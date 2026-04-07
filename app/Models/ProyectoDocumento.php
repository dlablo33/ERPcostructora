<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoDocumento extends Model
{
    protected $table = 'proyecto_documentos';
    
    protected $fillable = [
        'proyecto_id',
        'tipo',
        'nombre_original',
        'ruta',
        'mime_type',
        'tamaño'
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    // Accessor para URL pública
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->ruta);
    }
}