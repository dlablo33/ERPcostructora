<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventarioAlmacenProyecto extends Model
{
    use HasFactory;
    
    protected $table = 'inventario_almacen_proyecto';
    
    protected $fillable = [
        'inventario_proyecto_id',
        'almacen_id',
        'cantidad',
        'ubicacion_especifica',
        'lote',
        'fecha_caducidad',
        'observaciones'
    ];
    
    protected $casts = [
        'cantidad' => 'decimal:3',
        'fecha_caducidad' => 'date'
    ];
    
    // Relaciones
    public function inventarioProyecto()
    {
        return $this->belongsTo(InventarioProyecto::class, 'inventario_proyecto_id');
    }
    
    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }
    
    // Scopes
    public function scopePorLote($query, $lote)
    {
        return $query->where('lote', $lote);
    }
    
    public function scopeNoCaducados($query)
    {
        return $query->where(function($q) {
            $q->whereNull('fecha_caducidad')
              ->orWhere('fecha_caducidad', '>', now());
        });
    }
}