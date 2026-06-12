<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovimientoPoliza extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'movimientos_poliza';

    protected $fillable = [
        'poliza_contable_id',
        'cuenta_contable_id',
        'debe',
        'haber',
        'descripcion'
    ];

    protected $casts = [
        'debe' => 'decimal:2',
        'haber' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relación con póliza
    public function poliza()
    {
        return $this->belongsTo(PolizaContable::class, 'poliza_contable_id', 'poliza_contable_id');
    }

    // Relación con cuenta contable
    public function cuentaContable()
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_contable_id');
    }

    // Scopes útiles
    public function scopePorPoliza($query, $polizaId)
    {
        return $query->where('poliza_contable_id', $polizaId);
    }

    public function scopeDeudores($query)
    {
        return $query->where('debe', '>', 0);
    }

    public function scopeAcreedores($query)
    {
        return $query->where('haber', '>', 0);
    }

    // Accessors
    public function getMontoAttribute()
    {
        if ($this->debe > 0) {
            return $this->debe;
        }
        return $this->haber;
    }

    public function getTipoMovimientoAttribute()
    {
        if ($this->debe > 0) {
            return 'CARGO';
        }
        if ($this->haber > 0) {
            return 'ABONO';
        }
        return 'SALDO';
    }

    // Formateadores
    public function getDebeFormateadoAttribute()
    {
        return '$' . number_format($this->debe, 2);
    }

    public function getHaberFormateadoAttribute()
    {
        return '$' . number_format($this->haber, 2);
    }
}