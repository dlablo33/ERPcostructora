<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\CodigoSat;

class EstadoResultadosController extends Controller
{
    public function index(Request $request)
    {
        $anio = $request->get('anio', Carbon::now()->year);
        $mes = $request->get('mes', Carbon::now()->month);
        
        // Obtener todos los proyectos activos
        $proyectos = DB::table('proyectos')
            ->select('id', 'nombre', 'codigo')
            ->whereNull('deleted_at')
            ->where('status', 'activo')
            ->orderBy('nombre')
            ->get();
        
        // Obtener proyectos seleccionados (manejando null)
        $proyectosSeleccionados = $request->get('proyectos', []);
        
        // Si es null, convertir a array vacío
        if ($proyectosSeleccionados === null) {
            $proyectosSeleccionados = [];
        }
        
        // Si es string, convertir a array
        if (is_string($proyectosSeleccionados) && !empty($proyectosSeleccionados)) {
            $proyectosSeleccionados = explode(',', $proyectosSeleccionados);
        }
        
        // Si no es array, asegurar que sea array
        if (!is_array($proyectosSeleccionados)) {
            $proyectosSeleccionados = [];
        }
        
        // Convertir a enteros
        $proyectosSeleccionados = array_map('intval', $proyectosSeleccionados);
        
        // Fechas del período
        $fechaInicio = Carbon::create($anio, $mes, 1)->startOfMonth();
        $fechaFin = Carbon::create($anio, $mes, 1)->endOfMonth();
        
        // ============================================================
        // INGRESOS POR PROYECTO Y CÓDIGO SAT
        // ============================================================
        $ingresosPorProyecto = DB::table('movimientos_bancarios as mb')
            ->join('codigos_sat as cs', 'mb.codigo_sat_id', '=', 'cs.id')
            ->select(
                'mb.proyecto_id',
                'cs.codigo_agrupador',
                'cs.nombre_cuenta',
                'cs.nivel',
                DB::raw('SUM(mb.monto) as total')
            )
            ->where('mb.tipo', 'ingreso')
            ->where('mb.status', 'aplicado')
            ->where('cs.tipo', 'I')
            ->whereBetween('mb.fecha', [$fechaInicio, $fechaFin])
            ->groupBy('mb.proyecto_id', 'cs.codigo_agrupador', 'cs.nombre_cuenta', 'cs.nivel')
            ->orderBy('cs.codigo_agrupador')
            ->get();
        
        // ============================================================
        // GASTOS POR PROYECTO Y CÓDIGO SAT
        // ============================================================
        $gastosPorProyecto = DB::table('movimientos_bancarios as mb')
            ->join('codigos_sat as cs', 'mb.codigo_sat_id', '=', 'cs.id')
            ->select(
                'mb.proyecto_id',
                'cs.codigo_agrupador',
                'cs.nombre_cuenta',
                'cs.nivel',
                DB::raw('SUM(mb.monto) as total')
            )
            ->where('mb.tipo', 'egreso')
            ->where('mb.status', 'aplicado')
            ->where('cs.tipo', 'G')
            ->whereBetween('mb.fecha', [$fechaInicio, $fechaFin])
            ->groupBy('mb.proyecto_id', 'cs.codigo_agrupador', 'cs.nombre_cuenta', 'cs.nivel')
            ->orderBy('cs.codigo_agrupador')
            ->get();
        
        // ============================================================
        // RESUMEN POR PROYECTO (TOTALES)
        // ============================================================
        $resumenProyectos = [];
        $ingresosSum = DB::table('movimientos_bancarios as mb')
            ->join('proyectos as p', 'mb.proyecto_id', '=', 'p.id')
            ->select('p.id', 'p.codigo', 'p.nombre', DB::raw('SUM(mb.monto) as total'))
            ->where('mb.tipo', 'ingreso')
            ->where('mb.status', 'aplicado')
            ->whereBetween('mb.fecha', [$fechaInicio, $fechaFin])
            ->groupBy('p.id', 'p.codigo', 'p.nombre')
            ->get();
        
        $gastosSum = DB::table('movimientos_bancarios as mb')
            ->join('proyectos as p', 'mb.proyecto_id', '=', 'p.id')
            ->select('p.id', DB::raw('SUM(mb.monto) as total'))
            ->where('mb.tipo', 'egreso')
            ->where('mb.status', 'aplicado')
            ->whereBetween('mb.fecha', [$fechaInicio, $fechaFin])
            ->groupBy('p.id')
            ->get()
            ->keyBy('id');
        
        foreach ($ingresosSum as $proy) {
            $gastosProy = isset($gastosSum[$proy->id]) ? $gastosSum[$proy->id]->total : 0;
            $utilidadProy = $proy->total - $gastosProy;
            $margenProy = $proy->total > 0 ? ($utilidadProy / $proy->total) * 100 : 0;
            
            $resumenProyectos[] = [
                'proyecto_id' => $proy->id,
                'codigo' => $proy->codigo,
                'nombre' => $proy->nombre,
                'ingresos' => $proy->total,
                'gastos' => $gastosProy,
                'utilidad' => $utilidadProy,
                'margen' => $margenProy
            ];
        }
        
        // Años disponibles
        $aniosDisponibles = $this->getAniosDisponibles();
        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
        
        return view('conta.estados.estados', compact(
            'ingresosPorProyecto',
            'gastosPorProyecto',
            'resumenProyectos',
            'proyectos',
            'proyectosSeleccionados',
            'anio',
            'mes',
            'aniosDisponibles',
            'meses'
        ));
    }
    
    private function getAniosDisponibles()
    {
        $anios = DB::table('movimientos_bancarios')
            ->select(DB::raw('DISTINCT EXTRACT(YEAR FROM fecha) as anio'))
            ->where('status', 'aplicado')
            ->whereNotNull('codigo_sat_id')
            ->pluck('anio')
            ->toArray();
        
        if (empty($anios)) {
            $anios = [date('Y')];
        }
        
        sort($anios);
        return $anios;
    }
    
    public function exportarExcel(Request $request)
    {
        $anio = $request->get('anio', Carbon::now()->year);
        $mes = $request->get('mes', Carbon::now()->month);
        $fechaInicio = Carbon::create($anio, $mes, 1)->startOfMonth();
        $fechaFin = Carbon::create($anio, $mes, 1)->endOfMonth();
        
        // Obtener proyectos seleccionados (manejando null)
        $proyectosSeleccionados = $request->get('proyectos', []);
        
        if ($proyectosSeleccionados === null) {
            $proyectosSeleccionados = [];
        }
        
        if (is_string($proyectosSeleccionados) && !empty($proyectosSeleccionados)) {
            $proyectosSeleccionados = explode(',', $proyectosSeleccionados);
        }
        
        if (!is_array($proyectosSeleccionados)) {
            $proyectosSeleccionados = [];
        }
        
        $proyectosSeleccionados = array_map('intval', $proyectosSeleccionados);
        
        $ingresos = DB::table('movimientos_bancarios as mb')
            ->join('codigos_sat as cs', 'mb.codigo_sat_id', '=', 'cs.id')
            ->select('cs.codigo_agrupador', 'cs.nombre_cuenta', DB::raw('SUM(mb.monto) as total'))
            ->where('mb.tipo', 'ingreso')
            ->where('mb.status', 'aplicado')
            ->where('cs.tipo', 'I')
            ->whereBetween('mb.fecha', [$fechaInicio, $fechaFin])
            ->when(!empty($proyectosSeleccionados), function($q) use ($proyectosSeleccionados) {
                return $q->whereIn('mb.proyecto_id', $proyectosSeleccionados);
            })
            ->groupBy('cs.codigo_agrupador', 'cs.nombre_cuenta')
            ->orderBy('cs.codigo_agrupador')
            ->get();
        
        $gastos = DB::table('movimientos_bancarios as mb')
            ->join('codigos_sat as cs', 'mb.codigo_sat_id', '=', 'cs.id')
            ->select('cs.codigo_agrupador', 'cs.nombre_cuenta', DB::raw('SUM(mb.monto) as total'))
            ->where('mb.tipo', 'egreso')
            ->where('mb.status', 'aplicado')
            ->where('cs.tipo', 'G')
            ->whereBetween('mb.fecha', [$fechaInicio, $fechaFin])
            ->when(!empty($proyectosSeleccionados), function($q) use ($proyectosSeleccionados) {
                return $q->whereIn('mb.proyecto_id', $proyectosSeleccionados);
            })
            ->groupBy('cs.codigo_agrupador', 'cs.nombre_cuenta')
            ->orderBy('cs.codigo_agrupador')
            ->get();
        
        $totalIngresos = $ingresos->sum('total');
        $totalGastos = $gastos->sum('total');
        $utilidadNeta = $totalIngresos - $totalGastos;
        
        $filename = "estado_resultados_{$anio}_{$mes}.csv";
        $handle = fopen('php://temp', 'w');
        fputs($handle, "\xEF\xBB\xBF");
        fputcsv($handle, ['ESTADO DE RESULTADOS']);
        fputcsv($handle, ["Período: " . Carbon::create($anio, $mes, 1)->format('F Y')]);
        fputcsv($handle, []);
        fputcsv($handle, ['INGRESOS', '', '']);
        fputcsv($handle, ['Código SAT', 'Cuenta', 'Monto']);
        
        foreach ($ingresos as $ingreso) {
            fputcsv($handle, [$ingreso->codigo_agrupador, $ingreso->nombre_cuenta, number_format($ingreso->total, 2)]);
        }
        fputcsv($handle, ['', 'TOTAL INGRESOS', number_format($totalIngresos, 2)]);
        fputcsv($handle, []);
        
        fputcsv($handle, ['GASTOS', '', '']);
        fputcsv($handle, ['Código SAT', 'Cuenta', 'Monto']);
        
        foreach ($gastos as $gasto) {
            fputcsv($handle, [$gasto->codigo_agrupador, $gasto->nombre_cuenta, number_format($gasto->total, 2)]);
        }
        fputcsv($handle, ['', 'TOTAL GASTOS', number_format($totalGastos, 2)]);
        fputcsv($handle, []);
        
        fputcsv($handle, ['RESULTADO DEL EJERCICIO', '', '']);
        fputcsv($handle, ['Utilidad (Pérdida) Neta', '', number_format($utilidadNeta, 2)]);
        fputcsv($handle, ['Margen de Utilidad', '', number_format($totalIngresos > 0 ? ($utilidadNeta / $totalIngresos) * 100 : 0, 2) . '%']);
        
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
        
        return response($csv, 200)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }
    
    public function exportarPdf(Request $request)
    {
        return redirect()->back()->with('info', 'Exportación a PDF en desarrollo');
    }
}