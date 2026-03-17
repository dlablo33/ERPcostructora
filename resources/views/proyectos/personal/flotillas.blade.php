@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Asistencia y Cuadrillas -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Asistencia y Cuadrillas
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE ASISTENCIA CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Total Personal -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Personal</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalPersonal">187</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Presente Hoy -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Presente Hoy</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalPresente">142</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Ausente Hoy -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Ausente Hoy</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalAusente">45</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: % Asistencia -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">% Asistencia</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="porcentajeAsistencia">76%</div>
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

                        <!-- Selector de fecha -->
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <input type="date" id="fechaAsistencia" value="2026-03-11" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>

                        <select id="selectorCuadrilla" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                            <option value="">Todas las cuadrillas</option>
                            <option value="A">Cuadrilla A - Cimentación</option>
                            <option value="B">Cuadrilla B - Estructura</option>
                            <option value="C">Cuadrilla C - Acabados</option>
                            <option value="D">Cuadrilla D - Instalaciones</option>
                            <option value="E">Cuadrilla E - Obra Negra</option>
                        </select>
                    </div>
                    
                    <!-- Grupo de botones derecho -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Botón Tomar Asistencia -->
                        <div>
                            <button id="btnTomarAsistencia" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Tomar Asistencia">
                                <i class="fas fa-clipboard-check"></i> Tomar Asistencia
                            </button>
                        </div>

                        <!-- Botón Agregar Cuadrilla -->
                        <div>
                            <button id="btnAgregarCuadrilla" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #083CAE; font-size: 16px;" title="Agregar Cuadrilla">
                                <i class="fas fa-plus" style="color: #083CAE;"></i>
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
                            <input type="text" id="buscador" placeholder="Buscar personal..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Pestañas de secciones -->
                <div style="display: flex; gap: 2px; margin-bottom: 20px; border-bottom: 2px solid #083CAE;">
                    <button class="asistencia-tab active" data-tab="asistencia" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-clipboard-list"></i> Asistencia Diaria
                    </button>
                    <button class="asistencia-tab" data-tab="cuadrillas" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-users"></i> Cuadrillas
                    </button>
                    <button class="asistencia-tab" data-tab="resumen" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-chart-bar"></i> Reporte de Asistencia
                    </button>
                </div>

                <!-- SECCIÓN 1: ASISTENCIA DIARIA -->
                <div id="tab-asistencia" class="asistencia-content active">
                    <!-- Mensaje "Sin datos" centrado -->
                    <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                        <i class="fas fa-calendar-check" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                        <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin registros</h3>
                        <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros de asistencia para la fecha seleccionada</p>
                    </div>

                    <!-- Tabla de Asistencia -->
                    <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                        <table class="table table-bordered" id="tablaAsistencia" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                            <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                                <tr>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>No. Empleado</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Nombre</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Proyecto</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Cuadrilla</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Hora Entrada</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Hora Salida</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Horas</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Status</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Acciones</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodyAsistencia">
                                <!-- Las filas se insertarán dinámicamente con JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación (solo para asistencia) -->
                    <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px; background: transparent !important; background-color: transparent !important; border: none !important; box-shadow: none !important;">
                        <!-- Botón Ver todos (izquierda) - SIN FONDO -->
                        <button id="btnVerTodos" style="background: transparent !important; background-color: transparent !important; border: none !important; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: #2378e1; box-shadow: none !important; outline: none !important; margin: 0;">
                            <i class="fas fa-eye" style="font-size: 16px; color: #2378e1;"></i>
                            <span style="color: #2378e1;">Ver todos</span>
                        </button>
                        
                        <!-- Controles de paginación (derecha) - AZUL Y SIN FONDO -->
                        <div style="display: flex; align-items: center; gap: 5px; background: transparent; background-color: transparent;">
                            <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Primera página" id="btnPrimera">
                                <i class="fas fa-angle-double-left" style="color: #2378e1;"></i>
                            </button>
                            <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página anterior" id="btnAnterior">
                                <i class="fas fa-angle-left" style="color: #2378e1;"></i>
                            </button>
                            <span style="padding: 5px 10px; background-color: #2378e1; color: white; border-radius: 4px; font-size: 14px;" id="paginaActual">1</span>
                            <span style="margin-left: 5px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-5 de 45 registros</span>
                            <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página siguiente" id="btnSiguiente">
                                <i class="fas fa-angle-right" style="color: #2378e1;"></i>
                            </button>
                            <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Última página" id="btnUltima">
                                <i class="fas fa-angle-double-right" style="color: #2378e1;"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 2: CUADRILLAS -->
                <div id="tab-cuadrillas" class="asistencia-content" style="display: none;">
                    <!-- Resumen de cuadrillas -->
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 40px; height: 40px; background-color: #e8f0fe; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-people-arrows" style="color: #083CAE;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Total Cuadrillas</div>
                                    <div style="font-size: 24px; font-weight: bold; color: #083CAE;">5</div>
                                </div>
                            </div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 40px; height: 40px; background-color: #d4edda; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user-check" style="color: #28a745;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Personal Asignado</div>
                                    <div style="font-size: 24px; font-weight: bold; color: #28a745;">142</div>
                                </div>
                            </div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 40px; height: 40px; background-color: #fff3cd; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-clock" style="color: #ffc107;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Horas Trabajadas</div>
                                    <div style="font-size: 24px; font-weight: bold; color: #ffc107;">8,520</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Cuadrillas -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
                        <table class="table table-bordered" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px; text-align: left;">Cuadrilla</th>
                                    <th style="padding: 12px; text-align: left;">Encargado</th>
                                    <th style="padding: 12px; text-align: left;">Proyecto</th>
                                    <th style="padding: 12px; text-align: left;">Especialidad</th>
                                    <th style="padding: 12px; text-align: center;">Integrantes</th>
                                    <th style="padding: 12px; text-align: center;">Presentes Hoy</th>
                                    <th style="padding: 12px; text-align: right;">Horas/Día</th>
                                    <th style="padding: 12px; text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px;"><strong>Cuadrilla A</strong></td>
                                    <td style="padding: 12px;">Carlos Rodríguez</td>
                                    <td style="padding: 12px;">Torre Norte</td>
                                    <td style="padding: 12px;">Cimentación</td>
                                    <td style="padding: 12px; text-align: center;">12</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">10</td>
                                    <td style="padding: 12px; text-align: right;">96</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verDetalleCuadrilla('A')"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="editarCuadrilla('A')"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>Cuadrilla B</strong></td>
                                    <td style="padding: 12px;">María García</td>
                                    <td style="padding: 12px;">Puente Sur</td>
                                    <td style="padding: 12px;">Estructura</td>
                                    <td style="padding: 12px; text-align: center;">8</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">7</td>
                                    <td style="padding: 12px; text-align: right;">56</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verDetalleCuadrilla('B')"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="editarCuadrilla('B')"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>Cuadrilla C</strong></td>
                                    <td style="padding: 12px;">Juan Pérez</td>
                                    <td style="padding: 12px;">Parque Industrial</td>
                                    <td style="padding: 12px;">Acabados</td>
                                    <td style="padding: 12px; text-align: center;">6</td>
                                    <td style="padding: 12px; text-align: center; color: #ffc107;">5</td>
                                    <td style="padding: 12px; text-align: right;">40</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verDetalleCuadrilla('C')"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="editarCuadrilla('C')"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>Cuadrilla D</strong></td>
                                    <td style="padding: 12px;">Ana Martínez</td>
                                    <td style="padding: 12px;">Hospital Regional</td>
                                    <td style="padding: 12px;">Instalaciones</td>
                                    <td style="padding: 12px; text-align: center;">5</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">5</td>
                                    <td style="padding: 12px; text-align: right;">40</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verDetalleCuadrilla('D')"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="editarCuadrilla('D')"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>Cuadrilla E</strong></td>
                                    <td style="padding: 12px;">Luis Ramírez</td>
                                    <td style="padding: 12px;">Planta Tratamiento</td>
                                    <td style="padding: 12px;">Obra Negra</td>
                                    <td style="padding: 12px; text-align: center;">7</td>
                                    <td style="padding: 12px; text-align: center; color: #dc3545;">4</td>
                                    <td style="padding: 12px; text-align: right;">32</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verDetalleCuadrilla('E')"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="editarCuadrilla('E')"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 3: REPORTE DE ASISTENCIA -->
                <div id="tab-resumen" class="asistencia-content" style="display: none;">
                    <!-- Selector de período -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <label style="font-weight: 600; color: #083CAE;">Período:</label>
                            <select id="selectorMes" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                <option value="1">Enero 2026</option>
                                <option value="2">Febrero 2026</option>
                                <option value="3" selected>Marzo 2026</option>
                                <option value="4">Abril 2026</option>
                                <option value="5">Mayo 2026</option>
                            </select>
                            <button id="btnGenerarReporte" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px;">
                                <i class="fas fa-sync-alt"></i> Actualizar
                            </button>
                        </div>
                        <div>
                            <span style="background-color: #e8f0fe; color: #083CAE; padding: 8px 15px; border-radius: 4px; font-weight: 600;">
                                <i class="fas fa-calendar"></i> Días laborales: 22
                            </span>
                        </div>
                    </div>

                    <!-- Tarjetas de resumen mensual -->
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px;">
                        <div style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="color: #6c757d; font-size: 12px;">Total de registros</div>
                            <div style="font-size: 28px; font-weight: bold; color: #083CAE;">396</div>
                            <div style="font-size: 11px; color: #28a745;">+12 vs mes anterior</div>
                        </div>
                        <div style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="color: #6c757d; font-size: 12px;">Horas totales</div>
                            <div style="font-size: 28px; font-weight: bold; color: #083CAE;">3,850</div>
                            <div style="font-size: 11px; color: #ffc107;">promedio 8.5 hrs/día</div>
                        </div>
                        <div style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="color: #6c757d; font-size: 12px;">Ausentismo</div>
                            <div style="font-size: 28px; font-weight: bold; color: #083CAE;">8.2%</div>
                            <div style="font-size: 11px; color: #dc3545;">+2.1% vs meta</div>
                        </div>
                        <div style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="color: #6c757d; font-size: 12px;">Puntualidad</div>
                            <div style="font-size: 28px; font-weight: bold; color: #083CAE;">92%</div>
                            <div style="font-size: 11px; color: #28a745;">arriba del estándar</div>
                        </div>
                    </div>

                    <!-- Gráfico de asistencia por día -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                            <i class="fas fa-chart-line"></i> Asistencia Diaria - Marzo 2026
                        </h4>
                        <div style="height: 200px; display: flex; align-items: flex-end; gap: 3px; justify-content: space-between;">
                            <!-- Simulación de barras con datos realistas -->
                            <div style="width: 3.2%; background-color: #083CAE; height: 85%; border-radius: 4px 4px 0 0; position: relative;" title="Día 1: 85%">
                                <span style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); font-size: 10px;">85%</span>
                            </div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 90%; border-radius: 4px 4px 0 0;" title="Día 2: 90%"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 88%; border-radius: 4px 4px 0 0;" title="Día 3: 88%"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 92%; border-radius: 4px 4px 0 0;" title="Día 4: 92%"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 87%; border-radius: 4px 4px 0 0;" title="Día 5: 87%"></div>
                            <div style="width: 3.2%; background-color: #6c757d; height: 0%; border-radius: 4px 4px 0 0;" title="Día 6: Descanso"></div>
                            <div style="width: 3.2%; background-color: #6c757d; height: 0%; border-radius: 4px 4px 0 0;" title="Día 7: Descanso"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 91%; border-radius: 4px 4px 0 0;" title="Día 8: 91%"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 89%; border-radius: 4px 4px 0 0;" title="Día 9: 89%"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 86%; border-radius: 4px 4px 0 0;" title="Día 10: 86%"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 93%; border-radius: 4px 4px 0 0;" title="Día 11: 93%"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 90%; border-radius: 4px 4px 0 0;" title="Día 12: 90%"></div>
                            <div style="width: 3.2%; background-color: #6c757d; height: 0%; border-radius: 4px 4px 0 0;" title="Día 13: Descanso"></div>
                            <div style="width: 3.2%; background-color: #6c757d; height: 0%; border-radius: 4px 4px 0 0;" title="Día 14: Descanso"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 88%; border-radius: 4px 4px 0 0;" title="Día 15: 88%"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 87%; border-radius: 4px 4px 0 0;" title="Día 16: 87%"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 85%; border-radius: 4px 4px 0 0;" title="Día 17: 85%"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 89%; border-radius: 4px 4px 0 0;" title="Día 18: 89%"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 91%; border-radius: 4px 4px 0 0;" title="Día 19: 91%"></div>
                            <div style="width: 3.2%; background-color: #6c757d; height: 0%; border-radius: 4px 4px 0 0;" title="Día 20: Descanso"></div>
                            <div style="width: 3.2%; background-color: #6c757d; height: 0%; border-radius: 4px 4px 0 0;" title="Día 21: Descanso"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 92%; border-radius: 4px 4px 0 0;" title="Día 22: 92%"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 90%; border-radius: 4px 4px 0 0;" title="Día 23: 90%"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 88%; border-radius: 4px 4px 0 0;" title="Día 24: 88%"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 87%; border-radius: 4px 4px 0 0;" title="Día 25: 87%"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 89%; border-radius: 4px 4px 0 0;" title="Día 26: 89%"></div>
                            <div style="width: 3.2%; background-color: #6c757d; height: 0%; border-radius: 4px 4px 0 0;" title="Día 27: Descanso"></div>
                            <div style="width: 3.2%; background-color: #6c757d; height: 0%; border-radius: 4px 4px 0 0;" title="Día 28: Descanso"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 86%; border-radius: 4px 4px 0 0;" title="Día 29: 86%"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 84%; border-radius: 4px 4px 0 0;" title="Día 30: 84%"></div>
                            <div style="width: 3.2%; background-color: #083CAE; height: 82%; border-radius: 4px 4px 0 0;" title="Día 31: 82%"></div>
                        </div>
                        <div style="display: flex; justify-content: center; gap: 30px; margin-top: 25px;">
                            <span style="font-size: 12px; display: flex; align-items: center; gap: 5px;">
                                <span style="display: inline-block; width: 12px; height: 12px; background-color: #083CAE; border-radius: 2px;"></span> Día laboral
                            </span>
                            <span style="font-size: 12px; display: flex; align-items: center; gap: 5px;">
                                <span style="display: inline-block; width: 12px; height: 12px; background-color: #6c757d; border-radius: 2px;"></span> Día de descanso
                            </span>
                        </div>
                    </div>

                    <!-- Tabla resumen por proyecto -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                        <div style="background-color: #f8f9fa; padding: 12px 15px; border-bottom: 2px solid #083CAE;">
                            <h5 style="margin: 0; color: #083CAE; font-size: 15px;"><i class="fas fa-chart-pie"></i> Resumen por Proyecto</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="padding: 12px; text-align: left;">Proyecto</th>
                                        <th style="padding: 12px; text-align: right;">Personal</th>
                                        <th style="padding: 12px; text-align: right;">Días</th>
                                        <th style="padding: 12px; text-align: right;">Horas</th>
                                        <th style="padding: 12px; text-align: right;">Ausencias</th>
                                        <th style="padding: 12px; text-align: right;">% Asist.</th>
                                        <th style="padding: 12px; text-align: right;">Retardos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 12px;">Torre Norte Corporativa</td>
                                        <td style="padding: 12px; text-align: right;">45</td>
                                        <td style="padding: 12px; text-align: right;">22</td>
                                        <td style="padding: 12px; text-align: right;">7,920</td>
                                        <td style="padding: 12px; text-align: right;">38</td>
                                        <td style="padding: 12px; text-align: right; color: #28a745;">96%</td>
                                        <td style="padding: 12px; text-align: right;">5</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;">Puente Vehicular Sur</td>
                                        <td style="padding: 12px; text-align: right;">32</td>
                                        <td style="padding: 12px; text-align: right;">22</td>
                                        <td style="padding: 12px; text-align: right;">5,632</td>
                                        <td style="padding: 12px; text-align: right;">42</td>
                                        <td style="padding: 12px; text-align: right; color: #ffc107;">88%</td>
                                        <td style="padding: 12px; text-align: right;">8</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;">Parque Industrial Norte</td>
                                        <td style="padding: 12px; text-align: right;">28</td>
                                        <td style="padding: 12px; text-align: right;">21</td>
                                        <td style="padding: 12px; text-align: right;">4,704</td>
                                        <td style="padding: 12px; text-align: right;">35</td>
                                        <td style="padding: 12px; text-align: right; color: #ffc107;">85%</td>
                                        <td style="padding: 12px; text-align: right;">4</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;">Hospital Regional</td>
                                        <td style="padding: 12px; text-align: right;">22</td>
                                        <td style="padding: 12px; text-align: right;">22</td>
                                        <td style="padding: 12px; text-align: right;">3,872</td>
                                        <td style="padding: 12px; text-align: right;">18</td>
                                        <td style="padding: 12px; text-align: right; color: #28a745;">92%</td>
                                        <td style="padding: 12px; text-align: right;">3</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;">Planta Tratamiento</td>
                                        <td style="padding: 12px; text-align: right;">25</td>
                                        <td style="padding: 12px; text-align: right;">20</td>
                                        <td style="padding: 12px; text-align: right;">4,000</td>
                                        <td style="padding: 12px; text-align: right;">45</td>
                                        <td style="padding: 12px; text-align: right; color: #dc3545;">72%</td>
                                        <td style="padding: 12px; text-align: right;">12</td>
                                    </tr>
                                </tbody>
                                <tfoot style="background-color: #e9ecef; font-weight: bold;">
                                    <tr>
                                        <td style="padding: 12px;">TOTAL</td>
                                        <td style="padding: 12px; text-align: right;">152</td>
                                        <td style="padding: 12px; text-align: right;">-</td>
                                        <td style="padding: 12px; text-align: right;">26,128</td>
                                        <td style="padding: 12px; text-align: right;">178</td>
                                        <td style="padding: 12px; text-align: right;">87%</td>
                                        <td style="padding: 12px; text-align: right;">32</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Tomar Asistencia -->
<div id="modalTomarAsistencia" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #083CAE;"><i class="fas fa-clipboard-check"></i> Tomar Asistencia</h3>
            <button id="btnCerrarModal" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #6c757d;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <div style="display: flex; gap: 15px; margin-bottom: 20px; align-items: center; flex-wrap: wrap;">
                <div>
                    <label style="font-weight: 600; margin-right: 10px;">Fecha:</label>
                    <input type="date" id="modalFecha" value="2026-03-11" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="font-weight: 600; margin-right: 10px;">Cuadrilla:</label>
                    <select id="modalCuadrilla" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="A">Cuadrilla A - Cimentación</option>
                        <option value="B">Cuadrilla B - Estructura</option>
                        <option value="C">Cuadrilla C - Acabados</option>
                        <option value="D">Cuadrilla D - Instalaciones</option>
                        <option value="E">Cuadrilla E - Obra Negra</option>
                    </select>
                </div>
                <div style="margin-left: auto;">
                    <button id="btnMarcarTodos" style="background-color: #28a745; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer;">
                        <i class="fas fa-check-double"></i> Marcar todos presente
                    </button>
                </div>
            </div>

            <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 4px; max-height: 400px; overflow-y: auto;">
                <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
                    <thead style="background-color: #f8f9fa; position: sticky; top: 0;">
                        <tr>
                            <th style="padding: 10px; text-align: left;">No. Empleado</th>
                            <th style="padding: 10px; text-align: left;">Nombre</th>
                            <th style="padding: 10px; text-align: left;">Hora Entrada</th>
                            <th style="padding: 10px; text-align: left;">Status</th>
                            <th style="padding: 10px; text-align: center;">Seleccionar</th>
                        </tr>
                    </thead>
                    <tbody id="modalTablaPersonal">
                        <!-- Se llenará con JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelarModal" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button id="btnGuardarAsistencia" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Guardar Asistencia</button>
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
    
    /* Estilo para las filas alternadas */
    #tablaBodyAsistencia tr:nth-child(odd) {
        background-color: #ffffff;
    }
    
    #tablaBodyAsistencia tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    
    #tablaBodyAsistencia tr:hover {
        background-color: #e0e0e0;
    }
    
    /* Estilo para los iconos de acción */
    #tablaBodyAsistencia td i, .table td i {
        transition: transform 0.2s;
        font-size: 14px;
        color: #083CAE;
    }
    
    #tablaBodyAsistencia td i:hover, .table td i:hover {
        transform: scale(1.2);
    }
    
    /* Estilo para el filtro en encabezados */
    .table th i {
        opacity: 0.7;
        transition: opacity 0.2s;
        color: white;
    }
    
    .table th i:hover {
        opacity: 1;
    }
    
    /* Columna de acciones fija */
    #tablaBodyAsistencia td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
    }
    
    /* Badges para status de asistencia */
    .badge-asistencia {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        font-weight: 600;
    }
    
    .badge-presente {
        background-color: #d4edda;
        color: #28a745;
    }
    
    .badge-ausente {
        background-color: #f8d7da;
        color: #dc3545;
    }
    
    .badge-retardo {
        background-color: #fff3cd;
        color: #ffc107;
    }
    
    .badge-vacaciones {
        background-color: #cce5ff;
        color: #0d6efd;
    }
    
    .badge-permiso {
        background-color: #e9ecef;
        color: #6c757d;
    }
    
    /* Pestañas */
    .asistencia-tab {
        transition: all 0.3s ease;
    }
    
    .asistencia-tab:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    
    .asistencia-tab.active {
        background-color: #083CAE !important;
        color: white !important;
    }
    
    .asistencia-content {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* ESTILOS CORREGIDOS PARA PAGINACIÓN */
    #paginacionContainer {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
    
    /* Todos los elementos dentro del contenedor también sin fondo */
    #paginacionContainer * {
        background: transparent !important;
        background-color: transparent !important;
    }
    
    /* Excepción para los spans que deben tener fondo azul */
    #paginacionContainer span[style*="background-color"] {
        background-color: #2378e1 !important;
    }
    
    /* Estilos para los botones de paginación */
    #paginacionContainer button {
        background: transparent !important;
        border: none !important;
        color: #2378e1 !important;
        cursor: pointer;
    }
    
    #paginacionContainer button:hover {
        opacity: 0.7;
    }
    
    #paginacionContainer button i {
        color: #2378e1 !important;
    }
    
    /* Estilo específico para btnVerTodos */
    #btnVerTodos,
    #btnVerTodos:hover,
    #btnVerTodos:focus,
    #btnVerTodos:active {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }
    
    #btnVerTodos i,
    #btnVerTodos span {
        color: #2378e1 !important;
    }
    
    #paginacionInfo {
        color: #2378e1 !important;
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
        
        #paginacionContainer {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .asistencia-tab {
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
        console.log('DOM completamente cargado - Asistencia y Cuadrillas');
        
        // Variables
        let currentPage = 1;
        let rowsPerPage = 5;
        let datosOriginales = [];
        
        // Elementos del DOM
        const tablaBodyAsistencia = document.getElementById('tablaBodyAsistencia');
        const tablaContainer = document.getElementById('tablaContainer');
        const sinDatosMensaje = document.getElementById('sinDatosMensaje');
        const selectorProyecto = document.getElementById('selectorProyecto');
        const fechaAsistencia = document.getElementById('fechaAsistencia');
        const selectorCuadrilla = document.getElementById('selectorCuadrilla');
        const buscador = document.getElementById('buscador');
        const btnTomarAsistencia = document.getElementById('btnTomarAsistencia');
        const btnAgregarCuadrilla = document.getElementById('btnAgregarCuadrilla');
        const btnExcel = document.getElementById('btnExcel');
        const btnVerTodos = document.getElementById('btnVerTodos');
        const btnPrimera = document.getElementById('btnPrimera');
        const btnAnterior = document.getElementById('btnAnterior');
        const btnSiguiente = document.getElementById('btnSiguiente');
        const btnUltima = document.getElementById('btnUltima');
        const paginaActualSpan = document.getElementById('paginaActual');
        const paginacionInfo = document.getElementById('paginacionInfo');
        const btnGenerarReporte = document.getElementById('btnGenerarReporte');
        const selectorMes = document.getElementById('selectorMes');
        
        // Elementos del modal
        const modalTomarAsistencia = document.getElementById('modalTomarAsistencia');
        const btnCerrarModal = document.getElementById('btnCerrarModal');
        const btnCancelarModal = document.getElementById('btnCancelarModal');
        const btnGuardarAsistencia = document.getElementById('btnGuardarAsistencia');
        const btnMarcarTodos = document.getElementById('btnMarcarTodos');
        const modalTablaPersonal = document.getElementById('modalTablaPersonal');
        const modalFecha = document.getElementById('modalFecha');
        const modalCuadrilla = document.getElementById('modalCuadrilla');
        
        // Pestañas
        const asistenciaTabs = document.querySelectorAll('.asistencia-tab');
        const asistenciaContents = document.querySelectorAll('.asistencia-content');
        
        // Datos de ejemplo para asistencia
        const asistenciaData = [
            { id: 'EMP-001', nombre: 'Juan Pérez', proyecto: 'PRO-2024-001', proyectoNombre: 'Torre Norte', cuadrilla: 'A', entrada: '07:00', salida: '17:00', horas: 10, status: 'Presente' },
            { id: 'EMP-002', nombre: 'María García', proyecto: 'PRO-2024-001', proyectoNombre: 'Torre Norte', cuadrilla: 'A', entrada: '07:15', salida: '17:00', horas: 9.75, status: 'Retardo' },
            { id: 'EMP-003', nombre: 'Carlos Rodríguez', proyecto: 'PRO-2024-001', proyectoNombre: 'Torre Norte', cuadrilla: 'A', entrada: '07:00', salida: '17:00', horas: 10, status: 'Presente' },
            { id: 'EMP-004', nombre: 'Ana Martínez', proyecto: 'PRO-2024-001', proyectoNombre: 'Torre Norte', cuadrilla: 'B', entrada: '07:00', salida: '17:00', horas: 10, status: 'Presente' },
            { id: 'EMP-005', nombre: 'Luis Ramírez', proyecto: 'PRO-2024-002', proyectoNombre: 'Puente Sur', cuadrilla: 'B', entrada: '08:00', salida: '18:00', horas: 10, status: 'Presente' },
            { id: 'EMP-006', nombre: 'Sofía Castro', proyecto: 'PRO-2024-002', proyectoNombre: 'Puente Sur', cuadrilla: 'B', entrada: '07:30', salida: '17:30', horas: 10, status: 'Presente' },
            { id: 'EMP-007', nombre: 'Javier Ruiz', proyecto: 'PRO-2024-002', proyectoNombre: 'Puente Sur', cuadrilla: 'C', entrada: '07:00', salida: '17:00', horas: 10, status: 'Presente' },
            { id: 'EMP-008', nombre: 'Laura Gómez', proyecto: 'PRO-2024-003', proyectoNombre: 'Parque Industrial', cuadrilla: 'C', entrada: '07:00', salida: '17:00', horas: 10, status: 'Presente' },
            { id: 'EMP-009', nombre: 'Roberto Sánchez', proyecto: 'PRO-2024-003', proyectoNombre: 'Parque Industrial', cuadrilla: 'D', entrada: '07:00', salida: '17:00', horas: 10, status: 'Presente' },
            { id: 'EMP-010', nombre: 'Diana Flores', proyecto: 'PRO-2024-003', proyectoNombre: 'Parque Industrial', cuadrilla: 'D', entrada: '07:00', salida: '17:00', horas: 10, status: 'Presente' },
            { id: 'EMP-011', nombre: 'Miguel Torres', proyecto: 'PRO-2024-004', proyectoNombre: 'Hospital Regional', cuadrilla: 'D', entrada: '07:00', salida: '17:00', horas: 10, status: 'Presente' },
            { id: 'EMP-012', nombre: 'Pedro Hernández', proyecto: 'PRO-2024-004', proyectoNombre: 'Hospital Regional', cuadrilla: 'E', entrada: '07:00', salida: '17:00', horas: 10, status: 'Presente' },
            { id: 'EMP-013', nombre: 'Carmen López', proyecto: 'PRO-2024-004', proyectoNombre: 'Hospital Regional', cuadrilla: 'E', entrada: '07:00', salida: '17:00', horas: 10, status: 'Presente' },
            { id: 'EMP-014', nombre: 'José García', proyecto: 'PRO-2024-005', proyectoNombre: 'Planta Tratamiento', cuadrilla: 'E', entrada: '07:00', salida: '17:00', horas: 10, status: 'Presente' },
            { id: 'EMP-015', nombre: 'Patricia Sánchez', proyecto: 'PRO-2024-005', proyectoNombre: 'Planta Tratamiento', cuadrilla: 'A', entrada: '07:00', salida: '17:00', horas: 10, status: 'Presente' },
            { id: 'EMP-016', nombre: 'Fernando Castro', proyecto: 'PRO-2024-005', proyectoNombre: 'Planta Tratamiento', cuadrilla: 'A', entrada: '07:00', salida: '17:00', horas: 10, status: 'Presente' },
            { id: 'EMP-017', nombre: 'Alejandra Ruiz', proyecto: 'PRO-2024-006', proyectoNombre: 'Urbanización', cuadrilla: 'B', entrada: '07:00', salida: '17:00', horas: 10, status: 'Presente' },
            { id: 'EMP-018', nombre: 'Ricardo Flores', proyecto: 'PRO-2024-006', proyectoNombre: 'Urbanización', cuadrilla: 'B', entrada: '07:00', salida: '17:00', horas: 10, status: 'Presente' }
        ];
        
        // Datos para el modal (personal por cuadrilla)
        const personalPorCuadrilla = {
            'A': [
                { id: 'EMP-001', nombre: 'Juan Pérez' },
                { id: 'EMP-002', nombre: 'María García' },
                { id: 'EMP-003', nombre: 'Carlos Rodríguez' },
                { id: 'EMP-015', nombre: 'Patricia Sánchez' },
                { id: 'EMP-016', nombre: 'Fernando Castro' }
            ],
            'B': [
                { id: 'EMP-004', nombre: 'Ana Martínez' },
                { id: 'EMP-005', nombre: 'Luis Ramírez' },
                { id: 'EMP-006', nombre: 'Sofía Castro' },
                { id: 'EMP-017', nombre: 'Alejandra Ruiz' },
                { id: 'EMP-018', nombre: 'Ricardo Flores' }
            ],
            'C': [
                { id: 'EMP-007', nombre: 'Javier Ruiz' },
                { id: 'EMP-008', nombre: 'Laura Gómez' }
            ],
            'D': [
                { id: 'EMP-009', nombre: 'Roberto Sánchez' },
                { id: 'EMP-010', nombre: 'Diana Flores' },
                { id: 'EMP-011', nombre: 'Miguel Torres' }
            ],
            'E': [
                { id: 'EMP-012', nombre: 'Pedro Hernández' },
                { id: 'EMP-013', nombre: 'Carmen López' },
                { id: 'EMP-014', nombre: 'José García' }
            ]
        };
        
        datosOriginales = [...asistenciaData];
        
        // Función para actualizar los cuadros de resumen
        function actualizarResumen(datos) {
            const totalPersonal = 187; // Valor fijo de ejemplo
            const presenteHoy = datos.length;
            const ausenteHoy = totalPersonal - presenteHoy;
            const porcentaje = Math.round((presenteHoy / totalPersonal) * 100);
            
            document.getElementById('totalPersonal').textContent = totalPersonal;
            document.getElementById('totalPresente').textContent = presenteHoy;
            document.getElementById('totalAusente').textContent = ausenteHoy;
            document.getElementById('porcentajeAsistencia').textContent = porcentaje + '%';
        }
        
        // Función para obtener clase de badge según status
        function getStatusBadgeClass(status) {
            switch(status) {
                case 'Presente': return 'badge-presente';
                case 'Ausente': return 'badge-ausente';
                case 'Retardo': return 'badge-retardo';
                case 'Vacaciones': return 'badge-vacaciones';
                case 'Permiso': return 'badge-permiso';
                default: return 'badge-asistencia';
            }
        }
        
        // Función para obtener datos de la página actual
        function getCurrentPageData(datos) {
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            return datos.slice(start, end);
        }
        
        // Función para actualizar la paginación
        function actualizarPaginacion(total) {
            const totalPages = Math.ceil(total / rowsPerPage);
            paginaActualSpan.textContent = currentPage;
            paginacionInfo.textContent = `Mostrando ${Math.min((currentPage - 1) * rowsPerPage + 1, total)}-${Math.min(currentPage * rowsPerPage, total)} de ${total} registros`;
        }
        
        // Función para cargar datos en la tabla de asistencia
        function cargarTablaAsistencia(datos) {
            if (!tablaBodyAsistencia) return;
            
            tablaBodyAsistencia.innerHTML = '';
            
            if (datos.length === 0) {
                sinDatosMensaje.style.display = 'block';
                tablaContainer.style.display = 'none';
                paginacionInfo.textContent = 'Mostrando 0-0 de 0 registros';
                return;
            }
            
            sinDatosMensaje.style.display = 'none';
            tablaContainer.style.display = 'block';
            
            // Actualizar resumen
            actualizarResumen(datos);
            
            // Cargar datos paginados
            const pageData = getCurrentPageData(datos);
            
            pageData.forEach(item => {
                const row = document.createElement('tr');
                
                row.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.id}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.nombre}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.proyecto} - ${item.proyectoNombre}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">Cuadrilla ${item.cuadrilla}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.entrada}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.salida || '--:--'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.horas}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge-asistencia ${getStatusBadgeClass(item.status)}">${item.status}</span></td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" onclick="editarAsistencia('${item.id}')"></i>
                            <i class="fas fa-clock" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Registrar salida" onclick="registrarSalida('${item.id}')"></i>
                        </div>
                    </td>
                `;
                
                tablaBodyAsistencia.appendChild(row);
            });
            
            actualizarPaginacion(datos.length);
        }
        
        // Función para filtrar datos
        function filtrarDatos() {
            let datosFiltrados = [...asistenciaData];
            
            // Filtrar por proyecto
            const proyecto = selectorProyecto.value;
            if (proyecto) {
                datosFiltrados = datosFiltrados.filter(p => p.proyecto === proyecto);
            }
            
            // Filtrar por cuadrilla
            const cuadrilla = selectorCuadrilla.value;
            if (cuadrilla) {
                datosFiltrados = datosFiltrados.filter(p => p.cuadrilla === cuadrilla);
            }
            
            // Filtrar por búsqueda
            const busqueda = buscador.value.toLowerCase();
            if (busqueda) {
                datosFiltrados = datosFiltrados.filter(p => 
                    p.nombre.toLowerCase().includes(busqueda) ||
                    p.id.toLowerCase().includes(busqueda)
                );
            }
            
            datosOriginales = datosFiltrados;
            currentPage = 1;
            cargarTablaAsistencia(datosFiltrados);
        }
        
        // Event Listeners para filtros
        selectorProyecto.addEventListener('change', filtrarDatos);
        selectorCuadrilla.addEventListener('change', filtrarDatos);
        buscador.addEventListener('input', filtrarDatos);
        fechaAsistencia.addEventListener('change', function() {
            alert('Cambiando fecha de asistencia a: ' + this.value);
            filtrarDatos();
        });
        
        // Cambio de pestañas
        asistenciaTabs.forEach((tab, index) => {
            tab.addEventListener('click', function() {
                asistenciaTabs.forEach(t => {
                    t.classList.remove('active');
                    t.style.backgroundColor = '#e9ecef';
                    t.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                asistenciaContents.forEach(content => content.style.display = 'none');
                asistenciaContents[index].style.display = 'block';
            });
        });
        
        // Paginación
        function cambiarPagina(delta) {
            const totalPages = Math.ceil(datosOriginales.length / rowsPerPage);
            const nuevaPagina = currentPage + delta;
            
            if (nuevaPagina >= 1 && nuevaPagina <= totalPages) {
                currentPage = nuevaPagina;
                cargarTablaAsistencia(datosOriginales);
            }
        }
        
        btnPrimera.addEventListener('click', () => {
            if (datosOriginales.length > 0) {
                currentPage = 1;
                cargarTablaAsistencia(datosOriginales);
            }
        });
        
        btnAnterior.addEventListener('click', () => cambiarPagina(-1));
        btnSiguiente.addEventListener('click', () => cambiarPagina(1));
        
        btnUltima.addEventListener('click', () => {
            if (datosOriginales.length > 0) {
                currentPage = Math.ceil(datosOriginales.length / rowsPerPage);
                cargarTablaAsistencia(datosOriginales);
            }
        });
        
        // Función para cargar personal en el modal
        function cargarModalPersonal(cuadrilla) {
            if (!modalTablaPersonal) return;
            
            const personal = personalPorCuadrilla[cuadrilla] || [];
            modalTablaPersonal.innerHTML = '';
            
            personal.forEach(p => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">${p.id}</td>
                    <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">${p.nombre}</td>
                    <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">
                        <input type="time" class="hora-entrada" value="07:00" style="padding: 5px; border: 1px solid #ced4da; border-radius: 4px; width: 100px;">
                    </td>
                    <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">
                        <select class="status-select" style="padding: 5px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="Presente">Presente</option>
                            <option value="Retardo">Retardo</option>
                            <option value="Ausente">Ausente</option>
                            <option value="Permiso">Permiso</option>
                            <option value="Vacaciones">Vacaciones</option>
                        </select>
                    </td>
                    <td style="padding: 10px; border-bottom: 1px solid #dee2e6; text-align: center;">
                        <input type="checkbox" class="seleccionar-personal" checked>
                    </td>
                `;
                modalTablaPersonal.appendChild(row);
            });
        }
        
        // Modal Tomar Asistencia
        btnTomarAsistencia.addEventListener('click', function() {
            modalTomarAsistencia.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            
            // Cargar personal de la cuadrilla seleccionada
            const cuadrilla = modalCuadrilla.value;
            cargarModalPersonal(cuadrilla);
        });
        
        function cerrarModal() {
            modalTomarAsistencia.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        btnCerrarModal.addEventListener('click', cerrarModal);
        btnCancelarModal.addEventListener('click', cerrarModal);
        
        // Cerrar modal al hacer clic fuera
        window.addEventListener('click', function(event) {
            if (event.target === modalTomarAsistencia) {
                cerrarModal();
            }
        });
        
        // Cambiar cuadrilla en el modal
        modalCuadrilla.addEventListener('change', function() {
            cargarModalPersonal(this.value);
        });
        
        // Marcar todos como presente
        btnMarcarTodos.addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.seleccionar-personal');
            const horaInputs = document.querySelectorAll('.hora-entrada');
            const statusSelects = document.querySelectorAll('.status-select');
            
            checkboxes.forEach(cb => cb.checked = true);
            horaInputs.forEach(input => input.value = '07:00');
            statusSelects.forEach(select => select.value = 'Presente');
        });
        
        // Guardar asistencia
        btnGuardarAsistencia.addEventListener('click', function() {
            const filas = document.querySelectorAll('#modalTablaPersonal tr');
            const registros = [];
            
            filas.forEach((fila, index) => {
                const checkbox = fila.querySelector('.seleccionar-personal');
                if (checkbox && checkbox.checked) {
                    const celdas = fila.querySelectorAll('td');
                    const hora = fila.querySelector('.hora-entrada')?.value || '07:00';
                    const status = fila.querySelector('.status-select')?.value || 'Presente';
                    
                    registros.push({
                        id: celdas[0]?.textContent || '',
                        nombre: celdas[1]?.textContent || '',
                        hora: hora,
                        status: status
                    });
                }
            });
            
            alert(`Asistencia guardada para ${registros.length} personas de la cuadrilla ${modalCuadrilla.value} el día ${modalFecha.value}`);
            cerrarModal();
        });
        
        // Botones de acción adicionales
        btnAgregarCuadrilla.addEventListener('click', () => alert('Agregar nueva cuadrilla - Funcionalidad en desarrollo'));
        
        btnExcel.addEventListener('click', () => {
            alert('Exportando a Excel...');
        });
        
        btnVerTodos.addEventListener('click', () => {
            selectorProyecto.value = '';
            selectorCuadrilla.value = '';
            buscador.value = '';
            datosOriginales = [...asistenciaData];
            currentPage = 1;
            cargarTablaAsistencia(datosOriginales);
        });
        
        btnGenerarReporte.addEventListener('click', () => {
            const mes = selectorMes.options[selectorMes.selectedIndex].text;
            alert(`Actualizando reporte de ${mes}`);
        });
        
        // Funciones globales para acciones
        window.editarAsistencia = function(id) {
            alert(`Editando asistencia de empleado ${id}`);
        };
        
        window.registrarSalida = function(id) {
            alert(`Registrando salida de empleado ${id}`);
        };
        
        window.verDetalleCuadrilla = function(cuadrilla) {
            alert(`Ver detalle de Cuadrilla ${cuadrilla}`);
        };
        
        window.editarCuadrilla = function(cuadrilla) {
            alert(`Editar Cuadrilla ${cuadrilla}`);
        };
        
        // Filtros en encabezados
        document.querySelectorAll('.table th i.fa-filter').forEach(icon => {
            icon.addEventListener('click', () => alert('Filtro de columna - Funcionalidad en desarrollo'));
        });
        
        // bien ahora vamos a realizar en la seccion de 'Maquinaria y Equipo' y ahora vamos a realizar 'asignacion de equipo'
        cargarTablaAsistencia(asistenciaData);
    });
</script>
@endsection