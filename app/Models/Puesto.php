<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Puesto extends Model
{
    use SoftDeletes;

    protected $table = 'puestos';

    protected $fillable = [
        
        'folio',
        'nombre',
        'descripcion',
        'area_id',
        'estatus'
    ];

    protected $casts = [
        'estatus' => 'string'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('estatus', 'Activo');
    }

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