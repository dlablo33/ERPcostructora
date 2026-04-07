<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nomina extends Model
{
    use HasFactory;

    protected $table = 'nomina';

    protected $fillable = [
        'folio',
        'empleado_id',
        'empleado_nombre',
        'puesto',
        'periodo_tipo',
        'periodo_inicio',
        'periodo_fin',
        'dias_trabajados',
        'dias_ausentes',
        'dias_retardo',
        'dias_justificados',
        'sueldo_diario',
        'sueldo_periodo',
        'sueldo_base',
        'bono_asistencia',
        'bono_productividad',
        'horas_extras',
        'prima_vacacional',
        'aguinaldo_proporcional',
        'otras_percepciones',
        'total_percepciones',
        'isr',
        'imss',
        'infonavit',
        'fonacot',
        'pension_alimenticia',
        'prestamos',
        'faltas',
        'retardos_multa',
        'otras_deducciones',
        'total_deducciones',
        'neto_pagar',
        'estatus',
        'fecha_pago',
        'observaciones',
        'calculado_por'
    ];

    protected $casts = [
        'periodo_inicio' => 'date',
        'periodo_fin' => 'date',
        'fecha_pago' => 'date',
        'sueldo_diario' => 'decimal:2',
        'sueldo_periodo' => 'decimal:2',
        'sueldo_base' => 'decimal:2',
        'bono_asistencia' => 'decimal:2',
        'bono_productividad' => 'decimal:2',
        'horas_extras' => 'decimal:2',
        'prima_vacacional' => 'decimal:2',
        'aguinaldo_proporcional' => 'decimal:2',
        'otras_percepciones' => 'decimal:2',
        'total_percepciones' => 'decimal:2',
        'isr' => 'decimal:2',
        'imss' => 'decimal:2',
        'infonavit' => 'decimal:2',
        'fonacot' => 'decimal:2',
        'pension_alimenticia' => 'decimal:2',
        'prestamos' => 'decimal:2',
        'faltas' => 'decimal:2',
        'retardos_multa' => 'decimal:2',
        'otras_deducciones' => 'decimal:2',
        'total_deducciones' => 'decimal:2',
        'neto_pagar' => 'decimal:2'
    ];

    // Relación con empleado
    public function empleado()
    {
        return $this->belongsTo(Plantilla::class, 'empleado_id', 'plantilla_id');
    }

    // Scope por período
    public function scopePorPeriodo($query, $inicio, $fin)
    {
        return $query->whereBetween('periodo_inicio', [$inicio, $fin])
                     ->orWhereBetween('periodo_fin', [$inicio, $fin]);
    }

    // Scope por empleado
    public function scopePorEmpleado($query, $empleadoId)
    {
        return $query->where('empleado_id', $empleadoId);
    }

    // Generar folio
    public static function generarFolio($periodoTipo, $inicio, $fin)
    {
        $fechaInicio = date('Ymd', strtotime($inicio));
        $fechaFin = date('Ymd', strtotime($fin));
        $tipo = substr($periodoTipo, 0, 1);
        
        $ultimo = self::orderBy('id', 'desc')->first();
        $numero = $ultimo ? intval(substr($ultimo->folio, -4)) + 1 : 1;
        
        return "NOM-{$tipo}-{$fechaInicio}-{$fechaFin}-" . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }
}