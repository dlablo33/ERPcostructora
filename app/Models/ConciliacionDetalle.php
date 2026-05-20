<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConciliacionDetalle extends Model
{
    use HasFactory;

    protected $table = 'conciliacion_detalle';
    protected $primaryKey = 'id';

    protected $fillable = [
        'conciliacion_id',
        'origen',
        'fecha',
        'descripcion',
        'referencia',
        'egreso',
        'ingreso',
        'numero_transaccion',
        'estatus',
        'conciliado_con'
    ];

    protected $casts = [
        'fecha' => 'date',
        'egreso' => 'decimal:2',
        'ingreso' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // ========== RELACIONES ==========
    
    /**
     * Relación con la conciliación principal
     */
    public function conciliacion()
    {
        return $this->belongsTo(ConciliacionBancaria::class, 'conciliacion_id', 'id');
    }

    // ========== SCOPES ==========
    
    /**
     * Scope para movimientos del sistema
     */
    public function scopeSistema($query)
    {
        return $query->where('origen', 'Sistema');
    }

    /**
     * Scope para movimientos del extracto
     */
    public function scopeExtracto($query)
    {
        return $query->where('origen', 'Extracto');
    }

    /**
     * Scope para movimientos conciliados
     */
    public function scopeConciliados($query)
    {
        return $query->where('estatus', 'Conciliado');
    }

    /**
     * Scope para movimientos pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estatus', 'Pendiente');
    }

    /**
     * Scope para movimientos en diferencia
     */
    public function scopeDiferencia($query)
    {
        return $query->where('estatus', 'Diferencia');
    }

    /**
     * Scope para filtrar por rango de fechas
     */
    public function scopeEntreFechas($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha', [$inicio, $fin]);
    }

    // ========== MUTATORS & ACCESSORS ==========
    
    /**
     * Obtener el monto formateado (positivo o negativo según sea egreso o ingreso)
     */
    public function getMontoFormateadoAttribute()
    {
        if ($this->egreso > 0) {
            return '-$' . number_format($this->egreso, 2);
        }
        return '+$' . number_format($this->ingreso, 2);
    }

    /**
     * Obtener el tipo de movimiento
     */
    public function getTipoAttribute()
    {
        if ($this->egreso > 0) return 'Egreso';
        if ($this->ingreso > 0) return 'Ingreso';
        return 'Sin movimiento';
    }

    /**
     * Obtener el badge del estatus
     */
    public function getEstatusBadgeAttribute()
    {
        $badges = [
            'Pendiente' => 'badge-pendiente',
            'Conciliado' => 'badge-conciliado',
            'Diferencia' => 'badge-diferencia'
        ];
        return $badges[$this->estatus] ?? 'badge-pendiente';
    }

    // ========== MÉTODOS DE NEGOCIO ==========
    
    /**
     * Marcar como conciliado
     */
    public function marcarConciliado($movimientoId = null)
    {
        $this->estatus = 'Conciliado';
        $this->conciliado_con = $movimientoId;
        $this->save();
    }

    /**
     * Marcar como diferencia
     */
    public function marcarDiferencia()
    {
        $this->estatus = 'Diferencia';
        $this->save();
    }

    /**
     * Verificar si está conciliado
     */
    public function isConciliado()
    {
        return $this->estatus === 'Conciliado';
    }
}