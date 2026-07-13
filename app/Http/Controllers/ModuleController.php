<?php
// app/Http/Controllers/ModuleController.php

namespace App\Http\Controllers;

use App\Models\ModuleConfig; // ✅ Import correcto (sin "Config/")
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Mostrar la lista de módulos
     */
    public function index()
    {
        $modules = ModuleConfig::ordered()->get();
        return view('admin.modules', compact('modules'));
    }

    /**
     * Activar/Desactivar un módulo
     */
    public function toggle(Request $request, $id)
    {
        try {
            $module = ModuleConfig::findOrFail($id);
            $module->is_enabled = !$module->is_enabled;
            $module->save();

            return response()->json([
                'success' => true,
                'message' => 'Módulo ' . ($module->is_enabled ? 'activado' : 'desactivado') . ' correctamente',
                'module' => $module
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado del módulo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar el orden de un módulo
     */
    public function updateOrder(Request $request, $id)
    {
        try {
            $request->validate([
                'order' => 'required|integer|min:0'
            ]);

            $module = ModuleConfig::findOrFail($id);
            $module->order = $request->order;
            $module->save();

            return response()->json([
                'success' => true,
                'message' => 'Orden actualizado correctamente',
                'module' => $module
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el orden: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mover un módulo hacia arriba o abajo
     */
    public function move(Request $request, $id, $direction)
    {
        try {
            $module = ModuleConfig::findOrFail($id);
            $currentOrder = $module->order;

            if ($direction === 'up') {
                $swapModule = ModuleConfig::where('order', '<', $currentOrder)
                    ->orderBy('order', 'desc')
                    ->first();
            } else {
                $swapModule = ModuleConfig::where('order', '>', $currentOrder)
                    ->orderBy('order', 'asc')
                    ->first();
            }

            if ($swapModule) {
                $tempOrder = $currentOrder;
                $module->order = $swapModule->order;
                $swapModule->order = $tempOrder;
                $module->save();
                $swapModule->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Módulo movido correctamente',
                    'modules' => ModuleConfig::ordered()->get()
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No se puede mover el módulo en esa dirección'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mover el módulo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todos los módulos (para API)
     */
    public function getAll()
    {
        try {
            $modules = ModuleConfig::ordered()->get();
            return response()->json([
                'success' => true,
                'modules' => $modules
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los módulos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener módulos por sección
     */
    public function getBySection($section)
    {
        try {
            $modules = ModuleConfig::getBySection($section);
            return response()->json([
                'success' => true,
                'modules' => $modules
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los módulos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener solo módulos activos por sección
     */
    public function getActiveBySection($section)
    {
        try {
            $modules = ModuleConfig::getActiveBySection($section);
            return response()->json([
                'success' => true,
                'modules' => $modules
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los módulos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo módulo
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:module_configs,name',
                'display_name' => 'required|string',
                'section' => 'required|string',
                'icon' => 'nullable|string',
                'route' => 'nullable|string',
                'order' => 'nullable|integer|min:0'
            ]);

            $module = ModuleConfig::create([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'icon' => $request->icon ?? 'fa-cube',
                'section' => $request->section,
                'route' => $request->route,
                'is_enabled' => true,
                'order' => $request->order ?? ModuleConfig::count()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Módulo creado correctamente',
                'module' => $module
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el módulo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un módulo
     */
    public function update(Request $request, $id)
    {
        try {
            $module = ModuleConfig::findOrFail($id);

            $request->validate([
                'display_name' => 'sometimes|string',
                'icon' => 'nullable|string',
                'route' => 'nullable|string',
                'order' => 'nullable|integer|min:0'
            ]);

            $module->update($request->only(['display_name', 'icon', 'route', 'order']));

            return response()->json([
                'success' => true,
                'message' => 'Módulo actualizado correctamente',
                'module' => $module
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el módulo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un módulo
     */
    public function destroy($id)
    {
        try {
            $module = ModuleConfig::findOrFail($id);
            $module->delete();

            return response()->json([
                'success' => true,
                'message' => 'Módulo eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el módulo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar el orden de todos los módulos a la vez
     */
    public function updateAllOrders(Request $request)
    {
        try {
            $request->validate([
                'modules' => 'required|array',
                'modules.*.id' => 'required|exists:module_configs,id',
                'modules.*.order' => 'required|integer|min:0'
            ]);

            foreach ($request->modules as $moduleData) {
                $module = ModuleConfig::find($moduleData['id']);
                if ($module) {
                    $module->order = $moduleData['order'];
                    $module->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Orden de módulos actualizado correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el orden: ' . $e->getMessage()
            ], 500);
        }
    }
}