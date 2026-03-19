<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatBanco extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cat_bancos';
    protected $primaryKey = 'cat_banco_id';

    protected $fillable = [
        'clave',
        'descripcion',
        'nombre_corto',
        'rfc',
        'activo',
        'borrado_logico'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'borrado_logico' => 'boolean'
    ];

    public function plantillas()
    {
        return $this->hasMany(Plantilla::class, 'cat_bancos_clave', 'clave');
    }

    public function plantillasTiposCuentas()
    {
        return $this->hasMany(PlantillaTipoCuenta::class, 'cat_banco_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true)->where('borrado_logico', false);
    }

    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where('descripcion', 'ILIKE', "%{$termino}%")
                         ->orWhere('nombre_corto', 'ILIKE', "%{$termino}%")
                         ->orWhere('clave', 'ILIKE', "%{$termino}%");
        }
        return $query;
    }
}