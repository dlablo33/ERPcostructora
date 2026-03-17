@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Control de Calidad -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-clipboard-check" style="margin-right: 10px;"></i>
                    Control de Calidad
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE CONTROL DE CALIDAD CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Pruebas Realizadas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Pruebas Realizadas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalPruebas">1,284</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Aprobadas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Aprobadas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="aprobadas">1,089</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Rechazadas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Rechazadas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="rechazadas">156</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: % Cumplimiento -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">% Cumplimiento</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="cumplimiento">84.8%</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas con agrupación y botones -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Grupo de agrupación discreto en la esquina izquierda -->
                    <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar" id="iconoAgrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 30px;">
                            <!-- Aquí se mostrarán las columnas agrupadas -->
                        </div>
                    </div>
                    
                    <!-- Grupo de botones derecho -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Date Inicio -->
                        <div>
                            <input type="date" id="fechaInicio" value="2026-01-01" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Date Fin -->
                        <div>
                            <input type="date" id="fechaFin" value="2026-12-31" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Botón Nueva Prueba -->
                        <div>
                            <button id="btnNuevaPrueba" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Nueva Prueba">
                                <i class="fas fa-flask"></i> Nueva Prueba
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

                        <!-- Botón Generar Reporte -->
                        <div>
                            <button id="btnReporte" 
                                    style="background-color: white; border: 1px solid #28a745; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #28a745;"
                                    title="Generar Reporte">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar prueba..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Pestañas de vistas -->
                <div style="display: flex; gap: 2px; margin-bottom: 20px; border-bottom: 2px solid #083CAE; overflow-x: auto; white-space: nowrap;">
                    <button class="vista-tab active" data-vista="pruebas" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-list"></i> Pruebas Realizadas
                    </button>
                    <button class="vista-tab" data-vista="indicadores" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-chart-line"></i> Indicadores de Calidad
                    </button>
                    <button class="vista-tab" data-vista="no-conformidades" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-exclamation-triangle"></i> No Conformidades
                        <span style="background-color: #dc3545; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;">24</span>
                    </button>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-clipboard-check" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros de control de calidad</p>
                </div>

                <!-- VISTA PRUEBAS REALIZADAS -->
                <div id="vistaPruebas" class="vista-content active">
                    <!-- Tabla de Pruebas de Calidad -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                        <table class="table table-bordered" id="tablaCalidad" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                            <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                                <tr>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="no_prueba">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>No. Prueba</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="proyecto">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Proyecto</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="tipo_prueba">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Tipo de Prueba</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="elemento">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Elemento</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Fecha</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="resultado">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Resultado</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="responsable">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Responsable</span>
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
                            <tbody id="tablaBody">
                                <!-- Las filas se insertarán dinámicamente con JavaScript -->
                            </tbody>
                            <!-- Fila de totales -->
                            <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold; display: table-footer-group;">
                                <tr>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="5">Totales:</td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" id="totalResultados" colspan="3">1,089 Aprobadas · 156 Rechazadas</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- VISTA INDICADORES DE CALIDAD -->
                <div id="vistaIndicadores" class="vista-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                        <!-- Gráfico de pastel - Resultados globales -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-pie"></i> Resultados Globales
                            </h4>
                            <div style="display: flex; align-items: center; gap: 30px;">
                                <div style="width: 150px; height: 150px; border-radius: 50%; background: conic-gradient(#28a745 0deg 305deg, #dc3545 305deg 360deg);"></div>
                                <div>
                                    <div style="margin-bottom: 8px;">
                                        <span style="display: inline-block; width: 12px; height: 12px; background-color: #28a745; border-radius: 3px;"></span>
                                        <span style="margin-left: 5px; font-size: 13px;">Aprobadas</span>
                                        <span style="float: right; font-weight: 600;">84.8%</span>
                                    </div>
                                    <div>
                                        <span style="display: inline-block; width: 12px; height: 12px; background-color: #dc3545; border-radius: 3px;"></span>
                                        <span style="margin-left: 5px; font-size: 13px;">Rechazadas</span>
                                        <span style="float: right; font-weight: 600;">15.2%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- KPIs de calidad -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-line"></i> Indicadores Clave
                            </h4>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Índice de Calidad General</span>
                                    <span style="font-size: 13px; font-weight: 600;">92.8%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 92.8%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Eficiencia de Inspección</span>
                                    <span style="font-size: 13px; font-weight: 600;">89.5%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 89.5%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Cumplimiento Normativo</span>
                                    <span style="font-size: 13px; font-weight: 600;">97.2%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 97.2%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Tiempo de Respuesta</span>
                                    <span style="font-size: 13px; font-weight: 600;">2.3 días</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 85%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de indicadores por proyecto -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 12px;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Proyecto</th>
                                    <th style="padding: 12px; text-align: right;">Pruebas Totales</th>
                                    <th style="padding: 12px; text-align: right;">Aprobadas</th>
                                    <th style="padding: 12px; text-align: right;">Rechazadas</th>
                                    <th style="padding: 12px; text-align: center;">% Aprobación</th>
                                    <th style="padding: 12px; text-align: center;">Tendencia</th>
                                    <th style="padding: 12px; text-align: center;">Última Prueba</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px;"><strong>Torre Norte Corporativa</strong></td>
                                    <td style="padding: 12px; text-align: right;">342</td>
                                    <td style="padding: 12px; text-align: right;">308</td>
                                    <td style="padding: 12px; text-align: right;">34</td>
                                    <td style="padding: 12px; text-align: center;"><span style="color: #28a745;">90.1%</span></td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">↑ 2.3%</td>
                                    <td style="padding: 12px; text-align: center;">15/03/2026</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>Puente Vehicular Sur</strong></td>
                                    <td style="padding: 12px; text-align: right;">287</td>
                                    <td style="padding: 12px; text-align: right;">248</td>
                                    <td style="padding: 12px; text-align: right;">39</td>
                                    <td style="padding: 12px; text-align: center;"><span style="color: #28a745;">86.4%</span></td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">↑ 1.2%</td>
                                    <td style="padding: 12px; text-align: center;">14/03/2026</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>Parque Industrial Norte</strong></td>
                                    <td style="padding: 12px; text-align: right;">256</td>
                                    <td style="padding: 12px; text-align: right;">218</td>
                                    <td style="padding: 12px; text-align: right;">38</td>
                                    <td style="padding: 12px; text-align: center;"><span style="color: #ffc107;">85.2%</span></td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">↑ 0.5%</td>
                                    <td style="padding: 12px; text-align: center;">13/03/2026</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>Hospital Regional</strong></td>
                                    <td style="padding: 12px; text-align: right;">198</td>
                                    <td style="padding: 12px; text-align: right;">168</td>
                                    <td style="padding: 12px; text-align: right;">30</td>
                                    <td style="padding: 12px; text-align: center;"><span style="color: #ffc107;">84.8%</span></td>
                                    <td style="padding: 12px; text-align: center; color: #dc3545;">↓ 1.8%</td>
                                    <td style="padding: 12px; text-align: center;">12/03/2026</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>Planta de Tratamiento</strong></td>
                                    <td style="padding: 12px; text-align: right;">145</td>
                                    <td style="padding: 12px; text-align: right;">118</td>
                                    <td style="padding: 12px; text-align: right;">27</td>
                                    <td style="padding: 12px; text-align: center;"><span style="color: #ffc107;">81.4%</span></td>
                                    <td style="padding: 12px; text-align: center; color: #ffc107;">→ 0.0%</td>
                                    <td style="padding: 12px; text-align: center;">11/03/2026</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>Urbanización Los Álamos</strong></td>
                                    <td style="padding: 12px; text-align: right;">56</td>
                                    <td style="padding: 12px; text-align: right;">29</td>
                                    <td style="padding: 12px; text-align: right;">27</td>
                                    <td style="padding: 12px; text-align: center;"><span style="color: #dc3545;">51.8%</span></td>
                                    <td style="padding: 12px; text-align: center; color: #dc3545;">↓ 5.2%</td>
                                    <td style="padding: 12px; text-align: center;">10/03/2026</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- VISTA NO CONFORMIDADES -->
                <div id="vistaNoConformidades" class="vista-content" style="display: none;">
                    <!-- Tabla de No Conformidades (sin mensaje de acciones requeridas) -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">No. NC</th>
                                    <th style="padding: 12px;">Proyecto</th>
                                    <th style="padding: 12px;">Descripción</th>
                                    <th style="padding: 12px;">Fecha Detección</th>
                                    <th style="padding: 12px;">Gravedad</th>
                                    <th style="padding: 12px;">Responsable</th>
                                    <th style="padding: 12px;">Fecha Límite</th>
                                    <th style="padding: 12px;">Estado</th>
                                    <th style="padding: 12px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px;"><strong>NC-2026-001</strong></td>
                                    <td style="padding: 12px;">Torre Norte</td>
                                    <td style="padding: 12px;">Fisuras en columnas de concreto - Nivel 3</td>
                                    <td style="padding: 12px;">10/03/2026</td>
                                    <td style="padding: 12px;"><span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px;">Alta</span></td>
                                    <td style="padding: 12px;">Carlos Rodríguez</td>
                                    <td style="padding: 12px;">25/03/2026</td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">En proceso</span></td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verDetalleNC('NC-2026-001')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="editarNC('NC-2026-001')" title="Editar"></i>
                                        <i class="fas fa-check-circle" style="color: #28a745; cursor: pointer; margin: 0 5px;" onclick="cerrarNC('NC-2026-001')" title="Cerrar no conformidad"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>NC-2026-002</strong></td>
                                    <td style="padding: 12px;">Puente Sur</td>
                                    <td style="padding: 12px;">Soldadura con porosidad en junta 15B</td>
                                    <td style="padding: 12px;">08/03/2026</td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">Media</span></td>
                                    <td style="padding: 12px;">María García</td>
                                    <td style="padding: 12px;">22/03/2026</td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">En proceso</span></td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verDetalleNC('NC-2026-002')"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="editarNC('NC-2026-002')"></i>
                                        <i class="fas fa-check-circle" style="color: #28a745; cursor: pointer; margin: 0 5px;" onclick="cerrarNC('NC-2026-002')"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>NC-2026-003</strong></td>
                                    <td style="padding: 12px;">Parque Industrial</td>
                                    <td style="padding: 12px;">Nivelación fuera de especificación (±5cm)</td>
                                    <td style="padding: 12px;">05/03/2026</td>
                                    <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Baja</span></td>
                                    <td style="padding: 12px;">Ana Martínez</td>
                                    <td style="padding: 12px;">19/03/2026</td>
                                    <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Corregida</span></td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verDetalleNC('NC-2026-003')"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>NC-2026-004</strong></td>
                                    <td style="padding: 12px;">Hospital Regional</td>
                                    <td style="padding: 12px;">Instalación eléctrica incorrecta (circuito 3)</td>
                                    <td style="padding: 12px;">12/03/2026</td>
                                    <td style="padding: 12px;"><span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px;">Alta</span></td>
                                    <td style="padding: 12px;">Luis Ramírez</td>
                                    <td style="padding: 12px;">26/03/2026</td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">En proceso</span></td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verDetalleNC('NC-2026-004')"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="editarNC('NC-2026-004')"></i>
                                        <i class="fas fa-check-circle" style="color: #28a745; cursor: pointer; margin: 0 5px;" onclick="cerrarNC('NC-2026-004')"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>NC-2026-005</strong></td>
                                    <td style="padding: 12px;">Torre Norte</td>
                                    <td style="padding: 12px;">Acero de refuerzo con corrosión</td>
                                    <td style="padding: 12px;">09/03/2026</td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">Media</span></td>
                                    <td style="padding: 12px;">Juan Pérez</td>
                                    <td style="padding: 12px;">18/03/2026</td>
                                    <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Corregida</span></td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verDetalleNC('NC-2026-005')"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>NC-2026-006</strong></td>
                                    <td style="padding: 12px;">Puente Sur</td>
                                    <td style="padding: 12px;">Concreto con resistencia inferior (220 vs 250)</td>
                                    <td style="padding: 12px;">07/03/2026</td>
                                    <td style="padding: 12px;"><span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px;">Alta</span></td>
                                    <td style="padding: 12px;">María García</td>
                                    <td style="padding: 12px;">21/03/2026</td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">En proceso</span></td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verDetalleNC('NC-2026-006')"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="editarNC('NC-2026-006')"></i>
                                        <i class="fas fa-check-circle" style="color: #28a745; cursor: pointer; margin: 0 5px;" onclick="cerrarNC('NC-2026-006')"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>NC-2026-007</strong></td>
                                    <td style="padding: 12px;">Planta Tratamiento</td>
                                    <td style="padding: 12px;">Fuga en tubería de proceso</td>
                                    <td style="padding: 12px;">06/03/2026</td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">Media</span></td>
                                    <td style="padding: 12px;">Luis Ramírez</td>
                                    <td style="padding: 12px;">20/03/2026</td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">En proceso</span></td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verDetalleNC('NC-2026-007')"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="editarNC('NC-2026-007')"></i>
                                        <i class="fas fa-check-circle" style="color: #28a745; cursor: pointer; margin: 0 5px;" onclick="cerrarNC('NC-2026-007')"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>NC-2026-008</strong></td>
                                    <td style="padding: 12px;">Urbanización</td>
                                    <td style="padding: 12px;">Pavimento con espesor inferior (8cm vs 10cm)</td>
                                    <td style="padding: 12px;">04/03/2026</td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">Media</span></td>
                                    <td style="padding: 12px;">Sofía Castro</td>
                                    <td style="padding: 12px;">18/03/2026</td>
                                    <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Corregida</span></td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verDetalleNC('NC-2026-008')"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Paginación y botón Crear filtro -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px; background: transparent !important; background-color: transparent !important; border: none !important; box-shadow: none !important;">
                    <!-- Botón Crear filtro (izquierda) - SIN FONDO -->
                    <button id="btnCrearFiltro" style="background: transparent !important; background-color: transparent !important; border: none !important; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: #2378e1; box-shadow: none !important; outline: none !important; margin: 0;">
                        <i class="fas fa-filter" style="font-size: 16px; color: #2378e1;"></i>
                        <span style="color: #2378e1;">Crear filtro</span>
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
                        <button class="pagina-btn" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" data-pagina="2">2</button>
                        <button class="pagina-btn" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" data-pagina="3">3</button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página siguiente" id="btnSiguiente">
                            <i class="fas fa-angle-right" style="color: #2378e1;"></i>
                        </button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Última página" id="btnUltima">
                            <i class="fas fa-angle-double-right" style="color: #2378e1;"></i>
                        </button>
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-10 de 85 registros</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Nueva Prueba -->
<div id="modalNuevaPrueba" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 700px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #083CAE;"><i class="fas fa-flask"></i> Nueva Prueba de Calidad</h3>
            <button id="btnCerrarModal" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #6c757d;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Proyecto <span style="color: #dc3545;">*</span></label>
                    <select id="modalProyecto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar...</option>
                        <option value="Torre Norte">Torre Norte Corporativa</option>
                        <option value="Puente Sur">Puente Vehicular Sur</option>
                        <option value="Parque Industrial">Parque Industrial Norte</option>
                        <option value="Hospital Regional">Hospital Regional</option>
                        <option value="Planta Tratamiento">Planta de Tratamiento</option>
                        <option value="Urbanización">Urbanización Los Álamos</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipo de Prueba <span style="color: #dc3545;">*</span></label>
                    <select id="modalTipoPrueba" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar...</option>
                        <option value="Concreto">Prueba de Concreto</option>
                        <option value="Acero">Prueba de Acero</option>
                        <option value="Suelo">Prueba de Suelo</option>
                        <option value="Soldadura">Prueba de Soldadura</option>
                        <option value="Instalación Eléctrica">Prueba de Instalación Eléctrica</option>
                        <option value="Instalación Hidráulica">Prueba de Instalación Hidráulica</option>
                        <option value="Pavimento">Prueba de Pavimento</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Elemento / Ubicación <span style="color: #dc3545;">*</span></label>
                <input type="text" id="modalElemento" placeholder="Ej: Columna C-12 Nivel 3, Junta 15B, Tramo 2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha de Prueba</label>
                    <input type="date" id="modalFecha" value="2026-03-11" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Responsable</label>
                    <select id="modalResponsable" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar...</option>
                        <option value="Juan Pérez">Juan Pérez</option>
                        <option value="María García">María García</option>
                        <option value="Carlos Rodríguez">Carlos Rodríguez</option>
                        <option value="Ana Martínez">Ana Martínez</option>
                        <option value="Luis Ramírez">Luis Ramírez</option>
                        <option value="Sofía Castro">Sofía Castro</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Resultado</label>
                <select id="modalResultado" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="Aprobada">Aprobada</option>
                    <option value="Rechazada">Rechazada</option>
                    <option value="Pendiente">Pendiente</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Observaciones / Resultados</label>
                <textarea id="modalObservaciones" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: Resistencia a compresión 265 kg/cm² (especificación 250 kg/cm²)"></textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Documento / Certificado</label>
                <div style="border: 2px dashed #ced4da; border-radius: 4px; padding: 20px; text-align: center; background-color: #f8f9fa;">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 32px; color: #6c757d; margin-bottom: 10px;"></i>
                    <p style="margin: 0; font-size: 14px;">Arrastra el archivo aquí o haz clic para seleccionar</p>
                    <p style="font-size: 11px; color: #6c757d; margin-top: 5px;">PDF, JPG (Max. 10MB)</p>
                </div>
            </div>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelar" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button id="btnGuardar" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Guardar Prueba</button>
        </div>
    </div>
</div>

<!-- Modal para Ver Detalle de Prueba -->
<div id="modalVerDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 700px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-clipboard-check"></i> Detalle de Prueba
            </h3>
            <button id="btnCerrarDetalle" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="padding: 20px;">
            <!-- Encabezado -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap;">
                <div>
                    <div style="font-size: 12px; color: #6c757d;">No. Prueba</div>
                    <div style="font-size: 20px; font-weight: 700; color: #083CAE;" id="detalleNoPrueba">LAB-2026-001</div>
                </div>
                <div>
                    <span style="background-color: #28a745; color: white; padding: 6px 15px; border-radius: 20px; font-size: 14px; font-weight: 600;" id="detalleResultado">Aprobada</span>
                </div>
            </div>

            <!-- Información principal -->
            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Proyecto</div>
                <div style="font-size: 16px; font-weight: 600;" id="detalleProyecto">Torre Norte Corporativa</div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Tipo de Prueba</div>
                <div style="font-size: 14px;" id="detalleTipoPrueba">Prueba de Concreto</div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Elemento / Ubicación</div>
                <div style="font-size: 14px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px;" id="detalleElemento">Columna C-12, Nivel 3</div>
            </div>

            <!-- Fechas y responsable -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px;">Fecha de Prueba</div>
                    <div style="font-size: 15px; font-weight: 600;" id="detalleFecha">10/03/2026</div>
                </div>
                <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px;">Responsable</div>
                    <div style="font-size: 15px; font-weight: 600;" id="detalleResponsable">Juan Pérez</div>
                </div>
                <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px;">Laboratorio</div>
                    <div style="font-size: 15px;" id="detalleLaboratorio">Lab. Materiales SA</div>
                </div>
            </div>

            <!-- Valores de prueba (dinámicos) -->
            <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                <h4 style="margin: 0 0 10px 0; font-size: 14px; color: #083CAE;">Resultados de la Prueba</h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Valor Obtenido</div>
                        <div style="font-size: 18px; font-weight: 700;" id="detalleValor">285 kg/cm²</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Especificación</div>
                        <div style="font-size: 18px; font-weight: 700;" id="detalleEspecificacion">250 kg/cm²</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Desviación</div>
                        <div style="font-size: 18px; font-weight: 700; color: #28a745;" id="detalleDesviacion">+14%</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Norma</div>
                        <div style="font-size: 14px;" id="detalleNorma">NMX-C-083</div>
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Observaciones</div>
                <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; font-size: 13px;" id="detalleObservaciones">
                    La muestra supera la resistencia especificada. Se recomienda continuar con el colado.
                </div>
            </div>

            <!-- Documentos adjuntos -->
            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Documentos Adjuntos</div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 8px 12px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-file-pdf" style="color: #dc3545;"></i>
                        <span style="font-size: 13px;">Certificado_Concreto_001.pdf</span>
                        <i class="fas fa-download" style="color: #083CAE; cursor: pointer;"></i>
                    </div>
                    <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 8px 12px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-camera" style="color: #6c757d;"></i>
                        <span style="font-size: 13px;">Foto_Probeta_01.jpg</span>
                        <i class="fas fa-download" style="color: #083CAE; cursor: pointer;"></i>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button style="padding: 8px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="descargarCertificado()">
                    <i class="fas fa-download"></i> Descargar Certificado
                </button>
                <button style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="cerrarModalDetalle()">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Ver Detalle de No Conformidad -->
<div id="modalVerNC" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 700px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #dc3545 0%, #a71d2a 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-exclamation-triangle"></i> Detalle de No Conformidad
            </h3>
            <button id="btnCerrarNC" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="padding: 20px;">
            <!-- Encabezado -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap;">
                <div>
                    <div style="font-size: 12px; color: #6c757d;">No. No Conformidad</div>
                    <div style="font-size: 20px; font-weight: 700; color: #dc3545;" id="detalleNCNo">NC-2026-001</div>
                </div>
                <div>
                    <span style="background-color: #ffc107; color: #856404; padding: 6px 15px; border-radius: 20px; font-size: 14px; font-weight: 600;" id="detalleNCEstado">En proceso</span>
                </div>
            </div>

            <!-- Información principal -->
            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Proyecto</div>
                <div style="font-size: 16px; font-weight: 600;" id="detalleNCProyecto">Torre Norte Corporativa</div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Descripción</div>
                <div style="font-size: 14px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px;" id="detalleNCDescripcion">Fisuras en columnas de concreto - Nivel 3</div>
            </div>

            <!-- Gravedad y fechas -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px;">Gravedad</div>
                    <div style="font-size: 15px; font-weight: 600;" id="detalleNCGravedad"><span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px;">Alta</span></div>
                </div>
                <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px;">Fecha Detección</div>
                    <div style="font-size: 15px;" id="detalleNCFechaDeteccion">10/03/2026</div>
                </div>
                <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px;">Fecha Límite</div>
                    <div style="font-size: 15px;" id="detalleNCFechaLimite">25/03/2026</div>
                </div>
            </div>

            <!-- Responsable -->
            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Responsable de atención</div>
                <div style="font-size: 14px; font-weight: 600;" id="detalleNCResponsable">Carlos Rodríguez</div>
            </div>

            <!-- Acciones tomadas -->
            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Acciones tomadas</div>
                <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; font-size: 13px;" id="detalleNCAcciones">
                    Se programó reparación con epóxico. Se reforzará el área afectada.
                </div>
            </div>

            <!-- Causa raíz -->
            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Causa raíz identificada</div>
                <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; font-size: 13px;" id="detalleNCCausa">
                    Vibrado insuficiente durante el colado.
                </div>
            </div>

            <!-- Documentos adjuntos -->
            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Documentos Adjuntos</div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 8px 12px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-file-pdf" style="color: #dc3545;"></i>
                        <span style="font-size: 13px;">Reporte_Fisuras.pdf</span>
                        <i class="fas fa-download" style="color: #083CAE; cursor: pointer;"></i>
                    </div>
                    <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 8px 12px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-camera" style="color: #6c757d;"></i>
                        <span style="font-size: 13px;">Foto_Fisura_01.jpg</span>
                        <i class="fas fa-download" style="color: #083CAE; cursor: pointer;"></i>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button style="padding: 8px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="cerrarNC()">
                    <i class="fas fa-check-circle"></i> Cerrar No Conformidad
                </button>
                <button style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="cerrarModalNC()">
                    Cerrar
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
    
    /* Estilo para las filas alternadas */
    #tablaBody tr:nth-child(odd) {
        background-color: #ffffff;
    }
    
    #tablaBody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    
    #tablaBody tr:hover {
        background-color: #e0e0e0;
    }
    
    /* Estilo para los iconos de acción */
    #tablaBody td i {
        transition: transform 0.2s;
        font-size: 14px;
        color: #083CAE;
    }
    
    #tablaBody td i:hover {
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
    #tablaBody td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
    }
    
    /* Badges para resultados */
    .badge-resultado {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        font-weight: 600;
    }
    
    .badge-aprobada {
        background-color: #28a745;
        color: white;
    }
    
    .badge-rechazada {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-pendiente {
        background-color: #ffc107;
        color: #856404;
    }
    
    /* Badges para gravedad */
    .badge-gravedad {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        font-weight: 600;
    }
    
    .badge-alta {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-media {
        background-color: #ffc107;
        color: #856404;
    }
    
    .badge-baja {
        background-color: #28a745;
        color: white;
    }
    
    /* Estilo para el pie de tabla (totales) */
    tfoot td {
        font-weight: bold;
        background-color: #e9ecef !important;
        border-top: 2px solid #083CAE;
        color: #000000 !important;
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
    
    /* Estilo específico para btnCrearFiltro */
    #btnCrearFiltro,
    #btnCrearFiltro:hover,
    #btnCrearFiltro:focus,
    #btnCrearFiltro:active {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }
    
    #btnCrearFiltro i,
    #btnCrearFiltro span {
        color: #2378e1 !important;
    }
    
    #paginacionInfo {
        color: #2378e1 !important;
    }
    
    /* Estilos para agrupación de columnas */
    [draggable="true"] {
        cursor: grab;
    }
    
    [draggable="true"]:active {
        cursor: grabbing;
        opacity: 0.7;
    }
    
    #grupoAgrupacion {
        position: relative;
    }
    
    #grupoColumnas {
        display: inline-flex;
        align-items: center;
    }
    
    .columna-agrupada {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        background-color: #f0f4ff;
        border-radius: 16px;
        color: #2378e1;
        font-size: 12px;
        margin: 2px;
        border: 1px solid #2378e1;
    }
    
    .columna-agrupada .remover {
        margin-left: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        color: #2378e1;
    }
    
    .columna-agrupada .remover:hover {
        opacity: 0.7;
    }
    
    /* Estilo para filas de grupo */
    .fila-grupo {
        background-color: #f0f7ff !important;
        font-weight: 500;
        cursor: pointer;
    }
    
    .fila-grupo:hover {
        background-color: #e1f0ff !important;
    }
    
    .fila-grupo td:first-child i {
        transition: transform 0.2s;
        margin-right: 8px;
    }
    
    .fila-grupo:not(.expandido) td:first-child i {
        transform: rotate(-90deg);
    }
    
    .fila-detalle {
        background-color: #ffffff;
    }
    
    .fila-detalle td {
        border-top: none !important;
    }
    
    .fila-detalle td:first-child {
        padding-left: 30px !important;
    }
    
    /* Estilo cuando se está arrastrando sobre el área de grupo */
    .drag-over #grupoColumnas {
        background-color: rgba(35, 120, 225, 0.1);
        border-radius: 4px;
    }
    
    /* Pestañas */
    .vista-tab {
        transition: all 0.3s ease;
    }
    
    .vista-tab:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    
    .vista-tab.active {
        background-color: #083CAE !important;
        color: white !important;
    }
    
    .vista-content {
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
        
        input[type="date"] {
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
        
        .vista-tab {
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
        console.log('DOM completamente cargado - Control de Calidad');
        
        // Variables para agrupación
        let columnasAgrupadas = [];
        let expandedGroups = new Set();
        let datosOriginales = [];
        let currentPage = 1;
        let rowsPerPage = 10;
        let totalRows = 0;
        
        // Datos de ejemplo para Pruebas de Calidad (más completos)
        const datosCalidad = [
            {
                no_prueba: 'LAB-2026-001',
                proyecto: 'Torre Norte Corporativa',
                tipo_prueba: 'Prueba de Concreto',
                elemento: 'Columna C-12, Nivel 3',
                fecha: '2026-03-10',
                resultado: 'Aprobada',
                responsable: 'Juan Pérez',
                laboratorio: 'Lab. Materiales SA',
                valor: '285 kg/cm²',
                especificacion: '250 kg/cm²',
                norma: 'NMX-C-083',
                observaciones: 'La muestra supera la resistencia especificada. Se recomienda continuar con el colado.'
            },
            {
                no_prueba: 'LAB-2026-002',
                proyecto: 'Torre Norte Corporativa',
                tipo_prueba: 'Prueba de Acero',
                elemento: 'Viga principal, Tramo A',
                fecha: '2026-03-09',
                resultado: 'Aprobada',
                responsable: 'Juan Pérez',
                laboratorio: 'Lab. Metales',
                valor: '4,250 kg/cm²',
                especificacion: '4,200 kg/cm²',
                norma: 'NMX-B-123',
                observaciones: 'Límite elástico dentro de especificación.'
            },
            {
                no_prueba: 'LAB-2026-003',
                proyecto: 'Puente Vehicular Sur',
                tipo_prueba: 'Prueba de Soldadura',
                elemento: 'Junta 15, Tramo 2',
                fecha: '2026-03-08',
                resultado: 'Rechazada',
                responsable: 'María García',
                laboratorio: 'Lab. Estructural SA',
                valor: '2 mm porosidad',
                especificacion: 'Sin porosidad',
                norma: 'AWS D1.1',
                observaciones: 'Se detectó porosidad en la soldadura. Requiere reparación.'
            },
            {
                no_prueba: 'LAB-2026-004',
                proyecto: 'Puente Vehicular Sur',
                tipo_prueba: 'Prueba de Suelo',
                elemento: 'Estación 3+250',
                fecha: '2026-03-07',
                resultado: 'Aprobada',
                responsable: 'María García',
                laboratorio: 'Lab. Geotecnia',
                valor: '95%',
                especificacion: '> 90%',
                norma: 'ASTM D698',
                observaciones: 'Compactación dentro de especificación.'
            },
            {
                no_prueba: 'LAB-2026-005',
                proyecto: 'Parque Industrial Norte',
                tipo_prueba: 'Prueba de Concreto',
                elemento: 'Losa de cimentación',
                fecha: '2026-03-06',
                resultado: 'Aprobada',
                responsable: 'Carlos Rodríguez',
                laboratorio: 'Lab. Materiales SA',
                valor: '268 kg/cm²',
                especificacion: '250 kg/cm²',
                norma: 'NMX-C-083',
                observaciones: 'Resistencia adecuada.'
            },
            {
                no_prueba: 'LAB-2026-006',
                proyecto: 'Parque Industrial Norte',
                tipo_prueba: 'Prueba de Acero',
                elemento: 'Columna metálica CM-08',
                fecha: '2026-03-05',
                resultado: 'Aprobada',
                responsable: 'Carlos Rodríguez',
                laboratorio: 'Lab. Metales',
                valor: '4,180 kg/cm²',
                especificacion: '4,200 kg/cm²',
                norma: 'NMX-B-123',
                observaciones: 'Límite elástico ligeramente inferior pero aceptable.'
            },
            {
                no_prueba: 'LAB-2026-007',
                proyecto: 'Hospital Regional',
                tipo_prueba: 'Prueba de Instalación Eléctrica',
                elemento: 'Circuito eléctrico principal',
                fecha: '2026-03-04',
                resultado: 'Rechazada',
                responsable: 'Ana Martínez',
                laboratorio: 'Lab. Eléctrico',
                valor: '0.8 ohms',
                especificacion: '< 0.5 ohms',
                norma: 'NOM-001-SEDE',
                observaciones: 'Resistencia de tierra por encima de lo permitido.'
            },
            {
                no_prueba: 'LAB-2026-008',
                proyecto: 'Hospital Regional',
                tipo_prueba: 'Prueba de Concreto',
                elemento: 'Columna C-05, Nivel 2',
                fecha: '2026-03-03',
                resultado: 'Aprobada',
                responsable: 'Ana Martínez',
                laboratorio: 'Lab. Materiales SA',
                valor: '272 kg/cm²',
                especificacion: '250 kg/cm²',
                norma: 'NMX-C-083',
                observaciones: 'Resultado satisfactorio.'
            },
            {
                no_prueba: 'LAB-2026-009',
                proyecto: 'Planta de Tratamiento',
                tipo_prueba: 'Prueba de Instalación Hidráulica',
                elemento: 'Tubería principal',
                fecha: '2026-03-02',
                resultado: 'Aprobada',
                responsable: 'Luis Ramírez',
                laboratorio: 'Lab. Hidráulico',
                valor: '8.5 bar',
                especificacion: '8 bar',
                norma: 'NMX-H-123',
                observaciones: 'Prueba de presión exitosa.'
            },
            {
                no_prueba: 'LAB-2026-010',
                proyecto: 'Urbanización Los Álamos',
                tipo_prueba: 'Prueba de Pavimento',
                elemento: 'Calle principal, tramo 3',
                fecha: '2026-03-01',
                resultado: 'Rechazada',
                responsable: 'Sofía Castro',
                laboratorio: 'Lab. Pavimentos',
                valor: '8 cm',
                especificacion: '10 cm',
                norma: 'NMX-C-190',
                observaciones: 'Espesor de pavimento por debajo de especificación.'
            }
        ];
        
        datosOriginales = [...datosCalidad];
        totalRows = datosOriginales.length;
        
        // Función para formatear fecha
        function formatDate(dateString) {
            if (!dateString || dateString === '-') return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX');
        }
        
        // Función para actualizar contadores de los cuadros
        function actualizarContadores(datos) {
            const total = datos.length;
            const aprobadas = datos.filter(d => d.resultado === 'Aprobada').length;
            const rechazadas = datos.filter(d => d.resultado === 'Rechazada').length;
            const cumplimiento = total > 0 ? Math.round((aprobadas / total) * 100) : 0;
            
            document.getElementById('totalPruebas').textContent = total;
            document.getElementById('aprobadas').textContent = aprobadas;
            document.getElementById('rechazadas').textContent = rechazadas;
            document.getElementById('cumplimiento').textContent = cumplimiento + '%';
            
            document.getElementById('totalResultados').textContent = aprobadas + ' Aprobadas · ' + rechazadas + ' Rechazadas';
        }
        
        // Función para obtener clase de badge según resultado
        function getResultadoBadgeClass(resultado) {
            switch(resultado) {
                case 'Aprobada': return 'badge-aprobada';
                case 'Rechazada': return 'badge-rechazada';
                default: return 'badge-pendiente';
            }
        }
        
        // Función para generar un ID único para el grupo
        function generarGrupoId(item, columnas) {
            return columnas.map(col => {
                switch(col) {
                    case 'proyecto': return item.proyecto || 'Sin proyecto';
                    case 'tipo_prueba': return item.tipo_prueba || 'Sin tipo';
                    case 'resultado': return item.resultado || 'Sin resultado';
                    case 'responsable': return item.responsable || 'Sin responsable';
                    default: return '';
                }
            }).join('||');
        }
        
        // Función para agrupar datos por columnas seleccionadas
        function agruparDatos(datos, columnas) {
            if (columnas.length === 0) return { grupos: [], items: datos };
            
            const gruposMap = new Map();
            
            datos.forEach(item => {
                const grupoId = generarGrupoId(item, columnas);
                
                if (!gruposMap.has(grupoId)) {
                    // Crear un nuevo grupo
                    const valorGrupo = columnas.map(col => {
                        switch(col) {
                            case 'proyecto': return item.proyecto || 'Sin proyecto';
                            case 'tipo_prueba': return item.tipo_prueba || 'Sin tipo';
                            case 'resultado': return item.resultado || 'Sin resultado';
                            case 'responsable': return item.responsable || 'Sin responsable';
                            default: return '';
                        }
                    }).join(' - ');
                    
                    gruposMap.set(grupoId, {
                        id: grupoId,
                        valor: valorGrupo,
                        items: [item]
                    });
                } else {
                    const grupo = gruposMap.get(grupoId);
                    grupo.items.push(item);
                }
            });
            
            return {
                grupos: Array.from(gruposMap.values()),
                items: []
            };
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
            document.getElementById('paginaActual').textContent = currentPage;
            document.getElementById('paginacionInfo').textContent = `Mostrando ${Math.min((currentPage - 1) * rowsPerPage + 1, total)}-${Math.min(currentPage * rowsPerPage, total)} de ${total} registros`;
        }
        
        // Función para cargar datos en la tabla
        function cargarTabla(datos) {
            const tablaBody = document.getElementById('tablaBody');
            const tablaContainer = document.getElementById('tablaContainer');
            const sinDatosMensaje = document.getElementById('sinDatosMensaje');
            const paginacionInfo = document.getElementById('paginacionInfo');
            const textoAgrupar = document.getElementById('textoAgrupar');
            const tablaFoot = document.getElementById('tablaFoot');
            
            if (!tablaBody) return;
            
            // Actualizar contadores de los cuadros
            actualizarContadores(datos);
            
            // Ocultar texto de agrupar si hay columnas agrupadas
            if (textoAgrupar) {
                textoAgrupar.style.display = columnasAgrupadas.length > 0 ? 'none' : 'inline';
            }
            
            // Aplicar agrupación si hay columnas seleccionadas
            const { grupos } = agruparDatos(datos, columnasAgrupadas);
            const hayGrupos = grupos.length > 0 && columnasAgrupadas.length > 0;
            
            // Limpiar tabla
            tablaBody.innerHTML = '';
            
            if (datos.length === 0) {
                sinDatosMensaje.style.display = 'block';
                tablaContainer.style.display = 'none';
                
                if (paginacionInfo) {
                    paginacionInfo.textContent = 'Mostrando 0-0 de 0 registros';
                }
                return;
            }
            
            sinDatosMensaje.style.display = 'none';
            tablaContainer.style.display = 'block';
            
            if (hayGrupos) {
                // Ocultar pie de tabla cuando hay grupos
                if (tablaFoot) tablaFoot.style.display = 'none';
                
                // Mostrar grupos
                grupos.forEach(grupo => {
                    const grupoRow = document.createElement('tr');
                    grupoRow.className = 'fila-grupo';
                    grupoRow.dataset.grupoId = grupo.id;
                    
                    if (expandedGroups.has(grupo.id)) {
                        grupoRow.classList.add('expandido');
                    }
                    
                    grupoRow.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;" colspan="8">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                                    <strong style="color: #2378e1;">${grupo.valor}</strong>
                                    <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                        (${grupo.items.length} pruebas)
                                    </span>
                                </div>
                            </div>
                        </td>
                    `;
                    
                    tablaBody.appendChild(grupoRow);
                    
                    // Mostrar items del grupo si está expandido
                    if (expandedGroups.has(grupo.id)) {
                        grupo.items.forEach(item => {
                            const detalleRow = document.createElement('tr');
                            detalleRow.className = 'fila-detalle';
                            
                            let badgeClass = getResultadoBadgeClass(item.resultado);
                            
                            detalleRow.innerHTML = `
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; padding-left: 30px;">${item.no_prueba}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.proyecto}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.tipo_prueba}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.elemento}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${formatDate(item.fecha)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge-resultado ${badgeClass}">${item.resultado}</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.responsable}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetalle('${item.no_prueba}')"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" onclick="editarPrueba('${item.no_prueba}')"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; font-size: 14px;" title="Certificado" onclick="verCertificado('${item.no_prueba}')"></i>
                                    </div>
                                </td>
                            `;
                            
                            tablaBody.appendChild(detalleRow);
                        });
                    }
                });
                
                if (paginacionInfo) {
                    const totalRegistros = datos.length;
                    const mostrando = grupos.length;
                    paginacionInfo.textContent = `Mostrando ${mostrando} grupos de ${totalRegistros} registros`;
                }
            } else {
                // Mostrar todos los items sin agrupar (con paginación)
                const pageData = getCurrentPageData(datos);
                
                pageData.forEach(item => {
                    const row = document.createElement('tr');
                    
                    let badgeClass = getResultadoBadgeClass(item.resultado);
                    
                    row.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.no_prueba}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.proyecto}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.tipo_prueba}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.elemento}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${formatDate(item.fecha)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge-resultado ${badgeClass}">${item.resultado}</span></td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.responsable}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetalle('${item.no_prueba}')"></i>
                                <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" onclick="editarPrueba('${item.no_prueba}')"></i>
                                <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; font-size: 14px;" title="Certificado" onclick="verCertificado('${item.no_prueba}')"></i>
                            </div>
                        </td>
                    `;
                    
                    tablaBody.appendChild(row);
                });
                
                // Mostrar pie de tabla con totales
                if (tablaFoot) tablaFoot.style.display = 'table-footer-group';
                
                actualizarPaginacion(datos.length);
            }
        }
        
        // Función para actualizar la visualización de columnas agrupadas
        function actualizarGrupoColumnas() {
            const grupoContainer = document.getElementById('grupoColumnas');
            const textoAgrupar = document.getElementById('textoAgrupar');
            
            if (!grupoContainer) return;
            
            grupoContainer.innerHTML = '';
            
            if (columnasAgrupadas.length === 0) {
                if (textoAgrupar) textoAgrupar.style.display = 'inline';
            } else {
                if (textoAgrupar) textoAgrupar.style.display = 'none';
                
                columnasAgrupadas.forEach(col => {
                    const nombreColumna = {
                        'proyecto': 'Proyecto',
                        'tipo_prueba': 'Tipo de Prueba',
                        'resultado': 'Resultado',
                        'responsable': 'Responsable'
                    }[col] || col;
                    
                    const chip = document.createElement('span');
                    chip.className = 'columna-agrupada';
                    chip.innerHTML = `
                        ${nombreColumna}
                        <span class="remover" data-columna="${col}">&times;</span>
                    `;
                    grupoContainer.appendChild(chip);
                });
            }
            
            // Limpiar grupos expandidos al cambiar agrupación
            expandedGroups.clear();
            
            // Recargar tabla con nueva agrupación
            cargarTabla(datosOriginales);
        }
        
        // Configurar drag and drop
        function setupDragAndDrop() {
            const encabezados = document.querySelectorAll('th[draggable="true"]');
            const grupoAgrupacion = document.getElementById('grupoAgrupacion');
            
            encabezados.forEach(th => {
                th.addEventListener('dragstart', (e) => {
                    e.dataTransfer.setData('text/plain', th.dataset.columna);
                    e.dataTransfer.effectAllowed = 'copy';
                    th.style.opacity = '0.5';
                });
                
                th.addEventListener('dragend', (e) => {
                    th.style.opacity = '1';
                });
            });
            
            grupoAgrupacion.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'copy';
                grupoAgrupacion.classList.add('drag-over');
            });
            
            grupoAgrupacion.addEventListener('dragleave', () => {
                grupoAgrupacion.classList.remove('drag-over');
            });
            
            grupoAgrupacion.addEventListener('drop', (e) => {
                e.preventDefault();
                grupoAgrupacion.classList.remove('drag-over');
                
                const columna = e.dataTransfer.getData('text/plain');
                
                if (columna && !columnasAgrupadas.includes(columna)) {
                    columnasAgrupadas.push(columna);
                    actualizarGrupoColumnas();
                }
            });
            
            // Event listener para remover columnas (usando delegación)
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('remover')) {
                    const columna = e.target.dataset.columna;
                    columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
                    actualizarGrupoColumnas();
                }
            });
        }
        
        // Event listener para expandir/colapsar grupos
        document.addEventListener('click', function(e) {
            const filaGrupo = e.target.closest('.fila-grupo');
            if (filaGrupo) {
                const grupoId = filaGrupo.dataset.grupoId;
                const icono = filaGrupo.querySelector('i');
                
                if (expandedGroups.has(grupoId)) {
                    expandedGroups.delete(grupoId);
                    filaGrupo.classList.remove('expandido');
                    if (icono) icono.className = 'fas fa-caret-right';
                } else {
                    expandedGroups.add(grupoId);
                    filaGrupo.classList.add('expandido');
                    if (icono) icono.className = 'fas fa-caret-down';
                }
                
                // Recargar tabla para mostrar/ocultar detalles
                cargarTabla(datosOriginales);
            }
        });
        
        // Cargar datos iniciales
        cargarTabla(datosCalidad);
        
        // Configurar drag and drop
        setupDragAndDrop();
        
        // Pestañas
        const vistaTabs = document.querySelectorAll('.vista-tab');
        const vistaContents = document.querySelectorAll('.vista-content');
        
        vistaTabs.forEach((tab, index) => {
            tab.addEventListener('click', function() {
                vistaTabs.forEach(t => {
                    t.classList.remove('active');
                    t.style.backgroundColor = '#e9ecef';
                    t.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                vistaContents.forEach(content => content.style.display = 'none');
                vistaContents[index].style.display = 'block';
            });
        });
        
        // Event Listeners
        document.getElementById('btnNuevaPrueba')?.addEventListener('click', function() {
            document.getElementById('modalNuevaPrueba').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            exportTableToExcel('tablaCalidad', 'Control_Calidad');
        });
        
        document.getElementById('btnReporte')?.addEventListener('click', function() {
            alert('Generando reporte de calidad...');
        });
        
        document.getElementById('btnCrearFiltro')?.addEventListener('click', function() {
            alert('Crear filtro - Funcionalidad en desarrollo');
        });
        
        document.getElementById('buscador')?.addEventListener('input', function(e) {
            const busqueda = e.target.value.toLowerCase();
            const datosFiltrados = datosCalidad.filter(item => 
                item.no_prueba?.toLowerCase().includes(busqueda) ||
                item.proyecto?.toLowerCase().includes(busqueda) ||
                item.tipo_prueba?.toLowerCase().includes(busqueda) ||
                item.responsable?.toLowerCase().includes(busqueda)
            );
            datosOriginales = datosFiltrados;
            currentPage = 1;
            cargarTabla(datosOriginales);
        });
        
        // Paginación
        document.querySelectorAll('.pagina-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                currentPage = parseInt(this.dataset.pagina);
                cargarTabla(datosOriginales);
            });
        });
        
        document.getElementById('btnPrimera')?.addEventListener('click', function() {
            currentPage = 1;
            cargarTabla(datosOriginales);
        });
        
        document.getElementById('btnAnterior')?.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                cargarTabla(datosOriginales);
            }
        });
        
        document.getElementById('btnSiguiente')?.addEventListener('click', function() {
            const totalPages = Math.ceil(datosOriginales.length / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                cargarTabla(datosOriginales);
            }
        });
        
        document.getElementById('btnUltima')?.addEventListener('click', function() {
            currentPage = Math.ceil(datosOriginales.length / rowsPerPage);
            cargarTabla(datosOriginales);
        });
        
        // Modal de nueva prueba
        const modalNuevaPrueba = document.getElementById('modalNuevaPrueba');
        const btnCerrarModal = document.getElementById('btnCerrarModal');
        const btnCancelar = document.getElementById('btnCancelar');
        const btnGuardar = document.getElementById('btnGuardar');
        
        function cerrarModal() {
            modalNuevaPrueba.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        btnCerrarModal.addEventListener('click', cerrarModal);
        btnCancelar.addEventListener('click', cerrarModal);
        
        btnGuardar.addEventListener('click', function() {
            alert('Prueba guardada correctamente');
            cerrarModal();
        });
        
        window.addEventListener('click', function(event) {
            if (event.target === modalNuevaPrueba) {
                cerrarModal();
            }
        });
        
        // Funciones para acciones
        window.verDetalle = function(noPrueba) {
            const prueba = datosCalidad.find(p => p.no_prueba === noPrueba);
            if (prueba) {
                document.getElementById('detalleNoPrueba').textContent = prueba.no_prueba;
                document.getElementById('detalleResultado').textContent = prueba.resultado;
                document.getElementById('detalleResultado').className = prueba.resultado === 'Aprobada' ? 'badge-aprobada' : 'badge-rechazada';
                document.getElementById('detalleProyecto').textContent = prueba.proyecto;
                document.getElementById('detalleTipoPrueba').textContent = prueba.tipo_prueba;
                document.getElementById('detalleElemento').textContent = prueba.elemento;
                document.getElementById('detalleFecha').textContent = formatDate(prueba.fecha);
                document.getElementById('detalleResponsable').textContent = prueba.responsable;
                document.getElementById('detalleLaboratorio').textContent = prueba.laboratorio || 'No especificado';
                document.getElementById('detalleValor').textContent = prueba.valor || 'N/A';
                document.getElementById('detalleEspecificacion').textContent = prueba.especificacion || 'N/A';
                
                if (prueba.valor && prueba.especificacion) {
                    const valorNum = parseFloat(prueba.valor) || 0;
                    const especNum = parseFloat(prueba.especificacion) || 0;
                    if (valorNum && especNum) {
                        const desviacion = ((valorNum - especNum) / especNum * 100).toFixed(1);
                        document.getElementById('detalleDesviacion').textContent = (desviacion > 0 ? '+' : '') + desviacion + '%';
                        document.getElementById('detalleDesviacion').className = desviacion >= 0 ? 'text-success' : 'text-danger';
                    }
                }
                
                document.getElementById('detalleNorma').textContent = prueba.norma || 'N/A';
                document.getElementById('detalleObservaciones').textContent = prueba.observaciones || 'Sin observaciones';
            }
            
            document.getElementById('modalVerDetalle').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };
        
        window.editarPrueba = function(noPrueba) {
            alert('Editar prueba: ' + noPrueba);
        };
        
        window.verCertificado = function(noPrueba) {
            alert('Ver certificado de prueba: ' + noPrueba);
        };
        
        // Funciones para No Conformidades
        window.verDetalleNC = function(noNC) {
            alert('Ver detalle de no conformidad: ' + noNC);
            document.getElementById('modalVerNC').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };
        
        window.editarNC = function(noNC) {
            alert('Editar no conformidad: ' + noNC);
        };
        
        window.cerrarNC = function(noNC) {
            if (confirm('¿Está seguro de cerrar esta no conformidad?')) {
                alert('No conformidad ' + noNC + ' cerrada');
            }
        };
        
        // Cerrar modales de detalle
        document.getElementById('btnCerrarDetalle')?.addEventListener('click', function() {
            document.getElementById('modalVerDetalle').style.display = 'none';
            document.body.style.overflow = 'auto';
        });
        
        document.getElementById('btnCerrarNC')?.addEventListener('click', function() {
            document.getElementById('modalVerNC').style.display = 'none';
            document.body.style.overflow = 'auto';
        });
        
        window.cerrarModalDetalle = function() {
            document.getElementById('modalVerDetalle').style.display = 'none';
            document.body.style.overflow = 'auto';
        };
        
        window.cerrarModalNC = function() {
            document.getElementById('modalVerNC').style.display = 'none';
            document.body.style.overflow = 'auto';
        };
        
        window.descargarCertificado = function() {
            alert('Descargando certificado...');
        };
        
        // Función para exportar a Excel
        function exportTableToExcel(tableId, filename = '') {
            var table = document.getElementById(tableId);
            if (!table) return;
            
            var html = table.outerHTML;
            var url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
            
            var link = document.createElement('a');
            link.href = url;
            link.download = filename + '.xls';
            link.click();
        }
        
        // Inicializar
        cargarTabla(datosCalidad);
        setupDragAndDrop();
    });
</script>
@endsection