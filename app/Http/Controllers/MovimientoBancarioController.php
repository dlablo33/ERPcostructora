<?php
// app/Http/Controllers/MovimientoBancarioController.php
namespace App\Http\Controllers;

use App\Models\MovimientoBancario;
use App\Models\CuentaBancaria;
use App\Models\Proyecto;
use App\Models\TipoIngreso;
use App\Models\TipoEgreso;
use App\Models\CategoriaGasto;
use App\Models\MetodoPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MovimientoBancarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = MovimientoBancario::with(['cuentaBancaria', 'proyecto', 'tipoIngreso', 'tipoEgreso', 'categoriaGasto', 'metodoPago', 'creador']);
        
        if ($request->has('proyecto_id') && $request->proyecto_id) {
            $query->where('proyecto_id', $request->proyecto_id);
        }
        
        if ($request->has('cuenta_id') && $request->cuenta_id) {
            $query->where('cuenta_bancaria_id', $request->cuenta_id);
        }
        
        if ($request->has('tipo') && $request->tipo) {
            $query->where('tipo', $request->tipo);
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('fecha_inicio') && $request->fecha_inicio) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        }
        
        if ($request->has('fecha_fin') && $request->fecha_fin) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }
        
        $movimientos = $query->orderBy('fecha', 'desc')->paginate(20);
        
        $cuentas = CuentaBancaria::where('activa', true)->get();
        $proyectos = Proyecto::where('status', 'activo')->get();
        $tiposIngreso = TipoIngreso::where('activo', true)->get();
        $tiposEgreso = TipoEgreso::where('activo', true)->get();
        $metodosPago = MetodoPago::where('activo', true)->get();
        
        return view('administracion.tesoreria.movimientos.index', compact('movimientos', 'cuentas', 'proyectos', 'tiposIngreso', 'tiposEgreso', 'metodosPago'));
    }

    public function create(Request $request)
    {
        $proyectoId = $request->get('proyecto_id');
        $cuentas = CuentaBancaria::with('banco', 'moneda')
            ->when($proyectoId, function($q) use ($proyectoId) {
                return $q->where('proyecto_id', $proyectoId);
            })
            ->where('activa', true)
            ->get();
            
        $proyectos = Proyecto::where('status', 'activo')->get();
        $tiposIngreso = TipoIngreso::where('activo', true)->get();
        $tiposEgreso = TipoEgreso::where('activo', true)->get();
        $metodosPago = MetodoPago::where('activo', true)->get();
        
        return view('administracion.tesoreria.movimientos.create', compact('cuentas', 'proyectos', 'tiposIngreso', 'tiposEgreso', 'metodosPago', 'proyectoId'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
                'proyecto_id' => 'required|exists:proyectos,id',
                'tipo' => 'required|in:ingreso,egreso',
                'tipo_ingreso_id' => 'required_if:tipo,ingreso|nullable|exists:tipos_ingreso,id',
                'tipo_egreso_id' => 'required_if:tipo,egreso|nullable|exists:tipos_egreso,id',
                'categoria_gasto_id' => 'nullable|exists:categorias_gastos,id',
                'metodo_pago_id' => 'required|exists:metodos_pago,id',
                'monto' => 'required|numeric|min:0.01',
                'fecha' => 'required|date',
                'concepto' => 'required|string|max:500',
                'referencia' => 'nullable|string|max:100',
                'comprobante' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png',
                'observaciones' => 'nullable|string',
                'status' => 'nullable|in:pendiente,aplicado'
            ]);

            DB::beginTransaction();
            
            // Subir comprobante si existe
            if ($request->hasFile('comprobante')) {
                $archivo = $request->file('comprobante');
                $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
                $ruta = $archivo->storeAs('comprobantes', $nombreArchivo, 'public');
                $validated['comprobante'] = $ruta;
            }
            
            $validated['created_by'] = auth()->id();
            $validated['status'] = $validated['status'] ?? 'pendiente';
            
            $movimiento = MovimientoBancario::create($validated);
            
            // Si está marcado como aplicado, procesar inmediatamente
            if ($movimiento->status === 'aplicado') {
                $movimiento->aplicar();
            }
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Movimiento registrado exitosamente',
                'movimiento' => $movimiento
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear movimiento: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear movimiento: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $movimiento = MovimientoBancario::with(['cuentaBancaria.banco', 'cuentaBancaria.moneda', 'proyecto', 'tipoIngreso', 'tipoEgreso', 'categoriaGasto', 'metodoPago', 'creador'])
            ->findOrFail($id);
            
        return view('administracion.tesoreria.movimientos.show', compact('movimiento'));
    }

    public function edit($id)
    {
        $movimiento = MovimientoBancario::findOrFail($id);
        
        // Solo se pueden editar movimientos pendientes
        if ($movimiento->status !== 'pendiente') {
            return redirect()->route('movimientos.index')->with('error', 'Solo se pueden editar movimientos pendientes');
        }
        
        $cuentas = CuentaBancaria::with('banco', 'moneda')->where('activa', true)->get();
        $proyectos = Proyecto::where('status', 'activo')->get();
        $tiposIngreso = TipoIngreso::where('activo', true)->get();
        $tiposEgreso = TipoEgreso::where('activo', true)->get();
        $metodosPago = MetodoPago::where('activo', true)->get();
        
        return view('administracion.tesoreria.movimientos.edit', compact('movimiento', 'cuentas', 'proyectos', 'tiposIngreso', 'tiposEgreso', 'metodosPago'));
    }

    public function update(Request $request, $id)
    {
        try {
            $movimiento = MovimientoBancario::findOrFail($id);
            
            // Solo se pueden actualizar movimientos pendientes
            if ($movimiento->status !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden editar movimientos pendientes'
                ], 422);
            }
            
            $validated = $request->validate([
                'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
                'proyecto_id' => 'required|exists:proyectos,id',
                'tipo' => 'required|in:ingreso,egreso',
                'tipo_ingreso_id' => 'required_if:tipo,ingreso|nullable|exists:tipos_ingreso,id',
                'tipo_egreso_id' => 'required_if:tipo,egreso|nullable|exists:tipos_egreso,id',
                'categoria_gasto_id' => 'nullable|exists:categorias_gastos,id',
                'metodo_pago_id' => 'required|exists:metodos_pago,id',
                'monto' => 'required|numeric|min:0.01',
                'fecha' => 'required|date',
                'concepto' => 'required|string|max:500',
                'referencia' => 'nullable|string|max:100',
                'observaciones' => 'nullable|string'
            ]);

            DB::beginTransaction();
            
            $movimiento->update($validated);
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Movimiento actualizado exitosamente',
                'movimiento' => $movimiento
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar movimiento: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar movimiento: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $movimiento = MovimientoBancario::findOrFail($id);
            
            // Solo se pueden eliminar movimientos pendientes
            if ($movimiento->status !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden eliminar movimientos pendientes'
                ], 422);
            }
            
            // Eliminar comprobante si existe
            if ($movimiento->comprobante && Storage::disk('public')->exists($movimiento->comprobante)) {
                Storage::disk('public')->delete($movimiento->comprobante);
            }
            
            $movimiento->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Movimiento eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar movimiento: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar movimiento: ' . $e->getMessage()
            ], 500);
        }
    }

    public function aplicar($id)
    {
        try {
            DB::beginTransaction();
            $movimiento = MovimientoBancario::findOrFail($id);
            
            if ($movimiento->status !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'El movimiento ya está ' . $movimiento->status
                ], 422);
            }
            
            $movimiento->aplicar();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Movimiento aplicado exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al aplicar movimiento: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al aplicar movimiento: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cancelar($id)
    {
        try {
            DB::beginTransaction();
            $movimiento = MovimientoBancario::findOrFail($id);
            
            if ($movimiento->status !== 'aplicado') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden cancelar movimientos aplicados'
                ], 422);
            }
            
            $movimiento->cancelar();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Movimiento cancelado exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al cancelar movimiento: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cancelar movimiento: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getCategoriasPorTipoEgreso($tipoEgresoId)
    {
        $categorias = CategoriaGasto::where('tipo_egreso_id', $tipoEgresoId)
            ->where('activo', true)
            ->get();
        return response()->json($categorias);
    }

    public function getSaldoCuenta($cuentaId)
    {
        $cuenta = CuentaBancaria::findOrFail($cuentaId);
        return response()->json([
            'saldo_actual' => $cuenta->saldo_actual,
            'moneda' => $cuenta->moneda->simbolo
        ]);
    }

    // ==================================================================

    /**
 * Obtener datos para la vista de estados de cuenta
 */
// En app/Http/Controllers/MovimientoBancarioController.php
    public function getDataForEstadosCuenta(Request $request)
    {
        try {
            $query = MovimientoBancario::with(['cuentaBancaria.banco', 'cuentaBancaria.moneda']);
            
            // Filtro por cuenta bancaria
            $cuentaId = null;
            if ($request->has('cuenta_id') && $request->cuenta_id != '0' && $request->cuenta_id != 'null') {
                $cuentaId = $request->cuenta_id;
                $query->where('cuenta_bancaria_id', $cuentaId);
            }
            
            // Filtro por fechas
            $fechaInicio = $request->has('fecha_inicio') && $request->fecha_inicio ? $request->fecha_inicio : date('Y-m-01');
            $fechaFin = $request->has('fecha_fin') && $request->fecha_fin ? $request->fecha_fin : date('Y-m-t');
            
            $query->whereDate('fecha', '>=', $fechaInicio)
                  ->whereDate('fecha', '<=', $fechaFin);
            
            // Búsqueda
            if ($request->has('busqueda') && $request->busqueda) {
                $busqueda = $request->busqueda;
                $query->where(function($q) use ($busqueda) {
                    $q->where('folio', 'like', "%{$busqueda}%")
                      ->orWhere('referencia', 'like', "%{$busqueda}%")
                      ->orWhere('referencia_bancaria', 'like', "%{$busqueda}%")
                      ->orWhere('origen', 'like', "%{$busqueda}%")
                      ->orWhere('descripcion', 'like', "%{$busqueda}%")
                      ->orWhere('concepto', 'like', "%{$busqueda}%");
                });
            }
            
            // Obtener movimientos ordenados
            $movimientos = $query->orderBy('fecha', 'asc')->orderBy('id', 'asc')->get();
            
            // Calcular saldo inicial
            $saldoInicial = $this->calcularSaldoInicial($cuentaId, $fechaInicio);
            
            // Procesar movimientos y calcular saldo corrido
            $data = [];
            $saldoCorrido = $saldoInicial;
            
            foreach ($movimientos as $movimiento) {
                // Determinar si es cargo o abono
                $esCargo = in_array($movimiento->tipo, ['cargo', 'egreso', 'pago', 'retiro', 'compra', 'gasto']);
                $esAbono = in_array($movimiento->tipo, ['abono', 'ingreso', 'deposito', 'transferencia_recibida', 'pago_recibido']);
                
                $monto = floatval($movimiento->monto);
                
                if ($esCargo) {
                    $saldoCorrido -= $monto;
                } elseif ($esAbono) {
                    $saldoCorrido += $monto;
                }
                
                $data[] = [
                    'id' => $movimiento->id,
                    'fecha' => $movimiento->fecha,
                    'folio' => $movimiento->folio ?? 'MOV-' . str_pad($movimiento->id, 6, '0', STR_PAD_LEFT),
                    'referencia' => $movimiento->referencia ?? '-',
                    'ref_bancaria' => $movimiento->referencia_bancaria ?? '-',
                    'origen' => $movimiento->origen ?? $movimiento->tipo ?? '-',
                    'descripcion' => $movimiento->descripcion ?? $movimiento->concepto ?? '-',
                    'cargos' => $esCargo ? $monto : 0,
                    'abonos' => $esAbono ? $monto : 0,
                    'saldo_final' => round($saldoCorrido, 2),
                    'banco_id' => $movimiento->cuentaBancaria->banco_id ?? null,
                    'banco' => $movimiento->cuentaBancaria->banco->nombre ?? '',
                    'cuenta' => $movimiento->cuentaBancaria->numero_cuenta ?? '',
                ];
            }
            
            // Calcular totales
            $totalCargos = array_sum(array_column($data, 'cargos'));
            $totalAbonos = array_sum(array_column($data, 'abonos'));
            $saldoFinal = count($data) > 0 ? end($data)['saldo_final'] : $saldoInicial;
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'resumen' => [
                    'saldo_inicial' => round($saldoInicial, 2),
                    'total_cargos' => round($totalCargos, 2),
                    'total_abonos' => round($totalAbonos, 2),
                    'saldo_final' => round($saldoFinal, 2)
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getDataForEstadosCuenta: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los datos: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Calcular saldo inicial para el período
     */
    private function calcularSaldoInicial($cuentaId, $fechaInicio)
    {
        try {
            // Si no hay cuenta seleccionada, sumar saldos iniciales de todas las cuentas
            if (!$cuentaId) {
                $cuentas = CuentaBancaria::where('activa', true)->get();
                $saldoTotal = 0;
                
                foreach ($cuentas as $cuenta) {
                    // Obtener saldo inicial de la cuenta
                    $saldoBase = floatval($cuenta->saldo_inicial ?? 0);
                    
                    // Sumar movimientos ANTES de la fecha de inicio
                    $movimientosPrevios = MovimientoBancario::where('cuenta_bancaria_id', $cuenta->id)
                        ->whereDate('fecha', '<', $fechaInicio)
                        ->get();
                    
                    $saldoCorrido = $saldoBase;
                    foreach ($movimientosPrevios as $mov) {
                        $esCargo = in_array($mov->tipo, ['cargo', 'egreso', 'pago', 'retiro', 'compra', 'gasto']);
                        $esAbono = in_array($mov->tipo, ['abono', 'ingreso', 'deposito', 'transferencia_recibida', 'pago_recibido']);
                        
                        if ($esCargo) {
                            $saldoCorrido -= floatval($mov->monto);
                        } elseif ($esAbono) {
                            $saldoCorrido += floatval($mov->monto);
                        }
                    }
                    
                    $saldoTotal += $saldoCorrido;
                }
                
                return $saldoTotal;
            }
            
            // Para una cuenta específica
            $cuenta = CuentaBancaria::find($cuentaId);
            if (!$cuenta) {
                return 0;
            }
            
            // Saldo inicial de la cuenta
            $saldoBase = floatval($cuenta->saldo_inicial ?? 0);
            
            // Sumar movimientos ANTES de la fecha de inicio
            $movimientosPrevios = MovimientoBancario::where('cuenta_bancaria_id', $cuentaId)
                ->whereDate('fecha', '<', $fechaInicio)
                ->get();
            
            $saldoCorrido = $saldoBase;
            foreach ($movimientosPrevios as $mov) {
                $esCargo = in_array($mov->tipo, ['cargo', 'egreso', 'pago', 'retiro', 'compra', 'gasto']);
                $esAbono = in_array($mov->tipo, ['abono', 'ingreso', 'deposito', 'transferencia_recibida', 'pago_recibido']);
                
                if ($esCargo) {
                    $saldoCorrido -= floatval($mov->monto);
                } elseif ($esAbono) {
                    $saldoCorrido += floatval($mov->monto);
                }
            }
            
            return $saldoCorrido;
            
        } catch (\Exception $e) {
            Log::error('Error calculando saldo inicial: ' . $e->getMessage());
            return 0;
        }
    }
    


/**
 * Calcular saldo inicial para el período
 */

}