<?php

namespace App\Http\Controllers;

use App\Models\AsignacionActivo;
use App\Models\RequisicionActivo;
use App\Models\Activo;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DevolucionActivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        $asignaciones = AsignacionActivo::with(['activo', 'proyecto', 'requisicion'])
            ->where('estatus', 'Activa')
            ->get();
        
        return view('activos.devoluciones', compact('proyectos', 'asignaciones'));
    }
    
    /**
     * Get devoluciones for DataTable.
     */
    public function getDevoluciones(Request $request)
    {
        try {
            $query = AsignacionActivo::with(['activo', 'proyecto', 'requisicion', 'recibidoPor']);
            
            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }
            
            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha_salida', '>=', $request->fecha_inicio);
            }
            
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha_salida', '<=', $request->fecha_fin);
            }
            
            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);
            
            $devoluciones = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
            
            $data = $devoluciones->getCollection()->map(function($asignacion) {
                $datosEspecificos = $asignacion->activo->getDatosEspecificos();
                $medida = $asignacion->activo->tipo_activo === 'maquinaria' ? 'Horas' : ($asignacion->activo->tipo_activo === 'vehiculo' ? 'Km' : null);
                $valorSalida = $asignacion->activo->tipo_activo === 'maquinaria' ? $asignacion->horometro_salida : $asignacion->kilometraje_salida;
                $valorDevolucion = $asignacion->activo->tipo_activo === 'maquinaria' ? $asignacion->horometro_devolucion : $asignacion->kilometraje_devolucion;
                $diferencia = $valorDevolucion && $valorSalida ? $valorDevolucion - $valorSalida : null;
                
                return [
                    'id' => $asignacion->id,
                    'folio_requisicion' => $asignacion->requisicion ? $asignacion->requisicion->folio : null,
                    'fecha_salida' => $asignacion->fecha_salida->format('d/m/Y'),
                    'fecha_devolucion' => $asignacion->fecha_devolucion_real ? $asignacion->fecha_devolucion_real->format('d/m/Y') : null,
                    'proyecto_nombre' => $asignacion->proyecto->nombre,
                    'responsable_asignado' => $asignacion->responsable_asignado,
                    'activo_nombre' => $asignacion->activo->nombre,
                    'activo_codigo' => $asignacion->activo->codigo,
                    'valor_salida' => $valorSalida,
                    'valor_devolucion' => $valorDevolucion,
                    'diferencia' => $diferencia,
                    'unidad_medida' => $medida,
                    'condicion_salida' => $asignacion->condicion_salida,
                    'condicion_devolucion' => $asignacion->condicion_devolucion,
                    'reporte_danos' => $asignacion->reporte_danos,
                    'estatus' => $asignacion->estatus,
                    'recibido_por' => $asignacion->recibidoPor ? $asignacion->recibidoPor->name : null
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'total' => $devoluciones->total(),
                'per_page' => $devoluciones->perPage(),
                'current_page' => $devoluciones->currentPage(),
                'last_page' => $devoluciones->lastPage()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getDevoluciones: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar devoluciones: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Register a new assignment (salida).
     */
    public function registrarSalida(Request $request)
    {
        try {
            $request->validate([
                'requisicion_id' => 'required|exists:requisiciones_activos,id',
                'responsable_asignado' => 'required|string|max:100',
                'fecha_salida' => 'required|date',
                'condicion_salida' => 'required|in:Excelente,Bueno,Regular,Malo',
                'horometro_salida' => 'nullable|numeric|min:0',
                'kilometraje_salida' => 'nullable|numeric|min:0'
            ]);
            
            DB::beginTransaction();
            
            $requisicion = RequisicionActivo::findOrFail($request->requisicion_id);
            
            if ($requisicion->estatus !== 'Aprobada') {
                return response()->json([
                    'success' => false,
                    'message' => 'La requisición debe estar Aprobada para registrar salida'
                ], 400);
            }
            
            $asignacion = AsignacionActivo::create([
                'requisicion_id' => $requisicion->id,
                'activo_id' => $requisicion->activo_id,
                'proyecto_id' => $requisicion->proyecto_id,
                'responsable_asignado' => $request->responsable_asignado,
                'fecha_salida' => $request->fecha_salida,
                'horometro_salida' => $request->horometro_salida,
                'kilometraje_salida' => $request->kilometraje_salida,
                'condicion_salida' => $request->condicion_salida,
                'observaciones_salida' => $request->observaciones_salida,
                'estatus' => 'Activa'
            ]);
            
            // Actualizar estatus de la requisición
            $requisicion->update(['estatus' => 'Asignada']);
            
            // Actualizar estatus del activo
            $activo = Activo::find($requisicion->activo_id);
            $activo->update([
                'estatus' => 'Asignado',
                'proyecto_asignado_id' => $requisicion->proyecto_id,
                'fecha_asignacion' => now()
            ]);
            
            // Actualizar horómetro/kilometraje si aplica
            if ($activo->tipo_activo === 'maquinaria' && $activo->maquinaria && $request->horometro_salida) {
                $activo->maquinaria->update(['horometro_actual' => $request->horometro_salida]);
            } elseif ($activo->tipo_activo === 'vehiculo' && $activo->vehiculo && $request->kilometraje_salida) {
                $activo->vehiculo->update(['kilometraje_actual' => $request->kilometraje_salida]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Salida registrada exitosamente',
                'data' => $asignacion
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar salida: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar salida: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Register a return (devolucion).
     */
    public function registrarDevolucion(Request $request, $id)
    {
        try {
            $request->validate([
                'fecha_devolucion' => 'required|date',
                'condicion_devolucion' => 'required|in:Excelente,Bueno,Regular,Malo,Danado',
                'horometro_devolucion' => 'nullable|numeric|min:0',
                'kilometraje_devolucion' => 'nullable|numeric|min:0',
                'reporte_danos' => 'required_if:condicion_devolucion,Danado|nullable|string',
                'costo_reparacion' => 'nullable|numeric|min:0'
            ]);
            
            DB::beginTransaction();
            
            $asignacion = AsignacionActivo::with(['activo', 'requisicion'])->findOrFail($id);
            
            if ($asignacion->estatus !== 'Activa') {
                return response()->json([
                    'success' => false,
                    'message' => 'La asignación no está activa'
                ], 400);
            }
            
            $data = [
                'fecha_devolucion_real' => $request->fecha_devolucion,
                'condicion_devolucion' => $request->condicion_devolucion,
                'observaciones_devolucion' => $request->observaciones_devolucion,
                'reporte_danos' => $request->reporte_danos,
                'costo_reparacion' => $request->costo_reparacion,
                'recibido_por' => auth()->id(),
                'estatus' => 'Devuelta'
            ];
            
            if ($request->horometro_devolucion) {
                $data['horometro_devolucion'] = $request->horometro_devolucion;
            }
            
            if ($request->kilometraje_devolucion) {
                $data['kilometraje_devolucion'] = $request->kilometraje_devolucion;
            }
            
            $asignacion->devolver($data);
            
            // Actualizar requisición
            if ($asignacion->requisicion) {
                $asignacion->requisicion->update(['estatus' => 'Devuelta']);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Devolución registrada exitosamente',
                'data' => $asignacion
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar devolución: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar devolución: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get active assignments for a project.
     */
    public function getAsignacionesActivas(Request $request)
    {
        try {
            $query = AsignacionActivo::with(['activo', 'proyecto'])
                ->where('estatus', 'Activa');
            
            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_id', $request->proyecto_id);
            }
            
            $asignaciones = $query->get();
            
            return response()->json([
                'success' => true,
                'data' => $asignaciones->map(function($asignacion) {
                    return [
                        'id' => $asignacion->id,
                        'activo_nombre' => $asignacion->activo->nombre,
                        'activo_codigo' => $asignacion->activo->codigo,
                        'responsable_asignado' => $asignacion->responsable_asignado,
                        'fecha_salida' => $asignacion->fecha_salida->format('d/m/Y'),
                        'dias_transcurridos' => $asignacion->fecha_salida->diffInDays(now())
                    ];
                })
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar asignaciones: ' . $e->getMessage()
            ], 500);
        }
    }
}