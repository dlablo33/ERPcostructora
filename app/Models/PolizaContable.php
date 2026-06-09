<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PolizaContable extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'polizas_contables';

    // Cambia esto - usa 'poliza_contable_id' en lugar de 'polizas_contables_id'
    protected $primaryKey = 'poliza_contable_id';

    // Indica que la llave primaria no es auto-incrementable? (si es auto-increment, no necesitas esto)
    public $incrementing = true;
    
    // Si la llave primaria no es integer, descomenta:
    // protected $keyType = 'int';

    protected $fillable = [
        'folio',
        'fecha',
        'origen',
        'origen_id',
        'descripcion',
        'tipo_poliza',
        'estatus',
        'carta_porte_id',
        'proyecto_id',
        'monto_cargo',
        'monto_abono',
        'verificado',
        'fecha_folio',
        'concepto',
        'origen_nombre'
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_folio' => 'date',
        'verificado' => 'boolean',
        'monto_cargo' => 'decimal:2',
        'monto_abono' => 'decimal:2'
    ];

    // Relación con movimientos - Actualizar la clave foránea
    public function movimientos()
    {
        return $this->hasMany(MovimientoPoliza::class, 'poliza_contable_id', 'poliza_contable_id');
    }

    // Relación con proyecto
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'id');
    }

    // Scopes
    public function scopePorProyecto($query, $proyectoId)
    {
        if ($proyectoId) {
            return $query->where('proyecto_id', $proyectoId);
        }
        return $query;
    }

    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
    }

    public function scopePorEstatus($query, $estatus)
    {
        if ($estatus) {
            return $query->where('estatus', $estatus);
        }
        return $query;
    }

    // Accesors
    public function getNombreProyectoAttribute()
    {
        return $this->proyecto ? $this->proyecto->nombre : null;
    }

    public function getCodigoProyectoAttribute()
    {
        return $this->proyecto ? $this->proyecto->codigo : null;
    }
}