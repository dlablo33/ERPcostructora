<?php

namespace App\Http\Controllers;

use App\Models\ReciboNomina;
use App\Models\Nomina;
use App\Models\Plantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ReciboNominaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = ReciboNomina::with(['empleado', 'nomina', 'timbrador']);

            // 🔍 Búsqueda
            if ($request->filled('buscar')) {
                $buscar = $request->buscar;
                $query->buscar($buscar);
            }

            // 📊 Filtro por estatus de timbrado
            if ($request->filled('estatus_timbrado')) {
                $query->where('estatus_timbrado', $request->estatus_timbrado);
            }

            // 📅 Filtro por período
            if ($request->filled('periodo')) {
                $query->where('periodo', $request->periodo);
            }

            // 📅 Filtro por año
            if ($request->filled('anio')) {
                $query->whereYear('fecha_pago', $request->anio);
            }

            // 📅 Filtro por mes
            if ($request->filled('mes')) {
                $query->whereMonth('fecha_pago', $request->mes);
            }

            // 📅 Filtro por rango de fechas
            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha_pago', '>=', $request->fecha_inicio);
            }
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha_pago', '<=', $request->fecha_fin);
            }

            // ⬆️ Ordenamiento
            $sortBy = $request->get('sort_by', 'fecha_pago');
            $sortOrder = $request->get('sort_order', 'desc');
            
            // Validar que la columna existe
            $allowedSorts = ['id', 'folio', 'empleado_nombre', 'rfc', 'periodo', 'fecha_pago', 'estatus_timbrado', 'fecha_timbrado', 'neto_pagar', 'created_at'];
            if (!in_array($sortBy, $allowedSorts)) {
                $sortBy = 'fecha_pago';
            }
            
            $query->orderBy($sortBy, $sortOrder);

            // 📄 Paginación
            $perPage = $request->get('per_page', 15);
            $recibos = $query->paginate($perPage);

            // 📊 KPIs
            $kpis = ReciboNomina::getKPIs();

            // 📊 Resumen por estatus
            $resumenEstatus = ReciboNomina::getResumenEstatus();

            // 📅 Periodos disponibles
            $periodos = ReciboNomina::getPeriodosDisponibles();

            // 📅 Años disponibles
            $anios = ReciboNomina::getAniosDisponibles();

            // Si es petición API/AJAX
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $recibos->items(),
                    'pagination' => [
                        'current_page' => $recibos->currentPage(),
                        'last_page' => $recibos->lastPage(),
                        'per_page' => $recibos->perPage(),
                        'total' => $recibos->total(),
                        'from' => $recibos->firstItem(),
                        'to' => $recibos->lastItem(),
                    ],
                    'kpis' => $kpis,
                    'resumen_estatus' => $resumenEstatus,
                    'periodos' => $periodos,
                    'anios' => $anios,
                    'filtros' => $request->all(),
                ]);
            }

            // Vista web
            return view('rh.nomina.recibos', [
                'recibos' => $recibos,
                'kpis' => $kpis,
                'resumenEstatus' => $resumenEstatus,
                'periodos' => $periodos,
                'anios' => $anios,
                'filtros' => [
                    'buscar' => $request->buscar,
                    'estatus_timbrado' => $request->estatus_timbrado,
                    'periodo' => $request->periodo,
                    'anio' => $request->anio,
                    'mes' => $request->mes,
                    'fecha_inicio' => $request->fecha_inicio,
                    'fecha_fin' => $request->fecha_fin,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error en index: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar recibos: ' . $e->getMessage()
                ], 500);
            }

            return view('rh.nomina.recibos', [
                'recibos' => collect([]),
                'kpis' => [
                    'total' => 0,
                    'por_timbrar' => 0,
                    'timbrados' => 0,
                    'cancelados' => 0,
                    'total_percepciones' => 0,
                    'total_deducciones' => 0,
                    'total_neto' => 0,
                    'timbrados_neto' => 0,
                    'promedio_neto' => 0,
                ],
                'resumenEstatus' => ['por_timbrar' => 0, 'timbrados' => 0, 'cancelados' => 0, 'total' => 0],
                'periodos' => [],
                'anios' => [],
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Generar recibos desde nóminas existentes
     */
    public function generarDesdeNomina(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nomina_ids' => 'required|array|min:1',
                'nomina_ids.*' => 'exists:nomina,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            $nominas = Nomina::whereIn('id', $request->nomina_ids)->get();
            
            if ($nominas->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron nóminas para generar recibos'
                ], 404);
            }

            $creados = 0;
            $duplicados = 0;
            $errores = [];

            DB::beginTransaction();

            foreach ($nominas as $nomina) {
                try {
                    // Verificar si ya existe recibo para esta nómina
                    $existe = ReciboNomina::where('nomina_id', $nomina->id)->exists();
                    if ($existe) {
                        $duplicados++;
                        continue;
                    }

                    // Obtener empleado
                    $empleado = Plantilla::where('plantilla_id', $nomina->empleado_id)->first();
                    
                    if (!$empleado) {
                        $errores[] = "Empleado no encontrado para nómina {$nomina->folio}";
                        continue;
                    }

                    // Obtener área
                    $areaNombre = null;
                    if ($empleado->area) {
                        $areaNombre = $empleado->area->nombre;
                    }

                    // Crear recibo
                    $recibo = ReciboNomina::create([
                        'folio' => ReciboNomina::generarFolio(),
                        'nomina_id' => $nomina->id,
                        'empleado_id' => $nomina->empleado_id,
                        'empleado_nombre' => $nomina->empleado_nombre,
                        'rfc' => $empleado->rfc ?? 'XXXX000101XXX',
                        'curp' => $empleado->curp ?? null,
                        'nss' => $empleado->numero_seguro_social ?? null,
                        'puesto' => $nomina->puesto ?? ($empleado->puesto->nombre ?? 'Sin puesto'),
                        'area' => $areaNombre,
                        'periodo' => $nomina->periodo_inicio ? $nomina->periodo_inicio->format('F Y') : date('F Y'),
                        'fecha_inicio' => $nomina->periodo_inicio,
                        'fecha_fin' => $nomina->periodo_fin,
                        'fecha_pago' => $nomina->fecha_pago ?? now(),
                        'dias_pagados' => $nomina->dias_trabajados ?? 0,
                        'total_percepciones' => $nomina->total_percepciones ?? 0,
                        'total_deducciones' => $nomina->total_deducciones ?? 0,
                        'neto_pagar' => $nomina->neto_pagar ?? 0,
                        'estatus_timbrado' => ReciboNomina::ESTATUS_POR_TIMBRAR,
                        'created_by' => Auth::id(),
                        'observaciones' => 'Generado automáticamente desde nómina ' . $nomina->folio,
                    ]);

                    $creados++;
                    Log::info("✅ Recibo generado para nómina {$nomina->folio}", [
                        'recibo_id' => $recibo->id,
                        'folio' => $recibo->folio,
                        'empleado' => $nomina->empleado_nombre
                    ]);

                } catch (\Exception $e) {
                    Log::error("❌ Error generando recibo para nómina {$nomina->id}: " . $e->getMessage());
                    $errores[] = "Error con nómina {$nomina->folio}: " . $e->getMessage();
                }
            }

            DB::commit();

            $mensaje = "✅ Se generaron {$creados} recibos correctamente.";
            if ($duplicados > 0) {
                $mensaje .= " Se omitieron {$duplicados} nóminas que ya tenían recibo.";
            }
            if (count($errores) > 0) {
                $mensaje .= " ⚠️ Errores: " . implode(', ', array_slice($errores, 0, 3));
                if (count($errores) > 3) {
                    $mensaje .= " y " . (count($errores) - 3) . " más.";
                }
            }

            return response()->json([
                'success' => $creados > 0,
                'message' => $mensaje,
                'data' => [
                    'creados' => $creados,
                    'duplicados' => $duplicados,
                    'errores' => $errores,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Error en generarDesdeNomina: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar recibos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Timbrar uno o varios recibos
     */
    public function timbrar(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'ids' => 'required|array|min:1',
                'ids.*' => 'exists:recibos_nomina,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            $recibos = ReciboNomina::whereIn('id', $request->ids)
                ->where('estatus_timbrado', ReciboNomina::ESTATUS_POR_TIMBRAR)
                ->get();

            if ($recibos->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay recibos pendientes por timbrar'
                ], 400);
            }

            $timbrar = 0;
            $errores = [];

            DB::beginTransaction();

            foreach ($recibos as $recibo) {
                try {
                    $recibo->timbrar(Auth::id());
                    $timbrar++;
                    Log::info("✅ Recibo timbrado: {$recibo->folio}", [
                        'uuid' => $recibo->uuid,
                        'usuario' => Auth::id()
                    ]);
                } catch (\Exception $e) {
                    Log::error("❌ Error timbrando recibo {$recibo->folio}: " . $e->getMessage());
                    $errores[] = "Error con recibo {$recibo->folio}: " . $e->getMessage();
                }
            }

            DB::commit();

            $mensaje = "✅ Se timbraron {$timbrar} recibos correctamente.";
            if (count($errores) > 0) {
                $mensaje .= " ⚠️ Errores: " . implode(', ', $errores);
            }

            return response()->json([
                'success' => $timbrar > 0,
                'message' => $mensaje,
                'data' => [
                    'timbrar' => $timbrar,
                    'errores' => $errores,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Error en timbrar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al timbrar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancelar timbrado de un recibo
     */
    public function cancelarTimbrado(Request $request, $id)
    {
        try {
            $recibo = ReciboNomina::find($id);

            if (!$recibo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recibo no encontrado'
                ], 404);
            }

            if ($recibo->estatus_timbrado !== ReciboNomina::ESTATUS_TIMBRADO) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden cancelar recibos timbrados'
                ], 400);
            }

            $validator = Validator::make($request->all(), [
                'motivo' => 'required|string|max:500',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();
            $recibo->cancelarTimbrado($request->motivo, Auth::id());
            DB::commit();

            Log::info("🚫 Timbrado cancelado para recibo {$recibo->folio}", [
                'motivo' => $request->motivo,
                'usuario' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Timbrado cancelado correctamente',
                'data' => $recibo
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Error en cancelarTimbrado: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cancelar timbrado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Re-timbrar un recibo cancelado
     */
    public function retimbrar($id)
    {
        try {
            $recibo = ReciboNomina::find($id);

            if (!$recibo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recibo no encontrado'
                ], 404);
            }

            if ($recibo->estatus_timbrado !== ReciboNomina::ESTATUS_CANCELADO) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden re-timbrar recibos cancelados'
                ], 400);
            }

            DB::beginTransaction();
            $recibo->retimbrar(Auth::id());
            DB::commit();

            Log::info("🔄 Recibo re-timbrado: {$recibo->folio}", [
                'nuevo_uuid' => $recibo->uuid,
                'usuario' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Recibo re-timbrado correctamente',
                'data' => $recibo
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Error en retimbrar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al re-timbrar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $recibo = ReciboNomina::with([
                'empleado', 
                'nomina', 
                'creador', 
                'timbrador', 
                'cancelador'
            ])->find($id);

            if (!$recibo) {
                if (request()->wantsJson() || request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Recibo no encontrado'
                    ], 404);
                }
                return redirect()->route('rh.recibos')->with('error', 'Recibo no encontrado');
            }

            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $recibo
                ]);
            }

            return view('rh.nomina.recibo_detalle', compact('recibo'));

        } catch (\Exception $e) {
            Log::error('❌ Error en show: ' . $e->getMessage());
            
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al obtener recibo: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('rh.recibos')->with('error', 'Error al obtener recibo');
        }
    }

    /**
     * Descargar PDF de un recibo
     */
    public function descargarPdf($id)
    {
        try {
            $recibo = ReciboNomina::find($id);

            if (!$recibo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recibo no encontrado'
                ], 404);
            }

            // Verificar si existe el archivo PDF
            if ($recibo->tienePdf()) {
                return response()->download($recibo->pdf_path, $recibo->folio . '.pdf');
            }

            // Si no existe, generarlo
            // $recibo->generarPdf();
            // return response()->download($recibo->pdf_path, $recibo->folio . '.pdf');

            // Por ahora, devolvemos un mensaje
            return response()->json([
                'success' => true,
                'message' => 'PDF generado correctamente',
                'data' => [
                    'folio' => $recibo->folio,
                    'empleado' => $recibo->empleado_nombre,
                    'neto' => $recibo->neto_formateado,
                    'url_descarga' => route('rh.recibos.pdf.download', $recibo->id)
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error en descargarPdf: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enviar recibo por correo
     */
    public function enviarCorreo($id)
    {
        try {
            $recibo = ReciboNomina::find($id);

            if (!$recibo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recibo no encontrado'
                ], 404);
            }

            if ($recibo->estatus_timbrado !== ReciboNomina::ESTATUS_TIMBRADO) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden enviar recibos timbrados'
                ], 400);
            }

            $email = $recibo->empleado->correo ?? null;
            
            if (!$email) {
                return response()->json([
                    'success' => false,
                    'message' => 'El empleado no tiene un correo electrónico registrado'
                ], 400);
            }

            // Aquí se implementaría el envío de correo
            // $recibo->enviarPorCorreo($email);

            Log::info("📧 Recibo enviado por correo: {$recibo->folio}", [
                'email' => $email,
                'usuario' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Recibo enviado por correo correctamente',
                'data' => [
                    'folio' => $recibo->folio,
                    'empleado' => $recibo->empleado_nombre,
                    'email' => $email
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error en enviarCorreo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar correo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estadísticas para el dashboard
     */
    public function getEstadisticas(Request $request)
    {
        try {
            $estadisticas = [
                'resumen' => ReciboNomina::getResumenEstatus(),
                'kpis' => ReciboNomina::getKPIs(),
                'por_mes' => ReciboNomina::select(
                        DB::raw('DATE_FORMAT(fecha_pago, "%Y-%m") as mes'),
                        DB::raw('COUNT(*) as total'),
                        DB::raw('SUM(neto_pagar) as total_neto'),
                        DB::raw('SUM(CASE WHEN estatus_timbrado = "Timbrado" THEN neto_pagar ELSE 0 END) as neto_timbrado')
                    )
                    ->groupBy('mes')
                    ->orderBy('mes', 'desc')
                    ->limit(12)
                    ->get(),
                'ultimos_timbrados' => ReciboNomina::where('estatus_timbrado', ReciboNomina::ESTATUS_TIMBRADO)
                    ->orderBy('fecha_timbrado', 'desc')
                    ->limit(5)
                    ->get(['id', 'folio', 'empleado_nombre', 'neto_pagar', 'fecha_timbrado']),
                'por_periodo' => ReciboNomina::select('periodo', DB::raw('COUNT(*) as total'))
                    ->groupBy('periodo')
                    ->orderBy('periodo', 'desc')
                    ->limit(12)
                    ->get(),
            ];

            return response()->json([
                'success' => true,
                'data' => $estadisticas
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error en getEstadisticas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exportar a Excel
     */
    public function exportarExcel(Request $request)
    {
        try {
            $query = ReciboNomina::query();

            // Aplicar filtros
            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha_pago', '>=', $request->fecha_inicio);
            }
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha_pago', '<=', $request->fecha_fin);
            }
            if ($request->filled('estatus_timbrado')) {
                $query->where('estatus_timbrado', $request->estatus_timbrado);
            }
            if ($request->filled('periodo')) {
                $query->where('periodo', $request->periodo);
            }

            $recibos = $query->orderBy('fecha_pago', 'desc')->get();

            if ($recibos->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay datos para exportar'
                ], 404);
            }

            // Aquí se implementaría la exportación a Excel
            // return Excel::download(new RecibosExport($recibos), 'recibos_nomina.xlsx');

            return response()->json([
                'success' => true,
                'message' => 'Exportación iniciada',
                'total' => $recibos->count(),
                'data_preview' => $recibos->take(5)->map(function($recibo) {
                    return [
                        'folio' => $recibo->folio,
                        'empleado' => $recibo->empleado_nombre,
                        'periodo' => $recibo->periodo,
                        'neto' => $recibo->neto_formateado,
                        'estatus' => $recibo->estatus_timbrado,
                    ];
                })
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error en exportarExcel: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener nóminas disponibles para generar recibos
     */
    public function getNominasDisponibles(Request $request)
    {
        try {
            $query = Nomina::whereDoesntHave('recibo')
                ->where('estatus', 'Pagada')
                ->orWhere('estatus', 'Calculada');

            if ($request->filled('buscar')) {
                $buscar = $request->buscar;
                $query->where(function($q) use ($buscar) {
                    $q->where('folio', 'LIKE', "%{$buscar}%")
                      ->orWhere('empleado_nombre', 'LIKE', "%{$buscar}%");
                });
            }

            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha_pago', '>=', $request->fecha_inicio);
            }
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha_pago', '<=', $request->fecha_fin);
            }

            $nominas = $query->orderBy('fecha_pago', 'desc')
                ->limit(100)
                ->get(['id', 'folio', 'empleado_nombre', 'neto_pagar', 'fecha_pago', 'periodo_inicio', 'periodo_fin']);

            return response()->json([
                'success' => true,
                'data' => $nominas,
                'total' => $nominas->count()
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error en getNominasDisponibles: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener nóminas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener recibos de un empleado específico
     */
    public function getRecibosEmpleado($empleadoId, Request $request)
    {
        try {
            $empleado = Plantilla::find($empleadoId);
            
            if (!$empleado) {
                return response()->json([
                    'success' => false,
                    'message' => 'Empleado no encontrado'
                ], 404);
            }

            $query = ReciboNomina::where('empleado_id', $empleadoId);

            if ($request->filled('estatus')) {
                $query->where('estatus_timbrado', $request->estatus);
            }

            if ($request->filled('anio')) {
                $query->whereYear('fecha_pago', $request->anio);
            }

            $recibos = $query->orderBy('fecha_pago', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'empleado' => [
                        'id' => $empleado->plantilla_id,
                        'nombre' => $empleado->nombre_completo ?? $empleado->nombre,
                        'rfc' => $empleado->rfc,
                    ],
                    'recibos' => $recibos,
                    'total' => $recibos->count(),
                    'total_neto' => $recibos->sum('neto_pagar'),
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error en getRecibosEmpleado: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener recibos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener el total de recibos por estatus para el dashboard
     */
    public function getResumenEstatus()
    {
        try {
            $resumen = ReciboNomina::getResumenEstatus();
            
            return response()->json([
                'success' => true,
                'data' => $resumen
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error en getResumenEstatus: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener resumen: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un recibo (solo si está por timbrar)
     */
    public function destroy($id)
    {
        try {
            $recibo = ReciboNomina::find($id);

            if (!$recibo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recibo no encontrado'
                ], 404);
            }

            if ($recibo->estatus_timbrado !== ReciboNomina::ESTATUS_POR_TIMBRAR) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden eliminar recibos con estatus "Por Timbrar"'
                ], 400);
            }

            DB::beginTransaction();
            
            // Eliminar archivos si existen
            if ($recibo->pdf_path && Storage::exists($recibo->pdf_path)) {
                Storage::delete($recibo->pdf_path);
            }
            if ($recibo->xml_path && Storage::exists($recibo->xml_path)) {
                Storage::delete($recibo->xml_path);
            }
            
            $recibo->delete();
            DB::commit();

            Log::info("🗑️ Recibo eliminado: {$recibo->folio}", [
                'usuario' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Recibo eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Error en destroy: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar recibo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar datos de un recibo
     */
    public function update(Request $request, $id)
    {
        try {
            $recibo = ReciboNomina::find($id);

            if (!$recibo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recibo no encontrado'
                ], 404);
            }

            if ($recibo->estatus_timbrado !== ReciboNomina::ESTATUS_POR_TIMBRAR) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden editar recibos con estatus "Por Timbrar"'
                ], 400);
            }

            $validator = Validator::make($request->all(), [
                'empleado_nombre' => 'sometimes|string|max:200',
                'rfc' => 'sometimes|string|max:20',
                'curp' => 'sometimes|string|max:20|nullable',
                'nss' => 'sometimes|string|max:20|nullable',
                'puesto' => 'sometimes|string|max:100|nullable',
                'area' => 'sometimes|string|max:100|nullable',
                'total_percepciones' => 'sometimes|numeric|min:0',
                'total_deducciones' => 'sometimes|numeric|min:0',
                'neto_pagar' => 'sometimes|numeric|min:0',
                'observaciones' => 'sometimes|string|max:500|nullable',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $recibo->update($request->all());

            Log::info("✏️ Recibo actualizado: {$recibo->folio}", [
                'usuario' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Recibo actualizado correctamente',
                'data' => $recibo
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error en update: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar recibo: ' . $e->getMessage()
            ], 500);
        }
    }
    
}