<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hito extends Model
{
    /**
     * La tabla asociada al modelo.
     */
    protected $table = 'hitos';
    
    /**
     * Los atributos que son asignables en masa.
     */
    protected $fillable = [
        'proyecto_id',
        'nombre',
        'descripcion',
        'fecha_programada',
        'fecha_fin',         // ← NUEVO
        'fecha_real',
        'hora',
        'estado',
        'prioridad',
        'tipo',
        'responsable_id',
        'entregables',
        'dependencias',
        'notificar_a',
        'avance',
        'es_critico'
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
        'fecha_programada' => 'date:Y-m-d',
        'fecha_fin' => 'date:Y-m-d',       // ← NUEVO
        'fecha_real' => 'date:Y-m-d',
        'entregables' => 'array',
        'dependencias' => 'array',
        'notificar_a' => 'array',
        'es_critico' => 'boolean',
        'avance' => 'integer'
    ];

    /**
     * Relación: Hito pertenece a un Proyecto
     */
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    /**
     * Relación: Hito tiene un Responsable (Usuario)
     */
    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    // ============================================
    // SCOPES PARA FILTROS
    // ============================================

    public function scopeCompletados($query)
    {
        return $query->where('estado', 'completado');
    }

    public function scopeEnProceso($query)
    {
        return $query->where('estado', 'en_proceso');
    }

    public function scopeRetrasados($query)
    {
        return $query->where('estado', 'retrasado');
    }

    public function scopeProgramados($query)
    {
        return $query->where('estado', 'programado');
    }

    public function scopeCriticos($query)
    {
        return $query->where('es_critico', true);
    }

    public function scopeProximos($query, $dias = 7)
    {
        return $query->where('fecha_programada', '>=', now())
                     ->where('fecha_programada', '<=', now()->addDays($dias));
    }

    public function scopeDelProyecto($query, $proyectoId)
    {
        return $query->where('proyecto_id', $proyectoId);
    }

    public function scopeEntreFechas($query, $inicio, $fin)
    {
        return $query->where(function($q) use ($inicio, $fin) {
            $q->whereBetween('fecha_programada', [$inicio, $fin])
              ->orWhereBetween('fecha_fin', [$inicio, $fin])
              ->orWhere(function($q2) use ($inicio, $fin) {
                  $q2->where('fecha_programada', '<=', $inicio)
                     ->where('fecha_fin', '>=', $fin);
              });
        });
    }

    public function scopePrioridad($query, $prioridad)
    {
        return $query->where('prioridad', $prioridad);
    }

    // ============================================
    // ACCESSORS (GETTERS)
    // ============================================

    public function getColorEstadoAttribute(): string
    {
        return match($this->estado) {
            'completado' => '#28a745',
            'en_proceso' => '#ffc107',
            'retrasado' => '#dc3545',
            default => '#6c757d'
        };
    }

    public function getIconoEstadoAttribute(): string
    {
        return match($this->estado) {
            'completado' => 'fa-check-circle',
            'en_proceso' => 'fa-clock',
            'retrasado' => 'fa-exclamation-triangle',
            default => 'fa-circle'
        };
    }

    public function getClaseEstadoAttribute(): string
    {
        return match($this->estado) {
            'completado' => 'completado',
            'en_proceso' => 'proceso',
            'retrasado' => 'retrasado',
            default => 'programado'
        };
    }

    public function getNombreProyectoAttribute(): string
    {
        return $this->proyecto ? "{$this->proyecto->codigo} - {$this->proyecto->nombre}" : 'Sin proyecto';
    }

    public function getNombreResponsableAttribute(): string
    {
        return $this->responsable ? $this->responsable->name : 'Sin asignar';
    }

    public function getEstaAtrasadoAttribute(): bool
    {
        if ($this->estado === 'completado') return false;
        if ($this->estado === 'retrasado') return true;
        
        // Usar fecha_fin si existe, sino fecha_programada
        $fechaReferencia = $this->fecha_fin ?? $this->fecha_programada;
        return $fechaReferencia < now() && $this->avance < 100;
    }

    public function getDiasRestantesAttribute(): int
    {
        $fechaReferencia = $this->fecha_fin ?? $this->fecha_programada;
        return (int) now()->diffInDays($fechaReferencia, false);
    }

    /**
     * Calcular días de duración del hito
     */
    public function getDiasDuracionAttribute(): int
    {
        if ($this->fecha_fin) {
            return (int) $this->fecha_programada->diffInDays($this->fecha_fin) + 1;
        }
        return 1;
    }

    /**
     * Obtener el rango de fechas formateado
     */
    public function getRangoFechasAttribute(): string
    {
        $inicio = $this->fecha_programada?->format('d/m/Y');
        $fin = $this->fecha_fin?->format('d/m/Y');
        
        if ($fin && $fin !== $inicio) {
            return "{$inicio} - {$fin}";
        }
        return $inicio ?? 'Sin fecha';
    }

    // ============================================
    // MÉTODOS AUXILIARES
    // ============================================

    /**
     * Verificar si el hito está activo en una fecha específica
     */
    public function estaActivoEnFecha($fecha): bool
    {
        $fecha = is_string($fecha) ? \Carbon\Carbon::parse($fecha) : $fecha;
        $inicio = $this->fecha_programada;
        $fin = $this->fecha_fin ?? $this->fecha_programada;
        
        return $fecha->between($inicio, $fin);
    }

    /**
     * Actualizar estado automáticamente según avance
     */
    public function actualizarEstadoSegunAvance(): void
    {
        if ($this->avance >= 100) {
            $this->estado = 'completado';
            $this->fecha_real = now();
        } elseif ($this->avance > 0) {
            $this->estado = 'en_proceso';
        }
        
        // Si ya pasó la fecha fin (o programada) y no está completo
        $fechaReferencia = $this->fecha_fin ?? $this->fecha_programada;
        if ($fechaReferencia < now() && $this->avance < 100 && $this->estado !== 'retrasado') {
            $this->estado = 'retrasado';
        }
        
        $this->save();
    }
}