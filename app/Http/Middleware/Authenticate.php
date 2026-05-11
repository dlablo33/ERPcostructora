<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $this->authenticate($request, $guards);
        } catch (AuthenticationException $e) {
            return $this->handleUnauthenticated($request, $guards);
        } catch (\Exception $e) {
            if ($this->isTokenRelatedException($e)) {
                return $this->handleUnauthenticated($request, $guards);
            }
            throw $e;
        }
        
        return $next($request);
    }

    /**
     * Handle unauthenticated requests.
     */
    protected function handleUnauthenticated($request, array $guards)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'No autenticado. Token expirado o inválido.',
                'redirect' => route('login')
            ], 401);
        }

        return redirect()->route('login')->with(
            'error', 'Tu sesión ha expirado. Por favor inicia sesión nuevamente.'
        );
    }

    /**
     * Check if exception is token related.
     */
    protected function isTokenRelatedException(\Exception $e): bool
    {
        $errorMessage = $e->getMessage();
        
        $tokenKeywords = [
            'token', 'Token', 'JWT', 'jwt', 
            'expired', 'expirado', 'null', 
            'sanctum', 'passport', 'unauthorized'
        ];
        
        foreach ($tokenKeywords as $keyword) {
            if (str_contains($errorMessage, $keyword)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Override the unauthenticated method from parent (correct signature).
     */
    protected function unauthenticated($request, array $guards)
    {
        return $this->handleUnauthenticated($request, $guards);
    }
}