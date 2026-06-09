<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BalanzaComprobacionController extends Controller
{
    public function index(Request $request)
    {
        $anio = $request->get('anio', Carbon::now()->year);
        $mes = $request->get('mes', Carbon::now()->month);
        
        $mes = (int)$mes;
        if ($mes < 1 || $mes > 12) {
            $mes = Carbon::now()->month;
        }
        
        $proyectosIds = $request->get('proyectos', '');
        $proyectosSeleccionados = [];
        
        if (!empty($proyectosIds)) {
            if (is_string($proyectosIds)) {
                $proyectosSeleccionados = explode(',', $proyectosIds);
            } elseif (is_array($proyectosIds)) {
                $proyectosSeleccionados = $proyectosIds;
            }
            $proyectosSeleccionados = array_filter($proyectosSeleccionados);
            $proyectosSeleccionados = array_map('intval', $proyectosSeleccionados);
        }
        
        $fechaInicio = Carbon::create($anio, 1, 1)->startOfDay();
        $fechaLimite = Carbon::create($anio, $mes, 1)->endOfMonth();
        
        // ============================================================
        // CONSULTA PRINCIPAL - Obtener todos los movimientos agrupados
        // ============================================================
        $movimientosQuery = DB::table('movimientos_bancarios as mb')
            ->join('codigos_sat as cs', 'mb.codigo_sat_id', '=', 'cs.id')
            ->select(
                'cs.codigo_agrupador',
                'cs.nombre_cuenta',
                'cs.nivel',
                'cs.tipo',
                DB::raw("SUM(CASE WHEN mb.tipo = 'ingreso' THEN mb.monto ELSE 0 END) as total_ingresos"),
                DB::raw("SUM(CASE WHEN mb.tipo = 'egreso' THEN mb.monto ELSE 0 END) as total_egresos")
            )
            ->where('mb.status', 'aplicado')
            ->whereBetween('mb.fecha', [$fechaInicio, $fechaLimite]);
        
        if (!empty($proyectosSeleccionados)) {
            $movimientosQuery->whereIn('mb.proyecto_id', $proyectosSeleccionados);
        }
        
        $movimientos = $movimientosQuery
            ->groupBy('cs.codigo_agrupador', 'cs.nombre_cuenta', 'cs.nivel', 'cs.tipo')
            ->orderBy('cs.codigo_agrupador')
            ->get();
        
        // ============================================================
        // PROCESAR DATOS - LÓGICA CORREGIDA
        // ============================================================
        $datosBalance = [];
        $totalIngresos = 0;
        $totalEgresos = 0;
        
        foreach ($movimientos as $mov) {
            $naturaleza = $this->getNaturalezaCuenta($mov->tipo);
            
            // Para cuentas DEUDORAS (Activo, Gastos): cargos = ingresos, abonos = egresos
            // Para cuentas ACREEDORAS (Pasivo, Capital, Ingresos): cargos = egresos, abonos = ingresos
            if ($naturaleza == 'Deudora') {
                $cargos = $mov->total_ingresos;
                $abonos = $mov->total_egresos;
                $saldo = $cargos - $abonos; // Saldo deudor positivo
            } else {
                $cargos = $mov->total_egresos;
                $abonos = $mov->total_ingresos;
                $saldo = $abonos - $cargos; // Saldo acreedor positivo
            }
            
            // Para mostrar en la tabla, los montos siempre positivos
            $cargosMostrar = abs($cargos);
            $abonosMostrar = abs($abonos);
            $saldoMostrar = abs($saldo);
            
            $totalIngresos += $cargosMostrar;
            $totalEgresos += $abonosMostrar;
            
            $datosBalance[] = [
                'codigo' => $mov->codigo_agrupador,
                'nombre' => $mov->nombre_cuenta,
                'naturaleza' => $naturaleza,
                'nivel' => $mov->nivel,
                'cargos' => $cargosMostrar,
                'abonos' => $abonosMostrar,
                'saldo' => $saldoMostrar,
                'tipo' => $mov->tipo
            ];
        }
        
        // ============================================================
        // AGRUPAR POR GRUPOS PRINCIPALES
        // ============================================================
        $grupos = [
            '100' => ['nombre' => 'ACTIVO', 'tipo' => 'A', 'cuentas' => [], 'total' => 0],
            '200' => ['nombre' => 'PASIVO', 'tipo' => 'P', 'cuentas' => [], 'total' => 0],
            '300' => ['nombre' => 'CAPITAL CONTABLE', 'tipo' => 'C', 'cuentas' => [], 'total' => 0],
            '400' => ['nombre' => 'INGRESOS NETOS', 'tipo' => 'I', 'cuentas' => [], 'total' => 0],
            '500' => ['nombre' => 'COSTOS Y GASTOS', 'tipo' => 'G', 'cuentas' => [], 'total' => 0],
            '800' => ['nombre' => 'CUENTAS DE ORDEN', 'tipo' => 'O', 'cuentas' => [], 'total' => 0],
        ];
        
        // Clasificar cada cuenta en su grupo
        foreach ($datosBalance as $cuenta) {
            $codigo = $cuenta['codigo'];
            
            if (strpos($codigo, '100') === 0 || $codigo === '100') {
                $grupos['100']['cuentas'][] = $cuenta;
                $grupos['100']['total'] += $cuenta['saldo'];
            } 
            elseif (strpos($codigo, '200') === 0 || $codigo === '200') {
                $grupos['200']['cuentas'][] = $cuenta;
                $grupos['200']['total'] += $cuenta['saldo'];
            }
            elseif (strpos($codigo, '300') === 0 || $codigo === '300') {
                $grupos['300']['cuentas'][] = $cuenta;
                $grupos['300']['total'] += $cuenta['saldo'];
            }
            elseif (strpos($codigo, '400') === 0 || $codigo === '400' || $cuenta['tipo'] == 'I') {
                $grupos['400']['cuentas'][] = $cuenta;
                $grupos['400']['total'] += $cuenta['saldo'];
            }
            elseif (strpos($codigo, '500') === 0 || $codigo === '500' || $cuenta['tipo'] == 'G') {
                $grupos['500']['cuentas'][] = $cuenta;
                $grupos['500']['total'] += $cuenta['saldo'];
            }
            elseif (strpos($codigo, '800') === 0 || $codigo === '800') {
                $grupos['800']['cuentas'][] = $cuenta;
                $grupos['800']['total'] += $cuenta['saldo'];
            }
        }
        
        // Ordenar cuentas dentro de cada grupo
        foreach ($grupos as &$grupo) {
            usort($grupo['cuentas'], function($a, $b) {
                return strcmp($a['codigo'], $b['codigo']);
            });
        }
        
        $totalActivo = $grupos['100']['total'];
        $totalPasivo = $grupos['200']['total'];
        $totalCapital = $grupos['300']['total'];
        $totalIngresosGrupo = $grupos['400']['total'];
        $totalGastosGrupo = $grupos['500']['total'];
        $utilidad = $totalIngresosGrupo - $totalGastosGrupo;
        
        // Ajustar capital con la utilidad
        $totalCapitalAjustado = $totalCapital + $utilidad;
        
        // ============================================================
        // AÑOS DISPONIBLES
        // ============================================================
        $aniosDisponibles = DB::table('movimientos_bancarios')
            ->select(DB::raw('DISTINCT EXTRACT(YEAR FROM fecha) as anio'))
            ->where('status', 'aplicado')
            ->whereNotNull('codigo_sat_id')
            ->orderBy('anio', 'desc')
            ->pluck('anio')
            ->map(function($item) { return (int) $item; })
            ->toArray();
        
        if (empty($aniosDisponibles)) {
            $aniosDisponibles = [date('Y')];
        }
        
        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
        
        // Proyectos para el filtro
        $proyectos = DB::table('proyectos')
            ->select('id', 'codigo', 'nombre')
            ->orderBy('codigo')
            ->get();
        
        // Log de diagnóstico
        \Log::info("========== BALANZA DE COMPROBACIÓN ==========");
        \Log::info("Período: {$meses[$mes]} {$anio}");
        \Log::info("Total Ingresos (Debe): " . $totalIngresos);
        \Log::info("Total Egresos (Haber): " . $totalEgresos);
        \Log::info("Utilidad: " . $utilidad);
        \Log::info("Total Activo: " . $totalActivo);
        \Log::info("Total Pasivo: " . $totalPasivo);
        \Log::info("Total Capital: " . $totalCapitalAjustado);
        \Log::info("============================================");
        
        return view('conta.estados.comprobacion', compact(
            'grupos',
            'totalActivo',
            'totalPasivo',
            'totalCapitalAjustado',
            'totalIngresosGrupo',
            'totalGastosGrupo',
            'utilidad',
            'anio',
            'mes',
            'aniosDisponibles',
            'meses',
            'proyectos',
            'proyectosSeleccionados'
        ));
    }
    
    private function getNaturalezaCuenta($tipo)
    {
        switch ($tipo) {
            case 'A': return 'Deudora';
            case 'P': return 'Acreedora';
            case 'C': return 'Acreedora';
            case 'I': return 'Acreedora';
            case 'G': return 'Deudora';
            default: return 'Deudora';
        }
    }
    
    public function exportarExcel(Request $request)
    {
        $anio = $request->get('anio', Carbon::now()->year);
        $mes = $request->get('mes', Carbon::now()->month);
        
        $proyectosIds = $request->get('proyectos', '');
        $proyectosSeleccionados = [];
        
        if (!empty($proyectosIds)) {
            if (is_string($proyectosIds)) {
                $proyectosSeleccionados = explode(',', $proyectosIds);
            } elseif (is_array($proyectosIds)) {
                $proyectosSeleccionados = $proyectosIds;
            }
            $proyectosSeleccionados = array_filter($proyectosSeleccionados);
            $proyectosSeleccionados = array_map('intval', $proyectosSeleccionados);
        }
        
        $fechaInicio = Carbon::create($anio, 1, 1)->startOfDay();
        $fechaLimite = Carbon::create($anio, $mes, 1)->endOfMonth();
        
        $movimientos = DB::table('movimientos_bancarios as mb')
            ->join('codigos_sat as cs', 'mb.codigo_sat_id', '=', 'cs.id')
            ->select(
                'cs.codigo_agrupador',
                'cs.nombre_cuenta',
                'cs.tipo',
                DB::raw("SUM(CASE WHEN mb.tipo = 'ingreso' THEN mb.monto ELSE 0 END) as ingresos"),
                DB::raw("SUM(CASE WHEN mb.tipo = 'egreso' THEN mb.monto ELSE 0 END) as egresos")
            )
            ->where('mb.status', 'aplicado')
            ->whereBetween('mb.fecha', [$fechaInicio, $fechaLimite]);
        
        if (!empty($proyectosSeleccionados)) {
            $movimientos->whereIn('mb.proyecto_id', $proyectosSeleccionados);
        }
        
        $movimientos = $movimientos
            ->groupBy('cs.codigo_agrupador', 'cs.nombre_cuenta', 'cs.tipo')
            ->orderBy('cs.codigo_agrupador')
            ->get();
        
        $filename = "balanza_comprobacion_{$anio}_{$mes}.csv";
        $handle = fopen('php://temp', 'w');
        fputs($handle, "\xEF\xBB\xBF");
        
        fputcsv($handle, ['BALANZA DE COMPROBACIÓN']);
        fputcsv($handle, ["Período: " . Carbon::create($anio, $mes, 1)->format('F Y')]);
        
        if (!empty($proyectosSeleccionados)) {
            $proyectosNombres = DB::table('proyectos')->whereIn('id', $proyectosSeleccionados)->pluck('codigo')->implode(', ');
            fputcsv($handle, ["Proyectos: {$proyectosNombres}"]);
        }
        
        fputcsv($handle, []);
        fputcsv($handle, ['Código', 'Cuenta', 'Naturaleza', 'Cargos (Debe)', 'Abonos (Haber)', 'Saldo']);
        
        $totalCargos = 0;
        $totalAbonos = 0;
        
        foreach ($movimientos as $item) {
            $naturaleza = $this->getNaturalezaCuenta($item->tipo);
            
            if ($naturaleza == 'Deudora') {
                $cargos = $item->ingresos;
                $abonos = $item->egresos;
                $saldo = $cargos - $abonos;
            } else {
                $cargos = $item->egresos;
                $abonos = $item->ingresos;
                $saldo = $abonos - $cargos;
            }
            
            $totalCargos += abs($cargos);
            $totalAbonos += abs($abonos);
            
            fputcsv($handle, [
                $item->codigo_agrupador,
                $item->nombre_cuenta,
                $naturaleza,
                number_format(abs($cargos), 2),
                number_format(abs($abonos), 2),
                number_format(abs($saldo), 2)
            ]);
        }
        
        fputcsv($handle, []);
        fputcsv($handle, ['TOTALES', '', '', number_format($totalCargos, 2), number_format($totalAbonos, 2), number_format($totalCargos - $totalAbonos, 2)]);
        
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
        
        return response($csv, 200)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }
}