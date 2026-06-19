<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cuadrilla extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cuadrillas';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'especialidad',
        'proyecto_id',
        'encargado_id',
        'integrantes',
        'estatus',
        'observaciones',
        'created_by'
    ];

    protected $casts = [
        'integrantes' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'especialidad_nombre',
        'especialidad_icono',
        'especialidad_badge',
        'estatus_nombre',
        'estatus_badge',
        'total_integrantes',
        'nombre_encargado'
    ];

    // ==================== CATÁLOGOS ====================

    const ESPECIALIDADES = [
        'cimentacion' => 'Cimentación',
        'estructura' => 'Estructura',
        'acabados' => 'Acabados',
        'instalaciones' => 'Instalaciones',
        'obra_negra' => 'Obra Negra',
        'albanileria' => 'Albañilería',
        'herreria' => 'Herrería',
        'electricidad' => 'Electricidad',
        'plomeria' => 'Plomería',
        'pintura' => 'Pintura'
    ];

    const ESPECIALIDADES_ICONOS = [
        'cimentacion' => 'fa-archway',
        'estructura' => 'fa-building',
        'acabados' => 'fa-paint-roller',
        'instalaciones' => 'fa-plug',
        'obra_negra' => 'fa-hard-hat',
        'albanileria' => 'fa-hammer',
        'herreria' => 'fa-wrench',
        'electricidad' => 'fa-bolt',
        'plomeria' => 'fa-water',
        'pintura' => 'fa-palette'
    ];

    const ESPECIALIDADES_BADGE = [
        'cimentacion' => 'badge-cimentacion',
        'estructura' => 'badge-estructura',
        'acabados' => 'badge-acabados',
        'instalaciones' => 'badge-instalaciones',
        'obra_negra' => 'badge-obra_negra',
        'albanileria' => 'badge-albanileria',
        'herreria' => 'badge-herreria',
        'electricidad' => 'badge-electricidad',
        'plomeria' => 'badge-plomeria',
        'pintura' => 'badge-pintura'
    ];

    const ESTATUS = [
        'activo' => 'Activo',
        'inactivo' => 'Inactivo'
    ];

    const ESTATUS_BADGE = [
        'activo' => 'badge-activo',
        'inactivo' => 'badge-inactivo'
    ];

    // ==================== RELACIONES ====================

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function encargado()
    {
        return $this->belongsTo(Plantilla::class, 'encargado_id', 'plantilla_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'cuadrilla_id');
    }

    public function empleados()
    {
        return $this->belongsToMany(Plantilla::class, 'cuadrilla_empleados', 'cuadrilla_id', 'empleado_id')
            ->withPivot('fecha_asignacion', 'activo')
            ->withTimestamps();
    }

    // ==================== ACCESSORS ====================

    public function getEspecialidadNombreAttribute(): string
    {
        return self::ESPECIALIDADES[$this->especialidad] ?? $this->especialidad;
    }

    public function getEspecialidadIconoAttribute(): string
    {
        return self::ESPECIALIDADES_ICONOS[$this->especialidad] ?? 'fa-users';
    }

    public function getEspecialidadBadgeAttribute(): string
    {
        return self::ESPECIALIDADES_BADGE[$this->especialidad] ?? 'badge-especialidad';
    }

    public function getEstatusNombreAttribute(): string
    {
        return self::ESTATUS[$this->estatus] ?? $this->estatus;
    }

    public function getEstatusBadgeAttribute(): string
    {
        return self::ESTATUS_BADGE[$this->estatus] ?? 'badge-estatus';
    }

    public function getTotalIntegrantesAttribute(): int
    {
        if ($this->integrantes && is_array($this->integrantes)) {
            return count($this->integrantes);
        }
        return 0;
    }

    public function getNombreEncargadoAttribute(): string
    {
        if ($this->encargado) {
            return trim($this->encargado->nombre . ' ' . 
                       ($this->encargado->apellido_paterno ?? '') . ' ' . 
                       ($this->encargado->apellido_materno ?? ''));
        }
        return 'Sin encargado';
    }

    public function getIntegrantesListaAttribute(): array
    {
        if (!$this->integrantes) {
            return [];
        }
        return is_array($this->integrantes) ? $this->integrantes : json_decode($this->integrantes, true);
    }

    // ==================== SCOPES ====================

    public function scopeActivas($query)
    {
        return $query->where('estatus', 'activo');
    }

    public function scopeInactivas($query)
    {
        return $query->where('estatus', 'inactivo');
    }

    public function scopeByEspecialidad($query, $especialidad)
    {
        if ($especialidad) {
            return $query->where('especialidad', $especialidad);
        }
        return $query;
    }

    public function scopeByProyecto($query, $proyectoId)
    {
        if ($proyectoId) {
            return $query->where('proyecto_id', $proyectoId);
        }
        return $query;
    }

    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where(function($q) use ($termino) {
                $q->where('codigo', 'LIKE', "%{$termino}%")
                  ->orWhere('nombre', 'LIKE', "%{$termino}%")
                  ->orWhereHas('proyecto', function($sub) use ($termino) {
                      $sub->where('nombre', 'LIKE', "%{$termino}%")
                          ->orWhere('codigo', 'LIKE', "%{$termino}%");
                  });
            });
        }
        return $query;
    }

    // ==================== MÉTODOS DE NEGOCIO ====================

    public function esActiva(): bool
    {
        return $this->estatus === 'activo';
    }

    public function esInactiva(): bool
    {
        return $this->estatus === 'inactivo';
    }

    public function agregarIntegrante(int $empleadoId): bool
    {
        $integrantes = $this->integrantes_lista;
        if (!in_array($empleadoId, $integrantes)) {
            $integrantes[] = $empleadoId;
            $this->integrantes = $integrantes;
            return $this->save();
        }
        return false;
    }

    public function removerIntegrante(int $empleadoId): bool
    {
        $integrantes = $this->integrantes_lista;
        $key = array_search($empleadoId, $integrantes);
        if ($key !== false) {
            unset($integrantes[$key]);
            $this->integrantes = array_values($integrantes);
            return $this->save();
        }
        return false;
    }

    public function tieneIntegrante(int $empleadoId): bool
    {
        return in_array($empleadoId, $this->integrantes_lista);
    }

    // ==================== EVENTOS ====================

    protected static function booted()
    {
        static::creating(function ($cuadrilla) {
            if (!$cuadrilla->created_by) {
                $cuadrilla->created_by = auth()->id();
            }
            
            // Generar código si no tiene
            if (!$cuadrilla->codigo) {
                $count = self::withTrashed()->count() + 1;
                $cuadrilla->codigo = 'CUA-' . str_pad($count, 3, '0', STR_PAD_LEFT);
            }
        });
    }
}