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
        'tiempo_uso_promedio' => 'decimal:2'
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
}