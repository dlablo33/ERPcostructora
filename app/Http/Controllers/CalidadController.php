<?php

namespace App\Http\Controllers;

use App\Models\PruebaCalidad;
use App\Models\NoConformidad;
use App\Models\IndicadorCalidad;
use App\Models\Proyecto;
use App\Models\Plantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CalidadController extends Controller
{
    /**
     * Muestra la vista de Control de Calidad
     */
    public function index()
    {
        // Obtener proyectos activos para el selector
        $proyectos = Proyecto::where('status', 'activo')
            ->orderBy('nombre')
            ->get(['id', 'nombre']);
        
        // Obtener responsables disponibles (empleados activos)
        $responsables = Plantilla::where('estatus', 'Activo')
            ->select('plantilla_id as id', 'nombre', 'apellido_paterno', 'apellido_materno')
            ->orderBy('nombre')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'nombre_completo' => trim($item->nombre . ' ' . ($item->apellido_paterno ?? '') . ' ' . ($item->apellido_materno ?? ''))
                ];
            });
        
        // ✅ CORREGIDO: Usar la vista existente
        return view('proyectos.control.control', compact('proyectos', 'responsables'));
    }

    /**
     * Obtener resumen de KPIs (4 cuadros principales)
     */
    public function resumen(Request $request)
    {
        try {
            $query = PruebaCalidad::query();
            
            if ($request->has('proyecto_id') && $request->proyecto_id) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            if ($request->has('fecha_inicio') && $request->fecha_inicio) {
                $query->where('fecha', '>=', $request->fecha_inicio);
            }
            
            if ($request->has('fecha_fin') && $request->fecha_fin) {
                $query->where('fecha', '<=', $request->fecha_fin);
            }
            
            $total = $query->count();
            $aprobadas = (clone $query)->where('resultado', 'Aprobada')->count();
            $rechazadas = (clone $query)->where('resultado', 'Rechazada')->count();
            $cumplimiento = $total > 0 ? round(($aprobadas / $total) * 100) : 0;
            
            return response()->json([
                'total_pruebas' => $total,
                'aprobadas' => $aprobadas,
                'rechazadas' => $rechazadas,
                'cumplimiento' => $cumplimiento
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en resumen calidad: ' . $e->getMessage());
            return response()->json([
                'total_pruebas' => 0,
                'aprobadas' => 0,
                'rechazadas' => 0,
                'cumplimiento' => 0
            ]);
        }
    }

    /**
     * Obtener lista de pruebas con paginación y filtros
     */
    public function pruebas(Request $request)
    {
        try {
            $query = PruebaCalidad::with(['proyecto', 'responsable']);
            
            if ($request->has('proyecto_id') && $request->proyecto_id) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            if ($request->has('fecha_inicio') && $request->fecha_inicio) {
                $query->where('fecha', '>=', $request->fecha_inicio);
            }
            
            if ($request->has('fecha_fin') && $request->fecha_fin) {
                $query->where('fecha', '<=', $request->fecha_fin);
            }
            
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('no_prueba', 'LIKE', "%{$search}%")
                      ->orWhere('tipo_prueba', 'LIKE', "%{$search}%")
                      ->orWhere('elemento', 'LIKE', "%{$search}%")
                      ->orWhere('laboratorio', 'LIKE', "%{$search}%")
                      ->orWhereHas('proyecto', function($sub) use ($search) {
                          $sub->where('nombre', 'LIKE', "%{$search}%");
                      })
                      ->orWhereHas('responsable', function($sub) use ($search) {
                          $sub->where('nombre', 'LIKE', "%{$search}%")
                              ->orWhere('apellido_paterno', 'LIKE', "%{$search}%");
                      });
                });
            }
            
            $sortField = $request->sort_by ?? 'fecha';
            $sortOrder = $request->sort_order ?? 'desc';
            $query->orderBy($sortField, $sortOrder);
            
            $perPage = $request->per_page ?? 10;
            $pruebas = $query->paginate($perPage);
            
            $datos = $pruebas->map(function($prueba) {
                return [
                    'no_prueba' => $prueba->no_prueba,
                    'proyecto' => $prueba->proyecto->nombre ?? 'Sin proyecto',
                    'tipo_prueba' => $prueba->tipo_prueba,
                    'elemento' => $prueba->elemento,
                    'fecha' => $prueba->fecha ? $prueba->fecha->format('Y-m-d') : null,
                    'resultado' => $prueba->resultado,
                    'responsable' => $prueba->responsable ? 
                        trim($prueba->responsable->nombre . ' ' . ($prueba->responsable->apellido_paterno ?? '')) : 
                        'Sin responsable',
                    'laboratorio' => $prueba->laboratorio,
                    'valor' => $prueba->valor,
                    'especificacion' => $prueba->especificacion,
                    'norma' => $prueba->norma,
                    'observaciones' => $prueba->observaciones,
                    'certificado' => $prueba->certificado_path ? true : false
                ];
            });
            
            return response()->json([
                'data' => $datos,
                'pagination' => [
                    'total' => $pruebas->total(),
                    'per_page' => $pruebas->perPage(),
                    'current_page' => $pruebas->currentPage(),
                    'last_page' => $pruebas->lastPage()
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en pruebas calidad: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'pagination' => [
                    'total' => 0,
                    'per_page' => 10,
                    'current_page' => 1,
                    'last_page' => 1
                ]
            ]);
        }
    }

    /**
     * Obtener indicadores de calidad por proyecto
     */
    public function indicadores(Request $request)
    {
        try {
            $query = Proyecto::where('status', 'activo');
            
            if ($request->has('proyecto_id') && $request->proyecto_id) {
                $query->where('id', $request->proyecto_id);
            }
            
            $proyectos = $query->get();
            $resultados = [];
            
            foreach ($proyectos as $proyecto) {
                $pruebasQuery = PruebaCalidad::where('proyecto_id', $proyecto->id);
                
                if ($request->has('fecha_inicio') && $request->fecha_inicio) {
                    $pruebasQuery->where('fecha', '>=', $request->fecha_inicio);
                }
                
                if ($request->has('fecha_fin') && $request->fecha_fin) {
                    $pruebasQuery->where('fecha', '<=', $request->fecha_fin);
                }
                
                $total = $pruebasQuery->count();
                $aprobadas = (clone $pruebasQuery)->where('resultado', 'Aprobada')->count();
                $rechazadas = $total - $aprobadas;
                $porcentaje = $total > 0 ? round(($aprobadas / $total) * 100, 1) : 0;
                
                $indicador = IndicadorCalidad::firstOrCreate(
                    ['proyecto_id' => $proyecto->id],
                    [
                        'total_pruebas' => $total,
                        'aprobadas' => $aprobadas,
                        'rechazadas' => $rechazadas,
                        'porcentaje_aprobacion' => $porcentaje,
                        'indice_calidad' => $this->calcularIndiceCalidad($proyecto->id),
                        'fecha_actualizacion' => now()
                    ]
                );
                
                $ultimaPrueba = (clone $pruebasQuery)->orderBy('fecha', 'desc')->first();
                $tendencia = $this->calcularTendencia($proyecto->id);
                
                $resultados[] = [
                    'proyecto' => $proyecto->nombre,
                    'total_pruebas' => $total,
                    'aprobadas' => $aprobadas,
                    'rechazadas' => $rechazadas,
                    'porcentaje_aprobacion' => $porcentaje,
                    'tendencia' => $tendencia,
                    'ultima_prueba' => $ultimaPrueba ? $ultimaPrueba->fecha->format('d/m/Y') : 'N/A',
                    'indice_calidad' => round($indicador->indice_calidad ?? 0, 1),
                    'nivel_calidad' => $this->getNivelCalidad($indicador->indice_calidad ?? 0)
                ];
            }
            
            return response()->json($resultados);
            
        } catch (\Exception $e) {
            Log::error('Error en indicadores calidad: ' . $e->getMessage());
            return response()->json([]);
        }
    }

    /**
     * Obtener no conformidades con paginación
     */
    public function noConformidades(Request $request)
    {
        try {
            $query = NoConformidad::with(['proyecto', 'responsable']);
            
            if ($request->has('proyecto_id') && $request->proyecto_id) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            if ($request->has('estado') && $request->estado) {
                $query->where('estado', $request->estado);
            }
            
            if ($request->has('gravedad') && $request->gravedad) {
                $query->where('gravedad', $request->gravedad);
            }
            
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('no_nc', 'LIKE', "%{$search}%")
                      ->orWhere('descripcion', 'LIKE', "%{$search}%")
                      ->orWhereHas('proyecto', function($sub) use ($search) {
                          $sub->where('nombre', 'LIKE', "%{$search}%");
                      });
                });
            }
            
            $perPage = $request->per_page ?? 10;
            $noConformidades = $query->orderBy('fecha_deteccion', 'desc')->paginate($perPage);
            
            $totalNCAbiertas = NoConformidad::where('estado', 'En proceso')->count();
            
            $datos = $noConformidades->map(function($nc) {
                return [
                    'no_nc' => $nc->no_nc,
                    'proyecto' => $nc->proyecto->nombre ?? 'Sin proyecto',
                    'descripcion' => $nc->descripcion,
                    'fecha_deteccion' => $nc->fecha_deteccion ? $nc->fecha_deteccion->format('d/m/Y') : 'N/A',
                    'gravedad' => $nc->gravedad,
                    'responsable' => $nc->responsable ? 
                        trim($nc->responsable->nombre . ' ' . ($nc->responsable->apellido_paterno ?? '')) : 
                        'Sin responsable',
                    'fecha_limite' => $nc->fecha_limite ? $nc->fecha_limite->format('d/m/Y') : 'N/A',
                    'estado' => $nc->estado,
                    'dias_vencidos' => $nc->dias_vencidos ?? 0,
                    'tiene_acciones' => !empty($nc->acciones_tomadas)
                ];
            });
            
            return response()->json([
                'data' => $datos,
                'total_abiertas' => $totalNCAbiertas,
                'pagination' => [
                    'total' => $noConformidades->total(),
                    'per_page' => $noConformidades->perPage(),
                    'current_page' => $noConformidades->currentPage(),
                    'last_page' => $noConformidades->lastPage()
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en no conformidades: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'total_abiertas' => 0,
                'pagination' => [
                    'total' => 0,
                    'per_page' => 10,
                    'current_page' => 1,
                    'last_page' => 1
                ]
            ]);
        }
    }

    /**
     * Obtener detalle de una prueba específica
     */
    public function pruebaDetalle($noPrueba)
    {
        try {
            $prueba = PruebaCalidad::with(['proyecto', 'responsable', 'noConformidad'])
                ->where('no_prueba', $noPrueba)
                ->firstOrFail();
            
            return response()->json([
                'no_prueba' => $prueba->no_prueba,
                'proyecto' => $prueba->proyecto->nombre ?? 'Sin proyecto',
                'tipo_prueba' => $prueba->tipo_prueba,
                'elemento' => $prueba->elemento,
                'fecha' => $prueba->fecha ? $prueba->fecha->format('d/m/Y') : 'N/A',
                'resultado' => $prueba->resultado,
                'responsable' => $prueba->responsable ? 
                    trim($prueba->responsable->nombre . ' ' . ($prueba->responsable->apellido_paterno ?? '')) : 
                    'Sin responsable',
                'laboratorio' => $prueba->laboratorio ?? 'No especificado',
                'valor' => $prueba->valor ?? 'N/A',
                'especificacion' => $prueba->especificacion ?? 'N/A',
                'norma' => $prueba->norma ?? 'N/A',
                'observaciones' => $prueba->observaciones ?? 'Sin observaciones',
                'certificado_path' => $prueba->certificado_path,
                'no_conformidad' => $prueba->noConformidad ? [
                    'no_nc' => $prueba->noConformidad->no_nc,
                    'estado' => $prueba->noConformidad->estado
                ] : null
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en pruebaDetalle: ' . $e->getMessage());
            return response()->json([
                'error' => 'Prueba no encontrada'
            ], 404);
        }
    }

    /**
     * Obtener detalle de una no conformidad
     */
    public function ncDetalle($noNc)
    {
        try {
            $nc = NoConformidad::with(['proyecto', 'responsable', 'prueba', 'creador', 'cerradoPor'])
                ->where('no_nc', $noNc)
                ->firstOrFail();
            
            return response()->json([
                'no_nc' => $nc->no_nc,
                'proyecto' => $nc->proyecto->nombre ?? 'Sin proyecto',
                'descripcion' => $nc->descripcion,
                'fecha_deteccion' => $nc->fecha_deteccion ? $nc->fecha_deteccion->format('d/m/Y') : 'N/A',
                'fecha_limite' => $nc->fecha_limite ? $nc->fecha_limite->format('d/m/Y') : 'N/A',
                'gravedad' => $nc->gravedad,
                'responsable' => $nc->responsable ? 
                    trim($nc->responsable->nombre . ' ' . ($nc->responsable->apellido_paterno ?? '')) : 
                    'Sin responsable',
                'estado' => $nc->estado,
                'acciones_tomadas' => $nc->acciones_tomadas ?? 'Sin acciones registradas',
                'causa_raiz' => $nc->causa_raiz ?? 'No identificada',
                'prueba_relacionada' => $nc->prueba ? $nc->prueba->no_prueba : null,
                'fecha_cierre' => $nc->fecha_cierre ? $nc->fecha_cierre->format('d/m/Y H:i') : null,
                'dias_deteccion' => $nc->dias_desde_deteccion ?? 0,
                'dias_restantes' => $nc->dias_restantes ?? 0,
                'documento_path' => $nc->documento_path
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en ncDetalle: ' . $e->getMessage());
            return response()->json([
                'error' => 'No conformidad no encontrada'
            ], 404);
        }
    }

    /**
     * Guardar una nueva prueba de calidad
     */
    public function storePrueba(Request $request)
    {
        try {
            $validated = $request->validate([
                'proyecto_id' => 'required|exists:proyectos,id',
                'tipo_prueba' => 'required|string|max:100',
                'elemento' => 'required|string|max:255',
                'fecha' => 'required|date',
                'resultado' => 'required|in:Aprobada,Rechazada,Pendiente',
                'responsable_id' => 'required|exists:plantillas,plantilla_id',
                'laboratorio' => 'nullable|string|max:100',
                'valor' => 'nullable|string|max:50',
                'especificacion' => 'nullable|string|max:50',
                'norma' => 'nullable|string|max:50',
                'observaciones' => 'nullable|string'
            ]);
            
            $validated['created_by'] = auth()->id();
            $prueba = PruebaCalidad::create($validated);
            
            IndicadorCalidad::actualizarIndicadores($prueba->proyecto_id);
            
            return response()->json([
                'success' => true,
                'message' => 'Prueba guardada correctamente',
                'data' => $prueba
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al guardar prueba: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la prueba: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Guardar una nueva no conformidad
     */
    public function storeNC(Request $request)
    {
        try {
            $validated = $request->validate([
                'proyecto_id' => 'required|exists:proyectos,id',
                'descripcion' => 'required|string',
                'fecha_deteccion' => 'required|date',
                'gravedad' => 'required|in:Alta,Media,Baja',
                'responsable_id' => 'required|exists:plantillas,plantilla_id',
                'fecha_limite' => 'nullable|date|after:fecha_deteccion',
                'prueba_id' => 'nullable|exists:pruebas_calidad,id',
                'acciones_tomadas' => 'nullable|string',
                'causa_raiz' => 'nullable|string'
            ]);
            
            $validated['created_by'] = auth()->id();
            
            if (empty($validated['fecha_limite'])) {
                $validated['fecha_limite'] = now()->addDays(15);
            }
            
            $nc = NoConformidad::create($validated);
            
            IndicadorCalidad::actualizarIndicadores($nc->proyecto_id);
            
            return response()->json([
                'success' => true,
                'message' => 'No conformidad registrada correctamente',
                'data' => $nc
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al guardar NC: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la no conformidad: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cerrar una no conformidad
     */
    public function cerrarNC($noNc, Request $request)
    {
        try {
            $nc = NoConformidad::where('no_nc', $noNc)->firstOrFail();
            
            $nc->estado = 'Cerrada';
            $nc->cerrado_por = auth()->id();
            $nc->fecha_cierre = now();
            $nc->save();
            
            IndicadorCalidad::actualizarIndicadores($nc->proyecto_id);
            
            return response()->json([
                'success' => true,
                'message' => 'No conformidad cerrada correctamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al cerrar NC: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cerrar la no conformidad'
            ], 500);
        }
    }

    /**
     * Exportar a Excel
     */
    public function exportarExcel(Request $request)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Exportación en proceso'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en exportarExcel: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar a Excel'
            ], 500);
        }
    }

    /**
     * Generar reporte PDF
     */
    public function reportePdf(Request $request)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Reporte en proceso'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en reportePdf: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el reporte PDF'
            ], 500);
        }
    }

    // ════════════════════════════════════════════════════════════════
    // MÉTODOS AUXILIARES PRIVADOS
    // ════════════════════════════════════════════════════════════════

    private function calcularIndiceCalidad($proyectoId)
    {
        $total = PruebaCalidad::where('proyecto_id', $proyectoId)->count();
        if ($total === 0) return 0;
        
        $aprobadas = PruebaCalidad::where('proyecto_id', $proyectoId)
            ->where('resultado', 'Aprobada')
            ->count();
        
        $base = ($aprobadas / $total) * 100;
        
        $ncAbiertas = NoConformidad::where('proyecto_id', $proyectoId)
            ->where('estado', 'En proceso')
            ->count();
        
        $penalizacion = min($ncAbiertas * 2, 20);
        $rechazadas = $total - $aprobadas;
        $penalizacionRechazos = min(($rechazadas / $total) * 5, 10);
        
        return max($base - $penalizacion - $penalizacionRechazos, 0);
    }

    private function calcularTendencia($proyectoId)
    {
        $ultimos = PruebaCalidad::where('proyecto_id', $proyectoId)
            ->orderBy('fecha', 'desc')
            ->take(10)
            ->get();
        
        if ($ultimos->count() < 4) {
            return '→ 0.0%';
        }
        
        $mitad = ceil($ultimos->count() / 2);
        $primeraMitad = $ultimos->slice(0, $mitad);
        $segundaMitad = $ultimos->slice($mitad);
        
        $aprobadas1 = $primeraMitad->where('resultado', 'Aprobada')->count();
        $aprobadas2 = $segundaMitad->where('resultado', 'Aprobada')->count();
        
        $porcentaje1 = $primeraMitad->count() > 0 ? ($aprobadas1 / $primeraMitad->count()) * 100 : 0;
        $porcentaje2 = $segundaMitad->count() > 0 ? ($aprobadas2 / $segundaMitad->count()) * 100 : 0;
        
        $diferencia = round($porcentaje2 - $porcentaje1, 1);
        $signo = $diferencia > 0 ? '↑' : ($diferencia < 0 ? '↓' : '→');
        
        return $signo . ' ' . abs($diferencia) . '%';
    }

    private function getNivelCalidad($indice)
    {
        if ($indice >= 90) return 'Excelente';
        if ($indice >= 80) return 'Muy Bueno';
        if ($indice >= 70) return 'Bueno';
        if ($indice >= 60) return 'Regular';
        return 'Crítico';
    }
}