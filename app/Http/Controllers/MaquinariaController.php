<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\ActivoMaquinaria;
use App\Models\ActivoVehiculo;
use App\Models\ActivoHerramienta;
use App\Models\AsignacionActivo;
use App\Models\MantenimientoActivo;
use App\Models\CombustibleActivo;
use App\Models\Proyecto;
use App\Models\Plantilla;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MaquinariaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la vista principal de Maquinaria y Equipo
     */
    public function maquinas()
    {
        Log::info('=== MAQUINARIA Y EQUIPO: Cargando vista ===');
        return view('proyectos.maquinaria.asignacion');
    }

    /**
     * Obtiene todos los activos con filtros (para AJAX)
     */
    public function index(Request $request)
    {
        Log::info('=== MAQUINARIA INDEX ===');
        Log::info('Filtros recibidos:', $request->all());
        
        try {
            $query = Activo::with(['maquinaria', 'vehiculo', 'herramienta', 'proyectoAsignado', 'responsableAsignado']);

            if ($request->filled('busqueda')) {
                $query->buscar($request->busqueda);
            }

            if ($request->filled('tipo')) {
                $query->byTipo($request->tipo);
            }

            if ($request->filled('estatus')) {
                $query->byEstatus($request->estatus);
            }

            if ($request->filled('proyecto_id')) {
                $query->byProyecto($request->proyecto_id);
            }

            if ($request->filled('horometro_min') && $request->filled('horometro_max')) {
                $query->byRangoHorometro($request->horometro_min, $request->horometro_max);
            }

            $perPage = $request->get('per_page', 10);
            $activos = $query->orderBy('created_at', 'desc')->paginate($perPage);
            $estadisticas = $this->calcularEstadisticas($request);

            return response()->json([
                'success' => true,
                'data' => $activos,
                'estadisticas' => $estadisticas,
                'filtros_aplicados' => [
                    'tipo' => $request->input('tipo'),
                    'estatus' => $request->input('estatus'),
                    'proyecto_id' => $request->input('proyecto_id')
                ],
                'message' => 'Activos obtenidos correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en index Maquinaria: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener activos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene un activo específico por ID
     */
    public function show($id)
    {
        Log::info('=== MAQUINARIA: Mostrando detalle ID: ' . $id);
        
        try {
            $activo = Activo::with([
                'maquinaria', 
                'vehiculo', 
                'herramienta', 
                'proyectoAsignado', 
                'responsableAsignado',
                'proveedor',
                'creador',
                'asignaciones' => function($q) {
                    $q->orderBy('fecha_salida', 'desc')->limit(5);
                },
                'mantenimientos' => function($q) {
                    $q->orderBy('fecha_inicio', 'desc')->limit(5);
                },
                'combustibles' => function($q) {
                    $q->orderBy('fecha', 'desc')->limit(10);
                }
            ])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $activo,
                'message' => 'Activo obtenido correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al mostrar activo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Activo no encontrado'
            ], 404);
        }
    }

    /**
     * Almacena un nuevo activo
     */
    public function store(Request $request)
    {
        Log::info('=== MAQUINARIA: Creando nuevo activo ===');
        Log::info('Datos recibidos:', $request->all());
        
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'tipo_activo' => 'required|in:maquinaria,vehiculo,herramienta,equipo',
                'categoria' => 'nullable|string|max:100',
                'marca' => 'nullable|string|max:100',
                'modelo' => 'nullable|string|max:100',
                'serie' => 'nullable|string|max:100',
                'anio' => 'nullable|integer|min:1900|max:' . date('Y'),
                'costo_adquisicion' => 'nullable|numeric|min:0',
                'costo_operacion_hora' => 'nullable|numeric|min:0',
                'proveedor_id' => 'nullable|exists:proveedores,id',
                'estado_general' => 'nullable|in:excelente,bueno,regular,malo,reparacion'
            ]);

            DB::beginTransaction();

            $activo = Activo::create([
                'codigo' => $request->codigo ?? Activo::generarCodigo($request->tipo_activo),
                'nombre' => $request->nombre,
                'tipo_activo' => $request->tipo_activo,
                'categoria' => $request->categoria,
                'marca' => $request->marca,
                'modelo' => $request->modelo,
                'serie' => $request->serie,
                'anio' => $request->anio,
                'color' => $request->color,
                'ubicacion_fisica' => $request->ubicacion_fisica,
                'estado_general' => $request->estado_general ?? 'bueno',
                'estatus' => 'activo',
                'fecha_adquisicion' => $request->fecha_adquisicion,
                'costo_adquisicion' => $request->costo_adquisicion ?? 0,
                'costo_operacion_hora' => $request->costo_operacion_hora ?? 0,
                'consumo_promedio' => $request->consumo_promedio,
                'proveedor_id' => $request->proveedor_id,
                'factura' => $request->factura,
                'cuenta_contable' => $request->cuenta_contable,
                'descripcion' => $request->descripcion,
                'observaciones' => $request->observaciones,
                'created_by' => auth()->id(),
                'unidad_negocio_id' => $request->unidad_negocio_id
            ]);

            Log::info('Activo creado con ID: ' . $activo->id . ' y código: ' . $activo->codigo);

            if ($request->tipo_activo === 'maquinaria') {
                $this->crearMaquinaria($request, $activo->id);
            } elseif ($request->tipo_activo === 'vehiculo') {
                $this->crearVehiculo($request, $activo->id);
            } elseif ($request->tipo_activo === 'herramienta') {
                $this->crearHerramienta($request, $activo->id);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $activo->load(['maquinaria', 'vehiculo', 'herramienta']),
                'message' => 'Activo creado correctamente'
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Error de validación: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al crear activo: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el activo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualiza un activo existente
     */
    public function update(Request $request, $id)
    {
        Log::info('=== MAQUINARIA: Actualizando ID: ' . $id);
        Log::info('Datos:', $request->all());
        
        try {
            DB::beginTransaction();

            $activo = Activo::findOrFail($id);
            
            $activo->update([
                'nombre' => $request->nombre ?? $activo->nombre,
                'categoria' => $request->categoria ?? $activo->categoria,
                'marca' => $request->marca ?? $activo->marca,
                'modelo' => $request->modelo ?? $activo->modelo,
                'serie' => $request->serie ?? $activo->serie,
                'anio' => $request->anio ?? $activo->anio,
                'color' => $request->color ?? $activo->color,
                'ubicacion_fisica' => $request->ubicacion_fisica ?? $activo->ubicacion_fisica,
                'estado_general' => $request->estado_general ?? $activo->estado_general,
                'estatus' => $request->estatus ?? $activo->estatus,
                'costo_operacion_hora' => $request->costo_operacion_hora ?? $activo->costo_operacion_hora,
                'consumo_promedio' => $request->consumo_promedio ?? $activo->consumo_promedio,
                'proveedor_id' => $request->proveedor_id ?? $activo->proveedor_id,
                'descripcion' => $request->descripcion ?? $activo->descripcion,
                'observaciones' => $request->observaciones ?? $activo->observaciones
            ]);

            Log::info('Activo actualizado ID: ' . $activo->id);

            if ($request->tipo_activo === 'maquinaria') {
                $this->actualizarMaquinaria($request, $activo->id);
            } elseif ($request->tipo_activo === 'vehiculo') {
                $this->actualizarVehiculo($request, $activo->id);
            } elseif ($request->tipo_activo === 'herramienta') {
                $this->actualizarHerramienta($request, $activo->id);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $activo->load(['maquinaria', 'vehiculo', 'herramienta']),
                'message' => 'Activo actualizado correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al actualizar activo: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el activo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina un activo (soft delete)
     */
    public function destroy($id)
    {
        Log::info('=== MAQUINARIA: Eliminando ID: ' . $id);
        
        try {
            $activo = Activo::findOrFail($id);
            $activo->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Activo eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al eliminar activo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el activo'
            ], 500);
        }
    }

    /**
     * Asigna un activo a un proyecto
     */
    public function asignar(Request $request)
    {
        Log::info('=== MAQUINARIA: Asignando activo a proyecto ===');
        Log::info('Datos:', $request->all());
        
        try {
            $request->validate([
                'activo_id' => 'required|exists:activos,id',
                'proyecto_id' => 'required|exists:proyectos,id',
                'responsable_asignado' => 'nullable|string|max:255',
                'fecha_salida' => 'required|date',
                'fecha_estimada_devolucion' => 'nullable|date|after_or_equal:fecha_salida',
                'horometro_salida' => 'nullable|numeric|min:0',
                'kilometraje_salida' => 'nullable|numeric|min:0',
                'condicion_salida' => 'nullable|in:excelente,bueno,regular,malo,danado'
            ]);

            DB::beginTransaction();

            $activo = Activo::findOrFail($request->activo_id);

            if (!$activo->esta_disponible) {
                return response()->json([
                    'success' => false,
                    'message' => 'El activo no está disponible para asignación'
                ], 422);
            }

            $asignacion = AsignacionActivo::create([
                'activo_id' => $request->activo_id,
                'proyecto_id' => $request->proyecto_id,
                'responsable_asignado' => $request->responsable_asignado,
                'fecha_salida' => $request->fecha_salida,
                'fecha_estimada_devolucion' => $request->fecha_estimada_devolucion,
                'horometro_salida' => $request->horometro_salida,
                'kilometraje_salida' => $request->kilometraje_salida,
                'condicion_salida' => $request->condicion_salida ?? 'bueno',
                'observaciones_salida' => $request->observaciones,
                'estatus' => 'activa'
            ]);

            $activo->proyecto_asignado_id = $request->proyecto_id;
            $activo->fecha_asignacion = $request->fecha_salida;
            $activo->responsable_asignado_id = $request->responsable_asignado_id;
            $activo->estatus = 'activo';
            $activo->save();

            if ($activo->maquinaria && $request->horometro_salida) {
                $activo->maquinaria->horometro_actual = $request->horometro_salida;
                $activo->maquinaria->save();
            }

            if ($activo->vehiculo && $request->kilometraje_salida) {
                $activo->vehiculo->kilometraje_actual = $request->kilometraje_salida;
                $activo->vehiculo->save();
            }

            Log::info('Activo asignado ID: ' . $activo->id . ' al proyecto ID: ' . $request->proyecto_id);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $asignacion->load(['activo', 'proyecto']),
                'message' => 'Activo asignado correctamente'
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al asignar activo: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al asignar el activo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Devuelve un activo de un proyecto
     */
    public function devolver(Request $request, $id)
    {
        Log::info('=== MAQUINARIA: Devolviendo activo ID: ' . $id);
        
        try {
            DB::beginTransaction();

            $asignacion = AsignacionActivo::with(['activo'])->findOrFail($id);
            
            if ($asignacion->estatus !== 'activa' && $asignacion->estatus !== 'asignado') {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta asignación ya fue finalizada'
                ], 422);
            }

            $data = [
                'fecha_devolucion_real' => $request->fecha_devolucion_real ?? now(),
                'horometro_devolucion' => $request->horometro_devolucion,
                'kilometraje_devolucion' => $request->kilometraje_devolucion,
                'condicion_devolucion' => $request->condicion_devolucion ?? 'bueno',
                'observaciones_devolucion' => $request->observaciones,
                'estatus' => 'devuelto'
            ];

            if ($request->reporte_danos) {
                $data['reporte_danos'] = $request->reporte_danos;
            }

            if ($request->costo_reparacion) {
                $data['costo_reparacion'] = $request->costo_reparacion;
            }

            $asignacion->devolver($data);

            $activo = $asignacion->activo;
            $activo->proyecto_asignado_id = null;
            $activo->fecha_asignacion = null;
            $activo->responsable_asignado_id = null;
            
            if ($asignacion->condicion_devolucion === 'danado') {
                $activo->estatus = 'mantenimiento';
            } else {
                $activo->estatus = 'activo';
            }
            $activo->save();

            Log::info('Activo devuelto ID: ' . $activo->id);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $asignacion,
                'message' => 'Activo devuelto correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al devolver activo: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al devolver el activo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene todas las asignaciones activas
     */
    public function asignacionesActivas(Request $request)
    {
        try {
            $query = AsignacionActivo::with(['activo', 'proyecto'])
                ->whereIn('estatus', ['activa', 'asignado']);

            if ($request->filled('proyecto_id')) {
                $query->byProyecto($request->proyecto_id);
            }

            $asignaciones = $query->orderBy('fecha_salida', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => $asignaciones,
                'message' => 'Asignaciones activas obtenidas correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener asignaciones activas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener asignaciones activas'
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
     * Exporta activos a Excel/CSV
     */
    public function exportar(Request $request)
    {
        Log::info('=== MAQUINARIA: Exportando datos ===');
        
        try {
            $query = Activo::with(['maquinaria', 'vehiculo', 'proyectoAsignado']);

            if ($request->filled('busqueda')) {
                $query->buscar($request->busqueda);
            }

            if ($request->filled('tipo')) {
                $query->byTipo($request->tipo);
            }

            if ($request->filled('estatus')) {
                $query->byEstatus($request->estatus);
            }

            $activos = $query->orderBy('created_at', 'desc')->get();
            
            $headers = ['Código', 'Nombre', 'Tipo', 'Marca', 'Modelo', 'Año', 'Serie', 'Estado', 'Proyecto', 'Costo Adq.', 'Costo Op./Hora'];
            $rows = $activos->map(function($item) {
                return [
                    $item->codigo,
                    $item->nombre,
                    $item->tipo_nombre,
                    $item->marca ?? '-',
                    $item->modelo ?? '-',
                    $item->anio ?? '-',
                    $item->serie ?? '-',
                    $item->estado_general_nombre,
                    $item->proyectoAsignado?->nombre ?? 'Disponible',
                    '$' . number_format($item->costo_adquisicion, 2),
                    '$' . number_format($item->costo_operacion_hora, 2)
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => [
                    'headers' => $headers,
                    'rows' => $rows,
                    'total' => $activos->count()
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
            $equipos = Activo::whereIn('estatus', ['activo', 'disponible'])
                ->select('id', 'codigo', 'nombre', 'tipo_activo', 'estatus')
                ->orderBy('codigo')
                ->get()
                ->map(function($item) {
                    $tipoNombres = [
                        'maquinaria' => 'Maquinaria',
                        'vehiculo' => 'Vehículo',
                        'herramienta' => 'Herramienta',
                        'equipo' => 'Equipo'
                    ];
                    return [
                        'id' => $item->id,
                        'codigo' => $item->codigo,
                        'nombre' => $item->nombre,
                        'tipo' => $tipoNombres[$item->tipo_activo] ?? $item->tipo_activo,
                        'estatus' => $item->estatus,
                        'label' => $item->codigo . ' - ' . $item->nombre
                    ];
                });

            $todosEquipos = Activo::select('id', 'codigo', 'nombre', 'tipo_activo', 'estatus')
                ->orderBy('codigo')
                ->get()
                ->map(function($item) {
                    $tipoNombres = [
                        'maquinaria' => 'Maquinaria',
                        'vehiculo' => 'Vehículo',
                        'herramienta' => 'Herramienta',
                        'equipo' => 'Equipo'
                    ];
                    return [
                        'id' => $item->id,
                        'codigo' => $item->codigo,
                        'nombre' => $item->nombre,
                        'tipo' => $tipoNombres[$item->tipo_activo] ?? $item->tipo_activo,
                        'estatus' => $item->estatus,
                        'label' => $item->codigo . ' - ' . $item->nombre
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

            $responsables = Plantilla::where('estatus', 'Activo')
                ->select('plantilla_id as id', 'nombre', 'apellido_paterno', 'apellido_materno')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nombre_completo' => trim($item->nombre . ' ' . ($item->apellido_paterno ?? '') . ' ' . ($item->apellido_materno ?? ''))
                    ];
                });

            $operadores = Plantilla::where('estatus', 'Activo')
                ->select('plantilla_id as id', 'nombre', 'apellido_paterno', 'apellido_materno')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nombre_completo' => trim($item->nombre . ' ' . ($item->apellido_paterno ?? '') . ' ' . ($item->apellido_materno ?? ''))
                    ];
                });

            $proveedores = Proveedor::where('activo', true)
                ->select('id', 'nombre', 'rfc')
                ->orderBy('nombre')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nombre' => $item->nombre . ($item->rfc ? ' (' . $item->rfc . ')' : '')
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => [
                    'equipos' => $equipos,
                    'todos_equipos' => $todosEquipos,
                    'proyectos' => $proyectos,
                    'responsables' => $responsables,
                    'operadores' => $operadores,
                    'proveedores' => $proveedores
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('ERROR al obtener catálogos: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener catálogos: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==================== MÉTODOS DE MANTENIMIENTO ====================

    /**
     * Obtiene estadísticas para el dashboard de mantenimiento
     */
    public function getEstadisticasMantenimiento(Request $request)
    {
        try {
            Log::info('=== getEstadisticasMantenimiento ===');
            
            $query = MantenimientoActivo::query();

            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }

            $enMantenimiento = (clone $query)
                ->whereIn('estatus', ['en_proceso', 'pendiente'])
                ->count();

            $programados = (clone $query)
                ->where('estatus', 'pendiente')
                ->whereDate('fecha_inicio', '>=', Carbon::now()->startOfDay())
                ->count();

            $completados = (clone $query)
                ->where('estatus', 'completado')
                ->whereMonth('fecha_fin', Carbon::now()->month)
                ->whereYear('fecha_fin', Carbon::now()->year)
                ->count();

            $costoMensual = (clone $query)
                ->whereMonth('fecha_inicio', Carbon::now()->month)
                ->whereYear('fecha_inicio', Carbon::now()->year)
                ->sum('costo');

            return response()->json([
                'success' => true,
                'data' => [
                    'en_mantenimiento' => $enMantenimiento,
                    'programados' => $programados,
                    'completados' => $completados,
                    'costo_mensual' => number_format($costoMensual, 2)
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getEstadisticasMantenimiento: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene mantenimientos activos (en proceso + pendientes)
     */
    public function getMantenimientosActivos(Request $request)
    {
        try {
            Log::info('=== getMantenimientosActivos ===');
            
            $query = MantenimientoActivo::with(['activo', 'proyecto', 'responsable'])
                ->whereIn('estatus', ['en_proceso', 'pendiente'])
                ->orderBy('fecha_inicio', 'desc');

            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }

            if ($request->filled('tipo')) {
                $query->where('tipo_mantenimiento', $request->tipo);
            }

            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }

            $mantenimientos = $query->get();

            // Calcular avance para cada uno
            foreach ($mantenimientos as $item) {
                $item->avance = $this->calcularAvanceMantenimiento($item);
            }

            return response()->json([
                'success' => true,
                'data' => $mantenimientos
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getMantenimientosActivos: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener mantenimientos activos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene mantenimientos programados
     */
    public function getMantenimientosProgramados(Request $request)
    {
        try {
            Log::info('=== getMantenimientosProgramados ===');
            
            $query = MantenimientoActivo::with(['activo', 'proyecto', 'responsable'])
                ->where('estatus', 'pendiente')
                ->whereDate('fecha_inicio', '>=', Carbon::now()->startOfDay())
                ->orderBy('fecha_inicio', 'asc');

            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }

            $programados = $query->get();

            $proximos7Dias = (clone $query)
                ->whereDate('fecha_inicio', '<=', Carbon::now()->addDays(7))
                ->get();

            $porTipo = MantenimientoActivo::where('estatus', 'pendiente')
                ->whereDate('fecha_inicio', '>=', Carbon::now()->startOfDay())
                ->select('tipo_mantenimiento', DB::raw('count(*) as total'))
                ->groupBy('tipo_mantenimiento')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'programados' => $programados,
                    'proximos_7_dias' => $proximos7Dias,
                    'por_tipo' => $porTipo
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getMantenimientosProgramados: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener mantenimientos programados: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene historial de mantenimientos
     */
    public function getHistorialMantenimientos(Request $request)
    {
        try {
            Log::info('=== getHistorialMantenimientos ===');
            
            $query = MantenimientoActivo::with(['activo', 'proyecto', 'responsable'])
                ->where('estatus', 'completado')
                ->orderBy('fecha_fin', 'desc');

            if ($request->filled('periodo')) {
                $dias = (int) $request->periodo;
                $query->whereDate('fecha_fin', '>=', Carbon::now()->subDays($dias));
            }

            if ($request->filled('tipo')) {
                $query->where('tipo_mantenimiento', $request->tipo);
            }

            $perPage = $request->get('per_page', 10);
            $historial = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $historial
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getHistorialMantenimientos: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener historial: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene costos de mantenimiento
     */
    public function getCostosMantenimiento(Request $request)
    {
        try {
            Log::info('=== getCostosMantenimiento ===');
            
            $costosMensuales = MantenimientoActivo::where('estatus', 'completado')
                ->whereYear('fecha_fin', Carbon::now()->year)
                ->select(
                    DB::raw('EXTRACT(MONTH FROM fecha_fin) as mes'),
                    DB::raw('SUM(costo) as total')
                )
                ->groupBy('mes')
                ->orderBy('mes')
                ->get();

            $distribucion = MantenimientoActivo::where('estatus', 'completado')
                ->whereYear('fecha_fin', Carbon::now()->year)
                ->select('tipo_mantenimiento', DB::raw('SUM(costo) as total'))
                ->groupBy('tipo_mantenimiento')
                ->get();

            $costosPorEquipo = MantenimientoActivo::with('activo')
                ->where('estatus', 'completado')
                ->whereYear('fecha_fin', Carbon::now()->year)
                ->select(
                    'activo_id',
                    DB::raw('COUNT(*) as total_manttos'),
                    DB::raw('SUM(costo) as costo_total'),
                    DB::raw('AVG(costo) as promedio'),
                    DB::raw('MAX(fecha_fin) as ultimo_mantto')
                )
                ->groupBy('activo_id')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'costos_mensuales' => $costosMensuales,
                    'distribucion' => $distribucion,
                    'costos_por_equipo' => $costosPorEquipo
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getCostosMantenimiento: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener costos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene alertas de mantenimiento
     */
    public function getAlertasMantenimiento(Request $request)
    {
        try {
            Log::info('=== getAlertasMantenimiento ===');
            
            $criticas = MantenimientoActivo::with(['activo', 'proyecto'])
                ->where('estatus', 'pendiente')
                ->whereDate('fecha_inicio', '<', Carbon::now()->startOfDay())
                ->orderBy('fecha_inicio', 'asc')
                ->get();

            $preventivas = MantenimientoActivo::with(['activo', 'proyecto'])
                ->where('estatus', 'pendiente')
                ->whereDate('fecha_inicio', '>=', Carbon::now()->startOfDay())
                ->whereDate('fecha_inicio', '<=', Carbon::now()->addDays(7))
                ->orderBy('fecha_inicio', 'asc')
                ->get();

            $informacion = Activo::with(['maquinaria'])
                ->whereHas('maquinaria')
                ->where('estatus', 'activo')
                ->get()
                ->filter(function($activo) {
                    if ($activo->maquinaria && $activo->maquinaria->horometro_actual) {
                        $horas = $activo->maquinaria->horometro_actual;
                        $proximo = $activo->maquinaria->horometro_proximo_mantenimiento ?? 500;
                        $diferencia = $proximo - $horas;
                        return $diferencia <= 50 && $diferencia > 0;
                    }
                    return false;
                })
                ->values();

            return response()->json([
                'success' => true,
                'data' => [
                    'criticas' => $criticas,
                    'preventivas' => $preventivas,
                    'informacion' => $informacion
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getAlertasMantenimiento: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener alertas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Listado de mantenimientos con filtros
     */
    public function getListadoMantenimientos(Request $request)
    {
        try {
            Log::info('=== getListadoMantenimientos ===');
            
            $query = MantenimientoActivo::with(['activo', 'proyecto', 'responsable'])
                ->orderBy('created_at', 'desc');

            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }

            if ($request->filled('tipo')) {
                $query->where('tipo_mantenimiento', $request->tipo);
            }

            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }

            if ($request->filled('busqueda')) {
                $busqueda = $request->busqueda;
                $query->whereHas('activo', function($sub) use ($busqueda) {
                    $sub->where('codigo', 'ILIKE', "%{$busqueda}%")
                        ->orWhere('nombre', 'ILIKE', "%{$busqueda}%");
                });
            }

            $perPage = $request->get('per_page', 10);
            $mantenimientos = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $mantenimientos
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getListadoMantenimientos: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener mantenimientos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Registra un nuevo mantenimiento
     */
    public function storeMantenimiento(Request $request)
    {
        try {
            Log::info('=== storeMantenimiento ===');
            Log::info('Datos:', $request->all());
            
            $request->validate([
                'activo_id' => 'required|exists:activos,id',
                'tipo_mantenimiento' => 'required|in:preventivo,correctivo,predictivo',
                'descripcion' => 'required|string',
                'fecha_inicio' => 'required|date',
                'fecha_fin_estimada' => 'nullable|date|after_or_equal:fecha_inicio',
                'responsable_asignado' => 'nullable|string|max:255',
                'costo' => 'nullable|numeric|min:0',
                'prioridad' => 'nullable|in:alta,media,baja',
                'proyecto_id' => 'nullable|exists:proyectos,id'
            ]);

            DB::beginTransaction();

            $mantenimiento = MantenimientoActivo::create([
                'activo_id' => $request->activo_id,
                'proyecto_id' => $request->proyecto_id,
                'tipo_mantenimiento' => $request->tipo_mantenimiento,
                'descripcion' => $request->descripcion,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin_estimada' => $request->fecha_fin_estimada,
                'responsable_asignado' => $request->responsable_asignado,
                'costo' => $request->costo ?? 0,
                'prioridad' => $request->prioridad ?? 'media',
                'estatus' => 'pendiente',
                'created_by' => auth()->id()
            ]);

            DB::commit();

            Log::info('Mantenimiento creado ID: ' . $mantenimiento->id);

            return response()->json([
                'success' => true,
                'data' => $mantenimiento,
                'message' => 'Mantenimiento registrado correctamente'
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en storeMantenimiento: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar mantenimiento: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene detalle de un mantenimiento
     */
    public function getDetalleMantenimiento($id)
    {
        try {
            Log::info('=== getDetalleMantenimiento ID: ' . $id);
            
            $mantenimiento = MantenimientoActivo::with([
                'activo',
                'activo.maquinaria',
                'activo.vehiculo',
                'proyecto',
                'responsable',
                'proveedor',
                'creador'
            ])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $mantenimiento
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getDetalleMantenimiento: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener detalle del mantenimiento'
            ], 404);
        }
    }

    /**
     * Inicia un mantenimiento
     */
    public function iniciarMantenimiento($id, Request $request)
    {
        try {
            Log::info('=== iniciarMantenimiento ID: ' . $id);
            
            $mantenimiento = MantenimientoActivo::findOrFail($id);
            
            $mantenimiento->estatus = 'en_proceso';
            $mantenimiento->fecha_inicio_real = Carbon::now();
            $mantenimiento->save();

            $activo = Activo::find($mantenimiento->activo_id);
            if ($activo) {
                $activo->estatus = 'En mantenimiento';
                $activo->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Mantenimiento iniciado correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error en iniciarMantenimiento: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al iniciar mantenimiento: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Completa un mantenimiento
     */
    public function completarMantenimiento($id, Request $request)
    {
        try {
            Log::info('=== completarMantenimiento ID: ' . $id);
            
            $request->validate([
                'fecha_fin' => 'nullable|date',
                'costo_real' => 'nullable|numeric|min:0',
                'observaciones' => 'nullable|string'
            ]);

            $mantenimiento = MantenimientoActivo::findOrFail($id);
            
            $mantenimiento->estatus = 'completado';
            $mantenimiento->fecha_fin = $request->fecha_fin ?? Carbon::now();
            $mantenimiento->costo = $request->costo_real ?? $mantenimiento->costo;
            $mantenimiento->observaciones = $request->observaciones;
            $mantenimiento->save();

            $activo = Activo::find($mantenimiento->activo_id);
            if ($activo) {
                $activo->estatus = 'Disponible';
                $activo->save();

                if ($activo->maquinaria && $mantenimiento->horometro_actual) {
                    $activo->maquinaria->horometro_actual = $mantenimiento->horometro_actual;
                    if ($mantenimiento->horometro_proximo) {
                        $activo->maquinaria->horometro_proximo_mantenimiento = $mantenimiento->horometro_proximo;
                    }
                    $activo->maquinaria->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Mantenimiento completado correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error en completarMantenimiento: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al completar mantenimiento: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Registra un mantenimiento para un activo (desde la vista de maquinaria)
     */
    public function registrarMantenimiento(Request $request)
    {
        Log::info('=== MAQUINARIA: Registrando mantenimiento ===');
        Log::info('Datos:', $request->all());
        
        try {
            $request->validate([
                'activo_id' => 'required|exists:activos,id',
                'tipo_mantenimiento' => 'required|in:preventivo,correctivo,predictivo',
                'descripcion' => 'required|string',
                'fecha_inicio' => 'required|date',
                'costo' => 'nullable|numeric|min:0',
                'horometro_actual' => 'nullable|numeric|min:0',
                'horometro_proximo' => 'nullable|numeric|min:0',
                'dias_proximo' => 'nullable|integer|min:1',
                'proveedor_id' => 'nullable|exists:proveedores,id',
                'responsable_id' => 'nullable|exists:plantillas,plantilla_id'
            ]);

            DB::beginTransaction();

            $mantenimiento = MantenimientoActivo::create([
                'activo_id' => $request->activo_id,
                'proveedor_id' => $request->proveedor_id,
                'responsable_id' => $request->responsable_id,
                'created_by' => auth()->id(),
                'tipo_mantenimiento' => $request->tipo_mantenimiento,
                'descripcion' => $request->descripcion,
                'fecha_inicio' => $request->fecha_inicio,
                'costo' => $request->costo ?? 0,
                'horometro_actual' => $request->horometro_actual,
                'horometro_proximo' => $request->horometro_proximo,
                'dias_proximo' => $request->dias_proximo,
                'estatus' => $request->estatus ?? 'pendiente',
                'observaciones' => $request->observaciones
            ]);

            $activo = Activo::find($request->activo_id);
            $activo->estatus = 'En mantenimiento';
            $activo->save();

            Log::info('Mantenimiento registrado ID: ' . $mantenimiento->id . ' para activo ID: ' . $request->activo_id);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $mantenimiento->load(['activo', 'proveedor', 'responsable']),
                'message' => 'Mantenimiento registrado correctamente'
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al registrar mantenimiento: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar mantenimiento: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene el historial de mantenimientos de un activo
     */
    public function mantenimientos($activoId)
    {
        try {
            $mantenimientos = MantenimientoActivo::with(['proveedor', 'responsable'])
                ->where('activo_id', $activoId)
                ->orderBy('fecha_inicio', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $mantenimientos,
                'message' => 'Mantenimientos obtenidos correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener mantenimientos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener mantenimientos'
            ], 500);
        }
    }

    /**
     * Exporta mantenimientos a Excel
     */
    public function exportarMantenimientosExcel(Request $request)
    {
        try {
            Log::info('=== exportarMantenimientosExcel ===');
            
            $query = MantenimientoActivo::with(['activo', 'proyecto', 'responsable'])
                ->orderBy('created_at', 'desc');

            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }

            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin]);
            }

            $mantenimientos = $query->get();

            $headers = [
                'ID', 'Folio', 'Equipo', 'Tipo', 'Descripción', 'Fecha Inicio', 
                'Fecha Fin', 'Responsable', 'Costo', 'Estado', 'Prioridad'
            ];

            $rows = $mantenimientos->map(function($item) {
                return [
                    $item->id,
                    $item->folio ?? '-',
                    $item->activo->codigo . ' - ' . $item->activo->nombre,
                    ucfirst($item->tipo_mantenimiento),
                    $item->descripcion,
                    $item->fecha_inicio->format('d/m/Y'),
                    $item->fecha_fin ? $item->fecha_fin->format('d/m/Y') : '-',
                    $item->responsable_asignado ?? '-',
                    '$' . number_format($item->costo, 2),
                    ucfirst($item->estatus),
                    ucfirst($item->prioridad ?? 'Media')
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'headers' => $headers,
                    'rows' => $rows,
                    'total' => $mantenimientos->count()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error en exportarMantenimientosExcel: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar mantenimientos'
            ], 500);
        }
    }

    // ==================== MÉTODOS DE COMBUSTIBLE ====================

    /**
     * Obtiene historial de combustible
     */
    public function historialCombustible(Request $request)
    {
        try {
            $query = CombustibleActivo::with(['activo', 'proyecto', 'operador'])
                ->orderBy('fecha', 'desc');

            if ($request->filled('activo_id')) {
                $query->where('activo_id', $request->activo_id);
            }

            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            }

            $perPage = $request->get('per_page', 15);
            $historial = $query->paginate($perPage);

            $totales = [
                'total_litros' => CombustibleActivo::sum('litros'),
                'total_costo' => CombustibleActivo::sum('costo'),
                'total_registros' => CombustibleActivo::count()
            ];

            return response()->json([
                'success' => true,
                'data' => $historial,
                'totales' => $totales,
                'message' => 'Historial obtenido correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener historial: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener historial: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Registra el consumo de combustible
     */
    public function registrarConsumo(Request $request)
    {
        Log::info('=== MAQUINARIA: Registrando consumo de combustible ===');
        Log::info('Datos:', $request->all());
        
        try {
            $request->validate([
                'activo_id' => 'required|exists:activos,id',
                'fecha' => 'required|date',
                'litros' => 'required|numeric|min:0.01',
                'costo' => 'required|numeric|min:0',
                'horometro' => 'nullable|numeric|min:0',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'operador_id' => 'nullable|exists:plantillas,plantilla_id',
                'factura' => 'nullable|string|max:100',
                'proveedor' => 'nullable|string|max:255',
                'observaciones' => 'nullable|string'
            ]);

            DB::beginTransaction();

            $precio_litro = $request->litros > 0 ? $request->costo / $request->litros : 0;

            $consumo = CombustibleActivo::create([
                'activo_id' => $request->activo_id,
                'proyecto_id' => $request->proyecto_id,
                'operador_id' => $request->operador_id,
                'created_by' => auth()->id(),
                'fecha' => $request->fecha,
                'litros' => $request->litros,
                'costo' => $request->costo,
                'precio_litro' => $precio_litro,
                'horometro' => $request->horometro,
                'factura' => $request->factura,
                'proveedor' => $request->proveedor,
                'observaciones' => $request->observaciones
            ]);

            if ($request->horometro) {
                $maquinaria = ActivoMaquinaria::where('activo_id', $request->activo_id)->first();
                if ($maquinaria) {
                    $maquinaria->horometro_actual = $request->horometro;
                    $maquinaria->save();
                }
            }

            Log::info('Consumo de combustible registrado ID: ' . $consumo->id);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $consumo->load(['activo', 'proyecto', 'operador']),
                'message' => 'Consumo de combustible registrado correctamente'
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al registrar consumo de combustible: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar consumo de combustible: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene el historial de combustible de un activo
     */
    public function combustible($activoId)
    {
        try {
            $combustibles = CombustibleActivo::with(['proyecto', 'operador'])
                ->where('activo_id', $activoId)
                ->orderBy('fecha', 'desc')
                ->get();

            $totales = [
                'total_litros' => $combustibles->sum('litros'),
                'total_costo' => $combustibles->sum('costo'),
                'promedio_precio' => $combustibles->avg('precio_litro')
            ];

            return response()->json([
                'success' => true,
                'data' => [
                    'historial' => $combustibles,
                    'totales' => $totales
                ],
                'message' => 'Combustible obtenido correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener combustible: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener combustible'
            ], 500);
        }
    }

    /**
     * Obtiene el historial de mantenimientos con filtros
     */
    public function getMantenimientos(Request $request)
    {
        try {
            $query = MantenimientoActivo::with(['activo', 'proveedor', 'responsable'])
                ->orderBy('fecha_inicio', 'desc');

            if ($request->filled('activo_id')) {
                $query->where('activo_id', $request->activo_id);
            }

            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }

            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin]);
            }

            $mantenimientos = $query->get();

            $estadisticas = [
                'en_proceso' => MantenimientoActivo::where('estatus', 'en_proceso')->count(),
                'proximos' => MantenimientoActivo::where('estatus', 'pendiente')
                    ->whereBetween('fecha_inicio', [now(), now()->addDays(7)])
                    ->count(),
                'completados' => MantenimientoActivo::where('estatus', 'completado')->count()
            ];

            return response()->json([
                'success' => true,
                'data' => $mantenimientos,
                'estadisticas' => $estadisticas,
                'message' => 'Mantenimientos obtenidos correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener mantenimientos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener mantenimientos: ' . $e->getMessage()
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
            $query = Activo::query();
            
            if ($request->filled('tipo')) {
                $query->byTipo($request->tipo);
            }

            $total = (clone $query)->count();
            $enOperacion = (clone $query)->where('estatus', 'activo')->whereNotNull('proyecto_asignado_id')->count();
            $enMantenimiento = (clone $query)->where('estatus', 'mantenimiento')->count();
            $disponibles = (clone $query)->where('estatus', 'activo')->whereNull('proyecto_asignado_id')->count();

            return [
                'total_equipos' => $total,
                'en_operacion' => $enOperacion,
                'en_mantenimiento' => $enMantenimiento,
                'disponibles' => $disponibles,
                'total_maquinaria' => (clone $query)->where('tipo_activo', 'maquinaria')->count(),
                'total_vehiculos' => (clone $query)->where('tipo_activo', 'vehiculo')->count(),
                'total_herramientas' => (clone $query)->where('tipo_activo', 'herramienta')->count(),
                'total_equipos_categoria' => (clone $query)->where('tipo_activo', 'equipo')->count()
            ];
            
        } catch (\Exception $e) {
            Log::error('ERROR calcularEstadisticas: ' . $e->getMessage());
            return [
                'total_equipos' => 0,
                'en_operacion' => 0,
                'en_mantenimiento' => 0,
                'disponibles' => 0,
                'total_maquinaria' => 0,
                'total_vehiculos' => 0,
                'total_herramientas' => 0,
                'total_equipos_categoria' => 0
            ];
        }
    }

    /**
     * Calcula el avance de un mantenimiento
     */
    private function calcularAvanceMantenimiento($mantenimiento)
    {
        if (!$mantenimiento->fecha_inicio || !$mantenimiento->fecha_fin_estimada) {
            return 0;
        }

        if ($mantenimiento->estatus === 'completado') return 100;
        if ($mantenimiento->estatus === 'cancelado') return 0;
        if ($mantenimiento->estatus === 'pendiente') return 0;

        try {
            $inicio = Carbon::parse($mantenimiento->fecha_inicio);
            $fin = Carbon::parse($mantenimiento->fecha_fin_estimada);
            $ahora = Carbon::now();

            if ($ahora->lt($inicio)) return 0;
            if ($ahora->gt($fin)) return 100;

            $total = $fin->diffInDays($inicio);
            $transcurrido = $ahora->diffInDays($inicio);
            
            if ($total == 0) return 100;
            
            return round(($transcurrido / $total) * 100);
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Crea los datos de maquinaria para un activo
     */
    private function crearMaquinaria(Request $request, int $activoId): void
    {
        ActivoMaquinaria::create([
            'activo_id' => $activoId,
            'horometro_actual' => $request->horometro_actual ?? 0,
            'horometro_compra' => $request->horometro_compra ?? 0,
            'horometro_ultimo_mantenimiento' => $request->horometro_ultimo_mantenimiento,
            'horometro_proximo_mantenimiento' => $request->horometro_proximo_mantenimiento,
            'tipo_combustible' => $request->tipo_combustible,
            'consumo_promedio' => $request->consumo_promedio,
            'capacidad_tanque' => $request->capacidad_tanque,
            'peso_operativo' => $request->peso_operativo,
            'capacidad_carga' => $request->capacidad_carga,
            'unidad_capacidad' => $request->unidad_capacidad,
            'dimensiones' => $request->dimensiones,
            'operador_actual_id' => $request->operador_actual_id,
            'licencia_requerida' => $request->licencia_requerida,
            'ultimo_servicio_fecha' => $request->ultimo_servicio_fecha,
            'proximo_servicio_fecha' => $request->proximo_servicio_fecha,
            'mantenimiento_preventivo_dias' => $request->mantenimiento_preventivo_dias ?? 30
        ]);
    }

    /**
     * Crea los datos de vehículo para un activo
     */
    private function crearVehiculo(Request $request, int $activoId): void
    {
        ActivoVehiculo::create([
            'activo_id' => $activoId,
            'placas' => $request->placas,
            'numero_economico' => $request->numero_economico,
            'vin' => $request->vin,
            'kilometraje_actual' => $request->kilometraje_actual ?? 0,
            'kilometraje_compra' => $request->kilometraje_compra ?? 0,
            'kilometraje_ultimo_mantenimiento' => $request->kilometraje_ultimo_mantenimiento,
            'kilometraje_proximo_mantenimiento' => $request->kilometraje_proximo_mantenimiento,
            'tipo_combustible' => $request->tipo_combustible,
            'consumo_promedio' => $request->consumo_promedio,
            'capacidad_tanque' => $request->capacidad_tanque,
            'capacidad_pasajeros' => $request->capacidad_pasajeros,
            'capacidad_carga' => $request->capacidad_carga,
            'tipo_vehiculo' => $request->tipo_vehiculo,
            'traccion' => $request->traccion,
            'transmision' => $request->transmision,
            'poliza_seguro' => $request->poliza_seguro,
            'vencimiento_seguro' => $request->vencimiento_seguro,
            'poliza_verificacion' => $request->poliza_verificacion,
            'vencimiento_verificacion' => $request->vencimiento_verificacion,
            'ultimo_servicio_fecha' => $request->ultimo_servicio_fecha,
            'proximo_servicio_fecha' => $request->proximo_servicio_fecha,
            'licencia_requerida' => $request->licencia_requerida
        ]);
    }

    /**
     * Crea los datos de herramienta para un activo
     */
    private function crearHerramienta(Request $request, int $activoId): void
    {
        ActivoHerramienta::create([
            'activo_id' => $activoId,
            'tipo_herramienta' => $request->tipo_herramienta,
            'voltaje' => $request->voltaje,
            'potencia' => $request->potencia,
            'requiere_calibracion' => $request->requiere_calibracion ?? false,
            'fecha_ultima_calibracion' => $request->fecha_ultima_calibracion,
            'fecha_proxima_calibracion' => $request->fecha_proxima_calibracion,
            'numero_inventario' => $request->numero_inventario,
            'prestamos_realizados' => $request->prestamos_realizados ?? 0,
            'tiempo_uso_promedio' => $request->tiempo_uso_promedio
        ]);
    }

    /**
     * Actualiza los datos de maquinaria para un activo
     */
    private function actualizarMaquinaria(Request $request, int $activoId): void
    {
        $maquinaria = ActivoMaquinaria::where('activo_id', $activoId)->first();
        if ($maquinaria) {
            $maquinaria->update([
                'horometro_actual' => $request->horometro_actual ?? $maquinaria->horometro_actual,
                'tipo_combustible' => $request->tipo_combustible ?? $maquinaria->tipo_combustible,
                'consumo_promedio' => $request->consumo_promedio ?? $maquinaria->consumo_promedio,
                'capacidad_tanque' => $request->capacidad_tanque ?? $maquinaria->capacidad_tanque,
                'operador_actual_id' => $request->operador_actual_id ?? $maquinaria->operador_actual_id,
                'proximo_servicio_fecha' => $request->proximo_servicio_fecha ?? $maquinaria->proximo_servicio_fecha,
                'mantenimiento_preventivo_dias' => $request->mantenimiento_preventivo_dias ?? $maquinaria->mantenimiento_preventivo_dias
            ]);
        } else {
            $this->crearMaquinaria($request, $activoId);
        }
    }

    /**
     * Actualiza los datos de vehículo para un activo
     */
    private function actualizarVehiculo(Request $request, int $activoId): void
    {
        $vehiculo = ActivoVehiculo::where('activo_id', $activoId)->first();
        if ($vehiculo) {
            $vehiculo->update([
                'placas' => $request->placas ?? $vehiculo->placas,
                'kilometraje_actual' => $request->kilometraje_actual ?? $vehiculo->kilometraje_actual,
                'tipo_combustible' => $request->tipo_combustible ?? $vehiculo->tipo_combustible,
                'consumo_promedio' => $request->consumo_promedio ?? $vehiculo->consumo_promedio,
                'poliza_seguro' => $request->poliza_seguro ?? $vehiculo->poliza_seguro,
                'vencimiento_seguro' => $request->vencimiento_seguro ?? $vehiculo->vencimiento_seguro,
                'vencimiento_verificacion' => $request->vencimiento_verificacion ?? $vehiculo->vencimiento_verificacion,
                'proximo_servicio_fecha' => $request->proximo_servicio_fecha ?? $vehiculo->proximo_servicio_fecha
            ]);
        } else {
            $this->crearVehiculo($request, $activoId);
        }
    }

    /**
     * Actualiza los datos de herramienta para un activo
     */
    private function actualizarHerramienta(Request $request, int $activoId): void
    {
        $herramienta = ActivoHerramienta::where('activo_id', $activoId)->first();
        if ($herramienta) {
            $herramienta->update([
                'tipo_herramienta' => $request->tipo_herramienta ?? $herramienta->tipo_herramienta,
                'requiere_calibracion' => $request->requiere_calibracion ?? $herramienta->requiere_calibracion,
                'fecha_proxima_calibracion' => $request->fecha_proxima_calibracion ?? $herramienta->fecha_proxima_calibracion,
                'tiempo_uso_promedio' => $request->tiempo_uso_promedio ?? $herramienta->tiempo_uso_promedio
            ]);
        } else {
            $this->crearHerramienta($request, $activoId);
        }
    }
}