@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Presupuesto de Proyecto -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    
                    Presupuesto de Proyecto
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE RESUMEN CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Presupuesto Total -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Presupuesto Total</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalPresupuesto">$156.8M</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Ejecutado -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Ejecutado</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="ejecutado">$89.2M</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Por Ejecutar -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Por Ejecutar</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="porEjecutar">$67.6M</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Avance Global -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Avance Global</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="avanceGlobal">57%</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas con agrupación y botones -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Selector de proyecto a la izquierda -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <select id="selectorProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 350px;">
                            <option value="">Seleccionar proyecto...</option>
                            <option value="PRO-2024-001" selected>🏢 PRO-2024-001 - Torre Norte Corporativa (Oficinas)</option>
                            <option value="PRO-2024-002">🌉 PRO-2024-002 - Puente Vehicular Sur (Infraestructura)</option>
                            <option value="PRO-2024-003">🏭 PRO-2024-003 - Parque Industrial Norte (Naves Industriales)</option>
                            <option value="PRO-2024-004">🏥 PRO-2024-004 - Hospital Regional (Salud)</option>
                            <option value="PRO-2024-005">💧 PRO-2024-005 - Planta de Tratamiento (Hidráulico)</option>
                            <option value="PRO-2024-006">🏘️ PRO-2024-006 - Urbanización Los Álamos (Residencial)</option>
                            <option value="PRO-2024-007">🏫 PRO-2024-007 - Universidad Tecnológica (Educación)</option>
                            <option value="PRO-2024-008">🛣️ PRO-2024-008 - Carretera Costera (Vialidad)</option>
                        </select>
                        
                        <!-- Grupo de agrupación discreto -->
                        <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                            <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar" id="iconoAgrupar"></i>
                            <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                            <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 30px;">
                                <!-- Aquí se mostrarán las columnas agrupadas -->
                            </div>
                        </div>
                    </div>
                    
                    <!-- Grupo de botones derecho -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Selector de sección/área -->
                        <div>
                            <select id="selectorSeccion" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 200px;">
                                <option value="">Todas las secciones</option>
                                <option value="cimentacion">Cimentación</option>
                                <option value="estructura">Estructura</option>
                                <option value="albanileria">Albañilería</option>
                                <option value="acabados">Acabados</option>
                                <option value="instalaciones">Instalaciones</option>
                                <option value="exteriores">Exteriores</option>
                            </select>
                        </div>

                        <!-- Botones de vista -->
                        <div style="display: flex; gap: 5px; background-color: #e9ecef; padding: 4px; border-radius: 8px;">
                            <button class="vista-btn active" data-vista="proyecto" style="padding: 6px 12px; background-color: #083CAE; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 13px;">
                                <i class="fas fa-building"></i> Por Proyecto
                            </button>
                            <button class="vista-btn" data-vista="partidas" style="padding: 6px 12px; background-color: transparent; color: #495057; border: none; border-radius: 6px; cursor: pointer; font-size: 13px;">
                                <i class="fas fa-list"></i> Por Partidas
                            </button>
                        </div>

                        <!-- Botón Agregar (+) -->
                        <div>
                            <button id="btnAgregar" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #083CAE; font-size: 16px;" title="Agregar Partida">
                                <i class="fas fa-plus" style="color: #083CAE;"></i>
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

                        <div>
                            <button id="btnComparar" 
                                    style="background-color: white; border: 1px solid #ffc107; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #ffc107;"
                                    title="Comparar versiones">
                                <i class="fas fa-balance-scale"></i>
                            </button>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar partida..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Información del proyecto seleccionado (más detallada) -->
                <div id="infoProyecto" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; flex-wrap: wrap;">
                        <div>
                            <div style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Proyecto</div>
                            <div style="font-weight: 600; color: #083CAE; font-size: 18px;" id="proyectoNombre">Torre Norte Corporativa</div>
                            <div style="font-size: 13px; color: #495057;" id="proyectoTipo">Oficinas Comerciales</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Responsable</div>
                            <div style="font-weight: 500;" id="proyectoResponsable">Juan Pérez</div>
                            <div style="font-size: 12px; color: #6c757d;" id="proyectoEmail">j.perez@constructora.com</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Cliente</div>
                            <div style="font-weight: 500;" id="proyectoCliente">Inmobiliaria del Sur</div>
                            <div style="font-size: 12px; color: #6c757d;" id="proyectoClienteRFC">RFC: ISU890101ABC</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Fechas</div>
                            <div style="font-weight: 500;" id="proyectoFechas">15/01/2024 - 15/12/2024</div>
                            <div style="font-size: 12px; color: #6c757d;" id="proyectoDuracion">335 días calendario</div>
                        </div>
                    </div>
                    <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #dee2e6; display: flex; gap: 30px; flex-wrap: wrap;">
                        <div><span style="color: #6c757d;">Ubicación:</span> <span id="proyectoUbicacion">Av. Constitución 123, Monterrey, NL</span></div>
                        <div><span style="color: #6c757d;">Contrato:</span> <span id="proyectoContrato">CON-2024-001</span></div>
                        <div><span style="color: #6c757d;">Superficie:</span> <span id="proyectoSuperficie">12,500 m²</span></div>
                    </div>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-calculator" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay partidas para mostrar</p>
                </div>

                <!-- VISTA POR PROYECTO (Resumen detallado) -->
                <div id="vistaProyecto" class="vista-content active">
                    <!-- Gráficos de resumen y métricas clave -->
                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <!-- Distribución por categoría -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-pie"></i> Distribución por Categoría
                            </h4>
                            <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                                <div style="flex: 1; min-width: 200px;">
                                    <div style="margin-bottom: 12px;">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                            <span style="font-size: 13px;">Materiales</span>
                                            <span style="font-size: 13px; font-weight: 600;">$52.8M (45%)</span>
                                        </div>
                                        <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                            <div style="width: 45%; height: 8px; background-color: #2378e1; border-radius: 4px;"></div>
                                        </div>
                                    </div>
                                    <div style="margin-bottom: 12px;">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                            <span style="font-size: 13px;">Mano de Obra</span>
                                            <span style="font-size: 13px; font-weight: 600;">$28.2M (24%)</span>
                                        </div>
                                        <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                            <div style="width: 24%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                        </div>
                                    </div>
                                    <div style="margin-bottom: 12px;">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                            <span style="font-size: 13px;">Maquinaria</span>
                                            <span style="font-size: 13px; font-weight: 600;">$15.2M (13%)</span>
                                        </div>
                                        <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                            <div style="width: 13%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                        </div>
                                    </div>
                                    <div style="margin-bottom: 12px;">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                            <span style="font-size: 13px;">Subcontratos</span>
                                            <span style="font-size: 13px; font-weight: 600;">$14.1M (12%)</span>
                                        </div>
                                        <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                            <div style="width: 12%; height: 8px; background-color: #17a2b8; border-radius: 4px;"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                            <span style="font-size: 13px;">Indirectos</span>
                                            <span style="font-size: 13px; font-weight: 600;">$7.1M (6%)</span>
                                        </div>
                                        <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                            <div style="width: 6%; height: 8px; background-color: #6c757d; border-radius: 4px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="width: 150px; height: 150px; border-radius: 50%; background: conic-gradient(#2378e1 0deg 162deg, #28a745 162deg 248.4deg, #ffc107 248.4deg 295.2deg, #17a2b8 295.2deg 338.4deg, #6c757d 338.4deg 360deg); margin: 0 auto;"></div>
                                    <p style="margin-top: 10px; font-size: 12px; color: #6c757d;">Total: $117.4M</p>
                                </div>
                            </div>
                        </div>

                        <!-- Avance por categoría -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-line"></i> Avance por Categoría
                            </h4>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Materiales</span>
                                    <span style="font-size: 13px; font-weight: 600;">62%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 62%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Mano de Obra</span>
                                    <span style="font-size: 13px; font-weight: 600;">54%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 54%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Maquinaria</span>
                                    <span style="font-size: 13px; font-weight: 600;">71%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 71%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Subcontratos</span>
                                    <span style="font-size: 13px; font-weight: 600;">41%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 41%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Indirectos</span>
                                    <span style="font-size: 13px; font-weight: 600;">48%</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 48%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="font-weight: 600;">Avance Global</span>
                                    <span style="font-weight: 700; color: #083CAE; font-size: 18px;">57%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Métricas rápidas -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-bar"></i> Métricas Clave
                            </h4>
                            <div style="margin-bottom: 15px;">
                                <div style="color: #6c757d; font-size: 12px;">Costo por m²</div>
                                <div style="font-size: 22px; font-weight: 700; color: #083CAE;">$9,380</div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="color: #6c757d; font-size: 12px;">Rendimiento</div>
                                <div style="font-size: 22px; font-weight: 700; color: #28a745;">$285,000/día</div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="color: #6c757d; font-size: 12px;">Desviación</div>
                                <div style="font-size: 22px; font-weight: 700; color: #ffc107;">+3.2%</div>
                            </div>
                            <div>
                                <div style="color: #6c757d; font-size: 12px;">Partidas activas</div>
                                <div style="font-size: 22px; font-weight: 700; color: #083CAE;">187</div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen por secciones/áreas del proyecto -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; margin-bottom: 20px;">
                        <div style="background-color: #f8f9fa; padding: 15px 20px; border-bottom: 2px solid #083CAE; display: flex; justify-content: space-between; align-items: center;">
                            <h5 style="margin: 0; color: #083CAE; font-size: 16px;"><i class="fas fa-layer-group"></i> Resumen por Secciones</h5>
                            <span style="background-color: #083CAE; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">7 secciones</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="padding: 12px; text-align: left;">Sección</th>
                                        <th style="padding: 12px; text-align: right;">Presupuesto</th>
                                        <th style="padding: 12px; text-align: right;">Ejecutado</th>
                                        <th style="padding: 12px; text-align: right;">Pendiente</th>
                                        <th style="padding: 12px; text-align: center;">% Avance</th>
                                        <th style="padding: 12px; text-align: right;">Partidas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 12px;"><strong>Cimentación</strong></td>
                                        <td style="padding: 12px; text-align: right;">$18,500,000</td>
                                        <td style="padding: 12px; text-align: right;">$16,280,000</td>
                                        <td style="padding: 12px; text-align: right;">$2,220,000</td>
                                        <td style="padding: 12px; text-align: center;"><span style="color: #28a745;">88%</span></td>
                                        <td style="padding: 12px; text-align: right;">24</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>Estructura</strong></td>
                                        <td style="padding: 12px; text-align: right;">$32,400,000</td>
                                        <td style="padding: 12px; text-align: right;">$22,680,000</td>
                                        <td style="padding: 12px; text-align: right;">$9,720,000</td>
                                        <td style="padding: 12px; text-align: center;"><span style="color: #ffc107;">70%</span></td>
                                        <td style="padding: 12px; text-align: right;">42</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>Albañilería</strong></td>
                                        <td style="padding: 12px; text-align: right;">$15,200,000</td>
                                        <td style="padding: 12px; text-align: right;">$9,120,000</td>
                                        <td style="padding: 12px; text-align: right;">$6,080,000</td>
                                        <td style="padding: 12px; text-align: center;"><span style="color: #ffc107;">60%</span></td>
                                        <td style="padding: 12px; text-align: right;">28</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>Acabados</strong></td>
                                        <td style="padding: 12px; text-align: right;">$21,800,000</td>
                                        <td style="padding: 12px; text-align: right;">$8,720,000</td>
                                        <td style="padding: 12px; text-align: right;">$13,080,000</td>
                                        <td style="padding: 12px; text-align: center;"><span style="color: #dc3545;">40%</span></td>
                                        <td style="padding: 12px; text-align: right;">35</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>Instalaciones</strong></td>
                                        <td style="padding: 12px; text-align: right;">$18,600,000</td>
                                        <td style="padding: 12px; text-align: right;">$7,440,000</td>
                                        <td style="padding: 12px; text-align: right;">$11,160,000</td>
                                        <td style="padding: 12px; text-align: center;"><span style="color: #dc3545;">40%</span></td>
                                        <td style="padding: 12px; text-align: right;">31</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>Exteriores</strong></td>
                                        <td style="padding: 12px; text-align: right;">$8,500,000</td>
                                        <td style="padding: 12px; text-align: right;">$2,550,000</td>
                                        <td style="padding: 12px; text-align: right;">$5,950,000</td>
                                        <td style="padding: 12px; text-align: center;"><span style="color: #dc3545;">30%</span></td>
                                        <td style="padding: 12px; text-align: right;">18</td>
                                    </tr>
                                </tbody>
                                <tfoot style="background-color: #e9ecef; font-weight: bold;">
                                    <tr>
                                        <td style="padding: 12px;">Totales</td>
                                        <td style="padding: 12px; text-align: right;">$115,000,000</td>
                                        <td style="padding: 12px; text-align: right;">$66,790,000</td>
                                        <td style="padding: 12px; text-align: right;">$48,210,000</td>
                                        <td style="padding: 12px; text-align: center;">58%</td>
                                        <td style="padding: 12px; text-align: right;">178</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Gráfico de avance mensual -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                            <i class="fas fa-chart-line"></i> Avance Mensual Proyectado vs Real
                        </h4>
                        <div style="height: 200px; display: flex; align-items: flex-end; gap: 15px; justify-content: center;">
                            <div style="text-align: center; width: 60px;">
                                <div style="height: 120px; background-color: #2378e1; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="height: 100px; background-color: #28a745; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0; margin-top: -100px;"></div>
                                <div style="margin-top: 5px; font-size: 11px;">Ene</div>
                                <div style="font-size: 10px; color: #6c757d;">$4.2M</div>
                            </div>
                            <div style="text-align: center; width: 60px;">
                                <div style="height: 140px; background-color: #2378e1; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="height: 125px; background-color: #28a745; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0; margin-top: -125px;"></div>
                                <div style="margin-top: 5px; font-size: 11px;">Feb</div>
                                <div style="font-size: 10px; color: #6c757d;">$4.9M</div>
                            </div>
                            <div style="text-align: center; width: 60px;">
                                <div style="height: 160px; background-color: #2378e1; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="height: 145px; background-color: #28a745; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0; margin-top: -145px;"></div>
                                <div style="margin-top: 5px; font-size: 11px;">Mar</div>
                                <div style="font-size: 10px; color: #6c757d;">$5.6M</div>
                            </div>
                            <div style="text-align: center; width: 60px;">
                                <div style="height: 180px; background-color: #2378e1; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="height: 150px; background-color: #28a745; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0; margin-top: -150px;"></div>
                                <div style="margin-top: 5px; font-size: 11px;">Abr</div>
                                <div style="font-size: 10px; color: #6c757d;">$6.3M</div>
                            </div>
                            <div style="text-align: center; width: 60px;">
                                <div style="height: 200px; background-color: #2378e1; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="height: 140px; background-color: #28a745; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0; margin-top: -140px;"></div>
                                <div style="margin-top: 5px; font-size: 11px;">May</div>
                                <div style="font-size: 10px; color: #6c757d;">$7.0M</div>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: center; gap: 30px; margin-top: 20px;">
                            <span style="font-size: 12px; display: flex; align-items: center;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #2378e1; margin-right: 5px;"></span> Proyectado</span>
                            <span style="font-size: 12px; display: flex; align-items: center;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #28a745; margin-right: 5px;"></span> Real</span>
                        </div>
                    </div>
                </div>

                <!-- VISTA POR PARTIDAS (Detallada con secciones y subpartidas) -->
                <div id="vistaPartidas" class="vista-content" style="display: none;">
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 12px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                        <table class="table table-bordered" id="tablaPartidas" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                            <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                                <tr>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="seccion">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Sección</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="codigo">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Código</span>
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
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="unidad">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Unidad</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="cantidad">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Cantidad</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="pu">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>P.U.</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="importe">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Importe</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="ejecutado">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Ejecutado</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="pendiente">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Pendiente</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="avance">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>% Avance</span>
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
                            <tbody id="tablaBody">
                                <!-- Las filas se insertarán dinámicamente con JavaScript -->
                            </tbody>
                            <!-- Fila de totales -->
                            <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold; display: table-footer-group;">
                                <tr>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="7">Totales:</td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumImporte">$0.00</td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumEjecutado">$0.00</td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumPendiente">$0.00</td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" id="promAvance">0%</td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                <!-- Paginación y botón Crear filtro -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px; background: transparent !important; background-color: transparent !important; border: none !important; box-shadow: none !important;">
                    <!-- Botón Crear filtro (izquierda) - SIN FONDO -->
                    <button id="btnCrearFiltro" style="background: transparent !important; background-color: transparent !important; border: none !important; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: #2378e1; box-shadow: none !important; outline: none !important; margin: 0;">
                        <i class="fas fa-filter" style="font-size: 16px; color: #2378e1;"></i>
                        <span style="color: #2378e1;">Crear filtro avanzado</span>
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
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-10 de 187 registros</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Agregar/Editar Partida -->
<div id="modalPartida" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #083CAE;"><i class="fas fa-plus-circle"></i> <span id="modalTitulo">Agregar Partida</span></h3>
            <button id="btnCerrarModal" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #6c757d;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Sección <span style="color: #dc3545;">*</span></label>
                    <select id="modalSeccion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar...</option>
                        <option value="cimentacion">Cimentación</option>
                        <option value="estructura">Estructura</option>
                        <option value="albanileria">Albañilería</option>
                        <option value="acabados">Acabados</option>
                        <option value="instalaciones">Instalaciones</option>
                        <option value="exteriores">Exteriores</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Código <span style="color: #dc3545;">*</span></label>
                    <input type="text" id="modalCodigo" placeholder="Ej: 01.01.001" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Categoría <span style="color: #dc3545;">*</span></label>
                    <select id="modalCategoria" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar...</option>
                        <option value="materiales">Materiales</option>
                        <option value="mano_obra">Mano de Obra</option>
                        <option value="maquinaria">Maquinaria</option>
                        <option value="subcontratos">Subcontratos</option>
                        <option value="indirectos">Indirectos</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción de la Partida <span style="color: #dc3545;">*</span></label>
                <input type="text" id="modalPartidaDesc" placeholder="Ej: Excavación para cimentación" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Unidad</label>
                    <input type="text" id="modalUnidad" placeholder="Ej: m³" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Cantidad</label>
                    <input type="number" id="modalCantidad" placeholder="0.00" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Precio Unitario</label>
                    <input type="text" id="modalPU" placeholder="$0.00" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Importe</label>
                    <div style="background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 4px; padding: 8px; font-weight: 600;" id="modalImporte">$0.00</div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Ejecutado</label>
                    <input type="text" id="modalEjecutado" placeholder="$0.00" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">% Avance</label>
                    <div style="background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 4px; padding: 8px; font-weight: 600;" id="modalAvance">0%</div>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Observaciones</label>
                <textarea id="modalObservaciones" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Notas adicionales, especificaciones técnicas, etc."></textarea>
            </div>

            <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px;">
                <h5 style="margin: 0 0 10px 0; font-size: 14px; color: #083CAE;">Desglose de Costos (Análisis de Precio Unitario)</h5>
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                    <div>
                        <label style="display: block; margin-bottom: 3px; font-size: 12px;">Materiales</label>
                        <input type="text" placeholder="$0.00" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 3px; font-size: 12px;">Mano de Obra</label>
                        <input type="text" placeholder="$0.00" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 3px; font-size: 12px;">Maquinaria</label>
                        <input type="text" placeholder="$0.00" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                    </div>
                </div>
            </div>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelar" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button id="btnGuardar" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Guardar Partida</button>
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
    #tablaBody tr:nth-child(odd) {
        background-color: #ffffff;
    }
    
    #tablaBody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    
    #tablaBody tr:hover {
        background-color: #e0e0e0;
    }
    
    /* Estilo para los iconos de acción */
    #tablaBody td i {
        transition: transform 0.2s;
        font-size: 14px;
        color: #083CAE;
    }
    
    #tablaBody td i:hover {
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
    #tablaBody td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
    }
    
    /* Badges para categorías */
    .badge-categoria {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        font-weight: 600;
    }
    
    .badge-materiales {
        background-color: #cce5ff;
        color: #0d6efd;
    }
    
    .badge-mano-obra {
        background-color: #d4edda;
        color: #28a745;
    }
    
    .badge-maquinaria {
        background-color: #fff3cd;
        color: #ffc107;
    }
    
    .badge-subcontratos {
        background-color: #f8d7da;
        color: #dc3545;
    }
    
    .badge-indirectos {
        background-color: #e9ecef;
        color: #6c757d;
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
    
    /* Botones de vista */
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
    
    .vista-content {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Barra de progreso */
    .progress-mini {
        width: 60px;
        height: 6px;
        background-color: #e9ecef;
        border-radius: 3px;
        display: inline-block;
        margin-right: 5px;
    }
    
    .progress-mini-fill {
        height: 100%;
        border-radius: 3px;
    }
    
    .progress-mini-fill.success { background-color: #28a745; }
    .progress-mini-fill.warning { background-color: #ffc107; }
    .progress-mini-fill.danger { background-color: #dc3545; }
    .progress-mini-fill.primary { background-color: #2378e1; }
    
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
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado - Presupuesto de Proyecto');
        
        // Variables para agrupación
        let columnasAgrupadas = [];
        let expandedGroups = new Set();
        let datosOriginales = [];
        let currentPage = 1;
        let rowsPerPage = 15;
        let totalRows = 0;
        let proyectoSeleccionado = 'PRO-2024-001';
        
        // Datos de ejemplo para proyectos (más detallados)
        const proyectosData = {
            'PRO-2024-001': {
                nombre: 'Torre Norte Corporativa',
                tipo: 'Oficinas Comerciales',
                responsable: 'Juan Pérez',
                email: 'j.perez@constructora.com',
                cliente: 'Inmobiliaria del Sur',
                clienteRFC: 'ISU890101ABC',
                ubicacion: 'Av. Constitución 123, Monterrey, NL',
                contrato: 'CON-2024-001',
                superficie: '12,500 m²',
                inicio: '15/01/2024',
                fin: '15/12/2024',
                duracion: '335 días',
                total: 117400000,
                ejecutado: 66790000,
                partidas: [
                    // SECCIÓN: CIMENTACIÓN
                    { seccion: 'Cimentación', seccion_id: 'cimentacion', codigo: 'CIM-001', partida: 'Excavación masiva', categoria: 'maquinaria', categoria_nombre: 'Maquinaria', unidad: 'm³', cantidad: 4500, pu: 120, importe: 540000, ejecutado: 540000, pendiente: 0, avance: 100 },
                    { seccion: 'Cimentación', seccion_id: 'cimentacion', codigo: 'CIM-002', partida: 'Excavación para zapatas', categoria: 'maquinaria', categoria_nombre: 'Maquinaria', unidad: 'm³', cantidad: 850, pu: 180, importe: 153000, ejecutado: 153000, pendiente: 0, avance: 100 },
                    { seccion: 'Cimentación', seccion_id: 'cimentacion', codigo: 'CIM-003', partida: 'Acero de refuerzo (fy=4200)', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'kg', cantidad: 45000, pu: 32, importe: 1440000, ejecutado: 1440000, pendiente: 0, avance: 100 },
                    { seccion: 'Cimentación', seccion_id: 'cimentacion', codigo: 'CIM-004', partida: 'Concreto f\'c=250 kg/cm²', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'm³', cantidad: 850, pu: 2450, importe: 2082500, ejecutado: 2082500, pendiente: 0, avance: 100 },
                    { seccion: 'Cimentación', seccion_id: 'cimentacion', codigo: 'CIM-005', partida: 'Cimbra para zapatas', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'm²', cantidad: 1200, pu: 380, importe: 456000, ejecutado: 456000, pendiente: 0, avance: 100 },
                    { seccion: 'Cimentación', seccion_id: 'cimentacion', codigo: 'CIM-006', partida: 'Mano de obra - Cimentación', categoria: 'mano_obra', categoria_nombre: 'Mano de Obra', unidad: 'jor', cantidad: 850, pu: 650, importe: 552500, ejecutado: 552500, pendiente: 0, avance: 100 },
                    
                    // SECCIÓN: ESTRUCTURA
                    { seccion: 'Estructura', seccion_id: 'estructura', codigo: 'EST-001', partida: 'Columnas de concreto', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'm³', cantidad: 1250, pu: 2850, importe: 3562500, ejecutado: 3206250, pendiente: 356250, avance: 90 },
                    { seccion: 'Estructura', seccion_id: 'estructura', codigo: 'EST-002', partida: 'Losas de entrepiso', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'm²', cantidad: 8500, pu: 950, importe: 8075000, ejecutado: 6460000, pendiente: 1615000, avance: 80 },
                    { seccion: 'Estructura', seccion_id: 'estructura', codigo: 'EST-003', partida: 'Trabe de acero', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'kg', cantidad: 25000, pu: 45, importe: 1125000, ejecutado: 900000, pendiente: 225000, avance: 80 },
                    { seccion: 'Estructura', seccion_id: 'estructura', codigo: 'EST-004', partida: 'Muro de concreto', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'm³', cantidad: 850, pu: 2650, importe: 2252500, ejecutado: 1802000, pendiente: 450500, avance: 80 },
                    { seccion: 'Estructura', seccion_id: 'estructura', codigo: 'EST-005', partida: 'Escaleras de concreto', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'pza', cantidad: 8, pu: 45000, importe: 360000, ejecutado: 288000, pendiente: 72000, avance: 80 },
                    { seccion: 'Estructura', seccion_id: 'estructura', codigo: 'EST-006', partida: 'Mano de obra - Estructura', categoria: 'mano_obra', categoria_nombre: 'Mano de Obra', unidad: 'jor', cantidad: 3500, pu: 680, importe: 2380000, ejecutado: 1904000, pendiente: 476000, avance: 80 },
                    { seccion: 'Estructura', seccion_id: 'estructura', codigo: 'EST-007', partida: 'Grúa torre', categoria: 'maquinaria', categoria_nombre: 'Maquinaria', unidad: 'mes', cantidad: 8, pu: 85000, importe: 680000, ejecutado: 680000, pendiente: 0, avance: 100 },
                    
                    // SECCIÓN: ALBAÑILERÍA
                    { seccion: 'Albañilería', seccion_id: 'albanileria', codigo: 'ALB-001', partida: 'Muros de block', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'm²', cantidad: 4200, pu: 280, importe: 1176000, ejecutado: 882000, pendiente: 294000, avance: 75 },
                    { seccion: 'Albañilería', seccion_id: 'albanileria', codigo: 'ALB-002', partida: 'Muros de tabique', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'm²', cantidad: 3800, pu: 320, importe: 1216000, ejecutado: 912000, pendiente: 304000, avance: 75 },
                    { seccion: 'Albañilería', seccion_id: 'albanileria', codigo: 'ALB-003', partida: 'Aplanados', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'm²', cantidad: 8500, pu: 95, importe: 807500, ejecutado: 565250, pendiente: 242250, avance: 70 },
                    { seccion: 'Albañilería', seccion_id: 'albanileria', codigo: 'ALB-004', partida: 'Firme de concreto', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'm²', cantidad: 4200, pu: 185, importe: 777000, ejecutado: 543900, pendiente: 233100, avance: 70 },
                    { seccion: 'Albañilería', seccion_id: 'albanileria', codigo: 'ALB-005', partida: 'Mano de obra - Albañilería', categoria: 'mano_obra', categoria_nombre: 'Mano de Obra', unidad: 'jor', cantidad: 2800, pu: 620, importe: 1736000, ejecutado: 1215200, pendiente: 520800, avance: 70 },
                    
                    // SECCIÓN: ACABADOS
                    { seccion: 'Acabados', seccion_id: 'acabados', codigo: 'ACA-001', partida: 'Piso de mármol', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'm²', cantidad: 1250, pu: 1250, importe: 1562500, ejecutado: 625000, pendiente: 937500, avance: 40 },
                    { seccion: 'Acabados', seccion_id: 'acabados', codigo: 'ACA-002', partida: 'Piso cerámico', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'm²', cantidad: 3200, pu: 480, importe: 1536000, ejecutado: 614400, pendiente: 921600, avance: 40 },
                    { seccion: 'Acabados', seccion_id: 'acabados', codigo: 'ACA-003', partida: 'Pintura vinílica', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'm²', cantidad: 12500, pu: 45, importe: 562500, ejecutado: 225000, pendiente: 337500, avance: 40 },
                    { seccion: 'Acabados', seccion_id: 'acabados', codigo: 'ACA-004', partida: 'Plafón de yeso', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'm²', cantidad: 5800, pu: 220, importe: 1276000, ejecutado: 510400, pendiente: 765600, avance: 40 },
                    { seccion: 'Acabados', seccion_id: 'acabados', codigo: 'ACA-005', partida: 'Lambrín de madera', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'm²', cantidad: 850, pu: 890, importe: 756500, ejecutado: 302600, pendiente: 453900, avance: 40 },
                    { seccion: 'Acabados', seccion_id: 'acabados', codigo: 'ACA-006', partida: 'Mano de obra - Acabados', categoria: 'mano_obra', categoria_nombre: 'Mano de Obra', unidad: 'jor', cantidad: 1800, pu: 650, importe: 1170000, ejecutado: 468000, pendiente: 702000, avance: 40 },
                    
                    // SECCIÓN: INSTALACIONES
                    { seccion: 'Instalaciones', seccion_id: 'instalaciones', codigo: 'INS-001', partida: 'Instalación eléctrica', categoria: 'subcontratos', categoria_nombre: 'Subcontratos', unidad: 'global', cantidad: 1, pu: 3850000, importe: 3850000, ejecutado: 1540000, pendiente: 2310000, avance: 40 },
                    { seccion: 'Instalaciones', seccion_id: 'instalaciones', codigo: 'INS-002', partida: 'Instalación hidrosanitaria', categoria: 'subcontratos', categoria_nombre: 'Subcontratos', unidad: 'global', cantidad: 1, pu: 2950000, importe: 2950000, ejecutado: 1180000, pendiente: 1770000, avance: 40 },
                    { seccion: 'Instalaciones', seccion_id: 'instalaciones', codigo: 'INS-003', partida: 'Aire acondicionado', categoria: 'subcontratos', categoria_nombre: 'Subcontratos', unidad: 'global', cantidad: 1, pu: 4250000, importe: 4250000, ejecutado: 1700000, pendiente: 2550000, avance: 40 },
                    { seccion: 'Instalaciones', seccion_id: 'instalaciones', codigo: 'INS-004', partida: 'Sistema contra incendios', categoria: 'subcontratos', categoria_nombre: 'Subcontratos', unidad: 'global', cantidad: 1, pu: 1850000, importe: 1850000, ejecutado: 740000, pendiente: 1110000, avance: 40 },
                    { seccion: 'Instalaciones', seccion_id: 'instalaciones', codigo: 'INS-005', partida: 'Elevadores', categoria: 'subcontratos', categoria_nombre: 'Subcontratos', unidad: 'pza', cantidad: 4, pu: 850000, importe: 3400000, ejecutado: 1360000, pendiente: 2040000, avance: 40 },
                    
                    // SECCIÓN: EXTERIORES
                    { seccion: 'Exteriores', seccion_id: 'exteriores', codigo: 'EXT-001', partida: 'Pavimentación', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'm²', cantidad: 1800, pu: 450, importe: 810000, ejecutado: 243000, pendiente: 567000, avance: 30 },
                    { seccion: 'Exteriores', seccion_id: 'exteriores', codigo: 'EXT-002', partida: 'Banquetas', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'm²', cantidad: 850, pu: 380, importe: 323000, ejecutado: 96900, pendiente: 226100, avance: 30 },
                    { seccion: 'Exteriores', seccion_id: 'exteriores', codigo: 'EXT-003', partida: 'Áreas verdes', categoria: 'subcontratos', categoria_nombre: 'Subcontratos', unidad: 'global', cantidad: 1, pu: 450000, importe: 450000, ejecutado: 135000, pendiente: 315000, avance: 30 },
                    { seccion: 'Exteriores', seccion_id: 'exteriores', codigo: 'EXT-004', partida: 'Cercado perimetral', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'ml', cantidad: 450, pu: 850, importe: 382500, ejecutado: 114750, pendiente: 267750, avance: 30 },
                    { seccion: 'Exteriores', seccion_id: 'exteriores', codigo: 'EXT-005', partida: 'Mano de obra - Exteriores', categoria: 'mano_obra', categoria_nombre: 'Mano de Obra', unidad: 'jor', cantidad: 320, pu: 620, importe: 198400, ejecutado: 59520, pendiente: 138880, avance: 30 }
                ]
            },
            'PRO-2024-002': {
                nombre: 'Puente Vehicular Sur',
                tipo: 'Infraestructura Vial',
                responsable: 'María García',
                email: 'm.garcia@constructora.com',
                cliente: 'Gobierno Regional',
                clienteRFC: 'GRG890202XYZ',
                ubicacion: 'Carretera Nacional km 45, Guadalupe, NL',
                contrato: 'CON-2024-002',
                superficie: '8,200 m²',
                inicio: '01/02/2024',
                fin: '30/11/2024',
                duracion: '303 días',
                total: 28750000,
                ejecutado: 11500000,
                partidas: [
                    { seccion: 'Cimentación', seccion_id: 'cimentacion', codigo: 'CIM-001', partida: 'Pilotaje', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'pza', cantidad: 120, pu: 45000, importe: 5400000, ejecutado: 2160000, pendiente: 3240000, avance: 40 },
                    { seccion: 'Cimentación', seccion_id: 'cimentacion', codigo: 'CIM-002', partida: 'Cabezal de pilotes', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'pza', cantidad: 12, pu: 85000, importe: 1020000, ejecutado: 408000, pendiente: 612000, avance: 40 },
                    { seccion: 'Estructura', seccion_id: 'estructura', codigo: 'EST-001', partida: 'Trabe de cimentación', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'm³', cantidad: 85, pu: 3800, importe: 323000, ejecutado: 161500, pendiente: 161500, avance: 50 },
                    { seccion: 'Estructura', seccion_id: 'estructura', codigo: 'EST-002', partida: 'Columnas', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'm³', cantidad: 120, pu: 4200, importe: 504000, ejecutado: 252000, pendiente: 252000, avance: 50 },
                    { seccion: 'Estructura', seccion_id: 'estructura', codigo: 'EST-003', partida: 'Superestructura', categoria: 'materiales', categoria_nombre: 'Materiales', unidad: 'global', cantidad: 1, pu: 8500000, importe: 8500000, ejecutado: 3400000, pendiente: 5100000, avance: 40 },
                    { seccion: 'Estructura', seccion_id: 'estructura', codigo: 'EST-004', partida: 'Mano de obra - Estructura', categoria: 'mano_obra', categoria_nombre: 'Mano de Obra', unidad: 'jor', cantidad: 1200, pu: 680, importe: 816000, ejecutado: 326400, pendiente: 489600, avance: 40 }
                ]
            }
        };
        
        // Función para formatear moneda
        function formatCurrency(amount) {
            if (amount >= 1000000) {
                return '$' + (amount / 1000000).toFixed(1) + 'M';
            } else if (amount >= 1000) {
                return '$' + (amount / 1000).toFixed(1) + 'K';
            }
            return '$' + amount.toFixed(2);
        }
        
        function formatCurrencyFull(amount) {
            return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        
        // Función para formatear fecha
        function formatDate(dateString) {
            if (!dateString || dateString === '-') return '-';
            return dateString;
        }
        
        // Función para obtener clase de badge según categoría
        function getCategoriaBadgeClass(categoria) {
            switch(categoria) {
                case 'materiales': return 'badge-materiales';
                case 'mano_obra': return 'badge-mano-obra';
                case 'maquinaria': return 'badge-maquinaria';
                case 'subcontratos': return 'badge-subcontratos';
                case 'indirectos': return 'badge-indirectos';
                default: return 'badge-categoria';
            }
        }
        
        // Función para obtener clase de progreso
        function getProgressClass(avance) {
            if (avance >= 75) return 'success';
            if (avance >= 50) return 'primary';
            if (avance >= 25) return 'warning';
            return 'danger';
        }
        
        // Función para actualizar los cuadros de resumen
        function actualizarResumen(proyectoId) {
            if (proyectoId && proyectosData[proyectoId]) {
                const data = proyectosData[proyectoId];
                document.getElementById('totalPresupuesto').textContent = formatCurrency(data.total);
                document.getElementById('ejecutado').textContent = formatCurrency(data.ejecutado);
                
                const porEjecutar = data.total - data.ejecutado;
                document.getElementById('porEjecutar').textContent = formatCurrency(porEjecutar);
                
                const avance = Math.round((data.ejecutado / data.total) * 100);
                document.getElementById('avanceGlobal').textContent = avance + '%';
            }
        }
        
        // Función para actualizar información del proyecto
        function actualizarInfoProyecto(proyectoId) {
            if (proyectoId && proyectosData[proyectoId]) {
                const data = proyectosData[proyectoId];
                document.getElementById('proyectoNombre').textContent = data.nombre;
                document.getElementById('proyectoTipo').textContent = data.tipo;
                document.getElementById('proyectoResponsable').textContent = data.responsable;
                document.getElementById('proyectoEmail').textContent = data.email;
                document.getElementById('proyectoCliente').textContent = data.cliente;
                document.getElementById('proyectoClienteRFC').textContent = 'RFC: ' + data.clienteRFC;
                document.getElementById('proyectoFechas').textContent = data.inicio + ' - ' + data.fin;
                document.getElementById('proyectoDuracion').textContent = data.duracion + ' calendario';
                document.getElementById('proyectoUbicacion').textContent = data.ubicacion;
                document.getElementById('proyectoContrato').textContent = data.contrato;
                document.getElementById('proyectoSuperficie').textContent = data.superficie;
            }
        }
        
        // Función para generar un ID único para el grupo
        function generarGrupoId(item, columnas) {
            return columnas.map(col => {
                switch(col) {
                    case 'seccion': return item.seccion || 'Sin sección';
                    case 'categoria': return item.categoria_nombre || 'Sin categoría';
                    default: return '';
                }
            }).join('||');
        }
        
        // Función para agrupar datos por columnas seleccionadas
        function agruparDatos(datos, columnas) {
            if (columnas.length === 0) return { grupos: [], items: datos };
            
            const gruposMap = new Map();
            
            datos.forEach(item => {
                const grupoId = generarGrupoId(item, columnas);
                
                if (!gruposMap.has(grupoId)) {
                    // Crear un nuevo grupo
                    const valorGrupo = columnas.map(col => {
                        switch(col) {
                            case 'seccion': return item.seccion || 'Sin sección';
                            case 'categoria': return item.categoria_nombre || 'Sin categoría';
                            default: return '';
                        }
                    }).join(' - ');
                    
                    gruposMap.set(grupoId, {
                        id: grupoId,
                        valor: valorGrupo,
                        items: [item],
                        totalImporte: item.importe || 0,
                        totalEjecutado: item.ejecutado || 0,
                        totalPendiente: item.pendiente || 0
                    });
                } else {
                    const grupo = gruposMap.get(grupoId);
                    grupo.items.push(item);
                    grupo.totalImporte += item.importe || 0;
                    grupo.totalEjecutado += item.ejecutado || 0;
                    grupo.totalPendiente += item.pendiente || 0;
                }
            });
            
            return {
                grupos: Array.from(gruposMap.values()),
                items: []
            };
        }
        
        // Función para obtener datos de la página actual
        function getCurrentPageData(datos) {
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            return datos.slice(start, end);
        }
        
        // Función para actualizar la paginación
        function actualizarPaginacion(total) {
            const totalPages = Math.ceil(total / rowsPerPage);
            document.getElementById('paginaActual').textContent = currentPage;
            document.getElementById('paginacionInfo').textContent = `Mostrando ${Math.min((currentPage - 1) * rowsPerPage + 1, total)}-${Math.min(currentPage * rowsPerPage, total)} de ${total} registros`;
        }
        
        // Función para calcular totales
        function calcularTotales(datos) {
            let totalImporte = 0;
            let totalEjecutado = 0;
            let totalPendiente = 0;
            let sumaAvance = 0;
            
            datos.forEach(item => {
                totalImporte += item.importe || 0;
                totalEjecutado += item.ejecutado || 0;
                totalPendiente += item.pendiente || 0;
                sumaAvance += item.avance || 0;
            });
            
            const promedioAvance = datos.length > 0 ? sumaAvance / datos.length : 0;
            
            document.getElementById('sumImporte').textContent = formatCurrencyFull(totalImporte);
            document.getElementById('sumEjecutado').textContent = formatCurrencyFull(totalEjecutado);
            document.getElementById('sumPendiente').textContent = formatCurrencyFull(totalPendiente);
            document.getElementById('promAvance').textContent = promedioAvance.toFixed(1) + '%';
        }
        
        // Función para cargar datos en la tabla de partidas
        function cargarTablaPartidas(proyectoId) {
            const tablaBody = document.getElementById('tablaBody');
            const tablaContainer = document.getElementById('tablaContainer');
            const sinDatosMensaje = document.getElementById('sinDatosMensaje');
            const textoAgrupar = document.getElementById('textoAgrupar');
            const tablaFoot = document.getElementById('tablaFoot');
            
            if (!tablaBody) return;
            
            if (!proyectoId || !proyectosData[proyectoId]) {
                sinDatosMensaje.style.display = 'block';
                tablaContainer.style.display = 'none';
                
                document.getElementById('sumImporte').textContent = '$0.00';
                document.getElementById('sumEjecutado').textContent = '$0.00';
                document.getElementById('sumPendiente').textContent = '$0.00';
                document.getElementById('promAvance').textContent = '0%';
                document.getElementById('paginacionInfo').textContent = 'Mostrando 0-0 de 0 registros';
                return;
            }
            
            const proyecto = proyectosData[proyectoId];
            const partidas = proyecto.partidas;
            datosOriginales = partidas;
            
            sinDatosMensaje.style.display = 'none';
            tablaContainer.style.display = 'block';
            
            // Actualizar información del proyecto y resumen
            actualizarInfoProyecto(proyectoId);
            actualizarResumen(proyectoId);
            
            // Ocultar texto de agrupar si hay columnas agrupadas
            if (textoAgrupar) {
                textoAgrupar.style.display = columnasAgrupadas.length > 0 ? 'none' : 'inline';
            }
            
            // Aplicar agrupación si hay columnas seleccionadas
            const { grupos } = agruparDatos(partidas, columnasAgrupadas);
            const hayGrupos = grupos.length > 0 && columnasAgrupadas.length > 0;
            
            // Limpiar tabla
            tablaBody.innerHTML = '';
            
            if (hayGrupos) {
                // Ocultar pie de tabla cuando hay grupos
                if (tablaFoot) tablaFoot.style.display = 'none';
                
                // Mostrar grupos
                grupos.forEach(grupo => {
                    const grupoRow = document.createElement('tr');
                    grupoRow.className = 'fila-grupo';
                    grupoRow.dataset.grupoId = grupo.id;
                    
                    if (expandedGroups.has(grupo.id)) {
                        grupoRow.classList.add('expandido');
                    }
                    
                    grupoRow.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;" colspan="12">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                                    <strong style="color: #2378e1;">${grupo.valor}</strong>
                                    <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                        (${grupo.items.length} partidas - Importe: ${formatCurrencyFull(grupo.totalImporte)} - Ejecutado: ${formatCurrencyFull(grupo.totalEjecutado)})
                                    </span>
                                </div>
                            </div>
                        </td>
                    `;
                    
                    tablaBody.appendChild(grupoRow);
                    
                    // Mostrar items del grupo si está expandido
                    if (expandedGroups.has(grupo.id)) {
                        grupo.items.forEach(item => {
                            const detalleRow = document.createElement('tr');
                            detalleRow.className = 'fila-detalle';
                            
                            let categoriaBadge = getCategoriaBadgeClass(item.categoria);
                            
                            detalleRow.innerHTML = `
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; padding-left: 30px;">${item.seccion}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.codigo}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.partida}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge-categoria ${categoriaBadge}">${item.categoria_nombre}</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.unidad}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.cantidad.toLocaleString()}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${formatCurrencyFull(item.pu)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${formatCurrencyFull(item.importe)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${formatCurrencyFull(item.ejecutado)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${formatCurrencyFull(item.pendiente)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">
                                    <div style="display: flex; align-items: center; gap: 5px;">
                                        <div class="progress-mini">
                                            <div class="progress-mini-fill ${getProgressClass(item.avance)}" style="width: ${item.avance}%"></div>
                                        </div>
                                        ${item.avance}%
                                    </div>
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetallePartida('${item.codigo}')"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" onclick="editarPartida('${item.codigo}')"></i>
                                        <i class="fas fa-copy" style="color: #ffc107; cursor: pointer; font-size: 14px;" title="Duplicar" onclick="duplicarPartida('${item.codigo}')"></i>
                                    </div>
                                </td>
                            `;
                            
                            tablaBody.appendChild(detalleRow);
                        });
                    }
                });
                
                if (paginacionInfo) {
                    const totalRegistros = partidas.length;
                    const mostrando = grupos.length;
                    paginacionInfo.textContent = `Mostrando ${mostrando} grupos de ${totalRegistros} registros`;
                }
            } else {
                // Mostrar todos los items sin agrupar (con paginación)
                const pageData = getCurrentPageData(partidas);
                
                pageData.forEach(item => {
                    const row = document.createElement('tr');
                    
                    let categoriaBadge = getCategoriaBadgeClass(item.categoria);
                    
                    row.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.seccion}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.codigo}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.partida}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge-categoria ${categoriaBadge}">${item.categoria_nombre}</span></td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.unidad}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.cantidad.toLocaleString()}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${formatCurrencyFull(item.pu)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${formatCurrencyFull(item.importe)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${formatCurrencyFull(item.ejecutado)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${formatCurrencyFull(item.pendiente)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">
                            <div style="display: flex; align-items: center; gap: 5px;">
                                <div class="progress-mini">
                                    <div class="progress-mini-fill ${getProgressClass(item.avance)}" style="width: ${item.avance}%"></div>
                                </div>
                                ${item.avance}%
                            </div>
                        </td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetallePartida('${item.codigo}')"></i>
                                <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" onclick="editarPartida('${item.codigo}')"></i>
                                <i class="fas fa-copy" style="color: #ffc107; cursor: pointer; font-size: 14px;" title="Duplicar" onclick="duplicarPartida('${item.codigo}')"></i>
                            </div>
                        </td>
                    `;
                    
                    tablaBody.appendChild(row);
                });
                
                // Mostrar pie de tabla con totales
                if (tablaFoot) tablaFoot.style.display = 'table-footer-group';
                calcularTotales(partidas);
                
                actualizarPaginacion(partidas.length);
            }
        }
        
        // Función para actualizar la visualización de columnas agrupadas
        function actualizarGrupoColumnas() {
            const grupoContainer = document.getElementById('grupoColumnas');
            const textoAgrupar = document.getElementById('textoAgrupar');
            
            if (!grupoContainer) return;
            
            grupoContainer.innerHTML = '';
            
            if (columnasAgrupadas.length === 0) {
                if (textoAgrupar) textoAgrupar.style.display = 'inline';
            } else {
                if (textoAgrupar) textoAgrupar.style.display = 'none';
                
                columnasAgrupadas.forEach(col => {
                    const nombreColumna = {
                        'seccion': 'Sección',
                        'categoria': 'Categoría'
                    }[col] || col;
                    
                    const chip = document.createElement('span');
                    chip.className = 'columna-agrupada';
                    chip.innerHTML = `
                        ${nombreColumna}
                        <span class="remover" data-columna="${col}">&times;</span>
                    `;
                    grupoContainer.appendChild(chip);
                });
            }
            
            // Limpiar grupos expandidos al cambiar agrupación
            expandedGroups.clear();
            
            // Recargar tabla con nueva agrupación
            cargarTablaPartidas(proyectoSeleccionado);
        }
        
        // Configurar drag and drop
        function setupDragAndDrop() {
            const encabezados = document.querySelectorAll('th[draggable="true"]');
            const grupoAgrupacion = document.getElementById('grupoAgrupacion');
            
            encabezados.forEach(th => {
                th.addEventListener('dragstart', (e) => {
                    e.dataTransfer.setData('text/plain', th.dataset.columna);
                    e.dataTransfer.effectAllowed = 'copy';
                    th.style.opacity = '0.5';
                });
                
                th.addEventListener('dragend', (e) => {
                    th.style.opacity = '1';
                });
            });
            
            grupoAgrupacion.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'copy';
                grupoAgrupacion.classList.add('drag-over');
            });
            
            grupoAgrupacion.addEventListener('dragleave', () => {
                grupoAgrupacion.classList.remove('drag-over');
            });
            
            grupoAgrupacion.addEventListener('drop', (e) => {
                e.preventDefault();
                grupoAgrupacion.classList.remove('drag-over');
                
                const columna = e.dataTransfer.getData('text/plain');
                
                if (columna && !columnasAgrupadas.includes(columna)) {
                    columnasAgrupadas.push(columna);
                    actualizarGrupoColumnas();
                }
            });
            
            // Event listener para remover columnas (usando delegación)
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('remover')) {
                    const columna = e.target.dataset.columna;
                    columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
                    actualizarGrupoColumnas();
                }
            });
        }
        
        // Event listener para expandir/colapsar grupos
        document.addEventListener('click', function(e) {
            const filaGrupo = e.target.closest('.fila-grupo');
            if (filaGrupo) {
                const grupoId = filaGrupo.dataset.grupoId;
                const icono = filaGrupo.querySelector('i');
                
                if (expandedGroups.has(grupoId)) {
                    expandedGroups.delete(grupoId);
                    filaGrupo.classList.remove('expandido');
                    if (icono) icono.className = 'fas fa-caret-right';
                } else {
                    expandedGroups.add(grupoId);
                    filaGrupo.classList.add('expandido');
                    if (icono) icono.className = 'fas fa-caret-down';
                }
                
                // Recargar tabla para mostrar/ocultar detalles
                cargarTablaPartidas(proyectoSeleccionado);
            }
        });
        
        // Cambio de vista (Proyecto / Partidas)
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
                document.getElementById(`vista${vista.charAt(0).toUpperCase() + vista.slice(1)}`).style.display = 'block';
            });
        });
        
        // Selector de proyecto
        const selectorProyecto = document.getElementById('selectorProyecto');
        selectorProyecto.addEventListener('change', function() {
            proyectoSeleccionado = this.value;
            currentPage = 1;
            cargarTablaPartidas(proyectoSeleccionado);
        });
        
        // Selector de sección
        const selectorSeccion = document.getElementById('selectorSeccion');
        selectorSeccion.addEventListener('change', function() {
            const seccion = this.value;
            if (!proyectoSeleccionado || !proyectosData[proyectoSeleccionado]) return;
            
            const partidas = proyectosData[proyectoSeleccionado].partidas;
            
            if (!seccion) {
                datosOriginales = partidas;
            } else {
                datosOriginales = partidas.filter(item => item.seccion_id === seccion);
            }
            currentPage = 1;
            cargarTablaPartidas(proyectoSeleccionado);
        });
        
        // Buscador
        document.getElementById('buscador').addEventListener('input', function(e) {
            if (!proyectoSeleccionado || !proyectosData[proyectoSeleccionado]) return;
            
            const busqueda = e.target.value.toLowerCase();
            const partidas = proyectosData[proyectoSeleccionado].partidas;
            
            const datosFiltrados = partidas.filter(item => 
                item.partida?.toLowerCase().includes(busqueda) ||
                item.codigo?.toLowerCase().includes(busqueda) ||
                item.seccion?.toLowerCase().includes(busqueda) ||
                item.categoria_nombre?.toLowerCase().includes(busqueda)
            );
            
            datosOriginales = datosFiltrados;
            currentPage = 1;
            
            if (datosFiltrados.length === 0) {
                document.getElementById('tablaBody').innerHTML = '';
                document.getElementById('sinDatosMensaje').style.display = 'block';
                document.getElementById('tablaContainer').style.display = 'none';
            } else {
                document.getElementById('sinDatosMensaje').style.display = 'none';
                document.getElementById('tablaContainer').style.display = 'block';
                
                const pageData = getCurrentPageData(datosFiltrados);
                const tablaBody = document.getElementById('tablaBody');
                tablaBody.innerHTML = '';
                
                pageData.forEach(item => {
                    const row = document.createElement('tr');
                    let categoriaBadge = getCategoriaBadgeClass(item.categoria);
                    
                    row.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.seccion}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.codigo}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.partida}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px;"><span class="badge-categoria ${categoriaBadge}">${item.categoria_nombre}</span></td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">${item.unidad}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${item.cantidad.toLocaleString()}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${formatCurrencyFull(item.pu)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${formatCurrencyFull(item.importe)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${formatCurrencyFull(item.ejecutado)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${formatCurrencyFull(item.pendiente)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px;">
                            <div style="display: flex; align-items: center; gap: 5px;">
                                <div class="progress-mini">
                                    <div class="progress-mini-fill ${getProgressClass(item.avance)}" style="width: ${item.avance}%"></div>
                                </div>
                                ${item.avance}%
                            </div>
                        </td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;"></i>
                                <i class="fas fa-edit" style="color: #083CAE; cursor: pointer;"></i>
                                <i class="fas fa-copy" style="color: #ffc107; cursor: pointer;"></i>
                            </div>
                        </td>
                    `;
                    tablaBody.appendChild(row);
                });
                
                calcularTotales(datosFiltrados);
                actualizarPaginacion(datosFiltrados.length);
            }
        });
        
        // Paginación
        function cambiarPagina(delta) {
            const totalPages = Math.ceil(datosOriginales.length / rowsPerPage);
            const nuevaPagina = currentPage + delta;
            
            if (nuevaPagina >= 1 && nuevaPagina <= totalPages) {
                currentPage = nuevaPagina;
                cargarTablaPartidas(proyectoSeleccionado);
            }
        }
        
        document.getElementById('btnPrimera').addEventListener('click', () => {
            if (datosOriginales.length > 0) {
                currentPage = 1;
                cargarTablaPartidas(proyectoSeleccionado);
            }
        });
        
        document.getElementById('btnAnterior').addEventListener('click', () => cambiarPagina(-1));
        document.getElementById('btnSiguiente').addEventListener('click', () => cambiarPagina(1));
        
        document.getElementById('btnUltima').addEventListener('click', () => {
            if (datosOriginales.length > 0) {
                currentPage = Math.ceil(datosOriginales.length / rowsPerPage);
                cargarTablaPartidas(proyectoSeleccionado);
            }
        });
        
        // Botones de acción
        document.getElementById('btnAgregar').addEventListener('click', () => {
            document.getElementById('modalTitulo').textContent = 'Agregar Partida';
            document.getElementById('modalPartida').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
        
        document.getElementById('btnExcel').addEventListener('click', () => {
            alert('Exportando a Excel...');
        });
        
        document.getElementById('btnComparar').addEventListener('click', () => {
            alert('Comparar versiones de presupuesto - Funcionalidad en desarrollo');
        });
        
        document.getElementById('btnCrearFiltro').addEventListener('click', () => {
            alert('Crear filtro avanzado - Funcionalidad en desarrollo');
        });
        
        // Modal de partida
        const modalPartida = document.getElementById('modalPartida');
        const btnCerrarModal = document.getElementById('btnCerrarModal');
        const btnCancelar = document.getElementById('btnCancelar');
        const btnGuardar = document.getElementById('btnGuardar');
        
        function cerrarModal() {
            modalPartida.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        btnCerrarModal.addEventListener('click', cerrarModal);
        btnCancelar.addEventListener('click', cerrarModal);
        
        btnGuardar.addEventListener('click', () => {
            const codigo = document.getElementById('modalCodigo').value;
            const partida = document.getElementById('modalPartidaDesc').value;
            
            if (!codigo || !partida) {
                alert('Por favor complete los campos requeridos');
                return;
            }
            
            alert('Partida guardada correctamente');
            cerrarModal();
        });
        
        window.addEventListener('click', function(event) {
            if (event.target === modalPartida) {
                cerrarModal();
            }
        });
        
        // Cálculo automático de importe
        function calcularImporte() {
            const cantidad = parseFloat(document.getElementById('modalCantidad').value) || 0;
            const pu = parseFloat(document.getElementById('modalPU').value) || 0;
            const importe = cantidad * pu;
            document.getElementById('modalImporte').textContent = formatCurrencyFull(importe);
            
            // Calcular avance si hay ejecutado
            const ejecutado = parseFloat(document.getElementById('modalEjecutado').value) || 0;
            if (importe > 0) {
                const avance = Math.round((ejecutado / importe) * 100);
                document.getElementById('modalAvance').textContent = avance + '%';
            }
        }
        
        document.getElementById('modalCantidad').addEventListener('input', calcularImporte);
        document.getElementById('modalPU').addEventListener('input', calcularImporte);
        document.getElementById('modalEjecutado').addEventListener('input', calcularImporte);
        
        // Funciones para acciones de partidas
        window.verDetallePartida = function(codigo) {
            alert('Ver detalle de partida ' + codigo);
        };
        
        window.editarPartida = function(codigo) {
            document.getElementById('modalTitulo').textContent = 'Editar Partida: ' + codigo;
            modalPartida.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            // Aquí se cargarían los datos de la partida
        };
        
        window.duplicarPartida = function(codigo) {
            document.getElementById('modalTitulo').textContent = 'Duplicar Partida: ' + codigo;
            modalPartida.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            // Aquí se duplicarían los datos
        };
        
        // Filtros en encabezados
        document.querySelectorAll('.table th i.fa-filter').forEach(icon => {
            icon.addEventListener('click', () => alert('Filtro de columna - Funcionalidad en desarrollo'));
        });
        
        // Inicializar con el primer proyecto
        cargarTablaPartidas('PRO-2024-001');
        setupDragAndDrop();
    });
</script>
@endsection