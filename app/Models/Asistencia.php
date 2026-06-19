<?php

namespace App\Models;

use App\Models\User;
use App\Models\Plantilla;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Asistencia extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'asistencias';

    protected $fillable = [
        'folio',
        'user_id',
        'plantilla_id',
        'cuadrilla_id',
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
        'semana_fin' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'estatus_nombre',
        'estatus_badge',
        'tipo_registro_nombre',
        'nombre_completo',
        'horas_trabajadas',
        'es_retardo'
    ];

    // ============================================
    // CATÁLOGOS
    // ============================================

    const ESTATUS_REGISTRO = [
        'presente' => 'Presente',
        'ausente' => 'Ausente',
        'retardo' => 'Retardo',
        'vacaciones' => 'Vacaciones',
        'permiso' => 'Permiso'
    ];

    const ESTATUS_BADGE = [
        'presente' => 'badge-presente',
        'ausente' => 'badge-ausente',
        'retardo' => 'badge-retardo',
        'vacaciones' => 'badge-vacaciones',
        'permiso' => 'badge-permiso'
    ];

    const TIPOS_REGISTRO = [
        'entrada' => 'Entrada',
        'salida' => 'Salida',
        'ambos' => 'Entrada/Salida'
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

    /**
     * Relación con la cuadrilla
     */
    public function cuadrilla()
    {
        return $this->belongsTo(Cuadrilla::class, 'cuadrilla_id');
    }

    // ============================================
    // ACCESSORS
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
                return trim($empleado->nombre . ' ' . ($empleado->apellido_paterno ?? '') . ' ' . ($empleado->apellido_materno ?? ''));
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

    /**
     * Obtener el nombre completo del empleado
     */
    public function getNombreCompletoAttribute(): string
    {
        if (!$this->empleado) {
            return 'Empleado no encontrado';
        }
        return trim($this->empleado->nombre . ' ' . 
                   ($this->empleado->apellido_paterno ?? '') . ' ' . 
                   ($this->empleado->apellido_materno ?? ''));
    }

    /**
     * Obtener el nombre del estatus
     */
    public function getEstatusNombreAttribute(): string
    {
        return self::ESTATUS_REGISTRO[$this->estatus] ?? $this->estatus;
    }

    /**
     * Obtener la clase CSS del badge para el estatus
     */
    public function getEstatusBadgeAttribute(): string
    {
        return self::ESTATUS_BADGE[$this->estatus] ?? 'badge-estatus';
    }

    /**
     * Obtener el nombre del tipo de registro
     */
    public function getTipoRegistroNombreAttribute(): string
    {
        return self::TIPOS_REGISTRO[$this->tipo_registro] ?? $this->tipo_registro;
    }

    /**
     * Calcular horas trabajadas
     */
    public function getHorasTrabajadasAttribute(): float
    {
        if (!$this->hora_entrada || !$this->hora_salida) {
            return 0;
        }

        $entrada = Carbon::parse($this->hora_entrada);
        $salida = Carbon::parse($this->hora_salida);
        
        // Si la salida es menor que la entrada, es porque pasó de medianoche
        if ($salida->lt($entrada)) {
            $salida->addDay();
        }
        
        return $entrada->diffInHours($salida) + ($entrada->diffInMinutes($salida) % 60) / 60;
    }

    /**
     * Determinar si es retardo
     */
    public function getEsRetardoAttribute(): bool
    {
        if (!$this->hora_entrada) {
            return false;
        }
        $horaEntrada = Carbon::parse($this->hora_entrada);
        $horaBase = Carbon::parse('07:00:00');
        return $horaEntrada->gt($horaBase) && $this->estatus === 'presente';
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope por fecha
     */
    public function scopeByFecha($query, $fecha)
    {
        if ($fecha) {
            return $query->whereDate('fecha', $fecha);
        }
        return $query;
    }

    /**
     * Scope por rango de fechas
     */
    public function scopeByRangoFechas($query, $fechaInicio, $fechaFin)
    {
        if ($fechaInicio && $fechaFin) {
            return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }
        return $query;
    }

    /**
     * Scope por empleado
     */
    public function scopeByEmpleado($query, $empleadoId)
    {
        if ($empleadoId) {
            return $query->where('plantilla_id', $empleadoId);
        }
        return $query;
    }

    /**
     * Scope por cuadrilla
     */
    public function scopeByCuadrilla($query, $cuadrillaId)
    {
        if ($cuadrillaId) {
            return $query->where('cuadrilla_id', $cuadrillaId);
        }
        return $query;
    }

    /**
     * Scope por estatus
     */
    public function scopeByEstatus($query, $estatus)
    {
        if ($estatus) {
            return $query->where('estatus', $estatus);
        }
        return $query;
    }

    /**
     * Scope solo presentes
     */
    public function scopePresentes($query)
    {
        return $query->where('estatus', 'presente');
    }

    /**
     * Scope solo ausentes
     */
    public function scopeAusentes($query)
    {
        return $query->where('estatus', 'ausente');
    }

    /**
     * Scope solo retardos
     */
    public function scopeConRetardo($query)
    {
        return $query->where('estatus', 'retardo');
    }

    /**
     * Scope para búsqueda general
     */
    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->whereHas('empleado', function($sub) use ($termino) {
                $sub->where('nombre', 'LIKE', "%{$termino}%")
                    ->orWhere('apellido_paterno', 'LIKE', "%{$termino}%")
                    ->orWhere('numero_empleado_interno', 'LIKE', "%{$termino}%");
            });
        }
        return $query;
    }

    // ============================================
    // MÉTODOS DE NEGOCIO
    // ============================================

    /**
     * Verifica si está presente
     */
    public function estaPresente(): bool
    {
        return $this->estatus === 'presente';
    }

    /**
     * Verifica si está ausente
     */
    public function estaAusente(): bool
    {
        return $this->estatus === 'ausente';
    }

    /**
     * Verifica si tiene retardo
     */
    public function tieneRetardo(): bool
    {
        return $this->estatus === 'retardo';
    }

    /**
     * Registrar entrada
     */
    public function registrarEntrada(string $hora = null): bool
    {
        $this->hora_entrada = $hora ?? Carbon::now()->format('H:i:s');
        $this->estatus = 'presente';
        return $this->save();
    }

    /**
     * Registrar salida
     */
    public function registrarSalida(string $hora = null): bool
    {
        $this->hora_salida = $hora ?? Carbon::now()->format('H:i:s');
        return $this->save();
    }

    /**
     * Marcar como ausente
     */
    public function marcarAusente(): bool
    {
        $this->estatus = 'ausente';
        return $this->save();
    }

    /**
     * Marcar como retardo
     */
    public function marcarRetardo(string $hora = null): bool
    {
        $this->hora_entrada = $hora ?? Carbon::now()->format('H:i:s');
        $this->estatus = 'retardo';
        return $this->save();
    }

    /**
     * Obtener resumen de la asistencia
     */
    public function getResumen(): array
    {
        return [
            'id' => $this->id,
            'empleado' => $this->nombre_completo,
            'fecha' => $this->fecha?->format('d/m/Y'),
            'entrada' => $this->hora_entrada,
            'salida' => $this->hora_salida,
            'horas' => $this->horas_trabajadas,
            'estatus' => $this->estatus_nombre,
            'cuadrilla' => $this->cuadrilla?->nombre
        ];
    }

    // ============================================
    // EVENTOS
    // ============================================

    protected static function booted()
    {
        static::creating(function ($asistencia) {
            if (!$asistencia->folio) {
                $fecha = Carbon::parse($asistencia->fecha)->format('Ymd');
                $count = self::whereDate('fecha', $asistencia->fecha)->count() + 1;
                $asistencia->folio = 'ASIS-' . $fecha . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
            
            if (!$asistencia->user_id) {
                $asistencia->user_id = auth()->id();
            }
        });
    }
}