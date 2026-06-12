@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Cobranza por Día -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Cobranza por Día
                </h2>
            </div>

            <div class="card-body p-4">
                @php
                    // Inicializar variables
                    $estadisticas = $estadisticas ?? (object)['cobranza_total' => 0, 'dias_con_cobro' => 0, 'facturas_cobradas' => 0];
                    $promedioDia = $promedioDia ?? 0;
                    $dias = $dias ?? collect();
                    $detallePorDia = $detallePorDia ?? [];
                    $totalesGlobales = $totalesGlobales ?? (object)['total_mxn' => 0];
                    $fechaInicio = $fechaInicio ?? date('Y-m-01');
                    $fechaFin = $fechaFin ?? date('Y-m-t');
                    $search = $search ?? '';
                @endphp

                <!-- 4 CUADROS DE COBRANZA -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Cobranza Total -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Cobranza Total</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="cobranzaTotal">${{ number_format($estadisticas->cobranza_total ?? 0, 2) }}</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Días con Cobro -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Días con Cobro</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="diasCobro">{{ $estadisticas->dias_con_cobro ?? 0 }}</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Promedio por Día -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Promedio por Día</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="promedioDia">${{ number_format($promedioDia, 2) }}</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Facturas Cobradas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Facturas Cobradas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="facturasCobradas">{{ $estadisticas->facturas_cobradas ?? 0 }}</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas con filtros -->
                <form method="GET" action="{{ route('conta.cobranza') }}" id="filtrosForm">
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-hand-holding-usd" style="color: #083CAE; font-size: 24px;"></i>
                            <h3 style="color: #083CAE; font-size: 20px; font-weight: bold; margin: 0;">Cobranza</h3>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                            <div>
                                <span style="font-weight: 600; color: #083CAE; font-size: 14px; margin-right: 5px;">Fecha inicio:</span>
                                <input type="date" name="fecha_inicio" value="{{ $fechaInicio }}" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 150px;">
                            </div>
                            <div>
                                <span style="font-weight: 600; color: #083CAE; font-size: 14px; margin-right: 5px;">Fecha fin:</span>
                                <input type="date" name="fecha_fin" value="{{ $fechaFin }}" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 150px;">
                            </div>
                            <div>
                                <button type="submit" style="background: #083CAE; border: none; border-radius: 4px; padding: 8px 16px; color: white; cursor: pointer;">
                                    <i class="fas fa-search"></i> Filtrar
                                </button>
                            </div>
                            <div>
                                <a href="{{ route('conta.cobranza') }}" style="background: #6c757d; border-radius: 4px; padding: 8px 16px; color: white; text-decoration: none; display: inline-block;">
                                    <i class="fas fa-undo"></i> Limpiar
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('conta.cobranza.exportar', request()->all()) }}" id="btnExcel" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE; text-decoration: none;">
                                    <i class="fas fa-file-excel" style="color: #083CAE;"></i> Excel
                                </a>
                            </div>
                            <div style="position: relative;">
                                <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                                <input type="text" name="search" placeholder="Buscar cliente..." value="{{ $search }}" style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Mensaje "Sin datos" -->
                @if($dias->count() == 0)
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0;">
                    <i class="fas fa-money-bill-wave" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros de cobranza para mostrar</p>
                </div>
                @else
                <!-- Lista de Cobranza por Día (Acordeón) -->
                <div style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);" id="cobranzaContainer">
                    <div style="background-color: #f1f5f9; padding: 15px 20px; border-bottom: 2px solid #083CAE;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div style="font-weight: 700; color: #083CAE; font-size: 16px;">
                                <i class="fas fa-calendar-alt mr-2"></i> Días con Cobranza
                            </div>
                            <div style="font-weight: 700; color: #083CAE; font-size: 16px;" id="totalCobranzaDisplay">
                                Total: ${{ number_format($estadisticas->cobranza_total ?? 0, 2) }}
                            </div>
                        </div>
                    </div>

                    <div id="listaDias" style="padding: 10px 0;">
                        @foreach($dias as $index => $dia)
                        <div class="dia-item" style="border-bottom: {{ $loop->last ? 'none' : '1px solid #dee2e6' }};">
                            <div class="dia-header" onclick="toggleDia(this)" style="display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; cursor: pointer; background-color: #ffffff; transition: background-color 0.2s;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <i class="fas fa-chevron-right" style="color: #083CAE; font-size: 16px; transition: transform 0.3s;"></i>
                                    <span style="font-weight: 600; color: #083CAE; font-size: 16px;">{{ \Carbon\Carbon::parse($dia->fecha)->format('Y-m-d') }}</span>
                                    <span style="color: #6c757d; font-size: 14px;">Total del Día:</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 30px;">
                                    <span style="font-weight: 700; color: #083CAE; font-size: 18px;">${{ number_format($dia->total_dia, 2) }} MXN</span>
                                </div>
                            </div>
                            <div class="dia-content" style="display: none; padding: 0 20px 20px 50px; background-color: #f8f9fa;">
                                <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                                    <thead>
                                        <tr style="border-bottom: 2px solid #dee2e6;">
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Depósito</th>
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Cliente</th>
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Factura</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">Monto Cobrado</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">Venta MXN</th>
                                            <th style="padding: 10px; text-align: center; color: #083CAE; font-weight: 600;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $totalDia = 0; @endphp
                                        @foreach($detallePorDia[$dia->fecha] ?? [] as $detalle)
                                        @php $totalDia += $detalle->monto_mxn; @endphp
                                        <tr style="border-bottom: 1px solid #e9ecef;">
                                            <td style="padding: 10px;">{{ $detalle->deposito }}</td>
                                            <td style="padding: 10px;">{{ $detalle->cliente }}</td>
                                            <td style="padding: 10px;">{{ $detalle->factura }}</td>
                                            <td style="padding: 10px; text-align: right;">${{ number_format($detalle->monto_mxn, 2) }}</td>
                                            <td style="padding: 10px; text-align: right;">${{ number_format($detalle->venta_mxn, 2) }}</td>
                                            <td style="padding: 10px; text-align: center;">
                                                <i class="fas fa-eye" data-factura="{{ $detalle->factura }}" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver Factura"></i>
                                                <i class="fas fa-file-pdf" data-factura="{{ $detalle->factura }}" style="color: #dc3545; cursor: pointer; margin: 0 5px;" title="PDF Factura"></i>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #e9ecef; font-weight: bold;">
                                            <td colspan="3" style="padding: 10px; text-align: right;">Total Día:</td>
                                            <td style="padding: 10px; text-align: right;">${{ number_format($totalDia, 2) }}</td>
                                            <td style="padding: 10px; text-align: right;">${{ number_format($totalDia, 2) }}</td>
                                            <td style="padding: 10px;"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pie de lista con totales globales -->
                    <div style="background-color: #e9ecef; padding: 15px 20px; border-top: 2px solid #083CAE;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div style="font-weight: 700; color: #083CAE; font-size: 16px;">
                                <i class="fas fa-chart-line mr-2"></i> Resumen Global
                            </div>
                            <div style="display: flex; gap: 40px;">
                                <div style="text-align: right;">
                                    <div style="font-size: 13px; color: #6c757d;">Total Cobrado</div>
                                    <div style="font-weight: 700; color: #083CAE; font-size: 18px;">${{ number_format($totalesGlobales->total_mxn ?? 0, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
</div>

<style>
    .semaforo .card-header {
        background-color: #f4f6f9;
        border-bottom: 2px solid #083CAE;
    }
    
    .semaforo .card-header h2 {
        color: #083CAE !important;
    }
    
    .custom-card {
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    
    .custom-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(8, 60, 174, 0.15) !important;
        border-color: #083CAE !important;
    }
    
    .dia-header {
        transition: background-color 0.2s;
    }
    
    .dia-header:hover {
        background-color: #f1f5f9 !important;
    }
    
    .dia-header i.fa-chevron-right {
        transition: transform 0.3s;
    }
    
    .dia-header.expandido i.fa-chevron-right {
        transform: rotate(90deg);
    }
    
    .dia-content {
        transition: all 0.3s ease;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    
    th {
        background-color: #f8f9fa;
        color: #083CAE;
        font-weight: 600;
        padding: 10px;
        border-bottom: 2px solid #083CAE;
    }
    
    td {
        padding: 8px 10px;
        border-bottom: 1px solid #e9ecef;
    }
    
    tbody tr:hover {
        background-color: #f1f5f9 !important;
    }
    
    tfoot td {
        font-weight: 600;
        background-color: #e9ecef;
    }
    
    #btnExcel {
        transition: all 0.3s ease;
    }
    
    #btnExcel:hover {
        background-color: #f8f9fa !important;
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    input[type="date"] {
        transition: all 0.3s ease;
    }
    
    input[type="date"]:focus {
        outline: none;
        border-color: #083CAE;
        box-shadow: 0 0 0 2px rgba(8, 60, 174, 0.2);
    }
    
    .fa-eye:hover, .fa-file-pdf:hover {
        transform: scale(1.2);
        transition: transform 0.2s;
    }
    
    .fa-eye:hover {
        color: #0056b3 !important;
    }
    
    .fa-file-pdf:hover {
        color: #b02a37 !important;
    }
    
    @media (max-width: 768px) {
        [style*="flex: 0 1 calc(25% - 15px)"] {
            flex: 0 1 calc(50% - 15px) !important;
        }
        
        .dia-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 10px;
        }
        
        table {
            font-size: 11px;
        }
        
        td, th {
            padding: 5px !important;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filtrosForm');
    const fechaInicio = document.querySelector('input[name="fecha_inicio"]');
    const fechaFin = document.querySelector('input[name="fecha_fin"]');
    const searchInput = document.querySelector('input[name="search"]');
    
    // Auto-submit cuando cambian las fechas
    if (fechaInicio) fechaInicio.addEventListener('change', () => form.submit());
    if (fechaFin) fechaFin.addEventListener('change', () => form.submit());
    
    // Buscador con debounce
    if (searchInput) {
        let timeout;
        searchInput.addEventListener('input', () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => form.submit(), 500);
        });
    }
    
    // Acciones de iconos
    document.querySelectorAll('.fa-eye').forEach(icon => {
        icon.addEventListener('click', function() {
            const factura = this.dataset.factura;
            alert('Ver detalle de factura: ' + factura);
        });
    });
    
    document.querySelectorAll('.fa-file-pdf').forEach(icon => {
        icon.addEventListener('click', function() {
            const factura = this.dataset.factura;
            alert('Descargar PDF de factura: ' + factura);
        });
    });
});

window.toggleDia = function(header) {
    const content = header.nextElementSibling;
    const icon = header.querySelector('i.fa-chevron-right');
    
    if (content.style.display === 'none' || content.style.display === '') {
        content.style.display = 'block';
        header.classList.add('expandido');
    } else {
        content.style.display = 'none';
        header.classList.remove('expandido');
    }
};
</script>
@endsection