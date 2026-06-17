<?php

namespace App\Http\Controllers;

use App\Models\ReporteFotografico;
use App\Models\ReporteFotograficoGrupo;
use App\Models\Proyecto;
use App\Models\User;
use App\Models\Plantilla;
use App\Http\Requests\ReporteFotograficoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReporteFotograficoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la vista principal de Reportes Fotográficos
     */
    public function reportes()
    {
        Log::info('=== REPORTES FOTOGRÁFICOS: Cargando vista ===');
        return view('proyectos.avances.reportes');
    }

    /**
     * Obtiene todas las fotos con filtros (para AJAX)
     * SOPORTA FILTRO MÚLTIPLE DE PROYECTOS
     */
    public function index(Request $request)
    {
        Log::info('=== REPORTES FOTOGRÁFICOS INDEX ===');
        Log::info('Filtros recibidos:', $request->all());
        
        try {
            $query = ReporteFotografico::with(['proyecto', 'responsable', 'empleado', 'creador']);

            // Aplicar filtro de búsqueda
            if ($request->filled('busqueda')) {
                $query->buscar($request->busqueda);
            }

            // Aplicar filtro por múltiples proyectos
            if ($request->filled('proyecto_id')) {
                $proyectos = $request->input('proyecto_id');
                
                if (is_array($proyectos) && count($proyectos) > 0) {
                    $proyectosFiltrados = array_filter($proyectos, function($value) {
                        return $value !== '' && $value !== null;
                    });
                    
                    if (count($proyectosFiltrados) > 0) {
                        $query->whereIn('proyecto_id', $proyectosFiltrados);
                        Log::info('Filtrando por proyectos: ' . implode(', ', $proyectosFiltrados));
                    }
                } elseif (!is_array($proyectos) && $proyectos !== '' && $proyectos !== null) {
                    $query->where('proyecto_id', $proyectos);
                    Log::info('Filtrando por proyecto: ' . $proyectos);
                }
            }

            // Aplicar filtro por categoría
            if ($request->filled('categoria') && $request->categoria !== 'todos') {
                $query->byCategoria($request->categoria);
            }

            // Aplicar filtro por rango de fechas
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->byRangoFechas($request->fecha_inicio, $request->fecha_fin);
            }

            // Aplicar filtro por estado
            if ($request->filled('estado')) {
                if ($request->estado === 'activo') {
                    $query->activos();
                } elseif ($request->estado === 'archivado') {
                    $query->archivados();
                }
            }

            // Ordenar y paginar
            $perPage = $request->get('per_page', 12);
            $fotos = $query->orderBy('fecha', 'desc')->paginate($perPage);

            // Calcular estadísticas para los 4 cuadros
            $estadisticas = $this->calcularEstadisticas($request);

            // Obtener conteos por categoría
            $conteosCategorias = $this->getConteosCategorias($request);

            return response()->json([
                'success' => true,
                'data' => $fotos,
                'estadisticas' => $estadisticas,
                'conteos_categorias' => $conteosCategorias,
                'filtros_aplicados' => [
                    'proyectos' => $request->input('proyecto_id'),
                    'categoria' => $request->input('categoria'),
                    'fecha_inicio' => $request->input('fecha_inicio'),
                    'fecha_fin' => $request->input('fecha_fin')
                ],
                'message' => 'Reportes fotográficos obtenidos correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en index Reportes Fotográficos: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener reportes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene una foto específica por ID
     */
    public function show($id)
    {
        Log::info('=== REPORTES FOTOGRÁFICOS: Mostrando detalle ID: ' . $id);
        
        try {
            $foto = ReporteFotografico::with(['proyecto', 'responsable', 'empleado', 'creador', 'grupos'])
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $foto,
                'message' => 'Foto obtenida correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al mostrar foto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Foto no encontrada'
            ], 404);
        }
    }

    /**
     * Almacena una nueva foto
     */
    /**
 * Almacena una nueva foto
 */
public function store(ReporteFotograficoRequest $request)
{
    Log::info('=== REPORTES FOTOGRÁFICOS: Subiendo nueva foto ===');
    Log::info('Datos recibidos:', $request->all());
    
    try {
        DB::beginTransaction();
        
        // SOLO usar archivos[] - ignorar archivo individual
        $archivos = [];
        
        if ($request->hasFile('archivos')) {
            $archivos = $request->file('archivos');
            if (!is_array($archivos)) {
                $archivos = [$archivos];
            }
        }
        
        // Validar que haya archivos
        if (empty($archivos)) {
            return response()->json([
                'success' => false,
                'message' => 'Debe seleccionar al menos una foto'
            ], 422);
        }
        
        $fotosSubidas = [];
        $errores = [];
        
        foreach ($archivos as $archivo) {
            if (!$archivo) continue;
            
            // Validar tipo de archivo
            if (!in_array($archivo->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
                $errores[] = $archivo->getClientOriginalName() . ' no es una imagen válida';
                continue;
            }
            
            // Validar tamaño (max 10MB)
            if ($archivo->getSize() > 10485760) {
                $errores[] = $archivo->getClientOriginalName() . ' excede el tamaño máximo de 10MB';
                continue;
            }
            
            // Generar nombre único
            $nombreOriginal = $archivo->getClientOriginalName();
            $extension = $archivo->getClientOriginalExtension();
            $nombreUnico = uniqid() . '_' . time() . '.' . $extension;
            $ruta = $archivo->storeAs('reportes_fotograficos', $nombreUnico, 'public');
            
            // Obtener dimensiones de la imagen
            $dimensiones = $this->getImageDimensions($archivo->path());
            
            // Crear registro
            $foto = ReporteFotografico::create([
                'proyecto_id' => $request->proyecto_id,
                'responsable_id' => $request->responsable_id ?? auth()->id(),
                'empleado_id' => $request->empleado_id,
                'categoria' => $request->categoria ?? 'avance',
                'titulo' => $request->titulo ?? $nombreOriginal,
                'descripcion' => $request->descripcion,
                'fecha' => $request->fecha ?? now(),
                'ruta' => $ruta,
                'nombre_original' => $nombreOriginal,
                'nombre_unico' => $nombreUnico,
                'tipo' => $archivo->getMimeType(),
                'tamanio' => $archivo->getSize(),
                'ancho' => $dimensiones['ancho'] ?? null,
                'alto' => $dimensiones['alto'] ?? null,
                'estado' => 'activo',
                'observaciones' => $request->observaciones,
                'created_by' => auth()->id()
            ]);
            
            $fotosSubidas[] = $foto;
        }
        
        DB::commit();
        
        $mensaje = count($fotosSubidas) . ' foto(s) subida(s) correctamente';
        if (!empty($errores)) {
            $mensaje .= ' - Errores: ' . implode(', ', $errores);
        }
        
        return response()->json([
            'success' => true,
            'data' => $fotosSubidas,
            'total' => count($fotosSubidas),
            'errores' => $errores,
            'message' => $mensaje
        ], 201);
        
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('ERROR al subir fotos: ' . $e->getMessage());
        Log::error('Stack trace: ' . $e->getTraceAsString());
        
        return response()->json([
            'success' => false,
            'message' => 'Error al subir las fotos: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Actualiza los datos de una foto
     */
    public function update(ReporteFotograficoRequest $request, $id)
    {
        Log::info('=== REPORTES FOTOGRÁFICOS: Actualizando ID: ' . $id);
        Log::info('Datos:', $request->all());
        
        try {
            DB::beginTransaction();
            
            $foto = ReporteFotografico::findOrFail($id);
            
            $foto->update([
                'proyecto_id' => $request->proyecto_id,
                'categoria' => $request->categoria,
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'fecha' => $request->fecha,
                'observaciones' => $request->observaciones
            ]);
            
            Log::info('Foto actualizada ID: ' . $foto->id);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'data' => $foto,
                'message' => 'Foto actualizada correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al actualizar foto: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la foto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina una foto (soft delete y archivo físico)
     */
    public function destroy($id)
    {
        Log::info('=== REPORTES FOTOGRÁFICOS: Eliminando ID: ' . $id);
        
        try {
            $foto = ReporteFotografico::findOrFail($id);
            
            // Eliminar archivo físico
            $foto->deleteFile();
            
            // Soft delete del registro
            $foto->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Foto eliminada correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al eliminar foto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la foto'
            ], 500);
        }
    }

    /**
     * Descarga una foto
     */
    public function descargar($id)
    {
        try {
            $foto = ReporteFotografico::findOrFail($id);
            
            if (!$foto->existsInStorage()) {
                abort(404, 'El archivo no existe');
            }
            
            return Storage::disk('public')->download(
                $foto->ruta,
                $foto->nombre_original
            );

        } catch (\Exception $e) {
            Log::error('ERROR al descargar foto: ' . $e->getMessage());
            abort(404, 'Foto no encontrada');
        }
    }

    /**
     * Archiva una foto
     */
    public function archivar($id)
    {
        Log::info('=== REPORTES FOTOGRÁFICOS: Archivando ID: ' . $id);
        
        try {
            $foto = ReporteFotografico::findOrFail($id);
            $foto->archivar();
            
            return response()->json([
                'success' => true,
                'data' => $foto,
                'message' => 'Foto archivada correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al archivar foto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al archivar la foto'
            ], 500);
        }
    }

    /**
     * Restaura una foto archivada
     */
    public function restaurar($id)
    {
        Log::info('=== REPORTES FOTOGRÁFICOS: Restaurando ID: ' . $id);
        
        try {
            $foto = ReporteFotografico::findOrFail($id);
            $foto->restaurar();
            
            return response()->json([
                'success' => true,
                'data' => $foto,
                'message' => 'Foto restaurada correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al restaurar foto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al restaurar la foto'
            ], 500);
        }
    }

    /**
     * Obtiene estadísticas para el dashboard
     */
    public function estadisticas(Request $request)
    {
        try {
            $estadisticas = $this->calcularEstadisticas($request);
            $conteosCategorias = $this->getConteosCategorias($request);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'estadisticas' => $estadisticas,
                    'conteos_categorias' => $conteosCategorias
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en estadísticas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas'
            ], 500);
        }
    }

    /**
     * Exporta reportes a Excel/CSV
     */
    public function exportar(Request $request)
    {
        Log::info('=== REPORTES FOTOGRÁFICOS: Exportando datos ===');
        
        try {
            $query = ReporteFotografico::with(['proyecto']);
            
            if ($request->filled('busqueda')) {
                $query->buscar($request->busqueda);
            }
            
            if ($request->filled('proyecto_id')) {
                $proyectos = $request->input('proyecto_id');
                if (is_array($proyectos) && count($proyectos) > 0) {
                    $proyectosFiltrados = array_filter($proyectos, function($value) {
                        return $value !== '' && $value !== null;
                    });
                    if (count($proyectosFiltrados) > 0) {
                        $query->whereIn('proyecto_id', $proyectosFiltrados);
                    }
                } elseif (!is_array($proyectos) && $proyectos !== '' && $proyectos !== null) {
                    $query->where('proyecto_id', $proyectos);
                }
            }
            
            if ($request->filled('categoria') && $request->categoria !== 'todos') {
                $query->byCategoria($request->categoria);
            }
            
            $fotos = $query->orderBy('fecha', 'desc')->get();
            
            $headers = ['ID', 'Proyecto', 'Título', 'Categoría', 'Fecha', 'Descripción', 'Responsable', 'Tamaño', 'Estado'];
            $rows = $fotos->map(function($foto) {
                return [
                    $foto->id,
                    $foto->proyecto?->nombre ?? '-',
                    $foto->titulo,
                    $foto->categoria_nombre,
                    $foto->fecha?->format('d/m/Y'),
                    $foto->descripcion ?? '-',
                    $foto->responsable_nombre,
                    $foto->tamanio_formateado,
                    $foto->estado_nombre
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => [
                    'headers' => $headers,
                    'rows' => $rows,
                    'total' => $fotos->count()
                ],
                'message' => 'Datos listos para exportar'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al exportar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar datos'
            ], 500);
        }
    }

    /**
     * Obtiene lista de proyectos para selects
     */
    public function proyectos()
    {
        try {
            $proyectos = Proyecto::where('status', 'activo')
                ->orWhere('status', 'en_curso')
                ->select('id', 'codigo', 'nombre')
                ->orderBy('nombre')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nombre' => $item->codigo . ' - ' . $item->nombre
                    ];
                });
            
            return response()->json([
                'success' => true,
                'data' => $proyectos
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener proyectos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Error al obtener proyectos'
            ]);
        }
    }

    /**
     * Obtiene lista de responsables para selects
     */
    public function responsables()
    {
        try {
            $responsables = User::where('estatus', 'activo')
                ->select('id', 'name')
                ->orderBy('name')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nombre' => $item->name
                    ];
                });
            
            // También obtener empleados de plantillas
            $empleados = Plantilla::where('estatus', 'Activo')
                ->select('plantilla_id as id', 'nombre', 'apellido_paterno', 'apellido_materno')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nombre' => trim($item->nombre . ' ' . ($item->apellido_paterno ?? '') . ' ' . ($item->apellido_materno ?? ''))
                    ];
                });
            
            return response()->json([
                'success' => true,
                'data' => [
                    'usuarios' => $responsables,
                    'empleados' => $empleados
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener responsables: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Error al obtener responsables'
            ]);
        }
    }

    // ==================== MÉTODOS PRIVADOS ====================

    /**
     * Calcula las estadísticas para los 4 cuadros
     */
    private function calcularEstadisticas(Request $request): array
    {
        try {
            $query = ReporteFotografico::query();
            
            // Aplicar filtros
            if ($request->filled('proyecto_id')) {
                $proyectos = $request->input('proyecto_id');
                if (is_array($proyectos) && count($proyectos) > 0) {
                    $proyectosFiltrados = array_filter($proyectos, function($value) {
                        return $value !== '' && $value !== null;
                    });
                    if (count($proyectosFiltrados) > 0) {
                        $query->whereIn('proyecto_id', $proyectosFiltrados);
                    }
                } elseif (!is_array($proyectos) && $proyectos !== '' && $proyectos !== null) {
                    $query->where('proyecto_id', $proyectos);
                }
            }
            
            if ($request->filled('categoria') && $request->categoria !== 'todos') {
                $query->byCategoria($request->categoria);
            }

            // Calcular tamaño total
            $tamanioTotal = (clone $query)->sum('tamanio');
            $tamanioFormateado = $this->formatSize($tamanioTotal);

            return [
                'total_fotos' => (clone $query)->count(),
                'reportes_mes' => (clone $query)->whereMonth('fecha', now()->month)
                    ->whereYear('fecha', now()->year)
                    ->count(),
                'proyectos_activos' => (clone $query)->distinct('proyecto_id')->count('proyecto_id'),
                'tamano_total' => $tamanioFormateado,
                'tamano_total_bytes' => $tamanioTotal
            ];
            
        } catch (\Exception $e) {
            Log::error('ERROR calcularEstadisticas: ' . $e->getMessage());
            return [
                'total_fotos' => 0,
                'reportes_mes' => 0,
                'proyectos_activos' => 0,
                'tamano_total' => '0 B',
                'tamano_total_bytes' => 0
            ];
        }
    }

    /**
     * Obtiene los conteos por categoría
     */
    private function getConteosCategorias(Request $request): array
    {
        try {
            $query = ReporteFotografico::query();
            
            if ($request->filled('proyecto_id')) {
                $proyectos = $request->input('proyecto_id');
                if (is_array($proyectos) && count($proyectos) > 0) {
                    $proyectosFiltrados = array_filter($proyectos, function($value) {
                        return $value !== '' && $value !== null;
                    });
                    if (count($proyectosFiltrados) > 0) {
                        $query->whereIn('proyecto_id', $proyectosFiltrados);
                    }
                } elseif (!is_array($proyectos) && $proyectos !== '' && $proyectos !== null) {
                    $query->where('proyecto_id', $proyectos);
                }
            }

            $categorias = ReporteFotografico::CATEGORIAS;
            $conteos = [];

            foreach ($categorias as $key => $nombre) {
                $conteos[$key] = (clone $query)->where('categoria', $key)->count();
            }

            $conteos['todos'] = array_sum($conteos);

            return $conteos;
            
        } catch (\Exception $e) {
            Log::error('ERROR getConteosCategorias: ' . $e->getMessage());
            return [
                'todos' => 0,
                'avance' => 0,
                'calidad' => 0,
                'seguridad' => 0,
                'reunion' => 0,
                'entrega' => 0,
                'instalaciones' => 0,
                'estructura' => 0,
                'terracerias' => 0,
                'pavimentos' => 0
            ];
        }
    }

    /**
     * Obtiene dimensiones de una imagen
     */
    private function getImageDimensions(string $path): array
    {
        try {
            $dimensiones = getimagesize($path);
            return [
                'ancho' => $dimensiones[0] ?? null,
                'alto' => $dimensiones[1] ?? null
            ];
        } catch (\Exception $e) {
            return ['ancho' => null, 'alto' => null];
        }
    }

    /**
     * Formatea el tamaño de archivo
     */
    private function formatSize(int $bytes): string
    {
        $unidades = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($unidades) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 1) . ' ' . $unidades[$i];
    }
}