<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RetencionController extends Controller
{
    /**
     * Vista principal (para el blade)
     */
    public function vista()
    {
        return view('conta.fiscal.retenciones');
    }

    /**
     * Get retenciones data for the selected month and year (API)
     */
    public function getData(Request $request)
    {
        try {
            $mes = $request->input('mes', date('m'));
            $anio = $request->input('anio', date('Y'));
            
            // ============================================
            // 1. RETENCIONES ISR
            // ============================================
            $retencionesIsr = $this->getIsrRetenciones($mes, $anio);
            
            // ============================================
            // 2. RETENCIONES IVA
            // ============================================
            $retencionesIva = $this->getIvaRetenciones($mes, $anio);
            
            // ============================================
            // 3. ESTADÍSTICAS (Tarjetas resumen)
            // ============================================
            $estadisticas = $this->getEstadisticas($mes, $anio);
            
            // ============================================
            // 4. RESUMEN GENERAL
            // ============================================
            $resumenGeneral = $this->getResumenGeneral($mes, $anio);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'retenciones_isr' => $retencionesIsr,
                    'retenciones_iva' => $retencionesIva,
                    'estadisticas' => $estadisticas,
                    'resumen_general' => $resumenGeneral,
                    'mes' => $mes,
                    'anio' => $anio
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en RetencionController@getData: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar datos: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener retenciones de ISR (10% sobre honorarios, arrendamiento, servicios profesionales)
     */
    private function getIsrRetenciones($mes, $anio)
    {
        // Tipos de egreso que aplican para retención de ISR
        // Ajusta estos IDs según tus tipos_egreso
        $tiposIsr = [1, 2, 4, 5]; // Materiales, Mano de Obra, Subcontratos, Gastos Indirectos
        
        $pagos = DB::table('pagos')
            ->select(
                'proveedor_rfc as rfc',
                'proveedor_nombre as nombre',
                DB::raw('SUM(monto) as subtotal'),
                DB::raw('SUM(monto * 0.10) as isr_retenido')
            )
            ->whereRaw('EXTRACT(MONTH FROM fecha_pago) = ?', [$mes])
            ->whereRaw('EXTRACT(YEAR FROM fecha_pago) = ?', [$anio])
            ->where('estatus', 'completado')
            ->whereIn('tipo_egreso_id', $tiposIsr)
            ->whereNotNull('proveedor_rfc')
            ->groupBy('proveedor_rfc', 'proveedor_nombre')
            ->havingRaw('SUM(monto) > 0')
            ->orderBy('proveedor_nombre')
            ->get();
        
        // Enriquecer con datos de proveedores
        $proveedores = DB::table('proveedores')
            ->where('activo', true)
            ->get(['rfc', 'razon_social', 'nombre']);
        
        foreach ($pagos as $pago) {
            $proveedor = $proveedores->firstWhere('rfc', $pago->rfc);
            if ($proveedor) {
                $pago->razon_social = $proveedor->razon_social ?? $proveedor->nombre ?? $pago->nombre;
                $pago->codigo = $proveedor->id ?? null;
            } else {
                $pago->razon_social = $pago->nombre;
            }
        }
        
        return $pagos;
    }
    
    /**
     * Obtener retenciones de IVA (2/3 del IVA - 10.666% sobre el 16%)
     */
    private function getIvaRetenciones($mes, $anio)
    {
        // Para IVA, retenemos 2/3 del IVA (10.666% sobre el 16%)
        $pagos = DB::table('pagos')
            ->select(
                'proveedor_rfc as rfc',
                'proveedor_nombre as nombre',
                DB::raw('SUM(monto) as subtotal'),
                DB::raw('SUM(monto * 0.16) as iva_calculado'),
                DB::raw('SUM(monto * 0.16 * 0.6667) as iva_retenido')
            )
            ->whereRaw('EXTRACT(MONTH FROM fecha_pago) = ?', [$mes])
            ->whereRaw('EXTRACT(YEAR FROM fecha_pago) = ?', [$anio])
            ->where('estatus', 'completado')
            ->whereNotNull('proveedor_rfc')
            ->groupBy('proveedor_rfc', 'proveedor_nombre')
            ->havingRaw('SUM(monto) > 0')
            ->orderBy('proveedor_nombre')
            ->get();
        
        // Enriquecer con datos de proveedores
        $proveedores = DB::table('proveedores')
            ->where('activo', true)
            ->get(['rfc', 'razon_social', 'nombre']);
        
        foreach ($pagos as $pago) {
            $proveedor = $proveedores->firstWhere('rfc', $pago->rfc);
            if ($proveedor) {
                $pago->razon_social = $proveedor->razon_social ?? $proveedor->nombre ?? $pago->nombre;
                $pago->codigo = $proveedor->id ?? null;
            } else {
                $pago->razon_social = $pago->nombre;
            }
            
            $pago->tasa_formateada = '16%';
        }
        
        return $pagos;
    }
    
    /**
     * Obtener estadísticas para tarjetas resumen
     */
    private function getEstadisticas($mes, $anio)
    {
        // Total ISR retenido
        $tiposIsr = [1, 2, 4, 5];
        $totalIsr = DB::table('pagos')
            ->whereRaw('EXTRACT(MONTH FROM fecha_pago) = ?', [$mes])
            ->whereRaw('EXTRACT(YEAR FROM fecha_pago) = ?', [$anio])
            ->where('estatus', 'completado')
            ->whereIn('tipo_egreso_id', $tiposIsr)
            ->whereNotNull('proveedor_rfc')
            ->sum(DB::raw('monto * 0.10'));
        
        // Total IVA retenido
        $totalIva = DB::table('pagos')
            ->whereRaw('EXTRACT(MONTH FROM fecha_pago) = ?', [$mes])
            ->whereRaw('EXTRACT(YEAR FROM fecha_pago) = ?', [$anio])
            ->where('estatus', 'completado')
            ->whereNotNull('proveedor_rfc')
            ->sum(DB::raw('monto * 0.16 * 0.6667'));
        
        // Número de proveedores con retención
        $proveedoresIsr = DB::table('pagos')
            ->whereRaw('EXTRACT(MONTH FROM fecha_pago) = ?', [$mes])
            ->whereRaw('EXTRACT(YEAR FROM fecha_pago) = ?', [$anio])
            ->where('estatus', 'completado')
            ->whereIn('tipo_egreso_id', $tiposIsr)
            ->whereNotNull('proveedor_rfc')
            ->distinct('proveedor_rfc')
            ->count('proveedor_rfc');
        
        $proveedoresIva = DB::table('pagos')
            ->whereRaw('EXTRACT(MONTH FROM fecha_pago) = ?', [$mes])
            ->whereRaw('EXTRACT(YEAR FROM fecha_pago) = ?', [$anio])
            ->where('estatus', 'completado')
            ->whereNotNull('proveedor_rfc')
            ->distinct('proveedor_rfc')
            ->count('proveedor_rfc');
        
        // Total de operaciones (pagos)
        $totalOperaciones = DB::table('pagos')
            ->whereRaw('EXTRACT(MONTH FROM fecha_pago) = ?', [$mes])
            ->whereRaw('EXTRACT(YEAR FROM fecha_pago) = ?', [$anio])
            ->where('estatus', 'completado')
            ->count();
        
        return [
            'total_isr' => $totalIsr,
            'total_isr_formateado' => '$' . number_format($totalIsr, 2),
            'total_iva' => $totalIva,
            'total_iva_formateado' => '$' . number_format($totalIva, 2),
            'proveedores_isr' => $proveedoresIsr,
            'proveedores_iva' => $proveedoresIva,
            'total_proveedores' => max($proveedoresIsr, $proveedoresIva),
            'total_operaciones' => $totalOperaciones
        ];
    }
    
    /**
     * Obtener resumen general para la pestaña de resumen
     */
    private function getResumenGeneral($mes, $anio)
    {
        // ISR por tipo de concepto
        $isrPorConcepto = DB::table('pagos')
            ->join('tipos_egreso', 'pagos.tipo_egreso_id', '=', 'tipos_egreso.id')
            ->select(
                'tipos_egreso.nombre as concepto',
                DB::raw('SUM(pagos.monto) as base'),
                DB::raw('SUM(pagos.monto * 0.10) as retencion')
            )
            ->whereRaw('EXTRACT(MONTH FROM pagos.fecha_pago) = ?', [$mes])
            ->whereRaw('EXTRACT(YEAR FROM pagos.fecha_pago) = ?', [$anio])
            ->where('pagos.estatus', 'completado')
            ->whereIn('pagos.tipo_egreso_id', [1, 2, 4, 5])
            ->groupBy('tipos_egreso.nombre')
            ->get();
        
        // IVA general
        $ivaGeneral = DB::table('pagos')
            ->select(
                DB::raw('SUM(monto) as base'),
                DB::raw('SUM(monto * 0.16) as iva'),
                DB::raw('SUM(monto * 0.16 * 0.6667) as retencion')
            )
            ->whereRaw('EXTRACT(MONTH FROM fecha_pago) = ?', [$mes])
            ->whereRaw('EXTRACT(YEAR FROM fecha_pago) = ?', [$anio])
            ->where('estatus', 'completado')
            ->whereNotNull('proveedor_rfc')
            ->first();
        
        $totalBase = DB::table('pagos')
            ->whereRaw('EXTRACT(MONTH FROM fecha_pago) = ?', [$mes])
            ->whereRaw('EXTRACT(YEAR FROM fecha_pago) = ?', [$anio])
            ->where('estatus', 'completado')
            ->whereNotNull('proveedor_rfc')
            ->sum('monto');
        
        $totalIsr = DB::table('pagos')
            ->whereRaw('EXTRACT(MONTH FROM fecha_pago) = ?', [$mes])
            ->whereRaw('EXTRACT(YEAR FROM fecha_pago) = ?', [$anio])
            ->where('estatus', 'completado')
            ->whereIn('tipo_egreso_id', [1, 2, 4, 5])
            ->sum(DB::raw('monto * 0.10'));
        
        $totalIva = DB::table('pagos')
            ->whereRaw('EXTRACT(MONTH FROM fecha_pago) = ?', [$mes])
            ->whereRaw('EXTRACT(YEAR FROM fecha_pago) = ?', [$anio])
            ->where('estatus', 'completado')
            ->whereNotNull('proveedor_rfc')
            ->sum(DB::raw('monto * 0.16 * 0.6667'));
        
        $totalRetencion = $totalIsr + $totalIva;
        
        // Preparar IVA por tasa (solo una tasa por ahora)
        $ivaPorTasa = [];
        if ($ivaGeneral && $ivaGeneral->base > 0) {
            $ivaPorTasa[] = (object)[
                'tasa' => '16',
                'base' => $ivaGeneral->base,
                'iva' => $ivaGeneral->iva,
                'retencion' => $ivaGeneral->retencion
            ];
        }
        
        return [
            'isr_por_concepto' => $isrPorConcepto,
            'iva_por_tasa' => $ivaPorTasa,
            'total_base' => $totalBase,
            'total_base_formateado' => '$' . number_format($totalBase, 2),
            'total_isr' => $totalIsr,
            'total_isr_formateado' => '$' . number_format($totalIsr, 2),
            'total_iva' => $totalIva,
            'total_iva_formateado' => '$' . number_format($totalIva, 2),
            'total_retencion' => $totalRetencion,
            'total_retencion_formateado' => '$' . number_format($totalRetencion, 2)
        ];
    }
    
    /**
     * Exportar reporte a Excel
     */
    public function exportarExcel(Request $request)
    {
        try {
            $mes = $request->input('mes', date('m'));
            $anio = $request->input('anio', date('Y'));
            $mesNombre = $this->getMesNombre($mes);
            
            $retencionesIsr = $this->getIsrRetenciones($mes, $anio);
            $retencionesIva = $this->getIvaRetenciones($mes, $anio);
            $estadisticas = $this->getEstadisticas($mes, $anio);
            
            $html = $this->generarExcel($retencionesIsr, $retencionesIva, $estadisticas, $mesNombre, $anio);
            
            return response($html)
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename="retenciones_' . $anio . '_' . $mes . '.xls"');
                
        } catch (\Exception $e) {
            Log::error('Error en RetencionController@exportarExcel: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al exportar: ' . $e->getMessage()]);
        }
    }
    
    private function generarExcel($retencionesIsr, $retencionesIva, $estadisticas, $mesNombre, $anio)
    {
        $html = '<html><head><meta charset="UTF-8"><title>Retenciones ISR e IVA</title>
        <style>
            th { background-color: #083CAE; color: white; padding: 8px; border: 1px solid #ddd; }
            td { padding: 6px; border: 1px solid #ddd; }
            .text-right { text-align: right; }
            .text-center { text-align: center; }
        </style>
        </head><body>
        <h2>Retenciones - ISR e IVA</h2>
        <p>Período: ' . $mesNombre . ' ' . $anio . '</p>
        <p>Generado: ' . date('d/m/Y H:i:s') . '</p>
        
        <h3>Resumen</h3>
        <table border="1">
            <thead><tr><th>Concepto</th><th>Monto</th></tr></thead>
            <tbody>
                <tr><td>Total ISR Retenido</td><td class="text-right">' . ($estadisticas['total_isr_formateado'] ?? '$0.00') . '</td></tr>
                <tr><td>Total IVA Retenido</td><td class="text-right">' . ($estadisticas['total_iva_formateado'] ?? '$0.00') . '</td></tr>
                <tr><td>Proveedores con Retención</td><td class="text-right">' . ($estadisticas['total_proveedores'] ?? 0) . '</td></tr>
                <tr><td>Total Operaciones</td><td class="text-right">' . ($estadisticas['total_operaciones'] ?? 0) . '</td></tr>
            </tbody>
        </table>
        
        <h3>Retenciones ISR</h3>
        <table border="1">
            <thead><tr><th>Proveedor</th><th>RFC</th><th>Subtotal</th><th>ISR Retenido (10%)</th></tr></thead>
            <tbody>';
        
        foreach ($retencionesIsr as $r) {
            $html .= '<tr>
                <td>' . e($r->razon_social ?? $r->nombre) . '</td>
                <td>' . e($r->rfc) . '</td>
                <td class="text-right">$' . number_format($r->subtotal, 2) . '</td>
                <td class="text-right">$' . number_format($r->isr_retenido, 2) . '</td>
            </tr>';
        }
        
        $html .= '</tbody></table>
        
        <h3>Retenciones IVA</h3>
        <table border="1">
            <thead><tr><th>Proveedor</th><th>RFC</th><th>Subtotal</th><th>Tasa</th><th>IVA Retenido</th></tr></thead>
            <tbody>';
        
        foreach ($retencionesIva as $r) {
            $html .= '<tr>
                <td>' . e($r->razon_social ?? $r->nombre) . '</td>
                <td>' . e($r->rfc) . '</td>
                <td class="text-right">$' . number_format($r->subtotal, 2) . '</td>
                <td class="text-center">16%</td>
                <td class="text-right">$' . number_format($r->iva_retenido, 2) . '</td>
            </tr>';
        }
        
        $html .= '</tbody></table>
        </body></html>';
        
        return $html;
    }
    
    private function getMesNombre($mes)
    {
        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
        return $meses[(int)$mes] ?? 'Desconocido';
    }
    
    /**
     * Test endpoint
     */
    public function test()
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'API Retenciones funcionando correctamente',
                'timestamp' => now()->toDateTimeString()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}