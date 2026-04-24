<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cotizacion extends Model
{
    use HasFactory;
    
    protected $table = 'cotizaciones';
    
    protected $fillable = [
        'requisicion_id',
        'proveedor_id',
        'folio',
        'fecha_cotizacion',
        'tiempo_entrega_dias',
        'condiciones_pago',
        'subtotal',
        'impuestos',
        'total',
        'archivo_pdf',
        'observaciones',
        'estatus',
        'creado_por'
    ];
    
    protected $casts = [
        'fecha_cotizacion' => 'date',
        'subtotal' => 'decimal:2',
        'impuestos' => 'decimal:2',
        'total' => 'decimal:2',
        'tiempo_entrega_dias' => 'integer'
    ];
    
    // Relaciones
    public function requisicion()
    {
        return $this->belongsTo(Requisicion::class);
    }
    
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
    
    public function detalles()
    {
        return $this->hasMany(CotizacionDetalle::class);
    }
    
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
    
    // Scopes
    public function scopeSeleccionada($query)
    {
        return $query->where('estatus', 'Seleccionada');
    }
    
    public function scopePendientes($query)
    {
        return $query->where('estatus', 'Pendiente');
    }
    
    // Helper para calcular totales
    public function recalcularTotales()
    {
        $this->subtotal = $this->detalles->sum('subtotal');
        $this->impuestos = $this->detalles->sum('impuestos');
        $this->total = $this->detalles->sum('total');
        $this->save();
        
        return $this;
    }
}