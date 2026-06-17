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
     * Muestra la vista principal de Análisis de Precios Unitarios
     * Esta es la vista que carga tu blade
     */
    public function analisis()
    {
        Log::info('=== APU: Cargando vista análisis ===');
        return view('proyectos.licitacion.analisis');
    }

    /**
     * Obtiene todos los APUs con filtros (para AJAX)
     */
    public function index(Request $request)
    {
        Log::info('=== APU INDEX ===');
        
        try {
            $query = AnalisisPrecioUnitario::with(['creador']);

            // Aplicar filtro de búsqueda
            if ($request->filled('busqueda')) {
                $query->buscar($request->busqueda);
            }

            // Aplicar filtro por categoría
            if ($request->filled('categoria') && $request->categoria !== 'todos') {
                $query->byCategoria($request->categoria);
            }

            // Aplicar filtro por estado
            if ($request->filled('estado')) {
                $query->byEstado($request->estado);
            }

            // Aplicar filtro por rango de costos
            if ($request->filled('costo_min') && $request->filled('costo_max')) {
                $query->byRangoCostos($request->costo_min, $request->costo_max);
            }

            // Ordenar y paginar
            $perPage = $request->get('per_page', 10);
            $apus = $query->orderBy('created_at', 'desc')->paginate($perPage);

            // Calcular estadísticas para los 4 cuadros
            $estadisticas = $this->calcularEstadisticas($request);

            // Calcular promedios
            $promedios = $this->calcularPromedios($request);

            // Obtener conteos por categoría para las pestañas
            $conteosCategorias = $this->getConteosCategorias($request);

            return response()->json([
                'success' => true,
                'data' => $apus,
                'estadisticas' => $estadisticas,
                'promedios' => $promedios,
                'conteos_categorias' => $conteosCategorias,
                'message' => 'APUs obtenidos correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en index APU: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener APUs: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene un APU específico por ID
     */
    public function show($id)
    {
        Log::info('=== APU: Mostrando detalle ID: ' . $id);
        
        try {
            $apu = AnalisisPrecioUnitario::with(['creador', 'componentes'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $apu,
                'message' => 'APU obtenido correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al mostrar APU: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'APU no encontrado'
            ], 404);
        }
    }

    /**
     * Almacena un nuevo APU
     */
    public function store(APURequest $request)
    {
        Log::info('=== APU: Creando nuevo análisis ===');
        Log::info('Datos recibidos:', $request->all());
        
        try {
            DB::beginTransaction();
            
            $apu = AnalisisPrecioUnitario::create([
                'codigo' => $request->codigo,
                'concepto' => $request->concepto,
                'categoria' => $request->categoria,
                'unidad' => $request->unidad,
                'costo_materiales' => $request->costo_materiales ?? 0,
                'costo_mano_obra' => $request->costo_mano_obra ?? 0,
                'costo_maquinaria' => $request->costo_maquinaria ?? 0,
                'costo_subcontratos' => $request->costo_subcontratos ?? 0,
                'estado' => $request->estado ?? 'activo',
                'observaciones' => $request->observaciones,
                'created_by' => auth()->id()
            ]);
            
            Log::info('APU creado con ID: ' . $apu->id . ' y código: ' . $apu->codigo);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'data' => $apu,
                'message' => 'Análisis creado correctamente'
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al crear APU: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el análisis: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualiza un APU existente
     */
    public function update(APURequest $request, $id)
    {
        Log::info('=== APU: Actualizando ID: ' . $id);
        Log::info('Datos:', $request->all());
        
        try {
            DB::beginTransaction();
            
            $apu = AnalisisPrecioUnitario::findOrFail($id);
            
            $apu->update([
                'codigo' => $request->codigo,
                'concepto' => $request->concepto,
                'categoria' => $request->categoria,
                'unidad' => $request->unidad,
                'costo_materiales' => $request->costo_materiales ?? 0,
                'costo_mano_obra' => $request->costo_mano_obra ?? 0,
                'costo_maquinaria' => $request->costo_maquinaria ?? 0,
                'costo_subcontratos' => $request->costo_subcontratos ?? 0,
                'estado' => $request->estado ?? $apu->estado,
                'observaciones' => $request->observaciones
            ]);
            
            Log::info('APU actualizado ID: ' . $apu->id);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'data' => $apu,
                'message' => 'Análisis actualizado correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al actualizar APU: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el análisis: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina un APU (soft delete)
     */
    public function destroy($id)
    {
        Log::info('=== APU: Eliminando ID: ' . $id);
        
        try {
            $apu = AnalisisPrecioUnitario::findOrFail($id);
            $apu->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Análisis eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al eliminar APU: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el análisis'
            ], 500);
        }
    }

    /**
     * Duplica un APU existente
     */
    public function duplicar($id)
    {
        Log::info('=== APU: Duplicando ID: ' . $id);
        
        try {
            DB::beginTransaction();
            
            $apuOriginal = AnalisisPrecioUnitario::findOrFail($id);
            $nuevoAPU = $apuOriginal->duplicar();
            
            // Si tiene componentes, duplicarlos también
            if ($apuOriginal->componentes()->count() > 0) {
                foreach ($apuOriginal->componentes as $componente) {
                    $nuevoComponente = $componente->replicate();
                    $nuevoComponente->apu_id = $nuevoAPU->id;
                    $nuevoComponente->save();
                }
            }
            
            Log::info('APU duplicado: ' . $apuOriginal->codigo . ' → ' . $nuevoAPU->codigo);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'data' => $nuevoAPU,
                'message' => 'Análisis duplicado correctamente. Nuevo código: ' . $nuevoAPU->codigo
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al duplicar APU: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al duplicar el análisis: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cambia el estado de un APU
     */
    public function cambiarEstado(Request $request, $id)
    {
        Log::info('=== APU: Cambiando estado ID: ' . $id . ' a: ' . $request->estado);
        
        try {
            $apu = AnalisisPrecioUnitario::findOrFail($id);
            
            if (!$apu->cambiarEstado($request->estado)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Estado no válido'
                ], 400);
            }
            
            return response()->json([
                'success' => true,
                'data' => $apu,
                'message' => 'Estado actualizado a: ' . $apu->estado_nombre
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al cambiar estado: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado'
            ], 500);
        }
    }

    /**
     * Obtiene estadísticas para el dashboard
     */
    public function estadisticas(Request $request)
    {
        try {
            $estadisticas = $this->calcularEstadisticas($request);
            $promedios = $this->calcularPromedios($request);
            $conteosCategorias = $this->getConteosCategorias($request);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'estadisticas' => $estadisticas,
                    'promedios' => $promedios,
                    'conteos_categorias' => $conteosCategorias
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en estadísticas APU: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas'
            ], 500);
        }
    }

    /**
     * Exporta APUs a Excel
     */
    public function exportar(Request $request)
    {
        Log::info('=== APU: Exportando datos ===');
        
        try {
            $query = AnalisisPrecioUnitario::query();
            
            if ($request->filled('busqueda')) {
                $query->buscar($request->busqueda);
            }
            
            if ($request->filled('categoria') && $request->categoria !== 'todos') {
                $query->byCategoria($request->categoria);
            }
            
            $apus = $query->orderBy('created_at', 'desc')->get();
            
            // Preparar datos para CSV
            $headers = ['Código', 'Concepto', 'Categoría', 'Unidad', 'Materiales', 'Mano de Obra', 'Maquinaria', 'Subcontratos', 'Precio Unitario', 'Estado'];
            $rows = $apus->map(function($apu) {
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
                    $apu->estado_nombre
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => [
                    'headers' => $headers,
                    'rows' => $rows,
                    'total' => $apus->count()
                ],
                'message' => 'Datos listos para exportar'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al exportar APU: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar datos'
            ], 500);
        }
    }

    /**
     * Obtiene catálogo de materiales para selects
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
                'data' => $materiales
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener materiales: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Error al obtener materiales'
            ]);
        }
    }

    /**
     * Obtiene catálogo de maquinaria para selects
     */
    public function maquinaria()
    {
        try {
            $maquinaria = ActivoMaquinaria::with(['activo'])
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nombre' => $item->activo->nombre ?? 'Sin nombre',
                        'codigo' => $item->activo->codigo ?? 'N/A',
                        'costo_hora' => $item->costo_operacion ?? 0
                    ];
                });
            
            return response()->json([
                'success' => true,
                'data' => $maquinaria
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener maquinaria: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Error al obtener maquinaria'
            ]);
        }
    }

    /**
     * Obtiene catálogo de puestos (mano de obra) para selects
     */
    public function puestos()
    {
        try {
            $puestos = Puesto::where('estatus', 'activo')
                ->select('id', 'folio', 'nombre', 'descripcion')
                ->orderBy('nombre')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nombre' => $item->nombre,
                        'folio' => $item->folio,
                        'descripcion' => $item->descripcion
                    ];
                });
            
            return response()->json([
                'success' => true,
                'data' => $puestos
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener puestos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Error al obtener puestos'
            ]);
        }
    }

    /**
     * Obtiene catálogo de proveedores para selects
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
                'data' => $proveedores
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener proveedores: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Error al obtener proveedores'
            ]);
        }
    }

    // ==================== MÉTODOS PRIVADOS ====================

    /**
     * Calcula las estadísticas para los 4 cuadros del dashboard
     */
    private function calcularEstadisticas(Request $request): array
    {
        try {
            $query = AnalisisPrecioUnitario::query();
            
            if ($request->filled('categoria') && $request->categoria !== 'todos') {
                $query->byCategoria($request->categoria);
            }

            return [
                'total' => $query->count(),
                'activos' => (clone $query)->where('estado', 'activo')->count(),
                'revision' => (clone $query)->where('estado', 'revision')->count(),
                'inactivos' => (clone $query)->where('estado', 'inactivo')->count()
            ];
            
        } catch (\Exception $e) {
            Log::error('ERROR calcularEstadisticas APU: ' . $e->getMessage());
            return [
                'total' => 0,
                'activos' => 0,
                'revision' => 0,
                'inactivos' => 0
            ];
        }
    }

    /**
     * Calcula los promedios de costos
     */
    private function calcularPromedios(Request $request): array
    {
        try {
            $query = AnalisisPrecioUnitario::query();
            
            if ($request->filled('categoria') && $request->categoria !== 'todos') {
                $query->byCategoria($request->categoria);
            }

            $apus = $query->get();
            $count = $apus->count() ?: 1;

            return [
                'materiales' => $apus->avg('costo_materiales') ?? 0,
                'mano_obra' => $apus->avg('costo_mano_obra') ?? 0,
                'maquinaria' => $apus->avg('costo_maquinaria') ?? 0,
                'subcontratos' => $apus->avg('costo_subcontratos') ?? 0,
                'total' => $apus->avg('costo_total') ?? 0
            ];
            
        } catch (\Exception $e) {
            Log::error('ERROR calcularPromedios APU: ' . $e->getMessage());
            return [
                'materiales' => 0,
                'mano_obra' => 0,
                'maquinaria' => 0,
                'subcontratos' => 0,
                'total' => 0
            ];
        }
    }

    /**
     * Obtiene los conteos por categoría para las pestañas
     */
    private function getConteosCategorias(Request $request): array
    {
        try {
            $query = AnalisisPrecioUnitario::query();
            
            // Aplicar filtro de búsqueda si existe
            if ($request->filled('busqueda')) {
                $query->buscar($request->busqueda);
            }

            $categorias = AnalisisPrecioUnitario::CATEGORIAS;
            $conteos = [];

            foreach ($categorias as $key => $nombre) {
                $conteos[$key] = (clone $query)->where('categoria', $key)->count();
            }

            // Total
            $conteos['todos'] = array_sum($conteos);

            return $conteos;
            
        } catch (\Exception $e) {
            Log::error('ERROR getConteosCategorias APU: ' . $e->getMessage());
            return [
                'todos' => 0,
                'materiales' => 0,
                'mano_obra' => 0,
                'maquinaria' => 0,
                'subcontratos' => 0,
                'indirectos' => 0
            ];
        }
    }
}