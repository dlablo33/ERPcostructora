<?php

namespace App\Http\Controllers\RH;

use App\Models\Plantilla;
use App\Models\Area;
use App\Models\Puesto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RH\PlantillaRequest;
use App\Exports\PlantillaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class PlantillaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Obtener plantillas con el scope DataGrid
            $plantillas = Plantilla::dataGrid()->get();
            
            $totalPlantillas = $plantillas->count();
            $activos = $plantillas->whereIn('estatus', ['1', 'Activo'])->count();
            $inactivos = $plantillas->whereIn('estatus', ['0', 'Inactivo', 'Baja'])->count();

            // Obtener áreas para el select
            $areas = Area::whereNull('deleted_at')
                        ->orderBy('nombre')
                        ->get(['id', 'nombre', 'folio']);

            // Obtener puestos con sus áreas relacionadas
            $puestos = Puesto::with('area')
                            ->whereNull('deleted_at')
                            ->orderBy('nombre')
                            ->get(['id', 'nombre', 'area_id', 'folio']);

            Log::info('PlantillaController@index - Datos cargados', [
                'plantillas_count' => $plantillas->count(),
                'areas_count' => $areas->count(),
                'puestos_count' => $puestos->count()
            ]);

            // Si es petición API
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'plantillas' => $plantillas,
                        'totalPlantillas' => $totalPlantillas,
                        'activos' => $activos,
                        'inactivos' => $inactivos,
                        'areas' => $areas,
                        'puestos' => $puestos
                    ]
                ]);
            }

            // ============ CORRECCIÓN IMPORTANTE ============
            // Cambiado de 'rh.catalogos.plantilla' a 'rh.gestion.plantilla'
            return view('rh.gestion.plantilla', compact(
                'plantillas', 
                'totalPlantillas', 
                'activos', 
                'inactivos',
                'areas',
                'puestos'
            ));

        } catch (\Exception $e) {
            Log::error('Error en PlantillaController@index: ' . $e->getMessage());
            
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
     * Get all areas for select (API) - NUEVO MÉTODO
     */
    public function getAreas(Request $request)
    {
        try {
            $areas = Area::whereNull('deleted_at')
                        ->orderBy('nombre')
                        ->get(['id', 'nombre', 'folio']);

            Log::info('Áreas obtenidas vía API:', ['count' => $areas->count()]);

            return response()->json([
                'success' => true,
                'data' => $areas
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener áreas: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar áreas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlantillaRequest $request)
    {
        try {
            Log::info('Intentando crear empleado con datos:', $request->validated());
            
            $plantilla = Plantilla::create($request->validated());

            Log::info('Empleado creado exitosamente:', ['id' => $plantilla->plantilla_id]);

            if ($request->wantsJson() || $request->is('api/*')) {
                // Cargar relaciones para la respuesta
                $plantilla->load('area', 'puesto');
                
                return response()->json([
                    'success' => true,
                    'message' => 'Empleado creado exitosamente',
                    'data' => $plantilla
                ], 201);
            }

            return redirect()->route('plantilla.index')
                ->with('success', 'Empleado creado exitosamente');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Error de validación al crear empleado:', $e->errors());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            Log::error('Error al crear empleado: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el empleado: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al crear el empleado: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        try {
            Log::info('Mostrando empleado ID: ' . $id);
            
            $plantilla = Plantilla::with(['area', 'puesto'])->find($id);
            
            if (!$plantilla) {
                Log::error('Empleado no encontrado con ID: ' . $id);
                
                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Empleado no encontrado'
                    ], 404);
                }
                
                return abort(404, 'Empleado no encontrado');
            }
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => $plantilla
                ]);
            }

            return view('rh.gestion.plantilla-show', compact('plantilla'));
            
        } catch (\Exception $e) {
            Log::error('Error al mostrar empleado: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar el empleado: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al cargar el empleado: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlantillaRequest $request, $id)
    {
        try {
            Log::info('=== INICIO ACTUALIZACIÓN EMPLEADO ===');
            Log::info('ID recibido en URL: ' . $id);
            
            if (is_numeric($id)) {
                $id = (int) $id;
            }
            
            $plantilla = Plantilla::find($id);
            
            if (!$plantilla) {
                Log::error('Empleado no encontrado con ID: ' . $id);
                
                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Empleado no encontrado'
                    ], 404);
                }
                
                return back()->with('error', 'Empleado no encontrado');
            }
            
            $plantilla->update($request->validated());

            Log::info('Empleado actualizado exitosamente');

            if ($request->wantsJson() || $request->is('api/*')) {
                // Cargar relaciones para la respuesta
                $plantilla->load('area', 'puesto');
                
                return response()->json([
                    'success' => true,
                    'message' => 'Empleado actualizado exitosamente',
                    'data' => $plantilla
                ]);
            }

            return redirect()->route('plantilla.index')
                ->with('success', 'Empleado actualizado exitosamente');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Error de validación al actualizar empleado:', $e->errors());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            Log::error('Error al actualizar empleado: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el empleado: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al actualizar el empleado: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            Log::info('=== INICIO ELIMINACIÓN EMPLEADO ===');
            Log::info('ID recibido: ' . $id);
            
            if (is_numeric($id)) {
                $id = (int) $id;
            }
            
            $plantilla = Plantilla::find($id);
            
            if (!$plantilla) {
                Log::error('Empleado no encontrado con ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Empleado no encontrado'
                ], 404);
            }
            
            $plantilla->delete();

            Log::info('Empleado eliminado exitosamente');

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Empleado eliminado exitosamente'
                ]);
            }

            return redirect()->route('plantilla.index')
                ->with('success', 'Empleado eliminado exitosamente');
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar empleado: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el empleado: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al eliminar el empleado: ' . $e->getMessage());
        }
    }

    /**
     * Get data for grid view with filters
     */
    public function getDataGrid(Request $request)
    {
        try {
            $query = Plantilla::dataGrid();
            
            // Aplicar filtros
            if ($request->has('buscar') && $request->buscar) {
                $query->buscar($request->buscar);
            }
            
            if ($request->has('estatus') && $request->estatus !== '') {
                if ($request->estatus === 'Activo') {
                    $query->whereIn('estatus', ['1', 'Activo']);
                } elseif ($request->estatus === 'Inactivo') {
                    $query->whereIn('estatus', ['0', 'Inactivo', 'Baja']);
                }
            }
            
            if ($request->has('operador') && $request->operador !== '') {
                $query->where('operador', $request->operador === 'true');
            }
            
            $plantillas = $query->get();
            
            return response()->json([
                'success' => true,
                'data' => $plantillas,
                'total' => $plantillas->count(),
                'activos' => $plantillas->whereIn('estatus', ['1', 'Activo'])->count(),
                'inactivos' => $plantillas->whereIn('estatus', ['0', 'Inactivo', 'Baja'])->count(),
                'operadores' => $plantillas->where('operador', true)->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getDataGrid: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los datos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get puestos by area for dynamic select
     */
    public function getPuestosByArea(Request $request)
    {
        try {
            $areaId = $request->area_id;
            
            Log::info('Obteniendo puestos para área ID: ' . $areaId);
            
            if (!$areaId) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de área no proporcionado'
                ], 400);
            }
            
            $puestos = Puesto::where('area_id', $areaId)
                            ->whereNull('deleted_at')
                            ->where('estatus', 'Activo')
                            ->orderBy('nombre')
                            ->get(['id', 'nombre', 'folio']);

            Log::info('Puestos encontrados: ' . $puestos->count());

            return response()->json([
                'success' => true,
                'data' => $puestos
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener puestos por área: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar puestos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        try {
            $buscar = $request->buscar;
            
            Log::info('Exportando plantilla a Excel', ['buscar' => $buscar]);
            
            $nombreArchivo = 'plantilla_' . date('Y-m-d_His') . '.xlsx';
            
            // Para peticiones API, devolver JSON
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Exportación completada',
                    'download_url' => route('plantilla.export.download', ['buscar' => $buscar])
                ]);
            }
            
            // Para peticiones web, devolver el archivo directamente
            return Excel::download(new PlantillaExport($buscar), $nombreArchivo);
            
        } catch (\Exception $e) {
            Log::error('Error al exportar plantilla: ' . $e->getMessage());
            
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
            $nombreArchivo = 'plantilla_' . date('Y-m-d_His') . '.xlsx';
            
            return Excel::download(new PlantillaExport($buscar), $nombreArchivo);
            
        } catch (\Exception $e) {
            Log::error('Error al descargar Excel: ' . $e->getMessage());
            return back()->with('error', 'Error al descargar: ' . $e->getMessage());
        }
    }
}