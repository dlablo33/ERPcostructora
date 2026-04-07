<?php
namespace App\Http\Controllers;

use App\Models\CategoriaGasto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoriaGastoController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = CategoriaGasto::with('tipoEgreso');
            if ($request->has('tipo_egreso_id') && $request->tipo_egreso_id) {
                $query->where('tipo_egreso_id', $request->tipo_egreso_id);
            }
            $categorias = $query->orderBy('nombre')->get();
            return response()->json($categorias);
        } catch (\Exception $e) {
            Log::error('Error en categorias: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $categoria = CategoriaGasto::create($request->all());
            return response()->json(['success' => true, 'message' => 'Categoría creada', 'data' => $categoria]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            return response()->json(CategoriaGasto::with('tipoEgreso')->findOrFail($id));
        } catch (\Exception $e) {
            return response()->json(['error' => 'No encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $categoria = CategoriaGasto::findOrFail($id);
            $categoria->update($request->all());
            return response()->json(['success' => true, 'message' => 'Categoría actualizada']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            CategoriaGasto::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Categoría eliminada']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}