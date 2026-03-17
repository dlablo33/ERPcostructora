@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Usuarios del Sistema -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Usuarios del Sistema
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Grupo de agrupación -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <!-- Botones -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <!-- Botón Agregar (+) -->
                        <div>
                            <button id="btnAgregar" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                    title="Agregar usuario"
                                    onclick="abrirModalUsuario()">
                                <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Excel</span>
                            </button>
                        </div>

                        <!-- Botón Seleccionar Columnas -->
                        <div style="position: relative;">
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                    onclick="toggleColumnSelector()">
                                <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Columnas</span>
                            </button>
                            
                            <!-- Selector de columnas -->
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 280px; max-height: 350px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative; min-width: 220px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar usuario..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Usuarios -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaUsuarios" style="width: 100%; border-collapse: collapse; font-size: 13px; min-width: 800px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 12%;" draggable="true" data-columna="folio">Folio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 25%;" draggable="true" data-columna="empleado">Empleado</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 25%;" draggable="true" data-columna="correo">Correo</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 18%;" draggable="true" data-columna="rol">Rol</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 10%;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35; box-shadow: -2px 0 5px rgba(0,0,0,0.1); width: 10%;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">USR-001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JUAN CARLOS PÉREZ LÓPEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">juan.perez@empresa.com</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Administrador</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del usuario')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarUsuario('USR-001')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar usuario?')) alert('Usuario eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-key" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Restablecer contraseña')" title="Restablecer contraseña"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">USR-002</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">MARÍA FERNANDA RAMOS GARCÍA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">maria.ramos@empresa.com</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Gerente de Proyectos</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del usuario')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarUsuario('USR-002')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar usuario?')) alert('Usuario eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-key" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Restablecer contraseña')" title="Restablecer contraseña"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">USR-003</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">CARLOS ALBERTO MENDOZA SÁNCHEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">carlos.mendoza@empresa.com</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Supervisor de Obra</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del usuario')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarUsuario('USR-003')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar usuario?')) alert('Usuario eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-key" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Restablecer contraseña')" title="Restablecer contraseña"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">USR-004</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ANA SOFÍA MARTÍNEZ FLORES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ana.martinez@empresa.com</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Residente de Obra</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del usuario')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarUsuario('USR-004')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar usuario?')) alert('Usuario eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-key" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Restablecer contraseña')" title="Restablecer contraseña"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">USR-005</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ROBERTO ANTONIO SÁNCHEZ TORRES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">roberto.sanchez@empresa.com</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Almacenista</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del usuario')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarUsuario('USR-005')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar usuario?')) alert('Usuario eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-key" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Restablecer contraseña')" title="Restablecer contraseña"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">USR-006</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">LAURA PATRICIA FLORES GONZÁLEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">laura.flores@empresa.com</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Recursos Humanos</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del usuario')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarUsuario('USR-006')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar usuario?')) alert('Usuario eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-key" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Restablecer contraseña')" title="Restablecer contraseña"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">USR-007</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">JOSÉ LUIS TORRES RAMÍREZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">jose.torres@empresa.com</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Finanzas</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del usuario')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarUsuario('USR-007')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar usuario?')) alert('Usuario eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-key" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Restablecer contraseña')" title="Restablecer contraseña"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">USR-008</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">PATRICIA ELIZABETH CASTILLO VEGA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">patricia.castillo@empresa.com</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Compras</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del usuario')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarUsuario('USR-008')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar usuario?')) alert('Usuario eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-key" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Restablecer contraseña')" title="Restablecer contraseña"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">USR-009</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">MIGUEL ÁNGEL HERRERA DÍAZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">miguel.herrera@empresa.com</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Operador de Maquinaria</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Inactivo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del usuario')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarUsuario('USR-009')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar usuario?')) alert('Usuario eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-key" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Restablecer contraseña')" title="Restablecer contraseña"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">USR-010</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">FERNANDO GONZÁLEZ MARTÍNEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">fernando.gonzalez@empresa.com</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Sistemas</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del usuario')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarUsuario('USR-010')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar usuario?')) alert('Usuario eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-key" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Restablecer contraseña')" title="Restablecer contraseña"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">USR-011</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">GABRIELA ALEJANDRA NAVARRO</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">gabriela.navarro@empresa.com</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Calidad</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del usuario')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarUsuario('USR-011')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar usuario?')) alert('Usuario eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-key" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Restablecer contraseña')" title="Restablecer contraseña"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">USR-012</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">ALEJANDRO GUZMÁN REYES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">alejandro.guzman@empresa.com</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Seguridad e Higiene</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Inactivo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle del usuario')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarUsuario('USR-012')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar usuario?')) alert('Usuario eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-key" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Restablecer contraseña')" title="Restablecer contraseña"></i>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="6" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 13px;">Total Usuarios: 12 | Activos: 10 | Inactivos: 2</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Crear filtro -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter" style="font-size: 12px;"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA AGREGAR/EDITAR USUARIO -->
<div id="modalUsuario" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 500px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTituloUsuario">Nuevo Usuario</h3>
            <button onclick="cerrarModalUsuario()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Folio</label>
                    <input type="text" id="modalFolioUsuario" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="USR-013">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Empleado</label>
                    <select id="modalEmpleadoUsuario" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar empleado</option>
                        <option value="JUAN CARLOS PÉREZ LÓPEZ">JUAN CARLOS PÉREZ LÓPEZ</option>
                        <option value="MARÍA FERNANDA RAMOS GARCÍA">MARÍA FERNANDA RAMOS GARCÍA</option>
                        <option value="CARLOS ALBERTO MENDOZA SÁNCHEZ">CARLOS ALBERTO MENDOZA SÁNCHEZ</option>
                        <option value="ANA SOFÍA MARTÍNEZ FLORES">ANA SOFÍA MARTÍNEZ FLORES</option>
                        <option value="ROBERTO ANTONIO SÁNCHEZ TORRES">ROBERTO ANTONIO SÁNCHEZ TORRES</option>
                        <option value="LAURA PATRICIA FLORES GONZÁLEZ">LAURA PATRICIA FLORES GONZÁLEZ</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Correo</label>
                    <input type="email" id="modalCorreoUsuario" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="correo@empresa.com">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Contraseña</label>
                    <input type="password" id="modalPasswordUsuario" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="••••••••">
                    <small style="display: block; font-size: 11px; color: #6c757d; margin-top: 3px;">Mínimo 8 caracteres</small>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Confirmar Contraseña</label>
                    <input type="password" id="modalConfirmPasswordUsuario" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="••••••••">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Rol</label>
                    <select id="modalRolUsuario" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar rol</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Gerente de Proyectos">Gerente de Proyectos</option>
                        <option value="Supervisor de Obra">Supervisor de Obra</option>
                        <option value="Residente de Obra">Residente de Obra</option>
                        <option value="Almacenista">Almacenista</option>
                        <option value="Recursos Humanos">Recursos Humanos</option>
                        <option value="Finanzas">Finanzas</option>
                        <option value="Compras">Compras</option>
                        <option value="Sistemas">Sistemas</option>
                        <option value="Calidad">Calidad</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus</label>
                    <select id="modalEstatusUsuario" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalUsuario()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarUsuario()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
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
    
    .table td:last-child i.fa-key {
        color: #ffc107;
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
    #modalUsuario {
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
        
        #modalUsuario > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadas = [];
    
    // Función para abrir modal de nuevo usuario
    window.abrirModalUsuario = function() {
        document.getElementById('modalTituloUsuario').textContent = 'Nuevo Usuario';
        document.getElementById('modalFolioUsuario').value = '';
        document.getElementById('modalEmpleadoUsuario').value = '';
        document.getElementById('modalCorreoUsuario').value = '';
        document.getElementById('modalPasswordUsuario').value = '';
        document.getElementById('modalConfirmPasswordUsuario').value = '';
        document.getElementById('modalRolUsuario').value = '';
        document.getElementById('modalEstatusUsuario').value = 'Activo';
        document.getElementById('modalUsuario').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    // Función para editar usuario
    window.editarUsuario = function(folio) {
        document.getElementById('modalTituloUsuario').textContent = 'Editar Usuario - ' + folio;
        
        // Simular carga de datos según el folio
        if (folio === 'USR-001') {
            document.getElementById('modalFolioUsuario').value = 'USR-001';
            document.getElementById('modalEmpleadoUsuario').value = 'JUAN CARLOS PÉREZ LÓPEZ';
            document.getElementById('modalCorreoUsuario').value = 'juan.perez@empresa.com';
            document.getElementById('modalPasswordUsuario').value = '';
            document.getElementById('modalConfirmPasswordUsuario').value = '';
            document.getElementById('modalRolUsuario').value = 'Administrador';
            document.getElementById('modalEstatusUsuario').value = 'Activo';
        } else if (folio === 'USR-002') {
            document.getElementById('modalFolioUsuario').value = 'USR-002';
            document.getElementById('modalEmpleadoUsuario').value = 'MARÍA FERNANDA RAMOS GARCÍA';
            document.getElementById('modalCorreoUsuario').value = 'maria.ramos@empresa.com';
            document.getElementById('modalPasswordUsuario').value = '';
            document.getElementById('modalConfirmPasswordUsuario').value = '';
            document.getElementById('modalRolUsuario').value = 'Gerente de Proyectos';
            document.getElementById('modalEstatusUsuario').value = 'Activo';
        } else if (folio === 'USR-009') {
            document.getElementById('modalFolioUsuario').value = 'USR-009';
            document.getElementById('modalEmpleadoUsuario').value = 'MIGUEL ÁNGEL HERRERA DÍAZ';
            document.getElementById('modalCorreoUsuario').value = 'miguel.herrera@empresa.com';
            document.getElementById('modalPasswordUsuario').value = '';
            document.getElementById('modalConfirmPasswordUsuario').value = '';
            document.getElementById('modalRolUsuario').value = 'Operador de Maquinaria';
            document.getElementById('modalEstatusUsuario').value = 'Inactivo';
        } else {
            document.getElementById('modalFolioUsuario').value = folio;
            document.getElementById('modalEmpleadoUsuario').value = 'Empleado de ejemplo';
            document.getElementById('modalCorreoUsuario').value = 'correo@ejemplo.com';
            document.getElementById('modalPasswordUsuario').value = '';
            document.getElementById('modalConfirmPasswordUsuario').value = '';
            document.getElementById('modalRolUsuario').value = 'Administrador';
            document.getElementById('modalEstatusUsuario').value = 'Activo';
        }
        
        document.getElementById('modalUsuario').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalUsuario = function() {
        document.getElementById('modalUsuario').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.guardarUsuario = function() {
        const folio = document.getElementById('modalFolioUsuario').value;
        const empleado = document.getElementById('modalEmpleadoUsuario').value;
        const correo = document.getElementById('modalCorreoUsuario').value;
        const password = document.getElementById('modalPasswordUsuario').value;
        const confirmPassword = document.getElementById('modalConfirmPasswordUsuario').value;
        const rol = document.getElementById('modalRolUsuario').value;
        const estatus = document.getElementById('modalEstatusUsuario').value;
        
        if (!folio || !empleado || !correo || !rol) {
            alert('Por favor complete los campos obligatorios');
            return;
        }
        
        if (password && password.length < 8) {
            alert('La contraseña debe tener al menos 8 caracteres');
            return;
        }
        
        if (password !== confirmPassword) {
            alert('Las contraseñas no coinciden');
            return;
        }
        
        alert(`Usuario ${folio} guardado correctamente`);
        cerrarModalUsuario();
    };
    
    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalUsuario();
        }
    });
    
    // Cerrar modal al hacer clic fuera
    document.getElementById('modalUsuario').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalUsuario();
        }
    });
    
    // Funciones de agrupación y selector de columnas
    function actualizarGrupoColumnas() {
        const container = document.getElementById('grupoColumnas');
        const texto = document.getElementById('textoAgrupar');
        
        container.innerHTML = '';
        
        if (columnasAgrupadas.length === 0) {
            texto.style.display = 'inline';
        } else {
            texto.style.display = 'none';
            columnasAgrupadas.forEach(col => {
                const chip = document.createElement('span');
                chip.className = 'columna-agrupada';
                chip.innerHTML = `${col} <span class="remover" onclick="removerColumna('${col}')">&times;</span>`;
                container.appendChild(chip);
            });
        }
    }

    window.removerColumna = function(columna) {
        columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
        actualizarGrupoColumnas();
    };

    // Drag & drop
    document.addEventListener('dragstart', (e) => {
        if (e.target.tagName === 'TH' && e.target.draggable) {
            e.dataTransfer.setData('text/plain', e.target.dataset.columna);
        }
    });

    document.getElementById('grupoAgrupacion').addEventListener('dragover', (e) => e.preventDefault());
    
    document.getElementById('grupoAgrupacion').addEventListener('drop', (e) => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadas.includes(columna)) {
            columnasAgrupadas.push(columna);
            actualizarGrupoColumnas();
            alert('Agrupando por: ' + columna);
        }
    });

    // Selector de columnas
    window.toggleColumnSelector = function() {
        const selector = document.getElementById('columnSelector');
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
        
        if (selector.style.display === 'block') {
            const columnas = [
                { field: 'folio', caption: 'Folio' },
                { field: 'empleado', caption: 'Empleado' },
                { field: 'correo', caption: 'Correo' },
                { field: 'rol', caption: 'Rol' },
                { field: 'estatus', caption: 'Estatus' }
            ];
            
            const lista = document.getElementById('columnasLista');
            lista.innerHTML = columnas.map(col => `
                <div style="padding: 5px 0; display: flex; align-items: center;">
                    <input type="checkbox" 
                           id="chk_${col.field}"
                           data-columna="${col.field}"
                           checked
                           style="margin-right: 8px; accent-color: var(--color-primary);">
                    <label for="chk_${col.field}" style="font-size: 12px;">${col.caption}</label>
                </div>
            `).join('');
        }
    };

    window.cerrarColumnSelector = function() {
        document.getElementById('columnSelector').style.display = 'none';
    };

    // Cerrar selector al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#btnColumnas') && !e.target.closest('#columnSelector')) {
            document.getElementById('columnSelector').style.display = 'none';
        }
    });

    // Botones
    document.getElementById('btnCrearFiltro').addEventListener('click', () => alert('Funcionalidad de filtro en desarrollo'));
    document.getElementById('btnExcel').addEventListener('click', () => alert('Exportar usuarios a Excel'));

    // Buscador
    document.getElementById('buscador').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        console.log('Buscando en usuarios:', termino);
    });
});
</script>
@endsection