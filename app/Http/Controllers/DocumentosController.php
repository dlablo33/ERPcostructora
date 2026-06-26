<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Plano;
use App\Models\DocumentoVersion;
use App\Models\CategoriaDocumento;
use App\Models\Proyecto;
use App\Models\Proveedor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentosController extends Controller
{
    /**
     * Muestra la vista de Contratos y Planos
     */
    public function index()
    {
        // Obtener proyectos activos para los selectores
        $proyectos = Proyecto::where('status', 'activo')
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'codigo']);
        
        // Obtener clientes para contratos
        $clientes = DB::table('contactos')
            ->where('estatus', true)
            ->where(function($q) {
                $q->where('tipo', 'cliente')->orWhere('tipo', 'ambos');
            })
            ->orderBy('razon_social')
            ->get(['contacto_id', 'razon_social', 'rfc']);
        
        // Obtener proveedores
        $proveedores = Proveedor::where('activo', true)
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'rfc']);
        
        // Obtener responsables (usuarios)
        $responsables = User::orderBy('name')
            ->get(['id', 'name']);
        
        // Obtener categorías de documentos
        $categorias = CategoriaDocumento::where('activo', true)
            ->orderBy('orden')
            ->get();
        
        return view('proyectos.documentacion.planos', compact(
            'proyectos', 
            'clientes', 
            'proveedores', 
            'responsables',
            'categorias'
        ));
    }

    /**
     * Obtener resumen de KPIs (4 cuadros principales)
     */
    public function resumen(Request $request)
    {
        try {
            $queryContratos = Contrato::query();
            $queryPlanos = Plano::query();
            
            // Aplicar filtro de proyecto
            if ($request->has('proyecto_id') && $request->proyecto_id) {
                $queryContratos->where('proyecto_id', $request->proyecto_id);
                $queryPlanos->where('proyecto_id', $request->proyecto_id);
            }
            
            // Aplicar filtro de fechas
            if ($request->has('fecha_inicio') && $request->fecha_inicio) {
                $queryContratos->where('fecha_firma', '>=', $request->fecha_inicio);
                $queryPlanos->where('fecha', '>=', $request->fecha_inicio);
            }
            
            if ($request->has('fecha_fin') && $request->fecha_fin) {
                $queryContratos->where('fecha_firma', '<=', $request->fecha_fin);
                $queryPlanos->where('fecha', '<=', $request->fecha_fin);
            }
            
            $totalContratos = $queryContratos->count();
            $totalPlanos = $queryPlanos->count();
            $contratosVigentes = (clone $queryContratos)->where('estado', 'Vigente')->count();
            $planosAprobados = (clone $queryPlanos)->where('estado', 'Aprobado')->count();
            
            return response()->json([
                'total_contratos' => $totalContratos,
                'total_planos' => $totalPlanos,
                'contratos_vigentes' => $contratosVigentes,
                'planos_aprobados' => $planosAprobados
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en resumen documentos: ' . $e->getMessage());
            return response()->json([
                'total_contratos' => 0,
                'total_planos' => 0,
                'contratos_vigentes' => 0,
                'planos_aprobados' => 0
            ]);
        }
    }

    /**
     * Obtener lista de contratos con paginación y filtros
     */
    public function contratos(Request $request)
    {
        try {
            $query = Contrato::with(['proyecto', 'creador']);
            
            // Filtros
            if ($request->has('proyecto_id') && $request->proyecto_id) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            if ($request->has('estado') && $request->estado) {
                $query->where('estado', $request->estado);
            }
            
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('no_contrato', 'LIKE', "%{$search}%")
                      ->orWhere('descripcion', 'LIKE', "%{$search}%")
                      ->orWhere('responsable_contratante', 'LIKE', "%{$search}%")
                      ->orWhere('responsable_contratista', 'LIKE', "%{$search}%")
                      ->orWhereHas('proyecto', function($sub) use ($search) {
                          $sub->where('nombre', 'LIKE', "%{$search}%")
                              ->orWhere('codigo', 'LIKE', "%{$search}%");
                      });
                });
            }
            
            // Ordenar
            $sortField = $request->sort_by ?? 'fecha_firma';
            $sortOrder = $request->sort_order ?? 'desc';
            $query->orderBy($sortField, $sortOrder);
            
            $perPage = $request->per_page ?? 10;
            $contratos = $query->paginate($perPage);
            
            $datos = $contratos->map(function($contrato) {
                // Obtener cliente desde la tabla contactos
                $cliente = null;
                if ($contrato->cliente_id) {
                    $cliente = DB::table('contactos')
                        ->where('contacto_id', $contrato->cliente_id)
                        ->first();
                }
                
                return [
                    'id' => $contrato->id,
                    'no_contrato' => $contrato->no_contrato,
                    'proyecto' => $contrato->proyecto->nombre ?? 'Sin proyecto',
                    'proyecto_codigo' => $contrato->proyecto->codigo ?? '',
                    'cliente' => $cliente->razon_social ?? 'N/A',
                    'cliente_rfc' => $cliente->rfc ?? '',
                    'fecha_firma' => $contrato->fecha_firma ? $contrato->fecha_firma->format('d/m/Y') : 'N/A',
                    'fecha_inicio' => $contrato->fecha_inicio ? $contrato->fecha_inicio->format('d/m/Y') : 'N/A',
                    'fecha_fin' => $contrato->fecha_fin ? $contrato->fecha_fin->format('d/m/Y') : 'N/A',
                    'monto_total' => $contrato->monto_total,
                    'monto_formateado' => '$' . number_format($contrato->monto_total, 0),
                    'estado' => $contrato->estado,
                    'version' => $contrato->version,
                    'tiene_documento' => !empty($contrato->documento_path),
                    'documento_nombre' => $contrato->documento_nombre,
                    'responsable_contratante' => $contrato->responsable_contratante,
                    'responsable_contratista' => $contrato->responsable_contratista,
                    'dias_restantes' => $contrato->dias_restantes,
                    'created_at' => $contrato->created_at ? $contrato->created_at->format('d/m/Y H:i') : 'N/A'
                ];
            });
            
            return response()->json([
                'data' => $datos,
                'pagination' => [
                    'total' => $contratos->total(),
                    'per_page' => $contratos->perPage(),
                    'current_page' => $contratos->currentPage(),
                    'last_page' => $contratos->lastPage()
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en contratos: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'pagination' => [
                    'total' => 0,
                    'per_page' => 10,
                    'current_page' => 1,
                    'last_page' => 1
                ]
            ]);
        }
    }

    /**
     * Obtener detalle de un contrato específico
     */
    public function contratoDetalle($id)
    {
        try {
            $contrato = Contrato::with(['proyecto', 'creador'])->findOrFail($id);
            
            // Obtener cliente
            $cliente = null;
            if ($contrato->cliente_id) {
                $cliente = DB::table('contactos')
                    ->where('contacto_id', $contrato->cliente_id)
                    ->first();
            }
            
            return response()->json([
                'id' => $contrato->id,
                'no_contrato' => $contrato->no_contrato,
                'proyecto' => $contrato->proyecto->nombre ?? 'Sin proyecto',
                'proyecto_id' => $contrato->proyecto_id,
                'cliente' => $cliente->razon_social ?? 'N/A',
                'cliente_id' => $contrato->cliente_id,
                'cliente_rfc' => $cliente->rfc ?? '',
                'fecha_firma' => $contrato->fecha_firma ? $contrato->fecha_firma->format('d/m/Y') : 'N/A',
                'fecha_inicio' => $contrato->fecha_inicio ? $contrato->fecha_inicio->format('d/m/Y') : 'N/A',
                'fecha_fin' => $contrato->fecha_fin ? $contrato->fecha_fin->format('d/m/Y') : 'N/A',
                'monto_total' => $contrato->monto_total,
                'monto_formateado' => '$' . number_format($contrato->monto_total, 2),
                'anticipo_porcentaje' => $contrato->anticipo_porcentaje,
                'anticipo_monto' => $contrato->anticipo_monto,
                'anticipo_formateado' => '$' . number_format($contrato->anticipo_monto, 2),
                'saldo_restante' => $contrato->saldo_restante,
                'saldo_formateado' => '$' . number_format($contrato->saldo_restante, 2),
                'estado' => $contrato->estado,
                'version' => $contrato->version,
                'descripcion' => $contrato->descripcion,
                'forma_pago' => $contrato->forma_pago,
                'plazo_pago' => $contrato->plazo_pago,
                'penalizaciones' => $contrato->penalizaciones,
                'garantias' => $contrato->garantias,
                'responsable_contratante' => $contrato->responsable_contratante,
                'cargo_contratante' => $contrato->cargo_contratante,
                'email_contratante' => $contrato->email_contratante,
                'rfc_cliente' => $contrato->rfc_cliente,
                'responsable_contratista' => $contrato->responsable_contratista,
                'cargo_contratista' => $contrato->cargo_contratista,
                'email_contratista' => $contrato->email_contratista,
                'documento_path' => $contrato->documento_path,
                'documento_nombre' => $contrato->documento_nombre,
                'dias_restantes' => $contrato->dias_restantes,
                'created_by' => $contrato->creador->name ?? 'N/A',
                'created_at' => $contrato->created_at ? $contrato->created_at->format('d/m/Y H:i') : 'N/A',
                'updated_at' => $contrato->updated_at ? $contrato->updated_at->format('d/m/Y H:i') : 'N/A'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en contratoDetalle: ' . $e->getMessage());
            return response()->json([
                'error' => 'Contrato no encontrado'
            ], 404);
        }
    }

    /**
     * Obtener lista de planos con paginación y filtros
     */
    public function planos(Request $request)
    {
        try {
            $query = Plano::with(['proyecto', 'creador']);
            
            // Filtros
            if ($request->has('proyecto_id') && $request->proyecto_id) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            if ($request->has('disciplina') && $request->disciplina) {
                $query->where('disciplina', $request->disciplina);
            }
            
            if ($request->has('estado') && $request->estado) {
                $query->where('estado', $request->estado);
            }
            
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('no_plano', 'LIKE', "%{$search}%")
                      ->orWhere('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('descripcion', 'LIKE', "%{$search}%")
                      ->orWhere('disciplina', 'LIKE', "%{$search}%")
                      ->orWhereHas('proyecto', function($sub) use ($search) {
                          $sub->where('nombre', 'LIKE', "%{$search}%")
                              ->orWhere('codigo', 'LIKE', "%{$search}%");
                      });
                });
            }
            
            // Ordenar
            $sortField = $request->sort_by ?? 'fecha';
            $sortOrder = $request->sort_order ?? 'desc';
            $query->orderBy($sortField, $sortOrder);
            
            $perPage = $request->per_page ?? 12;
            $planos = $query->paginate($perPage);
            
            $datos = $planos->map(function($plano) {
                return [
                    'id' => $plano->id,
                    'no_plano' => $plano->no_plano,
                    'nombre' => $plano->nombre,
                    'proyecto' => $plano->proyecto->nombre ?? 'Sin proyecto',
                    'proyecto_id' => $plano->proyecto_id,
                    'disciplina' => $plano->disciplina,
                    'subdisciplina' => $plano->subdisciplina,
                    'revision' => $plano->revision,
                    'estado' => $plano->estado,
                    'fecha' => $plano->fecha ? $plano->fecha->format('d/m/Y') : 'N/A',
                    'fecha_aprobacion' => $plano->fecha_aprobacion ? $plano->fecha_aprobacion->format('d/m/Y') : 'N/A',
                    'formato' => $plano->formato,
                    'escala' => $plano->escala,
                    'tamanio_formateado' => $plano->tamanio_formateado,
                    'descripcion' => $plano->descripcion,
                    'tiene_documento' => !empty($plano->documento_path),
                    'documento_nombre' => $plano->documento_nombre,
                    'tiene_miniatura' => !empty($plano->miniatura_path),
                    'creador' => $plano->creador->name ?? 'N/A',
                    'created_at' => $plano->created_at ? $plano->created_at->format('d/m/Y H:i') : 'N/A'
                ];
            });
            
            return response()->json([
                'data' => $datos,
                'pagination' => [
                    'total' => $planos->total(),
                    'per_page' => $planos->perPage(),
                    'current_page' => $planos->currentPage(),
                    'last_page' => $planos->lastPage()
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en planos: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'pagination' => [
                    'total' => 0,
                    'per_page' => 12,
                    'current_page' => 1,
                    'last_page' => 1
                ]
            ]);
        }
    }

    /**
     * Obtener detalle de un plano específico
     */
    public function planoDetalle($id)
    {
        try {
            $plano = Plano::with(['proyecto', 'creador'])->findOrFail($id);
            
            return response()->json([
                'id' => $plano->id,
                'no_plano' => $plano->no_plano,
                'nombre' => $plano->nombre,
                'proyecto' => $plano->proyecto->nombre ?? 'Sin proyecto',
                'proyecto_id' => $plano->proyecto_id,
                'disciplina' => $plano->disciplina,
                'subdisciplina' => $plano->subdisciplina,
                'revision' => $plano->revision,
                'estado' => $plano->estado,
                'fecha' => $plano->fecha ? $plano->fecha->format('d/m/Y') : 'N/A',
                'fecha_aprobacion' => $plano->fecha_aprobacion ? $plano->fecha_aprobacion->format('d/m/Y') : 'N/A',
                'formato' => $plano->formato,
                'escala' => $plano->escala,
                'tamanio_bytes' => $plano->tamanio_bytes,
                'tamanio_formateado' => $plano->tamanio_formateado,
                'descripcion' => $plano->descripcion,
                'documento_path' => $plano->documento_path,
                'documento_nombre' => $plano->documento_nombre,
                'miniatura_path' => $plano->miniatura_path,
                'creador' => $plano->creador->name ?? 'N/A',
                'created_at' => $plano->created_at ? $plano->created_at->format('d/m/Y H:i') : 'N/A',
                'updated_at' => $plano->updated_at ? $plano->updated_at->format('d/m/Y H:i') : 'N/A'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en planoDetalle: ' . $e->getMessage());
            return response()->json([
                'error' => 'Plano no encontrado'
            ], 404);
        }
    }

    /**
     * Obtener historial de versiones de un documento
     */
    public function historialVersiones(Request $request)
    {
        try {
            $tipo = $request->tipo; // 'contrato' o 'plano'
            $id = $request->id;
            
            if (!$tipo || !$id) {
                return response()->json([
                    'error' => 'Tipo e ID son requeridos'
                ], 400);
            }
            
            $versiones = DocumentoVersion::with(['usuario', 'creador'])
                ->where('documento_tipo', $tipo)
                ->where('documento_id', $id)
                ->orderBy('fecha_version', 'desc')
                ->get();
            
            $datos = $versiones->map(function($version) {
                return [
                    'id' => $version->id,
                    'version' => $version->version,
                    'nombre_version' => $version->nombre_version,
                    'fecha_version' => $version->fecha_version ? $version->fecha_version->format('d/m/Y H:i') : 'N/A',
                    'usuario' => $version->usuario->name ?? 'N/A',
                    'cambios' => $version->cambios,
                    'documento_path' => $version->documento_path,
                    'documento_nombre' => $version->documento_nombre,
                    'tamanio_formateado' => $version->tamanio_formateado,
                    'es_actual' => $version->es_actual
                ];
            });
            
            return response()->json([
                'data' => $datos,
                'total' => $versiones->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en historialVersiones: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'total' => 0
            ]);
        }
    }

    /**
     * Crear un nuevo contrato
     */
    public function storeContrato(Request $request)
    {
        try {
            $validated = $request->validate([
                'proyecto_id' => 'required|exists:proyectos,id',
                'cliente_id' => 'nullable|exists:contactos,contacto_id',
                'proveedor_id' => 'nullable|exists:proveedores,id',
                'fecha_firma' => 'required|date',
                'fecha_inicio' => 'required|date|after_or_equal:fecha_firma',
                'fecha_fin' => 'required|date|after:fecha_inicio',
                'monto_total' => 'required|numeric|min:0',
                'anticipo_porcentaje' => 'nullable|numeric|min:0|max:100',
                'estado' => 'required|in:Vigente,En Revisión,Vencido',
                'descripcion' => 'nullable|string',
                'forma_pago' => 'nullable|string|max:100',
                'plazo_pago' => 'nullable|string|max:100',
                'responsable_contratante' => 'nullable|string|max:100',
                'cargo_contratante' => 'nullable|string|max:100',
                'email_contratante' => 'nullable|email|max:100',
                'rfc_cliente' => 'nullable|string|max:20',
                'responsable_contratista' => 'nullable|string|max:100',
                'cargo_contratista' => 'nullable|string|max:100',
                'email_contratista' => 'nullable|email|max:100'
            ]);
            
            // Calcular anticipo y saldo
            $validated['anticipo_monto'] = ($validated['monto_total'] * ($validated['anticipo_porcentaje'] ?? 0)) / 100;
            $validated['saldo_restante'] = $validated['monto_total'] - $validated['anticipo_monto'];
            $validated['version'] = 'v1.0';
            $validated['created_by'] = auth()->id();
            
            $contrato = Contrato::create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Contrato creado correctamente',
                'data' => $contrato
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al crear contrato: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el contrato: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un contrato
     */
    public function updateContrato($id, Request $request)
    {
        try {
            $contrato = Contrato::findOrFail($id);
            
            $validated = $request->validate([
                'proyecto_id' => 'sometimes|exists:proyectos,id',
                'cliente_id' => 'nullable|exists:contactos,contacto_id',
                'proveedor_id' => 'nullable|exists:proveedores,id',
                'fecha_firma' => 'sometimes|date',
                'fecha_inicio' => 'sometimes|date|after_or_equal:fecha_firma',
                'fecha_fin' => 'sometimes|date|after:fecha_inicio',
                'monto_total' => 'sometimes|numeric|min:0',
                'anticipo_porcentaje' => 'nullable|numeric|min:0|max:100',
                'estado' => 'sometimes|in:Vigente,En Revisión,Vencido',
                'descripcion' => 'nullable|string',
                'forma_pago' => 'nullable|string|max:100',
                'plazo_pago' => 'nullable|string|max:100',
                'responsable_contratante' => 'nullable|string|max:100',
                'cargo_contratante' => 'nullable|string|max:100',
                'email_contratante' => 'nullable|email|max:100',
                'rfc_cliente' => 'nullable|string|max:20',
                'responsable_contratista' => 'nullable|string|max:100',
                'cargo_contratista' => 'nullable|string|max:100',
                'email_contratista' => 'nullable|email|max:100'
            ]);
            
            // Recalcular si cambió el monto
            if (isset($validated['monto_total']) || isset($validated['anticipo_porcentaje'])) {
                $monto = $validated['monto_total'] ?? $contrato->monto_total;
                $porcentaje = $validated['anticipo_porcentaje'] ?? $contrato->anticipo_porcentaje;
                $validated['anticipo_monto'] = ($monto * $porcentaje) / 100;
                $validated['saldo_restante'] = $monto - $validated['anticipo_monto'];
            }
            
            $validated['updated_by'] = auth()->id();
            
            $contrato->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Contrato actualizado correctamente',
                'data' => $contrato
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al actualizar contrato: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el contrato: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear o actualizar un plano (CORREGIDO - Maneja duplicados)
     */
    public function storePlano(Request $request)
    {
        try {
            $validated = $request->validate([
                'no_plano' => 'required|string|max:50',
                'nombre' => 'required|string|max:255',
                'proyecto_id' => 'required|exists:proyectos,id',
                'disciplina' => 'required|string|max:50',
                'subdisciplina' => 'nullable|string|max:50',
                'fecha' => 'required|date',
                'formato' => 'required|string|max:20',
                'escala' => 'nullable|string|max:20',
                'descripcion' => 'nullable|string'
            ]);
            
            // ✅ VERIFICAR SI EL PLANO YA EXISTE
            $plano = Plano::where('proyecto_id', $validated['proyecto_id'])
                ->where('no_plano', $validated['no_plano'])
                ->first();
            
            if ($plano) {
                // ✅ ACTUALIZAR PLANO EXISTENTE
                $plano->update([
                    'nombre' => $validated['nombre'],
                    'disciplina' => $validated['disciplina'],
                    'subdisciplina' => $validated['subdisciplina'] ?? $plano->subdisciplina,
                    'fecha' => $validated['fecha'],
                    'formato' => $validated['formato'],
                    'escala' => $validated['escala'] ?? $plano->escala,
                    'descripcion' => $validated['descripcion'] ?? $plano->descripcion,
                    'updated_by' => auth()->id()
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Plano actualizado correctamente',
                    'data' => $plano,
                    'tipo_accion' => 'actualizado'
                ]);
            } else {
                // ✅ CREAR NUEVO PLANO
                $validated['estado'] = 'Pendiente';
                $validated['revision'] = 'Rev.0';
                $validated['created_by'] = auth()->id();
                
                $plano = Plano::create($validated);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Plano creado correctamente',
                    'data' => $plano,
                    'tipo_accion' => 'creado'
                ]);
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al guardar plano: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el plano: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un plano
     */
    public function updatePlano($id, Request $request)
    {
        try {
            $plano = Plano::findOrFail($id);
            
            $validated = $request->validate([
                'nombre' => 'sometimes|string|max:255',
                'disciplina' => 'sometimes|string|max:50',
                'subdisciplina' => 'nullable|string|max:50',
                'fecha' => 'sometimes|date',
                'formato' => 'sometimes|string|max:20',
                'escala' => 'nullable|string|max:20',
                'estado' => 'sometimes|in:Aprobado,En Revisión,Pendiente',
                'descripcion' => 'nullable|string'
            ]);
            
            // Si el estado cambia a Aprobado, registrar fecha y usuario
            if (isset($validated['estado']) && $validated['estado'] === 'Aprobado') {
                $validated['fecha_aprobacion'] = now();
                $validated['aprobado_por'] = auth()->id();
            }
            
            $validated['updated_by'] = auth()->id();
            
            $plano->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Plano actualizado correctamente',
                'data' => $plano
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al actualizar plano: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el plano: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Subir un archivo (documento) para un contrato o plano - CORREGIDO
     * Maneja creación de nuevos documentos o actualización de existentes
     */
    public function subirDocumento(Request $request)
    {
        try {
            // Validar campos
            $validated = $request->validate([
                'tipo' => 'required|in:contrato,plano',
                'id' => 'nullable|integer',
                'proyecto_id' => 'required|exists:proyectos,id',
                'no_documento' => 'required|string|max:50',
                'nombre' => 'required|string|max:255',
                'disciplina' => 'nullable|string|max:50',
                'fecha' => 'required|date',
                'version' => 'nullable|string|max:10',
                'cambios' => 'nullable|string',
                'archivo' => 'required|file|max:51200',
            ]);

            Log::info('=== SUBIR DOCUMENTO ===');
            Log::info('Tipo:', ['tipo' => $validated['tipo']]);
            Log::info('Documento:', ['no_documento' => $validated['no_documento']]);
            Log::info('ID recibido:', ['id' => $validated['id'] ?? 'null']);

            $archivo = $request->file('archivo');
            $extension = $archivo->getClientOriginalExtension();
            $nombreOriginal = $archivo->getClientOriginalName();
            $tamanio = $archivo->getSize();
            
            // Generar nombre único
            $nombreUnico = Str::uuid() . '.' . $extension;
            $path = $archivo->storeAs('documentos/' . $validated['tipo'] . 's', $nombreUnico, 'public');
            
            // Buscar o crear el documento
            if ($validated['tipo'] === 'contrato') {
                // Buscar contrato por ID o por número y proyecto
                if ($request->has('id') && $request->id && $request->id != 'null') {
                    Log::info('Buscando contrato por ID:', ['id' => $validated['id']]);
                    $documento = Contrato::findOrFail($validated['id']);
                } else {
                    Log::info('Buscando contrato por número y proyecto:', [
                        'no_contrato' => $validated['no_documento'],
                        'proyecto_id' => $validated['proyecto_id']
                    ]);
                    $documento = Contrato::where('no_contrato', $validated['no_documento'])
                        ->where('proyecto_id', $validated['proyecto_id'])
                        ->first();
                    
                    if (!$documento) {
                        Log::info('Creando nuevo contrato');
                        $documento = Contrato::create([
                            'no_contrato' => $validated['no_documento'],
                            'proyecto_id' => $validated['proyecto_id'],
                            'fecha_firma' => $validated['fecha'],
                            'fecha_inicio' => $validated['fecha'],
                            'fecha_fin' => date('Y-m-d', strtotime($validated['fecha'] . ' + 1 year')),
                            'monto_total' => 0,
                            'estado' => 'En Revisión',
                            'version' => $validated['version'] ?? 'v1.0',
                            'created_by' => auth()->id()
                        ]);
                    } else {
                        Log::info('Contrato existente encontrado:', ['id' => $documento->id]);
                    }
                }
            } else {
                // Buscar plano por ID o por número y proyecto
                if ($request->has('id') && $request->id && $request->id != 'null') {
                    Log::info('Buscando plano por ID:', ['id' => $validated['id']]);
                    $documento = Plano::findOrFail($validated['id']);
                } else {
                    Log::info('Buscando plano por número y proyecto:', [
                        'no_plano' => $validated['no_documento'],
                        'proyecto_id' => $validated['proyecto_id']
                    ]);
                    $documento = Plano::where('no_plano', $validated['no_documento'])
                        ->where('proyecto_id', $validated['proyecto_id'])
                        ->first();
                    
                    if (!$documento) {
                        Log::info('Creando nuevo plano');
                        $documento = Plano::create([
                            'no_plano' => $validated['no_documento'],
                            'nombre' => $validated['nombre'],
                            'proyecto_id' => $validated['proyecto_id'],
                            'disciplina' => $validated['disciplina'] ?? 'General',
                            'fecha' => $validated['fecha'],
                            'estado' => 'Pendiente',
                            'revision' => $validated['version'] ?? 'Rev.0',
                            'created_by' => auth()->id()
                        ]);
                    } else {
                        Log::info('Plano existente encontrado:', ['id' => $documento->id]);
                        // Actualizar el plano existente
                        $documento->update([
                            'nombre' => $validated['nombre'],
                            'disciplina' => $validated['disciplina'] ?? $documento->disciplina,
                            'fecha' => $validated['fecha'],
                            'revision' => $validated['version'] ?? $documento->revision,
                            'updated_by' => auth()->id()
                        ]);
                    }
                }
            }
            
            // Versión
            $version = $validated['version'] ?? $documento->version ?? 'v1.0';
            
            // Crear versión en el historial
            $versionRecord = DocumentoVersion::create([
                'documento_tipo' => $validated['tipo'],
                'documento_id' => $documento->id,
                'version' => $version,
                'fecha_version' => now(),
                'usuario_id' => auth()->id(),
                'cambios' => $validated['cambios'] ?? 'Subida inicial del documento',
                'documento_path' => $path,
                'documento_nombre' => $nombreOriginal,
                'tamanio_bytes' => $tamanio,
                'es_actual' => true,
                'created_by' => auth()->id()
            ]);
            
            // Marcar otras versiones como no actuales
            DocumentoVersion::where('documento_tipo', $validated['tipo'])
                ->where('documento_id', $documento->id)
                ->where('id', '!=', $versionRecord->id)
                ->update(['es_actual' => false]);
            
            // Actualizar el documento principal
            $documento->update([
                'documento_path' => $path,
                'documento_nombre' => $nombreOriginal,
                'documento_tamanio' => $tamanio,
                'version' => $version,
                'updated_by' => auth()->id()
            ]);
            
            Log::info('Documento subido correctamente:', [
                'id' => $documento->id,
                'tipo' => $validated['tipo'],
                'path' => $path
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Documento subido correctamente',
                'data' => [
                    'id' => $documento->id,
                    'tipo' => $validated['tipo'],
                    'no_documento' => $validated['no_documento'],
                    'path' => $path,
                    'nombre' => $nombreOriginal,
                    'version' => $version
                ]
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación al subir documento:', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error de validación: ' . implode(', ', array_merge(...array_values($e->errors()))),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al subir documento: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al subir el documento: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Descargar un documento
     */
    public function descargarDocumento($id, Request $request)
    {
        try {
            $tipo = $request->tipo; // 'contrato' o 'plano'
            
            if (!$tipo) {
                return response()->json(['error' => 'Tipo de documento requerido'], 400);
            }
            
            if ($tipo === 'contrato') {
                $documento = Contrato::findOrFail($id);
            } else {
                $documento = Plano::findOrFail($id);
            }
            
            if (empty($documento->documento_path)) {
                return response()->json(['error' => 'El documento no tiene archivo asociado'], 404);
            }
            
            if (!Storage::disk('public')->exists($documento->documento_path)) {
                return response()->json(['error' => 'El archivo no existe en el servidor'], 404);
            }
            
            $nombreDescarga = $documento->documento_nombre ?? $documento->no_contrato ?? $documento->no_plano . '.pdf';
            
            return Storage::disk('public')->download($documento->documento_path, $nombreDescarga);
            
        } catch (\Exception $e) {
            Log::error('Error al descargar documento: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al descargar el documento: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Descargar una versión específica de un documento
     */
    public function descargarVersion($id)
    {
        try {
            $version = DocumentoVersion::findOrFail($id);
            
            if (empty($version->documento_path)) {
                return response()->json(['error' => 'La versión no tiene archivo asociado'], 404);
            }
            
            if (!Storage::disk('public')->exists($version->documento_path)) {
                return response()->json(['error' => 'El archivo no existe en el servidor'], 404);
            }
            
            $nombreDescarga = $version->documento_nombre ?? 'version_' . $version->version . '.pdf';
            
            return Storage::disk('public')->download($version->documento_path, $nombreDescarga);
            
        } catch (\Exception $e) {
            Log::error('Error al descargar versión: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al descargar la versión: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un contrato (soft delete)
     */
    public function deleteContrato($id)
    {
        try {
            $contrato = Contrato::findOrFail($id);
            $contrato->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Contrato eliminado correctamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar contrato: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el contrato: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un plano (soft delete)
     */
    public function deletePlano($id)
    {
        try {
            $plano = Plano::findOrFail($id);
            $plano->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Plano eliminado correctamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar plano: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el plano: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exportar a Excel
     */
    public function exportarExcel(Request $request)
    {
        try {
            $tipo = $request->tipo ?? 'contratos';
            
            // Aquí implementar exportación con Laravel Excel
            return response()->json([
                'success' => true,
                'message' => 'Exportación en proceso',
                'tipo' => $tipo
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en exportarExcel: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar a Excel'
            ], 500);
        }
    }

    /**
     * Generar reporte PDF
     */
    public function reportePdf(Request $request)
    {
        try {
            // Aquí implementar generación de PDF
            return response()->json([
                'success' => true,
                'message' => 'Reporte en proceso'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en reportePdf: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el reporte PDF'
            ], 500);
        }
    }
}