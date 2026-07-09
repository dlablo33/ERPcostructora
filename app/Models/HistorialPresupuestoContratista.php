<?php
// app/Models/HistorialPresupuestoContratista.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistorialPresupuestoContratista extends Model
{
    protected $table = 'historial_presupuesto_contratista';
    
    protected $fillable = [
        'asignacion_id',
        'contratista_id',
        'presupuesto_anterior',
        'presupuesto_nuevo',
        'gasto_acumulado',
        'motivo',
        'fecha_cambio',
        'realizado_por'
    ];

    protected $casts = [
        'presupuesto_anterior' => 'decimal:2',
        'presupuesto_nuevo' => 'decimal:2',
        'gasto_acumulado' => 'decimal:2',
        'fecha_cambio' => 'date'
    ];

    /**
     * Relación con asignación
     */
    public function asignacion(): BelongsTo
    {
        return $this->belongsTo(AsignacionContratista::class);
    }

    /**
     * Relación con contratista
     */
    public function contratista(): BelongsTo
    {
        return $this->belongsTo(Contratista::class);
    }

    /**
     * Relación con usuario que realizó el cambio
     */
    public function realizadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'realizado_por');
    }

    /**
     * Accessor para diferencia
     */
    public function getDiferenciaAttribute(): float
    {
        if ($this->presupuesto_anterior) {
            return $this->presupuesto_nuevo - $this->presupuesto_anterior;
        }
        return $this->presupuesto_nuevo;
    }

    /**
     * Accessor para porcentaje de cambio
     */
    public function getPorcentajeCambioAttribute(): float
    {
        if ($this->presupuesto_anterior > 0) {
            return (($this->presupuesto_nuevo - $this->presupuesto_anterior) / $this->presupuesto_anterior) * 100;
        }
        return 0;
    }
}