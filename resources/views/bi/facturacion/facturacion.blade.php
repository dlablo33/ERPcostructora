@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Facturación -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Facturación
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE KPI's PRINCIPALES -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Facturado del Mes -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Facturado del Mes</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">$28.6M</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Por Facturar -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Por Facturar</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">$42.3M</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Cobrado vs Vencido -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Cobrado vs Vencido</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">$18.2M</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Días Promedio Pago -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Días Promedio Pago</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">38 días</div>
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
                                <option value="pagada" selected>✅ Pagada</option>
                                <option value="pendiente">⏳ Pendiente</option>
                                <option value="vencida">⚠️ Vencida</option>
                                <option value="parcial">🔄 Pago Parcial</option>
                                <option value="cancelada">❌ Cancelada</option>
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

                        <div>
                            <select id="selectorCliente" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 200px;">
                                <option value="">Todos los clientes</option>
                                <option value="gobierno" selected>🏛️ Gobierno Regional</option>
                                <option value="inmobiliaria">🏢 Inmobiliaria del Norte</option>
                                <option value="constructora">🏗️ Constructora ABC</option>
                                <option value="empresas">🏭 Empresas López</option>
                                <option value="desarrollos">🏘️ Desarrollos del Sur</option>
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
                        <!-- Botón Nueva Factura -->
                         

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
                            <input type="text" id="buscador" placeholder="Buscar factura, cliente..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- GRÁFICOS PRINCIPALES -->
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Evolución de Facturación -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                            <i class="fas fa-chart-line"></i> Evolución de Facturación - 1er Trimestre 2026
                        </h4>
                        <div style="height: 200px; display: flex; align-items: flex-end; gap: 30px; justify-content: center;">
                            <div style="text-align: center; width: 80px;">
                                <div style="height: 100px; background: linear-gradient(to top, #083CAE, #2378e1); width: 50px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-weight: 600;">Enero</div>
                                <div style="font-size: 12px; color: #083CAE;">$22.5M</div>
                            </div>
                            <div style="text-align: center; width: 80px;">
                                <div style="height: 120px; background: linear-gradient(to top, #083CAE, #2378e1); width: 50px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-weight: 600;">Febrero</div>
                                <div style="font-size: 12px; color: #083CAE;">$26.8M</div>
                            </div>
                            <div style="text-align: center; width: 80px;">
                                <div style="height: 130px; background: linear-gradient(to top, #28a745, #34ce57); width: 50px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-weight: 600;">Marzo</div>
                                <div style="font-size: 12px; color: #28a745;">$28.6M</div>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: center; gap: 30px; margin-top: 20px;">
                            <span style="font-size: 12px; display: flex; align-items: center;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #083CAE; margin-right: 5px;"></span> Facturado</span>
                            <span style="font-size: 12px; display: flex; align-items: center;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #28a745; margin-right: 5px;"></span> Cobrado</span>
                        </div>
                    </div>

                    <!-- Facturación por Estado -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                            <i class="fas fa-chart-pie"></i> Facturación por Estado
                        </h4>
                        <div style="margin-top: 20px;">
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;"><span style="display: inline-block; width: 10px; height: 10px; background-color: #28a745; border-radius: 50%; margin-right: 5px;"></span> Pagada</span>
                                    <span style="font-size: 13px; font-weight: 600;">$42.8M</span>
                                </div>
                                <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 58%; height: 6px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;"><span style="display: inline-block; width: 10px; height: 10px; background-color: #ffc107; border-radius: 50%; margin-right: 5px;"></span> Pendiente</span>
                                    <span style="font-size: 13px; font-weight: 600;">$23.5M</span>
                                </div>
                                <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 32%; height: 6px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;"><span style="display: inline-block; width: 10px; height: 10px; background-color: #dc3545; border-radius: 50%; margin-right: 5px;"></span> Vencida</span>
                                    <span style="font-size: 13px; font-weight: 600;">$4.5M</span>
                                </div>
                                <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 6%; height: 6px; background-color: #dc3545; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;"><span style="display: inline-block; width: 10px; height: 10px; background-color: #17a2b8; border-radius: 50%; margin-right: 5px;"></span> Pago Parcial</span>
                                    <span style="font-size: 13px; font-weight: 600;">$2.8M</span>
                                </div>
                                <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 4%; height: 6px; background-color: #17a2b8; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEGUNDA FILA DE GRÁFICOS -->
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Facturación por Cliente -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-chart-bar"></i> Facturación por Cliente
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Gobierno Regional</span>
                                    <span style="font-size: 13px; font-weight: 600;">$28.5M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 100%; height: 8px; background-color: #083CAE; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Inmobiliaria del Norte</span>
                                    <span style="font-size: 13px; font-weight: 600;">$18.2M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 64%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Constructora ABC</span>
                                    <span style="font-size: 13px; font-weight: 600;">$12.8M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 45%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Empresas López</span>
                                    <span style="font-size: 13px; font-weight: 600;">$8.6M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 30%; height: 8px; background-color: #fd7e14; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Antigüedad de Cartera -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-clock"></i> Antigüedad de Cartera
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 13px;">0-30 días</span>
                                <span style="font-size: 13px; font-weight: 600; color: #28a745;">$18.5M</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 13px;">31-60 días</span>
                                <span style="font-size: 13px; font-weight: 600; color: #ffc107;">$3.8M</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 13px;">61-90 días</span>
                                <span style="font-size: 13px; font-weight: 600; color: #fd7e14;">$2.2M</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 13px;">90+ días</span>
                                <span style="font-size: 13px; font-weight: 600; color: #dc3545;">$1.8M</span>
                            </div>
                            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #dee2e6;">
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="font-size: 13px; font-weight: 600;">Total Cartera</span>
                                    <span style="font-size: 13px; font-weight: 600;">$26.3M</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Próximos Vencimientos -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-exclamation-triangle"></i> Próximos Vencimientos
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="background-color: #ffc107; color: #856404; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">!</span>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">FACT-2026-089</div>
                                    <div style="font-size: 11px; color: #6c757d;">Gobierno Regional • Vence mañana</div>
                                </div>
                                <div style="font-weight: 600; color: #ffc107;">$1.8M</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="background-color: #ffc107; color: #856404; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">!</span>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">FACT-2026-092</div>
                                    <div style="font-size: 11px; color: #6c757d;">Constructora ABC • Vence en 3 días</div>
                                </div>
                                <div style="font-weight: 600; color: #ffc107;">$950K</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="background-color: #17a2b8; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">i</span>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">FACT-2026-095</div>
                                    <div style="font-size: 11px; color: #6c757d;">Empresas López • Vence en 5 días</div>
                                </div>
                                <div style="font-weight: 600; color: #17a2b8;">$2.2M</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TABLA DE FACTURAS -->
                <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 12px; max-height: 400px; overflow-y: auto; margin-top: 20px;">
                    <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="padding: 12px 8px; text-align: left;">Folio</th>
                                <th style="padding: 12px 8px; text-align: left;">Fecha Emisión</th>
                                <th style="padding: 12px 8px; text-align: left;">Cliente</th>
                                <th style="padding: 12px 8px; text-align: left;">Proyecto</th>
                                <th style="padding: 12px 8px; text-align: right;">Monto</th>
                                <th style="padding: 12px 8px; text-align: center;">Fecha Vencimiento</th>
                                <th style="padding: 12px 8px; text-align: center;">Días</th>
                                <th style="padding: 12px 8px; text-align: center;">Estado</th>
                                <th style="padding: 12px 8px; text-align: center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 10px 8px; font-weight: 600;">FACT-2026-095</td>
                                <td style="padding: 10px 8px;">2026-03-15</td>
                                <td style="padding: 10px 8px;">Gobierno Regional</td>
                                <td style="padding: 10px 8px;">Hospital Regional</td>
                                <td style="padding: 10px 8px; text-align: right;">$2,850,000</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-04-15</td>
                                <td style="padding: 10px 8px; text-align: center;">25</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Pagada</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 3px;"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; font-weight: 600;">FACT-2026-092</td>
                                <td style="padding: 10px 8px;">2026-03-14</td>
                                <td style="padding: 10px 8px;">Constructora ABC</td>
                                <td style="padding: 10px 8px;">Parque Industrial</td>
                                <td style="padding: 10px 8px; text-align: right;">$950,000</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-04-14</td>
                                <td style="padding: 10px 8px; text-align: center;">24</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Pendiente</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 3px;"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; font-weight: 600;">FACT-2026-089</td>
                                <td style="padding: 10px 8px;">2026-03-12</td>
                                <td style="padding: 10px 8px;">Empresas López</td>
                                <td style="padding: 10px 8px;">Torre Norte</td>
                                <td style="padding: 10px 8px; text-align: right;">$1,800,000</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-04-12</td>
                                <td style="padding: 10px 8px; text-align: center;">22</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Pendiente</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 3px;"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; font-weight: 600;">FACT-2026-086</td>
                                <td style="padding: 10px 8px;">2026-03-10</td>
                                <td style="padding: 10px 8px;">Inmobiliaria del Norte</td>
                                <td style="padding: 10px 8px;">Torre Norte</td>
                                <td style="padding: 10px 8px; text-align: right;">$2,200,000</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-04-10</td>
                                <td style="padding: 10px 8px; text-align: center;">20</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Pago Parcial</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 3px;"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; font-weight: 600;">FACT-2026-082</td>
                                <td style="padding: 10px 8px;">2026-03-08</td>
                                <td style="padding: 10px 8px;">Desarrollos del Sur</td>
                                <td style="padding: 10px 8px;">Puente Sur</td>
                                <td style="padding: 10px 8px; text-align: right;">$1,200,000</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-04-08</td>
                                <td style="padding: 10px 8px; text-align: center;">18</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Pagada</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 3px;"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; font-weight: 600;">FACT-2026-078</td>
                                <td style="padding: 10px 8px;">2026-03-05</td>
                                <td style="padding: 10px 8px;">Gobierno Regional</td>
                                <td style="padding: 10px 8px;">Hospital Regional</td>
                                <td style="padding: 10px 8px; text-align: right;">$3,500,000</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-04-05</td>
                                <td style="padding: 10px 8px; text-align: center;">15</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Vencida</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 3px;"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Totales y Paginación -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <div style="display: flex; gap: 30px;">
                        <div>
                            <span style="color: #6c757d; font-size: 13px;">Total Facturado:</span>
                            <span style="font-weight: 600; font-size: 16px; margin-left: 10px;">$77.9M</span>
                        </div>
                        <div>
                            <span style="color: #6c757d; font-size: 13px;">Total Cobrado:</span>
                            <span style="font-weight: 600; font-size: 16px; margin-left: 10px; color: #28a745;">$42.8M</span>
                        </div>
                        <div>
                            <span style="color: #6c757d; font-size: 13px;">Por Cobrar:</span>
                            <span style="font-weight: 600; font-size: 16px; margin-left: 10px; color: #ffc107;">$35.1M</span>
                        </div>
                    </div>
                    <div style="color: #6c757d; font-size: 13px;">
                        Mostrando 1-6 de 48 facturas
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
        console.log('Facturación cargada');
        
        // Botones principales
        document.getElementById('btnNueva')?.addEventListener('click', function() {
            alert('Crear nueva factura');
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            alert('Exportando facturas a Excel...');
        });
        
        document.getElementById('btnReporte')?.addEventListener('click', function() {
            alert('Generando reporte de facturación...');
        });
        
        // Acciones de tabla
        document.querySelectorAll('.fa-eye').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Ver detalle de factura');
            });
        });
        
        document.querySelectorAll('.fa-file-pdf').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Generando PDF de la factura...');
            });
        });
        
        document.querySelectorAll('.fa-download').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Descargando XML de la factura...');
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
        
        const clienteSelect = document.getElementById('selectorCliente');
        if (clienteSelect) {
            clienteSelect.addEventListener('change', function() {
                console.log('Filtrando por cliente:', this.value);
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