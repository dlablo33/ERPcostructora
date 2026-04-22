<?php

namespace App\Http\Controllers;

use App\Models\InventarioProyecto;
use App\Models\Proyecto;
use App\Models\Articulo;
use App\Models\Almacen;
use App\Models\MovimientoInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InventarioProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        $articulos = Articulo::where('estatus', 'Activo')->orderBy('codigo')->get();
        $almacenes = Almacen::where('estatus', 'Activo')->orderBy('nombre')->get();
        
        return view('inventario.proyecto.index', compact('proyectos', 'articulos', 'almacenes'));
    }
    
    /**
     * Get inventario for DataTable
     */
    public function getInventario(Request $request)
    {
        try {
            $query = InventarioProyecto::with(['proyecto', 'articulo', 'ubicaciones.almacen']);
            
            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            if ($request->filled('articulo_id')) {
                $query->where('articulo_id', $request->articulo_id);
            }
            
            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }
            
            if ($request->filled('bajo_stock') && $request->bajo_stock == 'true') {
                $query->bajoStock();
            }
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('articulo', function($q) use ($search) {
                    $q->where('codigo', 'LIKE', "%{$search}%")
                      ->orWhere('descripcion', 'LIKE', "%{$search}%");
                });
            }
            
            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);
            
            $inventario = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
            
            $data = $inventario->getCollection()->map(function($item) {
                $ubicaciones = $item->ubicaciones->map(function($ubi) {
                    return [
                        'almacen_id' => $ubi->almacen_id,
                        'almacen_nombre' => $ubi->almacen->nombre,
                        'cantidad' => $ubi->cantidad,
                        'ubicacion_especifica' => $ubi->ubicacion_especifica,
                        'lote' => $ubi->lote
                    ];
                });
                
                return [
                    'id' => $item->id,
                    'proyecto_id' => $item->proyecto_id,
                    'proyecto_nombre' => $item->proyecto->nombre,
                    'articulo_id' => $item->articulo_id,
                    'articulo_codigo' => $item->articulo->codigo,
                    'articulo_descripcion' => $item->articulo->descripcion,
                    'unidad_medida' => $item->unidad_medida ?: $item->articulo->unidad_medida,
                    'cantidad_actual' => $item->cantidad_actual,
                    'cantidad_reservada' => $item->cantidad_reservada,
                    'disponible' => $item->disponible,
                    'cantidad_minima' => $item->cantidad_minima,
                    'cantidad_maxima' => $item->cantidad_maxima,
                    'punto_reorden' => $item->punto_reorden,
                    'bajo_stock' => $item->estaBajoStock,
                    'porcentaje_stock' => $item->porcentajeStock,
                    'ultima_entrada' => $item->ultima_entrada ? $item->ultima_entrada->format('d/m/Y H:i') : null,
                    'ultima_salida' => $item->ultima_salida ? $item->ultima_salida->format('d/m/Y H:i') : null,
                    'estatus' => $item->estatus,
                    'ubicaciones' => $ubicaciones
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'total' => $inventario->total(),
                'per_page' => $inventario->perPage(),
                'current_page' => $inventario->currentPage(),
                'last_page' => $inventario->lastPage()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getInventario: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar inventario: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Store a new inventory record.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'proyecto_id' => 'required|exists:proyectos,id',
                'articulo_id' => 'required|exists:articulos,id',
                'cantidad_inicial' => 'required|numeric|min:0',
                'almacen_id' => 'required|exists:almacenes,id',
                'cantidad_minima' => 'nullable|numeric|min:0',
                'cantidad_maxima' => 'nullable|numeric|min:0',
                'punto_reorden' => 'nullable|numeric|min:0',
                'ubicacion_especifica' => 'nullable|string|max:100',
                'lote' => 'nullable|string|max:50',
                'observaciones' => 'nullable|string'
            ]);
            
            DB::beginTransaction();
            
            // Verificar si ya existe inventario para este proyecto y artículo
            $existe = InventarioProyecto::where('proyecto_id', $request->proyecto_id)
                ->where('articulo_id', $request->articulo_id)
                ->first();
            
            if ($existe) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe inventario para este artículo en el proyecto seleccionado'
                ], 400);
            }
            
            $articulo = Articulo::find($request->articulo_id);
            
            $inventario = InventarioProyecto::create([
                'proyecto_id' => $request->proyecto_id,
                'articulo_id' => $request->articulo_id,
                'cantidad_actual' => $request->cantidad_inicial,
                'cantidad_reservada' => 0,
                'cantidad_minima' => $request->cantidad_minima ?? 0,
                'cantidad_maxima' => $request->cantidad_maxima ?? 0,
                'punto_reorden' => $request->punto_reorden ?? 0,
                'unidad_medida' => $articulo->unidad_medida,
                'observaciones' => $request->observaciones,
                'estatus' => 'Activo'
            ]);
            
            // Registrar ubicación en almacén
            \App\Models\InventarioAlmacenProyecto::create([
                'inventario_proyecto_id' => $inventario->id,
                'almacen_id' => $request->almacen_id,
                'cantidad' => $request->cantidad_inicial,
                'ubicacion_especifica' => $request->ubicacion_especifica,
                'lote' => $request->lote
            ]);
            
            // Registrar movimiento inicial si hay cantidad
            if ($request->cantidad_inicial > 0) {
                MovimientoInventario::create([
                    'inventario_proyecto_id' => $inventario->id,
                    'almacen_destino_id' => $request->almacen_id,
                    'tipo_movimiento' => 'Entrada',
                    'cantidad' => $request->cantidad_inicial,
                    'cantidad_antes' => 0,
                    'cantidad_despues' => $request->cantidad_inicial,
                    'referencia_tipo' => 'InventarioInicial',
                    'observaciones' => 'Inventario inicial',
                    'fecha_movimiento' => now(),
                    'creado_por' => auth()->id()
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Inventario creado exitosamente',
                'data' => $inventario->load(['proyecto', 'articulo', 'ubicaciones'])
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear inventario: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al crear inventario: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $inventario = InventarioProyecto::with(['proyecto', 'articulo', 'ubicaciones.almacen', 'movimientos' => function($q) {
                $q->orderBy('fecha_movimiento', 'desc')->limit(50);
            }])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $inventario->id,
                    'proyecto_id' => $inventario->proyecto_id,
                    'proyecto_nombre' => $inventario->proyecto->nombre,
                    'articulo_id' => $inventario->articulo_id,
                    'articulo_codigo' => $inventario->articulo->codigo,
                    'articulo_descripcion' => $inventario->articulo->descripcion,
                    'unidad_medida' => $inventario->unidad_medida,
                    'cantidad_actual' => $inventario->cantidad_actual,
                    'cantidad_reservada' => $inventario->cantidad_reservada,
                    'disponible' => $inventario->disponible,
                    'cantidad_minima' => $inventario->cantidad_minima,
                    'cantidad_maxima' => $inventario->cantidad_maxima,
                    'punto_reorden' => $inventario->punto_reorden,
                    'observaciones' => $inventario->observaciones,
                    'estatus' => $inventario->estatus,
                    'ubicaciones' => $inventario->ubicaciones->map(function($ubi) {
                        return [
                            'id' => $ubi->id,
                            'almacen_id' => $ubi->almacen_id,
                            'almacen_nombre' => $ubi->almacen->nombre,
                            'cantidad' => $ubi->cantidad,
                            'ubicacion_especifica' => $ubi->ubicacion_especifica,
                            'lote' => $ubi->lote,
                            'fecha_caducidad' => $ubi->fecha_caducidad
                        ];
                    }),
                    'movimientos' => $inventario->movimientos->map(function($mov) {
                        return [
                            'id' => $mov->id,
                            'tipo_movimiento' => $mov->tipo_movimiento,
                            'cantidad' => $mov->cantidad,
                            'cantidad_antes' => $mov->cantidad_antes,
                            'cantidad_despues' => $mov->cantidad_despues,
                            'referencia_tipo' => $mov->referencia_tipo,
                            'referencia_folio' => $mov->referencia_folio,
                            'observaciones' => $mov->observaciones,
                            'fecha_movimiento' => $mov->fecha_movimiento->format('d/m/Y H:i'),
                            'creado_por' => $mov->creador ? $mov->creador->name : null
                        ];
                    })
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Inventario no encontrado'
            ], 404);
        }
    }
    
    /**
     * Update inventory settings.
     */
    public function update(Request $request, $id)
    {
        try {
            $inventario = InventarioProyecto::findOrFail($id);
            
            $request->validate([
                'cantidad_minima' => 'nullable|numeric|min:0',
                'cantidad_maxima' => 'nullable|numeric|min:0',
                'punto_reorden' => 'nullable|numeric|min:0',
                'observaciones' => 'nullable|string',
                'estatus' => 'required|in:Activo,Inactivo'
            ]);
            
            DB::beginTransaction();
            
            $inventario->update([
                'cantidad_minima' => $request->cantidad_minima ?? 0,
                'cantidad_maxima' => $request->cantidad_maxima ?? 0,
                'punto_reorden' => $request->punto_reorden ?? 0,
                'observaciones' => $request->observaciones,
                'estatus' => $request->estatus
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Inventario actualizado exitosamente',
                'data' => $inventario
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar inventario: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar inventario: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Add stock to inventory.
     */
    public function agregarStock(Request $request, $id)
    {
        try {
            $request->validate([
                'cantidad' => 'required|numeric|min:0.001',
                'almacen_id' => 'required|exists:almacenes,id',
                'referencia_tipo' => 'nullable|string|max:50',
                'referencia_folio' => 'nullable|string|max:50',
                'observaciones' => 'nullable|string'
            ]);
            
            DB::beginTransaction();
            
            $inventario = InventarioProyecto::findOrFail($id);
            $inventario->agregarStock(
                $request->cantidad,
                $request->almacen_id,
                $request->observaciones,
                $request->referencia_tipo,
                $request->referencia_folio
            );
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Stock agregado exitosamente',
                'data' => [
                    'cantidad_actual' => $inventario->cantidad_actual,
                    'disponible' => $inventario->disponible
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al agregar stock: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar stock: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Remove stock from inventory.
     */
    public function retirarStock(Request $request, $id)
    {
        try {
            $request->validate([
                'cantidad' => 'required|numeric|min:0.001',
                'almacen_id' => 'required|exists:almacenes,id',
                'referencia_tipo' => 'nullable|string|max:50',
                'referencia_folio' => 'nullable|string|max:50',
                'observaciones' => 'nullable|string'
            ]);
            
            DB::beginTransaction();
            
            $inventario = InventarioProyecto::findOrFail($id);
            $inventario->retirarStock(
                $request->cantidad,
                $request->almacen_id,
                $request->observaciones,
                $request->referencia_tipo,
                $request->referencia_folio
            );
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Stock retirado exitosamente',
                'data' => [
                    'cantidad_actual' => $inventario->cantidad_actual,
                    'disponible' => $inventario->disponible
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al retirar stock: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
    
    /**
     * Transfer stock between warehouses.
     */
    public function transferirStock(Request $request, $id)
    {
        try {
            $request->validate([
                'cantidad' => 'required|numeric|min:0.001',
                'almacen_origen_id' => 'required|exists:almacenes,id',
                'almacen_destino_id' => 'required|exists:almacenes,id|different:almacen_origen_id',
                'observaciones' => 'nullable|string'
            ]);
            
            DB::beginTransaction();
            
            $inventario = InventarioProyecto::findOrFail($id);
            
            // Retirar del almacén origen
            $inventario->retirarStock(
                $request->cantidad,
                $request->almacen_origen_id,
                $request->observaciones,
                'Transferencia',
                null
            );
            
            // Agregar al almacén destino
            $inventario->agregarStock(
                $request->cantidad,
                $request->almacen_destino_id,
                $request->observaciones,
                'Transferencia',
                null
            );
            
            // Registrar movimiento de transferencia
            MovimientoInventario::create([
                'inventario_proyecto_id' => $inventario->id,
                'almacen_origen_id' => $request->almacen_origen_id,
                'almacen_destino_id' => $request->almacen_destino_id,
                'tipo_movimiento' => 'Transferencia',
                'cantidad' => $request->cantidad,
                'cantidad_antes' => $inventario->cantidad_actual,
                'cantidad_despues' => $inventario->cantidad_actual,
                'observaciones' => $request->observaciones,
                'fecha_movimiento' => now(),
                'creado_por' => auth()->id()
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Stock transferido exitosamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al transferir stock: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
    
    /**
     * Get inventory summary by project.
     */
    public function getResumenPorProyecto($proyectoId)
    {
        try {
            $inventario = InventarioProyecto::with(['articulo'])
                ->where('proyecto_id', $proyectoId)
                ->where('estatus', 'Activo')
                ->get();
            
            $totalArticulos = $inventario->count();
            $valorTotalInventario = 0; // Se puede agregar costo más adelante
            $articulosBajoStock = $inventario->filter(function($item) {
                return $item->estaBajoStock;
            })->count();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'total_articulos' => $totalArticulos,
                    'valor_total' => $valorTotalInventario,
                    'articulos_bajo_stock' => $articulosBajoStock,
                    'detalle' => $inventario->map(function($item) {
                        return [
                            'articulo_codigo' => $item->articulo->codigo,
                            'articulo_descripcion' => $item->articulo->descripcion,
                            'disponible' => $item->disponible,
                            'punto_reorden' => $item->punto_reorden,
                            'bajo_stock' => $item->estaBajoStock
                        ];
                    })
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar resumen: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Export to Excel.
     */
    public function exportar(Request $request)
    {
        try {
            $query = InventarioProyecto::with(['proyecto', 'articulo']);
            
            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            $inventario = $query->orderBy('proyecto_id')->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Exportación en desarrollo',
                'total' => $inventario->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }
}