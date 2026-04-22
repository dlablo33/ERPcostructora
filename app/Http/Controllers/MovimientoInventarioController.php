<?php

namespace App\Http\Controllers;

use App\Models\MovimientoInventario;
use App\Models\InventarioProyecto;
use App\Models\InventarioAlmacenProyecto;
use App\Models\Proyecto;
use App\Models\Articulo;
use App\Models\Almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MovimientoInventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        $articulos = Articulo::where('estatus', 'Activo')->orderBy('codigo')->get();
        $almacenes = Almacen::where('estatus', 'Activo')->orderBy('nombre')->get();

        return view('almacen.movimiento.entrada', compact('proyectos', 'articulos', 'almacenes'));
    }
    
    /**
     * Get movimientos for DataTable with pagination.
     */
    public function getMovimientos(Request $request)
    {
        try {
            $query = MovimientoInventario::with(['inventarioProyecto.proyecto', 'inventarioProyecto.articulo', 'almacenOrigen', 'almacenDestino', 'creador']);
            
            // Filtro por tipo
            if ($request->filled('tipo')) {
                $query->where('tipo_movimiento', $request->tipo);
            }
            
            // Filtro por fechas
            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha_movimiento', '>=', $request->fecha_inicio);
            }
            
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha_movimiento', '<=', $request->fecha_fin);
            }
            
            // Filtro por proyecto
            if ($request->filled('proyecto_id')) {
                $query->whereHas('inventarioProyecto', function($q) use ($request) {
                    $q->where('proyecto_id', $request->proyecto_id);
                });
            }
            
            // Filtro por artículo
            if ($request->filled('articulo_id')) {
                $query->whereHas('inventarioProyecto', function($q) use ($request) {
                    $q->where('articulo_id', $request->articulo_id);
                });
            }
            
            // Filtro por almacén
            if ($request->filled('almacen_id')) {
                $query->where(function($q) use ($request) {
                    $q->where('almacen_origen_id', $request->almacen_id)
                      ->orWhere('almacen_destino_id', $request->almacen_id);
                });
            }
            
            // Búsqueda general
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('referencia_folio', 'LIKE', "%{$search}%")
                      ->orWhere('observaciones', 'LIKE', "%{$search}%")
                      ->orWhere('solicitante', 'LIKE', "%{$search}%");
                });
            }
            
            // Paginación
            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);
            
            $movimientos = $query->orderBy('fecha_movimiento', 'desc')
                ->orderBy('id', 'desc')
                ->paginate($perPage, ['*'], 'page', $page);
            
            $data = $movimientos->getCollection()->map(function($movimiento) {
                return [
                    'id' => $movimiento->id,
                    'tipo_movimiento' => $movimiento->tipo_movimiento,
                    'fecha_movimiento' => $movimiento->fecha_movimiento ? $movimiento->fecha_movimiento->format('d/m/Y H:i') : '',
                    'proyecto_id' => $movimiento->inventarioProyecto?->proyecto_id,
                    'proyecto_nombre' => $movimiento->inventarioProyecto?->proyecto?->nombre,
                    'proyecto_codigo' => $movimiento->inventarioProyecto?->proyecto?->codigo,
                    'articulo_id' => $movimiento->inventarioProyecto?->articulo_id,
                    'articulo_codigo' => $movimiento->inventarioProyecto?->articulo?->codigo,
                    'articulo_descripcion' => $movimiento->inventarioProyecto?->articulo?->descripcion,
                    'unidad_medida' => $movimiento->inventarioProyecto?->unidad_medida,
                    'cantidad' => $movimiento->cantidad,
                    'cantidad_antes' => $movimiento->cantidad_antes,
                    'cantidad_despues' => $movimiento->cantidad_despues,
                    'almacen_origen_id' => $movimiento->almacen_origen_id,
                    'almacen_origen_nombre' => $movimiento->almacenOrigen?->nombre,
                    'almacen_destino_id' => $movimiento->almacen_destino_id,
                    'almacen_destino_nombre' => $movimiento->almacenDestino?->nombre,
                    'almacen_nombre' => $movimiento->tipo_movimiento === 'Entrada' 
                        ? ($movimiento->almacenDestino?->nombre) 
                        : ($movimiento->almacenOrigen?->nombre),
                    'referencia_tipo' => $movimiento->referencia_tipo,
                    'referencia_id' => $movimiento->referencia_id,
                    'referencia_folio' => $movimiento->referencia_folio,
                    'solicitante' => $movimiento->solicitante,
                    'motivo' => $movimiento->motivo,
                    'observaciones' => $movimiento->observaciones,
                    'creado_por' => $movimiento->creador?->name,
                    'creado_por_id' => $movimiento->creado_por,
                    'created_at' => $movimiento->created_at ? $movimiento->created_at->format('d/m/Y H:i') : '',
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'total' => $movimientos->total(),
                'per_page' => $movimientos->perPage(),
                'current_page' => $movimientos->currentPage(),
                'last_page' => $movimientos->lastPage()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getMovimientos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar movimientos: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Registrar una entrada de material.
     */
    public function registrarEntrada(Request $request)
    {
        try {
            $request->validate([
                'proyecto_id' => 'required|exists:proyectos,id',
                'articulo_id' => 'required|exists:articulos,id',
                'almacen_id' => 'required|exists:almacenes,id',
                'cantidad' => 'required|numeric|min:0.001',
                'fecha_movimiento' => 'required|date',
                'referencia_folio' => 'nullable|string|max:50',
                'observaciones' => 'nullable|string'
            ]);
            
            DB::beginTransaction();
            
            // Buscar o crear inventario para este proyecto y artículo
            $inventario = InventarioProyecto::where('proyecto_id', $request->proyecto_id)
                ->where('articulo_id', $request->articulo_id)
                ->first();
            
            $articulo = Articulo::find($request->articulo_id);
            
            if (!$inventario) {
                $inventario = InventarioProyecto::create([
                    'proyecto_id' => $request->proyecto_id,
                    'articulo_id' => $request->articulo_id,
                    'cantidad_actual' => 0,
                    'cantidad_reservada' => 0,
                    'cantidad_minima' => 0,
                    'cantidad_maxima' => 0,
                    'punto_reorden' => 0,
                    'unidad_medida' => $articulo->unidad_medida ?? 'Pieza',
                    'estatus' => 'Activo'
                ]);
            }
            
            $cantidadAnterior = $inventario->cantidad_actual;
            
            // Actualizar stock
            $inventario->cantidad_actual += $request->cantidad;
            $inventario->ultima_entrada = now();
            $inventario->save();
            
            // Actualizar ubicación en almacén
            $ubicacion = InventarioAlmacenProyecto::where('inventario_proyecto_id', $inventario->id)
                ->where('almacen_id', $request->almacen_id)
                ->first();
            
            if ($ubicacion) {
                $ubicacion->cantidad += $request->cantidad;
                $ubicacion->save();
            } else {
                InventarioAlmacenProyecto::create([
                    'inventario_proyecto_id' => $inventario->id,
                    'almacen_id' => $request->almacen_id,
                    'cantidad' => $request->cantidad
                ]);
            }
            
            // Registrar movimiento
            $movimiento = MovimientoInventario::create([
                'inventario_proyecto_id' => $inventario->id,
                'almacen_destino_id' => $request->almacen_id,
                'tipo_movimiento' => 'Entrada',
                'cantidad' => $request->cantidad,
                'cantidad_antes' => $cantidadAnterior,
                'cantidad_despues' => $inventario->cantidad_actual,
                'referencia_tipo' => 'Compra',
                'referencia_folio' => $request->referencia_folio,
                'observaciones' => $request->observaciones,
                'fecha_movimiento' => $request->fecha_movimiento,
                'creado_por' => auth()->id()
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Entrada registrada exitosamente',
                'data' => $movimiento
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar entrada: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar entrada: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Registrar una salida de material.
     */
    public function registrarSalida(Request $request)
    {
        try {
            $request->validate([
                'proyecto_id' => 'required|exists:proyectos,id',
                'articulo_id' => 'required|exists:articulos,id',
                'almacen_id' => 'required|exists:almacenes,id',
                'cantidad' => 'required|numeric|min:0.001',
                'fecha_movimiento' => 'required|date',
                'solicitante' => 'nullable|string|max:100',
                'referencia_folio' => 'nullable|string|max:50',
                'observaciones' => 'nullable|string'
            ]);
            
            DB::beginTransaction();
            
            // Verificar inventario
            $inventario = InventarioProyecto::where('proyecto_id', $request->proyecto_id)
                ->where('articulo_id', $request->articulo_id)
                ->first();
            
            if (!$inventario) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay inventario registrado para este artículo en el proyecto seleccionado'
                ], 400);
            }
            
            // Verificar stock disponible
            if ($inventario->disponible < $request->cantidad) {
                return response()->json([
                    'success' => false,
                    'message' => "Stock insuficiente. Disponible: {$inventario->disponible} {$inventario->unidad_medida}"
                ], 400);
            }
            
            // Verificar stock en almacén
            $ubicacion = InventarioAlmacenProyecto::where('inventario_proyecto_id', $inventario->id)
                ->where('almacen_id', $request->almacen_id)
                ->first();
            
            if (!$ubicacion || $ubicacion->cantidad < $request->cantidad) {
                $disponible = $ubicacion ? $ubicacion->cantidad : 0;
                return response()->json([
                    'success' => false,
                    'message' => "Stock insuficiente en el almacén. Disponible: {$disponible} {$inventario->unidad_medida}"
                ], 400);
            }
            
            $cantidadAnterior = $inventario->cantidad_actual;
            
            // Actualizar stock
            $inventario->cantidad_actual -= $request->cantidad;
            $inventario->ultima_salida = now();
            $inventario->save();
            
            // Actualizar ubicación
            $ubicacion->cantidad -= $request->cantidad;
            $ubicacion->save();
            
            // Registrar movimiento
            $movimiento = MovimientoInventario::create([
                'inventario_proyecto_id' => $inventario->id,
                'almacen_origen_id' => $request->almacen_id,
                'tipo_movimiento' => 'Salida',
                'cantidad' => $request->cantidad,
                'cantidad_antes' => $cantidadAnterior,
                'cantidad_despues' => $inventario->cantidad_actual,
                'referencia_tipo' => 'Consumo',
                'referencia_folio' => $request->referencia_folio,
                'solicitante' => $request->solicitante,
                'observaciones' => $request->observaciones,
                'fecha_movimiento' => $request->fecha_movimiento,
                'creado_por' => auth()->id()
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Salida registrada exitosamente',
                'data' => $movimiento
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar salida: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar salida: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Transferir material entre almacenes.
     */
    public function transferir(Request $request)
    {
        try {
            $request->validate([
                'proyecto_id' => 'required|exists:proyectos,id',
                'articulo_id' => 'required|exists:articulos,id',
                'almacen_origen_id' => 'required|exists:almacenes,id',
                'almacen_destino_id' => 'required|exists:almacenes,id|different:almacen_origen_id',
                'cantidad' => 'required|numeric|min:0.001',
                'fecha_movimiento' => 'required|date',
                'observaciones' => 'nullable|string'
            ]);
            
            DB::beginTransaction();
            
            // Buscar inventario del proyecto
            $inventario = InventarioProyecto::where('proyecto_id', $request->proyecto_id)
                ->where('articulo_id', $request->articulo_id)
                ->first();
            
            if (!$inventario) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay inventario registrado para este artículo en el proyecto'
                ], 400);
            }
            
            // Verificar stock en almacén origen
            $ubicacionOrigen = InventarioAlmacenProyecto::where('inventario_proyecto_id', $inventario->id)
                ->where('almacen_id', $request->almacen_origen_id)
                ->first();
            
            if (!$ubicacionOrigen || $ubicacionOrigen->cantidad < $request->cantidad) {
                $disponible = $ubicacionOrigen ? $ubicacionOrigen->cantidad : 0;
                return response()->json([
                    'success' => false,
                    'message' => "Stock insuficiente en almacén origen. Disponible: {$disponible} {$inventario->unidad_medida}"
                ], 400);
            }
            
            $cantidadAnterior = $inventario->cantidad_actual;
            
            // Retirar de origen
            $ubicacionOrigen->cantidad -= $request->cantidad;
            $ubicacionOrigen->save();
            
            // Agregar a destino
            $ubicacionDestino = InventarioAlmacenProyecto::where('inventario_proyecto_id', $inventario->id)
                ->where('almacen_id', $request->almacen_destino_id)
                ->first();
            
            if ($ubicacionDestino) {
                $ubicacionDestino->cantidad += $request->cantidad;
                $ubicacionDestino->save();
            } else {
                InventarioAlmacenProyecto::create([
                    'inventario_proyecto_id' => $inventario->id,
                    'almacen_id' => $request->almacen_destino_id,
                    'cantidad' => $request->cantidad
                ]);
            }
            
            // Registrar movimiento
            $movimiento = MovimientoInventario::create([
                'inventario_proyecto_id' => $inventario->id,
                'almacen_origen_id' => $request->almacen_origen_id,
                'almacen_destino_id' => $request->almacen_destino_id,
                'tipo_movimiento' => 'Transferencia',
                'cantidad' => $request->cantidad,
                'cantidad_antes' => $cantidadAnterior,
                'cantidad_despues' => $inventario->cantidad_actual,
                'referencia_tipo' => 'Transferencia',
                'observaciones' => $request->observaciones,
                'fecha_movimiento' => $request->fecha_movimiento,
                'creado_por' => auth()->id()
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Transferencia realizada exitosamente',
                'data' => $movimiento
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al transferir: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al transferir: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Ajuste de inventario (físico vs sistema).
     */
    public function ajustar(Request $request)
    {
        try {
            $request->validate([
                'proyecto_id' => 'required|exists:proyectos,id',
                'articulo_id' => 'required|exists:articulos,id',
                'almacen_id' => 'required|exists:almacenes,id',
                'cantidad_nueva' => 'required|numeric|min:0',
                'fecha_movimiento' => 'required|date',
                'motivo' => 'required|string|min:5',
                'observaciones' => 'nullable|string'
            ]);
            
            DB::beginTransaction();
            
            $inventario = InventarioProyecto::where('proyecto_id', $request->proyecto_id)
                ->where('articulo_id', $request->articulo_id)
                ->first();
            
            if (!$inventario) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay inventario registrado para este artículo en el proyecto'
                ], 400);
            }
            
            $ubicacion = InventarioAlmacenProyecto::where('inventario_proyecto_id', $inventario->id)
                ->where('almacen_id', $request->almacen_id)
                ->first();
            
            if (!$ubicacion) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay inventario en el almacén seleccionado'
                ], 400);
            }
            
            $cantidadAnterior = $inventario->cantidad_actual;
            $diferencia = $request->cantidad_nueva - $ubicacion->cantidad;
            
            if ($diferencia == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'La cantidad nueva es igual a la actual, no se requiere ajuste'
                ], 400);
            }
            
            $inventario->cantidad_actual += $diferencia;
            $inventario->save();
            
            $ubicacion->cantidad = $request->cantidad_nueva;
            $ubicacion->save();
            
            $movimiento = MovimientoInventario::create([
                'inventario_proyecto_id' => $inventario->id,
                'almacen_origen_id' => $diferencia < 0 ? $request->almacen_id : null,
                'almacen_destino_id' => $diferencia > 0 ? $request->almacen_id : null,
                'tipo_movimiento' => 'Ajuste',
                'cantidad' => abs($diferencia),
                'cantidad_antes' => $cantidadAnterior,
                'cantidad_despues' => $inventario->cantidad_actual,
                'referencia_tipo' => 'AjusteInventario',
                'motivo' => $request->motivo,
                'observaciones' => $request->observaciones,
                'fecha_movimiento' => $request->fecha_movimiento,
                'creado_por' => auth()->id()
            ]);
            
            DB::commit();
            
            $mensaje = $diferencia > 0 
                ? "Ajuste positivo de +{$diferencia} unidades" 
                : "Ajuste negativo de {$diferencia} unidades";
            
            return response()->json([
                'success' => true,
                'message' => $mensaje,
                'data' => $movimiento
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al ajustar inventario: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al ajustar inventario: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Display the specified movement.
     */
    public function show($id)
    {
        try {
            $movimiento = MovimientoInventario::with([
                'inventarioProyecto.proyecto', 
                'inventarioProyecto.articulo', 
                'almacenOrigen', 
                'almacenDestino', 
                'creador'
            ])->find($id);
            
            if (!$movimiento) {
                return response()->json([
                    'success' => false,
                    'message' => 'Movimiento no encontrado'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $movimiento->id,
                    'tipo_movimiento' => $movimiento->tipo_movimiento,
                    'fecha_movimiento' => $movimiento->fecha_movimiento->format('d/m/Y H:i'),
                    'proyecto_nombre' => $movimiento->inventarioProyecto?->proyecto?->nombre,
                    'articulo_codigo' => $movimiento->inventarioProyecto?->articulo?->codigo,
                    'articulo_descripcion' => $movimiento->inventarioProyecto?->articulo?->descripcion,
                    'cantidad' => $movimiento->cantidad,
                    'unidad_medida' => $movimiento->inventarioProyecto?->unidad_medida,
                    'almacen_origen_nombre' => $movimiento->almacenOrigen?->nombre,
                    'almacen_destino_nombre' => $movimiento->almacenDestino?->nombre,
                    'referencia_folio' => $movimiento->referencia_folio,
                    'solicitante' => $movimiento->solicitante,
                    'observaciones' => $movimiento->observaciones,
                    'creado_por' => $movimiento->creador?->name
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener movimiento: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Verificar stock específico por proyecto, artículo y almacén
     * Este es el método CORREGIDO usando tus modelos
     */
    public function verificarStock(Request $request)
    {
        try {
            $proyectoId = $request->get('proyecto_id');
            $articuloId = $request->get('articulo_id');
            $almacenId = $request->get('almacen_id');
            
            if (!$proyectoId || !$articuloId || !$almacenId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Faltan parámetros requeridos'
                ]);
            }
            
            // Buscar el inventario del proyecto usando tu modelo
            $inventarioProyecto = InventarioProyecto::where('proyecto_id', $proyectoId)
                ->where('articulo_id', $articuloId)
                ->first();
            
            if (!$inventarioProyecto) {
                $articulo = Articulo::find($articuloId);
                return response()->json([
                    'success' => true,
                    'disponible' => 0,
                    'stock_actual' => 0,
                    'unidad_medida' => $articulo ? ($articulo->unidad_medida ?? 'Pieza') : 'Pieza',
                    'message' => 'No hay inventario registrado'
                ]);
            }
            
            // Buscar la cantidad en el almacén específico usando tu modelo
            $ubicacion = InventarioAlmacenProyecto::where('inventario_proyecto_id', $inventarioProyecto->id)
                ->where('almacen_id', $almacenId)
                ->first();
            
            $cantidadEnAlmacen = $ubicacion ? floatval($ubicacion->cantidad) : 0;
            
            return response()->json([
                'success' => true,
                'disponible' => $cantidadEnAlmacen,
                'stock_actual' => floatval($inventarioProyecto->cantidad_actual),
                'unidad_medida' => $inventarioProyecto->unidad_medida ?? 'Pieza'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en verificarStock: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'disponible' => 0
            ]);
        }
    }
    
    /**
     * Get inventory balance for a specific project and article.
     */
    public function getSaldo(Request $request)
    {
        try {
            $request->validate([
                'proyecto_id' => 'required|exists:proyectos,id',
                'articulo_id' => 'required|exists:articulos,id'
            ]);
            
            $inventario = InventarioProyecto::where('proyecto_id', $request->proyecto_id)
                ->where('articulo_id', $request->articulo_id)
                ->with('ubicaciones.almacen')
                ->first();
            
            if (!$inventario) {
                $articulo = Articulo::find($request->articulo_id);
                return response()->json([
                    'success' => true,
                    'data' => [
                        'cantidad_actual' => 0,
                        'disponible' => 0,
                        'unidad_medida' => $articulo ? ($articulo->unidad_medida ?? 'Pieza') : 'Pieza',
                        'ubicaciones' => []
                    ]
                ]);
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'cantidad_actual' => $inventario->cantidad_actual,
                    'cantidad_reservada' => $inventario->cantidad_reservada,
                    'disponible' => $inventario->disponible,
                    'unidad_medida' => $inventario->unidad_medida,
                    'ubicaciones' => $inventario->ubicaciones->map(function($ubi) {
                        return [
                            'almacen_id' => $ubi->almacen_id,
                            'almacen_nombre' => $ubi->almacen?->nombre,
                            'cantidad' => $ubi->cantidad,
                            'ubicacion_especifica' => $ubi->ubicacion_especifica,
                            'lote' => $ubi->lote
                        ];
                    })
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getSaldo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener saldo: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get summary of movements.
     */
    public function getResumen(Request $request)
    {
        try {
            $query = MovimientoInventario::query();
            
            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha_movimiento', '>=', $request->fecha_inicio);
            }
            
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha_movimiento', '<=', $request->fecha_fin);
            }
            
            if ($request->filled('proyecto_id')) {
                $query->whereHas('inventarioProyecto', function($q) use ($request) {
                    $q->where('proyecto_id', $request->proyecto_id);
                });
            }
            
            $totalEntradas = (clone $query)->where('tipo_movimiento', 'Entrada')->sum('cantidad');
            $totalSalidas = (clone $query)->where('tipo_movimiento', 'Salida')->sum('cantidad');
            $totalTransferencias = (clone $query)->where('tipo_movimiento', 'Transferencia')->count();
            $totalAjustes = (clone $query)->where('tipo_movimiento', 'Ajuste')->count();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'total_entradas' => $totalEntradas,
                    'total_salidas' => $totalSalidas,
                    'total_transferencias' => $totalTransferencias,
                    'total_ajustes' => $totalAjustes
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener resumen: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Export movements to Excel.
     */
    public function exportar(Request $request)
    {
        try {
            $query = MovimientoInventario::with(['inventarioProyecto.proyecto', 'inventarioProyecto.articulo']);
            
            if ($request->filled('tipo')) {
                $query->where('tipo_movimiento', $request->tipo);
            }
            
            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha_movimiento', '>=', $request->fecha_inicio);
            }
            
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha_movimiento', '<=', $request->fecha_fin);
            }
            
            $movimientos = $query->orderBy('fecha_movimiento', 'desc')->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Exportación en desarrollo',
                'total' => $movimientos->count()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }
}