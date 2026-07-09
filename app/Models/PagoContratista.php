<?php
// app/Models/PagoContratista.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PagoContratista extends Model
{
    use SoftDeletes;

    protected $table = 'pagos_contratista';
    
    protected $fillable = [
        'contratista_id',
        'asignacion_id',
        'gasto_id',
        'folio',
        'fecha_pago',
        'monto',
        'forma_pago',
        'referencia',
        'comprobante_path',
        'observaciones',
        'created_by'
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'monto' => 'decimal:2'
    ];

    /**
     * Formas de pago disponibles
     */
    const FORMAS_PAGO = [
        'transferencia' => 'Transferencia',
        'cheque' => 'Cheque',
        'efectivo' => 'Efectivo'
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
     * Relación con gasto
     */
    public function gasto(): BelongsTo
    {
        return $this->belongsTo(GastoContratista::class);
    }

    /**
     * Relación con creador
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope por rango de fechas
     */
    public function scopeBetweenDates($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha_pago', [$inicio, $fin]);
    }

    /**
     * Scope por forma de pago
     */
    public function scopeByFormaPago($query, $forma)
    {
        return $query->where('forma_pago', $forma);
    }

    /**
     * Accessor para forma de pago formateada
     */
    public function getFormaPagoFormateadaAttribute(): string
    {
        return self::FORMAS_PAGO[$this->forma_pago] ?? $this->forma_pago;
    }

    /**
     * Accessor para monto formateado
     */
    public function getMontoFormateadoAttribute(): string
    {
        return '$' . number_format($this->monto, 2);
    }

    /**
     * Método para generar folio
     */
    public static function generarFolio(): string
    {
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $last = self::whereYear('fecha_pago', $year)
            ->whereMonth('fecha_pago', $month)
            ->count() + 1;
        
        return "PAG-{$year}{$month}{$day}-" . str_pad($last, 4, '0', STR_PAD_LEFT);
    }
}