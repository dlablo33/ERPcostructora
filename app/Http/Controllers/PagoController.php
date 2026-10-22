<?php
// app/Http/Controllers/PagoController.php
namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\CuentaBancaria;
use App\Models\Proveedor;
use App\Models\Proyecto;
use App\Models\TipoEgreso;
use App\Models\CategoriaGasto;
use App\Models\MetodoPago;
use App\Models\Moneda;
use App\Models\MovimientoBancario;
use App\Models\CodigoSat;
use App\Models\LayoutPago;
use App\Models\LayoutPagoDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PagoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getData']);
    }

    /**
     * Vista principal de pagos
     */
    public function index()
    {
        $cuentasBancarias = CuentaBancaria::with(['banco', 'moneda'])
            ->where('activa', true)
            ->get();

        $proveedores = Proveedor::with('codigoSatDefault')
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        $proyectos = Proyecto::where('status', 'activo')
            ->orderBy('nombre')
            ->get();

        $tiposEgreso = TipoEgreso::activos()
            ->orderBy('nombre')
            ->get();

        $categoriasGasto = CategoriaGasto::where('activo', true)->get();
        $metodosPago     = MetodoPago::where('activo', true)->get();
        $monedas         = Moneda::where('activa', true)->get();

        $codigosSatGastos = CodigoSat::whereIn('tipo', ['G', 'A'])
            ->orderBy('codigo_agrupador')
            ->get();

        $estadisticas = [
            'total'       => Pago::count(),
            'completados' => Pago::where('estatus', 'completado')->count(),
            'pendientes'  => Pago::where('estatus', 'pendiente')->count(),
            'cancelados'  => Pago::where('estatus', 'cancelado')->count(),
            'total_monto' => Pago::sum('monto') ?? 0,
        ];

        return view('administracion.tesoreria.pagos', compact(
            'cuentasBancarias',
            'proveedores',
            'proyectos',
            'tiposEgreso',
            'categoriasGasto',
            'metodosPago',
            'monedas',
            'codigosSatGastos',
            'estadisticas'
        ));
    }

    /**
     * Listado de pagos para el grid (JSON)
     */
    public function getData(Request $request)
    {
        try {
            $query = Pago::with([
                'cuentaBancaria.banco',
                'proveedor',
                'proyecto',
                'tipoEgreso',
                'categoriaGasto',
                'metodoPago',
                'moneda',
                'codigoSat',
            ]);

            if ($request->filled('fecha_inicio')) {
                $query->whereDate('fecha_pago', '>=', $request->fecha_inicio);
            }
            if ($request->filled('fecha_fin')) {
                $query->whereDate('fecha_pago', '<=', $request->fecha_fin);
            }
            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }
            if ($request->filled('proveedor_id')) {
                $query->where('proveedor_id', $request->proveedor_id);
            }

            $pagos = $query->orderBy('fecha_pago', 'desc')->get();

            $data = $pagos->map(function ($p) {
                return [
                    'id'                 => $p->id,
                    'folio'              => $p->folio,
                    'fecha_pago'         => $p->fecha_pago,
                    'proveedor'          => $p->proveedor->nombre ?? $p->proveedor_nombre,
                    'proveedor_id'       => $p->proveedor_id,
                    'proveedor_rfc'      => $p->proveedor->rfc ?? $p->proveedor_rfc,
                    'concepto'           => $p->concepto,
                    'monto'              => (float) $p->monto,
                    'metodo_pago'        => $p->metodoPago->nombre ?? null,
                    'metodo_pago_id'     => $p->metodo_pago_id,
                    'estatus'            => $p->estatus,
                    'factura'            => $p->factura,
                    'factura_uuid'       => $p->factura_uuid,
                    'factura_monto'      => $p->factura_monto,
                    'factura_fecha'      => $p->factura_fecha,
                    'codigo_sat_id'      => $p->codigo_sat_id,
                    'codigo_sat'         => $p->codigoSat->codigo_agrupador ?? null,
                    'codigo_sat_nombre'  => $p->codigoSat->nombre_cuenta ?? null,
                    'tipo_egreso_id'     => $p->tipo_egreso_id,
                    'categoria_gasto_id' => $p->categoria_gasto_id,
                    'proyecto_id'        => $p->proyecto_id,
                    'cuenta_bancaria_id' => $p->cuenta_bancaria_id,
                    'moneda_id'          => $p->moneda_id,
                    'referencia'         => $p->referencia,
                    'referencia_bancaria'=> $p->referencia_bancaria,
                    'observaciones'      => $p->observaciones,
                ];
            });

            return response()->json([
                'success' => true,
                'data'    => $data,
                'stats'   => [
                    'total'       => $pagos->count(),
                    'completados' => $pagos->where('estatus', 'completado')->count(),
                    'pendientes'  => $pagos->where('estatus', 'pendiente')->count(),
                    'total_monto' => $pagos->sum('monto'),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getData pagos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Categorías por tipo de egreso
     */
    public function getCategoriasPorTipoEgreso($tipoEgresoId)
    {
        try {
            $categorias = CategoriaGasto::where('tipo_egreso_id', $tipoEgresoId)
                ->where('activo', true)
                ->orderBy('nombre')
                ->get(['id', 'nombre']);

            return response()->json($categorias);
        } catch (\Exception $e) {
            Log::error('Error al obtener categorías: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Código SAT sugerido por proveedor
     */
    public function getCodigoSatSugerido($proveedorId)
    {
        try {
            $proveedor = Proveedor::with('codigoSatDefault')->find($proveedorId);

            if ($proveedor && $proveedor->codigo_sat_default_id) {
                return response()->json([
                    'success'           => true,
                    'codigo_sat_id'     => $proveedor->codigo_sat_default_id,
                    'codigo_sat_nombre' => $proveedor->codigoSatDefault?->nombre_cuenta,
                    'codigo_sat_codigo' => $proveedor->codigoSatDefault?->codigo_agrupador,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'El proveedor no tiene un código SAT por defecto',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Facturas del proveedor (para el select de "Número de Factura")
     * GET /admin/api/proveedores/{proveedorId}/facturas
     *
     * ⚠️ AJUSTA la tabla/modelo y los campos según tu estructura real.
     * Por defecto se asume una tabla `facturas_proveedor` con:
     *   id, proveedor_id, folio, uuid, total, fecha
     */
    public function getFacturasProveedor($proveedorId)
    {
        try {
            // ---------- OPCIÓN A: usando Query Builder (recomendado si no tienes modelo) ----------
            $facturas = DB::table('facturas_proveedor')
                ->where('proveedor_id', $proveedorId)
                ->whereNull('deleted_at')                       // quitar si no usas SoftDeletes
                ->orderBy('fecha', 'desc')
                ->get()
                ->map(function ($f) {
                    return [
                        'id'    => $f->id,
                        'folio' => $f->folio ?? $f->numero_factura ?? $f->id,
                        'uuid'  => $f->uuid  ?? $f->uuid_cfdi ?? null,
                        'monto' => (float) ($f->total ?? $f->monto ?? 0),
                        'fecha' => $f->fecha ?? $f->fecha_emision ?? null,
                    ];
                });

            // ---------- OPCIÓN B: usando un modelo Eloquent ----------
            // $facturas = \App\Models\FacturaProveedor::where('proveedor_id', $proveedorId)
            //     ->orderBy('fecha', 'desc')
            //     ->get(['id', 'folio', 'uuid', 'total', 'fecha'])
            //     ->map(function ($f) {
            //         return [
            //             'id'    => $f->id,
            //             'folio' => $f->folio,
            //             'uuid'  => $f->uuid,
            //             'monto' => (float) $f->total,
            //             'fecha' => $f->fecha,
            //         ];
            //     });

            return response()->json([
                'success' => true,
                'data'    => $facturas,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener facturas del proveedor: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data'    => [],
            ], 500);
        }
    }

    /**
     * Crear pago
     * 🔧 FIX Ticket #2: codigo_sat_id nullable, factura_* incluidos en Validator
     * 🔧 FIX Ticket #5: persiste factura_uuid, factura_monto, factura_fecha
     */
    public function store(Request $request)
    {
        try {
            Log::info('Datos recibidos en store:', $request->all());

            $validator = Validator::make($request->all(), [
                'fecha_pago'         => 'required|date',
                'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
                'proveedor_id'       => 'nullable|exists:proveedores,id',
                'proveedor_nombre'   => 'nullable|string|max:200',
                'proveedor_rfc'      => 'nullable|string|max:20',
                'proyecto_id'        => 'nullable|exists:proyectos,id',
                'tipo_egreso_id'     => 'required|exists:tipos_egreso,id',
                'categoria_gasto_id' => 'nullable|exists:categorias_gastos,id',
                'metodo_pago_id'     => 'required|exists:metodos_pago,id',
                'moneda_id'          => 'required|exists:monedas,id',
                'monto'              => 'required|numeric|min:0.01',
                'concepto'           => 'required|string|max:500',
                'referencia'         => 'nullable|string|max:100',
                'referencia_bancaria'=> 'nullable|string|max:100',
                'factura'            => 'nullable|string|max:50',
                'factura_uuid'       => 'nullable|string|max:100',
                'factura_monto'      => 'nullable|numeric|min:0',
                'factura_fecha'      => 'nullable|date',
                'observaciones'      => 'nullable|string',
                'aplicar_ahora'      => 'boolean',
                'codigo_sat_id'      => 'nullable|exists:codigos_sat,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors'  => $validator->errors(),
                ], 422);
            }

            $validated = $validator->validated();

            // Validación de negocio: proveedor obligatorio
            if (empty($validated['proveedor_id']) && empty($validated['proveedor_nombre'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Debe seleccionar un proveedor',
                    'errors'  => ['proveedor_id' => ['Proveedor requerido']],
                ], 422);
            }

            DB::beginTransaction();

            // Traer nombre/RFC del proveedor y código SAT por defecto
            if (!empty($validated['proveedor_id'])) {
                $proveedor = Proveedor::find($validated['proveedor_id']);
                if ($proveedor) {
                    $validated['proveedor_nombre'] = $proveedor->nombre;
                    $validated['proveedor_rfc']    = $proveedor->rfc;

                    if (empty($validated['codigo_sat_id']) && $proveedor->codigo_sat_default_id) {
                        $validated['codigo_sat_id'] = $proveedor->codigo_sat_default_id;
                    }
                }
            }

            // Si aún no hay código SAT, asignar uno genérico de gastos
            if (empty($validated['codigo_sat_id'])) {
                $defaultSat = CodigoSat::whereIn('tipo', ['G', 'A'])
                    ->orderBy('codigo_agrupador')
                    ->first();

                if ($defaultSat) {
                    $validated['codigo_sat_id'] = $defaultSat->id;
                }
            }

            $validated['folio']      = Pago::generarFolio();
            $validated['estatus']    = ($validated['aplicar_ahora'] ?? false) ? 'completado' : 'pendiente';
            $validated['created_by'] = auth()->id();

            $pago = Pago::create($validated);

            if ($validated['aplicar_ahora'] ?? false) {
                $this->aplicarPago($pago);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pago creado exitosamente',
                'data'    => $pago->load([
                    'cuentaBancaria.banco',
                    'proveedor',
                    'proyecto',
                    'tipoEgreso',
                    'categoriaGasto',
                    'metodoPago',
                    'moneda',
                    'codigoSat',
                ]),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear pago: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Ver un pago
     */
    public function show($id)
    {
        try {
            $pago = Pago::with([
                'cuentaBancaria.banco',
                'proveedor',
                'proyecto',
                'tipoEgreso',
                'categoriaGasto',
                'metodoPago',
                'moneda',
                'creador',
                'codigoSat',
            ])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data'    => $pago,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => 'Pago no encontrado',
            ], 404);
        }
    }

    /**
     * Actualizar pago
     */
    public function update(Request $request, $id)
    {
        try {
            $pago = Pago::findOrFail($id);

            if ($pago->estatus !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden editar pagos pendientes',
                ], 422);
            }

            $validator = Validator::make($request->all(), [
                'fecha_pago'         => 'required|date',
                'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
                'proveedor_id'       => 'nullable|exists:proveedores,id',
                'proveedor_nombre'   => 'nullable|string|max:200',
                'proveedor_rfc'      => 'nullable|string|max:20',
                'proyecto_id'        => 'nullable|exists:proyectos,id',
                'tipo_egreso_id'     => 'required|exists:tipos_egreso,id',
                'categoria_gasto_id' => 'nullable|exists:categorias_gastos,id',
                'metodo_pago_id'     => 'required|exists:metodos_pago,id',
                'moneda_id'          => 'required|exists:monedas,id',
                'monto'              => 'required|numeric|min:0.01',
                'concepto'           => 'required|string|max:500',
                'referencia'         => 'nullable|string|max:100',
                'referencia_bancaria'=> 'nullable|string|max:100',
                'factura'            => 'nullable|string|max:50',
                'factura_uuid'       => 'nullable|string|max:100',
                'factura_monto'      => 'nullable|numeric|min:0',
                'factura_fecha'      => 'nullable|date',
                'observaciones'      => 'nullable|string',
                'codigo_sat_id'      => 'nullable|exists:codigos_sat,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors'  => $validator->errors(),
                ], 422);
            }

            $validated = $validator->validated();

            DB::beginTransaction();

            if (!empty($validated['proveedor_id'])) {
                $proveedor = Proveedor::find($validated['proveedor_id']);
                if ($proveedor) {
                    $validated['proveedor_nombre'] = $proveedor->nombre;
                    $validated['proveedor_rfc']    = $proveedor->rfc;
                }
            }

            $pago->update($validated);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pago actualizado exitosamente',
                'data'    => $pago->load([
                    'cuentaBancaria.banco',
                    'proveedor',
                    'proyecto',
                    'tipoEgreso',
                    'categoriaGasto',
                    'metodoPago',
                    'moneda',
                    'codigoSat',
                ]),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Eliminar pago
     */
    public function destroy($id)
    {
        try {
            $pago = Pago::findOrFail($id);

            if ($pago->estatus !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden eliminar pagos pendientes',
                ], 422);
            }

            DB::beginTransaction();
            $pago->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pago eliminado exitosamente',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Aplicar pago (marcar como completado)
     */
    public function aplicar($id)
    {
        try {
            DB::beginTransaction();
            $pago = Pago::findOrFail($id);

            if ($pago->estatus !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'El pago ya fue ' . $pago->estatus,
                ], 422);
            }

            if (!$pago->codigo_sat_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'El pago no tiene un código SAT asignado. Por favor edite el pago y asigne uno.',
                ], 422);
            }

            $this->aplicarPago($pago);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pago aplicado exitosamente. Saldo actualizado.',
                'data'    => $pago->load([
                    'cuentaBancaria.banco',
                    'proveedor',
                    'proyecto',
                    'tipoEgreso',
                    'categoriaGasto',
                    'metodoPago',
                    'moneda',
                    'codigoSat',
                ]),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al aplicar pago: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Lógica interna: actualiza saldo de cuenta y crea movimiento bancario
     */
    private function aplicarPago($pago)
    {
        if (!$pago->codigo_sat_id) {
            throw new \Exception('El pago no tiene un código SAT asignado.');
        }

        $cuenta = CuentaBancaria::find($pago->cuenta_bancaria_id);
        if ($cuenta) {
            $cuenta->saldo_actual = $cuenta->saldo_actual - $pago->monto;
            $cuenta->save();

            Log::info('Saldo actualizado. Nuevo saldo cuenta ' . $cuenta->id . ': ' . $cuenta->saldo_actual);
        }

        $movimiento = MovimientoBancario::create([
            'cuenta_bancaria_id' => $pago->cuenta_bancaria_id,
            'proyecto_id'        => $pago->proyecto_id,
            'tipo'               => 'egreso',
            'tipo_egreso_id'     => $pago->tipo_egreso_id,
            'categoria_gasto_id' => $pago->categoria_gasto_id,
            'metodo_pago_id'     => $pago->metodo_pago_id,
            'monto'              => $pago->monto,
            'fecha'              => $pago->fecha_pago,
            'concepto'           => $pago->concepto,
            'referencia'         => $pago->referencia,
            'comprobante'        => $pago->comprobante ?? null,
            'status'             => 'aplicado',
            'observaciones'      => 'Pago: ' . ($pago->observaciones ?? ''),
            'created_by'         => $pago->created_by,
            'codigo_sat_id'      => $pago->codigo_sat_id,
        ]);

        $pago->estatus = 'completado';
        $pago->save();

        Log::info('Movimiento creado ID: ' . $movimiento->id . ' con código SAT: ' . $pago->codigo_sat_id);

        return $movimiento;
    }

    /**
     * Estadísticas para el resumen de cards
     */
    public function getEstadisticas()
    {
        try {
            return response()->json([
                'success' => true,
                'data'    => [
                    'total'       => Pago::count(),
                    'pendientes'  => Pago::where('estatus', 'pendiente')->count(),
                    'completados' => Pago::where('estatus', 'completado')->count(),
                    'cancelados'  => Pago::where('estatus', 'cancelado')->count(),
                    'total_monto' => Pago::sum('monto') ?? 0,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Generar PDF del pago (opcional)
     */
    public function pdf($id)
    {
        try {
            $pago = Pago::with([
                'cuentaBancaria.banco',
                'proveedor',
                'proyecto',
                'tipoEgreso',
                'categoriaGasto',
                'metodoPago',
                'moneda',
                'codigoSat',
            ])->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'PDF pendiente de implementar',
                'data'    => $pago,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => 'Pago no encontrado',
            ], 404);
        }
    }

    /**
     * Vista imprimible del pago (opcional)
     */
    public function printView($id)
    {
        try {
            $pago = Pago::with([
                'cuentaBancaria.banco',
                'proveedor',
                'proyecto',
                'tipoEgreso',
                'categoriaGasto',
                'metodoPago',
                'moneda',
                'codigoSat',
            ])->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Vista de impresión pendiente de implementar',
                'data'    => $pago,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => 'Pago no encontrado',
            ], 404);
        }
    }

    // ============================================================
    // LAYOUT DE PAGOS
    // ============================================================

    /**
     * Genera un layout a partir de un rango de pagos seleccionados.
     * POST /admin/api/layouts/generar
     */
    public function generarLayout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha'              => 'required|date',
            'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
            'referencia'         => 'nullable|string|max:100',
            'tipo_cambio'        => 'nullable|numeric|min:0',
            'pago_ids'           => 'required|array|min:1',
            'pago_ids.*'         => 'exists:pagos,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $pagos = Pago::with(['proveedor', 'cuentaBancaria.banco'])
                ->whereIn('id', $request->pago_ids)
                ->get();

            if ($pagos->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron pagos para el layout',
                ], 422);
            }

            $cuenta = CuentaBancaria::with('banco')->find($request->cuenta_bancaria_id);

            $layout = LayoutPago::create([
                'folio'              => LayoutPago::generarFolio(),
                'fecha'              => $request->fecha,
                'cuenta_nombre'      => $cuenta->nombre_cuenta ?? ($cuenta->banco->nombre ?? 'CUENTA'),
                'estatus'            => 'activo',
                'referencia'         => $request->referencia,
                'moneda'             => 'MXN',
                'tipo_cambio'        => $request->tipo_cambio ?? 1,
                'monto_total'        => $pagos->sum('monto'),
                'tipo_programacion'  => 'Programacion de Pagos',
                'descripcion'        => 'N',
                'cuenta_bancaria_id' => $request->cuenta_bancaria_id,
                'created_by'         => auth()->id(),
            ]);

            foreach ($pagos as $pago) {
                LayoutPagoDetalle::create([
                    'layout_pago_id'   => $layout->id,
                    'pago_id'          => $pago->id,
                    'programacion'     => (string) $layout->id,
                    'referencia'       => $request->referencia ?? 'prueba',
                    'fecha'            => $request->fecha,
                    'proveedor_nombre' => $pago->proveedor->nombre ?? $pago->proveedor_nombre ?? 'SIN PROVEEDOR',
                    'monto'            => $pago->monto,
                    'banco'            => $cuenta->banco->nombre ?? 'N/A',
                    'estatus'          => 'PROCESO COMPLETO',
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Layout generado exitosamente',
                'data'    => $layout->load('detalles'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al generar layout: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Listado de layouts generados.
     */
    public function getLayouts()
    {
        $layouts = LayoutPago::withCount('detalles')
            ->orderBy('fecha', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $layouts,
        ]);
    }

    /**
     * Detalle JSON de un layout.
     */
    public function verLayout($id)
    {
        $layout = LayoutPago::with([
            'detalles',
            'cuenta.banco',
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $layout,
        ]);
    }

    /**
     * Vista HTML imprimible del layout.
     */
    public function verLayoutHtml($id)
    {
        $layout = LayoutPago::with(['detalles', 'cuenta.banco'])->findOrFail($id);

        return view('administracion.tesoreria.layout_pago_print', compact('layout'));
    }
}