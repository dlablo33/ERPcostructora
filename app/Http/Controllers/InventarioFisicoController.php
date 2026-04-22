<?php

namespace App\Http\Controllers;

use App\Models\InventarioProyecto;
use App\Models\Proyecto;
use App\Models\Articulo;
use App\Models\Almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioFisicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        $articulos = Articulo::where('estatus', 'Activo')->orderBy('codigo')->get();
        $almacenes = Almacen::where('estatus', 'Activo')->orderBy('nombre')->get();
        
        return view('almacen.existencia.inventario', compact('proyectos', 'articulos', 'almacenes'));
    }
    
    /**
     * Get inventario for DataTable.
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
            
            if ($request->filled('almacen_id')) {
                $query->whereHas('ubicaciones', function($q) use ($request) {
                    $q->where('almacen_id', $request->almacen_id);
                });
            }
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('articulo', function($q) use ($search) {
                    $q->where('codigo', 'LIKE', "%{$search}%")
                      ->orWhere('descripcion', 'LIKE', "%{$search}%");
                })->orWhereHas('proyecto', function($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('codigo', 'LIKE', "%{$search}%");
                });
            }
            
            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);
            
            $inventario = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
            
            $data = $inventario->getCollection()->map(function($item) {
                // Obtener la cantidad por almacén
                $ubicaciones = $item->ubicaciones->map(function($ubi) {
                    return [
                        'almacen_id' => $ubi->almacen_id,
                        'almacen_nombre' => $ubi->almacen->nombre,
                        'cantidad' => $ubi->cantidad,
                        'ubicacion_especifica' => $ubi->ubicacion_especifica,
                        'lote' => $ubi->lote
                    ];
                });
                
                $totalPorAlmacenes = $item->ubicaciones->sum('cantidad');
                
                return [
                    'id' => $item->id,
                    'proyecto_id' => $item->proyecto_id,
                    'proyecto_nombre' => $item->proyecto->nombre,
                    'proyecto_codigo' => $item->proyecto->codigo,
                    'articulo_id' => $item->articulo_id,
                    'articulo_codigo' => $item->articulo->codigo,
                    'articulo_descripcion' => $item->articulo->descripcion,
                    'unidad_medida' => $item->unidad_medida,
                    'cantidad_actual' => $item->cantidad_actual,
                    'disponible' => $item->disponible,
                    'cantidad_minima' => $item->cantidad_minima,
                    'cantidad_maxima' => $item->cantidad_maxima,
                    'punto_reorden' => $item->punto_reorden,
                    'bajo_stock' => $item->estaBajoStock,
                    'ultima_entrada' => $item->ultima_entrada ? $item->ultima_entrada->format('d/m/Y') : null,
                    'ultima_salida' => $item->ultima_salida ? $item->ultima_salida->format('d/m/Y') : null,
                    'ubicaciones' => $ubicaciones,
                    'total_por_almacenes' => $totalPorAlmacenes,
                    'estatus' => $item->estatus
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
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar inventario: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get inventory details for a specific item.
     */
    public function show($id)
    {
        try {
            $inventario = InventarioProyecto::with(['proyecto', 'articulo', 'ubicaciones.almacen'])
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $inventario->id,
                    'proyecto_nombre' => $inventario->proyecto->nombre,
                    'articulo_codigo' => $inventario->articulo->codigo,
                    'articulo_descripcion' => $inventario->articulo->descripcion,
                    'unidad_medida' => $inventario->unidad_medida,
                    'cantidad_actual' => $inventario->cantidad_actual,
                    'disponible' => $inventario->disponible,
                    'cantidad_minima' => $inventario->cantidad_minima,
                    'cantidad_maxima' => $inventario->cantidad_maxima,
                    'punto_reorden' => $inventario->punto_reorden,
                    'observaciones' => $inventario->observaciones,
                    'ubicaciones' => $inventario->ubicaciones->map(function($ubi) {
                        return [
                            'almacen_nombre' => $ubi->almacen->nombre,
                            'cantidad' => $ubi->cantidad,
                            'ubicacion_especifica' => $ubi->ubicacion_especifica,
                            'lote' => $ubi->lote
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
     * Export to Excel.
     */
    public function exportar(Request $request)
    {
        try {
            $query = InventarioProyecto::with(['proyecto', 'articulo']);
            
            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            $inventario = $query->get();
            
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