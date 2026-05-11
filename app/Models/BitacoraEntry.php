<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BitacoraEntry extends Model
{
    use SoftDeletes;

    protected $table = 'bitacora_entries';

    protected $fillable = [
        'proyecto_id',
        'tipo',
        'titulo',
        'descripcion',
        'fecha',
        'hora',
        'responsable',
        'personal',
        'maquinaria',
        'materiales',
        'estado',
        'created_by'
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora' => 'datetime:H:i',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relaciones
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function incidencia(): HasMany
    {
        return $this->hasMany(BitacoraIncidencia::class, 'bitacora_entry_id');
    }

    public function evidencias(): HasMany
    {
        return $this->hasMany(EvidenciaFotografica::class, 'bitacora_entry_id');
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(ComentarioBitacora::class, 'bitacora_entry_id')->latest();
    }

    // Accessors
    public function getTipoColorAttribute(): string
    {
        return match($this->tipo) {
            'actividad' => '#28a745',
            'incidencia' => '#dc3545',
            'acuerdo' => '#ffc107',
            'nota' => '#17a2b8',
            default => '#6c757d'
        };
    }

    public function getTipoIconoAttribute(): string
    {
        return match($this->tipo) {
            'actividad' => 'fa-check-circle',
            'incidencia' => 'fa-exclamation-triangle',
            'acuerdo' => 'fa-handshake',
            'nota' => 'fa-sticky-note',
            default => 'fa-file-alt'
        };
    }

    public function getEstadoBadgeAttribute(): string
    {
        return match($this->estado) {
            'pendiente' => 'warning',
            'en_proceso' => 'info',
            'completado' => 'success',
            'cerrado' => 'secondary',
            default => 'light'
        };
    }

    // Scopes
    public function scopePorProyecto($query, $proyectoId)
    {
        if ($proyectoId) {
            return $query->where('proyecto_id', $proyectoId);
        }
        return $query;
    }

    public function scopePorTipo($query, $tipo)
    {
        if ($tipo) {
            return $query->where('tipo', $tipo);
        }
        return $query;
    }

    public function scopePorRangoFechas($query, $fechaInicio, $fechaFin)
    {
        if ($fechaInicio && $fechaFin) {
            return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }
        return $query;
    }

    public function scopePorEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado', $estado);
        }
        return $query;
    }
}