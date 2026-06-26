<?php

namespace App\Http\Controllers;

use App\Models\Requisicion;
use App\Models\RequisicionArticulo;
use App\Models\Area;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RequisicionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    try {
        $query = Requisicion::with(['area', 'proyecto', 'articulos']);
        
        // Filtros
        if ($request->filled('estatus')) {
            $query->where('estatus', $request->estatus);
        }
        
        if ($request->filled('area_id')) {
            $query->where('area_id', $request->area_id);
        }
        
        if ($request->filled('proyecto_id')) {
            $query->where('proyecto_id', $request->proyecto_id);
        }
        
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_requerimiento', '>=', $request->fecha_inicio);
        }
        
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_requerimiento', '<=', $request->fecha_fin);
        }
        
        if ($request->filled('buscar')) {
            $query->where(function($q) use ($request) {
                $q->where('folio', 'LIKE', "%{$request->buscar}%")
                  ->orWhere('solicitante', 'LIKE', "%{$request->buscar}%");
            });
        }
        
        $requisiciones = $query->orderBy('id', 'desc')->paginate(15);
        
        // Obtener áreas y proyectos
        $areas = Area::all();
        $proyectos = Proyecto::all();
        
        // Si es una petición AJAX, devolver JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($requisiciones);
        }
        
        // Siempre devolver la vista con todas las variables
        return view('compras.requisicion.requisicion', [
            'requisiciones' => $requisiciones,
            'areas' => $areas,
            'proyectos' => $proyectos
        ]);
        
    } catch (\Exception $e) {
        Log::error('Error en RequisicionController@index: ' . $e->getMessage());
        
        // En caso de error, pasar arrays vacíos
        $requisiciones = collect([]);
        $areas = Area::all();
        $proyectos = Proyecto::all();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar requisiciones: ' . $e->getMessage()
            ], 500);
        }
        
        return view('compras.requisicion.requisicion', [
            'requisiciones' => $requisiciones,
            'areas' => $areas,
            'proyectos' => $proyectos
        ]);
    }
}

    /**
     * Generar folio automático
     */
    public function generarFolio()
    {
        try {
            $ultima = Requisicion::withTrashed()->orderBy('id', 'desc')->first();
            if ($ultima && $ultima->folio) {
                $numero = intval(substr($ultima->folio, 4)) + 1;
            } else {
                $numero = 1;
            }
            $folio = 'REQ-' . str_pad($numero, 3, '0', STR_PAD_LEFT);
            return response()->json(['folio' => $folio]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar folio: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener lista de proyectos para el select
     */
    public function getProyectos()
    {
        try {
            $proyectos = Proyecto::where('status', 'activo')->get(['id', 'nombre', 'codigo']);
            return response()->json($proyectos);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar proyectos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener lista de áreas para el select
     */
    public function getAreas()
    {
        try {
            $areas = Area::all(['id', 'nombre']);
            return response()->json($areas);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar áreas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        $request->validate([
            'fecha_requerimiento' => 'required|date',
            'solicitante' => 'required|string|max:100',
            'area_id' => 'required|exists:areas,id',
            'proyecto_id' => 'nullable|exists:proyectos,id',
            'observaciones' => 'nullable|string',
            'articulos' => 'required|array|min:1',
            'articulos.*.codigo' => 'nullable|string|max:50',
            'articulos.*.cantidad' => 'required|numeric|min:0.001',
            'articulos.*.unidad_medida' => 'required|string|max:20',
            'articulos.*.descripcion' => 'required|string|max:500',
            'articulos.*.observacion' => 'nullable|string',
            'articulos.*.pendiente' => 'boolean',
        ]);
        
        DB::beginTransaction();
        
        // Generar folio
        $ultima = Requisicion::withTrashed()->orderBy('id', 'desc')->first();
        $numero = $ultima ? intval(substr($ultima->folio, 4)) + 1 : 1;
        $folio = 'REQ-' . str_pad($numero, 3, '0', STR_PAD_LEFT);
        
        // Obtener el nombre del área
        $area = Area::find($request->area_id);
        
        // Crear requisición
        $requisicion = Requisicion::create([
            'folio' => $folio,
            'fecha_requerimiento' => $request->fecha_requerimiento,
            'estatus' => $request->estatus ?? 'Pendiente',
            'solicitante' => $request->solicitante,
            'area' => $area ? $area->nombre : null,
            'area_id' => $request->area_id,
            'proyecto_id' => $request->proyecto_id,
            'cotizadas' => 0,
            'observaciones' => $request->observaciones,
            'creado_por' => Auth::id(),
        ]);
        
        // Crear artículos
        foreach ($request->articulos as $articulo) {
            RequisicionArticulo::create([
                'requisicion_id' => $requisicion->id,
                'codigo' => $articulo['codigo'] ?? null,
                'cantidad' => $articulo['cantidad'],
                'unidad_medida' => $articulo['unidad_medida'],
                'descripcion' => $articulo['descripcion'],
                'observacion' => $articulo['observacion'] ?? null,
                'pendiente' => $articulo['pendiente'] ?? true,
                'cantidad_surtida' => 0,
            ]);
        }
        
        // ⭐⭐⭐ GENERAR TAREA AUTOMÁTICAMENTE ⭐⭐⭐
        try {
            Log::info('🔄 Intentando generar tarea para requisición', [
                'requisicion_id' => $requisicion->id,
                'folio' => $requisicion->folio
            ]);
            
            $tarea = $requisicion->generarTareaDesdeRequisicion();
            
            if ($tarea) {
                Log::info('✅ Tarea generada exitosamente desde el controlador', [
                    'requisicion_id' => $requisicion->id,
                    'tarea_id' => $tarea->id,
                    'tarea_titulo' => $tarea->title
                ]);
            } else {
                Log::warning('⚠️ No se pudo generar la tarea (retornó null)', [
                    'requisicion_id' => $requisicion->id
                ]);
            }
        } catch (\Exception $e) {
            Log::error('❌ Error al generar tarea en store(): ' . $e->getMessage(), [
                'requisicion_id' => $requisicion->id,
                'trace' => $e->getTraceAsString()
            ]);
        }
        // ⭐⭐⭐ FIN DE GENERACIÓN DE TAREA ⭐⭐⭐
        
        DB::commit();
        
        return response()->json([
            'success' => true,
            'message' => 'Requisición creada exitosamente',
            'data' => $requisicion->load('articulos', 'area', 'proyecto'),
            'tarea_generada' => isset($tarea) && $tarea ? true : false
        ]);
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error de validación',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error al crear requisición: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error al crear la requisición: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $requisicion = Requisicion::with(['area', 'proyecto', 'articulos', 'creador'])->findOrFail($id);
            return response()->json($requisicion);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Requisición no encontrada: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $requisicion = Requisicion::findOrFail($id);
            
            $request->validate([
                'fecha_requerimiento' => 'required|date',
                'solicitante' => 'required|string|max:100',
                'area_id' => 'required|exists:areas,id',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'estatus' => 'required|in:Pendiente,Activo,Cotizado,Cancelado',
                'observaciones' => 'nullable|string',
                'articulos' => 'required|array|min:1',
                'articulos.*.codigo' => 'nullable|string|max:50',
                'articulos.*.cantidad' => 'required|numeric|min:0.001',
                'articulos.*.unidad_medida' => 'required|string|max:20',
                'articulos.*.descripcion' => 'required|string|max:500',
                'articulos.*.observacion' => 'nullable|string',
                'articulos.*.pendiente' => 'boolean',
            ]);
            
            DB::beginTransaction();
            
            // Obtener el nombre del área
            $area = Area::find($request->area_id);
            
            // Actualizar requisición
            $requisicion->update([
                'fecha_requerimiento' => $request->fecha_requerimiento,
                'solicitante' => $request->solicitante,
                'area' => $area ? $area->nombre : null,
                'area_id' => $request->area_id,
                'proyecto_id' => $request->proyecto_id,
                'estatus' => $request->estatus,
                'observaciones' => $request->observaciones,
            ]);
            
            // Eliminar artículos viejos
            RequisicionArticulo::where('requisicion_id', $requisicion->id)->delete();
            
            // Crear nuevos artículos
            foreach ($request->articulos as $articulo) {
                RequisicionArticulo::create([
                    'requisicion_id' => $requisicion->id,
                    'codigo' => $articulo['codigo'] ?? null,
                    'cantidad' => $articulo['cantidad'],
                    'unidad_medida' => $articulo['unidad_medida'],
                    'descripcion' => $articulo['descripcion'],
                    'observacion' => $articulo['observacion'] ?? null,
                    'pendiente' => $articulo['pendiente'] ?? true,
                    'cantidad_surtida' => 0,
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Requisición actualizada exitosamente',
                'data' => $requisicion->load('articulos', 'area', 'proyecto')
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar requisición: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la requisición: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $requisicion = Requisicion::findOrFail($id);
            RequisicionArticulo::where('requisicion_id', $requisicion->id)->delete();
            $requisicion->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Requisición eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la requisición: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Aprobar requisición
     */
    public function aprobar($id)
{
    try {
        $requisicion = Requisicion::findOrFail($id);
        
        $requisicion->update([
            'estatus' => 'Activo',
            'aprobado_por' => Auth::id(),
            'fecha_aprobacion' => now(),
        ]);
        
        // ⭐ Actualizar tarea si existe
        try {
            $tarea = \App\Models\WorkflowTask::where('module', 'requisiciones')
                ->where('record_id', $requisicion->id)
                ->first();
            
            if ($tarea) {
                $tarea->update([
                    'status' => 'in_progress',
                    'title' => "✅ Requisición Aprobada: " . $requisicion->folio
                ]);
                
                Log::info('📝 Tarea actualizada por aprobación', [
                    'requisicion_id' => $requisicion->id,
                    'tarea_id' => $tarea->id
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error al actualizar tarea en aprobación: ' . $e->getMessage());
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Requisición aprobada exitosamente'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al aprobar: ' . $e->getMessage()
        ], 500);
    }
}
    
    /**
     * Rechazar requisición
     */
    public function rechazar(Request $request, $id)
    {
        try {
            $request->validate(['motivo_rechazo' => 'required|string']);
            
            $requisicion = Requisicion::findOrFail($id);
            
            $requisicion->update([
                'estatus' => 'Cancelado',
                'motivo_rechazo' => $request->motivo_rechazo,
                'aprobado_por' => Auth::id(),
                'fecha_aprobacion' => now(),
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Requisición rechazada'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al rechazar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Exportar a Excel
     */
    public function exportar(Request $request)
    {
        try {
            $requisiciones = Requisicion::with(['area', 'proyecto'])->get();
            
            // Aquí iría la lógica de exportación a Excel
            return response()->json([
                'success' => true,
                'message' => 'Exportación en desarrollo. Se encontraron ' . $requisiciones->count() . ' registros.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en exportación: ' . $e->getMessage()
            ], 500);
        }
    }

    
}