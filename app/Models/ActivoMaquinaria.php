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
        'horometro_actual' => 'decimal:2',
        'horometro_compra' => 'decimal:2',
        'horometro_ultimo_mantenimiento' => 'decimal:2',
        'horometro_proximo_mantenimiento' => 'decimal:2',
        'consumo_promedio' => 'decimal:2',
        'capacidad_tanque' => 'decimal:2',
        'peso_operativo' => 'decimal:2',
        'capacidad_carga' => 'decimal:2',
        'mantenimiento_preventivo_dias' => 'integer',
        'ultimo_servicio_fecha' => 'date',
        'proximo_servicio_fecha' => 'date'
    ];

    protected $appends = [
        'horas_restantes_mantenimiento',
        'requiere_mantenimiento',
        'horas_usadas_desde_compra',
        'dias_restantes_servicio',
        'capacidad_formateada'
    ];
    
    public function activo()
    {
        return $this->belongsTo(Activo::class);
    }
    
    public function operadorActual()
    {
        return $this->belongsTo(Plantilla::class, 'operador_actual_id', 'plantilla_id');
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

    public function getDiasRestantesServicioAttribute(): ?int
    {
        if (!$this->proximo_servicio_fecha) {
            return null;
        }
        $dias = now()->diffInDays($this->proximo_servicio_fecha, false);
        return max(0, $dias);
    }

    public function getCapacidadFormateadaAttribute(): string
    {
        if (!$this->capacidad_carga) {
            return '-';
        }
        return $this->capacidad_carga . ' ' . ($this->unidad_capacidad ?? '');
    }

    public function getRequiereServicioAttribute(): bool
    {
        $dias = $this->dias_restantes_servicio;
        return $dias !== null && $dias <= 7;
    }

    public function scopePorMantenimiento($query)
    {
        return $query->where(function($q) {
            $q->whereRaw('horometro_proximo_mantenimiento - horometro_actual <= 50')
              ->orWhereRaw('horometro_proximo_mantenimiento - horometro_actual IS NULL');
        });
    }

    public function scopePorServicio($query)
    {
        return $query->where(function($q) {
            $q->whereDate('proximo_servicio_fecha', '<=', now()->addDays(7))
              ->orWhereNull('proximo_servicio_fecha');
        });
    }

    public function actualizarHorometro(float $horas): bool
    {
        $this->horometro_actual = $horas;
        
        if ($this->horometro_proximo_mantenimiento && $horas >= $this->horometro_proximo_mantenimiento) {
            $this->activo->update(['estatus' => 'mantenimiento']);
        }
        
        return $this->save();
    }

    public function registrarMantenimiento(float $horasActuales): bool
    {
        $this->horometro_ultimo_mantenimiento = $horasActuales;
        $this->horometro_proximo_mantenimiento = $horasActuales + ($this->mantenimiento_preventivo_dias * 8);
        $this->ultimo_servicio_fecha = now();
        $this->proximo_servicio_fecha = now()->addDays($this->mantenimiento_preventivo_dias ?? 30);
        
        return $this->save();
    }
}