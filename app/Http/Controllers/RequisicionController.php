<?php

namespace App\Http\Controllers;

use App\Models\Requisicion;
use App\Models\RequisicionArticulo;
use App\Models\Area;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class RequisicionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Requisicion::with(['area', 'proyecto', 'articulos']);
            
            // Filtros
            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }
            
            if ($request->filled('area_id')) {
                $query->where('area_id', $request->area_id);
            }
            
            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha_requerimiento', '>=', $request->fecha_inicio);
            }
            
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha_requerimiento', '<=', $request->fecha_fin);
            }
            
            if ($request->filled('buscar')) {
                $query->where(function($q) use ($request) {
                    $q->where('folio', 'LIKE', "%{$request->buscar}%")
                      ->orWhere('solicitante', 'LIKE', "%{$request->buscar}%");
                });
            }
            
            $requisiciones = $query->orderBy('id', 'desc')->paginate(15);
            
            $areas = Area::all();
            $proyectos = Proyecto::all();
            
            // Si es petición AJAX, devolver JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($requisiciones);
            }
            
            // Vista con todas las variables
            return view('compras.requisicion.requisicion', [
                'requisiciones' => $requisiciones,
                'areas' => $areas,
                'proyectos' => $proyectos
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en RequisicionController@index: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar requisiciones: ' . $e->getMessage()
                ], 500);
            }
            
            return view('compras.requisicion.requisicion', [
                'requisiciones' => collect([]),
                'areas' => Area::all(),
                'proyectos' => Proyecto::all()
            ]);
        }
    }

    /**
     * Generar folio automático
     */
    public function generarFolio()
    {
        try {
            $ultima = Requisicion::withTrashed()->orderBy('id', 'desc')->first();
            if ($ultima && $ultima->folio) {
                $numero = intval(substr($ultima->folio, 4)) + 1;
            } else {
                $numero = 1;
            }
            $folio = 'REQ-' . str_pad($numero, 3, '0', STR_PAD_LEFT);
            return response()->json(['folio' => $folio]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar folio: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener lista de proyectos para el select
     */
    public function getProyectos()
    {
        try {
            $proyectos = Proyecto::where('status', 'activo')->get(['id', 'nombre', 'codigo']);
            return response()->json($proyectos);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar proyectos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener lista de áreas para el select
     */
    public function getAreas()
    {
        try {
            $areas = Area::all(['id', 'nombre']);
            return response()->json($areas);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar áreas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
 * ⭐ TICKET #1: Catálogo de artículos para el selector
 * Usa el modelo Articulo con sus columnas reales
 */
public function getArticulos(Request $request)
{
    try {
        // ============================================
        // 1. Query base con el modelo
        // ============================================
        $query = \App\Models\Articulo::query();
        
        // Solo artículos activos (usa el scope del modelo)
        $query->where(function($q) {
            $q->where('estatus', 'Activo')
              ->orWhereNull('estatus');
        });
        
        // ============================================
        // 2. Búsqueda por texto
        // ============================================
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('descripcion', 'LIKE', "%{$search}%")
                  ->orWhere('codigo', 'LIKE', "%{$search}%")
                  ->orWhere('numero_parte', 'LIKE', "%{$search}%");
            });
        }
        
        // ============================================
        // 3. Filtrar por familia/subfamilia si se envía
        // ============================================
        if ($request->filled('familia_id')) {
            $query->where('familia_id', $request->familia_id);
        }
        if ($request->filled('subfamilia_id')) {
            $query->where('subfamilia_id', $request->subfamilia_id);
        }
        
        // ============================================
        // 4. Ordenar y limitar
        // ============================================
        $articulos = $query
            ->orderBy('descripcion')
            ->limit(100)
            ->get()
            ->map(function($art) {
                // Normalizar respuesta al formato que espera el Blade
                return [
                    'id' => $art->id,
                    'nombre' => $art->descripcion,           // alias para el Blade
                    'descripcion' => $art->descripcion,
                    'codigo' => $art->codigo,
                    'numero_parte' => $art->numero_parte,
                    'unidad_medida' => $art->unidad_medida,
                    'stock_actual' => 0,                     // se calcula aparte si quieres
                    'familia_id' => $art->familia_id,
                    'subfamilia_id' => $art->subfamilia_id,
                    'ubicacion' => $art->ubicacion,
                    'minimo' => $art->minimo,
                    'maximo' => $art->maximo,
                    'punto_reorden' => $art->punto_reorden,
                    'cuenta_contable' => $art->cuenta_contable,
                    'estatus' => $art->estatus,
                ];
            });
        
        return response()->json([
            'success' => true,
            'data' => $articulos,
            'total' => $articulos->count(),
            'mensaje' => $articulos->count() > 0
                ? "{$articulos->count()} artículos encontrados"
                : 'La tabla de artículos está vacía'
        ]);
        
    } catch (\Exception $e) {
        Log::error('Error getArticulos: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error al cargar artículos: ' . $e->getMessage(),
            'data' => []
        ], 500);
    }
}

    /**
     * ⭐ TICKETS #3 y #4: Obtener personal para el selector de solicitante
     * 
     * Prioridad:
     *   1. Personal del proyecto (tabla pivote proyecto_personal)
     *   2. Empleados de la plantilla general
     *   3. Usuarios del sistema
     */
    public function getPersonal(Request $request)
    {
        try {
            $personal = collect();
            
            // ============================================
            // Opción 1: Personal del proyecto específico
            // ============================================
            if ($request->filled('proyecto_id')) {
                $proyectoId = $request->proyecto_id;
                
                // 1.1 Intentar con tabla pivote proyecto_personal
                if (Schema::hasTable('proyecto_personal')) {
                    try {
                        $personalProyecto = DB::table('proyecto_personal as pp')
                            ->leftJoin('plantilla as p', 'pp.empleado_id', '=', 'p.plantilla_id')
                            ->where('pp.proyecto_id', $proyectoId)
                            ->where(function($q) {
                                $q->where('pp.activo', 1)->orWhereNull('pp.activo');
                            })
                            ->select(
                                'p.plantilla_id as id',
                                DB::raw("CONCAT(p.nombre, ' ', IFNULL(p.apellido_paterno,''), ' ', IFNULL(p.apellido_materno,'')) as nombre"),
                                'p.puesto',
                                DB::raw("'proyecto' as tipo")
                            )
                            ->orderBy('p.nombre')
                            ->get();
                        
                        if ($personalProyecto->isNotEmpty()) {
                            $personal = $personalProyecto;
                        }
                    } catch (\Exception $e) {
                        Log::warning('Error al consultar proyecto_personal: ' . $e->getMessage());
                    }
                }
                
                // 1.2 Si no hay personal de proyecto, usar asignaciones de personal
                if ($personal->isEmpty() && Schema::hasTable('asignaciones_personal')) {
                    try {
                        $personalProyecto = DB::table('asignaciones_personal as ap')
                            ->leftJoin('plantilla as p', 'ap.empleado_id', '=', 'p.plantilla_id')
                            ->where('ap.proyecto_id', $proyectoId)
                            ->where(function($q) {
                                $q->where('ap.status', 'activo')->orWhereNull('ap.status');
                            })
                            ->select(
                                'p.plantilla_id as id',
                                DB::raw("CONCAT(p.nombre, ' ', IFNULL(p.apellido_paterno,''), ' ', IFNULL(p.apellido_materno,'')) as nombre"),
                                'p.puesto',
                                DB::raw("'asignacion' as tipo")
                            )
                            ->orderBy('p.nombre')
                            ->get();
                        
                        if ($personalProyecto->isNotEmpty()) {
                            $personal = $personalProyecto;
                        }
                    } catch (\Exception $e) {
                        Log::warning('Error al consultar asignaciones_personal: ' . $e->getMessage());
                    }
                }
            }
            
            // ============================================
            // Opción 2: Empleados de la plantilla general
            // ============================================
            if ($personal->isEmpty() && Schema::hasTable('plantilla')) {
                try {
                    $personal = DB::table('plantilla')
                        ->where(function($q) {
                            $q->where('estatus', 'Activo')
                              ->orWhere('estatus', 'activo')
                              ->orWhereNull('estatus');
                        })
                        ->orderBy('nombre')
                        ->limit(300)
                        ->select(
                            'plantilla_id as id',
                            DB::raw("CONCAT(nombre, ' ', IFNULL(apellido_paterno,''), ' ', IFNULL(apellido_materno,'')) as nombre"),
                            'puesto',
                            DB::raw("'empleado' as tipo")
                        )
                        ->get();
                } catch (\Exception $e) {
                    Log::warning('Error al consultar plantilla: ' . $e->getMessage());
                }
            }
            
            // ============================================
            // Opción 3: Usuarios del sistema como fallback
            // ============================================
            if ($personal->isEmpty() && Schema::hasTable('users')) {
                try {
                    $personal = DB::table('users')
                        ->orderBy('name')
                        ->limit(300)
                        ->select(
                            'id',
                            'name as nombre',
                            DB::raw("'' as puesto"),
                            DB::raw("'usuario' as tipo")
                        )
                        ->get();
                } catch (\Exception $e) {
                    Log::warning('Error al consultar users: ' . $e->getMessage());
                }
            }
            
            // ============================================
            // Filtro por búsqueda
            // ============================================
            if ($request->filled('search')) {
                $search = strtolower($request->search);
                $personal = $personal->filter(function($item) use ($search) {
                    return str_contains(strtolower($item->nombre ?? ''), $search)
                        || str_contains(strtolower($item->puesto ?? ''), $search);
                })->values();
            }
            
            return response()->json([
                'success' => true,
                'data' => $personal,
                'total' => $personal->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error getPersonal: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar personal: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * ⭐ TICKETS #3 y #4: Personal específico de un proyecto
     */
    public function getPersonalProyecto($proyectoId)
    {
        $request = new Request();
        $request->merge(['proyecto_id' => $proyectoId]);
        return $this->getPersonal($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'fecha_requerimiento' => 'required|date',
                'solicitante' => 'required|string|max:100',
                'area_id' => 'required|exists:areas,id',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'observaciones' => 'nullable|string',
                'articulos' => 'required|array|min:1',
                'articulos.*.articulo_id' => 'nullable',
                'articulos.*.codigo' => 'nullable|string|max:50',
                'articulos.*.cantidad' => 'required|numeric|min:0.001',
                'articulos.*.unidad_medida' => 'required|string|max:20',
                'articulos.*.descripcion' => 'required|string|max:500',
                'articulos.*.observacion' => 'nullable|string',
                'articulos.*.pendiente' => 'boolean',
            ]);
            
            DB::beginTransaction();
            
            // Generar folio
            $ultima = Requisicion::withTrashed()->orderBy('id', 'desc')->first();
            $numero = 1;
            if ($ultima && $ultima->folio) {
                $numero = intval(substr($ultima->folio, 4)) + 1;
            }
            $folio = 'REQ-' . str_pad($numero, 3, '0', STR_PAD_LEFT);
            
            // Obtener el nombre del área
            $area = Area::find($request->area_id);
            
            // Crear requisición
            $requisicion = Requisicion::create([
                'folio' => $folio,
                'fecha_requerimiento' => $request->fecha_requerimiento,
                'estatus' => $request->estatus ?? 'Pendiente',
                'solicitante' => $request->solicitante,
                'area' => $area ? $area->nombre : null,
                'area_id' => $request->area_id,
                'proyecto_id' => $request->proyecto_id,
                'cotizadas' => 0,
                'observaciones' => $request->observaciones,
                'creado_por' => Auth::id(),
            ]);
            
            // Crear artículos
            foreach ($request->articulos as $articulo) {
                $dataArticulo = [
                    'requisicion_id' => $requisicion->id,
                    'codigo' => $articulo['codigo'] ?? null,
                    'cantidad' => $articulo['cantidad'],
                    'unidad_medida' => $articulo['unidad_medida'],
                    'descripcion' => $articulo['descripcion'],
                    'observacion' => $articulo['observacion'] ?? null,
                    'pendiente' => $articulo['pendiente'] ?? true,
                    'cantidad_surtida' => 0,
                ];
                
                // Agregar articulo_id solo si la columna existe
                if (Schema::hasColumn('requisicion_articulos', 'articulo_id') && !empty($articulo['articulo_id'])) {
                    $dataArticulo['articulo_id'] = $articulo['articulo_id'];
                }
                
                RequisicionArticulo::create($dataArticulo);
            }
            
            // Generar tarea automáticamente (si el método existe)
            try {
                Log::info('🔄 Intentando generar tarea para requisición', [
                    'requisicion_id' => $requisicion->id,
                    'folio' => $requisicion->folio
                ]);
                
                if (method_exists($requisicion, 'generarTareaDesdeRequisicion')) {
                    $tarea = $requisicion->generarTareaDesdeRequisicion();
                    
                    if ($tarea) {
                        Log::info('✅ Tarea generada', [
                            'requisicion_id' => $requisicion->id,
                            'tarea_id' => $tarea->id ?? null
                        ]);
                    }
                }
            } catch (\Exception $e) {
                Log::error('❌ Error al generar tarea: ' . $e->getMessage());
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Requisición creada exitosamente',
                'data' => $requisicion->load('articulos', 'area', 'proyecto'),
            ]);
            
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear requisición: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la requisición: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $requisicion = Requisicion::with(['area', 'proyecto', 'articulos', 'creador'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $requisicion,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Requisición no encontrada: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $requisicion = Requisicion::findOrFail($id);
            
            $request->validate([
                'fecha_requerimiento' => 'required|date',
                'solicitante' => 'required|string|max:100',
                'area_id' => 'required|exists:areas,id',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'estatus' => 'required|in:Pendiente,Activo,Cotizado,Cancelado',
                'observaciones' => 'nullable|string',
                'articulos' => 'required|array|min:1',
                'articulos.*.articulo_id' => 'nullable',
                'articulos.*.codigo' => 'nullable|string|max:50',
                'articulos.*.cantidad' => 'required|numeric|min:0.001',
                'articulos.*.unidad_medida' => 'required|string|max:20',
                'articulos.*.descripcion' => 'required|string|max:500',
                'articulos.*.observacion' => 'nullable|string',
                'articulos.*.pendiente' => 'boolean',
            ]);
            
            DB::beginTransaction();
            
            // Obtener el nombre del área
            $area = Area::find($request->area_id);
            
            // Actualizar requisición
            $requisicion->update([
                'fecha_requerimiento' => $request->fecha_requerimiento,
                'solicitante' => $request->solicitante,
                'area' => $area ? $area->nombre : null,
                'area_id' => $request->area_id,
                'proyecto_id' => $request->proyecto_id,
                'estatus' => $request->estatus,
                'observaciones' => $request->observaciones,
            ]);
            
            // Eliminar artículos viejos
            RequisicionArticulo::where('requisicion_id', $requisicion->id)->delete();
            
            // Crear nuevos artículos
            foreach ($request->articulos as $articulo) {
                $dataArticulo = [
                    'requisicion_id' => $requisicion->id,
                    'codigo' => $articulo['codigo'] ?? null,
                    'cantidad' => $articulo['cantidad'],
                    'unidad_medida' => $articulo['unidad_medida'],
                    'descripcion' => $articulo['descripcion'],
                    'observacion' => $articulo['observacion'] ?? null,
                    'pendiente' => $articulo['pendiente'] ?? true,
                    'cantidad_surtida' => $articulo['cantidad_surtida'] ?? 0,
                ];
                
                if (Schema::hasColumn('requisicion_articulos', 'articulo_id') && !empty($articulo['articulo_id'])) {
                    $dataArticulo['articulo_id'] = $articulo['articulo_id'];
                }
                
                RequisicionArticulo::create($dataArticulo);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Requisición actualizada exitosamente',
                'data' => $requisicion->load('articulos', 'area', 'proyecto')
            ]);
            
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar requisición: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la requisición: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $requisicion = Requisicion::findOrFail($id);
            RequisicionArticulo::where('requisicion_id', $requisicion->id)->delete();
            $requisicion->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Requisición eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la requisición: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Aprobar requisición
     */
    public function aprobar($id)
    {
        try {
            $requisicion = Requisicion::findOrFail($id);
            
            $requisicion->update([
                'estatus' => 'Activo',
                'aprobado_por' => Auth::id(),
                'fecha_aprobacion' => now(),
            ]);
            
            // Actualizar tarea si existe
            try {
                if (class_exists('App\Models\WorkflowTask')) {
                    $tarea = \App\Models\WorkflowTask::where('module', 'requisiciones')
                        ->where('record_id', $requisicion->id)
                        ->first();
                    
                    if ($tarea) {
                        $tarea->update([
                            'status' => 'in_progress',
                            'title' => "✅ Requisición Aprobada: " . $requisicion->folio
                        ]);
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error al actualizar tarea en aprobación: ' . $e->getMessage());
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Requisición aprobada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al aprobar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Rechazar requisición
     */
    public function rechazar(Request $request, $id)
    {
        try {
            $request->validate(['motivo_rechazo' => 'required|string']);
            
            $requisicion = Requisicion::findOrFail($id);
            
            $requisicion->update([
                'estatus' => 'Cancelado',
                'motivo_rechazo' => $request->motivo_rechazo,
                'aprobado_por' => Auth::id(),
                'fecha_aprobacion' => now(),
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Requisición rechazada'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al rechazar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ⭐ TICKET #5: Validar stock disponible
     */
    public function validarStock(Request $request, $id)
    {
        try {
            $requisicion = Requisicion::with('articulos')->findOrFail($id);
            $almacenId = $request->input('almacen_id');
            
            $resultados = [];
            $todoDisponible = true;
            
            foreach ($requisicion->articulos as $articuloReq) {
                $stockDisponible = 0;
                
                if (Schema::hasTable('inventario_stock')) {
                    $query = DB::table('inventario_stock');
                    
                    if (!empty($articuloReq->articulo_id) && Schema::hasColumn('inventario_stock', 'articulo_id')) {
                        $query->where('articulo_id', $articuloReq->articulo_id);
                    } elseif (!empty($articuloReq->codigo) && Schema::hasColumn('inventario_stock', 'codigo')) {
                        $query->where('codigo', $articuloReq->codigo);
                    }
                    
                    if ($almacenId && Schema::hasColumn('inventario_stock', 'almacen_id')) {
                        $query->where('almacen_id', $almacenId);
                    }
                    
                    $stockDisponible = (float) $query->sum('cantidad');
                }
                
                $cantidadSolicitada = (float) $articuloReq->cantidad;
                $cantidadSurtida = (float) ($articuloReq->cantidad_surtida ?? 0);
                $pendiente = $cantidadSolicitada - $cantidadSurtida;
                
                $suficiente = $stockDisponible >= $pendiente;
                if (!$suficiente && $pendiente > 0) {
                    $todoDisponible = false;
                }
                
                $resultados[] = [
                    'requisicion_articulo_id' => $articuloReq->id,
                    'articulo_id' => $articuloReq->articulo_id ?? null,
                    'codigo' => $articuloReq->codigo,
                    'descripcion' => $articuloReq->descripcion,
                    'cantidad_solicitada' => $cantidadSolicitada,
                    'cantidad_surtida' => $cantidadSurtida,
                    'cantidad_pendiente' => $pendiente,
                    'stock_disponible' => $stockDisponible,
                    'suficiente' => $suficiente,
                ];
            }
            
            return response()->json([
                'success' => true,
                'todo_disponible' => $todoDisponible,
                'requisicion_id' => $requisicion->id,
                'folio' => $requisicion->folio,
                'articulos' => $resultados
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error validarStock: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al validar stock: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ⭐ TICKET #5: Generar salida de requisición
     */
    public function generarSalida(Request $request, $id)
    {
        try {
            $request->validate([
                'almacen_id' => 'required',
                'articulos' => 'required|array',
                'articulos.*.requisicion_articulo_id' => 'required',
                'articulos.*.cantidad_surtir' => 'required|numeric|min:0.001',
            ]);
            
            DB::beginTransaction();
            
            $requisicion = Requisicion::with('articulos')->findOrFail($id);
            
            if ($requisicion->estatus === 'Cancelado') {
                throw new \Exception('No se puede generar salida de una requisición cancelada');
            }
            
            $errores = [];
            $detallesSalida = [];
            
            foreach ($request->articulos as $item) {
                $articuloReq = RequisicionArticulo::findOrFail($item['requisicion_articulo_id']);
                $cantidadSurtir = (float) $item['cantidad_surtir'];
                $almacenId = $request->almacen_id;
                
                // Validar stock
                $stockDisponible = 0;
                if (Schema::hasTable('inventario_stock')) {
                    $query = DB::table('inventario_stock');
                    
                    if (!empty($articuloReq->articulo_id) && Schema::hasColumn('inventario_stock', 'articulo_id')) {
                        $query->where('articulo_id', $articuloReq->articulo_id);
                    } elseif (!empty($articuloReq->codigo) && Schema::hasColumn('inventario_stock', 'codigo')) {
                        $query->where('codigo', $articuloReq->codigo);
                    }
                    
                    if ($almacenId && Schema::hasColumn('inventario_stock', 'almacen_id')) {
                        $query->where('almacen_id', $almacenId);
                    }
                    
                    $stockDisponible = (float) $query->sum('cantidad');
                }
                
                if ($stockDisponible < $cantidadSurtir) {
                    $errores[] = "Stock insuficiente para '{$articuloReq->descripcion}'. " .
                                 "Solicitado: {$cantidadSurtir}, Disponible: {$stockDisponible}";
                    continue;
                }
                
                // Actualizar cantidad surtida
                $nuevaCantidadSurtida = ($articuloReq->cantidad_surtida ?? 0) + $cantidadSurtir;
                $pendiente = $nuevaCantidadSurtida < $articuloReq->cantidad;
                
                $articuloReq->update([
                    'cantidad_surtida' => $nuevaCantidadSurtida,
                    'pendiente' => $pendiente,
                ]);
                
                $detallesSalida[] = [
                    'requisicion_articulo_id' => $articuloReq->id,
                    'cantidad' => $cantidadSurtir,
                ];
            }
            
            if (!empty($errores)) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede generar la salida',
                    'errores' => $errores
                ], 422);
            }
            
            // Verificar si todos están surtidos
            $todosSurtidos = RequisicionArticulo::where('requisicion_id', $requisicion->id)
                ->where('pendiente', true)
                ->count() === 0;
            
            if ($todosSurtidos) {
                $requisicion->update(['estatus' => 'Cotizado']);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Salida generada exitosamente',
                'data' => [
                    'requisicion_id' => $requisicion->id,
                    'folio' => $requisicion->folio,
                    'detalles' => $detallesSalida,
                    'todos_surtidos' => $todosSurtidos
                ]
            ]);
            
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error generarSalida: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar salida: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Exportar a Excel
     */
    public function exportar(Request $request)
    {
        try {
            $requisiciones = Requisicion::with(['area', 'proyecto'])->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Exportación en desarrollo. Se encontraron ' . $requisiciones->count() . ' registros.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en exportación: ' . $e->getMessage()
            ], 500);
        }
    }
}