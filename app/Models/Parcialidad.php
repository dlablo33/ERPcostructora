<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcialidad extends Model
{
    use HasFactory;

    protected $table = 'parcialidades';

    protected $fillable = [
        'credito_id',
        'numero',
        'fecha_vencimiento',
        'fecha_pago',
        'monto',
        'capital',
        'interes',
        'saldo',
        'estado',
        'notas',
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date',
        'fecha_pago'        => 'date',
        'monto'             => 'decimal:2',
        'capital'           => 'decimal:2',
        'interes'           => 'decimal:2',
        'saldo'             => 'decimal:2',
    ];

    public function credito()
    {
        return $this->belongsTo(Credito::class, 'credito_id');
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }
}