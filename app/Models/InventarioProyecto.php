<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventarioProyecto extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'inventario_proyecto';
    
    protected $fillable = [
        'proyecto_id',
        'articulo_id',
        'cantidad_actual',
        'cantidad_reservada',
        'cantidad_minima',
        'cantidad_maxima',
        'punto_reorden',
        'unidad_medida',
        'ultima_entrada',
        'ultima_salida',
        'observaciones',
        'estatus'
    ];
    
    protected $casts = [
        'cantidad_actual' => 'decimal:3',
        'cantidad_reservada' => 'decimal:3',
        'cantidad_minima' => 'decimal:3',
        'cantidad_maxima' => 'decimal:3',
        'punto_reorden' => 'decimal:3',
        'ultima_entrada' => 'datetime',
        'ultima_salida' => 'datetime',
        'estatus' => 'string'
    ];
    
    // Relaciones
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
    
    public function articulo()
    {
        return $this->belongsTo(Articulo::class);
    }
    
    public function ubicaciones()
    {
        return $this->hasMany(InventarioAlmacenProyecto::class, 'inventario_proyecto_id');
    }
    
    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class, 'inventario_proyecto_id');
    }
    
    // Accessors
    public function getDisponibleAttribute()
    {
        return $this->cantidad_actual - $this->cantidad_reservada;
    }
    
    public function getEstaBajoStockAttribute()
    {
        return $this->disponible <= $this->punto_reorden;
    }
    
    public function getPorcentajeStockAttribute()
    {
        if ($this->cantidad_maxima <= 0) return 0;
        return round(($this->cantidad_actual / $this->cantidad_maxima) * 100, 2);
    }
    
    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estatus', 'Activo');
    }
    
    public function scopeBajoStock($query)
    {
        return $query->whereRaw('(cantidad_actual - cantidad_reservada) <= punto_reorden');
    }
    
    // Métodos
    public function agregarStock($cantidad, $almacenId, $observaciones = null, $referenciaTipo = null, $referenciaId = null)
    {
        $cantidadAnterior = $this->cantidad_actual;
        
        // Actualizar stock principal
        $this->cantidad_actual += $cantidad;
        $this->ultima_entrada = now();
        $this->save();
        
        // Actualizar o crear ubicación en almacén
        $ubicacion = InventarioAlmacenProyecto::where('inventario_proyecto_id', $this->id)
            ->where('almacen_id', $almacenId)
            ->first();
        
        if ($ubicacion) {
            $ubicacion->cantidad += $cantidad;
            $ubicacion->save();
        } else {
            InventarioAlmacenProyecto::create([
                'inventario_proyecto_id' => $this->id,
                'almacen_id' => $almacenId,
                'cantidad' => $cantidad
            ]);
        }
        
        // Registrar movimiento
        MovimientoInventario::create([
            'inventario_proyecto_id' => $this->id,
            'almacen_destino_id' => $almacenId,
            'tipo_movimiento' => 'Entrada',
            'cantidad' => $cantidad,
            'cantidad_antes' => $cantidadAnterior,
            'cantidad_despues' => $this->cantidad_actual,
            'referencia_tipo' => $referenciaTipo,
            'referencia_id' => $referenciaId,
            'observaciones' => $observaciones,
            'fecha_movimiento' => now(),
            'creado_por' => auth()->id()
        ]);
        
        return true;
    }
    
    public function retirarStock($cantidad, $almacenId, $observaciones = null, $referenciaTipo = null, $referenciaId = null)
    {
        if ($this->disponible < $cantidad) {
            throw new \Exception('Stock insuficiente');
        }
        
        $cantidadAnterior = $this->cantidad_actual;
        
        // Actualizar stock principal
        $this->cantidad_actual -= $cantidad;
        $this->ultima_salida = now();
        $this->save();
        
        // Actualizar ubicación en almacén
        $ubicacion = InventarioAlmacenProyecto::where('inventario_proyecto_id', $this->id)
            ->where('almacen_id', $almacenId)
            ->first();
        
        if ($ubicacion) {
            $ubicacion->cantidad -= $cantidad;
            $ubicacion->save();
        }
        
        // Registrar movimiento
        MovimientoInventario::create([
            'inventario_proyecto_id' => $this->id,
            'almacen_origen_id' => $almacenId,
            'tipo_movimiento' => 'Salida',
            'cantidad' => $cantidad,
            'cantidad_antes' => $cantidadAnterior,
            'cantidad_despues' => $this->cantidad_actual,
            'referencia_tipo' => $referenciaTipo,
            'referencia_id' => $referenciaId,
            'observaciones' => $observaciones,
            'fecha_movimiento' => now(),
            'creado_por' => auth()->id()
        ]);
        
        return true;
    }
}