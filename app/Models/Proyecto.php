<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyecto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'proyectos';
    
    protected $fillable = [
        'codigo',
        'nombre',
        'tipo_proyecto',
        'categoria',
        'prioridad',
        'ubicacion',
        'direccion',
        'fecha_inicio',
        'fecha_fin',
        'descripcion',
        'estado',
        'moneda',
        'tipo_cambio',
        'cliente_nombre',
        'cliente_rfc',
        'cliente_email',
        'cliente_telefono',
        'cliente_contacto',
        'cliente_cargo',
        'numero_contrato',
        'fecha_firma',
        'tipo_contrato',
        'forma_pago',
        'plazo_pago',
        'responsable_id',
        'cargo_responsable',
        'email_responsable',
        'presupuesto_total',
        'anticipo',
        'margen',
        'fondo_reserva',
        'status',
        'created_by'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'fecha_firma' => 'date',
        'presupuesto_total' => 'decimal:2',
        'anticipo' => 'decimal:2',
        'margen' => 'decimal:2',
        'fondo_reserva' => 'decimal:2',
        'tipo_cambio' => 'decimal:4',
    ];

    // Relaciones
    public function equipo()
    {
        return $this->hasMany(ProyectoEquipo::class, 'proyecto_id');
    }

    public function documentos()
    {
        return $this->hasMany(ProyectoDocumento::class, 'proyecto_id');
    }

    public function costos()
    {
        return $this->hasOne(ProyectoCosto::class, 'proyecto_id');
    }

    public function flujoEfectivo()
    {
        return $this->hasMany(ProyectoFlujoEfectivo::class, 'proyecto_id');
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessors
    public function getMontoAnticipoAttribute()
    {
        return ($this->presupuesto_total * $this->anticipo) / 100;
    }

    public function getUtilidadEstimadaAttribute()
    {
        return ($this->presupuesto_total * $this->margen) / 100;
    }

    public function getCostoTotalAttribute()
    {
        if ($this->costos) {
            return $this->costos->materiales + 
                   $this->costos->mano_obra + 
                   $this->costos->maquinaria + 
                   $this->costos->gastos_indirectos;
        }
        return 0;
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('status', 'activo');
    }

    public function scopeBorradores($query)
    {
        return $query->where('status', 'borrador');
    }

// app/Models/Proyecto.php - Agrega estas relaciones

public function cuentasBancarias()
{
    return $this->hasMany(CuentaBancaria::class);
}

public function movimientosBancarios()
{
    return $this->hasMany(MovimientoBancario::class);
}

public function saldosCuentas()
{
    return $this->hasMany(ProyectoSaldo::class);
}

public function getSaldoTotalAttribute()
{
    return $this->saldosCuentas->sum('saldo_disponible');
}
}