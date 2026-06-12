<?php

namespace App\Http\Controllers;

use App\Models\ComplementoPago;
use App\Models\Facturacion\Contacto;
use App\Models\Pago;
use App\Models\Contrarecibo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ComplementoPagoController extends Controller
{
    /**
     * Vista principal (para el blade)
     */
    public function vista()
    {
        return view('conta.fiscal.complementos');
    }

    /**
     * Display a listing of the resource (API)
     */
    public function index(Request $request)
    {
        try {
            // Obtener valores de los filtros
            $search = $request->input('search', '');
            $fechaInicio = $request->input('fecha_inicio', date('Y-m-01'));
            $fechaFin = $request->input('fecha_fin', date('Y-m-t'));
            $estatus = $request->input('estatus', '');
            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 10);
            $sortKey = $request->input('sort_key', 'fecha_pago');
            $sortDir = $request->input('sort_dir', 'desc');
            
            // ============================================
            // CONSULTA PRINCIPAL
            // ============================================
            $query = ComplementoPago::with(['cliente', 'cfdi', 'pago', 'contrarecibo'])
                ->whereNull('deleted_at');
            
            // Aplicar filtros
            if (!empty($search)) {
                $query->buscar($search);
            }
            
            if (!empty($fechaInicio) && !empty($fechaFin)) {
                $query->entreFechas($fechaInicio, $fechaFin);
            }
            
            if (!empty($estatus)) {
                $query->porEstatus($estatus);
            }
            
            // Aplicar ordenamiento
            $sortDirSql = $sortDir === 'asc' ? 'asc' : 'desc';
            if ($sortKey === 'monto') {
                $query->orderBy('monto', $sortDirSql);
            } elseif ($sortKey === 'fecha_pago') {
                $query->orderBy('fecha_pago', $sortDirSql);
            } elseif ($sortKey === 'folio') {
                $query->orderBy('folio', $sortDirSql);
            } else {
                $query->orderBy('fecha_pago', 'desc');
            }
            
            // Paginación
            $complementos = $query->paginate($perPage, ['*'], 'page', $page);
            
            // ============================================
            // ESTADÍSTICAS (KPIs)
            // ============================================
            $kpis = $this->calcularKPIs($search, $fechaInicio, $fechaFin, $estatus);
            
            // Transformar datos para la vista
            $complementosTransformados = $this->transformarComplementos($complementos);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'complementos' => $complementosTransformados,
                    'pagination' => [
                        'current_page' => $complementos->currentPage(),
                        'per_page' => $complementos->perPage(),
                        'total' => $complementos->total(),
                        'last_page' => $complementos->lastPage(),
                        'from' => $complementos->firstItem(),
                        'to' => $complementos->lastItem()
                    ],
                    'kpis' => $kpis
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en ComplementoPagoController@index: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los complementos: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Calcular KPIs para el dashboard
     */
    private function calcularKPIs($search, $fechaInicio, $fechaFin, $estatus)
    {
        $query = ComplementoPago::whereNull('deleted_at');
        
        if (!empty($search)) {
            $query->buscar($search);
        }
        
        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $query->entreFechas($fechaInicio, $fechaFin);
        }
        
        if (!empty($estatus)) {
            $query->porEstatus($estatus);
        }
        
        $total = $query->count();
        $montoTotal = $query->sum('monto');
        
        // Complementos por estatus
        $porTimbrar = ComplementoPago::whereNull('deleted_at')
            ->when(!empty($search), fn($q) => $q->buscar($search))
            ->when(!empty($fechaInicio) && !empty($fechaFin), fn($q) => $q->entreFechas($fechaInicio, $fechaFin))
            ->where('estatus', 'Pendiente')
            ->count();
        
        $timbrados = ComplementoPago::whereNull('deleted_at')
            ->when(!empty($search), fn($q) => $q->buscar($search))
            ->when(!empty($fechaInicio) && !empty($fechaFin), fn($q) => $q->entreFechas($fechaInicio, $fechaFin))
            ->where('estatus', 'Timbrado')
            ->count();
        
        return [
            'total' => $total,
            'total_formateado' => number_format($total, 0),
            'monto_total' => $montoTotal,
            'monto_total_formateado' => '$' . number_format($montoTotal, 2),
            'por_timbrar' => $porTimbrar,
            'timbrados' => $timbrados,
            'cancelados' => $total - $porTimbrar - $timbrados
        ];
    }
    
    /**
     * Transformar complementos para la vista
     */
    private function transformarComplementos($complementos)
    {
        return $complementos->map(function($complemento) {
            return [
                'id' => $complemento->id,
                'folio' => $complemento->folio,
                'cliente' => $complemento->cliente_nombre,
                'rfc' => $complemento->rfc ?? ($complemento->cliente ? $complemento->cliente->rfc : '-'),
                'fecha_pago' => $complemento->fecha_pago ? $complemento->fecha_pago->format('Y-m-d') : date('Y-m-d'),
                'fecha_lista' => $complemento->fecha_lista,
                'documento_relacionado' => $complemento->documento_relacionado ?? '-',
                'forma_pago' => $complemento->forma_pago ?? 'Transferencia',
                'monto' => $complemento->monto,
                'monto_formateado' => $complemento->monto_formateado,
                'estatus' => $complemento->estatus,
                'badge_class' => $complemento->badge_class,
                'uuid' => $complemento->uuid ?? '-',
                'cfdi_id' => $complemento->cfdi_id,
                'pago_id' => $complemento->pago_id,
                'contrarecibo_id' => $complemento->contrarecibo_id
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
                'cliente_id' => 'required|exists:contactos,contacto_id',
                'fecha_pago' => 'required|date',
                'monto' => 'required|numeric|min:0.01',
                'documento_relacionado' => 'nullable|string|max:50',
                'forma_pago' => 'nullable|string|max:50'
            ]);
            
            // Generar folio automático
            $folio = ComplementoPago::generarFolio();
            
            // Obtener RFC del cliente usando DB::table
            $cliente = DB::table('contactos')
                ->where('contacto_id', $validated['cliente_id'])
                ->first();
            $rfc = $cliente ? $cliente->rfc : null;
            
            // Crear el complemento
            $complemento = ComplementoPago::create([
                'folio' => $folio,
                'cliente_id' => $validated['cliente_id'],
                'rfc' => $rfc,
                'fecha_pago' => $validated['fecha_pago'],
                'documento_relacionado' => $validated['documento_relacionado'] ?? null,
                'forma_pago' => $validated['forma_pago'] ?? 'Transferencia',
                'monto' => $validated['monto'],
                'estatus' => 'Pendiente',
                'created_by' => auth()->id()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Complemento de pago registrado correctamente',
                'data' => $complemento
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en ComplementoPagoController@store: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el complemento: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $complemento = ComplementoPago::with(['cliente', 'cfdi', 'pago', 'contrarecibo'])
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $complemento->id,
                    'folio' => $complemento->folio,
                    'cliente_id' => $complemento->cliente_id,
                    'cliente_nombre' => $complemento->cliente_nombre,
                    'rfc' => $complemento->rfc,
                    'fecha_pago' => $complemento->fecha_pago->format('Y-m-d'),
                    'fecha_formateada' => $complemento->fecha_pago_formateada,
                    'documento_relacionado' => $complemento->documento_relacionado,
                    'forma_pago' => $complemento->forma_pago,
                    'monto' => $complemento->monto,
                    'monto_formateado' => $complemento->monto_formateado,
                    'estatus' => $complemento->estatus,
                    'uuid' => $complemento->uuid,
                    'cfdi_id' => $complemento->cfdi_id,
                    'created_at' => $complemento->created_at->format('d/m/Y H:i:s')
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Complemento no encontrado'
            ], 404);
        }
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $complemento = ComplementoPago::findOrFail($id);
            
            $validated = $request->validate([
                'fecha_pago' => 'sometimes|required|date',
                'monto' => 'sometimes|required|numeric|min:0.01',
                'documento_relacionado' => 'nullable|string|max:50',
                'forma_pago' => 'nullable|string|max:50'
            ]);
            
            $complemento->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Complemento actualizado correctamente'
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
            $complemento = ComplementoPago::findOrFail($id);
            
            // Solo se puede eliminar si está pendiente
            if ($complemento->estatus !== 'Pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar un complemento timbrado o cancelado'
                ], 400);
            }
            
            $complemento->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Complemento eliminado correctamente'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Timbrar complemento de pago
     */
    public function timbrar($id)
    {
        try {
            $complemento = ComplementoPago::findOrFail($id);
            
            if ($complemento->estatus !== 'Pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'El complemento ya está timbrado o cancelado'
                ], 400);
            }
            
            // Simular timbrado (aquí iría la integración con PAC)
            $uuid = 'TMP-' . strtoupper(uniqid()) . '-' . date('YmdHis');
            
            // Actualizar el complemento
            $complemento->asignarUuid($uuid);
            
            return response()->json([
                'success' => true,
                'message' => 'Complemento timbrado correctamente',
                'data' => [
                    'uuid' => $uuid,
                    'estatus' => 'Timbrado'
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al timbrar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Cancelar complemento de pago
     */
    public function cancelar($id)
    {
        try {
            $complemento = ComplementoPago::findOrFail($id);
            
            if ($complemento->estatus !== 'Timbrado') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden cancelar complementos timbrados'
                ], 400);
            }
            
            $complemento->cancelar();
            
            return response()->json([
                'success' => true,
                'message' => 'Complemento cancelado correctamente'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cancelar: ' . $e->getMessage()
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
            $fechaInicio = $request->input('fecha_inicio', date('Y-m-01'));
            $fechaFin = $request->input('fecha_fin', date('Y-m-t'));
            $estatus = $request->input('estatus', '');
            
            $kpis = $this->calcularKPIs($search, $fechaInicio, $fechaFin, $estatus);
            
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
     * Obtener clientes para el select
     */
    /**
 * Obtener clientes para el select
 */
public function getClientes(Request $request)
{
    try {
        $search = $request->input('search', '');
        
        // Consulta para obtener contactos que sean clientes
        $query = DB::table('contactos')
            ->select('contacto_id as id', 'razon_social', 'rfc')
            ->where('estatus', true)
            ->where(function($q) {
                $q->where('tipo', 'cliente')
                  ->orWhere('tipo', 'ambos');
            })
            ->whereNull('deleted_at');
        
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('razon_social', 'LIKE', "%{$search}%")
                  ->orWhere('rfc', 'LIKE', "%{$search}%");
            });
        }
        
        $clientes = $query->orderBy('razon_social')
            ->limit(50)
            ->get();
        
        \Log::info('Clientes encontrados: ' . $clientes->count());
        
        return response()->json([
            'success' => true,
            'data' => $clientes
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error en getClientes: ' . $e->getMessage());
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
            $fechaInicio = $request->input('fecha_inicio', date('Y-m-01'));
            $fechaFin = $request->input('fecha_fin', date('Y-m-t'));
            $estatus = $request->input('estatus', '');
            
            $query = ComplementoPago::with(['cliente'])
                ->whereNull('deleted_at');
            
            if (!empty($search)) {
                $query->buscar($search);
            }
            
            if (!empty($fechaInicio) && !empty($fechaFin)) {
                $query->entreFechas($fechaInicio, $fechaFin);
            }
            
            if (!empty($estatus)) {
                $query->porEstatus($estatus);
            }
            
            $complementos = $query->orderBy('fecha_pago', 'desc')->get();
            
            $html = $this->generarExcel($complementos);
            
            return response($html)
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename="complementos_pago_' . date('Y-m-d') . '.xls"');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al exportar: ' . $e->getMessage()]);
        }
    }
    
    private function generarExcel($complementos)
    {
        $total = $complementos->sum('monto');
        
        $html = '<html><head><meta charset="UTF-8"><title>Complementos de Pago</title>
        <style>th{background:#083CAE;color:white;padding:8px;}td{padding:6px;border:1px solid #ddd;}</style>
        </head><body>
        <h2>Complementos de Pago</h2>
        <p>Generado: ' . date('d/m/Y H:i:s') . '</p>
        <table border="1"><thead><tr>
            <th>Folio</th><th>Cliente</th><th>RFC</th><th>Fecha Pago</th>
            <th>Documento Relacionado</th><th>Forma Pago</th><th>Monto</th><th>Estado</th><th>UUID</th>
        </tr></thead><tbody>';
        
        foreach ($complementos as $c) {
            $clienteNombre = $c->cliente ? $c->cliente->razon_social : '-';
            $html .= '<tr>
                <td>' . e($c->folio) . '</td>
                <td>' . e($clienteNombre) . '</td>
                <td>' . e($c->rfc ?? '-') . '</td>
                <td>' . ($c->fecha_pago ? $c->fecha_pago->format('d/m/Y') : '-') . '</td>
                <td>' . e($c->documento_relacionado ?? '-') . '</td>
                <td>' . e($c->forma_pago ?? '-') . '</td>
                <td class="text-right">$' . number_format($c->monto, 2) . '</td>
                <td>' . e($c->estatus) . '</td>
                <td>' . e($c->uuid ?? '-') . '</td>
            <td>';
        }
        
        $html .= '</tbody><tfoot><tr>
            <td colspan="6"><strong>TOTAL</strong></td>
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
            $tableExists = \Illuminate\Support\Facades\Schema::hasTable('complementos_pago');
            $count = $tableExists ? ComplementoPago::count() : 0;
            
            return response()->json([
                'success' => true,
                'message' => 'API Complementos de Pago funcionando correctamente',
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