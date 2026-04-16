<?php
// app/Http/Controllers/ChequeTransferenciaController.php
namespace App\Http\Controllers;

use App\Models\ChequeTransferencia;
use App\Models\CuentaBancaria;
use App\Models\Moneda;
use App\Models\Proyecto;
use App\Models\Banco;
use App\Models\MovimientoBancario;
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
        
        return view('administracion.tesoreria.trasferencias', compact('cuentasBancarias', 'monedas', 'proyectos'));
    }

    public function getData(Request $request)
    {
        try {
            $query = ChequeTransferencia::with(['cuentaBancaria.banco', 'moneda', 'proyecto']);
            
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
            Log::error('Error en getData: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
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
                'aplicar_ahora' => 'boolean'
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
                'data' => $registro->load(['cuentaBancaria.banco', 'moneda', 'proyecto'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear registro: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $registro = ChequeTransferencia::with(['cuentaBancaria.banco', 'moneda', 'proyecto'])
                ->findOrFail($id);
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
                'observaciones' => 'nullable|string'
            ]);
            
            DB::beginTransaction();
            $registro->update($validated);
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Registro actualizado exitosamente',
                'data' => $registro->load(['cuentaBancaria.banco', 'moneda', 'proyecto'])
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
            
            $this->aplicarMovimiento($registro);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Registro aplicado exitosamente. Saldo actualizado.',
                'data' => $registro->load(['cuentaBancaria.banco', 'moneda', 'proyecto'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al aplicar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function aplicarMovimiento($registro)
    {
        // Actualizar saldo de la cuenta bancaria (EGRESO - se resta)
        $cuenta = CuentaBancaria::find($registro->cuenta_bancaria_id);
        if ($cuenta) {
            $cuenta->saldo_actual = $cuenta->saldo_actual - $registro->monto;
            $cuenta->save();
            
            Log::info('Saldo actualizado. Nuevo saldo: ' . $cuenta->saldo_actual);
        }
        
        // Crear movimiento bancario (EGRESO)
        $movimiento = MovimientoBancario::create([
            'cuenta_bancaria_id' => $registro->cuenta_bancaria_id,
            'proyecto_id' => $registro->proyecto_id,
            'tipo' => 'egreso',
            'tipo_egreso_id' => null,
            'categoria_gasto_id' => null,
            'metodo_pago_id' => $registro->forma_pago === 'cheque' ? 2 : 1,
            'monto' => $registro->monto,
            'fecha' => $registro->fecha,
            'concepto' => $registro->descripcion ?? 'Cheque/Transferencia: ' . $registro->proveedor,
            'referencia' => $registro->referencia,
            'comprobante' => null,
            'status' => 'aplicado',
            'observaciones' => 'Cheque/Transferencia: ' . ($registro->observaciones ?? ''),
            'created_by' => $registro->created_by
        ]);
        
        // Actualizar el registro a COMPLETADO (no 'aplicado')
        $registro->estatus = 'completado';
        $registro->save();
        
        Log::info('Movimiento creado ID: ' . $movimiento->id);
        
        return $movimiento;
    }
}