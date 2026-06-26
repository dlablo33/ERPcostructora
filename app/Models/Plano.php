<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plano extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'planos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'no_plano',
        'nombre',
        'proyecto_id',
        'disciplina',
        'subdisciplina',
        'revision',
        'estado',
        'fecha',
        'fecha_aprobacion',
        'formato',
        'escala',
        'tamanio_bytes',
        'descripcion',
        'documento_path',
        'documento_nombre',
        'miniatura_path',
        'ultima_revision_por',
        'aprobado_por',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha' => 'date',
        'fecha_aprobacion' => 'date',
        'tamanio_bytes' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the project that owns the plan.
     */
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    /**
     * Get the user who last revised the plan.
     */
    public function ultimaRevisionPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ultima_revision_por');
    }

    /**
     * Get the user who approved the plan.
     */
    public function aprobadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }

    /**
     * Get the user who created the plan.
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the versions for the plan.
     */
    public function versiones(): HasMany
    {
        return $this->hasMany(DocumentoVersion::class, 'documento_id')
            ->where('documento_tipo', 'plano');
    }

    /**
     * Get the current version of the plan.
     */
    public function versionActual()
    {
        return $this->hasOne(DocumentoVersion::class, 'documento_id')
            ->where('documento_tipo', 'plano')
            ->where('es_actual', true);
    }

    /**
     * Scope a query to only include approved plans.
     */
    public function scopeAprobados($query)
    {
        return $query->where('estado', 'Aprobado');
    }

    /**
     * Scope a query to only include plans in review.
     */
    public function scopeEnRevision($query)
    {
        return $query->where('estado', 'En Revisión');
    }

    /**
     * Scope a query to only include pending plans.
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'Pendiente');
    }

    /**
     * Scope a query to filter by discipline.
     */
    public function scopePorDisciplina($query, $disciplina)
    {
        return $query->where('disciplina', $disciplina);
    }

    /**
     * Scope a query to filter by project.
     */
    public function scopePorProyecto($query, $proyectoId)
    {
        return $query->where('proyecto_id', $proyectoId);
    }

    /**
     * Get the formatted file size.
     */
    public function getTamanioFormateadoAttribute(): string
    {
        $bytes = $this->tamanio_bytes;
        if ($bytes === 0) return '0 B';
        
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes, 1024));
        return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
    }

    /**
     * Get the status badge class.
     */
    public function getEstadoBadgeClassAttribute(): string
    {
        return match ($this->estado) {
            'Aprobado' => 'badge-success',
            'En Revisión' => 'badge-warning',
            'Pendiente' => 'badge-secondary',
            default => 'badge-secondary',
        };
    }

    /**
     * Get the discipline badge class.
     */
    public function getDisciplinaBadgeClassAttribute(): string
    {
        return match ($this->disciplina) {
            'Arquitectura' => 'badge-primary',
            'Estructura' => 'badge-danger',
            'Instalaciones' => 'badge-info',
            'Eléctricas' => 'badge-warning',
            'Hidráulicas' => 'badge-success',
            default => 'badge-secondary',
        };
    }

    /**
     * Check if plan is approved.
     */
    public function isAprobado(): bool
    {
        return $this->estado === 'Aprobado';
    }

    /**
     * Check if plan is in review.
     */
    public function isEnRevision(): bool
    {
        return $this->estado === 'En Revisión';
    }

    /**
     * Get the full plan number with prefix.
     */
    public function getNumeroPlanoAttribute(): string
    {
        return $this->no_plano ?? 'N/A';
    }

    /**
     * Get the revision number.
     */
    public function getRevisionNumeroAttribute(): int
    {
        if (preg_match('/Rev\.(\d+)/', $this->revision, $matches)) {
            return (int) $matches[1];
        }
        return 0;
    }

    /**
     * Increment the revision number.
     */
    public function incrementarRevision(): string
    {
        $actual = $this->revision_numero;
        $nueva = $actual + 1;
        $this->revision = "Rev.{$nueva}";
        return $this->revision;
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->revision)) {
                $model->revision = 'Rev.0';
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('estado') && $model->estado === 'Aprobado' && empty($model->fecha_aprobacion)) {
                $model->fecha_aprobacion = now();
            }
        });
    }
}