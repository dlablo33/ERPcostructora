<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JustificacionPermiso extends Model
{
    use HasFactory;

    protected $table = 'justificaciones_permisos';

    protected $fillable = [
        'folio',
        'empleado_id',
        'empleado_nombre',
        'tipo',
        'fecha_inicio',
        'fecha_fin',
        'dias',
        'estatus',
        'tiene_justificante',
        'motivo',
        'archivo_justificante',
        'observaciones',
        'autorizado_por',
        'fecha_autorizacion'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'fecha_autorizacion' => 'datetime',
        'tiene_justificante' => 'boolean',
        'dias' => 'integer'
    ];

    // Tipos de justificaciones/permisos disponibles
    public static $tipos = [
        'Permiso Médico',
        'Permiso Personal',
        'Permiso de Estudios',
        'Permiso por Luto',
        'Incapacidad',
        'Justificante de Retardo',
        'Otro'
    ];

    // Estatus disponibles
    public static $estatus = [
        'Pendiente',
        'Aprobado',
        'Rechazado'
    ];

    // Scope para filtrar por estatus
    public function scopePorEstatus($query, $estatus)
    {
        return $query->where('estatus', $estatus);
    }

    // Scope para filtrar por empleado
    public function scopePorEmpleado($query, $empleadoId)
    {
        return $query->where('empleado_id', $empleadoId);
    }

    // Scope para filtrar por rango de fechas
    public function scopePorRangoFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
                     ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin]);
    }

    // Scope para búsqueda
    public function scopeBuscar($query, $termino)
    {
        return $query->where('folio', 'LIKE', "%{$termino}%")
                     ->orWhere('empleado_nombre', 'LIKE', "%{$termino}%")
                     ->orWhere('tipo', 'LIKE', "%{$termino}%")
                     ->orWhere('motivo', 'LIKE', "%{$termino}%");
    }

    // Generar folio automáticamente
    public static function generarFolio()
    {
        $ultimo = self::orderBy('id', 'desc')->first();
        $numero = $ultimo ? intval(substr($ultimo->folio, 4)) + 1 : 1001;
        return 'JP-' . $numero;
    }

    // Calcular días entre fechas
    public static function calcularDias($fechaInicio, $fechaFin)
    {
        $inicio = new \DateTime($fechaInicio);
        $fin = new \DateTime($fechaFin);
        $interval = $inicio->diff($fin);
        return $interval->days + 1;
    }
}