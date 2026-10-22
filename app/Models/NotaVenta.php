<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotaVenta extends Model
{
    use SoftDeletes;

    protected $table = 'notas_venta';

    protected $fillable = [
        'folio', 'fecha', 'contacto_id', 'proyecto_id', 'cat_serie_id',
        'subtotal', 'descuento', 'iva', 'total',
        'estatus', 'facturada', 'factura_id',
        'observaciones', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'fecha'      => 'date',
        'facturada'  => 'boolean',
        'subtotal'   => 'decimal:2',
        'descuento'  => 'decimal:2',
        'iva'        => 'decimal:2',
        'total'      => 'decimal:2',
    ];

    // Estatus
    const ESTATUS_ABIERTA   = 1;
    const ESTATUS_FACTURADA = 19;
    const ESTATUS_CANCELADA = 21;

    public function conceptos()
    {
        return $this->hasMany(NotaVentaConcepto::class, 'nota_venta_id');
    }

    public function contacto()
    {
        return $this->belongsTo(Contacto::class, 'contacto_id', 'contacto_id');
    }

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'factura_id', 'factura_id');
    }

    public function scopeDisponibles($query)
    {
        return $query->where('facturada', false)
                     ->where('estatus', self::ESTATUS_ABIERTA)
                     ->whereNull('deleted_at');
    }
}