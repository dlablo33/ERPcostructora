<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProyectoDashboardController extends Controller
{
    public function index(Request $request)
    {
        $filtroTipo = $request->input('tipo', '');
        $filtroEstado = $request->input('estado', '');
        $filtroResponsable = $request->input('responsable', '');
        $search = $request->input('search', '');
        
        // ============================================
        // ESTADÍSTICAS GLOBALES
        // ============================================
        $estadisticas = DB::table('proyectos')
            ->whereNull('deleted_at')
            ->select(
                DB::raw('COUNT(*) as total_centros'),
                DB::raw("COUNT(CASE WHEN status = 'activo' THEN 1 END) as centros_activos"),
                DB::raw("COUNT(CASE WHEN status != 'activo' THEN 1 END) as centros_inactivos"),
                DB::raw('COALESCE(SUM(presupuesto_total), 0) as presupuesto_total')
            )
            ->first();
        
        // ============================================
        // OPCIONES PARA FILTROS
        // ============================================
        $tiposProyecto = DB::table('proyectos')
            ->whereNull('deleted_at')
            ->whereNotNull('tipo_proyecto')
            ->select('tipo_proyecto')
            ->distinct()
            ->pluck('tipo_proyecto');
        
        $estadosDisponibles = DB::table('proyectos')
            ->whereNull('deleted_at')
            ->select('status')
            ->distinct()
            ->pluck('status');
        
        $responsables = DB::table('proyectos')
            ->whereNull('deleted_at')
            ->whereNotNull('responsable_id')
            ->select('responsable_id')
            ->distinct()
            ->get();
        
        $responsablesList = collect();
        foreach ($responsables as $resp) {
            $user = DB::table('users')->where('id', $resp->responsable_id)->first();
            if ($user) {
                $responsablesList->push((object)[
                    'id' => $resp->responsable_id,
                    'nombre' => $user->name
                ]);
            } else {
                $plantilla = DB::table('plantillas')->where('plantilla_id', $resp->responsable_id)->first();
                if ($plantilla) {
                    $nombre = trim($plantilla->nombre . ' ' . ($plantilla->apellido_paterno ?? ''));
                    $responsablesList->push((object)[
                        'id' => $resp->responsable_id,
                        'nombre' => $nombre
                    ]);
                }
            }
        }
        
        // ============================================
        // LISTA DE PROYECTOS
        // ============================================
        $query = DB::table('proyectos as p')
            ->leftJoin('polizas_contables as pc', 'p.id', '=', 'pc.proyecto_id')
            ->leftJoin('movimientos_poliza as mp', 'pc.poliza_contable_id', '=', 'mp.poliza_contable_id')
            ->whereNull('p.deleted_at')
            ->select(
                'p.id',
                'p.codigo',
                'p.nombre',
                'p.tipo_proyecto as tipo',
                'p.responsable_id',
                'p.presupuesto_total',
                'p.status as estado',
                DB::raw('COALESCE(SUM(mp.debe), 0) as ejercido')
            )
            ->groupBy('p.id', 'p.codigo', 'p.nombre', 'p.tipo_proyecto', 'p.responsable_id', 'p.presupuesto_total', 'p.status');
        
        if (!empty($filtroTipo)) {
            $query->where('p.tipo_proyecto', $filtroTipo);
        }
        
        if (!empty($filtroEstado)) {
            $query->where('p.status', $filtroEstado);
        }
        
        if (!empty($filtroResponsable)) {
            $query->where('p.responsable_id', $filtroResponsable);
        }
        
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('p.codigo', 'LIKE', "%{$search}%")
                  ->orWhere('p.nombre', 'LIKE', "%{$search}%");
            });
        }
        
        $proyectos = $query->orderBy('p.codigo')->get();
        
        foreach ($proyectos as $proyecto) {
            $proyecto->disponible = $proyecto->presupuesto_total - $proyecto->ejercido;
            $proyecto->porcentaje = $proyecto->presupuesto_total > 0 
                ? round(($proyecto->ejercido / $proyecto->presupuesto_total) * 100, 2)
                : 0;
            
            $proyecto->presupuesto_formateado = '$' . number_format($proyecto->presupuesto_total, 2);
            $proyecto->ejercido_formateado = '$' . number_format($proyecto->ejercido, 2);
            $proyecto->disponible_formateado = '$' . number_format($proyecto->disponible, 2);
            
            $responsable = DB::table('users')->where('id', $proyecto->responsable_id)->first();
            if ($responsable) {
                $proyecto->responsable_nombre = $responsable->name;
            } else {
                $plantilla = DB::table('plantillas')->where('plantilla_id', $proyecto->responsable_id)->first();
                if ($plantilla) {
                    $proyecto->responsable_nombre = trim($plantilla->nombre . ' ' . ($plantilla->apellido_paterno ?? ''));
                } else {
                    $proyecto->responsable_nombre = 'No asignado';
                }
            }
            
            $proyecto->badge_class = $proyecto->estado == 'activo' ? 'badge-activo' : 'badge-inactivo';
            
            if ($proyecto->porcentaje >= 80) {
                $proyecto->barra_color = '#dc3545';
            } elseif ($proyecto->porcentaje >= 50) {
                $proyecto->barra_color = '#ffc107';
            } else {
                $proyecto->barra_color = '#28a745';
            }
        }
        
        // ============================================
        // VISTA JERÁRQUICA
        // ============================================
        $jerarquia = DB::table('proyectos')
            ->whereNull('deleted_at')
            ->select(
                'tipo_proyecto',
                DB::raw('COUNT(*) as cantidad'),
                DB::raw('COALESCE(SUM(presupuesto_total), 0) as presupuesto')
            )
            ->groupBy('tipo_proyecto')
            ->orderBy('tipo_proyecto')
            ->get();
        
        foreach ($jerarquia as $grupo) {
            $grupo->proyectos = DB::table('proyectos')
                ->whereNull('deleted_at')
                ->where('tipo_proyecto', $grupo->tipo_proyecto)
                ->select('codigo', 'nombre', 'presupuesto_total')
                ->orderBy('codigo')
                ->get();
            
            foreach ($grupo->proyectos as $proy) {
                $proy->presupuesto_formateado = '$' . number_format($proy->presupuesto_total, 2);
            }
            
            $grupo->presupuesto_formateado = '$' . number_format($grupo->presupuesto, 2);
        }
        
        // ============================================
        // VISTA DE PRESUPUESTOS
        // ============================================
        $distribucionTipos = DB::table('proyectos')
            ->whereNull('deleted_at')
            ->select(
                'tipo_proyecto',
                DB::raw('COUNT(*) as cantidad'),
                DB::raw('COALESCE(SUM(presupuesto_total), 0) as total')
            )
            ->groupBy('tipo_proyecto')
            ->get();
        
        $totalPresupuestoGeneral = $distribucionTipos->sum('total');
        
        foreach ($distribucionTipos as $tipo) {
            $tipo->porcentaje = $totalPresupuestoGeneral > 0 
                ? round(($tipo->total / $totalPresupuestoGeneral) * 100, 1) 
                : 0;
            $tipo->total_formateado = '$' . number_format($tipo->total, 2);
        }
        
        // ============================================
        // TOP 5 CENTROS (CORREGIDO - INCLUYE ID)
        // ============================================
        $topCentros = DB::table('proyectos')
            ->whereNull('deleted_at')
            ->select('id', 'codigo', 'nombre', 'presupuesto_total')
            ->orderBy('presupuesto_total', 'desc')
            ->limit(5)
            ->get();
        
        foreach ($topCentros as $centro) {
            $centro->presupuesto_formateado = '$' . number_format($centro->presupuesto_total, 2);
            
            $ejercido = DB::table('polizas_contables as pc')
                ->join('movimientos_poliza as mp', 'pc.poliza_contable_id', '=', 'mp.poliza_contable_id')
                ->where('pc.proyecto_id', $centro->id)
                ->sum('mp.debe');
            
            $centro->ejercido = $ejercido;
            $centro->ejercido_formateado = '$' . number_format($ejercido, 2);
            $centro->porcentaje = $centro->presupuesto_total > 0 
                ? round(($ejercido / $centro->presupuesto_total) * 100, 1) 
                : 0;
        }
        
        // ============================================
        // ÚLTIMOS MOVIMIENTOS
        // ============================================
        $ultimosMovimientos = DB::table('polizas_contables as pc')
            ->join('movimientos_poliza as mp', 'pc.poliza_contable_id', '=', 'mp.poliza_contable_id')
            ->join('proyectos as p', 'pc.proyecto_id', '=', 'p.id')
            ->where('mp.debe', '>', 0)
            ->whereNull('pc.deleted_at')
            ->select(
                'pc.fecha',
                'p.codigo as centro_codigo',
                'p.nombre as centro_nombre',
                'mp.descripcion as concepto',
                'mp.debe as monto'
            )
            ->orderBy('pc.fecha', 'desc')
            ->limit(10)
            ->get();
        
        foreach ($ultimosMovimientos as $mov) {
            $mov->monto_formateado = '$' . number_format($mov->monto, 2);
            $mov->fecha_formateada = $mov->fecha ? date('d/m/Y', strtotime($mov->fecha)) : '-';
        }
        
        // ============================================
        // TOTALES GENERALES
        // ============================================
        $totalEjercido = DB::table('polizas_contables as pc')
            ->join('movimientos_poliza as mp', 'pc.poliza_contable_id', '=', 'mp.poliza_contable_id')
            ->join('proyectos as p', 'pc.proyecto_id', '=', 'p.id')
            ->whereNull('pc.deleted_at')
            ->sum('mp.debe');
        
        $totalDisponible = ($estadisticas->presupuesto_total ?? 0) - $totalEjercido;
        
        // ============================================
        // RETORNAR VISTA
        // ============================================
        return view('conta.catalogo.centros', [
            'estadisticas' => $estadisticas,
            'tiposProyecto' => $tiposProyecto,
            'estadosDisponibles' => $estadosDisponibles,
            'responsablesList' => $responsablesList,
            'proyectos' => $proyectos,
            'jerarquia' => $jerarquia,
            'distribucionTipos' => $distribucionTipos,
            'topCentros' => $topCentros,
            'ultimosMovimientos' => $ultimosMovimientos,
            'totalPresupuestoGeneral' => $totalPresupuestoGeneral,
            'totalEjercido' => $totalEjercido,
            'totalDisponible' => $totalDisponible,
            'filtroTipo' => $filtroTipo,
            'filtroEstado' => $filtroEstado,
            'filtroResponsable' => $filtroResponsable,
            'search' => $search
        ]);
    }
    
    public function exportarExcel(Request $request)
    {
        $filtroTipo = $request->input('tipo', '');
        $filtroEstado = $request->input('estado', '');
        $search = $request->input('search', '');
        
        $query = DB::table('proyectos as p')
            ->leftJoin('polizas_contables as pc', 'p.id', '=', 'pc.proyecto_id')
            ->leftJoin('movimientos_poliza as mp', 'pc.poliza_contable_id', '=', 'mp.poliza_contable_id')
            ->whereNull('p.deleted_at')
            ->select(
                'p.codigo',
                'p.nombre',
                'p.tipo_proyecto as tipo',
                'p.status as estado',
                'p.presupuesto_total',
                DB::raw('COALESCE(SUM(mp.debe), 0) as ejercido')
            )
            ->groupBy('p.codigo', 'p.nombre', 'p.tipo_proyecto', 'p.status', 'p.presupuesto_total');
        
        if (!empty($filtroTipo)) {
            $query->where('p.tipo_proyecto', $filtroTipo);
        }
        
        if (!empty($filtroEstado)) {
            $query->where('p.status', $filtroEstado);
        }
        
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('p.codigo', 'LIKE', "%{$search}%")
                  ->orWhere('p.nombre', 'LIKE', "%{$search}%");
            });
        }
        
        $proyectos = $query->orderBy('p.codigo')->get();
        
        foreach ($proyectos as $proyecto) {
            $proyecto->disponible = $proyecto->presupuesto_total - $proyecto->ejercido;
            $proyecto->porcentaje = $proyecto->presupuesto_total > 0 
                ? round(($proyecto->ejercido / $proyecto->presupuesto_total) * 100, 2)
                : 0;
        }
        
        $html = $this->generarExcel($proyectos);
        
        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="centros_costos_' . date('Y-m-d') . '.xls"');
    }
    
    private function generarExcel($proyectos)
    {
        $totalPresupuesto = $proyectos->sum('presupuesto_total');
        $totalEjercido = $proyectos->sum('ejercido');
        $totalDisponible = $totalPresupuesto - $totalEjercido;
        
        $html = '<html>
        <head>
            <meta charset="UTF-8">
            <title>Centros de Costos</title>
            <style>
                th { background-color: #083CAE; color: white; padding: 8px; border: 1px solid #ddd; }
                td { padding: 6px; border: 1px solid #ddd; }
                .text-right { text-align: right; }
            </style>
        </head>
        <body>
            <h2>Centros de Costos - Proyectos</h2>
            <p>Generado el: ' . date('d/m/Y H:i:s') . '</p>
            <table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Presupuesto</th>
                        <th>Ejercido</th>
                        <th>Disponible</th>
                        <th>% Avance</th>
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($proyectos as $proy) {
            $html .= '<tr>
                <td>' . e($proy->codigo) . '</td>
                <td>' . e($proy->nombre) . '</td>
                <td>' . e($proy->tipo ?? '-') . '</td>
                <td>' . e($proy->estado ?? '-') . '</td>
                <td class="text-right">$' . number_format($proy->presupuesto_total, 2) . '</td>
                <td class="text-right">$' . number_format($proy->ejercido, 2) . '</td>
                <td class="text-right">$' . number_format($proy->disponible, 2) . '</td>
                <td class="text-right">' . $proy->porcentaje . '%</td>
            </tr>';
        }
        
        $html .= '</tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"><strong>TOTALES</strong></td>
                        <td class="text-right"><strong>$' . number_format($totalPresupuesto, 2) . '</strong></td>
                        <td class="text-right"><strong>$' . number_format($totalEjercido, 2) . '</strong></td>
                        <td class="text-right"><strong>$' . number_format($totalDisponible, 2) . '</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </body>
        </html>';
        
        return $html;
    }
}