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
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="desviacionCosto">+$2.4M</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Desviación en Tiempo -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Desviación Tiempo</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="desviacionTiempo">+24 días</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: CPI (Índice de Costo) -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">CPI</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="cpi">0.89</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: SPI (Índice de Tiempo) -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">SPI</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="spi">0.92</div>
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
                                <option value="torre" selected>🏢 Torre Norte Corporativa</option>
                                <option value="puente">🌉 Puente Vehicular Sur</option>
                                <option value="parque">🏭 Parque Industrial Norte</option>
                                <option value="hospital">🏥 Hospital Regional</option>
                                <option value="planta">💧 Planta de Tratamiento</option>
                                <option value="urbanizacion">🏘️ Urbanización Los Álamos</option>
                            </select>
                        </div>

                        <!-- Date Inicio -->
                        <div>
                            <input type="date" id="fechaInicio" value="2026-01-01" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Date Fin -->
                        <div>
                            <input type="date" id="fechaFin" value="2026-12-31" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
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

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-chart-line" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros de desviaciones</p>
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
                            <div style="height: 200px; display: flex; align-items: flex-end; gap: 15px; justify-content: center;">
                                <div style="text-align: center; width: 70px;">
                                    <div style="height: 80px; background-color: #dc3545; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="height: 30px; background-color: #28a745; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0; margin-top: -30px;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Torre</div>
                                    <div style="font-size: 10px; color: #dc3545;">+8.2%</div>
                                </div>
                                <div style="text-align: center; width: 70px;">
                                    <div style="height: 45px; background-color: #ffc107; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="height: 50px; background-color: #28a745; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0; margin-top: -50px;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Puente</div>
                                    <div style="font-size: 10px; color: #ffc107;">+4.5%</div>
                                </div>
                                <div style="text-align: center; width: 70px;">
                                    <div style="height: 25px; background-color: #28a745; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Parque</div>
                                    <div style="font-size: 10px; color: #28a745;">-2.3%</div>
                                </div>
                                <div style="text-align: center; width: 70px;">
                                    <div style="height: 95px; background-color: #dc3545; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Hospital</div>
                                    <div style="font-size: 10px; color: #dc3545;">+9.5%</div>
                                </div>
                                <div style="text-align: center; width: 70px;">
                                    <div style="height: 60px; background-color: #ffc107; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Planta</div>
                                    <div style="font-size: 10px; color: #ffc107;">+6.0%</div>
                                </div>
                                <div style="text-align: center; width: 70px;">
                                    <div style="height: 15px; background-color: #28a745; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Urb.</div>
                                    <div style="font-size: 10px; color: #28a745;">-1.5%</div>
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
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Costo Total Presupuestado</span>
                                    <span style="font-size: 13px; font-weight: 600;">$156.8M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 100%; height: 8px; background-color: #2378e1; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Costo Real</span>
                                    <span style="font-size: 13px; font-weight: 600;">$159.2M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 101.5%; height: 8px; background-color: #dc3545; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Plazo Planificado</span>
                                    <span style="font-size: 13px; font-weight: 600;">292 días</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 100%; height: 8px; background-color: #2378e1; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Plazo Real Estimado</span>
                                    <span style="font-size: 13px; font-weight: 600;">316 días</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 108%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
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
                            <tbody>
                                <tr>
                                    <td style="padding: 12px;"><strong>Torre Norte Corporativa</strong></td>
                                    <td style="padding: 12px; text-align: right;">$45,500,000</td>
                                    <td style="padding: 12px; text-align: right;">$49,200,000</td>
                                    <td style="padding: 12px; text-align: right; color: #dc3545;">+$3,700,000</td>
                                    <td style="padding: 12px; text-align: center;"><span style="color: #dc3545;">+8.2%</span></td>
                                    <td style="padding: 12px; text-align: right;">335</td>
                                    <td style="padding: 12px; text-align: right;">355</td>
                                    <td style="padding: 12px; text-align: center; color: #dc3545;">+20 días</td>
                                    <td style="padding: 12px; text-align: center; color: #dc3545;">0.92</td>
                                    <td style="padding: 12px; text-align: center; color: #ffc107;">0.94</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>Puente Vehicular Sur</strong></td>
                                    <td style="padding: 12px; text-align: right;">$28,750,000</td>
                                    <td style="padding: 12px; text-align: right;">$30,050,000</td>
                                    <td style="padding: 12px; text-align: right; color: #ffc107;">+$1,300,000</td>
                                    <td style="padding: 12px; text-align: center;"><span style="color: #ffc107;">+4.5%</span></td>
                                    <td style="padding: 12px; text-align: right;">303</td>
                                    <td style="padding: 12px; text-align: right;">315</td>
                                    <td style="padding: 12px; text-align: center; color: #ffc107;">+12 días</td>
                                    <td style="padding: 12px; text-align: center; color: #ffc107;">0.96</td>
                                    <td style="padding: 12px; text-align: center; color: #ffc107;">0.96</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>Parque Industrial Norte</strong></td>
                                    <td style="padding: 12px; text-align: right;">$52,300,000</td>
                                    <td style="padding: 12px; text-align: right;">$51,100,000</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">-$1,200,000</td>
                                    <td style="padding: 12px; text-align: center;"><span style="color: #28a745;">-2.3%</span></td>
                                    <td style="padding: 12px; text-align: right;">365</td>
                                    <td style="padding: 12px; text-align: right;">350</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">-15 días</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">1.02</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">1.04</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>Hospital Regional</strong></td>
                                    <td style="padding: 12px; text-align: right;">$78,900,000</td>
                                    <td style="padding: 12px; text-align: right;">$86,400,000</td>
                                    <td style="padding: 12px; text-align: right; color: #dc3545;">+$7,500,000</td>
                                    <td style="padding: 12px; text-align: center;"><span style="color: #dc3545;">+9.5%</span></td>
                                    <td style="padding: 12px; text-align: right;">242</td>
                                    <td style="padding: 12px; text-align: right;">265</td>
                                    <td style="padding: 12px; text-align: center; color: #dc3545;">+23 días</td>
                                    <td style="padding: 12px; text-align: center; color: #dc3545;">0.91</td>
                                    <td style="padding: 12px; text-align: center; color: #dc3545;">0.91</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>Planta de Tratamiento</strong></td>
                                    <td style="padding: 12px; text-align: right;">$34,200,000</td>
                                    <td style="padding: 12px; text-align: right;">$36,250,000</td>
                                    <td style="padding: 12px; text-align: right; color: #ffc107;">+$2,050,000</td>
                                    <td style="padding: 12px; text-align: center;"><span style="color: #ffc107;">+6.0%</span></td>
                                    <td style="padding: 12px; text-align: right;">274</td>
                                    <td style="padding: 12px; text-align: right;">285</td>
                                    <td style="padding: 12px; text-align: center; color: #ffc107;">+11 días</td>
                                    <td style="padding: 12px; text-align: center; color: #ffc107;">0.94</td>
                                    <td style="padding: 12px; text-align: center; color: #ffc107;">0.96</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><strong>Urbanización Los Álamos</strong></td>
                                    <td style="padding: 12px; text-align: right;">$67,800,000</td>
                                    <td style="padding: 12px; text-align: right;">$66,800,000</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">-$1,000,000</td>
                                    <td style="padding: 12px; text-align: center;"><span style="color: #28a745;">-1.5%</span></td>
                                    <td style="padding: 12px; text-align: right;">547</td>
                                    <td style="padding: 12px; text-align: right;">540</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">-7 días</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">1.01</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">1.01</td>
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
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-10 de 24 registros</span>
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
                    <div style="font-size: 18px; font-weight: 600;" id="detalleConcepto">Torre Norte - Cimentación</div>
                </div>
                <div>
                    <span style="background-color: #dc3545; color: white; padding: 6px 15px; border-radius: 20px; font-size: 14px; font-weight: 600;" id="detalleTipo">Sobrecosto</span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Presupuestado</div>
                    <div style="font-size: 20px; font-weight: 700;" id="detallePresupuestado">$1,250,000</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Real</div>
                    <div style="font-size: 20px; font-weight: 700;" id="detalleReal">$1,450,000</div>
                </div>
            </div>

            <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Desviación</div>
                        <div style="font-size: 24px; font-weight: 700; color: #dc3545;" id="detalleDesviacion">+$200,000</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Porcentaje</div>
                        <div style="font-size: 20px; font-weight: 700; color: #dc3545;" id="detallePorcentaje">+16%</div>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <div style="color: #6c757d; font-size: 12px;">Causa Principal</div>
                <div style="font-size: 14px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px;" id="detalleCausa">
                    Incremento en precio del acero (15% por encima del estimado) y mayores tiempos de cimentación por condiciones del suelo.
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <div style="color: #6c757d; font-size: 12px;">Impacto en Proyecto</div>
                <div style="font-size: 14px;" id="detalleImpacto">Retraso de 5 días en cronograma general</div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Acciones Correctivas</div>
                <div style="font-size: 14px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px;" id="detalleAcciones">
                    Se negociaron precios con proveedores alternativos. Se incrementó personal para recuperar tiempo perdido.
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
    #tablaBodyCostos tr:nth-child(odd),
    #tablaBodyTiempo tr:nth-child(odd) {
        background-color: #ffffff;
    }
    
    #tablaBodyCostos tr:nth-child(even),
    #tablaBodyTiempo tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    
    #tablaBodyCostos tr:hover,
    #tablaBodyTiempo tr:hover {
        background-color: #e0e0e0;
    }
    
    /* Estilo para los iconos de acción */
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
    #tablaBodyCostos td:last-child,
    #tablaBodyTiempo td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
    }
    
    /* Badges para desviaciones */
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
    
    /* Badges para impacto */
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
        console.log('DOM completamente cargado - Desviaciones');
        
        // Variables para agrupación
        let columnasAgrupadas = [];
        let expandedGroups = new Set();
        let datosOriginalesCostos = [];
        let datosOriginalesTiempo = [];
        let currentPage = 1;
        let rowsPerPage = 10;
        
        // Datos de ejemplo para Desviaciones en Costo - MÁS DATOS FICTICIOS
        const datosCostos = [
            // Torre Norte (6 registros)
            {
                proyecto: 'Torre Norte',
                partida: 'Cimentación',
                categoria: 'Materiales',
                presupuestado: 1250000,
                real: 1450000,
                desviacion: 200000,
                porcentaje: 16.0,
                causa: 'Incremento en precio del acero'
            },
            {
                proyecto: 'Torre Norte',
                partida: 'Estructura',
                categoria: 'Mano de Obra',
                presupuestado: 2380000,
                real: 2620000,
                desviacion: 240000,
                porcentaje: 10.1,
                causa: 'Menor rendimiento de cuadrillas'
            },
            {
                proyecto: 'Torre Norte',
                partida: 'Acabados',
                categoria: 'Materiales',
                presupuestado: 1850000,
                real: 1650000,
                desviacion: -200000,
                porcentaje: -10.8,
                causa: 'Compra por volumen con descuento'
            },
            {
                proyecto: 'Torre Norte',
                partida: 'Instalaciones Eléctricas',
                categoria: 'Subcontratos',
                presupuestado: 980000,
                real: 1150000,
                desviacion: 170000,
                porcentaje: 17.3,
                causa: 'Cambios en especificaciones técnicas'
            },
            {
                proyecto: 'Torre Norte',
                partida: 'Hidrosanitarias',
                categoria: 'Materiales',
                presupuestado: 650000,
                real: 720000,
                desviacion: 70000,
                porcentaje: 10.8,
                causa: 'Materiales de mayor calidad requeridos'
            },
            {
                proyecto: 'Torre Norte',
                partida: 'Fachada',
                categoria: 'Materiales',
                presupuestado: 2100000,
                real: 1950000,
                desviacion: -150000,
                porcentaje: -7.1,
                causa: 'Optimización en diseño'
            },
            
            // Puente Sur (5 registros)
            {
                proyecto: 'Puente Sur',
                partida: 'Pilotaje',
                categoria: 'Subcontratos',
                presupuestado: 3200000,
                real: 3560000,
                desviacion: 360000,
                porcentaje: 11.3,
                causa: 'Condiciones del suelo no previstas'
            },
            {
                proyecto: 'Puente Sur',
                partida: 'Superestructura',
                categoria: 'Materiales',
                presupuestado: 2850000,
                real: 2950000,
                desviacion: 100000,
                porcentaje: 3.5,
                causa: 'Ajuste en especificaciones'
            },
            {
                proyecto: 'Puente Sur',
                partida: 'Estribos',
                categoria: 'Concreto',
                presupuestado: 1450000,
                real: 1680000,
                desviacion: 230000,
                porcentaje: 15.9,
                causa: 'Mayor volumen de concreto requerido'
            },
            {
                proyecto: 'Puente Sur',
                partida: 'Acero de Refuerzo',
                categoria: 'Materiales',
                presupuestado: 2100000,
                real: 2350000,
                desviacion: 250000,
                porcentaje: 11.9,
                causa: 'Incremento en precio del acero'
            },
            {
                proyecto: 'Puente Sur',
                partida: 'Pavimento',
                categoria: 'Materiales',
                presupuestado: 890000,
                real: 820000,
                desviacion: -70000,
                porcentaje: -7.9,
                causa: 'Optimización de mezcla asfáltica'
            },
            
            // Parque Industrial (5 registros)
            {
                proyecto: 'Parque Industrial',
                partida: 'Nivelación',
                categoria: 'Maquinaria',
                presupuestado: 980000,
                real: 850000,
                desviacion: -130000,
                porcentaje: -13.3,
                causa: 'Mayor eficiencia de equipos'
            },
            {
                proyecto: 'Parque Industrial',
                partida: 'Red de agua',
                categoria: 'Subcontratos',
                presupuestado: 1200000,
                real: 1280000,
                desviacion: 80000,
                porcentaje: 6.7,
                causa: 'Materiales adicionales'
            },
            {
                proyecto: 'Parque Industrial',
                partida: 'Pavimentos',
                categoria: 'Materiales',
                presupuestado: 2150000,
                real: 1980000,
                desviacion: -170000,
                porcentaje: -7.9,
                causa: 'Menor espesor requerido'
            },
            {
                proyecto: 'Parque Industrial',
                partida: 'Naves - Estructura',
                categoria: 'Acero',
                presupuestado: 3450000,
                real: 3620000,
                desviacion: 170000,
                porcentaje: 4.9,
                causa: 'Ajustes por normativa sísmica'
            },
            {
                proyecto: 'Parque Industrial',
                partida: 'Oficinas',
                categoria: 'Acabados',
                presupuestado: 980000,
                real: 890000,
                desviacion: -90000,
                porcentaje: -9.2,
                causa: 'Simplificación de acabados'
            },
            
            // Hospital Regional (6 registros)
            {
                proyecto: 'Hospital Regional',
                partida: 'Instalación eléctrica',
                categoria: 'Subcontratos',
                presupuestado: 2450000,
                real: 2850000,
                desviacion: 400000,
                porcentaje: 16.3,
                causa: 'Cambios en diseño'
            },
            {
                proyecto: 'Hospital Regional',
                partida: 'Acabados',
                categoria: 'Materiales',
                presupuestado: 1850000,
                real: 2100000,
                desviacion: 250000,
                porcentaje: 13.5,
                causa: 'Especificaciones de mayor calidad'
            },
            {
                proyecto: 'Hospital Regional',
                partida: 'Cimentación',
                categoria: 'Concreto',
                presupuestado: 3200000,
                real: 3850000,
                desviacion: 650000,
                porcentaje: 20.3,
                causa: 'Problemas de suelo - pilotes más profundos'
            },
            {
                proyecto: 'Hospital Regional',
                partida: 'Equipamiento Médico',
                categoria: 'Subcontratos',
                presupuestado: 5600000,
                real: 5950000,
                desviacion: 350000,
                porcentaje: 6.3,
                causa: 'Actualización de equipos'
            },
            {
                proyecto: 'Hospital Regional',
                partida: 'Gases Medicinales',
                categoria: 'Instalaciones',
                presupuestado: 980000,
                real: 1250000,
                desviacion: 270000,
                porcentaje: 27.6,
                causa: 'Normativa más estricta'
            },
            {
                proyecto: 'Hospital Regional',
                partida: 'Aire Acondicionado',
                categoria: 'Equipos',
                presupuestado: 1750000,
                real: 1920000,
                desviacion: 170000,
                porcentaje: 9.7,
                causa: 'Mayor capacidad requerida'
            },
            
            // Planta de Tratamiento (5 registros)
            {
                proyecto: 'Planta de Tratamiento',
                partida: 'Obra Civil',
                categoria: 'Concreto',
                presupuestado: 2850000,
                real: 3120000,
                desviacion: 270000,
                porcentaje: 9.5,
                causa: 'Mayor volumen de concreto'
            },
            {
                proyecto: 'Planta de Tratamiento',
                partida: 'Equipos de Bombeo',
                categoria: 'Maquinaria',
                presupuestado: 1750000,
                real: 1980000,
                desviacion: 230000,
                porcentaje: 13.1,
                causa: 'Equipos de mayor eficiencia'
            },
            {
                proyecto: 'Planta de Tratamiento',
                partida: 'Tuberías',
                categoria: 'Materiales',
                presupuestado: 1450000,
                real: 1280000,
                desviacion: -170000,
                porcentaje: -11.7,
                causa: 'Optimización de diámetros'
            },
            {
                proyecto: 'Planta de Tratamiento',
                partida: 'Sistema Eléctrico',
                categoria: 'Instalaciones',
                presupuestado: 890000,
                real: 1020000,
                desviacion: 130000,
                porcentaje: 14.6,
                causa: 'Mayor automatización'
            },
            {
                proyecto: 'Planta de Tratamiento',
                partida: 'Pruebas y Puesta en Marcha',
                categoria: 'Servicios',
                presupuestado: 450000,
                real: 580000,
                desviacion: 130000,
                porcentaje: 28.9,
                causa: 'Más pruebas requeridas'
            },
            
            // Urbanización Los Álamos (5 registros)
            {
                proyecto: 'Urbanización Los Álamos',
                partida: 'Red de Agua Potable',
                categoria: 'Materiales',
                presupuestado: 1850000,
                real: 1620000,
                desviacion: -230000,
                porcentaje: -12.4,
                causa: 'Mejores precios de proveedores'
            },
            {
                proyecto: 'Urbanización Los Álamos',
                partida: 'Red de Alcantarillado',
                categoria: 'Materiales',
                presupuestado: 2100000,
                real: 1950000,
                desviacion: -150000,
                porcentaje: -7.1,
                causa: 'Optimización de trazado'
            },
            {
                proyecto: 'Urbanización Los Álamos',
                partida: 'Pavimentación',
                categoria: 'Materiales',
                presupuestado: 3250000,
                real: 3120000,
                desviacion: -130000,
                porcentaje: -4.0,
                causa: 'Menor espesor autorizado'
            },
            {
                proyecto: 'Urbanización Los Álamos',
                partida: 'Alumbrado Público',
                categoria: 'Instalaciones',
                presupuestado: 980000,
                real: 1050000,
                desviacion: 70000,
                porcentaje: 7.1,
                causa: 'Luminarias LED de mayor calidad'
            },
            {
                proyecto: 'Urbanización Los Álamos',
                partida: 'Áreas Verdes',
                categoria: 'Paisajismo',
                presupuestado: 750000,
                real: 620000,
                desviacion: -130000,
                porcentaje: -17.3,
                causa: 'Reducción de áreas verdes'
            }
        ];
        
        // Datos de ejemplo para Desviaciones en Tiempo - MÁS DATOS FICTICIOS
        const datosTiempo = [
            // Torre Norte (5 registros)
            {
                proyecto: 'Torre Norte',
                actividad: 'Cimentación',
                fecha_plan: '2026-02-15',
                fecha_real: '2026-02-25',
                desviacion: 10,
                impacto: 'Alto',
                causa: 'Problemas con el suelo'
            },
            {
                proyecto: 'Torre Norte',
                actividad: 'Estructura - Nivel 1',
                fecha_plan: '2026-03-10',
                fecha_real: '2026-03-15',
                desviacion: 5,
                impacto: 'Medio',
                causa: 'Retraso en entrega de acero'
            },
            {
                proyecto: 'Torre Norte',
                actividad: 'Estructura - Nivel 2',
                fecha_plan: '2026-03-25',
                fecha_real: '2026-03-28',
                desviacion: 3,
                impacto: 'Bajo',
                causa: 'Ajustes en programación'
            },
            {
                proyecto: 'Torre Norte',
                actividad: 'Instalaciones Eléctricas',
                fecha_plan: '2026-04-15',
                fecha_real: '2026-04-20',
                desviacion: 5,
                impacto: 'Medio',
                causa: 'Coordinación de gremios'
            },
            {
                proyecto: 'Torre Norte',
                actividad: 'Fachada',
                fecha_plan: '2026-05-01',
                fecha_real: '2026-04-28',
                desviacion: -3,
                impacto: 'Bajo',
                causa: 'Adelanto por buen clima'
            },
            
            // Puente Sur (4 registros)
            {
                proyecto: 'Puente Sur',
                actividad: 'Pilotaje',
                fecha_plan: '2026-02-28',
                fecha_real: '2026-03-15',
                desviacion: 15,
                impacto: 'Alto',
                causa: 'Condiciones geotécnicas adversas'
            },
            {
                proyecto: 'Puente Sur',
                actividad: 'Montaje de trabes',
                fecha_plan: '2026-03-20',
                fecha_real: '2026-03-25',
                desviacion: 5,
                impacto: 'Medio',
                causa: 'Problemas logísticos'
            },
            {
                proyecto: 'Puente Sur',
                actividad: 'Colocación de losa',
                fecha_plan: '2026-04-01',
                fecha_real: '2026-04-10',
                desviacion: 9,
                impacto: 'Medio',
                causa: 'Retraso acumulado'
            },
            {
                proyecto: 'Puente Sur',
                actividad: 'Acabados',
                fecha_plan: '2026-04-20',
                fecha_real: '2026-04-18',
                desviacion: -2,
                impacto: 'Bajo',
                causa: 'Optimización de trabajos'
            },
            
            // Parque Industrial (4 registros)
            {
                proyecto: 'Parque Industrial',
                actividad: 'Nivelación',
                fecha_plan: '2026-02-10',
                fecha_real: '2026-02-05',
                desviacion: -5,
                impacto: 'Bajo',
                causa: 'Se adelantó por buen clima'
            },
            {
                proyecto: 'Parque Industrial',
                actividad: 'Cimentación',
                fecha_plan: '2026-03-01',
                fecha_real: '2026-02-28',
                desviacion: -1,
                impacto: 'Bajo',
                causa: 'Buena productividad'
            },
            {
                proyecto: 'Parque Industrial',
                actividad: 'Estructura Metálica',
                fecha_plan: '2026-03-20',
                fecha_real: '2026-03-25',
                desviacion: 5,
                impacto: 'Medio',
                causa: 'Retraso en fabricación'
            },
            {
                proyecto: 'Parque Industrial',
                actividad: 'Cubiertas',
                fecha_plan: '2026-04-10',
                fecha_real: '2026-04-12',
                desviacion: 2,
                impacto: 'Bajo',
                causa: 'Condiciones climáticas'
            },
            
            // Hospital Regional (5 registros)
            {
                proyecto: 'Hospital Regional',
                actividad: 'Cimentación',
                fecha_plan: '2026-01-15',
                fecha_real: '2026-02-05',
                desviacion: 21,
                impacto: 'Alto',
                causa: 'Problemas con el estudio de suelo'
            },
            {
                proyecto: 'Hospital Regional',
                actividad: 'Estructura',
                fecha_plan: '2026-02-15',
                fecha_real: '2026-03-10',
                desviacion: 23,
                impacto: 'Alto',
                causa: 'Retraso acumulado de cimentación'
            },
            {
                proyecto: 'Hospital Regional',
                actividad: 'Instalaciones',
                fecha_plan: '2026-03-20',
                fecha_real: '2026-04-05',
                desviacion: 16,
                impacto: 'Alto',
                causa: 'Complejidad técnica'
            },
            {
                proyecto: 'Hospital Regional',
                actividad: 'Acabados',
                fecha_plan: '2026-04-15',
                fecha_real: '2026-04-20',
                desviacion: 5,
                impacto: 'Medio',
                causa: 'Ajustes en especificaciones'
            },
            {
                proyecto: 'Hospital Regional',
                actividad: 'Equipamiento',
                fecha_plan: '2026-05-01',
                fecha_real: '2026-05-15',
                desviacion: 14,
                impacto: 'Alto',
                causa: 'Retraso en importación'
            },
            
            // Planta de Tratamiento (4 registros)
            {
                proyecto: 'Planta de Tratamiento',
                actividad: 'Obra Civil',
                fecha_plan: '2026-02-01',
                fecha_real: '2026-02-15',
                desviacion: 14,
                impacto: 'Alto',
                causa: 'Condiciones climáticas'
            },
            {
                proyecto: 'Planta de Tratamiento',
                actividad: 'Instalación de Equipos',
                fecha_plan: '2026-03-10',
                fecha_real: '2026-03-18',
                desviacion: 8,
                impacto: 'Medio',
                causa: 'Retraso en fabricación'
            },
            {
                proyecto: 'Planta de Tratamiento',
                actividad: 'Conexiones Hidráulicas',
                fecha_plan: '2026-03-25',
                fecha_real: '2026-03-28',
                desviacion: 3,
                impacto: 'Bajo',
                causa: 'Ajustes menores'
            },
            {
                proyecto: 'Planta de Tratamiento',
                actividad: 'Pruebas',
                fecha_plan: '2026-04-15',
                fecha_real: '2026-04-20',
                desviacion: 5,
                impacto: 'Medio',
                causa: 'Más pruebas requeridas'
            },
            
            // Urbanización Los Álamos (4 registros)
            {
                proyecto: 'Urbanización Los Álamos',
                actividad: 'Red de Agua',
                fecha_plan: '2026-02-10',
                fecha_real: '2026-02-05',
                desviacion: -5,
                impacto: 'Bajo',
                causa: 'Avance por buen clima'
            },
            {
                proyecto: 'Urbanización Los Álamos',
                actividad: 'Red de Alcantarillado',
                fecha_plan: '2026-02-20',
                fecha_real: '2026-02-18',
                desviacion: -2,
                impacto: 'Bajo',
                causa: 'Buena productividad'
            },
            {
                proyecto: 'Urbanización Los Álamos',
                actividad: 'Pavimentación',
                fecha_plan: '2026-03-15',
                fecha_real: '2026-03-20',
                desviacion: 5,
                impacto: 'Medio',
                causa: 'Lluvias'
            },
            {
                proyecto: 'Urbanización Los Álamos',
                actividad: 'Áreas Verdes',
                fecha_plan: '2026-04-01',
                fecha_real: '2026-03-28',
                desviacion: -3,
                impacto: 'Bajo',
                causa: 'Adelanto por condiciones óptimas'
            }
        ];
        
        datosOriginalesCostos = [...datosCostos];
        datosOriginalesTiempo = [...datosTiempo];
        
        // Función para formatear moneda
        function formatCurrency(amount) {
            return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        
        // Función para formatear fecha
        function formatDate(dateString) {
            if (!dateString || dateString === '-') return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX');
        }
        
        // Función para obtener clase de badge según desviación
        function getDesviacionBadgeClass(desviacion) {
            if (desviacion > 0) return 'badge-negativa';
            if (desviacion < 0) return 'badge-positiva';
            return 'badge-neutra';
        }
        
        // Función para obtener clase de badge según impacto
        function getImpactoBadgeClass(impacto) {
            switch(impacto) {
                case 'Alto': return 'badge-alto';
                case 'Medio': return 'badge-medio';
                case 'Bajo': return 'badge-bajo';
                default: return 'badge-medio';
            }
        }
        
        // Función para cargar datos en tabla de costos
        function cargarTablaCostos(datos) {
            const tablaBody = document.getElementById('tablaBodyCostos');
            if (!tablaBody) return;
            
            tablaBody.innerHTML = '';
            
            if (datos.length === 0) {
                document.getElementById('sinDatosMensaje').style.display = 'block';
                document.getElementById('tablaContainerCostos').style.display = 'none';
                return;
            }
            
            document.getElementById('sinDatosMensaje').style.display = 'none';
            document.getElementById('tablaContainerCostos').style.display = 'block';
            
            const pageData = datos.slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage);
            
            pageData.forEach(item => {
                const row = document.createElement('tr');
                let badgeClass = getDesviacionBadgeClass(item.desviacion);
                
                row.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.proyecto}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.partida}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.categoria}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${formatCurrency(item.presupuestado)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${formatCurrency(item.real)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: ${item.desviacion > 0 ? '#dc3545' : '#28a745'};">${item.desviacion > 0 ? '+' : ''}${formatCurrency(item.desviacion)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;"><span class="badge-desviacion ${badgeClass}">${item.desviacion > 0 ? '+' : ''}${item.porcentaje}%</span></td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.causa}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetalle('${item.proyecto} - ${item.partida}')"></i>
                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer;"></i>
                        </div>
                    </td>
                `;
                
                tablaBody.appendChild(row);
            });
            
            // Actualizar totales
            let totalPresupuesto = 0, totalReal = 0, totalDesviacion = 0;
            datos.forEach(item => {
                totalPresupuesto += item.presupuestado;
                totalReal += item.real;
                totalDesviacion += item.desviacion;
            });
            
            document.getElementById('totalPresupuesto').textContent = formatCurrency(totalPresupuesto);
            document.getElementById('totalReal').textContent = formatCurrency(totalReal);
            document.getElementById('totalDesviacion').textContent = (totalDesviacion > 0 ? '+' : '') + formatCurrency(totalDesviacion);
            
            let promedioPorcentaje = totalPresupuesto > 0 ? (totalDesviacion / totalPresupuesto * 100) : 0;
            document.getElementById('promDesviacion').textContent = (promedioPorcentaje > 0 ? '+' : '') + promedioPorcentaje.toFixed(1) + '%';
            
            document.getElementById('paginacionInfo').textContent = `Mostrando 1-${Math.min(rowsPerPage, datos.length)} de ${datos.length} registros`;
        }
        
        // Función para cargar datos en tabla de tiempo
        function cargarTablaTiempo(datos) {
            const tablaBody = document.getElementById('tablaBodyTiempo');
            if (!tablaBody) return;
            
            tablaBody.innerHTML = '';
            
            if (datos.length === 0) {
                document.getElementById('sinDatosMensaje').style.display = 'block';
                document.getElementById('tablaContainerTiempo').style.display = 'none';
                return;
            }
            
            document.getElementById('sinDatosMensaje').style.display = 'none';
            document.getElementById('tablaContainerTiempo').style.display = 'block';
            
            const pageData = datos.slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage);
            
            pageData.forEach(item => {
                const row = document.createElement('tr');
                let badgeClass = getDesviacionBadgeClass(item.desviacion);
                let impactoBadge = getImpactoBadgeClass(item.impacto);
                
                row.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.proyecto}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.actividad}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">${formatDate(item.fecha_plan)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">${formatDate(item.fecha_real)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: ${item.desviacion > 0 ? '#dc3545' : '#28a745'};">${item.desviacion > 0 ? '+' : ''}${item.desviacion} días</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;"><span class="badge-impacto ${impactoBadge}">${item.impacto}</span></td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.causa}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetalle('${item.proyecto} - ${item.actividad}')"></i>
                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer;"></i>
                        </div>
                    </td>
                `;
                
                tablaBody.appendChild(row);
            });
            
            document.getElementById('paginacionInfo').textContent = `Mostrando 1-${Math.min(rowsPerPage, datos.length)} de ${datos.length} registros`;
        }
        
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
                
                // Recargar datos según la vista
                if (index === 0) {
                    // Resumen - no necesita recarga
                } else if (index === 1) {
                    cargarTablaCostos(datosOriginalesCostos);
                } else if (index === 2) {
                    cargarTablaTiempo(datosOriginalesTiempo);
                }
            });
        });
        
        // Botones
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            alert('Exportando a Excel...');
        });
        
        document.getElementById('btnReporte')?.addEventListener('click', function() {
            alert('Generando reporte de desviaciones...');
        });
        
        document.getElementById('btnCrearFiltro')?.addEventListener('click', function() {
            alert('Crear filtro - Funcionalidad en desarrollo');
        });
        
        // Modal
        window.verDetalle = function(concepto) {
            document.getElementById('modalVerDetalle').style.display = 'flex';
            document.body.style.overflow = 'hidden';
            
            // Aquí podrías cargar datos específicos según el concepto
            document.getElementById('detalleConcepto').textContent = concepto;
        };
        
        window.editarDesviacion = function() {
            alert('Editar desviación - Funcionalidad en desarrollo');
        };
        
        function cerrarModalDetalle() {
            document.getElementById('modalVerDetalle').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        window.cerrarModalDetalle = cerrarModalDetalle;
        
        document.getElementById('btnCerrarDetalle')?.addEventListener('click', cerrarModalDetalle);
        
        window.addEventListener('click', function(event) {
            if (event.target === document.getElementById('modalVerDetalle')) {
                cerrarModalDetalle();
            }
        });
        
        // Cargar datos iniciales
        cargarTablaCostos(datosOriginalesCostos);
        cargarTablaTiempo(datosOriginalesTiempo);
    });
</script>
@endsection