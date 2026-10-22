<?php

namespace App\Http\Controllers;

use App\Models\Anticipo;
use App\Models\Proveedor;
use App\Models\CuentaBancaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Moneda;

class AnticipoController extends Controller
{
    /**
     * Mostrar la vista principal de anticipos
     */
    public function index()
    {
        return view('anticipos.index');
    }

    /**
     * Obtener lista de anticipos (AJAX/JSON)
     * Usado para cargar la tabla dinámicamente
     */
    public function listar(Request $request)
    {
        try {
            $query = Anticipo::query()
                ->with(['proveedor', 'cuentaBancaria', 'moneda']);

            // Filtros por fecha
            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha', '>=', $request->fecha_inicio);
            }
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha', '<=', $request->fecha_fin);
            }

            // Filtro por estatus
            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }

            // Búsqueda general
            if ($request->filled('buscar')) {
                $termino = $request->buscar;
                $query->where(function ($q) use ($termino) {
                    $q->where('folio', 'LIKE', "%{$termino}%")
                      ->orWhere('referencia', 'LIKE', "%{$termino}%")
                      ->orWhere('referencia_bancaria', 'LIKE', "%{$termino}%")
                      ->orWhere('descripcion', 'LIKE', "%{$termino}%")
                      ->orWhereHas('proveedor', function ($pq) use ($termino) {
                          $pq->where('nombre', 'LIKE', "%{$termino}%");
                      });
                });
            }

            $anticipos = $query->orderBy('fecha', 'desc')->get();

            $data = $anticipos->map(function ($anticipo) {
                return [
                    'anticipo_id'         => $anticipo->id,
                    'estatus'             => $anticipo->estatus,
                    'proveedor'           => $anticipo->proveedor->nombre ?? 'Sin proveedor',
                    'forma_pago'          => $anticipo->forma_pago,
                    'cuenta_bancaria'     => $anticipo->cuentaBancaria->numero_cuenta ?? '-',
                    'fecha'               => $anticipo->fecha?->format('Y-m-d'),
                    'referencia'          => $anticipo->referencia,
                    'referencia_bancaria' => $anticipo->referencia_bancaria,
                    'monto'               => (float) $anticipo->monto,
                    'monto_restante'      => (float) $anticipo->monto_restante,
                    'moneda'              => $anticipo->moneda->codigo ?? 'MXN',
                    'tipo_cambio'         => (float) ($anticipo->tipo_cambio ?? 1),
                    'descripcion'         => $anticipo->descripcion,
                ];
            });

            return response()->json([
                'success' => true,
                'data'    => $data,
                'totales' => [
                    'registros'      => $data->count(),
                    'suma_monto'     => $data->sum('monto'),
                    'suma_restante'  => $data->sum('monto_restante'),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Error al listar anticipos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los anticipos: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Guardar un nuevo anticipo (Botón +)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'proveedor_id'        => 'required|exists:proveedores,id',
            'cuenta_bancaria_id'  => 'nullable|exists:cuentas_bancarias,id',
            'moneda_id'           => 'required|exists:monedas,id',
            'forma_pago'          => 'required|string|max:50',
            'fecha'               => 'required|date',
            'referencia'          => 'required|string|max:100|unique:anticipos,referencia',
            'referencia_bancaria' => 'nullable|string|max:100',
            'monto'               => 'required|numeric|min:0.01',
            'tipo_cambio'         => 'nullable|numeric|min:0.0001',
            'descripcion'         => 'nullable|string|max:500',
            'estatus'             => 'nullable|in:Pendiente,Aprobado,Rechazado,Liquidado,Cancelado',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $anticipo = Anticipo::create([
                'folio'               => $this->generarFolio(),
                'proveedor_id'        => $request->proveedor_id,
                'cuenta_bancaria_id'  => $request->cuenta_bancaria_id,
                'moneda_id'           => $request->moneda_id,
                'forma_pago'          => $request->forma_pago,
                'fecha'               => $request->fecha,
                'referencia'          => $request->referencia,
                'referencia_bancaria' => $request->referencia_bancaria,
                'monto'               => $request->monto,
                'monto_restante'      => $request->monto,
                'tipo_cambio'         => $request->tipo_cambio ?? 1,
                'descripcion'         => $request->descripcion,
                'estatus'             => $request->estatus ?? 'Pendiente',
                'user_id'             => auth()->id(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Anticipo creado correctamente',
                'data'    => $anticipo,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear anticipo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el anticipo: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtener un anticipo para edición (Botón editar)
     */
    public function show($id)
    {
        try {
            $anticipo = Anticipo::with(['proveedor', 'cuentaBancaria', 'moneda'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data'    => [
                    'id'                  => $anticipo->id,
                    'folio'               => $anticipo->folio,
                    'estatus'             => $anticipo->estatus,
                    'proveedor_id'        => $anticipo->proveedor_id,
                    'proveedor'           => $anticipo->proveedor->nombre ?? '',
                    'cuenta_bancaria_id'  => $anticipo->cuenta_bancaria_id,
                    'cuenta_bancaria'     => $anticipo->cuentaBancaria->numero_cuenta ?? '',
                    'moneda_id'           => $anticipo->moneda_id,
                    'moneda'              => $anticipo->moneda->codigo ?? 'MXN',
                    'forma_pago'          => $anticipo->forma_pago,
                    'fecha'               => $anticipo->fecha?->format('Y-m-d'),
                    'referencia'          => $anticipo->referencia,
                    'referencia_bancaria' => $anticipo->referencia_bancaria,
                    'monto'               => (float) $anticipo->monto,
                    'monto_restante'      => (float) $anticipo->monto_restante,
                    'tipo_cambio'         => (float) $anticipo->tipo_cambio,
                    'descripcion'         => $anticipo->descripcion,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener anticipo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Anticipo no encontrado',
            ], 404);
        }
    }

    /**
     * Actualizar un anticipo existente (Botón editar - guardar)
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'proveedor_id'        => 'required|exists:proveedores,id',
            'cuenta_bancaria_id'  => 'nullable|exists:cuentas_bancarias,id',
            'moneda_id'           => 'required|exists:monedas,id',
            'forma_pago'          => 'required|string|max:50',
            'fecha'               => 'required|date',
            'referencia'          => 'required|string|max:100|unique:anticipos,referencia,' . $id,
            'referencia_bancaria' => 'nullable|string|max:100',
            'monto'               => 'required|numeric|min:0.01',
            'tipo_cambio'         => 'nullable|numeric|min:0.0001',
            'descripcion'         => 'nullable|string|max:500',
            'estatus'             => 'required|in:Pendiente,Aprobado,Rechazado,Liquidado,Cancelado',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $anticipo = Anticipo::findOrFail($id);

            // Recalcular monto_restante si cambia el monto
            $diferencia = $request->monto - $anticipo->monto;
            $nuevoRestante = max(0, $anticipo->monto_restante + $diferencia);

            $anticipo->update([
                'proveedor_id'        => $request->proveedor_id,
                'cuenta_bancaria_id'  => $request->cuenta_bancaria_id,
                'moneda_id'           => $request->moneda_id,
                'forma_pago'          => $request->forma_pago,
                'fecha'               => $request->fecha,
                'referencia'          => $request->referencia,
                'referencia_bancaria' => $request->referencia_bancaria,
                'monto'               => $request->monto,
                'monto_restante'      => $nuevoRestante,
                'tipo_cambio'         => $request->tipo_cambio ?? 1,
                'descripcion'         => $request->descripcion,
                'estatus'             => $request->estatus,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Anticipo actualizado correctamente',
                'data'    => $anticipo->fresh(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar anticipo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el anticipo: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Eliminar un anticipo (Botón eliminar)
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $anticipo = Anticipo::findOrFail($id);

            // Validar que no tenga aplicaciones/pagos asociados
            if ($anticipo->aplicaciones()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el anticipo porque tiene aplicaciones registradas.',
                ], 409);
            }

            $anticipo->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Anticipo eliminado correctamente',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar anticipo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el anticipo: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Generar PDF del anticipo (Botón PDF)
     */
    public function pdf($id)
    {
        try {
            $anticipo = Anticipo::with(['proveedor', 'cuentaBancaria', 'moneda'])->findOrFail($id);

            $pdf = Pdf::loadView('anticipos.pdf', [
                'anticipo' => $anticipo,
            ]);

            $pdf->setPaper('letter', 'portrait');

            return $pdf->download('anticipo_' . $anticipo->folio . '.pdf');
        } catch (\Exception $e) {
            Log::error('Error al generar PDF: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el PDF: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Liquidar un anticipo (Botón liquidar)
     */
    public function liquidar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'monto_liquidar' => 'required|numeric|min:0.01',
            'observaciones'  => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $anticipo = Anticipo::findOrFail($id);

            if ($anticipo->estatus === 'Liquidado' || $anticipo->estatus === 'Cancelado') {
                return response()->json([
                    'success' => false,
                    'message' => 'El anticipo ya está ' . strtolower($anticipo->estatus) . ' y no puede liquidarse.',
                ], 409);
            }

            if ($request->monto_liquidar > $anticipo->monto_restante) {
                return response()->json([
                    'success' => false,
                    'message' => 'El monto a liquidar excede el monto restante ($' . number_format($anticipo->monto_restante, 2) . ').',
                ], 422);
            }

            $nuevoRestante = $anticipo->monto_restante - $request->monto_liquidar;

            $anticipo->update([
                'monto_restante' => $nuevoRestante,
                'estatus'        => $nuevoRestante <= 0 ? 'Liquidado' : 'Aprobado',
            ]);

            // Registrar la aplicación/liquidación
            $anticipo->aplicaciones()->create([
                'monto'         => $request->monto_liquidar,
                'fecha'         => now()->toDateString(),
                'observaciones' => $request->observaciones,
                'user_id'       => auth()->id(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $nuevoRestante <= 0
                    ? 'Anticipo liquidado completamente.'
                    : 'Liquidación parcial registrada. Restante: $' . number_format($nuevoRestante, 2),
                'data'    => $anticipo->fresh(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al liquidar anticipo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al liquidar el anticipo: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Exportar anticipos a Excel
     */
    public function exportarExcel(Request $request)
    {
        try {
            $query = Anticipo::query()->with(['proveedor', 'cuentaBancaria', 'moneda']);

            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha', '>=', $request->fecha_inicio);
            }
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha', '<=', $request->fecha_fin);
            }

            $anticipos = $query->orderBy('fecha', 'desc')->get();

            // Si tienes Laravel Excel instalado:
            // return Excel::download(new AnticiposExport($anticipos), 'anticipos.xlsx');

            // Alternativa simple sin Laravel Excel:
            $filename = 'anticipos_' . now()->format('Ymd_His') . '.csv';
            $headers = [
                'Content-Type'        => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $callback = function () use ($anticipos) {
                $file = fopen('php://output', 'w');
                fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8

                fputcsv($file, [
                    'Estatus', 'Folio', 'Proveedor', 'Forma de Pago',
                    'Cuenta Bancaria', 'Fecha', 'Referencia', 'Ref. Bancaria',
                    'Monto', 'Monto Restante', 'Moneda', 'Tipo de Cambio', 'Descripción',
                ]);

                foreach ($anticipos as $a) {
                    fputcsv($file, [
                        $a->estatus,
                        $a->folio,
                        $a->proveedor->nombre ?? '',
                        $a->forma_pago,
                        $a->cuentaBancaria->numero_cuenta ?? '',
                        $a->fecha?->format('Y-m-d'),
                        $a->referencia,
                        $a->referencia_bancaria,
                        number_format($a->monto, 2, '.', ''),
                        number_format($a->monto_restante, 2, '.', ''),
                        $a->moneda->codigo ?? 'MXN',
                        $a->tipo_cambio,
                        $a->descripcion,
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Error al exportar anticipos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtener catálogos para los formularios (proveedores, cuentas, monedas)
     */
    public function catalogos()
{
    try {
        // Proveedores (usa tu modelo real)
        $proveedores = Proveedor::activos()
            ->select('id', 'nombre', 'alias', 'razon_social', 'rfc')
            ->orderBy('nombre')
            ->get();

        // Cuentas bancarias: usamos banco_id -> relación con Banco
        $cuentas = CuentaBancaria::activas()
            ->with(['banco:id,nombre', 'moneda:id,codigo,simbolo'])
            ->select('id', 'numero_cuenta', 'clabe', 'titular', 'banco_id', 'moneda_id')
            ->get()
            ->map(function ($c) {
                return [
                    'id'                => $c->id,
                    'numero_cuenta'     => $c->numero_cuenta,
                    'numero_formateado' => $c->numero_formateado ?? $c->numero_cuenta,
                    'banco'             => $c->banco->nombre ?? '-',
                    'titular'           => $c->titular ?? '-',
                    'moneda'            => $c->moneda->codigo ?? 'MXN',
                ];
            });

        // Monedas
        $monedas = Moneda::select('id', 'codigo', 'nombre', 'simbolo')
            ->orderBy('codigo')
            ->get();

        return response()->json([
            'success'     => true,
            'proveedores' => $proveedores,
            'cuentas'     => $cuentas,
            'monedas'     => $monedas,
            'formas_pago' => ['Transferencia', 'Cheque', 'Efectivo', 'Tarjeta', 'Otro'],
            'estatus'     => ['Pendiente', 'Aprobado', 'Rechazado', 'Liquidado', 'Cancelado'],
        ]);
    } catch (\Exception $e) {
        Log::error('Error al obtener catálogos: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error al obtener catálogos: ' . $e->getMessage(),
        ], 500);
    }
}

    /**
     * Generar folio único para el anticipo
     */
    private function generarFolio(): string
    {
        $prefijo = 'ANT';
        $anio = now()->format('Y');
        $ultimo = Anticipo::whereYear('created_at', now()->year)
            ->where('folio', 'LIKE', "{$prefijo}-{$anio}-%")
            ->orderBy('id', 'desc')
            ->first();

        $consecutivo = $ultimo ? ((int) substr($ultimo->folio, -4)) + 1 : 1;

        return sprintf('%s-%s-%04d', $prefijo, $anio, $consecutivo);
    }
}