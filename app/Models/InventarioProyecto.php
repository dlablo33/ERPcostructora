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
        'estatus',
        'costo_promedio',
        'ultimo_costo',
        'ultimo_costo_compra'
    ];
    
    protected $casts = [
        'cantidad_actual' => 'decimal:3',
        'cantidad_reservada' => 'decimal:3',
        'cantidad_minima' => 'decimal:3',
        'cantidad_maxima' => 'decimal:3',
        'punto_reorden' => 'decimal:3',
        'costo_promedio' => 'decimal:2',
        'ultimo_costo' => 'decimal:2',
        'ultimo_costo_compra' => 'decimal:2',
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
    
    public function getValorInventarioAttribute()
    {
        if (!$this->costo_promedio && !$this->ultimo_costo) return 0;
        $costo = $this->costo_promedio ?? $this->ultimo_costo ?? 0;
        return $this->cantidad_actual * $costo;
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
    
    /**
     * Agregar stock al inventario (ENTRADA)
     */
    public function agregarStock($cantidad, $almacenId, $observaciones = null, $referenciaTipo = null, $referenciaId = null, $costoUnitario = null)
    {
        $cantidadAnterior = $this->cantidad_actual;
        
        // ACTUALIZAR COSTOS si se proporciona costo unitario
        if ($costoUnitario && $costoUnitario > 0) {
            // Guardar último costo
            $this->ultimo_costo = $costoUnitario;
            
            // Si es una compra, guardar también en último costo de compra
            if ($referenciaTipo === 'Compra') {
                $this->ultimo_costo_compra = $costoUnitario;
            }
            
            // Calcular costo promedio ponderado
            if ($this->cantidad_actual > 0 && $this->costo_promedio && $this->costo_promedio > 0) {
                $importeActual = $this->cantidad_actual * $this->costo_promedio;
                $importeNuevo = $cantidad * $costoUnitario;
                $cantidadTotal = $this->cantidad_actual + $cantidad;
                $this->costo_promedio = ($importeActual + $importeNuevo) / $cantidadTotal;
            } else {
                $this->costo_promedio = $costoUnitario;
            }
        }
        
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
        
        // Registrar movimiento con costo
        MovimientoInventario::create([
            'inventario_proyecto_id' => $this->id,
            'almacen_destino_id' => $almacenId,
            'tipo_movimiento' => 'Entrada',
            'cantidad' => $cantidad,
            'costo_unitario' => $costoUnitario,
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
    
    /**
     * Retirar stock del inventario (SALIDA)
     */
    public function retirarStock($cantidad, $almacenId, $observaciones = null, $referenciaTipo = null, $referenciaId = null)
    {
        if ($this->disponible < $cantidad) {
            throw new \Exception('Stock insuficiente. Disponible: ' . $this->disponible . ', solicitado: ' . $cantidad);
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
        
        // Registrar movimiento (usar el costo promedio al momento de la salida)
        $costoSalida = $this->costo_promedio ?? $this->ultimo_costo ?? 0;
        
        MovimientoInventario::create([
            'inventario_proyecto_id' => $this->id,
            'almacen_origen_id' => $almacenId,
            'tipo_movimiento' => 'Salida',
            'cantidad' => $cantidad,
            'costo_unitario' => $costoSalida,
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
    
    /**
     * Actualizar costo promedio manualmente
     */
    public function actualizarCostoPromedio($nuevoCosto, $cantidadNueva = null)
    {
        if (!$cantidadNueva) {
            $cantidadNueva = $this->cantidad_actual;
        }
        
        if ($this->cantidad_actual > 0 && $this->costo_promedio && $this->costo_promedio > 0) {
            $importeActual = $this->cantidad_actual * $this->costo_promedio;
            $importeNuevo = $cantidadNueva * $nuevoCosto;
            $cantidadTotal = $this->cantidad_actual + $cantidadNueva;
            $this->costo_promedio = ($importeActual + $importeNuevo) / $cantidadTotal;
        } else {
            $this->costo_promedio = $nuevoCosto;
        }
        
        $this->ultimo_costo = $nuevoCosto;
        $this->save();
        
        return $this->costo_promedio;
    }
}