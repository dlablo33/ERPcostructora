<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;

class FacturaCancelada extends Model
{
    protected $table = 'factura_cancelada';
    protected $fillable = [
        'factura_id', 'cfdi_id', 'fecha_peticion', 'fecha_cancelado', 'codigo_cancelacion',
        'mensaje_cancelacion', 'estado', 'es_cancelable', 'estatus_cancelacion',
        'folio_relacionado', 'timbrefiscaldigitalUUID_relacionado', 'satcat_tipo_relacion_clave',
    ];
    protected $casts = ['fecha_peticion' => 'datetime', 'fecha_cancelado' => 'datetime'];

    public function factura() { return $this->belongsTo(Factura::class, 'factura_id'); }
    public function cfdi() { return $this->belongsTo(CFDI::class, 'cfdi_id'); }
    public function tipoRelacion() { return $this->belongsTo(SatcatTipoRelacion::class, 'satcat_tipo_relacion_clave', 'clave'); }
}