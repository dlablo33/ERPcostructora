<?php
// app/Models/ProyectoPartida.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProyectoPartida extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'proyecto_partidas';
    
    protected $fillable = [
        'proyecto_id',
        'codigo',
        'nombre',
        'descripcion',
        'seccion',
        'categoria',
        'unidad',
        'cantidad',
        'precio_unitario',
        'orden',
        'activa'
    ];
    
    protected $casts = [
        'cantidad' => 'decimal:2',
        'precio_unitario' => 'decimal:2',
        'importe' => 'decimal:2',
        'activa' => 'boolean',
        'orden' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
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
     * Relación con movimientos bancarios (costo incurrido real)
     */
    public function movimientos()
    {
        return $this->hasMany(MovimientoBancario::class, 'partida_id');
    }
    
    /**
     * Relación con estimaciones de avance (MUCHAS)
     * Una partida puede tener muchas estimaciones a lo largo del tiempo
     */
    public function estimaciones()
    {
        return $this->hasMany(EstimacionesPartida::class, 'partida_id');
    }
    
    // ==========================================
    // ATTRIBUTOS (Calculados desde partida)
    // ==========================================
    
    /**
     * Obtener el importe total (cantidad * precio_unitario)
     */
    public function getImporteAttribute()
    {
        return $this->cantidad * $this->precio_unitario;
    }
    
    /**
     * Obtener el nombre de la categoría en español
     */
    public function getCategoriaNombreAttribute()
    {
        $categorias = [
            'materiales' => 'Materiales',
            'mano_obra' => 'Mano de Obra',
            'maquinaria' => 'Maquinaria',
            'subcontratos' => 'Subcontratos',
            'indirectos' => 'Gastos Indirectos',
        ];
        
        return $categorias[$this->categoria] ?? $this->categoria;
    }
    
    // ==========================================
    // ATTRIBUTOS (Calculados desde MOVIMIENTOS - Costo Incurrido)
    // ==========================================
    
    /**
     * Obtener el costo incurrido real (suma de movimientos bancarios)
     */
    public function getCostoIncurridoAttribute()
    {
        return $this->movimientos()
            ->where('tipo', 'egreso')
            ->where('status', 'aplicado')
            ->sum('monto');
    }
    
    /**
     * Obtener el avance financiero (por costo incurrido)
     */
    public function getAvanceFinancieroAttribute()
    {
        if ($this->importe <= 0) return 0;
        
        return round(($this->costo_incurrido / $this->importe) * 100, 2);
    }
    
    /**
     * Obtener el monto ejecutado por costo
     */
    public function getEjecutadoPorCostoAttribute()
    {
        return $this->costo_incurrido;
    }
    
    /**
     * Obtener el monto pendiente por costo
     */
    public function getPendientePorCostoAttribute()
    {
        $pendiente = $this->importe - $this->costo_incurrido;
        return $pendiente < 0 ? 0 : $pendiente;
    }
    
    // ==========================================
    // ATTRIBUTOS (Calculados desde ESTIMACIONES - Avance Físico)
    // ==========================================
    
    /**
     * Obtener la última estimación de esta partida
     */
    public function getUltimaEstimacionAttribute()
    {
        return $this->estimaciones()
            ->orderBy('fecha', 'desc')
            ->first();
    }
    
    /**
     * Obtener el avance acumulado según la última estimación (%)
     */
    public function getAvanceAcumuladoAttribute()
    {
        $ultimaEstimacion = $this->ultima_estimacion;
        return $ultimaEstimacion ? $ultimaEstimacion->avance_porcentaje : 0;
    }
    
    /**
     * Obtener la cantidad total ejecutada acumulada (suma de todas las estimaciones)
     */
    public function getCantidadEjecutadaAcumuladaAttribute()
    {
        return $this->estimaciones()->sum('cantidad_ejecutada');
    }
    
    /**
     * Obtener la cantidad total ejecutada (alias)
     */
    public function getCantidadEjecutadaTotalAttribute()
    {
        return $this->cantidad_ejecutada_acumulada;
    }
    
    /**
     * Obtener el avance FÍSICO real basado en cantidad ejecutada
     * Este es el método PRINCIPAL para medir avance de obra
     */
    public function getAvanceFisicoAttribute()
    {
        if ($this->cantidad <= 0) return 0;
        
        $cantidadEjecutada = $this->cantidad_ejecutada_acumulada;
        $avance = ($cantidadEjecutada / $this->cantidad) * 100;
        
        return round($avance, 2);
    }
    
    /**
     * Obtener el avance real (alias de avance_fisico)
     */
    public function getAvanceRealAttribute()
    {
        return $this->avance_fisico;
    }
    
    /**
     * Obtener el monto devengado real basado en avance físico
     * Este es el valor que se debe facturar al cliente
     */
    public function getMontoDevengadoRealAttribute()
    {
        return ($this->avance_fisico / 100) * $this->importe;
    }
    
    /**
     * Obtener el monto ejecutado por avance físico
     */
    public function getEjecutadoPorAvanceAttribute()
    {
        return $this->monto_devengado_real;
    }
    
    /**
     * Obtener el monto pendiente por avance físico
     */
    public function getPendientePorAvanceAttribute()
    {
        $pendiente = $this->importe - $this->monto_devengado_real;
        return $pendiente < 0 ? 0 : $pendiente;
    }
    
    // ==========================================
    // ATTRIBUTOS (Comparativos - Índice de Rendimiento)
    // ==========================================
    
    /**
     * Obtener el índice de rendimiento (avance físico vs avance financiero)
     * > 1 = Vas adelantado (gastas menos de lo que has avanzado)
     * = 1 = Vas según lo planeado
     * < 1 = Vas atrasado (gastas más de lo que has avanzado)
     */
    public function getIndiceRendimientoAttribute()
    {
        if ($this->avance_financiero <= 0) return 0;
        
        return round($this->avance_fisico / $this->avance_financiero, 2);
    }
    
    /**
     * Obtener la variación (diferencia entre avance físico y financiero)
     */
    public function getVariacionAttribute()
    {
        return round($this->avance_fisico - $this->avance_financiero, 2);
    }
    
    /**
     * Obtener el color del semáforo según el rendimiento
     */
    public function getSemaforoAttribute()
    {
        if ($this->indice_rendimiento >= 1.05) return 'success';   // Verde (superávit)
        if ($this->indice_rendimiento >= 0.95) return 'primary';    // Azul (OK)
        if ($this->indice_rendimiento >= 0.85) return 'warning';    // Amarillo (alerta)
        return 'danger';                                             // Rojo (crítico)
    }
    
    /**
     * Obtener el color según el avance físico
     */
    public function getAvanceColorAttribute()
    {
        if ($this->avance_fisico >= 75) return 'success';
        if ($this->avance_fisico >= 50) return 'primary';
        if ($this->avance_fisico >= 25) return 'warning';
        return 'danger';
    }
    
    // ==========================================
    // SCOPES (Consultas comunes)
    // ==========================================
    
    /**
     * Scope para filtrar por sección
     */
    public function scopePorSeccion($query, $seccion)
    {
        if ($seccion) {
            return $query->where('seccion', $seccion);
        }
        return $query;
    }
    
    /**
     * Scope para filtrar por categoría
     */
    public function scopePorCategoria($query, $categoria)
    {
        if ($categoria) {
            return $query->where('categoria', $categoria);
        }
        return $query;
    }
    
    /**
     * Scope para filtrar por búsqueda
     */
    public function scopeBuscar($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }
        return $query;
    }
    
    /**
     * Scope para solo partidas activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }
    
    /**
     * Scope para ordenar por orden y código
     */
    public function scopeOrdenadas($query)
    {
        return $query->orderBy('orden', 'asc')->orderBy('codigo', 'asc');
    }
    
    // ==========================================
    // MÉTODOS ESTÁTICOS PARA REPORTES
    // ==========================================
    
    /**
     * Obtener todas las secciones disponibles de un proyecto
     */
    public static function getSecciones($proyectoId)
    {
        return self::where('proyecto_id', $proyectoId)
            ->where('activa', true)
            ->select('seccion')
            ->distinct()
            ->orderBy('seccion')
            ->pluck('seccion')
            ->toArray();
    }
    
    /**
     * Obtener resumen por categoría de un proyecto (basado en avance físico)
     */
    public static function getResumenPorCategoria($proyectoId)
    {
        $partidas = self::where('proyecto_id', $proyectoId)
            ->where('activa', true)
            ->get();
        
        $resumen = [
            'materiales' => ['presupuesto' => 0, 'ejecutado' => 0, 'pendiente' => 0, 'avance' => 0],
            'mano_obra' => ['presupuesto' => 0, 'ejecutado' => 0, 'pendiente' => 0, 'avance' => 0],
            'maquinaria' => ['presupuesto' => 0, 'ejecutado' => 0, 'pendiente' => 0, 'avance' => 0],
            'subcontratos' => ['presupuesto' => 0, 'ejecutado' => 0, 'pendiente' => 0, 'avance' => 0],
            'indirectos' => ['presupuesto' => 0, 'ejecutado' => 0, 'pendiente' => 0, 'avance' => 0],
        ];
        
        foreach ($partidas as $partida) {
            $cat = $partida->categoria;
            $resumen[$cat]['presupuesto'] += $partida->importe;
            $resumen[$cat]['ejecutado'] += $partida->monto_devengado_real;
            $resumen[$cat]['pendiente'] += $partida->pendiente_por_avance;
        }
        
        foreach ($resumen as $key => $value) {
            if ($value['presupuesto'] > 0) {
                $resumen[$key]['avance'] = round(($value['ejecutado'] / $value['presupuesto']) * 100, 1);
            }
        }
        
        return $resumen;
    }
    
    /**
     * Obtener resumen por sección de un proyecto (basado en avance físico)
     */
    public static function getResumenPorSeccion($proyectoId)
    {
        $partidas = self::where('proyecto_id', $proyectoId)
            ->where('activa', true)
            ->get();
        
        $resumen = [];
        
        foreach ($partidas as $partida) {
            $seccion = $partida->seccion ?? 'Sin sección';
            
            if (!isset($resumen[$seccion])) {
                $resumen[$seccion] = [
                    'presupuesto' => 0,
                    'ejecutado' => 0,
                    'pendiente' => 0,
                    'partidas' => 0,
                    'avance' => 0
                ];
            }
            
            $resumen[$seccion]['presupuesto'] += $partida->importe;
            $resumen[$seccion]['ejecutado'] += $partida->monto_devengado_real;
            $resumen[$seccion]['pendiente'] += $partida->pendiente_por_avance;
            $resumen[$seccion]['partidas']++;
        }
        
        // Calcular avance
        foreach ($resumen as $key => $value) {
            if ($value['presupuesto'] > 0) {
                $resumen[$key]['avance'] = round(($value['ejecutado'] / $value['presupuesto']) * 100, 1);
            }
        }
        
        return $resumen;
    }
    
    /**
     * Obtener el avance global del proyecto (ponderado por costo)
     */
    public static function getAvanceGlobalProyecto($proyectoId)
    {
        $partidas = self::where('proyecto_id', $proyectoId)
            ->where('activa', true)
            ->get();
        
        $totalPresupuesto = $partidas->sum('importe');
        $totalDevengado = $partidas->sum('monto_devengado_real');
        
        if ($totalPresupuesto <= 0) return 0;
        
        return round(($totalDevengado / $totalPresupuesto) * 100, 2);
    }
}