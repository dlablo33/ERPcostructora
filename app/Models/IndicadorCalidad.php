<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndicadorCalidad extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'indicadores_calidad';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'proyecto_id',
        'total_pruebas',
        'aprobadas',
        'rechazadas',
        'porcentaje_aprobacion',
        'indice_calidad',
        'eficiencia_inspeccion',
        'cumplimiento_normativo',
        'tiempo_respuesta',
        'fecha_actualizacion'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_pruebas' => 'integer',
        'aprobadas' => 'integer',
        'rechazadas' => 'integer',
        'porcentaje_aprobacion' => 'decimal:2',
        'indice_calidad' => 'decimal:2',
        'eficiencia_inspeccion' => 'decimal:2',
        'cumplimiento_normativo' => 'decimal:2',
        'tiempo_respuesta' => 'decimal:2',
        'fecha_actualizacion' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the project that owns the quality indicators.
     */
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    /**
     * Get the formatted approval percentage.
     */
    public function getPorcentajeAprobacionFormateadoAttribute(): string
    {
        return number_format($this->porcentaje_aprobacion, 1) . '%';
    }

    /**
     * Get the formatted quality index.
     */
    public function getIndiceCalidadFormateadoAttribute(): string
    {
        return number_format($this->indice_calidad, 1) . '%';
    }

    /**
     * Get the formatted efficiency inspection.
     */
    public function getEficienciaInspeccionFormateadoAttribute(): string
    {
        return number_format($this->eficiencia_inspeccion, 1) . '%';
    }

    /**
     * Get the formatted compliance.
     */
    public function getCumplimientoNormativoFormateadoAttribute(): string
    {
        return number_format($this->cumplimiento_normativo, 1) . '%';
    }

    /**
     * Get the formatted response time.
     */
    public function getTiempoRespuestaFormateadoAttribute(): string
    {
        return number_format($this->tiempo_respuesta, 1) . ' días';
    }

    /**
     * Check if the quality index is good (>= 80%).
     */
    public function isIndiceCalidadBueno(): bool
    {
        return $this->indice_calidad >= 80;
    }

    /**
     * Check if the quality index is regular (>= 60% and < 80%).
     */
    public function isIndiceCalidadRegular(): bool
    {
        return $this->indice_calidad >= 60 && $this->indice_calidad < 80;
    }

    /**
     * Check if the quality index is bad (< 60%).
     */
    public function isIndiceCalidadMalo(): bool
    {
        return $this->indice_calidad < 60;
    }

    /**
     * Get the color for the quality index.
     */
    public function getIndiceCalidadColorAttribute(): string
    {
        if ($this->isIndiceCalidadBueno()) {
            return '#28a745';
        }
        if ($this->isIndiceCalidadRegular()) {
            return '#ffc107';
        }
        return '#dc3545';
    }

    /**
     * Get the label for the quality index.
     */
    public function getIndiceCalidadLabelAttribute(): string
    {
        if ($this->isIndiceCalidadBueno()) {
            return 'Excelente';
        }
        if ($this->isIndiceCalidadRegular()) {
            return 'Regular';
        }
        return 'Crítico';
    }

    /**
     * Calculate and update indicators for a project.
     */
    public static function actualizarIndicadores($proyectoId): self
    {
        $total = PruebaCalidad::where('proyecto_id', $proyectoId)->count();
        $aprobadas = PruebaCalidad::where('proyecto_id', $proyectoId)
            ->where('resultado', 'Aprobada')
            ->count();
        $rechazadas = $total - $aprobadas;

        $porcentaje = $total > 0 ? ($aprobadas / $total) * 100 : 0;

        // Calcular índice de calidad
        $indiceCalidad = $porcentaje;
        
        // Penalización por no conformidades abiertas
        $ncAbiertas = NoConformidad::where('proyecto_id', $proyectoId)
            ->where('estado', 'En proceso')
            ->count();
        
        $penalizacion = min($ncAbiertas * 2, 20);
        $indiceCalidad = max($indiceCalidad - $penalizacion, 0);

        // Calcular eficiencia de inspección (simulado)
        $eficiencia = min($porcentaje * 0.95 + 5, 100);

        // Calcular cumplimiento normativo (simulado)
        $cumplimiento = min($porcentaje * 0.98 + 2, 100);

        // Calcular tiempo de respuesta (simulado)
        $tiempoRespuesta = max(5 - ($porcentaje / 20), 1);

        return self::updateOrCreate(
            ['proyecto_id' => $proyectoId],
            [
                'total_pruebas' => $total,
                'aprobadas' => $aprobadas,
                'rechazadas' => $rechazadas,
                'porcentaje_aprobacion' => $porcentaje,
                'indice_calidad' => $indiceCalidad,
                'eficiencia_inspeccion' => $eficiencia,
                'cumplimiento_normativo' => $cumplimiento,
                'tiempo_respuesta' => $tiempoRespuesta,
                'fecha_actualizacion' => now()
            ]
        );
    }

    /**
     * Get the quality level based on the index.
     */
    public function getNivelCalidadAttribute(): string
    {
        if ($this->indice_calidad >= 90) {
            return 'Excelente';
        }
        if ($this->indice_calidad >= 80) {
            return 'Muy Bueno';
        }
        if ($this->indice_calidad >= 70) {
            return 'Bueno';
        }
        if ($this->indice_calidad >= 60) {
            return 'Regular';
        }
        return 'Crítico';
    }

    /**
     * Get the color for the quality level.
     */
    public function getNivelCalidadColorAttribute(): string
    {
        return match ($this->getNivelCalidadAttribute()) {
            'Excelente' => '#28a745',
            'Muy Bueno' => '#20c997',
            'Bueno' => '#17a2b8',
            'Regular' => '#ffc107',
            'Crítico' => '#dc3545',
            default => '#6c757d',
        };
    }
}