@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-clipboard-list"></i> Requisiciones de Material
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Proyecto</label>
                        <select id="filtroProyecto" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Todos los proyectos</option>
                            @isset($proyectos)
                                @foreach($proyectos as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Estatus</label>
                        <select id="filtroEstatus" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Todos</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Autorizada">Autorizada</option>
                            <option value="Rechazada">Rechazada</option>
                            <option value="Surtida">Surtida</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Fecha Inicio</label>
                        <input type="date" id="fechaInicio" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-01') }}">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Fecha Fin</label>
                        <input type="date" id="fechaFin" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <!-- Botones -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap;">
                    <div>
                        <button id="btnActualizar" style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 20px; cursor: pointer;">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button id="btnNuevaRequisicion" class="btn-agregar" onclick="abrirModalRequisicion()" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 20px; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-plus"></i> Nueva Requisición
                        </button>
                        <button id="btnExportar" class="btn-excel" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 20px; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-file-excel"></i> Exportar
                        </button>
                    </div>
                </div>

                <!-- Tabla de Requisiciones -->
                <div class="table-container">
                    <table class="table" id="tablaRequisiciones">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Fecha</th>
                                <th>Proyecto</th>
                                <th>Solicitante</th>
                                <th>Prioridad</th>
                                <th>Estatus</th>
                                <th>% Surtido</th>
                                <th>Autorizado por</th>
                                <th>Fecha Autorización</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="10" style="text-align: center;">Cargando...<\/td></tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div class="pagination-container" style="margin-top: 15px; display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                    <button class="page-btn" id="btnPrimera" disabled><i class="fas fa-angle-double-left"></i></button>
                    <button class="page-btn" id="btnAnterior" disabled><i class="fas fa-angle-left"></i></button>
                    <span>Página <span id="paginaActual">1</span> de <span id="totalPaginas">1</span></span>
                    <button class="page-btn" id="btnSiguiente" disabled><i class="fas fa-angle-right"></i></button>
                    <button class="page-btn" id="btnUltima" disabled><i class="fas fa-angle-double-right"></i></button>
                    <select id="porPagina" style="padding: 5px; border-radius: 4px;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL NUEVA REQUISICIÓN -->
<div id="modalRequisicion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 800px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;">Nueva Requisición de Material</h3>
            <button onclick="cerrarModalRequisicion()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Proyecto <span style="color: red;">*</span></label>
                    <select id="reqProyecto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar proyecto</option>
                        @isset($proyectos)
                            @foreach($proyectos as $proyecto)
                                <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Fecha <span style="color: red;">*</span></label>
                    <input type="date" id="reqFecha" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Solicitante <span style="color: red;">*</span></label>
                    <input type="text" id="reqSolicitante" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Nombre del solicitante">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Área</label>
                    <input type="text" id="reqArea" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Área que solicita">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Prioridad <span style="color: red;">*</span></label>
                    <select id="reqPrioridad" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Alta">🔴 Alta</option>
                        <option value="Media" selected="selected">🟡 Media</option>
                        <option value="Baja">🟢 Baja</option>
                    </select>
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Observaciones</label>
                    <textarea id="reqObservaciones" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones generales..."></textarea>
                </div>
            </div>
            
            <hr style="margin: 15px 0;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h4 style="margin: 0; font-size: 14px; color: var(--color-primary);"><i class="fas fa-boxes"></i> Artículos Solicitados</h4>
                <button type="button" onclick="agregarArticulo()" style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 5px 12px; cursor: pointer;">
                    <i class="fas fa-plus"></i> Agregar Artículo
                </button>
            </div>
            
            <div class="table-container" style="max-height: 300px;">
                <table class="table" id="tablaArticulos">
                    <thead>
                        <tr>
                            <th>Artículo</th>
                            <th>Cantidad</th>
                            <th>Unidad</th>
                            <th>Observación</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbodyArticulos">
                        <tr id="filaArticulo_0">
                            <td>
                                <select class="articulo-select" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;">
                                    <option value="">Seleccionar artículo</option>
                                    @isset($articulos)
                                        @foreach($articulos as $articulo)
                                            <option value="{{ $articulo->id }}">{{ $articulo->codigo }} - {{ $articulo->descripcion }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </td>
                            <td><input type="number" step="0.001" class="cantidad-input" style="width: 100px; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00"></td>
                            <td><input type="text" class="unidad-input" style="width: 80px; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" readonly placeholder="Auto"></td>
                            <td><input type="text" class="observacion-input" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observación"></td>
                            <td><i class="fas fa-trash" onclick="eliminarArticulo(0)" style="color: #dc3545; cursor: pointer;"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalRequisicion()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarRequisicion()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETALLE REQUISICIÓN -->
<div id="modalDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 800px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;" id="detalleTitulo">Detalle de Requisición</h3>
            <button onclick="cerrarModalDetalle()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div id="detalleContenido" style="padding: 20px;">
            <!-- Contenido dinámico -->
        </div>
        <div id="detalleBotones" style="padding: 15px 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button onclick="cerrarModalDetalle()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cerrar</button>
        </div>
    </div>
</div>

<style>
    :root { --color-primary: #083CAE; }
    .table-container { border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; max-height: 500px; overflow-y: auto; }
    .table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .table th { background-color: var(--color-primary) !important; color: white; padding: 12px 8px; border: 1px solid #dee2e6; position: sticky; top: 0; }
    .table td { padding: 10px 8px; border: 1px solid #dee2e6; }
    tbody tr:nth-child(even) { background-color: #f8f9fa; }
    tbody tr:hover { background-color: #e8f0fe; }
    .page-btn { padding: 5px 12px; border: 1px solid var(--color-primary); border-radius: 4px; background: white; cursor: pointer; color: var(--color-primary); }
    .page-btn:disabled { opacity: 0.5; cursor: not-allowed; }
    .badge-pendiente { background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 12px; font-size: 10px; }
    .badge-autorizada { background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 12px; font-size: 10px; }
    .badge-rechazada { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 12px; font-size: 10px; }
    .badge-surtida { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 12px; font-size: 10px; }
    .badge-cancelada { background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 12px; font-size: 10px; }
    .prioridad-alta { color: #dc3545; font-weight: bold; }
    .prioridad-media { color: #ffc107; font-weight: bold; }
    .prioridad-baja { color: #28a745; font-weight: bold; }
    .btn-agregar:hover, .btn-excel:hover { background-color: var(--color-primary) !important; color: white !important; }
    .progress-bar-container { width: 100%; background-color: #e9ecef; border-radius: 10px; height: 8px; }
    .progress-bar { background-color: #28a745; border-radius: 10px; height: 8px; }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
let currentPage = 1;
let perPage = 10;
let totalPages = 1;
let articuloCounter = 1;

document.addEventListener('DOMContentLoaded', function() {
    cargarRequisiciones();
    configurarEventos();
    
    // Evento para cargar unidad de medida al seleccionar artículo
    document.addEventListener('change', function(e) {
        if (e.target.classList && e.target.classList.contains('articulo-select')) {
            const row = e.target.closest('tr');
            const unidadInput = row.querySelector('.unidad-input');
            const selectedOption = e.target.options[e.target.selectedIndex];
            const unidad = selectedOption.getAttribute('data-unidad') || '';
            if (unidadInput) unidadInput.value = unidad;
        }
    });
});

function cargarRequisiciones() {
    const proyectoId = document.getElementById('filtroProyecto')?.value || '';
    const estatus = document.getElementById('filtroEstatus')?.value || '';
    const fechaInicio = document.getElementById('fechaInicio')?.value || '';
    const fechaFin = document.getElementById('fechaFin')?.value || '';
    
    let url = `/inventario/api/requisiciones?page=${currentPage}&per_page=${perPage}`;
    if (proyectoId) url += `&proyecto_id=${proyectoId}`;
    if (estatus) url += `&estatus=${estatus}`;
    if (fechaInicio) url += `&fecha_inicio=${fechaInicio}`;
    if (fechaFin) url += `&fecha_fin=${fechaFin}`;
    
    fetch(url)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                renderizarTabla(response.data);
                totalPages = response.last_page;
                actualizarPaginacion(response.current_page, response.last_page);
            }
        })
        .catch(error => console.error('Error:', error));
}

function renderizarTabla(data) {
    const tbody = document.getElementById('tablaBody');
    if (!data.length) {
        tbody.innerHTML = '<tr><td colspan="10" style="text-align: center;">No hay requisiciones registradas</td></tr>';
        return;
    }
    
    tbody.innerHTML = '';
    data.forEach((item, index) => {
        const row = tbody.insertRow();
        row.style.backgroundColor = index % 2 === 1 ? '#f8f9fa' : 'white';
        
        let estatusBadge = '';
        switch (item.estatus) {
            case 'Pendiente': estatusBadge = '<span class="badge-pendiente">⏳ Pendiente</span>'; break;
            case 'Autorizada': estatusBadge = '<span class="badge-autorizada">✓ Autorizada</span>'; break;
            case 'Rechazada': estatusBadge = '<span class="badge-rechazada">✗ Rechazada</span>'; break;
            case 'Surtida': estatusBadge = '<span class="badge-surtida">✔ Surtida</span>'; break;
            case 'Cancelada': estatusBadge = '<span class="badge-cancelada">⊗ Cancelada</span>'; break;
            default: estatusBadge = '<span class="badge-pendiente">' + item.estatus + '</span>';
        }
        
        let prioridadClass = '';
        if (item.prioridad === 'Alta') prioridadClass = 'prioridad-alta';
        else if (item.prioridad === 'Media') prioridadClass = 'prioridad-media';
        else prioridadClass = 'prioridad-baja';
        
        let progreso = item.porcentaje_surtido || 0;
        let progressHtml = `<div class="progress-bar-container"><div class="progress-bar" style="width: ${progreso}%;"></div></div><span style="font-size: 10px;">${progreso}%</span>`;
        
        row.insertCell(0).innerHTML = `<strong>${item.folio}</strong>`;
        row.insertCell(1).innerHTML = item.fecha_requisicion;
        row.insertCell(2).innerHTML = item.proyecto_nombre;
        row.insertCell(3).innerHTML = item.solicitante;
        row.insertCell(4).innerHTML = `<span class="${prioridadClass}">${item.prioridad}</span>`;
        row.insertCell(5).innerHTML = estatusBadge;
        row.insertCell(6).innerHTML = progressHtml;
        row.insertCell(7).innerHTML = item.autorizado_por || '---';
        row.insertCell(8).innerHTML = item.fecha_autorizacion || '---';
        row.insertCell(9).innerHTML = `
            <i class="fas fa-eye" onclick="verDetalle(${item.id})" style="color: var(--color-primary); cursor: pointer; margin: 0 5px;" title="Ver detalle"></i>
            ${item.estatus === 'Pendiente' ? `<i class="fas fa-check-circle" onclick="autorizarRequisicion(${item.id})" style="color: #28a745; cursor: pointer; margin: 0 5px;" title="Autorizar"></i>` : ''}
            ${item.estatus === 'Pendiente' ? `<i class="fas fa-times-circle" onclick="rechazarRequisicion(${item.id})" style="color: #dc3545; cursor: pointer; margin: 0 5px;" title="Rechazar"></i>` : ''}
            ${item.estatus === 'Autorizada' ? `<i class="fas fa-truck" onclick="generarSurtido(${item.id})" style="color: #17a2b8; cursor: pointer; margin: 0 5px;" title="Generar Surtido"></i>` : ''}
        `;
    });
}

function actualizarPaginacion(currentPage, lastPage) {
    document.getElementById('paginaActual').textContent = currentPage;
    document.getElementById('totalPaginas').textContent = lastPage;
    document.getElementById('btnPrimera').disabled = currentPage === 1;
    document.getElementById('btnAnterior').disabled = currentPage === 1;
    document.getElementById('btnSiguiente').disabled = currentPage === lastPage;
    document.getElementById('btnUltima').disabled = currentPage === lastPage;
}

function configurarEventos() {
    document.getElementById('btnActualizar')?.addEventListener('click', () => {
        currentPage = 1;
        cargarRequisiciones();
    });
    
    document.getElementById('btnPrimera')?.addEventListener('click', () => { currentPage = 1; cargarRequisiciones(); });
    document.getElementById('btnAnterior')?.addEventListener('click', () => { if (currentPage > 1) { currentPage--; cargarRequisiciones(); } });
    document.getElementById('btnSiguiente')?.addEventListener('click', () => { currentPage++; cargarRequisiciones(); });
    document.getElementById('btnUltima')?.addEventListener('click', () => { currentPage = totalPages; cargarRequisiciones(); });
    document.getElementById('porPagina')?.addEventListener('change', (e) => { perPage = parseInt(e.target.value); currentPage = 1; cargarRequisiciones(); });
    
    document.getElementById('btnExportar')?.addEventListener('click', () => alert('Exportación en desarrollo'));
}

// Modal Requisición
function abrirModalRequisicion() {
    document.getElementById('reqProyecto').value = '';
    document.getElementById('reqFecha').value = new Date().toISOString().split('T')[0];
    document.getElementById('reqSolicitante').value = '';
    document.getElementById('reqArea').value = '';
    document.getElementById('reqPrioridad').value = 'Media';
    document.getElementById('reqObservaciones').value = '';
    
    // Limpiar tabla de artículos
    const tbody = document.getElementById('tbodyArticulos');
    tbody.innerHTML = '';
    articuloCounter = 0;
    agregarArticulo();
    
    document.getElementById('modalRequisicion').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalRequisicion() {
    document.getElementById('modalRequisicion').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function agregarArticulo() {
    const tbody = document.getElementById('tbodyArticulos');
    const articulosHtml = document.getElementById('tbodyArticulos').innerHTML;
    
    // Obtener opciones de artículos desde el select original
    const selectOriginal = document.querySelector('.articulo-select');
    let opcionesHtml = '';
    if (selectOriginal) {
        opcionesHtml = selectOriginal.innerHTML;
    } else {
        opcionesHtml = `<option value="">Seleccionar artículo</option>
            @isset($articulos)
                @foreach($articulos as $articulo)
                    <option value="{{ $articulo->id }}" data-unidad="{{ $articulo->unidad_medida }}">{{ $articulo->codigo }} - {{ $articulo->descripcion }}</option>
                @endforeach
            @endisset`;
    }
    
    const newRow = document.createElement('tr');
    newRow.id = `filaArticulo_${articuloCounter}`;
    newRow.innerHTML = `
        <td>
            <select class="articulo-select" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;">
                ${opcionesHtml}
            </select>
        </td>
        <td><input type="number" step="0.001" class="cantidad-input" style="width: 100px; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00"></td>
        <td><input type="text" class="unidad-input" style="width: 80px; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" readonly placeholder="Auto"></td>
        <td><input type="text" class="observacion-input" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observación"></td>
        <td><i class="fas fa-trash" onclick="eliminarArticulo(${articuloCounter})" style="color: #dc3545; cursor: pointer;"></i></td>
    `;
    tbody.appendChild(newRow);
    articuloCounter++;
}

function eliminarArticulo(id) {
    const row = document.getElementById(`filaArticulo_${id}`);
    if (row) row.remove();
}

function guardarRequisicion() {
    const proyectoId = document.getElementById('reqProyecto').value;
    const solicitante = document.getElementById('reqSolicitante').value.trim();
    
    if (!proyectoId) {
        alert('Seleccione un proyecto');
        return;
    }
    if (!solicitante) {
        alert('Ingrese el nombre del solicitante');
        return;
    }
    
    const articulos = [];
    const rows = document.querySelectorAll('#tbodyArticulos tr');
    
    for (let row of rows) {
        const articuloId = row.querySelector('.articulo-select')?.value;
        const cantidad = row.querySelector('.cantidad-input')?.value;
        const observacion = row.querySelector('.observacion-input')?.value;
        
        if (articuloId && cantidad && cantidad > 0) {
            articulos.push({
                articulo_id: articuloId,
                cantidad_solicitada: parseFloat(cantidad),
                observacion: observacion || null
            });
        }
    }
    
    if (articulos.length === 0) {
        alert('Agregue al menos un artículo');
        return;
    }
    
    const data = {
        proyecto_id: proyectoId,
        fecha_requisicion: document.getElementById('reqFecha').value,
        solicitante: solicitante,
        area: document.getElementById('reqArea').value,
        prioridad: document.getElementById('reqPrioridad').value,
        observaciones: document.getElementById('reqObservaciones').value,
        articulos: articulos
    };
    
    fetch('/inventario/api/requisiciones', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            alert('✅ ' + response.message);
            cerrarModalRequisicion();
            cargarRequisiciones();
        } else {
            alert('❌ Error: ' + response.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error al guardar la requisición');
    });
}

// Ver detalle
function verDetalle(id) {
    fetch(`/inventario/api/requisiciones/${id}`)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                const req = response.data;
                let html = `
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px;">
                        <div><strong>Folio:</strong> ${req.folio}</div>
                        <div><strong>Fecha:</strong> ${req.fecha_requisicion}</div>
                        <div><strong>Proyecto:</strong> ${req.proyecto_nombre}</div>
                        <div><strong>Solicitante:</strong> ${req.solicitante}</div>
                        <div><strong>Área:</strong> ${req.area || '---'}</div>
                        <div><strong>Prioridad:</strong> ${req.prioridad}</div>
                        <div><strong>Estatus:</strong> ${req.estatus}</div>
                        <div><strong>% Surtido:</strong> ${req.porcentaje_surtido}%</div>
                    </div>
                    ${req.observaciones ? `<div><strong>Observaciones:</strong> ${req.observaciones}</div><br>` : ''}
                    ${req.motivo_rechazo ? `<div style="color: #dc3545;"><strong>Motivo de rechazo:</strong> ${req.motivo_rechazo}</div><br>` : ''}
                    <hr>
                    <h4>Artículos Solicitados</h4>
                    <div class="table-container">
                        <table class="table">
                            <thead><tr><th>Código</th><th>Descripción</th><th>Solicitado</th><th>Autorizado</th><th>Surtido</th><th>Disponible</th></tr></thead>
                            <tbody>
                `;
                
                req.detalles.forEach(det => {
                    html += `<tr>
                        <td>${det.articulo_codigo}</td>
                        <td>${det.articulo_descripcion}</td>
                        <td>${det.cantidad_solicitada} ${det.unidad_medida}</td>
                        <td>${det.cantidad_autorizada > 0 ? det.cantidad_autorizada + ' ' + det.unidad_medida : '---'}</td>
                        <td>${det.cantidad_surtida > 0 ? det.cantidad_surtida + ' ' + det.unidad_medida : '---'}</td>
                        <td>${det.disponible} ${det.unidad_medida}</td>
                    </tr>`;
                });
                
                html += `</tbody></table></div>`;
                
                document.getElementById('detalleContenido').innerHTML = html;
                document.getElementById('detalleTitulo').textContent = `Requisición ${req.folio}`;
                
                // Botones según estatus
                let botonesHtml = `<button onclick="cerrarModalDetalle()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cerrar</button>`;
                if (req.estatus === 'Pendiente') {
                    botonesHtml += `<button onclick="autorizarRequisicion(${req.id}); cerrarModalDetalle();" style="padding: 8px 20px; border: none; border-radius: 4px; background: #28a745; color: white; cursor: pointer; margin-left: 10px;">✓ Autorizar</button>`;
                    botonesHtml += `<button onclick="rechazarRequisicion(${req.id}); cerrarModalDetalle();" style="padding: 8px 20px; border: none; border-radius: 4px; background: #dc3545; color: white; cursor: pointer; margin-left: 10px;">✗ Rechazar</button>`;
                }
                if (req.estatus === 'Autorizada') {
                    botonesHtml += `<button onclick="generarSurtido(${req.id}); cerrarModalDetalle();" style="padding: 8px 20px; border: none; border-radius: 4px; background: #17a2b8; color: white; cursor: pointer; margin-left: 10px;">🚚 Generar Surtido</button>`;
                }
                
                document.getElementById('detalleBotones').innerHTML = botonesHtml;
                document.getElementById('modalDetalle').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        });
}

function cerrarModalDetalle() {
    document.getElementById('modalDetalle').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Autorizar
function autorizarRequisicion(id) {
    // Primero obtener los detalles para mostrar el modal de autorización
    fetch(`/inventario/api/requisiciones/${id}`)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                const req = response.data;
                let mensaje = `Autorizar requisición ${req.folio}\n\n`;
                mensaje += `Proyecto: ${req.proyecto_nombre}\n`;
                mensaje += `Solicitante: ${req.solicitante}\n`;
                mensaje += `Prioridad: ${req.prioridad}\n\n`;
                mensaje += `Artículos:\n`;
                
                req.detalles.forEach(det => {
                    mensaje += `- ${det.articulo_codigo}: ${det.cantidad_solicitada} ${det.unidad_medida}\n`;
                });
                
                const cantidades = prompt(mensaje + '\n\nIngrese las cantidades autorizadas separadas por comas (en el mismo orden):');
                if (cantidades) {
                    const cantidadesArray = cantidades.split(',').map(c => parseFloat(c.trim()));
                    const articulosData = req.detalles.map((det, index) => ({
                        detalle_id: det.id,
                        cantidad_autorizada: cantidadesArray[index] || det.cantidad_solicitada
                    }));
                    
                    fetch(`/inventario/api/requisiciones/${id}/autorizar`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            articulos: articulosData,
                            observaciones: null
                        })
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            alert('✅ ' + res.message);
                            cargarRequisiciones();
                        } else {
                            alert('❌ Error: ' + res.message);
                        }
                    });
                }
            }
        });
}

// Rechazar
function rechazarRequisicion(id) {
    const motivo = prompt('Ingrese el motivo del rechazo:');
    if (motivo && motivo.trim()) {
        fetch(`/inventario/api/requisiciones/${id}/rechazar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ motivo: motivo })
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                alert('✅ ' + response.message);
                cargarRequisiciones();
            } else {
                alert('❌ Error: ' + response.message);
            }
        });
    }
}

// Generar Surtido
function generarSurtido(id) {
    fetch(`/inventario/api/requisiciones/${id}/generar-surtido`)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                const data = response.data;
                if (data.tiene_stock_suficiente) {
                    let mensaje = `Surtido para requisición ${data.requisicion.folio}\n\n`;
                    mensaje += `Proyecto: ${data.requisicion.proyecto}\n`;
                    mensaje += `Artículos a surtir:\n`;
                    
                    data.items_a_surtir.forEach(item => {
                        mensaje += `- ${item.articulo_codigo}: ${item.cantidad_solicitada} (Disponible: ${item.disponible})\n`;
                    });
                    
                    const confirmar = confirm(mensaje + '\n\n¿Desea proceder con el surtido?');
                    if (confirmar) {
                        const almacenId = prompt('Ingrese el ID del almacén desde donde se surtirá:');
                        if (almacenId) {
                            const items = data.items_a_surtir.map(item => ({
                                detalle_id: item.detalle_id,
                                cantidad: item.cantidad_solicitada
                            }));
                            
                            fetch(`/inventario/api/requisiciones/${id}/ejecutar-surtido`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({
                                    almacen_id: almacenId,
                                    items: items
                                })
                            })
                            .then(res => res.json())
                            .then(res => {
                                if (res.success) {
                                    alert('✅ ' + res.message);
                                    cargarRequisiciones();
                                } else {
                                    alert('❌ Error: ' + res.message);
                                }
                            });
                        }
                    }
                } else {
                    let mensaje = `⚠️ Stock insuficiente para la requisición ${data.requisicion.folio}\n\n`;
                    mensaje += `Artículos sin stock suficiente:\n`;
                    data.items_sin_stock.forEach(item => {
                        mensaje += `- ${item.articulo_codigo}: Requiere ${item.cantidad_solicitada}, Disponible: ${item.disponible}, Faltante: ${item.faltante}\n`;
                    });
                    alert(mensaje);
                }
            } else {
                alert('❌ Error: ' + response.message);
            }
        });
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        cerrarModalRequisicion();
        cerrarModalDetalle();
    }
});

document.getElementById('modalRequisicion')?.addEventListener('click', (e) => {
    if (e.target === this) cerrarModalRequisicion();
});
document.getElementById('modalDetalle')?.addEventListener('click', (e) => {
    if (e.target === this) cerrarModalDetalle();
});
</script>
@endsection