<?php

namespace App\Http\Controllers;

use App\Models\TablaSueldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TablaSueldoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TablaSueldo::query();
        
        // Búsqueda
        if ($request->has('search') && $request->search) {
            $query->buscar($request->search);
        }
        
        // Filtro por estatus
        if ($request->has('estatus') && $request->estatus) {
            $query->where('estatus', $request->estatus);
        }
        
        // Ordenamiento
        $sortField = $request->get('sort_field', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $tablaSueldos = $query->paginate(15);
        
        // Para el select de estatus en el filtro
        $estatusOptions = ['Activo', 'Pendiente', 'Cancelado', 'Finalizado'];
        
        if ($request->ajax()) {
            return response()->json([
                'data' => $tablaSueldos->items(),
                'total' => $tablaSueldos->total(),
                'current_page' => $tablaSueldos->currentPage(),
                'last_page' => $tablaSueldos->lastPage(),
            ]);
        }
        
        // Retornar la vista correcta
        return view('rh.nomina.sueldos', compact('tablaSueldos', 'estatusOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'folio' => 'required|string|max:50|unique:tabla_sueldos,folio',
            'fecha_ejecuto' => 'required|date',
            'fecha_inicial' => 'required|date|before_or_equal:fecha_final',
            'fecha_final' => 'required|date|after_or_equal:fecha_inicial',
            'cantidad_registros' => 'required|integer|min:0',
            'monto' => 'required|numeric|min:0',
            'estatus' => 'required|in:Activo,Pendiente,Cancelado,Finalizado',
            'observaciones' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();
            
            $tablaSueldo = TablaSueldo::create([
                'folio' => $request->folio,
                'fecha_ejecuto' => $request->fecha_ejecuto,
                'fecha_inicial' => $request->fecha_inicial,
                'fecha_final' => $request->fecha_final,
                'cantidad_registros' => $request->cantidad_registros,
                'monto' => $request->monto,
                'estatus' => $request->estatus,
                'observaciones' => $request->observaciones,
                'created_by' => auth()->id(),
            ]);
            
            DB::commit();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tabla de sueldos creada exitosamente',
                    'data' => $tablaSueldo
                ]);
            }
            
            return redirect()->route('rh.nomina.sueldos')
                ->with('success', 'Tabla de sueldos creada exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al crear: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tablaSueldo = TablaSueldo::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $tablaSueldo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tablaSueldo = TablaSueldo::findOrFail($id);
        
        $request->validate([
            'folio' => 'required|string|max:50|unique:tabla_sueldos,folio,' . $id,
            'fecha_ejecuto' => 'required|date',
            'fecha_inicial' => 'required|date|before_or_equal:fecha_final',
            'fecha_final' => 'required|date|after_or_equal:fecha_inicial',
            'cantidad_registros' => 'required|integer|min:0',
            'monto' => 'required|numeric|min:0',
            'estatus' => 'required|in:Activo,Pendiente,Cancelado,Finalizado',
            'observaciones' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();
            
            $tablaSueldo->update([
                'folio' => $request->folio,
                'fecha_ejecuto' => $request->fecha_ejecuto,
                'fecha_inicial' => $request->fecha_inicial,
                'fecha_final' => $request->fecha_final,
                'cantidad_registros' => $request->cantidad_registros,
                'monto' => $request->monto,
                'estatus' => $request->estatus,
                'observaciones' => $request->observaciones,
            ]);
            
            DB::commit();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tabla de sueldos actualizada exitosamente',
                    'data' => $tablaSueldo
                ]);
            }
            
            return redirect()->route('rh.nomina.sueldos')
                ->with('success', 'Tabla de sueldos actualizada exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $tablaSueldo = TablaSueldo::findOrFail($id);
            $tablaSueldo->delete();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Registro eliminado exitosamente'
                ]);
            }
            
            return redirect()->route('rh.nomina.sueldos')
                ->with('success', 'Registro eliminado exitosamente');
                
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }

    /**
     * Export to Excel
     */
    public function export(Request $request)
    {
        $query = TablaSueldo::query();
        
        if ($request->has('search') && $request->search) {
            $query->buscar($request->search);
        }
        
        $tablaSueldos = $query->get();
        
        // Aquí implementarías la exportación a Excel
        return response()->json([
            'success' => true,
            'data' => $tablaSueldos,
            'message' => 'Exportación preparada'
        ]);
    }
}