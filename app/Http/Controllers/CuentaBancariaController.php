<?php
// app/Http/Controllers/CuentaBancariaController.php
namespace App\Http\Controllers;

use App\Models\CuentaBancaria;
use App\Models\Banco;
use App\Models\Moneda;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CuentaBancariaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = CuentaBancaria::with(['banco', 'moneda', 'proyecto']);
        
        if ($request->has('proyecto_id') && $request->proyecto_id) {
            $query->where('proyecto_id', $request->proyecto_id);
        }
        
        if ($request->has('activa') && $request->activa !== '') {
            $query->where('activa', $request->activa);
        }
        
        $cuentas = $query->orderBy('banco_id')->get();
        $bancos = Banco::where('activo', true)->get();
        $monedas = Moneda::where('activa', true)->get();
        $proyectos = Proyecto::where('status', 'activo')->get();
        
        return view('administracion.tesoreria.cuentas-bancarias.index', compact('cuentas', 'bancos', 'monedas', 'proyectos'));
    }

    public function create()
    {
        $bancos = Banco::where('activo', true)->get();
        $monedas = Moneda::where('activa', true)->get();
        $proyectos = Proyecto::where('status', 'activo')->get();
        
        return view('administracion.tesoreria.cuentas-bancarias.create', compact('bancos', 'monedas', 'proyectos'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'banco_id' => 'required|exists:bancos,id',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'moneda_id' => 'required|exists:monedas,id',
                'numero_cuenta' => 'required|string|max:50',
                'clabe' => 'nullable|string|max:30',
                'titular' => 'required|string|max:200',
                'saldo_inicial' => 'nullable|numeric|min:0',
                'activa' => 'boolean'
            ]);

            DB::beginTransaction();
            
            $validated['saldo_actual'] = $validated['saldo_inicial'] ?? 0;
            $validated['activa'] = $validated['activa'] ?? true;
            
            $cuenta = CuentaBancaria::create($validated);
            
            // Si tiene proyecto asignado, crear registro de saldo
            if ($cuenta->proyecto_id) {
                \App\Models\ProyectoSaldo::create([
                    'proyecto_id' => $cuenta->proyecto_id,
                    'cuenta_bancaria_id' => $cuenta->id,
                    'saldo_asignado' => $cuenta->saldo_inicial,
                    'saldo_disponible' => $cuenta->saldo_inicial,
                    'total_ingresos' => 0,
                    'total_egresos' => 0
                ]);
            }
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cuenta bancaria creada exitosamente',
                'cuenta' => $cuenta
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear cuenta bancaria: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear cuenta bancaria: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $cuenta = CuentaBancaria::with(['banco', 'moneda', 'proyecto', 'movimientos' => function($q) {
            $q->orderBy('fecha', 'desc')->limit(50);
        }])->findOrFail($id);
        
        return response()->json($cuenta);
    }

    public function edit($id)
    {
        $cuenta = CuentaBancaria::findOrFail($id);
        $bancos = Banco::where('activo', true)->get();
        $monedas = Moneda::where('activa', true)->get();
        $proyectos = Proyecto::where('status', 'activo')->get();
        
        return view('administracion.tesoreria.cuentas-bancarias.edit', compact('cuenta', 'bancos', 'monedas', 'proyectos'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'banco_id' => 'required|exists:bancos,id',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'moneda_id' => 'required|exists:monedas,id',
                'numero_cuenta' => 'required|string|max:50',
                'clabe' => 'nullable|string|max:30',
                'titular' => 'required|string|max:200',
                'activa' => 'boolean'
            ]);

            DB::beginTransaction();
            $cuenta = CuentaBancaria::findOrFail($id);
            $cuenta->update($validated);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cuenta bancaria actualizada exitosamente',
                'cuenta' => $cuenta
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar cuenta bancaria: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar cuenta bancaria: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $cuenta = CuentaBancaria::findOrFail($id);
            
            // Verificar si tiene movimientos
            if ($cuenta->movimientos()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar la cuenta porque tiene movimientos asociados'
                ], 422);
            }
            
            $cuenta->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cuenta bancaria eliminada exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar cuenta bancaria: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar cuenta bancaria: ' . $e->getMessage()
            ], 500);
        }
    }
}