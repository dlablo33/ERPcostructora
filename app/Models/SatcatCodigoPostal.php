<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatcatCodigoPostal extends Model
{
    use HasFactory;

    protected $table = 'satcat_codigos_postales';
    protected $primaryKey = 'satcat_codigo_postal_id';

    protected $fillable = [
        'codigo_postal',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    public function colonias()
    {
        return $this->hasMany(SatcatColonia::class, 'satcat_codigos_postales_codigo_postal', 'codigo_postal');
    }

    public function plantillas()
    {
        return $this->hasMany(Plantilla::class, 'satcat_codigos_postales_codigo_postal', 'codigo_postal');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where('codigo_postal', 'ILIKE', "%{$termino}%");
        }
        return $query;
    }
}