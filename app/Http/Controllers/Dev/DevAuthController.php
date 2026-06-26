<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\DesarrolladorAcceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DevAuthController extends Controller
{
    /**
     * Muestra el formulario de login para desarrolladores
     */
    public function showLoginForm()
    {
        return view('dev.login');
    }

    /**
     * Procesa el login de desarrolladores
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        // Buscar desarrollador por email
        $dev = DesarrolladorAcceso::where('email', $request->email)
            ->where('activo', true)
            ->first();

        if (!$dev || !Hash::check($request->password, $dev->password)) {
            return back()->with('error', 'Credenciales incorrectas o usuario inactivo');
        }

        // Guardar en sesión
        session([
            'dev_user_id' => $dev->id,
            'dev_nombre' => $dev->nombre,
            'dev_email' => $dev->email
        ]);

        // Actualizar último acceso
        $dev->update(['ultimo_acceso' => now()]);

        return redirect()->route('dev.dashboard');
    }

    /**
     * Cierra la sesión del desarrollador
     */
    public function logout()
    {
        session()->forget(['dev_user_id', 'dev_nombre', 'dev_email']);
        return redirect()->route('dev.login')->with('success', 'Sesión cerrada correctamente');
    }
}