<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NominaOtrosPago extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'nomina_otros_pagos';
    protected $primaryKey = 'nomina_otros_pago_id';

    protected $fillable = [
        'plantilla_id',
        'clave_sat',
        'concepto',
        'importe',
        'fecha_aplicacion',
        'borrado_logico'
    ];

    protected $casts = [
        'importe' => 'decimal:2',
        'fecha_aplicacion' => 'date',
        'borrado_logico' => 'boolean'
    ];

    public function plantilla()
    {
        return $this->belongsTo(Plantilla::class, 'plantilla_id');
    }

    public function scopeActivas($query)
    {
        return $query->where('borrado_logico', false);
    }

    public function scopeDelPeriodo($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_aplicacion', [$fechaInicio, $fechaFin]);
    }
}