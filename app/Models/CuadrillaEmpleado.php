<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CuadrillaEmpleado extends Model
{
    use HasFactory;

    protected $table = 'cuadrilla_empleados';

    protected $fillable = [
        'cuadrilla_id',
        'empleado_id',
        'fecha_asignacion',
        'activo'
    ];

    protected $casts = [
        'fecha_asignacion' => 'date',
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // ==================== RELACIONES ====================

    public function cuadrilla()
    {
        return $this->belongsTo(Cuadrilla::class, 'cuadrilla_id');
    }

    public function empleado()
    {
        return $this->belongsTo(Plantilla::class, 'empleado_id', 'plantilla_id');
    }
}