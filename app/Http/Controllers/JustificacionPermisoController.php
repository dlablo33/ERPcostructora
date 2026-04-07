<?php

namespace App\Http\Controllers;

use App\Models\JustificacionPermiso;
use App\Models\Plantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class JustificacionPermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = JustificacionPermiso::query();
            
            // Buscador
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('folio', 'LIKE', "%{$search}%")
                      ->orWhere('empleado_nombre', 'LIKE', "%{$search}%")
                      ->orWhere('tipo', 'LIKE', "%{$search}%")
                      ->orWhere('motivo', 'LIKE', "%{$search}%");
                });
            }
            
            // Filtro por estatus
            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }
            
            // Filtro por tipo
            if ($request->filled('tipo')) {
                $query->where('tipo', $request->tipo);
            }
            
            $justificaciones = $query->orderBy('created_at', 'desc')->paginate(15);
            
            // Obtener empleados de la tabla plantilla
            try {
                $empleados = Plantilla::where('activo', 1)
                    ->orWhere('estatus', 'activo')
                    ->select('id', 'nombre_completo as nombre', 'puesto')
                    ->orderBy('nombre_completo')
                    ->get();
            } catch (\Exception $e) {
                // Si no hay tabla, usar datos de ejemplo
                $empleados = collect([
                    (object)['id' => 1, 'nombre' => 'JUAN CARLOS PÉREZ LÓPEZ'],
                    (object)['id' => 2, 'nombre' => 'MARÍA FERNANDA RAMOS GARCÍA'],
                    (object)['id' => 3, 'nombre' => 'CARLOS ALBERTO MENDOZA SÁNCHEZ'],
                    (object)['id' => 4, 'nombre' => 'ANA SOFÍA MARTÍNEZ FLORES'],
                    (object)['id' => 5, 'nombre' => 'ROBERTO ANTONIO SÁNCHEZ TORRES'],
                ]);
            }
            
            return view('rh.asistencia.justificantes', compact('justificaciones', 'empleados'));
            
        } catch (\Exception $e) {
            Log::error('Error en index de justificaciones: ' . $e->getMessage());
            $justificaciones = collect([]);
            $empleados = collect([]);
            return view('rh.asistencia.justificantes', compact('justificaciones', 'empleados'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('=== INICIO STORE JUSTIFICACION ===');
        Log::info('Request all:', $request->all());
        
        try {
            $validated = $request->validate([
                'empleado_id' => 'required',
                'empleado_nombre' => 'required|string',
                'tipo' => 'required|string',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                'motivo' => 'nullable|string',
                'estatus' => 'required|in:Pendiente,Aprobado,Rechazado',
                'dias' => 'nullable|integer'
            ]);
            
            Log::info('Validación exitosa');
            
            DB::beginTransaction();
            
            // Calcular días si no vienen en la request
            $dias = $request->dias ?? $this->calcularDias($request->fecha_inicio, $request->fecha_fin);
            $folio = $this->generarFolio();
            
            Log::info('Datos a guardar:', [
                'folio' => $folio,
                'empleado_id' => $request->empleado_id,
                'empleado_nombre' => $request->empleado_nombre,
                'tipo' => $request->tipo,
                'dias' => $dias,
                'estatus' => $request->estatus
            ]);
            
            $justificacion = JustificacionPermiso::create([
                'folio' => $folio,
                'empleado_id' => $request->empleado_id,
                'empleado_nombre' => $request->empleado_nombre,
                'tipo' => $request->tipo,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'dias' => $dias,
                'estatus' => $request->estatus,
                'tiene_justificante' => $request->hasFile('justificante'),
                'motivo' => $request->motivo,
                'observaciones' => $request->observaciones ?? null
            ]);
            
            Log::info('Justificación creada con ID: ' . $justificacion->id);
            
            // Subir archivo justificante si existe
            if ($request->hasFile('justificante')) {
                $archivo = $request->file('justificante');
                $nombreArchivo = 'justificante_' . $justificacion->folio . '.' . $archivo->getClientOriginalExtension();
                $ruta = $archivo->storeAs('justificantes', $nombreArchivo, 'public');
                $justificacion->update([
                    'archivo_justificante' => $ruta,
                    'tiene_justificante' => true
                ]);
                Log::info('Justificante subido: ' . $ruta);
            }
            
            DB::commit();
            
            Log::info('Justificación guardada exitosamente');
            
            return response()->json([
                'success' => true,
                'message' => 'Justificación/Permiso creado exitosamente',
                'data' => $justificacion
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Error de validación:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al guardar justificación:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $justificacion = JustificacionPermiso::findOrFail($id);
            return response()->json($justificacion);
        } catch (\Exception $e) {
            Log::error('Error al obtener justificación: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Registro no encontrado'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Log::info('=== INICIO UPDATE JUSTIFICACION ===', ['id' => $id]);
        
        try {
            $justificacion = JustificacionPermiso::findOrFail($id);
            
            $validated = $request->validate([
                'tipo' => 'required|string',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                'motivo' => 'nullable|string',
                'estatus' => 'required|in:Pendiente,Aprobado,Rechazado',
                'dias' => 'nullable|integer'
            ]);
            
            DB::beginTransaction();
            
            // Calcular días si no vienen en la request
            $dias = $request->dias ?? $this->calcularDias($request->fecha_inicio, $request->fecha_fin);
            
            $justificacion->update([
                'tipo' => $request->tipo,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'dias' => $dias,
                'estatus' => $request->estatus,
                'motivo' => $request->motivo,
                'observaciones' => $request->observaciones ?? $justificacion->observaciones
            ]);
            
            // Subir nuevo justificante si se proporciona
            if ($request->hasFile('justificante')) {
                // Eliminar archivo anterior si existe
                if ($justificacion->archivo_justificante) {
                    Storage::disk('public')->delete($justificacion->archivo_justificante);
                }
                
                $archivo = $request->file('justificante');
                $nombreArchivo = 'justificante_' . $justificacion->folio . '.' . $archivo->getClientOriginalExtension();
                $ruta = $archivo->storeAs('justificantes', $nombreArchivo, 'public');
                $justificacion->update([
                    'archivo_justificante' => $ruta,
                    'tiene_justificante' => true
                ]);
                Log::info('Justificante actualizado: ' . $ruta);
            }
            
            DB::commit();
            
            Log::info('Justificación actualizada exitosamente');
            
            return response()->json([
                'success' => true,
                'message' => 'Justificación/Permiso actualizado exitosamente',
                'data' => $justificacion
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Error de validación en update:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar justificación:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Log::info('=== INICIO DESTROY JUSTIFICACION ===', ['id' => $id]);
        
        try {
            $justificacion = JustificacionPermiso::findOrFail($id);
            
            // Eliminar archivo justificante si existe
            if ($justificacion->archivo_justificante) {
                Storage::disk('public')->delete($justificacion->archivo_justificante);
                Log::info('Archivo eliminado: ' . $justificacion->archivo_justificante);
            }
            
            $justificacion->delete();
            
            Log::info('Justificación eliminada exitosamente');
            
            return response()->json([
                'success' => true,
                'message' => 'Registro eliminado exitosamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar justificación:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Print the specified resource.
     */
    public function print($id)
    {
        try {
            $justificacion = JustificacionPermiso::findOrFail($id);
            return view('rh.asistencia.justificantes-print', compact('justificacion'));
        } catch (\Exception $e) {
            Log::error('Error al imprimir: ' . $e->getMessage());
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }
    }
    
    /**
     * Download justificante file.
     */
    public function downloadJustificante($id)
    {
        try {
            $justificacion = JustificacionPermiso::findOrFail($id);
            
            if ($justificacion->archivo_justificante && Storage::disk('public')->exists($justificacion->archivo_justificante)) {
                return Storage::disk('public')->download($justificacion->archivo_justificante);
            }
            
            return response()->json(['error' => 'Archivo no encontrado'], 404);
            
        } catch (\Exception $e) {
            Log::error('Error al descargar justificante: ' . $e->getMessage());
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }
    }
    
    /**
     * Calcular días entre fechas
     */
    private function calcularDias($fechaInicio, $fechaFin)
    {
        $inicio = new \DateTime($fechaInicio);
        $fin = new \DateTime($fechaFin);
        $interval = $inicio->diff($fin);
        return $interval->days + 1;
    }
    
    /**
     * Generar folio automático
     */
    private function generarFolio()
    {
        $ultimo = JustificacionPermiso::orderBy('id', 'desc')->first();
        $numero = $ultimo ? intval(substr($ultimo->folio, 4)) + 1 : 1001;
        return 'JP-' . $numero;
    }
}