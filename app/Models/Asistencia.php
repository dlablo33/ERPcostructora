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

    /**
     * Relación con el usuario (empleado como usuario del sistema)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con el empleado (plantilla)
     */
    public function empleado()
    {
        return $this->belongsTo(Plantilla::class, 'plantilla_id', 'plantilla_id');
    }

    /**
     * Alias para plantilla (por compatibilidad)
     */
    public function plantilla()
    {
        return $this->belongsTo(Plantilla::class, 'plantilla_id', 'plantilla_id');
    }

    /**
     * Relación con el usuario que registró la asistencia
     */
    public function registrador()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    // ============================================
    // ACCESORES
    // ============================================

    /**
     * Obtener el nombre de la persona (empleado)
     */
    public function getNombrePersonaAttribute()
    {
        // Intentar obtener desde la relación empleado
        if ($this->relationLoaded('empleado') && $this->empleado) {
            return $this->empleado->nombre_completo;
        }
        
        // Cargar la relación si no está cargada
        if ($this->plantilla_id && !$this->relationLoaded('empleado')) {
            $empleado = Plantilla::find($this->plantilla_id);
            if ($empleado) {
                return trim($empleado->nombre . ' ' . $empleado->apellido_paterno . ' ' . $empleado->apellido_materno);
            }
        }
        
        // Intentar desde la relación user
        if ($this->relationLoaded('user') && $this->user) {
            return $this->user->name;
        }
        
        return 'Desconocido';
    }

    /**
     * Alias para nombre_persona
     */
    public function getEmpleadoNombreAttribute()
    {
        return $this->nombre_persona;
    }
}