<?php
// app/Models/Contratista.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contratista extends Model
{
    use SoftDeletes;

    protected $table = 'contratistas';
    
    protected $fillable = [
        'proveedor_id',
        'codigo',
        'nombre_comercial',
        'especialidad',
        'nivel_riesgo',
        'calificacion',
        'registro_imss',
        'licencia_obra',
        'fecha_registro',
        'activo'
    ];

    protected $casts = [
        'calificacion' => 'decimal:2',
        'fecha_registro' => 'date',
        'activo' => 'boolean'
    ];

    /**
     * Relación con proveedor
     */
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    /**
     * Relación con asignaciones
     */
    public function asignaciones(): HasMany
    {
        return $this->hasMany(AsignacionContratista::class);
    }

    /**
     * Relación con gastos
     */
    public function gastos(): HasMany
    {
        return $this->hasMany(GastoContratista::class);
    }

    /**
     * Relación con documentos
     */
    public function documentos(): HasMany
    {
        return $this->hasMany(DocumentoContratista::class);
    }

    /**
     * Relación con órdenes de trabajo
     */
    public function ordenesTrabajo(): HasMany
    {
        return $this->hasMany(OrdenTrabajoContratista::class);
    }

    /**
     * Relación con evaluaciones
     */
    public function evaluaciones(): HasMany
    {
        return $this->hasMany(EvaluacionContratista::class);
    }

    /**
     * Relación con pagos
     */
    public function pagos(): HasMany
    {
        return $this->hasMany(PagoContratista::class);
    }

    /**
     * Relación con alertas
     */
    public function alertas(): HasMany
    {
        return $this->hasMany(AlertaContratista::class);
    }

    /**
     * Scope para activos
     */
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope por especialidad
     */
    public function scopeByEspecialidad($query, $especialidad)
    {
        return $query->where('especialidad', $especialidad);
    }

    /**
     * Scope por nivel de riesgo
     */
    public function scopeByRiesgo($query, $nivel)
    {
        return $query->where('nivel_riesgo', $nivel);
    }

    /**
     * Accessor para nombre completo
     */
    public function getNombreCompletoAttribute(): string
    {
        return $this->nombre_comercial ?? $this->proveedor->nombre ?? $this->codigo;
    }

    /**
     * Accessor para presupuesto total
     */
    public function getPresupuestoTotalAttribute(): float
    {
        return (float) $this->asignaciones()->sum('presupuesto_asignado');
    }

    /**
     * Accessor para gasto total
     */
    public function getGastoTotalAttribute(): float
    {
        return (float) $this->asignaciones()->sum('gasto_acumulado');
    }

    /**
     * Accessor para saldo disponible
     */
    public function getSaldoDisponibleAttribute(): float
    {
        return $this->presupuesto_total - $this->gasto_total;
    }

    /**
     * Accessor para proyectos activos
     */
    public function getProyectosActivosAttribute(): int
    {
        return $this->asignaciones()
            ->whereIn('status', ['asignado', 'en_progreso'])
            ->distinct('proyecto_id')
            ->count();
    }

    /**
     * Método para actualizar calificación
     */
    public function actualizarCalificacion(): void
    {
        $promedio = $this->evaluaciones()->avg('promedio');
        $this->calificacion = $promedio ?? 0;
        $this->save();
    }

    /**
     * Método para verificar si tiene asignaciones activas
     */
    public function tieneAsignacionesActivas(): bool
    {
        return $this->asignaciones()
            ->whereIn('status', ['asignado', 'en_progreso'])
            ->exists();
    }
}