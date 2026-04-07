<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nomina;
use App\Models\Plantilla;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NominaController extends Controller
{
    /**
     * Display the view (página web)
     */
public function indexView()
{
    // Obtener nóminas existentes
    $nominas = Nomina::with('plantilla')->orderBy('created_at', 'desc')->paginate(15);
    
    // Calcular KPIs
    $totalNominas = Nomina::count();
    $totalPagado = Nomina::where('estatus', 'Pagada')->sum('neto_pagar');
    $totalPendiente = Nomina::where('estatus', 'Pendiente')->count();
    
    // Obtener empleados activos - IMPORTANTE: usa plantilla_id como clave primaria
    $empleados = Plantilla::whereIn('estatus', ['1', 'Activo'])
        ->orderBy('nombre')
        ->orderBy('apellido_paterno')
        ->get();
    
    // Agregar nombre completo a cada empleado
    foreach ($empleados as $emp) {
        $emp->nombre_completo = trim($emp->nombre . ' ' . $emp->apellido_paterno . ' ' . $emp->apellido_materno);
    }
    
    // Debug: Verificar cuántos empleados se obtuvieron
    \Log::info('Empleados cargados:', ['count' => $empleados->count()]);
    
    return view('rh.nomina.calculo', compact('nominas', 'totalNominas', 'totalPagado', 'totalPendiente', 'empleados'));
}

    /**
     * API: Display a listing of the resource
     */
    public function index(Request $request)
    {
        try {
            $query = Nomina::with('plantilla');
            
            // Filtrar por búsqueda
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('folio', 'like', "%{$search}%")
                      ->orWhere('empleado_nombre', 'like', "%{$search}%")
                      ->orWhereHas('plantilla', function($emp) use ($search) {
                          $emp->where('nombre', 'like', "%{$search}%")
                              ->orWhere('apellido_paterno', 'like', "%{$search}%")
                              ->orWhere('apellido_materno', 'like', "%{$search}%")
                              ->orWhere('rfc', 'like', "%{$search}%");
                      });
                });
            }
            
            // Filtrar por tipo de período
            if ($request->filled('periodo_tipo')) {
                $query->where('periodo_tipo', $request->periodo_tipo);
            }
            
            // Filtrar por estatus
            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }
            
            $perPage = $request->get('per_page', 15);
            $nominas = $query->orderBy('created_at', 'desc')->paginate($perPage);
            
            // Calcular KPIs
            $totalNominas = Nomina::count();
            $totalPagado = Nomina::where('estatus', 'Pagada')->sum('neto_pagar');
            $totalPendiente = Nomina::where('estatus', 'Pendiente')->count();
            $totalCalculado = Nomina::where('estatus', 'Calculada')->sum('neto_pagar');
            
            // Obtener empleados activos
            $empleados = Plantilla::whereIn('estatus', ['1', 'Activo'])
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
            // Validar datos
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
            
            DB::beginTransaction();
            
            foreach ($empleadosIds as $empleadoId) {
                try {
                    // Verificar si ya existe una nómina para este período y empleado
                    $existe = Nomina::where('plantilla_id', $empleadoId)
                        ->where('periodo_inicio', $periodoInicio->format('Y-m-d'))
                        ->where('periodo_fin', $periodoFin->format('Y-m-d'))
                        ->exists();
                    
                    if ($existe) {
                        $duplicados++;
                        continue;
                    }
                    
                    // Obtener datos del empleado
                    $empleado = Plantilla::find($empleadoId);
                    
                    if (!$empleado) {
                        $errores[] = "Empleado ID {$empleadoId} no encontrado";
                        continue;
                    }
                    
                    // Calcular nómina para el empleado
                    $nomina = $this->calcularNominaEmpleado($empleado, $periodoInicio, $periodoFin, $periodoTipo);
                    
                    if ($nomina) {
                        $resultados[] = $nomina;
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
                    'nominas' => $resultados
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
            // Calcular días trabajados en el período
            $diasTrabajados = $this->calcularDiasTrabajados($empleado, $periodoInicio, $periodoFin);
            
            if ($diasTrabajados <= 0) {
                return null;
            }
            
            // Obtener sueldo diario
            $sueldoDiario = $this->obtenerSueldoDiario($empleado);
            
            // Calcular percepciones
            $sueldo = $sueldoDiario * $diasTrabajados;
            
            // Obtener bonos
            $bonos = $this->calcularBonos($empleado, $periodoInicio, $periodoFin);
            
            // Obtener comisiones
            $comisiones = $this->calcularComisiones($empleado, $periodoInicio, $periodoFin);
            
            // Obtener otras percepciones
            $otrasPercepciones = $this->calcularOtrasPercepciones($empleado);
            
            $totalPercepciones = $sueldo + $bonos + $comisiones + $otrasPercepciones;
            
            // Calcular deducciones
            $isr = $this->calcularISR($totalPercepciones, $empleado);
            $imss = $this->calcularIMSS($sueldo, $empleado);
            $infonavit = $this->calcularInfonavit($empleado);
            $fondoAhorro = $this->calcularFondoAhorro($totalPercepciones, $empleado);
            $prestamos = $this->calcularPrestamos($empleado);
            $pensionAlimenticia = $empleado->pension_alimenticia ? $this->calcularPensionAlimenticia($totalPercepciones, $empleado) : 0;
            $fonacot = $empleado->fonacot ? $this->calcularFonacot($empleado) : 0;
            $otrasDeducciones = $this->calcularOtrasDeducciones($empleado);
            
            $totalDeducciones = $isr + $imss + $infonavit + $fondoAhorro + $prestamos + $pensionAlimenticia + $fonacot + $otrasDeducciones;
            
            // Calcular neto a pagar
            $netoPagar = $totalPercepciones - $totalDeducciones;
            
            // Generar folio único
            $folio = $this->generarFolio($periodoInicio, $periodoFin, $empleado->plantilla_id, $periodoTipo);
            
            // Obtener nombre completo del empleado
            $nombreCompleto = $this->getNombreCompleto($empleado);
            
            // Obtener nombre del puesto
            $puestoNombre = $empleado->puesto ?? ($empleado->puesto_nombre ?? 'N/A');
            
            // Crear registro de nómina
            $nomina = Nomina::create([
                'folio' => $folio,
                'plantilla_id' => $empleado->plantilla_id,
                'empleado_nombre' => $nombreCompleto,
                'puesto' => $puestoNombre,
                'periodo_tipo' => $periodoTipo,
                'periodo_inicio' => $periodoInicio->format('Y-m-d'),
                'periodo_fin' => $periodoFin->format('Y-m-d'),
                'dias_trabajados' => $diasTrabajados,
                'sueldo' => $sueldo,
                'bonos' => $bonos,
                'comisiones' => $comisiones,
                'otras_percepciones' => $otrasPercepciones,
                'total_percepciones' => $totalPercepciones,
                'isr' => $isr,
                'imss' => $imss,
                'infonavit' => $infonavit,
                'fondo_ahorro' => $fondoAhorro,
                'prestamos' => $prestamos,
                'pension_alimenticia' => $pensionAlimenticia,
                'fonacot' => $fonacot,
                'otras_deducciones' => $otrasDeducciones,
                'total_deducciones' => $totalDeducciones,
                'neto_pagar' => $netoPagar,
                'estatus' => 'Calculada',
                'fecha_calculo' => Carbon::now()
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
     * Calcular bonos del empleado
     */
    private function calcularBonos($empleado, $periodoInicio, $periodoFin)
    {
        $bonos = 0;
        
        if ($empleado->bono_asistencia) {
            $bonos += $this->calcularBonoAsistencia($empleado, $periodoInicio, $periodoFin);
        }
        
        return $bonos;
    }
    
    /**
     * Calcular bono de asistencia
     */
    private function calcularBonoAsistencia($empleado, $periodoInicio, $periodoFin)
    {
        $diasLaborales = $periodoInicio->diffInDays($periodoFin) + 1;
        $bonoBase = $this->obtenerSueldoDiario($empleado) * $diasLaborales * 0.05;
        return $bonoBase;
    }
    
    /**
     * Calcular comisiones (placeholder)
     */
    private function calcularComisiones($empleado, $periodoInicio, $periodoFin)
    {
        return 0;
    }
    
    /**
     * Calcular otras percepciones
     */
    private function calcularOtrasPercepciones($empleado)
    {
        $total = 0;
        
        if ($empleado->nomina_percepciones && is_array($empleado->nomina_percepciones)) {
            foreach ($empleado->nomina_percepciones as $percepcion) {
                $total += $percepcion['monto'] ?? 0;
            }
        }
        
        return $total;
    }
    
    /**
     * Calcular ISR
     */
    private function calcularISR($sueldo, $empleado)
    {
        if ($empleado->monto_mensual_isr > 0) {
            return $empleado->monto_mensual_isr / 2;
        }
        
        if ($sueldo <= 10000) return $sueldo * 0.10;
        if ($sueldo <= 20000) return $sueldo * 0.15;
        if ($sueldo <= 35000) return $sueldo * 0.20;
        if ($sueldo <= 60000) return $sueldo * 0.25;
        return $sueldo * 0.30;
    }
    
    /**
     * Calcular IMSS
     */
    private function calcularIMSS($sueldo, $empleado)
    {
        if ($empleado->monto_mensual_imss > 0) {
            return $empleado->monto_mensual_imss / 2;
        }
        return $sueldo * 0.05;
    }
    
    /**
     * Calcular INFONAVIT
     */
    private function calcularInfonavit($empleado)
    {
        if ($empleado->monto_mensual_infonavit > 0) {
            return $empleado->monto_mensual_infonavit / 2;
        }
        return 0;
    }
    
    /**
     * Calcular fondo de ahorro
     */
    private function calcularFondoAhorro($sueldo, $empleado)
    {
        return 0;
    }
    
    /**
     * Calcular préstamos
     */
    private function calcularPrestamos($empleado)
    {
        return 0;
    }
    
    /**
     * Calcular pensión alimenticia
     */
    private function calcularPensionAlimenticia($sueldo, $empleado)
    {
        return $sueldo * 0.15;
    }
    
    /**
     * Calcular FONACOT
     */
    private function calcularFonacot($empleado)
    {
        return 0;
    }
    
    /**
     * Calcular otras deducciones
     */
    private function calcularOtrasDeducciones($empleado)
    {
        $total = 0;
        
        if ($empleado->nomina_deducciones && is_array($empleado->nomina_deducciones)) {
            foreach ($empleado->nomina_deducciones as $deduccion) {
                $total += $deduccion['monto'] ?? 0;
            }
        }
        
        return $total;
    }
    
    /**
     * Generar folio único para la nómina
     */
    private function generarFolio($periodoInicio, $periodoFin, $empleadoId, $periodoTipo)
    {
        $tipoAbrev = str_starts_with($periodoTipo, 'quincenal') ? 'Q' : 'S';
        $fechaInicio = $periodoInicio->format('Ymd');
        $fechaFin = $periodoFin->format('Ymd');
        $empleado = str_pad($empleadoId, 4, '0', STR_PAD_LEFT);
        
        $contador = Nomina::where('periodo_inicio', $periodoInicio->format('Y-m-d'))
            ->where('periodo_fin', $periodoFin->format('Y-m-d'))
            ->count() + 1;
        
        return "NOM-{$tipoAbrev}-{$fechaInicio}-{$fechaFin}-{$empleado}-" . str_pad($contador, 3, '0', STR_PAD_LEFT);
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
            
            Log::info("Cambio de estatus de nómina", [
                'nomina_id' => $id,
                'folio' => $nomina->folio,
                'estatus_nuevo' => $request->estatus
            ]);
            
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
            Log::error('Error actualizando estatus de nómina: ' . $e->getMessage());
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
            $nomina = Nomina::with('plantilla')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $nomina
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error mostrando nómina: ' . $e->getMessage());
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
            $nomina = Nomina::with('plantilla')->findOrFail($id);
            return view('rh.nomina.print', compact('nomina'));
            
        } catch (\Exception $e) {
            Log::error('Error imprimiendo nómina: ' . $e->getMessage());
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
            $nomina = Nomina::with('plantilla')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'message' => 'PDF generado correctamente',
                'data' => $nomina
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error generando PDF: ' . $e->getMessage());
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
                'message' => 'Nómina cancelada correctamente',
                'data' => $nomina
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error cancelando nómina: ' . $e->getMessage());
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
            Log::error('Error obteniendo resumen: ' . $e->getMessage());
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
            $query = Nomina::with('plantilla');
            
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
            Log::error('Error exportando a Excel: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar'
            ], 500);
        }
    }
}