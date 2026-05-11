<?php
// app/Models/ContrareciboFactura.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContrareciboFactura extends Model
{
    protected $table = 'contrarecibo_facturas';
    
    protected $fillable = [
        'contrarecibo_id',
        'factura_id',
        'monto_aplicado'
    ];

    protected $casts = [
        'monto_aplicado' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relaciones
    public function contrarecibo()
    {
        return $this->belongsTo(Contrarecibo::class, 'contrarecibo_id', 'contrarecibo_id');
    }

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'factura_id', 'factura_id');
    }
}