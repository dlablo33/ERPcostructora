<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;

class SatcatUsoCfdi extends Model
{
    protected $table = 'satcat_uso_cfdi';
    protected $fillable = ['clave', 'descripcion', 'estatus'];
    protected $casts = ['estatus' => 'boolean'];

    public function contactos() { return $this->hasMany(Contacto::class, 'satcat_uso_cfdi_clave', 'clave'); }
    public function facturas() { return $this->hasMany(Factura::class, 'satcat_uso_cfdi_clave', 'clave'); }
}