<?php

namespace App\Http\Controllers;

use App\Models\Nomina;
use App\Models\Plantilla;
use App\Models\CatPuesto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
                              ->orWhere('rfc', 'like', "%{$search}%")
                              ->orWhere('numero_empleado_interno', 'like', "%{$search}%");
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
            
            // ✅ OBTENER EMPLEADOS ACTIVOS CON plantilla_id
            $empleados = Plantilla::where('estatus', 'Activo')
                ->orderBy('nombre')
                ->orderBy('apellido_paterno')
                ->get()
                ->map(function($emp) {
                    // Asegurar que el ID esté disponible
                    $emp->id = $emp->plantilla_id;
                    $emp->plantilla_id = $emp->plantilla_id;
                    
                    // Nombre completo
                    $emp->nombre_completo = trim(
                        $emp->nombre . ' ' . 
                        $emp->apellido_paterno . ' ' . 
                        $emp->apellido_materno
                    );
                    
                    // Obtener nombre del puesto
                    if ($emp->cat_puesto_id && $emp->puesto) {
                        $emp->puesto_nombre = $emp->puesto->nombre;
                    } else {
                        $emp->puesto_nombre = 'Sin puesto';
                    }
                    
                    // Asegurar sueldo diario
                    if (empty($emp->sueldo_diario) && !empty($emp->sueldo)) {
                        $emp->sueldo_diario = $emp->sueldo / 30;
                    }
                    
                    return $emp;
                });

            // 🔍 LOG DE DEPURACIÓN
            Log::info('📊 Empleados cargados en indexView:', [
                'total' => $empleados->count(),
                'ids' => $empleados->pluck('plantilla_id')->toArray(),
                'nombres' => $empleados->pluck('nombre_completo')->toArray()
            ]);

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
            Log::error('❌ Error en indexView: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
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
            
            // Filtros
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
            
            if ($request->filled('fecha_inicio')) {
                $query->where('periodo_inicio', '>=', $request->fecha_inicio);
            }
            
            if ($request->filled('fecha_fin')) {
                $query->where('periodo_fin', '<=', $request->fecha_fin);
            }
            
            $perPage = $request->get('per_page', 15);
            $nominas = $query->orderBy('created_at', 'desc')->paginate($perPage);
            
            // KPIs
            $totalNominas = Nomina::count();
            $totalPagado = Nomina::where('estatus', 'Pagada')->sum('neto_pagar');
            $totalPendiente = Nomina::where('estatus', 'Pendiente')->count();
            $totalCalculado = Nomina::where('estatus', 'Calculada')->sum('neto_pagar');
            
            // Empleados activos
            $empleados = Plantilla::where('estatus', 'Activo')
                ->select('plantilla_id', 'nombre', 'apellido_paterno', 'apellido_materno')
                ->orderBy('nombre')
                ->orderBy('apellido_paterno')
                ->get()
                ->map(function($emp) {
                    $emp->nombre_completo = trim(
                        $emp->nombre . ' ' . 
                        $emp->apellido_paterno . ' ' . 
                        $emp->apellido_materno
                    );
                    $emp->id = $emp->plantilla_id;
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
            Log::error('❌ Error en index API: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los datos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calcular nómina para empleados seleccionados
     */
    public function calcular(Request $request)
    {
        try {
            // Validación
            $validator = Validator::make($request->all(), [
                'periodo_tipo' => 'required|in:quincenal,semanal',
                'periodo_inicio' => 'required|date',
                'periodo_fin' => 'required|date|after_or_equal:periodo_inicio',
                'empleados' => 'required|array|min:1',
                'empleados.*' => 'exists:plantillas,plantilla_id' // ✅ Usando plantilla_id
            ], [
                'empleados.required' => 'Debes seleccionar al menos un empleado',
                'empleados.*.exists' => 'Uno o más empleados no existen en la base de datos'
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }
            
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
                    // Verificar si ya existe nómina para este empleado en el período
                    $existe = Nomina::where('empleado_id', $empleadoId)
                        ->where('periodo_inicio', $periodoInicio->format('Y-m-d'))
                        ->where('periodo_fin', $periodoFin->format('Y-m-d'))
                        ->exists();
                    
                    if ($existe) {
                        $duplicados++;
                        Log::warning("⚠️ Nómina duplicada para empleado {$empleadoId} en período {$periodoInicio->format('Y-m-d')} a {$periodoFin->format('Y-m-d')}");
                        continue;
                    }
                    
                    // Obtener empleado
                    $empleado = Plantilla::with('puesto')
                        ->where('plantilla_id', $empleadoId)
                        ->first();
                    
                    if (!$empleado) {
                        $errores[] = "Empleado ID {$empleadoId} no encontrado";
                        continue;
                    }
                    
                    // Calcular nómina
                    $nomina = $this->calcularNominaEmpleado($empleado, $periodoInicio, $periodoFin, $periodoTipo);
                    
                    if ($nomina) {
                        $resultados[] = $nomina;
                        $totalCalculado += $nomina->neto_pagar;
                        Log::info("✅ Nómina calculada para: {$empleado->nombre_completo}", [
                            'folio' => $nomina->folio,
                            'neto' => $nomina->neto_pagar
                        ]);
                    } else {
                        $errores[] = "Error al calcular nómina para " . $this->getNombreCompleto($empleado);
                    }
                    
                } catch (\Exception $e) {
                    Log::error("❌ Error calculando nómina para empleado {$empleadoId}: " . $e->getMessage());
                    $errores[] = "Error con empleado ID {$empleadoId}: " . $e->getMessage();
                }
            }
            
            DB::commit();
            
            $mensaje = "✅ Se calcularon " . count($resultados) . " nóminas correctamente.";
            if ($duplicados > 0) {
                $mensaje .= " Se omitieron {$duplicados} empleados que ya tenían nómina en este período.";
            }
            if (count($errores) > 0) {
                $mensaje .= " ⚠️ Errores: " . implode(', ', array_slice($errores, 0, 3));
                if (count($errores) > 3) {
                    $mensaje .= " y " . (count($errores) - 3) . " más.";
                }
            }
            
            return response()->json([
                'success' => count($resultados) > 0,
                'message' => $mensaje,
                'data' => [
                    'creadas' => count($resultados),
                    'duplicados' => $duplicados,
                    'errores' => $errores,
                    'total_calculado' => number_format($totalCalculado, 2),
                    'nominas' => $resultados
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Error en cálculo de nómina: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
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
            // Calcular días trabajados
            $diasTrabajados = $this->calcularDiasTrabajados($empleado, $periodoInicio, $periodoFin);
            
            if ($diasTrabajados <= 0) {
                Log::warning("⚠️ Empleado sin días trabajados: " . $this->getNombreCompleto($empleado));
                return null;
            }
            
            // Obtener sueldo diario
            $sueldoDiario = $this->obtenerSueldoDiario($empleado);
            if ($sueldoDiario <= 0) {
                Log::warning("⚠️ Empleado sin sueldo definido: " . $this->getNombreCompleto($empleado));
                return null;
            }
            
            // Calcular percepciones
            $sueldoBase = $sueldoDiario * $diasTrabajados;
            $bonoAsistencia = $this->calcularBonoAsistencia($empleado, $periodoInicio, $periodoFin);
            $bonoProductividad = $empleado->bono_productividad ?? 0;
            $bonoAdministrativo = $empleado->bono_administrativo ?? 0;
            
            $totalPercepciones = $sueldoBase + $bonoAsistencia + $bonoProductividad + $bonoAdministrativo;
            
            // Calcular deducciones
            $isr = $this->calcularISR($totalPercepciones);
            $imss = $this->calcularIMSS($sueldoBase);
            $infonavit = $this->calcularInfonavit($empleado, $sueldoBase);
            $pensionAlimenticia = $empleado->pension_alimenticia ?? 0;
            $fonacot = $empleado->fonacot ?? 0;
            
            $totalDeducciones = $isr + $imss + $infonavit + $pensionAlimenticia + $fonacot;
            
            // Calcular neto
            $netoPagar = max(0, $totalPercepciones - $totalDeducciones);
            
            // Generar folio
            $folio = Nomina::generarFolio($periodoTipo, $periodoInicio, $periodoFin, $empleado->plantilla_id);
            $nombreCompleto = $this->getNombreCompleto($empleado);
            $puestoNombre = $empleado->puesto ? $empleado->puesto->nombre : ($empleado->puesto_nombre ?? 'Sin puesto');
            
            // Crear nómina
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
                'bono_productividad' => $bonoProductividad,
                'bono_administrativo' => $bonoAdministrativo,
                'total_percepciones' => $totalPercepciones,
                'isr' => $isr,
                'imss' => $imss,
                'infonavit' => $infonavit,
                'pension_alimenticia' => $pensionAlimenticia,
                'fonacot' => $fonacot,
                'total_deducciones' => $totalDeducciones,
                'neto_pagar' => $netoPagar,
                'estatus' => Nomina::ESTATUS_CALCULADA,
                'calculado_por' => Auth::id()
            ]);
            
            Log::info('✅ Nómina creada:', [
                'folio' => $folio,
                'empleado' => $nombreCompleto,
                'neto' => $netoPagar
            ]);
            
            return $nomina;
            
        } catch (\Exception $e) {
            Log::error('❌ Error en calcularNominaEmpleado: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Obtener nombre completo del empleado
     */
    private function getNombreCompleto($empleado)
    {
        $partes = array_filter([
            $empleado->nombre ?? '',
            $empleado->apellido_paterno ?? '',
            $empleado->apellido_materno ?? ''
        ]);
        return !empty($partes) ? implode(' ', $partes) : 'Sin nombre';
    }
    
    /**
     * Calcular días trabajados en el período
     */
    private function calcularDiasTrabajados($empleado, $periodoInicio, $periodoFin)
    {
        $diasTotales = $periodoInicio->diffInDays($periodoFin) + 1;
        
        // Si tiene fecha de ingreso después del inicio del período
        if ($empleado->fecha_ingreso && Carbon::parse($empleado->fecha_ingreso) > $periodoInicio) {
            $diasTotales = Carbon::parse($empleado->fecha_ingreso)->diffInDays($periodoFin) + 1;
        }
        
        // Si tiene fecha de baja antes del fin del período
        if ($empleado->fecha_baja && Carbon::parse($empleado->fecha_baja) < $periodoFin) {
            $diasTotales = $periodoInicio->diffInDays(Carbon::parse($empleado->fecha_baja)) + 1;
        }
        
        return max(0, $diasTotales);
    }
    
    /**
     * Obtener sueldo diario del empleado
     */
    private function obtenerSueldoDiario($empleado)
    {
        // Prioridad: sueldo_diario > sueldo/30 > sueldo_hora*8
        if ($empleado->sueldo_diario && $empleado->sueldo_diario > 0) {
            return (float) $empleado->sueldo_diario;
        }
        
        if ($empleado->sueldo && $empleado->sueldo > 0) {
            return (float) ($empleado->sueldo / 30);
        }
        
        if ($empleado->sueldo_hora && $empleado->sueldo_hora > 0) {
            return (float) ($empleado->sueldo_hora * 8);
        }
        
        return 0;
    }
    
    /**
     * Calcular bono de asistencia
     */
    private function calcularBonoAsistencia($empleado, $periodoInicio, $periodoFin)
    {
        if (!$empleado->bono_asistencia || $empleado->bono_asistencia <= 0) {
            return 0;
        }
        
        $diasLaborales = $periodoInicio->diffInDays($periodoFin) + 1;
        $sueldoDiario = $this->obtenerSueldoDiario($empleado);
        
        // Bono de asistencia: 5% del sueldo diario por día trabajado
        return $sueldoDiario * $diasLaborales * 0.05;
    }
    
    /**
     * Calcular ISR (simplificado)
     */
    private function calcularISR($sueldo)
    {
        // Escala simplificada de ISR
        if ($sueldo <= 10000) {
            return $sueldo * 0.10;
        } elseif ($sueldo <= 20000) {
            return $sueldo * 0.15;
        } elseif ($sueldo <= 35000) {
            return $sueldo * 0.20;
        } elseif ($sueldo <= 60000) {
            return $sueldo * 0.25;
        } else {
            return $sueldo * 0.30;
        }
    }
    
    /**
     * Calcular IMSS (simplificado)
     */
    private function calcularIMSS($sueldo)
    {
        // 5% del sueldo base
        return $sueldo * 0.05;
    }
    
    /**
     * Calcular INFONAVIT (simplificado)
     */
    private function calcularInfonavit($empleado, $sueldoBase)
    {
        // Si el empleado tiene descuento INFONAVIT configurado
        if (isset($empleado->descuento_infonavit) && $empleado->descuento_infonavit > 0) {
            return $sueldoBase * ($empleado->descuento_infonavit / 100);
        }
        
        // Si tiene monto diario INFONAVIT
        if ($empleado->monto_diario_infonavit && $empleado->monto_diario_infonavit > 0) {
            return $empleado->monto_diario_infonavit * $this->calcularDiasTrabajados(
                $empleado,
                Carbon::parse($empleado->periodo_inicio ?? now()),
                Carbon::parse($empleado->periodo_fin ?? now())
            );
        }
        
        return 0;
    }
    
    /**
     * Actualizar estatus de una nómina
     */
    public function actualizarEstatus(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'estatus' => 'required|in:Pendiente,Calculada,Pagada,Cancelada',
                'fecha_pago' => 'required_if:estatus,Pagada|nullable|date'
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            $nomina = Nomina::findOrFail($id);
            $estatusAnterior = $nomina->estatus;
            $nomina->estatus = $request->estatus;
            
            if ($request->estatus === 'Pagada' && $request->fecha_pago) {
                $nomina->fecha_pago = $request->fecha_pago;
            }
            
            $nomina->save();
            
            Log::info("✅ Estatus de nómina actualizado", [
                'folio' => $nomina->folio,
                'estatus_anterior' => $estatusAnterior,
                'estatus_nuevo' => $nomina->estatus,
                'usuario' => Auth::id()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Estatus actualizado correctamente',
                'data' => $nomina
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Nómina no encontrada'
            ], 404);
        } catch (\Exception $e) {
            Log::error('❌ Error actualizando estatus: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar estatus: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Display the specified resource
     */
    public function show($id)
    {
        try {
            $nomina = Nomina::with('empleado', 'calculadoPor')->findOrFail($id);
            
            // Si es petición API, devolver JSON
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $nomina
                ]);
            }
            
            // Si es petición web, devolver vista
            return view('rh.nomina.detalle', compact('nomina'));
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nómina no encontrada'
                ], 404);
            }
            return redirect()->route('nomina.index')->with('error', 'Nómina no encontrada');
        } catch (\Exception $e) {
            Log::error('❌ Error en show: ' . $e->getMessage());
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al obtener nómina: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->route('nomina.index')->with('error', 'Error al obtener nómina');
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
            Log::error('❌ Error al imprimir recibo: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al imprimir recibo');
        }
    }
    
    /**
     * Generate PDF de nómina
     */
    public function generarPDF($id)
    {
        try {
            $nomina = Nomina::with('empleado')->findOrFail($id);
            
            // Aquí se implementaría la generación de PDF con una librería como DomPDF
            // Por ahora devolvemos JSON
            return response()->json([
                'success' => true,
                'message' => 'PDF generado correctamente',
                'data' => $nomina
            ]);
            
        } catch (\Exception $e) {
            Log::error('❌ Error al generar PDF: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar PDF: ' . $e->getMessage()
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
            
            Log::info("🚫 Nómina cancelada", [
                'folio' => $nomina->folio,
                'usuario' => Auth::id()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Nómina cancelada correctamente',
                'data' => $nomina
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Nómina no encontrada'
            ], 404);
        } catch (\Exception $e) {
            Log::error('❌ Error al cancelar nómina: ' . $e->getMessage());
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
            $validator = Validator::make($request->all(), [
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            $resumen = Nomina::whereBetween('periodo_inicio', [$request->fecha_inicio, $request->fecha_fin])
                ->select(
                    DB::raw('COUNT(*) as total_nominas'),
                    DB::raw('SUM(CASE WHEN estatus = "Pagada" THEN neto_pagar ELSE 0 END) as total_pagado'),
                    DB::raw('SUM(CASE WHEN estatus = "Calculada" THEN neto_pagar ELSE 0 END) as total_calculado'),
                    DB::raw('SUM(CASE WHEN estatus = "Pendiente" THEN neto_pagar ELSE 0 END) as total_pendiente'),
                    DB::raw('SUM(neto_pagar) as total_general'),
                    DB::raw('COUNT(CASE WHEN estatus = "Pagada" THEN 1 END) as pagadas_count'),
                    DB::raw('COUNT(CASE WHEN estatus = "Calculada" THEN 1 END) as calculadas_count'),
                    DB::raw('COUNT(CASE WHEN estatus = "Pendiente" THEN 1 END) as pendientes_count'),
                    DB::raw('COUNT(CASE WHEN estatus = "Cancelada" THEN 1 END) as canceladas_count')
                )
                ->first();
            
            return response()->json([
                'success' => true,
                'data' => $resumen
            ]);
            
        } catch (\Exception $e) {
            Log::error('❌ Error al obtener resumen: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener resumen: ' . $e->getMessage()
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
            
            $nominas = $query->orderBy('periodo_inicio', 'desc')->get();
            
            // Aquí se implementaría la exportación a Excel con una librería
            // Por ahora devolvemos JSON con los datos
            return response()->json([
                'success' => true,
                'message' => 'Exportación preparada',
                'total_registros' => $nominas->count(),
                'data' => $nominas
            ]);
            
        } catch (\Exception $e) {
            Log::error('❌ Error al exportar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener empleados disponibles para nómina (API)
     */
    public function getEmpleadosDisponibles(Request $request)
    {
        try {
            $query = Plantilla::where('estatus', 'Activo')
                ->with('puesto');
            
            // Búsqueda
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                      ->orWhere('apellido_paterno', 'like', "%{$search}%")
                      ->orWhere('apellido_materno', 'like', "%{$search}%")
                      ->orWhere('rfc', 'like', "%{$search}%")
                      ->orWhere('numero_empleado_interno', 'like', "%{$search}%");
                });
            }
            
            // Filtrar por puesto
            if ($request->filled('puesto_id')) {
                $query->where('cat_puesto_id', $request->puesto_id);
            }
            
            $empleados = $query->orderBy('nombre')
                ->orderBy('apellido_paterno')
                ->get()
                ->map(function($emp) {
                    return [
                        'id' => $emp->plantilla_id,
                        'plantilla_id' => $emp->plantilla_id,
                        'nombre_completo' => $this->getNombreCompleto($emp),
                        'nombre' => $emp->nombre,
                        'apellido_paterno' => $emp->apellido_paterno,
                        'apellido_materno' => $emp->apellido_materno,
                        'puesto' => $emp->puesto ? $emp->puesto->nombre : 'Sin puesto',
                        'sueldo_diario' => $this->obtenerSueldoDiario($emp),
                        'rfc' => $emp->rfc,
                        'numero_empleado' => $emp->numero_empleado_interno,
                        'fecha_ingreso' => $emp->fecha_ingreso ? $emp->fecha_ingreso->format('Y-m-d') : null
                    ];
                });
            
            return response()->json([
                'success' => true,
                'data' => $empleados,
                'total' => $empleados->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('❌ Error al obtener empleados disponibles: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener empleados: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Recalcular una nómina existente
     */
    public function recalcular($id)
    {
        try {
            $nomina = Nomina::with('empleado')->findOrFail($id);
            
            if ($nomina->estatus === 'Pagada') {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede recalcular una nómina ya pagada'
                ], 400);
            }
            
            $empleado = $nomina->empleado;
            $periodoInicio = Carbon::parse($nomina->periodo_inicio);
            $periodoFin = Carbon::parse($nomina->periodo_fin);
            
            // Recalcular
            $diasTrabajados = $this->calcularDiasTrabajados($empleado, $periodoInicio, $periodoFin);
            $sueldoDiario = $this->obtenerSueldoDiario($empleado);
            $sueldoBase = $sueldoDiario * $diasTrabajados;
            
            $bonoAsistencia = $this->calcularBonoAsistencia($empleado, $periodoInicio, $periodoFin);
            $bonoProductividad = $empleado->bono_productividad ?? 0;
            $bonoAdministrativo = $empleado->bono_administrativo ?? 0;
            
            $totalPercepciones = $sueldoBase + $bonoAsistencia + $bonoProductividad + $bonoAdministrativo;
            
            $isr = $this->calcularISR($totalPercepciones);
            $imss = $this->calcularIMSS($sueldoBase);
            $infonavit = $this->calcularInfonavit($empleado, $sueldoBase);
            $pensionAlimenticia = $empleado->pension_alimenticia ?? 0;
            $fonacot = $empleado->fonacot ?? 0;
            
            $totalDeducciones = $isr + $imss + $infonavit + $pensionAlimenticia + $fonacot;
            $netoPagar = max(0, $totalPercepciones - $totalDeducciones);
            
            // Actualizar nómina
            $nomina->update([
                'dias_trabajados' => $diasTrabajados,
                'sueldo_diario' => $sueldoDiario,
                'sueldo_base' => $sueldoBase,
                'bono_asistencia' => $bonoAsistencia,
                'bono_productividad' => $bonoProductividad,
                'bono_administrativo' => $bonoAdministrativo,
                'total_percepciones' => $totalPercepciones,
                'isr' => $isr,
                'imss' => $imss,
                'infonavit' => $infonavit,
                'pension_alimenticia' => $pensionAlimenticia,
                'fonacot' => $fonacot,
                'total_deducciones' => $totalDeducciones,
                'neto_pagar' => $netoPagar,
                'estatus' => Nomina::ESTATUS_CALCULADA
            ]);
            
            Log::info("🔄 Nómina recalculada", [
                'folio' => $nomina->folio,
                'neto_anterior' => $nomina->getOriginal('neto_pagar'),
                'neto_nuevo' => $netoPagar
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Nómina recalculada correctamente',
                'data' => $nomina
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Nómina no encontrada'
            ], 404);
        } catch (\Exception $e) {
            Log::error('❌ Error al recalcular nómina: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al recalcular nómina: ' . $e->getMessage()
            ], 500);
        }
    }

    public function pagosIndex(Request $request)
    {
        try {
            $query = Nomina::with('empleado');

            // 🔍 Búsqueda
            if ($request->filled('buscar')) {
                $buscar = $request->buscar;
                $query->where(function($q) use ($buscar) {
                    $q->where('folio', 'LIKE', "%{$buscar}%")
                      ->orWhere('empleado_nombre', 'LIKE', "%{$buscar}%")
                      ->orWhere('observaciones', 'LIKE', "%{$buscar}%")
                      ->orWhereHas('empleado', function($emp) use ($buscar) {
                          $emp->where('nombre', 'LIKE', "%{$buscar}%")
                              ->orWhere('apellido_paterno', 'LIKE', "%{$buscar}%")
                              ->orWhere('apellido_materno', 'LIKE', "%{$buscar}%")
                              ->orWhere('rfc', 'LIKE', "%{$buscar}%")
                              ->orWhere('numero_empleado_interno', 'LIKE', "%{$buscar}%");
                      });
                });
            }

            // 📅 Filtro por fechas
            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha_pago', '>=', $request->fecha_inicio);
            }
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha_pago', '<=', $request->fecha_fin);
            }

            // 📊 Filtro por estatus
            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }   

            // 📌 Filtro por tipo de período
            if ($request->filled('periodo_tipo')) {
                $query->where('periodo_tipo', $request->periodo_tipo);
            }

            // ⬆️ Ordenamiento
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            // 📄 Paginación
            $perPage = $request->get('per_page', 15);
            $nominas = $query->paginate($perPage);

            // 📊 Estadísticas
            $estadisticas = [
                'total' => Nomina::count(),
                'pagado' => Nomina::where('estatus', 'Pagada')->count(),
                'pendiente' => Nomina::where('estatus', 'Pendiente')->count(),
                'cancelado' => Nomina::where('estatus', 'Cancelada')->count(),
                'calculado' => Nomina::where('estatus', 'Calculada')->count(),
                'total_monto' => Nomina::sum('neto_pagar'),
                'monto_pagado' => Nomina::where('estatus', 'Pagada')->sum('neto_pagar'),
                'monto_pendiente' => Nomina::where('estatus', 'Pendiente')->sum('neto_pagar'),
            ];

            // 🔄 Si es petición API
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $nominas->items(),
                    'pagination' => [
                        'current_page' => $nominas->currentPage(),
                        'last_page' => $nominas->lastPage(),
                        'per_page' => $nominas->perPage(),
                        'total' => $nominas->total(),
                        'from' => $nominas->firstItem(),
                        'to' => $nominas->lastItem(),
                    ],
                    'estadisticas' => $estadisticas,
                ]);
            }

            // 📱 Vista web
            return view('rh.nomina.pagos', [
                'nominas' => $nominas,
                'estadisticas' => $estadisticas,
                'filtros' => [
                    'buscar' => $request->buscar,
                    'estatus' => $request->estatus,
                    'periodo_tipo' => $request->periodo_tipo,
                    'fecha_inicio' => $request->fecha_inicio,
                    'fecha_fin' => $request->fecha_fin,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error en pagosIndex: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar pagos: ' . $e->getMessage()
                ], 500);
            }

            return view('rh.nomina.pagos', [
                'nominas' => collect([]),
                'estadisticas' => [
                    'total' => 0,
                    'pagado' => 0,
                    'pendiente' => 0,
                    'cancelado' => 0,
                    'calculado' => 0,
                    'total_monto' => 0,
                    'monto_pagado' => 0,
                    'monto_pendiente' => 0,
                ],
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Obtener datos para DataTable (AJAX)
     */
    public function pagosDatatable(Request $request)
    {
        try {
            $columns = ['folio', 'fecha_pago', 'periodo_inicio', 'periodo_fin', 'observaciones', 'estatus'];
            $column = $request->get('order', [['column' => 0, 'dir' => 'desc']])[0];
            $sortColumn = $columns[$column['column']] ?? 'created_at';
            $sortDirection = $column['dir'] ?? 'desc';

            $query = Nomina::with('empleado');

            // Búsqueda general
            if ($request->filled('search') && $request->search['value']) {
                $search = $request->search['value'];
                $query->where(function($q) use ($search) {
                    $q->where('folio', 'LIKE', "%{$search}%")
                      ->orWhere('empleado_nombre', 'LIKE', "%{$search}%")
                      ->orWhere('observaciones', 'LIKE', "%{$search}%")
                      ->orWhereHas('empleado', function($emp) use ($search) {
                          $emp->where('nombre', 'LIKE', "%{$search}%")
                              ->orWhere('apellido_paterno', 'LIKE', "%{$search}%")
                              ->orWhere('apellido_materno', 'LIKE', "%{$search}%")
                              ->orWhere('rfc', 'LIKE', "%{$search}%");
                      });
                });
            }

            // Filtros adicionales
            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }
            if ($request->filled('periodo_tipo')) {
                $query->where('periodo_tipo', $request->periodo_tipo);
            }

            $totalRecords = $query->count();

            $nominas = $query->orderBy($sortColumn, $sortDirection)
                ->skip($request->get('start', 0))
                ->take($request->get('length', 15))
                ->get()
                ->map(function($nomina) {
                    return [
                        'id' => $nomina->id,
                        'folio' => $nomina->folio,
                        'fecha_pago' => $nomina->fecha_pago ? $nomina->fecha_pago->format('d/m/Y') : '-',
                        'fecha_inicio' => $nomina->periodo_inicio ? $nomina->periodo_inicio->format('d/m/Y') : '-',
                        'fecha_fin' => $nomina->periodo_fin ? $nomina->periodo_fin->format('d/m/Y') : '-',
                        'empleado_nombre' => $nomina->empleado_nombre,
                        'observaciones' => $nomina->observaciones ?? '-',
                        'estatus' => $nomina->estatus,
                        'estatus_badge' => $this->getEstatusBadge($nomina->estatus),
                        'neto_pagar' => number_format($nomina->neto_pagar, 2),
                        'acciones' => $this->getAccionesHtml($nomina->id)
                    ];
                });

            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $nominas
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error en pagosDatatable: ' . $e->getMessage());
            return response()->json([
                'draw' => intval($request->draw ?? 0),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Crear un nuevo pago de nómina (desde el modal)
     */
    public function storePago(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'empleado_id' => 'required|exists:plantillas,plantilla_id',
                'periodo_tipo' => 'required|in:Semanal,Quincenal,Mensual',
                'periodo_inicio' => 'required|date',
                'periodo_fin' => 'required|date|after_or_equal:periodo_inicio',
                'sueldo_diario' => 'required|numeric|min:0',
                'dias_trabajados' => 'required|integer|min:0|max:31',
                'estatus' => 'required|in:Pagada,Pendiente,Cancelada,Calculada',
                'fecha_pago' => 'nullable|date',
                'observaciones' => 'nullable|string|max:500',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Verificar duplicado
            $existe = Nomina::where('empleado_id', $request->empleado_id)
                ->where('periodo_inicio', $request->periodo_inicio)
                ->where('periodo_fin', $request->periodo_fin)
                ->exists();

            if ($existe) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe una nómina para este empleado en el período seleccionado'
                ], 409);
            }

            $empleado = Plantilla::where('plantilla_id', $request->empleado_id)->first();
            $nombreCompleto = $this->getNombreCompleto($empleado);
            $puestoNombre = $empleado->puesto ? $empleado->puesto->nombre : 'Sin puesto';

            // Generar folio
            $folio = $this->generarFolioPago();

            DB::beginTransaction();

            $nomina = Nomina::create([
                'folio' => $folio,
                'empleado_id' => $request->empleado_id,
                'empleado_nombre' => $nombreCompleto,
                'puesto' => $puestoNombre,
                'periodo_tipo' => $request->periodo_tipo,
                'periodo_inicio' => $request->periodo_inicio,
                'periodo_fin' => $request->periodo_fin,
                'dias_trabajados' => $request->dias_trabajados,
                'sueldo_diario' => $request->sueldo_diario,
                'sueldo_base' => $request->sueldo_diario * $request->dias_trabajados,
                'total_percepciones' => $request->total_percepciones ?? 0,
                'total_deducciones' => $request->total_deducciones ?? 0,
                'neto_pagar' => $request->neto_pagar ?? ($request->sueldo_diario * $request->dias_trabajados),
                'estatus' => $request->estatus,
                'fecha_pago' => $request->fecha_pago ?? ($request->estatus === 'Pagada' ? now() : null),
                'observaciones' => $request->observaciones,
                'calculado_por' => Auth::id(),
            ]);

            DB::commit();

            Log::info('✅ Pago de nómina creado manualmente', [
                'folio' => $folio,
                'empleado' => $nombreCompleto,
                'usuario' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pago de nómina creado exitosamente',
                'data' => $nomina
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Error en storePago: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear pago: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un pago de nómina
     */
    public function updatePago(Request $request, $id)
    {
        try {
            $nomina = Nomina::find($id);
            
            if (!$nomina) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nómina no encontrada'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'estatus' => 'sometimes|in:Pagada,Pendiente,Cancelada,Calculada',
                'fecha_pago' => 'nullable|date',
                'observaciones' => 'nullable|string|max:500',
                'neto_pagar' => 'sometimes|numeric|min:0',
                'dias_trabajados' => 'sometimes|integer|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->only(['estatus', 'fecha_pago', 'observaciones', 'neto_pagar', 'dias_trabajados']);
            
            // Si se cambia a Pagada y no tiene fecha, asignar hoy
            if ($request->estatus === 'Pagada' && !$request->fecha_pago) {
                $data['fecha_pago'] = now();
            }

            DB::beginTransaction();
            $nomina->update($data);
            DB::commit();

            Log::info('✅ Pago de nómina actualizado', [
                'folio' => $nomina->folio,
                'usuario' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pago de nómina actualizado exitosamente',
                'data' => $nomina
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Error en updatePago: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un pago de nómina
     */
    public function destroyPago($id)
    {
        try {
            $nomina = Nomina::find($id);
            
            if (!$nomina) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nómina no encontrada'
                ], 404);
            }

            // No permitir eliminar nóminas pagadas
            if ($nomina->estatus === 'Pagada') {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar una nómina ya pagada'
                ], 400);
            }

            DB::beginTransaction();
            $nomina->delete();
            DB::commit();

            Log::info('🗑️ Pago de nómina eliminado', [
                'folio' => $nomina->folio,
                'usuario' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pago de nómina eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Error en destroyPago: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generar PDF de un pago de nómina
     */
    public function generarPdfPago($id)
    {
        try {
            $nomina = Nomina::with('empleado')->find($id);
            
            if (!$nomina) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nómina no encontrada'
                ], 404);
            }

            // Aquí implementarías la generación del PDF
            // Por ahora devolvemos un JSON de éxito
            return response()->json([
                'success' => true,
                'message' => 'PDF generado correctamente',
                'data' => [
                    'folio' => $nomina->folio,
                    'empleado' => $nomina->empleado_nombre,
                    'neto' => number_format($nomina->neto_pagar, 2),
                    'url_download' => route('nomina.pdf.download', $nomina->id) // Ruta futura
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error en generarPdfPago: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    // ========================================
    // 🔧 MÉTODOS PRIVADOS AUXILIARES
    // ========================================

    /**
     * Generar folio para pago manual
     */
    private function generarFolioPago()
    {
        $ultimo = Nomina::orderBy('id', 'desc')->first();
        $numero = $ultimo ? intval(substr($ultimo->folio, 5)) + 1 : 1001;
        return 'NOM-' . str_pad($numero, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Obtener badge HTML para estatus
     */
    private function getEstatusBadge($estatus)
    {
        $badges = [
            'Pagada' => '<span class="badge badge-success" style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px;">Pagada</span>',
            'Pendiente' => '<span class="badge badge-warning" style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px;">Pendiente</span>',
            'Cancelada' => '<span class="badge badge-danger" style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px;">Cancelada</span>',
            'Calculada' => '<span class="badge badge-info" style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 3px;">Calculada</span>',
        ];
        return $badges[$estatus] ?? $badges['Pendiente'];
    }

    /**
     * Obtener HTML de acciones
     */
    private function getAccionesHtml($id)
    {
        return '
            <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verDetalle(' . $id . ')"></i>
            <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarNomina(' . $id . ')"></i>
            <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="eliminarNomina(' . $id . ')"></i>
            <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="generarPDF(' . $id . ')"></i>
        ';
    }

    
}