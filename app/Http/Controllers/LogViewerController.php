<?php
// app/Http/Controllers/LogViewerController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogViewerController extends Controller
{
    public function index()
    {
        // Verifica que el usuario sea admin
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'No autorizado');
        }

        $logFile = storage_path('logs/laravel.log');
        
        if (!File::exists($logFile)) {
            return "El archivo de log no existe. Asegúrate de que la aplicación haya generado errores.";
        }

        $logs = File::get($logFile);
        
        // Formatear para mejor visualización
        $logs = nl2br(e($logs));
        
        return view('logs.index', compact('logs'));
    }

    public function clear()
{
    File::put(storage_path('logs/laravel.log'), '');
    return redirect()->route('logs.index')->with('success', 'Logs limpiados');
}

public function download()
{
    $logFile = storage_path('logs/laravel.log');
    return response()->download($logFile, 'laravel-' . date('Y-m-d') . '.log');
}
}