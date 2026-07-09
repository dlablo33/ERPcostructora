<?php
// app/Models/ChequeTransferencia.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Facturacion\Contacto;
use App\Models\Facturacion\Factura;

class ChequeTransferencia extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'cheques_transferencias';
    
    protected $fillable = [
        'folio',
        'estatus',
        'forma_pago',
        'proveedor',
        'proveedor_id',
        'contacto_id',
        'cliente_id',
        'rfc',
        'cuenta_bancaria_id',
        'referencia',
        'referencia_bancaria',
        'fecha',
        'fecha_vencimiento',
        'monto',
        'monto_restante',
        'monto_aplicado',
        'moneda_id',
        'tipo_cambio',
        'monto_original',
        'descripcion',
        'comprobante',
        'poliza_contable',
        'cuenta_contable_id',
        'proyecto_id',
        'observaciones',
        'created_by',
        'codigo_sat_id',
        'tipo_aplicacion',
        'facturas_aplicadas',
        'tipo_operacion'
    ];
    
    protected $casts = [
        'fecha' => 'date',
        'fecha_vencimiento' => 'date',
        'monto' => 'decimal:2',
        'monto_restante' => 'decimal:2',
        'monto_aplicado' => 'decimal:2',
        'tipo_cambio' => 'decimal:4',
        'monto_original' => 'decimal:2',
        'facturas_aplicadas' => 'array'
    ];
    
    // ============================================
    // RELACIONES
    // ============================================
    
    /**
     * Relación con la cuenta bancaria
     */
    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class);
    }
    
    /**
     * Relación con la moneda
     */
    public function moneda()
    {
        return $this->belongsTo(Moneda::class);
    }
    
    /**
     * Relación con la cuenta contable
     */
    public function cuentaContable()
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_contable_id');
    }
    
    /**
     * Relación con el proyecto
     */
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
    
    /**
     * Relación con el usuario creador
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    /**
     * Relación con el proveedor
     */
    public function proveedorRel()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
    
    /**
     * Relación con el contacto (cliente/proveedor)
     */
    public function contactoRel()
    {
        return $this->belongsTo(Contacto::class, 'contacto_id', 'contacto_id');
    }
    
    /**
     * Relación con el cliente (para depósitos)
     */
    public function clienteRel()
    {
        return $this->belongsTo(Contacto::class, 'cliente_id', 'contacto_id');
    }
    
    /**
     * Relación con el código SAT
     */
    public function codigoSat()
    {
        return $this->belongsTo(CodigoSat::class, 'codigo_sat_id');
    }
    
    // ============================================
    // MÉTODOS
    // ============================================
    
    /**
     * Generar folio automático
     */
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
    
    /**
     * Obtener lista de facturas aplicadas
     */
    public function getFacturasAplicadasListAttribute()
    {
        if (!$this->facturas_aplicadas) {
            return collect();
        }
        
        $ids = array_keys($this->facturas_aplicadas);
        
        // Usar factura_id como clave primaria
        return Factura::whereIn('factura_id', $ids)->get()->map(function($factura) {
            $factura->monto_aplicado = $this->facturas_aplicadas[$factura->factura_id] ?? 0;
            return $factura;
        });
    }
    
    /**
     * Calcular total aplicado a facturas
     */
    public function calcularTotalAplicado()
    {
        if (!$this->facturas_aplicadas) {
            return 0;
        }
        return array_sum($this->facturas_aplicadas);
    }
    
    /**
     * Aplicar el registro (crear movimiento bancario)
     */
    public function aplicar()
    {
        if ($this->estatus !== 'activo') {
            return false;
        }
        
        DB::beginTransaction();
        
        try {
            $tipoMovimiento = $this->tipo_operacion === 'ingreso' ? 'ingreso' : 'egreso';
            $signo = $this->tipo_operacion === 'ingreso' ? 1 : -1;
            
            // Actualizar saldo de la cuenta bancaria
            $cuenta = CuentaBancaria::find($this->cuenta_bancaria_id);
            if ($cuenta) {
                $nuevoSaldo = $cuenta->saldo_actual + ($signo * $this->monto);
                $cuenta->saldo_actual = $nuevoSaldo;
                $cuenta->save();
            }
            
            // Obtener método de pago ID
            $metodoPagoId = $this->forma_pago === 'cheque' ? 2 : 1;
            
            // Determinar concepto
            $concepto = $this->descripcion ?? '';
            if (empty($concepto)) {
                if ($this->tipo_operacion === 'ingreso') {
                    $concepto = 'Depósito de cliente: ' . ($this->proveedor ?? 'Sin especificar');
                } else {
                    $concepto = 'Pago a proveedor: ' . ($this->proveedor ?? 'Sin especificar');
                }
            }
            
            // Crear movimiento bancario
            $movimiento = MovimientoBancario::create([
                'cuenta_bancaria_id' => $this->cuenta_bancaria_id,
                'proyecto_id' => $this->proyecto_id,
                'tipo' => $tipoMovimiento,
                'tipo_egreso_id' => null,
                'categoria_gasto_id' => null,
                'metodo_pago_id' => $metodoPagoId,
                'monto' => $this->monto,
                'fecha' => $this->fecha,
                'concepto' => $concepto,
                'referencia' => $this->referencia,
                'comprobante' => $this->comprobante,
                'status' => 'aplicado',
                'observaciones' => 'Cheque/Transferencia: ' . ($this->observaciones ?? ''),
                'created_by' => $this->created_by,
                'codigo_sat_id' => $this->codigo_sat_id
            ]);
            
            // Actualizar estatus
            $this->estatus = 'completado';
            $this->save();
            
            DB::commit();
            
            return $movimiento;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    /**
     * Cancelar el registro
     */
    public function cancelar()
    {
        if ($this->estatus !== 'activo') {
            return false;
        }
        
        DB::beginTransaction();
        
        try {
            // Revertir saldo de la cuenta bancaria
            $cuenta = CuentaBancaria::find($this->cuenta_bancaria_id);
            if ($cuenta) {
                $signo = $this->tipo_operacion === 'ingreso' ? -1 : 1;
                $cuenta->saldo_actual = $cuenta->saldo_actual + ($signo * $this->monto);
                $cuenta->save();
            }
            
            // Revertir saldos de facturas si las hay
            if ($this->facturas_aplicadas) {
                foreach ($this->facturas_aplicadas as $facturaId => $montoAplicado) {
                    // Usar factura_id
                    $factura = Factura::where('factura_id', $facturaId)->first();
                    if ($factura) {
                        $factura->saldo_disponible += $montoAplicado;
                        if ($factura->estatus === 'pagada') {
                            $factura->estatus = 'emitida';
                        }
                        $factura->save();
                    }
                }
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