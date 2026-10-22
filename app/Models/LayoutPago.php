<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LayoutPago extends Model
{
    protected $table = 'layouts_pago';

    protected $fillable = [
        'folio',
        'fecha',
        'cuenta_nombre',
        'estatus',
        'referencia',
        'moneda',
        'tipo_cambio',
        'monto_total',
        'tipo_programacion',
        'descripcion',
        'cuenta_bancaria_id',
        'created_by',
    ];

    protected $casts = [
        'fecha'       => 'date',
        'tipo_cambio' => 'float',
        'monto_total' => 'float',
    ];

    public function detalles(): HasMany
    {
        return $this->hasMany(LayoutPagoDetalle::class, 'layout_pago_id');
    }

    public function cuenta(): BelongsTo
    {
        return $this->belongsTo(CuentaBancaria::class, 'cuenta_bancaria_id');
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Genera folio único con formato LAY-YY-0001
     */
    public static function generarFolio(): string
    {
        $anio   = date('y');
        $ultimo = static::whereYear('created_at', date('Y'))->max('id') ?? 0;

        return 'LAY-' . $anio . '-' . str_pad($ultimo + 1, 4, '0', STR_PAD_LEFT);
    }
}