<?php

namespace App\Http\Controllers;

use App\Models\ComplementoPago;
use App\Models\Facturacion\Contacto;
use App\Models\Pago;
use App\Models\Contrarecibo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

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
            $search      = $request->input('search', '');
            $fechaInicio = $request->input('fecha_inicio', date('Y-m-01'));
            $fechaFin    = $request->input('fecha_fin', date('Y-m-t'));
            $estatus     = $request->input('estatus', '');
            $page        = (int) $request->input('page', 1);
            $perPage     = (int) $request->input('per_page', 10);
            $sortKey     = $request->input('sort_key', 'fecha_pago');
            $sortDir     = $request->input('sort_dir', 'desc');

            $query = ComplementoPago::with(['cliente', 'cfdi', 'pago', 'contrarecibo'])
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

            $sortDirSql = $sortDir === 'asc' ? 'asc' : 'desc';
            if (in_array($sortKey, ['monto', 'fecha_pago', 'folio'], true)) {
                $query->orderBy($sortKey, $sortDirSql);
            } else {
                $query->orderBy('fecha_pago', 'desc');
            }

            $complementos = $query->paginate($perPage, ['*'], 'page', $page);

            $kpis = $this->calcularKPIs($search, $fechaInicio, $fechaFin, $estatus);
            $complementosTransformados = $this->transformarComplementos($complementos);

            return response()->json([
                'success' => true,
                'data' => [
                    'complementos' => $complementosTransformados,
                    'pagination' => [
                        'current_page' => $complementos->currentPage(),
                        'per_page'     => $complementos->perPage(),
                        'total'        => $complementos->total(),
                        'last_page'    => $complementos->lastPage(),
                        'from'         => $complementos->firstItem(),
                        'to'           => $complementos->lastItem(),
                    ],
                    'kpis' => $kpis,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Error en ComplementoPagoController@index: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los complementos: ' . $e->getMessage(),
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

        $total      = $query->count();
        $montoTotal = $query->sum('monto');

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
            'total'                  => $total,
            'total_formateado'       => number_format($total, 0),
            'monto_total'            => $montoTotal,
            'monto_total_formateado' => '$' . number_format($montoTotal, 2),
            'por_timbrar'            => $porTimbrar,
            'timbrados'              => $timbrados,
            'cancelados'             => max(0, $total - $porTimbrar - $timbrados),
        ];
    }

    /**
     * Transformar complementos para la vista
     */
    private function transformarComplementos($complementos)
    {
        return $complementos->map(function ($complemento) {
            return [
                'id'                    => $complemento->id,
                'folio'                 => $complemento->folio,
                'cliente'               => $complemento->cliente_nombre,
                'rfc'                   => $complemento->rfc ?? ($complemento->cliente ? $complemento->cliente->rfc : '-'),
                'fecha_pago'            => $complemento->fecha_pago ? $complemento->fecha_pago->format('Y-m-d') : date('Y-m-d'),
                'fecha_lista'           => $complemento->fecha_lista,
                'documento_relacionado' => $complemento->documento_relacionado ?? '-',
                'forma_pago'            => $complemento->forma_pago ?? 'Transferencia',
                'cuenta_banco'          => $complemento->cuenta_banco ?? null,
                'monto'                 => $complemento->monto,
                'monto_formateado'      => $complemento->monto_formateado,
                'estatus'               => $complemento->estatus,
                'badge_class'           => $complemento->badge_class,
                'uuid'                  => $complemento->uuid ?? '-',
                'cfdi_id'               => $complemento->cfdi_id,
                'pago_id'               => $complemento->pago_id,
                'contrarecibo_id'       => $complemento->contrarecibo_id,
                'factura_id'            => $complemento->factura_id ?? null,
            ];
        });
    }

    /**
     * ============================================================
     * STORE — fix "bigint undefined" + cuenta_banco + factura_id
     * ============================================================
     */
    public function store(Request $request)
    {
        try {
            $rawCliente = $request->input('cliente_id');
            if ($rawCliente === 'undefined' || $rawCliente === 'null' || $rawCliente === '') {
                return response()->json([
                    'success' => false,
                    'message' => 'Debe seleccionar un cliente válido.',
                ], 422);
            }

            $validated = $request->validate([
                'cliente_id'            => 'required|integer|min:1|exists:contactos,contacto_id',
                'fecha_pago'            => 'required|date',
                'monto'                 => 'required|numeric|min:0.01',
                'documento_relacionado' => 'nullable|string|max:50',
                'forma_pago'            => 'nullable|string|max:50',
                'cuenta_banco'          => 'nullable|string|max:100',
                'factura_id'            => 'nullable|integer|min:1',
                'facturas_ids'          => 'nullable|array',
                'facturas_ids.*'        => 'integer|min:1',
            ]);

            $clienteId = (int) $validated['cliente_id'];
            $userId    = auth()->id() ? (int) auth()->id() : null;

            $cliente = DB::table('contactos')
                ->where('contacto_id', $clienteId)
                ->first();
            $rfc = $cliente->rfc ?? null;

            $facturaId = isset($validated['factura_id']) ? (int) $validated['factura_id'] : null;
            if ($facturaId) {
                $facturaValida = $this->validarFacturaDeCliente($facturaId, $clienteId);
                if (!$facturaValida) {
                    return response()->json([
                        'success' => false,
                        'message' => 'La factura seleccionada no pertenece al cliente o no existe.',
                    ], 422);
                }
            }

            $folio = ComplementoPago::generarFolio();

            $tieneCuentaBanco = Schema::hasColumn('complementos_pago', 'cuenta_banco');
            $tieneFacturaId   = Schema::hasColumn('complementos_pago', 'factura_id');

            $payload = [
                'folio'                 => $folio,
                'cliente_id'            => $clienteId,
                'rfc'                   => $rfc,
                'fecha_pago'            => $validated['fecha_pago'],
                'documento_relacionado' => $validated['documento_relacionado'] ?? null,
                'forma_pago'            => $validated['forma_pago'] ?? 'Transferencia',
                'monto'                 => $validated['monto'],
                'estatus'               => 'Pendiente',
                'created_by'            => $userId,
            ];

            if ($tieneCuentaBanco) {
                $payload['cuenta_banco'] = $validated['cuenta_banco'] ?? null;
            }

            $facturaIdFinal = $facturaId;
            if (!$facturaIdFinal && !empty($validated['facturas_ids'])) {
                $facturaIdFinal = (int) $validated['facturas_ids'][0];
            }
            if ($facturaIdFinal && $tieneFacturaId) {
                $payload['factura_id'] = $facturaIdFinal;
            }

            $complemento = ComplementoPago::create($payload);

            return response()->json([
                'success' => true,
                'message' => 'Complemento de pago registrado correctamente',
                'data'    => $complemento,
            ]);

        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos: ' . $ve->validator->errors()->first(),
                'errors'  => $ve->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error en ComplementoPagoController@store: ' . $e->getMessage(), [
                'payload' => $request->all(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el complemento: ' . $e->getMessage(),
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
                    'id'                    => $complemento->id,
                    'folio'                 => $complemento->folio,
                    'cliente_id'            => $complemento->cliente_id,
                    'cliente_nombre'        => $complemento->cliente_nombre,
                    'rfc'                   => $complemento->rfc,
                    'fecha_pago'            => $complemento->fecha_pago->format('Y-m-d'),
                    'fecha_formateada'      => $complemento->fecha_pago_formateada,
                    'documento_relacionado' => $complemento->documento_relacionado,
                    'forma_pago'            => $complemento->forma_pago,
                    'cuenta_banco'          => $complemento->cuenta_banco ?? null,
                    'monto'                 => $complemento->monto,
                    'monto_formateado'      => $complemento->monto_formateado,
                    'estatus'               => $complemento->estatus,
                    'uuid'                  => $complemento->uuid,
                    'cfdi_id'               => $complemento->cfdi_id,
                    'factura_id'            => $complemento->factura_id ?? null,
                    'created_at'            => $complemento->created_at->format('d/m/Y H:i:s'),
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Complemento no encontrado',
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
                'fecha_pago'            => 'sometimes|required|date',
                'monto'                 => 'sometimes|required|numeric|min:0.01',
                'documento_relacionado' => 'nullable|string|max:50',
                'forma_pago'            => 'nullable|string|max:50',
                'cuenta_banco'          => 'nullable|string|max:100',
                'factura_id'            => 'nullable|integer|min:1',
            ]);

            if (!Schema::hasColumn('complementos_pago', 'cuenta_banco')) {
                unset($validated['cuenta_banco']);
            }
            if (!Schema::hasColumn('complementos_pago', 'factura_id')) {
                unset($validated['factura_id']);
            }

            $complemento->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Complemento actualizado correctamente',
            ]);

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
            $complemento = ComplementoPago::findOrFail($id);

            if ($complemento->estatus !== 'Pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar un complemento timbrado o cancelado',
                ], 400);
            }

            $complemento->delete();

            return response()->json([
                'success' => true,
                'message' => 'Complemento eliminado correctamente',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage(),
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
                    'message' => 'El complemento ya está timbrado o cancelado',
                ], 400);
            }

            $uuid = 'TMP-' . strtoupper(uniqid()) . '-' . date('YmdHis');
            $complemento->asignarUuid($uuid);

            return response()->json([
                'success' => true,
                'message' => 'Complemento timbrado correctamente',
                'data'    => ['uuid' => $uuid, 'estatus' => 'Timbrado'],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al timbrar: ' . $e->getMessage(),
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
                    'message' => 'Solo se pueden cancelar complementos timbrados',
                ], 400);
            }

            $complemento->cancelar();

            return response()->json([
                'success' => true,
                'message' => 'Complemento cancelado correctamente',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cancelar: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * KPIs en tiempo real
     */
    public function getKPIs(Request $request)
    {
        try {
            $search      = $request->input('search', '');
            $fechaInicio = $request->input('fecha_inicio', date('Y-m-01'));
            $fechaFin    = $request->input('fecha_fin', date('Y-m-t'));
            $estatus     = $request->input('estatus', '');

            $kpis = $this->calcularKPIs($search, $fechaInicio, $fechaFin, $estatus);

            return response()->json(['success' => true, 'data' => $kpis]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Obtener clientes para el select
     */
    public function getClientes(Request $request)
    {
        try {
            $search = $request->input('search', '');

            $query = DB::table('contactos')
                ->select('contacto_id as id', 'razon_social', 'rfc')
                ->where('estatus', true)
                ->where(function ($q) {
                    $q->where('tipo', 'cliente')
                      ->orWhere('tipo', 'ambos');
                })
                ->whereNull('deleted_at');

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('razon_social', 'LIKE', "%{$search}%")
                      ->orWhere('rfc', 'LIKE', "%{$search}%");
                });
            }

            $clientes = $query->orderBy('razon_social')->limit(50)->get();

            $clientes = $clientes->map(fn($c) => [
                'contacto_id'  => (int) $c->id,
                'id'           => (int) $c->id,
                'razon_social' => $c->razon_social,
                'rfc'          => $c->rfc,
            ]);

            return response()->json(['success' => true, 'data' => $clientes]);

        } catch (\Exception $e) {
            Log::error('Error en getClientes: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * ============================================================
     * FACTURAS DEL CLIENTE (para el selector del modal)
     * GET /api/complementos-pago/facturas-cliente?cliente_id=X
     *
     * Esquema real de tabla `facturas`:
     *   factura_id, contacto_id, folio, fecha, total, saldo_disponible,
     *   estatus, tipo_comprobante, deleted_at, ...
     * ============================================================
     */
    public function getFacturasCliente(Request $request)
    {
        try {
            $clienteId = $request->input('cliente_id');
            if ($clienteId === 'undefined' || $clienteId === 'null' || $clienteId === '' || !is_numeric($clienteId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'cliente_id inválido.',
                ], 422);
            }
            $clienteId = (int) $clienteId;

            $tabla = $this->detectarTablaFacturas();
            if (!$tabla) {
                return response()->json([
                    'success' => true,
                    'data'    => [],
                    'message' => 'No se encontró tabla de facturas configurada.',
                ]);
            }

            $columnas = Schema::getColumnListing($tabla);

            $pick = function (array $candidatas) use ($columnas) {
                foreach ($candidatas as $c) {
                    if (in_array($c, $columnas, true)) return $c;
                }
                return null;
            };

            $colPk      = $pick(['factura_id', 'id', 'id_factura', 'comprobante_id', 'cfdi_id']);
            $colCliente = $pick(['contacto_id', 'cliente_id', 'id_cliente', 'receptor_id']);
            $colFolio   = $pick(['folio', 'numero_factura', 'numero', 'serie_folio']);
            $colTotal   = $pick(['total', 'monto', 'importe', 'total_factura']);
            $colSaldo   = $pick(['saldo_disponible', 'saldo', 'saldo_pendiente']);
            $colFecha   = $pick(['fecha', 'fecha_emision', 'fecha_factura', 'created_at']);
            $colEstatus = $pick(['estatus', 'status', 'estado', 'estado_factura']);
            $colUuid    = $pick(['uuid', 'uuid_fiscal', 'folio_fiscal']);
            $colTipo    = $pick(['tipo_comprobante']);

            if (!$colPk || !$colCliente) {
                return response()->json([
                    'success' => true,
                    'data'    => [],
                    'message' => "La tabla {$tabla} no tiene columnas de PK o cliente reconocibles.",
                    'meta'    => ['columnas' => $columnas],
                ]);
            }

            $select = [
                DB::raw("\"{$tabla}\".\"{$colPk}\" as id"),
                DB::raw($colFolio   ? "\"{$tabla}\".\"{$colFolio}\" as folio"   : "\"{$tabla}\".\"{$colPk}\"::text as folio"),
                DB::raw($colTotal   ? "\"{$tabla}\".\"{$colTotal}\" as total"   : "0 as total"),
                DB::raw($colSaldo   ? "\"{$tabla}\".\"{$colSaldo}\" as saldo"   : "0 as saldo"),
                DB::raw($colFecha   ? "\"{$tabla}\".\"{$colFecha}\" as fecha"   : "NULL as fecha"),
                DB::raw($colEstatus ? "\"{$tabla}\".\"{$colEstatus}\" as estatus" : "'' as estatus"),
                DB::raw($colUuid    ? "\"{$tabla}\".\"{$colUuid}\" as uuid"     : "'' as uuid"),
                DB::raw($colTipo    ? "\"{$tabla}\".\"{$colTipo}\" as tipo_comprobante" : "'' as tipo_comprobante"),
            ];

            $query = DB::table($tabla)->select($select);

            $query->where("{$tabla}.{$colCliente}", $clienteId);

            if (in_array('deleted_at', $columnas, true)) {
                $query->whereNull("{$tabla}.deleted_at");
            }

            if ($colTipo) {
                $query->where(function ($q) use ($tabla, $colTipo) {
                    $q->whereNull("{$tabla}.{$colTipo}")
                      ->orWhere("{$tabla}.{$colTipo}", 'I')
                      ->orWhere("{$tabla}.{$colTipo}", 'Ingreso')
                      ->orWhere("{$tabla}.{$colTipo}", 'ingreso');
                });
            }

            if (in_array('complemento_pago_id', $columnas, true)) {
                $query->whereNull("{$tabla}.complemento_pago_id");
            }

            if ($colSaldo) {
                $query->where("{$tabla}.{$colSaldo}", '>', 0);
            }

            $query->orderByDesc("{$tabla}.{$colPk}");

            $facturas = $query->limit(100)->get();

            return response()->json([
                'success' => true,
                'data'    => $facturas,
                'meta'    => [
                    'tabla'    => $tabla,
                    'columnas' => [
                        'pk'      => $colPk,
                        'cliente' => $colCliente,
                        'folio'   => $colFolio,
                        'total'   => $colTotal,
                        'saldo'   => $colSaldo,
                        'fecha'   => $colFecha,
                        'estatus' => $colEstatus,
                        'uuid'    => $colUuid,
                        'tipo'    => $colTipo,
                    ],
                    'cliente'  => $clienteId,
                    'total'    => $facturas->count(),
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getFacturasCliente: ' . $e->getMessage(), [
                'cliente_id' => $request->input('cliente_id'),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al consultar facturas: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Cuentas bancarias para el select
     */
    public function getCuentasBanco(Request $request)
    {
        try {
            $tabla = null;
            foreach (['cuentas_bancarias', 'cuentas_banco', 'bancos_cuentas', 'cat_cuentas_bancarias', 'cuentas'] as $t) {
                if (Schema::hasTable($t)) { $tabla = $t; break; }
            }

            if (!$tabla) {
                return response()->json(['success' => true, 'data' => [], 'meta' => ['tabla' => null]]);
            }

            $columnas = Schema::getColumnListing($tabla);

            $pick = function (array $candidatas) use ($columnas) {
                foreach ($candidatas as $c) {
                    if (in_array($c, $columnas, true)) return $c;
                }
                return null;
            };

            $colId     = $pick(['id', 'cuenta_bancaria_id', 'cuenta_id', 'id_cuenta']);
            $colNombre = $pick(['nombre', 'alias', 'descripcion', 'titular']);
            $colBanco  = $pick(['banco', 'banco_nombre', 'nombre_banco', 'banco_id']);
            $colCuenta = $pick(['numero_cuenta', 'cuenta', 'no_cuenta', 'num_cuenta']);
            $colClabe  = $pick(['clabe', 'clabe_interbancaria']);
            $colActivo = $pick(['activo', 'estatus', 'status']);

            if (!$colId) {
                return response()->json([
                    'success' => true,
                    'data'    => [],
                    'message' => "La tabla {$tabla} no tiene PK reconocible.",
                    'meta'    => ['columnas' => $columnas],
                ]);
            }

            $select = [
                DB::raw("\"{$tabla}\".\"{$colId}\" as id"),
                DB::raw($colNombre ? "\"{$tabla}\".\"{$colNombre}\" as nombre"        : "NULL as nombre"),
                DB::raw($colBanco  ? "\"{$tabla}\".\"{$colBanco}\" as banco"          : "NULL as banco"),
                DB::raw($colCuenta ? "\"{$tabla}\".\"{$colCuenta}\" as numero_cuenta" : "NULL as numero_cuenta"),
                DB::raw($colClabe  ? "\"{$tabla}\".\"{$colClabe}\" as clabe"          : "NULL as clabe"),
            ];

            $query = DB::table($tabla)->select($select);

            if ($colActivo) {
                $query->where(function ($q) use ($tabla, $colActivo) {
                    $q->where("{$tabla}.{$colActivo}", true)
                      ->orWhere("{$tabla}.{$colActivo}", 1)
                      ->orWhere("{$tabla}.{$colActivo}", 'activo')
                      ->orWhere("{$tabla}.{$colActivo}", 'Activo');
                });
            }

            $cuentas = $query->get();

            return response()->json([
                'success' => true,
                'data'    => $cuentas,
                'meta'    => [
                    'tabla'    => $tabla,
                    'columnas' => [
                        'id'     => $colId,
                        'nombre' => $colNombre,
                        'banco'  => $colBanco,
                        'cuenta' => $colCuenta,
                        'clabe'  => $colClabe,
                    ],
                    'total' => $cuentas->count(),
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getCuentasBanco: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Exportar a Excel
     */
    public function exportarExcel(Request $request)
    {
        try {
            $search      = $request->input('search', '');
            $fechaInicio = $request->input('fecha_inicio', date('Y-m-01'));
            $fechaFin    = $request->input('fecha_fin', date('Y-m-t'));
            $estatus     = $request->input('estatus', '');

            $query = ComplementoPago::with(['cliente'])->whereNull('deleted_at');

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
            <th>Documento Relacionado</th><th>Forma Pago</th><th>Cuenta Banco</th>
            <th>Monto</th><th>Estado</th><th>UUID</th>
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
                <td>' . e($c->cuenta_banco ?? '-') . '</td>
                <td class="text-right">$' . number_format($c->monto, 2) . '</td>
                <td>' . e($c->estatus) . '</td>
                <td>' . e($c->uuid ?? '-') . '</td>
            </tr>';
        }

        $html .= '</tbody><tfoot><tr>
            <td colspan="7"><strong>TOTAL</strong></td>
            <td class="text-right"><strong>$' . number_format($total, 2) . '</strong></td>
            <td colspan="2"></td>
        </tr></tfoot></table></body></html>';

        return $html;
    }

    /**
     * Método de prueba
     */
    public function test()
    {
        try {
            $tableExists = Schema::hasTable('complementos_pago');
            $count = $tableExists ? ComplementoPago::count() : 0;

            return response()->json([
                'success'       => true,
                'message'       => 'API Complementos de Pago funcionando correctamente',
                'table_exists'  => $tableExists,
                'records_count' => $count,
                'timestamp'     => now()->toDateTimeString(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /* ============================================================
     * HELPERS internos
     * ============================================================ */

    private function detectarTablaFacturas(): ?string
    {
        foreach ([
            'facturas',
            'facturacion_facturas',
            'facturas_clientes',
            'cfdi_facturas',
            'facturas_emitidas',
        ] as $t) {
            if (Schema::hasTable($t)) return $t;
        }
        return null;
    }

    private function detectarColumnaCliente(string $tabla): ?string
    {
        foreach (['contacto_id', 'cliente_id', 'id_cliente', 'receptor_id'] as $c) {
            if (Schema::hasColumn($tabla, $c)) return $c;
        }
        return null;
    }

    private function validarFacturaDeCliente(int $facturaId, int $clienteId): bool
    {
        $tabla = $this->detectarTablaFacturas();
        if (!$tabla) return true;

        $colCliente = $this->detectarColumnaCliente($tabla);
        if (!$colCliente) return true;

        $colPk = Schema::hasColumn($tabla, 'factura_id') ? 'factura_id' : 'id';

        return DB::table($tabla)
            ->where($colPk, $facturaId)
            ->where($colCliente, $clienteId)
            ->exists();
    }
}