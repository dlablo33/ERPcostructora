<?php

namespace App\Http\Controllers;

use App\Models\MovimientoBancario;
use App\Models\CuentaBancaria;
use App\Models\CategoriaGasto;
use App\Models\TipoIngreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FlujoMensualController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('administracion.tesoreria.flujo_mensual');
    }

    /**
     * Obtener datos del flujo de dinero por rango de meses
     */
    public function getData(Request $request)
    {
        try {
            $mesInicio = $request->get('mes_inicio', '2026-2');
            $mesFin = $request->get('mes_fin', '2026-3');
            
            // Obtener meses en el rango
            $meses = $this->obtenerMesesEnRango($mesInicio, $mesFin);
            
            if (empty($meses)) {
                return response()->json([
                    'success' => true,
                    'data' => ['cuentas' => [], 'meses' => []],
                    'totales_por_mes' => [],
                    'acumulados_por_cuenta' => []
                ]);
            }
            
            // Obtener movimientos agrupados por mes
            $datosPorMes = [];
            $totalesPorMes = [];
            $acumuladosPorCuenta = [];
            
            foreach ($meses as $mes) {
                $fechaInicio = $mes['inicio'];
                $fechaFin = $mes['fin'];
                
                // Obtener movimientos del mes
                $movimientos = MovimientoBancario::whereBetween('fecha', [$fechaInicio, $fechaFin])
                    ->get();
                
                $ingresos = [];
                $egresos = [];
                
                foreach ($movimientos as $mov) {
                    $tipo = $mov->tipo;
                    $categoria = $this->getCategoriaMovimiento($mov);
                    $codigo = $this->getCodigoCategoria($categoria);
                    
                    if ($tipo === 'ingreso') {
                        if (!isset($ingresos[$codigo])) {
                            $ingresos[$codigo] = [
                                'codigo' => $codigo,
                                'nombre' => $categoria,
                                'total' => 0
                            ];
                        }
                        $ingresos[$codigo]['total'] += $mov->monto;
                        
                        // Acumulado anual
                        if (!isset($acumuladosPorCuenta[$codigo])) {
                            $acumuladosPorCuenta[$codigo] = 0;
                        }
                        $acumuladosPorCuenta[$codigo] += $mov->monto;
                    } else {
                        if (!isset($egresos[$codigo])) {
                            $egresos[$codigo] = [
                                'codigo' => $codigo,
                                'nombre' => $categoria,
                                'total' => 0
                            ];
                        }
                        $egresos[$codigo]['total'] += $mov->monto;
                        
                        // Acumulado anual
                        if (!isset($acumuladosPorCuenta[$codigo])) {
                            $acumuladosPorCuenta[$codigo] = 0;
                        }
                        $acumuladosPorCuenta[$codigo] += $mov->monto;
                    }
                }
                
                $datosPorMes[$mes['clave']] = [
                    'ingresos' => $ingresos,
                    'egresos' => $egresos,
                    'nombre' => $mes['nombre']
                ];
                
                // Calcular total del mes
                $totalMes = 0;
                foreach ($ingresos as $ingreso) {
                    $totalMes += $ingreso['total'];
                }
                foreach ($egresos as $egreso) {
                    $totalMes -= $egreso['total'];
                }
                $totalesPorMes[$mes['clave']] = $totalMes;
            }
            
            // Construir estructura de cuentas (Ingresos y Egresos)
            $cuentas = [];
            
            // Obtener todas las categorías únicas
            $todasCategorias = [];
            foreach ($datosPorMes as $mesData) {
                foreach ($mesData['ingresos'] as $codigo => $data) {
                    if (!isset($todasCategorias[$codigo])) {
                        $todasCategorias[$codigo] = [
                            'codigo' => $codigo,
                            'nombre' => $data['nombre'],
                            'tipo' => 'ingreso'
                        ];
                    }
                }
                foreach ($mesData['egresos'] as $codigo => $data) {
                    if (!isset($todasCategorias[$codigo])) {
                        $todasCategorias[$codigo] = [
                            'codigo' => $codigo,
                            'nombre' => $data['nombre'],
                            'tipo' => 'egreso'
                        ];
                    }
                }
            }
            
            // Construir subcuentas de ingresos
            $subcuentasIngresos = [];
            $subcuentasEgresos = [];
            
            foreach ($todasCategorias as $codigo => $categoria) {
                $subcuenta = [
                    'id' => rand(100, 999),
                    'codigo' => $codigo,
                    'nombre' => $categoria['nombre'],
                    'meses' => []
                ];
                
                foreach ($meses as $mes) {
                    $clave = $mes['clave'];
                    $valor = 0;
                    if ($categoria['tipo'] === 'ingreso' && isset($datosPorMes[$clave]['ingresos'][$codigo])) {
                        $valor = $datosPorMes[$clave]['ingresos'][$codigo]['total'];
                    } elseif ($categoria['tipo'] === 'egreso' && isset($datosPorMes[$clave]['egresos'][$codigo])) {
                        $valor = $datosPorMes[$clave]['egresos'][$codigo]['total'];
                    }
                    $subcuenta['meses'][$clave] = $valor;
                }
                
                if ($categoria['tipo'] === 'ingreso') {
                    $subcuentasIngresos[] = $subcuenta;
                } else {
                    $subcuentasEgresos[] = $subcuenta;
                }
            }
            
            // Ordenar subcuentas por código
            usort($subcuentasIngresos, function($a, $b) {
                return strcmp($a['codigo'], $b['codigo']);
            });
            usort($subcuentasEgresos, function($a, $b) {
                return strcmp($a['codigo'], $b['codigo']);
            });
            
            if (!empty($subcuentasIngresos)) {
                $cuentas[] = [
                    'id' => 1,
                    'codigo' => '100-00',
                    'nombre' => 'Ingresos',
                    'esPrincipal' => true,
                    'subcuentas' => $subcuentasIngresos
                ];
            }
            
            if (!empty($subcuentasEgresos)) {
                $cuentas[] = [
                    'id' => 2,
                    'codigo' => '200-00',
                    'nombre' => 'Egresos',
                    'esPrincipal' => true,
                    'subcuentas' => $subcuentasEgresos
                ];
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'cuentas' => $cuentas,
                    'meses' => $meses
                ],
                'totales_por_mes' => $totalesPorMes,
                'acumulados_por_cuenta' => $acumuladosPorCuenta
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getData flujo mensual: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => ['cuentas' => []]
            ], 500);
        }
    }

    /**
     * Obtener meses en el rango especificado
     */
    private function obtenerMesesEnRango($mesInicio, $mesFin)
    {
        $meses = [];
        
        list($anioInicio, $mesNumInicio) = explode('-', $mesInicio);
        list($anioFin, $mesNumFin) = explode('-', $mesFin);
        
        $fechaInicio = new \DateTime("$anioInicio-$mesNumInicio-01");
        $fechaFin = new \DateTime("$anioFin-$mesNumFin-01");
        
        if ($fechaFin < $fechaInicio) {
            // Intercambiar
            list($mesInicio, $mesFin) = [$mesFin, $mesInicio];
            list($anioInicio, $mesNumInicio) = explode('-', $mesInicio);
            list($anioFin, $mesNumFin) = explode('-', $mesFin);
            $fechaInicio = new \DateTime("$anioInicio-$mesNumInicio-01");
            $fechaFin = new \DateTime("$anioFin-$mesNumFin-01");
        }
        
        $fechaActual = clone $fechaInicio;
        
        while ($fechaActual <= $fechaFin) {
            $anio = $fechaActual->format('Y');
            $mesNum = $fechaActual->format('n');
            $clave = "$anio-$mesNum";
            
            // Primer día del mes
            $inicio = $fechaActual->format('Y-m-d');
            // Último día del mes
            $fin = (clone $fechaActual)->modify('last day of this month')->format('Y-m-d');
            
            $meses[] = [
                'clave' => $clave,
                'anio' => $anio,
                'mes_num' => $mesNum,
                'nombre' => $this->getNombreMes($mesNum),
                'nombre_corto' => $this->getNombreMesCorto($mesNum),
                'inicio' => $inicio,
                'fin' => $fin
            ];
            
            $fechaActual->modify('first day of next month');
        }
        
        return $meses;
    }

    /**
     * Obtener nombre del mes
     */
    private function getNombreMes($mesNum)
    {
        $nombres = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
        return $nombres[$mesNum] ?? '';
    }

    /**
     * Obtener nombre corto del mes
     */
    private function getNombreMesCorto($mesNum)
    {
        $nombres = [
            1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr',
            5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
            9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
        ];
        return $nombres[$mesNum] ?? '';
    }

    /**
     * Obtener categoría del movimiento
     */
    private function getCategoriaMovimiento($movimiento)
    {
        if ($movimiento->tipo === 'ingreso') {
            if (isset($movimiento->tipo_ingreso_id) && $movimiento->tipo_ingreso_id) {
                $tipoIngreso = TipoIngreso::find($movimiento->tipo_ingreso_id);
                return $tipoIngreso ? $tipoIngreso->nombre : 'Otros Ingresos';
            }
            if (isset($movimiento->concepto) && strpos($movimiento->concepto, 'Traspaso') !== false) {
                return 'Traspasos Entradas';
            }
            return 'Cobranza';
        } else {
            if (isset($movimiento->categoria_gasto_id) && $movimiento->categoria_gasto_id) {
                $categoria = CategoriaGasto::find($movimiento->categoria_gasto_id);
                return $categoria ? $categoria->nombre : 'Otros Gastos';
            }
            if (isset($movimiento->concepto)) {
                if (strpos($movimiento->concepto, 'Cheque') !== false || strpos($movimiento->concepto, 'Transferencia') !== false) {
                    return 'Traspasos Salidas';
                }
                if (strpos($movimiento->concepto, 'Pago') !== false) {
                    return 'Gastos Administrativos';
                }
            }
            return 'Costos Operativos';
        }
    }

    /**
     * Obtener código para la categoría
     */
    private function getCodigoCategoria($categoria)
    {
        $codigos = [
            'Cobranza' => '101-00',
            'Otros Ingresos' => '102-00',
            'Traspasos Entradas' => '103-00',
            'Costos Operativos' => '201-00',
            'Costos Indirectos Operación' => '202-00',
            'Costos Indirectos Mantenimiento' => '203-00',
            'Gastos Administrativos' => '204-00',
            'Arrendamientos' => '205-00',
            'Impuestos' => '206-00',
            'Traspasos Salidas' => '207-00',
            'Otros Gastos' => '299-00'
        ];
        
        return $codigos[$categoria] ?? '999-00';
    }

    /**
     * Exportar a Excel
     */
    public function exportarExcel(Request $request)
    {
        try {
            $mesInicio = $request->get('mes_inicio', '2026-2');
            $mesFin = $request->get('mes_fin', '2026-3');
            
            $meses = $this->obtenerMesesEnRango($mesInicio, $mesFin);
            
            $filename = "flujo_dinero_mensual_" . date('Y-m-d') . ".csv";
            $handle = fopen('php://temp', 'w');
            
            // Cabeceras
            $headers = ['Cuenta'];
            foreach ($meses as $mes) {
                $headers[] = $mes['nombre_corto'] . ' ' . $mes['anio'];
            }
            $headers[] = 'Acumulado';
            fputcsv($handle, $headers);
            
            // Obtener datos
            $movimientos = MovimientoBancario::all();
            
            // Agrupar por categoría y mes
            $datosPorCategoria = [];
            $acumulados = [];
            
            foreach ($movimientos as $mov) {
                $categoria = $this->getCategoriaMovimiento($mov);
                $codigo = $this->getCodigoCategoria($categoria);
                $fecha = new \DateTime($mov->fecha);
                $claveMes = $fecha->format('Y-n');
                
                if (!isset($datosPorCategoria[$codigo])) {
                    $datosPorCategoria[$codigo] = [
                        'nombre' => "$codigo - $categoria",
                        'meses' => []
                    ];
                    $acumulados[$codigo] = 0;
                }
                
                if (!isset($datosPorCategoria[$codigo]['meses'][$claveMes])) {
                    $datosPorCategoria[$codigo]['meses'][$claveMes] = 0;
                }
                
                $datosPorCategoria[$codigo]['meses'][$claveMes] += $mov->monto;
                $acumulados[$codigo] += $mov->monto;
            }
            
            // Ordenar por código
            ksort($datosPorCategoria);
            
            // Escribir datos
            foreach ($datosPorCategoria as $codigo => $data) {
                $fila = [$data['nombre']];
                foreach ($meses as $mes) {
                    $valor = $data['meses'][$mes['clave']] ?? 0;
                    $fila[] = '$' . number_format($valor, 2);
                }
                $fila[] = '$' . number_format($acumulados[$codigo], 2);
                fputcsv($handle, $fila);
            }
            
            rewind($handle);
            $csvContent = stream_get_contents($handle);
            fclose($handle);
            
            return response($csvContent, 200)
                ->header('Content-Type', 'text/csv; charset=UTF-8')
                ->header('Content-Disposition', "attachment; filename={$filename}");
                
        } catch (\Exception $e) {
            Log::error('Error exportando flujo mensual: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}