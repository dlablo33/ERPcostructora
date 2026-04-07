<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Plantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrestamoController extends Controller
{
    public function index()
    {
        $prestamos = Prestamo::with('empleado')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $empleados = Plantilla::activos()
            ->orderBy('nombre')
            ->orderBy('apellido_paterno')
            ->get();
        
        // Cambiado de 'nominas.prestaciones' a 'rh.prestaciones.prestamos'
        return view('rh.prestaciones.prestamos', compact('prestamos', 'empleados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'estatus' => 'required|string',
            'fecha_inicio' => 'required|date',
            'plantilla_id' => 'required|exists:plantillas,plantilla_id',
            'motivo' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
            'monto_descuento' => 'required|numeric|min:0',
            'numero_pagos' => 'required|integer|min:1',
            'frecuencia' => 'required|string',
            'monto_restante' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
            'gasto' => 'nullable|string|max:50',
        ]);

        try {
            DB::beginTransaction();
            
            $prestamo = Prestamo::create($validated);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Préstamo registrado correctamente',
                'prestamo' => $prestamo->load('empleado')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el préstamo: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $prestamo = Prestamo::findOrFail($id);
        
        $validated = $request->validate([
            'estatus' => 'required|string',
            'fecha_inicio' => 'required|date',
            'plantilla_id' => 'required|exists:plantillas,plantilla_id',
            'motivo' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
            'monto_descuento' => 'required|numeric|min:0',
            'numero_pagos' => 'required|integer|min:1',
            'frecuencia' => 'required|string',
            'monto_restante' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
            'gasto' => 'nullable|string|max:50',
        ]);

        try {
            DB::beginTransaction();
            
            $prestamo->update($validated);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Préstamo actualizado correctamente',
                'prestamo' => $prestamo->load('empleado')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el préstamo: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $prestamo = Prestamo::findOrFail($id);
            $prestamo->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Préstamo eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el préstamo: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $prestamo = Prestamo::with('empleado')->findOrFail($id);
        return response()->json($prestamo);
    }

    /**
     * Exportar préstamos a CSV
     */
    public function exportExcel()
    {
        try {
            $prestamos = Prestamo::with('empleado')
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Crear CSV manualmente
            $filename = 'prestamos_' . date('Y-m-d') . '.csv';
            $handle = fopen('php://temp', 'w+');
            
            // Agregar BOM para UTF-8
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Encabezados
            fputcsv($handle, [
                'ID', 
                'Folio', 
                'Estatus', 
                'Fecha Inicio', 
                'Empleado', 
                'Motivo', 
                'Monto', 
                'Monto Descuento', 
                'Número Pagos', 
                'Frecuencia', 
                'Monto Restante', 
                'Observaciones', 
                'Gasto', 
                'Fecha Registro'
            ]);
            
            // Datos
            foreach ($prestamos as $prestamo) {
                fputcsv($handle, [
                    $prestamo->id,
                    $prestamo->folio,
                    $prestamo->estatus,
                    $prestamo->fecha_inicio->format('d/m/Y'),
                    $prestamo->nombre_empleado,
                    $prestamo->motivo,
                    number_format($prestamo->monto, 2),
                    number_format($prestamo->monto_descuento, 2),
                    $prestamo->numero_pagos,
                    $prestamo->frecuencia,
                    number_format($prestamo->monto_restante, 2),
                    $prestamo->observaciones ?? '-',
                    $prestamo->gasto ?? '-',
                    $prestamo->created_at->format('d/m/Y H:i')
                ]);
            }
            
            rewind($handle);
            $csv = stream_get_contents($handle);
            fclose($handle);
            
            return response($csv, 200)
                ->header('Content-Type', 'text/csv; charset=UTF-8')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Pragma', 'no-cache')
                ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                ->header('Expires', '0');
                
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }
}