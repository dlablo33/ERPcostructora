<?php
// app/Http/Controllers/ContratistaController.php

namespace App\Http\Controllers;

use App\Models\Contratista;
use App\Models\Proveedor;
use App\Models\AsignacionContratista;
use App\Models\GastoContratista;
use App\Models\PagoContratista;
use App\Models\HistorialPresupuestoContratista;
use App\Models\OrdenTrabajoContratista;
use App\Models\DocumentoContratista;
use App\Models\EvaluacionContratista;
use App\Models\AlertaContratista;
use App\Models\Proyecto;
use App\Models\ProyectoPartida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ContratistaController extends Controller
{
    // ============================================
    // SECCIÓN 0: VISTAS (WEB)
    // ============================================

    /**
     * Mostrar vista de listado de contratistas
     */
    public function indexContratistasView()
    {
        return view('proyectos.contratistas.index');
    }

    /**
     * Mostrar vista de detalle de contratista
     */
    public function showContratistaView($id)
    {
        return view('proyectos.contratistas.show', compact('id'));
    }

    /**
     * Mostrar vista de dashboard
     */
    public function dashboardView()
    {
        return view('proyectos.contratistas.dashboard');
    }

    /**
     * Mostrar vista de asignaciones
     */
    public function asignacionesView()
    {
        return view('proyectos.contratistas.asignaciones');
    }

    /**
     * Mostrar vista de gastos
     */
    public function gastosView()
    {
        return view('proyectos.contratistas.gastos');
    }

    /**
     * Mostrar vista de pagos
     */
    public function pagosView()
    {
        return view('proyectos.contratistas.pagos');
    }

    /**
     * Mostrar vista de creación
     */
    public function create()
    {
        return view('proyectos.contratistas.create');
    }

    /**
     * Mostrar vista de edición
     */
    public function edit($id)
    {
        return view('proyectos.contratistas.edit', compact('id'));
    }

    // ============================================
    // SECCIÓN 1: CONTRATISTAS (CRUD + Estadísticas)
    // ============================================

    /**
     * Listar contratistas (API)
     */
    public function indexContratistas(Request $request)
    {
        try {
            $query = Contratista::with(['proveedor', 'asignaciones']);

            // Filtros
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('codigo', 'LIKE', "%{$search}%")
                      ->orWhere('nombre_comercial', 'LIKE', "%{$search}%")
                      ->orWhere('especialidad', 'LIKE', "%{$search}%");
                });
            }

            if ($request->has('especialidad')) {
                $query->where('especialidad', $request->especialidad);
            }

            if ($request->has('nivel_riesgo')) {
                $query->where('nivel_riesgo', $request->nivel_riesgo);
            }

            if ($request->has('activo')) {
                $query->where('activo', $request->activo);
            }

            $sortField = $request->get('sort_field', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortField, $sortOrder);

            $contratistas = $query->paginate($request->get('per_page', 15));

            // Agregar estadísticas adicionales
            $contratistas->getCollection()->transform(function ($contratista) {
                $contratista->presupuesto_total = $contratista->presupuesto_total;
                $contratista->gasto_total = $contratista->gasto_total;
                $contratista->saldo_disponible = $contratista->saldo_disponible;
                $contratista->proyectos_activos = $contratista->proyectos_activos;
                return $contratista;
            });

            return response()->json($contratistas);

        } catch (\Exception $e) {
            Log::error('Error al listar contratistas: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al listar contratistas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear contratista (API)
     */
    public function storeContratista(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'codigo' => 'required|string|max:50|unique:contratistas,codigo',
            'nombre_comercial' => 'required|string|max:200',
            'especialidad' => 'required|string|max:100',
            'nivel_riesgo' => 'required|in:bajo,medio,alto',
            'registro_imss' => 'nullable|string|max:20',
            'licencia_obra' => 'nullable|string|max:50',
            'fecha_registro' => 'nullable|date',
            'activo' => 'nullable|boolean',
            'rfc' => 'nullable|string|max:13',
            'email' => 'nullable|email|max:100',
            'telefono' => 'nullable|string|max:20'
        ]);

        if ($validator->fails()) {
            Log::error('Error de validación:', $validator->errors()->toArray());
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Convertir el valor de 'activo' a booleano
            $activo = false;
            if ($request->has('activo')) {
                $activo = filter_var($request->activo, FILTER_VALIDATE_BOOLEAN);
            }

            // Si no hay proveedor_id, crear uno automáticamente
            if (!$request->proveedor_id) {
                $proveedor = Proveedor::create([
                    'nombre' => $request->nombre_comercial,
                    'rfc' => $request->rfc ?? null,
                    'email' => $request->email ?? null,
                    'telefono' => $request->telefono ?? null,
                    'activo' => true
                ]);
                $request->merge(['proveedor_id' => $proveedor->id]);
            }

            $contratista = Contratista::create([
                'proveedor_id' => $request->proveedor_id,
                'codigo' => $request->codigo,
                'nombre_comercial' => $request->nombre_comercial,
                'especialidad' => $request->especialidad,
                'nivel_riesgo' => $request->nivel_riesgo,
                'registro_imss' => $request->registro_imss,
                'licencia_obra' => $request->licencia_obra,
                'fecha_registro' => $request->fecha_registro ?? now(),
                'activo' => $activo,
            ]);

            // Procesar documentos si se subieron
            if ($request->hasFile('documento_contrato')) {
                $this->guardarDocumento($request->file('documento_contrato'), $contratista->id, 'contrato');
            }
            if ($request->hasFile('documento_identificacion')) {
                $this->guardarDocumento($request->file('documento_identificacion'), $contratista->id, 'identificacion');
            }
            if ($request->hasFile('documento_domicilio')) {
                $this->guardarDocumento($request->file('documento_domicilio'), $contratista->id, 'domicilio');
            }
            if ($request->hasFile('documento_seguro')) {
                $this->guardarDocumento($request->file('documento_seguro'), $contratista->id, 'seguro');
            }

            DB::commit();

            Log::info('Contratista creado exitosamente', ['id' => $contratista->id, 'codigo' => $contratista->codigo]);

            return response()->json([
                'message' => 'Contratista creado exitosamente',
                'data' => $contratista->load('proveedor')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear contratista:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'message' => 'Error al crear el contratista',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar contratista (API)
     */
    public function showContratista($id)
    {
        try {
            $contratista = Contratista::with([
                'proveedor',
                'asignaciones.proyecto',
                'asignaciones.partida',
                'gastos' => function($query) {
                    $query->orderBy('fecha_gasto', 'desc');
                },
                'documentos',
                'evaluaciones' => function($query) {
                    $query->orderBy('fecha_evaluacion', 'desc');
                }
            ])->findOrFail($id);

            $estadisticas = [
                'presupuesto_total' => $contratista->presupuesto_total,
                'gasto_total' => $contratista->gasto_total,
                'saldo_disponible' => $contratista->saldo_disponible,
                'proyectos_activos' => $contratista->proyectos_activos,
                'total_asignaciones' => $contratista->asignaciones->count(),
                'promedio_calificacion' => $contratista->calificacion,
                'ultima_evaluacion' => $contratista->evaluaciones->first()
            ];

            return response()->json([
                'contratista' => $contratista,
                'estadisticas' => $estadisticas
            ]);

        } catch (\Exception $e) {
            Log::error('Error al mostrar contratista: ' . $e->getMessage());
            return response()->json([
                'message' => 'Contratista no encontrado',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Actualizar contratista (API)
     */
    public function updateContratista(Request $request, $id)
    {
        $contratista = Contratista::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre_comercial' => 'sometimes|string|max:200',
            'especialidad' => 'sometimes|string|max:100',
            'nivel_riesgo' => 'sometimes|in:bajo,medio,alto',
            'calificacion' => 'sometimes|numeric|min:0|max:10',
            'registro_imss' => 'nullable|string|max:20',
            'licencia_obra' => 'nullable|string|max:50',
            'activo' => 'sometimes|boolean',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'rfc' => 'nullable|string|max:13',
            'email' => 'nullable|email|max:100',
            'telefono' => 'nullable|string|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Convertir activo a booleano si está presente
            if ($request->has('activo')) {
                $request->merge(['activo' => filter_var($request->activo, FILTER_VALIDATE_BOOLEAN)]);
            }

            $contratista->update($request->all());

            if ($request->has('proveedor_id') && $request->proveedor_id) {
                $proveedor = Proveedor::find($request->proveedor_id);
                if ($proveedor) {
                    $proveedor->update([
                        'nombre' => $request->nombre_comercial ?? $proveedor->nombre,
                        'rfc' => $request->rfc ?? $proveedor->rfc,
                        'email' => $request->email ?? $proveedor->email,
                        'telefono' => $request->telefono ?? $proveedor->telefono
                    ]);
                }
            }

            // Procesar nuevos documentos si se subieron
            if ($request->hasFile('documento_contrato')) {
                $this->guardarDocumento($request->file('documento_contrato'), $contratista->id, 'contrato');
            }
            if ($request->hasFile('documento_identificacion')) {
                $this->guardarDocumento($request->file('documento_identificacion'), $contratista->id, 'identificacion');
            }
            if ($request->hasFile('documento_domicilio')) {
                $this->guardarDocumento($request->file('documento_domicilio'), $contratista->id, 'domicilio');
            }
            if ($request->hasFile('documento_seguro')) {
                $this->guardarDocumento($request->file('documento_seguro'), $contratista->id, 'seguro');
            }

            DB::commit();

            return response()->json([
                'message' => 'Contratista actualizado exitosamente',
                'data' => $contratista->load('proveedor')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar contratista: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al actualizar el contratista',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar contratista (API)
     */
    public function destroyContratista($id)
    {
        $contratista = Contratista::findOrFail($id);

        if ($contratista->tieneAsignacionesActivas()) {
            return response()->json([
                'message' => 'No se puede eliminar el contratista porque tiene asignaciones activas'
            ], 400);
        }

        try {
            DB::beginTransaction();

            foreach ($contratista->documentos as $documento) {
                if ($documento->ruta_archivo && Storage::disk('public')->exists($documento->ruta_archivo)) {
                    Storage::disk('public')->delete($documento->ruta_archivo);
                }
            }

            $contratista->delete();

            DB::commit();

            return response()->json([
                'message' => 'Contratista eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar contratista: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al eliminar el contratista',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validar código único
     */
    public function validarCodigo(Request $request)
    {
        try {
            $existe = Contratista::where('codigo', $request->codigo)
                ->when($request->has('id'), function($query) use ($request) {
                    return $query->where('id', '!=', $request->id);
                })
                ->exists();
            return response()->json(['existe' => $existe]);

        } catch (\Exception $e) {
            Log::error('Error al validar código: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Obtener datos para gráficas
     */
    public function datosGraficas()
    {
        try {
            // Distribución por especialidad
            $especialidades = Contratista::select('especialidad', DB::raw('count(*) as total'))
                ->where('activo', true)
                ->groupBy('especialidad')
                ->get();

            // Gastos por tipo
            $gastosTipo = DB::table('gastos_contratista')
                ->select('tipo_gasto', DB::raw('sum(monto) as total'))
                ->groupBy('tipo_gasto')
                ->get();

            // Evolución mensual de contrataciones
            $contratacionesMensuales = Contratista::select(
                DB::raw('EXTRACT(YEAR FROM created_at) as year'),
                DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                DB::raw('count(*) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get()
            ->map(function($item) {
                $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                return [
                    'label' => $meses[(int)$item->month - 1] . ' ' . $item->year,
                    'total' => $item->total
                ];
            });

            // Distribución por nivel de riesgo
            $riesgo = Contratista::select('nivel_riesgo', DB::raw('count(*) as total'))
                ->groupBy('nivel_riesgo')
                ->get();

            return response()->json([
                'especialidades' => $especialidades,
                'gastos_tipo' => $gastosTipo,
                'contrataciones_mensuales' => $contratacionesMensuales,
                'riesgo' => $riesgo
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener datos para gráficas: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al obtener datos para gráficas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Top contratistas
     */
    public function topContratistas(Request $request)
    {
        $limit = $request->get('limit', 10);

        try {
            $contratistas = Contratista::withCount(['asignaciones' => function($query) {
                $query->whereIn('status', ['en_progreso', 'finalizado']);
            }])
            ->having('asignaciones_count', '>', 0)
            ->orderBy('asignaciones_count', 'desc')
            ->limit($limit)
            ->get();

            $result = $contratistas->map(function($contratista) {
                return [
                    'id' => $contratista->id,
                    'nombre_comercial' => $contratista->nombre_comercial,
                    'especialidad' => $contratista->especialidad,
                    'calificacion' => $contratista->calificacion,
                    'proyectos' => $contratista->asignaciones_count,
                    'presupuesto' => $contratista->presupuesto_total,
                    'gasto' => $contratista->gasto_total,
                    'avance' => $contratista->asignaciones()->avg('avance_porcentaje')
                ];
            });

            return response()->json($result);

        } catch (\Exception $e) {
            Log::error('Error al obtener top contratistas: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al obtener top contratistas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // SECCIÓN 2: ASIGNACIONES
    // ============================================

    /**
     * Listar asignaciones (API)
     */
    public function indexAsignaciones(Request $request)
    {
        try {
            $query = AsignacionContratista::with([
                'contratista.proveedor',
                'proyecto',
                'partida',
                'creador'
            ]);

            if ($request->has('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }

            if ($request->has('contratista_id')) {
                $query->where('contratista_id', $request->contratista_id);
            }

            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            if ($request->has('seccion')) {
                $query->where('seccion', 'LIKE', "%{$request->seccion}%");
            }

            if ($request->has('fecha_desde') && $request->has('fecha_hasta')) {
                $query->whereBetween('fecha_asignacion', [$request->fecha_desde, $request->fecha_hasta]);
            }

            if ($request->has('presupuesto_min')) {
                $query->where('presupuesto_asignado', '>=', $request->presupuesto_min);
            }
            if ($request->has('presupuesto_max')) {
                $query->where('presupuesto_asignado', '<=', $request->presupuesto_max);
            }

            $sortField = $request->get('sort_field', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortField, $sortOrder);

            $asignaciones = $query->paginate($request->get('per_page', 15));

            return response()->json($asignaciones);

        } catch (\Exception $e) {
            Log::error('Error al listar asignaciones: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al listar asignaciones',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear asignación (API)
     */
    public function storeAsignacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contratista_id' => 'required|exists:contratistas,id',
            'proyecto_id' => 'required|exists:proyectos,id',
            'partida_id' => 'nullable|exists:proyecto_partidas,id',
            'seccion' => 'nullable|string|max:100',
            'fecha_asignacion' => 'required|date',
            'fecha_inicio' => 'nullable|date|after_or_equal:fecha_asignacion',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'presupuesto_asignado' => 'required|numeric|min:0',
            'condiciones_pago' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $contratista = Contratista::findOrFail($request->contratista_id);
            if (!$contratista->activo) {
                return response()->json(['message' => 'El contratista no está activo'], 400);
            }

            $asignacion = AsignacionContratista::create([
                'contratista_id' => $request->contratista_id,
                'proyecto_id' => $request->proyecto_id,
                'partida_id' => $request->partida_id,
                'seccion' => $request->seccion,
                'fecha_asignacion' => $request->fecha_asignacion,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'presupuesto_asignado' => $request->presupuesto_asignado,
                'saldo_disponible' => $request->presupuesto_asignado,
                'status' => 'asignado',
                'condiciones_pago' => $request->condiciones_pago,
                'created_by' => auth()->id()
            ]);

            // Registrar en historial
            HistorialPresupuestoContratista::create([
                'asignacion_id' => $asignacion->id,
                'contratista_id' => $request->contratista_id,
                'presupuesto_nuevo' => $request->presupuesto_asignado,
                'gasto_acumulado' => 0,
                'motivo' => 'Asignación inicial',
                'realizado_por' => auth()->id()
            ]);

            // Crear alerta
            $this->crearAlerta(
                $request->contratista_id,
                $asignacion->id,
                'presupuesto',
                'Nueva asignación de proyecto',
                "Se ha asignado al contratista {$contratista->nombre_comercial} al proyecto con un presupuesto de $" . number_format($request->presupuesto_asignado, 2),
                'info'
            );

            DB::commit();

            return response()->json([
                'message' => 'Asignación creada exitosamente',
                'data' => $asignacion->load(['contratista', 'proyecto', 'partida'])
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear asignación: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al crear la asignación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar asignación (API)
     */
    public function showAsignacion($id)
    {
        try {
            $asignacion = AsignacionContratista::with([
                'contratista.proveedor',
                'proyecto',
                'partida',
                'gastos' => function($query) {
                    $query->orderBy('fecha_gasto', 'desc');
                },
                'ordenesTrabajo',
                'historialPresupuesto' => function($query) {
                    $query->orderBy('fecha_cambio', 'desc');
                },
                'pagos' => function($query) {
                    $query->orderBy('fecha_pago', 'desc');
                },
                'creador'
            ])->findOrFail($id);

            $estadisticas = [
                'total_gastos' => $asignacion->gastos->count(),
                'total_pagos' => $asignacion->pagos->count(),
                'total_ordenes' => $asignacion->ordenesTrabajo->count(),
                'gastos_por_tipo' => $asignacion->gastos->groupBy('tipo_gasto')->map(function($group) {
                    return $group->sum('monto');
                }),
                'presupuesto_restante' => $asignacion->presupuesto_restante,
                'porcentaje_gasto' => $asignacion->porcentaje_gasto,
                'dias_transcurridos' => $asignacion->dias_transcurridos
            ];

            return response()->json([
                'asignacion' => $asignacion,
                'estadisticas' => $estadisticas
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Asignación no encontrada',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Actualizar asignación (API)
     */
    public function updateAsignacion(Request $request, $id)
    {
        $asignacion = AsignacionContratista::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'presupuesto_asignado' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:asignado,en_progreso,pausado,finalizado,cancelado',
            'avance_porcentaje' => 'nullable|numeric|min:0|max:100',
            'condiciones_pago' => 'nullable|string',
            'motivo_cambio_presupuesto' => 'required_with:presupuesto_asignado|nullable|string',
            'seccion' => 'nullable|string|max:100',
            'partida_id' => 'nullable|exists:proyecto_partidas,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $oldPresupuesto = $asignacion->presupuesto_asignado;

            if ($request->has('presupuesto_asignado') && 
                $request->presupuesto_asignado != $oldPresupuesto) {
                
                HistorialPresupuestoContratista::create([
                    'asignacion_id' => $asignacion->id,
                    'contratista_id' => $asignacion->contratista_id,
                    'presupuesto_anterior' => $oldPresupuesto,
                    'presupuesto_nuevo' => $request->presupuesto_asignado,
                    'gasto_acumulado' => $asignacion->gasto_acumulado,
                    'motivo' => $request->motivo_cambio_presupuesto,
                    'realizado_por' => auth()->id()
                ]);

                $nuevoSaldo = $request->presupuesto_asignado - $asignacion->gasto_acumulado;
                $request->merge(['saldo_disponible' => max(0, $nuevoSaldo)]);

                $this->crearAlerta(
                    $asignacion->contratista_id,
                    $asignacion->id,
                    'presupuesto',
                    'Cambio en presupuesto asignado',
                    "El presupuesto cambió de $" . number_format($oldPresupuesto, 2) . " a $" . number_format($request->presupuesto_asignado, 2),
                    'warning'
                );
            }

            if ($request->has('status') && $request->status === 'finalizado') {
                $request->merge(['avance_porcentaje' => 100]);
                $asignacion->fecha_fin = now()->toDateString();

                $this->crearAlerta(
                    $asignacion->contratista_id,
                    $asignacion->id,
                    'evaluacion',
                    'Proyecto finalizado',
                    "El proyecto {$asignacion->proyecto->nombre} ha sido finalizado con un avance del 100%",
                    'info'
                );
            }

            $asignacion->update($request->all());

            if ($request->has('gasto_acumulado') || $request->has('presupuesto_asignado')) {
                $asignacion->calcularAvance();
            }

            DB::commit();

            return response()->json([
                'message' => 'Asignación actualizada exitosamente',
                'data' => $asignacion->load(['contratista', 'proyecto'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar asignación: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al actualizar la asignación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cambiar status de asignación (API)
     */
    public function cambiarStatusAsignacion(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:asignado,en_progreso,pausado,finalizado,cancelado',
            'motivo' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $asignacion = AsignacionContratista::findOrFail($id);
            $oldStatus = $asignacion->status;
            $asignacion->status = $request->status;

            if ($request->status == 'en_progreso' && !$asignacion->fecha_inicio) {
                $asignacion->fecha_inicio = now()->toDateString();
            }

            if ($request->status == 'finalizado') {
                $asignacion->fecha_fin = now()->toDateString();
                $asignacion->avance_porcentaje = 100;
            }

            $asignacion->save();

            $this->crearAlerta(
                $asignacion->contratista_id,
                $asignacion->id,
                'evaluacion',
                'Cambio de estado en asignación',
                "El estado cambió de '{$oldStatus}' a '{$request->status}'" . ($request->motivo ? " - Motivo: {$request->motivo}" : ""),
                'info'
            );

            return response()->json([
                'message' => 'Estado actualizado exitosamente',
                'data' => $asignacion
            ]);

        } catch (\Exception $e) {
            Log::error('Error al cambiar estado de asignación: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al cambiar el estado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar asignación (API)
     */
    public function destroyAsignacion($id)
    {
        $asignacion = AsignacionContratista::findOrFail($id);

        if ($asignacion->gastos()->count() > 0) {
            return response()->json([
                'message' => 'No se puede eliminar la asignación porque tiene gastos registrados'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $asignacion->historialPresupuesto()->delete();
            $asignacion->ordenesTrabajo()->delete();
            AlertaContratista::where('asignacion_id', $id)->delete();

            $asignacion->delete();

            DB::commit();

            return response()->json([
                'message' => 'Asignación eliminada exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar asignación: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al eliminar la asignación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // SECCIÓN 3: GASTOS
    // ============================================

    /**
     * Listar gastos (API)
     */
    public function indexGastos(Request $request)
    {
        try {
            $query = GastoContratista::with([
                'contratista',
                'asignacion.proyecto',
                'asignacion.partida',
                'creador'
            ]);

            if ($request->has('contratista_id')) {
                $query->where('contratista_id', $request->contratista_id);
            }

            if ($request->has('asignacion_id')) {
                $query->where('asignacion_id', $request->asignacion_id);
            }

            if ($request->has('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }

            if ($request->has('tipo_gasto')) {
                $query->where('tipo_gasto', $request->tipo_gasto);
            }

            if ($request->has('status_pago')) {
                $query->where('status_pago', $request->status_pago);
            }

            if ($request->has('fecha_desde') && $request->has('fecha_hasta')) {
                $query->whereBetween('fecha_gasto', [$request->fecha_desde, $request->fecha_hasta]);
            }

            if ($request->has('monto_min')) {
                $query->where('monto', '>=', $request->monto_min);
            }
            if ($request->has('monto_max')) {
                $query->where('monto', '<=', $request->monto_max);
            }

            $sortField = $request->get('sort_field', 'fecha_gasto');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortField, $sortOrder);

            $gastos = $query->paginate($request->get('per_page', 15));

            return response()->json($gastos);

        } catch (\Exception $e) {
            Log::error('Error al listar gastos: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al listar gastos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Registrar gasto (API)
     */
    public function storeGasto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'asignacion_id' => 'required|exists:asignaciones_contratistas,id',
            'tipo_gasto' => 'required|in:material,mano_obra,maquinaria,subcontrato,otros',
            'concepto' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'fecha_gasto' => 'required|date',
            'monto' => 'required|numeric|min:0.01',
            'factura' => 'nullable|string|max:50',
            'proveedor_externo' => 'nullable|string|max:200',
            'comprobante' => 'nullable|file|max:5120'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $asignacion = AsignacionContratista::findOrFail($request->asignacion_id);

            $nuevoGasto = $asignacion->gasto_acumulado + $request->monto;
            if ($nuevoGasto > $asignacion->presupuesto_asignado) {
                return response()->json([
                    'message' => 'El gasto excede el presupuesto disponible',
                    'disponible' => $asignacion->saldo_disponible
                ], 400);
            }

            $comprobantePath = null;
            if ($request->hasFile('comprobante')) {
                $file = $request->file('comprobante');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $comprobantePath = $file->storeAs('contratistas/gastos', $fileName, 'public');
            }

            $gasto = GastoContratista::create([
                'asignacion_id' => $request->asignacion_id,
                'contratista_id' => $asignacion->contratista_id,
                'proyecto_id' => $asignacion->proyecto_id,
                'tipo_gasto' => $request->tipo_gasto,
                'concepto' => $request->concepto,
                'descripcion' => $request->descripcion,
                'fecha_gasto' => $request->fecha_gasto,
                'monto' => $request->monto,
                'factura' => $request->factura,
                'proveedor_externo' => $request->proveedor_externo,
                'comprobante_path' => $comprobantePath,
                'created_by' => auth()->id()
            ]);

            $asignacion->gasto_acumulado += $request->monto;
            $asignacion->saldo_disponible = $asignacion->presupuesto_asignado - $asignacion->gasto_acumulado;
            $asignacion->calcularAvance();
            $asignacion->save();

            $porcentajeGasto = ($asignacion->gasto_acumulado / $asignacion->presupuesto_asignado) * 100;
            if ($porcentajeGasto >= 80) {
                $this->crearAlerta(
                    $asignacion->contratista_id,
                    $asignacion->id,
                    'presupuesto',
                    'Presupuesto próximo a agotarse',
                    "El presupuesto está al {$porcentajeGasto}% de uso. Gasto acumulado: $" . number_format($asignacion->gasto_acumulado, 2) . " de $" . number_format($asignacion->presupuesto_asignado, 2),
                    $porcentajeGasto >= 95 ? 'danger' : 'warning'
                );
            }

            DB::commit();

            return response()->json([
                'message' => 'Gasto registrado exitosamente',
                'data' => [
                    'gasto' => $gasto,
                    'asignacion' => $asignacion
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar gasto: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al registrar el gasto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar gasto (API)
     */
    public function showGasto($id)
    {
        try {
            $gasto = GastoContratista::with([
                'contratista.proveedor',
                'asignacion.proyecto',
                'asignacion.partida',
                'creador'
            ])->findOrFail($id);

            return response()->json($gasto);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gasto no encontrado',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Actualizar gasto (API)
     */
    public function updateGasto(Request $request, $id)
    {
        $gasto = GastoContratista::findOrFail($id);

        if ($gasto->status_pago === 'pagado') {
            return response()->json([
                'message' => 'No se puede actualizar un gasto que ya está pagado'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'concepto' => 'sometimes|string|max:200',
            'descripcion' => 'nullable|string',
            'fecha_gasto' => 'sometimes|date',
            'monto' => 'sometimes|numeric|min:0.01',
            'factura' => 'nullable|string|max:50',
            'proveedor_externo' => 'nullable|string|max:200'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            if ($request->has('monto') && $request->monto != $gasto->monto) {
                $asignacion = $gasto->asignacion;
                $diferencia = $request->monto - $gasto->monto;
                
                if ($asignacion->gasto_acumulado + $diferencia > $asignacion->presupuesto_asignado) {
                    return response()->json([
                        'message' => 'El nuevo monto excede el presupuesto disponible'
                    ], 400);
                }

                $asignacion->gasto_acumulado += $diferencia;
                $asignacion->saldo_disponible = $asignacion->presupuesto_asignado - $asignacion->gasto_acumulado;
                $asignacion->calcularAvance();
                $asignacion->save();
            }

            $gasto->update($request->all());

            DB::commit();

            return response()->json([
                'message' => 'Gasto actualizado exitosamente',
                'data' => $gasto
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar gasto: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al actualizar el gasto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar gasto (API)
     */
    public function destroyGasto($id)
    {
        $gasto = GastoContratista::findOrFail($id);

        if ($gasto->status_pago === 'pagado') {
            return response()->json([
                'message' => 'No se puede eliminar un gasto que ya está pagado'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $asignacion = $gasto->asignacion;
            $asignacion->gasto_acumulado -= $gasto->monto;
            $asignacion->saldo_disponible += $gasto->monto;
            $asignacion->calcularAvance();
            $asignacion->save();

            if ($gasto->comprobante_path && Storage::disk('public')->exists($gasto->comprobante_path)) {
                Storage::disk('public')->delete($gasto->comprobante_path);
            }

            $gasto->delete();

            DB::commit();

            return response()->json([
                'message' => 'Gasto eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar gasto: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al eliminar el gasto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Marcar gasto como pagado (API)
     */
    public function marcarGastoPagado(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fecha_pago' => 'required|date',
            'forma_pago' => 'required|in:transferencia,cheque,efectivo',
            'referencia' => 'nullable|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $gasto = GastoContratista::findOrFail($id);
            
            if ($gasto->status_pago === 'pagado') {
                return response()->json([
                    'message' => 'El gasto ya está pagado'
                ], 400);
            }

            $gasto->status_pago = 'pagado';
            $gasto->fecha_pago = $request->fecha_pago;
            $gasto->save();

            PagoContratista::create([
                'contratista_id' => $gasto->contratista_id,
                'asignacion_id' => $gasto->asignacion_id,
                'gasto_id' => $gasto->id,
                'folio' => PagoContratista::generarFolio(),
                'fecha_pago' => $request->fecha_pago,
                'monto' => $gasto->monto,
                'forma_pago' => $request->forma_pago,
                'referencia' => $request->referencia,
                'observaciones' => $request->observaciones,
                'created_by' => auth()->id()
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Gasto marcado como pagado exitosamente',
                'data' => $gasto
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al marcar gasto como pagado: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al marcar el gasto como pagado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Resumen de gastos por tipo (API)
     */
    public function resumenGastosPorTipo(Request $request)
    {
        try {
            $query = GastoContratista::select('tipo_gasto', DB::raw('count(*) as total_gastos'), DB::raw('sum(monto) as monto_total'));

            if ($request->has('contratista_id')) {
                $query->where('contratista_id', $request->contratista_id);
            }

            if ($request->has('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }

            if ($request->has('fecha_desde') && $request->has('fecha_hasta')) {
                $query->whereBetween('fecha_gasto', [$request->fecha_desde, $request->fecha_hasta]);
            }

            $result = $query->groupBy('tipo_gasto')->get();

            return response()->json($result);

        } catch (\Exception $e) {
            Log::error('Error al obtener resumen de gastos por tipo: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al obtener resumen de gastos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Descargar comprobante de gasto (API)
     */
    public function descargarComprobanteGasto($id)
    {
        try {
            $gasto = GastoContratista::findOrFail($id);
            
            if (!$gasto->comprobante_path) {
                return response()->json(['message' => 'El gasto no tiene comprobante'], 404);
            }

            if (!Storage::disk('public')->exists($gasto->comprobante_path)) {
                return response()->json(['message' => 'El archivo no existe'], 404);
            }

            return Storage::disk('public')->download($gasto->comprobante_path);

        } catch (\Exception $e) {
            Log::error('Error al descargar comprobante de gasto: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al descargar el comprobante',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // SECCIÓN 4: PAGOS
    // ============================================

    /**
     * Listar pagos (API)
     */
    public function indexPagos(Request $request)
    {
        try {
            $query = PagoContratista::with([
                'contratista',
                'asignacion.proyecto',
                'gasto',
                'creador'
            ]);

            if ($request->has('contratista_id')) {
                $query->where('contratista_id', $request->contratista_id);
            }

            if ($request->has('asignacion_id')) {
                $query->where('asignacion_id', $request->asignacion_id);
            }

            if ($request->has('forma_pago')) {
                $query->where('forma_pago', $request->forma_pago);
            }

            if ($request->has('fecha_desde') && $request->has('fecha_hasta')) {
                $query->whereBetween('fecha_pago', [$request->fecha_desde, $request->fecha_hasta]);
            }

            $sortField = $request->get('sort_field', 'fecha_pago');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortField, $sortOrder);

            $pagos = $query->paginate($request->get('per_page', 15));

            return response()->json($pagos);

        } catch (\Exception $e) {
            Log::error('Error al listar pagos: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al listar pagos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Registrar pago (API)
     */
    public function storePago(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contratista_id' => 'required|exists:contratistas,id',
            'asignacion_id' => 'required|exists:asignaciones_contratistas,id',
            'gasto_id' => 'nullable|exists:gastos_contratista,id',
            'fecha_pago' => 'required|date',
            'monto' => 'required|numeric|min:0.01',
            'forma_pago' => 'required|in:transferencia,cheque,efectivo',
            'referencia' => 'nullable|string|max:100',
            'comprobante' => 'nullable|file|max:5120',
            'observaciones' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $asignacion = AsignacionContratista::findOrFail($request->asignacion_id);

            if ($request->monto > $asignacion->gasto_acumulado) {
                return response()->json([
                    'message' => 'El monto del pago excede el gasto acumulado',
                    'gasto_acumulado' => $asignacion->gasto_acumulado
                ], 400);
            }

            $comprobantePath = null;
            if ($request->hasFile('comprobante')) {
                $file = $request->file('comprobante');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $comprobantePath = $file->storeAs('contratistas/pagos', $fileName, 'public');
            }

            $pago = PagoContratista::create([
                'contratista_id' => $request->contratista_id,
                'asignacion_id' => $request->asignacion_id,
                'gasto_id' => $request->gasto_id,
                'folio' => PagoContratista::generarFolio(),
                'fecha_pago' => $request->fecha_pago,
                'monto' => $request->monto,
                'forma_pago' => $request->forma_pago,
                'referencia' => $request->referencia,
                'comprobante_path' => $comprobantePath,
                'observaciones' => $request->observaciones,
                'created_by' => auth()->id()
            ]);

            if ($request->gasto_id) {
                $gasto = GastoContratista::find($request->gasto_id);
                if ($gasto && $gasto->status_pago !== 'pagado') {
                    $gasto->status_pago = 'pagado';
                    $gasto->fecha_pago = $request->fecha_pago;
                    $gasto->save();
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Pago registrado exitosamente',
                'data' => $pago->load(['contratista', 'asignacion', 'gasto'])
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar pago: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al registrar el pago',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar pago (API)
     */
    public function showPago($id)
    {
        try {
            $pago = PagoContratista::with([
                'contratista.proveedor',
                'asignacion.proyecto',
                'gasto',
                'creador'
            ])->findOrFail($id);

            return response()->json($pago);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Pago no encontrado',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Eliminar pago (API)
     */
    public function destroyPago($id)
    {
        try {
            DB::beginTransaction();

            $pago = PagoContratista::findOrFail($id);

            if ($pago->gasto_id) {
                $gasto = GastoContratista::find($pago->gasto_id);
                if ($gasto && $gasto->status_pago === 'pagado') {
                    $gasto->status_pago = 'pendiente';
                    $gasto->fecha_pago = null;
                    $gasto->save();
                }
            }

            if ($pago->comprobante_path && Storage::disk('public')->exists($pago->comprobante_path)) {
                Storage::disk('public')->delete($pago->comprobante_path);
            }

            $pago->delete();

            DB::commit();

            return response()->json([
                'message' => 'Pago eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar pago: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al eliminar el pago',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Resumen de pagos (API)
     */
    public function resumenPagos(Request $request)
    {
        try {
            $query = PagoContratista::select(
                DB::raw('EXTRACT(YEAR FROM fecha_pago) as year'),
                DB::raw('EXTRACT(MONTH FROM fecha_pago) as month'),
                DB::raw('count(*) as total_pagos'),
                DB::raw('sum(monto) as monto_total')
            );

            if ($request->has('contratista_id')) {
                $query->where('contratista_id', $request->contratista_id);
            }

            if ($request->has('year')) {
                $query->whereYear('fecha_pago', $request->year);
            }

            $result = $query->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get()
                ->map(function($item) {
                    $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                    return [
                        'label' => $meses[(int)$item->month - 1] . ' ' . $item->year,
                        'total_pagos' => $item->total_pagos,
                        'monto_total' => $item->monto_total
                    ];
                });

            return response()->json($result);

        } catch (\Exception $e) {
            Log::error('Error al obtener resumen de pagos: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al obtener resumen de pagos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Descargar comprobante de pago (API)
     */
    public function descargarComprobantePago($id)
    {
        try {
            $pago = PagoContratista::findOrFail($id);
            
            if (!$pago->comprobante_path) {
                return response()->json(['message' => 'El pago no tiene comprobante'], 404);
            }

            if (!Storage::disk('public')->exists($pago->comprobante_path)) {
                return response()->json(['message' => 'El archivo no existe'], 404);
            }

            return Storage::disk('public')->download($pago->comprobante_path);

        } catch (\Exception $e) {
            Log::error('Error al descargar comprobante de pago: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al descargar el comprobante',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // SECCIÓN 5: DASHBOARD Y ESTADÍSTICAS
    // ============================================

    /**
     * Dashboard principal (API)
     */
    public function dashboard(Request $request)
    {
        try {
            $kpis = [
                'total_contratistas' => Contratista::count(),
                'activos' => Contratista::where('activo', true)->count(),
                'inactivos' => Contratista::where('activo', false)->count(),
                'total_proyectos' => AsignacionContratista::distinct('proyecto_id')->count(),
                'total_asignaciones' => AsignacionContratista::count(),
                'presupuesto_total' => AsignacionContratista::sum('presupuesto_asignado'),
                'gasto_total' => AsignacionContratista::sum('gasto_acumulado'),
                'saldo_total' => AsignacionContratista::sum('saldo_disponible')
            ];

            $asignacionesStatus = AsignacionContratista::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get();

            $gastosTipo = GastoContratista::select('tipo_gasto', DB::raw('sum(monto) as total'))
                ->groupBy('tipo_gasto')
                ->get();

            $especialidades = Contratista::select('especialidad', DB::raw('count(*) as total'))
                ->where('activo', true)
                ->groupBy('especialidad')
                ->get();

            $alertasNoLeidas = AlertaContratista::noLeidas()->count();

            $proyectosActivos = AsignacionContratista::select(
                'proyecto_id',
                DB::raw('count(*) as total_asignaciones'),
                DB::raw('sum(presupuesto_asignado) as total_presupuesto')
            )
            ->whereIn('status', ['asignado', 'en_progreso'])
            ->groupBy('proyecto_id')
            ->with('proyecto')
            ->orderBy('total_asignaciones', 'desc')
            ->limit(5)
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->proyecto_id,
                    'nombre' => $item->proyecto->nombre ?? 'N/A',
                    'total_asignaciones' => $item->total_asignaciones,
                    'total_presupuesto' => $item->total_presupuesto
                ];
            });

            $gastosMensuales = GastoContratista::select(
                DB::raw('TO_CHAR(fecha_gasto, \'YYYY-MM\') as mes'),
                DB::raw('sum(monto) as total')
            )
            ->where('fecha_gasto', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get();

            $topContratistas = Contratista::select(
                'contratistas.id',
                'contratistas.nombre_comercial',
                'contratistas.especialidad',
                DB::raw('sum(gastos_contratista.monto) as total_gasto')
            )
            ->leftJoin('gastos_contratista', 'contratistas.id', '=', 'gastos_contratista.contratista_id')
            ->where('contratistas.activo', true)
            ->groupBy('contratistas.id', 'contratistas.nombre_comercial', 'contratistas.especialidad')
            ->orderBy('total_gasto', 'desc')
            ->limit(5)
            ->get();

            return response()->json([
                'kpis' => $kpis,
                'asignaciones_status' => $asignacionesStatus,
                'gastos_tipo' => $gastosTipo,
                'especialidades' => $especialidades,
                'alertas_no_leidas' => $alertasNoLeidas,
                'proyectos_activos' => $proyectosActivos,
                'gastos_mensuales' => $gastosMensuales,
                'top_contratistas' => $topContratistas
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener datos del dashboard: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al obtener datos del dashboard',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Estadísticas globales (API)
     */
    public function estadisticasGlobales()
    {
        try {
            $estadisticas = [
                'total' => Contratista::count(),
                'activos' => Contratista::where('activo', true)->count(),
                'inactivos' => Contratista::where('activo', false)->count(),
                'total_proyectos' => AsignacionContratista::distinct('proyecto_id')->count(),
                'presupuesto_total' => AsignacionContratista::sum('presupuesto_asignado'),
                'gasto_total' => AsignacionContratista::sum('gasto_acumulado'),
                'saldo_total' => AsignacionContratista::sum('saldo_disponible'),
                'por_especialidad' => Contratista::select('especialidad', DB::raw('count(*) as total'))
                    ->where('activo', true)
                    ->groupBy('especialidad')
                    ->get(),
                'por_riesgo' => Contratista::select('nivel_riesgo', DB::raw('count(*) as total'))
                    ->groupBy('nivel_riesgo')
                    ->get(),
                'promedio_calificacion' => Contratista::where('calificacion', '>', 0)->avg('calificacion')
            ];

            return response()->json($estadisticas);

        } catch (\Exception $e) {
            Log::error('Error al obtener estadísticas globales: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al obtener estadísticas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // SECCIÓN 6: ALERTAS
    // ============================================

    /**
     * Listar alertas (API)
     */
    public function indexAlertas(Request $request)
    {
        try {
            $query = AlertaContratista::with(['contratista', 'asignacion'])
                ->orderBy('created_at', 'desc');

            if ($request->has('leida')) {
                $query->where('leida', $request->leida);
            }

            if ($request->has('nivel')) {
                $query->where('nivel', $request->nivel);
            }

            if ($request->has('contratista_id')) {
                $query->where('contratista_id', $request->contratista_id);
            }

            $alertas = $query->paginate($request->get('per_page', 20));

            return response()->json($alertas);

        } catch (\Exception $e) {
            Log::error('Error al listar alertas: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al listar alertas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Marcar alerta como leída (API)
     */
    public function marcarAlertaLeida($id)
    {
        try {
            $alerta = AlertaContratista::findOrFail($id);
            $alerta->marcarComoLeida();

            return response()->json([
                'message' => 'Alerta marcada como leída',
                'data' => $alerta
            ]);

        } catch (\Exception $e) {
            Log::error('Error al marcar alerta como leída: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al marcar alerta como leída',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Marcar todas las alertas como leídas (API)
     */
    public function marcarTodasAlertasLeidas()
    {
        try {
            AlertaContratista::noLeidas()->update(['leida' => true]);

            return response()->json([
                'message' => 'Todas las alertas marcadas como leídas'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al marcar todas las alertas como leídas: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al marcar alertas como leídas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // SECCIÓN 7: CATÁLOGOS Y UTILIDADES
    // ============================================

    /**
     * Obtener proyectos disponibles (API)
     */
    public function proyectosDisponibles()
    {
        try {
            $proyectos = Proyecto::where('status', 'activo')
                ->select('id', 'codigo', 'nombre', 'presupuesto_total')
                ->orderBy('codigo')
                ->get();

            return response()->json($proyectos);

        } catch (\Exception $e) {
            Log::error('Error al obtener proyectos disponibles: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al obtener proyectos disponibles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener partidas de un proyecto (API)
     */
    public function partidasProyecto($proyectoId)
    {
        try {
            $partidas = ProyectoPartida::where('proyecto_id', $proyectoId)
                ->where('activa', true)
                ->select('id', 'codigo', 'nombre', 'categoria', 'importe', 'unidad')
                ->orderBy('orden')
                ->get();

            return response()->json($partidas);

        } catch (\Exception $e) {
            Log::error('Error al obtener partidas del proyecto: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al obtener partidas del proyecto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener resumen por proyecto (API)
     */
    public function resumenProyecto($proyectoId)
    {
        try {
            $proyecto = Proyecto::findOrFail($proyectoId);
            
            $asignaciones = AsignacionContratista::with('contratista')
                ->where('proyecto_id', $proyectoId)
                ->get();

            $resumen = [
                'proyecto' => [
                    'id' => $proyecto->id,
                    'nombre' => $proyecto->nombre,
                    'codigo' => $proyecto->codigo
                ],
                'total_contratistas' => $asignaciones->count(),
                'presupuesto_total' => $asignaciones->sum('presupuesto_asignado'),
                'gasto_total' => $asignaciones->sum('gasto_acumulado'),
                'saldo_total' => $asignaciones->sum('saldo_disponible'),
                'avance_promedio' => $asignaciones->avg('avance_porcentaje'),
                'status_distribution' => $asignaciones->groupBy('status')->map(function($group) {
                    return [
                        'count' => $group->count(),
                        'presupuesto' => $group->sum('presupuesto_asignado'),
                        'gasto' => $group->sum('gasto_acumulado')
                    ];
                }),
                'detalle' => $asignaciones->map(function($asignacion) {
                    return [
                        'id' => $asignacion->id,
                        'contratista' => $asignacion->contratista->nombre_comercial,
                        'contratista_id' => $asignacion->contratista_id,
                        'seccion' => $asignacion->seccion,
                        'presupuesto' => $asignacion->presupuesto_asignado,
                        'gasto' => $asignacion->gasto_acumulado,
                        'saldo' => $asignacion->saldo_disponible,
                        'avance' => $asignacion->avance_porcentaje,
                        'status' => $asignacion->status,
                        'fecha_inicio' => $asignacion->fecha_inicio,
                        'fecha_fin' => $asignacion->fecha_fin
                    ];
                })
            ];

            return response()->json($resumen);

        } catch (\Exception $e) {
            Log::error('Error al obtener resumen del proyecto: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al obtener resumen del proyecto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // SECCIÓN 8: DOCUMENTOS
    // ============================================

    /**
     * Guardar documento (privado)
     */
    private function guardarDocumento($file, $contratistaId, $tipo)
    {
        try {
            $nombreOriginal = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $nombreUnico = time() . '_' . uniqid() . '.' . $extension;
            $ruta = $file->storeAs('contratistas/documentos/' . $contratistaId, $nombreUnico, 'public');

            DocumentoContratista::create([
                'contratista_id' => $contratistaId,
                'tipo_documento' => $tipo,
                'nombre_original' => $nombreOriginal,
                'ruta_archivo' => $ruta,
                'fecha_subida' => now(),
                'subido_por' => auth()->id()
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error al guardar documento: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener documentos del contratista (API)
     */
    public function getDocumentos($id)
    {
        try {
            $documentos = DocumentoContratista::where('contratista_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($documentos);

        } catch (\Exception $e) {
            Log::error('Error al obtener documentos: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al obtener documentos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar documento (API)
     */
    public function eliminarDocumento($id)
    {
        try {
            $documento = DocumentoContratista::findOrFail($id);
            
            if ($documento->ruta_archivo && Storage::disk('public')->exists($documento->ruta_archivo)) {
                Storage::disk('public')->delete($documento->ruta_archivo);
            }
            
            $documento->delete();

            return response()->json([
                'message' => 'Documento eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al eliminar documento: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al eliminar el documento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Descargar documento (API)
     */
    public function descargarDocumento($id)
    {
        try {
            $documento = DocumentoContratista::findOrFail($id);
            
            if (!$documento->ruta_archivo || !Storage::disk('public')->exists($documento->ruta_archivo)) {
                return response()->json([
                    'message' => 'El archivo no existe'
                ], 404);
            }

            return Storage::disk('public')->download($documento->ruta_archivo, $documento->nombre_original);

        } catch (\Exception $e) {
            Log::error('Error al descargar documento: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al descargar el documento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // SECCIÓN 9: MÉTODOS PRIVADOS
    // ============================================

    /**
     * Crear alerta (privado)
     */
    private function crearAlerta($contratistaId, $asignacionId, $tipo, $titulo, $descripcion, $nivel = 'info')
    {
        try {
            return AlertaContratista::create([
                'contratista_id' => $contratistaId,
                'asignacion_id' => $asignacionId,
                'tipo' => $tipo,
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'nivel' => $nivel,
                'generada_por' => auth()->id()
            ]);
        } catch (\Exception $e) {
            Log::error('Error al crear alerta: ' . $e->getMessage());
            return null;
        }
    }
}