<?php
// app/Http/Controllers/CuentaContableController.php
namespace App\Http\Controllers;

use App\Models\CuentaContable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CuentaContableController extends Controller
{
    // Constructor con middleware condicional
    public function __construct()
    {
        // Solo aplicar auth a métodos que no sean de API
        $this->middleware('auth')->except([
            'getData', 'store', 'show', 'update', 'destroy', 'getCuentasPadre'
        ]);
    }

    public function index()
    {
        $cuentas = CuentaContable::orderBy('codigo')->get();
        return view('administracion.cuentasavanzadas.registrocuenta', compact('cuentas'));
    }

    public function getData()
    {
        try {
            $cuentas = CuentaContable::orderBy('codigo')->get();
            return response()->json($cuentas);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'codigo' => 'required|string|max:20|unique:cuentas_contables',
                'nombre' => 'required|string|max:200',
                'tipo' => 'required|in:activo,pasivo,capital,ingreso,gasto,costo',
                'naturaleza' => 'required|in:deudora,acreedora',
                'codigo_padre' => 'nullable|string|exists:cuentas_contables,codigo',
                'nivel' => 'required|integer|min:1|max:5',
                'auxiliar' => 'boolean',
                'activa' => 'boolean',
                'descripcion' => 'nullable|string'
            ]);
            
            DB::beginTransaction();
            $cuenta = CuentaContable::create($validated);
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Cuenta contable creada exitosamente',
                'data' => $cuenta
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear cuenta contable: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $cuenta = CuentaContable::findOrFail($id);
            return response()->json($cuenta);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Cuenta no encontrada'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'codigo' => 'required|string|max:20|unique:cuentas_contables,codigo,' . $id,
                'nombre' => 'required|string|max:200',
                'tipo' => 'required|in:activo,pasivo,capital,ingreso,gasto,costo',
                'naturaleza' => 'required|in:deudora,acreedora',
                'codigo_padre' => 'nullable|string|exists:cuentas_contables,codigo',
                'nivel' => 'required|integer|min:1|max:5',
                'auxiliar' => 'boolean',
                'activa' => 'boolean',
                'descripcion' => 'nullable|string'
            ]);
            
            DB::beginTransaction();
            $cuenta = CuentaContable::findOrFail($id);
            $cuenta->update($validated);
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Cuenta contable actualizada exitosamente',
                'data' => $cuenta
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
            $cuenta = CuentaContable::findOrFail($id);
            
            // Verificar si tiene subcuentas
            if (CuentaContable::where('codigo_padre', $cuenta->codigo)->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar porque tiene subcuentas asociadas'
                ], 422);
            }
            
            $cuenta->delete();
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Cuenta contable eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getCuentasPadre()
    {
        try {
            $cuentas = CuentaContable::where('activa', true)
                ->orderBy('codigo')
                ->get(['codigo', 'nombre', 'nivel']);
            return response()->json($cuentas);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}