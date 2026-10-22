<?php

namespace App\Http\Controllers\Facturacion;

use App\Http\Controllers\Controller;
use App\Models\Facturacion\Factura;
use App\Models\Facturacion\CFDI;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use CfdiUtils\CfdiCreator40;
use CfdiUtils\Certificado\Certificado;
use CfdiUtils\XmlResolver\XmlResolver;
use Exception;

class TimbradoController extends Controller
{
    protected string $baseUrl;
    protected string $user;
    protected string $password;
    protected string $cerPath;
    protected string $keyPath;
    protected string $csdPassword;
    protected ?string $xmlResolverPath;
    protected bool $debug;

    public function __construct()
    {
        $this->baseUrl         = rtrim(env('SW_URL', 'https://services.test.sw.com.mx'), '/');
        $this->user            = env('SW_USER', '');
        $this->password        = env('SW_PASSWORD', '');
        $this->cerPath         = env('CSD_CER_PATH', 'certs/csd.cer');
        $this->keyPath         = env('CSD_KEY_PATH', 'certs/csd.key.pem');
        $this->csdPassword     = env('CSD_PASSWORD', '');
        $this->xmlResolverPath = env('CFDI_XSD_PATH', storage_path('app/xsd/sat'));
        $this->debug           = (bool) env('CFDI_DEBUG', false);
    }

    private function getToken(): string
    {
        return Cache::remember('sw_token_' . md5($this->user), now()->addMinutes(170), function () {
            $response = Http::post($this->baseUrl . '/v2/security/authenticate', [
                'user'     => $this->user,
                'password' => $this->password,
            ]);

            if (!$response->successful()) {
                throw new Exception('SW Auth HTTP ' . $response->status() . ': ' . $response->body());
            }

            $data = $response->json();
            if (($data['status'] ?? '') !== 'success') {
                throw new Exception('SW Auth: ' . ($data['message'] ?? 'Error de autenticación'));
            }

            return $data['data']['token'];
        });
    }

    /**
     * TIMBRAR: Timbrado Corporativo (XML pre-sellado).
     */
    public function timbrarFactura(Factura $factura): array
    {
        try {
            $xmlSellado = $this->generarYSellarXML($factura);
            $token = $this->getToken();

            $response = Http::withToken($token)
                ->attach('xml', $xmlSellado, 'cfdi.xml')
                ->post($this->baseUrl . '/cfdi33/stamp/v4');

            if (!$response->successful()) {
                Log::error('SW Timbrado HTTP error', ['status' => $response->status(), 'body' => $response->body()]);
                return ['success' => false, 'error' => 'HTTP ' . $response->status() . ': ' . $response->body()];
            }

            $data = $response->json();
            if (($data['status'] ?? '') !== 'success') {
                return [
                    'success' => false,
                    'error'   => $data['message'] ?? 'Error desconocido al timbrar',
                    'detail'  => $data['messageDetail'] ?? null,
                ];
            }

            $timbrado = $data['data'];
            $this->guardarCFDI($factura, $timbrado);

            $factura->update([
                'xml'     => $timbrado['cfdi'] ?? null,
                'estatus' => 19,
            ]);

            return [
                'success' => true,
                'uuid'    => $timbrado['uuid'],
                'xml'     => $timbrado['cfdi'],
            ];

        } catch (Exception $e) {
            Log::error('Excepción timbrado: ' . $e->getMessage(), ['factura_id' => $factura->factura_id]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * CANCELAR: Cancelación por CSD con .cer/.key en Base64.
     *
     * Fix: los UUID del SAT vienen en MAYÚSCULAS aunque en BD estén en minúsculas,
     * por eso normalizamos ambos al buscar el código de respuesta.
     */
    public function cancelarFactura(Factura $factura, string $motivo = '02', ?string $folioSustitucion = null): array
    {
        try {
            $cfdi = $factura->cfdi;
            if (!$cfdi || !$cfdi->timbrefiscaldigitalUUID) {
                return ['success' => false, 'error' => 'La factura no tiene UUID timbrado'];
            }

            if ($motivo === '01' && !$folioSustitucion) {
                return ['success' => false, 'error' => 'Motivo 01 requiere folio de sustitución'];
            }
            if ($motivo !== '01') {
                $folioSustitucion = null;
            }

            $token = $this->getToken();

            $cerContent = Storage::get($this->cerPath);
            $keyDerPath = preg_replace('/\.pem$/', '', $this->keyPath);
            if (!Storage::exists($keyDerPath)) {
                return [
                    'success' => false,
                    'error'   => 'No se encontró el archivo .key original (DER) en: ' . $keyDerPath,
                ];
            }
            $keyContent = Storage::get($keyDerPath);

            $payload = [
                'uuid'     => $cfdi->timbrefiscaldigitalUUID,
                'password' => $this->csdPassword,
                'rfc'      => $factura->serie->datosGenerales->rfc,
                'motivo'   => $motivo,
                'b64Cer'   => base64_encode($cerContent),
                'b64Key'   => base64_encode($keyContent),
            ];

            if ($motivo === '01') {
                $payload['folioSustitucion'] = $folioSustitucion;
            }

            $response = Http::withToken($token)
                ->acceptJson()
                ->post($this->baseUrl . '/cfdi33/cancel/csd', $payload);

            if (!$response->successful()) {
                Log::error('SW Cancelación HTTP error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return ['success' => false, 'error' => 'HTTP ' . $response->status() . ': ' . $response->body()];
            }

            $data = $response->json();

            if (($data['status'] ?? '') !== 'success') {
                return [
                    'success' => false,
                    'error'   => $data['message'] ?? 'Error de cancelación',
                    'detail'  => $data['messageDetail'] ?? null,
                ];
            }

            // [FIX] El SAT devuelve el UUID en MAYÚSCULAS aunque en BD esté en minúsculas.
            // Normalizamos ambos y comparamos case-insensitive.
            $uuidResult  = $data['data']['uuid'] ?? [];
            $uuidBuscado = strtoupper($cfdi->timbrefiscaldigitalUUID);
            $codigo      = null;

            if (is_array($uuidResult)) {
                foreach ($uuidResult as $uuidKey => $uuidCodigo) {
                    if (strtoupper($uuidKey) === $uuidBuscado) {
                        $codigo = $uuidCodigo;
                        break;
                    }
                }
            }

            // 201 = solicitud exitosa, 202 = previamente cancelado
            if (in_array($codigo, ['201', '202'])) {
                $factura->update([
                    'estatus'          => 21,
                    'saldo_disponible' => 0,
                ]);
                return [
                    'success' => true,
                    'codigo'  => $codigo,
                    'acuse'   => $data['data']['acuse'] ?? null,
                ];
            }

            return [
                'success' => false,
                'error'   => 'SAT rechazó la cancelación. Código: ' . ($codigo ?: 'sin código') . ' - ' . ($data['data']['message'] ?? ''),
            ];

        } catch (Exception $e) {
            Log::error('Excepción cancelación: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * [NEW] CONSULTAR ESTATUS: consulta al SAT el estatus actual de la factura
     * y actualiza la BD local si ya cambió (ej. si se completó la cancelación).
     *
     * Endpoint SW: GET /cfdi33/status/{rfcEmisor}/{rfcReceptor}/{total}/{uuid}
     *
     * Devuelve:
     *  - success: bool
     *  - estatus_sat: 'Vigente' | 'Cancelado' | 'No Encontrado' | 'En Proceso'
     *  - estatus_local: el estatus interno antes de la consulta
     *  - actualizado: bool (si la BD se modificó)
     */
    public function consultarEstatusFactura(Factura $factura): array
{
    try {
        $cfdi = $factura->cfdi;
        if (!$cfdi || !$cfdi->timbrefiscaldigitalUUID) {
            return ['success' => false, 'error' => 'La factura no tiene UUID timbrado'];
        }

        $rfcEmisor   = $factura->serie->datosGenerales->rfc;
        $rfcReceptor = $factura->contacto->rfc;
        $total       = number_format((float) $factura->total, 2, '.', '');
        $uuid        = $cfdi->timbrefiscaldigitalUUID;
        
        // El parámetro 'fe' son los últimos 8 caracteres del sello del emisor.
        // Si no lo tienes guardado, puedes enviarlo vacío; SW a veces lo tolera en pruebas.
        $sello = $cfdi->comprobanteSello ?? '';
        $fe    = substr($sello, -8);

        // Construir la expresión impresa que espera el SAT
        $expresion = "?re={$rfcEmisor}&rr={$rfcReceptor}&tt={$total}&id={$uuid}&fe={$fe}";

        // XML SOAP que espera el servicio
        $soapBody = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
   <soapenv:Header/>
   <soapenv:Body>
      <tem:Consulta>
         <tem:expresionImpresa><![CDATA[{$expresion}]]></tem:expresionImpresa>
      </tem:Consulta>
   </soapenv:Body>
</soapenv:Envelope>
XML;

        $response = Http::withHeaders([
            'Content-Type' => 'text/xml;charset="utf-8"',
            'SOAPAction'   => 'http://tempuri.org/IConsultaCFDIService/Consulta',
            'Accept'       => 'text/xml',
        ])->withBody($soapBody, 'text/xml')->post('https://api.test.sw.com.mx/ConsultaCFDIService.svc');

        if (!$response->successful()) {
            return ['success' => false, 'error' => 'HTTP ' . $response->status() . ': ' . $response->body()];
        }

        // El servicio SIEMPRE responde HTTP 200, incluso si hay error.
        // Hay que parsear el XML de respuesta para obtener los campos.
        $xmlString = $response->body();
        
        // Parsear la respuesta SOAP (buscar los nodos a:Estado, a:EsCancelable, etc.)
        // Usamos SimpleXML con los namespaces correctos
        $xml = simplexml_load_string($xmlString);
        if ($xml === false) {
            return ['success' => false, 'error' => 'No se pudo parsear la respuesta SOAP'];
        }

        $xml->registerXPathNamespace('s', 'http://schemas.xmlsoap.org/soap/envelope/');
        $xml->registerXPathNamespace('a', 'http://schemas.datacontract.org/2004/07/Sat.Cfdi.Negocio.ConsultaCfdi.Servicio');

        $estado    = (string) ($xml->xpath('//a:Estado')[0] ?? 'Desconocido');
        $esCancelable = (string) ($xml->xpath('//a:EsCancelable')[0] ?? '');
        $codigoEstatus = (string) ($xml->xpath('//a:CodigoEstatus')[0] ?? '');
        $estatusCancelacion = (string) ($xml->xpath('//a:EstatusCancelacion')[0] ?? '');

        // Mapear el Estado del SAT a estatus interno
        $estatusLocal = $factura->estatus;
        $nuevoEstatus = null;
        $actualizado = false;

        if (strcasecmp($estado, 'Cancelado') === 0) {
            $nuevoEstatus = 21;
        } elseif (strcasecmp($estado, 'Vigente') === 0) {
            $nuevoEstatus = 19;
        }

        if ($nuevoEstatus !== null && $nuevoEstatus !== $estatusLocal) {
            $updateData = ['estatus' => $nuevoEstatus, 'updated_at' => now()];
            if ($nuevoEstatus === 21) {
                $updateData['saldo_disponible'] = 0;
            }
            $factura->update($updateData);
            $actualizado = true;
        }

        return [
            'success'            => true,
            'estatus_sat'        => $estado,
            'codigo_estatus'     => $codigoEstatus,
            'es_cancelable'      => $esCancelable,
            'estatus_cancelacion'=> $estatusCancelacion,
            'estatus_local'      => $estatusLocal,
            'estatus_nuevo'      => $nuevoEstatus,
            'actualizado'        => $actualizado,
        ];

    } catch (Exception $e) {
        Log::error('Excepción consultarEstatus: ' . $e->getMessage());
        return ['success' => false, 'error' => $e->getMessage()];
    }
}

    /**
     * Genera el XML CFDI 4.0 completo y lo sella con el CSD del emisor.
     */
    private function generarYSellarXML(Factura $factura): string
    {
        $empresa  = $factura->serie->datosGenerales;
        $cliente  = $factura->contacto;
        $sucursal = $factura->sucursal;

        $certificado = new Certificado(Storage::path($this->cerPath));

        $atributos = [
            'Version'           => '4.0',
            'Serie'             => $factura->serie->serie,
            'Folio'             => $factura->folio,
            'Fecha'             => $factura->fecha->format('Y-m-d\TH:i:s'),
            'FormaPago'         => $factura->satcat_formas_pago_clave,
            'SubTotal'          => number_format((float) $factura->subtotal, 2, '.', ''),
            'Moneda'            => $factura->cat_monedas_clave,
            'Total'             => number_format((float) $factura->total, 2, '.', ''),
            'TipoDeComprobante' => 'I',
            'Exportacion'       => '01',
            'MetodoPago'        => $factura->satcat_metodos_pago_clave,
            'LugarExpedicion'   => $sucursal->codigo_postal,
        ];

        if ($factura->cat_monedas_clave !== 'MXN') {
            $atributos['TipoCambio'] = number_format((float) $factura->tipo_cambio, 6, '.', '');
        }

        $creator = new CfdiCreator40($atributos, $certificado);
        $creator->putCertificado($certificado, false);

        if ($this->xmlResolverPath && is_dir($this->xmlResolverPath)) {
            $creator->setXmlResolver(new XmlResolver($this->xmlResolverPath));
        }

        $comprobante = $creator->comprobante();

        if ($cliente->rfc === 'XAXX010101000' && $cliente->razon_social === 'PUBLICO EN GENERAL') {
            $comprobante->addInformacionGlobal([
                'Periodicidad' => '04',
                'Meses'        => $factura->fecha->format('m'),
                'Año'          => $factura->fecha->format('Y'),
            ]);
        }

        $comprobante->addEmisor([
            'Rfc'           => $empresa->rfc,
            'Nombre'        => $empresa->razon_social,
            'RegimenFiscal' => $empresa->satcat_regimen_fiscal_clave,
        ]);

        // [AUTO] Si el receptor es público en general, DomicilioFiscalReceptor = LugarExpedicion
        $domicilioReceptor = $cliente->codigo_postal;
        if ($cliente->rfc === 'XAXX010101000') {
            $domicilioReceptor = $sucursal->codigo_postal;
        }

        $comprobante->addReceptor([
            'Rfc'                     => $cliente->rfc,
            'Nombre'                  => $cliente->razon_social,
            'DomicilioFiscalReceptor' => $domicilioReceptor,
            'RegimenFiscalReceptor'   => $cliente->satcat_regimen_fiscal_clave,
            'UsoCFDI'                 => $cliente->satcat_uso_cfdi_clave,
        ]);

        foreach ($factura->conceptos as $item) {
            $importe = (float) $item->importe;
            $iva     = (float) $item->iva;

            $concepto = $comprobante->addConcepto([
                'ClaveProdServ' => $item->satcat_clave_productos_clave ?: '84111500',
                'Cantidad'      => number_format((float) $item->cantidad, 4, '.', ''),
                'ClaveUnidad'   => $item->satcat_unidades_clave ?: 'ACT',
                'Descripcion'   => $item->descripcion,
                'ValorUnitario' => number_format((float) $item->valor_unitario, 4, '.', ''),
                'Importe'       => number_format($importe, 2, '.', ''),
                'ObjetoImp'     => '02',
            ]);

            $concepto->addTraslado([
                'Base'       => number_format($importe, 2, '.', ''),
                'Impuesto'   => '002',
                'TipoFactor' => 'Tasa',
                'TasaOCuota' => '0.160000',
                'Importe'    => number_format($iva, 2, '.', ''),
            ]);
        }

        $creator->addSumasConceptos(null, 2);

        $creator->addSello(
            'file://' . Storage::path($this->keyPath),
            $this->csdPassword
        );

        $creator->moveSatDefinitionsToComprobante();

        if ($this->debug) {
            $debugPath = storage_path('app/cfdi_debug.xml');
            file_put_contents($debugPath, $creator->asXml());
            Log::info('XML CFDI generado para debug', ['path' => $debugPath]);
        }

        $asserts = $creator->validate();
        if ($asserts->hasErrors()) {
            $errores = implode(' | ', $asserts->errors());
            Log::error('XML CFDI inválido XSD: ' . $errores);
            throw new Exception('XML inválido: ' . $errores);
        }

        return $creator->asXml();
    }

    private function guardarCFDI(Factura $factura, array $timbrado): CFDI
    {
        return CFDI::updateOrCreate(
            ['factura_id' => $factura->factura_id],
            [
                'timbrefiscaldigitalUUID'              => $timbrado['uuid']              ?? null,
                'timbrefiscaldigitalFechaTimbrado'     => $timbrado['fechaTimbrado']      ?? null,
                'timbrefiscaldigitalSelloCFD'          => $timbrado['selloCFDI']          ?? null,
                'timbrefiscaldigitalSelloSAT'          => $timbrado['selloSAT']           ?? null,
                'timbrefiscaldigitalNoCertificadoSAT'  => $timbrado['noCertificadoSAT']   ?? null,
                'comprobanteSerie'                     => $factura->serie->serie,
                'comprobanteFolio'                     => $factura->folio,
                'comprobanteFecha'                     => $factura->fecha,
                'comprobanteMoneda'                    => $factura->cat_monedas_clave,
                'comprobanteTipoCambio'                => $factura->tipo_cambio,
                'comprobanteSubTotal'                  => $factura->subtotal,
                'comprobanteTotal'                     => $factura->total,
                'comprobanteTipoDeComprobante'         => 'I',
                'comprobanteMetodoPago'                => $factura->satcat_metodos_pago_clave,
                'comprobanteFormaPago'                 => $factura->satcat_formas_pago_clave,
                'comprobanteNoCertificado'             => $timbrado['noCertificadoCFDI']   ?? null,
                'emisorRfc'                            => $factura->serie->datosGenerales->rfc,
                'receptorRfc'                          => $factura->contacto->rfc,
                'cadena_original'                      => $timbrado['cadenaOriginalSAT']   ?? null,
            ]
        );
    }
}