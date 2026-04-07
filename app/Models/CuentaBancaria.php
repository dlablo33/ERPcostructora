<?php
// app/Models/CuentaBancaria.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'banco_id', 'proyecto_id', 'moneda_id', 'numero_cuenta', 
        'clabe', 'titular', 'saldo_inicial', 'saldo_actual', 'activa'
    ];
    
    protected $casts = [
        'saldo_inicial' => 'decimal:2',
        'saldo_actual' => 'decimal:2'
    ];
    
    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }
    
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
    
    public function moneda()
    {
        return $this->belongsTo(Moneda::class);
    }
    
    public function movimientos()
    {
        return $this->hasMany(MovimientoBancario::class);
    }
    
    public function saldosProyecto()
    {
        return $this->hasMany(ProyectoSaldo::class);
    }
    
    public function actualizarSaldo()
    {
        $totalIngresos = $this->movimientos()->where('tipo', 'ingreso')->where('status', 'aplicado')->sum('monto');
        $totalEgresos = $this->movimientos()->where('tipo', 'egreso')->where('status', 'aplicado')->sum('monto');
        $this->saldo_actual = $this->saldo_inicial + $totalIngresos - $totalEgresos;
        $this->save();
        
        return $this->saldo_actual;
    }
}