<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatEstatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cat_estatus';
    protected $primaryKey = 'cat_estatus_id';

    protected $fillable = [
        'estatus',
        'clave',
        'tipo',
        'color',
        'orden',
        'activo',
        'borrado_logico'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'borrado_logico' => 'boolean',
        'orden' => 'integer'
    ];

    public function plantillas()
    {
        return $this->hasMany(Plantilla::class, 'estatus', 'clave');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true)->where('borrado_logico', false);
    }

    public function scopeDelTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where('estatus', 'ILIKE', "%{$termino}%")
                         ->orWhere('clave', 'ILIKE', "%{$termino}%");
        }
        return $query;
    }
}