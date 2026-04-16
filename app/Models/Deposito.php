<?php
// app/Models/Deposito.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Deposito extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'depositos';
    
    protected $fillable = [
        'folio',
        'fecha',
        'monto',
        'concepto',
        'cuenta_bancaria_id',
        'proyecto_id',
        'tipo_ingreso_id',
        'estatus',
        'referencia',
        'comprobante',
        'observaciones',
        'created_by'
    ];
    
    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2'
    ];
    
    // Relaciones
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
    
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estatus', 'pendiente');
    }
    
    public function scopeAplicados($query)
    {
        return $query->where('estatus', 'aplicado');
    }
    
    public function scopePorFecha($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
    }
    
    // Método para aplicar el depósito (crear movimiento bancario)
    public function aplicar()
{
    if ($this->estatus !== 'pendiente') {
        return false;
    }
    
    DB::beginTransaction();
    
    try {
        // Crear movimiento bancario
        $movimiento = MovimientoBancario::create([
            'cuenta_bancaria_id' => $this->cuenta_bancaria_id,
            'proyecto_id' => $this->proyecto_id,
            'tipo' => 'ingreso',
            'tipo_ingreso_id' => $this->tipo_ingreso_id,
            'metodo_pago_id' => 1,
            'monto' => $this->monto,
            'fecha' => $this->fecha,
            'concepto' => $this->concepto,
            'referencia' => $this->referencia,
            'comprobante' => $this->comprobante,
            'status' => 'aplicado',
            'observaciones' => 'Depósito automático: ' . ($this->observaciones ?? ''),
            'created_by' => $this->created_by
        ]);
        
        // Actualizar saldo de la cuenta bancaria
        $cuenta = CuentaBancaria::find($this->cuenta_bancaria_id);
        if ($cuenta) {
            $cuenta->saldo_actual = $cuenta->saldo_actual + $this->monto;
            $cuenta->save();
        }
        
        $this->estatus = 'aplicado';
        $this->save();
        
        DB::commit();
        
        return $movimiento;
    } catch (\Exception $e) {
        DB::rollBack();
        throw $e;
    }
}
    
    // Generar folio automático
    public static function generarFolio()
    {
        $year = date('Y');
        $month = date('m');
        $last = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($last) {
            $num = intval(substr($last->folio, -4)) + 1;
        } else {
            $num = 1;
        }
        
        return 'DEP-' . $year . $month . '-' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}