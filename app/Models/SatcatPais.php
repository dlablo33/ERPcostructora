<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatcatPais extends Model
{
    use HasFactory;

    protected $table = 'satcat_paises';
    protected $primaryKey = 'satcat_pais_id';

    protected $fillable = [
        'clave',
        'descripcion',
        'nacionalidad',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    public function estados()
    {
        return $this->hasMany(SatcatEstado::class, 'clave_satcat_paises', 'clave');
    }

    public function plantillas()
    {
        return $this->hasMany(Plantilla::class, 'satcat_paises_clave', 'clave');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
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