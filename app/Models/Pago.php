<?php
// app/Models/Pago.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Pago extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'pagos';
    
    protected $fillable = [
        'folio',
        'fecha_pago',
        'monto',
        'concepto',
        'cuenta_bancaria_id',
        'proveedor_id',
        'proyecto_id',
        'tipo_egreso_id',
        'categoria_gasto_id',
        'metodo_pago_id',
        'moneda_id',
        'proveedor_nombre',
        'proveedor_rfc',
        'referencia',
        'referencia_bancaria',
        'factura',
        'estatus',
        'comprobante',
        'observaciones',
        'created_by'
    ];
    
    protected $casts = [
        'fecha_pago' => 'date',
        'monto' => 'decimal:2'
    ];
    
    // Relaciones
    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class);
    }
    
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
    
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
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
    
    public function moneda()
    {
        return $this->belongsTo(Moneda::class);
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
    
    public function scopeCompletados($query)
    {
        return $query->where('estatus', 'completado');
    }
    
    public function scopePorFecha($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_pago', [$fechaInicio, $fechaFin]);
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
        
        if ($last && $last->folio) {
            $num = intval(substr($last->folio, -4)) + 1;
        } else {
            $num = 1;
        }
        
        return 'PAG-' . $year . $month . '-' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
    
    // Aplicar pago (actualizar saldo de cuenta bancaria)
    public function aplicar()
    {
        if ($this->estatus !== 'pendiente') {
            return false;
        }
        
        DB::beginTransaction();
        
        try {
            // Actualizar saldo de la cuenta bancaria (EGRESO - se resta)
            $cuenta = CuentaBancaria::find($this->cuenta_bancaria_id);
            if ($cuenta) {
                $cuenta->saldo_actual = $cuenta->saldo_actual - $this->monto;
                $cuenta->save();
            }
            
            // Crear movimiento bancario
            $movimiento = MovimientoBancario::create([
                'cuenta_bancaria_id' => $this->cuenta_bancaria_id,
                'proyecto_id' => $this->proyecto_id,
                'tipo' => 'egreso',
                'tipo_egreso_id' => $this->tipo_egreso_id,
                'categoria_gasto_id' => $this->categoria_gasto_id,
                'metodo_pago_id' => $this->metodo_pago_id,
                'monto' => $this->monto,
                'fecha' => $this->fecha_pago,
                'concepto' => $this->concepto,
                'referencia' => $this->referencia,
                'comprobante' => $this->comprobante,
                'status' => 'aplicado',
                'observaciones' => 'Pago: ' . ($this->observaciones ?? ''),
                'created_by' => $this->created_by
            ]);
            
            $this->estatus = 'completado';
            $this->save();
            
            DB::commit();
            
            return $movimiento;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}