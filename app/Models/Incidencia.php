<?php
// app/Models/Incidencia.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incidencia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'incidencias';
    protected $primaryKey = 'incidencia_id';

    protected $fillable = [
        'plantilla_id',
        'cat_tipo_incidencia_id',
        'descripcion',
        'fecha_incidencia',
        'estatus',
        'fecha_resolucion',
        'comentarios_resolucion',
        'autorizado_por',
        'fecha_autorizacion',
        'borrado_logico'
    ];

    protected $casts = [
        'fecha_incidencia' => 'date',
        'fecha_resolucion' => 'date',
        'fecha_autorizacion' => 'date',
        'borrado_logico' => 'boolean'
    ];

    // Relación con empleado
    public function empleado()
    {
        return $this->belongsTo(Plantilla::class, 'plantilla_id', 'plantilla_id');
    }

    // Relación con tipo de incidencia
    public function tipoIncidencia()
    {
        return $this->belongsTo(CatTipoIncidencia::class, 'cat_tipo_incidencia_id');
    }

    // Relación con autorizador
    public function autorizador()
    {
        return $this->belongsTo(Plantilla::class, 'autorizado_por', 'plantilla_id');
    }

    // Scopes útiles
    public function scopePendientes($query)
    {
        return $query->where('estatus', 'Pendiente');
    }

    public function scopePorEmpleado($query, $empleadoId)
    {
        return $query->where('plantilla_id', $empleadoId);
    }

    public function scopePorFechas($query, $desde, $hasta)
    {
        if ($desde && $hasta) {
            return $query->whereBetween('fecha_incidencia', [$desde, $hasta]);
        }
        return $query;
    }

    // Accesor para estatus con badge
    public function getEstatusBadgeAttribute()
    {
        $badges = [
            'Pendiente' => '<span class="badge-pendiente">Pendiente</span>',
            'Aprobada' => '<span class="badge-activo">Aprobada</span>',
            'Rechazada' => '<span class="badge-inactivo">Rechazada</span>',
            'Resuelta' => '<span class="badge-activo">Resuelta</span>'
        ];
        
        return $badges[$this->estatus] ?? '<span class="badge-pendiente">' . $this->estatus . '</span>';
    }
}