<?php

namespace App\Http\Controllers\Facturacion;

use App\Http\Controllers\Controller;
use App\Models\Facturacion\Factura;
use App\Models\Facturacion\CFDI;
use App\Models\Facturacion\FacturaConcepto;
use App\Models\Facturacion\Contacto;
use App\Models\Facturacion\CatSerie;
use App\Models\Facturacion\CatSucursal;
use App\Models\Facturacion\FacturaRelacionado;
use App\Models\Facturacion\BitacoraFactura;
use App\Models\Facturacion\SatcatFormaPago;
use App\Models\Facturacion\SatcatMetodoPago;
use App\Models\Facturacion\SatcatUsoCfdi;
use App\Models\Facturacion\SatcatRegimenFiscal;
use App\Models\Facturacion\CatMoneda;
use App\Models\Proyecto;
use App\Models\ProyectoPartida;
use App\Models\Articulo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use QrCode;
use SimpleXMLElement;

class FacturaController extends Controller
{
    const ORIGEN_POLIZA = 2;

    // Estatus
    const ESTATUS_PENDIENTE = 1;
    const ESTATUS_TIMBRANDO = 10;
    const ESTATUS_TIMBRADA  = 19;
    const ESTATUS_CANCELADA = 21;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexView()
    {
        return view('facturacion.index');
    }

    /**
     * Obtener datos para la tabla de facturación
     */
    public function getData(Request $request)
    {
        try {
            $query = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->leftJoin('proyectos as p', 'f.proyecto_id', '=', 'p.id')
                ->leftJoin('cfdi as cf', 'f.factura_id', '=', 'cf.factura_id')
                ->whereNull('f.deleted_at')
                ->whereIn('f.tipo_comprobante', ['I', 'E'])
                ->select(
                    'f.factura_id', 'f.folio', 'f.fecha', 'f.fecha_vencimiento',
                    'f.estatus', 'f.subtotal', 'f.iva', 'f.total',
                    'f.cat_monedas_clave as moneda', 'f.tipo_cambio',
                    'f.observaciones', 'f.tipo_comprobante',
                    'f.satcat_metodos_pago_clave', 'f.satcat_formas_pago_clave',
                    'f.satcat_uso_cfdi_clave',
                    'f.retencion_iva', 'f.retencion_isr', 'f.retencion_garantia',
                    'f.nota_venta_id', 'f.nota_venta_folio', 'f.factura_origen_id',
                    'f.created_at',
                    'cf.timbrefiscaldigitalUUID as uuid',
                    'cf.timbrefiscaldigitalFechaTimbrado as fecha_timbrado',
                    'cs.serie',
                    'c.razon_social as cliente_nombre',
                    'c.rfc as cliente_rfc',
                    'p.nombre as projeto_nombre',
                    'p.codigo as projeto_codigo'
                );

            if ($request->filled('fecha_inicio')) $query->whereDate('f.fecha', '>=', $request->fecha_inicio);
            if ($request->filled('fecha_fin'))    $query->whereDate('f.fecha', '<=', $request->fecha_fin);
            if ($request->filled('estatus'))      $query->where('f.estatus', $request->estatus);

            if ($request->filled('search')) {
                $search = trim($request->search);
                $query->where(function ($q) use ($search) {
                    $q->where('f.folio', 'like', "%{$search}%")
                      ->orWhere('c.razon_social', 'like', "%{$search}%")
                      ->orWhere('c.rfc', 'like', "%{$search}%")
                      ->orWhere('cf.timbrefiscaldigitalUUID', 'like', "%{$search}%");
                });
            }

            $facturas = $query->orderBy('f.fecha', 'desc')->get();

            $estatusMap = [
                self::ESTATUS_PENDIENTE => 'pendiente',
                self::ESTATUS_TIMBRANDO => 'timbrando',
                self::ESTATUS_TIMBRADA  => 'timbrada',
                self::ESTATUS_CANCELADA => 'cancelada',
            ];

            foreach ($facturas as $factura) {
                if (!$factura->subtotal && $factura->total) $factura->subtotal = $factura->total / 1.16;
                if (!$factura->iva && $factura->subtotal)   $factura->iva = $factura->subtotal * 0.16;

                $factura->total_mxn = ($factura->moneda !== 'MXN' && $factura->tipo_cambio > 0)
                    ? $factura->total * $factura->tipo_cambio
                    : $factura->total;

                $factura->estatus_texto = $estatusMap[$factura->estatus] ?? 'pendiente';
            }

            $stats = [
                'total'      => $facturas->count(),
                'activas'    => $facturas->where('estatus_texto', 'timbrada')->count(),
                'pagadas'    => 0,
                'canceladas' => $facturas->where('estatus_texto', 'cancelada')->count(),
            ];

            return response()->json([
                'success'    => true,
                'data'       => $facturas,
                'stats'      => $stats,
                'total_rows' => $facturas->count(),
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getData: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data'    => [],
                'stats'   => ['total' => 0, 'activas' => 0, 'pagadas' => 0, 'canceladas' => 0],
            ], 500);
        }
    }

    public function getProyectosActivos()
    {
        try {
            return response()->json(
                DB::table('proyectos')->where('status', 'activo')->whereNull('deleted_at')
                    ->select('id', 'codigo', 'nombre')->orderBy('codigo')->get()
            );
        } catch (\Exception $e) { return response()->json([]); }
    }

    public function getClientes()
    {
        try {
            return response()->json(
                DB::table('contactos')->where('estatus', true)->whereNull('deleted_at')
                    ->where(function ($q) { $q->where('tipo', 'cliente')->orWhere('tipo', 'ambos'); })
                    ->select('contacto_id', 'razon_social', 'rfc', 'satcat_regimen_fiscal_clave')
                    ->orderBy('razon_social')->get()
            );
        } catch (\Exception $e) { return response()->json([]); }
    }

    public function getSeriesActivas()
    {
        try {
            return response()->json(
                DB::table('cat_series')->where('activo', true)
                    ->select('cat_serie_id', 'serie', 'descripcion', 'folio_actual', 'folio_final', 'cat_tipo_comprobante')
                    ->orderBy('serie')->get()
            );
        } catch (\Exception $e) { return response()->json([]); }
    }

    public function getSeriesNotaCredito()
    {
        try {
            $series = DB::table('cat_series')->where('activo', true)
                ->where('cat_tipo_comprobante', 'E')
                ->select('cat_serie_id', 'serie', 'descripcion', 'folio_actual', 'folio_final')
                ->orderBy('serie')->get();

            if ($series->isEmpty()) {
                return response()->json([[
                    'cat_serie_id' => 10, 'serie' => 'NC', 'descripcion' => 'Notas de Crédito',
                    'folio_actual' => 0, 'folio_final' => 99999
                ]]);
            }
            return response()->json($series);
        } catch (\Exception $e) {
            return response()->json([[
                'cat_serie_id' => 10, 'serie' => 'NC', 'descripcion' => 'Notas de Crédito',
                'folio_actual' => 0, 'folio_final' => 99999
            ]]);
        }
    }

    public function getFacturasParaNotaCredito(Request $request)
    {
        try {
            $query = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->where('f.estatus', self::ESTATUS_TIMBRADA)
                ->where('f.tipo_comprobante', 'I')
                ->whereNull('f.deleted_at')
                ->select('f.factura_id', 'f.folio', 'f.fecha', 'f.total', 'f.subtotal', 'f.saldo_disponible',
                         'cs.serie', 'c.razon_social as cliente_nombre', 'c.rfc as cliente_rfc', 'c.contacto_id');

            if ($request->cliente_id) $query->where('f.contacto_id', $request->cliente_id);

            $facturas = $query->orderBy('f.fecha', 'desc')->get();

            foreach ($facturas as $factura) {
                $notasAplicadas = DB::table('facturas')
                    ->where('factura_relacionada_id', $factura->factura_id)
                    ->where('tipo_comprobante', 'E')->where('estatus', self::ESTATUS_TIMBRADA)->sum('total');

                $factura->saldo_restante = $factura->saldo_disponible ?? ($factura->total - abs($notasAplicadas));
                $factura->total_notas_aplicadas = abs($notasAplicadas);
            }

            return response()->json($facturas->filter(fn($f) => $f->saldo_restante > 0)->values());
        } catch (\Exception $e) {
            Log::error('Error en getFacturasParaNotaCredito: ' . $e->getMessage());
            return response()->json([]);
        }
    }

    public function getSiguienteFolio($id)
    {
        try {
            $serie = DB::table('cat_series')->where('cat_serie_id', $id)->first();
            if (!$serie) return response()->json(['folio' => '000001']);
            return response()->json(['folio' => str_pad(intval($serie->folio_actual) + 1, 6, '0', STR_PAD_LEFT)]);
        } catch (\Exception $e) { return response()->json(['folio' => '000001']); }
    }

    public function getUsosCFDI()
    {
        try {
            $usos = DB::table('satcat_uso_cfdi')->where('estatus', true)->select('clave', 'descripcion')->orderBy('clave')->get();
            if ($usos->isEmpty()) {
                return response()->json([
                    ['clave' => 'G01', 'descripcion' => 'Adquisición de mercancías'],
                    ['clave' => 'G03', 'descripcion' => 'Gastos en general'],
                    ['clave' => 'S01', 'descripcion' => 'Sin efectos fiscales'],
                ]);
            }
            return response()->json($usos);
        } catch (\Exception $e) {
            return response()->json([['clave' => 'G01', 'descripcion' => 'Adquisición de mercancías']]);
        }
    }

    public function getFormasPago()
    {
        try {
            $formas = DB::table('satcat_formas_pago')->where('estatus', true)->select('clave', 'descripcion')->orderBy('clave')->get();
            if ($formas->isEmpty()) {
                return response()->json([
                    ['clave' => '01', 'descripcion' => 'Efectivo'],
                    ['clave' => '03', 'descripcion' => 'Transferencia electrónica de fondos'],
                ]);
            }
            return response()->json($formas);
        } catch (\Exception $e) { return response()->json([['clave' => '01', 'descripcion' => 'Efectivo']]); }
    }

    public function getMetodosPago()
    {
        try {
            $metodos = DB::table('satcat_metodos_pago')->where('estatus', true)->select('clave', 'descripcion')->orderBy('clave')->get();
            if ($metodos->isEmpty()) {
                return response()->json([
                    ['clave' => 'PUE', 'descripcion' => 'Pago en una sola exhibición'],
                    ['clave' => 'PPD', 'descripcion' => 'Pago en parcialidades o diferido'],
                ]);
            }
            return response()->json($metodos);
        } catch (\Exception $e) {
            return response()->json([['clave' => 'PUE', 'descripcion' => 'Pago en una sola exhibición']]);
        }
    }

    public function getClavesProductoServicio(Request $request)
    {
        try {
            $query = DB::table('satcat_clave_productos_servicios')->select('clave', 'descripcion');
            if ($request->search) {
                $query->where(function ($q) use ($request) {
                    $q->where('clave', 'like', "%{$request->search}%")
                      ->orWhere('descripcion', 'like', "%{$request->search}%");
                });
            }
            return response()->json($query->orderBy('clave')->limit(300)->get());
        } catch (\Exception $e) {
            return response()->json([
                ['clave' => '84111500', 'descripcion' => 'Servicios de contabilidad y auditoría'],
                ['clave' => '80111600', 'descripcion' => 'Servicios de construcción'],
            ]);
        }
    }

    public function getClavesUnidadMedida(Request $request)
    {
        try {
            $query = DB::table('satcat_unidades')->select('clave', 'descripcion');
            if ($request->search) {
                $query->where(function ($q) use ($request) {
                    $q->where('clave', 'like', "%{$request->search}%")
                      ->orWhere('descripcion', 'like', "%{$request->search}%");
                });
            }
            return response()->json($query->orderBy('clave')->limit(300)->get());
        } catch (\Exception $e) {
            return response()->json([
                ['clave' => 'ACT', 'descripcion' => 'Actividad'],
                ['clave' => 'E48', 'descripcion' => 'Unidad de servicio'],
            ]);
        }
    }

    public function getNotasVentaDisponibles(Request $request)
    {
        try {
            if (!Schema::hasTable('notas_venta')) return response()->json([]);

            $query = DB::table('notas_venta as nv')
                ->leftJoin('contactos as c', 'nv.contacto_id', '=', 'c.contacto_id')
                ->select('nv.id', 'nv.folio', 'nv.fecha', 'nv.total', 'nv.estatus', 'nv.contacto_id',
                         'c.razon_social as cliente_nombre');

            if (Schema::hasColumn('notas_venta', 'facturada')) {
                $query->where(function ($q) { $q->where('nv.facturada', false)->orWhereNull('nv.facturada'); });
            }
            if ($request->filled('contacto_id')) $query->where('nv.contacto_id', $request->contacto_id);

            return response()->json($query->orderBy('nv.fecha', 'desc')->limit(200)->get());
        } catch (\Exception $e) {
            Log::warning('Error getNotasVentaDisponibles: ' . $e->getMessage());
            return response()->json([]);
        }
    }

    /**
     * Guardar nueva factura.
     *
     * Flujo:
     *  1. Se guarda en BD con estatus 1 (pendiente) o 10 (timbrando) dentro de una transacción.
     *  2. Al hacer commit, si el usuario pidió timbrar, se llama al PAC FUERA de la transacción
     *     porque el timbrado puede tardar y queremos evitar locks prolongados.
     *  3. Si el timbrado falla, la factura queda en estatus 1 (pendiente) para poder reintentar.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'contacto_id'               => 'required',
                'cat_serie_id'              => 'required',
                'fecha'                     => 'required|date',
                'conceptos'                 => 'required|array|min:1',
                'conceptos.*.descripcion'   => 'required',
                'conceptos.*.cantidad'      => 'required|numeric|min:0.0001',
                'conceptos.*.valorUnitario' => 'required|numeric|min:0',
                'conceptos.*.estimacion_id' => 'nullable|exists:estimaciones_partidas,id',
                'conceptos.*.partida_id'    => 'nullable|exists:proyecto_partidas,id',
            ]);

            $serie = DB::table('cat_series')->where('cat_serie_id', $request->cat_serie_id)->first();
            if (!$serie) throw new \Exception('Serie no encontrada');
            $folio = str_pad(($serie->folio_actual ?? 0) + 1, 6, '0', STR_PAD_LEFT);

            $sucursalDefault = DB::table('cat_sucursales')->where('estatus', true)->first();
            $catSucursalId = $sucursalDefault->cat_sucursal_id ?? 1;

            $contacto = DB::table('contactos')->where('contacto_id', $request->contacto_id)->first();
            if (!$contacto) throw new \Exception('Cliente no encontrado');

            $satcatUsoCfdiClave       = $request->satcat_uso_cfdi_clave        ?? 'G01';
            $satcatFormasPagoClave    = $request->satcat_formas_pago_clave     ?? '01';
            $satcatMetodosPagoClave   = $request->satcat_metodos_pago_clave    ?? 'PUE';
            $satcatRegimenFiscalClave = $contacto->satcat_regimen_fiscal_clave ?? '601';
            $tipoComprobante          = $request->tipo_comprobante             ?? 'I';

            $subtotal = 0; $totalDescuento = 0; $ivaTotal = 0;
            $retencionIva      = (float) ($request->retencion_iva      ?? 0);
            $retencionIsr      = (float) ($request->retencion_isr      ?? 0);
            $retencionGarantia = (float) ($request->retencion_garantia ?? 0);

            foreach ($request->conceptos as $concepto) {
                $importe   = $concepto['cantidad'] * $concepto['valorUnitario'];
                $descuento = (float) ($concepto['descuento'] ?? 0);
                $subtotal       += $importe;
                $totalDescuento += $descuento;
                $ivaTotal       += ($importe - $descuento) * 0.16;
            }

            $total = ($subtotal - $totalDescuento) + $ivaTotal - $retencionIva - $retencionIsr - $retencionGarantia;

            $estatusInicial = $request->timbrar ? self::ESTATUS_TIMBRANDO : self::ESTATUS_PENDIENTE;

            $notaVentaId    = $request->nota_venta_id    ?? null;
            $notaVentaFolio = $request->nota_venta_folio ?? null;
            if ($notaVentaId && !$notaVentaFolio && Schema::hasTable('notas_venta')) {
                $nv = DB::table('notas_venta')->where('id', $notaVentaId)->first();
                if ($nv) $notaVentaFolio = $nv->folio ?? null;
            }

            // Validación re-factura
            if ($request->filled('factura_origen_id')) {
                $origen = DB::table('facturas')->where('factura_id', $request->factura_origen_id)->whereNull('deleted_at')->first();
                if (!$origen) throw new \Exception('Factura origen no encontrada');
                if ((int) $origen->estatus !== self::ESTATUS_CANCELADA) {
                    throw new \Exception('Solo se puede re-facturar una factura cancelada (estatus 21)');
                }
                $yaRefacturada = DB::table('facturas')
                    ->where('factura_origen_id', $request->factura_origen_id)
                    ->whereNull('deleted_at')->exists();
                if ($yaRefacturada) throw new \Exception('Esta factura ya tiene una re-factura asociada');
            }

            $facturaId = DB::table('facturas')->insertGetId([
                'contacto_id'                 => $request->contacto_id,
                'proyecto_id'                 => $request->proyecto_id,
                'cat_serie_id'                => $request->cat_serie_id,
                'cat_sucursal_id'             => $catSucursalId,
                'folio'                       => $folio,
                'fecha'                       => $request->fecha,
                'fecha_vencimiento'           => $request->fecha_vencimiento,
                'cat_monedas_clave'           => $request->moneda ?? 'MXN',
                'tipo_cambio'                 => $request->tipo_cambio ?? 1,
                'subtotal'                    => $subtotal,
                'descuento'                   => $totalDescuento,
                'iva'                         => $ivaTotal,
                'retencion_iva'               => $retencionIva,
                'retencion_isr'               => $retencionIsr,
                'retencion_garantia'          => $retencionGarantia,
                'total'                       => $total,
                'saldo_disponible'            => $total,
                'satcat_uso_cfdi_clave'       => $satcatUsoCfdiClave,
                'satcat_formas_pago_clave'    => $satcatFormasPagoClave,
                'satcat_metodos_pago_clave'   => $satcatMetodosPagoClave,
                'satcat_regimen_fiscal_clave' => $satcatRegimenFiscalClave,
                'tipo_comprobante'            => $tipoComprobante,
                'observaciones'               => $request->observaciones,
                'factura_origen_id'           => $request->factura_origen_id ?? null,
                'nota_venta_id'               => $notaVentaId,
                'nota_venta_folio'            => $notaVentaFolio,
                'estatus'                     => $estatusInicial,
                'created_by'                  => Auth::id(),
                'created_at'                  => now(),
                'updated_at'                  => now(),
            ], 'factura_id');

            foreach ($request->conceptos as $concepto) {
                $importe   = $concepto['cantidad'] * $concepto['valorUnitario'];
                $descuento = (float) ($concepto['descuento'] ?? 0);
                $base      = $importe - $descuento;

                DB::table('facturas_conceptos')->insert([
                    'factura_id'                    => $facturaId,
                    'estimacion_id'                 => $concepto['estimacion_id'] ?? null,
                    'partida_id'                    => $concepto['partida_id'] ?? null,
                    'descripcion'                   => $concepto['descripcion'],
                    'observaciones'                 => $concepto['observaciones'] ?? null,
                    'cantidad'                      => $concepto['cantidad'],
                    'satcat_unidades_clave'         => $concepto['unidad_sat']   ?? 'ACT',
                    'satcat_clave_productos_clave'  => $concepto['producto_sat'] ?? '84111500',
                    'valor_unitario'                => $concepto['valorUnitario'],
                    'descuento'                     => $descuento,
                    'importe'                       => $importe,
                    'subtotal'                      => $base,
                    'iva'                           => $base * 0.16,
                    'tasa_iva'                      => 16.0000,
                    'created_at'                    => now(),
                    'updated_at'                    => now(),
                ]);
            }

            DB::table('cat_series')
                ->where('cat_serie_id', $request->cat_serie_id)
                ->update(['folio_actual' => ($serie->folio_actual ?? 0) + 1]);

            if ($notaVentaId && Schema::hasTable('notas_venta') && Schema::hasColumn('notas_venta', 'facturada')) {
                DB::table('notas_venta')->where('id', $notaVentaId)->update([
                    'facturada'  => true,
                    'factura_id' => $facturaId,
                ]);
            }

            DB::commit();

            $response = [
                'success'    => true,
                'message'    => 'Factura guardada correctamente',
                'factura_id' => $facturaId,
                'estatus'    => self::ESTATUS_PENDIENTE,
            ];

            // Timbrado real fuera de la transacción
            if ($request->timbrar) {
                $factura = Factura::find($facturaId);
                $timbrado = app(TimbradoController::class)->timbrarFactura($factura);

                if ($timbrado['success']) {
                    $response['message']  = 'Factura timbrada correctamente';
                    $response['estatus']  = self::ESTATUS_TIMBRADA;
                    $response['uuid']     = $timbrado['uuid'];
                    $response['timbrado'] = true;
                } else {
                    DB::table('facturas')->where('factura_id', $facturaId)
                        ->update(['estatus' => self::ESTATUS_PENDIENTE, 'updated_at' => now()]);
                    $response['message']        = 'Factura guardada, pero el timbrado falló: ' . $timbrado['error'];
                    $response['estatus']        = self::ESTATUS_PENDIENTE;
                    $response['timbrado']       = false;
                    $response['timbrado_error'] = $timbrado['error'];
                }
            }

            return response()->json($response);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error de validación', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al guardar factura: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al guardar: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Timbrar una factura existente (estatus 1 o 10).
     * Delega el trabajo al TimbradoController (PAC real).
     */
    public function timbrarFactura(Request $request, $id)
    {
        try {
            $factura = Factura::find($id);
            if (!$factura) {
                return response()->json(['success' => false, 'message' => 'Factura no encontrada'], 404);
            }

            if ((int) $factura->estatus === self::ESTATUS_TIMBRADA) {
                return response()->json(['success' => false, 'message' => 'La factura ya está timbrada'], 422);
            }
            if ((int) $factura->estatus === self::ESTATUS_CANCELADA) {
                return response()->json(['success' => false, 'message' => 'La factura está cancelada'], 422);
            }

            // Marcar como "timbrando" mientras se procesa (evita doble click)
            DB::table('facturas')->where('factura_id', $id)->update([
                'estatus' => self::ESTATUS_TIMBRANDO,
                'updated_at' => now(),
            ]);

            $timbrado = app(TimbradoController::class)->timbrarFactura($factura);

            if (!$timbrado['success']) {
                // Devolver a pendiente para permitir reintentar
                DB::table('facturas')->where('factura_id', $id)->update([
                    'estatus' => self::ESTATUS_PENDIENTE,
                    'updated_at' => now(),
                ]);
                return response()->json([
                    'success' => false,
                    'message' => $timbrado['error'],
                ], 500);
            }

            return response()->json([
                'success' => true,
                'uuid'    => $timbrado['uuid'],
                'message' => 'Factura timbrada correctamente',
                'estatus' => self::ESTATUS_TIMBRADA,
            ]);

        } catch (\Exception $e) {
            Log::error('Error al timbrar factura #' . $id . ': ' . $e->getMessage());
            // Devolver a pendiente si quedó atorada
            DB::table('facturas')->where('factura_id', $id)->update([
                'estatus' => self::ESTATUS_PENDIENTE,
                'updated_at' => now(),
            ]);
            return response()->json(['success' => false, 'message' => 'Error al timbrar: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Cancelar una factura timbrada (estatus 19 → 21).
     * Delega el trabajo al TimbradoController (PAC real, por CSD en Base64).
     */
    public function cancelarFactura(Request $request, $id)
    {
        try {
            $factura = Factura::find($id);
            if (!$factura) {
                return response()->json(['success' => false, 'message' => 'Factura no encontrada'], 404);
            }
            if ((int) $factura->estatus === self::ESTATUS_CANCELADA) {
                return response()->json(['success' => false, 'message' => 'La factura ya está cancelada'], 422);
            }
            if ((int) $factura->estatus !== self::ESTATUS_TIMBRADA) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden cancelar facturas timbradas (estatus 19)',
                ], 422);
            }

            // No se puede cancelar si ya tiene re-factura
            $refactura = DB::table('facturas')->where('factura_origen_id', $id)->whereNull('deleted_at')->first();
            if ($refactura) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede cancelar: ya tiene una re-factura asociada (#'
                        . $refactura->factura_id . '). Cancela primero la re-factura.',
                ], 422);
            }

            $motivo           = $request->input('motivo_sat', '02');
            $folioSustitucion = $request->input('folio_sustitucion');
            $motivoTexto      = $request->input('motivo', '');

            $cancelacion = app(TimbradoController::class)->cancelarFactura($factura, $motivo, $folioSustitucion);

            if (!$cancelacion['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $cancelacion['error'],
                ], 500);
            }

            // Bitácora
            if (Schema::hasTable('bitacora_factura')) {
                DB::table('bitacora_factura')->insert([
                    'factura_id' => $id,
                    'accion'     => 'cancelacion',
                    'detalle'    => json_encode([
                        'motivo'            => $motivoTexto,
                        'motivo_sat'        => $motivo,
                        'folio_sustitucion' => $folioSustitucion,
                        'codigo_sat'        => $cancelacion['codigo'] ?? null,
                        'user_id'           => Auth::id(),
                        'fecha'             => now()->toDateTimeString(),
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Guardar acuse
            if (!empty($cancelacion['acuse'])) {
                Storage::put("acuses_cancelacion/{$factura->factura_id}.xml", base64_decode($cancelacion['acuse']));
            }

            // Nota en observaciones
            $facturaActual = DB::table('facturas')->where('factura_id', $id)->first();
            $nuevaObs = trim(($facturaActual->observaciones ?? '') . "\n[CANCELADA " . now()->format('Y-m-d H:i') . "] " . $motivoTexto);
            DB::table('facturas')->where('factura_id', $id)->update(['observaciones' => $nuevaObs]);

            return response()->json([
                'success' => true,
                'message' => 'Factura cancelada correctamente',
                'codigo'  => $cancelacion['codigo'] ?? null,
                'estatus' => self::ESTATUS_CANCELADA,
            ]);

        } catch (\Exception $e) {
            Log::error('Error al cancelar factura #' . $id . ': ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al cancelar: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $factura = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->leftJoin('cfdi as cf', 'f.factura_id', '=', 'cf.factura_id')
                ->where('f.factura_id', $id)
                ->select('f.*', 'c.razon_social as cliente_nombre', 'c.rfc as cliente_rfc', 'cs.serie',
                         'cf.timbrefiscaldigitalUUID as uuid')
                ->first();

            if (!$factura) {
                return response()->json(['success' => false, 'message' => 'Factura no encontrada'], 404);
            }

            $conceptos = DB::table('facturas_conceptos')->where('factura_id', $id)->get();

            return response()->json(['success' => true, 'data' => $factura, 'conceptos' => $conceptos]);
        } catch (\Exception $e) {
            Log::error('Error en show: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $factura = DB::table('facturas')->where('factura_id', $id)->first();
            if (!$factura) return response()->json(['success' => false, 'message' => 'Factura no encontrada'], 404);
            if ((int) $factura->estatus === self::ESTATUS_TIMBRADA) {
                return response()->json(['success' => false, 'message' => 'No se puede editar una factura timbrada'], 422);
            }

            $notaVentaId    = $request->nota_venta_id    ?? $factura->nota_venta_id;
            $notaVentaFolio = $request->nota_venta_folio ?? $factura->nota_venta_folio;
            if ($notaVentaId && !$notaVentaFolio && Schema::hasTable('notas_venta')) {
                $nv = DB::table('notas_venta')->where('id', $notaVentaId)->first();
                if ($nv) $notaVentaFolio = $nv->folio ?? null;
            }

            $updateData = [
                'contacto_id'                 => $request->contacto_id ?? $factura->contacto_id,
                'proyecto_id'                 => $request->proyecto_id,
                'fecha'                       => $request->fecha ?? $factura->fecha,
                'fecha_vencimiento'           => $request->fecha_vencimiento,
                'cat_monedas_clave'           => $request->moneda ?? $factura->cat_monedas_clave,
                'tipo_cambio'                 => $request->tipo_cambio ?? $factura->tipo_cambio,
                'satcat_uso_cfdi_clave'       => $request->satcat_uso_cfdi_clave       ?? $factura->satcat_uso_cfdi_clave,
                'satcat_formas_pago_clave'    => $request->satcat_formas_pago_clave    ?? $factura->satcat_formas_pago_clave,
                'satcat_metodos_pago_clave'   => $request->satcat_metodos_pago_clave   ?? $factura->satcat_metodos_pago_clave,
                'tipo_comprobante'            => $request->tipo_comprobante            ?? $factura->tipo_comprobante,
                'observaciones'               => $request->observaciones,
                'retencion_iva'               => $request->retencion_iva      ?? 0,
                'retencion_isr'               => $request->retencion_isr      ?? 0,
                'retencion_garantia'          => $request->retencion_garantia ?? 0,
                'nota_venta_id'               => $notaVentaId,
                'nota_venta_folio'            => $notaVentaFolio,
                'factura_origen_id'           => $request->factura_origen_id ?? $factura->factura_origen_id,
                'updated_at'                  => now(),
            ];

            if ($request->has('conceptos') && is_array($request->conceptos)) {
                $subtotal = 0; $totalDescuento = 0; $ivaTotal = 0;
                foreach ($request->conceptos as $c) {
                    $importe   = $c['cantidad'] * $c['valorUnitario'];
                    $descuento = (float) ($c['descuento'] ?? 0);
                    $subtotal += $importe;
                    $totalDescuento += $descuento;
                    $ivaTotal += ($importe - $descuento) * 0.16;
                }
                $retIva = (float) ($request->retencion_iva      ?? 0);
                $retIsr = (float) ($request->retencion_isr      ?? 0);
                $retGar = (float) ($request->retencion_garantia ?? 0);
                $total = ($subtotal - $totalDescuento) + $ivaTotal - $retIva - $retIsr - $retGar;

                $updateData['subtotal']         = $subtotal;
                $updateData['descuento']        = $totalDescuento;
                $updateData['iva']              = $ivaTotal;
                $updateData['total']            = $total;
                $updateData['saldo_disponible'] = $total;

                DB::table('facturas_conceptos')->where('factura_id', $id)->delete();
                foreach ($request->conceptos as $c) {
                    $importe   = $c['cantidad'] * $c['valorUnitario'];
                    $descuento = (float) ($c['descuento'] ?? 0);
                    $base      = $importe - $descuento;
                    DB::table('facturas_conceptos')->insert([
                        'factura_id'                    => $id,
                        'estimacion_id'                 => $c['estimacion_id'] ?? null,
                        'partida_id'                    => $c['partida_id'] ?? null,
                        'descripcion'                   => $c['descripcion'],
                        'observaciones'                 => $c['observaciones'] ?? null,
                        'cantidad'                      => $c['cantidad'],
                        'satcat_unidades_clave'         => $c['unidad_sat']   ?? 'ACT',
                        'satcat_clave_productos_clave'  => $c['producto_sat'] ?? '84111500',
                        'valor_unitario'                => $c['valorUnitario'],
                        'descuento'                     => $descuento,
                        'importe'                       => $importe,
                        'subtotal'                      => $base,
                        'iva'                           => $base * 0.16,
                        'tasa_iva'                      => 16.0000,
                        'created_at'                    => now(),
                        'updated_at'                    => now(),
                    ]);
                }
            }

            DB::table('facturas')->where('factura_id', $id)->update($updateData);
            DB::commit();

            if ($request->boolean('timbrar') && (int) $factura->estatus !== self::ESTATUS_TIMBRADA) {
                return $this->timbrarFactura($request, $id);
            }

            return response()->json(['success' => true, 'message' => 'Factura actualizada']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar factura: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('facturas')->where('factura_id', $id)->update(['deleted_at' => now()]);
            return response()->json(['status' => 'ok', 'message' => 'Factura eliminada']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function edit($id) { return $this->show($id); }
    public function create() { return response()->json(['status' => 'ok']); }
    public function enviarCorreo($id) { return response()->json(['status' => 'ok', 'message' => 'Correo enviado']); }

    public function pdf($id)
    {
        try {
            $factura = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->leftJoin('cfdi as cf', 'f.factura_id', '=', 'cf.factura_id')
                ->where('f.factura_id', $id)
                ->select('f.*', 'c.razon_social as cliente_nombre', 'c.rfc as cliente_rfc', 'cs.serie',
                         'cf.timbrefiscaldigitalUUID as uuid')
                ->first();

            if (!$factura) abort(404, 'Factura no encontrada');

            $conceptos = DB::table('facturas_conceptos')->where('factura_id', $id)->get();

            return view('pdfs.factura', [
                'factura'     => $factura,
                'conceptos'   => $conceptos,
                'total_letra' => $this->numeroALetras($factura->total),
            ]);
        } catch (\Exception $e) {
            Log::error('Error al generar PDF: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function downloadXml($id)
    {
        try {
            $factura = DB::table('facturas')->where('factura_id', $id)->first();
            if (!$factura) abort(404, 'Factura no encontrada');

            // Si ya está timbrada, devolver el XML real del CFDI
            $cfdi = DB::table('cfdi')->where('factura_id', $id)->first();
            if ($cfdi && !empty($factura->xml)) {
                $filename = 'Factura_' . $factura->folio . '.xml';
                return response($factura->xml, 200)
                    ->header('Content-Type', 'application/xml')
                    ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
            }

            // Si no, XML de vista previa
            $facturaFull = DB::table('facturas as f')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->where('f.factura_id', $id)
                ->select('f.*', 'cs.serie', 'c.razon_social as cliente_nombre', 'c.rfc')
                ->first();

            $conceptos = DB::table('facturas_conceptos')->where('factura_id', $id)->get();
            $xml = $this->generarXMLPreview($facturaFull, $conceptos);

            return response($xml, 200)
                ->header('Content-Type', 'application/xml')
                ->header('Content-Disposition', 'attachment; filename="Factura_preview_' . $id . '.xml"');

        } catch (\Exception $e) {
            Log::error('Error al generar XML: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function generarXMLPreview($factura, $conceptos)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<cfdi:Comprobante xmlns:cfdi="http://www.sat.gob.mx/cfd/4" 
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" Version="4.0" 
            Serie="' . htmlspecialchars($factura->serie ?? '') . '" 
            Folio="' . htmlspecialchars($factura->folio ?? '') . '" 
            Fecha="' . $factura->fecha . 'T12:00:00" 
            Moneda="' . ($factura->cat_monedas_clave ?? 'MXN') . '" 
            SubTotal="' . number_format($factura->subtotal, 2, '.', '') . '" 
            Total="' . number_format($factura->total, 2, '.', '') . '" 
            TipoDeComprobante="' . ($factura->tipo_comprobante ?? 'I') . '" 
            MetodoPago="' . ($factura->satcat_metodos_pago_clave ?? 'PUE') . '" 
            FormaPago="' . ($factura->satcat_formas_pago_clave ?? '01') . '" 
            Exportacion="01" LugarExpedicion="64000" 
            xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd">';
        $xml .= '<cfdi:Emisor Rfc="XAXX010101000" Nombre="PREVIEW" RegimenFiscal="601"/>';
        $xml .= '<cfdi:Receptor Rfc="' . htmlspecialchars($factura->rfc ?? 'XAXX010101000') . '" 
            Nombre="' . htmlspecialchars($factura->cliente_nombre ?? '') . '" 
            DomicilioFiscalReceptor="64000" RegimenFiscalReceptor="616" 
            UsoCFDI="' . ($factura->satcat_uso_cfdi_clave ?? 'G01') . '"/>';

        $xml .= '<cfdi:Conceptos>';
        foreach ($conceptos as $c) {
            $xml .= '<cfdi:Concepto ClaveProdServ="' . ($c->satcat_clave_productos_clave ?? '84111500') . '" 
                Cantidad="' . number_format($c->cantidad, 2, '.', '') . '" 
                ClaveUnidad="' . ($c->satcat_unidades_clave ?? 'ACT') . '" 
                Descripcion="' . htmlspecialchars($c->descripcion) . '" 
                ValorUnitario="' . number_format($c->valor_unitario, 2, '.', '') . '" 
                Importe="' . number_format($c->importe, 2, '.', '') . '" 
                ObjetoImp="02"/>';
        }
        $xml .= '</cfdi:Conceptos>';
        $xml .= '</cfdi:Comprobante>';

        return $xml;
    }

    private function numeroALetras($numero)
    {
        $decimales = round(($numero - floor($numero)) * 100, 0);
        $parteEntera = floor($numero);

        $unidades = ['', 'un', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
        $decenas = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
        $decenasEspeciales = ['once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];
        $centenas = ['', 'cien', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];

        $letras = '';
        $miles = floor($parteEntera / 1000);
        $resto = $parteEntera % 1000;

        if ($miles > 0) {
            $letras .= ($miles == 1) ? 'mil ' :
                $this->convertirTresDigitos($miles, $unidades, $decenas, $decenasEspeciales, $centenas) . ' mil ';
        }
        if ($resto > 0) {
            $letras .= $this->convertirTresDigitos($resto, $unidades, $decenas, $decenasEspeciales, $centenas);
        } elseif ($parteEntera == 0) {
            $letras = 'cero';
        }

        return ucfirst(trim($letras)) . ' pesos ' . str_pad($decimales, 2, '0', STR_PAD_LEFT) . '/100 M.N.';
    }

    private function convertirTresDigitos($numero, $unidades, $decenas, $decenasEspeciales, $centenas)
    {
        $letras = '';
        $cientos = floor($numero / 100);
        $resto = $numero % 100;

        if ($cientos > 0) {
            $letras .= ($cientos == 1 && $resto == 0) ? 'cien ' : $centenas[$cientos] . ' ';
        }
        if ($resto > 0) {
            if ($resto < 10) {
                $letras .= $unidades[$resto] . ' ';
            } elseif ($resto < 20) {
                $letras .= ($resto == 10) ? 'diez ' : $decenasEspeciales[$resto - 11] . ' ';
            } else {
                $decena = floor($resto / 10);
                $unidad = $resto % 10;
                $letras .= $unidad > 0
                    ? $decenas[$decena] . ' y ' . $unidades[$unidad] . ' '
                    : $decenas[$decena] . ' ';
            }
        }
        return $letras;
    }

    // ============================================
    // CATÁLOGO DE SERIES
    // ============================================
    public function getSeriesCatalogo(Request $request)
    {
        try {
            $query = DB::table('cat_series');
            if ($request->filled('search')) {
                $s = $request->search;
                $query->where(function ($q) use ($s) {
                    $q->where('serie', 'like', "%{$s}%")->orWhere('descripcion', 'like', "%{$s}%");
                });
            }
            if ($request->filled('activo')) $query->where('activo', $request->activo);
            return response()->json($query->orderBy('serie')->get());
        } catch (\Exception $e) { return response()->json([]); }
    }

    public function storeSerie(Request $request)
    {
        try {
            $request->validate([
                'serie'                => 'required|string|max:10',
                'descripcion'          => 'required|string|max:191',
                'cat_tipo_comprobante' => 'required|string|in:I,E,T,N,P',
                'folio_actual'         => 'nullable|integer|min:0',
                'folio_final'          => 'nullable|integer|min:0',
            ]);

            $id = DB::table('cat_series')->insertGetId([
                'serie'                => strtoupper($request->serie),
                'descripcion'          => $request->descripcion,
                'cat_tipo_comprobante' => $request->cat_tipo_comprobante,
                'folio_actual'         => $request->folio_actual ?? 0,
                'folio_final'          => $request->folio_final ?? 999999,
                'activo'               => true,
                'created_at'           => now(),
                'updated_at'           => now(),
            ], 'cat_serie_id');

            return response()->json(['success' => true, 'cat_serie_id' => $id]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateSerie(Request $request, $id)
    {
        try {
            DB::table('cat_series')->where('cat_serie_id', $id)->update([
                'serie'                => strtoupper($request->serie),
                'descripcion'          => $request->descripcion,
                'cat_tipo_comprobante' => $request->cat_tipo_comprobante,
                'folio_actual'         => $request->folio_actual,
                'folio_final'          => $request->folio_final,
                'activo'               => $request->activo,
                'updated_at'           => now(),
            ]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroySerie($id)
    {
        try {
            DB::table('cat_series')->where('cat_serie_id', $id)->update(['activo' => false]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ============================================
    // FACTURAS PARA PAGO
    // ============================================
    public function getFacturasParaPago(Request $request)
    {
        try {
            $query = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->where('f.estatus', self::ESTATUS_TIMBRADA)
                ->where('f.tipo_comprobante', 'I')
                ->whereNull('f.deleted_at')
                ->select('f.factura_id', 'f.folio', 'f.fecha', 'f.total', 'f.subtotal', 'f.saldo_disponible',
                         'cs.serie', 'c.razon_social as cliente_nombre', 'c.rfc as cliente_rfc', 'c.contacto_id');

            if ($request->cliente_id) $query->where('f.contacto_id', $request->cliente_id);

            $facturas = $query->orderBy('f.fecha', 'desc')->get();
            $disponibles = [];

            foreach ($facturas as $factura) {
                $notasAplicadas = DB::table('facturas')
                    ->where('factura_relacionada_id', $factura->factura_id)
                    ->where('tipo_comprobante', 'E')->where('estatus', self::ESTATUS_TIMBRADA)->sum('total');

                $pagosAplicados = DB::table('contrarecibo_facturas as cf')
                    ->join('contrarecibos as cr', 'cf.contrarecibo_id', '=', 'cr.contrarecibo_id')
                    ->where('cf.factura_id', $factura->factura_id)
                    ->where('cr.estatus', self::ESTATUS_TIMBRADA)->sum('cf.monto_aplicado');

                $totalAplicado = abs($notasAplicadas) + $pagosAplicados;
                $saldoRestante = $factura->total - $totalAplicado;

                if ($factura->saldo_disponible != $saldoRestante) {
                    DB::table('facturas')->where('factura_id', $factura->factura_id)
                        ->update(['saldo_disponible' => max(0, $saldoRestante)]);
                }

                if ($saldoRestante > 0) {
                    $factura->saldo_restante        = $saldoRestante;
                    $factura->total_notas_aplicadas = $notasAplicadas;
                    $factura->total_pagos_aplicados = $pagosAplicados;
                    $factura->total_aplicado        = $totalAplicado;
                    $disponibles[] = $factura;
                }
            }

            return response()->json($disponibles);
        } catch (\Exception $e) {
            Log::error('Error en getFacturasParaPago: ' . $e->getMessage());
            return response()->json([]);
        }
    }

    public function getFacturasParaRefactura(Request $request)
    {
        try {
            $query = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->whereNull('f.deleted_at')
                ->where('f.tipo_comprobante', 'I')
                ->where('f.estatus', self::ESTATUS_CANCELADA)
                ->select('f.factura_id', 'f.folio', 'f.fecha', 'f.total', 'f.subtotal',
                         'f.estatus', 'f.contacto_id', 'cs.serie',
                         'c.razon_social as cliente_nombre', 'c.rfc as cliente_rfc')
                ->whereNotExists(function ($sub) {
                    $sub->select(DB::raw(1))
                        ->from('facturas as rf')
                        ->whereColumn('rf.factura_origen_id', 'f.factura_id')
                        ->whereNull('rf.deleted_at');
                });

            if ($request->filled('contacto_id')) $query->where('f.contacto_id', $request->contacto_id);

            $facturas = $query->orderBy('f.fecha', 'desc')->limit(200)->get();
            foreach ($facturas as $f) $f->estatus_texto = 'cancelada';

            return response()->json($facturas);
        } catch (\Exception $e) {
            Log::warning('getFacturasParaRefactura: ' . $e->getMessage());
            return response()->json([]);
        }
    }
}