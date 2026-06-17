<?php

namespace App\Http\Controllers;

use App\Models\AsignacionPersonal;
use App\Models\AsignacionHistorial;
use App\Models\Plantilla;
use App\Models\Proyecto;
use App\Models\Puesto;
use App\Http\Requests\AsignacionPersonalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AsignacionPersonalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la vista principal de Personal Asignado
     */
    public function asignada()
    {
        Log::info('=== PERSONAL ASIGNADO: Cargando vista ===');
        return view('proyectos.personal.asignada');
    }

    /**
     * Obtiene todas las asignaciones con filtros (para AJAX)
     * SOPORTA FILTRO MÚLTIPLE DE PROYECTOS
     */
    public function index(Request $request)
    {
        Log::info('=== PERSONAL ASIGNADO INDEX ===');
        Log::info('Filtros recibidos:', $request->all());
        
        try {
            $query = AsignacionPersonal::with(['empleado', 'proyecto', 'creador']);

            // Aplicar filtro de búsqueda
            if ($request->filled('busqueda')) {
                $query->buscar($request->busqueda);
            }

            // Aplicar filtro por múltiples proyectos
            if ($request->filled('proyecto_id')) {
                $proyectos = $request->input('proyecto_id');
                
                if (is_array($proyectos) && count($proyectos) > 0) {
                    $proyectosFiltrados = array_filter($proyectos, function($value) {
                        return $value !== '' && $value !== null;
                    });
                    
                    if (count($proyectosFiltrados) > 0) {
                        $query->whereIn('proyecto_id', $proyectosFiltrados);
                        Log::info('Filtrando por proyectos: ' . implode(', ', $proyectosFiltrados));
                    }
                } elseif (!is_array($proyectos) && $proyectos !== '' && $proyectos !== null) {
                    $query->where('proyecto_id', $proyectos);
                    Log::info('Filtrando por proyecto: ' . $proyectos);
                }
            }

            // Aplicar filtro por tipo de personal
            if ($request->filled('tipo_personal') && $request->tipo_personal !== 'todos') {
                $query->byTipo($request->tipo_personal);
            }

            // Aplicar filtro por status
            if ($request->filled('status')) {
                $query->byStatus($request->status);
            }

            // Ordenar y paginar
            $perPage = $request->get('per_page', 10);
            $asignaciones = $query->orderBy('created_at', 'desc')->paginate($perPage);

            // Calcular estadísticas para los 4 cuadros
            $estadisticas = $this->calcularEstadisticas($request);

            return response()->json([
                'success' => true,
                'data' => $asignaciones,
                'estadisticas' => $estadisticas,
                'filtros_aplicados' => [
                    'proyectos' => $request->input('proyecto_id'),
                    'tipo_personal' => $request->input('tipo_personal'),
                    'status' => $request->input('status')
                ],
                'message' => 'Asignaciones obtenidas correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en index Personal Asignado: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener asignaciones: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene una asignación específica por ID
     */
    public function show($id)
    {
        Log::info('=== PERSONAL ASIGNADO: Mostrando detalle ID: ' . $id);
        
        try {
            $asignacion = AsignacionPersonal::with(['empleado', 'proyecto', 'creador', 'historial'])
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $asignacion,
                'message' => 'Asignación obtenida correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al mostrar asignación: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Asignación no encontrada'
            ], 404);
        }
    }

    /**
     * Almacena una nueva asignación de personal
     */
    public function store(AsignacionPersonalRequest $request)
    {
        Log::info('=== PERSONAL ASIGNADO: Creando nueva asignación ===');
        Log::info('Datos recibidos:', $request->all());
        
        try {
            DB::beginTransaction();
            
            // Verificar que el empleado no esté ya activo en este proyecto
            $existe = AsignacionPersonal::where('empleado_id', $request->empleado_id)
                ->where('proyecto_id', $request->proyecto_id)
                ->where('status', 'activo')
                ->exists();
            
            if ($existe) {
                return response()->json([
                    'success' => false,
                    'message' => 'El empleado ya está activo en este proyecto'
                ], 422);
            }
            
            $asignacion = AsignacionPersonal::create([
                'empleado_id' => $request->empleado_id,
                'proyecto_id' => $request->proyecto_id,
                'tipo_personal' => $request->tipo_personal,
                'rol' => $request->rol,
                'fecha_asignacion' => $request->fecha_asignacion ?? now(),
                'fecha_fin' => $request->fecha_fin,
                'salario_diario' => $request->salario_diario ?? 0,
                'status' => $request->status ?? 'activo',
                'observaciones' => $request->observaciones,
                'created_by' => auth()->id()
            ]);
            
            Log::info('Asignación creada con ID: ' . $asignacion->id);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'data' => $asignacion,
                'message' => 'Personal asignado correctamente'
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al crear asignación: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al asignar personal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualiza una asignación existente
     */
    public function update(AsignacionPersonalRequest $request, $id)
    {
        Log::info('=== PERSONAL ASIGNADO: Actualizando ID: ' . $id);
        Log::info('Datos:', $request->all());
        
        try {
            DB::beginTransaction();
            
            $asignacion = AsignacionPersonal::findOrFail($id);
            
            // Verificar que no haya duplicados
            if ($request->status === 'activo') {
                $existe = AsignacionPersonal::where('empleado_id', $request->empleado_id)
                    ->where('proyecto_id', $request->proyecto_id)
                    ->where('status', 'activo')
                    ->where('id', '!=', $id)
                    ->exists();
                
                if ($existe) {
                    return response()->json([
                        'success' => false,
                        'message' => 'El empleado ya está activo en este proyecto'
                    ], 422);
                }
            }
            
            $asignacion->update([
                'empleado_id' => $request->empleado_id,
                'proyecto_id' => $request->proyecto_id,
                'tipo_personal' => $request->tipo_personal,
                'rol' => $request->rol,
                'fecha_asignacion' => $request->fecha_asignacion,
                'fecha_fin' => $request->fecha_fin,
                'salario_diario' => $request->salario_diario,
                'status' => $request->status,
                'observaciones' => $request->observaciones
            ]);
            
            Log::info('Asignación actualizada ID: ' . $asignacion->id);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'data' => $asignacion,
                'message' => 'Asignación actualizada correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al actualizar asignación: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la asignación: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina una asignación (soft delete)
     */
    public function destroy($id)
    {
        Log::info('=== PERSONAL ASIGNADO: Eliminando ID: ' . $id);
        
        try {
            $asignacion = AsignacionPersonal::findOrFail($id);
            $asignacion->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Asignación eliminada correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al eliminar asignación: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la asignación'
            ], 500);
        }
    }

    /**
     * Cambia el status de una asignación
     */
    public function cambiarStatus(Request $request, $id)
    {
        Log::info('=== PERSONAL ASIGNADO: Cambiando status ID: ' . $id . ' a: ' . $request->status);
        
        try {
            $asignacion = AsignacionPersonal::findOrFail($id);
            
            if (!$asignacion->cambiarStatus($request->status, $request->observaciones)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status no válido'
                ], 400);
            }
            
            return response()->json([
                'success' => true,
                'data' => $asignacion,
                'message' => 'Status actualizado a: ' . $asignacion->status_nombre
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al cambiar status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el status'
            ], 500);
        }
    }

    /**
     * Reasigna un empleado a otro proyecto
     */
    public function reasignar(Request $request, $id)
    {
        Log::info('=== PERSONAL ASIGNADO: Reasignando ID: ' . $id . ' a proyecto: ' . $request->proyecto_id);
        
        try {
            $asignacion = AsignacionPersonal::findOrFail($id);
            
            // Verificar que no esté activo en el nuevo proyecto
            $existe = AsignacionPersonal::where('empleado_id', $asignacion->empleado_id)
                ->where('proyecto_id', $request->proyecto_id)
                ->where('status', 'activo')
                ->where('id', '!=', $id)
                ->exists();
            
            if ($existe) {
                return response()->json([
                    'success' => false,
                    'message' => 'El empleado ya está activo en el proyecto destino'
                ], 422);
            }
            
            $asignacion->reasignar($request->proyecto_id, $request->observaciones);
            
            return response()->json([
                'success' => true,
                'data' => $asignacion,
                'message' => 'Empleado reasignado correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al reasignar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al reasignar: ' . $e->getMessage()
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
     * Exporta asignaciones a Excel/CSV
     */
    public function exportar(Request $request)
    {
        Log::info('=== PERSONAL ASIGNADO: Exportando datos ===');
        
        try {
            $query = AsignacionPersonal::with(['empleado', 'proyecto']);
            
            if ($request->filled('busqueda')) {
                $query->buscar($request->busqueda);
            }
            
            if ($request->filled('proyecto_id')) {
                $proyectos = $request->input('proyecto_id');
                if (is_array($proyectos) && count($proyectos) > 0) {
                    $proyectosFiltrados = array_filter($proyectos, function($value) {
                        return $value !== '' && $value !== null;
                    });
                    if (count($proyectosFiltrados) > 0) {
                        $query->whereIn('proyecto_id', $proyectosFiltrados);
                    }
                } elseif (!is_array($proyectos) && $proyectos !== '' && $proyectos !== null) {
                    $query->where('proyecto_id', $proyectos);
                }
            }
            
            if ($request->filled('tipo_personal') && $request->tipo_personal !== 'todos') {
                $query->byTipo($request->tipo_personal);
            }
            
            $asignaciones = $query->orderBy('created_at', 'desc')->get();
            
            $headers = ['No. Empleado', 'Nombre', 'Tipo', 'Proyecto', 'Rol', 'Fecha Asignación', 'Fecha Fin', 'Salario Diario', 'Status'];
            $rows = $asignaciones->map(function($asignacion) {
                return [
                    $asignacion->empleado?->numero_empleado_interno ?? $asignacion->empleado_id,
                    $asignacion->nombre_completo,
                    $asignacion->tipo_nombre,
                    $asignacion->proyecto?->codigo . ' - ' . $asignacion->proyecto?->nombre,
                    $asignacion->rol,
                    $asignacion->fecha_asignacion?->format('d/m/Y'),
                    $asignacion->fecha_fin?->format('d/m/Y') ?? 'Activo',
                    '$' . number_format($asignacion->salario_diario, 2),
                    $asignacion->status_nombre
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => [
                    'headers' => $headers,
                    'rows' => $rows,
                    'total' => $asignaciones->count(),
                    'total_salarios' => $asignaciones->where('status', 'activo')->sum('salario_diario')
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
     * Obtiene lista de empleados para selects
     */
    public function empleados()
    {
        try {
            $empleados = Plantilla::where('estatus', 'Activo')
                ->select('plantilla_id as id', 'nombre', 'apellido_paterno', 'apellido_materno', 'numero_empleado_interno')
                ->orderBy('nombre')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nombre_completo' => trim($item->nombre . ' ' . ($item->apellido_paterno ?? '') . ' ' . ($item->apellido_materno ?? '')),
                        'numero_empleado' => $item->numero_empleado_interno ?? $item->id
                    ];
                });
            
            return response()->json([
                'success' => true,
                'data' => $empleados
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener empleados: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Error al obtener empleados'
            ]);
        }
    }

    /**
     * Obtiene lista de proyectos para selects
     */
    public function proyectos()
    {
        try {
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
            
            return response()->json([
                'success' => true,
                'data' => $proyectos
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener proyectos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Error al obtener proyectos'
            ]);
        }
    }

    /**
     * Obtiene lista de puestos/roles para selects
     */
    public function puestos()
    {
        try {
            $puestos = Puesto::where('estatus', 'activo')
                ->select('id', 'folio', 'nombre')
                ->orderBy('nombre')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nombre' => $item->folio . ' - ' . $item->nombre
                    ];
                });
            
            return response()->json([
                'success' => true,
                'data' => $puestos
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener puestos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Error al obtener puestos'
            ]);
        }
    }

    // ==================== MÉTODOS PRIVADOS ====================

    /**
     * Calcula las estadísticas para los 4 cuadros
     */
    private function calcularEstadisticas(Request $request): array
    {
        try {
            $query = AsignacionPersonal::query();
            
            if ($request->filled('proyecto_id')) {
                $proyectos = $request->input('proyecto_id');
                if (is_array($proyectos) && count($proyectos) > 0) {
                    $proyectosFiltrados = array_filter($proyectos, function($value) {
                        return $value !== '' && $value !== null;
                    });
                    if (count($proyectosFiltrados) > 0) {
                        $query->whereIn('proyecto_id', $proyectosFiltrados);
                    }
                } elseif (!is_array($proyectos) && $proyectos !== '' && $proyectos !== null) {
                    $query->where('proyecto_id', $proyectos);
                }
            }
            
            if ($request->filled('tipo_personal') && $request->tipo_personal !== 'todos') {
                $query->byTipo($request->tipo_personal);
            }

            $total = (clone $query)->count();
            $enObra = (clone $query)->where('status', 'activo')
                ->whereIn('tipo_personal', ['obrero', 'operador', 'supervisor'])
                ->count();
            $administrativos = (clone $query)->whereIn('tipo_personal', ['administrativo', 'ingeniero'])->count();
            
            // Costo mensual (considerando 24 días)
            $costoTotal = (clone $query)->where('status', 'activo')->sum('salario_diario') * 24;

            return [
                'total_personal' => $total,
                'en_obra' => $enObra,
                'administrativos' => $administrativos,
                'costo_mensual' => $costoTotal,
                'costo_mensual_formateado' => '$' . number_format($costoTotal / 1000, 1) . 'K',
                'activos' => (clone $query)->where('status', 'activo')->count(),
                'inactivos' => (clone $query)->where('status', 'inactivo')->count(),
                'vacaciones' => (clone $query)->where('status', 'vacaciones')->count(),
                'permiso' => (clone $query)->where('status', 'permiso')->count()
            ];
            
        } catch (\Exception $e) {
            Log::error('ERROR calcularEstadisticas: ' . $e->getMessage());
            return [
                'total_personal' => 0,
                'en_obra' => 0,
                'administrativos' => 0,
                'costo_mensual' => 0,
                'costo_mensual_formateado' => '$0K',
                'activos' => 0,
                'inactivos' => 0,
                'vacaciones' => 0,
                'permiso' => 0
            ];
        }
    }
}