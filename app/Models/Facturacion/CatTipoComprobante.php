<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;

class CatTipoComprobante extends Model
{
    protected $table = 'cat_tipos_comprobante';
    protected $primaryKey = 'cat_tipo_comprobante_id';
    protected $fillable = ['clave', 'descripcion', 'activo'];
    protected $casts = ['activo' => 'boolean'];

    public function series() { return $this->hasMany(CatSerie::class, 'cat_tipo_comprobante', 'clave'); }
}