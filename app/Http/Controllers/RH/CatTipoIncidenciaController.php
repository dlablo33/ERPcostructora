<?php

namespace App\Http\Controllers\RH;

use App\Models\CatTipoIncidencia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CatTipoIncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $tipos = CatTipoIncidencia::activos()
                ->orderBy('nombre')
                ->get(['cat_tipo_incidencia_id', 'nombre', 'descripcion', 'clave_sat', 'afecta_nomina', 'requiere_autorizacion']);

            Log::info('Tipos de incidencia obtenidos:', ['count' => $tipos->count()]);

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => $tipos,
                    'total' => $tipos->count()
                ]);
            }

            return view('rh.catalogos.tipos-incidencias', compact('tipos'));

        } catch (\Exception $e) {
            Log::error('Error al obtener tipos de incidencia: ' . $e->getMessage());

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar los tipos de incidencia: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al cargar los datos: ' . $e->getMessage());
        }
    }

    /**
     * Get all active tipos de incidencia for select (API)
     */
    public function getActivos(Request $request)
    {
        try {
            $tipos = CatTipoIncidencia::activos()
                ->orderBy('nombre')
                ->get(['cat_tipo_incidencia_id', 'nombre', 'descripcion', 'afecta_nomina', 'requiere_autorizacion']);

            Log::info('Tipos de incidencia activos obtenidos:', ['count' => $tipos->count()]);

            return response()->json([
                'success' => true,
                'data' => $tipos,
                'total' => $tipos->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener tipos de incidencia activos: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los tipos de incidencia: ' . $e->getMessage()
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
                'nombre' => 'required|string|max:100|unique:cat_tipos_incidencias,nombre',
                'descripcion' => 'nullable|string',
                'clave_sat' => 'nullable|string|max:10',
                'afecta_nomina' => 'boolean',
                'requiere_autorizacion' => 'boolean',
                'activo' => 'boolean'
            ]);

            $tipo = CatTipoIncidencia::create([
                'nombre' => $validated['nombre'],
                'descripcion' => $validated['descripcion'] ?? null,
                'clave_sat' => $validated['clave_sat'] ?? null,
                'afecta_nomina' => $validated['afecta_nomina'] ?? false,
                'requiere_autorizacion' => $validated['requiere_autorizacion'] ?? false,
                'activo' => $validated['activo'] ?? true,
                'borrado_logico' => false
            ]);

            DB::commit();

            Log::info('Tipo de incidencia creado:', ['id' => $tipo->cat_tipo_incidencia_id, 'nombre' => $tipo->nombre]);

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tipo de incidencia creado exitosamente',
                    'data' => $tipo
                ], 201);
            }

            return redirect()->route('cat-tipos-incidencias.index')
                ->with('success', 'Tipo de incidencia creado exitosamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::warning('Error de validación al crear tipo de incidencia:', $e->errors());

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
            Log::error('Error al crear tipo de incidencia: ' . $e->getMessage());

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el tipo de incidencia: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al crear el tipo de incidencia: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        try {
            $tipo = CatTipoIncidencia::with('incidencias')->findOrFail($id);

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => $tipo
                ]);
            }

            return view('rh.catalogos.tipos-incidencias-show', compact('tipo'));

        } catch (\Exception $e) {
            Log::error('Error al mostrar tipo de incidencia: ' . $e->getMessage());

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tipo de incidencia no encontrado'
                ], 404);
            }

            return back()->with('error', 'Tipo de incidencia no encontrado');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $tipo = CatTipoIncidencia::findOrFail($id);

            $validated = $request->validate([
                'nombre' => 'required|string|max:100|unique:cat_tipos_incidencias,nombre,' . $id . ',cat_tipo_incidencia_id',
                'descripcion' => 'nullable|string',
                'clave_sat' => 'nullable|string|max:10',
                'afecta_nomina' => 'boolean',
                'requiere_autorizacion' => 'boolean',
                'activo' => 'boolean'
            ]);

            $tipo->update([
                'nombre' => $validated['nombre'],
                'descripcion' => $validated['descripcion'] ?? null,
                'clave_sat' => $validated['clave_sat'] ?? null,
                'afecta_nomina' => $validated['afecta_nomina'] ?? $tipo->afecta_nomina,
                'requiere_autorizacion' => $validated['requiere_autorizacion'] ?? $tipo->requiere_autorizacion,
                'activo' => $validated['activo'] ?? $tipo->activo
            ]);

            DB::commit();

            Log::info('Tipo de incidencia actualizado:', ['id' => $tipo->cat_tipo_incidencia_id, 'nombre' => $tipo->nombre]);

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tipo de incidencia actualizado exitosamente',
                    'data' => $tipo
                ]);
            }

            return redirect()->route('cat-tipos-incidencias.index')
                ->with('success', 'Tipo de incidencia actualizado exitosamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::warning('Error de validación al actualizar tipo de incidencia:', $e->errors());

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
            Log::error('Error al actualizar tipo de incidencia: ' . $e->getMessage());

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el tipo de incidencia: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al actualizar el tipo de incidencia: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            $tipo = CatTipoIncidencia::findOrFail($id);

            // Verificar si tiene incidencias asociadas
            if ($tipo->incidencias()->count() > 0) {
                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se puede eliminar el tipo de incidencia porque tiene incidencias asociadas'
                    ], 400);
                }
                return back()->with('error', 'No se puede eliminar porque tiene incidencias asociadas');
            }

            $tipo->delete();

            Log::info('Tipo de incidencia eliminado:', ['id' => $tipo->cat_tipo_incidencia_id, 'nombre' => $tipo->nombre]);

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tipo de incidencia eliminado exitosamente'
                ]);
            }

            return redirect()->route('cat-tipos-incidencias.index')
                ->with('success', 'Tipo de incidencia eliminado exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar tipo de incidencia: ' . $e->getMessage());

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el tipo de incidencia: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al eliminar el tipo de incidencia: ' . $e->getMessage());
        }
    }

    /**
     * Toggle active status
     */
    public function toggleActive($id, Request $request)
    {
        try {
            $tipo = CatTipoIncidencia::findOrFail($id);
            $tipo->activo = !$tipo->activo;
            $tipo->save();

            Log::info('Estado de tipo de incidencia cambiado:', [
                'id' => $tipo->cat_tipo_incidencia_id,
                'nombre' => $tipo->nombre,
                'activo' => $tipo->activo
            ]);

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => $tipo->activo ? 'Tipo de incidencia activado' : 'Tipo de incidencia desactivado',
                    'data' => $tipo
                ]);
            }

            return back()->with('success', $tipo->activo ? 'Tipo de incidencia activado' : 'Tipo de incidencia desactivado');

        } catch (\Exception $e) {
            Log::error('Error al cambiar estado del tipo de incidencia: ' . $e->getMessage());

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cambiar el estado: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al cambiar el estado: ' . $e->getMessage());
        }
    }

    /**
     * Get statistics for dashboard
     */
    public function getStats(Request $request)
    {
        try {
            $total = CatTipoIncidencia::count();
            $activos = CatTipoIncidencia::activos()->count();
            $inactivos = $total - $activos;
            $afectanNomina = CatTipoIncidencia::where('afecta_nomina', true)->count();
            $requierenAutorizacion = CatTipoIncidencia::where('requiere_autorizacion', true)->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'total' => $total,
                    'activos' => $activos,
                    'inactivos' => $inactivos,
                    'afectan_nomina' => $afectanNomina,
                    'requieren_autorizacion' => $requierenAutorizacion
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener estadísticas: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas: ' . $e->getMessage()
            ], 500);
        }
    }
}