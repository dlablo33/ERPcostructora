<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Cuadrilla;
use App\Models\Plantilla;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AsistenciaCuadrillaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la vista principal de Asistencia y Cuadrillas
     */
    public function flotillas()
    {
        Log::info('=== ASISTENCIA Y CUADRILLAS: Cargando vista ===');
        return view('proyectos.personal.flotillas');
    }

    /**
     * Obtiene todas las asistencias con filtros (para AJAX)
     */
    public function indexAsistencia(Request $request)
    {
        Log::info('=== ASISTENCIA: Index ===');
        Log::info('Filtros recibidos:', $request->all());
        
        try {
            $query = Asistencia::with(['empleado', 'cuadrilla.proyecto', 'user']);

            if ($request->filled('busqueda')) {
                $query->buscar($request->busqueda);
            }

            if ($request->filled('fecha')) {
                $query->byFecha($request->fecha);
            } else {
                $query->byFecha(now()->format('Y-m-d'));
            }

            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->byRangoFechas($request->fecha_inicio, $request->fecha_fin);
            }

            if ($request->filled('proyecto_id')) {
                $proyectos = $request->input('proyecto_id');
                if (is_array($proyectos) && count($proyectos) > 0) {
                    $proyectosFiltrados = array_filter($proyectos, function($value) {
                        return $value !== '' && $value !== null;
                    });
                    if (count($proyectosFiltrados) > 0) {
                        $cuadrillas = Cuadrilla::whereIn('proyecto_id', $proyectosFiltrados)->pluck('id');
                        $query->whereIn('cuadrilla_id', $cuadrillas);
                    }
                } elseif (!is_array($proyectos) && $proyectos !== '' && $proyectos !== null) {
                    $cuadrillas = Cuadrilla::where('proyecto_id', $proyectos)->pluck('id');
                    $query->whereIn('cuadrilla_id', $cuadrillas);
                }
            }

            if ($request->filled('cuadrilla_id')) {
                $query->byCuadrilla($request->cuadrilla_id);
            }

            if ($request->filled('estatus')) {
                $query->byEstatus($request->estatus);
            }

            $perPage = $request->get('per_page', 10);
            $asistencias = $query->orderBy('fecha', 'desc')->orderBy('hora_entrada', 'desc')->paginate($perPage);

            // Normalizar datos para el frontend
            $asistencias->getCollection()->transform(function ($item) {
                return $this->formatearAsistencia($item);
            });

            $estadisticas = $this->calcularEstadisticas($request);

            return response()->json([
                'success' => true,
                'data' => $asistencias,
                'estadisticas' => $estadisticas,
                'filtros_aplicados' => [
                    'fecha' => $request->input('fecha'),
                    'proyecto_id' => $request->input('proyecto_id'),
                    'cuadrilla_id' => $request->input('cuadrilla_id'),
                    'estatus' => $request->input('estatus')
                ],
                'message' => 'Asistencias obtenidas correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en index Asistencia: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener asistencias: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene todas las cuadrillas con filtros
     */
    public function indexCuadrillas(Request $request)
    {
        Log::info('=== CUADRILLAS: Index ===');
        
        try {
            $query = Cuadrilla::with(['proyecto', 'encargado', 'creador']);

            if ($request->filled('busqueda')) {
                $query->buscar($request->busqueda);
            }

            if ($request->filled('proyecto_id')) {
                $proyectos = $request->input('proyecto_id');
                if (is_array($proyectos) && count($proyectos) > 0) {
                    $query->whereIn('proyecto_id', $proyectos);
                } elseif (!is_array($proyectos) && $proyectos !== '') {
                    $query->byProyecto($proyectos);
                }
            }

            if ($request->filled('especialidad')) {
                $query->byEspecialidad($request->especialidad);
            }

            if ($request->filled('estatus')) {
                if ($request->estatus === 'activo') {
                    $query->activas();
                } elseif ($request->estatus === 'inactivo') {
                    $query->inactivas();
                }
            }

            $cuadrillas = $query->orderBy('codigo')->get();

            // Normalizar datos
            $cuadrillasTransformadas = $cuadrillas->map(function ($c) {
                return $this->formatearCuadrilla($c);
            });

            $resumen = [
                'total' => $cuadrillas->count(),
                'activas' => $cuadrillas->where('estatus', 'activo')->count(),
                'inactivas' => $cuadrillas->where('estatus', 'inactivo')->count(),
                'total_integrantes' => $cuadrillas->sum(function($c) {
                    $integrantes = is_array($c->integrantes) ? $c->integrantes : (json_decode($c->integrantes, true) ?? []);
                    return count($integrantes);
                })
            ];

            return response()->json([
                'success' => true,
                'data' => $cuadrillasTransformadas,
                'resumen' => $resumen,
                'message' => 'Cuadrillas obtenidas correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en index Cuadrillas: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener cuadrillas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene una asistencia específica
     */
    public function showAsistencia($id)
    {
        try {
            $asistencia = Asistencia::with(['empleado', 'cuadrilla.proyecto', 'user', 'registrador'])
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $this->formatearAsistencia($asistencia),
                'message' => 'Asistencia obtenida correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Asistencia no encontrada'
            ], 404);
        }
    }

    /**
     * Obtiene una cuadrilla específica CON DETALLE DE INTEGRANTES
     */
    public function showCuadrilla($id)
    {
        try {
            $cuadrilla = Cuadrilla::with(['proyecto', 'encargado', 'creador'])
                ->findOrFail($id);
            
            // Obtener detalle de integrantes
            $integrantesIds = is_array($cuadrilla->integrantes) 
                ? $cuadrilla->integrantes 
                : (json_decode($cuadrilla->integrantes, true) ?? []);
            
            $integrantesDetalle = [];
            if (!empty($integrantesIds)) {
                $integrantesDetalle = Plantilla::whereIn('plantilla_id', $integrantesIds)
                    ->get()
                    ->map(function ($p) {
                        return [
                            'id' => $p->plantilla_id,
                            'numero_empleado' => $p->numero_empleado_interno ?? $p->plantilla_id,
                            'nombre_completo' => trim(($p->nombre ?? '') . ' ' . ($p->apellido_paterno ?? '') . ' ' . ($p->apellido_materno ?? '')),
                            'puesto' => $p->puesto ?? null,
                        ];
                    })->toArray();
            }
            
            $data = $this->formatearCuadrilla($cuadrilla);
            $data['integrantes'] = $integrantesIds;
            $data['integrantes_detalle'] = $integrantesDetalle;
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Cuadrilla obtenida correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR showCuadrilla: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Cuadrilla no encontrada: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Toma asistencia (masivo)
     */
    public function tomarAsistencia(Request $request)
    {
        Log::info('=== ASISTENCIA: Tomando asistencia ===');
        Log::info('Datos:', $request->all());
        
        try {
            DB::beginTransaction();
            
            $fecha = $request->fecha ?? now()->format('Y-m-d');
            $cuadrillaId = $request->cuadrilla_id;
            $empleados = $request->empleados;
            
            if (empty($empleados)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay empleados para registrar'
                ], 422);
            }

            $registros = [];
            $errores = [];

            foreach ($empleados as $data) {
                try {
                    $asistencia = Asistencia::where('plantilla_id', $data['id'])
                        ->whereDate('fecha', $fecha)
                        ->first();

                    if ($asistencia) {
                        $asistencia->update([
                            'hora_entrada' => $data['hora_entrada'] ?? $asistencia->hora_entrada,
                            'hora_salida' => $data['hora_salida'] ?? $asistencia->hora_salida,
                            'estatus' => $data['status'] ?? $asistencia->estatus,
                            'cuadrilla_id' => $cuadrillaId ?? $asistencia->cuadrilla_id,
                            'observaciones' => $data['observaciones'] ?? $asistencia->observaciones,
                            'registrado_por' => auth()->id()
                        ]);
                        $registros[] = $asistencia;
                    } else {
                        $asistencia = Asistencia::create([
                            'plantilla_id' => $data['id'],
                            'cuadrilla_id' => $cuadrillaId,
                            'fecha' => $fecha,
                            'hora_entrada' => $data['hora_entrada'] ?? null,
                            'hora_salida' => $data['hora_salida'] ?? null,
                            'estatus' => $data['status'] ?? 'Activo',
                            'tipo_registro' => 'entrada',
                            'observaciones' => $data['observaciones'] ?? null,
                            'registrado_por' => auth()->id(),
                            'user_id' => auth()->id()
                        ]);
                        $registros[] = $asistencia;
                    }
                } catch (\Exception $e) {
                    $errores[] = [
                        'empleado_id' => $data['id'],
                        'error' => $e->getMessage()
                    ];
                    Log::error('Error al registrar asistencia para empleado ' . $data['id'] . ': ' . $e->getMessage());
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => [
                    'registrados' => count($registros),
                    'errores' => $errores,
                    'registros' => $registros
                ],
                'message' => count($registros) . ' registros de asistencia guardados correctamente'
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al tomar asistencia: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al tomar asistencia: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Registra asistencia individual
     */
    public function storeAsistencia(Request $request)
    {
        Log::info('=== ASISTENCIA: Creando registro individual ===');
        
        try {
            $request->validate([
                'plantilla_id' => 'required|exists:plantillas,plantilla_id',
                'fecha' => 'required|date',
                'hora_entrada' => 'nullable|date_format:H:i',
                'hora_salida' => 'nullable|date_format:H:i|after:hora_entrada',
                'estatus' => 'required|in:Activo,Pendiente,Justificado,Falta,Retardo'
            ]);

            DB::beginTransaction();

            $asistencia = Asistencia::create([
                'plantilla_id' => $request->plantilla_id,
                'cuadrilla_id' => $request->cuadrilla_id,
                'fecha' => $request->fecha,
                'hora_entrada' => $request->hora_entrada,
                'hora_salida' => $request->hora_salida,
                'estatus' => $request->estatus,
                'tipo_registro' => 'entrada',
                'observaciones' => $request->observaciones,
                'registrado_por' => auth()->id(),
                'user_id' => auth()->id()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $asistencia,
                'message' => 'Asistencia registrada correctamente'
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al registrar asistencia: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar asistencia: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualiza una asistencia
     */
    public function updateAsistencia(Request $request, $id)
    {
        Log::info('=== ASISTENCIA: Actualizando ID: ' . $id);
        
        try {
            $asistencia = Asistencia::findOrFail($id);
            
            $asistencia->update([
                'hora_entrada' => $request->hora_entrada ?? $asistencia->hora_entrada,
                'hora_salida' => $request->hora_salida ?? $asistencia->hora_salida,
                'estatus' => $request->estatus ?? $asistencia->estatus,
                'cuadrilla_id' => $request->cuadrilla_id ?? $asistencia->cuadrilla_id,
                'observaciones' => $request->observaciones ?? $asistencia->observaciones
            ]);

            return response()->json([
                'success' => true,
                'data' => $this->formatearAsistencia($asistencia->fresh(['empleado', 'cuadrilla.proyecto'])),
                'message' => 'Asistencia actualizada correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al actualizar asistencia: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar asistencia: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crea una nueva cuadrilla
     * CORREGIDO: Maneja integrantes como array o JSON string
     */
    public function storeCuadrilla(Request $request)
    {
        Log::info('=== CUADRILLAS: Creando nueva ===');
        Log::info('Datos recibidos:', $request->all());
        
        try {
            // Normalizar integrantes (puede llegar como string JSON desde FormData)
            $this->sincronizarSecuenciaCuadrillas();
            $integrantes = $this->normalizarIntegrantes($request->input('integrantes'));
            
            // Crear request modificado para validar
            $request->merge(['integrantes' => $integrantes]);
            
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:100',
                'especialidad' => 'required|in:cimentacion,estructura,acabados,instalaciones,obra_negra,albanileria,herreria,electricidad,plomeria,pintura',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'encargado_id' => 'nullable|exists:plantillas,plantilla_id',
                'integrantes' => 'nullable|array',
                'estatus' => 'nullable|in:activo,inactivo',
            ]);

            if ($validator->fails()) {
                Log::error('Validación fallida:', $validator->errors()->toArray());
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación: ' . $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // Generar código si no viene
            $codigo = $request->codigo;
            if (empty($codigo)) {
                $ultimoId = Cuadrilla::max('id') ?? 0;
                $codigo = 'CUA-' . str_pad($ultimoId + 1, 3, '0', STR_PAD_LEFT);
            }

            $cuadrilla = Cuadrilla::create([
                'codigo' => $codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'especialidad' => $request->especialidad,
                'proyecto_id' => $request->proyecto_id ?: null,
                'encargado_id' => $request->encargado_id ?: null,
                'integrantes' => $integrantes,
                'estatus' => $request->estatus ?? 'activo',
                'observaciones' => $request->observaciones,
                'created_by' => auth()->id()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $this->formatearCuadrilla($cuadrilla->fresh(['proyecto', 'encargado'])),
                'message' => 'Cuadrilla creada correctamente'
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al crear cuadrilla: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear cuadrilla: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualiza una cuadrilla
     * CORREGIDO: Maneja integrantes como array o JSON string
     */
    public function updateCuadrilla(Request $request, $id)
    {
        Log::info('=== CUADRILLAS: Actualizando ID: ' . $id);
        Log::info('Datos recibidos:', $request->all());
        
        try {
            $cuadrilla = Cuadrilla::findOrFail($id);
            
            // Normalizar integrantes
            $integrantes = $request->has('integrantes') 
                ? $this->normalizarIntegrantes($request->input('integrantes'))
                : $cuadrilla->integrantes;
            
            $request->merge(['integrantes' => $integrantes]);
            
            $validator = Validator::make($request->all(), [
                'nombre' => 'sometimes|required|string|max:100',
                'especialidad' => 'sometimes|required|in:cimentacion,estructura,acabados,instalaciones,obra_negra,albanileria,herreria,electricidad,plomeria,pintura',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'encargado_id' => 'nullable|exists:plantillas,plantilla_id',
                'integrantes' => 'nullable|array',
                'estatus' => 'nullable|in:activo,inactivo',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación: ' . $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422);
            }
            
            $cuadrilla->update([
                'codigo' => $request->codigo ?? $cuadrilla->codigo,
                'nombre' => $request->nombre ?? $cuadrilla->nombre,
                'descripcion' => $request->descripcion ?? $cuadrilla->descripcion,
                'especialidad' => $request->especialidad ?? $cuadrilla->especialidad,
                'proyecto_id' => $request->has('proyecto_id') ? ($request->proyecto_id ?: null) : $cuadrilla->proyecto_id,
                'encargado_id' => $request->has('encargado_id') ? ($request->encargado_id ?: null) : $cuadrilla->encargado_id,
                'integrantes' => $integrantes,
                'estatus' => $request->estatus ?? $cuadrilla->estatus,
                'observaciones' => $request->observaciones ?? $cuadrilla->observaciones
            ]);

            return response()->json([
                'success' => true,
                'data' => $this->formatearCuadrilla($cuadrilla->fresh(['proyecto', 'encargado'])),
                'message' => 'Cuadrilla actualizada correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al actualizar cuadrilla: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar cuadrilla: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina una cuadrilla
     * CORREGIDO: Verifica relaciones antes de eliminar y maneja errores
     */
    public function destroyCuadrilla($id)
    {
        Log::info('=== CUADRILLAS: Eliminando ID: ' . $id);
        
        try {
            DB::beginTransaction();
            
            $cuadrilla = Cuadrilla::findOrFail($id);
            
            // Verificar si tiene asistencias asociadas
            $tieneAsistencias = Asistencia::where('cuadrilla_id', $id)->exists();
            if ($tieneAsistencias) {
                // Opción: desvincular asistencias en lugar de bloquear
                Asistencia::where('cuadrilla_id', $id)->update(['cuadrilla_id' => null]);
                Log::info('Asistencias desvinculadas de la cuadrilla ID: ' . $id);
            }
            
            $cuadrilla->delete();
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cuadrilla eliminada correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al eliminar cuadrilla: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar cuadrilla: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene estadísticas para el dashboard
     */
    public function estadisticas(Request $request)
    {
        try {
            $estadisticas = $this->calcularEstadisticas($request);
            
            return response()->json([
                'success' => true,
                'data' => $estadisticas
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en estadísticas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas'
            ], 500);
        }
    }

    /**
     * Obtiene reporte mensual de asistencia
     */
    public function reporteMensual(Request $request)
    {
        try {
            $mes = $request->mes ?? now()->month;
            $anio = $request->anio ?? now()->year;
            
            $fechaInicio = Carbon::create($anio, $mes, 1)->startOfMonth();
            $fechaFin = Carbon::create($anio, $mes, 1)->endOfMonth();
            
            $asistencias = Asistencia::with(['empleado', 'cuadrilla.proyecto'])
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->get();
            
            $cuadrillas = Cuadrilla::with(['proyecto'])->get();
            $resumenProyectos = [];
            
            foreach ($cuadrillas as $cuadrilla) {
                $proyectoId = $cuadrilla->proyecto_id;
                if (!$proyectoId) continue;
                
                if (!isset($resumenProyectos[$proyectoId])) {
                    $resumenProyectos[$proyectoId] = [
                        'nombre' => $cuadrilla->proyecto->nombre ?? 'Proyecto ' . $proyectoId,
                        'total_asistencias' => 0,
                        'total_horas' => 0,
                        'presentes' => 0,
                        'ausentes' => 0,
                        'retardos' => 0,
                        'porcentaje_asistencia' => 0
                    ];
                }
                
                $asistenciasCuadrilla = $asistencias->where('cuadrilla_id', $cuadrilla->id);
                foreach ($asistenciasCuadrilla as $asistencia) {
                    $resumenProyectos[$proyectoId]['total_asistencias']++;
                    $resumenProyectos[$proyectoId]['total_horas'] += $asistencia->horas_trabajadas ?? 0;
                    
                    if ($asistencia->estatus === 'Activo') {
                        $resumenProyectos[$proyectoId]['presentes']++;
                    } elseif ($asistencia->estatus === 'Falta') {
                        $resumenProyectos[$proyectoId]['ausentes']++;
                    } elseif ($asistencia->estatus === 'Retardo') {
                        $resumenProyectos[$proyectoId]['retardos']++;
                    }
                }
            }
            
            // Calcular porcentajes
            foreach ($resumenProyectos as $proyectoId => &$data) {
                $total = $data['total_asistencias'];
                $data['porcentaje_asistencia'] = $total > 0 
                    ? round(($data['presentes'] / $total) * 100) 
                    : 0;
            }
            unset($data);
            
            // Datos para gráfico
            $dias = [];
            $fechaActual = clone $fechaInicio;
            while ($fechaActual <= $fechaFin) {
                $fechaStr = $fechaActual->format('Y-m-d');
                $asistenciasDia = $asistencias->filter(function ($a) use ($fechaStr) {
                    return Carbon::parse($a->fecha)->format('Y-m-d') === $fechaStr;
                });
                $total = $asistenciasDia->count();
                $presentes = $asistenciasDia->where('estatus', 'Activo')->count();
                
                $dias[] = [
                    'fecha' => $fechaActual->format('d/m'),
                    'total' => $total,
                    'presentes' => $presentes,
                    'porcentaje' => $total > 0 ? round(($presentes / $total) * 100) : 0
                ];
                $fechaActual->addDay();
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'periodo' => $fechaInicio->format('F Y'),
                    'dias_laborales' => $fechaInicio->diffInDays($fechaFin) + 1,
                    'total_registros' => $asistencias->count(),
                    'total_horas' => $asistencias->sum('horas_trabajadas'),
                    'resumen_proyectos' => $resumenProyectos,
                    'grafico' => $dias
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en reporte mensual: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar reporte: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exporta asistencias a Excel/CSV
     */
    public function exportarAsistencia(Request $request)
    {
        Log::info('=== ASISTENCIA: Exportando datos ===');
        
        try {
            $query = Asistencia::with(['empleado', 'cuadrilla']);
            
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->byRangoFechas($request->fecha_inicio, $request->fecha_fin);
            } else {
                $query->byFecha($request->fecha ?? now()->format('Y-m-d'));
            }
            
            $asistencias = $query->orderBy('fecha', 'desc')->get();
            
            $headers = ['Folio', 'Empleado', 'Fecha', 'Entrada', 'Salida', 'Horas', 'Cuadrilla', 'Estatus'];
            $rows = $asistencias->map(function($item) {
                return [
                    $item->folio,
                    trim(($item->empleado->nombre ?? '') . ' ' . ($item->empleado->apellido_paterno ?? '') . ' ' . ($item->empleado->apellido_materno ?? '')),
                    $item->fecha ? Carbon::parse($item->fecha)->format('d/m/Y') : '-',
                    $item->hora_entrada,
                    $item->hora_salida ?? '-',
                    number_format($item->horas_trabajadas ?? 0, 1),
                    $item->cuadrilla?->nombre ?? '-',
                    $item->estatus_nombre ?? $item->estatus
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => [
                    'headers' => $headers,
                    'rows' => $rows,
                    'total' => $asistencias->count()
                ],
                'message' => 'Datos listos para exportar'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al exportar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar datos'
            ], 500);
        }
    }

    /**
     * Obtiene catálogos para selects
     */
    public function catalogos()
    {
        try {
            $cuadrillas = Cuadrilla::activas()
                ->select('id', 'codigo', 'nombre', 'especialidad')
                ->orderBy('codigo')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nombre' => $item->codigo . ' - ' . $item->nombre,
                        'especialidad' => $item->especialidad_nombre ?? $item->especialidad
                    ];
                });
            
            $proyectos = Proyecto::whereIn('status', ['activo', 'en_curso'])
                ->select('id', 'codigo', 'nombre')
                ->orderBy('nombre')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nombre' => $item->codigo . ' - ' . $item->nombre
                    ];
                });
            
            $empleados = Plantilla::where('estatus', 'Activo')
                ->select('plantilla_id as id', 'nombre', 'apellido_paterno', 'apellido_materno')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nombre_completo' => trim($item->nombre . ' ' . ($item->apellido_paterno ?? '') . ' ' . ($item->apellido_materno ?? ''))
                    ];
                });
            
            return response()->json([
                'success' => true,
                'data' => [
                    'cuadrillas' => $cuadrillas,
                    'proyectos' => $proyectos,
                    'empleados' => $empleados
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener catálogos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data' => [
                    'cuadrillas' => [],
                    'proyectos' => [],
                    'empleados' => []
                ],
                'message' => 'Error al obtener catálogos: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Obtiene personal de una cuadrilla para tomar asistencia
     * CORREGIDO: Maneja integrantes como array o JSON
     */
    public function personalPorCuadrilla($cuadrillaId)
    {
        try {
            $cuadrilla = Cuadrilla::with(['encargado', 'proyecto'])->findOrFail($cuadrillaId);
            
            $integrantesIds = is_array($cuadrilla->integrantes) 
                ? $cuadrilla->integrantes 
                : (json_decode($cuadrilla->integrantes, true) ?? []);
            
            // Asegurar que son enteros
            $integrantesIds = array_map('intval', $integrantesIds);
            
            $integrantes = [];
            
            if (!empty($integrantesIds)) {
                $integrantes = Plantilla::whereIn('plantilla_id', $integrantesIds)
                    ->select('plantilla_id as id', 'numero_empleado_interno', 'nombre', 'apellido_paterno', 'apellido_materno', 'puesto')
                    ->get()
                    ->map(function($item) {
                        return [
                            'id' => $item->id,
                            'numero_empleado' => $item->numero_empleado_interno ?? $item->id,
                            'nombre_completo' => trim($item->nombre . ' ' . ($item->apellido_paterno ?? '') . ' ' . ($item->apellido_materno ?? '')),
                            'puesto' => $item->puesto
                        ];
                    })
                    ->toArray();
            }
            
            // Agregar encargado si no está en la lista
            if ($cuadrilla->encargado_id) {
                $idsArray = array_column($integrantes, 'id');
                if (!in_array($cuadrilla->encargado_id, $idsArray)) {
                    $encargado = Plantilla::find($cuadrilla->encargado_id);
                    if ($encargado) {
                        array_unshift($integrantes, [
                            'id' => $encargado->plantilla_id,
                            'numero_empleado' => $encargado->numero_empleado_interno ?? $encargado->plantilla_id,
                            'nombre_completo' => trim($encargado->nombre . ' ' . ($encargado->apellido_paterno ?? '') . ' ' . ($encargado->apellido_materno ?? '')) . ' (Encargado)',
                            'puesto' => $encargado->puesto ?? 'Encargado'
                        ]);
                    }
                }
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'cuadrilla' => $this->formatearCuadrilla($cuadrilla),
                    'integrantes' => $integrantes
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener personal de cuadrilla: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener personal de la cuadrilla: ' . $e->getMessage(),
                'data' => [
                    'cuadrilla' => null,
                    'integrantes' => []
                ]
            ], 500);
        }
    }

    /**
     * Asigna un empleado a una cuadrilla
     */
    public function asignarEmpleado(Request $request)
    {
        Log::info('=== ASIGNAR EMPLEADO A CUADRILLA ===');
        Log::info('Datos:', $request->all());
        
        try {
            $request->validate([
                'empleado_id' => 'required|exists:plantillas,plantilla_id',
                'cuadrilla_id' => 'required|exists:cuadrillas,id'
            ]);
            
            DB::beginTransaction();
            
            $empleadoId = (int) $request->empleado_id;
            $cuadrillaId = (int) $request->cuadrilla_id;
            
            // Remover de cualquier cuadrilla actual
            $cuadrillas = Cuadrilla::all();
            foreach ($cuadrillas as $c) {
                $integrantes = is_array($c->integrantes) 
                    ? $c->integrantes 
                    : (json_decode($c->integrantes, true) ?? []);
                
                $integrantes = array_map('intval', $integrantes);
                
                if (in_array($empleadoId, $integrantes)) {
                    $integrantes = array_values(array_filter($integrantes, function($id) use ($empleadoId) {
                        return $id !== $empleadoId;
                    }));
                    $c->integrantes = $integrantes;
                    $c->save();
                }
            }
            
            // Asignar a la nueva cuadrilla
            $cuadrillaDestino = Cuadrilla::find($cuadrillaId);
            $integrantes = is_array($cuadrillaDestino->integrantes) 
                ? $cuadrillaDestino->integrantes 
                : (json_decode($cuadrillaDestino->integrantes, true) ?? []);
            
            $integrantes = array_map('intval', $integrantes);
            
            if (!in_array($empleadoId, $integrantes)) {
                $integrantes[] = $empleadoId;
            }
            
            $cuadrillaDestino->integrantes = array_values($integrantes);
            $cuadrillaDestino->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Empleado asignado a la cuadrilla correctamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al asignar empleado: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error al asignar empleado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene las asignaciones actuales de empleados a cuadrillas
     */
    public function getAsignaciones()
    {
        try {
            $cuadrillas = Cuadrilla::all();
            $asignaciones = [];
            
            foreach ($cuadrillas as $cuadrilla) {
                $integrantes = is_array($cuadrilla->integrantes) 
                    ? $cuadrilla->integrantes 
                    : (json_decode($cuadrilla->integrantes, true) ?? []);
                
                foreach ($integrantes as $empleadoId) {
                    $empleado = Plantilla::find($empleadoId);
                    if ($empleado) {
                        $asignaciones[$empleadoId] = [
                            'empleado_id' => $empleadoId,
                            'empleado_nombre' => trim($empleado->nombre . ' ' . ($empleado->apellido_paterno ?? '') . ' ' . ($empleado->apellido_materno ?? '')),
                            'cuadrilla_id' => $cuadrilla->id,
                            'cuadrilla_nombre' => $cuadrilla->codigo . ' - ' . $cuadrilla->nombre
                        ];
                    }
                }
            }
            
            return response()->json([
                'success' => true,
                'data' => $asignaciones
            ]);
            
        } catch (\Exception $e) {
            Log::error('ERROR al obtener asignaciones: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Error al obtener asignaciones: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remueve un empleado de su cuadrilla
     */
    public function removerAsignacion($empleadoId)
    {
        Log::info('=== REMOVER ASIGNACIÓN: Empleado ID: ' . $empleadoId);
        
        try {
            DB::beginTransaction();
            
            $empleadoId = (int) $empleadoId;
            
            $cuadrillas = Cuadrilla::all();
            foreach ($cuadrillas as $cuadrilla) {
                $integrantes = is_array($cuadrilla->integrantes) 
                    ? $cuadrilla->integrantes 
                    : (json_decode($cuadrilla->integrantes, true) ?? []);
                
                $integrantes = array_map('intval', $integrantes);
                
                if (in_array($empleadoId, $integrantes)) {
                    $integrantes = array_values(array_filter($integrantes, function($id) use ($empleadoId) {
                        return $id !== $empleadoId;
                    }));
                    $cuadrilla->integrantes = $integrantes;
                    $cuadrilla->save();
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Empleado removido de la cuadrilla correctamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al remover asignación: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al remover asignación: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Endpoint para obtener empleados disponibles
     */
    public function empleadosDisponibles()
    {
        try {
            $empleados = Plantilla::where('estatus', 'Activo')
                ->select('plantilla_id as id', 'nombre', 'apellido_paterno', 'apellido_materno')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nombre_completo' => trim($item->nombre . ' ' . ($item->apellido_paterno ?? '') . ' ' . ($item->apellido_materno ?? ''))
                    ];
                });
            
            return response()->json([
                'success' => true,
                'data' => $empleados
            ]);
            
        } catch (\Exception $e) {
            Log::error('ERROR empleadosDisponibles: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Error al obtener empleados'
            ], 500);
        }
    }

    // ==================== MÉTODOS PRIVADOS ====================

    /**
     * Normaliza integrantes a array de enteros
     */
    private function normalizarIntegrantes($integrantes): array
    {
        if (empty($integrantes)) {
            return [];
        }
        
        // Si es string JSON
        if (is_string($integrantes)) {
            $decoded = json_decode($integrantes, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $integrantes = $decoded;
            } else {
                // Puede ser "1,2,3"
                $integrantes = array_filter(explode(',', $integrantes));
            }
        }
        
        if (!is_array($integrantes)) {
            return [];
        }
        
        // Convertir a enteros y filtrar vacíos
        return array_values(array_filter(array_map('intval', $integrantes)));
    }

    /**
     * Formatea una asistencia para el frontend
     */
    private function formatearAsistencia($item): array
    {
        return [
            'id' => $item->id,
            'folio' => $item->folio ?? null,
            'plantilla_id' => $item->plantilla_id,
            'nombre_completo' => trim(
                ($item->empleado->nombre ?? '') . ' ' . 
                ($item->empleado->apellido_paterno ?? '') . ' ' . 
                ($item->empleado->apellido_materno ?? '')
            ) ?: ($item->nombre_completo ?? '-'),
            'fecha' => $item->fecha,
            'hora_entrada' => $item->hora_entrada,
            'hora_salida' => $item->hora_salida,
            'horas_trabajadas' => (float) ($item->horas_trabajadas ?? 0),
            'estatus' => $item->estatus,
            'estatus_nombre' => $item->estatus_nombre ?? $item->estatus,
            'observaciones' => $item->observaciones,
            'cuadrilla' => $item->cuadrilla ? [
                'id' => $item->cuadrilla->id,
                'codigo' => $item->cuadrilla->codigo,
                'nombre' => $item->cuadrilla->nombre,
                'proyecto' => $item->cuadrilla->proyecto ? [
                    'id' => $item->cuadrilla->proyecto->id,
                    'nombre' => $item->cuadrilla->proyecto->nombre,
                ] : null,
            ] : null,
            'empleado' => $item->empleado ? [
                'plantilla_id' => $item->empleado->plantilla_id,
                'numero_empleado_interno' => $item->empleado->numero_empleado_interno,
            ] : null,
            'registrador' => $item->registrador ? [
                'name' => $item->registrador->name
            ] : null,
        ];
    }

    /**
     * Formatea una cuadrilla para el frontend
     */
    private function formatearCuadrilla($c): array
    {
        $integrantes = is_array($c->integrantes) 
            ? $c->integrantes 
            : (json_decode($c->integrantes, true) ?? []);
        
        $especialidades = [
            'cimentacion' => '🏗️ Cimentación',
            'estructura' => '🏢 Estructura',
            'acabados' => '🎨 Acabados',
            'instalaciones' => '🔌 Instalaciones',
            'obra_negra' => '🧱 Obra Negra',
            'albanileria' => '🔨 Albañilería',
            'herreria' => '⚙️ Herrería',
            'electricidad' => '⚡ Electricidad',
            'plomeria' => '💧 Plomería',
            'pintura' => '🖌️ Pintura',
        ];
        
        return [
            'id' => $c->id,
            'codigo' => $c->codigo,
            'nombre' => $c->nombre,
            'descripcion' => $c->descripcion,
            'especialidad' => $c->especialidad,
            'especialidad_nombre' => $especialidades[$c->especialidad] ?? $c->especialidad,
            'proyecto_id' => $c->proyecto_id,
            'proyecto' => $c->proyecto ? [
                'id' => $c->proyecto->id,
                'nombre' => $c->proyecto->nombre,
                'codigo' => $c->proyecto->codigo,
            ] : null,
            'encargado_id' => $c->encargado_id,
            'nombre_encargado' => $c->encargado 
                ? trim(($c->encargado->nombre ?? '') . ' ' . ($c->encargado->apellido_paterno ?? '') . ' ' . ($c->encargado->apellido_materno ?? ''))
                : null,
            'integrantes' => array_map('intval', $integrantes),
            'total_integrantes' => count($integrantes),
            'estatus' => $c->estatus,
            'estatus_nombre' => $c->estatus === 'activo' ? 'Activo' : 'Inactivo',
            'observaciones' => $c->observaciones,
            'created_at' => $c->created_at,
        ];
    }

    /**
     * Calcula las estadísticas para los 4 cuadros
     */
    private function calcularEstadisticas(Request $request): array
    {
        try {
            $query = Asistencia::query();
            
            $fecha = $request->fecha ?? now()->format('Y-m-d');
            $query->byFecha($fecha);
            
            if ($request->filled('proyecto_id')) {
                $proyectos = $request->input('proyecto_id');
                if (is_array($proyectos) && count($proyectos) > 0) {
                    $proyectosFiltrados = array_filter($proyectos, function($value) {
                        return $value !== '' && $value !== null;
                    });
                    if (count($proyectosFiltrados) > 0) {
                        $cuadrillas = Cuadrilla::whereIn('proyecto_id', $proyectosFiltrados)->pluck('id');
                        $query->whereIn('cuadrilla_id', $cuadrillas);
                    }
                } elseif (!is_array($proyectos) && $proyectos !== '' && $proyectos !== null) {
                    $cuadrillas = Cuadrilla::where('proyecto_id', $proyectos)->pluck('id');
                    $query->whereIn('cuadrilla_id', $cuadrillas);
                }
            }
            
            if ($request->filled('cuadrilla_id')) {
                $query->byCuadrilla($request->cuadrilla_id);
            }

            $total = (clone $query)->count();
            $presentes = (clone $query)->where('estatus', 'Activo')->count();
            $ausentes = (clone $query)->where('estatus', 'Falta')->count();
            $retardos = (clone $query)->where('estatus', 'Retardo')->count();
            $justificados = (clone $query)->where('estatus', 'Justificado')->count();
            
            $porcentaje = $total > 0 ? round(($presentes / $total) * 100) : 0;

            return [
                'total_personal' => $total,
                'presentes' => $presentes,
                'ausentes' => $ausentes,
                'retardos' => $retardos,
                'porcentaje' => $porcentaje,
                'justificados' => $justificados,
                'vacaciones' => 0,
                'permisos' => 0
            ];
            
        } catch (\Exception $e) {
            Log::error('ERROR calcularEstadisticas: ' . $e->getMessage());
            return [
                'total_personal' => 0,
                'presentes' => 0,
                'ausentes' => 0,
                'retardos' => 0,
                'porcentaje' => 0,
                'justificados' => 0,
                'vacaciones' => 0,
                'permisos' => 0
            ];
        }
    }

    /**
 * Sincroniza la secuencia de la tabla cuadrillas (para PostgreSQL)
 */
private function sincronizarSecuenciaCuadrillas()
{
    try {
        // Solo para PostgreSQL
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("
                SELECT setval(
                    pg_get_serial_sequence('cuadrillas', 'id'),
                    COALESCE((SELECT MAX(id) FROM cuadrillas), 0) + 1,
                    false
                )
            ");
            Log::info('Secuencia de cuadrillas sincronizada');
        }
    } catch (\Exception $e) {
        Log::warning('No se pudo sincronizar la secuencia: ' . $e->getMessage());
    }
}
}