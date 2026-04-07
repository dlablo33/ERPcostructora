<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\DetalleListaAsistencia;
use App\Models\ListaAsistencia;
use App\Models\Plantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ControlHorariosController extends Controller
{
    /**
     * Display a listing of the resource with pagination.
     */
    public function index(Request $request)
{
    try {
        $fecha = $request->get('fecha', date('Y-m-d'));
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search', '');
        
        // Obtener la lista de asistencia para la fecha seleccionada
        $lista = ListaAsistencia::where('fecha', $fecha)->first();
        
        if ($lista) {
            // Query base para los detalles
            $query = DetalleListaAsistencia::where('lista_asistencia_id', $lista->id)
                ->with('lista');
            
            // Aplicar búsqueda si existe
            if (!empty($search)) {
                $query->where('empleado_nombre', 'ILIKE', "%{$search}%");
            }
            
            // Obtener el total de registros (para estadísticas)
            $totalDetallesQuery = clone $query;
            $total = $totalDetallesQuery->count();
            
            // Calcular estadísticas (presentes, retardos, ausentes, justificados) - SOBRE EL TOTAL FILTRADO
            $presentes = (clone $query)->where('estado', 'presente')->count();
            $retardos = (clone $query)->where('estado', 'retardo')->count();
            $ausentes = (clone $query)->where('estado', 'ausente')->count();
            $justificados = (clone $query)->where('estado', 'justificado')->count();
            
            // Aplicar ordenamiento y paginación para los registros a mostrar
            $query->orderBy('empleado_nombre');
            $detalles = $query->paginate($perPage, ['*'], 'page', $page);
            
            $registros = $detalles->map(function($detalle) {
                return [
                    'id' => $detalle->id,
                    'empleado_nombre' => $detalle->empleado_nombre,
                    'puesto' => $detalle->puesto,
                    'fecha' => $detalle->lista->fecha,
                    'hora_entrada' => $detalle->hora_entrada,
                    'hora_salida' => $detalle->hora_salida,
                    'horas_trabajadas' => $detalle->horas_trabajadas,
                    'estado' => $detalle->estado,
                    'observaciones' => $detalle->observaciones,
                    'justificado' => $detalle->justificado
                ];
            });
            
            $totalEmpleados = $lista->total_empleados;
            
            // Guardar el paginador para la vista
            $paginador = $detalles;
        } else {
            $registros = collect([]);
            $paginador = null;
            $total = 0;
            $presentes = 0;
            $retardos = 0;
            $ausentes = 0;
            $justificados = 0;
            $totalEmpleados = Plantilla::where('estatus', 'Activo')->count();
        }
        
        // Obtener empleados para el select del modal
        $empleados = Plantilla::where('estatus', 'Activo')
            ->select('plantilla_id as id', 'nombre', 'apellido_paterno', 'apellido_materno')
            ->orderBy('nombre')
            ->get()
            ->map(function($emp) {
                $emp->nombre_completo = trim($emp->nombre . ' ' . $emp->apellido_paterno . ' ' . $emp->apellido_materno);
                return $emp;
            });
        
        return view('rh.asistencia.control', compact(
            'registros',
            'paginador',
            'total',
            'presentes',
            'retardos',
            'ausentes',
            'justificados',
            'totalEmpleados',
            'fecha',
            'empleados',
            'perPage',
            'search'
        ));
        
    } catch (\Exception $e) {
        Log::error('Error en ControlHorariosController@index: ' . $e->getMessage());
        
        $registros = collect([]);
        $paginador = null;
        $total = 0;
        $presentes = 0;
        $retardos = 0;
        $ausentes = 0;
        $justificados = 0;
        $totalEmpleados = Plantilla::where('estatus', 'Activo')->count();
        $fecha = date('Y-m-d');
        $empleados = collect([]);
        $perPage = 10;
        $search = '';
        
        return view('rh.asistencia.control', compact(
            'registros',
            'paginador',
            'total',
            'presentes',
            'retardos',
            'ausentes',
            'justificados',
            'totalEmpleados',
            'fecha',
            'empleados',
            'perPage',
            'search'
        ));
    }
}
    
    /**
     * Registrar entrada o salida manual
     */
    public function registrar(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'empleado_id' => 'required',
                'tipo_registro' => 'required|in:entrada,salida,ambos',
                'hora' => 'required',
                'observaciones' => 'nullable|string'
            ]);
            
            $fecha = date('Y-m-d');
            $empleado = Plantilla::find($request->empleado_id);
            
            if (!$empleado) {
                return response()->json([
                    'success' => false,
                    'message' => 'Empleado no encontrado'
                ], 404);
            }
            
            // Buscar o crear la lista de asistencia para hoy
            $lista = ListaAsistencia::where('fecha', $fecha)->first();
            
            if (!$lista) {
                // Crear lista si no existe
                $empleadosActivos = Plantilla::where('estatus', 'Activo')->get();
                $folio = ListaAsistencia::generarFolio($fecha);
                
                $lista = ListaAsistencia::create([
                    'folio' => $folio,
                    'fecha' => $fecha,
                    'total_empleados' => $empleadosActivos->count(),
                    'presentes' => 0,
                    'retardos' => 0,
                    'ausentes' => $empleadosActivos->count(),
                    'justificados' => 0,
                    'cerrada' => false,
                    'creado_por' => auth()->id()
                ]);
                
                // Crear detalles para todos los empleados
                foreach ($empleadosActivos as $emp) {
                    DetalleListaAsistencia::create([
                        'lista_asistencia_id' => $lista->id,
                        'empleado_id' => $emp->plantilla_id,
                        'empleado_nombre' => $emp->nombre_completo,
                        'puesto' => $emp->puesto ? $emp->puesto->nombre : 'N/A',
                        'estado' => 'ausente'
                    ]);
                }
            }
            
            // Buscar el detalle del empleado
            $detalle = DetalleListaAsistencia::where('lista_asistencia_id', $lista->id)
                ->where('empleado_id', $request->empleado_id)
                ->first();
            
            if (!$detalle) {
                return response()->json([
                    'success' => false,
                    'message' => 'Empleado no encontrado en la lista de hoy'
                ], 404);
            }
            
            // Actualizar según el tipo de registro
            $mensaje = '';
            
            if ($request->tipo_registro == 'entrada' || $request->tipo_registro == 'ambos') {
                $detalle->hora_entrada = $request->hora;
                $mensaje .= "Entrada registrada a las {$request->hora}. ";
            }
            
            if ($request->tipo_registro == 'salida' || $request->tipo_registro == 'ambos') {
                $detalle->hora_salida = $request->hora;
                $mensaje .= "Salida registrada a las {$request->hora}. ";
            }
            
            // Calcular horas trabajadas si hay ambas horas
            if ($detalle->hora_entrada && $detalle->hora_salida) {
                $horasTrabajadas = DetalleListaAsistencia::calcularHorasTrabajadas(
                    $detalle->hora_entrada,
                    $detalle->hora_salida
                );
                $detalle->horas_trabajadas = $horasTrabajadas;
            }
            
            // Determinar estado basado en hora de entrada
            if ($detalle->hora_entrada) {
                $horaEntrada = strtotime($detalle->hora_entrada);
                $horaLimite = strtotime('09:00:00');
                
                if ($horaEntrada <= $horaLimite) {
                    $detalle->estado = 'presente';
                } else {
                    $detalle->estado = 'retardo';
                }
            }
            
            $detalle->observaciones = $request->observaciones;
            $detalle->save();
            
            // Actualizar estadísticas de la lista
            $lista->actualizarEstadisticas();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => $mensaje . 'Registro guardado correctamente',
                'data' => $detalle
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en registrar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Actualizar un registro existente
     */
    public function update(Request $request, $id)
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
            
            $detalle->update([
                'hora_entrada' => $request->hora_entrada,
                'hora_salida' => $request->hora_salida,
                'estado' => $request->estado,
                'observaciones' => $request->observaciones
            ]);
            
            if ($detalle->hora_entrada && $detalle->hora_salida) {
                $detalle->horas_trabajadas = DetalleListaAsistencia::calcularHorasTrabajadas(
                    $detalle->hora_entrada,
                    $detalle->hora_salida
                );
                $detalle->save();
            }
            
            $detalle->lista->actualizarEstadisticas();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Registro actualizado correctamente',
                'data' => $detalle
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en update: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Eliminar un registro
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $detalle = DetalleListaAsistencia::findOrFail($id);
            $lista = $detalle->lista;
            
            $detalle->delete();
            $lista->actualizarEstadisticas();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Registro eliminado correctamente'
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
     * Obtener resumen para KPIs
     */
    public function getResumen(Request $request)
    {
        try {
            $fecha = $request->get('fecha', date('Y-m-d'));
            
            $lista = ListaAsistencia::where('fecha', $fecha)->first();
            
            if ($lista) {
                $totalEmpleados = $lista->total_empleados;
                $presentes = $lista->presentes;
                $retardos = $lista->retardos;
                $ausentes = $lista->ausentes;
                $justificados = $lista->justificados;
            } else {
                $totalEmpleados = Plantilla::where('estatus', 'Activo')->count();
                $presentes = 0;
                $retardos = 0;
                $ausentes = $totalEmpleados;
                $justificados = 0;
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'total_empleados' => $totalEmpleados,
                    'presentes' => $presentes,
                    'retardos' => $retardos,
                    'ausentes' => $ausentes,
                    'justificados' => $justificados
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}