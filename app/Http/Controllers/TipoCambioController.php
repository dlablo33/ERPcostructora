<?php
namespace App\Http\Controllers;

use App\Models\TipoCambio;
use App\Models\Moneda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TipoCambioController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = TipoCambio::with(['monedaOrigen', 'monedaDestino']);
            if ($request->has('fecha') && $request->fecha) {
                $query->whereDate('fecha', $request->fecha);
            }
            $tipos = $query->orderBy('fecha', 'desc')->get();
            return response()->json($tipos);
        } catch (\Exception $e) {
            Log::error('Error en tipos cambio: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'moneda_origen_id' => 'required|exists:monedas,id',
                'moneda_destino_id' => 'required|exists:monedas,id|different:moneda_origen_id',
                'tasa' => 'required|numeric|min:0',
                'fecha' => 'required|date'
            ]);
            $tipo = TipoCambio::create($validated);
            return response()->json(['success' => true, 'message' => 'Tipo de cambio creado', 'data' => $tipo]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            return response()->json(TipoCambio::with(['monedaOrigen', 'monedaDestino'])->findOrFail($id));
        } catch (\Exception $e) {
            return response()->json(['error' => 'No encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $tipo = TipoCambio::findOrFail($id);
            $tipo->update($request->all());
            return response()->json(['success' => true, 'message' => 'Tipo de cambio actualizado']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            TipoCambio::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Tipo de cambio eliminado']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}