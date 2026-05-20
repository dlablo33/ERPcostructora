<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramacionPago extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'programacion_pagos';
    
    protected $fillable = [
        'folio',
        'estatus',
        'fecha',
        'proveedor_id',
        'descripcion',
        'monto',
        'saldo',
        'fecha_estimada_pago',
        'fecha_pago_real',
        'proyecto_id',
        'cuenta_bancaria_id',
        'referencia_pago',
        'observaciones',
        'created_by'
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_estimada_pago' => 'date',
        'fecha_pago_real' => 'date',
        'monto' => 'decimal:2',
        'saldo' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // ========== RELACIONES ==========
    
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id', 'id');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'id');
    }

    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class, 'cuenta_bancaria_id', 'id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    // ========== SCOPES ==========
    
    public function scopePorEstatus($query, $estatus)
    {
        return $query->where('estatus', $estatus);
    }

    public function scopePendientes($query)
    {
        return $query->where('estatus', 'Pendiente')->where('saldo', '>', 0);
    }

    public function scopeProgramados($query)
    {
        return $query->where('estatus', 'Programado');
    }

    public function scopePagados($query)
    {
        return $query->where('estatus', 'Pagado');
    }

    public function scopeEntreFechas($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha', [$inicio, $fin]);
    }

    public function scopeFechaEstimadaEntre($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha_estimada_pago', [$inicio, $fin]);
    }

    // ========== MUTATORS & ACCESSORS ==========
    
    public function getMontoFormateadoAttribute()
    {
        return '$' . number_format($this->monto, 2);
    }

    public function getSaldoFormateadoAttribute()
    {
        return '$' . number_format($this->saldo, 2);
    }

    public function getEstatusBadgeAttribute()
    {
        $badges = [
            'Programado' => 'badge-programado',
            'Pendiente' => 'badge-pendiente',
            'Pagado' => 'badge-pagado',
            'Cancelado' => 'badge-cancelado',
            'Parcial' => 'badge-parcial'
        ];
        return $badges[$this->estatus] ?? 'badge-pendiente';
    }

    // ========== MÉTODOS DE NEGOCIO ==========
    
    public function registrarPago($monto, $referencia = null)
    {
        $this->saldo -= $monto;
        
        if ($this->saldo <= 0) {
            $this->estatus = 'Pagado';
            $this->saldo = 0;
            $this->fecha_pago_real = now();
        } elseif ($this->saldo < $this->monto) {
            $this->estatus = 'Parcial';
        }
        
        $this->referencia_pago = $referencia;
        $this->save();
        
        return $this;
    }
}