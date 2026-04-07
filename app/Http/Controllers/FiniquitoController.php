<?php

namespace App\Http\Controllers;

use App\Models\Finiquito;
use App\Models\Plantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FiniquitoController extends Controller
{
   public function index()
{
    $finiquitos = Finiquito::with('empleado')
        ->orderBy('created_at', 'desc')
        ->get();
    
    $empleados = Plantilla::activos()
        ->orderBy('nombre')
        ->orderBy('apellido_paterno')
        ->get();
    
    // Calcular KPIs
    $totalProcesos = $finiquitos->count();
    $pendientes = $finiquitos->where('estatus', 'Pendiente')->count();
    $autorizados = $finiquitos->where('estatus', 'Autorizado')->count();
    $pagados = $finiquitos->where('estatus', 'Pagado')->count();
    
    // CAMBIA ESTA LÍNEA de 'rh.prestaciones.finiquito' a 'rh.prestaciones.finequito'
    return view('rh.prestaciones.finequito', compact('finiquitos', 'empleados', 'totalProcesos', 'pendientes', 'autorizados', 'pagados'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plantilla_id' => 'required|exists:plantillas,plantilla_id',
            'tipo' => 'required|in:finiquito,liquidacion',
            'fecha_baja' => 'required|date',
            'fecha_ingreso' => 'required|date|before:fecha_baja',
            'salario_diario' => 'required|numeric|min:0',
            'salario_integrado' => 'required|numeric|min:0',
            'dias_vacaciones' => 'required|integer|min:0',
            'prima_vacacional' => 'required|numeric|min:0',
            'aguinaldo' => 'required|numeric|min:0',
            'indemnizacion' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
            'motivo_baja' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();
            
            $finiquito = Finiquito::create($validated);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Finiquito/Liquidación registrado correctamente',
                'finiquito' => $finiquito->load('empleado')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $finiquito = Finiquito::findOrFail($id);
        
        $validated = $request->validate([
            'plantilla_id' => 'required|exists:plantillas,plantilla_id',
            'tipo' => 'required|in:finiquito,liquidacion',
            'fecha_baja' => 'required|date',
            'fecha_ingreso' => 'required|date|before:fecha_baja',
            'salario_diario' => 'required|numeric|min:0',
            'salario_integrado' => 'required|numeric|min:0',
            'dias_vacaciones' => 'required|integer|min:0',
            'prima_vacacional' => 'required|numeric|min:0',
            'aguinaldo' => 'required|numeric|min:0',
            'indemnizacion' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
            'motivo_baja' => 'nullable|string',
            'estatus' => 'sometimes|required|in:Pendiente,Autorizado,Pagado,Cancelado',
        ]);

        try {
            DB::beginTransaction();
            
            $finiquito->update($validated);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Finiquito/Liquidación actualizado correctamente',
                'finiquito' => $finiquito->load('empleado')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $finiquito = Finiquito::findOrFail($id);
            $finiquito->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Finiquito/Liquidación eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $finiquito = Finiquito::with('empleado')->findOrFail($id);
        return response()->json($finiquito);
    }

    public function autorizar($id)
    {
        try {
            $finiquito = Finiquito::findOrFail($id);
            $finiquito->update([
                'estatus' => 'Autorizado',
                'usuario_autorizo' => auth()->user()->name ?? 'Sistema',
                'fecha_autorizacion' => now(),
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Finiquito autorizado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al autorizar: ' . $e->getMessage()
            ], 500);
        }
    }

    public function registrarPago(Request $request, $id)
    {
        $request->validate([
            'fecha_pago' => 'required|date',
        ]);
        
        try {
            $finiquito = Finiquito::findOrFail($id);
            $finiquito->update([
                'estatus' => 'Pagado',
                'fecha_pago' => $request->fecha_pago,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Pago registrado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar pago: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportExcel()
    {
        try {
            $finiquitos = Finiquito::with('empleado')
                ->orderBy('created_at', 'desc')
                ->get();
            
            $filename = 'finiquitos_' . date('Y-m-d') . '.csv';
            $handle = fopen('php://temp', 'w+');
            
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($handle, [
                'ID', 'Folio', 'Empleado', 'RFC', 'Tipo', 'Fecha Baja', 'Antigüedad',
                'Días Vac.', 'Prima Vac.', 'Aguinaldo', 'Indemnización', 'Total',
                'Estatus', 'Motivo Baja', 'Fecha Pago', 'Fecha Registro'
            ]);
            
            foreach ($finiquitos as $finiquito) {
                fputcsv($handle, [
                    $finiquito->id,
                    $finiquito->folio,
                    $finiquito->nombre_empleado,
                    $finiquito->rfc,
                    $finiquito->tipo == 'finiquito' ? 'Finiquito' : 'Liquidación',
                    $finiquito->fecha_baja->format('d/m/Y'),
                    $finiquito->antiguedad,
                    $finiquito->dias_vacaciones,
                    number_format($finiquito->prima_vacacional, 2),
                    number_format($finiquito->aguinaldo, 2),
                    number_format($finiquito->indemnizacion, 2),
                    number_format($finiquito->total, 2),
                    $finiquito->estatus,
                    $finiquito->motivo_baja ?? '-',
                    $finiquito->fecha_pago ? $finiquito->fecha_pago->format('d/m/Y') : '-',
                    $finiquito->created_at->format('d/m/Y H:i')
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