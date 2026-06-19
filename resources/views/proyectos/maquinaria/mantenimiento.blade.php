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
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="costoMensual">$0</div>
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
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
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
                            <tbody id="tablaActivos">
                                <!-- Las filas se insertarán dinámicamente -->
                            </tbody>
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
                                <div style="padding: 15px; text-align: center; color: #6c757d;">
                                    Cargando...
                                </div>
                            </div>
                        </div>

                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;" id="graficoPorTipo">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-pie"></i> Por Tipo
                            </h4>
                            <div id="listaPorTipo">
                                <div style="padding: 15px; text-align: center; color: #6c757d;">
                                    Cargando...
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
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
                            <tbody id="tablaProgramados">
                                <!-- Las filas se insertarán dinámicamente -->
                            </tbody>
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

                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
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
                            <tbody id="tablaHistorial">
                                <!-- Las filas se insertarán dinámicamente -->
                            </tbody>
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
                                <div style="padding: 15px; text-align: center; color: #6c757d;">
                                    Cargando datos...
                                </div>
                            </div>
                        </div>

                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;" id="graficoDistribucion">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-pie"></i> Distribución
                            </h4>
                            <div id="contenedorDistribucion">
                                <div style="padding: 15px; text-align: center; color: #6c757d;">
                                    Cargando datos...
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
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
                            <tbody id="tablaCostos">
                                <!-- Las filas se insertarán dinámicamente -->
                            </tbody>
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
                            <div style="padding: 15px; text-align: center; color: #6c757d;">
                                Cargando...
                            </div>
                        </div>

                        <h4 style="color: #ffc107; margin: 20px 0 10px 0; font-size: 16px;">
                            <i class="fas fa-exclamation-triangle"></i> Preventivas
                        </h4>
                        <div id="alertasPreventivas">
                            <div style="padding: 15px; text-align: center; color: #6c757d;">
                                Cargando...
                            </div>
                        </div>

                        <h4 style="color: #0d6efd; margin: 20px 0 10px 0; font-size: 16px;">
                            <i class="fas fa-info-circle"></i> Información
                        </h4>
                        <div id="alertasInformacion">
                            <div style="padding: 15px; text-align: center; color: #6c757d;">
                                Cargando...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Registrar Mantenimiento -->
<div id="modalRegistrarMantto" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-tools"></i> Registrar Mantenimiento</h3>
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
                <i class="fas fa-save"></i> Registrar
            </button>
        </div>
    </div>
</div>

<!-- Modal para Ver Detalles -->
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
    .table td { white-space: nowrap; font-size: 12px; padding: 10px 4px; color: #000000 !important; }
    
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
        #paginacionContainer { flex-direction: column; align-items: flex-start; }
        #modalRegistrarMantto > div, #modalVerDetalle > div { width: 95%; margin: 10px; }
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
    let currentTab = 'activos';

    // ============================================
    // FUNCIONES AUXILIARES
    // ============================================
    
    function ucfirst(str) {
        if (!str) return '';
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function formatDate(dateString) {
        if (!dateString) return '-';
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            });
        } catch {
            return '-';
        }
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
        } catch {
            return '-';
        }
    }

    function getTipoColor(tipo) {
        const colores = {
            'preventivo': '#0d6efd',
            'correctivo': '#dc3545',
            'predictivo': '#28a745'
        };
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

    function mostrarNotificacion(mensaje, tipo = 'success') {
        document.querySelectorAll('.toast-notification').forEach(el => el.remove());
        
        const notificacion = document.createElement('div');
        notificacion.className = `toast-notification ${tipo}`;
        const icono = tipo === 'success' ? 'fa-check-circle' : tipo === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
        notificacion.innerHTML = `<i class="fas ${icono}"></i> ${mensaje}`;
        document.body.appendChild(notificacion);
        setTimeout(() => notificacion.remove(), 3000);
    }

    // ============================================
    // FUNCIONES PARA CARGAR EQUIPOS EN EL MODAL
    // ============================================

    async function cargarEquiposParaModal() {
        try {
            console.log('Cargando equipos para modal...');
            const select = document.getElementById('modalEquipo');
            if (!select) {
                console.error('Select modalEquipo no encontrado');
                return;
            }
            
            // Mostrar loading
            select.innerHTML = '<option value="">Cargando equipos...</option>';
            
            const response = await fetch(`${API_MAQUINARIA}/catalogos`, {
                headers: { 
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const result = await response.json();
            console.log('Respuesta de equipos:', result);
            
            // Limpiar select
            select.innerHTML = '<option value="">Seleccionar equipo...</option>';
            
            if (result.success && result.data) {
                // Usar 'todos_equipos' primero, si no existe usar 'equipos'
                const equipos = result.data.todos_equipos || result.data.equipos || [];
                
                console.log('Equipos encontrados:', equipos.length);
                
                if (equipos.length === 0) {
                    select.innerHTML += '<option value="">No hay equipos disponibles</option>';
                    return;
                }
                
                equipos.forEach(e => {
                    const option = document.createElement('option');
                    option.value = e.id;
                    option.textContent = e.label || e.codigo + ' - ' + e.nombre;
                    select.appendChild(option);
                });
                
                console.log('✅ Equipos cargados correctamente');
            } else {
                select.innerHTML += '<option value="">Error al cargar equipos</option>';
                console.error('Error en la respuesta:', result.message);
            }
        } catch (error) {
            console.error('Error cargando equipos:', error);
            const select = document.getElementById('modalEquipo');
            if (select) {
                select.innerHTML = '<option value="">Error al cargar equipos</option>';
            }
        }
    }

    // ============================================
    // FUNCIONES PARA CARGAR DATOS
    // ============================================

    async function cargarEstadisticas() {
        try {
            const proyectoId = document.getElementById('selectorProyecto')?.value || '';
            const url = `${API_BASE}/estadisticas${proyectoId ? `?proyecto_id=${proyectoId}` : ''}`;
            
            const response = await fetch(url, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                document.getElementById('enMantenimiento').textContent = result.data.en_mantenimiento || 0;
                document.getElementById('programados').textContent = result.data.programados || 0;
                document.getElementById('completados').textContent = result.data.completados || 0;
                document.getElementById('costoMensual').textContent = '$' + Number(result.data.costo_mensual || 0).toFixed(2);
            }
        } catch (error) {
            console.error('Error cargando estadísticas:', error);
        }
    }

    async function cargarMantenimientosActivos() {
        try {
            const proyectoId = document.getElementById('selectorProyecto')?.value || '';
            const tipo = document.getElementById('selectorTipoMantto')?.value || '';
            const estatus = document.getElementById('selectorStatus')?.value || '';
            const busqueda = document.getElementById('buscador')?.value || '';
            
            let url = `${API_BASE}/activos?`;
            if (proyectoId) url += `proyecto_id=${proyectoId}&`;
            if (tipo) url += `tipo=${tipo}&`;
            if (estatus) url += `estatus=${estatus}&`;
            if (busqueda) url += `busqueda=${busqueda}&`;
            
            const response = await fetch(url, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                renderizarActivos(result.data);
                actualizarContador('activos', result.data.length);
            }
        } catch (error) {
            console.error('Error cargando mantenimientos activos:', error);
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
                        No hay mantenimientos activos
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
                    <td style="padding: 12px;">
                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalle" onclick="abrirDetalleMantenimiento(${item.id})"></i>
                        ${item.estatus === 'en_proceso' ? 
                            `<i class="fas fa-check-circle" style="color: #28a745; cursor: pointer; margin: 0 5px;" title="Completar" onclick="completarMantenimiento(${item.id})"></i>` : ''
                        }
                        ${item.estatus === 'pendiente' ?
                            `<i class="fas fa-play" style="color: #0d6efd; cursor: pointer; margin: 0 5px;" title="Iniciar" onclick="iniciarMantenimiento(${item.id})"></i>` : ''
                        }
                    </td>
                </tr>
            `;
        }).join('');
    }

    async function cargarMantenimientosProgramados() {
        try {
            const proyectoId = document.getElementById('selectorProyecto')?.value || '';
            const url = `${API_BASE}/programados${proyectoId ? `?proyecto_id=${proyectoId}` : ''}`;
            
            const response = await fetch(url, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                renderizarProgramados(result.data);
                actualizarContador('programados', result.data.programados.length);
            }
        } catch (error) {
            console.error('Error cargando mantenimientos programados:', error);
        }
    }

    function renderizarProgramados(data) {
        // Renderizar próximos 7 días
        const listaProximos = document.getElementById('listaProximos7Dias');
        if (listaProximos && data.proximos_7_dias) {
            if (data.proximos_7_dias.length === 0) {
                listaProximos.innerHTML = `
                    <div style="padding: 15px; text-align: center; color: #6c757d;">
                        No hay mantenimientos programados en los próximos 7 días
                    </div>
                `;
            } else {
                listaProximos.innerHTML = data.proximos_7_dias.map(item => `
                    <div style="display: flex; align-items: center; padding: 8px; background-color: #f8f9fa; border-radius: 4px; margin-bottom: 8px;">
                        <div style="width: 60px; font-weight: bold;">${formatDate(item.fecha_inicio)}</div>
                        <div style="flex: 1; margin-left: 10px;">${item.activo?.codigo || '-'} - ${item.activo?.nombre || '-'} (${ucfirst(item.tipo_mantenimiento)})</div>
                        <span class="badge-estado-pendiente">Programado</span>
                    </div>
                `).join('');
            }
        }

        // Renderizar gráfico por tipo
        const listaPorTipo = document.getElementById('listaPorTipo');
        if (listaPorTipo && data.por_tipo) {
            const total = data.por_tipo.reduce((sum, t) => sum + t.total, 0);
            if (total === 0) {
                listaPorTipo.innerHTML = `
                    <div style="padding: 15px; text-align: center; color: #6c757d;">
                        No hay datos
                    </div>
                `;
            } else {
                listaPorTipo.innerHTML = data.por_tipo.map(t => {
                    const porcentaje = Math.round((t.total / total) * 100);
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

        // Renderizar tabla de programados
        const tbody = document.getElementById('tablaProgramados');
        if (tbody && data.programados) {
            if (data.programados.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px; color: #6c757d;">
                            No hay mantenimientos programados
                        </td>
                    </tr>
                `;
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
                            <td style="padding: 12px;">
                                <i class="fas fa-play" style="color: #28a745; cursor: pointer; margin: 0 5px;" title="Iniciar" onclick="iniciarMantenimiento(${item.id})"></i>
                            </td>
                        </tr>
                    `;
                }).join('');
            }
        }
    }

    async function cargarHistorial() {
        try {
            const periodo = document.getElementById('filtroPeriodo')?.value || '30';
            const tipo = document.getElementById('filtroTipoHistorial')?.value || '';
            const url = `${API_BASE}/historial?periodo=${periodo}&tipo=${tipo}`;
            
            const response = await fetch(url, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                renderizarHistorial(result.data);
            }
        } catch (error) {
            console.error('Error cargando historial:', error);
        }
    }

    function renderizarHistorial(historial) {
        const tbody = document.getElementById('tablaHistorial');
        if (!tbody) return;
        
        const items = historial.data || [];
        
        if (items.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" style="text-align: center; padding: 30px; color: #6c757d;">
                        <i class="fas fa-history" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
                        No hay historial de mantenimientos
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = items.map(item => `
            <tr>
                <td style="padding: 12px;">${formatDate(item.fecha_fin || item.fecha_inicio)}</td>
                <td style="padding: 12px;">${item.activo?.codigo || '-'} - ${item.activo?.nombre || '-'}</td>
                <td style="padding: 12px;"><span class="badge-tipo-${item.tipo_mantenimiento}">${ucfirst(item.tipo_mantenimiento)}</span></td>
                <td style="padding: 12px;">${item.descripcion || '-'}</td>
                <td style="padding: 12px;">${item.responsable_asignado || '-'}</td>
                <td style="padding: 12px; text-align: right;">$${Number(item.costo || 0).toFixed(2)}</td>
                <td style="padding: 12px;">${calcularDuracion(item.fecha_inicio, item.fecha_fin)}</td>
                <td style="padding: 12px;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="abrirDetalleMantenimiento(${item.id})"></i>
                </td>
            </tr>
        `).join('');
    }

    async function cargarCostos() {
        try {
            const response = await fetch(`${API_BASE}/costos`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                renderizarCostos(result.data);
            }
        } catch (error) {
            console.error('Error cargando costos:', error);
        }
    }

    function renderizarCostos(data) {
        const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        
        // Gráfico de barras
        const contenedorBarras = document.getElementById('contenedorGraficoBarras');
        if (contenedorBarras && data.costos_mensuales) {
            const maxValor = Math.max(...data.costos_mensuales.map(m => m.total), 1);
            
            if (data.costos_mensuales.length === 0) {
                contenedorBarras.innerHTML = `
                    <div style="padding: 15px; text-align: center; color: #6c757d;">
                        No hay datos de costos
                    </div>
                `;
            } else {
                contenedorBarras.innerHTML = data.costos_mensuales.map(m => {
                    const mesIndex = parseInt(m.mes) - 1;
                    const altura = maxValor > 0 ? Math.round((m.total / maxValor) * 150) : 0;
                    return `
                        <div style="text-align: center;">
                            <div style="height: ${altura}px; width: 40px; background-color: #083CAE; border-radius: 4px 4px 0 0;"></div>
                            <div style="margin-top: 5px; font-size: 11px;">${meses[mesIndex]}</div>
                            <div style="font-size: 10px;">$${Math.round(m.total / 1000)}K</div>
                        </div>
                    `;
                }).join('');
            }
        }

        // Distribución
        const contenedorDistribucion = document.getElementById('contenedorDistribucion');
        if (contenedorDistribucion && data.distribucion) {
            const total = data.distribucion.reduce((sum, d) => sum + d.total, 0);
            
            if (total === 0) {
                contenedorDistribucion.innerHTML = `
                    <div style="padding: 15px; text-align: center; color: #6c757d;">
                        No hay datos
                    </div>
                `;
            } else {
                contenedorDistribucion.innerHTML = data.distribucion.map(d => {
                    const porcentaje = Math.round((d.total / total) * 100);
                    const color = getTipoColor(d.tipo_mantenimiento);
                    return `
                        <div style="margin-bottom: 15px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <span style="font-size: 13px;">${ucfirst(d.tipo_mantenimiento)}</span>
                                <span style="font-size: 13px; font-weight: 600;">$${Math.round(d.total / 1000)}K (${porcentaje}%)</span>
                            </div>
                            <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                <div style="width: ${porcentaje}%; height: 8px; background-color: ${color}; border-radius: 4px;"></div>
                            </div>
                        </div>
                    `;
                }).join('');
            }
        }

        // Tabla de costos por equipo
        const tbody = document.getElementById('tablaCostos');
        if (tbody && data.costos_por_equipo) {
            if (data.costos_por_equipo.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 30px; color: #6c757d;">
                            No hay datos de costos por equipo
                        </td>
                    </tr>
                `;
            } else {
                tbody.innerHTML = data.costos_por_equipo.map(item => {
                    const tendencia = Math.random() > 0.5 ? '↓' : '↑';
                    const color = tendencia === '↓' ? '#28a745' : '#dc3545';
                    const variacion = (Math.random() * 15).toFixed(0);
                    
                    return `
                        <tr>
                            <td style="padding: 12px;">${item.activo?.codigo || '-'} - ${item.activo?.nombre || '-'}</td>
                            <td style="padding: 12px;">${item.total_manttos || 0}</td>
                            <td style="padding: 12px; text-align: right;">$${Number(item.costo_total || 0).toFixed(2)}</td>
                            <td style="padding: 12px; text-align: right;">$${Number(item.promedio || 0).toFixed(2)}</td>
                            <td style="padding: 12px; text-align: right;">${formatDate(item.ultimo_mantto || null)}</td>
                            <td style="padding: 12px; text-align: center; color: ${color}; font-weight: 600;">
                                ${tendencia} ${variacion}%
                            </td>
                        </tr>
                    `;
                }).join('');
            }
        }
    }

    async function cargarAlertas() {
        try {
            const response = await fetch(`${API_BASE}/alertas`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                renderizarAlertas(result.data);
                actualizarContador('alertas', result.data.criticas.length);
            }
        } catch (error) {
            console.error('Error cargando alertas:', error);
        }
    }

    function renderizarAlertas(data) {
        // Críticas
        const criticasContainer = document.getElementById('alertasCriticas');
        if (criticasContainer) {
            if (data.criticas.length === 0) {
                criticasContainer.innerHTML = `
                    <div style="padding: 15px; background-color: #d4edda; border-left: 4px solid #28a745; border-radius: 4px;">
                        <p style="margin: 0; color: #155724;">✅ No hay alertas críticas</p>
                    </div>
                `;
            } else {
                criticasContainer.innerHTML = data.criticas.map(item => `
                    <div style="background-color: #f8d7da; border-left: 4px solid #dc3545; border-radius: 4px; padding: 15px; margin-bottom: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-exclamation-circle" style="color: #dc3545; font-size: 24px;"></i>
                            <div style="flex: 1;">
                                <h4 style="margin: 0; font-size: 14px; color: #721c24;">Mantenimiento Vencido - ${item.activo?.codigo || ''}</h4>
                                <p style="margin: 5px 0 0; font-size: 13px;">${item.descripcion || 'Mantenimiento programado no realizado'}</p>
                            </div>
                            <span style="color: #dc3545; font-weight: bold;">Vencido</span>
                        </div>
                    </div>
                `).join('');
            }
        }

        // Preventivas
        const preventivasContainer = document.getElementById('alertasPreventivas');
        if (preventivasContainer) {
            if (data.preventivas.length === 0) {
                preventivasContainer.innerHTML = `
                    <div style="padding: 15px; background-color: #d4edda; border-left: 4px solid #28a745; border-radius: 4px;">
                        <p style="margin: 0; color: #155724;">✅ No hay alertas preventivas</p>
                    </div>
                `;
            } else {
                preventivasContainer.innerHTML = data.preventivas.map(item => `
                    <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px; padding: 15px; margin-bottom: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-exclamation-triangle" style="color: #856404; font-size: 24px;"></i>
                            <div style="flex: 1;">
                                <h4 style="margin: 0; font-size: 14px; color: #856404;">${item.activo?.codigo || ''} - ${item.activo?.nombre || ''}</h4>
                                <p style="margin: 5px 0 0; font-size: 13px;">${ucfirst(item.tipo_mantenimiento)} - ${item.descripcion || 'Mantenimiento programado'}</p>
                            </div>
                            <span style="color: #856404; font-weight: bold;">Próximo</span>
                        </div>
                    </div>
                `).join('');
            }
        }

        // Información
        const infoContainer = document.getElementById('alertasInformacion');
        if (infoContainer) {
            if (data.informacion.length === 0) {
                infoContainer.innerHTML = `
                    <div style="padding: 15px; background-color: #d4edda; border-left: 4px solid #28a745; border-radius: 4px;">
                        <p style="margin: 0; color: #155724;">✅ No hay información de alertas</p>
                    </div>
                `;
            } else {
                infoContainer.innerHTML = data.informacion.map(item => `
                    <div style="background-color: #cce5ff; border-left: 4px solid #0d6efd; border-radius: 4px; padding: 15px; margin-bottom: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-info-circle" style="color: #0d6efd; font-size: 24px;"></i>
                            <div style="flex: 1;">
                                <h4 style="margin: 0; font-size: 14px; color: #0d6efd;">${item.codigo || ''} - ${item.nombre || ''}</h4>
                                <p style="margin: 5px 0 0; font-size: 13px;">
                                    Horas actuales: ${item.maquinaria?.horometro_actual || 0} / Límite: ${item.maquinaria?.horometro_proximo_mantenimiento || 500}
                                </p>
                            </div>
                            <span style="color: #0d6efd; font-weight: bold;">
                                ${Math.round((item.maquinaria?.horometro_proximo_mantenimiento || 500) - (item.maquinaria?.horometro_actual || 0))} hrs restantes
                            </span>
                        </div>
                    </div>
                `).join('');
            }
        }
    }

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
            if (span) {
                span.textContent = count;
            }
        }
    }

    // ============================================
    // ACCIONES
    // ============================================

    window.abrirDetalleMantenimiento = async function(id) {
        try {
            const modal = document.getElementById('modalVerDetalle');
            const contenido = document.getElementById('contenidoDetalle');
            
            contenido.innerHTML = `
                <div style="text-align: center; padding: 40px; color: #6c757d;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 36px;"></i>
                    <p style="margin-top: 10px;">Cargando detalle...</p>
                </div>
            `;
            
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            
            const response = await fetch(`${API_BASE}/${id}`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                const item = result.data;
                const prioridadBadge = getPrioridadBadge(item.prioridad || 'media');
                const estadoBadge = getEstadoBadge(item.estatus);
                
                contenido.innerHTML = `
                    <!-- Información general -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                        <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; border: 1px solid #dee2e6;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-tractor"></i> Información del Equipo
                            </h4>
                            <table style="width: 100%; font-size: 13px;">
                                <tr>
                                    <td style="padding: 5px 0; color: #6c757d;">ID Equipo:</td>
                                    <td style="padding: 5px 0; font-weight: 600;">${item.activo?.codigo || '-'}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px 0; color: #6c757d;">Tipo:</td>
                                    <td style="padding: 5px 0;">${item.activo?.nombre || '-'}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px 0; color: #6c757d;">Proyecto:</td>
                                    <td style="padding: 5px 0;">${item.activo?.proyecto_asignado?.nombre || '-'}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px 0; color: #6c757d;">Horómetro actual:</td>
                                    <td style="padding: 5px 0; font-weight: 600;">${item.activo?.maquinaria?.horometro_actual || '0 hrs'}</td>
                                </tr>
                            </table>
                        </div>

                        <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; border: 1px solid #dee2e6;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-info-circle"></i> Resumen
                            </h4>
                            <table style="width: 100%; font-size: 13px;">
                                <tr>
                                    <td style="padding: 5px 0; color: #6c757d;">Tipo Mantenimiento:</td>
                                    <td style="padding: 5px 0;">
                                        <span class="badge-tipo-${item.tipo_mantenimiento}">${ucfirst(item.tipo_mantenimiento)}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px 0; color: #6c757d;">Prioridad:</td>
                                    <td style="padding: 5px 0;">
                                        <span class="${prioridadBadge.class}">${prioridadBadge.label}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px 0; color: #6c757d;">Estado:</td>
                                    <td style="padding: 5px 0;">
                                        <span class="${estadoBadge.class}">${estadoBadge.label}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px 0; color: #6c757d;">Costo:</td>
                                    <td style="padding: 5px 0; font-weight: 600;">$${Number(item.costo || 0).toFixed(2)}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Fechas y responsables -->
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 25px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">Fecha de Inicio</div>
                            <div style="font-size: 15px; font-weight: 600; color: #083CAE;">${formatDate(item.fecha_inicio)}</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">Fecha Estimada Fin</div>
                            <div style="font-size: 15px; font-weight: 600; color: #083CAE;">${item.fecha_fin_estimada ? formatDate(item.fecha_fin_estimada) : '-'}</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">Responsable</div>
                            <div style="font-size: 15px; font-weight: 600; color: #083CAE;">${item.responsable_asignado || '-'}</div>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 15px; margin-bottom: 25px;">
                        <h4 style="color: #083CAE; margin: 0 0 10px 0; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-align-left"></i> Descripción
                        </h4>
                        <p style="margin: 0; font-size: 13px; line-height: 1.6; color: #495057;">${item.descripcion || 'Sin descripción'}</p>
                    </div>

                    <!-- Observaciones -->
                    ${item.observaciones ? `
                        <div style="background-color: #f8f9fa; border-radius: 6px; padding: 15px; margin-bottom: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 10px 0; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-clipboard"></i> Observaciones
                            </h4>
                            <p style="margin: 0; font-size: 13px; color: #495057;">${item.observaciones}</p>
                        </div>
                    ` : ''}

                    <!-- Botones de acción -->
                    <div style="display: flex; justify-content: flex-end; gap: 10px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                        ${item.estatus === 'en_proceso' ? `
                            <button onclick="completarMantenimiento(${item.id})" style="padding: 10px 20px; background-color: white; border: 1px solid #28a745; color: #28a745; border-radius: 4px; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                                <i class="fas fa-check-circle"></i> Completar
                            </button>
                        ` : ''}
                        ${item.estatus === 'pendiente' ? `
                            <button onclick="iniciarMantenimiento(${item.id})" style="padding: 10px 20px; background-color: white; border: 1px solid #0d6efd; color: #0d6efd; border-radius: 4px; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                                <i class="fas fa-play"></i> Iniciar
                            </button>
                        ` : ''}
                        <button onclick="cerrarModalDetalle()" style="padding: 10px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cerrar</button>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error cargando detalle:', error);
            document.getElementById('contenidoDetalle').innerHTML = `
                <div style="text-align: center; padding: 40px; color: #dc3545;">
                    <i class="fas fa-exclamation-circle" style="font-size: 36px;"></i>
                    <p style="margin-top: 10px;">Error al cargar el detalle</p>
                </div>
            `;
        }
    };

    window.iniciarMantenimiento = function(id) {
        if (!confirm('¿Está seguro de iniciar este mantenimiento?')) return;
        
        fetch(`${API_BASE}/${id}/iniciar`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion('Mantenimiento iniciado correctamente', 'success');
                cargarMantenimientosActivos();
                cargarEstadisticas();
                cerrarModalDetalle();
            } else {
                mostrarNotificacion(result.message || 'Error al iniciar mantenimiento', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al iniciar mantenimiento', 'error');
        });
    };

    window.completarMantenimiento = function(id) {
        if (!confirm('¿Está seguro de completar este mantenimiento?')) return;
        
        const costo = prompt('Ingrese el costo real del mantenimiento:', '0');
        if (costo === null) return;
        
        fetch(`${API_BASE}/${id}/completar`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                costo_real: parseFloat(costo) || 0,
                fecha_fin: new Date().toISOString().split('T')[0]
            })
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion('Mantenimiento completado correctamente', 'success');
                cargarMantenimientosActivos();
                cargarEstadisticas();
                cargarHistorial();
                cerrarModalDetalle();
            } else {
                mostrarNotificacion(result.message || 'Error al completar mantenimiento', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al completar mantenimiento', 'error');
        });
    };

    function cerrarModalDetalle() {
        document.getElementById('modalVerDetalle').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function cerrarModalRegistro() {
        document.getElementById('modalRegistrarMantto').style.display = 'none';
        document.body.style.overflow = 'auto';
        document.getElementById('formMantenimiento').reset();
    }

    // ============================================
    // EVENTOS
    // ============================================

    // Pestañas
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
            
            document.querySelectorAll('.mantenimiento-content').forEach(content => {
                content.style.display = 'none';
            });
            
            const target = document.getElementById(`tab-${currentTab}`);
            if (target) {
                target.style.display = 'block';
            }
            
            switch(currentTab) {
                case 'activos':
                    cargarMantenimientosActivos();
                    break;
                case 'programados':
                    cargarMantenimientosProgramados();
                    break;
                case 'historial':
                    cargarHistorial();
                    break;
                case 'costos':
                    cargarCostos();
                    break;
                case 'alertas':
                    cargarAlertas();
                    break;
            }
        });
    });

    // Filtros
    document.getElementById('selectorProyecto')?.addEventListener('change', function() {
        cargarEstadisticas();
        cargarMantenimientosActivos();
        cargarMantenimientosProgramados();
    });

    document.getElementById('selectorTipoMantto')?.addEventListener('change', cargarMantenimientosActivos);
    document.getElementById('selectorStatus')?.addEventListener('change', cargarMantenimientosActivos);
    document.getElementById('filtroPeriodo')?.addEventListener('change', cargarHistorial);
    document.getElementById('filtroTipoHistorial')?.addEventListener('change', cargarHistorial);

    document.getElementById('buscador')?.addEventListener('input', function() {
        cargarMantenimientosActivos();
    });

    // Botón Registrar - CORREGIDO
    document.getElementById('btnRegistrarMantto')?.addEventListener('click', function(e) {
        e.preventDefault();
        console.log('Abriendo modal de registro...');
        
        // Mostrar el modal
        document.getElementById('modalRegistrarMantto').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Establecer fecha actual
        const hoy = new Date();
        document.getElementById('modalFechaInicio').value = hoy.toISOString().split('T')[0];
        
        // Cargar equipos en el select
        cargarEquiposParaModal();
    });

    document.getElementById('btnProgramar')?.addEventListener('click', function() {
        document.getElementById('modalRegistrarMantto').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        cargarEquiposParaModal();
        
        const hoy = new Date();
        document.getElementById('modalFechaInicio').value = hoy.toISOString().split('T')[0];
        document.getElementById('modalTipoMantto').value = 'preventivo';
    });

    document.getElementById('btnExcel')?.addEventListener('click', function() {
        const url = `${API_BASE}/exportar/excel`;
        window.open(url, '_blank');
    });

    // Modal de registro
    document.getElementById('btnCerrarModalMantto')?.addEventListener('click', cerrarModalRegistro);
    document.getElementById('btnCancelarMantto')?.addEventListener('click', cerrarModalRegistro);

    document.getElementById('btnGuardarMantto')?.addEventListener('click', function() {
        const form = document.getElementById('formMantenimiento');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        
        if (!data.activo_id || !data.fecha_inicio || !data.descripcion) {
            mostrarNotificacion('Por favor complete los campos requeridos', 'warning');
            return;
        }

        const btn = this;
        const textoOriginal = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        btn.disabled = true;

        fetch(`${API_BASE}/registrar`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            btn.innerHTML = textoOriginal;
            btn.disabled = false;
            
            if (result.success) {
                mostrarNotificacion('Mantenimiento registrado correctamente', 'success');
                cerrarModalRegistro();
                cargarEstadisticas();
                cargarMantenimientosActivos();
                cargarMantenimientosProgramados();
            } else {
                mostrarNotificacion(result.message || 'Error al registrar mantenimiento', 'error');
            }
        })
        .catch(error => {
            btn.innerHTML = textoOriginal;
            btn.disabled = false;
            console.error('Error:', error);
            mostrarNotificacion('Error al registrar mantenimiento', 'error');
        });
    });

    // Cerrar modales al hacer clic fuera
    window.addEventListener('click', function(event) {
        if (event.target === document.getElementById('modalRegistrarMantto')) {
            cerrarModalRegistro();
        }
        if (event.target === document.getElementById('modalVerDetalle')) {
            cerrarModalDetalle();
        }
    });

    // ============================================
    // INICIALIZACIÓN
    // ============================================
    
    cargarProyectos();
    cargarEstadisticas();
    cargarMantenimientosActivos();
    cargarMantenimientosProgramados();
});
</script>
@endsection