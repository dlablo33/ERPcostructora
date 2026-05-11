<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;

class SatcatClaveProducto extends Model
{
    protected $table = 'satcat_clave_productos';
    protected $fillable = ['clave', 'descripcion', 'estatus'];
    protected $casts = ['estatus' => 'boolean'];

    public function conceptos() { return $this->hasMany(FacturaConcepto::class, 'satcat_clave_productos_clave', 'clave'); }
}