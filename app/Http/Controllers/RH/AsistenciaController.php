<?php

namespace App\Http\Controllers\RH;

use App\Models\Asistencia;
use App\Models\Plantilla;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            Log::info('=== INICIO AsistenciaController@index ===');
            
            $query = Asistencia::with(['empleado', 'registrador'])
                ->orderBy('fecha', 'desc')
                ->orderBy('created_at', 'desc');

            // Aplicar filtros
            if ($request->has('fecha_inicio') && $request->fecha_inicio) {
                $query->whereDate('fecha', '>=', $request->fecha_inicio);
            }

            if ($request->has('fecha_fin') && $request->fecha_fin) {
                $query->whereDate('fecha', '<=', $request->fecha_fin);
            }

            if ($request->has('estatus') && $request->estatus) {
                $query->where('estatus', $request->estatus);
            }

            if ($request->has('buscar') && $request->buscar) {
                $buscar = $request->buscar;
                $query->where(function($q) use ($buscar) {
                    $q->whereHas('empleado', function($sub) use ($buscar) {
                        $sub->where('nombre', 'LIKE', "%{$buscar}%")
                            ->orWhere('apellido_paterno', 'LIKE', "%{$buscar}%")
                            ->orWhere('apellido_materno', 'LIKE', "%{$buscar}%")
                            ->orWhere('folio', 'LIKE', "%{$buscar}%");
                    })->orWhere('folio', 'LIKE', "%{$buscar}%");
                });
            }

            $asistencias = $query->get();
            
            Log::info('Asistencias obtenidas:', ['count' => $asistencias->count()]);

            // Calcular totales
            $totalAsistencias = $asistencias->count();
            $asistenciasActivas = $asistencias->where('estatus', 'Activo')->count();
            $asistenciasPendientes = $asistencias->where('estatus', 'Pendiente')->count();
            $asistenciasFaltas = $asistencias->where('estatus', 'Falta')->count();
            $asistenciasRetardos = $asistencias->where('estatus', 'Retardo')->count();

            // Obtener empleados para el select (solo activos)
            $empleados = Plantilla::select('plantilla_id as id', 'nombre', 'apellido_paterno', 'apellido_materno')
                ->whereIn('estatus', ['1', 'Activo'])
                ->whereNull('deleted_at')
                ->orderBy('nombre')
                ->get()
                ->map(function($emp) {
                    $emp->nombre_completo = trim($emp->nombre . ' ' . $emp->apellido_paterno . ' ' . $emp->apellido_materno);
                    return $emp;
                });

            // Formatear datos para la tabla
            $asistenciasFormateadas = $asistencias->map(function($asistencia) {
                return [
                    'id' => $asistencia->id,
                    'folio' => $asistencia->folio,
                    'nombre_persona' => $asistencia->nombre_persona,
                    'empleado' => $asistencia->nombre_persona,
                    'fecha' => $asistencia->fecha ? date('d/m/Y', strtotime($asistencia->fecha)) : '-',
                    'hora_entrada' => $asistencia->hora_entrada,
                    'hora_salida' => $asistencia->hora_salida,
                    'observaciones' => $asistencia->observaciones,
                    'estatus' => $asistencia->estatus,
                    'registrado_por' => $asistencia->registrador ? $asistencia->registrador->name : '-'
                ];
            });

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'asistencias' => $asistenciasFormateadas,
                        'totalAsistencias' => $totalAsistencias,
                        'asistenciasActivas' => $asistenciasActivas,
                        'asistenciasPendientes' => $asistenciasPendientes,
                        'asistenciasFaltas' => $asistenciasFaltas,
                        'asistenciasRetardos' => $asistenciasRetardos,
                        'empleados' => $empleados
                    ]
                ]);
            }

            return view('rh.asistencia.asistencia', compact(
                'asistenciasFormateadas',
                'totalAsistencias',
                'asistenciasActivas',
                'asistenciasPendientes',
                'asistenciasFaltas',
                'asistenciasRetardos',
                'empleados'
            ));

        } catch (\Exception $e) {
            Log::error('Error en AsistenciaController@index: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar los datos: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al cargar los datos: ' . $e->getMessage());
        }
    }

    /**
     * DEBUG: Get all users and employees for debugging
     */
    public function debugEmpleados(Request $request)
    {
        try {
            $user = auth()->user();
            
            // Buscar todos los usuarios
            $usuarios = User::select('id', 'name', 'email', 'rol', 'estatus')->get();
            
            // Buscar empleados con coordinador_plantilla_id = 2
            $empleadosCoordinador2 = Plantilla::where('coordinador_plantilla_id', 2)
                ->whereNull('deleted_at')
                ->get(['plantilla_id', 'nombre', 'apellido_paterno', 'estatus']);
            
            // Buscar empleados con coordinador_plantilla_id = ID del usuario autenticado
            $empleadosDelUsuario = [];
            if ($user) {
                $empleadosDelUsuario = Plantilla::where('coordinador_plantilla_id', $user->id)
                    ->whereNull('deleted_at')
                    ->where(function($query) {
                        $query->where('estatus', 'Activo')
                              ->orWhere('estatus', '1');
                    })
                    ->get(['plantilla_id', 'nombre', 'apellido_paterno', 'estatus']);
            }
            
            // Buscar todos los empleados activos
            $empleadosActivos = Plantilla::whereIn('estatus', ['1', 'Activo'])
                ->whereNull('deleted_at')
                ->get(['plantilla_id', 'nombre', 'apellido_paterno', 'coordinador_plantilla_id']);
            
            return response()->json([
                'success' => true,
                'debug' => [
                    'usuario_autenticado' => $user ? [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'rol' => $user->rol
                    ] : null,
                    'todos_los_usuarios' => $usuarios,
                    'empleados_con_coordinador_2' => [
                        'count' => $empleadosCoordinador2->count(),
                        'lista' => $empleadosCoordinador2
                    ],
                    'empleados_del_usuario_autenticado' => [
                        'count' => $empleadosDelUsuario->count(),
                        'lista' => $empleadosDelUsuario
                    ],
                    'todos_los_empleados_activos' => $empleadosActivos->map(function($emp) {
                        return [
                            'id' => $emp->plantilla_id,
                            'nombre' => $emp->nombre . ' ' . $emp->apellido_paterno,
                            'coordinador_id' => $emp->coordinador_plantilla_id ?? 'Sin asignar'
                        ];
                    })
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en debugEmpleados: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get employees under the current user's supervision (coordinador)
     */
    /**
 * Get employees under the current user's supervision (coordinador)
 */
public function getEmpleadosACargo(Request $request)
{
    
    try {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado'
            ], 401);
        }
        
        // Usar Query Builder (funciona igual que en test-simple)
        $empleados = DB::table('plantillas')
            ->select(
                'plantilla_id as id', 
                'nombre', 
                'apellido_paterno', 
                'apellido_materno',
                'cat_area_id',
                'cat_puesto_id'
            )
            ->where('coordinador_plantilla_id', $user->id)
            ->whereNull('deleted_at')
            ->where(function($query) {
                $query->where('estatus', 'Activo')
                      ->orWhere('estatus', '1');
            })
            ->orderBy('nombre')
            ->orderBy('apellido_paterno')
            ->get();
        
        $empleadosFormateados = $empleados->map(function($emp) {
            $nombreCompleto = trim($emp->nombre . ' ' . $emp->apellido_paterno . ' ' . $emp->apellido_materno);
            
            return [
                'id' => (int) $emp->id,
                'nombre_completo' => $nombreCompleto,
                'area' => '-',
                'puesto' => '-'
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $empleadosFormateados,
            'total' => $empleadosFormateados->count(),
            'user_id' => $user->id
        ]);
        
    } catch (\Exception $e) {
        Log::error('Error al obtener empleados a cargo: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error al cargar empleados: ' . $e->getMessage()
        ], 500);
    }
}
    /**
     * Store multiple attendances at once
     */
    public function storeMasivo(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $asistencias = $request->asistencias;
            
            if (!$asistencias || !is_array($asistencias) || count($asistencias) === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se enviaron asistencias para registrar'
                ], 400);
            }
            
            $registradas = 0;
            $duplicadas = 0;
            $errores = [];
            
            foreach ($asistencias as $asistencia) {
                try {
                    // Verificar si ya existe asistencia para este empleado en esta fecha
                    $existe = Asistencia::where('plantilla_id', $asistencia['plantilla_id'])
                        ->where('fecha', $asistencia['fecha'])
                        ->exists();
                    
                    if (!$existe) {
                        // Generar folio único
                        $folio = $this->generarFolio();
                        
                        Asistencia::create([
                            'folio' => $folio,
                            'plantilla_id' => $asistencia['plantilla_id'],
                            'fecha' => $asistencia['fecha'],
                            'hora_entrada' => $asistencia['hora_entrada'] ?? null,
                            'hora_salida' => $asistencia['hora_salida'] ?? null,
                            'estatus' => $asistencia['estatus'] ?? 'Activo',
                            'registrado_por' => auth()->id(),
                            'observaciones' => $asistencia['observaciones'] ?? null
                        ]);
                        $registradas++;
                    } else {
                        $duplicadas++;
                    }
                } catch (\Exception $e) {
                    $errores[] = "Error con empleado ID {$asistencia['plantilla_id']}: " . $e->getMessage();
                    Log::error('Error al guardar asistencia individual:', [
                        'asistencia' => $asistencia,
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
            DB::commit();
            
            $mensaje = "Se registraron $registradas asistencias correctamente";
            if ($duplicadas > 0) {
                $mensaje .= ". $duplicadas ya existían y no se registraron";
            }
            if (count($errores) > 0) {
                $mensaje .= ". Errores: " . implode(", ", $errores);
            }
            
            Log::info('Registro masivo de asistencias completado', [
                'registradas' => $registradas,
                'duplicadas' => $duplicadas,
                'errores' => count($errores)
            ]);
            
            return response()->json([
                'success' => true,
                'message' => $mensaje,
                'data' => [
                    'registradas' => $registradas,
                    'duplicadas' => $duplicadas,
                    'errores' => $errores
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en storeMasivo: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar asistencias: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate unique folio for attendance
     */
    private function generarFolio()
    {
        $ultimo = Asistencia::orderBy('id', 'desc')->first();
        $numero = $ultimo ? intval(substr($ultimo->folio, 5)) + 1 : 1;
        return 'ASIS-' . str_pad($numero, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            Log::info('=== INICIO CREACIÓN ASISTENCIA ===');
            Log::info('Datos recibidos:', $request->all());
            
            // Validar que no exista duplicado
            $existe = Asistencia::where('plantilla_id', $request->plantilla_id)
                ->where('fecha', $request->fecha)
                ->exists();
            
            if ($existe) {
                throw new \Exception('Ya existe un registro de asistencia para este empleado en esta fecha');
            }
            
            // Generar folio
            $folio = $this->generarFolio();
            
            $asistencia = Asistencia::create([
                'folio' => $folio,
                'plantilla_id' => $request->plantilla_id,
                'fecha' => $request->fecha,
                'hora_entrada' => $request->hora_entrada,
                'hora_salida' => $request->hora_salida,
                'observaciones' => $request->observaciones,
                'estatus' => $request->estatus ?? 'Activo',
                'registrado_por' => auth()->id()
            ]);
            
            DB::commit();
            
            Log::info('Asistencia creada exitosamente:', ['id' => $asistencia->id]);
            
            if ($request->wantsJson() || $request->is('api/*')) {
                $asistencia->load(['empleado', 'registrador']);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Asistencia registrada exitosamente',
                    'data' => $asistencia
                ], 201);
            }
            
            return redirect()->route('rh.asistencia')
                ->with('success', 'Asistencia registrada exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear asistencia: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al registrar asistencia: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al registrar asistencia: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        try {
            $asistencia = Asistencia::with(['empleado', 'registrador'])->find($id);
            
            if (!$asistencia) {
                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Asistencia no encontrada'
                    ], 404);
                }
                
                return abort(404, 'Asistencia no encontrada');
            }
            
            $data = [
                'id' => $asistencia->id,
                'folio' => $asistencia->folio,
                'plantilla_id' => $asistencia->plantilla_id,
                'nombre_persona' => $asistencia->nombre_persona,
                'empleado' => $asistencia->nombre_persona,
                'fecha' => $asistencia->fecha,
                'hora_entrada' => $asistencia->hora_entrada,
                'hora_salida' => $asistencia->hora_salida,
                'observaciones' => $asistencia->observaciones,
                'estatus' => $asistencia->estatus,
                'registrado_por' => $asistencia->registrador ? $asistencia->registrador->name : '-'
            ];
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => $data
                ]);
            }
            
            return view('rh.asistencia.show', compact('asistencia'));
            
        } catch (\Exception $e) {
            Log::error('Error al mostrar asistencia: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar la asistencia: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al cargar la asistencia: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            Log::info('=== INICIO ACTUALIZACIÓN ASISTENCIA ===');
            Log::info('ID recibido: ' . $id);
            Log::info('Datos recibidos:', $request->all());
            
            $asistencia = Asistencia::find($id);
            
            if (!$asistencia) {
                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Asistencia no encontrada'
                    ], 404);
                }
                
                return back()->with('error', 'Asistencia no encontrada');
            }
            
            $asistencia->update([
                'hora_entrada' => $request->hora_entrada,
                'hora_salida' => $request->hora_salida,
                'observaciones' => $request->observaciones,
                'estatus' => $request->estatus
            ]);
            
            DB::commit();
            
            Log::info('Asistencia actualizada exitosamente');
            
            if ($request->wantsJson() || $request->is('api/*')) {
                $asistencia->load(['empleado', 'registrador']);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Asistencia actualizada exitosamente',
                    'data' => $asistencia
                ]);
            }
            
            return redirect()->route('rh.asistencia')
                ->with('success', 'Asistencia actualizada exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar asistencia: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar asistencia: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al actualizar asistencia: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            Log::info('=== INICIO ELIMINACIÓN ASISTENCIA ===');
            Log::info('ID recibido: ' . $id);
            
            $asistencia = Asistencia::find($id);
            
            if (!$asistencia) {
                return response()->json([
                    'success' => false,
                    'message' => 'Asistencia no encontrada'
                ], 404);
            }
            
            $asistencia->delete();
            
            Log::info('Asistencia eliminada exitosamente');
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Asistencia eliminada exitosamente'
                ]);
            }
            
            return redirect()->route('rh.asistencia')
                ->with('success', 'Asistencia eliminada exitosamente');
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar asistencia: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar asistencia: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al eliminar asistencia: ' . $e->getMessage());
        }
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        try {
            Log::info('Exportando asistencias a Excel', [
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'estatus' => $request->estatus,
                'buscar' => $request->buscar
            ]);
            
            $nombreArchivo = 'asistencias_' . date('Y-m-d_His') . '.xlsx';
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Exportación iniciada',
                    'download_url' => route('asistencias.export.download', $request->all())
                ]);
            }
            
            return Excel::download(new AsistenciaExport(
                $request->fecha_inicio,
                $request->fecha_fin,
                $request->estatus,
                $request->buscar
            ), $nombreArchivo);
            
        } catch (\Exception $e) {
            Log::error('Error al exportar asistencias: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al exportar: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al exportar: ' . $e->getMessage());
        }
    }

    /**
     * Registrar entrada del empleado
     */
    public function registrarEntrada(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'plantilla_id' => 'required|exists:plantillas,plantilla_id',
                'fecha' => 'required|date',
                'hora_entrada' => 'required'
            ]);
            
            // Verificar si ya existe asistencia
            $existe = Asistencia::where('plantilla_id', $request->plantilla_id)
                ->where('fecha', $request->fecha)
                ->exists();
            
            if ($existe) {
                throw new \Exception('Ya existe un registro de asistencia para este empleado en esta fecha');
            }
            
            $folio = $this->generarFolio();
            
            $asistencia = Asistencia::create([
                'folio' => $folio,
                'plantilla_id' => $request->plantilla_id,
                'fecha' => $request->fecha,
                'hora_entrada' => $request->hora_entrada,
                'estatus' => 'Activo',
                'registrado_por' => auth()->id()
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Entrada registrada exitosamente',
                'data' => $asistencia
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar entrada: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar entrada: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Registrar salida del empleado
     */
    public function registrarSalida(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'hora_salida' => 'required'
            ]);
            
            $asistencia = Asistencia::find($id);
            
            if (!$asistencia) {
                return response()->json([
                    'success' => false,
                    'message' => 'Asistencia no encontrada'
                ], 404);
            }
            
            $asistencia->update([
                'hora_salida' => $request->hora_salida
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Salida registrada exitosamente',
                'data' => $asistencia
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
 * TEST: Get employees directly from database
 */
public function testEmpleados(Request $request)
{
    try {
        $user = auth()->user();
        
        // Consulta directa con Query Builder para evitar problemas de relaciones
        $empleados = DB::table('plantillas')
            ->select(
                'plantilla_id as id', 
                'nombre', 
                'apellido_paterno', 
                'apellido_materno', 
                'estatus', 
                'coordinador_plantilla_id'
            )
            ->where('coordinador_plantilla_id', $user ? $user->id : 2)
            ->whereNull('deleted_at')
            ->where(function($query) {
                $query->where('estatus', 'Activo')
                      ->orWhere('estatus', '1');
            })
            ->get()
            ->map(function($emp) {
                $emp->nombre_completo = trim($emp->nombre . ' ' . $emp->apellido_paterno . ' ' . $emp->apellido_materno);
                return $emp;
            });
        
        return response()->json([
            'success' => true,
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : null,
            'total_empleados' => $empleados->count(),
            'empleados' => $empleados
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
}
}