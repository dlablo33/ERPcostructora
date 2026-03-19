<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatPuesto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cat_puestos';
    protected $primaryKey = 'cat_puesto_id';

    protected $fillable = [
        'puesto',
        'descripcion',
        'cat_area_id',
        'activo',
        'borrado_logico'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'borrado_logico' => 'boolean'
    ];

    public function area()
    {
        return $this->belongsTo(CatArea::class, 'cat_area_id');
    }

    public function plantillas()
    {
        return $this->hasMany(Plantilla::class, 'cat_puesto_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true)->where('borrado_logico', false);
    }

    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where('puesto', 'ILIKE', "%{$termino}%")
                         ->orWhere('descripcion', 'ILIKE', "%{$termino}%");
        }
        return $query;
    }
}