@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Análisis de Rentabilidad -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-chart-line" style="margin-right: 10px;"></i>
                    Análisis de Rentabilidad
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE RENTABILIDAD CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Margen Promedio -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Margen Promedio</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="margenPromedio">18.5%</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Utilidad Neta -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Utilidad Neta</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="utilidadNeta">$24.8M</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: ROI -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">ROI</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="roi">22.3%</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Período Recuperación -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Recuperación</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="periodoRecuperacion">8.2 meses</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Selectores a la izquierda -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <select id="selectorPeriodo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                            <option value="mes">Este Mes</option>
                            <option value="trimestre" selected>Este Trimestre</option>
                            <option value="semestre">Este Semestre</option>
                            <option value="año">Este Año</option>
                            <option value="personalizado">Personalizado</option>
                        </select>

                        <select id="selectorProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 300px;">
                            <option value="">Todos los proyectos</option>
                            <option value="PRO-2024-001" selected>🏢 PRO-2024-001 - Torre Norte Corporativa</option>
                            <option value="PRO-2024-002">🌉 PRO-2024-002 - Puente Vehicular Sur</option>
                            <option value="PRO-2024-003">🏭 PRO-2024-003 - Parque Industrial Norte</option>
                            <option value="PRO-2024-004">🏥 PRO-2024-004 - Hospital Regional</option>
                            <option value="PRO-2024-005">💧 PRO-2024-005 - Planta de Tratamiento</option>
                            <option value="PRO-2024-006">🏘️ PRO-2024-006 - Urbanización Los Álamos</option>
                        </select>

                        <!-- Rango de fechas (oculto por defecto) -->
                        <div id="rangoFechas" style="display: none; align-items: center; gap: 5px;">
                            <input type="date" id="fechaInicio" value="2026-01-01" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <span style="color: #6c757d;">a</span>
                            <input type="date" id="fechaFin" value="2026-12-31" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                    </div>
                    
                    <!-- Grupo de botones derecho -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Botón Exportar -->
                        <div>
                            <button id="btnExportar" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;" title="Exportar reporte">
                                <i class="fas fa-download"></i> Exportar
                            </button>
                        </div>

                        <!-- Botón Actualizar -->
                        <div>
                            <button id="btnActualizar" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                                <i class="fas fa-sync-alt"></i> Actualizar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- TABS DE ANÁLISIS -->
                <div style="display: flex; gap: 2px; margin-bottom: 20px; border-bottom: 2px solid #083CAE; overflow-x: auto; white-space: nowrap;">
                    <button class="analisis-tab active" data-tab="general" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-chart-pie"></i> Rentabilidad General
                    </button>
                    <button class="analisis-tab" data-tab="proyectos" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-building"></i> Por Proyecto
                    </button>
                    <button class="analisis-tab" data-tab="categorias" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-tags"></i> Por Categoría
                    </button>
                    <button class="analisis-tab" data-tab="tendencias" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-chart-line"></i> Tendencias
                    </button>
                    <button class="analisis-tab" data-tab="comparativo" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-balance-scale"></i> Comparativo
                    </button>
                </div>

                <!-- SECCIÓN 1: RENTABILIDAD GENERAL -->
                <div id="tab-general" class="analisis-content active">
                    <!-- Gráficos de rentabilidad general -->
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 25px;">
                        <!-- Gráfico de ingresos vs costos -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-bar"></i> Ingresos vs Costos (Últimos 6 meses)
                            </h4>
                            <div style="height: 250px; display: flex; align-items: flex-end; gap: 15px; justify-content: center;">
                                <div style="text-align: center; width: 70px;">
                                    <div style="height: 180px; background-color: #28a745; width: 30px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="height: 140px; background-color: #dc3545; width: 30px; margin: 0 auto; border-radius: 4px 4px 0 0; margin-top: -140px;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Ene</div>
                                    <div style="font-size: 10px; color: #28a745;">$8.2M</div>
                                    <div style="font-size: 10px; color: #dc3545;">$6.5M</div>
                                </div>
                                <div style="text-align: center; width: 70px;">
                                    <div style="height: 200px; background-color: #28a745; width: 30px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="height: 155px; background-color: #dc3545; width: 30px; margin: 0 auto; border-radius: 4px 4px 0 0; margin-top: -155px;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Feb</div>
                                    <div style="font-size: 10px; color: #28a745;">$9.1M</div>
                                    <div style="font-size: 10px; color: #dc3545;">$7.2M</div>
                                </div>
                                <div style="text-align: center; width: 70px;">
                                    <div style="height: 220px; background-color: #28a745; width: 30px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="height: 170px; background-color: #dc3545; width: 30px; margin: 0 auto; border-radius: 4px 4px 0 0; margin-top: -170px;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Mar</div>
                                    <div style="font-size: 10px; color: #28a745;">$10.0M</div>
                                    <div style="font-size: 10px; color: #dc3545;">$7.9M</div>
                                </div>
                                <div style="text-align: center; width: 70px;">
                                    <div style="height: 240px; background-color: #28a745; width: 30px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="height: 185px; background-color: #dc3545; width: 30px; margin: 0 auto; border-radius: 4px 4px 0 0; margin-top: -185px;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Abr</div>
                                    <div style="font-size: 10px; color: #28a745;">$10.9M</div>
                                    <div style="font-size: 10px; color: #dc3545;">$8.6M</div>
                                </div>
                                <div style="text-align: center; width: 70px;">
                                    <div style="height: 210px; background-color: #28a745; width: 30px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="height: 160px; background-color: #dc3545; width: 30px; margin: 0 auto; border-radius: 4px 4px 0 0; margin-top: -160px;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">May</div>
                                    <div style="font-size: 10px; color: #28a745;">$9.5M</div>
                                    <div style="font-size: 10px; color: #dc3545;">$7.4M</div>
                                </div>
                                <div style="text-align: center; width: 70px;">
                                    <div style="height: 190px; background-color: #28a745; width: 30px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="height: 145px; background-color: #dc3545; width: 30px; margin: 0 auto; border-radius: 4px 4px 0 0; margin-top: -145px;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Jun</div>
                                    <div style="font-size: 10px; color: #28a745;">$8.6M</div>
                                    <div style="font-size: 10px; color: #dc3545;">$6.7M</div>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: center; gap: 30px; margin-top: 15px;">
                                <span style="font-size: 12px; display: flex; align-items: center;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #28a745; margin-right: 5px;"></span> Ingresos</span>
                                <span style="font-size: 12px; display: flex; align-items: center;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #dc3545; margin-right: 5px;"></span> Costos</span>
                            </div>
                        </div>

                        <!-- Tarjetas de rentabilidad -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; text-align: center;">
                                <div style="color: #6c757d; font-size: 13px; margin-bottom: 5px;">Ingresos Totales</div>
                                <div style="font-size: 28px; font-weight: 700; color: #28a745;">$134.2M</div>
                                <div style="font-size: 12px; color: #28a745; margin-top: 5px;">+12.3% vs trimestre anterior</div>
                            </div>
                            <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; text-align: center;">
                                <div style="color: #6c757d; font-size: 13px; margin-bottom: 5px;">Costos Totales</div>
                                <div style="font-size: 28px; font-weight: 700; color: #dc3545;">$109.4M</div>
                                <div style="font-size: 12px; color: #dc3545; margin-top: 5px;">+8.7% vs trimestre anterior</div>
                            </div>
                            <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; text-align: center;">
                                <div style="color: #6c757d; font-size: 13px; margin-bottom: 5px;">Utilidad Bruta</div>
                                <div style="font-size: 28px; font-weight: 700; color: #083CAE;">$24.8M</div>
                                <div style="font-size: 12px; color: #28a745; margin-top: 5px;">Margen: 18.5%</div>
                            </div>
                            <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; text-align: center;">
                                <div style="color: #6c757d; font-size: 13px; margin-bottom: 5px;">EBITDA</div>
                                <div style="font-size: 28px; font-weight: 700; color: #083CAE;">$21.3M</div>
                                <div style="font-size: 12px; color: #6c757d; margin-top: 5px;">Margen EBITDA: 15.9%</div>
                            </div>
                        </div>
                    </div>

                    <!-- Estado de Resultados Simplificado -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; margin-bottom: 25px;">
                        <div style="background-color: #f8f9fa; padding: 15px 20px; border-bottom: 2px solid #083CAE;">
                            <h5 style="margin: 0; color: #083CAE; font-size: 16px;"><i class="fas fa-file-invoice"></i> Estado de Resultados (Período Actual)</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="width: 100%; font-size: 14px; border-collapse: collapse;">
                                <tbody>
                                    <tr>
                                        <td style="padding: 12px 20px;"><strong>Ingresos Totales</strong></td>
                                        <td style="padding: 12px 20px; text-align: right;">$134,200,000</td>
                                        <td style="padding: 12px 20px; text-align: right;">100%</td>
                                    </tr>
                                    <tr style="background-color: #f8f9fa;">
                                        <td style="padding: 12px 20px; padding-left: 40px;">- Costos Directos</td>
                                        <td style="padding: 12px 20px; text-align: right;">$89,500,000</td>
                                        <td style="padding: 12px 20px; text-align: right;">66.7%</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px 20px; padding-left: 40px;"><strong>Utilidad Bruta</strong></td>
                                        <td style="padding: 12px 20px; text-align: right; color: #28a745;"><strong>$44,700,000</strong></td>
                                        <td style="padding: 12px 20px; text-align: right; color: #28a745;"><strong>33.3%</strong></td>
                                    </tr>
                                    <tr style="background-color: #f8f9fa;">
                                        <td style="padding: 12px 20px; padding-left: 40px;">- Gastos de Operación</td>
                                        <td style="padding: 12px 20px; text-align: right;">$12,800,000</td>
                                        <td style="padding: 12px 20px; text-align: right;">9.5%</td>
                                    </tr>
                                    <tr style="background-color: #f8f9fa;">
                                        <td style="padding: 12px 20px; padding-left: 40px;">- Gastos Administrativos</td>
                                        <td style="padding: 12px 20px; text-align: right;">$5,400,000</td>
                                        <td style="padding: 12px 20px; text-align: right;">4.0%</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px 20px; padding-left: 40px;"><strong>EBITDA</strong></td>
                                        <td style="padding: 12px 20px; text-align: right; color: #083CAE;"><strong>$26,500,000</strong></td>
                                        <td style="padding: 12px 20px; text-align: right; color: #083CAE;"><strong>19.8%</strong></td>
                                    </tr>
                                    <tr style="background-color: #f8f9fa;">
                                        <td style="padding: 12px 20px; padding-left: 40px;">- Depreciación y Amortización</td>
                                        <td style="padding: 12px 20px; text-align: right;">$1,700,000</td>
                                        <td style="padding: 12px 20px; text-align: right;">1.3%</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px 20px; padding-left: 40px;"><strong>Utilidad de Operación</strong></td>
                                        <td style="padding: 12px 20px; text-align: right; color: #ffc107;"><strong>$24,800,000</strong></td>
                                        <td style="padding: 12px 20px; text-align: right; color: #ffc107;"><strong>18.5%</strong></td>
                                    </tr>
                                    <tr style="background-color: #f8f9fa;">
                                        <td style="padding: 12px 20px; padding-left: 40px;">- Gastos Financieros</td>
                                        <td style="padding: 12px 20px; text-align: right;">$2,100,000</td>
                                        <td style="padding: 12px 20px; text-align: right;">1.6%</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px 20px; padding-left: 40px;">- Impuestos</td>
                                        <td style="padding: 12px 20px; text-align: right;">$5,800,000</td>
                                        <td style="padding: 12px 20px; text-align: right;">4.3%</td>
                                    </tr>
                                    <tr style="background-color: #e9ecef; font-weight: bold;">
                                        <td style="padding: 15px 20px;">Utilidad Neta</td>
                                        <td style="padding: 15px 20px; text-align: right; color: #28a745; font-size: 18px;">$16,900,000</td>
                                        <td style="padding: 15px 20px; text-align: right; color: #28a745; font-size: 18px;">12.6%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Indicadores Clave -->
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="color: #6c757d; font-size: 12px;">ROI (Retorno sobre Inversión)</div>
                            <div style="font-size: 24px; font-weight: 700; color: #28a745;">22.3%</div>
                            <div style="font-size: 12px; color: #6c757d;">vs 18.5% objetivo</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="color: #6c757d; font-size: 12px;">ROE (Retorno sobre Capital)</div>
                            <div style="font-size: 24px; font-weight: 700; color: #28a745;">18.7%</div>
                            <div style="font-size: 12px; color: #6c757d;">+2.3% vs trimestre</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="color: #6c757d; font-size: 12px;">Margen Neto</div>
                            <div style="font-size: 24px; font-weight: 700; color: #083CAE;">12.6%</div>
                            <div style="font-size: 12px; color: #6c757d;">Industria: 10.2%</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="color: #6c757d; font-size: 12px;">Punto de Equilibrio</div>
                            <div style="font-size: 24px; font-weight: 700; color: #ffc107;">$78.5M</div>
                            <div style="font-size: 12px; color: #6c757d;">58% de ingresos</div>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 2: RENTABILIDAD POR PROYECTO -->
                <div id="tab-proyectos" class="analisis-content" style="display: none;">
                    <!-- Tabla de rentabilidad por proyecto -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 15px; text-align: left;">Proyecto</th>
                                    <th style="padding: 15px; text-align: right;">Ingresos</th>
                                    <th style="padding: 15px; text-align: right;">Costos</th>
                                    <th style="padding: 15px; text-align: right;">Utilidad</th>
                                    <th style="padding: 15px; text-align: center;">Margen</th>
                                    <th style="padding: 15px; text-align: center;">ROI</th>
                                    <th style="padding: 15px; text-align: center;">Avance</th>
                                    <th style="padding: 15px; text-align: center;">Estatus</th>
                                    <th style="padding: 15px; text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 15px;"><strong>Torre Norte Corporativa</strong><br><small style="color: #6c757d;">PRO-2024-001</small></td>
                                    <td style="padding: 15px; text-align: right;">$52,300,000</td>
                                    <td style="padding: 15px; text-align: right;">$42,800,000</td>
                                    <td style="padding: 15px; text-align: right; color: #28a745;">$9,500,000</td>
                                    <td style="padding: 15px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">18.2%</span></td>
                                    <td style="padding: 15px; text-align: center;">21.5%</td>
                                    <td style="padding: 15px; text-align: center;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 65%; height: 6px; background-color: #28a745; border-radius: 3px;"></div>
                                            </div>
                                            65%
                                        </div>
                                    </td>
                                    <td style="padding: 15px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Rentable</span></td>
                                    <td style="padding: 15px; text-align: center;">
                                        <i class="fas fa-chart-line" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalle"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;" title="Reporte"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 15px;"><strong>Puente Vehicular Sur</strong><br><small style="color: #6c757d;">PRO-2024-002</small></td>
                                    <td style="padding: 15px; text-align: right;">$28,750,000</td>
                                    <td style="padding: 15px; text-align: right;">$25,300,000</td>
                                    <td style="padding: 15px; text-align: right; color: #ffc107;">$3,450,000</td>
                                    <td style="padding: 15px; text-align: center;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">12.0%</span></td>
                                    <td style="padding: 15px; text-align: center;">14.2%</td>
                                    <td style="padding: 15px; text-align: center;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 40%; height: 6px; background-color: #ffc107; border-radius: 3px;"></div>
                                            </div>
                                            40%
                                        </div>
                                    </td>
                                    <td style="padding: 15px; text-align: center;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">En desarrollo</span></td>
                                    <td style="padding: 15px; text-align: center;">
                                        <i class="fas fa-chart-line" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 15px;"><strong>Parque Industrial Norte</strong><br><small style="color: #6c757d;">PRO-2024-003</small></td>
                                    <td style="padding: 15px; text-align: right;">$52,300,000</td>
                                    <td style="padding: 15px; text-align: right;">$41,800,000</td>
                                    <td style="padding: 15px; text-align: right; color: #28a745;">$10,500,000</td>
                                    <td style="padding: 15px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">20.1%</span></td>
                                    <td style="padding: 15px; text-align: center;">24.3%</td>
                                    <td style="padding: 15px; text-align: center;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 25%; height: 6px; background-color: #28a745; border-radius: 3px;"></div>
                                            </div>
                                            25%
                                        </div>
                                    </td>
                                    <td style="padding: 15px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Rentable</span></td>
                                    <td style="padding: 15px; text-align: center;">
                                        <i class="fas fa-chart-line" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 15px;"><strong>Hospital Regional</strong><br><small style="color: #6c757d;">PRO-2024-004</small></td>
                                    <td style="padding: 15px; text-align: right;">$78,900,000</td>
                                    <td style="padding: 15px; text-align: right;">$71,500,000</td>
                                    <td style="padding: 15px; text-align: right; color: #28a745;">$7,400,000</td>
                                    <td style="padding: 15px; text-align: center;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">9.4%</span></td>
                                    <td style="padding: 15px; text-align: center;">11.2%</td>
                                    <td style="padding: 15px; text-align: center;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 80%; height: 6px; background-color: #28a745; border-radius: 3px;"></div>
                                            </div>
                                            80%
                                        </div>
                                    </td>
                                    <td style="padding: 15px; text-align: center;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">Margen bajo</span></td>
                                    <td style="padding: 15px; text-align: center;">
                                        <i class="fas fa-chart-line" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 15px;"><strong>Planta de Tratamiento</strong><br><small style="color: #6c757d;">PRO-2024-005</small></td>
                                    <td style="padding: 15px; text-align: right;">$34,200,000</td>
                                    <td style="padding: 15px; text-align: right;">$30,800,000</td>
                                    <td style="padding: 15px; text-align: right; color: #28a745;">$3,400,000</td>
                                    <td style="padding: 15px; text-align: center;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">9.9%</span></td>
                                    <td style="padding: 15px; text-align: center;">11.8%</td>
                                    <td style="padding: 15px; text-align: center;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 45%; height: 6px; background-color: #ffc107; border-radius: 3px;"></div>
                                            </div>
                                            45%
                                        </div>
                                    </td>
                                    <td style="padding: 15px; text-align: center;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">En desarrollo</span></td>
                                    <td style="padding: 15px; text-align: center;">
                                        <i class="fas fa-chart-line" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 15px;"><strong>Urbanización Los Álamos</strong><br><small style="color: #6c757d;">PRO-2024-006</small></td>
                                    <td style="padding: 15px; text-align: right;">$67,800,000</td>
                                    <td style="padding: 15px; text-align: right;">$58,200,000</td>
                                    <td style="padding: 15px; text-align: right; color: #28a745;">$9,600,000</td>
                                    <td style="padding: 15px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">14.2%</span></td>
                                    <td style="padding: 15px; text-align: center;">16.8%</td>
                                    <td style="padding: 15px; text-align: center;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 15%; height: 6px; background-color: #28a745; border-radius: 3px;"></div>
                                            </div>
                                            15%
                                        </div>
                                    </td>
                                    <td style="padding: 15px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Rentable</span></td>
                                    <td style="padding: 15px; text-align: center;">
                                        <i class="fas fa-chart-line" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot style="background-color: #e9ecef; font-weight: bold;">
                                <tr>
                                    <td style="padding: 15px;">Totales / Promedios</td>
                                    <td style="padding: 15px; text-align: right;">$313,350,000</td>
                                    <td style="padding: 15px; text-align: right;">$269,600,000</td>
                                    <td style="padding: 15px; text-align: right; color: #28a745;">$43,750,000</td>
                                    <td style="padding: 15px; text-align: center;">14.0%</td>
                                    <td style="padding: 15px; text-align: center;">16.6%</td>
                                    <td style="padding: 15px; text-align: center;">45%</td>
                                    <td style="padding: 15px; text-align: center;"></td>
                                    <td style="padding: 15px; text-align: center;"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Gráfico de rentabilidad por proyecto -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 25px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-bar"></i> Rentabilidad por Proyecto
                            </h4>
                            <div style="height: 200px; display: flex; align-items: flex-end; gap: 10px; justify-content: space-around;">
                                <div style="text-align: center;">
                                    <div style="height: 140px; width: 40px; background-color: #28a745; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Torre</div>
                                    <div style="font-size: 10px;">18.2%</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="height: 95px; width: 40px; background-color: #ffc107; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Puente</div>
                                    <div style="font-size: 10px;">12.0%</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="height: 155px; width: 40px; background-color: #28a745; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Parque</div>
                                    <div style="font-size: 10px;">20.1%</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="height: 75px; width: 40px; background-color: #ffc107; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Hospital</div>
                                    <div style="font-size: 10px;">9.4%</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="height: 80px; width: 40px; background-color: #ffc107; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Planta</div>
                                    <div style="font-size: 10px;">9.9%</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="height: 110px; width: 40px; background-color: #28a745; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">Urb.</div>
                                    <div style="font-size: 10px;">14.2%</div>
                                </div>
                            </div>
                        </div>

                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-pie"></i> Distribución de Utilidad
                            </h4>
                            <div style="display: flex; align-items: center; gap: 20px;">
                                <div style="width: 150px; height: 150px; border-radius: 50%; background: conic-gradient(#28a745 0deg 130deg, #ffc107 130deg 210deg, #dc3545 210deg 360deg);"></div>
                                <div>
                                    <div style="margin-bottom: 10px;">
                                        <span style="display: inline-block; width: 12px; height: 12px; background-color: #28a745; border-radius: 3px;"></span>
                                        <span style="margin-left: 5px; font-size: 13px;">Rentables (3)</span>
                                        <span style="float: right; font-weight: 600;">65%</span>
                                    </div>
                                    <div style="margin-bottom: 10px;">
                                        <span style="display: inline-block; width: 12px; height: 12px; background-color: #ffc107; border-radius: 3px;"></span>
                                        <span style="margin-left: 5px; font-size: 13px;">Margen medio (2)</span>
                                        <span style="float: right; font-weight: 600;">25%</span>
                                    </div>
                                    <div>
                                        <span style="display: inline-block; width: 12px; height: 12px; background-color: #dc3545; border-radius: 3px;"></span>
                                        <span style="margin-left: 5px; font-size: 13px;">Críticos (1)</span>
                                        <span style="float: right; font-weight: 600;">10%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 3: RENTABILIDAD POR CATEGORÍA -->
                <div id="tab-categorias" class="analisis-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                        <!-- Rentabilidad por tipo de obra -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-bar"></i> Rentabilidad por Tipo de Obra
                            </h4>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Oficinas Comerciales</span>
                                    <span style="font-size: 13px; font-weight: 600;">18.2%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 18.2%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Infraestructura Vial</span>
                                    <span style="font-size: 13px; font-weight: 600;">12.0%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 12%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Naves Industriales</span>
                                    <span style="font-size: 13px; font-weight: 600;">20.1%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 20.1%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Salud</span>
                                    <span style="font-size: 13px; font-weight: 600;">9.4%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 9.4%; height: 8px; background-color: #dc3545; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Hidráulico</span>
                                    <span style="font-size: 13px; font-weight: 600;">9.9%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 9.9%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Residencial</span>
                                    <span style="font-size: 13px; font-weight: 600;">14.2%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 14.2%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Rentabilidad por cliente -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-building"></i> Rentabilidad por Cliente
                            </h4>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Inmobiliaria del Sur</span>
                                    <span style="font-size: 13px; font-weight: 600;">18.2%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 18.2%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Gobierno Regional</span>
                                    <span style="font-size: 13px; font-weight: 600;">12.0%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 12%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Constructora ABC</span>
                                    <span style="font-size: 13px; font-weight: 600;">20.1%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 20.1%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Ministerio de Salud</span>
                                    <span style="font-size: 13px; font-weight: 600;">9.4%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 9.4%; height: 8px; background-color: #dc3545; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Minera del Norte</span>
                                    <span style="font-size: 13px; font-weight: 600;">9.9%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 9.9%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Análisis de costos por categoría -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                        <div style="background-color: #f8f9fa; padding: 15px 20px; border-bottom: 2px solid #083CAE;">
                            <h5 style="margin: 0; color: #083CAE; font-size: 16px;"><i class="fas fa-chart-pie"></i> Desglose de Costos por Categoría</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="padding: 12px;">Categoría</th>
                                        <th style="padding: 12px; text-align: right;">Monto</th>
                                        <th style="padding: 12px; text-align: center;">% del Total</th>
                                        <th style="padding: 12px; text-align: right;">vs Presupuesto</th>
                                        <th style="padding: 12px; text-align: right;">vs Mes Anterior</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 12px;">Materiales</td>
                                        <td style="padding: 12px; text-align: right;">$52,800,000</td>
                                        <td style="padding: 12px; text-align: center;">48.2%</td>
                                        <td style="padding: 12px; text-align: right; color: #28a745;">-2.3%</td>
                                        <td style="padding: 12px; text-align: right; color: #28a745;">-1.5%</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;">Mano de Obra</td>
                                        <td style="padding: 12px; text-align: right;">$28,200,000</td>
                                        <td style="padding: 12px; text-align: center;">25.8%</td>
                                        <td style="padding: 12px; text-align: right; color: #dc3545;">+3.8%</td>
                                        <td style="padding: 12px; text-align: right; color: #dc3545;">+2.1%</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;">Maquinaria</td>
                                        <td style="padding: 12px; text-align: right;">$15,200,000</td>
                                        <td style="padding: 12px; text-align: center;">13.9%</td>
                                        <td style="padding: 12px; text-align: right; color: #ffc107;">+1.2%</td>
                                        <td style="padding: 12px; text-align: right; color: #28a745;">-0.8%</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;">Subcontratos</td>
                                        <td style="padding: 12px; text-align: right;">$9,100,000</td>
                                        <td style="padding: 12px; text-align: center;">8.3%</td>
                                        <td style="padding: 12px; text-align: right; color: #28a745;">-1.5%</td>
                                        <td style="padding: 12px; text-align: right; color: #28a745;">-0.5%</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;">Indirectos</td>
                                        <td style="padding: 12px; text-align: right;">$4,100,000</td>
                                        <td style="padding: 12px; text-align: center;">3.8%</td>
                                        <td style="padding: 12px; text-align: right; color: #ffc107;">+0.5%</td>
                                        <td style="padding: 12px; text-align: right; color: #ffc107;">+0.2%</td>
                                    </tr>
                                </tbody>
                                <tfoot style="background-color: #e9ecef; font-weight: bold;">
                                    <tr>
                                        <td style="padding: 12px;">Totales</td>
                                        <td style="padding: 12px; text-align: right;">$109,400,000</td>
                                        <td style="padding: 12px; text-align: center;">100%</td>
                                        <td style="padding: 12px; text-align: right;"></td>
                                        <td style="padding: 12px; text-align: right;"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 4: TENDENCIAS -->
                <div id="tab-tendencias" class="analisis-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 25px;">
                        <!-- Tendencia de márgenes -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-line"></i> Evolución del Margen (Últimos 12 meses)
                            </h4>
                            <div style="height: 250px; display: flex; align-items: flex-end; gap: 5px; justify-content: center;">
                                <div style="text-align: center; width: 30px;">
                                    <div style="height: 80px; background-color: #28a745; width: 20px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 10px;">Ene</div>
                                    <div style="font-size: 9px;">16.2%</div>
                                </div>
                                <div style="text-align: center; width: 30px;">
                                    <div style="height: 85px; background-color: #28a745; width: 20px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 10px;">Feb</div>
                                    <div style="font-size: 9px;">16.8%</div>
                                </div>
                                <div style="text-align: center; width: 30px;">
                                    <div style="height: 82px; background-color: #28a745; width: 20px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 10px;">Mar</div>
                                    <div style="font-size: 9px;">16.5%</div>
                                </div>
                                <div style="text-align: center; width: 30px;">
                                    <div style="height: 90px; background-color: #28a745; width: 20px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 10px;">Abr</div>
                                    <div style="font-size: 9px;">17.5%</div>
                                </div>
                                <div style="text-align: center; width: 30px;">
                                    <div style="height: 95px; background-color: #28a745; width: 20px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 10px;">May</div>
                                    <div style="font-size: 9px;">18.2%</div>
                                </div>
                                <div style="text-align: center; width: 30px;">
                                    <div style="height: 98px; background-color: #28a745; width: 20px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 10px;">Jun</div>
                                    <div style="font-size: 9px;">18.5%</div>
                                </div>
                                <div style="text-align: center; width: 30px;">
                                    <div style="height: 102px; background-color: #28a745; width: 20px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 10px;">Jul</div>
                                    <div style="font-size: 9px;">19.0%</div>
                                </div>
                                <div style="text-align: center; width: 30px;">
                                    <div style="height: 108px; background-color: #28a745; width: 20px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 10px;">Ago</div>
                                    <div style="font-size: 9px;">19.8%</div>
                                </div>
                                <div style="text-align: center; width: 30px;">
                                    <div style="height: 105px; background-color: #28a745; width: 20px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 10px;">Sep</div>
                                    <div style="font-size: 9px;">19.5%</div>
                                </div>
                                <div style="text-align: center; width: 30px;">
                                    <div style="height: 112px; background-color: #28a745; width: 20px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 10px;">Oct</div>
                                    <div style="font-size: 9px;">20.2%</div>
                                </div>
                                <div style="text-align: center; width: 30px;">
                                    <div style="height: 108px; background-color: #28a745; width: 20px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 10px;">Nov</div>
                                    <div style="font-size: 9px;">19.8%</div>
                                </div>
                                <div style="text-align: center; width: 30px;">
                                    <div style="height: 115px; background-color: #28a745; width: 20px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 10px;">Dic</div>
                                    <div style="font-size: 9px;">20.5%</div>
                                </div>
                            </div>
                        </div>

                        <!-- Proyecciones -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-line"></i> Proyección a 6 meses
                            </h4>
                            <div style="margin-bottom: 20px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Margen Proyectado</span>
                                    <span style="font-size: 13px; font-weight: 600;">21.5%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 21.5%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Ingresos Proyectados</span>
                                    <span style="font-size: 13px; font-weight: 600;">$185M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 75%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Utilidad Proyectada</span>
                                    <span style="font-size: 13px; font-weight: 600;">$39.8M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 68%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="font-weight: 600;">Crecimiento Anual</span>
                                    <span style="font-weight: 700; color: #28a745;">+15.3%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de tendencias mensuales -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 12px;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Mes</th>
                                    <th style="padding: 12px; text-align: right;">Ingresos</th>
                                    <th style="padding: 12px; text-align: right;">Costos</th>
                                    <th style="padding: 12px; text-align: right;">Utilidad</th>
                                    <th style="padding: 12px; text-align: center;">Margen</th>
                                    <th style="padding: 12px; text-align: right;">vs Mes Anterior</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px;">Enero 2026</td>
                                    <td style="padding: 12px; text-align: right;">$8,200,000</td>
                                    <td style="padding: 12px; text-align: right;">$6,500,000</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">$1,700,000</td>
                                    <td style="padding: 12px; text-align: center;">16.2%</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">+2.1%</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">Febrero 2026</td>
                                    <td style="padding: 12px; text-align: right;">$9,100,000</td>
                                    <td style="padding: 12px; text-align: right;">$7,200,000</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">$1,900,000</td>
                                    <td style="padding: 12px; text-align: center;">16.8%</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">+0.6%</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">Marzo 2026</td>
                                    <td style="padding: 12px; text-align: right;">$10,000,000</td>
                                    <td style="padding: 12px; text-align: right;">$7,900,000</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">$2,100,000</td>
                                    <td style="padding: 12px; text-align: center;">16.5%</td>
                                    <td style="padding: 12px; text-align: right; color: #dc3545;">-0.3%</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">Abril 2026</td>
                                    <td style="padding: 12px; text-align: right;">$10,900,000</td>
                                    <td style="padding: 12px; text-align: right;">$8,600,000</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">$2,300,000</td>
                                    <td style="padding: 12px; text-align: center;">17.5%</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">+1.0%</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">Mayo 2026</td>
                                    <td style="padding: 12px; text-align: right;">$9,500,000</td>
                                    <td style="padding: 12px; text-align: right;">$7,400,000</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">$2,100,000</td>
                                    <td style="padding: 12px; text-align: center;">18.2%</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">+0.7%</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">Junio 2026</td>
                                    <td style="padding: 12px; text-align: right;">$8,600,000</td>
                                    <td style="padding: 12px; text-align: right;">$6,700,000</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">$1,900,000</td>
                                    <td style="padding: 12px; text-align: center;">18.5%</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">+0.3%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 5: COMPARATIVO -->
                <div id="tab-comparativo" class="analisis-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                        <!-- vs Presupuesto -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-bar"></i> Real vs Presupuesto
                            </h4>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Ingresos</span>
                                    <span style="font-size: 13px; font-weight: 600;">$134.2M / $142.0M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 94.5%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                                <div style="font-size: 11px; color: #ffc107; margin-top: 2px;">-5.5% vs presupuesto</div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Costos</span>
                                    <span style="font-size: 13px; font-weight: 600;">$109.4M / $115.0M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 95.1%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                                <div style="font-size: 11px; color: #28a745; margin-top: 2px;">-4.9% por debajo</div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Utilidad</span>
                                    <span style="font-size: 13px; font-weight: 600;">$24.8M / $27.0M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 91.8%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                                <div style="font-size: 11px; color: #ffc107; margin-top: 2px;">-8.2% por debajo</div>
                            </div>
                        </div>

                        <!-- vs Año Anterior -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-line"></i> 2026 vs 2025
                            </h4>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Ingresos</span>
                                    <span style="font-size: 13px; font-weight: 600;">+15.3%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 75%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Margen</span>
                                    <span style="font-size: 13px; font-weight: 600;">+2.1%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 60%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">ROI</span>
                                    <span style="font-size: 13px; font-weight: 600;">+3.5%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 70%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comparativo por proyecto -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 12px;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Proyecto</th>
                                    <th style="padding: 12px; text-align: right;">Real</th>
                                    <th style="padding: 12px; text-align: right;">Presupuesto</th>
                                    <th style="padding: 12px; text-align: center;">Variación</th>
                                    <th style="padding: 12px; text-align: right;">2025</th>
                                    <th style="padding: 12px; text-align: center;">vs 2025</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px;">Torre Norte Corporativa</td>
                                    <td style="padding: 12px; text-align: right;">18.2%</td>
                                    <td style="padding: 12px; text-align: right;">17.5%</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">+0.7%</td>
                                    <td style="padding: 12px; text-align: right;">16.8%</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">+1.4%</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">Puente Vehicular Sur</td>
                                    <td style="padding: 12px; text-align: right;">12.0%</td>
                                    <td style="padding: 12px; text-align: right;">13.5%</td>
                                    <td style="padding: 12px; text-align: center; color: #dc3545;">-1.5%</td>
                                    <td style="padding: 12px; text-align: right;">11.2%</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">+0.8%</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">Parque Industrial Norte</td>
                                    <td style="padding: 12px; text-align: right;">20.1%</td>
                                    <td style="padding: 12px; text-align: right;">19.0%</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">+1.1%</td>
                                    <td style="padding: 12px; text-align: right;">18.5%</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">+1.6%</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">Hospital Regional</td>
                                    <td style="padding: 12px; text-align: right;">9.4%</td>
                                    <td style="padding: 12px; text-align: right;">10.0%</td>
                                    <td style="padding: 12px; text-align: center; color: #dc3545;">-0.6%</td>
                                    <td style="padding: 12px; text-align: right;">8.9%</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">+0.5%</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">Planta de Tratamiento</td>
                                    <td style="padding: 12px; text-align: right;">9.9%</td>
                                    <td style="padding: 12px; text-align: right;">10.5%</td>
                                    <td style="padding: 12px; text-align: center; color: #dc3545;">-0.6%</td>
                                    <td style="padding: 12px; text-align: right;">9.1%</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">+0.8%</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">Urbanización Los Álamos</td>
                                    <td style="padding: 12px; text-align: right;">14.2%</td>
                                    <td style="padding: 12px; text-align: right;">13.8%</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">+0.4%</td>
                                    <td style="padding: 12px; text-align: right;">13.2%</td>
                                    <td style="padding: 12px; text-align: center; color: #28a745;">+1.0%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Paginación y botón Crear filtro (solo visible en tablas extensas) -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 25px; gap: 5px; background: transparent !important; background-color: transparent !important; border: none !important; box-shadow: none !important;">
                    <!-- Botón Generar Reporte (izquierda) -->
                    <button id="btnGenerarReporte" style="background: transparent !important; background-color: transparent !important; border: none !important; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: #2378e1; box-shadow: none !important; outline: none !important; margin: 0;">
                        <i class="fas fa-file-pdf" style="font-size: 16px; color: #dc3545;"></i>
                        <span style="color: #2378e1;">Generar Reporte Completo</span>
                    </button>
                    
                    <!-- Controles de paginación (derecha) - AZUL Y SIN FONDO (para tablas) -->
                    <div style="display: flex; align-items: center; gap: 5px; background: transparent; background-color: transparent;">
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Primera página" id="btnPaginaPrimera">
                            <i class="fas fa-angle-double-left" style="color: #2378e1;"></i>
                        </button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página anterior" id="btnPaginaAnterior">
                            <i class="fas fa-angle-left" style="color: #2378e1;"></i>
                        </button>
                        <span style="padding: 5px 10px; background-color: #2378e1; color: white; border-radius: 4px; font-size: 14px;" id="paginaActual">1</span>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página siguiente" id="btnPaginaSiguiente">
                            <i class="fas fa-angle-right" style="color: #2378e1;"></i>
                        </button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Última página" id="btnPaginaUltima">
                            <i class="fas fa-angle-double-right" style="color: #2378e1;"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
        background-color: #f8f9fa !important;
        color: #495057;
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
    
    /* Pestañas */
    .analisis-tab {
        transition: all 0.3s ease;
    }
    
    .analisis-tab:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    
    .analisis-tab.active {
        background-color: #083CAE !important;
        color: white !important;
    }
    
    .analisis-content {
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
    
    /* Estilo específico para btnGenerarReporte */
    #btnGenerarReporte,
    #btnGenerarReporte:hover,
    #btnGenerarReporte:focus,
    #btnGenerarReporte:active {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }
    
    #btnGenerarReporte i,
    #btnGenerarReporte span {
        color: #2378e1 !important;
    }
    
    #btnGenerarReporte i.fa-file-pdf {
        color: #dc3545 !important;
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
        
        .analisis-tab {
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
        console.log('DOM completamente cargado - Análisis de Rentabilidad');
        
        // Variables
        let currentPage = 1;
        let rowsPerPage = 10;
        
        // Elementos del DOM
        const selectorPeriodo = document.getElementById('selectorPeriodo');
        const selectorProyecto = document.getElementById('selectorProyecto');
        const rangoFechas = document.getElementById('rangoFechas');
        const fechaInicio = document.getElementById('fechaInicio');
        const fechaFin = document.getElementById('fechaFin');
        const btnExportar = document.getElementById('btnExportar');
        const btnActualizar = document.getElementById('btnActualizar');
        const btnGenerarReporte = document.getElementById('btnGenerarReporte');
        
        // Pestañas
        const analisisTabs = document.querySelectorAll('.analisis-tab');
        const analisisContents = document.querySelectorAll('.analisis-content');
        
        // Mostrar/ocultar rango de fechas según selector de período
        selectorPeriodo.addEventListener('change', function() {
            if (this.value === 'personalizado') {
                rangoFechas.style.display = 'flex';
            } else {
                rangoFechas.style.display = 'none';
            }
        });
        
        // Cambio de pestañas
        analisisTabs.forEach((tab, index) => {
            tab.addEventListener('click', function() {
                analisisTabs.forEach(t => {
                    t.classList.remove('active');
                    t.style.backgroundColor = '#e9ecef';
                    t.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                analisisContents.forEach(content => content.style.display = 'none');
                analisisContents[index].style.display = 'block';
            });
        });
        
        // Botones de acción
        btnExportar.addEventListener('click', function() {
            alert('Exportando reporte de rentabilidad...');
        });
        
        btnActualizar.addEventListener('click', function() {
            alert('Actualizando datos de rentabilidad...');
        });
        
        btnGenerarReporte.addEventListener('click', function() {
            alert('Generando reporte completo de rentabilidad...');
        });
        
        // Paginación (simulada)
        document.getElementById('btnPaginaPrimera').addEventListener('click', function() {
            currentPage = 1;
            document.getElementById('paginaActual').textContent = currentPage;
        });
        
        document.getElementById('btnPaginaAnterior').addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                document.getElementById('paginaActual').textContent = currentPage;
            }
        });
        
        document.getElementById('btnPaginaSiguiente').addEventListener('click', function() {
            if (currentPage < 5) {
                currentPage++;
                document.getElementById('paginaActual').textContent = currentPage;
            }
        });
        
        document.getElementById('btnPaginaUltima').addEventListener('click', function() {
            currentPage = 5;
            document.getElementById('paginaActual').textContent = currentPage;
        });
        
        // Acciones en iconos
        document.querySelectorAll('.fa-chart-line, .fa-file-pdf').forEach(icon => {
            icon.addEventListener('click', function(e) {
                e.stopPropagation();
                if (this.classList.contains('fa-chart-line')) {
                    alert('Ver detalle de rentabilidad');
                } else if (this.classList.contains('fa-file-pdf')) {
                    alert('Descargar reporte PDF');
                }
            });
        });
    });
</script>
@endsection