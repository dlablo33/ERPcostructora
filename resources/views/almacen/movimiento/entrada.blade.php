@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Entradas y Salidas de Almacén -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Entradas y Salidas de Almacén
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros de período -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Fecha Inicio</label>
                        <input type="date" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;" value="{{ date('Y-m-01') }}">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Fecha Fin</label>
                        <input type="date" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;" value="{{ date('Y-m-d') }}">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Proveedor/Cliente</label>
                        <select style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                            <option>Todos</option>
                            <option>CEMEX México</option>
                            <option>Grupo Acerero</option>
                            <option>Ferrecarril SA</option>
                            <option>Constructora del Norte</option>
                        </select>
                    </div>
                    <div style="display: flex; align-items: flex-end;">
                        <button style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 13px; width: 100%;">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                    </div>
                </div>

                <!-- Pestañas de navegación -->
                <div style="display: flex; border-bottom: 2px solid #dee2e6; margin-bottom: 20px;">
                    <button class="tab-entrada active" onclick="switchTab('entradas')" id="tabEntradas" style="background-color: var(--color-primary); color: white; border: none; padding: 10px 25px; border-radius: 8px 8px 0 0; margin-right: 5px; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-arrow-down" style="color: #28a745; margin-right: 5px;"></i> Entradas
                    </button>
                    <button class="tab-salida" onclick="switchTab('salidas')" id="tabSalidas" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; border-radius: 8px 8px 0 0; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-arrow-up" style="color: #dc3545; margin-right: 5px;"></i> Salidas
                    </button>
                </div>

                <!-- Panel de Entradas -->
                <div id="panelEntradas" style="display: block;">
                    <!-- Barra de herramientas para Entradas -->
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                        <!-- Grupo de agrupación -->
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacionEntradas">
                            <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                            <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgruparEntradas">arrastra una columna aquí para agrupar</span>
                            <div id="grupoColumnasEntradas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                        </div>
                        
                        <!-- Botones -->
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                            <!-- Botón Agregar (+) -->
                            <div>
                                <button id="btnAgregarEntrada" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                        title="Agregar entrada"
                                        onclick="abrirModalEntrada()">
                                    <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                                </button>
                            </div>

                            <!-- Botón Exportar Excel -->
                            <div>
                                <button id="btnExcelEntradas" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                    <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                    <span class="hide-mobile">Excel</span>
                                </button>
                            </div>



                            <!-- Botón Seleccionar Columnas -->
                            <div style="position: relative;">
                                <button id="btnColumnasEntradas" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                        onclick="toggleColumnSelector('entradas')">
                                    <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                    <span class="hide-mobile">Columnas</span>
                                </button>
                                
                                <!-- Selector de columnas para Entradas -->
                                <div id="columnSelectorEntradas" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 280px; max-height: 400px; overflow-y: auto;">
                                    <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                        <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                        <button onclick="cerrarColumnSelector('entradas')" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                    </div>
                                    <div id="columnasListaEntradas" style="padding: 10px;"></div>
                                </div>
                            </div>

                            <!-- Buscador -->
                            <div style="position: relative; min-width: 220px;">
                                <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                                <input type="text" id="buscadorEntradas" placeholder="Buscar entrada..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Entradas -->
                    <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                        <table class="table" id="tablaEntradas" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1600px;">
                            <thead style="background-color: var(--color-primary); position: sticky; top: 0; z-index: 20;">
                                <tr>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="entrada">Entrada</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha">Fecha</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="proveedor">Proveedor</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="codigo">Código</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="descripcion">Descripción</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="cantidad">Cantidad</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="valor_unitario">V. Unitario</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="importe">Importe</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="impuestos">Impuestos</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="total">Total</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="factura">Factura</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="referencia">Referencia</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="factura_cxp">Factura CXP</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="poliza">Póliza</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="empresa">Empresa</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="observaciones">Observaciones</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodyEntradas">
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">1001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Activo</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">CEMEX México</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CEM-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Cemento Gris 50kg</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">100</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$185.50</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$18,550.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$2,968.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$21,518.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">FAC-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">REF-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CXP-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">POL-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Constructora ABC</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Material para obra TRC001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle entrada 1001')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarEntrada('1001')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar entrada?')) alert('Entrada eliminada')" title="Eliminar"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">1002</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Activo</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">14/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Grupo Acerero</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">AC-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Varilla Corrugada 3/8"</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">500</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$45.20</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$22,600.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$3,616.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$26,216.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">FAC-002</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">REF-002</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CXP-002</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">POL-002</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Constructora ABC</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Material para obra PAC002</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle entrada 1002')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarEntrada('1002')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar entrada?')) alert('Entrada eliminada')" title="Eliminar"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">1003</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Cancelado</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">13/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Ferrecarril SA</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">FERR-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Rieles de Acero</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">20</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$2,350.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$47,000.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$7,520.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$54,520.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">FAC-003</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">REF-003</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CXP-003</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">POL-003</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Constructora ABC</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Cancelado por error en factura</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle entrada 1003')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarEntrada('1003')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar entrada?')) alert('Entrada eliminada')" title="Eliminar"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot style="background-color: #e9ecef; font-weight: bold;">
                                <tr>
                                    <td colspan="6" style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">Totales:</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">620</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">—</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">$88,150.00</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">$14,104.00</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$102,254.00</td>
                                    <td colspan="6" style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">Total Registros: 3</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #e9ecef; box-shadow: -2px 0 5px rgba(0,0,0,0.1);"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Panel de Entradas Diesel (Combustible) -->
                <div id="panelEntradasDiesel" style="display: none;">
                    <!-- Barra de herramientas para Entradas Diesel -->
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                        <!-- Grupo de agrupación -->
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacionDiesel">
                            <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                            <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgruparDiesel">arrastra una columna aquí para agrupar</span>
                            <div id="grupoColumnasDiesel" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                        </div>
                        
                        <!-- Botones -->
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                            <!-- Botón Agregar (+) -->
                            <div>
                                <button style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                        title="Agregar entrada de combustible"
                                        onclick="alert('Agregar entrada de combustible')">
                                    <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                                </button>
                            </div>

                            <!-- Botón Exportar Excel -->
                            <div>
                                <button style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                    <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                    <span class="hide-mobile">Excel</span>
                                </button>
                            </div>

                            <!-- Botón Volver a Entradas -->
                            <div>
                                <button id="btnVolverEntradas" 
                                        style="background-color: #6c757d; color: white; border: none; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;"
                                        onclick="volverAEntradas()">
                                    <i class="fas fa-arrow-left"></i>
                                    <span class="hide-mobile">Volver a Entradas</span>
                                </button>
                            </div>

                            <!-- Buscador -->
                            <div style="position: relative; min-width: 220px;">
                                <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                                <input type="text" placeholder="Buscar combustible..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Entradas Diesel -->
                    <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                        <table class="table" id="tablaEntradasDiesel" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1000px;">
                            <thead style="background-color: var(--color-primary); position: sticky; top: 0; z-index: 20;">
                                <tr>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="entrada">Entrada</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="poliza">Póliza</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha">Fecha</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="proveedor">Proveedor</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="codigo">Código</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="descripcion">Descripción</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="cantidad">Cantidad (L)</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="total">Total</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">D-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Activo</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">POL-045</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">PEMEX</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">DIE-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Diésel</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">800</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$18,400.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar?')) alert('Eliminado')" title="Eliminar"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">D-002</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Activo</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">POL-046</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">14/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Gas LP Monterrey</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">GAS-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Gasolina Magna</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">500</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$11,250.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar?')) alert('Eliminado')" title="Eliminar"></i>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot style="background-color: #e9ecef; font-weight: bold;">
                                <tr>
                                    <td colspan="7" style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">Totales:</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">1,300 L</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$29,650.00</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #e9ecef; box-shadow: -2px 0 5px rgba(0,0,0,0.1);"></td>
                                </tr>
                                <tr>
                                    <td colspan="10" style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">Total Registros: 2</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Panel de Salidas -->
                <div id="panelSalidas" style="display: none;">
                    <!-- Barra de herramientas para Salidas -->
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                        <!-- Grupo de agrupación -->
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacionSalidas">
                            <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                            <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgruparSalidas">arrastra una columna aquí para agrupar</span>
                            <div id="grupoColumnasSalidas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                        </div>
                        
                        <!-- Botones -->
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                            <!-- Botón Agregar (+) -->
                            <div>
                                <button id="btnAgregarSalida" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                        title="Agregar salida"
                                        onclick="abrirModalSalida()">
                                    <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                                </button>
                            </div>

                            <!-- Botón Exportar Excel -->
                            <div>
                                <button id="btnExcelSalidas" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                    <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                    <span class="hide-mobile">Excel</span>
                                </button>
                            </div>

                            <!-- Botón Seleccionar Columnas -->
                            <div style="position: relative;">
                                <button id="btnColumnasSalidas" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                        onclick="toggleColumnSelector('salidas')">
                                    <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                    <span class="hide-mobile">Columnas</span>
                                </button>
                                
                                <!-- Selector de columnas para Salidas -->
                                <div id="columnSelectorSalidas" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 280px; max-height: 400px; overflow-y: auto;">
                                    <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                        <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                        <button onclick="cerrarColumnSelector('salidas')" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                    </div>
                                    <div id="columnasListaSalidas" style="padding: 10px;"></div>
                                </div>
                            </div>

                            <!-- Buscador -->
                            <div style="position: relative; min-width: 220px;">
                                <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                                <input type="text" id="buscadorSalidas" placeholder="Buscar salida..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Salidas -->
                    <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                        <table class="table" id="tablaSalidas" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1600px;">
                            <thead style="background-color: var(--color-primary); position: sticky; top: 0; z-index: 20;">
                                <tr>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="salida">Salida</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha">Fecha</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="numero_parte">Núm. Parte</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="codigo">Código</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="descripcion">Descripción</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="cantidad">Cantidad</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="costo_promedio">Costo Prom.</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="importe">Importe</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="impuestos">Impuestos</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="total">Total</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="orden_servicio">O.S.</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="unidad">Unidad</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="tipo_unidad">Tipo Unidad</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="poliza">Póliza</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodySalidas">
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">2001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Completado</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">NP-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CEM-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Cemento Gris 50kg</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">50</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$185.50</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$9,275.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$1,484.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$10,759.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">OS-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">UN-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Pickup</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">POL-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle salida 2001')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarSalida('2001')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar salida?')) alert('Salida eliminada')" title="Eliminar"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">2002</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Completado</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">14/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">NP-002</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">AC-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Varilla Corrugada 3/8"</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">200</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$45.20</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$9,040.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$1,446.40</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$10,486.40</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">OS-002</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">UN-002</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Camión</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">POL-002</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle salida 2002')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarSalida('2002')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar salida?')) alert('Salida eliminada')" title="Eliminar"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">2003</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Pendiente</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">13/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">NP-003</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">FERR-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Rieles de Acero</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">5</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$2,350.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$11,750.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$1,880.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$13,630.00</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">OS-003</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">UN-003</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Camión</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle salida 2003')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarSalida('2003')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar salida?')) alert('Salida eliminada')" title="Eliminar"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot style="background-color: #e9ecef; font-weight: bold;">
                                <tr>
                                    <td colspan="6" style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">Totales:</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">255</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">—</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">$30,065.00</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">$4,810.40</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$34,875.40</td>
                                    <td colspan="4" style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">Total Registros: 3</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #e9ecef; box-shadow: -2px 0 5px rgba(0,0,0,0.1);"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                <!-- Crear filtro (visible según pestaña activa) -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter" style="font-size: 12px;"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA AGREGAR/EDITAR ENTRADA -->
<div id="modalEntrada" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTituloEntrada">Nueva Entrada</h3>
            <button onclick="cerrarModalEntrada()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Folio</label>
                    <input type="text" id="modalFolioEntrada" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="1004">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha</label>
                    <input type="date" id="modalFechaEntrada" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Proveedor</label>
                    <select id="modalProveedorEntrada" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar proveedor</option>
                        <option>CEMEX México</option>
                        <option>Grupo Acerero</option>
                        <option>Ferrecarril SA</option>
                        <option>Constructora del Norte</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Código</label>
                    <input type="text" id="modalCodigoEntrada" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="CEM-001">
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Descripción</label>
                    <input type="text" id="modalDescripcionEntrada" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción del producto">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Cantidad</label>
                    <input type="number" id="modalCantidadEntrada" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Valor Unitario</label>
                    <input type="number" id="modalValorUnitarioEntrada" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Factura</label>
                    <input type="text" id="modalFacturaEntrada" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="FAC-001">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Referencia</label>
                    <input type="text" id="modalReferenciaEntrada" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="REF-001">
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Observaciones</label>
                    <textarea id="modalObservacionesEntrada" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones..."></textarea>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalEntrada()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarEntrada()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA AGREGAR/EDITAR SALIDA -->
<div id="modalSalida" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTituloSalida">Nueva Salida</h3>
            <button onclick="cerrarModalSalida()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Folio Salida</label>
                    <input type="text" id="modalFolioSalida" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="2004">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha</label>
                    <input type="date" id="modalFechaSalida" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Número de Parte</label>
                    <input type="text" id="modalNumeroParteSalida" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="NP-001">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Código</label>
                    <input type="text" id="modalCodigoSalida" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="CEM-001">
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Descripción</label>
                    <input type="text" id="modalDescripcionSalida" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción del producto">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Cantidad</label>
                    <input type="number" id="modalCantidadSalida" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Unidad</label>
                    <input type="text" id="modalUnidadSalida" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="UN-001">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Orden de Servicio</label>
                    <input type="text" id="modalOrdenSalida" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="OS-001">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Tipo Unidad</label>
                    <select id="modalTipoUnidadSalida" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Pickup</option>
                        <option>Camión</option>
                        <option>Sedán</option>
                    </select>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalSalida()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarSalida()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
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
    
    /* Pestañas */
    .tab-entrada, .tab-salida {
        transition: all 0.2s;
        font-size: 14px;
    }
    
    .tab-entrada:hover, .tab-salida:hover {
        opacity: 0.9;
        transform: translateY(-1px);
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
    
    .table td:last-child i.fa-edit,
    .table td:last-child i.fa-eye {
        color: var(--color-primary);
    }
    
    .table td:last-child i.fa-trash,
    .table td:last-child i.fa-file-pdf {
        color: #dc3545;
    }
    
    /* Badges de estatus */
    .badge-activo, .badge-completado {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-pendiente {
        background-color: #ffc107;
        color: #212529;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-cancelado {
        background-color: #dc3545;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
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
    #modalEntrada, #modalSalida {
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
        
        .tab-entrada, .tab-salida {
            padding: 8px 15px !important;
            font-size: 13px;
        }
        
        #modalEntrada > div, #modalSalida > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        #modalEntrada div[style*="grid-template-columns: repeat(2, 1fr)"],
        #modalSalida div[style*="grid-template-columns: repeat(2, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadasEntradas = [];
    let columnasAgrupadasDiesel = [];
    let columnasAgrupadasSalidas = [];
    let vistaActual = 'entradas'; // entradas, diesel, salidas
    
    // Función para cambiar entre pestañas principales
    window.switchTab = function(tab) {
        vistaActual = tab;
        
        if (tab === 'entradas') {
            document.getElementById('panelEntradas').style.display = 'block';
            document.getElementById('panelEntradasDiesel').style.display = 'none';
            document.getElementById('panelSalidas').style.display = 'none';
            document.getElementById('tabEntradas').style.backgroundColor = 'var(--color-primary)';
            document.getElementById('tabEntradas').style.color = 'white';
            document.getElementById('tabSalidas').style.backgroundColor = '#e9ecef';
            document.getElementById('tabSalidas').style.color = '#495057';
        } else {
            document.getElementById('panelEntradas').style.display = 'none';
            document.getElementById('panelEntradasDiesel').style.display = 'none';
            document.getElementById('panelSalidas').style.display = 'block';
            document.getElementById('tabSalidas').style.backgroundColor = 'var(--color-primary)';
            document.getElementById('tabSalidas').style.color = 'white';
            document.getElementById('tabEntradas').style.backgroundColor = '#e9ecef';
            document.getElementById('tabEntradas').style.color = '#495057';
        }
    };
    
    // Función para mostrar entradas de combustible
    window.mostrarEntradasDiesel = function() {
        vistaActual = 'diesel';
        document.getElementById('panelEntradas').style.display = 'none';
        document.getElementById('panelEntradasDiesel').style.display = 'block';
        document.getElementById('panelSalidas').style.display = 'none';
    };
    
    window.volverAEntradas = function() {
        vistaActual = 'entradas';
        document.getElementById('panelEntradas').style.display = 'block';
        document.getElementById('panelEntradasDiesel').style.display = 'none';
        document.getElementById('panelSalidas').style.display = 'none';
    };
    
    // Vincular botón de diesel
    document.getElementById('btnDieselEntradas')?.addEventListener('click', mostrarEntradasDiesel);
    
    // Funciones para Entradas
    window.abrirModalEntrada = function() {
        document.getElementById('modalTituloEntrada').textContent = 'Nueva Entrada';
        document.getElementById('modalFolioEntrada').value = '';
        document.getElementById('modalFechaEntrada').value = new Date().toISOString().split('T')[0];
        document.getElementById('modalProveedorEntrada').value = 'Seleccionar proveedor';
        document.getElementById('modalCodigoEntrada').value = '';
        document.getElementById('modalDescripcionEntrada').value = '';
        document.getElementById('modalCantidadEntrada').value = '';
        document.getElementById('modalValorUnitarioEntrada').value = '';
        document.getElementById('modalFacturaEntrada').value = '';
        document.getElementById('modalReferenciaEntrada').value = '';
        document.getElementById('modalObservacionesEntrada').value = '';
        document.getElementById('modalEntrada').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.editarEntrada = function(id) {
        document.getElementById('modalTituloEntrada').textContent = 'Editar Entrada ' + id;
        // Simular carga de datos
        document.getElementById('modalFolioEntrada').value = id;
        document.getElementById('modalFechaEntrada').value = '2025-03-15';
        document.getElementById('modalProveedorEntrada').value = 'CEMEX México';
        document.getElementById('modalCodigoEntrada').value = 'CEM-001';
        document.getElementById('modalDescripcionEntrada').value = 'Cemento Gris 50kg';
        document.getElementById('modalCantidadEntrada').value = '100';
        document.getElementById('modalValorUnitarioEntrada').value = '185.50';
        document.getElementById('modalFacturaEntrada').value = 'FAC-001';
        document.getElementById('modalReferenciaEntrada').value = 'REF-001';
        document.getElementById('modalObservacionesEntrada').value = 'Material para obra TRC001';
        document.getElementById('modalEntrada').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalEntrada = function() {
        document.getElementById('modalEntrada').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.guardarEntrada = function() {
        const folio = document.getElementById('modalFolioEntrada').value;
        if (!folio) {
            alert('Por favor complete los campos obligatorios');
            return;
        }
        alert(`Entrada ${folio} guardada correctamente`);
        cerrarModalEntrada();
    };
    
    // Funciones para Salidas
    window.abrirModalSalida = function() {
        document.getElementById('modalTituloSalida').textContent = 'Nueva Salida';
        document.getElementById('modalFolioSalida').value = '';
        document.getElementById('modalFechaSalida').value = new Date().toISOString().split('T')[0];
        document.getElementById('modalNumeroParteSalida').value = '';
        document.getElementById('modalCodigoSalida').value = '';
        document.getElementById('modalDescripcionSalida').value = '';
        document.getElementById('modalCantidadSalida').value = '';
        document.getElementById('modalUnidadSalida').value = '';
        document.getElementById('modalOrdenSalida').value = '';
        document.getElementById('modalTipoUnidadSalida').value = 'Pickup';
        document.getElementById('modalSalida').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.editarSalida = function(id) {
        document.getElementById('modalTituloSalida').textContent = 'Editar Salida ' + id;
        // Simular carga de datos
        document.getElementById('modalFolioSalida').value = id;
        document.getElementById('modalFechaSalida').value = '2025-03-15';
        document.getElementById('modalNumeroParteSalida').value = 'NP-001';
        document.getElementById('modalCodigoSalida').value = 'CEM-001';
        document.getElementById('modalDescripcionSalida').value = 'Cemento Gris 50kg';
        document.getElementById('modalCantidadSalida').value = '50';
        document.getElementById('modalUnidadSalida').value = 'UN-001';
        document.getElementById('modalOrdenSalida').value = 'OS-001';
        document.getElementById('modalTipoUnidadSalida').value = 'Pickup';
        document.getElementById('modalSalida').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalSalida = function() {
        document.getElementById('modalSalida').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.guardarSalida = function() {
        const folio = document.getElementById('modalFolioSalida').value;
        if (!folio) {
            alert('Por favor complete los campos obligatorios');
            return;
        }
        alert(`Salida ${folio} guardada correctamente`);
        cerrarModalSalida();
    };
    
    // Cerrar modales con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalEntrada();
            cerrarModalSalida();
        }
    });
    
    // Cerrar modales al hacer clic fuera
    document.getElementById('modalEntrada').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalEntrada();
        }
    });
    
    document.getElementById('modalSalida').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalSalida();
        }
    });
    
    // Funciones de agrupación
    function actualizarGrupoColumnas(tipo) {
        let container, texto;
        
        if (tipo === 'entradas') {
            container = document.getElementById('grupoColumnasEntradas');
            texto = document.getElementById('textoAgruparEntradas');
        } else if (tipo === 'diesel') {
            container = document.getElementById('grupoColumnasDiesel');
            texto = document.getElementById('textoAgruparDiesel');
        } else {
            container = document.getElementById('grupoColumnasSalidas');
            texto = document.getElementById('textoAgruparSalidas');
        }
        
        if (!container) return;
        
        container.innerHTML = '';
        
        let agrupadas = tipo === 'entradas' ? columnasAgrupadasEntradas : 
                       (tipo === 'diesel' ? columnasAgrupadasDiesel : columnasAgrupadasSalidas);
        
        if (agrupadas.length === 0) {
            if (texto) texto.style.display = 'inline';
        } else {
            if (texto) texto.style.display = 'none';
            agrupadas.forEach(col => {
                const chip = document.createElement('span');
                chip.className = 'columna-agrupada';
                chip.innerHTML = `${col} <span class="remover" onclick="removerColumna('${tipo}', '${col}')">&times;</span>`;
                container.appendChild(chip);
            });
        }
    }

    window.removerColumna = function(tipo, columna) {
        if (tipo === 'entradas') {
            columnasAgrupadasEntradas = columnasAgrupadasEntradas.filter(c => c !== columna);
            actualizarGrupoColumnas('entradas');
        } else if (tipo === 'diesel') {
            columnasAgrupadasDiesel = columnasAgrupadasDiesel.filter(c => c !== columna);
            actualizarGrupoColumnas('diesel');
        } else {
            columnasAgrupadasSalidas = columnasAgrupadasSalidas.filter(c => c !== columna);
            actualizarGrupoColumnas('salidas');
        }
    };

    // Drag & drop
    document.addEventListener('dragstart', (e) => {
        if (e.target.tagName === 'TH' && e.target.draggable) {
            e.dataTransfer.setData('text/plain', e.target.dataset.columna);
        }
    });

    document.getElementById('grupoAgrupacionEntradas')?.addEventListener('dragover', (e) => e.preventDefault());
    document.getElementById('grupoAgrupacionEntradas')?.addEventListener('drop', (e) => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadasEntradas.includes(columna)) {
            columnasAgrupadasEntradas.push(columna);
            actualizarGrupoColumnas('entradas');
            alert('Agrupando entradas por: ' + columna);
        }
    });
    
    document.getElementById('grupoAgrupacionDiesel')?.addEventListener('dragover', (e) => e.preventDefault());
    document.getElementById('grupoAgrupacionDiesel')?.addEventListener('drop', (e) => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadasDiesel.includes(columna)) {
            columnasAgrupadasDiesel.push(columna);
            actualizarGrupoColumnas('diesel');
            alert('Agrupando combustible por: ' + columna);
        }
    });
    
    document.getElementById('grupoAgrupacionSalidas')?.addEventListener('dragover', (e) => e.preventDefault());
    document.getElementById('grupoAgrupacionSalidas')?.addEventListener('drop', (e) => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadasSalidas.includes(columna)) {
            columnasAgrupadasSalidas.push(columna);
            actualizarGrupoColumnas('salidas');
            alert('Agrupando salidas por: ' + columna);
        }
    });

    // Selector de columnas
    window.toggleColumnSelector = function(tipo) {
        const selector = document.getElementById('columnSelector' + (tipo === 'entradas' ? 'Entradas' : 'Salidas'));
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
        
        if (selector.style.display === 'block') {
            const lista = document.getElementById('columnasLista' + (tipo === 'entradas' ? 'Entradas' : 'Salidas'));
            
            let columnas;
            if (tipo === 'entradas') {
                columnas = [
                    { field: 'entrada', caption: 'Entrada' },
                    { field: 'estatus', caption: 'Estatus' },
                    { field: 'fecha', caption: 'Fecha' },
                    { field: 'proveedor', caption: 'Proveedor' },
                    { field: 'codigo', caption: 'Código' },
                    { field: 'descripcion', caption: 'Descripción' },
                    { field: 'cantidad', caption: 'Cantidad' },
                    { field: 'valor_unitario', caption: 'V. Unitario' },
                    { field: 'importe', caption: 'Importe' },
                    { field: 'impuestos', caption: 'Impuestos' },
                    { field: 'total', caption: 'Total' },
                    { field: 'factura', caption: 'Factura' },
                    { field: 'referencia', caption: 'Referencia' },
                    { field: 'factura_cxp', caption: 'Factura CXP' },
                    { field: 'poliza', caption: 'Póliza' },
                    { field: 'empresa', caption: 'Empresa' },
                    { field: 'observaciones', caption: 'Observaciones' }
                ];
            } else {
                columnas = [
                    { field: 'salida', caption: 'Salida' },
                    { field: 'estatus', caption: 'Estatus' },
                    { field: 'fecha', caption: 'Fecha' },
                    { field: 'numero_parte', caption: 'Núm. Parte' },
                    { field: 'codigo', caption: 'Código' },
                    { field: 'descripcion', caption: 'Descripción' },
                    { field: 'cantidad', caption: 'Cantidad' },
                    { field: 'costo_promedio', caption: 'Costo Prom.' },
                    { field: 'importe', caption: 'Importe' },
                    { field: 'impuestos', caption: 'Impuestos' },
                    { field: 'total', caption: 'Total' },
                    { field: 'orden_servicio', caption: 'O.S.' },
                    { field: 'unidad', caption: 'Unidad' },
                    { field: 'tipo_unidad', caption: 'Tipo Unidad' },
                    { field: 'poliza', caption: 'Póliza' }
                ];
            }
            
            lista.innerHTML = columnas.map(col => `
                <div style="padding: 5px 0; display: flex; align-items: center;">
                    <input type="checkbox" 
                           id="chk_${col.field}_${tipo}"
                           data-columna="${col.field}"
                           checked
                           style="margin-right: 8px; accent-color: var(--color-primary);">
                    <label for="chk_${col.field}_${tipo}" style="font-size: 12px;">${col.caption}</label>
                </div>
            `).join('');
        }
    };

    window.cerrarColumnSelector = function(tipo) {
        document.getElementById('columnSelector' + (tipo === 'entradas' ? 'Entradas' : 'Salidas')).style.display = 'none';
    };

    // Cerrar selectores al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#btnColumnasEntradas') && !e.target.closest('#columnSelectorEntradas')) {
            document.getElementById('columnSelectorEntradas').style.display = 'none';
        }
        if (!e.target.closest('#btnColumnasSalidas') && !e.target.closest('#columnSelectorSalidas')) {
            document.getElementById('columnSelectorSalidas').style.display = 'none';
        }
    });

    // Botones
    document.getElementById('btnCrearFiltro').addEventListener('click', () => alert('Funcionalidad de filtro en desarrollo'));
    document.getElementById('btnExcelEntradas')?.addEventListener('click', () => alert('Exportar entradas a Excel'));
    document.getElementById('btnExcelSalidas')?.addEventListener('click', () => alert('Exportar salidas a Excel'));

    // Buscadores
    document.getElementById('buscadorEntradas')?.addEventListener('input', function(e) {
        console.log('Buscando en entradas:', e.target.value);
    });
    
    document.getElementById('buscadorSalidas')?.addEventListener('input', function(e) {
        console.log('Buscando en salidas:', e.target.value);
    });
});
</script>
@endsection