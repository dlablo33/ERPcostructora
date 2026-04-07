<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoFlujoEfectivo extends Model
{
    protected $table = 'proyecto_flujo_efectivo';
    
    protected $fillable = [
        'proyecto_id',
        'mes',
        'ingreso_estimado',
        'gasto_estimado',
        'flujo_neto',
        'saldo_acumulado'
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }
}