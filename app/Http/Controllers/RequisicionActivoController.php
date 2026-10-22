<?php

namespace App\Http\Controllers;

use App\Models\RequisicionActivo;
use App\Models\AsignacionActivo;
use App\Models\Activo;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RequisicionActivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        $activos   = Activo::where('estatus', 'Disponible')->orderBy('codigo')->get();

        return view('almacen.movimiento.requisiciones_devoluciones_equipo', compact('proyectos', 'activos'));
    }

    /**
     * Get requisiciones for DataTable.
     */
    public function getRequisiciones(Request $request)
    {
        try {
            $query = RequisicionActivo::with(['proyecto', 'activo', 'autorizador', 'creador']);

            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }

            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }

            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha_requisicion', '>=', $request->fecha_inicio);
            }

            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha_requisicion', '<=', $request->fecha_fin);
            }

            $perPage = $request->get('per_page', 10);
            $page    = $request->get('page', 1);

            $requisiciones = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

            $data = $requisiciones->getCollection()->map(function ($req) {
                $fmtDate = fn($d, $formato = 'd/m/Y') => $d ? Carbon::parse($d)->format($formato) : null;

                return [
                    'id'                 => $req->id,
                    'folio'              => $req->folio,

                    // ⭐ TICKETS #2 y #4: IDs que el front necesita
                    'proyecto_id'        => $req->proyecto_id,
                    'activo_id'          => $req->activo_id,

                    // Fechas
                    'fecha_requisicion'  => $fmtDate($req->fecha_requisicion),
                    'fecha_requerida'    => $fmtDate($req->fecha_requerida),

                    // Relaciones (con fallback por si el registro tiene FK huérfana)
                    'proyecto_nombre'    => $req->proyecto?->nombre,
                    'proyecto_codigo'    => $req->proyecto?->codigo,
                    'activo_nombre'      => $req->activo?->nombre,
                    'activo_codigo'      => $req->activo?->codigo,
                    'unidad_medida'      => $req->activo?->unidad_medida,

                    // Datos propios
                    'cantidad'           => $req->cantidad,
                    'solicitante'        => $req->solicitante,
                    'area'               => $req->area,
                    'prioridad'          => $req->prioridad,
                    'estatus'            => $req->estatus,
                    'motivo'             => $req->motivo,
                    'observaciones'      => $req->observaciones,
                    'motivo_rechazo'     => $req->motivo_rechazo,

                    // Auditoría
                    'autorizado_por'     => $req->autorizador?->name,
                    'fecha_autorizacion' => $req->fecha_autorizacion
                                                ? Carbon::parse($req->fecha_autorizacion)->format('d/m/Y H:i')
                                                : null,
                    'created_at'         => $req->created_at
                                                ? Carbon::parse($req->created_at)->format('d/m/Y H:i')
                                                : null,
                ];
            });

            return response()->json([
                'success'      => true,
                'data'         => $data,
                'total'        => $requisiciones->total(),
                'per_page'     => $requisiciones->perPage(),
                'current_page' => $requisiciones->currentPage(),
                'last_page'    => $requisiciones->lastPage(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Error en getRequisiciones: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar requisiciones: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created requisition.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'proyecto_id'     => 'required|exists:proyectos,id',
                'activo_id'       => 'required|exists:activos,id',
                'fecha_requerida' => 'required|date',
                'solicitante'     => 'required|string|max:100',
                'prioridad'       => 'required|in:Baja,Media,Alta,Urgente',
                'motivo'          => 'required|string',
                'observaciones'   => 'nullable|string',
                'cantidad'        => 'nullable|numeric|min:1',
                'area'            => 'nullable|string|max:255',
            ]);

            DB::beginTransaction();

            $requisicion = RequisicionActivo::create([
                'folio'             => RequisicionActivo::generarFolio(),
                'proyecto_id'       => $request->proyecto_id,
                'activo_id'         => $request->activo_id,
                'cantidad'          => $request->cantidad ?? 1,
                'fecha_requisicion' => now(),
                'fecha_requerida'   => $request->fecha_requerida,
                'solicitante'       => $request->solicitante,
                'area'              => $request->area,
                'prioridad'         => $request->prioridad,
                'motivo'            => $request->motivo,
                'observaciones'     => $request->observaciones,
                'estatus'           => 'Pendiente',
                'creado_por'        => auth()->id(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Requisición creada exitosamente',
                'data'    => $requisicion->load(['proyecto', 'activo']),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error al crear requisición: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al crear requisición: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified requisition.
     */
    public function show($id)
    {
        try {
            $requisicion = RequisicionActivo::with([
                'proyecto', 'activo', 'autorizador', 'creador', 'asignacion',
            ])->find($id);

            if (!$requisicion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Requisición no encontrada.',
                ], 404);
            }

            // Helper seguro para formatear fechas
            $fmtDate = fn($d, $formato = 'Y-m-d') => $d ? Carbon::parse($d)->format($formato) : null;

            // Normalizar la relación por si Eloquent devuelve Collection en lugar de Model
            $asig = $requisicion->asignacion;
            if ($asig instanceof \Illuminate\Database\Eloquent\Collection) {
                $asig = $asig->first();
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id'                 => $requisicion->id,
                    'folio'              => $requisicion->folio,
                    'proyecto_id'        => $requisicion->proyecto_id,
                    'proyecto_nombre'    => $requisicion->proyecto?->nombre,
                    'proyecto_codigo'    => $requisicion->proyecto?->codigo,
                    'activo_id'          => $requisicion->activo_id,
                    'activo_nombre'      => $requisicion->activo?->nombre,
                    'activo_codigo'      => $requisicion->activo?->codigo,
                    'unidad_medida'      => $requisicion->activo?->unidad_medida,
                    'cantidad'           => $requisicion->cantidad,
                    'fecha_requisicion'  => $fmtDate($requisicion->fecha_requisicion),
                    'fecha_requerida'    => $fmtDate($requisicion->fecha_requerida),
                    'solicitante'        => $requisicion->solicitante,
                    'area'               => $requisicion->area,
                    'prioridad'          => $requisicion->prioridad,
                    'motivo'             => $requisicion->motivo,
                    'observaciones'      => $requisicion->observaciones,
                    'estatus'            => $requisicion->estatus,
                    'motivo_rechazo'     => $requisicion->motivo_rechazo,
                    'autorizado_por'     => $requisicion->autorizador?->name,
                    'fecha_autorizacion' => $fmtDate($requisicion->fecha_autorizacion, 'd/m/Y H:i'),

                    'asignacion' => $asig ? [
                        'id'                       => $asig->id,
                        'fecha_salida'             => $fmtDate($asig->fecha_salida, 'd/m/Y'),
                        'responsable_asignado'     => $asig->responsable_asignado,
                        'condicion_salida'         => $asig->condicion_salida,
                        'horometro_salida'         => $asig->horometro_salida,
                        'kilometraje_salida'       => $asig->kilometraje_salida,
                        'observaciones_salida'     => $asig->observaciones_salida,
                        'fecha_devolucion'         => $fmtDate($asig->fecha_devolucion_real, 'd/m/Y'),
                        'condicion_devolucion'     => $asig->condicion_devolucion,
                        'horometro_devolucion'     => $asig->horometro_devolucion,
                        'kilometraje_devolucion'   => $asig->kilometraje_devolucion,
                        'reporte_danos'            => $asig->reporte_danos,
                        'costo_reparacion'         => $asig->costo_reparacion,
                        'observaciones_devolucion' => $asig->observaciones_devolucion,
                        'estatus'                  => $asig->estatus,
                    ] : null,
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Error en RequisicionActivoController@show: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar la requisición: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Authorize requisition.
     */
    public function autorizar(Request $request, $id)
    {
        try {
            $requisicion = RequisicionActivo::findOrFail($id);

            if ($requisicion->estatus !== 'Pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'La requisición no está en estado Pendiente',
                ], 400);
            }

            DB::beginTransaction();

            $requisicion->update([
                'estatus'            => 'Aprobada',
                'autorizado_por'     => auth()->id(),
                'fecha_autorizacion' => now(),
                'observaciones'      => $request->observaciones,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Requisición autorizada exitosamente',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error al autorizar requisición: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al autorizar requisición: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Reject requisition.
     */
    public function rechazar(Request $request, $id)
    {
        try {
            $request->validate([
                'motivo' => 'required|string|min:5',
            ]);

            $requisicion = RequisicionActivo::findOrFail($id);

            if ($requisicion->estatus !== 'Pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'La requisición no está en estado Pendiente',
                ], 400);
            }

            DB::beginTransaction();

            $requisicion->update([
                'estatus'            => 'Rechazada',
                'autorizado_por'     => auth()->id(),
                'fecha_autorizacion' => now(),
                'motivo_rechazo'     => $request->motivo,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Requisición rechazada exitosamente',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error al rechazar requisición: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al rechazar requisición: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete requisition.
     */
    public function destroy($id)
    {
        try {
            $requisicion = RequisicionActivo::findOrFail($id);

            if ($requisicion->estatus !== 'Pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden eliminar requisiciones en estado Pendiente',
                ], 400);
            }

            $requisicion->delete();

            return response()->json([
                'success' => true,
                'message' => 'Requisición eliminada exitosamente',
            ]);
        } catch (\Throwable $e) {
            Log::error('Error al eliminar requisición: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar requisición: ' . $e->getMessage(),
            ], 500);
        }
    }
}