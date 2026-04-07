<?php

namespace App\Http\Controllers;

use App\Models\ListaAsistencia;
use App\Models\DetalleListaAsistencia;
use App\Models\Plantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ListaAsistenciaController extends Controller
{
    /**
     * Display a listing of attendance lists grouped by date
     */
    public function index(Request $request)
    {
        try {
            $query = ListaAsistencia::with('detalles')
                ->orderBy('fecha', 'desc');
            
            // Filtro por fecha
            if ($request->has('fecha_inicio') && $request->fecha_inicio) {
                $query->whereDate('fecha', '>=', $request->fecha_inicio);
            }
            
            if ($request->has('fecha_fin') && $request->fecha_fin) {
                $query->whereDate('fecha', '<=', $request->fecha_fin);
            }
            
            $listas = $query->get();
            
            return view('rh.asistencia.lista', compact('listas'));
            
        } catch (\Exception $e) {
            Log::error('Error en ListaAsistenciaController@index: ' . $e->getMessage());
            $listas = collect([]);
            return view('rh.asistencia.lista', compact('listas'));
        }
    }
    
    /**
     * Generate daily attendance list from plantilla (todos los empleados activos)
     */
    public function generarListaDiaria(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'fecha' => 'required|date'
            ]);
            
            $fecha = $request->fecha;
            
            // Verificar si ya existe lista para esta fecha
            $existe = ListaAsistencia::where('fecha', $fecha)->exists();
            if ($existe) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe una lista de asistencia para esta fecha'
                ], 400);
            }
            
            // Obtener todos los empleados activos de la plantilla
            $empleados = Plantilla::where('estatus', 'Activo')
                ->orWhere('estatus', '1')
                ->select('plantilla_id as id', 'nombre', 'apellido_paterno', 'apellido_materno', 'puesto')
                ->orderBy('nombre')
                ->get();
            
            if ($empleados->count() == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay empleados activos en la plantilla'
                ], 400);
            }
            
            // Crear la lista principal
            $folio = ListaAsistencia::generarFolio($fecha);
            $lista = ListaAsistencia::create([
                'folio' => $folio,
                'fecha' => $fecha,
                'total_empleados' => $empleados->count(),
                'presentes' => 0,
                'retardos' => 0,
                'ausentes' => $empleados->count(),
                'justificados' => 0,
                'cerrada' => false,
                'creado_por' => auth()->id()
            ]);
            
            // Crear los detalles para cada empleado
            foreach ($empleados as $empleado) {
                $nombreCompleto = trim($empleado->nombre . ' ' . $empleado->apellido_paterno . ' ' . $empleado->apellido_materno);
                
                DetalleListaAsistencia::create([
                    'lista_asistencia_id' => $lista->id,
                    'empleado_id' => $empleado->id,
                    'empleado_nombre' => $nombreCompleto,
                    'puesto' => $empleado->puesto ?? 'N/A',
                    'hora_entrada' => null,
                    'hora_salida' => null,
                    'estado' => 'ausente',
                    'observaciones' => null,
                    'horas_trabajadas' => 0,
                    'justificado' => false
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => "Lista de asistencia generada exitosamente para el día " . date('d/m/Y', strtotime($fecha)),
                'data' => [
                    'lista' => $lista,
                    'total_empleados' => $empleados->count()
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en generarListaDiaria: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Store a new daily attendance list (manual selection)
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'fecha' => 'required|date',
                'empleados' => 'required|array',
                'empleados.*.id' => 'required',
                'empleados.*.nombre' => 'required|string',
                'empleados.*.puesto' => 'nullable|string'
            ]);
            
            // Verificar si ya existe lista para esta fecha
            $existe = ListaAsistencia::where('fecha', $request->fecha)->exists();
            if ($existe) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe una lista de asistencia para esta fecha'
                ], 400);
            }
            
            // Crear la lista principal
            $folio = ListaAsistencia::generarFolio($request->fecha);
            $lista = ListaAsistencia::create([
                'folio' => $folio,
                'fecha' => $request->fecha,
                'total_empleados' => 0,
                'presentes' => 0,
                'retardos' => 0,
                'ausentes' => 0,
                'justificados' => 0,
                'cerrada' => false,
                'creado_por' => auth()->id()
            ]);
            
            // Crear los detalles
            foreach ($request->empleados as $empleado) {
                DetalleListaAsistencia::create([
                    'lista_asistencia_id' => $lista->id,
                    'empleado_id' => $empleado['id'],
                    'empleado_nombre' => $empleado['nombre'],
                    'puesto' => $empleado['puesto'] ?? null,
                    'hora_entrada' => null,
                    'hora_salida' => null,
                    'estado' => 'ausente',
                    'observaciones' => null,
                    'horas_trabajadas' => 0,
                    'justificado' => false
                ]);
            }
            
            // Actualizar estadísticas
            $lista->actualizarEstadisticas();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Lista de asistencia creada exitosamente',
                'data' => $lista
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en store: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Display attendance details for a specific date
     */
    public function show($fecha)
    {
        try {
            $lista = ListaAsistencia::where('fecha', $fecha)
                ->with('detalles')
                ->first();
            
            if (!$lista) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró lista para esta fecha'
                ], 404);
            }
            
            $resumen = [
                'total' => $lista->total_empleados,
                'presentes' => $lista->presentes,
                'retardos' => $lista->retardos,
                'ausentes' => $lista->ausentes,
                'justificados' => $lista->justificados
            ];
            
            // Formatear detalles para la vista
            $detallesFormateados = $lista->detalles->map(function($detalle) {
                return [
                    'id' => $detalle->id,
                    'empleado_id' => $detalle->empleado_id,
                    'empleado_nombre' => $detalle->empleado_nombre,
                    'puesto' => $detalle->puesto,
                    'hora_entrada' => $detalle->hora_entrada,
                    'hora_salida' => $detalle->hora_salida,
                    'estado' => $detalle->estado,
                    'observaciones' => $detalle->observaciones,
                    'horas_trabajadas' => $detalle->horas_trabajadas,
                    'justificado' => $detalle->justificado
                ];
            });
            
            return response()->json([
                'success' => true,
                'fecha' => $fecha,
                'folio' => $lista->folio,
                'detalles' => $detallesFormateados,
                'resumen' => $resumen
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en show: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update a specific attendance detail
     */
    public function updateDetalle(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $detalle = DetalleListaAsistencia::findOrFail($id);
            
            $request->validate([
                'hora_entrada' => 'nullable',
                'hora_salida' => 'nullable',
                'estado' => 'required|in:presente,retardo,ausente,justificado',
                'observaciones' => 'nullable|string'
            ]);
            
            $horasTrabajadas = 0;
            if ($request->hora_entrada && $request->hora_salida) {
                $horasTrabajadas = DetalleListaAsistencia::calcularHorasTrabajadas(
                    $request->hora_entrada,
                    $request->hora_salida
                );
            }
            
            $detalle->update([
                'hora_entrada' => $request->hora_entrada,
                'hora_salida' => $request->hora_salida,
                'estado' => $request->estado,
                'observaciones' => $request->observaciones,
                'horas_trabajadas' => $horasTrabajadas
            ]);
            
            // Actualizar estadísticas de la lista
            $detalle->lista->actualizarEstadisticas();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Asistencia actualizada correctamente',
                'data' => $detalle
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en updateDetalle: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Delete an entire attendance list for a specific date
     */
    public function destroy($fecha)
    {
        try {
            DB::beginTransaction();
            
            $lista = ListaAsistencia::where('fecha', $fecha)->first();
            
            if (!$lista) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lista no encontrada'
                ], 404);
            }
            
            $lista->delete(); // Esto eliminará los detalles por cascade
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Lista de asistencia eliminada correctamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en destroy: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get employees for the modal
     */
    public function getEmpleados()
    {
        try {
            $empleados = Plantilla::where('estatus', 'Activo')
                ->orWhere('estatus', '1')
                ->select('plantilla_id as id', 'nombre', 'apellido_paterno', 'apellido_materno', 'puesto')
                ->orderBy('nombre')
                ->get()
                ->map(function($emp) {
                    $emp->nombre_completo = trim($emp->nombre . ' ' . $emp->apellido_paterno . ' ' . $emp->apellido_materno);
                    return $emp;
                });
            
            return response()->json([
                'success' => true,
                'data' => $empleados
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getEmpleados: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data' => []
            ]);
        }
    }
    
    /**
     * Get summary statistics of all attendance lists
     */
    public function getResumenGeneral()
    {
        try {
            $totalListas = ListaAsistencia::count();
            $totalEmpleadosRegistrados = ListaAsistencia::sum('total_empleados');
            $totalPresentes = ListaAsistencia::sum('presentes');
            $totalRetardos = ListaAsistencia::sum('retardos');
            $totalAusentes = ListaAsistencia::sum('ausentes');
            $totalJustificados = ListaAsistencia::sum('justificados');
            
            return response()->json([
                'success' => true,
                'data' => [
                    'total_listas' => $totalListas,
                    'total_empleados_registrados' => $totalEmpleadosRegistrados,
                    'total_presentes' => $totalPresentes,
                    'total_retardos' => $totalRetardos,
                    'total_ausentes' => $totalAusentes,
                    'total_justificados' => $totalJustificados
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getResumenGeneral: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener resumen'
            ], 500);
        }
    }
}