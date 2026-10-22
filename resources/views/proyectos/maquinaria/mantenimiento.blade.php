@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Mantenimiento de Equipo -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Mantenimiento de Equipo
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE MANTENIMIENTO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">En Mantenimiento</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="enMantenimiento">0</div>
                        </div>
                    </div>

                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Programados</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="programados">0</div>
                        </div>
                    </div>

                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Completados</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="completados">0</div>
                        </div>
                    </div>

                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Costo Mensual</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="costoMensual">$0.00</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <select id="selectorProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 250px;">
                            <option value="">Todos los proyectos</option>
                        </select>

                        <select id="selectorTipoMantto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 180px;">
                            <option value="">Todos los tipos</option>
                            <option value="preventivo">Preventivo</option>
                            <option value="correctivo">Correctivo</option>
                            <option value="predictivo">Predictivo</option>
                        </select>

                        <select id="selectorStatus" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                            <option value="">Todos los estados</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="en_proceso">En Proceso</option>
                            <option value="completado">Completado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>

                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <button id="btnRegistrarMantto" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Registrar Mantenimiento">
                                <i class="fas fa-plus-circle"></i> Registrar
                            </button>
                        </div>

                        <div>
                            <button id="btnProgramar" style="background-color: white; border: 1px solid #ffc107; color: #ffc107; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Programar Mantenimiento">
                                <i class="fas fa-calendar-plus"></i> Programar
                            </button>
                        </div>

                        <div>
                            <button id="btnExcel" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;" title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                                Exportar
                            </button>
                        </div>

                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar equipo..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Pestañas de secciones -->
                <div style="display: flex; gap: 2px; margin-bottom: 20px; border-bottom: 2px solid #083CAE; overflow-x: auto; white-space: nowrap;">
                    <button class="mantenimiento-tab active" data-tab="activos" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-wrench"></i> Mantenimientos Activos
                        <span style="background-color: #dc3545; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;">0</span>
                    </button>
                    <button class="mantenimiento-tab" data-tab="programados" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-calendar-alt"></i> Programados
                        <span style="background-color: #ffc107; color: #856404; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;">0</span>
                    </button>
                    <button class="mantenimiento-tab" data-tab="historial" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-history"></i> Historial
                    </button>
                    <button class="mantenimiento-tab" data-tab="costos" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-dollar-sign"></i> Costos
                    </button>
                    <button class="mantenimiento-tab" data-tab="alertas" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-exclamation-triangle"></i> Alertas
                        <span style="background-color: #dc3545; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;">0</span>
                    </button>
                </div>

                <!-- SECCIÓN 1: MANTENIMIENTOS ACTIVOS -->
                <div id="tab-activos" class="mantenimiento-content active">
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Equipo</th>
                                    <th style="padding: 12px;">Tipo</th>
                                    <th style="padding: 12px;">Proyecto</th>
                                    <th style="padding: 12px;">Fecha Inicio</th>
                                    <th style="padding: 12px;">Fecha Fin Estimada</th>
                                    <th style="padding: 12px;">Responsable</th>
                                    <th style="padding: 12px;">Estado</th>
                                    <th style="padding: 12px;">Prioridad</th>
                                    <th style="padding: 12px;">Avance</th>
                                    <th style="padding: 12px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaActivos"></tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 2: PROGRAMADOS -->
                <div id="tab-programados" class="mantenimiento-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;" id="calendarioProximos">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-calendar-alt"></i> Próximos 7 días
                            </h4>
                            <div id="listaProximos7Dias">
                                <div style="padding: 15px; text-align: center; color: #6c757d;">Cargando...</div>
                            </div>
                        </div>

                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;" id="graficoPorTipo">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-pie"></i> Por Tipo
                            </h4>
                            <div id="listaPorTipo">
                                <div style="padding: 15px; text-align: center; color: #6c757d;">Cargando...</div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Equipo</th>
                                    <th style="padding: 12px;">Tipo</th>
                                    <th style="padding: 12px;">Proyecto</th>
                                    <th style="padding: 12px;">Fecha Programada</th>
                                    <th style="padding: 12px;">Técnico Asignado</th>
                                    <th style="padding: 12px;">Prioridad</th>
                                    <th style="padding: 12px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaProgramados"></tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 3: HISTORIAL -->
                <div id="tab-historial" class="mantenimiento-content" style="display: none;">
                    <div style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                        <select id="filtroPeriodo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="30">Últimos 30 días</option>
                            <option value="90">Últimos 90 días</option>
                            <option value="365">Este año</option>
                        </select>
                        <select id="filtroTipoHistorial" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="">Todos los tipos</option>
                            <option value="preventivo">Preventivo</option>
                            <option value="correctivo">Correctivo</option>
                            <option value="predictivo">Predictivo</option>
                        </select>
                    </div>

                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Fecha</th>
                                    <th style="padding: 12px;">Equipo</th>
                                    <th style="padding: 12px;">Tipo</th>
                                    <th style="padding: 12px;">Descripción</th>
                                    <th style="padding: 12px;">Responsable</th>
                                    <th style="padding: 12px; text-align: right;">Costo</th>
                                    <th style="padding: 12px;">Duración</th>
                                    <th style="padding: 12px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaHistorial"></tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 4: COSTOS -->
                <div id="tab-costos" class="mantenimiento-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;" id="graficoCostosMensuales">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-line"></i> Costos Mensuales
                            </h4>
                            <div id="contenedorGraficoBarras" style="height: 200px; display: flex; align-items: flex-end; gap: 15px; justify-content: center;">
                                <div style="padding: 15px; text-align: center; color: #6c757d;">Cargando datos...</div>
                            </div>
                        </div>

                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;" id="graficoDistribucion">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-pie"></i> Distribución
                            </h4>
                            <div id="contenedorDistribucion">
                                <div style="padding: 15px; text-align: center; color: #6c757d;">Cargando datos...</div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Equipo</th>
                                    <th style="padding: 12px;">No. Mantenimientos</th>
                                    <th style="padding: 12px; text-align: right;">Costo Total</th>
                                    <th style="padding: 12px; text-align: right;">Promedio por Mantto</th>
                                    <th style="padding: 12px; text-align: right;">Último Mantto</th>
                                    <th style="padding: 12px; text-align: center;">Tendencia</th>
                                </tr>
                            </thead>
                            <tbody id="tablaCostos"></tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 5: ALERTAS -->
                <div id="tab-alertas" class="mantenimiento-content" style="display: none;">
                    <div style="margin-bottom: 20px;">
                        <h4 style="color: #dc3545; margin: 0 0 10px 0; font-size: 16px;">
                            <i class="fas fa-exclamation-circle"></i> Críticas
                        </h4>
                        <div id="alertasCriticas">
                            <div style="padding: 15px; text-align: center; color: #6c757d;">Cargando...</div>
                        </div>

                        <h4 style="color: #ffc107; margin: 20px 0 10px 0; font-size: 16px;">
                            <i class="fas fa-exclamation-triangle"></i> Preventivas
                        </h4>
                        <div id="alertasPreventivas">
                            <div style="padding: 15px; text-align: center; color: #6c757d;">Cargando...</div>
                        </div>

                        <h4 style="color: #0d6efd; margin: 20px 0 10px 0; font-size: 16px;">
                            <i class="fas fa-info-circle"></i> Información
                        </h4>
                        <div id="alertasInformacion">
                            <div style="padding: 15px; text-align: center; color: #6c757d;">Cargando...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ========================================================= -->
<!-- MODAL: REGISTRAR / PROGRAMAR MANTENIMIENTO                -->
<!-- ========================================================= -->
<div id="modalRegistrarMantto" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 id="tituloModalMantto" style="margin: 0; color: white;"><i class="fas fa-tools"></i> Registrar Mantenimiento</h3>
            <button id="btnCerrarModalMantto" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>

        <div style="padding: 20px;">
            <form id="formMantenimiento">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Equipo <span style="color: #dc3545;">*</span></label>
                    <select id="modalEquipo" name="activo_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        <option value="">Seleccionar equipo...</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Tipo Mantenimiento <span style="color: #dc3545;">*</span></label>
                        <select id="modalTipoMantto" name="tipo_mantenimiento" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="preventivo">Preventivo</option>
                            <option value="correctivo">Correctivo</option>
                            <option value="predictivo">Predictivo</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Prioridad</label>
                        <select id="modalPrioridad" name="prioridad" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="alta">Alta</option>
                            <option value="media" selected>Media</option>
                            <option value="baja">Baja</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Fecha Inicio <span style="color: #dc3545;">*</span></label>
                        <input type="date" id="modalFechaInicio" name="fecha_inicio" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Fecha Estimada Fin</label>
                        <input type="date" id="modalFechaFin" name="fecha_fin_estimada" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Responsable</label>
                    <input type="text" id="modalResponsable" name="responsable_asignado" placeholder="Taller Mecánico / Proveedor" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Descripción <span style="color: #dc3545;">*</span></label>
                    <textarea id="modalDescripcion" name="descripcion" rows="3" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;" placeholder="Describa las actividades a realizar..."></textarea>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Costo Estimado</label>
                    <input type="number" id="modalCosto" name="costo" step="0.01" min="0" placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                </div>
            </form>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelarMantto" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Cancelar</button>
            <button id="btnGuardarMantto" style="padding: 8px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- MODAL: EDITAR MANTENIMIENTO                               -->
<!-- ========================================================= -->
<div id="modalEditarMantto" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-edit"></i> Editar Mantenimiento</h3>
            <button id="btnCerrarModalEditar" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>

        <div style="padding: 20px;">
            <form id="formEditarMantto">
                <input type="hidden" id="editManttoId">

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Equipo</label>
                    <select id="editManttoEquipo" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        <option value="">Seleccionar equipo...</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Tipo</label>
                        <select id="editManttoTipo" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="preventivo">Preventivo</option>
                            <option value="correctivo">Correctivo</option>
                            <option value="predictivo">Predictivo</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Prioridad</label>
                        <select id="editManttoPrioridad" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="alta">Alta</option>
                            <option value="media">Media</option>
                            <option value="baja">Baja</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Fecha Inicio</label>
                        <input type="date" id="editManttoFechaInicio" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Fecha Estimada Fin</label>
                        <input type="date" id="editManttoFechaFin" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Responsable</label>
                    <input type="text" id="editManttoResponsable" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Descripción</label>
                    <textarea id="editManttoDescripcion" rows="3" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Costo</label>
                    <input type="number" id="editManttoCosto" step="0.01" min="0" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                </div>
            </form>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelarEditar" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Cancelar</button>
            <button id="btnGuardarEditar" style="padding: 8px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- MODAL: CERRAR MANTENIMIENTO                               -->
<!-- ========================================================= -->
<div id="modalCerrarMantto" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 500px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-flag-checkered"></i> Cerrar Mantenimiento</h3>
            <button id="btnCerrarModalCerrar" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>

        <div style="padding: 20px;">
            <input type="hidden" id="cerrarManttoId">

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Fecha Fin Real <span style="color: #dc3545;">*</span></label>
                <input type="date" id="cerrarFechaFin" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Costo Real</label>
                <input type="number" id="cerrarCosto" step="0.01" min="0" placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Observaciones</label>
                <textarea id="cerrarObservaciones" rows="3" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;" placeholder="Observaciones finales..."></textarea>
            </div>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelarCerrar" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Cancelar</button>
            <button id="btnConfirmarCierre" style="padding: 8px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                <i class="fas fa-check-circle"></i> Confirmar Cierre
            </button>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- MODAL: VER DETALLE                                        -->
<!-- ========================================================= -->
<div id="modalVerDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-clipboard-list"></i> Detalle de Mantenimiento
            </h3>
            <button id="btnCerrarDetalle" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>

        <div style="padding: 20px;" id="contenidoDetalle">
            <div style="text-align: center; padding: 40px; color: #6c757d;">
                <i class="fas fa-spinner fa-spin" style="font-size: 36px;"></i>
                <p style="margin-top: 10px;">Cargando detalle...</p>
            </div>
        </div>
    </div>
</div>

<style>
    .semaforo .card-header { background-color: #f4f6f9; border-bottom: 2px solid #083CAE; }
    .semaforo .card-header h2 { color: #083CAE !important; }
    .custom-card { transition: transform 0.2s, box-shadow 0.2s; height: 100%; }
    .custom-card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(8, 60, 174, 0.15) !important; border-color: #083CAE !important; }

    .table th { white-space: nowrap; font-size: 12px; background-color: #2378e1 !important; color: white; font-weight: 600; padding: 10px 4px; }
    .table td { font-size: 12px; padding: 10px 4px; color: #000000 !important; vertical-align: middle; }

    .table td:last-child,
    .table th:last-child {
        white-space: nowrap;
        min-width: 120px;
        text-align: center;
    }

    #tablaActivos tr:nth-child(odd) { background-color: #ffffff; }
    #tablaActivos tr:nth-child(even) { background-color: #f2f2f2; }
    #tablaActivos tr:hover { background-color: #e0e0e0; }

    .mantenimiento-tab { transition: all 0.3s ease; }
    .mantenimiento-tab:hover { opacity: 0.9; transform: translateY(-2px); }
    .mantenimiento-tab.active { background-color: #083CAE !important; color: white !important; }
    .mantenimiento-content { animation: fadeIn 0.3s ease; }

    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    .badge-prioridad-alta { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
    .badge-prioridad-media { background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
    .badge-prioridad-baja { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
    .badge-estado-pendiente { background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
    .badge-estado-en_proceso { background-color: #0d6efd; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
    .badge-estado-completado { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
    .badge-estado-cancelado { background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }

    .badge-tipo-preventivo { background-color: #0d6efd; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
    .badge-tipo-correctivo { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
    .badge-tipo-predictivo { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }

    .toast-notification { position: fixed; bottom: 20px; right: 20px; z-index: 100000; animation: slideIn 0.3s ease; padding: 12px 20px; border-radius: 8px; margin-bottom: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); font-size: 14px; }
    .toast-notification.success { background-color: #28a745; color: white; }
    .toast-notification.error { background-color: #dc3545; color: white; }
    .toast-notification.warning { background-color: #ffc107; color: #333; }

    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

    @media (max-width: 768px) {
        input[type="date"] { width: 100% !important; }
        input#buscador { width: 100% !important; }
        #selectorProyecto { min-width: 100% !important; }
        #modalRegistrarMantto > div, #modalVerDetalle > div, #modalEditarMantto > div, #modalCerrarMantto > div { width: 95%; margin: 10px; }
        .mantenimiento-tab { padding: 8px 12px !important; font-size: 12px !important; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado - Mantenimiento de Equipo');

    // ============================================
    // CONFIGURACIÓN
    // ============================================
    const API_BASE = '/proyectos/maquinaria/mantenimiento';
    const API_MAQUINARIA = '/proyectos/maquinaria';
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    let currentTab = 'activos';
    let modoModal = 'registrar';
    let buscarTimeout = null;

    // ============================================
    // HELPERS
    // ============================================
    function ucfirst(str) {
        if (!str) return '';
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function formatDate(dateString) {
        if (!dateString) return '-';
        try {
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return '-';
            return date.toLocaleDateString('es-MX', {
                year: 'numeric', month: '2-digit', day: '2-digit'
            });
        } catch { return '-'; }
    }

    function calcularDuracion(inicio, fin) {
        if (!inicio || !fin) return '-';
        try {
            const start = new Date(inicio);
            const end = new Date(fin);
            const diff = Math.abs(end - start);
            const horas = Math.floor(diff / (1000 * 60 * 60));
            if (horas < 1) {
                const minutos = Math.floor(diff / (1000 * 60));
                return `${minutos} min`;
            }
            return `${horas} hrs`;
        } catch { return '-'; }
    }

    function getTipoColor(tipo) {
        const colores = { 'preventivo': '#0d6efd', 'correctivo': '#dc3545', 'predictivo': '#28a745' };
        return colores[tipo] || '#6c757d';
    }

    function getPrioridadBadge(prioridad) {
        const badges = {
            'alta': { class: 'badge-prioridad-alta', label: 'Alta' },
            'media': { class: 'badge-prioridad-media', label: 'Media' },
            'baja': { class: 'badge-prioridad-baja', label: 'Baja' }
        };
        return badges[prioridad] || badges['media'];
    }

    function getEstadoBadge(estado) {
        const badges = {
            'pendiente': { class: 'badge-estado-pendiente', label: 'Pendiente' },
            'en_proceso': { class: 'badge-estado-en_proceso', label: 'En Proceso' },
            'completado': { class: 'badge-estado-completado', label: 'Completado' },
            'cancelado': { class: 'badge-estado-cancelado', label: 'Cancelado' }
        };
        return badges[estado] || badges['pendiente'];
    }

    function toMoney(value) {
        if (value === null || value === undefined) return 0;
        if (typeof value === 'number') return isNaN(value) ? 0 : value;
        const clean = String(value).replace(/[^0-9.\-]/g, '');
        const num = parseFloat(clean);
        return isNaN(num) ? 0 : num;
    }

    function extraerArray(data) {
        if (!data) return [];
        if (Array.isArray(data)) return data;
        if (Array.isArray(data.data)) return data.data;
        if (Array.isArray(data.items)) return data.items;
        if (Array.isArray(data.rows)) return data.rows;
        return [];
    }

    function mostrarNotificacion(mensaje, tipo = 'success') {
        document.querySelectorAll('.toast-notification').forEach(el => el.remove());
        const notificacion = document.createElement('div');
        notificacion.className = `toast-notification ${tipo}`;
        const icono = tipo === 'success' ? 'fa-check-circle' : tipo === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
        notificacion.innerHTML = `<i class="fas ${icono}"></i> ${mensaje}`;
        document.body.appendChild(notificacion);
        setTimeout(() => notificacion.remove(), 3000);
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        if (el) el.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function openModal(id) {
        const el = document.getElementById(id);
        if (el) el.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    // ============================================
    // CARGA DE EQUIPOS
    // ============================================
    async function cargarEquiposParaSelects() {
        try {
            const response = await fetch(`${API_MAQUINARIA}/catalogos`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            const result = await response.json();

            const selectRegistrar = document.getElementById('modalEquipo');
            const selectEditar = document.getElementById('editManttoEquipo');

            const htmlOptions = '<option value="">Seleccionar equipo...</option>';
            if (selectRegistrar) selectRegistrar.innerHTML = htmlOptions + '<option value="">Cargando...</option>';
            if (selectEditar) selectEditar.innerHTML = htmlOptions + '<option value="">Cargando...</option>';

            const equipos = (result?.data?.todos_equipos || result?.data?.equipos || []);

            const options = equipos.map(e =>
                `<option value="${e.id}">${e.label || (e.codigo + ' - ' + e.nombre)}</option>`
            ).join('');

            if (selectRegistrar) selectRegistrar.innerHTML = htmlOptions + options;
            if (selectEditar) selectEditar.innerHTML = htmlOptions + options;
        } catch (error) {
            console.error('Error cargando equipos:', error);
            const selectRegistrar = document.getElementById('modalEquipo');
            const selectEditar = document.getElementById('editManttoEquipo');
            if (selectRegistrar) selectRegistrar.innerHTML = '<option value="">Error al cargar equipos</option>';
            if (selectEditar) selectEditar.innerHTML = '<option value="">Error al cargar equipos</option>';
        }
    }

    // ============================================
    // ESTADÍSTICAS
    // ============================================
    async function cargarEstadisticas() {
        try {
            const proyectoId = document.getElementById('selectorProyecto')?.value || '';
            const params = new URLSearchParams();
            if (proyectoId) params.append('proyecto_id', proyectoId);

            const response = await fetch(`${API_BASE}/estadisticas?${params}`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();

            if (result.success) {
                const d = result.data || {};
                document.getElementById('enMantenimiento').textContent = d.en_mantenimiento ?? 0;
                document.getElementById('programados').textContent = d.programados ?? 0;
                document.getElementById('completados').textContent = d.completados ?? 0;
                document.getElementById('costoMensual').textContent = '$' + toMoney(d.costo_mensual).toFixed(2);
            }
        } catch (error) {
            console.error('Error cargando estadísticas:', error);
            document.getElementById('costoMensual').textContent = '$0.00';
        }
    }

    // ============================================
    // MANTENIMIENTOS ACTIVOS
    // ============================================
    async function cargarMantenimientosActivos() {
        const tbody = document.getElementById('tablaActivos');

        try {
            const proyectoId = document.getElementById('selectorProyecto')?.value || '';
            const tipo = document.getElementById('selectorTipoMantto')?.value || '';
            const estatus = document.getElementById('selectorStatus')?.value || '';
            const busqueda = (document.getElementById('buscador')?.value || '').trim();

            const params = new URLSearchParams();
            if (proyectoId) params.append('proyecto_id', proyectoId);
            if (tipo) params.append('tipo', tipo);
            if (estatus) params.append('estatus', estatus);
            if (busqueda) params.append('busqueda', busqueda);

            const url = `${API_BASE}/activos?${params}`;
            console.log('📡 GET', url);

            const response = await fetch(url, {
                headers: { 'Accept': 'application/json' }
            });

            const result = await response.json();
            console.log('📦 Respuesta:', result);

            if (!response.ok) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="10" style="text-align: center; padding: 30px; color: #dc3545;">
                            <i class="fas fa-exclamation-circle" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
                            Error HTTP ${response.status}: ${result?.message || 'Error desconocido'}
                        </td>
                    </tr>`;
                return;
            }

            const lista = extraerArray(result.data);
            renderizarActivos(lista);
            actualizarContador('activos', lista.length);

        } catch (error) {
            console.error('❌ Error:', error);
            tbody.innerHTML = `
                <tr>
                    <td colspan="10" style="text-align: center; padding: 30px; color: #dc3545;">
                        <i class="fas fa-exclamation-circle" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
                        Error de red: ${error.message}
                    </td>
                </tr>`;
        }
    }

    function renderizarActivos(mantenimientos) {
        const tbody = document.getElementById('tablaActivos');
        if (!tbody) return;

        if (!mantenimientos || mantenimientos.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="10" style="text-align: center; padding: 30px; color: #6c757d;">
                        <i class="fas fa-info-circle" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
                        No hay mantenimientos que coincidan con los filtros
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = mantenimientos.map(item => {
            const prioridadBadge = getPrioridadBadge(item.prioridad || 'media');
            const estadoBadge = getEstadoBadge(item.estatus);
            const avance = item.avance || 0;

            return `
                <tr>
                    <td style="padding: 12px;">
                        <strong>${item.activo?.codigo || '-'}</strong> - ${item.activo?.nombre || '-'}
                    </td>
                    <td style="padding: 12px;">
                        <span class="badge-tipo-${item.tipo_mantenimiento}">${ucfirst(item.tipo_mantenimiento)}</span>
                    </td>
                    <td style="padding: 12px;">${item.activo?.proyecto_asignado?.nombre || '-'}</td>
                    <td style="padding: 12px;">${formatDate(item.fecha_inicio)}</td>
                    <td style="padding: 12px;">${item.fecha_fin_estimada ? formatDate(item.fecha_fin_estimada) : '-'}</td>
                    <td style="padding: 12px;">${item.responsable_asignado || '-'}</td>
                    <td style="padding: 12px;"><span class="${estadoBadge.class}">${estadoBadge.label}</span></td>
                    <td style="padding: 12px;"><span class="${prioridadBadge.class}">${prioridadBadge.label}</span></td>
                    <td style="padding: 12px;">
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                <div style="width: ${avance}%; height: 6px; background-color: ${avance === 100 ? '#28a745' : '#ffc107'}; border-radius: 3px;"></div>
                            </div>
                            ${avance}%
                        </div>
                    </td>
                    <td style="padding: 12px; white-space: nowrap; text-align: center;">
                        <div style="display: inline-flex; gap: 8px; align-items: center;">
                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 15px;" title="Ver detalle" onclick="abrirDetalleMantenimiento(${item.id})"></i>
                            <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; font-size: 15px;" title="Editar" onclick="editarMantenimiento(${item.id})"></i>
                            ${item.estatus === 'pendiente' ?
                                `<i class="fas fa-play" style="color: #0d6efd; cursor: pointer; font-size: 15px;" title="Iniciar" onclick="iniciarMantenimiento(${item.id})"></i>` : ''
                            }
                            ${item.estatus === 'en_proceso' ?
                                `<i class="fas fa-flag-checkered" style="color: #28a745; cursor: pointer; font-size: 15px;" title="Cerrar mantenimiento" onclick="abrirCerrarMantenimiento(${item.id}, ${item.costo || 0})"></i>` : ''
                            }
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // ============================================
    // PROGRAMADOS
    // ============================================
    async function cargarMantenimientosProgramados() {
        try {
            const proyectoId = document.getElementById('selectorProyecto')?.value || '';

            // Tabla: TODOS los pendientes (usando /list)
            const paramsList = new URLSearchParams({ estatus: 'pendiente' });
            if (proyectoId) paramsList.append('proyecto_id', proyectoId);

            // Próximos 7 días + Por tipo: desde /programados
            const paramsProg = new URLSearchParams();
            if (proyectoId) paramsProg.append('proyecto_id', proyectoId);

            const [resList, resProg] = await Promise.all([
                fetch(`${API_BASE}/list?${paramsList}`, { headers: { 'Accept': 'application/json' } }),
                fetch(`${API_BASE}/programados?${paramsProg}`, { headers: { 'Accept': 'application/json' } })
            ]);

            const jsonList = await resList.json();
            const jsonProg = await resProg.json();

            console.log('📦 List:', jsonList);
            console.log('📦 Programados:', jsonProg);

            const todosPendientes = extraerArray(jsonList?.data);
            const progData = jsonProg?.data || {};
            const proximos7 = extraerArray(progData.proximos_7_dias);
            const porTipo = extraerArray(progData.por_tipo);

            renderizarProgramados({
                programados: todosPendientes,
                proximos_7_dias: proximos7,
                por_tipo: porTipo
            });

            actualizarContador('programados', todosPendientes.length);

        } catch (error) {
            console.error('Error cargando programados:', error);
            renderizarProgramados({ programados: [], proximos_7_dias: [], por_tipo: [] });
        }
    }

    function renderizarProgramados(data) {
        // Próximos 7 días
        const listaProximos = document.getElementById('listaProximos7Dias');
        if (listaProximos) {
            if (!data.proximos_7_dias || data.proximos_7_dias.length === 0) {
                listaProximos.innerHTML = `
                    <div style="padding: 15px; text-align: center; color: #6c757d;">
                        No hay mantenimientos programados en los próximos 7 días
                    </div>`;
            } else {
                listaProximos.innerHTML = data.proximos_7_dias.map(item => `
                    <div style="display: flex; align-items: center; padding: 8px; background-color: #f8f9fa; border-radius: 4px; margin-bottom: 8px;">
                        <div style="width: 90px; font-weight: bold; font-size: 12px;">${formatDate(item.fecha_inicio)}</div>
                        <div style="flex: 1; margin-left: 10px; font-size: 13px;">
                            ${item.activo?.codigo || '-'} - ${item.activo?.nombre || '-'} (${ucfirst(item.tipo_mantenimiento)})
                        </div>
                        <span class="badge-estado-pendiente">Programado</span>
                    </div>
                `).join('');
            }
        }

        // Por tipo
        const listaPorTipo = document.getElementById('listaPorTipo');
        if (listaPorTipo) {
            const total = (data.por_tipo || []).reduce((sum, t) => sum + Number(t.total || 0), 0);
            if (total === 0) {
                listaPorTipo.innerHTML = `<div style="padding: 15px; text-align: center; color: #6c757d;">No hay datos</div>`;
            } else {
                listaPorTipo.innerHTML = data.por_tipo.map(t => {
                    const porcentaje = Math.round((Number(t.total) / total) * 100);
                    const color = getTipoColor(t.tipo_mantenimiento);
                    return `
                        <div style="margin-bottom: 15px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <span style="font-size: 13px;">${ucfirst(t.tipo_mantenimiento)}</span>
                                <span style="font-size: 13px; font-weight: 600;">${t.total} (${porcentaje}%)</span>
                            </div>
                            <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                <div style="width: ${porcentaje}%; height: 8px; background-color: ${color}; border-radius: 4px;"></div>
                            </div>
                        </div>
                    `;
                }).join('');
            }
        }

        // Tabla
        const tbody = document.getElementById('tablaProgramados');
        if (tbody) {
            if (!data.programados || data.programados.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px; color: #6c757d;">
                            <i class="fas fa-calendar-times" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
                            No hay mantenimientos programados.
                            <div style="margin-top: 8px; font-size: 12px; color: #999;">
                                Usa el botón <strong>Programar</strong> para agendar uno.
                            </div>
                        </td>
                    </tr>`;
            } else {
                tbody.innerHTML = data.programados.map(item => {
                    const prioridadBadge = getPrioridadBadge(item.prioridad || 'media');
                    return `
                        <tr>
                            <td style="padding: 12px;">${item.activo?.codigo || '-'} - ${item.activo?.nombre || '-'}</td>
                            <td style="padding: 12px;"><span class="badge-tipo-${item.tipo_mantenimiento}">${ucfirst(item.tipo_mantenimiento)}</span></td>
                            <td style="padding: 12px;">${item.activo?.proyecto_asignado?.nombre || '-'}</td>
                            <td style="padding: 12px;">${formatDate(item.fecha_inicio)}</td>
                            <td style="padding: 12px;">${item.responsable_asignado || '-'}</td>
                            <td style="padding: 12px;"><span class="${prioridadBadge.class}">${prioridadBadge.label}</span></td>
                            <td style="padding: 12px; white-space: nowrap; text-align: center;">
                                <div style="display: inline-flex; gap: 8px; align-items: center;">
                                    <i class="fas fa-play" style="color: #28a745; cursor: pointer; font-size: 15px;" title="Iniciar" onclick="iniciarMantenimiento(${item.id})"></i>
                                    <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; font-size: 15px;" title="Editar" onclick="editarMantenimiento(${item.id})"></i>
                                </div>
                            </td>
                        </tr>
                    `;
                }).join('');
            }
        }
    }

    // ============================================
    // HISTORIAL
    // ============================================
    async function cargarHistorial() {
        try {
            const periodo = document.getElementById('filtroPeriodo')?.value || '30';
            const tipo = document.getElementById('filtroTipoHistorial')?.value || '';

            const params = new URLSearchParams({ periodo, tipo });
            const response = await fetch(`${API_BASE}/historial?${params}`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();

            if (result.success) renderizarHistorial(result.data);
        } catch (error) {
            console.error('Error cargando historial:', error);
        }
    }

    function renderizarHistorial(historial) {
        const tbody = document.getElementById('tablaHistorial');
        if (!tbody) return;

        const items = extraerArray(historial);

        if (items.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" style="text-align: center; padding: 30px; color: #6c757d;">
                        <i class="fas fa-history" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
                        No hay historial de mantenimientos
                    </td>
                </tr>`;
            return;
        }

        tbody.innerHTML = items.map(item => `
            <tr>
                <td style="padding: 12px;">${formatDate(item.fecha_fin || item.fecha_inicio)}</td>
                <td style="padding: 12px;">${item.activo?.codigo || '-'} - ${item.activo?.nombre || '-'}</td>
                <td style="padding: 12px;"><span class="badge-tipo-${item.tipo_mantenimiento}">${ucfirst(item.tipo_mantenimiento)}</span></td>
                <td style="padding: 12px;">${item.descripcion || '-'}</td>
                <td style="padding: 12px;">${item.responsable_asignado || '-'}</td>
                <td style="padding: 12px; text-align: right;">$${toMoney(item.costo).toFixed(2)}</td>
                <td style="padding: 12px;">${calcularDuracion(item.fecha_inicio, item.fecha_fin)}</td>
                <td style="padding: 12px; white-space: nowrap; text-align: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 15px;" title="Ver detalle" onclick="abrirDetalleMantenimiento(${item.id})"></i>
                </td>
            </tr>
        `).join('');
    }

    // ============================================
    // COSTOS
    // ============================================
    async function cargarCostos() {
        try {
            const response = await fetch(`${API_BASE}/costos`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            console.log('📦 Costos:', result);

            if (result.success) renderizarCostos(result.data || {});
        } catch (error) {
            console.error('Error cargando costos:', error);
        }
    }

    function renderizarCostos(data) {
        const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        // Gráfico de barras
        const contenedorBarras = document.getElementById('contenedorGraficoBarras');
        if (contenedorBarras) {
            const cm = extraerArray(data.costos_mensuales);
            if (cm.length === 0) {
                contenedorBarras.innerHTML = `<div style="padding: 15px; text-align: center; color: #6c757d;">No hay datos de costos</div>`;
            } else {
                const maxValor = Math.max(...cm.map(m => toMoney(m.total)), 1);
                contenedorBarras.innerHTML = cm.map(m => {
                    const mesIndex = parseInt(m.mes) - 1;
                    const altura = maxValor > 0 ? Math.round((toMoney(m.total) / maxValor) * 150) : 0;
                    return `
                        <div style="text-align: center;">
                            <div style="height: ${altura}px; width: 40px; background-color: #083CAE; border-radius: 4px 4px 0 0;"></div>
                            <div style="margin-top: 5px; font-size: 11px;">${meses[mesIndex] || ''}</div>
                            <div style="font-size: 10px;">$${Math.round(toMoney(m.total) / 1000)}K</div>
                        </div>`;
                }).join('');
            }
        }

        // Distribución
        const contenedorDistribucion = document.getElementById('contenedorDistribucion');
        if (contenedorDistribucion) {
            const dist = extraerArray(data.distribucion);
            const total = dist.reduce((sum, d) => sum + toMoney(d.total), 0);
            if (total === 0) {
                contenedorDistribucion.innerHTML = `<div style="padding: 15px; text-align: center; color: #6c757d;">No hay datos</div>`;
            } else {
                contenedorDistribucion.innerHTML = dist.map(d => {
                    const porcentaje = Math.round((toMoney(d.total) / total) * 100);
                    const color = getTipoColor(d.tipo_mantenimiento);
                    return `
                        <div style="margin-bottom: 15px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <span style="font-size: 13px;">${ucfirst(d.tipo_mantenimiento)}</span>
                                <span style="font-size: 13px; font-weight: 600;">$${Math.round(toMoney(d.total) / 1000)}K (${porcentaje}%)</span>
                            </div>
                            <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                <div style="width: ${porcentaje}%; height: 8px; background-color: ${color}; border-radius: 4px;"></div>
                            </div>
                        </div>`;
                }).join('');
            }
        }

        // Tabla de costos por equipo
        const tbody = document.getElementById('tablaCostos');
        if (tbody) {
            const cpe = extraerArray(data.costos_por_equipo);
            if (cpe.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 30px; color: #6c757d;">No hay datos de costos por equipo</td></tr>`;
            } else {
                tbody.innerHTML = cpe.map(item => {
                    const tendencia = Math.random() > 0.5 ? '↓' : '↑';
                    const color = tendencia === '↓' ? '#28a745' : '#dc3545';
                    const variacion = (Math.random() * 15).toFixed(0);
                    return `
                        <tr>
                            <td style="padding: 12px;">${item.activo?.codigo || '-'} - ${item.activo?.nombre || '-'}</td>
                            <td style="padding: 12px;">${item.total_manttos || 0}</td>
                            <td style="padding: 12px; text-align: right;">$${toMoney(item.costo_total).toFixed(2)}</td>
                            <td style="padding: 12px; text-align: right;">$${toMoney(item.promedio).toFixed(2)}</td>
                            <td style="padding: 12px; text-align: right;">${formatDate(item.ultimo_mantto || null)}</td>
                            <td style="padding: 12px; text-align: center; color: ${color}; font-weight: 600;">
                                ${tendencia} ${variacion}%
                            </td>
                        </tr>`;
                }).join('');
            }
        }
    }

    // ============================================
    // ALERTAS
    // ============================================
    async function cargarAlertas() {
        try {
            const response = await fetch(`${API_BASE}/alertas`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            if (result.success) {
                renderizarAlertas(result.data || { criticas: [], preventivas: [], informacion: [] });
                actualizarContador('alertas', extraerArray(result.data?.criticas).length);
            }
        } catch (error) {
            console.error('Error cargando alertas:', error);
        }
    }

    function renderizarAlertas(data) {
        const criticas = document.getElementById('alertasCriticas');
        if (criticas) {
            const lista = extraerArray(data.criticas);
            if (lista.length === 0) {
                criticas.innerHTML = `<div style="padding: 15px; background-color: #d4edda; border-left: 4px solid #28a745; border-radius: 4px;"><p style="margin: 0; color: #155724;">✅ No hay alertas críticas</p></div>`;
            } else {
                criticas.innerHTML = lista.map(item => `
                    <div style="background-color: #f8d7da; border-left: 4px solid #dc3545; border-radius: 4px; padding: 15px; margin-bottom: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-exclamation-circle" style="color: #dc3545; font-size: 24px;"></i>
                            <div style="flex: 1;">
                                <h4 style="margin: 0; font-size: 14px; color: #721c24;">Mantenimiento Vencido - ${item.activo?.codigo || ''}</h4>
                                <p style="margin: 5px 0 0; font-size: 13px;">${item.descripcion || 'Mantenimiento programado no realizado'}</p>
                            </div>
                        </div>
                    </div>`).join('');
            }
        }

        const preventivas = document.getElementById('alertasPreventivas');
        if (preventivas) {
            const lista = extraerArray(data.preventivas);
            if (lista.length === 0) {
                preventivas.innerHTML = `<div style="padding: 15px; background-color: #d4edda; border-left: 4px solid #28a745; border-radius: 4px;"><p style="margin: 0; color: #155724;">✅ No hay alertas preventivas</p></div>`;
            } else {
                preventivas.innerHTML = lista.map(item => `
                    <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px; padding: 15px; margin-bottom: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-exclamation-triangle" style="color: #856404; font-size: 24px;"></i>
                            <div style="flex: 1;">
                                <h4 style="margin: 0; font-size: 14px; color: #856404;">${item.activo?.codigo || ''} - ${item.activo?.nombre || ''}</h4>
                                <p style="margin: 5px 0 0; font-size: 13px;">${ucfirst(item.tipo_mantenimiento)} - ${item.descripcion || 'Mantenimiento programado'}</p>
                            </div>
                        </div>
                    </div>`).join('');
            }
        }

        const info = document.getElementById('alertasInformacion');
        if (info) {
            const lista = extraerArray(data.informacion);
            if (lista.length === 0) {
                info.innerHTML = `<div style="padding: 15px; background-color: #d4edda; border-left: 4px solid #28a745; border-radius: 4px;"><p style="margin: 0; color: #155724;">✅ No hay información de alertas</p></div>`;
            } else {
                info.innerHTML = lista.map(item => {
                    const actual = Number(item.maquinaria?.horometro_actual || 0);
                    const limite = Number(item.maquinaria?.horometro_proximo_mantenimiento || 500);
                    const restantes = Math.max(0, limite - actual);
                    return `
                        <div style="background-color: #cce5ff; border-left: 4px solid #0d6efd; border-radius: 4px; padding: 15px; margin-bottom: 10px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-info-circle" style="color: #0d6efd; font-size: 24px;"></i>
                                <div style="flex: 1;">
                                    <h4 style="margin: 0; font-size: 14px; color: #0d6efd;">${item.codigo || ''} - ${item.nombre || ''}</h4>
                                    <p style="margin: 5px 0 0; font-size: 13px;">Horas actuales: ${actual} / Límite: ${limite}</p>
                                </div>
                                <span style="color: #0d6efd; font-weight: bold;">${restantes} hrs restantes</span>
                            </div>
                        </div>`;
                }).join('');
            }
        }
    }

    // ============================================
    // PROYECTOS
    // ============================================
    async function cargarProyectos() {
        try {
            const response = await fetch(`${API_MAQUINARIA}/catalogos`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();

            if (result.success && result.data.proyectos) {
                const select = document.getElementById('selectorProyecto');
                select.innerHTML = '<option value="">Todos los proyectos</option>';
                result.data.proyectos.forEach(p => {
                    const option = document.createElement('option');
                    option.value = p.id;
                    option.textContent = p.nombre;
                    select.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Error cargando proyectos:', error);
        }
    }

    function actualizarContador(tab, count) {
        const tabButton = document.querySelector(`.mantenimiento-tab[data-tab="${tab}"]`);
        if (tabButton) {
            const span = tabButton.querySelector('span');
            if (span) span.textContent = count;
        }
    }

    // ============================================
    // ACCIONES GLOBALES
    // ============================================

    window.abrirDetalleMantenimiento = async function(id) {
        const contenido = document.getElementById('contenidoDetalle');
        openModal('modalVerDetalle');
        contenido.innerHTML = `
            <div style="text-align: center; padding: 40px; color: #6c757d;">
                <i class="fas fa-spinner fa-spin" style="font-size: 36px;"></i>
                <p style="margin-top: 10px;">Cargando detalle...</p>
            </div>`;

        try {
            const response = await fetch(`${API_BASE}/${id}`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();

            if (result.success) {
                const item = result.data;
                const prioridadBadge = getPrioridadBadge(item.prioridad || 'media');
                const estadoBadge = getEstadoBadge(item.estatus);

                contenido.innerHTML = `
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                        <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; border: 1px solid #dee2e6;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;"><i class="fas fa-tractor"></i> Equipo</h4>
                            <table style="width: 100%; font-size: 13px;">
                                <tr><td style="padding: 5px 0; color: #6c757d;">Código:</td><td style="font-weight: 600;">${item.activo?.codigo || '-'}</td></tr>
                                <tr><td style="padding: 5px 0; color: #6c757d;">Nombre:</td><td>${item.activo?.nombre || '-'}</td></tr>
                                <tr><td style="padding: 5px 0; color: #6c757d;">Proyecto:</td><td>${item.activo?.proyecto_asignado?.nombre || '-'}</td></tr>
                                <tr><td style="padding: 5px 0; color: #6c757d;">Horómetro:</td><td>${item.activo?.maquinaria?.horometro_actual || '0 hrs'}</td></tr>
                            </table>
                        </div>
                        <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; border: 1px solid #dee2e6;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;"><i class="fas fa-info-circle"></i> Resumen</h4>
                            <table style="width: 100%; font-size: 13px;">
                                <tr><td style="padding: 5px 0; color: #6c757d;">Tipo:</td><td><span class="badge-tipo-${item.tipo_mantenimiento}">${ucfirst(item.tipo_mantenimiento)}</span></td></tr>
                                <tr><td style="padding: 5px 0; color: #6c757d;">Prioridad:</td><td><span class="${prioridadBadge.class}">${prioridadBadge.label}</span></td></tr>
                                <tr><td style="padding: 5px 0; color: #6c757d;">Estado:</td><td><span class="${estadoBadge.class}">${estadoBadge.label}</span></td></tr>
                                <tr><td style="padding: 5px 0; color: #6c757d;">Costo:</td><td style="font-weight: 600;">$${toMoney(item.costo).toFixed(2)}</td></tr>
                            </table>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 25px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">Inicio</div>
                            <div style="font-size: 15px; font-weight: 600; color: #083CAE;">${formatDate(item.fecha_inicio)}</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">Fin estimado</div>
                            <div style="font-size: 15px; font-weight: 600; color: #083CAE;">${item.fecha_fin_estimada ? formatDate(item.fecha_fin_estimada) : '-'}</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">Responsable</div>
                            <div style="font-size: 15px; font-weight: 600; color: #083CAE;">${item.responsable_asignado || '-'}</div>
                        </div>
                    </div>

                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 15px; margin-bottom: 25px;">
                        <h4 style="color: #083CAE; margin: 0 0 10px 0; font-size: 14px;"><i class="fas fa-align-left"></i> Descripción</h4>
                        <p style="margin: 0; font-size: 13px; line-height: 1.6; color: #495057;">${item.descripcion || 'Sin descripción'}</p>
                    </div>

                    ${item.observaciones ? `
                        <div style="background-color: #f8f9fa; border-radius: 6px; padding: 15px; margin-bottom: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 10px 0; font-size: 14px;"><i class="fas fa-clipboard"></i> Observaciones</h4>
                            <p style="margin: 0; font-size: 13px; color: #495057;">${item.observaciones}</p>
                        </div>` : ''}

                    <div style="display: flex; justify-content: flex-end; gap: 10px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                        ${item.estatus === 'en_proceso' ? `
                            <button onclick="abrirCerrarMantenimiento(${item.id}, ${item.costo || 0}); window.cerrarModalDetalle();" style="padding: 10px 20px; background-color: white; border: 1px solid #28a745; color: #28a745; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-flag-checkered"></i> Cerrar mantenimiento
                            </button>` : ''}
                        ${item.estatus === 'pendiente' ? `
                            <button onclick="iniciarMantenimiento(${item.id})" style="padding: 10px 20px; background-color: white; border: 1px solid #0d6efd; color: #0d6efd; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-play"></i> Iniciar
                            </button>` : ''}
                        <button onclick="window.cerrarModalDetalle()" style="padding: 10px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cerrar</button>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error cargando detalle:', error);
            contenido.innerHTML = `
                <div style="text-align: center; padding: 40px; color: #dc3545;">
                    <i class="fas fa-exclamation-circle" style="font-size: 36px;"></i>
                    <p style="margin-top: 10px;">Error al cargar el detalle</p>
                </div>`;
        }
    };

    window.cerrarModalDetalle = function() { closeModal('modalVerDetalle'); };

    window.iniciarMantenimiento = async function(id) {
        if (!confirm('¿Está seguro de iniciar este mantenimiento?')) return;
        try {
            const response = await fetch(`${API_BASE}/${id}/iniciar`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
            });
            const result = await response.json();
            if (result.success) {
                mostrarNotificacion('Mantenimiento iniciado correctamente', 'success');
                cargarMantenimientosActivos();
                cargarMantenimientosProgramados();
                cargarEstadisticas();
                window.cerrarModalDetalle();
            } else {
                mostrarNotificacion(result.message || 'Error al iniciar', 'error');
            }
        } catch (error) {
            console.error(error);
            mostrarNotificacion('Error al iniciar mantenimiento', 'error');
        }
    };

    window.abrirCerrarMantenimiento = function(id, costoActual) {
        document.getElementById('cerrarManttoId').value = id;
        document.getElementById('cerrarFechaFin').value = new Date().toISOString().split('T')[0];
        document.getElementById('cerrarCosto').value = toMoney(costoActual).toFixed(2);
        document.getElementById('cerrarObservaciones').value = '';
        openModal('modalCerrarMantto');
    };

    window.editarMantenimiento = async function(id) {
        try {
            const response = await fetch(`${API_BASE}/${id}`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();

            if (!result.success) {
                mostrarNotificacion('No se pudo cargar el registro', 'error');
                return;
            }

            const d = result.data;
            document.getElementById('editManttoId').value = d.id;
            document.getElementById('editManttoEquipo').value = d.activo_id || '';
            document.getElementById('editManttoTipo').value = d.tipo_mantenimiento || 'preventivo';
            document.getElementById('editManttoPrioridad').value = d.prioridad || 'media';
            document.getElementById('editManttoFechaInicio').value = (d.fecha_inicio || '').substring(0, 10);
            document.getElementById('editManttoFechaFin').value = (d.fecha_fin_estimada || '').substring(0, 10);
            document.getElementById('editManttoResponsable').value = d.responsable_asignado || '';
            document.getElementById('editManttoDescripcion').value = d.descripcion || '';
            document.getElementById('editManttoCosto').value = toMoney(d.costo).toFixed(2);

            openModal('modalEditarMantto');
        } catch (error) {
            console.error('Error al abrir editar:', error);
            mostrarNotificacion('Error al cargar mantenimiento', 'error');
        }
    };

    // ============================================
    // EVENTOS — PESTAÑAS
    // ============================================
    document.querySelectorAll('.mantenimiento-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.mantenimiento-tab').forEach(t => {
                t.classList.remove('active');
                t.style.backgroundColor = '#e9ecef';
                t.style.color = '#495057';
            });
            this.classList.add('active');
            this.style.backgroundColor = '#083CAE';
            this.style.color = 'white';

            currentTab = this.dataset.tab;

            document.querySelectorAll('.mantenimiento-content').forEach(c => c.style.display = 'none');
            const target = document.getElementById(`tab-${currentTab}`);
            if (target) target.style.display = 'block';

            switch (currentTab) {
                case 'activos': cargarMantenimientosActivos(); break;
                case 'programados': cargarMantenimientosProgramados(); break;
                case 'historial': cargarHistorial(); break;
                case 'costos': cargarCostos(); break;
                case 'alertas': cargarAlertas(); break;
            }
        });
    });

    // ============================================
    // EVENTOS — FILTROS
    // ============================================
    document.getElementById('selectorProyecto')?.addEventListener('change', function() {
        cargarEstadisticas();
        if (currentTab === 'activos') cargarMantenimientosActivos();
        if (currentTab === 'programados') cargarMantenimientosProgramados();
        if (currentTab === 'costos') cargarCostos();
        if (currentTab === 'historial') cargarHistorial();
    });

    document.getElementById('selectorTipoMantto')?.addEventListener('change', cargarMantenimientosActivos);
    document.getElementById('selectorStatus')?.addEventListener('change', cargarMantenimientosActivos);
    document.getElementById('filtroPeriodo')?.addEventListener('change', cargarHistorial);
    document.getElementById('filtroTipoHistorial')?.addEventListener('change', cargarHistorial);

    document.getElementById('buscador')?.addEventListener('input', function() {
        clearTimeout(buscarTimeout);
        buscarTimeout = setTimeout(cargarMantenimientosActivos, 400);
    });

    // ============================================
    // EVENTOS — BOTONES PRINCIPALES
    // ============================================
    document.getElementById('btnRegistrarMantto')?.addEventListener('click', function(e) {
        e.preventDefault();
        modoModal = 'registrar';
        prepararModalMantenimiento();
    });

    document.getElementById('btnProgramar')?.addEventListener('click', function(e) {
        e.preventDefault();
        modoModal = 'programar';
        prepararModalMantenimiento();
    });

    function prepararModalMantenimiento() {
        const titulo = document.getElementById('tituloModalMantto');
        const btnGuardar = document.getElementById('btnGuardarMantto');

        if (modoModal === 'programar') {
            titulo.innerHTML = '<i class="fas fa-calendar-plus"></i> Programar Mantenimiento';
            btnGuardar.innerHTML = '<i class="fas fa-calendar-check"></i> Programar';
        } else {
            titulo.innerHTML = '<i class="fas fa-tools"></i> Registrar Mantenimiento';
            btnGuardar.innerHTML = '<i class="fas fa-save"></i> Registrar';
        }

        const hoy = new Date().toISOString().split('T')[0];
        document.getElementById('formMantenimiento').reset();
        document.getElementById('modalFechaInicio').value = hoy;

        if (modoModal === 'programar') {
            const prox = new Date();
            prox.setDate(prox.getDate() + 7);
            document.getElementById('modalFechaInicio').value = prox.toISOString().split('T')[0];
        }

        openModal('modalRegistrarMantto');
        cargarEquiposParaSelects();
    }

    document.getElementById('btnExcel')?.addEventListener('click', function() {
        window.open(`${API_BASE}/exportar/excel`, '_blank');
    });

    // ============================================
    // EVENTOS — MODAL REGISTRAR/PROGRAMAR
    // ============================================
    document.getElementById('btnCerrarModalMantto')?.addEventListener('click', () => closeModal('modalRegistrarMantto'));
    document.getElementById('btnCancelarMantto')?.addEventListener('click', () => closeModal('modalRegistrarMantto'));

    document.getElementById('btnGuardarMantto')?.addEventListener('click', async function() {
        const form = document.getElementById('formMantenimiento');
        const data = Object.fromEntries(new FormData(form).entries());
        data.modo = modoModal;

        if (!data.activo_id || !data.fecha_inicio || !data.descripcion) {
            mostrarNotificacion('Por favor complete los campos requeridos', 'warning');
            return;
        }

        const btn = this;
        const original = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        btn.disabled = true;

        try {
            const response = await fetch(`${API_BASE}/registrar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });
            const result = await response.json();

            btn.innerHTML = original;
            btn.disabled = false;

            if (result.success) {
                mostrarNotificacion(modoModal === 'programar' ? 'Mantenimiento programado' : 'Mantenimiento registrado', 'success');
                closeModal('modalRegistrarMantto');
                cargarEstadisticas();
                cargarMantenimientosActivos();
                cargarMantenimientosProgramados();
            } else {
                mostrarNotificacion(result.message || 'Error al guardar', 'error');
            }
        } catch (error) {
            btn.innerHTML = original;
            btn.disabled = false;
            console.error(error);
            mostrarNotificacion('Error al guardar mantenimiento', 'error');
        }
    });

    // ============================================
    // EVENTOS — MODAL EDITAR
    // ============================================
    document.getElementById('btnCerrarModalEditar')?.addEventListener('click', () => closeModal('modalEditarMantto'));
    document.getElementById('btnCancelarEditar')?.addEventListener('click', () => closeModal('modalEditarMantto'));

    document.getElementById('btnGuardarEditar')?.addEventListener('click', async function() {
        const id = document.getElementById('editManttoId').value;
        const data = {
            activo_id: document.getElementById('editManttoEquipo').value,
            tipo_mantenimiento: document.getElementById('editManttoTipo').value,
            prioridad: document.getElementById('editManttoPrioridad').value,
            fecha_inicio: document.getElementById('editManttoFechaInicio').value,
            fecha_fin_estimada: document.getElementById('editManttoFechaFin').value,
            responsable_asignado: document.getElementById('editManttoResponsable').value,
            descripcion: document.getElementById('editManttoDescripcion').value,
            costo: parseFloat(document.getElementById('editManttoCosto').value) || 0,
        };

        const btn = this;
        const original = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        btn.disabled = true;

        try {
            const response = await fetch(`${API_BASE}/${id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });
            const result = await response.json();

            btn.innerHTML = original;
            btn.disabled = false;

            if (result.success) {
                mostrarNotificacion('Mantenimiento actualizado', 'success');
                closeModal('modalEditarMantto');
                cargarMantenimientosActivos();
                cargarMantenimientosProgramados();
                cargarEstadisticas();
            } else {
                mostrarNotificacion(result.message || 'Error al actualizar', 'error');
            }
        } catch (error) {
            btn.innerHTML = original;
            btn.disabled = false;
            console.error(error);
            mostrarNotificacion('Error al actualizar mantenimiento', 'error');
        }
    });

    // ============================================
    // EVENTOS — MODAL CERRAR MANTENIMIENTO
    // ============================================
    document.getElementById('btnCerrarModalCerrar')?.addEventListener('click', () => closeModal('modalCerrarMantto'));
    document.getElementById('btnCancelarCerrar')?.addEventListener('click', () => closeModal('modalCerrarMantto'));

    document.getElementById('btnConfirmarCierre')?.addEventListener('click', async function() {
        const id = document.getElementById('cerrarManttoId').value;
        const body = {
            fecha_fin: document.getElementById('cerrarFechaFin').value,
            costo_real: parseFloat(document.getElementById('cerrarCosto').value) || 0,
            observaciones: document.getElementById('cerrarObservaciones').value,
        };

        if (!body.fecha_fin) {
            mostrarNotificacion('La fecha de fin es requerida', 'warning');
            return;
        }

        const btn = this;
        const original = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cerrando...';
        btn.disabled = true;

        try {
            const response = await fetch(`${API_BASE}/${id}/cerrar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(body)
            });
            const result = await response.json();

            btn.innerHTML = original;
            btn.disabled = false;

            if (result.success) {
                mostrarNotificacion('Mantenimiento cerrado correctamente', 'success');
                closeModal('modalCerrarMantto');
                cargarMantenimientosActivos();
                cargarEstadisticas();
                cargarHistorial();
                if (currentTab === 'costos') cargarCostos();
            } else {
                mostrarNotificacion(result.message || 'Error al cerrar mantenimiento', 'error');
            }
        } catch (error) {
            btn.innerHTML = original;
            btn.disabled = false;
            console.error(error);
            mostrarNotificacion('Error al cerrar mantenimiento', 'error');
        }
    });

    // ============================================
    // EVENTOS — CLIC FUERA DE MODALES
    // ============================================
    window.addEventListener('click', function(event) {
        const modales = ['modalRegistrarMantto', 'modalVerDetalle', 'modalEditarMantto', 'modalCerrarMantto'];
        modales.forEach(id => {
            const el = document.getElementById(id);
            if (event.target === el) closeModal(id);
        });
    });

    // ============================================
    // INICIALIZACIÓN
    // ============================================
    cargarProyectos();
    cargarEstadisticas();
    cargarMantenimientosActivos();
    cargarMantenimientosProgramados();
    cargarEquiposParaSelects();
});
</script>
@endsection