<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\RH\RolController;
use App\Http\Controllers\RH\PuestoController;
use App\Http\Controllers\RH\AreaController;
use App\Http\Controllers\RH\PlantillaController;
use App\Http\Controllers\RH\IncidenciaController;
use App\Http\Controllers\RH\CatTipoIncidenciaController;
use App\Http\Controllers\RH\AsistenciaController;
use App\Http\Controllers\RH\UserController;
use App\Http\Controllers\JustificacionPermisoController;
use App\Http\Controllers\ListaAsistenciaController;
use App\Http\Controllers\ControlHorariosController;
use App\Http\Controllers\NominaController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\VacacionController;
use App\Http\Controllers\FiniquitoController;
use App\Http\Controllers\TablaSueldoController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\MonedaController;
use App\Http\Controllers\TipoCambioController;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\CuentaBancariaController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\TipoIngresoController;
use App\Http\Controllers\TipoEgresoController;
use App\Http\Controllers\CategoriaGastoController;
use App\Http\Controllers\MovimientoBancarioController;
use App\Http\Controllers\CuentaContableController;
use App\Http\Controllers\DepositoController;
use App\Http\Controllers\ChequeTransferenciaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\TraspasoController;
use App\Http\Controllers\FlujoDineroController;
use App\Http\Controllers\FlujoMensualController;
use App\Http\Controllers\PresupuestoProyectoController;
use App\Http\Controllers\EstimacionesPartidaController;
use App\Models\Proyecto;
use App\Models\ProyectoPartida;
use App\Http\Controllers\RequisicionController;
use App\Http\Controllers\FamiliaController;
use App\Http\Controllers\InventarioProyectoController;
use App\Http\Controllers\RequisicionMaterialController;
use App\Http\Controllers\MovimientoInventarioController;
use App\Http\Controllers\TraspasoAlmacenController;
use App\Http\Controllers\AutorizacionRequisicionController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\CompraRecepcionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HitoController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\Facturacion\DatosGeneralesController;
use App\Http\Controllers\Facturacion\FacturaController;
use App\Http\Controllers\Facturacion\ReporteFacturasController;
use App\Http\Controllers\Facturacion\TimbradoController;
use App\Http\Controllers\ContrareciboController;
use App\Http\Controllers\FactorajeController;

// ============================================
// RUTAS PÚBLICAS
// ============================================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

// ============================================
// RUTAS CON AUTENTICACIÓN
// ============================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ==========================================
    // RUTAS API PARA PRESUPUESTO DE PROYECTOS
    // ==========================================
    Route::get('/api/proyectos', function() {
        $proyectos = Proyecto::where('status', 'activo')
            ->orderBy('codigo')
            ->get(['id', 'codigo', 'nombre', 'cliente_nombre', 'fecha_inicio', 'fecha_fin', 'ubicacion']);
        return response()->json(['success' => true, 'data' => $proyectos]);
    });
    
    Route::get('/api/proyectos/{proyecto}/presupuesto', [PresupuestoProyectoController::class, 'getPresupuesto']);
    Route::get('/api/proyectos/{proyecto}/partidas', [PresupuestoProyectoController::class, 'getPartidas']);
    Route::get('/api/proyectos/{proyecto}/partidas/{partida}', [PresupuestoProyectoController::class, 'getPartida']);
    Route::post('/api/proyectos/{proyecto}/partidas', [PresupuestoProyectoController::class, 'storePartida']);
    Route::put('/api/proyectos/{proyecto}/partidas/{partida}', [PresupuestoProyectoController::class, 'updatePartida']);
    Route::delete('/api/proyectos/{proyecto}/partidas/{partida}', [PresupuestoProyectoController::class, 'destroyPartida']);
    Route::get('/api/proyectos/{proyecto}/resumen-seccion', [PresupuestoProyectoController::class, 'getResumenPorSeccion']);
    Route::get('/api/proyectos/{proyecto}/exportar-excel', [PresupuestoProyectoController::class, 'exportarExcel']);
    Route::get('/api/proyectos/{proyecto}/partidas-por-seccion/{seccion}', [PresupuestoProyectoController::class, 'getPartidasPorSeccion']);
    
    // ============================================
    // ESTIMACIONES DE OBRA
    // ============================================
    Route::prefix('estimaciones')->name('estimaciones.')->group(function () {
        Route::get('/', [EstimacionesPartidaController::class, 'index'])->name('index');
        Route::get('/api/resumen', [EstimacionesPartidaController::class, 'getResumen']);
        Route::get('/api/detalle', [EstimacionesPartidaController::class, 'getDetalle']);
        Route::get('/api/proyectos', [EstimacionesPartidaController::class, 'getProyectos']);
        Route::get('/api/partidas/{proyectoId}', [EstimacionesPartidaController::class, 'getPartidasPorProyecto']);
        Route::get('/api/historial/{partidaId}', [EstimacionesPartidaController::class, 'getHistorialPartida']);
        Route::get('/exportar', [EstimacionesPartidaController::class, 'exportarResumen']);
        Route::get('/api/{id}', [EstimacionesPartidaController::class, 'show']);
        Route::post('/api', [EstimacionesPartidaController::class, 'store']);
        Route::put('/api/{id}', [EstimacionesPartidaController::class, 'update']);
        Route::delete('/api/{id}', [EstimacionesPartidaController::class, 'destroy']);
    });
});

Route::get('/tareas', function () {
    return view('tareas.index');
})->name('tareas.index')->middleware('auth');

// Grupo para BI
Route::prefix('bi')->group(function () {
    Route::get('/dashboard', function () { return view('bi.dashboard.dashboard'); })->name('bi.dashboard');
    Route::get('/licitaciones', function () { return view('bi.dashboard.licitaciones'); })->name('bi.licitaciones');
    Route::get('/finanzas', function () { return view('bi.dashboard.finanzas'); })->name('bi.finanzas');
    Route::get('/papeline', function () { return view('bi.ventas.papeline'); })->name('ventas.papeline');
    Route::get('/propuestas', function () { return view('bi.ventas.propuestas'); })->name('ventas.propuestas');
    Route::get('/analisis', function () { return view('bi.ventas.analisis'); })->name('ventas.analisis');
    Route::get('/seguimientofacturacion', function () { return view('bi.facturacion.seguimiento'); })->name('facturacion.seguimiento');
    Route::get('/pendientefacturacion', function () { return view('bi.facturacion.pendiente'); })->name('facturacion.pendiente');
    Route::get('/facturacion', function () { return view('bi.facturacion.facturacion'); })->name('facturacion.facturacion');
    Route::get('/historial', function () { return view('bi.cobranza.historial'); })->name('cobranza.historial');
    Route::get('/proyecciones', function () { return view('bi.cobranza.proyecciones'); })->name('cobranza.proyecciones');
});

// Grupo para Administración
Route::prefix('admin')->group(function () {
    Route::get('/facturacion', function () { return view('admin.facturacion.index'); })->name('admin.facturacion');
    Route::get('/cuentasporcobrar', function () { return view('administracion.cuentascobrar.saldos'); })->name('admin.saldos');
    Route::get('/cuentasporpagar', function () { return view('administracion.cuentaspago.pagos'); })->name('admin.pagos');
    Route::get('/cfdi', function () { return view('administracion.facturacion.cfdi'); })->name('admin.cfdi');
    Route::get('/notadecredito', function () { return view('administracion.facturacion.nota'); })->name('admin.nota');
    Route::get('/facturacion', function () { return view('administracion.facturacion.facturacion'); })->name('admin.facturacion');
    Route::get('/bitacora', function () { return view('administracion.facturacion.bitacora'); })->name('admin.bitacora');
    Route::get('/comiciones', function () { return view('administracion.facturacion.comiciones'); })->name('admin.comiciones');
    Route::get('/contrarecibo', function () { return view('administracion.facturacion.contrarecibo'); })->name('admin.contrarecibo');
    Route::get('/factoraje', function () { return view('administracion.facturacion.factoraje'); })->name('admin.factoraje');
    Route::get('/notadeventas', function () { return view('administracion.facturacion.ventas'); })->name('admin.ventas');
    Route::get('/conciliacion', function () { return view('administracion.tesoreria.conciliacion'); })->name('tesoreria.conciliacion');
    
    Route::get('/api/categorias-por-tipo-egreso/{tipoEgresoId}', [PagoController::class, 'getCategoriasPorTipoEgreso']);

    // TRASPASOS
    Route::get('/traspasos', [TraspasoController::class, 'index'])->name('traspasos.index');
    Route::get('/api/traspasos', [TraspasoController::class, 'getData']);
    Route::post('/api/traspasos', [TraspasoController::class, 'store']);
    Route::get('/api/traspasos/{id}', [TraspasoController::class, 'show']);
    Route::put('/api/traspasos/{id}', [TraspasoController::class, 'update']);
    Route::delete('/api/traspasos/{id}', [TraspasoController::class, 'destroy']);
    Route::post('/api/traspasos/{id}/aplicar', [TraspasoController::class, 'aplicar']);
    Route::get('/api/traspasos-estadisticas', [TraspasoController::class, 'getEstadisticas']);
    Route::get('/api/tipo-cambio', [TraspasoController::class, 'getTipoCambio']);

    // FLUJO DE DINERO
    Route::get('/flujos', [FlujoDineroController::class, 'index'])->name('tesoreria.flujos');
    Route::get('/api/flujo-dinero', [FlujoDineroController::class, 'getData']);
    Route::get('/api/flujo-dinero/semanas', [FlujoDineroController::class, 'getSemanas']);
    Route::get('/api/flujo-dinero/exportar-excel', [FlujoDineroController::class, 'exportarExcel']);

    // FLUJO DE DINERO MENSUAL
    Route::get('/flujo-mensual', [FlujoMensualController::class, 'index'])->name('tesoreria.flujo_mensual');
    Route::get('/api/flujo-mensual', [FlujoMensualController::class, 'getData']);
    Route::get('/api/flujo-mensual/exportar-excel', [FlujoMensualController::class, 'exportarExcel']);

    // DEPÓSITOS
    Route::get('/depositos', [DepositoController::class, 'index'])->name('depositos.index');
    Route::get('/api/depositos', [DepositoController::class, 'getData']);
    Route::post('/api/depositos', [DepositoController::class, 'store']);
    Route::get('/api/depositos/{id}', [DepositoController::class, 'show']);
    Route::put('/api/depositos/{id}', [DepositoController::class, 'update']);
    Route::delete('/api/depositos/{id}', [DepositoController::class, 'destroy']);
    Route::post('/api/depositos/{id}/aplicar', [DepositoController::class, 'aplicar']);
    
    // CHEQUES Y TRANSFERENCIAS
    Route::get('/api/cheques-transferencias', [ChequeTransferenciaController::class, 'getData']);
    Route::post('/api/cheques-transferencias', [ChequeTransferenciaController::class, 'store']);
    Route::get('/api/cheques-transferencias/{id}', [ChequeTransferenciaController::class, 'show']);
    Route::put('/api/cheques-transferencias/{id}', [ChequeTransferenciaController::class, 'update']);
    Route::delete('/api/cheques-transferencias/{id}', [ChequeTransferenciaController::class, 'destroy']);
    Route::post('/api/cheques-transferencias/{id}/aplicar', [ChequeTransferenciaController::class, 'aplicar']);
    Route::get('/test-datos', [ChequeTransferenciaController::class, 'test'])->name('test.datos');
    Route::get('/trasferencia', [ChequeTransferenciaController::class, 'index'])->name('tesoreria.trasferencia');
    
    // TESORERÍA
    Route::get('/estadosdecuenta', function () { return view('administracion.tesoreria.estadosdecuenta'); })->name('tesoreria.estadosdecuenta');
    Route::get('/flujomensual', function () { return view('administracion.tesoreria.flujomensual'); })->name('tesoreria.flujomensual');
    Route::get('/flujos', function () { return view('administracion.tesoreria.flujos'); })->name('tesoreria.flujos');
    Route::get('/programacion', function () { return view('administracion.tesoreria.programacion'); })->name('tesoreria.programacion');
    Route::get('/pagos', function () { return view('administracion.tesoreria.pagos'); })->name('tesoreria.pagos');
    Route::get('/facturacionproveedores', function () { return view('administracion.presupuestos.facturacion'); })->name('presupuestos.facturacion');
    Route::get('/gastosfijos', function () { return view('administracion.presupuestos.gastos'); })->name('presupuestos.gastos');
    Route::get('/presupuestomensual', function () { return view('administracion.presupuestos.mensual'); })->name('presupuestos.mensual');
    Route::get('/reasignacion', function () { return view('administracion.presupuestos.reasignacion'); })->name('presupuestos.reasignacion');
    Route::get('/anticipo', function () { return view('administracion.operaciones.anticipo'); })->name('operaciones.anticipo');
    Route::get('/credito', function () { return view('administracion.operaciones.credito'); })->name('operaciones.credito');
    Route::get('/prepago', function () { return view('administracion.operaciones.prepago'); })->name('operaciones.prepago');
    Route::get('/cuentasavanzadas', function () { return view('administracion.cuentasavanzadas.cuentasavanzadas'); })->name('cuentasavanzadas.cuentasavanzadas');

    // PROVEEDORES
    Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index');
    Route::get('/api/proveedores', [ProveedorController::class, 'getData']);
    Route::post('/api/proveedores', [ProveedorController::class, 'store']);
    Route::get('/api/proveedores/{id}', [ProveedorController::class, 'show']);
    Route::put('/api/proveedores/{id}', [ProveedorController::class, 'update']);
    Route::delete('/api/proveedores/{id}', [ProveedorController::class, 'destroy']);

    // PAGOS
    Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
    Route::get('/api/pagos', [PagoController::class, 'getData']);
    Route::post('/api/pagos', [PagoController::class, 'store']);
    Route::get('/api/pagos/{id}', [PagoController::class, 'show']);
    Route::put('/api/pagos/{id}', [PagoController::class, 'update']);
    Route::delete('/api/pagos/{id}', [PagoController::class, 'destroy']);
    Route::post('/api/pagos/{id}/aplicar', [PagoController::class, 'aplicar']);
    Route::get('/api/pagos-estadisticas', [PagoController::class, 'getEstadisticas']); 
});

// ==================== RUTAS FUERA DEL GRUPO ADMIN ====================

Route::prefix('config')->group(function () {
    Route::get('/config', function () { return view('config.index'); })->name('config.index');
    Route::get('/personalizacion', function () { return view('config.topmenu.menuconfi'); })->name('config.menuconfig');
});

Route::prefix('conta')->group(function () {
    Route::get('/analisis', function () { return view('conta.analisis.analisis'); })->name('conta.analisis');
    Route::get('/comparativos', function () { return view('conta.analisis.comparativos'); })->name('conta.comparativos');
    Route::get('/razones', function () { return view('conta.analisis.razones'); })->name('conta.razones');
    Route::get('/reportes', function () { return view('conta.analisis.reportes'); })->name('conta.reportes');
    Route::get('/auxiliar', function () { return view('conta.catalogo.auxiliar'); })->name('conta.auxiliar');
    Route::get('/centros', function () { return view('conta.catalogo.centros'); })->name('conta.centros');
    Route::get('/configuracion', function () { return view('conta.catalogo.configuracion'); })->name('conta.configuraciones');
    Route::get('/cuentas', function () { return view('conta.catalogo.cuentas'); })->name('conta.cuentas');
    Route::get('/amortizacion', function () { return view('conta.cierre.amortizacion'); })->name('conta.amortizacion');
    Route::get('/anual', function () { return view('conta.cierre.anual'); })->name('conta.anual');
    Route::get('/depreciaciones', function () { return view('conta.cierre.depreciaciones'); })->name('conta.depreciaciones');
    Route::get('/mensual', function () { return view('conta.cierre.mensual'); })->name('conta.mensual');
    Route::get('/estados', function () { return view('conta.estados.estados'); })->name('conta.estados');
    Route::get('/balance', function () { return view('conta.estados.balance'); })->name('conta.balance');
    Route::get('/capital', function () { return view('conta.estados.capital'); })->name('conta.capital');
    Route::get('/comprobacion', function () { return view('conta.estados.comprobacion'); })->name('conta.comprobacion');
    Route::get('/flujo', function () { return view('conta.estados.flujo'); })->name('conta.flujo');
    Route::get('/complementos', function () { return view('conta.fiscal.complementos'); })->name('conta.complementos');
    Route::get('/contabilidad', function () { return view('conta.fiscal.contabilidad'); })->name('conta.contabilidad');
    Route::get('/declarciones', function () { return view('conta.fiscal.declaraciones'); })->name('conta.declaracinoes');
    Route::get('/diot', function () { return view('conta.fiscal.diot'); })->name('conta.diot');
    Route::get('/retenciones', function () { return view('conta.fiscal.retenciones'); })->name('conta.retenciones');
    Route::get('/asignaciones', function () { return view('conta.porproyecto.asignacion'); })->name('conta.asignacion');
    Route::get('/cierre', function () { return view('conta.porproyecto.cierre'); })->name('conta.cierre');
    Route::get('/costo', function () { return view('conta.porproyecto.costo'); })->name('conta.costo');
    Route::get('/gastos', function () { return view('conta.porproyecto.gastos'); })->name('conta.gastos');
    Route::get('/rentabilidad', function () { return view('conta.porproyecto.rentabilidad'); })->name('conta.rentabilidad');
    Route::get('/ajustes', function () { return view('conta.registros.ajustes'); })->name('conta.ajustes');
    Route::get('/auxliar', function () { return view('conta.registros.auxiliar'); })->name('conta.regaux');
    Route::get('/diario', function () { return view('conta.registros.diario'); })->name('conta.diario');
    Route::get('/libro', function () { return view('conta.registros.libro'); })->name('conta.libro');
    Route::get('/poliza', function () { return view('conta.registros.polizas'); })->name('conta.polizas');
    Route::get('/unidadenegocios', function () { return view('conta.estados.unidad'); })->name('conta.unidad');
    Route::get('/liquidacion', function () { return view('conta.estados.liquidacion'); })->name('conta.liquidacion');
    Route::get('/general', function () { return view('conta.estados.general'); })->name('conta.general');
    Route::get('/mensuales', function () { return view('conta.fiscal.declaraciones'); })->name('conta.declaraciones');
    Route::get('/complemento', function () { return view('conta.fiscal.complementos'); })->name('conta.complemento');
    Route::get('/diariogeneral', function () { return view('conta.registros.diario'); })->name('conta.diario');
    Route::get('/cobranza', function () { return view('conta.registros.auxiliar'); })->name('conta.cobranza');
    Route::get('/centro', function () { return view('conta.catalogo.centros'); })->name('conta.centros');
    Route::get('/costoobras', function () { return view('conta.porproyecto.costo'); })->name('conta.costo');
    Route::get('/asignacion', function () { return view('conta.porproyecto.asignacion'); })->name('conta.asignacion');
    Route::get('/rentabilidad', function () { return view('conta.porproyecto.rentabilidad'); })->name('conta.rentabilidad');
});

// ============================================
// RUTAS PRINCIPALES DE RH
// ============================================
Route::prefix('rh')->name('rh.')->group(function () {
    // GESTION
    Route::get('/plantilla', [PlantillaController::class, 'index'])->name('plantilla');
    Route::get('/alta', function () { return view('rh.gestion.alta'); })->name('alta');
    Route::get('/expediente', function () { return view('rh.gestion.expediente'); })->name('expediente');
    Route::get('/historial-gestion', function () { return view('rh.gestion.historial'); })->name('historial_gestion');
    Route::get('/semaforo', function () { return view('rh.gestion.semaforo'); })->name('semaforo');
    
    // ASISTENCIA
    Route::get('/asistencia', function () { return view('rh.asistencia.asistencia'); })->name('asistencia');
    Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias');
    
    // JUSTIFICANTES
    Route::get('/justificantes', [JustificacionPermisoController::class, 'index'])->name('justificantes');
    Route::post('/justificantes', [JustificacionPermisoController::class, 'store'])->name('justificantes.store');
    Route::get('/justificantes/{id}', [JustificacionPermisoController::class, 'show']);
    Route::put('/justificantes/{id}', [JustificacionPermisoController::class, 'update']);
    Route::delete('/justificantes/{id}', [JustificacionPermisoController::class, 'destroy']);
    Route::get('/justificantes/{id}/print', [JustificacionPermisoController::class, 'print']);
    Route::get('/justificantes/{id}/justificante', [JustificacionPermisoController::class, 'downloadJustificante']);
    
    // LISTA DE ASISTENCIA DIARIA
    Route::get('/lista', [ListaAsistenciaController::class, 'index'])->name('lista');
    Route::post('/lista', [ListaAsistenciaController::class, 'store']);
    Route::post('/lista/generar', [ListaAsistenciaController::class, 'generarListaDiaria']);
    Route::get('/lista/{fecha}', [ListaAsistenciaController::class, 'show']);
    Route::put('/lista/detalle/{id}', [ListaAsistenciaController::class, 'updateDetalle']);
    Route::delete('/lista/{fecha}', [ListaAsistenciaController::class, 'destroy']);
    Route::get('/empleados-lista', [ListaAsistenciaController::class, 'getEmpleados']);
    
    // CONTROL DE HORARIOS
    Route::get('/control', [ControlHorariosController::class, 'index'])->name('control');
    Route::post('/control/registrar', [ControlHorariosController::class, 'registrar']);
    Route::put('/control/{id}', [ControlHorariosController::class, 'update']);
    Route::delete('/control/{id}', [ControlHorariosController::class, 'destroy']);
    Route::get('/control/resumen', [ControlHorariosController::class, 'getResumen']);
    
    // NOMINA
    Route::get('/calculo', function () { return view('rh.nomina.calculo'); })->name('calculo');
    Route::get('/historial-nomina', function () { return view('rh.nomina.historial'); })->name('historial_nomina');
    Route::get('/pagos', function () { return view('rh.nomina.pagos'); })->name('pagos');
    Route::get('/recibos', function () { return view('rh.nomina.recibos'); })->name('recibos');
    
    // TABLA DE SUELDOS
    Route::prefix('nomina/sueldos')->name('nomina.sueldos.')->group(function () {
        Route::get('/', [TablaSueldoController::class, 'index'])->name('index');
        Route::post('/', [TablaSueldoController::class, 'store'])->name('store');
        Route::get('/export', [TablaSueldoController::class, 'export'])->name('export');
        Route::get('/{id}', [TablaSueldoController::class, 'show'])->name('show');
        Route::put('/{id}', [TablaSueldoController::class, 'update'])->name('update');
        Route::delete('/{id}', [TablaSueldoController::class, 'destroy'])->name('destroy');
    });
    
    // PRESTACIONES
    Route::get('/aguinaldo', function () { return view('rh.prestaciones.aguinaldo'); })->name('aguinaldo');
    Route::get('/descuentos', function () { return view('rh.prestaciones.descuentos'); })->name('descuentos');
    Route::get('/finiquito', function () { return view('rh.prestaciones.finequito'); })->name('finiquito');
    Route::get('/vacaciones', function () { return view('rh.prestaciones.vacaciones'); })->name('vacaciones');
    
    // PRESTAMOS
    Route::prefix('prestamos')->name('prestamos.')->group(function () {
        Route::get('/export/excel', [PrestamoController::class, 'exportExcel'])->name('export');
        Route::get('/create', function() { return view('rh.prestaciones.prestamos_create'); })->name('create');
        Route::get('/', [PrestamoController::class, 'index'])->name('index');
        Route::post('/', [PrestamoController::class, 'store'])->name('store');
        Route::get('/{id}', [PrestamoController::class, 'show'])->name('show');
        Route::put('/{id}', [PrestamoController::class, 'update'])->name('update');
        Route::delete('/{id}', [PrestamoController::class, 'destroy'])->name('destroy');
    });

    // VACACIONES
    Route::prefix('vacaciones')->name('vacaciones.')->group(function () {
        Route::get('/export/excel', [VacacionController::class, 'exportExcel'])->name('export');
        Route::get('/', [VacacionController::class, 'index'])->name('index');
        Route::post('/', [VacacionController::class, 'store'])->name('store');
        Route::get('/{id}', [VacacionController::class, 'show'])->name('show');
        Route::put('/{id}', [VacacionController::class, 'update'])->name('update');
        Route::delete('/{id}', [VacacionController::class, 'destroy'])->name('destroy');
    });

    // FINIQUITOS Y LIQUIDACIONES
    Route::prefix('finiquito')->name('finiquito.')->group(function () {
        Route::get('/export/excel', [FiniquitoController::class, 'exportExcel'])->name('export');
        Route::get('/', [FiniquitoController::class, 'index'])->name('index');
        Route::post('/', [FiniquitoController::class, 'store'])->name('store');
        Route::get('/{id}', [FiniquitoController::class, 'show'])->name('show');
        Route::put('/{id}', [FiniquitoController::class, 'update'])->name('update');
        Route::delete('/{id}', [FiniquitoController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/autorizar', [FiniquitoController::class, 'autorizar'])->name('autorizar');
        Route::post('/{id}/pago', [FiniquitoController::class, 'registrarPago'])->name('pago');
    });
    
    // UNIDADES
    Route::get('/bitacora', function () { return view('rh.unidades.bitacora'); })->name('bitacora');
    Route::get('/carros', function () { return view('rh.unidades.carros'); })->name('carros');
    Route::get('/flotillas', function () { return view('rh.unidades.flotillas'); })->name('flotillas');
    Route::get('/semaforos-unidades', function () { return view('rh.unidades.semaforos'); })->name('semaforos_unidades');
    
    // CATALOGOS
    Route::get('/imss-catalogo', function () { return view('rh.catalogos.imss'); })->name('imss_catalogo');
    Route::get('/areas', [AreaController::class, 'index'])->name('areas');
    Route::get('/deducciones', function () { return view('rh.catalogos.deducciones'); })->name('deducciones');
    Route::get('/percepciones', function () { return view('rh.catalogos.percepciones'); })->name('percepciones');
    Route::get('/roles', [RolController::class, 'index'])->name('roles');
    Route::get('/turnos', function () { return view('rh.catalogos.turnos'); })->name('turnos');
    Route::get('/tipos-incidencias', [CatTipoIncidenciaController::class, 'index'])->name('tipos_incidencias');
    
    // REPORTES
    Route::get('/costos', function () { return view('rh.reportes.costos'); })->name('costos');
    Route::get('/sat', function () { return view('rh.reportes.sat'); })->name('sat');
    Route::get('/imss-reporte', function () { return view('rh.reportes.imss'); })->name('imss_reporte');

    // NOMINA
    Route::get('/nomina', [NominaController::class, 'indexView'])->name('nomina');

    // RUTAS API DE ASISTENCIA
    Route::prefix('asistencia-api')->name('asistencia.api.')->group(function () {
        Route::get('/', [AsistenciaController::class, 'index']);
        Route::post('/', [AsistenciaController::class, 'store']);
        Route::get('/{id}', [AsistenciaController::class, 'show']);
        Route::put('/{id}', [AsistenciaController::class, 'update']);
        Route::delete('/{id}', [AsistenciaController::class, 'destroy']);
        Route::post('/entrada', [AsistenciaController::class, 'registrarEntrada']);
        Route::post('/{id}/salida', [AsistenciaController::class, 'registrarSalida']);
        Route::get('/exportar-excel', [AsistenciaController::class, 'exportExcel'])->name('export');
    });
});

// ============================================
// ALMACEN - GRUPO PRINCIPAL
// ============================================
Route::prefix('almacen')->name('almacen.')->group(function () {
    
    // ============================================
    // MOVIMIENTOS
    // ============================================
    Route::get('/entrada', [App\Http\Controllers\MovimientoInventarioController::class, 'index'])->name('entrada');
    Route::get('/traspasos', [App\Http\Controllers\TraspasoAlmacenController::class, 'index'])->name('traspasos');
    Route::get('/vales', [App\Http\Controllers\MovimientoInventarioController::class, 'index'])->name('vales');
    
    // ============================================
    // REQUISICIONES DE MATERIAL
    // ============================================
    Route::get('/requisicion', [App\Http\Controllers\RequisicionMaterialController::class, 'index'])->name('requisicion');
    
    // ============================================
    // REQUISICIONES Y DEVOLUCIONES DE EQUIPO (ACTIVOS)
    // ============================================
    Route::get('/requisiciones-devoluciones-equipo', [App\Http\Controllers\EquipoRequisicionController::class, 'index'])->name('requisiciones_devoluciones_equipo');
    
    // ============================================
    // INVENTARIO FÍSICO
    // ============================================
    Route::get('/inventariofisico', [App\Http\Controllers\InventarioFisicoController::class, 'index'])->name('inventario');
    Route::get('/api/inventario-fisico', [App\Http\Controllers\InventarioFisicoController::class, 'getInventario'])->name('api.inventario-fisico');
    Route::get('/api/inventario-fisico/{id}', [App\Http\Controllers\InventarioFisicoController::class, 'show'])->name('api.inventario-fisico.show');
    Route::get('/api/inventario-fisico/exportar', [App\Http\Controllers\InventarioFisicoController::class, 'exportar'])->name('api.inventario-fisico.exportar');
    
    // ============================================
    // CATÁLOGOS
    // ============================================
    Route::get('/almacenes', [App\Http\Controllers\AlmacenController::class, 'index'])->name('almacen');
    Route::get('/articulos', [App\Http\Controllers\ArticuloController::class, 'index'])->name('articulo');
    Route::get('/familias', [App\Http\Controllers\FamiliaController::class, 'index'])->name('familias');
    Route::get('/activos', [App\Http\Controllers\ActivoController::class, 'index'])->name('activos');
    
    // ============================================
    // API ROUTES PARA ARTÍCULOS
    // ============================================
    Route::get('/api/articulos', [App\Http\Controllers\ArticuloController::class, 'getArticulos'])->name('api.articulos');
    Route::get('/api/articulos/{id}', [App\Http\Controllers\ArticuloController::class, 'show'])->name('api.articulos.show');
    Route::post('/api/articulos', [App\Http\Controllers\ArticuloController::class, 'store'])->name('api.articulos.store');
    Route::put('/api/articulos/{id}', [App\Http\Controllers\ArticuloController::class, 'update'])->name('api.articulos.update');
    Route::delete('/api/articulos/{id}', [App\Http\Controllers\ArticuloController::class, 'destroy'])->name('api.articulos.destroy');
    Route::get('/api/articulos/exportar', [App\Http\Controllers\ArticuloController::class, 'exportar'])->name('api.articulos.exportar');
    Route::get('/api/subfamilias-por-familia/{familiaId}', [App\Http\Controllers\ArticuloController::class, 'getSubfamiliasByFamilia'])->name('api.subfamilias-por-familia');

    // ============================================
    // API ROUTES PARA ALMACENES
    // ============================================
    Route::get('/api/almacenes', [App\Http\Controllers\AlmacenController::class, 'getAlmacenes'])->name('api.almacenes');
    Route::get('/api/almacenes/{id}', [App\Http\Controllers\AlmacenController::class, 'show'])->name('api.almacenes.show');
    Route::post('/api/almacenes', [App\Http\Controllers\AlmacenController::class, 'store'])->name('api.almacenes.store');
    Route::put('/api/almacenes/{id}', [App\Http\Controllers\AlmacenController::class, 'update'])->name('api.almacenes.update');
    Route::delete('/api/almacenes/{id}', [App\Http\Controllers\AlmacenController::class, 'destroy'])->name('api.almacenes.destroy');
    Route::post('/api/almacenes/{id}/reactivar', [App\Http\Controllers\AlmacenController::class, 'reactivar'])->name('api.almacenes.reactivar');
    Route::get('/api/almacenes/tipos', [App\Http\Controllers\AlmacenController::class, 'getTipos'])->name('api.almacenes.tipos');
    Route::get('/api/almacenes/exportar', [App\Http\Controllers\AlmacenController::class, 'exportar'])->name('api.almacenes.exportar');
    Route::get('/api/almacenes/estadisticas', [App\Http\Controllers\AlmacenController::class, 'getEstadisticas'])->name('api.almacenes.estadisticas');

    // ============================================
    // API ROUTES PARA FAMILIAS Y SUBFAMILIAS
    // ============================================
    Route::get('/api/familias', [App\Http\Controllers\FamiliaController::class, 'getFamilias'])->name('api.familias');
    Route::get('/api/subfamilias', [App\Http\Controllers\FamiliaController::class, 'getSubfamilias'])->name('api.subfamilias');
    Route::get('/api/familias-select', [App\Http\Controllers\FamiliaController::class, 'getFamiliasSelect'])->name('api.familias-select');
    
    Route::post('/api/familias', [App\Http\Controllers\FamiliaController::class, 'storeFamilia'])->name('api.familias.store');
    Route::put('/api/familias/{id}', [App\Http\Controllers\FamiliaController::class, 'updateFamilia'])->name('api.familias.update');
    Route::delete('/api/familias/{id}', [App\Http\Controllers\FamiliaController::class, 'destroyFamilia'])->name('api.familias.destroy');
    
    Route::post('/api/subfamilias', [App\Http\Controllers\FamiliaController::class, 'storeSubfamilia'])->name('api.subfamilias.store');
    Route::put('/api/subfamilias/{id}', [App\Http\Controllers\FamiliaController::class, 'updateSubfamilia'])->name('api.subfamilias.update');
    Route::delete('/api/subfamilias/{id}', [App\Http\Controllers\FamiliaController::class, 'destroySubfamilia'])->name('api.subfamilias.destroy');
    
    Route::get('/api/familias/exportar', [App\Http\Controllers\FamiliaController::class, 'exportarFamilias'])->name('api.familias.exportar');
    Route::get('/api/subfamilias/exportar', [App\Http\Controllers\FamiliaController::class, 'exportarSubfamilias'])->name('api.subfamilias.exportar');

    // ============================================
    // API ROUTES PARA ACTIVOS
    // ============================================
    Route::get('/api/activos', [App\Http\Controllers\ActivoController::class, 'getActivos'])->name('api.activos');
    Route::get('/api/activos/{id}', [App\Http\Controllers\ActivoController::class, 'show'])->name('api.activos.show');
    Route::post('/api/activos', [App\Http\Controllers\ActivoController::class, 'store'])->name('api.activos.store');
    Route::put('/api/activos/{id}', [App\Http\Controllers\ActivoController::class, 'update'])->name('api.activos.update');
    Route::delete('/api/activos/{id}', [App\Http\Controllers\ActivoController::class, 'destroy'])->name('api.activos.destroy');
    Route::post('/api/activos/{id}/asignar', [App\Http\Controllers\ActivoController::class, 'asignar'])->name('api.activos.asignar');
    Route::get('/api/activos/disponibles', [App\Http\Controllers\ActivoController::class, 'getDisponibles'])->name('api.activos.disponibles');
    Route::get('/api/activos/exportar', [App\Http\Controllers\ActivoController::class, 'exportar'])->name('api.activos.exportar');

    // ============================================
    // API ROUTES PARA REQUISICIONES DE ACTIVOS
    // ============================================
    Route::get('/api/requisiciones-activos', [App\Http\Controllers\RequisicionActivoController::class, 'getRequisiciones'])->name('api.requisiciones-activos');
    Route::get('/api/requisiciones-activos/{id}', [App\Http\Controllers\RequisicionActivoController::class, 'show'])->name('api.requisiciones-activos.show');
    Route::post('/api/requisiciones-activos', [App\Http\Controllers\RequisicionActivoController::class, 'store'])->name('api.requisiciones-activos.store');
    Route::post('/api/requisiciones-activos/{id}/autorizar', [App\Http\Controllers\RequisicionActivoController::class, 'autorizar'])->name('api.requisiciones-activos.autorizar');
    Route::post('/api/requisiciones-activos/{id}/rechazar', [App\Http\Controllers\RequisicionActivoController::class, 'rechazar'])->name('api.requisiciones-activos.rechazar');
    Route::delete('/api/requisiciones-activos/{id}', [App\Http\Controllers\RequisicionActivoController::class, 'destroy'])->name('api.requisiciones-activos.destroy');

    // ============================================
    // API ROUTES PARA DEVOLUCIONES/ASIGNACIONES DE ACTIVOS
    // ============================================
    Route::get('/api/devoluciones-activos', [App\Http\Controllers\DevolucionActivoController::class, 'getDevoluciones'])->name('api.devoluciones-activos');
    Route::post('/api/devoluciones-activos/salida', [App\Http\Controllers\DevolucionActivoController::class, 'registrarSalida'])->name('api.devoluciones-activos.salida');
    Route::post('/api/devoluciones-activos/{id}/devolver', [App\Http\Controllers\DevolucionActivoController::class, 'registrarDevolucion'])->name('api.devoluciones-activos.devolver');
    Route::get('/api/devoluciones-activos/asignaciones-activas', [App\Http\Controllers\DevolucionActivoController::class, 'getAsignacionesActivas'])->name('api.devoluciones-activos.asignaciones-activas');

    // Activos (repetido? pero se mantiene)
    Route::get('/activos', [App\Http\Controllers\ActivoController::class, 'index'])->name('activos');
    Route::get('/api/activos', [App\Http\Controllers\ActivoController::class, 'getActivos'])->name('api.activos');
    Route::get('/api/activos/{id}', [App\Http\Controllers\ActivoController::class, 'show'])->name('api.activos.show');
    Route::post('/api/activos', [App\Http\Controllers\ActivoController::class, 'store'])->name('api.activos.store');
    Route::put('/api/activos/{id}', [App\Http\Controllers\ActivoController::class, 'update'])->name('api.activos.update');
    Route::delete('/api/activos/{id}', [App\Http\Controllers\ActivoController::class, 'destroy'])->name('api.activos.destroy');
    Route::post('/api/activos/{id}/asignar', [App\Http\Controllers\ActivoController::class, 'asignar'])->name('api.activos.asignar');
    Route::get('/api/activos/disponibles', [App\Http\Controllers\ActivoController::class, 'getDisponibles'])->name('api.activos.disponibles');
    Route::get('/api/activos/exportar', [App\Http\Controllers\ActivoController::class, 'exportar'])->name('api.activos.exportar');
});

// ============================================
// INVENTARIO POR PROYECTO (API)
// ============================================
Route::prefix('inventario')->name('inventario.')->middleware(['auth'])->group(function () {
    
    Route::get('/api/inventario-por-obra', [App\Http\Controllers\InventarioProyectoController::class, 'getInventarioPorObra'])
        ->name('api.inventario-por-obra');
    
    Route::get('/api/filtros-catalogos', [App\Http\Controllers\InventarioProyectoController::class, 'getFiltrosCatalogos'])
        ->name('api.filtros-catalogos');
    
    Route::get('/api/movimientos', [App\Http\Controllers\MovimientoInventarioController::class, 'getMovimientos'])->name('api.movimientos');
    Route::post('/api/movimientos/entrada', [App\Http\Controllers\MovimientoInventarioController::class, 'registrarEntrada'])->name('api.movimientos.entrada');
    Route::post('/api/movimientos/salida', [App\Http\Controllers\MovimientoInventarioController::class, 'registrarSalida'])->name('api.movimientos.salida');
    Route::post('/api/movimientos/transferencia', [App\Http\Controllers\MovimientoInventarioController::class, 'transferir'])->name('api.movimientos.transferencia');
    Route::post('/api/movimientos/ajuste', [App\Http\Controllers\MovimientoInventarioController::class, 'ajustar'])->name('api.movimientos.ajuste');
    Route::get('/api/movimientos/saldo', [App\Http\Controllers\MovimientoInventarioController::class, 'getSaldo'])->name('api.movimientos.saldo');
    Route::get('/api/movimientos/resumen', [App\Http\Controllers\MovimientoInventarioController::class, 'getResumen'])->name('api.movimientos.resumen');
    Route::get('/api/movimientos/exportar', [App\Http\Controllers\MovimientoInventarioController::class, 'exportar'])->name('api.movimientos.exportar');
    Route::get('/api/movimientos/verificar-stock', [App\Http\Controllers\MovimientoInventarioController::class, 'verificarStock'])->name('api.movimientos.verificar-stock');
    Route::get('/api/movimientos/{id}', [App\Http\Controllers\MovimientoInventarioController::class, 'show'])->name('api.movimientos.show');

    Route::get('/api/inventario', [App\Http\Controllers\InventarioProyectoController::class, 'getInventario'])->name('api.inventario');
    Route::get('/api/inventario/{id}', [App\Http\Controllers\InventarioProyectoController::class, 'show'])->name('api.inventario.show');
    Route::post('/api/inventario', [App\Http\Controllers\InventarioProyectoController::class, 'store'])->name('api.inventario.store');
    Route::put('/api/inventario/{id}', [App\Http\Controllers\InventarioProyectoController::class, 'update'])->name('api.inventario.update');
    Route::post('/api/inventario/{id}/agregar-stock', [App\Http\Controllers\InventarioProyectoController::class, 'agregarStock'])->name('api.inventario.agregar-stock');
    Route::post('/api/inventario/{id}/retirar-stock', [App\Http\Controllers\InventarioProyectoController::class, 'retirarStock'])->name('api.inventario.retirar-stock');
    Route::post('/api/inventario/{id}/transferir-stock', [App\Http\Controllers\InventarioProyectoController::class, 'transferirStock'])->name('api.inventario.transferir-stock');
    Route::get('/api/inventario/resumen/{proyectoId}', [App\Http\Controllers\InventarioProyectoController::class, 'getResumenPorProyecto'])->name('api.inventario.resumen');
    Route::get('/api/inventario/exportar', [App\Http\Controllers\InventarioProyectoController::class, 'exportar'])->name('api.inventario.exportar');
    
    Route::get('/api/requisiciones', [App\Http\Controllers\RequisicionMaterialController::class, 'getRequisiciones'])->name('api.requisiciones');
    Route::get('/api/requisiciones/{id}', [App\Http\Controllers\RequisicionMaterialController::class, 'show'])->name('api.requisiciones.show');
    Route::post('/api/requisiciones', [App\Http\Controllers\RequisicionMaterialController::class, 'store'])->name('api.requisiciones.store');
    Route::post('/api/requisiciones/{id}/autorizar', [App\Http\Controllers\RequisicionMaterialController::class, 'autorizar'])->name('api.requisiciones.autorizar');
    Route::post('/api/requisiciones/{id}/rechazar', [App\Http\Controllers\RequisicionMaterialController::class, 'rechazar'])->name('api.requisiciones.rechazar');
    Route::get('/api/requisiciones/{id}/generar-surtido', [App\Http\Controllers\RequisicionMaterialController::class, 'generarSurtido'])->name('api.requisiciones.generar-surtido');
    Route::post('/api/requisiciones/{id}/ejecutar-surtido', [App\Http\Controllers\RequisicionMaterialController::class, 'ejecutarSurtido'])->name('api.requisiciones.ejecutar-surtido');
    Route::delete('/api/requisiciones/{id}', [App\Http\Controllers\RequisicionMaterialController::class, 'destroy'])->name('api.requisiciones.destroy');

    Route::post('/api/movimientos/recepcion-multiple', [App\Http\Controllers\MovimientoInventarioController::class, 'recepcionMultiple'])
        ->name('api.movimientos.recepcion-multiple');

    Route::post('/api/articulos/crear-temporal', [App\Http\Controllers\ArticuloController::class, 'crearTemporal'])
        ->name('api.articulos.crear-temporal');
});

// ============================================
// COMPRAS
// ============================================
Route::prefix('compras')->name('compras.')->group(function () {
    // Vistas simples
    Route::get('/requisicion', function () { return view('compras.requisicion.requisicion'); })->name('requisicion');
    Route::get('/autorizacion', function () { return view('compras.requisicion.autorizacion'); })->name('autorizacion');
    Route::get('/autorizaciones', function () { return view('compras.compras.autorizacion'); })->name('autorizaciones');
    Route::get('/proveedores', function () { return view('compras.subcontratistas.gestion'); })->name('gestion');
    Route::get('/almacenobra', function () {
        $proyectos = App\Models\Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        return view('compras.almacen.almacen', compact('proyectos'));
    })->name('almacen');

    // Proveedores
    Route::get('/proveedores', [App\Http\Controllers\ProveedorController::class, 'index'])->name('gestion');
    Route::get('/api/proveedores', [App\Http\Controllers\ProveedorController::class, 'getData'])->name('api.proveedores');
    Route::get('/api/proveedores/{id}', [App\Http\Controllers\ProveedorController::class, 'show'])->name('api.proveedores.show');
    Route::post('/api/proveedores', [App\Http\Controllers\ProveedorController::class, 'store'])->name('api.proveedores.store');
    Route::put('/api/proveedores/{id}', [App\Http\Controllers\ProveedorController::class, 'update'])->name('api.proveedores.update');
    Route::delete('/api/proveedores/{id}', [App\Http\Controllers\ProveedorController::class, 'destroy'])->name('api.proveedores.destroy');
    Route::get('/api/proveedores/exportar', [App\Http\Controllers\ProveedorController::class, 'exportar'])->name('api.proveedores.exportar');
    
    Route::get('/autorizaciones', [CotizacionController::class, 'autorizacionCotizaciones'])->name('autorizaciones');

    // ============================================
    // REQUISICIONES
    // ============================================
    Route::prefix('requisiciones')->name('requisiciones.')->group(function () {
        Route::get('/', [RequisicionController::class, 'index'])->name('index');
        Route::get('/generar-folio', [RequisicionController::class, 'generarFolio'])->name('generar-folio');
        Route::get('/proyectos', [RequisicionController::class, 'getProyectos'])->name('proyectos');
        Route::get('/areas', [RequisicionController::class, 'getAreas'])->name('areas');
        Route::get('/{id}', [RequisicionController::class, 'show'])->name('show');
        Route::post('/', [RequisicionController::class, 'store'])->name('store');
        Route::put('/{id}', [RequisicionController::class, 'update'])->name('update');
        Route::delete('/{id}', [RequisicionController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/aprobar', [RequisicionController::class, 'aprobar'])->name('aprobar');
        Route::post('/{id}/rechazar', [RequisicionController::class, 'rechazar'])->name('rechazar');
        Route::get('/exportar/excel', [RequisicionController::class, 'exportar'])->name('exportar');
    });

    // ============================================
    // AUTORIZACIÓN DE REQUISICIONES
    // ============================================
    Route::prefix('autorizacion-requisiciones')->name('autorizacion.')->group(function () {
        Route::get('/get-data', [AutorizacionRequisicionController::class, 'getRequisiciones'])->name('get-data');
        Route::post('/{id}/autorizar', [AutorizacionRequisicionController::class, 'autorizar'])->name('autorizar');
        Route::post('/{id}/rechazar', [AutorizacionRequisicionController::class, 'rechazar'])->name('rechazar');
        Route::post('/{id}/revertir', [AutorizacionRequisicionController::class, 'revertirAutorizacion'])->name('revertir');
        Route::post('/{id}/reabrir', [AutorizacionRequisicionController::class, 'reabrir'])->name('reabrir');
        Route::get('/{id}/detalle', [AutorizacionRequisicionController::class, 'detalle'])->name('detalle');
        Route::get('/exportar', [AutorizacionRequisicionController::class, 'exportar'])->name('exportar');
    });

    // ============================================
    // ÓRDENES PARA COTIZAR
    // ============================================
    Route::get('/ordenes', [CotizacionController::class, 'ordenesPendientes'])->name('ordenes');
    
    // ============================================
    // AUTORIZACIÓN DE COTIZACIONES
    // ============================================
    Route::get('/autorizacion-cotizaciones', [CotizacionController::class, 'autorizacionCotizaciones'])->name('autorizacion-cotizaciones');
    
    // ============================================
    // COTIZACIONES (API y vistas)
    // ============================================
    Route::prefix('cotizaciones')->name('cotizaciones.')->group(function () {
        Route::get('/', [CotizacionController::class, 'index'])->name('index');
        Route::get('/solicitar/{requisicionId}', [CotizacionController::class, 'solicitar'])->name('solicitar');
        Route::post('/', [CotizacionController::class, 'store'])->name('store');
        Route::get('/comparativo/{requisicionId}', [CotizacionController::class, 'comparativo'])->name('comparativo');
        Route::get('/comparativo-json/{requisicionId}', [CotizacionController::class, 'getComparativo'])->name('comparativo-json');
        Route::post('/seleccionar/{cotizacionId}', [CotizacionController::class, 'seleccionar'])->name('seleccionar');
        Route::get('/articulos/{requisicionId}', [CotizacionController::class, 'getArticulos'])->name('get-articulos');
        Route::get('/requisiciones-para-autorizar', [CotizacionController::class, 'requisicionesParaAutorizar'])->name('requisiciones-para-autorizar');
        Route::post('/autorizar-todas/{requisicionId}', [CotizacionController::class, 'autorizarTodasCotizaciones'])->name('autorizar-todas');
        Route::get('/{id}', [CotizacionController::class, 'show'])->name('show');
    });

    // ============================================
    // COMPRAS PENDIENTES DE RECEPCIÓN
    // ============================================
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/pendientes-recepcion', [App\Http\Controllers\CompraRecepcionController::class, 'pendientes'])
            ->name('pendientes-recepcion');
        Route::get('/pendientes-recepcion/{id}/detalle', [App\Http\Controllers\CompraRecepcionController::class, 'detalleCompra'])
            ->name('pendientes-recepcion.detalle');
    });
});

// ============================================
// PROYECTOS
// ============================================
Route::prefix('proyectos')->name('proyectos.')->middleware(['auth'])->group(function () {
    Route::get('/cartera', [ProyectoController::class, 'index'])->name('cartera');
    Route::get('/dashboard', [ProyectoController::class, 'dashboard'])->name('dashboard');
    Route::get('/alta', [ProyectoController::class, 'create'])->name('alta');
    Route::get('/create', [ProyectoController::class, 'create'])->name('create');
    Route::post('/', [ProyectoController::class, 'store'])->name('store');
    Route::get('/buscar/cliente', [ProyectoController::class, 'buscarCliente'])->name('buscar-cliente');
    
    Route::get('/presupuestos', function () { return view('proyectos.presupuestos.presupuestos'); })->name('presupuestos');
    Route::get('/presupuesto', function () { return view('proyectos.presupuestos.presupuesto'); })->name('presupuesto_proyecto');
    Route::get('/real', function () { return view('proyectos.presupuestos.real'); })->name('real');
    
    Route::get('/hitos', [HitoController::class, 'index'])->name('hitos');
    Route::get('/hitos/data', [HitoController::class, 'getHitos'])->name('hitos.data');
    Route::get('/hitos/estadisticas', [HitoController::class, 'estadisticas'])->name('hitos.stats');
    Route::get('/hitos/{id}', [HitoController::class, 'show'])->name('hitos.show');
    Route::post('/hitos', [HitoController::class, 'store'])->name('hitos.store');
    Route::put('/hitos/{id}', [HitoController::class, 'update'])->name('hitos.update');
    Route::put('/hitos/{id}/estado', [HitoController::class, 'cambiarEstado'])->name('hitos.estado');
    Route::delete('/hitos/{id}', [HitoController::class, 'destroy'])->name('hitos.destroy');

    Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora');
    Route::get('/asignacion', function () { return view('proyectos.personal.asignada'); })->name('asignada');
    Route::get('/flotillas', function () { return view('proyectos.personal.flotillas'); })->name('flotillas');
    Route::get('/maquinas', function () { return view('proyectos.maquinaria.asignacion'); })->name('asignacion');
    Route::get('/control', function () { return view('proyectos.maquinaria.control'); })->name('control');
    Route::get('/mantenimiento', function () { return view('proyectos.maquinaria.mantenimiento'); })->name('mantenimiento');
    Route::get('/bitaherramienta', function () { return view('proyectos.maquinaria.bitacora'); })->name('bita');
    Route::get('/planos', function () { return view('proyectos.documentacion.planos'); })->name('planos');
    Route::get('/permisos', function () { return view('proyectos.documentacion.permisos'); })->name('permisos');
    Route::get('/evidencia', function () { return view('proyectos.documentacion.evidencia'); })->name('evidencia');
    Route::get('/activas', function () { return view('proyectos.licitacion.activas'); })->name('activas');
    Route::get('/cotizaciones', function () { return view('proyectos.licitacion.presupuestos'); })->name('presupuestos_licitacion');
    Route::get('/analisis', function () { return view('proyectos.licitacion.analisis'); })->name('analisis');
    Route::get('/analisisrentabilidad', function () { return view('proyectos.costos.rentabilidad'); })->name('rentabilidad');
    Route::get('/indirectos', function () { return view('proyectos.costos.indirectos'); })->name('indirectos');
    Route::get('/directos', function () { return view('proyectos.costos.directos'); })->name('directos');
    Route::get('/estimaciones', function () { return view('proyectos.avances.estimaciones'); })->name('estimaciones');
    Route::get('/reportes', function () { return view('proyectos.avances.reportes'); })->name('reportes');
    Route::get('/control_proyectos', function () { return view('proyectos.control.control'); })->name('control');
    Route::get('/desviaciones', function () { return view('proyectos.control.desviaciones'); })->name('desviaciones');
    
    Route::get('/{id}/edit-data', [ProyectoController::class, 'editData'])->name('edit-data');
    Route::get('/{id}/detalle', [ProyectoController::class, 'getDetalle'])->name('detalle');
    Route::get('/{id}/edit', [ProyectoController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProyectoController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProyectoController::class, 'destroy'])->name('destroy');
    Route::post('/{proyecto_id}/documentos', [ProyectoController::class, 'subirDocumento'])->name('subir-documento');
    Route::get('/documentos/{id}/descargar', [ProyectoController::class, 'descargarDocumento'])->name('descargar-documento');
    Route::delete('/documentos/{id}', [ProyectoController::class, 'eliminarDocumento'])->name('eliminar-documento');
    
    Route::get('/{id}', [ProyectoController::class, 'show'])->name('show');
});

// ============================================
// BITÁCORA DE OBRA
// ============================================
Route::prefix('bitacora')->name('bitacora.')->middleware(['auth'])->group(function () {
    Route::get('/', [BitacoraController::class, 'index'])->name('index');
    Route::get('/export-pdf', [BitacoraController::class, 'exportPDF'])->name('export-pdf');
    Route::get('/print', [BitacoraController::class, 'printView'])->name('print');
});

// ============================================
// API ROUTES PARA BITÁCORA
// ============================================
Route::prefix('api/bitacora')->middleware(['auth'])->group(function () {
    Route::get('/entries', [BitacoraController::class, 'getEntries'])->name('api.bitacora.entries');
    Route::post('/entries', [BitacoraController::class, 'store'])->name('api.bitacora.store');
    Route::get('/entries/{id}', [BitacoraController::class, 'show'])->name('api.bitacora.show');
    Route::put('/entries/{id}', [BitacoraController::class, 'update'])->name('api.bitacora.update');
    Route::delete('/entries/{id}', [BitacoraController::class, 'destroy'])->name('api.bitacora.destroy');
    Route::post('/entries/{entryId}/comments', [BitacoraController::class, 'addComment'])->name('api.bitacora.comments.store');
    Route::delete('/comments/{id}', [BitacoraController::class, 'deleteComment'])->name('api.bitacora.comments.destroy');
    Route::post('/entries/{entryId}/upload-image', [BitacoraController::class, 'uploadImage'])->name('api.bitacora.images.upload');
    Route::delete('/images/{id}', [BitacoraController::class, 'deleteImage'])->name('api.bitacora.images.destroy');
    Route::get('/evidencias', [BitacoraController::class, 'getEvidencias'])->name('api.bitacora.evidencias');
    Route::get('/incidencias', [BitacoraController::class, 'getIncidencias'])->name('api.bitacora.incidencias');
    Route::get('/incidencias/{id}', [BitacoraController::class, 'getIncidencia'])->name('api.bitacora.incidencias.show');
    Route::put('/incidencias/{id}/resolve', [BitacoraController::class, 'resolveIncidencia'])->name('api.bitacora.incidencias.resolve');
    Route::put('/incidencias/{id}/prioridad', [BitacoraController::class, 'updatePrioridad'])->name('api.bitacora.incidencias.prioridad');
    Route::get('/estadisticas', [BitacoraController::class, 'getEstadisticas'])->name('api.bitacora.estadisticas');
    Route::get('/reportes/resumen', [BitacoraController::class, 'getResumenReporte'])->name('api.bitacora.reportes.resumen');
    Route::post('/reportes/generar', [BitacoraController::class, 'generarReporte'])->name('api.bitacora.reportes.generar');
    Route::get('/proyectos', [BitacoraController::class, 'getProyectosList'])->name('api.bitacora.proyectos');
    Route::get('/responsables', [BitacoraController::class, 'getResponsablesList'])->name('api.bitacora.responsables');
});

// ============================================
// RUTAS WEB CRUD
// ============================================
Route::resource('roles', RolController::class);
Route::resource('puestos', PuestoController::class);
Route::resource('areas', AreaController::class);
Route::resource('plantilla', PlantillaController::class)->parameters(['plantilla' => 'id']);
Route::resource('usuarios', UserController::class);

Route::post('roles/exportar-excel', [RolController::class, 'exportExcel'])->name('roles.export');
Route::post('puestos/exportar-excel', [PuestoController::class, 'exportExcel'])->name('puestos.export');
Route::post('areas/exportar-excel', [AreaController::class, 'exportExcel'])->name('areas.export');
Route::post('plantilla/exportar-excel', [PlantillaController::class, 'exportExcel'])->name('plantilla.export');
Route::post('usuarios/exportar-excel', [UserController::class, 'exportExcel'])->name('usuarios.export');

Route::get('roles/descargar-excel', [RolController::class, 'downloadExcel'])->name('roles.export.download');
Route::get('puestos/descargar-excel', [PuestoController::class, 'downloadExcel'])->name('puestos.export.download');
Route::get('areas/descargar-excel', [AreaController::class, 'downloadExcel'])->name('areas.export.download');
Route::get('plantilla/descargar-excel', [PlantillaController::class, 'downloadExcel'])->name('plantilla.export.download');
Route::get('usuarios/download-excel', [UserController::class, 'downloadExcel'])->name('usuarios.export.download');

// ============================================
// RUTAS API GENERALES
// ============================================
Route::prefix('api')->group(function () {
    Route::apiResource('roles', RolController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::post('roles/exportar-excel', [RolController::class, 'exportExcel']);
    Route::apiResource('puestos', PuestoController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::post('puestos/exportar-excel', [PuestoController::class, 'exportExcel']);
    Route::apiResource('areas', AreaController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::post('areas/exportar-excel', [AreaController::class, 'exportExcel']);
    Route::apiResource('usuarios', UserController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::post('usuarios/exportar-excel', [UserController::class, 'exportExcel']);
    Route::post('usuarios/{id}/reset-password', [UserController::class, 'resetPassword']);
    Route::get('roles-activos', [UserController::class, 'getRoles']);
    
    Route::get('plantilla', [PlantillaController::class, 'index']);
    Route::get('plantilla/datagrid', [PlantillaController::class, 'getDataGrid']);
    Route::post('plantilla', [PlantillaController::class, 'store']);
    Route::get('plantilla/{id}', [PlantillaController::class, 'show']);
    Route::put('plantilla/{id}', [PlantillaController::class, 'update']);
    Route::delete('plantilla/{id}', [PlantillaController::class, 'destroy']);
    Route::post('plantilla/exportar-excel', [PlantillaController::class, 'exportExcel']);
    Route::get('puestos-por-area', [PlantillaController::class, 'getPuestosByArea']);
    
    Route::prefix('plantilla/{id}')->group(function () {
        Route::get('documentos', [PlantillaController::class, 'getDocumentos']);
        Route::post('documentos/archivo', [PlantillaController::class, 'subirArchivoDocumento']);
        Route::delete('documentos/{documentoId}', [PlantillaController::class, 'eliminarDocumento']);
        Route::get('documentos/{documentoId}/descargar', [PlantillaController::class, 'descargarDocumento']);
    });
    
    Route::get('cat-tipos-incidencias', [CatTipoIncidenciaController::class, 'index']);
    Route::get('cat-tipos-incidencias/activos', [CatTipoIncidenciaController::class, 'getActivos']);
    Route::post('cat-tipos-incidencias', [CatTipoIncidenciaController::class, 'store']);
    Route::get('cat-tipos-incidencias/{id}', [CatTipoIncidenciaController::class, 'show']);
    Route::put('cat-tipos-incidencias/{id}', [CatTipoIncidenciaController::class, 'update']);
    Route::delete('cat-tipos-incidencias/{id}', [CatTipoIncidenciaController::class, 'destroy']);
    Route::patch('cat-tipos-incidencias/{id}/toggle-active', [CatTipoIncidenciaController::class, 'toggleActive']);
    Route::get('cat-tipos-incidencias/stats', [CatTipoIncidenciaController::class, 'getStats']);
    
    Route::get('incidencias', [IncidenciaController::class, 'index']);
    Route::get('incidencias/datagrid', [IncidenciaController::class, 'getDataGrid']);
    Route::post('incidencias', [IncidenciaController::class, 'store']);
    Route::get('incidencias/{id}', [IncidenciaController::class, 'show']);
    Route::put('incidencias/{id}', [IncidenciaController::class, 'update']);
    Route::delete('incidencias/{id}', [IncidenciaController::class, 'destroy']);

    Route::get('asistencias/empleados-a-cargo', [AsistenciaController::class, 'getEmpleadosACargo']);
    Route::post('asistencias/masivo', [AsistenciaController::class, 'storeMasivo']);
    Route::post('asistencias/entrada', [AsistenciaController::class, 'registrarEntrada']);
    Route::post('asistencias/exportar-excel', [AsistenciaController::class, 'exportExcel']);
    Route::get('asistencias/debug', [AsistenciaController::class, 'debugEmpleados']);
    Route::get('asistencias/test-empleados', [AsistenciaController::class, 'testEmpleados']);
    Route::get('asistencias', [AsistenciaController::class, 'index']);
    Route::post('asistencias', [AsistenciaController::class, 'store']);
    Route::get('asistencias/{id}', [AsistenciaController::class, 'show']);
    Route::put('asistencias/{id}', [AsistenciaController::class, 'update']);
    Route::delete('asistencias/{id}', [AsistenciaController::class, 'destroy']);
    Route::post('asistencias/{id}/salida', [AsistenciaController::class, 'registrarSalida']);
    
    Route::resource('justificaciones-permisos', JustificacionPermisoController::class)->except(['create', 'edit']);
    Route::get('justificaciones-permisos/{id}/print', [JustificacionPermisoController::class, 'print']);
    Route::get('justificaciones-permisos/{id}/justificante', [JustificacionPermisoController::class, 'downloadJustificante']);
});

// ============================================
// CHAT
// ============================================
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/chat/conversations', [ChatController::class, 'getConversations']);
    Route::get('/chat/users', [ChatController::class, 'getUsers']);
    Route::get('/chat/messages/{userId}', [ChatController::class, 'getMessages']);
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
    Route::post('/chat/mark-read/{userId}', [ChatController::class, 'markAsRead']);
    Route::get('/chat/unread-count', [ChatController::class, 'getTotalUnreadCount'])->middleware('auth');
});

// ============================================
// RUTAS PARA CATÁLOGOS
// ============================================
Route::middleware(['auth'])->group(function () {
    Route::get('/administracion/cuentasavanzadas', function () {
        return view('administracion.cuentasavanzadas.cuentasavanzadas');
    })->name('cuentasavanzadas');
    
    Route::get('/monedas', [MonedaController::class, 'index'])->name('monedas.index');
    Route::get('/monedas/create', [MonedaController::class, 'create'])->name('monedas.create');
    Route::post('/monedas', [MonedaController::class, 'store'])->name('monedas.store');
    Route::get('/monedas/{id}/edit', [MonedaController::class, 'edit'])->name('monedas.edit');
    Route::put('/monedas/{id}', [MonedaController::class, 'update'])->name('monedas.update');
    Route::delete('/monedas/{id}', [MonedaController::class, 'destroy'])->name('monedas.destroy');
    
    Route::get('/tipos-cambio', [TipoCambioController::class, 'index'])->name('tipos-cambio.index');
    Route::get('/tipos-cambio/create', [TipoCambioController::class, 'create'])->name('tipos-cambio.create');
    Route::post('/tipos-cambio', [TipoCambioController::class, 'store'])->name('tipos-cambio.store');
    Route::get('/tipos-cambio/{id}/edit', [TipoCambioController::class, 'edit'])->name('tipos-cambio.edit');
    Route::put('/tipos-cambio/{id}', [TipoCambioController::class, 'update'])->name('tipos-cambio.update');
    Route::delete('/tipos-cambio/{id}', [TipoCambioController::class, 'destroy'])->name('tipos-cambio.destroy');
    
    Route::get('/bancos', [BancoController::class, 'index'])->name('bancos.index');
    Route::get('/bancos/create', [BancoController::class, 'create'])->name('bancos.create');
    Route::post('/bancos', [BancoController::class, 'store'])->name('bancos.store');
    Route::get('/bancos/{id}/edit', [BancoController::class, 'edit'])->name('bancos.edit');
    Route::put('/bancos/{id}', [BancoController::class, 'update'])->name('bancos.update');
    Route::delete('/bancos/{id}', [BancoController::class, 'destroy'])->name('bancos.destroy');
    
    Route::get('/cuentas-bancarias', [CuentaBancariaController::class, 'index'])->name('cuentas-bancarias.index');
    Route::get('/cuentas-bancarias/create', [CuentaBancariaController::class, 'create'])->name('cuentas-bancarias.create');
    Route::post('/cuentas-bancarias', [CuentaBancariaController::class, 'store'])->name('cuentas-bancarias.store');
    Route::get('/cuentas-bancarias/{id}/edit', [CuentaBancariaController::class, 'edit'])->name('cuentas-bancarias.edit');
    Route::put('/cuentas-bancarias/{id}', [CuentaBancariaController::class, 'update'])->name('cuentas-bancarias.update');
    Route::delete('/cuentas-bancarias/{id}', [CuentaBancariaController::class, 'destroy'])->name('cuentas-bancarias.destroy');
    
    Route::get('/metodos-pago', [MetodoPagoController::class, 'index'])->name('metodos-pago.index');
    Route::get('/metodos-pago/create', [MetodoPagoController::class, 'create'])->name('metodos-pago.create');
    Route::post('/metodos-pago', [MetodoPagoController::class, 'store'])->name('metodos-pago.store');
    Route::get('/metodos-pago/{id}/edit', [MetodoPagoController::class, 'edit'])->name('metodos-pago.edit');
    Route::put('/metodos-pago/{id}', [MetodoPagoController::class, 'update'])->name('metodos-pago.update');
    Route::delete('/metodos-pago/{id}', [MetodoPagoController::class, 'destroy'])->name('metodos-pago.destroy');
    
    Route::get('/tipos-ingreso', [TipoIngresoController::class, 'index'])->name('tipos-ingreso.index');
    Route::get('/tipos-ingreso/create', [TipoIngresoController::class, 'create'])->name('tipos-ingreso.create');
    Route::post('/tipos-ingreso', [TipoIngresoController::class, 'store'])->name('tipos-ingreso.store');
    Route::get('/tipos-ingreso/{id}/edit', [TipoIngresoController::class, 'edit'])->name('tipos-ingreso.edit');
    Route::put('/tipos-ingreso/{id}', [TipoIngresoController::class, 'update'])->name('tipos-ingreso.update');
    Route::delete('/tipos-ingreso/{id}', [TipoIngresoController::class, 'destroy'])->name('tipos-ingreso.destroy');
    
    Route::get('/tipos-egreso', [TipoEgresoController::class, 'index'])->name('tipos-egreso.index');
    Route::get('/tipos-egreso/create', [TipoEgresoController::class, 'create'])->name('tipos-egreso.create');
    Route::post('/tipos-egreso', [TipoEgresoController::class, 'store'])->name('tipos-egreso.store');
    Route::get('/tipos-egreso/{id}/edit', [TipoEgresoController::class, 'edit'])->name('tipos-egreso.edit');
    Route::put('/tipos-egreso/{id}', [TipoEgresoController::class, 'update'])->name('tipos-egreso.update');
    Route::delete('/tipos-egreso/{id}', [TipoEgresoController::class, 'destroy'])->name('tipos-egreso.destroy');
    
    Route::get('/categorias-gasto', [CategoriaGastoController::class, 'index'])->name('categorias-gasto.index');
    Route::get('/categorias-gasto/create', [CategoriaGastoController::class, 'create'])->name('categorias-gasto.create');
    Route::post('/categorias-gasto', [CategoriaGastoController::class, 'store'])->name('categorias-gasto.store');
    Route::get('/categorias-gasto/{id}/edit', [CategoriaGastoController::class, 'edit'])->name('categorias-gasto.edit');
    Route::put('/categorias-gasto/{id}', [CategoriaGastoController::class, 'update'])->name('categorias-gasto.update');
    Route::delete('/categorias-gasto/{id}', [CategoriaGastoController::class, 'destroy'])->name('categorias-gasto.destroy');
    
    Route::get('/movimientos', [MovimientoBancarioController::class, 'index'])->name('movimientos.index');
    Route::get('/movimientos/create', [MovimientoBancarioController::class, 'create'])->name('movimientos.create');
    Route::post('/movimientos', [MovimientoBancarioController::class, 'store'])->name('movimientos.store');
    Route::get('/movimientos/{id}', [MovimientoBancarioController::class, 'show'])->name('movimientos.show');
    Route::get('/movimientos/{id}/edit', [MovimientoBancarioController::class, 'edit'])->name('movimientos.edit');
    Route::put('/movimientos/{id}', [MovimientoBancarioController::class, 'update'])->name('movimientos.update');
    Route::delete('/movimientos/{id}', [MovimientoBancarioController::class, 'destroy'])->name('movimientos.destroy');
    Route::post('/movimientos/{id}/aplicar', [MovimientoBancarioController::class, 'aplicar'])->name('movimientos.aplicar');
    Route::post('/movimientos/{id}/cancelar', [MovimientoBancarioController::class, 'cancelar'])->name('movimientos.cancelar');
    
    Route::get('/registro-cuentas', [CuentaContableController::class, 'index'])->name('registro.cuentas');
    Route::get('/cuentas-bancarias', [CuentaBancariaController::class, 'index'])->name('cuentas.bancarias');
    
    Route::get('/api/categorias-por-tipo-egreso/{tipoEgresoId}', [CategoriaGastoController::class, 'getPorTipoEgreso']);
    Route::get('/api/saldo-cuenta/{cuentaId}', [MovimientoBancarioController::class, 'getSaldoCuenta']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/movimientos-bancarios-data', [MovimientoBancarioController::class, 'getDataForEstadosCuenta']);
});

// Dashboard
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

// API Routes for Dashboard
Route::prefix('api/dashboard')->group(function () {
    Route::get('/ventas-tendencia', [App\Http\Controllers\DashboardController::class, 'getVentasTendencia']);
    Route::get('/ventas-proyecto', [App\Http\Controllers\DashboardController::class, 'getVentasProyecto']);
    Route::get('/facturacion-diaria', [App\Http\Controllers\DashboardController::class, 'getFacturacionDiaria']);
    Route::get('/cuentas-pagar', [App\Http\Controllers\DashboardController::class, 'getCuentasPagar']);
    Route::get('/cuentas-cobrar', [App\Http\Controllers\DashboardController::class, 'getCuentasCobrar']);
    Route::get('/rentabilidad', [App\Http\Controllers\DashboardController::class, 'getRentabilidad']);
    Route::get('/estado-resultados', [App\Http\Controllers\DashboardController::class, 'getEstadoResultados']);
    Route::get('/nomina-resumen', [App\Http\Controllers\DashboardController::class, 'getNominaResumen']);
    Route::get('/nomina-proyectos', [App\Http\Controllers\DashboardController::class, 'getNominaProyectos']);
    Route::get('/maquinaria-estado', [App\Http\Controllers\DashboardController::class, 'getMaquinariaEstado']);
    Route::get('/maquinaria-costos', [App\Http\Controllers\DashboardController::class, 'getMaquinariaCostos']);
});

// ============================================
// RUTAS DE FACTURACIÓN - OPTIMIZADAS Y ORGANIZADAS
// ============================================

Route::middleware(['auth'])->group(function () {

    // Agrega esta línea dentro del grupo de rutas con auth, cerca de las otras rutas de facturación
Route::get('/api/facturas-para-pago', [App\Http\Controllers\Facturacion\FacturaController::class, 'getFacturasParaPago']);
    
    // ==========================================
    // VISTAS PRINCIPALES
    // ==========================================
    Route::get('/facturacion', [App\Http\Controllers\Facturacion\FacturaController::class, 'indexView'])->name('facturacion.index');
    
    // ==========================================
    // API PARA DATOS DE TABLA Y DETALLES
    // ==========================================
    Route::get('/facturacion/data', [App\Http\Controllers\Facturacion\FacturaController::class, 'getData']);
    Route::get('/facturacion/{id}', [App\Http\Controllers\Facturacion\FacturaController::class, 'show']);
    Route::get('/facturacion/{id}/edit', [App\Http\Controllers\Facturacion\FacturaController::class, 'edit']);
    
    // ==========================================
    // PDF Y XML - DEBEN IR ANTES DE LA RUTA {id}
    // ==========================================
    Route::get('/facturacion/{id}/pdf', [App\Http\Controllers\Facturacion\FacturaController::class, 'pdf'])->name('facturacion.pdf');
    Route::get('/facturacion/{id}/xml', [App\Http\Controllers\Facturacion\FacturaController::class, 'downloadXml'])->name('facturacion.xml');
    
    // ==========================================
    // CRUD DE FACTURAS
    // ==========================================
    Route::post('/api/facturas', [App\Http\Controllers\Facturacion\FacturaController::class, 'store']);
    Route::put('/api/facturas/{id}', [App\Http\Controllers\Facturacion\FacturaController::class, 'update']);
    Route::delete('/api/facturas/{id}', [App\Http\Controllers\Facturacion\FacturaController::class, 'destroy']);
    
    // ==========================================
    // ACCIONES ESPECIALES
    // ==========================================
    Route::post('/facturacion/{id}/timbrar', [App\Http\Controllers\Facturacion\FacturaController::class, 'timbrar']);
    Route::post('/facturacion/{id}/cancelar', [App\Http\Controllers\Facturacion\FacturaController::class, 'cancelar']);
    Route::post('/facturacion/{id}/enviar-correo', [App\Http\Controllers\Facturacion\FacturaController::class, 'enviarCorreo']);
    
    // ==========================================
    // CATÁLOGOS PARA SELECTS (API)
    // ==========================================
    
    // Proyectos
    Route::get('/api/proyectos/activos', [App\Http\Controllers\Facturacion\FacturaController::class, 'getProyectosActivos']);
    
    // Clientes
    Route::get('/api/contactos', [App\Http\Controllers\Facturacion\FacturaController::class, 'getClientes']);
    
    // Series y folios
    Route::get('/api/series/activas', [App\Http\Controllers\Facturacion\FacturaController::class, 'getSeriesActivas']);
    Route::get('/api/series/{id}/siguiente-folio', [App\Http\Controllers\Facturacion\FacturaController::class, 'getSiguienteFolio']);
    
    // Catálogos SAT
    Route::get('/api/sat/uso-cfdi', [App\Http\Controllers\Facturacion\FacturaController::class, 'getUsosCFDI']);
    Route::get('/api/sat/formas-pago', [App\Http\Controllers\Facturacion\FacturaController::class, 'getFormasPago']);
    Route::get('/api/sat/metodos-pago', [App\Http\Controllers\Facturacion\FacturaController::class, 'getMetodosPago']);
});

// ==========================================
// RUTAS DE RESPALDO CON DB::table() POR SI LOS MODELOS NO EXISTEN
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // Respaldo para proyectos
    Route::get('/api/v2/proyectos/activos', function() {
        try {
            $proyectos = DB::table('proyectos')
                ->where('status', 'activo')
                ->whereNull('deleted_at')
                ->select('id', 'codigo', 'nombre')
                ->orderBy('codigo')
                ->get();
            return response()->json($proyectos);
        } catch (\Exception $e) {
            return response()->json([]);
        }
    });
    
    // Respaldo para clientes
    Route::get('/api/v2/contactos', function() {
        try {
            $contactos = DB::table('contactos')
                ->where('estatus', true)
                ->whereNull('deleted_at')
                ->where(function($q) {
                    $q->where('tipo', 'cliente')->orWhere('tipo', 'ambos');
                })
                ->select('contacto_id', 'razon_social', 'rfc')
                ->orderBy('razon_social')
                ->get();
            return response()->json($contactos);
        } catch (\Exception $e) {
            return response()->json([]);
        }
    });
    
    // Respaldo para series
    Route::get('/api/v2/series/activas', function() {
        try {
            $series = DB::table('cat_series')
                ->where('activo', true)
                ->select('cat_serie_id', 'serie', 'descripcion', 'folio_actual', 'folio_final')
                ->orderBy('serie')
                ->get();
            return response()->json($series);
        } catch (\Exception $e) {
            return response()->json([]);
        }
    });
    
    // Respaldo para usos CFDI
    Route::get('/api/v2/sat/uso-cfdi', function() {
        try {
            $usos = DB::table('satcat_uso_cfdi')
                ->where('estatus', true)
                ->select('clave', 'descripcion')
                ->orderBy('clave')
                ->get();
            return response()->json($usos);
        } catch (\Exception $e) {
            return response()->json([
                ['clave' => 'G01', 'descripcion' => 'Adquisición de mercancías'],
                ['clave' => 'G02', 'descripcion' => 'Devoluciones, descuentos o bonificaciones'],
                ['clave' => 'G03', 'descripcion' => 'Gastos en general'],
            ]);
        }
    });
    
    // Respaldo para formas de pago
    Route::get('/api/v2/sat/formas-pago', function() {
        try {
            $formas = DB::table('satcat_formas_pago')
                ->where('estatus', true)
                ->select('clave', 'descripcion')
                ->orderBy('clave')
                ->get();
            return response()->json($formas);
        } catch (\Exception $e) {
            return response()->json([
                ['clave' => '01', 'descripcion' => 'Efectivo'],
                ['clave' => '02', 'descripcion' => 'Cheque nominativo'],
                ['clave' => '03', 'descripcion' => 'Transferencia electrónica de fondos'],
            ]);
        }
    });
    
    // Respaldo para métodos de pago
    Route::get('/api/v2/sat/metodos-pago', function() {
        try {
            $metodos = DB::table('satcat_metodos_pago')
                ->where('estatus', true)
                ->select('clave', 'descripcion')
                ->orderBy('clave')
                ->get();
            return response()->json($metodos);
        } catch (\Exception $e) {
            return response()->json([
                ['clave' => 'PUE', 'descripcion' => 'Pago en una sola exhibición'],
                ['clave' => 'PPD', 'descripcion' => 'Pago en parcialidades o diferido'],
            ]);
        }
    });
});

// ============================================
// RUTAS PARA NOTAS DE CRÉDITO
// ============================================

Route::middleware(['auth'])->group(function () {
    
    // ==========================================
    // VISTA PRINCIPAL
    // ==========================================
    Route::get('/notas-credito', [App\Http\Controllers\Facturacion\NotaCreditoController::class, 'indexView'])->name('notas-credito.index');
    
    // ==========================================
    // API PARA DATOS DE TABLA
    // ==========================================
    Route::get('/notas-credito/data', [App\Http\Controllers\Facturacion\NotaCreditoController::class, 'getData']);
    
    // ==========================================
    // DATOS PARA CREAR NUEVA NOTA DE CRÉDITO
    // ==========================================
    Route::get('/notas-credito/create-data', [App\Http\Controllers\Facturacion\NotaCreditoController::class, 'create']);
    
    // ==========================================
    // MOSTRAR NOTA DE CRÉDITO ESPECÍFICA
    // ==========================================
    Route::get('/notas-credito/{id}', [App\Http\Controllers\Facturacion\NotaCreditoController::class, 'show']);
    
    // ==========================================
    // PDF DE NOTA DE CRÉDITO
    // ==========================================
    Route::get('/notas-credito/{id}/pdf', [App\Http\Controllers\Facturacion\NotaCreditoController::class, 'pdf']);
    
    // ==========================================
    // CRUD DE NOTAS DE CRÉDITO
    // ==========================================
    Route::post('/api/notas-credito', [App\Http\Controllers\Facturacion\NotaCreditoController::class, 'store']);
    Route::delete('/api/notas-credito/{id}', [App\Http\Controllers\Facturacion\NotaCreditoController::class, 'destroy']);
    
    // ==========================================
    // OBTENER FACTURAS PARA RELACIONAR (Nota de Crédito)
    // ==========================================
    Route::get('/api/facturas-para-nota-credito', [App\Http\Controllers\Facturacion\FacturaController::class, 'getFacturasParaNotaCredito']);
    
    // ==========================================
    // OBTENER SERIES PARA NOTAS DE CRÉDITO
    // ==========================================
    Route::get('/api/series-nota-credito', [App\Http\Controllers\Facturacion\FacturaController::class, 'getSeriesNotaCredito']);
});

// ============================================
// RUTAS PARA CFDI
// ============================================
Route::middleware(['auth'])->group(function () {
    Route::get('/cfdi', [App\Http\Controllers\Facturacion\CFDIController::class, 'indexView'])->name('cfdi.index');
    Route::get('/cfdi/data', [App\Http\Controllers\Facturacion\CFDIController::class, 'getData']);
    Route::get('/cfdi/{id}', [App\Http\Controllers\Facturacion\CFDIController::class, 'show']);
    Route::get('/cfdi/{id}/pdf', [App\Http\Controllers\Facturacion\CFDIController::class, 'pdf']);
    Route::get('/cfdi/{id}/xml', [App\Http\Controllers\Facturacion\CFDIController::class, 'xml']);
});

// ============================================
// RUTAS PARA VENTAS
// ============================================
Route::middleware(['auth'])->group(function () {
    Route::get('/ventas', [App\Http\Controllers\VentasController::class, 'indexView'])->name('ventas.index');
    Route::get('/ventas/data', [App\Http\Controllers\VentasController::class, 'getData']);
    Route::get('/ventas/{id}', [App\Http\Controllers\VentasController::class, 'show']);
});
// ============================================
// RUTAS PARA CONTRARECIBOS
// ============================================

Route::middleware(['auth'])->group(function () {
    Route::get('/contrarecibos', [App\Http\Controllers\ContrareciboController::class, 'indexView'])->name('contrarecibos.index');
    Route::get('/contrarecibos/data', [App\Http\Controllers\ContrareciboController::class, 'getData']);
    Route::post('/contrarecibos', [App\Http\Controllers\ContrareciboController::class, 'store']);
    Route::get('/contrarecibos/{id}', [App\Http\Controllers\ContrareciboController::class, 'show']);
    Route::delete('/contrarecibos/{id}', [App\Http\Controllers\ContrareciboController::class, 'destroy']);
});

// ============================================
// RUTAS PARA FACTORAJE
// ============================================

Route::middleware(['auth'])->group(function () {
    // Factoraje
    Route::get('/factoraje', [FactorajeController::class, 'indexView'])->name('factoraje');
    Route::get('/factoraje/data', [FactorajeController::class, 'getData']);
    Route::get('/factoraje/create', [FactorajeController::class, 'create']);
    Route::get('/factoraje/factores', [FactorajeController::class, 'getFactores']);
    Route::get('/factoraje/clientes-con-facturas', [FactorajeController::class, 'getClientesConFacturas']);
    Route::get('/factoraje/facturas-disponibles', [FactorajeController::class, 'getFacturasDisponibles']);
    Route::get('/factoraje/solicitud/{id}', [FactorajeController::class, 'show']);
    Route::post('/factoraje/solicitud', [FactorajeController::class, 'store']);
    Route::put('/factoraje/solicitud/{id}/autorizar', [FactorajeController::class, 'autorizar']);
    Route::put('/factoraje/solicitud/{id}/rechazar', [FactorajeController::class, 'rechazar']);
    Route::put('/factoraje/solicitud/{id}/liquidar', [FactorajeController::class, 'liquidar']);
    Route::delete('/factoraje/solicitud/{id}', [FactorajeController::class, 'destroy']);
    Route::get('/factoraje/excel', [FactorajeController::class, 'exportExcel']);
});

require __DIR__.'/auth.php';