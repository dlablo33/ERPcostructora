<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;

class CatMoneda extends Model
{
    protected $table = 'monedas';
    protected $fillable = ['codigo', 'nombre', 'simbolo', 'activa'];
    protected $casts = ['activa' => 'boolean'];

    public function facturas() { return $this->hasMany(Factura::class, 'cat_monedas_clave', 'codigo'); }
}