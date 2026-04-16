<?php

namespace App\Http\Controllers;

use App\Models\MovimientoBancario;
use App\Models\CuentaBancaria;
use App\Models\CategoriaGasto;
use App\Models\TipoIngreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FlujoDineroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('administracion.tesoreria.flujos');
    }

    /**
     * Obtener datos del flujo de dinero por semana
     */
    public function getData(Request $request)
    {
        try {
            $semana = $request->get('semana', 3);
            $year = $request->get('year', date('Y'));
            
            // Calcular fechas de la semana
            $fechasSemana = $this->calcularFechasSemana($year, $semana);
            
            // Obtener movimientos por día - TEMPORALMENTE SIN FILTRO DE ESTADO
            $movimientos = MovimientoBancario::whereBetween('fecha', [$fechasSemana['inicio'], $fechasSemana['fin']])
                ->get();
            
            // Log para depuración
            Log::info('Movimientos encontrados: ' . $movimientos->count());
            
            // Agrupar por tipo y categoría
            $ingresos = [];
            $egresos = [];
            
            foreach ($movimientos as $mov) {
                $dia = strtolower(date('l', strtotime($mov->fecha)));
                $diaMap = [
                    'monday' => 'lunes',
                    'tuesday' => 'martes',
                    'wednesday' => 'miercoles',
                    'thursday' => 'jueves',
                    'friday' => 'viernes',
                    'saturday' => 'sabado',
                    'sunday' => 'domingo'
                ];
                $diaSemana = $diaMap[$dia] ?? 'lunes';
                
                $tipo = $mov->tipo; // 'ingreso' o 'egreso'
                $categoria = $this->getCategoriaMovimiento($mov);
                $codigo = $this->getCodigoCategoria($categoria);
                
                if ($tipo === 'ingreso') {
                    if (!isset($ingresos[$categoria])) {
                        $ingresos[$categoria] = [
                            'codigo' => $codigo,
                            'nombre' => $categoria,
                            'lunes' => 0, 'martes' => 0, 'miercoles' => 0,
                            'jueves' => 0, 'viernes' => 0, 'sabado' => 0, 'domingo' => 0
                        ];
                    }
                    $ingresos[$categoria][$diaSemana] += $mov->monto;
                } else {
                    if (!isset($egresos[$categoria])) {
                        $egresos[$categoria] = [
                            'codigo' => $codigo,
                            'nombre' => $categoria,
                            'lunes' => 0, 'martes' => 0, 'miercoles' => 0,
                            'jueves' => 0, 'viernes' => 0, 'sabado' => 0, 'domingo' => 0
                        ];
                    }
                    $egresos[$categoria][$diaSemana] += $mov->monto;
                }
            }
            
            // Construir respuesta
            $cuentas = [];
            
            if (!empty($ingresos)) {
                $subcuentasIngresos = [];
                foreach ($ingresos as $categoria => $datos) {
                    $subcuentasIngresos[] = [
                        'id' => rand(100, 199),
                        'codigo' => $datos['codigo'],
                        'nombre' => $datos['nombre'],
                        'lunes' => $datos['lunes'],
                        'martes' => $datos['martes'],
                        'miercoles' => $datos['miercoles'],
                        'jueves' => $datos['jueves'],
                        'viernes' => $datos['viernes'],
                        'sabado' => $datos['sabado'],
                        'domingo' => $datos['domingo']
                    ];
                }
                
                $cuentas[] = [
                    'id' => 1,
                    'codigo' => '100-00',
                    'nombre' => 'Ingresos',
                    'esPrincipal' => true,
                    'subcuentas' => $subcuentasIngresos
                ];
            }
            
            if (!empty($egresos)) {
                $subcuentasEgresos = [];
                foreach ($egresos as $categoria => $datos) {
                    $subcuentasEgresos[] = [
                        'id' => rand(200, 299),
                        'codigo' => $datos['codigo'],
                        'nombre' => $datos['nombre'],
                        'lunes' => $datos['lunes'],
                        'martes' => $datos['martes'],
                        'miercoles' => $datos['miercoles'],
                        'jueves' => $datos['jueves'],
                        'viernes' => $datos['viernes'],
                        'sabado' => $datos['sabado'],
                        'domingo' => $datos['domingo']
                    ];
                }
                
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
                'data' => ['cuentas' => $cuentas],
                'semana' => $semana,
                'rango' => $fechasSemana['inicio'] . ' - ' . $fechasSemana['fin']
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getData flujo dinero: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => ['cuentas' => []]
            ], 500);
        }
    }

    /**
     * Calcular fechas de una semana específica
     */
    private function calcularFechasSemana($year, $semanaNumero)
    {
        $fechaInicio = new \DateTime();
        $fechaInicio->setISODate($year, $semanaNumero, 1); // Lunes
        $fechaFin = clone $fechaInicio;
        $fechaFin->modify('+6 days'); // Domingo
        
        return [
            'inicio' => $fechaInicio->format('Y-m-d'),
            'fin' => $fechaFin->format('Y-m-d')
        ];
    }

    /**
     * Obtener categoría del movimiento
     */
    private function getCategoriaMovimiento($movimiento)
    {
        // Verificar si tiene relación con tipo_ingreso
        if ($movimiento->tipo === 'ingreso') {
            if (isset($movimiento->tipo_ingreso_id) && $movimiento->tipo_ingreso_id) {
                $tipoIngreso = TipoIngreso::find($movimiento->tipo_ingreso_id);
                return $tipoIngreso ? $tipoIngreso->nombre : 'Otros Ingresos';
            }
            // Revisar si hay una columna concepto que indique el tipo
            if (isset($movimiento->concepto) && strpos($movimiento->concepto, 'Traspaso') !== false) {
                return 'Traspasos Entradas';
            }
            return 'Cobranza';
        } else {
            if (isset($movimiento->categoria_gasto_id) && $movimiento->categoria_gasto_id) {
                $categoria = CategoriaGasto::find($movimiento->categoria_gasto_id);
                return $categoria ? $categoria->nombre : 'Otros Gastos';
            }
            // Revisar si hay una columna concepto que indique el tipo
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
            $semana = $request->get('semana', 3);
            $year = $request->get('year', date('Y'));
            
            $fechasSemana = $this->calcularFechasSemana($year, $semana);
            
            $movimientos = MovimientoBancario::whereBetween('fecha', [$fechasSemana['inicio'], $fechasSemana['fin']])
                ->get();
            
            $filename = "flujo_dinero_semana_{$semana}_{$year}.csv";
            $handle = fopen('php://temp', 'w');
            
            // Cabeceras
            fputcsv($handle, ['Fecha', 'Tipo', 'Categoría', 'Monto', 'Concepto', 'Referencia']);
            
            foreach ($movimientos as $mov) {
                fputcsv($handle, [
                    $mov->fecha,
                    ucfirst($mov->tipo),
                    $this->getCategoriaMovimiento($mov),
                    $mov->monto,
                    $mov->concepto ?? '',
                    $mov->referencia ?? ''
                ]);
            }
            
            rewind($handle);
            $csvContent = stream_get_contents($handle);
            fclose($handle);
            
            return response($csvContent, 200)
                ->header('Content-Type', 'text/csv; charset=UTF-8')
                ->header('Content-Disposition', "attachment; filename={$filename}");
                
        } catch (\Exception $e) {
            Log::error('Error exportando flujo dinero: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}