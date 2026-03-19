<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatcatFiguraTransporte extends Model
{
    use HasFactory;

    protected $table = 'satcat_figuras_transporte';
    protected $primaryKey = 'satcat_figura_transporte_id';

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
        return $this->hasMany(Plantilla::class, 'satcat_figura_transporte_clave', 'clave');
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