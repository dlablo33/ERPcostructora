@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Control de Maquinaria -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-chart-line" style="margin-right: 10px;"></i>
                    Control de Maquinaria
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE CONTROL CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Disponibilidad -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Disponibilidad</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="disponibilidad">87%</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Utilización -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Utilización</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="utilizacion">76%</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Horas Operadas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Horas Hoy</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="horasHoy">342</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Eficiencia -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Eficiencia</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="eficiencia">92%</div>
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

                        <select id="selectorTipo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 180px;">
                            <option value="">Todos los tipos</option>
                            <option value="Excavadora">Excavadoras</option>
                            <option value="Retroexcavadora">Retroexcavadoras</option>
                            <option value="Camion">Camiones</option>
                            <option value="Grua">Grúas</option>
                            <option value="Compactador">Compactadores</option>
                            <option value="Generador">Generadores</option>
                        </select>

                        <!-- Selector de fecha -->
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <input type="date" id="fechaControl" value="2026-03-11" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                    </div>
                    
                    <!-- Grupo de botones derecho -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Botón Reporte -->
                        <div>
                            <button id="btnReporte" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Generar Reporte">
                                <i class="fas fa-file-pdf"></i> Reporte
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

                        <!-- Botón Refrescar -->
                        <div>
                            <button id="btnRefrescar" 
                                    style="background-color: white; border: 1px solid #28a745; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #28a745;"
                                    title="Actualizar datos">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Pestañas de secciones -->
                <div style="display: flex; gap: 2px; margin-bottom: 20px; border-bottom: 2px solid #083CAE; overflow-x: auto; white-space: nowrap;">
                    <button class="control-tab active" data-tab="dashboard" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </button>
                    <button class="control-tab" data-tab="rendimiento" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-chart-bar"></i> Rendimiento
                    </button>
                    <button class="control-tab" data-tab="operadores" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-users-cog"></i> Operadores
                    </button>
                    <button class="control-tab" data-tab="alertas" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-exclamation-triangle"></i> Alertas
                        <span style="background-color: #dc3545; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;">3</span>
                    </button>
                    <button class="control-tab" data-tab="costos" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-dollar-sign"></i> Costos Operativos
                    </button>
                </div>

                <!-- SECCIÓN 1: DASHBOARD -->
                <div id="tab-dashboard" class="control-content active">
                    <!-- KPIs por tipo de maquinaria -->
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; padding: 20px; color: white;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <i class="fas fa-tractor" style="font-size: 24px; opacity: 0.8;"></i>
                                    <h3 style="margin: 10px 0 5px; font-size: 14px; opacity: 0.9;">Excavadoras</h3>
                                    <div style="font-size: 28px; font-weight: bold;">12</div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 12px;">Operando: 8</div>
                                    <div style="font-size: 12px;">Disponibles: 3</div>
                                    <div style="font-size: 12px;">Mantto: 1</div>
                                </div>
                            </div>
                        </div>
                        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 10px; padding: 20px; color: white;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <i class="fas fa-truck" style="font-size: 24px; opacity: 0.8;"></i>
                                    <h3 style="margin: 10px 0 5px; font-size: 14px; opacity: 0.9;">Camiones</h3>
                                    <div style="font-size: 28px; font-weight: bold;">18</div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 12px;">Operando: 14</div>
                                    <div style="font-size: 12px;">Disponibles: 2</div>
                                    <div style="font-size: 12px;">Mantto: 2</div>
                                </div>
                            </div>
                        </div>
                        <div style="background: linear-gradient(135deg, #5f2c82 0%, #49a09d 100%); border-radius: 10px; padding: 20px; color: white;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <i class="fas fa-crane" style="font-size: 24px; opacity: 0.8;"></i>
                                    <h3 style="margin: 10px 0 5px; font-size: 14px; opacity: 0.9;">Grúas</h3>
                                    <div style="font-size: 28px; font-weight: bold;">6</div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 12px;">Operando: 4</div>
                                    <div style="font-size: 12px;">Disponibles: 1</div>
                                    <div style="font-size: 12px;">Mantto: 1</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gráficos de actividad en tiempo real -->
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <!-- Gráfico de horas operadas por equipo -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-clock"></i> Horas Operadas - Hoy
                            </h4>
                            <div style="height: 200px;">
                                <canvas id="graficoHoras" style="width: 100%; height: 100%;"></canvas>
                                <!-- Simulación de gráfico con barras -->
                                <div style="display: flex; align-items: flex-end; gap: 10px; height: 180px; justify-content: space-around;">
                                    <div style="text-align: center; width: 60px;">
                                        <div style="height: 120px; background-color: #083CAE; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                        <div style="margin-top: 5px; font-size: 11px;">EX-001</div>
                                        <div style="font-size: 10px; color: #6c757d;">8.5h</div>
                                    </div>
                                    <div style="text-align: center; width: 60px;">
                                        <div style="height: 95px; background-color: #28a745; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                        <div style="margin-top: 5px; font-size: 11px;">EX-002</div>
                                        <div style="font-size: 10px; color: #6c757d;">6.8h</div>
                                    </div>
                                    <div style="text-align: center; width: 60px;">
                                        <div style="height: 140px; background-color: #ffc107; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                        <div style="margin-top: 5px; font-size: 11px;">CA-010</div>
                                        <div style="font-size: 10px; color: #6c757d;">10.0h</div>
                                    </div>
                                    <div style="text-align: center; width: 60px;">
                                        <div style="height: 75px; background-color: #17a2b8; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                        <div style="margin-top: 5px; font-size: 11px;">RT-005</div>
                                        <div style="font-size: 10px; color: #6c757d;">5.2h</div>
                                    </div>
                                    <div style="text-align: center; width: 60px;">
                                        <div style="height: 110px; background-color: #dc3545; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                        <div style="margin-top: 5px; font-size: 11px;">GR-003</div>
                                        <div style="font-size: 10px; color: #6c757d;">7.8h</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Distribución por estado -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-pie"></i> Estado Actual
                            </h4>
                            <div style="text-align: center;">
                                <div style="position: relative; width: 150px; height: 150px; margin: 0 auto 15px;">
                                    <svg viewBox="0 0 100 100" style="width: 150px; height: 150px;">
                                        <circle cx="50" cy="50" r="40" fill="none" stroke="#28a745" stroke-width="20" stroke-dasharray="188.4" stroke-dashoffset="37.68" />
                                        <circle cx="50" cy="50" r="40" fill="none" stroke="#ffc107" stroke-width="20" stroke-dasharray="188.4" stroke-dashoffset="131.88" transform="rotate(-90 50 50)" />
                                        <circle cx="50" cy="50" r="40" fill="none" stroke="#dc3545" stroke-width="20" stroke-dasharray="188.4" stroke-dashoffset="169.56" transform="rotate(-90 50 50)" />
                                        <text x="50" y="55" text-anchor="middle" fill="#333" font-size="16" font-weight="bold">142</text>
                                    </svg>
                                </div>
                                <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
                                    <span style="font-size: 12px;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #28a745; border-radius: 2px; margin-right: 5px;"></span> Operación: 98</span>
                                    <span style="font-size: 12px;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #ffc107; border-radius: 2px; margin-right: 5px;"></span> Disponible: 24</span>
                                    <span style="font-size: 12px;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #dc3545; border-radius: 2px; margin-right: 5px;"></span> Mantenimiento: 20</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de monitoreo en tiempo real -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                        <div style="background-color: #f8f9fa; padding: 12px 15px; border-bottom: 2px solid #083CAE; display: flex; justify-content: space-between; align-items: center;">
                            <h5 style="margin: 0; color: #083CAE; font-size: 15px;"><i class="fas fa-satellite-dish"></i> Monitoreo en Tiempo Real</h5>
                            <span style="background-color: #28a745; color: white; padding: 3px 8px; border-radius: 4px; font-size: 11px;">Actualizado hace 2 min</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="padding: 12px;">Equipo</th>
                                        <th style="padding: 12px;">Operador</th>
                                        <th style="padding: 12px;">Proyecto</th>
                                        <th style="padding: 12px;">Horas Hoy</th>
                                        <th style="padding: 12px;">Combustible</th>
                                        <th style="padding: 12px;">Ubicación</th>
                                        <th style="padding: 12px;">Status</th>
                                        <th style="padding: 12px;">Próx. Mantto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 12px;"><strong>EX-001</strong> - Excavadora</td>
                                        <td style="padding: 12px;">Carlos Rodríguez</td>
                                        <td style="padding: 12px;">Torre Norte</td>
                                        <td style="padding: 12px;">8.5</td>
                                        <td style="padding: 12px;">65%</td>
                                        <td style="padding: 12px;">Sector A</td>
                                        <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Operando</span></td>
                                        <td style="padding: 12px;">15 días</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>RT-005</strong> - Retro</td>
                                        <td style="padding: 12px;">María García</td>
                                        <td style="padding: 12px;">Puente Sur</td>
                                        <td style="padding: 12px;">5.2</td>
                                        <td style="padding: 12px;">42%</td>
                                        <td style="padding: 12px;">Sector B</td>
                                        <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Operando</span></td>
                                        <td style="padding: 12px;">8 días</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>CA-010</strong> - Camión</td>
                                        <td style="padding: 12px;">Juan Pérez</td>
                                        <td style="padding: 12px;">Parque Industrial</td>
                                        <td style="padding: 12px;">10.0</td>
                                        <td style="padding: 12px;">28%</td>
                                        <td style="padding: 12px;">Ruta 3</td>
                                        <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">En ruta</span></td>
                                        <td style="padding: 12px;"><span style="color: #dc3545;">Vence hoy</span></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>GR-003</strong> - Grúa</td>
                                        <td style="padding: 12px;">Ana Martínez</td>
                                        <td style="padding: 12px;">Hospital Regional</td>
                                        <td style="padding: 12px;">7.8</td>
                                        <td style="padding: 12px;">55%</td>
                                        <td style="padding: 12px;">Zona 2</td>
                                        <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Operando</span></td>
                                        <td style="padding: 12px;">5 días</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>GN-001</strong> - Generador</td>
                                        <td style="padding: 12px;">-</td>
                                        <td style="padding: 12px;">Planta Tratamiento</td>
                                        <td style="padding: 12px;">0</td>
                                        <td style="padding: 12px;">-</td>
                                        <td style="padding: 12px;">Almacén</td>
                                        <td style="padding: 12px;"><span style="background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 4px;">Inactivo</span></td>
                                        <td style="padding: 12px;">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 2: RENDIMIENTO -->
                <div id="tab-rendimiento" class="control-content" style="display: none;">
                    <!-- KPIs de rendimiento -->
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <div style="color: #6c757d; font-size: 12px;">Rendimiento Promedio</div>
                            <div style="font-size: 28px; font-weight: bold; color: #083CAE;">92%</div>
                            <div style="font-size: 11px; color: #28a745;">+2% vs ayer</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <div style="color: #6c757d; font-size: 12px;">Tiempo Muerto</div>
                            <div style="font-size: 28px; font-weight: bold; color: #083CAE;">2.4 hrs</div>
                            <div style="font-size: 11px; color: #dc3545;">+0.5 vs meta</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <div style="color: #6c757d; font-size: 12px;">Producción por Hr</div>
                            <div style="font-size: 28px; font-weight: bold; color: #083CAE;">45 m³</div>
                            <div style="font-size: 11px; color: #28a745;">+3 vs ayer</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <div style="color: #6c757d; font-size: 12px;">Consumo Combustible</div>
                            <div style="font-size: 28px; font-weight: bold; color: #083CAE;">2.8 L/hr</div>
                            <div style="font-size: 11px; color: #28a745;">eficiente</div>
                        </div>
                    </div>

                    <!-- Tabla de rendimiento por equipo -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                        <div style="background-color: #f8f9fa; padding: 12px 15px; border-bottom: 2px solid #083CAE;">
                            <h5 style="margin: 0; color: #083CAE; font-size: 15px;"><i class="fas fa-chart-line"></i> Rendimiento por Equipo</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="padding: 12px;">Equipo</th>
                                        <th style="padding: 12px;">Horas Proyectadas</th>
                                        <th style="padding: 12px;">Horas Reales</th>
                                        <th style="padding: 12px;">Eficiencia</th>
                                        <th style="padding: 12px;">Producción</th>
                                        <th style="padding: 12px;">Tiempo Muerto</th>
                                        <th style="padding: 12px;">Rendimiento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 12px;">EX-001 - Excavadora</td>
                                        <td style="padding: 12px;">8.0</td>
                                        <td style="padding: 12px;">8.5</td>
                                        <td style="padding: 12px;">106%</td>
                                        <td style="padding: 12px;">42 m³</td>
                                        <td style="padding: 12px;">0.5 h</td>
                                        <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Excelente</span></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;">RT-005 - Retro</td>
                                        <td style="padding: 12px;">8.0</td>
                                        <td style="padding: 12px;">5.2</td>
                                        <td style="padding: 12px;">65%</td>
                                        <td style="padding: 12px;">28 m³</td>
                                        <td style="padding: 12px;">2.8 h</td>
                                        <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">Regular</span></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;">CA-010 - Camión</td>
                                        <td style="padding: 12px;">10.0</td>
                                        <td style="padding: 12px;">10.0</td>
                                        <td style="padding: 12px;">100%</td>
                                        <td style="padding: 12px;">15 viajes</td>
                                        <td style="padding: 12px;">1.0 h</td>
                                        <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Bueno</span></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;">GR-003 - Grúa</td>
                                        <td style="padding: 12px;">8.0</td>
                                        <td style="padding: 12px;">7.8</td>
                                        <td style="padding: 12px;">97%</td>
                                        <td style="padding: 12px;">12 izajes</td>
                                        <td style="padding: 12px;">0.2 h</td>
                                        <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Excelente</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 3: OPERADORES -->
                <div id="tab-operadores" class="control-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 50px; height: 50px; background-color: #e8f0fe; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user-tie" style="color: #083CAE; font-size: 24px;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Total Operadores</div>
                                    <div style="font-size: 28px; font-weight: bold; color: #083CAE;">24</div>
                                </div>
                            </div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 50px; height: 50px; background-color: #d4edda; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user-check" style="color: #28a745; font-size: 24px;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Activos Hoy</div>
                                    <div style="font-size: 28px; font-weight: bold; color: #28a745;">18</div>
                                </div>
                            </div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 50px; height: 50px; background-color: #fff3cd; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-star" style="color: #ffc107; font-size: 24px;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Top Performance</div>
                                    <div style="font-size: 28px; font-weight: bold; color: #ffc107;">Carlos R.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de operadores -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                        <div style="background-color: #f8f9fa; padding: 12px 15px; border-bottom: 2px solid #083CAE;">
                            <h5 style="margin: 0; color: #083CAE; font-size: 15px;"><i class="fas fa-users"></i> Desempeño de Operadores</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="padding: 12px;">Operador</th>
                                        <th style="padding: 12px;">Equipo Asignado</th>
                                        <th style="padding: 12px;">Horas Hoy</th>
                                        <th style="padding: 12px;">Horas Semana</th>
                                        <th style="padding: 12px;">Eficiencia</th>
                                        <th style="padding: 12px;">Incidentes</th>
                                        <th style="padding: 12px;">Calificación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 12px;">Carlos Rodríguez</td>
                                        <td style="padding: 12px;">EX-001 - Excavadora</td>
                                        <td style="padding: 12px;">8.5</td>
                                        <td style="padding: 12px;">42.5</td>
                                        <td style="padding: 12px;">98%</td>
                                        <td style="padding: 12px;">0</td>
                                        <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">A+</span></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;">María García</td>
                                        <td style="padding: 12px;">RT-005 - Retro</td>
                                        <td style="padding: 12px;">5.2</td>
                                        <td style="padding: 12px;">28.4</td>
                                        <td style="padding: 12px;">65%</td>
                                        <td style="padding: 12px;">1</td>
                                        <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">B</span></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;">Juan Pérez</td>
                                        <td style="padding: 12px;">CA-010 - Camión</td>
                                        <td style="padding: 12px;">10.0</td>
                                        <td style="padding: 12px;">48.0</td>
                                        <td style="padding: 12px;">100%</td>
                                        <td style="padding: 12px;">0</td>
                                        <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">A</span></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;">Ana Martínez</td>
                                        <td style="padding: 12px;">GR-003 - Grúa</td>
                                        <td style="padding: 12px;">7.8</td>
                                        <td style="padding: 12px;">39.0</td>
                                        <td style="padding: 12px;">95%</td>
                                        <td style="padding: 12px;">0</td>
                                        <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">A</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 4: ALERTAS -->
                <div id="tab-alertas" class="control-content" style="display: none;">
                    <div style="margin-bottom: 20px;">
                        <div style="background-color: #f8d7da; border-left: 4px solid #dc3545; border-radius: 4px; padding: 15px; margin-bottom: 10px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-exclamation-circle" style="color: #dc3545; font-size: 24px;"></i>
                                <div style="flex: 1;">
                                    <h4 style="margin: 0; font-size: 14px; color: #721c24;">Mantenimiento Vencido</h4>
                                    <p style="margin: 5px 0 0; font-size: 13px;">El equipo CA-010 tiene mantenimiento programado vencido desde ayer</p>
                                </div>
                                <span style="color: #dc3545; font-weight: bold;">Hace 1 día</span>
                            </div>
                        </div>
                        <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px; padding: 15px; margin-bottom: 10px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-exclamation-triangle" style="color: #856404; font-size: 24px;"></i>
                                <div style="flex: 1;">
                                    <h4 style="margin: 0; font-size: 14px; color: #856404;">Bajo Rendimiento</h4>
                                    <p style="margin: 5px 0 0; font-size: 13px;">La retroexcavadora RT-005 tiene solo 65% de eficiencia en la última semana</p>
                                </div>
                                <span style="color: #856404; font-weight: bold;">Hace 2 días</span>
                            </div>
                        </div>
                        <div style="background-color: #cce5ff; border-left: 4px solid #0d6efd; border-radius: 4px; padding: 15px; margin-bottom: 10px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-info-circle" style="color: #0d6efd; font-size: 24px;"></i>
                                <div style="flex: 1;">
                                    <h4 style="margin: 0; font-size: 14px; color: #0d6efd;">Próximo Mantenimiento</h4>
                                    <p style="margin: 5px 0 0; font-size: 13px;">3 equipos requieren mantenimiento en los próximos 7 días</p>
                                </div>
                                <span style="color: #0d6efd; font-weight: bold;">Preventivo</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 5: COSTOS OPERATIVOS -->
                <div id="tab-costos" class="control-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <div style="color: #6c757d; font-size: 12px;">Costo Operativo Hoy</div>
                            <div style="font-size: 28px; font-weight: bold; color: #083CAE;">$45,280</div>
                            <div style="font-size: 11px;">combustible + mantenimiento</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <div style="color: #6c757d; font-size: 12px;">Costo por Hora</div>
                            <div style="font-size: 28px; font-weight: bold; color: #083CAE;">$328</div>
                            <div style="font-size: 11px;">promedio por equipo</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <div style="color: #6c757d; font-size: 12px;">Costo Mensual</div>
                            <div style="font-size: 28px; font-weight: bold; color: #083CAE;">$985,450</div>
                            <div style="font-size: 11px;">vs presupuesto $950,000</div>
                        </div>
                    </div>

                    <!-- Gráfico de costos -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                            <i class="fas fa-chart-bar"></i> Costos por Tipo de Equipo
                        </h4>
                        <div style="height: 200px; display: flex; align-items: flex-end; gap: 15px; justify-content: center;">
                            <div style="text-align: center;">
                                <div style="height: 140px; width: 50px; background-color: #083CAE; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-size: 12px;">Excavadoras</div>
                                <div style="font-size: 11px; color: #6c757d;">$18,240</div>
                            </div>
                            <div style="text-align: center;">
                                <div style="height: 110px; width: 50px; background-color: #28a745; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-size: 12px;">Camiones</div>
                                <div style="font-size: 11px; color: #6c757d;">$12,450</div>
                            </div>
                            <div style="text-align: center;">
                                <div style="height: 70px; width: 50px; background-color: #ffc107; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-size: 12px;">Grúas</div>
                                <div style="font-size: 11px; color: #6c757d;">$8,320</div>
                            </div>
                            <div style="text-align: center;">
                                <div style="height: 50px; width: 50px; background-color: #17a2b8; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-size: 12px;">Retros</div>
                                <div style="font-size: 11px; color: #6c757d;">$6,270</div>
                            </div>
                        </div>
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
    
    /* Pestañas */
    .control-tab {
        transition: all 0.3s ease;
    }
    
    .control-tab:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    
    .control-tab.active {
        background-color: #083CAE !important;
        color: white !important;
    }
    
    .control-content {
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
        
        select {
            width: 100% !important;
        }
        
        button {
            width: 100%;
        }
        
        .control-tab {
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
        console.log('DOM completamente cargado - Control de Maquinaria');
        
        // Elementos del DOM
        const selectorProyecto = document.getElementById('selectorProyecto');
        const selectorTipo = document.getElementById('selectorTipo');
        const fechaControl = document.getElementById('fechaControl');
        const btnReporte = document.getElementById('btnReporte');
        const btnExcel = document.getElementById('btnExcel');
        const btnRefrescar = document.getElementById('btnRefrescar');
        
        // Pestañas
        const controlTabs = document.querySelectorAll('.control-tab');
        const controlContents = document.querySelectorAll('.control-content');
        
        // Cambio de pestañas
        controlTabs.forEach((tab, index) => {
            tab.addEventListener('click', function() {
                controlTabs.forEach(t => {
                    t.classList.remove('active');
                    t.style.backgroundColor = '#e9ecef';
                    t.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                controlContents.forEach(content => content.style.display = 'none');
                controlContents[index].style.display = 'block';
            });
        });
        
        // Event Listeners
        selectorProyecto.addEventListener('change', function() {
            console.log('Filtrando por proyecto:', this.value);
        });
        
        selectorTipo.addEventListener('change', function() {
            console.log('Filtrando por tipo:', this.value);
        });
        
        fechaControl.addEventListener('change', function() {
            alert('Actualizando datos para fecha: ' + this.value);
        });
        
        btnReporte.addEventListener('click', function() {
            alert('Generando reporte de control de maquinaria...');
        });
        
        btnExcel.addEventListener('click', function() {
            alert('Exportando a Excel...');
        });
        
        btnRefrescar.addEventListener('click', function() {
            alert('Actualizando datos en tiempo real...');
        });
    });
</script>
@endsection