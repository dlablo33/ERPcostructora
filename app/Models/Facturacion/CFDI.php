<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;

class CFDI extends Model
{
    protected $table = 'cfdi';
    protected $primaryKey = 'cfdi_id';
    protected $fillable = [
        'factura_id', 'timbrefiscaldigitalUUID', 'timbrefiscaldigitalFechaTimbrado',
        'timbrefiscaldigitalSelloCFD', 'timbrefiscaldigitalSelloSAT', 'timbrefiscaldigitalNoCertificadoSAT',
        'comprobanteSerie', 'comprobanteFolio', 'comprobanteFecha', 'comprobanteMoneda',
        'comprobanteTipoCambio', 'comprobanteSubTotal', 'comprobanteTotal', 'comprobanteTipoDeComprobante',
        'comprobanteMetodoPago', 'comprobanteFormaPago', 'comprobanteNoCertificado', 'comprobanteSello',
        'emisorRfc', 'receptorRfc', 'cadena_original',
    ];

    protected $casts = [
        'timbrefiscaldigitalFechaTimbrado' => 'datetime', 'comprobanteFecha' => 'date',
        'comprobanteTipoCambio' => 'decimal:6', 'comprobanteSubTotal' => 'decimal:2', 'comprobanteTotal' => 'decimal:2',
    ];

    public function factura() { return $this->belongsTo(Factura::class, 'factura_id'); }
    public function relacionados() { return $this->hasMany(CFDIRelacionado::class, 'cfdi_id'); }
}