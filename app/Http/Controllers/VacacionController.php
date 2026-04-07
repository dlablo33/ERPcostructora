<?php

namespace App\Http\Controllers;

use App\Models\Vacacion;
use App\Models\Plantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VacacionController extends Controller
{
    public function index()
    {
        $vacaciones = Vacacion::with('empleado')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $empleados = Plantilla::activos()
            ->orderBy('nombre')
            ->orderBy('apellido_paterno')
            ->get();
        
        return view('rh.prestaciones.vacaciones', compact('vacaciones', 'empleados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plantilla_id' => 'required|exists:plantillas,plantilla_id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'dias' => 'required|integer|min:1',
            'observaciones' => 'nullable|string',
            'estatus' => 'required|string',
        ]);

        try {
            DB::beginTransaction();
            
            $vacacion = Vacacion::create($validated);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Registro de vacaciones guardado correctamente',
                'vacacion' => $vacacion->load('empleado')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el registro: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $vacacion = Vacacion::findOrFail($id);
        
        $validated = $request->validate([
            'plantilla_id' => 'required|exists:plantillas,plantilla_id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'dias' => 'required|integer|min:1',
            'observaciones' => 'nullable|string',
            'estatus' => 'required|string',
        ]);

        try {
            DB::beginTransaction();
            
            $vacacion->update($validated);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Registro de vacaciones actualizado correctamente',
                'vacacion' => $vacacion->load('empleado')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el registro: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $vacacion = Vacacion::findOrFail($id);
            $vacacion->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Registro de vacaciones eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el registro: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $vacacion = Vacacion::with('empleado')->findOrFail($id);
        return response()->json($vacacion);
    }

    public function exportExcel()
    {
        try {
            $vacaciones = Vacacion::with('empleado')
                ->orderBy('created_at', 'desc')
                ->get();
            
            $filename = 'vacaciones_' . date('Y-m-d') . '.csv';
            $handle = fopen('php://temp', 'w+');
            
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($handle, [
                'ID', 'Folio', 'Empleado', 'Fecha Inicio', 'Fecha Fin', 
                'Días', 'Estatus', 'Observaciones', 'Fecha Registro'
            ]);
            
            foreach ($vacaciones as $vacacion) {
                fputcsv($handle, [
                    $vacacion->id,
                    $vacacion->folio,
                    $vacacion->nombre_empleado,
                    $vacacion->fecha_inicio->format('d/m/Y'),
                    $vacacion->fecha_fin->format('d/m/Y'),
                    $vacacion->dias,
                    $vacacion->estatus,
                    $vacacion->observaciones ?? '-',
                    $vacacion->created_at->format('d/m/Y H:i')
                ]);
            }
            
            rewind($handle);
            $csv = stream_get_contents($handle);
            fclose($handle);
            
            return response($csv, 200)
                ->header('Content-Type', 'text/csv; charset=UTF-8')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
                
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }
}