<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivoVehiculo extends Model
{
    use HasFactory;
    
    protected $table = 'activos_vehiculos';
    
    protected $fillable = [
        'activo_id',
        'placas',
        'numero_economico',
        'vin',
        'kilometraje_actual',
        'kilometraje_compra',
        'kilometraje_ultimo_mantenimiento',
        'kilometraje_proximo_mantenimiento',
        'tipo_combustible',
        'consumo_promedio',
        'capacidad_tanque',
        'capacidad_pasajeros',
        'capacidad_carga',
        'tipo_vehiculo',
        'traccion',
        'transmision',
        'poliza_seguro',
        'vencimiento_seguro',
        'poliza_verificacion',
        'vencimiento_verificacion',
        'ultimo_servicio_fecha',
        'proximo_servicio_fecha',
        'licencia_requerida'
    ];
    
    protected $casts = [
        'kilometraje_actual' => 'decimal:2',
        'kilometraje_compra' => 'decimal:2',
        'kilometraje_ultimo_mantenimiento' => 'decimal:2',
        'kilometraje_proximo_mantenimiento' => 'decimal:2',
        'consumo_promedio' => 'decimal:2',
        'capacidad_tanque' => 'decimal:2',
        'capacidad_carga' => 'decimal:2',
        'capacidad_pasajeros' => 'integer',
        'vencimiento_seguro' => 'date',
        'vencimiento_verificacion' => 'date',
        'ultimo_servicio_fecha' => 'date',
        'proximo_servicio_fecha' => 'date'
    ];

    protected $appends = [
        'kilometros_restantes_mantenimiento',
        'requiere_mantenimiento',
        'seguro_vigente',
        'verificacion_vigente',
        'dias_restantes_seguro',
        'dias_restantes_verificacion'
    ];
    
    public function activo()
    {
        return $this->belongsTo(Activo::class);
    }
    
    public function getKilometrosRestantesMantenimientoAttribute()
    {
        if ($this->kilometraje_proximo_mantenimiento) {
            return max(0, $this->kilometraje_proximo_mantenimiento - $this->kilometraje_actual);
        }
        return null;
    }
    
    public function getRequiereMantenimientoAttribute()
    {
        if ($this->kilometraje_proximo_mantenimiento) {
            return $this->kilometraje_actual >= $this->kilometraje_proximo_mantenimiento;
        }
        return false;
    }
    
    public function getSeguroVigenteAttribute()
    {
        return $this->vencimiento_seguro && $this->vencimiento_seguro >= now();
    }
    
    public function getVerificacionVigenteAttribute()
    {
        return $this->vencimiento_verificacion && $this->vencimiento_verificacion >= now();
    }

    public function getDiasRestantesSeguroAttribute(): ?int
    {
        if (!$this->vencimiento_seguro) {
            return null;
        }
        $dias = now()->diffInDays($this->vencimiento_seguro, false);
        return max(0, $dias);
    }

    public function getDiasRestantesVerificacionAttribute(): ?int
    {
        if (!$this->vencimiento_verificacion) {
            return null;
        }
        $dias = now()->diffInDays($this->vencimiento_verificacion, false);
        return max(0, $dias);
    }

    public function scopeConSeguroVigente($query)
    {
        return $query->whereDate('vencimiento_seguro', '>=', now());
    }

    public function scopeConVerificacionVigente($query)
    {
        return $query->whereDate('vencimiento_verificacion', '>=', now());
    }

    public function actualizarKilometraje(float $km): bool
    {
        $this->kilometraje_actual = $km;
        return $this->save();
    }

    public function renovarSeguro(string $nuevaPoliza, string $nuevaFecha): bool
    {
        $this->poliza_seguro = $nuevaPoliza;
        $this->vencimiento_seguro = $nuevaFecha;
        return $this->save();
    }

    public function renovarVerificacion(string $nuevaPoliza, string $nuevaFecha): bool
    {
        $this->poliza_verificacion = $nuevaPoliza;
        $this->vencimiento_verificacion = $nuevaFecha;
        return $this->save();
    }
}