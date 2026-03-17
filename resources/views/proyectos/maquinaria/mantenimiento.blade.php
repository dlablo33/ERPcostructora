@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Mantenimiento de Equipo -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    
                    Mantenimiento de Equipo
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE MANTENIMIENTO CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: En Mantenimiento -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">En Mantenimiento</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="enMantenimiento">12</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Programados -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Programados</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="programados">18</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Completados Mes -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Completados</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="completados">24</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Costo Mensual -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Costo Mensual</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="costoMensual">$142K</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Selectores a la izquierda -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <select id="selectorProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 250px;">
                            <option value="">Todos los proyectos</option>
                            <option value="PRO-2024-001">PRO-2024-001 - Torre Norte Corporativa</option>
                            <option value="PRO-2024-002">PRO-2024-002 - Puente Vehicular Sur</option>
                            <option value="PRO-2024-003">PRO-2024-003 - Parque Industrial Norte</option>
                            <option value="PRO-2024-004">PRO-2024-004 - Hospital Regional</option>
                            <option value="PRO-2024-005">PRO-2024-005 - Planta Tratamiento</option>
                            <option value="PRO-2024-006">PRO-2024-006 - Urbanización Los Álamos</option>
                        </select>

                        <select id="selectorTipoMantto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 180px;">
                            <option value="">Todos los tipos</option>
                            <option value="Preventivo">Preventivo</option>
                            <option value="Correctivo">Correctivo</option>
                            <option value="Predictivo">Predictivo</option>
                        </select>

                        <select id="selectorStatus" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                            <option value="">Todos los estados</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="En Proceso">En Proceso</option>
                            <option value="Completado">Completado</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>
                    </div>
                    
                    <!-- Grupo de botones derecho -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Botón Registrar Mantenimiento -->
                        <div>
                            <button id="btnRegistrarMantto" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Registrar Mantenimiento">
                                <i class="fas fa-plus-circle"></i> Registrar
                            </button>
                        </div>

                        <!-- Botón Programar -->
                        <div>
                            <button id="btnProgramar" style="background-color: white; border: 1px solid #ffc107; color: #ffc107; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Programar Mantenimiento">
                                <i class="fas fa-calendar-plus"></i>
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                    title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar equipo..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Pestañas de secciones -->
                <div style="display: flex; gap: 2px; margin-bottom: 20px; border-bottom: 2px solid #083CAE; overflow-x: auto; white-space: nowrap;">
                    <button class="mantenimiento-tab active" data-tab="activos" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-wrench"></i> Mantenimientos Activos
                        <span style="background-color: #dc3545; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;">12</span>
                    </button>
                    <button class="mantenimiento-tab" data-tab="programados" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-calendar-alt"></i> Programados
                        <span style="background-color: #ffc107; color: #856404; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;">18</span>
                    </button>
                    <button class="mantenimiento-tab" data-tab="historial" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-history"></i> Historial
                    </button>
                    <button class="mantenimiento-tab" data-tab="costos" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-dollar-sign"></i> Costos
                    </button>
                    <button class="mantenimiento-tab" data-tab="alertas" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-exclamation-triangle"></i> Alertas
                        <span style="background-color: #dc3545; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;">5</span>
                    </button>
                </div>

                <!-- SECCIÓN 1: MANTENIMIENTOS ACTIVOS -->
                <div id="tab-activos" class="mantenimiento-content active">
                    <!-- Tabla de mantenimientos activos -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Equipo</th>
                                    <th style="padding: 12px;">Tipo</th>
                                    <th style="padding: 12px;">Proyecto</th>
                                    <th style="padding: 12px;">Fecha Inicio</th>
                                    <th style="padding: 12px;">Fecha Fin Estimada</th>
                                    <th style="padding: 12px;">Responsable</th>
                                    <th style="padding: 12px;">Estado</th>
                                    <th style="padding: 12px;">Prioridad</th>
                                    <th style="padding: 12px;">Avance</th>
                                    <th style="padding: 12px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px;"><strong>EX-002</strong> - Excavadora 320D</td>
                                    <td style="padding: 12px;"><span style="background-color: #cce5ff; color: #0d6efd; padding: 4px 8px; border-radius: 4px;">Preventivo</span></td>
                                    <td style="padding: 12px;">Torre Norte</td>
                                    <td style="padding: 12px;">10/03/2026</td>
                                    <td style="padding: 12px;">12/03/2026</td>
                                    <td style="padding: 12px;">Taller Mecánico</td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">En Proceso</span></td>
                                    <td style="padding: 12px;"><span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px;">Alta</span></td>
                                    <td style="padding: 12px;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 65%; height: 6px; background-color: #ffc107; border-radius: 3px;"></div>
                                            </div>
                                            65%
                                        </div>
                                    </td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalle" onclick="abrirDetalleMantenimiento('EX-002')"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Editar" onclick="editarMantenimiento('EX-002')"></i>
                                        <i class="fas fa-check-circle" style="color: #28a745; cursor: pointer; margin: 0 5px;" title="Completar" onclick="completarMantenimiento('EX-002')"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>CA-015</strong> - Camión Kenworth</td>
                                    <td style="padding: 12px;"><span style="background-color: #f8d7da; color: #dc3545; padding: 4px 8px; border-radius: 4px;">Correctivo</span></td>
                                    <td style="padding: 12px;">Puente Sur</td>
                                    <td style="padding: 12px;">08/03/2026</td>
                                    <td style="padding: 12px;">-</td>
                                    <td style="padding: 12px;">Taller Externo</td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">En Proceso</span></td>
                                    <td style="padding: 12px;"><span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px;">Alta</span></td>
                                    <td style="padding: 12px;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 40%; height: 6px; background-color: #ffc107; border-radius: 3px;"></div>
                                            </div>
                                            40%
                                        </div>
                                    </td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalle" onclick="abrirDetalleMantenimiento('CA-015')"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Editar" onclick="editarMantenimiento('CA-015')"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>GN-001</strong> - Generador</td>
                                    <td style="padding: 12px;"><span style="background-color: #cce5ff; color: #0d6efd; padding: 4px 8px; border-radius: 4px;">Preventivo</span></td>
                                    <td style="padding: 12px;">Parque Industrial</td>
                                    <td style="padding: 12px;">09/03/2026</td>
                                    <td style="padding: 12px;">10/03/2026</td>
                                    <td style="padding: 12px;">Taller Mecánico</td>
                                    <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Completado</span></td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">Media</span></td>
                                    <td style="padding: 12px;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 100%; height: 6px; background-color: #28a745; border-radius: 3px;"></div>
                                            </div>
                                            100%
                                        </div>
                                    </td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalle" onclick="abrirDetalleMantenimiento('GN-001')"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>RT-003</strong> - Retroexcavadora</td>
                                    <td style="padding: 12px;"><span style="background-color: #f8d7da; color: #dc3545; padding: 4px 8px; border-radius: 4px;">Correctivo</span></td>
                                    <td style="padding: 12px;">Hospital Regional</td>
                                    <td style="padding: 12px;">07/03/2026</td>
                                    <td style="padding: 12px;">09/03/2026</td>
                                    <td style="padding: 12px;">Taller Externo</td>
                                    <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Completado</span></td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">Media</span></td>
                                    <td style="padding: 12px;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 100%; height: 6px; background-color: #28a745; border-radius: 3px;"></div>
                                            </div>
                                            100%
                                        </div>
                                    </td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalle" onclick="abrirDetalleMantenimiento('RT-003')"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 2: PROGRAMADOS -->
                <div id="tab-programados" class="mantenimiento-content" style="display: none;">
                    <!-- Calendario de mantenimientos -->
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-calendar-alt"></i> Próximos 7 días
                            </h4>
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <div style="display: flex; align-items: center; padding: 8px; background-color: #f8f9fa; border-radius: 4px;">
                                    <div style="width: 60px; font-weight: bold;">12/03</div>
                                    <div style="flex: 1; margin-left: 10px;">EX-003 - Excavadora (Preventivo)</div>
                                    <span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">Programado</span>
                                </div>
                                <div style="display: flex; align-items: center; padding: 8px; background-color: #f8f9fa; border-radius: 4px;">
                                    <div style="width: 60px; font-weight: bold;">13/03</div>
                                    <div style="flex: 1; margin-left: 10px;">CA-012 - Camión (Correctivo)</div>
                                    <span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">Programado</span>
                                </div>
                                <div style="display: flex; align-items: center; padding: 8px; background-color: #f8f9fa; border-radius: 4px;">
                                    <div style="width: 60px; font-weight: bold;">14/03</div>
                                    <div style="flex: 1; margin-left: 10px;">GR-002 - Grúa (Preventivo)</div>
                                    <span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">Programado</span>
                                </div>
                                <div style="display: flex; align-items: center; padding: 8px; background-color: #f8f9fa; border-radius: 4px;">
                                    <div style="width: 60px; font-weight: bold;">15/03</div>
                                    <div style="flex: 1; margin-left: 10px;">RT-001 - Retro (Preventivo)</div>
                                    <span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">Programado</span>
                                </div>
                                <div style="display: flex; align-items: center; padding: 8px; background-color: #f8f9fa; border-radius: 4px;">
                                    <div style="width: 60px; font-weight: bold;">16/03</div>
                                    <div style="flex: 1; margin-left: 10px;">GN-002 - Generador (Preventivo)</div>
                                    <span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">Programado</span>
                                </div>
                            </div>
                        </div>

                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-pie"></i> Por Tipo
                            </h4>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Preventivo</span>
                                    <span style="font-size: 13px; font-weight: 600;">12 (67%)</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 67%; height: 8px; background-color: #0d6efd; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Correctivo</span>
                                    <span style="font-size: 13px; font-weight: 600;">4 (22%)</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 22%; height: 8px; background-color: #dc3545; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Predictivo</span>
                                    <span style="font-size: 13px; font-weight: 600;">2 (11%)</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 11%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de mantenimientos programados -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Equipo</th>
                                    <th style="padding: 12px;">Tipo</th>
                                    <th style="padding: 12px;">Proyecto</th>
                                    <th style="padding: 12px;">Fecha Programada</th>
                                    <th style="padding: 12px;">Técnico Asignado</th>
                                    <th style="padding: 12px;">Prioridad</th>
                                    <th style="padding: 12px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px;">EX-003 - Excavadora</td>
                                    <td style="padding: 12px;"><span style="background-color: #cce5ff; color: #0d6efd; padding: 4px 8px; border-radius: 4px;">Preventivo</span></td>
                                    <td style="padding: 12px;">Torre Norte</td>
                                    <td style="padding: 12px;">12/03/2026</td>
                                    <td style="padding: 12px;">Taller Mecánico</td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">Media</span></td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="editarProgramacion('EX-003')"></i>
                                        <i class="fas fa-play" style="color: #28a745; cursor: pointer; margin: 0 5px;" title="Iniciar" onclick="iniciarMantenimiento('EX-003')"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">CA-012 - Camión</td>
                                    <td style="padding: 12px;"><span style="background-color: #f8d7da; color: #dc3545; padding: 4px 8px; border-radius: 4px;">Correctivo</span></td>
                                    <td style="padding: 12px;">Puente Sur</td>
                                    <td style="padding: 12px;">13/03/2026</td>
                                    <td style="padding: 12px;">Taller Externo</td>
                                    <td style="padding: 12px;"><span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px;">Alta</span></td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="editarProgramacion('CA-012')"></i>
                                        <i class="fas fa-play" style="color: #28a745; cursor: pointer; margin: 0 5px;" onclick="iniciarMantenimiento('CA-012')"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 3: HISTORIAL -->
                <div id="tab-historial" class="mantenimiento-content" style="display: none;">
                    <!-- Filtros de historial -->
                    <div style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                        <select id="filtroPeriodo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="30">Últimos 30 días</option>
                            <option value="90">Últimos 90 días</option>
                            <option value="365">Este año</option>
                            <option value="2025">2025</option>
                        </select>
                        <select id="filtroTipoHistorial" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="">Todos los tipos</option>
                            <option value="Preventivo">Preventivo</option>
                            <option value="Correctivo">Correctivo</option>
                        </select>
                    </div>

                    <!-- Tabla de historial -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Fecha</th>
                                    <th style="padding: 12px;">Equipo</th>
                                    <th style="padding: 12px;">Tipo</th>
                                    <th style="padding: 12px;">Descripción</th>
                                    <th style="padding: 12px;">Responsable</th>
                                    <th style="padding: 12px; text-align: right;">Costo</th>
                                    <th style="padding: 12px;">Duración</th>
                                    <th style="padding: 12px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px;">10/03/2026</td>
                                    <td style="padding: 12px;">GN-001 - Generador</td>
                                    <td style="padding: 12px;"><span style="background-color: #cce5ff; color: #0d6efd; padding: 4px 8px; border-radius: 4px;">Preventivo</span></td>
                                    <td style="padding: 12px;">Cambio de aceite y filtros</td>
                                    <td style="padding: 12px;">Taller Mecánico</td>
                                    <td style="padding: 12px; text-align: right;">$3,200</td>
                                    <td style="padding: 12px;">2 hrs</td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="abrirDetalleMantenimiento('GN-001')"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;" title="Ver reporte" onclick="descargarReporte('GN-001')"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">08/03/2026</td>
                                    <td style="padding: 12px;">RT-003 - Retro</td>
                                    <td style="padding: 12px;"><span style="background-color: #f8d7da; color: #dc3545; padding: 4px 8px; border-radius: 4px;">Correctivo</span></td>
                                    <td style="padding: 12px;">Reparación de sistema hidráulico</td>
                                    <td style="padding: 12px;">Taller Externo</td>
                                    <td style="padding: 12px; text-align: right;">$12,500</td>
                                    <td style="padding: 12px;">8 hrs</td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="abrirDetalleMantenimiento('RT-003')"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;" onclick="descargarReporte('RT-003')"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">05/03/2026</td>
                                    <td style="padding: 12px;">EX-001 - Excavadora</td>
                                    <td style="padding: 12px;"><span style="background-color: #cce5ff; color: #0d6efd; padding: 4px 8px; border-radius: 4px;">Preventivo</span></td>
                                    <td style="padding: 12px;">Mantenimiento de 500 horas</td>
                                    <td style="padding: 12px;">Taller Mecánico</td>
                                    <td style="padding: 12px; text-align: right;">$5,800</td>
                                    <td style="padding: 12px;">4 hrs</td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="abrirDetalleMantenimiento('EX-001')"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;" onclick="descargarReporte('EX-001')"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">01/03/2026</td>
                                    <td style="padding: 12px;">CA-010 - Camión</td>
                                    <td style="padding: 12px;"><span style="background-color: #f8d7da; color: #dc3545; padding: 4px 8px; border-radius: 4px;">Correctivo</span></td>
                                    <td style="padding: 12px;">Cambio de neumáticos</td>
                                    <td style="padding: 12px;">Taller Externo</td>
                                    <td style="padding: 12px; text-align: right;">$8,400</td>
                                    <td style="padding: 12px;">3 hrs</td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="abrirDetalleMantenimiento('CA-010')"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;" onclick="descargarReporte('CA-010')"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 4: COSTOS -->
                <div id="tab-costos" class="mantenimiento-content" style="display: none;">
                    <!-- Gráficos de costos -->
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-line"></i> Costos Mensuales
                            </h4>
                            <div style="height: 200px; display: flex; align-items: flex-end; gap: 15px; justify-content: center;">
                                <div style="text-align: center;">
                                    <div style="height: 80px; width: 40px; background-color: #083CAE; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Ene</div>
                                    <div style="font-size: 10px;">$28K</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="height: 95px; width: 40px; background-color: #083CAE; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Feb</div>
                                    <div style="font-size: 10px;">$32K</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="height: 120px; width: 40px; background-color: #083CAE; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Mar</div>
                                    <div style="font-size: 10px;">$42K</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="height: 85px; width: 40px; background-color: #083CAE; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Abr</div>
                                    <div style="font-size: 10px;">$28K</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="height: 70px; width: 40px; background-color: #083CAE; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">May</div>
                                    <div style="font-size: 10px;">$24K</div>
                                </div>
                            </div>
                        </div>

                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-pie"></i> Distribución
                            </h4>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Preventivo</span>
                                    <span style="font-size: 13px; font-weight: 600;">$78K (55%)</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 55%; height: 8px; background-color: #0d6efd; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Correctivo</span>
                                    <span style="font-size: 13px; font-weight: 600;">$52K (37%)</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 37%; height: 8px; background-color: #dc3545; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Predictivo</span>
                                    <span style="font-size: 13px; font-weight: 600;">$12K (8%)</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 8%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de costos por equipo -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Equipo</th>
                                    <th style="padding: 12px;">No. Mantenimientos</th>
                                    <th style="padding: 12px; text-align: right;">Costo Total</th>
                                    <th style="padding: 12px; text-align: right;">Promedio por Mantto</th>
                                    <th style="padding: 12px; text-align: right;">Último Mantto</th>
                                    <th style="padding: 12px; text-align: center;">Tendencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px;">EX-001 - Excavadora</td>
                                    <td style="padding: 12px;">4</td>
                                    <td style="padding: 12px; text-align: right;">$18,500</td>
                                    <td style="padding: 12px; text-align: right;">$4,625</td>
                                    <td style="padding: 12px; text-align: right;">05/03/2026</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">↓ 5%</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">CA-010 - Camión</td>
                                    <td style="padding: 12px;">6</td>
                                    <td style="padding: 12px; text-align: right;">$32,400</td>
                                    <td style="padding: 12px; text-align: right;">$5,400</td>
                                    <td style="padding: 12px; text-align: right;">01/03/2026</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">↓ 2%</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">RT-003 - Retro</td>
                                    <td style="padding: 12px;">3</td>
                                    <td style="padding: 12px; text-align: right;">$21,200</td>
                                    <td style="padding: 12px; text-align: right;">$7,067</td>
                                    <td style="padding: 12px; text-align: right;">08/03/2026</td>
                                    <td style="padding: 12px; text-align: center; color: #dc3545;">↑ 12%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 5: ALERTAS -->
                <div id="tab-alertas" class="mantenimiento-content" style="display: none;">
                    <div style="margin-bottom: 20px;">
                        <!-- Alertas críticas -->
                        <h4 style="color: #dc3545; margin: 0 0 10px 0; font-size: 16px;">
                            <i class="fas fa-exclamation-circle"></i> Críticas
                        </h4>
                        <div style="background-color: #f8d7da; border-left: 4px solid #dc3545; border-radius: 4px; padding: 15px; margin-bottom: 10px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-exclamation-circle" style="color: #dc3545; font-size: 24px;"></i>
                                <div style="flex: 1;">
                                    <h4 style="margin: 0; font-size: 14px; color: #721c24;">Mantenimiento Vencido - EX-002</h4>
                                    <p style="margin: 5px 0 0; font-size: 13px;">El mantenimiento programado para el 05/03/2026 no se ha realizado</p>
                                </div>
                                <span style="color: #dc3545; font-weight: bold;">Hace 5 días</span>
                            </div>
                        </div>

                        <!-- Alertas preventivas -->
                        <h4 style="color: #ffc107; margin: 20px 0 10px 0; font-size: 16px;">
                            <i class="fas fa-exclamation-triangle"></i> Preventivas
                        </h4>
                        <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px; padding: 15px; margin-bottom: 10px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-exclamation-triangle" style="color: #856404; font-size: 24px;"></i>
                                <div style="flex: 1;">
                                    <h4 style="margin: 0; font-size: 14px; color: #856404;">Próximo Mantenimiento - 3 equipos</h4>
                                    <p style="margin: 5px 0 0; font-size: 13px;">CA-010, RT-001 y GN-002 requieren mantenimiento en 3 días</p>
                                </div>
                                <span style="color: #856404; font-weight: bold;">En 3 días</span>
                            </div>
                        </div>
                        <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px; padding: 15px; margin-bottom: 10px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-clock" style="color: #856404; font-size: 24px;"></i>
                                <div style="flex: 1;">
                                    <h4 style="margin: 0; font-size: 14px; color: #856404;">Horas de operación cercanas al límite</h4>
                                    <p style="margin: 5px 0 0; font-size: 13px;">EX-003 ha alcanzado 450 horas desde último mantenimiento (límite 500)</p>
                                </div>
                                <span style="color: #856404; font-weight: bold;">50 hrs restantes</span>
                            </div>
                        </div>

                        <!-- Información -->
                        <h4 style="color: #0d6efd; margin: 20px 0 10px 0; font-size: 16px;">
                            <i class="fas fa-info-circle"></i> Información
                        </h4>
                        <div style="background-color: #cce5ff; border-left: 4px solid #0d6efd; border-radius: 4px; padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-info-circle" style="color: #0d6efd; font-size: 24px;"></i>
                                <div style="flex: 1;">
                                    <h4 style="margin: 0; font-size: 14px; color: #0d6efd;">Reporte mensual disponible</h4>
                                    <p style="margin: 5px 0 0; font-size: 13px;">El reporte de mantenimiento de febrero está listo para descargar</p>
                                </div>
                                <button style="background-color: #0d6efd; color: white; border: none; border-radius: 4px; padding: 5px 10px; cursor: pointer;" onclick="descargarReporteMensual()">Descargar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Registrar Mantenimiento -->
<div id="modalRegistrarMantto" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #083CAE;"><i class="fas fa-tools"></i> Registrar Mantenimiento</h3>
            <button id="btnCerrarModalMantto" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #6c757d;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Equipo <span style="color: #dc3545;">*</span></label>
                <select id="modalEquipo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="">Seleccionar equipo...</option>
                    <option value="EX-001">EX-001 - Excavadora 320D</option>
                    <option value="EX-002">EX-002 - Excavadora 320D</option>
                    <option value="CA-010">CA-010 - Camión Kenworth</option>
                    <option value="RT-005">RT-005 - Retroexcavadora</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipo de Mantenimiento</label>
                    <select id="modalTipoMantto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Preventivo">Preventivo</option>
                        <option value="Correctivo">Correctivo</option>
                        <option value="Predictivo">Predictivo</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Prioridad</label>
                    <select id="modalPrioridad" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Alta">Alta</option>
                        <option value="Media">Media</option>
                        <option value="Baja">Baja</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha de Inicio</label>
                    <input type="date" id="modalFechaInicio" value="2026-03-11" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha Estimada Fin</label>
                    <input type="date" id="modalFechaFin" value="2026-03-12" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Responsable</label>
                <input type="text" id="modalResponsable" placeholder="Taller Mecánico / Proveedor" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción del trabajo</label>
                <textarea id="modalDescripcion" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Describa las actividades a realizar..."></textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Costo Estimado</label>
                <input type="number" id="modalCosto" placeholder="0.00" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelarMantto" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button id="btnGuardarMantto" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Registrar</button>
        </div>
    </div>
</div>

<!-- Modal para Ver Detalles de Mantenimiento -->
<div id="modalVerDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto;">
        <!-- Cabecera del modal -->
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-clipboard-list"></i> 
                Detalle de Mantenimiento
            </h3>
            <button id="btnCerrarDetalle" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="padding: 20px;">
            <!-- Información general del mantenimiento -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                <!-- Tarjeta de equipo -->
                <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; border: 1px solid #dee2e6;">
                    <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-tractor"></i> Información del Equipo
                    </h4>
                    <table style="width: 100%; font-size: 13px;">
                        <tr>
                            <td style="padding: 5px 0; color: #6c757d;">ID Equipo:</td>
                            <td style="padding: 5px 0; font-weight: 600;" id="detalleIdEquipo">EX-001</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 0; color: #6c757d;">Tipo:</td>
                            <td style="padding: 5px 0;" id="detalleTipoEquipo">Excavadora 320D</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 0; color: #6c757d;">Proyecto:</td>
                            <td style="padding: 5px 0;" id="detalleProyecto">Torre Norte Corporativa</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 0; color: #6c757d;">Horómetro actual:</td>
                            <td style="padding: 5px 0; font-weight: 600;" id="detalleHorometro">1,245 hrs</td>
                        </tr>
                    </table>
                </div>

                <!-- Tarjeta de resumen -->
                <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; border: 1px solid #dee2e6;">
                    <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-info-circle"></i> Resumen
                    </h4>
                    <table style="width: 100%; font-size: 13px;">
                        <tr>
                            <td style="padding: 5px 0; color: #6c757d;">Tipo Mantenimiento:</td>
                            <td style="padding: 5px 0;">
                                <span id="detalleTipoMantto" style="background-color: #cce5ff; color: #0d6efd; padding: 4px 8px; border-radius: 4px;">Preventivo</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 0; color: #6c757d;">Prioridad:</td>
                            <td style="padding: 5px 0;">
                                <span id="detallePrioridad" style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px;">Alta</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 0; color: #6c757d;">Estado:</td>
                            <td style="padding: 5px 0;">
                                <span id="detalleEstado" style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">En Proceso</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 0; color: #6c757d;">Avance:</td>
                            <td style="padding: 5px 0;">
                                <div style="display: flex; align-items: center; gap: 5px;">
                                    <div style="width: 100px; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                        <div id="detalleBarraAvance" style="width: 65%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                    </div>
                                    <span id="detalleAvance">65%</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Fechas y responsables -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 25px;">
                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">Fecha de Inicio</div>
                    <div style="font-size: 15px; font-weight: 600; color: #083CAE;" id="detalleFechaInicio">10/03/2026</div>
                    <div style="font-size: 11px; color: #6c757d;" id="detalleHoraInicio">08:00 hrs</div>
                </div>
                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">Fecha Estimada Fin</div>
                    <div style="font-size: 15px; font-weight: 600; color: #083CAE;" id="detalleFechaFin">12/03/2026</div>
                    <div style="font-size: 11px; color: #6c757d;" id="detalleHoraFin">18:00 hrs</div>
                </div>
                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">Responsable</div>
                    <div style="font-size: 15px; font-weight: 600; color: #083CAE;" id="detalleResponsable">Taller Mecánico</div>
                    <div style="font-size: 11px; color: #6c757d;" id="detalleResponsableNombre">Ing. Roberto Sánchez</div>
                </div>
            </div>

            <!-- Descripción detallada -->
            <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 15px; margin-bottom: 25px;">
                <h4 style="color: #083CAE; margin: 0 0 10px 0; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-align-left"></i> Descripción del Trabajo
                </h4>
                <p id="detalleDescripcion" style="margin: 0; font-size: 13px; line-height: 1.6; color: #495057;">
                    Mantenimiento preventivo de 500 horas. Incluye cambio de aceite de motor, 
                    filtros de aceite y combustible, lubricación general de puntos de engrase, 
                    revisión de niveles de fluidos, inspección de mangueras y conexiones hidráulicas, 
                    verificación de frenos y sistemas de seguridad.
                </p>
            </div>

            <!-- Lista de actividades -->
            <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 15px; margin-bottom: 25px;">
                <h4 style="color: #083CAE; margin: 0 0 10px 0; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-tasks"></i> Actividades Realizadas
                </h4>
                <div id="listaActividades" style="display: flex; flex-direction: column; gap: 8px;">
                    <div style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                        <i class="fas fa-check-circle" style="color: #28a745;"></i>
                        <span style="font-size: 13px;">Cambio de aceite de motor</span>
                        <span style="margin-left: auto; font-size: 11px; color: #6c757d;">10/03/2026</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                        <i class="fas fa-check-circle" style="color: #28a745;"></i>
                        <span style="font-size: 13px;">Cambio de filtros de aceite y combustible</span>
                        <span style="margin-left: auto; font-size: 11px; color: #6c757d;">10/03/2026</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                        <i class="fas fa-check-circle" style="color: #28a745;"></i>
                        <span style="font-size: 13px;">Lubricación general</span>
                        <span style="margin-left: auto; font-size: 11px; color: #6c757d;">11/03/2026</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                        <i class="fas fa-spinner" style="color: #ffc107;"></i>
                        <span style="font-size: 13px;">Revisión de sistema hidráulico</span>
                        <span style="margin-left: auto; font-size: 11px; color: #6c757d;">En progreso</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                        <i class="fas fa-clock" style="color: #6c757d;"></i>
                        <span style="font-size: 13px;">Pruebas de funcionamiento</span>
                        <span style="margin-left: auto; font-size: 11px; color: #6c757d;">Pendiente</span>
                    </div>
                </div>
            </div>

            <!-- Costos y repuestos -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 25px;">
                <!-- Costos -->
                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 15px;">
                    <h4 style="color: #083CAE; margin: 0 0 10px 0; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-dollar-sign"></i> Costos
                    </h4>
                    <table id="tablaCostos" style="width: 100%; font-size: 13px;">
                        <tr>
                            <td style="padding: 5px 0;">Mano de obra:</td>
                            <td style="padding: 5px 0; text-align: right;" id="costoManoObra">$2,400</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 0;">Repuestos:</td>
                            <td style="padding: 5px 0; text-align: right;" id="costoRepuestos">$3,850</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 0;">Insumos:</td>
                            <td style="padding: 5px 0; text-align: right;" id="costoInsumos">$550</td>
                        </tr>
                        <tr style="border-top: 1px solid #dee2e6;">
                            <td style="padding: 8px 0; font-weight: 600;">Total:</td>
                            <td style="padding: 8px 0; text-align: right; font-weight: 600; color: #083CAE;" id="costoTotal">$6,800</td>
                        </tr>
                    </table>
                </div>

                <!-- Repuestos utilizados -->
                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 15px;">
                    <h4 style="color: #083CAE; margin: 0 0 10px 0; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-box"></i> Repuestos Utilizados
                    </h4>
                    <div id="listaRepuestos" style="font-size: 12px;">
                        <div style="display: flex; justify-content: space-between; padding: 4px 0;">
                            <span>Filtro de aceite (2 unidades)</span>
                            <span>$800</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 4px 0;">
                            <span>Filtro de combustible</span>
                            <span>$450</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 4px 0;">
                            <span>Aceite 15W-40 (20 litros)</span>
                            <span>$2,200</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 4px 0;">
                            <span>Grasa multipropósito</span>
                            <span>$400</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Observaciones y documentos -->
            <div style="background-color: #f8f9fa; border-radius: 6px; padding: 15px; margin-bottom: 20px;">
                <h4 style="color: #083CAE; margin: 0 0 10px 0; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-clipboard"></i> Observaciones
                </h4>
                <p id="detalleObservaciones" style="margin: 0 0 15px 0; font-size: 13px; color: #495057;">
                    Se detectó desgaste prematuro en mangueras hidráulicas. Se recomienda programar 
                    reemplazo en próximo mantenimiento. El equipo opera dentro de parámetros normales.
                </p>
                
                <h4 style="color: #083CAE; margin: 15px 0 10px 0; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-paperclip"></i> Documentos Adjuntos
                </h4>
                <div id="listaDocumentos" style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 4px; padding: 8px 12px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-file-pdf" style="color: #dc3545;"></i>
                        <span style="font-size: 12px;">Reporte_Inspeccion.pdf</span>
                        <i class="fas fa-download" style="color: #083CAE; cursor: pointer;" onclick="descargarArchivo('Reporte_Inspeccion.pdf')"></i>
                    </div>
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 4px; padding: 8px 12px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-camera" style="color: #6c757d;"></i>
                        <span style="font-size: 12px;">Fotos_Evidencia.zip</span>
                        <i class="fas fa-download" style="color: #083CAE; cursor: pointer;" onclick="descargarArchivo('Fotos_Evidencia.zip')"></i>
                    </div>
                </div>
            </div>

            <!-- Historial de cambios -->
            <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 15px; margin-bottom: 20px;">
                <h4 style="color: #083CAE; margin: 0 0 10px 0; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-history"></i> Historial de Cambios
                </h4>
                <div id="historialCambios" style="font-size: 12px;">
                    <div style="display: flex; gap: 10px; padding: 5px 0; border-bottom: 1px dashed #dee2e6;">
                        <span style="color: #6c757d; min-width: 80px;">10/03 10:30</span>
                        <span style="color: #083CAE;">Estado cambiado a "En Proceso"</span>
                        <span style="margin-left: auto; color: #6c757d;">por J. Pérez</span>
                    </div>
                    <div style="display: flex; gap: 10px; padding: 5px 0; border-bottom: 1px dashed #dee2e6;">
                        <span style="color: #6c757d; min-width: 80px;">10/03 08:15</span>
                        <span style="color: #083CAE;">Mantenimiento registrado</span>
                        <span style="margin-left: auto; color: #6c757d;">por sistema</span>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div style="display: flex; justify-content: flex-end; gap: 10px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                <button id="btnCompletarMantto" style="padding: 10px 20px; background-color: white; border: 1px solid #28a745; color: #28a745; border-radius: 4px; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                    <i class="fas fa-check-circle"></i> Completar
                </button>
                <button id="btnEditarMantto" style="padding: 10px 20px; background-color: white; border: 1px solid #ffc107; color: #ffc107; border-radius: 4px; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                    <i class="fas fa-edit"></i> Editar
                </button>
                <button id="btnImprimirReporte" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                    <i class="fas fa-print"></i> Imprimir Reporte
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .semaforo .card-header {
        background-color: #f4f6f9;
        border-bottom: 2px solid #083CAE;
    }
    
    .semaforo .card-header h2 {
        color: #083CAE !important;
    }
    
    .custom-card {
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    
    .custom-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(8, 60, 174, 0.15) !important;
        border-color: #083CAE !important;
    }
    
    /* Estilos de tabla */
    .table th {
        white-space: nowrap;
        font-size: 12px;
        background-color: #2378e1 !important;
        color: white;
        font-weight: 600;
        padding: 10px 4px;
    }
    
    .table td {
        white-space: nowrap;
        font-size: 12px;
        padding: 10px 4px;
        color: #000000 !important;
    }
    
    /* Pestañas */
    .mantenimiento-tab {
        transition: all 0.3s ease;
    }
    
    .mantenimiento-tab:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    
    .mantenimiento-tab.active {
        background-color: #083CAE !important;
        color: white !important;
    }
    
    .mantenimiento-content {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        div[style*="justify-content: flex-end"] {
            justify-content: center !important;
        }
        
        select {
            width: 100% !important;
        }
        
        button {
            width: 100%;
        }
        
        div[style*="position: relative"] {
            width: 100%;
        }
        
        input#buscador {
            width: 100% !important;
        }
        
        .mantenimiento-tab {
            padding: 8px 12px !important;
            font-size: 12px !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado - Mantenimiento de Equipo');
        
        // Elementos del DOM
        const selectorProyecto = document.getElementById('selectorProyecto');
        const selectorTipoMantto = document.getElementById('selectorTipoMantto');
        const selectorStatus = document.getElementById('selectorStatus');
        const filtroPeriodo = document.getElementById('filtroPeriodo');
        const filtroTipoHistorial = document.getElementById('filtroTipoHistorial');
        const buscador = document.getElementById('buscador');
        const btnRegistrarMantto = document.getElementById('btnRegistrarMantto');
        const btnProgramar = document.getElementById('btnProgramar');
        const btnExcel = document.getElementById('btnExcel');
        
        // Pestañas
        const mantenimientoTabs = document.querySelectorAll('.mantenimiento-tab');
        const mantenimientoContents = document.querySelectorAll('.mantenimiento-content');
        
        // Elementos del modal de registro
        const modalRegistrarMantto = document.getElementById('modalRegistrarMantto');
        const btnCerrarModalMantto = document.getElementById('btnCerrarModalMantto');
        const btnCancelarMantto = document.getElementById('btnCancelarMantto');
        const btnGuardarMantto = document.getElementById('btnGuardarMantto');
        
        // Elementos del modal de detalle
        const modalVerDetalle = document.getElementById('modalVerDetalle');
        const btnCerrarDetalle = document.getElementById('btnCerrarDetalle');
        const btnCompletarMantto = document.getElementById('btnCompletarMantto');
        const btnEditarMantto = document.getElementById('btnEditarMantto');
        const btnImprimirReporte = document.getElementById('btnImprimirReporte');
        
        // Cambio de pestañas
        mantenimientoTabs.forEach((tab, index) => {
            tab.addEventListener('click', function() {
                mantenimientoTabs.forEach(t => {
                    t.classList.remove('active');
                    t.style.backgroundColor = '#e9ecef';
                    t.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                mantenimientoContents.forEach(content => content.style.display = 'none');
                mantenimientoContents[index].style.display = 'block';
            });
        });
        
        // Event Listeners para filtros
        selectorProyecto.addEventListener('change', function() {
            console.log('Filtrando por proyecto:', this.value);
        });
        
        selectorTipoMantto.addEventListener('change', function() {
            console.log('Filtrando por tipo:', this.value);
        });
        
        selectorStatus.addEventListener('change', function() {
            console.log('Filtrando por estado:', this.value);
        });
        
        if (filtroPeriodo) {
            filtroPeriodo.addEventListener('change', function() {
                console.log('Filtrando por período:', this.value);
            });
        }
        
        if (filtroTipoHistorial) {
            filtroTipoHistorial.addEventListener('change', function() {
                console.log('Filtrando historial por tipo:', this.value);
            });
        }
        
        buscador.addEventListener('input', function(e) {
            console.log('Buscando:', e.target.value);
        });
        
        // Botones de acción
        btnRegistrarMantto.addEventListener('click', function() {
            modalRegistrarMantto.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
        
        btnProgramar.addEventListener('click', function() {
            alert('Programar mantenimiento - Funcionalidad en desarrollo');
        });
        
        btnExcel.addEventListener('click', function() {
            alert('Exportando a Excel...');
        });
        
        // Modal de registro
        function cerrarModalRegistro() {
            modalRegistrarMantto.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        btnCerrarModalMantto.addEventListener('click', cerrarModalRegistro);
        btnCancelarMantto.addEventListener('click', cerrarModalRegistro);
        
        btnGuardarMantto.addEventListener('click', function() {
            const equipo = document.getElementById('modalEquipo').value;
            const tipo = document.getElementById('modalTipoMantto').value;
            const fechaInicio = document.getElementById('modalFechaInicio').value;
            
            if (!equipo || !fechaInicio) {
                alert('Por favor complete los campos requeridos');
                return;
            }
            
            alert('Mantenimiento registrado correctamente');
            cerrarModalRegistro();
        });
        
        // Cerrar modal al hacer clic fuera
        window.addEventListener('click', function(event) {
            if (event.target === modalRegistrarMantto) {
                cerrarModalRegistro();
            }
            if (event.target === modalVerDetalle) {
                cerrarModalDetalle();
            }
        });
        
        // Modal de detalle
        window.abrirDetalleMantenimiento = function(id) {
            console.log('Abriendo detalle de mantenimiento:', id);
            
            // Aquí podrías cargar datos dinámicamente según el ID
            // Por ahora usamos datos de ejemplo
            document.getElementById('detalleIdEquipo').textContent = id;
            
            modalVerDetalle.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };
        
        function cerrarModalDetalle() {
            modalVerDetalle.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        btnCerrarDetalle.addEventListener('click', cerrarModalDetalle);
        
        btnCompletarMantto.addEventListener('click', function() {
            if (confirm('¿Está seguro de marcar este mantenimiento como completado?')) {
                alert('Mantenimiento completado');
                cerrarModalDetalle();
            }
        });
        
        btnEditarMantto.addEventListener('click', function() {
            alert('Editar mantenimiento - Funcionalidad en desarrollo');
            cerrarModalDetalle();
        });
        
        btnImprimirReporte.addEventListener('click', function() {
            alert('Generando reporte PDF...');
        });
        
        // Otras funciones
        window.editarMantenimiento = function(id) {
            alert('Editar mantenimiento ' + id);
        };
        
        window.completarMantenimiento = function(id) {
            if (confirm('¿Está seguro de marcar este mantenimiento como completado?')) {
                alert('Mantenimiento ' + id + ' completado');
            }
        };
        
        window.editarProgramacion = function(id) {
            alert('Editar programación ' + id);
        };
        
        window.iniciarMantenimiento = function(id) {
            alert('Iniciar mantenimiento ' + id);
        };
        
        window.descargarReporte = function(id) {
            alert('Descargando reporte de ' + id);
        };
        
        window.descargarReporteMensual = function() {
            alert('Descargando reporte mensual...');
        };
        
        window.descargarArchivo = function(nombre) {
            alert('Descargando ' + nombre);
        };
    });
</script>
@endsection