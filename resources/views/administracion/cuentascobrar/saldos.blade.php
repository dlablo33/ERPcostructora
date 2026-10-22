@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h1 style="color: #083CAE; font-weight: bold; margin: 0 0 15px 0; font-size: 28px; text-align: center; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    Antiguedad de Cuentas Por Cobrar
                    <i class="fa-solid fa-arrow-trend-up" style="color: #16a34a; font-size: 26px;"></i>
                </h1>

                <div class="row align-items-center">
                    <div class="col-md-3">
                        <label for="contacto_id" style="color: #083CAE; font-weight: 500; margin-right: 10px;">Cliente:</label>
                        <select class="form-control form-control-sm" id="contacto_id" style="width: auto; display: inline-block; border: 1px solid #083CAE; border-radius: 4px; padding: 5px 10px;">
                            <option value="0" {{ request('cliente') == '0' || !request('cliente') ? 'selected' : '' }}>TODOS</option>
                            @if(isset($clientes) && count($clientes) > 0)
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->contacto_id }}" {{ request('cliente') == $cliente->contacto_id ? 'selected' : '' }}>
                                        {{ $cliente->razon_social }}
                                    </option>
                                @endforeach
                            @else
                                <option value="" disabled>No hay clientes registrados</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-5"></div>
                    <div class="col-md-4 text-right">
                        <button type="button" class="btn btn-sm" id="buttonActualizar" style="background-color: #083CAE; color: white; border: none; padding: 5px 15px; border-radius: 4px; margin-right: 5px;">
                            <i class="fas fa-sync-alt mr-1"></i> Actualizar
                        </button>
                        <button type="button" class="btn btn-sm" id="buttonExcel" style="background-color: #28a745; color: white; border: none; padding: 5px 15px; border-radius: 4px; margin-right: 5px;">
                            <i class="fas fa-file-excel mr-1"></i> Descarga Excel
                        </button>
                        <button type="button" class="btn btn-sm" id="buttonVerPDF" style="background-color: #28a745; color: white; border: none; padding: 5px 15px; border-radius: 4px; margin-right: 5px;">
                            <i class="fas fa-file-pdf mr-1"></i> Descarga PDF
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <!-- PRIMERA FILA: 4 CUADROS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 15px;">
                    <div style="flex: 1 1 calc(12.5% - 15px); min-width: 130px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px; display: flex; align-items: center; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%;">
                            <div style="background-color: #28a745; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                <i class="fas fa-search-dollar" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Total CXC</div>
                                <div style="color: #083CAE; font-size: 16px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${{ number_format($totales['total_general'] ?? 0, 2) }}</div>
                            </div>
                        </div>
                    </div>

                    <div style="flex: 1 1 calc(12.5% - 15px); min-width: 130px;">
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

                    <div style="flex: 1 1 calc(12.5% - 15px); min-width: 130px;">
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

                    <div style="flex: 1 1 calc(12.5% - 15px); min-width: 130px;">
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

                <!-- SEGUNDA FILA: 4 CUADROS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
                    <div style="flex: 1 1 calc(12.5% - 15px); min-width: 130px;">
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

                    <div style="flex: 1 1 calc(12.5% - 15px); min-width: 130px;">
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

                    <div style="flex: 1 1 calc(12.5% - 15px); min-width: 130px;">
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

                    <div style="flex: 1 1 calc(12.5% - 15px); min-width: 130px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px; display: flex; align-items: center; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%;">
                            <div style="background-color: #6c757d; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                <i class="fas fa-hand-holding-heart" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Anticipo</div>
                                <div style="color: #083CAE; font-size: 16px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${{ number_format($totales['anticipo'] ?? 0, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de antigüedad -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 550px; overflow-y: auto; overflow-x: auto;">
                    <table class="table table-bordered table-striped" id="semaforoCXC" style="width: 100%; margin-bottom: 0; font-size: 12px; min-width: 1200px;">
                        <thead style="position: sticky; top: 0; z-index: 10;">
                            <tr style="background-color: #e9ecef;">
                                <th style="width: 30px; text-align: center; background-color: #6B8ACE !important; color: white;"></th>
                                <th style="min-width: 220px; background-color: #6B8ACE !important; color: white;">Cliente / Factura</th>
                                <th style="min-width: 140px; text-align: center; background-color: #6B8ACE !important; color: white;">Fecha Venc.</th>
                                <th style="width: 110px; background-color: #28a745 !important; color: white; text-align: center;">Corriente</th>
                                <th style="width: 90px; background-color: #ffc107 !important; color: #000; text-align: center;">1-30</th>
                                <th style="width: 90px; background-color: #ff9800 !important; color: white; text-align: center;">31-60</th>
                                <th style="width: 90px; background-color: #fd7e14 !important; color: white; text-align: center;">61-90</th>
                                <th style="width: 90px; background-color: #dc3545 !important; color: white; text-align: center;">91-120</th>
                                <th style="width: 90px; background-color: #c82333 !important; color: white; text-align: center;">+120</th>
                                <th style="width: 110px; background-color: #6B8ACE !important; color: white; text-align: center;">Total</th>
                            </tr>
                        </thead>
                        <tbody id="tbodySemaforoCXC">
                            @if(isset($cuentasPorCliente) && count($cuentasPorCliente) > 0)
                                @foreach($cuentasPorCliente as $clienteId => $clienteData)
                                    @php $totalCliente = $clienteData['totales']['total']; @endphp
                                    <!-- FILA DEL CLIENTE (PADRE) -->
                                    <tr class="parent-row" data-cliente="{{ $clienteId }}" style="background-color: #e9ecef; font-weight: bold; cursor: pointer;">
                                        <td style="text-align: center;">
                                            <i class="fas fa-chevron-right toggle-icon" style="color: #083CAE;"></i>
                                        </td>
                                        <td colspan="2">
                                            <i class="fas fa-building"></i> {{ $clienteData['cliente']->razon_social ?? 'SIN CLIENTE' }}
                                            @if(($clienteData['cliente']->rfc ?? 'N/A') && ($clienteData['cliente']->rfc ?? 'N/A') != 'N/A')
                                                <br><small class="text-muted">{{ $clienteData['cliente']->rfc }}</small>
                                            @endif
                                        </td>
                                        <td style="text-align: right; background-color: #d4edda; font-weight: bold;">{{ number_format($clienteData['rangos']['corriente'] ?? 0, 2) }}</td>
                                        <td style="text-align: right; background-color: #fff3cd;">{{ number_format($clienteData['rangos']['1_30'] ?? 0, 2) }}</td>
                                        <td style="text-align: right; background-color: #ffe0b3;">{{ number_format($clienteData['rangos']['31_60'] ?? 0, 2) }}</td>
                                        <td style="text-align: right; background-color: #ffd699; font-weight: bold;">{{ number_format($clienteData['rangos']['61_90'] ?? 0, 2) }}</td>
                                        <td style="text-align: right; background-color: #f8d7da;">{{ number_format($clienteData['rangos']['91_120'] ?? 0, 2) }}</td>
                                        <td style="text-align: right; background-color: #f5c6cb;">{{ number_format($clienteData['rangos']['mas_120'] ?? 0, 2) }}</td>
                                        <td style="text-align: right; font-weight: bold; background-color: #e7f1ff;">{{ number_format($totalCliente, 2) }}</td>
                                    </tr>

                                    <!-- FILAS DE FACTURAS (HIJOS) -->
                                    @foreach($clienteData['facturas'] as $factura)
                                    <tr class="child-row" data-parent="{{ $clienteId }}" style="background-color: #ffffff; display: none;">
                                        <td style="text-align: center;"></td>
                                        <td style="padding-left: 35px;">
                                            <i class="fas fa-file-invoice"></i>
                                            <a href="#" onclick="verDetalleFactura({{ $factura['factura_id'] }}); return false;" style="text-decoration: underline; color: #0000ee; cursor: pointer;">
                                                {{ $factura['folio'] }}
                                            </a>
                                        </td>
                                        <td style="text-align: center;">
                                            @if($factura['fecha_vencimiento'])
                                                {{ $factura['fecha_vencimiento'] }}
                                                <br>
                                                <small class="{{ str_contains($factura['texto_dias'] ?? '', 'Vence') ? 'text-success' : 'text-danger' }}">
                                                    {{ $factura['texto_dias'] ?? 'Sin información' }}
                                                </small>
                                            @else
                                                <span class="text-muted">Sin fecha</span>
                                            @endif
                                        </td>
                                        <td style="text-align: right;">{{ number_format($factura['corriente'], 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($factura['rango_1_30'], 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($factura['rango_31_60'], 2) }}</td>
                                        <td style="text-align: right; font-weight: bold; {{ ($factura['rango_61_90'] ?? 0) > 0 ? 'color: #dc3545;' : '' }}">{{ number_format($factura['rango_61_90'] ?? 0, 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($factura['rango_91_120'] ?? 0, 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($factura['mas_120'] ?? 0, 2) }}</td>
                                        <td style="text-align: right; font-weight: bold;">{{ number_format($factura['saldo_pendiente'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                        No hay cuentas por cobrar pendientes.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
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
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    /* ============================================================
       ESTILOS GENERALES
       ============================================================ */
    .swal2-container { z-index: 99999 !important; }
    .swal2-popup     { z-index: 100000 !important; }
    .swal2-shown     { z-index: 99999 !important; }

    .custom-card {
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    .custom-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(8, 60, 174, 0.15) !important;
    }
    .parent-row { cursor: pointer; }
    .parent-row:hover { background-color: #dee2e6 !important; }
    .toggle-icon {
        transition: transform 0.3s ease;
        display: inline-block;
    }
    .toggle-icon.rotated { transform: rotate(90deg); }
    .table-responsive::-webkit-scrollbar { width: 8px; height: 8px; }
    .table-responsive::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .table-responsive::-webkit-scrollbar-thumb { background: #083CAE; border-radius: 10px; }
    .table-responsive::-webkit-scrollbar-thumb:hover { background: #062a7a; }
    .btn-sm { font-size: 13px; padding: 5px 12px; transition: opacity 0.2s; }
    .btn-sm:hover { opacity: 0.9; }
    .btn-sm:disabled { opacity: 0.6; cursor: not-allowed; }

    /* ============================================================
       ESTILOS DEL MODAL DE DETALLE DE FACTURA
       ============================================================ */
    .factura-modal {
        text-align: left;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    /* Header con folio y estatus */
    .factura-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg, #083CAE 0%, #0d5ce6 100%);
        color: white;
        padding: 16px 20px;
        border-radius: 10px;
        margin-bottom: 18px;
        box-shadow: 0 4px 12px rgba(8, 60, 174, 0.25);
    }
    .factura-header .folio {
        display: flex;
        flex-direction: column;
    }
    .factura-header .folio small {
        font-size: 11px;
        opacity: 0.85;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }
    .factura-header .folio strong {
        font-size: 22px;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .factura-header .estatus-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .estatus-activa  { background-color: #ffc107; color: #000; }
    .estatus-pagada  { background-color: #28a745; color: #fff; }
    .estatus-cancelada { background-color: #dc3545; color: #fff; }

    /* Sección de información del cliente */
    .info-section {
        background-color: #f8f9fa;
        border-left: 4px solid #083CAE;
        border-radius: 6px;
        padding: 14px 16px;
        margin-bottom: 18px;
    }
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        font-size: 13px;
        color: #495057;
        border-bottom: 1px dashed #dee2e6;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row .label {
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
    }
    .info-row .value {
        font-weight: 500;
        color: #212529;
        text-align: right;
    }

    /* Grid de totales */
    .totales-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 16px;
    }
    .total-box {
        padding: 14px 12px;
        border-radius: 8px;
        text-align: center;
        border: 2px solid transparent;
        transition: transform 0.15s ease;
    }
    .total-box:hover { transform: translateY(-2px); }
    .total-box .label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
        opacity: 0.8;
    }
    .total-box .amount {
        font-size: 16px;
        font-weight: 700;
    }
    .total-box.subtotal {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #495057;
    }
    .total-box.iva {
        background-color: #fff3cd;
        border-color: #ffeaa7;
        color: #856404;
    }
    .total-box.total {
        background: linear-gradient(135deg, #083CAE 0%, #0d5ce6 100%);
        color: white;
        box-shadow: 0 4px 10px rgba(8, 60, 174, 0.3);
    }

    /* Grid de pagado / saldo */
    .pagos-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 18px;
    }
    .pago-box {
        padding: 16px;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .pago-box .label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }
    .pago-box .amount {
        font-size: 20px;
        font-weight: 700;
    }
    .pago-box.pagado {
        background-color: #d4edda;
        border-left: 5px solid #28a745;
        color: #155724;
    }
    .pago-box.saldo {
        background-color: #f8d7da;
        border-left: 5px solid #dc3545;
        color: #721c24;
    }
    .pago-box .icon {
        font-size: 28px;
        opacity: 0.7;
    }

    /* Sección historial de pagos */
    .historial-section {
        margin-top: 10px;
    }
    .historial-section h5 {
        font-size: 15px;
        font-weight: 700;
        color: #083CAE;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .historial-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .historial-table thead th {
        background-color: #e9ecef;
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        padding: 10px 12px;
        text-align: left;
        border-bottom: 2px solid #dee2e6;
    }
    .historial-table tbody td {
        padding: 10px 12px;
        border-bottom: 1px solid #f1f3f5;
        color: #495057;
    }
    .historial-table tbody tr:last-child td { border-bottom: none; }
    .historial-table tbody tr:hover { background-color: #f8f9fa; }
    .historial-table .monto {
        text-align: right;
        font-weight: 600;
        color: #28a745;
    }
    .empty-pagos {
        text-align: center;
        padding: 24px 12px;
        color: #6c757d;
        font-size: 13px;
    }
    .empty-pagos i {
        font-size: 28px;
        color: #ced4da;
        margin-bottom: 8px;
        display: block;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const URL_DETALLE_FACTURA = "{{ route('cuentascobrar.factura.detalle', ['facturaId' => '__ID__']) }}";
const URL_ACTUALIZAR      = "{{ route('cuentascobrar.actualizar') }}";

document.addEventListener('DOMContentLoaded', function() {

    // ============================================================
    // Toggle de filas cliente/facturas
    // ============================================================
    function toggleCliente(element) {
        var clienteId = element.getAttribute('data-cliente');
        if (!clienteId) {
            var parentRow = element.closest('.parent-row');
            if (parentRow) clienteId = parentRow.getAttribute('data-cliente');
        }
        if (!clienteId) return;

        var childRows = document.querySelectorAll('.child-row[data-parent="' + clienteId + '"]');
        var parentRow = document.querySelector('.parent-row[data-cliente="' + clienteId + '"]');
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
            toggleCliente(this);
        });
    });

    document.querySelectorAll('.toggle-icon').forEach(function(icon) {
        icon.addEventListener('click', function(e) {
            e.stopPropagation();
            var parentRow = this.closest('.parent-row');
            if (parentRow) toggleCliente(parentRow);
        });
    });

    // ============================================================
    // Filtro por cliente
    // ============================================================
    document.getElementById('contacto_id')?.addEventListener('change', function() {
        var url = new URL(window.location.href);
        if (this.value === '0') {
            url.searchParams.delete('cliente');
        } else {
            url.searchParams.set('cliente', this.value);
        }
        window.location.href = url.toString();
    });

    // ============================================================
    // Botón Actualizar
    // ============================================================
    document.getElementById('buttonActualizar')?.addEventListener('click', async function() {
        const btn = this;
        const originalHtml = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Actualizando...';

        try {
            const cliente = document.getElementById('contacto_id')?.value || 0;
            const url = new URL(URL_ACTUALIZAR, window.location.origin);
            url.searchParams.set('cliente', cliente);
            url.searchParams.set('_t', Date.now());

            const response = await fetch(url.toString(), {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!response.ok) throw new Error('HTTP ' + response.status);
            const data = await response.json();

            if (data.success) {
                const toast = Swal.mixin({
                    toast: true, position: 'top-end', showConfirmButton: false,
                    timer: 1200, timerProgressBar: true
                });
                await toast.fire({ icon: 'success', title: 'Datos actualizados' });
                window.location.reload();
            } else {
                Swal.fire('Error', data.message || 'No se pudo actualizar', 'error');
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            }
        } catch (e) {
            console.error('Error al actualizar:', e);
            Swal.fire('Error de conexión', 'No se pudo contactar al servidor para actualizar.', 'error');
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        }
    });

    // ============================================================
    // Exportar Excel
    // ============================================================
    document.getElementById('buttonExcel')?.addEventListener('click', function() {
        var table = document.getElementById('semaforoCXC').cloneNode(true);
        table.querySelectorAll('.child-row').forEach(function(row) {
            row.style.display = 'table-row';
        });
        var html = table.outerHTML;
        var blob = new Blob(['\ufeff' + html], { type: 'application/vnd.ms-excel;charset=utf-8' });
        var link = document.createElement('a');
        var url = URL.createObjectURL(blob);
        link.href = url;
        link.download = 'CuentasPorCobrar_' + new Date().toISOString().slice(0, 19).replace(/[:T]/g, '-') + '.xls';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    });

    // ============================================================
    // Exportar PDF
    // ============================================================
    document.getElementById('buttonVerPDF')?.addEventListener('click', function() {
        document.querySelectorAll('.child-row').forEach(function(row) {
            row.dataset.prevDisplay = row.style.display;
            row.style.display = 'table-row';
        });
        window.print();
        setTimeout(function() {
            document.querySelectorAll('.child-row').forEach(function(row) {
                row.style.display = row.dataset.prevDisplay || 'none';
            });
        }, 500);
    });
});

// ============================================================
// Helpers de formato
// ============================================================
function fmtMoney(value) {
    const num = Number(value || 0);
    return '$' + num.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function escapeHtml(str) {
    if (str === null || str === undefined) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

// ============================================================
// Ver detalle de factura (MODAL MEJORADO)
// ============================================================
async function verDetalleFactura(facturaId) {
    Swal.fire({
        title: '',
        html: '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-3 text-muted">Cargando detalles...</p></div>',
        width: '820px',
        padding: '0',
        showConfirmButton: false,
        showCancelButton: true,
        cancelButtonText: '<i class="fas fa-times mr-1"></i> Cerrar',
        cancelButtonColor: '#6c757d',
        didOpen: async () => {
            try {
                const url = URL_DETALLE_FACTURA.replace('__ID__', facturaId);
                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const contentType = response.headers.get('content-type') || '';
                if (!contentType.includes('application/json')) {
                    Swal.update({
                        html: '<div class="p-4"><div class="alert alert-danger mb-0"><i class="fas fa-exclamation-triangle"></i> Error en el servidor al obtener el detalle de la factura.<br><small>Verifique la ruta y el log del servidor.</small></div></div>',
                        showConfirmButton: true,
                        confirmButtonText: 'Cerrar',
                        confirmButtonColor: '#6c757d',
                        showCancelButton: false
                    });
                    return;
                }

                const data = await response.json();

                if (!data.success) {
                    Swal.update({
                        html: '<div class="p-4"><div class="alert alert-danger mb-0">' + escapeHtml(data.message || 'Error al cargar los detalles') + '</div></div>',
                        showConfirmButton: true,
                        confirmButtonText: 'Cerrar',
                        confirmButtonColor: '#6c757d',
                        showCancelButton: false
                    });
                    return;
                }

                const f = data.factura || {};
                const total      = Number(f.total || 0);
                const saldo      = Number(data.saldo_pendiente || 0);
                const pagado     = total - saldo;
                const subtotal   = Number(f.subtotal || 0);
                const iva        = Number(f.iva || 0);

                // Estatus
                let estatusClase = 'estatus-activa';
                let estatusTexto = 'Activa';
                if (String(f.estatus) === '2') { estatusClase = 'estatus-pagada'; estatusTexto = 'Pagada'; }
                else if (String(f.estatus) === '0' || String(f.estatus) === '3') { estatusClase = 'estatus-cancelada'; estatusTexto = 'Cancelada'; }

                // Historial de pagos
                const pagos = Array.isArray(data.pagos) ? data.pagos : [];
                const pagosHtml = pagos.length > 0
                    ? `
                        <table class="historial-table">
                            <thead>
                                <tr>
                                    <th>Folio Pago</th>
                                    <th>Fecha</th>
                                    <th style="text-align:right;">Monto</th>
                                    <th>Forma de Pago</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${pagos.map(p => `
                                    <tr>
                                        <td><i class="fas fa-receipt" style="color:#083CAE;margin-right:6px;"></i>${escapeHtml(p.folio || 'N/A')}</td>
                                        <td>${escapeHtml(p.fecha || 'N/A')}</td>
                                        <td class="monto">${fmtMoney(p.monto)}</td>
                                        <td>${escapeHtml(p.forma_pago || 'N/A')}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `
                    : `
                        <div class="empty-pagos">
                            <i class="fas fa-inbox"></i>
                            No hay pagos registrados para esta factura.
                        </div>
                    `;

                const html = `
                    <div class="factura-modal">
                        <!-- HEADER -->
                        <div class="factura-header">
                            <div class="folio">
                                <small>Factura</small>
                                <strong>${escapeHtml(f.folio || 'N/A')}</strong>
                            </div>
                            <span class="estatus-badge ${estatusClase}">${estatusTexto}</span>
                        </div>

                        <div style="padding: 0 20px 20px 20px;">
                            <!-- INFO CLIENTE -->
                            <div class="info-section">
                                <div class="info-row">
                                    <span class="label">Cliente</span>
                                    <span class="value">${escapeHtml(f.cliente || 'N/A')}</span>
                                </div>
                                <div class="info-row">
                                    <span class="label">RFC</span>
                                    <span class="value">${escapeHtml(f.rfc || 'N/A')}</span>
                                </div>
                                <div class="info-row">
                                    <span class="label">Fecha Emisión</span>
                                    <span class="value">${escapeHtml(f.fecha_formateada || 'N/A')}</span>
                                </div>
                                <div class="info-row">
                                    <span class="label">Vencimiento</span>
                                    <span class="value">${escapeHtml(f.fecha_vencimiento_formateada || 'Sin fecha')}</span>
                                </div>
                            </div>

                            <!-- TOTALES -->
                            <div class="totales-grid">
                                <div class="total-box subtotal">
                                    <div class="label">Subtotal</div>
                                    <div class="amount">${fmtMoney(subtotal)}</div>
                                </div>
                                <div class="total-box iva">
                                    <div class="label">IVA</div>
                                    <div class="amount">${fmtMoney(iva)}</div>
                                </div>
                                <div class="total-box total">
                                    <div class="label">Total</div>
                                    <div class="amount">${fmtMoney(total)}</div>
                                </div>
                            </div>

                            <!-- PAGADO / SALDO -->
                            <div class="pagos-grid">
                                <div class="pago-box pagado">
                                    <div>
                                        <div class="label">Total Pagado</div>
                                        <div class="amount">${fmtMoney(pagado)}</div>
                                    </div>
                                    <i class="fas fa-check-circle icon"></i>
                                </div>
                                <div class="pago-box saldo">
                                    <div>
                                        <div class="label">Saldo Pendiente</div>
                                        <div class="amount">${fmtMoney(saldo)}</div>
                                    </div>
                                    <i class="fas fa-exclamation-circle icon"></i>
                                </div>
                            </div>

                            <!-- HISTORIAL -->
                            <div class="historial-section">
                                <h5><i class="fas fa-history"></i> Historial de Pagos</h5>
                                ${pagosHtml}
                            </div>
                        </div>
                    </div>
                `;

                Swal.update({
                    html: html,
                    width: '820px',
                    padding: '0',
                    showConfirmButton: true,
                    confirmButtonText: '<i class="fas fa-times mr-1"></i> Cerrar',
                    confirmButtonColor: '#083CAE',
                    showCancelButton: false
                });

            } catch (error) {
                console.error('Error verDetalleFactura:', error);
                Swal.update({
                    html: '<div class="p-4"><div class="alert alert-danger mb-0"><i class="fas fa-exclamation-triangle"></i> Error de conexión al servidor al obtener el detalle de la factura.</div></div>',
                    showConfirmButton: true,
                    confirmButtonText: 'Cerrar',
                    confirmButtonColor: '#6c757d',
                    showCancelButton: false
                });
            }
        }
    });
}
</script>
@endsection