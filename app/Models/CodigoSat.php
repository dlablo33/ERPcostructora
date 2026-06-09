<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoSat extends Model
{
    use HasFactory;
    
    protected $table = 'codigos_sat';
    
    protected $fillable = [
        'codigo_agrupador',
        'nivel',
        'nombre_cuenta',
        'tipo'
    ];
    
    protected $casts = [
        'nivel' => 'integer'
    ];
    
    // Relaciones
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'codigo_sat_id');
    }
    
    public function depositos()
    {
        return $this->hasMany(Deposito::class, 'codigo_sat_id');
    }
    
    public function proveedoresDefault()
    {
        return $this->hasMany(Proveedor::class, 'codigo_sat_default_id');
    }
    
    public function contactosDefault()
    {
        return $this->hasMany(Contacto::class, 'codigo_sat_default_id');
    }
    
    // Scopes por tipo
    public function scopeIngresos($query)
    {
        return $query->where('tipo', 'I');
    }
    
    public function scopeGastos($query)
    {
        return $query->where('tipo', 'G');
    }
    
    public function scopeActivos($query)
    {
        return $query->where('tipo', 'A');
    }
    
    public function scopePasivos($query)
    {
        return $query->where('tipo', 'P');
    }
    
    public function scopeCapital($query)
    {
        return $query->where('tipo', 'C');
    }
    
    public function scopeOrden($query)
    {
        return $query->where('tipo', 'O');
    }
    
    // Scope por nivel
    public function scopeNivel($query, $nivel)
    {
        return $query->where('nivel', $nivel);
    }
    
    // Scope para códigos principales (nivel 1)
    public function scopePrincipales($query)
    {
        return $query->where('nivel', 1);
    }
    
    // Scope para subcuentas (nivel > 1)
    public function scopeSubcuentas($query)
    {
        return $query->where('nivel', '>', 1);
    }
    
    // Método para obtener el padre (si aplica)
    public function padre()
    {
        if ($this->nivel <= 1) {
            return null;
        }
        
        // Buscar el código padre (sin el último segmento)
        $partes = explode('.', $this->codigo_agrupador);
        if (count($partes) > 1) {
            array_pop($partes);
            $codigoPadre = implode('.', $partes);
            return self::where('codigo_agrupador', $codigoPadre)->first();
        }
        
        return null;
    }
    
    // Método para obtener los hijos
    public function hijos()
    {
        return self::where('codigo_agrupador', 'LIKE', $this->codigo_agrupador . '.%')
            ->orderBy('codigo_agrupador')
            ->get();
    }
    
    // Accesor para saber si es cuenta de resultado (ingreso o gasto)
    public function getEsCuentaResultadoAttribute()
    {
        return in_array($this->tipo, ['I', 'G']);
    }
    
    // Accesor para saber si es cuenta de balance (activo, pasivo, capital)
    public function getEsCuentaBalanceAttribute()
    {
        return in_array($this->tipo, ['A', 'P', 'C']);
    }
}