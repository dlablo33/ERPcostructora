<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Plantilla extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'plantillas';
    protected $primaryKey = 'plantilla_id';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'correo',
        'celular',
        'numero_seguro_social',
        'rfc',
        'curp',
        'alias',
        'calle',
        'num_exterior',
        'num_interior',
        'satcat_paises_clave',
        'satcat_codigos_postales_codigo_postal',
        'satcat_estados_clave',
        'satcat_municipios_clave',
        'satcat_colonias_clave',
        'satcat_localidades_clave',
        'cat_area_id',
        'cat_puesto_id',
        'sueldo',
        'fecha_ingreso',
        'reclutador',
        'fecha_baja',
        'motivo_baja_id',
        'operador',
        'cat_tipo_operador_id',
        'cat_tipo_licencia_id',
        'numero_licencia',
        'licencia_reconocimiento',
        'contacto_emergencia',
        'numero_emergencia',
        'empresa_id',
        'borrado_logico',
        'estatus',
        'vencimiento_licencia',
        'cat_tipo_cuenta_id',
        'cuenta',
        'propietario',
        'municipio',
        'estado',
        'satcat_figura_transporte_clave',
        'cat_bancos_clave',
        'cuenta_sucursal',
        'monto_mensual_imss',
        'monto_diario_imss',
        'monto_mensual_infonavit',
        'monto_diario_infonavit',
        'monto_mensual_isr',
        'monto_diario_isr',
        'sueldo_hora',
        'numero_medicina_preventiva',
        'satcat_colonias_claveopen',
        'cuenta_contable_sat_id',
        'dias_vacaciones',
        'prima_vacacional',
        'aguinaldo',
        'sueldo_diario',
        'sueldo_integrado',
        'satcat_nomina_contratos_clave',
        'satcat_nomina_jornadas_clave',
        'satcat_nomina_periodicidades_clave',
        'satcat_nomina_regimenes_clave',
        'propietario_tipo',
        'razon_social',
        'datos_generales_id',
        'estatus_seguro_social',
        'bono_asistencia',
        'bono_productividad',
        'sueldo_canacar',
        'pension_alimenticia',
        'reserva',
        'numero_empleado_interno',
        'bono_federal',
        'bono_administrativo',
        'aplica_asistencia',
        'fonacot',
        'nomina_percepciones',
        'nomina_deducciones',
        'nomina_otros_pagos',
        'nomina_total',
        'password',
        'coordinador_plantilla_id',
        '__userId__',
        'pagar_por_liquidacion',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_ingreso' => 'date',
        'fecha_baja' => 'date',
        'vencimiento_licencia' => 'date',
        'operador' => 'boolean',
        'borrado_logico' => 'boolean',
        'bono_asistencia' => 'boolean',
        'bono_productividad' => 'boolean',
        'pension_alimenticia' => 'boolean',
        'reserva' => 'boolean',
        'bono_federal' => 'boolean',
        'bono_administrativo' => 'boolean',
        'aplica_asistencia' => 'boolean',
        'fonacot' => 'boolean',
        'pagar_por_liquidacion' => 'boolean',
        'nomina_percepciones' => 'array',
        'nomina_deducciones' => 'array',
        'nomina_otros_pagos' => 'array',
        'sueldo' => 'decimal:2',
        'sueldo_hora' => 'decimal:2',
        'sueldo_diario' => 'decimal:2',
        'sueldo_integrado' => 'decimal:2',
        'sueldo_canacar' => 'decimal:2',
        'monto_mensual_imss' => 'decimal:2',
        'monto_diario_imss' => 'decimal:2',
        'monto_mensual_infonavit' => 'decimal:2',
        'monto_diario_infonavit' => 'decimal:2',
        'monto_mensual_isr' => 'decimal:2',
        'monto_diario_isr' => 'decimal:2',
        'nomina_total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ============================================
    // RELACIONES
    // ============================================

    // ✅ Usar cat_area_id con id
    public function area()
    {
        return $this->belongsTo(Area::class, 'cat_area_id', 'id');
    }

    // ✅ Usar cat_puesto_id con id
    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'cat_puesto_id', 'id');
    }

    // Relación con Tipo de Operador
    public function tipoOperador()
    {
        return $this->belongsTo(CatTipoOperador::class, 'cat_tipo_operador_id', 'id');
    }

    // Relación con Tipo de Licencia
    public function tipoLicencia()
    {
        return $this->belongsTo(CatTipoLicencia::class, 'cat_tipo_licencia_id', 'id');
    }

    // Relación con Banco
    public function banco()
    {
        return $this->belongsTo(CatBanco::class, 'cat_bancos_clave', 'clave');
    }

    // Relación con Tipo de Cuenta
    public function tipoCuenta()
    {
        return $this->belongsTo(CatTipoCuenta::class, 'cat_tipo_cuenta_id', 'id');
    }

    // Relación con País
    public function pais()
    {
        return $this->belongsTo(SatcatPais::class, 'satcat_paises_clave', 'clave');
    }

    // Relación con Estado
    public function estadoRel()
    {
        return $this->belongsTo(SatcatEstado::class, 'satcat_estados_clave', 'clave');
    }

    // Relación con Municipio
    public function municipioRel()
    {
        return $this->belongsTo(SatcatMunicipio::class, 'satcat_municipios_clave', 'clave');
    }

    // Relación con Colonia
    public function colonia()
    {
        return $this->belongsTo(SatcatColonia::class, 'satcat_colonias_clave', 'clave');
    }

    // Relación con Localidad
    public function localidad()
    {
        return $this->belongsTo(SatcatLocalidad::class, 'satcat_localidades_clave', 'clave');
    }

    // Relación con Código Postal
    public function codigoPostal()
    {
        return $this->belongsTo(SatcatCodigoPostal::class, 'satcat_codigos_postales_codigo_postal', 'codigo_postal');
    }

    // Relación con Tipo de Contrato SAT
    public function tipoContrato()
    {
        return $this->belongsTo(SatcatNominaContrato::class, 'satcat_nomina_contratos_clave', 'clave');
    }

    // Relación con Tipo de Jornada SAT
    public function tipoJornada()
    {
        return $this->belongsTo(SatcatNominaJornada::class, 'satcat_nomina_jornadas_clave', 'clave');
    }

    // Relación con Periodicidad de Pago SAT
    public function periodicidadPago()
    {
        return $this->belongsTo(SatcatNominaPeriodicidad::class, 'satcat_nomina_periodicidades_clave', 'clave');
    }

    // Relación con Régimen SAT
    public function regimen()
    {
        return $this->belongsTo(SatcatNominaRegimen::class, 'satcat_nomina_regimenes_clave', 'clave');
    }

    // Relación con Figura de Transporte SAT
    public function figuraTransporte()
    {
        return $this->belongsTo(SatcatFiguraTransporte::class, 'satcat_figura_transporte_clave', 'clave');
    }

    // ✅ Relación con Coordinador usando plantilla_id
    public function coordinador()
    {
        return $this->belongsTo(Plantilla::class, 'coordinador_plantilla_id', 'plantilla_id');
    }

    // ✅ Relación inversa con coordinados
    public function coordinados()
    {
        return $this->hasMany(Plantilla::class, 'coordinador_plantilla_id', 'plantilla_id');
    }

    // ✅ Relación con Nóminas
    public function nominas(): HasMany
    {
        return $this->hasMany(Nomina::class, 'empleado_id', 'plantilla_id');
    }

    // ✅ Relación con Nóminas pagadas
    public function nominasPagadas(): HasMany
    {
        return $this->hasMany(Nomina::class, 'empleado_id', 'plantilla_id')
                    ->where('estatus', 'Pagada');
    }

    // ✅ Relación con Nóminas calculadas
    public function nominasCalculadas(): HasMany
    {
        return $this->hasMany(Nomina::class, 'empleado_id', 'plantilla_id')
                    ->where('estatus', 'Calculada');
    }

    // ════════════════════════════════════════════════════════════
    // ✅ RELACIONES CON PROYECTOS
    // ════════════════════════════════════════════════════════════

    /**
     * Relación con Proyectos a través de la tabla asignacion_personal
     * Un empleado puede estar asignado a múltiples proyectos
     */
    public function proyectos(): BelongsToMany
    {
        return $this->belongsToMany(Proyecto::class, 'asignacion_personal', 'plantilla_id', 'proyecto_id')
                    ->withPivot('id', 'fecha_inicio', 'fecha_fin', 'estatus', 'puesto_id', 'sueldo_asignado', 'observaciones')
                    ->withTimestamps();
    }

    /**
     * Relación con Proyectos activos actuales
     * Filtra solo asignaciones activas y sin fecha de fin o con fecha de fin futura
     */
    public function proyectosActivos(): BelongsToMany
    {
        return $this->belongsToMany(Proyecto::class, 'asignacion_personal', 'plantilla_id', 'proyecto_id')
                    ->wherePivot('estatus', 'activo')
                    ->where(function($q) {
                        $q->whereNull('pivot.fecha_fin')
                          ->orWhere('pivot.fecha_fin', '>=', now()->toDateString());
                    })
                    ->withPivot('id', 'fecha_inicio', 'fecha_fin', 'estatus', 'puesto_id', 'sueldo_asignado')
                    ->withTimestamps();
    }

    /**
     * Obtener el proyecto actual del empleado (el más reciente activo)
     */
    public function getProyectoActualAttribute()
    {
        return $this->proyectosActivos()
                    ->latest('pivot.fecha_inicio')
                    ->first();
    }

    /**
     * Verificar si el empleado está asignado a un proyecto específico
     */
    public function estaAsignadoAProyecto($proyectoId): bool
    {
        return $this->proyectosActivos()
                    ->where('proyectos.id', $proyectoId)
                    ->exists();
    }

    /**
     * Obtener todos los proyectos donde el empleado ha estado asignado (historial completo)
     */
    public function historialProyectos(): BelongsToMany
    {
        return $this->belongsToMany(Proyecto::class, 'asignacion_personal', 'plantilla_id', 'proyecto_id')
                    ->withPivot('id', 'fecha_inicio', 'fecha_fin', 'estatus', 'puesto_id', 'sueldo_asignado', 'observaciones')
                    ->withTimestamps()
                    ->orderBy('pivot.fecha_inicio', 'desc');
    }

    /**
     * Obtener el proyecto principal (el que más tiempo ha estado asignado)
     */
    public function getProyectoPrincipalAttribute()
    {
        return $this->proyectos()
                    ->withPivot('fecha_inicio', 'fecha_fin')
                    ->get()
                    ->sortByDesc(function($proyecto) {
                        $inicio = $proyecto->pivot->fecha_inicio;
                        $fin = $proyecto->pivot->fecha_fin ?? now();
                        return $inicio->diffInDays($fin);
                    })
                    ->first();
    }

    /**
     * Obtener lista de proyectos del empleado como string (para mostrar)
     * ✅ CON MANEJO DE ERRORES
     */
    public function getProyectosListaAttribute()
    {
        try {
            $proyectos = $this->proyectosActivos;
            if ($proyectos && $proyectos->count() > 0) {
                return $proyectos->pluck('nombre')->implode(', ');
            }
            return 'Sin proyectos activos';
        } catch (\Exception $e) {
            Log::warning('Error al obtener proyectos para empleado ' . $this->plantilla_id . ': ' . $e->getMessage());
            return 'No disponible';
        }
    }

    /**
     * Obtener IDs de proyectos activos como array
     */
    public function getProyectosActivosIdsAttribute()
    {
        try {
            return $this->proyectosActivos->pluck('id')->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    // Relación con Documentos
    public function documentos()
    {
        return $this->hasMany(EmpleadoDocumento::class, 'plantilla_id', 'plantilla_id');
    }

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relación con Asistencias
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'plantilla_id', 'plantilla_id');
    }

    // ============================================
    // SCOPES
    // ============================================

    // Scope para DataGrid (vista principal)
    public function scopeDataGrid($query)
    {
        return $query->select(
            'plantillas.*',
            'areas.nombre as area_nombre',
            'puestos.nombre as puesto_nombre'
        )
        ->selectRaw(
            "CONCAT(plantillas.nombre, ' ', COALESCE(plantillas.apellido_paterno, ''), ' ', COALESCE(plantillas.apellido_materno, '')) AS nombre_completo,
            CASE 
                WHEN plantillas.estatus = '1' OR plantillas.estatus = 'Activo' THEN 'Activo'
                WHEN plantillas.estatus = '0' OR plantillas.estatus = 'Inactivo' THEN 'Inactivo'
                WHEN plantillas.estatus = 'Vacaciones' THEN 'Vacaciones'
                WHEN plantillas.estatus = 'Baja' THEN 'Baja'
                ELSE 'Activo'
            END AS estatus_txt,
            CASE WHEN plantillas.operador = true THEN 'Sí' ELSE 'No' END AS is_operador"
        )
        ->leftJoin('areas', 'plantillas.cat_area_id', '=', 'areas.id')
        ->leftJoin('puestos', 'plantillas.cat_puesto_id', '=', 'puestos.id');
    }

    // Scope para búsqueda
    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where(function($q) use ($termino) {
                $q->where('plantillas.nombre', 'LIKE', "%{$termino}%")
                  ->orWhere('plantillas.apellido_paterno', 'LIKE', "%{$termino}%")
                  ->orWhere('plantillas.apellido_materno', 'LIKE', "%{$termino}%")
                  ->orWhere('plantillas.rfc', 'LIKE', "%{$termino}%")
                  ->orWhere('plantillas.curp', 'LIKE', "%{$termino}%")
                  ->orWhere('plantillas.numero_empleado_interno', 'LIKE', "%{$termino}%")
                  ->orWhere('plantillas.correo', 'LIKE', "%{$termino}%")
                  ->orWhereRaw("CONCAT(plantillas.nombre, ' ', COALESCE(plantillas.apellido_paterno, ''), ' ', COALESCE(plantillas.apellido_materno, '')) LIKE ?", ["%{$termino}%"]);
            });
        }
        return $query;
    }

    // Scope para activos
    public function scopeActivos($query)
    {
        return $query->whereIn('plantillas.estatus', ['1', 'Activo']);
    }

    // Scope para inactivos
    public function scopeInactivos($query)
    {
        return $query->whereIn('plantillas.estatus', ['0', 'Inactivo', 'Baja']);
    }

    // Scope para operadores
    public function scopeOperadores($query)
    {
        return $query->where('plantillas.operador', true);
    }

    // Scope para administrativos
    public function scopeAdministrativos($query)
    {
        return $query->where('plantillas.operador', false);
    }

    // Scope para filtrar por área
    public function scopePorArea($query, $areaId)
    {
        if ($areaId) {
            return $query->where('plantillas.cat_area_id', $areaId);
        }
        return $query;
    }

    // Scope para filtrar por puesto
    public function scopePorPuesto($query, $puestoId)
    {
        if ($puestoId) {
            return $query->where('plantillas.cat_puesto_id', $puestoId);
        }
        return $query;
    }

    // Scope para filtrar por banco
    public function scopePorBanco($query, $bancoClave)
    {
        if ($bancoClave) {
            return $query->where('plantillas.cat_bancos_clave', $bancoClave);
        }
        return $query;
    }

    // Scope para filtrar por tipo de cuenta
    public function scopePorTipoCuenta($query, $tipoCuentaId)
    {
        if ($tipoCuentaId) {
            return $query->where('plantillas.cat_tipo_cuenta_id', $tipoCuentaId);
        }
        return $query;
    }

    // ✅ Scope para filtrar por estatus de nómina
    public function scopeConNominas($query, $estatus = null)
    {
        return $query->with(['nominas' => function($q) use ($estatus) {
            if ($estatus) {
                $q->where('estatus', $estatus);
            }
        }]);
    }

    // ✅ Scope para filtrar empleados por proyecto
    public function scopePorProyecto($query, $proyectoId)
    {
        if ($proyectoId) {
            return $query->whereHas('proyectosActivos', function($q) use ($proyectoId) {
                $q->where('proyecto_id', $proyectoId);
            });
        }
        return $query;
    }

    // ✅ Scope para filtrar empleados que NO están en ningún proyecto
    public function scopeSinProyecto($query)
    {
        return $query->whereDoesntHave('proyectosActivos');
    }

    // ✅ Scope para filtrar empleados por múltiples proyectos
    public function scopePorProyectos($query, $proyectosIds)
    {
        if (is_array($proyectosIds) && count($proyectosIds) > 0) {
            return $query->whereHas('proyectosActivos', function($q) use ($proyectosIds) {
                $q->whereIn('proyecto_id', $proyectosIds);
            });
        }
        return $query;
    }

    // ============================================
    // ACCESORES
    // ============================================

    // Obtener nombre completo
    public function getNombreCompletoAttribute()
    {
        return trim($this->nombre . ' ' . $this->apellido_paterno . ' ' . $this->apellido_materno);
    }

    // Obtener nombre corto
    public function getNombreCortoAttribute()
    {
        return trim($this->nombre . ' ' . $this->apellido_paterno);
    }

    // Obtener iniciales
    public function getInicialesAttribute()
    {
        $iniciales = '';
        if ($this->nombre) $iniciales .= $this->nombre[0];
        if ($this->apellido_paterno) $iniciales .= $this->apellido_paterno[0];
        if ($this->apellido_materno) $iniciales .= $this->apellido_materno[0];
        return strtoupper($iniciales);
    }

    // Obtener edad
    public function getEdadAttribute()
    {
        if ($this->fecha_nacimiento) {
            return $this->fecha_nacimiento->age;
        }
        return null;
    }

    // Obtener antigüedad en años
    public function getAntiguedadAttribute()
    {
        if ($this->fecha_ingreso) {
            return $this->fecha_ingreso->diffInYears(now());
        }
        return null;
    }

    // Obtener estatus en texto
    public function getEstatusTxtAttribute()
    {
        $estatusMap = [
            '1' => 'Activo',
            '0' => 'Inactivo',
            'Activo' => 'Activo',
            'Inactivo' => 'Inactivo',
            'Vacaciones' => 'Vacaciones',
            'Baja' => 'Baja'
        ];
        
        return $estatusMap[$this->estatus] ?? 'Activo';
    }

    // Obtener si es operador en texto
    public function getIsOperadorAttribute()
    {
        return $this->operador ? 'Sí' : 'No';
    }

    // Obtener nombre del banco
    public function getBancoNombreAttribute()
    {
        return $this->banco ? $this->banco->nombre_corto : '-';
    }

    // Obtener nombre del tipo de cuenta
    public function getTipoCuentaNombreAttribute()
    {
        return $this->tipoCuenta ? $this->tipoCuenta->descripcion : '-';
    }

    // Obtener nombre del área
    public function getAreaNombreAttribute()
    {
        return $this->area ? $this->area->nombre : '-';
    }

    // Obtener nombre del puesto
    public function getPuestoNombreAttribute()
    {
        return $this->puesto ? $this->puesto->nombre : '-';
    }

    // Obtener nombre del coordinador
    public function getCoordinadorNombreAttribute()
    {
        return $this->coordinador ? $this->coordinador->nombre_completo : '-';
    }

    // Obtener sueldo diario calculado
    public function getSueldoDiarioCalculadoAttribute()
    {
        if ($this->sueldo_diario && $this->sueldo_diario > 0) {
            return $this->sueldo_diario;
        }
        if ($this->sueldo && $this->sueldo > 0) {
            return $this->sueldo / 30;
        }
        return 0;
    }

    // Obtener sueldo mensual calculado
    public function getSueldoMensualCalculadoAttribute()
    {
        if ($this->sueldo && $this->sueldo > 0) {
            return $this->sueldo;
        }
        if ($this->sueldo_diario && $this->sueldo_diario > 0) {
            return $this->sueldo_diario * 30;
        }
        return 0;
    }

    // ============================================
    // MUTADORES
    // ============================================

    // Asegurar que el estatus siempre sea string
    public function setEstatusAttribute($value)
    {
        $this->attributes['estatus'] = (string) $value;
    }

    // Formatear sueldo al guardar
    public function setSueldoAttribute($value)
    {
        $this->attributes['sueldo'] = str_replace(',', '', $value);
    }

    // Asegurar que el RFC sea mayúscula
    public function setRfcAttribute($value)
    {
        $this->attributes['rfc'] = $value ? strtoupper(trim($value)) : null;
    }

    // Asegurar que el CURP sea mayúscula
    public function setCurpAttribute($value)
    {
        $this->attributes['curp'] = $value ? strtoupper(trim($value)) : null;
    }

    // Asegurar que el correo sea minúscula
    public function setCorreoAttribute($value)
    {
        $this->attributes['correo'] = $value ? strtolower(trim($value)) : null;
    }

    // Asegurar que el nombre esté capitalizado
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = $value ? ucwords(strtolower(trim($value))) : null;
    }

    // Asegurar que los apellidos estén capitalizados
    public function setApellidoPaternoAttribute($value)
    {
        $this->attributes['apellido_paterno'] = $value ? ucwords(strtolower(trim($value))) : null;
    }

    public function setApellidoMaternoAttribute($value)
    {
        $this->attributes['apellido_materno'] = $value ? ucwords(strtolower(trim($value))) : null;
    }

    // ============================================
    // MÉTODOS ÚTILES
    // ============================================

    /**
     * Verificar si el empleado está activo
     */
    public function isActivo(): bool
    {
        return in_array($this->estatus, ['1', 'Activo']);
    }

    /**
     * Verificar si el empleado es operador
     */
    public function isOperador(): bool
    {
        return (bool) $this->operador;
    }

    /**
     * Verificar si el empleado es propietario
     */
    public function isPropietario(): bool
    {
        return (bool) $this->propietario;
    }

    /**
     * Verificar si tiene licencia vigente
     */
    public function tieneLicenciaVigente(): bool
    {
        if (!$this->vencimiento_licencia) return false;
        return $this->vencimiento_licencia->isFuture();
    }

    /**
     * Generar número de empleado automático
     */
    public static function generarNumeroEmpleado()
    {
        $ultimo = self::orderBy('numero_empleado_interno', 'desc')
            ->whereNotNull('numero_empleado_interno')
            ->first();
        
        if (!$ultimo || !$ultimo->numero_empleado_interno) {
            return 'EMP-0001';
        }
        
        $numero = intval(substr($ultimo->numero_empleado_interno, 4)) + 1;
        return 'EMP-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Calcular total de nóminas del empleado
     */
    public function getTotalNominasAttribute()
    {
        return $this->nominas()->count();
    }

    /**
     * Calcular total pagado al empleado
     */
    public function getTotalPagadoAttribute()
    {
        return $this->nominasPagadas()->sum('neto_pagar');
    }

    /**
     * Asignar el empleado a un proyecto
     */
    public function asignarAProyecto($proyectoId, $data = [])
    {
        $defaultData = [
            'fecha_inicio' => now()->toDateString(),
            'estatus' => 'activo',
            'puesto_id' => $this->cat_puesto_id,
            'sueldo_asignado' => $this->sueldo_diario,
            'observaciones' => null,
        ];

        $data = array_merge($defaultData, $data);

        return $this->proyectos()->attach($proyectoId, $data);
    }

    /**
     * Desasignar el empleado de un proyecto
     */
    public function desasignarDeProyecto($proyectoId, $fechaFin = null)
    {
        $fechaFin = $fechaFin ?? now()->toDateString();
        
        return $this->proyectos()
                    ->wherePivot('proyecto_id', $proyectoId)
                    ->updateExistingPivot($proyectoId, [
                        'fecha_fin' => $fechaFin,
                        'estatus' => 'inactivo'
                    ]);
    }

    /**
     * Reactivar el empleado en un proyecto
     */
    public function reactivarEnProyecto($proyectoId, $data = [])
    {
        $defaultData = [
            'fecha_fin' => null,
            'estatus' => 'activo',
        ];

        $data = array_merge($defaultData, $data);

        return $this->proyectos()
                    ->wherePivot('proyecto_id', $proyectoId)
                    ->updateExistingPivot($proyectoId, $data);
    }

    /**
     * Obtener el ID del proyecto actual (si solo puede estar en uno)
     */
    public function getProyectoActualIdAttribute()
    {
        $proyecto = $this->proyecto_actual;
        return $proyecto ? $proyecto->id : null;
    }

    // ============================================
    // BOOT
    // ============================================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generar número de empleado si no tiene
            if (empty($model->numero_empleado_interno)) {
                $model->numero_empleado_interno = self::generarNumeroEmpleado();
            }
            
            // Establecer estatus por defecto
            if (empty($model->estatus)) {
                $model->estatus = 'Activo';
            }
        });

        static::updating(function ($model) {
            // Si se cambia el estatus a Baja, registrar fecha de baja
            if ($model->isDirty('estatus') && $model->estatus === 'Baja' && empty($model->fecha_baja)) {
                $model->fecha_baja = now();
            }
        });
    }
}