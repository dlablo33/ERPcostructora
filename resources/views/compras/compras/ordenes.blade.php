@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Órdenes de Compra -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Órdenes de Compra
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- KPIs - Fondo blanco y texto negro -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px; width: 100%;">
                    <!-- Total Órdenes -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: white; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #000000; margin-bottom: 3px;">Órdenes</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: #000000;">3</div>
                    </div>

                    <!-- Activas -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: white; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #000000; margin-bottom: 3px;">Activas</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: #000000;">2</div>
                    </div>

                    <!-- Cerradas -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: white; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #000000; margin-bottom: 3px;">Cerradas</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: #000000;">0</div>
                    </div>

                    <!-- Canceladas -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: white; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #000000; margin-bottom: 3px;">Canceladas</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: #000000;">0</div>
                    </div>
                </div>

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
                        
                        <!-- Botón Agregar (+) -->
                        <div>
                            <button id="btnAgregar" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                    title="Agregar orden de compra"
                                    onclick="abrirModalOrdenCompra()">
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
                        <div style="position: relative; min-width: 200px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar orden..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Órdenes de Compra -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaOrdenesCompra" style="width: 100%; border-collapse: collapse; font-size: 11px; min-width: 2000px;">
                        <thead style="background-color: var(--color-primary); position: sticky; top: 0; z-index: 20;">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="folio">Folio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha">Fecha</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="proveedor">Proveedor</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="moneda">Moneda</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="subtotal">SubTotal</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="impuestos">Impuestos</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="descuento">Descuento</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="retencion">Retención</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="total">Total</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="folio_cxp">Folio CXP</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="uuid">UUID</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="total_cxp">Total CXP</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus_cxp">Estatus CXP</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_factura">Fecha Factura</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="observaciones">Observaciones</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="entrada">Entrada</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_autorizacion">Fecha Autorización</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="autorizo">Autorizó</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="cotizacion">Cotización</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 10px; display: inline-block; min-width: 70px;">Activa</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">1001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">CEMEX México</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">MXN</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$45,000.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$7,200.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$52,200.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-size: 10px;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Material para obra TRC001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">COT-001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle OC-1001')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarOrdenCompra('1001')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar orden?')) alert('Orden eliminada')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 10px; display: inline-block; min-width: 70px;">Activa</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">1002</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">14/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Grupo Acerero</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">MXN</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$78,500.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$12,560.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$91,060.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-size: 10px;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Varilla y perfiles de acero</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">COT-002</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle OC-1002')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarOrdenCompra('1002')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar orden?')) alert('Orden eliminada')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 3px; font-size: 10px; display: inline-block; min-width: 70px;">Cerrada</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">1003</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">13/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Ferrecarril SA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">MXN</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$32,000.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$5,120.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$37,120.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CXP-003</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-size: 10px;">A1B2C3D4-E5F6-7890</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$37,120.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 2px 6px; border-radius: 3px; font-size: 10px;">Pagado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">13/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Rieles de acero - Entregado</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">ENT-003</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">13/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JUAN PÉREZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">COT-003</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle OC-1003')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarOrdenCompra('1003')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar orden?')) alert('Orden eliminada')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 10px; display: inline-block; min-width: 70px;">Pendiente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">1004</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">12/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Constructora del Norte</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">MXN</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$95,000.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$15,200.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$110,200.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-size: 10px;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Pendiente de autorización</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">COT-004</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle OC-1004')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarOrdenCompra('1004')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar orden?')) alert('Orden eliminada')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 10px; display: inline-block; min-width: 70px;">Cancelada</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">1005</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">11/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Materiales Monterrey</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">MXN</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$12,500.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$2,000.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$14,500.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-size: 10px;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Cancelada por error en precios</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">COT-005</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle OC-1005')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarOrdenCompra('1005')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar orden?')) alert('Orden eliminada')" title="Eliminar"></i>
                                    <i class="fas fa-undo-alt" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Reactivar orden')" title="Reactivar"></i>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="4" style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">Totales:</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">$263,000.00</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">$42,080.00</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">$0.00</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$305,080.00</td>
                                <td colspan="2" style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">$37,120.00</td>
                                <td colspan="5" style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">Total Órdenes: 5</td>
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

<!-- MODAL PARA AGREGAR/EDITAR ORDEN DE COMPRA -->
<div id="modalOrdenCompra" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 900px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTituloOrdenCompra">Nueva Orden de Compra</h3>
            <button onclick="cerrarModalOrdenCompra()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Folio</label>
                    <input type="text" id="modalFolioOrdenCompra" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="1006">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Estatus</label>
                    <select id="modalEstatusOrdenCompra" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Activa</option>
                        <option>Pendiente</option>
                        <option>Cerrada</option>
                        <option>Cancelada</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Fecha</label>
                    <input type="date" id="modalFechaOrdenCompra" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d') }}">
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Proveedor</label>
                    <select id="modalProveedorOrdenCompra" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar proveedor</option>
                        <option>CEMEX México</option>
                        <option>Grupo Acerero</option>
                        <option>Ferrecarril SA</option>
                        <option>Constructora del Norte</option>
                        <option>Materiales Monterrey</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Moneda</label>
                    <select id="modalMonedaOrdenCompra" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>MXN</option>
                        <option>USD</option>
                        <option>EUR</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Cotización</label>
                    <input type="text" id="modalCotizacionOrdenCompra" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="COT-006">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">SubTotal</label>
                    <input type="number" id="modalSubtotalOrdenCompra" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">IVA (16%)</label>
                    <input type="number" id="modalIvaOrdenCompra" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Descuento</label>
                    <input type="number" id="modalDescuentoOrdenCompra" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Retención</label>
                    <input type="number" id="modalRetencionOrdenCompra" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Total</label>
                    <input type="number" id="modalTotalOrdenCompra" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00" readonly>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Fecha Autorización</label>
                    <input type="date" id="modalFechaAutorizacionOrdenCompra" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Autorizó</label>
                    <input type="text" id="modalAutorizoOrdenCompra" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Nombre del autorizador">
                </div>
                <div style="grid-column: span 3;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Observaciones</label>
                    <textarea id="modalObservacionesOrdenCompra" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones..."></textarea>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalOrdenCompra()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarOrdenCompra()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
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
        font-size: 11px;
    }

    .table th {
        background-color: var(--color-primary) !important;
        color: white;
        padding: 12px 8px;
        border: 1px solid #dee2e6;
        font-size: 11px;
        white-space: nowrap;
        text-align: center;
        font-weight: 600;
    }
    
    .table td {
        padding: 10px 8px;
        border: 1px solid #dee2e6;
        font-size: 11px;
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
        font-size: 13px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .table td:last-child i:hover {
        transform: scale(1.2);
    }
    
    .table td:last-child i.fa-edit,
    .table td:last-child i.fa-eye {
        color: var(--color-primary);
    }
    
    .table td:last-child i.fa-trash,
    .table td:last-child i.fa-file-pdf {
        color: #dc3545;
    }
    
    .table td:last-child i.fa-undo-alt {
        color: #ffc107;
    }
    
    /* Badges de estatus */
    .badge-activa {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 10px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-cerrada {
        background-color: #17a2b8;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 10px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-pendiente {
        background-color: #ffc107;
        color: #212529;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 10px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-cancelada {
        background-color: #dc3545;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 10px;
        display: inline-block;
        min-width: 70px;
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
    #modalOrdenCompra {
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
            font-size: 10px;
        }
        
        .table td:last-child i {
            margin: 0 3px;
            font-size: 11px;
        }
        
        #modalOrdenCompra > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        #modalOrdenCompra div[style*="grid-template-columns: repeat(3, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadas = [];
    
    // Función para abrir modal de nueva orden de compra
    window.abrirModalOrdenCompra = function() {
        document.getElementById('modalTituloOrdenCompra').textContent = 'Nueva Orden de Compra';
        document.getElementById('modalFolioOrdenCompra').value = '';
        document.getElementById('modalEstatusOrdenCompra').value = 'Pendiente';
        document.getElementById('modalFechaOrdenCompra').value = new Date().toISOString().split('T')[0];
        document.getElementById('modalProveedorOrdenCompra').value = 'Seleccionar proveedor';
        document.getElementById('modalMonedaOrdenCompra').value = 'MXN';
        document.getElementById('modalCotizacionOrdenCompra').value = '';
        document.getElementById('modalSubtotalOrdenCompra').value = '';
        document.getElementById('modalIvaOrdenCompra').value = '';
        document.getElementById('modalDescuentoOrdenCompra').value = '';
        document.getElementById('modalRetencionOrdenCompra').value = '';
        document.getElementById('modalTotalOrdenCompra').value = '';
        document.getElementById('modalFechaAutorizacionOrdenCompra').value = '';
        document.getElementById('modalAutorizoOrdenCompra').value = '';
        document.getElementById('modalObservacionesOrdenCompra').value = '';
        document.getElementById('modalOrdenCompra').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    // Función para editar orden de compra
    window.editarOrdenCompra = function(folio) {
        document.getElementById('modalTituloOrdenCompra').textContent = 'Editar Orden de Compra ' + folio;
        
        // Simular carga de datos según el folio
        if (folio === '1001') {
            document.getElementById('modalFolioOrdenCompra').value = '1001';
            document.getElementById('modalEstatusOrdenCompra').value = 'Activa';
            document.getElementById('modalFechaOrdenCompra').value = '2025-03-15';
            document.getElementById('modalProveedorOrdenCompra').value = 'CEMEX México';
            document.getElementById('modalMonedaOrdenCompra').value = 'MXN';
            document.getElementById('modalCotizacionOrdenCompra').value = 'COT-001';
            document.getElementById('modalSubtotalOrdenCompra').value = '45000';
            document.getElementById('modalIvaOrdenCompra').value = '7200';
            document.getElementById('modalDescuentoOrdenCompra').value = '0';
            document.getElementById('modalRetencionOrdenCompra').value = '0';
            document.getElementById('modalTotalOrdenCompra').value = '52200';
            document.getElementById('modalFechaAutorizacionOrdenCompra').value = '';
            document.getElementById('modalAutorizoOrdenCompra').value = '';
            document.getElementById('modalObservacionesOrdenCompra').value = 'Material para obra TRC001';
        } else if (folio === '1003') {
            document.getElementById('modalFolioOrdenCompra').value = '1003';
            document.getElementById('modalEstatusOrdenCompra').value = 'Cerrada';
            document.getElementById('modalFechaOrdenCompra').value = '2025-03-13';
            document.getElementById('modalProveedorOrdenCompra').value = 'Ferrecarril SA';
            document.getElementById('modalMonedaOrdenCompra').value = 'MXN';
            document.getElementById('modalCotizacionOrdenCompra').value = 'COT-003';
            document.getElementById('modalSubtotalOrdenCompra').value = '32000';
            document.getElementById('modalIvaOrdenCompra').value = '5120';
            document.getElementById('modalDescuentoOrdenCompra').value = '0';
            document.getElementById('modalRetencionOrdenCompra').value = '0';
            document.getElementById('modalTotalOrdenCompra').value = '37120';
            document.getElementById('modalFechaAutorizacionOrdenCompra').value = '2025-03-13';
            document.getElementById('modalAutorizoOrdenCompra').value = 'JUAN PÉREZ';
            document.getElementById('modalObservacionesOrdenCompra').value = 'Rieles de acero - Entregado';
        } else {
            document.getElementById('modalFolioOrdenCompra').value = folio;
            document.getElementById('modalEstatusOrdenCompra').value = 'Pendiente';
            document.getElementById('modalFechaOrdenCompra').value = '2025-03-10';
            document.getElementById('modalProveedorOrdenCompra').value = 'CEMEX México';
            document.getElementById('modalMonedaOrdenCompra').value = 'MXN';
            document.getElementById('modalCotizacionOrdenCompra').value = 'COT-00' + folio;
            document.getElementById('modalSubtotalOrdenCompra').value = '10000';
            document.getElementById('modalIvaOrdenCompra').value = '1600';
            document.getElementById('modalDescuentoOrdenCompra').value = '0';
            document.getElementById('modalRetencionOrdenCompra').value = '0';
            document.getElementById('modalTotalOrdenCompra').value = '11600';
            document.getElementById('modalFechaAutorizacionOrdenCompra').value = '';
            document.getElementById('modalAutorizoOrdenCompra').value = '';
            document.getElementById('modalObservacionesOrdenCompra').value = '';
        }
        
        document.getElementById('modalOrdenCompra').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalOrdenCompra = function() {
        document.getElementById('modalOrdenCompra').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.guardarOrdenCompra = function() {
        const folio = document.getElementById('modalFolioOrdenCompra').value;
        const proveedor = document.getElementById('modalProveedorOrdenCompra').value;
        
        if (!folio || proveedor === 'Seleccionar proveedor') {
            alert('Por favor complete los campos obligatorios');
            return;
        }
        
        alert(`Orden de compra ${folio} guardada correctamente`);
        cerrarModalOrdenCompra();
    };
    
    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalOrdenCompra();
        }
    });
    
    // Cerrar modal al hacer clic fuera
    document.getElementById('modalOrdenCompra').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalOrdenCompra();
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
                { field: 'estatus', caption: 'Estatus' },
                { field: 'folio', caption: 'Folio' },
                { field: 'fecha', caption: 'Fecha' },
                { field: 'proveedor', caption: 'Proveedor' },
                { field: 'moneda', caption: 'Moneda' },
                { field: 'subtotal', caption: 'SubTotal' },
                { field: 'impuestos', caption: 'Impuestos' },
                { field: 'descuento', caption: 'Descuento' },
                { field: 'retencion', caption: 'Retención' },
                { field: 'total', caption: 'Total' },
                { field: 'folio_cxp', caption: 'Folio CXP' },
                { field: 'uuid', caption: 'UUID' },
                { field: 'total_cxp', caption: 'Total CXP' },
                { field: 'estatus_cxp', caption: 'Estatus CXP' },
                { field: 'fecha_factura', caption: 'Fecha Factura' },
                { field: 'observaciones', caption: 'Observaciones' },
                { field: 'entrada', caption: 'Entrada' },
                { field: 'fecha_autorizacion', caption: 'Fecha Autorización' },
                { field: 'autorizo', caption: 'Autorizó' },
                { field: 'cotizacion', caption: 'Cotización' }
            ];
            
            const lista = document.getElementById('columnasLista');
            lista.innerHTML = columnas.map(col => `
                <div style="padding: 5px 0; display: flex; align-items: center;">
                    <input type="checkbox" 
                           id="chk_${col.field}"
                           data-columna="${col.field}"
                           checked
                           style="margin-right: 8px; accent-color: var(--color-primary);">
                    <label for="chk_${col.field}" style="font-size: 11px;">${col.caption}</label>
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
    document.getElementById('btnExcel').addEventListener('click', () => alert('Exportar órdenes de compra a Excel'));

    // Buscador
    document.getElementById('buscador').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        console.log('Buscando en órdenes de compra:', termino);
    });
});
</script>
@endsection