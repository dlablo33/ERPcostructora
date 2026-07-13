<?php
// app/Providers/ModuleServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ModuleConfig;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Compartir datos con todas las vistas
        view()->composer('*', function ($view) {
            $view->with('moduleHelper', new class {
                public function isEnabled($moduleName)
                {
                    return \App\Models\ModuleConfig::where('name', $moduleName)
                        ->where('is_enabled', true)
                        ->exists();
                }

                public function hasActive($section)
                {
                    return \App\Models\ModuleConfig::where('section', $section)
                        ->where('is_enabled', true)
                        ->exists();
                }

                public function getActive($section = null)
                {
                    $query = \App\Models\ModuleConfig::where('is_enabled', true);
                    if ($section) {
                        $query->where('section', $section);
                    }
                    return $query->orderBy('order', 'asc')->get();
                }
            });
        });
    }
}