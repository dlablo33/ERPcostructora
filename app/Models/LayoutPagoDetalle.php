<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LayoutPagoDetalle extends Model
{
    protected $table = 'layout_pago_detalle';

    protected $fillable = [
        'layout_pago_id',
        'pago_id',
        'programacion',
        'referencia',
        'fecha',
        'proveedor_nombre',
        'monto',
        'banco',
        'estatus',
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'float',
    ];

    public function layout(): BelongsTo
    {
        return $this->belongsTo(LayoutPago::class, 'layout_pago_id');
    }

    public function pago(): BelongsTo
    {
        return $this->belongsTo(Pago::class, 'pago_id');
    }
}