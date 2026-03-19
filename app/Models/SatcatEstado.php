<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatcatEstado extends Model
{
    use HasFactory;

    protected $table = 'satcat_estados';
    protected $primaryKey = 'satcat_estado_id';

    protected $fillable = [
        'clave',
        'clave_satcat_paises',
        'descripcion',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    public function pais()
    {
        return $this->belongsTo(SatcatPais::class, 'clave_satcat_paises', 'clave');
    }

    public function municipios()
    {
        return $this->hasMany(SatcatMunicipio::class, 'clave_satcat_estados', 'clave');
    }

    public function plantillas()
    {
        return $this->hasMany(Plantilla::class, 'satcat_estados_clave', 'clave');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeDelPais($query, $paisClave)
    {
        return $query->where('clave_satcat_paises', $paisClave);
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