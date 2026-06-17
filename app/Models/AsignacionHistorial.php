<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AsignacionHistorial extends Model
{
    use HasFactory;

    protected $table = 'asignaciones_historial';

    protected $fillable = [
        'asignacion_id',
        'usuario_id',
        'accion',
        'fecha',
        'detalles',
        'rol_anterior',
        'rol_nuevo',
        'proyecto_anterior_id',
        'proyecto_nuevo_id',
        'status_anterior',
        'status_nuevo'
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $appends = [
        'accion_nombre'
    ];

    // ==================== RELACIONES ====================

    public function asignacion()
    {
        return $this->belongsTo(AsignacionPersonal::class, 'asignacion_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function proyectoAnterior()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_anterior_id');
    }

    public function proyectoNuevo()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_nuevo_id');
    }

    // ==================== ACCESSORS ====================

    public function getAccionNombreAttribute(): string
    {
        $acciones = [
            'asignacion' => 'Asignación',
            'cambio_rol' => 'Cambio de Rol',
            'cambio_proyecto' => 'Cambio de Proyecto',
            'cambio_status' => 'Cambio de Status',
            'baja' => 'Baja'
        ];
        return $acciones[$this->accion] ?? $this->accion;
    }

    // ==================== SCOPES ====================

    public function scopeByAsignacion($query, $asignacionId)
    {
        return $query->where('asignacion_id', $asignacionId);
    }

    public function scopeByAccion($query, $accion)
    {
        if ($accion) {
            return $query->where('accion', $accion);
        }
        return $query;
    }

    public function scopeByFecha($query, $fechaInicio, $fechaFin)
    {
        if ($fechaInicio && $fechaFin) {
            return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }
        return $query;
    }
}