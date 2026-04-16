<?php
// app/Http/Controllers/EstimacionesPartidaController.php

namespace App\Http\Controllers;

use App\Models\EstimacionesPartida;
use App\Models\Proyecto;
use App\Models\ProyectoPartida;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EstimacionesPartidaController extends Controller
{
    /**
     * Muestra la vista principal de estimaciones
     */
    public function index()
    {
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        $responsables = User::where('estatus', 'activo')->orderBy('name')->get();
        $partidas = ProyectoPartida::where('activa', true)->orderBy('codigo')->get();
        
        return view('proyectos.avances.estimaciones', compact('proyectos', 'responsables', 'partidas'));
    }
    
    /**
     * Vista resumida: Obtener estimaciones agrupadas por proyecto y período
     */
    public function getResumen(Request $request)
    {
        try {
            $fechaInicio = $request->get('fecha_inicio');
            $fechaFin = $request->get('fecha_fin');
            $proyectoId = $request->get('proyecto_id');
            $search = $request->get('search');
            
            $resumen = EstimacionesPartida::getResumenPorPeriodo($fechaInicio, $fechaFin, $proyectoId);
            
            if ($search) {
                $resumen = array_filter($resumen, function($item) use ($search) {
                    return stripos($item['proyecto_nombre'], $search) !== false ||
                           stripos($item['periodo'], $search) !== false;
                });
                $resumen = array_values($resumen);
            }
            
            $totalEstimaciones = count($resumen);
            $totalDevengado = array_sum(array_column($resumen, 'monto_total_devengado'));
            $totalFacturado = array_sum(array_column($resumen, 'monto_total_facturado'));
            $totalPorCobrar = array_sum(array_column($resumen, 'cuenta_por_cobrar'));
            $porcentajeCobroGlobal = $totalDevengado > 0 ? round(($totalFacturado / $totalDevengado) * 100, 2) : 0;
            
            return response()->json([
                'success' => true,
                'data' => $resumen,
                'resumen' => [
                    'total_estimaciones' => $totalEstimaciones,
                    'total_devengado' => $totalDevengado,
                    'total_facturado' => $totalFacturado,
                    'total_por_cobrar' => $totalPorCobrar,
                    'porcentaje_cobro' => $porcentajeCobroGlobal,
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getResumen: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar el resumen: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Vista detallada: Obtener todas las estimaciones con detalle por partida
     */
    public function getDetalle(Request $request)
    {
        try {
            $query = EstimacionesPartida::with(['proyecto', 'partida']);
            
            if ($request->has('proyecto_id') && $request->proyecto_id) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            if ($request->has('fecha_inicio') && $request->fecha_inicio) {
                $query->whereDate('fecha', '>=', $request->fecha_inicio);
            }
            
            if ($request->has('fecha_fin') && $request->fecha_fin) {
                $query->whereDate('fecha', '<=', $request->fecha_fin);
            }
            
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->whereHas('proyecto', function($q2) use ($search) {
                        $q2->where('nombre', 'like', "%{$search}%");
                    })->orWhereHas('partida', function($q2) use ($search) {
                        $q2->where('nombre', 'like', "%{$search}%")
                           ->orWhere('codigo', 'like', "%{$search}%");
                    });
                });
            }
            
            $estimaciones = $query->orderBy('fecha', 'desc')->get();
            
            $data = [];
            foreach ($estimaciones as $est) {
                $anterior = EstimacionesPartida::where('partida_id', $est->partida_id)
                    ->where('fecha', '<', $est->fecha)
                    ->orderBy('fecha', 'desc')
                    ->first();
                
                $avanceAnterior = $anterior ? $anterior->avance_porcentaje : 0;
                $avancePeriodo = $est->avance_porcentaje - $avanceAnterior;
                $montoDevengado = ($avancePeriodo / 100) * $est->partida->importe;
                
                $data[] = [
                    'id' => $est->id,
                    'proyecto' => $est->proyecto ? $est->proyecto->nombre : 'N/A',
                    'partida_codigo' => $est->partida ? $est->partida->codigo : 'N/A',
                    'partida_nombre' => $est->partida ? $est->partida->nombre : 'N/A',
                    'fecha' => $est->fecha,
                    'avance_porcentaje' => $est->avance_porcentaje,
                    'avance_periodo' => round($avancePeriodo, 2),
                    'cantidad_ejecutada' => $est->cantidad_ejecutada,
                    'unidad' => $est->partida ? $est->partida->unidad : '',
                    'monto_devengado' => $montoDevengado,
                    'monto_facturado' => 0,
                    'cuenta_por_cobrar' => $montoDevengado,
                    'porcentaje_cobro' => 0,
                ];
            }
            
            $totalDevengado = array_sum(array_column($data, 'monto_devengado'));
            $totalFacturado = array_sum(array_column($data, 'monto_facturado'));
            $totalPorCobrar = array_sum(array_column($data, 'cuenta_por_cobrar'));
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'total' => [
                    'devengado' => $totalDevengado,
                    'facturado' => $totalFacturado,
                    'por_cobrar' => $totalPorCobrar,
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getDetalle: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar el detalle: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
    
    /**
     * Obtener una estimación específica (para editar)
     */
    public function show($id)
    {
        try {
            $estimacion = EstimacionesPartida::with(['proyecto', 'partida', 'creador'])
                ->findOrFail($id);
            
            $anterior = $estimacion->estimacion_anterior;
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $estimacion->id,
                    'proyecto_id' => $estimacion->proyecto_id,
                    'partida_id' => $estimacion->partida_id,
                    'fecha' => $estimacion->fecha->format('Y-m-d'),
                    'periodo_inicio' => $estimacion->periodo_inicio ? $estimacion->periodo_inicio->format('Y-m-d') : null,
                    'periodo_fin' => $estimacion->periodo_fin ? $estimacion->periodo_fin->format('Y-m-d') : null,
                    'avance_porcentaje' => $estimacion->avance_porcentaje,
                    'avance_anterior' => $anterior ? $anterior->avance_porcentaje : 0,
                    'avance_periodo' => $estimacion->avance_periodo,
                    'cantidad_ejecutada' => $estimacion->cantidad_ejecutada,
                    'monto_devengado' => $estimacion->monto_devengado_periodo,
                    'observaciones' => $estimacion->observaciones,
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Estimación no encontrada'
            ], 404);
        }
    }
    
    /**
     * Crear una nueva estimación
     */
    /**
 * Crear una nueva estimación
 */
public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'proyecto_id' => 'required|exists:proyectos,id',
            'partida_id' => 'required|exists:proyecto_partidas,id',
            'fecha' => 'required|date',
            'periodo_inicio' => 'nullable|date',
            'periodo_fin' => 'nullable|date|after_or_equal:periodo_inicio',
            'avance_porcentaje' => 'required|numeric|min:0|max:100',
            'cantidad_ejecutada' => 'nullable|numeric|min:0',
            'observaciones' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        
        // Obtener la última estimación de esta partida
        $anterior = EstimacionesPartida::where('partida_id', $validated['partida_id'])
            ->orderBy('fecha', 'desc')
            ->first();
        
        // Si existe una estimación anterior, validar que el avance sea mayor
        if ($anterior) {
            if ($validated['avance_porcentaje'] < $anterior->avance_porcentaje) {
                return response()->json([
                    'success' => false,
                    'message' => "El avance no puede ser menor al anterior ({$anterior->avance_porcentaje}%). Si desea corregir, elimine la estimación anterior primero."
                ], 422);
            }
            
            // Si es igual al anterior, también es un error (no tiene sentido)
            if ($validated['avance_porcentaje'] == $anterior->avance_porcentaje) {
                return response()->json([
                    'success' => false,
                    'message' => "El avance es igual al anterior ({$anterior->avance_porcentaje}%). Registre un avance mayor o elimine la anterior."
                ], 422);
            }
        }
        
        // Si no se envió cantidad ejecutada, calcularla proporcionalmente
        $partida = ProyectoPartida::find($validated['partida_id']);
        if (!isset($validated['cantidad_ejecutada']) || $validated['cantidad_ejecutada'] === null) {
            $avanceAnterior = $anterior ? $anterior->avance_porcentaje : 0;
            $avancePeriodo = $validated['avance_porcentaje'] - $avanceAnterior;
            $validated['cantidad_ejecutada'] = ($avancePeriodo / 100) * $partida->cantidad;
        }
        
        $validated['created_by'] = auth()->id();
        
        $estimacion = EstimacionesPartida::create($validated);
        
        DB::commit();
        
        return response()->json([
            'success' => true,
            'message' => 'Estimación registrada exitosamente',
            'data' => $estimacion
        ]);
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error de validación',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error al crear estimación: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error al crear la estimación: ' . $e->getMessage()
        ], 500);
    }
}
    
    /**
     * Actualizar una estimación existente
     */
    public function update(Request $request, $id)
    {
        try {
            $estimacion = EstimacionesPartida::findOrFail($id);
            
            $validated = $request->validate([
                'proyecto_id' => 'required|exists:proyectos,id',
                'partida_id' => 'required|exists:proyecto_partidas,id',
                'fecha' => 'required|date',
                'periodo_inicio' => 'nullable|date',
                'periodo_fin' => 'nullable|date|after_or_equal:periodo_inicio',
                'avance_porcentaje' => 'required|numeric|min:0|max:100',
                'cantidad_ejecutada' => 'nullable|numeric|min:0',
                'observaciones' => 'nullable|string',
            ]);
            
            DB::beginTransaction();
            
            $anterior = EstimacionesPartida::where('partida_id', $validated['partida_id'])
                ->where('fecha', '<', $validated['fecha'])
                ->orderBy('fecha', 'desc')
                ->first();
            
            if ($anterior && $validated['avance_porcentaje'] < $anterior->avance_porcentaje) {
                return response()->json([
                    'success' => false,
                    'message' => 'El avance no puede ser menor al anterior (' . $anterior->avance_porcentaje . '%)'
                ], 422);
            }
            
            $siguiente = EstimacionesPartida::where('partida_id', $validated['partida_id'])
                ->where('fecha', '>', $validated['fecha'])
                ->orderBy('fecha', 'asc')
                ->first();
            
            if ($siguiente && $validated['avance_porcentaje'] > $siguiente->avance_porcentaje) {
                return response()->json([
                    'success' => false,
                    'message' => 'El avance no puede ser mayor al siguiente (' . $siguiente->avance_porcentaje . '%)'
                ], 422);
            }
            
            $estimacion->update($validated);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Estimación actualizada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar estimación: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la estimación: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Eliminar una estimación
     */
    public function destroy($id)
    {
        try {
            $estimacion = EstimacionesPartida::findOrFail($id);
            
            DB::beginTransaction();
            
            if ($estimacion->movimientos()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar la estimación porque tiene movimientos bancarios asociados'
                ], 422);
            }
            
            $estimacion->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Estimación eliminada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar estimación: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la estimación: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener el historial de avance de una partida (para gráficos)
     */
    public function getHistorialPartida($partidaId)
    {
        try {
            $historial = EstimacionesPartida::where('partida_id', $partidaId)
                ->orderBy('fecha', 'asc')
                ->get(['fecha', 'avance_porcentaje', 'cantidad_ejecutada']);
            
            return response()->json([
                'success' => true,
                'data' => $historial
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener proyectos para el selector
     */
    public function getProyectos()
    {
        try {
            $proyectos = Proyecto::where('status', 'activo')
                ->orderBy('codigo')
                ->get(['id', 'codigo', 'nombre']);
            
            if ($proyectos->isEmpty()) {
                $proyectos = Proyecto::orderBy('codigo')->get(['id', 'codigo', 'nombre']);
            }
            
            Log::info('Proyectos encontrados: ' . $proyectos->count());
            
            return response()->json([
                'success' => true,
                'data' => $proyectos
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getProyectos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
    
    /**
     * Obtener partidas por proyecto
     */
    public function getPartidasPorProyecto($proyectoId)
    {
        try {
            $partidas = ProyectoPartida::where('proyecto_id', $proyectoId)
                ->where('activa', true)
                ->orderBy('codigo')
                ->get(['id', 'codigo', 'nombre', 'unidad', 'cantidad', 'precio_unitario', 'importe']);
            
            return response()->json([
                'success' => true,
                'data' => $partidas
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Exportar resumen a Excel
     */
    public function exportarResumen(Request $request)
    {
        try {
            $fechaInicio = $request->get('fecha_inicio');
            $fechaFin = $request->get('fecha_fin');
            $proyectoId = $request->get('proyecto_id');
            
            $resumen = EstimacionesPartida::getResumenPorPeriodo($fechaInicio, $fechaFin, $proyectoId);
            
            $filename = "estimaciones_resumen_" . date('Y-m-d') . ".xls";
            
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            
            echo "<table border='1'>";
            echo "<thead><tr>";
            echo "<th>Proyecto</th>";
            echo "<th>Período</th>";
            echo "<th># Estimaciones</th>";
            echo "<th>Monto Devengado</th>";
            echo "<th>Monto Facturado</th>";
            echo "<th>Cuenta por Cobrar</th>";
            echo "<th>% Cobro</th>";
            echo "</tr></thead><tbody>";
            
            foreach ($resumen as $item) {
                echo "<tr>";
                echo "<td>{$item['proyecto_nombre']}</td>";
                echo "<td>{$item['periodo']}</td>";
                echo "<td>{$item['estimaciones_count']}</td>";
                echo "<td>$" . number_format($item['monto_total_devengado'], 2) . "</td>";
                echo "<td>$" . number_format($item['monto_total_facturado'], 2) . "</td>";
                echo "<td>$" . number_format($item['cuenta_por_cobrar'], 2) . "</td>";
                echo "<td>{$item['porcentaje_cobro']}%</td>";
                echo "</tr>";
            }
            
            echo "</tbody></table>";
            exit;
            
        } catch (\Exception $e) {
            Log::error('Error al exportar: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}