<?php
// app/Http/Controllers/Facturacion/CFDIController.php

namespace App\Http\Controllers\Facturacion;

use App\Http\Controllers\Controller;
use App\Services\CFDIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class CFDIController extends Controller
{
    protected $cfdiService;

    public function __construct(CFDIService $cfdiService)
    {
        $this->middleware('auth');
        $this->cfdiService = $cfdiService;
    }

    /**
     * Vista principal de CFDI
     */
    public function indexView()
    {
        return view('cfdi.index');
    }

    /**
     * Obtener datos para la tabla de CFDI
     */
    public function getData(Request $request)
    {
        try {
            $query = DB::table('cfdi as c')
                ->leftJoin('facturas as f', 'c.factura_id', '=', 'f.factura_id')
                ->leftJoin('contactos as cont', 'f.contacto_id', '=', 'cont.contacto_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->select(
                    'c.cfdi_id',
                    'c.comprobanteSerie',
                    'c.comprobanteFolio',
                    'c.comprobanteFecha',
                    'c.comprobanteTotal',
                    'c.timbrefiscaldigitalUUID as uuid',
                    'c.comprobanteTipoDeComprobante',
                    'f.estatus as factura_estatus',
                    'cont.razon_social as receptor_nombre',
                    'cont.rfc as receptor_rfc',
                    'cs.serie'
                );

            // Filtros
            if ($request->fecha_inicio) {
                $query->whereDate('c.comprobanteFecha', '>=', $request->fecha_inicio);
            }
            if ($request->fecha_fin) {
                $query->whereDate('c.comprobanteFecha', '<=', $request->fecha_fin);
            }
            if ($request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('c.comprobanteFolio', 'like', "%{$request->search}%")
                      ->orWhere('c.comprobanteSerie', 'like', "%{$request->search}%")
                      ->orWhere('c.timbrefiscaldigitalUUID', 'like', "%{$request->search}%")
                      ->orWhere('cont.razon_social', 'like', "%{$request->search}%")
                      ->orWhere('cont.rfc', 'like', "%{$request->search}%");
                });
            }

            $cfdis = $query->orderBy('c.comprobanteFecha', 'desc')->get();

            // Procesar datos para mostrar estatus legible
            foreach ($cfdis as $cfdi) {
                $estatusMap = [
                    1 => 'Borrador',
                    10 => 'Timbrando',
                    19 => 'Timbrada',
                    21 => 'Cancelada'
                ];
                $cfdi->estatus_texto = $estatusMap[$cfdi->factura_estatus] ?? 'Desconocido';
                $cfdi->tipo_texto = $cfdi->comprobanteTipoDeComprobante === 'I' ? 'Factura' : 'Nota de Crédito';
                
                if (!$cfdi->comprobanteSerie && $cfdi->serie) {
                    $cfdi->comprobanteSerie = $cfdi->serie;
                }
            }

            $stats = [
                'total' => $cfdis->count(),
                'activas' => $cfdis->where('factura_estatus', 19)->where('comprobanteTipoDeComprobante', 'I')->count(),
                'pagadas' => 0,
                'timbradas' => $cfdis->where('factura_estatus', 19)->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $cfdis,
                'stats' => $stats,
                'total_rows' => $cfdis->count()
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getData CFDI: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
                'stats' => ['total' => 0, 'activas' => 0, 'pagadas' => 0, 'timbradas' => 0]
            ], 500);
        }
    }

    /**
     * Obtener detalles de un CFDI específico
     */
    public function show($id)
    {
        try {
            $cfdi = DB::table('cfdi as c')
                ->leftJoin('facturas as f', 'c.factura_id', '=', 'f.factura_id')
                ->leftJoin('contactos as cont', 'f.contacto_id', '=', 'cont.contacto_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->where('c.cfdi_id', $id)
                ->select(
                    'c.*',
                    'f.folio as factura_folio',
                    'f.fecha as factura_fecha',
                    'f.subtotal',
                    'f.iva',
                    'f.total as factura_total',
                    'cont.razon_social as receptor_nombre',
                    'cont.rfc as receptor_rfc',
                    'cont.email_facturacion',
                    'cont.telefono',
                    'cs.serie as factura_serie'
                )
                ->first();

            if (!$cfdi) {
                return response()->json(['success' => false, 'message' => 'CFDI no encontrado'], 404);
            }

            $conceptos = DB::table('facturas_conceptos')
                ->where('factura_id', $cfdi->factura_id)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $cfdi,
                'conceptos' => $conceptos
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Descargar PDF del CFDI
     */
    public function pdf($id)
    {
        try {
            $cfdi = DB::table('cfdi as c')
                ->leftJoin('facturas as f', 'c.factura_id', '=', 'f.factura_id')
                ->leftJoin('contactos as cont', 'f.contacto_id', '=', 'cont.contacto_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->where('c.cfdi_id', $id)
                ->select(
                    'c.*',
                    'f.folio as factura_folio',
                    'f.fecha as factura_fecha',
                    'f.subtotal',
                    'f.iva',
                    'cont.razon_social as receptor_nombre',
                    'cont.rfc as receptor_rfc',
                    'cont.email_facturacion',
                    'cs.serie as factura_serie'
                )
                ->first();

            if (!$cfdi) {
                abort(404, 'CFDI no encontrado');
            }

            $conceptos = DB::table('facturas_conceptos')
                ->where('factura_id', $cfdi->factura_id)
                ->get();

            $data = [
                'cfdi' => $cfdi,
                'conceptos' => $conceptos,
                'total_letra' => $this->numeroALetras($cfdi->comprobanteTotal),
            ];

            $pdf = Pdf::loadView('cfdi.pdf', $data);
            $pdf->setPaper('letter', 'portrait');
            
            return $pdf->download('CFDI_' . $cfdi->comprobanteSerie . '-' . $cfdi->comprobanteFolio . '.pdf');
            
        } catch (\Exception $e) {
            \Log::error('Error al generar PDF CFDI: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Descargar XML del CFDI
     */
    public function xml($id)
    {
        try {
            $cfdi = DB::table('cfdi')->where('cfdi_id', $id)->first();
            
            if (!$cfdi) {
                abort(404, 'CFDI no encontrado');
            }
            
            $xml = $cfdi->xml ?? $this->generarXML($cfdi);
            $filename = 'CFDI_' . $cfdi->comprobanteSerie . '-' . $cfdi->comprobanteFolio . '.xml';
            
            return response($xml, 200)
                ->header('Content-Type', 'application/xml')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
                
        } catch (\Exception $e) {
            \Log::error('Error al generar XML CFDI: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * TIMBRAR UN CFDI EXISTENTE
     */
    public function timbrar($id)
    {
        try {
            // 1. Obtener datos de la factura
            $factura = DB::table('facturas as f')
                ->leftJoin('contactos as cont', 'f.contacto_id', '=', 'cont.contacto_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->where('f.factura_id', $id)
                ->select(
                    'f.*',
                    'cont.razon_social as receptor_nombre',
                    'cont.rfc as receptor_rfc',
                    'cont.codigo_postal as receptor_cp',
                    'cs.serie'
                )
                ->first();

            if (!$factura) {
                return response()->json([
                    'success' => false,
                    'message' => 'Factura no encontrada'
                ], 404);
            }

            // 2. Obtener conceptos
            $conceptos = DB::table('facturas_conceptos')
                ->where('factura_id', $factura->factura_id)
                ->get();

            // 3. Preparar datos para CFDI
            $cfdiData = [
                'fecha' => $factura->fecha ?? date('Y-m-d\TH:i:s'),
                'tipo' => 'I',
                'forma_pago' => $factura->forma_pago ?? '01',
                'metodo_pago' => $factura->metodo_pago ?? 'PUE',
                'moneda' => 'MXN',
                'tipo_cambio' => '1',
                'subtotal' => (float) ($factura->subtotal ?? 0),
                'total' => (float) ($factura->total ?? 0),
                'cp' => config('cfdi.emisor.cp', '45100'),
                'emisor_rfc' => config('cfdi.emisor.rfc'),
                'emisor_nombre' => config('cfdi.emisor.nombre'),
                'regimen_fiscal' => config('cfdi.emisor.regimen_fiscal', '601'),
                'receptor_rfc' => $factura->receptor_rfc ?? 'XAXX010101000',
                'receptor_nombre' => $factura->receptor_nombre ?? 'PUBLICO EN GENERAL',
                'uso_cfdi' => $factura->uso_cfdi ?? 'G01',
                'receptor_cp' => $factura->receptor_cp ?? '64000',
                'receptor_regimen' => '616', // Valor por defecto
                'conceptos' => $conceptos->map(function($item) {
                    return [
                        'clave' => $item->clave_prod_serv ?? '01010101',
                        'cantidad' => (float) ($item->cantidad ?? 1),
                        'unidad' => $item->unidad ?? 'ACT',
                        'descripcion' => $item->descripcion ?? 'Producto/Servicio',
                        'precio' => (float) ($item->precio_unitario ?? 0),
                        'importe' => (float) ($item->importe ?? 0),
                        'iva' => (float) ($item->iva ?? 0),
                        'objeto_imp' => '02',
                    ];
                })->toArray()
            ];

            // 4. Timbrar
            $resultado = $this->cfdiService->timbrarCFDI($cfdiData);

            if ($resultado['success']) {
                // 5. Guardar en la base de datos
                DB::table('cfdi')->insert([
                    'factura_id' => $factura->factura_id,
                    'comprobanteSerie' => $factura->serie ?? 'A',
                    'comprobanteFolio' => $factura->folio ?? '0001',
                    'comprobanteFecha' => date('Y-m-d'),
                    'comprobanteSubTotal' => $factura->subtotal ?? 0,
                    'comprobanteTotal' => $factura->total ?? 0,
                    'comprobanteMoneda' => 'MXN',
                    'comprobanteTipoDeComprobante' => 'I',
                    'comprobanteMetodoPago' => 'PUE',
                    'comprobanteFormaPago' => '01',
                    'comprobanteTipoCambio' => 1,
                    'timbrefiscaldigitalUUID' => $resultado['uuid'],
                    'timbrefiscaldigitalFechaTimbrado' => $resultado['fecha_timbrado'],
                    'timbrefiscaldigitalSelloCFD' => $resultado['sello'] ?? '',
                    'timbrefiscaldigitalNoCertificadoSAT' => $resultado['no_certificado'] ?? '',
                    'xml' => $resultado['xml_timbrado'] ?? '',
                    'qr_code' => $resultado['qr_code'] ?? '',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // 6. Actualizar estatus de factura
                DB::table('facturas')
                    ->where('factura_id', $factura->factura_id)
                    ->update(['estatus' => 19]); // Timbrada

                return response()->json([
                    'success' => true,
                    'message' => '✅ CFDI timbrado correctamente',
                    'uuid' => $resultado['uuid'],
                    'fecha_timbrado' => $resultado['fecha_timbrado'],
                    'qr_code' => $resultado['qr_code']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '❌ Error al timbrar',
                    'error' => $resultado['message']
                ], 500);
            }

        } catch (\Exception $e) {
            \Log::error('Error al timbrar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * CANCELAR UN CFDI
     */
    public function cancelar($id)
    {
        try {
            $cfdi = DB::table('cfdi')->where('cfdi_id', $id)->first();
            
            if (!$cfdi) {
                return response()->json([
                    'success' => false,
                    'message' => 'CFDI no encontrado'
                ], 404);
            }

            $factura = DB::table('facturas')
                ->where('factura_id', $cfdi->factura_id)
                ->first();

            $resultado = $this->cfdiService->cancelarCFDI(
                $cfdi->timbrefiscaldigitalUUID,
                config('cfdi.emisor.rfc'),
                $factura->receptor_rfc ?? null,
                $cfdi->comprobanteTotal ?? null
            );

            if ($resultado['success']) {
                // Actualizar estatus en BD
                DB::table('cfdi')
                    ->where('cfdi_id', $id)
                    ->update([
                        'cancelado' => 1,
                        'fecha_cancelacion' => $resultado['fecha_cancelacion'],
                        'updated_at' => now()
                    ]);

                DB::table('facturas')
                    ->where('factura_id', $cfdi->factura_id)
                    ->update(['estatus' => 21]); // Cancelada

                return response()->json([
                    'success' => true,
                    'message' => '✅ CFDI cancelado correctamente',
                    'fecha_cancelacion' => $resultado['fecha_cancelacion']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '❌ Error al cancelar',
                    'error' => $resultado['message']
                ], 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * CONSULTAR ESTADO DE UN CFDI
     */
    public function consultarEstado($id)
    {
        try {
            $cfdi = DB::table('cfdi')->where('cfdi_id', $id)->first();
            
            if (!$cfdi) {
                return response()->json([
                    'success' => false,
                    'message' => 'CFDI no encontrado'
                ], 404);
            }

            $factura = DB::table('facturas')
                ->where('factura_id', $cfdi->factura_id)
                ->first();

            $resultado = $this->cfdiService->consultarEstado(
                $cfdi->timbrefiscaldigitalUUID,
                config('cfdi.emisor.rfc'),
                $factura->receptor_rfc ?? 'XAXX010101000',
                $cfdi->comprobanteTotal ?? 0
            );

            return response()->json($resultado);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generar XML de prueba para timbrado
     */
    public function generarXMLPrueba()
    {
        try {
            // Crear CFDI de prueba
            $creator = new \CfdiUtils\CfdiCreator40();
            $comprobante = $creator->comprobante();
            
            // Datos del comprobante
            $comprobante->addAttributes([
                'Fecha' => date('Y-m-d\TH:i:s'),
                'TipoDeComprobante' => 'I',
                'FormaPago' => '01',
                'MetodoPago' => 'PUE',
                'Moneda' => 'MXN',
                'TipoCambio' => '1',
                'SubTotal' => '100.00',
                'Total' => '116.00',
                'LugarExpedicion' => '45100',
                'Exportacion' => '01',
            ]);

            // Emisor
            $emisor = $comprobante->getEmisor();
            $emisor->addAttributes([
                'Rfc' => config('cfdi.emisor.rfc', 'EKU9003173C9'),
                'Nombre' => config('cfdi.emisor.nombre', 'ESCUELA KEMPER URGATE'),
                'RegimenFiscal' => config('cfdi.emisor.regimen_fiscal', '601'),
            ]);

            // Receptor
            $receptor = $comprobante->getReceptor();
            $receptor->addAttributes([
                'Rfc' => 'XAXX010101000',
                'Nombre' => 'PUBLICO EN GENERAL',
                'UsoCFDI' => 'G01',
                'DomicilioFiscalReceptor' => '64000',
                'RegimenFiscalReceptor' => '616',
            ]);

            // Concepto
            $concepto = $comprobante->addConcepto([
                'ClaveProdServ' => '01010101',
                'Cantidad' => '1',
                'ClaveUnidad' => 'ACT',
                'Descripcion' => 'Producto de prueba',
                'ValorUnitario' => '100.00',
                'Importe' => '100.00',
                'ObjetoImp' => '02',
            ]);

            // Traslado de IVA
            $concepto->addTraslado([
                'Base' => '100.00',
                'Impuesto' => '002',
                'TipoFactor' => 'Tasa',
                'TasaOCuota' => '0.160000',
                'Importe' => '16.00',
            ]);

            // Impuestos del comprobante
            $impuestos = $comprobante->getImpuestos();
            $impuestos->addTraslado([
                'Impuesto' => '002',
                'TipoFactor' => 'Tasa',
                'TasaOCuota' => '0.160000',
                'Importe' => '16.00',
            ]);

            $xml = $creator->asXml();

            return response($xml, 200)
                ->header('Content-Type', 'application/xml')
                ->header('Content-Disposition', 'inline; filename="cfdi_prueba.xml"');

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al generar XML: ' . $e->getMessage()
            ], 500);
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
            return number_format($numero, 2) . ' pesos 00/100 M.N.';
        }
    }

    /**
     * Generar XML básico
     */
    private function generarXML($cfdi)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<cfdi:Comprobante xmlns:cfdi="http://www.sat.gob.mx/cfd/4" 
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
            Version="4.0" 
            Serie="' . htmlspecialchars($cfdi->comprobanteSerie ?? '') . '" 
            Folio="' . htmlspecialchars($cfdi->comprobanteFolio ?? '') . '" 
            Fecha="' . ($cfdi->comprobanteFecha ?? now()->format('Y-m-d')) . 'T12:00:00" 
            Moneda="' . ($cfdi->comprobanteMoneda ?? 'MXN') . '" 
            TipoCambio="' . ($cfdi->comprobanteTipoCambio ?? 1) . '" 
            SubTotal="' . number_format($cfdi->comprobanteSubTotal ?? 0, 2, '.', '') . '" 
            Total="' . number_format($cfdi->comprobanteTotal ?? 0, 2, '.', '') . '" 
            TipoDeComprobante="' . ($cfdi->comprobanteTipoDeComprobante ?? 'I') . '" 
            MetodoPago="' . ($cfdi->comprobanteMetodoPago ?? 'PUE') . '" 
            FormaPago="' . ($cfdi->comprobanteFormaPago ?? '01') . '" 
            Exportacion="01" 
            LugarExpedicion="64000">';
        
        $xml .= '<cfdi:Complemento>
            <tfd:TimbreFiscalDigital xmlns:tfd="http://www.sat.gob.mx/TimbreFiscalDigital" 
                Version="1.1" 
                UUID="' . ($cfdi->timbrefiscaldigitalUUID ?? '') . '" 
                FechaTimbrado="' . ($cfdi->timbrefiscaldigitalFechaTimbrado ?? now()->format('Y-m-d\TH:i:s')) . '" 
                RfcProvCertif="AAA010101AAA"/>
        </cfdi:Complemento>';
        
        $xml .= '</cfdi:Comprobante>';
        
        return $xml;
    }
}