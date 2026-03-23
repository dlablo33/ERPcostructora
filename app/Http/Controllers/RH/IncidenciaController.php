<?php
// app/Http/Controllers/RH/IncidenciaController.php

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
            // Obtener incidencias con relaciones
            $incidencias = Incidencia::with(['empleado', 'tipoIncidencia'])
                ->orderBy('fecha_incidencia', 'desc')
                ->get();
            
            // Obtener catálogos para selects
            $tiposIncidencia = CatTipoIncidencia::activos()->get();
            $empleados = Plantilla::activos()
                ->orderBy('nombre')
                ->get(['plantilla_id', 'nombre', 'apellido_paterno', 'apellido_materno']);
            
            // Si es petición API
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => $incidencias,
                    'tipos' => $tiposIncidencia,
                    'empleados' => $empleados
                ]);
            }
            
            return view('rh.gestion.incidencias', compact('incidencias', 'tiposIncidencia', 'empleados'));
            
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $data = $this->prepareData($request);
            
            $incidencia = Incidencia::create($data);
            
            DB::commit();
            
            Log::info('Incidencia creada exitosamente:', ['id' => $incidencia->incidencia_id]);
            
            if ($request->wantsJson() || $request->is('api/*')) {
                $incidencia->load(['empleado', 'tipoIncidencia']);
                return response()->json([
                    'success' => true,
                    'message' => 'Incidencia creada exitosamente',
                    'data' => $incidencia
                ], 201);
            }
            
            return redirect()->route('incidencias.index')
                ->with('success', 'Incidencia creada exitosamente');
                
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
            
            return view('rh.gestion.incidencias-show', compact('incidencia'));
            
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
            $data = $this->prepareData($request);
            
            $incidencia->update($data);
            
            DB::commit();
            
            if ($request->wantsJson() || $request->is('api/*')) {
                $incidencia->load(['empleado', 'tipoIncidencia']);
                return response()->json([
                    'success' => true,
                    'message' => 'Incidencia actualizada exitosamente',
                    'data' => $incidencia
                ]);
            }
            
            return redirect()->route('incidencias.index')
                ->with('success', 'Incidencia actualizada exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar incidencia: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar la incidencia'
                ], 500);
            }
            
            return back()->with('error', 'Error al actualizar la incidencia');
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
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Incidencia eliminada exitosamente'
                ]);
            }
            
            return redirect()->route('incidencias.index')
                ->with('success', 'Incidencia eliminada exitosamente');
                
        } catch (\Exception $e) {
            Log::error('Error al eliminar incidencia: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar la incidencia'
                ], 500);
            }
            
            return back()->with('error', 'Error al eliminar la incidencia');
        }
    }
    
    /**
     * Get data for grid view with filters
     */
    public function getDataGrid(Request $request)
    {
        try {
            $query = Incidencia::with(['empleado', 'tipoIncidencia']);
            
            // Aplicar filtros
            if ($request->has('buscar') && $request->buscar) {
                $buscar = $request->buscar;
                $query->where(function($q) use ($buscar) {
                    $q->where('descripcion', 'ILIKE', "%{$buscar}%")
                      ->orWhereHas('empleado', function($sub) use ($buscar) {
                          $sub->where('nombre', 'ILIKE', "%{$buscar}%")
                               ->orWhere('apellido_paterno', 'ILIKE', "%{$buscar}%");
                      })
                      ->orWhereHas('tipoIncidencia', function($sub) use ($buscar) {
                          $sub->where('nombre', 'ILIKE', "%{$buscar}%");
                      });
                });
            }
            
            if ($request->has('estatus') && $request->estatus) {
                $query->where('estatus', $request->estatus);
            }
            
            if ($request->has('empleado_id') && $request->empleado_id) {
                $query->where('plantilla_id', $request->empleado_id);
            }
            
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
        
        return $data;
    }
}