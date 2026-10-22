<?php

namespace App\Http\Controllers;

use App\Models\GastoIndirecto;
use App\Models\Proyecto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GastoIndirectoController extends Controller
{
    /**
     * Vista principal (para el blade)
     */
    public function vista()
    {
        return view('conta.porproyecto.gastos');
    }

    /**
     * Display a listing of the resource (API)
     */
    public function index(Request $request)
    {
        try {
            $search      = $request->input('search', '');
            $proyectoId  = $request->input('proyecto_id', '');
            $tipoGasto   = $request->input('tipo_gasto', '');
            $proveedorId = $request->input('proveedor_id', '');
            $page        = $request->input('page', 1);
            $perPage     = $request->input('per_page', 10);
            $sortKey     = $request->input('sort_key', 'fecha');
            $sortDir     = $request->input('sort_dir', 'desc');

            // ============================================
            // CONSULTA PRINCIPAL
            // ============================================
            $query = GastoIndirecto::with(['proyecto', 'proveedor'])
                ->whereNull('deleted_at');

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('folio', 'LIKE', "%{$search}%")
                      ->orWhere('concepto', 'LIKE', "%{$search}%")
                      ->orWhereHas('proveedor', function ($pq) use ($search) {
                          $pq->where('nombre', 'LIKE', "%{$search}%")
                             ->orWhere('razon_social', 'LIKE', "%{$search}%");
                      });
                });
            }

            if (!empty($proyectoId)) {
                $query->where('proyecto_id', $proyectoId);
            }

            if (!empty($tipoGasto)) {
                $query->where('partida', $tipoGasto);
            }

            if (!empty($proveedorId)) {
                $query->where('proveedor_id', $proveedorId);
            }

            // Ordenamiento
            $sortDirSql = $sortDir === 'asc' ? 'asc' : 'desc';
            if ($sortKey === 'monto') {
                $query->orderBy('monto', $sortDirSql);
            } elseif ($sortKey === 'fecha') {
                $query->orderBy('fecha', $sortDirSql);
            } elseif ($sortKey === 'folio') {
                $query->orderBy('folio', $sortDirSql);
            } else {
                $query->orderBy('fecha', 'desc');
            }

            $gastos = $query->paginate($perPage, ['*'], 'page', $page);

            $kpis = $this->calcularKPIs($search, $proyectoId, $tipoGasto, $proveedorId);

            // ============================================
            // DATOS PARA FILTROS  (incluye PROVEEDORES)
            // ============================================
            $proyectos = Proyecto::where('status', 'activo')
                ->orWhere('estado', 'activo')
                ->orderBy('codigo')
                ->get(['id', 'codigo', 'nombre']);

            $tiposGasto = GastoIndirecto::whereNotNull('partida')
                ->distinct()
                ->pluck('partida');

            // 👇 NUEVO: lista de proveedores para el selector del formulario
            $proveedores = Proveedor::orderBy('nombre')
                ->get(['id', 'nombre', 'razon_social', 'rfc']);

            $gastosTransformados = $this->transformarGastos($gastos);

            return response()->json([
                'success' => true,
                'data' => [
                    'gastos' => $gastosTransformados,
                    'pagination' => [
                        'current_page' => $gastos->currentPage(),
                        'per_page'     => $gastos->perPage(),
                        'total'        => $gastos->total(),
                        'last_page'    => $gastos->lastPage(),
                        'from'         => $gastos->firstItem(),
                        'to'           => $gastos->lastItem(),
                    ],
                    'kpis' => $kpis,
                    'filtros' => [
                        'proyectos'   => $proyectos,
                        'tipos_gasto' => $tiposGasto,
                        'proveedores' => $proveedores, // 👈 nuevo
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Error en GastoIndirectoController@index: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los gastos indirectos: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Calcular KPIs para el dashboard
     */
    private function calcularKPIs($search, $proyectoId, $tipoGasto, $proveedorId = null)
    {
        $base = function () use ($search, $proyectoId, $proveedorId) {
            $q = GastoIndirecto::whereNull('deleted_at');

            if (!empty($search)) {
                $q->where(function ($sq) use ($search) {
                    $sq->where('folio', 'LIKE', "%{$search}%")
                       ->orWhere('concepto', 'LIKE', "%{$search}%")
                       ->orWhereHas('proveedor', function ($pq) use ($search) {
                           $pq->where('nombre', 'LIKE', "%{$search}%")
                              ->orWhere('razon_social', 'LIKE', "%{$search}%");
                       });
                });
            }

            if (!empty($proyectoId)) {
                $q->where('proyecto_id', $proyectoId);
            }

            if (!empty($proveedorId)) {
                $q->where('proveedor_id', $proveedorId);
            }

            return $q;
        };

        $totalQuery = $base();
        if (!empty($tipoGasto)) {
            $totalQuery->where('partida', $tipoGasto);
        }
        $total = $totalQuery->sum('monto');

        $administrativos = $base()->where('partida', 'ADMIN01')->sum('monto');
        $servicios      = $base()->where('partida', 'SER01')->sum('monto');

        return [
            'total'                      => $total,
            'total_formateado'           => '$' . number_format($total, 2),
            'administrativos'            => $administrativos,
            'administrativos_formateado' => '$' . number_format($administrativos, 2),
            'servicios'                  => $servicios,
            'servicios_formateado'       => '$' . number_format($servicios, 2),
            'porcentaje_sobre_costo'     => 0,
        ];
    }

    /**
     * Transformar gastos para la vista
     */
    private function transformarGastos($gastos)
    {
        return $gastos->map(function ($gasto) {
            $tipo       = $this->getTipoFromPartida($gasto->partida);
            $badgeClass = $this->getBadgeClass($tipo);

            // Nombre del proveedor desde la relación
            $proveedorNombre = null;
            if ($gasto->relationLoaded('proveedor') && $gasto->proveedor) {
                $proveedorNombre = $gasto->proveedor->nombre
                    ?? $gasto->proveedor->razon_social
                    ?? null;
            }

            return [
                'id'               => $gasto->id,
                'folio'            => $gasto->folio,
                'fecha'            => $gasto->fecha ? $gasto->fecha->format('Y-m-d') : date('Y-m-d'),
                'fecha_lista'      => $gasto->fecha ? $this->formatearFechaLista($gasto->fecha) : date('d/m/Y'),
                'proyecto_id'      => $gasto->proyecto_id,
                'proyecto_codigo'  => $gasto->proyecto?->codigo ?? 'N/A',
                'proyecto_nombre'  => $gasto->proyecto?->nombre ?? 'N/A',
                'proyecto_color'   => '#083CAE',
                'tipo'             => $tipo,
                'badge_class'      => $badgeClass,
                'proveedor_id'     => $gasto->proveedor_id,                          // 👈 nuevo
                'proveedor'        => $proveedorNombre ?? 'No especificado',          // 👈 ahora desde relación
                'monto'            => $gasto->monto,
                'monto_formateado' => '$' . number_format($gasto->monto, 2),
                'partida'          => $gasto->partida ?? '—',
                'tipo_documento'   => $gasto->tipo_documento ?? 'Factura',
                'forma_pago'       => $gasto->forma_pago ?? 'Transferencia',
                'concepto'         => $gasto->concepto ?? 'Sin concepto',
                'estatus'          => $gasto->estatus ?? 'activo',
            ];
        });
    }

    private function formatearFechaLista($fecha)
    {
        $meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        return $fecha->format('d') . ' ' . $meses[$fecha->month - 1] . ' ' . $fecha->format('Y');
    }

    private function getTipoFromPartida($partida)
    {
        $map = [
            'ADMIN01' => 'Administrativo',
            'VIA01'   => 'Viaticos',
            'SER01'   => 'Servicios',
            'SEG01'   => 'Seguros',
            'IMP01'   => 'Impuestos',
        ];
        return $map[$partida] ?? 'Administrativo';
    }

    private function getBadgeClass($tipo)
    {
        $map = [
            'Administrativo' => 'badge-administrativo',
            'Oficina'        => 'badge-oficina',
            'Viaticos'       => 'badge-viaticos',
            'Servicios'      => 'badge-servicios',
            'Seguros'        => 'badge-seguros',
            'Impuestos'      => 'badge-impuestos',
        ];
        return $map[$tipo] ?? 'badge-administrativo';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'proyecto_id'    => 'required|exists:proyectos,id',
                'fecha'          => 'required|date',
                'monto'          => 'required|numeric|min:0.01',
                'tipo'           => 'required|string',
                'proveedor_id'   => 'nullable|exists:proveedores,id',   // 👈 ahora FK
                'tipo_documento' => 'nullable|string|max:50',
                'forma_pago'     => 'nullable|string|max:50',
                'concepto'       => 'nullable|string',
            ]);

            $folio = $this->generarFolio();

            $gasto = GastoIndirecto::create([
                'folio'          => $folio,
                'fecha'          => $validated['fecha'],
                'proyecto_id'    => $validated['proyecto_id'],
                'proveedor_id'   => $validated['proveedor_id'] ?? null, // 👈
                'monto'          => $validated['monto'],
                'partida'        => $this->getPartidaFromTipo($validated['tipo']),
                'tipo_documento' => $validated['tipo_documento'] ?? 'Factura',
                'forma_pago'     => $validated['forma_pago'] ?? 'Transferencia',
                'concepto'       => $validated['concepto'] ?? 'Gasto indirecto',
                'created_by'     => auth()->id(),
            ]);

            $gasto->load(['proyecto', 'proveedor']);

            return response()->json([
                'success' => true,
                'message' => 'Gasto indirecto registrado correctamente',
                'data'    => $gasto,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error en GastoIndirectoController@store: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el gasto: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function generarFolio()
    {
        $year = date('Y');
        $ultimo = GastoIndirecto::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        if ($ultimo && preg_match('/GIN-' . $year . '-(\d+)/', $ultimo->folio, $matches)) {
            $numero = intval($matches[1]) + 1;
        } else {
            $numero = 1;
        }

        return 'GIN-' . $year . '-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    private function getPartidaFromTipo($tipo)
    {
        $map = [
            'Administrativo' => 'ADMIN01',
            'Oficina'        => 'ADMIN01',
            'Viaticos'       => 'VIA01',
            'Servicios'      => 'SER01',
            'Seguros'        => 'SEG01',
            'Impuestos'      => 'IMP01',
        ];
        return $map[$tipo] ?? 'ADMIN01';
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $gasto = GastoIndirecto::with(['proyecto', 'proveedor'])->findOrFail($id);
            return response()->json([
                'success' => true,
                'data'    => $gasto,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gasto no encontrado',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $gasto = GastoIndirecto::findOrFail($id);

            $validated = $request->validate([
                'fecha'        => 'sometimes|required|date',
                'monto'        => 'sometimes|required|numeric|min:0.01',
                'proveedor_id' => 'nullable|exists:proveedores,id', // 👈
                'concepto'     => 'nullable|string',
            ]);

            $gasto->update($validated);
            $gasto->load(['proyecto', 'proveedor']);

            return response()->json([
                'success' => true,
                'message' => 'Gasto indirecto actualizado correctamente',
                'data'    => $gasto,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $gasto = GastoIndirecto::findOrFail($id);
            $gasto->delete();

            return response()->json([
                'success' => true,
                'message' => 'Gasto indirecto eliminado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtener KPIs en tiempo real para AJAX
     */
    public function getKPIs(Request $request)
    {
        try {
            $search      = $request->input('search', '');
            $proyectoId  = $request->input('proyecto_id', '');
            $tipoGasto   = $request->input('tipo_gasto', '');
            $proveedorId = $request->input('proveedor_id', '');

            $kpis = $this->calcularKPIs($search, $proyectoId, $tipoGasto, $proveedorId);

            return response()->json([
                'success' => true,
                'data'    => $kpis,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Exportar a Excel
     */
    public function exportarExcel(Request $request)
    {
        try {
            $search      = $request->input('search', '');
            $proyectoId  = $request->input('proyecto_id', '');
            $tipoGasto   = $request->input('tipo_gasto', '');
            $proveedorId = $request->input('proveedor_id', '');

            $query = GastoIndirecto::with(['proyecto', 'proveedor'])
                ->whereNull('deleted_at');

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('folio', 'LIKE', "%{$search}%")
                      ->orWhere('concepto', 'LIKE', "%{$search}%")
                      ->orWhereHas('proveedor', function ($pq) use ($search) {
                          $pq->where('nombre', 'LIKE', "%{$search}%")
                             ->orWhere('razon_social', 'LIKE', "%{$search}%");
                      });
                });
            }

            if (!empty($proyectoId)) {
                $query->where('proyecto_id', $proyectoId);
            }

            if (!empty($tipoGasto)) {
                $query->where('partida', $tipoGasto);
            }

            if (!empty($proveedorId)) {
                $query->where('proveedor_id', $proveedorId);
            }

            $gastos = $query->orderBy('fecha', 'desc')->get();

            $html = $this->generarExcel($gastos);

            return response($html)
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename="gastos_indirectos_' . date('Y-m-d') . '.xls"');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al exportar: ' . $e->getMessage()]);
        }
    }

    private function generarExcel($gastos)
    {
        $total = $gastos->sum('monto');

        $html = '<html><head><meta charset="UTF-8"><title>Gastos Indirectos</title>
        <style>th{background:#083CAE;color:white;padding:8px;}td{padding:6px;border:1px solid #ddd;}</style>
        </head><body>
        <h2>Gastos Indirectos por Obra</h2>
        <p>Generado: ' . date('d/m/Y H:i:s') . '</p>
        <table border="1"><thead><tr><th>Folio</th><th>Fecha</th><th>Proyecto</th><th>Tipo</th><th>Proveedor</th><th>Monto</th><th>Partida</th></tr></thead><tbody>';

        foreach ($gastos as $g) {
            $provNombre = $g->proveedor->nombre ?? $g->proveedor->razon_social ?? '-';
            $html .= '<tr>
                <td>' . e($g->folio) . '</td>
                <td>' . ($g->fecha ? $g->fecha->format('d/m/Y') : '-') . '</td>
                <td>' . e($g->proyecto?->codigo ?? '-') . ' - ' . e($g->proyecto?->nombre ?? '-') . '</td>
                <td>' . e($this->getTipoFromPartida($g->partida)) . '</td>
                <td>' . e($provNombre) . '</td>
                <td class="text-right">$' . number_format($g->monto, 2) . '</td>
                <td>' . e($g->partida ?? '-') . '</td>
            </tr>';
        }

        $html .= '</tbody><tfoot><tr><td colspan="5"><strong>TOTAL</strong></td>
        <td class="text-right"><strong>$' . number_format($total, 2) . '</strong></td><td></td></tr></tfoot></table></body></html>';

        return $html;
    }
}