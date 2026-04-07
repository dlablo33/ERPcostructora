<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TablaSueldo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tabla_sueldos';

    protected $fillable = [
        'folio',
        'fecha_ejecuto',
        'fecha_inicial',
        'fecha_final',
        'cantidad_registros',
        'monto',
        'estatus',
        'observaciones',
        'created_by',
    ];

    protected $casts = [
        'fecha_ejecuto' => 'date',
        'fecha_inicial' => 'date',
        'fecha_final' => 'date',
        'monto' => 'decimal:2',
        'cantidad_registros' => 'integer',
    ];

    // Relación con el usuario que lo creó
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessor para formatear monto
    public function getMontoFormateadoAttribute()
    {
        return '$' . number_format($this->monto, 2);
    }

    // Scope para búsqueda
    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where(function($q) use ($termino) {
                $q->where('folio', 'LIKE', "%{$termino}%")
                  ->orWhere('estatus', 'LIKE', "%{$termino}%");
            });
        }
        return $query;
    }
}