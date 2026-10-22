<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'responsable_id',
        'responsable',
        'personal',
        'maquinaria',
        'materiales',
        'estado',
        'created_by',
    ];

    protected $casts = [
        'fecha'      => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Si quieres que los accessors se incluyan siempre en el JSON,
     * descomenta esta línea.
     *
     * protected $appends = ['hora_corta', 'tipo_color', 'tipo_icono', 'estado_badge'];
     */

    /* =========================================================
     |  RELACIONES
     | ========================================================= */

    /**
     * Usuario que creó la entrada.
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Usuario responsable asignado (FK users.id).
     */
    public function responsableUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    /**
     * Proyecto al que pertenece.
     * (proyectos.codigo => bitacora_entries.proyecto_id)
     */
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'codigo');
    }

    /**
     * Incidencias asociadas a esta entrada (puede haber varias).
     */
    public function incidencia(): HasMany
    {
        return $this->hasMany(BitacoraIncidencia::class, 'bitacora_entry_id');
    }

    /**
     * Alias en singular: SOLO la última incidencia de esta entrada.
     * Se usa en el blade para el ícono ✅ de resolución.
     */
    public function primeraIncidencia(): HasOne
    {
        return $this->hasOne(BitacoraIncidencia::class, 'bitacora_entry_id')->latestOfMany();
    }

    /**
     * Evidencias fotográficas.
     */
    public function evidencias(): HasMany
    {
        return $this->hasMany(EvidenciaFotografica::class, 'bitacora_entry_id');
    }

    /**
     * Comentarios.
     *
     * ⚠️ IMPORTANTE: NO agregar `->latest()` aquí.
     * Si se hace, la relación devuelve una Collection en vez de un
     * Query Builder, y rompe llamadas como `$entry->comentarios()->delete()`.
     *
     * Para traerlos ordenados por fecha desc, usa:
     *     $entry->comentarios()->latest()->get()
     */
    public function comentarios(): HasMany
    {
        return $this->hasMany(ComentarioBitacora::class, 'bitacora_entry_id');
    }

    /* =========================================================
     |  ACCESSORS
     | ========================================================= */

    public function getTipoColorAttribute(): string
    {
        return match ($this->tipo) {
            'actividad'  => '#28a745',
            'incidencia' => '#dc3545',
            'acuerdo'    => '#ffc107',
            'nota'       => '#17a2b8',
            default      => '#6c757d',
        };
    }

    public function getTipoIconoAttribute(): string
    {
        return match ($this->tipo) {
            'actividad'  => 'fa-check-circle',
            'incidencia' => 'fa-exclamation-triangle',
            'acuerdo'    => 'fa-handshake',
            'nota'       => 'fa-sticky-note',
            default      => 'fa-file-alt',
        };
    }

    public function getEstadoBadgeAttribute(): string
    {
        return match ($this->estado) {
            'pendiente'  => 'warning',
            'en_proceso' => 'info',
            'completado' => 'success',
            'cerrado'    => 'secondary',
            default      => 'light',
        };
    }

    /**
     * Hora formateada a HH:MM (por si viene con segundos).
     */
    public function getHoraCortaAttribute(): ?string
    {
        if (!$this->hora) return null;
        return substr((string) $this->hora, 0, 5);
    }

    /* =========================================================
     |  SCOPES
     | ========================================================= */

    public function scopePorProyecto($query, $proyectoId)
    {
        return $proyectoId ? $query->where('proyecto_id', $proyectoId) : $query;
    }

    public function scopePorTipo($query, $tipo)
    {
        return $tipo ? $query->where('tipo', $tipo) : $query;
    }

    public function scopePorEstado($query, $estado)
    {
        return $estado ? $query->where('estado', $estado) : $query;
    }

    public function scopePorRangoFechas($query, $fechaInicio, $fechaFin)
    {
        if ($fechaInicio && $fechaFin) {
            return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }
        return $query;
    }

    public function scopeSearch($query, $term)
    {
        if (!$term) return $query;

        return $query->where(function ($q) use ($term) {
            $q->where('titulo', 'LIKE', "%{$term}%")
              ->orWhere('descripcion', 'LIKE', "%{$term}%")
              ->orWhere('responsable', 'LIKE', "%{$term}%");
        });
    }
}