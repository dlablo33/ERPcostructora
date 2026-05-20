<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GastoFijo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gastos_fijos';
    protected $primaryKey = 'gasto_fijo_id';
    
    protected $fillable = [
        'proveedor_id',
        'proyecto_id',
        'cuenta_contable_id',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'importe',
        'periodicidad',
        'dia_cobro',
        'dia_mes_cobro',
        'mes_inicio_cobro',
        'estatus',
        'cuenta_flujo_dinero',
        'satcat_uso_cfdi_clave',
        'satcat_metodos_pago_clave',
        'satcat_formas_pago_clave'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'importe' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // ========== RELACIONES ==========
    
    /**
     * Relación con Proveedor
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id', 'id');
    }

    /**
     * Relación con Proyecto
     */
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'id');
    }

    /**
     * Relación con Cuenta Contable
     */
    public function cuentaContable()
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_contable_id', 'id');
    }

    // ========== SCOPES ==========
    
    /**
     * Scope para gastos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estatus', 'Activo');
    }

    /**
     * Scope para gastos inactivos
     */
    public function scopeInactivos($query)
    {
        return $query->where('estatus', 'Inactivo');
    }

    /**
     * Scope para gastos pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estatus', 'Pendiente');
    }

    /**
     * Scope para filtrar por rango de fechas
     */
    public function scopeEntreFechas($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha_inicio', [$inicio, $fin]);
    }

    /**
     * Scope para filtrar por proyecto
     */
    public function scopePorProyecto($query, $proyectoId)
    {
        return $query->where('proyecto_id', $proyectoId);
    }

    /**
     * Scope para filtrar por proveedor
     */
    public function scopePorProveedor($query, $proveedorId)
    {
        return $query->where('proveedor_id', $proveedorId);
    }

    /**
     * Scope para filtrar por periodicidad
     */
    public function scopePorPeriodicidad($query, $periodicidad)
    {
        return $query->where('periodicidad', $periodicidad);
    }

    // ========== MUTATORS & ACCESSORS ==========
    
    /**
     * Obtener el nombre del proyecto
     */
    public function getNombreProyectoAttribute()
    {
        return $this->proyecto ? $this->proyecto->nombre : 'Sin Proyecto';
    }

    /**
     * Obtener el nombre de la cuenta contable
     */
    public function getNombreCuentaContableAttribute()
    {
        return $this->cuentaContable ? $this->cuentaContable->nombre : 'Sin Cuenta';
    }

    /**
     * Obtener el texto de periodicidad
     */
    public function getPeriodicidadTextoAttribute()
    {
        $periodicidades = [
            'Mensual' => 'Mensual',
            'Trimestral' => 'Trimestral',
            'Semestral' => 'Semestral',
            'Anual' => 'Anual'
        ];
        return $periodicidades[$this->periodicidad] ?? $this->periodicidad;
    }

    /**
     * Obtener el día de cobro formateado
     */
    public function getDiaCobroTextoAttribute()
    {
        if (!$this->dia_cobro) return '-';
        return $this->dia_cobro . '° día del mes';
    }
}