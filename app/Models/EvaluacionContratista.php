<?php
// app/Models/EvaluacionContratista.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluacionContratista extends Model
{
    protected $table = 'evaluaciones_contratista';
    
    protected $fillable = [
        'contratista_id',
        'asignacion_id',
        'evaluador_id',
        'fecha_evaluacion',
        'calidad',
        'cumplimiento',
        'seguridad',
        'comunicacion',
        'promedio',
        'comentarios',
        'fortalezas',
        'areas_mejora'
    ];

    protected $casts = [
        'calidad' => 'decimal:2',
        'cumplimiento' => 'decimal:2',
        'seguridad' => 'decimal:2',
        'comunicacion' => 'decimal:2',
        'promedio' => 'decimal:2',
        'fecha_evaluacion' => 'date'
    ];

    /**
     * Relación con contratista
     */
    public function contratista(): BelongsTo
    {
        return $this->belongsTo(Contratista::class);
    }

    /**
     * Relación con asignación
     */
    public function asignacion(): BelongsTo
    {
        return $this->belongsTo(AsignacionContratista::class);
    }

    /**
     * Relación con evaluador
     */
    public function evaluador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluador_id');
    }

    /**
     * Scope por rango de fechas
     */
    public function scopeBetweenDates($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha_evaluacion', [$inicio, $fin]);
    }

    /**
     * Scope por calificación alta
     */
    public function scopeAltaCalificacion($query, $minimo = 8)
    {
        return $query->where('promedio', '>=', $minimo);
    }

    /**
     * Scope por calificación baja
     */
    public function scopeBajaCalificacion($query, $maximo = 5)
    {
        return $query->where('promedio', '<=', $maximo);
    }

    /**
     * Accessor para nivel de desempeño
     */
    public function getNivelDesempenoAttribute(): string
    {
        if ($this->promedio >= 8) {
            return 'Excelente';
        } elseif ($this->promedio >= 6) {
            return 'Aceptable';
        } else {
            return 'Necesita Mejora';
        }
    }

    /**
     * Accessor para badge de desempeño
     */
    public function getDesempenoBadgeAttribute(): string
    {
        if ($this->promedio >= 8) {
            return 'success';
        } elseif ($this->promedio >= 6) {
            return 'warning';
        } else {
            return 'danger';
        }
    }

    /**
     * Método para calcular promedio
     */
    public function calcularPromedio(): void
    {
        $suma = $this->calidad + $this->cumplimiento + $this->seguridad + $this->comunicacion;
        $this->promedio = $suma / 4;
        $this->save();
    }
}