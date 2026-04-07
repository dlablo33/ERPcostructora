<tbody id="tablaBody">
    @if(isset($nominas) && $nominas->count() > 0)
        @foreach($nominas as $nomina)
        <tr data-id="{{ $nomina->id }}">
            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;"><strong>{{ $nomina->folio }}</strong></td>
            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">{{ $nomina->empleado_nombre }}</td>
            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                <span class="badge-periodo {{ $nomina->periodo_tipo }}">{{ ucfirst($nomina->periodo_tipo) }}</span>
            </td>
            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ \Carbon\Carbon::parse($nomina->periodo_inicio)->format('d/m/Y') }}</td>
            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ \Carbon\Carbon::parse($nomina->periodo_fin)->format('d/m/Y') }}</td>
            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $nomina->dias_trabajados }}/{{ $nomina->periodo_tipo == 'semanal' ? 7 : 15 }}</td>
            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">${{ number_format($nomina->neto_pagar, 2) }}</td>
            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                @php
                    $estatusClass = '';
                    switch($nomina->estatus) {
                        case 'Pagada': $estatusClass = 'badge-pagada'; break;
                        case 'Calculada': $estatusClass = 'badge-calculada'; break;
                        case 'Cancelada': $estatusClass = 'badge-cancelada'; break;
                        default: $estatusClass = 'badge-pendiente';
                    }
                @endphp
                <span class="{{ $estatusClass }}">{{ $nomina->estatus }}</span>
            </td>
            <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; text-align: center;">
                <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verDetalle({{ $nomina->id }})" title="Ver detalle"></i>
                <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarEstatus({{ $nomina->id }})" title="Cambiar estatus"></i>
                <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="imprimirRecibo({{ $nomina->id }})" title="Imprimir recibo"></i>
                <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="generarPDF({{ $nomina->id }})" title="Generar PDF"></i>
            </td>
        </tr>
        @endforeach
    @else
        <tr>
            <td colspan="9" style="text-align: center; padding: 40px;">
                <i class="fas fa-calculator" style="font-size: 48px; color: #dee2e6; margin-bottom: 15px; display: block;"></i>
                No hay cálculos de nómina registrados
            </td>
        </tr>
    @endif
</tbody>
<tfoot style="background-color: #e9ecef; font-weight: bold;">
    <tr>
        <td colspan="6" style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right;">Total General:</td>
        <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right; background-color: #e9ecef;" id="totalSuma">${{ number_format(isset($nominas) ? $nominas->sum('neto_pagar') : 0, 2) }}</td>
        <td colspan="2" style="padding: 12px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #e9ecef;"></td>
    </tr>
</tfoot>

<!-- Datos para KPIs -->
<div style="display: none;" id="kpis-data">
    <span id="totalNominas">{{ $totalNominas ?? 0 }}</span>
    <span id="totalPagado">${{ number_format($totalPagado ?? 0, 2) }}</span>
    <span id="pendientes">{{ $totalPendiente ?? 0 }}</span>
</div>