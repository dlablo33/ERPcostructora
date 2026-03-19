@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Áreas de la Empresa -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Áreas
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
                                    title="Agregar área"
                                    onclick="abrirModalArea()">
                                <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                    onclick="exportarAreasExcel()">
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
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 250px; max-height: 350px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative; min-width: 200px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar área..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Áreas -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaAreas" style="width: 100%; border-collapse: collapse; font-size: 13px; min-width: 700px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 15%;" draggable="true" data-columna="folio">Folio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 25%;" draggable="true" data-columna="area">Área</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 35%;" draggable="true" data-columna="descripcion">Descripción</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 15%;" draggable="true" data-columna="cuenta_contable">Cuenta Contable</th>
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
                
                <!-- Total de Áreas -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start; padding: 10px; background-color: #e9ecef; border-radius: 4px; font-size: 13px; font-weight: bold;">
                    <span>Total Áreas: <span id="totalAreas" style="color: var(--color-primary);">0</span></span>
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

<!-- MODAL PARA AGREGAR/EDITAR ÁREA -->
<div id="modalArea" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 500px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTituloArea">Nueva Área</h3>
            <button onclick="cerrarModalArea()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <form id="formArea" onsubmit="event.preventDefault(); guardarArea();">
                @csrf
                <input type="hidden" id="modalAreaId" value="">
                
                <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Folio</label>
                        <input type="text" id="modalFolioArea" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: AR-013" required>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Área</label>
                        <input type="text" id="modalNombreArea" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Nombre del área" required>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Descripción</label>
                        <textarea id="modalDescripcionArea" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción del área y sus funciones..."></textarea>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Cuenta Contable</label>
                        <input type="text" id="modalCuentaArea" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="(Opcional)">
                        <small style="display: block; font-size: 11px; color: #6c757d; margin-top: 3px;">Puedes dejarlo vacío</small>
                    </div>
                </div>
                
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" onclick="cerrarModalArea()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
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
    #modalArea {
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
        
        #modalArea > div {
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
        fetch('/api/areas', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                datos = data.data.areas || [];
                totalRegistros = datos.length;
                document.getElementById('totalAreas').textContent = totalRegistros;
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
                    <td colspan="5" style="padding: 30px; text-align: center; color: #6c757d;">
                        <i class="fas fa-info-circle" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                        No hay áreas registradas
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
                        <td colspan="5" style="padding: 10px 8px; border: 1px solid #dee2e6;">
                            <i class="fas fa-folder-open" style="color: var(--color-primary); margin-right: 8px;"></i>
                            ${columnasAgrupadas[0]}: ${grupo.valor} (${grupo.count} registros)
                        </td>
                    </tr>
                `;
                
                grupo.items.forEach(item => {
                    html += `
                        <tr>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; padding-left: 30px;">${item.folio}</td>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">${item.nombre}</td>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">${item.descripcion || ''}</td>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">${item.cuenta_contable || '—'}</td>
                            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verArea(${item.id})" title="Ver detalle"></i>
                                <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarArea(${item.id})" title="Editar"></i>
                                <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="eliminarArea(${item.id})" title="Eliminar"></i>
                            </td>
                        </tr>
                    `;
                });
            });
        } else {
            // Renderizar vista normal
            paginaActualDatos.forEach((area, index) => {
                const bgColor = (inicio + index) % 2 === 1 ? 'style="background-color: #f8f9fa;"' : '';
                
                html += `
                    <tr ${bgColor}>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">${area.folio}</td>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">${area.nombre}</td>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">${area.descripcion || ''}</td>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">${area.cuenta_contable || '—'}</td>
                        <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                            <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verArea(${area.id})" title="Ver detalle"></i>
                            <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarArea(${area.id})" title="Editar"></i>
                            <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="eliminarArea(${area.id})" title="Eliminar"></i>
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
            area: 1,
            descripcion: 2,
            cuenta_contable: 3
        };
        
        checkboxes.forEach(checkbox => {
            const columna = checkbox.dataset.columna;
            const index = indices[columna];
            const celdas = document.querySelectorAll(`#tablaAreas td:nth-child(${index + 1}), #tablaAreas th:nth-child(${index + 1})`);
            
            celdas.forEach(celda => {
                celda.style.display = checkbox.checked ? '' : 'none';
            });
        });
    }
    
    // Funciones para Áreas
    window.abrirModalArea = function(id = null) {
        document.getElementById('modalTituloArea').textContent = id ? 'Editar Área' : 'Nueva Área';
        document.getElementById('modalAreaId').value = id || '';
        
        if (id) {
            fetch(`/api/areas/${id}`, {
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
                    document.getElementById('modalFolioArea').value = data.data.folio;
                    document.getElementById('modalNombreArea').value = data.data.nombre;
                    document.getElementById('modalDescripcionArea').value = data.data.descripcion || '';
                    document.getElementById('modalCuentaArea').value = data.data.cuenta_contable || '';
                    document.getElementById('modalArea').style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarNotificacion('error', 'Error al cargar los datos del área');
            });
        } else {
            document.getElementById('modalFolioArea').value = '';
            document.getElementById('modalNombreArea').value = '';
            document.getElementById('modalDescripcionArea').value = '';
            document.getElementById('modalCuentaArea').value = '';
            document.getElementById('modalArea').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    };
    
    window.editarArea = function(id) {
        abrirModalArea(id);
    };
    
    window.verArea = function(id) {
        fetch(`/api/areas/${id}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Área: ${data.data.nombre}\nFolio: ${data.data.folio}\nDescripción: ${data.data.descripcion}\nCuenta Contable: ${data.data.cuenta_contable || 'N/A'}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('error', 'Error al cargar los datos del área');
        });
    };
    
    window.cerrarModalArea = function() {
        document.getElementById('modalArea').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.guardarArea = function() {
        const id = document.getElementById('modalAreaId').value;
        const numericId = id ? parseInt(id) : null;
        
        const data = {
            folio: document.getElementById('modalFolioArea').value,
            nombre: document.getElementById('modalNombreArea').value,
            descripcion: document.getElementById('modalDescripcionArea').value,
            cuenta_contable: document.getElementById('modalCuentaArea').value
        };

        const url = numericId ? `/api/areas/${numericId}` : '/api/areas';
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
                mostrarNotificacion('success', data.message || 'Área guardada exitosamente');
                cerrarModalArea();
                cargarDatos();
            } else {
                if (data.errors) {
                    const mensajes = Object.values(data.errors).flat().join('\n');
                    mostrarNotificacion('error', mensajes);
                } else {
                    mostrarNotificacion('error', data.message || 'Error al guardar el área');
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
    
    window.eliminarArea = function(id) {
        if (!id) {
            mostrarNotificacion('error', 'ID de área no válido');
            return;
        }
        
        if (confirm('¿Estás seguro de eliminar esta área?')) {
            const numericId = parseInt(id);
            
            fetch(`/api/areas/${numericId}`, {
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
                    mostrarNotificacion('success', data.message || 'Área eliminada exitosamente');
                    cargarDatos();
                } else {
                    mostrarNotificacion('error', data.message || 'Error al eliminar el área');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarNotificacion('error', 'Error de conexión al servidor');
            });
        }
    };
    
    // Función de exportación
    window.exportarAreasExcel = function() {
    // Mostrar notificación de carga
    mostrarNotificacion('info', 'Generando archivo Excel...');
    
    // Obtener el término de búsqueda
    const buscar = document.getElementById('buscador').value;
    
    // Opción 1: Usando fetch con blob (recomendado)
    fetch('/areas/exportar-excel', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        },
        body: new URLSearchParams({
            buscar: buscar
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la descarga');
        }
        return response.blob();
    })
    .then(blob => {
        // Crear URL del blob
        const url = window.URL.createObjectURL(blob);
        
        // Crear enlace temporal
        const a = document.createElement('a');
        a.href = url;
        a.download = 'areas_' + new Date().toISOString().slice(0,19).replace(/:/g, '-') + '.xlsx';
        document.body.appendChild(a);
        a.click();
        
        // Limpiar
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
        
        mostrarNotificacion('success', 'Archivo Excel descargado correctamente');
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('error', 'Error al descargar el archivo');
    });
};
    
    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') cerrarModalArea();
    });
    
    // Cerrar modal al hacer clic fuera
    document.getElementById('modalArea').addEventListener('click', function(e) {
        if (e.target === this) cerrarModalArea();
    });
    
    // Funciones de agrupación
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
                { field: 'area', caption: 'Área' },
                { field: 'descripcion', caption: 'Descripción' },
                { field: 'cuenta_contable', caption: 'Cuenta Contable' }
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
            area: 1,
            descripcion: 2,
            cuenta_contable: 3
        };
        
        const index = indices[columna];
        const celdas = document.querySelectorAll(`#tablaAreas td:nth-child(${index + 1}), #tablaAreas th:nth-child(${index + 1})`);
        
        celdas.forEach(celda => {
            celda.style.display = visible ? '' : 'none';
        });
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
            row.innerHTML = '<td colspan="5" style="padding: 20px; text-align: center; color: #6c757d;">No se encontraron áreas que coincidan con la búsqueda</td>';
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
            { field: 'area', caption: 'Área' },
            { field: 'descripcion', caption: 'Descripción' },
            { field: 'cuenta_contable', caption: 'Cuenta Contable' }
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