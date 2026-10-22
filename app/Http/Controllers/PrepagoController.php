<?php

namespace App\Http\Controllers;

use App\Models\Prepago;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class PrepagoController extends Controller
{
    /**
     * Listado principal (renderiza la vista con la tabla).
     */
    public function index(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', date('Y-m-01'));
        $fechaFin    = $request->get('fecha_fin', date('Y-m-d'));

        return view('prepagos.index', compact('fechaInicio', 'fechaFin'));
    }

    /**
     * Endpoint AJAX que devuelve los datos para la tabla.
     * Si no usas AJAX, puedes inyectar $prepagos en la vista directamente.
     */
    public function listado(Request $request)
    {
        try {
            $query = Prepago::with(['proveedor:id,nombre']);

            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha', '>=', $request->fecha_inicio);
            }
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha', '<=', $request->fecha_fin);
            }
            if ($request->filled('buscar')) {
                $buscar = $request->buscar;
                $query->where(function ($q) use ($buscar) {
                    $q->where('folio', 'like', "%{$buscar}%")
                      ->orWhereHas('proveedor', fn ($p) => $p->where('nombre', 'like', "%{$buscar}%"));
                });
            }

            $prepagos = $query->orderByDesc('fecha')->orderByDesc('id')->get();

            return response()->json([
                'success' => true,
                'data'    => $prepagos->map(fn ($p) => [
                    'prepago_id' => $p->folio ?? $p->id,
                    'id'         => $p->id,
                    'proveedor'  => $p->proveedor->nombre ?? 'Sin proveedor',
                    'fecha'      => optional($p->fecha)->format('Y-m-d'),
                    'monto'      => (float) $p->monto,
                ]),
            ]);
        } catch (\Throwable $e) {
            Log::error('Prepago listado: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al listar prepagos'], 500);
        }
    }

    /**
     * Catálogo de proveedores para el modal de agregar/editar.
     */
    public function proveedores()
    {
        return response()->json([
            'success' => true,
            'data'    => Proveedor::select('id', 'nombre')->orderBy('nombre')->get(),
        ]);
    }

    /**
     * Guardar nuevo prepago (Botón "+").
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha'        => 'required|date',
            'monto'        => 'required|numeric|min:0.01',
            'folio'        => 'nullable|string|max:50|unique:prepagos,folio',
            'observaciones'=> 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $prepago = Prepago::create([
                'folio'         => $request->folio ?: $this->generarFolio(),
                'proveedor_id'  => $request->proveedor_id,
                'fecha'         => $request->fecha,
                'monto'         => $request->monto,
                'observaciones' => $request->observaciones,
                'estatus'       => 'activo',
                'user_id'       => auth()->id(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Prepago creado correctamente',
                'data'    => $prepago->load('proveedor:id,nombre'),
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Prepago store: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al crear prepago'], 500);
        }
    }

    /**
     * Ver detalle de un prepago (Botón "ojo" / Visualizar).
     */
    public function show($id)
    {
        try {
            $prepago = Prepago::with('proveedor:id,nombre')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data'    => [
                    'id'            => $prepago->id,
                    'folio'         => $prepago->folio,
                    'proveedor'     => $prepago->proveedor->nombre ?? 'Sin proveedor',
                    'proveedor_id'  => $prepago->proveedor_id,
                    'fecha'         => optional($prepago->fecha)->format('Y-m-d'),
                    'monto'         => (float) $prepago->monto,
                    'observaciones' => $prepago->observaciones,
                    'estatus'       => $prepago->estatus,
                ],
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Prepago no encontrado'], 404);
        } catch (\Throwable $e) {
            Log::error('Prepago show: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al obtener prepago'], 500);
        }
    }

    /**
     * Actualizar prepago (Botón "editar").
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha'        => 'required|date',
            'monto'        => 'required|numeric|min:0.01',
            'folio'        => 'nullable|string|max:50|unique:prepagos,folio,' . $id,
            'observaciones'=> 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $prepago = Prepago::findOrFail($id);
            $prepago->update([
                'proveedor_id'  => $request->proveedor_id,
                'fecha'         => $request->fecha,
                'monto'         => $request->monto,
                'observaciones' => $request->observaciones,
                'folio'         => $request->folio ?: $prepago->folio,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Prepago actualizado correctamente',
                'data'    => $prepago->fresh()->load('proveedor:id,nombre'),
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Prepago no encontrado'], 404);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Prepago update: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al actualizar prepago'], 500);
        }
    }

    /**
     * Eliminar prepago (Botón "papelera").
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $prepago = Prepago::findOrFail($id);

            // Si manejas soft deletes, usa ->delete(); sino ->forceDelete();
            $prepago->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Prepago eliminado correctamente',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Prepago no encontrado'], 404);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Prepago destroy: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al eliminar prepago'], 500);
        }
    }

    /**
     * Generar PDF individual (Botón "PDF").
     */
    public function pdf($id)
    {
        try {
            $prepago = Prepago::with('proveedor:id,nombre')->findOrFail($id);

            $pdf = Pdf::loadView('prepagos.pdf', compact('prepago'))
                ->setPaper('letter', 'portrait');

            return $pdf->download("Prepago_{$prepago->folio}.pdf");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Prepago no encontrado');
        } catch (\Throwable $e) {
            Log::error('Prepago pdf: ' . $e->getMessage());
            abort(500, 'Error al generar PDF');
        }
    }

    /**
     * Exportar a Excel (Botón "Exportar").
     * Requiere: composer require maatwebsite/excel
     */
    public function exportExcel(Request $request)
    {
        try {
            $query = Prepago::with('proveedor:id,nombre');

            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha', '>=', $request->fecha_inicio);
            }
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha', '<=', $request->fecha_fin);
            }

            $prepagos = $query->orderByDesc('fecha')->get();

            $filename = 'prepagos_' . now()->format('Ymd_His') . '.csv';
            $headers = [
                'Content-Type'        => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename={$filename}",
            ];

            $callback = function () use ($prepagos) {
                $handle = fopen('php://output', 'w');
                fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8

                fputcsv($handle, ['Folio', 'Proveedor', 'Fecha', 'Monto', 'Estatus']);

                foreach ($prepagos as $p) {
                    fputcsv($handle, [
                        $p->folio,
                        $p->proveedor->nombre ?? 'Sin proveedor',
                        optional($p->fecha)->format('d/m/Y'),
                        number_format($p->monto, 2, '.', ''),
                        $p->estatus,
                    ]);
                }

                fclose($handle);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Throwable $e) {
            Log::error('Prepago exportExcel: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al exportar'], 500);
        }
    }

    /**
     * Generar folio consecutivo automático.
     */
    private function generarFolio(): string
{
    $year = now()->year;

    // Contar sobre el MODELO Prepago (no sobre $this)
    $total = Prepago::withTrashed()
        ->whereYear('created_at', $year)
        ->count();

    $consecutivo = $total + 1;

    // Evitar colisiones si dos usuarios guardan al mismo tiempo
    while (
        Prepago::withTrashed()
            ->where('folio', 'PRE-' . $year . '-' . str_pad($consecutivo, 6, '0', STR_PAD_LEFT))
            ->exists()
    ) {
        $consecutivo++;
    }

    return 'PRE-' . $year . '-' . str_pad($consecutivo, 6, '0', STR_PAD_LEFT);
}
}