<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PruebaCalidad extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pruebas_calidad';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'no_prueba',
        'proyecto_id',
        'tipo_prueba',
        'elemento',
        'fecha',
        'resultado',
        'responsable_id',
        'laboratorio',
        'valor',
        'especificacion',
        'norma',
        'observaciones',
        'certificado_path',
        'created_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the project that owns the quality test.
     */
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    /**
     * Get the responsible person for the quality test.
     */
    public function responsable(): BelongsTo
    {
        return $this->belongsTo(Plantilla::class, 'responsable_id', 'plantilla_id');
    }

    /**
     * Get the user who created the quality test.
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the non-conformity associated with the quality test.
     */
    public function noConformidad(): HasOne
    {
        return $this->hasOne(NoConformidad::class, 'prueba_id');
    }

    /**
     * Scope a query to only include approved tests.
     */
    public function scopeAprobadas($query)
    {
        return $query->where('resultado', 'Aprobada');
    }

    /**
     * Scope a query to only include rejected tests.
     */
    public function scopeRechazadas($query)
    {
        return $query->where('resultado', 'Rechazada');
    }

    /**
     * Scope a query to only include pending tests.
     */
    public function scopePendientes($query)
    {
        return $query->where('resultado', 'Pendiente');
    }

    /**
     * Scope a query to filter by project.
     */
    public function scopePorProyecto($query, $proyectoId)
    {
        return $query->where('proyecto_id', $proyectoId);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
    }

    /**
     * Get the formatted date attribute.
     */
    public function getFechaFormateadaAttribute(): string
    {
        return $this->fecha ? $this->fecha->format('d/m/Y') : 'N/A';
    }

    /**
     * Get the full test number with prefix.
     */
    public function getNumeroPruebaAttribute(): string
    {
        return $this->no_prueba ?? 'N/A';
    }

    /**
     * Check if the test was approved.
     */
    public function isAprobada(): bool
    {
        return $this->resultado === 'Aprobada';
    }

    /**
     * Check if the test was rejected.
     */
    public function isRechazada(): bool
    {
        return $this->resultado === 'Rechazada';
    }

    /**
     * Check if the test is pending.
     */
    public function isPendiente(): bool
    {
        return $this->resultado === 'Pendiente';
    }

    /**
     * Get the badge class for the result.
     */
    public function getResultadoBadgeClass(): string
    {
        return match ($this->resultado) {
            'Aprobada' => 'badge-success',
            'Rechazada' => 'badge-danger',
            default => 'badge-warning',
        };
    }

    /**
     * Generate the next test number.
     */
    public static function generarSiguienteNumero(): string
    {
        $year = now()->format('Y');
        $last = self::whereYear('created_at', $year)->count();
        $numero = str_pad($last + 1, 3, '0', STR_PAD_LEFT);
        return "LAB-{$year}-{$numero}";
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->no_prueba)) {
                $model->no_prueba = self::generarSiguienteNumero();
            }
        });
    }
}