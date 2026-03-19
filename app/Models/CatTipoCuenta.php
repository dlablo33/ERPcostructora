<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatTipoCuenta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cat_tipos_cuenta';
    protected $primaryKey = 'cat_tipo_cuenta_id';

    protected $fillable = [
        'descripcion',
        'clave_sat',
        'activo',
        'borrado_logico'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'borrado_logico' => 'boolean'
    ];

    public function plantillasTiposCuentas()
    {
        return $this->hasMany(PlantillaTipoCuenta::class, 'cat_tipo_cuenta_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true)->where('borrado_logico', false);
    }

    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where('descripcion', 'ILIKE', "%{$termino}%");
        }
        return $query;
    }
}