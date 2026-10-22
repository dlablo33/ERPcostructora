<?php

namespace App\Http\Controllers;

use App\Models\InventarioProyecto;
use App\Models\Proyecto;
use App\Models\Articulo;
use App\Models\Almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InventarioFisicoController extends Controller
{
    /**
     * Mostrar la vista principal del inventario físico.
     */
    public function index()
    {
        $proyectos = Proyecto::where('status', 'activo')
            ->orderBy('nombre')
            ->get(['id', 'codigo', 'nombre']);

        $articulos = Articulo::where('estatus', 'Activo')
            ->orderBy('codigo')
            ->get(['id', 'codigo', 'descripcion']);

        $almacenes = Almacen::where('estatus', 'Activo')
            ->orderBy('nombre')
            ->get(['id', 'codigo', 'nombre']);

        return view('almacen.existencia.inventario', compact('proyectos', 'articulos', 'almacenes'));
    }

    /**
     * Obtener el listado paginado de inventario (API JSON).
     */
    public function getInventario(Request $request)
    {
        try {
            $query = InventarioProyecto::with([
                'proyecto:id,codigo,nombre',
                'articulo:id,codigo,descripcion',
                'ubicaciones.almacen:id,nombre,codigo'
            ]);

            // Filtros
            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }

            if ($request->filled('articulo_id')) {
                $query->where('articulo_id', $request->articulo_id);
            }

            if ($request->filled('almacen_id')) {
                $query->whereHas('ubicaciones', function ($q) use ($request) {
                    $q->where('almacen_id', $request->almacen_id);
                });
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->whereHas('articulo', function ($sub) use ($search) {
                        $sub->where('codigo', 'LIKE', "%{$search}%")
                            ->orWhere('descripcion', 'LIKE', "%{$search}%");
                    })->orWhereHas('proyecto', function ($sub) use ($search) {
                        $sub->where('nombre', 'LIKE', "%{$search}%")
                            ->orWhere('codigo', 'LIKE', "%{$search}%");
                    });
                });
            }

            $perPage = (int) $request->get('per_page', 10);
            $page    = (int) $request->get('page', 1);

            $inventario = $query->orderBy('id', 'desc')
                ->paginate($perPage, ['*'], 'page', $page);

            $data = $inventario->getCollection()->map(function ($item) {
                $ubicaciones = $item->ubicaciones->map(function ($ubi) {
                    return [
                        'almacen_id'           => $ubi->almacen_id,
                        'almacen_nombre'       => optional($ubi->almacen)->nombre ?? 'N/A',
                        'almacen_codigo'       => optional($ubi->almacen)->codigo ?? '',
                        'cantidad'             => $ubi->cantidad,
                        'ubicacion_especifica' => $ubi->ubicacion_especifica ?? null,
                        'lote'                 => $ubi->lote ?? null,
                    ];
                });

                $totalPorAlmacenes = $item->ubicaciones->sum('cantidad');

                // Cálculo manual de bajo stock (no dependemos del accessor)
                $bajoStock = false;
                if ($item->punto_reorden !== null && $item->cantidad_actual <= $item->punto_reorden) {
                    $bajoStock = true;
                }

                return [
                    'id'                    => $item->id,
                    'proyecto_id'           => $item->proyecto_id,
                    'proyecto_nombre'       => optional($item->proyecto)->nombre,
                    'proyecto_codigo'       => optional($item->proyecto)->codigo,
                    'articulo_id'           => $item->articulo_id,
                    'articulo_codigo'       => optional($item->articulo)->codigo,
                    'articulo_descripcion'  => optional($item->articulo)->descripcion,
                    'unidad_medida'         => $item->unidad_medida,
                    'cantidad_actual'       => $item->cantidad_actual,
                    'disponible'            => $item->disponible,
                    'cantidad_minima'       => $item->cantidad_minima,
                    'cantidad_maxima'       => $item->cantidad_maxima,
                    'punto_reorden'         => $item->punto_reorden,
                    'bajo_stock'            => $bajoStock,
                    'ultima_entrada'        => $item->ultima_entrada
                                                ? \Carbon\Carbon::parse($item->ultima_entrada)->format('d/m/Y')
                                                : null,
                    'ultima_salida'         => $item->ultima_salida
                                                ? \Carbon\Carbon::parse($item->ultima_salida)->format('d/m/Y')
                                                : null,
                    'ubicaciones'           => $ubicaciones,
                    'total_por_almacenes'   => $totalPorAlmacenes,
                    'estatus'               => $item->estatus,
                ];
            });

            return response()->json([
                'success'      => true,
                'data'         => $data,
                'total'        => $inventario->total(),
                'per_page'     => $inventario->perPage(),
                'current_page' => $inventario->currentPage(),
                'last_page'    => $inventario->lastPage(),
            ]);

        } catch (\Exception $e) {
            Log::error('Error en InventarioFisicoController@getInventario: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar inventario: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mostrar el detalle de un registro de inventario.
     */
    public function show($id)
    {
        try {
            $inventario = InventarioProyecto::with([
                'proyecto:id,codigo,nombre',
                'articulo:id,codigo,descripcion',
                'ubicaciones.almacen:id,nombre,codigo'
            ])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data'    => [
                    'id'                   => $inventario->id,
                    'proyecto_nombre'      => optional($inventario->proyecto)->nombre,
                    'proyecto_codigo'      => optional($inventario->proyecto)->codigo,
                    'articulo_codigo'      => optional($inventario->articulo)->codigo,
                    'articulo_descripcion' => optional($inventario->articulo)->descripcion,
                    'unidad_medida'        => $inventario->unidad_medida,
                    'cantidad_actual'      => $inventario->cantidad_actual,
                    'disponible'           => $inventario->disponible,
                    'cantidad_minima'      => $inventario->cantidad_minima,
                    'cantidad_maxima'      => $inventario->cantidad_maxima,
                    'punto_reorden'        => $inventario->punto_reorden,
                    'observaciones'        => $inventario->observaciones,
                    'ubicaciones'          => $inventario->ubicaciones->map(function ($ubi) {
                        return [
                            'almacen_nombre'       => optional($ubi->almacen)->nombre ?? 'N/A',
                            'cantidad'             => $ubi->cantidad,
                            'ubicacion_especifica' => $ubi->ubicacion_especifica ?? null,
                            'lote'                 => $ubi->lote ?? null,
                        ];
                    }),
                ],
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registro de inventario no encontrado.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error en InventarioFisicoController@show: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el inventario: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Exportar inventario a Excel (CSV por defecto).
     */
    public function exportar(Request $request)
    {
        try {
            $query = InventarioProyecto::with([
                'proyecto:id,codigo,nombre',
                'articulo:id,codigo,descripcion',
            ]);

            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }

            if ($request->filled('articulo_id')) {
                $query->where('articulo_id', $request->articulo_id);
            }

            if ($request->filled('almacen_id')) {
                $query->whereHas('ubicaciones', function ($q) use ($request) {
                    $q->where('almacen_id', $request->almacen_id);
                });
            }

            $inventario = $query->orderBy('id', 'desc')->get();

            $filename = 'inventario_fisico_' . date('Y-m-d_His') . '.csv';

            $headers = [
                'Content-Type'        => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];

            $callback = function () use ($inventario) {
                $file = fopen('php://output', 'w');

                // BOM para que Excel abra bien los acentos
                fputs($file, "\xEF\xBB\xBF");

                fputcsv($file, [
                    'ID',
                    'Proyecto',
                    'Código Proyecto',
                    'Código Artículo',
                    'Descripción',
                    'Unidad',
                    'Stock Actual',
                    'Disponible',
                    'Mínimo',
                    'Máximo',
                    'Punto Reorden',
                    'Estatus',
                ]);

                foreach ($inventario as $item) {
                    fputcsv($file, [
                        $item->id,
                        optional($item->proyecto)->nombre,
                        optional($item->proyecto)->codigo,
                        optional($item->articulo)->codigo,
                        optional($item->articulo)->descripcion,
                        $item->unidad_medida,
                        $item->cantidad_actual,
                        $item->disponible,
                        $item->cantidad_minima,
                        $item->cantidad_maxima,
                        $item->punto_reorden,
                        $item->estatus,
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            Log::error('Error en InventarioFisicoController@exportar: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage(),
            ], 500);
        }
    }
}