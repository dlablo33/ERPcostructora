<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaVentaConcepto extends Model
{
    protected $table = 'notas_venta_conceptos';

    protected $fillable = [
        'nota_venta_id', 'codigo', 'descripcion',
        'cantidad', 'valor_unitario', 'descuento', 'importe', 'iva',
        'satcat_clave_productos_clave', 'satcat_unidades_clave',
        'observaciones',
    ];

    protected $casts = [
        'cantidad'       => 'decimal:4',
        'valor_unitario' => 'decimal:2',
        'descuento'      => 'decimal:2',
        'importe'        => 'decimal:2',
        'iva'            => 'decimal:2',
    ];

    public function notaVenta()
    {
        return $this->belongsTo(NotaVenta::class, 'nota_venta_id');
    }
}