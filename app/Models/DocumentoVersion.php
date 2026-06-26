<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentoVersion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'documentos_versiones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'documento_tipo',
        'documento_id',
        'version',
        'nombre_version',
        'fecha_version',
        'usuario_id',
        'cambios',
        'documento_path',
        'documento_nombre',
        'tamanio_bytes',
        'es_actual',
        'created_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_version' => 'datetime',
        'es_actual' => 'boolean',
        'tamanio_bytes' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who uploaded this version.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Get the user who created the version record.
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the parent document (contract or plan).
     */
    public function documento()
    {
        return match ($this->documento_tipo) {
            'contrato' => $this->belongsTo(Contrato::class, 'documento_id'),
            'plano' => $this->belongsTo(Plano::class, 'documento_id'),
            default => null,
        };
    }

    /**
     * Scope a query to only include current versions.
     */
    public function scopeActuales($query)
    {
        return $query->where('es_actual', true);
    }

    /**
     * Scope a query to filter by document type.
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('documento_tipo', $tipo);
    }

    /**
     * Scope a query to filter by document ID.
     */
    public function scopePorDocumento($query, $documentoId)
    {
        return $query->where('documento_id', $documentoId);
    }

    /**
     * Get the formatted file size.
     */
    public function getTamanioFormateadoAttribute(): string
    {
        $bytes = $this->tamanio_bytes;
        if ($bytes === 0) return '0 B';
        
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes, 1024));
        return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
    }

    /**
     * Get the formatted date.
     */
    public function getFechaFormateadaAttribute(): string
    {
        return $this->fecha_version ? $this->fecha_version->format('d/m/Y H:i') : 'N/A';
    }

    /**
     * Check if this is the current version.
     */
    public function isActual(): bool
    {
        return $this->es_actual === true;
    }

    /**
     * Mark this version as current and unmark others.
     */
    public function marcarComoActual(): void
    {
        // Unmark all other versions
        $this->newQuery()
            ->where('documento_tipo', $this->documento_tipo)
            ->where('documento_id', $this->documento_id)
            ->where('id', '!=', $this->id)
            ->update(['es_actual' => false]);
        
        // Mark this as current
        $this->es_actual = true;
        $this->save();
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->fecha_version)) {
                $model->fecha_version = now();
            }
        });
    }
}