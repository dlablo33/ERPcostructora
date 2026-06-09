<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BalanceGeneralController extends Controller
{
    public function index(Request $request)
    {
        // Obtener año y mes seleccionado
        $anio = $request->get('anio', Carbon::now()->year);
        $mes = $request->get('mes', Carbon::now()->month);
        
        // Obtener todos los proyectos activos
        $proyectos = DB::table('proyectos')
            ->select('id', 'nombre', 'codigo')
            ->whereNull('deleted_at')
            ->where('status', 'activo')
            ->orderBy('nombre')
            ->get();
        
        // Obtener proyectos seleccionados (para mantener selección)
        $proyectosSeleccionados = $request->get('proyectos', []);
        
        if (is_string($proyectosSeleccionados) && !empty($proyectosSeleccionados)) {
            $proyectosSeleccionados = explode(',', $proyectosSeleccionados);
        }
        
        if (!is_array($proyectosSeleccionados)) {
            $proyectosSeleccionados = [];
        }
        
        $proyectosSeleccionados = array_filter($proyectosSeleccionados);
        $proyectosSeleccionados = array_map('intval', $proyectosSeleccionados);
        
        // Fechas
        $fechaInicioEjercicio = Carbon::create($anio, 1, 1)->startOfDay();
        $fechaLimite = Carbon::create($anio, $mes, 1)->endOfMonth();
        
        // ============================================================
        // 1. SALDO DE CUENTAS BANCARIAS (ACTIVO) - NO FILTRA POR PROYECTO
        // ============================================================
        $cuentasBancarias = DB::table('cuentas_bancarias as cb')
            ->leftJoin('bancos as b', 'cb.banco_id', '=', 'b.id')
            ->select(
                'cb.id',
                'b.nombre as banco',
                'cb.numero_cuenta',
                'cb.saldo_actual'
            )
            ->where('cb.activa', true)
            ->get();
        
        $saldoBancos = $cuentasBancarias->sum('saldo_actual');
        
        // ============================================================
        // 2. CLIENTES (Cuentas por cobrar) - CON PROYECTO_ID
        // ============================================================
        $clientesPorProyecto = DB::table('facturas')
            ->join('contactos', 'facturas.contacto_id', '=', 'contactos.contacto_id')
            ->select(
                'facturas.proyecto_id',
                'facturas.contacto_id',
                'contactos.razon_social',
                DB::raw('SUM(facturas.saldo_disponible) as saldo')
            )
            ->where('facturas.estatus', 19)
            ->where('facturas.saldo_disponible', '>', 0)
            ->whereNull('facturas.deleted_at')
            ->groupBy('facturas.proyecto_id', 'facturas.contacto_id', 'contactos.razon_social')
            ->get();
        
        // ============================================================
        // 3. INVENTARIOS - CON PROYECTO_ID
        // ============================================================
        $inventarioPorProyecto = DB::table('inventario_proyecto as ip')
            ->join('articulos as a', 'ip.articulo_id', '=', 'a.id')
            ->select(
                'ip.proyecto_id',
                'a.descripcion as articulo',
                'a.codigo',
                DB::raw('SUM(ip.cantidad_actual * COALESCE(ip.costo_promedio, 0)) as valor_inventario')
            )
            ->where('ip.cantidad_actual', '>', 0)
            ->groupBy('ip.proyecto_id', 'a.descripcion', 'a.codigo')
            ->get();
        
        // ============================================================
        // 4. ACTIVOS FIJOS - CON PROYECTO_ASIGNADO_ID
        // ============================================================
        $activosFijosPorProyecto = DB::table('activos')
            ->select('proyecto_asignado_id as proyecto_id', 'nombre', 'codigo', 'valor_actual')
            ->whereNull('deleted_at')
            ->where('estatus', 'activo')
            ->get();
        
        // ============================================================
        // 5. PROVEEDORES - NO FILTRA POR PROYECTO (GLOBAL)
        // ============================================================
        $proveedores = DB::table('proveedores')
            ->select('id', 'nombre', 'credito_actual')
            ->where('credito_actual', '>', 0)
            ->where('activo', true)
            ->get();
        
        $totalProveedores = $proveedores->sum('credito_actual');
        
        // ============================================================
        // 6. IMPUESTOS POR PAGAR - CON PROYECTO_ID
        // ============================================================
        $impuestosPorProyecto = DB::table('facturas')
            ->select('proyecto_id', DB::raw('SUM(iva) as total_iva'))
            ->where('estatus', 19)
            ->whereNull('deleted_at')
            ->groupBy('proyecto_id')
            ->get();
        
        // ============================================================
        // 7. PRÉSTAMOS - NO FILTRA POR PROYECTO (GLOBAL)
        // ============================================================
        $prestamos = DB::table('prestamos')
            ->where('estatus', 'activo')
            ->whereNull('deleted_at')
            ->sum('monto_restante');
        
        // ============================================================
        // 8. INGRESOS Y GASTOS POR PROYECTO (para utilidad)
        // ============================================================
        $ingresosPorProyecto = DB::table('movimientos_bancarios as mb')
            ->join('codigos_sat as cs', 'mb.codigo_sat_id', '=', 'cs.id')
            ->select('mb.proyecto_id', DB::raw('SUM(mb.monto) as total'))
            ->where('mb.tipo', 'ingreso')
            ->where('mb.status', 'aplicado')
            ->where('cs.tipo', 'I')
            ->whereBetween('mb.fecha', [$fechaInicioEjercicio, $fechaLimite])
            ->groupBy('mb.proyecto_id')
            ->get();
        
        $gastosPorProyecto = DB::table('movimientos_bancarios as mb')
            ->join('codigos_sat as cs', 'mb.codigo_sat_id', '=', 'cs.id')
            ->select('mb.proyecto_id', DB::raw('SUM(mb.monto) as total'))
            ->where('mb.tipo', 'egreso')
            ->where('mb.status', 'aplicado')
            ->where('cs.tipo', 'G')
            ->whereBetween('mb.fecha', [$fechaInicioEjercicio, $fechaLimite])
            ->groupBy('mb.proyecto_id')
            ->get();
        
        // ============================================================
        // 9. CONSTRUIR DATOS PARA EL FRONTEND (TODOS LOS DATOS SIN FILTRAR)
        // ============================================================
        
        // Organizar clientes por proyecto
        $clientesData = [];
        foreach ($clientesPorProyecto as $item) {
            $proyectoId = $item->proyecto_id ?? 0;
            if (!isset($clientesData[$proyectoId])) {
                $clientesData[$proyectoId] = [];
            }
            $clientesData[$proyectoId][] = [
                'contacto_id' => $item->contacto_id,
                'razon_social' => $item->razon_social,
                'saldo' => $item->saldo
            ];
        }
        
        // Organizar inventarios por proyecto
        $inventarioData = [];
        foreach ($inventarioPorProyecto as $item) {
            $proyectoId = $item->proyecto_id ?? 0;
            if (!isset($inventarioData[$proyectoId])) {
                $inventarioData[$proyectoId] = [];
            }
            $inventarioData[$proyectoId][] = [
                'articulo' => $item->articulo,
                'codigo' => $item->codigo,
                'valor' => $item->valor_inventario
            ];
        }
        
        // Organizar activos fijos por proyecto
        $activosFijosData = [];
        foreach ($activosFijosPorProyecto as $item) {
            $proyectoId = $item->proyecto_id ?? 0;
            if (!isset($activosFijosData[$proyectoId])) {
                $activosFijosData[$proyectoId] = [];
            }
            $activosFijosData[$proyectoId][] = [
                'nombre' => $item->nombre,
                'codigo' => $item->codigo,
                'valor' => $item->valor_actual
            ];
        }
        
        // Organizar impuestos por proyecto
        $impuestosData = [];
        foreach ($impuestosPorProyecto as $item) {
            $proyectoId = $item->proyecto_id ?? 0;
            $impuestosData[$proyectoId] = $item->total_iva;
        }
        
        // Organizar ingresos/gastos por proyecto
        $ingresosData = [];
        foreach ($ingresosPorProyecto as $item) {
            $proyectoId = $item->proyecto_id ?? 0;
            $ingresosData[$proyectoId] = $item->total;
        }
        
        $gastosData = [];
        foreach ($gastosPorProyecto as $item) {
            $proyectoId = $item->proyecto_id ?? 0;
            $gastosData[$proyectoId] = $item->total;
        }
        
        // ============================================================
        // 10. DATOS PARA EL FRONTEND Conexion con blade completo (actualizacion)
        // ============================================================
        $datosBalance = [
            'saldoBancos' => $saldoBancos,
            'cuentasBancarias' => $cuentasBancarias,
            'clientesPorProyecto' => $clientesData,
            'inventarioPorProyecto' => $inventarioData,
            'activosFijosPorProyecto' => $activosFijosData,
            'totalProveedores' => $totalProveedores,
            'proveedores' => $proveedores,
            'impuestosPorProyecto' => $impuestosData,
            'prestamos' => $prestamos,
            'ingresosPorProyecto' => $ingresosData,
            'gastosPorProyecto' => $gastosData
        ];
        

        // Años disponibles
        $aniosDisponibles = DB::table('movimientos_bancarios')
            ->select(DB::raw('DISTINCT EXTRACT(YEAR FROM fecha) as anio'))
            ->where('status', 'aplicado')
            ->whereNotNull('codigo_sat_id')
            ->pluck('anio')
            ->toArray();
        
        if (empty($aniosDisponibles)) {
            $aniosDisponibles = [date('Y')];
        }
        sort($aniosDisponibles);
        
        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
        
        return view('conta.estados.balance', compact(
            'datosBalance',
            'proyectos',
            'proyectosSeleccionados',
            'anio',
            'mes',
            'aniosDisponibles',
            'meses'
        ));
    }
}