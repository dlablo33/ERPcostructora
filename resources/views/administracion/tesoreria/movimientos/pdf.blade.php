<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Movimiento #{{ $movimiento->id }}</title>
    <style>
        @page { margin: 25px; }
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #000; }
        .header { text-align: center; border-bottom: 2px solid #083CAE; padding-bottom: 10px; margin-bottom: 15px; }
        .header h1 { color: #083CAE; margin: 0; font-size: 20px; }
        .header .sub { color: #555; font-size: 11px; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        th, td { border: 1px solid #999; padding: 6px 8px; vertical-align: top; }
        th { background-color: #f0f4ff; color: #083CAE; text-align: left; width: 200px; font-weight: bold; }
        .text-right { text-align: right; }
        .footer { margin-top: 20px; font-size: 10px; color: #666; text-align: center; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 10px; background: #e8f0fe; color: #083CAE; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Detalle del Movimiento Bancario</h1>
        <div class="sub">
            <span class="badge">ID: {{ $movimiento->id }}</span>
            &nbsp;·&nbsp; Fecha: {{ $movimiento->fecha }}
            &nbsp;·&nbsp; Generado: {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>

    <table>
        <tr><th>Folio</th><td>{{ $movimiento->folio ?? ('MOV-' . str_pad($movimiento->id, 6, '0', STR_PAD_LEFT)) }}</td></tr>
        <tr><th>Referencia</th><td>{{ $movimiento->referencia ?? '-' }}</td></tr>
        <tr><th>Ref. Bancaria</th><td>{{ $movimiento->referencia_bancaria ?? '-' }}</td></tr>
        <tr><th>Origen</th><td>{{ $movimiento->origen ?? $movimiento->tipo ?? '-' }}</td></tr>
        <tr><th>Concepto</th><td>{{ $movimiento->concepto ?? '-' }}</td></tr>
        <tr><th>Descripción</th><td>{{ $movimiento->descripcion ?? '-' }}</td></tr>
        @if(!empty($movimiento->observaciones))
        <tr><th>Observaciones</th><td>{{ $movimiento->observaciones }}</td></tr>
        @endif
    </table>

    <table>
        <tr>
            <th>Banco</th><td>{{ $movimiento->cuentaBancaria->banco->nombre ?? '-' }}</td>
            <th>No. Cuenta</th><td>{{ $movimiento->cuentaBancaria->numero_cuenta ?? '-' }}</td>
        </tr>
        <tr>
            <th>Moneda</th><td>{{ $movimiento->cuentaBancaria->moneda->nombre ?? '-' }}</td>
            <th>Proyecto</th><td>{{ $movimiento->proyecto->nombre ?? '-' }}</td>
        </tr>
        <tr>
            <th>Tipo</th><td>{{ ucfirst($movimiento->tipo ?? '-') }}</td>
            <th>Método Pago</th><td>{{ $movimiento->metodoPago->nombre ?? '-' }}</td>
        </tr>
        <tr>
            <th>Tipo Ingreso</th><td>{{ $movimiento->tipoIngreso->nombre ?? '-' }}</td>
            <th>Tipo Egreso</th><td>{{ $movimiento->tipoEgreso->nombre ?? '-' }}</td>
        </tr>
        <tr>
            <th>Categoría</th><td>{{ $movimiento->categoriaGasto->nombre ?? '-' }}</td>
            <th>Status</th><td>{{ ucfirst($movimiento->status ?? '-') }}</td>
        </tr>
        <tr>
            <th>Creado por</th><td colspan="3">{{ $movimiento->creador->name ?? '-' }}</td>
        </tr>
    </table>

    @php
        $esCargo = in_array($movimiento->tipo, ['cargo', 'egreso', 'pago', 'retiro', 'compra', 'gasto']);
        $esAbono = in_array($movimiento->tipo, ['abono', 'ingreso', 'deposito', 'transferencia_recibida', 'pago_recibido']);
        $monto = floatval($movimiento->monto ?? 0);
    @endphp

    <table>
        <tr>
            <th>Monto</th>
            <td class="text-right">${{ number_format($monto, 2) }}</td>
        </tr>
        <tr>
            <th>Movimiento</th>
            <td class="text-right">
                {{ $esCargo ? 'CARGO' : ($esAbono ? 'ABONO' : '-') }}
            </td>
        </tr>
        @if($esCargo)
        <tr><th>Cargos</th><td class="text-right">${{ number_format($monto, 2) }}</td></tr>
        @elseif($esAbono)
        <tr><th>Abonos</th><td class="text-right">${{ number_format($monto, 2) }}</td></tr>
        @endif
    </table>

    <div class="footer">
        Documento generado automáticamente — {{ config('app.name') }}
    </div>
</body>
</html>