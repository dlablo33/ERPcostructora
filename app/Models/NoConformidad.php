<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class NoConformidad extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'no_conformidades';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'no_nc',
        'proyecto_id',
        'descripcion',
        'fecha_deteccion',
        'fecha_limite',
        'gravedad',
        'responsable_id',
        'estado',
        'acciones_tomadas',
        'causa_raiz',
        'prueba_id',
        'documento_path',
        'created_by',
        'cerrado_por',
        'fecha_cierre'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_deteccion' => 'date',
        'fecha_limite' => 'date',
        'fecha_cierre' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the project that owns the non-conformity.
     */
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    /**
     * Get the responsible person for the non-conformity.
     */
    public function responsable(): BelongsTo
    {
        return $this->belongsTo(Plantilla::class, 'responsable_id', 'plantilla_id');
    }

    /**
     * Get the quality test associated with the non-conformity.
     */
    public function prueba(): BelongsTo
    {
        return $this->belongsTo(PruebaCalidad::class, 'prueba_id');
    }

    /**
     * Get the user who created the non-conformity.
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who closed the non-conformity.
     */
    public function cerradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cerrado_por');
    }

    /**
     * Scope a query to only include high severity non-conformities.
     */
    public function scopeGravedadAlta($query)
    {
        return $query->where('gravedad', 'Alta');
    }

    /**
     * Scope a query to only include medium severity non-conformities.
     */
    public function scopeGravedadMedia($query)
    {
        return $query->where('gravedad', 'Media');
    }

    /**
     * Scope a query to only include low severity non-conformities.
     */
    public function scopeGravedadBaja($query)
    {
        return $query->where('gravedad', 'Baja');
    }

    /**
     * Scope a query to only include open non-conformities.
     */
    public function scopeAbiertas($query)
    {
        return $query->where('estado', 'En proceso');
    }

    /**
     * Scope a query to only include corrected non-conformities.
     */
    public function scopeCorregidas($query)
    {
        return $query->where('estado', 'Corregida');
    }

    /**
     * Scope a query to only include closed non-conformities.
     */
    public function scopeCerradas($query)
    {
        return $query->where('estado', 'Cerrada');
    }

    /**
     * Scope a query to filter by project.
     */
    public function scopePorProyecto($query, $proyectoId)
    {
        return $query->where('proyecto_id', $proyectoId);
    }

    /**
     * Get the formatted detection date attribute.
     */
    public function getFechaDeteccionFormateadaAttribute(): string
    {
        return $this->fecha_deteccion ? $this->fecha_deteccion->format('d/m/Y') : 'N/A';
    }

    /**
     * Get the formatted limit date attribute.
     */
    public function getFechaLimiteFormateadaAttribute(): string
    {
        return $this->fecha_limite ? $this->fecha_limite->format('d/m/Y') : 'N/A';
    }

    /**
     * Get the full NC number.
     */
    public function getNumeroNcAttribute(): string
    {
        return $this->no_nc ?? 'N/A';
    }

    /**
     * Get the badge class for severity.
     */
    public function getGravedadBadgeClass(): string
    {
        return match ($this->gravedad) {
            'Alta' => 'badge-danger',
            'Media' => 'badge-warning',
            'Baja' => 'badge-success',
            default => 'badge-secondary',
        };
    }

    /**
     * Get the badge class for status.
     */
    public function getEstadoBadgeClass(): string
    {
        return match ($this->estado) {
            'En proceso' => 'badge-warning',
            'Corregida' => 'badge-info',
            'Cerrada' => 'badge-success',
            default => 'badge-secondary',
        };
    }

    /**
     * Get the status color for display.
     */
    public function getEstadoColorAttribute(): string
    {
        return match ($this->estado) {
            'En proceso' => '#ffc107',
            'Corregida' => '#17a2b8',
            'Cerrada' => '#28a745',
            default => '#6c757d',
        };
    }

    /**
     * Get the severity color for display.
     */
    public function getGravedadColorAttribute(): string
    {
        return match ($this->gravedad) {
            'Alta' => '#dc3545',
            'Media' => '#ffc107',
            'Baja' => '#28a745',
            default => '#6c757d',
        };
    }

    /**
     * Check if the non-conformity is open.
     */
    public function isAbierta(): bool
    {
        return $this->estado === 'En proceso';
    }

    /**
     * Check if the non-conformity is corrected.
     */
    public function isCorregida(): bool
    {
        return $this->estado === 'Corregida';
    }

    /**
     * Check if the non-conformity is closed.
     */
    public function isCerrada(): bool
    {
        return $this->estado === 'Cerrada';
    }

    /**
     * Get the days since detection.
     */
    public function getDiasDesdeDeteccionAttribute(): int
    {
        if (!$this->fecha_deteccion) {
            return 0;
        }
        return $this->fecha_deteccion->diffInDays(now());
    }

    /**
     * Get the days remaining until limit date.
     */
    public function getDiasRestantesAttribute(): int
    {
        if (!$this->fecha_limite) {
            return 0;
        }
        $diff = now()->diffInDays($this->fecha_limite, false);
        return max($diff, 0);
    }

    /**
     * Get the days overdue.
     */
    public function getDiasVencidosAttribute(): int
    {
        if (!$this->fecha_limite || $this->isCerrada()) {
            return 0;
        }
        $diff = now()->diffInDays($this->fecha_limite, false);
        return $diff < 0 ? abs($diff) : 0;
    }

    /**
     * Generate the next NC number.
     */
    public static function generarSiguienteNumero(): string
    {
        $year = now()->format('Y');
        $last = self::whereYear('created_at', $year)->count();
        $numero = str_pad($last + 1, 3, '0', STR_PAD_LEFT);
        return "NC-{$year}-{$numero}";
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->no_nc)) {
                $model->no_nc = self::generarSiguienteNumero();
            }
        });

        static::updating(function ($model) {
            // Si el estado cambia a "Cerrada", registrar fecha de cierre
            if ($model->isDirty('estado') && $model->estado === 'Cerrada' && empty($model->fecha_cierre)) {
                $model->fecha_cierre = now();
            }
        });
    }
}