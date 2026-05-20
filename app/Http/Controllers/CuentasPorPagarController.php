<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CuentasPorPagarController extends Controller
{
    /**
     * Muestra el reporte de antigüedad de saldos (Cuentas por Pagar)
     */
    public function index(Request $request)
    {
        // Obtener proveedores para el filtro
        $proveedores = DB::table('proveedores')
            ->select('id', 'nombre', 'rfc')
            ->whereNull('deleted_at')
            ->orderBy('nombre')
            ->get();
        
        $proveedorFiltro = $request->get('proveedor', 0);
        
        // Obtener pagos pendientes
        $query = DB::table('pagos')
            ->select(
                'id as pago_id',
                'folio',
                'fecha_pago',
                'monto',
                'estatus',
                'concepto',
                'proveedor_nombre',
                'proveedor_rfc',
                'proveedor_id'
            )
            ->where('estatus', 'pendiente');
        
        if ($proveedorFiltro != 0 && $proveedorFiltro != '0') {
            $query->where('proveedor_id', $proveedorFiltro);
        }
        
        $pagos = $query->get();
        
        $today = Carbon::now();
        $cuentasPorProveedor = [];
        $totales = [
            'corriente' => 0,
            'de_1_a_30' => 0,
            'de_31_a_60' => 0,
            'de_61_a_90' => 0,
            'de_91_a_120' => 0,
            'mas_120' => 0,
            'total_general' => 0
        ];
        
        foreach ($pagos as $pago) {
            $saldoPendiente = floatval($pago->monto);
            
            $columnaCorriente = 0;
            $columna1_30 = 0;
            $columna31_60 = 0;
            $columna61_90 = 0;
            $columna91_120 = 0;
            $columnaMas120 = 0;
            
            $fechaMostrar = null;
            $textoDias = "";
            
            if ($pago->fecha_pago) {
                // Parsear la fecha correctamente
                $fechaPago = Carbon::parse($pago->fecha_pago);
                $fechaVenc = $fechaPago->copy()->addDays(30);
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
                $textoDias = "Sin fecha de pago";
                $columnaCorriente = $saldoPendiente;
                $totales['corriente'] += $saldoPendiente;
            }
            
            $totales['total_general'] += $saldoPendiente;
            
            $proveedorId = $pago->proveedor_id ?? 0;
            $proveedorNombre = $pago->proveedor_nombre ?? 'SIN PROVEEDOR';
            $proveedorRfc = $pago->proveedor_rfc ?? 'N/A';
            
            if (!isset($cuentasPorProveedor[$proveedorId])) {
                $cuentasPorProveedor[$proveedorId] = [
                    'proveedor' => (object)[
                        'id' => $proveedorId,
                        'nombre' => $proveedorNombre,
                        'rfc' => $proveedorRfc
                    ],
                    'pagos' => [],
                    'rangos' => [
                        'corriente' => 0,
                        '1_30' => 0,
                        '31_60' => 0,
                        '61_90' => 0,
                        '91_120' => 0,
                        'mas_120' => 0
                    ],
                    'totales' => ['total' => 0]
                ];
            }
            
            $cuentasPorProveedor[$proveedorId]['pagos'][] = [
                'pago_id' => $pago->pago_id,
                'folio' => $pago->folio,
                'fecha_pago' => $pago->fecha_pago ? Carbon::parse($pago->fecha_pago)->format('d/m/Y') : 'Sin fecha',
                'fecha_vencimiento' => $fechaMostrar,
                'texto_dias' => $textoDias,
                'saldo_pendiente' => $saldoPendiente,
                'corriente' => $columnaCorriente,
                'rango_1_30' => $columna1_30,
                'rango_31_60' => $columna31_60,
                'rango_61_90' => $columna61_90,
                'rango_91_120' => $columna91_120,
                'mas_120' => $columnaMas120,
                'concepto' => $pago->concepto ?? 'Sin concepto'
            ];
            
            $cuentasPorProveedor[$proveedorId]['rangos']['corriente'] += $columnaCorriente;
            $cuentasPorProveedor[$proveedorId]['rangos']['1_30'] += $columna1_30;
            $cuentasPorProveedor[$proveedorId]['rangos']['31_60'] += $columna31_60;
            $cuentasPorProveedor[$proveedorId]['rangos']['61_90'] += $columna61_90;
            $cuentasPorProveedor[$proveedorId]['rangos']['91_120'] += $columna91_120;
            $cuentasPorProveedor[$proveedorId]['rangos']['mas_120'] += $columnaMas120;
            $cuentasPorProveedor[$proveedorId]['totales']['total'] += $saldoPendiente;
        }
        
        return view('administracion.cuentaspago.pagos', [
            'cuentasPorProveedor' => $cuentasPorProveedor,
            'totales' => $totales,
            'proveedores' => $proveedores
        ]);
    }
    
    /**
     * Obtiene el detalle de un pago específico
     */
    public function getDetallePago($pagoId)
    {
        try {
            $pago = DB::table('pagos')
                ->where('id', $pagoId)
                ->first();
            
            if (!$pago) {
                return response()->json(['success' => false, 'message' => 'Pago no encontrado']);
            }
            
            // Obtener nombre del proveedor si existe
            $proveedor = null;
            if ($pago->proveedor_id) {
                $proveedor = DB::table('proveedores')
                    ->where('id', $pago->proveedor_id)
                    ->first();
            }
            
            return response()->json([
                'success' => true,
                'pago' => $pago,
                'proveedor_nombre' => $proveedor ? $proveedor->nombre : $pago->proveedor_nombre,
                'proveedor_rfc' => $proveedor ? $proveedor->rfc : $pago->proveedor_rfc,
                'saldo_pendiente' => $pago->monto
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Método de prueba para verificar datos
     */
    public function test()
    {
        $pagos = DB::table('pagos')
            ->where('estatus', 'pendiente')
            ->get();
        
        return response()->json([
            'total' => $pagos->count(),
            'pagos' => $pagos
        ]);
    }
}