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
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                    onclick="exportarUsuariosExcel()">
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
                            <!-- Los datos se cargarán vía API -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div id="paginacion" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; padding: 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px;">
                    <div style="font-size: 13px; color: #6c757d;">
                        Mostrando <span id="desde">0</span> a <span id="hasta">0</span> de <span id="total">0</span> registros
                    </div>
                    <div style="display: flex; gap: 5px;">
                        <button id="prevPage" style="padding: 6px 12px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; font-size: 13px;" onclick="cambiarPagina('prev')" disabled>Anterior</button>
                        <span id="paginaActual" style="padding: 6px 12px; background-color: var(--color-primary); color: white; border-radius: 4px; font-size: 13px;">1</span>
                        <button id="nextPage" style="padding: 6px 12px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; font-size: 13px;" onclick="cambiarPagina('next')">Siguiente</button>
                    </div>
                </div>
                
                <!-- Totales de Usuarios -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start; gap: 20px; padding: 10px; background-color: #e9ecef; border-radius: 4px; font-size: 13px; font-weight: bold;">
                    <span>Total Usuarios: <span id="totalUsuarios" style="color: var(--color-primary);">0</span></span>
                    <span style="color: #28a745;">Activos: <span id="usuariosActivos">0</span></span>
                    <span style="color: #ffc107;">Inactivos: <span id="usuariosInactivos">0</span></span>
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
            <form id="formUsuario" onsubmit="event.preventDefault(); guardarUsuario();">
                @csrf
                <input type="hidden" id="modalUsuarioId" value="">
                
                <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Folio</label>
                        <input type="text" id="modalFolioUsuario" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="USR-013" required>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Empleado</label>
                        <input type="text" id="modalEmpleadoUsuario" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Nombre completo del empleado" required>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Correo</label>
                        <input type="email" id="modalCorreoUsuario" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="correo@empresa.com" required>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Contraseña</label>
                        <input type="password" id="modalPasswordUsuario" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="••••••••">
                        <small style="display: block; font-size: 11px; color: #6c757d; margin-top: 3px;">Mínimo 8 caracteres. Dejar vacío para no cambiar en edición.</small>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Confirmar Contraseña</label>
                        <input type="password" id="modalConfirmPasswordUsuario" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="••••••••">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Rol</label>
                        <select id="modalRolUsuario" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
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
                        <select id="modalEstatusUsuario" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                </div>
                
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" onclick="cerrarModalUsuario()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                    <button type="submit" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA RESTABLECER CONTRASEÑA -->
<div id="modalResetPassword" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 400px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalResetTitulo">Restablecer Contraseña</h3>
            <button onclick="cerrarModalReset()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <div style="text-align: center; margin-bottom: 20px;">
                <i class="fas fa-key" style="font-size: 48px; color: var(--color-primary); margin-bottom: 10px;"></i>
                <p style="font-size: 14px; color: #6c757d;">¿Estás seguro de restablecer la contraseña?</p>
                <p style="font-size: 13px; font-weight: bold; margin-top: 5px;" id="modalResetUsuario"></p>
            </div>
            
            <div style="display: flex; justify-content: center; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalReset()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="confirmarResetPassword()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Restablecer</button>
            </div>
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
    #modalUsuario, #modalResetPassword {
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
        
        #modalUsuario > div, #modalResetPassword > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
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
    let columnasAgrupadas = [];
    
    // Variables de paginación
    let paginaActual = 1;
    let registrosPorPagina = 10;
    let totalRegistros = 0;
    let datos = [];
    let datosAgrupados = [];
    let modoAgrupado = false;
    
    // Variable para reset de contraseña
    let usuarioResetId = null;
    
    // Cargar datos iniciales
    cargarDatos();
    
    // Función para cambiar número de registros por página
    window.cambiarRegistrosPorPagina = function() {
        const perPage = document.getElementById('perPage').value;
        registrosPorPagina = parseInt(perPage);
        paginaActual = 1;
        renderizarTabla();
        actualizarPaginacion();
    };
    
    // Funciones de paginación
    window.cambiarPagina = function(direccion) {
        if (direccion === 'prev' && paginaActual > 1) {
            paginaActual--;
        } else if (direccion === 'next' && paginaActual < Math.ceil(totalRegistros / registrosPorPagina)) {
            paginaActual++;
        }
        renderizarTabla();
        actualizarPaginacion();
    };
    
    function actualizarPaginacion() {
        const totalPaginas = Math.ceil(totalRegistros / registrosPorPagina);
        const desde = totalRegistros === 0 ? 0 : (paginaActual - 1) * registrosPorPagina + 1;
        const hasta = Math.min(paginaActual * registrosPorPagina, totalRegistros);
        
        document.getElementById('desde').textContent = desde;
        document.getElementById('hasta').textContent = hasta;
        document.getElementById('total').textContent = totalRegistros;
        document.getElementById('paginaActual').textContent = paginaActual;
        
        document.getElementById('prevPage').disabled = paginaActual === 1;
        document.getElementById('nextPage').disabled = paginaActual === totalPaginas || totalPaginas === 0;
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
        fetch('/api/usuarios', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                datos = data.data.usuarios || [];
                totalRegistros = datos.length;
                
                document.getElementById('totalUsuarios').textContent = totalRegistros;
                document.getElementById('usuariosActivos').textContent = data.data.usuariosActivos || 0;
                document.getElementById('usuariosInactivos').textContent = data.data.usuariosInactivos || 0;
                
                renderizarTabla();
                actualizarPaginacion();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('error', 'Error al cargar los datos');
        });
    }
    
    // Función para agrupar datos
    function agruparDatos(columna) {
        const grupos = {};
        
        datos.forEach(item => {
            let valor = item[columna];
            if (!valor) valor = 'Sin especificar';
            
            if (!grupos[valor]) {
                grupos[valor] = [];
            }
            grupos[valor].push(item);
        });
        
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
    
    function renderizarTabla() {
        const tbody = document.getElementById('tablaBody');
        
        // Determinar qué datos mostrar
        let datosAMostrar = datos;
        
        if (columnasAgrupadas.length > 0) {
            const columna = columnasAgrupadas[0];
            datosAgrupados = agruparDatos(columna);
            datosAMostrar = datosAgrupados;
            modoAgrupado = true;
            totalRegistros = datosAgrupados.length;
        } else {
            modoAgrupado = false;
            totalRegistros = datos.length;
        }
        
        const inicio = (paginaActual - 1) * registrosPorPagina;
        const fin = inicio + registrosPorPagina;
        const paginaActualDatos = datosAMostrar.slice(inicio, fin);
        
        if (!paginaActualDatos || paginaActualDatos.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" style="padding: 30px; text-align: center; color: #6c757d;">
                        <i class="fas fa-info-circle" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                        No hay usuarios registrados
                    </td>
                </tr>
            `;
            actualizarPaginacion();
            return;
        }
        
        let html = '';
        
        if (modoAgrupado) {
            // Renderizar vista agrupada
            paginaActualDatos.forEach((grupo, index) => {
                const bgColor = (inicio + index) % 2 === 1 ? 'style="background-color: #f8f9fa;"' : '';
                
                html += `
                    <tr ${bgColor} style="background-color: #e3f2fd; font-weight: bold;">
                        <td colspan="6" style="padding: 10px 8px; border: 1px solid #dee2e6;">
                            <i class="fas fa-folder-open" style="color: var(--color-primary); margin-right: 8px;"></i>
                            ${columnasAgrupadas[0]}: ${grupo.valor} (${grupo.count} registros)
                        </td>
                    </tr>
                `;
                
                grupo.items.forEach(item => {
                    const badgeColor = item.estatus === 'Activo' ? '#28a745' : '#ffc107';
                    const badgeTextColor = item.estatus === 'Activo' ? 'white' : '#212529';
                    
                    html += `
                        <tr>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; padding-left: 30px;">${item.folio || ''}</td>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">${item.empleado || item.name || ''}</td>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">${item.email || ''}</td>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">${item.rol || ''}</td>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                <span style="background-color: ${badgeColor}; color: ${badgeTextColor}; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">
                                    ${item.estatus || ''}
                                </span>
                            </td>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verUsuario(${item.id})" title="Ver detalle"></i>
                                <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarUsuario(${item.id})" title="Editar"></i>
                                <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="eliminarUsuario(${item.id})" title="Eliminar"></i>
                                <i class="fas fa-key" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="abrirModalResetPassword(${item.id}, '${item.empleado || item.name}')" title="Restablecer contraseña"></i>
                            </td>
                        </tr>
                    `;
                });
            });
        } else {
            // Renderizar vista normal
            paginaActualDatos.forEach((usuario, index) => {
                const bgColor = (inicio + index) % 2 === 1 ? 'style="background-color: #f8f9fa;"' : '';
                const badgeColor = usuario.estatus === 'Activo' ? '#28a745' : '#ffc107';
                const badgeTextColor = usuario.estatus === 'Activo' ? 'white' : '#212529';
                
                html += `
                    <tr ${bgColor}>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">${usuario.folio || ''}</td>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">${usuario.empleado || usuario.name || ''}</td>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">${usuario.email || ''}</td>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">${usuario.rol || ''}</td>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                            <span style="background-color: ${badgeColor}; color: ${badgeTextColor}; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">
                                ${usuario.estatus || ''}
                            </span>
                        </td>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                            <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verUsuario(${usuario.id})" title="Ver detalle"></i>
                            <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarUsuario(${usuario.id})" title="Editar"></i>
                            <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="eliminarUsuario(${usuario.id})" title="Eliminar"></i>
                            <i class="fas fa-key" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="abrirModalResetPassword(${usuario.id}, '${usuario.empleado || usuario.name}')" title="Restablecer contraseña"></i>
                        </td>
                    </tr>
                `;
            });
        }
        
        tbody.innerHTML = html;
        aplicarVisibilidadColumnas();
        actualizarPaginacion();
    }
    
    function aplicarVisibilidadColumnas() {
        const checkboxes = document.querySelectorAll('#columnasLista input[type="checkbox"]');
        const indices = {
            folio: 0,
            empleado: 1,
            correo: 2,
            rol: 3,
            estatus: 4
        };
        
        checkboxes.forEach(checkbox => {
            const columna = checkbox.dataset.columna;
            const index = indices[columna];
            if (index !== undefined) {
                const celdas = document.querySelectorAll(`#tablaUsuarios td:nth-child(${index + 1}), #tablaUsuarios th:nth-child(${index + 1})`);
                celdas.forEach(celda => {
                    celda.style.display = checkbox.checked ? '' : 'none';
                });
            }
        });
    }
    
    // Funciones para Usuarios
    window.abrirModalUsuario = function(id = null) {
        document.getElementById('modalTituloUsuario').textContent = id ? 'Editar Usuario' : 'Nuevo Usuario';
        document.getElementById('modalUsuarioId').value = id || '';
        
        if (id) {
            fetch(`/api/usuarios/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Error al cargar los datos');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    document.getElementById('modalFolioUsuario').value = data.data.folio || '';
                    document.getElementById('modalEmpleadoUsuario').value = data.data.empleado || data.data.name || '';
                    document.getElementById('modalCorreoUsuario').value = data.data.email || '';
                    document.getElementById('modalPasswordUsuario').value = '';
                    document.getElementById('modalConfirmPasswordUsuario').value = '';
                    document.getElementById('modalRolUsuario').value = data.data.rol || '';
                    document.getElementById('modalEstatusUsuario').value = data.data.estatus || 'Activo';
                    document.getElementById('modalUsuario').style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarNotificacion('error', 'Error al cargar los datos del usuario');
            });
        } else {
            document.getElementById('modalFolioUsuario').value = '';
            document.getElementById('modalEmpleadoUsuario').value = '';
            document.getElementById('modalCorreoUsuario').value = '';
            document.getElementById('modalPasswordUsuario').value = '';
            document.getElementById('modalConfirmPasswordUsuario').value = '';
            document.getElementById('modalRolUsuario').value = '';
            document.getElementById('modalEstatusUsuario').value = 'Activo';
            document.getElementById('modalUsuario').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    };
    
    window.editarUsuario = function(id) {
        abrirModalUsuario(id);
    };
    
    window.verUsuario = function(id) {
        fetch(`/api/usuarios/${id}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Usuario: ${data.data.empleado || data.data.name}\nFolio: ${data.data.folio}\nCorreo: ${data.data.email}\nRol: ${data.data.rol}\nEstatus: ${data.data.estatus}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('error', 'Error al cargar los datos del usuario');
        });
    };
    
    window.cerrarModalUsuario = function() {
        document.getElementById('modalUsuario').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.guardarUsuario = function() {
        const id = document.getElementById('modalUsuarioId').value;
        const numericId = id ? parseInt(id) : null;
        
        // Validar campos obligatorios
        const folio = document.getElementById('modalFolioUsuario').value;
        const empleado = document.getElementById('modalEmpleadoUsuario').value;
        const correo = document.getElementById('modalCorreoUsuario').value;
        const rol = document.getElementById('modalRolUsuario').value;
        const estatus = document.getElementById('modalEstatusUsuario').value;
        
        if (!folio || !empleado || !correo || !rol) {
            mostrarNotificacion('error', 'Por favor complete los campos obligatorios');
            return;
        }
        
        const password = document.getElementById('modalPasswordUsuario').value;
        const confirmPassword = document.getElementById('modalConfirmPasswordUsuario').value;
        
        // Validar contraseña solo si se proporciona (en creación es obligatoria, en edición opcional)
        if (!id && !password) {
            mostrarNotificacion('error', 'La contraseña es obligatoria');
            return;
        }
        
        if (password) {
            if (password.length < 8) {
                mostrarNotificacion('error', 'La contraseña debe tener al menos 8 caracteres');
                return;
            }
            
            if (password !== confirmPassword) {
                mostrarNotificacion('error', 'Las contraseñas no coinciden');
                return;
            }
        }
        
        const data = {
            folio: folio,
            name: empleado,
            empleado: empleado,
            email: correo,
            rol: rol,
            estatus: estatus
        };
        
        if (password) {
            data.password = password;
            data.password_confirmation = confirmPassword;
        }

        const url = numericId ? `/api/usuarios/${numericId}` : '/api/usuarios';
        const method = numericId ? 'PUT' : 'POST';

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
            return response.json().then(data => {
                if (!response.ok) throw { status: response.status, data: data };
                return data;
            });
        })
        .then(data => {
            if (data.success) {
                mostrarNotificacion('success', data.message || 'Usuario guardado exitosamente');
                cerrarModalUsuario();
                cargarDatos();
            } else {
                if (data.errors) {
                    const mensajes = Object.values(data.errors).flat().join('\n');
                    mostrarNotificacion('error', mensajes);
                } else {
                    mostrarNotificacion('error', data.message || 'Error al guardar el usuario');
                }
            }
        })
        .catch(error => {
            console.error('Error completo:', error);
            if (error.data?.message) mostrarNotificacion('error', error.data.message);
            else if (error.data?.errors) {
                const mensajes = Object.values(error.data.errors).flat().join('\n');
                mostrarNotificacion('error', mensajes);
            } else {
                mostrarNotificacion('error', 'Error de conexión al servidor');
            }
        });
    };
    
    window.eliminarUsuario = function(id) {
        if (!id) {
            mostrarNotificacion('error', 'ID de usuario no válido');
            return;
        }
        
        if (confirm('¿Estás seguro de eliminar este usuario?')) {
            const numericId = parseInt(id);
            
            fetch(`/api/usuarios/${numericId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarNotificacion('success', data.message || 'Usuario eliminado exitosamente');
                    cargarDatos();
                } else {
                    mostrarNotificacion('error', data.message || 'Error al eliminar el usuario');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarNotificacion('error', 'Error de conexión al servidor');
            });
        }
    };
    
    // Funciones para reset de contraseña
    window.abrirModalResetPassword = function(id, nombre) {
        usuarioResetId = id;
        document.getElementById('modalResetUsuario').textContent = nombre;
        document.getElementById('modalResetPassword').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalReset = function() {
        document.getElementById('modalResetPassword').style.display = 'none';
        document.body.style.overflow = 'auto';
        usuarioResetId = null;
    };
    
    window.confirmarResetPassword = function() {
        if (!usuarioResetId) {
            mostrarNotificacion('error', 'ID de usuario no válido');
            cerrarModalReset();
            return;
        }
        
        fetch(`/api/usuarios/${usuarioResetId}/reset-password`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // En desarrollo mostramos la nueva contraseña, en producción no
                if (data.new_password) {
                    mostrarNotificacion('success', `Contraseña restablecida: ${data.new_password}`);
                } else {
                    mostrarNotificacion('success', data.message || 'Contraseña restablecida exitosamente');
                }
                cerrarModalReset();
            } else {
                mostrarNotificacion('error', data.message || 'Error al restablecer la contraseña');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('error', 'Error de conexión al servidor');
            cerrarModalReset();
        });
    };
    
    // Función de exportación
    window.exportarUsuariosExcel = function() {
    // Mostrar notificación de carga
    mostrarNotificacion('info', 'Generando archivo Excel...');
    
    // Obtener el término de búsqueda
    const buscar = document.getElementById('buscador').value;
    
    // Crear un formulario temporal para la descarga directa
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/usuarios/exportar-excel';
    form.style.display = 'none';
    
    // Agregar token CSRF
    const csrfInput = document.createElement('input');
    csrfInput.name = '_token';
    csrfInput.value = document.querySelector('input[name="_token"]').value;
    form.appendChild(csrfInput);
    
    // Agregar término de búsqueda
    if (buscar) {
        const buscarInput = document.createElement('input');
        buscarInput.name = 'buscar';
        buscarInput.value = buscar;
        form.appendChild(buscarInput);
    }
    
    // Agregar al body y enviar
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
    
    // Cerrar notificación después de un momento
    setTimeout(() => {
        mostrarNotificacion('success', 'Descargando archivo Excel...');
    }, 1000);
};
    
    // Cerrar modales con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalUsuario();
            cerrarModalReset();
        }
    });
    
    // Cerrar modales al hacer clic fuera
    document.getElementById('modalUsuario').addEventListener('click', function(e) {
        if (e.target === this) cerrarModalUsuario();
    });
    
    document.getElementById('modalResetPassword').addEventListener('click', function(e) {
        if (e.target === this) cerrarModalReset();
    });
    
    // Funciones de agrupación
    function actualizarGrupoColumnas() {
        const container = document.getElementById('grupoColumnas');
        const texto = document.getElementById('textoAgrupar');
        
        container.innerHTML = '';
        
        if (columnasAgrupadas.length === 0) {
            texto.style.display = 'inline';
            modoAgrupado = false;
        } else {
            texto.style.display = 'none';
            modoAgrupado = true;
            columnasAgrupadas.forEach(col => {
                const chip = document.createElement('span');
                chip.className = 'columna-agrupada';
                chip.innerHTML = `${col} <span class="remover" onclick="removerColumna('${col}')">&times;</span>`;
                container.appendChild(chip);
            });
        }
        
        paginaActual = 1;
        renderizarTabla();
    }

    window.removerColumna = function(columna) {
        columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
        actualizarGrupoColumnas();
        mostrarNotificacion('info', 'Desagrupando por: ' + columna);
    };

    // Drag & drop
    document.querySelectorAll('[draggable="true"]').forEach(th => {
        th.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('text/plain', e.target.dataset.columna);
        });
    });

    document.getElementById('grupoAgrupacion').addEventListener('dragover', (e) => e.preventDefault());
    
    document.getElementById('grupoAgrupacion').addEventListener('drop', (e) => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadas.includes(columna)) {
            columnasAgrupadas.push(columna);
            actualizarGrupoColumnas();
            mostrarNotificacion('info', 'Agrupando por: ' + columna);
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
                           style="margin-right: 8px; accent-color: var(--color-primary);"
                           onchange="toggleColumna('${col.field}', this.checked)">
                    <label for="chk_${col.field}" style="font-size: 12px;">${col.caption}</label>
                </div>
            `).join('');
        }
    };
    
    window.toggleColumna = function(columna, visible) {
        const indices = {
            folio: 0,
            empleado: 1,
            correo: 2,
            rol: 3,
            estatus: 4
        };
        
        const index = indices[columna];
        if (index !== undefined) {
            const celdas = document.querySelectorAll(`#tablaUsuarios td:nth-child(${index + 1}), #tablaUsuarios th:nth-child(${index + 1})`);
            celdas.forEach(celda => {
                celda.style.display = visible ? '' : 'none';
            });
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

    // Botón Crear filtro
    document.getElementById('btnCrearFiltro').addEventListener('click', () => {
        mostrarNotificacion('info', 'Funcionalidad de filtro en desarrollo');
    });

    // Buscador
    document.getElementById('buscador').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        const filas = document.querySelectorAll('#tablaBody tr');
        let visibleCount = 0;
        
        filas.forEach(fila => {
            if (fila.cells && fila.cells.length > 1 && !fila.querySelector('td[colspan]')) {
                const texto = fila.textContent.toLowerCase();
                const visible = texto.includes(termino);
                fila.style.display = visible ? '' : 'none';
                if (visible) visibleCount++;
            }
        });
        
        const tbody = document.getElementById('tablaBody');
        const noResultsRow = document.getElementById('noResults');
        
        if (visibleCount === 0 && termino !== '' && !noResultsRow) {
            const row = document.createElement('tr');
            row.id = 'noResults';
            row.innerHTML = '<td colspan="6" style="padding: 20px; text-align: center; color: #6c757d;">No se encontraron usuarios que coincidan con la búsqueda</td>';
            tbody.appendChild(row);
        } else if (visibleCount > 0 && noResultsRow) {
            noResultsRow.remove();
        } else if (termino === '' && noResultsRow) {
            noResultsRow.remove();
        }
    });

    // Inicializar selectores de columnas
    function inicializarSelectoresColumnas() {
        const columnas = [
            { field: 'folio', caption: 'Folio' },
            { field: 'empleado', caption: 'Empleado' },
            { field: 'correo', caption: 'Correo' },
            { field: 'rol', caption: 'Rol' },
            { field: 'estatus', caption: 'Estatus' }
        ];
        
        const lista = document.getElementById('columnasLista');
        if (lista && lista.children.length === 0) {
            lista.innerHTML = columnas.map(col => `
                <div style="padding: 5px 0; display: flex; align-items: center;">
                    <input type="checkbox" 
                           id="chk_${col.field}"
                           data-columna="${col.field}"
                           checked
                           style="margin-right: 8px; accent-color: var(--color-primary);"
                           onchange="toggleColumna('${col.field}', this.checked)">
                    <label for="chk_${col.field}" style="font-size: 12px;">${col.caption}</label>
                </div>
            `).join('');
        }
    }
    
    inicializarSelectoresColumnas();
});
</script>
@endsection