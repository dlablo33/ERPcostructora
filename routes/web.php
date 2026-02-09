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
    
    // Más rutas...
});

// Grupo para Administración
Route::prefix('admin')->group(function () {
    Route::get('/facturacion', function () {
        return view('admin.facturacion.index');
    })->name('admin.facturacion');
    
    // Más rutas...
});




require __DIR__.'/auth.php';
