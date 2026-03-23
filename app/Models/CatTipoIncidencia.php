<?php
// app/Models/CatTipoIncidencia.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatTipoIncidencia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cat_tipos_incidencias';
    protected $primaryKey = 'cat_tipo_incidencia_id';

    protected $fillable = [
        'nombre',
        'descripcion',
        'clave_sat',
        'afecta_nomina',
        'requiere_autorizacion',
        'activo',
        'borrado_logico'
    ];

    protected $casts = [
        'afecta_nomina' => 'boolean',
        'requiere_autorizacion' => 'boolean',
        'activo' => 'boolean',
        'borrado_logico' => 'boolean'
    ];

    // Relación con incidencias
    public function incidencias()
    {
        return $this->hasMany(Incidencia::class, 'cat_tipo_incidencia_id');
    }

    // Scope para activos
    public function scopeActivos($query)
    {
        return $query->where('activo', true)->where('borrado_logico', false);
    }
}