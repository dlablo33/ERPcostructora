<?php

namespace App\Http\Controllers;

use App\Models\BitacoraEntry;
use App\Models\BitacoraIncidencia;
use App\Models\EvidenciaFotografica;
use App\Models\ComentarioBitacora;
use App\Models\ReporteGenerado;
use App\Models\Proyecto;
use App\Models\User;
use App\Models\Plantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class BitacoraController extends Controller
{
    /* =========================================================
     |  VISTA PRINCIPAL
     | ========================================================= */

    public function index()
    {
        $proyectos = Proyecto::where('status', 'activo')
            ->orderBy('codigo')
            ->get(['id', 'codigo', 'nombre'])
            ->map(fn($p) => ['id' => $p->codigo, 'nombre' => $p->nombre])
            ->toArray();

        if (empty($proyectos)) {
            $proyectos = [
                ['id' => 'PRO-2024-001', 'nombre' => 'Torre Norte Corporativa'],
                ['id' => 'PRO-2024-002', 'nombre' => 'Puente Vehicular Sur'],
                ['id' => 'PRO-2024-003', 'nombre' => 'Parque Industrial Norte'],
            ];
        }

        $resumen = [
            'total'       => BitacoraEntry::count(),
            'actividades' => BitacoraEntry::where('tipo', 'actividad')->count(),
            'incidencias' => BitacoraEntry::where('tipo', 'incidencia')->count(),
            'pendientes'  => BitacoraEntry::where('estado', 'pendiente')->count(),
        ];

        return view('proyectos.gestion.bitacora', compact('proyectos', 'resumen'));
    }

    /* =========================================================
     |  LISTADO DE ENTRADAS
     | ========================================================= */

    public function getEntries(Request $request)
    {
        try {
            $query = BitacoraEntry::with([
                'creador:id,name,email',
                'responsableUser:id,name,email',
                'incidencia',
                'comentarios.usuario:id,name',
                'evidencias',
            ])
            ->withCount(['comentarios', 'evidencias']);

            if ($request->filled('proyecto_id'))   $query->where('proyecto_id', $request->proyecto_id);
            if ($request->filled('tipo'))          $query->where('tipo', $request->tipo);
            if ($request->filled('estado'))        $query->where('estado', $request->estado);
            if ($request->filled('responsable'))   $query->where('responsable', 'LIKE', '%'.$request->responsable.'%');

            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            }

            if ($request->filled('search')) {
                $s = $request->search;
                $query->where(function ($q) use ($s) {
                    $q->where('titulo', 'LIKE', "%$s%")
                      ->orWhere('descripcion', 'LIKE', "%$s%")
                      ->orWhere('responsable', 'LIKE', "%$s%");
                });
            }

            $perPage = (int) $request->get('per_page', 10);
            $entries = $query->orderBy('fecha', 'desc')
                             ->orderBy('hora', 'desc')
                             ->paginate($perPage);

            // ✨ Transformar cada entry para exponer campos que el frontend necesita
            $items = collect($entries->items())->map(function ($e) {
                $arr = $e->toArray();

                $inc = $e->incidencia;
                $incPrincipal = null;

                if ($inc instanceof \Illuminate\Support\Collection) {
                    // Si la relación devuelve colección, tomar la primera (o la abierta si hay varias)
                    $incPrincipal = $inc->firstWhere('resuelta_en', null) ?? $inc->first();
                } elseif (is_array($inc)) {
                    $incPrincipal = null;
                    foreach ($inc as $i) {
                        if (empty($i['resuelta_en'])) { $incPrincipal = (object) $i; break; }
                    }
                    $incPrincipal = $incPrincipal ?? (isset($inc[0]) ? (object) $inc[0] : null);
                } elseif (is_object($inc)) {
                    $incPrincipal = $inc;
                }

                // ✨ Campos explícitos para el frontend
                $arr['incidencia_id']        = $incPrincipal->id ?? null;
                $arr['incidencia_abierta']   = $incPrincipal ? empty($incPrincipal->resuelta_en) : false;
                $arr['incidencia_principal'] = $incPrincipal;

                return $arr;
            });

            return response()->json([
                'success'      => true,
                'data'         => $items,
                'total'        => $entries->total(),
                'current_page' => $entries->currentPage(),
                'last_page'    => $entries->lastPage(),
                'per_page'     => $entries->perPage(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Bitacora::getEntries -> '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las entradas: '.$e->getMessage(),
            ], 500);
        }
    }

    /* =========================================================
     |  MOSTRAR UNA ENTRADA
     | ========================================================= */

    public function show($id)
    {
        try {
            $entry = BitacoraEntry::with([
                'creador:id,name,email',
                'responsableUser:id,name,email',
                'incidencia',
                'comentarios.usuario:id,name',
                'evidencias',
            ])->findOrFail($id);

            $data = $entry->toArray();
            $inc = $entry->incidencia;

            if ($inc instanceof \Illuminate\Support\Collection) {
                $data['incidencia'] = $inc->values()->toArray();
            } elseif (is_object($inc)) {
                $data['incidencia'] = [$inc->toArray()];
            } else {
                $data['incidencia'] = [];
            }

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Entrada no encontrada'], 404);
        }
    }

    /* =========================================================
     |  CREAR ENTRADA
     | ========================================================= */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'proyecto_id'    => 'required|string|max:50',
            'tipo'           => 'required|in:actividad,incidencia,acuerdo,nota',
            'titulo'         => 'required|string|max:255',
            'descripcion'    => 'required|string',
            'fecha'          => 'required|date',
            'hora'           => 'required',
            'responsable_id' => 'nullable|exists:users,id',
            'responsable'    => 'nullable|string|max:100',
            'personal'       => 'nullable|string',
            'maquinaria'     => 'nullable|string',
            'materiales'     => 'nullable|string',
            'imagenes'       => 'nullable|array',
            'imagenes.*'     => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $hora = substr($request->hora, 0, 5);

        $responsableNombre = $request->responsable;
        if ($request->filled('responsable_id')) {
            $u = User::find($request->responsable_id);
            if ($u) $responsableNombre = $u->name;
        }

        try {
            $entry = DB::transaction(function () use ($request, $hora, $responsableNombre) {

                $entry = BitacoraEntry::create([
                    'proyecto_id'    => $request->proyecto_id,
                    'tipo'           => $request->tipo,
                    'titulo'         => $request->titulo,
                    'descripcion'    => $request->descripcion,
                    'fecha'          => $request->fecha,
                    'hora'           => $hora,
                    'responsable'    => $responsableNombre,
                    'responsable_id' => $request->responsable_id,
                    'personal'       => $request->personal,
                    'maquinaria'     => $request->maquinaria,
                    'materiales'     => $request->materiales,
                    'estado'         => $request->tipo === 'incidencia' ? 'pendiente' : 'completado',
                    'created_by'     => auth()->id(),
                ]);

                if ($request->tipo === 'incidencia') {
                    BitacoraIncidencia::create([
                        'bitacora_entry_id' => $entry->id,
                        'tipo_incidencia'   => $request->input('tipo_incidencia', 'otros'),
                        'prioridad'         => $request->input('prioridad', 'media'),
                        'accion_tomada'     => $request->input('accion_tomada'),
                    ]);
                }

                if ($request->hasFile('imagenes')) {
                    foreach ($request->file('imagenes') as $img) {
                        $path = $img->store('evidencias/'.date('Y/m/d'), 'public');
                        EvidenciaFotografica::create([
                            'bitacora_entry_id' => $entry->id,
                            'ruta'              => $path,
                            'nombre_original'   => $img->getClientOriginalName(),
                            'mime_type'         => $img->getMimeType(),
                            'size'              => $img->getSize(),
                        ]);
                    }
                }

                return $entry;
            });

            return response()->json([
                'success' => true,
                'message' => 'Entrada creada exitosamente',
                'data'    => $entry->load(['creador:id,name', 'responsableUser:id,name', 'incidencia', 'evidencias']),
            ]);
        } catch (\Throwable $e) {
            Log::error('Bitacora::store -> '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la entrada: '.$e->getMessage(),
            ], 500);
        }
    }

    /* =========================================================
     |  ACTUALIZAR ENTRADA
     | ========================================================= */

    public function update(Request $request, $id)
    {
        $entry = BitacoraEntry::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'titulo'         => 'sometimes|string|max:255',
            'descripcion'    => 'sometimes|string',
            'estado'         => 'sometimes|in:pendiente,en_proceso,completado,cerrado',
            'responsable_id' => 'nullable|exists:users,id',
            'personal'       => 'nullable|string',
            'maquinaria'     => 'nullable|string',
            'materiales'     => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $data = $request->only(['titulo', 'descripcion', 'estado', 'personal', 'maquinaria', 'materiales']);

            if ($request->filled('responsable_id')) {
                $data['responsable_id'] = $request->responsable_id;
                $data['responsable']    = optional(User::find($request->responsable_id))->name;
            }

            $entry->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Entrada actualizada',
                'data'    => $entry->fresh(['creador:id,name', 'responsableUser:id,name', 'incidencia', 'evidencias']),
            ]);
        } catch (\Throwable $e) {
            Log::error('Bitacora::update -> '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al actualizar: '.$e->getMessage()], 500);
        }
    }

    /* =========================================================
     |  ELIMINAR ENTRADA (con cascada)
     | ========================================================= */

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $entry = BitacoraEntry::with(['evidencias', 'incidencia'])->findOrFail($id);

                foreach ($entry->evidencias as $ev) {
                    if ($ev->ruta && Storage::disk('public')->exists($ev->ruta)) {
                        Storage::disk('public')->delete($ev->ruta);
                    }
                }

                $entry->incidencia()->get()->each(fn($inc) => $inc->delete());
                $entry->comentarios()->get()->each(fn($c) => $c->delete());
                $entry->evidencias()->get()->each(fn($ev) => $ev->delete());
                $entry->delete();
            });

            return response()->json(['success' => true, 'message' => 'Entrada eliminada']);
        } catch (\Throwable $e) {
            Log::error('Bitacora::destroy -> '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Error al eliminar: '.$e->getMessage()], 500);
        }
    }

    /* =========================================================
     |  COMENTARIOS
     | ========================================================= */

    public function addComment(Request $request, $entryId)
    {
        $validator = Validator::make($request->all(), [
            'comentario' => 'required|string|min:1|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            BitacoraEntry::findOrFail($entryId);

            $c = ComentarioBitacora::create([
                'bitacora_entry_id' => $entryId,
                'user_id'           => auth()->id(),
                'comentario'        => $request->comentario,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Comentario agregado',
                'data'    => $c->load('usuario:id,name'),
            ]);
        } catch (\Throwable $e) {
            Log::error('Bitacora::addComment -> '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al agregar comentario: '.$e->getMessage()], 500);
        }
    }

    public function deleteComment($id)
    {
        try {
            $c = ComentarioBitacora::findOrFail($id);
            if ((int) $c->user_id !== (int) auth()->id() && !auth()->user()?->hasRole('admin')) {
                return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
            }
            $c->delete();
            return response()->json(['success' => true, 'message' => 'Comentario eliminado']);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar comentario'], 500);
        }
    }

    /* =========================================================
     |  INCIDENCIAS
     | ========================================================= */

    public function getIncidencias(Request $request)
    {
        try {
            $query = BitacoraIncidencia::with([
                'bitacoraEntry:id,proyecto_id,titulo,responsable,created_by,estado,fecha,hora',
                'bitacoraEntry.creador:id,name',
            ]);

            if ($request->filled('proyecto_id')) {
                $query->whereHas('bitacoraEntry', fn($q) => $q->where('proyecto_id', $request->proyecto_id));
            }
            if ($request->filled('prioridad'))       $query->where('prioridad', $request->prioridad);
            if ($request->filled('tipo_incidencia')) $query->where('tipo_incidencia', $request->tipo_incidencia);
            if ($request->filled('entry_id'))        $query->where('bitacora_entry_id', $request->entry_id);

            if ($request->filled('estado')) {
                if ($request->estado === 'resuelta') {
                    $query->whereNotNull('resuelta_en');
                } else {
                    $query->whereNull('resuelta_en');
                }
            }

            $inc = $query->orderByDesc('created_at')->paginate(15);

            return response()->json([
                'success'      => true,
                'data'         => $inc->items(),
                'total'        => $inc->total(),
                'current_page' => $inc->currentPage(),
                'last_page'    => $inc->lastPage(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Bitacora::getIncidencias -> '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al obtener incidencias: '.$e->getMessage()], 500);
        }
    }

    public function getIncidencia($id)
    {
        try {
            $inc = BitacoraIncidencia::with(['bitacoraEntry.creador:id,name', 'bitacoraEntry.evidencias'])->findOrFail($id);
            return response()->json(['success' => true, 'data' => $inc]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Incidencia no encontrada'], 404);
        }
    }

    /**
     * Resolver incidencia
     * Acepta POST o PUT. Busca por id de incidencia o por id de entry (fallback).
     */
    public function resolveIncidencia(Request $request, $id)
    {
        Log::info('=== resolveIncidencia START ===', [
            'id'            => $id,
            'http_method'   => $request->method(),
            'accion_tomada' => $request->input('accion_tomada'),
            'has_files'     => $request->hasFile('evidencias'),
        ]);

        // 1. Validar
        $validator = Validator::make($request->all(), [
            'accion_tomada' => 'required|string|min:5',
            'evidencias'    => 'nullable|array',
            'evidencias.*'  => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        if ($validator->fails()) {
            Log::warning('resolveIncidencia VALIDACIÓN FALLÓ', [
                'errors' => $validator->errors()->toArray(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // 2. Ejecutar transacción
        try {
            $resultado = DB::transaction(function () use ($request, $id) {

                // Buscar por id de incidencia
                $inc = BitacoraIncidencia::with('bitacoraEntry')->find($id);

                // Fallback: buscar por bitacora_entry_id
                if (!$inc) {
                    Log::info("resolveIncidencia: no se encontró incidencia con id $id, buscando por entry_id");
                    $inc = BitacoraIncidencia::with('bitacoraEntry')
                        ->where('bitacora_entry_id', $id)
                        ->latest()
                        ->first();
                }

                if (!$inc) {
                    throw new \RuntimeException('Incidencia no encontrada (id: '.$id.')');
                }

                if ($inc->resuelta_en) {
                    throw new \RuntimeException('La incidencia ya estaba resuelta (resuelta_en: '.$inc->resuelta_en.')');
                }

                // Actualizar incidencia
                $inc->accion_tomada = $request->accion_tomada;
                $inc->resuelta_en   = now();
                $inc->save();

                Log::info("resolveIncidencia: incidencia {$inc->id} actualizada", [
                    'resuelta_en' => $inc->resuelta_en,
                ]);

                // Guardar evidencias si las hay
                if ($request->hasFile('evidencias')) {
                    foreach ($request->file('evidencias') as $img) {
                        $path = $img->store('evidencias/'.date('Y/m/d'), 'public');
                        EvidenciaFotografica::create([
                            'bitacora_entry_id' => $inc->bitacora_entry_id,
                            'ruta'              => $path,
                            'nombre_original'   => $img->getClientOriginalName(),
                            'mime_type'         => $img->getMimeType(),
                            'size'              => $img->getSize(),
                            'descripcion'       => 'Evidencia de resolución de incidencia',
                        ]);
                    }
                }

                // Actualizar estado del entry a completado
                if ($inc->bitacoraEntry) {
                    $inc->bitacoraEntry->estado = 'completado';
                    $inc->bitacoraEntry->save();
                    Log::info("resolveIncidencia: entry {$inc->bitacoraEntry->id} marcado como completado");
                }

                return $inc->fresh(['bitacoraEntry.evidencias']);
            });

            return response()->json([
                'success' => true,
                'message' => 'Incidencia resuelta correctamente',
                'data'    => $resultado,
            ]);

        } catch (\Throwable $e) {
            Log::error('Bitacora::resolveIncidencia -> '.$e->getMessage(), [
                'id'    => $id,
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al resolver la incidencia: '.$e->getMessage(),
            ], 500);
        }
    }

    public function updatePrioridad(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'prioridad' => 'required|in:baja,media,alta,critica',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $inc = BitacoraIncidencia::findOrFail($id);
            $inc->update(['prioridad' => $request->prioridad]);
            return response()->json(['success' => true, 'message' => 'Prioridad actualizada']);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar prioridad'], 500);
        }
    }

    /* =========================================================
     |  EVIDENCIAS
     | ========================================================= */

    public function uploadImage(Request $request, $entryId)
    {
        $validator = Validator::make($request->all(), [
            'imagen'      => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'descripcion' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            BitacoraEntry::findOrFail($entryId);

            $file = $request->file('imagen');
            $path = $file->store('evidencias/'.date('Y/m/d'), 'public');

            $ev = EvidenciaFotografica::create([
                'bitacora_entry_id' => $entryId,
                'ruta'              => $path,
                'nombre_original'   => $file->getClientOriginalName(),
                'mime_type'         => $file->getMimeType(),
                'size'              => $file->getSize(),
                'descripcion'       => $request->descripcion,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Imagen subida',
                'data'    => array_merge($ev->toArray(), ['url' => Storage::url($path)]),
            ]);
        } catch (\Throwable $e) {
            Log::error('Bitacora::uploadImage -> '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al subir imagen: '.$e->getMessage()], 500);
        }
    }

    public function deleteImage($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $ev = EvidenciaFotografica::findOrFail($id);
                if ($ev->ruta && Storage::disk('public')->exists($ev->ruta)) {
                    Storage::disk('public')->delete($ev->ruta);
                }
                $ev->delete();
            });
            return response()->json(['success' => true, 'message' => 'Imagen eliminada']);
        } catch (\Throwable $e) {
            Log::error('Bitacora::deleteImage -> '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al eliminar imagen'], 500);
        }
    }

    public function getEvidencias(Request $request)
    {
        try {
            $query = EvidenciaFotografica::with('bitacoraEntry:id,proyecto_id,titulo');

            if ($request->filled('proyecto_id')) {
                $query->whereHas('bitacoraEntry', fn($q) => $q->where('proyecto_id', $request->proyecto_id));
            }
            if ($request->filled('entry_id')) {
                $query->where('bitacora_entry_id', $request->entry_id);
            }

            $ev = $query->orderByDesc('created_at')->paginate(20);

            $items = collect($ev->items())->map(function ($e) {
                $e->url = Storage::url($e->ruta);
                return $e;
            });

            return response()->json([
                'success'      => true,
                'data'         => $items,
                'total'        => $ev->total(),
                'current_page' => $ev->currentPage(),
                'last_page'    => $ev->lastPage(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Bitacora::getEvidencias -> '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al obtener evidencias'], 500);
        }
    }

    /* =========================================================
     |  ESTADÍSTICAS
     | ========================================================= */

    public function getEstadisticas(Request $request)
    {
        try {
            $q = BitacoraEntry::query();

            if ($request->filled('proyecto_id')) $q->where('proyecto_id', $request->proyecto_id);
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $q->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            }

            $data = [
                'total'       => (clone $q)->count(),
                'actividades' => (clone $q)->where('tipo', 'actividad')->count(),
                'incidencias' => (clone $q)->where('tipo', 'incidencia')->count(),
                'acuerdos'    => (clone $q)->where('tipo', 'acuerdo')->count(),
                'notas'       => (clone $q)->where('tipo', 'nota')->count(),
                'pendientes'  => (clone $q)->where('estado', 'pendiente')->count(),
                'en_proceso'  => (clone $q)->where('estado', 'en_proceso')->count(),
                'completados' => (clone $q)->where('estado', 'completado')->count(),
                'por_tipo'    => (clone $q)->select('tipo', DB::raw('count(*) as total'))->groupBy('tipo')->get(),
                'por_estado'  => (clone $q)->select('estado', DB::raw('count(*) as total'))->groupBy('estado')->get(),
                'por_proyecto'=> (clone $q)->select('proyecto_id', DB::raw('count(*) as total'))->groupBy('proyecto_id')->limit(10)->get(),
            ];

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Throwable $e) {
            Log::error('Bitacora::getEstadisticas -> '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al obtener estadísticas'], 500);
        }
    }

    public function getStats(Request $request)
    {
        try {
            $q = BitacoraEntry::query();

            if ($request->filled('proyecto_id')) $q->where('proyecto_id', $request->proyecto_id);
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $q->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'total'       => (clone $q)->count(),
                    'actividades' => (clone $q)->where('tipo', 'actividad')->count(),
                    'incidencias' => (clone $q)->where('tipo', 'incidencia')->count(),
                    'pendientes'  => (clone $q)->where('estado', 'pendiente')->count(),
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Bitacora::getStats -> '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al obtener stats'], 500);
        }
    }

    /* =========================================================
     |  REPORTES
     | ========================================================= */

    public function getReportes(Request $request)
    {
        try {
            $q = ReporteGenerado::with(['generador:id,name', 'proyecto:id,codigo,nombre']);

            if ($request->filled('proyecto_id')) $q->where('proyecto_id', $request->proyecto_id);
            if ($request->filled('tipo'))        $q->where('tipo', $request->tipo);

            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $q->whereBetween('created_at', [
                    $request->fecha_inicio.' 00:00:00',
                    $request->fecha_fin.' 23:59:59',
                ]);
            }

            $r = $q->orderByDesc('created_at')->paginate(15);

            return response()->json([
                'success'      => true,
                'data'         => $r->items(),
                'total'        => $r->total(),
                'current_page' => $r->currentPage(),
                'last_page'    => $r->lastPage(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('Bitacora::getReportes falló, devolviendo vacío: '.$e->getMessage());

            return response()->json([
                'success'      => true,
                'data'         => [],
                'total'        => 0,
                'current_page' => 1,
                'last_page'    => 1,
                'warning'      => 'No se pudo consultar la tabla de reportes: '.$e->getMessage(),
            ]);
        }
    }

    public function getResumenReporte(Request $request)
    {
        $resumen = [
            'total_entradas'        => 0,
            'total_actividades'     => 0,
            'total_incidencias'     => 0,
            'incidencias_abiertas'  => 0,
            'incidencias_resueltas' => 0,
            'total_comentarios'     => 0,
            'total_imagenes'        => 0,
            'reportes_generados'    => 0,
            'por_tipo'              => [],
            'por_proyecto'          => [],
        ];

        try {
            $q = BitacoraEntry::query();
            if ($request->filled('proyecto_id')) {
                $q->where('proyecto_id', $request->proyecto_id);
            }
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $q->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            }

            try { $resumen['total_entradas']    = (clone $q)->count(); } catch (\Throwable $e) {}
            try { $resumen['total_actividades'] = (clone $q)->where('tipo', 'actividad')->count(); } catch (\Throwable $e) {}
            try { $resumen['total_incidencias'] = (clone $q)->where('tipo', 'incidencia')->count(); } catch (\Throwable $e) {}
            try { $resumen['por_tipo']          = (clone $q)->select('tipo', DB::raw('count(*) as total'))->groupBy('tipo')->get()->toArray(); } catch (\Throwable $e) {}
            try { $resumen['por_proyecto']      = (clone $q)->select('proyecto_id', DB::raw('count(*) as total'))->groupBy('proyecto_id')->get()->toArray(); } catch (\Throwable $e) {}

            try { $resumen['incidencias_abiertas']  = BitacoraIncidencia::whereNull('resuelta_en')->count(); } catch (\Throwable $e) {}
            try { $resumen['incidencias_resueltas'] = BitacoraIncidencia::whereNotNull('resuelta_en')->count(); } catch (\Throwable $e) {}
            try { $resumen['total_comentarios']     = ComentarioBitacora::count(); } catch (\Throwable $e) {}
            try { $resumen['total_imagenes']        = EvidenciaFotografica::count(); } catch (\Throwable $e) {}
            try { $resumen['reportes_generados']    = ReporteGenerado::count(); } catch (\Throwable $e) {
                $resumen['reportes_generados'] = 0;
            }

            return response()->json(['success' => true, 'data' => $resumen]);
        } catch (\Throwable $e) {
            Log::error('Bitacora::getResumenReporte -> '.$e->getMessage());
            return response()->json(['success' => true, 'data' => $resumen]);
        }
    }

    public function generarReporte(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo_reporte' => 'required|in:diario,semanal,mensual,personalizado',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'proyecto_id'  => 'nullable|string',
            'titulo'       => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $reporte = ReporteGenerado::create([
                'titulo'       => $request->titulo ?? ('Reporte '.ucfirst($request->tipo_reporte).' - '.now()->format('d/m/Y H:i')),
                'tipo'         => $request->tipo_reporte,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin'    => $request->fecha_fin,
                'proyecto_id'  => $request->proyecto_id,
                'generado_por' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reporte generado',
                'data'    => $reporte->load('generador:id,name'),
            ]);
        } catch (\Throwable $e) {
            Log::error('Bitacora::generarReporte -> '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar reporte: '.$e->getMessage(),
            ], 500);
        }
    }

    /* =========================================================
     |  EXPORTAR / IMPRIMIR
     | ========================================================= */

    public function exportPDF(Request $request)
    {
        try {
            $q = BitacoraEntry::with(['creador:id,name', 'incidencia']);

            if ($request->filled('proyecto_id')) $q->where('proyecto_id', $request->proyecto_id);
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $q->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            }

            $entries = $q->orderByDesc('fecha')->orderByDesc('hora')->get();

            try {
                ReporteGenerado::create([
                    'titulo'       => 'Reporte Bitácora - '.now()->format('d/m/Y H:i'),
                    'tipo'         => 'personalizado',
                    'fecha_inicio' => $request->fecha_inicio ?? now()->startOfMonth(),
                    'fecha_fin'    => $request->fecha_fin ?? now()->endOfMonth(),
                    'proyecto_id'  => $request->proyecto_id,
                    'generado_por' => auth()->id(),
                ]);
            } catch (\Throwable $e) {
                Log::warning('No se pudo registrar el reporte generado: '.$e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Reporte generado',
                'data'    => [
                    'total_registros' => $entries->count(),
                    'entries'         => $entries,
                    'print_url'       => route('bitacora.print', $request->only(['proyecto_id', 'fecha_inicio', 'fecha_fin'])),
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Bitacora::exportPDF -> '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al generar reporte: '.$e->getMessage()], 500);
        }
    }

    public function printView(Request $request)
    {
        $q = BitacoraEntry::with(['creador:id,name', 'incidencia']);

        if ($request->filled('proyecto_id')) $q->where('proyecto_id', $request->proyecto_id);
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $q->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
        }

        $entries = $q->orderByDesc('fecha')->orderByDesc('hora')->get();

        return view('proyectos.gestion.bitacora_print', compact('entries'));
    }

    /* =========================================================
     |  CATÁLOGOS (proyectos y responsables)
     | ========================================================= */

    public function getProyectosList()
    {
        return response()->json(['success' => true, 'data' => $this->getProyectos()]);
    }

    private function getProyectos(): array
    {
        try {
            $p = Proyecto::where('status', 'activo')->orderBy('codigo')->get(['codigo', 'nombre']);
            if ($p->isNotEmpty()) {
                return $p->map(fn($x) => ['id' => $x->codigo, 'nombre' => $x->nombre])->toArray();
            }
        } catch (\Throwable $e) {
            Log::warning('Bitacora::getProyectos -> '.$e->getMessage());
        }

        return [
            ['id' => 'PRO-2024-001', 'nombre' => 'Torre Norte Corporativa'],
            ['id' => 'PRO-2024-002', 'nombre' => 'Puente Vehicular Sur'],
        ];
    }

    public function getResponsablesList()
    {
        try {
            $usuarios = User::query()
                ->orderBy('name')
                ->get(['id', 'name', 'email'])
                ->map(fn($u) => [
                    'id'     => $u->id,
                    'nombre' => $u->name,
                    'email'  => $u->email,
                    'tipo'   => 'usuario',
                ]);

            $empleados = collect();
            try {
                $empleados = Plantilla::query()
                    ->where('estatus', 'Activo')
                    ->orderBy('nombre')
                    ->get()
                    ->map(function ($e) {
                        $nombre = trim(($e->nombre ?? '').' '.($e->apellido_paterno ?? '').' '.($e->apellido_materno ?? ''));
                        return [
                            'id'     => 'EMP-'.$e->plantilla_id,
                            'nombre' => $nombre,
                            'email'  => null,
                            'tipo'   => 'empleado',
                        ];
                    });
            } catch (\Throwable $e) {
                // Si no existe el modelo o tabla, se ignora
            }

            $data = $usuarios->concat($empleados)->values();

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Throwable $e) {
            Log::error('Bitacora::getResponsablesList -> '.$e->getMessage());
            return response()->json(['success' => false, 'data' => [], 'message' => 'Error al obtener responsables'], 500);
        }
    }
}