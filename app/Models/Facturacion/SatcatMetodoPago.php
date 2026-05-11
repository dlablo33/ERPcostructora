<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;

class SatcatMetodoPago extends Model
{
    protected $table = 'satcat_metodos_pago';
    protected $fillable = ['clave', 'descripcion', 'estatus'];
    protected $casts = ['estatus' => 'boolean'];

    public function facturas() { return $this->hasMany(Factura::class, 'satcat_metodos_pago_clave', 'clave'); }
}