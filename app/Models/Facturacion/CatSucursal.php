<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatSucursal extends Model
{
    use SoftDeletes;

    protected $table = 'cat_sucursales';
    protected $primaryKey = 'cat_sucursal_id';
    protected $fillable = ['nombre', 'codigo', 'calle', 'num_exterior', 'num_interior', 'colonia', 'codigo_postal', 'municipio', 'estado', 'pais', 'email', 'telefono', 'datos_generales_id', 'estatus'];
    protected $casts = ['estatus' => 'boolean'];

    public function datosGenerales() { return $this->belongsTo(DatosGenerales::class, 'datos_generales_id'); }
    public function facturas() { return $this->hasMany(Factura::class, 'cat_sucursal_id'); }
}