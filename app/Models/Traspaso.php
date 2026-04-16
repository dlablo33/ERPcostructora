<?php
// app/Models/Traspaso.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Traspaso extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'traspasos';
    
    protected $fillable = [
        'folio',
        'fecha',
        'monto',
        'concepto',
        'cuenta_origen_id',
        'cuenta_destino_id',
        'moneda_origen_id',
        'moneda_destino_id',
        'tipo_cambio',
        'monto_destino',
        'estatus',
        'referencia',
        'referencia_bancaria',
        'poliza_contable',
        'proyecto_id',
        'observaciones',
        'comprobante',
        'created_by'
    ];
    
    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
        'tipo_cambio' => 'decimal:4',
        'monto_destino' => 'decimal:2'
    ];
    
    // Relaciones
    public function cuentaOrigen()
    {
        return $this->belongsTo(CuentaBancaria::class, 'cuenta_origen_id');
    }
    
    public function cuentaDestino()
    {
        return $this->belongsTo(CuentaBancaria::class, 'cuenta_destino_id');
    }
    
    public function monedaOrigen()
    {
        return $this->belongsTo(Moneda::class, 'moneda_origen_id');
    }
    
    public function monedaDestino()
    {
        return $this->belongsTo(Moneda::class, 'moneda_destino_id');
    }
    
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
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
        return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
    }
    
    public function scopePorCuentaOrigen($query, $cuentaId)
    {
        return $query->where('cuenta_origen_id', $cuentaId);
    }
    
    public function scopePorCuentaDestino($query, $cuentaId)
    {
        return $query->where('cuenta_destino_id', $cuentaId);
    }
    
    // Métodos
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
        
        return 'TRAS-' . $year . $month . '-' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
    
    public function getEstatusTextoAttribute()
    {
        $estatuses = [
            'pendiente' => 'Pendiente',
            'procesado' => 'Procesado',
            'completado' => 'Completado',
            'cancelado' => 'Cancelado'
        ];
        return $estatuses[$this->estatus] ?? 'Pendiente';
    }
    
    public function getMontoFormateadoAttribute()
    {
        $simbolo = $this->monedaOrigen->simbolo ?? '$';
        return $simbolo . ' ' . number_format($this->monto, 2);
    }
    
    public function getMontoDestinoFormateadoAttribute()
    {
        $simbolo = $this->monedaDestino->simbolo ?? '$';
        return $simbolo . ' ' . number_format($this->monto_destino, 2);
    }
    
    // Método para aplicar el traspaso (actualizar saldos)
    public function aplicar()
    {
        if ($this->estatus !== 'pendiente') {
            return false;
        }
        
        DB::beginTransaction();
        
        try {
            // 1. Restar saldo de la cuenta origen
            $cuentaOrigen = CuentaBancaria::find($this->cuenta_origen_id);
            if ($cuentaOrigen) {
                $cuentaOrigen->saldo_actual = $cuentaOrigen->saldo_actual - $this->monto;
                $cuentaOrigen->save();
            }
            
            // 2. Sumar saldo a la cuenta destino
            $cuentaDestino = CuentaBancaria::find($this->cuenta_destino_id);
            if ($cuentaDestino) {
                $cuentaDestino->saldo_actual = $cuentaDestino->saldo_actual + $this->monto_destino;
                $cuentaDestino->save();
            }
            
            // 3. Crear movimiento de egreso en cuenta origen
            $movimientoOrigen = MovimientoBancario::create([
                'cuenta_bancaria_id' => $this->cuenta_origen_id,
                'proyecto_id' => $this->proyecto_id,
                'tipo' => 'egreso',
                'tipo_egreso_id' => null,
                'categoria_gasto_id' => null,
                'metodo_pago_id' => 1,
                'monto' => $this->monto,
                'fecha' => $this->fecha,
                'concepto' => 'Traspaso a cuenta: ' . ($cuentaDestino->numero_cuenta ?? '') . ' - ' . ($this->concepto ?? ''),
                'referencia' => $this->referencia,
                'comprobante' => $this->comprobante,
                'status' => 'aplicado',
                'observaciones' => 'Traspaso: ' . ($this->observaciones ?? ''),
                'created_by' => $this->created_by
            ]);
            
            // 4. Crear movimiento de ingreso en cuenta destino
            $movimientoDestino = MovimientoBancario::create([
                'cuenta_bancaria_id' => $this->cuenta_destino_id,
                'proyecto_id' => $this->proyecto_id,
                'tipo' => 'ingreso',
                'tipo_ingreso_id' => null,
                'categoria_gasto_id' => null,
                'metodo_pago_id' => 1,
                'monto' => $this->monto_destino,
                'fecha' => $this->fecha,
                'concepto' => 'Traspaso desde cuenta: ' . ($cuentaOrigen->numero_cuenta ?? '') . ' - ' . ($this->concepto ?? ''),
                'referencia' => $this->referencia,
                'comprobante' => $this->comprobante,
                'status' => 'aplicado',
                'observaciones' => 'Traspaso: ' . ($this->observaciones ?? ''),
                'created_by' => $this->created_by
            ]);
            
            $this->estatus = 'completado';
            $this->save();
            
            DB::commit();
            
            return [
                'movimiento_origen' => $movimientoOrigen,
                'movimiento_destino' => $movimientoDestino
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    // Método para cancelar traspaso y revertir saldos
    public function cancelar()
    {
        if ($this->estatus !== 'pendiente') {
            return false;
        }
        
        DB::beginTransaction();
        
        try {
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