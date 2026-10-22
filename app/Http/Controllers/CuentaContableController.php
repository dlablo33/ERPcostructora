<?php
// app/Http/Controllers/CuentaContableController.php
namespace App\Http\Controllers;

use App\Models\CuentaContable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CuentaContableController extends Controller
{
    public function __construct()
    {
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
            Log::error('Error getData cuentas: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Normalizar booleanos ANTES de validar (por si llegan como "true"/"false" string)
            $request->merge([
                'auxiliar' => filter_var($request->input('auxiliar', false), FILTER_VALIDATE_BOOLEAN),
                'activa'   => filter_var($request->input('activa', true), FILTER_VALIDATE_BOOLEAN),
                'nivel'    => (int) $request->input('nivel', 1),
                'codigo_padre' => $request->input('codigo_padre') ?: null,
            ]);

            $validator = Validator::make($request->all(), [
                'codigo'       => 'required|string|max:20|unique:cuentas_contables,codigo',
                'nombre'       => 'required|string|max:200',
                'tipo'         => 'required|in:activo,pasivo,capital,ingreso,gasto,costo',
                'naturaleza'   => 'required|in:deudora,acreedora',
                'codigo_padre' => 'nullable|string|exists:cuentas_contables,codigo',
                'nivel'        => 'required|integer|min:1|max:5',
                'auxiliar'     => 'boolean',
                'activa'       => 'boolean',
                'descripcion'  => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Errores de validación: ' . implode(', ', $validator->errors()->all()),
                    'errors'  => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();

            DB::beginTransaction();
            $cuenta = CuentaContable::create($validated);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cuenta contable creada exitosamente',
                'data'    => $cuenta
            ], 201);

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Log::error('QueryException al crear cuenta contable: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error de base de datos: ' . $e->getMessage()
            ], 500);
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

            // Adjuntar info del padre (nombre) si existe, para que la vista "Ver"
            // muestre "código - nombre" igual que el resto del sistema.
            $cuenta->padre_nombre = null;
            if ($cuenta->codigo_padre) {
                $padre = CuentaContable::where('codigo', $cuenta->codigo_padre)
                    ->first(['codigo', 'nombre']);
                if ($padre) {
                    $cuenta->padre_nombre = $padre->nombre;
                }
            }

            return response()->json($cuenta);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Cuenta no encontrada'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->merge([
                'auxiliar' => filter_var($request->input('auxiliar', false), FILTER_VALIDATE_BOOLEAN),
                'activa'   => filter_var($request->input('activa', true), FILTER_VALIDATE_BOOLEAN),
                'nivel'    => (int) $request->input('nivel', 1),
                'codigo_padre' => $request->input('codigo_padre') ?: null,
            ]);

            $validator = Validator::make($request->all(), [
                'codigo'       => 'required|string|max:20|unique:cuentas_contables,codigo,' . $id,
                'nombre'       => 'required|string|max:200',
                'tipo'         => 'required|in:activo,pasivo,capital,ingreso,gasto,costo',
                'naturaleza'   => 'required|in:deudora,acreedora',
                'codigo_padre' => 'nullable|string|exists:cuentas_contables,codigo',
                'nivel'        => 'required|integer|min:1|max:5',
                'auxiliar'     => 'boolean',
                'activa'       => 'boolean',
                'descripcion'  => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Errores de validación: ' . implode(', ', $validator->errors()->all()),
                    'errors'  => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();

            DB::beginTransaction();
            $cuenta = CuentaContable::findOrFail($id);
            $cuenta->update($validated);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cuenta contable actualizada exitosamente',
                'data'    => $cuenta->fresh()
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar cuenta contable: ' . $e->getMessage());
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

            if (CuentaContable::where('codigo_padre', $cuenta->codigo)->count() > 0) {
                DB::rollBack();
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
            Log::error('Error al eliminar cuenta contable: ' . $e->getMessage());
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
            Log::error('Error getCuentasPadre: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}