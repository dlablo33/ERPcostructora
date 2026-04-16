<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NominaController;

use App\Http\Controllers\MonedaController;
use App\Http\Controllers\TipoCambioController;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\TipoIngresoController;
use App\Http\Controllers\TipoEgresoController;
use App\Http\Controllers\CategoriaGastoController;
use App\Http\Controllers\CuentaBancariaController;
use App\Http\Controllers\MovimientoBancarioController;
use App\Http\Controllers\CuentaContableController;
use App\Http\Controllers\ChequeTransferenciaController;
use App\Http\Controllers\PresupuestoProyectoController;
use App\Models\Proyecto;
use App\Models\ProyectoPartida;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ==================== RUTAS SIN AUTENTICACIÓN (PARA PRUEBAS) ====================

// ==========================================
// RUTAS PARA PRESUPUESTO DE PROYECTOS (SIN AUTENTICACIÓN)
// ==========================================

// Obtener lista de proyectos
Route::get('/proyectos', function() {
    $proyectos = Proyecto::where('status', 'activo')
        ->orderBy('codigo')
        ->get(['id', 'codigo', 'nombre', 'cliente_nombre', 'fecha_inicio', 'fecha_fin', 'ubicacion']);
    return response()->json(['success' => true, 'data' => $proyectos]);
});

// Obtener presupuesto de un proyecto
Route::get('/proyectos/{proyecto}/presupuesto', [PresupuestoProyectoController::class, 'getPresupuesto']);

// Obtener partidas de un proyecto
Route::get('/proyectos/{proyecto}/partidas', [PresupuestoProyectoController::class, 'getPartidas']);

// Obtener una partida específica
Route::get('/proyectos/{proyecto}/partidas/{partida}', [PresupuestoProyectoController::class, 'getPartida']);

// Crear una partida
Route::post('/proyectos/{proyecto}/partidas', [PresupuestoProyectoController::class, 'storePartida']);

// Actualizar una partida
Route::put('/proyectos/{proyecto}/partidas/{partida}', [PresupuestoProyectoController::class, 'updatePartida']);

// Eliminar una partida
Route::delete('/proyectos/{proyecto}/partidas/{partida}', [PresupuestoProyectoController::class, 'destroyPartida']);

// Obtener resumen por secciones
Route::get('/proyectos/{proyecto}/resumen-seccion', [PresupuestoProyectoController::class, 'getResumenPorSeccion']);

// Exportar a Excel
Route::get('/proyectos/{proyecto}/exportar-excel', [PresupuestoProyectoController::class, 'exportarExcel']);

// ==========================================
// RUTAS EXISTENTES SIN AUTENTICACIÓN
// ==========================================

// CUENTAS CONTABLES API - SIN AUTENTICACIÓN
Route::get('/cuentas-contables', [CuentaContableController::class, 'getData']);
Route::post('/cuentas-contables', [CuentaContableController::class, 'store']);
Route::get('/cuentas-contables/{id}', [CuentaContableController::class, 'show']);
Route::put('/cuentas-contables/{id}', [CuentaContableController::class, 'update']);
Route::delete('/cuentas-contables/{id}', [CuentaContableController::class, 'destroy']);
Route::get('/cuentas-contables-padre', [CuentaContableController::class, 'getCuentasPadre']);

// CUENTAS BANCARIAS API - SIN AUTENTICACIÓN
Route::get('/cuentas-bancarias', [CuentaBancariaController::class, 'getData']);
Route::post('/cuentas-bancarias', [CuentaBancariaController::class, 'store']);
Route::get('/cuentas-bancarias/{id}', [CuentaBancariaController::class, 'show']);
Route::put('/cuentas-bancarias/{id}', [CuentaBancariaController::class, 'update']);
Route::delete('/cuentas-bancarias/{id}', [CuentaBancariaController::class, 'destroy']);

// Movimientos Bancarios para Estados de Cuenta
Route::get('/movimientos-bancarios', [MovimientoBancarioController::class, 'getDataForEstadosCuenta']);

// Ruta de prueba
Route::get('/health', function() {
    return response()->json(['status' => 'ok', 'message' => 'API funcionando correctamente']);
});

// MONEDAS API - SIN AUTENTICACIÓN
Route::get('/monedas', [MonedaController::class, 'index']);
Route::post('/monedas', [MonedaController::class, 'store']);
Route::get('/monedas/{id}', [MonedaController::class, 'show']);
Route::put('/monedas/{id}', [MonedaController::class, 'update']);
Route::delete('/monedas/{id}', [MonedaController::class, 'destroy']);
Route::get('/monedas-activas', [MonedaController::class, 'getActivas']);

// BANCOS API - SIN AUTENTICACIÓN
Route::get('/bancos', [BancoController::class, 'index']);
Route::post('/bancos', [BancoController::class, 'store']);
Route::get('/bancos/{id}', [BancoController::class, 'show']);
Route::put('/bancos/{id}', [BancoController::class, 'update']);
Route::delete('/bancos/{id}', [BancoController::class, 'destroy']);
Route::get('/bancos-activos', [BancoController::class, 'getActivos']);

// TIPOS DE INGRESO API - SIN AUTENTICACIÓN
Route::get('/tipos-ingreso', [TipoIngresoController::class, 'index']);
Route::post('/tipos-ingreso', [TipoIngresoController::class, 'store']);
Route::get('/tipos-ingreso/{id}', [TipoIngresoController::class, 'show']);
Route::put('/tipos-ingreso/{id}', [TipoIngresoController::class, 'update']);
Route::delete('/tipos-ingreso/{id}', [TipoIngresoController::class, 'destroy']);
Route::get('/tipos-ingreso-activos', [TipoIngresoController::class, 'getActivos']);

// TIPOS DE EGRESO API - SIN AUTENTICACIÓN
Route::get('/tipos-egreso', [TipoEgresoController::class, 'index']);
Route::post('/tipos-egreso', [TipoEgresoController::class, 'store']);
Route::get('/tipos-egreso/{id}', [TipoEgresoController::class, 'show']);
Route::put('/tipos-egreso/{id}', [TipoEgresoController::class, 'update']);
Route::delete('/tipos-egreso/{id}', [TipoEgresoController::class, 'destroy']);
Route::get('/tipos-egreso-activos', [TipoEgresoController::class, 'getActivos']);

// MÉTODOS DE PAGO API - SIN AUTENTICACIÓN
Route::get('/metodos-pago', [MetodoPagoController::class, 'index']);
Route::post('/metodos-pago', [MetodoPagoController::class, 'store']);
Route::get('/metodos-pago/{id}', [MetodoPagoController::class, 'show']);
Route::put('/metodos-pago/{id}', [MetodoPagoController::class, 'update']);
Route::delete('/metodos-pago/{id}', [MetodoPagoController::class, 'destroy']);
Route::get('/metodos-pago-activos', [MetodoPagoController::class, 'getActivos']);

// TIPOS DE CAMBIO API - SIN AUTENTICACIÓN
Route::get('/tipos-cambio', [TipoCambioController::class, 'index']);
Route::post('/tipos-cambio', [TipoCambioController::class, 'store']);
Route::get('/tipos-cambio/{id}', [TipoCambioController::class, 'show']);
Route::put('/tipos-cambio/{id}', [TipoCambioController::class, 'update']);
Route::delete('/tipos-cambio/{id}', [TipoCambioController::class, 'destroy']);

// CATEGORÍAS DE GASTO API - SIN AUTENTICACIÓN
Route::get('/categorias-gasto', [CategoriaGastoController::class, 'index']);
Route::post('/categorias-gasto', [CategoriaGastoController::class, 'store']);
Route::get('/categorias-gasto/{id}', [CategoriaGastoController::class, 'show']);
Route::put('/categorias-gasto/{id}', [CategoriaGastoController::class, 'update']);
Route::delete('/categorias-gasto/{id}', [CategoriaGastoController::class, 'destroy']);

// ==================== RUTAS CON AUTENTICACIÓN ====================
Route::middleware('auth:sanctum')->group(function () {
    
    // Ruta para obtener el usuario autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Rutas de chat
    Route::get('/chat/users', [ChatController::class, 'getUsers']);
    Route::get('/chat/messages/{userId}', [ChatController::class, 'getMessages']);
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
    Route::post('/chat/mark-read/{userId}', [ChatController::class, 'markAsRead']);
    
    // Rutas API para Nómina
    Route::prefix('nomina')->name('api.nomina.')->group(function () {
        Route::get('/', [NominaController::class, 'index'])->name('index');
        Route::post('/calcular', [NominaController::class, 'calcular'])->name('calcular');
        Route::get('/{id}', [NominaController::class, 'show'])->name('show');
        Route::put('/{id}/estatus', [NominaController::class, 'actualizarEstatus'])->name('actualizar-estatus');
        Route::delete('/{id}', [NominaController::class, 'cancelar'])->name('cancelar');
        Route::get('/{id}/print', [NominaController::class, 'imprimirRecibo'])->name('print');
        Route::get('/{id}/pdf', [NominaController::class, 'generarPDF'])->name('pdf');
        Route::get('/resumen', [NominaController::class, 'resumen'])->name('resumen');
        Route::post('/exportar', [NominaController::class, 'exportar'])->name('exportar');
    });
    
    // MOVIMIENTOS BANCARIOS API
    Route::get('/movimientos', [MovimientoBancarioController::class, 'index']);
    Route::post('/movimientos', [MovimientoBancarioController::class, 'store']);
    Route::get('/movimientos/{id}', [MovimientoBancarioController::class, 'show']);
    Route::put('/movimientos/{id}', [MovimientoBancarioController::class, 'update']);
    Route::delete('/movimientos/{id}', [MovimientoBancarioController::class, 'destroy']);
    Route::post('/movimientos/{id}/aplicar', [MovimientoBancarioController::class, 'aplicar']);
    Route::post('/movimientos/{id}/cancelar', [MovimientoBancarioController::class, 'cancelar']);
    Route::get('/categorias-por-tipo-egreso/{tipoEgresoId}', [MovimientoBancarioController::class, 'getCategoriasPorTipoEgreso']);
    Route::get('/saldo-cuenta/{cuentaId}', [MovimientoBancarioController::class, 'getSaldoCuenta']);
    
    // CUENTAS BANCARIAS API - Actualizar saldos
    Route::post('/cuentas-bancarias/{id}/actualizar-saldo', [CuentaBancariaController::class, 'actualizarSaldo']);
    Route::post('/cuentas-bancarias/actualizar-todos-saldos', [CuentaBancariaController::class, 'actualizarTodosSaldos']);

    // ==================== CHEQUES Y TRANSFERENCIAS ====================
    // API interna
    Route::get('/api/cheques-transferencias', [ChequeTransferenciaController::class, 'getData']);
    Route::post('/api/cheques-transferencias', [ChequeTransferenciaController::class, 'store']);
    Route::get('/api/cheques-transferencias/{id}', [ChequeTransferenciaController::class, 'show']);
    Route::put('/api/cheques-transferencias/{id}', [ChequeTransferenciaController::class, 'update']);
    Route::delete('/api/cheques-transferencias/{id}', [ChequeTransferenciaController::class, 'destroy']);
    Route::post('/api/cheques-transferencias/{id}/aplicar', [ChequeTransferenciaController::class, 'aplicar']);
    
    // Vista
    Route::get('/cheques-transferencias', [ChequeTransferenciaController::class, 'index'])->name('cheques.transferencias');
});