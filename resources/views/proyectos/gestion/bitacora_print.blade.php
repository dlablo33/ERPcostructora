<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Bitácora - {{ now()->format('d/m/Y') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            padding: 20px;
            background: white;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #083CAE;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 { color: #083CAE; font-size: 22px; margin: 0; }
        .header .meta { text-align: right; font-size: 11px; color: #666; }
        .header .meta strong { color: #333; }

        .filtros {
            background: #f8f9fa;
            border-left: 4px solid #083CAE;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 11px;
        }
        .filtros span { margin-right: 20px; }
        .filtros strong { color: #083CAE; }

        .resumen {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        .resumen-card {
            flex: 1;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 10px 15px;
            background: white;
        }
        .resumen-card .label {
            font-size: 10px;
            color: #6c757d;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .resumen-card .value {
            font-size: 20px;
            font-weight: bold;
            color: #083CAE;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table thead {
            background: #083CAE;
            color: white;
        }
        table th {
            padding: 8px 6px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            border: 1px solid #083CAE;
        }
        table td {
            padding: 8px 6px;
            border: 1px solid #dee2e6;
            font-size: 10px;
            vertical-align: top;
        }
        table tbody tr:nth-child(even) { background: #f8f9fa; }
        table tbody tr:hover { background: #e9ecef; }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
        }
        .badge-actividad  { background: #007bff; }
        .badge-incidencia { background: #dc3545; }
        .badge-acuerdo    { background: #6f42c1; }
        .badge-nota       { background: #6c757d; }

        .badge-pendiente  { background: #fd7e14; }
        .badge-en_proceso { background: #17a2b8; }
        .badge-completado { background: #28a745; }
        .badge-cerrado    { background: #6c757d; }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            font-size: 9px;
            color: #999;
        }

        .no-print {
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
        }
        .no-print button {
            padding: 10px 20px;
            background: #083CAE;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            margin: 0 5px;
        }
        .no-print button:hover { background: #052a6b; }

        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
            @page { margin: 1cm; }
        }
    </style>
</head>
<body>

<!-- Botones de acción (no se imprimen) -->
<div class="no-print">
    <button onclick="window.print()">
        🖨️ Imprimir / Guardar PDF
    </button>
    <button onclick="window.close()">
        ✖ Cerrar
    </button>
</div>

<!-- Encabezado -->
<div class="header">
    <div>
        <h1>📋 Bitácora de Obra</h1>
        <div style="font-size: 11px; color: #666; margin-top: 5px;">Reporte generado el {{ now()->format('d/m/Y H:i') }}</div>
    </div>
    <div class="meta">
        <div><strong>Total de registros:</strong> {{ $entries->count() }}</div>
        @if(request('proyecto_id'))
            <div><strong>Proyecto:</strong> {{ request('proyecto_id') }}</div>
        @endif
    </div>
</div>

<!-- Filtros aplicados -->
<div class="filtros">
    <strong>Filtros aplicados:</strong>
    @if(request('proyecto_id'))
        <span>Proyecto: {{ request('proyecto_id') }}</span>
    @else
        <span>Proyecto: Todos</span>
    @endif

    @if(request('fecha_inicio') && request('fecha_fin'))
        <span>Periodo: {{ \Carbon\Carbon::parse(request('fecha_inicio'))->format('d/m/Y') }} al {{ \Carbon\Carbon::parse(request('fecha_fin'))->format('d/m/Y') }}</span>
    @else
        <span>Periodo: Todo</span>
    @endif
</div>

<!-- Resumen -->
@php
    $total       = $entries->count();
    $actividades = $entries->where('tipo', 'actividad')->count();
    $incidencias = $entries->where('tipo', 'incidencia')->count();
    $pendientes  = $entries->where('estado', 'pendiente')->count();
@endphp

<div class="resumen">
    <div class="resumen-card">
        <div class="label">Total Entradas</div>
        <div class="value">{{ $total }}</div>
    </div>
    <div class="resumen-card">
        <div class="label">Actividades</div>
        <div class="value" style="color: #28a745;">{{ $actividades }}</div>
    </div>
    <div class="resumen-card">
        <div class="label">Incidencias</div>
        <div class="value" style="color: #dc3545;">{{ $incidencias }}</div>
    </div>
    <div class="resumen-card">
        <div class="label">Pendientes</div>
        <div class="value" style="color: #fd7e14;">{{ $pendientes }}</div>
    </div>
</div>

<!-- Tabla de entradas -->
@if($entries->count() > 0)
<table>
    <thead>
        <tr>
            <th style="width: 70px;">Fecha</th>
            <th style="width: 50px;">Hora</th>
            <th style="width: 60px;">Proyecto</th>
            <th style="width: 80px;">Tipo</th>
            <th style="width: 80px;">Estado</th>
            <th>Título / Descripción</th>
            <th style="width: 100px;">Responsable</th>
        </tr>
    </thead>
    <tbody>
        @foreach($entries as $entry)
        <tr>
            <td>{{ \Carbon\Carbon::parse($entry->fecha)->format('d/m/Y') }}</td>
            <td>{{ substr($entry->hora, 0, 5) }}</td>
            <td>{{ $entry->proyecto_id }}</td>
            <td>
                <span class="badge badge-{{ $entry->tipo }}">
                    {{ $entry->tipo }}
                </span>
            </td>
            <td>
                <span class="badge badge-{{ $entry->estado }}">
                    {{ str_replace('_', ' ', $entry->estado) }}
                </span>
            </td>
            <td>
                <strong>{{ $entry->titulo }}</strong>
                @if($entry->descripcion)
                    <div style="color: #666; margin-top: 3px;">{{ $entry->descripcion }}</div>
                @endif
                @if($entry->personal || $entry->maquinaria || $entry->materiales)
                    <div style="font-size: 9px; color: #888; margin-top: 3px;">
                        @if($entry->personal) <span><strong>Personal:</strong> {{ $entry->personal }}</span> @endif
                        @if($entry->maquinaria) <span style="margin-left: 8px;"><strong>Maq:</strong> {{ $entry->maquinaria }}</span> @endif
                        @if($entry->materiales) <span style="margin-left: 8px;"><strong>Mat:</strong> {{ $entry->materiales }}</span> @endif
                    </div>
                @endif
            </td>
            <td>{{ $entry->responsable ?: '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
    <div style="padding: 40px; text-align: center; background: #f8f9fa; border-radius: 6px; color: #6c757d;">
        <div style="font-size: 40px; margin-bottom: 10px;">📋</div>
        <div>No hay registros que coincidan con los filtros aplicados.</div>
    </div>
@endif

<!-- Footer -->
<div class="footer">
    <div>MejoraSoft ERP - Bitácora de Obra</div>
    <div>Documento generado automáticamente - {{ now()->format('d/m/Y H:i:s') }}</div>
</div>

</body>
</html>