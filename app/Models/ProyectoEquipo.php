<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoEquipo extends Model
{
    protected $table = 'proyecto_equipo';
    
    protected $fillable = [
        'proyecto_id',
        'nombre',
        'rol',
        'departamento',
        'dedicacion'
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }
}