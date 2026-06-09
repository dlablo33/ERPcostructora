@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 22px;">
                        <i class="fas fa-chart-line"></i> Estados de Flujo de Efectivo
                    </h2>
                    <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                        <select id="anioSelector" class="form-control" style="width: 100px; border-color: #083CAE;">
                            @foreach($aniosDisponibles as $year)
                                <option value="{{ $year }}" {{ $anio == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                        <select id="mesSelector" class="form-control" style="width: 130px; border-color: #083CAE;">
                            @foreach($meses as $num => $nombre)
                                <option value="{{ $num }}" {{ $mes == $num ? 'selected' : '' }}>{{ $nombre }}</option>
                            @endforeach
                        </select>
                        
                        <!-- Selector de proyectos -->
                        <div class="dropdown" style="position: relative;">
                            <button id="btnSeleccionarProyectos" type="button" class="btn" style="background-color: #083CAE; color: white; border: none; padding: 6px 15px; border-radius: 4px;">
                                <i class="fas fa-check-square"></i> Proyectos 
                                <span id="proyectosCount" class="badge" style="background-color: #ffc107; color: #333; margin-left: 5px;">{{ count($proyectosSeleccionados) }}</span>
                            </button>
                            <div id="panelProyectos" class="dropdown-menu" style="display: none; position: absolute; top: 100%; right: 0; background: white; border: 1px solid #dee2e6; border-radius: 8px; width: 380px; max-height: 420px; overflow-y: auto; z-index: 1000; box-shadow: 0 4px 12px rgba(0,0,0,0.15); margin-top: 5px;">
                                <div style="padding: 12px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa;">
                                    <div style="display: flex; gap: 10px;">
                                        <button id="btnSeleccionarTodos" type="button" class="btn btn-sm" style="background-color: #28a745; color: white; border: none; padding: 5px 12px; border-radius: 4px;">
                                            <i class="fas fa-check-double"></i> Todos
                                        </button>
                                        <button id="btnLimpiarSeleccion" type="button" class="btn btn-sm" style="background-color: #6c757d; color: white; border: none; padding: 5px 12px; border-radius: 4px;">
                                            <i class="fas fa-times"></i> Ninguno
                                        </button>
                                    </div>
                                </div>
                                <div id="listaProyectos" style="padding: 10px; max-height: 320px; overflow-y: auto;">
                                    @forelse($proyectos as $proyecto)
                                        <div class="checkbox-item" style="margin-bottom: 8px; padding: 6px; border-radius: 6px;">
                                            <label style="display: flex; align-items: center; cursor: pointer; margin: 0;">
                                                <input type="checkbox" class="proyecto-checkbox" value="{{ $proyecto->id }}" 
                                                    {{ in_array($proyecto->id, $proyectosSeleccionados) ? 'checked' : '' }}
                                                    style="margin-right: 10px;">
                                                <span style="font-size: 12px;">
                                                    <strong>{{ $proyecto->codigo }}</strong> - {{ Str::limit($proyecto->nombre, 40) }}
                                                </span>
                                            </label>
                                        </div>
                                    @empty
                                        <div style="text-align: center; padding: 20px; color: #6c757d;">
                                            <i class="fas fa-info-circle"></i> No hay proyectos registrados
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        
                        <button id="btnFiltrar" class="btn" style="background-color: #083CAE; color: white; border: none; padding: 6px 18px; border-radius: 4px;">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                        <button id="btnExportarExcel" class="btn" style="background-color: #28a745; color: white; border: none; padding: 6px 18px; border-radius: 4px;">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                    </div>
                </div>
                <div class="mt-2" id="proyectosSeleccionadosInfo" style="font-size: 12px; color: #083CAE;">
                    @if(count($proyectosSeleccionados) > 0)
                        <i class="fas fa-check-circle" style="color: #28a745;"></i> 
                        <strong>{{ count($proyectosSeleccionados) }}</strong> proyecto(s) seleccionado(s)
                    @else
                        <i class="fas fa-info-circle"></i> Mostrando TODOS los proyectos
                    @endif
                </div>
            </div>

            <div class="card-body p-4">
                <!-- Resumen de Efectivo -->
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 25px;">
                    <!-- Saldo Inicial -->
                    <div style="background-color: white; border: 2px solid #083CAE; border-radius: 8px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 48px; height: 48px; background-color: #f0f4ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid #083CAE;">
                                <i class="fas fa-coins" style="color: #083CAE; font-size: 24px;"></i>
                            </div>
                            <div>
                                <span style="font-size: 13px; color: #6c757d; font-weight: 400;">Saldo Inicial</span>
                                <div style="font-size: 22px; font-weight: bold; color: #083CAE;" id="resumenInicial">${{ number_format($datosFlujo['saldo_inicial'] ?? 0, 0) }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Flujo Neto -->
                    <div style="background-color: white; border: 2px solid #083CAE; border-radius: 8px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 48px; height: 48px; background-color: #f0f4ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid #083CAE;">
                                <i class="fas fa-arrow-trend-up" style="color: #083CAE; font-size: 24px;"></i>
                            </div>
                            <div>
                                <span style="font-size: 13px; color: #6c757d; font-weight: 400;">Flujo Neto del Período</span>
                                <div style="font-size: 22px; font-weight: bold; color: {{ ($datosFlujo['flujo_neto_total'] ?? 0) >= 0 ? '#28a745' : '#dc3545' }};" id="resumenFlujo">
                                    {{ ($datosFlujo['flujo_neto_total'] ?? 0) >= 0 ? '+' : '' }}${{ number_format(abs($datosFlujo['flujo_neto_total'] ?? 0), 0) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Saldo Final -->
                    <div style="background-color: white; border: 2px solid #083CAE; border-radius: 8px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 48px; height: 48px; background-color: #f0f4ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid #083CAE;">
                                <i class="fas fa-wallet" style="color: #083CAE; font-size: 24px;"></i>
                            </div>
                            <div>
                                <span style="font-size: 13px; color: #6c757d; font-weight: 400;">Saldo Final</span>
                                <div style="font-size: 22px; font-weight: bold; color: #083CAE;" id="resumenFinal">${{ number_format($datosFlujo['saldo_final'] ?? 0, 0) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Flujo de Efectivo -->
                <div style="width: 100%; overflow-x: auto; margin-bottom: 20px; border: 1px solid #dee2e6; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <table class="table table-bordered" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                        <thead style="background-color: #083CAE;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: left; background-color: #083CAE; color: white; width: 300px;">Concepto</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: right; background-color: #083CAE; color: white; width: 150px;">Período Actual</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: right; background-color: #083CAE; color: white; width: 150px;">Período Anterior</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: right; background-color: #083CAE; color: white; width: 150px;">Variación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- ACTIVIDADES DE OPERACIÓN -->
                            <tr style="background-color: #f0f4ff; font-weight: bold;">
                                <td colspan="4" style="border: 1px solid #dee2e6; padding: 12px 15px;">ACTIVIDADES DE OPERACIÓN</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; padding-left: 30px;">Ingresos operativos</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right;">${{ number_format($datosFlujo['operacion']['ingresos'] ?? 0, 0) }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right;">${{ number_format($datosFlujo['operacion']['ingresos_anterior'] ?? 0, 0) }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right; color: {{ (($datosFlujo['operacion']['ingresos'] ?? 0) - ($datosFlujo['operacion']['ingresos_anterior'] ?? 0)) >= 0 ? '#28a745' : '#dc3545' }};">
                                    {{ (($datosFlujo['operacion']['ingresos'] ?? 0) - ($datosFlujo['operacion']['ingresos_anterior'] ?? 0)) >= 0 ? '+' : '' }}${{ number_format(abs(($datosFlujo['operacion']['ingresos'] ?? 0) - ($datosFlujo['operacion']['ingresos_anterior'] ?? 0)), 0) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; padding-left: 30px;">Egresos operativos</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right;">${{ number_format($datosFlujo['operacion']['egresos'] ?? 0, 0) }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right;">${{ number_format($datosFlujo['operacion']['egresos_anterior'] ?? 0, 0) }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right; color: {{ (($datosFlujo['operacion']['egresos'] ?? 0) - ($datosFlujo['operacion']['egresos_anterior'] ?? 0)) >= 0 ? '#dc3545' : '#28a745' }};">
                                    {{ (($datosFlujo['operacion']['egresos'] ?? 0) - ($datosFlujo['operacion']['egresos_anterior'] ?? 0)) >= 0 ? '+' : '' }}${{ number_format(abs(($datosFlujo['operacion']['egresos'] ?? 0) - ($datosFlujo['operacion']['egresos_anterior'] ?? 0)), 0) }}
                                </td>
                            </tr>
                            <tr style="background-color: #f5f5f5; font-weight: bold;">
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; padding-left: 30px;">Flujo neto de operación</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right; color: {{ ($datosFlujo['operacion']['flujo_neto'] ?? 0) >= 0 ? '#28a745' : '#dc3545' }};">
                                    ${{ number_format($datosFlujo['operacion']['flujo_neto'] ?? 0, 0) }}
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right; color: {{ ($datosFlujo['operacion']['flujo_neto_anterior'] ?? 0) >= 0 ? '#28a745' : '#dc3545' }};">
                                    ${{ number_format($datosFlujo['operacion']['flujo_neto_anterior'] ?? 0, 0) }}
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right; color: {{ (($datosFlujo['operacion']['flujo_neto'] ?? 0) - ($datosFlujo['operacion']['flujo_neto_anterior'] ?? 0)) >= 0 ? '#28a745' : '#dc3545' }};">
                                    {{ (($datosFlujo['operacion']['flujo_neto'] ?? 0) - ($datosFlujo['operacion']['flujo_neto_anterior'] ?? 0)) >= 0 ? '+' : '' }}${{ number_format(abs(($datosFlujo['operacion']['flujo_neto'] ?? 0) - ($datosFlujo['operacion']['flujo_neto_anterior'] ?? 0)), 0) }}
                                </td>
                            </tr>
                            
                            <!-- ACTIVIDADES DE INVERSIÓN -->
                            <tr style="background-color: #f0f4ff; font-weight: bold;">
                                <td colspan="4" style="border: 1px solid #dee2e6; padding: 12px 15px;">ACTIVIDADES DE INVERSIÓN</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; padding-left: 30px;">Ingresos por inversión</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right;">${{ number_format($datosFlujo['inversion']['ingresos'] ?? 0, 0) }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right;">${{ number_format($datosFlujo['inversion']['ingresos_anterior'] ?? 0, 0) }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right; color: {{ (($datosFlujo['inversion']['ingresos'] ?? 0) - ($datosFlujo['inversion']['ingresos_anterior'] ?? 0)) >= 0 ? '#28a745' : '#dc3545' }};">
                                    {{ (($datosFlujo['inversion']['ingresos'] ?? 0) - ($datosFlujo['inversion']['ingresos_anterior'] ?? 0)) >= 0 ? '+' : '' }}${{ number_format(abs(($datosFlujo['inversion']['ingresos'] ?? 0) - ($datosFlujo['inversion']['ingresos_anterior'] ?? 0)), 0) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; padding-left: 30px;">Egresos por inversión</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right;">${{ number_format($datosFlujo['inversion']['egresos'] ?? 0, 0) }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right;">${{ number_format($datosFlujo['inversion']['egresos_anterior'] ?? 0, 0) }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right; color: {{ (($datosFlujo['inversion']['egresos'] ?? 0) - ($datosFlujo['inversion']['egresos_anterior'] ?? 0)) >= 0 ? '#dc3545' : '#28a745' }};">
                                    {{ (($datosFlujo['inversion']['egresos'] ?? 0) - ($datosFlujo['inversion']['egresos_anterior'] ?? 0)) >= 0 ? '+' : '' }}${{ number_format(abs(($datosFlujo['inversion']['egresos'] ?? 0) - ($datosFlujo['inversion']['egresos_anterior'] ?? 0)), 0) }}
                                </td>
                            </tr>
                            <tr style="background-color: #f5f5f5; font-weight: bold;">
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; padding-left: 30px;">Flujo neto de inversión</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right; color: {{ ($datosFlujo['inversion']['flujo_neto'] ?? 0) >= 0 ? '#28a745' : '#dc3545' }};">
                                    ${{ number_format($datosFlujo['inversion']['flujo_neto'] ?? 0, 0) }}
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right; color: {{ ($datosFlujo['inversion']['flujo_neto_anterior'] ?? 0) >= 0 ? '#28a745' : '#dc3545' }};">
                                    ${{ number_format($datosFlujo['inversion']['flujo_neto_anterior'] ?? 0, 0) }}
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right; color: {{ (($datosFlujo['inversion']['flujo_neto'] ?? 0) - ($datosFlujo['inversion']['flujo_neto_anterior'] ?? 0)) >= 0 ? '#28a745' : '#dc3545' }};">
                                    {{ (($datosFlujo['inversion']['flujo_neto'] ?? 0) - ($datosFlujo['inversion']['flujo_neto_anterior'] ?? 0)) >= 0 ? '+' : '' }}${{ number_format(abs(($datosFlujo['inversion']['flujo_neto'] ?? 0) - ($datosFlujo['inversion']['flujo_neto_anterior'] ?? 0)), 0) }}
                                </td>
                            </tr>
                            
                            <!-- ACTIVIDADES DE FINANCIAMIENTO -->
                            <tr style="background-color: #f0f4ff; font-weight: bold;">
                                <td colspan="4" style="border: 1px solid #dee2e6; padding: 12px 15px;">ACTIVIDADES DE FINANCIAMIENTO</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; padding-left: 30px;">Ingresos por financiamiento</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right;">${{ number_format($datosFlujo['financiamiento']['ingresos'] ?? 0, 0) }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right;">${{ number_format($datosFlujo['financiamiento']['ingresos_anterior'] ?? 0, 0) }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right; color: {{ (($datosFlujo['financiamiento']['ingresos'] ?? 0) - ($datosFlujo['financiamiento']['ingresos_anterior'] ?? 0)) >= 0 ? '#28a745' : '#dc3545' }};">
                                    {{ (($datosFlujo['financiamiento']['ingresos'] ?? 0) - ($datosFlujo['financiamiento']['ingresos_anterior'] ?? 0)) >= 0 ? '+' : '' }}${{ number_format(abs(($datosFlujo['financiamiento']['ingresos'] ?? 0) - ($datosFlujo['financiamiento']['ingresos_anterior'] ?? 0)), 0) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; padding-left: 30px;">Egresos por financiamiento</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right;">${{ number_format($datosFlujo['financiamiento']['egresos'] ?? 0, 0) }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right;">${{ number_format($datosFlujo['financiamiento']['egresos_anterior'] ?? 0, 0) }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right; color: {{ (($datosFlujo['financiamiento']['egresos'] ?? 0) - ($datosFlujo['financiamiento']['egresos_anterior'] ?? 0)) >= 0 ? '#dc3545' : '#28a745' }};">
                                    {{ (($datosFlujo['financiamiento']['egresos'] ?? 0) - ($datosFlujo['financiamiento']['egresos_anterior'] ?? 0)) >= 0 ? '+' : '' }}${{ number_format(abs(($datosFlujo['financiamiento']['egresos'] ?? 0) - ($datosFlujo['financiamiento']['egresos_anterior'] ?? 0)), 0) }}
                                </td>
                            </tr>
                            <tr style="background-color: #f5f5f5; font-weight: bold;">
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; padding-left: 30px;">Flujo neto de financiamiento</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right; color: {{ ($datosFlujo['financiamiento']['flujo_neto'] ?? 0) >= 0 ? '#28a745' : '#dc3545' }};">
                                    ${{ number_format($datosFlujo['financiamiento']['flujo_neto'] ?? 0, 0) }}
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right; color: {{ ($datosFlujo['financiamiento']['flujo_neto_anterior'] ?? 0) >= 0 ? '#28a745' : '#dc3545' }};">
                                    ${{ number_format($datosFlujo['financiamiento']['flujo_neto_anterior'] ?? 0, 0) }}
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 15px; text-align: right; color: {{ (($datosFlujo['financiamiento']['flujo_neto'] ?? 0) - ($datosFlujo['financiamiento']['flujo_neto_anterior'] ?? 0)) >= 0 ? '#28a745' : '#dc3545' }};">
                                    {{ (($datosFlujo['financiamiento']['flujo_neto'] ?? 0) - ($datosFlujo['financiamiento']['flujo_neto_anterior'] ?? 0)) >= 0 ? '+' : '' }}${{ number_format(abs(($datosFlujo['financiamiento']['flujo_neto'] ?? 0) - ($datosFlujo['financiamiento']['flujo_neto_anterior'] ?? 0)), 0) }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 12px 15px; background-color: #e9ecef;">INCREMENTO/DISMINUCIÓN NETA DE EFECTIVO</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: right; background-color: #e9ecef; color: {{ ($datosFlujo['flujo_neto_total'] ?? 0) >= 0 ? '#28a745' : '#dc3545' }};">
                                    ${{ number_format($datosFlujo['flujo_neto_total'] ?? 0, 0) }}
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: right; background-color: #e9ecef;">${{ number_format($datosFlujo['flujo_neto_total_anterior'] ?? 0, 0) }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: right; background-color: #e9ecef;"></td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 12px 15px; background-color: #e9ecef;">Efectivo al inicio del período</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: right; background-color: #e9ecef;">${{ number_format($datosFlujo['saldo_inicial'] ?? 0, 0) }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: right; background-color: #e9ecef;"></td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: right; background-color: #e9ecef;"></td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 12px 15px; background-color: #e9ecef;">Efectivo al final del período</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: right; background-color: #e9ecef; font-weight: bold; color: #083CAE;">${{ number_format($datosFlujo['saldo_final'] ?? 0, 0) }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: right; background-color: #e9ecef;"></td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: right; background-color: #e9ecef;"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Leyenda -->
                <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 15px; padding: 10px; background-color: #f8f9fa; border-radius: 4px;">
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <div style="width: 12px; height: 12px; background-color: #f0f4ff; border: 1px solid #083CAE; border-radius: 2px;"></div>
                        <span style="font-size: 11px; color: #6c757d;">Sección Principal</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <div style="width: 12px; height: 12px; background-color: #f5f5f5; border: 1px solid #dee2e6; border-radius: 2px;"></div>
                        <span style="font-size: 11px; color: #6c757d;">Subtotal</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <div style="width: 12px; height: 12px; background-color: #e9ecef; border: 1px solid #083CAE; border-radius: 2px;"></div>
                        <span style="font-size: 11px; color: #6c757d;">Totales</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Filtrar
    document.getElementById('btnFiltrar')?.addEventListener('click', function() {
        const anio = document.getElementById('anioSelector').value;
        const mes = document.getElementById('mesSelector').value;
        const checkboxes = document.querySelectorAll('.proyecto-checkbox:checked');
        const proyectos = Array.from(checkboxes).map(cb => cb.value).join(',');
        
        let url = `/conta/flujo?anio=${anio}&mes=${mes}`;
        if (proyectos) {
            url += `&proyectos=${proyectos}`;
        }
        window.location.href = url;
    });
    
    // Exportar Excel
    document.getElementById('btnExportarExcel')?.addEventListener('click', function() {
        const anio = document.getElementById('anioSelector').value;
        const mes = document.getElementById('mesSelector').value;
        const checkboxes = document.querySelectorAll('.proyecto-checkbox:checked');
        const proyectos = Array.from(checkboxes).map(cb => cb.value).join(',');
        
        let url = `/conta/flujo-efectivo/excel?anio=${anio}&mes=${mes}`;
        if (proyectos) {
            url += `&proyectos=${proyectos}`;
        }
        window.location.href = url;
    });
    
    // Panel de proyectos
    const btnSeleccionar = document.getElementById('btnSeleccionarProyectos');
    const panelProyectos = document.getElementById('panelProyectos');
    
    if (btnSeleccionar) {
        btnSeleccionar.addEventListener('click', function(e) {
            e.stopPropagation();
            panelProyectos.style.display = panelProyectos.style.display === 'none' ? 'block' : 'none';
        });
    }
    
    document.addEventListener('click', function(event) {
        if (panelProyectos && btnSeleccionar) {
            if (!panelProyectos.contains(event.target) && !btnSeleccionar.contains(event.target)) {
                panelProyectos.style.display = 'none';
            }
        }
    });
    
    function actualizarContadorProyectos() {
        const checkboxes = document.querySelectorAll('.proyecto-checkbox:checked');
        const count = checkboxes.length;
        const countSpan = document.getElementById('proyectosCount');
        if (countSpan) countSpan.textContent = count;
        
        const infoDiv = document.getElementById('proyectosSeleccionadosInfo');
        if (count > 0) {
            infoDiv.innerHTML = `<i class="fas fa-check-circle" style="color: #28a745;"></i> <strong>${count}</strong> proyecto(s) seleccionado(s)`;
        } else {
            infoDiv.innerHTML = '<i class="fas fa-info-circle"></i> Mostrando TODOS los proyectos';
        }
    }
    
    document.getElementById('btnSeleccionarTodos')?.addEventListener('click', function() {
        document.querySelectorAll('.proyecto-checkbox').forEach(cb => cb.checked = true);
        actualizarContadorProyectos();
        if (panelProyectos) panelProyectos.style.display = 'none';
    });
    
    document.getElementById('btnLimpiarSeleccion')?.addEventListener('click', function() {
        document.querySelectorAll('.proyecto-checkbox').forEach(cb => cb.checked = false);
        actualizarContadorProyectos();
        if (panelProyectos) panelProyectos.style.display = 'none';
    });
    
    document.querySelectorAll('.proyecto-checkbox').forEach(cb => {
        cb.addEventListener('change', actualizarContadorProyectos);
    });
    
    actualizarContadorProyectos();
</script>

<style>
    .table th { background-color: #083CAE !important; color: white; }
    .table td { vertical-align: middle; }
    .checkbox-item:hover { background-color: #e8f0fe; }
    .dropdown-menu { position: absolute; right: 0; left: auto; }
    #btnExportarExcel, #btnFiltrar { transition: all 0.2s ease; }
    #btnExportarExcel:hover, #btnFiltrar:hover { opacity: 0.85; transform: translateY(-1px); }
    @media print { .btn, .dropdown { display: none; } }
</style>
@endsection