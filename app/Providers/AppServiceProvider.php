<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Asistencia;
use App\Observers\AsistenciaObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrar el observer para Asistencia
        Asistencia::observe(AsistenciaObserver::class);
    }
}