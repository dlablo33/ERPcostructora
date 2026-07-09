<?php
// app/Http/Controllers/ChequeTransferenciaController.php

namespace App\Http\Controllers;

use App\Models\ChequeTransferencia;
use App\Models\CuentaBancaria;
use App\Models\Moneda;
use App\Models\Proyecto;
use App\Models\Proveedor;
use App\Models\Facturacion\Contacto;
use App\Models\Facturacion\Factura;
use App\Models\MovimientoBancario;
use App\Models\CodigoSat;
use App\Models\CuentaContable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChequeTransferenciaController extends Controller
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
        $cuentasBancarias = CuentaBancaria::with(['banco', 'moneda'])->where('activa', true)->get();
        $monedas = Moneda::where('activa', true)->get();
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        
        // Proveedores para seleccionar
        $proveedores = Proveedor::where('activo', true)->orderBy('nombre')->get(['id', 'nombre', 'rfc']);
        
        // Códigos SAT para gastos
        $codigosSatGastos = CodigoSat::whereIn('tipo', ['G', 'A'])
            ->orderBy('codigo_agrupador')
            ->get();
        
        return view('administracion.tesoreria.trasferencias', compact(
            'cuentasBancarias', 'monedas', 'proyectos', 
            'codigosSatGastos',
            'proveedores'
        ));
    }

    /**
     * Obtener datos para la tabla
     */
    public function getData(Request $request)
    {
        try {
            $query = ChequeTransferencia::with([
                'cuentaBancaria.banco', 
                'moneda', 
                'proyecto', 
                'codigoSat',
                'proveedorRel'
            ])->where('tipo_operacion', 'egreso');
            
            // Filtros
            if ($request->has('fecha_inicio') && $request->fecha_inicio) {
                $query->whereDate('fecha', '>=', $request->fecha_inicio);
            }
            
            if ($request->has('fecha_fin') && $request->fecha_fin) {
                $query->whereDate('fecha', '<=', $request->fecha_fin);
            }
            
            if ($request->has('forma_pago') && $request->forma_pago) {
                $query->where('forma_pago', $request->forma_pago);
            }
            
            if ($request->has('estatus') && $request->estatus) {
                $query->where('estatus', $request->estatus);
            }
            
            if ($request->has('proveedor_id') && $request->proveedor_id) {
                $query->where('proveedor_id', $request->proveedor_id);
            }
            
            $registros = $query->orderBy('fecha', 'desc')->get();
            
            $data = $registros->map(function($item) {
                return [
                    'id' => $item->id,
                    'folio' => $item->folio,
                    'estatus' => $item->estatus,
                    'proveedor' => $item->proveedor,
                    'forma_pago' => $item->forma_pago === 'cheque' ? 'Cheque' : 'Transferencia',
                    'cuenta' => $item->cuentaBancaria?->numero_cuenta ?? '-',
                    'fecha' => $item->fecha,
                    'referencia' => $item->referencia ?? '-',
                    'referencia_bancaria' => $item->referencia_bancaria ?? '-',
                    'monto' => (float) $item->monto,
                    'monto_restante' => (float) $item->monto_restante,
                    'monto_aplicado' => (float) $item->monto_aplicado,
                    'moneda' => $item->moneda?->simbolo ?? '-',
                    'descripcion' => $item->descripcion ?? '-',
                    'facturas_aplicadas' => $item->facturas_aplicadas,
                ];
            });
            
            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error en getData cheques-transferencias: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Obtener facturas/pagos pendientes de un proveedor
     */
    public function getFacturasProveedor(Request $request, $proveedorId)
    {
        try {
            if (!$proveedorId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proveedor no especificado'
                ], 422);
            }
            
            // Obtener pagos pendientes del proveedor (facturas por pagar)
            $pagos = DB::table('pagos')
                ->select(
                    'id',
                    'folio',
                    'fecha_pago as fecha',
                    'monto as total',
                    'monto as saldo_pendiente',
                    'proveedor_nombre',
                    'concepto',
                    'created_at'
                )
                ->where('proveedor_id', $proveedorId)
                ->where('estatus', 'pendiente')
                ->orderBy('fecha_pago', 'asc')
                ->get()
                ->map(function($pago) {
                    // Calcular fecha de vencimiento (30 días después de la fecha de pago)
                    $fechaPago = $pago->fecha ? Carbon::parse($pago->fecha) : Carbon::now();
                    $fechaVencimiento = $fechaPago->copy()->addDays(30);
                    
                    return [
                        'id' => $pago->id,
                        'folio' => $pago->folio ?? 'P-' . $pago->id,
                        'fecha' => $pago->fecha,
                        'fecha_vencimiento' => $fechaVencimiento->format('Y-m-d'),
                        'total' => (float) $pago->total,
                        'saldo_disponible' => (float) $pago->saldo_pendiente,
                        'concepto' => $pago->concepto ?? 'Sin concepto'
                    ];
                });
            
            $hoy = now();
            $totalVencido = $pagos->filter(function($f) use ($hoy) {
                return $f['fecha_vencimiento'] && $f['fecha_vencimiento'] < $hoy;
            })->sum('saldo_disponible');
            
            $totalPorVencer = $pagos->filter(function($f) use ($hoy) {
                return !$f['fecha_vencimiento'] || $f['fecha_vencimiento'] >= $hoy;
            })->sum('saldo_disponible');
            
            return response()->json([
                'success' => true,
                'data' => $pagos,
                'totales' => [
                    'vencido' => $totalVencido,
                    'por_vencer' => $totalPorVencer,
                    'total' => $totalVencido + $totalPorVencer
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener facturas del proveedor: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener facturas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear nuevo registro (solo egresos)
     */
    public function store(Request $request)
    {
        try {
            Log::info('Datos recibidos en store cheques-transferencias:', $request->all());
            
            $validated = $request->validate([
                'fecha' => 'required|date',
                'forma_pago' => 'required|in:cheque,transferencia',
                'proveedor' => 'nullable|string|max:200',
                'rfc' => 'nullable|string|max:20',
                'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
                'moneda_id' => 'required|exists:monedas,id',
                'monto' => 'required|numeric|min:0.01',
                'referencia' => 'nullable|string|max:100',
                'referencia_bancaria' => 'nullable|string|max:100',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'descripcion' => 'nullable|string',
                'observaciones' => 'nullable|string',
                'aplicar_ahora' => 'boolean',
                'codigo_sat_id' => 'nullable|exists:codigos_sat,id',
                'proveedor_id' => 'nullable|exists:proveedores,id',
                'facturas_aplicadas' => 'nullable|array',
                'facturas_aplicadas.*.factura_id' => 'required|exists:pagos,id',
                'facturas_aplicadas.*.monto' => 'required|numeric|min:0.01',
                'cuenta_contable_id' => 'nullable|exists:cuentas_contables,id',
                'fecha_vencimiento' => 'nullable|date',
                'comprobante' => 'nullable|string',
                'poliza_contable' => 'nullable|string',
            ]);
            
            DB::beginTransaction();
            
            // Determinar el nombre del proveedor
            $nombreProveedor = $this->getNombreProveedor($validated);
            
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
                throw new \Exception('El monto aplicado a facturas no puede exceder el monto total del pago');
            }
            
            // Preparar datos para crear
            $createData = [
                'folio' => ChequeTransferencia::generarFolio(),
                'fecha' => $validated['fecha'],
                'fecha_vencimiento' => $validated['fecha_vencimiento'] ?? null,
                'forma_pago' => $validated['forma_pago'],
                'proveedor' => $nombreProveedor,
                'rfc' => $validated['rfc'] ?? null,
                'cuenta_bancaria_id' => $validated['cuenta_bancaria_id'],
                'moneda_id' => $validated['moneda_id'],
                'monto' => $validated['monto'],
                'monto_restante' => $validated['monto'] - $totalAplicado,
                'monto_aplicado' => $totalAplicado,
                'referencia' => $validated['referencia'] ?? null,
                'referencia_bancaria' => $validated['referencia_bancaria'] ?? null,
                'proyecto_id' => $validated['proyecto_id'] ?? null,
                'descripcion' => $validated['descripcion'] ?? null,
                'observaciones' => $validated['observaciones'] ?? null,
                'estatus' => 'activo',
                'tipo_cambio' => 1,
                'monto_original' => $validated['monto'],
                'created_by' => auth()->id(),
                'codigo_sat_id' => $validated['codigo_sat_id'] ?? null,
                'tipo_operacion' => 'egreso',
                'facturas_aplicadas' => !empty($facturasAplicadas) ? $facturasAplicadas : null,
                'proveedor_id' => $validated['proveedor_id'] ?? null,
                'cuenta_contable_id' => $validated['cuenta_contable_id'] ?? null,
                'comprobante' => $validated['comprobante'] ?? null,
                'poliza_contable' => $validated['poliza_contable'] ?? null,
            ];
            
            // Crear el registro
            $registro = ChequeTransferencia::create($createData);
            
            // Si hay facturas aplicadas, actualizar sus saldos
            if (!empty($facturasAplicadas)) {
                $this->actualizarSaldosFacturasProveedor($facturasAplicadas);
            }
            
            // Si se debe aplicar inmediatamente
            if ($validated['aplicar_ahora'] ?? true) {
                $this->aplicarMovimiento($registro);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pago creado exitosamente. ' . ($totalAplicado > 0 ? 'Facturas actualizadas.' : ''),
                'data' => $registro->load(['cuentaBancaria.banco', 'moneda', 'proyecto', 'codigoSat', 'proveedorRel'])
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
            Log::error('Error al crear registro cheques-transferencias: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener un registro
     */
    public function show($id)
    {
        try {
            $registro = ChequeTransferencia::with([
                'cuentaBancaria.banco', 
                'moneda', 
                'proyecto',
                'codigoSat',
                'proveedorRel',
                'cuentaContable'
            ])->findOrFail($id);
            
            // Cargar facturas aplicadas (de la tabla pagos)
            if ($registro->facturas_aplicadas) {
                $ids = array_keys($registro->facturas_aplicadas);
                $facturas = DB::table('pagos')
                    ->whereIn('id', $ids)
                    ->get()
                    ->map(function($factura) use ($registro) {
                        $factura->monto_aplicado = $registro->facturas_aplicadas[$factura->id] ?? 0;
                        return $factura;
                    });
                $registro->facturas_detalle = $facturas;
            }
            
            return response()->json($registro);
        } catch (\Exception $e) {
            Log::error('Error en show cheques-transferencias: ' . $e->getMessage());
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }
    }

    /**
     * Actualizar registro
     */
    public function update(Request $request, $id)
    {
        try {
            $registro = ChequeTransferencia::findOrFail($id);
            
            if ($registro->estatus === 'completado') {
                $validated = $request->validate([
                    'fecha' => 'required|date',
                    'forma_pago' => 'required|in:cheque,transferencia',
                    'proveedor' => 'nullable|string|max:200',
                    'rfc' => 'nullable|string|max:20',
                    'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
                    'moneda_id' => 'required|exists:monedas,id',
                    'referencia' => 'nullable|string|max:100',
                    'referencia_bancaria' => 'nullable|string|max:100',
                    'proyecto_id' => 'nullable|exists:proyectos,id',
                    'descripcion' => 'nullable|string',
                    'observaciones' => 'nullable|string',
                    'codigo_sat_id' => 'nullable|exists:codigos_sat,id',
                    'cuenta_contable_id' => 'nullable|exists:cuentas_contables,id',
                    'fecha_vencimiento' => 'nullable|date',
                ]);
            } else {
                $validated = $request->validate([
                    'fecha' => 'required|date',
                    'forma_pago' => 'required|in:cheque,transferencia',
                    'proveedor' => 'nullable|string|max:200',
                    'rfc' => 'nullable|string|max:20',
                    'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
                    'moneda_id' => 'required|exists:monedas,id',
                    'monto' => 'required|numeric|min:0.01',
                    'referencia' => 'nullable|string|max:100',
                    'referencia_bancaria' => 'nullable|string|max:100',
                    'proyecto_id' => 'nullable|exists:proyectos,id',
                    'descripcion' => 'nullable|string',
                    'observaciones' => 'nullable|string',
                    'codigo_sat_id' => 'nullable|exists:codigos_sat,id',
                    'proveedor_id' => 'nullable|exists:proveedores,id',
                    'cuenta_contable_id' => 'nullable|exists:cuentas_contables,id',
                    'fecha_vencimiento' => 'nullable|date',
                    'comprobante' => 'nullable|string',
                    'poliza_contable' => 'nullable|string',
                ]);
            }
            
            DB::beginTransaction();
            
            if (isset($validated['proveedor']) && empty($validated['proveedor'])) {
                $validated['proveedor'] = $this->getNombreProveedor($validated);
            }
            
            $registro->update($validated);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Registro actualizado exitosamente',
                'data' => $registro->load(['cuentaBancaria.banco', 'moneda', 'proyecto', 'codigoSat'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en update cheques-transferencias: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar registro
     */
    public function destroy($id)
    {
        try {
            $registro = ChequeTransferencia::findOrFail($id);
            
            if ($registro->estatus === 'completado') {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar un registro ya aplicado'
                ], 422);
            }
            
            DB::beginTransaction();
            
            // Revertir saldos de facturas si las hay
            if ($registro->facturas_aplicadas) {
                foreach ($registro->facturas_aplicadas as $facturaId => $montoAplicado) {
                    DB::table('pagos')
                        ->where('id', $facturaId)
                        ->increment('monto', $montoAplicado);
                }
            }
            
            $registro->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Registro eliminado exitosamente. Saldos de facturas restaurados.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en destroy cheques-transferencias: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Aplicar registro (crear movimiento bancario)
     */
    public function aplicar($id)
    {
        try {
            DB::beginTransaction();
            $registro = ChequeTransferencia::findOrFail($id);
            
            if ($registro->estatus !== 'activo') {
                return response()->json([
                    'success' => false,
                    'message' => 'El registro ya fue procesado'
                ], 422);
            }
            
            $this->aplicarMovimiento($registro);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Registro aplicado exitosamente. Saldo actualizado.',
                'data' => $registro->load(['cuentaBancaria.banco', 'moneda', 'proyecto', 'codigoSat'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al aplicar cheques-transferencias: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Aplicar movimiento bancario
     */
    private function aplicarMovimiento($registro)
    {
        $tipoMovimiento = 'egreso';
        $signo = -1;
        
        $cuenta = CuentaBancaria::find($registro->cuenta_bancaria_id);
        if ($cuenta) {
            $nuevoSaldo = $cuenta->saldo_actual + ($signo * $registro->monto);
            $cuenta->saldo_actual = $nuevoSaldo;
            $cuenta->save();
            
            Log::info('Saldo actualizado. Cuenta: ' . $cuenta->id . ', Nuevo saldo: ' . $nuevoSaldo);
        }
        
        $metodoPagoId = $registro->forma_pago === 'cheque' ? 2 : 1;
        
        $concepto = $registro->descripcion ?? '';
        if (empty($concepto)) {
            $concepto = 'Pago a proveedor: ' . ($registro->proveedor ?? 'Sin especificar');
        }
        
        $movimiento = MovimientoBancario::create([
            'cuenta_bancaria_id' => $registro->cuenta_bancaria_id,
            'proyecto_id' => $registro->proyecto_id,
            'tipo' => $tipoMovimiento,
            'tipo_egreso_id' => null,
            'categoria_gasto_id' => null,
            'metodo_pago_id' => $metodoPagoId,
            'monto' => $registro->monto,
            'fecha' => $registro->fecha,
            'concepto' => $concepto,
            'referencia' => $registro->referencia,
            'comprobante' => $registro->comprobante,
            'status' => 'aplicado',
            'observaciones' => 'Cheque/Transferencia: ' . ($registro->observaciones ?? ''),
            'created_by' => $registro->created_by,
            'codigo_sat_id' => $registro->codigo_sat_id
        ]);
        
        $registro->estatus = 'completado';
        $registro->save();
        
        Log::info('Movimiento creado ID: ' . $movimiento->id . ' con código SAT: ' . $registro->codigo_sat_id);
        
        return $movimiento;
    }

    /**
     * Actualizar saldos de facturas de proveedor (tabla pagos)
     */
    private function actualizarSaldosFacturasProveedor($facturasAplicadas)
    {
        foreach ($facturasAplicadas as $facturaId => $montoAplicado) {
            $pago = DB::table('pagos')->where('id', $facturaId)->first();
            if ($pago) {
                $nuevoSaldo = $pago->monto - $montoAplicado;
                DB::table('pagos')
                    ->where('id', $facturaId)
                    ->update([
                        'monto' => max(0, $nuevoSaldo),
                        'updated_at' => now()
                    ]);
                
                // Si el saldo queda en 0, cambiar estatus a pagado
                if ($nuevoSaldo <= 0) {
                    DB::table('pagos')
                        ->where('id', $facturaId)
                        ->update([
                            'estatus' => 'pagado',
                            'updated_at' => now()
                        ]);
                }
                
                Log::info('Pago actualizado ID: ' . $facturaId . ', Nuevo saldo: ' . max(0, $nuevoSaldo));
            }
        }
    }

    /**
     * Obtener nombre del proveedor
     */
    private function getNombreProveedor($data)
    {
        if (isset($data['proveedor_id']) && $data['proveedor_id']) {
            $proveedor = Proveedor::find($data['proveedor_id']);
            return $proveedor ? $proveedor->nombre : 'Proveedor sin nombre';
        }
        return $data['proveedor'] ?? 'Proveedor';
    }

    /**
     * Obtener estadísticas
     */
    public function getEstadisticas(Request $request)
    {
        try {
            $query = ChequeTransferencia::where('tipo_operacion', 'egreso');
            
            if ($request->has('proveedor_id') && $request->proveedor_id) {
                $query->where('proveedor_id', $request->proveedor_id);
            }
            
            $total = $query->count();
            $activos = $query->clone()->where('estatus', 'activo')->count();
            $completados = $query->clone()->where('estatus', 'completado')->count();
            $cancelados = $query->clone()->where('estatus', 'cancelado')->count();
            $totalMonto = $query->clone()->sum('monto');
            
            return response()->json([
                'total' => $total,
                'activos' => $activos,
                'completados' => $completados,
                'cancelados' => $cancelados,
                'total_monto' => $totalMonto
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getEstadisticas: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Obtener códigos SAT por tipo
     */
    public function getCodigosSat(Request $request)
    {
        try {
            $tipo = $request->get('tipo', 'G');
            $codigos = CodigoSat::where('tipo', $tipo)
                ->orderBy('codigo_agrupador')
                ->get(['id', 'codigo_agrupador', 'nombre_cuenta']);
            
            return response()->json([
                'success' => true,
                'data' => $codigos
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getCodigosSat: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener lista de proveedores para select
     */
    public function getProveedores(Request $request)
    {
        try {
            $proveedores = Proveedor::where('activo', true)
                ->orderBy('nombre')
                ->get(['id', 'nombre', 'rfc']);
            
            return response()->json([
                'success' => true,
                'data' => $proveedores
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getProveedores: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}