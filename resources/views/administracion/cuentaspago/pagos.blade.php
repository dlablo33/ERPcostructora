@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0 0 15px 0; font-size: 24px; text-align: center; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    Antiguedad de Cuentas Por Pagar
                    <i class="fa-solid fa-arrow-trend-down" style="color: #dc2626; font-size: 26px;"></i>
                </h2>
                
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <label for="proveedor_id" style="color: #083CAE; font-weight: 500; margin-right: 10px;">Proveedor:</label>
                        <select class="form-control form-control-sm" id="proveedor_id" style="width: auto; display: inline-block; border: 1px solid #083CAE; border-radius: 4px; padding: 5px 10px;">
                            <option value="0" {{ request('proveedor') == '0' || !request('proveedor') ? 'selected' : '' }}>TODOS</option>
                            @if(isset($proveedores) && count($proveedores) > 0)
                                @foreach($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}" {{ request('proveedor') == $proveedor->id ? 'selected' : '' }}>
                                        {{ $proveedor->nombre }}
                                    </option>
                                @endforeach
                            @else
                                <option value="" disabled>No hay proveedores registrados</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-5"></div>
                    <div class="col-md-4 text-right">
                        <button type="button" class="btn btn-sm" id="buttonExcel" style="background-color: #28a745; color: white; border: none; padding: 5px 15px; border-radius: 4px; margin-right: 5px;">
                            <i class="fas fa-file-excel mr-1"></i> Descarga Excel
                        </button>
                        <button type="button" class="btn btn-sm" id="buttonVerPDF" style="background-color: #28a745; color: white; border: none; padding: 5px 15px; border-radius: 4px; margin-right: 5px;">
                            <i class="fas fa-file-pdf mr-1"></i> Descarga PDF
                        </button>
                        <button type="button" class="btn btn-sm" id="buttonRecargar" style="background-color: #28a745; color: white; border: none; padding: 5px 10px; border-radius: 4px;">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <!-- PRIMERA FILA: 4 CUADROS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 15px;">
                    <div style="flex: 1 1 calc(14.28% - 15px); min-width: 130px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px; display: flex; align-items: center; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%;">
                            <div style="background-color: #28a745; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                <i class="fas fa-search-dollar" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Total CXP</div>
                                <div style="color: #083CAE; font-size: 16px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${{ number_format($totales['total_general'] ?? 0, 2) }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="flex: 1 1 calc(14.28% - 15px); min-width: 130px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px; display: flex; align-items: center; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%;">
                            <div style="background-color: #28a745; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                <i class="fas fa-calendar-check" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Corriente</div>
                                <div style="color: #083CAE; font-size: 16px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${{ number_format($totales['corriente'] ?? 0, 2) }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="flex: 1 1 calc(14.28% - 15px); min-width: 130px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px; display: flex; align-items: center; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%;">
                            <div style="background-color: #ffc107; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                <i class="fas fa-clock" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">De 1 a 30 Días</div>
                                <div style="color: #083CAE; font-size: 16px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${{ number_format($totales['de_1_a_30'] ?? 0, 2) }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="flex: 1 1 calc(14.28% - 15px); min-width: 130px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px; display: flex; align-items: center; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%;">
                            <div style="background-color: #ff9800; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                <i class="fas fa-hourglass-half" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">31 a 60 Días</div>
                                <div style="color: #083CAE; font-size: 16px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${{ number_format($totales['de_31_a_60'] ?? 0, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEGUNDA FILA: 3 CUADROS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
                    <div style="flex: 1 1 calc(14.28% - 15px); min-width: 130px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px; display: flex; align-items: center; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%;">
                            <div style="background-color: #fd7e14; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                <i class="fas fa-hourglass-start" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">61 a 90 Días</div>
                                <div style="color: #083CAE; font-size: 16px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${{ number_format($totales['de_61_a_90'] ?? 0, 2) }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="flex: 1 1 calc(14.28% - 15px); min-width: 130px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px; display: flex; align-items: center; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%;">
                            <div style="background-color: #dc3545; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                <i class="fas fa-hourglass-end" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">91 a 120 Días</div>
                                <div style="color: #083CAE; font-size: 16px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${{ number_format($totales['de_91_a_120'] ?? 0, 2) }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="flex: 1 1 calc(14.28% - 15px); min-width: 130px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px; display: flex; align-items: center; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%;">
                            <div style="background-color: #c82333; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                <i class="fas fa-skull-crosswalk" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Mas de 120 Días</div>
                                <div style="color: #083CAE; font-size: 16px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${{ number_format($totales['mas_120'] ?? 0, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 500px; overflow-y: auto;">
                    <table class="table table-bordered table-striped" id="semaforoCXP" style="width: 100%; margin-bottom: 0; font-size: 12px;">
                        <thead style="position: sticky; top: 0; z-index: 10;">
                            <tr style="background-color: #e9ecef;">
                                <th style="width: 30px; text-align: center; background-color: #6B8ACE !important; color: white;"></th>
                                <th style="min-width: 200px; background-color: #6B8ACE !important; color: white;">Proveedor / Pago</th>
                                <th style="min-width: 120px; text-align: center; background-color: #6B8ACE !important; color: white;">Fecha Venc.</th>
                                <th style="width: 100px; background-color: #28a745 !important; color: white; text-align: center;">Corriente</th>
                                <th style="width: 80px; background-color: #ffc107 !important; color: #000; text-align: center;">1-30</th>
                                <th style="width: 80px; background-color: #ff9800 !important; color: white; text-align: center;">31-60</th>
                                <th style="width: 80px; background-color: #fd7e14 !important; color: white; text-align: center;">61-90</th>
                                <th style="width: 80px; background-color: #dc3545 !important; color: white; text-align: center;">91-120</th>
                                <th style="width: 80px; background-color: #c82333 !important; color: white; text-align: center;">+120</th>
                                <th style="width: 100px; background-color: #6B8ACE !important; color: white; text-align: center;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($cuentasPorProveedor) && count($cuentasPorProveedor) > 0)
                                @foreach($cuentasPorProveedor as $proveedorId => $proveedorData)
                                    @php $totalProveedor = $proveedorData['totales']['total']; @endphp
                                    <tr class="parent-row" data-proveedor="{{ $proveedorId }}" style="background-color: #e9ecef; font-weight: bold; cursor: pointer;">
                                        <td style="text-align: center;">
                                            <i class="fas fa-chevron-right toggle-icon" style="color: #083CAE;"></i>
                                        </td>
                                        <td colspan="2">
                                            <i class="fas fa-building"></i> {{ $proveedorData['proveedor']->nombre }}
                                            @if($proveedorData['proveedor']->rfc && $proveedorData['proveedor']->rfc != 'N/A')
                                                <br><small class="text-muted">RFC: {{ $proveedorData['proveedor']->rfc }}</small>
                                            @endif
                                        </td>
                                        <td style="text-align: right; background-color: #d4edda; font-weight: bold;">{{ number_format($proveedorData['rangos']['corriente'], 2) }}</td>
                                        <td style="text-align: right; background-color: #fff3cd;">{{ number_format($proveedorData['rangos']['1_30'], 2) }}</td>
                                        <td style="text-align: right; background-color: #ffe0b3;">{{ number_format($proveedorData['rangos']['31_60'], 2) }}</td>
                                        <td style="text-align: right; background-color: #ffd699; font-weight: bold;">{{ number_format($proveedorData['rangos']['61_90'], 2) }}</td>
                                        <td style="text-align: right; background-color: #f8d7da;">{{ number_format($proveedorData['rangos']['91_120'], 2) }}</td>
                                        <td style="text-align: right; background-color: #f5c6cb;">{{ number_format($proveedorData['rangos']['mas_120'], 2) }}</td>
                                        <td style="text-align: right; font-weight: bold; background-color: #e7f1ff;">{{ number_format($totalProveedor, 2) }}</td>
                                    </tr>
                                    
                                    @foreach($proveedorData['pagos'] as $pago)
                                    <tr class="child-row" data-parent="{{ $proveedorId }}" style="background-color: #ffffff; display: none;">
                                        <td style="text-align: center;"> </td>
                                        <td style="padding-left: 35px;">
                                            <i class="fas fa-file-invoice"></i> 
                                            <a href="#" onclick="verDetallePago({{ $pago['pago_id'] }})" style="text-decoration: underline; color: #0000ee; cursor: pointer;">
                                                {{ $pago['folio'] }}
                                            </a>
                                        </td>
                                        <td style="text-align: center;">
                                            @if($pago['fecha_vencimiento'])
                                                {{ $pago['fecha_vencimiento'] }}
                                                <br>
                                                <small class="{{ str_contains($pago['texto_dias'], 'Vence') ? 'text-success' : 'text-danger' }}">
                                                    {{ $pago['texto_dias'] }}
                                                </small>
                                            @else
                                                <span class="text-muted">Sin fecha</span>
                                            @endif
                                        </td>
                                        <td style="text-align: right;">{{ number_format($pago['corriente'], 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($pago['rango_1_30'], 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($pago['rango_31_60'], 2) }}</td>
                                        <td style="text-align: right; font-weight: bold;">{{ number_format($pago['rango_61_90'], 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($pago['rango_91_120'], 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($pago['mas_120'], 2) }}</td>
                                        <td style="text-align: right; font-weight: bold;">{{ number_format($pago['saldo_pendiente'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" style="text-align: center; padding: 40px;">
                                        <div class="alert alert-info mb-0">
                                            <i class="fas fa-check-circle fa-3x mb-3 d-block"></i>
                                            <h5>No hay pagos pendientes</h5>
                                            <p class="mb-0">Todos los pagos están liquidados o no hay registros.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        @if(isset($cuentasPorProveedor) && count($cuentasPorProveedor) > 0)
                        <tfoot style="background-color: #e9ecef; font-weight: bold; border-top: 2px solid #083CAE;">
                            <tr>
                                <td colspan="3" style="text-align: right; font-size: 13px;">TOTAL GENERAL:</td>
                                <td style="text-align: right; background-color: #d4edda;">{{ number_format($totales['corriente'] ?? 0, 2) }}</td>
                                <td style="text-align: right; background-color: #fff3cd;">{{ number_format($totales['de_1_a_30'] ?? 0, 2) }}</td>
                                <td style="text-align: right; background-color: #ffe0b3;">{{ number_format($totales['de_31_a_60'] ?? 0, 2) }}</td>
                                <td style="text-align: right; background-color: #ffd699; font-weight: bold;">{{ number_format($totales['de_61_a_90'] ?? 0, 2) }}</td>
                                <td style="text-align: right; background-color: #f8d7da;">{{ number_format($totales['de_91_a_120'] ?? 0, 2) }}</td>
                                <td style="text-align: right; background-color: #f5c6cb;">{{ number_format($totales['mas_120'] ?? 0, 2) }}</td>
                                <td style="text-align: right; background-color: #e7f1ff; font-weight: bold;">{{ number_format($totales['total_general'] ?? 0, 2) }}</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .swal2-container {
        z-index: 99999 !important;
    }
    .swal2-popup {
        z-index: 100000 !important;
    }
    .custom-card {
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    .custom-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(8, 60, 174, 0.15) !important;
    }
    .parent-row {
        cursor: pointer;
    }
    .parent-row:hover {
        background-color: #dee2e6 !important;
    }
    .toggle-icon {
        transition: transform 0.3s ease;
        display: inline-block;
    }
    .toggle-icon.rotated {
        transform: rotate(90deg);
    }
    .table-responsive::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: #083CAE;
        border-radius: 10px;
    }
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #062a7a;
    }
    .btn-sm {
        font-size: 13px;
        padding: 5px 12px;
        transition: opacity 0.2s;
    }
    .btn-sm:hover {
        opacity: 0.9;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function toggleProveedor(element) {
        var proveedorId = element.getAttribute('data-proveedor');
        if (!proveedorId) {
            var parentRow = element.closest('.parent-row');
            if (parentRow) proveedorId = parentRow.getAttribute('data-proveedor');
        }
        if (!proveedorId) return;
        
        var childRows = document.querySelectorAll('.child-row[data-parent="' + proveedorId + '"]');
        var parentRow = document.querySelector('.parent-row[data-proveedor="' + proveedorId + '"]');
        var icon = parentRow ? parentRow.querySelector('.toggle-icon') : null;
        
        if (childRows.length === 0) return;
        
        var isVisible = childRows[0] && window.getComputedStyle(childRows[0]).display !== 'none';
        
        childRows.forEach(function(row) {
            row.style.display = isVisible ? 'none' : 'table-row';
        });
        
        if (icon) {
            isVisible ? icon.classList.remove('rotated') : icon.classList.add('rotated');
        }
    }
    
    document.querySelectorAll('.parent-row').forEach(function(row) {
        row.addEventListener('click', function(e) {
            if (e.target.tagName === 'A' || e.target.tagName === 'I') return;
            toggleProveedor(this);
        });
    });
    
    document.querySelectorAll('.toggle-icon').forEach(function(icon) {
        icon.addEventListener('click', function(e) {
            e.stopPropagation();
            var parentRow = this.closest('.parent-row');
            if (parentRow) toggleProveedor(parentRow);
        });
    });
    
    document.getElementById('proveedor_id')?.addEventListener('change', function() {
        var url = new URL(window.location.href);
        if (this.value === '0') {
            url.searchParams.delete('proveedor');
        } else {
            url.searchParams.set('proveedor', this.value);
        }
        window.location.href = url.toString();
    });
    
    document.getElementById('buttonRecargar')?.addEventListener('click', function() {
        location.reload();
    });
    
    document.getElementById('buttonExcel')?.addEventListener('click', function() {
        var table = document.getElementById('semaforoCXP');
        if (!table) return;
        
        var cloneTable = table.cloneNode(true);
        cloneTable.querySelectorAll('.child-row').forEach(function(row) {
            row.style.display = 'table-row';
        });
        
        var html = cloneTable.outerHTML;
        var blob = new Blob([html], { type: 'application/vnd.ms-excel' });
        var link = document.createElement('a');
        var url = URL.createObjectURL(blob);
        link.href = url;
        link.download = 'CuentasPorPagar_' + new Date().toISOString().slice(0,19) + '.xls';
        link.click();
        URL.revokeObjectURL(url);
    });
    
    document.getElementById('buttonVerPDF')?.addEventListener('click', function() {
        window.print();
    });
});

async function verDetallePago(pagoId) {
    Swal.fire({
        title: 'Detalle de Pago',
        html: '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Cargando detalles...</p></div>',
        width: '700px',
        showConfirmButton: true,
        showCancelButton: false,
        confirmButtonText: 'Cerrar',
        backdrop: true,
        allowOutsideClick: false,
        didOpen: async () => {
            try {
                const response = await fetch('/administracion/cuentaspago/detalle/' + pagoId);
                const data = await response.json();
                
                if (data.success) {
                    function formatearPesos(monto) {
                        let numero = typeof monto === 'string' ? parseFloat(monto) : monto;
                        return new Intl.NumberFormat('es-MX', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }).format(numero);
                    }
                    
                    function formatearFecha(fecha) {
                        if (!fecha) return 'N/A';
                        const date = new Date(fecha);
                        return date.toLocaleDateString('es-MX');
                    }
                    
                    Swal.update({
                        html: `
                            <div class="text-start" style="max-height: 500px; overflow-y: auto;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Pago:</strong> ${data.pago.folio}</p>
                                        <p><strong>Fecha Pago:</strong> ${formatearFecha(data.pago.fecha_pago)}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Proveedor:</strong> ${data.proveedor_nombre || data.pago.proveedor_nombre || 'N/A'}</p>
                                        <p><strong>RFC:</strong> ${data.proveedor_rfc || data.pago.proveedor_rfc || 'N/A'}</p>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="alert alert-secondary mb-0">
                                            <small>Monto</small><br>
                                            <strong>$${formatearPesos(data.pago.monto)}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-primary mb-0">
                                            <small>Saldo Pendiente</small><br>
                                            <strong>$${formatearPesos(data.saldo_pendiente)}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="alert alert-info mb-0">
                                            <small>Concepto</small><br>
                                            <strong>${data.pago.concepto || 'Sin concepto'}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="alert alert-secondary mb-0">
                                            <small>Estatus</small><br>
                                            <strong class="text-warning">${data.pago.estatus ? data.pago.estatus.toUpperCase() : 'PENDIENTE'}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `,
                        showConfirmButton: true,
                        confirmButtonText: 'Cerrar'
                    });
                } else {
                    Swal.update({
                        html: '<div class="alert alert-danger">Error al cargar los detalles</div>',
                        showConfirmButton: true,
                        confirmButtonText: 'Cerrar'
                    });
                }
            } catch (error) {
                Swal.update({
                    html: '<div class="alert alert-danger">Error de conexión al servidor</div>',
                    showConfirmButton: true,
                    confirmButtonText: 'Cerrar'
                });
            }
        }
    });
}
</script>
@endsection