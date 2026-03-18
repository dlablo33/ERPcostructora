@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Roles y Puestos del Sistema -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Roles y Puestos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Selector de registros por página -->
                <div style="display: flex; justify-content: flex-end; margin-bottom: 15px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <label style="font-size: 13px; color: #6c757d;">Mostrar:</label>
                        <select id="perPage" style="padding: 6px 10px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 13px;" onchange="cambiarRegistrosPorPagina()">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span style="font-size: 13px; color: #6c757d;">registros por página</span>
                    </div>
                </div>

                <!-- Pestañas de navegación -->
                <div style="display: flex; border-bottom: 2px solid #dee2e6; margin-bottom: 20px;">
                    <button class="tab-rol active" onclick="switchTab('roles')" id="tabRoles" style="background-color: var(--color-primary); color: white; border: none; padding: 10px 25px; border-radius: 8px 8px 0 0; margin-right: 5px; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-user-tag"></i> Roles
                        <span id="totalRolesBadge" style="background-color: white; color: var(--color-primary); padding: 2px 8px; border-radius: 10px; margin-left: 5px; font-size: 11px;">0</span>
                    </button>
                    <button class="tab-puesto" onclick="switchTab('puestos')" id="tabPuestos" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; border-radius: 8px 8px 0 0; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-briefcase"></i> Puestos
                        <span id="totalPuestosBadge" style="background-color: #6c757d; color: white; padding: 2px 8px; border-radius: 10px; margin-left: 5px; font-size: 11px;">0</span>
                    </button>
                </div>

                <!-- Panel de Roles -->
                <div id="panelRoles" style="display: block;">
                    <!-- Barra de herramientas para Roles -->
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                        <!-- Grupo de agrupación -->
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacionRoles">
                            <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                            <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgruparRoles">arrastra una columna aquí para agrupar</span>
                            <div id="grupoColumnasRoles" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                        </div>
                        
                        <!-- Botones -->
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                            <!-- Botón Agregar (+) -->
                            <div>
                                <button id="btnAgregarRol" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                        title="Agregar rol"
                                        onclick="abrirModalRol()">
                                    <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                                </button>
                            </div>

                            <!-- Botón Exportar Excel -->
                            <div>
                                <button id="btnExcelRoles" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                        onclick="exportarRolesExcel()">
                                    <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                    <span class="hide-mobile">Excel</span>
                                </button>
                            </div>

                            <!-- Botón Seleccionar Columnas -->
                            <div style="position: relative;">
                                <button id="btnColumnasRoles" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                        onclick="toggleColumnSelector('roles')">
                                    <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                    <span class="hide-mobile">Columnas</span>
                                </button>
                                
                                <!-- Selector de columnas para Roles -->
                                <div id="columnSelectorRoles" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 250px; max-height: 350px; overflow-y: auto;">
                                    <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                        <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                        <button onclick="cerrarColumnSelector('roles')" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                    </div>
                                    <div id="columnasListaRoles" style="padding: 10px;"></div>
                                </div>
                            </div>

                            <!-- Buscador -->
                            <div style="position: relative; min-width: 200px;">
                                <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                                <input type="text" id="buscadorRoles" placeholder="Buscar rol..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Roles -->
                    <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                        <table class="table" id="tablaRoles" style="width: 100%; border-collapse: collapse; font-size: 13px; min-width: 600px;">
                            <thead style="background-color: var(--color-primary);">
                                <tr>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 10%;" draggable="true" data-columna="estatus">Estatus</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 15%;" draggable="true" data-columna="folio">Folio</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 25%;" draggable="true" data-columna="rol">Rol</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 40%;" draggable="true" data-columna="descripcion">Descripción</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35; box-shadow: -2px 0 5px rgba(0,0,0,0.1); width: 10%;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodyRoles">
                                <!-- Los datos se cargarán vía API -->
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación para Roles -->
                    <div id="paginacionRoles" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; padding: 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px;">
                        <div style="font-size: 13px; color: #6c757d;">
                            Mostrando <span id="rolesDesde">0</span> a <span id="rolesHasta">0</span> de <span id="rolesTotal">0</span> registros
                        </div>
                        <div style="display: flex; gap: 5px;">
                            <button id="rolesPrevPage" style="padding: 6px 12px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; font-size: 13px;" onclick="cambiarPaginaRoles('prev')" disabled>Anterior</button>
                            <span id="rolesPaginaActual" style="padding: 6px 12px; background-color: var(--color-primary); color: white; border-radius: 4px; font-size: 13px;">1</span>
                            <button id="rolesNextPage" style="padding: 6px 12px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; font-size: 13px;" onclick="cambiarPaginaRoles('next')">Siguiente</button>
                        </div>
                    </div>
                    
                    <!-- Totales de Roles -->
                    <div style="margin-top: 15px; display: flex; justify-content: flex-start; gap: 20px; padding: 10px; background-color: #e9ecef; border-radius: 4px; font-size: 13px; font-weight: bold;">
                        <span>Total Roles: <span id="totalRoles" style="color: var(--color-primary);">0</span></span>
                        <span style="color: #28a745;">Activos: <span id="rolesActivos">0</span></span>
                        <span style="color: #ffc107;">Inactivos: <span id="rolesInactivos">0</span></span>
                    </div>
                </div>

                <!-- Panel de Puestos -->
                <div id="panelPuestos" style="display: none;">
                    <!-- Barra de herramientas para Puestos -->
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                        <!-- Grupo de agrupación -->
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacionPuestos">
                            <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                            <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgruparPuestos">arrastra una columna aquí para agrupar</span>
                            <div id="grupoColumnasPuestos" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                        </div>
                        
                        <!-- Botones -->
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                            <!-- Botón Agregar (+) -->
                            <div>
                                <button id="btnAgregarPuesto" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                        title="Agregar puesto"
                                        onclick="abrirModalPuesto()">
                                    <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                                </button>
                            </div>

                            <!-- Botón Exportar Excel -->
                            <div>
                                <button id="btnExcelPuestos" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                        onclick="exportarPuestosExcel()">
                                    <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                    <span class="hide-mobile">Excel</span>
                                </button>
                            </div>

                            <!-- Botón Seleccionar Columnas -->
                            <div style="position: relative;">
                                <button id="btnColumnasPuestos" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                        onclick="toggleColumnSelector('puestos')">
                                    <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                    <span class="hide-mobile">Columnas</span>
                                </button>
                                
                                <!-- Selector de columnas para Puestos -->
                                <div id="columnSelectorPuestos" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 250px; max-height: 350px; overflow-y: auto;">
                                    <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                        <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                        <button onclick="cerrarColumnSelector('puestos')" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                    </div>
                                    <div id="columnasListaPuestos" style="padding: 10px;"></div>
                                </div>
                            </div>

                            <!-- Buscador -->
                            <div style="position: relative; min-width: 200px;">
                                <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                                <input type="text" id="buscadorPuestos" placeholder="Buscar puesto..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Puestos -->
                    <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                        <table class="table" id="tablaPuestos" style="width: 100%; border-collapse: collapse; font-size: 13px; min-width: 600px;">
                            <thead style="background-color: var(--color-primary);">
                                <tr>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 10%;" draggable="true" data-columna="estatus">Estatus</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 15%;" draggable="true" data-columna="folio">Folio</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 25%;" draggable="true" data-columna="puesto">Puesto</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 40%;" draggable="true" data-columna="descripcion">Descripción</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35; box-shadow: -2px 0 5px rgba(0,0,0,0.1); width: 10%;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodyPuestos">
                                <!-- Los datos se cargarán vía API -->
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación para Puestos -->
                    <div id="paginacionPuestos" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; padding: 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px;">
                        <div style="font-size: 13px; color: #6c757d;">
                            Mostrando <span id="puestosDesde">0</span> a <span id="puestosHasta">0</span> de <span id="puestosTotal">0</span> registros
                        </div>
                        <div style="display: flex; gap: 5px;">
                            <button id="puestosPrevPage" style="padding: 6px 12px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; font-size: 13px;" onclick="cambiarPaginaPuestos('prev')" disabled>Anterior</button>
                            <span id="puestosPaginaActual" style="padding: 6px 12px; background-color: var(--color-primary); color: white; border-radius: 4px; font-size: 13px;">1</span>
                            <button id="puestosNextPage" style="padding: 6px 12px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; font-size: 13px;" onclick="cambiarPaginaPuestos('next')">Siguiente</button>
                        </div>
                    </div>
                    
                    <!-- Totales de Puestos -->
                    <div style="margin-top: 15px; display: flex; justify-content: flex-start; gap: 20px; padding: 10px; background-color: #e9ecef; border-radius: 4px; font-size: 13px; font-weight: bold;">
                        <span>Total Puestos: <span id="totalPuestos" style="color: var(--color-primary);">0</span></span>
                        <span style="color: #28a745;">Activos: <span id="puestosActivos">0</span></span>
                        <span style="color: #ffc107;">Inactivos: <span id="puestosInactivos">0</span></span>
                    </div>
                </div>
                
                <!-- Crear filtro (visible según pestaña activa) -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter" style="font-size: 12px;"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA AGREGAR/EDITAR ROL -->
<div id="modalRol" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 500px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTituloRol">Nuevo Rol</h3>
            <button onclick="cerrarModalRol()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <form id="formRol" onsubmit="event.preventDefault(); guardarRol();">
                @csrf
                <input type="hidden" id="modalRolId" value="">
                
                <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus</label>
                        <select id="modalEstatusRol" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Folio</label>
                        <input type="text" id="modalFolioRol" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: ROL-001" required>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Rol</label>
                        <input type="text" id="modalNombreRol" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Nombre del rol" required>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Descripción</label>
                        <textarea id="modalDescripcionRol" rows="4" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción del rol y sus permisos..."></textarea>
                    </div>
                </div>
                
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" onclick="cerrarModalRol()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                    <button type="submit" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA AGREGAR/EDITAR PUESTO -->
<div id="modalPuesto" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 500px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTituloPuesto">Nuevo Puesto</h3>
            <button onclick="cerrarModalPuesto()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <form id="formPuesto" onsubmit="event.preventDefault(); guardarPuesto();">
                @csrf
                <input type="hidden" id="modalPuestoId" value="">
                
                <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus</label>
                        <select id="modalEstatusPuesto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Folio</label>
                        <input type="text" id="modalFolioPuesto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: PUE-001" required>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Puesto</label>
                        <input type="text" id="modalNombrePuesto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Nombre del puesto" required>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Descripción</label>
                        <textarea id="modalDescripcionPuesto" rows="4" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción del puesto y sus responsabilidades..."></textarea>
                    </div>
                </div>
                
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" onclick="cerrarModalPuesto()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                    <button type="submit" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Notificación personalizada -->
<div id="notification" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 1000000; min-width: 300px; max-width: 400px; background: white; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); animation: slideInRight 0.3s ease; overflow: hidden;">
    <div id="notificationHeader" style="padding: 15px 20px; font-weight: bold; display: flex; align-items: center; gap: 10px;">
        <i id="notificationIcon" class="fas"></i>
        <span id="notificationTitle"></span>
    </div>
    <div id="notificationBody" style="padding: 15px 20px; border-top: 1px solid #eee;">
        <span id="notificationMessage"></span>
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
    
    /* Pestañas */
    .tab-rol, .tab-puesto {
        transition: all 0.2s;
        font-size: 14px;
    }
    
    .tab-rol:hover, .tab-puesto:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }
    
    /* Tabla */
    .table-container {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        overflow-x: auto;
        background-color: white;
        width: 100%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
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
        font-size: 13px;
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
        font-size: 14px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .table td:last-child i:hover {
        transform: scale(1.2);
    }
    
    .table td:last-child i.fa-edit,
    .table td:last-child i.fa-eye {
        color: var(--color-primary);
    }
    
    .table td:last-child i.fa-trash {
        color: #dc3545;
    }
    
    /* Badges de estatus */
    .badge-activo {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-inactivo {
        background-color: #ffc107;
        color: #212529;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
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
    
    /* Modal */
    #modalRol, #modalPuesto {
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
    
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .hide-mobile {
            display: none !important;
        }
        
        .table-container {
            max-height: 500px;
        }
        
        .table td {
            padding: 8px 4px;
            font-size: 12px;
        }
        
        .table td:last-child i {
            margin: 0 3px;
            font-size: 12px;
        }
        
        #modalRol > div, #modalPuesto > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        .tab-rol, .tab-puesto {
            padding: 8px 15px !important;
            font-size: 13px;
        }
        
        #notification {
            min-width: auto;
            max-width: 90%;
            right: 5%;
            left: 5%;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables para agrupación
    let columnasAgrupadasRoles = [];
    let columnasAgrupadasPuestos = [];
    
    // Variables de paginación
    let rolesPaginaActual = 1;
    let puestosPaginaActual = 1;
    let rolesPorPagina = 10;
    let puestosPorPagina = 10;
    let rolesTotalRegistros = 0;
    let puestosTotalRegistros = 0;
    let rolesDatos = [];
    let puestosDatos = [];
    
    // Variables para datos agrupados
    let rolesAgrupados = [];
    let puestosAgrupados = [];
    let modoAgrupadoRoles = false;
    let modoAgrupadoPuestos = false;
    
    // Cargar datos iniciales
    cargarDatos();
    
    // Función para cambiar número de registros por página
    window.cambiarRegistrosPorPagina = function() {
        const perPage = document.getElementById('perPage').value;
        rolesPorPagina = parseInt(perPage);
        puestosPorPagina = parseInt(perPage);
        rolesPaginaActual = 1;
        puestosPaginaActual = 1;
        renderizarTablaRoles();
        renderizarTablaPuestos();
        actualizarPaginacionRoles();
        actualizarPaginacionPuestos();
    };
    
    // Funciones de paginación para Roles
    window.cambiarPaginaRoles = function(direccion) {
        if (direccion === 'prev' && rolesPaginaActual > 1) {
            rolesPaginaActual--;
        } else if (direccion === 'next' && rolesPaginaActual < Math.ceil(rolesTotalRegistros / rolesPorPagina)) {
            rolesPaginaActual++;
        }
        renderizarTablaRoles();
        actualizarPaginacionRoles();
    };
    
    // Funciones de paginación para Puestos
    window.cambiarPaginaPuestos = function(direccion) {
        if (direccion === 'prev' && puestosPaginaActual > 1) {
            puestosPaginaActual--;
        } else if (direccion === 'next' && puestosPaginaActual < Math.ceil(puestosTotalRegistros / puestosPorPagina)) {
            puestosPaginaActual++;
        }
        renderizarTablaPuestos();
        actualizarPaginacionPuestos();
    };
    
    function actualizarPaginacionRoles() {
        const totalPaginas = Math.ceil(rolesTotalRegistros / rolesPorPagina);
        const desde = rolesTotalRegistros === 0 ? 0 : (rolesPaginaActual - 1) * rolesPorPagina + 1;
        const hasta = Math.min(rolesPaginaActual * rolesPorPagina, rolesTotalRegistros);
        
        document.getElementById('rolesDesde').textContent = desde;
        document.getElementById('rolesHasta').textContent = hasta;
        document.getElementById('rolesTotal').textContent = rolesTotalRegistros;
        document.getElementById('rolesPaginaActual').textContent = rolesPaginaActual;
        
        document.getElementById('rolesPrevPage').disabled = rolesPaginaActual === 1;
        document.getElementById('rolesNextPage').disabled = rolesPaginaActual === totalPaginas || totalPaginas === 0;
    }
    
    function actualizarPaginacionPuestos() {
        const totalPaginas = Math.ceil(puestosTotalRegistros / puestosPorPagina);
        const desde = puestosTotalRegistros === 0 ? 0 : (puestosPaginaActual - 1) * puestosPorPagina + 1;
        const hasta = Math.min(puestosPaginaActual * puestosPorPagina, puestosTotalRegistros);
        
        document.getElementById('puestosDesde').textContent = desde;
        document.getElementById('puestosHasta').textContent = hasta;
        document.getElementById('puestosTotal').textContent = puestosTotalRegistros;
        document.getElementById('puestosPaginaActual').textContent = puestosPaginaActual;
        
        document.getElementById('puestosPrevPage').disabled = puestosPaginaActual === 1;
        document.getElementById('puestosNextPage').disabled = puestosPaginaActual === totalPaginas || totalPaginas === 0;
    }
    
    // Función para mostrar notificaciones
    function mostrarNotificacion(tipo, mensaje) {
        const notification = document.getElementById('notification');
        const header = document.getElementById('notificationHeader');
        const icon = document.getElementById('notificationIcon');
        const title = document.getElementById('notificationTitle');
        const body = document.getElementById('notificationMessage');
        
        if (tipo === 'success') {
            header.style.backgroundColor = '#28a745';
            header.style.color = 'white';
            icon.className = 'fas fa-check-circle';
            title.textContent = 'Éxito';
        } else if (tipo === 'error') {
            header.style.backgroundColor = '#dc3545';
            header.style.color = 'white';
            icon.className = 'fas fa-times-circle';
            title.textContent = 'Error';
        } else if (tipo === 'warning') {
            header.style.backgroundColor = '#ffc107';
            header.style.color = '#212529';
            icon.className = 'fas fa-exclamation-triangle';
            title.textContent = 'Advertencia';
        } else {
            header.style.backgroundColor = '#17a2b8';
            header.style.color = 'white';
            icon.className = 'fas fa-info-circle';
            title.textContent = 'Información';
        }
        
        body.textContent = mensaje;
        
        notification.style.display = 'block';
        
        setTimeout(() => {
            notification.style.display = 'none';
        }, 3000);
    }
    
    // Función para cargar datos desde la API
    function cargarDatos() {
        fetch('/api/roles', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Guardar todos los datos
                rolesDatos = data.data.roles || [];
                puestosDatos = data.data.puestos || [];
                
                // Actualizar totales
                rolesTotalRegistros = rolesDatos.length;
                puestosTotalRegistros = puestosDatos.length;
                
                // Actualizar contadores
                document.getElementById('totalRolesBadge').textContent = rolesTotalRegistros;
                document.getElementById('totalPuestosBadge').textContent = puestosTotalRegistros;
                
                document.getElementById('totalRoles').textContent = rolesTotalRegistros;
                document.getElementById('rolesActivos').textContent = data.data.rolesActivos || 0;
                document.getElementById('rolesInactivos').textContent = data.data.rolesInactivos || 0;
                
                document.getElementById('totalPuestos').textContent = puestosTotalRegistros;
                document.getElementById('puestosActivos').textContent = data.data.puestosActivos || 0;
                document.getElementById('puestosInactivos').textContent = data.data.puestosInactivos || 0;
                
                // Renderizar tablas
                renderizarTablaRoles();
                renderizarTablaPuestos();
                actualizarPaginacionRoles();
                actualizarPaginacionPuestos();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('error', 'Error al cargar los datos');
        });
    }
    
    // Función para agrupar datos
    function agruparDatos(datos, columna) {
        const grupos = {};
        
        datos.forEach(item => {
            let valor = item[columna];
            if (!valor) valor = 'Sin especificar';
            
            if (!grupos[valor]) {
                grupos[valor] = [];
            }
            grupos[valor].push(item);
        });
        
        // Convertir a array de grupos
        const resultado = [];
        for (const [valor, items] of Object.entries(grupos)) {
            resultado.push({
                valor: valor,
                items: items,
                count: items.length
            });
        }
        
        return resultado;
    }
    
    function renderizarTablaRoles() {
        const tbody = document.getElementById('tablaBodyRoles');
        
        // Determinar qué datos mostrar
        let datosAMostrar = rolesDatos;
        let esAgrupado = false;
        
        if (columnasAgrupadasRoles.length > 0) {
            // Usar la primera columna para agrupar
            const columna = columnasAgrupadasRoles[0];
            rolesAgrupados = agruparDatos(rolesDatos, columna);
            datosAMostrar = rolesAgrupados;
            esAgrupado = true;
            rolesTotalRegistros = rolesAgrupados.length;
        } else {
            rolesTotalRegistros = rolesDatos.length;
        }
        
        const inicio = (rolesPaginaActual - 1) * rolesPorPagina;
        const fin = inicio + rolesPorPagina;
        const paginaActual = datosAMostrar.slice(inicio, fin);
        
        if (!paginaActual || paginaActual.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" style="padding: 30px; text-align: center; color: #6c757d;">
                        <i class="fas fa-info-circle" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                        No hay roles registrados
                    </td>
                </tr>
            `;
            actualizarPaginacionRoles();
            return;
        }
        
        let html = '';
        
        if (esAgrupado) {
            // Renderizar vista agrupada
            paginaActual.forEach((grupo, index) => {
                const bgColor = (inicio + index) % 2 === 1 ? 'style="background-color: #f8f9fa;"' : '';
                
                html += `
                    <tr ${bgColor} style="background-color: #e3f2fd; font-weight: bold;">
                        <td colspan="5" style="padding: 10px 8px; border: 1px solid #dee2e6;">
                            <i class="fas fa-folder-open" style="color: var(--color-primary); margin-right: 8px;"></i>
                            ${columnasAgrupadasRoles[0]}: ${grupo.valor} (${grupo.count} registros)
                        </td>
                    </tr>
                `;
                
                grupo.items.forEach((item, itemIndex) => {
                    const badgeColor = item.estatus === 'Activo' ? '#28a745' : '#ffc107';
                    const badgeTextColor = item.estatus === 'Activo' ? 'white' : '#212529';
                    
                    html += `
                        <tr>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; padding-left: 30px;">
                                <span style="background-color: ${badgeColor}; color: ${badgeTextColor}; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">
                                    ${item.estatus}
                                </span>
                            </td>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">${item.folio}</td>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">${item.nombre}</td>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">${item.descripcion || ''}</td>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verRol(${item.id})" title="Ver detalle"></i>
                                <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRol(${item.id})" title="Editar"></i>
                                <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="eliminarRol(${item.id})" title="Eliminar"></i>
                            </td>
                        </tr>
                    `;
                });
            });
        } else {
            // Renderizar vista normal
            paginaActual.forEach((rol, index) => {
                const bgColor = (inicio + index) % 2 === 1 ? 'style="background-color: #f8f9fa;"' : '';
                const badgeColor = rol.estatus === 'Activo' ? '#28a745' : '#ffc107';
                const badgeTextColor = rol.estatus === 'Activo' ? 'white' : '#212529';
                
                html += `
                    <tr ${bgColor}>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                            <span style="background-color: ${badgeColor}; color: ${badgeTextColor}; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">
                                ${rol.estatus}
                            </span>
                        </td>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">${rol.folio}</td>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">${rol.nombre}</td>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">${rol.descripcion || ''}</td>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                            <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verRol(${rol.id})" title="Ver detalle"></i>
                            <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRol(${rol.id})" title="Editar"></i>
                            <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="eliminarRol(${rol.id})" title="Eliminar"></i>
                        </td>
                    </tr>
                `;
            });
        }
        
        tbody.innerHTML = html;
        aplicarVisibilidadColumnas('roles');
        actualizarPaginacionRoles();
    }
    
    function renderizarTablaPuestos() {
        const tbody = document.getElementById('tablaBodyPuestos');
        
        // Determinar qué datos mostrar
        let datosAMostrar = puestosDatos;
        let esAgrupado = false;
        
        if (columnasAgrupadasPuestos.length > 0) {
            // Usar la primera columna para agrupar
            const columna = columnasAgrupadasPuestos[0];
            puestosAgrupados = agruparDatos(puestosDatos, columna);
            datosAMostrar = puestosAgrupados;
            esAgrupado = true;
            puestosTotalRegistros = puestosAgrupados.length;
        } else {
            puestosTotalRegistros = puestosDatos.length;
        }
        
        const inicio = (puestosPaginaActual - 1) * puestosPorPagina;
        const fin = inicio + puestosPorPagina;
        const paginaActual = datosAMostrar.slice(inicio, fin);
        
        if (!paginaActual || paginaActual.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" style="padding: 30px; text-align: center; color: #6c757d;">
                        <i class="fas fa-info-circle" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                        No hay puestos registrados
                    </td>
                </tr>
            `;
            actualizarPaginacionPuestos();
            return;
        }
        
        let html = '';
        
        if (esAgrupado) {
            // Renderizar vista agrupada
            paginaActual.forEach((grupo, index) => {
                const bgColor = (inicio + index) % 2 === 1 ? 'style="background-color: #f8f9fa;"' : '';
                
                html += `
                    <tr ${bgColor} style="background-color: #e3f2fd; font-weight: bold;">
                        <td colspan="5" style="padding: 10px 8px; border: 1px solid #dee2e6;">
                            <i class="fas fa-folder-open" style="color: var(--color-primary); margin-right: 8px;"></i>
                            ${columnasAgrupadasPuestos[0]}: ${grupo.valor} (${grupo.count} registros)
                        </td>
                    </tr>
                `;
                
                grupo.items.forEach((item, itemIndex) => {
                    const badgeColor = item.estatus === 'Activo' ? '#28a745' : '#ffc107';
                    const badgeTextColor = item.estatus === 'Activo' ? 'white' : '#212529';
                    
                    html += `
                        <tr>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; padding-left: 30px;">
                                <span style="background-color: ${badgeColor}; color: ${badgeTextColor}; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">
                                    ${item.estatus}
                                </span>
                            </td>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">${item.folio}</td>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">${item.nombre}</td>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">${item.descripcion || ''}</td>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verPuesto(${item.id})" title="Ver detalle"></i>
                                <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarPuesto(${item.id})" title="Editar"></i>
                                <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="eliminarPuesto(${item.id})" title="Eliminar"></i>
                            </td>
                        </tr>
                    `;
                });
            });
        } else {
            // Renderizar vista normal
            paginaActual.forEach((puesto, index) => {
                const bgColor = (inicio + index) % 2 === 1 ? 'style="background-color: #f8f9fa;"' : '';
                const badgeColor = puesto.estatus === 'Activo' ? '#28a745' : '#ffc107';
                const badgeTextColor = puesto.estatus === 'Activo' ? 'white' : '#212529';
                
                html += `
                    <tr ${bgColor}>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                            <span style="background-color: ${badgeColor}; color: ${badgeTextColor}; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">
                                ${puesto.estatus}
                            </span>
                        </td>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">${puesto.folio}</td>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">${puesto.nombre}</td>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">${puesto.descripcion || ''}</td>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                            <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verPuesto(${puesto.id})" title="Ver detalle"></i>
                            <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarPuesto(${puesto.id})" title="Editar"></i>
                            <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="eliminarPuesto(${puesto.id})" title="Eliminar"></i>
                        </td>
                    </tr>
                `;
            });
        }
        
        tbody.innerHTML = html;
        aplicarVisibilidadColumnas('puestos');
        actualizarPaginacionPuestos();
    }
    
    function aplicarVisibilidadColumnas(tipo) {
        const checkboxes = document.querySelectorAll(`#columnasLista${tipo === 'roles' ? 'Roles' : 'Puestos'} input[type="checkbox"]`);
        const indices = {
            estatus: 0,
            folio: 1,
            [tipo === 'roles' ? 'rol' : 'puesto']: 2,
            descripcion: 3
        };
        
        checkboxes.forEach(checkbox => {
            const columna = checkbox.dataset.columna;
            const index = indices[columna];
            const celdas = document.querySelectorAll(`#tabla${tipo === 'roles' ? 'Roles' : 'Puestos'} td:nth-child(${index + 1}), #tabla${tipo === 'roles' ? 'Roles' : 'Puestos'} th:nth-child(${index + 1})`);
            
            celdas.forEach(celda => {
                celda.style.display = checkbox.checked ? '' : 'none';
            });
        });
    }
    
    // Función para cambiar entre pestañas
    window.switchTab = function(tab) {
        if (tab === 'roles') {
            document.getElementById('panelRoles').style.display = 'block';
            document.getElementById('panelPuestos').style.display = 'none';
            document.getElementById('tabRoles').style.backgroundColor = 'var(--color-primary)';
            document.getElementById('tabRoles').style.color = 'white';
            document.getElementById('tabPuestos').style.backgroundColor = '#e9ecef';
            document.getElementById('tabPuestos').style.color = '#495057';
        } else {
            document.getElementById('panelRoles').style.display = 'none';
            document.getElementById('panelPuestos').style.display = 'block';
            document.getElementById('tabPuestos').style.backgroundColor = 'var(--color-primary)';
            document.getElementById('tabPuestos').style.color = 'white';
            document.getElementById('tabRoles').style.backgroundColor = '#e9ecef';
            document.getElementById('tabRoles').style.color = '#495057';
        }
    };
    
    // Funciones para Roles
    window.abrirModalRol = function(id = null) {
        document.getElementById('modalTituloRol').textContent = id ? 'Editar Rol' : 'Nuevo Rol';
        document.getElementById('modalRolId').value = id || '';
        
        if (id) {
            console.log('Cargando datos para editar rol ID:', id);
            
            fetch(`/api/roles/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al cargar los datos');
                }
                return response.json();
            })
            .then(data => {
                console.log('Datos recibidos:', data);
                if (data.success) {
                    document.getElementById('modalEstatusRol').value = data.data.estatus;
                    document.getElementById('modalFolioRol').value = data.data.folio;
                    document.getElementById('modalNombreRol').value = data.data.nombre;
                    document.getElementById('modalDescripcionRol').value = data.data.descripcion || '';
                    document.getElementById('modalRol').style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                } else {
                    mostrarNotificacion('error', 'Error al cargar los datos del rol');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarNotificacion('error', 'Error al cargar los datos del rol');
            });
        } else {
            document.getElementById('modalEstatusRol').value = 'Activo';
            document.getElementById('modalFolioRol').value = '';
            document.getElementById('modalNombreRol').value = '';
            document.getElementById('modalDescripcionRol').value = '';
            document.getElementById('modalRol').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    };
    
    window.editarRol = function(id) {
        abrirModalRol(id);
    };
    
    window.verRol = function(id) {
        fetch(`/api/roles/${id}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Rol: ${data.data.nombre}\nFolio: ${data.data.folio}\nDescripción: ${data.data.descripcion}\nEstatus: ${data.data.estatus}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('error', 'Error al cargar los datos del rol');
        });
    };
    
    window.cerrarModalRol = function() {
        document.getElementById('modalRol').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.guardarRol = function() {
        const id = document.getElementById('modalRolId').value;
        console.log('=== GUARDAR ROL ===');
        console.log('ID del modal:', id);
        
        // Asegurar que el ID sea un número si existe
        const numericId = id ? parseInt(id) : null;
        console.log('ID numérico:', numericId);
        
        // Si hay ID pero no es número válido, mostrar error
        if (id && isNaN(numericId)) {
            console.error('ID no es un número válido');
            mostrarNotificacion('error', 'ID de rol no válido');
            return;
        }
        
        const data = {
            folio: document.getElementById('modalFolioRol').value,
            nombre: document.getElementById('modalNombreRol').value,
            descripcion: document.getElementById('modalDescripcionRol').value,
            estatus: document.getElementById('modalEstatusRol').value
        };
        
        console.log('Datos a guardar:', data);

        // Determinar URL y método basado en si hay ID
        const url = numericId ? `/api/roles/${numericId}` : '/api/roles';
        const method = numericId ? 'PUT' : 'POST';
        
        console.log('URL:', url);
        console.log('Método:', method);
        console.log('URL completa:', window.location.origin + url);

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            console.log('Respuesta status:', response.status);
            console.log('Respuesta OK:', response.ok);
            return response.json().then(data => {
                if (!response.ok) {
                    throw { status: response.status, data: data };
                }
                return data;
            });
        })
        .then(data => {
            console.log('Respuesta data:', data);
            if (data.success) {
                mostrarNotificacion('success', data.message || 'Rol guardado exitosamente');
                cerrarModalRol();
                cargarDatos();
            } else {
                if (data.errors) {
                    const mensajes = Object.values(data.errors).flat().join('\n');
                    mostrarNotificacion('error', mensajes);
                } else {
                    mostrarNotificacion('error', data.message || 'Error al guardar el rol');
                }
            }
        })
        .catch(error => {
            console.error('Error completo:', error);
            if (error.data && error.data.message) {
                mostrarNotificacion('error', error.data.message);
            } else if (error.data && error.data.errors) {
                const mensajes = Object.values(error.data.errors).flat().join('\n');
                mostrarNotificacion('error', mensajes);
            } else {
                mostrarNotificacion('error', 'Error de conexión al servidor');
            }
        });
    };
    
    window.eliminarRol = function(id) {
        console.log('=== ELIMINAR ROL ===');
        console.log('ID recibido:', id);
        
        if (!id) {
            mostrarNotificacion('error', 'ID de rol no válido');
            return;
        }
        
        if (confirm('¿Estás seguro de eliminar este rol?')) {
            const numericId = parseInt(id);
            const url = `/api/roles/${numericId}`;
            console.log('URL de la petición:', url);
            
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('Respuesta status:', response.status);
                return response.json().then(data => {
                    if (!response.ok) {
                        throw { status: response.status, data: data };
                    }
                    return data;
                });
            })
            .then(data => {
                console.log('Respuesta data:', data);
                if (data.success) {
                    mostrarNotificacion('success', data.message || 'Rol eliminado exitosamente');
                    cargarDatos();
                } else {
                    mostrarNotificacion('error', data.message || 'Error al eliminar el rol');
                }
            })
            .catch(error => {
                console.error('Error completo:', error);
                if (error.data && error.data.message) {
                    mostrarNotificacion('error', error.data.message);
                } else {
                    mostrarNotificacion('error', 'Error de conexión al servidor');
                }
            });
        }
    };
    
    // Funciones para Puestos (similares a Roles)
    window.abrirModalPuesto = function(id = null) {
        document.getElementById('modalTituloPuesto').textContent = id ? 'Editar Puesto' : 'Nuevo Puesto';
        document.getElementById('modalPuestoId').value = id || '';
        
        if (id) {
            console.log('Cargando datos para editar puesto ID:', id);
            
            fetch(`/api/puestos/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al cargar los datos');
                }
                return response.json();
            })
            .then(data => {
                console.log('Datos recibidos:', data);
                if (data.success) {
                    document.getElementById('modalEstatusPuesto').value = data.data.estatus;
                    document.getElementById('modalFolioPuesto').value = data.data.folio;
                    document.getElementById('modalNombrePuesto').value = data.data.nombre;
                    document.getElementById('modalDescripcionPuesto').value = data.data.descripcion || '';
                    document.getElementById('modalPuesto').style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                } else {
                    mostrarNotificacion('error', 'Error al cargar los datos del puesto');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarNotificacion('error', 'Error al cargar los datos del puesto');
            });
        } else {
            document.getElementById('modalEstatusPuesto').value = 'Activo';
            document.getElementById('modalFolioPuesto').value = '';
            document.getElementById('modalNombrePuesto').value = '';
            document.getElementById('modalDescripcionPuesto').value = '';
            document.getElementById('modalPuesto').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    };
    
    window.editarPuesto = function(id) {
        abrirModalPuesto(id);
    };
    
    window.verPuesto = function(id) {
        fetch(`/api/puestos/${id}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Puesto: ${data.data.nombre}\nFolio: ${data.data.folio}\nDescripción: ${data.data.descripcion}\nEstatus: ${data.data.estatus}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('error', 'Error al cargar los datos del puesto');
        });
    };
    
    window.cerrarModalPuesto = function() {
        document.getElementById('modalPuesto').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.guardarPuesto = function() {
        const id = document.getElementById('modalPuestoId').value;
        console.log('=== GUARDAR PUESTO ===');
        console.log('ID del modal:', id);
        
        const numericId = id ? parseInt(id) : null;
        console.log('ID numérico:', numericId);
        
        if (id && isNaN(numericId)) {
            console.error('ID no es un número válido');
            mostrarNotificacion('error', 'ID de puesto no válido');
            return;
        }
        
        const data = {
            folio: document.getElementById('modalFolioPuesto').value,
            nombre: document.getElementById('modalNombrePuesto').value,
            descripcion: document.getElementById('modalDescripcionPuesto').value,
            estatus: document.getElementById('modalEstatusPuesto').value
        };
        
        console.log('Datos a guardar:', data);

        const url = numericId ? `/api/puestos/${numericId}` : '/api/puestos';
        const method = numericId ? 'PUT' : 'POST';
        
        console.log('URL:', url);
        console.log('Método:', method);

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            console.log('Respuesta status:', response.status);
            return response.json().then(data => {
                if (!response.ok) {
                    throw { status: response.status, data: data };
                }
                return data;
            });
        })
        .then(data => {
            console.log('Respuesta data:', data);
            if (data.success) {
                mostrarNotificacion('success', data.message || 'Puesto guardado exitosamente');
                cerrarModalPuesto();
                cargarDatos();
            } else {
                if (data.errors) {
                    const mensajes = Object.values(data.errors).flat().join('\n');
                    mostrarNotificacion('error', mensajes);
                } else {
                    mostrarNotificacion('error', data.message || 'Error al guardar el puesto');
                }
            }
        })
        .catch(error => {
            console.error('Error completo:', error);
            if (error.data && error.data.message) {
                mostrarNotificacion('error', error.data.message);
            } else if (error.data && error.data.errors) {
                const mensajes = Object.values(error.data.errors).flat().join('\n');
                mostrarNotificacion('error', mensajes);
            } else {
                mostrarNotificacion('error', 'Error de conexión al servidor');
            }
        });
    };
    
    window.eliminarPuesto = function(id) {
        console.log('=== ELIMINAR PUESTO ===');
        console.log('ID recibido:', id);
        
        if (!id) {
            mostrarNotificacion('error', 'ID de puesto no válido');
            return;
        }
        
        if (confirm('¿Estás seguro de eliminar este puesto?')) {
            const numericId = parseInt(id);
            const url = `/api/puestos/${numericId}`;
            console.log('URL de la petición:', url);
            
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('Respuesta status:', response.status);
                return response.json().then(data => {
                    if (!response.ok) {
                        throw { status: response.status, data: data };
                    }
                    return data;
                });
            })
            .then(data => {
                console.log('Respuesta data:', data);
                if (data.success) {
                    mostrarNotificacion('success', data.message || 'Puesto eliminado exitosamente');
                    cargarDatos();
                } else {
                    mostrarNotificacion('error', data.message || 'Error al eliminar el puesto');
                }
            })
            .catch(error => {
                console.error('Error completo:', error);
                if (error.data && error.data.message) {
                    mostrarNotificacion('error', error.data.message);
                } else {
                    mostrarNotificacion('error', 'Error de conexión al servidor');
                }
            });
        }
    };
    
    // Funciones de exportación
    window.exportarRolesExcel = function() {
        fetch('/roles/exportar-excel', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            mostrarNotificacion('info', data.message || 'Exportación en desarrollo');
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('error', 'Error al exportar roles');
        });
    };
    
    window.exportarPuestosExcel = function() {
        fetch('/puestos/exportar-excel', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            mostrarNotificacion('info', data.message || 'Exportación en desarrollo');
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('error', 'Error al exportar puestos');
        });
    };
    
    // Cerrar modales con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalRol();
            cerrarModalPuesto();
        }
    });
    
    // Cerrar modales al hacer clic fuera
    document.getElementById('modalRol').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalRol();
        }
    });
    
    document.getElementById('modalPuesto').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalPuesto();
        }
    });
    
    // Funciones de agrupación para Roles
    function actualizarGrupoColumnasRoles() {
        const container = document.getElementById('grupoColumnasRoles');
        const texto = document.getElementById('textoAgruparRoles');
        
        container.innerHTML = '';
        
        if (columnasAgrupadasRoles.length === 0) {
            texto.style.display = 'inline';
            modoAgrupadoRoles = false;
        } else {
            texto.style.display = 'none';
            modoAgrupadoRoles = true;
            columnasAgrupadasRoles.forEach(col => {
                const chip = document.createElement('span');
                chip.className = 'columna-agrupada';
                chip.innerHTML = `${col} <span class="remover" onclick="removerColumnaRoles('${col}')">&times;</span>`;
                container.appendChild(chip);
            });
        }
        
        // Resetear a primera página y renderizar
        rolesPaginaActual = 1;
        renderizarTablaRoles();
    }

    window.removerColumnaRoles = function(columna) {
        columnasAgrupadasRoles = columnasAgrupadasRoles.filter(c => c !== columna);
        actualizarGrupoColumnasRoles();
        mostrarNotificacion('info', 'Desagrupando por: ' + columna);
    };
    
    // Funciones de agrupación para Puestos
    function actualizarGrupoColumnasPuestos() {
        const container = document.getElementById('grupoColumnasPuestos');
        const texto = document.getElementById('textoAgruparPuestos');
        
        container.innerHTML = '';
        
        if (columnasAgrupadasPuestos.length === 0) {
            texto.style.display = 'inline';
            modoAgrupadoPuestos = false;
        } else {
            texto.style.display = 'none';
            modoAgrupadoPuestos = true;
            columnasAgrupadasPuestos.forEach(col => {
                const chip = document.createElement('span');
                chip.className = 'columna-agrupada';
                chip.innerHTML = `${col} <span class="remover" onclick="removerColumnaPuestos('${col}')">&times;</span>`;
                container.appendChild(chip);
            });
        }
        
        // Resetear a primera página y renderizar
        puestosPaginaActual = 1;
        renderizarTablaPuestos();
    }

    window.removerColumnaPuestos = function(columna) {
        columnasAgrupadasPuestos = columnasAgrupadasPuestos.filter(c => c !== columna);
        actualizarGrupoColumnasPuestos();
        mostrarNotificacion('info', 'Desagrupando por: ' + columna);
    };

    // Drag & drop para Roles
    document.getElementById('grupoAgrupacionRoles').addEventListener('dragover', (e) => e.preventDefault());
    
    document.getElementById('grupoAgrupacionRoles').addEventListener('drop', (e) => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadasRoles.includes(columna)) {
            columnasAgrupadasRoles.push(columna);
            actualizarGrupoColumnasRoles();
            mostrarNotificacion('info', 'Agrupando roles por: ' + columna);
        }
    });
    
    // Drag & drop para Puestos
    document.getElementById('grupoAgrupacionPuestos').addEventListener('dragover', (e) => e.preventDefault());
    
    document.getElementById('grupoAgrupacionPuestos').addEventListener('drop', (e) => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadasPuestos.includes(columna)) {
            columnasAgrupadasPuestos.push(columna);
            actualizarGrupoColumnasPuestos();
            mostrarNotificacion('info', 'Agrupando puestos por: ' + columna);
        }
    });

    // Inicializar drag & drop para las columnas
    document.querySelectorAll('[draggable="true"]').forEach(th => {
        th.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('text/plain', e.target.dataset.columna);
        });
    });

    // Selector de columnas
    window.toggleColumnSelector = function(tipo) {
        const selector = document.getElementById('columnSelector' + (tipo === 'roles' ? 'Roles' : 'Puestos'));
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
        
        if (selector.style.display === 'block') {
            const lista = document.getElementById('columnasLista' + (tipo === 'roles' ? 'Roles' : 'Puestos'));
            const columnas = tipo === 'roles' 
                ? [
                    { field: 'estatus', caption: 'Estatus' },
                    { field: 'folio', caption: 'Folio' },
                    { field: 'rol', caption: 'Rol' },
                    { field: 'descripcion', caption: 'Descripción' }
                  ]
                : [
                    { field: 'estatus', caption: 'Estatus' },
                    { field: 'folio', caption: 'Folio' },
                    { field: 'puesto', caption: 'Puesto' },
                    { field: 'descripcion', caption: 'Descripción' }
                  ];
            
            lista.innerHTML = columnas.map(col => `
                <div style="padding: 5px 0; display: flex; align-items: center;">
                    <input type="checkbox" 
                           id="chk_${col.field}_${tipo}"
                           data-columna="${col.field}"
                           checked
                           style="margin-right: 8px; accent-color: var(--color-primary);"
                           onchange="toggleColumna('${tipo}', '${col.field}', this.checked)">
                    <label for="chk_${col.field}_${tipo}" style="font-size: 12px;">${col.caption}</label>
                </div>
            `).join('');
        }
    };
    
    window.toggleColumna = function(tipo, columna, visible) {
        const indices = {
            estatus: 0,
            folio: 1,
            [tipo === 'roles' ? 'rol' : 'puesto']: 2,
            descripcion: 3
        };
        
        const index = indices[columna];
        const celdas = document.querySelectorAll(`#tabla${tipo === 'roles' ? 'Roles' : 'Puestos'} td:nth-child(${index + 1}), #tabla${tipo === 'roles' ? 'Roles' : 'Puestos'} th:nth-child(${index + 1})`);
        
        celdas.forEach(celda => {
            celda.style.display = visible ? '' : 'none';
        });
    };

    window.cerrarColumnSelector = function(tipo) {
        document.getElementById('columnSelector' + (tipo === 'roles' ? 'Roles' : 'Puestos')).style.display = 'none';
    };

    // Cerrar selectores al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#btnColumnasRoles') && !e.target.closest('#columnSelectorRoles')) {
            document.getElementById('columnSelectorRoles').style.display = 'none';
        }
        if (!e.target.closest('#btnColumnasPuestos') && !e.target.closest('#columnSelectorPuestos')) {
            document.getElementById('columnSelectorPuestos').style.display = 'none';
        }
    });

    // Botón Crear filtro
    document.getElementById('btnCrearFiltro').addEventListener('click', () => {
        mostrarNotificacion('info', 'Funcionalidad de filtro en desarrollo');
    });

    // Buscadores
    document.getElementById('buscadorRoles').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        const filas = document.querySelectorAll('#tablaBodyRoles tr');
        let visibleCount = 0;
        
        filas.forEach(fila => {
            if (fila.cells && fila.cells.length > 1 && !fila.querySelector('td[colspan]')) {
                const texto = fila.textContent.toLowerCase();
                const visible = texto.includes(termino);
                fila.style.display = visible ? '' : 'none';
                if (visible) visibleCount++;
            }
        });
        
        const tbody = document.getElementById('tablaBodyRoles');
        const noResultsRow = document.getElementById('noResultsRoles');
        
        if (visibleCount === 0 && termino !== '' && !noResultsRow) {
            const row = document.createElement('tr');
            row.id = 'noResultsRoles';
            row.innerHTML = '<td colspan="5" style="padding: 20px; text-align: center; color: #6c757d;">No se encontraron roles que coincidan con la búsqueda</td>';
            tbody.appendChild(row);
        } else if (visibleCount > 0 && noResultsRow) {
            noResultsRow.remove();
        } else if (termino === '' && noResultsRow) {
            noResultsRow.remove();
        }
    });
    
    document.getElementById('buscadorPuestos').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        const filas = document.querySelectorAll('#tablaBodyPuestos tr');
        let visibleCount = 0;
        
        filas.forEach(fila => {
            if (fila.cells && fila.cells.length > 1 && !fila.querySelector('td[colspan]')) {
                const texto = fila.textContent.toLowerCase();
                const visible = texto.includes(termino);
                fila.style.display = visible ? '' : 'none';
                if (visible) visibleCount++;
            }
        });
        
        const tbody = document.getElementById('tablaBodyPuestos');
        const noResultsRow = document.getElementById('noResultsPuestos');
        
        if (visibleCount === 0 && termino !== '' && !noResultsRow) {
            const row = document.createElement('tr');
            row.id = 'noResultsPuestos';
            row.innerHTML = '<td colspan="5" style="padding: 20px; text-align: center; color: #6c757d;">No se encontraron puestos que coincidan con la búsqueda</td>';
            tbody.appendChild(row);
        } else if (visibleCount > 0 && noResultsRow) {
            noResultsRow.remove();
        } else if (termino === '' && noResultsRow) {
            noResultsRow.remove();
        }
    });

    // Inicializar selectores de columnas
    function inicializarSelectoresColumnas() {
        const columnasRoles = [
            { field: 'estatus', caption: 'Estatus' },
            { field: 'folio', caption: 'Folio' },
            { field: 'rol', caption: 'Rol' },
            { field: 'descripcion', caption: 'Descripción' }
        ];
        
        const listaRoles = document.getElementById('columnasListaRoles');
        if (listaRoles && listaRoles.children.length === 0) {
            listaRoles.innerHTML = columnasRoles.map(col => `
                <div style="padding: 5px 0; display: flex; align-items: center;">
                    <input type="checkbox" 
                           id="chk_${col.field}_roles"
                           data-columna="${col.field}"
                           checked
                           style="margin-right: 8px; accent-color: var(--color-primary);"
                           onchange="toggleColumna('roles', '${col.field}', this.checked)">
                    <label for="chk_${col.field}_roles" style="font-size: 12px;">${col.caption}</label>
                </div>
            `).join('');
        }
        
        const columnasPuestos = [
            { field: 'estatus', caption: 'Estatus' },
            { field: 'folio', caption: 'Folio' },
            { field: 'puesto', caption: 'Puesto' },
            { field: 'descripcion', caption: 'Descripción' }
        ];
        
        const listaPuestos = document.getElementById('columnasListaPuestos');
        if (listaPuestos && listaPuestos.children.length === 0) {
            listaPuestos.innerHTML = columnasPuestos.map(col => `
                <div style="padding: 5px 0; display: flex; align-items: center;">
                    <input type="checkbox" 
                           id="chk_${col.field}_puestos"
                           data-columna="${col.field}"
                           checked
                           style="margin-right: 8px; accent-color: var(--color-primary);"
                           onchange="toggleColumna('puestos', '${col.field}', this.checked)">
                    <label for="chk_${col.field}_puestos" style="font-size: 12px;">${col.caption}</label>
                </div>
            `).join('');
        }
    }
    
    inicializarSelectoresColumnas();
});
</script>
@endsection