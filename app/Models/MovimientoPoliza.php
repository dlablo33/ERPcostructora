<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoPoliza extends Model
{
    use HasFactory;

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
        'haber' => 'decimal:2'
    ];

    // Relación con póliza
    public function poliza()
    {
        return $this->belongsTo(PolizaContable::class, 'poliza_contable_id', 'polizas_contables_id');
    }

    // Relación con cuenta contable
    public function cuentaContable()
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_contable_id');
    }
}