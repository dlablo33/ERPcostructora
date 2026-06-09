<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CodigoSat;

class Contacto extends Model
{
    use SoftDeletes;

    protected $table = 'contactos';
    protected $primaryKey = 'contacto_id';
    
    protected $fillable = [
        'razon_social', 
        'rfc', 
        'nombre_comercial', 
        'email_facturacion', 
        'telefono',
        'satcat_regimen_fiscal_clave', 
        'satcat_uso_cfdi_clave', 
        'satcat_formas_pago_clave',
        'satcat_metodos_pago_clave', 
        'calle', 
        'num_exterior', 
        'num_interior', 
        'colonia',
        'codigo_postal', 
        'municipio', 
        'estado', 
        'pais', 
        'tipo', 
        'dias_credito', 
        'limite_credito', 
        'estatus',
        'codigo_sat_default_id'  // NUEVO CAMPO
    ];

    protected $casts = [
        'estatus' => 'boolean', 
        'dias_credito' => 'integer', 
        'limite_credito' => 'decimal:2'
    ];

    // Relaciones existentes
    public function regimenFiscal() 
    { 
        return $this->belongsTo(SatcatRegimenFiscal::class, 'satcat_regimen_fiscal_clave', 'clave'); 
    }
    
    public function usoCfdi() 
    { 
        return $this->belongsTo(SatcatUsoCfdi::class, 'satcat_uso_cfdi_clave', 'clave'); 
    }
    
    public function formaPago() 
    { 
        return $this->belongsTo(SatcatFormaPago::class, 'satcat_formas_pago_clave', 'clave'); 
    }
    
    public function metodoPago() 
    { 
        return $this->belongsTo(SatcatMetodoPago::class, 'satcat_metodos_pago_clave', 'clave'); 
    }
    
    public function facturas() 
    { 
        return $this->hasMany(Factura::class, 'contacto_id'); 
    }
    
    public function contrarecibos()
    {
        return $this->hasMany(Contrarecibo::class, 'contacto_id', 'contacto_id');
    }
    
    // NUEVA RELACIÓN: Código SAT por defecto para ingresos
    public function codigoSatDefault()
    {
        return $this->belongsTo(CodigoSat::class, 'codigo_sat_default_id');
    }
    
    // Método para obtener el código SAT sugerido para un depósito/ingreso
    public function getCodigoSatSugerido()
    {
        if ($this->codigo_sat_default_id) {
            return $this->codigoSatDefault;
        }
        
        // Si no tiene código asignado, retorna un código genérico de ventas
        return CodigoSat::where('codigo_agrupador', '401')->first();
    }
    
    // Scopes
    public function scopeClientes($query)
    {
        return $query->where('tipo', 'cliente');
    }
    
    public function scopeProveedores($query)
    {
        return $query->where('tipo', 'proveedor');
    }
    
    public function scopeActivos($query)
    {
        return $query->where('estatus', true);
    }
    
    public function scopeConCodigoSatDefault($query)
    {
        return $query->whereNotNull('codigo_sat_default_id');
    }
    
    public function scopeSinCodigoSatDefault($query)
    {
        return $query->whereNull('codigo_sat_default_id');
    }
    
    // Accesores
    public function getNombreCompletoAttribute()
    {
        return $this->razon_social;
    }
    
    public function getDireccionCompletaAttribute()
    {
        $direccion = [];
        if ($this->calle) $direccion[] = $this->calle;
        if ($this->num_exterior) $direccion[] = $this->num_exterior;
        if ($this->num_interior) $direccion[] = 'Int ' . $this->num_interior;
        if ($this->colonia) $direccion[] = $this->colonia;
        if ($this->codigo_postal) $direccion[] = 'CP ' . $this->codigo_postal;
        if ($this->municipio) $direccion[] = $this->municipio;
        if ($this->estado) $direccion[] = $this->estado;
        
        return implode(', ', $direccion);
    }
    
    // Accesor para obtener el nombre del código SAT por defecto
    public function getCodigoSatDefaultNombreAttribute()
    {
        return $this->codigoSatDefault ? $this->codigoSatDefault->nombre_cuenta : 'Sin asignar';
    }
    
    // Accesor para obtener el código agrupador SAT por defecto
    public function getCodigoSatDefaultCodigoAttribute()
    {
        return $this->codigoSatDefault ? $this->codigoSatDefault->codigo_agrupador : 'N/A';
    }
    
    // Método para verificar si es cliente
    public function esCliente()
    {
        return $this->tipo === 'cliente';
    }
    
    // Método para verificar si es proveedor
    public function esProveedor()
    {
        return $this->tipo === 'proveedor';
    }
}