<?php

namespace App\Http\Controllers;

use App\Models\GastoProyecto;
use App\Models\Proyecto;
use App\Models\CategoriaGasto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GastoProyectoController extends Controller
{
    /**
     * Vista principal (para el blade)
     */
    public function vista()
    {
        return view('conta.porproyecto.asignacion');
    }

    /**
     * Display a listing of the resource (API)
     */
    public function index(Request $request)
    {
        try {
            // Obtener valores de los filtros
            $search = $request->input('search', '');
            $proyectoId = $request->input('proyecto_id', '');
            $categoriaId = $request->input('categoria_id', '');
            $estatus = $request->input('estatus', '');
            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 10);
            $sortKey = $request->input('sort_key', 'fecha');
            $sortDir = $request->input('sort_dir', 'desc');
            
            // ============================================
            // CONSULTA PRINCIPAL
            // ============================================
            $query = GastoProyecto::with(['proyecto', 'categoria', 'proveedor'])
                ->whereNull('deleted_at');
            
            // Aplicar filtros
            if (!empty($search)) {
                $query->buscar($search);
            }
            
            if (!empty($proyectoId)) {
                $query->porProyecto($proyectoId);
            }
            
            if (!empty($categoriaId)) {
                $query->porCategoria($categoriaId);
            }
            
            if (!empty($estatus)) {
                $query->porEstatus($estatus);
            }
            
            // Aplicar ordenamiento
            $sortDirSql = $sortDir === 'asc' ? 'asc' : 'desc';
            if ($sortKey === 'monto') {
                $query->orderBy('monto', $sortDirSql);
            } elseif ($sortKey === 'fecha') {
                $query->orderBy('fecha', $sortDirSql);
            } elseif ($sortKey === 'folio') {
                $query->orderBy('folio', $sortDirSql);
            } elseif ($sortKey === 'avance') {
                $query->orderBy('avance', $sortDirSql);
            } else {
                $query->orderBy('fecha', 'desc');
            }
            
            // Paginación
            $gastos = $query->paginate($perPage, ['*'], 'page', $page);
            
            // ============================================
            // KPIS (Estadísticas)
            // ============================================
            $kpis = $this->calcularKPIs($search, $proyectoId, $categoriaId, $estatus);
            
            // ============================================
            // DATOS PARA FILTROS
            // ============================================
            $proyectos = Proyecto::where('status', 'activo')
                ->orWhere('estado', 'activo')
                ->orderBy('codigo')
                ->get(['id', 'codigo', 'nombre']);
            
            $categorias = CategoriaGasto::where('activo', true)
                ->orderBy('nombre')
                ->get(['id', 'nombre']);
            
            $proveedores = Proveedor::where('activo', true)
                ->orderBy('nombre')
                ->get(['id', 'nombre']);
            
            // Transformar datos para la vista
            $gastosTransformados = $this->transformarGastos($gastos);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'gastos' => $gastosTransformados,
                    'pagination' => [
                        'current_page' => $gastos->currentPage(),
                        'per_page' => $gastos->perPage(),
                        'total' => $gastos->total(),
                        'last_page' => $gastos->lastPage(),
                        'from' => $gastos->firstItem(),
                        'to' => $gastos->lastItem()
                    ],
                    'kpis' => $kpis,
                    'filtros' => [
                        'proyectos' => $proyectos,
                        'categorias' => $categorias,
                        'proveedores' => $proveedores
                    ]
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en GastoProyectoController@index: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los gastos: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Calcular KPIs para el dashboard
     */
    private function calcularKPIs($search, $proyectoId, $categoriaId, $estatus)
    {
        $query = GastoProyecto::whereNull('deleted_at');
        
        if (!empty($search)) {
            $query->buscar($search);
        }
        
        if (!empty($proyectoId)) {
            $query->porProyecto($proyectoId);
        }
        
        if (!empty($categoriaId)) {
            $query->porCategoria($categoriaId);
        }
        
        if (!empty($estatus)) {
            $query->porEstatus($estatus);
        }
        
        $total = $query->sum('monto');
        
        // Gastos por estatus
        $aprobados = GastoProyecto::whereNull('deleted_at')
            ->when(!empty($search), fn($q) => $q->buscar($search))
            ->when(!empty($proyectoId), fn($q) => $q->porProyecto($proyectoId))
            ->when(!empty($categoriaId), fn($q) => $q->porCategoria($categoriaId))
            ->where('estatus', 'Aprobado')
            ->sum('monto');
        
        $pendientes = GastoProyecto::whereNull('deleted_at')
            ->when(!empty($search), fn($q) => $q->buscar($search))
            ->when(!empty($proyectoId), fn($q) => $q->porProyecto($proyectoId))
            ->when(!empty($categoriaId), fn($q) => $q->porCategoria($categoriaId))
            ->whereIn('estatus', ['Pendiente', 'En revisión'])
            ->sum('monto');
        
        // Proyectos activos con gastos
        $proyectosActivos = GastoProyecto::whereNull('deleted_at')
            ->when(!empty($search), fn($q) => $q->buscar($search))
            ->distinct('proyecto_id')
            ->count('proyecto_id');
        
        return [
            'total' => $total,
            'total_formateado' => '$' . number_format($total, 2),
            'aprobados' => $aprobados,
            'aprobados_formateado' => '$' . number_format($aprobados, 2),
            'pendientes' => $pendientes,
            'pendientes_formateado' => '$' . number_format($pendientes, 2),
            'proyectos_activos' => $proyectosActivos
        ];
    }
    
    /**
     * Transformar gastos para la vista
     */
    private function transformarGastos($gastos)
    {
        return $gastos->map(function($gasto) {
            return [
                'id' => $gasto->id,
                'folio' => $gasto->folio,
                'fecha' => $gasto->fecha ? $gasto->fecha->format('Y-m-d') : date('Y-m-d'),
                'fecha_lista' => $gasto->fecha_lista,
                'proyecto_id' => $gasto->proyecto_id,
                'proyecto_codigo' => $gasto->proyecto_codigo,
                'proyecto_nombre' => $gasto->proyecto_nombre,
                'proyecto_color' => $gasto->proyecto_color,
                'categoria' => $gasto->categoria_nombre,
                'categoria_grupo' => $gasto->categoria_grupo,
                'proveedor' => $gasto->proveedor_nombre,
                'monto' => $gasto->monto,
                'monto_formateado' => $gasto->monto_formateado,
                'partida' => $gasto->partida ?? '—',
                'tipo_documento' => $gasto->tipo_documento ?? 'Factura',
                'estatus' => $gasto->estatus,
                'badge_class' => $gasto->badge_class,
                'avance' => $gasto->avance,
                'progress_class' => $gasto->progress_class,
                'notas' => $gasto->notas ?? ''
            ];
        });
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'proyecto_id' => 'required|exists:proyectos,id',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0.01',
            'categoria' => 'nullable|string',
            'proveedor' => 'nullable|string|max:200',
            'partida' => 'nullable|string|max:50',
            'tipo_documento' => 'nullable|string|max:50',
            'estatus' => 'nullable|string|in:Pendiente,Aprobado,Rechazado,En revisión',
            'avance' => 'nullable|integer|min:0|max:100',
            'notas' => 'nullable|string'
        ]);
        
        // Buscar categoría existente por nombre (no crear nuevas)
        $categoriaId = null;
        if (!empty($validated['categoria'])) {
            $categoria = DB::table('categorias_gastos')
                ->where('nombre', $validated['categoria'])
                ->first();
            
            if ($categoria) {
                $categoriaId = $categoria->id;
            }
            // Si no existe, no crear una nueva - dejar como null
        }
        
        // Buscar o crear proveedor (esto está bien)
        $proveedorId = null;
        if (!empty($validated['proveedor'])) {
            $proveedor = Proveedor::firstOrCreate(
                ['nombre' => $validated['proveedor']],
                ['activo' => true]
            );
            $proveedorId = $proveedor->id;
        }
        
        // Generar folio automático
        $folio = GastoProyecto::generarFolio();
        
        // Crear el gasto
        $gasto = GastoProyecto::create([
            'folio' => $folio,
            'fecha' => $validated['fecha'],
            'proyecto_id' => $validated['proyecto_id'],
            'categoria_id' => $categoriaId,
            'proveedor_id' => $proveedorId,
            'monto' => $validated['monto'],
            'partida' => $validated['partida'] ?? null,
            'tipo_documento' => $validated['tipo_documento'] ?? 'Factura',
            'estatus' => $validated['estatus'] ?? 'Pendiente',
            'avance' => $validated['avance'] ?? 0,
            'notas' => $validated['notas'] ?? null,
            'created_by' => auth()->id()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Gasto registrado correctamente',
            'data' => $gasto
        ]);
        
    } catch (\Exception $e) {
        Log::error('Error en GastoProyectoController@store: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error al registrar el gasto: ' . $e->getMessage()
        ], 500);
    }
}
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $gasto = GastoProyecto::with(['proyecto', 'categoria', 'proveedor'])
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $gasto->id,
                    'folio' => $gasto->folio,
                    'fecha' => $gasto->fecha->format('Y-m-d'),
                    'fecha_formateada' => $gasto->fecha_formateada,
                    'proyecto_id' => $gasto->proyecto_id,
                    'proyecto_codigo' => $gasto->proyecto_codigo,
                    'proyecto_nombre' => $gasto->proyecto_nombre,
                    'categoria' => $gasto->categoria_nombre,
                    'proveedor' => $gasto->proveedor_nombre,
                    'monto' => $gasto->monto,
                    'monto_formateado' => $gasto->monto_formateado,
                    'partida' => $gasto->partida,
                    'tipo_documento' => $gasto->tipo_documento,
                    'estatus' => $gasto->estatus,
                    'avance' => $gasto->avance,
                    'notas' => $gasto->notas,
                    'created_at' => $gasto->created_at->format('d/m/Y H:i:s')
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gasto no encontrado'
            ], 404);
        }
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $gasto = GastoProyecto::findOrFail($id);
            
            $validated = $request->validate([
                'fecha' => 'sometimes|required|date',
                'monto' => 'sometimes|required|numeric|min:0.01',
                'categoria' => 'nullable|string',
                'proveedor' => 'nullable|string|max:200',
                'partida' => 'nullable|string|max:50',
                'tipo_documento' => 'nullable|string|max:50',
                'estatus' => 'nullable|string|in:Pendiente,Aprobado,Rechazado,En revisión',
                'avance' => 'nullable|integer|min:0|max:100',
                'notas' => 'nullable|string'
            ]);
            
            // Actualizar categoría si es necesario
            if (isset($validated['categoria']) && !empty($validated['categoria'])) {
                $categoria = CategoriaGasto::firstOrCreate(
                    ['nombre' => $validated['categoria']],
                    ['activo' => true]
                );
                $gasto->categoria_id = $categoria->id;
            }
            
            // Actualizar proveedor si es necesario
            if (isset($validated['proveedor']) && !empty($validated['proveedor'])) {
                $proveedor = Proveedor::firstOrCreate(
                    ['nombre' => $validated['proveedor']],
                    ['activo' => true]
                );
                $gasto->proveedor_id = $proveedor->id;
            }
            
            $gasto->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Gasto actualizado correctamente'
            ]);
            
        } catch (\Exception $e) {
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
        try {
            $gasto = GastoProyecto::findOrFail($id);
            $gasto->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Gasto eliminado correctamente'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener KPIs en tiempo real para AJAX
     */
    public function getKPIs(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $proyectoId = $request->input('proyecto_id', '');
            $categoriaId = $request->input('categoria_id', '');
            $estatus = $request->input('estatus', '');
            
            $kpis = $this->calcularKPIs($search, $proyectoId, $categoriaId, $estatus);
            
            return response()->json([
                'success' => true,
                'data' => $kpis
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Exportar a Excel
     */
    public function exportarExcel(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $proyectoId = $request->input('proyecto_id', '');
            $categoriaId = $request->input('categoria_id', '');
            $estatus = $request->input('estatus', '');
            
            $query = GastoProyecto::with(['proyecto', 'categoria'])
                ->whereNull('deleted_at');
            
            if (!empty($search)) {
                $query->buscar($search);
            }
            
            if (!empty($proyectoId)) {
                $query->porProyecto($proyectoId);
            }
            
            if (!empty($categoriaId)) {
                $query->porCategoria($categoriaId);
            }
            
            if (!empty($estatus)) {
                $query->porEstatus($estatus);
            }
            
            $gastos = $query->orderBy('fecha', 'desc')->get();
            
            $html = $this->generarExcel($gastos);
            
            return response($html)
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename="gastos_proyecto_' . date('Y-m-d') . '.xls"');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al exportar: ' . $e->getMessage()]);
        }
    }
    
    private function generarExcel($gastos)
    {
        $total = $gastos->sum('monto');
        
        $html = '<html><head><meta charset="UTF-8"><title>Gastos por Proyecto</title>
        <style>th{background:#083CAE;color:white;padding:8px;}td{padding:6px;border:1px solid #ddd;}</style>
        </head><body>
        <h2>Asignación de Gastos por Proyecto</h2>
        <p>Generado: ' . date('d/m/Y H:i:s') . '</p>
        <table border="1"><thead><tr>
            <th>Folio</th><th>Fecha</th><th>Proyecto</th><th>Categoría</th>
            <th>Proveedor</th><th>Monto</th><th>Estatus</th><th>Avance</th>
        </tr></thead><tbody>';
        
        foreach ($gastos as $g) {
            $html .= '<tr>
                <td>' . e($g->folio) . '</td>
                <td>' . ($g->fecha ? $g->fecha->format('d/m/Y') : '-') . '</td>
                <td>' . e($g->proyecto_codigo) . ' - ' . e($g->proyecto_nombre) . '</td>
                <td>' . e($g->categoria_nombre) . '</td>
                <td>' . e($g->proveedor_nombre) . '</td>
                <td class="text-right">$' . number_format($g->monto, 2) . '</td>
                <td>' . e($g->estatus) . '</td>
                <td class="text-center">' . $g->avance . '%</td>
            </td>';
        }
        
        $html .= '</tbody><tfoot><tr>
            <td colspan="5"><strong>TOTAL</strong></td>
            <td class="text-right"><strong>$' . number_format($total, 2) . '</strong></td>
            <td colspan="2"></td>
        </tr></tfoot></table></body></html>';
        
        return $html;
    }
    
    /**
     * Método de prueba para verificar que el controlador funciona
     */
    public function test()
    {
        try {
            $tableExists = \Illuminate\Support\Facades\Schema::hasTable('gastos_proyecto');
            $count = $tableExists ? GastoProyecto::count() : 0;
            
            return response()->json([
                'success' => true,
                'message' => 'API funcionando correctamente',
                'table_exists' => $tableExists,
                'records_count' => $count,
                'timestamp' => now()->toDateTimeString()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}