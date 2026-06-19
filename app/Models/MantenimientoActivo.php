<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MantenimientoActivo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mantenimientos_activos';

    protected $fillable = [
        'activo_id',
        'proveedor_id',
        'responsable_id',
        'created_by',
        'tipo_mantenimiento',
        'folio',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'costo',
        'horometro_actual',
        'horometro_proximo',
        'dias_proximo',
        'estatus',
        'observaciones'
    ];

    protected $casts = [
        'costo' => 'decimal:2',
        'horometro_actual' => 'decimal:2',
        'horometro_proximo' => 'decimal:2',
        'dias_proximo' => 'integer',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'tipo_nombre',
        'estatus_nombre',
        'estatus_badge',
        'tipo_badge',
        'duracion_dias',
        'nombre_responsable',
        'nombre_proveedor'
    ];

    // ==================== CATÁLOGOS ====================

    const TIPOS = [
        'preventivo' => 'Preventivo',
        'correctivo' => 'Correctivo',
        'predictivo' => 'Predictivo'
    ];

    const ESTATUS = [
        'pendiente' => 'Pendiente',
        'en_proceso' => 'En Proceso',
        'completado' => 'Completado',
        'cancelado' => 'Cancelado'
    ];

    const ESTATUS_BADGE = [
        'pendiente' => 'badge-pendiente',
        'en_proceso' => 'badge-en-proceso',
        'completado' => 'badge-completado',
        'cancelado' => 'badge-cancelado'
    ];

    const TIPOS_BADGE = [
        'preventivo' => 'badge-preventivo',
        'correctivo' => 'badge-correctivo',
        'predictivo' => 'badge-predictivo'
    ];

    // ==================== RELACIONES ====================

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'activo_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function responsable()
    {
        return $this->belongsTo(Plantilla::class, 'responsable_id', 'plantilla_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ==================== ACCESSORS ====================

    public function getTipoNombreAttribute(): string
    {
        return self::TIPOS[$this->tipo_mantenimiento] ?? $this->tipo_mantenimiento;
    }

    public function getEstatusNombreAttribute(): string
    {
        return self::ESTATUS[$this->estatus] ?? $this->estatus;
    }

    public function getEstatusBadgeAttribute(): string
    {
        return self::ESTATUS_BADGE[$this->estatus] ?? 'badge-estatus';
    }

    public function getTipoBadgeAttribute(): string
    {
        return self::TIPOS_BADGE[$this->tipo_mantenimiento] ?? 'badge-tipo';
    }

    public function getDuracionDiasAttribute(): ?int
    {
        if (!$this->fecha_inicio) {
            return null;
        }
        $fin = $this->fecha_fin ?? now();
        return $this->fecha_inicio->diffInDays($fin);
    }

    public function getNombreResponsableAttribute(): string
    {
        if (!$this->responsable) {
            return 'No asignado';
        }
        return trim($this->responsable->nombre . ' ' . 
                   ($this->responsable->apellido_paterno ?? '') . ' ' . 
                   ($this->responsable->apellido_materno ?? ''));
    }

    public function getNombreProveedorAttribute(): string
    {
        return $this->proveedor?->nombre ?? 'No especificado';
    }

    public function getEstaCompletadoAttribute(): bool
    {
        return $this->estatus === 'completado';
    }

    public function getEstaEnProcesoAttribute(): bool
    {
        return $this->estatus === 'en_proceso';
    }

    // ==================== SCOPES ====================

    public function scopeByActivo($query, $activoId)
    {
        if ($activoId) {
            return $query->where('activo_id', $activoId);
        }
        return $query;
    }

    public function scopeByTipo($query, $tipo)
    {
        if ($tipo) {
            return $query->where('tipo_mantenimiento', $tipo);
        }
        return $query;
    }

    public function scopeByEstatus($query, $estatus)
    {
        if ($estatus) {
            return $query->where('estatus', $estatus);
        }
        return $query;
    }

    public function scopePendientes($query)
    {
        return $query->whereIn('estatus', ['pendiente', 'en_proceso']);
    }

    public function scopeCompletados($query)
    {
        return $query->where('estatus', 'completado');
    }

    public function scopeByRangoFechas($query, $fechaInicio, $fechaFin)
    {
        if ($fechaInicio && $fechaFin) {
            return $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin]);
        }
        return $query;
    }

    // ==================== MÉTODOS ====================

    public function iniciar(): bool
    {
        if ($this->estatus !== 'pendiente') {
            return false;
        }
        $this->estatus = 'en_proceso';
        return $this->save();
    }

    public function completar(array $data = null): bool
    {
        if ($this->estatus === 'completado') {
            return false;
        }
        
        $this->estatus = 'completado';
        $this->fecha_fin = now();
        
        if ($data) {
            if (isset($data['horometro_proximo'])) {
                $this->horometro_proximo = $data['horometro_proximo'];
            }
            if (isset($data['observaciones'])) {
                $this->observaciones = $data['observaciones'];
            }
        }
        
        return $this->save();
    }

    public function cancelar(string $motivo = null): bool
    {
        if ($this->estatus === 'completado') {
            return false;
        }
        
        $this->estatus = 'cancelado';
        if ($motivo) {
            $this->observaciones = $motivo;
        }
        return $this->save();
    }

    public function getResumen(): array
    {
        return [
            'id' => $this->id,
            'folio' => $this->folio,
            'activo' => $this->activo?->nombre_completo,
            'tipo' => $this->tipo_nombre,
            'estatus' => $this->estatus_nombre,
            'fecha_inicio' => $this->fecha_inicio?->format('d/m/Y'),
            'costo' => $this->costo,
            'responsable' => $this->nombre_responsable
        ];
    }

    // ==================== EVENTOS ====================

    protected static function booted()
    {
        static::creating(function ($mantenimiento) {
            if (!$mantenimiento->folio) {
                $fecha = now()->format('Ymd');
                $count = self::whereDate('created_at', now()->toDateString())->count() + 1;
                $mantenimiento->folio = 'MANT-' . $fecha . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
            
            if (!$mantenimiento->created_by) {
                $mantenimiento->created_by = auth()->id();
            }
        });

        static::updated(function ($mantenimiento) {
            // Si se completó el mantenimiento, actualizar el activo
            if ($mantenimiento->isDirty('estatus') && $mantenimiento->estatus === 'completado') {
                if ($mantenimiento->activo) {
                    $activo = $mantenimiento->activo;
                    
                    // Actualizar fechas de mantenimiento en el activo
                    $activo->fecha_ultimo_mantenimiento = now();
                    if ($mantenimiento->dias_proximo) {
                        $activo->fecha_proximo_mantenimiento = now()->addDays($mantenimiento->dias_proximo);
                    }
                    
                    // Si estaba en mantenimiento, cambiar a activo
                    if ($activo->estatus === 'mantenimiento') {
                        $activo->estatus = 'activo';
                    }
                    
                    $activo->save();
                    
                    // Actualizar horometros en maquinaria
                    if ($activo->maquinaria && $mantenimiento->horometro_actual) {
                        $activo->maquinaria->horometro_actual = $mantenimiento->horometro_actual;
                        if ($mantenimiento->horometro_proximo) {
                            $activo->maquinaria->horometro_proximo_mantenimiento = $mantenimiento->horometro_proximo;
                        }
                        $activo->maquinaria->save();
                    }
                }
            }
        });
    }
    // ==================== RELACIONES ====================



// AGREGA ESTA RELACIÓN
public function proyecto()
{
    return $this->belongsTo(Proyecto::class, 'proyecto_id');
}




}