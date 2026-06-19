<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivoHerramienta extends Model
{
    use HasFactory;
    
    protected $table = 'activos_herramientas';
    
    protected $fillable = [
        'activo_id',
        'tipo_herramienta',
        'voltaje',
        'potencia',
        'requiere_calibracion',
        'fecha_ultima_calibracion',
        'fecha_proxima_calibracion',
        'numero_inventario',
        'prestamos_realizados',
        'tiempo_uso_promedio'
    ];
    
    protected $casts = [
        'requiere_calibracion' => 'boolean',
        'fecha_ultima_calibracion' => 'date',
        'fecha_proxima_calibracion' => 'date',
        'potencia' => 'decimal:2',
        'tiempo_uso_promedio' => 'decimal:2',
        'prestamos_realizados' => 'integer',
        'voltaje' => 'integer'
    ];

    protected $appends = [
        'dias_restantes_calibracion',
        'requiere_calibracion_pronto'
    ];
    
    public function activo()
    {
        return $this->belongsTo(Activo::class);
    }
    
    public function getRequiereCalibracionUrgenteAttribute()
    {
        if (!$this->requiere_calibracion || !$this->fecha_proxima_calibracion) {
            return false;
        }
        return $this->fecha_proxima_calibracion <= now()->addDays(30);
    }

    public function getDiasRestantesCalibracionAttribute(): ?int
    {
        if (!$this->fecha_proxima_calibracion) {
            return null;
        }
        $dias = now()->diffInDays($this->fecha_proxima_calibracion, false);
        return max(0, $dias);
    }

    public function getRequiereCalibracionProntoAttribute(): bool
    {
        $dias = $this->dias_restantes_calibracion;
        return $dias !== null && $dias <= 15;
    }

    public function scopePorCalibrar($query)
    {
        return $query->where('requiere_calibracion', true)
            ->whereDate('fecha_proxima_calibracion', '<=', now()->addDays(15));
    }

    public function registrarCalibracion(): bool
    {
        $this->fecha_ultima_calibracion = now();
        $this->fecha_proxima_calibracion = now()->addYear();
        return $this->save();
    }

    public function incrementarPrestamos(): bool
    {
        $this->prestamos_realizados = ($this->prestamos_realizados ?? 0) + 1;
        return $this->save();
    }
}