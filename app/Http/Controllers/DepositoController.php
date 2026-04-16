<?php
// app/Http/Controllers/DepositoController.php
namespace App\Http\Controllers;

use App\Models\Deposito;
use App\Models\CuentaBancaria;
use App\Models\Proyecto;
use App\Models\TipoIngreso;
use App\Models\MovimientoBancario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepositoController extends Controller
{
    public function __construct()
    {
        // Excluir TODOS los métodos API del middleware auth
        $this->middleware('auth')->except([
            'getData', 'store', 'show', 'update', 'destroy', 'aplicar', 'getEstadisticas'
        ]);
    }

    public function index()
    {
        $cuentasBancarias = CuentaBancaria::with(['banco', 'moneda'])->where('activa', true)->get();
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        $tiposIngreso = TipoIngreso::where('activo', true)->orderBy('nombre')->get();
        
        return view('administracion.tesoreria.depositos', compact('cuentasBancarias', 'proyectos', 'tiposIngreso'));
    }

    public function getData(Request $request)
    {
        try {
            $query = Deposito::with(['cuentaBancaria.banco', 'cuentaBancaria.moneda', 'proyecto', 'tipoIngreso']);
            
            if ($request->has('fecha_inicio') && $request->fecha_inicio) {
                $query->whereDate('fecha', '>=', $request->fecha_inicio);
            }
            
            if ($request->has('fecha_fin') && $request->fecha_fin) {
                $query->whereDate('fecha', '<=', $request->fecha_fin);
            }
            
            $depositos = $query->orderBy('fecha', 'desc')->get();
            return response()->json($depositos);
        } catch (\Exception $e) {
            Log::error('Error en getData depositos: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
            'proyecto_id' => 'nullable|exists:proyectos,id',
            'tipo_ingreso_id' => 'required|exists:tipos_ingreso,id',
            'monto' => 'required|numeric|min:0.01',
            'concepto' => 'required|string|max:500',
            'referencia' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string',
            'aplicar_ahora' => 'boolean'
        ]);
        
        DB::beginTransaction();
        
        $validated['folio'] = Deposito::generarFolio();
        $validated['estatus'] = 'pendiente'; // Inicialmente pendiente
        $validated['created_by'] = auth()->id();
        
        $deposito = Deposito::create($validated);
        
        // Si debe aplicarse ahora, ejecutar aplicar()
        if ($validated['aplicar_ahora'] ?? false) {
            $deposito->aplicar();
        }
        
        DB::commit();
        
        return response()->json([
            'success' => true,
            'message' => 'Depósito creado exitosamente',
            'data' => $deposito->load(['cuentaBancaria.banco', 'proyecto', 'tipoIngreso'])
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error al crear depósito: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

    public function show($id)
    {
        try {
            $deposito = Deposito::with(['cuentaBancaria.banco', 'cuentaBancaria.moneda', 'proyecto', 'tipoIngreso', 'creador'])
                ->findOrFail($id);
            return response()->json($deposito);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Depósito no encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $deposito = Deposito::findOrFail($id);
            
            if ($deposito->estatus !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden editar depósitos pendientes'
                ], 422);
            }
            
            $validated = $request->validate([
                'fecha' => 'required|date',
                'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'tipo_ingreso_id' => 'required|exists:tipos_ingreso,id',
                'monto' => 'required|numeric|min:0.01',
                'concepto' => 'required|string|max:500',
                'referencia' => 'nullable|string|max:100',
                'observaciones' => 'nullable|string'
            ]);
            
            DB::beginTransaction();
            $deposito->update($validated);
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Depósito actualizado exitosamente',
                'data' => $deposito->load(['cuentaBancaria.banco', 'proyecto', 'tipoIngreso'])
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
            $deposito = Deposito::findOrFail($id);
            
            if ($deposito->estatus !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden eliminar depósitos pendientes'
                ], 422);
            }
            
            DB::beginTransaction();
            $deposito->delete();
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Depósito eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function aplicar($id)
    {
        try {
            DB::beginTransaction();
            $deposito = Deposito::findOrFail($id);
            
            if ($deposito->estatus !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'El depósito ya fue ' . $deposito->estatus
                ], 422);
            }
            
            $movimiento = $deposito->aplicar();
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Depósito aplicado exitosamente',
                'movimiento' => $movimiento
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al aplicar depósito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function getEstadisticas()
    {
        try {
            $total = Deposito::count();
            $aplicados = Deposito::where('estatus', 'aplicado')->count();
            $pendientes = Deposito::where('estatus', 'pendiente')->count();
            $proceso = Deposito::where('estatus', 'proceso')->count();
            
            return response()->json([
                'total' => $total,
                'aplicados' => $aplicados,
                'pendientes' => $pendientes,
                'proceso' => $proceso
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}