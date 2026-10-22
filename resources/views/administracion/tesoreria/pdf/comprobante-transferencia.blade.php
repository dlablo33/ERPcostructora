<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante {{ $registro->folio }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 10px; color: #1A2332; padding: 20px; }
        
        /* HEADER */
        .header { border-bottom: 3px solid #083CAE; padding-bottom: 15px; margin-bottom: 20px; }
        .header-top { display: table; width: 100%; }
        .header-left { display: table-cell; vertical-align: middle; width: 70%; }
        .header-right { display: table-cell; vertical-align: middle; width: 30%; text-align: right; }
        .header-title { color: #083CAE; font-size: 22px; font-weight: bold; margin-bottom: 4px; }
        .header-subtitle { color: #6B7A8F; font-size: 11px; }
        .folio-box { background: #083CAE; color: white; padding: 10px 16px; border-radius: 6px; display: inline-block; }
        .folio-label { font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9; }
        .folio-value { font-size: 16px; font-weight: bold; margin-top: 2px; }
        
        /* BADGE ESTATUS */
        .estatus-badge { display: inline-block; padding: 4px 12px; border-radius: 4px; font-size: 9px; font-weight: bold; text-transform: uppercase; margin-top: 6px; }
        .estatus-activo { background: #FFC107; color: #000; }
        .estatus-completado { background: #28A745; color: #fff; }
        .estatus-cancelado { background: #DC3545; color: #fff; }
        
        /* SECCIONES */
        .section { margin-bottom: 16px; }
        .section-title { 
            background: #F8FAFC; 
            color: #083CAE; 
            font-size: 11px; 
            font-weight: bold; 
            padding: 8px 12px; 
            border-left: 4px solid #083CAE; 
            margin-bottom: 10px; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* GRID DE DATOS */
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 6px 10px; vertical-align: top; }
        .info-table td.label { color: #6B7A8F; font-size: 9px; text-transform: uppercase; width: 30%; font-weight: bold; }
        .info-table td.value { color: #1A2332; font-size: 11px; font-weight: 500; }
        .info-table tr { border-bottom: 1px solid #F1F3F5; }
        
        /* 2 COLUMNAS */
        .two-columns { display: table; width: 100%; }
        .col { display: table-cell; width: 50%; vertical-align: top; padding-right: 15px; }
        .col:last-child { padding-right: 0; padding-left: 15px; }
        
        /* CARD TOTALES */
        .totales-card { 
            background: linear-gradient(135deg, #083CAE 0%, #0A4BC9 100%); 
            color: white; 
            padding: 18px; 
            border-radius: 10px; 
            margin: 16px 0; 
        }
        .totales-grid { display: table; width: 100%; }
        .total-item { display: table-cell; width: 33.33%; text-align: center; padding: 0 10px; }
        .total-item:not(:last-child) { border-right: 1px solid rgba(255,255,255,0.3); }
        .total-label { font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.85; font-weight: 600; }
        .total-value { font-size: 20px; font-weight: bold; margin-top: 6px; }
        
        /* TABLA FACTURAS */
        .facturas-table { width: 100%; border-collapse: collapse; font-size: 10px; margin-top: 8px; }
        .facturas-table thead { background: #083CAE; color: white; }
        .facturas-table thead th { padding: 8px 10px; text-align: left; font-size: 9px; text-transform: uppercase; }
        .facturas-table tbody td { padding: 8px 10px; border-bottom: 1px solid #E9ECF0; }
        .facturas-table tbody tr:nth-child(even) { background: #F8FAFC; }
        .facturas-table tfoot td { padding: 10px; background: #E8F0FE; font-weight: bold; border-top: 2px solid #083CAE; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        /* CONCEPTO / OBSERVACIONES */
        .textarea-box { 
            background: #F8FAFC; 
            border: 1px solid #E9ECF0; 
            border-radius: 6px; 
            padding: 10px 12px; 
            font-size: 10px; 
            color: #4A5A6E; 
            min-height: 40px;
        }
        
        /* FIRMAS */
        .firmas { margin-top: 40px; display: table; width: 100%; }
        .firma-item { display: table-cell; width: 50%; text-align: center; padding: 0 20px; }
        .firma-line { border-top: 1px solid #1A2332; margin-top: 50px; padding-top: 6px; font-size: 9px; color: #6B7A8F; }
        
        /* FOOTER */
        .footer { 
            margin-top: 30px; 
            padding-top: 12px; 
            border-top: 1px solid #E9ECF0; 
            text-align: center; 
            font-size: 8px; 
            color: #8A9AAE; 
        }
    </style>
</head>
<body>

    <!-- ============ HEADER ============ -->
    <div class="header">
        <div class="header-top">
            <div class="header-left">
                <div class="header-title">Comprobante de Pago</div>
                <div class="header-subtitle">
                    {{ $registro->forma_pago === 'cheque' ? 'Cheque' : 'Transferencia Bancaria' }}
                    &nbsp;•&nbsp;
                    {{ $registro->fecha ? \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') : '-' }}
                </div>
                @php
                    $estatusTexto = $registro->estatus === 'activo' ? 'Pendiente' 
                                  : ($registro->estatus === 'completado' ? 'Aplicado' 
                                  : ($registro->estatus === 'cancelado' ? 'Cancelado' : $registro->estatus));
                @endphp
                <span class="estatus-badge estatus-{{ $registro->estatus }}">
                    {{ $estatusTexto }}
                </span>
            </div>
            <div class="header-right">
                <div class="folio-box">
                    <div class="folio-label">Folio</div>
                    <div class="folio-value">{{ $registro->folio ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============ DATOS DEL PROVEEDOR ============ -->
    <div class="section">
        <div class="section-title">Datos del Proveedor</div>
        <div class="two-columns">
            <div class="col">
                <table class="info-table">
                    <tr>
                        <td class="label">Razón Social</td>
                        <td class="value">{{ $registro->proveedor ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">RFC</td>
                        <td class="value">{{ $registro->rfc ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col">
                <table class="info-table">
                    <tr>
                        <td class="label">Proyecto</td>
                        <td class="value">{{ $registro->proyecto->nombre ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Código SAT</td>
                        <td class="value">
                            {{ $registro->codigoSat->codigo_agrupador ?? '-' }}
                            {{ $registro->codigoSat->nombre_cuenta ? '- ' . $registro->codigoSat->nombre_cuenta : '' }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- ============ DATOS DEL PAGO ============ -->
    <div class="section">
        <div class="section-title">Datos del Pago</div>
        <div class="two-columns">
            <div class="col">
                <table class="info-table">
                    <tr>
                        <td class="label">Fecha</td>
                        <td class="value">{{ $registro->fecha ? \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Forma de Pago</td>
                        <td class="value">{{ $registro->forma_pago === 'cheque' ? 'Cheque' : 'Transferencia' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Moneda</td>
                        <td class="value">
                            {{ $registro->moneda->simbolo ?? '' }} {{ $registro->moneda->nombre ?? '-' }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col">
                <table class="info-table">
                    <tr>
                        <td class="label">Cuenta Bancaria</td>
                        <td class="value">
                            {{ $registro->cuentaBancaria->numero_cuenta ?? '-' }}
                            @if($registro->cuentaBancaria && $registro->cuentaBancaria->banco)
                                <br><small style="color:#6B7A8F;">{{ $registro->cuentaBancaria->banco->nombre }}</small>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Referencia</td>
                        <td class="value">{{ $registro->referencia ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Referencia Bancaria</td>
                        <td class="value">{{ $registro->referencia_bancaria ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- ============ TOTALES ============ -->
    <div class="totales-card">
        <div class="totales-grid">
            <div class="total-item">
                <div class="total-label">Monto Total</div>
                <div class="total-value">${{ number_format($registro->monto, 2) }}</div>
            </div>
            <div class="total-item">
                <div class="total-label">Monto Aplicado</div>
                <div class="total-value">${{ number_format($registro->monto_aplicado, 2) }}</div>
            </div>
            <div class="total-item">
                <div class="total-label">Monto Restante</div>
                <div class="total-value">${{ number_format($registro->monto_restante, 2) }}</div>
            </div>
        </div>
    </div>

    <!-- ============ FACTURAS APLICADAS ============ -->
    @if(count($facturasDetalle) > 0)
    <div class="section">
        <div class="section-title">Facturas Aplicadas ({{ count($facturasDetalle) }})</div>
        <table class="facturas-table">
            <thead>
                <tr>
                    <th style="width: 40px;">#</th>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th class="text-right">Total Factura</th>
                    <th class="text-right">Monto Aplicado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($facturasDetalle as $i => $f)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $f['folio'] }}</strong></td>
                    <td>{{ $f['fecha'] ? \Carbon\Carbon::parse($f['fecha'])->format('d/m/Y') : '-' }}</td>
                    <td class="text-right">${{ number_format($f['total'], 2) }}</td>
                    <td class="text-right"><strong>${{ number_format($f['monto_aplicado'], 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right">TOTAL APLICADO:</td>
                    <td class="text-right">${{ number_format(array_sum(array_column($facturasDetalle, 'monto_aplicado')), 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endif

    <!-- ============ CONCEPTO ============ -->
    @if($registro->descripcion)
    <div class="section">
        <div class="section-title">Concepto</div>
        <div class="textarea-box">{{ $registro->descripcion }}</div>
    </div>
    @endif

    <!-- ============ OBSERVACIONES ============ -->
    @if($registro->observaciones)
    <div class="section">
        <div class="section-title">Observaciones</div>
        <div class="textarea-box">{{ $registro->observaciones }}</div>
    </div>
    @endif

    <!-- ============ FIRMAS ============ -->
    <div class="firmas">
        <div class="firma-item">
            <div class="firma-line">Autorizó</div>
        </div>
        <div class="firma-item">
            <div class="firma-line">Recibió</div>
        </div>
    </div>

    <!-- ============ FOOTER ============ -->
    <div class="footer">
        Documento generado el {{ now()->format('d/m/Y H:i:s') }} • Sistema de Tesorería • {{ $registro->folio }}
    </div>

</body>
</html>