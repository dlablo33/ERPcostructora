<?php

namespace App\Http\Controllers;

use App\Models\RequisicionMaterial;
use App\Models\RequisicionMaterialDetalle;
use App\Models\Proyecto;
use App\Models\Articulo;
use App\Models\Almacen;
use App\Models\InventarioProyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RequisicionMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        $articulos = Articulo::where('estatus', 'Activo')->orderBy('codigo')->get();
        $almacenes = Almacen::where('estatus', 'Activo')->orderBy('nombre')->get();
        
        return view('almacen.existencia.reqproyecto', compact('proyectos', 'articulos', 'almacenes'));
    }
    
    /**
     * Get requisiciones for DataTable.
     */
    public function getRequisiciones(Request $request)
    {
        try {
            $query = RequisicionMaterial::with(['proyecto', 'autorizador', 'creador']);
            
            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }
            
            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha_requisicion', '>=', $request->fecha_inicio);
            }
            
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha_requisicion', '<=', $request->fecha_fin);
            }
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('folio', 'LIKE', "%{$search}%")
                      ->orWhere('solicitante', 'LIKE', "%{$search}%");
                });
            }
            
            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);
            
            $requisiciones = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
            
            $data = $requisiciones->getCollection()->map(function($req) {
                return [
                    'id' => $req->id,
                    'folio' => $req->folio,
                    'proyecto_id' => $req->proyecto_id,
                    'proyecto_nombre' => $req->proyecto->nombre,
                    'fecha_requisicion' => $req->fecha_requisicion->format('d/m/Y'),
                    'solicitante' => $req->solicitante,
                    'area' => $req->area,
                    'prioridad' => $req->prioridad,
                    'estatus' => $req->estatus,
                    'porcentaje_surtido' => $req->porcentajeSurtido,
                    'autorizado_por' => $req->autorizador ? $req->autorizador->name : null,
                    'fecha_autorizacion' => $req->fecha_autorizacion ? $req->fecha_autorizacion->format('d/m/Y H:i') : null,
                    'motivo_rechazo' => $req->motivo_rechazo,
                    'created_at' => $req->created_at->format('d/m/Y H:i')
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'total' => $requisiciones->total(),
                'per_page' => $requisiciones->perPage(),
                'current_page' => $requisiciones->currentPage(),
                'last_page' => $requisiciones->lastPage()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getRequisiciones: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar requisiciones: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Store a newly created requisition.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'proyecto_id' => 'required|exists:proyectos,id',
                'fecha_requisicion' => 'required|date',
                'solicitante' => 'required|string|max:100',
                'area' => 'nullable|string|max:100',
                'prioridad' => 'required|in:Alta,Media,Baja',
                'observaciones' => 'nullable|string',
                'articulos' => 'required|array|min:1',
                'articulos.*.articulo_id' => 'required|exists:articulos,id',
                'articulos.*.cantidad_solicitada' => 'required|numeric|min:0.001'
            ]);
            
            DB::beginTransaction();
            
            $requisicion = RequisicionMaterial::create([
                'proyecto_id' => $request->proyecto_id,
                'folio' => (new RequisicionMaterial())->generarFolio(),
                'fecha_requisicion' => $request->fecha_requisicion,
                'solicitante' => $request->solicitante,
                'area' => $request->area,
                'prioridad' => $request->prioridad,
                'estatus' => 'Pendiente',
                'observaciones' => $request->observaciones,
                'creado_por' => auth()->id()
            ]);
            
            foreach ($request->articulos as $articuloData) {
                $articulo = Articulo::find($articuloData['articulo_id']);
                
                RequisicionMaterialDetalle::create([
                    'requisicion_id' => $requisicion->id,
                    'articulo_id' => $articuloData['articulo_id'],
                    'cantidad_solicitada' => $articuloData['cantidad_solicitada'],
                    'cantidad_autorizada' => 0,
                    'cantidad_surtida' => 0,
                    'unidad_medida' => $articulo->unidad_medida,
                    'observacion' => $articuloData['observacion'] ?? null
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Requisición creada exitosamente',
                'data' => $requisicion->load(['proyecto', 'detalles.articulo'])
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear requisición: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al crear requisición: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Display the specified requisition.
     */
    public function show($id)
    {
        try {
            $requisicion = RequisicionMaterial::with([
                'proyecto', 
                'detalles.articulo', 
                'autorizador', 
                'creador'
            ])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $requisicion->id,
                    'folio' => $requisicion->folio,
                    'proyecto_id' => $requisicion->proyecto_id,
                    'proyecto_nombre' => $requisicion->proyecto->nombre,
                    'fecha_requisicion' => $requisicion->fecha_requisicion->format('Y-m-d'),
                    'solicitante' => $requisicion->solicitante,
                    'area' => $requisicion->area,
                    'prioridad' => $requisicion->prioridad,
                    'estatus' => $requisicion->estatus,
                    'observaciones' => $requisicion->observaciones,
                    'motivo_rechazo' => $requisicion->motivo_rechazo,
                    'porcentaje_surtido' => $requisicion->porcentajeSurtido,
                    'detalles' => $requisicion->detalles->map(function($detalle) use ($requisicion) {
                        $inventario = InventarioProyecto::where('proyecto_id', $requisicion->proyecto_id)
                            ->where('articulo_id', $detalle->articulo_id)
                            ->first();
                        
                        return [
                            'id' => $detalle->id,
                            'articulo_id' => $detalle->articulo_id,
                            'articulo_codigo' => $detalle->articulo->codigo,
                            'articulo_descripcion' => $detalle->articulo->descripcion,
                            'unidad_medida' => $detalle->unidad_medida,
                            'cantidad_solicitada' => $detalle->cantidad_solicitada,
                            'cantidad_autorizada' => $detalle->cantidad_autorizada,
                            'cantidad_surtida' => $detalle->cantidad_surtida,
                            'disponible' => $inventario ? $inventario->disponible : 0,
                            'observacion' => $detalle->observacion
                        ];
                    })
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Requisición no encontrada'
            ], 404);
        }
    }
    
    /**
     * Authorize requisition.
     */
    public function autorizar(Request $request, $id)
    {
        try {
            $request->validate([
                'observaciones' => 'nullable|string',
                'articulos' => 'required|array',
                'articulos.*.detalle_id' => 'required|exists:requisicion_material_detalle,id',
                'articulos.*.cantidad_autorizada' => 'required|numeric|min:0'
            ]);
            
            DB::beginTransaction();
            
            $requisicion = RequisicionMaterial::findOrFail($id);
            
            if ($requisicion->estatus !== 'Pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'La requisición no está en estado Pendiente'
                ], 400);
            }
            
            // Actualizar cantidades autorizadas
            foreach ($request->articulos as $item) {
                $detalle = RequisicionMaterialDetalle::find($item['detalle_id']);
                $detalle->cantidad_autorizada = $item['cantidad_autorizada'];
                $detalle->save();
            }
            
            $requisicion->autorizar(auth()->id(), $request->observaciones);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Requisición autorizada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al autorizar requisición: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al autorizar requisición: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Reject requisition.
     */
    public function rechazar(Request $request, $id)
    {
        try {
            $request->validate([
                'motivo' => 'required|string|min:5'
            ]);
            
            DB::beginTransaction();
            
            $requisicion = RequisicionMaterial::findOrFail($id);
            
            if ($requisicion->estatus !== 'Pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'La requisición no está en estado Pendiente'
                ], 400);
            }
            
            $requisicion->rechazar(auth()->id(), $request->motivo);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Requisición rechazada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al rechazar requisición: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al rechazar requisición: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Generate picking list (surtido).
     */
    public function generarSurtido($id)
    {
        try {
            $requisicion = RequisicionMaterial::with(['detalles.articulo', 'proyecto'])->findOrFail($id);
            
            if ($requisicion->estatus !== 'Autorizada') {
                return response()->json([
                    'success' => false,
                    'message' => 'La requisición debe estar Autorizada para generar surtido'
                ], 400);
            }
            
            $items = [];
            $sinStock = [];
            
            foreach ($requisicion->detalles as $detalle) {
                if ($detalle->cantidad_autorizada <= 0) continue;
                
                $inventario = InventarioProyecto::where('proyecto_id', $requisicion->proyecto_id)
                    ->where('articulo_id', $detalle->articulo_id)
                    ->first();
                
                $disponible = $inventario ? $inventario->disponible : 0;
                $porSurtir = $detalle->cantidad_autorizada - $detalle->cantidad_surtida;
                
                if ($porSurtir <= 0) continue;
                
                if ($disponible >= $porSurtir) {
                    $items[] = [
                        'detalle_id' => $detalle->id,
                        'articulo_codigo' => $detalle->articulo->codigo,
                        'articulo_descripcion' => $detalle->articulo->descripcion,
                        'cantidad_solicitada' => $porSurtir,
                        'disponible' => $disponible,
                        'puede_surtir' => true
                    ];
                } else {
                    $sinStock[] = [
                        'detalle_id' => $detalle->id,
                        'articulo_codigo' => $detalle->articulo->codigo,
                        'articulo_descripcion' => $detalle->articulo->descripcion,
                        'cantidad_solicitada' => $porSurtir,
                        'disponible' => $disponible,
                        'faltante' => $porSurtir - $disponible
                    ];
                }
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'requisicion' => [
                        'id' => $requisicion->id,
                        'folio' => $requisicion->folio,
                        'proyecto' => $requisicion->proyecto->nombre
                    ],
                    'items_a_surtir' => $items,
                    'items_sin_stock' => $sinStock,
                    'tiene_stock_suficiente' => count($sinStock) === 0
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al generar surtido: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al generar surtido: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Execute picking (surtido).
     */
    public function ejecutarSurtido(Request $request, $id)
    {
        try {
            $request->validate([
                'almacen_id' => 'required|exists:almacenes,id',
                'items' => 'required|array',
                'items.*.detalle_id' => 'required|exists:requisicion_material_detalle,id',
                'items.*.cantidad' => 'required|numeric|min:0.001'
            ]);
            
            DB::beginTransaction();
            
            $requisicion = RequisicionMaterial::findOrFail($id);
            
            if ($requisicion->estatus !== 'Autorizada') {
                return response()->json([
                    'success' => false,
                    'message' => 'La requisición debe estar Autorizada para surtir'
                ], 400);
            }
            
            foreach ($request->items as $item) {
                $detalle = RequisicionMaterialDetalle::find($item['detalle_id']);
                
                if ($detalle->cantidad_surtida + $item['cantidad'] > $detalle->cantidad_autorizada) {
                    throw new \Exception('La cantidad a surtir excede lo autorizado');
                }
                
                // Retirar del inventario
                $inventario = InventarioProyecto::where('proyecto_id', $requisicion->proyecto_id)
                    ->where('articulo_id', $detalle->articulo_id)
                    ->first();
                
                if (!$inventario) {
                    throw new \Exception('No hay inventario para el artículo ' . $detalle->articulo->codigo);
                }
                
                $inventario->retirarStock(
                    $item['cantidad'],
                    $request->almacen_id,
                    "Surtido requisición {$requisicion->folio}",
                    'RequisicionMaterial',
                    $requisicion->id
                );
                
                // Actualizar detalle
                $detalle->cantidad_surtida += $item['cantidad'];
                $detalle->save();
            }
            
            // Verificar si la requisición está completamente surtida
            $completa = true;
            foreach ($requisicion->detalles as $detalle) {
                if ($detalle->cantidad_surtida < $detalle->cantidad_autorizada) {
                    $completa = false;
                    break;
                }
            }
            
            if ($completa) {
                $requisicion->update(['estatus' => 'Surtida']);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Surtido realizado exitosamente',
                'completa' => $completa
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al ejecutar surtido: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
    
    /**
     * Delete requisition.
     */
    public function destroy($id)
    {
        try {
            $requisicion = RequisicionMaterial::findOrFail($id);
            
            if ($requisicion->estatus !== 'Pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden eliminar requisiciones en estado Pendiente'
                ], 400);
            }
            
            $requisicion->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Requisición eliminada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar requisición: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar requisición: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Export requisitions to Excel.
     */
    public function exportar(Request $request)
    {
        try {
            $query = RequisicionMaterial::with(['proyecto']);
            
            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }
            
            $requisiciones = $query->orderBy('id', 'desc')->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Exportación en desarrollo',
                'total' => $requisiciones->count()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }
}