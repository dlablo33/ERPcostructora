@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Autorización de Órdenes de Compra -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-check-circle" style="margin-right: 10px;"></i> Autorización de Órdenes de Compra
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- KPIs -->


                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Grupo de agrupación (izquierda) -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <!-- Grupo derecho: filtros y botones -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <!-- Filtros de fecha -->
                        <div>
                            <input type="date" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px; width: 140px;" value="{{ date('Y-m-01') }}" placeholder="Fecha Inicio">
                        </div>
                        <div>
                            <input type="date" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px; width: 140px;" value="{{ date('Y-m-d') }}" placeholder="Fecha Fin">
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
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 280px; max-height: 400px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative; min-width: 200px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar orden..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Autorización de Órdenes de Compra -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaAutorizacion" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1200px;">
                        <thead style="background-color: var(--color-primary); position: sticky; top: 0; z-index: 20;">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="folio">Folio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha">Fecha</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="observaciones">Observaciones</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="orden_compra">Orden Compra</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="monto">Monto</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="cuenta_por_pagar">Cuenta por Pagar</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="autorizado_por">Autorizado por</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_autorizacion">Fecha Autorización</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">OC-1001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Pendiente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Material para obra TRC001 - Cemento y varilla</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">OC-1001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$52,200.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-check-circle" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="autorizarOrden('OC-1001')" title="Autorizar"></i>
                                    <i class="fas fa-times-circle" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="rechazarOrden('OC-1001')" title="Rechazar"></i>
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle OC-1001')" title="Ver detalle"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">OC-1002</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Pendiente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">14/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Varilla y perfiles de acero para obra PAC002</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">OC-1002</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$91,060.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-check-circle" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="autorizarOrden('OC-1002')" title="Autorizar"></i>
                                    <i class="fas fa-times-circle" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="rechazarOrden('OC-1002')" title="Rechazar"></i>
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle OC-1002')" title="Ver detalle"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">OC-1003</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Autorizada</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">13/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Rieles de acero para proyecto ferroviario</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">OC-1003</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$37,120.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CXP-003</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JUAN PÉREZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">13/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-undo-alt" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="revertirAutorizacion('OC-1003')" title="Revertir autorización"></i>
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle OC-1003')" title="Ver detalle"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">OC-1004</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Pendiente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">12/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Materiales varios para mantenimiento</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">OC-1004</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$110,200.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-check-circle" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="autorizarOrden('OC-1004')" title="Autorizar"></i>
                                    <i class="fas fa-times-circle" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="rechazarOrden('OC-1004')" title="Rechazar"></i>
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle OC-1004')" title="Ver detalle"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">OC-1005</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Rechazada</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">11/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Material con precios fuera de presupuesto</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">OC-1005</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$14,500.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">MARÍA GARCÍA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">11/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-redo-alt" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="reabrirOrden('OC-1005')" title="Reabrir"></i>
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle OC-1005')" title="Ver detalle"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">OC-1006</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Pendiente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">10/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Equipo de cómputo para oficina</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">OC-1006</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$45,300.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-check-circle" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="autorizarOrden('OC-1006')" title="Autorizar"></i>
                                    <i class="fas fa-times-circle" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="rechazarOrden('OC-1006')" title="Rechazar"></i>
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle OC-1006')" title="Ver detalle"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">OC-1007</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Autorizada</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">09/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Mobiliario para oficina central</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">OC-1007</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$28,750.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CXP-007</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">CARLOS LÓPEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">10/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-undo-alt" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="revertirAutorizacion('OC-1007')" title="Revertir autorización"></i>
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle OC-1007')" title="Ver detalle"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">OC-1008</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Autorizada</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">08/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Herramientas eléctricas para taller</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">OC-1008</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$12,450.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CXP-008</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ANA MARTÍNEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">09/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-undo-alt" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="revertirAutorizacion('OC-1008')" title="Revertir autorización"></i>
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle OC-1008')" title="Ver detalle"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">OC-1009</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Autorizada</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">07/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Material eléctrico para instalaciones</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">OC-1009</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$33,200.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CXP-009</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ROBERTO SÁNCHEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">08/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-undo-alt" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="revertirAutorizacion('OC-1009')" title="Revertir autorización"></i>
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle OC-1009')" title="Ver detalle"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">OC-1010</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Autorizada</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">06/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Material de ferretería general</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">OC-1010</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$8,950.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CXP-010</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">LAURA FLORES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">07/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-undo-alt" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="revertirAutorizacion('OC-1010')" title="Revertir autorización"></i>
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle OC-1010')" title="Ver detalle"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">OC-1011</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Rechazada</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">05/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Proveedor no cumple especificaciones</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">OC-1011</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$22,300.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JOSÉ TORRES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">05/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-redo-alt" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="reabrirOrden('OC-1011')" title="Reabrir"></i>
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle OC-1011')" title="Ver detalle"></i>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="4" style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">Totales:</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$456,030.00</td>
                                <td colspan="3" style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">Total Órdenes: 11</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #e9ecef; box-shadow: -2px 0 5px rgba(0,0,0,0.1);"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Botón Crear filtro -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA AUTORIZAR ORDEN -->
<div id="modalAutorizar" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 500px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Autorizar Orden de Compra</h3>
            <button onclick="cerrarModalAutorizar()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <p style="margin-bottom: 15px; font-size: 14px;">¿Está seguro de autorizar la orden <strong id="ordenAutorizar">OC-1001</strong>?</p>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Cuenta por Pagar</label>
                <input type="text" id="modalCuentaPagar" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="CXP-XXX">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Observaciones</label>
                <textarea id="modalObservacionesAutorizar" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones..."></textarea>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button onclick="cerrarModalAutorizar()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="confirmarAutorizar()" style="padding: 8px 20px; border: none; border-radius: 4px; background: #28a745; color: white; cursor: pointer;">
                    <i class="fas fa-check-circle"></i> Autorizar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA RECHAZAR ORDEN -->
<div id="modalRechazar" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 500px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Rechazar Orden de Compra</h3>
            <button onclick="cerrarModalRechazar()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <p style="margin-bottom: 15px; font-size: 14px;">¿Está seguro de rechazar la orden <strong id="ordenRechazar">OC-1001</strong>?</p>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Motivo de rechazo</label>
                <textarea id="modalMotivoRechazo" rows="4" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Indique el motivo del rechazo..."></textarea>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button onclick="cerrarModalRechazar()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="confirmarRechazar()" style="padding: 8px 20px; border: none; border-radius: 4px; background: #dc3545; color: white; cursor: pointer;">
                    <i class="fas fa-times-circle"></i> Rechazar
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
        max-height: 500px;
        overflow-y: auto;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        scrollbar-width: thin;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
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
    
    .table td:last-child i.fa-check-circle {
        color: #28a745;
    }
    
    .table td:last-child i.fa-times-circle {
        color: #dc3545;
    }
    
    .table td:last-child i.fa-undo-alt,
    .table td:last-child i.fa-redo-alt {
        color: #ffc107;
    }
    
    .table td:last-child i.fa-eye {
        color: var(--color-primary);
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
    
    .badge-autorizada {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 80px;
        text-align: center;
    }
    
    .badge-rechazada {
        background-color: #dc3545;
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
    
    /* Scroll personalizado */
    .table-container::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    .table-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .table-container::-webkit-scrollbar-thumb {
        background: var(--color-primary);
        border-radius: 4px;
    }
    
    /* Modal */
    #modalAutorizar, #modalRechazar {
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
            max-height: 400px;
        }
        
        .table td {
            padding: 8px 4px;
            font-size: 11px;
        }
        
        .table td:last-child i {
            margin: 0 3px;
            font-size: 12px;
        }
        
        #modalAutorizar > div, #modalRechazar > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadas = [];
    
    // Variables para modales
    let ordenSeleccionada = '';
    
    // Función para abrir modal de autorizar
    window.autorizarOrden = function(orden) {
        ordenSeleccionada = orden;
        document.getElementById('ordenAutorizar').textContent = orden;
        document.getElementById('modalCuentaPagar').value = '';
        document.getElementById('modalObservacionesAutorizar').value = '';
        document.getElementById('modalAutorizar').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalAutorizar = function() {
        document.getElementById('modalAutorizar').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.confirmarAutorizar = function() {
        const cuenta = document.getElementById('modalCuentaPagar').value;
        const observaciones = document.getElementById('modalObservacionesAutorizar').value;
        
        alert(`Orden ${ordenSeleccionada} autorizada correctamente.\nCuenta: ${cuenta || 'No especificada'}\nObservaciones: ${observaciones || 'Ninguna'}`);
        cerrarModalAutorizar();
    };
    
    // Función para abrir modal de rechazar
    window.rechazarOrden = function(orden) {
        ordenSeleccionada = orden;
        document.getElementById('ordenRechazar').textContent = orden;
        document.getElementById('modalMotivoRechazo').value = '';
        document.getElementById('modalRechazar').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalRechazar = function() {
        document.getElementById('modalRechazar').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.confirmarRechazar = function() {
        const motivo = document.getElementById('modalMotivoRechazo').value;
        
        if (!motivo) {
            alert('Por favor indique el motivo del rechazo');
            return;
        }
        
        alert(`Orden ${ordenSeleccionada} rechazada.\nMotivo: ${motivo}`);
        cerrarModalRechazar();
    };
    
    // Funciones adicionales
    window.revertirAutorizacion = function(orden) {
        if (confirm(`¿Está seguro de revertir la autorización de la orden ${orden}?`)) {
            alert(`Autorización revertida para la orden ${orden}`);
        }
    };
    
    window.reabrirOrden = function(orden) {
        if (confirm(`¿Está seguro de reabrir la orden ${orden}?`)) {
            alert(`Orden ${orden} reabierta correctamente`);
        }
    };
    
    // Cerrar modales con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalAutorizar();
            cerrarModalRechazar();
        }
    });
    
    // Cerrar modales al hacer clic fuera
    document.getElementById('modalAutorizar').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalAutorizar();
        }
    });
    
    document.getElementById('modalRechazar').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalRechazar();
        }
    });
    
    // Funciones de agrupación y selector de columnas
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
            alert('Agrupando por: ' + columna);
        }
    });

    // Selector de columnas
    window.toggleColumnSelector = function() {
        const selector = document.getElementById('columnSelector');
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
        
        if (selector.style.display === 'block') {
            const columnas = [
                { field: 'folio', caption: 'Folio' },
                { field: 'estatus', caption: 'Estatus' },
                { field: 'fecha', caption: 'Fecha' },
                { field: 'observaciones', caption: 'Observaciones' },
                { field: 'orden_compra', caption: 'Orden Compra' },
                { field: 'monto', caption: 'Monto' },
                { field: 'cuenta_por_pagar', caption: 'Cuenta por Pagar' },
                { field: 'autorizado_por', caption: 'Autorizado por' },
                { field: 'fecha_autorizacion', caption: 'Fecha Autorización' }
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
</script>
@endsection