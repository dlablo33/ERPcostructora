<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CobranzaController extends Controller
{
    public function index(Request $request)
    {
        // Obtener valores de los filtros
        $fechaInicio = $request->input('fecha_inicio', '2025-01-01');  // Cambiado para ver datos
        $fechaFin = $request->input('fecha_fin', date('Y-m-d'));       // Hasta hoy
        $search = $request->input('search', '');
        
        // ============================================
        // DEBUG - Verificar si hay datos
        // ============================================
        $totalContrarecibos = DB::table('contrarecibos')->count();
        $totalRelaciones = DB::table('contrarecibo_facturas')->count();
        
        // ============================================
        // ESTADÍSTICAS GLOBALES
        // ============================================
        $estadisticas = DB::table('contrarecibos as c')
            ->join('contrarecibo_facturas as cf', 'c.contrarecibo_id', '=', 'cf.contrarecibo_id')
            ->whereBetween('c.fecha_pago', [$fechaInicio, $fechaFin])
            ->select(
                DB::raw('COALESCE(SUM(cf.monto_aplicado), 0) as cobranza_total'),
                DB::raw('COUNT(DISTINCT DATE(c.fecha_pago)) as dias_con_cobro'),
                DB::raw('COUNT(DISTINCT cf.factura_id) as facturas_cobradas')
            )
            ->first();
        
        // Si no hay estadísticas, crear objeto por defecto
        if (!$estadisticas) {
            $estadisticas = (object)['cobranza_total' => 0, 'dias_con_cobro' => 0, 'facturas_cobradas' => 0];
        }
        
        // Calcular promedio por día
        $promedioDia = 0;
        if ($estadisticas->dias_con_cobro > 0) {
            $promedioDia = $estadisticas->cobranza_total / $estadisticas->dias_con_cobro;
        }
        
        // ============================================
        // DÍAS CON COBRANZA (agrupados)
        // ============================================
        $dias = DB::table('contrarecibos as c')
            ->join('contrarecibo_facturas as cf', 'c.contrarecibo_id', '=', 'cf.contrarecibo_id')
            ->whereBetween('c.fecha_pago', [$fechaInicio, $fechaFin])
            ->groupBy(DB::raw('DATE(c.fecha_pago)'))
            ->select(
                DB::raw('DATE(c.fecha_pago) as fecha'),
                DB::raw('SUM(cf.monto_aplicado) as total_dia')
            )
            ->orderBy(DB::raw('DATE(c.fecha_pago)'), 'desc')
            ->get();
        
        // Aplicar búsqueda por cliente si existe
        if (!empty($search) && $dias->count() > 0) {
            $diasFiltrados = [];
            foreach ($dias as $dia) {
                $tieneCliente = DB::table('contrarecibos as c')
                    ->join('contrarecibo_facturas as cf', 'c.contrarecibo_id', '=', 'cf.contrarecibo_id')
                    ->join('contactos as cont', 'c.contacto_id', '=', 'cont.contacto_id')
                    ->whereDate('c.fecha_pago', $dia->fecha)
                    ->where('cont.razon_social', 'LIKE', "%{$search}%")
                    ->exists();
                
                if ($tieneCliente) {
                    $diasFiltrados[] = $dia;
                }
            }
            $dias = collect($diasFiltrados);
        }
        
        // ============================================
        // DETALLE POR DÍA
        // ============================================
        $detallePorDia = [];
        
        foreach ($dias as $dia) {
            $detalle = DB::table('contrarecibos as c')
                ->join('contrarecibo_facturas as cf', 'c.contrarecibo_id', '=', 'cf.contrarecibo_id')
                ->join('facturas as f', 'cf.factura_id', '=', 'f.factura_id')
                ->join('contactos as cont', 'c.contacto_id', '=', 'cont.contacto_id')
                ->whereDate('c.fecha_pago', $dia->fecha)
                ->select(
                    'c.folio as deposito',
                    'cont.razon_social as cliente',
                    'f.folio as factura',
                    'cf.monto_aplicado as monto_mxn',
                    'f.total as venta_mxn',
                    'f.factura_id'
                );
            
            if (!empty($search)) {
                $detalle->where('cont.razon_social', 'LIKE', "%{$search}%");
            }
            
            $detallePorDia[$dia->fecha] = $detalle->get();
        }
        
        // ============================================
        // TOTALES GLOBALES
        // ============================================
        $totalesGlobales = DB::table('contrarecibos as c')
            ->join('contrarecibo_facturas as cf', 'c.contrarecibo_id', '=', 'cf.contrarecibo_id')
            ->whereBetween('c.fecha_pago', [$fechaInicio, $fechaFin])
            ->select(DB::raw('COALESCE(SUM(cf.monto_aplicado), 0) as total_mxn'))
            ->first();
        
        if (!$totalesGlobales) {
            $totalesGlobales = (object)['total_mxn' => 0];
        }
        
        // ============================================
        // RETORNAR VISTA CON DEBUG
        // ============================================
        return view('conta.registros.auxiliar', [
            'estadisticas' => $estadisticas,
            'promedioDia' => $promedioDia,
            'dias' => $dias,
            'detallePorDia' => $detallePorDia,
            'totalesGlobales' => $totalesGlobales,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'search' => $search,
            'debug' => [
                'total_contrarecibos' => $totalContrarecibos,
                'total_relaciones' => $totalRelaciones,
                'dias_encontrados' => $dias->count(),
                'fecha_inicio_usada' => $fechaInicio,
                'fecha_fin_usada' => $fechaFin
            ]
        ]);
    }
    
    public function exportarExcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', '2025-01-01');
        $fechaFin = $request->input('fecha_fin', date('Y-m-d'));
        $search = $request->input('search', '');
        
        $query = DB::table('contrarecibos as c')
            ->join('contrarecibo_facturas as cf', 'c.contrarecibo_id', '=', 'cf.contrarecibo_id')
            ->join('facturas as f', 'cf.factura_id', '=', 'f.factura_id')
            ->join('contactos as cont', 'c.contacto_id', '=', 'cont.contacto_id')
            ->whereBetween('c.fecha_pago', [$fechaInicio, $fechaFin])
            ->select(
                'c.fecha_pago',
                'c.folio as deposito',
                'cont.razon_social as cliente',
                'f.folio as factura',
                'cf.monto_aplicado as monto_cobrado'
            )
            ->orderBy('c.fecha_pago', 'desc');
        
        if (!empty($search)) {
            $query->where('cont.razon_social', 'LIKE', "%{$search}%");
        }
        
        $movimientos = $query->get();
        
        $html = $this->generarExcel($movimientos);
        
        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="cobranza_' . date('Y-m-d') . '.xls"');
    }
    
    private function generarExcel($movimientos)
    {
        $total = $movimientos->sum('monto_cobrado');
        
        $html = '<html><head><meta charset="UTF-8"><title>Cobranza</title>
        <style>th{background:#083CAE;color:white;padding:8px;}td{padding:6px;border:1px solid #ddd;}</style>
        </head><body>
        <h2>Reporte de Cobranza</h2>
        <p>Generado: ' . date('d/m/Y H:i:s') . '</p>
        <table border="1"><thead><tr><th>Fecha</th><th>Depósito</th><th>Cliente</th><th>Factura</th><th>Monto</th></tr></thead><tbody>';
        
        foreach ($movimientos as $mov) {
            $html .= '<tr>
                <td>' . date('d/m/Y', strtotime($mov->fecha_pago)) . '</td>
                <td>' . e($mov->deposito) . '</td>
                <td>' . e($mov->cliente) . '</td>
                <td>' . e($mov->factura) . '</td>
                <td style="text-align:right">$' . number_format($mov->monto_cobrado, 2) . '</td>
            </tr>';
        }
        
        $html .= '</tbody><tfoot><tr><td colspan="4"><strong>TOTAL</strong></td>
        <td style="text-align:right"><strong>$' . number_format($total, 2) . '</strong></td></tr></tfoot></table></body></html>';
        
        return $html;
    }
    
    public function getDetalleDia(Request $request)
    {
        $fecha = $request->input('fecha');
        $search = $request->input('search', '');
        
        $query = DB::table('contrarecibos as c')
            ->join('contrarecibo_facturas as cf', 'c.contrarecibo_id', '=', 'cf.contrarecibo_id')
            ->join('facturas as f', 'cf.factura_id', '=', 'f.factura_id')
            ->join('contactos as cont', 'c.contacto_id', '=', 'cont.contacto_id')
            ->whereDate('c.fecha_pago', $fecha)
            ->select(
                'c.folio as deposito',
                'cont.razon_social as cliente',
                'f.folio as factura',
                'cf.monto_aplicado as monto_mxn',
                'f.total as venta_mxn'
            );
        
        if (!empty($search)) {
            $query->where('cont.razon_social', 'LIKE', "%{$search}%");
        }
        
        return response()->json(['success' => true, 'data' => $query->get()]);
    }
}