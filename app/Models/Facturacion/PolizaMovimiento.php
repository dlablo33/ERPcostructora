<?php

namespace App\Models\Facturacion;

use App\Models\CuentasContable;
use Illuminate\Database\Eloquent\Model;

class PolizaMovimiento extends Model
{
    protected $table = 'polizas_movimientos';
    protected $fillable = ['poliza_contable_id', 'cuenta_contable_id', 'debe', 'haber', 'descripcion'];
    protected $casts = ['debe' => 'decimal:2', 'haber' => 'decimal:2'];

    public function poliza() { return $this->belongsTo(PolizaContable::class, 'poliza_contable_id'); }
    public function cuentaContable() { return $this->belongsTo(CuentasContable::class, 'cuenta_contable_id'); }
}