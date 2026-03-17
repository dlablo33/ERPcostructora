@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Control de Vehículos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                     Control de Vehículos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- KPIs - Indicadores de flotilla -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px; width: 100%;">
                    <!-- Total Unidades -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #2378e1; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Total Unidades</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">24</div>
                    </div>

                    <!-- Disponibles -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #28a745; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Disponibles</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">12</div>
                    </div>

                    <!-- En Ruta -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #ffc107; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #212529; margin-bottom: 3px;">En Ruta</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: #212529;">8</div>
                    </div>

                    <!-- Mantenimiento -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #dc3545; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Mantenimiento</div>
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
                                    title="Agregar vehículo"
                                    onclick="abrirModalVehiculo()">
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
                            <input type="text" id="buscador" placeholder="Buscar por unidad, placas, operador..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Control de Vehículos -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaVehiculos" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1400px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="unidad">Unidad</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="tipo">Tipo</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="marca">Marca</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="modelo">Modelo</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="placas">Placas</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="serie">No. Serie</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="kilometraje">Kilometraje</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="operador">Operador Asignado</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="ultimo_mantenimiento">Último Mantenimiento</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="proximo_mantenimiento">Próximo Mantenimiento</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: bold;">UN-001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Pickup</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Ford</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">F-150</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">ABC-123</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">3FTWF12A9XTA12345</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">45,230</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JUAN PÉREZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; min-width: 80px;">Disponible</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/02/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/04/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="abrirModalDetalleVehiculo('UN-001')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar UN-001')" title="Editar"></i>
                                    <i class="fas fa-tools" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Registrar mantenimiento UN-001')" title="Mantenimiento"></i>
                                    <i class="fas fa-history" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver historial UN-001')" title="Historial"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: bold;">UN-002</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Camión</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Freightliner</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">M2 106</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">XYZ-789</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">4V4NC9EHX8N123456</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">128,450</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">MARÍA GARCÍA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; min-width: 80px;">En Ruta</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">10/01/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">10/04/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="abrirModalDetalleVehiculo('UN-002')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar UN-002')" title="Editar"></i>
                                    <i class="fas fa-tools" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Registrar mantenimiento UN-002')" title="Mantenimiento"></i>
                                    <i class="fas fa-history" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver historial UN-002')" title="Historial"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: bold;">UN-003</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Pickup</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Chevrolet</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Silverado</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">DEF-456</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">2GCEC19V921234567</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">67,890</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">CARLOS LÓPEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; min-width: 80px;">Mantenimiento</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">01/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">01/04/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="abrirModalDetalleVehiculo('UN-003')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar UN-003')" title="Editar"></i>
                                    <i class="fas fa-tools" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Registrar mantenimiento UN-003')" title="Mantenimiento"></i>
                                    <i class="fas fa-history" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver historial UN-003')" title="Historial"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: bold;">UN-004</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Sedán</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Toyota</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Camry</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">GHI-789</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">4T1BF28KX9U123456</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">89,120</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ANA MARTÍNEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; min-width: 80px;">Disponible</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">20/02/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">20/05/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="abrirModalDetalleVehiculo('UN-004')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar UN-004')" title="Editar"></i>
                                    <i class="fas fa-tools" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Registrar mantenimiento UN-004')" title="Mantenimiento"></i>
                                    <i class="fas fa-history" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver historial UN-004')" title="Historial"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: bold;">UN-005</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Camión</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Kenworth</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">T680</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">JKL-012</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">3WKYK4EX6HJ123456</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">156,780</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ROBERTO SÁNCHEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; min-width: 80px;">En Ruta</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">05/01/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">05/04/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="abrirModalDetalleVehiculo('UN-005')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar UN-005')" title="Editar"></i>
                                    <i class="fas fa-tools" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Registrar mantenimiento UN-005')" title="Mantenimiento"></i>
                                    <i class="fas fa-history" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver historial UN-005')" title="Historial"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: bold;">UN-006</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Pickup</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Ram</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">2500</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">MNO-345</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">3D7KS29X1XG123456</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">34,560</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; min-width: 80px;">Disponible</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">10/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">10/06/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="abrirModalDetalleVehiculo('UN-006')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar UN-006')" title="Editar"></i>
                                    <i class="fas fa-user-plus" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="alert('Asignar operador UN-006')" title="Asignar operador"></i>
                                    <i class="fas fa-history" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver historial UN-006')" title="Historial"></i>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="11" style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right;">Total Unidades:</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: center; background-color: #e9ecef;">6</td>
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

<!-- MODAL PARA NUEVO VEHÍCULO -->
<div id="modalVehiculo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 900px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Registrar Nuevo Vehículo</h3>
            <button onclick="cerrarModalVehiculo()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Unidad *</label>
                    <input type="text" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="UN-007">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Tipo *</label>
                    <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar tipo</option>
                        <option>Pickup</option>
                        <option>Camión</option>
                        <option>Sedán</option>
                        <option>SUV</option>
                        <option>Van</option>
                        <option>Motocicleta</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Marca *</label>
                    <input type="text" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: Ford, Chevrolet">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Modelo *</label>
                    <input type="text" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: F-150, Silverado">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Año</label>
                    <input type="number" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="2023">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Placas *</label>
                    <input type="text" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="ABC-123">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">No. Serie (VIN)</label>
                    <input type="text" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Número de serie">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Motor</label>
                    <input type="text" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Número de motor">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Kilometraje</label>
                    <input type="number" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Capacidad (kg)</label>
                    <input type="number" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="1000">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Combustible</label>
                    <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Gasolina</option>
                        <option>Diésel</option>
                        <option>Eléctrico</option>
                        <option>Híbrido</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Rendimiento (km/l)</label>
                    <input type="number" step="0.1" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="8.5">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus</label>
                    <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Disponible</option>
                        <option>En Ruta</option>
                        <option>Mantenimiento</option>
                        <option>Fuera de Servicio</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Operador Asignado</label>
                    <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Sin asignar</option>
                        <option>JUAN PÉREZ</option>
                        <option>MARÍA GARCÍA</option>
                        <option>CARLOS LÓPEZ</option>
                        <option>ANA MARTÍNEZ</option>
                    </select>
                </div>
                
                <div style="grid-column: span 3;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Observaciones</label>
                    <textarea rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones adicionales..."></textarea>
                </div>
            </div>
            
            <h4 style="color: var(--color-primary); margin: 20px 0 15px; font-size: 15px; border-bottom: 1px solid #dee2e6; padding-bottom: 5px;">Documentación</h4>
            
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Tarjeta de Circulación</label>
                    <input type="date" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Seguro Vigente</label>
                    <input type="date" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Verificación</label>
                    <input type="date" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Último Mantenimiento</label>
                    <input type="date" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Próximo Mantenimiento</label>
                    <input type="date" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Kilometraje para Mantenimiento</label>
                    <input type="number" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="5000">
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalVehiculo()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="alert('Vehículo registrado correctamente')" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA DETALLE DE VEHÍCULO -->
<div id="modalDetalleVehiculo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 800px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Detalle del Vehículo - <span id="detalleUnidad">UN-001</span></h3>
            <button onclick="cerrarModalDetalleVehiculo()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Contenido -->
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                <div>
                    <h4 style="font-size: 14px; font-weight: bold; color: var(--color-primary); margin: 0 0 10px 0;">Información General</h4>
                    <table style="width: 100%; font-size: 12px;">
                        <tr><td style="padding: 4px 0; color: #6c757d;">Unidad:</td><td style="padding: 4px 0; font-weight: 500;" id="detalleUnidadValue">UN-001</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Tipo:</td><td style="padding: 4px 0;" id="detalleTipo">Pickup</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Marca:</td><td style="padding: 4px 0;" id="detalleMarca">Ford</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Modelo:</td><td style="padding: 4px 0;" id="detalleModelo">F-150</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Año:</td><td style="padding: 4px 0;" id="detalleAnio">2022</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Placas:</td><td style="padding: 4px 0;" id="detallePlacas">ABC-123</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">No. Serie:</td><td style="padding: 4px 0; font-size: 11px;" id="detalleSerie">3FTWF12A9XTA12345</td></tr>
                    </table>
                </div>
                <div>
                    <h4 style="font-size: 14px; font-weight: bold; color: var(--color-primary); margin: 0 0 10px 0;">Estatus y Asignación</h4>
                    <table style="width: 100%; font-size: 12px;">
                        <tr><td style="padding: 4px 0; color: #6c757d;">Estatus:</td><td style="padding: 4px 0;" id="detalleEstatus"><span style="background-color: #28a745; color: white; padding: 2px 8px; border-radius: 3px;">Disponible</span></td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Operador:</td><td style="padding: 4px 0;" id="detalleOperador">JUAN PÉREZ</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Kilometraje:</td><td style="padding: 4px 0;" id="detalleKilometraje">45,230 km</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Capacidad:</td><td style="padding: 4px 0;" id="detalleCapacidad">1,500 kg</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Combustible:</td><td style="padding: 4px 0;" id="detalleCombustible">Gasolina</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Rendimiento:</td><td style="padding: 4px 0;" id="detalleRendimiento">8.5 km/l</td></tr>
                    </table>
                </div>
            </div>
            
            <h4 style="font-size: 14px; font-weight: bold; color: var(--color-primary); margin: 15px 0 10px 0;">Documentación y Mantenimiento</h4>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                <div style="background-color: #f8f9fa; padding: 10px; border-radius: 4px;">
                    <div style="font-size: 11px; color: #6c757d;">Tarjeta de Circulación</div>
                    <div style="font-size: 13px; font-weight: 500;" id="detalleTarjeta">15/06/2025</div>
                    <div style="font-size: 10px; color: #28a745;">Vigente (90 días)</div>
                </div>
                <div style="background-color: #f8f9fa; padding: 10px; border-radius: 4px;">
                    <div style="font-size: 11px; color: #6c757d;">Seguro</div>
                    <div style="font-size: 13px; font-weight: 500;" id="detalleSeguro">31/12/2025</div>
                    <div style="font-size: 10px; color: #28a745;">Vigente (270 días)</div>
                </div>
                <div style="background-color: #f8f9fa; padding: 10px; border-radius: 4px;">
                    <div style="font-size: 11px; color: #6c757d;">Verificación</div>
                    <div style="font-size: 13px; font-weight: 500;" id="detalleVerificacion">30/06/2025</div>
                    <div style="font-size: 10px; color: #ffc107;">Próximo (105 días)</div>
                </div>
                <div style="background-color: #f8f9fa; padding: 10px; border-radius: 4px;">
                    <div style="font-size: 11px; color: #6c757d;">Último Mantenimiento</div>
                    <div style="font-size: 13px; font-weight: 500;" id="detalleUltimoMant">15/02/2025</div>
                    <div style="font-size: 10px; color: #6c757d;">Hace 20 días</div>
                </div>
                <div style="background-color: #f8f9fa; padding: 10px; border-radius: 4px;">
                    <div style="font-size: 11px; color: #6c757d;">Próximo Mantenimiento</div>
                    <div style="font-size: 13px; font-weight: 500;" id="detalleProximoMant">15/04/2025</div>
                    <div style="font-size: 10px; color: #ffc107;">En 40 días</div>
                </div>
                <div style="background-color: #f8f9fa; padding: 10px; border-radius: 4px;">
                    <div style="font-size: 11px; color: #6c757d;">Mantenimiento por km</div>
                    <div style="font-size: 13px; font-weight: 500;" id="detalleKmMant">5,000 km</div>
                    <div style="font-size: 10px;" id="detalleKmRestante">Restan 3,200 km</div>
                </div>
            </div>
            
            <h4 style="font-size: 14px; font-weight: bold; color: var(--color-primary); margin: 15px 0 10px 0;">Últimos Movimientos</h4>
            <table style="width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 15px;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6;">Fecha</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6;">Operador</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6;">Origen</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6;">Destino</th>
                        <th style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">Km</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td style="padding: 6px; border: 1px solid #dee2e6;">15/03/2025</td><td style="padding: 6px; border: 1px solid #dee2e6;">JUAN PÉREZ</td><td style="padding: 6px; border: 1px solid #dee2e6;">Base MTY</td><td style="padding: 6px; border: 1px solid #dee2e6;">Obra Apodaca</td><td style="padding: 6px; text-align: right; border: 1px solid #dee2e6;">45</td></tr>
                    <tr><td style="padding: 6px; border: 1px solid #dee2e6;">14/03/2025</td><td style="padding: 6px; border: 1px solid #dee2e6;">JUAN PÉREZ</td><td style="padding: 6px; border: 1px solid #dee2e6;">Obra Apodaca</td><td style="padding: 6px; border: 1px solid #dee2e6;">Base MTY</td><td style="padding: 6px; text-align: right; border: 1px solid #dee2e6;">45</td></tr>
                    <tr><td style="padding: 6px; border: 1px solid #dee2e6;">13/03/2025</td><td style="padding: 6px; border: 1px solid #dee2e6;">JUAN PÉREZ</td><td style="padding: 6px; border: 1px solid #dee2e6;">Base MTY</td><td style="padding: 6px; border: 1px solid #dee2e6;">Proveedor</td><td style="padding: 6px; text-align: right; border: 1px solid #dee2e6;">120</td></tr>
                </tbody>
            </table>
            
            <div style="margin-bottom: 15px;">
                <h4 style="font-size: 14px; font-weight: bold; color: var(--color-primary); margin: 0 0 5px 0;">Observaciones</h4>
                <p style="margin: 0; font-size: 12px; padding: 10px; background-color: #f8f9fa; border-radius: 4px;" id="detalleObservaciones">
                    Unidad en buen estado. Próximo servicio de afinación.
                </p>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button onclick="cerrarModalDetalleVehiculo()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cerrar</button>
                <button onclick="alert('Generando reporte')" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">
                    <i class="fas fa-file-pdf"></i> Reporte Completo
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
    .table td:nth-child(9),
    .table td:nth-child(10),
    .table td:nth-child(11) {
        text-align: center;
    }
    
    .table td:nth-child(7) {
        text-align: right;
    }
    
    .table td:nth-child(8) {
        text-align: left;
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
    
    /* Badges de estatus */
    .badge-disponible {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 80px;
        text-align: center;
    }
    
    .badge-en-ruta {
        background-color: #ffc107;
        color: #212529;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 80px;
        text-align: center;
    }
    
    .badge-mantenimiento {
        background-color: #dc3545;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 80px;
        text-align: center;
    }
    
    .badge-fuera-servicio {
        background-color: #6c757d;
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
    #modalVehiculo,
    #modalDetalleVehiculo {
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
        
        #modalVehiculo > div,
        #modalDetalleVehiculo > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        #modalVehiculo div[style*="grid-template-columns: repeat(3, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        
        #modalDetalleVehiculo div[style*="grid-template-columns: repeat(3, 1fr)"] {
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
                { field: 'unidad', caption: 'Unidad' },
                { field: 'tipo', caption: 'Tipo' },
                { field: 'marca', caption: 'Marca' },
                { field: 'modelo', caption: 'Modelo' },
                { field: 'placas', caption: 'Placas' },
                { field: 'serie', caption: 'No. Serie' },
                { field: 'kilometraje', caption: 'Kilometraje' },
                { field: 'operador', caption: 'Operador' },
                { field: 'estatus', caption: 'Estatus' },
                { field: 'ultimo_mantenimiento', caption: 'Último Mant.' },
                { field: 'proximo_mantenimiento', caption: 'Próximo Mant.' }
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

// Funciones de modal
function abrirModalVehiculo() {
    document.getElementById('modalVehiculo').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalVehiculo() {
    document.getElementById('modalVehiculo').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function abrirModalDetalleVehiculo(unidad) {
    document.getElementById('detalleUnidad').textContent = unidad;
    document.getElementById('detalleUnidadValue').textContent = unidad;
    document.getElementById('modalDetalleVehiculo').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalDetalleVehiculo() {
    document.getElementById('modalDetalleVehiculo').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Cerrar modales con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalVehiculo();
        cerrarModalDetalleVehiculo();
    }
});

// Cerrar modales al hacer clic fuera
document.getElementById('modalVehiculo')?.addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalVehiculo();
    }
});

document.getElementById('modalDetalleVehiculo')?.addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalDetalleVehiculo();
    }
});
</script>
@endsection