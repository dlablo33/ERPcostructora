<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BitacoraIncidencia extends Model
{
    protected $table = 'bitacora_incidencias';

    protected $fillable = [
        'bitacora_entry_id',
        'codigo',
        'tipo_incidencia',
        'prioridad',
        'accion_tomada',
        'resuelta_en'
    ];

    protected $casts = [
        'resuelta_en' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relaciones
    public function bitacoraEntry(): BelongsTo
    {
        return $this->belongsTo(BitacoraEntry::class, 'bitacora_entry_id');
    }

    // Accessors
    public function getPrioridadColorAttribute(): string
    {
        return match($this->prioridad) {
            'baja' => '#28a745',
            'media' => '#ffc107',
            'alta' => '#fd7e14',
            'critica' => '#dc3545',
            default => '#6c757d'
        };
    }

    public function getTipoIncidenciaLabelAttribute(): string
    {
        return match($this->tipo_incidencia) {
            'mecanica' => 'Mecánica',
            'personal' => 'Personal',
            'material' => 'Material',
            'seguridad' => 'Seguridad',
            'clima' => 'Clima',
            'otros' => 'Otros',
            default => 'No especificado'
        };
    }

    public function getEstaResueltaAttribute(): bool
    {
        return !is_null($this->resuelta_en);
    }

    // Mutators
    public function setAccionTomadaAttribute($value)
    {
        $this->attributes['accion_tomada'] = $value;
    }

    // Boot
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($incidencia) {
            if (empty($incidencia->codigo)) {
                $lastId = static::max('id') + 1;
                $incidencia->codigo = 'BIC-' . str_pad($lastId, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    // Scopes
    public function scopePorPrioridad($query, $prioridad)
    {
        if ($prioridad) {
            return $query->where('prioridad', $prioridad);
        }
        return $query;
    }

    public function scopeNoResueltas($query)
    {
        return $query->whereNull('resuelta_en');
    }

    public function scopeResueltas($query)
    {
        return $query->whereNotNull('resuelta_en');
    }
}