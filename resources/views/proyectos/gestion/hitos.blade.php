@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Cronogramas y Hitos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Cronogramas y Hitos de Proyectos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros y controles principales -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <!-- Selector de proyecto -->
                        <div>
                            <select id="selectorProyecto" style="padding: 10px 15px; border: 1px solid #ced4da; border-radius: 8px; font-size: 14px; min-width: 250px;">
                                <option value="">Todos los proyectos</option>
                                <option value="PRO-2024-001">PRO-2024-001 - Torre Norte Corporativa</option>
                                <option value="PRO-2024-002">PRO-2024-002 - Puente Vehicular Sur</option>
                                <option value="PRO-2024-003">PRO-2024-003 - Parque Industrial Norte</option>
                                <option value="PRO-2024-004">PRO-2024-004 - Hospital Regional</option>
                                <option value="PRO-2024-005">PRO-2024-005 - Planta Tratamiento</option>
                                <option value="PRO-2024-006">PRO-2024-006 - Urbanización Los Álamos</option>
                            </select>
                        </div>

                        <!-- Selector de vista -->
                        <div style="display: flex; gap: 5px; background-color: #e9ecef; padding: 4px; border-radius: 8px;">
                            <button class="vista-btn active" data-vista="calendario" style="padding: 8px 15px; background-color: #083CAE; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                                <i class="fas fa-calendar"></i> Calendario
                            </button>
                            <button class="vista-btn" data-vista="gantt" style="padding: 8px 15px; background-color: transparent; color: #495057; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                                <i class="fas fa-chart-bar"></i> Diagrama Gantt
                            </button>
                            <button class="vista-btn" data-vista="lista" style="padding: 8px 15px; background-color: transparent; color: #495057; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                                <i class="fas fa-list"></i> Lista
                            </button>
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <!-- Rango de fechas -->
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <input type="date" id="fechaInicio" value="2026-01-01" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <span style="color: #6c757d;">a</span>
                            <input type="date" id="fechaFin" value="2026-12-31" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                        </div>

                        <!-- Botones de acción -->
                        <button id="btnNuevoHito" style="padding: 8px 15px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-plus"></i> Nuevo Hito
                        </button>
                        <button id="btnExportar" style="padding: 8px 15px; background-color: white; border: 1px solid #083CAE; color: #083CAE; border-radius: 4px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-download"></i> Exportar
                        </button>
                    </div>
                </div>

                <!-- Resumen de hitos -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px;">
                    <div class="resumen-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; background-color: #e8f0fe; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-flag-checkered" style="color: #083CAE;"></i>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #6c757d;">Total Hitos</div>
                                <div style="font-size: 24px; font-weight: bold; color: #083CAE;">156</div>
                            </div>
                        </div>
                    </div>

                    <div class="resumen-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; background-color: #d4edda; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check-circle" style="color: #28a745;"></i>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #6c757d;">Completados</div>
                                <div style="font-size: 24px; font-weight: bold; color: #28a745;">89</div>
                            </div>
                        </div>
                    </div>

                    <div class="resumen-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; background-color: #fff3cd; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-clock" style="color: #ffc107;"></i>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #6c757d;">En Proceso</div>
                                <div style="font-size: 24px; font-weight: bold; color: #ffc107;">42</div>
                            </div>
                        </div>
                    </div>

                    <div class="resumen-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; background-color: #f8d7da; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #6c757d;">Retrasados</div>
                                <div style="font-size: 24px; font-weight: bold; color: #dc3545;">25</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- VISTA CALENDARIO -->
                <div id="vista-calendario" class="vista-content active">
                    <!-- Selector de mes -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div style="display: flex; gap: 10px;">
                            <button class="mes-btn" id="btnMesAnterior" style="padding: 8px 15px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <h3 style="font-size: 18px; font-weight: 600; color: #083CAE; margin: 0;" id="mesActual">Marzo 2026</h3>
                            <button class="mes-btn" id="btnMesSiguiente" style="padding: 8px 15px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                        <button class="btn-hoy" id="btnHoy" style="padding: 8px 15px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Hoy</button>
                    </div>

                    <!-- Días de la semana -->
                    <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px; margin-bottom: 5px;">
                        <div style="text-align: center; font-weight: 600; color: #083CAE; padding: 10px;">Lun</div>
                        <div style="text-align: center; font-weight: 600; color: #083CAE; padding: 10px;">Mar</div>
                        <div style="text-align: center; font-weight: 600; color: #083CAE; padding: 10px;">Mié</div>
                        <div style="text-align: center; font-weight: 600; color: #083CAE; padding: 10px;">Jue</div>
                        <div style="text-align: center; font-weight: 600; color: #083CAE; padding: 10px;">Vie</div>
                        <div style="text-align: center; font-weight: 600; color: #6c757d; padding: 10px;">Sáb</div>
                        <div style="text-align: center; font-weight: 600; color: #6c757d; padding: 10px;">Dom</div>
                    </div>

                    <!-- Grid del calendario -->
                    <div id="calendarioGrid" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px; min-height: 600px;">
                        <!-- Los días se generarán dinámicamente con JavaScript -->
                    </div>

                    <!-- Leyenda de colores -->
                    <div style="display: flex; gap: 20px; margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 8px; flex-wrap: wrap;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 16px; height: 16px; background-color: #083CAE; border-radius: 3px;"></div>
                            <span style="font-size: 12px;">Hitos Críticos</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 16px; height: 16px; background-color: #28a745; border-radius: 3px;"></div>
                            <span style="font-size: 12px;">Completados</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 16px; height: 16px; background-color: #ffc107; border-radius: 3px;"></div>
                            <span style="font-size: 12px;">En Proceso</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 16px; height: 16px; background-color: #dc3545; border-radius: 3px;"></div>
                            <span style="font-size: 12px;">Retrasados</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 16px; height: 16px; background-color: #6c757d; border-radius: 3px;"></div>
                            <span style="font-size: 12px;">Días no laborables</span>
                        </div>
                    </div>
                </div>

                <!-- VISTA GANTT -->
                <div id="vista-gantt" class="vista-content" style="display: none;">
                    <div style="overflow-x: auto; margin-top: 20px;">
                        <div style="min-width: 1200px;">
                            <!-- Timeline de meses -->
                            <div style="display: flex; margin-bottom: 20px; border-bottom: 2px solid #083CAE; position: sticky; top: 0; background-color: white; z-index: 10;">
                                <div style="width: 300px; padding: 10px; font-weight: 600; color: #083CAE;">Proyecto / Hito</div>
                                <div style="flex: 1; display: flex;">
                                    <div style="flex: 1; text-align: center; font-weight: 600; color: #083CAE; padding: 10px; border-left: 1px solid #dee2e6;">Ene</div>
                                    <div style="flex: 1; text-align: center; font-weight: 600; color: #083CAE; padding: 10px; border-left: 1px solid #dee2e6;">Feb</div>
                                    <div style="flex: 1; text-align: center; font-weight: 600; color: #083CAE; padding: 10px; border-left: 1px solid #dee2e6;">Mar</div>
                                    <div style="flex: 1; text-align: center; font-weight: 600; color: #083CAE; padding: 10px; border-left: 1px solid #dee2e6;">Abr</div>
                                    <div style="flex: 1; text-align: center; font-weight: 600; color: #083CAE; padding: 10px; border-left: 1px solid #dee2e6;">May</div>
                                    <div style="flex: 1; text-align: center; font-weight: 600; color: #083CAE; padding: 10px; border-left: 1px solid #dee2e6;">Jun</div>
                                    <div style="flex: 1; text-align: center; font-weight: 600; color: #083CAE; padding: 10px; border-left: 1px solid #dee2e6;">Jul</div>
                                    <div style="flex: 1; text-align: center; font-weight: 600; color: #083CAE; padding: 10px; border-left: 1px solid #dee2e6;">Ago</div>
                                    <div style="flex: 1; text-align: center; font-weight: 600; color: #083CAE; padding: 10px; border-left: 1px solid #dee2e6;">Sep</div>
                                    <div style="flex: 1; text-align: center; font-weight: 600; color: #083CAE; padding: 10px; border-left: 1px solid #dee2e6;">Oct</div>
                                    <div style="flex: 1; text-align: center; font-weight: 600; color: #083CAE; padding: 10px; border-left: 1px solid #dee2e6;">Nov</div>
                                    <div style="flex: 1; text-align: center; font-weight: 600; color: #083CAE; padding: 10px; border-left: 1px solid #dee2e6;">Dic</div>
                                </div>
                            </div>

                            <!-- PRO-2024-001 Torre Norte -->
                            <div style="margin-bottom: 20px;">
                                <div style="display: flex; align-items: center; background-color: #e8f0fe; padding: 12px; border-radius: 4px; margin-bottom: 5px; cursor: pointer;" onclick="toggleHitos('proyecto1')">
                                    <div style="width: 300px; font-weight: 600; color: #083CAE;">
                                        <i class="fas fa-chevron-down" id="icono-proyecto1" style="margin-right: 10px;"></i>
                                        PRO-2024-001 - Torre Norte Corporativa
                                    </div>
                                    <div style="flex: 1; display: flex; align-items: center; position: relative; height: 30px;">
                                        <!-- Barra de proyecto principal -->
                                        <div style="position: absolute; left: 0%; width: 75%; height: 20px; background-color: #083CAE; border-radius: 4px; opacity: 0.2;"></div>
                                        <!-- Avance real -->
                                        <div style="position: absolute; left: 0%; width: 65%; height: 20px; background-color: #083CAE; border-radius: 4px;"></div>
                                        <span style="position: absolute; left: 5px; color: white; font-size: 11px; line-height: 20px; z-index: 1;">65%</span>
                                        <!-- Hito -->
                                        <div style="position: absolute; left: 45%; top: -5px; width: 12px; height: 12px; background-color: #ffc107; border: 2px solid white; border-radius: 50%; z-index: 2;" title="Hito: Estructura"></div>
                                    </div>
                                </div>

                                <!-- Hitos del proyecto (inicialmente visibles) -->
                                <div id="hitos-proyecto1" style="margin-left: 30px;">
                                    <div style="display: flex; align-items: center; padding: 8px; border-bottom: 1px dashed #dee2e6;">
                                        <div style="width: 300px; font-size: 13px;">
                                            <i class="fas fa-circle" style="color: #28a745; font-size: 8px; margin-right: 10px;"></i>
                                            Cimentación
                                        </div>
                                        <div style="flex: 1; display: flex; align-items: center; position: relative; height: 25px;">
                                            <div style="position: absolute; left: 0%; width: 20%; height: 15px; background-color: #28a745; border-radius: 2px;"></div>
                                            <span style="position: absolute; left: 2%; color: #155724; font-size: 10px; line-height: 15px;">Completado</span>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; padding: 8px; border-bottom: 1px dashed #dee2e6;">
                                        <div style="width: 300px; font-size: 13px;">
                                            <i class="fas fa-circle" style="color: #ffc107; font-size: 8px; margin-right: 10px;"></i>
                                            Estructura
                                        </div>
                                        <div style="flex: 1; display: flex; align-items: center; position: relative; height: 25px;">
                                            <div style="position: absolute; left: 20%; width: 25%; height: 15px; background-color: #ffc107; border-radius: 2px;"></div>
                                            <span style="position: absolute; left: 22%; color: #856404; font-size: 10px; line-height: 15px;">En Proceso</span>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; padding: 8px;">
                                        <div style="width: 300px; font-size: 13px;">
                                            <i class="fas fa-circle" style="color: #6c757d; font-size: 8px; margin-right: 10px;"></i>
                                            Acabados
                                        </div>
                                        <div style="flex: 1; display: flex; align-items: center; position: relative; height: 25px;">
                                            <div style="position: absolute; left: 45%; width: 15%; height: 15px; background-color: #6c757d; border-radius: 2px; opacity: 0.5;"></div>
                                            <span style="position: absolute; left: 47%; color: #6c757d; font-size: 10px; line-height: 15px;">Programado</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PRO-2024-002 Puente Sur -->
                            <div style="margin-bottom: 20px;">
                                <div style="display: flex; align-items: center; background-color: #f8d7da; padding: 12px; border-radius: 4px; margin-bottom: 5px; cursor: pointer;" onclick="toggleHitos('proyecto2')">
                                    <div style="width: 300px; font-weight: 600; color: #dc3545;">
                                        <i class="fas fa-chevron-down" id="icono-proyecto2" style="margin-right: 10px;"></i>
                                        PRO-2024-002 - Puente Vehicular Sur
                                    </div>
                                    <div style="flex: 1; display: flex; align-items: center; position: relative; height: 30px;">
                                        <div style="position: absolute; left: 0%; width: 50%; height: 20px; background-color: #dc3545; border-radius: 4px; opacity: 0.2;"></div>
                                        <div style="position: absolute; left: 0%; width: 35%; height: 20px; background-color: #dc3545; border-radius: 4px;"></div>
                                        <span style="position: absolute; left: 5px; color: white; font-size: 11px; line-height: 20px;">35%</span>
                                        <div style="position: absolute; left: 15%; top: -5px; width: 12px; height: 12px; background-color: #dc3545; border: 2px solid white; border-radius: 50%;" title="Hito: Pilotaje retrasado"></div>
                                    </div>
                                </div>

                                <div id="hitos-proyecto2" style="margin-left: 30px;">
                                    <div style="display: flex; align-items: center; padding: 8px;">
                                        <div style="width: 300px; font-size: 13px;">
                                            <i class="fas fa-circle" style="color: #dc3545; font-size: 8px; margin-right: 10px;"></i>
                                            Pilotaje
                                        </div>
                                        <div style="flex: 1; display: flex; align-items: center; position: relative; height: 25px;">
                                            <div style="position: absolute; left: 5%; width: 15%; height: 15px; background-color: #dc3545; border-radius: 2px;"></div>
                                            <span style="position: absolute; left: 7%; color: #721c24; font-size: 10px; line-height: 15px;">Retrasado</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PRO-2024-003 Parque Industrial -->
                            <div style="margin-bottom: 20px;">
                                <div style="display: flex; align-items: center; background-color: #d4edda; padding: 12px; border-radius: 4px; margin-bottom: 5px; cursor: pointer;" onclick="toggleHitos('proyecto3')">
                                    <div style="width: 300px; font-weight: 600; color: #28a745;">
                                        <i class="fas fa-chevron-down" id="icono-proyecto3" style="margin-right: 10px;"></i>
                                        PRO-2024-003 - Parque Industrial Norte
                                    </div>
                                    <div style="flex: 1; display: flex; align-items: center; position: relative; height: 30px;">
                                        <div style="position: absolute; left: 0%; width: 30%; height: 20px; background-color: #28a745; border-radius: 4px; opacity: 0.2;"></div>
                                        <div style="position: absolute; left: 0%; width: 25%; height: 20px; background-color: #28a745; border-radius: 4px;"></div>
                                        <span style="position: absolute; left: 5px; color: white; font-size: 11px; line-height: 20px;">25%</span>
                                    </div>
                                </div>

                                <div id="hitos-proyecto3" style="margin-left: 30px;">
                                    <div style="display: flex; align-items: center; padding: 8px;">
                                        <div style="width: 300px; font-size: 13px;">
                                            <i class="fas fa-circle" style="color: #28a745; font-size: 8px; margin-right: 10px;"></i>
                                            Nivelación
                                        </div>
                                        <div style="flex: 1; display: flex; align-items: center; position: relative; height: 25px;">
                                            <div style="position: absolute; left: 0%; width: 10%; height: 15px; background-color: #28a745; border-radius: 2px;"></div>
                                            <span style="position: absolute; left: 2%; color: #155724; font-size: 10px; line-height: 15px;">Completado</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PRO-2024-004 Hospital Regional -->
                            <div style="margin-bottom: 20px;">
                                <div style="display: flex; align-items: center; background-color: #cff4fc; padding: 12px; border-radius: 4px; margin-bottom: 5px; cursor: pointer;" onclick="toggleHitos('proyecto4')">
                                    <div style="width: 300px; font-weight: 600; color: #0dcaf0;">
                                        <i class="fas fa-chevron-down" id="icono-proyecto4" style="margin-right: 10px;"></i>
                                        PRO-2024-004 - Hospital Regional
                                    </div>
                                    <div style="flex: 1; display: flex; align-items: center; position: relative; height: 30px;">
                                        <div style="position: absolute; left: 0%; width: 100%; height: 20px; background-color: #0dcaf0; border-radius: 4px; opacity: 0.2;"></div>
                                        <div style="position: absolute; left: 0%; width: 100%; height: 20px; background-color: #0dcaf0; border-radius: 4px;"></div>
                                        <span style="position: absolute; left: 5px; color: white; font-size: 11px; line-height: 20px;">100%</span>
                                        <div style="position: absolute; right: 5px; color: white; font-size: 11px; line-height: 20px;">Completado</div>
                                    </div>
                                </div>

                                <div id="hitos-proyecto4" style="margin-left: 30px;">
                                    <div style="display: flex; align-items: center; padding: 8px; border-bottom: 1px dashed #dee2e6;">
                                        <div style="width: 300px; font-size: 13px;">
                                            <i class="fas fa-circle" style="color: #28a745; font-size: 8px; margin-right: 10px;"></i>
                                            Cimentación
                                        </div>
                                        <div style="flex: 1; display: flex; align-items: center; position: relative; height: 25px;">
                                            <div style="position: absolute; left: 0%; width: 100%; height: 15px; background-color: #28a745; border-radius: 2px;"></div>
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: center; padding: 8px; border-bottom: 1px dashed #dee2e6;">
                                        <div style="width: 300px; font-size: 13px;">
                                            <i class="fas fa-circle" style="color: #28a745; font-size: 8px; margin-right: 10px;"></i>
                                            Estructura
                                        </div>
                                        <div style="flex: 1; display: flex; align-items: center; position: relative; height: 25px;">
                                            <div style="position: absolute; left: 20%; width: 100%; height: 15px; background-color: #28a745; border-radius: 2px;"></div>
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: center; padding: 8px;">
                                        <div style="width: 300px; font-size: 13px;">
                                            <i class="fas fa-circle" style="color: #28a745; font-size: 8px; margin-right: 10px;"></i>
                                            Acabados
                                        </div>
                                        <div style="flex: 1; display: flex; align-items: center; position: relative; height: 25px;">
                                            <div style="position: absolute; left: 45%; width: 100%; height: 15px; background-color: #28a745; border-radius: 2px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PRO-2024-005 Planta Tratamiento -->
                            <div style="margin-bottom: 20px;">
                                <div style="display: flex; align-items: center; background-color: #fff3cd; padding: 12px; border-radius: 4px; margin-bottom: 5px; cursor: pointer;" onclick="toggleHitos('proyecto5')">
                                    <div style="width: 300px; font-weight: 600; color: #ffc107;">
                                        <i class="fas fa-chevron-down" id="icono-proyecto5" style="margin-right: 10px;"></i>
                                        PRO-2024-005 - Planta Tratamiento
                                    </div>
                                    <div style="flex: 1; display: flex; align-items: center; position: relative; height: 30px;">
                                        <div style="position: absolute; left: 0%; width: 60%; height: 20px; background-color: #ffc107; border-radius: 4px; opacity: 0.2;"></div>
                                        <div style="position: absolute; left: 0%; width: 45%; height: 20px; background-color: #ffc107; border-radius: 4px;"></div>
                                        <span style="position: absolute; left: 5px; color: #856404; font-size: 11px; line-height: 20px;">45%</span>
                                    </div>
                                </div>

                                <div id="hitos-proyecto5" style="margin-left: 30px;">
                                    <div style="display: flex; align-items: center; padding: 8px;">
                                        <div style="width: 300px; font-size: 13px;">
                                            <i class="fas fa-circle" style="color: #ffc107; font-size: 8px; margin-right: 10px;"></i>
                                            Instalación de Equipo
                                        </div>
                                        <div style="flex: 1; display: flex; align-items: center; position: relative; height: 25px;">
                                            <div style="position: absolute; left: 15%; width: 20%; height: 15px; background-color: #ffc107; border-radius: 2px;"></div>
                                            <span style="position: absolute; left: 17%; color: #856404; font-size: 10px; line-height: 15px;">En Proceso</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Controles de zoom y escala -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 10px; background-color: #f8f9fa; border-radius: 8px;">
                        <div style="display: flex; gap: 10px;">
                            <button id="btnZoomOut" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-search-minus"></i>
                            </button>
                            <button id="btnZoomIn" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-search-plus"></i>
                            </button>
                            <select id="escalaGantt" style="padding: 5px 10px; border: 1px solid #dee2e6; border-radius: 4px;">
                                <option value="mes">Vista Mensual</option>
                                <option value="semana">Vista Semanal</option>
                                <option value="trimestre">Vista Trimestral</option>
                            </select>
                        </div>
                        <div style="display: flex; gap: 15px;">
                            <span style="font-size: 12px;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #083CAE; border-radius: 2px; margin-right: 5px;"></span> Progreso real</span>
                            <span style="font-size: 12px;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #083CAE; opacity: 0.2; border-radius: 2px; margin-right: 5px;"></span> Progreso planeado</span>
                            <span style="font-size: 12px;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #ffc107; border-radius: 50%; margin-right: 5px;"></span> Hito</span>
                        </div>
                    </div>
                </div>

                <!-- VISTA LISTA -->
                <div id="vista-lista" class="vista-content" style="display: none;">
                    <!-- Filtros rápidos -->
                    <div style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                        <button class="filtro-hito active" data-filtro="todos" style="padding: 8px 15px; background-color: #083CAE; color: white; border: none; border-radius: 20px; cursor: pointer; font-size: 12px;">Todos</button>
                        <button class="filtro-hito" data-filtro="criticos" style="padding: 8px 15px; background-color: white; border: 1px solid #dee2e6; border-radius: 20px; cursor: pointer; font-size: 12px;">Críticos</button>
                        <button class="filtro-hito" data-filtro="completados" style="padding: 8px 15px; background-color: white; border: 1px solid #dee2e6; border-radius: 20px; cursor: pointer; font-size: 12px;">Completados</button>
                        <button class="filtro-hito" data-filtro="proceso" style="padding: 8px 15px; background-color: white; border: 1px solid #dee2e6; border-radius: 20px; cursor: pointer; font-size: 12px;">En Proceso</button>
                        <button class="filtro-hito" data-filtro="retrasados" style="padding: 8px 15px; background-color: white; border: 1px solid #dee2e6; border-radius: 20px; cursor: pointer; font-size: 12px;">Retrasados</button>
                        <button class="filtro-hito" data-filtro="proximos" style="padding: 8px 15px; background-color: white; border: 1px solid #dee2e6; border-radius: 20px; cursor: pointer; font-size: 12px;">Próximos 7 días</button>
                    </div>

                    <!-- Tabla de hitos -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse; min-width: 1200px;">
                            <thead style="background-color: #f8f9fa; border-bottom: 2px solid #083CAE;">
                                <tr>
                                    <th style="padding: 12px; text-align: left;">Proyecto</th>
                                    <th style="padding: 12px; text-align: left;">Hito</th>
                                    <th style="padding: 12px; text-align: left;">Responsable</th>
                                    <th style="padding: 12px; text-align: left;">Fecha Programada</th>
                                    <th style="padding: 12px; text-align: left;">Fecha Real</th>
                                    <th style="padding: 12px; text-align: left;">Estado</th>
                                    <th style="padding: 12px; text-align: left;">Avance</th>
                                    <th style="padding: 12px; text-align: left;">Dependencias</th>
                                    <th style="padding: 12px; text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaHitosBody">
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;"><strong>PRO-2024-001</strong><br><small style="color: #6c757d;">Torre Norte</small></td>
                                    <td style="padding: 12px;">Cimentación</td>
                                    <td style="padding: 12px;">Carlos Rodríguez</td>
                                    <td style="padding: 12px;">15/01/2026</td>
                                    <td style="padding: 12px;">10/01/2026</td>
                                    <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Completado</span></td>
                                    <td style="padding: 12px;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 100%; height: 6px; background-color: #28a745; border-radius: 3px;"></div>
                                            </div>
                                            100%
                                        </div>
                                    </td>
                                    <td style="padding: 12px;">-</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalles"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Editar"></i>
                                        <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; margin: 0 5px;" title="Eliminar"></i>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6; background-color: #fff3cd;">
                                    <td style="padding: 12px;"><strong>PRO-2024-001</strong><br><small style="color: #6c757d;">Torre Norte</small></td>
                                    <td style="padding: 12px;">Estructura</td>
                                    <td style="padding: 12px;">Carlos Rodríguez</td>
                                    <td style="padding: 12px;">15/03/2026</td>
                                    <td style="padding: 12px;">-</td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 11px;">En Proceso</span></td>
                                    <td style="padding: 12px;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 45%; height: 6px; background-color: #ffc107; border-radius: 3px;"></div>
                                            </div>
                                            45%
                                        </div>
                                    </td>
                                    <td style="padding: 12px;">Cimentación</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;"><strong>PRO-2024-002</strong><br><small style="color: #6c757d;">Puente Sur</small></td>
                                    <td style="padding: 12px;">Pilotaje</td>
                                    <td style="padding: 12px;">María García</td>
                                    <td style="padding: 12px;">05/02/2026</td>
                                    <td style="padding: 12px;">-</td>
                                    <td style="padding: 12px;"><span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Retrasado</span></td>
                                    <td style="padding: 12px;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 35%; height: 6px; background-color: #dc3545; border-radius: 3px;"></div>
                                            </div>
                                            35%
                                        </div>
                                    </td>
                                    <td style="padding: 12px;">-</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;"><strong>PRO-2024-003</strong><br><small style="color: #6c757d;">Parque Industrial</small></td>
                                    <td style="padding: 12px;">Nivelación</td>
                                    <td style="padding: 12px;">Ana Martínez</td>
                                    <td style="padding: 12px;">20/02/2026</td>
                                    <td style="padding: 12px;">18/02/2026</td>
                                    <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Completado</span></td>
                                    <td style="padding: 12px;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 100%; height: 6px; background-color: #28a745; border-radius: 3px;"></div>
                                            </div>
                                            100%
                                        </div>
                                    </td>
                                    <td style="padding: 12px;">-</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6; background-color: #f8d7da;">
                                    <td style="padding: 12px;"><strong>PRO-2024-005</strong><br><small style="color: #6c757d;">Planta Tratamiento</small></td>
                                    <td style="padding: 12px;">Entrega de Equipo</td>
                                    <td style="padding: 12px;">Juan Pérez</td>
                                    <td style="padding: 12px;">15/03/2026</td>
                                    <td style="padding: 12px;">-</td>
                                    <td style="padding: 12px;"><span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Retrasado</span></td>
                                    <td style="padding: 12px;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 45%; height: 6px; background-color: #dc3545; border-radius: 3px;"></div>
                                            </div>
                                            45%
                                        </div>
                                    </td>
                                    <td style="padding: 12px;">-</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;"><strong>PRO-2024-001</strong><br><small style="color: #6c757d;">Torre Norte</small></td>
                                    <td style="padding: 12px;">Acabados</td>
                                    <td style="padding: 12px;">Carlos Rodríguez</td>
                                    <td style="padding: 12px;">15/06/2026</td>
                                    <td style="padding: 12px;">-</td>
                                    <td style="padding: 12px;"><span style="background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Programado</span></td>
                                    <td style="padding: 12px;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 0%; height: 6px; background-color: #6c757d; border-radius: 3px;"></div>
                                            </div>
                                            0%
                                        </div>
                                    </td>
                                    <td style="padding: 12px;">Estructura</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                        <div style="display: flex; gap: 5px;">
                            <button class="btn-paginacion" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <span style="padding: 5px 10px; background-color: #083CAE; color: white; border-radius: 4px;">1</span>
                            <button class="btn-paginacion" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">2</button>
                            <button class="btn-paginacion" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">3</button>
                            <button class="btn-paginacion" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">4</button>
                            <button class="btn-paginacion" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">5</button>
                            <button class="btn-paginacion" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                        <span style="color: #6c757d; font-size: 13px;">Mostrando 1-6 de 156 hitos</span>
                    </div>
                </div>

                <!-- Modal para Nuevo Hito (oculto por defecto) -->
                <div id="modalNuevoHito" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
                    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
                        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
                            <h3 style="margin: 0; color: #083CAE;"><i class="fas fa-flag"></i> Nuevo Hito</h3>
                            <button id="btnCerrarModal" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #6c757d;">&times;</button>
                        </div>
                        <div style="padding: 20px;">
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Proyecto <span style="color: #dc3545;">*</span></label>
                                <select id="modalProyecto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                    <option value="">Seleccionar proyecto...</option>
                                    <option value="PRO-2024-001">PRO-2024-001 - Torre Norte Corporativa</option>
                                    <option value="PRO-2024-002">PRO-2024-002 - Puente Vehicular Sur</option>
                                    <option value="PRO-2024-003">PRO-2024-003 - Parque Industrial Norte</option>
                                    <option value="PRO-2024-004">PRO-2024-004 - Hospital Regional</option>
                                    <option value="PRO-2024-005">PRO-2024-005 - Planta Tratamiento</option>
                                </select>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nombre del Hito <span style="color: #dc3545;">*</span></label>
                                <input type="text" id="modalNombreHito" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: Inicio de Cimentación">
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                                <div>
                                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha Programada <span style="color: #dc3545;">*</span></label>
                                    <input type="date" id="modalFechaProgramada" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Hora</label>
                                    <input type="time" id="modalHora" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                </div>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Responsable</label>
                                <select id="modalResponsable" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                    <option value="">Seleccionar responsable...</option>
                                    <option value="juan">Juan Pérez</option>
                                    <option value="maria">María García</option>
                                    <option value="carlos">Carlos Rodríguez</option>
                                    <option value="ana">Ana Martínez</option>
                                    <option value="luis">Luis Ramírez</option>
                                </select>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                                <div>
                                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Prioridad</label>
                                    <select id="modalPrioridad" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                        <option value="alta">Alta</option>
                                        <option value="media" selected>Media</option>
                                        <option value="baja">Baja</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipo</label>
                                    <select id="modalTipo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                        <option value="construccion">Construcción</option>
                                        <option value="entrega">Entrega</option>
                                        <option value="reunion">Reunión</option>
                                        <option value="pago">Pago</option>
                                        <option value="documentacion">Documentación</option>
                                    </select>
                                </div>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Dependencias</label>
                                <select id="modalDependencias" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                    <option value="">Sin dependencias</option>
                                    <option value="cimentacion">Cimentación</option>
                                    <option value="estructura">Estructura</option>
                                    <option value="acabados">Acabados</option>
                                    <option value="nivelacion">Nivelación</option>
                                </select>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción</label>
                                <textarea id="modalDescripcion" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Detalles del hito..."></textarea>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Entregables</label>
                                <div style="display: flex; gap: 10px; margin-bottom: 5px;">
                                    <input type="text" id="nuevoEntregable" style="flex: 1; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: Planos, Reportes">
                                    <button id="btnAgregarEntregable" style="padding: 8px 15px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Agregar</button>
                                </div>
                                <div id="listaEntregables" style="background-color: #f8f9fa; padding: 10px; border-radius: 4px; min-height: 50px;">
                                    <small style="color: #6c757d;">No hay entregables agregados</small>
                                </div>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Notificar a</label>
                                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    <label style="display: flex; align-items: center; gap: 5px;">
                                        <input type="checkbox" value="responsable"> Responsable
                                    </label>
                                    <label style="display: flex; align-items: center; gap: 5px;">
                                        <input type="checkbox" value="equipo"> Equipo del proyecto
                                    </label>
                                    <label style="display: flex; align-items: center; gap: 5px;">
                                        <input type="checkbox" value="cliente"> Cliente
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
                            <button id="btnCancelarHito" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
                            <button id="btnGuardarHito" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Guardar Hito</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .vista-btn {
        transition: all 0.3s ease;
    }
    
    .vista-btn:hover {
        background-color: #e9ecef;
    }
    
    .vista-btn.active {
        background-color: #083CAE !important;
        color: white !important;
    }
    
    .filtro-hito {
        transition: all 0.3s ease;
    }
    
    .filtro-hito:hover {
        background-color: #083CAE;
        color: white;
        border-color: #083CAE;
    }
    
    .filtro-hito.active {
        background-color: #083CAE !important;
        color: white !important;
        border-color: #083CAE !important;
    }
    
    .resumen-card {
        transition: transform 0.2s;
    }
    
    .resumen-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .vista-content {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Estilos para el calendario */
    .calendario-dia {
        background-color: white;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 5px;
        min-height: 100px;
        transition: all 0.2s;
    }
    
    .calendario-dia:hover {
        border-color: #083CAE;
        box-shadow: 0 2px 8px rgba(8, 60, 174, 0.1);
    }
    
    .calendario-dia.otro-mes {
        background-color: #f8f9fa;
        color: #adb5bd;
    }
    
    .calendario-dia.hoy {
        border: 2px solid #083CAE;
    }
    
    .evento-hito {
        background-color: #e8f0fe;
        border-left: 3px solid #083CAE;
        padding: 3px;
        margin-bottom: 3px;
        font-size: 11px;
        border-radius: 2px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .evento-hito:hover {
        background-color: #d0e0ff;
        transform: translateX(2px);
    }
    
    .evento-hito.completado {
        background-color: #d4edda;
        border-left-color: #28a745;
    }
    
    .evento-hito.proceso {
        background-color: #fff3cd;
        border-left-color: #ffc107;
    }
    
    .evento-hito.retrasado {
        background-color: #f8d7da;
        border-left-color: #dc3545;
    }
    
    /* Scrollbar personalizada */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #083CAE;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #052a6b;
    }
    
    /* Tooltip personalizado */
    .tooltip {
        position: relative;
        display: inline-block;
    }
    
    .tooltip .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        margin-left: -60px;
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .resumen-card {
            min-width: 100%;
        }
        
        .vista-btn {
            padding: 6px 10px !important;
            font-size: 11px !important;
        }
        
        #selectorProyecto {
            min-width: 100%;
        }
        
        .filtro-hito {
            padding: 6px 10px !important;
            font-size: 11px !important;
        }
        
        .calendario-dia {
            min-height: 80px;
            font-size: 11px;
        }
        
        .evento-hito {
            font-size: 9px;
            padding: 2px;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado - Cronogramas y Hitos');
        
        // Variables globales
        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();
        const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        
        // Datos de ejemplo para hitos
        const hitosData = [
            { fecha: '2026-03-03', proyecto: 'PRO-2024-001', nombre: 'Inicio de Cimentación', estado: 'completado', responsable: 'Carlos Rodríguez' },
            { fecha: '2026-03-06', proyecto: 'PRO-2024-003', nombre: 'Entrega de Planos', estado: 'completado', responsable: 'Ana Martínez' },
            { fecha: '2026-03-11', proyecto: 'PRO-2024-002', nombre: 'Colado de Trabes', estado: 'proceso', responsable: 'María García' },
            { fecha: '2026-03-15', proyecto: 'PRO-2024-005', nombre: 'Entrega de Equipo', estado: 'retrasado', responsable: 'Juan Pérez' },
            { fecha: '2026-03-18', proyecto: 'PRO-2024-001', nombre: 'Estructura', estado: 'proceso', responsable: 'Carlos Rodríguez' },
            { fecha: '2026-03-22', proyecto: 'PRO-2024-004', nombre: 'Entrega de Material', estado: 'completado', responsable: 'Luis Ramírez' },
            { fecha: '2026-03-25', proyecto: 'PRO-2024-003', nombre: 'Nivelación', estado: 'proceso', responsable: 'Ana Martínez' },
            { fecha: '2026-03-28', proyecto: 'PRO-2024-006', nombre: 'Inicio de Obra', estado: 'proceso', responsable: 'Roberto Sánchez' }
        ];
        
        // Elementos del DOM
        const calendarioGrid = document.getElementById('calendarioGrid');
        const mesActualEl = document.getElementById('mesActual');
        const btnMesAnterior = document.getElementById('btnMesAnterior');
        const btnMesSiguiente = document.getElementById('btnMesSiguiente');
        const btnHoy = document.getElementById('btnHoy');
        const btnNuevoHito = document.getElementById('btnNuevoHito');
        const modalNuevoHito = document.getElementById('modalNuevoHito');
        const btnCerrarModal = document.getElementById('btnCerrarModal');
        const btnCancelarHito = document.getElementById('btnCancelarHito');
        const btnGuardarHito = document.getElementById('btnGuardarHito');
        const btnAgregarEntregable = document.getElementById('btnAgregarEntregable');
        const listaEntregables = document.getElementById('listaEntregables');
        const selectorProyecto = document.getElementById('selectorProyecto');
        const fechaInicio = document.getElementById('fechaInicio');
        const fechaFin = document.getElementById('fechaFin');
        const btnExportar = document.getElementById('btnExportar');
        
        // Funciones para cambiar de vista
        const vistaBtns = document.querySelectorAll('.vista-btn');
        const vistas = document.querySelectorAll('.vista-content');
        
        vistaBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const vista = this.dataset.vista;
                
                vistaBtns.forEach(b => {
                    b.classList.remove('active');
                    b.style.backgroundColor = 'transparent';
                    b.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                vistas.forEach(v => v.style.display = 'none');
                document.getElementById(`vista-${vista}`).style.display = 'block';
                
                if (vista === 'calendario') {
                    generarCalendario(currentYear, currentMonth);
                }
            });
        });
        
        // Función para generar calendario
        function generarCalendario(year, month) {
            if (!calendarioGrid) return;
            
            mesActualEl.textContent = `${monthNames[month]} ${year}`;
            
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startDay = firstDay.getDay(); // 0 = Domingo, 1 = Lunes, etc.
            const daysInMonth = lastDay.getDate();
            
            // Ajustar para empezar en Lunes (si startDay = 0 (Domingo), entonces empezar desde 6 días antes)
            let startOffset = startDay === 0 ? 6 : startDay - 1;
            
            // Días del mes anterior
            const prevMonthLastDay = new Date(year, month, 0).getDate();
            
            calendarioGrid.innerHTML = '';
            
            // Generar celdas del calendario
            for (let i = 0; i < 42; i++) {
                const diaDiv = document.createElement('div');
                diaDiv.className = 'calendario-dia';
                
                let dayNumber;
                let isCurrentMonth = true;
                let dateStr;
                
                if (i < startOffset) {
                    // Días del mes anterior
                    dayNumber = prevMonthLastDay - startOffset + i + 1;
                    isCurrentMonth = false;
                    dateStr = `${year}-${String(month).padStart(2, '0')}-${String(dayNumber).padStart(2, '0')}`;
                } else if (i >= startOffset + daysInMonth) {
                    // Días del mes siguiente
                    dayNumber = i - (startOffset + daysInMonth) + 1;
                    isCurrentMonth = false;
                    const nextMonth = month + 1 > 11 ? 0 : month + 1;
                    const nextYear = month + 1 > 11 ? year + 1 : year;
                    dateStr = `${nextYear}-${String(nextMonth + 1).padStart(2, '0')}-${String(dayNumber).padStart(2, '0')}`;
                } else {
                    // Días del mes actual
                    dayNumber = i - startOffset + 1;
                    dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(dayNumber).padStart(2, '0')}`;
                }
                
                if (!isCurrentMonth) {
                    diaDiv.classList.add('otro-mes');
                }
                
                // Verificar si es hoy
                const today = new Date();
                if (year === today.getFullYear() && month === today.getMonth() && dayNumber === today.getDate() && isCurrentMonth) {
                    diaDiv.classList.add('hoy');
                }
                
                const numeroDia = document.createElement('div');
                numeroDia.style.display = 'flex';
                numeroDia.style.justifyContent = 'space-between';
                numeroDia.style.marginBottom = '5px';
                
                const spanNumero = document.createElement('span');
                spanNumero.style.fontWeight = isCurrentMonth ? 'bold' : 'normal';
                spanNumero.style.color = isCurrentMonth ? '#083CAE' : '#adb5bd';
                spanNumero.textContent = dayNumber;
                
                numeroDia.appendChild(spanNumero);
                
                // Contar hitos para este día
                const hitosDelDia = hitosData.filter(h => h.fecha === dateStr);
                if (hitosDelDia.length > 0) {
                    const contador = document.createElement('span');
                    contador.style.backgroundColor = '#083CAE';
                    contador.style.color = 'white';
                    contador.style.padding = '2px 6px';
                    contador.style.borderRadius = '10px';
                    contador.style.fontSize = '10px';
                    contador.textContent = hitosDelDia.length;
                    numeroDia.appendChild(contador);
                }
                
                diaDiv.appendChild(numeroDia);
                
                // Agregar hitos
                hitosDelDia.forEach(hito => {
                    const hitoDiv = document.createElement('div');
                    hitoDiv.className = `evento-hito ${hito.estado}`;
                    hitoDiv.innerHTML = `<strong>${hito.proyecto}</strong><br>${hito.nombre}`;
                    hitoDiv.title = `Responsable: ${hito.responsable}`;
                    hitoDiv.onclick = () => mostrarDetalleHito(hito);
                    diaDiv.appendChild(hitoDiv);
                });
                
                calendarioGrid.appendChild(diaDiv);
            }
        }
        
        // Función para mostrar detalle de hito
        function mostrarDetalleHito(hito) {
            alert(`Hito: ${hito.nombre}\nProyecto: ${hito.proyecto}\nFecha: ${hito.fecha}\nResponsable: ${hito.responsable}\nEstado: ${hito.estado}`);
        }
        
        // Función para cambiar de mes
        function cambiarMes(delta) {
            currentMonth += delta;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            } else if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            generarCalendario(currentYear, currentMonth);
        }
        
        // Event listeners para calendario
        if (btnMesAnterior) {
            btnMesAnterior.addEventListener('click', () => cambiarMes(-1));
        }
        
        if (btnMesSiguiente) {
            btnMesSiguiente.addEventListener('click', () => cambiarMes(1));
        }
        
        if (btnHoy) {
            btnHoy.addEventListener('click', () => {
                currentMonth = new Date().getMonth();
                currentYear = new Date().getFullYear();
                generarCalendario(currentYear, currentMonth);
            });
        }
        
        // Función para toggle de hitos en Gantt
        window.toggleHitos = function(proyectoId) {
            const hitosDiv = document.getElementById(`hitos-${proyectoId}`);
            const icono = document.getElementById(`icono-${proyectoId}`);
            
            if (hitosDiv && icono) {
                if (hitosDiv.style.display === 'none') {
                    hitosDiv.style.display = 'block';
                    icono.className = 'fas fa-chevron-down';
                } else {
                    hitosDiv.style.display = 'none';
                    icono.className = 'fas fa-chevron-right';
                }
            }
        };
        
        // Modal para nuevo hito
        if (btnNuevoHito) {
            btnNuevoHito.addEventListener('click', function() {
                modalNuevoHito.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        }
        
        function cerrarModal() {
            modalNuevoHito.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        if (btnCerrarModal) {
            btnCerrarModal.addEventListener('click', cerrarModal);
        }
        
        if (btnCancelarHito) {
            btnCancelarHito.addEventListener('click', cerrarModal);
        }
        
        // Cerrar modal al hacer clic fuera
        window.addEventListener('click', function(event) {
            if (event.target === modalNuevoHito) {
                cerrarModal();
            }
        });
        
        // Agregar entregables
        if (btnAgregarEntregable) {
            btnAgregarEntregable.addEventListener('click', function() {
                const input = document.getElementById('nuevoEntregable');
                const entregable = input.value.trim();
                
                if (entregable) {
                    const entregableDiv = document.createElement('div');
                    entregableDiv.style.display = 'flex';
                    entregableDiv.style.justifyContent = 'space-between';
                    entregableDiv.style.alignItems = 'center';
                    entregableDiv.style.padding = '5px';
                    entregableDiv.style.marginBottom = '5px';
                    entregableDiv.style.backgroundColor = 'white';
                    entregableDiv.style.borderRadius = '4px';
                    entregableDiv.style.border = '1px solid #dee2e6';
                    
                    entregableDiv.innerHTML = `
                        <span>${entregable}</span>
                        <i class="fas fa-times" style="color: #dc3545; cursor: pointer;" onclick="this.parentElement.remove()"></i>
                    `;
                    
                    if (listaEntregables) {
                        if (listaEntregables.children.length === 1 && listaEntregables.children[0].tagName === 'SMALL') {
                            listaEntregables.innerHTML = '';
                        }
                        listaEntregables.appendChild(entregableDiv);
                    }
                    
                    input.value = '';
                }
            });
        }
        
        // Guardar hito
        if (btnGuardarHito) {
            btnGuardarHito.addEventListener('click', function() {
                const proyecto = document.getElementById('modalProyecto').value;
                const nombre = document.getElementById('modalNombreHito').value;
                const fecha = document.getElementById('modalFechaProgramada').value;
                
                if (!proyecto || !nombre || !fecha) {
                    alert('Por favor complete los campos requeridos');
                    return;
                }
                
                alert('Hito guardado correctamente');
                cerrarModal();
            });
        }
        
        // Filtros de hitos en vista lista
        const filtrosHito = document.querySelectorAll('.filtro-hito');
        
        filtrosHito.forEach(filtro => {
            filtro.addEventListener('click', function() {
                filtrosHito.forEach(f => {
                    f.classList.remove('active');
                    f.style.backgroundColor = 'white';
                    f.style.color = '#495057';
                    f.style.border = '1px solid #dee2e6';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                this.style.border = 'none';
                
                const filtro = this.dataset.filtro;
                const filas = document.querySelectorAll('#tablaHitosBody tr');
                
                filas.forEach(fila => {
                    if (filtro === 'todos') {
                        fila.style.display = '';
                    } else {
                        const estado = fila.querySelector('td:nth-child(6) span').textContent.toLowerCase();
                        const fecha = fila.querySelector('td:nth-child(4)').textContent;
                        
                        if (filtro === 'completados' && estado.includes('completado')) {
                            fila.style.display = '';
                        } else if (filtro === 'proceso' && estado.includes('proceso')) {
                            fila.style.display = '';
                        } else if (filtro === 'retrasados' && estado.includes('retrasado')) {
                            fila.style.display = '';
                        } else if (filtro === 'criticos' && fila.querySelector('td:nth-child(2)').textContent.includes('Cimentación')) {
                            fila.style.display = '';
                        } else if (filtro === 'proximos') {
                            // Simplificado: mostrar filas con fecha futura
                            fila.style.display = '';
                        } else {
                            fila.style.display = 'none';
                        }
                    }
                });
            });
        });
        
        // Paginación
        const paginacionBtns = document.querySelectorAll('.btn-paginacion');
        paginacionBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.querySelector('.fa-chevron-left')) {
                    // Anterior
                } else if (this.querySelector('.fa-chevron-right')) {
                    // Siguiente
                } else {
                    paginacionBtns.forEach(b => {
                        if (!b.querySelector('i')) {
                            b.style.backgroundColor = 'white';
                            b.style.color = '#495057';
                        }
                    });
                    this.style.backgroundColor = '#083CAE';
                    this.style.color = 'white';
                }
            });
        });
        
        // Exportar
        if (btnExportar) {
            btnExportar.addEventListener('click', function() {
                alert('Exportando cronograma...');
            });
        }
        
        // Selector de proyecto
        if (selectorProyecto) {
            selectorProyecto.addEventListener('change', function() {
                alert(`Filtrando por proyecto: ${this.value || 'Todos'}`);
            });
        }
        
        // Fechas
        if (fechaInicio && fechaFin) {
            fechaInicio.addEventListener('change', function() {
                console.log('Fecha inicio:', this.value);
            });
            
            fechaFin.addEventListener('change', function() {
                console.log('Fecha fin:', this.value);
            });
        }
        
        // Zoom en Gantt
        const btnZoomIn = document.getElementById('btnZoomIn');
        const btnZoomOut = document.getElementById('btnZoomOut');
        const escalaGantt = document.getElementById('escalaGantt');
        
        if (btnZoomIn) {
            btnZoomIn.addEventListener('click', function() {
                alert('Zoom In - Funcionalidad simulada');
            });
        }
        
        if (btnZoomOut) {
            btnZoomOut.addEventListener('click', function() {
                alert('Zoom Out - Funcionalidad simulada');
            });
        }
        
        if (escalaGantt) {
            escalaGantt.addEventListener('change', function() {
                alert(`Cambiando a escala: ${this.options[this.selectedIndex].text}`);
            });
        }
        
        // Inicializar calendario
        generarCalendario(currentYear, currentMonth);
        
        // Inicializar hitos de proyectos en Gantt (todos visibles)
        document.querySelectorAll('[id^="hitos-proyecto"]').forEach(div => {
            div.style.display = 'block';
        });
    });
</script>
@endsection