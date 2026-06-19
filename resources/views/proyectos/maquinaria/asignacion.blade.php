@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Maquinaria y Equipo -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Maquinaria y Equipo
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE MAQUINARIA -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Equipos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalEquipos">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">En Operación</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalOperacion">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Mantenimiento</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalMantenimiento">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Disponibles</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalDisponibles">0</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
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

                        <select id="selectorTipo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                            <option value="">Todos los tipos</option>
                            <option value="maquinaria">🚜 Maquinaria</option>
                            <option value="vehiculo">🚗 Vehículos</option>
                            <option value="herramienta">🔧 Herramientas</option>
                            <option value="equipo">📦 Equipos</option>
                        </select>

                        <select id="selectorStatus" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                            <option value="">Todos los estados</option>
                            <option value="activo">✅ Activo</option>
                            <option value="mantenimiento">🔧 Mantenimiento</option>
                            <option value="inactivo">❌ Inactivo</option>
                            <option value="baja">📦 Baja</option>
                        </select>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <button id="btnAsignarEquipo" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Asignar Equipo a Proyecto">
                                <i class="fas fa-tasks"></i> Asignar Equipo
                            </button>
                        </div>
                        <div>
                            <button id="btnRegistrarMantenimiento" style="background-color: white; border: 1px solid #ffc107; color: #ffc107; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Registrar Mantenimiento">
                                <i class="fas fa-tools"></i> Mantenimiento
                            </button>
                        </div>
                        <div>
                            <button id="btnAgregarEquipo" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #083CAE; font-size: 16px;" title="Agregar Equipo">
                                <i class="fas fa-plus" style="color: #083CAE;"></i>
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
                <div style="display: flex; gap: 2px; margin-bottom: 20px; border-bottom: 2px solid #083CAE;">
                    <button class="maquinaria-tab active" data-tab="inventario" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-warehouse"></i> Inventario
                    </button>
                    <button class="maquinaria-tab" data-tab="asignacion" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-tasks"></i> Asignación de Equipo
                    </button>
                    <button class="maquinaria-tab" data-tab="mantenimiento" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-tools"></i> Mantenimiento
                    </button>
                    <button class="maquinaria-tab" data-tab="combustible" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-gas-pump"></i> Combustible
                    </button>
                </div>

                <!-- Loading -->
                <div id="loadingSpinner" style="text-align: center; padding: 40px; display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
                    <p style="margin-top: 10px; color: #6c757d;">Cargando equipos...</p>
                </div>

                <!-- Mensaje "Sin datos" -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-tractor" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin equipos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay equipos registrados</p>
                </div>

                <!-- SECCIÓN 1: INVENTARIO -->
                <div id="tab-inventario" class="maquinaria-content active">
                    <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                        <table class="table table-bordered" id="tablaInventario" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                            <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                                <tr>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Código</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Nombre</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Tipo</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Marca/Modelo</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Año</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Horómetro</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Proyecto</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Estado</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodyInventario">
                                <!-- Las filas se insertarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                    
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

                <!-- SECCIÓN 2: ASIGNACIÓN DE EQUIPO -->
                <div id="tab-asignacion" class="maquinaria-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;" id="resumenAsignaciones">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 40px; height: 40px; background-color: #e8f0fe; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-check-circle" style="color: #083CAE;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Equipos Asignados</div>
                                    <div style="font-size: 24px; font-weight: bold; color: #083CAE;" id="totalAsignados">0</div>
                                </div>
                            </div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 40px; height: 40px; background-color: #d4edda; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-clock" style="color: #28a745;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Horas Operación</div>
                                    <div style="font-size: 24px; font-weight: bold; color: #28a745;" id="totalHorasOperacion">0</div>
                                </div>
                            </div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 40px; height: 40px; background-color: #fff3cd; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-calendar-check" style="color: #ffc107;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Asignaciones del mes</div>
                                    <div style="font-size: 24px; font-weight: bold; color: #ffc107;" id="totalAsignacionesMes">0</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; margin-bottom: 20px;">
                        <div style="background-color: #f8f9fa; padding: 12px 15px; border-bottom: 2px solid #083CAE; display: flex; justify-content: space-between; align-items: center;">
                            <h5 style="margin: 0; color: #083CAE; font-size: 15px;"><i class="fas fa-tasks"></i> Asignaciones Activas</h5>
                            <button id="btnNuevaAsignacion" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 6px 12px; cursor: pointer; font-size: 13px;">
                                <i class="fas fa-plus"></i> Nueva Asignación
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="padding: 12px;">Equipo</th>
                                        <th style="padding: 12px;">Tipo</th>
                                        <th style="padding: 12px;">Proyecto</th>
                                        <th style="padding: 12px;">Responsable</th>
                                        <th style="padding: 12px; text-align: center;">Fecha Asignación</th>
                                        <th style="padding: 12px; text-align: center;">Fecha Estimada</th>
                                        <th style="padding: 12px; text-align: right;">Horas</th>
                                        <th style="padding: 12px; text-align: center;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaAsignaciones">
                                    <!-- Las filas se insertarán dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 3: MANTENIMIENTO -->
                <div id="tab-mantenimiento" class="maquinaria-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 40px; height: 40px; background-color: #f8d7da; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-wrench" style="color: #dc3545;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">En Mantenimiento</div>
                                    <div style="font-size: 24px; font-weight: bold; color: #dc3545;" id="totalMantEnProceso">0</div>
                                </div>
                            </div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 40px; height: 40px; background-color: #fff3cd; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-calendar-check" style="color: #ffc107;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Próximos 7 días</div>
                                    <div style="font-size: 24px; font-weight: bold; color: #ffc107;" id="totalMantProximos">0</div>
                                </div>
                            </div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 40px; height: 40px; background-color: #d4edda; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-check-circle" style="color: #28a745;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Completados</div>
                                    <div style="font-size: 24px; font-weight: bold; color: #28a745;" id="totalMantCompletados">0</div>
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
                                    <th style="padding: 12px;">Tipo Mant.</th>
                                    <th style="padding: 12px;">Fecha Inicio</th>
                                    <th style="padding: 12px;">Fecha Fin</th>
                                    <th style="padding: 12px;">Responsable</th>
                                    <th style="padding: 12px;">Status</th>
                                    <th style="padding: 12px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaMantenimientos">
                                <!-- Las filas se insertarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 4: COMBUSTIBLE -->
                <div id="tab-combustible" class="maquinaria-content" style="display: none;">
                    <!-- Filtros y botón de combustible -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                            <select id="selectorCombustibleEquipo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 200px;">
                                <option value="">Todos los equipos</option>
                            </select>
                            <input type="date" id="fechaCombustibleInicio" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <span style="color: #6c757d;">a</span>
                            <input type="date" id="fechaCombustibleFin" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <button id="btnFiltrarCombustible" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px;">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                        </div>
                        <div>
                            <button id="btnRegistrarCarga" style="background-color: #28a745; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Registrar Carga de Combustible">
                                <i class="fas fa-plus-circle"></i> Registrar Carga
                            </button>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 40px; height: 40px; background-color: #e8f0fe; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-gas-pump" style="color: #083CAE;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Consumo Mensual</div>
                                    <div style="font-size: 24px; font-weight: bold; color: #083CAE;" id="totalConsumoMensual">0 L</div>
                                </div>
                            </div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 40px; height: 40px; background-color: #fff3cd; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-dollar-sign" style="color: #ffc107;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Costo Mensual</div>
                                    <div style="font-size: 24px; font-weight: bold; color: #ffc107;" id="totalCostoMensual">$0</div>
                                </div>
                            </div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 40px; height: 40px; background-color: #d4edda; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-chart-line" style="color: #28a745;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Rendimiento Prom.</div>
                                    <div style="font-size: 24px; font-weight: bold; color: #28a745;" id="totalRendimientoProm">0 L/carga</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Equipo</th>
                                    <th style="padding: 12px;">Proyecto</th>
                                    <th style="padding: 12px;">Fecha</th>
                                    <th style="padding: 12px; text-align: right;">Litros</th>
                                    <th style="padding: 12px; text-align: right;">Costo</th>
                                    <th style="padding: 12px;">Horómetro</th>
                                    <th style="padding: 12px;">Operador</th>
                                    <th style="padding: 12px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaCombustible">
                                <!-- Las filas se insertarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Asignar Equipo -->
<div id="modalAsignarEquipo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-tasks"></i> Asignar Equipo a Proyecto</h3>
            <button id="btnCerrarModalAsignacion" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <form id="formAsignarEquipo">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Equipo <span style="color: #dc3545;">*</span></label>
                    <select id="modalEquipo" name="activo_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        <option value="">Seleccionar equipo...</option>
                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Proyecto <span style="color: #dc3545;">*</span></label>
                    <select id="modalProyecto" name="proyecto_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        <option value="">Seleccionar proyecto...</option>
                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Responsable</label>
                    <select id="modalResponsable" name="responsable_asignado_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        <option value="">Seleccionar responsable...</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Fecha Inicio <span style="color: #dc3545;">*</span></label>
                        <input type="date" id="modalFechaInicio" name="fecha_salida" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Fecha Estimada Fin</label>
                        <input type="date" id="modalFechaFin" name="fecha_estimada_devolucion" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Horómetro Salida</label>
                        <input type="number" id="modalHorometro" name="horometro_salida" step="0.1" min="0" placeholder="0.0" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Condición Salida</label>
                        <select id="modalCondicion" name="condicion_salida" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="excelente">Excelente</option>
                            <option value="bueno" selected>Bueno</option>
                            <option value="regular">Regular</option>
                            <option value="malo">Malo</option>
                            <option value="danado">Dañado</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Observaciones</label>
                    <textarea id="modalObservacionesAsignacion" name="observaciones" rows="2" placeholder="Notas adicionales sobre la asignación..." style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #dee2e6; padding-top: 20px;">
                    <button type="button" id="btnCancelarAsignacion" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Cancelar</button>
                    <button type="submit" style="padding: 8px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-save"></i> Asignar Equipo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Agregar/Editar Equipo -->
<div id="modalEquipo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 700px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-plus-circle"></i> Nuevo Equipo</h3>
            <button id="btnCerrarModalEquipo" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <form id="formEquipo">
                <input type="hidden" id="editEquipoId">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Nombre <span style="color: #dc3545;">*</span></label>
                        <input type="text" id="campoNombre" name="nombre" required placeholder="Nombre del equipo" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Tipo <span style="color: #dc3545;">*</span></label>
                        <select id="campoTipo" name="tipo_activo" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar...</option>
                            <option value="maquinaria">🚜 Maquinaria</option>
                            <option value="vehiculo">🚗 Vehículo</option>
                            <option value="herramienta">🔧 Herramienta</option>
                            <option value="equipo">📦 Equipo</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Marca</label>
                        <input type="text" id="campoMarca" name="marca" placeholder="Marca" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Modelo</label>
                        <input type="text" id="campoModelo" name="modelo" placeholder="Modelo" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Año</label>
                        <input type="number" id="campoAnio" name="anio" placeholder="2024" min="1900" max="2026" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Serie</label>
                        <input type="text" id="campoSerie" name="serie" placeholder="Número de serie" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Costo Adquisición</label>
                        <input type="number" id="campoCosto" name="costo_adquisicion" step="0.01" min="0" placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Costo Operación/hora</label>
                        <input type="number" id="campoCostoOperacion" name="costo_operacion_hora" step="0.01" min="0" placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Descripción</label>
                    <textarea id="campoDescripcion" name="descripcion" rows="2" placeholder="Descripción del equipo" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #dee2e6; padding-top: 20px;">
                    <button type="button" id="btnCancelarEquipo" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Cancelar</button>
                    <button type="submit" style="padding: 8px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-save"></i> Guardar Equipo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Registrar Mantenimiento -->
<div id="modalMantenimiento" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-tools"></i> Registrar Mantenimiento</h3>
            <button id="btnCerrarModalMantenimiento" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <form id="formMantenimiento">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Equipo <span style="color: #dc3545;">*</span></label>
                        <select id="modalMantEquipo" name="activo_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar equipo...</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Tipo Mantenimiento <span style="color: #dc3545;">*</span></label>
                        <select id="modalMantTipo" name="tipo_mantenimiento" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="preventivo">Preventivo</option>
                            <option value="correctivo">Correctivo</option>
                            <option value="predictivo">Predictivo</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Descripción <span style="color: #dc3545;">*</span></label>
                    <textarea id="modalMantDescripcion" name="descripcion" rows="2" placeholder="Descripción del trabajo realizado" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Fecha Inicio <span style="color: #dc3545;">*</span></label>
                        <input type="date" id="modalMantFechaInicio" name="fecha_inicio" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Costo</label>
                        <input type="number" id="modalMantCosto" name="costo" step="0.01" min="0" placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Horómetro Actual</label>
                        <input type="number" id="modalMantHorometro" name="horometro_actual" step="0.1" min="0" placeholder="0.0" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Próximo Mantenimiento (horas)</label>
                        <input type="number" id="modalMantProximo" name="horometro_proximo" step="0.1" min="0" placeholder="0.0" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Observaciones</label>
                    <textarea id="modalMantObservaciones" name="observaciones" rows="2" placeholder="Observaciones adicionales" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #dee2e6; padding-top: 20px;">
                    <button type="button" id="btnCancelarMantenimiento" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Cancelar</button>
                    <button type="submit" style="padding: 8px 20px; background-color: #ffc107; color: #856404; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-save"></i> Registrar Mantenimiento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Registrar Carga de Combustible -->
<div id="modalCombustible" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-gas-pump"></i> Registrar Carga de Combustible</h3>
            <button id="btnCerrarModalCombustible" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <form id="formCombustible">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Equipo <span style="color: #dc3545;">*</span></label>
                    <select id="modalCombustibleEquipo" name="activo_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        <option value="">Seleccionar equipo...</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Fecha <span style="color: #dc3545;">*</span></label>
                        <input type="date" id="modalCombustibleFecha" name="fecha" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Litros <span style="color: #dc3545;">*</span></label>
                        <input type="number" id="modalCombustibleLitros" name="litros" step="0.01" min="0.01" placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Costo Total <span style="color: #dc3545;">*</span></label>
                        <input type="number" id="modalCombustibleCosto" name="costo" step="0.01" min="0.01" placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Horómetro</label>
                        <input type="number" id="modalCombustibleHorometro" name="horometro" step="0.1" min="0" placeholder="0.0" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Proyecto</label>
                        <select id="modalCombustibleProyecto" name="proyecto_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Sin proyecto</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Operador</label>
                        <select id="modalCombustibleOperador" name="operador_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Sin operador</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Factura</label>
                        <input type="text" id="modalCombustibleFactura" name="factura" placeholder="Número de factura" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Proveedor</label>
                        <input type="text" id="modalCombustibleProveedor" name="proveedor" placeholder="Nombre del proveedor" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Observaciones</label>
                    <textarea id="modalCombustibleObservaciones" name="observaciones" rows="2" placeholder="Observaciones adicionales" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #dee2e6; padding-top: 20px;">
                    <button type="button" id="btnCancelarCombustible" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Cancelar</button>
                    <button type="submit" style="padding: 8px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-save"></i> Registrar Carga
                    </button>
                </div>
            </form>
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
    
    #tablaBodyInventario tr:nth-child(odd) { background-color: #ffffff; }
    #tablaBodyInventario tr:nth-child(even) { background-color: #f2f2f2; }
    #tablaBodyInventario tr:hover { background-color: #e0e0e0; }
    
    #tablaBodyInventario td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
    }
    
    .badge-equipo { font-size: 11px; padding: 4px 8px; border-radius: 4px; display: inline-block; font-weight: 600; }
    .badge-activo { background-color: #d4edda; color: #28a745; }
    .badge-mantenimiento { background-color: #f8d7da; color: #dc3545; }
    .badge-disponible { background-color: #cce5ff; color: #0d6efd; }
    .badge-inactivo { background-color: #e2e3e5; color: #6c757d; }
    .badge-baja { background-color: #f8d7da; color: #dc3545; }
    
    .badge-mant-pendiente { background-color: #fff3cd; color: #856404; }
    .badge-mant-en-proceso { background-color: #cce5ff; color: #0d6efd; }
    .badge-mant-completado { background-color: #d4edda; color: #28a745; }
    .badge-mant-cancelado { background-color: #e2e3e5; color: #6c757d; }
    
    .maquinaria-tab { transition: all 0.3s ease; }
    .maquinaria-tab:hover { opacity: 0.9; transform: translateY(-2px); }
    .maquinaria-tab.active { background-color: #083CAE !important; color: white !important; }
    .maquinaria-content { animation: fadeIn 0.3s ease; }
    
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
    
    @media (max-width: 768px) {
        input[type="date"] { width: 100% !important; }
        input#buscador { width: 100% !important; }
        #proyectoFilterContainer { min-width: 100% !important; }
        #filtroProyectosDropdown { min-width: 100% !important; }
        #paginacionContainer { flex-direction: column; align-items: flex-start; }
        #modalAsignarEquipo > div, #modalEquipo > div, #modalMantenimiento > div, #modalCombustible > div { width: 95%; margin: 10px; }
        .maquinaria-tab { padding: 8px 12px !important; font-size: 12px !important; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // ============================================
    // CONFIGURACIÓN
    // ============================================
    const API_BASE = '/proyectos/maquinaria';
    let currentPage = 1;
    let totalPages = 1;
    let currentTab = 'inventario';
    let proyectosLista = [];
    let catalogosCargados = false;
    let equiposDisponibles = [];
    let todosEquipos = [];
    let equiposAsignacionCargados = false;

    let currentFilters = {
        busqueda: '',
        tipo: '',
        estatus: '',
        proyecto_id: [],
        page: 1,
        per_page: 10
    };

    // ============================================
    // FUNCIONES PRINCIPALES
    // ============================================

    async function cargarActivos() {
        mostrarLoading(true);
        
        try {
            const proyectosSeleccionados = getProyectosSeleccionados();
            currentFilters.proyecto_id = proyectosSeleccionados;
            
            const params = new URLSearchParams();
            params.append('busqueda', currentFilters.busqueda || '');
            params.append('tipo', currentFilters.tipo || '');
            params.append('estatus', currentFilters.estatus || '');
            params.append('page', currentFilters.page || 1);
            params.append('per_page', currentFilters.per_page || 10);
            
            if (proyectosSeleccionados.length > 0) {
                proyectosSeleccionados.forEach(id => {
                    params.append('proyecto_id[]', id);
                });
            }
            
            const url = `${API_BASE}?${params.toString()}`;
            console.log('Cargando desde:', url);
            
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
            console.log('Resultado:', result);
            
            if (result.success) {
                const data = result.data.data || [];
                const pagination = result.data;
                
                actualizarEstadisticas(result.estadisticas);
                renderizarTablaInventario(data);
                actualizarPaginacion(pagination);
                
                currentPage = pagination.current_page || 1;
                totalPages = pagination.last_page || 1;
            } else {
                mostrarNotificacion(result.message || 'Error al cargar datos', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarNotificacion('Error al cargar los equipos', 'error');
        } finally {
            mostrarLoading(false);
        }
    }

    async function cargarAsignacionesActivas() {
        try {
            const response = await fetch(`${API_BASE}/asignaciones/activas`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                renderizarTablaAsignaciones(result.data);
                actualizarResumenAsignaciones(result.data);
            }
        } catch (error) {
            console.error('Error cargando asignaciones:', error);
        }
    }

    async function cargarCatalogos() {
        try {
            console.log('Cargando catálogos...');
            const response = await fetch(`${API_BASE}/catalogos`, {
                headers: { 
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const result = await response.json();
            console.log('Catálogos cargados:', result);
            
            if (result.success) {
                const data = result.data;
                
                equiposDisponibles = data.equipos || [];
                todosEquipos = data.todos_equipos || data.equipos || [];
                
                llenarSelectAsignacion();
                llenarSelectMantenimiento();
                llenarSelectCombustible();
                llenarSelectProyectos(data.proyectos || []);
                llenarSelectResponsables(data.responsables || []);
                llenarSelectOperadores(data.operadores || []);
                
                proyectosLista = data.proyectos || [];
                renderizarCheckboxesProyectos(proyectosLista);
                
                catalogosCargados = true;
                equiposAsignacionCargados = true;
                console.log('Catálogos cargados correctamente');
            } else {
                mostrarNotificacion('Error al cargar catálogos: ' + (result.message || 'Error desconocido'), 'error');
            }
        } catch (error) {
            console.error('Error en cargarCatalogos:', error);
            mostrarNotificacion('Error al cargar los catálogos', 'error');
        }
    }

    // ============================================
    // FUNCIONES PARA LLENAR SELECTS
    // ============================================

    function llenarSelectAsignacion() {
        const select = document.getElementById('modalEquipo');
        if (!select) return;
        
        const valorActual = select.value;
        select.innerHTML = '<option value="">Seleccionar equipo...</option>';
        
        if (equiposDisponibles && equiposDisponibles.length > 0) {
            equiposDisponibles.forEach(e => {
                const option = document.createElement('option');
                option.value = e.id;
                option.textContent = e.codigo + ' - ' + e.nombre + ' (' + e.tipo + ')';
                select.appendChild(option);
            });
        } else {
            select.innerHTML += '<option value="">No hay equipos disponibles</option>';
        }
        
        if (valorActual) {
            select.value = valorActual;
        }
    }

    function llenarSelectMantenimiento() {
        const select = document.getElementById('modalMantEquipo');
        if (!select) return;
        
        select.innerHTML = '<option value="">Seleccionar equipo...</option>';
        
        if (todosEquipos && todosEquipos.length > 0) {
            todosEquipos.forEach(e => {
                const option = document.createElement('option');
                option.value = e.id;
                option.textContent = e.codigo + ' - ' + e.nombre + ' (' + e.tipo + ')';
                select.appendChild(option);
            });
        } else {
            select.innerHTML += '<option value="">No hay equipos disponibles</option>';
        }
    }

    function llenarSelectCombustible() {
        const selectModal = document.getElementById('modalCombustibleEquipo');
        if (selectModal) {
            selectModal.innerHTML = '<option value="">Seleccionar equipo...</option>';
            
            if (todosEquipos && todosEquipos.length > 0) {
                todosEquipos.forEach(e => {
                    const option = document.createElement('option');
                    option.value = e.id;
                    option.textContent = e.codigo + ' - ' + e.nombre + ' (' + e.tipo + ')';
                    selectModal.appendChild(option);
                });
            } else {
                selectModal.innerHTML += '<option value="">No hay equipos disponibles</option>';
            }
        }
        
        const selectFiltro = document.getElementById('selectorCombustibleEquipo');
        if (selectFiltro) {
            selectFiltro.innerHTML = '<option value="">Todos los equipos</option>';
            
            if (todosEquipos && todosEquipos.length > 0) {
                todosEquipos.forEach(e => {
                    const option = document.createElement('option');
                    option.value = e.id;
                    option.textContent = e.codigo + ' - ' + e.nombre;
                    selectFiltro.appendChild(option);
                });
            }
        }
    }

    function llenarSelectProyectos(proyectos) {
        const selectAsignacion = document.getElementById('modalProyecto');
        if (selectAsignacion) {
            selectAsignacion.innerHTML = '<option value="">Seleccionar proyecto...</option>';
            if (proyectos && proyectos.length > 0) {
                proyectos.forEach(p => {
                    const option = document.createElement('option');
                    option.value = p.id;
                    option.textContent = p.nombre;
                    selectAsignacion.appendChild(option);
                });
            }
        }
        
        const selectCombustible = document.getElementById('modalCombustibleProyecto');
        if (selectCombustible) {
            selectCombustible.innerHTML = '<option value="">Sin proyecto</option>';
            if (proyectos && proyectos.length > 0) {
                proyectos.forEach(p => {
                    const option = document.createElement('option');
                    option.value = p.id;
                    option.textContent = p.nombre;
                    selectCombustible.appendChild(option);
                });
            }
        }
    }

    function llenarSelectResponsables(responsables) {
        const select = document.getElementById('modalResponsable');
        if (!select) return;
        
        select.innerHTML = '<option value="">Seleccionar responsable...</option>';
        if (responsables && responsables.length > 0) {
            responsables.forEach(r => {
                const option = document.createElement('option');
                option.value = r.id;
                option.textContent = r.nombre_completo;
                select.appendChild(option);
            });
        }
    }

    function llenarSelectOperadores(operadores) {
        const select = document.getElementById('modalCombustibleOperador');
        if (!select) return;
        
        select.innerHTML = '<option value="">Sin operador</option>';
        if (operadores && operadores.length > 0) {
            operadores.forEach(o => {
                const option = document.createElement('option');
                option.value = o.id;
                option.textContent = o.nombre_completo;
                select.appendChild(option);
            });
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
        cargarActivos();
    }

    // ============================================
    // RENDERIZADO - INVENTARIO
    // ============================================

    function renderizarTablaInventario(activos) {
        const tbody = document.getElementById('tablaBodyInventario');
        const sinDatos = document.getElementById('sinDatosMensaje');
        const tablaContainer = document.getElementById('tablaContainer');
        
        if (!tbody) return;
        
        tbody.innerHTML = '';
        
        if (!activos || activos.length === 0) {
            sinDatos.style.display = 'block';
            tablaContainer.style.display = 'none';
            return;
        }
        
        sinDatos.style.display = 'none';
        tablaContainer.style.display = 'block';
        
        activos.forEach(item => {
            const row = document.createElement('tr');
            const statusBadge = getStatusBadge(item.estatus);
            const horometro = item.maquinaria?.horometro_actual || '-';
            
            row.innerHTML = `
                <td style="padding: 10px 4px;">${item.codigo}</td>
                <td style="padding: 10px 4px;">${item.nombre}</td>
                <td style="padding: 10px 4px;">${item.tipo_nombre || '-'}</td>
                <td style="padding: 10px 4px;">${item.marca || '-'} ${item.modelo || ''}</td>
                <td style="padding: 10px 4px; text-align: center;">${item.anio || '-'}</td>
                <td style="padding: 10px 4px; text-align: right;">${horometro}</td>
                <td style="padding: 10px 4px;">${item.proyecto_asignado?.nombre || 'Disponible'}</td>
                <td style="padding: 10px 4px;"><span class="badge-equipo ${statusBadge}">${item.estatus_nombre || item.estatus}</span></td>
                <td style="padding: 10px 4px; background-color: white; position: sticky; right: 0;">
                    <div style="display: flex; gap: 8px; justify-content: center;">
                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetalle(${item.id})"></i>
                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" onclick="editarEquipo(${item.id})"></i>
                        <i class="fas fa-tasks" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Asignar" onclick="abrirModalAsignacion(${item.id})"></i>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    function renderizarTablaAsignaciones(asignaciones) {
        const tbody = document.getElementById('tablaAsignaciones');
        if (!tbody) return;
        
        tbody.innerHTML = '';
        
        if (!asignaciones || asignaciones.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px; color: #6c757d;">
                        No hay asignaciones activas
                    </td>
                </tr>
            `;
            return;
        }
        
        asignaciones.forEach(item => {
            const row = document.createElement('tr');
            const horas = item.horas_usadas || 0;
            
            row.innerHTML = `
                <td style="padding: 12px;">${item.activo?.codigo} - ${item.activo?.nombre}</td>
                <td style="padding: 12px;">${item.activo?.tipo_nombre || '-'}</td>
                <td style="padding: 12px;">${item.proyecto?.nombre || '-'}</td>
                <td style="padding: 12px;">${item.responsable_asignado || '-'}</td>
                <td style="padding: 12px; text-align: center;">${formatDate(item.fecha_salida)}</td>
                <td style="padding: 12px; text-align: center;">${formatDate(item.fecha_estimada_devolucion)}</td>
                <td style="padding: 12px; text-align: right;">${horas ? horas.toFixed(1) : '-'}</td>
                <td style="padding: 12px; text-align: center;">
                    <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="editarAsignacion(${item.id})"></i>
                    <i class="fas fa-check" style="color: #28a745; cursor: pointer; margin: 0 5px;" onclick="devolverEquipo(${item.id})"></i>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    function actualizarResumenAsignaciones(asignaciones) {
        const total = asignaciones?.length || 0;
        document.getElementById('totalAsignados').textContent = total;
        
        let horas = 0;
        asignaciones?.forEach(a => {
            horas += a.horas_usadas || 0;
        });
        document.getElementById('totalHorasOperacion').textContent = horas.toFixed(0);
        
        const mes = new Date().getMonth();
        const mesActual = asignaciones?.filter(a => {
            const fecha = new Date(a.fecha_salida);
            return fecha.getMonth() === mes;
        }) || [];
        document.getElementById('totalAsignacionesMes').textContent = mesActual.length;
    }

    function actualizarEstadisticas(stats) {
        if (!stats) return;
        document.getElementById('totalEquipos').textContent = stats.total_equipos || 0;
        document.getElementById('totalOperacion').textContent = stats.en_operacion || 0;
        document.getElementById('totalMantenimiento').textContent = stats.en_mantenimiento || 0;
        document.getElementById('totalDisponibles').textContent = stats.disponibles || 0;
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
            'activo': 'badge-activo',
            'mantenimiento': 'badge-mantenimiento',
            'inactivo': 'badge-inactivo',
            'baja': 'badge-baja',
            'disponible': 'badge-disponible'
        };
        return badges[status] || 'badge-equipo';
    }

    function getMantenimientoStatusBadge(status) {
        const badges = {
            'pendiente': 'badge-mant-pendiente',
            'en_proceso': 'badge-mant-en-proceso',
            'completado': 'badge-mant-completado',
            'cancelado': 'badge-mant-cancelado'
        };
        return badges[status] || 'badge-mant-pendiente';
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
        document.querySelectorAll('.toast-notification').forEach(el => el.remove());
        
        const notificacion = document.createElement('div');
        notificacion.className = `toast-notification ${tipo}`;
        const icono = tipo === 'success' ? 'fa-check-circle' : tipo === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
        notificacion.innerHTML = `<i class="fas ${icono}"></i> ${mensaje}`;
        document.body.appendChild(notificacion);
        setTimeout(() => notificacion.remove(), 3000);
    }

    // ============================================
    // FUNCIONES PARA MANTENIMIENTO
    // ============================================

    async function cargarMantenimientos() {
        try {
            const response = await fetch(`${API_BASE}/mantenimientos/list`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            console.log('Mantenimientos cargados:', result);
            
            if (result.success) {
                renderizarTablaMantenimientos(result.data);
                actualizarEstadisticasMantenimiento(result.estadisticas);
            }
        } catch (error) {
            console.error('Error cargando mantenimientos:', error);
        }
    }

    function renderizarTablaMantenimientos(data) {
        const tbody = document.getElementById('tablaMantenimientos');
        if (!tbody) return;
        
        if (!data || data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px; color: #6c757d;">
                        No hay registros de mantenimiento
                    </td>
                </tr>
            `;
            return;
        }
        
        tbody.innerHTML = data.map(item => {
            const statusBadge = getMantenimientoStatusBadge(item.estatus);
            const fechaFin = item.fecha_fin ? formatDate(item.fecha_fin) : '-';
            const responsable = item.responsable ? 
                (item.responsable.nombre_completo || item.responsable.nombre || '-') : 
                (item.responsable_asignado || '-');
            
            return `
                <tr>
                    <td>${item.activo?.codigo || ''} - ${item.activo?.nombre || ''}</td>
                    <td>${item.activo?.tipo_nombre || '-'}</td>
                    <td>${item.tipo_mantenimiento || '-'}</td>
                    <td>${formatDate(item.fecha_inicio)}</td>
                    <td>${fechaFin}</td>
                    <td>${responsable}</td>
                    <td><span class="badge-equipo ${statusBadge}">${item.estatus || 'Pendiente'}</span></td>
                    <td>
                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verDetalleMantenimiento(${item.id})"></i>
                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 5px;" onclick="editarMantenimiento(${item.id})"></i>
                    </td>
                </tr>
            `;
        }).join('');
    }

    function actualizarEstadisticasMantenimiento(estadisticas) {
        if (!estadisticas) return;
        document.getElementById('totalMantEnProceso').textContent = estadisticas.en_proceso || 0;
        document.getElementById('totalMantProximos').textContent = estadisticas.proximos || 0;
        document.getElementById('totalMantCompletados').textContent = estadisticas.completados || 0;
    }

    window.verDetalleMantenimiento = function(id) {
        mostrarNotificacion('Funcionalidad en desarrollo', 'warning');
    };

    window.editarMantenimiento = function(id) {
        mostrarNotificacion('Funcionalidad en desarrollo', 'warning');
    };

    // ============================================
    // FUNCIONES PARA COMBUSTIBLE
    // ============================================

    async function cargarCombustible() {
        try {
            const activoId = document.getElementById('selectorCombustibleEquipo')?.value || '';
            const fechaInicio = document.getElementById('fechaCombustibleInicio')?.value || '';
            const fechaFin = document.getElementById('fechaCombustibleFin')?.value || '';
            
            let url = `${API_BASE}/combustible/historial?per_page=20`;
            if (activoId) url += `&activo_id=${activoId}`;
            if (fechaInicio) url += `&fecha_inicio=${fechaInicio}`;
            if (fechaFin) url += `&fecha_fin=${fechaFin}`;
            
            console.log('Cargando combustible desde:', url);
            
            const response = await fetch(url, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            console.log('Combustible cargado:', result);
            
            if (result.success) {
                renderizarTablaCombustible(result.data.data || []);
                actualizarEstadisticasCombustible(result);
            }
        } catch (error) {
            console.error('Error al cargar combustible:', error);
            mostrarNotificacion('Error al cargar combustible', 'error');
        }
    }

    function renderizarTablaCombustible(data) {
        const tbody = document.getElementById('tablaCombustible');
        if (!tbody) return;
        
        if (!data || data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" style="text-align: center; padding: 20px;">
                <i class="fas fa-gas-pump" style="font-size: 24px; color: #ccc; display: block; margin-bottom: 10px;"></i>
                No hay registros de combustible
            </td></tr>`;
            return;
        }
        
        tbody.innerHTML = data.map(item => {
            let operadorNombre = '-';
            if (item.operador) {
                operadorNombre = item.operador.nombre_completo || 
                                (item.operador.nombre ? `${item.operador.nombre} ${item.operador.apellido_paterno || ''}`.trim() : '-');
            }
            
            let proyectoNombre = 'Sin proyecto';
            if (item.proyecto) {
                proyectoNombre = item.proyecto.nombre || 'Sin proyecto';
            }
            
            let activoNombre = '-';
            if (item.activo) {
                activoNombre = `${item.activo.codigo || ''} - ${item.activo.nombre || ''}`;
            }
            
            return `
                <tr>
                    <td>${activoNombre}</td>
                    <td>${proyectoNombre}</td>
                    <td>${formatDate(item.fecha)}</td>
                    <td style="text-align: right;">${Number(item.litros).toFixed(2)} L</td>
                    <td style="text-align: right;">$${Number(item.costo).toFixed(2)}</td>
                    <td>${item.horometro || '-'}</td>
                    <td>${operadorNombre}</td>
                    <td>
                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verDetalleCombustible(${item.id})"></i>
                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 5px;" onclick="editarCombustible(${item.id})"></i>
                    </td>
                </tr>
            `;
        }).join('');
    }

    function actualizarEstadisticasCombustible(result) {
        if (!result || !result.totales) return;
        
        const totalLitros = document.getElementById('totalConsumoMensual');
        const totalCosto = document.getElementById('totalCostoMensual');
        const rendimiento = document.getElementById('totalRendimientoProm');
        
        const totalL = Number(result.totales.total_litros || 0);
        const totalC = Number(result.totales.total_costo || 0);
        const registros = Number(result.totales.total_registros || 1);
        
        if (totalLitros) {
            totalLitros.textContent = totalL.toFixed(2) + ' L';
        }
        
        if (totalCosto) {
            totalCosto.textContent = '$' + totalC.toFixed(2);
        }
        
        if (rendimiento) {
            const rend = totalL / registros;
            rendimiento.textContent = rend.toFixed(2) + ' L/carga';
        }
    }

    window.verDetalleCombustible = function(id) {
        mostrarNotificacion('Funcionalidad en desarrollo', 'warning');
    };

    window.editarCombustible = function(id) {
        mostrarNotificacion('Funcionalidad en desarrollo', 'warning');
    };

    // ============================================
    // ACCIONES DE LA PÁGINA
    // ============================================

    window.verDetalle = function(id) {
        mostrarNotificacion('Funcionalidad en desarrollo', 'warning');
    };

    window.editarEquipo = function(id) {
        mostrarNotificacion('Funcionalidad en desarrollo', 'warning');
    };

    window.editarAsignacion = function(id) {
        mostrarNotificacion('Funcionalidad en desarrollo', 'warning');
    };

    window.devolverEquipo = function(id) {
        if (!confirm('¿Está seguro de devolver este equipo?')) return;
        mostrarNotificacion('Funcionalidad en desarrollo', 'warning');
    };

    window.abrirModalAsignacion = async function(equipoId = null) {
        try {
            const select = document.getElementById('modalEquipo');
            if (select) {
                select.innerHTML = '<option value="">Cargando equipos...</option>';
            }
            
            const modal = document.getElementById('modalAsignarEquipo');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            
            if (!equiposAsignacionCargados || equiposDisponibles.length === 0) {
                await cargarCatalogos();
            }
            
            llenarSelectAsignacion();
            
            if (equipoId) {
                const selectEquipo = document.getElementById('modalEquipo');
                if (selectEquipo) {
                    for (let i = 0; i < selectEquipo.options.length; i++) {
                        if (selectEquipo.options[i].value == equipoId) {
                            selectEquipo.selectedIndex = i;
                            break;
                        }
                    }
                }
            }
            
            const hoy = new Date();
            document.getElementById('modalFechaInicio').value = hoy.toISOString().split('T')[0];
            const unMes = new Date();
            unMes.setMonth(unMes.getMonth() + 1);
            document.getElementById('modalFechaFin').value = unMes.toISOString().split('T')[0];
            
        } catch (error) {
            console.error('Error al abrir modal:', error);
            mostrarNotificacion('Error al cargar los equipos', 'error');
            
            const select = document.getElementById('modalEquipo');
            if (select) {
                select.innerHTML = '<option value="">Error al cargar equipos</option>';
            }
        }
    };

    // ============================================
    // FUNCIONES PARA CERRAR MODALES
    // ============================================

    function cerrarModalAsignacion() {
        document.getElementById('modalAsignarEquipo').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function cerrarModalEquipo() {
        document.getElementById('modalEquipo').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function cerrarModalMantenimiento() {
        document.getElementById('modalMantenimiento').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function cerrarModalCombustible() {
        document.getElementById('modalCombustible').style.display = 'none';
        document.body.style.overflow = 'auto';
        document.getElementById('formCombustible').reset();
    }

    // ============================================
    // EXPORTAR A EXCEL
    // ============================================

    async function exportarExcel() {
        try {
            const params = new URLSearchParams();
            params.append('busqueda', currentFilters.busqueda || '');
            params.append('tipo', currentFilters.tipo || '');
            params.append('estatus', currentFilters.estatus || '');
            
            const proyectos = getProyectosSeleccionados();
            if (proyectos.length > 0) {
                proyectos.forEach(id => params.append('proyecto_id[]', id));
            }
            
            const response = await fetch(`${API_BASE}/exportar?${params.toString()}`);
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
                link.download = `Maquinaria_${new Date().toISOString().split('T')[0]}.csv`;
                link.click();
                URL.revokeObjectURL(link.href);
                mostrarNotificacion('Exportación completada', 'success');
            }
        } catch (error) {
            mostrarNotificacion('Error al exportar', 'error');
        }
    }

    // ============================================
    // EVENTOS E INICIALIZACIÓN
    // ============================================

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado - API_BASE:', API_BASE);
        
        cargarCatalogos().then(() => {
            cargarActivos();
            cargarAsignacionesActivas();
            cargarCombustible();
            cargarMantenimientos();
        });
        
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
        document.querySelectorAll('.maquinaria-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.maquinaria-tab').forEach(t => {
                    t.classList.remove('active');
                    t.style.backgroundColor = '#e9ecef';
                    t.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                currentTab = this.dataset.tab;
                
                document.querySelectorAll('.maquinaria-content').forEach(content => {
                    content.style.display = 'none';
                });
                
                const target = document.getElementById(`tab-${currentTab}`);
                if (target) {
                    target.style.display = 'block';
                }
                
                if (currentTab === 'asignacion') {
                    cargarAsignacionesActivas();
                }
                if (currentTab === 'mantenimiento') {
                    cargarMantenimientos();
                }
                if (currentTab === 'combustible') {
                    cargarCombustible();
                }
            });
        });
        
        // Filtros
        document.getElementById('selectorTipo')?.addEventListener('change', function() {
            currentFilters.tipo = this.value;
            currentFilters.page = 1;
            cargarActivos();
        });
        
        document.getElementById('selectorStatus')?.addEventListener('change', function() {
            currentFilters.estatus = this.value;
            currentFilters.page = 1;
            cargarActivos();
        });
        
        document.getElementById('buscador')?.addEventListener('input', function() {
            currentFilters.busqueda = this.value;
            currentFilters.page = 1;
            cargarActivos();
        });
        
        // Botón Asignar Equipo
        document.getElementById('btnAsignarEquipo')?.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            document.getElementById('formAsignarEquipo').reset();
            abrirModalAsignacion();
        });
        
        // Botón Nueva Asignación
        document.getElementById('btnNuevaAsignacion')?.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            document.getElementById('formAsignarEquipo').reset();
            abrirModalAsignacion();
        });
        
        document.getElementById('btnAgregarEquipo')?.addEventListener('click', function() {
            document.getElementById('modalEquipo').style.display = 'flex';
            document.body.style.overflow = 'hidden';
            document.getElementById('formEquipo').reset();
            document.getElementById('editEquipoId').value = '';
        });
        
        document.getElementById('btnRegistrarMantenimiento')?.addEventListener('click', function() {
            document.getElementById('modalMantenimiento').style.display = 'flex';
            document.body.style.overflow = 'hidden';
            document.getElementById('formMantenimiento').reset();
            const hoy = new Date();
            document.getElementById('modalMantFechaInicio').value = hoy.toISOString().split('T')[0];
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', exportarExcel);
        
        // Botones de combustible
        document.getElementById('btnRegistrarCarga')?.addEventListener('click', function() {
            document.getElementById('modalCombustible').style.display = 'flex';
            document.body.style.overflow = 'hidden';
            document.getElementById('formCombustible').reset();
            const hoy = new Date();
            document.getElementById('modalCombustibleFecha').value = hoy.toISOString().split('T')[0];
        });
        
        document.getElementById('btnFiltrarCombustible')?.addEventListener('click', cargarCombustible);
        
        // Cerrar modales de combustible
        document.getElementById('btnCerrarModalCombustible')?.addEventListener('click', cerrarModalCombustible);
        document.getElementById('btnCancelarCombustible')?.addEventListener('click', cerrarModalCombustible);
        
        // Paginación
        document.getElementById('btnPrimera')?.addEventListener('click', () => {
            if (currentPage > 1) { currentFilters.page = 1; cargarActivos(); }
        });
        document.getElementById('btnAnterior')?.addEventListener('click', () => {
            if (currentPage > 1) { currentFilters.page = currentPage - 1; cargarActivos(); }
        });
        document.getElementById('btnSiguiente')?.addEventListener('click', () => {
            if (currentPage < totalPages) { currentFilters.page = currentPage + 1; cargarActivos(); }
        });
        document.getElementById('btnUltima')?.addEventListener('click', () => {
            if (currentPage < totalPages) { currentFilters.page = totalPages; cargarActivos(); }
        });
        
        // Cerrar modales
        document.getElementById('btnCerrarModalAsignacion')?.addEventListener('click', cerrarModalAsignacion);
        document.getElementById('btnCancelarAsignacion')?.addEventListener('click', cerrarModalAsignacion);
        document.getElementById('btnCerrarModalEquipo')?.addEventListener('click', cerrarModalEquipo);
        document.getElementById('btnCancelarEquipo')?.addEventListener('click', cerrarModalEquipo);
        document.getElementById('btnCerrarModalMantenimiento')?.addEventListener('click', cerrarModalMantenimiento);
        document.getElementById('btnCancelarMantenimiento')?.addEventListener('click', cerrarModalMantenimiento);
        
        // Submit forms
        document.getElementById('formAsignarEquipo')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btnSubmit = this.querySelector('button[type="submit"]');
            const textoOriginal = btnSubmit.innerHTML;
            btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Asignando...';
            btnSubmit.disabled = true;
            
            const formData = new FormData(this);
            
            fetch(`${API_BASE}/asignar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                btnSubmit.innerHTML = textoOriginal;
                btnSubmit.disabled = false;
                
                if (result.success) {
                    mostrarNotificacion(result.message, 'success');
                    cerrarModalAsignacion();
                    cargarActivos();
                    cargarAsignacionesActivas();
                } else {
                    mostrarNotificacion(result.message || 'Error al asignar', 'error');
                }
            })
            .catch(error => {
                btnSubmit.innerHTML = textoOriginal;
                btnSubmit.disabled = false;
                mostrarNotificacion('Error al asignar el equipo', 'error');
            });
        });
        
        document.getElementById('formEquipo')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch(API_BASE, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    mostrarNotificacion(result.message, 'success');
                    cerrarModalEquipo();
                    cargarActivos();
                } else {
                    mostrarNotificacion(result.message || 'Error al guardar', 'error');
                }
            })
            .catch(error => {
                mostrarNotificacion('Error al guardar el equipo', 'error');
            });
        });
        
        document.getElementById('formMantenimiento')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btnSubmit = this.querySelector('button[type="submit"]');
            const textoOriginal = btnSubmit.innerHTML;
            btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registrando...';
            btnSubmit.disabled = true;
            
            const formData = new FormData(this);
            
            fetch(`${API_BASE}/mantenimientos`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                btnSubmit.innerHTML = textoOriginal;
                btnSubmit.disabled = false;
                
                if (result.success) {
                    mostrarNotificacion(result.message, 'success');
                    cerrarModalMantenimiento();
                    cargarActivos();
                    cargarMantenimientos();
                } else {
                    mostrarNotificacion(result.message || 'Error al registrar', 'error');
                }
            })
            .catch(error => {
                btnSubmit.innerHTML = textoOriginal;
                btnSubmit.disabled = false;
                mostrarNotificacion('Error al registrar mantenimiento', 'error');
            });
        });
        
        document.getElementById('formCombustible')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btnSubmit = this.querySelector('button[type="submit"]');
            const textoOriginal = btnSubmit.innerHTML;
            btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registrando...';
            btnSubmit.disabled = true;
            
            const formData = new FormData(this);
            
            fetch(`${API_BASE}/combustible/consumo`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                btnSubmit.innerHTML = textoOriginal;
                btnSubmit.disabled = false;
                
                if (result.success) {
                    mostrarNotificacion(result.message, 'success');
                    cerrarModalCombustible();
                    cargarCombustible();
                } else {
                    mostrarNotificacion(result.message || 'Error al registrar', 'error');
                }
            })
            .catch(error => {
                btnSubmit.innerHTML = textoOriginal;
                btnSubmit.disabled = false;
                mostrarNotificacion('Error al registrar consumo de combustible', 'error');
            });
        });
        
        // Cerrar modales al hacer clic fuera
        window.addEventListener('click', function(e) {
            const modalAsignacion = document.getElementById('modalAsignarEquipo');
            const modalEquipo = document.getElementById('modalEquipo');
            const modalMantenimiento = document.getElementById('modalMantenimiento');
            const modalCombustible = document.getElementById('modalCombustible');
            
            if (e.target === modalAsignacion) cerrarModalAsignacion();
            if (e.target === modalEquipo) cerrarModalEquipo();
            if (e.target === modalMantenimiento) cerrarModalMantenimiento();
            if (e.target === modalCombustible) cerrarModalCombustible();
        });
    });
</script>
@endsection