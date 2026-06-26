<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Evidencia extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'evidencias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tipo',
        'nombre',
        'descripcion',
        'proyecto_id',
        'categoria_id',
        'categoria_nombre',
        'fecha',
        'subido_por',
        'archivo_path',
        'archivo_nombre',
        'tamanio_bytes',
        'tipo_archivo',
        'miniatura_path',
        'metadatos',
        'ancho',
        'alto',
        'estado',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha' => 'date',
        'tamanio_bytes' => 'integer',
        'ancho' => 'integer',
        'alto' => 'integer',
        'metadatos' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the project that owns the evidencia.
     */
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    /**
     * Get the category that owns the evidencia.
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaEvidencia::class, 'categoria_id');
    }

    /**
     * Get the user who uploaded the evidencia.
     */
    public function subidoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'subido_por');
    }

    /**
     * Get the user who created the evidencia.
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the evidencia.
     */
    public function actualizador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the category name (from relation or fallback).
     */
    public function getCategoriaNombreAttribute(): string
    {
        if ($this->categoria) {
            return $this->categoria->nombre;
        }
        return $this->categoria_nombre ?? 'Sin categoría';
    }

    /**
     * Get the category color (from relation or fallback).
     */
    public function getCategoriaColorAttribute(): string
    {
        if ($this->categoria) {
            return $this->categoria->color;
        }
        return '#6c757d';
    }

    /**
     * Get the category icon (from relation or fallback).
     */
    public function getCategoriaIconoAttribute(): string
    {
        if ($this->categoria) {
            return $this->categoria->icono;
        }
        return 'fa-tag';
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
        return $this->fecha ? $this->fecha->format('d/m/Y') : 'N/A';
    }

    /**
     * Get the full URL for the file.
     */
    public function getArchivoUrlAttribute(): string
    {
        if (empty($this->archivo_path)) {
            return '';
        }
        return Storage::disk('public')->url($this->archivo_path);
    }

    /**
     * Get the full URL for the thumbnail.
     */
    public function getMiniaturaUrlAttribute(): string
    {
        if (empty($this->miniatura_path)) {
            // Return default icon based on type
            if ($this->tipo === 'foto') {
                return asset('images/default-image.jpg');
            }
            return asset('images/default-pdf.jpg');
        }
        return Storage::disk('public')->url($this->miniatura_path);
    }

    /**
     * Get the icon based on file type.
     */
    public function getIconoAttribute(): string
    {
        if ($this->tipo === 'foto') {
            return 'fa-image';
        }
        return 'fa-file-pdf';
    }

    /**
     * Get the color based on file type.
     */
    public function getColorAttribute(): string
    {
        if ($this->tipo === 'foto') {
            return '#28a745';
        }
        return '#dc3545';
    }

    /**
     * Get the badge class for the type.
     */
    public function getTipoBadgeAttribute(): string
    {
        return $this->tipo === 'foto' ? 'badge-foto' : 'badge-acta';
    }

    /**
     * Get the status badge class.
     */
    public function getEstadoBadgeAttribute(): string
    {
        return match ($this->estado) {
            'activo' => 'badge-success',
            'archivado' => 'badge-warning',
            'eliminado' => 'badge-danger',
            default => 'badge-secondary',
        };
    }

    /**
     * Check if the evidencia is a photo.
     */
    public function isFoto(): bool
    {
        return $this->tipo === 'foto';
    }

    /**
     * Check if the evidencia is an acta.
     */
    public function isActa(): bool
    {
        return $this->tipo === 'acta';
    }

    /**
     * Check if the evidencia is active.
     */
    public function isActivo(): bool
    {
        return $this->estado === 'activo';
    }

    /**
     * Scope a query to only include photos.
     */
    public function scopeFotos($query)
    {
        return $query->where('tipo', 'foto');
    }

    /**
     * Scope a query to only include actas.
     */
    public function scopeActas($query)
    {
        return $query->where('tipo', 'acta');
    }

    /**
     * Scope a query to only include active evidencias.
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Scope a query to filter by project.
     */
    public function scopePorProyecto($query, $proyectoId)
    {
        return $query->where('proyecto_id', $proyectoId);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopePorCategoria($query, $categoriaId)
    {
        return $query->where('categoria_id', $categoriaId);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
    }

    /**
     * Scope a query to search by name or description.
     */
    public function scopeBuscar($query, $termino)
    {
        return $query->where(function($q) use ($termino) {
            $q->where('nombre', 'LIKE', "%{$termino}%")
              ->orWhere('descripcion', 'LIKE', "%{$termino}%")
              ->orWhere('categoria_nombre', 'LIKE', "%{$termino}%");
        });
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->fecha)) {
                $model->fecha = now();
            }
            
            // Si no tiene categoría_id pero tiene categoria_nombre, buscar o crear
            if (empty($model->categoria_id) && !empty($model->categoria_nombre)) {
                $categoria = CategoriaEvidencia::firstOrCreate(
                    ['nombre' => $model->categoria_nombre],
                    [
                        'codigo' => strtoupper(substr($model->categoria_nombre, 0, 3)) . '_' . uniqid(),
                        'activo' => true
                    ]
                );
                $model->categoria_id = $categoria->id;
            }
        });

        static::deleting(function ($model) {
            // Eliminar archivos físicos al eliminar el registro
            if (!empty($model->archivo_path)) {
                Storage::disk('public')->delete($model->archivo_path);
            }
            if (!empty($model->miniatura_path)) {
                Storage::disk('public')->delete($model->miniatura_path);
            }
        });
    }
}