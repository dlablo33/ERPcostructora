<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prepago extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nombre de la tabla.
     */
    protected $table = 'prepagos';

    /**
     * Campos asignables masivamente.
     */
    protected $fillable = [
        'folio',
        'proveedor_id',
        'fecha',
        'monto',
        'observaciones',
        'estatus',
        'user_id',
    ];

    /**
     * Casts de atributos.
     */
    protected $casts = [
        'fecha'      => 'date',
        'monto'      => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Valores por defecto al crear.
     */
    protected $attributes = [
        'estatus' => 'activo',
    ];

    // ============================================
    // RELACIONES
    // ============================================

    /**
     * Proveedor asociado al prepago.
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    /**
     * Usuario que registró el prepago.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Solo prepagos activos.
     */
    public function scopeActivos($query)
    {
        return $query->where('estatus', 'activo');
    }

    /**
     * Filtrar por rango de fechas.
     */
    public function scopeEntreFechas($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha', [$inicio, $fin]);
    }

    /**
     * Filtrar por proveedor.
     */
    public function scopeDelProveedor($query, $proveedorId)
    {
        return $query->where('proveedor_id', $proveedorId);
    }

    // ============================================
    // HELPERS
    // ============================================

    /**
     * Genera el siguiente folio consecutivo del año.
     * Formato: PRE-2026-000001
     */
    public static function generarFolio(): string
    {
        $year = now()->year;

        $ultimo = static::withTrashed()
            ->whereYear('created_at', $year)
            ->lockForUpdate()
            ->max('id');

        $consecutivo = ($ultimo ?? 0) + 1;

        return 'PRE-' . $year . '-' . str_pad($consecutivo, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Accessor para monto formateado.
     */
    public function getMontoFormateadoAttribute(): string
    {
        return '$' . number_format($this->monto, 2);
    }
}