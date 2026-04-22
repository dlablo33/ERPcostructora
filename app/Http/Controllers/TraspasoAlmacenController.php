<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Articulo;
use App\Models\Almacen;
use App\Models\InventarioFisico;
use App\Models\MovimientoInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TraspasoAlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        $articulos = Articulo::where('estatus', 'Activo')->orderBy('codigo')->get();
        $almacenes = Almacen::where('estatus', 'Activo')->orderBy('nombre')->get();
        
        return view('almacen.movimiento.traspasos', compact('proyectos', 'articulos', 'almacenes'));
    }

    /**
     * Obtener stock por proyecto, artículo y almacén
     */
    public function getStockPorProyecto(Request $request)
    {
        try {
            $proyectoId = $request->get('proyecto_id');
            $articuloId = $request->get('articulo_id');
            $almacenId = $request->get('almacen_id');
            
            // Validar parámetros
            if (!$proyectoId || !$articuloId || !$almacenId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Faltan parámetros requeridos',
                    'disponible' => 0,
                    'stock_actual' => 0,
                    'unidad_medida' => 'Pieza'
                ]);
            }
            
            // Buscar en inventario_fisico
            $inventario = InventarioFisico::where('proyecto_id', $proyectoId)
                ->where('articulo_id', $articuloId)
                ->where('almacen_id', $almacenId)
                ->first();
            
            // Obtener unidad de medida del artículo
            $articulo = Articulo::find($articuloId);
            
            return response()->json([
                'success' => true,
                'disponible' => $inventario ? floatval($inventario->disponible) : 0,
                'stock_actual' => $inventario ? floatval($inventario->stock_actual) : 0,
                'unidad_medida' => $articulo ? ($articulo->unidad_medida ?? 'Pieza') : 'Pieza',
                'ubicacion' => $inventario ? $inventario->ubicaciones : null
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error en getStockPorProyecto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'disponible' => 0,
                'unidad_medida' => 'Pieza'
            ]);
        }
    }

    /**
     * Obtener saldo de un artículo por proyecto (para la API existente)
     */
    public function getSaldoArticulo(Request $request)
    {
        try {
            $proyectoId = $request->get('proyecto_id');
            $articuloId = $request->get('articulo_id');
            
            if (!$proyectoId || !$articuloId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Faltan parámetros requeridos'
                ]);
            }
            
            $inventarios = InventarioFisico::where('proyecto_id', $proyectoId)
                ->where('articulo_id', $articuloId)
                ->get();
            
            $articulo = Articulo::find($articuloId);
            
            $ubicaciones = [];
            foreach ($inventarios as $inv) {
                $almacen = Almacen::find($inv->almacen_id);
                $ubicaciones[] = [
                    'almacen_id' => $inv->almacen_id,
                    'almacen_nombre' => $almacen ? $almacen->nombre : 'N/A',
                    'cantidad' => $inv->disponible,
                    'stock_actual' => $inv->stock_actual
                ];
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'articulo_id' => $articuloId,
                    'articulo_codigo' => $articulo ? $articulo->codigo : '',
                    'articulo_descripcion' => $articulo ? $articulo->descripcion : '',
                    'unidad_medida' => $articulo ? ($articulo->unidad_medida ?? 'Pieza') : 'Pieza',
                    'ubicaciones' => $ubicaciones
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error en getSaldoArticulo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Obtener lista de movimientos (traspasos)
     */
    public function getMovimientos(Request $request)
    {
        try {
            $tipo = $request->get('tipo', 'Transferencia');
            $page = $request->get('page', 1);
            $perPage = $request->get('per_page', 10);
            $fechaInicio = $request->get('fecha_inicio');
            $fechaFin = $request->get('fecha_fin');
            $proyectoId = $request->get('proyecto_id');
            $articuloId = $request->get('articulo_id');
            
            $query = MovimientoInventario::where('tipo_movimiento', $tipo)
                ->with(['proyecto', 'articulo', 'almacenOrigen', 'almacenDestino', 'usuario']);
            
            if ($fechaInicio) {
                $query->whereDate('fecha_movimiento', '>=', $fechaInicio);
            }
            if ($fechaFin) {
                $query->whereDate('fecha_movimiento', '<=', $fechaFin);
            }
            if ($proyectoId) {
                $query->where('proyecto_id', $proyectoId);
            }
            if ($articuloId) {
                $query->where('articulo_id', $articuloId);
            }
            
            $movimientos = $query->orderBy('fecha_movimiento', 'desc')
                ->orderBy('id', 'desc')
                ->paginate($perPage, ['*'], 'page', $page);
            
            $data = [];
            foreach ($movimientos as $mov) {
                $data[] = [
                    'id' => $mov->id,
                    'fecha_movimiento' => $mov->fecha_movimiento,
                    'proyecto_nombre' => $mov->proyecto ? $mov->proyecto->nombre : 'N/A',
                    'articulo_codigo' => $mov->articulo ? $mov->articulo->codigo : 'N/A',
                    'articulo_descripcion' => $mov->articulo ? $mov->articulo->descripcion : 'N/A',
                    'cantidad' => $mov->cantidad,
                    'unidad_medida' => $mov->articulo ? $mov->articulo->unidad_medida : 'Pieza',
                    'almacen_origen_nombre' => $mov->almacenOrigen ? $mov->almacenOrigen->nombre : 'N/A',
                    'almacen_destino_nombre' => $mov->almacenDestino ? $mov->almacenDestino->nombre : 'N/A',
                    'observaciones' => $mov->observaciones,
                    'creado_por' => $mov->usuario ? $mov->usuario->name : 'N/A'
                ];
            }
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'current_page' => $movimientos->currentPage(),
                'last_page' => $movimientos->lastPage(),
                'per_page' => $movimientos->perPage(),
                'total' => $movimientos->total()
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error en getMovimientos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
                'current_page' => 1,
                'last_page' => 1
            ]);
        }
    }

    /**
     * Obtener detalle de un movimiento específico
     */
    public function getMovimiento($id)
    {
        try {
            $movimiento = MovimientoInventario::with(['proyecto', 'articulo', 'almacenOrigen', 'almacenDestino', 'usuario'])
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $movimiento->id,
                    'fecha_movimiento' => $movimiento->fecha_movimiento,
                    'proyecto_nombre' => $movimiento->proyecto ? $movimiento->proyecto->nombre : 'N/A',
                    'articulo_codigo' => $movimiento->articulo ? $movimiento->articulo->codigo : 'N/A',
                    'articulo_descripcion' => $movimiento->articulo ? $movimiento->articulo->descripcion : 'N/A',
                    'cantidad' => $movimiento->cantidad,
                    'unidad_medida' => $movimiento->articulo ? $movimiento->articulo->unidad_medida : 'Pieza',
                    'almacen_origen_nombre' => $movimiento->almacenOrigen ? $movimiento->almacenOrigen->nombre : 'N/A',
                    'almacen_destino_nombre' => $movimiento->almacenDestino ? $movimiento->almacenDestino->nombre : 'N/A',
                    'observaciones' => $movimiento->observaciones,
                    'creado_por' => $movimiento->usuario ? $movimiento->usuario->name : 'N/A'
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Movimiento no encontrado'
            ]);
        }
    }

    /**
     * Realizar traspaso entre almacenes
     */
    public function realizarTraspaso(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'proyecto_id' => 'required|exists:proyectos,id',
                'articulo_id' => 'required|exists:articulos,id',
                'almacen_origen_id' => 'required|exists:almacenes,id',
                'almacen_destino_id' => 'required|exists:almacenes,id|different:almacen_origen_id',
                'cantidad' => 'required|numeric|min:0.001',
                'fecha_movimiento' => 'required|date',
                'observaciones' => 'nullable|string'
            ]);
            
            $cantidad = floatval($request->cantidad);
            
            // Verificar stock en almacén origen
            $inventarioOrigen = InventarioFisico::where('proyecto_id', $request->proyecto_id)
                ->where('articulo_id', $request->articulo_id)
                ->where('almacen_id', $request->almacen_origen_id)
                ->first();
            
            if (!$inventarioOrigen || floatval($inventarioOrigen->disponible) < $cantidad) {
                $disponible = $inventarioOrigen ? $inventarioOrigen->disponible : 0;
                return response()->json([
                    'success' => false,
                    'message' => "Stock insuficiente en almacén origen. Disponible: {$disponible}, Solicitado: {$cantidad}"
                ]);
            }
            
            // Descontar del almacén origen
            $inventarioOrigen->stock_actual -= $cantidad;
            $inventarioOrigen->disponible -= $cantidad;
            $inventarioOrigen->save();
            
            // Agregar al almacén destino
            $inventarioDestino = InventarioFisico::where('proyecto_id', $request->proyecto_id)
                ->where('articulo_id', $request->articulo_id)
                ->where('almacen_id', $request->almacen_destino_id)
                ->first();
            
            if ($inventarioDestino) {
                $inventarioDestino->stock_actual += $cantidad;
                $inventarioDestino->disponible += $cantidad;
                $inventarioDestino->save();
            } else {
                // Crear nuevo registro en inventario_fisico
                InventarioFisico::create([
                    'proyecto_id' => $request->proyecto_id,
                    'articulo_id' => $request->articulo_id,
                    'almacen_id' => $request->almacen_destino_id,
                    'stock_actual' => $cantidad,
                    'disponible' => $cantidad,
                    'minimo' => 0,
                    'maximo' => 0,
                    'reorden' => 0,
                    'estado' => 'Normal'
                ]);
            }
            
            // Registrar el movimiento
            $movimiento = MovimientoInventario::create([
                'proyecto_id' => $request->proyecto_id,
                'articulo_id' => $request->articulo_id,
                'almacen_origen_id' => $request->almacen_origen_id,
                'almacen_destino_id' => $request->almacen_destino_id,
                'cantidad' => $cantidad,
                'tipo_movimiento' => 'Transferencia',
                'fecha_movimiento' => $request->fecha_movimiento,
                'observaciones' => $request->observaciones,
                'usuario_id' => Auth::id(),
                'referencia' => 'TRASPASO-' . date('YmdHis')
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Traspaso realizado exitosamente',
                'data' => $movimiento
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación: ' . implode(', ', $e->errors())
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error en realizarTraspaso: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al realizar el traspaso: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Exportar movimientos a Excel/CSV
     */
    public function exportarMovimientos(Request $request)
    {
        try {
            $tipo = $request->get('tipo', 'Transferencia');
            $fechaInicio = $request->get('fecha_inicio');
            $fechaFin = $request->get('fecha_fin');
            
            $query = MovimientoInventario::where('tipo_movimiento', $tipo)
                ->with(['proyecto', 'articulo', 'almacenOrigen', 'almacenDestino', 'usuario']);
            
            if ($fechaInicio) {
                $query->whereDate('fecha_movimiento', '>=', $fechaInicio);
            }
            if ($fechaFin) {
                $query->whereDate('fecha_movimiento', '<=', $fechaFin);
            }
            
            $movimientos = $query->orderBy('fecha_movimiento', 'desc')->get();
            
            // Generar CSV
            $filename = "traspasos_" . date('Ymd_His') . ".csv";
            $handle = fopen('php://temp', 'w');
            
            // Cabeceras
            fputcsv($handle, [
                'ID', 'Fecha', 'Proyecto', 'Artículo Código', 'Artículo Descripción',
                'Cantidad', 'Unidad', 'Almacén Origen', 'Almacén Destino',
                'Observaciones', 'Registrado Por'
            ]);
            
            // Datos
            foreach ($movimientos as $mov) {
                fputcsv($handle, [
                    $mov->id,
                    $mov->fecha_movimiento,
                    $mov->proyecto ? $mov->proyecto->nombre : 'N/A',
                    $mov->articulo ? $mov->articulo->codigo : 'N/A',
                    $mov->articulo ? $mov->articulo->descripcion : 'N/A',
                    $mov->cantidad,
                    $mov->articulo ? $mov->articulo->unidad_medida : 'Pieza',
                    $mov->almacenOrigen ? $mov->almacenOrigen->nombre : 'N/A',
                    $mov->almacenDestino ? $mov->almacenDestino->nombre : 'N/A',
                    $mov->observaciones ?? '',
                    $mov->usuario ? $mov->usuario->name : 'N/A'
                ]);
            }
            
            rewind($handle);
            $csvContent = stream_get_contents($handle);
            fclose($handle);
            
            return response($csvContent, 200)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', "attachment; filename=\"$filename\"");
                
        } catch (\Exception $e) {
            \Log::error('Error en exportarMovimientos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ]);
        }
    }
}