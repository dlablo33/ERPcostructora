<?php

namespace App\Http\Controllers;

use App\Models\AnalisisPrecioUnitario;
use App\Models\ApuComponente;
use App\Models\Articulo;
use App\Models\Puesto;
use App\Models\ActivoMaquinaria;
use App\Models\Proveedor;
use App\Http\Requests\APURequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class APUController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Vista principal
     */
    public function analisis()
    {
        Log::info('=== APU: Cargando vista análisis ===');
        return view('proyectos.licitacion.analisis');
    }

    /**
     * Lista de APUs con filtros + paginación + ordenamiento
     */
    public function index(Request $request)
    {
        Log::info('=== APU INDEX ===', $request->all());

        try {
            $query = AnalisisPrecioUnitario::with(['creador']);

            // 🔍 Búsqueda insensible a mayúsculas/minúsculas y acentos (punto 1)
            if ($request->filled('busqueda')) {
                $termino = trim($request->busqueda);
                $query->where(function ($q) use ($termino) {
                    $like = '%' . mb_strtolower($termino, 'UTF-8') . '%';
                    $q->whereRaw('LOWER(codigo) LIKE ?', [$like])
                      ->orWhereRaw('LOWER(concepto) LIKE ?', [$like])
                      ->orWhereRaw('LOWER(observaciones) LIKE ?', [$like]);
                });
            }

            // Filtro por categoría
            if ($request->filled('categoria') && $request->categoria !== 'todos') {
                $query->byCategoria($request->categoria);
            }

            // Filtro por estado
            if ($request->filled('estado') && $request->estado !== 'todos') {
                $query->byEstado($request->estado);
            }

            // Filtro por rango de costos
            if ($request->filled('costo_min') && $request->filled('costo_max')) {
                $query->byRangoCostos($request->costo_min, $request->costo_max);
            }

            // Filtro por fechas (que el frontend ya envía)
            if ($request->filled('fecha_inicio')) {
                $query->whereDate('created_at', '>=', $request->fecha_inicio);
            }
            if ($request->filled('fecha_fin')) {
                $query->whereDate('created_at', '<=', $request->fecha_fin);
            }

            // Ordenamiento configurable
            $sortBy  = $request->get('sort_by', 'created_at');
            $sortDir = strtolower($request->get('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';
            $columnasPermitidas = ['codigo', 'concepto', 'categoria', 'unidad', 'costo_total', 'estado', 'created_at'];
            if (!in_array($sortBy, $columnasPermitidas, true)) {
                $sortBy = 'created_at';
            }
            $query->orderBy($sortBy, $sortDir);

            // Paginación
            $perPage = (int) $request->get('per_page', 10);
            if (!in_array($perPage, [10, 25, 50, 100], true)) {
                $perPage = 10;
            }
            $apus = $query->paginate($perPage);

            // Estadísticas y promedios (sobre el universo filtrado, no solo la página)
            $estadisticas        = $this->calcularEstadisticas($request);
            $promedios           = $this->calcularPromedios($request);
            $conteosCategorias   = $this->getConteosCategorias($request);

            return response()->json([
                'success'             => true,
                'data'                => $apus,
                'estadisticas'        => $estadisticas,
                'promedios'           => $promedios,
                'conteos_categorias'  => $conteosCategorias,
                'message'             => 'APUs obtenidos correctamente',
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en index APU: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener APUs: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Detalle de un APU
     */
    public function show($id)
    {
        Log::info('=== APU: Mostrando detalle ID: ' . $id);

        try {
            $apu = AnalisisPrecioUnitario::with(['creador', 'componentes'])->find($id);

            if (!$apu) {
                return response()->json([
                    'success' => false,
                    'message' => 'APU no encontrado',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data'    => $apu,
                'message' => 'APU obtenido correctamente',
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al mostrar APU: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el APU',
            ], 500);
        }
    }

    /**
     * Crear APU
     */
    public function store(APURequest $request)
    {
        Log::info('=== APU: Creando nuevo análisis ===', $request->all());

        try {
            DB::beginTransaction();

            $apu = AnalisisPrecioUnitario::create([
                'codigo'             => $request->codigo,
                'concepto'           => $request->concepto,
                'categoria'          => $request->categoria,
                'unidad'             => $request->unidad,
                'costo_materiales'   => $request->costo_materiales ?? 0,
                'costo_mano_obra'    => $request->costo_mano_obra ?? 0,
                'costo_maquinaria'   => $request->costo_maquinaria ?? 0,
                'costo_subcontratos' => $request->costo_subcontratos ?? 0,
                'estado'             => $request->estado ?? 'activo',
                'observaciones'      => $request->observaciones,
                'created_by'         => auth()->id(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'data'    => $apu,
                'message' => 'Análisis creado correctamente',
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al crear APU: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al crear el análisis: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Actualizar APU (punto 3: permite actualizar estatus)
     */
    public function update(APURequest $request, $id)
    {
        Log::info('=== APU: Actualizando ID: ' . $id, $request->all());

        try {
            DB::beginTransaction();

            $apu = AnalisisPrecioUnitario::find($id);
            if (!$apu) {
                return response()->json([
                    'success' => false,
                    'message' => 'APU no encontrado',
                ], 404);
            }

            $apu->update([
                'codigo'             => $request->codigo,
                'concepto'           => $request->concepto,
                'categoria'          => $request->categoria,
                'unidad'             => $request->unidad,
                'costo_materiales'   => $request->costo_materiales ?? 0,
                'costo_mano_obra'    => $request->costo_mano_obra ?? 0,
                'costo_maquinaria'   => $request->costo_maquinaria ?? 0,
                'costo_subcontratos' => $request->costo_subcontratos ?? 0,
                'estado'             => $request->filled('estado') ? $request->estado : $apu->estado,
                'observaciones'      => $request->observaciones,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'data'    => $apu->fresh(),
                'message' => 'Análisis actualizado correctamente',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al actualizar APU: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el análisis: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Eliminar APU (soft delete) — punto 4
     */
    public function destroy($id)
    {
        Log::info('=== APU: Eliminando ID: ' . $id);

        try {
            DB::beginTransaction();

            $apu = AnalisisPrecioUnitario::find($id);
            if (!$apu) {
                return response()->json([
                    'success' => false,
                    'message' => 'APU no encontrado',
                ], 404);
            }

            $apu->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Análisis eliminado correctamente',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al eliminar APU: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el análisis',
            ], 500);
        }
    }

    /**
     * Duplicar APU
     */
    public function duplicar($id)
    {
        Log::info('=== APU: Duplicando ID: ' . $id);

        try {
            DB::beginTransaction();

            $apuOriginal = AnalisisPrecioUnitario::with('componentes')->find($id);
            if (!$apuOriginal) {
                return response()->json([
                    'success' => false,
                    'message' => 'APU no encontrado',
                ], 404);
            }

            $nuevoAPU = $apuOriginal->duplicar();

            // Duplicar componentes en batch
            if ($apuOriginal->componentes->count() > 0) {
                $componentes = $apuOriginal->componentes->map(function ($c) use ($nuevoAPU) {
                    $data = $c->toArray();
                    unset($data['id'], $data['created_at'], $data['updated_at'], $data['deleted_at']);
                    $data['apu_id'] = $nuevoAPU->id;
                    return $data;
                })->toArray();

                ApuComponente::insert($componentes);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'data'    => $nuevoAPU,
                'message' => 'Análisis duplicado correctamente. Nuevo código: ' . $nuevoAPU->codigo,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al duplicar APU: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al duplicar el análisis: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Cambiar estado (punto 3)
     */
    public function cambiarEstado(Request $request, $id)
    {
        Log::info('=== APU: Cambiando estado ID: ' . $id . ' a: ' . $request->estado);

        try {
            $request->validate([
                'estado' => 'required|in:activo,revision,inactivo',
            ]);

            $apu = AnalisisPrecioUnitario::find($id);
            if (!$apu) {
                return response()->json([
                    'success' => false,
                    'message' => 'APU no encontrado',
                ], 404);
            }

            if (!$apu->cambiarEstado($request->estado)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Estado no válido',
                ], 400);
            }

            return response()->json([
                'success' => true,
                'data'    => $apu->fresh(),
                'message' => 'Estado actualizado a: ' . $apu->estado_nombre,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Estado inválido',
                'errors'  => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            Log::error('ERROR al cambiar estado: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado',
            ], 500);
        }
    }

    /**
     * Estadísticas
     */
    public function estadisticas(Request $request)
    {
        try {
            return response()->json([
                'success' => true,
                'data'    => [
                    'estadisticas'        => $this->calcularEstadisticas($request),
                    'promedios'           => $this->calcularPromedios($request),
                    'conteos_categorias'  => $this->getConteosCategorias($request),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('ERROR en estadísticas APU: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas',
            ], 500);
        }
    }

    /**
     * Exportar (JSON con datos listos para CSV en front)
     */
    public function exportar(Request $request)
    {
        Log::info('=== APU: Exportando datos ===');

        try {
            $query = AnalisisPrecioUnitario::query();

            if ($request->filled('busqueda')) {
                $termino = mb_strtolower(trim($request->busqueda), 'UTF-8');
                $like = '%' . $termino . '%';
                $query->where(function ($q) use ($like) {
                    $q->whereRaw('LOWER(codigo) LIKE ?', [$like])
                      ->orWhereRaw('LOWER(concepto) LIKE ?', [$like]);
                });
            }

            if ($request->filled('categoria') && $request->categoria !== 'todos') {
                $query->byCategoria($request->categoria);
            }

            if ($request->filled('estado') && $request->estado !== 'todos') {
                $query->byEstado($request->estado);
            }

            $apus = $query->orderBy('created_at', 'desc')->get();

            $headers = ['Código', 'Concepto', 'Categoría', 'Unidad', 'Materiales', 'Mano de Obra', 'Maquinaria', 'Subcontratos', 'Precio Unitario', 'Estado'];
            $rows = $apus->map(function ($apu) {
                return [
                    $apu->codigo,
                    $apu->concepto,
                    $apu->categoria_nombre,
                    $apu->unidad,
                    $apu->costo_materiales,
                    $apu->costo_mano_obra,
                    $apu->costo_maquinaria,
                    $apu->costo_subcontratos,
                    $apu->costo_total,
                    $apu->estado_nombre,
                ];
            });

            return response()->json([
                'success' => true,
                'data'    => [
                    'headers' => $headers,
                    'rows'    => $rows,
                    'total'   => $apus->count(),
                ],
                'message' => 'Datos listos para exportar',
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al exportar APU: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar datos',
            ], 500);
        }
    }

    /**
     * Catálogo de materiales (para selects, punto 2 en combinación con unidades)
     */
    public function materiales()
    {
        try {
            $materiales = Articulo::where('estatus', 'activo')
                ->select('id', 'codigo', 'descripcion as nombre', 'unidad_medida as unidad')
                ->orderBy('descripcion')
                ->get();

            return response()->json([
                'success' => true,
                'data'    => $materiales,
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener materiales: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Error al obtener materiales',
            ]);
        }
    }

    /**
     * Catálogo de maquinaria
     */
    public function maquinaria()
    {
        try {
            $maquinaria = ActivoMaquinaria::with(['activo'])
                ->get()
                ->map(function ($item) {
                    return [
                        'id'         => $item->id,
                        'nombre'     => optional($item->activo)->nombre ?? 'Sin nombre',
                        'codigo'     => optional($item->activo)->codigo ?? 'N/A',
                        'costo_hora' => $item->costo_operacion ?? 0,
                    ];
                });

            return response()->json([
                'success' => true,
                'data'    => $maquinaria,
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener maquinaria: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Error al obtener maquinaria',
            ]);
        }
    }

    /**
     * Catálogo de puestos
     */
    public function puestos()
    {
        try {
            $puestos = Puesto::where('estatus', 'activo')
                ->select('id', 'folio', 'nombre', 'descripcion')
                ->orderBy('nombre')
                ->get()
                ->map(function ($item) {
                    return [
                        'id'          => $item->id,
                        'nombre'      => $item->nombre,
                        'folio'       => $item->folio,
                        'descripcion' => $item->descripcion,
                    ];
                });

            return response()->json([
                'success' => true,
                'data'    => $puestos,
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener puestos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Error al obtener puestos',
            ]);
        }
    }

    /**
     * Catálogo de proveedores
     */
    public function proveedores()
    {
        try {
            $proveedores = Proveedor::where('activo', true)
                ->select('id', 'nombre', 'rfc')
                ->orderBy('nombre')
                ->get();

            return response()->json([
                'success' => true,
                'data'    => $proveedores,
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener proveedores: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Error al obtener proveedores',
            ]);
        }
    }

    /**
     * Catálogo de unidades de medida (punto 2) — para el selector
     */
    public function unidades()
    {
        try {
            // Unidades fijas del sistema. Puedes reemplazar esto por
            // una consulta a una tabla `unidades_medida` si la tienes.
            $unidades = [
                ['valor' => 'm',    'nombre' => 'Metro (m)'],
                ['valor' => 'm2',   'nombre' => 'Metro cuadrado (m²)'],
                ['valor' => 'm3',   'nombre' => 'Metro cúbico (m³)'],
                ['valor' => 'ml',   'nombre' => 'Metro lineal (ml)'],
                ['valor' => 'kg',   'nombre' => 'Kilogramo (kg)'],
                ['valor' => 'ton',  'nombre' => 'Tonelada (ton)'],
                ['valor' => 'lt',   'nombre' => 'Litro (lt)'],
                ['valor' => 'pza',  'nombre' => 'Pieza (pza)'],
                ['valor' => 'lote', 'nombre' => 'Lote'],
                ['valor' => 'jor',  'nombre' => 'Jornal (jor)'],
                ['valor' => 'hr',   'nombre' => 'Hora (hr)'],
                ['valor' => 'dia',  'nombre' => 'Día (día)'],
                ['valor' => 'sem',  'nombre' => 'Semana'],
                ['valor' => 'mes',  'nombre' => 'Mes'],
                ['valor' => 'serv', 'nombre' => 'Servicio'],
                ['valor' => 'glob', 'nombre' => 'Global (glob)'],
                ['valor' => 'pct',  'nombre' => 'Porcentaje (%)'],
            ];

            return response()->json([
                'success' => true,
                'data'    => $unidades,
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener unidades: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Error al obtener unidades',
            ]);
        }
    }

    // ==================== MÉTODOS PRIVADOS ====================

    /**
     * Aplica los filtros comunes (búsqueda, categoría, estado, fechas)
     * a cualquier query. Evita duplicación.
     */
    private function aplicarFiltros(Request $request, $query)
    {
        if ($request->filled('busqueda')) {
            $termino = mb_strtolower(trim($request->busqueda), 'UTF-8');
            $like = '%' . $termino . '%';
            $query->where(function ($q) use ($like) {
                $q->whereRaw('LOWER(codigo) LIKE ?', [$like])
                  ->orWhereRaw('LOWER(concepto) LIKE ?', [$like]);
            });
        }

        if ($request->filled('categoria') && $request->categoria !== 'todos') {
            $query->byCategoria($request->categoria);
        }

        if ($request->filled('estado') && $request->estado !== 'todos') {
            $query->byEstado($request->estado);
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        return $query;
    }

    /**
     * Estadísticas para los 4 cuadros (optimizado con una sola query agrupada)
     */
    private function calcularEstadisticas(Request $request): array
    {
        try {
            $query = AnalisisPrecioUnitario::query();
            $this->aplicarFiltros($request, $query);

            $stats = (clone $query)
                ->select('estado', DB::raw('COUNT(*) as total'))
                ->groupBy('estado')
                ->pluck('total', 'estado');

            $total = $stats->sum();

            return [
                'total'     => $total,
                'activos'   => $stats['activo']   ?? 0,
                'revision'  => $stats['revision'] ?? 0,
                'inactivos' => $stats['inactivo'] ?? 0,
            ];

        } catch (\Exception $e) {
            Log::error('ERROR calcularEstadisticas APU: ' . $e->getMessage());
            return [
                'total'     => 0,
                'activos'   => 0,
                'revision'  => 0,
                'inactivos' => 0,
            ];
        }
    }

    /**
     * Promedios (punto 5): ahora coinciden con lo mostrado en el grid.
     * Se calculan sobre el universo filtrado (mismo filtro que la tabla),
     * usando SQL directo (más rápido que traer todo a memoria).
     */
    private function calcularPromedios(Request $request): array
    {
        try {
            $query = AnalisisPrecioUnitario::query();
            $this->aplicarFiltros($request, $query);

            $prom = (clone $query)
                ->selectRaw('
                    COALESCE(AVG(costo_materiales), 0)   as materiales,
                    COALESCE(AVG(costo_mano_obra), 0)    as mano_obra,
                    COALESCE(AVG(costo_maquinaria), 0)   as maquinaria,
                    COALESCE(AVG(costo_subcontratos), 0) as subcontratos,
                    COALESCE(AVG(costo_total), 0)        as total
                ')
                ->first();

            return [
                'materiales'   => round((float) ($prom->materiales   ?? 0), 2),
                'mano_obra'    => round((float) ($prom->mano_obra    ?? 0), 2),
                'maquinaria'   => round((float) ($prom->maquinaria   ?? 0), 2),
                'subcontratos' => round((float) ($prom->subcontratos ?? 0), 2),
                'total'        => round((float) ($prom->total        ?? 0), 2),
            ];

        } catch (\Exception $e) {
            Log::error('ERROR calcularPromedios APU: ' . $e->getMessage());
            return [
                'materiales'   => 0,
                'mano_obra'    => 0,
                'maquinaria'   => 0,
                'subcontratos' => 0,
                'total'        => 0,
            ];
        }
    }

    /**
     * Conteos por categoría en una sola query (punto: eficiencia)
     */
    private function getConteosCategorias(Request $request): array
    {
        try {
            $query = AnalisisPrecioUnitario::query();

            // Sólo aplicar búsqueda (no categoría, porque queremos los conteos por categoría)
            if ($request->filled('busqueda')) {
                $termino = mb_strtolower(trim($request->busqueda), 'UTF-8');
                $like = '%' . $termino . '%';
                $query->where(function ($q) use ($like) {
                    $q->whereRaw('LOWER(codigo) LIKE ?', [$like])
                      ->orWhereRaw('LOWER(concepto) LIKE ?', [$like]);
                });
            }

            $conteosRaw = (clone $query)
                ->select('categoria', DB::raw('COUNT(*) as total'))
                ->groupBy('categoria')
                ->pluck('total', 'categoria')
                ->toArray();

            $categorias = AnalisisPrecioUnitario::CATEGORIAS;
            $conteos = [];

            foreach ($categorias as $key => $nombre) {
                $conteos[$key] = (int) ($conteosRaw[$key] ?? 0);
            }

            $conteos['todos'] = array_sum($conteos);

            return $conteos;

        } catch (\Exception $e) {
            Log::error('ERROR getConteosCategorias APU: ' . $e->getMessage());
            return [
                'todos'        => 0,
                'materiales'   => 0,
                'mano_obra'    => 0,
                'maquinaria'   => 0,
                'subcontratos' => 0,
                'indirectos'   => 0,
            ];
        }
    }
}