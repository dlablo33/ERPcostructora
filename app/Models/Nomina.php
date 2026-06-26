<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Nomina extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nomina';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
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
        'neto_pagar' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the employee that owns the nomina.
     */
    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Plantilla::class, 'empleado_id', 'plantilla_id');
    }

    /**
     * Get the user who calculated the nomina.
     */
    public function calculadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'calculado_por');
    }

    /**
     * Scope a query to only include nominas of a specific type.
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('periodo_tipo', $tipo);
    }

    /**
     * Scope a query to only include nominas in a date range.
     */
    public function scopeEntreFechas($query, $inicio, $fin)
    {
        return $query->whereBetween('periodo_inicio', [$inicio, $fin])
                     ->orWhereBetween('periodo_fin', [$inicio, $fin]);
    }

    /**
     * Scope a query to only include nominas by employee.
     */
    public function scopePorEmpleado($query, $empleadoId)
    {
        return $query->where('empleado_id', $empleadoId);
    }

    /**
     * Scope a query to only include nominas by status.
     */
    public function scopePorEstatus($query, $estatus)
    {
        return $query->where('estatus', $estatus);
    }

    /**
     * Check if the nomina is paid.
     */
    public function isPagada(): bool
    {
        return $this->estatus === 'Pagada';
    }

    /**
     * Check if the nomina is calculated.
     */
    public function isCalculada(): bool
    {
        return $this->estatus === 'Calculada';
    }

    /**
     * Check if the nomina is pending.
     */
    public function isPendiente(): bool
    {
        return $this->estatus === 'Pendiente';
    }

    /**
     * Check if the nomina is cancelled.
     */
    public function isCancelada(): bool
    {
        return $this->estatus === 'Cancelada';
    }

    /**
     * Get the status badge class.
     */
    public function getEstatusBadgeClass(): string
    {
        return match ($this->estatus) {
            'Pagada' => 'badge-pagada',
            'Calculada' => 'badge-calculada',
            'Pendiente' => 'badge-pendiente',
            'Cancelada' => 'badge-cancelada',
            default => 'badge-pendiente',
        };
    }

    /**
     * Get the formatted net amount.
     */
    public function getNetoFormateadoAttribute(): string
    {
        return '$' . number_format($this->neto_pagar, 2);
    }

    /**
     * Get the formatted total percepciones.
     */
    public function getTotalPercepcionesFormateadoAttribute(): string
    {
        return '$' . number_format($this->total_percepciones, 2);
    }

    /**
     * Get the formatted total deducciones.
     */
    public function getTotalDeduccionesFormateadoAttribute(): string
    {
        return '$' . number_format($this->total_deducciones, 2);
    }

    /**
     * Get the period description.
     */
    public function getPeriodoDescripcionAttribute(): string
    {
        $inicio = $this->periodo_inicio ? $this->periodo_inicio->format('d/m/Y') : 'N/A';
        $fin = $this->periodo_fin ? $this->periodo_fin->format('d/m/Y') : 'N/A';
        return "{$inicio} - {$fin}";
    }

    /**
     * Get the days worked formatted.
     */
    public function getDiasFormateadoAttribute(): string
    {
        $dias = $this->dias_trabajados ?? 0;
        $total = $this->periodo_tipo === 'semanal' ? 7 : 15;
        return "{$dias}/{$total}";
    }

    /**
     * Generate a unique folio for the nomina.
     */
    public static function generarFolio($periodoTipo, $inicio, $fin, $empleadoId = null)
    {
        $fechaInicio = date('Ymd', strtotime($inicio));
        $fechaFin = date('Ymd', strtotime($fin));
        $tipo = $periodoTipo === 'semanal' ? 'S' : 'Q';
        
        // Contar nóminas existentes en el mismo período
        $count = self::where('periodo_inicio', $inicio)
            ->where('periodo_fin', $fin)
            ->count() + 1;
        
        $numero = str_pad($count, 4, '0', STR_PAD_LEFT);
        
        if ($empleadoId) {
            $empleado = str_pad($empleadoId, 3, '0', STR_PAD_LEFT);
            return "NOM-{$tipo}-{$fechaInicio}-{$fechaFin}-{$empleado}-{$numero}";
        }
        
        return "NOM-{$tipo}-{$fechaInicio}-{$fechaFin}-{$numero}";
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->folio)) {
                $model->folio = self::generarFolio(
                    $model->periodo_tipo,
                    $model->periodo_inicio,
                    $model->periodo_fin,
                    $model->empleado_id
                );
            }
        });
    }
}