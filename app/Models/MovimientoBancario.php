<?php
// app/Models/MovimientoBancario.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovimientoBancario extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'cuenta_bancaria_id', 'proyecto_id', 'tipo', 'tipo_ingreso_id', 
        'tipo_egreso_id', 'categoria_gasto_id', 'metodo_pago_id', 'monto', 
        'fecha', 'concepto', 'referencia', 'comprobante', 'status', 
        'observaciones', 'created_by'
    ];
    
    protected $casts = [
        'monto' => 'decimal:2',
        'fecha' => 'date'
    ];
    
    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class);
    }
    
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
    
    public function tipoIngreso()
    {
        return $this->belongsTo(TipoIngreso::class);
    }
    
    public function tipoEgreso()
    {
        return $this->belongsTo(TipoEgreso::class);
    }
    
    public function categoriaGasto()
    {
        return $this->belongsTo(CategoriaGasto::class);
    }
    
    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class);
    }
    
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function aplicar()
    {
        $this->status = 'aplicado';
        $this->save();
        
        // Actualizar saldo de la cuenta
        $this->cuentaBancaria->actualizarSaldo();
        
        // Actualizar saldo del proyecto
        $proyectoSaldo = ProyectoSaldo::firstOrNew([
            'proyecto_id' => $this->proyecto_id,
            'cuenta_bancaria_id' => $this->cuenta_bancaria_id
        ]);
        
        if ($this->tipo === 'ingreso') {
            $proyectoSaldo->total_ingresos += $this->monto;
            $proyectoSaldo->saldo_disponible += $this->monto;
        } else {
            $proyectoSaldo->total_egresos += $this->monto;
            $proyectoSaldo->saldo_disponible -= $this->monto;
        }
        
        $proyectoSaldo->save();
    }
}