<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatTipoOperador extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cat_tipos_operador';
    protected $primaryKey = 'cat_tipo_operador_id';

    protected $fillable = [
        'tipo_operador',
        'descripcion',
        'activo',
        'borrado_logico'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'borrado_logico' => 'boolean'
    ];

    public function plantillas()
    {
        return $this->hasMany(Plantilla::class, 'cat_tipo_operador_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true)->where('borrado_logico', false);
    }

    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where('tipo_operador', 'ILIKE', "%{$termino}%")
                         ->orWhere('descripcion', 'ILIKE', "%{$termino}%");
        }
        return $query;
    }
}