<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Anticipo {{ $anticipo->folio }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #333;
            padding: 25px 30px;
        }

        /* ===== HEADER ===== */
        .header {
            border-bottom: 3px solid #083CAE;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header-table { width: 100%; border-collapse: collapse; }
        .header-table td { vertical-align: middle; }
        .logo-cell { width: 90px; }
        .logo-box {
            width: 70px;
            height: 70px;
            background-color: #083CAE;
            color: #fff;
            border-radius: 8px;
            text-align: center;
            line-height: 70px;
            font-size: 28px;
            font-weight: bold;
        }
        .empresa-nombre {
            font-size: 18px;
            font-weight: bold;
            color: #083CAE;
        }
        .empresa-info {
            font-size: 10px;
            color: #666;
            margin-top: 3px;
        }
        .folio-box {
            text-align: right;
        }
        .folio-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .folio-valor {
            font-size: 20px;
            font-weight: bold;
            color: #083CAE;
        }
        .estatus-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            color: #fff;
            text-transform: uppercase;
            margin-top: 5px;
        }
        .badge-pendiente { background-color: #fd7e14; }
        .badge-aprobado  { background-color: #28a745; }
        .badge-rechazado { background-color: #dc3545; }
        .badge-liquidado { background-color: #17a2b8; }
        .badge-cancelado { background-color: #6c757d; }

        /* ===== TÍTULO ===== */
        .titulo-documento {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            color: #083CAE;
            margin: 15px 0 20px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* ===== SECCIONES ===== */
        .seccion {
            margin-bottom: 15px;
        }
        .seccion-titulo {
            background-color: #f0f4ff;
            color: #083CAE;
            font-size: 11px;
            font-weight: bold;
            padding: 6px 10px;
            border-left: 4px solid #083CAE;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ===== TABLAS DE DATOS ===== */
        .datos-table {
            width: 100%;
            border-collapse: collapse;
        }
        .datos-table td {
            padding: 6px 10px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 11px;
        }
        .datos-table td.label {
            color: #666;
            font-weight: bold;
            width: 30%;
            background-color: #fafafa;
        }
        .datos-table td.valor {
            color: #333;
        }

        /* ===== MONTOS DESTACADOS ===== */
        .montos-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .montos-table td {
            width: 33.33%;
            padding: 15px;
            text-align: center;
            vertical-align: top;
        }
        .monto-card {
            border-radius: 6px;
            padding: 12px;
        }
        .monto-card.original {
            background-color: #f0f7ff;
            border: 2px solid #2378e1;
        }
        .monto-card.restante {
            background-color: #fff4e6;
            border: 2px solid #fd7e14;
        }
        .monto-card.moneda {
            background-color: #f8f9fa;
            border: 2px solid #6c757d;
        }
        .monto-label {
            font-size: 9px;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .monto-card.original .monto-label { color: #2378e1; }
        .monto-card.restante .monto-label { color: #fd7e14; }
        .monto-card.moneda .monto-label { color: #6c757d; }
        .monto-valor {
            font-size: 16px;
            font-weight: bold;
        }
        .monto-card.original .monto-valor { color: #083CAE; }
        .monto-card.restante .monto-valor { color: #d9530f; }
        .monto-card.moneda .monto-valor { color: #333; }
        .monto-sub {
            font-size: 9px;
            color: #666;
            margin-top: 3px;
        }

        /* ===== DESCRIPCIÓN ===== */
        .descripcion-box {
            background-color: #f8f9fa;
            border-left: 4px solid #083CAE;
            padding: 10px 12px;
            font-size: 11px;
            line-height: 1.5;
            color: #333;
            border-radius: 4px;
        }

        /* ===== FIRMAS ===== */
        .firmas-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 50px;
        }
        .firmas-table td {
            width: 50%;
            text-align: center;
            padding: 0 20px;
            vertical-align: bottom;
        }
        .firma-linea {
            border-top: 1px solid #333;
            padding-top: 6px;
            margin-top: 50px;
        }
        .firma-nombre {
            font-size: 11px;
            font-weight: bold;
            color: #333;
        }
        .firma-cargo {
            font-size: 9px;
            color: #666;
            margin-top: 2px;
        }

        /* ===== FOOTER ===== */
        .footer {
            position: fixed;
            bottom: 15px;
            left: 30px;
            right: 30px;
            text-align: center;
            font-size: 9px;
            color: #999;
            border-top: 1px solid #e0e0e0;
            padding-top: 8px;
        }

        /* ===== UTILIDADES ===== */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .mt-10 { margin-top: 10px; }
        .mt-20 { margin-top: 20px; }

        /* ===== WATERMARK PARA CANCELADOS ===== */
        .watermark {
            position: fixed;
            top: 45%;
            left: 20%;
            font-size: 90px;
            color: rgba(220, 53, 69, 0.08);
            font-weight: bold;
            transform: rotate(-35deg);
            z-index: -1;
            text-transform: uppercase;
            letter-spacing: 5px;
        }
    </style>
</head>
<body>

    {{-- Marca de agua si está cancelado --}}
    @if($anticipo->estatus === 'Cancelado')
        <div class="watermark">CANCELADO</div>
    @endif

    {{-- ========== HEADER ========== --}}
    <div class="header">
        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    <div class="logo-box">E</div>
                </td>
                <td>
                    <div class="empresa-nombre">ERP Constructora</div>
                    <div class="empresa-info">
                        Sistema de Gestión de Anticipos<br>
                        RFC: XXXXXXXXXXXX · Tel: (000) 000-0000
                    </div>
                </td>
                <td class="folio-box">
                    <div class="folio-label">Folio</div>
                    <div class="folio-valor">{{ $anticipo->folio }}</div>
                    @php
                        $badgeClass = match($anticipo->estatus) {
                            'Aprobado'  => 'badge-aprobado',
                            'Pendiente' => 'badge-pendiente',
                            'Rechazado' => 'badge-rechazado',
                            'Liquidado' => 'badge-liquidado',
                            'Cancelado' => 'badge-cancelado',
                            default     => 'badge-pendiente',
                        };
                    @endphp
                    <span class="estatus-badge {{ $badgeClass }}">{{ $anticipo->estatus }}</span>
                </td>
            </tr>
        </table>
    </div>

    {{-- ========== TÍTULO ========== --}}
    <div class="titulo-documento">Comprobante de Anticipo</div>

    {{-- ========== DATOS DEL PROVEEDOR ========== --}}
    <div class="seccion">
        <div class="seccion-titulo">Datos del Proveedor</div>
        <table class="datos-table">
            <tr>
                <td class="label">Proveedor</td>
                <td class="valor">{{ $anticipo->proveedor->nombre ?? '-' }}</td>
                <td class="label">RFC</td>
                <td class="valor">{{ $anticipo->proveedor->rfc ?? '-' }}</td>
            </tr>
            @if($anticipo->proveedor && $anticipo->proveedor->razon_social)
            <tr>
                <td class="label">Razón Social</td>
                <td class="valor" colspan="3">{{ $anticipo->proveedor->razon_social }}</td>
            </tr>
            @endif
            @if($anticipo->proveedor && ($anticipo->proveedor->telefono || $anticipo->proveedor->email))
            <tr>
                <td class="label">Contacto</td>
                <td class="valor" colspan="3">
                    {{ $anticipo->proveedor->telefono ?? '' }}
                    @if($anticipo->proveedor->telefono && $anticipo->proveedor->email) · @endif
                    {{ $anticipo->proveedor->email ?? '' }}
                </td>
            </tr>
            @endif
        </table>
    </div>

    {{-- ========== DATOS DEL ANTICIPO ========== --}}
    <div class="seccion">
        <div class="seccion-titulo">Datos del Anticipo</div>
        <table class="datos-table">
            <tr>
                <td class="label">Fecha de Emisión</td>
                <td class="valor">
                    {{ $anticipo->fecha ? \Carbon\Carbon::parse($anticipo->fecha)->format('d/m/Y') : '-' }}
                </td>
                <td class="label">Forma de Pago</td>
                <td class="valor">{{ $anticipo->forma_pago ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Referencia</td>
                <td class="valor">{{ $anticipo->referencia ?? '-' }}</td>
                <td class="label">Ref. Bancaria</td>
                <td class="valor">{{ $anticipo->referencia_bancaria ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Cuenta Bancaria</td>
                <td class="valor">
                    @if($anticipo->cuentaBancaria)
                        {{ $anticipo->cuentaBancaria->numero_formateado ?? $anticipo->cuentaBancaria->numero_cuenta }}
                        @if($anticipo->cuentaBancaria->banco)
                            - {{ $anticipo->cuentaBancaria->banco->nombre }}
                        @endif
                    @else
                        -
                    @endif
                </td>
                <td class="label">Moneda</td>
                <td class="valor">{{ $anticipo->moneda->codigo ?? 'MXN' }}</td>
            </tr>
        </table>
    </div>

    {{-- ========== MONTOS ========== --}}
    <table class="montos-table">
        <tr>
            <td>
                <div class="monto-card original">
                    <div class="monto-label">Monto Original</div>
                    <div class="monto-valor">
                        ${{ number_format($anticipo->monto, 2) }}
                    </div>
                    <div class="monto-sub">{{ $anticipo->moneda->codigo ?? 'MXN' }}</div>
                </div>
            </td>
            <td>
                <div class="monto-card restante">
                    <div class="monto-label">Monto Restante</div>
                    <div class="monto-valor">
                        ${{ number_format($anticipo->monto_restante, 2) }}
                    </div>
                    <div class="monto-sub">
                        @if($anticipo->monto_restante <= 0)
                            Liquidado
                        @else
                            Pendiente por aplicar
                        @endif
                    </div>
                </div>
            </td>
            <td>
                <div class="monto-card moneda">
                    <div class="monto-label">Tipo de Cambio</div>
                    <div class="monto-valor">
                        {{ number_format($anticipo->tipo_cambio, 4) }}
                    </div>
                    <div class="monto-sub">MXN / {{ $anticipo->moneda->codigo ?? 'MXN' }}</div>
                </div>
            </td>
        </tr>
    </table>

    {{-- ========== DESCRIPCIÓN ========== --}}
    @if($anticipo->descripcion)
    <div class="seccion">
        <div class="seccion-titulo">Descripción / Concepto</div>
        <div class="descripcion-box">
            {{ $anticipo->descripcion }}
        </div>
    </div>
    @endif

    {{-- ========== FIRMAS ========== --}}
    <table class="firmas-table">
        <tr>
            <td>
                <div class="firma-linea">
                    <div class="firma-nombre">{{ $anticipo->user->name ?? 'Solicitante' }}</div>
                    <div class="firma-cargo">Solicitó / Elaboró</div>
                </div>
            </td>
            <td>
                <div class="firma-linea">
                    <div class="firma-nombre">Autorizó</div>
                    <div class="firma-cargo">Vo. Bo. / Gerencia</div>
                </div>
            </td>
        </tr>
    </table>

    {{-- ========== FOOTER ========== --}}
    <div class="footer">
        Documento generado automáticamente el
        {{ now()->format('d/m/Y H:i') }}
        · ERP Constructora · Folio {{ $anticipo->folio }}
    </div>

</body>
</html>