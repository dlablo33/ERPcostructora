<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    // Relación con Área
    public function area()
    {
        return $this->belongsTo(Area::class, 'cat_area_id', 'id');
    }

    // Relación con Puesto
    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'cat_puesto_id', 'id');
    }

    // Relación con Tipo de Operador
    public function tipoOperador()
    {
        return $this->belongsTo(CatTipoOperador::class, 'cat_tipo_operador_id');
    }

    // Relación con Tipo de Licencia
    public function tipoLicencia()
    {
        return $this->belongsTo(CatTipoLicencia::class, 'cat_tipo_licencia_id');
    }

    // Relación con Banco (corregida)
    public function banco()
    {
        return $this->belongsTo(CatBanco::class, 'cat_bancos_clave', 'clave');
    }

    // Relación con Tipo de Cuenta
    public function tipoCuenta()
    {
        return $this->belongsTo(CatTipoCuenta::class, 'cat_tipo_cuenta_id');
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

    // Relación con Coordinador (otro empleado)
    public function coordinador()
    {
        return $this->belongsTo(Plantilla::class, 'coordinador_plantilla_id', 'plantilla_id');
    }

    // Relación inversa con coordinados
    public function coordinados()
    {
        return $this->hasMany(Plantilla::class, 'coordinador_plantilla_id', 'plantilla_id');
    }

    // Relación con Documentos
    public function documentos()
    {
        return $this->hasMany(EmpleadoDocumento::class, 'plantilla_id', 'plantilla_id');
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
                $q->where('plantillas.nombre', 'ILIKE', "%{$termino}%")
                  ->orWhere('plantillas.apellido_paterno', 'ILIKE', "%{$termino}%")
                  ->orWhere('plantillas.apellido_materno', 'ILIKE', "%{$termino}%")
                  ->orWhere('plantillas.rfc', 'ILIKE', "%{$termino}%")
                  ->orWhere('plantillas.curp', 'ILIKE', "%{$termino}%")
                  ->orWhere('plantillas.numero_empleado_interno', 'ILIKE', "%{$termino}%")
                  ->orWhere('plantillas.correo', 'ILIKE', "%{$termino}%")
                  ->orWhereRaw("CONCAT(plantillas.nombre, ' ', COALESCE(plantillas.apellido_paterno, ''), ' ', COALESCE(plantillas.apellido_materno, '')) ILIKE ?", ["%{$termino}%"]);
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

    // ============================================
    // ACCESORES
    // ============================================

    // Obtener nombre completo
    public function getNombreCompletoAttribute()
    {
        return trim($this->nombre . ' ' . $this->apellido_paterno . ' ' . $this->apellido_materno);
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
}