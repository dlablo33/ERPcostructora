<?php
namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BancoController extends Controller
{
    public function index()
    {
        try {
            $bancos = Banco::orderBy('nombre')->get();
            return response()->json($bancos);
        } catch (\Exception $e) {
            Log::error('Error en bancos index: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:150',
                'codigo' => 'nullable|string|max:20',
                'activo' => 'boolean'
            ]);

            $banco = Banco::create($validated);
            return response()->json(['success' => true, 'message' => 'Banco creado', 'data' => $banco]);
        } catch (\Exception $e) {
            Log::error('Error al crear banco: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $banco = Banco::findOrFail($id);
            return response()->json($banco);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Banco no encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $banco = Banco::findOrFail($id);
            $validated = $request->validate([
                'nombre' => 'required|string|max:150',
                'codigo' => 'nullable|string|max:20',
                'activo' => 'boolean'
            ]);
            $banco->update($validated);
            return response()->json(['success' => true, 'message' => 'Banco actualizado']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $banco = Banco::findOrFail($id);
            $banco->delete();
            return response()->json(['success' => true, 'message' => 'Banco eliminado']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}