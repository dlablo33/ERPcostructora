<?php

namespace App\Http\Controllers;

use App\Models\BitacoraEntry;
use App\Models\BitacoraIncidencia;
use App\Models\EvidenciaFotografica;
use App\Models\ComentarioBitacora;
use App\Models\ReporteGenerado;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class BitacoraController extends Controller
{
    /**
     * Muestra la vista principal de la bitácora
     */
    public function index()
{
    // Obtener proyectos desde la base de datos
    $proyectos = \App\Models\Proyecto::where('status', 'activo')
        ->orderBy('codigo')
        ->get(['codigo as id', 'nombre'])
        ->toArray();
    
    // Si no hay proyectos, usar datos de respaldo
    if (empty($proyectos)) {
        $proyectos = [
            ['id' => 'PRO-2024-001', 'nombre' => 'Torre Norte Corporativa'],
            ['id' => 'PRO-2024-002', 'nombre' => 'Puente Vehicular Sur'],
            ['id' => 'PRO-2024-003', 'nombre' => 'Parque Industrial Norte'],
            ['id' => 'PRO-2024-004', 'nombre' => 'Hospital Regional'],
            ['id' => 'PRO-2024-005', 'nombre' => 'Planta Tratamiento'],
            ['id' => 'PRO-2024-006', 'nombre' => 'Urbanización Los Álamos']
        ];
    }
    
    $resumen = [
        'total' => \App\Models\BitacoraEntry::count(),
        'actividades' => \App\Models\BitacoraEntry::where('tipo', 'actividad')->count(),
        'incidencias' => \App\Models\BitacoraEntry::where('tipo', 'incidencia')->count(),
        'pendientes' => \App\Models\BitacoraEntry::where('estado', 'pendiente')->count()
    ];
    
    // IMPORTANTE: Usar la vista correcta
    return view('proyectos.gestion.bitacora', compact('proyectos', 'resumen'));
}

    /**
     * Obtiene las entradas de bitácora con filtros
     */
    public function getEntries(Request $request)
    {
        try {
            $query = BitacoraEntry::with(['creador', 'incidencia', 'comentarios.usuario']);
            
            // Aplicar filtros
            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            if ($request->filled('tipo')) {
                $query->where('tipo', $request->tipo);
            }
            
            if ($request->filled('estado')) {
                $query->where('estado', $request->estado);
            }
            
            if ($request->filled('responsable')) {
                $query->where('responsable', $request->responsable);
            }
            
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            }
            
            if ($request->filled('search')) {
                $query->where(function($q) use ($request) {
                    $q->where('titulo', 'LIKE', '%' . $request->search . '%')
                      ->orWhere('descripcion', 'LIKE', '%' . $request->search . '%')
                      ->orWhere('responsable', 'LIKE', '%' . $request->search . '%');
                });
            }
            
            $perPage = $request->get('per_page', 10);
            $entries = $query->orderBy('fecha', 'desc')
                            ->orderBy('hora', 'desc')
                            ->paginate($perPage);
            
            return response()->json([
                'success' => true,
                'data' => $entries->items(),
                'total' => $entries->total(),
                'current_page' => $entries->currentPage(),
                'last_page' => $entries->lastPage(),
                'per_page' => $entries->perPage()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al obtener entradas de bitácora: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las entradas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Muestra una entrada específica
     */
    public function show($id)
    {
        try {
            $entry = BitacoraEntry::with(['creador', 'incidencia', 'comentarios.usuario', 'evidencias'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $entry
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Entrada no encontrada'
            ], 404);
        }
    }

    /**
     * Almacena una nueva entrada en la bitácora
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'proyecto_id' => 'required|string|max:50',
            'tipo' => 'required|in:actividad,incidencia,acuerdo,nota',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'responsable' => 'required|string|max:100',
            'personal' => 'nullable|string',
            'maquinaria' => 'nullable|string',
            'materiales' => 'nullable|string',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Crear la entrada principal
            $entry = BitacoraEntry::create([
                'proyecto_id' => $request->proyecto_id,
                'tipo' => $request->tipo,
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'responsable' => $request->responsable,
                'personal' => $request->personal,
                'maquinaria' => $request->maquinaria,
                'materiales' => $request->materiales,
                'estado' => $request->tipo === 'incidencia' ? 'pendiente' : 'completado',
                'created_by' => auth()->id()
            ]);

            // Si es incidencia, crear registro adicional
            if ($request->tipo === 'incidencia') {
                $validatorInc = Validator::make($request->all(), [
                    'tipo_incidencia' => 'required|in:mecanica,personal,material,seguridad,clima,otros',
                    'prioridad' => 'required|in:baja,media,alta,critica',
                    'accion_tomada' => 'nullable|string'
                ]);

                if ($validatorInc->fails()) {
                    throw new \Exception('Datos de incidencia incompletos');
                }

                BitacoraIncidencia::create([
                    'bitacora_entry_id' => $entry->id,
                    'tipo_incidencia' => $request->tipo_incidencia,
                    'prioridad' => $request->prioridad,
                    'accion_tomada' => $request->accion_tomada
                ]);
            }

            // Procesar imágenes subidas
            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $imagen) {
                    $path = $imagen->store('evidencias/' . date('Y/m/d'), 'public');
                    EvidenciaFotografica::create([
                        'bitacora_entry_id' => $entry->id,
                        'ruta' => $path,
                        'nombre_original' => $imagen->getClientOriginalName(),
                        'mime_type' => $imagen->getMimeType(),
                        'size' => $imagen->getSize()
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Entrada creada exitosamente',
                'data' => $entry->load(['creador', 'incidencia', 'evidencias'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear entrada de bitácora: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la entrada: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualiza una entrada existente
     */
    public function update(Request $request, $id)
    {
        $entry = BitacoraEntry::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'titulo' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string',
            'estado' => 'sometimes|in:pendiente,en_proceso,completado,cerrado',
            'personal' => 'nullable|string',
            'maquinaria' => 'nullable|string',
            'materiales' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $entry->update($request->only([
                'titulo', 'descripcion', 'estado', 'personal', 
                'maquinaria', 'materiales'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Entrada actualizada exitosamente',
                'data' => $entry
            ]);

        } catch (\Exception $e) {
            Log::error('Error al actualizar entrada: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la entrada: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina una entrada de la bitácora
     */
    public function destroy($id)
    {
        try {
            $entry = BitacoraEntry::findOrFail($id);
            
            // Eliminar evidencias físicas
            foreach ($entry->evidencias as $evidencia) {
                Storage::disk('public')->delete($evidencia->ruta);
            }
            
            $entry->delete();

            return response()->json([
                'success' => true,
                'message' => 'Entrada eliminada exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al eliminar entrada: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la entrada: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Agrega un comentario a una entrada
     */
    public function addComment(Request $request, $entryId)
    {
        $validator = Validator::make($request->all(), [
            'comentario' => 'required|string|min:1|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $comentario = ComentarioBitacora::create([
                'bitacora_entry_id' => $entryId,
                'user_id' => auth()->id(),
                'comentario' => $request->comentario
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Comentario agregado exitosamente',
                'data' => $comentario->load('usuario')
            ]);

        } catch (\Exception $e) {
            Log::error('Error al agregar comentario: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar el comentario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina un comentario
     */
    public function deleteComment($id)
    {
        try {
            $comentario = ComentarioBitacora::findOrFail($id);
            
            // Verificar que el usuario sea el dueño del comentario
            if ($comentario->user_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No autorizado'
                ], 403);
            }
            
            $comentario->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Comentario eliminado'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el comentario'
            ], 500);
        }
    }

    /**
     * Obtiene las incidencias con filtros
     */
    public function getIncidencias(Request $request)
    {
        try {
            $query = BitacoraIncidencia::with('bitacoraEntry.creador');
            
            if ($request->filled('proyecto_id')) {
                $query->whereHas('bitacoraEntry', function($q) use ($request) {
                    $q->where('proyecto_id', $request->proyecto_id);
                });
            }
            
            if ($request->filled('prioridad')) {
                $query->where('prioridad', $request->prioridad);
            }
            
            if ($request->filled('tipo_incidencia')) {
                $query->where('tipo_incidencia', $request->tipo_incidencia);
            }
            
            if ($request->filled('estado')) {
                if ($request->estado === 'resuelta') {
                    $query->whereNotNull('resuelta_en');
                } else {
                    $query->whereNull('resuelta_en');
                }
            }
            
            $incidencias = $query->orderBy('created_at', 'desc')->paginate(15);
            
            return response()->json([
                'success' => true,
                'data' => $incidencias->items(),
                'total' => $incidencias->total(),
                'current_page' => $incidencias->currentPage(),
                'last_page' => $incidencias->lastPage()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al obtener incidencias: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las incidencias'
            ], 500);
        }
    }

    /**
     * Obtiene una incidencia específica
     */
    public function getIncidencia($id)
    {
        try {
            $incidencia = BitacoraIncidencia::with('bitacoraEntry.creador')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $incidencia
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Incidencia no encontrada'
            ], 404);
        }
    }

    /**
     * Resuelve una incidencia
     */
    public function resolveIncidencia(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'accion_tomada' => 'required|string|min:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $incidencia = BitacoraIncidencia::findOrFail($id);
            $incidencia->update([
                'resuelta_en' => now(),
                'accion_tomada' => $request->accion_tomada
            ]);
            
            // Actualizar estado de la entrada padre
            $incidencia->bitacoraEntry->update(['estado' => 'completado']);
            
            return response()->json([
                'success' => true,
                'message' => 'Incidencia resuelta exitosamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al resolver incidencia: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al resolver la incidencia: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualiza la prioridad de una incidencia
     */
    public function updatePrioridad(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'prioridad' => 'required|in:baja,media,alta,critica'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $incidencia = BitacoraIncidencia::findOrFail($id);
            $incidencia->update(['prioridad' => $request->prioridad]);
            
            return response()->json([
                'success' => true,
                'message' => 'Prioridad actualizada'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar prioridad'
            ], 500);
        }
    }

    /**
     * Sube una imagen para una entrada
     */
    public function uploadImage(Request $request, $entryId)
    {
        $validator = Validator::make($request->all(), [
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $entry = BitacoraEntry::findOrFail($entryId);
            
            $path = $request->file('imagen')->store('evidencias/' . date('Y/m/d'), 'public');
            
            $evidencia = EvidenciaFotografica::create([
                'bitacora_entry_id' => $entryId,
                'ruta' => $path,
                'nombre_original' => $request->file('imagen')->getClientOriginalName(),
                'mime_type' => $request->file('imagen')->getMimeType(),
                'size' => $request->file('imagen')->getSize(),
                'descripcion' => $request->descripcion
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Imagen subida exitosamente',
                'data' => $evidencia
            ]);

        } catch (\Exception $e) {
            Log::error('Error al subir imagen: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al subir la imagen: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina una imagen
     */
    public function deleteImage($id)
    {
        try {
            $evidencia = EvidenciaFotografica::findOrFail($id);
            $evidencia->delete();

            return response()->json([
                'success' => true,
                'message' => 'Imagen eliminada exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al eliminar imagen: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la imagen: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene las evidencias fotográficas
     */
    public function getEvidencias(Request $request)
    {
        try {
            $query = EvidenciaFotografica::with('bitacoraEntry');
            
            if ($request->filled('proyecto_id')) {
                $query->whereHas('bitacoraEntry', function($q) use ($request) {
                    $q->where('proyecto_id', $request->proyecto_id);
                });
            }
            
            if ($request->filled('entry_id')) {
                $query->where('bitacora_entry_id', $request->entry_id);
            }
            
            $evidencias = $query->orderBy('created_at', 'desc')->paginate(20);
            
            return response()->json([
                'success' => true,
                'data' => $evidencias->items(),
                'total' => $evidencias->total(),
                'current_page' => $evidencias->currentPage(),
                'last_page' => $evidencias->lastPage()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al obtener evidencias: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las evidencias'
            ], 500);
        }
    }

    /**
     * Obtiene estadísticas de la bitácora
     */
    public function getEstadisticas(Request $request)
    {
        try {
            $query = BitacoraEntry::query();
            
            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            }
            
            $estadisticas = [
                'total' => (clone $query)->count(),
                'actividades' => (clone $query)->where('tipo', 'actividad')->count(),
                'incidencias' => (clone $query)->where('tipo', 'incidencia')->count(),
                'acuerdos' => (clone $query)->where('tipo', 'acuerdo')->count(),
                'notas' => (clone $query)->where('tipo', 'nota')->count(),
                'pendientes' => (clone $query)->where('estado', 'pendiente')->count(),
                'en_proceso' => (clone $query)->where('estado', 'en_proceso')->count(),
                'completados' => (clone $query)->where('estado', 'completado')->count(),
                'por_tipo' => (clone $query)->select('tipo', DB::raw('count(*) as total'))
                                        ->groupBy('tipo')
                                        ->get(),
                'por_estado' => (clone $query)->select('estado', DB::raw('count(*) as total'))
                                         ->groupBy('estado')
                                         ->get(),
                'por_proyecto' => (clone $query)->select('proyecto_id', DB::raw('count(*) as total'))
                                          ->groupBy('proyecto_id')
                                          ->limit(10)
                                          ->get()
            ];
            
            return response()->json([
                'success' => true,
                'data' => $estadisticas
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al obtener estadísticas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las estadísticas'
            ], 500);
        }
    }

    /**
     * Exporta la bitácora a PDF
     */
    public function exportPDF(Request $request)
    {
        try {
            $query = BitacoraEntry::with(['creador', 'incidencia']);
            
            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            }
            
            $entries = $query->orderBy('fecha', 'desc')->orderBy('hora', 'desc')->get();
            
            // Guardar registro del reporte generado
            $reporte = ReporteGenerado::create([
                'titulo' => 'Reporte Bitácora - ' . now()->format('d/m/Y H:i'),
                'tipo' => 'personalizado',
                'fecha_inicio' => $request->fecha_inicio ?? now()->startOfMonth(),
                'fecha_fin' => $request->fecha_fin ?? now()->endOfMonth(),
                'proyecto_id' => $request->proyecto_id,
                'generado_por' => auth()->id()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Reporte generado exitosamente',
                'data' => [
                    'reporte_id' => $reporte->id,
                    'total_registros' => $entries->count(),
                    'entries' => $entries
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al exportar PDF: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el reporte: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene el resumen de la bitácora
     */
    private function getResumenBitacora(): array
    {
        return [
            'total' => BitacoraEntry::count(),
            'actividades' => BitacoraEntry::where('tipo', 'actividad')->count(),
            'incidencias' => BitacoraEntry::where('tipo', 'incidencia')->count(),
            'pendientes' => BitacoraEntry::where('estado', 'pendiente')->count()
        ];
    }

    /**
     * Obtiene la lista de proyectos desde la base de datos
     */
    private function getProyectos(): array
    {
        try {
            // Obtener proyectos de tu base de datos
            $proyectos = Proyecto::where('status', 'activo')
                ->orderBy('codigo')
                ->get(['codigo', 'nombre']);
            
            if ($proyectos->isNotEmpty()) {
                return $proyectos->map(function($proyecto) {
                    return [
                        'id' => $proyecto->codigo,
                        'nombre' => $proyecto->nombre
                    ];
                })->toArray();
            }
        } catch (\Exception $e) {
            Log::warning('No se pudieron obtener proyectos: ' . $e->getMessage());
        }
        
        // Datos de respaldo en caso de que no haya proyectos
        return [
            ['id' => 'PRO-2024-001', 'nombre' => 'Torre Norte Corporativa'],
            ['id' => 'PRO-2024-002', 'nombre' => 'Puente Vehicular Sur'],
            ['id' => 'PRO-2024-003', 'nombre' => 'Parque Industrial Norte'],
            ['id' => 'PRO-2024-004', 'nombre' => 'Hospital Regional'],
            ['id' => 'PRO-2024-005', 'nombre' => 'Planta Tratamiento'],
            ['id' => 'PRO-2024-006', 'nombre' => 'Urbanización Los Álamos']
        ];
    }

    /**
     * Obtiene lista de proyectos para selects (API)
     */
    public function getProyectosList()
    {
        return response()->json([
            'success' => true,
            'data' => $this->getProyectos()
        ]);
    }

    /**
     * Obtiene lista de responsables para selects
     */
    public function getResponsablesList()
    {
        try {
            $responsables = BitacoraEntry::select('responsable')
                ->distinct()
                ->pluck('responsable');
            
            return response()->json([
                'success' => true,
                'data' => $responsables
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'data' => ['Juan Pérez', 'María García', 'Carlos Rodríguez', 'Ana Martínez']
            ]);
        }
    }

    /**
     * Vista para imprimir
     */
    public function printView(Request $request)
    {
        $query = BitacoraEntry::with(['creador', 'incidencia']);
        
        if ($request->filled('proyecto_id')) {
            $query->where('proyecto_id', $request->proyecto_id);
        }
        
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
        }
        
        $entries = $query->orderBy('fecha', 'desc')->orderBy('hora', 'desc')->get();
        
        return view('proyectos.gestion.bitacora_print', compact('entries'));
    }

    /**
     * Obtiene resumen para reportes
     */
    public function getResumenReporte(Request $request)
    {
        try {
            $query = BitacoraEntry::query();
            
            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            }
            
            $resumen = [
                'total_entradas' => (clone $query)->count(),
                'total_actividades' => (clone $query)->where('tipo', 'actividad')->count(),
                'total_incidencias' => (clone $query)->where('tipo', 'incidencia')->count(),
                'total_comentarios' => ComentarioBitacora::whereHas('bitacoraEntry', function($q) use ($request) {
                    if ($request->filled('proyecto_id')) {
                        $q->where('proyecto_id', $request->proyecto_id);
                    }
                    if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                        $q->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
                    }
                })->count(),
                'total_imagenes' => EvidenciaFotografica::whereHas('bitacoraEntry', function($q) use ($request) {
                    if ($request->filled('proyecto_id')) {
                        $q->where('proyecto_id', $request->proyecto_id);
                    }
                    if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                        $q->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
                    }
                })->count()
            ];
            
            return response()->json([
                'success' => true,
                'data' => $resumen
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el resumen'
            ], 500);
        }
    }

    /**
     * Genera un reporte personalizado
     */
    public function generarReporte(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tipo_reporte' => 'required|in:diario,semanal,mensual,personalizado',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                'proyecto_id' => 'nullable|string'
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            
            $reporte = ReporteGenerado::create([
                'titulo' => 'Reporte ' . ucfirst($request->tipo_reporte) . ' - ' . now()->format('d/m/Y H:i'),
                'tipo' => $request->tipo_reporte,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'proyecto_id' => $request->proyecto_id,
                'generado_por' => auth()->id()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Reporte generado exitosamente',
                'data' => ['reporte_id' => $reporte->id]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el reporte: ' . $e->getMessage()
            ], 500);
        }
    }
}