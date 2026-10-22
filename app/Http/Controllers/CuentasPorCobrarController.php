<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CuentasPorCobrarController extends Controller
{
    /**
     * Constantes de tipo de factura (deben coincidir con la migración)
     */
    private const TIPO_FACTURA_CLIENTE   = 'cliente';
    private const TIPO_FACTURA_PROVEEDOR = 'proveedor';

    /**
     * Vista principal de antigüedad de cuentas por cobrar
     */
    public function saldos(Request $request)
    {
        $clientes = DB::table('contactos')
            ->select('contacto_id', 'razon_social', 'rfc')
            ->whereNull('deleted_at')
            ->orderBy('razon_social')
            ->get();

        $clienteFiltro = $request->get('cliente', 0);

        // ============================================================
        // FIX TICKET: "CXC está trayendo facturas de proveedor"
        // Solo se consideran facturas de tipo 'cliente' (emitidas).
        // ============================================================
        $query = DB::table('facturas as f')
            ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
            ->select(
                'f.factura_id',
                'f.folio',
                'f.fecha',
                'f.fecha_vencimiento',
                'f.total',
                'f.saldo_disponible',
                'f.tipo_comprobante',
                'c.contacto_id as cliente_id',
                'c.razon_social as cliente_nombre',
                'c.rfc'
            )
            ->whereNull('f.deleted_at')
            ->where('f.total', '>', 0)
            ->where('f.saldo_disponible', '>', 0);

        $this->aplicarFiltroSoloClientes($query);

        if ($clienteFiltro != 0 && $clienteFiltro != '0') {
            $query->where('c.contacto_id', $clienteFiltro);
        }

        $facturas = $query->get();

        $today = Carbon::now();
        $cuentasPorCliente = [];
        $totales = [
            'corriente'      => 0,
            'de_1_a_30'      => 0,
            'de_31_a_60'     => 0,
            'de_61_a_90'     => 0,
            'de_91_a_120'    => 0,
            'mas_120'        => 0,
            'anticipo'       => 0,
            'total_general'  => 0,
        ];

        foreach ($facturas as $factura) {
            $saldoPendiente = (float) $factura->saldo_disponible;

            $columnaCorriente = 0;
            $columna1_30      = 0;
            $columna31_60     = 0;
            $columna61_90     = 0;
            $columna91_120    = 0;
            $columnaMas120    = 0;

            $fechaMostrar = null;
            $textoDias    = '';

            if ($factura->fecha_vencimiento) {
                $fechaVenc = $this->parseFecha($factura->fecha_vencimiento);

                if ($fechaVenc) {
                    $fechaMostrar = $fechaVenc->format('d/m/Y');

                    if ($fechaVenc->isFuture()) {
                        $dias = $today->diffInDays($fechaVenc);
                        $textoDias = "Vence en {$dias} días";
                        $columnaCorriente = $saldoPendiente;
                        $totales['corriente'] += $saldoPendiente;
                    } else {
                        $dias = $fechaVenc->diffInDays($today);
                        $textoDias = "Vencido hace {$dias} días";

                        if ($dias <= 30) {
                            $columna1_30 = $saldoPendiente;
                            $totales['de_1_a_30'] += $saldoPendiente;
                        } elseif ($dias <= 60) {
                            $columna31_60 = $saldoPendiente;
                            $totales['de_31_a_60'] += $saldoPendiente;
                        } elseif ($dias <= 90) {
                            $columna61_90 = $saldoPendiente;
                            $totales['de_61_a_90'] += $saldoPendiente;
                        } elseif ($dias <= 120) {
                            $columna91_120 = $saldoPendiente;
                            $totales['de_91_a_120'] += $saldoPendiente;
                        } else {
                            $columnaMas120 = $saldoPendiente;
                            $totales['mas_120'] += $saldoPendiente;
                        }
                    }
                } else {
                    $textoDias = 'Fecha inválida';
                    $columnaCorriente = $saldoPendiente;
                    $totales['corriente'] += $saldoPendiente;
                }
            } else {
                $textoDias = 'Sin fecha';
                $columnaCorriente = $saldoPendiente;
                $totales['corriente'] += $saldoPendiente;
            }

            $totales['total_general'] += $saldoPendiente;

            $clienteId     = $factura->cliente_id ?? 0;
            $clienteNombre = $factura->cliente_nombre ?? 'SIN CLIENTE';

            if (!isset($cuentasPorCliente[$clienteId])) {
                $cuentasPorCliente[$clienteId] = [
                    'cliente' => (object) [
                        'contacto_id'  => $clienteId,
                        'razon_social' => $clienteNombre,
                        'rfc'          => $factura->rfc ?? 'N/A',
                    ],
                    'facturas' => [],
                    'rangos' => [
                        'corriente' => 0, '1_30' => 0, '31_60' => 0,
                        '61_90' => 0, '91_120' => 0, 'mas_120' => 0,
                    ],
                    'totales' => ['total' => 0],
                ];
            }

            $cuentasPorCliente[$clienteId]['facturas'][] = [
                'factura_id'       => $factura->factura_id,
                'folio'            => $factura->folio,
                'fecha_vencimiento'=> $fechaMostrar,
                'texto_dias'       => $textoDias,
                'saldo_pendiente'  => $saldoPendiente,
                'corriente'        => $columnaCorriente,
                'rango_1_30'       => $columna1_30,
                'rango_31_60'      => $columna31_60,
                'rango_61_90'      => $columna61_90,
                'rango_91_120'     => $columna91_120,
                'mas_120'          => $columnaMas120,
            ];

            $cuentasPorCliente[$clienteId]['rangos']['corriente'] += $columnaCorriente;
            $cuentasPorCliente[$clienteId]['rangos']['1_30']      += $columna1_30;
            $cuentasPorCliente[$clienteId]['rangos']['31_60']     += $columna31_60;
            $cuentasPorCliente[$clienteId]['rangos']['61_90']     += $columna61_90;
            $cuentasPorCliente[$clienteId]['rangos']['91_120']    += $columna91_120;
            $cuentasPorCliente[$clienteId]['rangos']['mas_120']   += $columnaMas120;
            $cuentasPorCliente[$clienteId]['totales']['total']    += $saldoPendiente;
        }

        uasort($cuentasPorCliente, function ($a, $b) {
            return strcasecmp($a['cliente']->razon_social, $b['cliente']->razon_social);
        });

        return view('administracion.cuentascobrar.saldos', [
            'cuentasPorCliente' => $cuentasPorCliente,
            'totales'           => $totales,
            'clientes'          => $clientes,
            'clienteFiltro'     => $clienteFiltro,
        ]);
    }

    /**
     * Detalle de una factura (para el modal del blade)
     */
    public function getDetalleFactura($facturaId)
    {
        try {
            if (!is_numeric($facturaId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de factura inválido',
                ], 400);
            }

            $query = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->where('f.factura_id', $facturaId)
                ->select('f.*', 'c.razon_social as cliente', 'c.rfc');

            // Solo facturas de cliente
            $this->aplicarFiltroSoloClientes($query);

            $factura = $query->first();

            if (!$factura) {
                return response()->json([
                    'success' => false,
                    'message' => 'Factura no encontrada',
                ], 404);
            }

            $pagos = DB::table('contrarecibo_facturas as cf')
                ->leftJoin('contrarecibos as cr', 'cf.contrarecibo_id', '=', 'cr.contrarecibo_id')
                ->where('cf.factura_id', $facturaId)
                ->select(
                    'cr.folio',
                    'cr.fecha_pago as fecha',
                    'cf.monto_aplicado as monto',
                    'cr.forma_pago'
                )
                ->orderBy('cr.fecha_pago', 'desc')
                ->get();

            $factura->fecha_vencimiento_formateada = $this->formatearFechaParaVista($factura->fecha_vencimiento ?? null);
            $factura->fecha_formateada             = $this->formatearFechaParaVista($factura->fecha ?? null);

            $pagos = $pagos->map(function ($pago) {
                $fechaPago = $this->parseFecha($pago->fecha ?? null);
                $pago->fecha = $fechaPago
                    ? $fechaPago->format('d/m/Y')
                    : ($pago->fecha ?? 'N/A');
                return $pago;
            });

            return response()->json([
                'success'         => true,
                'factura'         => $factura,
                'saldo_pendiente' => (float) ($factura->saldo_disponible ?? 0),
                'pagos'           => $pagos,
            ]);
        } catch (\Throwable $e) {
            \Log::error('Error en getDetalleFactura: ' . $e->getMessage(), [
                'factura_id' => $facturaId,
                'trace'      => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno al obtener el detalle de la factura',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Endpoint para refrescar la vista sin recargar (botón Actualizar)
     */
    public function actualizar(Request $request)
    {
        try {
            $clienteFiltro = $request->get('cliente', 0);

            $query = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->select(
                    'f.factura_id',
                    'f.folio',
                    'f.fecha',
                    'f.fecha_vencimiento',
                    'f.total',
                    'f.saldo_disponible',
                    'f.tipo_comprobante',
                    'c.contacto_id as cliente_id',
                    'c.razon_social as cliente_nombre',
                    'c.rfc'
                )
                ->whereNull('f.deleted_at')
                ->where('f.total', '>', 0)
                ->where('f.saldo_disponible', '>', 0);

            $this->aplicarFiltroSoloClientes($query);

            if ($clienteFiltro != 0 && $clienteFiltro != '0') {
                $query->where('c.contacto_id', $clienteFiltro);
            }

            $facturas = $query->get();
            $today    = Carbon::now();

            $cuentasPorCliente = [];
            $totales = [
                'corriente'     => 0,
                'de_1_a_30'     => 0,
                'de_31_a_60'    => 0,
                'de_61_a_90'    => 0,
                'de_91_a_120'   => 0,
                'mas_120'       => 0,
                'anticipo'      => 0,
                'total_general' => 0,
            ];

            foreach ($facturas as $factura) {
                $saldoPendiente   = (float) $factura->saldo_disponible;
                $columnaCorriente = $columna1_30 = $columna31_60 = 0;
                $columna61_90     = $columna91_120 = $columnaMas120 = 0;
                $fechaMostrar     = null;
                $textoDias        = '';

                if ($factura->fecha_vencimiento) {
                    $fechaVenc = $this->parseFecha($factura->fecha_vencimiento);
                    if ($fechaVenc) {
                        $fechaMostrar = $fechaVenc->format('d/m/Y');
                        if ($fechaVenc->isFuture()) {
                            $dias = $today->diffInDays($fechaVenc);
                            $textoDias = "Vence en {$dias} días";
                            $columnaCorriente = $saldoPendiente;
                            $totales['corriente'] += $saldoPendiente;
                        } else {
                            $dias = $fechaVenc->diffInDays($today);
                            $textoDias = "Vencido hace {$dias} días";
                            if ($dias <= 30) {
                                $columna1_30 = $saldoPendiente;
                                $totales['de_1_a_30'] += $saldoPendiente;
                            } elseif ($dias <= 60) {
                                $columna31_60 = $saldoPendiente;
                                $totales['de_31_a_60'] += $saldoPendiente;
                            } elseif ($dias <= 90) {
                                $columna61_90 = $saldoPendiente;
                                $totales['de_61_a_90'] += $saldoPendiente;
                            } elseif ($dias <= 120) {
                                $columna91_120 = $saldoPendiente;
                                $totales['de_91_a_120'] += $saldoPendiente;
                            } else {
                                $columnaMas120 = $saldoPendiente;
                                $totales['mas_120'] += $saldoPendiente;
                            }
                        }
                    } else {
                        $textoDias = 'Fecha inválida';
                        $columnaCorriente = $saldoPendiente;
                        $totales['corriente'] += $saldoPendiente;
                    }
                } else {
                    $textoDias = 'Sin fecha';
                    $columnaCorriente = $saldoPendiente;
                    $totales['corriente'] += $saldoPendiente;
                }

                $totales['total_general'] += $saldoPendiente;

                $clienteId     = $factura->cliente_id ?? 0;
                $clienteNombre = $factura->cliente_nombre ?? 'SIN CLIENTE';

                if (!isset($cuentasPorCliente[$clienteId])) {
                    $cuentasPorCliente[$clienteId] = [
                        'cliente' => [
                            'contacto_id'  => $clienteId,
                            'razon_social' => $clienteNombre,
                            'rfc'          => $factura->rfc ?? 'N/A',
                        ],
                        'facturas' => [],
                        'rangos' => [
                            'corriente' => 0, '1_30' => 0, '31_60' => 0,
                            '61_90' => 0, '91_120' => 0, 'mas_120' => 0,
                        ],
                        'totales' => ['total' => 0],
                    ];
                }

                $cuentasPorCliente[$clienteId]['facturas'][] = [
                    'factura_id'        => $factura->factura_id,
                    'folio'             => $factura->folio,
                    'fecha_vencimiento' => $fechaMostrar,
                    'texto_dias'        => $textoDias,
                    'saldo_pendiente'   => $saldoPendiente,
                    'corriente'         => $columnaCorriente,
                    'rango_1_30'        => $columna1_30,
                    'rango_31_60'       => $columna31_60,
                    'rango_61_90'       => $columna61_90,
                    'rango_91_120'      => $columna91_120,
                    'mas_120'           => $columnaMas120,
                ];

                $cuentasPorCliente[$clienteId]['rangos']['corriente'] += $columnaCorriente;
                $cuentasPorCliente[$clienteId]['rangos']['1_30']      += $columna1_30;
                $cuentasPorCliente[$clienteId]['rangos']['31_60']     += $columna31_60;
                $cuentasPorCliente[$clienteId]['rangos']['61_90']     += $columna61_90;
                $cuentasPorCliente[$clienteId]['rangos']['91_120']    += $columna91_120;
                $cuentasPorCliente[$clienteId]['rangos']['mas_120']   += $columnaMas120;
                $cuentasPorCliente[$clienteId]['totales']['total']    += $saldoPendiente;
            }

            uasort($cuentasPorCliente, function ($a, $b) {
                return strcasecmp($a['cliente']['razon_social'], $b['cliente']['razon_social']);
            });

            return response()->json([
                'success'           => true,
                'cuentasPorCliente' => $cuentasPorCliente,
                'totales'           => $totales,
                'timestamp'         => now()->format('d/m/Y H:i:s'),
            ]);
        } catch (\Throwable $e) {
            \Log::error('Error en actualizar CXC: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar los datos',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * ============================================================
     * HELPER CENTRALIZADO: aplicar filtro para que SOLO se incluyan
     * facturas de cliente (CXC), nunca de proveedor (CXP).
     * ============================================================
     */
    private function aplicarFiltroSoloClientes($query): void
    {
        if (Schema::hasColumn('facturas', 'tipo_factura')) {
            // Nuevo esquema (fix del ticket de facturas proveedor):
            // solo 'cliente' son cuentas por cobrar.
            $query->where('f.tipo_factura', '=', self::TIPO_FACTURA_CLIENTE);
            return;
        }

        if (Schema::hasColumn('facturas', 'tipo')) {
            $query->whereIn('f.tipo', ['emitida', 'CXC', 'cxc', 'venta', 'Venta']);
            return;
        }

        if (Schema::hasColumn('facturas', 'es_proveedor')) {
            $query->where('f.es_proveedor', 0);
            return;
        }

        if (Schema::hasColumn('facturas', 'tipo_movimiento')) {
            $query->whereIn('f.tipo_movimiento', ['CXC', 'cxc', 'Cobrar', 'cobrar']);
            return;
        }

        // Sin columna de clasificación → se asume que la tabla ya contiene solo CXC.
    }

    /**
     * Formatea fecha para mostrar en la vista (modal detalle).
     */
    private function formatearFechaParaVista($fecha): ?string
    {
        if (empty($fecha)) {
            return null;
        }
        $parsed = $this->parseFecha($fecha);
        return $parsed ? $parsed->format('d/m/Y') : $fecha;
    }

    /**
     * Helper para parsear fechas en distintos formatos.
     */
    private function parseFecha($fecha)
    {
        if (empty($fecha)) {
            return null;
        }

        $formatos = [
            'd/m/Y',
            'd/m/Y H:i:s',
            'Y-m-d',
            'Y-m-d H:i:s',
            'd-m-Y',
            'm/d/Y',
        ];

        foreach ($formatos as $formato) {
            try {
                $fechaParsed = Carbon::createFromFormat($formato, $fecha);
                if ($fechaParsed && $fechaParsed->format($formato) === $fecha) {
                    return $fechaParsed;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        try {
            return Carbon::parse($fecha);
        } catch (\Exception $e) {
            return null;
        }
    }
}