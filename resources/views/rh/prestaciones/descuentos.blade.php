@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Descuentos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-percent" style="margin-right: 10px;"></i> Descuentos
                </h2>
            </div>

            <div class="card-body p-4">
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
                                    title="Agregar descuento"
                                    onclick="abrirModalDescuento()">
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
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 280px; max-height: 350px; overflow-y: auto;">
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
                            <input type="text" id="buscador" placeholder="Buscar por empleado, concepto..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Descuentos -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaDescuentos" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1100px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="folio">Folio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="empleado">Empleado</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="concepto">Concepto</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="tipo">Tipo</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="monto">Monto</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_inicio">Fecha Inicio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_fin">Fecha Fin</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">DSC-001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JUAN CARLOS PÉREZ LÓPEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Fondo de Ahorro</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Fijo</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$500.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">01/01/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">31/12/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle DSC-001')"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar DSC-001')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar descuento?')) alert('Descuento eliminado')"></i>
                                    <i class="fas fa-pause-circle" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Suspender descuento')" title="Suspender"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">DSC-002</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">MARÍA FERNANDA RAMOS GARCÍA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Cuota Sindical</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Porcentaje</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">1.5%</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">01/01/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">31/12/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle DSC-002')"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar DSC-002')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar descuento?')) alert('Descuento eliminado')"></i>
                                    <i class="fas fa-pause-circle" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Suspender descuento')" title="Suspender"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">DSC-003</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">CARLOS ALBERTO MENDOZA SÁNCHEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Uniformes</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Fijo</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$350.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">01/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">30/04/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle DSC-003')"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar DSC-003')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar descuento?')) alert('Descuento eliminado')"></i>
                                    <i class="fas fa-pause-circle" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Suspender descuento')" title="Suspender"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">DSC-004</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ANA SOFÍA MARTÍNEZ FLORES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Herramientas</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Fijo</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$200.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/02/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/05/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle DSC-004')"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar DSC-004')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar descuento?')) alert('Descuento eliminado')"></i>
                                    <i class="fas fa-pause-circle" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Suspender descuento')" title="Suspender"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">DSC-005</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ROBERTO ANTONIO SÁNCHEZ TORRES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Fondo de Ahorro</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Fijo</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$600.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">01/01/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">31/12/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Suspendido</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle DSC-005')"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar DSC-005')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar descuento?')) alert('Descuento eliminado')"></i>
                                    <i class="fas fa-play-circle" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="alert('Reactivar descuento')" title="Reactivar"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">DSC-006</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">LAURA PATRICIA FLORES GONZÁLEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Cuota Sindical</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Porcentaje</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">1.2%</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">01/01/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">31/12/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle DSC-006')"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar DSC-006')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar descuento?')) alert('Descuento eliminado')"></i>
                                    <i class="fas fa-pause-circle" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Suspender descuento')" title="Suspender"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">DSC-007</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JOSÉ LUIS TORRES RAMÍREZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Teléfono</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Fijo</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$250.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">01/02/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">31/07/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle DSC-007')"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar DSC-007')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar descuento?')) alert('Descuento eliminado')"></i>
                                    <i class="fas fa-pause-circle" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Suspender descuento')" title="Suspender"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">DSC-008</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">PATRICIA ELIZABETH CASTILLO VEGA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Uniformes</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Fijo</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$350.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">01/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">30/04/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Finalizado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle DSC-008')"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar DSC-008')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar descuento?')) alert('Descuento eliminado')"></i>
                                    <i class="fas fa-redo-alt" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="alert('Renovar descuento')" title="Renovar"></i>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="4" style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right;">Totales:</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right; background-color: #e9ecef;">$2,250.00*</td>
                                <td colspan="3" style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: center; background-color: #e9ecef;">Total Descuentos: 8</td>
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

<!-- MODAL PARA NUEVO DESCUENTO -->
<div id="modalDescuento" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 700px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Nuevo Descuento</h3>
            <button onclick="cerrarModalDescuento()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Folio</label>
                    <input type="text" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="DSC-009">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Tipo de Descuento</label>
                    <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar tipo</option>
                        <option>Fondo de Ahorro</option>
                        <option>Cuota Sindical</option>
                        <option>Uniformes</option>
                        <option>Herramientas</option>
                        <option>Teléfono</option>
                        <option>Seguro de Vida</option>
                        <option>Otro</option>
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
                        <option>JOSÉ LUIS TORRES RAMÍREZ</option>
                        <option>PATRICIA ELIZABETH CASTILLO VEGA</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Tipo de Monto</label>
                    <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" id="tipoMonto">
                        <option value="fijo">Monto Fijo</option>
                        <option value="porcentaje">Porcentaje</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Valor</label>
                    <input type="text" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: 500.00 o 1.5%" id="valorDescuento">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha Inicio</label>
                    <input type="date" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha Fin</label>
                    <input type="date" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus</label>
                    <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Activo</option>
                        <option>Suspendido</option>
                    </select>
                </div>
                
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Concepto / Observaciones</label>
                    <textarea rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Detalle del descuento..."></textarea>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalDescuento()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="alert('Descuento guardado')" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
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
        min-width: 1100px;
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
    .table td:nth-child(4),
    .table td:nth-child(6),
    .table td:nth-child(7),
    .table td:nth-child(8) {
        text-align: center;
    }
    
    .table td:nth-child(2),
    .table td:nth-child(3) {
        text-align: left;
    }
    
    .table td:nth-child(5) {
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
    
    .table td:last-child i.fa-edit,
    .table td:last-child i.fa-eye {
        color: var(--color-primary);
    }
    
    .table td:last-child i.fa-trash {
        color: #dc3545;
    }
    
    .table td:last-child i.fa-pause-circle {
        color: #ffc107;
    }
    
    .table td:last-child i.fa-play-circle {
        color: #28a745;
    }
    
    .table td:last-child i.fa-redo-alt {
        color: #28a745;
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
    
    .badge-suspendido {
        background-color: #ffc107;
        color: #212529;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-finalizado {
        background-color: #6c757d;
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
    #modalDescuento {
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
        
        #modalDescuento > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        #modalDescuento div[style*="grid-template-columns: repeat(2, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadas = [];
    
    // Mostrar/ocultar campo de valor según tipo de monto
    document.getElementById('tipoMonto').addEventListener('change', function() {
        const valorField = document.getElementById('valorDescuento');
        if (this.value === 'porcentaje') {
            valorField.placeholder = 'Ej: 1.5%';
        } else {
            valorField.placeholder = 'Ej: 500.00';
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
                { field: 'concepto', caption: 'Concepto' },
                { field: 'tipo', caption: 'Tipo' },
                { field: 'monto', caption: 'Monto' },
                { field: 'fecha_inicio', caption: 'Fecha Inicio' },
                { field: 'fecha_fin', caption: 'Fecha Fin' },
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
function abrirModalDescuento() {
    document.getElementById('modalDescuento').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalDescuento() {
    document.getElementById('modalDescuento').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Cerrar modal con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalDescuento();
    }
});

// Cerrar modal al hacer clic fuera
document.getElementById('modalDescuento').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalDescuento();
    }
});
</script>
@endsection