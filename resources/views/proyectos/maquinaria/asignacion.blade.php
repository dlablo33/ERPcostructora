@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Maquinaria y Equipo
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE ESTADÍSTICAS -->
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
                        <div style="position: relative; min-width: 200px;" id="proyectoFilterContainer">
                            <button type="button" id="btnFiltroProyectos" style="width: 100%; padding: 6px 12px; border: 1px solid #ced4da; border-radius: 4px; background-color: white; cursor: pointer; font-size: 14px; display: flex; justify-content: space-between; align-items: center; min-height: 38px;">
                                <span id="filtroProyectosLabel">Todos los proyectos</span>
                                <i class="fas fa-chevron-down" style="color: #6c757d; font-size: 12px;"></i>
                            </button>
                            <div id="filtroProyectosDropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ced4da; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 1000; max-height: 280px; overflow: hidden; padding: 8px 0; margin-top: 2px;">
                                <div style="padding: 0 12px 8px 12px; border-bottom: 1px solid #e9ecef;">
                                    <input type="text" id="filtroProyectosBuscar" placeholder="Buscar proyecto..." style="width: 100%; padding: 6px 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                </div>
                                <div id="filtroProyectosLista" style="max-height: 180px; overflow-y: auto; padding: 8px 0;"></div>
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
                            <option value="Disponible">✅ Disponible</option>
                            <option value="Asignado">🔧 Asignado</option>
                            <option value="En mantenimiento">🛠️ En Mantenimiento</option>
                            <option value="Dado de baja">❌ Dado de Baja</option>
                        </select>
                    </div>

                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <button id="btnAsignarEquipo" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                                <i class="fas fa-tasks"></i> Asignar Equipo
                            </button>
                        </div>
                        <div>
                            <button id="btnRegistrarMantenimiento" style="background-color: white; border: 1px solid #ffc107; color: #ffc107; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                                <i class="fas fa-tools"></i> Mantenimiento
                            </button>
                        </div>
                        <div>
                            <button id="btnAgregarEquipo" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #083CAE; font-size: 16px;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div>
                            <button id="btnExcel" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;">
                                <i class="fas fa-file-excel"></i> Exportar
                            </button>
                        </div>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar equipo..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Pestañas -->
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

                <!-- Sin datos -->
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
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">Código</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">Nombre</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">Tipo</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">Marca/Modelo</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">Año</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">Horómetro</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">Proyecto</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">Estado</th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodyInventario"></tbody>
                        </table>
                    </div>

                    <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px;">
                        <div style="visibility: hidden;"></div>
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <button id="btnPrimera" style="padding: 5px 10px; border: none; background: none; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-double-left"></i></button>
                            <button id="btnAnterior" style="padding: 5px 10px; border: none; background: none; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-left"></i></button>
                            <span id="paginaActual" style="padding: 5px 12px; background-color: #2378e1; color: white; border-radius: 4px;">1</span>
                            <span id="totalPaginas" style="margin-left: 5px; color: #6c757d;">de 1</span>
                            <button id="btnSiguiente" style="padding: 5px 10px; border: none; background: none; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-right"></i></button>
                            <button id="btnUltima" style="padding: 5px 10px; border: none; background: none; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-double-right"></i></button>
                            <span id="paginacionInfo" style="margin-left: 10px; color: #2378e1;"></span>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 2: ASIGNACIÓN -->
                <div id="tab-asignacion" class="maquinaria-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
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

                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
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
                                <tbody id="tablaAsignaciones"></tbody>
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
                            <tbody id="tablaMantenimientos"></tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 4: COMBUSTIBLE -->
                <div id="tab-combustible" class="maquinaria-content" style="display: none;">
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
                            <button id="btnLimpiarFiltrosComb" style="background-color: white; color: #6c757d; border: 1px solid #6c757d; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px;">
                                <i class="fas fa-times"></i> Limpiar
                            </button>
                        </div>
                        <div>
                            <button id="btnRegistrarCarga" style="background-color: #28a745; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
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
                                    <div style="font-size: 12px; color: #6c757d;">Consumo (Filtro)</div>
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
                                    <div style="font-size: 12px; color: #6c757d;">Costo (Filtro)</div>
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
                                    <div style="font-size: 12px; color: #6c757d;">Precio Prom. (Filtro)</div>
                                    <div style="font-size: 24px; font-weight: bold; color: #28a745;" id="totalRendimientoProm">$0/L</div>
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
                            <tbody id="tablaCombustible"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ============================================================ -->
<!-- MODAL: ASIGNAR EQUIPO -->
<!-- ============================================================ -->
<div id="modalAsignarEquipo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-tasks"></i> Asignar Equipo a Proyecto</h3>
            <button type="button" data-close-modal="modalAsignarEquipo" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%;">&times;</button>
        </div>
        <div style="padding: 20px;">
            <form id="formAsignarEquipo">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Equipo <span style="color: #dc3545;">*</span></label>
                    <select id="modalAsignacionEquipo" name="activo_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        <option value="">Seleccionar equipo...</option>
                    </select>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Proyecto <span style="color: #dc3545;">*</span></label>
                    <select id="modalProyecto" name="proyecto_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        <option value="">Seleccionar proyecto...</option>
                    </select>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Responsable</label>
                    <select id="modalResponsable" name="responsable_asignado_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        <option value="">Seleccionar responsable...</option>
                    </select>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Fecha Inicio <span style="color: #dc3545;">*</span></label>
                        <input type="date" id="modalFechaInicio" name="fecha_salida" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Fecha Estimada Fin</label>
                        <input type="date" id="modalFechaFin" name="fecha_estimada_devolucion" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Horómetro Salida</label>
                        <input type="number" id="modalHorometro" name="horometro_salida" step="0.1" min="0" placeholder="0.0" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Condición Salida</label>
                        <select id="modalCondicion" name="condicion_salida" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="Excelente">Excelente</option>
                            <option value="Bueno" selected>Bueno</option>
                            <option value="Regular">Regular</option>
                            <option value="Malo">Malo</option>
                        </select>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Observaciones</label>
                    <textarea id="modalObservacionesAsignacion" name="observaciones" rows="2" placeholder="Notas adicionales..." style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #dee2e6; padding-top: 20px;">
                    <button type="button" data-close-modal="modalAsignarEquipo" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cancelar</button>
                    <button type="submit" style="padding: 8px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;"><i class="fas fa-save"></i> Asignar Equipo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODAL: EDITAR ASIGNACIÓN -->
<!-- ============================================================ -->
<div id="modalEditarAsignacion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-edit"></i> Editar Asignación</h3>
            <button type="button" data-close-modal="modalEditarAsignacion" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%;">&times;</button>
        </div>
        <div style="padding: 20px;">
            <form id="formEditarAsignacion">
                <input type="hidden" id="editAsignacionId">

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Equipo</label>
                    <input type="text" id="editAsignacionEquipo" readonly style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; background-color: #f8f9fa;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Proyecto <span style="color: #dc3545;">*</span></label>
                    <select id="editAsignacionProyecto" name="proyecto_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        <option value="">Seleccionar proyecto...</option>
                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Responsable</label>
                    <select id="editAsignacionResponsable" name="responsable_asignado_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        <option value="">Sin responsable</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Fecha Inicio <span style="color: #dc3545;">*</span></label>
                        <input type="date" id="editAsignacionFechaInicio" name="fecha_salida" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Fecha Estimada Fin</label>
                        <input type="date" id="editAsignacionFechaFin" name="fecha_estimada_devolucion" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Horómetro Salida</label>
                        <input type="number" id="editAsignacionHorometro" name="horometro_salida" step="0.1" min="0" placeholder="0.0" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Condición Salida</label>
                        <select id="editAsignacionCondicion" name="condicion_salida" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="Excelente">Excelente</option>
                            <option value="Bueno" selected>Bueno</option>
                            <option value="Regular">Regular</option>
                            <option value="Malo">Malo</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Observaciones</label>
                    <textarea id="editAsignacionObservaciones" name="observaciones_salida" rows="2" placeholder="Notas adicionales..." style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #dee2e6; padding-top: 20px;">
                    <button type="button" data-close-modal="modalEditarAsignacion" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cancelar</button>
                    <button type="submit" style="padding: 8px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;"><i class="fas fa-save"></i> Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODAL: DEVOLVER EQUIPO -->
<!-- ============================================================ -->
<div id="modalDevolverEquipo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-undo"></i> Devolver Equipo</h3>
            <button type="button" data-close-modal="modalDevolverEquipo" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%;">&times;</button>
        </div>
        <div style="padding: 20px;">
            <form id="formDevolverEquipo">
                <input type="hidden" id="devolverAsignacionId">

                <div style="margin-bottom: 15px; padding: 12px; background-color: #e8f0fe; border-radius: 8px; border-left: 4px solid #083CAE;">
                    <div style="font-size: 13px; color: #495057;">
                        <strong>Equipo:</strong> <span id="devolverEquipoInfo">-</span>
                    </div>
                    <div style="font-size: 13px; color: #495057; margin-top: 4px;">
                        <strong>Proyecto:</strong> <span id="devolverProyectoInfo">-</span>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Fecha Devolución <span style="color: #dc3545;">*</span></label>
                        <input type="date" id="devolverFecha" name="fecha_devolucion_real" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Condición Devolución <span style="color: #dc3545;">*</span></label>
                        <select id="devolverCondicion" name="condicion_devolucion" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="Excelente">Excelente</option>
                            <option value="Bueno" selected>Bueno</option>
                            <option value="Regular">Regular</option>
                            <option value="Malo">Malo</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Horómetro Devolución</label>
                        <input type="number" id="devolverHorometro" name="horometro_devolucion" step="0.1" min="0" placeholder="0.0" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Kilometraje Devolución</label>
                        <input type="number" id="devolverKilometraje" name="kilometraje_devolucion" step="0.1" min="0" placeholder="0.0" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Observaciones</label>
                    <textarea id="devolverObservaciones" name="observaciones" rows="3" placeholder="Observaciones de la devolución..." style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>

                <div id="devolverReporteDanos" style="display: none; margin-bottom: 15px; padding: 12px; background-color: #fff3cd; border-radius: 8px; border-left: 4px solid #ffc107;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #856404;">Reporte de Daños</label>
                    <textarea id="devolverReporteDanosTxt" name="reporte_danos" rows="2" placeholder="Describe los daños..." style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                    <label style="display: block; margin-top: 10px; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #856404;">Costo de Reparación</label>
                    <input type="number" id="devolverCostoReparacion" name="costo_reparacion" step="0.01" min="0" placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #dee2e6; padding-top: 20px;">
                    <button type="button" data-close-modal="modalDevolverEquipo" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cancelar</button>
                    <button type="submit" style="padding: 8px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;"><i class="fas fa-check"></i> Confirmar Devolución</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODAL: AGREGAR / EDITAR EQUIPO -->
<!-- ============================================================ -->
<div id="modalNuevoEquipo" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0,0,0,0.6); z-index: 999999 !important; align-items: center; justify-content: center; overflow: auto;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 700px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); border-radius: 12px 12px 0 0;">
            <h3 id="modalEquipoTitulo" style="margin: 0; color: white;"><i class="fas fa-plus-circle"></i> Nuevo Equipo</h3>
            <button type="button" data-close-modal="modalNuevoEquipo" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%;">&times;</button>
        </div>
        <div style="padding: 20px;">
            <form id="formEquipo">
                <input type="hidden" id="editEquipoId">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Nombre <span style="color: #dc3545;">*</span></label>
                        <input type="text" id="campoNombre" name="nombre" required placeholder="Nombre del equipo" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Tipo <span style="color: #dc3545;">*</span></label>
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
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Marca</label>
                        <input type="text" id="campoMarca" name="marca" placeholder="Marca" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Modelo</label>
                        <input type="text" id="campoModelo" name="modelo" placeholder="Modelo" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Año</label>
                        <input type="number" id="campoAnio" name="anio" placeholder="2024" min="1900" max="2030" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Serie</label>
                        <input type="text" id="campoSerie" name="serie" placeholder="Número de serie" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Costo Adquisición</label>
                        <input type="number" id="campoCosto" name="costo_adquisicion" step="0.01" min="0" placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Costo Operación/hora</label>
                        <input type="number" id="campoCostoOperacion" name="costo_operacion_hora" step="0.01" min="0" placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Descripción</label>
                    <textarea id="campoDescripcion" name="descripcion" rows="2" placeholder="Descripción del equipo" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #dee2e6; padding-top: 20px;">
                    <button type="button" data-close-modal="modalNuevoEquipo" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cancelar</button>
                    <button type="submit" style="padding: 8px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;"><i class="fas fa-save"></i> Guardar Equipo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODAL: REGISTRAR MANTENIMIENTO -->
<!-- ============================================================ -->
<div id="modalMantenimiento" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%); border-radius: 12px 12px 0 0;">
            <h3 id="modalMantTitulo" style="margin: 0; color: white;"><i class="fas fa-tools"></i> Registrar Mantenimiento</h3>
            <button type="button" data-close-modal="modalMantenimiento" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%;">&times;</button>
        </div>
        <div style="padding: 20px;">
            <form id="formMantenimiento">
                <input type="hidden" id="editMantId">
                <input type="hidden" id="modoMantenimiento" value="registrar">

                <div id="bloqueProgramar" style="margin-bottom: 15px; padding: 10px; background-color: #fff3cd; border-radius: 6px; border-left: 4px solid #ffc107;">
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: #856404; cursor: pointer;">
                        <input type="checkbox" id="chkProgramarMant" style="cursor: pointer;">
                        Programar mantenimiento (no cambia el estado del equipo hasta iniciarlo)
                    </label>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Equipo <span style="color: #dc3545;">*</span></label>
                        <select id="modalMantEquipo" name="activo_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar equipo...</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Tipo Mant. <span style="color: #dc3545;">*</span></label>
                        <select id="modalMantTipo" name="tipo_mantenimiento" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="preventivo">Preventivo</option>
                            <option value="correctivo">Correctivo</option>
                            <option value="predictivo">Predictivo</option>
                        </select>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Descripción <span style="color: #dc3545;">*</span></label>
                    <textarea id="modalMantDescripcion" name="descripcion" rows="2" placeholder="Descripción del trabajo a realizar" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Fecha Inicio <span style="color: #dc3545;">*</span></label>
                        <input type="date" id="modalMantFechaInicio" name="fecha_inicio" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Fecha Fin Estimada</label>
                        <input type="date" id="modalMantFechaFinEstimada" name="fecha_fin_estimada" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Costo Estimado</label>
                        <input type="number" id="modalMantCosto" name="costo" step="0.01" min="0" placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Prioridad</label>
                        <select id="modalMantPrioridad" name="prioridad" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="baja">Baja</option>
                            <option value="media" selected>Media</option>
                            <option value="alta">Alta</option>
                        </select>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Responsable</label>
                    <select id="modalMantResponsable" name="responsable_asignado" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        <option value="">Sin responsable asignado</option>
                    </select>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #dee2e6; padding-top: 20px;">
                    <button type="button" data-close-modal="modalMantenimiento" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cancelar</button>
                    <button type="submit" style="padding: 8px 20px; background-color: #ffc107; color: #856404; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;"><i class="fas fa-save"></i> Guardar Mantenimiento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODAL: CERRAR MANTENIMIENTO -->
<!-- ============================================================ -->
<div id="modalCerrarMantenimiento" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 500px;">
        <div style="padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-check-circle"></i> Finalizar Mantenimiento</h3>
            <button type="button" data-close-modal="modalCerrarMantenimiento" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%;">&times;</button>
        </div>
        <form id="formCerrarMantenimiento" style="padding: 20px;">
            <input type="hidden" id="cerrarMantId">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Fecha Fin <span style="color: #dc3545;">*</span></label>
                <input type="date" id="cerrarMantFechaFin" name="fecha_fin" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Costo Final</label>
                <input type="number" id="cerrarMantCostoFinal" name="costo_real" step="0.01" min="0" placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Observaciones de cierre</label>
                <textarea id="cerrarMantObservaciones" name="observaciones" rows="3" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #dee2e6; padding-top: 15px;">
                <button type="button" data-close-modal="modalCerrarMantenimiento" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cancelar</button>
                <button type="submit" style="padding: 8px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;"><i class="fas fa-check"></i> Finalizar</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODAL: REGISTRAR COMBUSTIBLE -->
<!-- ============================================================ -->
<div id="modalCombustible" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); border-radius: 12px 12px 0 0;">
            <h3 id="modalCombTitulo" style="margin: 0; color: white;"><i class="fas fa-gas-pump"></i> Registrar Carga de Combustible</h3>
            <button type="button" data-close-modal="modalCombustible" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%;">&times;</button>
        </div>
        <div style="padding: 20px;">
            <form id="formCombustible">
                <input type="hidden" id="editCombId">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Equipo <span style="color: #dc3545;">*</span></label>
                    <select id="modalCombustibleEquipo" name="activo_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        <option value="">Seleccionar equipo...</option>
                    </select>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Fecha <span style="color: #dc3545;">*</span></label>
                        <input type="date" id="modalCombustibleFecha" name="fecha" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Litros <span style="color: #dc3545;">*</span></label>
                        <input type="number" id="modalCombustibleLitros" name="litros" step="0.01" min="0.01" placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Costo Total <span style="color: #dc3545;">*</span></label>
                        <input type="number" id="modalCombustibleCosto" name="costo" step="0.01" min="0.01" placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Horómetro</label>
                        <input type="number" id="modalCombustibleHorometro" name="horometro" step="0.1" min="0" placeholder="0.0" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Proyecto</label>
                        <select id="modalCombustibleProyecto" name="proyecto_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Sin proyecto</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Operador</label>
                        <select id="modalCombustibleOperador" name="operador_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Sin operador</option>
                        </select>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Factura</label>
                        <input type="text" id="modalCombustibleFactura" name="factura" placeholder="Número de factura" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Proveedor</label>
                        <select id="modalCombustibleProveedor" name="proveedor_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Sin proveedor</option>
                        </select>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Observaciones</label>
                    <textarea id="modalCombustibleObservaciones" name="observaciones" rows="2" placeholder="Observaciones adicionales" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #dee2e6; padding-top: 20px;">
                    <button type="button" data-close-modal="modalCombustible" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cancelar</button>
                    <button type="submit" style="padding: 8px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;"><i class="fas fa-save"></i> Guardar</button>
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
    #tablaBodyInventario td:last-child { background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1); z-index: 15; }

    .badge-equipo { font-size: 11px; padding: 4px 8px; border-radius: 4px; display: inline-block; font-weight: 600; }
    .badge-activo { background-color: #d4edda; color: #28a745; }
    .badge-mantenimiento { background-color: #f8d7da; color: #dc3545; }
    .badge-disponible { background-color: #cce5ff; color: #0d6efd; }
    .badge-asignado { background-color: #d4edda; color: #28a745; }
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

    #paginacionContainer { background: transparent !important; }
    #paginacionContainer span[style*="background-color"] { background-color: #2378e1 !important; }
    #paginacionContainer button { background: transparent !important; border: none !important; color: #2378e1 !important; cursor: pointer; }

    .action-icon { cursor: pointer; font-size: 14px; padding: 4px; }

    @media (max-width: 768px) {
        input[type="date"] { width: 100% !important; }
        input#buscador { width: 100% !important; }
        #proyectoFilterContainer { min-width: 100% !important; }
        #filtroProyectosDropdown { min-width: 100% !important; }
        #paginacionContainer { flex-direction: column; align-items: flex-start; }
        #modalAsignarEquipo > div, #modalEditarAsignacion > div, #modalDevolverEquipo > div, #modalNuevoEquipo > div, #modalMantenimiento > div, #modalCombustible > div { width: 95%; margin: 10px; }
        .maquinaria-tab { padding: 8px 12px !important; font-size: 12px !important; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
/* =====================================================================
   CONFIGURACIÓN Y ESTADO GLOBAL
   ===================================================================== */
const API_BASE = '/proyectos/maquinaria';
const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

let currentPage = 1;
let totalPages = 1;
let currentTab = 'inventario';
let proyectosLista = [];
let catalogosCargados = false;
let equiposDisponibles = [];
let todosEquipos = [];
let responsablesLista = [];
let operadoresLista = [];
let proveedoresLista = [];

let currentFilters = {
    busqueda: '',
    tipo: '',
    estatus: '',
    proyecto_id: [],
    page: 1,
    per_page: 10
};

/* =====================================================================
   HELPERS
   ===================================================================== */
function mostrarLoading(show) {
    const el = document.getElementById('loadingSpinner');
    if (el) el.style.display = show ? 'flex' : 'none';
}

function mostrarNotificacion(mensaje, tipo = 'success') {
    document.querySelectorAll('.toast-notification').forEach(el => el.remove());
    const n = document.createElement('div');
    n.className = `toast-notification ${tipo}`;
    const icono = tipo === 'success' ? 'fa-check-circle' : tipo === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    n.innerHTML = `<i class="fas ${icono}"></i> ${mensaje}`;
    document.body.appendChild(n);
    setTimeout(() => n.remove(), 3000);
}

function formatDate(d) {
    if (!d) return '-';
    try { return new Date(d).toLocaleDateString('es-MX'); } catch { return '-'; }
}

/* ✅ FIX: normaliza el estatus a minúsculas para el badge */
function getStatusBadge(s) {
    const key = (s || '').toString().toLowerCase().trim();
    const b = {
        'activo': 'badge-activo',
        'activa': 'badge-activo',
        'asignado': 'badge-asignado',
        'asignada': 'badge-asignado',
        'disponible': 'badge-disponible',
        'mantenimiento': 'badge-mantenimiento',
        'en mantenimiento': 'badge-mantenimiento',
        'inactivo': 'badge-inactivo',
        'baja': 'badge-baja',
        'dado de baja': 'badge-baja'
    };
    return b[key] || 'badge-equipo';
}

function getMantenimientoStatusBadge(s) {
    const key = (s || '').toString().toLowerCase();
    const b = {
        pendiente: 'badge-mant-pendiente',
        en_proceso: 'badge-mant-en-proceso',
        completado: 'badge-mant-completado',
        cancelado: 'badge-mant-cancelado'
    };
    return b[key] || 'badge-mant-pendiente';
}

function abrirModal(id) {
    const m = document.getElementById(id);
    if (m) {
        m.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function cerrarModal(id) {
    const m = document.getElementById(id);
    if (!m) return;
    if (id.startsWith('modalDetalle')) {
        m.remove();
    } else {
        m.style.display = 'none';
    }
    document.body.style.overflow = 'auto';
}

/* =====================================================================
   CATÁLOGOS
   ===================================================================== */
async function cargarCatalogos() {
    try {
        const r = await fetch(`${API_BASE}/catalogos`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        });
        const result = await r.json();
        console.log('📦 Catálogos recibidos:', result);

        if (result.success) {
            const data = result.data;
            equiposDisponibles = data.equipos || [];
            todosEquipos = data.todos_equipos || data.equipos || [];
            proyectosLista = data.proyectos || [];
            responsablesLista = data.responsables || [];
            operadoresLista = data.operadores || [];
            proveedoresLista = data.proveedores || [];

            console.log('📋 Equipos disponibles:', equiposDisponibles.length);
            console.log('📋 Todos los equipos:', todosEquipos.length);
            console.log('📋 Proyectos:', proyectosLista.length);

            llenarSelectAsignacion(true);
            llenarSelectMantenimiento(true);
            llenarSelectCombustible(true);
            llenarSelectProyectos(data.proyectos || [], true);
            llenarSelectResponsables(data.responsables || [], true);
            llenarSelectOperadores(data.operadores || [], true);
            llenarSelectProveedores(data.proveedores || [], true);
            llenarSelectMantResponsable(data.responsables || [], true);

            renderizarCheckboxesProyectos(proyectosLista);
            catalogosCargados = true;
        } else {
            console.error('❌ Catálogos devolvieron success=false:', result);
        }
    } catch (e) {
        console.error('❌ Error cargando catálogos:', e);
        mostrarNotificacion('Error al cargar catálogos', 'error');
    }
}

/* ✅ FIX: SOLO equipos disponibles para asignación */
function llenarSelectAsignacion(force = false) {
    const s = document.getElementById('modalAsignacionEquipo');
    if (!s) return;

    if (!force && s.querySelectorAll('option').length > 1) {
        return;
    }

    const valorPrevio = s.value;
    s.innerHTML = '<option value="">Seleccionar equipo...</option>';

    const fuente = equiposDisponibles || [];

    console.log('📋 Poblando select de ASIGNACIÓN con', fuente.length, 'equipos disponibles (force=' + force + ')');

    if (fuente.length === 0) {
        const opt = document.createElement('option');
        opt.disabled = true;
        opt.textContent = 'No hay equipos disponibles para asignar';
        s.appendChild(opt);
        return;
    }

    fuente.forEach(e => {
        const o = document.createElement('option');
        o.value = e.id;
        const tipo = e.tipo_nombre || e.tipo || e.tipo_activo || 'Equipo';
        o.textContent = `${e.codigo || ''} - ${e.nombre || ''} (${tipo})`;
        s.appendChild(o);
    });

    if (valorPrevio) s.value = valorPrevio;
}

function llenarSelectMantenimiento(force = false) {
    const s = document.getElementById('modalMantEquipo');
    if (!s) return;
    if (!force && s.querySelectorAll('option').length > 1) return;

    const valorPrevio = s.value;
    s.innerHTML = '<option value="">Seleccionar equipo...</option>';

    const fuente = (todosEquipos && todosEquipos.length > 0) ? todosEquipos : (equiposDisponibles || []);
    if (fuente.length === 0) {
        const opt = document.createElement('option');
        opt.disabled = true;
        opt.textContent = 'No hay equipos disponibles';
        s.appendChild(opt);
        return;
    }
    fuente.forEach(e => {
        const o = document.createElement('option');
        o.value = e.id;
        const tipo = e.tipo_nombre || e.tipo || e.tipo_activo || 'Equipo';
        o.textContent = `${e.codigo || ''} - ${e.nombre || ''} (${tipo})`;
        s.appendChild(o);
    });
    if (valorPrevio) s.value = valorPrevio;
}

function llenarSelectCombustible(force = false) {
    const fuente = (todosEquipos && todosEquipos.length > 0) ? todosEquipos : (equiposDisponibles || []);

    const sm = document.getElementById('modalCombustibleEquipo');
    if (sm && (force || sm.querySelectorAll('option').length <= 1)) {
        const vp = sm.value;
        sm.innerHTML = '<option value="">Seleccionar equipo...</option>';
        if (fuente.length === 0) {
            const opt = document.createElement('option');
            opt.disabled = true;
            opt.textContent = 'No hay equipos disponibles';
            sm.appendChild(opt);
        } else {
            fuente.forEach(e => {
                const o = document.createElement('option');
                o.value = e.id;
                const tipo = e.tipo_nombre || e.tipo || e.tipo_activo || 'Equipo';
                o.textContent = `${e.codigo || ''} - ${e.nombre || ''} (${tipo})`;
                sm.appendChild(o);
            });
        }
        if (vp) sm.value = vp;
    }

    const sf = document.getElementById('selectorCombustibleEquipo');
    if (sf && (force || sf.querySelectorAll('option').length <= 1)) {
        const vp = sf.value;
        sf.innerHTML = '<option value="">Todos los equipos</option>';
        fuente.forEach(e => {
            const o = document.createElement('option');
            o.value = e.id;
            o.textContent = `${e.codigo || ''} - ${e.nombre || ''}`;
            sf.appendChild(o);
        });
        if (vp) sf.value = vp;
    }
}

function llenarSelectProyectos(proyectos, force = false) {
    const lista = proyectos || proyectosLista || [];

    // Modal de asignación
    const a = document.getElementById('modalProyecto');
    if (a && (force || a.querySelectorAll('option').length <= 1)) {
        const vp = a.value;
        a.innerHTML = '<option value="">Seleccionar proyecto...</option>';
        lista.forEach(p => {
            const o = document.createElement('option');
            o.value = p.id;
            o.textContent = p.nombre;
            a.appendChild(o);
        });
        if (vp) a.value = vp;
    }

    // Modal de edición de asignación
    const e = document.getElementById('editAsignacionProyecto');
    if (e && (force || e.querySelectorAll('option').length <= 1)) {
        const vp = e.value;
        e.innerHTML = '<option value="">Seleccionar proyecto...</option>';
        lista.forEach(p => {
            const o = document.createElement('option');
            o.value = p.id;
            o.textContent = p.nombre;
            e.appendChild(o);
        });
        if (vp) e.value = vp;
    }

    // Modal de combustible
    const c = document.getElementById('modalCombustibleProyecto');
    if (c && (force || c.querySelectorAll('option').length <= 1)) {
        const vp = c.value;
        c.innerHTML = '<option value="">Sin proyecto</option>';
        lista.forEach(p => {
            const o = document.createElement('option');
            o.value = p.id;
            o.textContent = p.nombre;
            c.appendChild(o);
        });
        if (vp) c.value = vp;
    }
}

function llenarSelectResponsables(rs, force = false) {
    const lista = rs || responsablesLista || [];

    // Modal de asignación
    const s = document.getElementById('modalResponsable');
    if (s && (force || s.querySelectorAll('option').length <= 1)) {
        const vp = s.value;
        s.innerHTML = '<option value="">Seleccionar responsable...</option>';
        lista.forEach(r => {
            const o = document.createElement('option');
            o.value = r.id;
            o.textContent = r.nombre_completo;
            s.appendChild(o);
        });
        if (vp) s.value = vp;
    }

    // Modal de edición de asignación
    const e = document.getElementById('editAsignacionResponsable');
    if (e && (force || e.querySelectorAll('option').length <= 1)) {
        const vp = e.value;
        e.innerHTML = '<option value="">Sin responsable</option>';
        lista.forEach(r => {
            const o = document.createElement('option');
            o.value = r.id;
            o.textContent = r.nombre_completo;
            e.appendChild(o);
        });
        if (vp) e.value = vp;
    }
}

function llenarSelectOperadores(os, force = false) {
    const s = document.getElementById('modalCombustibleOperador');
    if (!s) return;
    if (!force && s.querySelectorAll('option').length > 1) return;

    const lista = os || operadoresLista || [];
    const vp = s.value;
    s.innerHTML = '<option value="">Sin operador</option>';
    lista.forEach(o => {
        const op = document.createElement('option');
        op.value = o.id;
        op.textContent = o.nombre_completo;
        s.appendChild(op);
    });
    if (vp) s.value = vp;
}

function llenarSelectProveedores(ps, force = false) {
    const s = document.getElementById('modalCombustibleProveedor');
    if (!s) return;
    if (!force && s.querySelectorAll('option').length > 1) return;

    const lista = ps || proveedoresLista || [];
    const vp = s.value;
    s.innerHTML = '<option value="">Sin proveedor</option>';
    lista.forEach(p => {
        const o = document.createElement('option');
        o.value = p.id;
        o.textContent = p.nombre;
        s.appendChild(o);
    });
    if (vp) s.value = vp;
}

function llenarSelectMantResponsable(rs, force = false) {
    const s = document.getElementById('modalMantResponsable');
    if (!s) return;
    if (!force && s.querySelectorAll('option').length > 1) return;

    const lista = rs || responsablesLista || [];
    const vp = s.value;
    s.innerHTML = '<option value="">Sin responsable asignado</option>';
    lista.forEach(r => {
        const o = document.createElement('option');
        o.value = r.nombre_completo;
        o.textContent = r.nombre_completo;
        s.appendChild(o);
    });
    if (vp) s.value = vp;
}

/* =====================================================================
   FILTRO DE PROYECTOS
   ===================================================================== */
function getProyectosSeleccionados() {
    return Array.from(document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]:checked')).map(c => c.value).filter(v => v);
}

function actualizarLabelProyectos() {
    const total = document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]').length;
    const sel = getProyectosSeleccionados().length;
    document.getElementById('filtroProyectosLabel').textContent =
        (sel === 0 || sel === total) ? 'Todos los proyectos' : `${sel} proyecto${sel > 1 ? 's' : ''} seleccionado${sel > 1 ? 's' : ''}`;
}

function renderizarCheckboxesProyectos(ps) {
    const l = document.getElementById('filtroProyectosLista');
    l.innerHTML = '';
    if (!ps.length) { l.innerHTML = '<div style="padding:8px 12px;color:#6c757d;font-size:13px;">Sin proyectos</div>'; return; }
    ps.forEach(p => {
        const label = document.createElement('label');
        label.innerHTML = `<input type="checkbox" value="${p.id}"><span>${p.nombre}</span>`;
        l.appendChild(label);
    });
    actualizarLabelProyectos();
}

/* =====================================================================
   CARGA DE DATOS
   ===================================================================== */
async function cargarActivos() {
    mostrarLoading(true);
    try {
        const ps = getProyectosSeleccionados();
        currentFilters.proyecto_id = ps;

        const params = new URLSearchParams();
        params.append('busqueda', currentFilters.busqueda || '');
        params.append('tipo', currentFilters.tipo || '');
        params.append('estatus', currentFilters.estatus || '');
        params.append('page', currentFilters.page || 1);
        params.append('per_page', currentFilters.per_page || 10);
        ps.forEach(id => params.append('proyecto_id[]', id));

        const r = await fetch(`${API_BASE}?${params}`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': CSRF }
        });
        const result = await r.json();

        if (result.success) {
            actualizarEstadisticas(result.estadisticas);
            renderizarTablaInventario(result.data.data || []);
            actualizarPaginacion(result.data);
            currentPage = result.data.current_page || 1;
            totalPages = result.data.last_page || 1;
        }
    } catch (e) {
        console.error(e);
        mostrarNotificacion('Error al cargar equipos', 'error');
    } finally {
        mostrarLoading(false);
    }
}

async function cargarAsignacionesActivas() {
    try {
        const r = await fetch(`${API_BASE}/asignaciones/activas`, { headers: { 'Accept': 'application/json' } });
        const result = await r.json();
        if (result.success) {
            renderizarTablaAsignaciones(result.data);
            actualizarResumenAsignaciones(result.data);
        }
    } catch (e) { console.error(e); }
}

async function cargarMantenimientos() {
    try {
        const e = document.getElementById('filtroMantEstatus')?.value || '';
        const t = document.getElementById('filtroMantTipo')?.value || '';
        const b = document.getElementById('filtroMantBusqueda')?.value || '';
        const p = new URLSearchParams();
        if (e) p.append('estatus', e);
        if (t) p.append('tipo', t);
        if (b) p.append('busqueda', b);

        const r = await fetch(`${API_BASE}/mantenimientos/list?${p}`, { headers: { 'Accept': 'application/json' } });
        const result = await r.json();

        if (result.success) {
            const data = Array.isArray(result.data) ? result.data : (result.data?.data || []);
            renderizarTablaMantenimientos(data);
            if (result.estadisticas) actualizarEstadisticasMantenimiento(result.estadisticas);
        }
    } catch (e) { console.error(e); }
}

async function cargarCombustible() {
    try {
        const a = document.getElementById('selectorCombustibleEquipo')?.value || '';
        const fi = document.getElementById('fechaCombustibleInicio')?.value || '';
        const ff = document.getElementById('fechaCombustibleFin')?.value || '';
        let url = `${API_BASE}/combustible/historial?per_page=100`;
        if (a) url += `&activo_id=${a}`;
        if (fi) url += `&fecha_inicio=${fi}`;
        if (ff) url += `&fecha_fin=${ff}`;

        const r = await fetch(url, { headers: { 'Accept': 'application/json' } });
        const result = await r.json();

        if (result.success) {
            const data = result.data.data || [];
            renderizarTablaCombustible(data);
            calcularResumenCombustible(data);
        }
    } catch (e) { console.error(e); }
}

/* =====================================================================
   RENDERIZADO
   ===================================================================== */
function renderizarTablaInventario(activos) {
    const tbody = document.getElementById('tablaBodyInventario');
    const sin = document.getElementById('sinDatosMensaje');
    const tc = document.getElementById('tablaContainer');
    tbody.innerHTML = '';

    if (!activos.length) { sin.style.display = 'block'; tc.style.display = 'none'; return; }
    sin.style.display = 'none'; tc.style.display = 'block';

    activos.forEach(item => {
        const badge = getStatusBadge(item.estatus);
        const hor = item.maquinaria?.horometro_actual ?? '-';
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.codigo}</td>
            <td>${item.nombre}</td>
            <td>${item.tipo_nombre || '-'}</td>
            <td>${item.marca || '-'} ${item.modelo || ''}</td>
            <td style="text-align:center;">${item.anio || '-'}</td>
            <td style="text-align:right;">${hor}</td>
            <td>${item.proyecto_asignado?.nombre || item.proyectoAsignado?.nombre || 'Disponible'}</td>
            <td><span class="badge-equipo ${badge}">${item.estatus_nombre || item.estatus}</span></td>
            <td style="background:white;position:sticky;right:0;">
                <div style="display:flex;gap:8px;justify-content:center;">
                    <i class="fas fa-eye action-icon" data-action="ver-detalle" data-id="${item.id}" style="color:#083CAE;" title="Ver"></i>
                    <i class="fas fa-edit action-icon" data-action="editar" data-id="${item.id}" style="color:#083CAE;" title="Editar"></i>
                    <i class="fas fa-tasks action-icon" data-action="asignar" data-id="${item.id}" style="color:#083CAE;" title="Asignar"></i>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function renderizarTablaAsignaciones(as) {
    const tbody = document.getElementById('tablaAsignaciones');
    tbody.innerHTML = '';
    if (!as.length) { tbody.innerHTML = `<tr><td colspan="8" style="text-align:center;padding:20px;color:#6c757d;">Sin asignaciones activas</td></tr>`; return; }

    as.forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.activo?.codigo} - ${item.activo?.nombre}</td>
            <td>${item.activo?.tipo_nombre || '-'}</td>
            <td>${item.proyecto?.nombre || '-'}</td>
            <td>${item.responsable_asignado || '-'}</td>
            <td style="text-align:center;">${formatDate(item.fecha_salida)}</td>
            <td style="text-align:center;">${formatDate(item.fecha_estimada_devolucion)}</td>
            <td style="text-align:right;">${item.horas_usadas ? item.horas_usadas.toFixed(1) : '-'}</td>
            <td style="text-align:center;">
                <i class="fas fa-edit action-icon" data-action="editar-asignacion" data-id="${item.id}" style="color:#083CAE;" title="Editar"></i>
                <i class="fas fa-check action-icon" data-action="devolver-asignacion" data-id="${item.id}" style="color:#28a745;" title="Devolver"></i>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function renderizarTablaMantenimientos(data) {
    const tbody = document.getElementById('tablaMantenimientos');
    tbody.innerHTML = '';
    if (!data.length) { tbody.innerHTML = `<tr><td colspan="8" style="text-align:center;padding:20px;color:#6c757d;">Sin registros</td></tr>`; return; }

    data.forEach(item => {
        const badge = getMantenimientoStatusBadge(item.estatus);
        const puedeCerrar = item.estatus !== 'completado' && item.estatus !== 'cancelado';
        const resp = item.responsable_asignado || item.responsable?.nombre_completo || '-';
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.activo?.codigo || ''} - ${item.activo?.nombre || ''}</td>
            <td>${item.activo?.tipo_nombre || item.activo?.tipo_activo || '-'}</td>
            <td>${item.tipo_mantenimiento || '-'}</td>
            <td>${formatDate(item.fecha_inicio)}</td>
            <td>${item.fecha_fin ? formatDate(item.fecha_fin) : '-'}</td>
            <td>${resp}</td>
            <td><span class="badge-equipo ${badge}">${item.estatus || 'Pendiente'}</span></td>
            <td>
                <i class="fas fa-eye action-icon" data-action="ver-mant" data-id="${item.id}" style="color:#083CAE;"></i>
                <i class="fas fa-edit action-icon" data-action="editar-mant" data-id="${item.id}" style="color:#ffc107;"></i>
                ${puedeCerrar ? `<i class="fas fa-check-circle action-icon" data-action="cerrar-mant" data-id="${item.id}" style="color:#28a745;"></i>` : ''}
            </td>
        `;
        tbody.appendChild(row);
    });
}

function renderizarTablaCombustible(data) {
    const tbody = document.getElementById('tablaCombustible');
    tbody.innerHTML = '';
    if (!data.length) { tbody.innerHTML = `<tr><td colspan="8" style="text-align:center;padding:20px;">Sin registros de combustible</td></tr>`; return; }

    data.forEach(item => {
        const op = item.operador?.nombre_completo || item.operador?.nombre || '-';
        const proy = item.proyecto?.nombre || 'Sin proyecto';
        const act = item.activo ? `${item.activo.codigo || ''} - ${item.activo.nombre || ''}` : '-';
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${act}</td>
            <td>${proy}</td>
            <td>${formatDate(item.fecha)}</td>
            <td style="text-align:right;">${Number(item.litros).toFixed(2)} L</td>
            <td style="text-align:right;">$${Number(item.costo).toFixed(2)}</td>
            <td>${item.horometro || '-'}</td>
            <td>${op}</td>
            <td>
                <i class="fas fa-eye action-icon" data-action="ver-comb" data-id="${item.id}" style="color:#083CAE;"></i>
                <i class="fas fa-edit action-icon" data-action="editar-comb" data-id="${item.id}" style="color:#ffc107;"></i>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function actualizarEstadisticas(s) {
    if (!s) return;
    document.getElementById('totalEquipos').textContent = s.total_equipos || 0;
    document.getElementById('totalOperacion').textContent = s.en_operacion || 0;
    document.getElementById('totalMantenimiento').textContent = s.en_mantenimiento || 0;
    document.getElementById('totalDisponibles').textContent = s.disponibles || 0;
}

function actualizarEstadisticasMantenimiento(s) {
    if (!s) return;
    document.getElementById('totalMantEnProceso').textContent = s.en_mantenimiento ?? s.en_proceso ?? 0;
    document.getElementById('totalMantProximos').textContent = s.programados ?? s.proximos ?? 0;
    document.getElementById('totalMantCompletados').textContent = s.completados ?? 0;
}

function actualizarResumenAsignaciones(as) {
    document.getElementById('totalAsignados').textContent = as.length;
    let horas = 0; as.forEach(a => horas += a.horas_usadas || 0);
    document.getElementById('totalHorasOperacion').textContent = horas.toFixed(0);
    const mes = new Date().getMonth();
    document.getElementById('totalAsignacionesMes').textContent = as.filter(a => new Date(a.fecha_salida).getMonth() === mes).length;
}

function actualizarPaginacion(p) {
    if (!p) return;
    document.getElementById('paginaActual').textContent = p.current_page || 1;
    document.getElementById('totalPaginas').textContent = `de ${p.last_page || 1}`;
    document.getElementById('paginacionInfo').textContent = `Mostrando ${p.from || 0}-${p.to || 0} de ${p.total || 0} registros`;
}

function calcularResumenCombustible(regs) {
    const L = regs.reduce((s, r) => s + Number(r.litros || 0), 0);
    const C = regs.reduce((s, r) => s + Number(r.costo || 0), 0);
    const P = L > 0 ? C / L : 0;
    document.getElementById('totalConsumoMensual').textContent = L.toFixed(2) + ' L';
    document.getElementById('totalCostoMensual').textContent = '$' + C.toFixed(2);
    document.getElementById('totalRendimientoProm').textContent = '$' + P.toFixed(2) + '/L';
}

/* =====================================================================
   RED DE SEGURIDAD: recrear modal de asignación si fue eliminado
   ===================================================================== */
function crearModalAsignacionSiNoExiste() {
    const existe = document.getElementById('modalAsignarEquipo');

    if (existe) {
        const selEquipo = document.getElementById('modalAsignacionEquipo');
        if (selEquipo && selEquipo.querySelectorAll('option').length <= 1) {
            llenarSelectAsignacion(true);
        }
        const selProyecto = document.getElementById('modalProyecto');
        if (selProyecto && selProyecto.querySelectorAll('option').length <= 1) {
            llenarSelectProyectos(proyectosLista, true);
        }
        const selResp = document.getElementById('modalResponsable');
        if (selResp && selResp.querySelectorAll('option').length <= 1) {
            llenarSelectResponsables(responsablesLista, true);
        }
        return;
    }

    console.warn('⚠️ Modal de asignación no existe, recreándolo...');

    const modalHTML = `
    <div id="modalAsignarEquipo" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);z-index:99999;align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:12px;width:90%;max-width:600px;max-height:90vh;overflow-y:auto;">
            <div style="padding:15px 20px;display:flex;justify-content:space-between;align-items:center;background:linear-gradient(135deg,#083CAE,#052a6b);border-radius:12px 12px 0 0;">
                <h3 style="margin:0;color:white;"><i class="fas fa-tasks"></i> Asignar Equipo a Proyecto</h3>
                <button type="button" data-close-modal="modalAsignarEquipo" style="background:rgba(255,255,255,0.2);border:none;font-size:20px;cursor:pointer;color:white;width:36px;height:36px;border-radius:50%;">&times;</button>
            </div>
            <div style="padding:20px;">
                <form id="formAsignarEquipo">
                    <div style="margin-bottom:15px;">
                        <label style="display:block;margin-bottom:5px;font-weight:600;font-size:13px;">Equipo <span style="color:#dc3545;">*</span></label>
                        <select id="modalAsignacionEquipo" name="activo_id" style="width:100%;padding:8px 12px;border:1px solid #ced4da;border-radius:4px;font-size:14px;"></select>
                    </div>
                    <div style="margin-bottom:15px;">
                        <label style="display:block;margin-bottom:5px;font-weight:600;font-size:13px;">Proyecto <span style="color:#dc3545;">*</span></label>
                        <select id="modalProyecto" name="proyecto_id" style="width:100%;padding:8px 12px;border:1px solid #ced4da;border-radius:4px;font-size:14px;"></select>
                    </div>
                    <div style="margin-bottom:15px;">
                        <label style="display:block;margin-bottom:5px;font-weight:600;font-size:13px;">Responsable</label>
                        <select id="modalResponsable" name="responsable_asignado_id" style="width:100%;padding:8px 12px;border:1px solid #ced4da;border-radius:4px;font-size:14px;"></select>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-bottom:15px;">
                        <div>
                            <label style="display:block;margin-bottom:5px;font-weight:600;font-size:13px;">Fecha Inicio <span style="color:#dc3545;">*</span></label>
                            <input type="date" id="modalFechaInicio" name="fecha_salida" style="width:100%;padding:8px 12px;border:1px solid #ced4da;border-radius:4px;font-size:14px;">
                        </div>
                        <div>
                            <label style="display:block;margin-bottom:5px;font-weight:600;font-size:13px;">Fecha Estimada Fin</label>
                            <input type="date" id="modalFechaFin" name="fecha_estimada_devolucion" style="width:100%;padding:8px 12px;border:1px solid #ced4da;border-radius:4px;font-size:14px;">
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-bottom:15px;">
                        <div>
                            <label style="display:block;margin-bottom:5px;font-weight:600;font-size:13px;">Horómetro Salida</label>
                            <input type="number" id="modalHorometro" name="horometro_salida" step="0.1" min="0" placeholder="0.0" style="width:100%;padding:8px 12px;border:1px solid #ced4da;border-radius:4px;font-size:14px;">
                        </div>
                        <div>
                            <label style="display:block;margin-bottom:5px;font-weight:600;font-size:13px;">Condición Salida</label>
                            <select id="modalCondicion" name="condicion_salida" style="width:100%;padding:8px 12px;border:1px solid #ced4da;border-radius:4px;font-size:14px;">
                                <option value="Excelente">Excelente</option>
                                <option value="Bueno" selected>Bueno</option>
                                <option value="Regular">Regular</option>
                                <option value="Malo">Malo</option>
                            </select>
                        </div>
                    </div>
                    <div style="margin-bottom:15px;">
                        <label style="display:block;margin-bottom:5px;font-weight:600;font-size:13px;">Observaciones</label>
                        <textarea id="modalObservacionesAsignacion" name="observaciones" rows="2" style="width:100%;padding:8px 12px;border:1px solid #ced4da;border-radius:4px;font-size:14px;resize:vertical;"></textarea>
                    </div>
                    <div style="display:flex;justify-content:flex-end;gap:10px;border-top:1px solid #dee2e6;padding-top:20px;">
                        <button type="button" data-close-modal="modalAsignarEquipo" style="padding:8px 20px;background-color:#6c757d;color:white;border:none;border-radius:4px;cursor:pointer;">Cancelar</button>
                        <button type="submit" style="padding:8px 20px;background-color:#28a745;color:white;border:none;border-radius:4px;cursor:pointer;"><i class="fas fa-save"></i> Asignar Equipo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>`;

    document.body.insertAdjacentHTML('beforeend', modalHTML);

    llenarSelectAsignacion(true);
    llenarSelectProyectos(proyectosLista, true);
    llenarSelectResponsables(responsablesLista, true);

    document.getElementById('formAsignarEquipo').addEventListener('submit', async function(e) {
        e.preventDefault();
        const activoId = document.getElementById('modalAsignacionEquipo')?.value;
        if (!activoId) {
            mostrarNotificacion('Debes seleccionar un equipo', 'warning');
            return;
        }
        const btn = this.querySelector('button[type="submit"]');
        const txt = btn.innerHTML; btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Asignando...';
        try {
            const fd = new FormData(this);
            const r = await fetch(`${API_BASE}/asignar`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: fd
            });
            const result = await r.json();
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cerrarModal('modalAsignarEquipo');
                cargarActivos(); cargarAsignacionesActivas(); cargarCatalogos();
            } else {
                console.error('❌ Error:', result);
                mostrarNotificacion(result.message || 'Error', 'error');
            }
        } catch (err) { mostrarNotificacion('Error al asignar', 'error'); }
        finally { btn.disabled = false; btn.innerHTML = txt; }
    });
}

/* =====================================================================
   EDITAR ASIGNACIÓN
   ===================================================================== */
async function editarAsignacion(id) {
    try {
        console.log('🚀 editarAsignacion llamado con id:', id);

        const r = await fetch(`${API_BASE}/asignaciones/${id}`, {
            headers: { 'Accept': 'application/json' }
        });
        const result = await r.json();
        console.log('📦 Datos recibidos:', result);

        if (!result.success) {
            mostrarNotificacion('No se pudo cargar la asignación', 'error');
            return;
        }

        const item = result.data;

        const form = document.getElementById('formEditarAsignacion');
        if (form) form.reset();

        document.getElementById('editAsignacionId').value = item.id;

        const equipoInfo = item.activo
            ? `${item.activo.codigo || ''} - ${item.activo.nombre || ''}`
            : '-';
        document.getElementById('editAsignacionEquipo').value = equipoInfo;

        llenarSelectProyectos(proyectosLista, true);
        const selProyecto = document.getElementById('editAsignacionProyecto');
        if (selProyecto && item.proyecto_id) {
            selProyecto.value = String(item.proyecto_id);
        }

        llenarSelectResponsables(responsablesLista, true);
        const selResp = document.getElementById('editAsignacionResponsable');
        if (selResp && item.responsable_asignado) {
            const opciones = Array.from(selResp.options);
            const opt = opciones.find(o => o.textContent === item.responsable_asignado);
            if (opt) selResp.value = opt.value;
        }

        document.getElementById('editAsignacionFechaInicio').value = item.fecha_salida ? item.fecha_salida.split('T')[0] : '';
        document.getElementById('editAsignacionFechaFin').value = item.fecha_estimada_devolucion ? item.fecha_estimada_devolucion.split('T')[0] : '';
        document.getElementById('editAsignacionHorometro').value = item.horometro_salida || '';

        const selCond = document.getElementById('editAsignacionCondicion');
        if (selCond && item.condicion_salida) {
            const condMap = {
                'excelente': 'Excelente',
                'bueno': 'Bueno',
                'regular': 'Regular',
                'malo': 'Malo',
                'danado': 'Malo',
                'dañado': 'Malo',
            };
            const key = String(item.condicion_salida).toLowerCase();
            selCond.value = condMap[key] || 'Bueno';
        }

        document.getElementById('editAsignacionObservaciones').value = item.observaciones_salida || '';

        abrirModal('modalEditarAsignacion');

    } catch (e) {
        console.error('❌ Error en editarAsignacion:', e);
        mostrarNotificacion('Error al cargar asignación', 'error');
    }
}

/* =====================================================================
   DEVOLVER EQUIPO
   ===================================================================== */
async function devolverEquipo(id) {
    try {
        console.log('🚀 devolverEquipo llamado con id:', id);

        const r = await fetch(`${API_BASE}/asignaciones/${id}`, {
            headers: { 'Accept': 'application/json' }
        });
        const result = await r.json();

        if (!result.success) {
            mostrarNotificacion('No se pudo cargar la asignación', 'error');
            return;
        }

        const item = result.data;

        const form = document.getElementById('formDevolverEquipo');
        if (form) form.reset();

        document.getElementById('devolverAsignacionId').value = item.id;

        const equipoInfo = item.activo
            ? `${item.activo.codigo || ''} - ${item.activo.nombre || ''}`
            : '-';
        document.getElementById('devolverEquipoInfo').textContent = equipoInfo;
        document.getElementById('devolverProyectoInfo').textContent = item.proyecto?.nombre || '-';

        document.getElementById('devolverFecha').value = new Date().toISOString().split('T')[0];
        document.getElementById('devolverCondicion').value = 'Bueno';
        document.getElementById('devolverHorometro').value = item.horometro_salida || '';
        document.getElementById('devolverKilometraje').value = '';
        document.getElementById('devolverObservaciones').value = '';

        document.getElementById('devolverReporteDanos').style.display = 'none';

        abrirModal('modalDevolverEquipo');

    } catch (e) {
        console.error('❌ Error en devolverEquipo:', e);
        mostrarNotificacion('Error al cargar asignación', 'error');
    }
}

/* =====================================================================
   ACCIONES: VER / EDITAR
   ===================================================================== */
async function verDetalle(id) {
    try {
        const r = await fetch(`${API_BASE}/${id}`, { headers: { 'Accept': 'application/json' } });
        const result = await r.json();
        if (!result.success) { mostrarNotificacion('No se pudo cargar', 'error'); return; }

        const item = result.data;
        document.getElementById('modalDetalleEquipo')?.remove();

        const modal = document.createElement('div');
        modal.id = 'modalDetalleEquipo';
        modal.style.cssText = 'display:flex;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);z-index:99999;align-items:center;justify-content:center;';

        const m = item.maquinaria || {};
        const v = item.vehiculo || {};
        const p = item.proyecto_asignado || item.proyectoAsignado || {};

        modal.innerHTML = `
            <div style="background:#fff;border-radius:12px;width:90%;max-width:700px;max-height:90vh;overflow-y:auto;">
                <div style="padding:15px 20px;display:flex;justify-content:space-between;align-items:center;background:linear-gradient(135deg,#083CAE,#052a6b);border-radius:12px 12px 0 0;">
                    <h3 style="margin:0;color:white;"><i class="fas fa-info-circle"></i> Detalle del Equipo</h3>
                    <button data-close-modal="modalDetalleEquipo" style="background:rgba(255,255,255,0.2);border:none;font-size:20px;color:white;width:36px;height:36px;border-radius:50%;cursor:pointer;">&times;</button>
                </div>
                <div style="padding:20px;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;font-size:14px;">
                        <div><strong>Código:</strong> ${item.codigo||'-'}</div>
                        <div><strong>Nombre:</strong> ${item.nombre||'-'}</div>
                        <div><strong>Tipo:</strong> ${item.tipo_nombre||item.tipo_activo||'-'}</div>
                        <div><strong>Estado:</strong> ${item.estatus_nombre||item.estatus||'-'}</div>
                        <div><strong>Marca:</strong> ${item.marca||'-'}</div>
                        <div><strong>Modelo:</strong> ${item.modelo||'-'}</div>
                        <div><strong>Año:</strong> ${item.anio||'-'}</div>
                        <div><strong>Serie:</strong> ${item.serie||'-'}</div>
                        <div><strong>Horómetro:</strong> ${m.horometro_actual ?? '-'}</div>
                        <div><strong>Kilometraje:</strong> ${v.kilometraje_actual ?? '-'}</div>
                        <div><strong>Proyecto:</strong> ${p.nombre||'Disponible'}</div>
                        <div><strong>Condición:</strong> ${item.estado_general||'-'}</div>
                        <div><strong>Costo Adq.:</strong> ${item.costo_adquisicion ? '$'+Number(item.costo_adquisicion).toFixed(2) : '-'}</div>
                        <div><strong>Costo Op/h:</strong> ${item.costo_operacion_hora ? '$'+Number(item.costo_operacion_hora).toFixed(2) : '-'}</div>
                        <div style="grid-column:1/-1;"><strong>Descripción:</strong> ${item.descripcion||'-'}</div>
                        <div style="grid-column:1/-1;"><strong>Observaciones:</strong> ${item.observaciones||'-'}</div>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        document.body.style.overflow = 'hidden';
    } catch (e) { console.error(e); mostrarNotificacion('Error', 'error'); }
}

async function editarEquipo(id) {
    const modal = document.getElementById('modalNuevoEquipo');
    const form = document.getElementById('formEquipo');
    if (!modal || !form) {
        mostrarNotificacion('Error: modal de edición no encontrado', 'error');
        return;
    }
    try {
        const r = await fetch(`${API_BASE}/${id}`, { headers: { 'Accept': 'application/json' } });
        const result = await r.json();
        if (!result.success) { mostrarNotificacion('No se pudo cargar el equipo', 'error'); return; }

        const item = result.data;
        form.reset();

        const setVal = (elemId, val) => {
            const el = document.getElementById(elemId);
            if (el) el.value = val ?? '';
        };

        setVal('editEquipoId', item.id);
        setVal('campoNombre', item.nombre);
        setVal('campoTipo', item.tipo_activo);
        setVal('campoMarca', item.marca);
        setVal('campoModelo', item.modelo);
        setVal('campoAnio', item.anio);
        setVal('campoSerie', item.serie);
        setVal('campoCosto', item.costo_adquisicion);
        setVal('campoCostoOperacion', item.costo_operacion_hora);
        setVal('campoDescripcion', item.descripcion);

        document.getElementById('modalEquipoTitulo').innerHTML = '<i class="fas fa-edit"></i> Editar Equipo';
        abrirModal('modalNuevoEquipo');
    } catch (e) { console.error(e); mostrarNotificacion('Error al cargar equipo', 'error'); }
}

async function verDetalleMantenimiento(id) {
    try {
        const r = await fetch(`${API_BASE}/mantenimiento/${id}`, { headers: { 'Accept': 'application/json' } });
        const result = await r.json();
        if (!result.success) { mostrarNotificacion('No se pudo cargar', 'error'); return; }

        const item = result.data;
        document.getElementById('modalDetalleMantenimiento')?.remove();

        const modal = document.createElement('div');
        modal.id = 'modalDetalleMantenimiento';
        modal.style.cssText = 'display:flex;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);z-index:99999;align-items:center;justify-content:center;';
        modal.innerHTML = `
            <div style="background:#fff;border-radius:12px;width:90%;max-width:650px;max-height:90vh;overflow-y:auto;">
                <div style="padding:15px 20px;display:flex;justify-content:space-between;align-items:center;background:linear-gradient(135deg,#ffc107,#d39e00);border-radius:12px 12px 0 0;">
                    <h3 style="margin:0;color:white;"><i class="fas fa-tools"></i> Detalle de Mantenimiento</h3>
                    <button data-close-modal="modalDetalleMantenimiento" style="background:rgba(255,255,255,0.2);border:none;font-size:20px;color:white;width:36px;height:36px;border-radius:50%;cursor:pointer;">&times;</button>
                </div>
                <div style="padding:20px;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;font-size:14px;">
                        <div style="grid-column:1/-1;"><strong>Equipo:</strong> ${item.activo?.codigo||''} - ${item.activo?.nombre||''}</div>
                        <div><strong>Tipo:</strong> ${item.tipo_mantenimiento||'-'}</div>
                        <div><strong>Estado:</strong> ${item.estatus||'-'}</div>
                        <div><strong>Prioridad:</strong> ${item.prioridad||'-'}</div>
                        <div><strong>Responsable:</strong> ${item.responsable_asignado||item.responsable?.nombre_completo||'-'}</div>
                        <div><strong>Fecha Inicio:</strong> ${formatDate(item.fecha_inicio)}</div>
                        <div><strong>Fecha Fin:</strong> ${item.fecha_fin ? formatDate(item.fecha_fin) : '-'}</div>
                        <div><strong>Costo:</strong> ${item.costo ? '$'+Number(item.costo).toFixed(2) : '-'}</div>
                        <div style="grid-column:1/-1;"><strong>Descripción:</strong> ${item.descripcion||'-'}</div>
                        <div style="grid-column:1/-1;"><strong>Observaciones:</strong> ${item.observaciones||'-'}</div>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        document.body.style.overflow = 'hidden';
    } catch (e) { console.error(e); mostrarNotificacion('Error', 'error'); }
}

async function editarMantenimiento(id) {
    const form = document.getElementById('formMantenimiento');
    if (!form) { mostrarNotificacion('Modal no disponible', 'error'); return; }
    try {
        const r = await fetch(`${API_BASE}/mantenimiento/${id}`, { headers: { 'Accept': 'application/json' } });
        const result = await r.json();
        if (!result.success) { mostrarNotificacion('No se pudo cargar', 'error'); return; }

        const item = result.data;
        form.reset();
        document.getElementById('editMantId').value = id;
        document.getElementById('modoMantenimiento').value = 'editar';

        document.getElementById('modalMantEquipo').value = item.activo_id || '';
        document.getElementById('modalMantTipo').value = item.tipo_mantenimiento || 'preventivo';
        document.getElementById('modalMantDescripcion').value = item.descripcion || '';
        document.getElementById('modalMantFechaInicio').value = item.fecha_inicio ? item.fecha_inicio.split('T')[0] : '';
        document.getElementById('modalMantFechaFinEstimada').value = item.fecha_fin_estimada ? item.fecha_fin_estimada.split('T')[0] : '';
        document.getElementById('modalMantCosto').value = item.costo || '';
        document.getElementById('modalMantPrioridad').value = item.prioridad || 'media';
        if (item.responsable_asignado) document.getElementById('modalMantResponsable').value = item.responsable_asignado;

        document.getElementById('modalMantTitulo').innerHTML = '<i class="fas fa-edit"></i> Editar Mantenimiento';
        document.getElementById('chkProgramarMant').disabled = true;
        document.getElementById('bloqueProgramar').style.display = 'none';

        abrirModal('modalMantenimiento');
    } catch (e) { console.error(e); mostrarNotificacion('Error', 'error'); }
}

function cerrarMantenimientoModal(id) {
    const form = document.getElementById('formCerrarMantenimiento');
    if (form) form.reset();
    document.getElementById('cerrarMantId').value = id;
    document.getElementById('cerrarMantFechaFin').value = new Date().toISOString().split('T')[0];
    abrirModal('modalCerrarMantenimiento');
}

async function verDetalleCombustible(id) {
    try {
        const r = await fetch(`${API_BASE}/combustible/${id}`, { headers: { 'Accept': 'application/json' } });
        const result = await r.json();
        if (!result.success) { mostrarNotificacion('No se pudo cargar', 'error'); return; }

        const item = result.data;
        document.getElementById('modalDetalleCombustible')?.remove();

        const modal = document.createElement('div');
        modal.id = 'modalDetalleCombustible';
        modal.style.cssText = 'display:flex;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);z-index:99999;align-items:center;justify-content:center;';
        modal.innerHTML = `
            <div style="background:#fff;border-radius:12px;width:90%;max-width:600px;">
                <div style="padding:15px 20px;display:flex;justify-content:space-between;align-items:center;background:linear-gradient(135deg,#28a745,#1e7e34);border-radius:12px 12px 0 0;">
                    <h3 style="margin:0;color:white;"><i class="fas fa-gas-pump"></i> Detalle de Carga</h3>
                    <button data-close-modal="modalDetalleCombustible" style="background:rgba(255,255,255,0.2);border:none;font-size:20px;color:white;width:36px;height:36px;border-radius:50%;cursor:pointer;">&times;</button>
                </div>
                <div style="padding:20px;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;font-size:14px;">
                        <div style="grid-column:1/-1;"><strong>Equipo:</strong> ${item.activo?.codigo||''} - ${item.activo?.nombre||''}</div>
                        <div><strong>Proyecto:</strong> ${item.proyecto?.nombre||'Sin proyecto'}</div>
                        <div><strong>Fecha:</strong> ${formatDate(item.fecha)}</div>
                        <div><strong>Litros:</strong> ${Number(item.litros).toFixed(2)} L</div>
                        <div><strong>Costo:</strong> $${Number(item.costo).toFixed(2)}</div>
                        <div><strong>Precio/L:</strong> $${Number(item.precio_litro || (item.costo/item.litros) || 0).toFixed(2)}</div>
                        <div><strong>Horómetro:</strong> ${item.horometro||'-'}</div>
                        <div><strong>Factura:</strong> ${item.factura||'-'}</div>
                        <div><strong>Proveedor:</strong> ${item.proveedor?.nombre||'-'}</div>
                        <div><strong>Operador:</strong> ${item.operador?.nombre_completo||'-'}</div>
                        <div style="grid-column:1/-1;"><strong>Observaciones:</strong> ${item.observaciones||'-'}</div>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        document.body.style.overflow = 'hidden';
    } catch (e) { console.error(e); mostrarNotificacion('Error', 'error'); }
}

async function editarCombustible(id) {
    const form = document.getElementById('formCombustible');
    if (!form) { mostrarNotificacion('Modal no disponible', 'error'); return; }
    try {
        const r = await fetch(`${API_BASE}/combustible/${id}`, { headers: { 'Accept': 'application/json' } });
        const result = await r.json();
        if (!result.success) { mostrarNotificacion('No se pudo cargar', 'error'); return; }

        const item = result.data;
        form.reset();
        document.getElementById('editCombId').value = id;
        document.getElementById('modalCombustibleEquipo').value = item.activo_id || '';
        document.getElementById('modalCombustibleFecha').value = item.fecha ? item.fecha.split('T')[0] : '';
        document.getElementById('modalCombustibleLitros').value = item.litros || '';
        document.getElementById('modalCombustibleCosto').value = item.costo || '';
        document.getElementById('modalCombustibleHorometro').value = item.horometro || '';
        document.getElementById('modalCombustibleFactura').value = item.factura || '';
        document.getElementById('modalCombustibleObservaciones').value = item.observaciones || '';
        if (item.proyecto_id) document.getElementById('modalCombustibleProyecto').value = item.proyecto_id;
        if (item.operador_id) document.getElementById('modalCombustibleOperador').value = item.operador_id;
        if (item.proveedor_id) document.getElementById('modalCombustibleProveedor').value = item.proveedor_id;

        document.getElementById('modalCombTitulo').innerHTML = '<i class="fas fa-edit"></i> Editar Carga';
        abrirModal('modalCombustible');
    } catch (e) { console.error(e); mostrarNotificacion('Error', 'error'); }
}

/* =====================================================================
   ABRIR MODALES
   ===================================================================== */
function abrirModalAsignacion(equipoId) {
    crearModalAsignacionSiNoExiste();

    const form = document.getElementById('formAsignarEquipo');
    const modal = document.getElementById('modalAsignarEquipo');

    if (!form || !modal) {
        console.error('❌ No se encontró el modal o formulario de asignación');
        mostrarNotificacion('Error: no se pudo abrir el modal de asignación', 'error');
        return;
    }

    form.reset();

    const selEquipo = document.getElementById('modalAsignacionEquipo');
    if (selEquipo && selEquipo.querySelectorAll('option').length <= 1) {
        llenarSelectAsignacion(true);
    }
    const selProyecto = document.getElementById('modalProyecto');
    if (selProyecto && selProyecto.querySelectorAll('option').length <= 1) {
        llenarSelectProyectos(proyectosLista, true);
    }
    const selResp = document.getElementById('modalResponsable');
    if (selResp && selResp.querySelectorAll('option').length <= 1) {
        llenarSelectResponsables(responsablesLista, true);
    }

    if (equipoId) {
        const s = document.getElementById('modalAsignacionEquipo');
        const existe = s && Array.from(s.options).some(o => o.value === String(equipoId));
        if (existe) {
            s.value = String(equipoId);
        } else {
            mostrarNotificacion('Este equipo no está disponible para asignación (ya asignado o en mantenimiento)', 'warning');
        }
    }

    const hoy = new Date();
    const fechaInicio = document.getElementById('modalFechaInicio');
    if (fechaInicio) fechaInicio.value = hoy.toISOString().split('T')[0];

    const mes = new Date(); mes.setMonth(mes.getMonth() + 1);
    const fechaFin = document.getElementById('modalFechaFin');
    if (fechaFin) fechaFin.value = mes.toISOString().split('T')[0];

    abrirModal('modalAsignarEquipo');
}

function abrirModalNuevoEquipo() {
    const form = document.getElementById('formEquipo');
    if (form) form.reset();
    document.getElementById('editEquipoId').value = '';
    document.getElementById('modalEquipoTitulo').innerHTML = '<i class="fas fa-plus-circle"></i> Nuevo Equipo';
    abrirModal('modalNuevoEquipo');
}

function abrirModalNuevoMantenimiento() {
    const form = document.getElementById('formMantenimiento');
    if (form) form.reset();
    document.getElementById('editMantId').value = '';
    document.getElementById('modoMantenimiento').value = 'registrar';
    document.getElementById('chkProgramarMant').checked = false;
    document.getElementById('chkProgramarMant').disabled = false;
    document.getElementById('bloqueProgramar').style.display = 'block';
    document.getElementById('modalMantTitulo').innerHTML = '<i class="fas fa-tools"></i> Registrar Mantenimiento';
    document.getElementById('modalMantFechaInicio').value = new Date().toISOString().split('T')[0];
    abrirModal('modalMantenimiento');
}

function abrirModalNuevoCombustible() {
    const form = document.getElementById('formCombustible');
    if (form) form.reset();
    document.getElementById('editCombId').value = '';
    document.getElementById('modalCombTitulo').innerHTML = '<i class="fas fa-gas-pump"></i> Registrar Carga';
    document.getElementById('modalCombustibleFecha').value = new Date().toISOString().split('T')[0];
    abrirModal('modalCombustible');
}

/* =====================================================================
   EVENT DELEGATION GLOBAL
   ===================================================================== */
document.addEventListener('click', function(e) {
    const closeBtn = e.target.closest('[data-close-modal]');
    if (closeBtn) {
        e.preventDefault();
        const id = closeBtn.dataset.closeModal;
        if (id) {
            const m = document.getElementById(id);
            if (m) {
                if (id.startsWith('modalDetalle')) m.remove();
                else m.style.display = 'none';
            }
            document.body.style.overflow = 'auto';
        }
        return;
    }

    const actionEl = e.target.closest('[data-action]');
    if (actionEl) {
        e.preventDefault();
        const action = actionEl.dataset.action;
        const id = actionEl.dataset.id;
        console.log('[Action]', action, id);
        switch(action) {
            case 'ver-detalle':         verDetalle(id); break;
            case 'editar':              editarEquipo(id); break;
            case 'asignar':             abrirModalAsignacion(id); break;
            case 'ver-mant':            verDetalleMantenimiento(id); break;
            case 'editar-mant':         editarMantenimiento(id); break;
            case 'cerrar-mant':         cerrarMantenimientoModal(id); break;
            case 'ver-comb':            verDetalleCombustible(id); break;
            case 'editar-comb':         editarCombustible(id); break;
            case 'editar-asignacion':   editarAsignacion(id); break;
            case 'devolver-asignacion': devolverEquipo(id); break;
            default: console.warn('Acción no reconocida:', action);
        }
        return;
    }

    // Cerrar dropdown de proyectos (solo si el clic NO fue dentro de un modal)
    const c = document.getElementById('proyectoFilterContainer');
    const dropdown = document.getElementById('filtroProyectosDropdown');
    if (c && dropdown && !c.contains(e.target)) {
        const estaEnModal = e.target.closest('#modalAsignarEquipo') ||
                            e.target.closest('#modalEditarAsignacion') ||
                            e.target.closest('#modalDevolverEquipo') ||
                            e.target.closest('#modalNuevoEquipo') ||
                            e.target.closest('#modalMantenimiento') ||
                            e.target.closest('#modalCombustible') ||
                            e.target.closest('#modalCerrarMantenimiento');
        if (!estaEnModal && dropdown.style.display === 'block') {
            dropdown.style.display = 'none';
        }
    }
});

/* =====================================================================
   CERRAR MODALES CON CLIC FUERA
   ===================================================================== */
window.addEventListener('click', function(e) {
    const modalesDetalle = ['modalDetalleEquipo','modalDetalleMantenimiento','modalDetalleCombustible'];
    const modalesForm = [
        'modalAsignarEquipo','modalEditarAsignacion','modalDevolverEquipo',
        'modalNuevoEquipo','modalMantenimiento','modalCombustible','modalCerrarMantenimiento'
    ];

    modalesDetalle.forEach(id => {
        const m = document.getElementById(id);
        if (m && e.target === m) { m.remove(); document.body.style.overflow = 'auto'; }
    });
    modalesForm.forEach(id => {
        const m = document.getElementById(id);
        if (m && e.target === m) { m.style.display = 'none'; document.body.style.overflow = 'auto'; }
    });
});

/* =====================================================================
   INICIALIZACIÓN
   ===================================================================== */
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Maquinaria Blade inicializado');

    cargarCatalogos().then(() => {
        cargarActivos();
        cargarAsignacionesActivas();
        cargarMantenimientos();
        cargarCombustible();
    });

    /* ---------- FILTRO PROYECTOS ---------- */
    document.getElementById('btnFiltroProyectos')?.addEventListener('click', e => { e.stopPropagation();
        const d = document.getElementById('filtroProyectosDropdown');
        d.style.display = d.style.display === 'block' ? 'none' : 'block';
    });
    document.getElementById('btnCerrarFiltro')?.addEventListener('click', e => { e.stopPropagation(); document.getElementById('filtroProyectosDropdown').style.display = 'none'; });
    document.getElementById('btnSeleccionarTodos')?.addEventListener('click', e => { e.stopPropagation();
        document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]').forEach(c => c.checked = true);
        actualizarLabelProyectos(); currentFilters.page = 1; cargarActivos();
    });
    document.getElementById('btnDeseleccionarTodos')?.addEventListener('click', e => { e.stopPropagation();
        document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]').forEach(c => c.checked = false);
        actualizarLabelProyectos(); currentFilters.page = 1; cargarActivos();
    });
    document.getElementById('filtroProyectosBuscar')?.addEventListener('input', function() {
        const t = this.value.toLowerCase().trim();
        document.querySelectorAll('#filtroProyectosLista label').forEach(l => {
            l.style.display = l.textContent.toLowerCase().includes(t) ? 'flex' : 'none';
        });
    });
    document.getElementById('filtroProyectosLista')?.addEventListener('change', () => { actualizarLabelProyectos(); currentFilters.page = 1; cargarActivos(); });

    /* ---------- TABS ---------- */
    document.querySelectorAll('.maquinaria-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.maquinaria-tab').forEach(t => {
                t.classList.remove('active'); t.style.background = '#e9ecef'; t.style.color = '#495057';
            });
            this.classList.add('active'); this.style.background = '#083CAE'; this.style.color = 'white';

            currentTab = this.dataset.tab;
            document.querySelectorAll('.maquinaria-content').forEach(c => c.style.display = 'none');
            const target = document.getElementById(`tab-${currentTab}`);
            if (target) target.style.display = 'block';

            if (currentTab === 'asignacion') cargarAsignacionesActivas();
            if (currentTab === 'mantenimiento') cargarMantenimientos();
            if (currentTab === 'combustible') cargarCombustible();
        });
    });

    /* ---------- FILTROS INVENTARIO ---------- */
    document.getElementById('selectorTipo')?.addEventListener('change', function() { currentFilters.tipo = this.value; currentFilters.page = 1; cargarActivos(); });
    document.getElementById('selectorStatus')?.addEventListener('change', function() { currentFilters.estatus = this.value; currentFilters.page = 1; cargarActivos(); });
    let bTimeout;
    document.getElementById('buscador')?.addEventListener('input', function() {
        clearTimeout(bTimeout);
        bTimeout = setTimeout(() => { currentFilters.busqueda = this.value; currentFilters.page = 1; cargarActivos(); }, 400);
    });

    /* ---------- FILTROS MANTENIMIENTO ---------- */
    document.getElementById('filtroMantEstatus')?.addEventListener('change', cargarMantenimientos);
    document.getElementById('filtroMantTipo')?.addEventListener('change', cargarMantenimientos);
    let mTimeout;
    document.getElementById('filtroMantBusqueda')?.addEventListener('input', () => { clearTimeout(mTimeout); mTimeout = setTimeout(cargarMantenimientos, 400); });
    document.getElementById('btnLimpiarFiltrosMant')?.addEventListener('click', () => {
        document.getElementById('filtroMantEstatus').value = '';
        document.getElementById('filtroMantTipo').value = '';
        document.getElementById('filtroMantBusqueda').value = '';
        cargarMantenimientos();
    });

    /* ---------- FILTROS COMBUSTIBLE ---------- */
    document.getElementById('btnFiltrarCombustible')?.addEventListener('click', cargarCombustible);
    document.getElementById('selectorCombustibleEquipo')?.addEventListener('change', cargarCombustible);
    document.getElementById('fechaCombustibleInicio')?.addEventListener('change', cargarCombustible);
    document.getElementById('fechaCombustibleFin')?.addEventListener('change', cargarCombustible);
    document.getElementById('btnLimpiarFiltrosComb')?.addEventListener('click', () => {
        document.getElementById('selectorCombustibleEquipo').value = '';
        document.getElementById('fechaCombustibleInicio').value = '';
        document.getElementById('fechaCombustibleFin').value = '';
        cargarCombustible();
    });

    /* ---------- BOTONES PRINCIPALES ---------- */
    document.getElementById('btnAsignarEquipo')?.addEventListener('click', () => abrirModalAsignacion());
    document.getElementById('btnNuevaAsignacion')?.addEventListener('click', () => abrirModalAsignacion());
    document.getElementById('btnAgregarEquipo')?.addEventListener('click', abrirModalNuevoEquipo);
    document.getElementById('btnRegistrarMantenimiento')?.addEventListener('click', abrirModalNuevoMantenimiento);
    document.getElementById('btnRegistrarCarga')?.addEventListener('click', abrirModalNuevoCombustible);
    document.getElementById('btnExcel')?.addEventListener('click', exportarExcel);

    /* ---------- CHECKBOX PROGRAMAR ---------- */
    document.getElementById('chkProgramarMant')?.addEventListener('change', function() {
        document.getElementById('modoMantenimiento').value = this.checked ? 'programar' : 'registrar';
    });

    /* ---------- CAMBIO DE CONDICIÓN EN DEVOLUCIÓN ---------- */
    document.getElementById('devolverCondicion')?.addEventListener('change', function() {
        const condLower = (this.value || '').toLowerCase();
        const bloque = document.getElementById('devolverReporteDanos');
        if (bloque) {
            bloque.style.display = (condLower === 'malo') ? 'block' : 'none';
        }
    });

    /* ---------- PAGINACIÓN ---------- */
    document.getElementById('btnPrimera')?.addEventListener('click', () => { if (currentPage > 1) { currentFilters.page = 1; cargarActivos(); } });
    document.getElementById('btnAnterior')?.addEventListener('click', () => { if (currentPage > 1) { currentFilters.page = currentPage - 1; cargarActivos(); } });
    document.getElementById('btnSiguiente')?.addEventListener('click', () => { if (currentPage < totalPages) { currentFilters.page = currentPage + 1; cargarActivos(); } });
    document.getElementById('btnUltima')?.addEventListener('click', () => { if (currentPage < totalPages) { currentFilters.page = totalPages; cargarActivos(); } });

    /* ---------- SUBMIT FORMS ---------- */
    // Asignar equipo
    document.getElementById('formAsignarEquipo')?.addEventListener('submit', async function(e) {
        e.preventDefault();

        const activoId = document.getElementById('modalAsignacionEquipo')?.value;
        if (!activoId) {
            mostrarNotificacion('Debes seleccionar un equipo', 'warning');
            return;
        }

        const btn = this.querySelector('button[type="submit"]');
        const txt = btn.innerHTML; btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Asignando...';
        try {
            const fd = new FormData(this);
            console.log('📤 Enviando asignación:', Object.fromEntries(fd));
            const r = await fetch(`${API_BASE}/asignar`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: fd
            });
            const result = await r.json();
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cerrarModal('modalAsignarEquipo');
                cargarActivos();
                cargarAsignacionesActivas();
                cargarCatalogos();
            } else {
                console.error('❌ Error del servidor:', result);
                mostrarNotificacion(result.message || 'Error al asignar', 'error');
            }
        } catch (err) {
            console.error('❌ Error fetch:', err);
            mostrarNotificacion('Error al asignar', 'error');
        }
        finally { btn.disabled = false; btn.innerHTML = txt; }
    });

    // Editar asignación
    document.getElementById('formEditarAsignacion')?.addEventListener('submit', async function(e) {
        e.preventDefault();

        const id = document.getElementById('editAsignacionId').value;
        if (!id) {
            mostrarNotificacion('ID de asignación no válido', 'error');
            return;
        }

        const btn = this.querySelector('button[type="submit"]');
        const txt = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';

        try {
            const fd = new FormData(this);
            fd.append('_method', 'PUT');

            const r = await fetch(`${API_BASE}/asignaciones/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                },
                body: fd
            });

            const result = await r.json();

            if (result.success) {
                mostrarNotificacion(result.message || 'Asignación actualizada', 'success');
                cerrarModal('modalEditarAsignacion');
                cargarAsignacionesActivas();
                cargarActivos();
            } else {
                console.error('❌ Error:', result);
                mostrarNotificacion(result.message || 'Error al actualizar', 'error');
            }
        } catch (err) {
            console.error('❌ Error fetch:', err);
            mostrarNotificacion('Error al actualizar asignación', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = txt;
        }
    });

    // Devolver equipo
    document.getElementById('formDevolverEquipo')?.addEventListener('submit', async function(e) {
        e.preventDefault();

        const id = document.getElementById('devolverAsignacionId').value;
        if (!id) {
            mostrarNotificacion('ID de asignación no válido', 'error');
            return;
        }

        const btn = this.querySelector('button[type="submit"]');
        const txt = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Devolviendo...';

        try {
            const fd = new FormData(this);

            const r = await fetch(`${API_BASE}/${id}/devolver`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                },
                body: fd
            });

            const result = await r.json();

            if (result.success) {
                mostrarNotificacion(result.message || 'Equipo devuelto', 'success');
                cerrarModal('modalDevolverEquipo');
                cargarAsignacionesActivas();
                cargarActivos();
                cargarCatalogos();
            } else {
                console.error('❌ Error:', result);
                mostrarNotificacion(result.message || 'Error al devolver', 'error');
            }
        } catch (err) {
            console.error('❌ Error fetch:', err);
            mostrarNotificacion('Error al devolver el equipo', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = txt;
        }
    });

    // Equipo (crear / editar)
    document.getElementById('formEquipo')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const editId = document.getElementById('editEquipoId').value;
        const btn = this.querySelector('button[type="submit"]');
        const txt = btn.innerHTML; btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        try {
            const fd = new FormData(this);
            let url = API_BASE; let method = 'POST';
            if (editId) { url = `${API_BASE}/${editId}`; fd.append('_method', 'PUT'); }
            const r = await fetch(url, { method, headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }, body: fd });
            const result = await r.json();
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cerrarModal('modalNuevoEquipo');
                cargarActivos();
                cargarCatalogos();
            } else mostrarNotificacion(result.message || 'Error', 'error');
        } catch (err) { mostrarNotificacion('Error al guardar', 'error'); }
        finally { btn.disabled = false; btn.innerHTML = txt; }
    });

    // Mantenimiento
    document.getElementById('formMantenimiento')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const editId = document.getElementById('editMantId').value;
        const modo = document.getElementById('modoMantenimiento').value;
        const btn = this.querySelector('button[type="submit"]');
        const txt = btn.innerHTML; btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        try {
            const fd = new FormData(this);
            let url, method = 'POST';
            if (editId) { url = `${API_BASE}/mantenimiento/${editId}`; fd.append('_method', 'PUT'); }
            else { url = `${API_BASE}/mantenimiento`; fd.append('modo', modo); }

            const r = await fetch(url, { method, headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }, body: fd });
            const result = await r.json();
            if (result.success) {
                mostrarNotificacion(result.message || 'Guardado', 'success');
                cerrarModal('modalMantenimiento');
                cargarActivos();
                cargarMantenimientos();
                cargarCatalogos();
            } else mostrarNotificacion(result.message || 'Error', 'error');
        } catch (err) { mostrarNotificacion('Error al guardar', 'error'); }
        finally { btn.disabled = false; btn.innerHTML = txt; }
    });

    // Cerrar mantenimiento
    document.getElementById('formCerrarMantenimiento')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.getElementById('cerrarMantId').value;
        const btn = this.querySelector('button[type="submit"]');
        const txt = btn.innerHTML; btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Finalizando...';
        try {
            const r = await fetch(`${API_BASE}/mantenimiento/${id}/cerrar`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: new FormData(this)
            });
            const result = await r.json();
            if (result.success) {
                mostrarNotificacion(result.message || 'Finalizado', 'success');
                cerrarModal('modalCerrarMantenimiento');
                cargarMantenimientos();
                cargarActivos();
                cargarCatalogos();
            } else mostrarNotificacion(result.message || 'Error', 'error');
        } catch (err) { mostrarNotificacion('Error', 'error'); }
        finally { btn.disabled = false; btn.innerHTML = txt; }
    });

    // Combustible
    document.getElementById('formCombustible')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const editId = document.getElementById('editCombId').value;
        const btn = this.querySelector('button[type="submit"]');
        const txt = btn.innerHTML; btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        try {
            const fd = new FormData(this);
            let url, method = 'POST';
            if (editId) { url = `${API_BASE}/combustible/${editId}`; fd.append('_method', 'PUT'); }
            else { url = `${API_BASE}/combustible/consumo`; }

            const r = await fetch(url, { method, headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }, body: fd });
            const result = await r.json();
            if (result.success) {
                mostrarNotificacion(result.message || 'Guardado', 'success');
                cerrarModal('modalCombustible');
                cargarCombustible();
            } else mostrarNotificacion(result.message || 'Error', 'error');
        } catch (err) { mostrarNotificacion('Error', 'error'); }
        finally { btn.disabled = false; btn.innerHTML = txt; }
    });
});

/* =====================================================================
   EXPORTAR EXCEL
   ===================================================================== */
async function exportarExcel() {
    try {
        const p = new URLSearchParams();
        p.append('busqueda', currentFilters.busqueda || '');
        p.append('tipo', currentFilters.tipo || '');
        p.append('estatus', currentFilters.estatus || '');
        getProyectosSeleccionados().forEach(id => p.append('proyecto_id[]', id));

        const r = await fetch(`${API_BASE}/exportar?${p}`);
        const result = await r.json();

        if (result.success && result.data) {
            const { headers, rows } = result.data;
            if (!headers?.length || !rows?.length) { mostrarNotificacion('Sin datos', 'warning'); return; }
            const csv = [headers.join(','), ...rows.map(r => r.join(','))].join('\n');
            const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = `Maquinaria_${new Date().toISOString().split('T')[0]}.csv`;
            a.click();
            mostrarNotificacion('Exportado', 'success');
        }
    } catch (e) { mostrarNotificacion('Error al exportar', 'error'); }
}
</script>
@endsection