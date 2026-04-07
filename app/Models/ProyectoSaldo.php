<?php
// app/Models/ProyectoSaldo.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoSaldo extends Model
{
    use HasFactory;
    
    protected $table = 'proyecto_saldos';
    
    protected $fillable = [
        'proyecto_id',
        'cuenta_bancaria_id',
        'saldo_asignado',
        'saldo_disponible',
        'total_ingresos',
        'total_egresos'
    ];
    
    protected $casts = [
        'saldo_asignado' => 'decimal:2',
        'saldo_disponible' => 'decimal:2',
        'total_ingresos' => 'decimal:2',
        'total_egresos' => 'decimal:2'
    ];
    
    // Relaciones
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
    
    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class);
    }
    
    // Métodos
    public function getSaldoUtilizadoAttribute()
    {
        return $this->total_egresos;
    }
    
    public function getPorcentajeUtilizadoAttribute()
    {
        if ($this->saldo_asignado > 0) {
            return ($this->total_egresos / $this->saldo_asignado) * 100;
        }
        return 0;
    }
}