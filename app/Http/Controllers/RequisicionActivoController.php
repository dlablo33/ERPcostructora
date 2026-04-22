<?php

namespace App\Http\Controllers;

use App\Models\RequisicionActivo;
use App\Models\AsignacionActivo;
use App\Models\Activo;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RequisicionActivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        $activos = Activo::where('estatus', 'Disponible')->orderBy('codigo')->get();
        
        return view('almacen.movimiento.requisiciones_devoluciones_equipo', compact('proyectos', 'activos'));
    }
    
    /**
     * Get requisiciones for DataTable.
     */
    public function getRequisiciones(Request $request)
    {
        try {
            \Log::info('getRequisiciones called');
            
            $query = RequisicionActivo::with(['proyecto', 'activo', 'autorizador', 'creador']);
            
            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }
            
            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha_requisicion', '>=', $request->fecha_inicio);
            }
            
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha_requisicion', '<=', $request->fecha_fin);
            }
            
            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);
            
            $requisiciones = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
            
            $data = $requisiciones->getCollection()->map(function($req) {
                return [
                    'id' => $req->id,
                    'folio' => $req->folio,
                    'fecha_requisicion' => $req->fecha_requisicion->format('d/m/Y'),
                    'fecha_requerida' => $req->fecha_requerida->format('d/m/Y'),
                    'proyecto_nombre' => $req->proyecto->nombre,
                    'solicitante' => $req->solicitante,
                    'activo_nombre' => $req->activo->nombre,
                    'activo_codigo' => $req->activo->codigo,
                    'cantidad' => $req->cantidad,
                    'prioridad' => $req->prioridad,
                    'estatus' => $req->estatus,
                    'motivo' => $req->motivo,
                    'observaciones' => $req->observaciones,
                    'autorizado_por' => $req->autorizador ? $req->autorizador->name : null,
                    'fecha_autorizacion' => $req->fecha_autorizacion ? $req->fecha_autorizacion->format('d/m/Y H:i') : null,
                    'created_at' => $req->created_at->format('d/m/Y H:i')
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'total' => $requisiciones->total(),
                'per_page' => $requisiciones->perPage(),
                'current_page' => $requisiciones->currentPage(),
                'last_page' => $requisiciones->lastPage()
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error en getRequisiciones: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar requisiciones: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Store a newly created requisition.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'proyecto_id' => 'required|exists:proyectos,id',
                'activo_id' => 'required|exists:activos,id',
                'fecha_requerida' => 'required|date',
                'solicitante' => 'required|string|max:100',
                'prioridad' => 'required|in:Baja,Media,Alta,Urgente',
                'motivo' => 'required|string',
                'observaciones' => 'nullable|string'
            ]);
            
            DB::beginTransaction();
            
            $requisicion = RequisicionActivo::create([
                'folio' => RequisicionActivo::generarFolio(),
                'proyecto_id' => $request->proyecto_id,
                'activo_id' => $request->activo_id,
                'cantidad' => $request->cantidad ?? 1,
                'fecha_requisicion' => now(),
                'fecha_requerida' => $request->fecha_requerida,
                'solicitante' => $request->solicitante,
                'area' => $request->area,
                'prioridad' => $request->prioridad,
                'motivo' => $request->motivo,
                'observaciones' => $request->observaciones,
                'estatus' => 'Pendiente',
                'creado_por' => auth()->id()
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Requisición creada exitosamente',
                'data' => $requisicion->load(['proyecto', 'activo'])
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al crear requisición: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al crear requisición: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Display the specified requisition.
     */
    public function show($id)
    {
        try {
            $requisicion = RequisicionActivo::with([
                'proyecto', 'activo', 'autorizador', 'creador', 'asignacion'
            ])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $requisicion->id,
                    'folio' => $requisicion->folio,
                    'proyecto_id' => $requisicion->proyecto_id,
                    'proyecto_nombre' => $requisicion->proyecto->nombre,
                    'activo_id' => $requisicion->activo_id,
                    'activo_nombre' => $requisicion->activo->nombre,
                    'activo_codigo' => $requisicion->activo->codigo,
                    'cantidad' => $requisicion->cantidad,
                    'fecha_requisicion' => $requisicion->fecha_requisicion->format('Y-m-d'),
                    'fecha_requerida' => $requisicion->fecha_requerida->format('Y-m-d'),
                    'solicitante' => $requisicion->solicitante,
                    'area' => $requisicion->area,
                    'prioridad' => $requisicion->prioridad,
                    'motivo' => $requisicion->motivo,
                    'observaciones' => $requisicion->observaciones,
                    'estatus' => $requisicion->estatus,
                    'motivo_rechazo' => $requisicion->motivo_rechazo,
                    'autorizado_por' => $requisicion->autorizador ? $requisicion->autorizador->name : null,
                    'fecha_autorizacion' => $requisicion->fecha_autorizacion ? $requisicion->fecha_autorizacion->format('d/m/Y H:i') : null,
                    'asignacion' => $requisicion->asignacion ? [
                        'id' => $requisicion->asignacion->id,
                        'fecha_salida' => $requisicion->asignacion->fecha_salida,
                        'responsable_asignado' => $requisicion->asignacion->responsable_asignado,
                        'estatus' => $requisicion->asignacion->estatus
                    ] : null
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error en show: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Requisición no encontrada: ' . $e->getMessage()
            ], 404);
        }
    }
    
    /**
     * Authorize requisition.
     */
    public function autorizar(Request $request, $id)
    {
        try {
            $requisicion = RequisicionActivo::findOrFail($id);
            
            if ($requisicion->estatus !== 'Pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'La requisición no está en estado Pendiente'
                ], 400);
            }
            
            DB::beginTransaction();
            
            $requisicion->update([
                'estatus' => 'Aprobada',
                'autorizado_por' => auth()->id(),
                'fecha_autorizacion' => now(),
                'observaciones' => $request->observaciones
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Requisición autorizada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al autorizar requisición: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al autorizar requisición: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Reject requisition.
     */
    public function rechazar(Request $request, $id)
    {
        try {
            $request->validate([
                'motivo' => 'required|string|min:5'
            ]);
            
            $requisicion = RequisicionActivo::findOrFail($id);
            
            if ($requisicion->estatus !== 'Pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'La requisición no está en estado Pendiente'
                ], 400);
            }
            
            DB::beginTransaction();
            
            $requisicion->update([
                'estatus' => 'Rechazada',
                'autorizado_por' => auth()->id(),
                'fecha_autorizacion' => now(),
                'motivo_rechazo' => $request->motivo
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Requisición rechazada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al rechazar requisición: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al rechazar requisición: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Delete requisition.
     */
    public function destroy($id)
    {
        try {
            $requisicion = RequisicionActivo::findOrFail($id);
            
            if ($requisicion->estatus !== 'Pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden eliminar requisiciones en estado Pendiente'
                ], 400);
            }
            
            $requisicion->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Requisición eliminada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error al eliminar requisición: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar requisición: ' . $e->getMessage()
            ], 500);
        }
    }
}