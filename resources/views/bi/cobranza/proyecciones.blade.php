@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Proyección de Flujo -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Proyección de Flujo
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE KPI's PRINCIPALES -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Flujo Proyectado -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px; cursor: pointer;" onclick="verDetalleFlujo('Flujo Proyectado', '$156.8M', 'Próximos 12 meses')">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Flujo Proyectado</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">$156.8M</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Ingresos Proyectados -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px; cursor: pointer;" onclick="verDetalleFlujo('Ingresos Proyectados', '$98.3M', 'Estimaciones y anticipos')">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Ingresos Proyectados</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">$98.3M</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Egresos Proyectados -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px; cursor: pointer;" onclick="verDetalleFlujo('Egresos Proyectados', '$42.5M', 'Proveedores y nómina')">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Egresos Proyectados</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">$42.5M</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Saldo Neto Proyectado -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px; cursor: pointer;" onclick="verDetalleFlujo('Saldo Neto Proyectado', '$55.8M', 'Flujo positivo')">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Saldo Neto Proyectado</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">$55.8M</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas (solo filtros) -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                    <!-- Selectores de filtro -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <select id="selectorPeriodo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                                <option value="3meses">Próximos 3 meses</option>
                                <option value="6meses" selected>Próximos 6 meses</option>
                                <option value="12meses">Próximos 12 meses</option>
                                <option value="personalizado">Personalizado</option>
                            </select>
                        </div>

                        <div>
                            <select id="selectorProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 200px;">
                                <option value="">Todos los proyectos</option>
                                <option value="torre" selected> Torre Norte Corporativa</option>
                                <option value="puente"> Puente Vehicular Sur</option>
                                <option value="parque"> Parque Industrial Norte</option>
                                <option value="hospital"> Hospital Regional</option>
                                <option value="planta"> Planta de Tratamiento</option>
                                <option value="urbanizacion"> Urbanización Los Álamos</option>
                            </select>
                        </div>

                        <div>
                            <select id="selectorTipo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                                <option value="">Todos los conceptos</option>
                                <option value="ingresos" selected> Ingresos</option>
                                <option value="egresos"> Egresos</option>
                                <option value="neto"> Flujo Neto</option>
                            </select>
                        </div>

                        <!-- Date Inicio -->
                        <div>
                            <input type="date" id="fechaInicio" value="2026-04-01" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Date Fin -->
                        <div>
                            <input type="date" id="fechaFin" value="2026-09-30" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>
                    </div>

                    <!-- Buscador -->
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                        <input type="text" id="buscador" placeholder="Buscar proyecto, concepto..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 250px;">
                    </div>
                </div>

                <!-- GRÁFICO PRINCIPAL DE FLUJO -->
                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; margin-bottom: 20px; cursor: pointer;" onclick="verDetalleGrafico('Proyección de Flujo - Próximos 6 Meses')">
                    <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                        <i class="fas fa-chart-line"></i> Proyección de Flujo - Próximos 6 Meses
                        <i class="fas fa-search-plus" style="float: right; font-size: 14px; color: #6c757d;"></i>
                    </h4>
                    <div style="height: 250px; position: relative; margin-top: 20px;">
                        <!-- Líneas de ingresos, egresos y neto -->
                        <svg width="100%" height="200" viewBox="0 0 600 200">
                            <!-- Ingresos (verde) -->
                            <polyline points="0,180 100,150 200,120 300,100 400,80 500,70 600,60" 
                                      style="fill:none;stroke:#28a745;stroke-width:3" />
                            <!-- Egresos (rojo) -->
                            <polyline points="0,180 100,160 200,140 300,130 400,120 500,110 600,100" 
                                      style="fill:none;stroke:#dc3545;stroke-width:3" />
                            <!-- Neto (azul) -->
                            <polyline points="0,180 100,140 200,100 300,70 400,50 500,40 600,30" 
                                      style="fill:none;stroke:#083CAE;stroke-width:3" />
                            
                            <!-- Ejes -->
                            <line x1="0" y1="200" x2="600" y2="200" style="stroke:#dee2e6;stroke-width:1" />
                            <line x1="0" y1="0" x2="0" y2="200" style="stroke:#dee2e6;stroke-width:1" />
                            
                            <!-- Etiquetas de meses -->
                            <text x="30" y="220" font-size="10" fill="#6c757d">Abr</text>
                            <text x="130" y="220" font-size="10" fill="#6c757d">May</text>
                            <text x="230" y="220" font-size="10" fill="#6c757d">Jun</text>
                            <text x="330" y="220" font-size="10" fill="#6c757d">Jul</text>
                            <text x="430" y="220" font-size="10" fill="#6c757d">Ago</text>
                            <text x="530" y="220" font-size="10" fill="#6c757d">Sep</text>
                        </svg>
                        
                        <div style="display: flex; justify-content: center; gap: 40px; margin-top: 30px;">
                            <span style="font-size: 12px; display: flex; align-items: center;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #28a745; margin-right: 5px;"></span> Ingresos</span>
                            <span style="font-size: 12px; display: flex; align-items: center;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #dc3545; margin-right: 5px;"></span> Egresos</span>
                            <span style="font-size: 12px; display: flex; align-items: center;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #083CAE; margin-right: 5px;"></span> Flujo Neto</span>
                        </div>
                    </div>
                </div>

                <!-- SEGUNDA FILA DE GRÁFICOS -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Flujo por Proyecto -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px; cursor: pointer;" onclick="verDetalleGrafico('Flujo Proyectado por Proyecto')">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-chart-bar"></i> Flujo Proyectado por Proyecto
                            <i class="fas fa-search-plus" style="float: right; font-size: 12px; color: #6c757d;"></i>
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Torre Norte</span>
                                    <span style="font-size: 13px; font-weight: 600;">$45.2M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 100%; height: 8px; background: linear-gradient(90deg, #28a745 70%, #dc3545 30%); border-radius: 4px;"></div>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 10px; color: #6c757d; margin-top: 2px;">
                                    <span> $32.5M</span>
                                    <span> $12.7M</span>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Hospital Regional</span>
                                    <span style="font-size: 13px; font-weight: 600;">$38.6M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 85%; height: 8px; background: linear-gradient(90deg, #28a745 65%, #dc3545 35%); border-radius: 4px;"></div>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 10px; color: #6c757d; margin-top: 2px;">
                                    <span> $28.4M</span>
                                    <span> $10.2M</span>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Parque Industrial</span>
                                    <span style="font-size: 13px; font-weight: 600;">$24.8M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 55%; height: 8px; background: linear-gradient(90deg, #28a745 60%, #dc3545 40%); border-radius: 4px;"></div>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 10px; color: #6c757d; margin-top: 2px;">
                                    <span> $18.2M</span>
                                    <span> $6.6M</span>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Puente Sur</span>
                                    <span style="font-size: 13px; font-weight: 600;">$18.5M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 41%; height: 8px; background: linear-gradient(90deg, #28a745 55%, #dc3545 45%); border-radius: 4px;"></div>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 10px; color: #6c757d; margin-top: 2px;">
                                    <span> $12.8M</span>
                                    <span> $5.7M</span>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Urb. Los Álamos</span>
                                    <span style="font-size: 13px; font-weight: 600;">$12.5M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 28%; height: 8px; background: linear-gradient(90deg, #28a745 50%, #dc3545 50%); border-radius: 4px;"></div>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 10px; color: #6c757d; margin-top: 2px;">
                                    <span> $6.2M</span>
                                    <span> $6.3M</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Composición de Ingresos/Egresos -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px; cursor: pointer;" onclick="verDetalleGrafico('Composición de Flujo')">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-chart-pie"></i> Composición de Flujo
                            <i class="fas fa-search-plus" style="float: right; font-size: 12px; color: #6c757d;"></i>
                        </h4>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <!-- Ingresos -->
                            <div>
                                <h5 style="color: #28a745; margin: 0 0 10px 0; font-size: 14px;"> Ingresos $98.3M</h5>
                                <div style="margin-bottom: 8px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 2px;">
                                        <span style="font-size: 12px;">Estimaciones</span>
                                        <span style="font-size: 12px; font-weight: 600;">$58.2M (59%)</span>
                                    </div>
                                    <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                        <div style="width: 59%; height: 6px; background-color: #28a745; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 8px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 2px;">
                                        <span style="font-size: 12px;">Anticipos</span>
                                        <span style="font-size: 12px; font-weight: 600;">$22.5M (23%)</span>
                                    </div>
                                    <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                        <div style="width: 23%; height: 6px; background-color: #28a745; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 8px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 2px;">
                                        <span style="font-size: 12px;">Obras Adicionales</span>
                                        <span style="font-size: 12px; font-weight: 600;">$12.6M (13%)</span>
                                    </div>
                                    <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                        <div style="width: 13%; height: 6px; background-color: #28a745; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 8px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 2px;">
                                        <span style="font-size: 12px;">Otros</span>
                                        <span style="font-size: 12px; font-weight: 600;">$5.0M (5%)</span>
                                    </div>
                                    <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                        <div style="width: 5%; height: 6px; background-color: #28a745; border-radius: 4px;"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Egresos -->
                            <div>
                                <h5 style="color: #dc3545; margin: 0 0 10px 0; font-size: 14px;"> Egresos $42.5M</h5>
                                <div style="margin-bottom: 8px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 2px;">
                                        <span style="font-size: 12px;">Proveedores</span>
                                        <span style="font-size: 12px; font-weight: 600;">$24.5M (58%)</span>
                                    </div>
                                    <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                        <div style="width: 58%; height: 6px; background-color: #dc3545; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 8px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 2px;">
                                        <span style="font-size: 12px;">Nómina</span>
                                        <span style="font-size: 12px; font-weight: 600;">$12.8M (30%)</span>
                                    </div>
                                    <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                        <div style="width: 30%; height: 6px; background-color: #dc3545; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 8px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 2px;">
                                        <span style="font-size: 12px;">Maquinaria</span>
                                        <span style="font-size: 12px; font-weight: 600;">$3.2M (7%)</span>
                                    </div>
                                    <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                        <div style="width: 7%; height: 6px; background-color: #dc3545; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 8px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 2px;">
                                        <span style="font-size: 12px;">Gastos Grales.</span>
                                        <span style="font-size: 12px; font-weight: 600;">$2.0M (5%)</span>
                                    </div>
                                    <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                        <div style="width: 5%; height: 6px; background-color: #dc3545; border-radius: 4px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div style="margin-top: 15px; padding-top: 10px; border-top: 1px solid #dee2e6;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 14px; font-weight: 600;">Flujo Neto</span>
                                <span style="font-size: 18px; font-weight: 700; color: #28a745;">$55.8M</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TERCERA FILA - Hitos de Flujo -->
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Próximos Ingresos Importantes -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px;">
                        <h4 style="color: #28a745; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-arrow-down"></i> Próximos Ingresos Importantes
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" onclick="verDetalleConcepto('Estimación #9 - Torre Norte', event)">
                                <div style="background-color: #28a745; width: 8px; height: 8px; border-radius: 50%;"></div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Estimación #9 - Torre Norte</div>
                                    <div style="font-size: 11px; color: #6c757d;">15 Abr 2026 • Confirmado</div>
                                </div>
                                <div style="font-weight: 600; color: #28a745;">$3.2M</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" onclick="verDetalleConcepto('Anticipo - Hospital', event)">
                                <div style="background-color: #28a745; width: 8px; height: 8px; border-radius: 50%;"></div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Anticipo - Hospital Regional</div>
                                    <div style="font-size: 11px; color: #6c757d;">30 Abr 2026 • Programado</div>
                                </div>
                                <div style="font-weight: 600; color: #28a745;">$2.5M</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" onclick="verDetalleConcepto('Estimación #5 - Parque', event)">
                                <div style="background-color: #ffc107; width: 8px; height: 8px; border-radius: 50%;"></div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Estimación #5 - Parque Industrial</div>
                                    <div style="font-size: 11px; color: #6c757d;">20 May 2026 • Pendiente</div>
                                </div>
                                <div style="font-weight: 600; color: #ffc107;">$1.8M</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" onclick="verDetalleConcepto('Obra Adicional #3 - Puente', event)">
                                <div style="background-color: #ffc107; width: 8px; height: 8px; border-radius: 50%;"></div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Obra Adicional #3 - Puente Sur</div>
                                    <div style="font-size: 11px; color: #6c757d;">5 Jun 2026 • Pendiente</div>
                                </div>
                                <div style="font-weight: 600; color: #ffc107;">$950K</div>
                            </div>
                        </div>
                    </div>

                    <!-- Próximos Egresos Importantes -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px;">
                        <h4 style="color: #dc3545; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-arrow-up"></i> Próximos Egresos Importantes
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" onclick="verDetalleConcepto('Pago Proveedor Aceros', event)">
                                <div style="background-color: #dc3545; width: 8px; height: 8px; border-radius: 50%;"></div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Proveedor Aceros del Norte</div>
                                    <div style="font-size: 11px; color: #6c757d;">10 Abr 2026 • Programado</div>
                                </div>
                                <div style="font-weight: 600; color: #dc3545;">$1.5M</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" onclick="verDetalleConcepto('Nómina Quincenal', event)">
                                <div style="background-color: #dc3545; width: 8px; height: 8px; border-radius: 50%;"></div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Nómina Quincenal</div>
                                    <div style="font-size: 11px; color: #6c757d;">15 Abr 2026 • Recurrente</div>
                                </div>
                                <div style="font-weight: 600; color: #dc3545;">$2.1M</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" onclick="verDetalleConcepto('Pago Subcontratista', event)">
                                <div style="background-color: #dc3545; width: 8px; height: 8px; border-radius: 50%;"></div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Subcontratista Eléctrico</div>
                                    <div style="font-size: 11px; color: #6c757d;">20 Abr 2026 • Programado</div>
                                </div>
                                <div style="font-weight: 600; color: #dc3545;">$890K</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" onclick="verDetalleConcepto('Renta Maquinaria', event)">
                                <div style="background-color: #ffc107; width: 8px; height: 8px; border-radius: 50%;"></div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Renta de Maquinaria</div>
                                    <div style="font-size: 11px; color: #6c757d;">30 Abr 2026 • Recurrente</div>
                                </div>
                                <div style="font-weight: 600; color: #ffc107;">$450K</div>
                            </div>
                        </div>
                    </div>

                    <!-- Alertas de Flujo -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px;">
                        <h4 style="color: #ffc107; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-exclamation-triangle"></i> Alertas de Flujo
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px; background-color: #fff3cd; padding: 8px; border-radius: 6px;">
                                <i class="fas fa-exclamation-circle" style="color: #ffc107;"></i>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Bajo flujo en mayo</div>
                                    <div style="font-size: 11px;">Se espera déficit de $1.2M</div>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; background-color: #f8d7da; padding: 8px; border-radius: 6px;">
                                <i class="fas fa-exclamation-circle" style="color: #dc3545;"></i>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Pago atrasado - Cliente</div>
                                    <div style="font-size: 11px;">Gobierno Regional - 15 días</div>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-check-circle" style="color: #28a745;"></i>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Flujo positivo en abril</div>
                                    <div style="font-size: 11px;">Superávit proyectado $2.8M</div>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-check-circle" style="color: #28a745;"></i>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Flujo positivo en junio</div>
                                    <div style="font-size: 11px;">Superávit proyectado $1.5M</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!-- TABLA DE PROYECCIÓN DETALLADA -->
<div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 12px; max-height: 400px; overflow-y: auto; margin-top: 20px;">
    <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
        <thead style="position: sticky; top: 0; background-color: #2378e1; color: white;">
            <tr>
                <th style="padding: 12px 8px; text-align: left;">Período</th>
                <th style="padding: 12px 8px; text-align: left;">Proyecto</th>
                <th style="padding: 12px 8px; text-align: left;">Concepto</th>
                <th style="padding: 12px 8px; text-align: right;">Ingresos</th>
                <th style="padding: 12px 8px; text-align: right;">Egresos</th>
                <th style="padding: 12px 8px; text-align: right;">Flujo Neto</th>
                <th style="padding: 12px 8px; text-align: center;">Detalle</th>
            </tr>
        </thead>
        <tbody>
            <tr style="cursor: pointer;" onclick="verDetalleConcepto('Proyección Abril - Torre Norte')">
                <td style="padding: 10px 8px;">Abril 2026</td>
                <td style="padding: 10px 8px;">Torre Norte</td>
                <td style="padding: 10px 8px;">Estimación #9</td>
                <td style="padding: 10px 8px; text-align: right; color: #28a745;">$3,200,000</td>
                <td style="padding: 10px 8px; text-align: right; color: #dc3545;">$1,200,000</td>
                <td style="padding: 10px 8px; text-align: right; font-weight: 600; color: #28a745;">$2,000,000</td>
                <td style="padding: 10px 8px; text-align: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetalleConcepto('Proyección Abril - Torre Norte', event)"></i>
                </td>
            </tr>
            <tr style="background-color: #f8f9fa; cursor: pointer;" onclick="verDetalleConcepto('Proyección Abril - Hospital')">
                <td style="padding: 10px 8px;">Abril 2026</td>
                <td style="padding: 10px 8px;">Hospital Regional</td>
                <td style="padding: 10px 8px;">Anticipo</td>
                <td style="padding: 10px 8px; text-align: right; color: #28a745;">$2,500,000</td>
                <td style="padding: 10px 8px; text-align: right; color: #dc3545;">$850,000</td>
                <td style="padding: 10px 8px; text-align: right; font-weight: 600; color: #28a745;">$1,650,000</td>
                <td style="padding: 10px 8px; text-align: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetalleConcepto('Proyección Abril - Hospital', event)"></i>
                </td>
            </tr>
            <tr style="cursor: pointer;" onclick="verDetalleConcepto('Proyección Abril - Parque')">
                <td style="padding: 10px 8px;">Abril 2026</td>
                <td style="padding: 10px 8px;">Parque Industrial</td>
                <td style="padding: 10px 8px;">Estimación #4</td>
                <td style="padding: 10px 8px; text-align: right; color: #28a745;">$1,200,000</td>
                <td style="padding: 10px 8px; text-align: right; color: #dc3545;">$450,000</td>
                <td style="padding: 10px 8px; text-align: right; font-weight: 600; color: #28a745;">$750,000</td>
                <td style="padding: 10px 8px; text-align: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetalleConcepto('Proyección Abril - Parque', event)"></i>
                </td>
            </tr>
            <tr style="background-color: #f8f9fa; cursor: pointer;" onclick="verDetalleConcepto('Proyección Mayo - Torre Norte')">
                <td style="padding: 10px 8px;">Mayo 2026</td>
                <td style="padding: 10px 8px;">Torre Norte</td>
                <td style="padding: 10px 8px;">Estimación #10</td>
                <td style="padding: 10px 8px; text-align: right; color: #28a745;">$2,800,000</td>
                <td style="padding: 10px 8px; text-align: right; color: #dc3545;">$1,100,000</td>
                <td style="padding: 10px 8px; text-align: right; font-weight: 600; color: #28a745;">$1,700,000</td>
                <td style="padding: 10px 8px; text-align: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetalleConcepto('Proyección Mayo - Torre Norte', event)"></i>
                </td>
            </tr>
            <tr style="cursor: pointer;" onclick="verDetalleConcepto('Proyección Mayo - Hospital')">
                <td style="padding: 10px 8px;">Mayo 2026</td>
                <td style="padding: 10px 8px;">Hospital Regional</td>
                <td style="padding: 10px 8px;">Estimación #6</td>
                <td style="padding: 10px 8px; text-align: right; color: #28a745;">$2,100,000</td>
                <td style="padding: 10px 8px; text-align: right; color: #dc3545;">$780,000</td>
                <td style="padding: 10px 8px; text-align: right; font-weight: 600; color: #28a745;">$1,320,000</td>
                <td style="padding: 10px 8px; text-align: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetalleConcepto('Proyección Mayo - Hospital', event)"></i>
                </td>
            </tr>
            <tr style="background-color: #f8f9fa; cursor: pointer;" onclick="verDetalleConcepto('Proyección Mayo - Parque')">
                <td style="padding: 10px 8px;">Mayo 2026</td>
                <td style="padding: 10px 8px;">Parque Industrial</td>
                <td style="padding: 10px 8px;">Estimación #5</td>
                <td style="padding: 10px 8px; text-align: right; color: #28a745;">$1,800,000</td>
                <td style="padding: 10px 8px; text-align: right; color: #dc3545;">$620,000</td>
                <td style="padding: 10px 8px; text-align: right; font-weight: 600; color: #28a745;">$1,180,000</td>
                <td style="padding: 10px 8px; text-align: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetalleConcepto('Proyección Mayo - Parque', event)"></i>
                </td>
            </tr>
        </tbody>
    </table>
</div>

                <!-- Totales y Paginación -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <div style="display: flex; gap: 30px;">
                        <div>
                            <span style="color: #6c757d; font-size: 13px;">Total Ingresos:</span>
                            <span style="font-weight: 600; font-size: 16px; margin-left: 10px; color: #28a745;">$98.3M</span>
                        </div>
                        <div>
                            <span style="color: #6c757d; font-size: 13px;">Total Egresos:</span>
                            <span style="font-weight: 600; font-size: 16px; margin-left: 10px; color: #dc3545;">$42.5M</span>
                        </div>
                        <div>
                            <span style="color: #6c757d; font-size: 13px;">Flujo Neto:</span>
                            <span style="font-weight: 600; font-size: 16px; margin-left: 10px; color: #28a745;">$55.8M</span>
                        </div>
                    </div>
                    <div style="color: #6c757d; font-size: 13px;">
                        Mostrando 1-6 de 24 proyecciones
                    </div>
                </div>

                <!-- Paginación -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 10px;">
                    <div style="display: flex; gap: 5px;">
                        <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">Anterior</button>
                        <button style="padding: 5px 10px; border: 1px solid #083CAE; background-color: #083CAE; color: white; border-radius: 4px; cursor: pointer;">1</button>
                        <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">2</button>
                        <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">3</button>
                        <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">4</button>
                        <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">Siguiente</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Ver Detalle -->
<div id="modalVerDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 80vh; overflow-y: auto;">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-info-circle"></i> <span id="modalTitulo">Detalle de Proyección</span>
            </h3>
            <button id="btnCerrarModal" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="padding: 20px;" id="modalContenido">
            <!-- Contenido dinámico -->
        </div>
    </div>
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
    
    /* Cursor pointer para filas clickeables */
    tbody tr {
        cursor: pointer;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 1fr"] {
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
        console.log('Proyección de Flujo cargado - Solo vista');
        
        // Filtros (solo para visualización)
        const periodoSelect = document.getElementById('selectorPeriodo');
        if (periodoSelect) {
            periodoSelect.addEventListener('change', function() {
                console.log('Filtrando por período:', this.value);
            });
        }
        
        const proyectoSelect = document.getElementById('selectorProyecto');
        if (proyectoSelect) {
            proyectoSelect.addEventListener('change', function() {
                console.log('Filtrando por proyecto:', this.value);
            });
        }
        
        const tipoSelect = document.getElementById('selectorTipo');
        if (tipoSelect) {
            tipoSelect.addEventListener('change', function() {
                console.log('Filtrando por tipo:', this.value);
            });
        }
        
        // Buscador
        const buscador = document.getElementById('buscador');
        if (buscador) {
            buscador.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    console.log('Buscando: ' + this.value);
                }
            });
        }
        
        // Cerrar modal
        const btnCerrar = document.getElementById('btnCerrarModal');
        const modal = document.getElementById('modalVerDetalle');
        
        if (btnCerrar) {
            btnCerrar.addEventListener('click', function() {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            });
        }
        
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
    });
    
    // Función para ver detalle de flujo (KPIs)
    function verDetalleFlujo(titulo, valor, descripcion) {
        const modal = document.getElementById('modalVerDetalle');
        const modalTitulo = document.getElementById('modalTitulo');
        const modalContenido = document.getElementById('modalContenido');
        
        modalTitulo.textContent = titulo;
        
        modalContenido.innerHTML = `
            <div style="text-align: center; margin-bottom: 20px;">
                <div style="font-size: 48px; font-weight: bold; color: #083CAE;">${valor}</div>
                <div style="font-size: 16px; color: #6c757d; margin-top: 10px;">${descripcion}</div>
            </div>
            <div style="border-top: 1px solid #dee2e6; padding-top: 20px;">
                <h4 style="color: #083CAE; margin-bottom: 15px;">Distribución por Período</h4>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span>Abril 2026</span>
                        <span style="font-weight: 600;">$28.5M</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Mayo 2026</span>
                        <span style="font-weight: 600;">$26.2M</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Junio 2026</span>
                        <span style="font-weight: 600;">$24.8M</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Julio 2026</span>
                        <span style="font-weight: 600;">$22.5M</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Agosto 2026</span>
                        <span style="font-weight: 600;">$20.1M</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Septiembre 2026</span>
                        <span style="font-weight: 600;">$18.7M</span>
                    </div>
                </div>
            </div>
        `;
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    
    // Función para ver detalle de gráfico
    function verDetalleGrafico(titulo) {
        const modal = document.getElementById('modalVerDetalle');
        const modalTitulo = document.getElementById('modalTitulo');
        const modalContenido = document.getElementById('modalContenido');
        
        modalTitulo.textContent = titulo;
        
        modalContenido.innerHTML = `
            <div style="margin-bottom: 20px;">
                <p style="color: #6c757d;">Vista detallada del gráfico</p>
                <div style="height: 250px; position: relative; margin: 20px 0;">
                    <svg width="100%" height="200" viewBox="0 0 600 200">
                        <polyline points="0,180 100,150 200,120 300,100 400,80 500,70 600,60" 
                                  style="fill:none;stroke:#28a745;stroke-width:3" />
                        <polyline points="0,180 100,160 200,140 300,130 400,120 500,110 600,100" 
                                  style="fill:none;stroke:#dc3545;stroke-width:3" />
                        <polyline points="0,180 100,140 200,100 300,70 400,50 500,40 600,30" 
                                  style="fill:none;stroke:#083CAE;stroke-width:3" />
                        <line x1="0" y1="200" x2="600" y2="200" style="stroke:#dee2e6;stroke-width:1" />
                        <line x1="0" y1="0" x2="0" y2="200" style="stroke:#dee2e6;stroke-width:1" />
                        <text x="30" y="220" font-size="10" fill="#6c757d">Abr</text>
                        <text x="130" y="220" font-size="10" fill="#6c757d">May</text>
                        <text x="230" y="220" font-size="10" fill="#6c757d">Jun</text>
                        <text x="330" y="220" font-size="10" fill="#6c757d">Jul</text>
                        <text x="430" y="220" font-size="10" fill="#6c757d">Ago</text>
                        <text x="530" y="220" font-size="10" fill="#6c757d">Sep</text>
                    </svg>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 30px;">
                    <div>
                        <h5 style="font-size: 14px; margin-bottom: 10px;">Valores por Mes</h5>
                        <table style="width: 100%; font-size: 12px;">
                            <tr><td>Abril</td><td>💰 $8.5M</td><td>📤 $3.2M</td><td>⚖️ $5.3M</td></tr>
                            <tr><td>Mayo</td><td>💰 $7.8M</td><td>📤 $3.5M</td><td>⚖️ $4.3M</td></tr>
                            <tr><td>Junio</td><td>💰 $7.2M</td><td>📤 $3.8M</td><td>⚖️ $3.4M</td></tr>
                            <tr><td>Julio</td><td>💰 $6.5M</td><td>📤 $4.0M</td><td>⚖️ $2.5M</td></tr>
                            <tr><td>Agosto</td><td>💰 $5.8M</td><td>📤 $4.2M</td><td>⚖️ $1.6M</td></tr>
                            <tr><td>Septiembre</td><td>💰 $5.2M</td><td>📤 $4.5M</td><td>⚖️ $0.7M</td></tr>
                        </table>
                    </div>
                    <div>
                        <h5 style="font-size: 14px; margin-bottom: 10px;">Resumen</h5>
                        <div style="background-color: #f8f9fa; padding: 10px; border-radius: 8px;">
                            <div style="margin-bottom: 8px;">
                                <span style="color: #6c757d;">Total Ingresos:</span>
                                <span style="float: right; font-weight: 600; color: #28a745;">$41.0M</span>
                            </div>
                            <div style="margin-bottom: 8px;">
                                <span style="color: #6c757d;">Total Egresos:</span>
                                <span style="float: right; font-weight: 600; color: #dc3545;">$23.2M</span>
                            </div>
                            <div style="border-top: 1px solid #dee2e6; padding-top: 8px;">
                                <span style="color: #6c757d;">Flujo Neto:</span>
                                <span style="float: right; font-weight: 700; color: #28a745;">$17.8M</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    
    // Función para ver detalle de concepto
    function verDetalleConcepto(concepto, event) {
        if (event) {
            event.stopPropagation();
        }
        
        const modal = document.getElementById('modalVerDetalle');
        const modalTitulo = document.getElementById('modalTitulo');
        const modalContenido = document.getElementById('modalContenido');
        
        modalTitulo.textContent = concepto;
        
        modalContenido.innerHTML = `
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Período</div>
                    <div style="font-size: 16px; font-weight: 600;">Abril 2026</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Proyecto</div>
                    <div style="font-size: 16px; font-weight: 600;">Torre Norte Corporativa</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Concepto</div>
                    <div style="font-size: 14px;">Estimación #9</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Probabilidad</div>
                    <div><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">95%</span></div>
                </div>
            </div>
            
            <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Ingresos Proyectados</div>
                        <div style="font-size: 20px; font-weight: 700; color: #28a745;">$3,200,000</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Egresos Proyectados</div>
                        <div style="font-size: 20px; font-weight: 700; color: #dc3545;">$1,200,000</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Flujo Neto</div>
                        <div style="font-size: 24px; font-weight: 700; color: #28a745;">$2,000,000</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Estatus</div>
                        <div><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Confirmado</span></div>
                    </div>
                </div>
            </div>
            
            <div style="margin-bottom: 15px;">
                <div style="color: #6c757d; font-size: 12px;">Descripción</div>
                <div style="font-size: 14px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px;">
                    Estimación de avance #9 correspondiente a obra civil e instalaciones de la Torre Norte. Incluye:
                    • Estructura metálica - 35%
                    • Instalaciones eléctricas - 25%
                    • Acabados - 20%
                    • Mano de obra - 20%
                </div>
            </div>
            
            <div style="margin-bottom: 15px;">
                <div style="color: #6c757d; font-size: 12px;">Factores de Riesgo</div>
                <ul style="margin: 5px 0 0 0; padding-left: 20px;">
                    <li>Pendiente aprobación de residente de obra</li>
                    <li>Cliente con buen historial de pago</li>
                    <li>Sin retrasos en el cronograma</li>
                </ul>
            </div>
            
            <div style="border-top: 1px solid #dee2e6; padding-top: 15px; margin-top: 15px;">
                <div style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Documentos Relacionados</div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <span style="background-color: #e9ecef; padding: 8px 12px; border-radius: 4px; font-size: 12px;">
                        <i class="fas fa-file-pdf" style="color: #dc3545;"></i> estimacion-9.pdf
                    </span>
                    <span style="background-color: #e9ecef; padding: 8px 12px; border-radius: 4px; font-size: 12px;">
                        <i class="fas fa-file-excel" style="color: #28a745;"></i> generador-obra.xlsx
                    </span>
                </div>
            </div>
        `;
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
</script>
@endsection