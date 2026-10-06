<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota de Crédito {{ $nota->serie }}-{{ $nota->folio }}</title>
    <style>
        @page { margin: 30px 35px; }
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 11px; color: #222; }
        .header { text-align: center; margin-bottom: 10px; }
        .header h1 { margin: 0; font-size: 16px; }
        .header p { margin: 2px 0; font-size: 11px; }
        .box { border: 1px solid #999; padding: 6px 8px; margin-bottom: 8px; }
        .box h3 { margin: 0 0 4px 0; font-size: 11px; background: #eee; padding: 3px 5px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 4px 6px; font-size: 10px; }
        th { background: #f0f0f0; text-align: left; }
        .right { text-align: right; }
        .totales { margin-top: 8px; width: 45%; float: right; }
        .totales td { font-size: 11px; }
        .uuid { font-size: 9px; word-break: break-all; }
        .clearfix::after { content: ""; display: table; clear: both; }
        .motivo { background: #fff8dc; padding: 6px 8px; border-left: 3px solid #ffc107; margin: 6px 0; }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ config('cfdi.emisor.nombre', 'EMISOR') }}</h1>
        <p>RFC: {{ config('cfdi.emisor.rfc', '-') }} — Régimen: {{ config('cfdi.emisor.regimen_fiscal', '601') }}</p>
        <p>Lugar de expedición: {{ config('cfdi.emisor.cp', '-') }}</p>
        <p><strong>NOTA DE CRÉDITO (CFDI 4.0)</strong></p>
    </div>

    <div class="box">
        <table>
            <tr>
                <td><strong>Serie-Folio:</strong> {{ $nota->serie }}-{{ $nota->folio }}</td>
                <td><strong>Fecha:</strong> {{ $nota->fecha }}</td>
                <td><strong>Moneda:</strong> {{ $nota->moneda ?? 'MXN' }}</td>
            </tr>
            <tr>
                <td><strong>Tipo:</strong> Egreso</td>
                <td><strong>Método de pago:</strong> {{ $nota->metodo_pago ?? 'PUE' }}</td>
                <td><strong>Forma de pago:</strong> {{ $nota->forma_pago ?? '01' }}</td>
            </tr>
        </table>
    </div>

    <div class="box">
        <h3>Receptor</h3>
        <p style="margin: 2px 0;"><strong>Nombre:</strong> {{ $nota->cliente_nombre ?? '-' }}</p>
        <p style="margin: 2px 0;"><strong>RFC:</strong> {{ $nota->cliente_rfc ?? '-' }}</p>
    </div>

    @if(!empty($nota->factura_relacionada_serie) || !empty($nota->factura_relacionada_folio))
    <div class="box">
        <h3>Factura relacionada</h3>
        <p style="margin: 2px 0;">
            <strong>Serie-Folio:</strong>
            {{ $nota->factura_relacionada_serie ?? '-' }}-{{ $nota->factura_relacionada_folio ?? '-' }}
        </p>
        @if(!empty($nota->factura_relacionada_uuid))
            <p class="uuid" style="margin: 2px 0;"><strong>UUID:</strong> {{ $nota->factura_relacionada_uuid }}</p>
        @endif
    </div>
    @endif

    @if(!empty($nota->motivo_nota_credito))
    <div class="motivo">
        <strong>Motivo de la nota de crédito:</strong>
        {{ $nota->motivo_nota_credito }}
    </div>
    @endif

    <div class="box">
        <h3>Conceptos</h3>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cant.</th>
                    <th>Unidad</th>
                    <th>Descripción</th>
                    <th class="right">P. Unitario</th>
                    <th class="right">Importe</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($conceptos ?? []) as $c)
                    <tr>
                        <td>{{ $c->codigo ?? $c->clave_prod_serv ?? '01010101' }}</td>
                        <td class="right">{{ number_format($c->cantidad ?? 1, 2) }}</td>
                        <td>{{ $c->unidad ?? 'ACT' }}</td>
                        <td>{{ $c->descripcion ?? '' }}</td>
                        <td class="right">${{ number_format($c->valor_unitario ?? $c->precio_unitario ?? 0, 2) }}</td>
                        <td class="right">${{ number_format($c->importe ?? 0, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;">Sin conceptos registrados</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="clearfix">
        <table class="totales">
            <tr>
                <td><strong>Subtotal</strong></td>
                <td class="right">${{ number_format(abs($nota->subtotal ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td><strong>IVA</strong></td>
                <td class="right">${{ number_format(abs($nota->iva ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td class="right"><strong>${{ number_format(abs($nota->total ?? 0), 2) }}</strong></td>
            </tr>
        </table>
    </div>

    @if(!empty($total_letra))
    <div class="box" style="margin-top: 12px; clear: both;">
        <h3>Total con letra</h3>
        <p style="margin: 2px 0;">{{ $total_letra }}</p>
    </div>
    @endif

    @if(!empty($nota->uuid))
    <div class="box">
        <h3>Timbre Fiscal Digital</h3>
        <p class="uuid" style="margin: 2px 0;"><strong>UUID:</strong> {{ $nota->uuid }}</p>
        @if(!empty($nota->fecha_timbrado))
            <p style="margin: 2px 0;"><strong>Fecha de timbrado:</strong> {{ $nota->fecha_timbrado }}</p>
        @endif
    </div>
    @endif

    <p style="text-align:center; font-size: 9px; color: #666; margin-top: 10px;">
        Este documento es una representación impresa de un CFDI (Nota de Crédito).
    </p>

</body>
</html>
