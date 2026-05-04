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
     * Get inventario for DataTable (MODIFICADO para incluir costos)
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
                
                // Calcular costo e importe
                $costo = $item->costo_promedio ?? $item->ultimo_costo ?? 0;
                $importe = $item->cantidad_actual * $costo;
                $valorInventario = $importe;
                
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
                    'costo_unitario' => $costo,
                    'importe' => $importe,
                    'valor_inventario' => $valorInventario,
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
            
            // Calcular totales generales
            $totalValorInventario = $data->sum('valor_inventario');
            $totalArticulos = $data->sum('cantidad_actual');
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'total' => $inventario->total(),
                'per_page' => $inventario->perPage(),
                'current_page' => $inventario->currentPage(),
                'last_page' => $inventario->lastPage(),
                'totales' => [
                    'total_valor' => $totalValorInventario,
                    'total_articulos' => $totalArticulos
                ]
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
                'costo_inicial' => 'nullable|numeric|min:0',
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
            $costoInicial = $request->costo_inicial ?? 0;
            
            $inventario = InventarioProyecto::create([
                'proyecto_id' => $request->proyecto_id,
                'articulo_id' => $request->articulo_id,
                'cantidad_actual' => $request->cantidad_inicial,
                'cantidad_reservada' => 0,
                'cantidad_minima' => $request->cantidad_minima ?? 0,
                'cantidad_maxima' => $request->cantidad_maxima ?? 0,
                'punto_reorden' => $request->punto_reorden ?? 0,
                'unidad_medida' => $articulo->unidad_medida,
                'costo_promedio' => $costoInicial > 0 ? $costoInicial : null,
                'ultimo_costo' => $costoInicial > 0 ? $costoInicial : null,
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
                    'costo_unitario' => $costoInicial > 0 ? $costoInicial : null,
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
     * Display the specified resource (MODIFICADO para incluir costos)
     */
    public function show($id)
    {
        try {
            $inventario = InventarioProyecto::with(['proyecto', 'articulo', 'ubicaciones.almacen', 'movimientos' => function($q) {
                $q->orderBy('fecha_movimiento', 'desc')->limit(50);
            }])->findOrFail($id);
            
            $costo = $inventario->costo_promedio ?? $inventario->ultimo_costo ?? 0;
            $valorInventario = $inventario->cantidad_actual * $costo;
            
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
                    'costo_promedio' => $inventario->costo_promedio,
                    'ultimo_costo' => $inventario->ultimo_costo,
                    'ultimo_costo_compra' => $inventario->ultimo_costo_compra,
                    'valor_inventario' => $valorInventario,
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
                            'costo_unitario' => $mov->costo_unitario,
                            'importe' => ($mov->costo_unitario ?? 0) * $mov->cantidad,
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
     * Add stock to inventory (MODIFICADO para aceptar costo)
     */
    public function agregarStock(Request $request, $id)
    {
        try {
            $request->validate([
                'cantidad' => 'required|numeric|min:0.001',
                'almacen_id' => 'required|exists:almacenes,id',
                'costo_unitario' => 'nullable|numeric|min:0',
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
                $request->referencia_folio,
                $request->costo_unitario
            );
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Stock agregado exitosamente',
                'data' => [
                    'cantidad_actual' => $inventario->cantidad_actual,
                    'disponible' => $inventario->disponible,
                    'costo_promedio' => $inventario->costo_promedio,
                    'ultimo_costo' => $inventario->ultimo_costo
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
                null,
                $inventario->costo_promedio // Usar costo promedio para la transferencia
            );
            
            // Registrar movimiento de transferencia
            MovimientoInventario::create([
                'inventario_proyecto_id' => $inventario->id,
                'almacen_origen_id' => $request->almacen_origen_id,
                'almacen_destino_id' => $request->almacen_destino_id,
                'tipo_movimiento' => 'Transferencia',
                'cantidad' => $request->cantidad,
                'costo_unitario' => $inventario->costo_promedio ?? $inventario->ultimo_costo ?? 0,
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
     * Get inventory summary by project (MODIFICADO para incluir costos)
     */
    public function getResumenPorProyecto($proyectoId)
    {
        try {
            $inventario = InventarioProyecto::with(['articulo'])
                ->where('proyecto_id', $proyectoId)
                ->where('estatus', 'Activo')
                ->get();
            
            $totalArticulos = $inventario->count();
            $valorTotalInventario = $inventario->sum(function($item) {
                $costo = $item->costo_promedio ?? $item->ultimo_costo ?? 0;
                return $item->cantidad_actual * $costo;
            });
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
                        $costo = $item->costo_promedio ?? $item->ultimo_costo ?? 0;
                        return [
                            'articulo_codigo' => $item->articulo->codigo,
                            'articulo_descripcion' => $item->articulo->descripcion,
                            'disponible' => $item->disponible,
                            'costo_unitario' => $costo,
                            'valor_inventario' => $item->disponible * $costo,
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
     * Export to Excel (MODIFICADO para incluir costos)
     */
    public function exportar(Request $request)
    {
        try {
            $query = InventarioProyecto::with(['proyecto', 'articulo']);
            
            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            $inventario = $query->orderBy('proyecto_id')->get();
            
            $data = $inventario->map(function($item) {
                return [
                    'proyecto' => $item->proyecto->nombre,
                    'codigo' => $item->articulo->codigo,
                    'descripcion' => $item->articulo->descripcion,
                    'unidad' => $item->unidad_medida,
                    'cantidad' => $item->cantidad_actual,
                    'costo_promedio' => $item->costo_promedio,
                    'ultimo_costo' => $item->ultimo_costo,
                    'valor_inventario' => $item->cantidad_actual * ($item->costo_promedio ?? $item->ultimo_costo ?? 0),
                    'minimo' => $item->cantidad_minima,
                    'maximo' => $item->cantidad_maxima,
                    'punto_reorden' => $item->punto_reorden,
                    'estatus' => $item->estatus
                ];
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Exportación en desarrollo',
                'total' => $inventario->count(),
                'data_preview' => $data->take(10)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Actualizar costo promedio manualmente
     */
    public function actualizarCosto(Request $request, $id)
    {
        try {
            $request->validate([
                'costo' => 'required|numeric|min:0',
                'tipo' => 'required|in:promedio,ultimo'
            ]);
            
            DB::beginTransaction();
            
            $inventario = InventarioProyecto::findOrFail($id);
            
            if ($request->tipo === 'promedio') {
                $inventario->costo_promedio = $request->costo;
            } else {
                $inventario->ultimo_costo = $request->costo;
            }
            
            $inventario->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Costo actualizado exitosamente',
                'data' => [
                    'costo_promedio' => $inventario->costo_promedio,
                    'ultimo_costo' => $inventario->ultimo_costo
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar costo: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar costo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get inventario for Almacen por Obra view
     */
    /**
 * Get inventario for Almacen por Obra view
 */
public function getInventarioPorObra(Request $request)
{
    try {
        $query = InventarioProyecto::with(['proyecto', 'articulo.familia', 'articulo.subfamilia'])
            ->where('estatus', 'Activo');
        
        // FILTRO POR PROYECTO (OBRA)
        if ($request->filled('proyecto_id') && $request->proyecto_id !== 'todas') {
            $query->where('proyecto_id', (int)$request->proyecto_id);
        }
        
        // Búsqueda general
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('articulo', function($q) use ($search) {
                $q->where('codigo', 'LIKE', "%{$search}%")
                  ->orWhere('descripcion', 'LIKE', "%{$search}%");
            });
        }
        
        // Filtrar por categoría (familia)
        if ($request->filled('categoria') && $request->categoria !== 'todas') {
            $query->whereHas('articulo.familia', function($q) use ($request) {
                $q->where('nombre', $request->categoria);
            });
        }
        
        // Filtrar por subfamilia
        if ($request->filled('familia') && $request->familia !== 'todas') {
            $query->whereHas('articulo.subfamilia', function($q) use ($request) {
                $q->where('nombre', $request->familia);
            });
        }
        
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);
        
        $inventario = $query->orderBy('id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);
        
        $data = $inventario->getCollection()->map(function($item) {
            $costo = floatval($item->costo_promedio ?? $item->ultimo_costo ?? 0);
            $importe = floatval($item->cantidad_actual) * $costo;
            $cantidad = floatval($item->cantidad_actual);
            $minimo = floatval($item->cantidad_minima);
            
            if ($minimo > 0) {
                if ($cantidad <= ($minimo / 2)) {
                    $estatus = 'Crítico';
                } elseif ($cantidad <= $minimo) {
                    $estatus = 'Bajo';
                } else {
                    $estatus = 'Normal';
                }
            } else {
                $estatus = 'Normal';
            }
            
            return [
                'id' => $item->id,
                'codigo' => $item->articulo->codigo ?? '---',
                'descripcion' => $item->articulo->descripcion ?? '---',
                'categoria' => $item->articulo->familia->nombre ?? 'Sin categoría',
                'familia' => $item->articulo->subfamilia->nombre ?? $item->articulo->familia->nombre ?? 'Sin familia',
                'cantidad' => $cantidad,
                'unidad' => $item->unidad_medida ?? $item->articulo->unidad_medida ?? 'Pieza',
                'costo' => $costo,
                'importe' => $importe,
                'minimo' => $minimo,
                'maximo' => floatval($item->cantidad_maxima),
                'estatus' => $estatus
            ];
        });
        
        // Calcular KPIs (usando el mismo query con filtros)
        $queryKpi = clone $query;
        $allItems = $queryKpi->get();
        
        $totalArticulos = $allItems->sum(function($item) {
            return floatval($item->cantidad_actual);
        });
        
        $valorInventario = $allItems->sum(function($item) {
            $costo = floatval($item->costo_promedio ?? $item->ultimo_costo ?? 0);
            return floatval($item->cantidad_actual) * $costo;
        });
        
        $bajoMinimo = $allItems->filter(function($item) {
            $cantidad = floatval($item->cantidad_actual);
            $minimo = floatval($item->cantidad_minima);
            return $minimo > 0 && $cantidad <= $minimo && $cantidad > ($minimo / 2);
        })->count();
        
        $critico = $allItems->filter(function($item) {
            $cantidad = floatval($item->cantidad_actual);
            $minimo = floatval($item->cantidad_minima);
            return $minimo > 0 && $cantidad <= ($minimo / 2);
        })->count();
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'total' => $inventario->total(),
            'per_page' => $inventario->perPage(),
            'current_page' => $inventario->currentPage(),
            'last_page' => $inventario->lastPage(),
            'kpis' => [
                'total_articulos' => $totalArticulos,
                'valor_inventario' => $valorInventario,
                'bajo_minimo' => $bajoMinimo,
                'critico' => $critico
            ]
        ]);
        
    } catch (\Exception $e) {
        Log::error('Error en getInventarioPorObra: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Get filtros para catálogos (categorías y familias)
     */
    public function getFiltrosCatalogos()
    {
        try {
            $categorias = \App\Models\Familia::where('estatus', 'Activo')->select('nombre')->distinct()->get();
            $familias = \App\Models\Subfamilia::where('estatus', 'Activo')->select('nombre')->distinct()->get();
            
            return response()->json([
                'success' => true,
                'categorias' => $categorias,
                'familias' => $familias
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}