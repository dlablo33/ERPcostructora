<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FlujoEfectivoController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Obtener parámetros con valores por defecto
            $anio = $request->get('anio', Carbon::now()->year);
            $mes = $request->get('mes', Carbon::now()->month);
            $proyectosIds = $request->get('proyectos', '');
            
            // Log para depuración
            \Log::info("=== FLUJO EFECTIVO - INICIO ===");
            \Log::info("Año: $anio, Mes: $mes");
            \Log::info("Proyectos IDs: " . $proyectosIds);
            
            // Procesar proyectos seleccionados
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
            
            // Fechas del período actual
            $fechaInicio = Carbon::create($anio, $mes, 1)->startOfDay();
            $fechaFin = Carbon::create($anio, $mes, 1)->endOfMonth();
            
            // Fechas del período anterior (mismo mes del año anterior)
            $fechaInicioAnterior = Carbon::create($anio - 1, $mes, 1)->startOfDay();
            $fechaFinAnterior = Carbon::create($anio - 1, $mes, 1)->endOfMonth();
            
            \Log::info("Fechas actual: {$fechaInicio} - {$fechaFin}");
            \Log::info("Fechas anterior: {$fechaInicioAnterior} - {$fechaFinAnterior}");
            
            // Obtener datos con filtro de proyectos
            $datosFlujo = $this->obtenerDatosReales($fechaInicio, $fechaFin, $fechaInicioAnterior, $fechaFinAnterior, $proyectosSeleccionados);
            
            // Obtener años disponibles (con fallback)
            $aniosDisponibles = [];
            try {
                $aniosDisponibles = DB::table('movimientos_bancarios')
                    ->select(DB::raw('DISTINCT EXTRACT(YEAR FROM fecha) as anio'))
                    ->where('status', 'aplicado')
                    ->orderBy('anio', 'desc')
                    ->pluck('anio')
                    ->map(function($item) { return (int) $item; })
                    ->toArray();
                
                if (empty($aniosDisponibles)) {
                    $aniosDisponibles = [date('Y'), date('Y') - 1];
                }
            } catch (\Exception $e) {
                \Log::error("Error obteniendo años: " . $e->getMessage());
                $aniosDisponibles = [date('Y'), date('Y') - 1];
            }
            
            // Obtener proyectos para el filtro - SIN FILTRO DE STATUS
            $proyectos = collect([]);
            try {
                $proyectos = DB::table('proyectos')
                    ->select('id', 'codigo', 'nombre')
                    ->orderBy('codigo')
                    ->get();
                
                \Log::info("Proyectos encontrados: " . $proyectos->count());
                
                // Si no hay proyectos, intentar sin condición adicional
                if ($proyectos->isEmpty()) {
                    $proyectos = DB::table('proyectos')
                        ->select('id', 'codigo', 'nombre')
                        ->orderBy('codigo')
                        ->get();
                    \Log::info("Proyectos encontrados (sin filtro): " . $proyectos->count());
                }
            } catch (\Exception $e) {
                \Log::error("Error obteniendo proyectos: " . $e->getMessage());
                $proyectos = collect([]);
            }
            
            $meses = [
                1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
            ];
            
            \Log::info("Variables preparadas correctamente");
            \Log::info("aniosDisponibles: " . json_encode($aniosDisponibles));
            \Log::info("Total proyectos: " . $proyectos->count());
            \Log::info("Total ingresos operativos: " . ($datosFlujo['operacion']['ingresos'] ?? 0));
            \Log::info("=== FLUJO EFECTIVO - FIN ===");
            
            return view('conta.estados.flujo', [
                'datosFlujo' => $datosFlujo,
                'anio' => $anio,
                'mes' => $mes,
                'aniosDisponibles' => $aniosDisponibles,
                'meses' => $meses,
                'proyectos' => $proyectos,
                'proyectosSeleccionados' => $proyectosSeleccionados
            ]);
            
        } catch (\Exception $e) {
            \Log::error("ERROR CRÍTICO en FlujoEfectivoController: " . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            // Datos por defecto en caso de error
            $meses = [
                1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
            ];
            
            return view('conta.estados.flujo', [
                'datosFlujo' => [
                    'operacion' => [
                        'ingresos' => 0, 
                        'egresos' => 0, 
                        'flujo_neto' => 0, 
                        'ingresos_anterior' => 0, 
                        'egresos_anterior' => 0, 
                        'flujo_neto_anterior' => 0
                    ],
                    'inversion' => [
                        'ingresos' => 0, 
                        'egresos' => 0, 
                        'flujo_neto' => 0, 
                        'ingresos_anterior' => 0, 
                        'egresos_anterior' => 0, 
                        'flujo_neto_anterior' => 0
                    ],
                    'financiamiento' => [
                        'ingresos' => 0, 
                        'egresos' => 0, 
                        'flujo_neto' => 0, 
                        'ingresos_anterior' => 0, 
                        'egresos_anterior' => 0, 
                        'flujo_neto_anterior' => 0
                    ],
                    'flujo_neto_total' => 0,
                    'flujo_neto_total_anterior' => 0,
                    'saldo_inicial' => 0,
                    'saldo_final' => 0
                ],
                'anio' => date('Y'),
                'mes' => date('m'),
                'aniosDisponibles' => [date('Y'), date('Y') - 1],
                'meses' => $meses,
                'proyectos' => collect([]),
                'proyectosSeleccionados' => []
            ]);
        }
    }
    
    private function obtenerDatosReales($fechaInicio, $fechaFin, $fechaInicioAnterior, $fechaFinAnterior, $proyectosSeleccionados = [])
    {
        // ACTIVIDADES DE OPERACIÓN - Período Actual
        $ingresosOperativos = $this->getIngresosOperativos($fechaInicio, $fechaFin, $proyectosSeleccionados);
        $egresosOperativos = $this->getEgresosOperativos($fechaInicio, $fechaFin, $proyectosSeleccionados);
        $flujoOperativo = $ingresosOperativos - $egresosOperativos;
        
        // ACTIVIDADES DE OPERACIÓN - Período Anterior
        $ingresosOperativosAnterior = $this->getIngresosOperativos($fechaInicioAnterior, $fechaFinAnterior, $proyectosSeleccionados);
        $egresosOperativosAnterior = $this->getEgresosOperativos($fechaInicioAnterior, $fechaFinAnterior, $proyectosSeleccionados);
        $flujoOperativoAnterior = $ingresosOperativosAnterior - $egresosOperativosAnterior;
        
        // ACTIVIDADES DE INVERSIÓN - Período Actual
        $ingresosInversion = $this->getIngresosInversion($fechaInicio, $fechaFin, $proyectosSeleccionados);
        $egresosInversion = $this->getEgresosInversion($fechaInicio, $fechaFin, $proyectosSeleccionados);
        $flujoInversion = $ingresosInversion - $egresosInversion;
        
        // ACTIVIDADES DE INVERSIÓN - Período Anterior
        $ingresosInversionAnterior = $this->getIngresosInversion($fechaInicioAnterior, $fechaFinAnterior, $proyectosSeleccionados);
        $egresosInversionAnterior = $this->getEgresosInversion($fechaInicioAnterior, $fechaFinAnterior, $proyectosSeleccionados);
        $flujoInversionAnterior = $ingresosInversionAnterior - $egresosInversionAnterior;
        
        // ACTIVIDADES DE FINANCIAMIENTO - Período Actual
        $ingresosFinanciamiento = $this->getIngresosFinanciamiento($fechaInicio, $fechaFin, $proyectosSeleccionados);
        $egresosFinanciamiento = $this->getEgresosFinanciamiento($fechaInicio, $fechaFin, $proyectosSeleccionados);
        $flujoFinanciamiento = $ingresosFinanciamiento - $egresosFinanciamiento;
        
        // ACTIVIDADES DE FINANCIAMIENTO - Período Anterior
        $ingresosFinanciamientoAnterior = $this->getIngresosFinanciamiento($fechaInicioAnterior, $fechaFinAnterior, $proyectosSeleccionados);
        $egresosFinanciamientoAnterior = $this->getEgresosFinanciamiento($fechaInicioAnterior, $fechaFinAnterior, $proyectosSeleccionados);
        $flujoFinanciamientoAnterior = $ingresosFinanciamientoAnterior - $egresosFinanciamientoAnterior;
        
        // FLUJO NETO TOTAL
        $flujoNetoTotal = $flujoOperativo + $flujoInversion + $flujoFinanciamiento;
        $flujoNetoTotalAnterior = $flujoOperativoAnterior + $flujoInversionAnterior + $flujoFinanciamientoAnterior;
        
        // SALDOS
        $saldoInicial = $this->getSaldoInicial($fechaInicio, $proyectosSeleccionados);
        $saldoFinal = $saldoInicial + $flujoNetoTotal;
        
        \Log::info("Datos calculados - Ingresos: $ingresosOperativos, Egresos: $egresosOperativos, Flujo Neto: $flujoNetoTotal");
        
        return [
            'operacion' => [
                'ingresos' => $ingresosOperativos,
                'egresos' => $egresosOperativos,
                'flujo_neto' => $flujoOperativo,
                'ingresos_anterior' => $ingresosOperativosAnterior,
                'egresos_anterior' => $egresosOperativosAnterior,
                'flujo_neto_anterior' => $flujoOperativoAnterior
            ],
            'inversion' => [
                'ingresos' => $ingresosInversion,
                'egresos' => $egresosInversion,
                'flujo_neto' => $flujoInversion,
                'ingresos_anterior' => $ingresosInversionAnterior,
                'egresos_anterior' => $egresosInversionAnterior,
                'flujo_neto_anterior' => $flujoInversionAnterior
            ],
            'financiamiento' => [
                'ingresos' => $ingresosFinanciamiento,
                'egresos' => $egresosFinanciamiento,
                'flujo_neto' => $flujoFinanciamiento,
                'ingresos_anterior' => $ingresosFinanciamientoAnterior,
                'egresos_anterior' => $egresosFinanciamientoAnterior,
                'flujo_neto_anterior' => $flujoFinanciamientoAnterior
            ],
            'flujo_neto_total' => $flujoNetoTotal,
            'flujo_neto_total_anterior' => $flujoNetoTotalAnterior,
            'saldo_inicial' => $saldoInicial,
            'saldo_final' => $saldoFinal
        ];
    }
    
    private function getIngresosOperativos($inicio, $fin, $proyectosSeleccionados = [])
    {
        $query = DB::table('movimientos_bancarios as mb')
            ->join('codigos_sat as cs', 'mb.codigo_sat_id', '=', 'cs.id')
            ->where('mb.status', 'aplicado')
            ->where('mb.tipo', 'ingreso')
            ->whereBetween('mb.fecha', [$inicio, $fin])
            ->where('cs.codigo_agrupador', 'LIKE', '4%');
        
        if (!empty($proyectosSeleccionados)) {
            $query->whereIn('mb.proyecto_id', $proyectosSeleccionados);
        }
        
        $resultado = (float) $query->sum('mb.monto');
        \Log::info("getIngresosOperativos: $resultado");
        return $resultado;
    }
    
    private function getEgresosOperativos($inicio, $fin, $proyectosSeleccionados = [])
    {
        $query = DB::table('movimientos_bancarios as mb')
            ->join('codigos_sat as cs', 'mb.codigo_sat_id', '=', 'cs.id')
            ->where('mb.status', 'aplicado')
            ->where('mb.tipo', 'egreso')
            ->whereBetween('mb.fecha', [$inicio, $fin])
            ->where('cs.codigo_agrupador', 'LIKE', '5%');
        
        if (!empty($proyectosSeleccionados)) {
            $query->whereIn('mb.proyecto_id', $proyectosSeleccionados);
        }
        
        $resultado = (float) $query->sum('mb.monto');
        \Log::info("getEgresosOperativos: $resultado");
        return $resultado;
    }
    
    private function getIngresosInversion($inicio, $fin, $proyectosSeleccionados = [])
    {
        $query = DB::table('movimientos_bancarios as mb')
            ->join('codigos_sat as cs', 'mb.codigo_sat_id', '=', 'cs.id')
            ->where('mb.status', 'aplicado')
            ->where('mb.tipo', 'ingreso')
            ->whereBetween('mb.fecha', [$inicio, $fin])
            ->where(function($q) {
                $q->where('cs.codigo_agrupador', 'LIKE', '151%')
                  ->orWhere('cs.codigo_agrupador', 'LIKE', '152%')
                  ->orWhere('cs.codigo_agrupador', 'LIKE', '153%')
                  ->orWhere('cs.codigo_agrupador', 'LIKE', '154%');
            });
        
        if (!empty($proyectosSeleccionados)) {
            $query->whereIn('mb.proyecto_id', $proyectosSeleccionados);
        }
        
        return (float) $query->sum('mb.monto');
    }
    
    private function getEgresosInversion($inicio, $fin, $proyectosSeleccionados = [])
    {
        $query = DB::table('movimientos_bancarios as mb')
            ->join('codigos_sat as cs', 'mb.codigo_sat_id', '=', 'cs.id')
            ->where('mb.status', 'aplicado')
            ->where('mb.tipo', 'egreso')
            ->whereBetween('mb.fecha', [$inicio, $fin])
            ->where(function($q) {
                $q->where('cs.codigo_agrupador', 'LIKE', '151%')
                  ->orWhere('cs.codigo_agrupador', 'LIKE', '152%')
                  ->orWhere('cs.codigo_agrupador', 'LIKE', '153%')
                  ->orWhere('cs.codigo_agrupador', 'LIKE', '154%');
            });
        
        if (!empty($proyectosSeleccionados)) {
            $query->whereIn('mb.proyecto_id', $proyectosSeleccionados);
        }
        
        return (float) $query->sum('mb.monto');
    }
    
    private function getIngresosFinanciamiento($inicio, $fin, $proyectosSeleccionados = [])
    {
        $query = DB::table('movimientos_bancarios as mb')
            ->join('codigos_sat as cs', 'mb.codigo_sat_id', '=', 'cs.id')
            ->where('mb.status', 'aplicado')
            ->where('mb.tipo', 'ingreso')
            ->whereBetween('mb.fecha', [$inicio, $fin])
            ->where(function($q) {
                $q->where('cs.codigo_agrupador', 'LIKE', '300%')
                  ->orWhere('cs.codigo_agrupador', 'LIKE', '301%');
            });
        
        if (!empty($proyectosSeleccionados)) {
            $query->whereIn('mb.proyecto_id', $proyectosSeleccionados);
        }
        
        return (float) $query->sum('mb.monto');
    }
    
    private function getEgresosFinanciamiento($inicio, $fin, $proyectosSeleccionados = [])
    {
        $query = DB::table('movimientos_bancarios as mb')
            ->join('codigos_sat as cs', 'mb.codigo_sat_id', '=', 'cs.id')
            ->where('mb.status', 'aplicado')
            ->where('mb.tipo', 'egreso')
            ->whereBetween('mb.fecha', [$inicio, $fin])
            ->where(function($q) {
                $q->where('cs.codigo_agrupador', 'LIKE', '521%')
                  ->orWhere('cs.codigo_agrupador', 'LIKE', '522%');
            });
        
        if (!empty($proyectosSeleccionados)) {
            $query->whereIn('mb.proyecto_id', $proyectosSeleccionados);
        }
        
        return (float) $query->sum('mb.monto');
    }
    
    private function getSaldoInicial($fechaInicio, $proyectosSeleccionados = [])
    {
        $queryIngresos = DB::table('movimientos_bancarios')
            ->where('status', 'aplicado')
            ->where('tipo', 'ingreso')
            ->where('fecha', '<', $fechaInicio);
        
        $queryEgresos = DB::table('movimientos_bancarios')
            ->where('status', 'aplicado')
            ->where('tipo', 'egreso')
            ->where('fecha', '<', $fechaInicio);
        
        if (!empty($proyectosSeleccionados)) {
            $queryIngresos->whereIn('proyecto_id', $proyectosSeleccionados);
            $queryEgresos->whereIn('proyecto_id', $proyectosSeleccionados);
        }
        
        $ingresos = (float) $queryIngresos->sum('monto');
        $egresos = (float) $queryEgresos->sum('monto');
        
        $resultado = $ingresos - $egresos;
        \Log::info("Saldo inicial: $resultado (Ingresos: $ingresos, Egresos: $egresos)");
        return $resultado;
    }
    
    public function exportarExcel(Request $request)
    {
        try {
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
            
            $fechaInicio = Carbon::create($anio, $mes, 1)->startOfDay();
            $fechaFin = Carbon::create($anio, $mes, 1)->endOfMonth();
            $fechaInicioAnterior = Carbon::create($anio - 1, $mes, 1)->startOfDay();
            $fechaFinAnterior = Carbon::create($anio - 1, $mes, 1)->endOfMonth();
            
            $datosFlujo = $this->obtenerDatosReales($fechaInicio, $fechaFin, $fechaInicioAnterior, $fechaFinAnterior, $proyectosSeleccionados);
            
            $meses = [
                1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
            ];
            
            $filename = "flujo_efectivo_{$meses[$mes]}_{$anio}.csv";
            $handle = fopen('php://temp', 'w');
            fputs($handle, "\xEF\xBB\xBF");
            
            fputcsv($handle, ['ESTADO DE FLUJO DE EFECTIVO']);
            fputcsv($handle, ["Período: {$meses[$mes]} {$anio}"]);
            if (!empty($proyectosSeleccionados)) {
                $proyectosNombres = DB::table('proyectos')->whereIn('id', $proyectosSeleccionados)->pluck('codigo')->implode(', ');
                fputcsv($handle, ["Proyectos: {$proyectosNombres}"]);
            }
            fputcsv($handle, []);
            fputcsv($handle, ['Concepto', 'Período Actual', 'Período Anterior', 'Variación']);
            fputcsv($handle, ['ACTIVIDADES DE OPERACIÓN', '', '', '']);
            fputcsv($handle, ['  Ingresos operativos', number_format($datosFlujo['operacion']['ingresos'], 2), number_format($datosFlujo['operacion']['ingresos_anterior'], 2), number_format($datosFlujo['operacion']['ingresos'] - $datosFlujo['operacion']['ingresos_anterior'], 2)]);
            fputcsv($handle, ['  Egresos operativos', number_format($datosFlujo['operacion']['egresos'], 2), number_format($datosFlujo['operacion']['egresos_anterior'], 2), number_format($datosFlujo['operacion']['egresos'] - $datosFlujo['operacion']['egresos_anterior'], 2)]);
            fputcsv($handle, ['  Flujo neto de operación', number_format($datosFlujo['operacion']['flujo_neto'], 2), number_format($datosFlujo['operacion']['flujo_neto_anterior'], 2), number_format($datosFlujo['operacion']['flujo_neto'] - $datosFlujo['operacion']['flujo_neto_anterior'], 2)]);
            fputcsv($handle, []);
            fputcsv($handle, ['ACTIVIDADES DE INVERSIÓN', '', '', '']);
            fputcsv($handle, ['  Ingresos por inversión', number_format($datosFlujo['inversion']['ingresos'], 2), number_format($datosFlujo['inversion']['ingresos_anterior'], 2), number_format($datosFlujo['inversion']['ingresos'] - $datosFlujo['inversion']['ingresos_anterior'], 2)]);
            fputcsv($handle, ['  Egresos por inversión', number_format($datosFlujo['inversion']['egresos'], 2), number_format($datosFlujo['inversion']['egresos_anterior'], 2), number_format($datosFlujo['inversion']['egresos'] - $datosFlujo['inversion']['egresos_anterior'], 2)]);
            fputcsv($handle, ['  Flujo neto de inversión', number_format($datosFlujo['inversion']['flujo_neto'], 2), number_format($datosFlujo['inversion']['flujo_neto_anterior'], 2), number_format($datosFlujo['inversion']['flujo_neto'] - $datosFlujo['inversion']['flujo_neto_anterior'], 2)]);
            fputcsv($handle, []);
            fputcsv($handle, ['ACTIVIDADES DE FINANCIAMIENTO', '', '', '']);
            fputcsv($handle, ['  Ingresos por financiamiento', number_format($datosFlujo['financiamiento']['ingresos'], 2), number_format($datosFlujo['financiamiento']['ingresos_anterior'], 2), number_format($datosFlujo['financiamiento']['ingresos'] - $datosFlujo['financiamiento']['ingresos_anterior'], 2)]);
            fputcsv($handle, ['  Egresos por financiamiento', number_format($datosFlujo['financiamiento']['egresos'], 2), number_format($datosFlujo['financiamiento']['egresos_anterior'], 2), number_format($datosFlujo['financiamiento']['egresos'] - $datosFlujo['financiamiento']['egresos_anterior'], 2)]);
            fputcsv($handle, ['  Flujo neto de financiamiento', number_format($datosFlujo['financiamiento']['flujo_neto'], 2), number_format($datosFlujo['financiamiento']['flujo_neto_anterior'], 2), number_format($datosFlujo['financiamiento']['flujo_neto'] - $datosFlujo['financiamiento']['flujo_neto_anterior'], 2)]);
            fputcsv($handle, []);
            fputcsv($handle, ['INCREMENTO/DISMINUCIÓN NETA DE EFECTIVO', number_format($datosFlujo['flujo_neto_total'], 2), number_format($datosFlujo['flujo_neto_total_anterior'], 2), number_format($datosFlujo['flujo_neto_total'] - $datosFlujo['flujo_neto_total_anterior'], 2)]);
            fputcsv($handle, ['Efectivo al inicio del período', number_format($datosFlujo['saldo_inicial'], 2), '', '']);
            fputcsv($handle, ['Efectivo al final del período', number_format($datosFlujo['saldo_final'], 2), '', '']);
            
            rewind($handle);
            $csv = stream_get_contents($handle);
            fclose($handle);
            
            return response($csv, 200)
                ->header('Content-Type', 'text/csv; charset=UTF-8')
                ->header('Content-Disposition', "attachment; filename=\"$filename\"");
                
        } catch (\Exception $e) {
            \Log::error("Error exportando Excel: " . $e->getMessage());
            return response()->json(['error' => 'Error al exportar'], 500);
        }
    }
    
    public function exportarPDF(Request $request)
    {
        return $this->exportarExcel($request);
    }
}