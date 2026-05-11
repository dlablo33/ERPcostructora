<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;

class SatcatRegimenFiscal extends Model
{
    protected $table = 'satcat_regimen_fiscal';
    protected $fillable = ['clave', 'descripcion', 'estatus'];
    protected $casts = ['estatus' => 'boolean'];

    public function contactos() { return $this->hasMany(Contacto::class, 'satcat_regimen_fiscal_clave', 'clave'); }
    public function datosGenerales() { return $this->hasMany(DatosGenerales::class, 'satcat_regimen_fiscal_clave', 'clave'); }
    public function facturas() { return $this->hasMany(Factura::class, 'satcat_regimen_fiscal_clave', 'clave'); }
}