<?php
namespace App\Http\Controllers;

use App\Models\TipoIngreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TipoIngresoController extends Controller
{
    public function index()
    {
        try {
            $tipos = TipoIngreso::orderBy('nombre')->get();
            return response()->json($tipos);
        } catch (\Exception $e) {
            Log::error('Error en tipos ingreso: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $tipo = TipoIngreso::create($request->all());
            return response()->json(['success' => true, 'message' => 'Tipo de ingreso creado', 'data' => $tipo]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            return response()->json(TipoIngreso::findOrFail($id));
        } catch (\Exception $e) {
            return response()->json(['error' => 'No encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $tipo = TipoIngreso::findOrFail($id);
            $tipo->update($request->all());
            return response()->json(['success' => true, 'message' => 'Tipo de ingreso actualizado']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            TipoIngreso::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Tipo de ingreso eliminado']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}