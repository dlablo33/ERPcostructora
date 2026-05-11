<?php
// app/Models/FactorajeFactura.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Facturacion\Factura;

class FactorajeFactura extends Model
{
    protected $table = 'factoraje_facturas';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'solicitud_id',
        'factura_id',
        'monto_factura',
        'pagada_cliente',
        'fecha_pago_cliente'
    ];

    protected $casts = [
        'monto_factura' => 'decimal:2',
        'pagada_cliente' => 'boolean',
        'fecha_pago_cliente' => 'date'
    ];

    // Relaciones
    public function solicitud()
    {
        return $this->belongsTo(SolicitudFactoraje::class, 'solicitud_id', 'solicitud_id');
    }

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'factura_id', 'factura_id');
    }
    
}