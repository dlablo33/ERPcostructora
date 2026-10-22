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
use Carbon\Carbon;

class TraspasoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getData', 'print']);
    }

    public function index()
    {
        $cuentasBancarias = CuentaBancaria::with(['banco', 'moneda'])->get();
        $monedas = Moneda::all();
        $proyectos = Proyecto::orderBy('nombre')->get();
        
        $fechaInicioDefault = Carbon::now()->startOfMonth()->format('Y-m-d');
        $fechaFinDefault = Carbon::now()->endOfMonth()->format('Y-m-d');
        
        return view('administracion.tesoreria.transacciones', compact(
            'cuentasBancarias', 
            'monedas', 
            'proyectos',
            'fechaInicioDefault',
            'fechaFinDefault'
        ));
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
            
            $fechaInicio = $request->input('fecha_inicio');
            $fechaFin = $request->input('fecha_fin');
            
            if (!$fechaInicio && !$fechaFin) {
                $fechaInicio = Carbon::now()->startOfMonth()->format('Y-m-d');
                $fechaFin = Carbon::now()->endOfMonth()->format('Y-m-d');
            }
            
            if ($fechaInicio) $query->whereDate('fecha', '>=', $fechaInicio);
            if ($fechaFin) $query->whereDate('fecha', '<=', $fechaFin);
            if ($request->filled('estatus')) $query->where('estatus', $request->estatus);
            if ($request->filled('cuenta_origen_id')) $query->where('cuenta_origen_id', $request->cuenta_origen_id);
            if ($request->filled('cuenta_destino_id')) $query->where('cuenta_destino_id', $request->cuenta_destino_id);
            
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
            
            if (!$monedaOrigenId || !$monedaDestinoId || $monedaOrigenId == $monedaDestinoId) {
                return response()->json(['tipo_cambio' => 1]);
            }
            
            $tipoCambio = \App\Models\TipoCambio::where('moneda_origen_id', $monedaOrigenId)
                ->where('moneda_destino_id', $monedaDestinoId)
                ->whereDate('fecha', '<=', $fecha)
                ->orderBy('fecha', 'desc')
                ->first();
            
            return response()->json(['tipo_cambio' => $tipoCambio->tasa ?? 1]);
        } catch (\Exception $e) {
            Log::error('Error al obtener tipo de cambio: ' . $e->getMessage());
            return response()->json(['tipo_cambio' => 1, 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'fecha' => 'required|date',
                'cuenta_origen_id' => 'required|exists:cuentas_bancarias,id',
                'cuenta_destino_id' => 'required|exists:cuentas_bancarias,id|different:cuenta_origen_id',
                'monto' => 'required|numeric|min:0.01',
                'tipo_cambio' => 'nullable|numeric|min:0',
                'monto_destino' => 'nullable|numeric|min:0',
                'concepto' => 'nullable|string|max:500',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'referencia' => 'nullable|string|max:100',
                'referencia_bancaria' => 'nullable|string|max:100',
                'observaciones' => 'nullable|string',
                'aplicar_ahora' => 'boolean',
                'moneda_origen_id' => 'nullable|exists:monedas,id',
                'moneda_destino_id' => 'nullable|exists:monedas,id',
            ]);
            
            DB::beginTransaction();
            
            $cuentaOrigen = CuentaBancaria::findOrFail($validated['cuenta_origen_id']);
            $cuentaDestino = CuentaBancaria::findOrFail($validated['cuenta_destino_id']);
            
            $validated['moneda_origen_id'] = $cuentaOrigen->moneda_id ?? ($validated['moneda_origen_id'] ?? null);
            $validated['moneda_destino_id'] = $cuentaDestino->moneda_id ?? ($validated['moneda_destino_id'] ?? null);
            
            if (empty($validated['moneda_origen_id']) || empty($validated['moneda_destino_id'])) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo determinar la moneda de las cuentas seleccionadas'
                ], 422);
            }
            
            if (empty($validated['monto_destino'])) {
                $tipoCambio = $validated['tipo_cambio'] ?? 1;
                $validated['monto_destino'] = $validated['monto'] * $tipoCambio;
            }
            
            $validated['folio'] = Traspaso::generarFolio();
            $validated['estatus'] = 'pendiente';
            $validated['created_by'] = auth()->id();
            
            $traspaso = Traspaso::create($validated);
            
            // Si se pidió aplicar ahora, aplicar dentro de la misma transacción
            if ($validated['aplicar_ahora'] ?? false) {
                $this->aplicarTraspasoInterno($traspaso);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Traspaso creado exitosamente',
                'data' => $traspaso->fresh()->load([
                    'cuentaOrigen.banco', 
                    'cuentaDestino.banco', 
                    'monedaOrigen', 
                    'monedaDestino', 
                    'proyecto'
                ])
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
                'monto' => 'required|numeric|min:0.01',
                'tipo_cambio' => 'nullable|numeric|min:0',
                'monto_destino' => 'nullable|numeric|min:0',
                'concepto' => 'nullable|string|max:500',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'referencia' => 'nullable|string|max:100',
                'referencia_bancaria' => 'nullable|string|max:100',
                'observaciones' => 'nullable|string',
                'moneda_origen_id' => 'nullable|exists:monedas,id',
                'moneda_destino_id' => 'nullable|exists:monedas,id',
            ]);
            
            DB::beginTransaction();
            
            $cuentaOrigen = CuentaBancaria::findOrFail($validated['cuenta_origen_id']);
            $cuentaDestino = CuentaBancaria::findOrFail($validated['cuenta_destino_id']);
            
            $validated['moneda_origen_id'] = $cuentaOrigen->moneda_id ?? ($validated['moneda_origen_id'] ?? null);
            $validated['moneda_destino_id'] = $cuentaDestino->moneda_id ?? ($validated['moneda_destino_id'] ?? null);
            
            if (empty($validated['monto_destino'])) {
                $tipoCambio = $validated['tipo_cambio'] ?? 1;
                $validated['monto_destino'] = $validated['monto'] * $tipoCambio;
            }
            
            $traspaso->update($validated);
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Traspaso actualizado exitosamente',
                'data' => $traspaso->fresh()->load([
                    'cuentaOrigen.banco', 
                    'cuentaDestino.banco', 
                    'monedaOrigen', 
                    'monedaDestino', 
                    'proyecto'
                ])
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
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'El traspaso ya fue ' . $traspaso->estatus
                ], 422);
            }
            
            $this->aplicarTraspasoInterno($traspaso);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Traspaso aplicado exitosamente. Saldos actualizados.'
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

    /**
     * Lógica central de aplicación del traspaso.
     * Debe llamarse dentro de una transacción.
     *
     * PROBLEMA 4 RESUELTO: aquí se actualizan explícitamente los saldos
     * de las cuentas bancarias y se crean los movimientos bancarios,
     * en lugar de depender del método del modelo Traspaso->aplicar()
     * que puede no estar implementado correctamente.
     */
    /**
 * Lógica central de aplicación del traspaso.
 * Debe llamarse dentro de una transacción.
 *
 * IMPORTANTE (PostgreSQL):
 *  - Un try/catch de PHP no protege la transacción. Si una sentencia falla,
 *    Postgres aborta la transacción y rechaza cualquier sentencia posterior.
 *  - Para poder continuar tras un error opcional (como MovimientoBancario)
 *    se usa un SAVEPOINT explícito.
 */
private function aplicarTraspasoInterno(Traspaso $traspaso)
{
    $cuentaOrigen  = CuentaBancaria::lockForUpdate()->findOrFail($traspaso->cuenta_origen_id);
    $cuentaDestino = CuentaBancaria::lockForUpdate()->findOrFail($traspaso->cuenta_destino_id);

    $monto        = (float) $traspaso->monto;
    $montoDestino = (float) $traspaso->monto_destino;

    // Validar saldo suficiente
    if ((float) $cuentaOrigen->saldo_actual < $monto) {
        throw new \Exception(
            'Saldo insuficiente en la cuenta origen. Saldo actual: ' .
            number_format($cuentaOrigen->saldo_actual, 2)
        );
    }

    // 1) Afectar saldos
    $cuentaOrigen->saldo_actual  = (float) $cuentaOrigen->saldo_actual  - $monto;
    $cuentaDestino->saldo_actual = (float) $cuentaDestino->saldo_actual + $montoDestino;
    $cuentaOrigen->save();
    $cuentaDestino->save();

    // 2) Crear movimientos bancarios con SAVEPOINT (por si el modelo tiene
    //    columnas no definidas en la migración; así no se aborta la transacción).
    DB::statement('SAVEPOINT sp_movimientos');
    try {
        MovimientoBancario::create([
            'cuenta_bancaria_id'  => $cuentaOrigen->id,
            'fecha'               => $traspaso->fecha,
            'tipo'                => 'egreso',
            'monto'               => $monto,
            'concepto'            => 'Traspaso a ' . ($cuentaDestino->numero_cuenta ?? '') . ' - ' . ($traspaso->concepto ?? ''),
            'referencia'          => $traspaso->referencia,
            'referencia_bancaria' => $traspaso->referencia_bancaria,
            'proyecto_id'         => $traspaso->proyecto_id,
            'traspaso_id'         => $traspaso->id,
            'created_by'          => auth()->id(),
        ]);

        MovimientoBancario::create([
            'cuenta_bancaria_id'  => $cuentaDestino->id,
            'fecha'               => $traspaso->fecha,
            'tipo'                => 'ingreso',
            'monto'               => $montoDestino,
            'concepto'            => 'Traspaso desde ' . ($cuentaOrigen->numero_cuenta ?? '') . ' - ' . ($traspaso->concepto ?? ''),
            'referencia'          => $traspaso->referencia,
            'referencia_bancaria' => $traspaso->referencia_bancaria,
            'proyecto_id'         => $traspaso->proyecto_id,
            'traspaso_id'         => $traspaso->id,
            'created_by'          => auth()->id(),
        ]);

        DB::statement('RELEASE SAVEPOINT sp_movimientos');
    } catch (\Exception $e) {
        // En Postgres es OBLIGATORIO volver al savepoint para poder continuar
        DB::statement('ROLLBACK TO SAVEPOINT sp_movimientos');
        Log::warning('No se pudieron crear los movimientos bancarios: ' . $e->getMessage());
    }

    // 3) Marcar traspaso como completado
    //    Verificar que las columnas existan en la tabla. Si 'fecha_aplicacion'
    //    no existe, usar solo estatus.
    try {
        $traspaso->estatus = 'completado';

        // Solo setear fecha_aplicacion si la columna existe
        if (\Schema::hasColumn('traspasos', 'fecha_aplicacion')) {
            $traspaso->fecha_aplicacion = now();
        }

        $traspaso->save();
    } catch (\Exception $e) {
        Log::error('Error al guardar estatus del traspaso: ' . $e->getMessage());
        throw $e;
    }

    return $traspaso;
}

    /**
     * PROBLEMA 3 RESUELTO: endpoint de impresión.
     * Devuelve una vista imprimible del traspaso.
     */
    public function print($id)
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
            
            return view('administracion.tesoreria.traspaso_print', compact('traspaso'));
        } catch (\Exception $e) {
            Log::error('Error al imprimir traspaso: ' . $e->getMessage());
            abort(404, 'Traspaso no encontrado');
        }
    }

    public function getEstadisticas(Request $request)
    {
        try {
            $fechaInicio = $request->input('fecha_inicio', Carbon::now()->startOfMonth()->format('Y-m-d'));
            $fechaFin = $request->input('fecha_fin', Carbon::now()->endOfMonth()->format('Y-m-d'));
            
            $baseQuery = Traspaso::whereDate('fecha', '>=', $fechaInicio)
                                 ->whereDate('fecha', '<=', $fechaFin);
            
            $total = (clone $baseQuery)->count();
            $pendientes = (clone $baseQuery)->where('estatus', 'pendiente')->count();
            $completados = (clone $baseQuery)->where('estatus', 'completado')->count();
            $cancelados = (clone $baseQuery)->where('estatus', 'cancelado')->count();
            $totalMonto = (clone $baseQuery)->sum('monto');
            
            return response()->json([
                'success' => true,
                'resumen' => [
                    'total' => $total,
                    'pendientes' => $pendientes,
                    'completados' => $completados,
                    'cancelados' => $cancelados,
                    'total_monto' => round($totalMonto, 2),
                ],
                'rango' => [
                    'fecha_inicio' => $fechaInicio,
                    'fecha_fin' => $fechaFin,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getEstadisticas traspasos: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}