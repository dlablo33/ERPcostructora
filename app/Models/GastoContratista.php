<?php
// app/Models/GastoContratista.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GastoContratista extends Model
{
    use SoftDeletes;

    protected $table = 'gastos_contratista';
    
    protected $fillable = [
        'asignacion_id',
        'contratista_id',
        'proyecto_id',
        'tipo_gasto',
        'concepto',
        'descripcion',
        'fecha_gasto',
        'monto',
        'factura',
        'proveedor_externo',
        'comprobante_path',
        'status_pago',
        'fecha_pago',
        'created_by'
    ];

    protected $casts = [
        'fecha_gasto' => 'date',
        'monto' => 'decimal:2',
        'fecha_pago' => 'date'
    ];

    /**
     * Tipos de gasto disponibles
     */
    const TIPOS_GASTO = [
        'material' => 'Materiales',
        'mano_obra' => 'Mano de Obra',
        'maquinaria' => 'Maquinaria',
        'subcontrato' => 'Subcontrato',
        'otros' => 'Otros'
    ];

    /**
     * Estados de pago disponibles
     */
    const STATUS_PAGO = [
        'pendiente' => 'Pendiente',
        'pagado' => 'Pagado',
        'parcial' => 'Parcial'
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
     * Relación con proyecto
     */
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    /**
     * Relación con creador
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope por status de pago
     */
    public function scopeByStatusPago($query, $status)
    {
        return $query->where('status_pago', $status);
    }

    /**
     * Scope por tipo de gasto
     */
    public function scopeByTipoGasto($query, $tipo)
    {
        return $query->where('tipo_gasto', $tipo);
    }

    /**
     * Scope por rango de fechas
     */
    public function scopeBetweenDates($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha_gasto', [$inicio, $fin]);
    }

    /**
     * Accessor para tipo de gasto formateado
     */
    public function getTipoGastoFormateadoAttribute(): string
    {
        return self::TIPOS_GASTO[$this->tipo_gasto] ?? $this->tipo_gasto;
    }

    /**
     * Accessor para status de pago formateado
     */
    public function getStatusPagoFormateadoAttribute(): string
    {
        return self::STATUS_PAGO[$this->status_pago] ?? $this->status_pago;
    }

    /**
     * Accessor para badge de status
     */
    public function getStatusPagoBadgeAttribute(): string
    {
        $badges = [
            'pendiente' => 'warning',
            'pagado' => 'success',
            'parcial' => 'info'
        ];
        return $badges[$this->status_pago] ?? 'secondary';
    }

    /**
     * Método para marcar como pagado
     */
    public function marcarComoPagado($fechaPago = null): void
    {
        $this->status_pago = 'pagado';
        $this->fecha_pago = $fechaPago ?? now()->toDateString();
        $this->save();
    }

    /**
     * Método para verificar si está pagado
     */
    public function isPagado(): bool
    {
        return $this->status_pago === 'pagado';
    }

    /**
     * Método para obtener el monto formateado
     */
    public function getMontoFormateadoAttribute(): string
    {
        return '$' . number_format($this->monto, 2);
    }
}