<?php
// app/Http/Controllers/PresupuestoProyectoController.php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\ProyectoPartida;
use App\Models\EstimacionesPartida;
use App\Models\MovimientoBancario;
use App\Models\CategoriaGasto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PresupuestoProyectoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la vista principal del presupuesto
     */
    public function index(Proyecto $proyecto)
    {
        $secciones = ProyectoPartida::where('proyecto_id', $proyecto->id)
            ->where('activa', true)
            ->select('seccion')
            ->distinct()
            ->orderBy('seccion')
            ->pluck('seccion')
            ->toArray();
        
        return view('proyectos.presupuestos.presupuesto', compact('proyecto', 'secciones'));
    }

    /**
     * Obtiene los datos generales del presupuesto (reales vs presupuesto)
     */
    public function getPresupuesto(Proyecto $proyecto)
    {
        try {
            $partidas = ProyectoPartida::where('proyecto_id', $proyecto->id)
                ->where('activa', true)
                ->get();
            
            $presupuestoTotal = $partidas->sum('importe');
            
            $ejecutadoTotal = 0;
            $ejecutadoPorCategoria = [];
            $cantidadEjecutadaGlobal = 0;
            $cantidadPresupuestadaGlobal = 0;
            
            foreach ($partidas as $partida) {
                $ultimaEstimacion = EstimacionesPartida::where('partida_id', $partida->id)
                    ->orderBy('fecha', 'desc')
                    ->first();
                
                if ($ultimaEstimacion) {
                    $avanceAcumulado = min($ultimaEstimacion->avance_porcentaje, 100);
                    $montoDevengado = ($avanceAcumulado / 100) * $partida->importe;
                    
                    $ejecutadoTotal += $montoDevengado;
                    
                    $cantidadEjecutada = min($partida->estimaciones()->sum('cantidad_ejecutada'), $partida->cantidad);
                    $cantidadEjecutadaGlobal += $cantidadEjecutada;
                    $cantidadPresupuestadaGlobal += $partida->cantidad;
                    
                    $categoria = $partida->categoria;
                    if (!isset($ejecutadoPorCategoria[$categoria])) {
                        $ejecutadoPorCategoria[$categoria] = 0;
                    }
                    $ejecutadoPorCategoria[$categoria] += $montoDevengado;
                }
            }
            
            $pendienteTotal = $presupuestoTotal - $ejecutadoTotal;
            if ($pendienteTotal < 0) $pendienteTotal = 0;
            
            $avanceGlobal = $presupuestoTotal > 0 ? min(round(($ejecutadoTotal / $presupuestoTotal) * 100, 1), 100) : 0;
            
            $avanceGlobalCantidad = $cantidadPresupuestadaGlobal > 0 
                ? min(round(($cantidadEjecutadaGlobal / $cantidadPresupuestadaGlobal) * 100, 1), 100)
                : 0;
            
            $categorias = [
                'materiales' => ['nombre' => 'Materiales', 'color' => '#2378e1', 'presupuesto' => 0, 'ejecutado' => 0],
                'mano_obra' => ['nombre' => 'Mano de Obra', 'color' => '#28a745', 'presupuesto' => 0, 'ejecutado' => 0],
                'maquinaria' => ['nombre' => 'Maquinaria', 'color' => '#ffc107', 'presupuesto' => 0, 'ejecutado' => 0],
                'subcontratos' => ['nombre' => 'Subcontratos', 'color' => '#17a2b8', 'presupuesto' => 0, 'ejecutado' => 0],
                'indirectos' => ['nombre' => 'Gastos Indirectos', 'color' => '#6c757d', 'presupuesto' => 0, 'ejecutado' => 0],
            ];
            
            foreach ($partidas as $partida) {
                $categoria = $partida->categoria;
                if (isset($categorias[$categoria])) {
                    $categorias[$categoria]['presupuesto'] += $partida->importe;
                }
            }
            
            foreach ($categorias as $key => $data) {
                $categorias[$key]['ejecutado'] = $ejecutadoPorCategoria[$key] ?? 0;
                $categorias[$key]['pendiente'] = max($categorias[$key]['presupuesto'] - $categorias[$key]['ejecutado'], 0);
                $categorias[$key]['avance'] = $categorias[$key]['presupuesto'] > 0 
                    ? min(round(($categorias[$key]['ejecutado'] / $categorias[$key]['presupuesto']) * 100, 1), 100)
                    : 0;
            }
            
            $partidasActivas = $partidas->count();
            $partidasConAvance = $partidas->filter(function($p) {
                $ultima = EstimacionesPartida::where('partida_id', $p->id)->orderBy('fecha', 'desc')->first();
                return $ultima && $ultima->avance_porcentaje > 0;
            })->count();
            
            return response()->json([
                'success' => true,
                'proyecto' => [
                    'id' => $proyecto->id,
                    'codigo' => $proyecto->codigo,
                    'nombre' => $proyecto->nombre,
                    'tipo_proyecto' => $proyecto->tipo_proyecto ?? 'Construcción',
                    'cliente_nombre' => $proyecto->cliente_nombre ?? '-',
                    'cliente_rfc' => $proyecto->cliente_rfc ?? '-',
                    'ubicacion' => $proyecto->ubicacion ?? '-',
                    'fecha_inicio' => $proyecto->fecha_inicio ? $proyecto->fecha_inicio->format('d/m/Y') : '-',
                    'fecha_fin' => $proyecto->fecha_fin ? $proyecto->fecha_fin->format('d/m/Y') : '-',
                    'presupuesto_total' => $presupuestoTotal,
                    'ejecutado_total' => round($ejecutadoTotal, 2),
                    'pendiente_total' => round($pendienteTotal, 2),
                    'avance_global' => $avanceGlobal,
                    'avance_global_cantidad' => $avanceGlobalCantidad,
                    'partidas_activas' => $partidasActivas,
                    'partidas_con_avance' => $partidasConAvance,
                ],
                'categorias' => $categorias,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getPresupuesto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar el presupuesto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene la lista de partidas del proyecto con sus avances
     */
    public function getPartidas(Proyecto $proyecto, Request $request)
    {
        try {
            $query = ProyectoPartida::where('proyecto_id', $proyecto->id)
                ->where('activa', true);
            
            if ($request->has('seccion') && $request->seccion && $request->seccion !== '') {
                $query->where('seccion', $request->seccion);
            }
            
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('codigo', 'like', "%{$search}%")
                      ->orWhere('nombre', 'like', "%{$search}%");
                });
            }
            
            $query->orderBy('seccion')->orderBy('orden', 'asc')->orderBy('codigo', 'asc');
            $partidas = $query->get();
            
            $partidasArray = [];
            foreach ($partidas as $partida) {
                // Obtener avance desde estimaciones
                $avance = 0;
                $cantidadEjecutada = 0;
                $costoIncurrido = 0;
                
                // Última estimación
                $ultimaEstimacion = EstimacionesPartida::where('partida_id', $partida->id)
                    ->orderBy('fecha', 'desc')
                    ->first();
                
                if ($ultimaEstimacion) {
                    $avance = min($ultimaEstimacion->avance_porcentaje, 100);
                    $cantidadEjecutada = DB::table('estimaciones_partidas')
                        ->where('partida_id', $partida->id)
                        ->sum('cantidad_ejecutada');
                    $cantidadEjecutada = min($cantidadEjecutada, $partida->cantidad);
                }
                
                // Costo incurrido desde movimientos bancarios (ahora con partida_id)
                $costoIncurrido = DB::table('movimientos_bancarios')
                    ->where('partida_id', $partida->id)
                    ->where('tipo', 'egreso')
                    ->where('status', 'aplicado')
                    ->sum('monto');
                
                $ejecutado = ($avance / 100) * $partida->importe;
                $pendiente = max($partida->importe - $ejecutado, 0);
                
                // Calcular índice de rendimiento
                $indiceRendimiento = 0;
                if ($avance > 0 && $costoIncurrido > 0) {
                    $avanceFinanciero = ($costoIncurrido / $partida->importe) * 100;
                    $indiceRendimiento = $avanceFinanciero > 0 ? round($avance / $avanceFinanciero, 2) : 0;
                }
                
                $partidasArray[] = [
                    'id' => $partida->id,
                    'codigo' => $partida->codigo,
                    'nombre' => $partida->nombre,
                    'descripcion' => $partida->descripcion,
                    'seccion' => $partida->seccion ?? 'Sin sección',
                    'categoria' => $partida->categoria,
                    'categoria_nombre' => $partida->categoria_nombre,
                    'unidad' => $partida->unidad,
                    'cantidad' => floatval($partida->cantidad),
                    'cantidad_ejecutada' => round($cantidadEjecutada, 2),
                    'precio_unitario' => floatval($partida->precio_unitario),
                    'importe' => $partida->importe,
                    'ejecutado' => round($ejecutado, 2),
                    'pendiente' => round($pendiente, 2),
                    'avance' => $avance,
                    'costo_incurrido' => round($costoIncurrido, 2),
                    'indice_rendimiento' => $indiceRendimiento,
                ];
            }
            
            return response()->json([
                'success' => true,
                'data' => $partidasArray,
                'total' => count($partidasArray),
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getPartidas: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar las partidas: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Obtiene las partidas de una sección específica
     */
    public function getPartidasPorSeccion(Proyecto $proyecto, $seccion)
    {
        try {
            $partidas = ProyectoPartida::where('proyecto_id', $proyecto->id)
                ->where('activa', true)
                ->where('seccion', $seccion)
                ->orderBy('orden', 'asc')
                ->orderBy('codigo', 'asc')
                ->get();
            
            $partidasArray = [];
            foreach ($partidas as $partida) {
                $ultimaEstimacion = EstimacionesPartida::where('partida_id', $partida->id)
                    ->orderBy('fecha', 'desc')
                    ->first();
                
                $avance = $ultimaEstimacion ? min($ultimaEstimacion->avance_porcentaje, 100) : 0;
                $ejecutado = ($avance / 100) * $partida->importe;
                $cantidadEjecutada = min($partida->estimaciones()->sum('cantidad_ejecutada'), $partida->cantidad);
                
                $partidasArray[] = [
                    'id' => $partida->id,
                    'codigo' => $partida->codigo,
                    'nombre' => $partida->nombre,
                    'categoria_nombre' => $partida->categoria_nombre,
                    'unidad' => $partida->unidad,
                    'cantidad' => floatval($partida->cantidad),
                    'cantidad_ejecutada' => round($cantidadEjecutada, 2),
                    'precio_unitario' => floatval($partida->precio_unitario),
                    'importe' => $partida->importe,
                    'ejecutado' => round($ejecutado, 2),
                    'pendiente' => round($partida->importe - $ejecutado, 2),
                    'avance' => $avance,
                ];
            }
            
            return response()->json([
                'success' => true,
                'seccion' => $seccion,
                'data' => $partidasArray,
                'total' => count($partidasArray),
                'presupuesto_total' => collect($partidasArray)->sum('importe'),
                'ejecutado_total' => collect($partidasArray)->sum('ejecutado'),
                'avance_promedio' => collect($partidasArray)->avg('avance'),
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getPartidasPorSeccion: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar las partidas de la sección: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene el resumen del proyecto por secciones
     */
    public function getResumenPorSeccion(Proyecto $proyecto, Request $request)
    {
        try {
            $partidas = ProyectoPartida::where('proyecto_id', $proyecto->id)
                ->where('activa', true)
                ->get();
            
            $resumen = [];
            
            foreach ($partidas as $partida) {
                $seccion = $partida->seccion ?? 'Otras';
                $ultimaEstimacion = EstimacionesPartida::where('partida_id', $partida->id)
                    ->orderBy('fecha', 'desc')
                    ->first();
                
                $avance = $ultimaEstimacion ? min($ultimaEstimacion->avance_porcentaje, 100) : 0;
                $ejecutado = ($avance / 100) * $partida->importe;
                
                if (!isset($resumen[$seccion])) {
                    $resumen[$seccion] = [
                        'presupuesto' => 0,
                        'ejecutado' => 0,
                        'pendiente' => 0,
                        'partidas' => 0,
                        'avance' => 0,
                    ];
                }
                
                $resumen[$seccion]['presupuesto'] += $partida->importe;
                $resumen[$seccion]['ejecutado'] += $ejecutado;
                $resumen[$seccion]['pendiente'] += max($partida->importe - $ejecutado, 0);
                $resumen[$seccion]['partidas']++;
            }
            
            foreach ($resumen as $key => $value) {
                if ($value['presupuesto'] > 0) {
                    $resumen[$key]['avance'] = min(round(($value['ejecutado'] / $value['presupuesto']) * 100, 1), 100);
                }
            }
            
            return response()->json([
                'success' => true,
                'data' => $resumen
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getResumenPorSeccion: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene el resumen del proyecto por categorías
     */
    public function getResumenPorCategoria(Proyecto $proyecto)
    {
        try {
            $resumen = ProyectoPartida::getResumenPorCategoria($proyecto->id);
            return response()->json(['success' => true, 'data' => $resumen]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Almacena una nueva partida
     */
    public function storePartida(Request $request, Proyecto $proyecto)
    {
        try {
            $validated = $request->validate([
                'codigo' => 'required|string|max:50',
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'seccion' => 'nullable|string|max:100',
                'categoria' => 'required|string|in:materiales,mano_obra,maquinaria,subcontratos,indirectos',
                'unidad' => 'required|string|max:20',
                'cantidad' => 'required|numeric|min:0',
                'precio_unitario' => 'required|numeric|min:0',
                'orden' => 'nullable|integer|min:0',
            ]);
            
            DB::beginTransaction();
            
            $partida = ProyectoPartida::create([
                'proyecto_id' => $proyecto->id,
                'codigo' => $validated['codigo'],
                'nombre' => $validated['nombre'],
                'descripcion' => $validated['descripcion'] ?? null,
                'seccion' => $validated['seccion'] ?? null,
                'categoria' => $validated['categoria'],
                'unidad' => $validated['unidad'],
                'cantidad' => $validated['cantidad'],
                'precio_unitario' => $validated['precio_unitario'],
                'orden' => $validated['orden'] ?? 0,
                'activa' => true,
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Partida creada exitosamente',
                'data' => $partida
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en storePartida: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la partida: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualiza una partida existente
     */
    public function updatePartida(Request $request, Proyecto $proyecto, $partidaId)
    {
        try {
            $partida = ProyectoPartida::where('proyecto_id', $proyecto->id)
                ->findOrFail($partidaId);
            
            $validated = $request->validate([
                'codigo' => 'required|string|max:50',
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'seccion' => 'nullable|string|max:100',
                'categoria' => 'required|string|in:materiales,mano_obra,maquinaria,subcontratos,indirectos',
                'unidad' => 'required|string|max:20',
                'cantidad' => 'required|numeric|min:0',
                'precio_unitario' => 'required|numeric|min:0',
                'orden' => 'nullable|integer|min:0',
                'activa' => 'nullable|boolean',
            ]);
            
            DB::beginTransaction();
            $partida->update($validated);
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Partida actualizada exitosamente',
                'data' => $partida
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en updatePartida: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la partida: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina una partida
     */
    public function destroyPartida(Proyecto $proyecto, $partidaId)
    {
        try {
            $partida = ProyectoPartida::where('proyecto_id', $proyecto->id)
                ->findOrFail($partidaId);
            
            DB::beginTransaction();
            
            if ($partida->movimientos()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar la partida porque tiene movimientos asociados'
                ], 422);
            }
            
            if ($partida->estimaciones()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar la partida porque tiene estimaciones asociadas'
                ], 422);
            }
            
            $partida->delete();
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Partida eliminada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en destroyPartida: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la partida: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene las secciones disponibles
     */
    public function getSecciones(Proyecto $proyecto)
    {
        try {
            $secciones = ProyectoPartida::where('proyecto_id', $proyecto->id)
                ->where('activa', true)
                ->select('seccion')
                ->distinct()
                ->orderBy('seccion')
                ->pluck('seccion')
                ->toArray();
            
            return response()->json(['success' => true, 'data' => $secciones]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Obtiene las categorías disponibles
     */
    public function getCategorias()
    {
        return response()->json([
            'success' => true,
            'data' => [
                ['value' => 'materiales', 'label' => 'Materiales', 'color' => '#2378e1'],
                ['value' => 'mano_obra', 'label' => 'Mano de Obra', 'color' => '#28a745'],
                ['value' => 'maquinaria', 'label' => 'Maquinaria', 'color' => '#ffc107'],
                ['value' => 'subcontratos', 'label' => 'Subcontratos', 'color' => '#17a2b8'],
                ['value' => 'indirectos', 'label' => 'Gastos Indirectos', 'color' => '#6c757d'],
            ]
        ]);
    }

    /**
     * Obtiene una partida específica
     */
    public function getPartida(Proyecto $proyecto, $partidaId)
    {
        try {
            $partida = ProyectoPartida::where('proyecto_id', $proyecto->id)
                ->findOrFail($partidaId);
            
            $ultimaEstimacion = EstimacionesPartida::where('partida_id', $partida->id)
                ->orderBy('fecha', 'desc')
                ->first();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $partida->id,
                    'codigo' => $partida->codigo,
                    'nombre' => $partida->nombre,
                    'descripcion' => $partida->descripcion,
                    'seccion' => $partida->seccion,
                    'categoria' => $partida->categoria,
                    'categoria_nombre' => $partida->categoria_nombre,
                    'unidad' => $partida->unidad,
                    'cantidad' => floatval($partida->cantidad),
                    'precio_unitario' => floatval($partida->precio_unitario),
                    'importe' => $partida->importe,
                    'orden' => $partida->orden,
                    'activa' => $partida->activa,
                    'avance_actual' => $ultimaEstimacion ? min($ultimaEstimacion->avance_porcentaje, 100) : 0,
                    'cantidad_ejecutada' => min($partida->estimaciones()->sum('cantidad_ejecutada'), $partida->cantidad),
                    'monto_devengado' => $ultimaEstimacion ? (min($ultimaEstimacion->avance_porcentaje, 100) / 100) * $partida->importe : 0,
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Partida no encontrada'], 404);
        }
    }

    /**
     * Exporta el presupuesto a Excel
     */
    public function exportarExcel(Proyecto $proyecto)
    {
        try {
            $partidas = ProyectoPartida::where('proyecto_id', $proyecto->id)
                ->where('activa', true)
                ->orderBy('seccion')
                ->orderBy('orden')
                ->get();
            
            $filename = "presupuesto_{$proyecto->codigo}_" . date('Y-m-d') . ".xls";
            
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            
            echo "<table border='1'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Sección</th>";
            echo "<th>Código</th>";
            echo "<th>Partida</th>";
            echo "<th>Categoría</th>";
            echo "<th>Unidad</th>";
            echo "<th>Cantidad Presupuestada</th>";
            echo "<th>Cantidad Ejecutada</th>";
            echo "<th>P.U.</th>";
            echo "<th>Presupuesto</th>";
            echo "<th>Avance %</th>";
            echo "<th>Devengado</th>";
            echo "<th>Pendiente</th>";
            echo "</table>";
            echo "</thead>";
            echo "<tbody>";
            
            foreach ($partidas as $partida) {
                $ultimaEstimacion = EstimacionesPartida::where('partida_id', $partida->id)
                    ->orderBy('fecha', 'desc')
                    ->first();
                
                $avance = $ultimaEstimacion ? min($ultimaEstimacion->avance_porcentaje, 100) : 0;
                $ejecutado = ($avance / 100) * $partida->importe;
                $cantidadEjecutada = min($partida->estimaciones()->sum('cantidad_ejecutada'), $partida->cantidad);
                
                echo "<tr>";
                echo "<td>{$partida->seccion}</td>";
                echo "<td>{$partida->codigo}</td>";
                echo "<td>{$partida->nombre}</td>";
                echo "<td>{$partida->categoria_nombre}</td>";
                echo "<td>{$partida->unidad}</td>";
                echo "<td>" . number_format($partida->cantidad, 2) . "</td>";
                echo "<td>" . number_format($cantidadEjecutada, 2) . "</td>";
                echo "<td>$" . number_format($partida->precio_unitario, 2) . "</td>";
                echo "<td>$" . number_format($partida->importe, 2) . "</td>";
                echo "<td>{$avance}%</span></td>";
                echo "<td>$" . number_format($ejecutado, 2) . "</td>";
                echo "<td>$" . number_format($partida->importe - $ejecutado, 2) . "</td>";
                echo "</tr>";
            }
            
            echo "</tbody>";
            echo "</table>";
            exit;
            
        } catch (\Exception $e) {
            Log::error('Error en exportarExcel: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}