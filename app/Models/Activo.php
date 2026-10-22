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

    /**
     * ✅ Valores EXACTOS que acepta el constraint de la tabla `activos`:
     *   CHECK (estatus IN ('Disponible', 'Asignado', 'En mantenimiento', 'Dado de baja'))
     */
    const ESTATUS = [
        'Disponible'       => 'Disponible',
        'Asignado'         => 'Asignado',
        'En mantenimiento' => 'En Mantenimiento',
        'Dado de baja'     => 'Dado de Baja',
    ];

    const ESTATUS_BADGE = [
        'Disponible'       => 'badge-disponible',
        'Asignado'         => 'badge-asignado',
        'En mantenimiento' => 'badge-mantenimiento',
        'Dado de baja'     => 'badge-baja',
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
            ->whereIn('estatus', ['Activa', 'Parcial'])
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
    
    // ==================== MUTATORS ====================

    /**
     * ✅ FIX CRÍTICO: normaliza el estatus al formato EXACTO que exige
     * el constraint de la tabla `activos`:
     *
     *   CHECK (estatus IN (
     *       'Disponible',
     *       'Asignado',
     *       'En mantenimiento',
     *       'Dado de baja'
     *   ))
     *
     * NUNCA mapear a 'Activa'/'Devuelta'/'Parcial' — esos valores son del
     * constraint de `asignaciones_activos` y aquí rompen el INSERT/UPDATE.
     */
    public function setEstatusAttribute($value)
    {
        $mapa = [
            // variantes minúsculas → valor canónico de `activos`
            'activo'             => 'Disponible',
            'activa'             => 'Disponible',
            'disponible'         => 'Disponible',
            'devuelto'           => 'Disponible',
            'devuelta'           => 'Disponible',
            'asignado'           => 'Asignado',
            'asignada'           => 'Asignado',
            'parcial'            => 'Asignado',
            'mantenimiento'      => 'En mantenimiento',
            'en mantenimiento'   => 'En mantenimiento',
            'en_mantenimiento'   => 'En mantenimiento',
            'inactivo'           => 'Dado de baja',
            'baja'               => 'Dado de baja',
            'dado de baja'       => 'Dado de baja',
            'dado_de_baja'       => 'Dado de baja',
        ];

        $key = strtolower(trim($value ?? 'disponible'));

        // Si el valor ya viene canónico (ej. 'Disponible'), lo respetamos
        if (in_array($value, ['Disponible', 'Asignado', 'En mantenimiento', 'Dado de baja'], true)) {
            $this->attributes['estatus'] = $value;
            return;
        }

        $this->attributes['estatus'] = $mapa[$key] ?? 'Disponible';
    }

    /**
     * ✅ Devuelve el estatus tal cual está en la BD.
     * NO lo convertimos a minúsculas aquí porque necesitamos los valores
     * canónicos con mayúscula para las comparaciones contra el constraint.
     */
    public function getEstatusAttribute($value)
    {
        return $value ?? 'Disponible';
    }

    /**
     * ✅ Normaliza el tipo_activo a minúsculas al guardar.
     */
    public function setTipoActivoAttribute($value)
    {
        $this->attributes['tipo_activo'] = strtolower(trim($value ?? 'equipo'));
    }

    /**
     * ✅ Normaliza el estado_general a minúsculas al guardar.
     */

    
    // ==================== ACCESSORS ====================

    public function getTipoNombreAttribute(): string
    {
        return self::TIPOS_ACTIVO[$this->tipo_activo] ?? ucfirst($this->tipo_activo ?? '');
    }

    public function getEstatusNombreAttribute(): string
    {
        return self::ESTATUS[$this->estatus] ?? $this->estatus;
    }

    public function getEstatusBadgeAttribute(): string
    {
        return self::ESTATUS_BADGE[$this->estatus] ?? 'badge-estatus';
    }

    /**
     * ✅ Devuelve el estatus en minúsculas para comparaciones limpias en JS.
     */
    public function getEstatusNormalizadoAttribute(): string
    {
        return strtolower($this->estatus ?? 'disponible');
    }

    public function getEstadoGeneralNombreAttribute(): string
    {
        $key = strtolower($this->estado_general ?? '');
        return self::ESTADO_GENERAL[$key] ?? ucfirst($key);
    }
    
    public function getNombreCompletoAttribute()
    {
        return $this->codigo . ' - ' . $this->nombre;
    }
    
    /**
     * ✅ Un activo está disponible si su estatus es 'Disponible' y NO tiene proyecto asignado.
     */
    public function getEstaDisponibleAttribute(): bool
    {
        return $this->estatus === 'Disponible'
            && is_null($this->proyecto_asignado_id);
    }
    
    /**
     * ✅ Un activo está asignado si su estatus es 'Asignado' y tiene proyecto.
     */
    public function getEstaAsignadoAttribute(): bool
    {
        return $this->estatus === 'Asignado'
            && !is_null($this->proyecto_asignado_id);
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
    
    /**
     * ✅ Scope de disponibles.
     */
    public function scopeDisponibles($query)
    {
        return $query->where('estatus', 'Disponible')
            ->whereNull('proyecto_asignado_id');
    }
    
    /**
     * ✅ Scope de asignados.
     */
    public function scopeAsignados($query)
    {
        return $query->where('estatus', 'Asignado')
            ->whereNotNull('proyecto_asignado_id');
    }

    /**
     * ✅ Scope en mantenimiento.
     */
    public function scopeEnMantenimiento($query)
    {
        return $query->where('estatus', 'En mantenimiento');
    }
    
    public function scopePorTipo($query, $tipo)
    {
        if ($tipo) {
            return $query->where('tipo_activo', $tipo);
        }
        return $query;
    }

    /**
     * ✅ Scope por estatus: acepta variantes y las normaliza al valor canónico.
     */
    public function scopeByEstatus($query, $estatus)
    {
        if (!$estatus) return $query;

        $mapa = [
            'activo'            => 'Disponible',
            'activa'            => 'Disponible',
            'disponible'        => 'Disponible',
            'asignado'          => 'Asignado',
            'asignada'          => 'Asignado',
            'mantenimiento'     => 'En mantenimiento',
            'en mantenimiento'  => 'En mantenimiento',
            'en_mantenimiento'  => 'En mantenimiento',
            'baja'              => 'Dado de baja',
            'dado de baja'      => 'Dado de baja',
            'inactivo'          => 'Dado de baja',
        ];

        $key = strtolower(trim($estatus));
        $valor = $mapa[$key] ?? $estatus;

        return $query->where('estatus', $valor);
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
                $q->where('codigo', 'ILIKE', "%{$termino}%")
                  ->orWhere('nombre', 'ILIKE', "%{$termino}%")
                  ->orWhere('marca', 'ILIKE', "%{$termino}%")
                  ->orWhere('modelo', 'ILIKE', "%{$termino}%")
                  ->orWhere('serie', 'ILIKE', "%{$termino}%");
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

    /**
     * ✅ Cambia el estatus validando contra los valores canónicos.
     */
    public function cambiarEstatus(string $nuevoEstatus): bool
    {
        $mapa = [
            'activo'            => 'Disponible',
            'disponible'        => 'Disponible',
            'asignado'          => 'Asignado',
            'mantenimiento'     => 'En mantenimiento',
            'en mantenimiento'  => 'En mantenimiento',
            'baja'              => 'Dado de baja',
            'dado de baja'      => 'Dado de baja',
        ];
        $key = strtolower(trim($nuevoEstatus));
        $this->estatus = $mapa[$key] ?? 'Disponible';
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
        $this->estatus = 'Asignado';
        return $this->save();
    }

    public function liberarDeProyecto(): bool
    {
        $this->proyecto_asignado_id = null;
        $this->fecha_asignacion = null;
        $this->responsable_asignado_id = null;
        $this->estatus = 'Disponible';
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

    public function setEstadoGeneralAttribute($value)
{
    $map = [
        'excelente'     => 'Excelente',
        'bueno'         => 'Bueno',
        'regular'       => 'Regular',
        'malo'          => 'Malo',
        'en reparacion' => 'En reparacion',
        'en_reparacion' => 'En reparacion',
        'enreparacion'  => 'En reparacion',
    ];
    $key = strtolower(trim((string) $value));
    $this->attributes['estado_general'] = $map[$key] ?? 'Bueno';
}
}