<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Cuadrilla;
use App\Models\Plantilla;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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
            $query = Asistencia::with(['empleado', 'cuadrilla', 'user']);

            // Aplicar filtro de búsqueda
            if ($request->filled('busqueda')) {
                $query->buscar($request->busqueda);
            }

            // Aplicar filtro por fecha
            if ($request->filled('fecha')) {
                $query->byFecha($request->fecha);
            } else {
                $query->byFecha(now()->format('Y-m-d'));
            }

            // Aplicar filtro por rango de fechas
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->byRangoFechas($request->fecha_inicio, $request->fecha_fin);
            }

            // Aplicar filtro por proyecto (a través de cuadrilla)
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

            // Aplicar filtro por cuadrilla
            if ($request->filled('cuadrilla_id')) {
                $query->byCuadrilla($request->cuadrilla_id);
            }

            // Aplicar filtro por estatus
            if ($request->filled('estatus')) {
                $query->byEstatus($request->estatus);
            }

            // Ordenar y paginar
            $perPage = $request->get('per_page', 10);
            $asistencias = $query->orderBy('fecha', 'desc')->orderBy('hora_entrada', 'desc')->paginate($perPage);

            // Calcular estadísticas para los 4 cuadros
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

            // Aplicar filtro de búsqueda
            if ($request->filled('busqueda')) {
                $query->buscar($request->busqueda);
            }

            // Aplicar filtro por proyecto
            if ($request->filled('proyecto_id')) {
                $query->byProyecto($request->proyecto_id);
            }

            // Aplicar filtro por especialidad
            if ($request->filled('especialidad')) {
                $query->byEspecialidad($request->especialidad);
            }

            // Aplicar filtro por estatus
            if ($request->filled('estatus')) {
                if ($request->estatus === 'activo') {
                    $query->activas();
                } elseif ($request->estatus === 'inactivo') {
                    $query->inactivas();
                }
            }

            $cuadrillas = $query->orderBy('codigo')->get();

            // Calcular resumen
            $resumen = [
                'total' => $cuadrillas->count(),
                'activas' => $cuadrillas->where('estatus', 'activo')->count(),
                'inactivas' => $cuadrillas->where('estatus', 'inactivo')->count(),
                'total_integrantes' => $cuadrillas->sum(function($c) {
                    $integrantes = $c->integrantes ?? [];
                    return count($integrantes);
                })
            ];

            return response()->json([
                'success' => true,
                'data' => $cuadrillas,
                'resumen' => $resumen,
                'message' => 'Cuadrillas obtenidas correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en index Cuadrillas: ' . $e->getMessage());
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
            $asistencia = Asistencia::with(['empleado', 'cuadrilla', 'user', 'registrador'])
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $asistencia,
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
     * Obtiene una cuadrilla específica
     */
    public function showCuadrilla($id)
    {
        try {
            $cuadrilla = Cuadrilla::with(['proyecto', 'encargado', 'creador'])
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $cuadrilla,
                'message' => 'Cuadrilla obtenida correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cuadrilla no encontrada'
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
            $empleados = $request->empleados; // Array de {id, hora_entrada, status}
            
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
                    // Verificar si ya existe registro para este empleado y fecha
                    $asistencia = Asistencia::where('plantilla_id', $data['id'])
                        ->whereDate('fecha', $fecha)
                        ->first();

                    if ($asistencia) {
                        // Actualizar existente
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
                        // Crear nuevo
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
                'data' => $asistencia,
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
     */
    public function storeCuadrilla(Request $request)
    {
        Log::info('=== CUADRILLAS: Creando nueva ===');
        
        try {
            $request->validate([
                'nombre' => 'required|string|max:100',
                'especialidad' => 'required|in:cimentacion,estructura,acabados,instalaciones,obra_negra,albanileria,herreria,electricidad,plomeria,pintura',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'encargado_id' => 'nullable|exists:plantillas,plantilla_id',
                'integrantes' => 'nullable|array'
            ]);

            DB::beginTransaction();

            $cuadrilla = Cuadrilla::create([
                'codigo' => $request->codigo ?? null,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'especialidad' => $request->especialidad,
                'proyecto_id' => $request->proyecto_id,
                'encargado_id' => $request->encargado_id,
                'integrantes' => $request->integrantes ?? [],
                'estatus' => $request->estatus ?? 'activo',
                'observaciones' => $request->observaciones,
                'created_by' => auth()->id()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $cuadrilla,
                'message' => 'Cuadrilla creada correctamente'
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al crear cuadrilla: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear cuadrilla: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualiza una cuadrilla
     */
    public function updateCuadrilla(Request $request, $id)
    {
        Log::info('=== CUADRILLAS: Actualizando ID: ' . $id);
        
        try {
            $cuadrilla = Cuadrilla::findOrFail($id);
            
            $cuadrilla->update([
                'nombre' => $request->nombre ?? $cuadrilla->nombre,
                'descripcion' => $request->descripcion ?? $cuadrilla->descripcion,
                'especialidad' => $request->especialidad ?? $cuadrilla->especialidad,
                'proyecto_id' => $request->proyecto_id ?? $cuadrilla->proyecto_id,
                'encargado_id' => $request->encargado_id ?? $cuadrilla->encargado_id,
                'integrantes' => $request->integrantes ?? $cuadrilla->integrantes,
                'estatus' => $request->estatus ?? $cuadrilla->estatus,
                'observaciones' => $request->observaciones ?? $cuadrilla->observaciones
            ]);

            return response()->json([
                'success' => true,
                'data' => $cuadrilla,
                'message' => 'Cuadrilla actualizada correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al actualizar cuadrilla: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar cuadrilla: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina una cuadrilla (soft delete)
     */
    public function destroyCuadrilla($id)
    {
        Log::info('=== CUADRILLAS: Eliminando ID: ' . $id);
        
        try {
            $cuadrilla = Cuadrilla::findOrFail($id);
            $cuadrilla->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cuadrilla eliminada correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al eliminar cuadrilla: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar cuadrilla'
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
            
            // Asistencias del mes
            $asistencias = Asistencia::with(['empleado', 'cuadrilla'])
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->get();
            
            // Resumen por proyecto
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
                        'retardos' => 0
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
            
            // Datos para gráfico
            $dias = [];
            $fechaActual = clone $fechaInicio;
            while ($fechaActual <= $fechaFin) {
                $asistenciasDia = $asistencias->where('fecha', $fechaActual->format('Y-m-d'));
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
                $query->byFecha(now()->format('Y-m-d'));
            }
            
            $asistencias = $query->orderBy('fecha', 'desc')->get();
            
            $headers = ['Folio', 'Empleado', 'Fecha', 'Entrada', 'Salida', 'Horas', 'Cuadrilla', 'Estatus'];
            $rows = $asistencias->map(function($item) {
                return [
                    $item->folio,
                    $item->nombre_completo,
                    $item->fecha?->format('d/m/Y'),
                    $item->hora_entrada,
                    $item->hora_salida ?? '-',
                    number_format($item->horas_trabajadas, 1),
                    $item->cuadrilla?->nombre ?? '-',
                    $item->estatus_nombre
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
                        'especialidad' => $item->especialidad_nombre
                    ];
                });
            
            $proyectos = Proyecto::where('status', 'activo')
                ->orWhere('status', 'en_curso')
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
                'data' => [],
                'message' => 'Error al obtener catálogos'
            ]);
        }
    }

    /**
     * Obtiene personal de una cuadrilla para tomar asistencia
     */
    public function personalPorCuadrilla($cuadrillaId)
    {
        try {
            $cuadrilla = Cuadrilla::with(['encargado'])->findOrFail($cuadrillaId);
            
            $integrantes = [];
            
            // Obtener integrantes de la cuadrilla
            if ($cuadrilla->integrantes && is_array($cuadrilla->integrantes)) {
                $integrantes = Plantilla::whereIn('plantilla_id', $cuadrilla->integrantes)
                    ->select('plantilla_id as id', 'nombre', 'apellido_paterno', 'apellido_materno')
                    ->get()
                    ->map(function($item) {
                        return [
                            'id' => $item->id,
                            'nombre_completo' => trim($item->nombre . ' ' . ($item->apellido_paterno ?? '') . ' ' . ($item->apellido_materno ?? ''))
                        ];
                    });
            }
            
            // Agregar encargado si no está en la lista
            if ($cuadrilla->encargado_id) {
                $existe = $integrantes->contains('id', $cuadrilla->encargado_id);
                if (!$existe) {
                    $encargado = Plantilla::find($cuadrilla->encargado_id);
                    if ($encargado) {
                        $integrantes->push([
                            'id' => $encargado->plantilla_id,
                            'nombre_completo' => trim($encargado->nombre . ' ' . ($encargado->apellido_paterno ?? '') . ' ' . ($encargado->apellido_materno ?? ''))
                        ]);
                    }
                }
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'cuadrilla' => $cuadrilla,
                    'integrantes' => $integrantes
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener personal de cuadrilla: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener personal de la cuadrilla'
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
            
            // Verificar si el empleado ya está asignado a otra cuadrilla
            $cuadrillaActual = Cuadrilla::whereJsonContains('integrantes', $request->empleado_id)->first();
            if ($cuadrillaActual) {
                // Remover de la cuadrilla actual
                $integrantes = $cuadrillaActual->integrantes ?? [];
                $key = array_search($request->empleado_id, $integrantes);
                if ($key !== false) {
                    unset($integrantes[$key]);
                    $cuadrillaActual->integrantes = array_values($integrantes);
                    $cuadrillaActual->save();
                }
            }
            
            // Asignar a la nueva cuadrilla
            $cuadrillaDestino = Cuadrilla::find($request->cuadrilla_id);
            $integrantes = $cuadrillaDestino->integrantes ?? [];
            if (!in_array($request->empleado_id, $integrantes)) {
                $integrantes[] = $request->empleado_id;
                $cuadrillaDestino->integrantes = $integrantes;
                $cuadrillaDestino->save();
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Empleado asignado a la cuadrilla correctamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('ERROR al asignar empleado: ' . $e->getMessage());
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
            $cuadrillas = Cuadrilla::with(['encargado'])->get();
            $asignaciones = [];
            
            foreach ($cuadrillas as $cuadrilla) {
                $integrantes = $cuadrilla->integrantes ?? [];
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
                'message' => 'Error al obtener asignaciones'
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
            $cuadrilla = Cuadrilla::whereJsonContains('integrantes', $empleadoId)->first();
            if ($cuadrilla) {
                $integrantes = $cuadrilla->integrantes ?? [];
                $key = array_search($empleadoId, $integrantes);
                if ($key !== false) {
                    unset($integrantes[$key]);
                    $cuadrilla->integrantes = array_values($integrantes);
                    $cuadrilla->save();
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Empleado removido de la cuadrilla correctamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('ERROR al remover asignación: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al remover asignación'
            ], 500);
        }
    }

    // ==================== MÉTODOS PRIVADOS ====================

    /**
     * Calcula las estadísticas para los 4 cuadros
     */
    private function calcularEstadisticas(Request $request): array
    {
        try {
            $query = Asistencia::query();
            
            // Aplicar fecha
            $fecha = $request->fecha ?? now()->format('Y-m-d');
            $query->byFecha($fecha);
            
            // Aplicar filtro por proyecto
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
                'total_personal' => $total + $ausentes,
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
}