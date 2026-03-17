@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Control de Horarios -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Control de Horarios
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- KPIs - Indicadores de asistencia -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px; width: 100%;">
                    <!-- Total Empleados -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #2378e1; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Total Empleados</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">24</div>
                    </div>

                    <!-- En Horario -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #28a745; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">En Horario</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">18</div>
                    </div>

                    <!-- Retardos -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #ffc107; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #212529; margin-bottom: 3px;">Retardos</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: #212529;">4</div>
                    </div>

                    <!-- Ausentes -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #dc3545; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Ausentes</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">2</div>
                    </div>
                </div>

                <!-- Filtros rápidos de fecha -->
                <div style="display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 5px; background-color: #f8f9fa; padding: 5px 10px; border-radius: 4px; border: 1px solid #dee2e6;">
                        <i class="fas fa-calendar-alt" style="color: var(--color-primary); font-size: 14px;"></i>
                        <span style="font-size: 13px; font-weight: 500;">Hoy:</span>
                        <span style="font-size: 13px;">06/03/2025</span>
                    </div>
                    
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <button class="filtro-fecha" style="background-color: var(--color-primary); color: white; border: none; padding: 5px 15px; border-radius: 20px; font-size: 12px; cursor: pointer;">Hoy</button>
                        <button class="filtro-fecha" style="background-color: transparent; color: var(--color-primary); border: 1px solid var(--color-primary); padding: 5px 15px; border-radius: 20px; font-size: 12px; cursor: pointer;">Ayer</button>
                        <button class="filtro-fecha" style="background-color: transparent; color: var(--color-primary); border: 1px solid var(--color-primary); padding: 5px 15px; border-radius: 20px; font-size: 12px; cursor: pointer;">Esta semana</button>
                        <button class="filtro-fecha" style="background-color: transparent; color: var(--color-primary); border: 1px solid var(--color-primary); padding: 5px 15px; border-radius: 20px; font-size: 12px; cursor: pointer;">Este mes</button>
                    </div>
                    
                    <div style="margin-left: auto; display: flex; gap: 10px;">
                        <div style="position: relative;">
                            <i class="fas fa-calendar" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="date" style="padding: 6px 6px 6px 30px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 12px;">
                        </div>
                        <div style="position: relative;">
                            <i class="fas fa-calendar" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="date" style="padding: 6px 6px 6px 30px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 12px;">
                        </div>
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
                        <!-- Botón Registrar Entrada/Salida -->
                        <div>
                            <button id="btnRegistrar" 
                                    style="background-color: var(--color-primary); border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: white;"
                                    onclick="abrirModalRegistroHorario()">
                                <i class="fas fa-clock"></i> Registrar
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
                            <input type="text" id="buscador" placeholder="Buscar por empleado, área..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Control de Horarios -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaHorarios" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1200px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="empleado">Empleado</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="area">Área</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha">Fecha</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="entrada">Entrada</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="salida">Salida</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="horas">Horas</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="tipo">Tipo</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="observaciones">Observaciones</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JUAN CARLOS PÉREZ LÓPEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Operaciones</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">06/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">08:00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Regular</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar registro?')) alert('Registro eliminado')"></i>
                                    <i class="fas fa-history" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver historial')"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">MARÍA FERNANDA RAMOS GARCÍA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Administración</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">06/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">08:15</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Retardo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Regular</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Llegó 15 min tarde</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar registro?')) alert('Registro eliminado')"></i>
                                    <i class="fas fa-history" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver historial')"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">CARLOS ALBERTO MENDOZA SÁNCHEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Operaciones</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">06/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">07:50</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Regular</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar registro?')) alert('Registro eliminado')"></i>
                                    <i class="fas fa-history" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver historial')"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ANA SOFÍA MARTÍNEZ FLORES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">RRHH</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">06/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">08:00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Regular</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar registro?')) alert('Registro eliminado')"></i>
                                    <i class="fas fa-history" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver historial')"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ROBERTO ANTONIO SÁNCHEZ TORRES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Operaciones</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">06/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">09:30</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Retardo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Justificado</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Cita médica - Presenta justificante</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar registro?')) alert('Registro eliminado')"></i>
                                    <i class="fas fa-history" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver historial')"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">LAURA PATRICIA FLORES GONZÁLEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Ventas</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">06/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Ausente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">No ha registrado entrada</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar registro?')) alert('Registro eliminado')"></i>
                                    <i class="fas fa-history" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver historial')"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JOSÉ LUIS TORRES RAMÍREZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Almacén</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">05/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">07:00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15:30</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: bold;">8.5</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Completo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Regular</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar registro?')) alert('Registro eliminado')"></i>
                                    <i class="fas fa-history" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver historial')"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">PATRICIA ELIZABETH CASTILLO VEGA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Calidad</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">05/03/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">07:45</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">16:15</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: bold;">8.5</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Completo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Regular</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Editar registro')"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar registro?')) alert('Registro eliminado')"></i>
                                    <i class="fas fa-history" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver historial')"></i>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="9" style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right;">Total Registros:</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: center; background-color: #e9ecef;" id="totalRegistros">8</td>
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
                        <span><strong style="color: #28a745;">✓ En horario:</strong> 18</span>
                        <span><strong style="color: #ffc107;">⚠ Retardos:</strong> 4</span>
                        <span><strong style="color: #dc3545;">✗ Ausentes:</strong> 2</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA REGISTRO DE ENTRADA/SALIDA -->
<div id="modalRegistroHorario" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 500px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Registrar Entrada/Salida</h3>
            <button onclick="cerrarModalRegistroHorario()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <div style="text-align: center; margin-bottom: 20px;">
                <div style="font-size: 48px; color: var(--color-primary); margin-bottom: 10px;">
                    <i class="fas fa-clock"></i>
                </div>
                <div style="font-size: 24px; font-weight: bold; color: var(--color-primary);" id="horaActual">12:00:00</div>
                <div style="font-size: 14px; color: #6c757d;" id="fechaActual">06/03/2025</div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
                <div>
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
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Tipo de Registro</label>
                    <div style="display: flex; gap: 15px;">
                        <label style="display: flex; align-items: center; gap: 5px;">
                            <input type="radio" name="tipoRegistro" checked> Entrada
                        </label>
                        <label style="display: flex; align-items: center; gap: 5px;">
                            <input type="radio" name="tipoRegistro"> Salida
                        </label>
                        <label style="display: flex; align-items: center; gap: 5px;">
                            <input type="radio" name="tipoRegistro"> Ambos
                        </label>
                    </div>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Hora</label>
                    <input type="time" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="08:00">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Observaciones</label>
                    <textarea rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones..."></textarea>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalRegistroHorario()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="alert('Registro guardado')" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
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
        min-width: 1200px;
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
    .table td:nth-child(1) {
        text-align: left;
        font-weight: 500;
    }
    
    .table td:nth-child(2),
    .table td:nth-child(3),
    .table td:nth-child(4),
    .table td:nth-child(5),
    .table td:nth-child(6),
    .table td:nth-child(7),
    .table td:nth-child(8) {
        text-align: center;
    }
    
    .table td:nth-child(9) {
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
    .table td:last-child i.fa-history {
        color: var(--color-primary);
    }
    
    .table td:last-child i.fa-trash {
        color: #dc3545;
    }
    
    /* Badges de estatus */
    .badge-activo, .badge-completo {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-retardo {
        background-color: #ffc107;
        color: #212529;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-ausente {
        background-color: #dc3545;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    /* Filtros de fecha */
    .filtro-fecha {
        transition: all 0.2s;
    }
    
    .filtro-fecha:hover {
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
    #modalRegistroHorario {
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
        
        #modalRegistroHorario > div {
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
    // Actualizar hora en tiempo real
    function actualizarHora() {
        const ahora = new Date();
        const hora = ahora.getHours().toString().padStart(2, '0');
        const minutos = ahora.getMinutes().toString().padStart(2, '0');
        const segundos = ahora.getSeconds().toString().padStart(2, '0');
        document.getElementById('horaActual').textContent = `${hora}:${minutos}:${segundos}`;
        
        const dia = ahora.getDate().toString().padStart(2, '0');
        const mes = (ahora.getMonth() + 1).toString().padStart(2, '0');
        const año = ahora.getFullYear();
        document.getElementById('fechaActual').textContent = `${dia}/${mes}/${año}`;
    }
    
    setInterval(actualizarHora, 1000);
    actualizarHora();
    
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
                { field: 'empleado', caption: 'Empleado' },
                { field: 'area', caption: 'Área' },
                { field: 'fecha', caption: 'Fecha' },
                { field: 'entrada', caption: 'Entrada' },
                { field: 'salida', caption: 'Salida' },
                { field: 'horas', caption: 'Horas' },
                { field: 'estatus', caption: 'Estatus' },
                { field: 'tipo', caption: 'Tipo' },
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
    document.getElementById('btnCrearFiltro').addEventListener('click', () => alert('Funcionalidad de filtro en desarrollo'));
    document.getElementById('btnExcel').addEventListener('click', () => alert('Exportar a Excel'));

    // Buscador
    document.getElementById('buscador').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        console.log('Buscando:', termino);
    });
    
    // Filtros de fecha
    document.querySelectorAll('.filtro-fecha').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filtro-fecha').forEach(b => {
                b.style.backgroundColor = 'transparent';
                b.style.color = 'var(--color-primary)';
            });
            this.style.backgroundColor = 'var(--color-primary)';
            this.style.color = 'white';
        });
    });
});

// Funciones del modal
function abrirModalRegistroHorario() {
    document.getElementById('modalRegistroHorario').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalRegistroHorario() {
    document.getElementById('modalRegistroHorario').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Cerrar modal con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalRegistroHorario();
    }
});

// Cerrar modal al hacer clic fuera
document.getElementById('modalRegistroHorario').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalRegistroHorario();
    }
});
</script>
@endsection