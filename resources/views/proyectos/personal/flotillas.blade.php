@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Asistencia y Cuadrillas -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Asistencia y Cuadrillas
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE ASISTENCIA -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Personal</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalPersonal">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Presente Hoy</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalPresente">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Ausente Hoy</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalAusente">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">% Asistencia</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="porcentajeAsistencia">0%</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Selectores a la izquierda -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <!-- Filtro de Proyectos - Dropdown con checkboxes -->
                        <div style="position: relative; min-width: 200px;" id="proyectoFilterContainer">
                            <button type="button" id="btnFiltroProyectos" style="width: 100%; padding: 6px 12px; border: 1px solid #ced4da; border-radius: 4px; background-color: white; cursor: pointer; font-size: 14px; display: flex; justify-content: space-between; align-items: center; min-height: 38px;">
                                <span id="filtroProyectosLabel">Todos los proyectos</span>
                                <i class="fas fa-chevron-down" style="color: #6c757d; font-size: 12px;"></i>
                            </button>
                            
                            <div id="filtroProyectosDropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ced4da; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 1000; max-height: 280px; overflow: hidden; padding: 8px 0; margin-top: 2px;">
                                <div style="padding: 0 12px 8px 12px; border-bottom: 1px solid #e9ecef;">
                                    <input type="text" id="filtroProyectosBuscar" placeholder="Buscar proyecto..." style="width: 100%; padding: 6px 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                </div>
                                <div id="filtroProyectosLista" style="max-height: 180px; overflow-y: auto; padding: 8px 0;">
                                    <!-- Los checkboxes se cargarán dinámicamente -->
                                </div>
                                <div style="padding: 8px 12px; border-top: 1px solid #e9ecef; display: flex; gap: 10px; flex-wrap: wrap;">
                                    <button id="btnSeleccionarTodos" style="background: none; border: none; color: #083CAE; cursor: pointer; font-size: 12px; font-weight: 600;">Seleccionar todos</button>
                                    <button id="btnDeseleccionarTodos" style="background: none; border: none; color: #6c757d; cursor: pointer; font-size: 12px;">Deseleccionar todos</button>
                                    <button id="btnCerrarFiltro" style="background: none; border: none; color: #dc3545; cursor: pointer; font-size: 12px; margin-left: auto;">Cerrar</button>
                                </div>
                            </div>
                        </div>

                        <!-- Selector de fecha -->
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <input type="date" id="fechaAsistencia" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>

                        <select id="selectorCuadrilla" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                            <option value="">Todas las cuadrillas</option>
                        </select>

                        <select id="selectorEstatus" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 130px;">
                            <option value="">Todos los status</option>
                            <option value="Activo">✅ Presente</option>
                            <option value="Falta">❌ Ausente</option>
                            <option value="Retardo">⏰ Retardo</option>
                            <option value="Justificado">📋 Justificado</option>
                            <option value="Pendiente">⏳ Pendiente</option>
                        </select>
                    </div>
                    
                    <!-- Grupo de botones derecho -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <button id="btnTomarAsistencia" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Tomar Asistencia">
                                <i class="fas fa-clipboard-check"></i> Tomar Asistencia
                            </button>
                        </div>
                        <div>
                            <button id="btnAgregarCuadrilla" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #083CAE; font-size: 16px;" title="Agregar Cuadrilla">
                                <i class="fas fa-plus" style="color: #083CAE;"></i>
                            </button>
                        </div>
                        <div>
                            <button id="btnAsignarEmpleados" style="background-color: #ffc107; color: #856404; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Asignar empleados a cuadrillas">
                                <i class="fas fa-user-plus"></i> Asignar Empleados
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
                            <input type="text" id="buscador" placeholder="Buscar personal..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Pestañas de secciones -->
                <div style="display: flex; gap: 2px; margin-bottom: 20px; border-bottom: 2px solid #083CAE;">
                    <button class="asistencia-tab active" data-tab="asistencia" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-clipboard-list"></i> Asistencia Diaria
                    </button>
                    <button class="asistencia-tab" data-tab="cuadrillas" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-users"></i> Cuadrillas
                    </button>
                    <button class="asistencia-tab" data-tab="resumen" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-chart-bar"></i> Reporte de Asistencia
                    </button>
                </div>

                <!-- Loading -->
                <div id="loadingSpinner" style="text-align: center; padding: 40px; display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
                    <p style="margin-top: 10px; color: #6c757d;">Cargando datos...</p>
                </div>

                <!-- Mensaje "Sin datos" -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-calendar-check" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin registros</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros de asistencia para la fecha seleccionada</p>
                </div>

                <!-- SECCIÓN 1: ASISTENCIA DIARIA -->
                <div id="tab-asistencia" class="asistencia-content active">
                    <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                        <table class="table table-bordered" id="tablaAsistencia" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                            <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                                <tr>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">No. Empleado</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Nombre</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Proyecto</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Cuadrilla</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Hora Entrada</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Hora Salida</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Horas</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Status</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodyAsistencia">
                                <!-- Las filas se insertarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación -->
                    <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px;">
                        <div style="visibility: hidden;"></div>
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <button id="btnPrimera" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-double-left"></i></button>
                            <button id="btnAnterior" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-left"></i></button>
                            <span id="paginaActual" style="padding: 5px 12px; background-color: #2378e1; color: white; border-radius: 4px;">1</span>
                            <span id="totalPaginas" style="margin-left: 5px; color: #6c757d;">de 1</span>
                            <button id="btnSiguiente" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-right"></i></button>
                            <button id="btnUltima" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-double-right"></i></button>
                            <span id="paginacionInfo" style="margin-left: 10px; color: #2378e1;"></span>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 2: CUADRILLAS -->
                <div id="tab-cuadrillas" class="asistencia-content" style="display: none;">
                    <!-- Resumen de cuadrillas -->
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;" id="cuadrillasResumen">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 40px; height: 40px; background-color: #e8f0fe; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-people-arrows" style="color: #083CAE;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Total Cuadrillas</div>
                                    <div style="font-size: 24px; font-weight: bold; color: #083CAE;" id="totalCuadrillas">0</div>
                                </div>
                            </div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 40px; height: 40px; background-color: #d4edda; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user-check" style="color: #28a745;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Cuadrillas Activas</div>
                                    <div style="font-size: 24px; font-weight: bold; color: #28a745;" id="cuadrillasActivas">0</div>
                                </div>
                            </div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 40px; height: 40px; background-color: #fff3cd; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-users" style="color: #ffc107;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Total Integrantes</div>
                                    <div style="font-size: 24px; font-weight: bold; color: #ffc107;" id="totalIntegrantes">0</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Cuadrillas -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
                        <table class="table table-bordered" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Cuadrilla</th>
                                    <th style="padding: 12px;">Encargado</th>
                                    <th style="padding: 12px;">Proyecto</th>
                                    <th style="padding: 12px;">Especialidad</th>
                                    <th style="padding: 12px; text-align: center;">Integrantes</th>
                                    <th style="padding: 12px; text-align: center;">Status</th>
                                    <th style="padding: 12px; text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodyCuadrillas">
                                <!-- Las filas se insertarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 3: REPORTE DE ASISTENCIA -->
                <div id="tab-resumen" class="asistencia-content" style="display: none;">
                    <!-- Selector de período -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <label style="font-weight: 600; color: #083CAE;">Período:</label>
                            <select id="selectorMes" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3" selected>Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                            <select id="selectorAnio" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026" selected>2026</option>
                            </select>
                            <button id="btnGenerarReporte" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px;">
                                <i class="fas fa-sync-alt"></i> Actualizar
                            </button>
                        </div>
                        <div>
                            <span style="background-color: #e8f0fe; color: #083CAE; padding: 8px 15px; border-radius: 4px; font-weight: 600;" id="diasLaborales">
                                <i class="fas fa-calendar"></i> Días laborales: --
                            </span>
                        </div>
                    </div>

                    <!-- Tarjetas de resumen mensual -->
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px;" id="resumenMensual">
                        <div style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="color: #6c757d; font-size: 12px;">Total de registros</div>
                            <div style="font-size: 28px; font-weight: bold; color: #083CAE;" id="totalRegistros">0</div>
                        </div>
                        <div style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="color: #6c757d; font-size: 12px;">Horas totales</div>
                            <div style="font-size: 28px; font-weight: bold; color: #083CAE;" id="totalHoras">0</div>
                        </div>
                        <div style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="color: #6c757d; font-size: 12px;">Ausentismo</div>
                            <div style="font-size: 28px; font-weight: bold; color: #083CAE;" id="porcentajeAusentismo">0%</div>
                        </div>
                        <div style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="color: #6c757d; font-size: 12px;">Puntualidad</div>
                            <div style="font-size: 28px; font-weight: bold; color: #083CAE;" id="porcentajePuntualidad">0%</div>
                        </div>
                    </div>

                    <!-- Gráfico de asistencia por día -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                            <i class="fas fa-chart-line"></i> Asistencia Diaria
                        </h4>
                        <div id="graficoAsistencia" style="height: 200px; display: flex; align-items: flex-end; gap: 3px; justify-content: space-between; padding-top: 20px;">
                            <!-- Las barras se cargarán dinámicamente -->
                        </div>
                        <div style="display: flex; justify-content: center; gap: 30px; margin-top: 25px;">
                            <span style="font-size: 12px; display: flex; align-items: center; gap: 5px;">
                                <span style="display: inline-block; width: 12px; height: 12px; background-color: #083CAE; border-radius: 2px;"></span> Día laboral
                            </span>
                            <span style="font-size: 12px; display: flex; align-items: center; gap: 5px;">
                                <span style="display: inline-block; width: 12px; height: 12px; background-color: #6c757d; border-radius: 2px;"></span> Día de descanso
                            </span>
                        </div>
                    </div>

                    <!-- Tabla resumen por proyecto -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                        <div style="background-color: #f8f9fa; padding: 12px 15px; border-bottom: 2px solid #083CAE;">
                            <h5 style="margin: 0; color: #083CAE; font-size: 15px;"><i class="fas fa-chart-pie"></i> Resumen por Proyecto</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="padding: 12px;">Proyecto</th>
                                        <th style="padding: 12px; text-align: right;">Registros</th>
                                        <th style="padding: 12px; text-align: right;">Horas</th>
                                        <th style="padding: 12px; text-align: right;">Presentes</th>
                                        <th style="padding: 12px; text-align: right;">Ausentes</th>
                                        <th style="padding: 12px; text-align: right;">Retardos</th>
                                        <th style="padding: 12px; text-align: right;">% Asist.</th>
                                    </tr>
                                </thead>
                                <tbody id="resumenProyectos">
                                    <!-- Las filas se cargarán dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Tomar Asistencia -->
<div id="modalTomarAsistencia" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-clipboard-check"></i> Tomar Asistencia</h3>
            <button id="btnCerrarModalAsistencia" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <div style="display: flex; gap: 15px; margin-bottom: 20px; align-items: center; flex-wrap: wrap;">
                <div>
                    <label style="font-weight: 600; margin-right: 10px;">Fecha:</label>
                    <input type="date" id="modalFechaAsistencia" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="font-weight: 600; margin-right: 10px;">Cuadrilla:</label>
                    <select id="modalCuadrillaAsistencia" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; min-width: 200px;">
                        <option value="">Seleccionar cuadrilla...</option>
                    </select>
                </div>
                <div style="margin-left: auto;">
                    <button id="btnMarcarTodosPresente" style="background-color: #28a745; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer;">
                        <i class="fas fa-check-double"></i> Marcar todos presente
                    </button>
                </div>
            </div>

            <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 4px; max-height: 400px; overflow-y: auto;">
                <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
                    <thead style="background-color: #f8f9fa; position: sticky; top: 0;">
                        <tr>
                            <th style="padding: 10px;">No. Empleado</th>
                            <th style="padding: 10px;">Nombre</th>
                            <th style="padding: 10px;">Hora Entrada</th>
                            <th style="padding: 10px;">Status</th>
                            <th style="padding: 10px; text-align: center;">Seleccionar</th>
                        </tr>
                    </thead>
                    <tbody id="modalTablaPersonal">
                        <!-- Se llenará con JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelarAsistencia" style="padding: 10px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button id="btnGuardarAsistencia" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                <i class="fas fa-save"></i> Guardar Asistencia
            </button>
        </div>
    </div>
</div>

<!-- Modal para Agregar/Editar Cuadrilla -->
<div id="modalCuadrilla" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 700px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;" id="modalCuadrillaTitulo"><i class="fas fa-users"></i> Nueva Cuadrilla</h3>
            <button id="btnCerrarModalCuadrilla" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <form id="formCuadrilla">
                <input type="hidden" id="editCuadrillaId">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Código</label>
                        <input type="text" id="campoCodigo" name="codigo" placeholder="Ej: CUA-001" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Nombre <span style="color: #dc3545;">*</span></label>
                        <input type="text" id="campoNombre" name="nombre" required placeholder="Nombre de la cuadrilla" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Especialidad <span style="color: #dc3545;">*</span></label>
                        <select id="campoEspecialidad" name="especialidad" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar...</option>
                            <option value="cimentacion">🏗️ Cimentación</option>
                            <option value="estructura">🏢 Estructura</option>
                            <option value="acabados">🎨 Acabados</option>
                            <option value="instalaciones">🔌 Instalaciones</option>
                            <option value="obra_negra">🧱 Obra Negra</option>
                            <option value="albanileria">🔨 Albañilería</option>
                            <option value="herreria">⚙️ Herrería</option>
                            <option value="electricidad">⚡ Electricidad</option>
                            <option value="plomeria">💧 Plomería</option>
                            <option value="pintura">🖌️ Pintura</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Proyecto</label>
                        <select id="campoProyecto" name="proyecto_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Sin proyecto</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Encargado</label>
                        <select id="campoEncargado" name="encargado_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Sin encargado</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Estatus</label>
                        <select id="campoEstatus" name="estatus" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="activo">✅ Activo</option>
                            <option value="inactivo">❌ Inactivo</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Descripción</label>
                    <textarea id="campoDescripcion" name="descripcion" rows="2" placeholder="Descripción de la cuadrilla" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Integrantes</label>
                    <select id="campoIntegrantes" name="integrantes[]" multiple style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-height: 100px;">
                        <!-- Se llenará con JavaScript -->
                    </select>
                    <p style="font-size: 11px; color: #6c757d; margin-top: 5px;">Mantén presionado Ctrl para seleccionar múltiples integrantes</p>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Observaciones</label>
                    <textarea id="campoObservacionesCuadrilla" name="observaciones" rows="2" placeholder="Observaciones adicionales" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #dee2e6; padding-top: 20px;">
                    <button type="button" id="btnCancelarCuadrilla" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Cancelar</button>
                    <button type="submit" style="padding: 8px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-save"></i> <span id="btnCuadrillaTexto">Guardar Cuadrilla</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Asignar Empleados a Cuadrillas -->
<div id="modalAsignarEmpleados" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 700px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-user-plus"></i> Asignar Empleados a Cuadrillas</h3>
            <button id="btnCerrarAsignar" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Empleado <span style="color: #dc3545;">*</span></label>
                    <select id="selectEmpleadoAsignar" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        <option value="">Seleccionar empleado...</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Cuadrilla <span style="color: #dc3545;">*</span></label>
                    <select id="selectCuadrillaAsignar" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        <option value="">Seleccionar cuadrilla...</option>
                    </select>
                </div>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Observaciones</label>
                <textarea id="asignarObservaciones" rows="2" placeholder="Observaciones de la asignación" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
            </div>

            <!-- Tabla de asignaciones actuales -->
            <div style="margin-top: 20px; border-top: 1px solid #dee2e6; padding-top: 15px;">
                <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;">
                    <i class="fas fa-list"></i> Asignaciones Actuales
                </h4>
                <div class="table-responsive" style="max-height: 200px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 4px;">
                    <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
                        <thead style="background-color: #f8f9fa; position: sticky; top: 0;">
                            <tr>
                                <th style="padding: 8px; text-align: left;">Empleado</th>
                                <th style="padding: 8px; text-align: left;">Cuadrilla</th>
                                <th style="padding: 8px; text-align: center;">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="tablaAsignaciones">
                            <!-- Se llenará dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelarAsignar" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Cancelar</button>
            <button id="btnGuardarAsignacion" style="padding: 8px 20px; background-color: #ffc107; color: #856404; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                <i class="fas fa-save"></i> Asignar
            </button>
        </div>
    </div>
</div>

<!-- Modal para Ver Detalle de Asistencia -->
<div id="modalVerDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 600px; max-height: 80vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #2378e1 0%, #1a5cb0 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-user-clock"></i> Detalle de Asistencia</h3>
            <button id="btnCerrarModalDetalle" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div style="padding: 20px;" id="modalContenidoDetalle"></div>
    </div>
</div>

<style>
    .semaforo .card-header { background-color: #f4f6f9; border-bottom: 2px solid #083CAE; }
    .semaforo .card-header h2 { color: #083CAE !important; }
    
    .custom-card { transition: transform 0.2s, box-shadow 0.2s; height: 100%; }
    .custom-card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(8, 60, 174, 0.15) !important; border-color: #083CAE !important; }
    
    .table th { white-space: nowrap; font-size: 12px; background-color: #2378e1 !important; color: white; font-weight: 600; padding: 10px 4px; }
    .table td { white-space: nowrap; font-size: 12px; padding: 10px 4px; color: #000000 !important; }
    
    #tablaBodyAsistencia tr:nth-child(odd), #tablaBodyCuadrillas tr:nth-child(odd) { background-color: #ffffff; }
    #tablaBodyAsistencia tr:nth-child(even), #tablaBodyCuadrillas tr:nth-child(even) { background-color: #f2f2f2; }
    #tablaBodyAsistencia tr:hover, #tablaBodyCuadrillas tr:hover { background-color: #e0e0e0; }
    
    #tablaBodyAsistencia td:last-child, #tablaBodyCuadrillas td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
    }
    
    .badge { font-size: 11px; font-weight: 600; padding: 4px 8px; display: inline-block; border-radius: 3px; }
    .badge-Activo { background-color: #d4edda; color: #28a745; }
    .badge-Falta { background-color: #f8d7da; color: #dc3545; }
    .badge-Retardo { background-color: #fff3cd; color: #856404; }
    .badge-Justificado { background-color: #cce5ff; color: #0d6efd; }
    .badge-Pendiente { background-color: #e2e3e5; color: #6c757d; }
    
    .badge-cimentacion { background-color: #cce5ff; color: #0d6efd; }
    .badge-estructura { background-color: #d4edda; color: #28a745; }
    .badge-acabados { background-color: #fff3cd; color: #856404; }
    .badge-instalaciones { background-color: #d1ecf1; color: #0c5460; }
    .badge-obra_negra { background-color: #e8f0fe; color: #2378e1; }
    .badge-albanileria { background-color: #f8d7da; color: #dc3545; }
    .badge-herreria { background-color: #e2e3e5; color: #6c757d; }
    .badge-electricidad { background-color: #ffe5d0; color: #fd7e14; }
    .badge-plomeria { background-color: #d4f5e6; color: #20c997; }
    .badge-pintura { background-color: #f5d4e6; color: #e83e8c; }
    
    .badge-activo { background-color: #d4edda; color: #28a745; }
    .badge-inactivo { background-color: #f8d7da; color: #dc3545; }
    
    .asistencia-tab { transition: all 0.3s ease; }
    .asistencia-tab:hover { opacity: 0.9; transform: translateY(-2px); }
    .asistencia-tab.active { background-color: #083CAE !important; color: white !important; }
    .asistencia-content { animation: fadeIn 0.3s ease; }
    
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    
    .toast-notification { position: fixed; bottom: 20px; right: 20px; z-index: 100000; animation: slideIn 0.3s ease; padding: 12px 20px; border-radius: 8px; margin-bottom: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); font-size: 14px; }
    .toast-notification.success { background-color: #28a745; color: white; }
    .toast-notification.error { background-color: #dc3545; color: white; }
    .toast-notification.warning { background-color: #ffc107; color: #333; }
    
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    
    #filtroProyectosDropdown { min-width: 250px; }
    #filtroProyectosLista label { display: flex; align-items: center; padding: 4px 12px; cursor: pointer; font-size: 13px; transition: background 0.2s; }
    #filtroProyectosLista label:hover { background-color: #f0f4ff; }
    #filtroProyectosLista input[type="checkbox"] { margin-right: 8px; cursor: pointer; }
    
    #paginacionContainer { background: transparent !important; background-color: transparent !important; border: none !important; box-shadow: none !important; }
    #paginacionContainer * { background: transparent !important; background-color: transparent !important; }
    #paginacionContainer span[style*="background-color"] { background-color: #2378e1 !important; }
    #paginacionContainer button { background: transparent !important; border: none !important; color: #2378e1 !important; cursor: pointer; }
    #paginacionContainer button:hover { opacity: 0.7; }
    #paginacionContainer button i { color: #2378e1 !important; }
    #paginacionInfo { color: #2378e1 !important; }
    
    /* Gráfico */
    #graficoAsistencia .barra-container { display: flex; flex-direction: column; align-items: center; width: 3%; min-width: 20px; }
    #graficoAsistencia .barra { width: 100%; border-radius: 4px 4px 0 0; min-height: 2px; transition: height 0.5s ease; }
    #graficoAsistencia .barra-label { font-size: 8px; color: #6c757d; margin-top: 4px; text-align: center; }
    
    @media (max-width: 768px) {
        input[type="date"] { width: 100% !important; }
        input#buscador { width: 100% !important; }
        #proyectoFilterContainer { min-width: 100% !important; }
        #filtroProyectosDropdown { min-width: 100% !important; }
        #paginacionContainer { flex-direction: column; align-items: flex-start; }
        #modalTomarAsistencia > div, #modalCuadrilla > div, #modalAsignarEmpleados > div, #modalVerDetalle > div { width: 95%; margin: 10px; }
        .asistencia-tab { padding: 8px 12px !important; font-size: 12px !important; }
        #resumenMensual { grid-template-columns: 1fr 1fr !important; }
        #graficoAsistencia .barra-container { width: 2.5%; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // ============================================
    // CONFIGURACIÓN
    // ============================================
    const API_BASE = '/proyectos/asistencia-cuadrillas';
    let currentPage = 1;
    let totalPages = 1;
    let currentTab = 'asistencia';
    let proyectosLista = [];
    let editCuadrillaId = null;
    let asignacionesActuales = {};
    
    let currentFilters = {
        busqueda: '',
        proyecto_id: [],
        cuadrilla_id: '',
        estatus: '',
        fecha: '',
        page: 1,
        per_page: 10
    };

    // ============================================
    // FUNCIONES PRINCIPALES
    // ============================================

    async function cargarAsistencias() {
        mostrarLoading(true);
        
        try {
            const proyectosSeleccionados = getProyectosSeleccionados();
            currentFilters.proyecto_id = proyectosSeleccionados;
            
            const params = new URLSearchParams();
            params.append('busqueda', currentFilters.busqueda || '');
            params.append('cuadrilla_id', currentFilters.cuadrilla_id || '');
            params.append('estatus', currentFilters.estatus || '');
            params.append('fecha', currentFilters.fecha || '');
            params.append('page', currentFilters.page || 1);
            params.append('per_page', currentFilters.per_page || 10);
            
            if (proyectosSeleccionados.length > 0) {
                proyectosSeleccionados.forEach(id => {
                    params.append('proyecto_id[]', id);
                });
            }
            
            const url = `${API_BASE}/asistencias?${params.toString()}`;
            console.log('Cargando asistencias desde:', url);
            
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            });
            
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP ${response.status}: ${errorText.substring(0, 200)}`);
            }
            
            const result = await response.json();
            
            if (result.success) {
                const data = result.data.data || [];
                const pagination = result.data;
                
                actualizarEstadisticas(result.estadisticas);
                renderizarTablaAsistencia(data);
                actualizarPaginacion(pagination);
                
                currentPage = pagination.current_page || 1;
                totalPages = pagination.last_page || 1;
            } else {
                mostrarNotificacion(result.message || 'Error al cargar datos', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarNotificacion('Error al cargar las asistencias', 'error');
        } finally {
            mostrarLoading(false);
        }
    }

    async function cargarCuadrillas() {
        try {
            const params = new URLSearchParams();
            params.append('proyecto_id', currentFilters.proyecto_id || '');
            
            const response = await fetch(`${API_BASE}/cuadrillas?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) throw new Error('Error al cargar cuadrillas');
            
            const result = await response.json();
            
            if (result.success) {
                renderizarTablaCuadrillas(result.data);
                actualizarResumenCuadrillas(result.resumen);
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarNotificacion('Error al cargar cuadrillas', 'error');
        }
    }

    async function cargarCatalogos() {
        try {
            const response = await fetch(`${API_BASE}/catalogos`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                const data = result.data;
                
                // Llenar select de cuadrillas
                const selectCuadrilla = document.getElementById('selectorCuadrilla');
                selectCuadrilla.innerHTML = '<option value="">Todas las cuadrillas</option>';
                data.cuadrillas.forEach(c => {
                    selectCuadrilla.innerHTML += `<option value="${c.id}">${c.nombre}</option>`;
                });
                
                // Llenar select de proyectos en modal cuadrilla
                const selectProyecto = document.getElementById('campoProyecto');
                selectProyecto.innerHTML = '<option value="">Sin proyecto</option>';
                data.proyectos.forEach(p => {
                    selectProyecto.innerHTML += `<option value="${p.id}">${p.nombre}</option>`;
                });
                
                // Llenar select de empleados en modal cuadrilla
                const selectIntegrantes = document.getElementById('campoIntegrantes');
                selectIntegrantes.innerHTML = '';
                data.empleados.forEach(e => {
                    selectIntegrantes.innerHTML += `<option value="${e.id}">${e.nombre_completo}</option>`;
                });
                
                // Llenar select de encargados en modal cuadrilla
                const selectEncargado = document.getElementById('campoEncargado');
                selectEncargado.innerHTML = '<option value="">Sin encargado</option>';
                data.empleados.forEach(e => {
                    selectEncargado.innerHTML += `<option value="${e.id}">${e.nombre_completo}</option>`;
                });
                
                // Llenar select de cuadrillas en modal asistencia
                const selectCuadrillaAsistencia = document.getElementById('modalCuadrillaAsistencia');
                selectCuadrillaAsistencia.innerHTML = '<option value="">Seleccionar cuadrilla...</option>';
                data.cuadrillas.forEach(c => {
                    selectCuadrillaAsistencia.innerHTML += `<option value="${c.id}">${c.nombre}</option>`;
                });
                
                // Llenar select de cuadrillas en modal asignar
                const selectCuadrillaAsignar = document.getElementById('selectCuadrillaAsignar');
                selectCuadrillaAsignar.innerHTML = '<option value="">Seleccionar cuadrilla...</option>';
                data.cuadrillas.forEach(c => {
                    selectCuadrillaAsignar.innerHTML += `<option value="${c.id}">${c.nombre}</option>`;
                });
                
                // Guardar proyectos para filtro
                proyectosLista = data.proyectos;
                renderizarCheckboxesProyectos(proyectosLista);
            }
        } catch (error) {
            console.error('Error cargando catálogos:', error);
        }
    }

    // ============================================
    // FILTRO DE PROYECTOS
    // ============================================

    function getProyectosSeleccionados() {
        const checkboxes = document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]:checked');
        const selected = [];
        checkboxes.forEach(cb => {
            if (cb.value) {
                selected.push(cb.value);
            }
        });
        return selected;
    }

    function actualizarLabelProyectos() {
        const total = document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]').length;
        const selected = getProyectosSeleccionados().length;
        const label = document.getElementById('filtroProyectosLabel');
        
        if (selected === 0 || selected === total) {
            label.textContent = 'Todos los proyectos';
        } else {
            label.textContent = `${selected} proyecto${selected > 1 ? 's' : ''} seleccionado${selected > 1 ? 's' : ''}`;
        }
    }

    function toggleDropdown() {
        const dropdown = document.getElementById('filtroProyectosDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    function cerrarDropdown() {
        document.getElementById('filtroProyectosDropdown').style.display = 'none';
    }

    function renderizarCheckboxesProyectos(proyectos) {
        const lista = document.getElementById('filtroProyectosLista');
        lista.innerHTML = '';
        
        if (!proyectos || proyectos.length === 0) {
            lista.innerHTML = '<div style="padding: 8px 12px; color: #6c757d; font-size: 13px;">No hay proyectos disponibles</div>';
            return;
        }
        
        const selected = getProyectosSeleccionados();
        
        proyectos.forEach(proyecto => {
            const checked = selected.includes(String(proyecto.id)) ? 'checked' : '';
            const label = document.createElement('label');
            label.innerHTML = `
                <input type="checkbox" value="${proyecto.id}" ${checked}>
                <span>${proyecto.nombre}</span>
            `;
            lista.appendChild(label);
        });
        
        actualizarLabelProyectos();
    }

    function filtrarProyectosLista(busqueda) {
        const labels = document.querySelectorAll('#filtroProyectosLista label');
        const term = busqueda.toLowerCase().trim();
        
        labels.forEach(label => {
            const text = label.textContent.toLowerCase();
            label.style.display = text.includes(term) ? 'flex' : 'none';
        });
    }

    function seleccionarTodosProyectos() {
        const todosVisibles = document.querySelectorAll('#filtroProyectosLista label:not([style*="display: none"])');
        todosVisibles.forEach(label => {
            const cb = label.querySelector('input[type="checkbox"]');
            if (cb) cb.checked = true;
        });
        actualizarLabelProyectos();
        aplicarFiltroProyectos();
    }

    function deseleccionarTodosProyectos() {
        const checkboxes = document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]');
        checkboxes.forEach(cb => cb.checked = false);
        actualizarLabelProyectos();
        aplicarFiltroProyectos();
    }

    function aplicarFiltroProyectos() {
        currentFilters.page = 1;
        if (currentTab === 'asistencia') {
            cargarAsistencias();
        } else {
            cargarCuadrillas();
        }
    }

    // ============================================
    // RENDERIZADO - ASISTENCIA
    // ============================================

    function renderizarTablaAsistencia(asistencias) {
        const tbody = document.getElementById('tablaBodyAsistencia');
        const sinDatos = document.getElementById('sinDatosMensaje');
        const tablaContainer = document.getElementById('tablaContainer');
        
        if (!tbody) return;
        
        tbody.innerHTML = '';
        
        if (!asistencias || asistencias.length === 0) {
            sinDatos.style.display = 'block';
            tablaContainer.style.display = 'none';
            return;
        }
        
        sinDatos.style.display = 'none';
        tablaContainer.style.display = 'block';
        
        asistencias.forEach(item => {
            const row = document.createElement('tr');
            const statusBadge = getStatusBadge(item.estatus);
            const horas = item.horas_trabajadas || 0;
            
            row.innerHTML = `
                <td style="padding: 10px 4px;">${item.empleado?.numero_empleado_interno || item.plantilla_id}</td>
                <td style="padding: 10px 4px;">${item.nombre_completo || '-'}</td>
                <td style="padding: 10px 4px;">${item.cuadrilla?.proyecto?.nombre || '-'}</td>
                <td style="padding: 10px 4px;">${item.cuadrilla?.nombre || '-'}</td>
                <td style="padding: 10px 4px;">${item.hora_entrada || '--:--'}</td>
                <td style="padding: 10px 4px;">${item.hora_salida || '--:--'}</td>
                <td style="padding: 10px 4px; text-align: right;">${horas ? horas.toFixed(1) : '-'}</td>
                <td style="padding: 10px 4px;"><span class="badge badge-${item.estatus}">${item.estatus_nombre || '-'}</span></td>
                <td style="padding: 10px 4px; background-color: white; position: sticky; right: 0;">
                    <div style="display: flex; gap: 8px; justify-content: center;">
                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetalleAsistencia(${item.id})"></i>
                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" onclick="editarAsistencia(${item.id})"></i>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    // ============================================
    // RENDERIZADO - CUADRILLAS
    // ============================================

    function renderizarTablaCuadrillas(cuadrillas) {
        const tbody = document.getElementById('tablaBodyCuadrillas');
        
        if (!tbody) return;
        
        tbody.innerHTML = '';
        
        if (!cuadrillas || cuadrillas.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" style="text-align: center; padding: 30px; color: #6c757d;">
                        <i class="fas fa-users" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
                        No hay cuadrillas registradas
                    </td>
                </tr>
            `;
            return;
        }
        
        cuadrillas.forEach(item => {
            const row = document.createElement('tr');
            const especialidadBadge = getEspecialidadBadge(item.especialidad);
            const estatusBadge = item.estatus === 'activo' ? 'badge-activo' : 'badge-inactivo';
            const integrantesCount = item.integrantes ? item.integrantes.length : 0;
            
            row.innerHTML = `
                <td style="padding: 12px;"><strong>${item.codigo}</strong><br><span style="font-size: 11px; color: #6c757d;">${item.nombre}</span></td>
                <td style="padding: 12px;">${item.nombre_encargado || 'Sin encargado'}</td>
                <td style="padding: 12px;">${item.proyecto?.nombre || '-'}</td>
                <td style="padding: 12px;"><span class="badge ${especialidadBadge}">${item.especialidad_nombre}</span></td>
                <td style="padding: 12px; text-align: center;">${integrantesCount}</td>
                <td style="padding: 12px; text-align: center;"><span class="badge ${estatusBadge}">${item.estatus_nombre}</span></td>
                <td style="padding: 12px; text-align: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verDetalleCuadrilla(${item.id})"></i>
                    <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="editarCuadrilla(${item.id})"></i>
                    <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; margin: 0 5px;" onclick="eliminarCuadrilla(${item.id})"></i>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    function actualizarResumenCuadrillas(resumen) {
        if (!resumen) return;
        document.getElementById('totalCuadrillas').textContent = resumen.total || 0;
        document.getElementById('cuadrillasActivas').textContent = resumen.activas || 0;
        document.getElementById('totalIntegrantes').textContent = resumen.total_integrantes || 0;
    }

    // ============================================
    // RENDERIZADO - REPORTE MENSUAL
    // ============================================

    async function cargarReporteMensual() {
        const mes = document.getElementById('selectorMes').value;
        const anio = document.getElementById('selectorAnio').value;
        
        try {
            const response = await fetch(`${API_BASE}/reporte-mensual?mes=${mes}&anio=${anio}`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                const data = result.data;
                
                document.getElementById('diasLaborales').innerHTML = `<i class="fas fa-calendar"></i> Días laborales: ${data.dias_laborales || 0}`;
                document.getElementById('totalRegistros').textContent = data.total_registros || 0;
                document.getElementById('totalHoras').textContent = (data.total_horas || 0).toFixed(1);
                
                const total = data.total_registros || 0;
                const ausentes = data.resumen_proyectos ? Object.values(data.resumen_proyectos).reduce((sum, p) => sum + (p.ausentes || 0), 0) : 0;
                const retardos = data.resumen_proyectos ? Object.values(data.resumen_proyectos).reduce((sum, p) => sum + (p.retardos || 0), 0) : 0;
                
                document.getElementById('porcentajeAusentismo').textContent = total > 0 ? Math.round((ausentes / total) * 100) + '%' : '0%';
                document.getElementById('porcentajePuntualidad').textContent = total > 0 ? Math.round(((total - retardos) / total) * 100) + '%' : '0%';
                
                renderizarGrafico(data.grafico || []);
                renderizarResumenProyectos(data.resumen_proyectos || {});
            }
        } catch (error) {
            console.error('Error al cargar reporte:', error);
            mostrarNotificacion('Error al cargar el reporte mensual', 'error');
        }
    }

    function renderizarGrafico(dias) {
        const container = document.getElementById('graficoAsistencia');
        container.innerHTML = '';
        
        if (!dias || dias.length === 0) {
            container.innerHTML = '<div style="text-align: center; width: 100%; color: #6c757d; padding: 20px;">No hay datos para mostrar</div>';
            return;
        }
        
        const maxValor = Math.max(...dias.map(d => d.porcentaje || 0), 1);
        const alturaMaxima = 180;
        
        dias.forEach(dia => {
            const div = document.createElement('div');
            div.className = 'barra-container';
            
            const porcentaje = dia.porcentaje || 0;
            const altura = maxValor > 0 ? Math.max((porcentaje / maxValor) * alturaMaxima, 2) : 2;
            const color = porcentaje > 0 ? '#083CAE' : '#6c757d';
            const esDiaLaboral = dia.total > 0;
            
            div.innerHTML = `
                <div style="height: ${altura}px; width: 100%; background-color: ${color}; border-radius: 4px 4px 0 0; min-height: 2px; transition: height 0.5s ease;" 
                     title="${dia.fecha}: ${porcentaje}% (${dia.presentes || 0} de ${dia.total || 0} presentes)"></div>
                <div style="font-size: 8px; color: #6c757d; margin-top: 4px; text-align: center;">${dia.fecha}</div>
                ${!esDiaLaboral ? '<div style="font-size: 6px; color: #6c757d;">Descanso</div>' : ''}
            `;
            container.appendChild(div);
        });
    }

    function renderizarResumenProyectos(proyectos) {
        const tbody = document.getElementById('resumenProyectos');
        tbody.innerHTML = '';
        
        const entries = Object.entries(proyectos);
        if (entries.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #6c757d;">No hay datos disponibles</td>
                </tr>
            `;
            return;
        }
        
        let totalRegistros = 0, totalHoras = 0, totalPresentes = 0, totalAusentes = 0, totalRetardos = 0;
        
        entries.forEach(([proyectoId, data]) => {
            const row = document.createElement('tr');
            const nombre = data.nombre || `Proyecto ${proyectoId}`;
            
            totalRegistros += data.total_asistencias || 0;
            totalHoras += data.total_horas || 0;
            totalPresentes += data.presentes || 0;
            totalAusentes += data.ausentes || 0;
            totalRetardos += data.retardos || 0;
            
            const porcentaje = data.porcentaje_asistencia || 0;
            const color = porcentaje >= 90 ? '#28a745' : porcentaje >= 70 ? '#ffc107' : '#dc3545';
            
            row.innerHTML = `
                <td style="padding: 12px;">${nombre}</td>
                <td style="padding: 12px; text-align: right;">${data.total_asistencias || 0}</td>
                <td style="padding: 12px; text-align: right;">${data.total_horas ? data.total_horas.toFixed(1) : 0}</td>
                <td style="padding: 12px; text-align: right; color: #28a745;">${data.presentes || 0}</td>
                <td style="padding: 12px; text-align: right; color: #dc3545;">${data.ausentes || 0}</td>
                <td style="padding: 12px; text-align: right; color: #ffc107;">${data.retardos || 0}</td>
                <td style="padding: 12px; text-align: right; font-weight: bold; color: ${color};">${porcentaje}%</td>
            `;
            tbody.appendChild(row);
        });
        
        const totalRow = document.createElement('tr');
        totalRow.style.fontWeight = 'bold';
        totalRow.style.backgroundColor = '#e9ecef';
        totalRow.innerHTML = `
            <td style="padding: 12px;">TOTAL</td>
            <td style="padding: 12px; text-align: right;">${totalRegistros}</td>
            <td style="padding: 12px; text-align: right;">${totalHoras.toFixed(1)}</td>
            <td style="padding: 12px; text-align: right; color: #28a745;">${totalPresentes}</td>
            <td style="padding: 12px; text-align: right; color: #dc3545;">${totalAusentes}</td>
            <td style="padding: 12px; text-align: right; color: #ffc107;">${totalRetardos}</td>
            <td style="padding: 12px; text-align: right;">${totalRegistros > 0 ? Math.round((totalPresentes / totalRegistros) * 100) : 0}%</td>
        `;
        tbody.appendChild(totalRow);
    }

    // ============================================
    // ESTADÍSTICAS Y PAGINACIÓN
    // ============================================

    function actualizarEstadisticas(stats) {
        if (!stats) return;
        document.getElementById('totalPersonal').textContent = stats.total_personal || 0;
        document.getElementById('totalPresente').textContent = stats.presentes || 0;
        document.getElementById('totalAusente').textContent = stats.ausentes || 0;
        document.getElementById('porcentajeAsistencia').textContent = (stats.porcentaje || 0) + '%';
    }

    function actualizarPaginacion(pagination) {
        if (!pagination) return;
        document.getElementById('paginaActual').textContent = pagination.current_page || 1;
        document.getElementById('totalPaginas').textContent = `de ${pagination.last_page || 1}`;
        document.getElementById('paginacionInfo').textContent = 
            `Mostrando ${pagination.from || 0}-${pagination.to || 0} de ${pagination.total || 0} registros`;
    }

    // ============================================
    // FUNCIONES AUXILIARES
    // ============================================

    function getStatusBadge(status) {
        const badges = {
            'Activo': 'badge-Activo',
            'Falta': 'badge-Falta',
            'Retardo': 'badge-Retardo',
            'Justificado': 'badge-Justificado',
            'Pendiente': 'badge-Pendiente'
        };
        return badges[status] || 'badge-status';
    }

    function getEspecialidadBadge(especialidad) {
        const badges = {
            'cimentacion': 'badge-cimentacion',
            'estructura': 'badge-estructura',
            'acabados': 'badge-acabados',
            'instalaciones': 'badge-instalaciones',
            'obra_negra': 'badge-obra_negra',
            'albanileria': 'badge-albanileria',
            'herreria': 'badge-herreria',
            'electricidad': 'badge-electricidad',
            'plomeria': 'badge-plomeria',
            'pintura': 'badge-pintura'
        };
        return badges[especialidad] || 'badge-especialidad';
    }

    function formatDate(dateString) {
        if (!dateString) return '-';
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX');
        } catch {
            return '-';
        }
    }

    function mostrarLoading(show) {
        document.getElementById('loadingSpinner').style.display = show ? 'flex' : 'none';
    }

    function mostrarNotificacion(mensaje, tipo = 'success') {
        const notificacion = document.createElement('div');
        notificacion.className = `toast-notification ${tipo}`;
        const icono = tipo === 'success' ? 'fa-check-circle' : tipo === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
        notificacion.innerHTML = `<i class="fas ${icono}"></i> ${mensaje}`;
        document.body.appendChild(notificacion);
        setTimeout(() => notificacion.remove(), 3000);
    }

    // ============================================
    // ASIGNACIÓN DE EMPLEADOS A CUADRILLAS
    // ============================================

    async function cargarEmpleadosParaAsignar() {
        try {
            const response = await fetch('/api/empleados-disponibles', {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                const select = document.getElementById('selectEmpleadoAsignar');
                const empleadosAsignados = Object.keys(asignacionesActuales);
                
                select.innerHTML = '<option value="">Seleccionar empleado...</option>';
                result.data.forEach(emp => {
                    if (!empleadosAsignados.includes(String(emp.id))) {
                        select.innerHTML += `<option value="${emp.id}">${emp.nombre_completo}</option>`;
                    }
                });
            }
        } catch (error) {
            console.error('Error cargando empleados:', error);
        }
    }

    async function cargarAsignacionesActuales() {
        try {
            const response = await fetch(`${API_BASE}/cuadrillas/asignaciones`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                asignacionesActuales = result.data;
                renderizarTablaAsignaciones();
            }
        } catch (error) {
            console.error('Error cargando asignaciones:', error);
        }
    }

    function renderizarTablaAsignaciones() {
        const tbody = document.getElementById('tablaAsignaciones');
        tbody.innerHTML = '';
        
        const entries = Object.entries(asignacionesActuales);
        if (entries.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="3" style="text-align: center; padding: 20px; color: #6c757d;">
                        No hay empleados asignados a cuadrillas
                    </td>
                </tr>
            `;
            return;
        }
        
        entries.forEach(([empleadoId, cuadrilla]) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">${cuadrilla.empleado_nombre}</td>
                <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">${cuadrilla.cuadrilla_nombre}</td>
                <td style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">
                    <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer;" onclick="removerAsignacion(${empleadoId})"></i>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    async function removerAsignacion(empleadoId) {
        if (!confirm('¿Está seguro de remover esta asignación?')) return;
        
        try {
            const response = await fetch(`${API_BASE}/cuadrillas/asignaciones/${empleadoId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarAsignacionesActuales();
                cargarEmpleadosParaAsignar();
            } else {
                mostrarNotificacion(result.message || 'Error al remover', 'error');
            }
        } catch (error) {
            mostrarNotificacion('Error al remover la asignación', 'error');
        }
    }

    async function guardarAsignacion() {
        const empleadoId = document.getElementById('selectEmpleadoAsignar').value;
        const cuadrillaId = document.getElementById('selectCuadrillaAsignar').value;
        const observaciones = document.getElementById('asignarObservaciones').value;
        
        if (!empleadoId || !cuadrillaId) {
            mostrarNotificacion('Debe seleccionar un empleado y una cuadrilla', 'warning');
            return;
        }
        
        try {
            const response = await fetch(`${API_BASE}/cuadrillas/asignar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    empleado_id: empleadoId,
                    cuadrilla_id: cuadrillaId,
                    observaciones: observaciones
                })
            });
            const result = await response.json();
            
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                document.getElementById('asignarObservaciones').value = '';
                cargarAsignacionesActuales();
                cargarEmpleadosParaAsignar();
            } else {
                mostrarNotificacion(result.message || 'Error al asignar', 'error');
            }
        } catch (error) {
            mostrarNotificacion('Error al asignar empleado', 'error');
        }
    }

    function abrirModalAsignar() {
        document.getElementById('modalAsignarEmpleados').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        cargarEmpleadosParaAsignar();
        cargarAsignacionesActuales();
    }

    function cerrarModalAsignar() {
        document.getElementById('modalAsignarEmpleados').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // ============================================
    // ACCIONES
    // ============================================

    window.verDetalleAsistencia = async function(id) {
        try {
            const response = await fetch(`${API_BASE}/asistencias/${id}`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                const item = result.data;
                const statusBadge = getStatusBadge(item.estatus);
                
                const contenido = `
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Empleado</div>
                            <div style="font-size: 16px; font-weight: 600;">${item.nombre_completo}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Folio</div>
                            <div style="font-size: 16px;">${item.folio || '-'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Cuadrilla</div>
                            <div style="font-size: 16px;">${item.cuadrilla?.nombre || '-'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Fecha</div>
                            <div style="font-size: 16px;">${formatDate(item.fecha)}</div>
                        </div>
                    </div>
                    <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                            <div>
                                <div style="color: #6c757d; font-size: 11px;">Hora Entrada</div>
                                <div style="font-size: 18px; font-weight: 700;">${item.hora_entrada || '--:--'}</div>
                            </div>
                            <div>
                                <div style="color: #6c757d; font-size: 11px;">Hora Salida</div>
                                <div style="font-size: 18px; font-weight: 700;">${item.hora_salida || '--:--'}</div>
                            </div>
                            <div>
                                <div style="color: #6c757d; font-size: 11px;">Horas Trabajadas</div>
                                <div style="font-size: 18px; font-weight: 700;">${(item.horas_trabajadas || 0).toFixed(1)} hrs</div>
                            </div>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Status</div>
                            <div style="font-size: 16px;"><span class="badge ${statusBadge}">${item.estatus_nombre}</span></div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Registrado por</div>
                            <div style="font-size: 16px;">${item.registrador?.name || 'Sistema'}</div>
                        </div>
                    </div>
                    ${item.observaciones ? `
                    <div style="margin-bottom: 15px;">
                        <div style="color: #6c757d; font-size: 12px;">Observaciones</div>
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; font-size: 14px;">${item.observaciones}</div>
                    </div>` : ''}
                    <div style="border-top: 1px solid #dee2e6; padding-top: 15px; margin-top: 15px; display: flex; justify-content: flex-end; gap: 10px;">
                        <button onclick="cerrarModalDetalle()" style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cerrar</button>
                    </div>
                `;
                
                document.getElementById('modalContenidoDetalle').innerHTML = contenido;
                document.getElementById('modalVerDetalle').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        } catch (error) {
            mostrarNotificacion('Error al cargar el detalle', 'error');
        }
    };

    window.editarAsistencia = function(id) {
        mostrarNotificacion('Funcionalidad de edición en desarrollo', 'warning');
    };

    window.verDetalleCuadrilla = function(id) {
        mostrarNotificacion('Funcionalidad en desarrollo', 'warning');
    };

    window.editarCuadrilla = async function(id) {
        try {
            const response = await fetch(`${API_BASE}/cuadrillas/${id}`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                const item = result.data;
                editCuadrillaId = id;
                
                document.getElementById('modalCuadrillaTitulo').innerHTML = `<i class="fas fa-edit"></i> Editar Cuadrilla`;
                document.getElementById('btnCuadrillaTexto').textContent = 'Actualizar Cuadrilla';
                
                document.getElementById('editCuadrillaId').value = id;
                document.getElementById('campoCodigo').value = item.codigo || '';
                document.getElementById('campoNombre').value = item.nombre || '';
                document.getElementById('campoEspecialidad').value = item.especialidad || '';
                document.getElementById('campoProyecto').value = item.proyecto_id || '';
                document.getElementById('campoEncargado').value = item.encargado_id || '';
                document.getElementById('campoEstatus').value = item.estatus || 'activo';
                document.getElementById('campoDescripcion').value = item.descripcion || '';
                document.getElementById('campoObservacionesCuadrilla').value = item.observaciones || '';
                
                // Seleccionar integrantes
                const selectIntegrantes = document.getElementById('campoIntegrantes');
                const integrantes = item.integrantes || [];
                for (let option of selectIntegrantes.options) {
                    option.selected = integrantes.includes(parseInt(option.value));
                }
                
                document.getElementById('modalCuadrilla').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        } catch (error) {
            mostrarNotificacion('Error al cargar la cuadrilla', 'error');
        }
    };

    window.eliminarCuadrilla = function(id) {
        if (!confirm('¿Está seguro de eliminar esta cuadrilla?')) return;
        
        fetch(`${API_BASE}/cuadrillas/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarCuadrillas();
            } else {
                mostrarNotificacion(result.message || 'Error al eliminar', 'error');
            }
        })
        .catch(error => {
            mostrarNotificacion('Error al eliminar la cuadrilla', 'error');
        });
    };

    function cerrarModalDetalle() {
        document.getElementById('modalVerDetalle').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    async function exportarExcel() {
        try {
            const params = new URLSearchParams();
            params.append('fecha', currentFilters.fecha || '');
            
            const response = await fetch(`${API_BASE}/asistencias/exportar?${params.toString()}`);
            const result = await response.json();
            
            if (result.success && result.data) {
                const headers = result.data.headers || [];
                const rows = result.data.rows || [];
                
                if (headers.length === 0 || rows.length === 0) {
                    mostrarNotificacion('No hay datos para exportar', 'warning');
                    return;
                }
                
                const csvContent = [headers.join(','), ...rows.map(row => row.join(','))].join('\n');
                const blob = new Blob(['\uFEFF' + csvContent], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `Asistencia_${new Date().toISOString().split('T')[0]}.csv`;
                link.click();
                URL.revokeObjectURL(link.href);
                mostrarNotificacion('Exportación completada', 'success');
            }
        } catch (error) {
            mostrarNotificacion('Error al exportar', 'error');
        }
    }

    // ============================================
    // MODAL - TOMAR ASISTENCIA
    // ============================================

    async function cargarPersonalPorCuadrilla(cuadrillaId) {
        if (!cuadrillaId) {
            document.getElementById('modalTablaPersonal').innerHTML = `
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px; color: #6c757d;">
                        Seleccione una cuadrilla para cargar el personal
                    </td>
                </tr>
            `;
            return;
        }
        
        try {
            const asignacionesResponse = await fetch(`${API_BASE}/cuadrillas/asignaciones`, {
                headers: { 'Accept': 'application/json' }
            });
            const asignacionesResult = await asignacionesResponse.json();
            
            if (asignacionesResult.success) {
                const asignaciones = asignacionesResult.data;
                const integrantes = Object.values(asignaciones).filter(a => a.cuadrilla_id == cuadrillaId);
                
                const tbody = document.getElementById('modalTablaPersonal');
                tbody.innerHTML = '';
                
                if (integrantes.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: #6c757d;">
                                Esta cuadrilla no tiene integrantes asignados
                                <br>
                                <small>Asigne empleados desde el botón "Asignar Empleados"</small>
                            </td>
                        </tr>
                    `;
                    return;
                }
                
                integrantes.forEach(emp => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">${emp.empleado_id}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">${emp.empleado_nombre}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">
                            <input type="time" class="hora-entrada" value="07:00" style="padding: 5px; border: 1px solid #ced4da; border-radius: 4px; width: 100px;">
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">
                            <select class="status-select" style="padding: 5px; border: 1px solid #ced4da; border-radius: 4px; width: 110px;">
                                <option value="Activo">✅ Presente</option>
                                <option value="Retardo">⏰ Retardo</option>
                                <option value="Falta">❌ Ausente</option>
                                <option value="Justificado">📋 Justificado</option>
                                <option value="Pendiente">⏳ Pendiente</option>
                            </select>
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #dee2e6; text-align: center;">
                            <input type="checkbox" class="seleccionar-personal" checked>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }
        } catch (error) {
            console.error('Error al cargar personal:', error);
            mostrarNotificacion('Error al cargar el personal de la cuadrilla', 'error');
        }
    }

    function abrirModalAsistencia() {
        document.getElementById('modalTomarAsistencia').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        const hoy = new Date();
        document.getElementById('modalFechaAsistencia').value = hoy.toISOString().split('T')[0];
        
        const selectCuadrilla = document.getElementById('modalCuadrillaAsistencia');
        if (selectCuadrilla.value) {
            cargarPersonalPorCuadrilla(selectCuadrilla.value);
        } else if (selectCuadrilla.options.length > 1) {
            selectCuadrilla.selectedIndex = 1;
            cargarPersonalPorCuadrilla(selectCuadrilla.value);
        }
    }

    function cerrarModalAsistencia() {
        document.getElementById('modalTomarAsistencia').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // ============================================
    // MODAL - CUADRILLA
    // ============================================

    function abrirModalCuadrilla() {
        editCuadrillaId = null;
        document.getElementById('modalCuadrillaTitulo').innerHTML = `<i class="fas fa-users"></i> Nueva Cuadrilla`;
        document.getElementById('btnCuadrillaTexto').textContent = 'Guardar Cuadrilla';
        document.getElementById('formCuadrilla').reset();
        document.getElementById('editCuadrillaId').value = '';
        
        const selectIntegrantes = document.getElementById('campoIntegrantes');
        for (let option of selectIntegrantes.options) {
            option.selected = false;
        }
        
        document.getElementById('modalCuadrilla').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function cerrarModalCuadrilla() {
        document.getElementById('modalCuadrilla').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // ============================================
    // EVENTOS E INICIALIZACIÓN
    // ============================================

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado - API_BASE:', API_BASE);
        
        const hoy = new Date();
        document.getElementById('fechaAsistencia').value = hoy.toISOString().split('T')[0];
        currentFilters.fecha = document.getElementById('fechaAsistencia').value;
        
        // Eventos de botones
        document.getElementById('btnAsignarEmpleados')?.addEventListener('click', abrirModalAsignar);
        document.getElementById('btnCerrarAsignar')?.addEventListener('click', cerrarModalAsignar);
        document.getElementById('btnCancelarAsignar')?.addEventListener('click', cerrarModalAsignar);
        document.getElementById('btnGuardarAsignacion')?.addEventListener('click', guardarAsignacion);
        
        cargarCatalogos();
        cargarAsistencias();
        cargarCuadrillas();
        cargarReporteMensual();
        cargarAsignacionesActuales();
        
        // Eventos del dropdown de proyectos
        document.getElementById('btnFiltroProyectos')?.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleDropdown();
        });
        
        document.getElementById('btnCerrarFiltro')?.addEventListener('click', function(e) {
            e.stopPropagation();
            cerrarDropdown();
        });
        
        document.getElementById('btnSeleccionarTodos')?.addEventListener('click', function(e) {
            e.stopPropagation();
            seleccionarTodosProyectos();
        });
        
        document.getElementById('btnDeseleccionarTodos')?.addEventListener('click', function(e) {
            e.stopPropagation();
            deseleccionarTodosProyectos();
        });
        
        document.getElementById('filtroProyectosBuscar')?.addEventListener('input', function(e) {
            e.stopPropagation();
            filtrarProyectosLista(this.value);
        });
        
        document.getElementById('filtroProyectosLista')?.addEventListener('change', function(e) {
            if (e.target.type === 'checkbox') {
                actualizarLabelProyectos();
                aplicarFiltroProyectos();
            }
        });
        
        document.addEventListener('click', function(e) {
            const container = document.getElementById('proyectoFilterContainer');
            if (container && !container.contains(e.target)) {
                cerrarDropdown();
            }
        });
        
        // Pestañas
        document.querySelectorAll('.asistencia-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.asistencia-tab').forEach(t => {
                    t.classList.remove('active');
                    t.style.backgroundColor = '#e9ecef';
                    t.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                currentTab = this.dataset.tab;
                
                document.querySelectorAll('.asistencia-content').forEach(content => {
                    content.style.display = 'none';
                });
                
                const target = document.getElementById(`tab-${currentTab}`);
                if (target) {
                    target.style.display = 'block';
                }
                
                if (currentTab === 'cuadrillas') {
                    cargarCuadrillas();
                } else if (currentTab === 'resumen') {
                    cargarReporteMensual();
                } else {
                    cargarAsistencias();
                }
            });
        });
        
        // Filtros de asistencia
        document.getElementById('fechaAsistencia')?.addEventListener('change', function() {
            currentFilters.fecha = this.value;
            currentFilters.page = 1;
            cargarAsistencias();
        });
        
        document.getElementById('selectorCuadrilla')?.addEventListener('change', function() {
            currentFilters.cuadrilla_id = this.value;
            currentFilters.page = 1;
            cargarAsistencias();
        });
        
        document.getElementById('selectorEstatus')?.addEventListener('change', function() {
            currentFilters.estatus = this.value;
            currentFilters.page = 1;
            cargarAsistencias();
        });
        
        document.getElementById('buscador')?.addEventListener('input', function() {
            currentFilters.busqueda = this.value;
            currentFilters.page = 1;
            cargarAsistencias();
        });
        
        // Botones principales
        document.getElementById('btnTomarAsistencia')?.addEventListener('click', abrirModalAsistencia);
        document.getElementById('btnAgregarCuadrilla')?.addEventListener('click', abrirModalCuadrilla);
        document.getElementById('btnExcel')?.addEventListener('click', exportarExcel);
        document.getElementById('btnGenerarReporte')?.addEventListener('click', cargarReporteMensual);
        
        // Paginación
        document.getElementById('btnPrimera')?.addEventListener('click', () => {
            if (currentPage > 1) { currentFilters.page = 1; cargarAsistencias(); }
        });
        document.getElementById('btnAnterior')?.addEventListener('click', () => {
            if (currentPage > 1) { currentFilters.page = currentPage - 1; cargarAsistencias(); }
        });
        document.getElementById('btnSiguiente')?.addEventListener('click', () => {
            if (currentPage < totalPages) { currentFilters.page = currentPage + 1; cargarAsistencias(); }
        });
        document.getElementById('btnUltima')?.addEventListener('click', () => {
            if (currentPage < totalPages) { currentFilters.page = totalPages; cargarAsistencias(); }
        });
        
        // Modal Asistencia
        document.getElementById('btnCerrarModalAsistencia')?.addEventListener('click', cerrarModalAsistencia);
        document.getElementById('btnCancelarAsistencia')?.addEventListener('click', cerrarModalAsistencia);
        
        document.getElementById('modalCuadrillaAsistencia')?.addEventListener('change', function() {
            cargarPersonalPorCuadrilla(this.value);
        });
        
        document.getElementById('btnMarcarTodosPresente')?.addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.seleccionar-personal');
            const horaInputs = document.querySelectorAll('.hora-entrada');
            const statusSelects = document.querySelectorAll('.status-select');
            
            checkboxes.forEach(cb => cb.checked = true);
            horaInputs.forEach(input => input.value = '07:00');
            statusSelects.forEach(select => select.value = 'Activo');
        });
        
        document.getElementById('btnGuardarAsistencia')?.addEventListener('click', async function() {
            const filas = document.querySelectorAll('#modalTablaPersonal tr');
            const empleados = [];
            
            filas.forEach(fila => {
                const checkbox = fila.querySelector('.seleccionar-personal');
                if (checkbox && checkbox.checked) {
                    const celdas = fila.querySelectorAll('td');
                    const hora = fila.querySelector('.hora-entrada')?.value || '07:00';
                    const status = fila.querySelector('.status-select')?.value || 'Activo';
                    
                    empleados.push({
                        id: celdas[0]?.textContent || '',
                        hora_entrada: hora,
                        status: status
                    });
                }
            });
            
            if (empleados.length === 0) {
                mostrarNotificacion('No hay empleados seleccionados', 'warning');
                return;
            }
            
            const data = {
                fecha: document.getElementById('modalFechaAsistencia').value,
                cuadrilla_id: document.getElementById('modalCuadrillaAsistencia').value,
                empleados: empleados
            };
            
            try {
                const response = await fetch(`${API_BASE}/asistencias/tomar`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                const result = await response.json();
                
                if (result.success) {
                    mostrarNotificacion(result.message, 'success');
                    cerrarModalAsistencia();
                    cargarAsistencias();
                } else {
                    mostrarNotificacion(result.message || 'Error al guardar', 'error');
                }
            } catch (error) {
                mostrarNotificacion('Error al guardar la asistencia', 'error');
            }
        });
        
        // Modal Cuadrilla
        document.getElementById('btnCerrarModalCuadrilla')?.addEventListener('click', cerrarModalCuadrilla);
        document.getElementById('btnCancelarCuadrilla')?.addEventListener('click', cerrarModalCuadrilla);
        
        document.getElementById('formCuadrilla')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const id = document.getElementById('editCuadrillaId').value;
            const formData = new FormData(this);
            const integrantesSelect = document.getElementById('campoIntegrantes');
            const integrantes = [];
            for (let option of integrantesSelect.options) {
                if (option.selected) {
                    integrantes.push(parseInt(option.value));
                }
            }
            formData.append('integrantes', JSON.stringify(integrantes));
            
            const url = id ? `${API_BASE}/cuadrillas/${id}` : API_BASE + '/cuadrillas';
            const method = id ? 'PUT' : 'POST';
            
            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                });
                const result = await response.json();
                
                if (result.success) {
                    mostrarNotificacion(result.message, 'success');
                    cerrarModalCuadrilla();
                    cargarCuadrillas();
                } else {
                    mostrarNotificacion(result.message || 'Error al guardar', 'error');
                }
            } catch (error) {
                mostrarNotificacion('Error al guardar la cuadrilla', 'error');
            }
        });
        
        // Cerrar modales al hacer clic fuera
        window.addEventListener('click', function(e) {
            const modalAsistencia = document.getElementById('modalTomarAsistencia');
            const modalCuadrilla = document.getElementById('modalCuadrilla');
            const modalAsignar = document.getElementById('modalAsignarEmpleados');
            const modalDetalle = document.getElementById('modalVerDetalle');
            
            if (e.target === modalAsistencia) cerrarModalAsistencia();
            if (e.target === modalCuadrilla) cerrarModalCuadrilla();
            if (e.target === modalAsignar) cerrarModalAsignar();
            if (e.target === modalDetalle) cerrarModalDetalle();
        });
    });
</script>
@endsection