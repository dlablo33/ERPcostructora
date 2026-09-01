<?php

namespace App\Services;

use CfdiUtils\CfdiCreator40;
use CfdiUtils\Certificado\Certificado;
use CfdiUtils\Pac\Sw\SwRequest;
use CfdiUtils\Pac\Sw\SwSoapConsumer;
use Illuminate\Support\Facades\Log;

class CFDIService
{
    protected $pacUrl;
    protected $pacUser;
    protected $pacPassword;

    public function __construct()
    {
        $this->pacUrl = config('cfdi.pac.url', 'https://services.test.sw.com.mx');
        $this->pacUser = config('cfdi.pac.user');
        $this->pacPassword = config('cfdi.pac.password');
    }

    /**
     * Timbrar un CFDI existente (desde tu base de datos)
     */
    public function timbrarCFDI($cfdiData, $xml = null)
    {
        try {
            // Si no se proporciona XML, generarlo desde los datos
            if (!$xml) {
                $xml = $this->generarXMLDesdeDatos($cfdiData);
            }

            // Cargar certificados
            $cerPath = config('cfdi.certificates.cer_path');
            $keyPath = config('cfdi.certificates.key_path');
            $password = config('cfdi.certificates.password', '');

            if (!file_exists($cerPath) || !file_exists($keyPath)) {
                return [
                    'success' => false,
                    'message' => 'No se encontraron los certificados',
                    'cer_exists' => file_exists($cerPath),
                    'key_exists' => file_exists($keyPath)
                ];
            }

            // Crear el CFDI desde XML
            $creator = CfdiCreator40::fromXml($xml);
            
            // Firmar
            $certificado = new Certificado($cerPath, $keyPath, $password);
            $creator->addSello($certificado);
            $xmlFirmado = $creator->asXml();

            // Preparar cliente SW Test
            $client = new SwSoapConsumer();
            $client->setUrl($this->pacUrl . '/cfdi40/issue/json');
            $client->authenticate($this->pacUser, $this->pacPassword);

            // Preparar solicitud
            $request = new SwRequest();
            $request->setComprobante($xmlFirmado);
            $request->setCertificado(file_get_contents($cerPath));
            $request->setLlave(file_get_contents($keyPath));
            $request->setPassword($password);

            // Timbrar
            $response = $client->issue($request);

            if ($response->getStatus() === 'success') {
                return [
                    'success' => true,
                    'uuid' => $response->getUuid(),
                    'fecha_timbrado' => $response->getFechaTimbrado(),
                    'sello' => $response->getSelloSfd(),
                    'no_certificado' => $response->getNoCertificadoSfd(),
                    'qr_code' => $response->getQrCode(),
                    'xml_timbrado' => $response->getComprobante(),
                    'xml_firmado' => $xmlFirmado
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $response->getMessage(),
                    'code' => $response->getCode()
                ];
            }

        } catch (\Exception $e) {
            Log::error('Error al timbrar CFDI: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ];
        }
    }

    /**
     * Generar XML desde datos de la factura
     */
    public function generarXMLDesdeDatos($data)
    {
        $creator = new CfdiCreator40();
        $comprobante = $creator->comprobante();

        // Datos del comprobante
        $comprobante->addAttributes([
            'Fecha' => $data['fecha'] ?? date('Y-m-d\TH:i:s'),
            'TipoDeComprobante' => $data['tipo'] ?? 'I',
            'FormaPago' => $data['forma_pago'] ?? '01',
            'MetodoPago' => $data['metodo_pago'] ?? 'PUE',
            'Moneda' => $data['moneda'] ?? 'MXN',
            'TipoCambio' => $data['tipo_cambio'] ?? '1',
            'SubTotal' => number_format($data['subtotal'] ?? 0, 2, '.', ''),
            'Total' => number_format($data['total'] ?? 0, 2, '.', ''),
            'LugarExpedicion' => $data['cp'] ?? '45100',
            'Exportacion' => $data['exportacion'] ?? '01',
        ]);

        // Emisor
        $emisor = $comprobante->getEmisor();
        $emisor->addAttributes([
            'Rfc' => $data['emisor_rfc'] ?? config('cfdi.emisor.rfc'),
            'Nombre' => $data['emisor_nombre'] ?? config('cfdi.emisor.nombre'),
            'RegimenFiscal' => $data['regimen_fiscal'] ?? '601',
        ]);

        // Receptor
        $receptor = $comprobante->getReceptor();
        $receptor->addAttributes([
            'Rfc' => $data['receptor_rfc'] ?? 'XAXX010101000',
            'Nombre' => $data['receptor_nombre'] ?? 'PUBLICO EN GENERAL',
            'UsoCFDI' => $data['uso_cfdi'] ?? 'G01',
            'DomicilioFiscalReceptor' => $data['receptor_cp'] ?? '64000',
            'RegimenFiscalReceptor' => $data['receptor_regimen'] ?? '616',
        ]);

        // Conceptos
        if (isset($data['conceptos']) && is_array($data['conceptos'])) {
            foreach ($data['conceptos'] as $conceptoData) {
                $concepto = $comprobante->addConcepto([
                    'ClaveProdServ' => $conceptoData['clave'] ?? '01010101',
                    'Cantidad' => $conceptoData['cantidad'] ?? 1,
                    'ClaveUnidad' => $conceptoData['unidad'] ?? 'ACT',
                    'Descripcion' => $conceptoData['descripcion'] ?? 'Producto/Servicio',
                    'ValorUnitario' => number_format($conceptoData['precio'] ?? 0, 2, '.', ''),
                    'Importe' => number_format($conceptoData['importe'] ?? 0, 2, '.', ''),
                    'ObjetoImp' => $conceptoData['objeto_imp'] ?? '02',
                ]);

                // Traslados
                if (isset($conceptoData['iva']) && $conceptoData['iva'] > 0) {
                    $concepto->addTraslado([
                        'Base' => number_format($conceptoData['importe'] ?? 0, 2, '.', ''),
                        'Impuesto' => '002',
                        'TipoFactor' => 'Tasa',
                        'TasaOCuota' => '0.160000',
                        'Importe' => number_format($conceptoData['iva'] ?? 0, 2, '.', ''),
                    ]);
                }
            }
        }

        return $creator->asXml();
    }

    /**
     * Cancelar un CFDI
     */
    public function cancelarCFDI($uuid, $rfcEmisor, $rfcReceptor = null, $total = null)
    {
        try {
            $cerPath = config('cfdi.certificates.cer_path');
            $keyPath = config('cfdi.certificates.key_path');
            $password = config('cfdi.certificates.password', '');

            if (!file_exists($cerPath) || !file_exists($keyPath)) {
                return [
                    'success' => false,
                    'message' => 'No se encontraron los certificados'
                ];
            }

            $client = new SwSoapConsumer();
            $client->setUrl($this->pacUrl . '/cfdi40/cancel/json');
            $client->authenticate($this->pacUser, $this->pacPassword);

            // Crear solicitud de cancelación
            $xmlCancelacion = $this->generarXMLCancelacion($uuid, $rfcEmisor);
            
            $request = new SwRequest();
            $request->setComprobante($xmlCancelacion);
            $request->setCertificado(file_get_contents($cerPath));
            $request->setLlave(file_get_contents($keyPath));
            $request->setPassword($password);

            $response = $client->cancel($request);

            if ($response->getStatus() === 'success') {
                return [
                    'success' => true,
                    'uuid' => $uuid,
                    'fecha_cancelacion' => $response->getFecha(),
                    'acuse' => $response->getAcuse()
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $response->getMessage(),
                    'code' => $response->getCode()
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function generarXMLCancelacion($uuid, $rfcEmisor)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<Cancelacion xmlns="http://www.sat.gob.mx/esquemas/cancelacion" 
            Version="1.0" 
            RfcEmisor="' . $rfcEmisor . '" 
            Fecha="' . date('Y-m-d\TH:i:s') . '">';
        $xml .= '<Folios>';
        $xml .= '<Folio UUID="' . $uuid . '" Motivo="01"/>';
        $xml .= '</Folios>';
        $xml .= '</Cancelacion>';
        return $xml;
    }

    /**
     * Obtener estado de un CFDI
     */
    public function consultarEstado($uuid, $rfcEmisor, $rfcReceptor, $total)
    {
        try {
            $client = new SwSoapConsumer();
            $client->setUrl($this->pacUrl . '/cfdi40/query/json');
            $client->authenticate($this->pacUser, $this->pacPassword);

            $xml = '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<Consulta xmlns="http://www.sat.gob.mx/esquemas/consulta" 
                Version="1.0" 
                RfcEmisor="' . $rfcEmisor . '" 
                RfcReceptor="' . $rfcReceptor . '" 
                Total="' . number_format($total, 2, '.', '') . '" 
                UUID="' . $uuid . '"/>';

            $request = new SwRequest();
            $request->setComprobante($xml);
            $request->setCertificado(file_get_contents(config('cfdi.certificates.cer_path')));

            $response = $client->query($request);

            return [
                'success' => true,
                'uuid' => $uuid,
                'estado' => $response->getEstado(),
                'fecha_cancelacion' => $response->getFechaCancelacion() ?? null
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}