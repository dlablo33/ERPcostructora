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
                <!-- 4 CUADROS DE CONTROL DE CALIDAD -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Pruebas Realizadas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalPruebas">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Aprobadas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="aprobadas">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Rechazadas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="rechazadas">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">% Cumplimiento</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="cumplimiento">0%</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar" id="iconoAgrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 30px;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <select id="selectorProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 200px;">
                                <option value="">Todos los proyectos</option>
                                @foreach($proyectos ?? [] as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <input type="date" id="fechaInicio" value="{{ date('Y-m-d', strtotime('-30 days')) }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <div>
                            <input type="date" id="fechaFin" value="{{ date('Y-m-d') }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <div>
                            <button id="btnNuevaPrueba" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Nueva Prueba">
                                <i class="fas fa-flask"></i> Nueva Prueba
                            </button>
                        </div>

                        <div>
                            <button id="btnExcel" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;" title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <div>
                            <button id="btnReporte" style="background-color: white; border: 1px solid #28a745; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #28a745;" title="Generar Reporte">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                        </div>

                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar prueba..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Pestañas -->
                <div style="display: flex; gap: 2px; margin-bottom: 20px; border-bottom: 2px solid #083CAE; overflow-x: auto; white-space: nowrap;">
                    <button class="vista-tab active" data-vista="pruebas" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-list"></i> Pruebas Realizadas
                    </button>
                    <button class="vista-tab" data-vista="indicadores" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-chart-line"></i> Indicadores de Calidad
                    </button>
                    <button class="vista-tab" data-vista="no-conformidades" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-exclamation-triangle"></i> No Conformidades
                        <span id="badgeNC" style="background-color: #dc3545; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;">0</span>
                    </button>
                </div>

                <!-- Loader -->
                <div id="loaderContainer" style="text-align: center; padding: 40px 20px; display: none;">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p style="color: #6c757d; margin-top: 10px;">Cargando datos...</p>
                </div>

                <!-- Mensaje "Sin datos" -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-clipboard-check" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros de control de calidad</p>
                </div>

                <!-- Mensaje de Error -->
                <div style="text-align: center; padding: 40px 20px; background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; margin: 20px 0; display: none;" id="errorMensaje">
                    <i class="fas fa-exclamation-triangle" style="font-size: 48px; color: #ffc107; margin-bottom: 15px;"></i>
                    <h3 style="color: #856404; font-size: 18px; margin: 0;">Error al cargar datos</h3>
                    <p style="color: #856404; font-size: 14px; margin-top: 5px;" id="errorTexto">Ocurrió un error al cargar los datos</p>
                    <button onclick="cargarTodosLosDatos()" style="margin-top: 10px; padding: 8px 20px; background-color: #ffc107; border: none; border-radius: 4px; cursor: pointer; color: #856404; font-weight: 600;">
                        <i class="fas fa-sync-alt"></i> Reintentar
                    </button>
                </div>

                <!-- VISTA PRUEBAS REALIZADAS -->
                <div id="vistaPruebas" class="vista-content active">
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
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 30px; color: #6c757d;">
                                        <i class="fas fa-spinner fa-spin"></i> Cargando datos...
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold; display: table-footer-group;">
                                <tr>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="7">Totales:</td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" id="totalResultados">0 Aprobadas · 0 Rechazadas</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- VISTA INDICADORES DE CALIDAD -->
                <div id="vistaIndicadores" class="vista-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-pie"></i> Resultados Globales
                            </h4>
                            <div style="display: flex; align-items: center; gap: 30px;">
                                <div id="graficoPastel" style="width: 150px; height: 150px; border-radius: 50%; background: conic-gradient(#6c757d 0deg 360deg);"></div>
                                <div>
                                    <div style="margin-bottom: 8px;">
                                        <span style="display: inline-block; width: 12px; height: 12px; background-color: #28a745; border-radius: 3px;"></span>
                                        <span style="margin-left: 5px; font-size: 13px;">Aprobadas</span>
                                        <span style="float: right; font-weight: 600;" id="porcAprobadas">0%</span>
                                    </div>
                                    <div>
                                        <span style="display: inline-block; width: 12px; height: 12px; background-color: #dc3545; border-radius: 3px;"></span>
                                        <span style="margin-left: 5px; font-size: 13px;">Rechazadas</span>
                                        <span style="float: right; font-weight: 600;" id="porcRechazadas">0%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-line"></i> Indicadores Clave
                            </h4>
                            <div id="kpisContainer">
                                <div style="margin-bottom: 12px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="font-size: 13px;">Índice de Calidad General</span>
                                        <span style="font-size: 13px; font-weight: 600;" id="kpiIndiceCalidad">0%</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                        <div id="barraIndiceCalidad" style="width: 0%; height: 8px; background-color: #6c757d; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 12px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="font-size: 13px;">Eficiencia de Inspección</span>
                                        <span style="font-size: 13px; font-weight: 600;" id="kpiEficiencia">0%</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                        <div id="barraEficiencia" style="width: 0%; height: 8px; background-color: #6c757d; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 12px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="font-size: 13px;">Cumplimiento Normativo</span>
                                        <span style="font-size: 13px; font-weight: 600;" id="kpiCumplimiento">0%</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                        <div id="barraCumplimiento" style="width: 0%; height: 8px; background-color: #6c757d; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="font-size: 13px;">Tiempo de Respuesta</span>
                                        <span style="font-size: 13px; font-weight: 600;" id="kpiTiempoRespuesta">0 días</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                        <div id="barraTiempoRespuesta" style="width: 0%; height: 8px; background-color: #6c757d; border-radius: 4px;"></div>
                                    </div>
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
                                    <th style="padding: 12px; text-align: center;">Nivel Calidad</th>
                                </tr>
                            </thead>
                            <tbody id="tablaIndicadoresBody">
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 30px; color: #6c757d;">
                                        <i class="fas fa-spinner fa-spin"></i> Cargando indicadores...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- VISTA NO CONFORMIDADES -->
                <div id="vistaNoConformidades" class="vista-content" style="display: none;">
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">No. NC</th>
                                    <th style="padding: 12px;">Proyecto</th>
                                    <th style="padding: 12px;">Descripción</th>
                                    <th style="padding: 12px;">Fecha Detección</th>
                                    <th style="padding: 12px;">Gravedad</th>
                                    <th style="padding: 12px;">Responsable</th>
                                    <th style="padding: 12px;">Estado</th>
                                    <th style="padding: 12px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaNCBody">
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 30px; color: #6c757d;">
                                        <i class="fas fa-spinner fa-spin"></i> Cargando no conformidades...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Paginación -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px; background: transparent !important; background-color: transparent !important; border: none !important; box-shadow: none !important;">
                    <button id="btnCrearFiltro" style="background: transparent !important; background-color: transparent !important; border: none !important; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: #2378e1; box-shadow: none !important; outline: none !important; margin: 0;">
                        <i class="fas fa-filter" style="font-size: 16px; color: #2378e1;"></i>
                        <span style="color: #2378e1;">Crear filtro</span>
                    </button>
                    
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
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 0-0 de 0 registros</span>
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
                        @foreach($proyectos ?? [] as $proyecto)
                            <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipo de Prueba <span style="color: #dc3545;">*</span></label>
                    <select id="modalTipoPrueba" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar...</option>
                        <option value="Prueba de Concreto">Prueba de Concreto</option>
                        <option value="Prueba de Acero">Prueba de Acero</option>
                        <option value="Prueba de Suelo">Prueba de Suelo</option>
                        <option value="Prueba de Soldadura">Prueba de Soldadura</option>
                        <option value="Instalación Eléctrica">Instalación Eléctrica</option>
                        <option value="Instalación Hidráulica">Instalación Hidráulica</option>
                        <option value="Prueba de Pavimento">Prueba de Pavimento</option>
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
                    <input type="date" id="modalFecha" value="{{ date('Y-m-d') }}" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Responsable <span style="color: #dc3545;">*</span></label>
                    <select id="modalResponsable" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar...</option>
                        @foreach($responsables ?? [] as $responsable)
                            <option value="{{ $responsable['id'] }}">{{ $responsable['nombre_completo'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Resultado</label>
                    <select id="modalResultado" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Aprobada">Aprobada</option>
                        <option value="Rechazada">Rechazada</option>
                        <option value="Pendiente">Pendiente</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Laboratorio</label>
                    <input type="text" id="modalLaboratorio" placeholder="Nombre del laboratorio" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Valor Obtenido</label>
                    <input type="text" id="modalValor" placeholder="Ej: 285 kg/cm²" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Especificación</label>
                    <input type="text" id="modalEspecificacion" placeholder="Ej: 250 kg/cm²" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Norma Aplicada</label>
                <input type="text" id="modalNorma" placeholder="Ej: NMX-C-083" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Observaciones</label>
                <textarea id="modalObservaciones" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones de la prueba..."></textarea>
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
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap;">
                <div>
                    <div style="font-size: 12px; color: #6c757d;">No. Prueba</div>
                    <div style="font-size: 20px; font-weight: 700; color: #083CAE;" id="detalleNoPrueba">-</div>
                </div>
                <div>
                    <span id="detalleResultado" style="padding: 6px 15px; border-radius: 20px; font-size: 14px; font-weight: 600; background-color: #6c757d; color: white;">-</span>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Proyecto</div>
                <div style="font-size: 16px; font-weight: 600;" id="detalleProyecto">-</div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Tipo de Prueba</div>
                <div style="font-size: 14px;" id="detalleTipoPrueba">-</div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Elemento / Ubicación</div>
                <div style="font-size: 14px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px;" id="detalleElemento">-</div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px;">Fecha de Prueba</div>
                    <div style="font-size: 15px; font-weight: 600;" id="detalleFecha">-</div>
                </div>
                <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px;">Responsable</div>
                    <div style="font-size: 15px; font-weight: 600;" id="detalleResponsable">-</div>
                </div>
                <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px;">Laboratorio</div>
                    <div style="font-size: 15px;" id="detalleLaboratorio">-</div>
                </div>
            </div>

            <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                <h4 style="margin: 0 0 10px 0; font-size: 14px; color: #083CAE;">Resultados de la Prueba</h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Valor Obtenido</div>
                        <div style="font-size: 18px; font-weight: 700;" id="detalleValor">-</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Especificación</div>
                        <div style="font-size: 18px; font-weight: 700;" id="detalleEspecificacion">-</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Norma</div>
                        <div style="font-size: 14px;" id="detalleNorma">-</div>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Observaciones</div>
                <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; font-size: 13px;" id="detalleObservaciones">-</div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="cerrarModalDetalle()">Cerrar</button>
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
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap;">
                <div>
                    <div style="font-size: 12px; color: #6c757d;">No. No Conformidad</div>
                    <div style="font-size: 20px; font-weight: 700; color: #dc3545;" id="detalleNCNo">-</div>
                </div>
                <div>
                    <span id="detalleNCEstado" style="padding: 6px 15px; border-radius: 20px; font-size: 14px; font-weight: 600; background-color: #6c757d; color: white;">-</span>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Proyecto</div>
                <div style="font-size: 16px; font-weight: 600;" id="detalleNCProyecto">-</div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Descripción</div>
                <div style="font-size: 14px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px;" id="detalleNCDescripcion">-</div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px;">Gravedad</div>
                    <div id="detalleNCGravedad" style="font-size: 15px; font-weight: 600;">-</div>
                </div>
                <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px;">Fecha Detección</div>
                    <div style="font-size: 15px;" id="detalleNCFechaDeteccion">-</div>
                </div>
                <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px;">Fecha Límite</div>
                    <div style="font-size: 15px;" id="detalleNCFechaLimite">-</div>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Responsable de atención</div>
                <div style="font-size: 14px; font-weight: 600;" id="detalleNCResponsable">-</div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Acciones tomadas</div>
                <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; font-size: 13px;" id="detalleNCAcciones">-</div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Causa raíz identificada</div>
                <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; font-size: 13px;" id="detalleNCCausa">-</div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="cerrarModalNC()">Cerrar</button>
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
    
    #tablaBody tr:nth-child(odd) {
        background-color: #ffffff;
    }
    
    #tablaBody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    
    #tablaBody tr:hover {
        background-color: #e0e0e0;
    }
    
    #tablaBody td i {
        transition: transform 0.2s;
        font-size: 14px;
        color: #083CAE;
    }
    
    #tablaBody td i:hover {
        transform: scale(1.2);
    }
    
    .table th i {
        opacity: 0.7;
        transition: opacity 0.2s;
        color: white;
    }
    
    .table th i:hover {
        opacity: 1;
    }
    
    #tablaBody td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
    }
    
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
    
    .badge-estado {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        font-weight: 600;
    }
    
    .badge-en-proceso {
        background-color: #ffc107;
        color: #856404;
    }
    
    .badge-corregida {
        background-color: #17a2b8;
        color: white;
    }
    
    .badge-cerrada {
        background-color: #28a745;
        color: white;
    }
    
    tfoot td {
        font-weight: bold;
        background-color: #e9ecef !important;
        border-top: 2px solid #083CAE;
        color: #000000 !important;
    }
    
    #paginacionContainer {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
    
    #paginacionContainer * {
        background: transparent !important;
        background-color: transparent !important;
    }
    
    #paginacionContainer span[style*="background-color"] {
        background-color: #2378e1 !important;
    }
    
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
    
    .spinner-border {
        display: inline-block;
        width: 3rem;
        height: 3rem;
        vertical-align: text-bottom;
        border: 0.25em solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner-border .75s linear infinite;
    }
    
    @keyframes spinner-border {
        to { transform: rotate(360deg); }
    }
    
    .badge-nivel {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        font-weight: 600;
    }
    
    .nivel-excelente {
        background-color: #28a745;
        color: white;
    }
    
    .nivel-muy-bueno {
        background-color: #20c997;
        color: white;
    }
    
    .nivel-bueno {
        background-color: #17a2b8;
        color: white;
    }
    
    .nivel-regular {
        background-color: #ffc107;
        color: #856404;
    }
    
    .nivel-critico {
        background-color: #dc3545;
        color: white;
    }
    
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado - Control de Calidad');
        
        // Variables globales
        let currentPage = 1;
        let rowsPerPage = 10;
        let totalRegistros = 0;
        let datosPruebas = [];
        let datosIndicadores = [];
        let datosNC = [];

        // ════════════════════════════════════════════════════════════════
        // FUNCIONES DE CARGA DE DATOS
        // ════════════════════════════════════════════════════════════════

        async function cargarTodosLosDatos() {
            mostrarLoader(true);
            ocultarErrores();
            
            try {
                await Promise.all([
                    cargarResumen(),
                    cargarPruebas(),
                    cargarIndicadores(),
                    cargarNoConformidades()
                ]);
                mostrarLoader(false);
            } catch (error) {
                console.error('Error al cargar datos:', error);
                mostrarError('Error al cargar los datos: ' + error.message);
                mostrarLoader(false);
            }
        }

        async function cargarResumen() {
            try {
                const proyectoId = document.getElementById('selectorProyecto').value;
                const fechaInicio = document.getElementById('fechaInicio').value;
                const fechaFin = document.getElementById('fechaFin').value;
                
                let url = '/proyectos/calidad-api/resumen';
                const params = new URLSearchParams();
                if (proyectoId) params.append('proyecto_id', proyectoId);
                if (fechaInicio) params.append('fecha_inicio', fechaInicio);
                if (fechaFin) params.append('fecha_fin', fechaFin);
                if (params.toString()) url += '?' + params.toString();
                
                const response = await fetch(url);
                if (!response.ok) throw new Error('Error al cargar resumen');
                
                const data = await response.json();
                
                document.getElementById('totalPruebas').textContent = data.total_pruebas || 0;
                document.getElementById('aprobadas').textContent = data.aprobadas || 0;
                document.getElementById('rechazadas').textContent = data.rechazadas || 0;
                document.getElementById('cumplimiento').textContent = (data.cumplimiento || 0) + '%';
                
                document.getElementById('totalResultados').textContent = 
                    (data.aprobadas || 0) + ' Aprobadas · ' + (data.rechazadas || 0) + ' Rechazadas';
                
            } catch (error) {
                console.error('Error en resumen:', error);
                throw error;
            }
        }

        async function cargarPruebas() {
            try {
                const proyectoId = document.getElementById('selectorProyecto').value;
                const search = document.getElementById('buscador').value;
                const fechaInicio = document.getElementById('fechaInicio').value;
                const fechaFin = document.getElementById('fechaFin').value;
                
                let url = `/proyectos/calidad-api/pruebas?per_page=${rowsPerPage}&page=${currentPage}`;
                if (proyectoId) url += `&proyecto_id=${proyectoId}`;
                if (search) url += `&search=${encodeURIComponent(search)}`;
                if (fechaInicio) url += `&fecha_inicio=${fechaInicio}`;
                if (fechaFin) url += `&fecha_fin=${fechaFin}`;
                
                const response = await fetch(url);
                if (!response.ok) throw new Error('Error al cargar pruebas');
                
                const data = await response.json();
                datosPruebas = data.data || [];
                totalRegistros = data.pagination?.total || 0;
                
                renderizarTablaPruebas(datosPruebas);
                actualizarPaginacion(data.pagination);
                
            } catch (error) {
                console.error('Error en pruebas:', error);
                throw error;
            }
        }

        async function cargarIndicadores() {
            try {
                const proyectoId = document.getElementById('selectorProyecto').value;
                const fechaInicio = document.getElementById('fechaInicio').value;
                const fechaFin = document.getElementById('fechaFin').value;
                
                let url = '/proyectos/calidad-api/indicadores';
                const params = new URLSearchParams();
                if (proyectoId) params.append('proyecto_id', proyectoId);
                if (fechaInicio) params.append('fecha_inicio', fechaInicio);
                if (fechaFin) params.append('fecha_fin', fechaFin);
                if (params.toString()) url += '?' + params.toString();
                
                const response = await fetch(url);
                if (!response.ok) throw new Error('Error al cargar indicadores');
                
                const data = await response.json();
                datosIndicadores = data || [];
                
                renderizarIndicadores(datosIndicadores);
                
            } catch (error) {
                console.error('Error en indicadores:', error);
                throw error;
            }
        }

        async function cargarNoConformidades() {
            try {
                const proyectoId = document.getElementById('selectorProyecto').value;
                
                let url = '/proyectos/calidad-api/no-conformidades?per_page=50';
                if (proyectoId) url += `&proyecto_id=${proyectoId}`;
                
                const response = await fetch(url);
                if (!response.ok) throw new Error('Error al cargar no conformidades');
                
                const data = await response.json();
                datosNC = data.data || [];
                
                document.getElementById('badgeNC').textContent = data.total_abiertas || 0;
                
                renderizarTablaNC(datosNC);
                
            } catch (error) {
                console.error('Error en no conformidades:', error);
                throw error;
            }
        }

        // ════════════════════════════════════════════════════════════════
        // FUNCIONES DE RENDERIZADO
        // ════════════════════════════════════════════════════════════════

        function renderizarTablaPruebas(datos) {
            const tablaBody = document.getElementById('tablaBody');
            const sinDatos = document.getElementById('sinDatosMensaje');
            const tablaContainer = document.getElementById('tablaContainer');
            
            if (!tablaBody) return;
            
            if (!datos || datos.length === 0) {
                tablaBody.innerHTML = `
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 30px; color: #6c757d;">
                            <i class="fas fa-inbox"></i> No hay registros de pruebas de calidad
                        </td>
                    </tr>
                `;
                sinDatos.style.display = 'block';
                tablaContainer.style.display = 'none';
                return;
            }
            
            sinDatos.style.display = 'none';
            tablaContainer.style.display = 'block';
            
            let html = '';
            let totalAprobadas = 0;
            let totalRechazadas = 0;
            
            datos.forEach(item => {
                const badgeClass = getResultadoBadgeClass(item.resultado);
                
                if (item.resultado === 'Aprobada') totalAprobadas++;
                if (item.resultado === 'Rechazada') totalRechazadas++;
                
                html += `
                    <tr>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.no_prueba || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.proyecto || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.tipo_prueba || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.elemento || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${formatDate(item.fecha)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">
                            <span class="badge-resultado ${badgeClass}">${item.resultado || 'Pendiente'}</span>
                        </td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.responsable || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetallePrueba('${item.no_prueba}')"></i>
                                <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
                                ${item.certificado ? `<i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; font-size: 14px;" title="Certificado"></i>` : ''}
                            </div>
                        </td>
                    </tr>
                `;
            });
            
            tablaBody.innerHTML = html;
            
            document.getElementById('totalResultados').textContent = 
                totalAprobadas + ' Aprobadas · ' + totalRechazadas + ' Rechazadas';
        }

        function renderizarIndicadores(datos) {
            const tablaBody = document.getElementById('tablaIndicadoresBody');
            
            if (!tablaBody) return;
            
            if (datos && datos.length > 0) {
                const totalAprobadas = datos.reduce((sum, item) => sum + (item.aprobadas || 0), 0);
                const totalPruebas = datos.reduce((sum, item) => sum + (item.total_pruebas || 0), 0);
                const porcGlobal = totalPruebas > 0 ? (totalAprobadas / totalPruebas) * 100 : 0;
                
                const aprobadas = datos.reduce((sum, item) => sum + (item.aprobadas || 0), 0);
                const rechazadas = datos.reduce((sum, item) => sum + (item.rechazadas || 0), 0);
                const total = aprobadas + rechazadas;
                
                if (total > 0) {
                    const porcAprob = (aprobadas / total) * 100;
                    const porcRech = (rechazadas / total) * 100;
                    const angleAprob = (porcAprob / 100) * 360;
                    
                    document.getElementById('graficoPastel').style.background = 
                        `conic-gradient(#28a745 0deg ${angleAprob}deg, #dc3545 ${angleAprob}deg 360deg)`;
                    document.getElementById('porcAprobadas').textContent = porcAprob.toFixed(1) + '%';
                    document.getElementById('porcRechazadas').textContent = porcRech.toFixed(1) + '%';
                }
                
                const indicePromedio = datos.reduce((sum, item) => sum + (item.indice_calidad || 0), 0) / datos.length;
                document.getElementById('kpiIndiceCalidad').textContent = indicePromedio.toFixed(1) + '%';
                document.getElementById('barraIndiceCalidad').style.width = Math.min(indicePromedio, 100) + '%';
                document.getElementById('barraIndiceCalidad').style.backgroundColor = indicePromedio >= 80 ? '#28a745' : indicePromedio >= 60 ? '#ffc107' : '#dc3545';
            }
            
            if (!datos || datos.length === 0) {
                tablaBody.innerHTML = `
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 30px; color: #6c757d;">
                            <i class="fas fa-inbox"></i> No hay indicadores disponibles
                        </td>
                    </tr>
                `;
                return;
            }
            
            let html = '';
            datos.forEach(item => {
                const color = item.porcentaje_aprobacion >= 80 ? '#28a745' : 
                             item.porcentaje_aprobacion >= 60 ? '#ffc107' : '#dc3545';
                const tendenciaColor = item.tendencia && item.tendencia.includes('↑') ? '#28a745' :
                                      item.tendencia && item.tendencia.includes('↓') ? '#dc3545' : '#6c757d';
                
                const nivelClass = getNivelClass(item.nivel_calidad || 'Regular');
                
                html += `
                    <tr>
                        <td style="padding: 12px;"><strong>${item.proyecto || '-'}</strong></td>
                        <td style="padding: 12px; text-align: right;">${item.total_pruebas || 0}</td>
                        <td style="padding: 12px; text-align: right;">${item.aprobadas || 0}</td>
                        <td style="padding: 12px; text-align: right;">${item.rechazadas || 0}</td>
                        <td style="padding: 12px; text-align: center; color: ${color}; font-weight: 600;">${item.porcentaje_aprobacion || 0}%</td>
                        <td style="padding: 12px; text-align: center; color: ${tendenciaColor};">${item.tendencia || '→ 0%'}</td>
                        <td style="padding: 12px; text-align: center;">${item.ultima_prueba || 'N/A'}</td>
                        <td style="padding: 12px; text-align: center;">
                            <span class="badge-nivel ${nivelClass}">${item.nivel_calidad || 'Regular'}</span>
                        </td>
                    </tr>
                `;
            });
            
            tablaBody.innerHTML = html;
        }

        function renderizarTablaNC(datos) {
            const tablaBody = document.getElementById('tablaNCBody');
            
            if (!tablaBody) return;
            
            if (!datos || datos.length === 0) {
                tablaBody.innerHTML = `
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 30px; color: #6c757d;">
                            <i class="fas fa-check-circle" style="color: #28a745;"></i> No hay no conformidades registradas
                        </td>
                    </tr>
                `;
                return;
            }
            
            let html = '';
            datos.forEach(item => {
                const gravedadClass = getGravedadBadgeClass(item.gravedad);
                const estadoClass = getEstadoBadgeClass(item.estado);
                
                html += `
                    <tr>
                        <td style="padding: 12px;"><strong>${item.no_nc || '-'}</strong></td>
                        <td style="padding: 12px;">${item.proyecto || '-'}</td>
                        <td style="padding: 12px;">${item.descripcion || '-'}</td>
                        <td style="padding: 12px;">${item.fecha_deteccion || '-'}</td>
                        <td style="padding: 12px;"><span class="badge-gravedad ${gravedadClass}">${item.gravedad || 'Media'}</span></td>
                        <td style="padding: 12px;">${item.responsable || '-'}</td>
                        <td style="padding: 12px;"><span class="badge-estado ${estadoClass}">${item.estado || 'En proceso'}</span></td>
                        <td style="padding: 12px;">
                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verDetalleNC('${item.no_nc}')" title="Ver detalle"></i>
                            ${item.estado === 'En proceso' ? 
                                `<i class="fas fa-check-circle" style="color: #28a745; cursor: pointer; margin: 0 5px;" onclick="cerrarNC('${item.no_nc}')" title="Cerrar no conformidad"></i>` : 
                                ''}
                        </td>
                    </tr>
                `;
            });
            
            tablaBody.innerHTML = html;
        }

        // ════════════════════════════════════════════════════════════════
        // FUNCIONES DE UTILIDAD
        // ════════════════════════════════════════════════════════════════

        function formatDate(dateString) {
            if (!dateString || dateString === '-') return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX');
        }

        function getResultadoBadgeClass(resultado) {
            switch(resultado) {
                case 'Aprobada': return 'badge-aprobada';
                case 'Rechazada': return 'badge-rechazada';
                default: return 'badge-pendiente';
            }
        }

        function getGravedadBadgeClass(gravedad) {
            switch(gravedad) {
                case 'Alta': return 'badge-alta';
                case 'Media': return 'badge-media';
                case 'Baja': return 'badge-baja';
                default: return 'badge-media';
            }
        }

        function getEstadoBadgeClass(estado) {
            switch(estado) {
                case 'En proceso': return 'badge-en-proceso';
                case 'Corregida': return 'badge-corregida';
                case 'Cerrada': return 'badge-cerrada';
                default: return 'badge-en-proceso';
            }
        }

        function getNivelClass(nivel) {
            switch(nivel) {
                case 'Excelente': return 'nivel-excelente';
                case 'Muy Bueno': return 'nivel-muy-bueno';
                case 'Bueno': return 'nivel-bueno';
                case 'Regular': return 'nivel-regular';
                case 'Crítico': return 'nivel-critico';
                default: return 'nivel-regular';
            }
        }

        function mostrarLoader(mostrar) {
            const loader = document.getElementById('loaderContainer');
            if (loader) loader.style.display = mostrar ? 'block' : 'none';
        }

        function mostrarError(mensaje) {
            const errorDiv = document.getElementById('errorMensaje');
            const errorText = document.getElementById('errorTexto');
            if (errorDiv && errorText) {
                errorText.textContent = mensaje || 'Ocurrió un error al cargar los datos';
                errorDiv.style.display = 'block';
            }
        }

        function ocultarErrores() {
            const errorDiv = document.getElementById('errorMensaje');
            if (errorDiv) errorDiv.style.display = 'none';
        }

        function actualizarPaginacion(pagination) {
            if (!pagination) return;
            
            const total = pagination.total || 0;
            const perPage = pagination.per_page || 10;
            const current = pagination.current_page || 1;
            const last = pagination.last_page || 1;
            
            const inicio = ((current - 1) * perPage) + 1;
            const fin = Math.min(current * perPage, total);
            
            document.getElementById('paginaActual').textContent = current;
            document.getElementById('paginacionInfo').textContent = 
                total > 0 ? `Mostrando ${inicio}-${fin} de ${total} registros` : 'Mostrando 0-0 de 0 registros';
            
            const pageButtons = document.querySelectorAll('.pagina-btn');
            pageButtons.forEach(btn => {
                const page = parseInt(btn.dataset.pagina);
                btn.style.backgroundColor = page === current ? '#2378e1' : 'transparent';
                btn.style.color = page === current ? 'white' : '#2378e1';
            });
        }

        // ════════════════════════════════════════════════════════════════
        // FUNCIONES DE MODALES
        // ════════════════════════════════════════════════════════════════

        window.verDetallePrueba = async function(noPrueba) {
            try {
                const response = await fetch(`/proyectos/calidad-api/prueba/${noPrueba}`);
                if (!response.ok) throw new Error('Error al cargar detalle');
                
                const data = await response.json();
                
                document.getElementById('detalleNoPrueba').textContent = data.no_prueba || '-';
                document.getElementById('detalleProyecto').textContent = data.proyecto || '-';
                document.getElementById('detalleTipoPrueba').textContent = data.tipo_prueba || '-';
                document.getElementById('detalleElemento').textContent = data.elemento || '-';
                document.getElementById('detalleFecha').textContent = data.fecha || '-';
                document.getElementById('detalleResponsable').textContent = data.responsable || '-';
                document.getElementById('detalleLaboratorio').textContent = data.laboratorio || '-';
                document.getElementById('detalleValor').textContent = data.valor || '-';
                document.getElementById('detalleEspecificacion').textContent = data.especificacion || '-';
                document.getElementById('detalleNorma').textContent = data.norma || '-';
                document.getElementById('detalleObservaciones').textContent = data.observaciones || 'Sin observaciones';
                
                const resultadoEl = document.getElementById('detalleResultado');
                resultadoEl.textContent = data.resultado || 'Pendiente';
                resultadoEl.style.backgroundColor = data.resultado === 'Aprobada' ? '#28a745' : 
                                                   data.resultado === 'Rechazada' ? '#dc3545' : '#ffc107';
                resultadoEl.style.color = data.resultado === 'Pendiente' ? '#856404' : 'white';
                
                document.getElementById('modalVerDetalle').style.display = 'flex';
                document.body.style.overflow = 'hidden';
                
            } catch (error) {
                console.error('Error al cargar detalle:', error);
                alert('Error al cargar el detalle de la prueba');
            }
        };

        window.verDetalleNC = async function(noNc) {
            try {
                const response = await fetch(`/proyectos/calidad-api/nc/${noNc}`);
                if (!response.ok) throw new Error('Error al cargar detalle NC');
                
                const data = await response.json();
                
                document.getElementById('detalleNCNo').textContent = data.no_nc || '-';
                document.getElementById('detalleNCProyecto').textContent = data.proyecto || '-';
                document.getElementById('detalleNCDescripcion').textContent = data.descripcion || '-';
                document.getElementById('detalleNCFechaDeteccion').textContent = data.fecha_deteccion || '-';
                document.getElementById('detalleNCFechaLimite').textContent = data.fecha_limite || '-';
                document.getElementById('detalleNCResponsable').textContent = data.responsable || '-';
                document.getElementById('detalleNCAcciones').textContent = data.acciones_tomadas || 'Sin acciones registradas';
                document.getElementById('detalleNCCausa').textContent = data.causa_raiz || 'No identificada';
                
                const gravedadEl = document.getElementById('detalleNCGravedad');
                const gravedadClass = getGravedadBadgeClass(data.gravedad);
                gravedadEl.innerHTML = `<span class="badge-gravedad ${gravedadClass}">${data.gravedad || 'Media'}</span>`;
                
                const estadoEl = document.getElementById('detalleNCEstado');
                const estadoClass = getEstadoBadgeClass(data.estado);
                estadoEl.textContent = data.estado || 'En proceso';
                estadoEl.className = `badge-estado ${estadoClass}`;
                
                document.getElementById('modalVerNC').style.display = 'flex';
                document.body.style.overflow = 'hidden';
                
            } catch (error) {
                console.error('Error al cargar detalle NC:', error);
                alert('Error al cargar el detalle de la no conformidad');
            }
        };

        window.cerrarNC = async function(noNc) {
            if (!confirm('¿Está seguro de cerrar esta no conformidad?')) return;
            
            try {
                const response = await fetch(`/proyectos/calidad-api/nc/${noNc}/cerrar`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });
                
                if (!response.ok) throw new Error('Error al cerrar NC');
                
                const data = await response.json();
                alert(data.message || 'No conformidad cerrada correctamente');
                cargarTodosLosDatos();
                
            } catch (error) {
                console.error('Error al cerrar NC:', error);
                alert('Error al cerrar la no conformidad');
            }
        };

        window.cerrarModalDetalle = function() {
            document.getElementById('modalVerDetalle').style.display = 'none';
            document.body.style.overflow = 'auto';
        };

        window.cerrarModalNC = function() {
            document.getElementById('modalVerNC').style.display = 'none';
            document.body.style.overflow = 'auto';
        };

        // ════════════════════════════════════════════════════════════════
        // EVENT LISTENERS
        // ════════════════════════════════════════════════════════════════

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

        // Filtros
        document.getElementById('selectorProyecto')?.addEventListener('change', function() {
            currentPage = 1;
            cargarTodosLosDatos();
        });

        document.getElementById('fechaInicio')?.addEventListener('change', function() {
            currentPage = 1;
            cargarTodosLosDatos();
        });

        document.getElementById('fechaFin')?.addEventListener('change', function() {
            currentPage = 1;
            cargarTodosLosDatos();
        });

        let searchTimeout;
        document.getElementById('buscador')?.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentPage = 1;
                cargarPruebas();
            }, 500);
        });

        // Paginación
        document.getElementById('btnPrimera')?.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage = 1;
                cargarPruebas();
            }
        });

        document.getElementById('btnAnterior')?.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                cargarPruebas();
            }
        });

        document.getElementById('btnSiguiente')?.addEventListener('click', function() {
            const total = totalRegistros;
            const lastPage = Math.ceil(total / rowsPerPage);
            if (currentPage < lastPage) {
                currentPage++;
                cargarPruebas();
            }
        });

        document.getElementById('btnUltima')?.addEventListener('click', function() {
            const total = totalRegistros;
            const lastPage = Math.ceil(total / rowsPerPage);
            if (currentPage < lastPage) {
                currentPage = lastPage;
                cargarPruebas();
            }
        });

        document.querySelectorAll('.pagina-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const page = parseInt(this.dataset.pagina);
                if (page !== currentPage) {
                    currentPage = page;
                    cargarPruebas();
                }
            });
        });

        // Botones
        document.getElementById('btnNuevaPrueba')?.addEventListener('click', function() {
            document.getElementById('modalNuevaPrueba').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });

        document.getElementById('btnExcel')?.addEventListener('click', function() {
            const params = new URLSearchParams({
                proyecto_id: document.getElementById('selectorProyecto').value,
                fecha_inicio: document.getElementById('fechaInicio').value,
                fecha_fin: document.getElementById('fechaFin').value
            });
            window.open(`/proyectos/calidad-api/exportar/excel?${params.toString()}`, '_blank');
        });

        document.getElementById('btnReporte')?.addEventListener('click', function() {
            const params = new URLSearchParams({
                proyecto_id: document.getElementById('selectorProyecto').value,
                fecha_inicio: document.getElementById('fechaInicio').value,
                fecha_fin: document.getElementById('fechaFin').value
            });
            window.open(`/proyectos/calidad-api/reporte/pdf?${params.toString()}`, '_blank');
        });

        document.getElementById('btnCrearFiltro')?.addEventListener('click', function() {
            alert('Crear filtro - Funcionalidad en desarrollo');
        });

        // Modal Nueva Prueba
        const modalNuevaPrueba = document.getElementById('modalNuevaPrueba');
        document.getElementById('btnCerrarModal')?.addEventListener('click', function() {
            modalNuevaPrueba.style.display = 'none';
            document.body.style.overflow = 'auto';
        });
        
        document.getElementById('btnCancelar')?.addEventListener('click', function() {
            modalNuevaPrueba.style.display = 'none';
            document.body.style.overflow = 'auto';
        });

        document.getElementById('btnGuardar')?.addEventListener('click', async function() {
            const data = {
                proyecto_id: document.getElementById('modalProyecto').value,
                tipo_prueba: document.getElementById('modalTipoPrueba').value,
                elemento: document.getElementById('modalElemento').value,
                fecha: document.getElementById('modalFecha').value,
                resultado: document.getElementById('modalResultado').value,
                responsable_id: document.getElementById('modalResponsable').value,
                laboratorio: document.getElementById('modalLaboratorio').value,
                valor: document.getElementById('modalValor').value,
                especificacion: document.getElementById('modalEspecificacion').value,
                norma: document.getElementById('modalNorma').value,
                observaciones: document.getElementById('modalObservaciones').value
            };
            
            if (!data.proyecto_id || !data.tipo_prueba || !data.elemento || !data.responsable_id) {
                alert('Por favor complete todos los campos requeridos');
                return;
            }
            
            try {
                const response = await fetch('/proyectos/calidad-api/prueba', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('Prueba guardada correctamente');
                    modalNuevaPrueba.style.display = 'none';
                    document.body.style.overflow = 'auto';
                    cargarTodosLosDatos();
                } else {
                    alert('Error: ' + (result.message || 'Error al guardar la prueba'));
                }
            } catch (error) {
                console.error('Error al guardar prueba:', error);
                alert('Error al guardar la prueba');
            }
        });

        // Cerrar modales con click fuera
        window.addEventListener('click', function(event) {
            if (event.target === document.getElementById('modalNuevaPrueba')) {
                document.getElementById('modalNuevaPrueba').style.display = 'none';
                document.body.style.overflow = 'auto';
            }
            if (event.target === document.getElementById('modalVerDetalle')) {
                window.cerrarModalDetalle();
            }
            if (event.target === document.getElementById('modalVerNC')) {
                window.cerrarModalNC();
            }
        });

        // Cargar datos iniciales
        cargarTodosLosDatos();

        // Exponer funciones globales
        window.cargarTodosLosDatos = cargarTodosLosDatos;
        window.cargarPruebas = cargarPruebas;
        window.cargarIndicadores = cargarIndicadores;
        window.cargarNoConformidades = cargarNoConformidades;
    });
</script>
@endsection