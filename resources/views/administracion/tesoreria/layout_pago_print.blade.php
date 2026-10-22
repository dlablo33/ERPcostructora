<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout de Pagos {{ $layout->folio }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 20px;
            background: #fff;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* Header empresa / folio */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .header .empresa {
            font-size: 12px;
            line-height: 1.4;
        }
        .header .empresa .nombre {
            font-weight: bold;
            font-size: 14px;
        }
        .header .right {
            text-align: right;
            font-size: 12px;
            line-height: 1.5;
        }
        .header .right strong {
            display: inline-block;
            min-width: 70px;
            text-align: left;
        }

        /* Título */
        .titulo {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 15px 0;
            padding: 6px 0;
            border-top: 1px solid #999;
            border-bottom: 1px solid #999;
        }

        /* Tabla de encabezado (datos generales) */
        .datos-generales {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .datos-generales td {
            padding: 5px 8px;
            border: 1px solid #999;
            font-size: 11px;
        }
        .datos-generales .label {
            background: #e9ecef;
            font-weight: bold;
            width: 120px;
        }

        /* Tabla de detalle */
        .detalle {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .detalle th {
            background: #083CAE;
            color: #fff;
            padding: 6px 6px;
            font-size: 11px;
            border: 1px solid #083CAE;
            text-align: left;
        }
        .detalle td {
            padding: 5px 6px;
            font-size: 11px;
            border: 1px solid #999;
        }
        .detalle tbody tr:nth-child(even) {
            background: #f5f5f5;
        }
        .detalle .monto {
            text-align: right;
            font-family: 'Courier New', monospace;
        }
        .detalle tfoot td {
            font-weight: bold;
            background: #e9ecef;
            border-top: 2px solid #083CAE;
        }
        .detalle tfoot .total-label {
            text-align: right;
        }
        .detalle tfoot .total-monto {
            text-align: right;
            font-family: 'Courier New', monospace;
            font-size: 12px;
        }

        /* Footer */
        .footer {
            margin-top: 20px;
            font-size: 10px;
            color: #666;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #ccc;
            padding-top: 8px;
        }

        .firmas {
            margin-top: 50px;
            display: flex;
            justify-content: space-around;
            gap: 40px;
        }
        .firmas .firma {
            flex: 1;
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 6px;
            font-size: 11px;
        }

        /* Botonera (no se imprime) */
        .no-print {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            background: #f4f6f9;
            border-radius: 6px;
        }
        .no-print button {
            background: #083CAE;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            margin: 0 4px;
        }
        .no-print button:hover {
            background: #062a80;
        }
        .no-print button.secondary {
            background: #6c757d;
        }

        @media print {
            body { padding: 0; margin: 10mm; }
            .no-print { display: none !important; }
            .container { max-width: none; }
            .header, .titulo, .datos-generales td, .detalle td, .detalle th {
                page-break-inside: avoid;
            }
            .detalle thead { display: table-header-group; }
            .detalle tfoot { display: table-footer-group; }
        }
    </style>
</head>
<body>

<div class="container">

    {{-- Botonera (no se imprime) --}}
    <div class="no-print">
        <button onclick="window.print()">
            🖨️ Imprimir
        </button>
        <button class="secondary" onclick="window.close()">
            ✖ Cerrar
        </button>
        <button class="secondary" onclick="window.location.href='/admin/pagos'">
            ↩ Regresar a Pagos
        </button>
    </div>

    {{-- =========================================== --}}
    {{-- ENCABEZADO EMPRESA / FOLIO --}}
    {{-- =========================================== --}}
    <div class="header">
        <div class="empresa">
            <div class="nombre">
                {{ $layout->cuenta->banco->nombre ?? 'Empresa DEMO' }}
            </div>
            <div>RFC: AAD220805DD4</div>
            <div>Carretera Nacional, S/N</div>
            <div>Tecnológico, CP. 000000</div>
            <div>Monterrey, Nuevo León, México</div>
        </div>
        <div class="right">
            <div><strong>Folio:</strong> {{ $layout->folio }}</div>
            <div><strong>Fecha:</strong> {{ $layout->fecha ? $layout->fecha->format('d/m/Y') : '-' }}</div>
            <div><strong>Cuenta:</strong> {{ $layout->cuenta_nombre ?? '-' }}</div>
            <div><strong>Estatus:</strong> {{ ucfirst($layout->estatus) }}</div>
        </div>
    </div>

    {{-- =========================================== --}}
    {{-- TÍTULO --}}
    {{-- =========================================== --}}
    <div class="titulo">Layout de Pagos</div>

    {{-- =========================================== --}}
    {{-- DATOS GENERALES --}}
    {{-- =========================================== --}}
    <table class="datos-generales">
        <tr>
            <td class="label">Folio</td>
            <td>{{ $layout->folio }}</td>
            <td class="label">Fecha</td>
            <td>{{ $layout->fecha ? $layout->fecha->format('d/m/Y') : '-' }}</td>
            <td class="label">Cuenta</td>
            <td>{{ $layout->cuenta_nombre ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Estatus</td>
            <td>{{ ucfirst($layout->estatus) }}</td>
            <td class="label">Referencia</td>
            <td>{{ $layout->referencia ?? '-' }}</td>
            <td class="label">Moneda</td>
            <td>{{ $layout->moneda }}</td>
        </tr>
        <tr>
            <td class="label">Tipo de Cambio</td>
            <td>{{ number_format($layout->tipo_cambio, 4) }}</td>
            <td class="label">Tipo Programación</td>
            <td>{{ $layout->tipo_programacion ?? '-' }}</td>
            <td class="label">Monto Total</td>
            <td><strong>${{ number_format($layout->monto_total, 2) }}</strong></td>
        </tr>
        <tr>
            <td class="label">Descripción</td>
            <td colspan="5">{{ $layout->descripcion ?? '-' }}</td>
        </tr>
    </table>

    {{-- =========================================== --}}
    {{-- DETALLE DE PAGOS --}}
    {{-- =========================================== --}}
    <table class="detalle">
        <thead>
            <tr>
                <th style="width: 80px;">Programación</th>
                <th style="width: 100px;">Referencia</th>
                <th style="width: 90px;">Fecha</th>
                <th>Proveedor</th>
                <th style="width: 110px; text-align: right;">Monto</th>
                <th style="width: 100px;">Banco</th>
                <th style="width: 130px;">Estatus</th>
            </tr>
        </thead>
        <tbody>
            @forelse($layout->detalles as $d)
                <tr>
                    <td>{{ $d->programacion ?? '-' }}</td>
                    <td>{{ $d->referencia ?? '-' }}</td>
                    <td>{{ $d->fecha ? $d->fecha->format('d/m/Y') : '-' }}</td>
                    <td>{{ $d->proveedor_nombre }}</td>
                    <td class="monto">${{ number_format($d->monto, 2) }}</td>
                    <td>{{ $d->banco ?? '-' }}</td>
                    <td>{{ $d->estatus }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #999;">
                        No hay pagos registrados en este layout.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="total-label">Total:</td>
                <td class="total-monto">${{ number_format($layout->monto_total, 2) }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

    {{-- =========================================== --}}
    {{-- FIRMAS --}}
    {{-- =========================================== --}}
    <div class="firmas">
        <div class="firma">Autorizó</div>
        <div class="firma">Revisó</div>
        <div class="firma">Recibió</div>
    </div>

    {{-- =========================================== --}}
    {{-- FOOTER --}}
    {{-- =========================================== --}}
    <div class="footer">
        <div>
            Generado el {{ now()->format('d/m/Y H:i') }}
        </div>
        <div>
            Layout: {{ $layout->folio }} — {{ $layout->detalles->count() }} pago(s)
        </div>
    </div>

</div>

</body>
</html>