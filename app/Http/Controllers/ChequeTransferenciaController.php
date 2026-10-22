<?php
// app/Http/Controllers/ChequeTransferenciaController.php

namespace App\Http\Controllers;

use App\Models\ChequeTransferencia;
use App\Models\CuentaBancaria;
use App\Models\Moneda;
use App\Models\Proyecto;
use App\Models\Proveedor;
use App\Models\MovimientoBancario;
use App\Models\CodigoSat;
use App\Models\CuentaContable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

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
        
        $proveedores = Proveedor::where('activo', true)->orderBy('nombre')->get(['id', 'nombre', 'rfc']);
        
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
                    'proveedor_id' => $item->proveedor_id,
                    'forma_pago' => $item->forma_pago === 'cheque' ? 'Cheque' : 'Transferencia',
                    'cuenta' => $item->cuentaBancaria?->numero_cuenta ?? '-',
                    'cuenta_bancaria_id' => $item->cuenta_bancaria_id,
                    'fecha' => $item->fecha,
                    'referencia' => $item->referencia ?? '-',
                    'referencia_bancaria' => $item->referencia_bancaria ?? '-',
                    'monto' => (float) $item->monto,
                    'monto_restante' => (float) $item->monto_restante,
                    'monto_aplicado' => (float) $item->monto_aplicado,
                    'moneda' => $item->moneda?->simbolo ?? '-',
                    'moneda_id' => $item->moneda_id,
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
     * Descargar PDF del listado de cheques/transferencias
     */
    public function descargarPdf(Request $request)
    {
        try {
            $query = ChequeTransferencia::with([
                'cuentaBancaria.banco',
                'moneda',
                'proyecto',
                'codigoSat',
                'proveedorRel'
            ])->where('tipo_operacion', 'egreso');

            // Mismos filtros que getData
            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha', '>=', $request->fecha_inicio);
            }
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha', '<=', $request->fecha_fin);
            }
            if ($request->filled('forma_pago')) {
                $query->where('forma_pago', $request->forma_pago);
            }
            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }
            if ($request->filled('proveedor_id')) {
                $query->where('proveedor_id', $request->proveedor_id);
            }
            // Búsqueda libre (misma lógica que el buscador del frontend)
            if ($request->filled('buscar')) {
                $buscar = $request->buscar;
                $query->where(function ($q) use ($buscar) {
                    $q->where('proveedor', 'like', "%{$buscar}%")
                      ->orWhere('folio', 'like', "%{$buscar}%")
                      ->orWhere('descripcion', 'like', "%{$buscar}%");
                });
            }

            $registros = $query->orderBy('fecha', 'desc')->get();

            // Totales
            $totalMonto = $registros->sum('monto');
            $totalAplicado = $registros->sum('monto_aplicado');
            $totalRestante = $registros->sum('monto_restante');

            $pdf = Pdf::loadView(
                'administracion.tesoreria.pdf.cheques-transferencias',
                compact('registros', 'totalMonto', 'totalAplicado', 'totalRestante')
            )->setPaper('letter', 'landscape');

            $nombreArchivo = 'cheques-transferencias-' . now()->format('Y-m-d-His') . '.pdf';

            return $pdf->download($nombreArchivo);

        } catch (\Exception $e) {
            Log::error('Error al generar PDF cheques-transferencias: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener facturas/pagos pendientes de un proveedor
     * ✅ REPARADO: Ahora consulta la tabla 'facturas' correctamente
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
            
            // Buscar el proveedor
            $proveedor = DB::table('proveedores')
                ->where('id', $proveedorId)
                ->whereNull('deleted_at')
                ->first();
            
            if (!$proveedor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proveedor no encontrado'
                ], 404);
            }
            
            // ✅ REPARADO: Buscar facturas reales en la tabla 'facturas' cruzando por RFC o razón social
            $facturas = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->whereNull('f.deleted_at')
                ->where(function($q) use ($proveedor) {
                    $q->where('c.rfc', $proveedor->rfc)
                      ->orWhere('c.razon_social', $proveedor->nombre);
                })
                ->where('f.saldo_disponible', '>', 0)
                ->whereIn('f.estatus', [1, 2]) // 1=Pendiente, 2=Parcial
                ->select(
                    'f.factura_id as id',
                    'f.folio',
                    'f.fecha',
                    'f.fecha_vencimiento',
                    'f.subtotal',
                    'f.iva',
                    'f.total',
                    'f.saldo_disponible',
                    'f.estatus'
                )
                ->orderBy('f.fecha', 'asc')
                ->get()
                ->map(function($factura) {
                    $fechaVencimiento = $factura->fecha_vencimiento 
                        ? Carbon::parse($factura->fecha_vencimiento) 
                        : Carbon::parse($factura->fecha)->addDays(30);
                    
                    return [
                        'id' => $factura->id,
                        'folio' => $factura->folio ?? 'F-' . $factura->id,
                        'fecha' => $factura->fecha,
                        'fecha_vencimiento' => $fechaVencimiento->format('Y-m-d'),
                        'total' => (float) $factura->total,
                        'saldo_disponible' => (float) $factura->saldo_disponible,
                        'subtotal' => (float) $factura->subtotal,
                        'iva' => (float) $factura->iva,
                        'concepto' => 'Factura ' . ($factura->folio ?? $factura->id)
                    ];
                });
            
            // ✅ Si no hay facturas en la tabla facturas, buscar en la tabla pagos como fallback
            if ($facturas->isEmpty()) {
                $pagos = DB::table('pagos')
                    ->select(
                        'id',
                        'folio',
                        'fecha_pago as fecha',
                        'monto as total',
                        'monto as saldo_disponible',
                        'proveedor_nombre',
                        'concepto',
                        'created_at'
                    )
                    ->where('proveedor_id', $proveedorId)
                    ->where('estatus', 'pendiente')
                    ->where('monto', '>', 0)
                    ->orderBy('fecha_pago', 'asc')
                    ->get()
                    ->map(function($pago) {
                        $fechaPago = $pago->fecha ? Carbon::parse($pago->fecha) : Carbon::now();
                        $fechaVencimiento = $fechaPago->copy()->addDays(30);
                        
                        return [
                            'id' => $pago->id,
                            'folio' => $pago->folio ?? 'P-' . $pago->id,
                            'fecha' => $pago->fecha,
                            'fecha_vencimiento' => $fechaVencimiento->format('Y-m-d'),
                            'total' => (float) $pago->total,
                            'saldo_disponible' => (float) $pago->saldo_disponible,
                            'subtotal' => (float) $pago->total,
                            'iva' => 0,
                            'concepto' => $pago->concepto ?? 'Sin concepto'
                        ];
                    });
                
                $facturas = $pagos;
            }
            
            $hoy = now()->format('Y-m-d');
            $totalVencido = $facturas->filter(function($f) use ($hoy) {
                return $f['fecha_vencimiento'] && $f['fecha_vencimiento'] < $hoy;
            })->sum('saldo_disponible');
            
            $totalPorVencer = $facturas->filter(function($f) use ($hoy) {
                return !$f['fecha_vencimiento'] || $f['fecha_vencimiento'] >= $hoy;
            })->sum('saldo_disponible');
            
            return response()->json([
                'success' => true,
                'data' => $facturas->values(),
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
                'facturas_aplicadas.*.factura_id' => 'required',
                'facturas_aplicadas.*.monto' => 'required|numeric|min:0.01',
                'cuenta_contable_id' => 'nullable|exists:cuentas_contables,id',
                'fecha_vencimiento' => 'nullable|date',
                'comprobante' => 'nullable|string',
                'poliza_contable' => 'nullable|string',
            ]);
            
            DB::beginTransaction();
            
            $nombreProveedor = $this->getNombreProveedor($validated);
            
            $facturasAplicadas = [];
            $totalAplicado = 0;
            
            if (isset($validated['facturas_aplicadas']) && is_array($validated['facturas_aplicadas'])) {
                foreach ($validated['facturas_aplicadas'] as $item) {
                    $facturasAplicadas[$item['factura_id']] = (float) $item['monto'];
                    $totalAplicado += (float) $item['monto'];
                }
            }
            
            if ($totalAplicado > $validated['monto']) {
                throw new \Exception('El monto aplicado a facturas no puede exceder el monto total del pago');
            }
            
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
            
            $registro = ChequeTransferencia::create($createData);
            
            if (!empty($facturasAplicadas)) {
                $this->actualizarSaldosFacturasProveedor($facturasAplicadas);
            }
            
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
     * ✅ REPARADO: Ahora devuelve TODOS los campos necesarios para editar (incluyendo moneda_id, cuenta_bancaria_id, etc.)
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
            
            // Cargar detalle de facturas aplicadas
            $facturasDetalle = [];
            if ($registro->facturas_aplicadas && is_array($registro->facturas_aplicadas)) {
                $ids = array_keys($registro->facturas_aplicadas);
                
                // Buscar en facturas primero
                $facturas = DB::table('facturas')
                    ->whereIn('factura_id', $ids)
                    ->whereNull('deleted_at')
                    ->get();
                
                foreach ($facturas as $factura) {
                    $facturasDetalle[] = [
                        'id' => $factura->factura_id,
                        'folio' => $factura->folio ?? 'F-' . $factura->factura_id,
                        'fecha' => $factura->fecha,
                        'total' => (float) $factura->total,
                        'monto_aplicado' => (float) ($registro->facturas_aplicadas[$factura->factura_id] ?? 0),
                    ];
                }
                
                // Si no se encontraron en facturas, buscar en pagos
                if (empty($facturasDetalle)) {
                    $pagos = DB::table('pagos')->whereIn('id', $ids)->get();
                    foreach ($pagos as $pago) {
                        $facturasDetalle[] = [
                            'id' => $pago->id,
                            'folio' => $pago->folio ?? 'P-' . $pago->id,
                            'fecha' => $pago->fecha_pago,
                            'total' => (float) $pago->monto,
                            'monto_aplicado' => (float) ($registro->facturas_aplicadas[$pago->id] ?? 0),
                        ];
                    }
                }
            }
            
            // ✅ REPARADO: Devolver TODOS los campos necesarios
            return response()->json([
                'id' => $registro->id,
                'folio' => $registro->folio,
                'estatus' => $registro->estatus,
                'fecha' => $registro->fecha ? Carbon::parse($registro->fecha)->format('Y-m-d') : null,
                'fecha_vencimiento' => $registro->fecha_vencimiento ? Carbon::parse($registro->fecha_vencimiento)->format('Y-m-d') : null,
                'forma_pago' => $registro->forma_pago,
                'proveedor' => $registro->proveedor,
                'proveedor_id' => $registro->proveedor_id,
                'rfc' => $registro->rfc,
                'cuenta_bancaria_id' => $registro->cuenta_bancaria_id,
                'cuenta_bancaria' => $registro->cuentaBancaria ? [
                    'id' => $registro->cuentaBancaria->id,
                    'numero_cuenta' => $registro->cuentaBancaria->numero_cuenta,
                    'banco' => $registro->cuentaBancaria->banco?->nombre,
                ] : null,
                'moneda_id' => $registro->moneda_id,
                'moneda' => $registro->moneda ? [
                    'id' => $registro->moneda->id,
                    'simbolo' => $registro->moneda->simbolo,
                    'nombre' => $registro->moneda->nombre,
                ] : null,
                'monto' => (float) $registro->monto,
                'monto_restante' => (float) $registro->monto_restante,
                'monto_aplicado' => (float) $registro->monto_aplicado,
                'referencia' => $registro->referencia,
                'referencia_bancaria' => $registro->referencia_bancaria,
                'proyecto_id' => $registro->proyecto_id,
                'proyecto' => $registro->proyecto ? [
                    'id' => $registro->proyecto->id,
                    'codigo' => $registro->proyecto->codigo,
                    'nombre' => $registro->proyecto->nombre,
                ] : null,
                'descripcion' => $registro->descripcion,
                'observaciones' => $registro->observaciones,
                'codigo_sat_id' => $registro->codigo_sat_id,
                'codigo_sat' => $registro->codigoSat ? [
                    'id' => $registro->codigoSat->id,
                    'codigo_agrupador' => $registro->codigoSat->codigo_agrupador,
                    'nombre_cuenta' => $registro->codigoSat->nombre_cuenta,
                ] : null,
                'cuenta_contable_id' => $registro->cuenta_contable_id,
                'comprobante' => $registro->comprobante,
                'poliza_contable' => $registro->poliza_contable,
                'facturas_aplicadas' => $registro->facturas_aplicadas,
                'facturas_detalle' => $facturasDetalle,
                'created_at' => $registro->created_at,
                'updated_at' => $registro->updated_at,
            ]);
        } catch (\Exception $e) {
            Log::error('Error en show cheques-transferencias: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json(['error' => 'Registro no encontrado: ' . $e->getMessage()], 404);
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
                    'facturas_aplicadas' => 'nullable|array',
                ]);
            }
            
            DB::beginTransaction();
            
            if (isset($validated['proveedor']) && empty($validated['proveedor'])) {
                $validated['proveedor'] = $this->getNombreProveedor($validated);
            }
            
            // Recalcular montos si hay facturas aplicadas
            if (isset($validated['facturas_aplicadas']) && is_array($validated['facturas_aplicadas'])) {
                $facturasAplicadas = [];
                $totalAplicado = 0;
                
                foreach ($validated['facturas_aplicadas'] as $item) {
                    if (isset($item['factura_id']) && isset($item['monto'])) {
                        $facturasAplicadas[$item['factura_id']] = (float) $item['monto'];
                        $totalAplicado += (float) $item['monto'];
                    }
                }
                
                $validated['facturas_aplicadas'] = !empty($facturasAplicadas) ? $facturasAplicadas : null;
                $validated['monto_aplicado'] = $totalAplicado;
                $validated['monto_restante'] = ($validated['monto'] ?? $registro->monto) - $totalAplicado;
            }
            
            $registro->update($validated);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Registro actualizado exitosamente',
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
            Log::error('Error en update cheques-transferencias: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
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
     * Actualizar saldos de facturas de proveedor
     * 
     * Valores de estatus en tabla facturas:
     *   1 = PENDIENTE
     *   2 = PAGADA
     *   3 = CANCELADA
     */
    private function actualizarSaldosFacturasProveedor($facturasAplicadas)
    {
        // Constantes de estatus
        $ESTATUS_PENDIENTE = 1;
        $ESTATUS_PAGADA    = 2;
        $ESTATUS_CANCELADA = 3;
        
        foreach ($facturasAplicadas as $facturaId => $montoAplicado) {
            // Buscar la factura primero
            $factura = DB::table('facturas')->where('factura_id', $facturaId)->first();
            
            if ($factura) {
                // 🛡️ PROTECCIÓN: no tocar facturas canceladas
                if ((int) $factura->estatus === $ESTATUS_CANCELADA) {
                    Log::warning('Intento de aplicar pago a factura CANCELADA. ID: ' . $facturaId);
                    continue;
                }
                
                $nuevoSaldo = max(0, $factura->saldo_disponible - $montoAplicado);
                
                // Determinar nuevo estatus según el saldo resultante
                if ($nuevoSaldo <= 0.01) {
                    // Saldo llegó a 0 → PAGADA
                    $nuevoEstatus = $ESTATUS_PAGADA;
                } else {
                    // Aún tiene saldo pendiente → sigue PENDIENTE
                    $nuevoEstatus = $ESTATUS_PENDIENTE;
                }
                
                DB::table('facturas')
                    ->where('factura_id', $facturaId)
                    ->update([
                        'saldo_disponible' => $nuevoSaldo,
                        'estatus' => $nuevoEstatus,
                        'updated_at' => now()
                    ]);
                
                Log::info('Factura actualizada', [
                    'factura_id' => $facturaId,
                    'saldo_anterior' => $factura->saldo_disponible,
                    'monto_aplicado' => $montoAplicado,
                    'nuevo_saldo' => $nuevoSaldo,
                    'estatus_anterior' => $factura->estatus,
                    'nuevo_estatus' => $nuevoEstatus,
                ]);
                
                continue;
            }
            
            // Fallback: tabla pagos (por si algún pago viejo apunta ahí)
            $pago = DB::table('pagos')->where('id', $facturaId)->first();
            if ($pago) {
                $nuevoSaldo = max(0, $pago->monto - $montoAplicado);
                $updateData = [
                    'monto' => $nuevoSaldo,
                    'updated_at' => now()
                ];
                
                if ($nuevoSaldo <= 0) {
                    $updateData['estatus'] = 'pagado';
                }
                
                DB::table('pagos')->where('id', $facturaId)->update($updateData);
                
                Log::info('Pago actualizado', [
                    'pago_id' => $facturaId,
                    'nuevo_saldo' => $nuevoSaldo
                ]);
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

    /**
     * Obtener detalle de facturas aplicadas a un pago
     */
    public function getFacturasAplicadas($id)
    {
        try {
            $registro = ChequeTransferencia::findOrFail($id);
            
            $detalle = [];
            
            if ($registro->facturas_aplicadas && is_array($registro->facturas_aplicadas)) {
                $ids = array_keys($registro->facturas_aplicadas);
                
                // Buscar en facturas
                $facturas = DB::table('facturas')
                    ->whereIn('factura_id', $ids)
                    ->whereNull('deleted_at')
                    ->get();
                
                foreach ($facturas as $factura) {
                    $detalle[] = [
                        'id' => $factura->factura_id,
                        'folio' => $factura->folio ?? 'F-' . $factura->factura_id,
                        'fecha' => $factura->fecha,
                        'fecha_vencimiento' => $factura->fecha_vencimiento,
                        'total' => (float) $factura->total,
                        'saldo_actual' => (float) $factura->saldo_disponible,
                        'monto_aplicado' => (float) ($registro->facturas_aplicadas[$factura->factura_id] ?? 0),
                        'tipo' => 'factura'
                    ];
                }
                
                // Si no hay en facturas, buscar en pagos
                if (empty($detalle)) {
                    $pagos = DB::table('pagos')->whereIn('id', $ids)->get();
                    foreach ($pagos as $pago) {
                        $detalle[] = [
                            'id' => $pago->id,
                            'folio' => $pago->folio ?? 'P-' . $pago->id,
                            'fecha' => $pago->fecha_pago,
                            'fecha_vencimiento' => null,
                            'total' => (float) $pago->monto,
                            'saldo_actual' => (float) $pago->monto,
                            'monto_aplicado' => (float) ($registro->facturas_aplicadas[$pago->id] ?? 0),
                            'tipo' => 'pago'
                        ];
                    }
                }
            }
            
            return response()->json([
                'success' => true,
                'data' => $detalle,
                'total_aplicado' => array_sum(array_column($detalle, 'monto_aplicado'))
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getFacturasAplicadas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
 * Descargar PDF individual (comprobante) de una transferencia/cheque
 */
public function descargarPdfIndividual($id)
{
    try {
        $registro = ChequeTransferencia::with([
            'cuentaBancaria.banco',
            'cuentaBancaria.moneda',
            'moneda',
            'proyecto',
            'codigoSat',
            'proveedorRel',
            'cuentaContable'
        ])->findOrFail($id);

        // Cargar detalle de facturas aplicadas
        $facturasDetalle = [];
        if ($registro->facturas_aplicadas && is_array($registro->facturas_aplicadas)) {
            $ids = array_keys($registro->facturas_aplicadas);

            $facturas = DB::table('facturas')
                ->whereIn('factura_id', $ids)
                ->whereNull('deleted_at')
                ->get();

            foreach ($facturas as $factura) {
                $facturasDetalle[] = [
                    'id'             => $factura->factura_id,
                    'folio'          => $factura->folio ?? 'F-' . $factura->factura_id,
                    'fecha'          => $factura->fecha,
                    'total'          => (float) $factura->total,
                    'monto_aplicado' => (float) ($registro->facturas_aplicadas[$factura->factura_id] ?? 0),
                ];
            }

            // Fallback: tabla pagos
            if (empty($facturasDetalle)) {
                $pagos = DB::table('pagos')->whereIn('id', $ids)->get();
                foreach ($pagos as $pago) {
                    $facturasDetalle[] = [
                        'id'             => $pago->id,
                        'folio'          => $pago->folio ?? 'P-' . $pago->id,
                        'fecha'          => $pago->fecha_pago,
                        'total'          => (float) $pago->monto,
                        'monto_aplicado' => (float) ($registro->facturas_aplicadas[$pago->id] ?? 0),
                    ];
                }
            }
        }

        $pdf = Pdf::loadView(
            'administracion.tesoreria.pdf.comprobante-transferencia',
            compact('registro', 'facturasDetalle')
        )->setPaper('letter', 'portrait');

        $nombreArchivo = 'comprobante-' . $registro->folio . '.pdf';

        return $pdf->download($nombreArchivo);

    } catch (\Exception $e) {
        Log::error('Error al generar PDF individual: ' . $e->getMessage());
        Log::error($e->getTraceAsString());
        return response()->json([
            'success' => false,
            'message' => 'Error al generar PDF: ' . $e->getMessage()
        ], 500);
    }
}
}