<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AsignacionActivo extends Model
{
    use HasFactory;
    
    protected $table = 'asignaciones_activos';
    
    protected $fillable = [
        'requisicion_id',
        'activo_id',
        'proyecto_id',
        'responsable_asignado',
        'fecha_salida',
        'fecha_devolucion_real',
        'fecha_estimada_devolucion',
        'horometro_salida',
        'horometro_devolucion',
        'horas_estimadas',
        'horas_reales',
        'kilometraje_salida',
        'kilometraje_devolucion',
        'condicion_salida',
        'condicion_devolucion',
        'observaciones_salida',
        'observaciones_devolucion',
        'reporte_danos',
        'costo_reparacion',
        'costo_estimado',
        'costo_real',
        'estatus',
        'recibido_por'
    ];
    
    protected $casts = [
        'fecha_salida' => 'date',
        'fecha_devolucion_real' => 'date',
        'fecha_estimada_devolucion' => 'date',
        'horometro_salida' => 'decimal:2',
        'horometro_devolucion' => 'decimal:2',
        'horas_estimadas' => 'decimal:2',
        'horas_reales' => 'decimal:2',
        'kilometraje_salida' => 'decimal:2',
        'kilometraje_devolucion' => 'decimal:2',
        'costo_reparacion' => 'decimal:2',
        'costo_estimado' => 'decimal:2',
        'costo_real' => 'decimal:2'
    ];

    protected $appends = [
        'estatus_nombre',
        'horas_usadas',
        'kilometros_recorridos',
        'tiene_danos',
        'esta_activa',
        'esta_vencida'
    ];

    const ESTATUS = [
        'activa' => 'Activa',
        'asignado' => 'Asignado',
        'devuelto' => 'Devuelto',
        'vencido' => 'Vencido',
        'cancelado' => 'Cancelado'
    ];

    const CONDICIONES = [
        'excelente' => 'Excelente',
        'bueno' => 'Bueno',
        'regular' => 'Regular',
        'malo' => 'Malo',
        'danado' => 'Dañado'
    ];
    
    public function requisicion()
    {
        return $this->belongsTo(RequisicionActivo::class, 'requisicion_id');
    }
    
    public function activo()
    {
        return $this->belongsTo(Activo::class);
    }
    
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
    
    public function recibidoPor()
    {
        return $this->belongsTo(User::class, 'recibido_por');
    }
    
    public function getHorasUsadasAttribute()
    {
        if ($this->horometro_salida && $this->horometro_devolucion) {
            return $this->horometro_devolucion - $this->horometro_salida;
        }
        return null;
    }
    
    public function getKilometrosRecorridosAttribute()
    {
        if ($this->kilometraje_salida && $this->kilometraje_devolucion) {
            return $this->kilometraje_devolucion - $this->kilometraje_salida;
        }
        return null;
    }
    
    public function getTieneDanosAttribute()
    {
        return $this->condicion_devolucion === 'danado' || !empty($this->reporte_danos);
    }

    public function getEstatusNombreAttribute(): string
    {
        return self::ESTATUS[$this->estatus] ?? $this->estatus;
    }

    public function getEstaActivaAttribute(): bool
    {
        return $this->estatus === 'activa' || $this->estatus === 'asignado';
    }

    public function getEstaVencidaAttribute(): bool
    {
        return $this->estatus === 'vencido' || 
               ($this->fecha_estimada_devolucion && now()->gt($this->fecha_estimada_devolucion) && $this->esta_activa);
    }

    public function scopeActivas($query)
    {
        return $query->whereIn('estatus', ['activa', 'asignado']);
    }

    public function scopeDevueltas($query)
    {
        return $query->where('estatus', 'devuelto');
    }

    public function scopeByProyecto($query, $proyectoId)
    {
        if ($proyectoId) {
            return $query->where('proyecto_id', $proyectoId);
        }
        return $query;
    }

    public function scopeByActivo($query, $activoId)
    {
        if ($activoId) {
            return $query->where('activo_id', $activoId);
        }
        return $query;
    }
    
    public function devolver($data)
    {
        $this->update($data);
        
        // Actualizar estatus del activo
        if ($this->condicion_devolucion === 'danado') {
            $this->activo->update(['estatus' => 'mantenimiento']);
        } else {
            $this->activo->update(['estatus' => 'activo']);
        }
        
        // Actualizar estatus de la requisición
        if ($this->requisicion) {
            $this->requisicion->update(['estatus' => 'Devuelta']);
        }
        
        return true;
    }

    public function finalizarAsignacion($observaciones = null): bool
    {
        $this->estatus = 'devuelto';
        $this->fecha_devolucion_real = now();
        
        if ($observaciones) {
            $this->observaciones_devolucion = $observaciones;
        }
        
        return $this->save();
    }

    public function registrarDanos(string $reporte, float $costo = null): bool
    {
        $this->reporte_danos = $reporte;
        if ($costo !== null) {
            $this->costo_reparacion = $costo;
        }
        return $this->save();
    }
}