<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestoMensual extends Model
{
    use HasFactory;

    protected $table = 'presupuesto_mensual';
    protected $primaryKey = 'presupuesto_mensual_id';
    public $timestamps = true;

    protected $fillable = [
        'mes',
        'anio',
        'monto',
        'observaciones',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'mes' => 'integer',
        'anio' => 'integer',
    ];
}