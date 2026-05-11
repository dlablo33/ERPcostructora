<?php
// app/Models/Facturacion/NotaCredito.php

namespace App\Models\Facturacion;

class NotaCredito extends Factura
{
    // Este modelo extiende Factura, por lo que usa la misma tabla
    // pero con comportamiento específico para notas de crédito
    
    protected $table = 'facturas';
    
    // El constructor puede forzar el tipo_comprobante
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['tipo_comprobante'] = 'E';
    }
    
    // Scope para filtrar solo notas de crédito
    protected static function booted()
    {
        static::addGlobalScope('tipo_comprobante', function ($builder) {
            $builder->where('tipo_comprobante', 'E');
        });
    }
    
    // Métodos específicos para notas de crédito
    public function getMotivoAttribute()
    {
        return $this->motivo_nota_credito;
    }
    
    public function getMontoAcreditarAttribute()
    {
        return abs($this->total);
    }
}