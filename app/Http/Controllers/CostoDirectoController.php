<?php

namespace App\Http\Controllers;

use App\Models\CostoDirecto;
use App\Models\CostoDirectoDocumento;
use App\Models\Proyecto;
use App\Models\Proveedor;
use App\Models\Plantilla;
use App\Http\Requests\CostoDirectoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CostoDirectoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la vista principal de Costos Directos
     */
    public function directos()
    {
        Log::info('=== COSTOS DIRECTOS: Cargando vista ===');
        return view('proyectos.costos.directos');
    }

    /**
     * Obtiene todos los costos directos con filtros (para AJAX)
     * SOPORTA FILTRO MÚLTIPLE DE PROYECTOS
     */
    public function index(Request $request)
    {
        Log::info('=== COSTOS DIRECTOS INDEX ===');
        Log::info('Filtros recibidos:', $request->all());
        
        try {
            $query = CostoDirecto::with(['proyecto', 'proveedor', 'empleado', 'creador']);

            // Aplicar filtro de búsqueda
            if ($request->filled('busqueda')) {
                $query->buscar($request->busqueda);
            }

            // Aplicar filtro por múltiples proyectos
            if ($request->filled('proyecto_id')) {
                $proyectos = $request->input('proyecto_id');
                
                // Si es un array (múltiple selección)
                if (is_array($proyectos) && count($proyectos) > 0) {
                    // Filtrar valores vacíos
                    $proyectosFiltrados = array_filter($proyectos, function($value) {
                        return $value !== '' && $value !== null;
                    });
                    
                    if (count($proyectosFiltrados) > 0) {
                        $query->whereIn('proyecto_id', $proyectosFiltrados);
                        Log::info('Filtrando por proyectos: ' . implode(', ', $proyectosFiltrados));
                    }
                } 
                // Si es un solo valor (selección única)
                elseif (!is_array($proyectos) && $proyectos !== '' && $proyectos !== null) {
                    $query->where('proyecto_id', $proyectos);
                    Log::info('Filtrando por proyecto: ' . $proyectos);
                }
            }

            // Aplicar filtro por categoría
            if ($request->filled('categoria') && $request->categoria !== 'todos') {
                $query->byCategoria($request->categoria);
            }

            // Aplicar filtro por estatus de pago
            if ($request->filled('estatus_pago')) {
                $query->byEstatusPago($request->estatus_pago);
            }

            // Aplicar filtro por rango de fechas
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->byRangoFechas($request->fecha_inicio, $request->fecha_fin);
            }

            // Ordenar y paginar
            $perPage = $request->get('per_page', 10);
            $costos = $query->orderBy('fecha', 'desc')->paginate($perPage);

            // Calcular estadísticas para los 4 cuadros (aplicando los mismos filtros)
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
                    'fecha_fin' => $request->input('fecha_fin')
                ],
                'message' => 'Costos obtenidos correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR en index Costos Directos: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener costos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene un costo directo específico por ID
     */
    public function show($id)
    {
        Log::info('=== COSTOS DIRECTOS: Mostrando detalle ID: ' . $id);
        
        try {
            $costo = CostoDirecto::with(['proyecto', 'proveedor', 'empleado', 'creador', 'documentos'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $costo,
                'message' => 'Costo obtenido correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al mostrar costo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Costo no encontrado'
            ], 404);
        }
    }

    /**
     * Almacena un nuevo costo directo
     */
    public function store(CostoDirectoRequest $request)
    {
        Log::info('=== COSTOS DIRECTOS: Creando nuevo costo ===');
        Log::info('Datos recibidos:', $request->all());
        
        try {
            DB::beginTransaction();
            
            $costo = CostoDirecto::create([
                'proyecto_id' => $request->proyecto_id,
                'proveedor_id' => $request->proveedor_id,
                'empleado_id' => $request->empleado_id,
                'categoria' => $request->categoria,
                'concepto' => $request->concepto,
                'fecha' => $request->fecha,
                'proveedor_nombre' => $request->proveedor_nombre ?? $request->proveedor,
                'rfc' => $request->rfc,
                'factura' => $request->factura,
                'descripcion' => $request->descripcion,
                'unidad' => $request->unidad,
                'cantidad' => $request->cantidad ?? 1,
                'precio_unitario' => $request->precio_unitario ?? 0,
                'iva' => $request->iva ?? 0,
                'fecha_pago' => $request->fecha_pago,
                'estatus_pago' => $request->estatus_pago ?? 'pendiente',
                'observaciones' => $request->observaciones,
                'created_by' => auth()->id()
            ]);
            
            Log::info('Costo creado con ID: ' . $costo->id);
            
            // Procesar documentos si se subieron
            if ($request->hasFile('documentos')) {
                foreach ($request->file('documentos') as $file) {
                    $this->subirDocumento($file, $costo->id);
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'data' => $costo,
                'message' => 'Costo directo creado correctamente'
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al crear costo: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el costo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualiza un costo directo existente
     */
    public function update(CostoDirectoRequest $request, $id)
    {
        Log::info('=== COSTOS DIRECTOS: Actualizando ID: ' . $id);
        Log::info('Datos:', $request->all());
        
        try {
            DB::beginTransaction();
            
            $costo = CostoDirecto::findOrFail($id);
            
            $costo->update([
                'proyecto_id' => $request->proyecto_id,
                'proveedor_id' => $request->proveedor_id,
                'empleado_id' => $request->empleado_id,
                'categoria' => $request->categoria,
                'concepto' => $request->concepto,
                'fecha' => $request->fecha,
                'proveedor_nombre' => $request->proveedor_nombre ?? $request->proveedor,
                'rfc' => $request->rfc,
                'factura' => $request->factura,
                'descripcion' => $request->descripcion,
                'unidad' => $request->unidad,
                'cantidad' => $request->cantidad ?? 1,
                'precio_unitario' => $request->precio_unitario ?? 0,
                'iva' => $request->iva ?? 0,
                'fecha_pago' => $request->fecha_pago,
                'estatus_pago' => $request->estatus_pago ?? $costo->estatus_pago,
                'observaciones' => $request->observaciones
            ]);
            
            Log::info('Costo actualizado ID: ' . $costo->id);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'data' => $costo,
                'message' => 'Costo directo actualizado correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al actualizar costo: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el costo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina un costo directo (soft delete)
     */
    public function destroy($id)
    {
        Log::info('=== COSTOS DIRECTOS: Eliminando ID: ' . $id);
        
        try {
            $costo = CostoDirecto::findOrFail($id);
            
            // Eliminar documentos asociados
            foreach ($costo->documentos as $documento) {
                Storage::disk('public')->delete($documento->ruta);
                $documento->delete();
            }
            
            $costo->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Costo directo eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al eliminar costo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el costo'
            ], 500);
        }
    }

    /**
     * Cambia el estatus de pago de un costo
     */
    public function cambiarEstatusPago(Request $request, $id)
    {
        Log::info('=== COSTOS DIRECTOS: Cambiando estatus ID: ' . $id . ' a: ' . $request->estatus);
        
        try {
            $costo = CostoDirecto::findOrFail($id);
            
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
                'message' => 'Error al cambiar el estatus'
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
     * Exporta costos a Excel/CSV
     */
    public function exportar(Request $request)
    {
        Log::info('=== COSTOS DIRECTOS: Exportando datos ===');
        
        try {
            $query = CostoDirecto::with(['proyecto']);
            
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
                    }
                } elseif (!is_array($proyectos) && $proyectos !== '' && $proyectos !== null) {
                    $query->where('proyecto_id', $proyectos);
                }
            }
            
            if ($request->filled('categoria') && $request->categoria !== 'todos') {
                $query->byCategoria($request->categoria);
            }
            
            $costos = $query->orderBy('fecha', 'desc')->get();
            
            // Preparar datos para CSV
            $headers = ['Proyecto', 'Categoría', 'Concepto', 'Fecha', 'Proveedor', 'RFC', 'Factura', 'Unidad', 'Cantidad', 'Precio Unit.', 'Subtotal', 'IVA', 'Total', 'Fecha Pago', 'Estatus', 'Observaciones'];
            $rows = $costos->map(function($costo) {
                return [
                    $costo->proyecto?->nombre ?? '-',
                    $costo->categoria_nombre,
                    $costo->concepto,
                    $costo->fecha?->format('d/m/Y'),
                    $costo->nombre_proveedor,
                    $costo->rfc ?? '-',
                    $costo->factura ?? '-',
                    $costo->unidad ?? '-',
                    $costo->cantidad,
                    $costo->precio_unitario,
                    $costo->subtotal,
                    $costo->iva,
                    $costo->total,
                    $costo->fecha_pago?->format('d/m/Y'),
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
                'message' => 'Error al exportar datos'
            ], 500);
        }
    }

    /**
     * Obtiene lista de proyectos para selects (con código y nombre)
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
     * Obtiene lista de empleados (mano de obra) para selects
     */
    public function empleados()
    {
        try {
            $empleados = Plantilla::where('estatus', 'Activo')
                ->select('plantilla_id as id', 'nombre', 'apellido_paterno', 'apellido_materno')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nombre_completo' => trim($item->nombre . ' ' . ($item->apellido_paterno ?? '') . ' ' . ($item->apellido_materno ?? ''))
                    ];
                });
            
            return response()->json([
                'success' => true,
                'data' => $empleados
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener empleados: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Error al obtener empleados'
            ]);
        }
    }

    /**
     * Sube un documento para un costo directo
     */
    public function subirDocumento(Request $request, $id)
    {
        Log::info('=== COSTOS DIRECTOS: Subiendo documento para ID: ' . $id);
        
        try {
            $request->validate([
                'documento' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx'
            ]);
            
            $costo = CostoDirecto::findOrFail($id);
            $file = $request->file('documento');
            
            $documento = $this->subirDocumentoArchivo($file, $costo->id);
            
            return response()->json([
                'success' => true,
                'data' => $documento,
                'message' => 'Documento subido correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al subir documento: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al subir el documento: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina un documento de un costo directo
     */
    public function eliminarDocumento($id, $documentoId)
    {
        Log::info('=== COSTOS DIRECTOS: Eliminando documento ID: ' . $documentoId . ' de costo ID: ' . $id);
        
        try {
            $documento = CostoDirectoDocumento::where('costo_directo_id', $id)
                ->where('id', $documentoId)
                ->firstOrFail();
            
            Storage::disk('public')->delete($documento->ruta);
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
            $documento = CostoDirectoDocumento::where('costo_directo_id', $id)
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
     * Calcula las estadísticas para los 4 cuadros
     * APLICANDO LOS MISMOS FILTROS (incluyendo múltiples proyectos)
     */
    private function calcularEstadisticas(Request $request): array
    {
        try {
            $query = CostoDirecto::query();
            
            // Aplicar filtro por múltiples proyectos (mismo que en index)
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

            // Totales por categoría
            $totalDirectos = (clone $query)->sum('total');
            $totalMateriales = (clone $query)->where('categoria', 'materiales')->sum('total');
            $totalManoObra = (clone $query)->where('categoria', 'mano_obra')->sum('total');
            $totalMaquinaria = (clone $query)->where('categoria', 'maquinaria')->sum('total');

            return [
                'total_directos' => $totalDirectos,
                'total_materiales' => $totalMateriales,
                'total_mano_obra' => $totalManoObra,
                'total_maquinaria' => $totalMaquinaria,
                'total_subcontratos' => (clone $query)->where('categoria', 'subcontratos')->sum('total'),
                'total_equipos' => (clone $query)->where('categoria', 'equipos')->sum('total'),
                'count' => (clone $query)->count(),
                'count_pagados' => (clone $query)->where('estatus_pago', 'pagado')->count(),
                'count_pendientes' => (clone $query)->where('estatus_pago', 'pendiente')->count(),
                'count_programados' => (clone $query)->where('estatus_pago', 'programado')->count(),
                'count_vencidos' => (clone $query)->where('estatus_pago', 'vencido')->count()
            ];
            
        } catch (\Exception $e) {
            Log::error('ERROR calcularEstadisticas: ' . $e->getMessage());
            return [
                'total_directos' => 0,
                'total_materiales' => 0,
                'total_mano_obra' => 0,
                'total_maquinaria' => 0,
                'total_subcontratos' => 0,
                'total_equipos' => 0,
                'count' => 0,
                'count_pagados' => 0,
                'count_pendientes' => 0,
                'count_programados' => 0,
                'count_vencidos' => 0
            ];
        }
    }

    /**
     * Sube un documento al almacenamiento
     */
    private function subirDocumentoArchivo($file, $costoId): CostoDirectoDocumento
    {
        $nombreOriginal = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $nombreUnico = uniqid() . '_' . time() . '.' . $extension;
        $ruta = $file->storeAs('costos_directos/documentos', $nombreUnico, 'public');
        
        return CostoDirectoDocumento::create([
            'costo_directo_id' => $costoId,
            'nombre_original' => $nombreOriginal,
            'nombre_unico' => $nombreUnico,
            'ruta' => $ruta,
            'tipo' => $file->getMimeType(),
            'tamanio' => $file->getSize(),
            'orden' => 0
        ]);
    }
}