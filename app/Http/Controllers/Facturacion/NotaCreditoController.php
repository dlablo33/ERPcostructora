<?php

namespace App\Http\Controllers\Facturacion;

use App\Http\Controllers\Controller;
use App\Models\Facturacion\Factura;
use App\Models\Facturacion\FacturaConcepto;
use App\Models\Facturacion\Contacto;
use App\Models\Facturacion\CatSerie;
use App\Models\Facturacion\CatSucursal;
use App\Models\Facturacion\SatcatFormaPago;
use App\Models\Facturacion\SatcatMetodoPago;
use App\Models\Facturacion\SatcatUsoCfdi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Barryvdh\DomPDF\Facade\Pdf;

class NotaCreditoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Vista principal de notas de crédito
     */
    public function indexView()
    {
        return view('notas-credito.index');
    }

    /**
     * Obtener datos para la tabla de notas de crédito
     */
    public function getData(Request $request)
    {
        try {
            $query = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->leftJoin('cfdi as cf', 'f.factura_id', '=', 'cf.factura_id')
                ->leftJoin('facturas as fr', 'f.factura_relacionada_id', '=', 'fr.factura_id')
                ->leftJoin('cat_series as cs_rel', 'fr.cat_serie_id', '=', 'cs_rel.cat_serie_id')
                ->where('f.tipo_comprobante', 'E')
                ->select(
                    'f.factura_id',
                    'f.folio',
                    'f.fecha',
                    'f.estatus',
                    'f.subtotal',
                    'f.iva',
                    'f.total',
                    'f.cat_monedas_clave as moneda',
                    'f.observaciones',
                    'f.motivo_nota_credito',
                    'f.created_at',
                    'cf.timbrefiscaldigitalUUID as uuid',
                    'cf.timbrefiscaldigitalFechaTimbrado as fecha_timbrado',
                    'cs.serie',
                    'c.razon_social as cliente_nombre',
                    'c.rfc as cliente_rfc',
                    'fr.folio as factura_relacionada_folio',
                    'cs_rel.serie as factura_relacionada_serie'
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
                      ->orWhere('c.rfc', 'like', "%{$request->search}%")
                      ->orWhere('f.motivo_nota_credito', 'like', "%{$request->search}%");
                });
            }

            $notas = $query->orderBy('f.fecha', 'desc')->get();

            // Procesar datos
            foreach ($notas as $nota) {
                if (!$nota->subtotal && $nota->total) {
                    $nota->subtotal = $nota->total / 1.16;
                }
                if (!$nota->iva && $nota->subtotal) {
                    $nota->iva = $nota->subtotal * 0.16;
                }

                $estatusMap = [
                    1 => 'pendiente',
                    10 => 'timbrando',
                    19 => 'timbrada',
                    21 => 'cancelada'
                ];
                $nota->estatus_texto = $estatusMap[$nota->estatus] ?? 'pendiente';
            }

            $stats = [
                'total' => $notas->count(),
                'timbradas' => $notas->where('estatus', 19)->count(),
                'pendientes' => $notas->where('estatus', 1)->count(),
                'canceladas' => $notas->where('estatus', 21)->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $notas,
                'stats' => $stats,
                'total_rows' => $notas->count()
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getData NotaCredito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
                'stats' => ['total' => 0, 'timbradas' => 0, 'pendientes' => 0, 'canceladas' => 0]
            ], 500);
        }
    }

    /**
     * Obtener datos para crear una nueva nota de crédito
     */
    public function create()
    {
        try {
            $clientes = Contacto::where('estatus', true)
                ->where(function($q) {
                    $q->where('tipo', 'cliente')->orWhere('tipo', 'ambos');
                })
                ->orderBy('razon_social')
                ->get(['contacto_id', 'razon_social', 'rfc']);

            $series = DB::table('cat_series')
                ->where('activo', true)
                ->where('cat_tipo_comprobante', 'E')
                ->orderBy('serie')
                ->get(['cat_serie_id', 'serie', 'descripcion', 'folio_actual', 'folio_final']);

            $formasPago = SatcatFormaPago::where('estatus', true)->get(['clave', 'descripcion']);
            $metodosPago = SatcatMetodoPago::where('estatus', true)->get(['clave', 'descripcion']);
            $usosCfdi = SatcatUsoCfdi::where('estatus', true)->get(['clave', 'descripcion']);
            $sucursales = CatSucursal::where('estatus', true)->get(['cat_sucursal_id', 'nombre']);

            return response()->json([
                'success' => true,
                'data' => compact('clientes', 'series', 'formasPago', 'metodosPago', 'usosCfdi', 'sucursales')
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Guardar nueva nota de crédito
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            \Log::info('Datos nota de crédito:', $request->all());

            $validated = $request->validate([
                'contacto_id' => 'required|exists:contactos,contacto_id',
                'cat_serie_id' => 'required|exists:cat_series,cat_serie_id',
                'fecha' => 'required|date',
                'factura_relacionada_id' => 'required|exists:facturas,factura_id',
                'motivo' => 'required|string|max:500',
                'conceptos' => 'required|array|min:1',
                'conceptos.*.descripcion' => 'required|string',
                'conceptos.*.cantidad' => 'required|numeric|min:0.0001',
                'conceptos.*.valorUnitario' => 'required|numeric|min:0',
            ]);

            // Obtener la factura original
            $facturaOriginal = DB::table('facturas')->where('factura_id', $request->factura_relacionada_id)->first();
            
            if (!$facturaOriginal) {
                throw new \Exception('Factura original no encontrada');
            }

            // Verificar que la factura original sea de tipo ingreso (I)
            if ($facturaOriginal->tipo_comprobante !== 'I') {
                throw new \Exception('Solo se pueden emitir notas de crédito para facturas de ingreso');
            }

            // Verificar que la factura esté timbrada
            if ($facturaOriginal->estatus != 19) {
                throw new \Exception('La factura debe estar timbrada para emitir una nota de crédito');
            }

            // Calcular el total de la nota de crédito
            $totalNotaCredito = 0;
            foreach ($request->conceptos as $concepto) {
                $totalNotaCredito += $concepto['cantidad'] * $concepto['valorUnitario'];
            }

            // Calcular saldo disponible de la factura original
            $notasAplicadas = DB::table('facturas')
                ->where('factura_relacionada_id', $request->factura_relacionada_id)
                ->where('tipo_comprobante', 'E')
                ->where('estatus', 19)
                ->sum('total');
            
            $saldoActual = $facturaOriginal->saldo_disponible ?? ($facturaOriginal->total - abs($notasAplicadas));
            $saldoRestante = max(0, $saldoActual);

            // Validar que no exceda el saldo disponible
            if ($totalNotaCredito > $saldoRestante) {
                return response()->json([
                    'success' => false,
                    'message' => "El monto de la nota de crédito (\$" . number_format($totalNotaCredito, 2) . ") excede el saldo disponible (\$" . number_format($saldoRestante, 2) . ") de la factura"
                ], 422);
            }

            // Obtener serie para nota de crédito
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
            $satcatRegimenFiscalClave = $contacto->satcat_regimen_fiscal_clave ?? '601';

            // Valores por defecto (tomar de la factura original si es posible)
            $satcatUsoCfdiClave = $facturaOriginal->satcat_uso_cfdi_clave ?? 'G01';
            $satcatFormasPagoClave = $facturaOriginal->satcat_formas_pago_clave ?? '01';
            $satcatMetodosPagoClave = $facturaOriginal->satcat_metodos_pago_clave ?? 'PUE';

            // Calcular totales (montos NEGATIVOS para nota de crédito)
            $subtotal = 0;
            foreach ($request->conceptos as $concepto) {
                $importe = -($concepto['cantidad'] * $concepto['valorUnitario']);
                $subtotal += $importe;
            }
            $iva = $subtotal * 0.16;
            $total = $subtotal + $iva;

            // Insertar nota de crédito
            $notaId = DB::table('facturas')->insertGetId([
                'contacto_id' => $request->contacto_id,
                'proyecto_id' => $request->proyecto_id ?? $facturaOriginal->proyecto_id,
                'cat_serie_id' => $request->cat_serie_id,
                'cat_sucursal_id' => $catSucursalId,
                'folio' => $folio,
                'fecha' => $request->fecha,
                'fecha_vencimiento' => null,
                'cat_monedas_clave' => $facturaOriginal->cat_monedas_clave ?? 'MXN',
                'tipo_cambio' => $facturaOriginal->tipo_cambio ?? 1,
                'subtotal' => $subtotal,
                'iva' => $iva,
                'total' => $total,
                'satcat_uso_cfdi_clave' => $satcatUsoCfdiClave,
                'satcat_formas_pago_clave' => $satcatFormasPagoClave,
                'satcat_metodos_pago_clave' => $satcatMetodosPagoClave,
                'satcat_regimen_fiscal_clave' => $satcatRegimenFiscalClave,
                'observaciones' => $request->observaciones,
                'motivo_nota_credito' => $request->motivo,
                'factura_relacionada_id' => $request->factura_relacionada_id,
                'tipo_comprobante' => 'E',
                'estatus' => $request->timbrar ? 19 : 1,
                'created_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now()
            ], 'factura_id');

            // Insertar conceptos (con montos NEGATIVOS)
            foreach ($request->conceptos as $concepto) {
                $importe = -($concepto['cantidad'] * $concepto['valorUnitario']);
                DB::table('facturas_conceptos')->insert([
                    'factura_id' => $notaId,
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

            // Actualizar el saldo disponible de la factura original
            $nuevoSaldo = $saldoRestante - $totalNotaCredito;
            DB::table('facturas')
                ->where('factura_id', $request->factura_relacionada_id)
                ->update([
                    'saldo_disponible' => max(0, $nuevoSaldo),
                    'updated_at' => now()
                ]);

            // Actualizar folio de la serie
            DB::table('cat_series')
                ->where('cat_serie_id', $request->cat_serie_id)
                ->update(['folio_actual' => ($serie->folio_actual ?? 0) + 1]);

            // Si se timbra, generar CFDI
            $uuid = null;
            if ($request->timbrar) {
                $uuid = strtoupper(bin2hex(random_bytes(16)));
                DB::table('cfdi')->insert([
                    'factura_id' => $notaId,
                    'timbrefiscaldigitalUUID' => $uuid,
                    'timbrefiscaldigitalFechaTimbrado' => now(),
                    'comprobanteSubTotal' => abs($subtotal),
                    'comprobanteTotal' => abs($total),
                    'comprobanteFecha' => $request->fecha,
                    'comprobanteMoneda' => $facturaOriginal->cat_monedas_clave ?? 'MXN',
                    'comprobanteTipoDeComprobante' => 'E',
                    'comprobanteSerie' => $serie->serie,
                    'comprobanteFolio' => $folio,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();

            $porcentajeAplicado = ($totalNotaCredito / $facturaOriginal->total) * 100;
            $estadoFactura = $nuevoSaldo <= 0 ? 'Totalmente pagada' : 'Parcialmente pagada';

            return response()->json([
                'success' => true,
                'message' => $request->timbrar ? 'Nota de crédito timbrada correctamente' : 'Nota de crédito guardada correctamente',
                'factura_id' => $notaId,
                'uuid' => $uuid,
                'saldo_restante' => $nuevoSaldo,
                'factura_total' => $facturaOriginal->total,
                'monto_aplicado' => $totalNotaCredito,
                'porcentaje_aplicado' => round($porcentajeAplicado, 2),
                'estado_factura' => $estadoFactura
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al guardar nota de crédito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar una nota de crédito específica
     */
    public function show($id)
    {
        try {
            // Obtener la nota de crédito
            $nota = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->leftJoin('cfdi as cf', 'f.factura_id', '=', 'cf.factura_id')
                ->leftJoin('facturas as fr', 'f.factura_relacionada_id', '=', 'fr.factura_id')
                ->leftJoin('cat_series as cs_rel', 'fr.cat_serie_id', '=', 'cs_rel.cat_serie_id')
                ->where('f.factura_id', $id)
                ->select(
                    'f.*',
                    'c.razon_social as cliente_nombre',
                    'c.rfc as cliente_rfc',
                    'cs.serie',
                    'cf.timbrefiscaldigitalUUID as uuid',
                    'fr.folio as factura_relacionada_folio',
                    'cs_rel.serie as factura_relacionada_serie'
                )
                ->first();

            if (!$nota) {
                return response()->json(['success' => false, 'message' => 'Nota de crédito no encontrada'], 404);
            }

            // Obtener los conceptos de la factura ORIGINAL (no de la nota)
            $conceptosFacturaOriginal = DB::table('facturas_conceptos as fc')
                ->where('fc.factura_id', $nota->factura_relacionada_id)
                ->select(
                    'fc.factura_concepto_id',
                    'fc.descripcion',
                    'fc.cantidad',
                    'fc.valor_unitario',
                    'fc.importe',
                    'fc.satcat_unidades_clave',
                    'fc.satcat_clave_productos_clave',
                    DB::raw('(SELECT SUM(importe) FROM facturas_conceptos WHERE factura_id = ' . $nota->factura_relacionada_id . ') as total_factura')
                )
                ->get();

            // Obtener los conceptos de la nota de crédito
            $conceptosNota = DB::table('facturas_conceptos')
                ->where('factura_id', $id)
                ->get();

            // Calcular información de la factura relacionada
            $facturaOriginal = DB::table('facturas')->where('factura_id', $nota->factura_relacionada_id)->first();
            
            // Calcular notas de crédito aplicadas a esta factura
            $totalNotasAplicadas = DB::table('facturas')
                ->where('factura_relacionada_id', $nota->factura_relacionada_id)
                ->where('tipo_comprobante', 'E')
                ->where('estatus', 19)
                ->sum('total');
            
            $saldoCalculado = ($facturaOriginal->total ?? 0) - abs($totalNotasAplicadas);
            
            $nota->info_factura = [
                'total' => $facturaOriginal->total ?? 0,
                'saldo_disponible' => $facturaOriginal->saldo_disponible ?? $saldoCalculado,
                'esta_totalmente_pagada' => ($facturaOriginal->saldo_disponible ?? $saldoCalculado) <= 0,
                'total_notas_aplicadas' => abs($totalNotasAplicadas),
                'conceptos' => $conceptosFacturaOriginal
            ];

            return response()->json([
                'success' => true,
                'data' => $nota,
                'conceptos' => $conceptosNota,
                'conceptos_factura_original' => $conceptosFacturaOriginal
            ]);
        } catch (\Exception $e) {
            \Log::error('Error en show nota crédito: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Generar PDF de la nota de crédito
     */
    public function pdf($id)
    {
        try {
            $nota = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->leftJoin('facturas as fr', 'f.factura_relacionada_id', '=', 'fr.factura_id')
                ->leftJoin('cat_series as cs_rel', 'fr.cat_serie_id', '=', 'cs_rel.cat_serie_id')
                ->where('f.factura_id', $id)
                ->select(
                    'f.*',
                    'c.razon_social as cliente_nombre',
                    'c.rfc as cliente_rfc',
                    'cs.serie',
                    'fr.folio as factura_relacionada_folio',
                    'cs_rel.serie as factura_relacionada_serie'
                )
                ->first();

            if (!$nota) {
                abort(404, 'Nota de crédito no encontrada');
            }

            $conceptos = DB::table('facturas_conceptos')
                ->where('factura_id', $id)
                ->get();

            $data = [
                'nota' => $nota,
                'conceptos' => $conceptos,
                'total_letra' => $this->numeroALetras(abs($nota->total)),
            ];

            return view('notas-credito.pdf', $data);

        } catch (\Exception $e) {
            \Log::error('Error al generar PDF nota crédito: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Eliminar nota de crédito
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $nota = DB::table('facturas')->where('factura_id', $id)->first();

            if (!$nota) {
                return response()->json(['success' => false, 'message' => 'Nota de crédito no encontrada'], 404);
            }

            if ($nota->estatus == 19) {
                return response()->json(['success' => false, 'message' => 'No se puede eliminar una nota de crédito timbrada'], 422);
            }

            // Restaurar el saldo de la factura original
            if ($nota->factura_relacionada_id) {
                $facturaOriginal = DB::table('facturas')->where('factura_id', $nota->factura_relacionada_id)->first();
                if ($facturaOriginal) {
                    $montoNota = abs($nota->total);
                    $nuevoSaldo = ($facturaOriginal->saldo_disponible ?? 0) + $montoNota;
                    DB::table('facturas')
                        ->where('factura_id', $nota->factura_relacionada_id)
                        ->update([
                            'saldo_disponible' => $nuevoSaldo,
                            'updated_at' => now()
                        ]);
                }
            }

            DB::table('facturas')->where('factura_id', $id)->update(['deleted_at' => now()]);
            
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Nota de crédito eliminada']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Convertir número a letras
     */
    private function numeroALetras($numero)
    {
        try {
            $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
            return ucfirst($formatter->format($numero)) . ' pesos 00/100 M.N.';
        } catch (\Exception $e) {
            // Fallback manual si NumberFormatter no está disponible
            return number_format($numero, 2) . ' pesos 00/100 M.N.';
        }
    }
}