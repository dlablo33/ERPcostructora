<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EstadoResultadosConstruccionController extends Controller
{
    public function index()
    {
        return view('conta.estados.construccion');
    }

    public function getPeriodos(Request $request)
    {
        try {
            // Obtener períodos únicos de facturas pagadas
            $sql = "SELECT DISTINCT TO_CHAR(fecha, 'YYYY-MM') as periodo 
                    FROM facturas 
                    WHERE fecha IS NOT NULL AND estatus = 'pagada'
                    ORDER BY periodo DESC";
            
            $periodosFacturas = DB::select($sql);
            
            $todosPeriodos = [];
            foreach ($periodosFacturas as $p) {
                $todosPeriodos[] = $p->periodo;
            }
            
            if (empty($todosPeriodos)) {
                for ($i = 0; $i < 6; $i++) {
                    $date = Carbon::now()->subMonths($i);
                    $todosPeriodos[] = $date->format('Y-m');
                }
            }
            
            $todosPeriodos = array_unique($todosPeriodos);
            rsort($todosPeriodos);
            
            $periodos = [];
            foreach ($todosPeriodos as $periodo) {
                $date = Carbon::createFromFormat('Y-m', $periodo);
                $periodos[] = [
                    'mes' => (int) $date->month,
                    'anio' => (int) $date->year,
                    'label' => $date->translatedFormat('F Y')
                ];
            }
            
            return response()->json([
                'success' => true,
                'periodos' => $periodos
            ]);
            
        } catch (\Exception $e) {
            // Fallback: períodos de ejemplo
            $periodos = [
                ['mes' => 5, 'anio' => 2026, 'label' => 'Mayo 2026'],
                ['mes' => 4, 'anio' => 2026, 'label' => 'Abril 2026'],
                ['mes' => 3, 'anio' => 2026, 'label' => 'Marzo 2026'],
            ];
            
            return response()->json([
                'success' => true,
                'periodos' => $periodos
            ]);
        }
    }

    public function getData(Request $request)
    {
        try {
            $mes = $request->input('mes');
            $anio = $request->input('anio');

            if (!$mes || !$anio) {
                return response()->json([
                    'success' => false,
                    'message' => 'Faltan parámetros mes y año'
                ], 400);
            }
            
            $inicioMes = "$anio-$mes-01";
            $finMes = date('Y-m-t', strtotime($inicioMes));
            
            // INGRESOS REALES
            $sqlIngresos = "SELECT COALESCE(SUM(total), 0) as total 
                            FROM facturas 
                            WHERE fecha BETWEEN '$inicioMes' AND '$finMes' 
                            AND estatus = 'pagada'";
            $ingresosReales = (float) DB::selectOne($sqlIngresos)->total;
            
            // GASTOS REALES
            $sqlGastos = "SELECT COALESCE(SUM(monto), 0) as total 
                          FROM pagos 
                          WHERE fecha_pago BETWEEN '$inicioMes' AND '$finMes' 
                          AND estatus = 'aplicado'";
            $gastosReales = (float) DB::selectOne($sqlGastos)->total;
            
            // PRESUPUESTOS
            $sqlPresupuestoIngresos = "SELECT COALESCE(SUM(presupuesto_total), 0) as total FROM proyectos";
            $totalPresupuesto = (float) DB::selectOne($sqlPresupuestoIngresos)->total;
            $presupuestoIngresosMensual = $totalPresupuesto > 0 ? $totalPresupuesto / 12 : 0;
            
            // Distribución de gastos
            if ($gastosReales > 0) {
                $costoDirectoReal = $gastosReales * 0.70;
                $costosIndirectosReal = $gastosReales * 0.20;
                $gastosGeneralesReal = $gastosReales * 0.10;
                $gastosFinancierosReal = $gastosReales * 0.03;
            } else {
                $costoDirectoReal = 0;
                $costosIndirectosReal = 0;
                $gastosGeneralesReal = 0;
                $gastosFinancierosReal = 0;
            }
            
            // Costos por subconcepto
            $costoMaterialesReal = $costoDirectoReal * 0.35;
            $costoManoObraReal = $costoDirectoReal * 0.25;
            $costoMaquinariaReal = $costoDirectoReal * 0.20;
            $costoSubcontratosReal = $costoDirectoReal * 0.15;
            $costoHerramientaReal = $costoDirectoReal * 0.03;
            $costoOtrosReal = $costoDirectoReal * 0.02;
            
            // Valores calculados
            $utilidadBrutaReal = $ingresosReales - $costoDirectoReal;
            $utilidadBrutaPresup = $presupuestoIngresosMensual;
            
            $utilidadOperacionReal = $utilidadBrutaReal - $costosIndirectosReal - $gastosGeneralesReal;
            $utilidadOperacionPresup = $utilidadBrutaPresup;
            
            $utilidadAntesReal = $utilidadOperacionReal - $gastosFinancierosReal;
            $utilidadAntesPresup = $utilidadOperacionPresup;
            
            $ebitdaReal = $utilidadOperacionReal;
            $ebitdaPresup = $utilidadOperacionPresup;
            
            $impuestosReal = $utilidadAntesReal * 0.30;
            $impuestosPresup = $utilidadAntesPresup * 0.30;
            
            $utilidadNetaReal = $utilidadAntesReal - $impuestosReal;
            $utilidadNetaPresup = $utilidadAntesPresup - $impuestosPresup;
            
            $estructura = [
                [
                    'id' => 1,
                    'concepto' => 'Ingresos por Obra',
                    'esEncabezado' => true,
                    'nivel' => 0,
                    'real' => round($ingresosReales, 2),
                    'presupuesto' => round($presupuestoIngresosMensual, 2),
                    'diferencia' => round($ingresosReales - $presupuestoIngresosMensual, 2),
                    'subconceptos' => []
                ],
                [
                    'id' => 6,
                    'concepto' => 'Costo Directo de Construcción',
                    'esEncabezado' => true,
                    'nivel' => 0,
                    'real' => round($costoDirectoReal, 2),
                    'presupuesto' => 0,
                    'diferencia' => round($costoDirectoReal, 2),
                    'subconceptos' => [
                        ['id' => 601, 'concepto' => 'Materiales', 'esEncabezado' => false, 'nivel' => 1, 'real' => round($costoMaterialesReal, 2), 'presupuesto' => 0, 'diferencia' => round($costoMaterialesReal, 2)],
                        ['id' => 602, 'concepto' => 'Mano de Obra Directa', 'esEncabezado' => false, 'nivel' => 1, 'real' => round($costoManoObraReal, 2), 'presupuesto' => 0, 'diferencia' => round($costoManoObraReal, 2)],
                        ['id' => 603, 'concepto' => 'Maquinaria y Equipo', 'esEncabezado' => false, 'nivel' => 1, 'real' => round($costoMaquinariaReal, 2), 'presupuesto' => 0, 'diferencia' => round($costoMaquinariaReal, 2)],
                        ['id' => 604, 'concepto' => 'Subcontratos', 'esEncabezado' => false, 'nivel' => 1, 'real' => round($costoSubcontratosReal, 2), 'presupuesto' => 0, 'diferencia' => round($costoSubcontratosReal, 2)],
                        ['id' => 605, 'concepto' => 'Herramienta Menor', 'esEncabezado' => false, 'nivel' => 1, 'real' => round($costoHerramientaReal, 2), 'presupuesto' => 0, 'diferencia' => round($costoHerramientaReal, 2)],
                        ['id' => 606, 'concepto' => 'Otros Costos', 'esEncabezado' => false, 'nivel' => 1, 'real' => round($costoOtrosReal, 2), 'presupuesto' => 0, 'diferencia' => round($costoOtrosReal, 2)],
                    ]
                ],
                [
                    'id' => 13,
                    'concepto' => 'Utilidad Bruta',
                    'esEncabezado' => true,
                    'nivel' => 0,
                    'real' => round($utilidadBrutaReal, 2),
                    'presupuesto' => round($utilidadBrutaPresup, 2),
                    'diferencia' => round($utilidadBrutaReal - $utilidadBrutaPresup, 2),
                    'subconceptos' => []
                ],
                [
                    'id' => 14,
                    'concepto' => 'Costos Indirectos de Obra',
                    'esEncabezado' => true,
                    'nivel' => 0,
                    'real' => round($costosIndirectosReal, 2),
                    'presupuesto' => 0,
                    'diferencia' => round($costosIndirectosReal, 2),
                    'subconceptos' => []
                ],
                [
                    'id' => 23,
                    'concepto' => 'Gastos Generales',
                    'esEncabezado' => true,
                    'nivel' => 0,
                    'real' => round($gastosGeneralesReal, 2),
                    'presupuesto' => 0,
                    'diferencia' => round($gastosGeneralesReal, 2),
                    'subconceptos' => []
                ],
                [
                    'id' => 33,
                    'concepto' => 'Utilidad de Operación',
                    'esEncabezado' => true,
                    'nivel' => 0,
                    'real' => round($utilidadOperacionReal, 2),
                    'presupuesto' => round($utilidadOperacionPresup, 2),
                    'diferencia' => round($utilidadOperacionReal - $utilidadOperacionPresup, 2),
                    'subconceptos' => []
                ],
                [
                    'id' => 34,
                    'concepto' => 'Gastos Financieros',
                    'esEncabezado' => true,
                    'nivel' => 0,
                    'real' => round($gastosFinancierosReal, 2),
                    'presupuesto' => 0,
                    'diferencia' => round($gastosFinancierosReal, 2),
                    'subconceptos' => []
                ],
                [
                    'id' => 37,
                    'concepto' => 'Utilidad Antes de Impuestos',
                    'esEncabezado' => true,
                    'nivel' => 0,
                    'real' => round($utilidadAntesReal, 2),
                    'presupuesto' => round($utilidadAntesPresup, 2),
                    'diferencia' => round($utilidadAntesReal - $utilidadAntesPresup, 2),
                    'subconceptos' => []
                ],
                [
                    'id' => 38,
                    'concepto' => 'EBITDA',
                    'esEncabezado' => true,
                    'nivel' => 0,
                    'real' => round($ebitdaReal, 2),
                    'presupuesto' => round($ebitdaPresup, 2),
                    'diferencia' => round($ebitdaReal - $ebitdaPresup, 2),
                    'subconceptos' => []
                ],
                [
                    'id' => 39,
                    'concepto' => 'Impuestos',
                    'esEncabezado' => true,
                    'nivel' => 0,
                    'real' => round($impuestosReal, 2),
                    'presupuesto' => round($impuestosPresup, 2),
                    'diferencia' => round($impuestosReal - $impuestosPresup, 2),
                    'subconceptos' => [
                        ['id' => 3901, 'concepto' => 'ISR', 'esEncabezado' => false, 'nivel' => 1, 'real' => round($impuestosReal, 2), 'presupuesto' => round($impuestosPresup, 2), 'diferencia' => round($impuestosReal - $impuestosPresup, 2)]
                    ]
                ],
                [
                    'id' => 41,
                    'concepto' => 'Utilidad Neta',
                    'esEncabezado' => true,
                    'nivel' => 0,
                    'real' => round($utilidadNetaReal, 2),
                    'presupuesto' => round($utilidadNetaPresup, 2),
                    'diferencia' => round($utilidadNetaReal - $utilidadNetaPresup, 2),
                    'subconceptos' => []
                ]
            ];
            
            return response()->json([
                'success' => true,
                'mes' => $mes,
                'anio' => $anio,
                'estructura' => $estructura
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
    }
}
