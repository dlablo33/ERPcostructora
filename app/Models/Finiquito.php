<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Finiquito extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'finiquitos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'folio',
        'plantilla_id',
        'tipo',
        'fecha_baja',
        'fecha_ingreso',
        'salario_diario',
        'salario_integrado',
        'dias_vacaciones',
        'prima_vacacional',
        'aguinaldo',
        'indemnizacion',
        'total',
        'estatus',
        'observaciones',
        'motivo_baja',
        'fecha_pago',
        'usuario_autorizo',
        'fecha_autorizacion',
    ];

    protected $casts = [
        'fecha_baja' => 'date',
        'fecha_ingreso' => 'date',
        'fecha_pago' => 'date',
        'fecha_autorizacion' => 'datetime',
        'salario_diario' => 'decimal:2',
        'salario_integrado' => 'decimal:2',
        'prima_vacacional' => 'decimal:2',
        'aguinaldo' => 'decimal:2',
        'indemnizacion' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function empleado()
    {
        return $this->belongsTo(Plantilla::class, 'plantilla_id', 'plantilla_id');
    }

    public function getNombreEmpleadoAttribute()
    {
        return $this->empleado ? $this->empleado->nombre_completo : '-';
    }

    public function getRfcAttribute()
    {
        return $this->empleado ? $this->empleado->rfc : '-';
    }

    public function getAntiguedadAttribute()
    {
        if ($this->fecha_ingreso && $this->fecha_baja) {
            $diff = $this->fecha_ingreso->diff($this->fecha_baja);
            $years = $diff->y;
            $months = $diff->m;
            return $years . ' años ' . $months . ' meses';
        }
        return '-';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($finiquito) {
            if (!$finiquito->folio) {
                $year = date('Y');
                $last = static::withTrashed()->where('folio', 'LIKE', "FQ-{$year}-%")->orderBy('id', 'desc')->first();
                if ($last) {
                    $lastNum = intval(substr($last->folio, -3));
                    $finiquito->folio = "FQ-{$year}-" . str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
                } else {
                    $finiquito->folio = "FQ-{$year}-001";
                }
            }
        });
    }
}