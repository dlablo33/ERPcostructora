<?php
// app/Http/Controllers/CompraRecepcionController.php

namespace App\Http\Controllers;

use App\Models\Requisicion;
use App\Models\CotizacionArticulo;
use App\Models\RequisicionArticulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompraRecepcionController extends Controller
{
    /**
     * Obtener compras pendientes de recepción (AGRUPADAS POR REQUISICIÓN)
     * SOLO muestra órdenes que tienen al menos un artículo pendiente
     */
    public function pendientes(Request $request)
    {
        try {
            // Obtener cotizaciones seleccionadas con cantidad pendiente por recibir
            $cotizaciones = CotizacionArticulo::with(['requisicionArticulo.requisicion.proyecto', 'proveedor'])
                ->where('estatus', 'Seleccionada')
                ->whereHas('requisicionArticulo', function($q) {
                    $q->whereRaw('cantidad > COALESCE(cantidad_surtida, 0)');
                })
                ->get();
            
            // Agrupar por requisición
            $agrupadas = $cotizaciones->groupBy(function($item) {
                return $item->requisicionArticulo->requisicion_id;
            });
            
            // Filtrar solo las que tienen al menos un artículo pendiente
            $pendientes = $agrupadas->filter(function($items, $requisicionId) {
                $totalPendiente = $items->sum(function($item) {
                    $articulo = $item->requisicionArticulo;
                    return $articulo->cantidad - ($articulo->cantidad_surtida ?? 0);
                });
                return $totalPendiente > 0;
            })->map(function($items, $requisicionId) {
                $first = $items->first();
                $articulo = $first->requisicionArticulo;
                $totalPendiente = $items->sum(function($item) {
                    $articulo = $item->requisicionArticulo;
                    return $articulo->cantidad - ($articulo->cantidad_surtida ?? 0);
                });
                
                return [
                    'id' => $first->id,
                    'requisicion_id' => $requisicionId,
                    'folio_requisicion' => $articulo->requisicion->folio,
                    'proveedor_nombre' => $first->proveedor->nombre,
                    'proyecto_id' => $articulo->requisicion->proyecto_id,
                    'proyecto_nombre' => $articulo->requisicion->proyecto->nombre ?? 'N/A',
                    'total_articulos' => $items->count(),
                    'total_pendiente' => $totalPendiente
                ];
            })->values();
            
            return response()->json([
                'success' => true,
                'data' => $pendientes
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en pendientes: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener detalle de una compra específica (TODOS los artículos de la requisición)
     * SOLO muestra artículos con cantidad pendiente > 0
     */
    public function detalleCompra($id)
    {
        try {
            Log::info('=== detalleCompra llamado ===');
            Log::info('ID recibido: ' . $id);
            
            // Buscar la cotización para obtener la requisición_id
            $cotizacion = CotizacionArticulo::with(['requisicionArticulo.requisicion.proyecto', 'proveedor'])
                ->findOrFail($id);
            
            Log::info('Cotización encontrada, requisicion_articulo_id: ' . $cotizacion->requisicion_articulo_id);
            
            $requisicionId = $cotizacion->requisicionArticulo->requisicion_id;
            
            Log::info('Buscando artículos de requisición ID: ' . $requisicionId);
            
            // Obtener TODOS los artículos de la misma requisición
            $articulosRequisicion = RequisicionArticulo::where('requisicion_id', $requisicionId)->get();
            
            Log::info('Artículos encontrados en requisición: ' . $articulosRequisicion->count());
            
            $articulos = [];
            foreach ($articulosRequisicion as $articulo) {
                // Buscar la cotización seleccionada para este artículo
                $cotizacionSel = CotizacionArticulo::where('requisicion_articulo_id', $articulo->id)
                    ->where('estatus', 'Seleccionada')
                    ->first();
                
                $cantidadRecibida = $articulo->cantidad_surtida ?? 0;
                $cantidadPendiente = $articulo->cantidad - $cantidadRecibida;
                
                Log::info('Artículo ' . $articulo->codigo . ' - Pendiente: ' . $cantidadPendiente);
                
                // SOLO incluir artículos con cantidad pendiente > 0
                if ($cantidadPendiente > 0) {
                    // Asegurar que articulo_id sea válido
                    $articuloId = $articulo->articulo_id;
                    
                    // Si no tiene articulo_id o es 0, intentar buscar por código
                    if (!$articuloId || $articuloId == 0) {
                        $articuloExistente = \App\Models\Articulo::where('codigo', $articulo->codigo)->first();
                        if ($articuloExistente) {
                            $articuloId = $articuloExistente->id;
                            Log::info('Artículo encontrado por código: ' . $articulo->codigo . ' con ID: ' . $articuloId);
                        } else {
                            Log::warning('No se encontró artículo con código: ' . $articulo->codigo);
                        }
                    }
                    
                    $articulos[] = [
                        'id' => $cotizacionSel?->id ?? $articulo->id,
                        'requisicion_articulo_id' => $articulo->id,
                        'articulo_id' => (int)$articuloId,
                        'articulo_codigo' => $articulo->codigo,
                        'articulo_descripcion' => $articulo->descripcion,
                        'unidad_medida' => $articulo->unidad_medida,
                        'cantidad_total' => (float)$articulo->cantidad,
                        'cantidad_recibida' => (float)$cantidadRecibida,
                        'cantidad_pendiente' => (float)$cantidadPendiente,
                        'costo_unitario' => (float)($cotizacionSel?->precio_unitario ?? 0)
                    ];
                }
            }
            
            Log::info('Artículos a devolver (solo pendientes): ' . count($articulos));
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $cotizacion->id,
                    'requisicion_id' => $requisicionId,
                    'folio_requisicion' => $cotizacion->requisicionArticulo->requisicion->folio,
                    'proveedor' => $cotizacion->proveedor->nombre,
                    'proyecto_id' => $cotizacion->requisicionArticulo->requisicion->proyecto_id,
                    'proyecto_nombre' => $cotizacion->requisicionArticulo->requisicion->proyecto->nombre ?? 'N/A',
                    'articulos' => $articulos
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en detalleCompra: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}