<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CotizacionArticulo extends Model
{
    use HasFactory;
    
    protected $table = 'cotizaciones_articulos';
    
    protected $fillable = [
        'requisicion_articulo_id',
        'proveedor_id',
        'precio_unitario',
        'tiempo_entrega_dias',
        'condiciones_pago',
        'observaciones',
        'estatus',
        'creado_por'
    ];
    
    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'tiempo_entrega_dias' => 'integer'
    ];
    
    // Relaciones
    public function requisicionArticulo()
    {
        return $this->belongsTo(RequisicionArticulo::class);
    }
    
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
    
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
    
    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estatus', 'Pendiente');
    }
    
    public function scopeSeleccionadas($query)
    {
        return $query->where('estatus', 'Seleccionada');
    }
    
    public function scopeRechazadas($query)
    {
        return $query->where('estatus', 'Rechazada');
    }
    
    // Helper para calcular total
    public function getTotalAttribute()
    {
        return $this->precio_unitario * $this->requisicionArticulo->cantidad;
    }
}