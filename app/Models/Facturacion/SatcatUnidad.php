<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;

class SatcatUnidad extends Model
{
    protected $table = 'satcat_unidades';
    protected $fillable = ['clave', 'descripcion', 'simbolo', 'estatus'];
    protected $casts = ['estatus' => 'boolean'];

    public function conceptos() { return $this->hasMany(FacturaConcepto::class, 'satcat_unidades_clave', 'clave'); }
}