<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequisicionArticulo extends Model
{
    protected $table = 'requisicion_articulos';
    
    protected $fillable = [
        'requisicion_id',
        'codigo',
        'cantidad',
        'unidad_medida',
        'descripcion',
        'observacion',
        'pendiente',
        'cantidad_surtida'
    ];
    
    protected $casts = [
        'cantidad' => 'decimal:3',
        'cantidad_surtida' => 'decimal:3',
        'pendiente' => 'boolean',
    ];
    
    // Relaciones
    public function requisicion()
    {
        return $this->belongsTo(Requisicion::class);
    }
    
    // Accesors
    public function getPendienteSurtirAttribute()
    {
        return max(0, $this->cantidad - $this->cantidad_surtida);
    }
    
    public function getEstaCompletoAttribute()
    {
        return $this->cantidad_surtida >= $this->cantidad;
    }
}