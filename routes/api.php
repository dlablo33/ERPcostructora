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

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Ruta de prueba para verificar que la API funciona (sin autenticación)
Route::get('/health', function() {
    return response()->json(['status' => 'ok', 'message' => 'API funcionando correctamente']);
});

// Ruta para obtener el usuario autenticado
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas de chat
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/chat/users', [ChatController::class, 'getUsers']);
    Route::get('/chat/messages/{userId}', [ChatController::class, 'getMessages']);
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
    Route::post('/chat/mark-read/{userId}', [ChatController::class, 'markAsRead']);
});

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

// ==================== RUTAS PARA CATÁLOGOS (SIN AUTENTICACIÓN PARA PRUEBAS) ====================
// MONEDAS API
Route::get('/monedas', [MonedaController::class, 'index']);
Route::post('/monedas', [MonedaController::class, 'store']);
Route::get('/monedas/{id}', [MonedaController::class, 'show']);
Route::put('/monedas/{id}', [MonedaController::class, 'update']);
Route::delete('/monedas/{id}', [MonedaController::class, 'destroy']);
Route::get('/monedas-activas', [MonedaController::class, 'getActivas']);

// TIPOS DE CAMBIO API
Route::get('/tipos-cambio', [TipoCambioController::class, 'index']);
Route::post('/tipos-cambio', [TipoCambioController::class, 'store']);
Route::get('/tipos-cambio/{id}', [TipoCambioController::class, 'show']);
Route::put('/tipos-cambio/{id}', [TipoCambioController::class, 'update']);
Route::delete('/tipos-cambio/{id}', [TipoCambioController::class, 'destroy']);
Route::get('/tipos-cambio/origen/{origenId}/destino/{destinoId}/fecha/{fecha?}', [TipoCambioController::class, 'getTipoCambio']);

// BANCOS API
Route::get('/bancos', [BancoController::class, 'index']);
Route::post('/bancos', [BancoController::class, 'store']);
Route::get('/bancos/{id}', [BancoController::class, 'show']);
Route::put('/bancos/{id}', [BancoController::class, 'update']);
Route::delete('/bancos/{id}', [BancoController::class, 'destroy']);
Route::get('/bancos-activos', [BancoController::class, 'getActivos']);

// CUENTAS BANCARIAS API
Route::get('/cuentas-bancarias', [CuentaBancariaController::class, 'index']);
Route::post('/cuentas-bancarias', [CuentaBancariaController::class, 'store']);
Route::get('/cuentas-bancarias/{id}', [CuentaBancariaController::class, 'show']);
Route::put('/cuentas-bancarias/{id}', [CuentaBancariaController::class, 'update']);
Route::delete('/cuentas-bancarias/{id}', [CuentaBancariaController::class, 'destroy']);

// MÉTODOS DE PAGO API
Route::get('/metodos-pago', [MetodoPagoController::class, 'index']);
Route::post('/metodos-pago', [MetodoPagoController::class, 'store']);
Route::get('/metodos-pago/{id}', [MetodoPagoController::class, 'show']);
Route::put('/metodos-pago/{id}', [MetodoPagoController::class, 'update']);
Route::delete('/metodos-pago/{id}', [MetodoPagoController::class, 'destroy']);
Route::get('/metodos-pago-activos', [MetodoPagoController::class, 'getActivos']);

// TIPOS DE INGRESO API
Route::get('/tipos-ingreso', [TipoIngresoController::class, 'index']);
Route::post('/tipos-ingreso', [TipoIngresoController::class, 'store']);
Route::get('/tipos-ingreso/{id}', [TipoIngresoController::class, 'show']);
Route::put('/tipos-ingreso/{id}', [TipoIngresoController::class, 'update']);
Route::delete('/tipos-ingreso/{id}', [TipoIngresoController::class, 'destroy']);
Route::get('/tipos-ingreso-activos', [TipoIngresoController::class, 'getActivos']);

// TIPOS DE EGRESO API
Route::get('/tipos-egreso', [TipoEgresoController::class, 'index']);
Route::post('/tipos-egreso', [TipoEgresoController::class, 'store']);
Route::get('/tipos-egreso/{id}', [TipoEgresoController::class, 'show']);
Route::put('/tipos-egreso/{id}', [TipoEgresoController::class, 'update']);
Route::delete('/tipos-egreso/{id}', [TipoEgresoController::class, 'destroy']);
Route::get('/tipos-egreso-activos', [TipoEgresoController::class, 'getActivos']);

// CATEGORÍAS DE GASTO API
Route::get('/categorias-gasto', [CategoriaGastoController::class, 'index']);
Route::post('/categorias-gasto', [CategoriaGastoController::class, 'store']);
Route::get('/categorias-gasto/{id}', [CategoriaGastoController::class, 'show']);
Route::put('/categorias-gasto/{id}', [CategoriaGastoController::class, 'update']);
Route::delete('/categorias-gasto/{id}', [CategoriaGastoController::class, 'destroy']);
Route::get('/categorias-gasto/por-tipo-egreso/{tipoEgresoId}', [CategoriaGastoController::class, 'getPorTipoEgreso']);

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