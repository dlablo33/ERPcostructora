<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatcatMunicipio extends Model
{
    use HasFactory;

    protected $table = 'satcat_municipios';
    protected $primaryKey = 'satcat_municipio_id';

    protected $fillable = [
        'clave',
        'clave_satcat_estados',
        'descripcion',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    public function estado()
    {
        return $this->belongsTo(SatcatEstado::class, 'clave_satcat_estados', 'clave');
    }

    public function localidades()
    {
        return $this->hasMany(SatcatLocalidad::class, 'satcat_estados_clave', 'clave_satcat_estados')
                    ->where('satcat_municipios_clave', $this->clave);
    }

    public function plantillas()
    {
        return $this->hasMany(Plantilla::class, 'satcat_municipios_clave', 'clave');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeDelEstado($query, $estadoClave)
    {
        return $query->where('clave_satcat_estados', $estadoClave);
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