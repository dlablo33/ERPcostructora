<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proyecto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'proyectos';
    
    protected $fillable = [
        'codigo',
        'nombre',
        'tipo_proyecto',
        'categoria',
        'prioridad',
        'ubicacion',
        'direccion',
        'fecha_inicio',
        'fecha_fin',
        'descripcion',
        'estado',
        'moneda',
        'tipo_cambio',
        'cliente_nombre',
        'cliente_rfc',
        'cliente_email',
        'cliente_telefono',
        'cliente_contacto',
        'cliente_cargo',
        'numero_contrato',
        'fecha_firma',
        'tipo_contrato',
        'forma_pago',
        'plazo_pago',
        'responsable_id',
        'cargo_responsable',
        'email_responsable',
        'presupuesto_total',
        'anticipo',
        'margen',
        'fondo_reserva',
        'status',
        'created_by'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'fecha_firma' => 'date',
        'presupuesto_total' => 'decimal:2',
        'anticipo' => 'decimal:2',
        'margen' => 'decimal:2',
        'fondo_reserva' => 'decimal:2',
        'tipo_cambio' => 'decimal:4',
    ];

    // ============================================
    // RELACIONES EXISTENTES
    // ============================================

    public function equipo()
    {
        return $this->hasMany(ProyectoEquipo::class, 'proyecto_id');
    }

    public function documentos()
    {
        return $this->hasMany(ProyectoDocumento::class, 'proyecto_id');
    }

    public function costos()
    {
        return $this->hasOne(ProyectoCosto::class, 'proyecto_id');
    }

    public function flujoEfectivo()
    {
        return $this->hasMany(ProyectoFlujoEfectivo::class, 'proyecto_id');
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function cuentasBancarias()
    {
        return $this->hasMany(CuentaBancaria::class);
    }

    public function movimientosBancarios()
    {
        return $this->hasMany(MovimientoBancario::class);
    }

    public function saldosCuentas()
    {
        return $this->hasMany(ProyectoSaldo::class);
    }

    // ============================================
    // ✅ NUEVAS RELACIONES CON EMPLEADOS (Plantilla)
    // ============================================

    /**
     * Relación con empleados (Plantilla) asignados al proyecto
     * a través de la tabla asignacion_personal
     */
    public function empleadosAsignados(): BelongsToMany
    {
        return $this->belongsToMany(Plantilla::class, 'asignacion_personal', 'proyecto_id', 'plantilla_id')
                    ->withPivot('id', 'fecha_inicio', 'fecha_fin', 'estatus', 'puesto_id', 'sueldo_asignado', 'observaciones')
                    ->withTimestamps();
    }

    /**
     * Relación con empleados activos actualmente en el proyecto
     */
    public function empleadosActivos(): BelongsToMany
    {
        return $this->belongsToMany(Plantilla::class, 'asignacion_personal', 'proyecto_id', 'plantilla_id')
                    ->wherePivot('estatus', 'activo')
                    ->where(function($q) {
                        $q->whereNull('pivot.fecha_fin')
                          ->orWhere('pivot.fecha_fin', '>=', now()->toDateString());
                    })
                    ->withPivot('id', 'fecha_inicio', 'fecha_fin', 'estatus', 'puesto_id', 'sueldo_asignado')
                    ->withTimestamps();
    }

    /**
     * Relación con empleados que han estado en el proyecto (historial completo)
     */
    public function empleadosHistorial(): BelongsToMany
    {
        return $this->belongsToMany(Plantilla::class, 'asignacion_personal', 'proyecto_id', 'plantilla_id')
                    ->withPivot('id', 'fecha_inicio', 'fecha_fin', 'estatus', 'puesto_id', 'sueldo_asignado', 'observaciones')
                    ->withTimestamps()
                    ->orderBy('pivot.fecha_inicio', 'desc');
    }

    /**
     * Relación con empleados que estuvieron en el proyecto pero ya no están activos
     */
    public function empleadosInactivos(): BelongsToMany
    {
        return $this->belongsToMany(Plantilla::class, 'asignacion_personal', 'proyecto_id', 'plantilla_id')
                    ->wherePivot('estatus', 'inactivo')
                    ->orWhere('pivot.fecha_fin', '<', now()->toDateString())
                    ->withPivot('id', 'fecha_inicio', 'fecha_fin', 'estatus', 'puesto_id', 'sueldo_asignado')
                    ->withTimestamps();
    }

    /**
     * Verificar si un empleado está asignado al proyecto
     */
    public function tieneEmpleadoAsignado($empleadoId): bool
    {
        return $this->empleadosActivos()
                    ->where('plantillas.plantilla_id', $empleadoId)
                    ->exists();
    }

    /**
     * Obtener el número de empleados activos en el proyecto
     */
    public function getTotalEmpleadosActivosAttribute(): int
    {
        return $this->empleadosActivos()->count();
    }

    /**
     * Obtener el número total de empleados que han estado en el proyecto
     */
    public function getTotalEmpleadosHistorialAttribute(): int
    {
        return $this->empleadosHistorial()->count();
    }

    // ============================================
    // ACCESSORS EXISTENTES
    // ============================================

    public function getMontoAnticipoAttribute()
    {
        return ($this->presupuesto_total * $this->anticipo) / 100;
    }

    public function getUtilidadEstimadaAttribute()
    {
        return ($this->presupuesto_total * $this->margen) / 100;
    }

    public function getCostoTotalAttribute()
    {
        if ($this->costos) {
            return $this->costos->materiales + 
                   $this->costos->mano_obra + 
                   $this->costos->maquinaria + 
                   $this->costos->gastos_indirectos;
        }
        return 0;
    }

    public function getSaldoTotalAttribute()
    {
        return $this->saldosCuentas->sum('saldo_disponible');
    }

    /**
     * Obtener el costo total de nómina del proyecto
     */
    public function getCostoNominaAttribute()
    {
        $total = 0;
        foreach ($this->empleadosActivos as $empleado) {
            $total += $empleado->sueldo_diario * 30; // Sueldo mensual estimado
        }
        return $total;
    }

    /**
     * Obtener el resumen de empleados por puesto
     */
    public function getEmpleadosPorPuestoAttribute()
    {
        return $this->empleadosActivos()
                    ->with('puesto')
                    ->get()
                    ->groupBy('puesto.nombre')
                    ->map(function($empleados) {
                        return $empleados->count();
                    });
    }

    // ============================================
    // SCOPES EXISTENTES
    // ============================================

    public function scopeActivos($query)
    {
        return $query->where('status', 'activo');
    }

    public function scopeBorradores($query)
    {
        return $query->where('status', 'borrador');
    }

    // ============================================
    // ✅ NUEVOS SCOPES
    // ============================================

    /**
     * Scope para filtrar proyectos que tienen empleados asignados
     */
    public function scopeConEmpleados($query)
    {
        return $query->has('empleadosActivos');
    }

    /**
     * Scope para filtrar proyectos sin empleados asignados
     */
    public function scopeSinEmpleados($query)
    {
        return $query->doesntHave('empleadosActivos');
    }

    /**
     * Scope para filtrar proyectos por empleado
     */
    public function scopePorEmpleado($query, $empleadoId)
    {
        return $query->whereHas('empleadosActivos', function($q) use ($empleadoId) {
            $q->where('plantillas.plantilla_id', $empleadoId);
        });
    }

    /**
     * Scope para filtrar proyectos por tipo
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_proyecto', $tipo);
    }

    /**
     * Scope para filtrar proyectos por categoría
     */
    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    /**
     * Scope para filtrar proyectos por estado
     */
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope para filtrar proyectos por rango de fechas
     */
    public function scopeEntreFechas($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha_inicio', [$inicio, $fin])
                     ->orWhereBetween('fecha_fin', [$inicio, $fin]);
    }

    /**
     * Scope para filtrar proyectos por presupuesto
     */
    public function scopePresupuestoMayorA($query, $monto)
    {
        return $query->where('presupuesto_total', '>=', $monto);
    }

    public function scopePresupuestoMenorA($query, $monto)
    {
        return $query->where('presupuesto_total', '<=', $monto);
    }

    // ============================================
    // ✅ NUEVOS MÉTODOS ÚTILES
    // ============================================

    /**
     * Asignar un empleado al proyecto
     */
    public function asignarEmpleado($empleadoId, $data = [])
    {
        $defaultData = [
            'fecha_inicio' => now()->toDateString(),
            'estatus' => 'activo',
            'puesto_id' => null,
            'sueldo_asignado' => null,
            'observaciones' => null,
        ];

        $data = array_merge($defaultData, $data);

        return $this->empleadosAsignados()->attach($empleadoId, $data);
    }

    /**
     * Desasignar un empleado del proyecto (baja lógica)
     */
    public function desasignarEmpleado($empleadoId, $fechaFin = null)
    {
        $fechaFin = $fechaFin ?? now()->toDateString();
        
        return $this->empleadosAsignados()
                    ->wherePivot('plantilla_id', $empleadoId)
                    ->updateExistingPivot($empleadoId, [
                        'fecha_fin' => $fechaFin,
                        'estatus' => 'inactivo'
                    ]);
    }

    /**
     * Reactivar un empleado en el proyecto
     */
    public function reactivarEmpleado($empleadoId, $data = [])
    {
        $defaultData = [
            'fecha_fin' => null,
            'estatus' => 'activo',
        ];

        $data = array_merge($defaultData, $data);

        return $this->empleadosAsignados()
                    ->wherePivot('plantilla_id', $empleadoId)
                    ->updateExistingPivot($empleadoId, $data);
    }

    /**
     * Obtener todos los empleados del proyecto con sus datos completos
     */
    public function getEmpleadosConDetallesAttribute()
    {
        return $this->empleadosActivos()
                    ->with(['puesto', 'area', 'user'])
                    ->get()
                    ->map(function($empleado) {
                        return [
                            'empleado' => $empleado,
                            'puesto' => $empleado->puesto,
                            'area' => $empleado->area,
                            'asignacion' => $empleado->pivot,
                            'sueldo_mensual' => $empleado->sueldo_diario * 30,
                        ];
                    });
    }

    /**
     * Calcular el total de sueldos del proyecto (costo mensual de nómina)
     */
    public function calcularCostoNominaMensual()
    {
        $total = 0;
        foreach ($this->empleadosActivos as $empleado) {
            $sueldo = $empleado->pivot->sueldo_asignado ?? $empleado->sueldo_diario * 30;
            $total += $sueldo;
        }
        return $total;
    }

    /**
     * Generar código automático para el proyecto
     */
    public static function generarCodigo()
    {
        $ultimo = self::orderBy('codigo', 'desc')->first();
        if (!$ultimo) {
            return 'PRJ-0001';
        }
        $numero = intval(substr($ultimo->codigo, 4)) + 1;
        return 'PRJ-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    // ============================================
    // BOOT
    // ============================================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generar código si no tiene
            if (empty($model->codigo)) {
                $model->codigo = self::generarCodigo();
            }
            
            // Establecer status por defecto
            if (empty($model->status)) {
                $model->status = 'borrador';
            }
        });

        static::updating(function ($model) {
            // Si se cambia el status a finalizado, registrar fecha de fin si no tiene
            if ($model->isDirty('status') && $model->status === 'finalizado' && empty($model->fecha_fin)) {
                $model->fecha_fin = now();
            }
        });
    }
}