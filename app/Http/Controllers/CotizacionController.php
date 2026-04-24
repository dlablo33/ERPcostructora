<?php

namespace App\Http\Controllers;

use App\Models\Requisicion;
use App\Models\CotizacionArticulo;
use App\Models\Proveedor;
use App\Models\RequisicionArticulo;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CotizacionController extends Controller
{
    /**
     * Muestra la lista de requisiciones para cotizar (vista ordenes.blade.php)
     * Órdenes pendientes de cotizar
     */
    public function ordenesPendientes(Request $request)
    {
        $query = Requisicion::with(['proyecto', 'articulos.cotizaciones'])
            ->where('estatus', 'Activo');
        
        // Filtros
        if ($request->filled('folio')) {
            $query->where('folio', 'LIKE', "%{$request->folio}%");
        }
        
        if ($request->filled('proyecto')) {
            $query->where('proyecto_id', $request->proyecto);
        }
        
        if ($request->filled('estatus_cotizacion')) {
            $query->where('estatus_cotizacion', $request->estatus_cotizacion);
        }
        
        $requisiciones = $query->orderBy('id', 'desc')->get();
        
        // Calcular estadísticas para cada requisición
        foreach ($requisiciones as $req) {
            $totalArticulos = $req->articulos->count();
            $cotizados = $req->articulos->where('cotizada', true)->count();
            $req->progreso_cotizacion = $totalArticulos > 0 ? round(($cotizados / $totalArticulos) * 100) : 0;
            $req->cotizados_count = $cotizados;
            $req->total_articulos = $totalArticulos;
        }
        
        $proveedores = Proveedor::activos()->orderBy('nombre')->get();
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        
        return view('compras.compras.ordenes', compact('requisiciones', 'proveedores', 'proyectos'));
    }
    
    /**
     * Muestra la lista de requisiciones con cotizaciones para autorizar
     */
    public function autorizacionCotizaciones(Request $request)
    {
        $query = Requisicion::with(['proyecto', 'articulos.cotizaciones.proveedor'])
            ->where('estatus', 'Activo')
            ->whereIn('estatus_cotizacion', ['En_Cotizacion', 'Cotizada']);
        
        // Filtros
        if ($request->filled('folio')) {
            $query->where('folio', 'LIKE', "%{$request->folio}%");
        }
        
        if ($request->filled('proyecto')) {
            $query->where('proyecto_id', $request->proyecto);
        }
        
        if ($request->filled('estatus_cotizacion')) {
            $query->where('estatus_cotizacion', $request->estatus_cotizacion);
        }
        
        $requisiciones = $query->orderBy('id', 'desc')->get();
        
        // Calcular estadísticas para cada requisición
        foreach ($requisiciones as $req) {
            $totalArticulos = $req->articulos->count();
            $cotizados = $req->articulos->where('cotizada', true)->count();
            $req->progreso_cotizacion = $totalArticulos > 0 ? round(($cotizados / $totalArticulos) * 100) : 0;
            $req->cotizados_count = $cotizados;
            $req->total_articulos = $totalArticulos;
        }
        
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        
        return view('compras.compras.autorizacion', compact('requisiciones', 'proyectos'));
    }
    
    /**
     * Obtiene los datos para el comparativo de cotizaciones por artículo (API)
     */
    public function getComparativo($requisicionId)
    {
        try {
            $requisicion = Requisicion::with(['proyecto', 'articulos'])->findOrFail($requisicionId);
            
            $articulos = $requisicion->articulos->map(function($articulo) {
                return [
                    'id' => $articulo->id,
                    'codigo' => $articulo->codigo,
                    'descripcion' => $articulo->descripcion,
                    'cantidad' => $articulo->cantidad,
                    'unidad_medida' => $articulo->unidad_medida,
                    'cotizada' => $articulo->cotizada,
                    'cotizaciones' => $articulo->cotizaciones->map(function($cot) {
                        return [
                            'id' => $cot->id,
                            'proveedor_nombre' => $cot->proveedor->nombre ?? '-',
                            'precio_unitario' => $cot->precio_unitario,
                            'tiempo_entrega_dias' => $cot->tiempo_entrega_dias,
                            'condiciones_pago' => $cot->condiciones_pago,
                            'estatus' => $cot->estatus
                        ];
                    }),
                    'cotizacion_seleccionada' => $articulo->cotizacionSeleccionada ? [
                        'id' => $articulo->cotizacionSeleccionada->id,
                        'proveedor_nombre' => $articulo->cotizacionSeleccionada->proveedor->nombre ?? '-',
                        'precio_unitario' => $articulo->cotizacionSeleccionada->precio_unitario
                    ] : null
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $articulos,
                'requisicion' => [
                    'id' => $requisicion->id,
                    'folio' => $requisicion->folio,
                    'solicitante' => $requisicion->solicitante,
                    'proyecto_nombre' => $requisicion->proyecto->nombre ?? '-',
                    'fecha_requerimiento' => $requisicion->fecha_requerimiento ? date('d/m/Y', strtotime($requisicion->fecha_requerimiento)) : '-',
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getComparativo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar comparativo: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Guarda una cotización para un artículo específico
     */
    public function store(Request $request)
    {
        try {
            Log::info('Iniciando guardado de cotización', $request->all());
            
            $request->validate([
                'requisicion_articulo_id' => 'required|exists:requisicion_articulos,id',
                'proveedor_id' => 'required|exists:proveedores,id',
                'precio_unitario' => 'required|numeric|min:0',
                'tiempo_entrega_dias' => 'nullable|integer|min:0',
                'condiciones_pago' => 'nullable|string|max:100',
                'observaciones' => 'nullable|string'
            ]);
            
            DB::beginTransaction();
            
            // Verificar si ya existe una cotización para este artículo con este proveedor
            $existe = CotizacionArticulo::where('requisicion_articulo_id', $request->requisicion_articulo_id)
                ->where('proveedor_id', $request->proveedor_id)
                ->where('estatus', 'Pendiente')
                ->first();
            
            if ($existe) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe una cotización pendiente para este artículo con este proveedor'
                ], 400);
            }
            
            // Crear cotización para el artículo
            $cotizacion = CotizacionArticulo::create([
                'requisicion_articulo_id' => $request->requisicion_articulo_id,
                'proveedor_id' => $request->proveedor_id,
                'precio_unitario' => $request->precio_unitario,
                'tiempo_entrega_dias' => $request->tiempo_entrega_dias,
                'condiciones_pago' => $request->condiciones_pago,
                'observaciones' => $request->observaciones,
                'estatus' => 'Pendiente',
                'creado_por' => Auth::id()
            ]);
            
            Log::info('Cotización creada', ['id' => $cotizacion->id]);
            
            // ACTUALIZAR EL ARTÍCULO COMO COTIZADO
            $articulo = RequisicionArticulo::find($request->requisicion_articulo_id);
            if ($articulo) {
                // Si el artículo no estaba marcado como cotizado, marcarlo
                if (!$articulo->cotizada) {
                    $articulo->cotizada = true;
                    $articulo->save();
                    Log::info('Artículo marcado como cotizado', ['articulo_id' => $articulo->id]);
                }
                
                // Actualizar estatus de la requisición
                $requisicion = Requisicion::find($articulo->requisicion_id);
                if ($requisicion) {
                    $requisicion->actualizarEstatusCotizacion();
                    Log::info('Estatus de requisición actualizado', [
                        'requisicion_id' => $requisicion->id,
                        'estatus_cotizacion' => $requisicion->estatus_cotizacion
                    ]);
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Cotización registrada exitosamente',
                'data' => [
                    'id' => $cotizacion->id,
                    'precio_unitario' => $cotizacion->precio_unitario,
                    'proveedor_nombre' => $cotizacion->proveedor->nombre ?? ''
                ]
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Error de validación: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Error de validación: ' . implode(', ', array_merge(...array_values($e->errors())))
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al guardar cotización: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Selecciona una cotización como ganadora para un artículo
     */
    public function seleccionar(Request $request, $cotizacionId)
    {
        try {
            DB::beginTransaction();
            
            $cotizacion = CotizacionArticulo::with('requisicionArticulo')->findOrFail($cotizacionId);
            
            if ($cotizacion->estatus !== 'Pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'La cotización ya fue procesada'
                ], 400);
            }
            
            $articulo = $cotizacion->requisicionArticulo;
            $resultado = $articulo->seleccionarCotizacion($cotizacionId);
            
            if (!$resultado) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al seleccionar la cotización'
                ], 400);
            }
            
            // NO actualizamos el estatus de la requisición aquí
            // Solo actualizamos el artículo
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Cotización seleccionada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al seleccionar cotización: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al seleccionar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Autoriza todas las cotizaciones seleccionadas de una requisición
     */
    public function autorizarTodasCotizaciones(Request $request, $requisicionId)
    {
        try {
            DB::beginTransaction();
            
            $requisicion = Requisicion::findOrFail($requisicionId);
            
            // Verificar que todos los artículos tengan cotización seleccionada
            $todosSeleccionados = $requisicion->articulos->every(function($articulo) {
                return $articulo->tieneCotizacionSeleccionada();
            });
            
            if (!$todosSeleccionados) {
                return response()->json([
                    'success' => false,
                    'message' => 'No todos los artículos tienen una cotización seleccionada'
                ], 400);
            }
            
            $requisicion->estatus_cotizacion = 'Cotizada';
            $requisicion->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Todas las cotizaciones han sido autorizadas'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al autorizar cotizaciones: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al autorizar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtiene los artículos de una requisición con su estado de cotización
     */
    public function getArticulos($requisicionId)
    {
        try {
            $requisicion = Requisicion::with(['articulos.cotizaciones.proveedor', 'articulos.cotizacionSeleccionada.proveedor'])
                ->findOrFail($requisicionId);
            
            $articulos = $requisicion->articulos->map(function($articulo) {
                // Obtener el mejor precio de las cotizaciones pendientes
                $mejorPrecio = $articulo->cotizaciones
                    ->where('estatus', 'Pendiente')
                    ->min('precio_unitario');
                
                return [
                    'id' => $articulo->id,
                    'codigo' => $articulo->codigo,
                    'descripcion' => $articulo->descripcion,
                    'cantidad' => $articulo->cantidad,
                    'unidad_medida' => $articulo->unidad_medida,
                    'cotizada' => $articulo->cotizada,
                    'mejor_precio' => $mejorPrecio ? number_format($mejorPrecio, 2) : null,
                    'cotizaciones_count' => $articulo->cotizaciones->count(),
                    'cotizaciones' => $articulo->cotizaciones->map(function($cot) {
                        return [
                            'id' => $cot->id,
                            'proveedor_nombre' => $cot->proveedor->nombre ?? '-',
                            'precio_unitario' => $cot->precio_unitario,
                            'tiempo_entrega_dias' => $cot->tiempo_entrega_dias,
                            'condiciones_pago' => $cot->condiciones_pago,
                            'estatus' => $cot->estatus,
                            'fecha' => $cot->created_at ? $cot->created_at->format('d/m/Y H:i') : '-'
                        ];
                    }),
                    'cotizacion_seleccionada' => $articulo->cotizacionSeleccionada ? [
                        'id' => $articulo->cotizacionSeleccionada->id,
                        'proveedor_nombre' => $articulo->cotizacionSeleccionada->proveedor->nombre ?? '-',
                        'precio_unitario' => $articulo->cotizacionSeleccionada->precio_unitario
                    ] : null
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $requisicion->id,
                    'folio' => $requisicion->folio,
                    'estatus_cotizacion' => $requisicion->estatus_cotizacion,
                    'articulos' => $articulos
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getArticulos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar artículos: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Ver detalle de una cotización
     */
    public function show($id)
    {
        try {
            $cotizacion = CotizacionArticulo::with(['proveedor', 'requisicionArticulo.requisicion'])
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $cotizacion->id,
                    'requisicion_folio' => $cotizacion->requisicionArticulo->requisicion->folio ?? '-',
                    'articulo_codigo' => $cotizacion->requisicionArticulo->codigo,
                    'articulo_descripcion' => $cotizacion->requisicionArticulo->descripcion,
                    'cantidad' => $cotizacion->requisicionArticulo->cantidad,
                    'unidad_medida' => $cotizacion->requisicionArticulo->unidad_medida,
                    'proveedor_nombre' => $cotizacion->proveedor->nombre ?? '-',
                    'precio_unitario' => $cotizacion->precio_unitario,
                    'tiempo_entrega_dias' => $cotizacion->tiempo_entrega_dias,
                    'condiciones_pago' => $cotizacion->condiciones_pago,
                    'observaciones' => $cotizacion->observaciones,
                    'estatus' => $cotizacion->estatus,
                    'creado_por' => $cotizacion->creador->name ?? '-',
                    'created_at' => $cotizacion->created_at ? $cotizacion->created_at->format('d/m/Y H:i') : '-'
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en show cotización: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar detalle: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Muestra el formulario para solicitar cotización (vista)
     */
    public function solicitar($requisicionId)
    {
        $requisicion = Requisicion::with(['articulos', 'proyecto'])->findOrFail($requisicionId);
        
        if ($requisicion->estatus !== 'Activo') {
            return redirect()->back()->with('error', 'La requisición no está autorizada');
        }
        
        $proveedores = Proveedor::activos()->orderBy('nombre')->get();
        
        return view('compras.cotizaciones.solicitar', compact('requisicion', 'proveedores'));
    }
    
    /**
     * Obtiene las cotizaciones pendientes por artículo para autorizar (API)
     */
    public function getCotizacionesPendientes()
    {
        try {
            $cotizaciones = CotizacionArticulo::with(['proveedor', 'requisicionArticulo.requisicion.proyecto'])
                ->where('estatus', 'Pendiente')
                ->orderBy('created_at', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $cotizaciones->map(function($cot) {
                    $subtotal = $cot->precio_unitario * $cot->requisicionArticulo->cantidad;
                    $iva = $subtotal * 0.16;
                    $total = $subtotal + $iva;
                    
                    return [
                        'id' => $cot->id,
                        'requisicion_folio' => $cot->requisicionArticulo->requisicion->folio,
                        'articulo_descripcion' => $cot->requisicionArticulo->descripcion,
                        'cantidad' => $cot->requisicionArticulo->cantidad,
                        'proveedor_nombre' => $cot->proveedor->nombre,
                        'precio_unitario' => $cot->precio_unitario,
                        'subtotal' => $subtotal,
                        'iva' => $iva,
                        'total' => $total
                    ];
                })
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getCotizacionesPendientes: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar cotizaciones pendientes'
            ], 500);
        }
    }

    /**
     * Obtiene requisiciones con cotizaciones pendientes de autorizar (API)
     */
    public function requisicionesParaAutorizar(Request $request)
    {
        try {
            $query = Requisicion::with(['proyecto'])
                ->where('estatus', 'Activo')
                ->whereIn('estatus_cotizacion', ['En_Cotizacion', 'Cotizada']);
            
            if ($request->filled('folio')) {
                $query->where('folio', 'LIKE', "%{$request->folio}%");
            }
            
            if ($request->filled('proyecto')) {
                $query->where('proyecto_id', $request->proyecto);
            }
            
            if ($request->filled('estatus')) {
                $query->where('estatus_cotizacion', $request->estatus);
            }
            
            $requisiciones = $query->orderBy('id', 'desc')->get();
            
            return response()->json([
                'success' => true,
                'data' => $requisiciones->map(function($req) {
                    return [
                        'id' => $req->id,
                        'folio' => $req->folio,
                        'fecha_requerimiento' => $req->fecha_requerimiento ? date('d/m/Y', strtotime($req->fecha_requerimiento)) : '-',
                        'proyecto_nombre' => $req->proyecto->nombre ?? '-',
                        'solicitante' => $req->solicitante,
                        'estatus_cotizacion' => $req->estatus_cotizacion,
                        'articulos_count' => $req->articulos->count(),
                        'articulos_cotizados' => $req->articulos->where('cotizada', true)->count()
                    ];
                })
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en requisicionesParaAutorizar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar requisiciones'
            ], 500);
        }
    }
}