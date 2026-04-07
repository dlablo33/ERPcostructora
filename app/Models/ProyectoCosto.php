<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoCosto extends Model
{
    protected $table = 'proyecto_costos';
    
    protected $fillable = [
        'proyecto_id',
        'materiales',
        'mano_obra',
        'maquinaria',
        'gastos_indirectos'
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function getTotalAttribute()
    {
        return $this->materiales + $this->mano_obra + $this->maquinaria + $this->gastos_indirectos;
    }
}