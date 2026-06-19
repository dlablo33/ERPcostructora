@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Desviaciones de Costo y Tiempo -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-chart-line" style="margin-right: 10px;"></i>
                    Desviaciones de Costo y Tiempo
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE DESVIACIONES CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Desviación en Costo -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Desviación Costo</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="desviacionCosto">$0</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Desviación en Tiempo -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Desviación Tiempo</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="desviacionTiempo">0 días</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: CPI (Índice de Costo) -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">CPI</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="cpi">1.00</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: SPI (Índice de Tiempo) -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">SPI</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="spi">1.00</div>
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
                        <!-- Selector de proyecto -->
                        <div>
                            <select id="selectorProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 250px;">
                                <option value="">Todos los proyectos</option>
                                @foreach($proyectos ?? [] as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Inicio -->
                        <div>
                            <input type="date" id="fechaInicio" value="{{ date('Y-m-d', strtotime('-30 days')) }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Date Fin -->
                        <div>
                            <input type="date" id="fechaFin" value="{{ date('Y-m-d') }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
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
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Pestañas de vistas -->
                <div style="display: flex; gap: 2px; margin-bottom: 20px; border-bottom: 2px solid #083CAE; overflow-x: auto; white-space: nowrap;">
                    <button class="vista-tab active" data-vista="resumen" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-chart-pie"></i> Resumen de Desviaciones
                    </button>
                    <button class="vista-tab" data-vista="costos" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-dollar-sign"></i> Desviaciones en Costo
                    </button>
                    <button class="vista-tab" data-vista="tiempo" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-clock"></i> Desviaciones en Tiempo
                    </button>
                </div>

                <!-- Loader -->
                <div id="loaderContainer" style="text-align: center; padding: 40px 20px; display: none;">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p style="color: #6c757d; margin-top: 10px;">Cargando datos...</p>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-chart-line" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros de desviaciones</p>
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

                <!-- VISTA RESUMEN DE DESVIACIONES -->
                <div id="vistaResumen" class="vista-content active">
                    <!-- Gráficos de resumen -->
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <!-- Gráfico de desviaciones por proyecto -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-bar"></i> Desviaciones por Proyecto
                            </h4>
                            <div id="graficoDesviaciones" style="height: 200px; display: flex; align-items: flex-end; gap: 15px; justify-content: center; padding: 10px 0;">
                                <!-- Los gráficos se generarán dinámicamente -->
                                <div style="text-align: center; color: #6c757d; width: 100%;">
                                    <i class="fas fa-chart-bar" style="font-size: 32px;"></i>
                                    <p style="font-size: 14px; margin-top: 5px;">Cargando gráficos...</p>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: center; gap: 30px; margin-top: 15px;">
                                <span style="font-size: 12px; display: flex; align-items: center;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #dc3545; margin-right: 5px;"></span> Sobrecosto</span>
                                <span style="font-size: 12px; display: flex; align-items: center;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #28a745; margin-right: 5px;"></span> Ahorro</span>
                                <span style="font-size: 12px; display: flex; align-items: center;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #ffc107; margin-right: 5px;"></span> Neutro</span>
                            </div>
                        </div>

                        <!-- KPIs de desviaciones -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-line"></i> Indicadores Clave
                            </h4>
                            <div id="kpisContainer">
                                <div style="margin-bottom: 15px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="font-size: 13px;">Costo Total Presupuestado</span>
                                        <span style="font-size: 13px; font-weight: 600;" id="kpiPresupuesto">$0</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                        <div id="barraPresupuesto" style="width: 0%; height: 8px; background-color: #2378e1; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="font-size: 13px;">Costo Real</span>
                                        <span style="font-size: 13px; font-weight: 600;" id="kpiReal">$0</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                        <div id="barraReal" style="width: 0%; height: 8px; background-color: #dc3545; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="font-size: 13px;">Plazo Planificado</span>
                                        <span style="font-size: 13px; font-weight: 600;" id="kpiPlazoPlan">0 días</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                        <div id="barraPlazoPlan" style="width: 0%; height: 8px; background-color: #2378e1; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="font-size: 13px;">Plazo Real Estimado</span>
                                        <span style="font-size: 13px; font-weight: 600;" id="kpiPlazoReal">0 días</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                        <div id="barraPlazoReal" style="width: 0%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla resumen por proyecto -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 12px;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Proyecto</th>
                                    <th style="padding: 12px; text-align: right;">Presupuesto</th>
                                    <th style="padding: 12px; text-align: right;">Costo Real</th>
                                    <th style="padding: 12px; text-align: right;">Desviación $</th>
                                    <th style="padding: 12px; text-align: center;">Desviación %</th>
                                    <th style="padding: 12px; text-align: right;">Plazo Plan</th>
                                    <th style="padding: 12px; text-align: right;">Plazo Real</th>
                                    <th style="padding: 12px; text-align: center;">Desviación T</th>
                                    <th style="padding: 12px; text-align: center;">CPI</th>
                                    <th style="padding: 12px; text-align: center;">SPI</th>
                                </tr>
                            </thead>
                            <tbody id="tablaResumenBody">
                                <!-- Las filas se insertarán dinámicamente -->
                                <tr>
                                    <td colspan="10" style="text-align: center; padding: 30px; color: #6c757d;">
                                        <i class="fas fa-spinner fa-spin"></i> Cargando datos...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- VISTA DESVIACIONES EN COSTO -->
                <div id="vistaCostos" class="vista-content" style="display: none;">
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainerCostos">
                        <table class="table table-bordered" id="tablaCostos" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                            <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                                <tr>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="proyecto">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Proyecto</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="partida">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Partida</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="categoria">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Categoría</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="presupuestado">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Presupuestado</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="real">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Real</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="desviacion">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Desviación $</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="porcentaje">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>% Desviación</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="causa">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Causa Principal</span>
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
                            <tbody id="tablaBodyCostos">
                                <!-- Las filas se insertarán dinámicamente con JavaScript -->
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 30px; color: #6c757d;">
                                        <i class="fas fa-spinner fa-spin"></i> Cargando datos...
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot id="tablaFootCostos" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold; display: table-footer-group;">
                                <tr>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="3">Totales:</td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="totalPresupuesto">$0.00</td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="totalReal">$0.00</td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="totalDesviacion">$0.00</td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" id="promDesviacion">0.0%</td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;" colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- VISTA DESVIACIONES EN TIEMPO -->
                <div id="vistaTiempo" class="vista-content" style="display: none;">
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainerTiempo">
                        <table class="table table-bordered" id="tablaTiempo" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                            <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                                <tr>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="proyecto">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Proyecto</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="actividad">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Actividad / Hito</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_plan">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Fecha Plan</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_real">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Fecha Real</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="desviacion">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Desviación (días)</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="impacto">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Impacto</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="causa">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Causa Principal</span>
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
                            <tbody id="tablaBodyTiempo">
                                <!-- Las filas se insertarán dinámicamente con JavaScript -->
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 30px; color: #6c757d;">
                                        <i class="fas fa-spinner fa-spin"></i> Cargando datos...
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
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 0-0 de 0 registros</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Ver Detalle de Desviación -->
<div id="modalVerDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 700px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-chart-line"></i> Detalle de Desviación
            </h3>
            <button id="btnCerrarDetalle" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div>
                    <div style="font-size: 12px; color: #6c757d;">Proyecto / Partida</div>
                    <div style="font-size: 18px; font-weight: 600;" id="detalleConcepto">-</div>
                </div>
                <div>
                    <span style="background-color: #dc3545; color: white; padding: 6px 15px; border-radius: 20px; font-size: 14px; font-weight: 600;" id="detalleTipo">-</span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Presupuestado</div>
                    <div style="font-size: 20px; font-weight: 700;" id="detallePresupuestado">$0</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Real</div>
                    <div style="font-size: 20px; font-weight: 700;" id="detalleReal">$0</div>
                </div>
            </div>

            <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Desviación</div>
                        <div style="font-size: 24px; font-weight: 700; color: #dc3545;" id="detalleDesviacion">$0</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Porcentaje</div>
                        <div style="font-size: 20px; font-weight: 700; color: #dc3545;" id="detallePorcentaje">0%</div>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <div style="color: #6c757d; font-size: 12px;">Causa Principal</div>
                <div style="font-size: 14px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px;" id="detalleCausa">
                    Sin información
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <div style="color: #6c757d; font-size: 12px;">Impacto en Proyecto</div>
                <div style="font-size: 14px;" id="detalleImpacto">Sin información</div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Acciones Correctivas</div>
                <div style="font-size: 14px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px;" id="detalleAcciones">
                    Sin acciones registradas
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button style="padding: 8px 15px; background-color: #ffc107; color: #856404; border: none; border-radius: 4px; cursor: pointer;" onclick="editarDesviacion()">
                    <i class="fas fa-edit"></i> Editar
                </button>
                <button style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="cerrarModalDetalle()">
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
    
    #tablaBodyCostos tr:nth-child(odd),
    #tablaBodyTiempo tr:nth-child(odd),
    #tablaResumenBody tr:nth-child(odd) {
        background-color: #ffffff;
    }
    
    #tablaBodyCostos tr:nth-child(even),
    #tablaBodyTiempo tr:nth-child(even),
    #tablaResumenBody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    
    #tablaBodyCostos tr:hover,
    #tablaBodyTiempo tr:hover,
    #tablaResumenBody tr:hover {
        background-color: #e0e0e0;
    }
    
    #tablaBodyCostos td i,
    #tablaBodyTiempo td i {
        transition: transform 0.2s;
        font-size: 14px;
        color: #083CAE;
    }
    
    #tablaBodyCostos td i:hover,
    #tablaBodyTiempo td i:hover {
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
    
    #tablaBodyCostos td:last-child,
    #tablaBodyTiempo td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
    }
    
    .badge-desviacion {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        font-weight: 600;
    }
    
    .badge-positiva {
        background-color: #28a745;
        color: white;
    }
    
    .badge-negativa {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-neutra {
        background-color: #ffc107;
        color: #856404;
    }
    
    .badge-impacto {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        font-weight: 600;
    }
    
    .badge-alto {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-medio {
        background-color: #ffc107;
        color: #856404;
    }
    
    .badge-bajo {
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
    
    .drag-over #grupoColumnas {
        background-color: rgba(35, 120, 225, 0.1);
        border-radius: 4px;
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
    // ════════════════════════════════════════════════════════════════
    // VARIABLES GLOBALES
    // ════════════════════════════════════════════════════════════════
    let columnasAgrupadas = [];
    let expandedGroups = new Set();
    let datosOriginalesCostos = [];
    let datosOriginalesTiempo = [];
    let currentPage = 1;
    let rowsPerPage = 10;
    let totalRegistros = 0;

    // ════════════════════════════════════════════════════════════════
    // FUNCIONES DE CARGA DE DATOS
    // ════════════════════════════════════════════════════════════════

    /**
     * Carga todos los datos necesarios para el dashboard
     */
    async function cargarTodosLosDatos() {
        mostrarLoader(true);
        ocultarErrores();
        
        try {
            await Promise.all([
                cargarResumen(),
                cargarProyectos(),
                cargarCostos(),
                cargarTiempos(),
                cargarGraficos()
            ]);
            
            mostrarLoader(false);
        } catch (error) {
            console.error('Error al cargar datos:', error);
            mostrarError('Error al cargar los datos: ' + error.message);
            mostrarLoader(false);
        }
    }

    /**
     * Carga el resumen general de desviaciones
     */
    async function cargarResumen() {
        try {
            const response = await fetch('/desviaciones-api/resumen');
            if (!response.ok) throw new Error('Error al cargar resumen');
            
            const data = await response.json();
            
            document.getElementById('desviacionCosto').textContent = data.desviacion_costo || '$0';
            document.getElementById('desviacionTiempo').textContent = data.desviacion_tiempo || '0 días';
            document.getElementById('cpi').textContent = data.cpi || '1.00';
            document.getElementById('spi').textContent = data.spi || '1.00';
            
        } catch (error) {
            console.error('Error en resumen:', error);
            throw error;
        }
    }

    /**
     * Carga la tabla resumen de proyectos
     */
    async function cargarProyectos() {
        try {
            const response = await fetch('/desviaciones-api/proyectos');
            if (!response.ok) throw new Error('Error al cargar proyectos');
            
            const data = await response.json();
            const tbody = document.getElementById('tablaResumenBody');
            
            if (!data || data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="10" style="text-align: center; padding: 30px; color: #6c757d;">
                            <i class="fas fa-inbox"></i> No hay proyectos registrados
                        </td>
                    </tr>
                `;
                return;
            }
            
            let html = '';
            data.forEach(proyecto => {
                const colorDesviacion = proyecto.desviacion_monto > 0 ? '#dc3545' : 
                                       proyecto.desviacion_monto < 0 ? '#28a745' : '#ffc107';
                const colorTiempo = proyecto.desviacion_tiempo > 0 ? '#dc3545' : 
                                   proyecto.desviacion_tiempo < 0 ? '#28a745' : '#ffc107';
                const colorCPI = proyecto.cpi < 1 ? '#dc3545' : 
                                proyecto.cpi > 1 ? '#28a745' : '#ffc107';
                const colorSPI = proyecto.spi < 1 ? '#dc3545' : 
                                proyecto.spi > 1 ? '#28a745' : '#ffc107';
                
                html += `
                    <tr>
                        <td style="padding: 12px;"><strong>${proyecto.proyecto}</strong></td>
                        <td style="padding: 12px; text-align: right;">${formatCurrency(proyecto.presupuesto)}</td>
                        <td style="padding: 12px; text-align: right;">${formatCurrency(proyecto.costo_real)}</td>
                        <td style="padding: 12px; text-align: right; color: ${colorDesviacion};">${formatCurrency(proyecto.desviacion_monto)}</td>
                        <td style="padding: 12px; text-align: center;">
                            <span class="badge-desviacion ${getDesviacionBadgeClass(proyecto.desviacion_monto)}">
                                ${proyecto.desviacion_porcentaje > 0 ? '+' : ''}${proyecto.desviacion_porcentaje}%
                            </span>
                        </td>
                        <td style="padding: 12px; text-align: right;">${proyecto.plazo_plan}</td>
                        <td style="padding: 12px; text-align: right;">${proyecto.plazo_real}</td>
                        <td style="padding: 12px; text-align: center; color: ${colorTiempo};">${proyecto.desviacion_tiempo > 0 ? '+' : ''}${proyecto.desviacion_tiempo} días</td>
                        <td style="padding: 12px; text-align: center; color: ${colorCPI};">${proyecto.cpi}</td>
                        <td style="padding: 12px; text-align: center; color: ${colorSPI};">${proyecto.spi}</td>
                    </tr>
                `;
            });
            
            tbody.innerHTML = html;
            
        } catch (error) {
            console.error('Error en proyectos:', error);
            throw error;
        }
    }

    /**
     * Carga las desviaciones en costo
     */
    async function cargarCostos(params = {}) {
        try {
            const proyectoId = document.getElementById('selectorProyecto').value;
            const search = document.getElementById('buscador').value;
            const fechaInicio = document.getElementById('fechaInicio').value;
            const fechaFin = document.getElementById('fechaFin').value;
            
            let url = `/desviaciones-api/costos?per_page=${rowsPerPage}&page=${currentPage}`;
            if (proyectoId) url += `&proyecto_id=${proyectoId}`;
            if (search) url += `&search=${encodeURIComponent(search)}`;
            if (fechaInicio) url += `&fecha_inicio=${fechaInicio}`;
            if (fechaFin) url += `&fecha_fin=${fechaFin}`;
            
            const response = await fetch(url);
            if (!response.ok) throw new Error('Error al cargar costos');
            
            const data = await response.json();
            datosOriginalesCostos = data.data || [];
            totalRegistros = data.pagination?.total || 0;
            
            renderizarTablaCostos(datosOriginalesCostos);
            actualizarPaginacion(data.pagination);
            
        } catch (error) {
            console.error('Error en costos:', error);
            throw error;
        }
    }

    /**
     * Carga las desviaciones en tiempo
     */
    async function cargarTiempos(params = {}) {
        try {
            const proyectoId = document.getElementById('selectorProyecto').value;
            const search = document.getElementById('buscador').value;
            const fechaInicio = document.getElementById('fechaInicio').value;
            const fechaFin = document.getElementById('fechaFin').value;
            
            let url = `/desviaciones-api/tiempos?per_page=${rowsPerPage}&page=${currentPage}`;
            if (proyectoId) url += `&proyecto_id=${proyectoId}`;
            if (search) url += `&search=${encodeURIComponent(search)}`;
            if (fechaInicio) url += `&fecha_inicio=${fechaInicio}`;
            if (fechaFin) url += `&fecha_fin=${fechaFin}`;
            
            const response = await fetch(url);
            if (!response.ok) throw new Error('Error al cargar tiempos');
            
            const data = await response.json();
            datosOriginalesTiempo = data.data || [];
            
            renderizarTablaTiempo(datosOriginalesTiempo);
            
        } catch (error) {
            console.error('Error en tiempos:', error);
            throw error;
        }
    }

    /**
     * Carga los datos para gráficos y KPIs
     */
    async function cargarGraficos() {
        try {
            const response = await fetch('/desviaciones-api/graficos');
            if (!response.ok) throw new Error('Error al cargar gráficos');
            
            const data = await response.json();
            
            if (data.kpis) {
                document.getElementById('kpiPresupuesto').textContent = formatCurrency(data.kpis.costo_presupuestado || 0);
                document.getElementById('kpiReal').textContent = formatCurrency(data.kpis.costo_real || 0);
                document.getElementById('kpiPlazoPlan').textContent = (data.kpis.plazo_plan || 0) + ' días';
                document.getElementById('kpiPlazoReal').textContent = (data.kpis.plazo_real || 0) + ' días';
                
                const maxCosto = Math.max(data.kpis.costo_presupuestado || 1, data.kpis.costo_real || 1);
                const maxPlazo = Math.max(data.kpis.plazo_plan || 1, data.kpis.plazo_real || 1);
                
                document.getElementById('barraPresupuesto').style.width = ((data.kpis.costo_presupuestado || 0) / maxCosto * 100) + '%';
                document.getElementById('barraReal').style.width = ((data.kpis.costo_real || 0) / maxCosto * 100) + '%';
                document.getElementById('barraPlazoPlan').style.width = ((data.kpis.plazo_plan || 0) / maxPlazo * 100) + '%';
                document.getElementById('barraPlazoReal').style.width = ((data.kpis.plazo_real || 0) / maxPlazo * 100) + '%';
            }
            
            if (data.por_proyecto && data.por_proyecto.length > 0) {
                renderizarGraficoDesviaciones(data.por_proyecto);
            }
            
        } catch (error) {
            console.error('Error en gráficos:', error);
        }
    }

    // ════════════════════════════════════════════════════════════════
    // FUNCIONES DE RENDERIZADO
    // ════════════════════════════════════════════════════════════════

    function renderizarTablaCostos(datos) {
        const tablaBody = document.getElementById('tablaBodyCostos');
        if (!tablaBody) return;
        
        if (!datos || datos.length === 0) {
            tablaBody.innerHTML = `
                <tr>
                    <td colspan="9" style="text-align: center; padding: 30px; color: #6c757d;">
                        <i class="fas fa-inbox"></i> No hay registros de desviaciones en costo
                    </td>
                </tr>
            `;
            actualizarTotalesCostos([]);
            return;
        }
        
        let html = '';
        let totalPresupuesto = 0;
        let totalReal = 0;
        let totalDesviacion = 0;
        
        datos.forEach(item => {
            const badgeClass = getDesviacionBadgeClass(item.desviacion);
            const colorDesviacion = item.desviacion > 0 ? '#dc3545' : item.desviacion < 0 ? '#28a745' : '#ffc107';
            
            totalPresupuesto += item.presupuestado || 0;
            totalReal += item.real || 0;
            totalDesviacion += item.desviacion || 0;
            
            html += `
                <tr>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.proyecto || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.partida || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.categoria || 'General'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${formatCurrency(item.presupuestado)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${formatCurrency(item.real)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: ${colorDesviacion};">${formatCurrency(item.desviacion)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">
                        <span class="badge-desviacion ${badgeClass}">
                            ${item.desviacion > 0 ? '+' : ''}${item.porcentaje}%
                        </span>
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.causa || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetalle('${item.proyecto} - ${item.partida}', 'costo', ${JSON.stringify(item).replace(/"/g, '&quot;')})"></i>
                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer;"></i>
                        </div>
                    </td>
                </tr>
            `;
        });
        
        tablaBody.innerHTML = html;
        actualizarTotalesCostos({ totalPresupuesto, totalReal, totalDesviacion });
    }

    function renderizarTablaTiempo(datos) {
        const tablaBody = document.getElementById('tablaBodyTiempo');
        if (!tablaBody) return;
        
        if (!datos || datos.length === 0) {
            tablaBody.innerHTML = `
                <tr>
                    <td colspan="8" style="text-align: center; padding: 30px; color: #6c757d;">
                        <i class="fas fa-inbox"></i> No hay registros de desviaciones en tiempo
                    </td>
                </tr>
            `;
            return;
        }
        
        let html = '';
        datos.forEach(item => {
            const badgeClass = getDesviacionBadgeClass(item.desviacion);
            const impactoBadge = getImpactoBadgeClass(item.impacto);
            const colorDesviacion = item.desviacion > 0 ? '#dc3545' : item.desviacion < 0 ? '#28a745' : '#ffc107';
            
            html += `
                <tr>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.proyecto || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.actividad || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">${item.fecha_plan || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">${item.fecha_real || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: ${colorDesviacion};">${item.desviacion > 0 ? '+' : ''}${item.desviacion} días</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">
                        <span class="badge-impacto ${impactoBadge}">${item.impacto || 'Medio'}</span>
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.causa || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetalle('${item.proyecto} - ${item.actividad}', 'tiempo', ${JSON.stringify(item).replace(/"/g, '&quot;')})"></i>
                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer;"></i>
                        </div>
                    </td>
                </tr>
            `;
        });
        
        tablaBody.innerHTML = html;
    }

    function renderizarGraficoDesviaciones(datos) {
        const container = document.getElementById('graficoDesviaciones');
        if (!container) return;
        
        if (!datos || datos.length === 0) {
            container.innerHTML = `
                <div style="text-align: center; color: #6c757d; width: 100%;">
                    <i class="fas fa-chart-bar" style="font-size: 32px;"></i>
                    <p style="font-size: 14px; margin-top: 5px;">No hay datos para mostrar</p>
                </div>
            `;
            return;
        }
        
        const maxAbs = Math.max(...datos.map(d => Math.abs(d.desviacion || 0)));
        const maxHeight = 150;
        
        let html = '';
        const colores = {
            'sobrecosto': '#dc3545',
            'ahorro': '#28a745',
            'neutro': '#ffc107'
        };
        
        datos.forEach(item => {
            const valor = item.desviacion || 0;
            const altura = maxAbs > 0 ? (Math.abs(valor) / maxAbs) * maxHeight : 0;
            const color = colores[item.tipo] || '#6c757d';
            const signo = valor > 0 ? '+' : '';
            
            html += `
                <div style="text-align: center; width: 70px;">
                    <div style="height: ${Math.max(altura, 5)}px; background-color: ${color}; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0; transition: height 0.5s;"></div>
                    <div style="margin-top: 5px; font-size: 11px;">${item.nombre}</div>
                    <div style="font-size: 10px; color: ${color};">${signo}${valor}%</div>
                </div>
            `;
        });
        
        container.innerHTML = html;
    }

    function actualizarTotalesCostos(totales) {
        document.getElementById('totalPresupuesto').textContent = formatCurrency(totales.totalPresupuesto || 0);
        document.getElementById('totalReal').textContent = formatCurrency(totales.totalReal || 0);
        document.getElementById('totalDesviacion').textContent = formatCurrency(totales.totalDesviacion || 0);
        
        const promedio = (totales.totalPresupuesto || 0) > 0 
            ? ((totales.totalDesviacion || 0) / (totales.totalPresupuesto || 1)) * 100 
            : 0;
        document.getElementById('promDesviacion').textContent = (promedio > 0 ? '+' : '') + promedio.toFixed(1) + '%';
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
    // FUNCIONES DE UTILIDAD
    // ════════════════════════════════════════════════════════════════

    function formatCurrency(amount) {
        if (amount === undefined || amount === null) return '$0';
        const sign = amount >= 0 ? '' : '-';
        return sign + '$' + Math.abs(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }

    function getDesviacionBadgeClass(desviacion) {
        if (desviacion > 0) return 'badge-negativa';
        if (desviacion < 0) return 'badge-positiva';
        return 'badge-neutra';
    }

    function getImpactoBadgeClass(impacto) {
        switch(impacto) {
            case 'Alto': return 'badge-alto';
            case 'Medio': return 'badge-medio';
            case 'Bajo': return 'badge-bajo';
            default: return 'badge-medio';
        }
    }

    function mostrarLoader(mostrar) {
        const loader = document.getElementById('loaderContainer');
        if (loader) {
            loader.style.display = mostrar ? 'block' : 'none';
        }
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
        if (errorDiv) {
            errorDiv.style.display = 'none';
        }
    }

    // ════════════════════════════════════════════════════════════════
    // FUNCIONES DEL MODAL
    // ════════════════════════════════════════════════════════════════

    window.verDetalle = function(concepto, tipo, data) {
        const modal = document.getElementById('modalVerDetalle');
        if (!modal) return;
        
        try {
            const item = typeof data === 'string' ? JSON.parse(data) : data;
            
            document.getElementById('detalleConcepto').textContent = concepto || 'Sin información';
            document.getElementById('detallePresupuestado').textContent = formatCurrency(item.presupuestado || 0);
            document.getElementById('detalleReal').textContent = formatCurrency(item.real || 0);
            document.getElementById('detalleDesviacion').textContent = formatCurrency(item.desviacion || 0);
            document.getElementById('detallePorcentaje').textContent = (item.porcentaje || 0) + '%';
            document.getElementById('detalleCausa').textContent = item.causa || 'Sin información';
            document.getElementById('detalleImpacto').textContent = item.impacto || 'Sin información';
            document.getElementById('detalleAcciones').textContent = 'Se recomienda revisar la causa y tomar acciones correctivas.';
            
            const tipoElement = document.getElementById('detalleTipo');
            if (item.desviacion > 0) {
                tipoElement.textContent = tipo === 'costo' ? 'Sobrecosto' : 'Atraso';
                tipoElement.style.backgroundColor = '#dc3545';
            } else if (item.desviacion < 0) {
                tipoElement.textContent = tipo === 'costo' ? 'Ahorro' : 'Adelanto';
                tipoElement.style.backgroundColor = '#28a745';
            } else {
                tipoElement.textContent = 'Neutro';
                tipoElement.style.backgroundColor = '#ffc107';
                tipoElement.style.color = '#856404';
            }
            
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            
        } catch (e) {
            console.error('Error al mostrar detalle:', e);
        }
    };

    window.cerrarModalDetalle = function() {
        const modal = document.getElementById('modalVerDetalle');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    };

    window.editarDesviacion = function() {
        alert('Editar desviación - Funcionalidad en desarrollo');
    };

    // ════════════════════════════════════════════════════════════════
    // EVENT LISTENERS
    // ════════════════════════════════════════════════════════════════

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado - Iniciando carga de datos...');
        
        cargarTodosLosDatos();
        
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
                
                if (index === 1) {
                    cargarCostos();
                } else if (index === 2) {
                    cargarTiempos();
                }
            });
        });
        
        document.getElementById('selectorProyecto')?.addEventListener('change', function() {
            currentPage = 1;
            cargarCostos();
            cargarTiempos();
        });
        
        let searchTimeout;
        document.getElementById('buscador')?.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentPage = 1;
                cargarCostos();
                cargarTiempos();
            }, 500);
        });
        
        document.getElementById('fechaInicio')?.addEventListener('change', function() {
            currentPage = 1;
            cargarCostos();
            cargarTiempos();
        });
        
        document.getElementById('fechaFin')?.addEventListener('change', function() {
            currentPage = 1;
            cargarCostos();
            cargarTiempos();
        });
        
        document.getElementById('btnPrimera')?.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage = 1;
                cargarCostos();
            }
        });
        
        document.getElementById('btnAnterior')?.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                cargarCostos();
            }
        });
        
        document.getElementById('btnSiguiente')?.addEventListener('click', function() {
            currentPage++;
            cargarCostos();
        });
        
        document.getElementById('btnUltima')?.addEventListener('click', function() {
            const total = totalRegistros;
            const lastPage = Math.ceil(total / rowsPerPage);
            if (currentPage < lastPage) {
                currentPage = lastPage;
                cargarCostos();
            }
        });
        
        document.querySelectorAll('.pagina-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const page = parseInt(this.dataset.pagina);
                if (page !== currentPage) {
                    currentPage = page;
                    cargarCostos();
                }
            });
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            const params = new URLSearchParams({
                proyecto_id: document.getElementById('selectorProyecto').value,
                fecha_inicio: document.getElementById('fechaInicio').value,
                fecha_fin: document.getElementById('fechaFin').value
            });
            window.open(`/desviaciones-api/exportar/excel?${params.toString()}`, '_blank');
        });
        
        document.getElementById('btnReporte')?.addEventListener('click', function() {
            const params = new URLSearchParams({
                proyecto_id: document.getElementById('selectorProyecto').value,
                fecha_inicio: document.getElementById('fechaInicio').value,
                fecha_fin: document.getElementById('fechaFin').value
            });
            window.open(`/desviaciones-api/reporte/pdf?${params.toString()}`, '_blank');
        });
        
        document.getElementById('btnCrearFiltro')?.addEventListener('click', function() {
            alert('Crear filtro - Funcionalidad en desarrollo');
        });
        
        document.getElementById('btnCerrarDetalle')?.addEventListener('click', window.cerrarModalDetalle);
        
        window.addEventListener('click', function(event) {
            if (event.target === document.getElementById('modalVerDetalle')) {
                window.cerrarModalDetalle();
            }
        });
    });

    window.cargarTodosLosDatos = cargarTodosLosDatos;
    window.cargarCostos = cargarCostos;
    window.cargarTiempos = cargarTiempos;
</script>
@endsection