<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DatosGenerales extends Model
{
    use SoftDeletes;

    protected $table = 'datos_generales';
    protected $primaryKey = 'datos_generales_id';
    protected $fillable = [
        'razon_social', 'rfc', 'calle', 'num_exterior', 'num_interior', 'colonia',
        'codigo_postal', 'municipio', 'estado', 'pais', 'satcat_regimen_fiscal_clave',
        'logo_path', 'certificado_cer', 'certificado_key', 'certificado_password',
        'certificado_no_serie', 'activo',
    ];

    protected $casts = ['activo' => 'boolean'];

    public function series() { return $this->hasMany(CatSerie::class, 'datos_generales_id'); }
    public function sucursales() { return $this->hasMany(CatSucursal::class, 'datos_generales_id'); }
    public function regimenFiscal() { return $this->belongsTo(SatcatRegimenFiscal::class, 'satcat_regimen_fiscal_clave', 'clave'); }
}