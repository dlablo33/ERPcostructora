<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requisicion extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'requisiciones';
    
    protected $fillable = [
        'folio',
        'fecha_requerimiento',
        'estatus',
        'solicitante',
        'area',
        'area_id',
        'proyecto_id',
        'cotizadas',
        'observaciones',
        'creado_por',
        'aprobado_por',
        'fecha_aprobacion',
        'motivo_rechazo',
        'estatus_cotizacion'
    ];
    
    protected $casts = [
        'fecha_requerimiento' => 'date',
        'fecha_aprobacion' => 'datetime',
    ];
    
    // Relación con área
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
    
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
    
    public function articulos()
    {
        return $this->hasMany(RequisicionArticulo::class);
    }
    
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
    
    public function aprobador()
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }
    
    // ========== RELACIONES PARA COTIZACIONES ==========
    
    /**
     * Todas las cotizaciones por artículo de esta requisición
     * (a través de los artículos)
     */
    public function cotizacionesArticulos()
    {
        return $this->hasManyThrough(
            CotizacionArticulo::class,
            RequisicionArticulo::class,
            'requisicion_id',
            'requisicion_articulo_id'
        );
    }
    
    // ========== MÉTODOS HELPERS ==========
    
    /**
     * Actualiza el estatus de cotización de la requisición
     * basado en el estado de cotización de sus artículos
     */
    public function actualizarEstatusCotizacion()
    {
        $totalArticulos = $this->articulos->count();
        $cotizados = $this->articulos->where('cotizada', true)->count();
        
        if ($totalArticulos == 0) {
            $this->estatus_cotizacion = 'Pendiente';
        } elseif ($cotizados == 0) {
            $this->estatus_cotizacion = 'Pendiente';
        } elseif ($cotizados < $totalArticulos) {
            $this->estatus_cotizacion = 'En_Cotizacion';
        } elseif ($cotizados == $totalArticulos) {
            // CAMBIADO: Ya no se auto-autoriza, solo queda en "En_Cotizacion"
            // El usuario debe autorizar manualmente
            $this->estatus_cotizacion = 'En_Cotizacion';
        }
        
        $this->save();
        
        return $this->estatus_cotizacion;
    }
    
    /**
     * Autoriza manualmente la requisición (todas las cotizaciones seleccionadas)
     */
    public function autorizarCotizaciones()
    {
        // Verificar que todos los artículos tengan una cotización seleccionada
        $todosSeleccionados = $this->articulos->every(function($articulo) {
            return $articulo->tieneCotizacionSeleccionada();
        });
        
        if ($todosSeleccionados) {
            $this->estatus_cotizacion = 'Cotizada';
            $this->save();
            return true;
        }
        
        return false;
    }
    
    /**
     * Verifica si todos los artículos ya están cotizados
     */
    public function todosArticulosCotizados()
    {
        return $this->articulos->where('cotizada', false)->count() == 0;
    }
    
    /**
     * Verifica si al menos un artículo tiene cotizaciones
     */
    public function tieneCotizaciones()
    {
        return $this->articulos->contains(function($articulo) {
            return $articulo->tieneCotizacion();
        });
    }
    
    /**
     * Verifica si la requisición tiene una cotización seleccionada por artículo
     * (todos los artículos tienen cotización seleccionada)
     */
    public function tieneTodasCotizacionesSeleccionadas()
    {
        return $this->articulos->every(function($articulo) {
            return $articulo->tieneCotizacionSeleccionada();
        });
    }
    
    /**
     * Obtiene el resumen de cotizaciones por artículo
     */
    public function getResumenCotizacionesAttribute()
    {
        $total = $this->articulos->count();
        $cotizadas = $this->articulos->where('cotizada', true)->count();
        
        return [
            'total_articulos' => $total,
            'cotizados' => $cotizadas,
            'pendientes' => $total - $cotizadas,
            'porcentaje' => $total > 0 ? round(($cotizadas / $total) * 100, 2) : 0
        ];
    }
}