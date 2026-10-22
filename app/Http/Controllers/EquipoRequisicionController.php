<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Activo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class EquipoRequisicionController extends Controller
{
    /**
     * Vista principal
     */
    public function index()
    {
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        $activos   = Activo::orderBy('codigo')->get();

        return view('almacen.movimiento.requisiciones_devoluciones_equipo', compact('proyectos', 'activos'));
    }

    /* =========================================================
     *  TICKET #1 — PERSONAS DEL PROYECTO
     *  Devuelve usuarios del sistema + personal asignado al
     *  proyecto (vía asignaciones_personal → plantillas).
     * ========================================================= */
    public function personasProyecto($proyectoId)
    {
        try {
            // ============================================================
            // 1) USUARIOS DEL SISTEMA
            // ============================================================
            $usuarios = DB::table('users')
                ->select('users.id', 'users.name', 'users.email', DB::raw('NULL as area'))
                ->orderBy('users.name')
                ->get()
                ->map(fn($u) => [
                    'id'     => 'u_' . $u->id,
                    'tipo'   => 'usuario',
                    'nombre' => $u->name,
                    'area'   => null,
                    'email'  => $u->email,
                ]);

            // ============================================================
            // 2) PERSONAL ASIGNADO AL PROYECTO
            //    asignaciones_personal.empleado_id -> plantillas.plantilla_id
            // ============================================================
            $plantillaCols = Schema::hasTable('plantillas')
                ? Schema::getColumnListing('plantillas')
                : [];

            // Detectar columnas de nombre
            $nombreExpr = null;
            if (in_array('nombre_completo', $plantillaCols)) {
                $nombreExpr = 'plantillas.nombre_completo';
            } elseif (in_array('nombre', $plantillaCols)) {
                $partes = ['plantillas.nombre'];
                if (in_array('apellido_paterno', $plantillaCols)) {
                    $partes[] = "COALESCE(plantillas.apellido_paterno, '')";
                }
                if (in_array('apellido_materno', $plantillaCols)) {
                    $partes[] = "COALESCE(plantillas.apellido_materno, '')";
                }
                $nombreExpr = 'TRIM(CONCAT(' . implode(", ' ', ", $partes) . '))';
            }

            // Puesto en plantillas
            $puestoCol = null;
            foreach (['puesto', 'puesto_nombre', 'cargo'] as $cp) {
                if (in_array($cp, $plantillaCols)) { $puestoCol = $cp; break; }
            }

            // Área en plantillas
            $areaColDirecta = null;
            foreach (['area', 'area_nombre'] as $ca) {
                if (in_array($ca, $plantillaCols)) { $areaColDirecta = $ca; break; }
            }
            $areaFk = null;
            foreach (['area_id', 'id_area'] as $fa) {
                if (in_array($fa, $plantillaCols)) { $areaFk = $fa; break; }
            }

            $personal = collect();

            if ($nombreExpr && Schema::hasTable('asignaciones_personal')) {
                $q = DB::table('asignaciones_personal')
                    ->where('asignaciones_personal.proyecto_id', $proyectoId)
                    ->whereNull('asignaciones_personal.deleted_at')
                    ->leftJoin('plantillas', 'plantillas.plantilla_id', '=', 'asignaciones_personal.empleado_id')
                    ->select(
                        'asignaciones_personal.id',
                        DB::raw("{$nombreExpr} as nombre"),
                        'asignaciones_personal.rol as puesto_rol'
                    );

                // Puesto desde plantillas (si existe)
                if ($puestoCol) {
                    $q->addSelect("plantillas.{$puestoCol} as puesto_plantilla");
                } else {
                    $q->addSelect(DB::raw('NULL as puesto_plantilla'));
                }

                // Área
                if ($areaColDirecta) {
                    $q->addSelect("plantillas.{$areaColDirecta} as area");
                } elseif ($areaFk && Schema::hasTable('areas')) {
                    $areaCols = Schema::getColumnListing('areas');
                    $areaName = in_array('nombre', $areaCols) ? 'nombre'
                              : (in_array('name', $areaCols) ? 'name' : null);
                    if ($areaName) {
                        $q->leftJoin('areas', 'areas.id', '=', "plantillas.{$areaFk}")
                          ->addSelect("areas.{$areaName} as area");
                    } else {
                        $q->addSelect(DB::raw('NULL as area'));
                    }
                } else {
                    $q->addSelect(DB::raw('NULL as area'));
                }

                $personal = $q->orderBy('nombre')->get()
                    ->filter(fn($p) => !empty($p->nombre))
                    ->map(fn($p) => [
                        'id'     => 'p_' . $p->id,
                        'tipo'   => 'personal',
                        'nombre' => $p->nombre,
                        'area'   => $p->area ?? null,
                        'puesto' => $p->puesto_plantilla ?? $p->puesto_rol ?? null,
                    ])
                    ->values();
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'usuarios' => $usuarios,
                    'personal' => $personal,
                    '_debug'   => [
                        'total_personal'  => $personal->count(),
                        'plantillas_cols' => $plantillaCols,
                    ],
                ],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar personas: ' . $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ], 500);
        }
    }

    /* =========================================================
     *  LISTADOS (paginados)
     * ========================================================= */

    public function listarRequisiciones(Request $request)
    {
        $query = DB::table('requisiciones_activos')
            ->leftJoin('proyectos', 'proyectos.id', '=', 'requisiciones_activos.proyecto_id')
            ->leftJoin('activos',   'activos.id',   '=', 'requisiciones_activos.activo_id')
            ->select([
                'requisiciones_activos.*',
                'proyectos.codigo as proyecto_codigo',
                'proyectos.nombre as proyecto_nombre',
                'activos.codigo   as activo_codigo',
                'activos.nombre   as activo_nombre',
                'activos.unidad_medida as unidad_medida',
            ]);

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('requisiciones_activos.fecha_requisicion', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('requisiciones_activos.fecha_requisicion', '<=', $request->fecha_fin);
        }
        if ($request->filled('proyecto_id')) {
            $query->where('requisiciones_activos.proyecto_id', $request->proyecto_id);
        }
        if ($request->filled('estatus')) {
            $query->where('requisiciones_activos.estatus', $request->estatus);
        }

        $perPage = (int) $request->get('per_page', 10);
        $page    = (int) $request->get('page', 1);

        $paginado = $query->orderByDesc('requisiciones_activos.id')->paginate($perPage, ['*'], 'page', $page);

        // Formatear fechas y normalizar datos
        $paginado->getCollection()->transform(function ($r) {
            $r->fecha_requisicion = $r->fecha_requisicion
                ? Carbon::parse($r->fecha_requisicion)->format('d/m/Y') : null;
            $r->fecha_requerida = $r->fecha_requerida
                ? Carbon::parse($r->fecha_requerida)->format('d/m/Y') : null;
            return $r;
        });

        return response()->json([
            'success'      => true,
            'data'         => $paginado->items(),
            'current_page' => $paginado->currentPage(),
            'last_page'    => $paginado->lastPage(),
            'total'        => $paginado->total(),
        ]);
    }

    public function listarDevoluciones(Request $request)
    {
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
                'activos.unidad_medida as unidad_medida',
            ]);

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('asignaciones_activos.fecha_salida', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('asignaciones_activos.fecha_salida', '<=', $request->fecha_fin);
        }
        if ($request->filled('proyecto_id')) {
            $query->where('requisiciones_activos.proyecto_id', $request->proyecto_id);
        }
        if ($request->filled('estatus')) {
            $query->where('asignaciones_activos.estatus', $request->estatus);
        }

        $perPage = (int) $request->get('per_page', 10);
        $page    = (int) $request->get('page', 1);

        $paginado = $query->orderByDesc('asignaciones_activos.id')->paginate($perPage, ['*'], 'page', $page);

        $paginado->getCollection()->transform(function ($d) {
            $d->fecha_salida     = $d->fecha_salida
                ? Carbon::parse($d->fecha_salida)->format('d/m/Y') : null;
            $d->fecha_devolucion = $d->fecha_devolucion_real
                ? Carbon::parse($d->fecha_devolucion_real)->format('d/m/Y') : null;
            $d->valor_salida     = $d->horometro_salida ?? $d->kilometraje_salida;
            return $d;
        });

        return response()->json([
            'success'      => true,
            'data'         => $paginado->items(),
            'current_page' => $paginado->currentPage(),
            'last_page'    => $paginado->lastPage(),
            'total'        => $paginado->total(),
        ]);
    }

    /* =========================================================
     *  REQUISICIONES — CRUD
     * ========================================================= */

    public function guardarRequisicion(Request $request)
    {
        $data = $request->validate([
            'proyecto_id'     => 'required|exists:proyectos,id',
            'activo_id'       => 'required|exists:activos,id',
            'fecha_requerida' => 'required|date',
            'cantidad'        => 'nullable|numeric|min:1',
            'solicitante'     => 'required|string|max:255',
            'area'            => 'nullable|string|max:255',
            'prioridad'       => 'required|in:Baja,Media,Alta,Urgente',
            'motivo'          => 'required|string',
            'observaciones'   => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $data['folio']             = $this->generarFolioRequisicion();
            $data['fecha_requisicion'] = now()->toDateString();
            $data['estatus']           = 'Pendiente';
            $data['creado_por']        = Auth::id();
            $data['cantidad']          = $data['cantidad'] ?? 1;

            $id = DB::table('requisiciones_activos')->insertGetId($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Requisición {$data['folio']} creada correctamente.",
                'data'    => array_merge(['id' => $id], $data),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la requisición: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * TICKET #2 — Detalle de requisición con asignación.
     */
    public function verRequisicion($id)
    {
        $requisicion = DB::table('requisiciones_activos')
            ->leftJoin('proyectos', 'proyectos.id', '=', 'requisiciones_activos.proyecto_id')
            ->leftJoin('activos',   'activos.id',   '=', 'requisiciones_activos.activo_id')
            ->select([
                'requisiciones_activos.*',
                'proyectos.codigo as proyecto_codigo',
                'proyectos.nombre as proyecto_nombre',
                'activos.codigo   as activo_codigo',
                'activos.nombre   as activo_nombre',
                'activos.unidad_medida as unidad_medida',
            ])
            ->where('requisiciones_activos.id', $id)
            ->first();

        if (!$requisicion) {
            return response()->json([
                'success' => false,
                'message' => 'Requisición no encontrada.',
            ], 404);
        }

        // Asignación más reciente (puede no existir)
        $asignacion = DB::table('asignaciones_activos')
            ->where('requisicion_id', $id)
            ->orderByDesc('id')
            ->first();

        $requisicion->asignacion = $asignacion;

        return response()->json([
            'success' => true,
            'data'    => $requisicion,
        ]);
    }

    public function autorizarRequisicion(Request $request, $id)
    {
        $req = DB::table('requisiciones_activos')->where('id', $id)->first();
        if (!$req) {
            return response()->json(['success' => false, 'message' => 'Requisición no encontrada.'], 404);
        }
        if ($req->estatus !== 'Pendiente') {
            return response()->json(['success' => false, 'message' => 'Solo se pueden autorizar requisiciones pendientes.'], 422);
        }

        $obs = trim(($req->observaciones ?? '') . "\n[Autorizada] " . ($request->observaciones ?? ''));

        DB::table('requisiciones_activos')->where('id', $id)->update([
            'estatus'            => 'Aprobada',
            'observaciones'      => $obs,
            'fecha_autorizacion' => now(),
            'autorizado_por'     => Auth::id(),
            'updated_at'         => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Requisición {$req->folio} autorizada correctamente.",
        ]);
    }

    public function rechazarRequisicion(Request $request, $id)
    {
        $request->validate(['motivo' => 'required|string']);

        $req = DB::table('requisiciones_activos')->where('id', $id)->first();
        if (!$req) {
            return response()->json(['success' => false, 'message' => 'Requisición no encontrada.'], 404);
        }
        if ($req->estatus !== 'Pendiente') {
            return response()->json(['success' => false, 'message' => 'Solo se pueden rechazar requisiciones pendientes.'], 422);
        }

        DB::table('requisiciones_activos')->where('id', $id)->update([
            'estatus'        => 'Rechazada',
            'motivo_rechazo' => $request->motivo,
            'fecha_autorizacion' => now(),
            'autorizado_por' => Auth::id(),
            'updated_at'     => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Requisición {$req->folio} rechazada.",
        ]);
    }

    /* =========================================================
     *  SALIDAS / DEVOLUCIONES
     * ========================================================= */

    public function registrarSalida(Request $request)
    {
        $data = $request->validate([
            'requisicion_id'       => 'required|exists:requisiciones_activos,id',
            'responsable_asignado' => 'required|string|max:255',
            'fecha_salida'         => 'required|date',
            'condicion_salida'     => 'required|in:Excelente,Bueno,Regular,Malo',
            'horometro_salida'     => 'nullable|numeric',
            'kilometraje_salida'   => 'nullable|numeric',
            'observaciones_salida' => 'nullable|string',
        ]);

        $req = DB::table('requisiciones_activos')->where('id', $data['requisicion_id'])->first();
        if (!$req) {
            return response()->json(['success' => false, 'message' => 'Requisición no encontrada.'], 404);
        }
        if ($req->estatus !== 'Aprobada') {
            return response()->json(['success' => false, 'message' => 'Solo se puede dar salida a requisiciones aprobadas.'], 422);
        }

        DB::beginTransaction();
        try {
            // Insertar la asignación (salida)
            $salidaId = DB::table('asignaciones_activos')->insertGetId([
                'requisicion_id'       => $req->id,
                'activo_id'            => $req->activo_id,
                'proyecto_id'          => $req->proyecto_id,
                'responsable_asignado' => $data['responsable_asignado'],
                'fecha_salida'         => $data['fecha_salida'],
                'condicion_salida'     => $data['condicion_salida'],
                'horometro_salida'     => $data['horometro_salida'] ?? null,
                'kilometraje_salida'   => $data['kilometraje_salida'] ?? null,
                'observaciones_salida' => $data['observaciones_salida'] ?? null,
                'estatus'              => 'Activa',
                'created_at'           => now(),
                'updated_at'           => now(),
            ]);

            // Actualizar la requisición
            DB::table('requisiciones_activos')
                ->where('id', $req->id)
                ->update(['estatus' => 'Asignada', 'updated_at' => now()]);

            // Actualizar estatus del activo (si aplica la columna)
            if (Schema::hasColumn('activos', 'estatus')) {
                DB::table('activos')->where('id', $req->activo_id)->update([
                    'estatus'    => 'Asignado',
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Salida registrada correctamente.',
                'data'    => ['id' => $salidaId],
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la salida: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * TICKET #3 — Detalle de devolución.
     */
    public function verDevolucion($id)
    {
        $dev = DB::table('asignaciones_activos')
            ->leftJoin('requisiciones_activos', 'requisiciones_activos.id', '=', 'asignaciones_activos.requisicion_id')
            ->leftJoin('proyectos', 'proyectos.id', '=', 'requisiciones_activos.proyecto_id')
            ->leftJoin('activos',   'activos.id',   '=', 'requisiciones_activos.activo_id')
            ->select([
                'asignaciones_activos.*',
                'requisiciones_activos.folio as folio_requisicion',
                'requisiciones_activos.motivo as motivo_requisicion',
                'proyectos.nombre as proyecto_nombre',
                'activos.codigo   as activo_codigo',
                'activos.nombre   as activo_nombre',
                'activos.unidad_medida as unidad_medida',
            ])
            ->where('asignaciones_activos.id', $id)
            ->first();

        if (!$dev) {
            return response()->json([
                'success' => false,
                'message' => 'Devolución no encontrada.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $dev,
        ]);
    }

    public function registrarDevolucion(Request $request, $id)
    {
        $data = $request->validate([
            'fecha_devolucion'         => 'required|date',
            'condicion_devolucion'     => 'required|in:Excelente,Bueno,Regular,Malo,Danado',
            'horometro_devolucion'     => 'nullable|numeric',
            'kilometraje_devolucion'   => 'nullable|numeric',
            'reporte_danos'            => 'nullable|string',
            'costo_reparacion'         => 'nullable|numeric',
            'observaciones_devolucion' => 'nullable|string',
        ]);

        $dev = DB::table('asignaciones_activos')->where('id', $id)->first();
        if (!$dev) {
            return response()->json(['success' => false, 'message' => 'Devolución no encontrada.'], 404);
        }
        if ($dev->estatus !== 'Activa') {
            return response()->json(['success' => false, 'message' => 'Esta asignación ya fue devuelta.'], 422);
        }
        if ($data['condicion_devolucion'] === 'Danado' && empty($data['reporte_danos'])) {
            return response()->json(['success' => false, 'message' => 'Debe describir los daños.'], 422);
        }

        DB::beginTransaction();
        try {
            DB::table('asignaciones_activos')->where('id', $id)->update([
                'fecha_devolucion_real'    => $data['fecha_devolucion'],
                'condicion_devolucion'     => $data['condicion_devolucion'],
                'horometro_devolucion'     => $data['horometro_devolucion'] ?? null,
                'kilometraje_devolucion'   => $data['kilometraje_devolucion'] ?? null,
                'reporte_danos'            => $data['reporte_danos'] ?? null,
                'costo_reparacion'         => $data['costo_reparacion'] ?? null,
                'observaciones_devolucion' => $data['observaciones_devolucion'] ?? null,
                'recibido_por'             => Auth::id(),
                'estatus'                  => 'Devuelta',
                'updated_at'               => now(),
            ]);

            DB::table('requisiciones_activos')
                ->where('id', $dev->requisicion_id)
                ->update(['estatus' => 'Devuelta', 'updated_at' => now()]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Devolución registrada correctamente.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la devolución: ' . $e->getMessage(),
            ], 500);
        }
    }

    /* =========================================================
     *  Helpers
     * ========================================================= */
    private function generarFolioRequisicion(): string
    {
        $prefix = 'REQ-' . now()->format('Ymd') . '-';
        $ultimo = DB::table('requisiciones_activos')
            ->where('folio', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('folio');
        $sec = $ultimo ? ((int) substr($ultimo, -4)) + 1 : 1;
        return $prefix . str_pad($sec, 4, '0', STR_PAD_LEFT);
    }
}