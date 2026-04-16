<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ChequeTransferencia extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'cheques_transferencias';
    
    protected $fillable = [
        'folio',
        'estatus',
        'forma_pago',
        'proveedor',
        'rfc',
        'cuenta_bancaria_id',
        'referencia',
        'referencia_bancaria',
        'fecha',
        'fecha_vencimiento',
        'monto',
        'monto_restante',
        'moneda_id',
        'tipo_cambio',
        'monto_original',
        'descripcion',
        'comprobante',
        'poliza_contable',
        'cuenta_contable_id',
        'proyecto_id',
        'observaciones',
        'created_by'
    ];
    
    protected $casts = [
        'fecha' => 'date',
        'fecha_vencimiento' => 'date',
        'monto' => 'decimal:2',
        'monto_restante' => 'decimal:2',
        'tipo_cambio' => 'decimal:4',
        'monto_original' => 'decimal:2'
    ];
    
    // Relaciones
    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class);
    }
    
    public function moneda()
    {
        return $this->belongsTo(Moneda::class);
    }
    
    public function cuentaContable()
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_contable_id');
    }
    
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
    
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public static function generarFolio()
    {
        $year = date('Y');
        $month = date('m');
        $last = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($last && $last->folio) {
            $num = intval(substr($last->folio, -4)) + 1;
        } else {
            $num = 1;
        }
        
        return 'CT-' . $year . $month . '-' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
    
    // MÉTODO PARA ACTUALIZAR EL SALDO DE LA CUENTA BANCARIA
    public function aplicar()
    {
        if ($this->estatus !== 'activo') {
            return false;
        }
        
        DB::beginTransaction();
        
        try {
            // Actualizar saldo de la cuenta bancaria (ES EGRESO, se resta)
            $cuenta = CuentaBancaria::find($this->cuenta_bancaria_id);
            if ($cuenta) {
                $cuenta->saldo_actual = $cuenta->saldo_actual - $this->monto;
                $cuenta->save();
            }
            
            // Crear movimiento bancario (EGRESO)
            $movimiento = MovimientoBancario::create([
                'cuenta_bancaria_id' => $this->cuenta_bancaria_id,
                'proyecto_id' => $this->proyecto_id,
                'tipo' => 'egreso',
                'tipo_egreso_id' => null, // Puedes crear un tipo de egreso para cheques/transferencias
                'categoria_gasto_id' => null,
                'metodo_pago_id' => $this->forma_pago === 'cheque' ? 2 : 1, // 1=Transferencia, 2=Cheque
                'monto' => $this->monto,
                'fecha' => $this->fecha,
                'concepto' => $this->concepto,
                'referencia' => $this->referencia,
                'comprobante' => $this->comprobante,
                'status' => 'aplicado',
                'observaciones' => 'Cheque/Transferencia: ' . ($this->observaciones ?? ''),
                'created_by' => $this->created_by
            ]);
            
            DB::commit();
            
            return $movimiento;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    // Método para cancelar y revertir el saldo
    public function cancelar()
    {
        if ($this->estatus !== 'activo') {
            return false;
        }
        
        DB::beginTransaction();
        
        try {
            // Revertir saldo de la cuenta bancaria (se suma de nuevo)
            $cuenta = CuentaBancaria::find($this->cuenta_bancaria_id);
            if ($cuenta) {
                $cuenta->saldo_actual = $cuenta->saldo_actual + $this->monto;
                $cuenta->save();
            }
            
            $this->estatus = 'cancelado';
            $this->save();
            
            DB::commit();
            
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}