<?php
// app/Models/DocumentoContratista.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentoContratista extends Model
{
    protected $table = 'documentos_contratista';
    
    protected $fillable = [
        'contratista_id',
        'asignacion_id',
        'tipo_documento',
        'nombre_original',
        'ruta_archivo',
        'fecha_subida',
        'fecha_vencimiento',
        'subido_por',
        'observaciones'
    ];

    protected $casts = [
        'fecha_subida' => 'date',
        'fecha_vencimiento' => 'date'
    ];

    /**
     * Tipos de documento disponibles
     */
    const TIPOS = [
        'contrato' => 'Contrato',
        'carta_garantia' => 'Carta Garantía',
        'licencia' => 'Licencia',
        'seguro' => 'Seguro',
        'identificacion' => 'Identificación',
        'certificado' => 'Certificado',
        'otros' => 'Otros'
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
     * Relación con usuario que subió el documento
     */
    public function subidoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'subido_por');
    }

    /**
     * Scope por tipo de documento
     */
    public function scopeByTipo($query, $tipo)
    {
        return $query->where('tipo_documento', $tipo);
    }

    /**
     * Scope por vigencia
     */
    public function scopeVigente($query)
    {
        return $query->where(function($q) {
            $q->whereNull('fecha_vencimiento')
              ->orWhere('fecha_vencimiento', '>=', now()->toDateString());
        });
    }

    /**
     * Scope por vencimiento próximo
     */
    public function scopeProximoVencer($query, $dias = 30)
    {
        return $query->whereNotNull('fecha_vencimiento')
            ->whereBetween('fecha_vencimiento', [
                now()->toDateString(),
                now()->addDays($dias)->toDateString()
            ]);
    }

    /**
     * Accessor para tipo formateado
     */
    public function getTipoFormateadoAttribute(): string
    {
        return self::TIPOS[$this->tipo_documento] ?? $this->tipo_documento;
    }

    /**
     * Accessor para verificar si está vigente
     */
    public function getVigenteAttribute(): bool
    {
        if ($this->fecha_vencimiento) {
            return $this->fecha_vencimiento >= now()->toDateString();
        }
        return true;
    }

    /**
     * Accessor para días restantes
     */
    public function getDiasRestantesAttribute(): ?int
    {
        if ($this->fecha_vencimiento) {
            return now()->diffInDays($this->fecha_vencimiento, false);
        }
        return null;
    }
}