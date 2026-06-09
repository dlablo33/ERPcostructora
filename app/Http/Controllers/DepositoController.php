<?php
// app/Http/Controllers/DepositoController.php
namespace App\Http\Controllers;

use App\Models\Deposito;
use App\Models\CuentaBancaria;
use App\Models\Proyecto;
use App\Models\TipoIngreso;
use App\Models\MovimientoBancario;
use App\Models\CodigoSat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepositoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getData']);
    }

    public function index()
    {
        // Obtener datos para los selects
        $cuentasBancarias = CuentaBancaria::with(['banco', 'moneda'])->where('activa', true)->get();
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        $tiposIngreso = TipoIngreso::where('activo', true)->get();
        
        // Códigos SAT para ingresos (tipo I = Ingreso)
        $codigosSatIngresos = CodigoSat::whereIn('tipo', ['I'])
            ->orderBy('codigo_agrupador')
            ->get();
        
        return view('administracion.tesoreria.depositos', compact(
            'cuentasBancarias', 'proyectos', 'tiposIngreso', 'codigosSatIngresos'
        ));
    }

    public function getData(Request $request)
    {
        try {
            $query = Deposito::with([
                'cuentaBancaria.banco', 
                'cuentaBancaria.moneda', 
                'proyecto', 
                'tipoIngreso',
                'codigoSat'
            ]);
            
            if ($request->has('fecha_inicio') && $request->fecha_inicio) {
                $query->whereDate('fecha', '>=', $request->fecha_inicio);
            }
            
            if ($request->has('fecha_fin') && $request->fecha_fin) {
                $query->whereDate('fecha', '<=', $request->fecha_fin);
            }
            
            if ($request->has('estatus') && $request->estatus) {
                $query->where('estatus', $request->estatus);
            }
            
            $depositos = $query->orderBy('fecha', 'desc')->get();
            return response()->json($depositos);
        } catch (\Exception $e) {
            Log::error('Error en getData depositos: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Datos recibidos en store deposito:', $request->all());
            
            $validated = $request->validate([
                'fecha' => 'required|date',
                'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'tipo_ingreso_id' => 'required|exists:tipos_ingreso,id',
                'monto' => 'required|numeric|min:0.01',
                'referencia' => 'nullable|string|max:100',
                'concepto' => 'required|string|max:500',
                'observaciones' => 'nullable|string',
                'aplicar_ahora' => 'boolean',
                'codigo_sat_id' => 'required|exists:codigos_sat,id'
            ]);
            
            DB::beginTransaction();
            
            $validated['folio'] = Deposito::generarFolio();
            $validated['estatus'] = ($validated['aplicar_ahora'] ?? false) ? 'aplicado' : 'pendiente';
            $validated['created_by'] = auth()->id();
            
            $deposito = Deposito::create($validated);
            
            if ($validated['aplicar_ahora'] ?? false) {
                $this->aplicarDeposito($deposito);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Depósito creado exitosamente',
                'data' => $deposito->load(['cuentaBancaria.banco', 'proyecto', 'tipoIngreso', 'codigoSat'])
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
            Log::error('Error al crear depósito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $deposito = Deposito::with([
                'cuentaBancaria.banco', 
                'cuentaBancaria.moneda', 
                'proyecto', 
                'tipoIngreso', 
                'creador',
                'codigoSat'
            ])->findOrFail($id);
            return response()->json($deposito);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Depósito no encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $deposito = Deposito::findOrFail($id);
            
            if ($deposito->estatus !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden editar depósitos pendientes'
                ], 422);
            }
            
            $validated = $request->validate([
                'fecha' => 'required|date',
                'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'tipo_ingreso_id' => 'required|exists:tipos_ingreso,id',
                'monto' => 'required|numeric|min:0.01',
                'referencia' => 'nullable|string|max:100',
                'concepto' => 'required|string|max:500',
                'observaciones' => 'nullable|string',
                'codigo_sat_id' => 'required|exists:codigos_sat,id'
            ]);
            
            DB::beginTransaction();
            $deposito->update($validated);
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Depósito actualizado exitosamente',
                'data' => $deposito->load(['cuentaBancaria.banco', 'proyecto', 'tipoIngreso', 'codigoSat'])
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
            $deposito = Deposito::findOrFail($id);
            
            if ($deposito->estatus !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden eliminar depósitos pendientes'
                ], 422);
            }
            
            DB::beginTransaction();
            $deposito->delete();
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Depósito eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
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
            $deposito = Deposito::findOrFail($id);
            
            if ($deposito->estatus !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'El depósito ya fue ' . $deposito->estatus
                ], 422);
            }
            
            // Validar que tenga código SAT
            if (!$deposito->codigo_sat_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'El depósito no tiene un código SAT asignado. Por favor edite el depósito y asigne uno.'
                ], 422);
            }
            
            $this->aplicarDeposito($deposito);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Depósito aplicado exitosamente. Saldo actualizado.',
                'data' => $deposito->load(['cuentaBancaria.banco', 'proyecto', 'tipoIngreso', 'codigoSat'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al aplicar depósito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Aplica el depósito: actualiza saldo de cuenta y crea movimiento bancario
     */
    private function aplicarDeposito($deposito)
    {
        // Validar que tenga código SAT
        if (!$deposito->codigo_sat_id) {
            throw new \Exception('El depósito no tiene un código SAT asignado.');
        }
        
        // Actualizar saldo de la cuenta bancaria (INGRESO - se suma)
        $cuenta = CuentaBancaria::find($deposito->cuenta_bancaria_id);
        if ($cuenta) {
            $cuenta->saldo_actual = $cuenta->saldo_actual + $deposito->monto;
            $cuenta->save();
            
            Log::info('Saldo actualizado. Nuevo saldo cuenta ' . $cuenta->id . ': ' . $cuenta->saldo_actual);
        }
        
        // Crear movimiento bancario con código SAT
        $movimiento = MovimientoBancario::create([
            'cuenta_bancaria_id' => $deposito->cuenta_bancaria_id,
            'proyecto_id' => $deposito->proyecto_id,
            'tipo' => 'ingreso',
            'tipo_ingreso_id' => $deposito->tipo_ingreso_id,
            'metodo_pago_id' => 1, // Default o podrías agregar campo
            'monto' => $deposito->monto,
            'fecha' => $deposito->fecha,
            'concepto' => $deposito->concepto,
            'referencia' => $deposito->referencia,
            'comprobante' => null,
            'status' => 'aplicado',
            'observaciones' => 'Depósito: ' . ($deposito->observaciones ?? ''),
            'created_by' => $deposito->created_by,
            'codigo_sat_id' => $deposito->codigo_sat_id
        ]);
        
        $deposito->estatus = 'aplicado';
        $deposito->save();
        
        Log::info('Movimiento creado ID: ' . $movimiento->id . ' con código SAT: ' . $deposito->codigo_sat_id);
        
        return $movimiento;
    }
    
    public function getEstadisticas()
    {
        try {
            $total = Deposito::count();
            $aplicados = Deposito::where('estatus', 'aplicado')->count();
            $pendientes = Deposito::where('estatus', 'pendiente')->count();
            $proceso = Deposito::where('estatus', 'proceso')->count();
            $totalMonto = Deposito::sum('monto');
            
            return response()->json([
                'total' => $total,
                'aplicados' => $aplicados,
                'pendientes' => $pendientes,
                'proceso' => $proceso,
                'total_monto' => $totalMonto
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}