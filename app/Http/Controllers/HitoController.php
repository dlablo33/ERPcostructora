<?php

namespace App\Http\Controllers;

use App\Models\Hito;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HitoController extends Controller
{
    /**
     * Muestra la vista principal de Cronogramas y Hitos
     */
    public function index()
    {
        $proyectos = Proyecto::select('id', 'codigo', 'nombre', 'fecha_inicio', 'fecha_fin')
            ->orderBy('nombre')
            ->get();
        
        $usuarios = User::select('id', 'name')
            ->orderBy('name')
            ->get();
        
        $stats = [
            'total' => Hito::count(),
            'completados' => Hito::where('estado', 'completado')->count(),
            'en_proceso' => Hito::where('estado', 'en_proceso')->count(),
            'retrasados' => Hito::where('estado', 'retrasado')->count(),
        ];
        
        return view('proyectos.gestion.hitos', compact('proyectos', 'usuarios', 'stats'));
    }

    /**
     * Obtiene los hitos para el calendario/Gantt (AJAX)
     */
    public function getHitos(Request $request)
    {
        try {
            $query = Hito::with(['proyecto:id,codigo,nombre', 'responsable:id,name']);
            
            // Filtro por proyecto
            if ($request->proyecto_id) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            // Filtro por rango de fechas (considera fecha_fin también)
            if ($request->fecha_inicio && $request->fecha_fin) {
                $query->where(function($q) use ($request) {
                    $q->whereBetween('fecha_programada', [$request->fecha_inicio, $request->fecha_fin])
                      ->orWhereBetween('fecha_fin', [$request->fecha_inicio, $request->fecha_fin])
                      ->orWhere(function($q2) use ($request) {
                          $q2->where('fecha_programada', '<=', $request->fecha_inicio)
                             ->where('fecha_fin', '>=', $request->fecha_fin);
                      });
                });
            } elseif ($request->fecha_inicio) {
                $query->where(function($q) use ($request) {
                    $q->where('fecha_programada', '>=', $request->fecha_inicio)
                      ->orWhere('fecha_fin', '>=', $request->fecha_inicio);
                });
            } elseif ($request->fecha_fin) {
                $query->where(function($q) use ($request) {
                    $q->where('fecha_programada', '<=', $request->fecha_fin)
                      ->orWhere('fecha_fin', '<=', $request->fecha_fin);
                });
            }
            
            // Filtro por estado
            if ($request->estado) {
                $query->where('estado', $request->estado);
            }
            
            $hitos = $query->orderBy('fecha_programada')->get();
            
            // Formatear los datos para el frontend
            $hitosFormateados = $hitos->map(function($hito) {
                return [
                    'id' => $hito->id,
                    'proyecto_id' => $hito->proyecto_id,
                    'nombre' => $hito->nombre,
                    'descripcion' => $hito->descripcion,
                    'fecha_programada' => $hito->fecha_programada?->format('Y-m-d'),
                    'fecha_fin' => $hito->fecha_fin?->format('Y-m-d'),           // ← NUEVO
                    'fecha_real' => $hito->fecha_real?->format('Y-m-d'),
                    'hora' => $hito->hora,
                    'estado' => $hito->estado,
                    'prioridad' => $hito->prioridad,
                    'tipo' => $hito->tipo,
                    'responsable_id' => $hito->responsable_id,
                    'avance' => $hito->avance,
                    'es_critico' => $hito->es_critico,
                    'dias_restantes' => $hito->dias_restantes,
                    'dias_duracion' => $hito->dias_duracion,                     // ← NUEVO
                    'rango_fechas' => $hito->rango_fechas,                       // ← NUEVO
                    'esta_atrasado' => $hito->esta_atrasado,
                    'color_estado' => $hito->color_estado,
                    'icono_estado' => $hito->icono_estado,
                    'clase_estado' => $hito->clase_estado,
                    'proyecto' => $hito->proyecto ? [
                        'id' => $hito->proyecto->id,
                        'codigo' => $hito->proyecto->codigo,
                        'nombre' => $hito->proyecto->nombre
                    ] : null,
                    'responsable' => $hito->responsable ? [
                        'id' => $hito->responsable->id,
                        'name' => $hito->responsable->name
                    ] : null,
                    'nombre_proyecto' => $hito->nombre_proyecto,
                    'nombre_responsable' => $hito->nombre_responsable,
                ];
            });
            
            // Calcular estadísticas filtradas
            $stats = [
                'total' => $hitos->count(),
                'completados' => $hitos->where('estado', 'completado')->count(),
                'en_proceso' => $hitos->where('estado', 'en_proceso')->count(),
                'retrasados' => $hitos->where('estado', 'retrasado')->count(),
            ];
            
            return response()->json([
                'success' => true,
                'hitos' => $hitosFormateados,
                'stats' => $stats
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al obtener hitos: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Error al cargar los hitos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Almacena un nuevo hito
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'proyecto_id' => 'required|exists:proyectos,id',
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'fecha_programada' => 'required|date',
                'fecha_fin' => 'nullable|date|after_or_equal:fecha_programada',  // ← NUEVO
                'estado' => 'nullable|in:programado,en_proceso,completado,retrasado',
                'prioridad' => 'nullable|in:alta,media,baja',
                'responsable_id' => 'nullable|exists:users,id',
                'avance' => 'nullable|integer|min:0|max:100',
                'es_critico' => 'nullable|boolean'
            ]);

            $validated['estado'] = $validated['estado'] ?? 'programado';
            $validated['avance'] = $validated['avance'] ?? 0;

            if ($validated['avance'] >= 100) {
                $validated['estado'] = 'completado';
                $validated['fecha_real'] = now()->format('Y-m-d');
            }

            $hito = Hito::create($validated);
            $hito->load(['proyecto:id,codigo,nombre', 'responsable:id,name']);

            return response()->json([
                'success' => true,
                'message' => 'Hito creado correctamente',
                'hito' => [
                    'id' => $hito->id,
                    'nombre' => $hito->nombre,
                    'fecha_programada' => $hito->fecha_programada->format('Y-m-d'),
                    'fecha_fin' => $hito->fecha_fin?->format('Y-m-d'),           // ← NUEVO
                    'estado' => $hito->estado,
                    'avance' => $hito->avance,
                    'dias_duracion' => $hito->dias_duracion,                     // ← NUEVO
                    'color_estado' => $hito->color_estado,
                    'proyecto' => $hito->proyecto,
                    'responsable' => $hito->responsable,
                ]
            ], 201);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error al crear hito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el hito: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualiza un hito existente
     */
    public function update(Request $request, $id)
    {
        try {
            $hito = Hito::findOrFail($id);
            
            $validated = $request->validate([
                'proyecto_id' => 'required|exists:proyectos,id',
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'fecha_programada' => 'required|date',
                'fecha_fin' => 'nullable|date|after_or_equal:fecha_programada',  // ← NUEVO
                'estado' => 'nullable|in:programado,en_proceso,completado,retrasado',
                'prioridad' => 'nullable|in:alta,media,baja',
                'responsable_id' => 'nullable|exists:users,id',
                'avance' => 'nullable|integer|min:0|max:100',
                'es_critico' => 'nullable|boolean'
            ]);

            if (($validated['avance'] ?? 0) >= 100) {
                $validated['estado'] = 'completado';
                $validated['fecha_real'] = now()->format('Y-m-d');
            }

            if (($validated['estado'] ?? '') === 'completado' && !isset($validated['fecha_real'])) {
                $validated['fecha_real'] = now()->format('Y-m-d');
                $validated['avance'] = 100;
            }

            $hito->update($validated);
            $hito->load(['proyecto:id,codigo,nombre', 'responsable:id,name']);

            return response()->json([
                'success' => true,
                'message' => 'Hito actualizado correctamente',
                'hito' => [
                    'id' => $hito->id,
                    'nombre' => $hito->nombre,
                    'fecha_programada' => $hito->fecha_programada->format('Y-m-d'),
                    'fecha_fin' => $hito->fecha_fin?->format('Y-m-d'),           // ← NUEVO
                    'estado' => $hito->estado,
                    'avance' => $hito->avance,
                    'dias_duracion' => $hito->dias_duracion,                     // ← NUEVO
                    'color_estado' => $hito->color_estado,
                    'proyecto' => $hito->proyecto,
                    'responsable' => $hito->responsable,
                ]
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error al actualizar hito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el hito: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina un hito
     */
    public function destroy($id)
    {
        try {
            $hito = Hito::findOrFail($id);
            $nombre = $hito->nombre;
            $hito->delete();
            
            return response()->json([
                'success' => true,
                'message' => "Hito '{$nombre}' eliminado correctamente"
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar hito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el hito'
            ], 500);
        }
    }

    /**
     * Actualizar estado del hito (completar/reabrir)
     */
    public function cambiarEstado(Request $request, $id)
    {
        try {
            $hito = Hito::findOrFail($id);
            
            $request->validate([
                'estado' => 'required|in:programado,en_proceso,completado,retrasado',
                'avance' => 'nullable|integer|min:0|max:100'
            ]);

            $hito->estado = $request->estado;
            
            if ($request->has('avance')) {
                $hito->avance = $request->avance;
            }
            
            if ($request->estado === 'completado') {
                $hito->fecha_real = now();
                $hito->avance = 100;
            }
            
            if (in_array($request->estado, ['programado', 'en_proceso'])) {
                $hito->fecha_real = null;
            }
            
            $hito->save();

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado correctamente',
                'hito' => [
                    'id' => $hito->id,
                    'estado' => $hito->estado,
                    'avance' => $hito->avance,
                    'fecha_real' => $hito->fecha_real?->format('Y-m-d'),
                    'color_estado' => $hito->color_estado,
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al cambiar estado: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado'
            ], 500);
        }
    }

    /**
     * Obtener estadísticas para el dashboard
     */
    public function estadisticas(Request $request)
    {
        try {
            $query = Hito::query();
            
            if ($request->proyecto_id) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            $stats = [
                'total' => $query->count(),
                'completados' => (clone $query)->where('estado', 'completado')->count(),
                'en_proceso' => (clone $query)->where('estado', 'en_proceso')->count(),
                'retrasados' => (clone $query)->where('estado', 'retrasado')->count(),
                'programados' => (clone $query)->where('estado', 'programado')->count(),
                'porcentaje_avance' => round($query->avg('avance') ?? 0, 1),
                'criticos' => (clone $query)->where('es_critico', true)->count(),
            ];
            
            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas'
            ], 500);
        }
    }
}