<?php
namespace App\Http\Controllers;

use App\Models\TipoEgreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TipoEgresoController extends Controller
{
    public function index()
    {
        try {
            $tipos = TipoEgreso::orderBy('nombre')->get();
            return response()->json($tipos);
        } catch (\Exception $e) {
            Log::error('Error en tipos egreso: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $tipo = TipoEgreso::create($request->all());
            return response()->json(['success' => true, 'message' => 'Tipo de egreso creado', 'data' => $tipo]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            return response()->json(TipoEgreso::findOrFail($id));
        } catch (\Exception $e) {
            return response()->json(['error' => 'No encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $tipo = TipoEgreso::findOrFail($id);
            $tipo->update($request->all());
            return response()->json(['success' => true, 'message' => 'Tipo de egreso actualizado']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            TipoEgreso::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Tipo de egreso eliminado']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}