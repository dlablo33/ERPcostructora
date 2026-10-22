<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Credito extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'creditos';

    protected $fillable = [
        'numero_credito',
        'banco_id',
        'fecha',
        'fecha_primer_pago',
        'fecha_vencimiento',
        'monto_total',
        'monto_pendiente',
        'monto_capital',
        'monto_capital_restante',
        'monto_interes',
        'parcialidad_actual',
        'tasa_interes',
        'plazo_meses',
        'num_parcialidades',
        'monto_parcialidad',
        'estado',
        'notas',
    ];

    protected $casts = [
        'fecha'                  => 'date',
        'fecha_primer_pago'      => 'date',
        'fecha_vencimiento'      => 'date',
        'monto_total'            => 'decimal:2',
        'monto_pendiente'        => 'decimal:2',
        'monto_capital'          => 'decimal:2',
        'monto_capital_restante' => 'decimal:2',
        'monto_interes'          => 'decimal:2',
        'monto_parcialidad'      => 'decimal:2',
        'tasa_interes'           => 'decimal:2',
    ];

    // Relación con el modelo existente Banco
    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }

    public function parcialidades()
    {
        return $this->hasMany(Parcialidad::class, 'credito_id')->orderBy('numero');
    }

    // Scopes útiles
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopePorBanco($query, $bancoId)
    {
        return $query->where('banco_id', $bancoId);
    }
}