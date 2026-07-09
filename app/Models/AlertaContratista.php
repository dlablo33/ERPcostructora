<?php
// app/Models/AlertaContratista.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlertaContratista extends Model
{
    protected $table = 'alertas_contratista';
    
    protected $fillable = [
        'contratista_id',
        'asignacion_id',
        'tipo',
        'titulo',
        'descripcion',
        'nivel',
        'leida',
        'fecha_limite',
        'generada_por'
    ];

    protected $casts = [
        'leida' => 'boolean',
        'fecha_limite' => 'date'
    ];

    /**
     * Tipos de alerta
     */
    const TIPOS = [
        'presupuesto' => 'Presupuesto',
        'vencimiento' => 'Vencimiento',
        'documento' => 'Documento',
        'evaluacion' => 'Evaluación',
        'pago' => 'Pago'
    ];

    /**
     * Niveles de alerta
     */
    const NIVELES = [
        'info' => 'Información',
        'warning' => 'Advertencia',
        'danger' => 'Peligro'
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
     * Relación con usuario que generó la alerta
     */
    public function generadaPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generada_por');
    }

    /**
     * Scope de alertas no leídas
     */
    public function scopeNoLeidas($query)
    {
        return $query->where('leida', false);
    }

    /**
     * Scope por nivel
     */
    public function scopeByNivel($query, $nivel)
    {
        return $query->where('nivel', $nivel);
    }

    /**
     * Scope por tipo
     */
    public function scopeByTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Scope por vencimiento próximo
     */
    public function scopeProximoVencer($query, $dias = 7)
    {
        return $query->whereNotNull('fecha_limite')
            ->whereBetween('fecha_limite', [
                now()->toDateString(),
                now()->addDays($dias)->toDateString()
            ]);
    }

    /**
     * Accessor para tipo formateado
     */
    public function getTipoFormateadoAttribute(): string
    {
        return self::TIPOS[$this->tipo] ?? $this->tipo;
    }

    /**
     * Accessor para nivel formateado
     */
    public function getNivelFormateadoAttribute(): string
    {
        return self::NIVELES[$this->nivel] ?? $this->nivel;
    }

    /**
     * Accessor para badge de nivel
     */
    public function getNivelBadgeAttribute(): string
    {
        $badges = [
            'info' => 'info',
            'warning' => 'warning',
            'danger' => 'danger'
        ];
        return $badges[$this->nivel] ?? 'secondary';
    }

    /**
     * Método para marcar como leída
     */
    public function marcarComoLeida(): void
    {
        $this->leida = true;
        $this->save();
    }
}