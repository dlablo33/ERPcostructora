<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleListaAsistencia extends Model
{
    use HasFactory;

    protected $table = 'detalle_listas_asistencia';

    protected $fillable = [
        'lista_asistencia_id',
        'empleado_id',
        'empleado_nombre',
        'puesto',
        'hora_entrada',
        'hora_salida',
        'estado',
        'observaciones',
        'horas_trabajadas',
        'justificado',
        'justificacion_id'
    ];

    protected $casts = [
        'hora_entrada' => 'datetime',
        'hora_salida' => 'datetime',
        'horas_trabajadas' => 'decimal:2',
        'justificado' => 'boolean'
    ];

    // Estados disponibles
    public static $estados = [
        'presente' => 'Presente',
        'retardo' => 'Retardo',
        'ausente' => 'Ausente',
        'justificado' => 'Justificado'
    ];

    // Relación con la lista principal
    public function lista()
    {
        return $this->belongsTo(ListaAsistencia::class, 'lista_asistencia_id');
    }

    // Relación con el empleado
    public function empleado()
    {
        return $this->belongsTo(Plantilla::class, 'empleado_id', 'plantilla_id');
    }

    // Relación con justificación
    public function justificacion()
    {
        return $this->belongsTo(JustificacionPermiso::class, 'justificacion_id');
    }

    // Scope por estado
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    // Calcular horas trabajadas
    public static function calcularHorasTrabajadas($horaEntrada, $horaSalida)
    {
        if (empty($horaEntrada) || empty($horaSalida)) {
            return 0;
        }
        
        $entrada = new \DateTime($horaEntrada);
        $salida = new \DateTime($horaSalida);
        $interval = $entrada->diff($salida);
        
        // Restar 1 hora de comida si aplica
        $horas = $interval->h + ($interval->i / 60);
        if ($horas > 5) {
            $horas -= 1;
        }
        
        return round($horas, 2);
    }
}