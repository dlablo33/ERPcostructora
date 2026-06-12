<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CostoObraController extends Controller
{
    /**
     * Display costos por obra.
     */
    public function index(Request $request)
    {
        // Obtener valores de los filtros
        $proyectoId = $request->input('proyecto_id', '');
        $fechaInicio = $request->input('fecha_inicio', date('Y-01-01'));
        $fechaFin = $request->input('fecha_fin', date('Y-m-t'));
        
        // ============================================
        // OBTENER LISTA DE OBRAS (PROYECTOS DE CONSTRUCCIÓN/INFRAESTRUCTURA)
        // ============================================
        $obras = DB::table('proyectos')
            ->select('id', 'codigo', 'nombre', 'cliente_nombre', 'presupuesto_total')
            ->whereNull('deleted_at')
            ->where('presupuesto_total', '>', 0)
            ->where(function($q) {
                $q->where('tipo_proyecto', 'LIKE', '%Construcci%')
                  ->orWhere('tipo_proyecto', 'LIKE', '%Infraestructura%')
                  ->orWhere('tipo_proyecto', 'LIKE', '%Obra%')
                  ->orWhere('tipo_proyecto', 'LIKE', '%Industrial%')
                  ->orWhere('tipo_proyecto', 'LIKE', '%Salud%')
                  ->orWhere('tipo_proyecto', 'LIKE', '%Comercial%')
                  ->orWhere('tipo_proyecto', 'LIKE', '%construccion%')
                  ->orWhere('tipo_proyecto', 'LIKE', '%puente%')
                  ->orWhere('tipo_proyecto', 'LIKE', '%edificio%');
            })
            ->orderBy('codigo')
            ->get();
        
        // Si no hay obra seleccionada y hay obras, tomar la primera
        if (empty($proyectoId) && $obras->isNotEmpty()) {
            $proyectoId = $obras->first()->id;
        }
        
        // ============================================
        // OBTENER DATOS DE LA OBRA SELECCIONADA
        // ============================================
        $obraSeleccionada = null;
        $presupuestoOriginal = 0;
        $avanceFisico = 0;
        
        if (!empty($proyectoId)) {
            $obraSeleccionada = DB::table('proyectos')
                ->select('id', 'codigo', 'nombre', 'cliente_nombre', 'presupuesto_total', 'estado')
                ->where('id', $proyectoId)
                ->first();
            
            if ($obraSeleccionada) {
                $presupuestoOriginal = $obraSeleccionada->presupuesto_total ?? 0;
                
                // Calcular avance físico basado en ejercido vs presupuesto
                $ejercidoTotal = DB::table('polizas_contables as pc')
                    ->join('movimientos_poliza as mp', 'pc.poliza_contable_id', '=', 'mp.poliza_contable_id')
                    ->where('pc.proyecto_id', $proyectoId)
                    ->whereNull('pc.deleted_at')
                    ->sum('mp.debe');
                
                $avanceFisico = $presupuestoOriginal > 0 
                    ? round(($ejercidoTotal / $presupuestoOriginal) * 100, 1)
                    : 0;
            }
        }
        
        // ============================================
        // COSTOS (Cuadros resumen)
        // ============================================
        $costos = DB::table('proyecto_costos')
            ->select(
                'materiales',
                'mano_obra',
                'maquinaria',
                'gastos_indirectos',
                'subcontratos'
            )
            ->where('proyecto_id', $proyectoId)
            ->first();
        
        $costoDirecto = ($costos->materiales ?? 0) + ($costos->mano_obra ?? 0) + ($costos->maquinaria ?? 0);
        $indirectos = ($costos->gastos_indirectos ?? 0) + ($costos->subcontratos ?? 0);
        
        // Costo real (ejercido en el período)
        $costoReal = DB::table('polizas_contables as pc')
            ->join('movimientos_poliza as mp', 'pc.poliza_contable_id', '=', 'mp.poliza_contable_id')
            ->where('pc.proyecto_id', $proyectoId)
            ->whereNull('pc.deleted_at')
            ->whereBetween('pc.fecha', [$fechaInicio, $fechaFin])
            ->sum('mp.debe');
        
        $variacion = $costoDirecto - $costoReal;
        $variacionPrefijo = $variacion >= 0 ? '+' : '-';
        
        // ============================================
        // TABLA APU (Conceptos de obra)
        // ============================================
        $conceptos = DB::table('proyecto_partidas')
            ->select(
                'id',
                'codigo',
                'nombre as concepto',
                'unidad',
                'cantidad',
                'precio_unitario as pu',
                'importe'
            )
            ->where('proyecto_id', $proyectoId)
            ->where('activa', true)
            ->orderBy('orden', 'asc')
            ->orderBy('codigo', 'asc')
            ->get();
        
        foreach ($conceptos as $concepto) {
            $concepto->importe_formateado = '$' . number_format($concepto->importe, 2);
            $concepto->pu_formateado = '$' . number_format($concepto->pu, 2);
            $concepto->cantidad_formateada = number_format($concepto->cantidad, 2);
        }
        
        $totalCostoDirecto = $conceptos->sum('importe');
        
        // ============================================
        // TABLA DE INSUMOS (Explosión)
        // ============================================
        $insumos = collect();
        
        // Intentar obtener insumos si existe la relación
        if (DB::getSchemaBuilder()->hasTable('proyecto_partida_insumos')) {
            $insumos = DB::table('proyecto_partida_insumos as ppi')
                ->join('proyecto_partidas as pp', 'ppi.partida_id', '=', 'pp.id')
                ->join('articulos as a', 'ppi.articulo_id', '=', 'a.id')
                ->leftJoin('movimientos_inventario as mi', function($join) use ($proyectoId, $fechaInicio, $fechaFin) {
                    $join->on('a.id', '=', 'mi.articulo_id')
                         ->where('mi.proyecto_id', $proyectoId)
                         ->where('mi.tipo_movimiento', 'salida')
                         ->whereBetween('mi.fecha_movimiento', [$fechaInicio, $fechaFin]);
                })
                ->where('pp.proyecto_id', $proyectoId)
                ->select(
                    'a.codigo',
                    'a.descripcion as insumo',
                    'a.unidad_medida as unidad',
                    DB::raw('SUM(ppi.cantidad) as cantidad_presupuestada'),
                    DB::raw('COALESCE(SUM(mi.cantidad), 0) as cantidad_real')
                )
                ->groupBy('a.id', 'a.codigo', 'a.descripcion', 'a.unidad_medida')
                ->get();
            
            foreach ($insumos as $insumo) {
                $insumo->variacion = $insumo->cantidad_real - $insumo->cantidad_presupuestada;
                $insumo->variacion_clase = $insumo->variacion <= 0 ? 'text-success' : 'text-danger';
                $insumo->variacion_formateada = ($insumo->variacion >= 0 ? '+' : '') . number_format($insumo->variacion, 2);
                $insumo->cantidad_presupuestada_formateada = number_format($insumo->cantidad_presupuestada, 2);
                $insumo->cantidad_real_formateada = number_format($insumo->cantidad_real, 2);
            }
        }
        
        // ============================================
        // PROGRAMA DE SUMINISTROS
        // ============================================
        $programaSuministros = collect();
        
        if (!empty($request->input('programa_inicio')) && !empty($request->input('programa_fin'))) {
            if (DB::getSchemaBuilder()->hasTable('proyecto_partida_insumos')) {
                $programaSuministros = DB::table('proyecto_partida_insumos as ppi')
                    ->join('proyecto_partidas as pp', 'ppi.partida_id', '=', 'pp.id')
                    ->join('articulos as a', 'ppi.articulo_id', '=', 'a.id')
                    ->where('pp.proyecto_id', $proyectoId)
                    ->select(
                        'a.codigo',
                        'a.descripcion as insumo',
                        'a.unidad_medida as unidad',
                        DB::raw('SUM(ppi.cantidad) as cantidad_total')
                    )
                    ->groupBy('a.id', 'a.codigo', 'a.descripcion', 'a.unidad_medida')
                    ->orderBy('a.codigo')
                    ->get();
                
                foreach ($programaSuministros as $item) {
                    $item->cantidad_formateada = number_format($item->cantidad_total, 2);
                }
            }
        }
        
        // ============================================
        // RETORNAR VISTA
        // ============================================
        return view('conta.porproyecto.costo', [
            'obras' => $obras,
            'proyectoId' => $proyectoId,
            'obraSeleccionada' => $obraSeleccionada,
            'presupuestoOriginal' => $presupuestoOriginal,
            'avanceFisico' => $avanceFisico,
            'costoDirecto' => $costoDirecto,
            'indirectos' => $indirectos,
            'costoReal' => $costoReal,
            'variacion' => $variacion,
            'variacionPrefijo' => $variacionPrefijo,
            'conceptos' => $conceptos,
            'totalCostoDirecto' => $totalCostoDirecto,
            'insumos' => $insumos,
            'programaSuministros' => $programaSuministros,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin
        ]);
    }
    
    /**
     * Exportar a Excel
     */
    public function exportarExcel(Request $request)
    {
        $proyectoId = $request->input('proyecto_id', '');
        $fechaInicio = $request->input('fecha_inicio', date('Y-01-01'));
        $fechaFin = $request->input('fecha_fin', date('Y-m-t'));
        
        $obra = DB::table('proyectos')->select('codigo', 'nombre')->where('id', $proyectoId)->first();
        
        $conceptos = DB::table('proyecto_partidas')
            ->select('codigo', 'nombre as concepto', 'unidad', 'cantidad', 'precio_unitario as pu', 'importe')
            ->where('proyecto_id', $proyectoId)
            ->where('activa', true)
            ->orderBy('orden', 'asc')
            ->get();
        
        $html = $this->generarExcel($obra, $conceptos, $fechaInicio, $fechaFin);
        
        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="costos_obra_' . ($obra->codigo ?? 'reporte') . '_' . date('Y-m-d') . '.xls"');
    }
    
    private function generarExcel($obra, $conceptos, $fechaInicio, $fechaFin)
    {
        $total = $conceptos->sum('importe');
        
        $html = '<html>
        <head>
            <meta charset="UTF-8">
            <title>Costos por Obra</title>
            <style>
                th { background-color: #083CAE; color: white; padding: 8px; border: 1px solid #ddd; }
                td { padding: 6px; border: 1px solid #ddd; }
                .text-right { text-align: right; }
            </style>
        </head>
        <body>
            <h2>Costos por Obra</h2>
            <h3>Obra: ' . e($obra->codigo ?? '-') . ' - ' . e($obra->nombre ?? '-') . '</h3>
            <p>Período: ' . date('d/m/Y', strtotime($fechaInicio)) . ' al ' . date('d/m/Y', strtotime($fechaFin)) . '</p>
            <br>
            <h4>Análisis de Precios Unitarios</h4>
            <table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Concepto</th>
                        <th>Unidad</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Importe</th>
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($conceptos as $c) {
            $html .= '<tr>
                <td>' . e($c->codigo) . '</td>
                <td>' . e($c->concepto) . '</td>
                <td>' . e($c->unidad) . '</td>
                <td class="text-right">' . number_format($c->cantidad, 2) . '</td>
                <td class="text-right">$' . number_format($c->pu, 2) . '</td>
                <td class="text-right">$' . number_format($c->importe, 2) . '</td>
            </tr>';
        }
        
        $html .= '</tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right"><strong>TOTAL</strong></td>
                        <td class="text-right"><strong>$' . number_format($total, 2) . '</strong></td>
                    </tr>
                </tfoot>
            </table>
        </body>
        </html>';
        
        return $html;
    }
}