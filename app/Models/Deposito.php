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
        'created_by',
        // NUEVOS CAMPOS
        'codigo_sat_id',
        'cuenta_contable_id'
    ];
    
    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2'
    ];
    
    // Relaciones existentes
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
    
    // NUEVAS RELACIONES SAT
    public function codigoSat()
    {
        return $this->belongsTo(CodigoSat::class, 'codigo_sat_id');
    }
    
    public function cuentaContable()
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_contable_id');
    }
    
    // Relación con Contacto (cliente) - si tienes el campo contacto_id
    public function contacto()
    {
        return $this->belongsTo(\App\Models\Facturacion\Contacto::class, 'contacto_id', 'contacto_id');
    }
    
    // Scopes existentes
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
        
        if ($last) {
            $num = intval(substr($last->folio, -4)) + 1;
        } else {
            $num = 1;
        }
        
        return 'DEP-' . $year . $month . '-' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
    
    // NUEVO MÉTODO: Obtener código SAT sugerido desde el contacto/cliente
    public function getCodigoSatSugeridoAttribute()
    {
        if ($this->contacto && $this->contacto->codigoSatDefault) {
            return $this->contacto->codigoSatDefault;
        }
        
        // Código genérico de ventas (401)
        return CodigoSat::where('codigo_agrupador', '401')->first();
    }
    
    // NUEVO MÉTODO: Asignar automáticamente el código SAT desde el cliente
    public function asignarCodigoSatDesdeCliente()
    {
        if ($this->contacto && $this->contacto->codigo_sat_default_id) {
            $this->codigo_sat_id = $this->contacto->codigo_sat_default_id;
            return true;
        }
        return false;
    }
    
    // NUEVO MÉTODO: Verificar si el depósito tiene código SAT válido
    public function tieneCodigoSatValido()
    {
        return $this->codigo_sat_id && $this->codigoSat && $this->codigoSat->tipo === 'I';
    }
    
    // Método para aplicar el depósito (crear movimiento bancario) - ACTUALIZADO
    public function aplicar()
    {
        if ($this->estatus !== 'pendiente') {
            return false;
        }
        
        // Validar que tenga código SAT asignado
        if (!$this->codigo_sat_id) {
            throw new \Exception('El depósito no tiene un código SAT asignado.');
        }
        
        DB::beginTransaction();
        
        try {
            // Crear movimiento bancario con código SAT
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
                'created_by' => $this->created_by,
                'codigo_sat_id' => $this->codigo_sat_id  // NUEVO
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
    
    // NUEVO MÉTODO: Obtener el tipo de ingreso formateado
    public function getTipoIngresoNombreAttribute()
    {
        return $this->tipoIngreso ? $this->tipoIngreso->nombre : 'N/A';
    }
}