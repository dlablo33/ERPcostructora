<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vacaciones';
    protected $primaryKey = 'id';

    protected $fillable = [
        'folio',
        'plantilla_id',
        'fecha_inicio',
        'fecha_fin',
        'dias',
        'observaciones',
        'estatus',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'dias' => 'integer',
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

        static::creating(function ($vacacion) {
            if (!$vacacion->folio) {
                $last = static::withTrashed()->orderBy('id', 'desc')->first();
                $lastId = $last ? $last->id : 0;
                $vacacion->folio = 'VAC-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}