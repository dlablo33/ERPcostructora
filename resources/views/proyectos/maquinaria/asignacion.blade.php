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
                <!-- 4 CUADROS DE MAQUINARIA CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Total Equipos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Equipos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalEquipos">142</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: En Operación -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">En Operación</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalOperacion">98</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: En Mantenimiento -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Mantenimiento</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalMantenimiento">24</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Disponibles -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Disponibles</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalDisponibles">20</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Selectores a la izquierda -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <select id="selectorTipo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 180px;">
                            <option value="">Todos los tipos</option>
                            <option value="Excavadora">Excavadoras</option>
                            <option value="Retroexcavadora">Retroexcavadoras</option>
                            <option value="Camion">Camiones</option>
                            <option value="Grua">Grúas</option>
                            <option value="Compactador">Compactadores</option>
                            <option value="Generador">Generadores</option>
                        </select>

                        <select id="selectorStatus" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                            <option value="">Todos los estados</option>
                            <option value="Operacion">En Operación</option>
                            <option value="Mantenimiento">En Mantenimiento</option>
                            <option value="Disponible">Disponible</option>
                            <option value="Asignado">Asignado</option>
                        </select>

                        <select id="selectorProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 250px;">
                            <option value="">Todos los proyectos</option>
                            <option value="PRO-2024-001">PRO-2024-001 - Torre Norte Corporativa</option>
                            <option value="PRO-2024-002">PRO-2024-002 - Puente Vehicular Sur</option>
                            <option value="PRO-2024-003">PRO-2024-003 - Parque Industrial Norte</option>
                            <option value="PRO-2024-004">PRO-2024-004 - Hospital Regional</option>
                            <option value="PRO-2024-005">PRO-2024-005 - Planta Tratamiento</option>
                            <option value="PRO-2024-006">PRO-2024-006 - Urbanización Los Álamos</option>
                        </select>
                    </div>
                    
                    <!-- Grupo de botones derecho -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Botón Asignar Equipo -->
                        <div>
                            <button id="btnAsignarEquipo" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Asignar Equipo a Proyecto">
                                <i class="fas fa-tasks"></i> Asignar Equipo
                            </button>
                        </div>

                        <!-- Botón Registrar Mantenimiento -->
                        <div>
                            <button id="btnRegistrarMantenimiento" style="background-color: white; border: 1px solid #ffc107; color: #ffc107; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Registrar Mantenimiento">
                                <i class="fas fa-tools"></i>
                            </button>
                        </div>

                        <!-- Botón Agregar Equipo -->
                        <div>
                            <button id="btnAgregarEquipo" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #083CAE; font-size: 16px;" title="Agregar Equipo">
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

                        <!-- Buscador -->
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

                <!-- SECCIÓN 1: INVENTARIO -->
                <div id="tab-inventario" class="maquinaria-content active">
                    <!-- Mensaje "Sin datos" centrado -->
                    <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                        <i class="fas fa-tractor" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                        <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin equipos</h3>
                        <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay equipos registrados</p>
                    </div>

                    <!-- Tabla de Inventario -->
                    <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                        <table class="table table-bordered" id="tablaInventario" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                            <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                                <tr>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>ID Equipo</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Tipo</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Marca/Modelo</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Año</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Horómetro</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Proyecto Asignado</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Status</span>
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
                            <tbody id="tablaBodyInventario">
                                <!-- Las filas se insertarán dinámicamente con JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación -->
                    <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px; background: transparent !important; background-color: transparent !important; border: none !important; box-shadow: none !important;">
                        <!-- Botón Ver todos (izquierda) - SIN FONDO -->
                        <button id="btnVerTodos" style="background: transparent !important; background-color: transparent !important; border: none !important; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: #2378e1; box-shadow: none !important; outline: none !important; margin: 0;">
                            <i class="fas fa-eye" style="font-size: 16px; color: #2378e1;"></i>
                            <span style="color: #2378e1;">Ver todos</span>
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
                            <span style="margin-left: 5px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-5 de 45 registros</span>
                            <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página siguiente" id="btnSiguiente">
                                <i class="fas fa-angle-right" style="color: #2378e1;"></i>
                            </button>
                            <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Última página" id="btnUltima">
                                <i class="fas fa-angle-double-right" style="color: #2378e1;"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 2: ASIGNACIÓN DE EQUIPO -->
                <div id="tab-asignacion" class="maquinaria-content" style="display: none;">
                    <!-- Resumen de asignaciones -->
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 40px; height: 40px; background-color: #e8f0fe; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-check-circle" style="color: #083CAE;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Equipos Asignados</div>
                                    <div style="font-size: 24px; font-weight: bold; color: #083CAE;">98</div>
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
                                    <div style="font-size: 24px; font-weight: bold; color: #28a745;">8,520</div>
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
                                    <div style="font-size: 24px; font-weight: bold; color: #ffc107;">24</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Asignaciones Activas -->
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
                                        <th style="padding: 12px; text-align: left;">Equipo</th>
                                        <th style="padding: 12px; text-align: left;">Tipo</th>
                                        <th style="padding: 12px; text-align: left;">Proyecto</th>
                                        <th style="padding: 12px; text-align: left;">Operador</th>
                                        <th style="padding: 12px; text-align: center;">Fecha Asignación</th>
                                        <th style="padding: 12px; text-align: center;">Fecha Estimada</th>
                                        <th style="padding: 12px; text-align: right;">Horas</th>
                                        <th style="padding: 12px; text-align: center;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 12px;"><strong>EX-001</strong> - Excavadora 320D</td>
                                        <td style="padding: 12px;">Excavadora</td>
                                        <td style="padding: 12px;">Torre Norte</td>
                                        <td style="padding: 12px;">Carlos Rodríguez</td>
                                        <td style="padding: 12px; text-align: center;">01/03/2026</td>
                                        <td style="padding: 12px; text-align: center;">30/04/2026</td>
                                        <td style="padding: 12px; text-align: right;">185</td>
                                        <td style="padding: 12px; text-align: center;">
                                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Editar asignación"></i>
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; margin: 0 5px;" title="Finalizar asignación"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>RT-005</strong> - Retroexcavadora 416E</td>
                                        <td style="padding: 12px;">Retroexcavadora</td>
                                        <td style="padding: 12px;">Puente Sur</td>
                                        <td style="padding: 12px;">María García</td>
                                        <td style="padding: 12px; text-align: center;">05/03/2026</td>
                                        <td style="padding: 12px; text-align: center;">15/05/2026</td>
                                        <td style="padding: 12px; text-align: right;">142</td>
                                        <td style="padding: 12px; text-align: center;">
                                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>CA-012</strong> - Camión de volteo</td>
                                        <td style="padding: 12px;">Camión</td>
                                        <td style="padding: 12px;">Parque Industrial</td>
                                        <td style="padding: 12px;">Juan Pérez</td>
                                        <td style="padding: 12px; text-align: center;">10/03/2026</td>
                                        <td style="padding: 12px; text-align: center;">10/04/2026</td>
                                        <td style="padding: 12px; text-align: right;">95</td>
                                        <td style="padding: 12px; text-align: center;">
                                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>GR-003</strong> - Grúa telescópica</td>
                                        <td style="padding: 12px;">Grúa</td>
                                        <td style="padding: 12px;">Hospital Regional</td>
                                        <td style="padding: 12px;">Ana Martínez</td>
                                        <td style="padding: 12px; text-align: center;">12/03/2026</td>
                                        <td style="padding: 12px; text-align: center;">12/04/2026</td>
                                        <td style="padding: 12px; text-align: right;">78</td>
                                        <td style="padding: 12px; text-align: center;">
                                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; margin: 0 5px;"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Historial de Asignaciones -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                        <div style="background-color: #f8f9fa; padding: 12px 15px; border-bottom: 2px solid #6c757d;">
                            <h5 style="margin: 0; color: #6c757d; font-size: 15px;"><i class="fas fa-history"></i> Historial de Asignaciones</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="width: 100%; font-size: 12px; border-collapse: collapse;">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="padding: 10px; text-align: left;">Equipo</th>
                                        <th style="padding: 10px; text-align: left;">Proyecto</th>
                                        <th style="padding: 10px; text-align: left;">Operador</th>
                                        <th style="padding: 10px; text-align: center;">Fecha Inicio</th>
                                        <th style="padding: 10px; text-align: center;">Fecha Fin</th>
                                        <th style="padding: 10px; text-align: right;">Horas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 10px;">EX-001 - Excavadora 320D</td>
                                        <td style="padding: 10px;">Torre Norte</td>
                                        <td style="padding: 10px;">Carlos Rodríguez</td>
                                        <td style="padding: 10px; text-align: center;">01/02/2026</td>
                                        <td style="padding: 10px; text-align: center;">28/02/2026</td>
                                        <td style="padding: 10px; text-align: right;">210</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px;">RT-005 - Retroexcavadora</td>
                                        <td style="padding: 10px;">Puente Sur</td>
                                        <td style="padding: 10px;">María García</td>
                                        <td style="padding: 10px; text-align: center;">01/02/2026</td>
                                        <td style="padding: 10px; text-align: center;">28/02/2026</td>
                                        <td style="padding: 10px; text-align: right;">185</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px;">CA-010 - Camión</td>
                                        <td style="padding: 10px;">Parque Industrial</td>
                                        <td style="padding: 10px;">Luis Ramírez</td>
                                        <td style="padding: 10px; text-align: center;">15/01/2026</td>
                                        <td style="padding: 10px; text-align: center;">15/02/2026</td>
                                        <td style="padding: 10px; text-align: right;">245</td>
                                    </tr>
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
                                    <div style="font-size: 24px; font-weight: bold; color: #dc3545;">12</div>
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
                                    <div style="font-size: 24px; font-weight: bold; color: #ffc107;">8</div>
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
                                    <div style="font-size: 24px; font-weight: bold; color: #28a745;">45</div>
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
                                    <th style="padding: 12px;">Tipo Mantenimiento</th>
                                    <th style="padding: 12px;">Fecha Inicio</th>
                                    <th style="padding: 12px;">Fecha Fin</th>
                                    <th style="padding: 12px;">Responsable</th>
                                    <th style="padding: 12px;">Status</th>
                                    <th style="padding: 12px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px;">EX-002 - Excavadora</td>
                                    <td style="padding: 12px;">Excavadora</td>
                                    <td style="padding: 12px;">Preventivo</td>
                                    <td style="padding: 12px;">10/03/2026</td>
                                    <td style="padding: 12px;">12/03/2026</td>
                                    <td style="padding: 12px;">Taller Mecánico</td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">En proceso</span></td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">CA-015 - Camión</td>
                                    <td style="padding: 12px;">Camión</td>
                                    <td style="padding: 12px;">Correctivo</td>
                                    <td style="padding: 12px;">08/03/2026</td>
                                    <td style="padding: 12px;">-</td>
                                    <td style="padding: 12px;">Taller Externo</td>
                                    <td style="padding: 12px;"><span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px;">Pendiente</span></td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 4: COMBUSTIBLE -->
                <div id="tab-combustible" class="maquinaria-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 40px; height: 40px; background-color: #e8f0fe; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-gas-pump" style="color: #083CAE;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; color: #6c757d;">Consumo Mensual</div>
                                    <div style="font-size: 24px; font-weight: bold; color: #083CAE;">12,450 L</div>
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
                                    <div style="font-size: 24px; font-weight: bold; color: #ffc107;">$248,500</div>
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
                                    <div style="font-size: 24px; font-weight: bold; color: #28a745;">2.8 L/hr</div>
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
                                    <th style="padding: 12px;">Litros</th>
                                    <th style="padding: 12px;">Costo</th>
                                    <th style="padding: 12px;">Horómetro</th>
                                    <th style="padding: 12px;">Operador</th>
                                    <th style="padding: 12px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px;">EX-001 - Excavadora</td>
                                    <td style="padding: 12px;">Torre Norte</td>
                                    <td style="padding: 12px;">10/03/2026</td>
                                    <td style="padding: 12px;">180 L</td>
                                    <td style="padding: 12px;">$3,600</td>
                                    <td style="padding: 12px;">1,245 hrs</td>
                                    <td style="padding: 12px;">Carlos R.</td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;">RT-005 - Retro</td>
                                    <td style="padding: 12px;">Puente Sur</td>
                                    <td style="padding: 12px;">10/03/2026</td>
                                    <td style="padding: 12px;">95 L</td>
                                    <td style="padding: 12px;">$1,900</td>
                                    <td style="padding: 12px;">890 hrs</td>
                                    <td style="padding: 12px;">María G.</td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer;"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Asignar Equipo -->
<div id="modalAsignarEquipo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #083CAE;"><i class="fas fa-tasks"></i> Asignar Equipo a Proyecto</h3>
            <button id="btnCerrarModalAsignacion" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #6c757d;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Equipo <span style="color: #dc3545;">*</span></label>
                <select id="modalEquipo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="">Seleccionar equipo...</option>
                    <option value="EX-001">EX-001 - Excavadora 320D (Disponible)</option>
                    <option value="EX-002">EX-002 - Excavadora 320D (Disponible)</option>
                    <option value="RT-005">RT-005 - Retroexcavadora 416E (Disponible)</option>
                    <option value="RT-006">RT-006 - Retroexcavadora 416E (Disponible)</option>
                    <option value="CA-010">CA-010 - Camión de volteo (Disponible)</option>
                    <option value="CA-012">CA-012 - Camión de volteo (Disponible)</option>
                </select>
            </div>

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
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Operador Asignado</label>
                <select id="modalOperador" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="">Seleccionar operador...</option>
                    <option value="carlos">Carlos Rodríguez</option>
                    <option value="maria">María García</option>
                    <option value="juan">Juan Pérez</option>
                    <option value="ana">Ana Martínez</option>
                    <option value="luis">Luis Ramírez</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha Inicio <span style="color: #dc3545;">*</span></label>
                    <input type="date" id="modalFechaInicio" value="2026-03-11" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha Estimada Fin</label>
                    <input type="date" id="modalFechaFin" value="2026-04-11" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Horas Estimadas</label>
                <input type="number" id="modalHoras" placeholder="200" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Observaciones</label>
                <textarea id="modalObservaciones" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Notas adicionales sobre la asignación..."></textarea>
            </div>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelarAsignacion" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button id="btnGuardarAsignacion" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Asignar Equipo</button>
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
    #tablaBodyInventario tr:nth-child(odd) {
        background-color: #ffffff;
    }
    
    #tablaBodyInventario tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    
    #tablaBodyInventario tr:hover {
        background-color: #e0e0e0;
    }
    
    /* Estilo para los iconos de acción */
    #tablaBodyInventario td i, .table td i {
        transition: transform 0.2s;
        font-size: 14px;
        color: #083CAE;
    }
    
    #tablaBodyInventario td i:hover, .table td i:hover {
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
    #tablaBodyInventario td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
    }
    
    /* Badges para status de equipo */
    .badge-equipo {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        font-weight: 600;
    }
    
    .badge-operacion {
        background-color: #d4edda;
        color: #28a745;
    }
    
    .badge-mantenimiento {
        background-color: #f8d7da;
        color: #dc3545;
    }
    
    .badge-disponible {
        background-color: #cce5ff;
        color: #0d6efd;
    }
    
    .badge-asignado {
        background-color: #fff3cd;
        color: #ffc107;
    }
    
    /* Pestañas */
    .maquinaria-tab {
        transition: all 0.3s ease;
    }
    
    .maquinaria-tab:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    
    .maquinaria-tab.active {
        background-color: #083CAE !important;
        color: white !important;
    }
    
    .maquinaria-content {
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
    
    /* Estilo específico para btnVerTodos */
    #btnVerTodos,
    #btnVerTodos:hover,
    #btnVerTodos:focus,
    #btnVerTodos:active {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }
    
    #btnVerTodos i,
    #btnVerTodos span {
        color: #2378e1 !important;
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
        
        .maquinaria-tab {
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
        console.log('DOM completamente cargado - Maquinaria y Equipo');
        
        // Variables
        let currentPage = 1;
        let rowsPerPage = 5;
        let datosOriginales = [];
        
        // Elementos del DOM
        const tablaBodyInventario = document.getElementById('tablaBodyInventario');
        const tablaContainer = document.getElementById('tablaContainer');
        const sinDatosMensaje = document.getElementById('sinDatosMensaje');
        const selectorTipo = document.getElementById('selectorTipo');
        const selectorStatus = document.getElementById('selectorStatus');
        const selectorProyecto = document.getElementById('selectorProyecto');
        const buscador = document.getElementById('buscador');
        const btnAsignarEquipo = document.getElementById('btnAsignarEquipo');
        const btnRegistrarMantenimiento = document.getElementById('btnRegistrarMantenimiento');
        const btnAgregarEquipo = document.getElementById('btnAgregarEquipo');
        const btnExcel = document.getElementById('btnExcel');
        const btnVerTodos = document.getElementById('btnVerTodos');
        const btnPrimera = document.getElementById('btnPrimera');
        const btnAnterior = document.getElementById('btnAnterior');
        const btnSiguiente = document.getElementById('btnSiguiente');
        const btnUltima = document.getElementById('btnUltima');
        const paginaActualSpan = document.getElementById('paginaActual');
        const paginacionInfo = document.getElementById('paginacionInfo');
        
        // Pestañas
        const maquinariaTabs = document.querySelectorAll('.maquinaria-tab');
        const maquinariaContents = document.querySelectorAll('.maquinaria-content');
        
        // Elementos del modal de asignación
        const modalAsignarEquipo = document.getElementById('modalAsignarEquipo');
        const btnCerrarModalAsignacion = document.getElementById('btnCerrarModalAsignacion');
        const btnCancelarAsignacion = document.getElementById('btnCancelarAsignacion');
        const btnGuardarAsignacion = document.getElementById('btnGuardarAsignacion');
        const btnNuevaAsignacion = document.getElementById('btnNuevaAsignacion');
        
        // Datos de ejemplo para inventario
        const inventarioData = [
            { id: 'EX-001', tipo: 'Excavadora', modelo: 'Caterpillar 320D', año: 2022, horometro: 1245, proyecto: 'PRO-2024-001', proyectoNombre: 'Torre Norte', status: 'Asignado' },
            { id: 'EX-002', tipo: 'Excavadora', modelo: 'Caterpillar 320D', año: 2022, horometro: 980, proyecto: '', proyectoNombre: '-', status: 'Disponible' },
            { id: 'EX-003', tipo: 'Excavadora', modelo: 'Komatsu PC200', año: 2021, horometro: 2100, proyecto: 'PRO-2024-002', proyectoNombre: 'Puente Sur', status: 'Asignado' },
            { id: 'RT-001', tipo: 'Retroexcavadora', modelo: 'John Deere 310L', año: 2023, horometro: 560, proyecto: 'PRO-2024-003', proyectoNombre: 'Parque Industrial', status: 'Asignado' },
            { id: 'RT-002', tipo: 'Retroexcavadora', modelo: 'Case 580SN', año: 2022, horometro: 1120, proyecto: 'PRO-2024-001', proyectoNombre: 'Torre Norte', status: 'Asignado' },
            { id: 'RT-003', tipo: 'Retroexcavadora', modelo: 'JCB 3CX', año: 2021, horometro: 1850, proyecto: '', proyectoNombre: '-', status: 'Disponible' },
            { id: 'CA-010', tipo: 'Camión', modelo: 'Kenworth T880', año: 2023, horometro: 890, proyecto: 'PRO-2024-004', proyectoNombre: 'Hospital Regional', status: 'Asignado' },
            { id: 'CA-011', tipo: 'Camión', modelo: 'Freightliner M2', año: 2022, horometro: 1240, proyecto: 'PRO-2024-005', proyectoNombre: 'Planta Tratamiento', status: 'Asignado' },
            { id: 'CA-012', tipo: 'Camión', modelo: 'International HV', año: 2021, horometro: 2150, proyecto: 'PRO-2024-003', proyectoNombre: 'Parque Industrial', status: 'Asignado' },
            { id: 'CA-013', tipo: 'Camión', modelo: 'Volvo VHD', año: 2023, horometro: 450, proyecto: '', proyectoNombre: '-', status: 'Disponible' },
            { id: 'GR-001', tipo: 'Grúa', modelo: 'Grove RT540', año: 2022, horometro: 780, proyecto: 'PRO-2024-002', proyectoNombre: 'Puente Sur', status: 'Mantenimiento' },
            { id: 'GR-002', tipo: 'Grúa', modelo: 'Link-Belt HTC', año: 2021, horometro: 1560, proyecto: 'PRO-2024-001', proyectoNombre: 'Torre Norte', status: 'Asignado' },
            { id: 'GR-003', tipo: 'Grúa', modelo: 'Terex RT', año: 2022, horometro: 920, proyecto: 'PRO-2024-004', proyectoNombre: 'Hospital Regional', status: 'Asignado' },
            { id: 'CP-001', tipo: 'Compactador', modelo: 'Bomag BW213', año: 2023, horometro: 320, proyecto: 'PRO-2024-005', proyectoNombre: 'Planta Tratamiento', status: 'Asignado' },
            { id: 'GN-001', tipo: 'Generador', modelo: 'Caterpillar 100kW', año: 2022, horometro: 540, proyecto: 'PRO-2024-003', proyectoNombre: 'Parque Industrial', status: 'Mantenimiento' }
        ];
        
        datosOriginales = [...inventarioData];
        
        // Función para obtener clase de badge según status
        function getStatusBadgeClass(status) {
            switch(status) {
                case 'Operacion':
                case 'Asignado': return 'badge-asignado';
                case 'Mantenimiento': return 'badge-mantenimiento';
                case 'Disponible': return 'badge-disponible';
                default: return 'badge-equipo';
            }
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
            paginaActualSpan.textContent = currentPage;
            paginacionInfo.textContent = `Mostrando ${Math.min((currentPage - 1) * rowsPerPage + 1, total)}-${Math.min(currentPage * rowsPerPage, total)} de ${total} registros`;
        }
        
        // Función para actualizar los cuadros de resumen
        function actualizarResumen(datos) {
            const totalEquipos = datos.length;
            const enOperacion = datos.filter(e => e.status === 'Asignado').length;
            const enMantenimiento = datos.filter(e => e.status === 'Mantenimiento').length;
            const disponibles = datos.filter(e => e.status === 'Disponible').length;
            
            document.getElementById('totalEquipos').textContent = totalEquipos;
            document.getElementById('totalOperacion').textContent = enOperacion;
            document.getElementById('totalMantenimiento').textContent = enMantenimiento;
            document.getElementById('totalDisponibles').textContent = disponibles;
        }
        
        // Función para cargar datos en la tabla de inventario
        function cargarTablaInventario(datos) {
            if (!tablaBodyInventario) return;
            
            tablaBodyInventario.innerHTML = '';
            
            if (datos.length === 0) {
                sinDatosMensaje.style.display = 'block';
                tablaContainer.style.display = 'none';
                paginacionInfo.textContent = 'Mostrando 0-0 de 0 registros';
                return;
            }
            
            sinDatosMensaje.style.display = 'none';
            tablaContainer.style.display = 'block';
            
            // Actualizar resumen
            actualizarResumen(datos);
            
            // Cargar datos paginados
            const pageData = getCurrentPageData(datos);
            
            pageData.forEach(item => {
                const row = document.createElement('tr');
                
                row.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.id}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.tipo}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.modelo}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; text-align: center;">${item.año}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; text-align: right;">${item.horometro}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.proyecto ? item.proyecto + ' - ' + item.proyectoNombre : 'No asignado'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge-equipo ${getStatusBadgeClass(item.status)}">${item.status}</span></td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetalleEquipo('${item.id}')"></i>
                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" onclick="editarEquipo('${item.id}')"></i>
                            <i class="fas fa-tasks" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Asignar" onclick="abrirModalAsignacion('${item.id}')"></i>
                        </div>
                    </td>
                `;
                
                tablaBodyInventario.appendChild(row);
            });
            
            actualizarPaginacion(datos.length);
        }
        
        // Función para filtrar datos
        function filtrarDatos() {
            let datosFiltrados = [...inventarioData];
            
            // Filtrar por tipo
            const tipo = selectorTipo.value;
            if (tipo) {
                datosFiltrados = datosFiltrados.filter(e => e.tipo === tipo);
            }
            
            // Filtrar por status
            const status = selectorStatus.value;
            if (status) {
                datosFiltrados = datosFiltrados.filter(e => e.status === status);
            }
            
            // Filtrar por proyecto
            const proyecto = selectorProyecto.value;
            if (proyecto) {
                datosFiltrados = datosFiltrados.filter(e => e.proyecto === proyecto);
            }
            
            // Filtrar por búsqueda
            const busqueda = buscador.value.toLowerCase();
            if (busqueda) {
                datosFiltrados = datosFiltrados.filter(e => 
                    e.id.toLowerCase().includes(busqueda) ||
                    e.tipo.toLowerCase().includes(busqueda) ||
                    e.modelo.toLowerCase().includes(busqueda)
                );
            }
            
            datosOriginales = datosFiltrados;
            currentPage = 1;
            cargarTablaInventario(datosFiltrados);
        }
        
        // Event Listeners para filtros
        selectorTipo.addEventListener('change', filtrarDatos);
        selectorStatus.addEventListener('change', filtrarDatos);
        selectorProyecto.addEventListener('change', filtrarDatos);
        buscador.addEventListener('input', filtrarDatos);
        
        // Cambio de pestañas
        maquinariaTabs.forEach((tab, index) => {
            tab.addEventListener('click', function() {
                maquinariaTabs.forEach(t => {
                    t.classList.remove('active');
                    t.style.backgroundColor = '#e9ecef';
                    t.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                maquinariaContents.forEach(content => content.style.display = 'none');
                maquinariaContents[index].style.display = 'block';
            });
        });
        
        // Paginación
        function cambiarPagina(delta) {
            const totalPages = Math.ceil(datosOriginales.length / rowsPerPage);
            const nuevaPagina = currentPage + delta;
            
            if (nuevaPagina >= 1 && nuevaPagina <= totalPages) {
                currentPage = nuevaPagina;
                cargarTablaInventario(datosOriginales);
            }
        }
        
        btnPrimera.addEventListener('click', () => {
            if (datosOriginales.length > 0) {
                currentPage = 1;
                cargarTablaInventario(datosOriginales);
            }
        });
        
        btnAnterior.addEventListener('click', () => cambiarPagina(-1));
        btnSiguiente.addEventListener('click', () => cambiarPagina(1));
        
        btnUltima.addEventListener('click', () => {
            if (datosOriginales.length > 0) {
                currentPage = Math.ceil(datosOriginales.length / rowsPerPage);
                cargarTablaInventario(datosOriginales);
            }
        });
        
        // Modal Asignar Equipo
        function abrirModalAsignacion(equipoId = null) {
            modalAsignarEquipo.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            
            if (equipoId) {
                // Pre-seleccionar equipo si se proporciona
                const selectEquipo = document.getElementById('modalEquipo');
                for (let i = 0; i < selectEquipo.options.length; i++) {
                    if (selectEquipo.options[i].value === equipoId) {
                        selectEquipo.selectedIndex = i;
                        break;
                    }
                }
            }
        }
        
        window.abrirModalAsignacion = abrirModalAsignacion;
        
        function cerrarModalAsignacion() {
            modalAsignarEquipo.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        btnAsignarEquipo.addEventListener('click', () => abrirModalAsignacion());
        btnNuevaAsignacion?.addEventListener('click', () => abrirModalAsignacion());
        
        btnCerrarModalAsignacion.addEventListener('click', cerrarModalAsignacion);
        btnCancelarAsignacion.addEventListener('click', cerrarModalAsignacion);
        
        // Cerrar modal al hacer clic fuera
        window.addEventListener('click', function(event) {
            if (event.target === modalAsignarEquipo) {
                cerrarModalAsignacion();
            }
        });
        
        // Guardar asignación
        btnGuardarAsignacion.addEventListener('click', function() {
            const equipo = document.getElementById('modalEquipo').value;
            const proyecto = document.getElementById('modalProyecto').value;
            const fechaInicio = document.getElementById('modalFechaInicio').value;
            
            if (!equipo || !proyecto || !fechaInicio) {
                alert('Por favor complete los campos requeridos');
                return;
            }
            
            alert('Equipo asignado correctamente');
            cerrarModalAsignacion();
        });
        
        // Botones de acción adicionales
        btnRegistrarMantenimiento.addEventListener('click', () => alert('Registrar mantenimiento - Funcionalidad en desarrollo'));
        
        btnAgregarEquipo.addEventListener('click', () => alert('Agregar nuevo equipo - Funcionalidad en desarrollo'));
        
        btnExcel.addEventListener('click', () => {
            alert('Exportando a Excel...');
        });
        
        btnVerTodos.addEventListener('click', () => {
            selectorTipo.value = '';
            selectorStatus.value = '';
            selectorProyecto.value = '';
            buscador.value = '';
            datosOriginales = [...inventarioData];
            currentPage = 1;
            cargarTablaInventario(datosOriginales);
        });
        
        // Funciones globales para acciones
        window.verDetalleEquipo = function(id) {
            alert(`Ver detalle de equipo ${id}`);
        };
        
        window.editarEquipo = function(id) {
            alert(`Editar equipo ${id}`);
        };
        
        // Filtros en encabezados
        document.querySelectorAll('.table th i.fa-filter').forEach(icon => {
            icon.addEventListener('click', () => alert('Filtro de columna - Funcionalidad en desarrollo'));
        });
        
        cargarTablaInventario(inventarioData);
    });
</script>
@endsection