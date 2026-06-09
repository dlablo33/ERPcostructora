<?php

namespace App\Http\Controllers;

use App\Models\PolizaContable;
use App\Models\Proyecto;
use App\Models\CuentaContable;
use App\Models\MovimientoPoliza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PolizaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $cuentas = CuentaContable::all();
            $fechaInicio = date('Y-m-01');
            $fechaFin = date('Y-m-d');
            
            return view('conta.registros.polizas', compact('cuentas', 'fechaInicio', 'fechaFin'));
        } catch (\Exception $e) {
            Log::error('Error en index: ' . $e->getMessage());
            return view('conta.registros.polizas', ['cuentas' => [], 'fechaInicio' => date('Y-m-01'), 'fechaFin' => date('Y-m-d')]);
        }
    }

    /**
     * Get data for the polizas table with filters.
     */
    public function getData(Request $request)
    {
        try {
            $fechaInicio = $request->get('fecha_inicio', '2026-01-01');
            $fechaFin = $request->get('fecha_fin', '2026-01-31');
            $proyectoId = $request->get('proyecto_id');

            // Construir la consulta
            $query = PolizaContable::with('proyecto')
                ->whereBetween('fecha', [$fechaInicio, $fechaFin]);
            
            if ($proyectoId && $proyectoId !== '' && $proyectoId !== 'null') {
                $query->where('proyecto_id', $proyectoId);
            }
            
            $polizas = $query->orderBy('fecha', 'desc')
                ->orderBy('poliza_contable_id', 'desc')
                ->get();
            
            // Formatear datos - USANDO LOS MONTOS DE LA TABLA polizas_contables
            $data = [];
            foreach ($polizas as $poliza) {
                $data[] = [
                    'poliza_contable_id' => $poliza->poliza_contable_id,
                    'folio' => $poliza->folio,
                    'estatus' => $poliza->estatus ?? 'Registrado',
                    'fecha' => $poliza->fecha,
                    'descripcion' => $poliza->descripcion ?? '-',
                    'origen' => $poliza->origen ?? '-',
                    'folio_origen' => $poliza->origen_id ?? '-',
                    'tipo_poliza' => $poliza->tipo_poliza ?? 'diario',
                    'carta_porte_id' => $poliza->carta_porte_id ?? '-',
                    'proyecto_id' => $poliza->proyecto_id,
                    'proyecto_nombre' => $poliza->proyecto ? $poliza->proyecto->nombre : null,
                    'monto_cargo' => floatval($poliza->monto_cargo ?? 0),
                    'monto_abono' => floatval($poliza->monto_abono ?? 0),
                    'verificado' => $poliza->verificado ?? false
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en getData: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los datos: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Get poliza by ID for editing.
     */
    public function show($id)
    {
        try {
            $poliza = PolizaContable::with('movimientos')
                ->where('poliza_contable_id', $id)
                ->firstOrFail();

            $movimientos = $poliza->movimientos->map(function($movimiento) {
                return [
                    'id' => $movimiento->id,
                    'cuenta_contable_id' => $movimiento->cuenta_contable_id,
                    'debe' => floatval($movimiento->debe),
                    'haber' => floatval($movimiento->haber),
                    'descripcion' => $movimiento->descripcion ?? ''
                ];
            });

            return response()->json([
                'success' => true,
                'poliza' => [
                    'poliza_contable_id' => $poliza->poliza_contable_id,
                    'id' => $poliza->poliza_contable_id,
                    'fecha' => $poliza->fecha,
                    'origen' => $poliza->origen,
                    'origen_id' => $poliza->origen_id,
                    'descripcion' => $poliza->descripcion,
                    'proyecto_id' => $poliza->proyecto_id,
                    'total_debe' => floatval($poliza->monto_cargo ?? 0),
                    'total_haber' => floatval($poliza->monto_abono ?? 0)
                ],
                'movimientos' => $movimientos
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en show: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created poliza in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'fecha' => 'required|date',
                'origen' => 'required|string|max:100',
                'origen_id' => 'nullable|string|max:50',
                'descripcion' => 'required|string',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'total_debe' => 'required|numeric',
                'total_haber' => 'required|numeric',
                'movimientos' => 'required|array|min:1',
                'movimientos.*.cuenta_contable_id' => 'required|exists:cuentas_contables,id',
                'movimientos.*.debe' => 'required|numeric|min:0',
                'movimientos.*.haber' => 'required|numeric|min:0',
                'movimientos.*.descripcion' => 'nullable|string'
            ]);

            if (abs($validated['total_debe'] - $validated['total_haber']) > 0.01) {
                return response()->json([
                    'success' => false,
                    'message' => 'La póliza no está balanceada'
                ], 422);
            }

            $year = date('Y', strtotime($validated['fecha']));
            $month = date('m', strtotime($validated['fecha']));
            $lastPoliza = PolizaContable::whereYear('fecha', $year)
                ->whereMonth('fecha', $month)
                ->orderBy('poliza_contable_id', 'desc')
                ->first();

            if ($lastPoliza && $lastPoliza->folio) {
                $lastNumber = intval(substr($lastPoliza->folio, -4));
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '0001';
            }

            $folio = "P-{$year}{$month}-{$newNumber}";

            $poliza = PolizaContable::create([
                'folio' => $folio,
                'fecha' => $validated['fecha'],
                'origen' => $validated['origen'],
                'origen_id' => $validated['origen_id'] ?? null,
                'descripcion' => $validated['descripcion'],
                'proyecto_id' => !empty($validated['proyecto_id']) ? $validated['proyecto_id'] : null,
                'monto_cargo' => $validated['total_debe'],
                'monto_abono' => $validated['total_haber'],
                'estatus' => 'Registrado',
                'tipo_poliza' => 'diario',
                'verificado' => false
            ]);

            foreach ($validated['movimientos'] as $movimiento) {
                if (!empty($movimiento['cuenta_contable_id'])) {
                    MovimientoPoliza::create([
                        'poliza_contable_id' => $poliza->poliza_contable_id,
                        'cuenta_contable_id' => $movimiento['cuenta_contable_id'],
                        'debe' => $movimiento['debe'] ?? 0,
                        'haber' => $movimiento['haber'] ?? 0,
                        'descripcion' => $movimiento['descripcion'] ?? ''
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Póliza creada exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR en store: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified poliza in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $poliza = PolizaContable::where('poliza_contable_id', $id)->firstOrFail();

            $validated = $request->validate([
                'fecha' => 'required|date',
                'origen' => 'required|string',
                'origen_id' => 'nullable|string',
                'descripcion' => 'required|string',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'total_debe' => 'required|numeric',
                'total_haber' => 'required|numeric',
                'movimientos' => 'required|array',
                'movimientos.*.cuenta_contable_id' => 'required|exists:cuentas_contables,id',
                'movimientos.*.debe' => 'required|numeric|min:0',
                'movimientos.*.haber' => 'required|numeric|min:0',
                'movimientos.*.descripcion' => 'nullable|string'
            ]);

            if (abs($validated['total_debe'] - $validated['total_haber']) > 0.01) {
                return response()->json([
                    'success' => false,
                    'message' => 'La póliza no está balanceada'
                ], 422);
            }

            $poliza->update([
                'fecha' => $validated['fecha'],
                'origen' => $validated['origen'],
                'origen_id' => $validated['origen_id'] ?? null,
                'descripcion' => $validated['descripcion'],
                'proyecto_id' => !empty($validated['proyecto_id']) ? $validated['proyecto_id'] : null,
                'monto_cargo' => $validated['total_debe'],
                'monto_abono' => $validated['total_haber']
            ]);

            MovimientoPoliza::where('poliza_contable_id', $poliza->poliza_contable_id)->delete();

            foreach ($validated['movimientos'] as $movimiento) {
                if (!empty($movimiento['cuenta_contable_id'])) {
                    MovimientoPoliza::create([
                        'poliza_contable_id' => $poliza->poliza_contable_id,
                        'cuenta_contable_id' => $movimiento['cuenta_contable_id'],
                        'debe' => $movimiento['debe'] ?? 0,
                        'haber' => $movimiento['haber'] ?? 0,
                        'descripcion' => $movimiento['descripcion'] ?? ''
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Póliza actualizada exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR en update: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified poliza from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $poliza = PolizaContable::where('poliza_contable_id', $id)->firstOrFail();

            if ($poliza->estatus === 'Contabilizado') {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar una póliza contabilizada'
                ], 422);
            }

            MovimientoPoliza::where('poliza_contable_id', $poliza->poliza_contable_id)->delete();
            $poliza->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Póliza eliminada exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR en destroy: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get list of proyectos for the filter.
     */
    public function getProyectosLista()
    {
        try {
            $proyectos = Proyecto::where('status', 'activo')
                ->select('id', 'codigo', 'nombre')
                ->orderBy('codigo')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $proyectos
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en getProyectosLista: ' . $e->getMessage());
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }
    }

    /**
     * Get list of cuentas contables.
     */
    public function getCuentasContables()
    {
        try {
            $cuentas = CuentaContable::select('id', 'codigo', 'nombre')
                ->orderBy('codigo')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $cuentas
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en getCuentasContables: ' . $e->getMessage());
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }
    }

    /**
     * Export polizas to Excel.
     */
    public function exportExcel(Request $request)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Exportación en desarrollo'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en exportExcel: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}