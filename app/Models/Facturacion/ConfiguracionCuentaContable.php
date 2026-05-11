<?php

namespace App\Models\Facturacion;

use App\Models\CuentasContable;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionCuentaContable extends Model
{
    protected $table = 'configuracion_cuenta_contable';
    protected $primaryKey = 'configuracion_cuenta_contable_id';
    protected $fillable = ['categoria', 'cuenta_contable_id', 'tipo', 'activo'];
    protected $casts = ['activo' => 'boolean'];

    public function cuentaContable() { return $this->belongsTo(CuentasContable::class, 'cuenta_contable_id'); }
}