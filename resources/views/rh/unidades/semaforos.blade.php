@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Semáforo de Documentos Unidades -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Semáforo de Documentos Unidades
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- KPIs -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px; width: 100%;">
                    <!-- Total Documentos -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 15px 0; background-color: #2378e1; width: 100%; text-align: center;">
                        <div style="font-size: 16px; font-weight: 500; color: white; margin-bottom: 5px;">Total Documentos</div>
                        <div style="font-size: 42px; font-weight: bold; line-height: 1.2; color: white;">9</div>
                    </div>

                    <!-- Vigentes -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 15px 0; background-color: #28a745; width: 100%; text-align: center;">
                        <div style="font-size: 16px; font-weight: 500; color: white; margin-bottom: 5px;">Vigentes</div>
                        <div style="font-size: 42px; font-weight: bold; line-height: 1.2; color: white;">0</div>
                    </div>

                    <!-- Por Vencer -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 15px 0; background-color: #ffc107; width: 100%; text-align: center;">
                        <div style="font-size: 16px; font-weight: 500; color: #212529; margin-bottom: 5px;">Por Vencer</div>
                        <div style="font-size: 42px; font-weight: bold; line-height: 1.2; color: #212529;">0</div>
                    </div>

                    <!-- Vencidos -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 15px 0; background-color: #dc3545; width: 100%; text-align: center;">
                        <div style="font-size: 16px; font-weight: 500; color: white; margin-bottom: 5px;">Vencidos</div>
                        <div style="font-size: 42px; font-weight: bold; line-height: 1.2; color: white;">8</div>
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
                                    title="Agregar documento"
                                    onclick="abrirModalDocumentoUnidad()">
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
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 250px; max-height: 350px; overflow-y: auto;">
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
                            <input type="text" id="buscador" placeholder="Buscar por unidad, documento..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Documentos de Unidades -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaDocumentosUnidades" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 800px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="unidad">Unidad</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="documento">Documento</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_vencimiento">Fecha de Vencimiento</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="dias">Días</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">04</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">TARJETA DE CIRCULACION</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">20/6/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #dc3545; font-weight: bold;">-259</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Vencido</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle unidad 04')"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar documento unidad 04')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar documento?')) alert('Documento eliminado')"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF unidad 04')"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">04</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">TARJETA DE CIRCULACION</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">19/6/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #dc3545; font-weight: bold;">-260</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Vencido</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle unidad 04')"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar documento unidad 04')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar documento?')) alert('Documento eliminado')"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF unidad 04')"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">04</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">TARJETA DE CIRCULACION</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">18/6/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #dc3545; font-weight: bold;">-261</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Vencido</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle unidad 04')"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar documento unidad 04')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar documento?')) alert('Documento eliminado')"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF unidad 04')"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">04</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">TARJETA DE CIRCULACION</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">20/6/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #dc3545; font-weight: bold;">-259</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Vencido</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle unidad 04')"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar documento unidad 04')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar documento?')) alert('Documento eliminado')"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF unidad 04')"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">04</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">TARJETA DE CIRCULACION</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">18/6/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #dc3545; font-weight: bold;">-261</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Vencido</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle unidad 04')"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar documento unidad 04')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar documento?')) alert('Documento eliminado')"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF unidad 04')"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">04</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">TARJETA DE CIRCULACION</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">19/7/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #dc3545; font-weight: bold;">-230</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Vencido</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle unidad 04')"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar documento unidad 04')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar documento?')) alert('Documento eliminado')"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF unidad 04')"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">04</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">TARJETA DE CIRCULACION</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">19/6/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #dc3545; font-weight: bold;">-260</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Vencido</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle unidad 04')"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar documento unidad 04')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar documento?')) alert('Documento eliminado')"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF unidad 04')"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">T01</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">TARJETA DE CIRCULACION</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">10/7/2023</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #dc3545; font-weight: bold;">-970</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Vencido</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle unidad T01')"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar documento unidad T01')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar documento?')) alert('Documento eliminado')"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF unidad T01')"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">T01</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">PLACAS</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">10/7/2028</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #28a745; font-weight: bold;">857</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Vigente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle unidad T01')"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar documento unidad T01')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar documento?')) alert('Documento eliminado')"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF unidad T01')"></i>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot style="background-color: #f8f9fa;">
                            <tr>
                                <td colspan="6" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-weight: bold; font-size: 13px;">Total Documentos: 9 | Vigentes: 1 | Vencidos: 8</td>
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

<!-- MODAL PARA NUEVO DOCUMENTO DE UNIDAD -->
<div id="modalDocumentoUnidad" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 500px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Nuevo Documento de Unidad</h3>
            <button onclick="cerrarModalDocumentoUnidad()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Unidad</label>
                    <input type="text" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: 04, T01">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Documento</label>
                    <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>TARJETA DE CIRCULACION</option>
                        <option>PLACAS</option>
                        <option>SEGURO</option>
                        <option>TENENCIA</option>
                        <option>VERIFICACION</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha de Vencimiento</label>
                    <input type="date" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Días</label>
                    <input type="number" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus</label>
                    <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Vigente</option>
                        <option>Por Vencer</option>
                        <option>Vencido</option>
                    </select>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalDocumentoUnidad()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="alert('Documento de unidad guardado')" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
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
        min-width: 800px;
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
    .table td:nth-child(5) {
        text-align: center;
    }
    
    .table td:nth-child(4) {
        text-align: center;
        font-weight: bold;
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
    .badge-vigente {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-por-vencer {
        background-color: #ffc107;
        color: #212529;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-vencido {
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
    
    /* Modal */
    #modalDocumentoUnidad {
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
        
        #modalDocumentoUnidad > div {
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
                { field: 'unidad', caption: 'Unidad' },
                { field: 'documento', caption: 'Documento' },
                { field: 'fecha_vencimiento', caption: 'Fecha Vencimiento' },
                { field: 'dias', caption: 'Días' },
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

// Funciones del modal
function abrirModalDocumentoUnidad() {
    document.getElementById('modalDocumentoUnidad').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalDocumentoUnidad() {
    document.getElementById('modalDocumentoUnidad').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Cerrar modal con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalDocumentoUnidad();
    }
});

// Cerrar modal al hacer clic fuera
document.getElementById('modalDocumentoUnidad').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalDocumentoUnidad();
    }
});
</script>
@endsection