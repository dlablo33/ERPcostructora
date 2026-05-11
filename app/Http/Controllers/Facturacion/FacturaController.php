<?php

namespace App\Http\Controllers\Facturacion;

use App\Http\Controllers\Controller;
use App\Models\Facturacion\Factura;
use App\Models\Facturacion\FacturaConcepto;
use App\Models\Facturacion\Contacto;
use App\Models\Facturacion\CatSerie;
use App\Models\Facturacion\CatSucursal;
use App\Models\Facturacion\CFDI;
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
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use QrCode;
use SimpleXMLElement;

class FacturaController extends Controller
{
    const ORIGEN_POLIZA = 2;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Vista principal del módulo de facturación
     */
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
                ->select(
                    'f.factura_id',
                    'f.folio',
                    'f.fecha',
                    'f.fecha_vencimiento',
                    'f.estatus',
                    'f.subtotal',
                    'f.iva',
                    'f.total',
                    'f.cat_monedas_clave as moneda',
                    'f.tipo_cambio',
                    'f.observaciones',
                    'f.created_at',
                    'cf.timbrefiscaldigitalUUID as uuid',
                    'cf.timbrefiscaldigitalFechaTimbrado as fecha_timbrado',
                    'cs.serie',
                    'c.razon_social as cliente_nombre',
                    'c.rfc as cliente_rfc',
                    'p.nombre as projeto_nombre',
                    'p.codigo as projeto_codigo'
                );

            // Filtros
            if ($request->fecha_inicio) {
                $query->whereDate('f.fecha', '>=', $request->fecha_inicio);
            }
            if ($request->fecha_fin) {
                $query->whereDate('f.fecha', '<=', $request->fecha_fin);
            }
            if ($request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('f.folio', 'like', "%{$request->search}%")
                      ->orWhere('c.razon_social', 'like', "%{$request->search}%")
                      ->orWhere('c.rfc', 'like', "%{$request->search}%");
                });
            }

            $facturas = $query->orderBy('f.fecha', 'desc')->get();

            // Procesar datos
            foreach ($facturas as $factura) {
                if (!$factura->subtotal && $factura->total) {
                    $factura->subtotal = $factura->total / 1.16;
                }
                if (!$factura->iva && $factura->subtotal) {
                    $factura->iva = $factura->subtotal * 0.16;
                }
                
                if ($factura->moneda != 'MXN' && $factura->tipo_cambio && $factura->tipo_cambio > 0) {
                    $factura->total_mxn = $factura->total * $factura->tipo_cambio;
                } else {
                    $factura->total_mxn = $factura->total;
                }
                
                // Mapear estatus
                $estatusMap = [
                    1 => 'pendiente',
                    10 => 'timbrando',
                    19 => 'timbrada',
                    21 => 'cancelada'
                ];
                $factura->estatus_texto = $estatusMap[$factura->estatus] ?? 'pendiente';
            }

            $stats = [
                'total' => $facturas->count(),
                'activas' => $facturas->where('estatus_texto', 'timbrada')->count(),
                'pagadas' => 0,
                'canceladas' => $facturas->where('estatus_texto', 'cancelada')->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $facturas,
                'stats' => $stats,
                'total_rows' => $facturas->count()
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getData: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
                'stats' => ['total' => 0, 'activas' => 0, 'pagadas' => 0, 'canceladas' => 0]
            ], 500);
        }
    }

    /**
     * Obtener proyectos activos para el select
     */
    public function getProyectosActivos()
    {
        try {
            $proyectos = DB::table('proyectos')
                ->where('status', 'activo')
                ->whereNull('deleted_at')
                ->select('id', 'codigo', 'nombre')
                ->orderBy('codigo')
                ->get();
            
            return response()->json($proyectos);
        } catch (\Exception $e) {
            return response()->json([]);
        }
    }

    /**
     * Obtener clientes para el select
     */
    public function getClientes()
    {
        try {
            $clientes = DB::table('contactos')
                ->where('estatus', true)
                ->whereNull('deleted_at')
                ->where(function($q) {
                    $q->where('tipo', 'cliente')->orWhere('tipo', 'ambos');
                })
                ->select('contacto_id', 'razon_social', 'rfc', 'satcat_regimen_fiscal_clave')
                ->orderBy('razon_social')
                ->get();
            
            return response()->json($clientes);
        } catch (\Exception $e) {
            return response()->json([]);
        }
    }

    /**
     * Obtener series activas para el select
     */
    public function getSeriesActivas()
    {
        try {
            $series = DB::table('cat_series')
                ->where('activo', true)
                ->select('cat_serie_id', 'serie', 'descripcion', 'folio_actual', 'folio_final')
                ->orderBy('serie')
                ->get();
            
            return response()->json($series);
        } catch (\Exception $e) {
            return response()->json([]);
        }
    }

    /**
     * Obtener series específicas para notas de crédito
     */
    public function getSeriesNotaCredito()
    {
        try {
            $series = DB::table('cat_series')
                ->where('activo', true)
                ->where('cat_tipo_comprobante', 'E')
                ->select('cat_serie_id', 'serie', 'descripcion', 'folio_actual', 'folio_final')
                ->orderBy('serie')
                ->get();

            if ($series->isEmpty()) {
                return response()->json([
                    ['cat_serie_id' => 10, 'serie' => 'NC', 'descripcion' => 'Notas de Crédito', 'folio_actual' => 0, 'folio_final' => 99999]
                ]);
            }

            return response()->json($series);
        } catch (\Exception $e) {
            return response()->json([
                ['cat_serie_id' => 10, 'serie' => 'NC', 'descripcion' => 'Notas de Crédito', 'folio_actual' => 0, 'folio_final' => 99999]
            ]);
        }
    }

    /**
     * Obtener facturas disponibles para relacionar con nota de crédito
     * Solo facturas con saldo disponible > 0
     */
    public function getFacturasParaNotaCredito(Request $request)
    {
        try {
            $query = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->where('f.estatus', 19) // Solo facturas timbradas
                ->where('f.tipo_comprobante', 'I') // Solo facturas (no notas de crédito)
                ->whereNull('f.deleted_at')
                ->select(
                    'f.factura_id',
                    'f.folio',
                    'f.fecha',
                    'f.total',
                    'f.subtotal',
                    'f.saldo_disponible',
                    'cs.serie',
                    'c.razon_social as cliente_nombre',
                    'c.rfc as cliente_rfc',
                    'c.contacto_id'
                );

            if ($request->cliente_id) {
                $query->where('f.contacto_id', $request->cliente_id);
            }

            $facturas = $query->orderBy('f.fecha', 'desc')->get();
            
            // Calcular saldo disponible para cada factura
            foreach ($facturas as $factura) {
                // Calcular notas de crédito aplicadas
                $notasAplicadas = DB::table('facturas')
                    ->where('factura_relacionada_id', $factura->factura_id)
                    ->where('tipo_comprobante', 'E')
                    ->where('estatus', 19)
                    ->sum('total');
                
                $saldoCalculado = $factura->total - abs($notasAplicadas);
                $factura->saldo_restante = $factura->saldo_disponible ?? $saldoCalculado;
                $factura->total_notas_aplicadas = abs($notasAplicadas);
            }
            
            // Filtrar solo facturas con saldo > 0
            $facturas = $facturas->filter(function($factura) {
                return $factura->saldo_restante > 0;
            })->values();

            \Log::info('Facturas encontradas para NC:', ['count' => $facturas->count()]);

            return response()->json($facturas);
            
        } catch (\Exception $e) {
            \Log::error('Error en getFacturasParaNotaCredito: ' . $e->getMessage());
            return response()->json([]);
        }
    }

    /**
     * Obtener siguiente folio de una serie
     */
    public function getSiguienteFolio($id)
    {
        try {
            $serie = DB::table('cat_series')->where('cat_serie_id', $id)->first();
            if (!$serie) {
                return response()->json(['folio' => '000001']);
            }
            $siguiente = intval($serie->folio_actual) + 1;
            $folio = str_pad($siguiente, 6, '0', STR_PAD_LEFT);
            return response()->json(['folio' => $folio]);
        } catch (\Exception $e) {
            return response()->json(['folio' => '000001']);
        }
    }

    /**
     * Obtener catálogos SAT
     */
    public function getUsosCFDI()
    {
        try {
            $usos = DB::table('satcat_uso_cfdi')
                ->where('estatus', true)
                ->select('clave', 'descripcion')
                ->orderBy('clave')
                ->get();
            
            if ($usos->isEmpty()) {
                return response()->json([
                    ['clave' => 'G01', 'descripcion' => 'Adquisición de mercancías'],
                    ['clave' => 'G02', 'descripcion' => 'Devoluciones, descuentos o bonificaciones'],
                    ['clave' => 'G03', 'descripcion' => 'Gastos en general'],
                ]);
            }
            return response()->json($usos);
        } catch (\Exception $e) {
            return response()->json([
                ['clave' => 'G01', 'descripcion' => 'Adquisición de mercancías'],
                ['clave' => 'G02', 'descripcion' => 'Devoluciones, descuentos o bonificaciones'],
                ['clave' => 'G03', 'descripcion' => 'Gastos en general'],
            ]);
        }
    }

    public function getFormasPago()
    {
        try {
            $formas = DB::table('satcat_formas_pago')
                ->where('estatus', true)
                ->select('clave', 'descripcion')
                ->orderBy('clave')
                ->get();
            
            if ($formas->isEmpty()) {
                return response()->json([
                    ['clave' => '01', 'descripcion' => 'Efectivo'],
                    ['clave' => '02', 'descripcion' => 'Cheque nominativo'],
                    ['clave' => '03', 'descripcion' => 'Transferencia electrónica de fondos'],
                ]);
            }
            return response()->json($formas);
        } catch (\Exception $e) {
            return response()->json([
                ['clave' => '01', 'descripcion' => 'Efectivo'],
                ['clave' => '02', 'descripcion' => 'Cheque nominativo'],
                ['clave' => '03', 'descripcion' => 'Transferencia electrónica de fondos'],
            ]);
        }
    }

    public function getMetodosPago()
    {
        try {
            $metodos = DB::table('satcat_metodos_pago')
                ->where('estatus', true)
                ->select('clave', 'descripcion')
                ->orderBy('clave')
                ->get();
            
            if ($metodos->isEmpty()) {
                return response()->json([
                    ['clave' => 'PUE', 'descripcion' => 'Pago en una sola exhibición'],
                    ['clave' => 'PPD', 'descripcion' => 'Pago en parcialidades o diferido'],
                ]);
            }
            return response()->json($metodos);
        } catch (\Exception $e) {
            return response()->json([
                ['clave' => 'PUE', 'descripcion' => 'Pago en una sola exhibición'],
                ['clave' => 'PPD', 'descripcion' => 'Pago en parcialidades o diferido'],
            ]);
        }
    }

    /**
     * Guardar nueva factura
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            \Log::info('Datos recibidos para factura:', $request->all());
            
            // Validación básica
            $validated = $request->validate([
                'contacto_id' => 'required',
                'cat_serie_id' => 'required',
                'fecha' => 'required|date',
                'conceptos' => 'required|array|min:1',
                'conceptos.*.descripcion' => 'required',
                'conceptos.*.cantidad' => 'required|numeric|min:0.0001',
                'conceptos.*.valorUnitario' => 'required|numeric|min:0',
            ]);
            
            // Obtener siguiente folio
            $serie = DB::table('cat_series')->where('cat_serie_id', $request->cat_serie_id)->first();
            if (!$serie) {
                throw new \Exception('Serie no encontrada');
            }
            $folio = str_pad(($serie->folio_actual ?? 0) + 1, 6, '0', STR_PAD_LEFT);
            
            // Obtener sucursal por defecto
            $sucursalDefault = DB::table('cat_sucursales')->where('estatus', true)->first();
            $catSucursalId = $sucursalDefault->cat_sucursal_id ?? 1;
            
            // Obtener datos del cliente
            $contacto = DB::table('contactos')->where('contacto_id', $request->contacto_id)->first();
            if (!$contacto) {
                throw new \Exception('Cliente no encontrado');
            }
            
            // Valores por defecto
            $satcatUsoCfdiClave = $request->satcat_uso_cfdi_clave ?? 'G01';
            $satcatFormasPagoClave = $request->satcat_formas_pago_clave ?? '01';
            $satcatMetodosPagoClave = $request->satcat_metodos_pago_clave ?? 'PUE';
            $satcatRegimenFiscalClave = $contacto->satcat_regimen_fiscal_clave ?? '601';
            
            // Calcular totales
            $subtotal = 0;
            foreach ($request->conceptos as $concepto) {
                $importe = $concepto['cantidad'] * $concepto['valorUnitario'];
                $subtotal += $importe;
            }
            $iva = $subtotal * 0.16;
            $total = $subtotal + $iva;
            
            // Determinar estatus
            $estatusFinal = $request->timbrar ? 19 : 1;
            
            // Insertar factura
            $facturaId = DB::table('facturas')->insertGetId([
                'contacto_id' => $request->contacto_id,
                'proyecto_id' => $request->proyecto_id,
                'cat_serie_id' => $request->cat_serie_id,
                'cat_sucursal_id' => $catSucursalId,
                'folio' => $folio,
                'fecha' => $request->fecha,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'cat_monedas_clave' => $request->moneda ?? 'MXN',
                'tipo_cambio' => $request->tipo_cambio ?? 1,
                'subtotal' => $subtotal,
                'iva' => $iva,
                'total' => $total,
                'saldo_disponible' => $total, // Inicialmente el saldo es igual al total
                'satcat_uso_cfdi_clave' => $satcatUsoCfdiClave,
                'satcat_formas_pago_clave' => $satcatFormasPagoClave,
                'satcat_metodos_pago_clave' => $satcatMetodosPagoClave,
                'satcat_regimen_fiscal_clave' => $satcatRegimenFiscalClave,
                'observaciones' => $request->observaciones,
                'tipo_comprobante' => 'I',
                'estatus' => $estatusFinal,
                'created_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now()
            ], 'factura_id');
            
            // Insertar conceptos
            foreach ($request->conceptos as $concepto) {
                $importe = $concepto['cantidad'] * $concepto['valorUnitario'];
                DB::table('facturas_conceptos')->insert([
                    'factura_id' => $facturaId,
                    'descripcion' => $concepto['descripcion'],
                    'cantidad' => $concepto['cantidad'],
                    'satcat_unidades_clave' => 'ACT',
                    'valor_unitario' => $concepto['valorUnitario'],
                    'importe' => $importe,
                    'descuento' => 0,
                    'subtotal' => $importe,
                    'iva' => $importe * 0.16,
                    'tasa_iva' => 16.0000,
                    'satcat_clave_productos_clave' => '84111500',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            
            // Actualizar folio de la serie
            DB::table('cat_series')
                ->where('cat_serie_id', $request->cat_serie_id)
                ->update(['folio_actual' => ($serie->folio_actual ?? 0) + 1]);
            
            // Si se timbra, generar CFDI
            $uuid = null;
            if ($request->timbrar) {
                $uuid = strtoupper(bin2hex(random_bytes(16)));
                
                $emisor = DB::table('datos_generales')->where('activo', true)->first();
                $rfcEmisor = $emisor->rfc ?? 'EPS123456789';
                
                DB::table('cfdi')->insert([
                    'factura_id' => $facturaId,
                    'timbrefiscaldigitalUUID' => $uuid,
                    'timbrefiscaldigitalFechaTimbrado' => now(),
                    'comprobanteSerie' => $serie->serie,
                    'comprobanteFolio' => $folio,
                    'comprobanteFecha' => $request->fecha,
                    'comprobanteMoneda' => $request->moneda ?? 'MXN',
                    'comprobanteTipoCambio' => $request->tipo_cambio ?? 1,
                    'comprobanteSubTotal' => $subtotal,
                    'comprobanteTotal' => $total,
                    'comprobanteTipoDeComprobante' => 'I',
                    'comprobanteMetodoPago' => $satcatMetodosPagoClave,
                    'comprobanteFormaPago' => $satcatFormasPagoClave,
                    'comprobanteNoCertificado' => '00001000000400000000',
                    'emisorRfc' => $rfcEmisor,
                    'receptorRfc' => $contacto->rfc,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            
            DB::commit();
            
            $response = [
                'success' => true,
                'message' => $request->timbrar ? 'Factura timbrada correctamente' : 'Factura guardada correctamente',
                'factura_id' => $facturaId
            ];
            
            if ($uuid) {
                $response['uuid'] = $uuid;
                $response['timbrado'] = true;
            }
            
            return response()->json($response);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al guardar factura: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Timbrar una factura existente
     */
    public function timbrarFactura(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $factura = DB::table('facturas as f')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->where('f.factura_id', $id)
                ->select('f.*', 'cs.serie', 'c.rfc as receptor_rfc')
                ->first();
            
            if (!$factura) {
                return response()->json(['success' => false, 'message' => 'Factura no encontrada'], 404);
            }
            
            if ($factura->estatus == 19) {
                return response()->json(['success' => false, 'message' => 'La factura ya está timbrada'], 422);
            }
            
            $cfdiExistente = DB::table('cfdi')->where('factura_id', $id)->first();
            $uuid = null;
            
            if (!$cfdiExistente) {
                $uuid = strtoupper(bin2hex(random_bytes(16)));
                
                $emisor = DB::table('datos_generales')->where('activo', true)->first();
                $rfcEmisor = $emisor->rfc ?? 'EPS123456789';
                
                DB::table('cfdi')->insert([
                    'factura_id' => $id,
                    'timbrefiscaldigitalUUID' => $uuid,
                    'timbrefiscaldigitalFechaTimbrado' => now(),
                    'comprobanteSerie' => $factura->serie,
                    'comprobanteFolio' => $factura->folio,
                    'comprobanteFecha' => $factura->fecha,
                    'comprobanteMoneda' => $factura->cat_monedas_clave ?? 'MXN',
                    'comprobanteTipoCambio' => $factura->tipo_cambio ?? 1,
                    'comprobanteSubTotal' => $factura->subtotal,
                    'comprobanteTotal' => $factura->total,
                    'comprobanteTipoDeComprobante' => 'I',
                    'comprobanteMetodoPago' => $factura->satcat_metodos_pago_clave ?? 'PUE',
                    'comprobanteFormaPago' => $factura->satcat_formas_pago_clave ?? '01',
                    'comprobanteNoCertificado' => '00001000000400000000',
                    'emisorRfc' => $rfcEmisor,
                    'receptorRfc' => $factura->receptor_rfc,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                $uuid = $cfdiExistente->timbrefiscaldigitalUUID;
            }
            
            // Actualizar estatus y saldo disponible si es factura
            $updateData = ['estatus' => 19, 'updated_at' => now()];
            if ($factura->tipo_comprobante === 'I' && !$factura->saldo_disponible) {
                $updateData['saldo_disponible'] = $factura->total;
            }
            
            DB::table('facturas')
                ->where('factura_id', $id)
                ->update($updateData);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Factura timbrada correctamente',
                'uuid' => $uuid
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al timbrar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al timbrar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar una factura específica
     */
    public function show($id)
    {
        try {
            $factura = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->leftJoin('cfdi as cf', 'f.factura_id', '=', 'cf.factura_id')
                ->where('f.factura_id', $id)
                ->select(
                    'f.*',
                    'c.razon_social as cliente_nombre',
                    'c.rfc as cliente_rfc',
                    'cs.serie',
                    'cf.timbrefiscaldigitalUUID as uuid'
                )
                ->first();
            
            if (!$factura) {
                return response()->json(['success' => false, 'message' => 'Factura no encontrada'], 404);
            }
            
            $conceptos = DB::table('facturas_conceptos')
                ->where('factura_id', $id)
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $factura,
                'conceptos' => $conceptos
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Generar PDF de la factura
     */
    public function pdf($id)
    {
        try {
            $factura = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->leftJoin('cfdi as cf', 'f.factura_id', '=', 'cf.factura_id')
                ->where('f.factura_id', $id)
                ->select(
                    'f.*',
                    'c.razon_social as cliente_nombre',
                    'c.rfc as cliente_rfc',
                    'cs.serie',
                    'cf.timbrefiscaldigitalUUID as uuid'
                )
                ->first();
            
            if (!$factura) {
                abort(404, 'Factura no encontrada');
            }
            
            $conceptos = DB::table('facturas_conceptos')
                ->where('factura_id', $id)
                ->get();
            
            $data = [
                'factura' => $factura,
                'conceptos' => $conceptos,
                'total_letra' => $this->numeroALetras($factura->total),
            ];
            
            return view('pdfs.factura', $data);
            
        } catch (\Exception $e) {
            \Log::error('Error al generar PDF: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Descargar XML de la factura
     */
    public function downloadXml($id)
    {
        try {
            $factura = DB::table('facturas as f')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->where('f.factura_id', $id)
                ->select('f.*', 'cs.serie', 'c.razon_social as cliente_nombre', 'c.rfc')
                ->first();
            
            if (!$factura) {
                abort(404, 'Factura no encontrada');
            }
            
            $conceptos = DB::table('facturas_conceptos')
                ->where('factura_id', $id)
                ->get();
            
            $xml = $this->generarXML($factura, $conceptos);
            $filename = 'Factura_' . $factura->serie . '-' . $factura->folio . '.xml';
            
            return response($xml, 200)
                ->header('Content-Type', 'application/xml')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
                
        } catch (\Exception $e) {
            \Log::error('Error al generar XML: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Generar XML para la factura
     */
    private function generarXML($factura, $conceptos)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<cfdi:Comprobante xmlns:cfdi="http://www.sat.gob.mx/cfd/4" 
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
            Version="4.0" 
            Serie="' . htmlspecialchars($factura->serie) . '" 
            Folio="' . htmlspecialchars($factura->folio) . '" 
            Fecha="' . $factura->fecha . 'T12:00:00" 
            Moneda="' . ($factura->cat_monedas_clave ?? 'MXN') . '" 
            TipoCambio="' . ($factura->tipo_cambio ?? 1) . '" 
            SubTotal="' . number_format($factura->subtotal, 2, '.', '') . '" 
            Total="' . number_format($factura->total, 2, '.', '') . '" 
            TipoDeComprobante="I" 
            MetodoPago="PUE" 
            FormaPago="01" 
            Exportacion="01" 
            LugarExpedicion="64000" 
            xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd">';
        
        $xml .= '<cfdi:Emisor Rfc="EPS123456789" Nombre="EMPRESA DE PRUEBA SA DE CV" RegimenFiscal="601"/>';
        $xml .= '<cfdi:Receptor Rfc="' . htmlspecialchars($factura->rfc ?? 'XAXX010101000') . '" 
            Nombre="' . htmlspecialchars($factura->cliente_nombre ?? 'PUBLICO EN GENERAL') . '" 
            DomicilioFiscalReceptor="64000" 
            RegimenFiscalReceptor="616" 
            UsoCFDI="G01"/>';
        
        $xml .= '<cfdi:Conceptos>';
        foreach ($conceptos as $index => $concepto) {
            $xml .= '<cfdi:Concepto 
                ClaveProdServ="84111500" 
                NoIdentificacion="' . str_pad($index + 1, 3, '0', STR_PAD_LEFT) . '" 
                Cantidad="' . number_format($concepto->cantidad, 2, '.', '') . '" 
                ClaveUnidad="ACT" 
                Unidad="Actividad" 
                Descripcion="' . htmlspecialchars($concepto->descripcion) . '" 
                ValorUnitario="' . number_format($concepto->valor_unitario, 2, '.', '') . '" 
                Importe="' . number_format($concepto->importe, 2, '.', '') . '" 
                ObjetoImp="02">
                <cfdi:Traslados>
                    <cfdi:Traslado Base="' . number_format($concepto->importe, 2, '.', '') . '" Impuesto="002" TipoFactor="Tasa" TasaOCuota="0.160000" Importe="' . number_format($concepto->iva, 2, '.', '') . '"/>
                </cfdi:Traslados>
            </cfdi:Concepto>';
        }
        $xml .= '</cfdi:Conceptos>';
        
        $xml .= '<cfdi:Impuestos TotalImpuestosTrasladados="' . number_format($factura->iva, 2, '.', '') . '">
            <cfdi:Traslados>
                <cfdi:Traslado Base="' . number_format($factura->subtotal, 2, '.', '') . '" Impuesto="002" TipoFactor="Tasa" TasaOCuota="0.160000" Importe="' . number_format($factura->iva, 2, '.', '') . '"/>
            </cfdi:Traslados>
        </cfdi:Impuestos>';
        
        $xml .= '<cfdi:Complemento>
            <tfd:TimbreFiscalDigital xmlns:tfd="http://www.sat.gob.mx/TimbreFiscalDigital" 
                Version="1.1" 
                UUID="' . strtoupper(bin2hex(random_bytes(16))) . '" 
                FechaTimbrado="' . now()->format('Y-m-d\TH:i:s') . '" 
                RfcProvCertif="AAA010101AAA" />
        </cfdi:Complemento>';
        
        $xml .= '</cfdi:Comprobante>';
        
        return $xml;
    }

    /**
     * Convertir número a letras
     */
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
            if ($miles == 1) {
                $letras .= 'mil ';
            } else {
                $letras .= $this->convertirTresDigitos($miles, $unidades, $decenas, $decenasEspeciales, $centenas) . ' mil ';
            }
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
            if ($cientos == 1 && $resto == 0) {
                $letras .= 'cien ';
            } else {
                $letras .= $centenas[$cientos] . ' ';
            }
        }
        
        if ($resto > 0) {
            if ($resto < 10) {
                $letras .= $unidades[$resto] . ' ';
            } elseif ($resto < 20) {
                if ($resto == 10) {
                    $letras .= 'diez ';
                } else {
                    $letras .= $decenasEspeciales[$resto - 11] . ' ';
                }
            } else {
                $decena = floor($resto / 10);
                $unidad = $resto % 10;
                if ($unidad > 0) {
                    $letras .= $decenas[$decena] . ' y ' . $unidades[$unidad] . ' ';
                } else {
                    $letras .= $decenas[$decena] . ' ';
                }
            }
        }
        
        return $letras;
    }

    // Métodos adicionales para compatibilidad
    
    public function index(Request $request)
    {
        return $this->getData($request);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['status' => 'ok', 'message' => 'Actualizado']);
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

    public function edit($id)
    {
        return $this->show($id);
    }

    public function create()
    {
        return response()->json(['status' => 'ok']);
    }

    public function enviarCorreo($id)
    {
        return response()->json(['status' => 'ok', 'message' => 'Correo enviado']);
    }

    /**
 * Obtener facturas disponibles para aplicar pagos (contrarecibos)
 * Solo facturas con saldo pendiente > 0
 */
/**
 * Obtener facturas disponibles para aplicar pagos (contrarecibos)
 */
/**
 * Obtener facturas disponibles para aplicar pagos (contrarecibos)
 */
public function getFacturasParaPago(Request $request)
{
    try {
        $query = DB::table('facturas as f')
            ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
            ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
            ->where('f.estatus', 19) // Solo facturas timbradas
            ->where('f.tipo_comprobante', 'I') // Solo facturas de ingreso
            ->whereNull('f.deleted_at')
            ->select(
                'f.factura_id',
                'f.folio',
                'f.fecha',
                'f.total',
                'f.subtotal',
                'f.saldo_disponible',
                'cs.serie',
                'c.razon_social as cliente_nombre',
                'c.rfc as cliente_rfc',
                'c.contacto_id'
            );

        if ($request->cliente_id) {
            $query->where('f.contacto_id', $request->cliente_id);
        }

        $facturas = $query->orderBy('f.fecha', 'desc')->get();
        
        $facturasDisponibles = [];
        
        foreach ($facturas as $factura) {
            // Calcular notas de crédito aplicadas
            $notasAplicadas = DB::table('facturas')
                ->where('factura_relacionada_id', $factura->factura_id)
                ->where('tipo_comprobante', 'E')
                ->where('estatus', 19)
                ->sum('total');
            
            // Calcular pagos aplicados vía contrarecibos
            $pagosAplicados = DB::table('contrarecibo_facturas as cf')
                ->join('contrarecibos as cr', 'cf.contrarecibo_id', '=', 'cr.contrarecibo_id')
                ->where('cf.factura_id', $factura->factura_id)
                ->where('cr.estatus', 19)
                ->sum('cf.monto_aplicado');
            
            // Calcular saldo restante
            $totalAplicado = abs($notasAplicadas) + $pagosAplicados;
            $saldoRestante = $factura->total - $totalAplicado;
            
            // Actualizar el saldo_disponible en la tabla si es necesario
            if ($factura->saldo_disponible != $saldoRestante) {
                DB::table('facturas')
                    ->where('factura_id', $factura->factura_id)
                    ->update(['saldo_disponible' => max(0, $saldoRestante)]);
            }
            
            // Solo incluir facturas con saldo > 0
            if ($saldoRestante > 0) {
                $factura->saldo_restante = $saldoRestante;
                $factura->total_notas_aplicadas = $notasAplicadas;
                $factura->total_pagos_aplicados = $pagosAplicados;
                $factura->total_aplicado = $totalAplicado;
                $facturasDisponibles[] = $factura;
            }
        }

        return response()->json($facturasDisponibles);
        
    } catch (\Exception $e) {
        \Log::error('Error en getFacturasParaPago: ' . $e->getMessage());
        return response()->json([]);
    }
}

}