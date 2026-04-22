<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MovimientoInventario extends Model
{
    use HasFactory;
    
    protected $table = 'movimientos_inventario';
    
    protected $fillable = [
        'inventario_proyecto_id',
        'almacen_origen_id',
        'almacen_destino_id',
        'tipo_movimiento',
        'cantidad',
        'cantidad_antes',
        'cantidad_despues',
        'referencia_tipo',
        'referencia_id',
        'referencia_folio',
        'proveedor_id',
        'solicitante',
        'autorizado_por',
        'motivo',
        'observaciones',
        'fecha_movimiento',
        'creado_por'
    ];
    
    protected $casts = [
        'cantidad' => 'decimal:3',
        'cantidad_antes' => 'decimal:3',
        'cantidad_despues' => 'decimal:3',
        'fecha_movimiento' => 'datetime'
    ];
    
    // Relaciones
    public function inventarioProyecto()
    {
        return $this->belongsTo(InventarioProyecto::class, 'inventario_proyecto_id');
    }
    
    public function almacenOrigen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_origen_id');
    }
    
    public function almacenDestino()
    {
        return $this->belongsTo(Almacen::class, 'almacen_destino_id');
    }
    
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
    
    public function autorizador()
    {
        return $this->belongsTo(User::class, 'autorizado_por');
    }
    
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
    
    // Scopes
    public function scopeEntradas($query)
    {
        return $query->where('tipo_movimiento', 'Entrada');
    }
    
    public function scopeSalidas($query)
    {
        return $query->where('tipo_movimiento', 'Salida');
    }
    
    public function scopePorFecha($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_movimiento', [$fechaInicio, $fechaFin]);
    }
}