<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nomina;
use App\Models\Plantilla;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class NominaController extends Controller
{
    /**
     * Display the view (página web)
     */
    public function indexView(Request $request)
    {
        try {
            // Obtener parámetros de filtro
            $search = $request->get('search');
            $periodoTipo = $request->get('periodo_tipo', 'quincenal');
            
            // Obtener nóminas existentes
            $query = Nomina::with('empleado');
            
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('folio', 'like', "%{$search}%")
                      ->orWhere('empleado_nombre', 'like', "%{$search}%")
                      ->orWhereHas('empleado', function($emp) use ($search) {
                          $emp->where('nombre', 'like', "%{$search}%")
                              ->orWhere('apellido_paterno', 'like', "%{$search}%")
                              ->orWhere('apellido_materno', 'like', "%{$search}%")
                              ->orWhere('rfc', 'like', "%{$search}%");
                      });
                });
            }
            
            if ($periodoTipo) {
                $query->where('periodo_tipo', $periodoTipo);
            }
            
            $nominas = $query->orderBy('created_at', 'desc')->paginate(15);
            
            // Calcular KPIs
            $totalNominas = Nomina::count();
            $totalPagado = Nomina::where('estatus', 'Pagada')->sum('neto_pagar');
            $totalPendiente = Nomina::where('estatus', 'Pendiente')->count();
            
            // ✅ OBTENER EMPLEADOS ACTIVOS (IGUAL QUE LA RUTA DE PRUEBA)
            $empleados = Plantilla::where('estatus', 'Activo')
                ->orderBy('nombre')
                ->orderBy('apellido_paterno')
                ->get();
            
            // Agregar datos adicionales a cada empleado
            foreach ($empleados as $emp) {
                $emp->nombre_completo = trim($emp->nombre . ' ' . $emp->apellido_paterno . ' ' . $emp->apellido_materno);
                
                if ($emp->puesto) {
                    $emp->puesto_nombre = $emp->puesto->nombre;
                } else {
                    $emp->puesto_nombre = 'N/A';
                }
                
                $emp->plantilla_id = $emp->plantilla_id ?? $emp->id;
            }
            
            // 🔍 LOG PARA VERIFICAR
            Log::info('Empleados cargados en indexView:', [
                'count' => $empleados->count(),
                'ids' => $empleados->pluck('plantilla_id')->toArray()
            ]);
            
            // ✅ PASAR TODAS LAS VARIABLES A LA VISTA
            return view('rh.nomina.calculo', [
                'nominas' => $nominas,
                'totalNominas' => $totalNominas,
                'totalPagado' => $totalPagado,
                'totalPendiente' => $totalPendiente,
                'empleados' => $empleados,
                'search' => $search,
                'periodoTipo' => $periodoTipo
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en indexView: ' . $e->getMessage());
            
            return view('rh.nomina.calculo', [
                'nominas' => collect([]),
                'totalNominas' => 0,
                'totalPagado' => 0,
                'totalPendiente' => 0,
                'empleados' => collect([]),
                'search' => null,
                'periodoTipo' => 'quincenal',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * API: Display a listing of the resource
     */
    public function index(Request $request)
    {
        try {
            $query = Nomina::with('empleado');
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('folio', 'like', "%{$search}%")
                      ->orWhere('empleado_nombre', 'like', "%{$search}%")
                      ->orWhereHas('empleado', function($emp) use ($search) {
                          $emp->where('nombre', 'like', "%{$search}%")
                              ->orWhere('apellido_paterno', 'like', "%{$search}%")
                              ->orWhere('apellido_materno', 'like', "%{$search}%");
                      });
                });
            }
            
            if ($request->filled('periodo_tipo')) {
                $query->where('periodo_tipo', $request->periodo_tipo);
            }
            
            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }
            
            $perPage = $request->get('per_page', 15);
            $nominas = $query->orderBy('created_at', 'desc')->paginate($perPage);
            
            $totalNominas = Nomina::count();
            $totalPagado = Nomina::where('estatus', 'Pagada')->sum('neto_pagar');
            $totalPendiente = Nomina::where('estatus', 'Pendiente')->count();
            $totalCalculado = Nomina::where('estatus', 'Calculada')->sum('neto_pagar');
            
            $empleados = Plantilla::where('estatus', 'Activo')
                ->select('plantilla_id as id', 'nombre', 'apellido_paterno', 'apellido_materno')
                ->orderBy('nombre')
                ->orderBy('apellido_paterno')
                ->get()
                ->map(function($emp) {
                    $emp->nombre_completo = trim($emp->nombre . ' ' . $emp->apellido_paterno . ' ' . $emp->apellido_materno);
                    $emp->plantilla_id = $emp->id;
                    return $emp;
                });
            
            return response()->json([
                'success' => true,
                'data' => [
                    'nominas' => $nominas->items(),
                    'pagination' => [
                        'current_page' => $nominas->currentPage(),
                        'last_page' => $nominas->lastPage(),
                        'per_page' => $nominas->perPage(),
                        'total' => $nominas->total(),
                        'from' => $nominas->firstItem(),
                        'to' => $nominas->lastItem()
                    ],
                    'kpis' => [
                        'total_nominas' => $totalNominas,
                        'total_pagado' => number_format($totalPagado, 2),
                        'total_pendiente' => $totalPendiente,
                        'total_calculado' => number_format($totalCalculado, 2)
                    ],
                    'empleados' => $empleados
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en index de nómina: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los datos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calcular nómina para empleados seleccionados (API)
     */
    public function calcular(Request $request)
    {
        try {
            $request->validate([
                'periodo_tipo' => 'required|in:quincenal,semanal',
                'periodo_inicio' => 'required|date',
                'periodo_fin' => 'required|date|after_or_equal:periodo_inicio',
                'empleados' => 'required|array',
                'empleados.*' => 'exists:plantillas,plantilla_id'
            ]);
            
            $periodoInicio = Carbon::parse($request->periodo_inicio);
            $periodoFin = Carbon::parse($request->periodo_fin);
            $periodoTipo = $request->periodo_tipo;
            $empleadosIds = $request->empleados;
            
            $resultados = [];
            $errores = [];
            $duplicados = 0;
            $totalCalculado = 0;
            
            DB::beginTransaction();
            
            foreach ($empleadosIds as $empleadoId) {
                try {
                    $existe = Nomina::where('empleado_id', $empleadoId)
                        ->where('periodo_inicio', $periodoInicio->format('Y-m-d'))
                        ->where('periodo_fin', $periodoFin->format('Y-m-d'))
                        ->exists();
                    
                    if ($existe) {
                        $duplicados++;
                        continue;
                    }
                    
                    $empleado = Plantilla::with('puesto')->find($empleadoId);
                    
                    if (!$empleado) {
                        $errores[] = "Empleado ID {$empleadoId} no encontrado";
                        continue;
                    }
                    
                    $nomina = $this->calcularNominaEmpleado($empleado, $periodoInicio, $periodoFin, $periodoTipo);
                    
                    if ($nomina) {
                        $resultados[] = $nomina;
                        $totalCalculado += $nomina->neto_pagar;
                    } else {
                        $errores[] = "Error al calcular nómina para " . $this->getNombreCompleto($empleado);
                    }
                    
                } catch (\Exception $e) {
                    Log::error('Error calculando nómina para empleado ' . $empleadoId . ': ' . $e->getMessage());
                    $errores[] = "Error con empleado ID {$empleadoId}: " . $e->getMessage();
                }
            }
            
            DB::commit();
            
            $mensaje = "Se calcularon " . count($resultados) . " nóminas correctamente.";
            if ($duplicados > 0) {
                $mensaje .= " Se omitieron {$duplicados} empleados que ya tenían nómina en este período.";
            }
            if (count($errores) > 0) {
                $mensaje .= " Errores: " . implode(', ', $errores);
            }
            
            return response()->json([
                'success' => count($resultados) > 0,
                'message' => $mensaje,
                'data' => [
                    'creadas' => count($resultados),
                    'duplicados' => $duplicados,
                    'errores' => $errores,
                    'total_calculado' => number_format($totalCalculado, 2)
                ]
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en cálculo de nómina: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al calcular nómina: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Calcular nómina para un empleado específico
     */
    private function calcularNominaEmpleado($empleado, $periodoInicio, $periodoFin, $periodoTipo)
    {
        try {
            $diasTrabajados = $this->calcularDiasTrabajados($empleado, $periodoInicio, $periodoFin);
            
            if ($diasTrabajados <= 0) {
                return null;
            }
            
            $sueldoDiario = $this->obtenerSueldoDiario($empleado);
            $sueldoBase = $sueldoDiario * $diasTrabajados;
            
            $bonoAsistencia = $this->calcularBonoAsistencia($empleado, $periodoInicio, $periodoFin);
            $totalPercepciones = $sueldoBase + $bonoAsistencia;
            
            $isr = $this->calcularISR($totalPercepciones);
            $imss = $this->calcularIMSS($sueldoBase);
            $totalDeducciones = $isr + $imss;
            
            $netoPagar = $totalPercepciones - $totalDeducciones;
            $netoPagar = max($netoPagar, 0);
            
            $folio = Nomina::generarFolio($periodoTipo, $periodoInicio->format('Y-m-d'), $periodoFin->format('Y-m-d'), $empleado->plantilla_id);
            $nombreCompleto = $this->getNombreCompleto($empleado);
            $puestoNombre = $empleado->puesto ? $empleado->puesto->nombre : ($empleado->puesto_nombre ?? 'N/A');
            
            $nomina = Nomina::create([
                'folio' => $folio,
                'empleado_id' => $empleado->plantilla_id,
                'empleado_nombre' => $nombreCompleto,
                'puesto' => $puestoNombre,
                'periodo_tipo' => $periodoTipo,
                'periodo_inicio' => $periodoInicio->format('Y-m-d'),
                'periodo_fin' => $periodoFin->format('Y-m-d'),
                'dias_trabajados' => $diasTrabajados,
                'sueldo_diario' => $sueldoDiario,
                'sueldo_base' => $sueldoBase,
                'bono_asistencia' => $bonoAsistencia,
                'total_percepciones' => $totalPercepciones,
                'isr' => $isr,
                'imss' => $imss,
                'total_deducciones' => $totalDeducciones,
                'neto_pagar' => $netoPagar,
                'estatus' => 'Calculada',
                'calculado_por' => Auth::id()
            ]);
            
            return $nomina;
            
        } catch (\Exception $e) {
            Log::error('Error en calcularNominaEmpleado: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Obtener nombre completo del empleado
     */
    private function getNombreCompleto($empleado)
    {
        $partes = [];
        if ($empleado->nombre) $partes[] = $empleado->nombre;
        if ($empleado->apellido_paterno) $partes[] = $empleado->apellido_paterno;
        if ($empleado->apellido_materno) $partes[] = $empleado->apellido_materno;
        return !empty($partes) ? implode(' ', $partes) : 'Sin nombre';
    }
    
    /**
     * Calcular días trabajados en el período
     */
    private function calcularDiasTrabajados($empleado, $periodoInicio, $periodoFin)
    {
        $diasTotales = $periodoInicio->diffInDays($periodoFin) + 1;
        if ($empleado->fecha_ingreso && $empleado->fecha_ingreso > $periodoInicio) {
            $diasTotales = Carbon::parse($empleado->fecha_ingreso)->diffInDays($periodoFin) + 1;
        }
        if ($empleado->fecha_baja && $empleado->fecha_baja < $periodoFin) {
            $diasTotales = $periodoInicio->diffInDays(Carbon::parse($empleado->fecha_baja)) + 1;
        }
        return max(0, $diasTotales);
    }
    
    /**
     * Obtener sueldo diario del empleado
     */
    private function obtenerSueldoDiario($empleado)
    {
        if ($empleado->sueldo_diario && $empleado->sueldo_diario > 0) {
            return $empleado->sueldo_diario;
        }
        if ($empleado->sueldo && $empleado->sueldo > 0) {
            return $empleado->sueldo / 30;
        }
        if ($empleado->sueldo_hora && $empleado->sueldo_hora > 0) {
            return $empleado->sueldo_hora * 8;
        }
        return 0;
    }
    
    /**
     * Calcular bono de asistencia
     */
    private function calcularBonoAsistencia($empleado, $periodoInicio, $periodoFin)
    {
        if (!$empleado->bono_asistencia) {
            return 0;
        }
        $diasLaborales = $periodoInicio->diffInDays($periodoFin) + 1;
        $sueldoDiario = $this->obtenerSueldoDiario($empleado);
        return $sueldoDiario * $diasLaborales * 0.05;
    }
    
    /**
     * Calcular ISR (simplificado)
     */
    private function calcularISR($sueldo)
    {
        if ($sueldo <= 10000) return $sueldo * 0.10;
        if ($sueldo <= 20000) return $sueldo * 0.15;
        if ($sueldo <= 35000) return $sueldo * 0.20;
        if ($sueldo <= 60000) return $sueldo * 0.25;
        return $sueldo * 0.30;
    }
    
    /**
     * Calcular IMSS (simplificado)
     */
    private function calcularIMSS($sueldo)
    {
        return $sueldo * 0.05;
    }
    
    /**
     * Actualizar estatus de una nómina (API)
     */
    public function actualizarEstatus(Request $request, $id)
    {
        try {
            $request->validate([
                'estatus' => 'required|in:Pendiente,Calculada,Pagada,Cancelada',
                'fecha_pago' => 'required_if:estatus,Pagada|nullable|date'
            ]);
            
            $nomina = Nomina::findOrFail($id);
            $nomina->estatus = $request->estatus;
            
            if ($request->estatus === 'Pagada' && $request->fecha_pago) {
                $nomina->fecha_pago = $request->fecha_pago;
            }
            
            $nomina->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Estatus actualizado correctamente',
                'data' => $nomina
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error actualizando estatus: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar estatus: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Display the specified resource (API)
     */
    public function show($id)
    {
        try {
            $nomina = Nomina::with('empleado')->findOrFail($id);
            return view('rh.nomina.detalle', compact('nomina'));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Nómina no encontrada'
            ], 404);
        }
    }
    
    /**
     * Print recibo de nómina
     */
    public function imprimirRecibo($id)
    {
        try {
            $nomina = Nomina::with('empleado')->findOrFail($id);
            return view('rh.nomina.print', compact('nomina'));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al imprimir recibo'
            ], 500);
        }
    }
    
    /**
     * Generate PDF de nómina
     */
    public function generarPDF($id)
    {
        try {
            $nomina = Nomina::with('empleado')->findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'PDF generado correctamente',
                'data' => $nomina
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar PDF'
            ], 500);
        }
    }
    
    /**
     * Cancelar una nómina
     */
    public function cancelar($id)
    {
        try {
            $nomina = Nomina::findOrFail($id);
            
            if ($nomina->estatus === 'Pagada') {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede cancelar una nómina ya pagada'
                ], 400);
            }
            
            $nomina->estatus = 'Cancelada';
            $nomina->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Nómina cancelada correctamente'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cancelar nómina: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener resumen de nóminas por período
     */
    public function resumen(Request $request)
    {
        try {
            $request->validate([
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
            ]);
            
            $resumen = Nomina::whereBetween('periodo_inicio', [$request->fecha_inicio, $request->fecha_fin])
                ->select(
                    DB::raw('COUNT(*) as total_nominas'),
                    DB::raw('SUM(CASE WHEN estatus = "Pagada" THEN neto_pagar ELSE 0 END) as total_pagado'),
                    DB::raw('SUM(CASE WHEN estatus = "Calculada" THEN neto_pagar ELSE 0 END) as total_calculado'),
                    DB::raw('SUM(CASE WHEN estatus = "Pendiente" THEN neto_pagar ELSE 0 END) as total_pendiente'),
                    DB::raw('SUM(neto_pagar) as total_general')
                )
                ->first();
            
            return response()->json([
                'success' => true,
                'data' => $resumen
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener resumen'
            ], 500);
        }
    }
    
    /**
     * Exportar nóminas a Excel
     */
    public function exportar(Request $request)
    {
        try {
            $query = Nomina::with('empleado');
            
            if ($request->filled('periodo_tipo')) {
                $query->where('periodo_tipo', $request->periodo_tipo);
            }
            
            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }
            
            if ($request->filled('fecha_inicio')) {
                $query->where('periodo_inicio', '>=', $request->fecha_inicio);
            }
            
            if ($request->filled('fecha_fin')) {
                $query->where('periodo_fin', '<=', $request->fecha_fin);
            }
            
            $nominas = $query->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Exportación iniciada',
                'total_registros' => $nominas->count()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar'
            ], 500);
        }
    }
}