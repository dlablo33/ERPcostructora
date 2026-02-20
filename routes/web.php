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


require __DIR__.'/auth.php';
