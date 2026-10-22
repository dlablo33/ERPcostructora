<?php

namespace App\Http\Controllers;

use App\Models\AsignacionActivo;
use App\Models\RequisicionActivo;
use App\Models\Activo;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DevolucionActivoController extends Controller
{
    /**
     * Display a listing of the resource (vista dedicada, si la usas).
     */
    public function index()
    {
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        $asignaciones = AsignacionActivo::with(['activo', 'proyecto', 'requisicion'])
            ->where('estatus', 'Activa')
            ->get();

        return view('activos.devoluciones', compact('proyectos', 'asignaciones'));
    }

    /* =========================================================
     *  LISTADO DE DEVOLUCIONES / ASIGNACIONES
     * ========================================================= */
    public function getDevoluciones(Request $request)
{
    try {
        $query = DB::table('asignaciones_activos')
            ->leftJoin('requisiciones_activos', 'requisiciones_activos.id', '=', 'asignaciones_activos.requisicion_id')
            ->leftJoin('proyectos', 'proyectos.id', '=', 'requisiciones_activos.proyecto_id')
            ->leftJoin('activos',   'activos.id',   '=', 'requisiciones_activos.activo_id')
            ->select([
                'asignaciones_activos.*',
                'requisiciones_activos.folio as folio_requisicion',
                'proyectos.nombre as proyecto_nombre',
                'activos.codigo   as activo_codigo',
                'activos.nombre   as activo_nombre',
                'activos.tipo_activo as tipo_activo',
            ]);

        if ($request->filled('proyecto_id')) {
            $query->where('requisiciones_activos.proyecto_id', $request->proyecto_id);
        }
        if ($request->filled('estatus')) {
            $query->where('asignaciones_activos.estatus', $request->estatus);
        }
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('asignaciones_activos.fecha_salida', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('asignaciones_activos.fecha_salida', '<=', $request->fecha_fin);
        }

        $perPage = (int) $request->get('per_page', 10);
        $page    = (int) $request->get('page', 1);

        $paginado = $query->orderByDesc('asignaciones_activos.id')
            ->paginate($perPage, ['*'], 'page', $page);

        $data = $paginado->getCollection()->map(function ($d) {
            // Unidad SOLO por tipo_activo (ya no depende de columna inexistente)
            $medida = $d->tipo_activo === 'maquinaria' ? 'Horas'
                    : ($d->tipo_activo === 'vehiculo' ? 'Km' : null);

            $valorSalida = $d->tipo_activo === 'maquinaria'
                ? $d->horometro_salida
                : ($d->tipo_activo === 'vehiculo'
                    ? $d->kilometraje_salida
                    : ($d->horometro_salida ?? $d->kilometraje_salida));

            $valorDevolucion = $d->tipo_activo === 'maquinaria'
                ? $d->horometro_devolucion
                : ($d->tipo_activo === 'vehiculo'
                    ? $d->kilometraje_devolucion
                    : ($d->horometro_devolucion ?? $d->kilometraje_devolucion));

            $diferencia = ($valorDevolucion !== null && $valorSalida !== null)
                ? $valorDevolucion - $valorSalida
                : null;

            return [
                'id'                   => $d->id,
                'folio_requisicion'    => $d->folio_requisicion,
                'fecha_salida'         => $d->fecha_salida
                                            ? Carbon::parse($d->fecha_salida)->format('d/m/Y')
                                            : null,
                'fecha_devolucion'     => $d->fecha_devolucion_real
                                            ? Carbon::parse($d->fecha_devolucion_real)->format('d/m/Y')
                                            : null,
                'proyecto_nombre'      => $d->proyecto_nombre,
                'responsable_asignado' => $d->responsable_asignado,
                'activo_nombre'        => $d->activo_nombre,
                'activo_codigo'        => $d->activo_codigo,
                'valor_salida'         => $valorSalida,
                'valor_devolucion'     => $valorDevolucion,
                'diferencia'           => $diferencia,
                'unidad_medida'        => $medida,
                'condicion_salida'     => $d->condicion_salida,
                'condicion_devolucion' => $d->condicion_devolucion,
                'reporte_danos'        => $d->reporte_danos,
                'estatus'              => $d->estatus,
                'recibido_por'         => $d->recibido_por,
            ];
        });

        return response()->json([
            'success'      => true,
            'data'         => $data,
            'total'        => $paginado->total(),
            'per_page'     => $paginado->perPage(),
            'current_page' => $paginado->currentPage(),
            'last_page'    => $paginado->lastPage(),
        ]);
    } catch (\Throwable $e) {
        Log::error('Error en getDevoluciones: ' . $e->getMessage());
        Log::error($e->getTraceAsString());

        return response()->json([
            'success' => false,
            'message' => 'Error al cargar devoluciones: ' . $e->getMessage(),
        ], 500);
    }
}

    /* =========================================================
     *  TICKET #3 — DETALLE DE ASIGNACIÓN / DEVOLUCIÓN
     *  Este es el método que consume el modal "Ver detalle".
     * ========================================================= */
    public function show($id)
{
    try {
        $dev = DB::table('asignaciones_activos')
            ->leftJoin('requisiciones_activos', 'requisiciones_activos.id', '=', 'asignaciones_activos.requisicion_id')
            ->leftJoin('proyectos', 'proyectos.id', '=', 'requisiciones_activos.proyecto_id')
            ->leftJoin('activos',   'activos.id',   '=', 'requisiciones_activos.activo_id')
            ->select([
                'asignaciones_activos.*',
                'requisiciones_activos.folio as folio_requisicion',
                'requisiciones_activos.motivo as motivo_requisicion',
                'requisiciones_activos.proyecto_id as proyecto_id',
                'requisiciones_activos.activo_id as activo_id',
                'proyectos.nombre as proyecto_nombre',
                'activos.codigo   as activo_codigo',
                'activos.nombre   as activo_nombre',
                'activos.tipo_activo as tipo_activo',
                // ⚠️ NO incluir activos.unidad_medida (no existe en la tabla)
            ])
            ->where('asignaciones_activos.id', $id)
            ->first();

        if (!$dev) {
            return response()->json([
                'success' => false,
                'message' => 'Devolución no encontrada.',
            ], 404);
        }

        // ✅ Unidad SOLO según tipo_activo
        $medida = $dev->tipo_activo === 'maquinaria' ? 'Horas'
                : ($dev->tipo_activo === 'vehiculo' ? 'Km' : null);

        $valorSalida = $dev->tipo_activo === 'maquinaria'
            ? $dev->horometro_salida
            : ($dev->tipo_activo === 'vehiculo'
                ? $dev->kilometraje_salida
                : ($dev->horometro_salida ?? $dev->kilometraje_salida));

        $valorDevolucion = $dev->tipo_activo === 'maquinaria'
            ? $dev->horometro_devolucion
            : ($dev->tipo_activo === 'vehiculo'
                ? $dev->kilometraje_devolucion
                : ($dev->horometro_devolucion ?? $dev->kilometraje_devolucion));

        return response()->json([
            'success' => true,
            'data' => [
                'id'                       => $dev->id,
                'folio_requisicion'        => $dev->folio_requisicion,
                'motivo_requisicion'       => $dev->motivo_requisicion,
                'proyecto_id'              => $dev->proyecto_id,
                'proyecto_nombre'          => $dev->proyecto_nombre,
                'activo_id'                => $dev->activo_id,
                'activo_nombre'            => $dev->activo_nombre,
                'activo_codigo'            => $dev->activo_codigo,
                'unidad_medida'            => $medida,

                // Salida
                'fecha_salida'             => $dev->fecha_salida
                                                ? Carbon::parse($dev->fecha_salida)->format('d/m/Y')
                                                : null,
                'responsable_asignado'     => $dev->responsable_asignado,
                'condicion_salida'         => $dev->condicion_salida,
                'horometro_salida'         => $dev->horometro_salida,
                'kilometraje_salida'       => $dev->kilometraje_salida,
                'observaciones_salida'     => $dev->observaciones_salida,
                'valor_salida'             => $valorSalida,

                // Devolución
                'fecha_devolucion'         => $dev->fecha_devolucion_real
                                                ? Carbon::parse($dev->fecha_devolucion_real)->format('d/m/Y')
                                                : null,
                'condicion_devolucion'     => $dev->condicion_devolucion,
                'horometro_devolucion'     => $dev->horometro_devolucion,
                'kilometraje_devolucion'   => $dev->kilometraje_devolucion,
                'reporte_danos'            => $dev->reporte_danos,
                'costo_reparacion'         => $dev->costo_reparacion,
                'observaciones_devolucion' => $dev->observaciones_devolucion,
                'valor_devolucion'         => $valorDevolucion,

                // Estatus
                'estatus'                  => $dev->estatus,
                'recibido_por'             => $dev->recibido_por,
            ],
        ]);
    } catch (\Throwable $e) {
        Log::error('Error en DevolucionActivoController@show: ' . $e->getMessage());
        Log::error($e->getTraceAsString());

        return response()->json([
            'success' => false,
            'message' => 'Error al cargar detalle: ' . $e->getMessage(),
        ], 500);
    }
}

    /* =========================================================
     *  REGISTRAR SALIDA (ASIGNACIÓN)
     * ========================================================= */
    public function registrarSalida(Request $request)
    {
        try {
            $request->validate([
                'requisicion_id'       => 'required|exists:requisiciones_activos,id',
                'responsable_asignado' => 'required|string|max:255',
                'fecha_salida'         => 'required|date',
                'condicion_salida'     => 'required|in:Excelente,Bueno,Regular,Malo',
                'horometro_salida'     => 'nullable|numeric|min:0',
                'kilometraje_salida'   => 'nullable|numeric|min:0',
                'observaciones_salida' => 'nullable|string',
            ]);

            DB::beginTransaction();

            $requisicion = DB::table('requisiciones_activos')
                ->where('id', $request->requisicion_id)
                ->first();

            if (!$requisicion) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Requisición no encontrada.',
                ], 404);
            }

            if ($requisicion->estatus !== 'Aprobada') {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'La requisición debe estar Aprobada para registrar salida.',
                ], 400);
            }

            // Crear asignación (salida)
            $asignacionId = DB::table('asignaciones_activos')->insertGetId([
                'requisicion_id'       => $requisicion->id,
                'activo_id'            => $requisicion->activo_id,
                'proyecto_id'          => $requisicion->proyecto_id,
                'responsable_asignado' => $request->responsable_asignado,
                'fecha_salida'         => $request->fecha_salida,
                'horometro_salida'     => $request->horometro_salida ?? null,
                'kilometraje_salida'   => $request->kilometraje_salida ?? null,
                'condicion_salida'     => $request->condicion_salida,
                'observaciones_salida' => $request->observaciones_salida ?? null,
                'estatus'              => 'Activa',
                'created_at'           => now(),
                'updated_at'           => now(),
            ]);

            // Actualizar estatus de la requisición
            DB::table('requisiciones_activos')
                ->where('id', $requisicion->id)
                ->update(['estatus' => 'Asignada', 'updated_at' => now()]);

            // Actualizar estatus del activo (si esas columnas existen)
            $activoUpdate = ['estatus' => 'Asignado', 'updated_at' => now()];
            if (Schema::hasColumn('activos', 'proyecto_asignado_id')) {
                $activoUpdate['proyecto_asignado_id'] = $requisicion->proyecto_id;
            }
            if (Schema::hasColumn('activos', 'fecha_asignacion')) {
                $activoUpdate['fecha_asignacion'] = now();
            }
            DB::table('activos')->where('id', $requisicion->activo_id)->update($activoUpdate);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Salida registrada exitosamente.',
                'data'    => ['id' => $asignacionId],
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error al registrar salida: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error al registrar salida: ' . $e->getMessage(),
            ], 500);
        }
    }

    /* =========================================================
     *  REGISTRAR DEVOLUCIÓN
     * ========================================================= */
    public function registrarDevolucion(Request $request, $id)
    {
        try {
            $request->validate([
                'fecha_devolucion'         => 'required|date',
                'condicion_devolucion'     => 'required|in:Excelente,Bueno,Regular,Malo,Danado',
                'horometro_devolucion'     => 'nullable|numeric|min:0',
                'kilometraje_devolucion'   => 'nullable|numeric|min:0',
                'reporte_danos'            => 'required_if:condicion_devolucion,Danado|nullable|string',
                'costo_reparacion'         => 'nullable|numeric|min:0',
                'observaciones_devolucion' => 'nullable|string',
            ]);

            DB::beginTransaction();

            $asignacion = DB::table('asignaciones_activos')->where('id', $id)->first();

            if (!$asignacion) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Asignación no encontrada.',
                ], 404);
            }

            if ($asignacion->estatus !== 'Activa') {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'La asignación no está activa.',
                ], 400);
            }

            // Actualizar la asignación con datos de devolución
            DB::table('asignaciones_activos')->where('id', $id)->update([
                'fecha_devolucion_real'    => $request->fecha_devolucion,
                'condicion_devolucion'     => $request->condicion_devolucion,
                'horometro_devolucion'     => $request->horometro_devolucion ?? null,
                'kilometraje_devolucion'   => $request->kilometraje_devolucion ?? null,
                'observaciones_devolucion' => $request->observaciones_devolucion ?? null,
                'reporte_danos'            => $request->reporte_danos ?? null,
                'costo_reparacion'         => $request->costo_reparacion ?? null,
                'recibido_por'             => Auth::id(),
                'estatus'                  => 'Devuelta',
                'updated_at'               => now(),
            ]);

            // Actualizar la requisición
            DB::table('requisiciones_activos')
                ->where('id', $asignacion->requisicion_id)
                ->update(['estatus' => 'Devuelta', 'updated_at' => now()]);

            // Liberar el activo
            if (Schema::hasColumn('activos', 'estatus')) {
                $activoUpdate = ['estatus' => 'Disponible', 'updated_at' => now()];
                if (Schema::hasColumn('activos', 'proyecto_asignado_id')) {
                    $activoUpdate['proyecto_asignado_id'] = null;
                }
                if (Schema::hasColumn('activos', 'fecha_asignacion')) {
                    $activoUpdate['fecha_asignacion'] = null;
                }
                DB::table('activos')->where('id', $asignacion->activo_id)->update($activoUpdate);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Devolución registrada exitosamente.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error al registrar devolución: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error al registrar devolución: ' . $e->getMessage(),
            ], 500);
        }
    }

    /* =========================================================
     *  ASIGNACIONES ACTIVAS
     * ========================================================= */
    public function getAsignacionesActivas(Request $request)
    {
        try {
            $query = DB::table('asignaciones_activos')
                ->leftJoin('requisiciones_activos', 'requisiciones_activos.id', '=', 'asignaciones_activos.requisicion_id')
                ->leftJoin('proyectos', 'proyectos.id', '=', 'requisiciones_activos.proyecto_id')
                ->leftJoin('activos',   'activos.id',   '=', 'requisiciones_activos.activo_id')
                ->where('asignaciones_activos.estatus', 'Activa')
                ->select([
                    'asignaciones_activos.id',
                    'asignaciones_activos.responsable_asignado',
                    'asignaciones_activos.fecha_salida',
                    'requisiciones_activos.folio as folio_requisicion',
                    'proyectos.nombre as proyecto_nombre',
                    'activos.nombre as activo_nombre',
                    'activos.codigo as activo_codigo',
                ]);

            if ($request->filled('proyecto_id')) {
                $query->where('requisiciones_activos.proyecto_id', $request->proyecto_id);
            }

            $asignaciones = $query->orderByDesc('asignaciones_activos.id')->get();

            $data = $asignaciones->map(function ($a) {
                $fecha = $a->fecha_salida ? Carbon::parse($a->fecha_salida) : null;

                return [
                    'id'                    => $a->id,
                    'folio_requisicion'     => $a->folio_requisicion,
                    'proyecto_nombre'       => $a->proyecto_nombre,
                    'activo_nombre'         => $a->activo_nombre,
                    'activo_codigo'         => $a->activo_codigo,
                    'responsable_asignado'  => $a->responsable_asignado,
                    'fecha_salida'          => $fecha ? $fecha->format('d/m/Y') : null,
                    'dias_transcurridos'    => $fecha ? $fecha->diffInDays(now()) : null,
                ];
            });

            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error en getAsignacionesActivas: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar asignaciones: ' . $e->getMessage(),
            ], 500);
        }
    }
}