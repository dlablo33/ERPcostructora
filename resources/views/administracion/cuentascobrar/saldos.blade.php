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
                        <tbody>
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
                                            <a href="#" onclick="verDetalleFactura({{ $factura['factura_id'] }})" style="text-decoration: underline; color: #0000ee; cursor: pointer;">
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
                                <tr class="parent-row" data-cliente="1" style="background-color: #e9ecef; font-weight: bold; cursor: pointer;">
                                    <td style="text-align: center;"><i class="fas fa-chevron-right toggle-icon" style="color: #083CAE;"></i></td>
                                    <td colspan="2">
                                        <i class="fas fa-building"></i> CARTONES DEL NORTE SAPI DE CV
                                        <br><small class="text-muted">CND890202XYZ</small>
                                    </td>
                                    <td style="text-align: right; background-color: #d4edda; font-weight: bold;">$128,760.00</td>
                                    <td style="text-align: right; background-color: #fff3cd;">$0.00</td>
                                    <td style="text-align: right; background-color: #ffe0b3;">$0.00</td>
                                    <td style="text-align: right; background-color: #ffd699; font-weight: bold;">$27,839,000.00</td>
                                    <td style="text-align: right; background-color: #f8d7da;">$0.00</td>
                                    <td style="text-align: right; background-color: #f5c6cb;">$0.00</td>
                                    <td style="text-align: right; font-weight: bold; background-color: #e7f1ff;">$27,967,760.00</td>
                                </tr>
                                <tr class="child-row" data-parent="1" style="background-color: #ffffff; display: none;">
                                    <td style="text-align: center;"></td>
                                    <td style="padding-left: 35px;">
                                        <i class="fas fa-file-invoice"></i> 
                                        <a href="#" onclick="verDetalleFactura(1)" style="text-decoration: underline; color: #0000ee; cursor: pointer;">FACT-001</a>
                                    </td>
                                    <td style="text-align: center;">2023-01-15<br><small class="text-danger">Vence hoy</small></td>
                                    <td style="text-align: right;">$128,760.00</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right; font-weight: bold; color: #dc3545;">$27,839,000.00</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right; font-weight: bold;">$27,967,760.00</td>
                                </tr>
                                <tr class="parent-row" data-cliente="2" style="background-color: #e9ecef; font-weight: bold; cursor: pointer;">
                                    <td style="text-align: center;"><i class="fas fa-chevron-right toggle-icon" style="color: #083CAE;"></i></td>
                                    <td colspan="2">
                                        <i class="fas fa-building"></i> LOGISTICA MONTERREY SA DE CV
                                        <br><small class="text-muted">LMN890456ABC</small>
                                    </td>
                                    <td style="text-align: right; background-color: #d4edda; font-weight: bold;">$176.84</td>
                                    <td style="text-align: right; background-color: #fff3cd;">$0.00</td>
                                    <td style="text-align: right; background-color: #ffe0b3;">$0.00</td>
                                    <td style="text-align: right; background-color: #ffd699; font-weight: bold;">$0.00</td>
                                    <td style="text-align: right; background-color: #f8d7da;">$0.00</td>
                                    <td style="text-align: right; background-color: #f5c6cb;">$0.00</td>
                                    <td style="text-align: right; font-weight: bold; background-color: #e7f1ff;">$176.84</td>
                                </tr>
                                <tr class="child-row" data-parent="2" style="background-color: #ffffff; display: none;">
                                    <td style="text-align: center;"></td>
                                    <td style="padding-left: 35px;">
                                        <i class="fas fa-file-invoice"></i> 
                                        <a href="#" onclick="verDetalleFactura(2)" style="text-decoration: underline; color: #0000ee; cursor: pointer;">FACT-002</a>
                                    </td>
                                    <td style="text-align: center;">2023-02-20<br><small class="text-success">A 30 días</small></td>
                                    <td style="text-align: right;">$176.84</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right; font-weight: bold;">$176.84</td>
                                </tr>
                                <tr class="parent-row" data-cliente="3" style="background-color: #e9ecef; font-weight: bold; cursor: pointer;">
                                    <td style="text-align: center;"><i class="fas fa-chevron-right toggle-icon" style="color: #083CAE;"></i></td>
                                    <td colspan="2">
                                        <i class="fas fa-building"></i> COMERCIALIZADORA DEL SUR SA
                                        <br><small class="text-muted">CDS890123DEF</small>
                                    </td>
                                    <td style="text-align: right; background-color: #d4edda; font-weight: bold;">$116,000.00</td>
                                    <td style="text-align: right; background-color: #fff3cd;">$0.00</td>
                                    <td style="text-align: right; background-color: #ffe0b3;">$0.00</td>
                                    <td style="text-align: right; background-color: #ffd699; font-weight: bold;">$0.00</td>
                                    <td style="text-align: right; background-color: #f8d7da;">$0.00</td>
                                    <td style="text-align: right; background-color: #f5c6cb;">$0.00</td>
                                    <td style="text-align: right; font-weight: bold; background-color: #e7f1ff;">$116,000.00</td>
                                </tr>
                                <tr class="child-row" data-parent="3" style="background-color: #ffffff; display: none;">
                                    <td style="text-align: center;"></td>
                                    <td style="padding-left: 35px;">
                                        <i class="fas fa-file-invoice"></i> 
                                        <a href="#" onclick="verDetalleFactura(3)" style="text-decoration: underline; color: #0000ee; cursor: pointer;">FACT-003</a>
                                    </td>
                                    <td style="text-align: center;">2023-03-10<br><small class="text-success">A 45 días</small></td>
                                    <td style="text-align: right;">$116,000.00</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right; font-weight: bold;">$116,000.00</td>
                                </tr>
                                <tr class="parent-row" data-cliente="4" style="background-color: #e9ecef; font-weight: bold; cursor: pointer;">
                                    <td style="text-align: center;"><i class="fas fa-chevron-right toggle-icon" style="color: #083CAE;"></i></td>
                                    <td colspan="2">
                                        <i class="fas fa-building"></i> CLIENTE VARIOS
                                        <br><small class="text-muted">VARIOS</small>
                                    </td>
                                    <td style="text-align: right; background-color: #d4edda; font-weight: bold;">$4,290.84</td>
                                    <td style="text-align: right; background-color: #fff3cd;">$0.00</td>
                                    <td style="text-align: right; background-color: #ffe0b3;">$0.00</td>
                                    <td style="text-align: right; background-color: #ffd699; font-weight: bold;">$0.00</td>
                                    <td style="text-align: right; background-color: #f8d7da;">$0.00</td>
                                    <td style="text-align: right; background-color: #f5c6cb;">$0.00</td>
                                    <td style="text-align: right; font-weight: bold; background-color: #e7f1ff;">$4,290.84</td>
                                </tr>
                                <tr class="child-row" data-parent="4" style="background-color: #ffffff; display: none;">
                                    <td style="text-align: center;"></td>
                                    <td style="padding-left: 35px;">
                                        <i class="fas fa-file-invoice"></i> 
                                        <a href="#" onclick="verDetalleFactura(4)" style="text-decoration: underline; color: #0000ee; cursor: pointer;">FACT-004</a>
                                    </td>
                                    <td style="text-align: center;">2023-04-05<br><small class="text-success">A 15 días</small></td>
                                    <td style="text-align: right;">$4,290.84</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right;">$0.00</td>
                                    <td style="text-align: right; font-weight: bold;">$4,290.84</td>
                                </tr>
                            @endif
                        </tbody>
                        @if(isset($cuentasPorCliente) && count($cuentasPorCliente) > 0)
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
                        @else
                        <tfoot style="background-color: #e9ecef; font-weight: bold; border-top: 2px solid #083CAE;">
                            <tr>
                                <td colspan="3" style="text-align: right; font-size: 13px;">TOTAL GENERAL:</td>
                                <td style="text-align: right; background-color: #d4edda;">$249,227.68</td>
                                <td style="text-align: right; background-color: #fff3cd;">$0.00</td>
                                <td style="text-align: right; background-color: #ffe0b3;">$0.00</td>
                                <td style="text-align: right; background-color: #ffd699; font-weight: bold;">$27,839,000.00</td>
                                <td style="text-align: right; background-color: #f8d7da;">$0.00</td>
                                <td style="text-align: right; background-color: #f5c6cb;">$0.00</td>
                                <td style="text-align: right; background-color: #e7f1ff; font-weight: bold;">$28,088,227.68</td>
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
    /* ESTILOS PARA CORREGIR EL Z-INDEX DEL POPUP */
    .swal2-container {
        z-index: 99999 !important;
    }
    
    .swal2-popup {
        z-index: 100000 !important;
    }
    
    /* Asegurar que SweetAlert2 esté por encima de todo */
    .swal2-shown {
        z-index: 99999 !important;
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
    
    document.getElementById('contacto_id')?.addEventListener('change', function() {
        var url = new URL(window.location.href);
        if (this.value === '0') {
            url.searchParams.delete('cliente');
        } else {
            url.searchParams.set('cliente', this.value);
        }
        window.location.href = url.toString();
    });
    
    document.getElementById('buttonExcel')?.addEventListener('click', function() {
        var table = document.getElementById('semaforoCXC').cloneNode(true);
        table.querySelectorAll('.child-row').forEach(function(row) {
            row.style.display = 'table-row';
        });
        var html = table.outerHTML;
        var blob = new Blob([html], { type: 'application/vnd.ms-excel' });
        var link = document.createElement('a');
        var url = URL.createObjectURL(blob);
        link.href = url;
        link.download = 'CuentasPorCobrar_' + new Date().toISOString().slice(0,19) + '.xls';
        link.click();
        URL.revokeObjectURL(url);
    });
    
    document.getElementById('buttonVerPDF')?.addEventListener('click', function() {
        window.print();
    });
});

// Función original para ver detalle de factura - conservando tu lógica original
async function verDetalleFactura(facturaId) {
    Swal.fire({
        title: 'Detalle de Factura',
        html: '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Cargando detalles...</p></div>',
        width: '800px',
        showConfirmButton: false,
        showCancelButton: true,
        cancelButtonText: 'Cerrar',
        didOpen: async () => {
            try {
                // Usando tu endpoint original
                const response = await fetch('/administracion/cuentascobrar/factura/' + facturaId + '/detalle');
                const data = await response.json();
                
                if (data.success) {
                    Swal.update({
                        html: `
                            <div class="row">
                                <div class="col-md-6 text-start">
                                    <p><strong>Factura:</strong> ${data.factura.folio}</p>
                                    <p><strong>Fecha Emisión:</strong> ${data.factura.fecha_formateada || 'N/A'}</p>
                                </div>
                                <div class="col-md-6 text-start">
                                    <p><strong>Vencimiento:</strong> ${data.factura.fecha_vencimiento_formateada || 'Sin fecha'}</p>
                                    <p><strong>Estatus:</strong> ${data.factura.estatus == 2 ? 'Pagada' : 'Activa'}</p>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 text-start">
                                    <p><strong>Cliente:</strong> ${data.factura.cliente || 'N/A'}</p>
                                    <p><strong>RFC:</strong> ${data.factura.rfc || 'N/A'}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4 text-start">
                                    <div class="alert alert-secondary mb-0">
                                        <small>Subtotal</small><br>
                                        <strong>$${Number(data.factura.subtotal || 0).toLocaleString()}</strong>
                                    </div>
                                </div>
                                <div class="col-md-4 text-start">
                                    <div class="alert alert-secondary mb-0">
                                        <small>IVA</small><br>
                                        <strong>$${Number(data.factura.iva || 0).toLocaleString()}</strong>
                                    </div>
                                </div>
                                <div class="col-md-4 text-start">
                                    <div class="alert alert-primary mb-0">
                                        <small>TOTAL</small><br>
                                        <strong>$${Number(data.factura.total || 0).toLocaleString()}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="alert alert-warning mb-0">
                                        <small>Total Pagado</small><br>
                                        <strong>$${Number((data.factura.total || 0) - (data.saldo_pendiente || 0)).toLocaleString()}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="alert alert-danger mb-0">
                                        <small>SALDO PENDIENTE</small><br>
                                        <strong>$${Number(data.saldo_pendiente || 0).toLocaleString()}</strong>
                                    </div>
                                </div>
                            </div>
                            <h5 class="mt-4">Historial de Pagos</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Folio Pago</th>
                                            <th>Fecha</th>
                                            <th>Monto</th>
                                            <th>Forma de Pago</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${data.pagos && data.pagos.length > 0 ? data.pagos.map(p => `
                                            <tr>
                                                <td>${p.folio || 'N/A'}</td>
                                                <td>${p.fecha || 'N/A'}</td>
                                                <td class="text-end">$${Number(p.monto).toLocaleString()}</td>
                                                <td>${p.forma_pago || 'N/A'}</td>
                                            </tr>
                                        `).join('') : '<tr><td colspan="4" class="text-center">No hay pagos registrados</td></tr>'}
                                    </tbody>
                                </table>
                            </div>
                        `,
                        showConfirmButton: true,
                        confirmButtonText: 'Cerrar'
                    });
                } else {
                    Swal.update({
                        html: '<div class="alert alert-danger">Error al cargar los detalles de la factura</div>',
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