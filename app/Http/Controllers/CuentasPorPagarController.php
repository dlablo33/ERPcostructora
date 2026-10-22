<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CuentasPorPagarController extends Controller
{
    public function index(Request $request)
    {
        $proveedores = DB::table('proveedores')
            ->select('id', 'nombre', 'rfc')
            ->whereNull('deleted_at')
            ->orderBy('nombre')
            ->get();
        
        $proveedorFiltro = $request->get('proveedor', 0);
        $today = Carbon::now();
        
        $cuentasPorProveedor = [];
        $totales = [
            'corriente' => 0, 'de_1_a_30' => 0, 'de_31_a_60' => 0,
            'de_61_a_90' => 0, 'de_91_a_120' => 0, 'mas_120' => 0,
            'total_general' => 0
        ];
        
        // ============================================
        // 1. GASTOS FIJOS (recurrentes activos)
        // ============================================
        $this->cargarGastosFijos($proveedorFiltro, $today, $cuentasPorProveedor, $totales);
        
        // ============================================
        // 2. GASTOS PROYECTO (pendientes de pago)
        // ============================================
        $this->cargarGastosProyecto($proveedorFiltro, $today, $cuentasPorProveedor, $totales);
        
        // ============================================
        // 3. GASTOS INDIRECTOS (pendientes de pago)
        // ============================================
        $this->cargarGastosIndirectos($proveedorFiltro, $today, $cuentasPorProveedor, $totales);
        
        // Ordenar por nombre de proveedor
        uasort($cuentasPorProveedor, function($a, $b) {
            return strcmp($a['proveedor']->nombre, $b['proveedor']->nombre);
        });
        
        return view('administracion.cuentaspago.pagos', [
            'cuentasPorProveedor' => $cuentasPorProveedor,
            'totales' => $totales,
            'proveedores' => $proveedores,
        ]);
    }
    
    /**
     * Gastos Fijos: estatus='Activo', con fecha_fin (o fecha_inicio+30 días)
     */
    private function cargarGastosFijos(
        $proveedorFiltro,
        Carbon $today,
        array &$cuentasPorProveedor,
        array &$totales
    ): void {
        try {
            $query = DB::table('gastos_fijos as g')
                ->leftJoin('proveedores as p', 'g.proveedor_id', '=', 'p.id')
                ->select(
                    'g.gasto_fijo_id as id',
                    'g.descripcion as folio',
                    'g.descripcion as concepto',
                    'g.fecha_inicio',
                    'g.fecha_fin',
                    'g.importe as monto',
                    'g.estatus',
                    'g.proveedor_id',
                    'p.nombre as proveedor_nombre',
                    'p.rfc as proveedor_rfc'
                )
                ->whereNull('g.deleted_at')
                ->whereIn('g.estatus', ['Activo', 'activo', 'ACTIVO']);
            
            if ($proveedorFiltro != 0 && $proveedorFiltro != '0') {
                $query->where('g.proveedor_id', $proveedorFiltro);
            }
            
            foreach ($query->get() as $gasto) {
                $saldo = floatval($gasto->monto);
                if ($saldo <= 0) continue;
                
                // Vencimiento: fecha_fin o fecha_inicio + 30 días
                $fechaVenc = null;
                if (!empty($gasto->fecha_fin)) {
                    $fechaVenc = Carbon::parse($gasto->fecha_fin);
                } elseif (!empty($gasto->fecha_inicio)) {
                    $fechaVenc = Carbon::parse($gasto->fecha_inicio)->addDays(30);
                }
                
                $rangos = $this->calcularRango($fechaVenc, $today, $saldo);
                
                $this->agregarDocumento(
                    $cuentasPorProveedor, $totales,
                    $gasto->proveedor_id,
                    $gasto->proveedor_nombre ?? 'SIN PROVEEDOR',
                    $gasto->proveedor_rfc ?? 'N/A',
                    [
                        'pago_id' => 'GF-' . $gasto->id,
                        'folio' => 'GF-' . $gasto->id,
                        'fecha_pago' => $gasto->fecha_inicio
                            ? Carbon::parse($gasto->fecha_inicio)->format('d/m/Y')
                            : 'Sin fecha',
                        'fecha_vencimiento' => $rangos['fecha_vencimiento'],
                        'texto_dias' => $rangos['texto_dias'],
                        'saldo_pendiente' => $saldo,
                        'corriente' => $rangos['corriente'],
                        'rango_1_30' => $rangos['1_30'],
                        'rango_31_60' => $rangos['31_60'],
                        'rango_61_90' => $rangos['61_90'],
                        'rango_91_120' => $rangos['91_120'],
                        'mas_120' => $rangos['mas_120'],
                        'concepto' => $gasto->concepto ?? 'Gasto fijo',
                        'tipo' => 'gasto_fijo',
                        'origen' => 'Gasto Fijo',
                        'estatus' => $gasto->estatus,
                    ]
                );
            }
        } catch (\Exception $e) {
            \Log::error('CXP - gastos_fijos: ' . $e->getMessage());
        }
    }
    
    /**
     * Gastos Proyecto: excluye pagados/cancelados
     */
    private function cargarGastosProyecto(
        $proveedorFiltro,
        Carbon $today,
        array &$cuentasPorProveedor,
        array &$totales
    ): void {
        try {
            $query = DB::table('gastos_proyecto as g')
                ->leftJoin('proveedores as p', 'g.proveedor_id', '=', 'p.id')
                ->select(
                    'g.id',
                    'g.folio',
                    'g.fecha',
                    'g.monto',
                    'g.estatus',
                    'g.notas as concepto',
                    'g.proveedor_id',
                    'p.nombre as proveedor_nombre',
                    'p.rfc as proveedor_rfc'
                )
                ->whereNull('g.deleted_at')
                ->whereNotIn('g.estatus', [
                    'pagado', 'Pagado', 'PAGADO',
                    'cancelado', 'Cancelado', 'CANCELADO',
                    'pagada', 'Pagada', 'PAGADA',
                ]);
            
            if ($proveedorFiltro != 0 && $proveedorFiltro != '0') {
                $query->where('g.proveedor_id', $proveedorFiltro);
            }
            
            foreach ($query->get() as $gasto) {
                $saldo = floatval($gasto->monto);
                if ($saldo <= 0) continue;
                
                $fechaVenc = $gasto->fecha
                    ? Carbon::parse($gasto->fecha)->addDays(30)
                    : null;
                
                $rangos = $this->calcularRango($fechaVenc, $today, $saldo);
                
                $this->agregarDocumento(
                    $cuentasPorProveedor, $totales,
                    $gasto->proveedor_id,
                    $gasto->proveedor_nombre ?? 'SIN PROVEEDOR',
                    $gasto->proveedor_rfc ?? 'N/A',
                    [
                        'pago_id' => 'GP-' . $gasto->id,
                        'folio' => $gasto->folio ?? ('GP-' . $gasto->id),
                        'fecha_pago' => $gasto->fecha
                            ? Carbon::parse($gasto->fecha)->format('d/m/Y')
                            : 'Sin fecha',
                        'fecha_vencimiento' => $rangos['fecha_vencimiento'],
                        'texto_dias' => $rangos['texto_dias'],
                        'saldo_pendiente' => $saldo,
                        'corriente' => $rangos['corriente'],
                        'rango_1_30' => $rangos['1_30'],
                        'rango_31_60' => $rangos['31_60'],
                        'rango_61_90' => $rangos['61_90'],
                        'rango_91_120' => $rangos['91_120'],
                        'mas_120' => $rangos['mas_120'],
                        'concepto' => $gasto->concepto ?? 'Gasto proyecto',
                        'tipo' => 'gasto_proyecto',
                        'origen' => 'Gasto Proyecto',
                        'estatus' => $gasto->estatus,
                    ]
                );
            }
        } catch (\Exception $e) {
            \Log::error('CXP - gastos_proyecto: ' . $e->getMessage());
        }
    }
    
    /**
     * Gastos Indirectos: excluye pagados/cancelados
     */
    private function cargarGastosIndirectos(
        $proveedorFiltro,
        Carbon $today,
        array &$cuentasPorProveedor,
        array &$totales
    ): void {
        try {
            $query = DB::table('gastos_indirectos as g')
                ->leftJoin('proveedores as p', 'g.proveedor_id', '=', 'p.id')
                ->select(
                    'g.id',
                    'g.folio',
                    'g.fecha',
                    'g.monto',
                    'g.estatus',
                    'g.concepto',
                    'g.proveedor_id',
                    'p.nombre as proveedor_nombre',
                    'p.rfc as proveedor_rfc'
                )
                ->whereNull('g.deleted_at')
                ->whereNotIn('g.estatus', [
                    'pagado', 'Pagado', 'PAGADO',
                    'cancelado', 'Cancelado', 'CANCELADO',
                    'pagada', 'Pagada', 'PAGADA',
                ]);
            
            if ($proveedorFiltro != 0 && $proveedorFiltro != '0') {
                $query->where('g.proveedor_id', $proveedorFiltro);
            }
            
            foreach ($query->get() as $gasto) {
                $saldo = floatval($gasto->monto);
                if ($saldo <= 0) continue;
                
                $fechaVenc = $gasto->fecha
                    ? Carbon::parse($gasto->fecha)->addDays(30)
                    : null;
                
                $rangos = $this->calcularRango($fechaVenc, $today, $saldo);
                
                $this->agregarDocumento(
                    $cuentasPorProveedor, $totales,
                    $gasto->proveedor_id,
                    $gasto->proveedor_nombre ?? 'SIN PROVEEDOR',
                    $gasto->proveedor_rfc ?? 'N/A',
                    [
                        'pago_id' => 'GI-' . $gasto->id,
                        'folio' => $gasto->folio ?? ('GI-' . $gasto->id),
                        'fecha_pago' => $gasto->fecha
                            ? Carbon::parse($gasto->fecha)->format('d/m/Y')
                            : 'Sin fecha',
                        'fecha_vencimiento' => $rangos['fecha_vencimiento'],
                        'texto_dias' => $rangos['texto_dias'],
                        'saldo_pendiente' => $saldo,
                        'corriente' => $rangos['corriente'],
                        'rango_1_30' => $rangos['1_30'],
                        'rango_31_60' => $rangos['31_60'],
                        'rango_61_90' => $rangos['61_90'],
                        'rango_91_120' => $rangos['91_120'],
                        'mas_120' => $rangos['mas_120'],
                        'concepto' => $gasto->concepto ?? 'Gasto indirecto',
                        'tipo' => 'gasto_indirecto',
                        'origen' => 'Gasto Indirecto',
                        'estatus' => $gasto->estatus,
                    ]
                );
            }
        } catch (\Exception $e) {
            \Log::error('CXP - gastos_indirectos: ' . $e->getMessage());
        }
    }
    
    private function agregarDocumento(
        array &$cuentas,
        array &$totales,
        $proveedorId,
        $proveedorNombre,
        $proveedorRfc,
        array $doc
    ): void {
        $key = $proveedorId ?: 'sin_proveedor';
        
        if (!isset($cuentas[$key])) {
            $cuentas[$key] = [
                'proveedor' => (object)[
                    'id' => $proveedorId,
                    'nombre' => $proveedorNombre,
                    'rfc' => $proveedorRfc,
                ],
                'pagos' => [],
                'rangos' => [
                    'corriente' => 0, '1_30' => 0, '31_60' => 0,
                    '61_90' => 0, '91_120' => 0, 'mas_120' => 0,
                ],
                'totales' => ['total' => 0],
            ];
        }
        
        $cuentas[$key]['pagos'][] = $doc;
        $cuentas[$key]['rangos']['corriente'] += $doc['corriente'];
        $cuentas[$key]['rangos']['1_30'] += $doc['rango_1_30'];
        $cuentas[$key]['rangos']['31_60'] += $doc['rango_31_60'];
        $cuentas[$key]['rangos']['61_90'] += $doc['rango_61_90'];
        $cuentas[$key]['rangos']['91_120'] += $doc['rango_91_120'];
        $cuentas[$key]['rangos']['mas_120'] += $doc['mas_120'];
        $cuentas[$key]['totales']['total'] += $doc['saldo_pendiente'];
        
        $totales['corriente'] += $doc['corriente'];
        $totales['de_1_a_30'] += $doc['rango_1_30'];
        $totales['de_31_a_60'] += $doc['rango_31_60'];
        $totales['de_61_a_90'] += $doc['rango_61_90'];
        $totales['de_91_a_120'] += $doc['rango_91_120'];
        $totales['mas_120'] += $doc['mas_120'];
        $totales['total_general'] += $doc['saldo_pendiente'];
    }
    
    private function calcularRango(?Carbon $fechaVenc, Carbon $today, float $saldo): array
    {
        $r = [
            'fecha_vencimiento' => null,
            'texto_dias' => 'Sin fecha',
            'corriente' => 0, '1_30' => 0, '31_60' => 0,
            '61_90' => 0, '91_120' => 0, 'mas_120' => 0,
        ];
        
        if (!$fechaVenc) {
            $r['corriente'] = $saldo;
            return $r;
        }
        
        $r['fecha_vencimiento'] = $fechaVenc->format('d/m/Y');
        
        if ($fechaVenc->isFuture() || $fechaVenc->isToday()) {
            $dias = $today->diffInDays($fechaVenc);
            $r['texto_dias'] = "Vence en {$dias} días";
            $r['corriente'] = $saldo;
        } else {
            $dias = $fechaVenc->diffInDays($today);
            $r['texto_dias'] = "Vencido hace {$dias} días";
            
            if ($dias <= 30) $r['1_30'] = $saldo;
            elseif ($dias <= 60) $r['31_60'] = $saldo;
            elseif ($dias <= 90) $r['61_90'] = $saldo;
            elseif ($dias <= 120) $r['91_120'] = $saldo;
            else $r['mas_120'] = $saldo;
        }
        
        return $r;
    }
    
    /**
     * Detalle de un documento (GF-, GP-, GI-)
     */
    public function getDetallePago($pagoId)
    {
        try {
            if (is_string($pagoId)) {
                if (str_starts_with($pagoId, 'GF-')) {
                    return $this->detalleGastoFijo(str_replace('GF-', '', $pagoId));
                }
                if (str_starts_with($pagoId, 'GP-')) {
                    return $this->detalleGastoProyecto(str_replace('GP-', '', $pagoId));
                }
                if (str_starts_with($pagoId, 'GI-')) {
                    return $this->detalleGastoIndirecto(str_replace('GI-', '', $pagoId));
                }
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Documento no reconocido: ' . $pagoId,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    private function detalleGastoFijo($id)
    {
        $g = DB::table('gastos_fijos as g')
            ->leftJoin('proveedores as p', 'g.proveedor_id', '=', 'p.id')
            ->select('g.*', 'p.nombre as proveedor_nombre_join', 'p.rfc as proveedor_rfc_join')
            ->where('g.gasto_fijo_id', $id)
            ->first();
        
        if (!$g) return response()->json(['success' => false, 'message' => 'Gasto fijo no encontrado']);
        
        return response()->json([
            'success' => true,
            'tipo' => 'gasto_fijo',
            'pago' => [
                'id' => $g->gasto_fijo_id,
                'folio' => 'GF-' . $g->gasto_fijo_id,
                'fecha_pago' => $g->fecha_inicio,
                'fecha_vencimiento' => $g->fecha_fin,
                'monto' => $g->importe,
                'subtotal' => $g->importe,
                'iva' => 0,
                'estatus' => $g->estatus,
                'concepto' => $g->descripcion,
                'moneda' => 'MXN',
                'periodicidad' => $g->periodicidad ?? 'N/A',
            ],
            'proveedor_nombre' => $g->proveedor_nombre_join,
            'proveedor_rfc' => $g->proveedor_rfc_join,
            'saldo_pendiente' => floatval($g->importe),
            'pagado' => 0,
            'pagos_aplicados' => [],
        ]);
    }
    
    private function detalleGastoProyecto($id)
    {
        $g = DB::table('gastos_proyecto as g')
            ->leftJoin('proveedores as p', 'g.proveedor_id', '=', 'p.id')
            ->select('g.*', 'p.nombre as proveedor_nombre_join', 'p.rfc as proveedor_rfc_join')
            ->where('g.id', $id)
            ->first();
        
        if (!$g) return response()->json(['success' => false, 'message' => 'Gasto proyecto no encontrado']);
        
        return response()->json([
            'success' => true,
            'tipo' => 'gasto_proyecto',
            'pago' => [
                'id' => $g->id,
                'folio' => $g->folio,
                'fecha_pago' => $g->fecha,
                'fecha_vencimiento' => null,
                'monto' => $g->monto,
                'subtotal' => $g->monto,
                'iva' => 0,
                'estatus' => $g->estatus,
                'concepto' => $g->notas ?? 'Gasto proyecto',
                'moneda' => 'MXN',
            ],
            'proveedor_nombre' => $g->proveedor_nombre_join,
            'proveedor_rfc' => $g->proveedor_rfc_join,
            'saldo_pendiente' => floatval($g->monto),
            'pagado' => 0,
            'pagos_aplicados' => [],
        ]);
    }
    
    private function detalleGastoIndirecto($id)
    {
        $g = DB::table('gastos_indirectos as g')
            ->leftJoin('proveedores as p', 'g.proveedor_id', '=', 'p.id')
            ->select('g.*', 'p.nombre as proveedor_nombre_join', 'p.rfc as proveedor_rfc_join')
            ->where('g.id', $id)
            ->first();
        
        if (!$g) return response()->json(['success' => false, 'message' => 'Gasto indirecto no encontrado']);
        
        return response()->json([
            'success' => true,
            'tipo' => 'gasto_indirecto',
            'pago' => [
                'id' => $g->id,
                'folio' => $g->folio,
                'fecha_pago' => $g->fecha,
                'fecha_vencimiento' => null,
                'monto' => $g->monto,
                'subtotal' => $g->monto,
                'iva' => 0,
                'estatus' => $g->estatus,
                'concepto' => $g->concepto ?? 'Gasto indirecto',
                'moneda' => 'MXN',
            ],
            'proveedor_nombre' => $g->proveedor_nombre_join,
            'proveedor_rfc' => $g->proveedor_rfc_join,
            'saldo_pendiente' => floatval($g->monto),
            'pagado' => 0,
            'pagos_aplicados' => [],
        ]);
    }
    
    public function test()
    {
        return response()->json([
            'gastos_fijos' => DB::table('gastos_fijos')->whereNull('deleted_at')->count(),
            'gastos_proyecto' => DB::table('gastos_proyecto')->whereNull('deleted_at')->count(),
            'gastos_indirectos' => DB::table('gastos_indirectos')->whereNull('deleted_at')->count(),
        ]);
    }
}