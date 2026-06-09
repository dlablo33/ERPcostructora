<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EstadoResultadosUnidadController extends Controller
{
    public function index(Request $request)
    {
        $anio = $request->get('anio', Carbon::now()->year);
        $mes = $request->get('mes', Carbon::now()->month);
        
        // Obtener unidades seleccionadas (múltiples)
        $unidadesIds = $request->get('unidades', '');
        $unidadesSeleccionadas = [];
        if (!empty($unidadesIds)) {
            if (is_string($unidadesIds)) {
                $unidadesSeleccionadas = explode(',', $unidadesIds);
            } elseif (is_array($unidadesIds)) {
                $unidadesSeleccionadas = $unidadesIds;
            }
            $unidadesSeleccionadas = array_filter($unidadesSeleccionadas);
            $unidadesSeleccionadas = array_map('intval', $unidadesSeleccionadas);
        }
        
        // Obtener unidades de negocio para el filtro
        $unidades = DB::table('cat_unidades_negocio')
            ->where('activo', true)
            ->orderBy('descripcion')
            ->get();
        
        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
        
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
        
        return view('conta.estados.unidad', compact('unidades', 'anio', 'mes', 'meses', 'aniosDisponibles', 'unidadesSeleccionadas'));
    }
    
    public function getData(Request $request)
    {
        try {
            $anio = $request->get('anio', Carbon::now()->year);
            $mes = $request->get('mes', Carbon::now()->month);
            $unidadesIds = $request->get('unidades', '');
            
            // Procesar unidades seleccionadas
            $unidadesSeleccionadas = [];
            if (!empty($unidadesIds)) {
                if (is_string($unidadesIds)) {
                    $unidadesSeleccionadas = explode(',', $unidadesIds);
                } elseif (is_array($unidadesIds)) {
                    $unidadesSeleccionadas = $unidadesIds;
                }
                $unidadesSeleccionadas = array_filter($unidadesSeleccionadas);
                $unidadesSeleccionadas = array_map('intval', $unidadesSeleccionadas);
            }
            
            // Fechas
            $fechaInicio = Carbon::create($anio, $mes, 1)->startOfDay();
            $fechaFin = Carbon::create($anio, $mes, 1)->endOfMonth();
            
            // ============================================
            // 1. INGRESOS TOTALES POR UNIDAD
            // ============================================
            $ingresosQuery = DB::table('movimientos_bancarios as mb')
                ->join('proyectos as p', 'mb.proyecto_id', '=', 'p.id')
                ->join('cat_unidades_negocio as un', 'p.unidad_negocio_id', '=', 'un.cat_unidad_negocio_id')
                ->join('codigos_sat as cs', 'mb.codigo_sat_id', '=', 'cs.id')
                ->where('mb.status', 'aplicado')
                ->where('mb.tipo', 'ingreso')
                ->whereBetween('mb.fecha', [$fechaInicio, $fechaFin])
                ->where('cs.codigo_agrupador', 'LIKE', '4%');
            
            if (!empty($unidadesSeleccionadas)) {
                $ingresosQuery->whereIn('un.cat_unidad_negocio_id', $unidadesSeleccionadas);
            }
            
            $totalIngresos = (float) $ingresosQuery->sum('mb.monto');
            
            // ============================================
            // 2. GASTOS POR CATEGORÍA
            // ============================================
            $gastosQuery = DB::table('movimientos_bancarios as mb')
                ->join('proyectos as p', 'mb.proyecto_id', '=', 'p.id')
                ->join('cat_unidades_negocio as un', 'p.unidad_negocio_id', '=', 'un.cat_unidad_negocio_id')
                ->join('codigos_sat as cs', 'mb.codigo_sat_id', '=', 'cs.id')
                ->where('mb.status', 'aplicado')
                ->where('mb.tipo', 'egreso')
                ->whereBetween('mb.fecha', [$fechaInicio, $fechaFin])
                ->where('cs.codigo_agrupador', 'LIKE', '5%');
            
            if (!empty($unidadesSeleccionadas)) {
                $gastosQuery->whereIn('un.cat_unidad_negocio_id', $unidadesSeleccionadas);
            }
            
            $gastos = $gastosQuery
                ->select(
                    'cs.codigo_agrupador',
                    'cs.nombre_cuenta',
                    DB::raw('SUM(mb.monto) as total')
                )
                ->groupBy('cs.codigo_agrupador', 'cs.nombre_cuenta')
                ->orderBy('cs.codigo_agrupador')
                ->get();
            
            // ============================================
            // 3. OBTENER CONFIGURACIÓN DE CONCEPTOS
            // ============================================
            $configConceptos = $this->getConfigConceptos();
            
            // ============================================
            // 4. ESTRUCTURA DE LA TABLA
            // ============================================
            $resultados = $this->estructurarTabla($totalIngresos, $gastos, $configConceptos);
            
            // ============================================
            // 5. KPIs (Unidades y Kilómetros)
            // ============================================
            $kpis = $this->getKpis($unidadesSeleccionadas, $fechaInicio, $fechaFin);
            
            return response()->json([
                'success' => true,
                'kpis' => $kpis,
                'resultados' => $resultados,
                'total_ingresos' => $totalIngresos
            ]);
            
        } catch (\Exception $e) {
            \Log::error("Error en getData: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    private function getConfigConceptos()
    {
        // Mapeo de códigos SAT a conceptos (por defecto)
        $conceptosPorDefecto = [
            '531' => ['concepto' => 'Combustible', 'categoria' => 'costos_variables'],
            '532' => ['concepto' => 'Casetas', 'categoria' => 'costos_variables'],
            '511.02' => ['concepto' => 'Sueldos Operadores', 'categoria' => 'costos_variables'],
            '511.01' => ['concepto' => 'Sueldos Administrativos', 'categoria' => 'gastos_fijos'],
            '517' => ['concepto' => 'Gastos de Viaje', 'categoria' => 'costos_variables'],
            '518' => ['concepto' => 'Honorarios', 'categoria' => 'gastos_fijos'],
            '512' => ['concepto' => 'Rentas', 'categoria' => 'gastos_fijos'],
            '513' => ['concepto' => 'Servicios Básicos', 'categoria' => 'gastos_fijos'],
            '514' => ['concepto' => 'Papelería y Útiles', 'categoria' => 'gastos_fijos'],
            '515' => ['concepto' => 'Gastos de Oficina', 'categoria' => 'gastos_fijos'],
            '516' => ['concepto' => 'Mantenimiento', 'categoria' => 'costos_variables'],
            '521' => ['concepto' => 'Intereses Bancarios', 'categoria' => 'financiamiento'],
            '522' => ['concepto' => 'Comisiones Bancarias', 'categoria' => 'financiamiento'],
            '541' => ['concepto' => 'Comisiones', 'categoria' => 'costos_variables'],
            '550' => ['concepto' => 'Depreciación', 'categoria' => 'gastos_fijos'],
            '551' => ['concepto' => 'Depreciación de Equipo', 'categoria' => 'gastos_fijos'],
            '552' => ['concepto' => 'Depreciación de Vehículos', 'categoria' => 'gastos_fijos']
        ];
        
        // Intentar obtener configuraciones de la base de datos
        try {
            $configuraciones = DB::table('config_conceptos')
                ->where('activo', true)
                ->get();
            
            if ($configuraciones->isNotEmpty()) {
                $conceptosDB = [];
                foreach ($configuraciones as $config) {
                    $conceptosDB[$config->codigo_sat] = [
                        'concepto' => $config->nombre_concepto,
                        'categoria' => $config->categoria,
                        'id' => $config->id
                    ];
                }
                return $conceptosDB;
            }
        } catch (\Exception $e) {
            // Tabla no existe, usar conceptos por defecto
        }
        
        return $conceptosPorDefecto;
    }
    
    private function getKpis($unidadesSeleccionadas, $fechaInicio, $fechaFin)
    {
        // Verificar si hay datos en movimientos_activos
        $existenMovimientos = DB::table('movimientos_activos')->exists();
        
        if (!$existenMovimientos) {
            return [
                'total_unidades' => 0,
                'unidades_usadas' => 0,
                'porcentaje_usadas' => 0,
                'km_totales' => 0,
                'unidades_unidad' => 0,
                'km_unidad' => 0,
                'km_liquidados' => 0,
                'porcentaje_km_liquidados' => 0,
                'sin_datos' => true
            ];
        }
        
        // Total de unidades (activos)
        $queryUnidades = DB::table('activos')
            ->where('estatus', 'activo');
        
        if (!empty($unidadesSeleccionadas)) {
            $queryUnidades->whereIn('unidad_negocio_id', $unidadesSeleccionadas);
        }
        $totalUnidades = $queryUnidades->count();
        
        // Unidades usadas en el período
        $queryUnidadesUsadas = DB::table('movimientos_activos as ma')
            ->join('activos as a', 'ma.activo_id', '=', 'a.id')
            ->whereBetween('ma.fecha_movimiento', [$fechaInicio, $fechaFin])
            ->distinct('ma.activo_id');
        
        if (!empty($unidadesSeleccionadas)) {
            $queryUnidadesUsadas->whereIn('a.unidad_negocio_id', $unidadesSeleccionadas);
        }
        $unidadesUsadas = $queryUnidadesUsadas->count('ma.activo_id');
        
        // Porcentaje de unidades usadas
        $porcentajeUsadas = $totalUnidades > 0 ? ($unidadesUsadas / $totalUnidades) * 100 : 0;
        
        // Kilómetros totales
        $queryKm = DB::table('movimientos_activos as ma')
            ->join('activos as a', 'ma.activo_id', '=', 'a.id')
            ->whereBetween('ma.fecha_movimiento', [$fechaInicio, $fechaFin]);
        
        if (!empty($unidadesSeleccionadas)) {
            $queryKm->whereIn('a.unidad_negocio_id', $unidadesSeleccionadas);
        }
        $kmTotales = (float) $queryKm->sum('ma.horometro_km');
        
        return [
            'total_unidades' => $totalUnidades,
            'unidades_usadas' => $unidadesUsadas,
            'porcentaje_usadas' => round($porcentajeUsadas, 2),
            'km_totales' => $kmTotales,
            'unidades_unidad' => 0,
            'km_unidad' => 0,
            'km_liquidados' => 0,
            'porcentaje_km_liquidados' => 0,
            'sin_datos' => false
        ];
    }
    
    private function estructurarTabla($totalIngresos, $gastos, $configConceptos)
    {
        $resultados = [];
        $totalGastos = 0;
        
        // Agrupar gastos por código SAT
        $gastosAgrupados = [];
        foreach ($gastos as $gasto) {
            $codigo = $gasto->codigo_agrupador;
            if (!isset($gastosAgrupados[$codigo])) {
                $gastosAgrupados[$codigo] = [
                    'monto' => 0,
                    'nombre' => $gasto->nombre_cuenta
                ];
            }
            $gastosAgrupados[$codigo]['monto'] += $gasto->total;
        }
        
        // Procesar cada gasto con su concepto configurado
        foreach ($gastosAgrupados as $codigo => $gasto) {
            $conceptoInfo = $configConceptos[$codigo] ?? null;
            $concepto = $conceptoInfo['concepto'] ?? $gasto['nombre'];
            $categoria = $conceptoInfo['categoria'] ?? 'otros';
            
            $resultados[] = [
                'concepto' => $concepto,
                'categoria' => $categoria,
                'monto' => $gasto['monto'],
                'codigo' => $codigo,
                'km' => 0,
                'unidad' => 0
            ];
            $totalGastos += $gasto['monto'];
        }
        
        // Ordenar resultados: costos_variables, gastos_fijos, financiamiento, otros
        $ordenCategorias = [
            'costos_variables' => 1,
            'gastos_fijos' => 2,
            'financiamiento' => 3,
            'otros' => 4
        ];
        
        usort($resultados, function($a, $b) use ($ordenCategorias) {
            $ordenA = $ordenCategorias[$a['categoria']] ?? 4;
            $ordenB = $ordenCategorias[$b['categoria']] ?? 4;
            if ($ordenA == $ordenB) {
                return strcmp($a['concepto'], $b['concepto']);
            }
            return $ordenA - $ordenB;
        });
        
        $utilidad = $totalIngresos - $totalGastos;
        
        return [
            'gastos' => $resultados,
            'total_gastos' => $totalGastos,
            'utilidad' => $utilidad
        ];
    }
    
    // ============================================
    // CONFIGURACIÓN
    // ============================================
    
    public function getConfiguracion(Request $request)
    {
        $unidadId = $request->get('unidad_id');
        
        // Obtener conceptos configurados
        $conceptos = DB::table('config_conceptos')
            ->orderBy('categoria')
            ->orderBy('orden')
            ->get();
        
        // Si no hay conceptos en la BD, usar los de prueba
        if ($conceptos->isEmpty()) {
            $this->insertarConceptosPrueba();
            $conceptos = DB::table('config_conceptos')
                ->orderBy('categoria')
                ->orderBy('orden')
                ->get();
        }
        
        $configuraciones = [];
        if ($unidadId) {
            $configuraciones = DB::table('config_unidad_conceptos')
                ->where('unidad_negocio_id', $unidadId)
                ->pluck('porcentaje', 'concepto_id')
                ->toArray();
        }
        
        $unidades = DB::table('cat_unidades_negocio')
            ->where('activo', true)
            ->get();
        
        return response()->json([
            'success' => true,
            'conceptos' => $conceptos,
            'configuraciones' => $configuraciones,
            'unidades' => $unidades
        ]);
    }
    
    private function insertarConceptosPrueba()
    {
        $conceptos = [
            ['categoria' => 'costos_variables', 'codigo_sat' => '531', 'nombre_concepto' => 'Combustible', 'orden' => 1],
            ['categoria' => 'costos_variables', 'codigo_sat' => '532', 'nombre_concepto' => 'Casetas', 'orden' => 2],
            ['categoria' => 'costos_variables', 'codigo_sat' => '511.02', 'nombre_concepto' => 'Sueldos Operadores', 'orden' => 3],
            ['categoria' => 'costos_variables', 'codigo_sat' => '516', 'nombre_concepto' => 'Mantenimiento', 'orden' => 4],
            ['categoria' => 'costos_variables', 'codigo_sat' => '541', 'nombre_concepto' => 'Comisiones', 'orden' => 5],
            ['categoria' => 'costos_variables', 'codigo_sat' => '517', 'nombre_concepto' => 'Gastos de Viaje', 'orden' => 6],
            ['categoria' => 'gastos_fijos', 'codigo_sat' => '511.01', 'nombre_concepto' => 'Sueldos Administrativos', 'orden' => 1],
            ['categoria' => 'gastos_fijos', 'codigo_sat' => '518', 'nombre_concepto' => 'Honorarios', 'orden' => 2],
            ['categoria' => 'gastos_fijos', 'codigo_sat' => '512', 'nombre_concepto' => 'Rentas', 'orden' => 3],
            ['categoria' => 'gastos_fijos', 'codigo_sat' => '513', 'nombre_concepto' => 'Servicios Básicos', 'orden' => 4],
            ['categoria' => 'gastos_fijos', 'codigo_sat' => '514', 'nombre_concepto' => 'Papelería y Útiles', 'orden' => 5],
            ['categoria' => 'gastos_fijos', 'codigo_sat' => '515', 'nombre_concepto' => 'Gastos de Oficina', 'orden' => 6],
            ['categoria' => 'gastos_fijos', 'codigo_sat' => '550', 'nombre_concepto' => 'Depreciación', 'orden' => 7],
            ['categoria' => 'financiamiento', 'codigo_sat' => '521', 'nombre_concepto' => 'Intereses Bancarios', 'orden' => 1],
            ['categoria' => 'financiamiento', 'codigo_sat' => '522', 'nombre_concepto' => 'Comisiones Bancarias', 'orden' => 2],
        ];
        
        foreach ($conceptos as $concepto) {
            DB::table('config_conceptos')->insert([
                'categoria' => $concepto['categoria'],
                'codigo_sat' => $concepto['codigo_sat'],
                'nombre_concepto' => $concepto['nombre_concepto'],
                'orden' => $concepto['orden'],
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
    
    public function guardarConfiguracion(Request $request)
    {
        try {
            $unidadId = $request->get('unidad_id');
            $configuraciones = $request->get('configuraciones', []);
            
            foreach ($configuraciones as $conceptoId => $porcentaje) {
                DB::table('config_unidad_conceptos')->updateOrInsert(
                    [
                        'unidad_negocio_id' => $unidadId,
                        'concepto_id' => $conceptoId
                    ],
                    [
                        'porcentaje' => $porcentaje,
                        'activo' => true,
                        'updated_at' => now()
                    ]
                );
            }
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    public function guardarConcepto(Request $request)
    {
        try {
            $id = $request->get('id');
            $data = [
                'categoria' => $request->get('categoria'),
                'codigo_sat' => $request->get('codigo_sat'),
                'nombre_concepto' => $request->get('nombre_concepto'),
                'descripcion' => $request->get('descripcion'),
                'orden' => $request->get('orden', 0),
                'updated_at' => now()
            ];
            
            if ($id) {
                DB::table('config_conceptos')->where('id', $id)->update($data);
            } else {
                $data['created_at'] = now();
                $data['activo'] = true;
                $id = DB::table('config_conceptos')->insertGetId($data);
            }
            
            return response()->json(['success' => true, 'id' => $id]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    public function eliminarConcepto($id)
    {
        try {
            DB::table('config_conceptos')->where('id', $id)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    // ============================================
    // EXPORTAR A EXCEL
    // ============================================
    
    public function exportarExcel(Request $request)
    {
        $anio = $request->get('anio', Carbon::now()->year);
        $mes = $request->get('mes', Carbon::now()->month);
        $unidadesIds = $request->get('unidades', '');
        
        $unidadesSeleccionadas = [];
        if (!empty($unidadesIds)) {
            if (is_string($unidadesIds)) {
                $unidadesSeleccionadas = explode(',', $unidadesIds);
            } elseif (is_array($unidadesIds)) {
                $unidadesSeleccionadas = $unidadesIds;
            }
            $unidadesSeleccionadas = array_filter($unidadesSeleccionadas);
            $unidadesSeleccionadas = array_map('intval', $unidadesSeleccionadas);
        }
        
        $fechaInicio = Carbon::create($anio, $mes, 1)->startOfDay();
        $fechaFin = Carbon::create($anio, $mes, 1)->endOfMonth();
        
        // Obtener nombres de unidades seleccionadas
        $unidadesNombres = '';
        if (!empty($unidadesSeleccionadas)) {
            $unidadesNombres = DB::table('cat_unidades_negocio')
                ->whereIn('cat_unidad_negocio_id', $unidadesSeleccionadas)
                ->pluck('descripcion')
                ->implode(', ');
        }
        
        // Calcular ingresos
        $ingresosQuery = DB::table('movimientos_bancarios as mb')
            ->join('proyectos as p', 'mb.proyecto_id', '=', 'p.id')
            ->join('cat_unidades_negocio as un', 'p.unidad_negocio_id', '=', 'un.cat_unidad_negocio_id')
            ->join('codigos_sat as cs', 'mb.codigo_sat_id', '=', 'cs.id')
            ->where('mb.status', 'aplicado')
            ->where('mb.tipo', 'ingreso')
            ->whereBetween('mb.fecha', [$fechaInicio, $fechaFin])
            ->where('cs.codigo_agrupador', 'LIKE', '4%');
        
        if (!empty($unidadesSeleccionadas)) {
            $ingresosQuery->whereIn('un.cat_unidad_negocio_id', $unidadesSeleccionadas);
        }
        $totalIngresos = (float) $ingresosQuery->sum('mb.monto');
        
        // Calcular gastos
        $gastosQuery = DB::table('movimientos_bancarios as mb')
            ->join('proyectos as p', 'mb.proyecto_id', '=', 'p.id')
            ->join('cat_unidades_negocio as un', 'p.unidad_negocio_id', '=', 'un.cat_unidad_negocio_id')
            ->join('codigos_sat as cs', 'mb.codigo_sat_id', '=', 'cs.id')
            ->where('mb.status', 'aplicado')
            ->where('mb.tipo', 'egreso')
            ->whereBetween('mb.fecha', [$fechaInicio, $fechaFin])
            ->where('cs.codigo_agrupador', 'LIKE', '5%');
        
        if (!empty($unidadesSeleccionadas)) {
            $gastosQuery->whereIn('un.cat_unidad_negocio_id', $unidadesSeleccionadas);
        }
        $gastos = $gastosQuery
            ->select('cs.codigo_agrupador', 'cs.nombre_cuenta', DB::raw('SUM(mb.monto) as total'))
            ->groupBy('cs.codigo_agrupador', 'cs.nombre_cuenta')
            ->get();
        
        $totalGastos = 0;
        foreach ($gastos as $gasto) {
            $totalGastos += $gasto->total;
        }
        $utilidad = $totalIngresos - $totalGastos;
        
        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
        
        $filename = "estado_resultados_{$meses[$mes]}_{$anio}.csv";
        $handle = fopen('php://temp', 'w');
        fputs($handle, "\xEF\xBB\xBF");
        
        fputcsv($handle, ['ESTADO DE RESULTADOS POR UNIDAD DE NEGOCIO']);
        fputcsv($handle, ["Período: {$meses[$mes]} {$anio}"]);
        if ($unidadesNombres) {
            fputcsv($handle, ["Unidades: {$unidadesNombres}"]);
        }
        fputcsv($handle, []);
        fputcsv($handle, ['Concepto', 'Monto', '%']);
        fputcsv($handle, ['INGRESOS TOTALES', number_format($totalIngresos, 2), '100.00%']);
        fputcsv($handle, ['COSTO DIRECTO DE OPERACIÓN', number_format($totalGastos, 2), number_format(($totalGastos / max($totalIngresos, 1)) * 100, 2) . '%']);
        
        foreach ($gastos as $gasto) {
            $porcentaje = ($gasto->total / max($totalIngresos, 1)) * 100;
            fputcsv($handle, ['  ' . $gasto->nombre_cuenta, number_format($gasto->total, 2), number_format($porcentaje, 2) . '%']);
        }
        
        fputcsv($handle, []);
        fputcsv($handle, ['UTILIDAD DEL EJERCICIO', number_format($utilidad, 2), number_format(($utilidad / max($totalIngresos, 1)) * 100, 2) . '%']);
        
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
        
        return response($csv, 200)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }
}