<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;

class SatcatFormaPago extends Model
{
    protected $table = 'satcat_formas_pago';
    protected $fillable = ['clave', 'descripcion', 'estatus'];
    protected $casts = ['estatus' => 'boolean'];

    public function facturas() { return $this->hasMany(Factura::class, 'satcat_formas_pago_clave', 'clave'); }
}