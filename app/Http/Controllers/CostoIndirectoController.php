<?php

namespace App\Http\Controllers;

use App\Models\CostoIndirecto;
use App\Models\CostoIndirectoDocumento;
use App\Models\Proyecto;
use App\Models\Proveedor;
use App\Http\Requests\CostoIndirectoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CostoIndirectoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la vista principal de Costos Indirectos
     */
    public function indirectos()
    {
        Log::info('=== COSTOS INDIRECTOS: Cargando vista ===');
        return view('proyectos.costos.indirectos');
    }

    /**
     * Obtiene todos los costos indirectos con filtros (para AJAX)
     * SOPORTA FILTRO MÚLTIPLE DE PROYECTOS
     */
    public function index(Request $request)
    {
        Log::info('=== COSTOS INDIRECTOS INDEX ===');
        Log::info('Filtros recibidos:', $request->all());

        try {
            $query = CostoIndirecto::with(['proyecto', 'proveedor', 'creador']);

            $this->aplicarFiltros($query, $request);

            // Ordenar y paginar
            $perPage = $request->get('per_page', 10);
            $costos = $query->orderBy('fecha', 'desc')->paginate($perPage);

            // Calcular estadísticas para los 4 cuadros
            // (aplicando LOS MISMOS filtros que la tabla)
            $estadisticas = $this->calcularEstadisticas($request);

            return response()->json([
                'success' => true,
                'data' => $costos,
                'estadisticas' => $estadisticas,
                'filtros_aplicados' => [
                    'proyectos' => $request->input('proyecto_id'),
                    'categoria' => $request->input('categoria'),
                    'estatus_pago' => $request->input('estatus_pago'),
                    'fecha_inicio' => $request->input('fecha_inicio'),
                    'fecha_fin' => $request->input('fecha_fin'),
                    'busqueda' => $request->input('busqueda'),
                ],
                'message' => 'Costos indirectos obtenidos correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en index Costos Indirectos: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener costos indirectos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene un costo indirecto específico por ID
     */
    public function show($id)
    {
        Log::info('=== COSTOS INDIRECTOS: Mostrando detalle ID: ' . $id);

        try {
            $costo = CostoIndirecto::with(['proyecto', 'proveedor', 'creador', 'documentos'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $costo,
                'message' => 'Costo indirecto obtenido correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al mostrar costo indirecto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Costo indirecto no encontrado'
            ], 404);
        }
    }

    /**
     * Almacena un nuevo costo indirecto
     */
    public function store(CostoIndirectoRequest $request)
    {
        Log::info('=== COSTOS INDIRECTOS: Creando nuevo costo ===');
        Log::info('Datos recibidos:', $request->all());

        try {
            DB::beginTransaction();

            $costo = CostoIndirecto::create([
                'proyecto_id' => $request->proyecto_id,
                'proveedor_id' => $request->proveedor_id,
                'categoria' => $request->categoria,
                'concepto' => $request->concepto,
                'fecha' => $request->fecha,
                'proveedor_nombre' => $request->proveedor_nombre ?? $request->proveedor,
                'rfc' => $request->rfc,
                'factura' => $request->factura,
                'descripcion' => $request->descripcion,
                'subtotal' => $request->subtotal ?? 0,
                'iva' => $request->iva ?? 0,
                'forma_pago' => $request->forma_pago ?? 'transferencia',
                'fecha_pago' => $request->fecha_pago,
                'estatus_pago' => $request->estatus_pago ?? 'pendiente',
                'observaciones' => $request->observaciones,
                'created_by' => auth()->id()
            ]);

            Log::info('Costo indirecto creado con ID: ' . $costo->id);

            // Procesar documentos si se subieron
            // IMPORTANTE: se usa el método privado subirDocumentoArchivo (NO el público)
            if ($request->hasFile('documentos')) {
                foreach ($request->file('documentos') as $file) {
                    $this->subirDocumentoArchivo($file, $costo->id);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $costo,
                'message' => 'Costo indirecto creado correctamente'
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al crear costo indirecto: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error al crear el costo indirecto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualiza un costo indirecto existente
     */
    public function update(CostoIndirectoRequest $request, $id)
    {
        Log::info('=== COSTOS INDIRECTOS: Actualizando ID: ' . $id);
        Log::info('Datos:', $request->all());

        try {
            DB::beginTransaction();

            $costo = CostoIndirecto::findOrFail($id);

            $costo->update([
                'proyecto_id' => $request->proyecto_id,
                'proveedor_id' => $request->proveedor_id,
                'categoria' => $request->categoria,
                'concepto' => $request->concepto,
                'fecha' => $request->fecha,
                'proveedor_nombre' => $request->proveedor_nombre ?? $request->proveedor,
                'rfc' => $request->rfc,
                'factura' => $request->factura,
                'descripcion' => $request->descripcion,
                'subtotal' => $request->subtotal ?? 0,
                'iva' => $request->iva ?? 0,
                'forma_pago' => $request->forma_pago ?? $costo->forma_pago,
                'fecha_pago' => $request->fecha_pago,
                'estatus_pago' => $request->estatus_pago ?? $costo->estatus_pago,
                'observaciones' => $request->observaciones
            ]);

            // Procesar documentos si se subieron en la edición
            if ($request->hasFile('documentos')) {
                foreach ($request->file('documentos') as $file) {
                    $this->subirDocumentoArchivo($file, $costo->id);
                }
            }

            Log::info('Costo indirecto actualizado ID: ' . $costo->id);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $costo,
                'message' => 'Costo indirecto actualizado correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al actualizar costo indirecto: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el costo indirecto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina un costo indirecto (soft delete)
     */
    public function destroy($id)
    {
        Log::info('=== COSTOS INDIRECTOS: Eliminando ID: ' . $id);

        try {
            DB::beginTransaction();

            $costo = CostoIndirecto::findOrFail($id);

            // Eliminar documentos asociados (archivos + registros)
            foreach ($costo->documentos as $documento) {
                if ($documento->ruta && Storage::disk('public')->exists($documento->ruta)) {
                    Storage::disk('public')->delete($documento->ruta);
                }
                $documento->delete();
            }

            $costo->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Costo indirecto eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al eliminar costo indirecto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el costo indirecto'
            ], 500);
        }
    }

    /**
     * Cambia el estatus de pago de un costo indirecto
     */
    public function cambiarEstatusPago(Request $request, $id)
    {
        Log::info('=== COSTOS INDIRECTOS: Cambiando estatus ID: ' . $id . ' a: ' . $request->estatus);

        try {
            $request->validate([
                'estatus' => 'required|in:pagado,pendiente,programado,vencido'
            ]);

            $costo = CostoIndirecto::findOrFail($id);

            if (!$costo->cambiarEstatusPago($request->estatus)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Estatus de pago no válido'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'data' => $costo,
                'message' => 'Estatus actualizado a: ' . $costo->estatus_nombre
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al cambiar estatus: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estatus: ' . $e->getMessage()
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

            return response()->json([
                'success' => true,
                'data' => $estadisticas
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
     * Exporta costos indirectos a Excel/CSV
     */
    public function exportar(Request $request)
    {
        Log::info('=== COSTOS INDIRECTOS: Exportando datos ===');

        try {
            $query = CostoIndirecto::with(['proyecto']);

            // Se aplican LOS MISMOS filtros que en index/estadísticas
            $this->aplicarFiltros($query, $request);

            $costos = $query->orderBy('fecha', 'desc')->get();

            // Preparar datos para CSV
            $headers = [
                'Proyecto', 'Categoría', 'Concepto', 'Fecha', 'Proveedor', 'RFC',
                'Factura', 'Descripción', 'Subtotal', 'IVA', 'Total',
                'Forma Pago', 'Fecha Pago', 'Estatus', 'Observaciones'
            ];

            $rows = $costos->map(function ($costo) {
                return [
                    $costo->proyecto?->nombre ?? '-',
                    $costo->categoria_nombre,
                    $costo->concepto,
                    $costo->fecha?->format('d/m/Y'),
                    $costo->nombre_proveedor,
                    $costo->rfc ?? '-',
                    $costo->factura ?? '-',
                    $costo->descripcion ?? '-',
                    $costo->subtotal,
                    $costo->iva,
                    $costo->total,
                    $costo->forma_pago_nombre,
                    $costo->fecha_pago?->format('d/m/Y') ?? '-',
                    $costo->estatus_nombre,
                    $costo->observaciones ?? '-'
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'headers' => $headers,
                    'rows' => $rows,
                    'total' => $costos->count(),
                    'total_general' => $costos->sum('total')
                ],
                'message' => 'Datos listos para exportar'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al exportar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar datos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene lista de proyectos para selects
     */
    public function proyectos()
    {
        try {
            $proyectos = Proyecto::whereIn('status', ['activo', 'en_curso'])
                ->select('id', 'codigo', 'nombre')
                ->orderBy('nombre')
                ->get()
                ->map(function ($item) {
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
     * Obtiene lista de proveedores para selects
     */
    public function proveedores()
    {
        try {
            $proveedores = Proveedor::where('activo', true)
                ->select('id', 'nombre', 'rfc')
                ->orderBy('nombre')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $proveedores
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener proveedores: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Error al obtener proveedores'
            ]);
        }
    }

    /**
     * Sube un documento para un costo indirecto (endpoint público)
     */
    public function subirDocumento(Request $request, $id)
    {
        Log::info('=== COSTOS INDIRECTOS: Subiendo documento para ID: ' . $id);

        try {
            $request->validate([
                'documento' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx'
            ]);

            // Verificar que el costo exista
            $costo = CostoIndirecto::findOrFail($id);
            $file = $request->file('documento');

            $documento = $this->subirDocumentoArchivo($file, $costo->id);

            return response()->json([
                'success' => true,
                'data' => $documento,
                'message' => 'Documento subido correctamente'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Archivo no válido',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('ERROR al subir documento: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al subir el documento: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina un documento de un costo indirecto
     */
    public function eliminarDocumento($id, $documentoId)
    {
        Log::info('=== COSTOS INDIRECTOS: Eliminando documento ID: ' . $documentoId . ' de costo ID: ' . $id);

        try {
            $documento = CostoIndirectoDocumento::where('costo_indirecto_id', $id)
                ->where('id', $documentoId)
                ->firstOrFail();

            if ($documento->ruta && Storage::disk('public')->exists($documento->ruta)) {
                Storage::disk('public')->delete($documento->ruta);
            }
            $documento->delete();

            return response()->json([
                'success' => true,
                'message' => 'Documento eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al eliminar documento: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el documento'
            ], 500);
        }
    }

    /**
     * Descarga un documento
     */
    public function descargarDocumento($id, $documentoId)
    {
        try {
            // Validar que el costo exista
            CostoIndirecto::findOrFail($id);

            $documento = CostoIndirectoDocumento::where('costo_indirecto_id', $id)
                ->where('id', $documentoId)
                ->firstOrFail();

            if (!Storage::disk('public')->exists($documento->ruta)) {
                abort(404, 'El archivo no existe');
            }

            return Storage::disk('public')->download(
                $documento->ruta,
                $documento->nombre_original
            );

        } catch (\Exception $e) {
            Log::error('ERROR al descargar documento: ' . $e->getMessage());
            abort(404, 'Documento no encontrado');
        }
    }

    // ==================== MÉTODOS PRIVADOS ====================

    /**
     * Aplica TODOS los filtros comunes a una query de CostoIndirecto.
     * Se reutiliza en index(), exportar() y calcularEstadisticas()
     * para garantizar que los totales coincidan con la tabla.
     */
    private function aplicarFiltros($query, Request $request): void
    {
        // Búsqueda libre (scopeBuscar en el modelo)
        if ($request->filled('busqueda')) {
            $query->buscar($request->busqueda);
        }

        // Filtro por múltiples proyectos
        if ($request->filled('proyecto_id')) {
            $proyectos = $request->input('proyecto_id');

            if (is_array($proyectos) && count($proyectos) > 0) {
                $proyectosFiltrados = array_filter($proyectos, function ($value) {
                    return $value !== '' && $value !== null;
                });

                if (count($proyectosFiltrados) > 0) {
                    $query->whereIn('proyecto_id', $proyectosFiltrados);
                }
            } elseif (!is_array($proyectos) && $proyectos !== '' && $proyectos !== null) {
                $query->where('proyecto_id', $proyectos);
            }
        }

        // Filtro por categoría
        if ($request->filled('categoria') && $request->categoria !== 'todos') {
            $query->byCategoria($request->categoria);
        }

        // Filtro por estatus de pago
        if ($request->filled('estatus_pago') && $request->estatus_pago !== '') {
            $query->byEstatusPago($request->estatus_pago);
        }

        // Rango de fechas (cada una se aplica por separado)
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }
    }

    /**
     * Calcula las estadísticas para los 4 cuadros de la parte superior.
     * Aplica EXACTAMENTE los mismos filtros que index() para que los
     * montos concuerden con los datos mostrados en la tabla.
     */
    private function calcularEstadisticas(Request $request): array
    {
        try {
            $query = CostoIndirecto::query();

            // ✅ Aplicar los mismos filtros (incluye fechas, estatus, búsqueda)
            $this->aplicarFiltros($query, $request);

            // Totales por categoría
            $totalIndirectos  = (clone $query)->sum('total');
            $totalPersonal    = (clone $query)->where('categoria', 'personal_tecnico')->sum('total');
            $totalAdmin       = (clone $query)->where('categoria', 'administracion')->sum('total');
            $totalSeguridad   = (clone $query)->where('categoria', 'seguridad')->sum('total');
            $totalServicios   = (clone $query)->where('categoria', 'servicios')->sum('total');
            $totalHerramienta = (clone $query)->where('categoria', 'herramienta')->sum('total');

            return [
                'total_indirectos'   => (float) $totalIndirectos,
                'total_personal'     => (float) $totalPersonal,
                'total_admin'        => (float) $totalAdmin,
                'total_seguridad'    => (float) $totalSeguridad,
                'total_servicios'    => (float) $totalServicios,
                'total_herramienta'  => (float) $totalHerramienta,
                'count'              => (clone $query)->count(),
                'count_pagados'      => (clone $query)->where('estatus_pago', 'pagado')->count(),
                'count_pendientes'   => (clone $query)->where('estatus_pago', 'pendiente')->count(),
                'count_programados'  => (clone $query)->where('estatus_pago', 'programado')->count(),
                'count_vencidos'     => (clone $query)->where('estatus_pago', 'vencido')->count(),
            ];

        } catch (\Exception $e) {
            Log::error('ERROR calcularEstadisticas: ' . $e->getMessage());

            return [
                'total_indirectos'   => 0,
                'total_personal'     => 0,
                'total_admin'        => 0,
                'total_seguridad'    => 0,
                'total_servicios'    => 0,
                'total_herramienta'  => 0,
                'count'              => 0,
                'count_pagados'      => 0,
                'count_pendientes'   => 0,
                'count_programados'  => 0,
                'count_vencidos'     => 0,
            ];
        }
    }

    /**
     * Sube un documento al almacenamiento y registra en BD.
     * Método privado que recibe un UploadedFile directamente.
     */
    private function subirDocumentoArchivo($file, $costoId): CostoIndirectoDocumento
    {
        $nombreOriginal = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $nombreUnico = uniqid() . '_' . time() . '.' . $extension;
        $ruta = $file->storeAs('costos_indirectos/documentos', $nombreUnico, 'public');

        return CostoIndirectoDocumento::create([
            'costo_indirecto_id' => $costoId,
            'nombre_original'    => $nombreOriginal,
            'nombre_unico'       => $nombreUnico,
            'ruta'               => $ruta,
            'tipo'               => $file->getMimeType(),
            'tamanio'            => $file->getSize(),
            'orden'              => 0
        ]);
    }
}