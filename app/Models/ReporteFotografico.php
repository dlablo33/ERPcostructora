<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ReporteFotografico extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reportes_fotograficos';

    protected $fillable = [
        'proyecto_id',
        'responsable_id',
        'empleado_id',
        'categoria',
        'titulo',
        'descripcion',
        'fecha',
        'ruta',
        'nombre_original',
        'nombre_unico',
        'tipo',
        'tamanio',
        'ancho',
        'alto',
        'exif',
        'estado',
        'observaciones',
        'created_by'
    ];

    protected $casts = [
        'fecha' => 'date',
        'tamanio' => 'integer',
        'ancho' => 'integer',
        'alto' => 'integer',
        'exif' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'categoria_nombre',
        'categoria_icono',
        'categoria_color',
        'estado_nombre',
        'tamanio_formateado',
        'url',
        'fecha_formateada',
        'responsable_nombre'
    ];

    // ==================== CATÁLOGOS ====================

    const CATEGORIAS = [
        'avance' => 'Avance de Obra',
        'calidad' => 'Control de Calidad',
        'seguridad' => 'Seguridad e Higiene',
        'reunion' => 'Reuniones / Juntas',
        'entrega' => 'Entregas de Material',
        'instalaciones' => 'Instalaciones',
        'estructura' => 'Estructura',
        'terracerias' => 'Terracerías',
        'pavimentos' => 'Pavimentos'
    ];

    const CATEGORIAS_ICONOS = [
        'avance' => 'fa-chart-line',
        'calidad' => 'fa-check-circle',
        'seguridad' => 'fa-hard-hat',
        'reunion' => 'fa-users',
        'entrega' => 'fa-truck',
        'instalaciones' => 'fa-plug',
        'estructura' => 'fa-building',
        'terracerias' => 'fa-mountain',
        'pavimentos' => 'fa-road'
    ];

    const CATEGORIAS_COLORES = [
        'avance' => '#0d6efd',
        'calidad' => '#28a745',
        'seguridad' => '#ffc107',
        'reunion' => '#6c757d',
        'entrega' => '#17a2b8',
        'instalaciones' => '#fd7e14',
        'estructura' => '#6f42c1',
        'terracerias' => '#20c997',
        'pavimentos' => '#e83e8c'
    ];

    const CATEGORIAS_BADGE = [
        'avance' => 'badge-avance',
        'calidad' => 'badge-calidad',
        'seguridad' => 'badge-seguridad',
        'reunion' => 'badge-reunion',
        'entrega' => 'badge-entrega',
        'instalaciones' => 'badge-instalaciones',
        'estructura' => 'badge-estructura',
        'terracerias' => 'badge-terracerias',
        'pavimentos' => 'badge-pavimentos'
    ];

    const ESTADOS = [
        'activo' => 'Activo',
        'archivado' => 'Archivado'
    ];

    const ESTADOS_BADGE = [
        'activo' => 'badge-activo',
        'archivado' => 'badge-archivado'
    ];

    // ==================== RELACIONES ====================

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function empleado()
    {
        return $this->belongsTo(Plantilla::class, 'empleado_id', 'plantilla_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function grupos()
    {
        return $this->belongsToMany(ReporteFotograficoGrupo::class, 'reporte_fotos', 'foto_id', 'reporte_id')
            ->withPivot('orden')
            ->withTimestamps();
    }

    // ==================== ACCESSORS ====================

    public function getCategoriaNombreAttribute(): string
    {
        return self::CATEGORIAS[$this->categoria] ?? $this->categoria;
    }

    public function getCategoriaIconoAttribute(): string
    {
        return self::CATEGORIAS_ICONOS[$this->categoria] ?? 'fa-camera';
    }

    public function getCategoriaColorAttribute(): string
    {
        return self::CATEGORIAS_COLORES[$this->categoria] ?? '#6c757d';
    }

    public function getCategoriaBadgeAttribute(): string
    {
        return self::CATEGORIAS_BADGE[$this->categoria] ?? 'badge-categoria';
    }

    public function getEstadoNombreAttribute(): string
    {
        return self::ESTADOS[$this->estado] ?? $this->estado;
    }

    public function getEstadoBadgeAttribute(): string
    {
        return self::ESTADOS_BADGE[$this->estado] ?? 'badge-estado';
    }

    public function getTamanioFormateadoAttribute(): string
    {
        $tamanio = $this->tamanio;
        $unidades = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($tamanio >= 1024 && $i < count($unidades) - 1) {
            $tamanio /= 1024;
            $i++;
        }
        return round($tamanio, 2) . ' ' . $unidades[$i];
    }

    public function getUrlAttribute(): string
    {
        if ($this->ruta && Storage::disk('public')->exists($this->ruta)) {
            return Storage::disk('public')->url($this->ruta);
        }
        return asset('images/no-image.png');
    }

    public function getFechaFormateadaAttribute(): string
    {
        return $this->fecha ? $this->fecha->format('d/m/Y') : '-';
    }

    public function getResponsableNombreAttribute(): string
    {
        if ($this->responsable) {
            return $this->responsable->name;
        }
        if ($this->empleado) {
            return trim($this->empleado->nombre . ' ' . ($this->empleado->apellido_paterno ?? ''));
        }
        return $this->creador?->name ?? 'Sistema';
    }

    public function getThumbnailAttribute(): string
    {
        // Si es una imagen, generar thumbnail
        if (str_starts_with($this->tipo, 'image/')) {
            return $this->url;
        }
        return asset('images/file-icon.png');
    }

    // ==================== SCOPES ====================

    public function scopeByProyecto($query, $proyectoId)
    {
        if ($proyectoId) {
            return $query->where('proyecto_id', $proyectoId);
        }
        return $query;
    }

    public function scopeByCategoria($query, $categoria)
    {
        if ($categoria && $categoria !== 'todos') {
            return $query->where('categoria', $categoria);
        }
        return $query;
    }

    public function scopeByRangoFechas($query, $fechaInicio, $fechaFin)
    {
        if ($fechaInicio && $fechaFin) {
            return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }
        return $query;
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopeArchivados($query)
    {
        return $query->where('estado', 'archivado');
    }

    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where(function($q) use ($termino) {
                $q->where('titulo', 'LIKE', "%{$termino}%")
                  ->orWhere('descripcion', 'LIKE', "%{$termino}%")
                  ->orWhere('nombre_original', 'LIKE', "%{$termino}%")
                  ->orWhereHas('proyecto', function($sub) use ($termino) {
                      $sub->where('nombre', 'LIKE', "%{$termino}%")
                          ->orWhere('codigo', 'LIKE', "%{$termino}%");
                  });
            });
        }
        return $query;
    }

    public function scopeByFecha($query, $fecha)
    {
        if ($fecha) {
            return $query->whereDate('fecha', $fecha);
        }
        return $query;
    }

    // ==================== MÉTODOS DE NEGOCIO ====================

    public function esActivo(): bool
    {
        return $this->estado === 'activo';
    }

    public function esArchivado(): bool
    {
        return $this->estado === 'archivado';
    }

    public function archivar(): bool
    {
        $this->estado = 'archivado';
        return $this->save();
    }

    public function restaurar(): bool
    {
        $this->estado = 'activo';
        return $this->save();
    }

    public function getPathAttribute(): string
    {
        return storage_path('app/public/' . $this->ruta);
    }

    public function getPublicPathAttribute(): string
    {
        return Storage::disk('public')->path($this->ruta);
    }

    public function existsInStorage(): bool
    {
        return Storage::disk('public')->exists($this->ruta);
    }

    public function deleteFile(): bool
    {
        if ($this->existsInStorage()) {
            return Storage::disk('public')->delete($this->ruta);
        }
        return false;
    }

    // ==================== EVENTOS ====================

    protected static function booted()
    {
        static::creating(function ($foto) {
            if (!$foto->created_by) {
                $foto->created_by = auth()->id();
            }
            
            if (!$foto->fecha) {
                $foto->fecha = now();
            }
        });

        static::deleted(function ($foto) {
            // Eliminar el archivo físico al eliminar el registro
            $foto->deleteFile();
        });
    }
}