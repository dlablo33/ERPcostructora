<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;

    protected $table = 'areas';
    
    protected $fillable = [
        'folio',
        'nombre',
        'descripcion',
        'cuenta_contable'
    ];

    // Scope para búsqueda
    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where('nombre', 'LIKE', "%{$termino}%")
                         ->orWhere('folio', 'LIKE', "%{$termino}%")
                         ->orWhere('descripcion', 'LIKE', "%{$termino}%")
                         ->orWhere('cuenta_contable', 'LIKE', "%{$termino}%");
        }
        return $query;
    }
}