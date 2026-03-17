@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Finiquitos y Liquidaciones -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-file-signature" style="margin-right: 10px;"></i> Finiquitos y Liquidaciones
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- KPIs - Indicadores -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px; width: 100%;">
                    <!-- Total Procesos -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #2378e1; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Total Procesos</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">24</div>
                    </div>

                    <!-- Pendientes -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #ffc107; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #212529; margin-bottom: 3px;">Pendientes</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: #212529;">8</div>
                    </div>

                    <!-- Autorizados -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #28a745; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Autorizados</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">12</div>
                    </div>

                    <!-- Pagados -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #17a2b8; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Pagados</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">4</div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Grupo de agrupación -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <!-- Botones -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <!-- Botón Agregar (+) -->
                        <div>
                            <button id="btnAgregar" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                    title="Nuevo finiquito/liquidación"
                                    onclick="abrirModalFiniquito()">
                                <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Excel</span>
                            </button>
                        </div>

                        <!-- Botón Seleccionar Columnas -->
                        <div style="position: relative;">
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                    onclick="toggleColumnSelector()">
                                <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Columnas</span>
                            </button>
                            
                            <!-- Selector de columnas -->
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 300px; max-height: 400px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative; min-width: 220px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar por empleado, RFC, folio..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Finiquitos y Liquidaciones -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaFiniquitos" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1400px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="folio">Folio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="empleado">Empleado</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="rfc">RFC</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="tipo">Tipo</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_baja">Fecha Baja</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="antiguedad">Antigüedad</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="dias_vacaciones">Días Vac.</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="prima_vacacional">Prima Vac.</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="aguinaldo">Aguinaldo</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="indemnizacion">Indemnización</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="total">Total</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">FQ-2025-001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JUAN CARLOS PÉREZ LÓPEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">PELJ850101</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #6f42c1; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Finiquito</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">3 años 2 meses</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">12</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$2,500.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$3,200.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$5,700.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; min-width: 80px;">Pendiente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="abrirModalDetalle('FQ-2025-001')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar FQ-2025-001')" title="Editar"></i>
                                    <i class="fas fa-check-circle" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="alert('Autorizar FQ-2025-001')" title="Autorizar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF FQ-2025-001')" title="Generar PDF"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">FQ-2025-002</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">MARÍA FERNANDA RAMOS GARCÍA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">ROGM900101</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #fd7e14; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Liquidación</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">28/02/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">5 años 7 meses</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">18</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$3,800.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$4,500.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$45,000.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$53,300.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; min-width: 80px;">Autorizado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="abrirModalDetalle('FQ-2025-002')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar FQ-2025-002')" title="Editar"></i>
                                    <i class="fas fa-money-bill-wave" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="alert('Registrar pago FQ-2025-002')" title="Registrar pago"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF FQ-2025-002')" title="Generar PDF"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">FQ-2025-003</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">CARLOS ALBERTO MENDOZA SÁNCHEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">MESC880315</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #6f42c1; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Finiquito</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">10/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">2 años 1 mes</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">8</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$1,900.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$2,100.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$4,000.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; min-width: 80px;">Pagado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="abrirModalDetalle('FQ-2025-003')" title="Ver detalle"></i>
                                    <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Imprimir recibo FQ-2025-003')" title="Imprimir recibo"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF FQ-2025-003')" title="Generar PDF"></i>
                                    <i class="fas fa-envelope" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Enviar por correo FQ-2025-003')" title="Enviar por correo"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">FQ-2025-004</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ANA SOFÍA MARTÍNEZ FLORES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">MAFA920101</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #6f42c1; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Finiquito</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">05/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">1 año 8 meses</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">6</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$1,200.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$1,500.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$2,700.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; min-width: 80px;">Pendiente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="abrirModalDetalle('FQ-2025-004')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar FQ-2025-004')" title="Editar"></i>
                                    <i class="fas fa-check-circle" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="alert('Autorizar FQ-2025-004')" title="Autorizar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Cancelar proceso?')) alert('Proceso cancelado')" title="Cancelar"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">FQ-2025-005</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ROBERTO ANTONIO SÁNCHEZ TORRES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">SATR880220</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #fd7e14; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Liquidación</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">20/02/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">4 años 3 meses</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">14</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$2,900.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$3,200.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$32,000.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$38,100.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; min-width: 80px;">Autorizado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="abrirModalDetalle('FQ-2025-005')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar FQ-2025-005')" title="Editar"></i>
                                    <i class="fas fa-money-bill-wave" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="alert('Registrar pago FQ-2025-005')" title="Registrar pago"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF FQ-2025-005')" title="Generar PDF"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">FQ-2025-006</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">LAURA PATRICIA FLORES GONZÁLEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">FOGL850101</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #6f42c1; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Finiquito</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/01/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">2 años 5 meses</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">10</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$2,100.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$2,300.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$4,400.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; min-width: 80px;">Pagado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="abrirModalDetalle('FQ-2025-006')" title="Ver detalle"></i>
                                    <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Imprimir recibo FQ-2025-006')" title="Imprimir recibo"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF FQ-2025-006')" title="Generar PDF"></i>
                                    <i class="fas fa-envelope" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Enviar por correo FQ-2025-006')" title="Enviar por correo"></i>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="4" style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right;">Totales:</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: center; background-color: #e9ecef;">-</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: center; background-color: #e9ecef;">-</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: center; background-color: #e9ecef;">68</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right; background-color: #e9ecef;">$14,400.00</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right; background-color: #e9ecef;">$16,800.00</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right; background-color: #e9ecef;">$77,000.00</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right; background-color: #e9ecef; font-weight: bold;">$108,200.00</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: center; background-color: #e9ecef;">6 procesos</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #e9ecef; box-shadow: -2px 0 5px rgba(0,0,0,0.1);"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Crear filtro -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter" style="font-size: 12px;"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA NUEVO FINIQUITO/LIQUIDACIÓN -->
<div id="modalFiniquito" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 900px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Nuevo Finiquito / Liquidación</h3>
            <button onclick="cerrarModalFiniquito()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Folio</label>
                    <input type="text" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="FQ-2025-007">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Tipo</label>
                    <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar tipo</option>
                        <option value="finiquito">Finiquito</option>
                        <option value="liquidacion">Liquidación</option>
                    </select>
                </div>
                
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Empleado</label>
                    <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar empleado</option>
                        <option>JUAN CARLOS PÉREZ LÓPEZ</option>
                        <option>MARÍA FERNANDA RAMOS GARCÍA</option>
                        <option>CARLOS ALBERTO MENDOZA SÁNCHEZ</option>
                        <option>ANA SOFÍA MARTÍNEZ FLORES</option>
                        <option>ROBERTO ANTONIO SÁNCHEZ TORRES</option>
                        <option>LAURA PATRICIA FLORES GONZÁLEZ</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha de Baja</label>
                    <input type="date" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha de Ingreso</label>
                    <input type="date" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Salario Diario</label>
                    <input type="number" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="250.00">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Salario Diario Integrado</label>
                    <input type="number" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="275.00">
                </div>
            </div>
            
            <h4 style="color: var(--color-primary); margin: 20px 0 15px; font-size: 15px; border-bottom: 1px solid #dee2e6; padding-bottom: 5px;">Conceptos a Liquidar</h4>
            
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Días de Vacaciones</label>
                    <input type="number" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="12" id="diasVacaciones" onchange="calcularFiniquito()">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Prima Vacacional (%)</label>
                    <input type="number" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="25" id="primaPorcentaje" onchange="calcularFiniquito()">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Prima Vacacional ($)</label>
                    <input type="number" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" id="primaVacacional" readonly>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Días de Aguinaldo</label>
                    <input type="number" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="15" id="diasAguinaldo" onchange="calcularFiniquito()">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Aguinaldo Proporcional ($)</label>
                    <input type="number" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" id="aguinaldo" readonly>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Indemnización ($)</label>
                    <input type="number" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" id="indemnizacion" placeholder="0.00">
                </div>
            </div>
            
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 4px; margin-top: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 16px; font-weight: bold;">TOTAL ESTIMADO:</span>
                    <span style="font-size: 24px; font-weight: bold; color: var(--color-primary);" id="totalEstimado">$0.00</span>
                </div>
            </div>
            
            <div style="margin-top: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Observaciones</label>
                <textarea rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Motivo de baja, observaciones..."></textarea>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalFiniquito()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="alert('Finiquito/Liquidación guardado')" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA DETALLE DE FINIQUITO -->
<div id="modalDetalleFiniquito" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 800px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Detalle de Finiquito - <span id="detalleFolio">FQ-2025-001</span></h3>
            <button onclick="cerrarModalDetalle()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Contenido -->
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                <div>
                    <h4 style="font-size: 14px; font-weight: bold; color: var(--color-primary); margin: 0 0 10px 0;">Datos del Empleado</h4>
                    <table style="width: 100%; font-size: 12px;">
                        <tr><td style="padding: 4px 0; color: #6c757d;">Nombre:</td><td style="padding: 4px 0; font-weight: 500;" id="detalleNombre">JUAN CARLOS PÉREZ LÓPEZ</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">RFC:</td><td style="padding: 4px 0;" id="detalleRfc">PELJ850101</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Fecha Ingreso:</td><td style="padding: 4px 0;" id="detalleFechaIngreso">15/01/2022</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Fecha Baja:</td><td style="padding: 4px 0;" id="detalleFechaBaja">15/03/2025</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Antigüedad:</td><td style="padding: 4px 0;" id="detalleAntiguedad">3 años 2 meses</td></tr>
                    </table>
                </div>
                <div>
                    <h4 style="font-size: 14px; font-weight: bold; color: var(--color-primary); margin: 0 0 10px 0;">Información del Proceso</h4>
                    <table style="width: 100%; font-size: 12px;">
                        <tr><td style="padding: 4px 0; color: #6c757d;">Tipo:</td><td style="padding: 4px 0;" id="detalleTipo">Finiquito</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Estatus:</td><td style="padding: 4px 0;" id="detalleEstatus">Pendiente</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Fecha Creación:</td><td style="padding: 4px 0;" id="detalleFechaCreacion">10/03/2025</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Última Actualización:</td><td style="padding: 4px 0;" id="detalleActualizacion">10/03/2025</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Usuario:</td><td style="padding: 4px 0;" id="detalleUsuario">ADMIN</td></tr>
                    </table>
                </div>
            </div>
            
            <h4 style="font-size: 14px; font-weight: bold; color: var(--color-primary); margin: 0 0 10px 0;">Cálculo de Finiquito</h4>
            <table style="width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 20px;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6;">Concepto</th>
                        <th style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">Días</th>
                        <th style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">Factor</th>
                        <th style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td style="padding: 8px; border: 1px solid #dee2e6;">Vacaciones</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">12</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">$250.00</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;" id="detalleVacaciones">$3,000.00</td></tr>
                    <tr><td style="padding: 8px; border: 1px solid #dee2e6;">Prima Vacacional (25%)</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">-</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">25%</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;" id="detallePrima">$2,500.00</td></tr>
                    <tr><td style="padding: 8px; border: 1px solid #dee2e6;">Aguinaldo (proporcional)</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">15</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">$250.00</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;" id="detalleAguinaldo">$3,200.00</td></tr>
                    <tr><td style="padding: 8px; border: 1px solid #dee2e6;">Indemnización</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">-</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">-</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;" id="detalleIndemnizacion">$0.00</td></tr>
                    <tr style="background-color: #f8f9fa; font-weight: bold;">
                        <td style="padding: 8px; border: 1px solid #dee2e6;" colspan="3">TOTAL</td>
                        <td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;" id="detalleTotal">$8,700.00</td>
                    </tr>
                </tbody>
            </table>
            
            <div style="margin-bottom: 15px;">
                <h4 style="font-size: 14px; font-weight: bold; color: var(--color-primary); margin: 0 0 5px 0;">Observaciones</h4>
                <p style="margin: 0; font-size: 12px; padding: 10px; background-color: #f8f9fa; border-radius: 4px;" id="detalleObservaciones">
                    Terminación de contrato por renuncia voluntaria. Todo en orden.
                </p>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button onclick="cerrarModalDetalle()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cerrar</button>
                <button onclick="alert('Generando PDF')" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --color-primary: #083CAE;
        --color-secondary: #2CBF1F;
        --color-accent: #eaf512;
        --color-red: #FF0000;
    }

    /* Estilos generales */
    .semaforo .card-header h2 {
        color: var(--color-primary) !important;
    }
    
    /* Tabla */
    .table-container {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        overflow-x: auto;
        background-color: white;
        width: 100%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        min-width: 1400px;
    }

    .table th {
        background-color: var(--color-primary) !important;
        color: white;
        padding: 12px 8px;
        border: 1px solid #dee2e6;
        font-size: 12px;
        white-space: nowrap;
        text-align: center;
        font-weight: 600;
    }
    
    .table td {
        padding: 10px 8px;
        border: 1px solid #dee2e6;
        font-size: 12px;
        vertical-align: middle;
    }
    
    /* Alineaciones específicas */
    .table td:nth-child(1),
    .table td:nth-child(2),
    .table td:nth-child(3),
    .table td:nth-child(4),
    .table td:nth-child(5),
    .table td:nth-child(6),
    .table td:nth-child(7),
    .table td:nth-child(12) {
        text-align: center;
    }
    
    .table td:nth-child(8),
    .table td:nth-child(9),
    .table td:nth-child(10),
    .table td:nth-child(11) {
        text-align: right;
    }
    
    /* Filas alternadas */
    tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    tbody tr:hover {
        background-color: #e8f0fe;
    }
    
    /* Columna de acciones fija */
    .table th:last-child,
    .table td:last-child {
        position: sticky !important;
        right: 0 !important;
        z-index: 35 !important;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1) !important;
    }
    
    .table th:last-child {
        background-color: var(--color-primary) !important;
    }
    
    .table td:last-child {
        background-color: white !important;
        text-align: center !important;
    }
    
    tbody tr:nth-child(even) td:last-child {
        background-color: #f8f9fa !important;
    }
    
    tbody tr:hover td:last-child {
        background-color: #e8f0fe !important;
    }
    
    /* Iconos de acción */
    .table td:last-child i {
        margin: 0 5px;
        font-size: 14px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .table td:last-child i:hover {
        transform: scale(1.2);
    }
    
    /* Badges de tipo */
    .badge-finiquito {
        background-color: #6f42c1;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-liquidacion {
        background-color: #fd7e14;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    /* Badges de estatus */
    .badge-pendiente {
        background-color: #ffc107;
        color: #212529;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 80px;
        text-align: center;
    }
    
    .badge-autorizado {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 80px;
        text-align: center;
    }
    
    .badge-pagado {
        background-color: #17a2b8;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 80px;
        text-align: center;
    }
    
    /* Drag & drop */
    [draggable="true"] {
        cursor: grab;
    }
    
    .columna-agrupada {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        background-color: #e8f0fe;
        border-radius: 4px;
        color: var(--color-primary);
        font-size: 11px;
        border: 1px solid var(--color-primary);
    }
    
    .columna-agrupada .remover {
        margin-left: 5px;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
        color: var(--color-primary);
    }
    
    /* Modal */
    #modalFiniquito,
    #modalDetalleFiniquito {
        display: none;
        align-items: center;
        justify-content: center;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .hide-mobile {
            display: none !important;
        }
        
        div[style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        .table-container {
            max-height: 500px;
        }
        
        .table td {
            padding: 8px 4px;
            font-size: 11px;
        }
        
        .table td:last-child i {
            margin: 0 3px;
            font-size: 12px;
        }
        
        #modalFiniquito > div,
        #modalDetalleFiniquito > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        #modalFiniquito div[style*="grid-template-columns: repeat(3, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadas = [];
    
    // Actualizar grupo de columnas
    function actualizarGrupoColumnas() {
        const container = document.getElementById('grupoColumnas');
        const texto = document.getElementById('textoAgrupar');
        
        container.innerHTML = '';
        
        if (columnasAgrupadas.length === 0) {
            texto.style.display = 'inline';
        } else {
            texto.style.display = 'none';
            columnasAgrupadas.forEach(col => {
                const chip = document.createElement('span');
                chip.className = 'columna-agrupada';
                chip.innerHTML = `${col} <span class="remover" onclick="removerColumna('${col}')">&times;</span>`;
                container.appendChild(chip);
            });
        }
    }

    window.removerColumna = function(columna) {
        columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
        actualizarGrupoColumnas();
    };

    // Drag & drop
    document.addEventListener('dragstart', (e) => {
        if (e.target.tagName === 'TH' && e.target.draggable) {
            e.dataTransfer.setData('text/plain', e.target.dataset.columna);
        }
    });

    document.getElementById('grupoAgrupacion').addEventListener('dragover', (e) => e.preventDefault());
    
    document.getElementById('grupoAgrupacion').addEventListener('drop', (e) => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadas.includes(columna)) {
            columnasAgrupadas.push(columna);
            actualizarGrupoColumnas();
        }
    });

    // Selector de columnas
    window.toggleColumnSelector = function() {
        const selector = document.getElementById('columnSelector');
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
        
        if (selector.style.display === 'block') {
            const columnas = [
                { field: 'folio', caption: 'Folio' },
                { field: 'empleado', caption: 'Empleado' },
                { field: 'rfc', caption: 'RFC' },
                { field: 'tipo', caption: 'Tipo' },
                { field: 'fecha_baja', caption: 'Fecha Baja' },
                { field: 'antiguedad', caption: 'Antigüedad' },
                { field: 'dias_vacaciones', caption: 'Días Vac.' },
                { field: 'prima_vacacional', caption: 'Prima Vac.' },
                { field: 'aguinaldo', caption: 'Aguinaldo' },
                { field: 'indemnizacion', caption: 'Indemnización' },
                { field: 'total', caption: 'Total' },
                { field: 'estatus', caption: 'Estatus' }
            ];
            
            const lista = document.getElementById('columnasLista');
            lista.innerHTML = columnas.map(col => `
                <div style="padding: 5px 0; display: flex; align-items: center;">
                    <input type="checkbox" 
                           id="chk_${col.field}"
                           data-columna="${col.field}"
                           checked
                           style="margin-right: 8px; accent-color: var(--color-primary);">
                    <label for="chk_${col.field}" style="font-size: 12px;">${col.caption}</label>
                </div>
            `).join('');
        }
    };

    window.cerrarColumnSelector = function() {
        document.getElementById('columnSelector').style.display = 'none';
    };

    // Cerrar selector al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#btnColumnas') && !e.target.closest('#columnSelector')) {
            document.getElementById('columnSelector').style.display = 'none';
        }
    });

    // Botones
    document.getElementById('btnCrearFiltro').addEventListener('click', () => alert('Funcionalidad de filtro en desarrollo'));
    document.getElementById('btnExcel').addEventListener('click', () => alert('Exportar a Excel'));

    // Buscador
    document.getElementById('buscador').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        console.log('Buscando:', termino);
    });
});

// Función para calcular finiquito en tiempo real
function calcularFiniquito() {
    const salarioDiario = parseFloat(document.querySelector('input[placeholder="250.00"]')?.value) || 250;
    const diasVacaciones = parseInt(document.getElementById('diasVacaciones')?.value) || 0;
    const primaPorcentaje = parseInt(document.getElementById('primaPorcentaje')?.value) || 25;
    const diasAguinaldo = parseInt(document.getElementById('diasAguinaldo')?.value) || 15;
    const indemnizacion = parseFloat(document.getElementById('indemnizacion')?.value) || 0;
    
    const vacaciones = salarioDiario * diasVacaciones;
    const primaVacacional = vacaciones * (primaPorcentaje / 100);
    const aguinaldo = salarioDiario * diasAguinaldo;
    const total = vacaciones + primaVacacional + aguinaldo + indemnizacion;
    
    document.getElementById('primaVacacional').value = primaVacacional.toFixed(2);
    document.getElementById('aguinaldo').value = aguinaldo.toFixed(2);
    document.getElementById('totalEstimado').textContent = '$' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

// Funciones de modal
function abrirModalFiniquito() {
    document.getElementById('modalFiniquito').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    setTimeout(calcularFiniquito, 100);
}

function cerrarModalFiniquito() {
    document.getElementById('modalFiniquito').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function abrirModalDetalle(folio) {
    document.getElementById('detalleFolio').textContent = folio;
    document.getElementById('modalDetalleFiniquito').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalDetalle() {
    document.getElementById('modalDetalleFiniquito').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Cerrar modales con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalFiniquito();
        cerrarModalDetalle();
    }
});

// Cerrar modales al hacer clic fuera
document.getElementById('modalFiniquito')?.addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalFiniquito();
    }
});

document.getElementById('modalDetalleFiniquito')?.addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalDetalle();
    }
});
</script>
@endsection