<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatUnidadNegocio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cat_unidades_negocio';
    protected $primaryKey = 'cat_unidad_negocio_id';

    protected $fillable = [
        'descripcion',
        'clave',
        'activo',
        'borrado_logico'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'borrado_logico' => 'boolean'
    ];

    public function unidades()
    {
        return $this->hasMany(Unidad::class, 'cat_unidad_negocio_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true)->where('borrado_logico', false);
    }

    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where('descripcion', 'ILIKE', "%{$termino}%")
                         ->orWhere('clave', 'ILIKE', "%{$termino}%");
        }
        return $query;
    }
}