<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #2378e1; padding-bottom: 10px; }
        .header h1 { color: #2378e1; margin: 0; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        td, th { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #2378e1; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Prepago {{ $prepago->folio }}</h1>
        <p>Fecha de emisión: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <tr><th>Folio</th><td>{{ $prepago->folio }}</td></tr>
        <tr><th>Proveedor</th><td>{{ $prepago->proveedor->nombre ?? 'Sin proveedor' }}</td></tr>
        <tr><th>Fecha</th><td>{{ optional($prepago->fecha)->format('d/m/Y') }}</td></tr>
        <tr><th>Monto</th><td>${{ number_format($prepago->monto, 2) }}</td></tr>
        <tr><th>Estatus</th><td>{{ $prepago->estatus }}</td></tr>
        <tr><th>Observaciones</th><td>{{ $prepago->observaciones ?? '-' }}</td></tr>
    </table>
</body>
</html>