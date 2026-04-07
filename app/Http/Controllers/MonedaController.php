<?php
// app/Http/Controllers/MonedaController.php
namespace App\Http\Controllers;

use App\Models\Moneda;
use Illuminate\Http\Request;

class MonedaController extends Controller
{
    public function index()
    {
        try {
            $monedas = Moneda::all();
            return response()->json($monedas);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }
    
    public function store(Request $request)
    {
        try {
            $moneda = Moneda::create($request->all());
            return response()->json(['success' => true, 'message' => 'Moneda creada', 'moneda' => $moneda]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    public function show($id)
    {
        try {
            $moneda = Moneda::findOrFail($id);
            return response()->json($moneda);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Moneda no encontrada'], 404);
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $moneda = Moneda::findOrFail($id);
            $moneda->update($request->all());
            return response()->json(['success' => true, 'message' => 'Moneda actualizada']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    public function destroy($id)
    {
        try {
            $moneda = Moneda::findOrFail($id);
            $moneda->delete();
            return response()->json(['success' => true, 'message' => 'Moneda eliminada']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    public function getActivas()
    {
        $monedas = Moneda::where('activa', true)->get();
        return response()->json($monedas);
    }
}