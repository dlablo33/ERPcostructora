<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\CategoriaEvidencia;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class EvidenciaController extends Controller
{
    /**
     * Muestra la vista de Evidencias
     */
    public function index()
    {
        // Obtener proyectos activos para los selectores
        $proyectos = Proyecto::where('status', 'activo')
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'codigo']);
        
        // Obtener categorías de evidencia
        $categorias = CategoriaEvidencia::where('activo', true)
            ->orderBy('orden')
            ->get();
        
        // Obtener usuarios que han subido evidencias
        $usuarios = User::orderBy('name')
            ->get(['id', 'name']);
        
        return view('proyectos.documentacion.evidencia', compact(
            'proyectos',
            'categorias',
            'usuarios'
        ));
    }

    /**
     * Obtener resumen de KPIs (4 cuadros principales)
     */
    public function resumen(Request $request)
    {
        try {
            $query = Evidencia::where('estado', 'activo');
            
            // Aplicar filtro de proyecto
            if ($request->has('proyecto_id') && $request->proyecto_id) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            // Aplicar filtro de fechas
            if ($request->has('fecha_inicio') && $request->fecha_inicio) {
                $query->where('fecha', '>=', $request->fecha_inicio);
            }
            
            if ($request->has('fecha_fin') && $request->fecha_fin) {
                $query->where('fecha', '<=', $request->fecha_fin);
            }
            
            $total = $query->count();
            $fotos = (clone $query)->where('tipo', 'foto')->count();
            $actas = (clone $query)->where('tipo', 'acta')->count();
            
            // Calcular tamaño total
            $totalBytes = (clone $query)->sum('tamanio_bytes');
            $tamanioFormateado = $this->formatBytes($totalBytes);
            
            return response()->json([
                'total_evidencias' => $total,
                'total_fotos' => $fotos,
                'total_actas' => $actas,
                'total_tamanio' => $tamanioFormateado,
                'total_bytes' => $totalBytes
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en resumen evidencias: ' . $e->getMessage());
            return response()->json([
                'total_evidencias' => 0,
                'total_fotos' => 0,
                'total_actas' => 0,
                'total_tamanio' => '0 MB',
                'total_bytes' => 0
            ]);
        }
    }

    /**
     * Obtener lista de evidencias con paginación y filtros
     */
    public function listar(Request $request)
    {
        try {
            $query = Evidencia::with(['proyecto', 'categoria', 'subidoPor'])
                ->where('estado', 'activo');
            
            // Filtros
            if ($request->has('proyecto_id') && $request->proyecto_id) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            if ($request->has('tipo') && $request->tipo) {
                $query->where('tipo', $request->tipo);
            }
            
            if ($request->has('categoria_id') && $request->categoria_id) {
                $query->where('categoria_id', $request->categoria_id);
            }
            
            if ($request->has('fecha_inicio') && $request->fecha_inicio) {
                $query->where('fecha', '>=', $request->fecha_inicio);
            }
            
            if ($request->has('fecha_fin') && $request->fecha_fin) {
                $query->where('fecha', '<=', $request->fecha_fin);
            }
            
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('descripcion', 'LIKE', "%{$search}%")
                      ->orWhereHas('proyecto', function($sub) use ($search) {
                          $sub->where('nombre', 'LIKE', "%{$search}%")
                              ->orWhere('codigo', 'LIKE', "%{$search}%");
                      })
                      ->orWhereHas('categoria', function($sub) use ($search) {
                          $sub->where('nombre', 'LIKE', "%{$search}%");
                      })
                      ->orWhereHas('subidoPor', function($sub) use ($search) {
                          $sub->where('name', 'LIKE', "%{$search}%");
                      });
                });
            }
            
            // Ordenar
            $sortField = $request->sort_by ?? 'fecha';
            $sortOrder = $request->sort_order ?? 'desc';
            $query->orderBy($sortField, $sortOrder);
            
            $perPage = $request->per_page ?? 10;
            $evidencias = $query->paginate($perPage);
            
            $datos = $evidencias->map(function($evidencia) {
                return [
                    'id' => $evidencia->id,
                    'tipo' => $evidencia->tipo,
                    'tipo_icono' => $evidencia->icono,
                    'tipo_color' => $evidencia->color,
                    'nombre' => $evidencia->nombre,
                    'proyecto' => $evidencia->proyecto->nombre ?? 'Sin proyecto',
                    'proyecto_id' => $evidencia->proyecto_id,
                    'fecha' => $evidencia->fecha ? $evidencia->fecha->format('Y-m-d') : null,
                    'categoria' => $evidencia->categoria_nombre,
                    'categoria_color' => $evidencia->categoria_color,
                    'subido_por' => $evidencia->subidoPor->name ?? 'N/A',
                    'tamanio' => $evidencia->tamanio_formateado,
                    'tamanio_bytes' => $evidencia->tamanio_bytes,
                    'tipo_archivo' => $evidencia->tipo_archivo,
                    'archivo_path' => $evidencia->archivo_path,
                    'archivo_url' => $evidencia->archivo_url,
                    'miniatura_url' => $evidencia->miniatura_url,
                    'descripcion' => $evidencia->descripcion,
                    'created_at' => $evidencia->created_at ? $evidencia->created_at->format('d/m/Y H:i') : 'N/A'
                ];
            });
            
            return response()->json([
                'data' => $datos,
                'pagination' => [
                    'total' => $evidencias->total(),
                    'per_page' => $evidencias->perPage(),
                    'current_page' => $evidencias->currentPage(),
                    'last_page' => $evidencias->lastPage()
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en listar evidencias: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'pagination' => [
                    'total' => 0,
                    'per_page' => 10,
                    'current_page' => 1,
                    'last_page' => 1
                ]
            ]);
        }
    }

    /**
     * Obtener datos para la galería
     */
    public function galeria(Request $request)
    {
        try {
            $query = Evidencia::with(['proyecto', 'categoria'])
                ->where('estado', 'activo')
                ->where('tipo', 'foto'); // Solo fotos para la galería
            
            // Filtros
            if ($request->has('proyecto_id') && $request->proyecto_id) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            if ($request->has('categoria_id') && $request->categoria_id) {
                $query->where('categoria_id', $request->categoria_id);
            }
            
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('descripcion', 'LIKE', "%{$search}%")
                      ->orWhereHas('proyecto', function($sub) use ($search) {
                          $sub->where('nombre', 'LIKE', "%{$search}%");
                      });
                });
            }
            
            $perPage = $request->per_page ?? 12;
            $evidencias = $query->orderBy('fecha', 'desc')->paginate($perPage);
            
            $datos = $evidencias->map(function($evidencia) {
                return [
                    'id' => $evidencia->id,
                    'tipo' => $evidencia->tipo,
                    'nombre' => $evidencia->nombre,
                    'proyecto' => $evidencia->proyecto->nombre ?? 'Sin proyecto',
                    'fecha' => $evidencia->fecha ? $evidencia->fecha->format('d/m/Y') : 'N/A',
                    'categoria' => $evidencia->categoria_nombre,
                    'categoria_color' => $evidencia->categoria_color,
                    'tamanio' => $evidencia->tamanio_formateado,
                    'archivo_url' => $evidencia->archivo_url,
                    'miniatura_url' => $evidencia->miniatura_url,
                    'descripcion' => $evidencia->descripcion,
                    'ancho' => $evidencia->ancho,
                    'alto' => $evidencia->alto,
                ];
            });
            
            return response()->json([
                'data' => $datos,
                'pagination' => [
                    'total' => $evidencias->total(),
                    'per_page' => $evidencias->perPage(),
                    'current_page' => $evidencias->currentPage(),
                    'last_page' => $evidencias->lastPage()
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en galeria evidencias: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'pagination' => [
                    'total' => 0,
                    'per_page' => 12,
                    'current_page' => 1,
                    'last_page' => 1
                ]
            ]);
        }
    }

    /**
     * Obtener detalle de una evidencia específica
     */
    public function detalle($id)
    {
        try {
            $evidencia = Evidencia::with(['proyecto', 'categoria', 'subidoPor'])
                ->findOrFail($id);
            
            return response()->json([
                'id' => $evidencia->id,
                'tipo' => $evidencia->tipo,
                'nombre' => $evidencia->nombre,
                'descripcion' => $evidencia->descripcion,
                'proyecto' => $evidencia->proyecto->nombre ?? 'Sin proyecto',
                'proyecto_id' => $evidencia->proyecto_id,
                'categoria' => $evidencia->categoria_nombre,
                'categoria_id' => $evidencia->categoria_id,
                'fecha' => $evidencia->fecha ? $evidencia->fecha->format('d/m/Y') : 'N/A',
                'subido_por' => $evidencia->subidoPor->name ?? 'N/A',
                'tamanio' => $evidencia->tamanio_formateado,
                'tamanio_bytes' => $evidencia->tamanio_bytes,
                'tipo_archivo' => $evidencia->tipo_archivo,
                'archivo_url' => $evidencia->archivo_url,
                'miniatura_url' => $evidencia->miniatura_url,
                'ancho' => $evidencia->ancho,
                'alto' => $evidencia->alto,
                'created_at' => $evidencia->created_at ? $evidencia->created_at->format('d/m/Y H:i') : 'N/A',
                'updated_at' => $evidencia->updated_at ? $evidencia->updated_at->format('d/m/Y H:i') : 'N/A'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en detalle evidencia: ' . $e->getMessage());
            return response()->json([
                'error' => 'Evidencia no encontrada'
            ], 404);
        }
    }

    /**
     * Subir una nueva evidencia
     */
    public function subir(Request $request)
    {
        try {
            $validated = $request->validate([
                'tipo' => 'required|in:foto,acta',
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'proyecto_id' => 'required|exists:proyectos,id',
                'categoria_id' => 'nullable|exists:categorias_evidencia,id',
                'categoria_nombre' => 'nullable|string|max:50',
                'fecha' => 'required|date',
                'archivo' => 'required|file|max:20480', // 20MB max
            ]);

            $archivo = $request->file('archivo');
            $extension = $archivo->getClientOriginalExtension();
            $nombreOriginal = $archivo->getClientOriginalName();
            $tamanio = $archivo->getSize();
            $mimeType = $archivo->getMimeType();
            
            // Validar tipo de archivo según el tipo de evidencia
            if ($validated['tipo'] === 'foto') {
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                if (!in_array(strtolower($extension), $allowedExtensions)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Las fotos solo pueden ser JPG, PNG, GIF o WEBP'
                    ], 422);
                }
            } else {
                $allowedExtensions = ['pdf'];
                if (!in_array(strtolower($extension), $allowedExtensions)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Las actas solo pueden ser PDF'
                    ], 422);
                }
            }
            
            // Generar nombre único
            $nombreUnico = Str::uuid() . '.' . $extension;
            
            // Guardar archivo
            $path = $archivo->storeAs('evidencias/' . $validated['tipo'] . 's', $nombreUnico, 'public');
            
            // Crear registro
            $evidencia = new Evidencia();
            $evidencia->tipo = $validated['tipo'];
            $evidencia->nombre = $validated['nombre'];
            $evidencia->descripcion = $validated['descripcion'];
            $evidencia->proyecto_id = $validated['proyecto_id'];
            $evidencia->fecha = $validated['fecha'];
            $evidencia->subido_por = auth()->id();
            $evidencia->archivo_path = $path;
            $evidencia->archivo_nombre = $nombreOriginal;
            $evidencia->tamanio_bytes = $tamanio;
            $evidencia->tipo_archivo = strtoupper($extension);
            $evidencia->created_by = auth()->id();
            
            // Manejar categoría
            if (!empty($validated['categoria_id'])) {
                $evidencia->categoria_id = $validated['categoria_id'];
                $categoria = CategoriaEvidencia::find($validated['categoria_id']);
                $evidencia->categoria_nombre = $categoria ? $categoria->nombre : null;
            } elseif (!empty($validated['categoria_nombre'])) {
                // Buscar o crear categoría por nombre
                $categoria = CategoriaEvidencia::firstOrCreate(
                    ['nombre' => $validated['categoria_nombre']],
                    [
                        'codigo' => strtoupper(substr($validated['categoria_nombre'], 0, 3)) . '_' . uniqid(),
                        'activo' => true
                    ]
                );
                $evidencia->categoria_id = $categoria->id;
                $evidencia->categoria_nombre = $categoria->nombre;
            }
            
            // Si es foto, generar miniatura usando GD nativo (SIN Intervention Image)
            if ($validated['tipo'] === 'foto' && in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                try {
                    $imagePath = Storage::disk('public')->path($path);
                    $thumbnailPath = 'evidencias/thumbnails/' . Str::uuid() . '.jpg';
                    
                    // Crear directorio si no existe
                    $thumbnailDir = Storage::disk('public')->path('evidencias/thumbnails');
                    if (!File::exists($thumbnailDir)) {
                        File::makeDirectory($thumbnailDir, 0755, true);
                    }
                    
                    // Obtener información de la imagen
                    list($width, $height, $type) = getimagesize($imagePath);
                    $evidencia->ancho = $width;
                    $evidencia->alto = $height;
                    
                    // Crear imagen según el tipo
                    $src = null;
                    switch ($type) {
                        case IMAGETYPE_JPEG:
                            $src = imagecreatefromjpeg($imagePath);
                            break;
                        case IMAGETYPE_PNG:
                            $src = imagecreatefrompng($imagePath);
                            break;
                        case IMAGETYPE_GIF:
                            $src = imagecreatefromgif($imagePath);
                            break;
                        case IMAGETYPE_WEBP:
                            if (function_exists('imagecreatefromwebp')) {
                                $src = imagecreatefromwebp($imagePath);
                            }
                            break;
                        default:
                            $src = null;
                    }
                    
                    if ($src) {
                        // Calcular nuevo tamaño (max 300px de ancho)
                        $newWidth = 300;
                        $newHeight = ($height / $width) * $newWidth;
                        
                        // Crear imagen redimensionada
                        $thumb = imagecreatetruecolor($newWidth, $newHeight);
                        
                        // Mantener transparencia para PNG y GIF
                        if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_GIF) {
                            imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
                            imagealphablending($thumb, false);
                            imagesavealpha($thumb, true);
                        }
                        
                        imagecopyresampled($thumb, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                        
                        // Guardar como JPEG
                        imagejpeg($thumb, Storage::disk('public')->path($thumbnailPath), 80);
                        
                        // Liberar memoria
                        imagedestroy($src);
                        imagedestroy($thumb);
                        
                        $evidencia->miniatura_path = $thumbnailPath;
                    }
                    
                } catch (\Exception $e) {
                    Log::warning('Error al generar miniatura con GD: ' . $e->getMessage());
                    // No fallar si no se puede generar la miniatura
                }
            }
            
            $evidencia->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Evidencia subida correctamente',
                'data' => $evidencia
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al subir evidencia: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al subir la evidencia: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar una evidencia (soft delete)
     */
    public function eliminar($id)
    {
        try {
            $evidencia = Evidencia::findOrFail($id);
            $evidencia->estado = 'eliminado';
            $evidencia->save();
            
            // Soft delete
            $evidencia->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Evidencia eliminada correctamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar evidencia: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la evidencia: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Descargar una evidencia
     */
    public function descargar($id)
    {
        try {
            $evidencia = Evidencia::findOrFail($id);
            
            if (empty($evidencia->archivo_path)) {
                return response()->json(['error' => 'El archivo no existe'], 404);
            }
            
            if (!Storage::disk('public')->exists($evidencia->archivo_path)) {
                return response()->json(['error' => 'El archivo no existe en el servidor'], 404);
            }
            
            $nombreDescarga = $evidencia->archivo_nombre ?? $evidencia->nombre . '.' . $evidencia->tipo_archivo;
            
            return Storage::disk('public')->download($evidencia->archivo_path, $nombreDescarga);
            
        } catch (\Exception $e) {
            Log::error('Error al descargar evidencia: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al descargar la evidencia: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener categorías disponibles
     */
    public function categorias(Request $request)
    {
        try {
            $categorias = CategoriaEvidencia::where('activo', true)
                ->orderBy('orden')
                ->get(['id', 'codigo', 'nombre', 'icono', 'color']);
            
            return response()->json([
                'data' => $categorias
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en categorias: ' . $e->getMessage());
            return response()->json([
                'data' => []
            ]);
        }
    }

    /**
     * Exportar a Excel
     */
    public function exportarExcel(Request $request)
    {
        try {
            // Aquí implementar exportación con Laravel Excel
            return response()->json([
                'success' => true,
                'message' => 'Exportación en proceso'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en exportarExcel: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar a Excel'
            ], 500);
        }
    }

    /**
     * Formatear bytes a formato legible
     */
    private function formatBytes($bytes)
    {
        if ($bytes === 0) return '0 B';
        
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = floor(log($bytes, 1024));
        return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
    }
}