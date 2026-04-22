<?php

namespace App\Http\Controllers;

use App\Models\Familia;
use App\Models\Subfamilia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FamiliaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $familias = Familia::orderBy('codigo')->get();
        $subfamilias = Subfamilia::with('familia')->orderBy('codigo')->get();
        
        return view('almacen.catalogo.familias', compact('familias', 'subfamilias'));
    }
    
    /**
     * Get familias for DataTable
     */
    public function getFamilias(Request $request)
    {
        try {
            $query = Familia::query();
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('codigo', 'LIKE', "%{$search}%")
                      ->orWhere('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('descripcion', 'LIKE', "%{$search}%");
                });
            }
            
            $familias = $query->orderBy('codigo')->get();
            
            $data = $familias->map(function($familia) {
                return [
                    'id' => $familia->id,
                    'codigo' => $familia->codigo,
                    'nombre' => $familia->nombre,
                    'descripcion' => $familia->descripcion,
                    'cuenta_contable' => $familia->cuenta_contable,
                    'estatus' => $familia->estatus,
                    'subfamilias_count' => $familia->subfamilias()->count(),
                    'created_at' => $familia->created_at ? $familia->created_at->format('d/m/Y') : '',
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'total' => $data->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getFamilias: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar familias: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get subfamilias for DataTable
     */
    public function getSubfamilias(Request $request)
    {
        try {
            $query = Subfamilia::with('familia');
            
            if ($request->filled('familia_id')) {
                $query->where('familia_id', $request->familia_id);
            }
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('codigo', 'LIKE', "%{$search}%")
                      ->orWhere('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('descripcion', 'LIKE', "%{$search}%");
                });
            }
            
            $subfamilias = $query->orderBy('codigo')->get();
            
            $data = $subfamilias->map(function($subfamilia) {
                return [
                    'id' => $subfamilia->id,
                    'codigo' => $subfamilia->codigo,
                    'familia_id' => $subfamilia->familia_id,
                    'familia_nombre' => $subfamilia->familia ? $subfamilia->familia->nombre : '',
                    'familia_codigo' => $subfamilia->familia ? $subfamilia->familia->codigo : '',
                    'nombre' => $subfamilia->nombre,
                    'descripcion' => $subfamilia->descripcion,
                    'cuenta_contable' => $subfamilia->cuenta_contable,
                    'estatus' => $subfamilia->estatus,
                    'created_at' => $subfamilia->created_at ? $subfamilia->created_at->format('d/m/Y') : '',
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'total' => $data->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getSubfamilias: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar subfamilias: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Store a newly created family.
     */
    public function storeFamilia(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:100|unique:familias,nombre',
                'descripcion' => 'nullable|string',
                'cuenta_contable' => 'nullable|string|max:50',
                'estatus' => 'required|in:Activo,Inactivo'
            ]);
            
            DB::beginTransaction();
            
            $familia = Familia::create([
                'codigo' => Familia::generarCodigo(),
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'cuenta_contable' => $request->cuenta_contable,
                'estatus' => $request->estatus
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Familia creada exitosamente',
                'data' => $familia
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear familia: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al crear familia: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Store a newly created subfamily.
     */
    public function storeSubfamilia(Request $request)
    {
        try {
            $request->validate([
                'familia_id' => 'required|exists:familias,id',
                'nombre' => 'required|string|max:100',
                'descripcion' => 'nullable|string',
                'cuenta_contable' => 'nullable|string|max:50',
                'estatus' => 'required|in:Activo,Inactivo'
            ]);
            
            DB::beginTransaction();
            
            $subfamilia = Subfamilia::create([
                'codigo' => Subfamilia::generarCodigo(),
                'familia_id' => $request->familia_id,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'cuenta_contable' => $request->cuenta_contable,
                'estatus' => $request->estatus
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Subfamilia creada exitosamente',
                'data' => $subfamilia->load('familia')
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear subfamilia: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al crear subfamilia: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update family.
     */
    public function updateFamilia(Request $request, $id)
    {
        try {
            $familia = Familia::findOrFail($id);
            
            $request->validate([
                'nombre' => 'required|string|max:100|unique:familias,nombre,' . $id,
                'descripcion' => 'nullable|string',
                'cuenta_contable' => 'nullable|string|max:50',
                'estatus' => 'required|in:Activo,Inactivo'
            ]);
            
            DB::beginTransaction();
            
            $familia->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'cuenta_contable' => $request->cuenta_contable,
                'estatus' => $request->estatus
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Familia actualizada exitosamente',
                'data' => $familia
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar familia: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar familia: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update subfamily.
     */
    public function updateSubfamilia(Request $request, $id)
    {
        try {
            $subfamilia = Subfamilia::findOrFail($id);
            
            $request->validate([
                'familia_id' => 'required|exists:familias,id',
                'nombre' => 'required|string|max:100',
                'descripcion' => 'nullable|string',
                'cuenta_contable' => 'nullable|string|max:50',
                'estatus' => 'required|in:Activo,Inactivo'
            ]);
            
            DB::beginTransaction();
            
            $subfamilia->update([
                'familia_id' => $request->familia_id,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'cuenta_contable' => $request->cuenta_contable,
                'estatus' => $request->estatus
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Subfamilia actualizada exitosamente',
                'data' => $subfamilia->load('familia')
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar subfamilia: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar subfamilia: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Delete family.
     */
    public function destroyFamilia($id)
    {
        try {
            $familia = Familia::findOrFail($id);
            
            // Verificar si tiene subfamilias asociadas
            if ($familia->subfamilias()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar la familia porque tiene subfamilias asociadas'
                ], 400);
            }
            
            $familia->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Familia eliminada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar familia: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar familia: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Delete subfamily.
     */
    public function destroySubfamilia($id)
    {
        try {
            $subfamilia = Subfamilia::findOrFail($id);
            $subfamilia->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Subfamilia eliminada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar subfamilia: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar subfamilia: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get families for select dropdown.
     */
    public function getFamiliasSelect()
    {
        try {
            $familias = Familia::where('estatus', 'Activo')
                ->orderBy('nombre')
                ->get(['id', 'codigo', 'nombre']);
            
            return response()->json([
                'success' => true,
                'data' => $familias
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar familias: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Export to Excel.
     */
    public function exportarFamilias()
    {
        try {
            $familias = Familia::orderBy('codigo')->get();
            // Aquí implementarías la exportación a Excel
            return response()->json([
                'success' => true,
                'message' => 'Exportación en desarrollo',
                'total' => $familias->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function exportarSubfamilias()
    {
        try {
            $subfamilias = Subfamilia::with('familia')->orderBy('codigo')->get();
            return response()->json([
                'success' => true,
                'message' => 'Exportación en desarrollo',
                'total' => $subfamilias->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }
}