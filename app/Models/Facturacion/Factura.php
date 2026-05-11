<?php

namespace App\Models\Facturacion;

use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{
    use SoftDeletes;

    protected $table = 'facturas';
    protected $primaryKey = 'factura_id';
    
    protected $fillable = [
        'contacto_id', 'proyecto_id', 'cat_serie_id', 'cat_sucursal_id', 'folio', 'fecha',
        'fecha_vencimiento', 'fecha_revision', 'satcat_metodos_pago_clave', 'satcat_formas_pago_clave',
        'satcat_uso_cfdi_clave', 'satcat_regimen_fiscal_clave', 'cat_monedas_clave', 'tipo_cambio',
        'subtotal', 'descuento', 'iva', 'riva', 'total', 'saldo_disponible', 'observaciones', 
        'referencia', 'estatus', 'xml', 'version', 'poliza_contable_id', 'created_by', 'refacturacion',
        // NUEVOS CAMPOS PARA NOTAS DE CRÉDITO
        'tipo_comprobante',           // I = Factura, E = Nota de Crédito
        'factura_relacionada_id',     // ID de la factura original (solo para NC)
        'motivo_nota_credito'         // Motivo de la nota de crédito
    ];

    protected $casts = [
        'fecha' => 'date', 
        'fecha_vencimiento' => 'date', 
        'fecha_revision' => 'datetime',
        'tipo_cambio' => 'decimal:6', 
        'subtotal' => 'decimal:2', 
        'descuento' => 'decimal:2',
        'iva' => 'decimal:2', 
        'riva' => 'decimal:2', 
        'total' => 'decimal:2',
        'saldo_disponible' => 'decimal:2',
        'version' => 'integer',
        'refacturacion' => 'boolean',
    ];

    // Relaciones existentes
    public function contacto() { return $this->belongsTo(Contacto::class, 'contacto_id'); }
    public function proyecto() { return $this->belongsTo(Proyecto::class, 'proyecto_id'); }
    public function serie() { return $this->belongsTo(CatSerie::class, 'cat_serie_id'); }
    public function sucursal() { return $this->belongsTo(CatSucursal::class, 'cat_sucursal_id'); }
    public function metodoPago() { return $this->belongsTo(SatcatMetodoPago::class, 'satcat_metodos_pago_clave', 'clave'); }
    public function formaPago() { return $this->belongsTo(SatcatFormaPago::class, 'satcat_formas_pago_clave', 'clave'); }
    public function usoCfdi() { return $this->belongsTo(SatcatUsoCfdi::class, 'satcat_uso_cfdi_clave', 'clave'); }
    public function regimenFiscal() { return $this->belongsTo(SatcatRegimenFiscal::class, 'satcat_regimen_fiscal_clave', 'clave'); }
    public function moneda() { return $this->belongsTo(CatMoneda::class, 'cat_monedas_clave', 'codigo'); }
    public function conceptos() { return $this->hasMany(FacturaConcepto::class, 'factura_id'); }
    public function cfdi() { return $this->hasOne(CFDI::class, 'factura_id'); }
    public function polizaContable() { return $this->belongsTo(PolizaContable::class, 'poliza_contable_id'); }
    public function creador() { return $this->belongsTo(User::class, 'created_by'); }
    public function bitacora() { return $this->hasMany(BitacoraFactura::class, 'factura_id'); }
    public function relacionadas() { return $this->hasMany(FacturaRelacionado::class, 'factura_id'); }
    public function cancelacion() { return $this->hasOne(FacturaCancelada::class, 'factura_id'); }

    // NUEVAS RELACIONES PARA NOTAS DE CRÉDITO
    public function facturaRelacionada()
    {
        return $this->belongsTo(Factura::class, 'factura_relacionada_id', 'factura_id');
    }

    public function notasCredito()
    {
        return $this->hasMany(Factura::class, 'factura_relacionada_id', 'factura_id');
    }

    // NUEVO: Obtener el saldo disponible de la factura
    public function getSaldoDisponibleAttribute()
    {
        if ($this->esNotaCredito()) {
            return 0;
        }
        
        // Si ya tiene saldo_disponible guardado, usarlo
        if ($this->saldo_disponible !== null) {
            return $this->saldo_disponible;
        }
        
        // Calcular saldo: total - suma de notas de crédito aplicadas
        $notasAplicadas = $this->notasCredito()
            ->where('estatus', 19)
            ->sum('total');
        
        return $this->total - abs($notasAplicadas);
    }

    // NUEVO: Verificar si la factura tiene saldo disponible
    public function tieneSaldoDisponible()
    {
        return $this->getSaldoDisponibleAttribute() > 0;
    }

    // NUEVO: Obtener el porcentaje de la factura que ha sido abonado
    public function getPorcentajeAbonadoAttribute()
    {
        if ($this->total <= 0) return 0;
        $abonado = $this->total - $this->getSaldoDisponibleAttribute();
        return round(($abonado / $this->total) * 100, 2);
    }

    // NUEVO: Obtener el total de notas de crédito aplicadas
    public function getTotalNotasCreditoAttribute()
    {
        return abs($this->notasCredito()
            ->where('estatus', 19)
            ->sum('total'));
    }

    // Scopes existentes
    public function scopeTimbradas($q) { return $q->where('estatus', 19); }
    public function scopeCanceladas($q) { return $q->where('estatus', 21); }
    public function scopeBorrador($q) { return $q->where('estatus', 1); }

    // NUEVOS SCOPES
    public function scopeFacturas($q) 
    { 
        return $q->where('tipo_comprobante', 'I')
                 ->whereNull('deleted_at');
    }
    
    public function scopeNotasCredito($q) 
    { 
        return $q->where('tipo_comprobante', 'E')
                 ->whereNull('deleted_at');
    }
    
    // NUEVO: Scope para facturas con saldo disponible
    public function scopeConSaldoDisponible($q)
    {
        return $q->facturas()
                 ->where(function($sub) {
                     $sub->where('saldo_disponible', '>', 0)
                         ->orWhereNull('saldo_disponible');
                 })
                 ->where('estatus', 19);
    }

    // MÉTODOS DE AYUDA
    public function esFactura()
    {
        return $this->tipo_comprobante === 'I' || $this->tipo_comprobante === null;
    }

    public function esNotaCredito()
    {
        return $this->tipo_comprobante === 'E';
    }

    public function getMontoAbsolutoAttribute()
    {
        return abs($this->total);
    }

    public function getTipoComprobanteTextoAttribute()
    {
        return $this->esFactura() ? 'Factura' : 'Nota de Crédito';
    }
    
    // NUEVO: Método para actualizar el saldo disponible
    public function actualizarSaldoDisponible()
    {
        $nuevoSaldo = $this->total - $this->getTotalNotasCreditoAttribute();
        $this->saldo_disponible = max(0, $nuevoSaldo);
        $this->saveQuietly(); // Guardar sin disparar eventos
        return $this->saldo_disponible;
    }
    
    // NUEVO: Método para verificar si se puede aplicar una nota de crédito
    public function puedeAplicarNotaCredito($monto)
    {
        return $this->esFactura() && 
               $this->estatus === 19 && 
               $this->getSaldoDisponibleAttribute() >= $monto;
    }

    // En app/Models/Facturacion/Factura.php
// Agregar esta relación

public function contrarecibos()
{
    return $this->belongsToMany(Contrarecibo::class, 'contrarecibo_facturas', 'factura_id', 'contrarecibo_id')
                ->withPivot('monto_aplicado')
                ->withTimestamps();
}

// app/Models/Facturacion/Factura.php

// Agrega este método para verificar si la factura ya está en proceso de factoraje
public function estaEnFactoraje()
{
    return $this->factorajeDetalles()
        ->whereHas('solicitud', function($q) {
            $q->whereIn('estatus', [
                \App\Models\SolicitudFactoraje::ESTATUS_SOLICITADO,
                \App\Models\SolicitudFactoraje::ESTATUS_AUTORIZADO
            ]);
        })
        ->exists();
}

// Agrega este método para obtener la solicitud de factoraje activa
public function solicitudFactorajeActiva()
{
    return $this->factorajeDetalles()
        ->whereHas('solicitud', function($q) {
            $q->whereIn('estatus', [
                \App\Models\SolicitudFactoraje::ESTATUS_SOLICITADO,
                \App\Models\SolicitudFactoraje::ESTATUS_AUTORIZADO
            ]);
        })
        ->with('solicitud')
        ->first();
}
}