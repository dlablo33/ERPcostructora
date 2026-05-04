<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Familia;
use App\Models\Subfamilia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $familias = Familia::where('estatus', 'Activo')->orderBy('nombre')->get();
        $subfamilias = Subfamilia::where('estatus', 'Activo')->orderBy('nombre')->get();
        
        return view('almacen.catalogo.articulos', compact('familias', 'subfamilias'));
    }
    
    /**
     * Get articulos for DataTable with pagination
     */
    public function getArticulos(Request $request)
    {
        try {
            $query = Articulo::with(['familia', 'subfamilia']);
            
            // Filtros
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('codigo', 'LIKE', "%{$search}%")
                      ->orWhere('descripcion', 'LIKE', "%{$search}%")
                      ->orWhere('numero_parte', 'LIKE', "%{$search}%")
                      ->orWhere('ubicacion', 'LIKE', "%{$search}%");
                });
            }
            
            if ($request->filled('familia_id')) {
                $query->where('familia_id', $request->familia_id);
            }
            
            if ($request->filled('subfamilia_id')) {
                $query->where('subfamilia_id', $request->subfamilia_id);
            }
            
            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }
            
            // Paginación
            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);
            
            $articulos = $query->orderBy('codigo')->paginate($perPage, ['*'], 'page', $page);
            
            $data = $articulos->getCollection()->map(function($articulo) {
                return [
                    'id' => $articulo->id,
                    'codigo' => $articulo->codigo,
                    'descripcion' => $articulo->descripcion,
                    'numero_parte' => $articulo->numero_parte,
                    'familia_id' => $articulo->familia_id,
                    'familia_nombre' => $articulo->familia ? $articulo->familia->nombre : '',
                    'subfamilia_id' => $articulo->subfamilia_id,
                    'subfamilia_nombre' => $articulo->subfamilia ? $articulo->subfamilia->nombre : '',
                    'ubicacion' => $articulo->ubicacion,
                    'minimo' => $articulo->minimo,
                    'maximo' => $articulo->maximo,
                    'punto_reorden' => $articulo->punto_reorden,
                    'unidad_medida' => $articulo->unidad_medida,
                    'cuenta_contable' => $articulo->cuenta_contable,
                    'estatus' => $articulo->estatus,
                    'created_at' => $articulo->created_at ? $articulo->created_at->format('d/m/Y') : '',
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'total' => $articulos->total(),
                'per_page' => $articulos->perPage(),
                'current_page' => $articulos->currentPage(),
                'last_page' => $articulos->lastPage()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getArticulos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar artículos: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'descripcion' => 'required|string|max:500',
                'familia_id' => 'nullable|exists:familias,id',
                'subfamilia_id' => 'nullable|exists:subfamilias,id',
                'ubicacion' => 'nullable|string|max:50',
                'minimo' => 'nullable|numeric|min:0',
                'maximo' => 'nullable|numeric|min:0',
                'punto_reorden' => 'nullable|numeric|min:0',
                'unidad_medida' => 'nullable|string|max:20',
                'cuenta_contable' => 'nullable|string|max:50',
                'estatus' => 'required|in:Activo,Inactivo'
            ]);
            
            DB::beginTransaction();
            
            $articulo = Articulo::create([
                'codigo' => Articulo::generarCodigo(),
                'descripcion' => $request->descripcion,
                'numero_parte' => $request->numero_parte,
                'familia_id' => $request->familia_id,
                'subfamilia_id' => $request->subfamilia_id,
                'ubicacion' => $request->ubicacion,
                'minimo' => $request->minimo ?? 0,
                'maximo' => $request->maximo ?? 0,
                'punto_reorden' => $request->punto_reorden ?? 0,
                'unidad_medida' => $request->unidad_medida,
                'cuenta_contable' => $request->cuenta_contable,
                'estatus' => $request->estatus
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Artículo creado exitosamente',
                'data' => $articulo->load(['familia', 'subfamilia'])
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear artículo: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al crear artículo: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $articulo = Articulo::with(['familia', 'subfamilia'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $articulo->id,
                    'codigo' => $articulo->codigo,
                    'descripcion' => $articulo->descripcion,
                    'numero_parte' => $articulo->numero_parte,
                    'familia_id' => $articulo->familia_id,
                    'familia_nombre' => $articulo->familia ? $articulo->familia->nombre : '',
                    'subfamilia_id' => $articulo->subfamilia_id,
                    'subfamilia_nombre' => $articulo->subfamilia ? $articulo->subfamilia->nombre : '',
                    'ubicacion' => $articulo->ubicacion,
                    'minimo' => $articulo->minimo,
                    'maximo' => $articulo->maximo,
                    'punto_reorden' => $articulo->punto_reorden,
                    'unidad_medida' => $articulo->unidad_medida,
                    'cuenta_contable' => $articulo->cuenta_contable,
                    'estatus' => $articulo->estatus
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Artículo no encontrado'
            ], 404);
        }
    }
    
    /**
     * Update the specified resource.
     */
    public function update(Request $request, $id)
    {
        try {
            $articulo = Articulo::findOrFail($id);
            
            $request->validate([
                'descripcion' => 'required|string|max:500',
                'familia_id' => 'nullable|exists:familias,id',
                'subfamilia_id' => 'nullable|exists:subfamilias,id',
                'ubicacion' => 'nullable|string|max:50',
                'minimo' => 'nullable|numeric|min:0',
                'maximo' => 'nullable|numeric|min:0',
                'punto_reorden' => 'nullable|numeric|min:0',
                'unidad_medida' => 'nullable|string|max:20',
                'cuenta_contable' => 'nullable|string|max:50',
                'estatus' => 'required|in:Activo,Inactivo'
            ]);
            
            DB::beginTransaction();
            
            $articulo->update([
                'descripcion' => $request->descripcion,
                'numero_parte' => $request->numero_parte,
                'familia_id' => $request->familia_id,
                'subfamilia_id' => $request->subfamilia_id,
                'ubicacion' => $request->ubicacion,
                'minimo' => $request->minimo ?? 0,
                'maximo' => $request->maximo ?? 0,
                'punto_reorden' => $request->punto_reorden ?? 0,
                'unidad_medida' => $request->unidad_medida,
                'cuenta_contable' => $request->cuenta_contable,
                'estatus' => $request->estatus
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Artículo actualizado exitosamente',
                'data' => $articulo->load(['familia', 'subfamilia'])
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar artículo: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar artículo: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Remove the specified resource.
     */
    public function destroy($id)
    {
        try {
            $articulo = Articulo::findOrFail($id);
            $articulo->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Artículo eliminado exitosamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar artículo: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar artículo: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Export to Excel
     */
    public function exportar()
    {
        try {
            $articulos = Articulo::with(['familia', 'subfamilia'])->orderBy('codigo')->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Exportación en desarrollo',
                'total' => $articulos->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get subfamilias by familia
     */
    public function getSubfamiliasByFamilia($familiaId)
    {
        try {
            $subfamilias = Subfamilia::where('familia_id', $familiaId)
                ->where('estatus', 'Activo')
                ->orderBy('nombre')
                ->get(['id', 'codigo', 'nombre']);
            
            return response()->json([
                'success' => true,
                'data' => $subfamilias
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar subfamilias'
            ], 500);
        }
    }

    /**
     * Crear artículo temporalmente (para recepción de compras)
     */
    public function crearTemporal(Request $request)
    {
        try {
            Log::info('Crear artículo temporal llamado', $request->all());
            
            $request->validate([
                'codigo' => 'required|string|max:50',
                'descripcion' => 'required|string|max:500',
                'unidad_medida' => 'nullable|string|max:20'
            ]);
            
            // Verificar si ya existe por código
            $existente = Articulo::where('codigo', $request->codigo)->first();
            
            if ($existente) {
                return response()->json([
                    'success' => true,
                    'message' => 'Artículo ya existe',
                    'data' => ['id' => $existente->id]
                ]);
            }
            
            // Crear nuevo artículo
            $articulo = Articulo::create([
                'codigo' => $request->codigo,
                'descripcion' => $request->descripcion,
                'unidad_medida' => $request->unidad_medida ?? 'Pieza',
                'estatus' => 'Activo',
                'minimo' => 0,
                'maximo' => 0,
                'punto_reorden' => 0,
                'numero_parte' => $request->codigo
            ]);
            
            Log::info('Artículo creado temporalmente', ['id' => $articulo->id, 'codigo' => $articulo->codigo]);
            
            return response()->json([
                'success' => true,
                'message' => 'Artículo creado temporalmente',
                'data' => ['id' => $articulo->id]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al crear artículo temporal: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}