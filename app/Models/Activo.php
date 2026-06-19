<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activo extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'activos';
    
    protected $fillable = [
        'codigo',
        'nombre',
        'tipo_activo',
        'categoria',
        'marca',
        'modelo',
        'serie',
        'anio',
        'color',
        'ubicacion_fisica',
        'proyecto_asignado_id',
        'fecha_asignacion',
        'responsable_asignado_id',
        'estado_general',
        'estatus',
        'fecha_adquisicion',
        'costo_adquisicion',
        'costo_operacion_hora',
        'consumo_promedio',
        'valor_actual',
        'proveedor_id',
        'factura',
        'cuenta_contable',
        'descripcion',
        'observaciones',
        'created_by',
        'unidad_negocio_id',
        'fecha_ultimo_mantenimiento',
        'fecha_proximo_mantenimiento'
    ];
    
    protected $casts = [
        'anio' => 'integer',
        'fecha_asignacion' => 'date',
        'fecha_adquisicion' => 'date',
        'fecha_ultimo_mantenimiento' => 'date',
        'fecha_proximo_mantenimiento' => 'date',
        'costo_adquisicion' => 'decimal:2',
        'costo_operacion_hora' => 'decimal:2',
        'consumo_promedio' => 'decimal:2',
        'valor_actual' => 'decimal:2'
    ];

    protected $appends = [
        'tipo_nombre',
        'estatus_nombre',
        'estatus_badge',
        'estado_general_nombre',
        'nombre_completo',
        'esta_disponible',
        'esta_asignado',
        'dias_ultimo_mantenimiento'
    ];

    const TIPOS_ACTIVO = [
        'maquinaria' => 'Maquinaria',
        'vehiculo' => 'Vehículo',
        'herramienta' => 'Herramienta',
        'equipo' => 'Equipo'
    ];

    const ESTATUS = [
        'Disponible' => 'Disponible',
        'Asignado' => 'Asignado', 
        'En mantenimiento' => 'En Mantenimiento',
        'Dado de baja' => 'Dado de Baja'
    ];

    const ESTATUS_BADGE = [
        'activo' => 'badge-activo',
        'inactivo' => 'badge-inactivo',
        'mantenimiento' => 'badge-mantenimiento',
        'baja' => 'badge-baja'
    ];

    const ESTADO_GENERAL = [
        'excelente' => 'Excelente',
        'bueno' => 'Bueno',
        'regular' => 'Regular',
        'malo' => 'Malo',
        'reparacion' => 'En Reparación'
    ];
    
    // ==================== RELACIONES ====================
    
    public function herramienta()
    {
        return $this->hasOne(ActivoHerramienta::class);
    }
    
    public function maquinaria()
    {
        return $this->hasOne(ActivoMaquinaria::class);
    }
    
    public function vehiculo()
    {
        return $this->hasOne(ActivoVehiculo::class);
    }
    
    public function proyectoAsignado()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_asignado_id');
    }
    
    public function responsableAsignado()
    {
        return $this->belongsTo(Plantilla::class, 'responsable_asignado_id', 'plantilla_id');
    }
    
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
    
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function unidadNegocio()
    {
        return $this->belongsTo(CatUnidadNegocio::class, 'unidad_negocio_id', 'cat_unidad_negocio_id');
    }
    
    public function requisiciones()
    {
        return $this->hasMany(RequisicionActivo::class);
    }
    
    public function asignaciones()
    {
        return $this->hasMany(AsignacionActivo::class);
    }
    
    public function asignacionActiva()
    {
        return $this->hasOne(AsignacionActivo::class)
            ->whereIn('estatus', ['activa', 'asignado'])
            ->latest('fecha_salida');
    }
    
    public function movimientos()
    {
        return $this->hasMany(MovimientoActivo::class);
    }

    public function mantenimientos()
    {
        return $this->hasMany(MantenimientoActivo::class);
    }

    public function mantenimientoActivo()
    {
        return $this->hasOne(MantenimientoActivo::class)
            ->where('estatus', 'en_proceso')
            ->latest('fecha_inicio');
    }

    public function combustibles()
    {
        return $this->hasMany(CombustibleActivo::class);
    }
    
    // ==================== ACCESSORS ====================

    public function getTipoNombreAttribute(): string
    {
        return self::TIPOS_ACTIVO[$this->tipo_activo] ?? $this->tipo_activo;
    }

    public function getEstatusNombreAttribute(): string
    {
        return self::ESTATUS[$this->estatus] ?? $this->estatus;
    }

    public function getEstatusBadgeAttribute(): string
    {
        return self::ESTATUS_BADGE[$this->estatus] ?? 'badge-estatus';
    }

    public function getEstadoGeneralNombreAttribute(): string
    {
        return self::ESTADO_GENERAL[$this->estado_general] ?? $this->estado_general;
    }
    
    public function getNombreCompletoAttribute()
    {
        return $this->codigo . ' - ' . $this->nombre;
    }
    
    public function getEstaDisponibleAttribute()
    {
        return $this->estatus === 'activo' && !$this->proyecto_asignado_id;
    }
    
    public function getEstaAsignadoAttribute()
    {
        return $this->estatus === 'activo' && $this->proyecto_asignado_id;
    }

    public function getDiasUltimoMantenimientoAttribute(): ?int
    {
        if (!$this->fecha_ultimo_mantenimiento) {
            return null;
        }
        return now()->diffInDays($this->fecha_ultimo_mantenimiento);
    }

    public function getCostoOperacionFormateadoAttribute(): string
    {
        return '$' . number_format($this->costo_operacion_hora ?? 0, 2);
    }
    
    // ==================== SCOPES ====================
    
    public function scopeDisponibles($query)
    {
        return $query->where('estatus', 'activo')->whereNull('proyecto_asignado_id');
    }
    
    public function scopeAsignados($query)
    {
        return $query->where('estatus', 'activo')->whereNotNull('proyecto_asignado_id');
    }

    public function scopeEnMantenimiento($query)
    {
        return $query->where('estatus', 'mantenimiento');
    }
    
    public function scopePorTipo($query, $tipo)
    {
        if ($tipo) {
            return $query->where('tipo_activo', $tipo);
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

    public function scopeByProyecto($query, $proyectoId)
    {
        if ($proyectoId) {
            return $query->where('proyecto_asignado_id', $proyectoId);
        }
        return $query;
    }

    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where(function($q) use ($termino) {
                $q->where('codigo', 'LIKE', "%{$termino}%")
                  ->orWhere('nombre', 'LIKE', "%{$termino}%")
                  ->orWhere('marca', 'LIKE', "%{$termino}%")
                  ->orWhere('modelo', 'LIKE', "%{$termino}%")
                  ->orWhere('serie', 'LIKE', "%{$termino}%");
            });
        }
        return $query;
    }

    public function scopeByRangoHorometro($query, $min, $max)
    {
        if ($min && $max) {
            return $query->whereHas('maquinaria', function($q) use ($min, $max) {
                $q->whereBetween('horometro_actual', [$min, $max]);
            });
        }
        return $query;
    }
    
    // ==================== MÉTODOS ====================
    
    public function getDatosEspecificos()
    {
        switch ($this->tipo_activo) {
            case 'herramienta':
                return $this->herramienta;
            case 'maquinaria':
                return $this->maquinaria;
            case 'vehiculo':
                return $this->vehiculo;
            default:
                return null;
        }
    }

    public function esMaquinaria(): bool
    {
        return $this->tipo_activo === 'maquinaria';
    }

    public function esVehiculo(): bool
    {
        return $this->tipo_activo === 'vehiculo';
    }

    public function esHerramienta(): bool
    {
        return $this->tipo_activo === 'herramienta';
    }

    public function cambiarEstatus(string $nuevoEstatus): bool
    {
        if (!array_key_exists($nuevoEstatus, self::ESTATUS)) {
            return false;
        }
        $this->estatus = $nuevoEstatus;
        return $this->save();
    }

    public function asignarAProyecto(int $proyectoId, int $responsableId = null): bool
    {
        if ($this->proyecto_asignado_id) {
            return false;
        }

        $this->proyecto_asignado_id = $proyectoId;
        $this->fecha_asignacion = now();
        $this->responsable_asignado_id = $responsableId;
        $this->estatus = 'activo';
        return $this->save();
    }

    public function liberarDeProyecto(): bool
    {
        $this->proyecto_asignado_id = null;
        $this->fecha_asignacion = null;
        $this->responsable_asignado_id = null;
        return $this->save();
    }
    
    public static function generarCodigo($tipoActivo)
    {
        $prefijos = [
            'herramienta' => 'HER',
            'maquinaria' => 'MAQ',
            'vehiculo' => 'VEH',
            'equipo' => 'EQU'
        ];
        
        $prefijo = $prefijos[$tipoActivo] ?? 'ACT';
        
        $ultimo = self::withTrashed()->where('codigo', 'LIKE', "{$prefijo}-%")
            ->orderBy('id', 'desc')
            ->first();
            
        if ($ultimo && $ultimo->codigo) {
            $numero = intval(substr($ultimo->codigo, 4)) + 1;
        } else {
            $numero = 1;
        }
        
        return $prefijo . '-' . str_pad($numero, 5, '0', STR_PAD_LEFT);
    }

    // ==================== EVENTOS ====================

    protected static function booted()
    {
        static::creating(function ($activo) {
            if (!$activo->codigo) {
                $activo->codigo = self::generarCodigo($activo->tipo_activo ?? 'equipo');
            }
            
            if (!$activo->created_by) {
                $activo->created_by = auth()->id();
            }
        });
    }
}