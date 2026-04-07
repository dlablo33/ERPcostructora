<?php
namespace App\Http\Controllers;

use App\Models\MetodoPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MetodoPagoController extends Controller
{
    public function index()
    {
        try {
            $metodos = MetodoPago::orderBy('nombre')->get();
            return response()->json($metodos);
        } catch (\Exception $e) {
            Log::error('Error en metodos pago: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $metodo = MetodoPago::create($request->all());
            return response()->json(['success' => true, 'message' => 'Método de pago creado', 'data' => $metodo]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            return response()->json(MetodoPago::findOrFail($id));
        } catch (\Exception $e) {
            return response()->json(['error' => 'No encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $metodo = MetodoPago::findOrFail($id);
            $metodo->update($request->all());
            return response()->json(['success' => true, 'message' => 'Método de pago actualizado']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            MetodoPago::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Método de pago eliminado']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}