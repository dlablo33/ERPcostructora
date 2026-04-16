<?php
// app/Http/Controllers/CuentaBancariaController.php
namespace App\Http\Controllers;

use App\Models\CuentaBancaria;
use App\Models\Banco;
use App\Models\Moneda;
use App\Models\Proyecto;
use App\Models\CuentaContable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CuentaBancariaController extends Controller
{
    public function __construct()
    {
        // Excluir métodos que no requieren autenticación (para API)
        $this->middleware('auth')->except(['getData', 'store', 'show', 'update', 'destroy']);
    }

    public function index()
    {
        $cuentas = CuentaBancaria::with(['banco', 'moneda', 'proyecto', 'cuentaContable'])
            ->orderBy('id', 'desc')
            ->get();
        $bancos = Banco::where('activo', true)->get();
        $monedas = Moneda::where('activa', true)->get();
        $proyectos = Proyecto::where('status', 'activo')->get();
        $cuentasContables = CuentaContable::where('activa', true)->orderBy('codigo')->get();
        
        return view('administracion.cuentasavanzadas.cuentasbancarias', compact('cuentas', 'bancos', 'monedas', 'proyectos', 'cuentasContables'));
    }

    public function getData()
    {
        try {
            $cuentas = CuentaBancaria::with(['banco', 'moneda', 'proyecto', 'cuentaContable'])
                ->orderBy('id', 'desc')
                ->get();
            return response()->json($cuentas);
        } catch (\Exception $e) {
            Log::error('Error en getData cuentas bancarias: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'banco_id' => 'required|exists:bancos,id',
                'moneda_id' => 'required|exists:monedas,id',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'cuenta_contable_id' => 'nullable|exists:cuentas_contables,id',
                'numero_cuenta' => 'required|string|max:50',
                'clabe' => 'nullable|string|max:30',
                'titular' => 'required|string|max:200',
                'tipo_cuenta' => 'required|in:cheques,ahorros,inversion,credito',
                'saldo_inicial' => 'nullable|numeric|min:0',
                'activa' => 'boolean'
            ]);
            
            DB::beginTransaction();
            
            $validated['saldo_actual'] = $validated['saldo_inicial'] ?? 0;
            $validated['activa'] = $validated['activa'] ?? true;
            $validated['created_by'] = auth()->id();
            
            $cuenta = CuentaBancaria::create($validated);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Cuenta bancaria creada exitosamente',
                'data' => $cuenta->load(['banco', 'moneda', 'proyecto', 'cuentaContable'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear cuenta bancaria: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $cuenta = CuentaBancaria::with([
                'banco', 
                'moneda', 
                'proyecto', 
                'cuentaContable',
                'movimientos' => function($q) {
                    $q->orderBy('fecha', 'desc')->limit(50);
                }
            ])->findOrFail($id);
            return response()->json($cuenta);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Cuenta no encontrada'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'banco_id' => 'required|exists:bancos,id',
                'moneda_id' => 'required|exists:monedas,id',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'cuenta_contable_id' => 'nullable|exists:cuentas_contables,id',
                'numero_cuenta' => 'required|string|max:50',
                'clabe' => 'nullable|string|max:30',
                'titular' => 'required|string|max:200',
                'tipo_cuenta' => 'required|in:cheques,ahorros,inversion,credito',
                'activa' => 'boolean'
            ]);
            
            DB::beginTransaction();
            $cuenta = CuentaBancaria::findOrFail($id);
            $cuenta->update($validated);
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Cuenta bancaria actualizada exitosamente',
                'data' => $cuenta->load(['banco', 'moneda', 'proyecto', 'cuentaContable'])
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
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // Obtener cuentas bancarias por proyecto
    public function getPorProyecto($proyectoId)
    {
        try {
            $cuentas = CuentaBancaria::with(['banco', 'moneda', 'cuentaContable'])
                ->where('proyecto_id', $proyectoId)
                ->where('activa', true)
                ->get();
            return response()->json($cuentas);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Obtener saldo de una cuenta
    public function getSaldo($id)
    {
        try {
            $cuenta = CuentaBancaria::findOrFail($id);
            return response()->json([
                'saldo_actual' => $cuenta->saldo_actual,
                'saldo_inicial' => $cuenta->saldo_inicial,
                'moneda' => $cuenta->moneda->simbolo,
                'moneda_codigo' => $cuenta->moneda->codigo
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
 * Actualizar el saldo de una cuenta bancaria específica
 */
public function actualizarSaldo($id)
{
    try {
        $cuenta = CuentaBancaria::findOrFail($id);
        
        // Calcular total de ingresos aplicados
        $totalIngresos = MovimientoBancario::where('cuenta_bancaria_id', $id)
            ->where('tipo', 'ingreso')
            ->where('status', 'aplicado')
            ->sum('monto');
        
        // Calcular total de egresos aplicados
        $totalEgresos = MovimientoBancario::where('cuenta_bancaria_id', $id)
            ->where('tipo', 'egreso')
            ->where('status', 'aplicado')
            ->sum('monto');
        
        // Calcular nuevo saldo
        $nuevoSaldo = $cuenta->saldo_inicial + $totalIngresos - $totalEgresos;
        
        // Actualizar saldo
        $cuenta->saldo_actual = $nuevoSaldo;
        $cuenta->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Saldo actualizado correctamente',
            'saldo_actual' => $nuevoSaldo,
            'saldo_formateado' => '$' . number_format($nuevoSaldo, 2)
        ]);
    } catch (\Exception $e) {
        Log::error('Error al actualizar saldo: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Actualizar todos los saldos de todas las cuentas bancarias
 */
public function actualizarTodosSaldos()
{
    try {
        $cuentas = CuentaBancaria::all();
        $actualizadas = 0;
        
        foreach ($cuentas as $cuenta) {
            $totalIngresos = MovimientoBancario::where('cuenta_bancaria_id', $cuenta->id)
                ->where('tipo', 'ingreso')
                ->where('status', 'aplicado')
                ->sum('monto');
                
            $totalEgresos = MovimientoBancario::where('cuenta_bancaria_id', $cuenta->id)
                ->where('tipo', 'egreso')
                ->where('status', 'aplicado')
                ->sum('monto');
                
            $nuevoSaldo = $cuenta->saldo_inicial + $totalIngresos - $totalEgresos;
            $cuenta->saldo_actual = $nuevoSaldo;
            $cuenta->save();
            $actualizadas++;
        }
        
        return response()->json([
            'success' => true,
            'message' => "Se actualizaron {$actualizadas} cuentas correctamente"
        ]);
    } catch (\Exception $e) {
        Log::error('Error al actualizar todos los saldos: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}
}