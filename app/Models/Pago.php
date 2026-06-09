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
        'created_by',
        // NUEVOS CAMPOS
        'codigo_sat_id',
        'cuenta_contable_id'
    ];
    
    protected $casts = [
        'fecha_pago' => 'date',
        'monto' => 'decimal:2'
    ];
    
    // Relaciones existentes
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
    
    // NUEVAS RELACIONES SAT
    public function codigoSat()
    {
        return $this->belongsTo(CodigoSat::class, 'codigo_sat_id');
    }
    
    public function cuentaContable()
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_contable_id');
    }
    
    // Scopes existentes
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
    
    // NUEVOS SCOPES
    public function scopeConCodigoSat($query)
    {
        return $query->whereNotNull('codigo_sat_id');
    }
    
    public function scopeSinCodigoSat($query)
    {
        return $query->whereNull('codigo_sat_id');
    }
    
    public function scopePorCodigoSat($query, $codigoSatId)
    {
        return $query->where('codigo_sat_id', $codigoSatId);
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
    
    // NUEVO MÉTODO: Obtener código SAT sugerido desde el proveedor
    public function getCodigoSatSugeridoAttribute()
    {
        if ($this->proveedor && $this->proveedor->codigoSatDefault) {
            return $this->proveedor->codigoSatDefault;
        }
        
        // Código genérico de gastos de oficina (515)
        return CodigoSat::where('codigo_agrupador', '515')->first();
    }
    
    // NUEVO MÉTODO: Asignar automáticamente el código SAT desde el proveedor
    public function asignarCodigoSatDesdeProveedor()
    {
        if ($this->proveedor && $this->proveedor->codigo_sat_default_id) {
            $this->codigo_sat_id = $this->proveedor->codigo_sat_default_id;
            return true;
        }
        return false;
    }
    
    // NUEVO MÉTODO: Verificar si el pago tiene código SAT válido
    public function tieneCodigoSatValido()
    {
        return $this->codigo_sat_id && $this->codigoSat && in_array($this->codigoSat->tipo, ['G', 'A']);
    }
    
    // Aplicar pago (actualizar saldo de cuenta bancaria) - ACTUALIZADO
    public function aplicar()
    {
        if ($this->estatus !== 'pendiente') {
            return false;
        }
        
        // Validar que tenga código SAT asignado
        if (!$this->codigo_sat_id) {
            throw new \Exception('El pago no tiene un código SAT asignado.');
        }
        
        DB::beginTransaction();
        
        try {
            // Actualizar saldo de la cuenta bancaria (EGRESO - se resta)
            $cuenta = CuentaBancaria::find($this->cuenta_bancaria_id);
            if ($cuenta) {
                $cuenta->saldo_actual = $cuenta->saldo_actual - $this->monto;
                $cuenta->save();
            }
            
            // Crear movimiento bancario con código SAT
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
                'created_by' => $this->created_by,
                'codigo_sat_id' => $this->codigo_sat_id  // NUEVO
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
    
    // NUEVO MÉTODO: Accesor para obtener el nombre del código SAT
    public function getCodigoSatNombreAttribute()
    {
        return $this->codigoSat ? $this->codigoSat->nombre_cuenta : 'Sin asignar';
    }
    
    // NUEVO MÉTODO: Accesor para obtener el código agrupador SAT
    public function getCodigoSatCodigoAttribute()
    {
        return $this->codigoSat ? $this->codigoSat->codigo_agrupador : 'N/A';
    }
}