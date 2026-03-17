@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Bitácora de Uso de Maquinaria -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    
                    Bitácora de Uso de Maquinaria
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE USO CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Horas Operadas Hoy -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Horas Hoy</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="horasHoy">342</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Equipos Activos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Equipos Activos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="equiposActivos">24</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Combustible Consumido -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Combustible</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="combustibleHoy">1,245 L</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Horas Mes -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Horas Mes</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="horasMes">8,520</div>
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

                        <select id="selectorEquipo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 200px;">
                            <option value="">Todos los equipos</option>
                            <option value="EX-001">EX-001 - Excavadora 320D</option>
                            <option value="EX-002">EX-002 - Excavadora 320D</option>
                            <option value="RT-001">RT-001 - Retroexcavadora</option>
                            <option value="CA-010">CA-010 - Camión Kenworth</option>
                            <option value="GR-002">GR-002 - Grúa</option>
                        </select>

                        <!-- Selector de fecha -->
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <input type="date" id="fechaInicio" value="2026-03-01" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <span style="color: #6c757d;">a</span>
                            <input type="date" id="fechaFin" value="2026-03-11" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                    </div>
                    
                    <!-- Grupo de botones derecho -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Botón Registrar Uso -->
                        <div>
                            <button id="btnRegistrarUso" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Registrar Uso">
                                <i class="fas fa-plus-circle"></i> Registrar Uso
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

                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar registro..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Pestañas de secciones -->
                <div style="display: flex; gap: 2px; margin-bottom: 20px; border-bottom: 2px solid #083CAE; overflow-x: auto; white-space: nowrap;">
                    <button class="bitacora-tab active" data-tab="diario" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-calendar-day"></i> Registro Diario
                    </button>
                    <button class="bitacora-tab" data-tab="equipos" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-tractor"></i> Por Equipo
                    </button>
                    <button class="bitacora-tab" data-tab="operadores" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-users"></i> Por Operador
                    </button>
                    <button class="bitacora-tab" data-tab="resumen" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-chart-bar"></i> Resumen
                    </button>
                </div>

                <!-- SECCIÓN 1: REGISTRO DIARIO -->
                <div id="tab-diario" class="bitacora-content active">
                    <!-- Tabla de registro diario -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Fecha</th>
                                    <th style="padding: 12px;">Equipo</th>
                                    <th style="padding: 12px;">Operador</th>
                                    <th style="padding: 12px;">Proyecto</th>
                                    <th style="padding: 12px;">Hora Inicio</th>
                                    <th style="padding: 12px;">Hora Fin</th>
                                    <th style="padding: 12px;">Horas</th>
                                    <th style="padding: 12px;">Horómetro Inicial</th>
                                    <th style="padding: 12px;">Horómetro Final</th>
                                    <th style="padding: 12px;">Combustible (L)</th>
                                    <th style="padding: 12px;">Labor Realizada</th>
                                    <th style="padding: 12px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px;">11/03/2026</td>
                                    <td style="padding: 12px;"><strong>EX-001</strong> - Excavadora</td>
                                    <td style="padding: 12px;">Carlos Rodríguez</td>
                                    <td style="padding: 12px;">Torre Norte</td>
                                    <td style="padding: 12px;">07:00</td>
                                    <td style="padding: 12px;">17:00</td>
                                    <td style="padding: 12px;">10.0</td>
                                    <td style="padding: 12px;">1,245</td>
                                    <td style="padding: 12px;">1,255</td>
                                    <td style="padding: 12px;">85</td>
                                    <td style="padding: 12px;">Excavación de cimentación</td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalle" onclick="verDetalleUso('EX-001', '11/03/2026')"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Editar" onclick="editarUso('EX-001', '11/03/2026')"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">11/03/2026</td>
                                    <td style="padding: 12px;"><strong>RT-005</strong> - Retroexcavadora</td>
                                    <td style="padding: 12px;">María García</td>
                                    <td style="padding: 12px;">Puente Sur</td>
                                    <td style="padding: 12px;">08:00</td>
                                    <td style="padding: 12px;">16:30</td>
                                    <td style="padding: 12px;">8.5</td>
                                    <td style="padding: 12px;">890</td>
                                    <td style="padding: 12px;">898.5</td>
                                    <td style="padding: 12px;">42</td>
                                    <td style="padding: 12px;">Excavación para zapatas</td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">11/03/2026</td>
                                    <td style="padding: 12px;"><strong>CA-010</strong> - Camión</td>
                                    <td style="padding: 12px;">Juan Pérez</td>
                                    <td style="padding: 12px;">Parque Industrial</td>
                                    <td style="padding: 12px;">06:30</td>
                                    <td style="padding: 12px;">18:30</td>
                                    <td style="padding: 12px;">12.0</td>
                                    <td style="padding: 12px;">2,150</td>
                                    <td style="padding: 12px;">2,162</td>
                                    <td style="padding: 12px;">95</td>
                                    <td style="padding: 12px;">Acarreo de material</td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">10/03/2026</td>
                                    <td style="padding: 12px;"><strong>GR-003</strong> - Grúa</td>
                                    <td style="padding: 12px;">Ana Martínez</td>
                                    <td style="padding: 12px;">Hospital Regional</td>
                                    <td style="padding: 12px;">09:00</td>
                                    <td style="padding: 12px;">17:00</td>
                                    <td style="padding: 12px;">8.0</td>
                                    <td style="padding: 12px;">920</td>
                                    <td style="padding: 12px;">928</td>
                                    <td style="padding: 12px;">38</td>
                                    <td style="padding: 12px;">Izaje de estructura metálica</td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">10/03/2026</td>
                                    <td style="padding: 12px;"><strong>CP-001</strong> - Compactador</td>
                                    <td style="padding: 12px;">Luis Ramírez</td>
                                    <td style="padding: 12px;">Planta Tratamiento</td>
                                    <td style="padding: 12px;">08:00</td>
                                    <td style="padding: 12px;">16:00</td>
                                    <td style="padding: 12px;">8.0</td>
                                    <td style="padding: 12px;">320</td>
                                    <td style="padding: 12px;">328</td>
                                    <td style="padding: 12px;">42</td>
                                    <td style="padding: 12px;">Compactación de terreno</td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
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
                        <span style="color: #6c757d; font-size: 13px;">Mostrando 1-5 de 45 registros</span>
                    </div>
                </div>

                <!-- SECCIÓN 2: POR EQUIPO -->
                <div id="tab-equipos" class="bitacora-content" style="display: none;">
                    <!-- Selector de equipo -->
                    <div style="display: flex; gap: 15px; margin-bottom: 20px; align-items: center; flex-wrap: wrap;">
                        <div style="min-width: 300px;">
                            <select id="selectorEquipoDetalle" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                <option value="">Seleccionar equipo...</option>
                                <option value="EX-001">EX-001 - Excavadora 320D</option>
                                <option value="EX-002">EX-002 - Excavadora 320D</option>
                                <option value="RT-001">RT-001 - Retroexcavadora</option>
                                <option value="CA-010">CA-010 - Camión Kenworth</option>
                                <option value="GR-002">GR-002 - Grúa</option>
                            </select>
                        </div>
                        <div>
                            <button id="btnVerEquipo" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 10px 20px; cursor: pointer;">
                                <i class="fas fa-search"></i> Ver detalles
                            </button>
                        </div>
                    </div>

                    <!-- Información del equipo (visible cuando se selecciona) -->
                    <div id="infoEquipo" style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; margin-bottom: 20px; display: none;">
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                            <div>
                                <div style="color: #6c757d; font-size: 12px;">Horas Totales</div>
                                <div style="font-size: 24px; font-weight: bold; color: #083CAE;" id="equipoHorasTotales">245</div>
                            </div>
                            <div>
                                <div style="color: #6c757d; font-size: 12px;">Horas Mes</div>
                                <div style="font-size: 24px; font-weight: bold; color: #083CAE;" id="equipoHorasMes">85</div>
                            </div>
                            <div>
                                <div style="color: #6c757d; font-size: 12px;">Combustible Total</div>
                                <div style="font-size: 24px; font-weight: bold; color: #083CAE;" id="equipoCombustible">1,245 L</div>
                            </div>
                            <div>
                                <div style="color: #6c757d; font-size: 12px;">Rendimiento</div>
                                <div style="font-size: 24px; font-weight: bold; color: #083CAE;" id="equipoRendimiento">5.1 L/hr</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de uso por equipo -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Fecha</th>
                                    <th style="padding: 12px;">Operador</th>
                                    <th style="padding: 12px;">Proyecto</th>
                                    <th style="padding: 12px;">Horas</th>
                                    <th style="padding: 12px;">Combustible</th>
                                    <th style="padding: 12px;">Horómetro</th>
                                    <th style="padding: 12px;">Labor Realizada</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px;">11/03/2026</td>
                                    <td style="padding: 12px;">Carlos Rodríguez</td>
                                    <td style="padding: 12px;">Torre Norte</td>
                                    <td style="padding: 12px;">10.0</td>
                                    <td style="padding: 12px;">85 L</td>
                                    <td style="padding: 12px;">1,245 → 1,255</td>
                                    <td style="padding: 12px;">Excavación de cimentación</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">10/03/2026</td>
                                    <td style="padding: 12px;">Carlos Rodríguez</td>
                                    <td style="padding: 12px;">Torre Norte</td>
                                    <td style="padding: 12px;">9.5</td>
                                    <td style="padding: 12px;">78 L</td>
                                    <td style="padding: 12px;">1,235.5 → 1,245</td>
                                    <td style="padding: 12px;">Excavación</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">09/03/2026</td>
                                    <td style="padding: 12px;">Carlos Rodríguez</td>
                                    <td style="padding: 12px;">Torre Norte</td>
                                    <td style="padding: 12px;">8.5</td>
                                    <td style="padding: 12px;">72 L</td>
                                    <td style="padding: 12px;">1,227 → 1,235.5</td>
                                    <td style="padding: 12px;">Nivelación</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 3: POR OPERADOR -->
                <div id="tab-operadores" class="bitacora-content" style="display: none;">
                    <!-- Selector de operador -->
                    <div style="display: flex; gap: 15px; margin-bottom: 20px; align-items: center; flex-wrap: wrap;">
                        <div style="min-width: 300px;">
                            <select id="selectorOperador" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                <option value="">Seleccionar operador...</option>
                                <option value="carlos">Carlos Rodríguez</option>
                                <option value="maria">María García</option>
                                <option value="juan">Juan Pérez</option>
                                <option value="ana">Ana Martínez</option>
                                <option value="luis">Luis Ramírez</option>
                            </select>
                        </div>
                        <div>
                            <button id="btnVerOperador" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 10px 20px; cursor: pointer;">
                                <i class="fas fa-search"></i> Ver detalles
                            </button>
                        </div>
                    </div>

                    <!-- Información del operador (visible cuando se selecciona) -->
                    <div id="infoOperador" style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; margin-bottom: 20px; display: none;">
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                            <div>
                                <div style="color: #6c757d; font-size: 12px;">Horas Totales</div>
                                <div style="font-size: 24px; font-weight: bold; color: #083CAE;" id="operadorHorasTotales">185</div>
                            </div>
                            <div>
                                <div style="color: #6c757d; font-size: 12px;">Horas Mes</div>
                                <div style="font-size: 24px; font-weight: bold; color: #083CAE;" id="operadorHorasMes">62</div>
                            </div>
                            <div>
                                <div style="color: #6c757d; font-size: 12px;">Equipos Operados</div>
                                <div style="font-size: 24px; font-weight: bold; color: #083CAE;" id="operadorEquipos">3</div>
                            </div>
                            <div>
                                <div style="color: #6c757d; font-size: 12px;">Eficiencia</div>
                                <div style="font-size: 24px; font-weight: bold; color: #28a745;" id="operadorEficiencia">98%</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de uso por operador -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Fecha</th>
                                    <th style="padding: 12px;">Equipo</th>
                                    <th style="padding: 12px;">Proyecto</th>
                                    <th style="padding: 12px;">Hora Inicio</th>
                                    <th style="padding: 12px;">Hora Fin</th>
                                    <th style="padding: 12px;">Horas</th>
                                    <th style="padding: 12px;">Labor Realizada</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px;">11/03/2026</td>
                                    <td style="padding: 12px;">EX-001 - Excavadora</td>
                                    <td style="padding: 12px;">Torre Norte</td>
                                    <td style="padding: 12px;">07:00</td>
                                    <td style="padding: 12px;">17:00</td>
                                    <td style="padding: 12px;">10.0</td>
                                    <td style="padding: 12px;">Excavación de cimentación</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">10/03/2026</td>
                                    <td style="padding: 12px;">EX-001 - Excavadora</td>
                                    <td style="padding: 12px;">Torre Norte</td>
                                    <td style="padding: 12px;">07:00</td>
                                    <td style="padding: 12px;">17:00</td>
                                    <td style="padding: 12px;">10.0</td>
                                    <td style="padding: 12px;">Excavación</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">09/03/2026</td>
                                    <td style="padding: 12px;">EX-001 - Excavadora</td>
                                    <td style="padding: 12px;">Torre Norte</td>
                                    <td style="padding: 12px;">08:00</td>
                                    <td style="padding: 12px;">16:00</td>
                                    <td style="padding: 12px;">8.0</td>
                                    <td style="padding: 12px;">Nivelación</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 4: RESUMEN -->
                <div id="tab-resumen" class="bitacora-content" style="display: none;">
                    <!-- Gráficos de resumen -->
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <!-- Horas por equipo -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-bar"></i> Horas por Equipo - Marzo 2026
                            </h4>
                            <div style="height: 200px; display: flex; align-items: flex-end; gap: 15px; justify-content: center;">
                                <div style="text-align: center;">
                                    <div style="height: 140px; width: 50px; background-color: #083CAE; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">EX-001</div>
                                    <div style="font-size: 10px;">185h</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="height: 110px; width: 50px; background-color: #28a745; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">EX-002</div>
                                    <div style="font-size: 10px;">145h</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="height: 95px; width: 50px; background-color: #ffc107; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">RT-005</div>
                                    <div style="font-size: 10px;">125h</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="height: 160px; width: 50px; background-color: #17a2b8; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">CA-010</div>
                                    <div style="font-size: 10px;">210h</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="height: 75px; width: 50px; background-color: #dc3545; border-radius: 4px 4px 0 0;"></div>
                                    <div style="margin-top: 5px; font-size: 11px;">GR-003</div>
                                    <div style="font-size: 10px;">98h</div>
                                </div>
                            </div>
                        </div>

                        <!-- Distribución por proyecto -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-pie"></i> Horas por Proyecto
                            </h4>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Torre Norte</span>
                                    <span style="font-size: 13px; font-weight: 600;">320h (38%)</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 38%; height: 8px; background-color: #083CAE; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Puente Sur</span>
                                    <span style="font-size: 13px; font-weight: 600;">210h (25%)</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 25%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Parque Industrial</span>
                                    <span style="font-size: 13px; font-weight: 600;">185h (22%)</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 22%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Hospital Regional</span>
                                    <span style="font-size: 13px; font-weight: 600;">125h (15%)</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 15%; height: 8px; background-color: #17a2b8; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla resumen por equipo -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Equipo</th>
                                    <th style="padding: 12px;">Horas Mes</th>
                                    <th style="padding: 12px;">Horas Totales</th>
                                    <th style="padding: 12px;">Combustible</th>
                                    <th style="padding: 12px;">Rendimiento</th>
                                    <th style="padding: 12px;">Operador Principal</th>
                                    <th style="padding: 12px;">Último Uso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px;">EX-001 - Excavadora</td>
                                    <td style="padding: 12px;">185</td>
                                    <td style="padding: 12px;">1,245</td>
                                    <td style="padding: 12px;">945 L</td>
                                    <td style="padding: 12px;">5.1 L/hr</td>
                                    <td style="padding: 12px;">Carlos Rodríguez</td>
                                    <td style="padding: 12px;">11/03/2026</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">EX-002 - Excavadora</td>
                                    <td style="padding: 12px;">145</td>
                                    <td style="padding: 12px;">980</td>
                                    <td style="padding: 12px;">725 L</td>
                                    <td style="padding: 12px;">5.0 L/hr</td>
                                    <td style="padding: 12px;">Pedro Sánchez</td>
                                    <td style="padding: 12px;">10/03/2026</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">RT-005 - Retro</td>
                                    <td style="padding: 12px;">125</td>
                                    <td style="padding: 12px;">890</td>
                                    <td style="padding: 12px;">438 L</td>
                                    <td style="padding: 12px;">3.5 L/hr</td>
                                    <td style="padding: 12px;">María García</td>
                                    <td style="padding: 12px;">11/03/2026</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">CA-010 - Camión</td>
                                    <td style="padding: 12px;">210</td>
                                    <td style="padding: 12px;">2,150</td>
                                    <td style="padding: 12px;">1,680 L</td>
                                    <td style="padding: 12px;">8.0 L/hr</td>
                                    <td style="padding: 12px;">Juan Pérez</td>
                                    <td style="padding: 12px;">11/03/2026</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">GR-003 - Grúa</td>
                                    <td style="padding: 12px;">98</td>
                                    <td style="padding: 12px;">920</td>
                                    <td style="padding: 12px;">392 L</td>
                                    <td style="padding: 12px;">4.0 L/hr</td>
                                    <td style="padding: 12px;">Ana Martínez</td>
                                    <td style="padding: 12px;">10/03/2026</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Registrar Uso -->
<div id="modalRegistrarUso" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #083CAE;"><i class="fas fa-plus-circle"></i> Registrar Uso de Equipo</h3>
            <button id="btnCerrarModalUso" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #6c757d;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha <span style="color: #dc3545;">*</span></label>
                    <input type="date" id="modalFecha" value="2026-03-11" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Equipo <span style="color: #dc3545;">*</span></label>
                    <select id="modalEquipo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar...</option>
                        <option value="EX-001">EX-001 - Excavadora 320D</option>
                        <option value="EX-002">EX-002 - Excavadora 320D</option>
                        <option value="RT-005">RT-005 - Retroexcavadora</option>
                        <option value="CA-010">CA-010 - Camión Kenworth</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Operador <span style="color: #dc3545;">*</span></label>
                <select id="modalOperador" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="">Seleccionar...</option>
                    <option value="carlos">Carlos Rodríguez</option>
                    <option value="maria">María García</option>
                    <option value="juan">Juan Pérez</option>
                    <option value="ana">Ana Martínez</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Proyecto <span style="color: #dc3545;">*</span></label>
                <select id="modalProyecto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="">Seleccionar...</option>
                    <option value="PRO-2024-001">PRO-2024-001 - Torre Norte</option>
                    <option value="PRO-2024-002">PRO-2024-002 - Puente Sur</option>
                    <option value="PRO-2024-003">PRO-2024-003 - Parque Industrial</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Hora Inicio</label>
                    <input type="time" id="modalHoraInicio" value="07:00" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Hora Fin</label>
                    <input type="time" id="modalHoraFin" value="17:00" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Horómetro Inicial</label>
                    <input type="number" id="modalHorometroInicial" placeholder="0" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Horómetro Final</label>
                    <input type="number" id="modalHorometroFinal" placeholder="0" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Combustible (L)</label>
                    <input type="number" id="modalCombustible" placeholder="0" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Horas Calculadas</label>
                    <input type="text" id="modalHorasCalculadas" readonly value="10.0" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; background-color: #e9ecef;">
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Labor Realizada</label>
                <textarea id="modalLabor" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Describa la actividad realizada..."></textarea>
            </div>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelarUso" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button id="btnGuardarUso" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Guardar Registro</button>
        </div>
    </div>
</div>

<!-- Modal para Ver Detalle de Uso -->
<div id="modalVerDetalleUso" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-clipboard-list"></i> Detalle de Uso
            </h3>
            <button id="btnCerrarDetalleUso" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Equipo</div>
                    <div style="font-size: 16px; font-weight: 600;" id="detalleEquipo">EX-001 - Excavadora 320D</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Fecha</div>
                    <div style="font-size: 16px; font-weight: 600;" id="detalleFecha">11/03/2026</div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Operador</div>
                    <div style="font-size: 14px;" id="detalleOperador">Carlos Rodríguez</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Proyecto</div>
                    <div style="font-size: 14px;" id="detalleProyecto">Torre Norte</div>
                </div>
            </div>

            <div style="background-color: #f8f9fa; border-radius: 6px; padding: 15px; margin-bottom: 20px;">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Hora Inicio</div>
                        <div style="font-size: 16px; font-weight: 600;" id="detalleHoraInicio">07:00</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Hora Fin</div>
                        <div style="font-size: 16px; font-weight: 600;" id="detalleHoraFin">17:00</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Horas</div>
                        <div style="font-size: 16px; font-weight: 600; color: #083CAE;" id="detalleHoras">10.0</div>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Horómetro Inicial</div>
                    <div style="font-size: 14px; font-weight: 600;" id="detalleHorometroInicial">1,245</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Horómetro Final</div>
                    <div style="font-size: 14px; font-weight: 600;" id="detalleHorometroFinal">1,255</div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Combustible</div>
                    <div style="font-size: 14px; font-weight: 600;" id="detalleCombustible">85 L</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Rendimiento</div>
                    <div style="font-size: 14px; font-weight: 600;" id="detalleRendimiento">8.5 L/hr</div>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Labor Realizada</div>
                <div style="background-color: #f8f9fa; padding: 10px; border-radius: 4px; font-size: 14px;" id="detalleLabor">
                    Excavación de cimentación para torre norte. Se removieron 120m³ de material.
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button id="btnEditarDetalle" style="padding: 8px 15px; background-color: white; border: 1px solid #ffc107; color: #ffc107; border-radius: 4px; cursor: pointer;">
                    <i class="fas fa-edit"></i> Editar
                </button>
                <button id="btnCerrarDetalle" style="padding: 8px 15px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">
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
    
    /* Pestañas */
    .bitacora-tab {
        transition: all 0.3s ease;
    }
    
    .bitacora-tab:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    
    .bitacora-tab.active {
        background-color: #083CAE !important;
        color: white !important;
    }
    
    .bitacora-content {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .btn-paginacion {
        transition: all 0.3s ease;
    }
    
    .btn-paginacion:hover {
        background-color: #e9ecef !important;
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
        
        .bitacora-tab {
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
        console.log('DOM completamente cargado - Bitácora de Uso de Maquinaria');
        
        // Elementos del DOM
        const selectorProyecto = document.getElementById('selectorProyecto');
        const selectorEquipo = document.getElementById('selectorEquipo');
        const fechaInicio = document.getElementById('fechaInicio');
        const fechaFin = document.getElementById('fechaFin');
        const btnRegistrarUso = document.getElementById('btnRegistrarUso');
        const btnExcel = document.getElementById('btnExcel');
        const btnRefrescar = document.getElementById('btnRefrescar');
        const buscador = document.getElementById('buscador');
        
        // Elementos de pestañas
        const bitacoraTabs = document.querySelectorAll('.bitacora-tab');
        const bitacoraContents = document.querySelectorAll('.bitacora-content');
        
        // Elementos de modales
        const modalRegistrarUso = document.getElementById('modalRegistrarUso');
        const btnCerrarModalUso = document.getElementById('btnCerrarModalUso');
        const btnCancelarUso = document.getElementById('btnCancelarUso');
        const btnGuardarUso = document.getElementById('btnGuardarUso');
        
        const modalVerDetalleUso = document.getElementById('modalVerDetalleUso');
        const btnCerrarDetalleUso = document.getElementById('btnCerrarDetalleUso');
        const btnCerrarDetalle = document.getElementById('btnCerrarDetalle');
        const btnEditarDetalle = document.getElementById('btnEditarDetalle');
        
        // Elementos de secciones específicas
        const selectorEquipoDetalle = document.getElementById('selectorEquipoDetalle');
        const btnVerEquipo = document.getElementById('btnVerEquipo');
        const infoEquipo = document.getElementById('infoEquipo');
        
        const selectorOperador = document.getElementById('selectorOperador');
        const btnVerOperador = document.getElementById('btnVerOperador');
        const infoOperador = document.getElementById('infoOperador');
        
        // Cambio de pestañas
        bitacoraTabs.forEach((tab, index) => {
            tab.addEventListener('click', function() {
                bitacoraTabs.forEach(t => {
                    t.classList.remove('active');
                    t.style.backgroundColor = '#e9ecef';
                    t.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                bitacoraContents.forEach(content => content.style.display = 'none');
                bitacoraContents[index].style.display = 'block';
            });
        });
        
        // Event Listeners para filtros
        selectorProyecto.addEventListener('change', function() {
            console.log('Filtrando por proyecto:', this.value);
        });
        
        selectorEquipo.addEventListener('change', function() {
            console.log('Filtrando por equipo:', this.value);
        });
        
        fechaInicio.addEventListener('change', function() {
            console.log('Fecha inicio:', this.value);
        });
        
        fechaFin.addEventListener('change', function() {
            console.log('Fecha fin:', this.value);
        });
        
        buscador.addEventListener('input', function(e) {
            console.log('Buscando:', e.target.value);
        });
        
        // Botones de acción
        btnRegistrarUso.addEventListener('click', function() {
            modalRegistrarUso.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
        
        btnExcel.addEventListener('click', function() {
            alert('Exportando a Excel...');
        });
        
        btnRefrescar.addEventListener('click', function() {
            alert('Actualizando datos...');
        });
        
        // Modal de registro de uso
        function cerrarModalRegistro() {
            modalRegistrarUso.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        btnCerrarModalUso.addEventListener('click', cerrarModalRegistro);
        btnCancelarUso.addEventListener('click', cerrarModalRegistro);
        
        btnGuardarUso.addEventListener('click', function() {
            const equipo = document.getElementById('modalEquipo').value;
            const operador = document.getElementById('modalOperador').value;
            const proyecto = document.getElementById('modalProyecto').value;
            
            if (!equipo || !operador || !proyecto) {
                alert('Por favor complete los campos requeridos');
                return;
            }
            
            alert('Uso registrado correctamente');
            cerrarModalRegistro();
        });
        
        // Cálculo automático de horas
        const horaInicio = document.getElementById('modalHoraInicio');
        const horaFin = document.getElementById('modalHoraFin');
        const horasCalculadas = document.getElementById('modalHorasCalculadas');
        
        function calcularHoras() {
            if (horaInicio.value && horaFin.value) {
                const inicio = horaInicio.value.split(':');
                const fin = horaFin.value.split(':');
                
                const horasInicio = parseInt(inicio[0]) + parseInt(inicio[1]) / 60;
                const horasFin = parseInt(fin[0]) + parseInt(fin[1]) / 60;
                
                let diff = horasFin - horasInicio;
                if (diff < 0) diff += 24;
                
                horasCalculadas.value = diff.toFixed(1);
            }
        }
        
        horaInicio.addEventListener('change', calcularHoras);
        horaFin.addEventListener('change', calcularHoras);
        
        // Modal de detalle de uso
        window.verDetalleUso = function(equipo, fecha) {
            console.log('Viendo detalle:', equipo, fecha);
            modalVerDetalleUso.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };
        
        window.editarUso = function(equipo, fecha) {
            alert('Editar registro de uso - Funcionalidad en desarrollo');
        };
        
        function cerrarModalDetalle() {
            modalVerDetalleUso.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        btnCerrarDetalleUso.addEventListener('click', cerrarModalDetalle);
        btnCerrarDetalle.addEventListener('click', cerrarModalDetalle);
        
        btnEditarDetalle.addEventListener('click', function() {
            alert('Editar registro - Funcionalidad en desarrollo');
            cerrarModalDetalle();
        });
        
        // Cerrar modales al hacer clic fuera
        window.addEventListener('click', function(event) {
            if (event.target === modalRegistrarUso) {
                cerrarModalRegistro();
            }
            if (event.target === modalVerDetalleUso) {
                cerrarModalDetalle();
            }
        });
        
        // Sección Por Equipo
        btnVerEquipo.addEventListener('click', function() {
            const equipo = selectorEquipoDetalle.value;
            if (equipo) {
                infoEquipo.style.display = 'block';
                // Aquí se cargarían los datos del equipo seleccionado
            } else {
                alert('Por favor seleccione un equipo');
            }
        });
        
        // Sección Por Operador
        btnVerOperador.addEventListener('click', function() {
            const operador = selectorOperador.value;
            if (operador) {
                infoOperador.style.display = 'block';
                // Aquí se cargarían los datos del operador seleccionado
            } else {
                alert('Por favor seleccione un operador');
            }
        });
        
        // Paginación
        document.querySelectorAll('.btn-paginacion').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!this.querySelector('i')) {
                    document.querySelectorAll('.btn-paginacion').forEach(b => {
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
    });
</script>
@endsection