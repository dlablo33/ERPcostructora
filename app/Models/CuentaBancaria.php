<?php
// app/Models/CuentaBancaria.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuentaBancaria extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'cuentas_bancarias';
    
    protected $fillable = [
        'banco_id',
        'moneda_id',
        'proyecto_id',
        'cuenta_contable_id',
        'numero_cuenta',
        'clabe',
        'titular',
        'tipo_cuenta',
        'saldo_inicial',
        'saldo_actual',
        'activa',
        'created_by'
    ];
    
    protected $casts = [
        'saldo_inicial' => 'decimal:2',
        'saldo_actual' => 'decimal:2',
        'activa' => 'boolean'
    ];
    
    // Relaciones
    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }
    
    public function moneda()
    {
        return $this->belongsTo(Moneda::class);
    }
    
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
    
    public function cuentaContable()
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_contable_id');
    }
    
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function movimientos()
    {
        return $this->hasMany(MovimientoBancario::class);
    }
    
    // Scopes
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }
    
    public function scopePorProyecto($query, $proyectoId)
    {
        return $query->where('proyecto_id', $proyectoId);
    }
    
    // Métodos
    public function actualizarSaldo()
    {
        $totalIngresos = $this->movimientos()
            ->where('tipo', 'ingreso')
            ->where('status', 'aplicado')
            ->sum('monto');
            
        $totalEgresos = $this->movimientos()
            ->where('tipo', 'egreso')
            ->where('status', 'aplicado')
            ->sum('monto');
            
        $this->saldo_actual = $this->saldo_inicial + $totalIngresos - $totalEgresos;
        $this->save();
        
        return $this->saldo_actual;
    }
    
    public function getSaldoDisponibleAttribute()
    {
        return $this->saldo_actual;
    }
    
    public function getNumeroFormateadoAttribute()
    {
        if (strlen($this->numero_cuenta) > 8) {
            return '****' . substr($this->numero_cuenta, -4);
        }
        return $this->numero_cuenta;
    }
    
    public function getClabeFormateadaAttribute()
    {
        if ($this->clabe && strlen($this->clabe) == 18) {
            return substr($this->clabe, 0, 6) . '****' . substr($this->clabe, -4);
        }
        return $this->clabe;
    }
}