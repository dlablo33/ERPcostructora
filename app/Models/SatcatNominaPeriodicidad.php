<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatcatNominaPeriodicidad extends Model
{
    use HasFactory;

    protected $table = 'satcat_nomina_periodicidades';
    protected $primaryKey = 'satcat_nomina_periodicidad_id';

    protected $fillable = [
        'clave',
        'descripcion',
        'dias',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'dias' => 'integer'
    ];

    public function plantillas()
    {
        return $this->hasMany(Plantilla::class, 'satcat_nomina_periodicidades_clave', 'clave');
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