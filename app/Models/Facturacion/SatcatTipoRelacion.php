<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;

class SatcatTipoRelacion extends Model
{
    protected $table = 'satcat_tipo_relacion';
    protected $fillable = ['clave', 'descripcion', 'estatus'];
    protected $casts = ['estatus' => 'boolean'];

    public function cfdiRelacionados() { return $this->hasMany(CFDIRelacionado::class, 'satcat_tipo_relacion_clave', 'clave'); }
    public function facturasRelacionadas() { return $this->hasMany(FacturaRelacionado::class, 'satcat_tipo_relacion_clave', 'clave'); }
}