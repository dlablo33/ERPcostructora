<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class RequisicionArticulo extends Model
{
    use HasFactory;
    
    protected $table = 'requisicion_articulos';
    
    protected $fillable = [
        'requisicion_id',
        'codigo',
        'cantidad',
        'unidad_medida',
        'descripcion',
        'observacion',
        'pendiente',
        'cantidad_surtida',
        // Nuevos campos para cotizaciones
        'cotizacion_seleccionada_id',
        'proveedor_seleccionado_id',
        'precio_unitario_seleccionado',
        'tiempo_entrega_seleccionado',
        'condiciones_pago_seleccionado',
        'cotizada'
    ];
    
    protected $casts = [
        'cantidad' => 'decimal:3',
        'cantidad_surtida' => 'decimal:3',
        'precio_unitario_seleccionado' => 'decimal:2',
        'tiempo_entrega_seleccionado' => 'integer',
        'pendiente' => 'boolean',
        'cotizada' => 'boolean'
    ];
    
    // Relaciones originales
    public function requisicion()
    {
        return $this->belongsTo(Requisicion::class);
    }
    
    // ========== NUEVAS RELACIONES PARA COTIZACIONES ==========
    
    /**
     * Todas las cotizaciones de este artículo
     */
    public function cotizaciones()
    {
        return $this->hasMany(CotizacionArticulo::class);
    }
    
    /**
     * La cotización seleccionada (ganadora) para este artículo
     */
    public function cotizacionSeleccionada()
    {
        return $this->belongsTo(CotizacionArticulo::class, 'cotizacion_seleccionada_id');
    }
    
    /**
     * El proveedor seleccionado para este artículo
     */
    public function proveedorSeleccionado()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_seleccionado_id');
    }
    
    // ========== MÉTODOS HELPERS ==========
    
    /**
     * Verifica si el artículo tiene al menos una cotización
     */
    public function tieneCotizacion()
    {
        return $this->cotizaciones()->exists();
    }
    
    /**
     * Verifica si el artículo ya tiene una cotización seleccionada
     */
    public function tieneCotizacionSeleccionada()
    {
        return !is_null($this->cotizacion_seleccionada_id);
    }
    
    /**
     * Obtiene la mejor cotización (menor precio unitario)
     */
    public function mejorCotizacion()
    {
        return $this->cotizaciones()
            ->where('estatus', 'Pendiente')
            ->orderBy('precio_unitario', 'asc')
            ->first();
    }
    
    /**
     * Selecciona una cotización como ganadora
     */
    public function seleccionarCotizacion($cotizacionId)
    {
        $cotizacion = CotizacionArticulo::find($cotizacionId);
        
        if (!$cotizacion || $cotizacion->requisicion_articulo_id != $this->id) {
            return false;
        }
        
        // Marcar todas las demás como Rechazadas
        $this->cotizaciones()
            ->where('id', '!=', $cotizacionId)
            ->update(['estatus' => 'Rechazada']);
        
        // Marcar esta como Seleccionada
        $cotizacion->update(['estatus' => 'Seleccionada']);
        
        // Actualizar el artículo de requisición
        $this->update([
            'cotizacion_seleccionada_id' => $cotizacionId,
            'proveedor_seleccionado_id' => $cotizacion->proveedor_id,
            'precio_unitario_seleccionado' => $cotizacion->precio_unitario,
            'tiempo_entrega_seleccionado' => $cotizacion->tiempo_entrega_dias,
            'condiciones_pago_seleccionado' => $cotizacion->condiciones_pago,
            'cotizada' => true
        ]);
        
        return true;
    }
}