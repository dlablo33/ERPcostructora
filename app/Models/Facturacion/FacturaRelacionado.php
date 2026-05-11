<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;

class FacturaRelacionado extends Model
{
    protected $table = 'factura_relacionado';
    protected $primaryKey = 'facturas_relacionado_id';
    protected $fillable = ['factura_id', 'relacion_factura_id', 'folio', 'timbrefiscaldigitalUUID', 'satcat_tipo_relacion_clave', 'borrado_logico'];
    protected $casts = ['borrado_logico' => 'boolean'];

    public function factura() { return $this->belongsTo(Factura::class, 'factura_id'); }
    public function facturaRelacionada() { return $this->belongsTo(Factura::class, 'relacion_factura_id'); }
    public function tipoRelacion() { return $this->belongsTo(SatcatTipoRelacion::class, 'satcat_tipo_relacion_clave', 'clave'); }
}