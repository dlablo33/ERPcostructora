<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
        // Roles que pueden acceder a configuración
        $allowedRoles = ['Administrador', 'admin', 'super_admin'];
        
        if (!$user || !in_array($user->rol, $allowedRoles)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }
        
        return $next($request);
    }
}