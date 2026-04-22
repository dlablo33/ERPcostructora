<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequisicionMaterialDetalle extends Model
{
    use HasFactory;
    
    protected $table = 'requisicion_material_detalle';
    
    protected $fillable = [
        'requisicion_id',
        'articulo_id',
        'cantidad_solicitada',
        'cantidad_autorizada',
        'cantidad_surtida',
        'unidad_medida',
        'observacion'
    ];
    
    protected $casts = [
        'cantidad_solicitada' => 'decimal:3',
        'cantidad_autorizada' => 'decimal:3',
        'cantidad_surtida' => 'decimal:3'
    ];
    
    // Relaciones
    public function requisicion()
    {
        return $this->belongsTo(RequisicionMaterial::class, 'requisicion_id');
    }
    
    public function articulo()
    {
        return $this->belongsTo(Articulo::class);
    }
    
    // Accessors
    public function getPendienteAttribute()
    {
        return $this->cantidad_autorizada - $this->cantidad_surtida;
    }
    
    public function getEstaCompletoAttribute()
    {
        return $this->cantidad_surtida >= $this->cantidad_autorizada;
    }
    
    // Métodos
    public function surtir($cantidad)
    {
        $nuevaCantidad = $this->cantidad_surtida + $cantidad;
        
        if ($nuevaCantidad > $this->cantidad_autorizada) {
            throw new \Exception('La cantidad a surtir excede lo autorizado');
        }
        
        $this->cantidad_surtida = $nuevaCantidad;
        $this->save();
        
        return true;
    }
}