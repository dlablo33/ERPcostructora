<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatArea extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cat_areas';
    protected $primaryKey = 'cat_area_id';

    protected $fillable = [
        'area',
        'descripcion',
        'activo',
        'borrado_logico'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'borrado_logico' => 'boolean'
    ];

    public function puestos()
    {
        return $this->hasMany(CatPuesto::class, 'cat_area_id');
    }

    public function plantillas()
    {
        return $this->hasMany(Plantilla::class, 'cat_area_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true)->where('borrado_logico', false);
    }

    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where('area', 'ILIKE', "%{$termino}%")
                         ->orWhere('descripcion', 'ILIKE', "%{$termino}%");
        }
        return $query;
    }
}