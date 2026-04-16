<?php
// app/Models/EstimacionesPartida.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstimacionesPartida extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'estimaciones_partidas';
    
    protected $fillable = [
        'proyecto_id',
        'partida_id',
        'fecha',
        'periodo_inicio',
        'periodo_fin',
        'avance_porcentaje',
        'cantidad_ejecutada',
        'observaciones',
        'created_by'
    ];
    
    protected $casts = [
        'fecha' => 'date',
        'periodo_inicio' => 'date',
        'periodo_fin' => 'date',
        'avance_porcentaje' => 'decimal:2',
        'cantidad_ejecutada' => 'decimal:2',
    ];
    
    // ==========================================
    // RELACIONES
    // ==========================================
    
    /**
     * Relación con el proyecto
     */
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }
    
    /**
     * Relación con la partida presupuestal
     */
    public function partida()
    {
        return $this->belongsTo(ProyectoPartida::class, 'partida_id');
    }
    
    /**
     * Relación con el usuario que creó el registro
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    /**
     * Relación con movimientos bancarios (facturación/cobro)
     */
    public function movimientos()
    {
        return $this->hasMany(MovimientoBancario::class, 'estimacion_id');
    }
    
    // ==========================================
    // ATRIBUTOS CALCULADOS
    // ==========================================
    
    /**
     * Obtener la estimación anterior de esta misma partida
     */
    
    /**
     * Obtener el avance anterior (%)
     */
    
    
    /**
     * Obtener el avance del período (diferencia con estimación anterior)
     */
    
    
    /**
     * Obtener el monto devengado acumulado de esta partida
     */
    public function getMontoDevengadoAttribute()
    {
        return ($this->avance_porcentaje / 100) * $this->partida->importe;
    }
    
    /**
     * Obtener el monto devengado en este período (solo el avance de esta estimación)
     */
    
    /**
     * Obtener el monto facturado (movimientos bancarios asociados a esta estimación)
     */
    public function getMontoFacturadoAttribute()
    {
        return $this->movimientos()
            ->where('tipo', 'ingreso')
            ->where('status', 'aplicado')
            ->sum('monto');
    }
    
    /**
     * Obtener la cuenta por cobrar de esta estimación
     */
    public function getCuentaPorCobrarAttribute()
    {
        return $this->monto_devengado_periodo - $this->monto_facturado;
    }
    
    /**
     * Obtener el total pagado de esta estimación
     */
    public function getTotalPagadoAttribute()
    {
        return $this->movimientos()
            ->where('tipo', 'ingreso')
            ->where('status', 'aplicado')
            ->sum('monto');
    }
    
    /**
     * Obtener el porcentaje de cobro de la estimación
     */
    public function getPorcentajeCobroAttribute()
    {
        if ($this->monto_devengado_periodo <= 0) return 0;
        return round(($this->monto_facturado / $this->monto_devengado_periodo) * 100, 2);
    }
    
    // ==========================================
    // SCOPES
    // ==========================================
    
    /**
     * Scope para filtrar por proyecto
     */
    public function scopePorProyecto($query, $proyectoId)
    {
        if ($proyectoId) {
            return $query->where('proyecto_id', $proyectoId);
        }
        return $query;
    }
    
    /**
     * Scope para filtrar por rango de fechas
     */
    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        if ($fechaInicio) {
            $query->whereDate('fecha', '>=', $fechaInicio);
        }
        if ($fechaFin) {
            $query->whereDate('fecha', '<=', $fechaFin);
        }
        return $query;
    }
    
    /**
     * Scope para filtrar por período (año-mes)
     */
    public function scopePorPeriodo($query, $anio, $mes)
    {
        return $query->whereYear('fecha', $anio)->whereMonth('fecha', $mes);
    }
    
    /**
     * Scope para ordenar por fecha descendente
     */
    public function scopeRecientes($query)
    {
        return $query->orderBy('fecha', 'desc')->orderBy('id', 'desc');
    }
    
    // ==========================================
    // MÉTODOS ESTÁTICOS PARA REPORTES
    // ==========================================
    
    /**
     * Obtener resumen de estimaciones agrupado por proyecto y período
     * (Para la vista resumida)
     */
    public static function getResumenPorPeriodo($fechaInicio = null, $fechaFin = null, $proyectoId = null)
    {
        $query = self::with(['proyecto', 'partida'])
            ->entreFechas($fechaInicio, $fechaFin)
            ->porProyecto($proyectoId);
        
        $estimaciones = $query->get();
        
        $resumen = [];
        
        foreach ($estimaciones as $est) {
            $key = $est->proyecto_id . '_' . $est->fecha->format('Y-m');
            
            if (!isset($resumen[$key])) {
                $resumen[$key] = [
                    'proyecto_id' => $est->proyecto_id,
                    'proyecto_nombre' => $est->proyecto->nombre,
                    'periodo' => $est->fecha->format('F Y'),
                    'anio' => $est->fecha->format('Y'),
                    'mes' => $est->fecha->format('m'),
                    'fecha_emision' => $est->fecha,
                    'estimaciones_count' => 0,
                    'monto_total_devengado' => 0,
                    'monto_total_facturado' => 0,
                    'cuenta_por_cobrar' => 0,
                    'partidas' => []
                ];
            }
            
            $resumen[$key]['estimaciones_count']++;
            $resumen[$key]['monto_total_devengado'] += $est->monto_devengado_periodo;
            $resumen[$key]['monto_total_facturado'] += $est->monto_facturado;
            $resumen[$key]['cuenta_por_cobrar'] += $est->cuenta_por_cobrar;
            $resumen[$key]['partidas'][] = $est;
        }
        
        // Calcular porcentaje de cobro
        foreach ($resumen as $key => $value) {
            if ($value['monto_total_devengado'] > 0) {
                $resumen[$key]['porcentaje_cobro'] = round(($value['monto_total_facturado'] / $value['monto_total_devengado']) * 100, 2);
            } else {
                $resumen[$key]['porcentaje_cobro'] = 0;
            }
        }
        
        return array_values($resumen);
    }
    
    /**
     * Obtener detalle de estimaciones por partida
     * (Para la vista detallada)
     */
    public static function getDetallePorPartida($proyectoId = null, $fechaInicio = null, $fechaFin = null)
    {
        $query = self::with(['proyecto', 'partida', 'movimientos'])
            ->entreFechas($fechaInicio, $fechaFin)
            ->porProyecto($proyectoId)
            ->recientes();
        
        $estimaciones = $query->get();
        
        return $estimaciones->map(function($est) {
            return [
                'id' => $est->id,
                'fecha' => $est->fecha,
                'proyecto' => $est->proyecto->nombre,
                'partida_codigo' => $est->partida->codigo,
                'partida_nombre' => $est->partida->nombre,
                'avance_porcentaje' => $est->avance_porcentaje,
                'avance_periodo' => $est->avance_periodo,
                'cantidad_ejecutada' => $est->cantidad_ejecutada,
                'monto_devengado' => $est->monto_devengado_periodo,
                'monto_facturado' => $est->monto_facturado,
                'cuenta_por_cobrar' => $est->cuenta_por_cobrar,
                'porcentaje_cobro' => $est->porcentaje_cobro,
                'observaciones' => $est->observaciones,
            ];
        });
    }
    
    /**
     * Calcular avance global del proyecto basado en estimaciones
     */
    public static function getAvanceGlobalProyecto($proyectoId)
    {
        $ultimasEstimaciones = self::where('proyecto_id', $proyectoId)
            ->select('partida_id', 'avance_porcentaje')
            ->orderBy('fecha', 'desc')
            ->distinct('partida_id')
            ->get();
        
        $promedioAvance = $ultimasEstimaciones->avg('avance_porcentaje');
        
        return round($promedioAvance, 2);
    }

    // app/Models/EstimacionesPartida.php

/**
 * Obtener la estimación anterior de esta misma partida
 */
public function getEstimacionAnteriorAttribute()
{
    return self::where('partida_id', $this->partida_id)
        ->where('fecha', '<', $this->fecha)
        ->orderBy('fecha', 'desc')
        ->first();
}

/**
 * Obtener el avance del período (solo lo que se avanza en esta estimación)
 */
public function getAvancePeriodoAttribute()
{
    $anterior = $this->estimacion_anterior;
    return $this->avance_porcentaje - ($anterior ? $anterior->avance_porcentaje : 0);
}

/**
 * Obtener la cantidad ejecutada en este período (solo la nueva)
 */
public function getCantidadPeriodoAttribute()
{
    $anterior = $this->estimacion_anterior;
    return $this->cantidad_ejecutada - ($anterior ? $anterior->cantidad_ejecutada : 0);
}

/**
 * Obtener el monto devengado en este período
 */
public function getMontoDevengadoPeriodoAttribute()
{
    return ($this->avance_periodo / 100) * $this->partida->importe;
}
}