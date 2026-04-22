@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-box"></i> Catálogo de Artículos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <div>
                            <select id="filtroFamilia" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px; min-width: 150px;">
                                <option value="">Todas las familias</option>
                                @isset($familias)
                                    @foreach($familias as $familia)
                                        <option value="{{ $familia->id }}">{{ $familia->nombre }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div>
                            <select id="filtroSubfamilia" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px; min-width: 150px;">
                                <option value="">Todas las subfamilias</option>
                            </select>
                        </div>
                        <div>
                            <select id="filtroEstatus" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px; min-width: 100px;">
                                <option value="">Todos</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                        <div>
                            <button id="btnAgregar" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                    onclick="abrirModalArticulo()">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div>
                            <button id="btnExcel" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                <i class="fas fa-file-excel"></i> <span class="hide-mobile">Excel</span>
                            </button>
                        </div>
                        <div style="position: relative;">
                            <button id="btnColumnas" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);" onclick="toggleColumnSelector()">
                                <i class="fas fa-columns"></i> <span class="hide-mobile">Columnas</span>
                            </button>
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 300px; max-height: 400px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>
                        <div style="position: relative; min-width: 250px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar artículo..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="table-container">
                    <table class="table" id="tablaArticulos">
                        <thead>
                            <tr>
                                <th draggable="true" data-columna="estatus">Estatus</th>
                                <th draggable="true" data-columna="codigo">Código</th>
                                <th draggable="true" data-columna="familia">Familia</th>
                                <th draggable="true" data-columna="subfamilia">Subfamilia</th>
                                <th draggable="true" data-columna="descripcion">Descripción</th>
                                <th draggable="true" data-columna="numero_parte">N° Parte</th>
                                <th draggable="true" data-columna="ubicacion">Ubicación</th>
                                <th draggable="true" data-columna="minimo">Mínimo</th>
                                <th draggable="true" data-columna="maximo">Máximo</th>
                                <th draggable="true" data-columna="reorden">Reorden</th>
                                <th draggable="true" data-columna="unidad">Unidad</th>
                                <th draggable="true" data-columna="cuenta_contable">Cta. Contable</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="13" style="text-align: center;">Cargando...</td><th>
                        </tbody>
                        <tfoot>
                            <tr><td colspan="13" style="text-align: center;">Total: 0</td><th>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter"></i> Crear filtro
                    </button>
                    
                    <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 13px; color: #6c757d;">Mostrando <span id="inicioRegistro">0</span> - <span id="finRegistro">0</span> de <span id="totalRegistros">0</span></span>
                            <select id="registrosPorPagina" style="padding: 5px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                                <option value="5">5</option>
                                <option value="10" selected>10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <button class="page-btn" id="btnPrimera" title="Primera página"><i class="fas fa-angle-double-left"></i></button>
                            <button class="page-btn" id="btnAnterior" title="Página anterior"><i class="fas fa-angle-left"></i></button>
                            <span id="paginaActual" style="min-width: 40px; height: 36px; display: flex; align-items: center; justify-content: center; background-color: var(--color-primary); color: white; border-radius: 4px;">1</span>
                            <span style="font-size: 13px;">de <span id="totalPaginas">1</span></span>
                            <button class="page-btn" id="btnSiguiente" title="Página siguiente"><i class="fas fa-angle-right"></i></button>
                            <button class="page-btn" id="btnUltima" title="Última página"><i class="fas fa-angle-double-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Artículo -->
<div id="modalArticulo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 800px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;" id="modalTituloArticulo">Nuevo Artículo</h3>
            <button onclick="cerrarModalArticulo()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;">
            <input type="hidden" id="articuloId">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Estatus</label>
                    <select id="modalEstatusArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Código</label>
                    <input type="text" id="modalCodigoArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" readonly placeholder="Autogenerado">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Familia</label>
                    <select id="modalFamiliaArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar familia</option>
                        @isset($familias)
                            @foreach($familias as $familia)
                                <option value="{{ $familia->id }}">{{ $familia->codigo }} - {{ $familia->nombre }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Subfamilia</label>
                    <select id="modalSubfamiliaArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Primero seleccione una familia</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Número de Parte</label>
                    <input type="text" id="modalNumeroParteArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Número de parte">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Ubicación</label>
                    <input type="text" id="modalUbicacionArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ubicación en almacén">
                </div>
                <div style="grid-column: span 3;">
                    <label style="font-size: 13px; font-weight: 600;">Descripción <span style="color: red;">*</span></label>
                    <input type="text" id="modalDescripcionArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción del artículo">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Stock Mínimo</label>
                    <input type="number" step="0.001" id="modalMinimoArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="0">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Stock Máximo</label>
                    <input type="number" step="0.001" id="modalMaximoArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="0">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Punto de Reorden</label>
                    <input type="number" step="0.001" id="modalReordenArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="0">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Unidad de Medida</label>
                    <select id="modalUnidadArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar unidad</option>
                        <option value="Pieza">Pieza</option>
                        <option value="Kilogramo">Kilogramo</option>
                        <option value="Litro">Litro</option>
                        <option value="Metro">Metro</option>
                        <option value="Metro Cuadrado">Metro Cuadrado</option>
                        <option value="Metro Cúbico">Metro Cúbico</option>
                        <option value="Caja">Caja</option>
                        <option value="Paquete">Paquete</option>
                        <option value="Juego">Juego</option>
                        <option value="Tonelada">Tonelada</option>
                        <option value="Galón">Galón</option>
                        <option value="Bulto">Bulto</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Cuenta Contable</label>
                    <input type="text" id="modalCuentaArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Cuenta contable">
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalArticulo()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarArticulo()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
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
    .badge-activo { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-inactivo { background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; display: inline-block; min-width: 70px; text-align: center; }
    .table td:last-child i { margin: 0 5px; cursor: pointer; }
    .table td:last-child i.fa-edit, .table td:last-child i.fa-eye { color: var(--color-primary); }
    .table td:last-child i.fa-trash { color: #dc3545; }
    .page-btn { width: 36px; height: 36px; border: 1px solid var(--color-primary); border-radius: 4px; background: transparent; cursor: pointer; color: var(--color-primary); }
    .page-btn:disabled { opacity: 0.5; cursor: not-allowed; }
    @media (max-width: 768px) { .hide-mobile { display: none; } }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
let editingId = null;
let currentPage = 1;
let perPage = 10;
let totalRecords = 0;
let searchTimeout = null;

document.addEventListener('DOMContentLoaded', function() {
    cargarArticulos();
    configurarEventos();
    cargarSubfamiliasPorFamilia();
});

// Cargar subfamilias cuando cambia la familia
function cargarSubfamiliasPorFamilia() {
    const familiaSelect = document.getElementById('modalFamiliaArticulo');
    if (familiaSelect) {
        familiaSelect.addEventListener('change', function() {
            const familiaId = this.value;
            const subfamiliaSelect = document.getElementById('modalSubfamiliaArticulo');
            
            if (familiaId) {
                fetch(`/almacen/api/subfamilias-por-familia/${familiaId}`)
                    .then(response => response.json())
                    .then(response => {
                        if (response.success) {
                            subfamiliaSelect.innerHTML = '<option value="">Seleccionar subfamilia</option>';
                            response.data.forEach(sub => {
                                subfamiliaSelect.innerHTML += `<option value="${sub.id}">${sub.codigo} - ${sub.nombre}</option>`;
                            });
                        }
                    });
            } else {
                subfamiliaSelect.innerHTML = '<option value="">Primero seleccione una familia</option>';
            }
        });
    }
}

function cargarArticulos() {
    const search = document.getElementById('buscador')?.value || '';
    const familiaId = document.getElementById('filtroFamilia')?.value || '';
    const subfamiliaId = document.getElementById('filtroSubfamilia')?.value || '';
    const estatus = document.getElementById('filtroEstatus')?.value || '';
    
    let url = `{{ route('almacen.api.articulos') }}?page=${currentPage}&per_page=${perPage}`;
    if (search) url += `&search=${encodeURIComponent(search)}`;
    if (familiaId) url += `&familia_id=${familiaId}`;
    if (subfamiliaId) url += `&subfamilia_id=${subfamiliaId}`;
    if (estatus) url += `&estatus=${estatus}`;
    
    fetch(url)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                renderizarTabla(response.data);
                totalRecords = response.total;
                const totalPages = response.last_page;
                document.getElementById('totalRegistros').textContent = totalRecords;
                document.getElementById('totalPaginas').textContent = totalPages;
                document.getElementById('paginaActual').textContent = currentPage;
                
                const inicio = (currentPage - 1) * perPage + 1;
                const fin = Math.min(currentPage * perPage, totalRecords);
                document.getElementById('inicioRegistro').textContent = totalRecords > 0 ? inicio : 0;
                document.getElementById('finRegistro').textContent = fin;
                
                document.getElementById('btnPrimera').disabled = currentPage === 1;
                document.getElementById('btnAnterior').disabled = currentPage === 1;
                document.getElementById('btnSiguiente').disabled = currentPage === totalPages;
                document.getElementById('btnUltima').disabled = currentPage === totalPages;
                
                document.querySelector('#tablaArticulos tfoot td').innerHTML = `Total: ${totalRecords}`;
            }
        })
        .catch(error => console.error('Error:', error));
}

function renderizarTabla(data) {
    const tbody = document.getElementById('tablaBody');
    if (!data.length) {
        tbody.innerHTML = '<tr><td colspan="13" style="text-align: center;">No hay artículos registrados</td><th';
        return;
    }
    
    tbody.innerHTML = '';
    data.forEach((item, index) => {
        const row = tbody.insertRow();
        row.style.backgroundColor = index % 2 === 1 ? '#f8f9fa' : 'white';
        
        const estatusBadge = item.estatus === 'Activo' ? '<span class="badge-activo">Activo</span>' : '<span class="badge-inactivo">Inactivo</span>';
        
        row.insertCell(0).innerHTML = estatusBadge;
        row.insertCell(1).innerHTML = `<strong>${escapeHtml(item.codigo)}</strong>`;
        row.insertCell(2).innerHTML = escapeHtml(item.familia_nombre) || '---';
        row.insertCell(3).innerHTML = escapeHtml(item.subfamilia_nombre) || '---';
        row.insertCell(4).innerHTML = escapeHtml(item.descripcion);
        row.insertCell(5).innerHTML = escapeHtml(item.numero_parte) || '---';
        row.insertCell(6).innerHTML = escapeHtml(item.ubicacion) || '---';
        row.insertCell(7).innerHTML = item.minimo || 0;
        row.insertCell(8).innerHTML = item.maximo || 0;
        row.insertCell(9).innerHTML = item.punto_reorden || 0;
        row.insertCell(10).innerHTML = escapeHtml(item.unidad_medida) || '---';
        row.insertCell(11).innerHTML = escapeHtml(item.cuenta_contable) || '---';
        row.insertCell(12).innerHTML = `
            <i class="fas fa-edit" onclick="editarArticulo(${item.id})" title="Editar"></i>
            <i class="fas fa-trash" onclick="eliminarArticulo(${item.id}, '${item.codigo}')" title="Eliminar"></i>
        `;
    });
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function configurarEventos() {
    document.getElementById('buscador').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            currentPage = 1;
            cargarArticulos();
        }, 500);
    });
    
    document.getElementById('filtroFamilia').addEventListener('change', () => { currentPage = 1; cargarArticulos(); });
    document.getElementById('filtroSubfamilia').addEventListener('change', () => { currentPage = 1; cargarArticulos(); });
    document.getElementById('filtroEstatus').addEventListener('change', () => { currentPage = 1; cargarArticulos(); });
    document.getElementById('registrosPorPagina').addEventListener('change', function() { perPage = parseInt(this.value); currentPage = 1; cargarArticulos(); });
    
    document.getElementById('btnPrimera').addEventListener('click', () => { currentPage = 1; cargarArticulos(); });
    document.getElementById('btnAnterior').addEventListener('click', () => { if (currentPage > 1) { currentPage--; cargarArticulos(); } });
    document.getElementById('btnSiguiente').addEventListener('click', () => { currentPage++; cargarArticulos(); });
    document.getElementById('btnUltima').addEventListener('click', () => { 
        const totalPages = parseInt(document.getElementById('totalPaginas').textContent);
        currentPage = totalPages;
        cargarArticulos();
    });
    
    document.getElementById('btnCrearFiltro').addEventListener('click', () => alert('Filtros avanzados en desarrollo'));
    document.getElementById('btnExcel').addEventListener('click', () => window.location.href = '{{ route("almacen.api.articulos.exportar") }}');
}

window.abrirModalArticulo = function() {
    editingId = null;
    document.getElementById('modalTituloArticulo').textContent = 'Nuevo Artículo';
    document.getElementById('articuloId').value = '';
    document.getElementById('modalCodigoArticulo').value = 'Autogenerado';
    document.getElementById('modalEstatusArticulo').value = 'Activo';
    document.getElementById('modalFamiliaArticulo').value = '';
    document.getElementById('modalSubfamiliaArticulo').innerHTML = '<option value="">Primero seleccione una familia</option>';
    document.getElementById('modalDescripcionArticulo').value = '';
    document.getElementById('modalNumeroParteArticulo').value = '';
    document.getElementById('modalUbicacionArticulo').value = '';
    document.getElementById('modalMinimoArticulo').value = 0;
    document.getElementById('modalMaximoArticulo').value = 0;
    document.getElementById('modalReordenArticulo').value = 0;
    document.getElementById('modalUnidadArticulo').value = '';
    document.getElementById('modalCuentaArticulo').value = '';
    document.getElementById('modalArticulo').style.display = 'flex';
    document.body.style.overflow = 'hidden';
};

window.editarArticulo = function(id) {
    fetch(`{{ route('almacen.api.articulos.show', '') }}/${id}`)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                const art = response.data;
                editingId = art.id;
                document.getElementById('modalTituloArticulo').textContent = `Editar Artículo ${art.codigo}`;
                document.getElementById('articuloId').value = art.id;
                document.getElementById('modalCodigoArticulo').value = art.codigo;
                document.getElementById('modalEstatusArticulo').value = art.estatus;
                document.getElementById('modalFamiliaArticulo').value = art.familia_id || '';
                document.getElementById('modalDescripcionArticulo').value = art.descripcion;
                document.getElementById('modalNumeroParteArticulo').value = art.numero_parte || '';
                document.getElementById('modalUbicacionArticulo').value = art.ubicacion || '';
                document.getElementById('modalMinimoArticulo').value = art.minimo;
                document.getElementById('modalMaximoArticulo').value = art.maximo;
                document.getElementById('modalReordenArticulo').value = art.punto_reorden;
                document.getElementById('modalUnidadArticulo').value = art.unidad_medida || '';
                document.getElementById('modalCuentaArticulo').value = art.cuenta_contable || '';
                
                if (art.familia_id) {
                    fetch(`/almacen/api/subfamilias-por-familia/${art.familia_id}`)
                        .then(res => res.json())
                        .then(res => {
                            if (res.success) {
                                const subSelect = document.getElementById('modalSubfamiliaArticulo');
                                subSelect.innerHTML = '<option value="">Seleccionar subfamilia</option>';
                                res.data.forEach(sub => {
                                    subSelect.innerHTML += `<option value="${sub.id}" ${art.subfamilia_id == sub.id ? 'selected' : ''}>${sub.codigo} - ${sub.nombre}</option>`;
                                });
                            }
                        });
                }
                
                document.getElementById('modalArticulo').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        });
};

window.guardarArticulo = function() {
    const descripcion = document.getElementById('modalDescripcionArticulo').value.trim();
    if (!descripcion) {
        alert('La descripción es obligatoria');
        return;
    }
    
    const data = {
        descripcion: descripcion,
        numero_parte: document.getElementById('modalNumeroParteArticulo').value,
        familia_id: document.getElementById('modalFamiliaArticulo').value || null,
        subfamilia_id: document.getElementById('modalSubfamiliaArticulo').value || null,
        ubicacion: document.getElementById('modalUbicacionArticulo').value,
        minimo: parseFloat(document.getElementById('modalMinimoArticulo').value) || 0,
        maximo: parseFloat(document.getElementById('modalMaximoArticulo').value) || 0,
        punto_reorden: parseFloat(document.getElementById('modalReordenArticulo').value) || 0,
        unidad_medida: document.getElementById('modalUnidadArticulo').value,
        cuenta_contable: document.getElementById('modalCuentaArticulo').value,
        estatus: document.getElementById('modalEstatusArticulo').value
    };
    
    const url = editingId ? `{{ route('almacen.api.articulos.update', '') }}/${editingId}` : '{{ route("almacen.api.articulos.store") }}';
    const method = editingId ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            alert(response.message);
            cerrarModalArticulo();
            cargarArticulos();
        } else {
            alert('Error: ' + response.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar el artículo');
    });
};

window.eliminarArticulo = function(id, codigo) {
    if (confirm(`¿Eliminar el artículo ${codigo}?`)) {
        fetch(`{{ route('almacen.api.articulos.destroy', '') }}/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                alert(response.message);
                cargarArticulos();
            } else {
                alert('Error: ' + response.message);
            }
        });
    }
};

window.cerrarModalArticulo = function() {
    document.getElementById('modalArticulo').style.display = 'none';
    document.body.style.overflow = 'auto';
};

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModalArticulo();
});

document.getElementById('modalArticulo').addEventListener('click', function(e) {
    if (e.target === this) cerrarModalArticulo();
});

// Funciones de UI (selector de columnas, drag & drop, etc.)
let columnasAgrupadas = [];

function actualizarGrupoColumnas() {
    const container = document.getElementById('grupoColumnas');
    const texto = document.getElementById('textoAgrupar');
    if (!container) return;
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

document.addEventListener('dragstart', (e) => {
    if (e.target.tagName === 'TH' && e.target.draggable) {
        e.dataTransfer.setData('text/plain', e.target.dataset.columna);
    }
});

document.getElementById('grupoAgrupacion')?.addEventListener('dragover', (e) => e.preventDefault());
document.getElementById('grupoAgrupacion')?.addEventListener('drop', (e) => {
    e.preventDefault();
    const columna = e.dataTransfer.getData('text/plain');
    if (columna && !columnasAgrupadas.includes(columna)) {
        columnasAgrupadas.push(columna);
        actualizarGrupoColumnas();
        alert('Agrupando por: ' + columna);
    }
});

window.toggleColumnSelector = function() {
    const selector = document.getElementById('columnSelector');
    selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
    if (selector.style.display === 'block') {
        const columnas = [
            { field: 'estatus', caption: 'Estatus' }, { field: 'codigo', caption: 'Código' },
            { field: 'familia', caption: 'Familia' }, { field: 'subfamilia', caption: 'Subfamilia' },
            { field: 'descripcion', caption: 'Descripción' }, { field: 'numero_parte', caption: 'Número Parte' },
            { field: 'ubicacion', caption: 'Ubicación' }, { field: 'minimo', caption: 'Mínimo' },
            { field: 'maximo', caption: 'Máximo' }, { field: 'reorden', caption: 'Reorden' },
            { field: 'unidad', caption: 'Unidad' }, { field: 'cuenta_contable', caption: 'Cuenta Contable' }
        ];
        const lista = document.getElementById('columnasLista');
        lista.innerHTML = columnas.map(col => `<div style="padding:5px 0;"><input type="checkbox" id="chk_${col.field}" checked><label> ${col.caption}</label></div>`).join('');
    }
};

window.cerrarColumnSelector = function() {
    document.getElementById('columnSelector').style.display = 'none';
};

document.addEventListener('click', function(e) {
    if (!e.target.closest('#btnColumnas') && !e.target.closest('#columnSelector')) {
        document.getElementById('columnSelector').style.display = 'none';
    }
});
</script>
@endsection