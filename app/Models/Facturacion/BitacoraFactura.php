<?php

namespace App\Models\Facturacion;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BitacoraFactura extends Model
{
    protected $table = 'bitacora_facturas';
    protected $primaryKey = 'bitacora_factura_id';
    protected $fillable = ['factura_id', 'comentario', '__userId__'];

    public function factura() { return $this->belongsTo(Factura::class, 'factura_id'); }
    public function usuario() { return $this->belongsTo(User::class, '__userId__'); }
}