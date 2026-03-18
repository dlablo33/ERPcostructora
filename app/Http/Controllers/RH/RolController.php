<?php

namespace App\Http\Controllers\RH;

use App\Models\Rol;
use App\Models\Puesto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RH\RolRequest;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Obtener roles (solo los que no están eliminados soft delete)
            $roles = Rol::whereNull('deleted_at')->get();
            $totalRoles = $roles->count();
            $rolesActivos = $roles->where('estatus', 'Activo')->count();
            $rolesInactivos = $roles->where('estatus', 'Inactivo')->count();

            // Obtener puestos
            $puestos = Puesto::whereNull('deleted_at')->get();
            $totalPuestos = $puestos->count();
            $puestosActivos = $puestos->where('estatus', 'Activo')->count();
            $puestosInactivos = $puestos->where('estatus', 'Inactivo')->count();

            \Log::info('RolController@index - Datos cargados', [
                'roles_count' => $roles->count(),
                'puestos_count' => $puestos->count()
            ]);

            // Si es petición API
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'roles' => $roles,
                        'totalRoles' => $totalRoles,
                        'rolesActivos' => $rolesActivos,
                        'rolesInactivos' => $rolesInactivos,
                        'puestos' => $puestos,
                        'totalPuestos' => $totalPuestos,
                        'puestosActivos' => $puestosActivos,
                        'puestosInactivos' => $puestosInactivos
                    ]
                ]);
            }

            // Si es vista web
            return view('rh.catalogos.roles', compact(
                'roles', 
                'totalRoles', 
                'rolesActivos', 
                'rolesInactivos',
                'puestos',
                'totalPuestos',
                'puestosActivos',
                'puestosInactivos'
            ));

        } catch (\Exception $e) {
            \Log::error('Error en RolController@index: ' . $e->getMessage());
            
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rh.catalogos.roles-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RolRequest $request)
    {
        try {
            \Log::info('Intentando crear rol con datos:', $request->validated());
            
            $rol = Rol::create($request->validated());

            \Log::info('Rol creado exitosamente:', ['id' => $rol->id, 'folio' => $rol->folio]);

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rol creado exitosamente',
                    'data' => $rol
                ], 201);
            }

            return redirect()->route('roles.index')
                ->with('success', 'Rol creado exitosamente');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Error de validación al crear rol:', $e->errors());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            \Log::error('Error al crear rol: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el rol: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al crear el rol: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        try {
            \Log::info('Mostrando rol ID: ' . $id);
            
            $rol = Rol::find($id);
            
            if (!$rol) {
                \Log::error('Rol no encontrado con ID: ' . $id);
                
                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Rol no encontrado'
                    ], 404);
                }
                
                return abort(404, 'Rol no encontrado');
            }
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => $rol
                ]);
            }

            return view('rh.catalogos.roles-show', compact('rol'));
            
        } catch (\Exception $e) {
            \Log::error('Error al mostrar rol: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar el rol: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al cargar el rol: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rol $rol)
    {
        return view('rh.catalogos.roles-edit', compact('rol'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RolRequest $request, $id)
    {
        try {
            \Log::info('=== INICIO ACTUALIZACIÓN ROL ===');
            \Log::info('ID recibido en URL: ' . $id);
            \Log::info('Tipo de ID: ' . gettype($id));
            \Log::info('¿Es numérico? ' . (is_numeric($id) ? 'SÍ' : 'NO'));
            \Log::info('Datos recibidos:', $request->all());
            
            // Convertir a entero si es numérico
            if (is_numeric($id)) {
                $id = (int) $id;
                \Log::info('ID convertido a entero: ' . $id);
            }
            
            // Buscar el rol
            $rol = Rol::find($id);
            
            if (!$rol) {
                \Log::error('Rol no encontrado con ID: ' . $id);
                
                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Rol no encontrado'
                    ], 404);
                }
                
                return back()->with('error', 'Rol no encontrado');
            }
            
            \Log::info('Rol encontrado:', ['folio_actual' => $rol->folio]);
            
            // Actualizar el rol
            $rol->update($request->validated());

            \Log::info('Rol actualizado exitosamente');

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rol actualizado exitosamente',
                    'data' => $rol
                ]);
            }

            return redirect()->route('roles.index')
                ->with('success', 'Rol actualizado exitosamente');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Error de validación al actualizar rol:', $e->errors());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            \Log::error('Error al actualizar rol: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el rol: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al actualizar el rol: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            \Log::info('=== INICIO ELIMINACIÓN ROL ===');
            \Log::info('ID recibido: ' . $id);
            
            // Convertir a entero si es numérico
            if (is_numeric($id)) {
                $id = (int) $id;
            }
            
            // Buscar el rol manualmente
            $rol = Rol::find($id);
            
            if (!$rol) {
                \Log::error('Rol no encontrado con ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Rol no encontrado'
                ], 404);
            }
            
            \Log::info('Folio: ' . $rol->folio);
            \Log::info('Nombre: ' . $rol->nombre);
            
            // Verificar si el rol ya está eliminado (soft delete)
            if ($rol->trashed()) {
                \Log::info('El rol ya estaba eliminado (soft delete)');
                
                // Forzar eliminación física
                $rol->forceDelete();
                \Log::info('Eliminación física forzada realizada');
            } else {
                // Intentar eliminar (soft delete)
                $deleted = $rol->delete();
                \Log::info('Resultado de delete(): ' . ($deleted ? 'true' : 'false'));
            }
            
            // Verificar después de la eliminación
            $existeDespues = Rol::withTrashed()->find($id);
            \Log::info('¿Existe después? ' . ($existeDespues ? 'SÍ' : 'NO'));
            if ($existeDespues) {
                \Log::info('deleted_at: ' . $existeDespues->deleted_at);
            }
            
            \Log::info('=== FIN ELIMINACIÓN ROL ===');

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rol eliminado exitosamente'
                ]);
            }

            return redirect()->route('roles.index')
                ->with('success', 'Rol eliminado exitosamente');
            
        } catch (\Exception $e) {
            \Log::error('Error al eliminar rol: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el rol: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al eliminar el rol: ' . $e->getMessage());
        }
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        try {
            $roles = Rol::whereNull('deleted_at')
                       ->buscar($request->buscar)
                       ->get();
            
            \Log::info('Exportando roles a Excel, total: ' . $roles->count());

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Exportación en desarrollo',
                    'data' => $roles
                ]);
            }

            return back()->with('info', 'Exportación en desarrollo');
            
        } catch (\Exception $e) {
            \Log::error('Error al exportar roles: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al exportar: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al exportar: ' . $e->getMessage());
        }
    }
}