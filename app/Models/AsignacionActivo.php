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
        'horometro_salida',
        'horometro_devolucion',
        'kilometraje_salida',
        'kilometraje_devolucion',
        'condicion_salida',
        'condicion_devolucion',
        'observaciones_salida',
        'observaciones_devolucion',
        'reporte_danos',
        'costo_reparacion',
        'estatus',
        'recibido_por'
    ];
    
    protected $casts = [
        'fecha_salida' => 'date',
        'fecha_devolucion_real' => 'date',
        'horometro_salida' => 'decimal:1',
        'horometro_devolucion' => 'decimal:1',
        'kilometraje_salida' => 'decimal:1',
        'kilometraje_devolucion' => 'decimal:1',
        'costo_reparacion' => 'decimal:2'
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
        return $this->condicion_devolucion === 'Danado' || !empty($this->reporte_danos);
    }
    
    public function devolver($data)
    {
        $this->update($data);
        
        // Actualizar estatus del activo
        if ($this->condicion_devolucion === 'Danado') {
            $this->activo->update(['estatus' => 'En mantenimiento']);
        } else {
            $this->activo->update(['estatus' => 'Disponible']);
        }
        
        // Actualizar estatus de la requisición
        if ($this->requisicion) {
            $this->requisicion->update(['estatus' => 'Devuelta']);
        }
        
        return true;
    }
}