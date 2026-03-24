<?php

namespace App\Http\Controllers\RH;

use App\Models\Incidencia;
use App\Models\Plantilla;
use App\Models\CatTipoIncidencia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $incidencias = Incidencia::with(['empleado', 'tipoIncidencia'])
                ->orderBy('fecha_incidencia', 'desc')
                ->get();
            
            $tiposIncidencia = CatTipoIncidencia::activos()->get();
            $empleados = Plantilla::activos()
                ->orderBy('nombre')
                ->get(['plantilla_id', 'nombre', 'apellido_paterno', 'apellido_materno']);
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => $incidencias,
                    'tipos' => $tiposIncidencia,
                    'empleados' => $empleados
                ]);
            }
            
            return view('rh.asistencia.incidencias', compact('incidencias', 'tiposIncidencia', 'empleados'));
            
        } catch (\Exception $e) {
            Log::error('Error en IncidenciaController@index: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar los datos: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al cargar los datos: ' . $e->getMessage());
        }
    }
    
    /**
     * Get data for grid view with filters
     */
    public function getDataGrid(Request $request)
    {
        try {
            $query = Incidencia::with(['empleado', 'tipoIncidencia']);
            
            // Aplicar búsqueda
            if ($request->has('buscar') && $request->buscar) {
                $buscar = $request->buscar;
                $query->where(function($q) use ($buscar) {
                    $q->where('descripcion', 'ILIKE', "%{$buscar}%")
                      ->orWhereHas('empleado', function($sub) use ($buscar) {
                          $sub->where('nombre', 'ILIKE', "%{$buscar}%")
                               ->orWhere('apellido_paterno', 'ILIKE', "%{$buscar}%")
                               ->orWhere('apellido_materno', 'ILIKE', "%{$buscar}%");
                      })
                      ->orWhereHas('tipoIncidencia', function($sub) use ($buscar) {
                          $sub->where('nombre', 'ILIKE', "%{$buscar}%");
                      });
                });
            }
            
            // Filtro por estatus
            if ($request->has('estatus') && $request->estatus) {
                $query->where('estatus', $request->estatus);
            }
            
            // Filtro por empleado
            if ($request->has('empleado_id') && $request->empleado_id) {
                $query->where('plantilla_id', $request->empleado_id);
            }
            
            // Filtro por fechas
            if ($request->has('fecha_desde') && $request->fecha_desde) {
                $query->where('fecha_incidencia', '>=', $request->fecha_desde);
            }
            
            if ($request->has('fecha_hasta') && $request->fecha_hasta) {
                $query->where('fecha_incidencia', '<=', $request->fecha_hasta);
            }
            
            $incidencias = $query->orderBy('fecha_incidencia', 'desc')->get();
            
            return response()->json([
                'success' => true,
                'data' => $incidencias,
                'total' => $incidencias->count(),
                'pendientes' => $incidencias->where('estatus', 'Pendiente')->count(),
                'aprobadas' => $incidencias->where('estatus', 'Aprobada')->count(),
                'rechazadas' => $incidencias->where('estatus', 'Rechazada')->count(),
                'resueltas' => $incidencias->where('estatus', 'Resuelta')->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getDataGrid incidencias: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los datos: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $validated = $request->validate([
                'plantilla_id' => 'required|exists:plantillas,plantilla_id',
                'cat_tipo_incidencia_id' => 'required|exists:cat_tipos_incidencias,cat_tipo_incidencia_id',
                'fecha_incidencia' => 'required|date',
                'descripcion' => 'required|string',
                'estatus' => 'sometimes|in:Pendiente,Aprobada,Rechazada,Resuelta'
            ]);
            
            $data = $this->prepareData($request);
            $incidencia = Incidencia::create($data);
            
            DB::commit();
            
            Log::info('Incidencia creada exitosamente:', [
                'id' => $incidencia->incidencia_id,
                'empleado' => $incidencia->plantilla_id,
                'tipo' => $incidencia->cat_tipo_incidencia_id,
                'usuario' => auth()->user()->id ?? 'sistema'
            ]);
            
            if ($request->wantsJson() || $request->is('api/*')) {
                $incidencia->load(['empleado', 'tipoIncidencia']);
                return response()->json([
                    'success' => true,
                    'message' => 'Incidencia creada exitosamente',
                    'data' => $incidencia
                ], 201);
            }
            
            return redirect()->route('rh.incidencias')
                ->with('success', 'Incidencia creada exitosamente');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::warning('Error de validación al crear incidencia:', $e->errors());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear incidencia: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear la incidencia: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al crear la incidencia: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        try {
            $incidencia = Incidencia::with(['empleado', 'tipoIncidencia', 'autorizador'])
                ->findOrFail($id);
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => $incidencia
                ]);
            }
            
            return view('rh.asistencia.incidencias-show', compact('incidencia'));
            
        } catch (\Exception $e) {
            Log::error('Error al mostrar incidencia: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar la incidencia'
                ], 404);
            }
            
            return back()->with('error', 'Incidencia no encontrada');
        }
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $incidencia = Incidencia::findOrFail($id);
            
            $validated = $request->validate([
                'plantilla_id' => 'sometimes|exists:plantillas,plantilla_id',
                'cat_tipo_incidencia_id' => 'sometimes|exists:cat_tipos_incidencias,cat_tipo_incidencia_id',
                'fecha_incidencia' => 'sometimes|date',
                'descripcion' => 'sometimes|string',
                'estatus' => 'sometimes|in:Pendiente,Aprobada,Rechazada,Resuelta',
                'comentarios_resolucion' => 'nullable|string',
                'fecha_resolucion' => 'nullable|date'
            ]);
            
            // Registrar cambio de estatus para auditoría
            $estatusAnterior = $incidencia->estatus;
            $nuevoEstatus = $validated['estatus'] ?? $estatusAnterior;
            
            // Si el estatus cambió a Resuelta y no hay fecha de resolución, asignar la actual
            if ($nuevoEstatus === 'Resuelta' && empty($validated['fecha_resolucion'])) {
                $validated['fecha_resolucion'] = now()->format('Y-m-d');
            }
            
            $data = $this->prepareData($request);
            $incidencia->update($data);
            
            // Registrar log del cambio de estatus
            if ($estatusAnterior !== $nuevoEstatus) {
                Log::info('Cambio de estatus en incidencia:', [
                    'incidencia_id' => $incidencia->incidencia_id,
                    'estatus_anterior' => $estatusAnterior,
                    'nuevo_estatus' => $nuevoEstatus,
                    'usuario' => auth()->user()->id ?? 'sistema',
                    'comentarios' => $validated['comentarios_resolucion'] ?? null
                ]);
            }
            
            DB::commit();
            
            Log::info('Incidencia actualizada exitosamente:', [
                'id' => $incidencia->incidencia_id,
                'estatus' => $incidencia->estatus,
                'usuario' => auth()->user()->id ?? 'sistema'
            ]);
            
            if ($request->wantsJson() || $request->is('api/*')) {
                $incidencia->load(['empleado', 'tipoIncidencia']);
                return response()->json([
                    'success' => true,
                    'message' => 'Incidencia actualizada exitosamente',
                    'data' => $incidencia
                ]);
            }
            
            return redirect()->route('rh.incidencias')
                ->with('success', 'Incidencia actualizada exitosamente');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::warning('Error de validación al actualizar incidencia:', $e->errors());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar incidencia: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar la incidencia: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al actualizar la incidencia: ' . $e->getMessage());
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            $incidencia = Incidencia::findOrFail($id);
            $incidencia->delete();
            
            Log::info('Incidencia eliminada exitosamente:', [
                'id' => $incidencia->incidencia_id,
                'empleado' => $incidencia->plantilla_id,
                'usuario' => auth()->user()->id ?? 'sistema'
            ]);
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Incidencia eliminada exitosamente'
                ]);
            }
            
            return redirect()->route('rh.incidencias')
                ->with('success', 'Incidencia eliminada exitosamente');
                
        } catch (\Exception $e) {
            Log::error('Error al eliminar incidencia: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar la incidencia: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al eliminar la incidencia: ' . $e->getMessage());
        }
    }
    
    /**
     * Cambiar el estatus de una incidencia (método específico)
     */
    public function cambiarEstatus(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $validated = $request->validate([
                'estatus' => 'required|in:Pendiente,Aprobada,Rechazada,Resuelta',
                'comentarios_resolucion' => 'nullable|string',
                'fecha_resolucion' => 'nullable|date'
            ]);
            
            $incidencia = Incidencia::findOrFail($id);
            $estatusAnterior = $incidencia->estatus;
            
            // Preparar datos para actualizar
            $data = [
                'estatus' => $validated['estatus']
            ];
            
            if ($validated['estatus'] === 'Resuelta') {
                $data['fecha_resolucion'] = $validated['fecha_resolucion'] ?? now()->format('Y-m-d');
                if (!empty($validated['comentarios_resolucion'])) {
                    $data['comentarios_resolucion'] = $validated['comentarios_resolucion'];
                }
            }
            
            // Si se aprueba o rechaza, registrar quién lo hizo
            if (in_array($validated['estatus'], ['Aprobada', 'Rechazada'])) {
                $data['autorizado_por'] = auth()->user()->id ?? null;
                $data['fecha_autorizacion'] = now()->format('Y-m-d');
            }
            
            $incidencia->update($data);
            
            DB::commit();
            
            Log::info('Estatus de incidencia actualizado:', [
                'incidencia_id' => $incidencia->incidencia_id,
                'estatus_anterior' => $estatusAnterior,
                'nuevo_estatus' => $validated['estatus'],
                'usuario' => auth()->user()->id ?? 'sistema'
            ]);
            
            if ($request->wantsJson() || $request->is('api/*')) {
                $incidencia->load(['empleado', 'tipoIncidencia']);
                return response()->json([
                    'success' => true,
                    'message' => "Estatus actualizado a: {$validated['estatus']}",
                    'data' => $incidencia
                ]);
            }
            
            return redirect()->route('rh.incidencias')
                ->with('success', "Estatus actualizado a: {$validated['estatus']}");
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::warning('Error de validación al cambiar estatus:', $e->errors());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al cambiar estatus de incidencia: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cambiar el estatus: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al cambiar el estatus: ' . $e->getMessage());
        }
    }
    
    /**
     * Obtener estadísticas de incidencias por período
     */
    public function getEstadisticas(Request $request)
    {
        try {
            $query = Incidencia::query();
            
            // Filtro por fechas
            if ($request->has('fecha_desde') && $request->fecha_desde) {
                $query->where('fecha_incidencia', '>=', $request->fecha_desde);
            }
            
            if ($request->has('fecha_hasta') && $request->fecha_hasta) {
                $query->where('fecha_incidencia', '<=', $request->fecha_hasta);
            }
            
            $total = $query->count();
            $pendientes = (clone $query)->where('estatus', 'Pendiente')->count();
            $aprobadas = (clone $query)->where('estatus', 'Aprobada')->count();
            $rechazadas = (clone $query)->where('estatus', 'Rechazada')->count();
            $resueltas = (clone $query)->where('estatus', 'Resuelta')->count();
            
            // Incidencias por empleado (top 5)
            $porEmpleado = Incidencia::select('plantilla_id', DB::raw('count(*) as total'))
                ->with('empleado')
                ->groupBy('plantilla_id')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get()
                ->map(function($item) {
                    return [
                        'empleado' => $item->empleado->nombre_completo ?? 'N/A',
                        'total' => $item->total
                    ];
                });
            
            // Incidencias por tipo
            $porTipo = Incidencia::select('cat_tipo_incidencia_id', DB::raw('count(*) as total'))
                ->with('tipoIncidencia')
                ->groupBy('cat_tipo_incidencia_id')
                ->orderBy('total', 'desc')
                ->get()
                ->map(function($item) {
                    return [
                        'tipo' => $item->tipoIncidencia->nombre ?? 'N/A',
                        'total' => $item->total
                    ];
                });
            
            return response()->json([
                'success' => true,
                'data' => [
                    'total' => $total,
                    'pendientes' => $pendientes,
                    'aprobadas' => $aprobadas,
                    'rechazadas' => $rechazadas,
                    'resueltas' => $resueltas,
                    'por_empleado' => $porEmpleado,
                    'por_tipo' => $porTipo
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al obtener estadísticas de incidencias: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Prepare data from request
     */
    private function prepareData(Request $request)
    {
        $data = $request->all();
        
        // Limpiar campos vacíos
        foreach ($data as $key => $value) {
            if ($value === '' || $value === null) {
                $data[$key] = null;
            }
        }
        
        // Si se está resolviendo una incidencia, agregar fecha de resolución
        if (isset($data['estatus']) && $data['estatus'] === 'Resuelta' && empty($data['fecha_resolucion'])) {
            $data['fecha_resolucion'] = now()->format('Y-m-d');
        }
        
        // Si se aprueba o rechaza, registrar fecha de autorización
        if (isset($data['estatus']) && in_array($data['estatus'], ['Aprobada', 'Rechazada']) && empty($data['fecha_autorizacion'])) {
            $data['fecha_autorizacion'] = now()->format('Y-m-d');
            if (empty($data['autorizado_por'])) {
                $data['autorizado_por'] = auth()->user()->id ?? null;
            }
        }
        
        return $data;
    }
}