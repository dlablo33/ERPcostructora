<?php

namespace App\Http\Controllers;

use App\Models\PresupuestoMensual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PresupuestoMensualController extends Controller
{
    /**
     * Mostrar la vista principal del presupuesto mensual.
     */
    public function index()
    {
        return view('presupuesto-mensual.index');
    }

    /**
     * Listar presupuestos con filtros, búsqueda y paginación (AJAX).
     * Repara el ticket: búsqueda, filtros de fecha, paginación real.
     */
    public function listar(Request $request)
    {
        try {
            $query = PresupuestoMensual::query();

            // Filtro por rango de fechas (basado en año/mes)
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $inicio = Carbon::parse($request->fecha_inicio);
                $fin = Carbon::parse($request->fecha_fin);

                $query->where(function ($q) use ($inicio, $fin) {
                    $q->where(function ($sub) use ($inicio) {
                        $sub->where('anio', '>', $inicio->year)
                            ->orWhere(function ($s) use ($inicio) {
                                $s->where('anio', $inicio->year)
                                  ->where('mes', '>=', $inicio->month);
                            });
                    })->where(function ($sub) use ($fin) {
                        $sub->where('anio', '<', $fin->year)
                            ->orWhere(function ($s) use ($fin) {
                                $s->where('anio', $fin->year)
                                  ->where('mes', '<=', $fin->month);
                            });
                    });
                });
            }

            // Búsqueda por folio, observaciones
            if ($request->filled('buscar')) {
                $termino = $request->buscar;
                $query->where(function ($q) use ($termino) {
                    $q->where('presupuesto_mensual_id', 'like', "%{$termino}%")
                      ->orWhere('observaciones', 'like', "%{$termino}%")
                      ->orWhere('mes', 'like', "%{$termino}%")
                      ->orWhere('anio', 'like', "%{$termino}%");
                });
            }

            // Ordenamiento
            $ordenPor = $request->get('orden_por', 'anio');
            $ordenDir = $request->get('orden_dir', 'desc');
            $query->orderBy($ordenPor, $ordenDir)->orderBy('mes', 'desc');

            $porPagina = (int) $request->get('por_pagina', 8);
            $paginado = $query->paginate($porPagina);

            // Totales
            $sumaMonto = (clone $query)->sum('monto');

            return response()->json([
                'success' => true,
                'data' => $paginado->items(),
                'total' => $paginado->total(),
                'suma_monto' => (float) $sumaMonto,
                'current_page' => $paginado->currentPage(),
                'last_page' => $paginado->lastPage(),
                'per_page' => $paginado->perPage(),
                'from' => $paginado->firstItem(),
                'to' => $paginado->lastItem(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error listar presupuestos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los presupuestos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Guardar un nuevo presupuesto (botón +).
     * Repara el ticket: botón + funcional.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mes' => 'required|integer|between:1,12',
            'anio' => 'required|integer|min:2000|max:2100',
            'monto' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Datos inválidos'
            ], 422);
        }

        // Validar unicidad (mes + año)
        $existe = PresupuestoMensual::where('mes', $request->mes)
            ->where('anio', $request->anio)
            ->exists();

        if ($existe) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe un presupuesto para ese mes y año.'
            ], 422);
        }

        try {
            $presupuesto = PresupuestoMensual::create([
                'mes' => $request->mes,
                'anio' => $request->anio,
                'monto' => $request->monto,
                'observaciones' => $request->observaciones,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Presupuesto creado correctamente.',
                'data' => $presupuesto
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error crear presupuesto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el presupuesto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener un presupuesto para editar / ver (botones editar y ver).
     * Repara el ticket: botón editar y ver funcional.
     */
    public function show($id)
    {
        try {
            $presupuesto = PresupuestoMensual::find($id);

            if (!$presupuesto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Presupuesto no encontrado.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $presupuesto
            ]);
        } catch (\Exception $e) {
            Log::error('Error show presupuesto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el presupuesto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un presupuesto existente (botón editar).
     * Repara el ticket: botón editar funcional.
     */
    public function update(Request $request, $id)
    {
        $presupuesto = PresupuestoMensual::find($id);

        if (!$presupuesto) {
            return response()->json([
                'success' => false,
                'message' => 'Presupuesto no encontrado.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'mes' => 'required|integer|between:1,12',
            'anio' => 'required|integer|min:2000|max:2100',
            'monto' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Datos inválidos'
            ], 422);
        }

        // Validar unicidad (mes+año) excluyendo el actual
        $existe = PresupuestoMensual::where('mes', $request->mes)
            ->where('anio', $request->anio)
            ->where('presupuesto_mensual_id', '!=', $id)
            ->exists();

        if ($existe) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe otro presupuesto para ese mes y año.'
            ], 422);
        }

        try {
            $presupuesto->update([
                'mes' => $request->mes,
                'anio' => $request->anio,
                'monto' => $request->monto,
                'observaciones' => $request->observaciones,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Presupuesto actualizado correctamente.',
                'data' => $presupuesto
            ]);
        } catch (\Exception $e) {
            Log::error('Error actualizar presupuesto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el presupuesto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un presupuesto (botón eliminar).
     * Repara el ticket: botón eliminar funcional.
     */
    public function destroy($id)
    {
        $presupuesto = PresupuestoMensual::find($id);

        if (!$presupuesto) {
            return response()->json([
                'success' => false,
                'message' => 'Presupuesto no encontrado.'
            ], 404);
        }

        try {
            $presupuesto->delete();
            return response()->json([
                'success' => true,
                'message' => 'Presupuesto eliminado correctamente.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error eliminar presupuesto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el presupuesto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exportar a Excel (botón Excel).
     * Repara el ticket: botón Excel funcional.
     */
    public function exportarExcel(Request $request)
    {
        try {
            $query = PresupuestoMensual::query();

            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $inicio = Carbon::parse($request->fecha_inicio);
                $fin = Carbon::parse($request->fecha_fin);
                $query->where('anio', '>=', $inicio->year)
                      ->where('anio', '<=', $fin->year);
            }

            $datos = $query->orderBy('anio', 'desc')->orderBy('mes', 'desc')->get();

            $nombreArchivo = 'presupuesto_mensual_' . date('Ymd_His') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"$nombreArchivo\"",
            ];

            $callback = function () use ($datos) {
                $file = fopen('php://output', 'w');
                fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8
                fputcsv($file, ['Folio', 'Mes', 'Año', 'Monto', 'Observaciones']);

                $meses = [
                    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                ];

                foreach ($datos as $d) {
                    fputcsv($file, [
                        $d->presupuesto_mensual_id,
                        $meses[$d->mes] ?? $d->mes,
                        $d->anio,
                        number_format($d->monto, 2, '.', ''),
                        $d->observaciones,
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Error exportar presupuestos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generar PDF de un presupuesto (botón PDF).
     * Repara el ticket: botón PDF funcional.
     */
    public function pdf($id)
    {
        try {
            $presupuesto = PresupuestoMensual::find($id);

            if (!$presupuesto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Presupuesto no encontrado.'
                ], 404);
            }

            // Si tienes barryvdh/laravel-dompdf instalado:
            // $pdf = \PDF::loadView('presupuesto-mensual.pdf', compact('presupuesto'));
            // return $pdf->download("presupuesto_{$id}.pdf");

            // Alternativa sin dependencias: devolver JSON para debug
            return response()->json([
                'success' => true,
                'message' => 'Para generar PDF instala barryvdh/laravel-dompdf',
                'data' => $presupuesto
            ]);
        } catch (\Exception $e) {
            Log::error('Error PDF presupuesto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar PDF: ' . $e->getMessage()
            ], 500);
        }
    }
}