<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivoMaquinaria extends Model
{
    use HasFactory;
    
    protected $table = 'activos_maquinaria';
    
    protected $fillable = [
        'activo_id',
        'horometro_actual',
        'horometro_compra',
        'horometro_ultimo_mantenimiento',
        'horometro_proximo_mantenimiento',
        'tipo_combustible',
        'consumo_promedio',
        'capacidad_tanque',
        'peso_operativo',
        'capacidad_carga',
        'unidad_capacidad',
        'dimensiones',
        'operador_actual_id',
        'licencia_requerida',
        'ultimo_servicio_fecha',
        'proximo_servicio_fecha',
        'mantenimiento_preventivo_dias'
    ];
    
    protected $casts = [
        'horometro_actual' => 'decimal:1',
        'horometro_compra' => 'decimal:1',
        'horometro_ultimo_mantenimiento' => 'decimal:1',
        'horometro_proximo_mantenimiento' => 'decimal:1',
        'consumo_promedio' => 'decimal:2',
        'capacidad_tanque' => 'decimal:2',
        'peso_operativo' => 'decimal:2',
        'capacidad_carga' => 'decimal:2',
        'ultimo_servicio_fecha' => 'date',
        'proximo_servicio_fecha' => 'date'
    ];
    
    public function activo()
    {
        return $this->belongsTo(Activo::class);
    }
    
    public function operadorActual()
    {
        return $this->belongsTo(User::class, 'operador_actual_id');
    }
    
    public function getHorasRestantesMantenimientoAttribute()
    {
        if ($this->horometro_proximo_mantenimiento) {
            return max(0, $this->horometro_proximo_mantenimiento - $this->horometro_actual);
        }
        return null;
    }
    
    public function getRequiereMantenimientoAttribute()
    {
        if ($this->horometro_proximo_mantenimiento) {
            return $this->horometro_actual >= $this->horometro_proximo_mantenimiento;
        }
        return false;
    }
    
    public function getHorasUsadasDesdeCompraAttribute()
    {
        return $this->horometro_actual - $this->horometro_compra;
    }
}