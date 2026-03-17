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
                <!-- Pestañas de navegación -->
                <div style="display: flex; border-bottom: 2px solid #dee2e6; margin-bottom: 20px;">
                    <button class="tab-rol active" onclick="switchTab('roles')" id="tabRoles" style="background-color: var(--color-primary); color: white; border: none; padding: 10px 25px; border-radius: 8px 8px 0 0; margin-right: 5px; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-user-tag"></i> Roles
                    </button>
                    <button class="tab-puesto" onclick="switchTab('puestos')" id="tabPuestos" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; border-radius: 8px 8px 0 0; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-briefcase"></i> Puestos
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
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
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
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">ROL-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">Administrador</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Acceso completo a todos los módulos del sistema, configuración y usuarios</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del rol')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRol('ROL-001')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar rol?')) alert('Rol eliminado')" title="Eliminar"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">ROL-002</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">Gerente de Proyectos</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Acceso a módulos de proyectos, reportes y asignación de recursos. Sin acceso a configuración.</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del rol')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRol('ROL-002')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar rol?')) alert('Rol eliminado')" title="Eliminar"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">ROL-003</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">Supervisor de Obra</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Acceso a obras asignadas, reportes de avance, solicitud de materiales y asistencia.</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del rol')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRol('ROL-003')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar rol?')) alert('Rol eliminado')" title="Eliminar"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">ROL-004</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">Residente de Obra</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Acceso completo a su obra, gestión de personal, reportes diarios y control de calidad.</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del rol')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRol('ROL-004')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar rol?')) alert('Rol eliminado')" title="Eliminar"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">ROL-005</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">Almacenista</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Acceso a inventarios, entradas y salidas de materiales, solicitudes de compra.</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del rol')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRol('ROL-005')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar rol?')) alert('Rol eliminado')" title="Eliminar"></i>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot style="background-color: #e9ecef; font-weight: bold;">
                                <tr>
                                    <td colspan="5" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 13px;">Total Roles: 5 | Activos: 5 | Inactivos: 0</td>
                                </tr>
                            </tfoot>
                        </table>
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
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
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
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">PUE-001</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">Arquitecto</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Diseño y supervisión de planos arquitectónicos, coordinación con clientes.</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del puesto')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarPuesto('PUE-001')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar puesto?')) alert('Puesto eliminado')" title="Eliminar"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">PUE-002</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">Ingeniero Civil</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Cálculo estructural, supervisión de obra, control de calidad de materiales.</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del puesto')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarPuesto('PUE-002')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar puesto?')) alert('Puesto eliminado')" title="Eliminar"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">PUE-003</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">Albañil</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Construcción de muros, columnas, losas y acabados en obra.</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del puesto')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarPuesto('PUE-003')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar puesto?')) alert('Puesto eliminado')" title="Eliminar"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">PUE-004</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">Electricista</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Instalación y mantenimiento de sistemas eléctricos en obra.</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del puesto')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarPuesto('PUE-004')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar puesto?')) alert('Puesto eliminado')" title="Eliminar"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">PUE-005</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">Plomero</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Instalación de tuberías, conexiones hidrosanitarias y accesorios.</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del puesto')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarPuesto('PUE-005')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar puesto?')) alert('Puesto eliminado')" title="Eliminar"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">PUE-006</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left; font-weight: 500;">Carpintero</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Fabricación e instalación de estructuras de madera, cimbra y acabados.</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del puesto')" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarPuesto('PUE-006')" title="Editar"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar puesto?')) alert('Puesto eliminado')" title="Eliminar"></i>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot style="background-color: #e9ecef; font-weight: bold;">
                                <tr>
                                    <td colspan="5" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 13px;">Total Puestos: 6 | Activos: 6 | Inactivos: 0</td>
                                </tr>
                            </tfoot>
                        </table>
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
            <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus</label>
                    <select id="modalEstatusRol" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Folio</label>
                    <input type="text" id="modalFolioRol" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="ROL-006">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Rol</label>
                    <input type="text" id="modalNombreRol" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Nombre del rol">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Descripción</label>
                    <textarea id="modalDescripcionRol" rows="4" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción del rol y sus permisos..."></textarea>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalRol()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarRol()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
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
            <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus</label>
                    <select id="modalEstatusPuesto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Folio</label>
                    <input type="text" id="modalFolioPuesto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="PUE-007">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Puesto</label>
                    <input type="text" id="modalNombrePuesto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Nombre del puesto">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Descripción</label>
                    <textarea id="modalDescripcionPuesto" rows="4" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción del puesto y sus responsabilidades..."></textarea>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalPuesto()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarPuesto()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
        </div>
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
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadasRoles = [];
    let columnasAgrupadasPuestos = [];
    
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
    window.abrirModalRol = function() {
        document.getElementById('modalTituloRol').textContent = 'Nuevo Rol';
        document.getElementById('modalEstatusRol').value = 'Activo';
        document.getElementById('modalFolioRol').value = '';
        document.getElementById('modalNombreRol').value = '';
        document.getElementById('modalDescripcionRol').value = '';
        document.getElementById('modalRol').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.editarRol = function(folio) {
        document.getElementById('modalTituloRol').textContent = 'Editar Rol - ' + folio;
        
        // Simular carga de datos
        if (folio === 'ROL-001') {
            document.getElementById('modalEstatusRol').value = 'Activo';
            document.getElementById('modalFolioRol').value = 'ROL-001';
            document.getElementById('modalNombreRol').value = 'Administrador';
            document.getElementById('modalDescripcionRol').value = 'Acceso completo a todos los módulos del sistema, configuración y usuarios';
        } else if (folio === 'ROL-002') {
            document.getElementById('modalEstatusRol').value = 'Activo';
            document.getElementById('modalFolioRol').value = 'ROL-002';
            document.getElementById('modalNombreRol').value = 'Gerente de Proyectos';
            document.getElementById('modalDescripcionRol').value = 'Acceso a módulos de proyectos, reportes y asignación de recursos. Sin acceso a configuración.';
        } else {
            document.getElementById('modalEstatusRol').value = 'Activo';
            document.getElementById('modalFolioRol').value = folio;
            document.getElementById('modalNombreRol').value = 'Rol de ejemplo';
            document.getElementById('modalDescripcionRol').value = 'Descripción del rol';
        }
        
        document.getElementById('modalRol').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalRol = function() {
        document.getElementById('modalRol').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.guardarRol = function() {
        const estatus = document.getElementById('modalEstatusRol').value;
        const folio = document.getElementById('modalFolioRol').value;
        const nombre = document.getElementById('modalNombreRol').value;
        const descripcion = document.getElementById('modalDescripcionRol').value;
        
        if (!folio || !nombre || !descripcion) {
            alert('Por favor complete todos los campos');
            return;
        }
        
        alert(`Rol ${folio} guardado correctamente`);
        cerrarModalRol();
    };
    
    // Funciones para Puestos
    window.abrirModalPuesto = function() {
        document.getElementById('modalTituloPuesto').textContent = 'Nuevo Puesto';
        document.getElementById('modalEstatusPuesto').value = 'Activo';
        document.getElementById('modalFolioPuesto').value = '';
        document.getElementById('modalNombrePuesto').value = '';
        document.getElementById('modalDescripcionPuesto').value = '';
        document.getElementById('modalPuesto').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.editarPuesto = function(folio) {
        document.getElementById('modalTituloPuesto').textContent = 'Editar Puesto - ' + folio;
        
        // Simular carga de datos
        if (folio === 'PUE-001') {
            document.getElementById('modalEstatusPuesto').value = 'Activo';
            document.getElementById('modalFolioPuesto').value = 'PUE-001';
            document.getElementById('modalNombrePuesto').value = 'Arquitecto';
            document.getElementById('modalDescripcionPuesto').value = 'Diseño y supervisión de planos arquitectónicos, coordinación con clientes.';
        } else if (folio === 'PUE-002') {
            document.getElementById('modalEstatusPuesto').value = 'Activo';
            document.getElementById('modalFolioPuesto').value = 'PUE-002';
            document.getElementById('modalNombrePuesto').value = 'Ingeniero Civil';
            document.getElementById('modalDescripcionPuesto').value = 'Cálculo estructural, supervisión de obra, control de calidad de materiales.';
        } else {
            document.getElementById('modalEstatusPuesto').value = 'Activo';
            document.getElementById('modalFolioPuesto').value = folio;
            document.getElementById('modalNombrePuesto').value = 'Puesto de ejemplo';
            document.getElementById('modalDescripcionPuesto').value = 'Descripción del puesto';
        }
        
        document.getElementById('modalPuesto').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalPuesto = function() {
        document.getElementById('modalPuesto').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.guardarPuesto = function() {
        const estatus = document.getElementById('modalEstatusPuesto').value;
        const folio = document.getElementById('modalFolioPuesto').value;
        const nombre = document.getElementById('modalNombrePuesto').value;
        const descripcion = document.getElementById('modalDescripcionPuesto').value;
        
        if (!folio || !nombre || !descripcion) {
            alert('Por favor complete todos los campos');
            return;
        }
        
        alert(`Puesto ${folio} guardado correctamente`);
        cerrarModalPuesto();
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
        } else {
            texto.style.display = 'none';
            columnasAgrupadasRoles.forEach(col => {
                const chip = document.createElement('span');
                chip.className = 'columna-agrupada';
                chip.innerHTML = `${col} <span class="remover" onclick="removerColumnaRoles('${col}')">&times;</span>`;
                container.appendChild(chip);
            });
        }
    }

    window.removerColumnaRoles = function(columna) {
        columnasAgrupadasRoles = columnasAgrupadasRoles.filter(c => c !== columna);
        actualizarGrupoColumnasRoles();
    };
    
    // Funciones de agrupación para Puestos
    function actualizarGrupoColumnasPuestos() {
        const container = document.getElementById('grupoColumnasPuestos');
        const texto = document.getElementById('textoAgruparPuestos');
        
        container.innerHTML = '';
        
        if (columnasAgrupadasPuestos.length === 0) {
            texto.style.display = 'inline';
        } else {
            texto.style.display = 'none';
            columnasAgrupadasPuestos.forEach(col => {
                const chip = document.createElement('span');
                chip.className = 'columna-agrupada';
                chip.innerHTML = `${col} <span class="remover" onclick="removerColumnaPuestos('${col}')">&times;</span>`;
                container.appendChild(chip);
            });
        }
    }

    window.removerColumnaPuestos = function(columna) {
        columnasAgrupadasPuestos = columnasAgrupadasPuestos.filter(c => c !== columna);
        actualizarGrupoColumnasPuestos();
    };

    // Drag & drop para Roles
    document.getElementById('grupoAgrupacionRoles').addEventListener('dragover', (e) => e.preventDefault());
    
    document.getElementById('grupoAgrupacionRoles').addEventListener('drop', (e) => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadasRoles.includes(columna)) {
            columnasAgrupadasRoles.push(columna);
            actualizarGrupoColumnasRoles();
            alert('Agrupando roles por: ' + columna);
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
            alert('Agrupando puestos por: ' + columna);
        }
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
                           style="margin-right: 8px; accent-color: var(--color-primary);">
                    <label for="chk_${col.field}_${tipo}" style="font-size: 12px;">${col.caption}</label>
                </div>
            `).join('');
        }
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

    // Botones
    document.getElementById('btnCrearFiltro').addEventListener('click', () => alert('Funcionalidad de filtro en desarrollo'));
    document.getElementById('btnExcelRoles').addEventListener('click', () => alert('Exportar roles a Excel'));
    document.getElementById('btnExcelPuestos').addEventListener('click', () => alert('Exportar puestos a Excel'));

    // Buscadores
    document.getElementById('buscadorRoles').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        console.log('Buscando en roles:', termino);
    });
    
    document.getElementById('buscadorPuestos').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        console.log('Buscando en puestos:', termino);
    });
});
</script>
@endsection