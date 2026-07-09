<?php
// app/Models/OrdenTrabajoContratista.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdenTrabajoContratista extends Model
{
    protected $table = 'ordenes_trabajo_contratista';
    
    protected $fillable = [
        'asignacion_id',
        'folio',
        'titulo',
        'descripcion',
        'fecha_emision',
        'fecha_inicio',
        'fecha_fin',
        'monto_estimado',
        'status',
        'aceptada_por',
        'fecha_aceptacion',
        'observaciones',
        'created_by'
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'monto_estimado' => 'decimal:2',
        'fecha_aceptacion' => 'date'
    ];

    /**
     * Estados disponibles
     */
    const STATUS = [
        'emitida' => 'Emitida',
        'aceptada' => 'Aceptada',
        'en_progreso' => 'En Progreso',
        'finalizada' => 'Finalizada'
    ];

    /**
     * Relación con asignación
     */
    public function asignacion(): BelongsTo
    {
        return $this->belongsTo(AsignacionContratista::class);
    }

    /**
     * Relación con contratista que aceptó
     */
    public function aceptadaPor(): BelongsTo
    {
        return $this->belongsTo(Contratista::class, 'aceptada_por');
    }

    /**
     * Relación con creador
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope por status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope por rango de fechas
     */
    public function scopeBetweenDates($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha_emision', [$inicio, $fin]);
    }

    /**
     * Accessor para status formateado
     */
    public function getStatusFormateadoAttribute(): string
    {
        return self::STATUS[$this->status] ?? $this->status;
    }

    /**
     * Accessor para badge de status
     */
    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'emitida' => 'secondary',
            'aceptada' => 'info',
            'en_progreso' => 'primary',
            'finalizada' => 'success'
        ];
        return $badges[$this->status] ?? 'secondary';
    }

    /**
     * Método para aceptar la orden
     */
    public function aceptar($contratistaId): void
    {
        $this->status = 'aceptada';
        $this->aceptada_por = $contratistaId;
        $this->fecha_aceptacion = now()->toDateString();
        $this->save();
    }

    /**
     * Método para iniciar la orden
     */
    public function iniciar(): void
    {
        $this->status = 'en_progreso';
        $this->fecha_inicio = now()->toDateString();
        $this->save();
    }

    /**
     * Método para finalizar la orden
     */
    public function finalizar(): void
    {
        $this->status = 'finalizada';
        $this->fecha_fin = now()->toDateString();
        $this->save();
    }
}