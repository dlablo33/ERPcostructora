@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Propuestas y Cotizaciones -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Propuestas y Cotizaciones
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE KPI's PRINCIPALES -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Cotizaciones Activas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Cotizaciones Activas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">48</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Monto Total Cotizado -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Monto Cotizado</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">$142.6M</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Tasa de Éxito -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Tasa de Éxito</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">32.5%</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Tiempo Promedio Respuesta -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Tiempo Respuesta</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">4.2 días</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                    <!-- Selectores -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <select id="selectorEstado" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                                <option value="">Todos los estados</option>
                                <option value="borrador" selected>Borrador</option>
                                <option value="enviada">Enviada</option>
                                <option value="negociacion">En Negociación</option>
                                <option value="ganada">Ganada</option>
                                <option value="perdida">Perdida</option>
                                <option value="vencida">Vencida</option>
                            </select>
                        </div>

                        <div>
                            <select id="selectorProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 200px;">
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
                            <input type="date" id="fechaFin" value="2026-03-31" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <!-- Botón Nueva Cotización -->
                                             <!-- Botón Exportar -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                    title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <!-- Botón Reporte -->
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
                            <input type="text" id="buscador" placeholder="Buscar cotización, cliente..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- GRÁFICOS PRINCIPALES -->
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Evolución de Cotizaciones -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                            <i class="fas fa-chart-line"></i> Evolución de Cotizaciones - 1er Trimestre 2026
                        </h4>
                        <div style="height: 200px; display: flex; align-items: flex-end; gap: 20px; justify-content: center;">
                            <div style="text-align: center; width: 70px;">
                                <div style="height: 80px; background: linear-gradient(to top, #083CAE, #2378e1); width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="height: 30px; background: linear-gradient(to top, #28a745, #34ce57); width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0; margin-top: -30px;"></div>
                                <div style="margin-top: 5px; font-weight: 600;">Ene</div>
                                <div style="font-size: 11px;">12/8</div>
                            </div>
                            <div style="text-align: center; width: 70px;">
                                <div style="height: 100px; background: linear-gradient(to top, #083CAE, #2378e1); width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="height: 45px; background: linear-gradient(to top, #28a745, #34ce57); width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0; margin-top: -45px;"></div>
                                <div style="margin-top: 5px; font-weight: 600;">Feb</div>
                                <div style="font-size: 11px;">15/12</div>
                            </div>
                            <div style="text-align: center; width: 70px;">
                                <div style="height: 120px; background: linear-gradient(to top, #083CAE, #2378e1); width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="height: 60px; background: linear-gradient(to top, #28a745, #34ce57); width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0; margin-top: -60px;"></div>
                                <div style="margin-top: 5px; font-weight: 600;">Mar</div>
                                <div style="font-size: 11px;">21/14</div>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: center; gap: 30px; margin-top: 20px;">
                            <span style="font-size: 12px; display: flex; align-items: center;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #083CAE; margin-right: 5px;"></span> Enviadas</span>
                            <span style="font-size: 12px; display: flex; align-items: center;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #28a745; margin-right: 5px;"></span> Ganadas</span>
                        </div>
                    </div>

                    <!-- Cotizaciones por Estado -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                            <i class="fas fa-chart-pie"></i> Cotizaciones por Estado
                        </h4>
                        <div style="margin-top: 20px;">
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;"><span style="display: inline-block; width: 10px; height: 10px; background-color: #ffc107; border-radius: 50%; margin-right: 5px;"></span> Borrador</span>
                                    <span style="font-size: 13px; font-weight: 600;">12</span>
                                </div>
                                <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 25%; height: 6px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;"><span style="display: inline-block; width: 10px; height: 10px; background-color: #17a2b8; border-radius: 50%; margin-right: 5px;"></span> Enviada</span>
                                    <span style="font-size: 13px; font-weight: 600;">18</span>
                                </div>
                                <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 38%; height: 6px; background-color: #17a2b8; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;"><span style="display: inline-block; width: 10px; height: 10px; background-color: #fd7e14; border-radius: 50%; margin-right: 5px;"></span> Negociación</span>
                                    <span style="font-size: 13px; font-weight: 600;">8</span>
                                </div>
                                <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 17%; height: 6px; background-color: #fd7e14; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;"><span style="display: inline-block; width: 10px; height: 10px; background-color: #28a745; border-radius: 50%; margin-right: 5px;"></span> Ganada</span>
                                    <span style="font-size: 13px; font-weight: 600;">34</span>
                                </div>
                                <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 71%; height: 6px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;"><span style="display: inline-block; width: 10px; height: 10px; background-color: #dc3545; border-radius: 50%; margin-right: 5px;"></span> Perdida</span>
                                    <span style="font-size: 13px; font-weight: 600;">16</span>
                                </div>
                                <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 33%; height: 6px; background-color: #dc3545; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEGUNDA FILA DE GRÁFICOS -->
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Top Proyectos Cotizados -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-chart-bar"></i> Proyectos más Cotizados
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Torre Norte</span>
                                    <span style="font-size: 13px; font-weight: 600;">18 cotiz.</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 100%; height: 8px; background-color: #083CAE; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Hospital Regional</span>
                                    <span style="font-size: 13px; font-weight: 600;">15 cotiz.</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 83%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Parque Industrial</span>
                                    <span style="font-size: 13px; font-weight: 600;">12 cotiz.</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 67%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Puente Sur</span>
                                    <span style="font-size: 13px; font-weight: 600;">8 cotiz.</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 44%; height: 8px; background-color: #dc3545; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Razones de Pérdida -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-times-circle"></i> Razones de Pérdida
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <div style="display: flex; justify-content: space-between;">
                                <span style="font-size: 13px;">Precio</span>
                                <span style="font-size: 13px; font-weight: 600;">42%</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="font-size: 13px;">Plazos de entrega</span>
                                <span style="font-size: 13px; font-weight: 600;">28%</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="font-size: 13px;">Especificaciones</span>
                                <span style="font-size: 13px; font-weight: 600;">18%</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="font-size: 13px;">Competencia</span>
                                <span style="font-size: 13px; font-weight: 600;">12%</span>
                            </div>
                            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #dee2e6;">
                                <div style="display: flex; justify-content: space-between; color: #dc3545;">
                                    <span style="font-size: 13px; font-weight: 600;">Total Perdidas</span>
                                    <span style="font-size: 13px; font-weight: 600;">16</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Próximos a Vencer -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-clock"></i> Próximos a Vencer
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="background-color: #dc3545; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">!</span>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">COT-2026-089</div>
                                    <div style="font-size: 11px; color: #6c757d;">Torre Norte • Vence mañana</div>
                                </div>
                                <div style="font-weight: 600; color: #dc3545;">$2.8M</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="background-color: #ffc107; color: #856404; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">!</span>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">COT-2026-092</div>
                                    <div style="font-size: 11px; color: #6c757d;">Hospital • Vence en 3 días</div>
                                </div>
                                <div style="font-weight: 600; color: #ffc107;">$4.2M</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="background-color: #ffc107; color: #856404; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">!</span>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">COT-2026-095</div>
                                    <div style="font-size: 11px; color: #6c757d;">Parque Industrial • Vence en 5 días</div>
                                </div>
                                <div style="font-weight: 600; color: #ffc107;">$1.5M</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TABLA DE COTIZACIONES -->
                <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 12px; max-height: 400px; overflow-y: auto; margin-top: 20px;">
                    <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="padding: 12px 8px; text-align: left;">Folio</th>
                                <th style="padding: 12px 8px; text-align: left;">Fecha</th>
                                <th style="padding: 12px 8px; text-align: left;">Cliente</th>
                                <th style="padding: 12px 8px; text-align: left;">Proyecto</th>
                                <th style="padding: 12px 8px; text-align: right;">Monto</th>
                                <th style="padding: 12px 8px; text-align: center;">Vigencia</th>
                                <th style="padding: 12px 8px; text-align: center;">Estado</th>
                                <th style="padding: 12px 8px; text-align: center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 10px 8px; font-weight: 600;">COT-2026-095</td>
                                <td style="padding: 10px 8px;">2026-03-15</td>
                                <td style="padding: 10px 8px;">Inmobiliaria del Norte</td>
                                <td style="padding: 10px 8px;">Torre Norte</td>
                                <td style="padding: 10px 8px; text-align: right;">$2,850,000</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-04-15</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Enviada</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 3px;"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; font-weight: 600;">COT-2026-092</td>
                                <td style="padding: 10px 8px;">2026-03-14</td>
                                <td style="padding: 10px 8px;">Gobierno Regional</td>
                                <td style="padding: 10px 8px;">Hospital Regional</td>
                                <td style="padding: 10px 8px; text-align: right;">$4,200,000</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-04-14</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #fd7e14; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Negociación</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 3px;"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; font-weight: 600;">COT-2026-089</td>
                                <td style="padding: 10px 8px;">2026-03-12</td>
                                <td style="padding: 10px 8px;">Empresas López</td>
                                <td style="padding: 10px 8px;">Parque Industrial</td>
                                <td style="padding: 10px 8px; text-align: right;">$1,500,000</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-04-12</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Borrador</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 3px;"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; font-weight: 600;">COT-2026-086</td>
                                <td style="padding: 10px 8px;">2026-03-10</td>
                                <td style="padding: 10px 8px;">Constructora ABC</td>
                                <td style="padding: 10px 8px;">Torre Norte</td>
                                <td style="padding: 10px 8px; text-align: right;">$950,000</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-04-10</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Ganada</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 3px;"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; font-weight: 600;">COT-2026-082</td>
                                <td style="padding: 10px 8px;">2026-03-08</td>
                                <td style="padding: 10px 8px;">Desarrollos del Sur</td>
                                <td style="padding: 10px 8px;">Puente Sur</td>
                                <td style="padding: 10px 8px; text-align: right;">$3,200,000</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-04-08</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Perdida</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 3px;"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; font-weight: 600;">COT-2026-078</td>
                                <td style="padding: 10px 8px;">2026-03-05</td>
                                <td style="padding: 10px 8px;">Grupo Industrial</td>
                                <td style="padding: 10px 8px;">Parque Industrial</td>
                                <td style="padding: 10px 8px; text-align: right;">$1,850,000</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-04-05</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Enviada</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 3px;"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <div style="color: #6c757d; font-size: 13px;">
                        Mostrando 1-6 de 48 cotizaciones
                    </div>
                    <div style="display: flex; gap: 5px;">
                        <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">Anterior</button>
                        <button style="padding: 5px 10px; border: 1px solid #083CAE; background-color: #083CAE; color: white; border-radius: 4px; cursor: pointer;">1</button>
                        <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">2</button>
                        <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">3</button>
                        <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">4</button>
                        <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">5</button>
                        <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">Siguiente</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
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
    }
    
    .table td {
        white-space: nowrap;
        font-size: 12px;
        color: #000000 !important;
    }
    
    /* Estilo para las filas alternadas */
    tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }
    
    tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    
    tbody tr:hover {
        background-color: #e0e0e0;
    }
    
    /* Estilo para los iconos de acción */
    td i {
        transition: transform 0.2s;
        cursor: pointer;
    }
    
    td i:hover {
        transform: scale(1.2);
    }
    
    /* Badges de estado */
    .badge-estado {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 2fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
        
        div[style*="grid-template-columns: 1fr 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
        
        .custom-card {
            min-width: 100% !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Propuestas y Cotizaciones cargado');
        
        // Botones principales
        document.getElementById('btnNueva')?.addEventListener('click', function() {
            alert('Crear nueva cotización');
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            alert('Exportando a Excel...');
        });
        
        document.getElementById('btnReporte')?.addEventListener('click', function() {
            alert('Generando reporte de cotizaciones...');
        });
        
        // Acciones de tabla
        document.querySelectorAll('.fa-eye').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Ver detalle de cotización');
            });
        });
        
        document.querySelectorAll('.fa-edit').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Editar cotización');
            });
        });
        
        document.querySelectorAll('.fa-file-pdf').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Generando PDF de la cotización...');
            });
        });
        
        // Filtros
        const estadoSelect = document.getElementById('selectorEstado');
        if (estadoSelect) {
            estadoSelect.addEventListener('change', function() {
                console.log('Filtrando por estado:', this.value);
            });
        }
        
        const proyectoSelect = document.getElementById('selectorProyecto');
        if (proyectoSelect) {
            proyectoSelect.addEventListener('change', function() {
                console.log('Filtrando por proyecto:', this.value);
            });
        }
        
        // Buscador
        const buscador = document.getElementById('buscador');
        if (buscador) {
            buscador.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    alert('Buscando: ' + this.value);
                }
            });
        }
    });
</script>
@endsection