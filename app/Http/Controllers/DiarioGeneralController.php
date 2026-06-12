<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DiarioGeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // ============================================
            // PROYECTOS - Para el select de filtro
            // ============================================
            $proyectos = DB::table('proyectos')
                ->select('id', 'nombre', 'codigo')
                ->whereNull('deleted_at')
                ->orderBy('nombre')
                ->get();
            
            // ============================================
            // CUENTAS BANCARIAS - Para el select de filtro
            // ============================================
            $cuentasBancarias = DB::table('cuentas_bancarias as cb')
                ->leftJoin('bancos as b', 'cb.banco_id', '=', 'b.id')
                ->select(
                    'cb.id',
                    'cb.numero_cuenta',
                    'b.nombre as banco_nombre'
                )
                ->whereNull('cb.deleted_at')
                ->where('cb.activa', true)
                ->orderBy('cb.id')
                ->get()
                ->map(function($cuenta) {
                    $cuenta->nombre_display = ($cuenta->banco_nombre ?? 'Banco') . ' - ' . $cuenta->numero_cuenta;
                    return $cuenta;
                });
            
            // ============================================
            // FECHAS
            // ============================================
            $fechaInicio = $request->get('fecha_inicio', date('Y-01-01'));
            $fechaFin = $request->get('fecha_fin', date('Y-m-t'));
            
            // ============================================
            // CONSULTA PRINCIPAL DEL DIARIO GENERAL
            // ============================================
            $query = DB::table('polizas_contables as pc')
                ->join('movimientos_poliza as mp', 'pc.poliza_contable_id', '=', 'mp.poliza_contable_id')
                ->leftJoin('cuentas_contables as cc', 'mp.cuenta_contable_id', '=', 'cc.id')
                ->leftJoin('proyectos as p', 'pc.proyecto_id', '=', 'p.id')
                ->select(
                    'mp.id as movimiento_id',
                    'pc.fecha',
                    'pc.folio as poliza',
                    'pc.tipo_poliza',
                    'pc.concepto as poliza_concepto',
                    'pc.proyecto_id',
                    'mp.debe',
                    'mp.haber',
                    'mp.descripcion as movimiento_descripcion',
                    'cc.codigo as cuenta_codigo',
                    'cc.nombre as cuenta_nombre',
                    'p.nombre as proyecto_nombre',
                    'p.codigo as proyecto_codigo'
                )
                ->whereNull('pc.deleted_at')
                ->whereBetween('pc.fecha', [$fechaInicio, $fechaFin]);
            
            // Aplicar filtro por proyecto
            if ($request->filled('proyecto_id')) {
                $query->where('pc.proyecto_id', $request->proyecto_id);
            }
            
            // Aplicar filtro por cuenta bancaria
            if ($request->filled('cuenta_bancaria_id')) {
                $query->whereExists(function($q) use ($request) {
                    $q->select(DB::raw(1))
                      ->from('cuentas_bancarias as cb')
                      ->whereRaw('cb.cuenta_contable_id = cc.id')
                      ->where('cb.id', $request->cuenta_bancaria_id);
                });
            }
            
            // Aplicar búsqueda general
            if ($request->filled('search')) {
                $search = '%' . $request->search . '%';
                $query->where(function($q) use ($search) {
                    $q->where('pc.folio', 'LIKE', $search)
                      ->orWhere('pc.concepto', 'LIKE', $search)
                      ->orWhere('mp.descripcion', 'LIKE', $search)
                      ->orWhere('cc.codigo', 'LIKE', $search)
                      ->orWhere('cc.nombre', 'LIKE', $search)
                      ->orWhere('p.nombre', 'LIKE', $search);
                });
            }
            
            // Ejecutar consulta y ordenar
            $movimientosRaw = $query->orderBy('pc.fecha', 'desc')
                                   ->orderBy('pc.id', 'desc')
                                   ->get();
            
            // Transformar datos al formato que espera la vista
            $movimientos = collect();
            foreach ($movimientosRaw as $mov) {
                // Determinar tipo de movimiento
                if ($mov->debe > 0) {
                    $tipo = 'Ingreso';
                    $badgeClass = 'badge-ingreso';
                } elseif ($mov->haber > 0) {
                    $tipo = 'Egreso';
                    $badgeClass = 'badge-egreso';
                } else {
                    $tipo = 'Diario';
                    $badgeClass = 'badge-diario';
                }
                
                $movimientos->push((object)[
                    'id' => $mov->movimiento_id,
                    'fecha' => $mov->fecha,
                    'fecha_formateada' => $mov->fecha ? date('d/m/Y', strtotime($mov->fecha)) : '-',
                    'poliza' => $mov->poliza,
                    'poliza_id' => $mov->poliza,
                    'tipo_poliza' => $mov->tipo_poliza,
                    'cuenta' => $mov->cuenta_codigo ?? '-',
                    'nombre_cuenta' => $mov->cuenta_nombre ?? '-',
                    'concepto' => $mov->movimiento_descripcion ?? $mov->poliza_concepto ?? '-',
                    'cargo' => floatval($mov->debe ?? 0),
                    'abono' => floatval($mov->haber ?? 0),
                    'tipo' => $tipo,
                    'badge_class' => $badgeClass,
                    'proyecto_id' => $mov->proyecto_id,
                    'proyecto_nombre' => $mov->proyecto_nombre,
                    'proyecto_codigo' => $mov->proyecto_codigo,
                ]);
            }
            
            // Calcular estadísticas
            $totalPolizas = $movimientos->unique('poliza_id')->count();
            $totalCargos = $movimientos->sum('cargo');
            $totalAbonos = $movimientos->sum('abono');
            
            $estadisticas = (object)[
                'total_polizas' => $totalPolizas,
                'polizas_mes' => $movimientos->count(),
                'total_cargos' => $totalCargos,
                'total_cargos_formateado' => '$' . number_format($totalCargos, 2),
                'total_abonos' => $totalAbonos,
                'total_abonos_formateado' => '$' . number_format($totalAbonos, 2),
            ];
            
            // Retornar vista con todos los datos
            return view('conta.registros.diario', [
                'movimientos' => $movimientos,
                'estadisticas' => $estadisticas,
                'proyectos' => $proyectos,
                'cuentasBancarias' => $cuentasBancarias,
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en DiarioGeneralController@index: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Retornar vista con datos vacíos en caso de error
            return view('conta.registros.diario', [
                'movimientos' => collect(),
                'estadisticas' => (object)[
                    'total_polizas' => 0,
                    'polizas_mes' => 0,
                    'total_cargos_formateado' => '$0.00',
                    'total_abonos_formateado' => '$0.00'
                ],
                'proyectos' => collect(),
                'cuentasBancarias' => collect(),
                'fechaInicio' => date('Y-m-01'),
                'fechaFin' => date('Y-m-t')
            ]);
        }
    }
    
    /**
     * Exportar a Excel
     */
    public function exportarExcel(Request $request)
    {
        try {
            $fechaInicio = $request->get('fecha_inicio', date('Y-01-01'));
            $fechaFin = $request->get('fecha_fin', date('Y-m-t'));
            
            $query = DB::table('polizas_contables as pc')
                ->join('movimientos_poliza as mp', 'pc.poliza_contable_id', '=', 'mp.poliza_contable_id')
                ->leftJoin('cuentas_contables as cc', 'mp.cuenta_contable_id', '=', 'cc.id')
                ->leftJoin('proyectos as p', 'pc.proyecto_id', '=', 'p.id')
                ->select(
                    'pc.fecha',
                    'pc.folio as poliza',
                    'cc.codigo as cuenta_codigo',
                    'cc.nombre as cuenta_nombre',
                    'mp.descripcion as concepto',
                    'mp.debe',
                    'mp.haber',
                    'p.nombre as proyecto_nombre'
                )
                ->whereNull('pc.deleted_at')
                ->whereBetween('pc.fecha', [$fechaInicio, $fechaFin]);
            
            if ($request->filled('proyecto_id')) {
                $query->where('pc.proyecto_id', $request->proyecto_id);
            }
            
            if ($request->filled('cuenta_bancaria_id')) {
                $query->whereExists(function($q) use ($request) {
                    $q->select(DB::raw(1))
                      ->from('cuentas_bancarias as cb')
                      ->whereRaw('cb.cuenta_contable_id = cc.id')
                      ->where('cb.id', $request->cuenta_bancaria_id);
                });
            }
            
            $movimientos = $query->orderBy('pc.fecha', 'desc')->get();
            
            // Generar HTML para Excel
            $html = $this->generarHTMLExcel($movimientos);
            
            return response($html)
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename="diario_general_' . date('Y-m-d_His') . '.xls"');
                
        } catch (\Exception $e) {
            Log::error('Error al exportar Excel: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al exportar: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Genera HTML para exportar a Excel
     */
    private function generarHTMLExcel($movimientos)
    {
        $totalCargos = $movimientos->sum('debe');
        $totalAbonos = $movimientos->sum('haber');
        
        $html = '<html>
        <head>
            <meta charset="UTF-8">
            <title>Diario General</title>
            <style>
                th { background-color: #083CAE; color: white; padding: 8px; border: 1px solid #ddd; }
                td { padding: 6px; border: 1px solid #ddd; }
                .text-right { text-align: right; }
                .text-center { text-align: center; }
            </style>
        </head>
        <body>
            <h2>Diario General</h2>
            <p>Generado el: ' . date('d/m/Y H:i:s') . '</p>
            <table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Póliza</th>
                        <th>Cuenta</th>
                        <th>Nombre Cuenta</th>
                        <th>Concepto</th>
                        <th>Cargo</th>
                        <th>Abono</th>
                        <th>Proyecto</th>
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($movimientos as $mov) {
            $fecha = $mov->fecha ? date('d/m/Y', strtotime($mov->fecha)) : '-';
            $cargo = $mov->debe > 0 ? '$' . number_format($mov->debe, 2) : '-';
            $abono = $mov->haber > 0 ? '$' . number_format($mov->haber, 2) : '-';
            
            $html .= '<tr>
                <td class="text-center">' . e($fecha) . '</td>
                <td class="text-center">' . e($mov->poliza) . '</td>
                <td>' . e($mov->cuenta_codigo ?? '-') . '</td>
                <td>' . e($mov->cuenta_nombre ?? '-') . '</td>
                <td>' . e($mov->concepto ?? '-') . '</td>
                <td class="text-right">' . $cargo . '</td>
                <td class="text-right">' . $abono . '</td>
                <td>' . e($mov->proyecto_nombre ?? '-') . '</td>
            </tr>';
        }
        
        $html .= '</tbody>
                <tfoot>
                    <tr>
                        <td colspan="5"><strong>TOTALES</strong></td>
                        <td class="text-right"><strong>$' . number_format($totalCargos, 2) . '</strong></td>
                        <td class="text-right"><strong>$' . number_format($totalAbonos, 2) . '</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </body>
        </html>';
        
        return $html;
    }
    
    /**
     * Obtener detalles de un movimiento específico
     */
    public function show($id)
    {
        try {
            $movimiento = DB::table('polizas_contables as pc')
                ->join('movimientos_poliza as mp', 'pc.poliza_contable_id', '=', 'mp.poliza_contable_id')
                ->leftJoin('cuentas_contables as cc', 'mp.cuenta_contable_id', '=', 'cc.id')
                ->leftJoin('proyectos as p', 'pc.proyecto_id', '=', 'p.id')
                ->select(
                    'mp.id',
                    'pc.folio',
                    'pc.fecha',
                    'pc.tipo_poliza',
                    'pc.concepto',
                    'mp.debe',
                    'mp.haber',
                    'mp.descripcion',
                    'cc.codigo as cuenta_codigo',
                    'cc.nombre as cuenta_nombre',
                    'p.nombre as proyecto_nombre'
                )
                ->where('mp.id', $id)
                ->first();
            
            if ($movimiento) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'folio' => $movimiento->folio,
                        'fecha' => date('d/m/Y', strtotime($movimiento->fecha)),
                        'tipo' => $movimiento->tipo_poliza ?? 'Diario',
                        'proyecto' => $movimiento->proyecto_nombre ?? 'Sin proyecto',
                        'concepto' => $movimiento->concepto ?? '-',
                        'descripcion' => $movimiento->descripcion ?? '-',
                        'cuenta' => ($movimiento->cuenta_codigo ? $movimiento->cuenta_codigo . ' - ' : '') . ($movimiento->cuenta_nombre ?? 'Sin cuenta'),
                        'debe' => number_format($movimiento->debe, 2),
                        'haber' => number_format($movimiento->haber, 2)
                    ]
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Movimiento no encontrado'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener estadísticas en tiempo real para AJAX
     */
    public function estadisticas(Request $request)
    {
        try {
            $fechaInicio = $request->get('fecha_inicio', date('Y-01-01'));
            $fechaFin = $request->get('fecha_fin', date('Y-m-t'));
            
            $query = DB::table('polizas_contables as pc')
                ->join('movimientos_poliza as mp', 'pc.poliza_contable_id', '=', 'mp.poliza_contable_id')
                ->leftJoin('cuentas_contables as cc', 'mp.cuenta_contable_id', '=', 'cc.id')
                ->whereNull('pc.deleted_at')
                ->whereBetween('pc.fecha', [$fechaInicio, $fechaFin]);
            
            if ($request->filled('proyecto_id')) {
                $query->where('pc.proyecto_id', $request->proyecto_id);
            }
            
            if ($request->filled('cuenta_bancaria_id')) {
                $query->whereExists(function($q) use ($request) {
                    $q->select(DB::raw(1))
                      ->from('cuentas_bancarias as cb')
                      ->whereRaw('cb.cuenta_contable_id = cc.id')
                      ->where('cb.id', $request->cuenta_bancaria_id);
                });
            }
            
            $movimientos = $query->get();
            
            $totalPolizas = $movimientos->unique('poliza_contable_id')->count();
            $totalCargos = $movimientos->sum('debe');
            $totalAbonos = $movimientos->sum('haber');
            
            return response()->json([
                'success' => true,
                'data' => [
                    'total_polizas' => $totalPolizas,
                    'polizas_mes' => $movimientos->count(),
                    'total_cargos_formateado' => '$' . number_format($totalCargos, 2),
                    'total_abonos_formateado' => '$' . number_format($totalAbonos, 2)
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}