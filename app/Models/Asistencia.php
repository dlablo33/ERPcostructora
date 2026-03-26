<?php

namespace App\Models;

use App\Models\User;
use App\Models\Plantilla;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asistencia extends Model
{
    use SoftDeletes;

    protected $table = 'asistencias';

    protected $fillable = [
        'folio',
        'user_id',
        'plantilla_id',
        'fecha',
        'hora_entrada',
        'hora_salida',
        'tipo_registro',
        'estatus',
        'observaciones',
        'registrado_por',
        'semana_inicio',
        'semana_fin',
        'semana'
    ];

    protected $casts = [
        'fecha' => 'date',
        'semana_inicio' => 'date',
        'semana_fin' => 'date'
    ];

    // ============================================
    // RELACIONES
    // ============================================

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plantilla()
    {
        return $this->belongsTo(Plantilla::class, 'plantilla_id', 'plantilla_id');
    }

    public function registrador()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    // ============================================
    // ACCESORES
    // ============================================

    public function getNombrePersonaAttribute()
    {
        if ($this->user) {
            return $this->user->name;
        }
        if ($this->plantilla) {
            return $this->plantilla->nombre_completo;
        }
        return 'Desconocido';
    }

    public function getFolioPersonaAttribute()
    {
        if ($this->user) {
            return $this->user->folio;
        }
        if ($this->plantilla) {
            return $this->plantilla->numero_empleado_interno ?? $this->plantilla->plantilla_id;
        }
        return '-';
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
    }

    public function scopePorSemana($query, $semana)
    {
        return $query->where('semana', $semana);
    }

    public function scopePorEmpleado($query, $empleadoId, $tipo = null)
    {
        if ($tipo === 'user') {
            return $query->where('user_id', $empleadoId);
        }
        if ($tipo === 'plantilla') {
            return $query->where('plantilla_id', $empleadoId);
        }
        return $query->where(function($q) use ($empleadoId) {
            $q->where('user_id', $empleadoId)
              ->orWhere('plantilla_id', $empleadoId);
        });
    }

    public function scopePorEstatus($query, $estatus)
    {
        return $query->where('estatus', $estatus);
    }

    public function scopeActivos($query)
    {
        return $query->where('estatus', 'Activo');
    }
}