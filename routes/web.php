<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

    });

require __DIR__.'/auth.php';
