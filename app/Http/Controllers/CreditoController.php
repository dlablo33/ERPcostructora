<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Credito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class CreditoController extends Controller
{
    public function index()
    {
        return view('creditos.index');
    }

    public function listar(Request $request)
    {
        try {
            $query = Credito::with('banco');

            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            }

            if ($request->filled('buscar')) {
                $termino = $request->buscar;
                $query->where(function ($q) use ($termino) {
                    $q->where('numero_credito', 'LIKE', "%{$termino}%")
                      ->orWhereHas('banco', function ($q2) use ($termino) {
                          $q2->where('nombre', 'LIKE', "%{$termino}%")
                             ->orWhere('codigo', 'LIKE', "%{$termino}%");
                      })
                      ->orWhere('parcialidad_actual', 'LIKE', "%{$termino}%");
                });
            }

            if ($request->filled('banco_id')) {
                $query->where('banco_id', $request->banco_id);
            }

            $creditos = $query->orderBy('fecha', 'desc')->get();

            $data = $creditos->map(function ($credito) {
                return [
                    'credito_id'              => $credito->id,
                    'numero'                  => $credito->numero_credito,
                    'entidad_financiera'      => $credito->banco->nombre ?? 'Sin banco',  // 👈 se mantiene el nombre de campo que usa el front
                    'banco_codigo'            => $credito->banco->codigo ?? null,
                    'fecha'                   => $credito->fecha,
                    'monto_total'             => (float) $credito->monto_total,
                    'monto_pendiente'         => (float) $credito->monto_pendiente,
                    'monto_capital'           => (float) $credito->monto_capital,
                    'monto_capital_restante'  => (float) $credito->monto_capital_restante,
                    'parcialidad_actual'      => $credito->parcialidad_actual,
                ];
            });

            return response()->json([
                'success' => true,
                'data'    => $data,
                'totales' => [
                    'monto_total'            => $data->sum('monto_total'),
                    'monto_pendiente'        => $data->sum('monto_pendiente'),
                    'monto_capital'          => $data->sum('monto_capital'),
                    'monto_capital_restante' => $data->sum('monto_capital_restante'),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Error al listar créditos: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al cargar los créditos'], 500);
        }
    }

    public function editar($id)
    {
        try {
            $credito = Credito::with('banco')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id'                     => $credito->id,
                    'numero_credito'         => $credito->numero_credito,
                    'banco_id'               => $credito->banco_id,
                    'entidad_financiera'     => $credito->banco->nombre ?? '',
                    'fecha'                  => $credito->fecha,
                    'monto_total'            => (float) $credito->monto_total,
                    'monto_pendiente'        => (float) $credito->monto_pendiente,
                    'monto_capital'          => (float) $credito->monto_capital,
                    'monto_capital_restante' => (float) $credito->monto_capital_restante,
                    'parcialidad_actual'     => $credito->parcialidad_actual,
                    'tasa_interes'           => (float) $credito->tasa_interes,
                    'plazo_meses'            => $credito->plazo_meses,
                    'notas'                  => $credito->notas,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Error al cargar crédito para edición: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Crédito no encontrado'], 404);
        }
    }

    public function crear(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_credito'         => 'required|string|max:50|unique:creditos,numero_credito',
            'banco_id'               => 'required|exists:bancos,id',
            'fecha'                  => 'required|date',
            'monto_total'            => 'required|numeric|min:0.01',
            'monto_pendiente'        => 'required|numeric|min:0',
            'monto_capital'          => 'required|numeric|min:0',
            'monto_capital_restante' => 'required|numeric|min:0',
            'parcialidad_actual'     => 'required|string|max:20',
            'tasa_interes'           => 'nullable|numeric|min:0|max:100',
            'plazo_meses'            => 'nullable|integer|min:1',
            'notas'                  => 'nullable|string|max:1000',
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
            $credito = Credito::create($request->all());
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Crédito creado exitosamente',
                'data'    => ['id' => $credito->id],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear crédito: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al crear el crédito'], 500);
        }
    }

    public function actualizar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'numero_credito'         => 'required|string|max:50|unique:creditos,numero_credito,' . $id,
            'banco_id'               => 'required|exists:bancos,id',
            'fecha'                  => 'required|date',
            'monto_total'            => 'required|numeric|min:0.01',
            'monto_pendiente'        => 'required|numeric|min:0',
            'monto_capital'          => 'required|numeric|min:0',
            'monto_capital_restante' => 'required|numeric|min:0',
            'parcialidad_actual'     => 'required|string|max:20',
            'tasa_interes'           => 'nullable|numeric|min:0|max:100',
            'plazo_meses'            => 'nullable|integer|min:1',
            'notas'                  => 'nullable|string|max:1000',
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
            $credito = Credito::findOrFail($id);
            $credito->update($request->all());
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Crédito actualizado exitosamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar crédito: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al actualizar el crédito'], 500);
        }
    }

    public function eliminar($id)
    {
        try {
            DB::beginTransaction();
            $credito = Credito::findOrFail($id);
            $credito->parcialidades()->delete();
            $credito->delete();
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Crédito eliminado exitosamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar crédito: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al eliminar el crédito'], 500);
        }
    }

    public function ver($id)
    {
        try {
            $credito = Credito::with(['banco', 'parcialidades'])->findOrFail($id);

            $parcialidades = $credito->parcialidades->map(fn ($p) => [
                'id'                => $p->id,
                'numero'            => $p->numero,
                'fecha_vencimiento' => $p->fecha_vencimiento,
                'monto'             => (float) $p->monto,
                'capital'           => (float) $p->capital,
                'interes'           => (float) $p->interes,
                'estado'            => $p->estado,
                'fecha_pago'        => $p->fecha_pago,
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'id'                     => $credito->id,
                    'numero_credito'         => $credito->numero_credito,
                    'entidad_financiera'     => $credito->banco->nombre ?? 'Sin banco',
                    'fecha'                  => $credito->fecha,
                    'monto_total'            => (float) $credito->monto_total,
                    'monto_pendiente'        => (float) $credito->monto_pendiente,
                    'monto_capital'          => (float) $credito->monto_capital,
                    'monto_capital_restante' => (float) $credito->monto_capital_restante,
                    'parcialidad_actual'     => $credito->parcialidad_actual,
                    'tasa_interes'           => (float) $credito->tasa_interes,
                    'plazo_meses'            => $credito->plazo_meses,
                    'notas'                  => $credito->notas,
                    'parcialidades'          => $parcialidades,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Error al ver crédito: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Crédito no encontrado'], 404);
        }
    }

    public function parcialidades($id)
    {
        try {
            $credito = Credito::with('parcialidades')->findOrFail($id);

            $parcialidades = $credito->parcialidades->map(fn ($p) => [
                'id'                => $p->id,
                'numero'            => $p->numero,
                'fecha_vencimiento' => $p->fecha_vencimiento,
                'monto'             => (float) $p->monto,
                'capital'           => (float) $p->capital,
                'interes'           => (float) $p->interes,
                'saldo'             => (float) $p->saldo,
                'estado'            => $p->estado,
                'fecha_pago'        => $p->fecha_pago,
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'credito_id'      => $credito->id,
                    'numero_credito'  => $credito->numero_credito,
                    'parcialidades'   => $parcialidades,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener parcialidades: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Crédito no encontrado'], 404);
        }
    }

    public function pdf($id)
    {
        try {
            $credito = Credito::with(['banco', 'parcialidades'])->findOrFail($id);

            $pdf = Pdf::loadView('creditos.pdf', [
                'credito'           => $credito,
                'parcialidades'     => $credito->parcialidades,
                'fecha_generacion'  => now()->format('d/m/Y H:i'),
            ])->setPaper('letter', 'portrait');

            $filename = 'Credito_' . $credito->numero_credito . '_' . date('Ymd') . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            Log::error('Error al generar PDF de crédito: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al generar el PDF'], 500);
        }
    }

    // 👇 Ahora devuelve bancos en lugar de entidades financieras
    public function bancos()
    {
        try {
            $bancos = Banco::activos()
                ->select('id', 'nombre', 'codigo')
                ->orderBy('nombre')
                ->get();

            return response()->json(['success' => true, 'data' => $bancos]);
        } catch (\Exception $e) {
            Log::error('Error al obtener bancos: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al obtener bancos'], 500);
        }
    }

    public function exportar(Request $request)
    {
        try {
            $query = Credito::with('banco');

            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            }

            $creditos = $query->orderBy('fecha', 'desc')->get();

            $filename = 'creditos_' . date('Ymd_His') . '.csv';
            $handle = fopen('php://temp', 'w+');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'No. Crédito', 'Banco', 'Código Banco', 'Fecha',
                'Monto Total', 'Pendiente', 'Monto Capital',
                'Restante Capital', 'Parcialidad Actual',
            ]);

            foreach ($creditos as $c) {
                fputcsv($handle, [
                    $c->numero_credito,
                    $c->banco->nombre ?? 'Sin banco',
                    $c->banco->codigo ?? '',
                    $c->fecha,
                    number_format($c->monto_total, 2, '.', ''),
                    number_format($c->monto_pendiente, 2, '.', ''),
                    number_format($c->monto_capital, 2, '.', ''),
                    number_format($c->monto_capital_restante, 2, '.', ''),
                    $c->parcialidad_actual,
                ]);
            }

            rewind($handle);
            $content = stream_get_contents($handle);
            fclose($handle);

            return response($content, 200, [
                'Content-Type'        => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al exportar créditos: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al exportar'], 500);
        }
    }

        /**
     * Registrar una nueva parcialidad en un crédito.
     * Regla opcional: si estado='pagada' y es la parcialidad siguiente,
     * se avanza parcialidad_actual y se reduce monto_capital_restante.
     */
    public function crearParcialidad(Request $request, $creditoId)
    {
        $validator = Validator::make($request->all(), [
            'numero'            => 'required|integer|min:1',
            'fecha_vencimiento' => 'required|date',
            'fecha_pago'        => 'nullable|date',
            'monto'             => 'required|numeric|min:0.01',
            'capital'           => 'required|numeric|min:0',
            'interes'           => 'required|numeric|min:0',
            'saldo'             => 'required|numeric|min:0',
            'estado'            => 'required|in:pendiente,pagada,vencida,parcial',
            'notas'             => 'nullable|string|max:1000',
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

            $credito = Credito::findOrFail($creditoId);

            // Evitar duplicados de número dentro del mismo crédito
            if ($credito->parcialidades()->where('numero', $request->numero)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe una parcialidad con ese número para este crédito',
                ], 422);
            }

            $parcialidad = $credito->parcialidades()->create($request->only([
                'numero', 'fecha_vencimiento', 'fecha_pago',
                'monto', 'capital', 'interes', 'saldo',
                'estado', 'notas',
            ]));

            // Recalcular estado del crédito si la parcialidad quedó pagada
            if ($parcialidad->estado === 'pagada') {
                $this->recalcularCredito($credito);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Parcialidad registrada exitosamente',
                'data'    => ['id' => $parcialidad->id],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear parcialidad: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al crear la parcialidad'], 500);
        }
    }

    /**
     * Actualizar parcialidad existente.
     */
    public function actualizarParcialidad(Request $request, $creditoId, $parcialidadId)
    {
        $validator = Validator::make($request->all(), [
            'numero'            => 'required|integer|min:1',
            'fecha_vencimiento' => 'required|date',
            'fecha_pago'        => 'nullable|date',
            'monto'             => 'required|numeric|min:0.01',
            'capital'           => 'required|numeric|min:0',
            'interes'           => 'required|numeric|min:0',
            'saldo'             => 'required|numeric|min:0',
            'estado'            => 'required|in:pendiente,pagada,vencida,parcial',
            'notas'             => 'nullable|string|max:1000',
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

            $credito = Credito::findOrFail($creditoId);
            $parcialidad = $credito->parcialidades()->findOrFail($parcialidadId);

            // Validar duplicado si cambia el número
            if ((int) $request->numero !== (int) $parcialidad->numero) {
                if ($credito->parcialidades()->where('numero', $request->numero)->exists()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ya existe otra parcialidad con ese número',
                    ], 422);
                }
            }

            $parcialidad->update($request->only([
                'numero', 'fecha_vencimiento', 'fecha_pago',
                'monto', 'capital', 'interes', 'saldo',
                'estado', 'notas',
            ]));

            $this->recalcularCredito($credito);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Parcialidad actualizada',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar parcialidad: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al actualizar'], 500);
        }
    }

    /**
     * Eliminar parcialidad.
     */
    public function eliminarParcialidad($creditoId, $parcialidadId)
    {
        try {
            DB::beginTransaction();

            $credito = Credito::findOrFail($creditoId);
            $parcialidad = $credito->parcialidades()->findOrFail($parcialidadId);
            $parcialidad->delete();

            $this->recalcularCredito($credito);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Parcialidad eliminada']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar parcialidad: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al eliminar'], 500);
        }
    }

    /**
     * Recalcula parcialidad_actual, monto_capital_restante y estado del crédito
     * a partir de sus parcialidades pagadas.
     */
    private function recalcularCredito(Credito $credito): void
    {
        $parcialidades = $credito->parcialidades()->orderBy('numero')->get();

        $pagadas = $parcialidades->where('estado', 'pagada')->count();
        $total    = $parcialidades->count();

        // Capital pagado = suma de "capital" de parcialidades pagadas
        $capitalPagado = $parcialidades->where('estado', 'pagada')->sum('capital');

        // Saldo insoluto = último "saldo" de la parcialidad pagada de mayor número
        $ultimaPagada = $parcialidades->where('estado', 'pagada')->sortByDesc('numero')->first();
        $saldoRestante = $ultimaPagada ? (float) $ultimaPagada->saldo : (float) $credito->monto_capital;

        $credito->parcialidad_actual     = $total > 0 ? "{$pagadas}/{$total}" : $credito->parcialidad_actual;
        $credito->monto_capital_restante = max(0, $saldoRestante);
        $credito->monto_pendiente        = max(0, $saldoRestante);

        // Estado del crédito
        if ($total > 0 && $pagadas === $total) {
            $credito->estado = 'pagado';
        } elseif ($parcialidades->where('estado', 'vencida')->count() > 0) {
            $credito->estado = 'vencido';
        } else {
            $credito->estado = 'activo';
        }

        $credito->save();
    }
}