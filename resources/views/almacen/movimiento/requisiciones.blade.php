@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Requisición y Devolución de Equipo -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Requisición y Devolución de Equipo
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
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Proyecto</label>
                        <select style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                            <option>Todos los proyectos</option>
                            <option>TRC001 - Torre Cumbres</option>
                            <option>PAC002 - Puente Constitución</option>
                            <option>CIA003 - Complejo Apodaca</option>
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
                    <button class="tab-requisicion active" onclick="switchTab('requisiciones')" id="tabRequisiciones" style="background-color: var(--color-primary); color: white; border: none; padding: 10px 25px; border-radius: 8px 8px 0 0; margin-right: 5px; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-clipboard-list" style="margin-right: 5px;"></i> Requisiciones de Equipo
                    </button>
                    <button class="tab-devolucion" onclick="switchTab('devoluciones')" id="tabDevoluciones" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; border-radius: 8px 8px 0 0; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-undo-alt" style="margin-right: 5px;"></i> Devoluciones de Equipo
                    </button>
                </div>

                <!-- Panel de Requisiciones de Equipo -->
                <div id="panelRequisiciones" style="display: block;">
                    <!-- Barra de herramientas para Requisiciones -->
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                        <!-- Grupo de agrupación -->
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacionRequisiciones">
                            <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                            <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgruparRequisiciones">arrastra una columna aquí para agrupar</span>
                            <div id="grupoColumnasRequisiciones" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                        </div>
                        
                        <!-- Botones -->
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                            <!-- Botón Agregar (+) -->
                            <div>
                                <button id="btnAgregarRequisicion" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                        title="Agregar requisición"
                                        onclick="abrirModalRequisicion()">
                                    <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                                </button>
                            </div>

                            <!-- Botón Exportar Excel -->
                            <div>
                                <button id="btnExcelRequisiciones" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                    <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                    <span class="hide-mobile">Excel</span>
                                </button>
                            </div>

                            <!-- Botón Seleccionar Columnas -->
                            <div style="position: relative;">
                                <button id="btnColumnasRequisiciones" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                        onclick="toggleColumnSelector('requisiciones')">
                                    <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                    <span class="hide-mobile">Columnas</span>
                                </button>
                                
                                <!-- Selector de columnas para Requisiciones -->
                                <div id="columnSelectorRequisiciones" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 280px; max-height: 400px; overflow-y: auto;">
                                    <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                        <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                        <button onclick="cerrarColumnSelector('requisiciones')" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                    </div>
                                    <div id="columnasListaRequisiciones" style="padding: 10px;"></div>
                                </div>
                            </div>

                            <!-- Buscador -->
                            <div style="position: relative; min-width: 220px;">
                                <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                                <input type="text" id="buscadorRequisiciones" placeholder="Buscar requisición..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Requisiciones de Equipo -->
                    <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                        <table class="table" id="tablaRequisiciones" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1400px;">
                            <thead style="background-color: var(--color-primary); position: sticky; top: 0; z-index: 20;">
                                <tr>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="folio">Folio</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha">Fecha</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="proyecto">Proyecto</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="solicitante">Solicitante</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="equipo">Equipo</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="codigo">Código</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="cantidad">Cantidad</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_requerida">Fecha Requerida</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_asignacion">Fecha Asignación</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="prioridad">Prioridad</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="observaciones">Observaciones</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodyRequisiciones">
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">REQ-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Aprobada</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">TRC001 - Torre Cumbres</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JUAN PÉREZ</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Retroexcavadora</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">RET-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">1</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">18/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">16/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Alta</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Excavación para cimentación</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle REQ-001')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRequisicion('REQ-001')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar requisición?')) alert('Requisición eliminada')" title="Eliminar"></i>
                                        <i class="fas fa-check-circle" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="alert('Aprobar requisición')" title="Aprobar"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">REQ-002</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Pendiente</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">14/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">PAC002 - Puente Constitución</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">MARÍA GARCÍA</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Grúa Torre</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">GRU-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">1</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">17/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Media</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Izaje de vigas</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle REQ-002')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRequisicion('REQ-002')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar requisición?')) alert('Requisición eliminada')" title="Eliminar"></i>
                                        <i class="fas fa-check-circle" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="alert('Aprobar requisición')" title="Aprobar"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">REQ-003</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Aprobada</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">13/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">CIA003 - Complejo Apodaca</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">CARLOS LÓPEZ</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Montacargas</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">MON-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">2</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">16/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">14/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Baja</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Carga de materiales</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle REQ-003')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRequisicion('REQ-003')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar requisición?')) alert('Requisición eliminada')" title="Eliminar"></i>
                                        <i class="fas fa-check-circle" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="alert('Aprobar requisición')" title="Aprobar"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">REQ-004</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Rechazada</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">12/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">RHR004 - Hospital Regional</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ANA MARTÍNEZ</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Compactadora</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">COM-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">1</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Media</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Compactación de terreno</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle REQ-004')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRequisicion('REQ-004')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar requisición?')) alert('Requisición eliminada')" title="Eliminar"></i>
                                        <i class="fas fa-redo-alt" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Reenviar requisición')" title="Reenviar"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">REQ-005</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Asignada</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">11/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">VPS005 - Periférico Sur</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ROBERTO SÁNCHEZ</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Revolvedora</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">REV-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">2</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">14/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">12/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Baja</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Preparación de concreto</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle REQ-005')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRequisicion('REQ-005')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar requisición?')) alert('Requisición eliminada')" title="Eliminar"></i>
                                        <i class="fas fa-truck" style="color: #17a2b8; margin: 0 5px; cursor: pointer;" onclick="alert('Ver asignación')" title="Ver asignación"></i>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot style="background-color: #e9ecef; font-weight: bold;">
                                <tr>
                                    <td colspan="7" style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">Totales:</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">7</td>
                                    <td colspan="4" style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">Total Requisiciones: 5</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #e9ecef; box-shadow: -2px 0 5px rgba(0,0,0,0.1);"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Panel de Devoluciones de Equipo -->
                <div id="panelDevoluciones" style="display: none;">
                    <!-- Barra de herramientas para Devoluciones -->
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                        <!-- Grupo de agrupación -->
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacionDevoluciones">
                            <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                            <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgruparDevoluciones">arrastra una columna aquí para agrupar</span>
                            <div id="grupoColumnasDevoluciones" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                        </div>
                        
                        <!-- Botones -->
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                            <!-- Botón Agregar (+) -->
                            <div>
                                <button id="btnAgregarDevolucion" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                        title="Agregar devolución"
                                        onclick="abrirModalDevolucion()">
                                    <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                                </button>
                            </div>

                            <!-- Botón Exportar Excel -->
                            <div>
                                <button id="btnExcelDevoluciones" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                    <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                    <span class="hide-mobile">Excel</span>
                                </button>
                            </div>

                            <!-- Botón Seleccionar Columnas -->
                            <div style="position: relative;">
                                <button id="btnColumnasDevoluciones" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                        onclick="toggleColumnSelector('devoluciones')">
                                    <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                    <span class="hide-mobile">Columnas</span>
                                </button>
                                
                                <!-- Selector de columnas para Devoluciones -->
                                <div id="columnSelectorDevoluciones" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 280px; max-height: 400px; overflow-y: auto;">
                                    <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                        <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                        <button onclick="cerrarColumnSelector('devoluciones')" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                    </div>
                                    <div id="columnasListaDevoluciones" style="padding: 10px;"></div>
                                </div>
                            </div>

                            <!-- Buscador -->
                            <div style="position: relative; min-width: 220px;">
                                <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                                <input type="text" id="buscadorDevoluciones" placeholder="Buscar devolución..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Devoluciones de Equipo -->
                    <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                        <table class="table" id="tablaDevoluciones" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1400px;">
                            <thead style="background-color: var(--color-primary); position: sticky; top: 0; z-index: 20;">
                                <tr>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="folio">Folio</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha">Fecha</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="proyecto">Proyecto</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="responsable">Responsable</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="equipo">Equipo</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="codigo">Código</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="cantidad">Cantidad</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_salida">Fecha Salida</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_devolucion">Fecha Devolución</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="condicion">Condición</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="observaciones">Observaciones</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodyDevoluciones">
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">DEV-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Completada</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">TRC001 - Torre Cumbres</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JUAN PÉREZ</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Retroexcavadora</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">RET-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">1</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">10/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Bueno</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Equipo en buen estado</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle DEV-001')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarDevolucion('DEV-001')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar devolución?')) alert('Devolución eliminada')" title="Eliminar"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">DEV-002</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Pendiente</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">14/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">PAC002 - Puente Constitución</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">MARÍA GARCÍA</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Grúa Torre</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">GRU-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">1</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">01/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Por revisar</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Pendiente de devolución</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle DEV-002')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarDevolucion('DEV-002')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar devolución?')) alert('Devolución eliminada')" title="Eliminar"></i>
                                        <i class="fas fa-clock" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Recordatorio de devolución')" title="Recordatorio"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">DEV-003</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Completada</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">13/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">CIA003 - Complejo Apodaca</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">CARLOS LÓPEZ</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Montacargas</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">MON-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">2</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">05/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">13/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Bueno</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Ambos en buen estado</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle DEV-003')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarDevolucion('DEV-003')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar devolución?')) alert('Devolución eliminada')" title="Eliminar"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">DEV-004</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Con Daños</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">12/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">RHR004 - Hospital Regional</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ANA MARTÍNEZ</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Compactadora</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">COM-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">1</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">01/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">12/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Dañado</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Requiere mantenimiento</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle DEV-004')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarDevolucion('DEV-004')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar devolución?')) alert('Devolución eliminada')" title="Eliminar"></i>
                                        <i class="fas fa-tools" style="color: #17a2b8; margin: 0 5px; cursor: pointer;" onclick="alert('Generar orden de mantenimiento')" title="Mantenimiento"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">DEV-005</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Completada</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">11/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">VPS005 - Periférico Sur</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ROBERTO SÁNCHEZ</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Revolvedora</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">REV-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">2</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">01/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">11/03/2025</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Regular</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Una requiere mantenimiento</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle DEV-005')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarDevolucion('DEV-005')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar devolución?')) alert('Devolución eliminada')" title="Eliminar"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot style="background-color: #e9ecef; font-weight: bold;">
                                <tr>
                                    <td colspan="7" style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">Totales:</td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">7</td>
                                    <td colspan="4" style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">Total Devoluciones: 5</td>
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

<!-- MODAL PARA AGREGAR/EDITAR REQUISICIÓN -->
<div id="modalRequisicion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTituloRequisicion">Nueva Requisición</h3>
            <button onclick="cerrarModalRequisicion()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Folio</label>
                    <input type="text" id="modalFolioRequisicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="REQ-006">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha</label>
                    <input type="date" id="modalFechaRequisicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Proyecto</label>
                    <select id="modalProyectoRequisicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar proyecto</option>
                        <option>TRC001 - Torre Cumbres</option>
                        <option>PAC002 - Puente Constitución</option>
                        <option>CIA003 - Complejo Apodaca</option>
                        <option>RHR004 - Hospital Regional</option>
                        <option>VPS005 - Periférico Sur</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Solicitante</label>
                    <select id="modalSolicitanteRequisicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar</option>
                        <option>JUAN PÉREZ</option>
                        <option>MARÍA GARCÍA</option>
                        <option>CARLOS LÓPEZ</option>
                        <option>ANA MARTÍNEZ</option>
                        <option>ROBERTO SÁNCHEZ</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Equipo</label>
                    <select id="modalEquipoRequisicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar equipo</option>
                        <option>Retroexcavadora</option>
                        <option>Grúa Torre</option>
                        <option>Montacargas</option>
                        <option>Compactadora</option>
                        <option>Revolvedora</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Código</label>
                    <input type="text" id="modalCodigoRequisicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="RET-001">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Cantidad</label>
                    <input type="number" id="modalCantidadRequisicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="1">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha Requerida</label>
                    <input type="date" id="modalFechaRequeridaRequisicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Prioridad</label>
                    <select id="modalPrioridadRequisicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Baja</option>
                        <option>Media</option>
                        <option>Alta</option>
                        <option>Urgente</option>
                    </select>
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Observaciones</label>
                    <textarea id="modalObservacionesRequisicion" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Motivo de la requisición..."></textarea>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalRequisicion()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarRequisicion()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA AGREGAR/EDITAR DEVOLUCIÓN -->
<div id="modalDevolucion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTituloDevolucion">Nueva Devolución</h3>
            <button onclick="cerrarModalDevolucion()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Folio</label>
                    <input type="text" id="modalFolioDevolucion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="DEV-006">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha</label>
                    <input type="date" id="modalFechaDevolucion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Proyecto</label>
                    <select id="modalProyectoDevolucion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar proyecto</option>
                        <option>TRC001 - Torre Cumbres</option>
                        <option>PAC002 - Puente Constitución</option>
                        <option>CIA003 - Complejo Apodaca</option>
                        <option>RHR004 - Hospital Regional</option>
                        <option>VPS005 - Periférico Sur</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Responsable</label>
                    <select id="modalResponsableDevolucion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar</option>
                        <option>JUAN PÉREZ</option>
                        <option>MARÍA GARCÍA</option>
                        <option>CARLOS LÓPEZ</option>
                        <option>ANA MARTÍNEZ</option>
                        <option>ROBERTO SÁNCHEZ</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Equipo</label>
                    <select id="modalEquipoDevolucion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar equipo</option>
                        <option>Retroexcavadora</option>
                        <option>Grúa Torre</option>
                        <option>Montacargas</option>
                        <option>Compactadora</option>
                        <option>Revolvedora</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Código</label>
                    <input type="text" id="modalCodigoDevolucion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="RET-001">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Cantidad</label>
                    <input type="number" id="modalCantidadDevolucion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="1">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha Salida</label>
                    <input type="date" id="modalFechaSalidaDevolucion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Condición</label>
                    <select id="modalCondicionDevolucion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Bueno</option>
                        <option>Regular</option>
                        <option>Dañado</option>
                        <option>Por revisar</option>
                    </select>
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Observaciones</label>
                    <textarea id="modalObservacionesDevolucion" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones sobre el estado del equipo..."></textarea>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalDevolucion()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarDevolucion()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
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
    .tab-requisicion, .tab-devolucion {
        transition: all 0.2s;
        font-size: 14px;
    }
    
    .tab-requisicion:hover, .tab-devolucion:hover {
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
    
    .table td:last-child i.fa-check-circle {
        color: #28a745;
    }
    
    .table td:last-child i.fa-redo-alt,
    .table td:last-child i.fa-clock {
        color: #ffc107;
    }
    
    .table td:last-child i.fa-truck,
    .table td:last-child i.fa-tools {
        color: #17a2b8;
    }
    
    /* Badges de estatus y prioridad */
    .badge-aprobada, .badge-completada {
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
    
    .badge-rechazada, .badge-danado {
        background-color: #dc3545;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-asignada {
        background-color: #17a2b8;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-alta {
        background-color: #dc3545;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-media {
        background-color: #ffc107;
        color: #212529;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-baja {
        background-color: #28a745;
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
    #modalRequisicion, #modalDevolucion {
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
        
        .tab-requisicion, .tab-devolucion {
            padding: 8px 15px !important;
            font-size: 13px;
        }
        
        #modalRequisicion > div, #modalDevolucion > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        #modalRequisicion div[style*="grid-template-columns: repeat(2, 1fr)"],
        #modalDevolucion div[style*="grid-template-columns: repeat(2, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadasRequisiciones = [];
    let columnasAgrupadasDevoluciones = [];
    let vistaActual = 'requisiciones';
    
    // Función para cambiar entre pestañas
    window.switchTab = function(tab) {
        vistaActual = tab;
        
        if (tab === 'requisiciones') {
            document.getElementById('panelRequisiciones').style.display = 'block';
            document.getElementById('panelDevoluciones').style.display = 'none';
            document.getElementById('tabRequisiciones').style.backgroundColor = 'var(--color-primary)';
            document.getElementById('tabRequisiciones').style.color = 'white';
            document.getElementById('tabDevoluciones').style.backgroundColor = '#e9ecef';
            document.getElementById('tabDevoluciones').style.color = '#495057';
        } else {
            document.getElementById('panelRequisiciones').style.display = 'none';
            document.getElementById('panelDevoluciones').style.display = 'block';
            document.getElementById('tabDevoluciones').style.backgroundColor = 'var(--color-primary)';
            document.getElementById('tabDevoluciones').style.color = 'white';
            document.getElementById('tabRequisiciones').style.backgroundColor = '#e9ecef';
            document.getElementById('tabRequisiciones').style.color = '#495057';
        }
    };
    
    // Funciones para Requisiciones
    window.abrirModalRequisicion = function() {
        document.getElementById('modalTituloRequisicion').textContent = 'Nueva Requisición';
        document.getElementById('modalFolioRequisicion').value = '';
        document.getElementById('modalFechaRequisicion').value = new Date().toISOString().split('T')[0];
        document.getElementById('modalProyectoRequisicion').value = 'Seleccionar proyecto';
        document.getElementById('modalSolicitanteRequisicion').value = 'Seleccionar';
        document.getElementById('modalEquipoRequisicion').value = 'Seleccionar equipo';
        document.getElementById('modalCodigoRequisicion').value = '';
        document.getElementById('modalCantidadRequisicion').value = '1';
        document.getElementById('modalFechaRequeridaRequisicion').value = '';
        document.getElementById('modalPrioridadRequisicion').value = 'Media';
        document.getElementById('modalObservacionesRequisicion').value = '';
        document.getElementById('modalRequisicion').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.editarRequisicion = function(folio) {
        document.getElementById('modalTituloRequisicion').textContent = 'Editar Requisición ' + folio;
        // Simular carga de datos
        document.getElementById('modalFolioRequisicion').value = folio;
        document.getElementById('modalFechaRequisicion').value = '2025-03-15';
        document.getElementById('modalProyectoRequisicion').value = 'TRC001 - Torre Cumbres';
        document.getElementById('modalSolicitanteRequisicion').value = 'JUAN PÉREZ';
        document.getElementById('modalEquipoRequisicion').value = 'Retroexcavadora';
        document.getElementById('modalCodigoRequisicion').value = 'RET-001';
        document.getElementById('modalCantidadRequisicion').value = '1';
        document.getElementById('modalFechaRequeridaRequisicion').value = '2025-03-18';
        document.getElementById('modalPrioridadRequisicion').value = 'Alta';
        document.getElementById('modalObservacionesRequisicion').value = 'Excavación para cimentación';
        document.getElementById('modalRequisicion').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalRequisicion = function() {
        document.getElementById('modalRequisicion').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.guardarRequisicion = function() {
        const folio = document.getElementById('modalFolioRequisicion').value;
        if (!folio) {
            alert('Por favor complete los campos obligatorios');
            return;
        }
        alert(`Requisición ${folio} guardada correctamente`);
        cerrarModalRequisicion();
    };
    
    // Funciones para Devoluciones
    window.abrirModalDevolucion = function() {
        document.getElementById('modalTituloDevolucion').textContent = 'Nueva Devolución';
        document.getElementById('modalFolioDevolucion').value = '';
        document.getElementById('modalFechaDevolucion').value = new Date().toISOString().split('T')[0];
        document.getElementById('modalProyectoDevolucion').value = 'Seleccionar proyecto';
        document.getElementById('modalResponsableDevolucion').value = 'Seleccionar';
        document.getElementById('modalEquipoDevolucion').value = 'Seleccionar equipo';
        document.getElementById('modalCodigoDevolucion').value = '';
        document.getElementById('modalCantidadDevolucion').value = '1';
        document.getElementById('modalFechaSalidaDevolucion').value = '';
        document.getElementById('modalCondicionDevolucion').value = 'Bueno';
        document.getElementById('modalObservacionesDevolucion').value = '';
        document.getElementById('modalDevolucion').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.editarDevolucion = function(folio) {
        document.getElementById('modalTituloDevolucion').textContent = 'Editar Devolución ' + folio;
        // Simular carga de datos
        document.getElementById('modalFolioDevolucion').value = folio;
        document.getElementById('modalFechaDevolucion').value = '2025-03-15';
        document.getElementById('modalProyectoDevolucion').value = 'TRC001 - Torre Cumbres';
        document.getElementById('modalResponsableDevolucion').value = 'JUAN PÉREZ';
        document.getElementById('modalEquipoDevolucion').value = 'Retroexcavadora';
        document.getElementById('modalCodigoDevolucion').value = 'RET-001';
        document.getElementById('modalCantidadDevolucion').value = '1';
        document.getElementById('modalFechaSalidaDevolucion').value = '2025-03-10';
        document.getElementById('modalCondicionDevolucion').value = 'Bueno';
        document.getElementById('modalObservacionesDevolucion').value = 'Equipo en buen estado';
        document.getElementById('modalDevolucion').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalDevolucion = function() {
        document.getElementById('modalDevolucion').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.guardarDevolucion = function() {
        const folio = document.getElementById('modalFolioDevolucion').value;
        if (!folio) {
            alert('Por favor complete los campos obligatorios');
            return;
        }
        alert(`Devolución ${folio} guardada correctamente`);
        cerrarModalDevolucion();
    };
    
    // Cerrar modales con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalRequisicion();
            cerrarModalDevolucion();
        }
    });
    
    // Cerrar modales al hacer clic fuera
    document.getElementById('modalRequisicion').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalRequisicion();
        }
    });
    
    document.getElementById('modalDevolucion').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalDevolucion();
        }
    });
    
    // Funciones de agrupación
    function actualizarGrupoColumnas(tipo) {
        let container, texto;
        let agrupadas;
        
        if (tipo === 'requisiciones') {
            container = document.getElementById('grupoColumnasRequisiciones');
            texto = document.getElementById('textoAgruparRequisiciones');
            agrupadas = columnasAgrupadasRequisiciones;
        } else {
            container = document.getElementById('grupoColumnasDevoluciones');
            texto = document.getElementById('textoAgruparDevoluciones');
            agrupadas = columnasAgrupadasDevoluciones;
        }
        
        if (!container) return;
        
        container.innerHTML = '';
        
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
        if (tipo === 'requisiciones') {
            columnasAgrupadasRequisiciones = columnasAgrupadasRequisiciones.filter(c => c !== columna);
            actualizarGrupoColumnas('requisiciones');
        } else {
            columnasAgrupadasDevoluciones = columnasAgrupadasDevoluciones.filter(c => c !== columna);
            actualizarGrupoColumnas('devoluciones');
        }
    };

    // Drag & drop
    document.addEventListener('dragstart', (e) => {
        if (e.target.tagName === 'TH' && e.target.draggable) {
            e.dataTransfer.setData('text/plain', e.target.dataset.columna);
        }
    });

    document.getElementById('grupoAgrupacionRequisiciones')?.addEventListener('dragover', (e) => e.preventDefault());
    document.getElementById('grupoAgrupacionRequisiciones')?.addEventListener('drop', (e) => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadasRequisiciones.includes(columna)) {
            columnasAgrupadasRequisiciones.push(columna);
            actualizarGrupoColumnas('requisiciones');
            alert('Agrupando requisiciones por: ' + columna);
        }
    });
    
    document.getElementById('grupoAgrupacionDevoluciones')?.addEventListener('dragover', (e) => e.preventDefault());
    document.getElementById('grupoAgrupacionDevoluciones')?.addEventListener('drop', (e) => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadasDevoluciones.includes(columna)) {
            columnasAgrupadasDevoluciones.push(columna);
            actualizarGrupoColumnas('devoluciones');
            alert('Agrupando devoluciones por: ' + columna);
        }
    });

    // Selector de columnas
    window.toggleColumnSelector = function(tipo) {
        const selector = document.getElementById('columnSelector' + (tipo === 'requisiciones' ? 'Requisiciones' : 'Devoluciones'));
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
        
        if (selector.style.display === 'block') {
            const lista = document.getElementById('columnasLista' + (tipo === 'requisiciones' ? 'Requisiciones' : 'Devoluciones'));
            
            let columnas;
            if (tipo === 'requisiciones') {
                columnas = [
                    { field: 'folio', caption: 'Folio' },
                    { field: 'estatus', caption: 'Estatus' },
                    { field: 'fecha', caption: 'Fecha' },
                    { field: 'proyecto', caption: 'Proyecto' },
                    { field: 'solicitante', caption: 'Solicitante' },
                    { field: 'equipo', caption: 'Equipo' },
                    { field: 'codigo', caption: 'Código' },
                    { field: 'cantidad', caption: 'Cantidad' },
                    { field: 'fecha_requerida', caption: 'Fecha Requerida' },
                    { field: 'fecha_asignacion', caption: 'Fecha Asignación' },
                    { field: 'prioridad', caption: 'Prioridad' },
                    { field: 'observaciones', caption: 'Observaciones' }
                ];
            } else {
                columnas = [
                    { field: 'folio', caption: 'Folio' },
                    { field: 'estatus', caption: 'Estatus' },
                    { field: 'fecha', caption: 'Fecha' },
                    { field: 'proyecto', caption: 'Proyecto' },
                    { field: 'responsable', caption: 'Responsable' },
                    { field: 'equipo', caption: 'Equipo' },
                    { field: 'codigo', caption: 'Código' },
                    { field: 'cantidad', caption: 'Cantidad' },
                    { field: 'fecha_salida', caption: 'Fecha Salida' },
                    { field: 'fecha_devolucion', caption: 'Fecha Devolución' },
                    { field: 'condicion', caption: 'Condición' },
                    { field: 'observaciones', caption: 'Observaciones' }
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
        document.getElementById('columnSelector' + (tipo === 'requisiciones' ? 'Requisiciones' : 'Devoluciones')).style.display = 'none';
    };

    // Cerrar selectores al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#btnColumnasRequisiciones') && !e.target.closest('#columnSelectorRequisiciones')) {
            document.getElementById('columnSelectorRequisiciones').style.display = 'none';
        }
        if (!e.target.closest('#btnColumnasDevoluciones') && !e.target.closest('#columnSelectorDevoluciones')) {
            document.getElementById('columnSelectorDevoluciones').style.display = 'none';
        }
    });

    // Botones
    document.getElementById('btnCrearFiltro').addEventListener('click', () => alert('Funcionalidad de filtro en desarrollo'));
    document.getElementById('btnExcelRequisiciones')?.addEventListener('click', () => alert('Exportar requisiciones a Excel'));
    document.getElementById('btnExcelDevoluciones')?.addEventListener('click', () => alert('Exportar devoluciones a Excel'));

    // Buscadores
    document.getElementById('buscadorRequisiciones')?.addEventListener('input', function(e) {
        console.log('Buscando en requisiciones:', e.target.value);
    });
    
    document.getElementById('buscadorDevoluciones')?.addEventListener('input', function(e) {
        console.log('Buscando en devoluciones:', e.target.value);
    });
});
</script>
@endsection