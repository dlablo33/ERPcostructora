<?php
// app/Models/AsignacionContratista.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AsignacionContratista extends Model
{
    use SoftDeletes;

    protected $table = 'asignaciones_contratistas';
    
    protected $fillable = [
        'contratista_id',
        'proyecto_id',
        'partida_id',
        'seccion',
        'fecha_asignacion',
        'fecha_inicio',
        'fecha_fin',
        'presupuesto_asignado',
        'gasto_acumulado',
        'saldo_disponible',
        'avance_porcentaje',
        'status',
        'condiciones_pago',
        'created_by'
    ];

    protected $casts = [
        'fecha_asignacion' => 'date',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'presupuesto_asignado' => 'decimal:2',
        'gasto_acumulado' => 'decimal:2',
        'saldo_disponible' => 'decimal:2',
        'avance_porcentaje' => 'decimal:2'
    ];

    /**
     * Relación con contratista
     */
    public function contratista(): BelongsTo
    {
        return $this->belongsTo(Contratista::class);
    }

    /**
     * Relación con proyecto
     */
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    /**
     * Relación con partida
     */
    public function partida(): BelongsTo
    {
        return $this->belongsTo(ProyectoPartida::class, 'partida_id');
    }

    /**
     * Relación con gastos
     */
    public function gastos(): HasMany
    {
        return $this->hasMany(GastoContratista::class);
    }

    /**
     * Relación con órdenes de trabajo
     */
    public function ordenesTrabajo(): HasMany
    {
        return $this->hasMany(OrdenTrabajoContratista::class);
    }

    /**
     * Relación con historial de presupuestos
     */
    public function historialPresupuesto(): HasMany
    {
        return $this->hasMany(HistorialPresupuestoContratista::class);
    }

    /**
     * Relación con pagos
     */
    public function pagos(): HasMany
    {
        return $this->hasMany(PagoContratista::class);
    }

    /**
     * Relación con creador
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope por status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope por proyecto
     */
    public function scopeByProyecto($query, $proyectoId)
    {
        return $query->where('proyecto_id', $proyectoId);
    }

    /**
     * Scope por contratista
     */
    public function scopeByContratista($query, $contratistaId)
    {
        return $query->where('contratista_id', $contratistaId);
    }

    /**
     * Scope por rango de fechas
     */
    public function scopeBetweenDates($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha_asignacion', [$inicio, $fin]);
    }

    /**
     * Accessor para presupuesto restante
     */
    public function getPresupuestoRestanteAttribute(): float
    {
        return $this->presupuesto_asignado - $this->gasto_acumulado;
    }

    /**
     * Accessor para porcentaje de gasto
     */
    public function getPorcentajeGastoAttribute(): float
    {
        if ($this->presupuesto_asignado > 0) {
            return ($this->gasto_acumulado / $this->presupuesto_asignado) * 100;
        }
        return 0;
    }

    /**
     * Accessor para días transcurridos
     */
    public function getDiasTranscurridosAttribute(): int
    {
        if ($this->fecha_inicio) {
            return now()->diffInDays($this->fecha_inicio);
        }
        return 0;
    }

    /**
     * Método para actualizar saldo
     */
    public function actualizarSaldo(): void
    {
        $this->gasto_acumulado = $this->gastos()->sum('monto');
        $this->saldo_disponible = $this->presupuesto_asignado - $this->gasto_acumulado;
        $this->save();
    }

    /**
     * Método para calcular avance
     */
    public function calcularAvance(): void
    {
        if ($this->presupuesto_asignado > 0) {
            $avance = ($this->gasto_acumulado / $this->presupuesto_asignado) * 100;
            $this->avance_porcentaje = min(100, $avance);
        } else {
            $this->avance_porcentaje = 0;
        }
        $this->save();
    }

    /**
     * Método para verificar si está activa
     */
    public function isActive(): bool
    {
        return in_array($this->status, ['asignado', 'en_progreso']);
    }

    /**
     * Método para verificar si está completada
     */
    public function isCompleted(): bool
    {
        return $this->status === 'finalizado';
    }
}