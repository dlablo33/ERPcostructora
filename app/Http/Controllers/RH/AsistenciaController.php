<?php
// app/Http/Controllers/RH/AsistenciaController.php

namespace App\Http\Controllers\RH;

use App\Models\User;
use App\Models\Plantilla;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Obtener los IDs de plantilla que el usuario puede ver según su rol
            $plantillaIds = $this->getPlantillaIdsPermitidos($user);
            
            // Query base de asistencias
            $query = Asistencia::with(['plantilla' => function($q) {
                $q->select('plantilla_id', 'nombre', 'apellido_paterno', 'apellido_materno', 'user_id');
            }, 'user', 'registrador'])
                ->whereIn('plantilla_id', $plantillaIds);
            
            // Aplicar filtros
            if ($request->buscar) {
                $buscar = $request->buscar;
                $query->whereHas('plantilla', function($q) use ($buscar) {
                    $q->where('nombre', 'ILIKE', "%{$buscar}%")
                      ->orWhere('apellido_paterno', 'ILIKE', "%{$buscar}%")
                      ->orWhere('apellido_materno', 'ILIKE', "%{$buscar}%")
                      ->orWhere('numero_empleado_interno', 'ILIKE', "%{$buscar}%");
                });
            }
            
            if ($request->fecha_inicio && $request->fecha_fin) {
                $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            }
            
            if ($request->estatus) {
                $query->where('estatus', $request->estatus);
            }
            
            $asistencias = $query->orderBy('fecha', 'desc')->get();
            
            // Formatear datos para la tabla
            $asistenciasFormateadas = $asistencias->map(function($asistencia) {
                return [
                    'id' => $asistencia->id,
                    'folio' => $asistencia->folio,
                    'fecha' => $asistencia->fecha ? $asistencia->fecha->format('d/m/Y') : '-',
                    'hora_entrada' => $asistencia->hora_entrada,
                    'hora_salida' => $asistencia->hora_salida,
                    'empleado' => $asistencia->plantilla ? $asistencia->plantilla->nombre_completo : ($asistencia->user ? $asistencia->user->name : '-'),
                    'observaciones' => $asistencia->observaciones,
                    'estatus' => $asistencia->estatus,
                    'estatus_badge' => $this->getEstatusBadge($asistencia->estatus),
                    'created_at' => $asistencia->created_at ? $asistencia->created_at->format('d/m/Y H:i') : '-'
                ];
            });
            
            $totalAsistencias = $asistencias->count();
            $asistenciasActivas = $asistencias->where('estatus', 'Activo')->count();
            $asistenciasPendientes = $asistencias->where('estatus', 'Pendiente')->count();
            $asistenciasFaltas = $asistencias->where('estatus', 'Falta')->count();
            $asistenciasRetardos = $asistencias->where('estatus', 'Retardo')->count();
            
            // Obtener empleados para el select del modal
            $empleados = Plantilla::whereIn('plantilla_id', $plantillaIds)
                ->activos()
                ->orderBy('nombre')
                ->get(['plantilla_id', 'nombre', 'apellido_paterno', 'apellido_materno', 'user_id'])
                ->map(function($empleado) {
                    return [
                        'id' => $empleado->plantilla_id,
                        'nombre_completo' => $empleado->nombre_completo,
                        'tiene_usuario' => $empleado->user_id ? true : false
                    ];
                });
            
            // Si es petición AJAX/API
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'asistencias' => $asistenciasFormateadas,
                        'totalAsistencias' => $totalAsistencias,
                        'asistenciasActivas' => $asistenciasActivas,
                        'asistenciasPendientes' => $asistenciasPendientes,
                        'asistenciasFaltas' => $asistenciasFaltas,
                        'asistenciasRetardos' => $asistenciasRetardos,
                        'empleados' => $empleados,
                        'usuario_actual' => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'rol' => $user->rol
                        ]
                    ]
                ]);
            }
            
            // Para vista web
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
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar los datos: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al cargar los datos: ' . $e->getMessage());
        }
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'plantilla_id' => 'required|exists:plantillas,plantilla_id',
                'fecha' => 'required|date',
                'hora_entrada' => 'nullable',
                'hora_salida' => 'nullable',
                'observaciones' => 'nullable|string',
                'estatus' => 'required|in:Activo,Pendiente,Justificado,Falta,Retardo'
            ]);
            
            $user = Auth::user();
            
            // Verificar permiso
            $plantillaIdsPermitidos = $this->getPlantillaIdsPermitidos($user);
            if (!in_array($validated['plantilla_id'], $plantillaIdsPermitidos)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tiene permiso para registrar asistencia de este empleado'
                ], 403);
            }
            
            // Verificar si ya existe registro para esta fecha
            $existe = Asistencia::where('plantilla_id', $validated['plantilla_id'])
                ->whereDate('fecha', $validated['fecha'])
                ->first();
            
            if ($existe) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe un registro de asistencia para esta fecha'
                ], 422);
            }
            
            // Generar folio automático
            $ultimoFolio = Asistencia::withTrashed()->max('folio');
            $nuevoFolio = $ultimoFolio ? (int)$ultimoFolio + 1 : 1;
            $folioFormateado = str_pad($nuevoFolio, 6, '0', STR_PAD_LEFT);
            
            // Calcular semana
            $fecha = \Carbon\Carbon::parse($validated['fecha']);
            $semana = $fecha->format('Y-W');
            $semanaInicio = $fecha->copy()->startOfWeek();
            $semanaFin = $fecha->copy()->endOfWeek();
            
            $asistencia = Asistencia::create([
                'folio' => $folioFormateado,
                'plantilla_id' => $validated['plantilla_id'],
                'fecha' => $validated['fecha'],
                'hora_entrada' => $validated['hora_entrada'] ?? null,
                'hora_salida' => $validated['hora_salida'] ?? null,
                'observaciones' => $validated['observaciones'],
                'estatus' => $validated['estatus'],
                'registrado_por' => $user->id,
                'tipo_registro' => 'entrada',
                'semana' => $semana,
                'semana_inicio' => $semanaInicio,
                'semana_fin' => $semanaFin
            ]);
            
            $asistencia->load(['plantilla', 'registrador']);
            
            return response()->json([
                'success' => true,
                'message' => 'Asistencia registrada exitosamente',
                'data' => [
                    'id' => $asistencia->id,
                    'folio' => $asistencia->folio,
                    'fecha' => $asistencia->fecha->format('d/m/Y'),
                    'hora_entrada' => $asistencia->hora_entrada,
                    'hora_salida' => $asistencia->hora_salida,
                    'empleado' => $asistencia->plantilla->nombre_completo,
                    'observaciones' => $asistencia->observaciones,
                    'estatus' => $asistencia->estatus,
                    'estatus_badge' => $this->getEstatusBadge($asistencia->estatus)
                ]
            ], 201);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al guardar asistencia: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        try {
            $asistencia = Asistencia::with(['plantilla', 'user', 'registrador'])->find($id);
            
            if (!$asistencia) {
                return response()->json([
                    'success' => false,
                    'message' => 'Asistencia no encontrada'
                ], 404);
            }
            
            $user = Auth::user();
            $plantillaIdsPermitidos = $this->getPlantillaIdsPermitidos($user);
            
            if (!in_array($asistencia->plantilla_id, $plantillaIdsPermitidos)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tiene permiso para ver esta asistencia'
                ], 403);
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $asistencia->id,
                    'folio' => $asistencia->folio,
                    'plantilla_id' => $asistencia->plantilla_id,
                    'empleado' => $asistencia->plantilla->nombre_completo,
                    'fecha' => $asistencia->fecha->format('Y-m-d'),
                    'hora_entrada' => $asistencia->hora_entrada,
                    'hora_salida' => $asistencia->hora_salida,
                    'observaciones' => $asistencia->observaciones,
                    'estatus' => $asistencia->estatus,
                    'registrado_por' => $asistencia->registrador ? $asistencia->registrador->name : '-'
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al mostrar asistencia: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $asistencia = Asistencia::find($id);
            
            if (!$asistencia) {
                return response()->json([
                    'success' => false,
                    'message' => 'Asistencia no encontrada'
                ], 404);
            }
            
            $user = Auth::user();
            $plantillaIdsPermitidos = $this->getPlantillaIdsPermitidos($user);
            
            if (!in_array($asistencia->plantilla_id, $plantillaIdsPermitidos)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tiene permiso para modificar esta asistencia'
                ], 403);
            }
            
            $validated = $request->validate([
                'fecha' => 'sometimes|date',
                'hora_entrada' => 'nullable',
                'hora_salida' => 'nullable',
                'observaciones' => 'nullable|string',
                'estatus' => 'sometimes|in:Activo,Pendiente,Justificado,Falta,Retardo'
            ]);
            
            $asistencia->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Asistencia actualizada exitosamente',
                'data' => $asistencia
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al actualizar asistencia: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            $asistencia = Asistencia::find($id);
            
            if (!$asistencia) {
                return response()->json([
                    'success' => false,
                    'message' => 'Asistencia no encontrada'
                ], 404);
            }
            
            $user = Auth::user();
            
            // Solo administradores pueden eliminar asistencias
            if ($user->rol !== 'Administrador') {
                return response()->json([
                    'success' => false,
                    'message' => 'No tiene permiso para eliminar asistencias'
                ], 403);
            }
            
            $asistencia->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Asistencia eliminada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar asistencia: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Registrar entrada rápida
     */
    public function registrarEntrada(Request $request)
    {
        try {
            $validated = $request->validate([
                'plantilla_id' => 'required|exists:plantillas,plantilla_id',
                'fecha' => 'required|date',
                'hora_entrada' => 'required'
            ]);
            
            $user = Auth::user();
            $plantillaIdsPermitidos = $this->getPlantillaIdsPermitidos($user);
            
            if (!in_array($validated['plantilla_id'], $plantillaIdsPermitidos)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tiene permiso para registrar asistencia de este empleado'
                ], 403);
            }
            
            // Verificar si ya existe registro
            $existe = Asistencia::where('plantilla_id', $validated['plantilla_id'])
                ->whereDate('fecha', $validated['fecha'])
                ->first();
            
            if ($existe) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe un registro de asistencia para esta fecha'
                ], 422);
            }
            
            $ultimoFolio = Asistencia::withTrashed()->max('folio');
            $nuevoFolio = $ultimoFolio ? (int)$ultimoFolio + 1 : 1;
            $folioFormateado = str_pad($nuevoFolio, 6, '0', STR_PAD_LEFT);
            
            $fecha = \Carbon\Carbon::parse($validated['fecha']);
            $semana = $fecha->format('Y-W');
            
            $asistencia = Asistencia::create([
                'folio' => $folioFormateado,
                'plantilla_id' => $validated['plantilla_id'],
                'fecha' => $validated['fecha'],
                'hora_entrada' => $validated['hora_entrada'],
                'estatus' => 'Activo',
                'registrado_por' => $user->id,
                'tipo_registro' => 'entrada',
                'semana' => $semana
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Entrada registrada exitosamente',
                'data' => $asistencia
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al registrar entrada: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Registrar salida
     */
    public function registrarSalida($id, Request $request)
    {
        try {
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
            
            $user = Auth::user();
            $plantillaIdsPermitidos = $this->getPlantillaIdsPermitidos($user);
            
            if (!in_array($asistencia->plantilla_id, $plantillaIdsPermitidos)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tiene permiso para modificar esta asistencia'
                ], 403);
            }
            
            $asistencia->update([
                'hora_salida' => $request->hora_salida
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Salida registrada exitosamente',
                'data' => $asistencia
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al registrar salida: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener IDs de plantilla que el usuario puede ver según su rol
     */
    private function getPlantillaIdsPermitidos($user)
    {
        $plantilla = $user->plantilla;
        
        switch ($user->rol) {
            case 'Administrador':
                return Plantilla::activos()->pluck('plantilla_id')->toArray();
                
            case 'Gerente':
            case 'Gerente de Proyectos':
                if ($plantilla && $plantilla->cat_area_id) {
                    $ids = Plantilla::activos()
                        ->where('cat_area_id', $plantilla->cat_area_id)
                        ->pluck('plantilla_id')
                        ->toArray();
                    
                    $subordinadosIds = $plantilla->coordinados()->activos()->pluck('plantilla_id')->toArray();
                    return array_unique(array_merge($ids, $subordinadosIds, [$plantilla->plantilla_id]));
                }
                return $plantilla ? [$plantilla->plantilla_id] : [];
                
            case 'Supervisor':
            case 'Residente':
                if ($plantilla) {
                    $ids = $plantilla->coordinados()->activos()->pluck('plantilla_id')->toArray();
                    return array_unique(array_merge($ids, [$plantilla->plantilla_id]));
                }
                return [];
                
            default:
                return $plantilla ? [$plantilla->plantilla_id] : [];
        }
    }
    
    /**
     * Obtener badge HTML para estatus
     */
    private function getEstatusBadge($estatus)
    {
        $badges = [
            'Activo' => '<span class="badge-activo">Activo</span>',
            'Pendiente' => '<span class="badge-pendiente">Pendiente</span>',
            'Justificado' => '<span class="badge-justificado">Justificado</span>',
            'Falta' => '<span class="badge-falta">Falta</span>',
            'Retardo' => '<span class="badge-retardo">Retardo</span>',
            'Cancelado' => '<span class="badge-cancelado">Cancelado</span>'
        ];
        
        return $badges[$estatus] ?? '<span class="badge-activo">' . $estatus . '</span>';
    }
}