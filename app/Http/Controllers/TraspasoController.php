<?php
// app/Http/Controllers/TraspasoController.php
namespace App\Http\Controllers;

use App\Models\Traspaso;
use App\Models\CuentaBancaria;
use App\Models\Moneda;
use App\Models\Proyecto;
use App\Models\MovimientoBancario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TraspasoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getData']);
    }

    public function index()
    {
        // Obtener datos para los selects - CORREGIDO: obtener TODAS las cuentas primero para depuración
        $cuentasBancarias = CuentaBancaria::with(['banco', 'moneda'])->get();
        
        // Si quieres solo las activas, usa where('activa', true) pero primero verifica que el campo existe
        // $cuentasBancarias = CuentaBancaria::with(['banco', 'moneda'])->where('activa', true)->get();
        
        $monedas = Moneda::all(); // Cambiado a all() para obtener todas
        $proyectos = Proyecto::orderBy('nombre')->get(); // Cambiado a all() para obtener todos
        
        // Depuración - Registrar en log
        Log::info('=== TRASPASOS INDEX ===');
        Log::info('Cuentas encontradas: ' . $cuentasBancarias->count());
        Log::info('Monedas encontradas: ' . $monedas->count());
        Log::info('Proyectos encontrados: ' . $proyectos->count());
        
        // CORREGIDO: Cambiar 'traspasos' por 'transacciones' porque ese es el nombre de tu archivo
        return view('administracion.tesoreria.transacciones', compact('cuentasBancarias', 'monedas', 'proyectos'));
    }

    public function getData(Request $request)
    {
        try {
            $query = Traspaso::with([
                'cuentaOrigen.banco', 
                'cuentaOrigen.moneda',
                'cuentaDestino.banco', 
                'cuentaDestino.moneda',
                'monedaOrigen',
                'monedaDestino',
                'proyecto'
            ]);
            
            if ($request->has('fecha_inicio') && $request->fecha_inicio) {
                $query->whereDate('fecha', '>=', $request->fecha_inicio);
            }
            
            if ($request->has('fecha_fin') && $request->fecha_fin) {
                $query->whereDate('fecha', '<=', $request->fecha_fin);
            }
            
            if ($request->has('estatus') && $request->estatus) {
                $query->where('estatus', $request->estatus);
            }
            
            if ($request->has('cuenta_origen_id') && $request->cuenta_origen_id) {
                $query->where('cuenta_origen_id', $request->cuenta_origen_id);
            }
            
            if ($request->has('cuenta_destino_id') && $request->cuenta_destino_id) {
                $query->where('cuenta_destino_id', $request->cuenta_destino_id);
            }
            
            $traspasos = $query->orderBy('fecha', 'desc')->get();
            return response()->json($traspasos);
        } catch (\Exception $e) {
            Log::error('Error en getData traspasos: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getTipoCambio(Request $request)
    {
        try {
            $monedaOrigenId = $request->get('moneda_origen_id');
            $monedaDestinoId = $request->get('moneda_destino_id');
            $fecha = $request->get('fecha', date('Y-m-d'));
            
            if (!$monedaOrigenId || !$monedaDestinoId) {
                return response()->json(['tipo_cambio' => 1]);
            }
            
            // Si es la misma moneda, tipo de cambio = 1
            if ($monedaOrigenId == $monedaDestinoId) {
                return response()->json(['tipo_cambio' => 1]);
            }
            
            // Buscar tipo de cambio en la tabla tipos_cambio
            $tipoCambio = \App\Models\TipoCambio::where('moneda_origen_id', $monedaOrigenId)
                ->where('moneda_destino_id', $monedaDestinoId)
                ->whereDate('fecha', '<=', $fecha)
                ->orderBy('fecha', 'desc')
                ->first();
            
            if ($tipoCambio) {
                return response()->json(['tipo_cambio' => $tipoCambio->tasa]);
            }
            
            // Si no se encuentra, usar 1 por defecto
            return response()->json(['tipo_cambio' => 1]);
        } catch (\Exception $e) {
            Log::error('Error al obtener tipo de cambio: ' . $e->getMessage());
            return response()->json(['tipo_cambio' => 1, 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Datos recibidos en store traspaso:', $request->all());
            
            $validated = $request->validate([
                'fecha' => 'required|date',
                'cuenta_origen_id' => 'required|exists:cuentas_bancarias,id',
                'cuenta_destino_id' => 'required|exists:cuentas_bancarias,id|different:cuenta_origen_id',
                'moneda_origen_id' => 'required|exists:monedas,id',
                'moneda_destino_id' => 'required|exists:monedas,id',
                'monto' => 'required|numeric|min:0.01',
                'tipo_cambio' => 'nullable|numeric|min:0',
                'monto_destino' => 'nullable|numeric|min:0',
                'concepto' => 'nullable|string|max:500',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'referencia' => 'nullable|string|max:100',
                'referencia_bancaria' => 'nullable|string|max:100',
                'observaciones' => 'nullable|string',
                'aplicar_ahora' => 'boolean'
            ]);
            
            DB::beginTransaction();
            
            // Calcular monto destino si no viene
            if (empty($validated['monto_destino']) && isset($validated['tipo_cambio'])) {
                $validated['monto_destino'] = $validated['monto'] * $validated['tipo_cambio'];
            }
            
            $validated['folio'] = Traspaso::generarFolio();
            $validated['estatus'] = ($validated['aplicar_ahora'] ?? false) ? 'completado' : 'pendiente';
            $validated['created_by'] = auth()->id();
            
            $traspaso = Traspaso::create($validated);
            
            if ($validated['aplicar_ahora'] ?? false) {
                $traspaso->aplicar();
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Traspaso creado exitosamente',
                'data' => $traspaso->load(['cuentaOrigen.banco', 'cuentaDestino.banco', 'monedaOrigen', 'monedaDestino', 'proyecto'])
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear traspaso: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $traspaso = Traspaso::with([
                'cuentaOrigen.banco', 
                'cuentaOrigen.moneda',
                'cuentaDestino.banco', 
                'cuentaDestino.moneda',
                'monedaOrigen',
                'monedaDestino',
                'proyecto',
                'creador'
            ])->findOrFail($id);
            return response()->json($traspaso);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Traspaso no encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $traspaso = Traspaso::findOrFail($id);
            
            if ($traspaso->estatus !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden editar traspasos pendientes'
                ], 422);
            }
            
            $validated = $request->validate([
                'fecha' => 'required|date',
                'cuenta_origen_id' => 'required|exists:cuentas_bancarias,id',
                'cuenta_destino_id' => 'required|exists:cuentas_bancarias,id|different:cuenta_origen_id',
                'moneda_origen_id' => 'required|exists:monedas,id',
                'moneda_destino_id' => 'required|exists:monedas,id',
                'monto' => 'required|numeric|min:0.01',
                'tipo_cambio' => 'nullable|numeric|min:0',
                'monto_destino' => 'nullable|numeric|min:0',
                'concepto' => 'nullable|string|max:500',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'referencia' => 'nullable|string|max:100',
                'referencia_bancaria' => 'nullable|string|max:100',
                'observaciones' => 'nullable|string'
            ]);
            
            DB::beginTransaction();
            
            // Calcular monto destino si no viene
            if (empty($validated['monto_destino']) && isset($validated['tipo_cambio'])) {
                $validated['monto_destino'] = $validated['monto'] * $validated['tipo_cambio'];
            }
            
            $traspaso->update($validated);
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Traspaso actualizado exitosamente',
                'data' => $traspaso->load(['cuentaOrigen.banco', 'cuentaDestino.banco', 'monedaOrigen', 'monedaDestino', 'proyecto'])
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
            $traspaso = Traspaso::findOrFail($id);
            
            if ($traspaso->estatus !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden eliminar traspasos pendientes'
                ], 422);
            }
            
            DB::beginTransaction();
            $traspaso->delete();
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Traspaso eliminado exitosamente'
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
            $traspaso = Traspaso::findOrFail($id);
            
            if ($traspaso->estatus !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'El traspaso ya fue ' . $traspaso->estatus
                ], 422);
            }
            
            $movimientos = $traspaso->aplicar();
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Traspaso aplicado exitosamente. Saldos actualizados.',
                'movimientos' => $movimientos
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al aplicar traspaso: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function getEstadisticas()
    {
        try {
            $total = Traspaso::count();
            $pendientes = Traspaso::where('estatus', 'pendiente')->count();
            $completados = Traspaso::where('estatus', 'completado')->count();
            $cancelados = Traspaso::where('estatus', 'cancelado')->count();
            $totalMonto = Traspaso::sum('monto');
            
            return response()->json([
                'total' => $total,
                'pendientes' => $pendientes,
                'completados' => $completados,
                'cancelados' => $cancelados,
                'total_monto' => $totalMonto
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}