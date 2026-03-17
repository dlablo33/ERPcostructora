@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Recibos de Nómina (Timbrados) -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-file-invoice" style="margin-right: 10px;"></i> Recibos de Nómina (Timbrados)
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- KPIs - Indicadores de nómina -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px; width: 100%;">
                    <!-- Total Recibos -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #2378e1; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Total Recibos</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">156</div>
                    </div>

                    <!-- Por Timbrar -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #ffc107; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #212529; margin-bottom: 3px;">Por Timbrar</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: #212529;">23</div>
                    </div>

                    <!-- Timbrados -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #28a745; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Timbrados</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">128</div>
                    </div>

                    <!-- Cancelados -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #dc3545; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Cancelados</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">5</div>
                    </div>
                </div>

                <!-- Filtros de período -->
                <div style="display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 5px; background-color: #f8f9fa; padding: 5px 10px; border-radius: 4px; border: 1px solid #dee2e6;">
                        <i class="fas fa-calendar-alt" style="color: var(--color-primary); font-size: 14px;"></i>
                        <span style="font-size: 13px; font-weight: 500;">Período:</span>
                        <span style="font-size: 13px;">Marzo 2025</span>
                    </div>
                    
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <button class="filtro-periodo" style="background-color: var(--color-primary); color: white; border: none; padding: 5px 15px; border-radius: 20px; font-size: 12px; cursor: pointer;">Ene-Mar</button>
                        <button class="filtro-periodo" style="background-color: transparent; color: var(--color-primary); border: 1px solid var(--color-primary); padding: 5px 15px; border-radius: 20px; font-size: 12px; cursor: pointer;">Abr-Jun</button>
                        <button class="filtro-periodo" style="background-color: transparent; color: var(--color-primary); border: 1px solid var(--color-primary); padding: 5px 15px; border-radius: 20px; font-size: 12px; cursor: pointer;">Jul-Sep</button>
                        <button class="filtro-periodo" style="background-color: transparent; color: var(--color-primary); border: 1px solid var(--color-primary); padding: 5px 15px; border-radius: 20px; font-size: 12px; cursor: pointer;">Oct-Dic</button>
                    </div>
                    
                    <div style="margin-left: auto; display: flex; gap: 10px;">
                        <select style="padding: 6px 10px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 12px;">
                            <option>2025</option>
                            <option>2024</option>
                            <option>2023</option>
                        </select>
                        <select style="padding: 6px 10px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 12px;">
                            <option>Enero</option>
                            <option>Febrero</option>
                            <option>Marzo</option>
                            <option>Abril</option>
                            <option>Mayo</option>
                            <option>Junio</option>
                            <option>Julio</option>
                            <option>Agosto</option>
                            <option>Septiembre</option>
                            <option>Octubre</option>
                            <option>Noviembre</option>
                            <option>Diciembre</option>
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
                        <!-- Botón Timbrar Seleccionados -->
                        <div>
                            <button id="btnTimbrar" 
                                    style="background-color: #28a745; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: white;"
                                    onclick="alert('Timbrar recibos seleccionados')">
                                <i class="fas fa-certificate"></i> Timbrar
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
                            <input type="text" id="buscador" placeholder="Buscar por empleado, RFC, folio..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Recibos de Nómina -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaRecibos" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1300px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 5%;">
                                    <input type="checkbox" id="seleccionarTodos" style="accent-color: white;">
                                </th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="folio">Folio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="uuid">UUID</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="empleado">Empleado</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="rfc">RFC</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="periodo">Período</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_pago">Fecha Pago</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="percepciones">Percepciones</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="deducciones">Deducciones</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="neto">Neto</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus_timbrado">Estatus Timbrado</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_timbrado">Fecha Timbrado</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;"><input type="checkbox" class="seleccionar-recibo" style="accent-color: var(--color-primary);"></td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">R-2025-001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-family: monospace; font-size: 10px;">A1B2C3D4-E5F6-7890-1234-567890ABCDEF</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JUAN CARLOS PÉREZ LÓPEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">PELJ850101</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Marzo 2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$12,500.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$2,300.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$10,200.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Timbrado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025 10:30</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver recibo R-2025-001')" title="Ver recibo"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Descargar PDF R-2025-001')" title="Descargar PDF"></i>
                                    <i class="fas fa-envelope" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Enviar por correo R-2025-001')" title="Enviar por correo"></i>
                                    <i class="fas fa-undo-alt" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Cancelar timbrado?')) alert('Timbrado cancelado')" title="Cancelar timbrado"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;"><input type="checkbox" class="seleccionar-recibo" style="accent-color: var(--color-primary);"></td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">R-2025-002</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-family: monospace; font-size: 10px;">F6E5D4C3-B2A1-0987-6543-21ABCDEF9876</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">MARÍA FERNANDA RAMOS GARCÍA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">ROGM900101</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Marzo 2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$11,200.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$2,100.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$9,100.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Timbrado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025 10:32</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver recibo R-2025-002')" title="Ver recibo"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Descargar PDF R-2025-002')" title="Descargar PDF"></i>
                                    <i class="fas fa-envelope" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Enviar por correo R-2025-002')" title="Enviar por correo"></i>
                                    <i class="fas fa-undo-alt" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Cancelar timbrado?')) alert('Timbrado cancelado')" title="Cancelar timbrado"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;"><input type="checkbox" class="seleccionar-recibo" style="accent-color: var(--color-primary);"></td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">R-2025-003</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-family: monospace; font-size: 10px;">9876-5432-10AB-CDEF-1234-567890ABCDEF</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">CARLOS ALBERTO MENDOZA SÁNCHEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">MESC880315</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Marzo 2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$14,800.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$2,800.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$12,000.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Timbrado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025 10:35</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver recibo R-2025-003')" title="Ver recibo"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Descargar PDF R-2025-003')" title="Descargar PDF"></i>
                                    <i class="fas fa-envelope" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Enviar por correo R-2025-003')" title="Enviar por correo"></i>
                                    <i class="fas fa-undo-alt" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Cancelar timbrado?')) alert('Timbrado cancelado')" title="Cancelar timbrado"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;"><input type="checkbox" class="seleccionar-recibo" style="accent-color: var(--color-primary);"></td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">R-2025-004</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-family: monospace; font-size: 10px;">ABCD-1234-EFGH-5678-IJKL-9012-MNOP</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ANA SOFÍA MARTÍNEZ FLORES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">MAFA920101</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Marzo 2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$10,500.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$1,900.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$8,600.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Por Timbrar</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver recibo R-2025-004')" title="Ver recibo"></i>
                                    <i class="fas fa-certificate" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="alert('Timbrar R-2025-004')" title="Timbrar"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar R-2025-004')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar recibo?')) alert('Recibo eliminado')" title="Eliminar"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;"><input type="checkbox" class="seleccionar-recibo" style="accent-color: var(--color-primary);"></td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">R-2025-005</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-family: monospace; font-size: 10px;">1234-5678-90AB-CDEF-1234-567890ABCDEF</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ROBERTO ANTONIO SÁNCHEZ TORRES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">SATR880220</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Marzo 2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$13,200.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$2,500.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$10,700.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Timbrado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/03/2025 10:40</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver recibo R-2025-005')" title="Ver recibo"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Descargar PDF R-2025-005')" title="Descargar PDF"></i>
                                    <i class="fas fa-envelope" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Enviar por correo R-2025-005')" title="Enviar por correo"></i>
                                    <i class="fas fa-undo-alt" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Cancelar timbrado?')) alert('Timbrado cancelado')" title="Cancelar timbrado"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;"><input type="checkbox" class="seleccionar-recibo" style="accent-color: var(--color-primary);"></td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">R-2025-006</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-family: monospace; font-size: 10px;">FEDC-BA09-8765-4321-0FED-CBA9-8765</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">LAURA PATRICIA FLORES GONZÁLEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">FOGL850101</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Febrero 2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">28/02/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$9,800.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$1,800.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$8,000.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Cancelado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">28/02/2025 09:15</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver recibo R-2025-006')" title="Ver recibo"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Descargar PDF R-2025-006')" title="Descargar PDF"></i>
                                    <i class="fas fa-redo-alt" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="alert('Re-timbrar R-2025-006')" title="Re-timbrar"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;"><input type="checkbox" class="seleccionar-recibo" style="accent-color: var(--color-primary);"></td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">R-2025-007</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-family: monospace; font-size: 10px;">A1B2-C3D4-E5F6-7890-1234-5678-90AB</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JOSÉ LUIS TORRES RAMÍREZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">TORJ801220</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Febrero 2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">28/02/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$15,500.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$3,000.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$12,500.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Timbrado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">28/02/2025 09:20</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver recibo R-2025-007')" title="Ver recibo"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Descargar PDF R-2025-007')" title="Descargar PDF"></i>
                                    <i class="fas fa-envelope" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Enviar por correo R-2025-007')" title="Enviar por correo"></i>
                                    <i class="fas fa-undo-alt" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Cancelar timbrado?')) alert('Timbrado cancelado')" title="Cancelar timbrado"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;"><input type="checkbox" class="seleccionar-recibo" style="accent-color: var(--color-primary);"></td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">R-2025-008</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-family: monospace; font-size: 10px;">1234-5678-90AB-CDEF-1234-567890ABCDEF</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">PATRICIA ELIZABETH CASTILLO VEGA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CAVP850101</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Febrero 2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">28/02/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$10,200.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$1,900.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$8,300.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px;">Timbrado</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">28/02/2025 09:25</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver recibo R-2025-008')" title="Ver recibo"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="alert('Descargar PDF R-2025-008')" title="Descargar PDF"></i>
                                    <i class="fas fa-envelope" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Enviar por correo R-2025-008')" title="Enviar por correo"></i>
                                    <i class="fas fa-undo-alt" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Cancelar timbrado?')) alert('Timbrado cancelado')" title="Cancelar timbrado"></i>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="7" style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right;">Totales:</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right; background-color: #e9ecef;">$97,700.00</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right; background-color: #e9ecef;">$18,300.00</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right; background-color: #e9ecef; font-weight: bold;">$79,400.00</td>
                                <td colspan="2" style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: center; background-color: #e9ecef;">Total Recibos: 8</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #e9ecef; box-shadow: -2px 0 5px rgba(0,0,0,0.1);"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Crear filtro y resumen -->
                <div style="margin-top: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter" style="font-size: 12px;"></i> Crear filtro
                    </button>
                    
                    <div style="display: flex; gap: 20px; font-size: 12px;">
                        <span><strong style="color: #28a745;">✓ Timbrados:</strong> 6</span>
                        <span><strong style="color: #ffc107;">⏱ Por Timbrar:</strong> 1</span>
                        <span><strong style="color: #dc3545;">✗ Cancelados:</strong> 1</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA VER RECIBO -->
<div id="modalVerRecibo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 800px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Recibo de Nómina - R-2025-001</h3>
            <button onclick="cerrarModalVerRecibo()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Contenido del recibo -->
        <div style="padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #e9ecef; padding-bottom: 15px;">
                <div>
                    <img src="https://via.placeholder.com/150x50/083CAE/FFFFFF?text=EMPRESA" alt="Logo empresa" style="height: 40px;">
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 20px; font-weight: bold; color: var(--color-primary);">RECIBO DE NÓMINA</div>
                    <div style="font-size: 12px; color: #6c757d;">Folio Fiscal: A1B2C3D4-E5F6-7890-1234-567890ABCDEF</div>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                <div>
                    <h4 style="font-size: 14px; font-weight: bold; color: var(--color-primary); margin: 0 0 10px 0;">Datos del Empleado</h4>
                    <table style="width: 100%; font-size: 12px;">
                        <tr><td style="padding: 4px 0; color: #6c757d;">Nombre:</td><td style="padding: 4px 0; font-weight: 500;">JUAN CARLOS PÉREZ LÓPEZ</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">RFC:</td><td style="padding: 4px 0;">PELJ850101</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">CURP:</td><td style="padding: 4px 0;">PELJ850101HDFRRN01</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">NSS:</td><td style="padding: 4px 0;">12345678901</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Área:</td><td style="padding: 4px 0;">Operaciones</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Puesto:</td><td style="padding: 4px 0;">Supervisor</td></tr>
                    </table>
                </div>
                <div>
                    <h4 style="font-size: 14px; font-weight: bold; color: var(--color-primary); margin: 0 0 10px 0;">Datos del Período</h4>
                    <table style="width: 100%; font-size: 12px;">
                        <tr><td style="padding: 4px 0; color: #6c757d;">Período:</td><td style="padding: 4px 0;">Marzo 2025</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Fecha Pago:</td><td style="padding: 4px 0;">15/03/2025</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Fecha Inicio:</td><td style="padding: 4px 0;">01/03/2025</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Fecha Fin:</td><td style="padding: 4px 0;">15/03/2025</td></tr>
                        <tr><td style="padding: 4px 0; color: #6c757d;">Días Pagados:</td><td style="padding: 4px 0;">15</td></tr>
                    </table>
                </div>
            </div>
            
            <div style="margin-bottom: 20px;">
                <h4 style="font-size: 14px; font-weight: bold; color: var(--color-primary); margin: 0 0 10px 0;">Percepciones</h4>
                <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6;">Concepto</th>
                            <th style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td style="padding: 8px; border: 1px solid #dee2e6;">Sueldo</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">$10,000.00</td></tr>
                        <tr><td style="padding: 8px; border: 1px solid #dee2e6;">Bono de productividad</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">$1,500.00</td></tr>
                        <tr><td style="padding: 8px; border: 1px solid #dee2e6;">Vales de despensa</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">$1,000.00</td></tr>
                        <tr style="background-color: #f8f9fa; font-weight: bold;">
                            <td style="padding: 8px; border: 1px solid #dee2e6;">Total Percepciones</td>
                            <td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">$12,500.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div style="margin-bottom: 20px;">
                <h4 style="font-size: 14px; font-weight: bold; color: var(--color-primary); margin: 0 0 10px 0;">Deducciones</h4>
                <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6;">Concepto</th>
                            <th style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td style="padding: 8px; border: 1px solid #dee2e6;">ISR</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">$1,500.00</td></tr>
                        <tr><td style="padding: 8px; border: 1px solid #dee2e6;">IMSS</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">$500.00</td></tr>
                        <tr><td style="padding: 8px; border: 1px solid #dee2e6;">Préstamo</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">$300.00</td></tr>
                        <tr style="background-color: #f8f9fa; font-weight: bold;">
                            <td style="padding: 8px; border: 1px solid #dee2e6;">Total Deducciones</td>
                            <td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">$2,300.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div style="background-color: #e9ecef; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 16px; font-weight: bold;">NETO A PAGAR</span>
                    <span style="font-size: 24px; font-weight: bold; color: var(--color-primary);">$10,200.00</span>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button onclick="cerrarModalVerRecibo()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cerrar</button>
                <button onclick="alert('Descargando PDF')" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
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
        min-width: 1300px;
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
    .table td:nth-child(5),
    .table td:nth-child(6),
    .table td:nth-child(7),
    .table td:nth-child(11),
    .table td:nth-child(12) {
        text-align: center;
    }
    
    .table td:nth-child(4) {
        text-align: left;
    }
    
    .table td:nth-child(8),
    .table td:nth-child(9),
    .table td:nth-child(10) {
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
    
    /* Badges de estatus timbrado */
    .badge-timbrado {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 80px;
        text-align: center;
    }
    
    .badge-por-timbrar {
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
    
    /* Filtros de período */
    .filtro-periodo {
        transition: all 0.2s;
    }
    
    .filtro-periodo:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
    #modalVerRecibo {
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
        
        #modalVerRecibo > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        #modalVerRecibo div[style*="grid-template-columns: repeat(2, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadas = [];
    
    // Seleccionar/deseleccionar todos los recibos
    document.getElementById('seleccionarTodos').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.seleccionar-recibo');
        checkboxes.forEach(cb => cb.checked = this.checked);
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
                { field: 'uuid', caption: 'UUID' },
                { field: 'empleado', caption: 'Empleado' },
                { field: 'rfc', caption: 'RFC' },
                { field: 'periodo', caption: 'Período' },
                { field: 'fecha_pago', caption: 'Fecha Pago' },
                { field: 'percepciones', caption: 'Percepciones' },
                { field: 'deducciones', caption: 'Deducciones' },
                { field: 'neto', caption: 'Neto' },
                { field: 'estatus_timbrado', caption: 'Estatus Timbrado' },
                { field: 'fecha_timbrado', caption: 'Fecha Timbrado' }
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
    
    // Filtros de período
    document.querySelectorAll('.filtro-periodo').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filtro-periodo').forEach(b => {
                b.style.backgroundColor = 'transparent';
                b.style.color = 'var(--color-primary)';
            });
            this.style.backgroundColor = 'var(--color-primary)';
            this.style.color = 'white';
        });
    });
});

// Funciones del modal
function abrirModalVerRecibo() {
    document.getElementById('modalVerRecibo').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalVerRecibo() {
    document.getElementById('modalVerRecibo').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Cerrar modal con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalVerRecibo();
    }
});

// Cerrar modal al hacer clic fuera
document.getElementById('modalVerRecibo').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalVerRecibo();
    }
});
</script>
@endsection