<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatcatNominaRegimen extends Model
{
    use HasFactory;

    protected $table = 'satcat_nomina_regimenes';
    protected $primaryKey = 'satcat_nomina_regimen_id';

    protected $fillable = [
        'clave',
        'descripcion',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    public function plantillas()
    {
        return $this->hasMany(Plantilla::class, 'satcat_nomina_regimenes_clave', 'clave');
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