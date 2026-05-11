<?php
// app/Models/FactorFinanciero.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FactorFinanciero extends Model
{
    use SoftDeletes;

    protected $table = 'factores_financieros';
    protected $primaryKey = 'factor_id';
    
    protected $fillable = [
        'nombre',
        'rfc',
        'contacto_nombre',
        'telefono',
        'email',
        'direccion',
        'porcentaje_anticipo_default',
        'comision_default',
        'dias_plazo_default',
        'activo',
        'observaciones',
        'created_by'
    ];

    protected $casts = [
        'porcentaje_anticipo_default' => 'decimal:2',
        'comision_default' => 'decimal:2',
        'dias_plazo_default' => 'integer',
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relaciones
    public function solicitudes(): HasMany
    {
        return $this->hasMany(SolicitudFactoraje::class, 'factor_id', 'factor_id');
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    // Métodos de ayuda
    public function getNombreCompletoAttribute(): string
    {
        return $this->nombre . ' (' . $this->rfc . ')';
    }
    
    public function getAnticipoFormateadoAttribute(): string
    {
        return number_format($this->porcentaje_anticipo_default, 2) . '%';
    }
    
    public function getComisionFormateadaAttribute(): string
    {
        return number_format($this->comision_default, 2) . '%';
    }
}