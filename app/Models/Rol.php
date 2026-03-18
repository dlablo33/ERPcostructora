<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    use SoftDeletes;

    protected $table = 'roles'; // Especificar el nombre de la tabla

    protected $fillable = [
        'folio',
        'nombre',
        'descripcion',
        'estatus'
    ];

    protected $casts = [
        'estatus' => 'string'
    ];

    // Scope para activos
    public function scopeActivos($query)
    {
        return $query->where('estatus', 'Activo');
    }

    // Scope para búsqueda
    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where('nombre', 'LIKE', "%{$termino}%")
                         ->orWhere('folio', 'LIKE', "%{$termino}%")
                         ->orWhere('descripcion', 'LIKE', "%{$termino}%");
        }
        return $query;
    }
}