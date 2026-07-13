<?php
// app/Models/ModuleConfig.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleConfig extends Model
{
    use HasFactory;

    protected $table = 'module_configs';

    protected $fillable = [
        'name',
        'display_name',
        'icon',
        'section',
        'route',
        'is_enabled',
        'order'
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Obtener módulos ordenados por el campo 'order'
     */
    public static function ordered()
    {
        return self::orderBy('order', 'asc')->get();
    }

    /**
     * Obtener módulos activos de una sección específica
     */
    public static function getActiveBySection($section)
    {
        return self::where('section', $section)
            ->where('is_enabled', true)
            ->orderBy('order', 'asc')
            ->get();
    }

    /**
     * Verificar si un módulo específico está activo
     */
    public static function isModuleActive($moduleName)
    {
        return self::where('name', $moduleName)
            ->where('is_enabled', true)
            ->exists();
    }

    /**
     * Obtener todos los módulos de una sección
     */
    public static function getBySection($section)
    {
        return self::where('section', $section)
            ->orderBy('order', 'asc')
            ->get();
    }

    /**
     * Scope para filtrar módulos activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_enabled', true);
    }

    /**
     * Scope para filtrar módulos inactivos
     */
    public function scopeInactive($query)
    {
        return $query->where('is_enabled', false);
    }
}