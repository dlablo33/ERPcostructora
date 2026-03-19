<?php

namespace App\Http\Controllers\RH;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RH\AreaRequest;

use App\Exports\AreasExport;
use Maatwebsite\Excel\Facades\Excel;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Obtener áreas (solo las que no están eliminadas soft delete)
            $areas = Area::whereNull('deleted_at')->get();
            $totalAreas = $areas->count();

            \Log::info('AreaController@index - Datos cargados', [
                'areas_count' => $areas->count()
            ]);

            // Si es petición API
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'areas' => $areas,
                        'totalAreas' => $totalAreas
                    ]
                ]);
            }

            // Si es vista web
            return view('rh.catalogos.areas', compact('areas', 'totalAreas'));

        } catch (\Exception $e) {
            \Log::error('Error en AreaController@index: ' . $e->getMessage());
            
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
    public function store(AreaRequest $request)
    {
        try {
            \Log::info('Intentando crear área con datos:', $request->validated());
            
            $area = Area::create($request->validated());

            \Log::info('Área creada exitosamente:', ['id' => $area->id, 'folio' => $area->folio]);

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Área creada exitosamente',
                    'data' => $area
                ], 201);
            }

            return redirect()->route('areas.index')
                ->with('success', 'Área creada exitosamente');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Error de validación al crear área:', $e->errors());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            \Log::error('Error al crear área: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el área: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al crear el área: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        try {
            \Log::info('Mostrando área ID: ' . $id);
            
            $area = Area::find($id);
            
            if (!$area) {
                \Log::error('Área no encontrada con ID: ' . $id);
                
                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Área no encontrada'
                    ], 404);
                }
                
                return abort(404, 'Área no encontrada');
            }
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => $area
                ]);
            }

            return view('rh.catalogos.areas-show', compact('area'));
            
        } catch (\Exception $e) {
            \Log::error('Error al mostrar área: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar el área: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al cargar el área: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AreaRequest $request, $id)
    {
        try {
            \Log::info('=== INICIO ACTUALIZACIÓN ÁREA ===');
            \Log::info('ID recibido en URL: ' . $id);
            
            // Asegurar que el ID sea un entero
            if (is_numeric($id)) {
                $id = (int) $id;
                \Log::info('ID convertido a entero: ' . $id);
            } else {
                \Log::error('ID no es numérico: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'ID de área no válido'
                ], 400);
            }
            
            // Buscar el área
            $area = Area::find($id);
            
            if (!$area) {
                \Log::error('Área no encontrada con ID: ' . $id);
                
                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Área no encontrada'
                    ], 404);
                }
                
                return back()->with('error', 'Área no encontrada');
            }
            
            \Log::info('Área encontrada:', ['folio_actual' => $area->folio]);
            
            // Actualizar el área
            $area->update($request->validated());

            \Log::info('Área actualizada exitosamente');

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Área actualizada exitosamente',
                    'data' => $area
                ]);
            }

            return redirect()->route('areas.index')
                ->with('success', 'Área actualizada exitosamente');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Error de validación al actualizar área:', $e->errors());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            \Log::error('Error al actualizar área: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el área: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al actualizar el área: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            \Log::info('=== INICIO ELIMINACIÓN ÁREA ===');
            \Log::info('ID recibido: ' . $id);
            
            if (is_numeric($id)) {
                $id = (int) $id;
            }
            
            $area = Area::find($id);
            
            if (!$area) {
                \Log::error('Área no encontrada con ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Área no encontrada'
                ], 404);
            }
            
            \Log::info('Folio: ' . $area->folio);
            \Log::info('Nombre: ' . $area->nombre);
            
            if ($area->trashed()) {
                $area->forceDelete();
                \Log::info('Eliminación física forzada realizada');
            } else {
                $deleted = $area->delete();
                \Log::info('Resultado de delete(): ' . ($deleted ? 'true' : 'false'));
            }
            
            $existeDespues = Area::withTrashed()->find($id);
            \Log::info('¿Existe después? ' . ($existeDespues ? 'SÍ' : 'NO'));
            
            \Log::info('=== FIN ELIMINACIÓN ÁREA ===');

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Área eliminada exitosamente'
                ]);
            }

            return redirect()->route('areas.index')
                ->with('success', 'Área eliminada exitosamente');
            
        } catch (\Exception $e) {
            \Log::error('Error al eliminar área: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el área: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al eliminar el área: ' . $e->getMessage());
        }
    }

  /**
 * Export to Excel
 */
public function exportExcel(Request $request)
{
    try {
        $buscar = $request->buscar;
        
        \Log::info('Exportando áreas a Excel', ['buscar' => $buscar]);
        
        $nombreArchivo = 'areas_' . date('Y-m-d_His') . '.xlsx';
        
        // Para peticiones API, devolver JSON
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Exportación completada',
                'download_url' => route('areas.export.download', ['buscar' => $buscar])
            ]);
        }
        
        // Para peticiones web, devolver el archivo directamente
        return Excel::download(new AreasExport($buscar), $nombreArchivo);
        
    } catch (\Exception $e) {
        \Log::error('Error al exportar áreas: ' . $e->getMessage());
        
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }

        return back()->with('error', 'Error al exportar: ' . $e->getMessage());
    }
}

/**
 * Download Excel file
 */
public function downloadExcel(Request $request)
{
    try {
        $buscar = $request->buscar;
        $nombreArchivo = 'areas_' . date('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new AreasExport($buscar), $nombreArchivo);
        
    } catch (\Exception $e) {
        \Log::error('Error al descargar Excel: ' . $e->getMessage());
        return back()->with('error', 'Error al descargar: ' . $e->getMessage());
    }
}
}