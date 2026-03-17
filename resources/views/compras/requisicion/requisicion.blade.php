@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Requisiciones -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-clipboard-list" style="margin-right: 10px;"></i> Requisiciones
                </h2>
            </div>

            <div class="card-body p-4">
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
                                    title="Agregar requisición"
                                    onclick="abrirModalRequisicion()">
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
                            <input type="text" id="buscador" placeholder="Buscar requisición..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Requisiciones -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaRequisiciones" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 900px;">
                        <thead style="background-color: var(--color-primary); position: sticky; top: 0; z-index: 20;">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 10%;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 15%;" draggable="true" data-columna="requisicion">Requisición</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 15%;" draggable="true" data-columna="fecha">Fecha Requerimiento</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 20%;" draggable="true" data-columna="solicitante">Solicitante</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 20%;" draggable="true" data-columna="area">Área</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 10%;" draggable="true" data-columna="cotizadas">Cotizadas</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1); width: 10%;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">REQ-001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JUAN PÉREZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Operaciones</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">3</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle REQ-001')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRequisicion('REQ-001')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar requisición?')) alert('Requisición eliminada')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Pendiente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">REQ-002</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">14/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">MARÍA GARCÍA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Proyectos</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">0</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle REQ-002')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRequisicion('REQ-002')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar requisición?')) alert('Requisición eliminada')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">REQ-003</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">13/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">CARLOS LÓPEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">2</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle REQ-003')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRequisicion('REQ-003')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar requisición?')) alert('Requisición eliminada')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Pendiente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">REQ-004</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">12/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ANA MARTÍNEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Recursos Humanos</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">0</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle REQ-004')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRequisicion('REQ-004')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar requisición?')) alert('Requisición eliminada')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">REQ-005</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">11/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ROBERTO SÁNCHEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Compras</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">4</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle REQ-005')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRequisicion('REQ-005')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar requisición?')) alert('Requisición eliminada')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">REQ-006</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">10/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">LAURA FLORES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Finanzas</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">2</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle REQ-006')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRequisicion('REQ-006')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar requisición?')) alert('Requisición eliminada')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Pendiente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">REQ-007</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">09/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JOSÉ TORRES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Mantenimiento</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">0</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle REQ-007')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRequisicion('REQ-007')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar requisición?')) alert('Requisición eliminada')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">REQ-008</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">08/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">PATRICIA CASTILLO</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Calidad</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">1</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle REQ-008')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRequisicion('REQ-008')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar requisición?')) alert('Requisición eliminada')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">REQ-009</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">07/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">FERNANDO GONZÁLEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Sistemas</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">2</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle REQ-009')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRequisicion('REQ-009')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar requisición?')) alert('Requisición eliminada')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Pendiente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">REQ-010</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">06/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">GABRIELA NAVARRO</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Legal</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">0</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle REQ-010')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRequisicion('REQ-010')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar requisición?')) alert('Requisición eliminada')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="7" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 13px;">Total Requisiciones: 10</td>
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

<!-- MODAL PARA AGREGAR/EDITAR REQUISICIÓN -->
<div id="modalRequisicion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 900px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTituloRequisicion">Nueva Requisición</h3>
            <button onclick="cerrarModalRequisicion()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <!-- Datos generales -->
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <h4 style="color: var(--color-primary); font-size: 15px; margin: 0 0 15px 0;">
                    <i class="fas fa-info-circle"></i> General
                </h4>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Folio</label>
                        <input type="text" id="modalFolioRequisicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="REQ-011">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Fecha Requerimiento</label>
                        <input type="date" id="modalFechaRequisicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d') }}">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Estatus</label>
                        <select id="modalEstatusRequisicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option>Activo</option>
                            <option>Pendiente</option>
                            <option>Cotizado</option>
                            <option>Cancelado</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Responsable</label>
                        <select id="modalResponsableRequisicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option>Seleccionar responsable</option>
                            <option>JUAN PÉREZ</option>
                            <option>MARÍA GARCÍA</option>
                            <option>CARLOS LÓPEZ</option>
                            <option>ANA MARTÍNEZ</option>
                            <option>ROBERTO SÁNCHEZ</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Área</label>
                        <select id="modalAreaRequisicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option>Seleccionar área</option>
                            <option>Operaciones</option>
                            <option>Proyectos</option>
                            <option>Almacén</option>
                            <option>Recursos Humanos</option>
                            <option>Compras</option>
                            <option>Finanzas</option>
                            <option>Mantenimiento</option>
                            <option>Calidad</option>
                            <option>Sistemas</option>
                            <option>Legal</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Cotizadas</label>
                        <input type="number" id="modalCotizadasRequisicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0" value="0" readonly>
                    </div>
                </div>
            </div>
            
            <!-- Artículos de la requisición -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <h4 style="color: var(--color-primary); font-size: 15px; margin: 0;">
                        <i class="fas fa-box"></i> Artículos Solicitados
                    </h4>
                    <button id="btnAgregarArticulo" style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 6px 12px; cursor: pointer; font-size: 12px; display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-plus"></i> Agregar Artículo
                    </button>
                </div>
                
                <!-- Tabla de artículos -->
                <div style="border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                        <thead style="background-color: #f8f9fa;">
                            <tr>
                                <th style="padding: 10px; text-align: left; border-bottom: 1px solid #dee2e6;">Código</th>
                                <th style="padding: 10px; text-align: left; border-bottom: 1px solid #dee2e6;">Cantidad</th>
                                <th style="padding: 10px; text-align: left; border-bottom: 1px solid #dee2e6;">Unidad Medida</th>
                                <th style="padding: 10px; text-align: left; border-bottom: 1px solid #dee2e6;">Descripción</th>
                                <th style="padding: 10px; text-align: left; border-bottom: 1px solid #dee2e6;">Observación</th>
                                <th style="padding: 10px; text-align: center; border-bottom: 1px solid #dee2e6;">Pendiente</th>
                                <th style="padding: 10px; text-align: center; border-bottom: 1px solid #dee2e6;"></th>
                            </tr>
                        </thead>
                        <tbody id="tablaArticulosRequisicion">
                            <tr>
                                <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">
                                    <input type="text" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="HERR-001">
                                </td>
                                <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">
                                    <input type="number" style="width: 80px; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" value="1">
                                </td>
                                <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">
                                    <select style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;">
                                        <option>Pieza</option>
                                        <option>Kilogramo</option>
                                        <option>Litro</option>
                                        <option>Metro</option>
                                        <option>Caja</option>
                                    </select>
                                </td>
                                <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">
                                    <input type="text" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" value="Taladro Percutor 1/2&quot;">
                                </td>
                                <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">
                                    <input type="text" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones">
                                </td>
                                <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                                    <input type="checkbox" style="accent-color: var(--color-primary);" checked>
                                </td>
                                <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                                    <i class="fas fa-trash" style="color: #dc3545; cursor: pointer;"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">
                                    <input type="text" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="MAT-001">
                                </td>
                                <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">
                                    <input type="number" style="width: 80px; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" value="50">
                                </td>
                                <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">
                                    <select style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;">
                                        <option>Kilogramo</option>
                                        <option>Pieza</option>
                                        <option>Litro</option>
                                        <option>Metro</option>
                                        <option>Caja</option>
                                    </select>
                                </td>
                                <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">
                                    <input type="text" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" value="Cemento Gris 50kg">
                                </td>
                                <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">
                                    <input type="text" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" value="Para obra TRC001">
                                </td>
                                <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                                    <input type="checkbox" style="accent-color: var(--color-primary);">
                                </td>
                                <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                                    <i class="fas fa-trash" style="color: #dc3545; cursor: pointer;"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">
                                    <input type="text" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="EQP-001">
                                </td>
                                <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">
                                    <input type="number" style="width: 80px; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" value="2">
                                </td>
                                <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">
                                    <select style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;">
                                        <option>Pieza</option>
                                        <option>Kilogramo</option>
                                        <option>Litro</option>
                                        <option>Metro</option>
                                        <option>Caja</option>
                                    </select>
                                </td>
                                <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">
                                    <input type="text" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" value="Andamio Metálico 3m">
                                </td>
                                <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">
                                    <input type="text" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" value="Para fachada">
                                </td>
                                <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                                    <input type="checkbox" style="accent-color: var(--color-primary);" checked>
                                </td>
                                <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                                    <i class="fas fa-trash" style="color: #dc3545; cursor: pointer;"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Observaciones generales -->
                <div style="margin-top: 15px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Observaciones Generales</label>
                    <textarea id="modalObservacionesRequisicion" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones generales de la requisición..."></textarea>
                </div>
            </div>
            
            <!-- Botones del modal -->
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalRequisicion()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarRequisicion()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
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
    
    .table td:last-child i.fa-edit,
    .table td:last-child i.fa-eye {
        color: var(--color-primary);
    }
    
    .table td:last-child i.fa-trash,
    .table td:last-child i.fa-file-pdf {
        color: #dc3545;
    }
    
    /* Badges de estatus */
    .badge-activo {
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
    
    .badge-cotizadas {
        background-color: #17a2b8;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 30px;
        text-align: center;
    }
    
    .badge-sin-cotizar {
        background-color: #6c757d;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 30px;
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
    #modalRequisicion {
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
        
        #modalRequisicion > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        #modalRequisicion div[style*="grid-template-columns: repeat(3, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        
        #modalRequisicion table {
            font-size: 11px;
        }
        
        #modalRequisicion input[type="text"],
        #modalRequisicion input[type="number"],
        #modalRequisicion select {
            font-size: 11px;
            padding: 4px;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadas = [];
    
    // Función para abrir modal de nueva requisición
    window.abrirModalRequisicion = function() {
        document.getElementById('modalTituloRequisicion').textContent = 'Nueva Requisición';
        document.getElementById('modalFolioRequisicion').value = '';
        document.getElementById('modalFechaRequisicion').value = new Date().toISOString().split('T')[0];
        document.getElementById('modalEstatusRequisicion').value = 'Pendiente';
        document.getElementById('modalResponsableRequisicion').value = 'Seleccionar responsable';
        document.getElementById('modalAreaRequisicion').value = 'Seleccionar área';
        document.getElementById('modalCotizadasRequisicion').value = '0';
        document.getElementById('modalObservacionesRequisicion').value = '';
        document.getElementById('modalRequisicion').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    // Función para editar requisición
    window.editarRequisicion = function(folio) {
        document.getElementById('modalTituloRequisicion').textContent = 'Editar Requisición ' + folio;
        
        // Simular carga de datos según el folio
        if (folio === 'REQ-001') {
            document.getElementById('modalFolioRequisicion').value = 'REQ-001';
            document.getElementById('modalFechaRequisicion').value = '2025-03-15';
            document.getElementById('modalEstatusRequisicion').value = 'Activo';
            document.getElementById('modalResponsableRequisicion').value = 'JUAN PÉREZ';
            document.getElementById('modalAreaRequisicion').value = 'Operaciones';
            document.getElementById('modalCotizadasRequisicion').value = '3';
            document.getElementById('modalObservacionesRequisicion').value = 'Requisición urgente para obra';
        } else if (folio === 'REQ-002') {
            document.getElementById('modalFolioRequisicion').value = 'REQ-002';
            document.getElementById('modalFechaRequisicion').value = '2025-03-14';
            document.getElementById('modalEstatusRequisicion').value = 'Pendiente';
            document.getElementById('modalResponsableRequisicion').value = 'MARÍA GARCÍA';
            document.getElementById('modalAreaRequisicion').value = 'Proyectos';
            document.getElementById('modalCotizadasRequisicion').value = '0';
            document.getElementById('modalObservacionesRequisicion').value = 'Pendiente de autorización';
        } else {
            document.getElementById('modalFolioRequisicion').value = folio;
            document.getElementById('modalFechaRequisicion').value = '2025-03-10';
            document.getElementById('modalEstatusRequisicion').value = 'Pendiente';
            document.getElementById('modalResponsableRequisicion').value = 'JUAN PÉREZ';
            document.getElementById('modalAreaRequisicion').value = 'Operaciones';
            document.getElementById('modalCotizadasRequisicion').value = '1';
            document.getElementById('modalObservacionesRequisicion').value = '';
        }
        
        document.getElementById('modalRequisicion').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalRequisicion = function() {
        document.getElementById('modalRequisicion').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.guardarRequisicion = function() {
        const folio = document.getElementById('modalFolioRequisicion').value;
        const responsable = document.getElementById('modalResponsableRequisicion').value;
        const area = document.getElementById('modalAreaRequisicion').value;
        
        if (!folio || responsable === 'Seleccionar responsable' || area === 'Seleccionar área') {
            alert('Por favor complete los campos obligatorios');
            return;
        }
        
        alert(`Requisición ${folio} guardada correctamente`);
        cerrarModalRequisicion();
    };
    
    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalRequisicion();
        }
    });
    
    // Cerrar modal al hacer clic fuera
    document.getElementById('modalRequisicion').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalRequisicion();
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
                { field: 'requisicion', caption: 'Requisición' },
                { field: 'fecha', caption: 'Fecha Requerimiento' },
                { field: 'solicitante', caption: 'Solicitante' },
                { field: 'area', caption: 'Área' },
                { field: 'cotizadas', caption: 'Cotizadas' }
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
    document.getElementById('btnExcel').addEventListener('click', () => alert('Exportar requisiciones a Excel'));

    // Buscador
    document.getElementById('buscador').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        console.log('Buscando en requisiciones:', termino);
    });
    
    // Botón agregar artículo (simulado)
    document.getElementById('btnAgregarArticulo').addEventListener('click', function() {
        alert('Funcionalidad para agregar más artículos');
    });
});
</script>
@endsection