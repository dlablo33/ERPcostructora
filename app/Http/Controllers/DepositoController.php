<?php
// app/Http/Controllers/DepositoController.php
namespace App\Http\Controllers;

use App\Models\Deposito;
use App\Models\CuentaBancaria;
use App\Models\Proyecto;
use App\Models\TipoIngreso;
use App\Models\MovimientoBancario;
use App\Models\CodigoSat;
use App\Models\Facturacion\Contacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepositoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getData']);
    }

    /**
     * Vista principal
     */
    public function index()
    {
        // Obtener datos para los selects
        $cuentasBancarias = CuentaBancaria::with(['banco', 'moneda'])->where('activa', true)->get();
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        $tiposIngreso = TipoIngreso::where('activo', true)->get();
        
        // Obtener clientes para el select
        $clientes = Contacto::where('tipo', 'cliente')
            ->where('estatus', true)
            ->orderBy('razon_social')
            ->get(['contacto_id as id', 'razon_social as nombre', 'rfc']);
        
        // Códigos SAT para ingresos (tipo I = Ingreso)
        $codigosSatIngresos = CodigoSat::whereIn('tipo', ['I'])
            ->orderBy('codigo_agrupador')
            ->get();
        
        return view('administracion.tesoreria.depositos', compact(
            'cuentasBancarias', 'proyectos', 'tiposIngreso', 'codigosSatIngresos',
            'clientes'
        ));
    }

    /**
     * Obtener datos para la tabla
     */
    public function getData(Request $request)
    {
        try {
            $query = Deposito::with([
                'cuentaBancaria.banco', 
                'cuentaBancaria.moneda', 
                'proyecto', 
                'tipoIngreso',
                'codigoSat',
                'contacto'
            ]);
            
            if ($request->has('fecha_inicio') && $request->fecha_inicio) {
                $query->whereDate('fecha', '>=', $request->fecha_inicio);
            }
            
            if ($request->has('fecha_fin') && $request->fecha_fin) {
                $query->whereDate('fecha', '<=', $request->fecha_fin);
            }
            
            if ($request->has('estatus') && $request->estatus) {
                $query->where('estatus', $request->estatus);
            }
            
            if ($request->has('cliente_id') && $request->cliente_id) {
                $query->where('contacto_id', $request->cliente_id);
            }
            
            $depositos = $query->orderBy('fecha', 'desc')->get();
            return response()->json($depositos);
        } catch (\Exception $e) {
            Log::error('Error en getData depositos: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Obtener facturas pendientes de un cliente
     */
    public function getFacturasCliente(Request $request, $clienteId)
    {
        try {
            if (!$clienteId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cliente no especificado'
                ], 422);
            }
            
            // Obtener facturas del cliente con saldo pendiente
            $facturas = DB::table('facturas')
                ->select('factura_id as id', 'folio', 'fecha', 'fecha_vencimiento', 'total', 'saldo_disponible')
                ->where('contacto_id', $clienteId)
                ->where('estatus', 1) // Estatus 1 = Emitida/Pendiente
                ->where('saldo_disponible', '>', 0)
                ->whereNull('deleted_at')
                ->orderBy('fecha_vencimiento', 'asc')
                ->get()
                ->map(function($factura) {
                    return [
                        'id' => $factura->id,
                        'folio' => $factura->folio,
                        'fecha' => $factura->fecha,
                        'fecha_vencimiento' => $factura->fecha_vencimiento,
                        'total' => $factura->total,
                        'saldo_disponible' => $factura->saldo_disponible
                    ];
                });
            
            $hoy = now();
            $totalVencido = $facturas->filter(function($f) use ($hoy) {
                return $f['fecha_vencimiento'] && $f['fecha_vencimiento'] < $hoy;
            })->sum('saldo_disponible');
            
            $totalPorVencer = $facturas->filter(function($f) use ($hoy) {
                return !$f['fecha_vencimiento'] || $f['fecha_vencimiento'] >= $hoy;
            })->sum('saldo_disponible');
            
            return response()->json([
                'success' => true,
                'data' => $facturas,
                'totales' => [
                    'vencido' => $totalVencido,
                    'por_vencer' => $totalPorVencer,
                    'total' => $totalVencido + $totalPorVencer
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener facturas del cliente: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener facturas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear nuevo depósito
     */
    public function store(Request $request)
    {
        try {
            Log::info('Datos recibidos en store deposito:', $request->all());
            
            $validated = $request->validate([
                'fecha' => 'required|date',
                'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'tipo_ingreso_id' => 'required|exists:tipos_ingreso,id',
                'monto' => 'required|numeric|min:0.01',
                'referencia' => 'nullable|string|max:100',
                'concepto' => 'required|string|max:500',
                'observaciones' => 'nullable|string',
                'aplicar_ahora' => 'boolean',
                'codigo_sat_id' => 'required|exists:codigos_sat,id',
                'cliente_id' => 'nullable|exists:contactos,contacto_id',
                'facturas_aplicadas' => 'nullable|array',
                'facturas_aplicadas.*.factura_id' => 'required|exists:facturas,factura_id',
                'facturas_aplicadas.*.monto' => 'required|numeric|min:0.01',
            ]);
            
            DB::beginTransaction();
            
            // Procesar facturas aplicadas
            $facturasAplicadas = [];
            $totalAplicado = 0;
            
            if (isset($validated['facturas_aplicadas']) && is_array($validated['facturas_aplicadas'])) {
                foreach ($validated['facturas_aplicadas'] as $item) {
                    $facturasAplicadas[$item['factura_id']] = (float) $item['monto'];
                    $totalAplicado += (float) $item['monto'];
                }
            }
            
            // Validar que el monto aplicado no exceda el total
            if ($totalAplicado > $validated['monto']) {
                throw new \Exception('El monto aplicado a facturas no puede exceder el monto total del depósito');
            }
            
            $validated['folio'] = Deposito::generarFolio();
            $validated['estatus'] = ($validated['aplicar_ahora'] ?? false) ? 'aplicado' : 'pendiente';
            $validated['created_by'] = auth()->id();
            $validated['contacto_id'] = $validated['cliente_id'] ?? null;
            $validated['facturas_aplicadas'] = !empty($facturasAplicadas) ? $facturasAplicadas : null;
            $validated['monto_aplicado'] = $totalAplicado;
            
            $deposito = Deposito::create($validated);
            
            // Si hay facturas aplicadas, actualizar sus saldos
            if (!empty($facturasAplicadas)) {
                $this->actualizarSaldosFacturas($facturasAplicadas);
            }
            
            if ($validated['aplicar_ahora'] ?? false) {
                $this->aplicarDeposito($deposito);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Depósito creado exitosamente. ' . ($totalAplicado > 0 ? 'Facturas actualizadas.' : ''),
                'data' => $deposito->load(['cuentaBancaria.banco', 'proyecto', 'tipoIngreso', 'codigoSat', 'contacto'])
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear depósito: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener un depósito
     */
    public function show($id)
    {
        try {
            $deposito = Deposito::with([
                'cuentaBancaria.banco', 
                'cuentaBancaria.moneda', 
                'proyecto', 
                'tipoIngreso', 
                'creador',
                'codigoSat',
                'contacto'
            ])->findOrFail($id);
            
            // Cargar facturas aplicadas
            if ($deposito->facturas_aplicadas) {
                $ids = array_keys($deposito->facturas_aplicadas);
                $facturas = DB::table('facturas')
                    ->whereIn('factura_id', $ids)
                    ->get()
                    ->map(function($factura) use ($deposito) {
                        $factura->monto_aplicado = $deposito->facturas_aplicadas[$factura->factura_id] ?? 0;
                        return $factura;
                    });
                $deposito->facturas_detalle = $facturas;
            }
            
            return response()->json($deposito);
        } catch (\Exception $e) {
            Log::error('Error en show deposito: ' . $e->getMessage());
            return response()->json(['error' => 'Depósito no encontrado'], 404);
        }
    }

    /**
     * Actualizar depósito
     */
    public function update(Request $request, $id)
    {
        try {
            $deposito = Deposito::findOrFail($id);
            
            if ($deposito->estatus !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden editar depósitos pendientes'
                ], 422);
            }
            
            $validated = $request->validate([
                'fecha' => 'required|date',
                'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'tipo_ingreso_id' => 'required|exists:tipos_ingreso,id',
                'monto' => 'required|numeric|min:0.01',
                'referencia' => 'nullable|string|max:100',
                'concepto' => 'required|string|max:500',
                'observaciones' => 'nullable|string',
                'codigo_sat_id' => 'required|exists:codigos_sat,id',
                'cliente_id' => 'nullable|exists:contactos,contacto_id',
            ]);
            
            DB::beginTransaction();
            
            $validated['contacto_id'] = $validated['cliente_id'] ?? null;
            $deposito->update($validated);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Depósito actualizado exitosamente',
                'data' => $deposito->load(['cuentaBancaria.banco', 'proyecto', 'tipoIngreso', 'codigoSat', 'contacto'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en update deposito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar depósito
     */
    public function destroy($id)
    {
        try {
            $deposito = Deposito::findOrFail($id);
            
            if ($deposito->estatus !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden eliminar depósitos pendientes'
                ], 422);
            }
            
            DB::beginTransaction();
            
            // Revertir saldos de facturas si las hay
            if ($deposito->facturas_aplicadas) {
                foreach ($deposito->facturas_aplicadas as $facturaId => $montoAplicado) {
                    DB::table('facturas')
                        ->where('factura_id', $facturaId)
                        ->increment('saldo_disponible', $montoAplicado);
                    
                    // Si estaba pagada, restaurar a emitida
                    $factura = DB::table('facturas')->where('factura_id', $facturaId)->first();
                    if ($factura && $factura->saldo_disponible > 0 && $factura->estatus == 10) {
                        DB::table('facturas')
                            ->where('factura_id', $facturaId)
                            ->update(['estatus' => 1]);
                    }
                }
            }
            
            $deposito->delete();
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Depósito eliminado exitosamente. Saldos de facturas restaurados.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en destroy deposito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Aplicar depósito
     */
    public function aplicar($id)
    {
        try {
            DB::beginTransaction();
            $deposito = Deposito::findOrFail($id);
            
            if ($deposito->estatus !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'El depósito ya fue ' . $deposito->estatus
                ], 422);
            }
            
            // Validar que tenga código SAT
            if (!$deposito->codigo_sat_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'El depósito no tiene un código SAT asignado. Por favor edite el depósito y asigne uno.'
                ], 422);
            }
            
            $this->aplicarDeposito($deposito);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Depósito aplicado exitosamente. Saldo actualizado.',
                'data' => $deposito->load(['cuentaBancaria.banco', 'proyecto', 'tipoIngreso', 'codigoSat', 'contacto'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al aplicar depósito: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Aplica el depósito: actualiza saldo de cuenta y crea movimiento bancario
     */
    private function aplicarDeposito($deposito)
    {
        // Validar que tenga código SAT
        if (!$deposito->codigo_sat_id) {
            throw new \Exception('El depósito no tiene un código SAT asignado.');
        }
        
        // Actualizar saldo de la cuenta bancaria (INGRESO - se suma)
        $cuenta = CuentaBancaria::find($deposito->cuenta_bancaria_id);
        if ($cuenta) {
            $cuenta->saldo_actual = $cuenta->saldo_actual + $deposito->monto;
            $cuenta->save();
            
            Log::info('Saldo actualizado. Nuevo saldo cuenta ' . $cuenta->id . ': ' . $cuenta->saldo_actual);
        }
        
        // Crear movimiento bancario con código SAT
        $movimiento = MovimientoBancario::create([
            'cuenta_bancaria_id' => $deposito->cuenta_bancaria_id,
            'proyecto_id' => $deposito->proyecto_id,
            'tipo' => 'ingreso',
            'tipo_ingreso_id' => $deposito->tipo_ingreso_id,
            'metodo_pago_id' => 1,
            'monto' => $deposito->monto,
            'fecha' => $deposito->fecha,
            'concepto' => $deposito->concepto,
            'referencia' => $deposito->referencia,
            'comprobante' => null,
            'status' => 'aplicado',
            'observaciones' => 'Depósito: ' . ($deposito->observaciones ?? ''),
            'created_by' => $deposito->created_by,
            'codigo_sat_id' => $deposito->codigo_sat_id
        ]);
        
        $deposito->estatus = 'aplicado';
        $deposito->save();
        
        Log::info('Movimiento creado ID: ' . $movimiento->id . ' con código SAT: ' . $deposito->codigo_sat_id);
        
        return $movimiento;
    }

    /**
     * Actualizar saldos de facturas
     */
    private function actualizarSaldosFacturas($facturasAplicadas)
    {
        foreach ($facturasAplicadas as $facturaId => $montoAplicado) {
            $factura = DB::table('facturas')->where('factura_id', $facturaId)->first();
            if ($factura) {
                $nuevoSaldo = $factura->saldo_disponible - $montoAplicado;
                $nuevoSaldo = max(0, $nuevoSaldo);
                
                $updateData = ['saldo_disponible' => $nuevoSaldo];
                
                // Si el saldo queda en 0, cambiar estatus a pagada (10)
                if ($nuevoSaldo <= 0) {
                    $updateData['estatus'] = 10; // Estatus 10 = Pagada
                }
                
                DB::table('facturas')
                    ->where('factura_id', $facturaId)
                    ->update($updateData);
                
                Log::info('Factura actualizada ID: ' . $facturaId . ', Nuevo saldo: ' . $nuevoSaldo);
            }
        }
    }

    /**
     * Obtener estadísticas
     */
    public function getEstadisticas(Request $request)
    {
        try {
            $query = Deposito::query();
            
            if ($request->has('cliente_id') && $request->cliente_id) {
                $query->where('contacto_id', $request->cliente_id);
            }
            
            $total = $query->count();
            $aplicados = $query->clone()->where('estatus', 'aplicado')->count();
            $pendientes = $query->clone()->where('estatus', 'pendiente')->count();
            $proceso = $query->clone()->where('estatus', 'proceso')->count();
            $totalMonto = $query->clone()->sum('monto');
            
            return response()->json([
                'total' => $total,
                'aplicados' => $aplicados,
                'pendientes' => $pendientes,
                'proceso' => $proceso,
                'total_monto' => $totalMonto
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getEstadisticas: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}