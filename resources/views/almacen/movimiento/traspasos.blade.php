@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Traspasos entre Almacenes -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Traspasos entre Almacenes
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
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Almacén</label>
                        <select style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                            <option>Todos</option>
                            <option>Almacén Central</option>
                            <option>Almacén Norte</option>
                            <option>Almacén Sur</option>
                            <option>Almacén Este</option>
                            <option>Almacén Oeste</option>
                        </select>
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
                                    title="Agregar traspaso"
                                    onclick="abrirModalTraspaso()">
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
                        <div style="position: relative; min-width: 220px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar traspaso..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Traspasos entre Almacenes -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaTraspasos" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 900px;">
                        <thead style="background-color: var(--color-primary); position: sticky; top: 0; z-index: 20;">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 15%;" draggable="true" data-columna="id">ID Traspaso</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 10%;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 12%;" draggable="true" data-columna="fecha">Fecha</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 18%;" draggable="true" data-columna="almacen_origen">Almacén Origen</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 18%;" draggable="true" data-columna="almacen_destino">Almacén Destino</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 15%;" draggable="true" data-columna="plantilla">Plantilla</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1); width: 12%;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">TA-001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Completado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Central</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Norte</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JUAN PÉREZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle TA-001')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarTraspaso('TA-001')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar traspaso?')) alert('Traspaso eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">TA-002</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Completado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">14/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Central</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Sur</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">MARÍA GARCÍA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle TA-002')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarTraspaso('TA-002')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar traspaso?')) alert('Traspaso eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">TA-003</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Pendiente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">13/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Norte</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Este</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">CARLOS LÓPEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle TA-003')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarTraspaso('TA-003')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar traspaso?')) alert('Traspaso eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-check-circle" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="alert('Procesar traspaso')" title="Procesar"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">TA-004</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Completado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">12/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Sur</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Oeste</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ANA MARTÍNEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle TA-004')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarTraspaso('TA-004')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar traspaso?')) alert('Traspaso eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">TA-005</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Completado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">11/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Este</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Central</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ROBERTO SÁNCHEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle TA-005')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarTraspaso('TA-005')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar traspaso?')) alert('Traspaso eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">TA-006</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Pendiente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">10/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Oeste</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Norte</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">LAURA FLORES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle TA-006')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarTraspaso('TA-006')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar traspaso?')) alert('Traspaso eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-check-circle" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="alert('Procesar traspaso')" title="Procesar"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">TA-007</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Completado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">09/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Central</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Este</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JOSÉ TORRES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle TA-007')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarTraspaso('TA-007')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar traspaso?')) alert('Traspaso eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">TA-008</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Completado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">08/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Sur</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Norte</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">PATRICIA CASTILLO</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle TA-008')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarTraspaso('TA-008')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar traspaso?')) alert('Traspaso eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Generar PDF')" title="PDF"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">TA-009</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Pendiente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">07/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Este</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Oeste</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">FERNANDO GONZÁLEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle TA-009')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarTraspaso('TA-009')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar traspaso?')) alert('Traspaso eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-check-circle" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="alert('Procesar traspaso')" title="Procesar"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">TA-010</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Cancelado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">06/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Central</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacén Sur</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">GABRIELA NAVARRO</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle TA-010')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarTraspaso('TA-010')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar traspaso?')) alert('Traspaso eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-undo-alt" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Reactivar traspaso')" title="Reactivar"></i>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="7" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 13px;">Total Traspasos: 10 | Completados: 7 | Pendientes: 2 | Cancelados: 1</td>
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

<!-- MODAL PARA AGREGAR/EDITAR TRASPASO ENTRE ALMACENES -->
<div id="modalTraspaso" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTituloTraspaso">Nuevo Traspaso entre Almacenes</h3>
            <button onclick="cerrarModalTraspaso()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">ID Traspaso</label>
                    <input type="text" id="modalIdTraspaso" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="TA-011">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus</label>
                    <select id="modalEstatusTraspaso" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Pendiente</option>
                        <option>Completado</option>
                        <option>Cancelado</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha</label>
                    <input type="date" id="modalFechaTraspaso" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Plantilla</label>
                    <select id="modalPlantillaTraspaso" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar responsable</option>
                        <option>JUAN PÉREZ</option>
                        <option>MARÍA GARCÍA</option>
                        <option>CARLOS LÓPEZ</option>
                        <option>ANA MARTÍNEZ</option>
                        <option>ROBERTO SÁNCHEZ</option>
                        <option>LAURA FLORES</option>
                        <option>JOSÉ TORRES</option>
                        <option>PATRICIA CASTILLO</option>
                        <option>FERNANDO GONZÁLEZ</option>
                        <option>GABRIELA NAVARRO</option>
                    </select>
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Almacén Origen</label>
                    <select id="modalOrigenTraspaso" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar almacén origen</option>
                        <option>Almacén Central</option>
                        <option>Almacén Norte</option>
                        <option>Almacén Sur</option>
                        <option>Almacén Este</option>
                        <option>Almacén Oeste</option>
                    </select>
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Almacén Destino</label>
                    <select id="modalDestinoTraspaso" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar almacén destino</option>
                        <option>Almacén Central</option>
                        <option>Almacén Norte</option>
                        <option>Almacén Sur</option>
                        <option>Almacén Este</option>
                        <option>Almacén Oeste</option>
                    </select>
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Observaciones</label>
                    <textarea id="modalObservacionesTraspaso" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones del traspaso..."></textarea>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalTraspaso()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarTraspaso()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
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
    
    .table td:last-child i.fa-check-circle {
        color: #28a745;
    }
    
    .table td:last-child i.fa-undo-alt {
        color: #ffc107;
    }
    
    /* Badges de estatus */
    .badge-completado {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 80px;
        text-align: center;
    }
    
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
    
    .badge-cancelado {
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
    #modalTraspaso {
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
        
        #modalTraspaso > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        #modalTraspaso div[style*="grid-template-columns: repeat(2, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadas = [];
    
    // Función para abrir modal de nuevo traspaso
    window.abrirModalTraspaso = function() {
        document.getElementById('modalTituloTraspaso').textContent = 'Nuevo Traspaso entre Almacenes';
        document.getElementById('modalIdTraspaso').value = '';
        document.getElementById('modalEstatusTraspaso').value = 'Pendiente';
        document.getElementById('modalFechaTraspaso').value = new Date().toISOString().split('T')[0];
        document.getElementById('modalOrigenTraspaso').value = 'Seleccionar almacén origen';
        document.getElementById('modalDestinoTraspaso').value = 'Seleccionar almacén destino';
        document.getElementById('modalPlantillaTraspaso').value = 'Seleccionar responsable';
        document.getElementById('modalObservacionesTraspaso').value = '';
        document.getElementById('modalTraspaso').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    // Función para editar traspaso
    window.editarTraspaso = function(id) {
        document.getElementById('modalTituloTraspaso').textContent = 'Editar Traspaso ' + id;
        
        // Simular carga de datos según el ID
        if (id === 'TA-001') {
            document.getElementById('modalIdTraspaso').value = 'TA-001';
            document.getElementById('modalEstatusTraspaso').value = 'Completado';
            document.getElementById('modalFechaTraspaso').value = '2025-03-15';
            document.getElementById('modalOrigenTraspaso').value = 'Almacén Central';
            document.getElementById('modalDestinoTraspaso').value = 'Almacén Norte';
            document.getElementById('modalPlantillaTraspaso').value = 'JUAN PÉREZ';
            document.getElementById('modalObservacionesTraspaso').value = 'Traspaso completado sin novedad';
        } else if (id === 'TA-003') {
            document.getElementById('modalIdTraspaso').value = 'TA-003';
            document.getElementById('modalEstatusTraspaso').value = 'Pendiente';
            document.getElementById('modalFechaTraspaso').value = '2025-03-13';
            document.getElementById('modalOrigenTraspaso').value = 'Almacén Norte';
            document.getElementById('modalDestinoTraspaso').value = 'Almacén Este';
            document.getElementById('modalPlantillaTraspaso').value = 'CARLOS LÓPEZ';
            document.getElementById('modalObservacionesTraspaso').value = 'Pendiente de autorización';
        } else if (id === 'TA-010') {
            document.getElementById('modalIdTraspaso').value = 'TA-010';
            document.getElementById('modalEstatusTraspaso').value = 'Cancelado';
            document.getElementById('modalFechaTraspaso').value = '2025-03-06';
            document.getElementById('modalOrigenTraspaso').value = 'Almacén Central';
            document.getElementById('modalDestinoTraspaso').value = 'Almacén Sur';
            document.getElementById('modalPlantillaTraspaso').value = 'GABRIELA NAVARRO';
            document.getElementById('modalObservacionesTraspaso').value = 'Cancelado por error en inventario';
        } else {
            document.getElementById('modalIdTraspaso').value = id;
            document.getElementById('modalEstatusTraspaso').value = 'Pendiente';
            document.getElementById('modalFechaTraspaso').value = '2025-03-10';
            document.getElementById('modalOrigenTraspaso').value = 'Almacén Central';
            document.getElementById('modalDestinoTraspaso').value = 'Almacén Norte';
            document.getElementById('modalPlantillaTraspaso').value = 'JUAN PÉREZ';
            document.getElementById('modalObservacionesTraspaso').value = '';
        }
        
        document.getElementById('modalTraspaso').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalTraspaso = function() {
        document.getElementById('modalTraspaso').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.guardarTraspaso = function() {
        const id = document.getElementById('modalIdTraspaso').value;
        const origen = document.getElementById('modalOrigenTraspaso').value;
        const destino = document.getElementById('modalDestinoTraspaso').value;
        const plantilla = document.getElementById('modalPlantillaTraspaso').value;
        
        if (!id || origen === 'Seleccionar almacén origen' || destino === 'Seleccionar almacén destino' || plantilla === 'Seleccionar responsable') {
            alert('Por favor complete los campos obligatorios');
            return;
        }
        
        if (origen === destino) {
            alert('El almacén origen y destino no pueden ser el mismo');
            return;
        }
        
        alert(`Traspaso ${id} guardado correctamente`);
        cerrarModalTraspaso();
    };
    
    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalTraspaso();
        }
    });
    
    // Cerrar modal al hacer clic fuera
    document.getElementById('modalTraspaso').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalTraspaso();
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
                { field: 'id', caption: 'ID Traspaso' },
                { field: 'estatus', caption: 'Estatus' },
                { field: 'fecha', caption: 'Fecha' },
                { field: 'almacen_origen', caption: 'Almacén Origen' },
                { field: 'almacen_destino', caption: 'Almacén Destino' },
                { field: 'plantilla', caption: 'Plantilla' }
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
    document.getElementById('btnExcel').addEventListener('click', () => alert('Exportar traspasos a Excel'));

    // Buscador
    document.getElementById('buscador').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        console.log('Buscando en traspasos:', termino);
    });
});
</script>
@endsection