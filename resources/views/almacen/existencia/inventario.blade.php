@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Inventario Físico -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Inventario Físico
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- KPIs - Indicadores de inventario -->


                <!-- Filtros de búsqueda -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Familia</label>
                        <select style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                            <option>Todas</option>
                            <option>Herramientas</option>
                            <option>Materiales</option>
                            <option>Equipo</option>
                            <option>Consumibles</option>
                            <option>Seguridad</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Subfamilia</label>
                        <select style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                            <option>Todas</option>
                            <option>Eléctricas</option>
                            <option>Hidráulicas</option>
                            <option>Manuales</option>
                            <option>Protección</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Ubicación</label>
                        <select style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                            <option>Todas</option>
                            <option>Almacén A</option>
                            <option>Almacén B</option>
                            <option>Almacén C</option>
                        </select>
                    </div>
                    <div style="display: flex; align-items: flex-end;">
                        <button style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 13px; width: 100%;">
                            <i class="fas fa-filter"></i> Filtrar
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
                        <!-- Botón Agregar (+) -->
                        <div>
                            <button id="btnAgregar" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                    title="Agregar artículo"
                                    onclick="abrirModalArticulo()">
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
                        <div style="position: relative; min-width: 250px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar por código, descripción..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Inventario Físico -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaInventario" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1300px;">
                        <thead style="background-color: var(--color-primary); position: sticky; top: 0; z-index: 20;">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="codigo">Código</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="descripcion">Descripción</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="numero_parte">Número Parte</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="stock">Existencia</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="ubicacion">Ubicación</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="costo">Costo</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="minimo">Mínimo</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="maximo">Máximo</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="reorden">Punto Reorden</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="familia">Familia</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="subfamilia">SubFamilia</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">HERR-001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Taladro Percutor 1/2"</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">TLD-1001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">25</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">A-12</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$1,250.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">10</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">50</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">15</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Herramientas</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Eléctricas</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle HERR-001')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarArticulo('HERR-001')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar artículo?')) alert('Artículo eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-clipboard-list" style="color: #17a2b8; margin: 0 5px; cursor: pointer;" onclick="alert('Ver movimientos')" title="Movimientos"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">MAT-001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Cemento Gris 50kg</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CEM-50</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">350</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">B-05</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$185.50</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">200</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">1000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">300</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Materiales</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Construcción</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle MAT-001')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarArticulo('MAT-001')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar artículo?')) alert('Artículo eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-clipboard-list" style="color: #17a2b8; margin: 0 5px; cursor: pointer;" onclick="alert('Ver movimientos')" title="Movimientos"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">EQP-001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Andamio Metálico 3m</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">AND-300</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500; color: #dc3545;">8</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">C-10</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$3,450.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">10</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">30</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">12</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Equipo</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Andamios</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle EQP-001')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarArticulo('EQP-001')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar artículo?')) alert('Artículo eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-clipboard-list" style="color: #17a2b8; margin: 0 5px; cursor: pointer;" onclick="alert('Ver movimientos')" title="Movimientos"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">CON-001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Guantes de Seguridad</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">GUA-001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">150</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">D-03</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$45.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">50</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">300</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">80</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Consumibles</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Seguridad</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle CON-001')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarArticulo('CON-001')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar artículo?')) alert('Artículo eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-clipboard-list" style="color: #17a2b8; margin: 0 5px; cursor: pointer;" onclick="alert('Ver movimientos')" title="Movimientos"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">HERR-002</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Pulidora Angular 4 1/2"</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">PUL-045</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">18</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">A-15</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$890.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">10</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">30</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">15</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Herramientas</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Eléctricas</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle HERR-002')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarArticulo('HERR-002')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar artículo?')) alert('Artículo eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-clipboard-list" style="color: #17a2b8; margin: 0 5px; cursor: pointer;" onclick="alert('Ver movimientos')" title="Movimientos"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">MAT-002</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Varilla Corrugada 3/8"</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">VAR-038</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">500</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">B-12</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$45.20</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">200</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">1000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">300</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Materiales</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Acero</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle MAT-002')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarArticulo('MAT-002')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar artículo?')) alert('Artículo eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-clipboard-list" style="color: #17a2b8; margin: 0 5px; cursor: pointer;" onclick="alert('Ver movimientos')" title="Movimientos"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">EQP-002</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Revolvedora 1 saco</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">REV-001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500; color: #28a745;">12</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">C-05</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$12,500.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">8</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">20</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">10</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Equipo</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Maquinaria</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle EQP-002')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarArticulo('EQP-002')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar artículo?')) alert('Artículo eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-clipboard-list" style="color: #17a2b8; margin: 0 5px; cursor: pointer;" onclick="alert('Ver movimientos')" title="Movimientos"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">CON-002</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Casco de Seguridad</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CAS-001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">85</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">D-08</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$120.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">30</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">150</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">40</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Consumibles</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Seguridad</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle CON-002')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarArticulo('CON-002')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar artículo?')) alert('Artículo eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-clipboard-list" style="color: #17a2b8; margin: 0 5px; cursor: pointer;" onclick="alert('Ver movimientos')" title="Movimientos"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">HERR-003</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Rotomartillo SDS</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">ROT-002</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500;">7</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">A-18</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$2,300.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">5</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">15</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">8</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Herramientas</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Eléctricas</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle HERR-003')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarArticulo('HERR-003')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar artículo?')) alert('Artículo eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-clipboard-list" style="color: #17a2b8; margin: 0 5px; cursor: pointer;" onclick="alert('Ver movimientos')" title="Movimientos"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">MAT-003</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Block Hueco 15x20x40</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">BLK-001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: 500; color: #ffc107;">850</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">B-20</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$12.50</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">500</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">2000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">700</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Materiales</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Mampostería</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle MAT-003')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarArticulo('MAT-003')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar artículo?')) alert('Artículo eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-clipboard-list" style="color: #17a2b8; margin: 0 5px; cursor: pointer;" onclick="alert('Ver movimientos')" title="Movimientos"></i>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="5" style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">Valor Total Inventario:</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$32,450.70</td>
                                <td colspan="5" style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">Total Artículos: 10</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #e9ecef; box-shadow: -2px 0 5px rgba(0,0,0,0.1);"></td>
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

<!-- MODAL PARA AGREGAR/EDITAR ARTÍCULO -->
<div id="modalArticulo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 700px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTituloArticulo">Nuevo Artículo</h3>
            <button onclick="cerrarModalArticulo()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Código</label>
                    <input type="text" id="modalCodigoArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="HERR-004">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Número de Parte</label>
                    <input type="text" id="modalNumeroParteArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="TLD-1002">
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Descripción</label>
                    <input type="text" id="modalDescripcionArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción del artículo">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Existencia</label>
                    <input type="number" id="modalStockArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Ubicación</label>
                    <input type="text" id="modalUbicacionArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="A-12">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Costo</label>
                    <input type="number" id="modalCostoArticulo" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Mínimo</label>
                    <input type="number" id="modalMinimoArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Máximo</label>
                    <input type="number" id="modalMaximoArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Punto Reorden</label>
                    <input type="number" id="modalReordenArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Familia</label>
                    <select id="modalFamiliaArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar familia</option>
                        <option>Herramientas</option>
                        <option>Materiales</option>
                        <option>Equipo</option>
                        <option>Consumibles</option>
                        <option>Seguridad</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Subfamilia</label>
                    <select id="modalSubfamiliaArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar subfamilia</option>
                        <option>Eléctricas</option>
                        <option>Hidráulicas</option>
                        <option>Manuales</option>
                        <option>Construcción</option>
                        <option>Acero</option>
                        <option>Maquinaria</option>
                        <option>Andamios</option>
                        <option>Seguridad</option>
                        <option>Mampostería</option>
                    </select>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalArticulo()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarArticulo()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
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
    
    /* Alineaciones específicas */
    .table td:nth-child(1),
    .table td:nth-child(3),
    .table td:nth-child(4),
    .table td:nth-child(6),
    .table td:nth-child(7),
    .table td:nth-child(8),
    .table td:nth-child(9) {
        text-align: center;
    }
    
    .table td:nth-child(2),
    .table td:nth-child(5),
    .table td:nth-child(10),
    .table td:nth-child(11) {
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
    
    .table td:last-child i.fa-edit,
    .table td:last-child i.fa-eye {
        color: var(--color-primary);
    }
    
    .table td:last-child i.fa-trash {
        color: #dc3545;
    }
    
    .table td:last-child i.fa-clipboard-list {
        color: #17a2b8;
    }
    
    /* Indicadores de nivel de stock */
    .stock-bajo {
        color: #dc3545;
        font-weight: 700;
    }
    
    .stock-alto {
        color: #28a745;
        font-weight: 700;
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
    #modalArticulo {
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
        
        #modalArticulo > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        #modalArticulo div[style*="grid-template-columns: repeat(2, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadas = [];
    
    // Función para abrir modal de nuevo artículo
    window.abrirModalArticulo = function() {
        document.getElementById('modalTituloArticulo').textContent = 'Nuevo Artículo';
        document.getElementById('modalCodigoArticulo').value = '';
        document.getElementById('modalNumeroParteArticulo').value = '';
        document.getElementById('modalDescripcionArticulo').value = '';
        document.getElementById('modalStockArticulo').value = '0';
        document.getElementById('modalUbicacionArticulo').value = '';
        document.getElementById('modalCostoArticulo').value = '';
        document.getElementById('modalMinimoArticulo').value = '';
        document.getElementById('modalMaximoArticulo').value = '';
        document.getElementById('modalReordenArticulo').value = '';
        document.getElementById('modalFamiliaArticulo').value = 'Seleccionar familia';
        document.getElementById('modalSubfamiliaArticulo').value = 'Seleccionar subfamilia';
        document.getElementById('modalArticulo').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    // Función para editar artículo
    window.editarArticulo = function(codigo) {
        document.getElementById('modalTituloArticulo').textContent = 'Editar Artículo ' + codigo;
        
        // Simular carga de datos según el código
        if (codigo === 'HERR-001') {
            document.getElementById('modalCodigoArticulo').value = 'HERR-001';
            document.getElementById('modalNumeroParteArticulo').value = 'TLD-1001';
            document.getElementById('modalDescripcionArticulo').value = 'Taladro Percutor 1/2"';
            document.getElementById('modalStockArticulo').value = '25';
            document.getElementById('modalUbicacionArticulo').value = 'A-12';
            document.getElementById('modalCostoArticulo').value = '1250.00';
            document.getElementById('modalMinimoArticulo').value = '10';
            document.getElementById('modalMaximoArticulo').value = '50';
            document.getElementById('modalReordenArticulo').value = '15';
            document.getElementById('modalFamiliaArticulo').value = 'Herramientas';
            document.getElementById('modalSubfamiliaArticulo').value = 'Eléctricas';
        } else if (codigo === 'MAT-001') {
            document.getElementById('modalCodigoArticulo').value = 'MAT-001';
            document.getElementById('modalNumeroParteArticulo').value = 'CEM-50';
            document.getElementById('modalDescripcionArticulo').value = 'Cemento Gris 50kg';
            document.getElementById('modalStockArticulo').value = '350';
            document.getElementById('modalUbicacionArticulo').value = 'B-05';
            document.getElementById('modalCostoArticulo').value = '185.50';
            document.getElementById('modalMinimoArticulo').value = '200';
            document.getElementById('modalMaximoArticulo').value = '1000';
            document.getElementById('modalReordenArticulo').value = '300';
            document.getElementById('modalFamiliaArticulo').value = 'Materiales';
            document.getElementById('modalSubfamiliaArticulo').value = 'Construcción';
        } else {
            document.getElementById('modalCodigoArticulo').value = codigo;
            document.getElementById('modalNumeroParteArticulo').value = 'COD-' + codigo.substring(4);
            document.getElementById('modalDescripcionArticulo').value = 'Artículo de ejemplo';
            document.getElementById('modalStockArticulo').value = '10';
            document.getElementById('modalUbicacionArticulo').value = 'A-01';
            document.getElementById('modalCostoArticulo').value = '100.00';
            document.getElementById('modalMinimoArticulo').value = '5';
            document.getElementById('modalMaximoArticulo').value = '20';
            document.getElementById('modalReordenArticulo').value = '8';
            document.getElementById('modalFamiliaArticulo').value = 'Herramientas';
            document.getElementById('modalSubfamiliaArticulo').value = 'Manuales';
        }
        
        document.getElementById('modalArticulo').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalArticulo = function() {
        document.getElementById('modalArticulo').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.guardarArticulo = function() {
        const codigo = document.getElementById('modalCodigoArticulo').value;
        const descripcion = document.getElementById('modalDescripcionArticulo').value;
        
        if (!codigo || !descripcion) {
            alert('Por favor complete los campos obligatorios');
            return;
        }
        
        alert(`Artículo ${codigo} guardado correctamente`);
        cerrarModalArticulo();
    };
    
    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalArticulo();
        }
    });
    
    // Cerrar modal al hacer clic fuera
    document.getElementById('modalArticulo').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalArticulo();
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
                { field: 'codigo', caption: 'Código' },
                { field: 'descripcion', caption: 'Descripción' },
                { field: 'numero_parte', caption: 'Número Parte' },
                { field: 'stock', caption: 'Existencia' },
                { field: 'ubicacion', caption: 'Ubicación' },
                { field: 'costo', caption: 'Costo' },
                { field: 'minimo', caption: 'Mínimo' },
                { field: 'maximo', caption: 'Máximo' },
                { field: 'reorden', caption: 'Punto Reorden' },
                { field: 'familia', caption: 'Familia' },
                { field: 'subfamilia', caption: 'SubFamilia' }
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
    document.getElementById('btnExcel').addEventListener('click', () => alert('Exportar inventario a Excel'));

    // Buscador
    document.getElementById('buscador').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        console.log('Buscando en inventario:', termino);
    });
});
</script>
@endsection