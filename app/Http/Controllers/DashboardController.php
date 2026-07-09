<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Proyecto;
use App\Models\ProyectoCosto;
use App\Models\ProyectoPartida;
use App\Models\Plantilla;
use App\Models\Activo;
use App\Models\Contratista;
use App\Models\Nomina;
use App\Models\Facturacion\Factura;
use App\Models\Pago;
use App\Models\MovimientoBancario;
use App\Models\CuentaBancaria;
use App\Models\InventarioProyecto;
use App\Models\Hito;
use App\Models\BitacoraEntry;
use App\Models\Licitacion;
use App\Models\AsignacionPersonal;
use App\Models\CostoDirecto;
use App\Models\CostoIndirecto;
use App\Models\Cotizacion;
use App\Models\Deposito;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // ============================================
    // CONSTANTES DE ESTATUS DE FACTURAS
    // ============================================
    const ESTATUS_EMITIDA = 1;
    const ESTATUS_PAGADA = 2;
    const ESTATUS_CANCELADA = 3;
    const ESTATUS_TIMBRADA = 4;
    const ESTATUS_PENDIENTE = 5;

    /**
     * Vista principal del dashboard
     */
    public function index()
    {
        return view('bi.dashboard.dashboard');
    }

    /**
     * Obtener lista de proyectos para filtros
     */
    public function getProyectosList(Request $request)
    {
        try {
            $proyectos = Proyecto::select('id', 'codigo', 'nombre', 'status')
                ->orderBy('nombre')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $proyectos
            ]);
        } catch (\Exception $e) {
            \Log::error('Error en getProyectosList: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Dashboard completo con filtros por proyecto
     */
    public function getDashboardCompleto(Request $request)
    {
        try {
            $periodo = $request->get('periodo', 'mes');
            $proyectoIds = $request->get('proyecto_ids', []);
            $incluirPresupuesto = $request->get('incluir_presupuesto', 'true') === 'true';
            
            if (empty($proyectoIds) || (count($proyectoIds) === 1 && $proyectoIds[0] === 'all')) {
                $proyectoIds = Proyecto::pluck('id')->toArray();
            }

            if (empty($proyectoIds)) {
                $proyectoIds = Proyecto::pluck('id')->toArray();
            }

            $finanzas = $this->getFinanzas($proyectoIds, $periodo);
            $estadoResultados = $this->getEstadoResultadosData($proyectoIds, $periodo, $incluirPresupuesto);
            $flujoEfectivo = $this->getFlujoEfectivoData($proyectoIds, $periodo);

            return response()->json([
                'success' => true,
                'data' => [
                    'periodo' => $periodo,
                    'proyectos_seleccionados' => $proyectoIds,
                    'timestamp' => now()->toISOString(),
                    'resumen' => $this->getResumenGeneral($proyectoIds, $periodo),
                    'proyectos' => $this->getResumenProyectos($proyectoIds),
                    'contratistas' => $this->getResumenContratistas($proyectoIds),
                    'finanzas' => $finanzas,
                    'estado_resultados' => $estadoResultados,
                    'flujo_efectivo' => $flujoEfectivo,
                    'nomina' => $this->getNominaResumen($proyectoIds, $periodo),
                    'maquinaria' => $this->getMaquinariaEstado($proyectoIds),
                    'inventario' => $this->getResumenInventario($proyectoIds),
                    'bitacora' => $this->getResumenBitacora($proyectoIds, $periodo),
                    'ventas' => $this->getVentasTendenciaData($proyectoIds, $periodo),
                    'alertas' => $this->getAlertasSistema($proyectoIds)
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getDashboardCompleto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Resumen general (KPIs principales)
     */
    private function getResumenGeneral($proyectoIds, $periodo)
    {
        try {
            $totalProyectos = Proyecto::whereIn('id', $proyectoIds)->count();
            $proyectosActivos = Proyecto::whereIn('id', $proyectoIds)
                ->where(function($q) {
                    $q->where('status', 'activo')
                      ->orWhere('estado', 'activo')
                      ->orWhere('estado', 'en_progreso');
                })
                ->count();

            $totalContratistas = Contratista::count();
            $contratistasActivos = Contratista::where('activo', true)->count();

            // ✅ Usar DB::table para facturas
            $facturacionMes = DB::table('facturas')
                ->whereIn('proyecto_id', $proyectoIds)
                ->whereMonth('fecha', now()->month)
                ->whereYear('fecha', now()->year)
                ->where('estatus', '!=', self::ESTATUS_CANCELADA)
                ->sum('total');

            $ingresos = DB::table('facturas')
                ->whereIn('proyecto_id', $proyectoIds)
                ->where('estatus', '!=', self::ESTATUS_CANCELADA)
                ->sum('total');
            
            $costos = ProyectoCosto::whereIn('proyecto_id', $proyectoIds)
                ->sum(DB::raw('COALESCE(materiales, 0) + COALESCE(mano_obra, 0) + COALESCE(maquinaria, 0) + COALESCE(gastos_indirectos, 0) + COALESCE(subcontratos, 0)'));
            
            $utilidad = $ingresos - $costos;
            $rentabilidad = $ingresos > 0 ? round(($utilidad / $ingresos) * 100, 1) : 0;

            return [
                'proyectos' => [
                    'total' => $totalProyectos,
                    'activos' => $proyectosActivos
                ],
                'contratistas' => [
                    'total' => $totalContratistas,
                    'activos' => $contratistasActivos
                ],
                'facturacion_mes' => (float) $facturacionMes,
                'rentabilidad' => $rentabilidad,
                'utilidad' => (float) $utilidad
            ];

        } catch (\Exception $e) {
            \Log::error('Error en getResumenGeneral: ' . $e->getMessage());
            return [
                'proyectos' => ['total' => 0, 'activos' => 0],
                'contratistas' => ['total' => 0, 'activos' => 0],
                'facturacion_mes' => 0,
                'rentabilidad' => 0,
                'utilidad' => 0
            ];
        }
    }

    /**
     * Resumen de proyectos con filtro
     */
    private function getResumenProyectos($proyectoIds)
    {
        try {
            $total = Proyecto::whereIn('id', $proyectoIds)->count();
            $activos = Proyecto::whereIn('id', $proyectoIds)
                ->where(function($q) {
                    $q->where('status', 'activo')
                      ->orWhere('estado', 'activo')
                      ->orWhere('estado', 'en_progreso');
                })
                ->count();
            $finalizados = Proyecto::whereIn('id', $proyectoIds)
                ->where(function($q) {
                    $q->where('status', 'completado')
                      ->orWhere('estado', 'finalizado');
                })
                ->count();
            $enProgreso = Proyecto::whereIn('id', $proyectoIds)
                ->where('estado', 'en_progreso')
                ->count();
            $cancelados = Proyecto::whereIn('id', $proyectoIds)
                ->where('estado', 'cancelado')
                ->count();

            $presupuestoTotal = (float) Proyecto::whereIn('id', $proyectoIds)->sum('presupuesto_total');
            $presupuestoActivo = (float) Proyecto::whereIn('id', $proyectoIds)
                ->where(function($q) {
                    $q->where('status', 'activo')
                      ->orWhere('estado', 'activo')
                      ->orWhere('estado', 'en_progreso');
                })
                ->sum('presupuesto_total');

            $topProyectos = Proyecto::whereIn('id', $proyectoIds)
                ->orderBy('presupuesto_total', 'desc')
                ->limit(5)
                ->get(['id', 'codigo', 'nombre', 'presupuesto_total', 'status']);

            return [
                'total' => $total,
                'activos' => $activos,
                'finalizados' => $finalizados,
                'en_progreso' => $enProgreso,
                'cancelados' => $cancelados,
                'presupuesto_total' => $presupuestoTotal,
                'presupuesto_activo' => $presupuestoActivo,
                'top_proyectos' => $topProyectos,
                'tasa_actividad' => $total > 0 ? round(($activos / $total) * 100, 1) : 0
            ];

        } catch (\Exception $e) {
            \Log::error('Error en getResumenProyectos: ' . $e->getMessage());
            return [
                'total' => 0,
                'activos' => 0,
                'finalizados' => 0,
                'en_progreso' => 0,
                'cancelados' => 0,
                'presupuesto_total' => 0,
                'presupuesto_activo' => 0,
                'top_proyectos' => [],
                'tasa_actividad' => 0
            ];
        }
    }

    /**
     * Resumen de contratistas con filtro por proyecto
     */
    private function getResumenContratistas($proyectoIds)
    {
        try {
            $total = Contratista::count();
            $activos = Contratista::where('activo', true)->count();
            $inactivos = $total - $activos;
            
            $riesgoAlto = Contratista::where('nivel_riesgo', 'alto')->count();
            $riesgoMedio = Contratista::where('nivel_riesgo', 'medio')->count();
            $riesgoBajo = Contratista::where('nivel_riesgo', 'bajo')->count();

            $contratistasEnProyectos = DB::table('asignaciones_contratistas')
                ->whereIn('proyecto_id', $proyectoIds)
                ->whereIn('status', ['asignado', 'en_progreso'])
                ->distinct('contratista_id')
                ->count('contratista_id');

            $especialidades = Contratista::select('especialidad', DB::raw('count(*) as total'))
                ->whereNotNull('especialidad')
                ->groupBy('especialidad')
                ->get();

            $calificacionPromedio = (float) Contratista::avg('calificacion');

            $topCalificacion = Contratista::whereNotNull('calificacion')
                ->orderBy('calificacion', 'desc')
                ->limit(5)
                ->get(['id', 'nombre_comercial', 'especialidad', 'calificacion']);

            $presupuestoAsignado = (float) DB::table('asignaciones_contratistas')
                ->whereIn('proyecto_id', $proyectoIds)
                ->sum('presupuesto_asignado');
            
            $gastoTotal = (float) DB::table('asignaciones_contratistas')
                ->whereIn('proyecto_id', $proyectoIds)
                ->sum('gasto_acumulado');
            
            $saldoTotal = $presupuestoAsignado - $gastoTotal;

            return [
                'total' => $total,
                'activos' => $activos,
                'inactivos' => $inactivos,
                'riesgo_alto' => $riesgoAlto,
                'riesgo_medio' => $riesgoMedio,
                'riesgo_bajo' => $riesgoBajo,
                'en_proyectos' => $contratistasEnProyectos,
                'especialidades' => $especialidades,
                'calificacion_promedio' => round($calificacionPromedio, 1),
                'top_calificacion' => $topCalificacion,
                'presupuesto_asignado' => $presupuestoAsignado,
                'gasto_total' => $gastoTotal,
                'saldo_total' => $saldoTotal
            ];

        } catch (\Exception $e) {
            \Log::error('Error en getResumenContratistas: ' . $e->getMessage());
            return [
                'total' => 0,
                'activos' => 0,
                'inactivos' => 0,
                'riesgo_alto' => 0,
                'riesgo_medio' => 0,
                'riesgo_bajo' => 0,
                'en_proyectos' => 0,
                'especialidades' => [],
                'calificacion_promedio' => 0,
                'top_calificacion' => [],
                'presupuesto_asignado' => 0,
                'gasto_total' => 0,
                'saldo_total' => 0
            ];
        }
    }

    /**
     * Finanzas con filtro por proyecto
     * 🔥 CORREGIDO - Usa DB::table para todas las consultas
     */
    private function getFinanzas($proyectoIds, $periodo)
    {
        try {
            $today = Carbon::now();
            
            // ========== CUENTAS POR PAGAR ==========
            // ✅ Usar DB::table en lugar de Pago::where
            $queryPagos = DB::table('pagos')->where('estatus', 'pendiente');
            
            if (!empty($proyectoIds)) {
                $queryPagos->whereIn('proyecto_id', $proyectoIds);
            }
            
            $pagosPendientes = $queryPagos->get();

            $antiguedadPagar = ['0-30' => 0, '31-60' => 0, '61-90' => 0, '91+' => 0];
            $totalPagar = 0;

            foreach ($pagosPendientes as $pago) {
                $monto = (float) $pago->monto;
                $totalPagar += $monto;

                if ($pago->fecha_pago) {
                    try {
                        $fechaPago = Carbon::parse($pago->fecha_pago);
                        $fechaVenc = $fechaPago->copy()->addDays(30);
                        
                        if ($fechaVenc->isFuture()) {
                            $antiguedadPagar['0-30'] += $monto;
                        } else {
                            $dias = $fechaVenc->diffInDays($today);
                            if ($dias <= 30) {
                                $antiguedadPagar['0-30'] += $monto;
                            } elseif ($dias <= 60) {
                                $antiguedadPagar['31-60'] += $monto;
                            } elseif ($dias <= 90) {
                                $antiguedadPagar['61-90'] += $monto;
                            } else {
                                $antiguedadPagar['91+'] += $monto;
                            }
                        }
                    } catch (\Exception $e) {
                        $antiguedadPagar['0-30'] += $monto;
                    }
                } else {
                    $antiguedadPagar['0-30'] += $monto;
                }
            }

            // ========== CUENTAS POR COBRAR ==========
            // ✅ Usar DB::table en lugar de Factura::where
            $queryFacturas = DB::table('facturas')
                ->where('total', '>', 0)
                ->where('saldo_disponible', '>', 0);
            
            if (!empty($proyectoIds)) {
                $queryFacturas->whereIn('proyecto_id', $proyectoIds);
            }
            
            $facturasPendientes = $queryFacturas->get();

            $antiguedadCobrar = ['corriente' => 0, '30-60' => 0, '61-90' => 0, '91-120' => 0, '120+' => 0];
            $totalCobrar = 0;

            foreach ($facturasPendientes as $factura) {
                $monto = (float) ($factura->saldo_disponible ?? $factura->total ?? 0);
                $totalCobrar += $monto;

                if ($factura->fecha_vencimiento) {
                    try {
                        $fechaVenc = Carbon::parse($factura->fecha_vencimiento);
                        
                        if ($fechaVenc->isFuture()) {
                            $antiguedadCobrar['corriente'] += $monto;
                        } else {
                            $dias = $fechaVenc->diffInDays($today);
                            if ($dias <= 30) {
                                $antiguedadCobrar['30-60'] += $monto;
                            } elseif ($dias <= 60) {
                                $antiguedadCobrar['30-60'] += $monto;
                            } elseif ($dias <= 90) {
                                $antiguedadCobrar['61-90'] += $monto;
                            } elseif ($dias <= 120) {
                                $antiguedadCobrar['91-120'] += $monto;
                            } else {
                                $antiguedadCobrar['120+'] += $monto;
                            }
                        }
                    } catch (\Exception $e) {
                        $antiguedadCobrar['corriente'] += $monto;
                    }
                } else {
                    $antiguedadCobrar['corriente'] += $monto;
                }
            }

            // ========== RENTABILIDAD ==========
            // ✅ Usar DB::table en lugar de Factura::where
            $queryIngresos = DB::table('facturas')
                ->where('estatus', '!=', self::ESTATUS_CANCELADA);
                
            if (!empty($proyectoIds)) {
                $queryIngresos->whereIn('proyecto_id', $proyectoIds);
            }
            $ingresos = (float) $queryIngresos->sum('total');

            // ✅ Usar DB::table en lugar de ProyectoCosto::where
            $queryCostos = DB::table('proyecto_costos');
            if (!empty($proyectoIds)) {
                $queryCostos->whereIn('proyecto_id', $proyectoIds);
            }
            
            // Verificar si la tabla tiene las columnas necesarias
            $costos = 0;
            try {
                $costos = (float) $queryCostos->sum(DB::raw('COALESCE(materiales, 0) + COALESCE(mano_obra, 0) + COALESCE(maquinaria, 0) + COALESCE(gastos_indirectos, 0) + COALESCE(subcontratos, 0)'));
            } catch (\Exception $e) {
                // Si hay error, usar sum simple
                $costos = (float) $queryCostos->sum('materiales') + 
                          (float) $queryCostos->sum('mano_obra') +
                          (float) $queryCostos->sum('maquinaria') +
                          (float) $queryCostos->sum('gastos_indirectos') +
                          (float) $queryCostos->sum('subcontratos');
            }

            $utilidad = $ingresos - $costos;
            $margen = $ingresos > 0 ? round(($utilidad / $ingresos) * 100, 1) : 0;

            // Rentabilidad por proyecto
            $rentabilidadProyectos = [];
            $queryProyectos = Proyecto::query();
            if (!empty($proyectoIds)) {
                $queryProyectos->whereIn('id', $proyectoIds);
            }
            $proyectos = $queryProyectos->limit(10)->get();
            
            foreach ($proyectos as $proyecto) {
                $ingresoProyecto = (float) DB::table('facturas')
                    ->where('proyecto_id', $proyecto->id)
                    ->where('estatus', '!=', self::ESTATUS_CANCELADA)
                    ->sum('total');
                
                $costoProyecto = (float) DB::table('proyecto_costos')
                    ->where('proyecto_id', $proyecto->id)
                    ->sum(DB::raw('COALESCE(materiales, 0) + COALESCE(mano_obra, 0) + COALESCE(maquinaria, 0) + COALESCE(gastos_indirectos, 0) + COALESCE(subcontratos, 0)'));
                
                $margenProyecto = $ingresoProyecto > 0 ? round((($ingresoProyecto - $costoProyecto) / $ingresoProyecto) * 100, 1) : 0;
                
                $rentabilidadProyectos[] = [
                    'nombre' => $proyecto->nombre,
                    'ingresos' => $ingresoProyecto,
                    'margen' => $margenProyecto
                ];
            }

            usort($rentabilidadProyectos, function($a, $b) {
                return $b['margen'] <=> $a['margen'];
            });

            return [
                'cuentas_pagar' => [
                    'total' => $totalPagar,
                    'antiguedad' => $antiguedadPagar
                ],
                'cuentas_cobrar' => [
                    'total' => $totalCobrar,
                    'antiguedad' => $antiguedadCobrar
                ],
                'rentabilidad' => [
                    'margen' => $margen,
                    'utilidad' => $utilidad,
                    'proyectos' => $rentabilidadProyectos
                ]
            ];

        } catch (\Exception $e) {
            \Log::error('Error en getFinanzas: ' . $e->getMessage());
            return [
                'cuentas_pagar' => ['total' => 0, 'antiguedad' => ['0-30' => 0, '31-60' => 0, '61-90' => 0, '91+' => 0]],
                'cuentas_cobrar' => ['total' => 0, 'antiguedad' => ['corriente' => 0, '30-60' => 0, '61-90' => 0, '91-120' => 0, '120+' => 0]],
                'rentabilidad' => ['margen' => 0, 'utilidad' => 0, 'proyectos' => []]
            ];
        }
    }

    /**
     * Estado de Resultados con datos REALES y PRESUPUESTADOS
     */
    private function getEstadoResultadosData($proyectoIds, $periodo, $incluirPresupuesto = true)
    {
        try {
            $fechaInicio = $this->getFechaInicio($periodo);
            $fechaFin = Carbon::now();

            // ========== INGRESOS REALES ==========
            // ✅ Usar DB::table en lugar de Factura::where
            $ingresosReal = (float) DB::table('facturas')
                ->whereIn('proyecto_id', $proyectoIds)
                ->where('estatus', '!=', self::ESTATUS_CANCELADA)
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->sum('total');

            // ========== COSTOS DIRECTOS REALES ==========
            // ✅ Usar DB::table en lugar de ProyectoCosto::where
            $queryCostosDirectos = DB::table('proyecto_costos')
                ->whereIn('proyecto_id', $proyectoIds)
                ->whereBetween('created_at', [$fechaInicio, $fechaFin]);
                
            $costosDirectosReal = 0;
            try {
                $costosDirectosReal = (float) $queryCostosDirectos->sum(DB::raw('COALESCE(materiales, 0) + COALESCE(mano_obra, 0) + COALESCE(maquinaria, 0) + COALESCE(subcontratos, 0)'));
            } catch (\Exception $e) {
                $costosDirectosReal = (float) $queryCostosDirectos->sum('materiales') + 
                                      (float) $queryCostosDirectos->sum('mano_obra') +
                                      (float) $queryCostosDirectos->sum('maquinaria') +
                                      (float) $queryCostosDirectos->sum('subcontratos');
            }

            if ($costosDirectosReal == 0) {
                $costosDirectosReal = (float) DB::table('movimientos_bancarios')
                    ->whereIn('proyecto_id', $proyectoIds)
                    ->where('tipo', 'egreso')
                    ->where('status', 'aplicado')
                    ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                    ->where(function($q) {
                        $q->where('concepto', 'LIKE', '%material%')
                          ->orWhere('concepto', 'LIKE', '%mano de obra%')
                          ->orWhere('concepto', 'LIKE', '%maquinaria%')
                          ->orWhere('concepto', 'LIKE', '%subcontrato%');
                    })
                    ->sum('monto');
            }

            // ========== GASTOS DE OPERACIÓN REALES ==========
            $queryGastosOperacion = DB::table('proyecto_costos')
                ->whereIn('proyecto_id', $proyectoIds)
                ->whereBetween('created_at', [$fechaInicio, $fechaFin]);
                
            $gastosOperacionReal = (float) $queryGastosOperacion->sum('gastos_indirectos');

            if ($gastosOperacionReal == 0) {
                $gastosOperacionReal = (float) DB::table('movimientos_bancarios')
                    ->whereIn('proyecto_id', $proyectoIds)
                    ->where('tipo', 'egreso')
                    ->where('status', 'aplicado')
                    ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                    ->where(function($q) {
                        $q->where('concepto', 'LIKE', '%gasto%')
                          ->orWhere('concepto', 'LIKE', '%operacion%')
                          ->orWhere('concepto', 'LIKE', '%administrativo%');
                    })
                    ->sum('monto');
            }

            // ========== GASTOS FINANCIEROS REALES ==========
            $gastosFinancierosReal = (float) DB::table('movimientos_bancarios')
                ->whereIn('proyecto_id', $proyectoIds)
                ->where('tipo', 'egreso')
                ->where('status', 'aplicado')
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->where(function($q) {
                    $q->where('concepto', 'LIKE', '%financiero%')
                      ->orWhere('concepto', 'LIKE', '%interes%')
                      ->orWhere('concepto', 'LIKE', '%comision%');
                })
                ->sum('monto');

            // ========== DEPRECIACIÓN REAL ==========
            $depreciacionReal = 0;
            try {
                $depreciacionReal = (float) DB::table('depreciaciones')
                    ->whereIn('proyecto_id', $proyectoIds)
                    ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                    ->sum('monto');
            } catch (\Exception $e) {
                $depreciacionReal = 0;
            }

            // ========== CÁLCULOS REALES ==========
            $utilidadBrutaReal = $ingresosReal - $costosDirectosReal;
            $ebitdaReal = $utilidadBrutaReal - $gastosOperacionReal;
            $utilidadNetaReal = $ebitdaReal - $gastosFinancierosReal - $depreciacionReal;

            // ========== PRESUPUESTO ==========
            $presupuesto = $this->getPresupuestoData($proyectoIds);

            $resultado = [
                'real' => [
                    'ingresos' => $ingresosReal,
                    'costos_directos' => $costosDirectosReal,
                    'utilidad_bruta' => $utilidadBrutaReal,
                    'gastos_operacion' => $gastosOperacionReal,
                    'ebitda' => $ebitdaReal,
                    'gastos_financieros' => $gastosFinancierosReal,
                    'depreciacion' => $depreciacionReal,
                    'utilidad_neta' => $utilidadNetaReal
                ],
                'periodo' => $periodo,
                'fecha_inicio' => $fechaInicio->format('Y-m-d'),
                'fecha_fin' => $fechaFin->format('Y-m-d')
            ];

            if ($incluirPresupuesto) {
                $resultado['presupuesto'] = $presupuesto;
            }

            return $resultado;

        } catch (\Exception $e) {
            \Log::error('Error en getEstadoResultadosData: ' . $e->getMessage());
            
            return [
                'real' => [
                    'ingresos' => 0,
                    'costos_directos' => 0,
                    'utilidad_bruta' => 0,
                    'gastos_operacion' => 0,
                    'ebitda' => 0,
                    'gastos_financieros' => 0,
                    'depreciacion' => 0,
                    'utilidad_neta' => 0
                ],
                'presupuesto' => [
                    'ingresos' => 0,
                    'costos_directos' => 0,
                    'utilidad_bruta' => 0,
                    'gastos_operacion' => 0,
                    'ebitda' => 0,
                    'gastos_financieros' => 0,
                    'depreciacion' => 0,
                    'utilidad_neta' => 0
                ],
                'periodo' => $periodo,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Obtener datos presupuestados desde los proyectos
     */
    private function getPresupuestoData($proyectoIds)
    {
        try {
            $ingresosPres = (float) Proyecto::whereIn('id', $proyectoIds)->sum('presupuesto_total');

            $queryCostosDirectos = DB::table('proyecto_costos')
                ->whereIn('proyecto_id', $proyectoIds);
                
            $costosDirectosPres = 0;
            try {
                $costosDirectosPres = (float) $queryCostosDirectos->sum(DB::raw('COALESCE(materiales, 0) + COALESCE(mano_obra, 0) + COALESCE(maquinaria, 0) + COALESCE(subcontratos, 0)'));
            } catch (\Exception $e) {
                $costosDirectosPres = (float) $queryCostosDirectos->sum('materiales') + 
                                      (float) $queryCostosDirectos->sum('mano_obra') +
                                      (float) $queryCostosDirectos->sum('maquinaria') +
                                      (float) $queryCostosDirectos->sum('subcontratos');
            }

            if ($costosDirectosPres == 0) {
                $costosDirectosPres = (float) DB::table('proyecto_partidas')
                    ->whereIn('proyecto_id', $proyectoIds)
                    ->whereIn('categoria', ['materiales', 'mano_obra', 'maquinaria'])
                    ->where('activa', true)
                    ->sum('importe');
            }

            $gastosOperacionPres = (float) DB::table('proyecto_costos')
                ->whereIn('proyecto_id', $proyectoIds)
                ->sum('gastos_indirectos');

            if ($gastosOperacionPres == 0) {
                $gastosOperacionPres = $ingresosPres * 0.15;
            }

            $gastosFinancierosPres = $ingresosPres * 0.02;
            $depreciacionPres = $ingresosPres * 0.03;

            $utilidadBrutaPres = $ingresosPres - $costosDirectosPres;
            $ebitdaPres = $utilidadBrutaPres - $gastosOperacionPres;
            $utilidadNetaPres = $ebitdaPres - $gastosFinancierosPres - $depreciacionPres;

            return [
                'ingresos' => $ingresosPres,
                'costos_directos' => $costosDirectosPres,
                'utilidad_bruta' => $utilidadBrutaPres,
                'gastos_operacion' => $gastosOperacionPres,
                'ebitda' => $ebitdaPres,
                'gastos_financieros' => $gastosFinancierosPres,
                'depreciacion' => $depreciacionPres,
                'utilidad_neta' => $utilidadNetaPres
            ];

        } catch (\Exception $e) {
            \Log::error('Error en getPresupuestoData: ' . $e->getMessage());
            
            try {
                $ingresosPres = (float) Proyecto::whereIn('id', $proyectoIds)->sum('presupuesto_total');
                return [
                    'ingresos' => $ingresosPres,
                    'costos_directos' => $ingresosPres * 0.60,
                    'utilidad_bruta' => $ingresosPres * 0.40,
                    'gastos_operacion' => $ingresosPres * 0.20,
                    'ebitda' => $ingresosPres * 0.20,
                    'gastos_financieros' => $ingresosPres * 0.02,
                    'depreciacion' => $ingresosPres * 0.03,
                    'utilidad_neta' => $ingresosPres * 0.15
                ];
            } catch (\Exception $e2) {
                return [
                    'ingresos' => 0,
                    'costos_directos' => 0,
                    'utilidad_bruta' => 0,
                    'gastos_operacion' => 0,
                    'ebitda' => 0,
                    'gastos_financieros' => 0,
                    'depreciacion' => 0,
                    'utilidad_neta' => 0
                ];
            }
        }
    }

    /**
     * Flujo de Efectivo con datos REALES y BANCOS
     * 🔥 CORREGIDO - Usa DB::table para todas las consultas
     */
    private function getFlujoEfectivoData($proyectoIds, $periodo)
    {
        try {
            $fechaInicio = $this->getFechaInicio($periodo);
            $fechaFin = Carbon::now();

            // ========== SALDO INICIAL ==========
            // ✅ Usar DB::table en lugar de CuentaBancaria::where
            $saldoInicial = (float) DB::table('cuentas_bancarias')
                ->where('activa', true)
                ->sum('saldo_inicial');

            if ($saldoInicial == 0) {
                $saldoInicial = (float) DB::table('cuentas_bancarias')
                    ->where('activa', true)
                    ->sum('saldo_actual');
            }

            // ========== INGRESOS DEL PERÍODO ==========
            // ✅ Usar DB::table en lugar de MovimientoBancario::where
            $ingresos = (float) DB::table('movimientos_bancarios')
                ->whereIn('proyecto_id', $proyectoIds)
                ->where('tipo', 'ingreso')
                ->where('status', 'aplicado')
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->sum('monto');

            if ($ingresos == 0) {
                $ingresos = (float) DB::table('facturas')
                    ->whereIn('proyecto_id', $proyectoIds)
                    ->where('estatus', '!=', self::ESTATUS_CANCELADA)
                    ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                    ->sum('total');
            }

            // ========== EGRESOS DEL PERÍODO ==========
            $egresos = (float) DB::table('movimientos_bancarios')
                ->whereIn('proyecto_id', $proyectoIds)
                ->where('tipo', 'egreso')
                ->where('status', 'aplicado')
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->sum('monto');

            if ($egresos == 0) {
                $egresos = (float) DB::table('pagos')
                    ->whereIn('proyecto_id', $proyectoIds)
                    ->where('estatus', 'pagado')
                    ->whereBetween('fecha_pago', [$fechaInicio, $fechaFin])
                    ->sum('monto');
            }

            // ========== BANCOS ==========
            // ✅ Usar DB::table en lugar de CuentaBancaria::where
            $bancos = DB::table('cuentas_bancarias')
                ->where('activa', true)
                ->get(['id', 'banco', 'numero_cuenta', 'saldo_actual', 'saldo_inicial']);

            $bancosData = [];
            foreach ($bancos as $banco) {
                $ingresosBanco = (float) DB::table('movimientos_bancarios')
                    ->where('cuenta_bancaria_id', $banco->id)
                    ->where('tipo', 'ingreso')
                    ->where('status', 'aplicado')
                    ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                    ->sum('monto');

                $egresosBanco = (float) DB::table('movimientos_bancarios')
                    ->where('cuenta_bancaria_id', $banco->id)
                    ->where('tipo', 'egreso')
                    ->where('status', 'aplicado')
                    ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                    ->sum('monto');

                $bancosData[] = [
                    'id' => $banco->id,
                    'nombre' => $banco->banco ?? 'Cuenta sin nombre',
                    'numero' => $banco->numero_cuenta ?? '',
                    'saldo_inicial' => (float) ($banco->saldo_inicial ?? 0),
                    'saldo_actual' => (float) ($banco->saldo_actual ?? 0),
                    'ingresos' => $ingresosBanco,
                    'egresos' => $egresosBanco,
                    'flujo' => $ingresosBanco - $egresosBanco
                ];
            }

            $flujoNeto = $ingresos - $egresos;
            $saldoFinal = $saldoInicial + $flujoNeto;

            return [
                'saldo_inicial' => $saldoInicial,
                'ingresos' => $ingresos,
                'egresos' => $egresos,
                'flujo_neto' => $flujoNeto,
                'saldo_final' => $saldoFinal,
                'bancos' => $bancosData,
                'periodo' => $periodo,
                'fecha_inicio' => $fechaInicio->format('Y-m-d'),
                'fecha_fin' => $fechaFin->format('Y-m-d')
            ];

        } catch (\Exception $e) {
            \Log::error('Error en getFlujoEfectivoData: ' . $e->getMessage());
            
            try {
                $saldoInicial = (float) DB::table('cuentas_bancarias')
                    ->where('activa', true)
                    ->sum('saldo_actual');
                
                $bancos = DB::table('cuentas_bancarias')
                    ->where('activa', true)
                    ->get(['id', 'banco', 'numero_cuenta', 'saldo_actual']);
                
                $bancosData = [];
                foreach ($bancos as $banco) {
                    $bancosData[] = [
                        'id' => $banco->id,
                        'nombre' => $banco->banco ?? 'Cuenta',
                        'numero' => $banco->numero_cuenta ?? '',
                        'saldo_inicial' => (float) ($banco->saldo_actual ?? 0),
                        'saldo_actual' => (float) ($banco->saldo_actual ?? 0),
                        'ingresos' => 0,
                        'egresos' => 0,
                        'flujo' => 0
                    ];
                }
                
                return [
                    'saldo_inicial' => $saldoInicial,
                    'ingresos' => 0,
                    'egresos' => 0,
                    'flujo_neto' => 0,
                    'saldo_final' => $saldoInicial,
                    'bancos' => $bancosData,
                    'periodo' => $periodo,
                    'fecha_inicio' => $fechaInicio->format('Y-m-d'),
                    'fecha_fin' => $fechaFin->format('Y-m-d')
                ];
            } catch (\Exception $e2) {
                return [
                    'saldo_inicial' => 0,
                    'ingresos' => 0,
                    'egresos' => 0,
                    'flujo_neto' => 0,
                    'saldo_final' => 0,
                    'bancos' => [],
                    'periodo' => $periodo,
                    'fecha_inicio' => $fechaInicio->format('Y-m-d'),
                    'fecha_fin' => $fechaFin->format('Y-m-d')
                ];
            }
        }
    }

    /**
     * Resumen de nómina con filtro por proyecto
     * 🔥 CORREGIDO - Usa DB::table para todas las consultas
     */
    private function getNominaResumen($proyectoIds, $periodo)
    {
        try {
            // ✅ Usar DB::table en lugar de Plantilla::where
            $totalEmpleados = DB::table('plantillas')
                ->where('borrado_logico', false)
                ->count();
                
            $empleadosActivos = DB::table('plantillas')
                ->where('estatus', 'Activo')
                ->count();

            $empleadosEnProyectos = DB::table('asignaciones_personal')
                ->whereIn('proyecto_id', $proyectoIds)
                ->where('status', 'activo')
                ->distinct('empleado_id')
                ->count('empleado_id');

            $costoNomina = (float) DB::table('asignaciones_personal')
                ->whereIn('proyecto_id', $proyectoIds)
                ->where('status', 'activo')
                ->sum('salario_diario');

            if ($costoNomina === 0) {
                $costoNomina = (float) DB::table('nomina')
                    ->whereIn('proyecto_id', $proyectoIds)
                    ->where('estatus', 'pagado')
                    ->sum('total');
            }

            // Clasificación de empleados
            $operadores = DB::table('plantillas')
                ->where('operador', true)
                ->count();
            
            $tecnicos = DB::table('plantillas')
                ->whereIn('cat_puesto_id', function($query) {
                    $query->select('id')
                        ->from('cat_puestos')
                        ->where('puesto', 'LIKE', '%técnico%');
                })
                ->count();

            if ($tecnicos == 0) {
                $tecnicos = (int) ($totalEmpleados * 0.15);
            }

            $administrativos = $totalEmpleados - $operadores - $tecnicos;

            return [
                'total_empleados' => $totalEmpleados,
                'empleados_activos' => $empleadosActivos,
                'empleados_en_proyectos' => $empleadosEnProyectos,
                'costo_nomina' => $costoNomina,
                'porcentaje_obreros' => $totalEmpleados > 0 ? round(($operadores / $totalEmpleados) * 100) : 0,
                'porcentaje_tecnicos' => $totalEmpleados > 0 ? round(($tecnicos / $totalEmpleados) * 100) : 0,
                'porcentaje_admin' => $totalEmpleados > 0 ? round(($administrativos / $totalEmpleados) * 100) : 0
            ];

        } catch (\Exception $e) {
            \Log::error('Error en getNominaResumen: ' . $e->getMessage());
            return [
                'total_empleados' => 0,
                'empleados_activos' => 0,
                'empleados_en_proyectos' => 0,
                'costo_nomina' => 0,
                'porcentaje_obreros' => 0,
                'porcentaje_tecnicos' => 0,
                'porcentaje_admin' => 0
            ];
        }
    }

    /**
     * Estado de maquinaria con filtro por proyecto
     */
    private function getMaquinariaEstado($proyectoIds)
    {
        try {
            $total = Activo::where('tipo_activo', 'maquinaria')->count();
            
            $enProyectos = Activo::where('tipo_activo', 'maquinaria')
                ->whereIn('proyecto_asignado_id', $proyectoIds)
                ->count();

            $operativos = Activo::where('tipo_activo', 'maquinaria')
                ->where('estatus', 'operativo')
                ->count();

            $mantencion = Activo::where('tipo_activo', 'maquinaria')
                ->where('estatus', 'mantenimiento')
                ->count();

            $inactivos = Activo::where('tipo_activo', 'maquinaria')
                ->where('estatus', 'inactivo')
                ->count();

            return [
                'total' => $total,
                'en_proyectos' => $enProyectos,
                'operativos' => $operativos,
                'mantencion' => $mantencion,
                'inactivos' => $inactivos,
                'disponibilidad' => $total > 0 ? round(($operativos / $total) * 100, 1) : 0
            ];

        } catch (\Exception $e) {
            \Log::error('Error en getMaquinariaEstado: ' . $e->getMessage());
            return [
                'total' => 0,
                'en_proyectos' => 0,
                'operativos' => 0,
                'mantencion' => 0,
                'inactivos' => 0,
                'disponibilidad' => 0
            ];
        }
    }

    /**
     * Resumen de inventario con filtro por proyecto
     */
    private function getResumenInventario($proyectoIds)
    {
        try {
            $totalArticulos = DB::table('articulos')->where('estatus', 'activo')->count();
            $totalFamilias = DB::table('familias')->where('estatus', 'activo')->count();
            
            $inventarioProyectos = InventarioProyecto::whereIn('proyecto_id', $proyectoIds)
                ->select(
                    DB::raw('COALESCE(sum(cantidad_actual), 0) as stock_total'),
                    DB::raw('COALESCE(sum(cantidad_actual * costo_promedio), 0) as valor_total')
                )
                ->first();

            $bajoStock = InventarioProyecto::whereIn('proyecto_id', $proyectoIds)
                ->whereRaw('cantidad_actual <= cantidad_minima')
                ->count();

            return [
                'total_articulos' => $totalArticulos,
                'total_familias' => $totalFamilias,
                'stock_total' => (float) ($inventarioProyectos->stock_total ?? 0),
                'valor_total' => (float) ($inventarioProyectos->valor_total ?? 0),
                'bajo_stock' => $bajoStock
            ];

        } catch (\Exception $e) {
            \Log::error('Error en getResumenInventario: ' . $e->getMessage());
            return [
                'total_articulos' => 0,
                'total_familias' => 0,
                'stock_total' => 0,
                'valor_total' => 0,
                'bajo_stock' => 0
            ];
        }
    }

    /**
     * Resumen de bitácora con filtro por proyecto
     */
    private function getResumenBitacora($proyectoIds, $periodo)
    {
        try {
            $fechaInicio = $this->getFechaInicio($periodo);

            $totalEntries = BitacoraEntry::whereIn('proyecto_id', $proyectoIds)
                ->where('created_at', '>=', $fechaInicio)
                ->count();

            $incidencias = DB::table('bitacora_incidencias')
                ->whereIn('bitacora_entry_id', function($query) use ($proyectoIds, $fechaInicio) {
                    $query->select('id')
                        ->from('bitacora_entries')
                        ->whereIn('proyecto_id', $proyectoIds)
                        ->where('created_at', '>=', $fechaInicio);
                })
                ->count();

            $hitos = Hito::whereIn('proyecto_id', $proyectoIds)
                ->where('created_at', '>=', $fechaInicio)
                ->count();

            return [
                'total_entries' => $totalEntries,
                'incidencias' => $incidencias,
                'hitos' => $hitos
            ];

        } catch (\Exception $e) {
            \Log::error('Error en getResumenBitacora: ' . $e->getMessage());
            return [
                'total_entries' => 0,
                'incidencias' => 0,
                'hitos' => 0
            ];
        }
    }

    /**
     * Datos de tendencia de ventas
     */
    private function getVentasTendenciaData($proyectoIds, $periodo)
    {
        try {
            $fechaInicio = $this->getFechaInicio($periodo);

            // ✅ Usar DB::table en lugar de Factura::where
            $facturas = DB::table('facturas')
                ->select(
                    DB::raw("TO_CHAR(fecha, 'YYYY-MM') as mes"),
                    DB::raw('COALESCE(sum(total), 0) as total_ventas')
                )
                ->whereIn('proyecto_id', $proyectoIds)
                ->where('fecha', '>=', $fechaInicio)
                ->where('estatus', '!=', self::ESTATUS_CANCELADA)
                ->groupBy('mes')
                ->orderBy('mes', 'asc')
                ->get();

            $labels = [];
            $ventas = [];

            foreach ($facturas as $item) {
                $labels[] = Carbon::parse($item->mes . '-01')->format('M Y');
                $ventas[] = (float) $item->total_ventas;
            }

            return [
                'labels' => $labels,
                'ventas' => $ventas,
                'periodo' => $periodo
            ];

        } catch (\Exception $e) {
            \Log::error('Error en getVentasTendenciaData: ' . $e->getMessage());
            return [
                'labels' => [],
                'ventas' => [],
                'periodo' => $periodo
            ];
        }
    }

    /**
     * Alertas del sistema con filtro por proyecto
     */
    private function getAlertasSistema($proyectoIds)
    {
        try {
            $alertas = [];

            // 1. Proyectos atrasados
            $proyectosAtrasados = Proyecto::whereIn('id', $proyectoIds)
                ->where('estado', 'en_progreso')
                ->where('fecha_fin', '<', now())
                ->count();
            
            if ($proyectosAtrasados > 0) {
                $alertas[] = [
                    'nivel' => 'warning',
                    'mensaje' => $proyectosAtrasados . ' proyecto(s) están atrasados',
                    'tipo' => 'proyecto_atrasado'
                ];
            }

            // 2. Contratistas con bajo rendimiento
            $contratistasBajo = Contratista::where('calificacion', '<', 6)
                ->where('activo', true)
                ->count();
            
            if ($contratistasBajo > 0) {
                $alertas[] = [
                    'nivel' => 'danger',
                    'mensaje' => $contratistasBajo . ' contratista(s) tienen calificación baja',
                    'tipo' => 'contratista_bajo_rendimiento'
                ];
            }

            // 3. Pagos vencidos
            $pagosVencidos = Pago::whereIn('proyecto_id', $proyectoIds)
                ->where('estatus', 'pendiente')
                ->where('fecha_pago', '<', now())
                ->count();
            
            if ($pagosVencidos > 0) {
                $alertas[] = [
                    'nivel' => 'danger',
                    'mensaje' => $pagosVencidos . ' pago(s) están vencidos',
                    'tipo' => 'pago_vencido'
                ];
            }

            // 4. Facturas vencidas
            // ✅ Usar DB::table en lugar de Factura::where
            $facturasVencidas = DB::table('facturas')
                ->whereIn('proyecto_id', $proyectoIds)
                ->where('estatus', '=', self::ESTATUS_EMITIDA)
                ->where('fecha_vencimiento', '<', now())
                ->count();
            
            if ($facturasVencidas > 0) {
                $alertas[] = [
                    'nivel' => 'warning',
                    'mensaje' => $facturasVencidas . ' factura(s) están vencidas',
                    'tipo' => 'factura_vencida'
                ];
            }

            // 5. Stock bajo
            $bajoStock = InventarioProyecto::whereIn('proyecto_id', $proyectoIds)
                ->whereRaw('cantidad_actual <= cantidad_minima')
                ->count();
            
            if ($bajoStock > 0) {
                $alertas[] = [
                    'nivel' => 'warning',
                    'mensaje' => $bajoStock . ' producto(s) tienen stock bajo',
                    'tipo' => 'stock_bajo'
                ];
            }

            return [
                'total' => count($alertas),
                'alertas' => $alertas
            ];

        } catch (\Exception $e) {
            \Log::error('Error en getAlertasSistema: ' . $e->getMessage());
            return [
                'total' => 0,
                'alertas' => []
            ];
        }
    }

    /**
     * Obtener fecha de inicio según período
     */
    private function getFechaInicio($periodo)
    {
        switch ($periodo) {
            case 'dia': return now()->startOfDay();
            case 'semana': return now()->startOfWeek();
            case 'mes': return now()->startOfMonth();
            case 'trimestre': return now()->startOfQuarter();
            case 'año': return now()->startOfYear();
            default: return now()->startOfMonth();
        }
    }

    // ============================================
    // MÉTODOS API PARA EL FRONTEND
    // ============================================

    public function getCuentasCobrar(Request $request)
    {
        try {
            $proyectoIds = $request->get('proyecto_ids', []);
            
            // ✅ Usar DB::table en lugar de Factura::where
            $query = DB::table('facturas')
                ->where('total', '>', 0)
                ->where('saldo_disponible', '>', 0);
            
            if (!empty($proyectoIds)) {
                $query->whereIn('proyecto_id', $proyectoIds);
            }
            
            $facturasPendientes = $query->get();

            $antiguedad = ['corriente' => 0, '30-60' => 0, '61-90' => 0, '91-120' => 0, '120+' => 0];
            $total = 0;
            $today = Carbon::now();

            foreach ($facturasPendientes as $factura) {
                $monto = (float) ($factura->saldo_disponible ?? $factura->total ?? 0);
                $total += $monto;

                if ($factura->fecha_vencimiento) {
                    try {
                        $fechaVenc = Carbon::parse($factura->fecha_vencimiento);
                        
                        if ($fechaVenc->isFuture()) {
                            $antiguedad['corriente'] += $monto;
                        } else {
                            $dias = $fechaVenc->diffInDays($today);
                            if ($dias <= 30) {
                                $antiguedad['30-60'] += $monto;
                            } elseif ($dias <= 60) {
                                $antiguedad['30-60'] += $monto;
                            } elseif ($dias <= 90) {
                                $antiguedad['61-90'] += $monto;
                            } elseif ($dias <= 120) {
                                $antiguedad['91-120'] += $monto;
                            } else {
                                $antiguedad['120+'] += $monto;
                            }
                        }
                    } catch (\Exception $e) {
                        $antiguedad['corriente'] += $monto;
                    }
                } else {
                    $antiguedad['corriente'] += $monto;
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'total' => $total,
                    'antiguedad' => $antiguedad
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getCuentasCobrar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getCuentasPagar(Request $request)
    {
        try {
            $proyectoIds = $request->get('proyecto_ids', []);
            
            // ✅ Usar DB::table en lugar de Pago::where
            $query = DB::table('pagos')->where('estatus', 'pendiente');
            
            if (!empty($proyectoIds)) {
                $query->whereIn('proyecto_id', $proyectoIds);
            }
            
            $pagosPendientes = $query->get();

            $antiguedad = ['0-30' => 0, '31-60' => 0, '61-90' => 0, '91+' => 0];
            $total = 0;
            $today = Carbon::now();

            foreach ($pagosPendientes as $pago) {
                $monto = (float) $pago->monto;
                $total += $monto;

                if ($pago->fecha_pago) {
                    try {
                        $fechaPago = Carbon::parse($pago->fecha_pago);
                        $fechaVenc = $fechaPago->copy()->addDays(30);
                        
                        if ($fechaVenc->isFuture()) {
                            $antiguedad['0-30'] += $monto;
                        } else {
                            $dias = $fechaVenc->diffInDays($today);
                            if ($dias <= 30) {
                                $antiguedad['0-30'] += $monto;
                            } elseif ($dias <= 60) {
                                $antiguedad['31-60'] += $monto;
                            } elseif ($dias <= 90) {
                                $antiguedad['61-90'] += $monto;
                            } else {
                                $antiguedad['91+'] += $monto;
                            }
                        }
                    } catch (\Exception $e) {
                        $antiguedad['0-30'] += $monto;
                    }
                } else {
                    $antiguedad['0-30'] += $monto;
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'total' => $total,
                    'antiguedad' => $antiguedad
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getCuentasPagar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getEstadoResultados(Request $request)
    {
        try {
            $proyectoIds = $request->get('proyecto_ids', []);
            $periodo = $request->get('periodo', 'mes');
            $incluirPresupuesto = $request->get('incluir_presupuesto', 'true') === 'true';
            
            if (empty($proyectoIds)) {
                $proyectoIds = Proyecto::pluck('id')->toArray();
            }

            $data = $this->getEstadoResultadosData($proyectoIds, $periodo, $incluirPresupuesto);

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getEstadoResultados: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getFlujoEfectivo(Request $request)
    {
        try {
            $proyectoIds = $request->get('proyecto_ids', []);
            $periodo = $request->get('periodo', 'mes');
            
            if (empty($proyectoIds)) {
                $proyectoIds = Proyecto::pluck('id')->toArray();
            }

            $data = $this->getFlujoEfectivoData($proyectoIds, $periodo);

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getFlujoEfectivo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getResumenProyectosApi(Request $request)
    {
        $proyectoIds = $request->get('proyecto_ids', []);
        if (empty($proyectoIds)) {
            $proyectoIds = Proyecto::pluck('id')->toArray();
        }
        return response()->json([
            'success' => true,
            'data' => $this->getResumenProyectos($proyectoIds)
        ]);
    }

    public function getResumenContratistasApi(Request $request)
    {
        $proyectoIds = $request->get('proyecto_ids', []);
        if (empty($proyectoIds)) {
            $proyectoIds = Proyecto::pluck('id')->toArray();
        }
        return response()->json([
            'success' => true,
            'data' => $this->getResumenContratistas($proyectoIds)
        ]);
    }

    public function getNominaResumenApi(Request $request)
    {
        $proyectoIds = $request->get('proyecto_ids', []);
        $periodo = $request->get('periodo', 'mes');
        if (empty($proyectoIds)) {
            $proyectoIds = Proyecto::pluck('id')->toArray();
        }
        return response()->json([
            'success' => true,
            'data' => $this->getNominaResumen($proyectoIds, $periodo)
        ]);
    }

    public function getMaquinariaEstadoApi(Request $request)
    {
        $proyectoIds = $request->get('proyecto_ids', []);
        if (empty($proyectoIds)) {
            $proyectoIds = Proyecto::pluck('id')->toArray();
        }
        return response()->json([
            'success' => true,
            'data' => $this->getMaquinariaEstado($proyectoIds)
        ]);
    }

    public function getResumenInventarioApi(Request $request)
    {
        $proyectoIds = $request->get('proyecto_ids', []);
        if (empty($proyectoIds)) {
            $proyectoIds = Proyecto::pluck('id')->toArray();
        }
        return response()->json([
            'success' => true,
            'data' => $this->getResumenInventario($proyectoIds)
        ]);
    }

    public function getResumenBitacoraApi(Request $request)
    {
        $proyectoIds = $request->get('proyecto_ids', []);
        $periodo = $request->get('periodo', 'mes');
        if (empty($proyectoIds)) {
            $proyectoIds = Proyecto::pluck('id')->toArray();
        }
        return response()->json([
            'success' => true,
            'data' => $this->getResumenBitacora($proyectoIds, $periodo)
        ]);
    }

    public function getAlertasSistemaApi(Request $request)
    {
        $proyectoIds = $request->get('proyecto_ids', []);
        if (empty($proyectoIds)) {
            $proyectoIds = Proyecto::pluck('id')->toArray();
        }
        return response()->json([
            'success' => true,
            'data' => $this->getAlertasSistema($proyectoIds)
        ]);
    }

    public function getKPIGenerales(Request $request)
    {
        try {
            $proyectoIds = $request->get('proyecto_ids', []);
            if (empty($proyectoIds)) {
                $proyectoIds = Proyecto::pluck('id')->toArray();
            }

            $totalProyectos = Proyecto::whereIn('id', $proyectoIds)->count();
            $proyectosActivos = Proyecto::whereIn('id', $proyectoIds)
                ->where('status', 'activo')
                ->count();
            
            $totalContratistas = Contratista::count();
            $contratistasActivos = Contratista::where('activo', true)->count();
            
            // ✅ Usar DB::table en lugar de Factura::where
            $facturacionTotal = (float) DB::table('facturas')
                ->whereIn('proyecto_id', $proyectoIds)
                ->where('estatus', '!=', self::ESTATUS_CANCELADA)
                ->sum('total');
            
            $facturacionMes = (float) DB::table('facturas')
                ->whereIn('proyecto_id', $proyectoIds)
                ->whereMonth('fecha', now()->month)
                ->whereYear('fecha', now()->year)
                ->where('estatus', '!=', self::ESTATUS_CANCELADA)
                ->sum('total');
            
            $totalEmpleados = DB::table('plantillas')
                ->where('borrado_logico', false)
                ->count();
                
            $empleadosActivos = DB::table('plantillas')
                ->where('estatus', 'Activo')
                ->count();
            
            $totalMaquinaria = Activo::where('tipo_activo', 'maquinaria')->count();
            $maquinariaOperativa = Activo::where('tipo_activo', 'maquinaria')
                ->where('estatus', 'operativo')
                ->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'proyectos' => [
                        'total' => $totalProyectos,
                        'activos' => $proyectosActivos,
                        'tasa_actividad' => $totalProyectos > 0 ? round(($proyectosActivos / $totalProyectos) * 100, 1) : 0
                    ],
                    'contratistas' => [
                        'total' => $totalContratistas,
                        'activos' => $contratistasActivos,
                        'tasa_actividad' => $totalContratistas > 0 ? round(($contratistasActivos / $totalContratistas) * 100, 1) : 0
                    ],
                    'finanzas' => [
                        'facturacion_total' => $facturacionTotal,
                        'facturacion_mes' => $facturacionMes
                    ],
                    'rh' => [
                        'total_empleados' => $totalEmpleados,
                        'empleados_activos' => $empleadosActivos
                    ],
                    'maquinaria' => [
                        'total' => $totalMaquinaria,
                        'operativa' => $maquinariaOperativa,
                        'disponibilidad' => $totalMaquinaria > 0 ? round(($maquinariaOperativa / $totalMaquinaria) * 100, 1) : 0
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getKPIGenerales: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getVentasProyecto(Request $request)
    {
        try {
            $proyectoIds = $request->get('proyecto_ids', []);
            if (empty($proyectoIds)) {
                $proyectoIds = Proyecto::pluck('id')->toArray();
            }

            $proyectos = Proyecto::whereIn('id', $proyectoIds)
                ->where(function($q) {
                    $q->where('status', 'activo')
                      ->orWhere('estado', 'activo')
                      ->orWhere('estado', 'en_progreso');
                })
                ->get();

            $data = [];
            foreach ($proyectos as $proyecto) {
                // ✅ Usar DB::table en lugar de Factura::where
                $monto = (float) DB::table('facturas')
                    ->where('proyecto_id', $proyecto->id)
                    ->where('estatus', '!=', self::ESTATUS_CANCELADA)
                    ->sum('total');

                $data[] = [
                    'id' => $proyecto->id,
                    'nombre' => $proyecto->nombre,
                    'codigo' => $proyecto->codigo,
                    'monto' => $monto,
                    'presupuesto' => (float) $proyecto->presupuesto_total
                ];
            }

            usort($data, function($a, $b) {
                return $b['monto'] <=> $a['monto'];
            });

            $totalVentas = array_sum(array_column($data, 'monto'));

            return response()->json([
                'success' => true,
                'data' => $data,
                'total_ventas' => $totalVentas
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getVentasProyecto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getVentasTendencia(Request $request)
    {
        try {
            $periodo = $request->get('periodo', 'mes');
            $fechaInicio = $this->getFechaInicio($periodo);
            $proyectoIds = $request->get('proyecto_ids', []);
            
            if (empty($proyectoIds)) {
                $proyectoIds = Proyecto::pluck('id')->toArray();
            }

            // ✅ Usar DB::table en lugar de Factura::where y TO_CHAR para PostgreSQL
            $facturas = DB::table('facturas')
                ->select(
                    DB::raw("TO_CHAR(fecha, 'YYYY-MM') as mes"),
                    DB::raw('COALESCE(sum(total), 0) as total_ventas')
                )
                ->whereIn('proyecto_id', $proyectoIds)
                ->where('fecha', '>=', $fechaInicio)
                ->where('estatus', '!=', self::ESTATUS_CANCELADA)
                ->groupBy('mes')
                ->orderBy('mes', 'asc')
                ->get();

            $labels = [];
            $ventas = [];

            foreach ($facturas as $item) {
                $labels[] = Carbon::parse($item->mes . '-01')->format('M Y');
                $ventas[] = (float) $item->total_ventas;
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'labels' => $labels,
                    'ventas' => $ventas,
                    'periodo' => $periodo
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getVentasTendencia: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getFacturacionDiaria(Request $request)
    {
        try {
            $proyectoIds = $request->get('proyecto_ids', []);
            if (empty($proyectoIds)) {
                $proyectoIds = Proyecto::pluck('id')->toArray();
            }

            // ✅ Usar DB::table en lugar de Factura::where
            $totalMes = (float) DB::table('facturas')
                ->whereIn('proyecto_id', $proyectoIds)
                ->whereMonth('fecha', now()->month)
                ->whereYear('fecha', now()->year)
                ->where('estatus', '!=', self::ESTATUS_CANCELADA)
                ->sum('total');

            $facturacionDiaria = DB::table('facturas')
                ->select(
                    DB::raw("DATE(fecha) as fecha"),
                    DB::raw('COALESCE(sum(total), 0) as total')
                )
                ->whereIn('proyecto_id', $proyectoIds)
                ->where('fecha', '>=', now()->subDays(30))
                ->where('estatus', '!=', self::ESTATUS_CANCELADA)
                ->groupBy('fecha')
                ->orderBy('fecha', 'asc')
                ->get();

            $ingresos = DB::table('facturas')
                ->whereIn('proyecto_id', $proyectoIds)
                ->where('estatus', '!=', self::ESTATUS_CANCELADA)
                ->sum('total');

            $costos = DB::table('proyecto_costos')
                ->whereIn('proyecto_id', $proyectoIds)
                ->sum(DB::raw('COALESCE(materiales, 0) + COALESCE(mano_obra, 0) + COALESCE(maquinaria, 0) + COALESCE(gastos_indirectos, 0) + COALESCE(subcontratos, 0)'));

            $rentabilidad = $ingresos > 0 ? round((($ingresos - $costos) / $ingresos) * 100, 1) : 0;

            return response()->json([
                'success' => true,
                'data' => [
                    'total_mes' => $totalMes,
                    'proyeccion_mensual' => $totalMes * 1.2,
                    'rentabilidad' => $rentabilidad,
                    'facturacion_diaria' => $facturacionDiaria
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getFacturacionDiaria: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getRentabilidad(Request $request)
    {
        try {
            $proyectoIds = $request->get('proyecto_ids', []);
            $periodo = $request->get('periodo', 'mes');
            if (empty($proyectoIds)) {
                $proyectoIds = Proyecto::pluck('id')->toArray();
            }

            $data = $this->getFinanzas($proyectoIds, $periodo);
            return response()->json([
                'success' => true,
                'data' => $data['rentabilidad']
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getRentabilidad: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getAsignacionesContratistas(Request $request)
    {
        try {
            $proyectoIds = $request->get('proyecto_ids', []);
            if (empty($proyectoIds)) {
                $proyectoIds = Proyecto::pluck('id')->toArray();
            }

            $asignaciones = DB::table('asignaciones_contratistas')
                ->whereIn('proyecto_id', $proyectoIds)
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();

            $totales = [
                'total' => DB::table('asignaciones_contratistas')->whereIn('proyecto_id', $proyectoIds)->count(),
                'asignado' => DB::table('asignaciones_contratistas')->whereIn('proyecto_id', $proyectoIds)->where('status', 'asignado')->count(),
                'en_progreso' => DB::table('asignaciones_contratistas')->whereIn('proyecto_id', $proyectoIds)->where('status', 'en_progreso')->count(),
                'finalizado' => DB::table('asignaciones_contratistas')->whereIn('proyecto_id', $proyectoIds)->where('status', 'finalizado')->count()
            ];

            return response()->json([
                'success' => true,
                'data' => [
                    'totales' => $totales,
                    'asignaciones' => $asignaciones
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getAsignacionesContratistas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getGastosContratistas(Request $request)
    {
        try {
            $proyectoIds = $request->get('proyecto_ids', []);
            if (empty($proyectoIds)) {
                $proyectoIds = Proyecto::pluck('id')->toArray();
            }

            $gastos = DB::table('gastos_contratista')
                ->whereIn('proyecto_id', $proyectoIds)
                ->orderBy('fecha_gasto', 'desc')
                ->limit(50)
                ->get();

            $totalGastos = (float) DB::table('gastos_contratista')
                ->whereIn('proyecto_id', $proyectoIds)
                ->sum('monto');

            return response()->json([
                'success' => true,
                'data' => [
                    'total_gastos' => $totalGastos,
                    'gastos_recientes' => $gastos
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getGastosContratistas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getResumenLicitaciones(Request $request)
    {
        try {
            $total = Licitacion::count();
            $activas = Licitacion::where('estado', 'activa')->count();
            $adjudicadas = Licitacion::where('estado', 'adjudicada')->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'total' => $total,
                    'activas' => $activas,
                    'adjudicadas' => $adjudicadas,
                    'tasa_conversion' => $total > 0 ? round(($adjudicadas / $total) * 100, 1) : 0
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getResumenLicitaciones: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getResumenConciliacion(Request $request)
    {
        try {
            $total = DB::table('conciliacion_bancaria')->count();
            $pendientes = DB::table('conciliacion_bancaria')->where('estatus', 'pendiente')->count();
            $completadas = DB::table('conciliacion_bancaria')->where('estatus', 'completada')->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'total' => $total,
                    'pendientes' => $pendientes,
                    'completadas' => $completadas,
                    'tasa_completado' => $total > 0 ? round(($completadas / $total) * 100, 1) : 0
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getResumenConciliacion: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getSeguimientoObra(Request $request)
    {
        try {
            $proyectoId = $request->get('proyecto_id');
            
            if (!$proyectoId) {
                $proyectos = Proyecto::where('status', 'activo')
                    ->orWhere('estado', 'activo')
                    ->orWhere('estado', 'en_progreso')
                    ->get(['id', 'codigo', 'nombre']);

                return response()->json([
                    'success' => true,
                    'data' => $proyectos
                ]);
            }

            $partidas = ProyectoPartida::where('proyecto_id', $proyectoId)
                ->where('activa', true)
                ->with('estimaciones')
                ->get();

            $avanceTotal = 0;
            $presupuestoTotal = 0;
            $partidasData = [];

            foreach ($partidas as $partida) {
                $ultimaEstimacion = $partida->estimaciones()->orderBy('fecha', 'desc')->first();
                $avance = $ultimaEstimacion ? $ultimaEstimacion->avance_porcentaje : 0;
                $importe = (float) $partida->importe;
                
                $avanceTotal += ($avance * $importe);
                $presupuestoTotal += $importe;
                
                $partidasData[] = [
                    'codigo' => $partida->codigo,
                    'nombre' => $partida->nombre,
                    'seccion' => $partida->seccion,
                    'avance' => $avance,
                    'presupuesto' => $importe
                ];
            }

            $avanceGlobal = $presupuestoTotal > 0 ? round(($avanceTotal / $presupuestoTotal), 1) : 0;

            return response()->json([
                'success' => true,
                'data' => [
                    'proyecto_id' => $proyectoId,
                    'avance_global' => $avanceGlobal,
                    'partidas' => $partidasData,
                    'total_partidas' => count($partidasData)
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getSeguimientoObra: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getNominaProyectos(Request $request)
    {
        try {
            $proyectoIds = $request->get('proyecto_ids', []);
            if (empty($proyectoIds)) {
                $proyectoIds = Proyecto::pluck('id')->toArray();
            }

            $proyectos = Proyecto::whereIn('id', $proyectoIds)
                ->where('status', 'activo')
                ->limit(5)
                ->get();

            $data = [];
            foreach ($proyectos as $proyecto) {
                $asignaciones = AsignacionPersonal::where('proyecto_id', $proyecto->id)
                    ->where('status', 'activo')
                    ->get();

                $personal = $asignaciones->count();
                $costoTotal = 0;

                foreach ($asignaciones as $asignacion) {
                    $costoTotal += (float) ($asignacion->salario_diario ?? 0);
                }

                $data[] = [
                    'nombre' => $proyecto->nombre,
                    'personal' => $personal,
                    'costo' => $costoTotal
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getNominaProyectos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getAsistenciaResumen(Request $request)
    {
        try {
            $periodo = $request->get('periodo', 'mes');
            $fechaInicio = $this->getFechaInicio($periodo);

            $totalRegistros = DB::table('asistencias')
                ->where('fecha', '>=', $fechaInicio)
                ->count();

            $entradas = DB::table('asistencias')
                ->where('fecha', '>=', $fechaInicio)
                ->where('tipo_registro', 'entrada')
                ->count();

            $incidencias = DB::table('incidencias')
                ->where('created_at', '>=', $fechaInicio)
                ->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'total_registros' => $totalRegistros,
                    'entradas' => $entradas,
                    'incidencias' => $incidencias
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getAsistenciaResumen: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getMaquinariaCostos(Request $request)
    {
        try {
            $proyectoIds = $request->get('proyecto_ids', []);
            if (empty($proyectoIds)) {
                $proyectoIds = Proyecto::pluck('id')->toArray();
            }

            $costoOperacion = 0;
            $combustible = 0;
            
            try {
                $costoOperacion = (float) DB::table('costos_maquinaria')
                    ->whereIn('proyecto_id', $proyectoIds)
                    ->where('tipo_costo', 'operacion')
                    ->sum('monto');
                
                $combustible = (float) DB::table('costos_maquinaria')
                    ->whereIn('proyecto_id', $proyectoIds)
                    ->where('tipo_costo', 'combustible')
                    ->sum('monto');
            } catch (\Exception $e) {
                // Tabla no existe
            }
            
            $costoMantenimiento = (float) DB::table('mantenimientos_activos')
                ->whereIn('activo_id', function($query) use ($proyectoIds) {
                    $query->select('id')
                        ->from('activos')
                        ->where('tipo_activo', 'maquinaria')
                        ->whereIn('proyecto_asignado_id', $proyectoIds);
                })
                ->sum('costo');

            return response()->json([
                'success' => true,
                'data' => [
                    'operacion' => $costoOperacion,
                    'mantenimiento' => $costoMantenimiento,
                    'combustible' => $combustible
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getMaquinariaCostos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}