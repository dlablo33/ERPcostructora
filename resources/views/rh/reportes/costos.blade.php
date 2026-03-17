@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Costo de Nómina por Proyecto -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Costo de Nómina por Proyecto
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros de período y proyecto -->
                <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Año</label>
                        <select style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                            <option>2025</option>
                            <option>2024</option>
                            <option>2023</option>
                            <option>2022</option>
                            <option>2021</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Mes</label>
                        <select style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                            <option>Enero</option>
                            <option>Febrero</option>
                            <option>Marzo</option>
                            <option>Abril</option>
                            <option>Mayo</option>
                            <option>Junio</option>
                            <option>Julio</option>
                            <option>Agosto</option>
                            <option>Septiembre</option>
                            <option>Octubre</option>
                            <option>Noviembre</option>
                            <option>Diciembre</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Proyecto</label>
                        <select style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                            <option>Todos los proyectos</option>
                            <option>TRC001 - Torre Cumbres</option>
                            <option>PAC002 - Puente Constitución</option>
                            <option>CIA003 - Complejo Apodaca</option>
                            <option>RHR004 - Hospital Regional</option>
                            <option>VPS005 - Periférico Sur</option>
                            <option>PGA006 - Plaza Galerías</option>
                            <option>CCM007 - Centro Comercial</option>
                            <option>UAN008 - Unidad Anáhuac</option>
                            <option>PIR009 - Parque Roble</option>
                            <option>EST010 - Estadio Universitario</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Clasificación</label>
                        <select style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                            <option>Todas</option>
                            <option>Mano de obra directa</option>
                            <option>Mano de obra indirecta</option>
                            <option>Administración de obra</option>
                            <option>Supervisión</option>
                            <option>Seguridad</option>
                            <option>Mantenimiento</option>
                        </select>
                    </div>
                    <div style="display: flex; align-items: flex-end;">
                        <button style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 13px; width: 100%;">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                    </div>
                </div>

                <!-- KPIs - Indicadores de costo de nómina [citation:1] -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px; width: 100%;">
                    <!-- Costo Total Nómina -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #2378e1; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Costo Total Nómina</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">$2.45M</div>
                    </div>

                    <!-- Horas Hombre Totales -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #17a2b8; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Horas Hombre</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">18,420 h</div>
                    </div>

                    <!-- Costo por Hora Promedio [citation:5]-->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #28a745; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Costo por Semana</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">$55,667</div>
                    </div>

                    <!-- Desviación vs Presupuesto -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #ffc107; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #212529; margin-bottom: 3px;">vs Presupuesto</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: #212529;">+5.2%</div>
                    </div>
                </div>

                <!-- Gráfica de distribución por proyecto (simulada) -->


                <!-- Segunda gráfica: Composición de costos -->
                <div style="margin-bottom: 25px;">
                    <h3 style="color: var(--color-primary); font-size: 16px; margin: 0 0 10px 0;">
                        <i class="fas fa-chart-pie"></i> Composición del Costo de Nómina
                    </h3>
                    <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; display: flex; align-items: center; justify-content: space-around;">
                        <div style="width: 180px; height: 180px; border-radius: 50%; background: conic-gradient(var(--color-primary) 0deg 250deg, #28a745 250deg 320deg, #ffc107 320deg 360deg);"></div>
                        <div style="flex: 1; max-width: 300px;">
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                    <span style="display: inline-block; width: 16px; height: 16px; background-color: var(--color-primary); border-radius: 4px;"></span>
                                    <span style="font-size: 13px; font-weight: 600;">Sueldos base</span>
                                    <span style="font-size: 13px; margin-left: auto;">$1,892,300</span>
                                </div>
                                <div style="height: 8px; background-color: #e9ecef; border-radius: 4px; overflow: hidden;">
                                    <div style="width: 74%; height: 8px; background-color: var(--color-primary);"></div>
                                </div>
                                <div style="font-size: 11px; color: #6c757d; margin-top: 2px;">74.3% del total</div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                    <span style="display: inline-block; width: 16px; height: 16px; background-color: #28a745; border-radius: 4px;"></span>
                                    <span style="font-size: 13px; font-weight: 600;">Prestaciones</span>
                                    <span style="font-size: 13px; margin-left: auto;">$297,950</span>
                                </div>
                                <div style="height: 8px; background-color: #e9ecef; border-radius: 4px; overflow: hidden;">
                                    <div style="width: 11.7%; height: 8px; background-color: #28a745;"></div>
                                </div>
                                <div style="font-size: 11px; color: #6c757d; margin-top: 2px;">11.7% del total</div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                    <span style="display: inline-block; width: 16px; height: 16px; background-color: #ffc107; border-radius: 4px;"></span>
                                    <span style="font-size: 13px; font-weight: 600;">IMSS + INFONAVIT</span>
                                    <span style="font-size: 13px; margin-left: auto;">$355,550</span>
                                </div>
                                <div style="height: 8px; background-color: #e9ecef; border-radius: 4px; overflow: hidden;">
                                    <div style="width: 14%; height: 8px; background-color: #ffc107;"></div>
                                </div>
                                <div style="font-size: 11px; color: #6c757d; margin-top: 2px;">14.0% del total</div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Ranking de proyectos por eficiencia -->
                <div style="margin-bottom: 25px;">
                    <h3 style="color: var(--color-primary); font-size: 16px; margin: 0 0 10px 0;">
                        <i class="fas fa-trophy"></i> Ranking de Proyectos por Eficiencia
                    </h3>
                    <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                            <thead>
                                <tr style="background-color: var(--color-primary); color: white;">
                                    <th style="padding: 10px; text-align: left; border-radius: 6px 0 0 0;">Posición</th>
                                    <th style="padding: 10px; text-align: left;">Proyecto</th>
                                    <th style="padding: 10px; text-align: right;">Costo/Semana</th>
                                    <th style="padding: 10px; text-align: right;">vs Presupuesto</th>
                                    <th style="padding: 10px; text-align: center;">Eficiencia</th>
                                    <th style="padding: 10px; text-align: center;">Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">🏆 1</td>
                                    <td style="padding: 8px; border-bottom: 1px solid #dee2e6; font-weight: 500;">CIA003 - Complejo Apodaca</td>
                                    <td style="padding: 8px; text-align: right; border-bottom: 1px solid #dee2e6;">$124.27</td>
                                    <td style="padding: 8px; text-align: right; border-bottom: 1px solid #dee2e6; color: #28a745;">-1.5%</td>
                                    <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                                        <div style="background-color: #e9ecef; height: 6px; width: 80px; margin: 0 auto; border-radius: 3px; overflow: hidden;">
                                            <div style="width: 98%; height: 6px; background-color: #28a745;"></div>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                                        <span style="background-color: #28a745; color: white; padding: 3px 8px; border-radius: 12px; font-size: 11px;">Óptimo</span>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">🥈 2</td>
                                    <td style="padding: 8px; border-bottom: 1px solid #dee2e6; font-weight: 500;">PAC002 - Puente Constitución</td>
                                    <td style="padding: 8px; text-align: right; border-bottom: 1px solid #dee2e6;">$128.45</td>
                                    <td style="padding: 8px; text-align: right; border-bottom: 1px solid #dee2e6; color: #28a745;">+2.1%</td>
                                    <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                                        <div style="background-color: #e9ecef; height: 6px; width: 80px; margin: 0 auto; border-radius: 3px; overflow: hidden;">
                                            <div style="width: 94%; height: 6px; background-color: #28a745;"></div>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                                        <span style="background-color: #28a745; color: white; padding: 3px 8px; border-radius: 12px; font-size: 11px;">Bueno</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">🥉 3</td>
                                    <td style="padding: 8px; border-bottom: 1px solid #dee2e6; font-weight: 500;">PGA006 - Plaza Galerías</td>
                                    <td style="padding: 8px; text-align: right; border-bottom: 1px solid #dee2e6;">$97.96</td>
                                    <td style="padding: 8px; text-align: right; border-bottom: 1px solid #dee2e6; color: #28a745;">+1.1%</td>
                                    <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                                        <div style="background-color: #e9ecef; height: 6px; width: 80px; margin: 0 auto; border-radius: 3px; overflow: hidden;">
                                            <div style="width: 92%; height: 6px; background-color: #28a745;"></div>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                                        <span style="background-color: #28a745; color: white; padding: 3px 8px; border-radius: 12px; font-size: 11px;">Bueno</span>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">4</td>
                                    <td style="padding: 8px; border-bottom: 1px solid #dee2e6; font-weight: 500;">TRC001 - Torre Cumbres</td>
                                    <td style="padding: 8px; text-align: right; border-bottom: 1px solid #dee2e6;">$133.70</td>
                                    <td style="padding: 8px; text-align: right; border-bottom: 1px solid #dee2e6; color: #ffc107;">+3.0%</td>
                                    <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                                        <div style="background-color: #e9ecef; height: 6px; width: 80px; margin: 0 auto; border-radius: 3px; overflow: hidden;">
                                            <div style="width: 87%; height: 6px; background-color: #ffc107;"></div>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                                        <span style="background-color: #ffc107; color: #212529; padding: 3px 8px; border-radius: 12px; font-size: 11px;">Regular</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">5</td>
                                    <td style="padding: 8px; border-bottom: 1px solid #dee2e6; font-weight: 500;">RHR004 - Hospital Regional</td>
                                    <td style="padding: 8px; text-align: right; border-bottom: 1px solid #dee2e6;">$121.27</td>
                                    <td style="padding: 8px; text-align: right; border-bottom: 1px solid #dee2e6; color: #ffc107;">+3.2%</td>
                                    <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                                        <div style="background-color: #e9ecef; height: 6px; width: 80px; margin: 0 auto; border-radius: 3px; overflow: hidden;">
                                            <div style="width: 85%; height: 6px; background-color: #ffc107;"></div>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                                        <span style="background-color: #ffc107; color: #212529; padding: 3px 8px; border-radius: 12px; font-size: 11px;">Regular</span>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">6</td>
                                    <td style="padding: 8px; border-bottom: 1px solid #dee2e6; font-weight: 500;">VPS005 - Periférico Sur</td>
                                    <td style="padding: 8px; text-align: right; border-bottom: 1px solid #dee2e6;">$100.00</td>
                                    <td style="padding: 8px; text-align: right; border-bottom: 1px solid #dee2e6; color: #dc3545;">+3.6%</td>
                                    <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                                        <div style="background-color: #e9ecef; height: 6px; width: 80px; margin: 0 auto; border-radius: 3px; overflow: hidden;">
                                            <div style="width: 82%; height: 6px; background-color: #dc3545;"></div>
                                        </div>
                                    </td>
                                    <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                                        <span style="background-color: #dc3545; color: white; padding: 3px 8px; border-radius: 12px; font-size: 11px;">Crítico</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Grupo de agrupación -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <!-- Botones -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <!-- Botón Agregar (+) -->
                        <div>
                            <button style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" title="Agregar proyecto">
                                <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Excel</span>
                            </button>
                        </div>

                        <!-- Botón Exportar PDF -->
                        <div>
                            <button style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                <i class="fas fa-file-pdf" style="color: #dc3545;"></i>
                                <span class="hide-mobile">PDF</span>
                            </button>
                        </div>

                        <!-- Botón Seleccionar Columnas -->
                        <div style="position: relative;">
                            <button style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                    onclick="toggleColumnSelector()">
                                <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Columnas</span>
                            </button>
                            
                            <!-- Selector de columnas -->
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 280px; max-height: 400px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative; min-width: 200px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" placeholder="Buscar proyecto..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Costo de Nómina por Proyecto -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%; max-height: 450px; overflow-y: auto;">
                    <table class="table" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1200px;">
                        <thead style="background-color: var(--color-primary); position: sticky; top: 0; z-index: 20;">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="proyecto">Proyecto</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="empleados">Empleados</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="horas">Horas Hombre</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="sueldos">Sueldos</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="prestaciones">Prestaciones</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="imss">IMSS</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="infonavit">INFONAVIT</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="total">Total</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="costo_hora">Costo/Hora</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="presupuesto">Presupuesto</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="desviacion">Desviación</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">TRC001 - Torre Cumbres</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">24</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">6,320</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$625,300</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$98,450</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$78,250</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$42,800</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$844,800</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$133.70</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$820,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 3px 6px; border-radius: 3px; font-size: 11px;">+3.0%</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del proyecto')" title="Ver detalle"></i>
                                    <i class="fas fa-chart-line" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver evolución')" title="Ver evolución"></i>
                                    <i class="fas fa-download" style="color: #6c757d; margin: 0 5px; cursor: pointer;" onclick="alert('Descargar reporte')" title="Descargar reporte"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">PAC002 - Puente Constitución</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">18</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">4,850</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$462,500</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$72,800</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$57,900</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$29,800</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$623,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$128.45</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$610,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 3px 6px; border-radius: 3px; font-size: 11px;">+2.1%</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del proyecto')" title="Ver detalle"></i>
                                    <i class="fas fa-chart-line" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver evolución')" title="Ver evolución"></i>
                                    <i class="fas fa-download" style="color: #6c757d; margin: 0 5px; cursor: pointer;" onclick="alert('Descargar reporte')" title="Descargar reporte"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">CIA003 - Complejo Apodaca</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">4,120</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$382,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$60,200</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$47,800</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$22,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$512,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$124.27</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$520,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 3px 6px; border-radius: 3px; font-size: 11px;">-1.5%</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del proyecto')" title="Ver detalle"></i>
                                    <i class="fas fa-chart-line" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver evolución')" title="Ver evolución"></i>
                                    <i class="fas fa-download" style="color: #6c757d; margin: 0 5px; cursor: pointer;" onclick="alert('Descargar reporte')" title="Descargar reporte"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">RHR004 - Hospital Regional</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">10</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">2,680</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$242,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$38,100</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$30,300</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$14,600</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$325,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$121.27</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$315,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 3px 6px; border-radius: 3px; font-size: 11px;">+3.2%</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del proyecto')" title="Ver detalle"></i>
                                    <i class="fas fa-chart-line" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver evolución')" title="Ver evolución"></i>
                                    <i class="fas fa-download" style="color: #6c757d; margin: 0 5px; cursor: pointer;" onclick="alert('Descargar reporte')" title="Descargar reporte"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">VPS005 - Periférico Sur</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">6</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">1,450</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$108,500</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$17,100</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$13,600</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$5,800</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$145,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$100.00</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$140,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 3px 6px; border-radius: 3px; font-size: 11px;">+3.6%</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del proyecto')" title="Ver detalle"></i>
                                    <i class="fas fa-chart-line" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver evolución')" title="Ver evolución"></i>
                                    <i class="fas fa-download" style="color: #6c757d; margin: 0 5px; cursor: pointer;" onclick="alert('Descargar reporte')" title="Descargar reporte"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">PGA006 - Plaza Galerías</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">4</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">980</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$72,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$11,300</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$9,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$3,700</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$96,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$97.96</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$95,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 3px 6px; border-radius: 3px; font-size: 11px;">+1.1%</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del proyecto')" title="Ver detalle"></i>
                                    <i class="fas fa-chart-line" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver evolución')" title="Ver evolución"></i>
                                    <i class="fas fa-download" style="color: #6c757d; margin: 0 5px; cursor: pointer;" onclick="alert('Descargar reporte')" title="Descargar reporte"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">CCM007 - Centro Comercial</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">3</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">720</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$58,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$9,100</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$7,200</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$3,200</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$77,500</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$107.64</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$75,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 3px 6px; border-radius: 3px; font-size: 11px;">+3.3%</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del proyecto')" title="Ver detalle"></i>
                                    <i class="fas fa-chart-line" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver evolución')" title="Ver evolución"></i>
                                    <i class="fas fa-download" style="color: #6c757d; margin: 0 5px; cursor: pointer;" onclick="alert('Descargar reporte')" title="Descargar reporte"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">UAN008 - Unidad Anáhuac</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">5</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">1,200</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$89,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$14,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$11,100</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$4,800</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$118,900</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$99.08</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$115,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 3px 6px; border-radius: 3px; font-size: 11px;">+3.4%</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del proyecto')" title="Ver detalle"></i>
                                    <i class="fas fa-chart-line" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver evolución')" title="Ver evolución"></i>
                                    <i class="fas fa-download" style="color: #6c757d; margin: 0 5px; cursor: pointer;" onclick="alert('Descargar reporte')" title="Descargar reporte"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">PIR009 - Parque Roble</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">7</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">1,680</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$124,500</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$19,600</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$15,500</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$6,400</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$166,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$98.81</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$160,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 3px 6px; border-radius: 3px; font-size: 11px;">+3.8%</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del proyecto')" title="Ver detalle"></i>
                                    <i class="fas fa-chart-line" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver evolución')" title="Ver evolución"></i>
                                    <i class="fas fa-download" style="color: #6c757d; margin: 0 5px; cursor: pointer;" onclick="alert('Descargar reporte')" title="Descargar reporte"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">EST010 - Estadio Universitario</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">12</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">2,880</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$213,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$33,500</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$26,600</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$11,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$284,100</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$98.65</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$275,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 3px 6px; border-radius: 3px; font-size: 11px;">+3.3%</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del proyecto')" title="Ver detalle"></i>
                                    <i class="fas fa-chart-line" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver evolución')" title="Ver evolución"></i>
                                    <i class="fas fa-download" style="color: #6c757d; margin: 0 5px; cursor: pointer;" onclick="alert('Descargar reporte')" title="Descargar reporte"></i>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;" colspan="2">TOTALES:</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">24,880</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">$2,376,800</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">$374,250</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">$297,250</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">$149,500</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">$3,197,800</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">$128.50</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: right;">$3,110,000</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">+2.8%</td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #e9ecef; box-shadow: -2px 0 5px rgba(0,0,0,0.1);"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Botón Crear filtro -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA DETALLE DE PROYECTO (ejemplo) -->
<div id="modalDetalleProyecto" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 700px; max-height: 80vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Detalle de Costos - <span id="modalProyecto">TRC001</span></h3>
            <button onclick="cerrarModalDetalle()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;" id="modalContenido">
            <!-- Contenido dinámico -->
            <p style="text-align: center; color: #6c757d;">Seleccione un proyecto para ver su detalle</p>
        </div>
    </div>
</div>

<style>
    :root {
        --color-primary: #083CAE;
        --color-secondary: #2CBF1F;
        --color-accent: #eaf512;
        --color-red: #FF0000;
    }

    /* Estilos generales */
    .semaforo .card-header h2 {
        color: var(--color-primary) !important;
    }
    
    /* Tabla */
    .table-container {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        overflow-x: auto;
        background-color: white;
        width: 100%;
        max-height: 450px;
        overflow-y: auto;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        scrollbar-width: thin;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        min-width: 1200px;
    }

    .table th {
        background-color: var(--color-primary) !important;
        color: white;
        padding: 12px 8px;
        border: 1px solid #dee2e6;
        font-size: 12px;
        white-space: nowrap;
        text-align: center;
        font-weight: 600;
    }
    
    .table td {
        padding: 10px 8px;
        border: 1px solid #dee2e6;
        font-size: 12px;
        vertical-align: middle;
    }
    
    /* Filas alternadas */
    tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    tbody tr:hover {
        background-color: #e8f0fe;
    }
    
    /* Columna de acciones fija */
    .table th:last-child,
    .table td:last-child {
        position: sticky !important;
        right: 0 !important;
        z-index: 35 !important;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1) !important;
    }
    
    .table th:last-child {
        background-color: var(--color-primary) !important;
    }
    
    .table td:last-child {
        background-color: white !important;
        text-align: center !important;
    }
    
    tbody tr:nth-child(even) td:last-child {
        background-color: #f8f9fa !important;
    }
    
    tbody tr:hover td:last-child {
        background-color: #e8f0fe !important;
    }
    
    /* Iconos de acción */
    .table td:last-child i {
        margin: 0 5px;
        font-size: 13px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .table td:last-child i:hover {
        transform: scale(1.2);
    }
    
    /* Drag & drop */
    [draggable="true"] {
        cursor: grab;
    }
    
    .columna-agrupada {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        background-color: #e8f0fe;
        border-radius: 4px;
        color: var(--color-primary);
        font-size: 11px;
        border: 1px solid var(--color-primary);
    }
    
    .columna-agrupada .remover {
        margin-left: 5px;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
        color: var(--color-primary);
    }
    
    /* Scroll personalizado */
    .table-container::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    .table-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .table-container::-webkit-scrollbar-thumb {
        background: var(--color-primary);
        border-radius: 4px;
    }
    
    /* Modal */
    #modalDetalleProyecto {
        display: none;
        align-items: center;
        justify-content: center;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .hide-mobile {
            display: none !important;
        }
        
        div[style*="grid-template-columns: repeat(5, 1fr)"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        div[style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        .table-container {
            max-height: 400px;
        }
        
        .table td {
            padding: 8px 4px;
            font-size: 11px;
        }
        
        .table td:last-child i {
            margin: 0 3px;
            font-size: 11px;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadas = [];
    
    // Función para mostrar detalle del proyecto
    window.verDetalleProyecto = function(proyecto) {
        const modal = document.getElementById('modalDetalleProyecto');
        document.getElementById('modalProyecto').textContent = proyecto;
        
        // Contenido de ejemplo
        let contenido = `
            <div style="margin-bottom: 15px;">
                <h4 style="color: var(--color-primary); margin: 0 0 10px 0;">Desglose de Costos</h4>
                <table style="width:100%; border-collapse:collapse; font-size:13px;">
                    <tr><td style="padding:8px; border-bottom:1px solid #dee2e6;"><strong>Sueldos base:</strong></td><td style="padding:8px; text-align:right;">$625,300</td></tr>
                    <tr><td style="padding:8px; border-bottom:1px solid #dee2e6;"><strong>Prestaciones:</strong></td><td style="padding:8px; text-align:right;">$98,450</td></tr>
                    <tr><td style="padding:8px; border-bottom:1px solid #dee2e6;"><strong>IMSS (cuotas patronales):</strong></td><td style="padding:8px; text-align:right;">$78,250</td></tr>
                    <tr><td style="padding:8px; border-bottom:1px solid #dee2e6;"><strong>INFONAVIT:</strong></td><td style="padding:8px; text-align:right;">$42,800</td></tr>
                    <tr style="font-weight:bold; background-color:#f8f9fa;"><td style="padding:8px;">TOTAL:</td><td style="padding:8px; text-align:right;">$844,800</td></tr>
                </table>
            </div>
            <div>
                <h4 style="color: var(--color-primary); margin: 0 0 10px 0;">Distribución por área</h4>
                <table style="width:100%; border-collapse:collapse; font-size:13px;">
                    <thead><tr style="background-color:#f8f9fa;"><th style="padding:8px; text-align:left;">Área</th><th style="padding:8px; text-align:right;">Empleados</th><th style="padding:8px; text-align:right;">Costo</th></tr></thead>
                    <tbody>
                        <tr><td style="padding:8px;">Operación</td><td style="padding:8px; text-align:center;">12</td><td style="padding:8px; text-align:right;">$425,300</td></tr>
                        <tr><td style="padding:8px;">Seguridad</td><td style="padding:8px; text-align:center;">4</td><td style="padding:8px; text-align:right;">$125,500</td></tr>
                        <tr><td style="padding:8px;">Administración</td><td style="padding:8px; text-align:center;">5</td><td style="padding:8px; text-align:right;">$185,000</td></tr>
                        <tr><td style="padding:8px;">Mantenimiento</td><td style="padding:8px; text-align:center;">3</td><td style="padding:8px; text-align:right;">$109,000</td></tr>
                    </tbody>
                </table>
            </div>
        `;
        
        document.getElementById('modalContenido').innerHTML = contenido;
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalDetalle = function() {
        document.getElementById('modalDetalleProyecto').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalDetalle();
        }
    });
    
    // Cerrar modal al hacer clic fuera
    document.getElementById('modalDetalleProyecto').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalDetalle();
        }
    });
    
    // Funciones de agrupación y selector de columnas
    function actualizarGrupoColumnas() {
        const container = document.getElementById('grupoColumnas');
        const texto = document.getElementById('textoAgrupar');
        
        container.innerHTML = '';
        
        if (columnasAgrupadas.length === 0) {
            texto.style.display = 'inline';
        } else {
            texto.style.display = 'none';
            columnasAgrupadas.forEach(col => {
                const chip = document.createElement('span');
                chip.className = 'columna-agrupada';
                chip.innerHTML = `${col} <span class="remover" onclick="removerColumna('${col}')">&times;</span>`;
                container.appendChild(chip);
            });
        }
    }

    window.removerColumna = function(columna) {
        columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
        actualizarGrupoColumnas();
    };

    // Drag & drop
    document.addEventListener('dragstart', (e) => {
        if (e.target.tagName === 'TH' && e.target.draggable) {
            e.dataTransfer.setData('text/plain', e.target.dataset.columna);
        }
    });

    document.getElementById('grupoAgrupacion').addEventListener('dragover', (e) => e.preventDefault());
    
    document.getElementById('grupoAgrupacion').addEventListener('drop', (e) => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadas.includes(columna)) {
            columnasAgrupadas.push(columna);
            actualizarGrupoColumnas();
            alert('Agrupando por: ' + columna);
        }
    });

    // Selector de columnas
    window.toggleColumnSelector = function() {
        const selector = document.getElementById('columnSelector');
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
        
        if (selector.style.display === 'block') {
            const columnas = [
                { field: 'proyecto', caption: 'Proyecto' },
                { field: 'empleados', caption: 'Empleados' },
                { field: 'horas', caption: 'Horas Hombre' },
                { field: 'sueldos', caption: 'Sueldos' },
                { field: 'prestaciones', caption: 'Prestaciones' },
                { field: 'imss', caption: 'IMSS' },
                { field: 'infonavit', caption: 'INFONAVIT' },
                { field: 'total', caption: 'Total' },
                { field: 'costo_hora', caption: 'Costo/Hora' },
                { field: 'presupuesto', caption: 'Presupuesto' },
                { field: 'desviacion', caption: 'Desviación' }
            ];
            
            const lista = document.getElementById('columnasLista');
            lista.innerHTML = columnas.map(col => `
                <div style="padding: 5px 0; display: flex; align-items: center;">
                    <input type="checkbox" 
                           id="chk_${col.field}"
                           data-columna="${col.field}"
                           checked
                           style="margin-right: 8px; accent-color: var(--color-primary);">
                    <label for="chk_${col.field}" style="font-size: 12px;">${col.caption}</label>
                </div>
            `).join('');
        }
    };

    window.cerrarColumnSelector = function() {
        document.getElementById('columnSelector').style.display = 'none';
    };

    // Cerrar selector al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#btnColumnas') && !e.target.closest('#columnSelector')) {
            document.getElementById('columnSelector').style.display = 'none';
        }
    });
});
</script>
@endsection