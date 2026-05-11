<?php
// app/Http/Controllers/Facturacion/CFDIController.php

namespace App\Http\Controllers\Facturacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class CFDIController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
                // Mapear estatus de la factura
                $estatusMap = [
                    1 => 'Borrador',
                    10 => 'Timbrando',
                    19 => 'Timbrada',
                    21 => 'Cancelada'
                ];
                $cfdi->estatus_texto = $estatusMap[$cfdi->factura_estatus] ?? 'Desconocido';
                
                // Tipo de comprobante
                $cfdi->tipo_texto = $cfdi->comprobanteTipoDeComprobante === 'I' ? 'Factura' : 'Nota de Crédito';
                
                // Si no hay serie del cat_series, usar la del CFDI
                if (!$cfdi->comprobanteSerie && $cfdi->serie) {
                    $cfdi->comprobanteSerie = $cfdi->serie;
                }
            }

            $stats = [
                'total' => $cfdis->count(),
                'activas' => $cfdis->where('factura_estatus', 19)->where('comprobanteTipoDeComprobante', 'I')->count(),
                'pagadas' => 0, // Esto vendría de otra tabla
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

            // Obtener conceptos de la factura relacionada
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

    private function numeroALetras($numero)
    {
        try {
            $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
            return ucfirst($formatter->format($numero)) . ' pesos 00/100 M.N.';
        } catch (\Exception $e) {
            return number_format($numero, 2) . ' pesos 00/100 M.N.';
        }
    }

    private function generarXML($cfdi)
    {
        // XML básico si no existe en la BD
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