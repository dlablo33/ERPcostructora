<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatcatColonia extends Model
{
    use HasFactory;

    protected $table = 'satcat_colonias';
    protected $primaryKey = 'satcat_colonia_id';

    protected $fillable = [
        'clave',
        'satcat_codigos_postales_codigo_postal',
        'descripcion',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    public function codigoPostal()
    {
        return $this->belongsTo(SatcatCodigoPostal::class, 'satcat_codigos_postales_codigo_postal', 'codigo_postal');
    }

    public function plantillas()
    {
        return $this->hasMany(Plantilla::class, 'satcat_colonias_clave', 'clave');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeDelCodigoPostal($query, $cp)
    {
        return $query->where('satcat_codigos_postales_codigo_postal', $cp);
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