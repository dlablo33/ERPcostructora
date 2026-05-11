<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CFDI {{ $cfdi->comprobanteSerie }}-{{ $cfdi->comprobanteFolio }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .empresa { font-size: 16px; font-weight: bold; color: #083CAE; }
        .cfdi-title { font-size: 14px; font-weight: bold; margin-top: 10px; }
        .info { border: 1px solid #ccc; padding: 10px; margin-bottom: 20px; }
        .info-title { font-weight: bold; background: #f0f0f0; padding: 5px; margin: -10px -10px 10px -10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
        .text-right { text-align: right; }
        .totales { width: 300px; float: right; margin-top: 20px; }
        .footer { text-align: center; margin-top: 50px; font-size: 10px; }
        .clearfix { clear: both; }
    </style>
</head>
<body>
    <div class="header">
        <div class="empresa">EMPRESA DE PRUEBA SA DE CV</div>
        <div>RFC: EPS123456789</div>
        <div class="cfdi-title">COMPROBANTE FISCAL DIGITAL POR INTERNET (CFDI)</div>
        <div>{{ $cfdi->comprobanteSerie }}-{{ $cfdi->comprobanteFolio }}</div>
    </div>

    <div class="info">
        <div class="info-title">DATOS DEL RECEPTOR</div>
        <table style="width:100%; border:none;">
            <tr><td style="width:120px;"><strong>Nombre:</strong></td><td>{{ $cfdi->receptor_nombre ?? '-' }}</td>
                <td style="width:120px;"><strong>RFC:</strong></td><td>{{ $cfdi->receptor_rfc ?? '-' }}</td>
            </tr>
            <tr><td><strong>Fecha:</strong></td><td>{{ date('d/m/Y', strtotime($cfdi->comprobanteFecha ?? now())) }}</td>
                <td><strong>UUID:</strong></td><td>{{ $cfdi->uuid ?? '-' }}</td>
            </tr>
            <tr><td><strong>Tipo:</strong></td><td>{{ $cfdi->comprobanteTipoDeComprobante === 'I' ? 'Factura' : 'Nota de Crédito' }}</td>
                <td><strong>Moneda:</strong></td><td>{{ $cfdi->comprobanteMoneda ?? 'MXN' }}</td>
            </tr>
        </table>
    </div>

    @if($conceptos && count($conceptos) > 0)
    <table>
        <thead>
            <tr><th>Descripción</th><th class="text-right">Cantidad</th><th class="text-right">Valor Unitario</th><th class="text-right">Importe</th></tr>
        </thead>
        <tbody>
            @foreach($conceptos as $concepto)
            <tr>
                <td>{{ $concepto->descripcion ?? '-' }}</td>
                <td class="text-right">{{ number_format($concepto->cantidad ?? 0, 2) }}</td>
                <td class="text-right">${{ number_format($concepto->valor_unitario ?? 0, 2) }}</td>
                <td class="text-right">${{ number_format($concepto->importe ?? 0, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="totales">
        <table>
            <tr><td><strong>Subtotal:</strong></td><td class="text-right">${{ number_format($cfdi->comprobanteSubTotal ?? 0, 2) }}</td></tr>
            <tr><td><strong>IVA (16%):</strong></td><td class="text-right">${{ number_format(($cfdi->comprobanteSubTotal ?? 0) * 0.16, 2) }}</td></tr>
            <tr style="border-top:1px solid #ccc;"><td><strong>TOTAL:</strong></td><td class="text-right"><strong>${{ number_format($cfdi->comprobanteTotal ?? 0, 2) }}</strong></td></tr>
        </table>
    </div>

    <div class="clearfix"></div>
    <div class="footer">
        <p>Este documento es una representación impresa de un CFDI</p>
        <p>UUID: {{ $cfdi->uuid ?? '-' }}</p>
        <p>Consulte en <a href="https://verificacfdi.facturaelectronica.sat.gob.mx">https://verificacfdi.facturaelectronica.sat.gob.mx</a></p>
    </div>
</body>
</html>