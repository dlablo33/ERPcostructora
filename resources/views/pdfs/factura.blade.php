<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura {{ $factura->serie }}-{{ $factura->folio }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 20px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #083CAE;
            padding-bottom: 10px;
        }
        .empresa {
            font-size: 18px;
            font-weight: bold;
            color: #083CAE;
        }
        .factura-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            color: #333;
        }
        .cliente {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .cliente-title {
            font-weight: bold;
            background: #f0f0f0;
            padding: 5px;
            margin: -10px -10px 10px -10px;
            border-radius: 5px 5px 0 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #f0f0f0;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .totales {
            width: 100%;
            margin-top: 20px;
        }
        .totales table {
            width: 300px;
            float: right;
            border: none;
        }
        .totales td {
            border: none;
            padding: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 10px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        .clearfix {
            clear: both;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-pendiente { background-color: #ffc107; color: #333; }
        .badge-timbrada { background-color: #28a745; color: white; }
        .badge-cancelada { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <div class="empresa">MejoraSoft ERPCostruccion</div>
        <div>RFC: MJERP19112001COSTR3</div>
        <div>Av. Garza Sada #100, Col. Centro, Monterrey, Nuevo León</div>
        <div>Tel: (81) 8888-0000</div>
        <div class="factura-title">FACTURA {{ $factura->serie }}-{{ $factura->folio }}</div>
    </div>

    <div class="cliente">
        <div class="cliente-title">DATOS DEL CLIENTE</div>
        <table style="width:100%; border:none;">
            <tr>
                <td style="width:120px;"><strong>Razón Social:</strong></td>
                <td>{{ $factura->cliente_nombre ?? '-' }}</td>
                <td style="width:120px;"><strong>RFC:</strong></td>
                <td>{{ $factura->cliente_rfc ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Fecha:</strong></td>
                <td>{{ date('d/m/Y', strtotime($factura->fecha)) }}</td>
                <td><strong>Moneda:</strong></td>
                <td>{{ $factura->cat_monedas_clave ?? 'MXN' }}</td>
            </tr>
            @if($factura->fecha_vencimiento)
            <tr>
                <td><strong>Fecha Vencimiento:</strong></td>
                <td>{{ date('d/m/Y', strtotime($factura->fecha_vencimiento)) }}</td>
                <td><strong>Tipo de Cambio:</strong></td>
                <td>{{ $factura->tipo_cambio ?? 1 }}</td>
            </tr>
            @endif
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No.</th>
                <th>Descripción</th>
                <th class="text-right">Cantidad</th>
                <th class="text-right">Valor Unitario</th>
                <th class="text-right">Importe</th>
            </tr>
        </thead>
        <tbody>
            @forelse($conceptos as $index => $concepto)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $concepto->descripcion }}</td>
                <td class="text-right">{{ number_format($concepto->cantidad, 2) }}</td>
                <td class="text-right">${{ number_format($concepto->valor_unitario, 2) }}</td>
                <td class="text-right">${{ number_format($concepto->importe, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No hay conceptos registrados</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="totales">
        <table>
            <tr><td><strong>Subtotal:</strong></td><td class="text-right">${{ number_format($factura->subtotal, 2) }}</td></tr>
            <tr><td><strong>IVA (16%):</strong></td><td class="text-right">${{ number_format($factura->iva, 2) }}</td></tr>
            <tr><td style="border-top:1px solid #ccc;"><strong>TOTAL:</strong></td><td style="border-top:1px solid #ccc;" class="text-right"><strong>${{ number_format($factura->total, 2) }}</strong></td></tr>
            <tr><td colspan="2"><strong>Total con letra:</strong> {{ $total_letra }}</td></tr>
        </table>
    </div>

    <div class="clearfix"></div>

    <div class="footer">
        <p>Este documento es una representación impresa de un CFDI</p>
        <p>Consulte el CFDI en <a href="https://verificacfdi.facturaelectronica.sat.gob.mx">https://verificacfdi.facturaelectronica.sat.gob.mx</a></p>
        <p>UUID: {{ $factura->uuid ?? 'No timbrada' }}</p>
    </div>
</body>
</html>