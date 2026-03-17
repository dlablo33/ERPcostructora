@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Bitácora de Uso - Unidades y Flotilla -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-clipboard-list" style="margin-right: 10px;"></i> Bitácora de Uso - Unidades y Flotilla
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros de búsqueda -->
                <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Fecha Inicio</label>
                        <input type="date" class="form-control" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;" value="2025-03-01">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Fecha Fin</label>
                        <input type="date" class="form-control" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;" value="2025-03-06">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Unidad</label>
                        <select style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                            <option>Todas</option>
                            <option>UN-001</option>
                            <option>UN-002</option>
                            <option>UN-003</option>
                            <option>UN-004</option>
                            <option>UN-005</option>
                            <option>UN-006</option>
                            <option>UN-007</option>
                            <option>UN-008</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Operador</label>
                        <select style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                            <option>Todos</option>
                            <option>JUAN PÉREZ</option>
                            <option>MARÍA GARCÍA</option>
                            <option>CARLOS LÓPEZ</option>
                            <option>ANA MARTÍNEZ</option>
                            <option>ROBERTO SÁNCHEZ</option>
                            <option>LAURA FLORES</option>
                            <option>JOSÉ TORRES</option>
                            <option>PATRICIA CASTILLO</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Tipo</label>
                        <select style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                            <option>Todos</option>
                            <option>Salida</option>
                            <option>Regreso</option>
                            <option>Carga Combustible</option>
                            <option>Mantenimiento</option>
                            <option>Incidencia</option>
                        </select>
                    </div>
                    <div style="display: flex; align-items: flex-end;">
                        <button id="btnFiltrar" style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 13px; width: 100%;">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
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
                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Excel</span>
                            </button>
                        </div>

                        <!-- Botón Imprimir -->
                        <div>
                            <button id="btnImprimir" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                <i class="fas fa-print" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Imprimir</span>
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
                            <input type="text" id="buscador" placeholder="Buscar en bitácora..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Bitácora de Uso -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%; max-height: 550px; overflow-y: auto;">
                    <table class="table" id="tablaBitacora" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1300px;">
                        <thead style="background-color: var(--color-primary); position: sticky; top: 0; z-index: 20;">
                            <tr>
                                <th style="padding: 10px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="folio">Folio</th>
                                <th style="padding: 10px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha">Fecha/Hora</th>
                                <th style="padding: 10px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="unidad">Unidad</th>
                                <th style="padding: 10px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="operador">Operador</th>
                                <th style="padding: 10px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="tipo">Tipo</th>
                                <th style="padding: 10px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="origen">Origen</th>
                                <th style="padding: 10px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="destino">Destino</th>
                                <th style="padding: 10px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="km_inicial">Km Inicial</th>
                                <th style="padding: 10px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="km_final">Km Final</th>
                                <th style="padding: 10px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="km_recorridos">Km Recorridos</th>
                                <th style="padding: 10px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="combustible">Combustible (L)</th>
                                <th style="padding: 10px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="observaciones">Observaciones</th>
                                <th style="padding: 10px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- Registros de bitácora -->
                            <tr>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">B-2025-001</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">06/03/2025 08:15</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">UN-001</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">JUAN PÉREZ</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 3px 6px; border-radius: 3px; font-size: 10px;">Salida</span>
                                </td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Base MTY</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Obra Apodaca</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">45,230</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">45,275</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">45</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">0</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Salida a obra</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')" title="Editar"></i>
                                    <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Imprimir')" title="Imprimir"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">B-2025-002</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">06/03/2025 09:30</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">UN-002</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">MARÍA GARCÍA</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 3px 6px; border-radius: 3px; font-size: 10px;">Salida</span>
                                </td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Base MTY</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Proveedor</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">128,450</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">128,520</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">70</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">0</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Compra de materiales</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')" title="Editar"></i>
                                    <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Imprimir')" title="Imprimir"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">B-2025-003</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">06/03/2025 10:45</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">UN-005</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">ROBERTO SÁNCHEZ</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 3px 6px; border-radius: 3px; font-size: 10px;">Carga Combustible</span>
                                </td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Gasolinera</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Gasolinera</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">156,780</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">156,780</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">0</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">150</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Carga de diésel</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')" title="Editar"></i>
                                    <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Imprimir')" title="Imprimir"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">B-2025-004</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">06/03/2025 12:00</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">UN-001</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">JUAN PÉREZ</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 3px 6px; border-radius: 3px; font-size: 10px;">Regreso</span>
                                </td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Obra Apodaca</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Base MTY</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">45,275</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">45,320</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">45</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">0</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Regreso a base</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')" title="Editar"></i>
                                    <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Imprimir')" title="Imprimir"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">B-2025-005</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">06/03/2025 13:20</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">UN-003</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">CARLOS LÓPEZ</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #17a2b8; color: white; padding: 3px 6px; border-radius: 3px; font-size: 10px;">Mantenimiento</span>
                                </td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Taller</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Taller</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">67,890</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">67,890</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">0</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">0</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Cambio de aceite</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')" title="Editar"></i>
                                    <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Imprimir')" title="Imprimir"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">B-2025-006</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">06/03/2025 14:45</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">UN-004</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">ANA MARTÍNEZ</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 3px 6px; border-radius: 3px; font-size: 10px;">Salida</span>
                                </td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Base MTY</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Oficina Cliente</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">89,120</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">89,180</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">60</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">0</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Reunión con cliente</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')" title="Editar"></i>
                                    <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Imprimir')" title="Imprimir"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">B-2025-007</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">05/03/2025 07:30</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">UN-001</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">JUAN PÉREZ</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 3px 6px; border-radius: 3px; font-size: 10px;">Salida</span>
                                </td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Base MTY</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Obra Apodaca</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">45,185</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">45,230</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">45</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">0</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Salida a obra</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')" title="Editar"></i>
                                    <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Imprimir')" title="Imprimir"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">B-2025-008</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">05/03/2025 08:45</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">UN-002</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">MARÍA GARCÍA</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 3px 6px; border-radius: 3px; font-size: 10px;">Carga Combustible</span>
                                </td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Gasolinera</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Gasolinera</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">128,380</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">128,380</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">0</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">200</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Carga de gasolina</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')" title="Editar"></i>
                                    <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Imprimir')" title="Imprimir"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">B-2025-009</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">05/03/2025 10:15</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">UN-005</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">ROBERTO SÁNCHEZ</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 3px 6px; border-radius: 3px; font-size: 10px;">Salida</span>
                                </td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Base MTY</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Obra Escobedo</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">156,680</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">156,780</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">100</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">0</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Traslado de materiales</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')" title="Editar"></i>
                                    <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Imprimir')" title="Imprimir"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">B-2025-010</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">05/03/2025 12:30</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">UN-001</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">JUAN PÉREZ</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 3px 6px; border-radius: 3px; font-size: 10px;">Regreso</span>
                                </td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Obra Apodaca</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Base MTY</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">45,230</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">45,275</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">45</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">0</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Regreso a base</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')" title="Editar"></i>
                                    <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Imprimir')" title="Imprimir"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">B-2025-011</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">05/03/2025 14:00</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">UN-002</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">MARÍA GARCÍA</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 3px 6px; border-radius: 3px; font-size: 10px;">Regreso</span>
                                </td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Proveedor</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Base MTY</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">128,520</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">128,590</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">70</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">0</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Regreso de compras</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')" title="Editar"></i>
                                    <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Imprimir')" title="Imprimir"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">B-2025-012</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">05/03/2025 15:30</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">UN-003</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">CARLOS LÓPEZ</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 3px 6px; border-radius: 3px; font-size: 10px;">Salida</span>
                                </td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Taller</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Base MTY</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">67,890</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">67,910</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">20</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">0</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Regreso de taller</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')" title="Editar"></i>
                                    <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Imprimir')" title="Imprimir"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">B-2025-013</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">04/03/2025 09:00</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">UN-004</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">ANA MARTÍNEZ</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 3px 6px; border-radius: 3px; font-size: 10px;">Salida</span>
                                </td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Base MTY</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Proveedor</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">89,050</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">89,120</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">70</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">0</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Compra de materiales</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')" title="Editar"></i>
                                    <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Imprimir')" title="Imprimir"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">B-2025-014</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">04/03/2025 11:30</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">UN-005</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">ROBERTO SÁNCHEZ</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 3px 6px; border-radius: 3px; font-size: 10px;">Carga Combustible</span>
                                </td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Gasolinera</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Gasolinera</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">156,680</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">156,680</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">0</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">180</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Carga de diésel</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')" title="Editar"></i>
                                    <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Imprimir')" title="Imprimir"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">B-2025-015</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">04/03/2025 13:45</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">UN-001</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">JUAN PÉREZ</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 3px 6px; border-radius: 3px; font-size: 10px;">Regreso</span>
                                </td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Obra Apodaca</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Base MTY</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">45,140</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">45,185</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">45</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">0</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Regreso a base</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')" title="Editar"></i>
                                    <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Imprimir')" title="Imprimir"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">B-2025-016</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">04/03/2025 15:00</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">UN-002</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">MARÍA GARCÍA</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 3px 6px; border-radius: 3px; font-size: 10px;">Salida</span>
                                </td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Base MTY</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Obra Escobedo</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">128,590</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">128,690</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">100</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: right;">0</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: left;">Entrega de materiales</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')" title="Editar"></i>
                                    <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Imprimir')" title="Imprimir"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Resumen y paginación -->
                <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <div style="display: flex; gap: 20px; align-items: center;">
                        <span style="font-size: 13px; color: #6c757d;">
                            Mostrando <span id="registrosMostrados">16</span> de <span id="totalRegistros">16</span> registros
                        </span>
                        <span style="font-size: 13px;">
                            <strong>Total Km:</strong> <span id="totalKm">585</span> km
                        </span>
                        <span style="font-size: 13px;">
                            <strong>Total Combustible:</strong> <span id="totalCombustible">530</span> L
                        </span>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <button class="page-btn" style="width: 32px; height: 32px; border: 1px solid var(--color-primary); border-radius: 4px; background: transparent; cursor: pointer; color: var(--color-primary);" id="btnPrimera" disabled>
                            <i class="fas fa-angle-double-left"></i>
                        </button>
                        <button class="page-btn" style="width: 32px; height: 32px; border: 1px solid var(--color-primary); border-radius: 4px; background: transparent; cursor: pointer; color: var(--color-primary);" id="btnAnterior" disabled>
                            <i class="fas fa-angle-left"></i>
                        </button>
                        <span style="padding: 5px 12px; background-color: var(--color-primary); color: white; border-radius: 4px; font-size: 13px;">1</span>
                        <span style="font-size: 13px; color: #6c757d;">de 1</span>
                        <button class="page-btn" style="width: 32px; height: 32px; border: 1px solid var(--color-primary); border-radius: 4px; background: transparent; cursor: pointer; color: var(--color-primary);" id="btnSiguiente" disabled>
                            <i class="fas fa-angle-right"></i>
                        </button>
                        <button class="page-btn" style="width: 32px; height: 32px; border: 1px solid var(--color-primary); border-radius: 4px; background: transparent; cursor: pointer; color: var(--color-primary);" id="btnUltima" disabled>
                            <i class="fas fa-angle-double-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA DETALLE DE REGISTRO -->
<div id="modalDetalleRegistro" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 600px; max-height: 80vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Detalle de Registro - <span id="modalFolio">B-2025-001</span></h3>
            <button onclick="cerrarModalDetalle()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;" id="modalContenido">
            <!-- Contenido dinámico -->
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
        max-height: 550px;
        overflow-y: auto;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        scrollbar-width: thin;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        min-width: 1300px;
    }

    .table th {
        background-color: var(--color-primary) !important;
        color: white;
        padding: 10px 8px;
        border: 1px solid #dee2e6;
        font-size: 12px;
        white-space: nowrap;
        text-align: center;
        font-weight: 600;
    }
    
    .table td {
        padding: 8px;
        border: 1px solid #dee2e6;
        font-size: 12px;
        vertical-align: middle;
    }
    
    /* Filas alternadas */
    #tablaBody tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    #tablaBody tr:hover {
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
    
    #tablaBody tr:nth-child(even) td:last-child {
        background-color: #f8f9fa !important;
    }
    
    #tablaBody tr:hover td:last-child {
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
    #modalDetalleRegistro {
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
        
        div[style*="grid-template-columns: repeat(6, 1fr)"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        .table-container {
            max-height: 400px;
        }
        
        .table td {
            padding: 6px 4px;
            font-size: 11px;
        }
        
        .table td:last-child i {
            margin: 0 3px;
            font-size: 11px;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadas = [];
    
    // Función para mostrar detalle
    window.verDetalle = function(folio) {
        const modal = document.getElementById('modalDetalleRegistro');
        document.getElementById('modalFolio').textContent = folio;
        
        // Buscar el registro (simulado)
        let contenido = '<p><strong>Información completa del registro:</strong></p>';
        contenido += '<table style="width:100%; border-collapse:collapse;">';
        contenido += '<tr><td style="padding:8px; border:1px solid #dee2e6;"><strong>Folio:</strong></td><td style="padding:8px; border:1px solid #de2e6;">' + folio + '</td></tr>';
        contenido += '<tr><td style="padding:8px; border:1px solid #dee2e6;"><strong>Fecha/Hora:</strong></td><td style="padding:8px; border:1px solid #de2e6;">06/03/2025 08:15</td></tr>';
        contenido += '<tr><td style="padding:8px; border:1px solid #dee2e6;"><strong>Unidad:</strong></td><td style="padding:8px; border:1px solid #de2e6;">UN-001</td></tr>';
        contenido += '<tr><td style="padding:8px; border:1px solid #dee2e6;"><strong>Operador:</strong></td><td style="padding:8px; border:1px solid #de2e6;">JUAN PÉREZ</td></tr>';
        contenido += '<tr><td style="padding:8px; border:1px solid #dee2e6;"><strong>Tipo:</strong></td><td style="padding:8px; border:1px solid #de2e6;">Salida</td></tr>';
        contenido += '<tr><td style="padding:8px; border:1px solid #dee2e6;"><strong>Origen:</strong></td><td style="padding:8px; border:1px solid #de2e6;">Base MTY</td></tr>';
        contenido += '<tr><td style="padding:8px; border:1px solid #dee2e6;"><strong>Destino:</strong></td><td style="padding:8px; border:1px solid #de2e6;">Obra Apodaca</td></tr>';
        contenido += '<tr><td style="padding:8px; border:1px solid #dee2e6;"><strong>Km Inicial:</strong></td><td style="padding:8px; border:1px solid #de2e6;">45,230</td></tr>';
        contenido += '<tr><td style="padding:8px; border:1px solid #dee2e6;"><strong>Km Final:</strong></td><td style="padding:8px; border:1px solid #de2e6;">45,275</td></tr>';
        contenido += '<tr><td style="padding:8px; border:1px solid #dee2e6;"><strong>Km Recorridos:</strong></td><td style="padding:8px; border:1px solid #de2e6;">45</td></tr>';
        contenido += '<tr><td style="padding:8px; border:1px solid #dee2e6;"><strong>Combustible:</strong></td><td style="padding:8px; border:1px solid #de2e6;">0 L</td></tr>';
        contenido += '<tr><td style="padding:8px; border:1px solid #dee2e6;"><strong>Observaciones:</strong></td><td style="padding:8px; border:1px solid #de2e6;">Salida a obra</td></tr>';
        contenido += '</table>';
        
        document.getElementById('modalContenido').innerHTML = contenido;
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalDetalle = function() {
        document.getElementById('modalDetalleRegistro').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalDetalle();
        }
    });
    
    // Cerrar modal al hacer clic fuera
    document.getElementById('modalDetalleRegistro').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalDetalle();
        }
    });
    
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
                { field: 'fecha', caption: 'Fecha/Hora' },
                { field: 'unidad', caption: 'Unidad' },
                { field: 'operador', caption: 'Operador' },
                { field: 'tipo', caption: 'Tipo' },
                { field: 'origen', caption: 'Origen' },
                { field: 'destino', caption: 'Destino' },
                { field: 'km_inicial', caption: 'Km Inicial' },
                { field: 'km_final', caption: 'Km Final' },
                { field: 'km_recorridos', caption: 'Km Recorridos' },
                { field: 'combustible', caption: 'Combustible' },
                { field: 'observaciones', caption: 'Observaciones' }
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
    document.getElementById('btnFiltrar').addEventListener('click', () => alert('Filtros aplicados'));
    document.getElementById('btnExcel').addEventListener('click', () => alert('Exportando a Excel'));
    document.getElementById('btnImprimir').addEventListener('click', () => alert('Enviando a impresión'));
    document.getElementById('buscador').addEventListener('input', function() {
        console.log('Buscando:', this.value);
    });
});
</script>
@endsection