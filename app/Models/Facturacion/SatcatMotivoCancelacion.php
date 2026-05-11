<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;

class SatcatMotivoCancelacion extends Model
{
    protected $table = 'satcat_motivo_cancelacion';
    protected $fillable = ['clave', 'descripcion', 'estatus'];
    protected $casts = ['estatus' => 'boolean'];
}