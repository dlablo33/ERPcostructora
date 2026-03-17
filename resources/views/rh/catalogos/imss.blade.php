@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Catálogo IMSS -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-shield-alt" style="margin-right: 10px;"></i> Catálogo IMSS - Cuotas y Porcentajes
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Pestañas de navegación -->
                <div style="display: flex; border-bottom: 2px solid #dee2e6; margin-bottom: 20px;">
                    <button class="tab-imss active" onclick="switchIMSTab('cuotas')" id="tabCuotas" style="background-color: var(--color-primary); color: white; border: none; padding: 10px 20px; border-radius: 8px 8px 0 0; margin-right: 5px; cursor: pointer;">
                        <i class="fas fa-percent"></i> Cuotas Obrero-Patronales
                    </button>
                    <button class="tab-imss" onclick="switchIMSTab('cesantia')" id="tabCesantia" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 20px; border-radius: 8px 8px 0 0; margin-right: 5px; cursor: pointer;">
                        <i class="fas fa-chart-line"></i> Cesantía y Vejez (CEAV)
                    </button>
                    <button class="tab-imss" onclick="switchIMSTab('riesgo')" id="tabRiesgo" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 20px; border-radius: 8px 8px 0 0; margin-right: 5px; cursor: pointer;">
                        <i class="fas fa-exclamation-triangle"></i> Riesgos de Trabajo
                    </button>
                    <button class="tab-imss" onclick="switchIMSTab('infonavit')" id="tabInfonavit" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 20px; border-radius: 8px 8px 0 0; cursor: pointer;">
                        <i class="fas fa-home"></i> INFONAVIT
                    </button>
                </div>

                <!-- Panel 1: Cuotas Obrero-Patronales (Porcentajes fijos) -->
                <div id="panelCuotas" style="display: block;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h3 style="color: var(--color-primary); font-size: 18px; margin: 0;">
                            <i class="fas fa-percent"></i> Porcentajes de Cuotas IMSS 2025
                        </h3>
                        <div>
                            <span style="background-color: #ffc107; color: #212529; padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                <i class="fas fa-exclamation-triangle"></i> Verificar actualización anual
                            </span>
                        </div>
                    </div>

                    <!-- Barra de herramientas -->
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                        <div style="display: flex; gap: 10px;">
                            <button style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 13px;">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 13px; color: var(--color-primary);">
                                <i class="fas fa-history"></i> Historial
                            </button>
                        </div>
                        <div style="position: relative; min-width: 250px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary);"></i>
                            <input type="text" placeholder="Buscar concepto..." style="width: 100%; padding: 8px 8px 8px 35px; border: 1px solid #ced4da; border-radius: 4px;">
                        </div>
                    </div>

                    <!-- Tabla de Cuotas IMSS -->
                    <div style="overflow-x: auto; border: 1px solid #dee2e6; border-radius: 8px;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 13px; min-width: 800px;">
                            <thead style="background-color: var(--color-primary); color: white;">
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Concepto</th>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">Base</th>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">% Patrón</th>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">% Obrero</th>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">Tope (SM)</th>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">Vigencia</th>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; font-weight: 500;">Enfermedades y Maternidad - Cuota Fija</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">UMA</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;"><input type="text" value="20.40" style="width: 80px; text-align: right; padding: 5px; border: 1px solid #ced4da; border-radius: 4px;"> %</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;"><input type="text" value="0.00" style="width: 80px; text-align: right; padding: 5px; border: 1px solid #ced4da; border-radius: 4px;" disabled> %</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3 SM</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">2025</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;"></i>
                                        <i class="fas fa-save" style="color: #28a745; margin: 0 5px; cursor: pointer;"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px; border: 1px solid #dee2e6; font-weight: 500;">Enfermedades y Maternidad - Cuota Adicional</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">Diferencia SBC vs 3 UMA</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;"><input type="text" value="1.10" style="width: 80px; text-align: right; padding: 5px; border: 1px solid #ced4da; border-radius: 4px;"> %</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;"><input type="text" value="0.40" style="width: 80px; text-align: right; padding: 5px; border: 1px solid #ced4da; border-radius: 4px;"> %</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">25 UMA</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">2025</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;"></i>
                                        <i class="fas fa-save" style="color: #28a745; margin: 0 5px; cursor: pointer;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; font-weight: 500;">Gastos Médicos Pensionados</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">SBC</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;"><input type="text" value="1.05" style="width: 80px; text-align: right; padding: 5px; border: 1px solid #ced4da; border-radius: 4px;"> %</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;"><input type="text" value="0.375" style="width: 80px; text-align: right; padding: 5px; border: 1px solid #ced4da; border-radius: 4px;"> %</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">25 UMA</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">2025</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;"></i>
                                        <i class="fas fa-save" style="color: #28a745; margin: 0 5px; cursor: pointer;"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px; border: 1px solid #dee2e6; font-weight: 500;">Prestaciones en Dinero</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">SBC</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;"><input type="text" value="0.70" style="width: 80px; text-align: right; padding: 5px; border: 1px solid #ced4da; border-radius: 4px;"> %</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;"><input type="text" value="0.25" style="width: 80px; text-align: right; padding: 5px; border: 1px solid #ced4da; border-radius: 4px;"> %</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">25 UMA</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">2025</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;"></i>
                                        <i class="fas fa-save" style="color: #28a745; margin: 0 5px; cursor: pointer;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; font-weight: 500;">Invalidez y Vida</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">SBC</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;"><input type="text" value="1.75" style="width: 80px; text-align: right; padding: 5px; border: 1px solid #ced4da; border-radius: 4px;"> %</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;"><input type="text" value="0.625" style="width: 80px; text-align: right; padding: 5px; border: 1px solid #ced4da; border-radius: 4px;"> %</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">25 UMA</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">2025</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;"></i>
                                        <i class="fas fa-save" style="color: #28a745; margin: 0 5px; cursor: pointer;"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px; border: 1px solid #dee2e6; font-weight: 500;">Retiro</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">SBC</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;"><input type="text" value="2.00" style="width: 80px; text-align: right; padding: 5px; border: 1px solid #ced4da; border-radius: 4px;"> %</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;"><input type="text" value="0.00" style="width: 80px; text-align: right; padding: 5px; border: 1px solid #ced4da; border-radius: 4px;" disabled> %</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">25 UMA</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">2025</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;"></i>
                                        <i class="fas fa-save" style="color: #28a745; margin: 0 5px; cursor: pointer;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; font-weight: 500;">Guarderías</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">SBC</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;"><input type="text" value="1.00" style="width: 80px; text-align: right; padding: 5px; border: 1px solid #ced4da; border-radius: 4px;"> %</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;"><input type="text" value="0.00" style="width: 80px; text-align: right; padding: 5px; border: 1px solid #ced4da; border-radius: 4px;" disabled> %</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">25 UMA</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">2025</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;"></i>
                                        <i class="fas fa-save" style="color: #28a745; margin: 0 5px; cursor: pointer;"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Nota informativa -->
                    <div style="margin-top: 15px; padding: 10px; background-color: #e7f3ff; border-left: 4px solid var(--color-primary); border-radius: 4px;">
                        <i class="fas fa-info-circle" style="color: var(--color-primary); margin-right: 8px;"></i>
                        <span style="font-size: 12px;">Los porcentajes mostrados corresponden al ejercicio 2025. La cuota fija de enfermedades y maternidad se calcula sobre la UMA, el resto de conceptos sobre el SBC [citation:5][citation:7].</span>
                    </div>
                </div>

                <!-- Panel 2: Cesantía y Vejez (Tabla dinámica) -->
                <div id="panelCesantia" style="display: none;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h3 style="color: var(--color-primary); font-size: 18px; margin: 0;">
                            <i class="fas fa-chart-line"></i> Aportación Patronal CEAV 2023-2030
                        </h3>
                        <div>
                            <span style="background-color: #17a2b8; color: white; padding: 5px 10px; border-radius: 20px; font-size: 12px;">
                                <i class="fas fa-clock"></i> Incremento gradual por rango salarial [citation:5][citation:6]
                            </span>
                        </div>
                    </div>

                    <!-- Barra de herramientas -->
                    <div style="display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap;">
                        <div>
                            <label style="display: block; font-size: 11px; color: #6c757d;">Año</label>
                            <select style="padding: 6px; border: 1px solid #ced4da; border-radius: 4px; min-width: 100px;">
                                <option>2025</option>
                                <option>2024</option>
                                <option>2023</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 11px; color: #6c757d;">Zona</label>
                            <select style="padding: 6px; border: 1px solid #ced4da; border-radius: 4px; min-width: 150px;">
                                <option>Salario Mínimo General (SMG)</option>
                                <option>Zona Fronteriza (SMZF)</option>
                            </select>
                        </div>
                        <div style="display: flex; align-items: flex-end;">
                            <button style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 20px; cursor: pointer;">
                                <i class="fas fa-sync-alt"></i> Actualizar tablas
                            </button>
                        </div>
                    </div>

                    <!-- Tabla CEAV -->
                    <div style="overflow-x: auto; border: 1px solid #dee2e6; border-radius: 8px;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 900px;">
                            <thead style="background-color: var(--color-primary); color: white;">
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6;">Rango Salarial</th>
                                    <th style="padding: 12px; border: 1px solid #dee2e6;">2023</th>
                                    <th style="padding: 12px; border: 1px solid #dee2e6;">2024</th>
                                    <th style="padding: 12px; border: 1px solid #dee2e6;">2025</th>
                                    <th style="padding: 12px; border: 1px solid #dee2e6;">2026</th>
                                    <th style="padding: 12px; border: 1px solid #dee2e6;">2027</th>
                                    <th style="padding: 12px; border: 1px solid #dee2e6;">2028</th>
                                    <th style="padding: 12px; border: 1px solid #dee2e6;">2029</th>
                                    <th style="padding: 12px; border: 1px solid #dee2e6;">2030</th>
                                    <th style="padding: 12px; border: 1px solid #dee2e6;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; font-weight: 500;">1.00 SM</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3.150%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3.150%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3.150%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3.150%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3.150%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3.150%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3.150%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3.150%</td>
                                    <td rowspan="8" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; vertical-align: middle;">
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;"></i>
                                        <i class="fas fa-history" style="color: #6c757d; margin: 0 5px; cursor: pointer;"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px; border: 1px solid #dee2e6;">1.01 SM a 1.50 UMA</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3.281%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3.413%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3.544%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3.676%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3.807%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3.939%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">4.070%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">4.202%</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #dee2e6;">1.51 a 2.00 UMA</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3.575%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">4.000%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">4.426%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">4.851%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">5.276%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">5.701%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">6.126%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">6.552%</td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px; border: 1px solid #dee2e6;">2.01 a 2.50 UMA</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3.751%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">4.353%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">4.954%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">5.556%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">6.157%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">6.759%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">7.360%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">7.962%</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #dee2e6;">2.51 a 3.00 UMA</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3.869%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">4.588%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">5.307%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">6.026%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">6.745%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">7.464%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">8.183%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">8.902%</td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px; border: 1px solid #dee2e6;">3.01 a 3.50 UMA</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">3.953%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">4.756%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">5.559%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">6.361%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">7.164%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">7.967%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">8.770%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">9.573%</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #dee2e6;">3.51 a 4.00 UMA</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">4.016%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">4.882%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">5.747%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">6.613%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">7.479%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">8.345%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">9.211%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">10.077%</td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px; border: 1px solid #dee2e6;">4.01 UMA en adelante</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">4.241%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">5.331%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">6.422%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">7.513%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">8.603%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">9.694%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">10.784%</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">11.875%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p style="margin-top: 10px; font-size: 11px; color: #6c757d; text-align: right;">*Porcentaje total de aportación patronal (Retiro + Cesantía) [citation:6]</p>
                </div>

                <!-- Panel 3: Riesgos de Trabajo (Clases) -->
                <div id="panelRiesgo" style="display: none;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h3 style="color: var(--color-primary); font-size: 18px; margin: 0;">
                            <i class="fas fa-exclamation-triangle"></i> Primas de Riesgo de Trabajo
                        </h3>
                        <div>
                            <button style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 13px;">
                                <i class="fas fa-calculator"></i> Calcular prima según clase
                            </button>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                        <!-- Tabla de clases -->
                        <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                            <div style="background-color: var(--color-primary); color: white; padding: 10px; font-weight: 600;">
                                Clases de Riesgo [citation:5]
                            </div>
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">Clase</th>
                                        <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">Prima Media (%)</th>
                                        <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">I</td><td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">0.54355%</td><td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;"><i class="fas fa-edit" style="color: var(--color-primary); cursor: pointer;"></i></td></tr>
                                    <tr style="background-color: #f8f9fa;"><td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">II</td><td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">1.130658%</td><td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;"><i class="fas fa-edit" style="color: var(--color-primary); cursor: pointer;"></i></td></tr>
                                    <tr><td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">III</td><td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">2.59844%</td><td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;"><i class="fas fa-edit" style="color: var(--color-primary); cursor: pointer;"></i></td></tr>
                                    <tr style="background-color: #f8f9fa;"><td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">IV</td><td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">4.65325%</td><td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;"><i class="fas fa-edit" style="color: var(--color-primary); cursor: pointer;"></i></td></tr>
                                    <tr><td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">V</td><td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">7.58875%</td><td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;"><i class="fas fa-edit" style="color: var(--color-primary); cursor: pointer;"></i></td></tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Configuración de prima de riesgo de la empresa -->
                        <div style="border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <h4 style="margin-top: 0; color: var(--color-primary); font-size: 16px;">Prima de Riesgo de la Empresa</h4>
                            <p style="font-size: 12px; color: #6c757d; margin-bottom: 15px;">Se calcula anualmente según la siniestralidad de la empresa [citation:6].</p>
                            
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Clase asignada por IMSS</label>
                                <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                    <option>Clase I</option>
                                    <option>Clase II</option>
                                    <option>Clase III</option>
                                    <option>Clase IV</option>
                                    <option>Clase V</option>
                                </select>
                            </div>
                            
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Prima de Riesgo actual (%)</label>
                                <input type="text" value="2.59844" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            </div>
                            
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Ejercicio</label>
                                <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                    <option>2025</option>
                                    <option>2024</option>
                                    <option>2023</option>
                                </select>
                            </div>
                            
                            <button style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px; width: 100%; cursor: pointer;">
                                Guardar configuración
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Panel 4: INFONAVIT -->
                <div id="panelInfonavit" style="display: none;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h3 style="color: var(--color-primary); font-size: 18px; margin: 0;">
                            <i class="fas fa-home"></i> Aportaciones INFONAVIT
                        </h3>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div style="border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="margin-top: 0; color: var(--color-primary);">Aportación Patronal</h4>
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Porcentaje fijo [citation:6]</label>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <input type="text" value="5.00" style="width: 100px; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;"> <span>%</span>
                                </div>
                                <p style="font-size: 11px; color: #6c757d; margin-top: 5px;">Se calcula sobre el Salario Base de Cotización (SBC)</p>
                            </div>
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Tope máximo</label>
                                <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                    <option>25 veces la UMA</option>
                                    <option>10 veces la UMA</option>
                                </select>
                            </div>
                        </div>

                        <div style="border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="margin-top: 0; color: var(--color-primary);">Amortización de Créditos</h4>
                            <p style="font-size: 13px;">Factor de descuento según el tipo de crédito y salario del trabajador.</p>
                            <div style="margin-bottom: 10px;">
                                <input type="checkbox" id="creditoVSM" checked> <label for="creditoVSM">Calcular con base en VSM</label>
                            </div>
                            <div style="margin-bottom: 10px;">
                                <input type="checkbox" id="creditoPesos"> <label for="creditoPesos">Calcular con base en pesos</label>
                            </div>
                            <button style="background-color: #28a745; color: white; border: none; border-radius: 4px; padding: 8px; width: 100%; margin-top: 10px; cursor: pointer;">
                                <i class="fas fa-sync-alt"></i> Sincronizar tablas INFONAVIT
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Botón Crear filtro (consistente con otras páginas) -->
                <div style="margin-top: 20px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    :root {
        --color-primary: #083CAE;
        --color-secondary: #2CBF1F;
        --color-accent: #eaf512;
        --color-red: #FF0000;
    }

    .tab-imss {
        transition: all 0.2s;
    }
    
    .tab-imss:hover {
        opacity: 0.9;
    }
    
    .semaforo .card-header h2 {
        color: var(--color-primary) !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        div[style*="grid-template-columns: repeat(2, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        
        div[style*="display: flex; border-bottom: 2px solid #dee2e6"] {
            flex-wrap: wrap;
        }
        
        .tab-imss {
            flex: 1 1 auto;
            margin-bottom: 5px;
            font-size: 12px;
            padding: 8px 10px !important;
        }
    }
</style>

<script>
    function switchIMSTab(tab) {
        // Ocultar todos los paneles
        document.getElementById('panelCuotas').style.display = 'none';
        document.getElementById('panelCesantia').style.display = 'none';
        document.getElementById('panelRiesgo').style.display = 'none';
        document.getElementById('panelInfonavit').style.display = 'none';
        
        // Resetear estilos de pestañas
        document.getElementById('tabCuotas').style.backgroundColor = '#e9ecef';
        document.getElementById('tabCuotas').style.color = '#495057';
        document.getElementById('tabCesantia').style.backgroundColor = '#e9ecef';
        document.getElementById('tabCesantia').style.color = '#495057';
        document.getElementById('tabRiesgo').style.backgroundColor = '#e9ecef';
        document.getElementById('tabRiesgo').style.color = '#495057';
        document.getElementById('tabInfonavit').style.backgroundColor = '#e9ecef';
        document.getElementById('tabInfonavit').style.color = '#495057';
        
        // Mostrar panel seleccionado y activar pestaña
        if (tab === 'cuotas') {
            document.getElementById('panelCuotas').style.display = 'block';
            document.getElementById('tabCuotas').style.backgroundColor = 'var(--color-primary)';
            document.getElementById('tabCuotas').style.color = 'white';
        } else if (tab === 'cesantia') {
            document.getElementById('panelCesantia').style.display = 'block';
            document.getElementById('tabCesantia').style.backgroundColor = 'var(--color-primary)';
            document.getElementById('tabCesantia').style.color = 'white';
        } else if (tab === 'riesgo') {
            document.getElementById('panelRiesgo').style.display = 'block';
            document.getElementById('tabRiesgo').style.backgroundColor = 'var(--color-primary)';
            document.getElementById('tabRiesgo').style.color = 'white';
        } else if (tab === 'infonavit') {
            document.getElementById('panelInfonavit').style.display = 'block';
            document.getElementById('tabInfonavit').style.backgroundColor = 'var(--color-primary)';
            document.getElementById('tabInfonavit').style.color = 'white';
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Botón crear filtro
        document.getElementById('btnCrearFiltro')?.addEventListener('click', function() {
            alert('Funcionalidad de filtro en desarrollo');
        });
    });
</script>
@endsection