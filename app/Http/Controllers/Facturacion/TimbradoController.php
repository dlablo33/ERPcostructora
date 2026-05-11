<?php

namespace App\Http\Controllers\Facturacion;

use App\Http\Controllers\Controller;
use App\Models\Facturacion\Factura;
use App\Models\Facturacion\CFDI;
use App\Models\Facturacion\CFDIRelacionado;
use App\Models\Facturacion\SatcatTipoRelacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use SimpleXMLElement;

class TimbradoController extends Controller
{
    protected $pacUrl;
    protected $pacUser;
    protected $pacPassword;
    
    public function __construct()
    {
        // Configurar desde variables de entorno o base de datos
        $this->pacUrl = env('SW_URL', 'https://api.sw.com.mx/v2/');
        $this->pacUser = env('SW_USER', '');
        $this->pacPassword = env('SW_PASSWORD', '');
    }
    
    /**
     * Genera el XML del CFDI y lo timbra con SW Sapien
     */
    public function timbrarCFDI(Factura $factura)
    {
        try {
            // 1. Construir XML del CFDI 4.0
            $xmlString = $this->generarXMLCFDI($factura);
            
            // 2. Llamar a API de SW Sapien para timbrar
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getToken(),
                'Content-Type' => 'application/xml',
            ])->post($this->pacUrl . 'cfdi33/timbrado', $xmlString);
            
            if ($response->successful()) {
                $xmlTimbrado = $response->body();
                // Procesar respuesta y extraer UUID, sello, etc.
                $datosTimbrado = $this->procesarXMLTimbrado($xmlTimbrado, $factura);
                
                // Guardar CFDI en base de datos
                $cfdi = CFDI::create([
                    'factura_id' => $factura->factura_id,
                    'timbrefiscaldigitalUUID' => $datosTimbrado['uuid'],
                    'timbrefiscaldigitalFechaTimbrado' => $datosTimbrado['fechaTimbrado'],
                    'timbrefiscaldigitalSelloCFD' => $datosTimbrado['selloCFD'],
                    'timbrefiscaldigitalSelloSAT' => $datosTimbrado['selloSAT'],
                    'timbrefiscaldigitalNoCertificadoSAT' => $datosTimbrado['noCertificadoSAT'],
                    'comprobanteSerie' => $factura->serie->serie,
                    'comprobanteFolio' => $factura->folio,
                    'comprobanteFecha' => $factura->fecha,
                    'comprobanteMoneda' => $factura->cat_monedas_clave,
                    'comprobanteTipoCambio' => $factura->tipo_cambio,
                    'comprobanteSubTotal' => $factura->subtotal,
                    'comprobanteTotal' => $factura->total,
                    'comprobanteTipoDeComprobante' => 'I',
                    'comprobanteMetodoPago' => $factura->satcat_metodos_pago_clave,
                    'comprobanteFormaPago' => $factura->satcat_formas_pago_clave,
                    'comprobanteNoCertificado' => $datosTimbrado['noCertificadoEmisor'],
                    'comprobanteSello' => $datosTimbrado['selloEmisor'],
                    'emisorRfc' => $factura->serie->datosGenerales->rfc,
                    'receptorRfc' => $factura->contacto->rfc,
                    'cadena_original' => $datosTimbrado['cadenaOriginal'] ?? null,
                ]);
                
                // Actualizar factura con XML timbrado
                $factura->update(['xml' => $xmlTimbrado]);
                
                return ['success' => true, 'uuid' => $datosTimbrado['uuid'], 'xml' => $xmlTimbrado];
            } else {
                Log::error('Error timbrando CFDI: ' . $response->body());
                return ['success' => false, 'error' => $response->json()['message'] ?? 'Error al timbrar'];
            }
        } catch (\Exception $e) {
            Log::error('Excepción en timbrado: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Cancelar CFDI con SW Sapien
     */
    public function cancelarCFDI(Factura $factura, $motivo)
    {
        try {
            $cfdi = $factura->cfdi;
            if (!$cfdi) {
                return ['success' => false, 'error' => 'La factura no tiene CFDI asociado'];
            }
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getToken(),
                'Content-Type' => 'application/json',
            ])->post($this->pacUrl . 'cfdi33/cancelacion', [
                'uuid' => $cfdi->timbrefiscaldigitalUUID,
                'rfc_emisor' => $factura->serie->datosGenerales->rfc,
                'rfc_receptor' => $factura->contacto->rfc,
                'total' => $factura->total,
                'motivo' => $motivo,
                'folio_sustitucion' => null,
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] == 'success') {
                    return ['success' => true];
                }
                return ['success' => false, 'error' => $data['message'] ?? 'Cancelación fallida'];
            }
            return ['success' => false, 'error' => 'Error de comunicación con el PAC'];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Obtener token de autenticación para SW Sapien
     */
    private function getToken()
    {
        // Implementar obtención de token (puede ser cacheado)
        $response = Http::post($this->pacUrl . 'auth/login', [
            'username' => $this->pacUser,
            'password' => $this->pacPassword,
        ]);
        
        if ($response->successful()) {
            return $response->json()['token'];
        }
        throw new \Exception('No se pudo obtener token de SW');
    }
    
    /**
     * Genera el string XML del CFDI versión 4.0 (sin Carta Porte)
     */
    private function generarXMLCFDI(Factura $factura)
    {
        $empresa = $factura->serie->datosGenerales;
        $cliente = $factura->contacto;
        $sucursal = $factura->sucursal;
        
        // Crear el documento XML
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><cfdi:Comprobante xmlns:cfdi="http://www.sat.gob.mx/cfd/4" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd"/>');
        
        // Atributos del comprobante
        $xml->addAttribute('Version', '4.0');
        $xml->addAttribute('Serie', $factura->serie->serie);
        $xml->addAttribute('Folio', $factura->folio);
        $xml->addAttribute('Fecha', $factura->fecha->format('Y-m-d\TH:i:s'));
        $xml->addAttribute('FormaPago', $factura->satcat_formas_pago_clave);
        $xml->addAttribute('NoCertificado', $empresa->certificado_no_serie ?? '00000000000000000000');
        $xml->addAttribute('SubTotal', number_format($factura->subtotal, 2, '.', ''));
        $xml->addAttribute('Moneda', $factura->cat_monedas_clave);
        if ($factura->cat_monedas_clave != 'MXN') {
            $xml->addAttribute('TipoCambio', number_format($factura->tipo_cambio, 6, '.', ''));
        }
        $xml->addAttribute('Total', number_format($factura->total, 2, '.', ''));
        $xml->addAttribute('TipoDeComprobante', 'I');
        $xml->addAttribute('Exportacion', '01'); // 01 = No aplica
        $xml->addAttribute('MetodoPago', $factura->satcat_metodos_pago_clave);
        $xml->addAttribute('LugarExpedicion', $sucursal->codigo_postal);
        
        // Emisor
        $emisor = $xml->addChild('cfdi:Emisor');
        $emisor->addAttribute('Rfc', $empresa->rfc);
        $emisor->addAttribute('Nombre', $empresa->razon_social);
        $emisor->addAttribute('RegimenFiscal', $empresa->satcat_regimen_fiscal_clave);
        
        // Receptor
        $receptor = $xml->addChild('cfdi:Receptor');
        $receptor->addAttribute('Rfc', $cliente->rfc);
        $receptor->addAttribute('Nombre', $cliente->razon_social);
        $receptor->addAttribute('DomicilioFiscalReceptor', $cliente->codigo_postal);
        $receptor->addAttribute('RegimenFiscalReceptor', $cliente->satcat_regimen_fiscal_clave);
        $receptor->addAttribute('UsoCFDI', $cliente->satcat_uso_cfdi_clave);
        
        // Conceptos
        $conceptos = $xml->addChild('cfdi:Conceptos');
        foreach ($factura->conceptos as $item) {
            $concepto = $conceptos->addChild('cfdi:Concepto');
            $concepto->addAttribute('ClaveProdServ', $item->satcat_clave_productos_clave);
            $concepto->addAttribute('Cantidad', number_format($item->cantidad, 4, '.', ''));
            $concepto->addAttribute('ClaveUnidad', $item->satcat_unidades_clave);
            $concepto->addAttribute('Unidad', 'Unidad de Servicio'); // Podría mejorarse
            $concepto->addAttribute('Descripcion', $item->descripcion);
            $concepto->addAttribute('ValorUnitario', number_format($item->valor_unitario, 4, '.', ''));
            $concepto->addAttribute('Importe', number_format($item->importe, 2, '.', ''));
            $concepto->addAttribute('ObjetoImp', '02'); // Sí objeto de impuesto
            
            // Impuestos del concepto
            $impuestosConcepto = $concepto->addChild('cfdi:Impuestos');
            $traslados = $impuestosConcepto->addChild('cfdi:Traslados');
            $traslado = $traslados->addChild('cfdi:Traslado');
            $traslado->addAttribute('Base', number_format($item->importe, 2, '.', ''));
            $traslado->addAttribute('Impuesto', '002'); // IVA
            $traslado->addAttribute('TipoFactor', 'Tasa');
            $traslado->addAttribute('TasaOCuota', '0.160000');
            $traslado->addAttribute('Importe', number_format($item->iva, 2, '.', ''));
        }
        
        // Impuestos totales
        $impuestos = $xml->addChild('cfdi:Impuestos');
        $impuestos->addAttribute('TotalImpuestosTrasladados', number_format($factura->iva, 2, '.', ''));
        $trasladosTotales = $impuestos->addChild('cfdi:Traslados');
        $trasladoTotal = $trasladosTotales->addChild('cfdi:Traslado');
        $trasladoTotal->addAttribute('Base', number_format($factura->subtotal, 2, '.', ''));
        $trasladoTotal->addAttribute('Impuesto', '002');
        $trasladoTotal->addAttribute('TipoFactor', 'Tasa');
        $trasladoTotal->addAttribute('TasaOCuota', '0.160000');
        $trasladoTotal->addAttribute('Importe', number_format($factura->iva, 2, '.', ''));
        
        return $xml->asXML();
    }
    
    /**
     * Procesa el XML timbrado devuelto por el PAC
     */
    private function procesarXMLTimbrado($xmlString, Factura $factura)
    {
        $xml = new SimpleXMLElement($xmlString);
        $xml->registerXPathNamespace('tfd', 'http://www.sat.gob.mx/TimbreFiscalDigital');
        
        $timbre = $xml->xpath('//tfd:TimbreFiscalDigital');
        if (empty($timbre)) {
            throw new \Exception('No se encontró el timbre fiscal en el XML');
        }
        
        return [
            'uuid' => (string)$timbre[0]['UUID'],
            'fechaTimbrado' => (string)$timbre[0]['FechaTimbrado'],
            'selloCFD' => (string)$timbre[0]['SelloCFD'],
            'selloSAT' => (string)$timbre[0]['SelloSAT'],
            'noCertificadoSAT' => (string)$timbre[0]['NoCertificadoSAT'],
            'selloEmisor' => (string)$xml['Sello'],
            'noCertificadoEmisor' => (string)$xml['NoCertificado'],
        ];
    }
}