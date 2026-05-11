<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;

class CFDIRelacionado extends Model
{
    protected $table = 'cfdi_relacionados';
    protected $primaryKey = 'cfdi_relacionado_id';
    protected $fillable = ['cfdi_id', 'timbrefiscaldigitalUUID', 'UUID', 'satcat_tipo_relacion_clave'];

    public function cfdi() { return $this->belongsTo(CFDI::class, 'cfdi_id'); }
    public function tipoRelacion() { return $this->belongsTo(SatcatTipoRelacion::class, 'satcat_tipo_relacion_clave', 'clave'); }
}