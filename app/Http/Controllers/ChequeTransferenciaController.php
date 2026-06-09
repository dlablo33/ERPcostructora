<?php
// app/Http/Controllers/ChequeTransferenciaController.php
namespace App\Http\Controllers;

use App\Models\ChequeTransferencia;
use App\Models\CuentaBancaria;
use App\Models\Moneda;
use App\Models\Proyecto;
use App\Models\Proveedor;
use App\Models\Facturacion\Contacto;
use App\Models\MovimientoBancario;
use App\Models\CodigoSat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChequeTransferenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getData']);
    }

    public function index()
    {
        $cuentasBancarias = CuentaBancaria::with(['banco', 'moneda'])->where('activa', true)->get();
        $monedas = Moneda::where('activa', true)->get();
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        
        // Proveedores y contactos para seleccionar
        $proveedores = Proveedor::where('activo', true)->orderBy('nombre')->get(['id', 'nombre', 'rfc']);
        $contactos = Contacto::where('tipo', 'cliente')->where('estatus', true)->orderBy('razon_social')->get(['contacto_id as id', 'razon_social as nombre', 'rfc']);
        
        // Códigos SAT para gastos (cheques y transferencias son egresos)
        $codigosSatGastos = CodigoSat::whereIn('tipo', ['G', 'A'])
            ->orderBy('codigo_agrupador')
            ->get();
        
        return view('administracion.tesoreria.trasferencias', compact(
            'cuentasBancarias', 'monedas', 'proyectos', 'codigosSatGastos', 
            'proveedores', 'contactos'
        ));
    }

    public function getData(Request $request)
    {
        try {
            // Verificar si la relación 'codigoSat' existe, si no, usar without
            $query = ChequeTransferencia::with(['cuentaBancaria.banco', 'moneda', 'proyecto']);
            
            // Agregar codigoSat solo si la relación existe en el modelo
            if (method_exists(ChequeTransferencia::class, 'codigoSat')) {
                $query = $query->with('codigoSat');
            }
            
            if ($request->has('fecha_inicio') && $request->fecha_inicio) {
                $query->whereDate('fecha', '>=', $request->fecha_inicio);
            }
            
            if ($request->has('fecha_fin') && $request->fecha_fin) {
                $query->whereDate('fecha', '<=', $request->fecha_fin);
            }
            
            if ($request->has('forma_pago') && $request->forma_pago) {
                $query->where('forma_pago', $request->forma_pago);
            }
            
            $registros = $query->orderBy('fecha', 'desc')->get();
            return response()->json($registros);
        } catch (\Exception $e) {
            Log::error('Error en getData cheques-transferencias: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Datos recibidos en store cheques-transferencias:', $request->all());
            
            $validated = $request->validate([
                'fecha' => 'required|date',
                'forma_pago' => 'required|in:cheque,transferencia',
                'proveedor' => 'required|string|max:200',
                'rfc' => 'nullable|string|max:20',
                'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
                'moneda_id' => 'required|exists:monedas,id',
                'monto' => 'required|numeric|min:0.01',
                'referencia' => 'nullable|string|max:100',
                'referencia_bancaria' => 'nullable|string|max:100',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'descripcion' => 'nullable|string',
                'observaciones' => 'nullable|string',
                'aplicar_ahora' => 'boolean',
                'codigo_sat_id' => 'required|exists:codigos_sat,id',
                'proveedor_id' => 'nullable|exists:proveedores,id',
                'contacto_id' => 'nullable|exists:contactos,contacto_id'
            ]);
            
            DB::beginTransaction();
            
            $validated['folio'] = ChequeTransferencia::generarFolio();
            $validated['estatus'] = 'activo';
            $validated['monto_restante'] = $validated['monto'];
            $validated['tipo_cambio'] = 1;
            $validated['monto_original'] = $validated['monto'];
            $validated['created_by'] = auth()->id();
            
            $registro = ChequeTransferencia::create($validated);
            
            if ($validated['aplicar_ahora'] ?? true) {
                $this->aplicarMovimiento($registro);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Registro creado exitosamente',
                'data' => $registro->load(['cuentaBancaria.banco', 'moneda', 'proyecto', 'codigoSat'])
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear registro cheques-transferencias: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $registro = ChequeTransferencia::with([
                'cuentaBancaria.banco', 
                'moneda', 
                'proyecto',
                'codigoSat',
                'proveedorRel',
                'contactoRel'
            ])->findOrFail($id);
            return response()->json($registro);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $registro = ChequeTransferencia::findOrFail($id);
            
            $validated = $request->validate([
                'fecha' => 'required|date',
                'forma_pago' => 'required|in:cheque,transferencia',
                'proveedor' => 'required|string|max:200',
                'rfc' => 'nullable|string|max:20',
                'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
                'moneda_id' => 'required|exists:monedas,id',
                'monto' => 'required|numeric|min:0.01',
                'referencia' => 'nullable|string|max:100',
                'referencia_bancaria' => 'nullable|string|max:100',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'descripcion' => 'nullable|string',
                'observaciones' => 'nullable|string',
                'codigo_sat_id' => 'required|exists:codigos_sat,id',
                'proveedor_id' => 'nullable|exists:proveedores,id',
                'contacto_id' => 'nullable|exists:contactos,contacto_id'
            ]);
            
            DB::beginTransaction();
            $registro->update($validated);
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Registro actualizado exitosamente',
                'data' => $registro->load(['cuentaBancaria.banco', 'moneda', 'proyecto', 'codigoSat'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $registro = ChequeTransferencia::findOrFail($id);
            
            if ($registro->estatus === 'completado') {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar un registro ya aplicado'
                ], 422);
            }
            
            $registro->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Registro eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function aplicar($id)
    {
        try {
            DB::beginTransaction();
            $registro = ChequeTransferencia::findOrFail($id);
            
            if ($registro->estatus !== 'activo') {
                return response()->json([
                    'success' => false,
                    'message' => 'El registro ya fue procesado'
                ], 422);
            }
            
            // Validar que tenga código SAT
            if (!$registro->codigo_sat_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'El registro no tiene un código SAT asignado. Por favor edite y asigne uno.'
                ], 422);
            }
            
            $this->aplicarMovimiento($registro);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Registro aplicado exitosamente. Saldo actualizado.',
                'data' => $registro->load(['cuentaBancaria.banco', 'moneda', 'proyecto', 'codigoSat'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al aplicar cheques-transferencias: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function aplicarMovimiento($registro)
    {
        // Validar que tenga código SAT
        if (!$registro->codigo_sat_id) {
            throw new \Exception('El registro no tiene un código SAT asignado.');
        }
        
        // Actualizar saldo de la cuenta bancaria (EGRESO - se resta)
        $cuenta = CuentaBancaria::find($registro->cuenta_bancaria_id);
        if ($cuenta) {
            $nuevoSaldo = $cuenta->saldo_actual - $registro->monto;
            $cuenta->saldo_actual = $nuevoSaldo;
            $cuenta->save();
            
            Log::info('Saldo actualizado. Cuenta: ' . $cuenta->id . ', Nuevo saldo: ' . $nuevoSaldo);
        }
        
        // Obtener el método de pago ID según la forma de pago
        $metodoPagoId = $registro->forma_pago === 'cheque' ? 2 : 1;
        
        // Crear movimiento bancario (EGRESO) con código SAT
        $movimiento = MovimientoBancario::create([
            'cuenta_bancaria_id' => $registro->cuenta_bancaria_id,
            'proyecto_id' => $registro->proyecto_id,
            'tipo' => 'egreso',
            'tipo_egreso_id' => null,
            'categoria_gasto_id' => null,
            'metodo_pago_id' => $metodoPagoId,
            'monto' => $registro->monto,
            'fecha' => $registro->fecha,
            'concepto' => $registro->descripcion ?? 'Cheque/Transferencia: ' . $registro->proveedor,
            'referencia' => $registro->referencia,
            'comprobante' => null,
            'status' => 'aplicado',
            'observaciones' => 'Cheque/Transferencia: ' . ($registro->observaciones ?? ''),
            'created_by' => $registro->created_by,
            'codigo_sat_id' => $registro->codigo_sat_id
        ]);
        
        // Actualizar el registro a COMPLETADO
        $registro->estatus = 'completado';
        $registro->save();
        
        Log::info('Movimiento creado ID: ' . $movimiento->id . ' con código SAT: ' . $registro->codigo_sat_id);
        
        return $movimiento;
    }
    
    public function getEstadisticas()
    {
        try {
            $total = ChequeTransferencia::count();
            $activos = ChequeTransferencia::where('estatus', 'activo')->count();
            $completados = ChequeTransferencia::where('estatus', 'completado')->count();
            $cancelados = ChequeTransferencia::where('estatus', 'cancelado')->count();
            $totalMonto = ChequeTransferencia::sum('monto');
            
            return response()->json([
                'total' => $total,
                'activos' => $activos,
                'completados' => $completados,
                'cancelados' => $cancelados,
                'total_monto' => $totalMonto
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}