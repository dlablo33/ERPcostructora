<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuxiliarContableController extends Controller
{
    /**
     * Display auxiliar de cuenta contable.
     */
    public function index(Request $request)
    {
        // Obtener valores de los filtros
        $fechaInicio = $request->input('fecha_inicio', date('Y-m-01'));
        $fechaFin = $request->input('fecha_fin', date('Y-m-t'));
        $cuentaId = $request->input('cuenta_id', null);
        
        // ============================================
        // OBTENER LISTA DE CUENTAS CONTABLES ACTIVAS
        // ============================================
        $cuentas = DB::table('cuentas_contables')
            ->select('id', 'codigo', 'nombre', 'naturaleza')
            ->where('activa', true)
            ->orderBy('codigo')
            ->get();
        
        // Si no hay cuenta seleccionada y hay cuentas, tomar la primera
        if (empty($cuentaId) && $cuentas->isNotEmpty()) {
            $cuentaId = $cuentas->first()->id;
        }
        
        // ============================================
        // OBTENER DATOS DE LA CUENTA SELECCIONADA
        // ============================================
        $cuentaSeleccionada = null;
        $naturaleza = 'deudora'; // Por defecto
        $codigoCuenta = '';
        $nombreCuenta = '';
        
        if (!empty($cuentaId)) {
            $cuentaSeleccionada = DB::table('cuentas_contables')
                ->select('id', 'codigo', 'nombre', 'naturaleza')
                ->where('id', $cuentaId)
                ->first();
            
            if ($cuentaSeleccionada) {
                $naturaleza = $cuentaSeleccionada->naturaleza ?? 'deudora';
                $codigoCuenta = $cuentaSeleccionada->codigo ?? '';
                $nombreCuenta = $cuentaSeleccionada->nombre ?? '';
            }
        }
        
        // ============================================
        // CALCULAR SALDO INICIAL (antes de fecha inicio)
        // ============================================
        $saldoInicial = 0;
        
        if (!empty($cuentaId)) {
            $movimientosAnteriores = DB::table('movimientos_poliza as mp')
                ->join('polizas_contables as pc', 'mp.poliza_contable_id', '=', 'pc.poliza_contable_id')
                ->where('mp.cuenta_contable_id', $cuentaId)
                ->whereNull('pc.deleted_at')
                ->where('pc.fecha', '<', $fechaInicio)
                ->select(
                    DB::raw('COALESCE(SUM(mp.debe), 0) as total_debe'),
                    DB::raw('COALESCE(SUM(mp.haber), 0) as total_haber')
                )
                ->first();
            
            if ($naturaleza == 'deudora') {
                $saldoInicial = ($movimientosAnteriores->total_debe ?? 0) - ($movimientosAnteriores->total_haber ?? 0);
            } else {
                $saldoInicial = ($movimientosAnteriores->total_haber ?? 0) - ($movimientosAnteriores->total_debe ?? 0);
            }
        }
        
        // ============================================
        // OBTENER MOVIMIENTOS DEL PERÍODO
        // ============================================
        $movimientos = collect();
        $totalCargos = 0;
        $totalAbonos = 0;
        
        if (!empty($cuentaId)) {
            $movimientosRaw = DB::table('movimientos_poliza as mp')
                ->join('polizas_contables as pc', 'mp.poliza_contable_id', '=', 'pc.poliza_contable_id')
                ->leftJoin('proyectos as p', 'pc.proyecto_id', '=', 'p.id')
                ->where('mp.cuenta_contable_id', $cuentaId)
                ->whereNull('pc.deleted_at')
                ->whereBetween('pc.fecha', [$fechaInicio, $fechaFin])
                ->select(
                    'pc.fecha',
                    'pc.folio as poliza',
                    'pc.origen as modulo',
                    'pc.origen_id as folio_origen',
                    'pc.proyecto_id',
                    'mp.descripcion',
                    'mp.debe as cargo',
                    'mp.haber as abono',
                    'mp.id as movimiento_id',
                    'p.nombre as proyecto_nombre'
                )
                ->orderBy('pc.fecha', 'asc')
                ->orderBy('pc.poliza_contable_id', 'asc')  // CORREGIDO: usar poliza_contable_id en lugar de id
                ->get();
            
            // Calcular saldos corridos y totales
            $saldoCorrido = $saldoInicial;
            
            foreach ($movimientosRaw as $mov) {
                $cargo = floatval($mov->cargo ?? 0);
                $abono = floatval($mov->abono ?? 0);
                
                $totalCargos += $cargo;
                $totalAbonos += $abono;
                
                // Calcular saldo según naturaleza
                if ($naturaleza == 'deudora') {
                    $saldoCorrido = $saldoCorrido + $cargo - $abono;
                } else {
                    $saldoCorrido = $saldoCorrido + $abono - $cargo;
                }
                
                $movimientos->push((object)[
                    'fecha' => $mov->fecha,
                    'fecha_formateada' => $mov->fecha ? date('d/m/Y', strtotime($mov->fecha)) : '-',
                    'poliza' => $mov->poliza,
                    'modulo' => $mov->modulo ?? '-',
                    'folio_origen' => $mov->folio_origen ?? '-',
                    'descripcion' => $mov->descripcion ?? '-',
                    'cargo' => $cargo,
                    'abono' => $abono,
                    'cargo_formateado' => '$' . number_format($cargo, 2),
                    'abono_formateado' => '$' . number_format($abono, 2),
                    'saldo_actual' => $saldoCorrido,
                    'saldo_formateado' => '$' . number_format($saldoCorrido, 2),
                    'proyecto_nombre' => $mov->proyecto_nombre ?? '-',
                    'movimiento_id' => $mov->movimiento_id
                ]);
            }
        }
        
        // Calcular saldo final
        if ($naturaleza == 'deudora') {
            $saldoFinal = $saldoInicial + $totalCargos - $totalAbonos;
        } else {
            $saldoFinal = $saldoInicial + $totalAbonos - $totalCargos;
        }
        
        // ============================================
        // DATOS DE LA EMPRESA
        // ============================================
        $empresa = DB::table('datos_generales')
            ->select('razon_social', 'rfc')
            ->where('activo', true)
            ->first();
        
        $nombreEmpresa = $empresa->razon_social ?? 'EMPRESA DEMO';
        
        // ============================================
        // RETORNAR VISTA
        // ============================================
        return view('conta.catalogo.auxiliar', [
            'cuentas' => $cuentas,
            'cuentaId' => $cuentaId,
            'cuentaSeleccionada' => $cuentaSeleccionada,
            'codigoCuenta' => $codigoCuenta,
            'nombreCuenta' => $nombreCuenta,
            'naturaleza' => $naturaleza,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'saldoInicial' => $saldoInicial,
            'saldoInicialFormateado' => '$' . number_format($saldoInicial, 2),
            'totalCargos' => $totalCargos,
            'totalCargosFormateado' => '$' . number_format($totalCargos, 2),
            'totalAbonos' => $totalAbonos,
            'totalAbonosFormateado' => '$' . number_format($totalAbonos, 2),
            'saldoFinal' => $saldoFinal,
            'saldoFinalFormateado' => '$' . number_format($saldoFinal, 2),
            'movimientos' => $movimientos,
            'nombreEmpresa' => $nombreEmpresa,
            'totalRegistros' => $movimientos->count()
        ]);
    }
    
    /**
     * Exportar auxiliar a Excel
     */
    public function exportarExcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', date('Y-m-01'));
        $fechaFin = $request->input('fecha_fin', date('Y-m-t'));
        $cuentaId = $request->input('cuenta_id', null);
        
        // Obtener datos de la cuenta
        $cuenta = null;
        $naturaleza = 'deudora';
        
        if (!empty($cuentaId)) {
            $cuenta = DB::table('cuentas_contables')
                ->select('codigo', 'nombre', 'naturaleza')
                ->where('id', $cuentaId)
                ->first();
            
            if ($cuenta) {
                $naturaleza = $cuenta->naturaleza ?? 'deudora';
            }
        }
        
        // Calcular saldo inicial
        $saldoInicial = 0;
        if (!empty($cuentaId)) {
            $movimientosAnteriores = DB::table('movimientos_poliza as mp')
                ->join('polizas_contables as pc', 'mp.poliza_contable_id', '=', 'pc.poliza_contable_id')
                ->where('mp.cuenta_contable_id', $cuentaId)
                ->whereNull('pc.deleted_at')
                ->where('pc.fecha', '<', $fechaInicio)
                ->select(
                    DB::raw('COALESCE(SUM(mp.debe), 0) as total_debe'),
                    DB::raw('COALESCE(SUM(mp.haber), 0) as total_haber')
                )
                ->first();
            
            if ($naturaleza == 'deudora') {
                $saldoInicial = ($movimientosAnteriores->total_debe ?? 0) - ($movimientosAnteriores->total_haber ?? 0);
            } else {
                $saldoInicial = ($movimientosAnteriores->total_haber ?? 0) - ($movimientosAnteriores->total_debe ?? 0);
            }
        }
        
        // Obtener movimientos
        $movimientos = DB::table('movimientos_poliza as mp')
            ->join('polizas_contables as pc', 'mp.poliza_contable_id', '=', 'pc.poliza_contable_id')
            ->leftJoin('proyectos as p', 'pc.proyecto_id', '=', 'p.id')
            ->where('mp.cuenta_contable_id', $cuentaId)
            ->whereNull('pc.deleted_at')
            ->whereBetween('pc.fecha', [$fechaInicio, $fechaFin])
            ->select(
                'pc.fecha',
                'pc.folio as poliza',
                'pc.origen as modulo',
                'pc.origen_id as folio_origen',
                'mp.descripcion',
                'mp.debe as cargo',
                'mp.haber as abono',
                'p.nombre as proyecto_nombre'
            )
            ->orderBy('pc.fecha', 'asc')
            ->orderBy('pc.poliza_contable_id', 'asc')
            ->get();
        
        // Calcular saldos corridos
        $saldoCorrido = $saldoInicial;
        foreach ($movimientos as $mov) {
            if ($naturaleza == 'deudora') {
                $saldoCorrido = $saldoCorrido + ($mov->cargo - $mov->abono);
            } else {
                $saldoCorrido = $saldoCorrido + ($mov->abono - $mov->cargo);
            }
            $mov->saldo = $saldoCorrido;
        }
        
        $totalCargos = $movimientos->sum('cargo');
        $totalAbonos = $movimientos->sum('abono');
        
        if ($naturaleza == 'deudora') {
            $saldoFinal = $saldoInicial + $totalCargos - $totalAbonos;
        } else {
            $saldoFinal = $saldoInicial + $totalAbonos - $totalCargos;
        }
        
        $html = $this->generarExcel($movimientos, $cuenta, $fechaInicio, $fechaFin, $saldoInicial, $totalCargos, $totalAbonos, $saldoFinal);
        
        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="auxiliar_contable_' . date('Y-m-d') . '.xls"');
    }
    
    private function generarExcel($movimientos, $cuenta, $fechaInicio, $fechaFin, $saldoInicial, $totalCargos, $totalAbonos, $saldoFinal)
    {
        $codigoCuenta = $cuenta->codigo ?? '-';
        $nombreCuenta = $cuenta->nombre ?? '-';
        
        $html = '<html>
        <head>
            <meta charset="UTF-8">
            <title>Auxiliar Contable</title>
            <style>
                th { background-color: #083CAE; color: white; padding: 8px; border: 1px solid #ddd; }
                td { padding: 6px; border: 1px solid #ddd; }
                .text-right { text-align: right; }
                .text-center { text-align: center; }
            </style>
        </head>
        <body>
            <h2>Auxiliar de Cuenta Contable</h2>
            <h3>Cuenta: ' . e($codigoCuenta) . ' - ' . e($nombreCuenta) . '</h3>
            <p>Período: ' . date('d/m/Y', strtotime($fechaInicio)) . ' al ' . date('d/m/Y', strtotime($fechaFin)) . '</p>
            <table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Póliza</th>
                        <th>Módulo</th>
                        <th>Folio</th>
                        <th>Descripción</th>
                        <th>Proyecto</th>
                        <th>Cargo</th>
                        <th>Abono</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>';
        
        $html .= '<tr style="background:#e9ecef;">
                    <td colspan="6" class="text-right"><strong>SALDO INICIAL</strong></td>
                    <td class="text-right">-</td>
                    <td class="text-right">-</td>
                    <td class="text-right"><strong>$' . number_format($saldoInicial, 2) . '</strong></td>
                  </tr>';
        
        foreach ($movimientos as $mov) {
            $html .= '<tr>
                <td class="text-center">' . date('d/m/Y', strtotime($mov->fecha)) . '</td>
                <td class="text-center">' . e($mov->poliza) . '</td>
                <td class="text-left">' . e($mov->modulo ?? '-') . '</td>
                <td class="text-center">' . e($mov->folio_origen ?? '-') . '</td>
                <td class="text-left">' . e($mov->descripcion ?? '-') . '</td>
                <td class="text-left">' . e($mov->proyecto_nombre ?? '-') . '</td>
                <td class="text-right">' . ($mov->cargo > 0 ? '$'.number_format($mov->cargo,2) : '-') . '</td>
                <td class="text-right">' . ($mov->abono > 0 ? '$'.number_format($mov->abono,2) : '-') . '</td>
                <td class="text-right"><strong>$' . number_format($mov->saldo, 2) . '</strong></td>
            </tr>';
        }
        
        $html .= '<tr style="background:#e9ecef;">
                    <td colspan="6" class="text-right"><strong>TOTALES</strong></td>
                    <td class="text-right"><strong>$' . number_format($totalCargos, 2) . '</strong></td>
                    <td class="text-right"><strong>$' . number_format($totalAbonos, 2) . '</strong></td>
                    <td class="text-right"><strong>$' . number_format($saldoFinal, 2) . '</strong></td>
                  </tr>';
        
        $html .= '</tbody>
            </table>
        </body>
        </html>';
        
        return $html;
    }
}