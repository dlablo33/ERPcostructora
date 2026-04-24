<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CotizacionDetalle extends Model
{
    use HasFactory;
    
    protected $table = 'cotizacion_detalles';
    
    protected $fillable = [
        'cotizacion_id',
        'articulo_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'impuestos',
        'total',
        'observacion'
    ];
    
    protected $casts = [
        'cantidad' => 'decimal:3',
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'impuestos' => 'decimal:2',
        'total' => 'decimal:2'
    ];
    
    // Relaciones
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }
    
    public function articulo()
    {
        return $this->belongsTo(Articulo::class);
    }
}