<?php
// app/Http/Controllers/ProveedorController.php
namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        return view('administracion.tesoreria.proveedores', compact('proveedores'));
    }

    public function getData()
    {
        try {
            $proveedores = Proveedor::where('activo', true)->orderBy('nombre')->get();
            return response()->json($proveedores);
        } catch (\Exception $e) {
            Log::error('Error en getData proveedores: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:200',
                'rfc' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'telefono' => 'nullable|string|max:50',
                'contacto' => 'nullable|string|max:200',
                'direccion' => 'nullable|string|max:500',
                'activo' => 'boolean'
            ]);
            
            DB::beginTransaction();
            $proveedor = Proveedor::create($validated);
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Proveedor creado exitosamente',
                'data' => $proveedor
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear proveedor: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            return response()->json($proveedor);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Proveedor no encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            
            $validated = $request->validate([
                'nombre' => 'required|string|max:200',
                'rfc' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'telefono' => 'nullable|string|max:50',
                'contacto' => 'nullable|string|max:200',
                'direccion' => 'nullable|string|max:500',
                'activo' => 'boolean'
            ]);
            
            DB::beginTransaction();
            $proveedor->update($validated);
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Proveedor actualizado exitosamente',
                'data' => $proveedor
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
            $proveedor = Proveedor::findOrFail($id);
            $proveedor->delete();
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Proveedor eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}