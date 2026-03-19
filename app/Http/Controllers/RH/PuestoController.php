<?php

namespace App\Http\Controllers\RH;

use App\Models\Puesto;
use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RH\PuestoRequest;

use App\Exports\PuestosExport;
use Maatwebsite\Excel\Facades\Excel;

class PuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Obtener puestos con sus áreas relacionadas
            $puestos = Puesto::with('area')
                            ->whereNull('deleted_at')
                            ->orderBy('nombre')
                            ->get();
            
            $totalPuestos = $puestos->count();
            $puestosActivos = $puestos->where('estatus', 'Activo')->count();
            $puestosInactivos = $puestos->where('estatus', 'Inactivo')->count();

            // Obtener áreas para el filtro (si es vista web)
            $areas = Area::whereNull('deleted_at')
                        ->orderBy('nombre')
                        ->get(['id', 'nombre', 'folio']);

            \Log::info('PuestoController@index - Datos cargados', [
                'puestos_count' => $puestos->count(),
                'areas_count' => $areas->count()
            ]);

            // Si es petición API
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'puestos' => $puestos,
                        'totalPuestos' => $totalPuestos,
                        'puestosActivos' => $puestosActivos,
                        'puestosInactivos' => $puestosInactivos,
                        'areas' => $areas
                    ]
                ]);
            }

            // Si es vista web
            return view('rh.catalogos.puestos', compact(
                'puestos', 
                'totalPuestos', 
                'puestosActivos', 
                'puestosInactivos',
                'areas'
            ));

        } catch (\Exception $e) {
            \Log::error('Error en PuestoController@index: ' . $e->getMessage());
            
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
     * Get puestos by area (for API/AJAX)
     */
    public function getByArea(Request $request)
    {
        try {
            $areaId = $request->area_id;
            
            $puestos = Puesto::whereNull('deleted_at')
                            ->when($areaId, function($query) use ($areaId) {
                                return $query->where('area_id', $areaId);
                            })
                            ->orderBy('nombre')
                            ->get(['id', 'nombre', 'folio', 'area_id']);

            return response()->json([
                'success' => true,
                'data' => $puestos
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al obtener puestos por área: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar puestos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PuestoRequest $request)
    {
        try {
            \Log::info('Intentando crear puesto con datos:', $request->validated());
            
            $puesto = Puesto::create($request->validated());

            \Log::info('Puesto creado exitosamente:', [
                'id' => $puesto->id, 
                'folio' => $puesto->folio,
                'area_id' => $puesto->area_id
            ]);

            if ($request->wantsJson() || $request->is('api/*')) {
                // Cargar la relación con área para la respuesta
                $puesto->load('area');
                
                return response()->json([
                    'success' => true,
                    'message' => 'Puesto creado exitosamente',
                    'data' => $puesto
                ], 201);
            }

            return redirect()->route('puestos.index')
                ->with('success', 'Puesto creado exitosamente');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Error de validación al crear puesto:', $e->errors());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            \Log::error('Error al crear puesto: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el puesto: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al crear el puesto: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        try {
            \Log::info('Mostrando puesto ID: ' . $id);
            
            $puesto = Puesto::with('area')->find($id);
            
            if (!$puesto) {
                \Log::error('Puesto no encontrado con ID: ' . $id);
                
                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Puesto no encontrado'
                    ], 404);
                }
                
                return abort(404, 'Puesto no encontrado');
            }
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => $puesto
                ]);
            }

            return view('rh.catalogos.puestos-show', compact('puesto'));
            
        } catch (\Exception $e) {
            \Log::error('Error al mostrar puesto: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar el puesto: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al cargar el puesto: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PuestoRequest $request, $id)
    {
        try {
            \Log::info('=== INICIO ACTUALIZACIÓN PUESTO ===');
            \Log::info('ID recibido en URL: ' . $id);
            
            // Asegurar que el ID sea un entero
            if (is_numeric($id)) {
                $id = (int) $id;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de puesto no válido'
                ], 400);
            }
            
            // Buscar el puesto
            $puesto = Puesto::find($id);
            
            if (!$puesto) {
                \Log::error('Puesto no encontrado con ID: ' . $id);
                
                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Puesto no encontrado'
                    ], 404);
                }
                
                return back()->with('error', 'Puesto no encontrado');
            }
            
            \Log::info('Puesto encontrado:', [
                'folio_actual' => $puesto->folio,
                'area_id_actual' => $puesto->area_id
            ]);
            
            // Actualizar el puesto
            $puesto->update($request->validated());

            \Log::info('Puesto actualizado exitosamente');

            if ($request->wantsJson() || $request->is('api/*')) {
                // Cargar la relación con área para la respuesta
                $puesto->load('area');
                
                return response()->json([
                    'success' => true,
                    'message' => 'Puesto actualizado exitosamente',
                    'data' => $puesto
                ]);
            }

            return redirect()->route('puestos.index')
                ->with('success', 'Puesto actualizado exitosamente');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Error de validación al actualizar puesto:', $e->errors());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            \Log::error('Error al actualizar puesto: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el puesto: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al actualizar el puesto: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            \Log::info('=== INICIO ELIMINACIÓN PUESTO ===');
            \Log::info('ID recibido: ' . $id);
            
            if (is_numeric($id)) {
                $id = (int) $id;
            }
            
            $puesto = Puesto::find($id);
            
            if (!$puesto) {
                \Log::error('Puesto no encontrado con ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Puesto no encontrado'
                ], 404);
            }
            
            \Log::info('Folio: ' . $puesto->folio);
            \Log::info('Nombre: ' . $puesto->nombre);
            
            if ($puesto->trashed()) {
                $puesto->forceDelete();
                \Log::info('Eliminación física forzada realizada');
            } else {
                $deleted = $puesto->delete();
                \Log::info('Resultado de delete(): ' . ($deleted ? 'true' : 'false'));
            }
            
            $existeDespues = Puesto::withTrashed()->find($id);
            \Log::info('¿Existe después? ' . ($existeDespues ? 'SÍ' : 'NO'));
            
            \Log::info('=== FIN ELIMINACIÓN PUESTO ===');

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Puesto eliminado exitosamente'
                ]);
            }

            return redirect()->route('puestos.index')
                ->with('success', 'Puesto eliminado exitosamente');
            
        } catch (\Exception $e) {
            \Log::error('Error al eliminar puesto: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el puesto: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al eliminar el puesto: ' . $e->getMessage());
        }
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        try {
            $buscar = $request->buscar;
            
            \Log::info('Exportando puestos a Excel', ['buscar' => $buscar]);
            
            $nombreArchivo = 'puestos_' . date('Y-m-d_His') . '.xlsx';
            
            // Para peticiones API, devolver JSON
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Exportación completada',
                    'download_url' => route('puestos.export.download', ['buscar' => $buscar])
                ]);
            }
            
            // Para peticiones web, devolver el archivo directamente
            return Excel::download(new PuestosExport($buscar), $nombreArchivo);
            
        } catch (\Exception $e) {
            \Log::error('Error al exportar puestos: ' . $e->getMessage());
            
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
     * Download Excel file for Puestos
     */
    public function downloadExcel(Request $request)
    {
        try {
            $buscar = $request->buscar;
            $nombreArchivo = 'puestos_' . date('Y-m-d_His') . '.xlsx';
            
            return Excel::download(new PuestosExport($buscar), $nombreArchivo);
            
        } catch (\Exception $e) {
            \Log::error('Error al descargar Excel: ' . $e->getMessage());
            return back()->with('error', 'Error al descargar: ' . $e->getMessage());
        }
    }
}