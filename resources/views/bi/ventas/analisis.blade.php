@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Análisis de Ventas - Construcción -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Análisis de Ventas 
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE KPI's PRINCIPALES -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Ventas Totales -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Ventas Totales</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">$78.4M</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Unidades Vendidas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Unidades Vendidas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">124</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Ticket Promedio -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Ticket Promedio</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">$632K</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Tasa de Conversión -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Tasa Conversión</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">23.8%</div>
                        </div>
                    </div>
                </div> 

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                    <!-- Selectores -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <select id="selectorPeriodo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                                <option value="mes">Este mes</option>
                                <option value="trimestre" selected>Este trimestre</option>
                                <option value="semestre">Este semestre</option>
                                <option value="año">Este año</option>
                                <option value="personalizado">Personalizado</option>
                            </select>
                        </div>

                        <div>
                            <select id="selectorProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 200px;">
                                <option value="">Todos los proyectos</option>
                                <option value="torre" selected> Torre Norte Corporativa</option>
                                <option value="parque"> Parque Industrial Norte</option>
                                <option value="hospital"> Hospital Regional</option>
                                <option value="urbanizacion"> Urbanización Los Álamos</option>
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

                    <!-- Botones -->
                    <div style="display: flex; align-items: center; gap: 10px;">
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
                            <input type="text" id="buscador" placeholder="Buscar cliente, proyecto..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- GRÁFICOS PRINCIPALES -->
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Gráfico de Ventas por Mes -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                            <i class="fas fa-chart-line"></i> Evolución de Ventas - 1er Trimestre 2026
                        </h4>
                        <div style="height: 200px; display: flex; align-items: flex-end; gap: 30px; justify-content: center;">
                            <div style="text-align: center; width: 80px;">
                                <div style="height: 100px; background: linear-gradient(to top, #083CAE, #2378e1); width: 50px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-weight: 600;">Enero</div>
                                <div style="font-size: 12px; color: #083CAE;">$24.5M</div>
                            </div>
                            <div style="text-align: center; width: 80px;">
                                <div style="height: 140px; background: linear-gradient(to top, #083CAE, #2378e1); width: 50px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-weight: 600;">Febrero</div>
                                <div style="font-size: 12px; color: #083CAE;">$26.8M</div>
                            </div>
                            <div style="text-align: center; width: 80px;">
                                <div style="height: 160px; background: linear-gradient(to top, #28a745, #34ce57); width: 50px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-weight: 600;">Marzo</div>
                                <div style="font-size: 12px; color: #28a745;">$27.1M</div>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: center; gap: 30px; margin-top: 20px;">
                            <span style="font-size: 12px; display: flex; align-items: center;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #083CAE; margin-right: 5px;"></span> Proyectado</span>
                            <span style="font-size: 12px; display: flex; align-items: center;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #28a745; margin-right: 5px;"></span> Real</span>
                        </div>
                    </div>

                    <!-- Ventas por Tipo de Inmueble -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                            <i class="fas fa-chart-pie"></i> Ventas por Tipo
                        </h4>
                        <div style="margin-top: 20px;">
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;"><i class="fas fa-building" style="color: #083CAE;"></i> Oficinas</span>
                                    <span style="font-size: 13px; font-weight: 600;">42%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 42%; height: 8px; background-color: #083CAE; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;"><i class="fas fa-warehouse" style="color: #28a745;"></i> Naves Industriales</span>
                                    <span style="font-size: 13px; font-weight: 600;">28%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 28%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;"><i class="fas fa-home" style="color: #ffc107;"></i> Vivienda</span>
                                    <span style="font-size: 13px; font-weight: 600;">18%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 18%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;"><i class="fas fa-hospital" style="color: #dc3545;"></i> Equipamiento</span>
                                    <span style="font-size: 13px; font-weight: 600;">12%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 12%; height: 8px; background-color: #dc3545; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEGUNDA FILA DE GRÁFICOS -->
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Top Clientes -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-crown"></i> Top Clientes
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="background-color: #083CAE; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">1</span>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Inmobiliaria del Norte</div>
                                    <div style="font-size: 11px; color: #6c757d;">3 unidades • Torre Norte</div>
                                </div>
                                <div style="font-weight: 600; color: #28a745;">$4.2M</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="background-color: #6c757d; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">2</span>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Gobierno Regional</div>
                                    <div style="font-size: 11px; color: #6c757d;">2 unidades • Hospital Regional</div>
                                </div>
                                <div style="font-weight: 600; color: #28a745;">$3.8M</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="background-color: #cd7f32; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">3</span>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Empresas López</div>
                                    <div style="font-size: 11px; color: #6c757d;">2 naves • Parque Industrial</div>
                                </div>
                                <div style="font-weight: 600; color: #28a745;">$2.5M</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="background-color: #e9ecef; color: #495057; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">4</span>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Constructora ABC</div>
                                    <div style="font-size: 11px; color: #6c757d;">1 nave + ofna • Mixto</div>
                                </div>
                                <div style="font-weight: 600; color: #28a745;">$1.9M</div>
                            </div>
                        </div>
                    </div>

                    <!-- Ventas por Proyecto -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-chart-bar"></i> Ventas por Proyecto
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Torre Norte</span>
                                    <span style="font-size: 13px; font-weight: 600;">$32.5M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 78%; height: 8px; background-color: #083CAE; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Hospital Regional</span>
                                    <span style="font-size: 13px; font-weight: 600;">$28.4M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 68%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Parque Industrial</span>
                                    <span style="font-size: 13px; font-weight: 600;">$12.8M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 45%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Urb. Los Álamos</span>
                                    <span style="font-size: 13px; font-weight: 600;">$4.7M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 25%; height: 8px; background-color: #dc3545; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etapas de Venta -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-filter"></i> Embudo de Ventas
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Prospectos</span>
                                    <span style="font-size: 13px; font-weight: 600;">245</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 100%; height: 8px; background-color: #083CAE; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Cotizaciones</span>
                                    <span style="font-size: 13px; font-weight: 600;">98</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 40%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Negociación</span>
                                    <span style="font-size: 13px; font-weight: 600;">45</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 18%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Cerradas</span>
                                    <span style="font-size: 13px; font-weight: 600;">124</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 51%; height: 8px; background-color: #dc3545; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TABLA DE VENTAS DETALLADA -->
                <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 12px; max-height: 400px; overflow-y: auto; margin-top: 20px;">
                    <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="padding: 12px 8px; text-align: left;">Fecha</th>
                                <th style="padding: 12px 8px; text-align: left;">Cliente</th>
                                <th style="padding: 12px 8px; text-align: left;">Proyecto</th>
                                <th style="padding: 12px 8px; text-align: left;">Tipo</th>
                                <th style="padding: 12px 8px; text-align: center;">Unidades</th>
                                <th style="padding: 12px 8px; text-align: right;">Monto</th>
                                <th style="padding: 12px 8px; text-align: center;">Estado</th>
                                <th style="padding: 12px 8px; text-align: center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 10px 8px;">2026-03-15</td>
                                <td style="padding: 10px 8px;">Inmobiliaria del Norte</td>
                                <td style="padding: 10px 8px;">Torre Norte</td>
                                <td style="padding: 10px 8px;">Oficinas</td>
                                <td style="padding: 10px 8px; text-align: center;">3</td>
                                <td style="padding: 10px 8px; text-align: right;">$4,250,000</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Escriturado</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px;">2026-03-14</td>
                                <td style="padding: 10px 8px;">Gobierno Regional</td>
                                <td style="padding: 10px 8px;">Hospital Regional</td>
                                <td style="padding: 10px 8px;">Equipamiento</td>
                                <td style="padding: 10px 8px; text-align: center;">2</td>
                                <td style="padding: 10px 8px; text-align: right;">$3,800,000</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Apartado</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px;">2026-03-12</td>
                                <td style="padding: 10px 8px;">Empresas López</td>
                                <td style="padding: 10px 8px;">Parque Industrial</td>
                                <td style="padding: 10px 8px;">Naves</td>
                                <td style="padding: 10px 8px; text-align: center;">2</td>
                                <td style="padding: 10px 8px; text-align: right;">$2,500,000</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Escriturado</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px;">2026-03-10</td>
                                <td style="padding: 10px 8px;">Constructora ABC</td>
                                <td style="padding: 10px 8px;">Urb. Los Álamos</td>
                                <td style="padding: 10px 8px;">Vivienda</td>
                                <td style="padding: 10px 8px; text-align: center;">5</td>
                                <td style="padding: 10px 8px; text-align: right;">$1,450,000</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Contrato</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px;">2026-03-08</td>
                                <td style="padding: 10px 8px;">Desarrollos del Sur</td>
                                <td style="padding: 10px 8px;">Torre Norte</td>
                                <td style="padding: 10px 8px;">Oficinas</td>
                                <td style="padding: 10px 8px; text-align: center;">1</td>
                                <td style="padding: 10px 8px; text-align: right;">$1,850,000</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Escriturado</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px;">2026-03-05</td>
                                <td style="padding: 10px 8px;">Grupo Industrial</td>
                                <td style="padding: 10px 8px;">Parque Industrial</td>
                                <td style="padding: 10px 8px;">Nave</td>
                                <td style="padding: 10px 8px; text-align: center;">1</td>
                                <td style="padding: 10px 8px; text-align: right;">$1,200,000</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Apartado</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <div style="color: #6c757d; font-size: 13px;">
                        Mostrando 1-6 de 48 registros
                    </div>
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
        console.log('Análisis de Ventas - Construcción cargado');
        
        // Botones de exportación
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            alert('Exportando a Excel...');
        });
        
        document.getElementById('btnReporte')?.addEventListener('click', function() {
            alert('Generando reporte de ventas...');
        });
        
        // Selector de período
        const periodoSelect = document.getElementById('selectorPeriodo');
        if (periodoSelect) {
            periodoSelect.addEventListener('change', function() {
                if (this.value === 'personalizado') {
                    alert('Seleccione fechas personalizadas');
                }
            });
        }
        
        // Iconos de acción
        document.querySelectorAll('.fa-eye').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Ver detalle de venta');
            });
        });
        
        document.querySelectorAll('.fa-file-pdf').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Generando PDF de la venta...');
            });
        });
    });
</script>
@endsection