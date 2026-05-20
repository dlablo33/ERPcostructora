<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CuentasPorCobrarController extends Controller
{
    public function saldos(Request $request)
    {
        $clientes = DB::table('contactos')
            ->select('contacto_id', 'razon_social', 'rfc')
            ->whereNull('deleted_at')
            ->orderBy('razon_social')
            ->get();
        
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
                'c.contacto_id as cliente_id',
                'c.razon_social as cliente_nombre',
                'c.rfc'
            )
            ->where('f.total', '>', 0)
            ->where('f.saldo_disponible', '>', 0);
        
        if ($clienteFiltro != 0 && $clienteFiltro != '0') {
            $query->where('c.contacto_id', $clienteFiltro);
        }
        
        $facturas = $query->get();
        
        $today = Carbon::now();
        $cuentasPorCliente = [];
        $totales = [
            'corriente' => 0, 'de_1_a_30' => 0, 'de_31_a_60' => 0,
            'de_61_a_90' => 0, 'de_91_a_120' => 0, 'mas_120' => 0,
            'anticipo' => 0, 'total_general' => 0
        ];
        
        foreach ($facturas as $factura) {
            $saldoPendiente = $factura->saldo_disponible;
            
            $columnaCorriente = 0;
            $columna1_30 = 0;
            $columna31_60 = 0;
            $columna61_90 = 0;
            $columna91_120 = 0;
            $columnaMas120 = 0;
            
            $fechaMostrar = null;
            $textoDias = "";
            
            if ($factura->fecha_vencimiento) {
                // Intentar parsear la fecha en diferentes formatos
                $fechaVenc = $this->parseFecha($factura->fecha_vencimiento);
                
                if ($fechaVenc) {
                    $fechaMostrar = $fechaVenc->format('d/m/Y');
                    
                    // COMPARACIÓN CORRECTA
                    if ($fechaVenc->isFuture()) {
                        // FECHA FUTURA (aún no vence)
                        $dias = $today->diffInDays($fechaVenc);
                        $textoDias = "Vence en {$dias} días";
                        $columnaCorriente = $saldoPendiente;
                        $totales['corriente'] += $saldoPendiente;
                    } else {
                        // FECHA PASADA O HOY (ya vencida)
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
                    // No se pudo parsear la fecha
                    $textoDias = "Fecha inválida";
                    $columnaCorriente = $saldoPendiente;
                    $totales['corriente'] += $saldoPendiente;
                }
            } else {
                $textoDias = "Sin fecha";
                $columnaCorriente = $saldoPendiente;
                $totales['corriente'] += $saldoPendiente;
            }
            
            $totales['total_general'] += $saldoPendiente;
            
            $clienteId = $factura->cliente_id ?? 0;
            $clienteNombre = $factura->cliente_nombre ?? 'SIN CLIENTE';
            
            if (!isset($cuentasPorCliente[$clienteId])) {
                $cuentasPorCliente[$clienteId] = [
                    'cliente' => (object)[
                        'contacto_id' => $clienteId,
                        'razon_social' => $clienteNombre,
                        'rfc' => $factura->rfc ?? 'N/A'
                    ],
                    'facturas' => [],
                    'rangos' => [
                        'corriente' => 0, '1_30' => 0, '31_60' => 0,
                        '61_90' => 0, '91_120' => 0, 'mas_120' => 0
                    ],
                    'totales' => ['total' => 0]
                ];
            }
            
            $cuentasPorCliente[$clienteId]['facturas'][] = [
                'factura_id' => $factura->factura_id,
                'folio' => $factura->folio,
                'fecha_vencimiento' => $fechaMostrar,
                'texto_dias' => $textoDias,
                'saldo_pendiente' => $saldoPendiente,
                'corriente' => $columnaCorriente,
                'rango_1_30' => $columna1_30,
                'rango_31_60' => $columna31_60,
                'rango_61_90' => $columna61_90,
                'rango_91_120' => $columna91_120,
                'mas_120' => $columnaMas120
            ];
            
            $cuentasPorCliente[$clienteId]['rangos']['corriente'] += $columnaCorriente;
            $cuentasPorCliente[$clienteId]['rangos']['1_30'] += $columna1_30;
            $cuentasPorCliente[$clienteId]['rangos']['31_60'] += $columna31_60;
            $cuentasPorCliente[$clienteId]['rangos']['61_90'] += $columna61_90;
            $cuentasPorCliente[$clienteId]['rangos']['91_120'] += $columna91_120;
            $cuentasPorCliente[$clienteId]['rangos']['mas_120'] += $columnaMas120;
            $cuentasPorCliente[$clienteId]['totales']['total'] += $saldoPendiente;
        }
        
        return view('administracion.cuentascobrar.saldos', [
            'cuentasPorCliente' => $cuentasPorCliente,
            'totales' => $totales,
            'clientes' => $clientes,
            'clienteFiltro' => $clienteFiltro
        ]);
    }
    
    public function getDetalleFactura($facturaId)
    {
        $factura = DB::table('facturas as f')
            ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
            ->where('f.factura_id', $facturaId)
            ->select('f.*', 'c.razon_social as cliente', 'c.rfc')
            ->first();
        
        if (!$factura) {
            return response()->json(['success' => false, 'message' => 'Factura no encontrada']);
        }
        
        $pagos = DB::table('contrarecibo_facturas as cf')
            ->leftJoin('contrarecibos as cr', 'cf.contrarecibo_id', '=', 'cr.contrarecibo_id')
            ->where('cf.factura_id', $facturaId)
            ->select('cr.folio', 'cr.fecha_pago as fecha', 'cf.monto_aplicado as monto', 'cr.forma_pago')
            ->orderBy('cr.fecha_pago', 'desc')
            ->get();
        
        // Formatear fechas para la respuesta JSON
        if ($factura->fecha_vencimiento) {
            $fechaVenc = $this->parseFecha($factura->fecha_vencimiento);
            $factura->fecha_vencimiento_formateada = $fechaVenc ? $fechaVenc->format('d/m/Y') : $factura->fecha_vencimiento;
        }
        
        if ($factura->fecha) {
            $fechaFactura = $this->parseFecha($factura->fecha);
            $factura->fecha_formateada = $fechaFactura ? $fechaFactura->format('d/m/Y') : $factura->fecha;
        }
        
        return response()->json([
            'success' => true,
            'factura' => $factura,
            'saldo_pendiente' => $factura->saldo_disponible,
            'pagos' => $pagos
        ]);
    }
    
    /**
     * Función helper para parsear fechas en diferentes formatos
     * 
     * @param string $fecha
     * @return Carbon|null
     */
    private function parseFecha($fecha)
    {
        if (empty($fecha)) {
            return null;
        }
        
        // Intentar diferentes formatos
        $formatos = [
            'd/m/Y',        // 30/06/2026
            'd/m/Y H:i:s',  // 30/06/2026 14:30:00
            'Y-m-d',        // 2026-06-30
            'Y-m-d H:i:s',  // 2026-06-30 14:30:00
            'd-m-Y',        // 30-06-2026
            'm/d/Y',        // 06/30/2026
        ];
        
        foreach ($formatos as $formato) {
            try {
                $fechaParsed = Carbon::createFromFormat($formato, $fecha);
                if ($fechaParsed && $fechaParsed->format($formato) === $fecha) {
                    return $fechaParsed;
                }
            } catch (\Exception $e) {
                // Continuar con el siguiente formato
                continue;
            }
        }
        
        // Último intento con parse() nativo
        try {
            return Carbon::parse($fecha);
        } catch (\Exception $e) {
            return null;
        }
    }
}