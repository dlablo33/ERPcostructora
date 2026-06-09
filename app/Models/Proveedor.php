<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'proveedores';
    
    protected $fillable = [
        'nombre',
        'alias',
        'razon_social',
        'rfc',
        'regimen_fiscal',
        'email',
        'telefono',
        'contacto',
        'calle',
        'num_ext',
        'num_int',
        'colonia',
        'ciudad',
        'estado',
        'codigo_postal',
        'limite_credito',
        'credito_actual',
        'forma_pago',
        'metodo_pago',
        'uso_cfdi',
        'banco',
        'cuenta_bancaria',
        'cuenta_contable',
        'cuenta_secundaria',
        'cuenta_resultado',
        'direccion', // Mantener por compatibilidad
        'activo',
        'codigo_sat_default_id'  // NUEVO CAMPO
    ];
    
    protected $casts = [
        'activo' => 'boolean',
        'limite_credito' => 'decimal:2',
        'credito_actual' => 'decimal:2'
    ];
    
    // Relaciones existentes
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
    
    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class);
    }
    
    public function cotizacionesActivas()
    {
        return $this->cotizaciones()->where('estatus', 'Pendiente');
    }
    
    public function cotizacionesGanadoras()
    {
        return $this->cotizaciones()->where('estatus', 'Seleccionada');
    }
    
    // NUEVA RELACIÓN: Código SAT por defecto para gastos
    public function codigoSatDefault()
    {
        return $this->belongsTo(CodigoSat::class, 'codigo_sat_default_id');
    }
    
    // Método para obtener el código SAT sugerido para un pago
    public function getCodigoSatSugerido()
    {
        if ($this->codigo_sat_default_id) {
            return $this->codigoSatDefault;
        }
        
        // Si no tiene código asignado, retorna un código genérico de gastos de oficina
        return CodigoSat::where('codigo_agrupador', '515')->first();
    }
    
    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
    
    public function scopeConCodigoSatDefault($query)
    {
        return $query->whereNotNull('codigo_sat_default_id');
    }
    
    public function scopeSinCodigoSatDefault($query)
    {
        return $query->whereNull('codigo_sat_default_id');
    }
    
    // Accesor para obtener dirección completa
    public function getDireccionCompletaAttribute()
    {
        $direccion = [];
        if ($this->calle) $direccion[] = $this->calle;
        if ($this->num_ext) $direccion[] = $this->num_ext;
        if ($this->num_int) $direccion[] = 'Int ' . $this->num_int;
        if ($this->colonia) $direccion[] = $this->colonia;
        if ($this->ciudad) $direccion[] = $this->ciudad;
        if ($this->estado) $direccion[] = $this->estado;
        if ($this->codigo_postal) $direccion[] = 'CP ' . $this->codigo_postal;
        
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
}