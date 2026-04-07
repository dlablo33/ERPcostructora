<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prestamo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'prestamos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'folio',
        'estatus',
        'fecha_inicio',
        'plantilla_id',
        'motivo',
        'monto',
        'monto_descuento',
        'numero_pagos',
        'frecuencia',
        'monto_restante',
        'observaciones',
        'gasto',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'monto' => 'decimal:2',
        'monto_descuento' => 'decimal:2',
        'monto_restante' => 'decimal:2',
        'numero_pagos' => 'integer',
    ];

    // Relación con Plantilla (empleado)
    public function empleado()
    {
        return $this->belongsTo(Plantilla::class, 'plantilla_id', 'plantilla_id');
    }

    // Accesor para obtener nombre del empleado
    public function getNombreEmpleadoAttribute()
    {
        return $this->empleado ? $this->empleado->nombre_completo : '-';
    }

    // Boot para generar folio automáticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($prestamo) {
            if (!$prestamo->folio) {
                $last = static::withTrashed()->orderBy('id', 'desc')->first();
                $lastId = $last ? $last->id : 0;
                $prestamo->folio = 'PR-' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
            }
        });
    }
}