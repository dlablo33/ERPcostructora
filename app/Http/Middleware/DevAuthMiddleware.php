<?php

namespace App\Http\Middleware;

use App\Models\DesarrolladorAcceso;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DevAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el desarrollador está autenticado en sesión
        if (!session()->has('dev_user_id')) {
            Log::info('Intento de acceso sin sesión a área de desarrollo', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl()
            ]);
            
            return redirect()->route('dev.login')
                ->with('error', 'Debes iniciar sesión para acceder al área de desarrollo');
        }

        // Obtener el ID del desarrollador de la sesión
        $devId = session('dev_user_id');

        // Verificar que el desarrollador exista y esté activo
        $dev = DesarrolladorAcceso::find($devId);
        
        if (!$dev) {
            Log::warning('Desarrollador no encontrado en BD', [
                'dev_id' => $devId,
                'ip' => $request->ip()
            ]);
            
            session()->forget(['dev_user_id', 'dev_nombre', 'dev_email']);
            
            return redirect()->route('dev.login')
                ->with('error', 'Usuario no encontrado. Por favor, inicia sesión nuevamente.');
        }

        if (!$dev->activo) {
            Log::warning('Desarrollador inactivo intentó acceder', [
                'dev_id' => $devId,
                'email' => $dev->email,
                'ip' => $request->ip()
            ]);
            
            session()->forget(['dev_user_id', 'dev_nombre', 'dev_email']);
            
            return redirect()->route('dev.login')
                ->with('error', 'Tu cuenta está desactivada. Contacta con soporte.');
        }

        // Verificar si el token de acceso ha expirado (opcional)
        // Se puede agregar lógica de expiración de token si es necesario

        // Actualizar último acceso (cada 10 minutos aproximadamente)
        $lastUpdate = $dev->ultimo_acceso;
        if (!$lastUpdate || $lastUpdate->diffInMinutes(now()) >= 10) {
            $dev->update(['ultimo_acceso' => now()]);
        }

        // Compartir datos del desarrollador con todas las vistas del área dev
        view()->share('dev_user', [
            'id' => $dev->id,
            'nombre' => $dev->nombre,
            'email' => $dev->email
        ]);

        return $next($request);
    }
}