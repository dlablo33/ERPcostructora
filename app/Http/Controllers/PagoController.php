<?php
// app/Http/Controllers/PagoController.php
namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\CuentaBancaria;
use App\Models\Proveedor;
use App\Models\Proyecto;
use App\Models\TipoEgreso;
use App\Models\CategoriaGasto;
use App\Models\MetodoPago;
use App\Models\Moneda;
use App\Models\MovimientoBancario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PagoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getData']);
    }

    public function index()
    {
        // Obtener datos para los selects
        $cuentasBancarias = CuentaBancaria::with(['banco', 'moneda'])->where('activa', true)->get();
        $proveedores = Proveedor::where('activo', true)->orderBy('nombre')->get();
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        $tiposEgreso = TipoEgreso::where('activo', true)->get();
        $categoriasGasto = CategoriaGasto::where('activo', true)->get();
        $metodosPago = MetodoPago::where('activo', true)->get();
        $monedas = Moneda::where('activa', true)->get();
        
        return view('administracion.tesoreria.pagos', compact(
            'cuentasBancarias', 'proveedores', 'proyectos', 
            'tiposEgreso', 'categoriasGasto', 'metodosPago', 'monedas'
        ));
    }

    public function getData(Request $request)
    {
        try {
            $query = Pago::with(['cuentaBancaria.banco', 'proveedor', 'proyecto', 'tipoEgreso', 'categoriaGasto', 'metodoPago', 'moneda']);
            
            if ($request->has('fecha_inicio') && $request->fecha_inicio) {
                $query->whereDate('fecha_pago', '>=', $request->fecha_inicio);
            }
            
            if ($request->has('fecha_fin') && $request->fecha_fin) {
                $query->whereDate('fecha_pago', '<=', $request->fecha_fin);
            }
            
            if ($request->has('estatus') && $request->estatus) {
                $query->where('estatus', $request->estatus);
            }
            
            if ($request->has('proveedor_id') && $request->proveedor_id) {
                $query->where('proveedor_id', $request->proveedor_id);
            }
            
            $pagos = $query->orderBy('fecha_pago', 'desc')->get();
            return response()->json($pagos);
        } catch (\Exception $e) {
            Log::error('Error en getData pagos: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Obtiene las categorías de gasto por tipo de egreso
     */
    public function getCategoriasPorTipoEgreso($tipoEgresoId)
    {
        try {
            $categorias = CategoriaGasto::where('tipo_egreso_id', $tipoEgresoId)
                ->where('activo', true)
                ->orderBy('nombre')
                ->get(['id', 'nombre']);
            return response()->json($categorias);
        } catch (\Exception $e) {
            Log::error('Error al obtener categorías: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Datos recibidos en store:', $request->all());
            
            $validated = $request->validate([
                'fecha_pago' => 'required|date',
                'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
                'proveedor_id' => 'nullable|exists:proveedores,id',
                'proveedor_nombre' => 'nullable|string|max:200',
                'proveedor_rfc' => 'nullable|string|max:20',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'tipo_egreso_id' => 'required|exists:tipos_egreso,id',
                'categoria_gasto_id' => 'nullable|exists:categorias_gastos,id',
                'metodo_pago_id' => 'required|exists:metodos_pago,id',
                'moneda_id' => 'required|exists:monedas,id',
                'monto' => 'required|numeric|min:0.01',
                'concepto' => 'required|string|max:500',
                'referencia' => 'nullable|string|max:100',
                'referencia_bancaria' => 'nullable|string|max:100',
                'factura' => 'nullable|string|max:50',
                'observaciones' => 'nullable|string',
                'aplicar_ahora' => 'boolean'
            ]);
            
            DB::beginTransaction();
            
            $validated['folio'] = Pago::generarFolio();
            $validated['estatus'] = ($validated['aplicar_ahora'] ?? false) ? 'completado' : 'pendiente';
            $validated['created_by'] = auth()->id();
            
            $pago = Pago::create($validated);
            
            if ($validated['aplicar_ahora'] ?? false) {
                $this->aplicarPago($pago);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pago creado exitosamente',
                'data' => $pago->load(['cuentaBancaria.banco', 'proveedor', 'proyecto', 'tipoEgreso', 'categoriaGasto', 'metodoPago', 'moneda'])
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
            Log::error('Error al crear pago: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $pago = Pago::with(['cuentaBancaria.banco', 'proveedor', 'proyecto', 'tipoEgreso', 'categoriaGasto', 'metodoPago', 'moneda', 'creador'])
                ->findOrFail($id);
            return response()->json($pago);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Pago no encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $pago = Pago::findOrFail($id);
            
            if ($pago->estatus !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden editar pagos pendientes'
                ], 422);
            }
            
            $validated = $request->validate([
                'fecha_pago' => 'required|date',
                'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
                'proveedor_id' => 'nullable|exists:proveedores,id',
                'proveedor_nombre' => 'nullable|string|max:200',
                'proveedor_rfc' => 'nullable|string|max:20',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'tipo_egreso_id' => 'required|exists:tipos_egreso,id',
                'categoria_gasto_id' => 'nullable|exists:categorias_gastos,id',
                'metodo_pago_id' => 'required|exists:metodos_pago,id',
                'moneda_id' => 'required|exists:monedas,id',
                'monto' => 'required|numeric|min:0.01',
                'concepto' => 'required|string|max:500',
                'referencia' => 'nullable|string|max:100',
                'referencia_bancaria' => 'nullable|string|max:100',
                'factura' => 'nullable|string|max:50',
                'observaciones' => 'nullable|string'
            ]);
            
            DB::beginTransaction();
            $pago->update($validated);
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pago actualizado exitosamente',
                'data' => $pago->load(['cuentaBancaria.banco', 'proveedor', 'proyecto', 'tipoEgreso', 'categoriaGasto', 'metodoPago', 'moneda'])
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
            $pago = Pago::findOrFail($id);
            
            if ($pago->estatus !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden eliminar pagos pendientes'
                ], 422);
            }
            
            DB::beginTransaction();
            $pago->delete();
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pago eliminado exitosamente'
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
            $pago = Pago::findOrFail($id);
            
            if ($pago->estatus !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'El pago ya fue ' . $pago->estatus
                ], 422);
            }
            
            $this->aplicarPago($pago);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pago aplicado exitosamente. Saldo actualizado.',
                'data' => $pago->load(['cuentaBancaria.banco', 'proveedor', 'proyecto', 'tipoEgreso', 'categoriaGasto', 'metodoPago', 'moneda'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al aplicar pago: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function aplicarPago($pago)
    {
        // Actualizar saldo de la cuenta bancaria (EGRESO - se resta)
        $cuenta = CuentaBancaria::find($pago->cuenta_bancaria_id);
        if ($cuenta) {
            $cuenta->saldo_actual = $cuenta->saldo_actual - $pago->monto;
            $cuenta->save();
            
            Log::info('Saldo actualizado. Nuevo saldo cuenta ' . $cuenta->id . ': ' . $cuenta->saldo_actual);
        }
        
        // Crear movimiento bancario
        $movimiento = MovimientoBancario::create([
            'cuenta_bancaria_id' => $pago->cuenta_bancaria_id,
            'proyecto_id' => $pago->proyecto_id,
            'tipo' => 'egreso',
            'tipo_egreso_id' => $pago->tipo_egreso_id,
            'categoria_gasto_id' => $pago->categoria_gasto_id,
            'metodo_pago_id' => $pago->metodo_pago_id,
            'monto' => $pago->monto,
            'fecha' => $pago->fecha_pago,
            'concepto' => $pago->concepto,
            'referencia' => $pago->referencia,
            'comprobante' => $pago->comprobante,
            'status' => 'aplicado',
            'observaciones' => 'Pago: ' . ($pago->observaciones ?? ''),
            'created_by' => $pago->created_by
        ]);
        
        $pago->estatus = 'completado';
        $pago->save();
        
        Log::info('Movimiento creado ID: ' . $movimiento->id);
        
        return $movimiento;
    }
    
    public function getEstadisticas()
    {
        try {
            $total = Pago::count();
            $pendientes = Pago::where('estatus', 'pendiente')->count();
            $completados = Pago::where('estatus', 'completado')->count();
            $cancelados = Pago::where('estatus', 'cancelado')->count();
            $totalMonto = Pago::sum('monto');
            
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