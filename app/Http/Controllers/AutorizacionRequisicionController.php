<?php

namespace App\Http\Controllers;

use App\Models\Requisicion;
use App\Models\RequisicionArticulo;
use App\Models\Area;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AutorizacionRequisicionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Requisicion::with(['area', 'proyecto', 'articulos']);
            
            // Filtros
            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }
            
            if ($request->filled('area_id')) {
                $query->where('area_id', $request->area_id);
            }
            
            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha_requerimiento', '>=', $request->fecha_inicio);
            }
            
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha_requerimiento', '<=', $request->fecha_fin);
            }
            
            if ($request->filled('buscar')) {
                $query->where(function($q) use ($request) {
                    $q->where('folio', 'LIKE', "%{$request->buscar}%")
                      ->orWhere('solicitante', 'LIKE', "%{$request->buscar}%");
                });
            }
            
            $requisiciones = $query->orderBy('id', 'desc')->get();
            
            // Obtener áreas y proyectos para filtros
            $areas = Area::all();
            $proyectos = Proyecto::all();
            
            return view('compras.requisicion.autorizacion', [
                'requisiciones' => $requisiciones,
                'areas' => $areas,
                'proyectos' => $proyectos
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en AutorizacionRequisicionController@index: ' . $e->getMessage());
            
            return view('compras.requisicion.autorizacion', [
                'requisiciones' => collect([]),
                'areas' => Area::all(),
                'proyectos' => Proyecto::all()
            ])->with('error', 'Error al cargar requisiciones: ' . $e->getMessage());
        }
    }

    /**
     * Get requisiciones for DataTable
     */
    public function getRequisiciones(Request $request)
{
    try {
        $requisiciones = Requisicion::orderBy('id', 'desc')->get();
        
        $data = $requisiciones->map(function($req) {
            return [
                'id' => $req->id,
                'folio' => $req->folio,
                'estatus' => $req->estatus,
                'fecha_requerimiento' => $req->fecha_requerimiento ? date('d/m/Y', strtotime($req->fecha_requerimiento)) : '',
                'solicitante' => $req->solicitante,
                'cotizadas' => $req->cotizadas ?? 0,
                'cotizadas_texto' => ($req->cotizadas ?? 0) . '/' . $req->articulos->count(),
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Autorizar una requisición
     */
    /**
 * Autorizar una requisición
 */
public function autorizar(Request $request, $id)
{
    try {
        $request->validate([
            'observaciones' => 'nullable|string|max:500'
        ]);
        
        DB::beginTransaction();
        
        $requisicion = Requisicion::findOrFail($id);
        
        // Validar que esté en estado Pendiente
        if ($requisicion->estatus !== 'Pendiente') {
            return response()->json([
                'success' => false,
                'message' => 'La requisición no está en estado Pendiente'
            ], 400);
        }
        
        // USAR 'Activo' en lugar de 'Autorizada'
        $requisicion->update([
            'estatus' => 'Activo',  // Cambiado de 'Autorizada' a 'Activo'
            'aprobado_por' => Auth::id(),
            'fecha_aprobacion' => now(),
        ]);
        
        DB::commit();
        
        return response()->json([
            'success' => true,
            'message' => 'Requisición autorizada correctamente',
            'data' => $requisicion
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error al autorizar requisición: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error al autorizar: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Rechazar una requisición
 */
public function rechazar(Request $request, $id)
{
    try {
        $request->validate([
            'motivo' => 'required|string|min:5|max:500'
        ]);
        
        DB::beginTransaction();
        
        $requisicion = Requisicion::findOrFail($id);
        
        // Validar que esté en estado Pendiente
        if ($requisicion->estatus !== 'Pendiente') {
            return response()->json([
                'success' => false,
                'message' => 'La requisición no está en estado Pendiente'
            ], 400);
        }
        
        // USAR 'Cancelado' en lugar de 'Rechazada'
        $requisicion->update([
            'estatus' => 'Cancelado',  // Cambiado de 'Rechazada' a 'Cancelado'
            'aprobado_por' => Auth::id(),
            'fecha_aprobacion' => now(),
            'motivo_rechazo' => $request->motivo
        ]);
        
        DB::commit();
        
        return response()->json([
            'success' => true,
            'message' => 'Requisición rechazada correctamente',
            'data' => $requisicion
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error al rechazar requisición: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error al rechazar: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Revertir autorización
 */
public function revertirAutorizacion($id)
{
    try {
        DB::beginTransaction();
        
        $requisicion = Requisicion::findOrFail($id);
        
        // Validar que esté en estado Activo o Cancelado
        if (!in_array($requisicion->estatus, ['Activo', 'Cancelado'])) {
            return response()->json([
                'success' => false,
                'message' => 'Solo se pueden revertir requisiciones Activas o Canceladas'
            ], 400);
        }
        
        $requisicion->update([
            'estatus' => 'Pendiente',
            'aprobado_por' => null,
            'fecha_aprobacion' => null,
            'motivo_rechazo' => null,
        ]);
        
        DB::commit();
        
        return response()->json([
            'success' => true,
            'message' => 'Autorización revertida correctamente'
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error al revertir autorización: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error al revertir: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Reabrir una requisición
 */
public function reabrir($id)
{
    try {
        DB::beginTransaction();
        
        $requisicion = Requisicion::findOrFail($id);
        
        // Validar que esté cancelada
        if ($requisicion->estatus !== 'Cancelado') {
            return response()->json([
                'success' => false,
                'message' => 'Solo se pueden reabrir requisiciones Canceladas'
            ], 400);
        }
        
        $requisicion->update([
            'estatus' => 'Pendiente',
            'aprobado_por' => null,
            'fecha_aprobacion' => null,
            'motivo_rechazo' => null,
        ]);
        
        DB::commit();
        
        return response()->json([
            'success' => true,
            'message' => 'Requisición reabierta correctamente'
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error al reabrir requisición: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error al reabrir: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Rechazar una requisición
     */
    

    /**
     * Revertir autorización (para pruebas o correcciones)
     */
    

    /**
     * Reabrir una requisición rechazada
     */
    

    /**
     * Obtener detalle de una requisición para el modal
     */
    /**
 * Obtener detalle de una requisición para el modal
 */
public function detalle($id)
{
    try {
        $requisicion = Requisicion::with(['area', 'proyecto', 'articulos', 'creador', 'aprobador'])->findOrFail($id);
        
        // CORREGIDO: Manejar el área correctamente (puede ser objeto o string)
        $areaNombre = '';
        if ($requisicion->area) {
            if (is_object($requisicion->area) && method_exists($requisicion->area, 'nombre')) {
                $areaNombre = $requisicion->area->nombre;
            } else {
                $areaNombre = $requisicion->area; // Ya es un string
            }
        }
        
        // CORREGIDO: Manejar el proyecto correctamente
        $proyectoNombre = '';
        if ($requisicion->proyecto) {
            if (is_object($requisicion->proyecto) && method_exists($requisicion->proyecto, 'nombre')) {
                $proyectoNombre = $requisicion->proyecto->nombre;
            } else if (is_string($requisicion->proyecto)) {
                $proyectoNombre = $requisicion->proyecto;
            }
        }
        
        // CORREGIDO: Obtener nombre del aprobador
        $aprobadoPorNombre = '';
        if ($requisicion->aprobador) {
            $aprobadoPorNombre = $requisicion->aprobador->name ?? $requisicion->aprobador->nombre ?? 'Usuario';
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $requisicion->id,
                'folio' => $requisicion->folio,
                'fecha_requerimiento' => $requisicion->fecha_requerimiento ? date('d/m/Y', strtotime($requisicion->fecha_requerimiento)) : '',
                'solicitante' => $requisicion->solicitante,
                'area' => $areaNombre,
                'proyecto' => $proyectoNombre,
                'estatus' => $requisicion->estatus,
                'observaciones' => $requisicion->observaciones,
                'motivo_rechazo' => $requisicion->motivo_rechazo,
                'fecha_aprobacion' => $requisicion->fecha_aprobacion ? date('d/m/Y H:i', strtotime($requisicion->fecha_aprobacion)) : '',
                'aprobado_por' => $aprobadoPorNombre,
                'articulos' => $requisicion->articulos->map(function($art) {
                    return [
                        'id' => $art->id,
                        'codigo' => $art->codigo,
                        'cantidad' => $art->cantidad,
                        'unidad_medida' => $art->unidad_medida,
                        'descripcion' => $art->descripcion,
                        'observacion' => $art->observacion,
                        'pendiente' => $art->pendiente,
                        'cantidad_surtida' => $art->cantidad_surtida ?? 0,
                    ];
                })
            ]
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error al obtener detalle: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        
        return response()->json([
            'success' => false,
            'message' => 'Error al obtener detalle: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Exportar a Excel
     */
    public function exportar(Request $request)
    {
        try {
            $query = Requisicion::with(['area', 'proyecto']);
            
            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha_requerimiento', '>=', $request->fecha_inicio);
            }
            
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha_requerimiento', '<=', $request->fecha_fin);
            }
            
            $requisiciones = $query->orderBy('id', 'desc')->get();
            
            // Aquí implementarías la exportación real a Excel
            // Por ahora devolvemos JSON
            
            return response()->json([
                'success' => true,
                'message' => 'Exportación exitosa',
                'total' => $requisiciones->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al exportar: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }
}