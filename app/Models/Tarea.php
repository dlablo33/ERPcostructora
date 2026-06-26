<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $fillable = [
        'usuario_creador_id', 'usuario_asignado_id', 'titulo', 'descripcion',
        'tipo', 'data', 'referencia_id', 'referencia_type', 'estado',
        'fecha_limite', 'leida_at'
    ];

    protected $casts = [
        'data' => 'array',
        'fecha_limite' => 'datetime',
        'leida_at' => 'datetime',
    ];

    // Relaciones
    public function creador()
    {
        return $this->belongsTo(User::class, 'usuario_creador_id');
    }

    public function asignado()
    {
        return $this->belongsTo(User::class, 'usuario_asignado_id');
    }

    public function referencia()
    {
        return $this->morphTo();
    }

    // Scopes para consultas comunes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopePorUsuario($query, $userId)
    {
        return $query->where('usuario_asignado_id', $userId);
    }
}