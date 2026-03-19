<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatcatLocalidad extends Model
{
    use HasFactory;

    protected $table = 'satcat_localidades';
    protected $primaryKey = 'satcat_localidad_id';

    protected $fillable = [
        'clave',
        'satcat_estados_clave',
        'descripcion',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    public function estado()
    {
        return $this->belongsTo(SatcatEstado::class, 'satcat_estados_clave', 'clave');
    }

    public function plantillas()
    {
        return $this->hasMany(Plantilla::class, 'satcat_localidades_clave', 'clave');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeDelEstado($query, $estadoClave)
    {
        return $query->where('satcat_estados_clave', $estadoClave);
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