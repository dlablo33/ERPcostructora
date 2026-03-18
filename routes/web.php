<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RH\RolController;
use App\Http\Controllers\RH\PuestoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/tareas', function () {
    return view('tareas.index');
})->name('tareas.index')->middleware('auth');

// Grupo para BI
Route::prefix('bi')->group(function () {

    Route::get('/dashboard', function () {
        return view('bi.dashboard.dashboard');
    })->name('bi.dashboard');
    
    Route::get('/licitaciones', function () {
        return view('bi.dashboard.licitaciones');
    })->name('bi.licitaciones');

    Route::get('/finanzas', function () {
        return view('bi.dashboard.finanzas');
    })->name('bi.finanzas');
    
    Route::get('/papeline', function () {
        return view('bi.ventas.papeline');
    })->name('ventas.papeline');

    Route::get('/propuestas', function () {
        return view('bi.ventas.propuestas');
    })->name('ventas.propuestas');

    Route::get('/analisis', function () {
        return view('bi.ventas.analisis');
    })->name('ventas.analisis');

    Route::get('/seguimientofacturacion', function () {
        return view('bi.facturacion.seguimiento');
    })->name('facturacion.seguimiento');

    Route::get('/pendientefacturacion', function () {
        return view('bi.facturacion.pendiente');
    })->name('facturacion.pendiente');

    Route::get('/facturacion', function () {
        return view('bi.facturacion.facturacion');
    })->name('facturacion.facturacion');

    Route::get('/historial', function () {
        return view('bi.cobranza.historial');
    })->name('cobranza.historial');

       Route::get('/proyecciones', function () {
        return view('bi.cobranza.proyecciones');
    })->name('cobranza.proyecciones');



});

// Grupo para Administración
Route::prefix('admin')->group(function () {

    Route::get('/facturacion', function () {
        return view('admin.facturacion.index');
    })->name('admin.facturacion');
    
    Route::get('/cuentasporcobrar', function () {
        return view('administracion.cuentascobrar.saldos');
    })->name('admin.saldos');

    Route::get('/cuentasporpagar', function () {
        return view('administracion.cuentaspago.pagos');
    })->name('admin.pagos');

    Route::get('/cfdi', function () {
        return view('administracion.facturacion.cfdi');
    })->name('admin.cfdi');

    Route::get('/notadecredito', function () {
        return view('administracion.facturacion.nota');
    })->name('admin.nota');

    Route::get('/facturacion', function () {
        return view('administracion.facturacion.facturacion');
    })->name('admin.facturacion');

    Route::get('/bitacora', function () {
        return view('administracion.facturacion.bitacora');
    })->name('admin.bitacora');

    Route::get('/comiciones', function () {
        return view('administracion.facturacion.comiciones');
    })->name('admin.comiciones');

    Route::get('/contrarecibo', function () {
        return view('administracion.facturacion.contrarecibo');
    })->name('admin.contrarecibo');

    Route::get('/factoraje', function () {
        return view('administracion.facturacion.factoraje');
    })->name('admin.factoraje');

    Route::get('/notadeventas', function () {
        return view('administracion.facturacion.ventas');
    })->name('admin.ventas');

    Route::get('/notadeventas', function () {
        return view('administracion.facturacion.ventas');
    })->name('admin.ventas');

    Route::get('/conciliacion', function () {
        return view('administracion.tesoreria.conciliacion');
    })->name('tesoreria.conciliacion');

    Route::get('/depositos', function () {
        return view('administracion.tesoreria.depositos');
    })->name('tesoreria.depositos');

    Route::get('/estadosdecuenta', function () {
        return view('administracion.tesoreria.estadosdecuenta');
    })->name('tesoreria.estadosdecuenta');

    Route::get('/flujomensual', function () {
        return view('administracion.tesoreria.flujomensual');
    })->name('tesoreria.flujomensual');

    Route::get('/flujos', function () {
        return view('administracion.tesoreria.flujos');
    })->name('tesoreria.flujos');

    Route::get('/programacion', function () {
        return view('administracion.tesoreria.programacion');
    })->name('tesoreria.programacion');

    Route::get('/traspasos', function () {
        return view('administracion.tesoreria.transacciones');
    })->name('tesoreria.transacciones');

    Route::get('/trasferencia', function () {
        return view('administracion.tesoreria.trasferencias');
    })->name('tesoreria.trasferencia');

    Route::get('/pagos', function () {
        return view('administracion.tesoreria.pagos');
    })->name('tesoreria.pagos');

    Route::get('/facturacionproveedores', function () {
        return view('administracion.presupuestos.facturacion');
    })->name('presupuestos.facturacion');

    Route::get('/gastosfijos', function () {
        return view('administracion.presupuestos.gastos');
    })->name('presupuestos.gastos');

    Route::get('/presupuestomensual', function () {
        return view('administracion.presupuestos.mensual');
    })->name('presupuestos.mensual');

    Route::get('/reasignacion', function () {
        return view('administracion.presupuestos.reasignacion');
    })->name('presupuestos.reasignacion');

    Route::get('/anticipo', function () {
        return view('administracion.operaciones.anticipo');
    })->name('operaciones.anticipo');

    Route::get('/credito', function () {
        return view('administracion.operaciones.credito');
    })->name('operaciones.credito');

    Route::get('/prepago', function () {
        return view('administracion.operaciones.prepago');
    })->name('operaciones.prepago');

    Route::get('/cuentasavanzadas', function () {
        return view('administracion.cuentasavanzadas.cuentasavanzadas');
    })->name('cuentasavanzadas.cuentasavanzadas');

});

Route::prefix('config')->group(function () {

    Route::get('/config', function () {
        return view('config.index');
    })->name('config.index');

    Route::get('/personalizacion', function () {
        return view('config.topmenu.menuconfi');
    })->name('config.menuconfig');

});


Route::prefix('conta')->group(function () {

    Route::get('/analisis', function () {
        return view('conta.analisis.analisis');
    })->name('conta.analisis');

    Route::get('/comparativos', function () {
        return view('conta.analisis.comparativos');
    })->name('conta.comparativos');

    Route::get('/razones', function () {
        return view('conta.analisis.razones');
    })->name('conta.razones');

    Route::get('/reportes', function () {
        return view('conta.analisis.reportes');
    })->name('conta.reportes');

    Route::get('/auxiliar', function () {
        return view('conta.catalogo.auxiliar');
    })->name('conta.auxiliar');

    Route::get('/centros', function () {
        return view('conta.catalogo.centros');
    })->name('conta.centros');

    Route::get('/configuracion', function () {
        return view('conta.catalogo.configuracion');
    })->name('conta.configuraciones');

    Route::get('/cuentas', function () {
        return view('conta.catalogo.cuentas');
    })->name('conta.cuentas');

    Route::get('/amortizacion', function () {
        return view('conta.cierre.amortizacion');
    })->name('conta.amortizacion');

    Route::get('/anual', function () {
        return view('conta.cierre.anual');
    })->name('conta.anual');

    Route::get('/depreciaciones', function () {
        return view('conta.cierre.depreciaciones');
    })->name('conta.depreciaciones');

    Route::get('/mensual', function () {
        return view('conta.cierre.mensual');
    })->name('conta.mensual');

    Route::get('/depreciaciones', function () {
        return view('conta.cierre.depreciaciones');
    })->name('conta.depreciaciones');

    Route::get('/estados', function () {
        return view('conta.estados.estados');
    })->name('conta.estados');

    Route::get('/balance', function () {
        return view('conta.estados.balance');
    })->name('conta.balance');

    Route::get('/capital', function () {
        return view('conta.estados.capital');
    })->name('conta.capital');

    Route::get('/comprobacion', function () {
        return view('conta.estados.comprobacion');
    })->name('conta.comprobacion');

    Route::get('/flujo', function () {
        return view('conta.estados.flujo');
    })->name('conta.flujo');

    Route::get('/complementos', function () {
        return view('conta.fiscal.complementos');
    })->name('conta.complementos');

    Route::get('/contabilidad', function () {
        return view('conta.fiscal.contabilidad');
    })->name('conta.contabilidad');

    Route::get('/declarciones', function () {
        return view('conta.fiscal.declaraciones');
    })->name('conta.declaracinoes');

    Route::get('/diot', function () {
        return view('conta.fiscal.diot');
    })->name('conta.diot');

    Route::get('/retenciones', function () {
        return view('conta.fiscal.retenciones');
    })->name('conta.retenciones');

    Route::get('/asignaciones', function () {
        return view('conta.porproyecto.asignacion');
    })->name('conta.asignacion');

    Route::get('/cierre', function () {
        return view('conta.porproyecto.cierre');
    })->name('conta.cierre');

    Route::get('/costo', function () {
        return view('conta.porproyecto.costo');
    })->name('conta.costo');

    Route::get('/gastos', function () {
        return view('conta.porproyecto.gastos');
    })->name('conta.gastos');

    Route::get('/rentabilidad', function () {
        return view('conta.porproyecto.rentabilidad');
    })->name('conta.rentabilidad');

    Route::get('/ajustes', function () {
        return view('conta.registros.ajustes');
    })->name('conta.ajustes');

    Route::get('/auxliar', function () {
        return view('conta.registros.auxiliar');
    })->name('conta.regaux');

    Route::get('/diario', function () {
        return view('conta.registros.diario');
    })->name('conta.diario');

    Route::get('/libro', function () {
        return view('conta.registros.libro');
    })->name('conta.libro');

    Route::get('/poliza', function () {
        return view('conta.registros.polizas');
    })->name('conta.polizas');

    Route::get('/unidadenegocios', function () {
        return view('conta.estados.unidad');
    })->name('conta.unidad');

    Route::get('/liquidacion', function () {
        return view('conta.estados.liquidacion');
    })->name('conta.liquidacion');

    Route::get('/general', function () {
        return view('conta.estados.general');
    })->name('conta.general');

    Route::get('/diot', function () {
        return view('conta.fiscal.diot');
    })->name('conta.diot');

    Route::get('/mensuales', function () {
        return view('conta.fiscal.declaraciones');
    })->name('conta.declaraciones');

    Route::get('/retenciones', function () {
        return view('conta.fiscal.retenciones');
    })->name('conta.retenciones');

    Route::get('/complemento', function () {
        return view('conta.fiscal.complementos');
    })->name('conta.complemento');

    Route::get('/diariogeneral', function () {
        return view('conta.registros.diario');
    })->name('conta.diario');

    Route::get('/cobranza', function () {
        return view('conta.registros.auxiliar');
    })->name('conta.cobranza');

    Route::get('/centro', function () {
        return view('conta.catalogo.centros');
    })->name('conta.centros');

    Route::get('/auxiliar', function () {
        return view('conta.catalogo.auxiliar');
    })->name('conta.auxiliar');

    Route::get('/libro', function () {
        return view('conta.registros.libro');
    })->name('conta.libro');

    Route::get('/costoobras', function () {
        return view('conta.porproyecto.costo');
    })->name('conta.costo');

    Route::get('/asignacion', function () {
        return view('conta.porproyecto.asignacion');
    })->name('conta.asignacion');


    Route::get('/cierre', function () {
        return view('conta.porproyecto.cierre');
    })->name('conta.cierre');

    Route::get('/gastos', function () {
        return view('conta.porproyecto.gastos');
    })->name('conta.gastos');

    Route::get('/rentabilidad', function () {
        return view('conta.porproyecto.rentabilidad');
    })->name('conta.rentabilidad');

    });

Route::prefix('rh')->name('rh.')->group(function () {

    // ======================= GESTION =======================

    Route::get('/plantilla', function () {
        return view('rh.gestion.plantilla');
    })->name('plantilla');

    Route::get('/alta', function () {
        return view('rh.gestion.alta');
    })->name('alta');

    Route::get('/expediente', function () {
        return view('rh.gestion.expediente');
    })->name('expediente');

    Route::get('/historial-gestion', function () {
        return view('rh.gestion.historial');
    })->name('historial_gestion');

    Route::get('/semaforo', function () {
        return view('rh.gestion.semaforo');
    })->name('semaforo');

    // ======================= ASISTENCIA =======================

    Route::get('/asistencia', function () {
        return view('rh.asistencia.asistencia');
    })->name('asistencia');

    Route::get('/lista', function () {
        return view('rh.asistencia.lista');
    })->name('lista');

    Route::get('/incidencias', function () {
        return view('rh.asistencia.incidencias');
    })->name('incidencias');

    Route::get('/justificantes', function () {
        return view('rh.asistencia.justificantes');
    })->name('justificantes');

    Route::get('/control', function () {
        return view('rh.asistencia.control');
    })->name('control');

    // ======================= NOMINA =======================

    Route::get('/calculo', function () {
        return view('rh.nomina.calculo');
    })->name('calculo');

    Route::get('/historial-nomina', function () {
        return view('rh.nomina.historial');
    })->name('historial_nomina');

    Route::get('/pagos', function () {
        return view('rh.nomina.pagos');
    })->name('pagos');

    Route::get('/recibos', function () {
        return view('rh.nomina.recibos');
    })->name('recibos');

    Route::get('/sueldos', function () {
        return view('rh.nomina.sueldos');
    })->name('sueldos');

    // ======================= PRESTACIONES =======================

    Route::get('/aguinaldo', function () {
        return view('rh.prestaciones.aguinaldo');
    })->name('aguinaldo');

    Route::get('/descuentos', function () {
        return view('rh.prestaciones.descuentos');
    })->name('descuentos');

    Route::get('/finiquito', function () {
        return view('rh.prestaciones.finequito');
    })->name('finiquito');

    Route::get('/prestamos', function () {
        return view('rh.prestaciones.prestamos');
    })->name('prestamos');

    Route::get('/vacaciones', function () {
        return view('rh.prestaciones.vacaciones');
    })->name('vacaciones');

    // ======================= UNIDADES =======================

    Route::get('/bitacora', function () {
        return view('rh.unidades.bitacora');
    })->name('bitacora');

    Route::get('/carros', function () {
        return view('rh.unidades.carros');
    })->name('carros');

    Route::get('/flotillas', function () {
        return view('rh.unidades.flotillas');
    })->name('flotillas');

    Route::get('/semaforos-unidades', function () {
        return view('rh.unidades.semaforos');
    })->name('semaforos_unidades');

    // ======================= CATALOGOS =======================

    Route::get('/imss-catalogo', function () {
        return view('rh.catalogos.imss');
    })->name('imss_catalogo');

    Route::get('/areas', function () {
        return view('rh.catalogos.areas');
    })->name('areas');

    Route::get('/deducciones', function () {
        return view('rh.catalogos.deducciones');
    })->name('deducciones');

    Route::get('/percepciones', function () {
        return view('rh.catalogos.percepciones');
    })->name('percepciones');

    Route::get('/roles', function () {
        return view('rh.catalogos.roles');
    })->name('roles');

    Route::get('/turnos', function () {
        return view('rh.catalogos.turnos');
    })->name('turnos');

    // ======================= REPORTES ========================

    Route::get('/costos', function () {
        return view('rh.reportes.costos');
    })->name('costos');

    Route::get('/sat', function () {
        return view('rh.reportes.sat');
    })->name('sat');

    Route::get('/imss-reporte', function () {
        return view('rh.reportes.imss');
    })->name('imss_reporte');

});


Route::prefix('almacen')->name('almacen.')->group(function () {


    Route::get('/entrada', function () {
        return view('almacen.movimiento.entrada');
    })->name('entrada');

    Route::get('/requisicion', function () {
        return view('almacen.movimiento.requisiciones');
    })->name('requisicion');

    Route::get('/traspasos', function () {
        return view('almacen.movimiento.traspasos');
    })->name('traspasos');

    Route::get('/inventariofisico', function () {
        return view('almacen.existencia.inventario');
    })->name('inventario');

    Route::get('/vales', function () {
        return view('almacen.existencia.vale');
    })->name('vales');

    Route::get('/almacenes', function () {
        return view('almacen.catalogo.almacen');
    })->name('almacen');

    Route::get('/articulos', function () {
        return view('almacen.catalogo.articulos');
    })->name('articulo');

    Route::get('/familia', function () {
        return view('almacen.catalogo.familias');
    })->name('familia');
    

});

Route::prefix('compras')->name('compras.')->group(function () {

    Route::get('/requisicion', function () {
        return view('compras.requisicion.requisicion');
    })->name('requisicion');

    Route::get('/autorizacion', function () {
        return view('compras.requisicion.autorizacion');
    })->name('autorizacion');

    Route::get('/autorizaciones', function () {
        return view('compras.compras.autorizacion');
    })->name('autorizaciones'); 

    Route::get('/ordenesdecompras', function () {
        return view('compras.compras.ordenes');
    })->name('ordenes'); 

    Route::get('/proveedores', function () {
        return view('compras.subcontratistas.gestion');
    })->name('gestion'); 

    Route::get('/almacenobra', function () {
        return view('compras.almacen.almacen');
    })->name('almacen'); 


});

Route::prefix('proyectos')->name('proyectos.')->group(function () {

    Route::get('/cartera', function () {
        return view('proyectos.gestion.cartera');
    })->name('cartera'); 

    Route::get('/alta', function () {
        return view('proyectos.gestion.alta');
    })->name('alta'); 

    Route::get('/hitos', function () {
        return view('proyectos.gestion.hitos');
    })->name('hitos'); 

    Route::get('/bitacora', function () {
        return view('proyectos.gestion.bitacora');
    })->name('bitacora'); 

    // ===============  Presupuestos    ===============================

     Route::get('/presupuestos', function () {
        return view('proyectos.presupuestos.presupuestos');
    })->name('presupuestos');
    
    // =============== Personal =========================================

    Route::get('/asignacion', function () {
        return view('proyectos.personal.asignada');
    })->name('asignada');

    Route::get('/flotillas', function () {
        return view('proyectos.personal.flotillas');
    })->name('flotillas');

    // ============== Maquinaria de Equipo ==============================

    Route::get('/maquinas', function () {
        return view('proyectos.maquinaria.asignacion');
    })->name('asignacion');

    Route::get('/control', function () {
        return view('proyectos.maquinaria.control');
    })->name('control');

    Route::get('/mantenimiento', function () {
        return view('proyectos.maquinaria.mantenimiento');
    })->name('mantenimiento');

    Route::get('/bitaherramienta', function () {
        return view('proyectos.maquinaria.bitacora');
    })->name('bita');

    // ================ documentacion =====================================

    Route::get('/planos', function () {
        return view('proyectos.documentacion.planos');
    })->name('planos');

    Route::get('/permisos', function () {
        return view('proyectos.documentacion.permisos');
    })->name('permisos');

    Route::get('/evidencia', function () {
        return view('proyectos.documentacion.evidencia');
    })->name('evidencia');

    // ================= licitaciones =====================================

   Route::get('/activas', function () {
        return view('proyectos.licitacion.activas');
    })->name('activas'); 

    Route::get('/cotizaciones', function () {
        return view('proyectos.licitacion.presupuestos');
    })->name('presupuestos');

    Route::get('/analisis', function () {
        return view('proyectos.licitacion.analisis');
    })->name('analisis');

    // ================== presupuestos ======================================


    Route::get('/presupuestos', function () {
        return view('proyectos.presupuestos.presupuesto');
    })->name('presupuesto');

    Route::get('/real', function () {
        return view('proyectos.presupuestos.real');
    })->name('real');

    // =================== costos ============================================

    Route::get('/analisisrentabilidad', function () {
        return view('proyectos.costos.rentabilidad');
    })->name('rentabilidad'); 

    Route::get('/indirectos', function () {
        return view('proyectos.costos.indirectos');
    })->name('indirectos'); 

    Route::get('/directos', function () {
        return view('proyectos.costos.directos');
    })->name('directos'); 

    // ===================== avances ========================================

    Route::get('/estimaciones', function () {
        return view('proyectos.avances.estimaciones');
    })->name('estimaciones');

    Route::get('/reportes', function () {
        return view('proyectos.avances.reportes');
    })->name('reportes');
    
    // ================ control ===============================================

    Route::get('/control', function () {
        return view('proyectos.control.control');
    })->name('control');

    Route::get('/desviaciones', function () {
        return view('proyectos.control.desviaciones');
    })->name('desviaciones');

});

// Rutas web
Route::resource('roles', RolController::class);
Route::resource('puestos', PuestoController::class);

// Rutas adicionales
Route::post('roles/exportar-excel', [RolController::class, 'exportExcel'])->name('roles.export');
Route::post('puestos/exportar-excel', [PuestoController::class, 'exportExcel'])->name('puestos.export');

// Si son rutas API
// Rutas API
Route::prefix('api')->group(function () {
    // Roles
    Route::get('roles', [RolController::class, 'index']);
    Route::post('roles', [RolController::class, 'store']);
    Route::get('roles/{id}', [RolController::class, 'show'])->where('id', '[0-9]+');
    Route::put('roles/{id}', [RolController::class, 'update'])->where('id', '[0-9]+');
    Route::delete('roles/{id}', [RolController::class, 'destroy'])->where('id', '[0-9]+');
    
    // Puestos (igual)
    Route::get('puestos', [PuestoController::class, 'index']);
    Route::post('puestos', [PuestoController::class, 'store']);
    Route::get('puestos/{id}', [PuestoController::class, 'show'])->where('id', '[0-9]+');
    Route::put('puestos/{id}', [PuestoController::class, 'update'])->where('id', '[0-9]+');
    Route::delete('puestos/{id}', [PuestoController::class, 'destroy'])->where('id', '[0-9]+');
});


// Rutas web para Áreas
Route::resource('areas', App\Http\Controllers\RH\AreaController::class);

// Rutas API para Áreas
Route::prefix('api')->group(function () {
    Route::get('areas', [App\Http\Controllers\RH\AreaController::class, 'index']);
    Route::post('areas', [App\Http\Controllers\RH\AreaController::class, 'store']);
    Route::get('areas/{id}', [App\Http\Controllers\RH\AreaController::class, 'show']);
    Route::put('areas/{id}', [App\Http\Controllers\RH\AreaController::class, 'update']);
    Route::delete('areas/{id}', [App\Http\Controllers\RH\AreaController::class, 'destroy']);
    Route::post('areas/exportar-excel', [App\Http\Controllers\RH\AreaController::class, 'exportExcel']);
});

// Rutas adicionales
Route::post('areas/exportar-excel', [App\Http\Controllers\RH\AreaController::class, 'exportExcel'])->name('areas.export');

require __DIR__.'/auth.php';