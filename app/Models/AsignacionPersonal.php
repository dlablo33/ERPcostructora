<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class AsignacionPersonal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'asignaciones_personal';

    protected $fillable = [
        'empleado_id',
        'proyecto_id',
        'tipo_personal',
        'rol',
        'fecha_asignacion',
        'fecha_fin',
        'salario_diario',
        'status',
        'observaciones',
        'created_by'
    ];

    protected $casts = [
        'fecha_asignacion' => 'date',
        'fecha_fin' => 'date',
        'salario_diario' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'tipo_nombre',
        'tipo_icono',
        'tipo_badge',
        'status_nombre',
        'status_badge',
        'status_color',
        'nombre_completo',
        'nombre_proyecto',
        'salario_formateado'
    ];

    // ==================== CATÁLOGOS ====================

    const TIPOS_PERSONAL = [
        'obrero' => 'Obrero',
        'operador' => 'Operador',
        'supervisor' => 'Supervisor',
        'ingeniero' => 'Ingeniero',
        'administrativo' => 'Administrativo'
    ];

    const TIPOS_ICONOS = [
        'obrero' => 'fa-hard-hat',
        'operador' => 'fa-tractor',
        'supervisor' => 'fa-clipboard-check',
        'ingeniero' => 'fa-user-graduate',
        'administrativo' => 'fa-user-tie'
    ];

    const TIPOS_BADGE = [
        'obrero' => 'badge-obrero',
        'operador' => 'badge-operador',
        'supervisor' => 'badge-supervisor',
        'ingeniero' => 'badge-ingeniero',
        'administrativo' => 'badge-administrativo'
    ];

    const TIPOS_COLORES = [
        'obrero' => '#2378e1',
        'operador' => '#28a745',
        'supervisor' => '#ffc107',
        'ingeniero' => '#0d6efd',
        'administrativo' => '#6c757d'
    ];

    const STATUS = [
        'activo' => 'Activo',
        'inactivo' => 'Inactivo',
        'vacaciones' => 'Vacaciones',
        'permiso' => 'Permiso'
    ];

    const STATUS_BADGE = [
        'activo' => 'badge-activo',
        'inactivo' => 'badge-inactivo',
        'vacaciones' => 'badge-vacaciones',
        'permiso' => 'badge-permiso'
    ];

    const STATUS_COLORES = [
        'activo' => '#28a745',
        'inactivo' => '#dc3545',
        'vacaciones' => '#ffc107',
        'permiso' => '#6c757d'
    ];

    // ==================== RELACIONES ====================

    public function empleado()
    {
        return $this->belongsTo(Plantilla::class, 'empleado_id', 'plantilla_id');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function historial()
    {
        return $this->hasMany(AsignacionHistorial::class, 'asignacion_id');
    }

    // ==================== ACCESSORS ====================

    public function getTipoNombreAttribute(): string
    {
        return self::TIPOS_PERSONAL[$this->tipo_personal] ?? $this->tipo_personal;
    }

    public function getTipoIconoAttribute(): string
    {
        return self::TIPOS_ICONOS[$this->tipo_personal] ?? 'fa-user';
    }

    public function getTipoBadgeAttribute(): string
    {
        return self::TIPOS_BADGE[$this->tipo_personal] ?? 'badge-tipo';
    }

    public function getTipoColorAttribute(): string
    {
        return self::TIPOS_COLORES[$this->tipo_personal] ?? '#6c757d';
    }

    public function getStatusNombreAttribute(): string
    {
        return self::STATUS[$this->status] ?? $this->status;
    }

    public function getStatusBadgeAttribute(): string
    {
        return self::STATUS_BADGE[$this->status] ?? 'badge-status';
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORES[$this->status] ?? '#6c757d';
    }

    public function getNombreCompletoAttribute(): string
    {
        if (!$this->empleado) {
            return 'Empleado no encontrado';
        }
        return trim($this->empleado->nombre . ' ' . 
                   ($this->empleado->apellido_paterno ?? '') . ' ' . 
                   ($this->empleado->apellido_materno ?? ''));
    }

    public function getNombreProyectoAttribute(): string
    {
        return $this->proyecto?->nombre ?? 'Proyecto no encontrado';
    }

    public function getCodigoProyectoAttribute(): string
    {
        return $this->proyecto?->codigo ?? 'N/A';
    }

    public function getSalarioFormateadoAttribute(): string
    {
        return '$' . number_format($this->salario_diario, 2);
    }

    public function getSalarioMensualAttribute(): float
    {
        // Considerando 24 días laborales al mes
        return $this->salario_diario * 24;
    }

    public function getSalarioMensualFormateadoAttribute(): string
    {
        return '$' . number_format($this->salario_mensual, 2);
    }

    public function getDiasActivoAttribute(): int
    {
        if (!$this->fecha_asignacion) {
            return 0;
        }
        $fin = $this->fecha_fin ?? Carbon::now();
        return Carbon::parse($this->fecha_asignacion)->diffInDays($fin);
    }

    public function getEstaActivoAttribute(): bool
    {
        return $this->status === 'activo';
    }

    // ==================== SCOPES ====================

    public function scopeByProyecto($query, $proyectoId)
    {
        if ($proyectoId) {
            return $query->where('proyecto_id', $proyectoId);
        }
        return $query;
    }

    public function scopeByEmpleado($query, $empleadoId)
    {
        if ($empleadoId) {
            return $query->where('empleado_id', $empleadoId);
        }
        return $query;
    }

    public function scopeByTipo($query, $tipo)
    {
        if ($tipo && $tipo !== 'todos') {
            return $query->where('tipo_personal', $tipo);
        }
        return $query;
    }

    public function scopeByStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeActivos($query)
    {
        return $query->where('status', 'activo');
    }

    public function scopeInactivos($query)
    {
        return $query->where('status', 'inactivo');
    }

    public function scopeEnVacaciones($query)
    {
        return $query->where('status', 'vacaciones');
    }

    public function scopeConPermiso($query)
    {
        return $query->where('status', 'permiso');
    }

    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where(function($q) use ($termino) {
                $q->whereHas('empleado', function($sub) use ($termino) {
                    $sub->where('nombre', 'LIKE', "%{$termino}%")
                        ->orWhere('apellido_paterno', 'LIKE', "%{$termino}%")
                        ->orWhere('apellido_materno', 'LIKE', "%{$termino}%")
                        ->orWhere('numero_empleado_interno', 'LIKE', "%{$termino}%");
                })
                ->orWhereHas('proyecto', function($sub) use ($termino) {
                    $sub->where('nombre', 'LIKE', "%{$termino}%")
                        ->orWhere('codigo', 'LIKE', "%{$termino}%");
                })
                ->orWhere('rol', 'LIKE', "%{$termino}%");
            });
        }
        return $query;
    }

    // ==================== MÉTODOS DE NEGOCIO ====================

    public function esActivo(): bool
    {
        return $this->status === 'activo';
    }

    public function esInactivo(): bool
    {
        return $this->status === 'inactivo';
    }

    public function estaEnVacaciones(): bool
    {
        return $this->status === 'vacaciones';
    }

    public function tienePermiso(): bool
    {
        return $this->status === 'permiso';
    }

    public function cambiarStatus(string $nuevoStatus, string $observaciones = null): bool
    {
        if (!array_key_exists($nuevoStatus, self::STATUS)) {
            return false;
        }

        $statusAnterior = $this->status;
        $this->status = $nuevoStatus;
        
        if ($observaciones) {
            $this->observaciones = $observaciones;
        }

        // Registrar en historial
        $this->registrarHistorial([
            'accion' => 'cambio_status',
            'status_anterior' => $statusAnterior,
            'status_nuevo' => $nuevoStatus,
            'detalles' => $observaciones
        ]);

        return $this->save();
    }

    public function reasignar(int $nuevoProyectoId, string $observaciones = null): bool
    {
        $proyectoAnterior = $this->proyecto_id;
        $this->proyecto_id = $nuevoProyectoId;
        
        if ($observaciones) {
            $this->observaciones = $observaciones;
        }

        // Registrar en historial
        $this->registrarHistorial([
            'accion' => 'cambio_proyecto',
            'proyecto_anterior_id' => $proyectoAnterior,
            'proyecto_nuevo_id' => $nuevoProyectoId,
            'detalles' => $observaciones
        ]);

        return $this->save();
    }

    public function cambiarRol(string $nuevoRol, string $observaciones = null): bool
    {
        $rolAnterior = $this->rol;
        $this->rol = $nuevoRol;
        
        if ($observaciones) {
            $this->observaciones = $observaciones;
        }

        // Registrar en historial
        $this->registrarHistorial([
            'accion' => 'cambio_rol',
            'rol_anterior' => $rolAnterior,
            'rol_nuevo' => $nuevoRol,
            'detalles' => $observaciones
        ]);

        return $this->save();
    }

    public function finalizarAsignacion(string $observaciones = null): bool
    {
        $this->status = 'inactivo';
        $this->fecha_fin = Carbon::now();
        
        if ($observaciones) {
            $this->observaciones = $observaciones;
        }

        $this->registrarHistorial([
            'accion' => 'baja',
            'detalles' => $observaciones ?? 'Asignación finalizada'
        ]);

        return $this->save();
    }

    public function registrarHistorial(array $data): void
    {
        if (!class_exists('App\Models\AsignacionHistorial')) {
            return;
        }

        AsignacionHistorial::create([
            'asignacion_id' => $this->id,
            'usuario_id' => auth()->id(),
            'accion' => $data['accion'],
            'fecha' => Carbon::now(),
            'detalles' => $data['detalles'] ?? null,
            'rol_anterior' => $data['rol_anterior'] ?? null,
            'rol_nuevo' => $data['rol_nuevo'] ?? null,
            'proyecto_anterior_id' => $data['proyecto_anterior_id'] ?? null,
            'proyecto_nuevo_id' => $data['proyecto_nuevo_id'] ?? null,
            'status_anterior' => $data['status_anterior'] ?? null,
            'status_nuevo' => $data['status_nuevo'] ?? null
        ]);
    }

    // ==================== EVENTOS ====================

    protected static function booted()
    {
        static::creating(function ($asignacion) {
            if (!$asignacion->created_by) {
                $asignacion->created_by = auth()->id();
            }
            
            if (!$asignacion->fecha_asignacion) {
                $asignacion->fecha_asignacion = Carbon::now();
            }
        });

        static::created(function ($asignacion) {
            // Registrar historial de creación
            $asignacion->registrarHistorial([
                'accion' => 'asignacion',
                'detalles' => 'Asignación creada: ' . $asignacion->rol
            ]);
        });

        static::saving(function ($asignacion) {
            // Verificar que no haya duplicados activos
            if ($asignacion->status === 'activo') {
                $exists = self::where('empleado_id', $asignacion->empleado_id)
                    ->where('proyecto_id', $asignacion->proyecto_id)
                    ->where('status', 'activo')
                    ->where('id', '!=', $asignacion->id)
                    ->exists();
                
                if ($exists) {
                    throw new \Exception('El empleado ya está activo en este proyecto');
                }
            }
        });
    }
}