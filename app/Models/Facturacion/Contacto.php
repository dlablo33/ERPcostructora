<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contacto extends Model
{
    use SoftDeletes;

    protected $table = 'contactos';
    protected $primaryKey = 'contacto_id';
    protected $fillable = [
        'razon_social', 'rfc', 'nombre_comercial', 'email_facturacion', 'telefono',
        'satcat_regimen_fiscal_clave', 'satcat_uso_cfdi_clave', 'satcat_formas_pago_clave',
        'satcat_metodos_pago_clave', 'calle', 'num_exterior', 'num_interior', 'colonia',
        'codigo_postal', 'municipio', 'estado', 'pais', 'tipo', 'dias_credito', 'limite_credito', 'estatus',
    ];

    protected $casts = ['estatus' => 'boolean', 'dias_credito' => 'integer', 'limite_credito' => 'decimal:2'];

    public function regimenFiscal() { return $this->belongsTo(SatcatRegimenFiscal::class, 'satcat_regimen_fiscal_clave', 'clave'); }
    public function usoCfdi() { return $this->belongsTo(SatcatUsoCfdi::class, 'satcat_uso_cfdi_clave', 'clave'); }
    public function formaPago() { return $this->belongsTo(SatcatFormaPago::class, 'satcat_formas_pago_clave', 'clave'); }
    public function metodoPago() { return $this->belongsTo(SatcatMetodoPago::class, 'satcat_metodos_pago_clave', 'clave'); }
    public function facturas() { return $this->hasMany(Factura::class, 'contacto_id'); }

    // En app/Models/Facturacion/Contacto.php
// Agregar esta relación

public function contrarecibos()
{
    return $this->hasMany(Contrarecibo::class, 'contacto_id', 'contacto_id');
}
}