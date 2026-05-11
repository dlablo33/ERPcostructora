<?php
// app/Models/SolicitudFactoraje.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Facturacion\Contacto;
use App\Models\Facturacion\Factura;

class SolicitudFactoraje extends Model
{
    use SoftDeletes;

    protected $table = 'solicitudes_factoraje';
    protected $primaryKey = 'solicitud_id';
    
    protected $fillable = [
        'folio',
        'fecha_solicitud',
        'fecha_autorizacion',
        'factor_id',
        'contacto_id',
        'monto_factura',
        'porcentaje_anticipo',
        'monto_anticipo',
        'tasa_interes',
        'comision',
        'iva_comision',
        'total_comision',
        'monto_recibir',
        'fecha_vencimiento_factoraje',
        'fecha_liquidacion',
        'estatus',
        'referencia_pago',
        'observaciones',
        'created_by',
        'autorizado_por'
    ];

    protected $casts = [
        'fecha_solicitud' => 'date',
        'fecha_autorizacion' => 'date',
        'fecha_vencimiento_factoraje' => 'date',
        'fecha_liquidacion' => 'date',
        'monto_factura' => 'decimal:2',
        'porcentaje_anticipo' => 'decimal:2',
        'monto_anticipo' => 'decimal:2',
        'tasa_interes' => 'decimal:2',
        'comision' => 'decimal:2',
        'iva_comision' => 'decimal:2',
        'total_comision' => 'decimal:2',
        'monto_recibir' => 'decimal:2',
        'estatus' => 'integer'
    ];

    // Constantes de estatus
    const ESTATUS_SOLICITADO = 1;
    const ESTATUS_AUTORIZADO = 2;
    const ESTATUS_LIQUIDADO = 3;
    const ESTATUS_RECHAZADO = 4;
    const ESTATUS_VENCIDO = 5;

    // Relaciones
    public function factor()
    {
        return $this->belongsTo(FactorFinanciero::class, 'factor_id', 'factor_id');
    }

    // Relación con Contacto (usando el namespace correcto)
    public function contacto()
    {
        return $this->belongsTo(Contacto::class, 'contacto_id', 'contacto_id');
    }

    // Relación con Factura a través de la tabla pivote
    public function facturas()
    {
        return $this->belongsToMany(
            Factura::class, 
            'factoraje_facturas', 
            'solicitud_id', 
            'factura_id'
        )->withPivot('id', 'monto_factura', 'pagada_cliente', 'fecha_pago_cliente')
         ->withTimestamps();
    }
    
    // Relación con los detalles (alternativa)
    public function detalles()
    {
        return $this->hasMany(FactorajeFactura::class, 'solicitud_id', 'solicitud_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function autorizador()
    {
        return $this->belongsTo(User::class, 'autorizado_por', 'id');
    }

    // Scopes
    public function scopeSolicitados($query)
    {
        return $query->where('estatus', self::ESTATUS_SOLICITADO);
    }

    public function scopeAutorizados($query)
    {
        return $query->where('estatus', self::ESTATUS_AUTORIZADO);
    }

    public function scopeLiquidados($query)
    {
        return $query->where('estatus', self::ESTATUS_LIQUIDADO);
    }

    // Métodos de ayuda
    public function getEstatusTextoAttribute()
    {
        $map = [
            self::ESTATUS_SOLICITADO => 'Solicitado',
            self::ESTATUS_AUTORIZADO => 'Autorizado',
            self::ESTATUS_LIQUIDADO => 'Liquidado',
            self::ESTATUS_RECHAZADO => 'Rechazado',
            self::ESTATUS_VENCIDO => 'Vencido'
        ];
        return $map[$this->estatus] ?? 'Desconocido';
    }

    public function getBadgeClassAttribute()
    {
        $map = [
            self::ESTATUS_SOLICITADO => 'badge-warning',
            self::ESTATUS_AUTORIZADO => 'badge-info',
            self::ESTATUS_LIQUIDADO => 'badge-success',
            self::ESTATUS_RECHAZADO => 'badge-danger',
            self::ESTATUS_VENCIDO => 'badge-secondary'
        ];
        return $map[$this->estatus] ?? 'badge-secondary';
    }

    // Método para calcular montos automáticamente
    public function calcularMontos()
    {
        $this->monto_anticipo = ($this->monto_factura * $this->porcentaje_anticipo) / 100;
        
        $comisionPorcentaje = $this->factor->comision_default ?? 3;
        $this->comision = ($this->monto_factura * $comisionPorcentaje) / 100;
        $this->iva_comision = $this->comision * 0.16;
        $this->total_comision = $this->comision + $this->iva_comision;
        $this->monto_recibir = $this->monto_anticipo - $this->total_comision;
        
        return $this;
    }
}