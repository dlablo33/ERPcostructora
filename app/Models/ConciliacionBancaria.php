<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConciliacionBancaria extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'conciliacion_bancaria';
    protected $primaryKey = 'id';

    protected $fillable = [
        'cuenta_bancaria_id',
        'folio',
        'fecha_conciliacion',
        'periodo_inicio',
        'periodo_fin',
        'saldo_inicial_sistema',
        'saldo_inicial_extracto',
        'total_ingresos_sistema',
        'total_egresos_sistema',
        'total_ingresos_extracto',
        'total_egresos_extracto',
        'saldo_final_sistema',
        'saldo_final_extracto',
        'diferencia',
        'archivo_excel',
        'estatus',
        'observaciones',
        'created_by'
    ];

    protected $casts = [
        'fecha_conciliacion' => 'date',
        'periodo_inicio' => 'date',
        'periodo_fin' => 'date',
        'saldo_inicial_sistema' => 'decimal:2',
        'saldo_inicial_extracto' => 'decimal:2',
        'total_ingresos_sistema' => 'decimal:2',
        'total_egresos_sistema' => 'decimal:2',
        'total_ingresos_extracto' => 'decimal:2',
        'total_egresos_extracto' => 'decimal:2',
        'saldo_final_sistema' => 'decimal:2',
        'saldo_final_extracto' => 'decimal:2',
        'diferencia' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // ========== RELACIONES ==========
    
    /**
     * Relación con la cuenta bancaria
     */
    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class, 'cuenta_bancaria_id', 'id');
    }

    /**
     * Relación con el usuario que creó la conciliación
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Relación con los detalles de la conciliación
     */
    public function detalles()
    {
        return $this->hasMany(ConciliacionDetalle::class, 'conciliacion_id', 'id');
    }

    // ========== SCOPES ==========
    
    /**
     * Scope para conciliaciones pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estatus', 'Pendiente');
    }

    /**
     * Scope para conciliaciones conciliadas
     */
    public function scopeConciliadas($query)
    {
        return $query->where('estatus', 'Conciliado');
    }

    /**
     * Scope para conciliaciones en proceso
     */
    public function scopeEnProceso($query)
    {
        return $query->where('estatus', 'En Proceso');
    }

    /**
     * Scope para conciliaciones con descuadre
     */
    public function scopeDescuadre($query)
    {
        return $query->where('estatus', 'Descuadre');
    }

    /**
     * Scope para filtrar por período
     */
    public function scopePorPeriodo($query, $inicio, $fin)
    {
        return $query->whereBetween('periodo_inicio', [$inicio, $fin]);
    }

    /**
     * Scope para filtrar por cuenta bancaria
     */
    public function scopePorCuenta($query, $cuentaId)
    {
        return $query->where('cuenta_bancaria_id', $cuentaId);
    }

    // ========== MUTATORS & ACCESSORS ==========
    
    /**
     * Obtener el nombre del banco
     */
    public function getNombreBancoAttribute()
    {
        return $this->cuentaBancaria ? $this->cuentaBancaria->banco->nombre : 'N/A';
    }

    /**
     * Obtener el número de cuenta
     */
    public function getNumeroCuentaAttribute()
    {
        return $this->cuentaBancaria ? $this->cuentaBancaria->numero_cuenta : 'N/A';
    }

    /**
     * Obtener la diferencia formateada
     */
    public function getDiferenciaFormateadaAttribute()
    {
        $signo = $this->diferencia >= 0 ? '+' : '-';
        return $signo . '$' . number_format(abs($this->diferencia), 2);
    }

    /**
     * Obtener el badge del estatus
     */
    public function getEstatusBadgeAttribute()
    {
        $badges = [
            'Pendiente' => 'badge-pendiente',
            'En Proceso' => 'badge-info',
            'Conciliado' => 'badge-conciliado',
            'Descuadre' => 'badge-diferencia'
        ];
        return $badges[$this->estatus] ?? 'badge-pendiente';
    }

    // ========== MÉTODOS DE NEGOCIO ==========
    
    /**
     * Calcular saldo final del sistema
     */
    public function calcularSaldoFinalSistema()
    {
        return $this->saldo_inicial_sistema + $this->total_ingresos_sistema - $this->total_egresos_sistema;
    }

    /**
     * Calcular saldo final del extracto
     */
    public function calcularSaldoFinalExtracto()
    {
        return $this->saldo_inicial_extracto + $this->total_ingresos_extracto - $this->total_egresos_extracto;
    }

    /**
     * Calcular diferencia
     */
    public function calcularDiferencia()
    {
        $saldoFinalSistema = $this->calcularSaldoFinalSistema();
        $saldoFinalExtracto = $this->calcularSaldoFinalExtracto();
        return $saldoFinalSistema - $saldoFinalExtracto;
    }

    /**
     * Actualizar estatus basado en la diferencia
     */
    public function actualizarEstatus()
    {
        if ($this->diferencia == 0) {
            $this->estatus = 'Conciliado';
        } else {
            $this->estatus = 'Descuadre';
        }
        $this->save();
    }
}