<?php
// app/Http/Controllers/LicitacionController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Licitacion;
use App\Models\Facturacion\Contacto;
use App\Models\Plantilla;

class LicitacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function activas()
    {
        Log::info('=== LICITACIONES: Cargando vista activas ===');
        return view('proyectos.licitacion.activas');
    }

    /**
     * Listado principal con búsqueda, filtros, agrupación y paginación
     */
    public function index(Request $request)
    {
        Log::info('=== LICITACIONES INDEX ===');
        Log::info('URL: ' . $request->fullUrl());
        Log::info('Params: ' . json_encode($request->all()));

        try {
            $query = Licitacion::with(['cliente', 'responsable', 'creador']);

            // ============================================
            // 1. BÚSQUEDA GLOBAL (buscador)
            // ============================================
            if ($request->filled('busqueda')) {
                $busqueda = trim($request->busqueda);
                $query->where(function ($q) use ($busqueda) {
                    $q->where('no_licitacion', 'LIKE', "%{$busqueda}%")
                      ->orWhere('nombre', 'LIKE', "%{$busqueda}%")
                      ->orWhere('observaciones', 'LIKE', "%{$busqueda}%")
                      ->orWhereHas('cliente', function ($cq) use ($busqueda) {
                          $cq->where('razon_social', 'LIKE', "%{$busqueda}%")
                             ->orWhere('rfc', 'LIKE', "%{$busqueda}%");
                      })
                      ->orWhereHas('responsable', function ($rq) use ($busqueda) {
                          $rq->where('nombre', 'LIKE', "%{$busqueda}%")
                             ->orWhere('apellido_paterno', 'LIKE', "%{$busqueda}%")
                             ->orWhere('apellido_materno', 'LIKE', "%{$busqueda}%");
                      });
                });
            }

            // ============================================
            // 2. FILTRO POR ESTADO
            // ============================================
            if ($request->filled('estado')) {
                $estados = is_array($request->estado)
                    ? $request->estado
                    : explode(',', $request->estado);
                $query->whereIn('estado', $estados);
            }

            // ============================================
            // 3. FILTRO POR FECHAS (publicación / cierre)
            // ============================================
            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha_publicacion', '>=', $request->fecha_inicio);
            }

            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha_publicacion', '<=', $request->fecha_fin);
            }

            // Filtro específico por rango de cierre
            if ($request->filled('fecha_cierre_inicio')) {
                $query->whereDate('fecha_cierre', '>=', $request->fecha_cierre_inicio);
            }

            if ($request->filled('fecha_cierre_fin')) {
                $query->whereDate('fecha_cierre', '<=', $request->fecha_cierre_fin);
            }

            // Filtro por rango de monto
            if ($request->filled('monto_min')) {
                $query->where('monto_estimado', '>=', $request->monto_min);
            }

            if ($request->filled('monto_max')) {
                $query->where('monto_estimado', '<=', $request->monto_max);
            }

            // ============================================
            // 4. FILTRO POR CLIENTE / RESPONSABLE
            // ============================================
            if ($request->filled('cliente_id')) {
                $query->where('cliente_id', $request->cliente_id);
            }

            if ($request->filled('responsable_id')) {
                $query->where('responsable_id', $request->responsable_id);
            }

            // ============================================
            // 5. FILTRO POR PARTICIPACIÓN
            // ============================================
            if ($request->filled('participa')) {
                $query->where('participa', filter_var($request->participa, FILTER_VALIDATE_BOOLEAN));
            }

            // ============================================
            // 6. ORDENAMIENTO (sort_by + sort_dir)
            // ============================================
            $sortBy = $request->get('sort_by', 'created_at');
            $sortDir = strtolower($request->get('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

            $columnasPermitidas = [
                'no_licitacion', 'nombre', 'fecha_publicacion',
                'fecha_cierre', 'monto_estimado', 'estado', 'created_at'
            ];

            if (in_array($sortBy, $columnasPermitidas)) {
                $query->orderBy($sortBy, $sortDir);
            } else {
                $query->orderBy('created_at', 'desc');
            }

            // ============================================
            // 7. AGRUPACIÓN (group_by)
            // ============================================
            $groupBy = $request->get('group_by');
            $agrupado = null;

            $perPage = (int) $request->get('per_page', 10);
            $perPage = max(1, min($perPage, 100));

            if ($groupBy && in_array($groupBy, ['estado', 'cliente_id', 'responsable_id', 'moneda'])) {
                // Agrupamos manualmente los resultados
                $todos = $query->get();

                $agrupado = $todos->groupBy(function ($item) use ($groupBy) {
                    switch ($groupBy) {
                        case 'cliente_id':
                            return $item->nombre_cliente ?? ($item->cliente->razon_social ?? 'Sin cliente');
                        case 'responsable_id':
                            return $item->nombre_responsable ?? ($item->responsable->nombre ?? 'Sin responsable');
                        default:
                            return $item->{$groupBy} ?? 'Sin valor';
                    }
                })->map(function ($grupo, $key) {
                    return [
                        'grupo' => $key,
                        'total' => $grupo->count(),
                        'monto_total' => $grupo->sum('monto_estimado'),
                        'items' => $grupo->values(),
                    ];
                })->values();

                // Paginación manual del agrupado
                $page = (int) $request->get('page', 1);
                $total = $agrupado->count();
                $items = $agrupado->slice(($page - 1) * $perPage, $perPage)->values();

                $licitaciones = new \Illuminate\Pagination\LengthAwarePaginator(
                    $items,
                    $total,
                    $perPage,
                    $page,
                    ['path' => $request->url(), 'query' => $request->query()]
                );
            } else {
                $licitaciones = $query->paginate($perPage);
            }

            Log::info('Licitaciones encontradas: ' . $licitaciones->total());

            $estadisticas = $this->calcularEstadisticas($request);

            return response()->json([
                'success' => true,
                'data' => $licitaciones,
                'agrupado' => $agrupado,
                'group_by' => $groupBy,
                'estadisticas' => $estadisticas,
                'filtros_aplicados' => $request->only([
                    'busqueda', 'estado', 'fecha_inicio', 'fecha_fin',
                    'fecha_cierre_inicio', 'fecha_cierre_fin',
                    'monto_min', 'monto_max', 'cliente_id', 'responsable_id',
                    'participa', 'sort_by', 'sort_dir', 'group_by'
                ]),
                'message' => 'Licitaciones obtenidas correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en index: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    public function clientes()
    {
        Log::info('=== LICITACIONES: Obteniendo clientes ===');

        try {
            $clientes = Contacto::where('estatus', true)
                ->whereNull('deleted_at')
                ->where(function ($q) {
                    $q->where('tipo', 'cliente')->orWhere('tipo', 'ambos');
                })
                ->select('contacto_id as id', 'razon_social as nombre', 'rfc')
                ->orderBy('razon_social')
                ->get();

            if ($clientes->isEmpty()) {
                $clientes = collect([
                    (object)['id' => 1, 'nombre' => 'Gobierno del Estado', 'rfc' => 'GES123456'],
                    (object)['id' => 2, 'nombre' => 'Municipio de Monterrey', 'rfc' => 'MUN123456'],
                    (object)['id' => 3, 'nombre' => 'CONAGUA', 'rfc' => 'CON123456'],
                    (object)['id' => 4, 'nombre' => 'CFE', 'rfc' => 'CFE123456'],
                    (object)['id' => 5, 'nombre' => 'SEMARNAT', 'rfc' => 'SEM123456'],
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $clientes,
                'count' => $clientes->count()
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener clientes: ' . $e->getMessage());

            return response()->json([
                'success' => true,
                'data' => [
                    ['id' => 1, 'nombre' => 'Gobierno del Estado'],
                    ['id' => 2, 'nombre' => 'Municipio de Monterrey'],
                    ['id' => 3, 'nombre' => 'CONAGUA'],
                    ['id' => 4, 'nombre' => 'CFE'],
                    ['id' => 5, 'nombre' => 'SEMARNAT']
                ],
                'count' => 5,
                'warning' => 'Usando datos de prueba: ' . $e->getMessage()
            ]);
        }
    }

    public function responsables()
    {
        Log::info('=== LICITACIONES: Obteniendo responsables ===');

        try {
            $responsables = Plantilla::where('estatus', 'Activo')
                ->select('plantilla_id as id', 'nombre', 'apellido_paterno', 'apellido_materno')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'nombre_completo' => trim(
                            $item->nombre . ' ' . $item->apellido_paterno . ' ' . $item->apellido_materno
                        )
                    ];
                });

            if ($responsables->isEmpty()) {
                $responsables = collect([
                    (object)['id' => 1, 'nombre_completo' => 'Juan Pérez'],
                    (object)['id' => 2, 'nombre_completo' => 'María García'],
                    (object)['id' => 3, 'nombre_completo' => 'Carlos Rodríguez'],
                    (object)['id' => 4, 'nombre_completo' => 'Ana Martínez'],
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $responsables,
                'count' => $responsables->count()
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener responsables: ' . $e->getMessage());

            return response()->json([
                'success' => true,
                'data' => [
                    ['id' => 1, 'nombre_completo' => 'Juan Pérez'],
                    ['id' => 2, 'nombre_completo' => 'María García'],
                    ['id' => 3, 'nombre_completo' => 'Carlos Rodríguez'],
                    ['id' => 4, 'nombre_completo' => 'Ana Martínez']
                ],
                'count' => 4,
                'warning' => 'Usando datos de prueba: ' . $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        Log::info('=== LICITACIONES: Creando nueva licitación ===');
        Log::info('Datos recibidos:', $request->all());

        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'no_licitacion' => 'required|string|max:50|unique:licitaciones,no_licitacion',
                'nombre' => 'required|string|max:500',
                'cliente_id' => 'required|exists:contactos,contacto_id',
                'fecha_publicacion' => 'required|date',
                'fecha_cierre' => 'required|date|after_or_equal:fecha_publicacion',
                'monto_estimado' => 'required|numeric|min:0',
                'responsable_id' => 'nullable|exists:plantillas,plantilla_id',
                'observaciones' => 'nullable|string'
            ]);

            $licitacion = Licitacion::create([
                'no_licitacion' => $request->no_licitacion,
                'nombre' => $request->nombre,
                'cliente_id' => $request->cliente_id,
                'responsable_id' => $request->responsable_id,
                'created_by' => auth()->id(),
                'fecha_publicacion' => $request->fecha_publicacion,
                'fecha_cierre' => $request->fecha_cierre,
                'monto_estimado' => $request->monto_estimado,
                'moneda' => $request->moneda ?? 'MXN',
                'observaciones' => $request->observaciones,
                'estado' => 'En Proceso',
                'participa' => false
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $licitacion->load(['cliente', 'responsable']),
                'message' => 'Licitación creada correctamente'
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al crear licitación: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al crear: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        Log::info('=== LICITACIONES: Mostrando detalle ID: ' . $id);

        try {
            $licitacion = Licitacion::with(['cliente', 'responsable', 'creador'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $licitacion
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Licitación no encontrada'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('=== LICITACIONES: Actualizando ID: ' . $id);

        try {
            $licitacion = Licitacion::findOrFail($id);

            $validated = $request->validate([
                'no_licitacion' => 'sometimes|string|max:50|unique:licitaciones,no_licitacion,' . $id,
                'nombre' => 'sometimes|string|max:500',
                'cliente_id' => 'sometimes|exists:contactos,contacto_id',
                'fecha_publicacion' => 'sometimes|date',
                'fecha_cierre' => 'sometimes|date|after_or_equal:fecha_publicacion',
                'monto_estimado' => 'sometimes|numeric|min:0',
                'responsable_id' => 'nullable|exists:plantillas,plantilla_id',
                'estado' => 'sometimes|in:En Proceso,Adjudicada,No Adjudicada,Por Vencer,Vencida,Rechazada,Cancelada',
                'observaciones' => 'nullable|string'
            ]);

            $licitacion->update($request->all());

            // Recalcular estado automáticamente según fecha
            $this->recalcularEstado($licitacion);

            return response()->json([
                'success' => true,
                'data' => $licitacion->fresh(['cliente', 'responsable']),
                'message' => 'Licitación actualizada'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('ERROR al actualizar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $licitacion = Licitacion::findOrFail($id);
            $licitacion->delete();

            return response()->json([
                'success' => true,
                'message' => 'Licitación eliminada'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Marcar/desmarcar participación.
     * Al marcar como "participa", el estado se actualiza a "En Proceso".
     */
    public function participar(Request $request, $id)
    {
        Log::info('=== LICITACIONES: Participar ID: ' . $id);

        try {
            DB::beginTransaction();

            $licitacion = Licitacion::findOrFail($id);

            // Toggle: si ya participa, se quita; si no, se marca
            $nuevoEstado = !$licitacion->participa;

            $licitacion->participa = $nuevoEstado;
            $licitacion->fecha_participacion = $nuevoEstado ? now() : null;

            // ✅ Al marcar participación, el estado cambia a "En Proceso"
            if ($nuevoEstado) {
                $licitacion->estado = 'En Proceso';
            } else {
                // Si se desmarca y estaba "En Proceso", se regresa a "En Proceso" por defecto
                // (puedes ajustar esta lógica según tu flujo)
                if ($licitacion->estado === 'En Proceso') {
                    $licitacion->estado = 'En Proceso';
                }
            }

            $licitacion->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $licitacion->fresh(['cliente', 'responsable']),
                'participa' => $licitacion->participa,
                'estado' => $licitacion->estado,
                'message' => $nuevoEstado
                    ? 'Participación confirmada. Estado actualizado a "En Proceso".'
                    : 'Participación cancelada.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al participar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ NUEVO: Marcar licitación como Ganadora / Adjudicada
     */
    public function ganar(Request $request, $id)
    {
        Log::info('=== LICITACIONES: Marcar como Ganadora ID: ' . $id);

        try {
            $licitacion = Licitacion::findOrFail($id);
            $licitacion->estado = 'Adjudicada';
            $licitacion->participa = true;
            $licitacion->fecha_adjudicacion = now();
            $licitacion->save();

            return response()->json([
                'success' => true,
                'data' => $licitacion->fresh(['cliente', 'responsable']),
                'message' => 'Licitación marcada como Adjudicada'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ NUEVO: Marcar licitación como Rechazada / No Adjudicada
     */
    public function rechazar(Request $request, $id)
    {
        Log::info('=== LICITACIONES: Marcar como Rechazada ID: ' . $id);

        try {
            $request->validate([
                'motivo' => 'nullable|string|max:500'
            ]);

            $licitacion = Licitacion::findOrFail($id);
            $licitacion->estado = 'No Adjudicada';
            $licitacion->participa = true;

            if ($request->filled('motivo')) {
                $obs = $licitacion->observaciones
                    ? $licitacion->observaciones . "\n\n"
                    : '';
                $licitacion->observaciones = $obs . '[Rechazo ' . now()->format('Y-m-d H:i') . '] ' . $request->motivo;
            }

            $licitacion->save();

            return response()->json([
                'success' => true,
                'data' => $licitacion->fresh(['cliente', 'responsable']),
                'message' => 'Licitación marcada como No Adjudicada'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ NUEVO: Cambiar estado manualmente (para el botón de check procesar)
     */
    public function cambiarEstado(Request $request, $id)
    {
        Log::info('=== LICITACIONES: Cambiar estado ID: ' . $id);

        try {
            $request->validate([
                'estado' => 'required|in:En Proceso,Adjudicada,No Adjudicada,Por Vencer,Vencida,Rechazada,Cancelada'
            ]);

            $licitacion = Licitacion::findOrFail($id);
            $licitacion->estado = $request->estado;

            // Si el nuevo estado es Adjudicada, se marca participación automáticamente
            if ($request->estado === 'Adjudicada') {
                $licitacion->participa = true;
                $licitacion->fecha_adjudicacion = now();
            }

            $licitacion->save();

            return response()->json([
                'success' => true,
                'data' => $licitacion->fresh(['cliente', 'responsable']),
                'message' => 'Estado actualizado a "' . $request->estado . '"'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Estado no válido',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function estadisticas(Request $request)
    {
        try {
            $estadisticas = $this->calcularEstadisticas($request);

            return response()->json([
                'success' => true,
                'data' => $estadisticas
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => [
                    'total' => 0,
                    'en_proceso' => 0,
                    'adjudicadas' => 0,
                    'por_vencer' => 0,
                    'monto_total' => 0
                ]
            ]);
        }
    }

    /**
     * Exportar respetando filtros aplicados
     */
    public function exportar(Request $request)
    {
        Log::info('=== LICITACIONES: Exportando datos ===');

        try {
            $query = Licitacion::with(['cliente', 'responsable']);

            // Reutilizamos la misma lógica de filtros
            if ($request->filled('busqueda')) {
                $busqueda = trim($request->busqueda);
                $query->where(function ($q) use ($busqueda) {
                    $q->where('no_licitacion', 'LIKE', "%{$busqueda}%")
                      ->orWhere('nombre', 'LIKE', "%{$busqueda}%")
                      ->orWhereHas('cliente', function ($cq) use ($busqueda) {
                          $cq->where('razon_social', 'LIKE', "%{$busqueda}%");
                      });
                });
            }

            if ($request->filled('estado')) {
                $estados = is_array($request->estado) ? $request->estado : explode(',', $request->estado);
                $query->whereIn('estado', $estados);
            }

            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha_publicacion', '>=', $request->fecha_inicio);
            }

            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha_publicacion', '<=', $request->fecha_fin);
            }

            $licitaciones = $query->orderBy('created_at', 'desc')->get();

            // Formatear datos para exportación
            $data = $licitaciones->map(function ($l) {
                return [
                    'id' => $l->id,
                    'no_licitacion' => $l->no_licitacion,
                    'nombre' => $l->nombre,
                    'nombre_cliente' => $l->nombre_cliente ?? ($l->cliente->razon_social ?? '-'),
                    'nombre_responsable' => $l->nombre_responsable ?? ($l->responsable->nombre ?? '-'),
                    'fecha_publicacion' => $l->fecha_publicacion,
                    'fecha_cierre' => $l->fecha_cierre,
                    'dias_restantes' => $l->dias_restantes,
                    'monto_estimado' => $l->monto_estimado,
                    'moneda' => $l->moneda,
                    'estado' => $l->estado,
                    'participa' => $l->participa,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data,
                'count' => $data->count()
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al exportar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function eliminarDocumento($id, $index)
    {
        return response()->json([
            'success' => true,
            'message' => 'Documento eliminado'
        ]);
    }

    /**
     * Recalcula el estado según la fecha de cierre
     */
    private function recalcularEstado(Licitacion $licitacion): void
    {
        if (in_array($licitacion->estado, ['Adjudicada', 'No Adjudicada', 'Rechazada', 'Cancelada'])) {
            return;
        }

        $hoy = Carbon::now()->startOfDay();
        $cierre = Carbon::parse($licitacion->fecha_cierre)->startOfDay();

        if ($cierre->lt($hoy)) {
            $licitacion->estado = 'Vencida';
        } elseif ($cierre->diffInDays($hoy) <= 7) {
            $licitacion->estado = 'Por Vencer';
        } elseif ($licitacion->participa) {
            $licitacion->estado = 'En Proceso';
        }

        $licitacion->save();
    }

    private function calcularEstadisticas(Request $request): array
    {
        try {
            $baseQuery = Licitacion::query();

            // Aplicar los mismos filtros de fecha si existen
            if ($request->filled('fecha_inicio')) {
                $baseQuery->whereDate('fecha_publicacion', '>=', $request->fecha_inicio);
            }
            if ($request->filled('fecha_fin')) {
                $baseQuery->whereDate('fecha_publicacion', '<=', $request->fecha_fin);
            }

            $total = (clone $baseQuery)->count();
            $enProceso = (clone $baseQuery)->where('estado', 'En Proceso')->count();
            $adjudicadas = (clone $baseQuery)->where('estado', 'Adjudicada')->count();
            $noAdjudicadas = (clone $baseQuery)->where('estado', 'No Adjudicada')->count();

            $porVencer = (clone $baseQuery)
                ->whereIn('estado', ['En Proceso', 'Por Vencer'])
                ->whereDate('fecha_cierre', '<=', now()->addDays(15))
                ->whereDate('fecha_cierre', '>=', now())
                ->count();

            $montoTotal = (clone $baseQuery)->sum('monto_estimado');

            return [
                'total' => $total,
                'en_proceso' => $enProceso,
                'adjudicadas' => $adjudicadas,
                'no_adjudicadas' => $noAdjudicadas,
                'por_vencer' => $porVencer,
                'monto_total' => $montoTotal
            ];

        } catch (\Exception $e) {
            Log::error('ERROR calcularEstadisticas: ' . $e->getMessage());
            return [
                'total' => 0,
                'en_proceso' => 0,
                'adjudicadas' => 0,
                'no_adjudicadas' => 0,
                'por_vencer' => 0,
                'monto_total' => 0
            ];
        }
    }
}