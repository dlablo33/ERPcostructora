@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-warehouse"></i> Catálogo de Almacenes
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros y herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <div>
                            <select id="filtroTipo" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px; min-width: 150px;">
                                <option value="">Todos los tipos</option>
                                <option value="General">General</option>
                                <option value="Refrigerado">Refrigerado</option>
                                <option value="Materiales Peligrosos">Materiales Peligrosos</option>
                                <option value="Herramientas">Herramientas</option>
                                <option value="Maquinaria">Maquinaria</option>
                                <option value="Temporal">Temporal</option>
                                <option value="Combustibles">Combustibles</option>
                                <option value="Obra">Obra</option>
                                <option value="Consumibles">Consumibles</option>
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
                            <button id="btnAgregar" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary);" onclick="abrirModalAlmacen()">
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
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 280px; max-height: 400px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary);">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>
                        <div style="position: relative; min-width: 200px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar almacén..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="table-container">
                    <table class="table" id="tablaAlmacenes">
                        <thead>
                            <tr>
                                <th draggable="true" data-columna="estatus">Estatus</th>
                                <th draggable="true" data-columna="codigo">Código</th>
                                <th draggable="true" data-columna="nombre">Nombre</th>
                                <th draggable="true" data-columna="tipo">Tipo</th>
                                <th draggable="true" data-columna="descripcion">Descripción</th>
                                <th draggable="true" data-columna="ubicacion">Ubicación</th>
                                <th draggable="true" data-columna="responsable">Responsable</th>
                                <th draggable="true" data-columna="cuenta_contable">Cuenta Contable</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="9" style="text-align: center;">Cargando...</td></tr>
                        </tbody>
                        <tfoot>
                            <tr><td colspan="9" style="text-align: center;">Total: 0</td></tr>
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
                            <button class="page-btn" id="btnPrimera"><i class="fas fa-angle-double-left"></i></button>
                            <button class="page-btn" id="btnAnterior"><i class="fas fa-angle-left"></i></button>
                            <span id="paginaActual" style="min-width: 40px; height: 36px; display: flex; align-items: center; justify-content: center; background-color: var(--color-primary); color: white; border-radius: 4px;">1</span>
                            <span>de <span id="totalPaginas">1</span></span>
                            <button class="page-btn" id="btnSiguiente"><i class="fas fa-angle-right"></i></button>
                            <button class="page-btn" id="btnUltima"><i class="fas fa-angle-double-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Almacén -->
<div id="modalAlmacen" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 700px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;" id="modalTituloAlmacen">Nuevo Almacén</h3>
            <button onclick="cerrarModalAlmacen()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;">
            <input type="hidden" id="almacenId">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Estatus</label>
                    <select id="modalEstatusAlmacen" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Código</label>
                    <input type="text" id="modalCodigoAlmacen" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" readonly placeholder="Autogenerado">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Nombre <span style="color: red;">*</span></label>
                    <input type="text" id="modalNombreAlmacen" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Nombre del almacén">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Tipo <span style="color: red;">*</span></label>
                    <select id="modalTipoAlmacen" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar tipo</option>
                        <option value="General">General</option>
                        <option value="Refrigerado">Refrigerado</option>
                        <option value="Materiales Peligrosos">Materiales Peligrosos</option>
                        <option value="Herramientas">Herramientas</option>
                        <option value="Maquinaria">Maquinaria</option>
                        <option value="Temporal">Temporal</option>
                        <option value="Combustibles">Combustibles</option>
                        <option value="Obra">Obra</option>
                        <option value="Consumibles">Consumibles</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Ubicación</label>
                    <input type="text" id="modalUbicacionAlmacen" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Dirección física">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Responsable</label>
                    <input type="text" id="modalResponsableAlmacen" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Persona responsable">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Teléfono</label>
                    <input type="text" id="modalTelefonoAlmacen" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Teléfono de contacto">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Email</label>
                    <input type="email" id="modalEmailAlmacen" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="correo@ejemplo.com">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Cuenta Contable</label>
                    <input type="text" id="modalCuentaAlmacen" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="1150-01-001">
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Descripción</label>
                    <textarea id="modalDescripcionAlmacen" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción del almacén..."></textarea>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalAlmacen()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarAlmacen()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
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
    .badge-activo { background-color: #28a745; color: white; padding: 4px 12px; border-radius: 20px; display: inline-block; font-size: 11px; font-weight: 500; }
    .badge-inactivo { background-color: #dc3545; color: white; padding: 4px 12px; border-radius: 20px; display: inline-block; font-size: 11px; font-weight: 500; }
    .table td:last-child i { margin: 0 5px; cursor: pointer; font-size: 14px; }
    .table td:last-child i.fa-edit { color: var(--color-primary); }
    .table td:last-child i.fa-trash { color: #dc3545; }
    .table td:last-child i.fa-redo-alt { color: #ffc107; }
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
    cargarAlmacenes();
    configurarEventos();
});

function cargarAlmacenes() {
    const search = document.getElementById('buscador')?.value || '';
    const tipo = document.getElementById('filtroTipo')?.value || '';
    const estatus = document.getElementById('filtroEstatus')?.value || '';
    
    let url = `{{ route('almacen.api.almacenes') }}?page=${currentPage}&per_page=${perPage}`;
    if (search) url += `&search=${encodeURIComponent(search)}`;
    if (tipo) url += `&tipo=${encodeURIComponent(tipo)}`;
    if (estatus) url += `&estatus=${encodeURIComponent(estatus)}`;
    
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
                
                document.querySelector('#tablaAlmacenes tfoot td').innerHTML = `Total: ${totalRecords}`;
            }
        })
        .catch(error => console.error('Error:', error));
}

function renderizarTabla(data) {
    const tbody = document.getElementById('tablaBody');
    if (!data.length) {
        tbody.innerHTML = '<tr><td colspan="9" style="text-align: center;">No hay almacenes registrados</td></tr>';
        return;
    }
    
    tbody.innerHTML = '';
    data.forEach((item, index) => {
        const row = tbody.insertRow();
        row.style.backgroundColor = index % 2 === 1 ? '#f8f9fa' : 'white';
        
        const estatusBadge = item.estatus === 'Activo' 
            ? '<span class="badge-activo">Activo</span>' 
            : '<span class="badge-inactivo">Inactivo</span>';
        
        let acciones = `
            <i class="fas fa-edit" onclick="editarAlmacen(${item.id})" title="Editar"></i>
            <i class="fas fa-trash" onclick="eliminarAlmacen(${item.id}, '${item.codigo}')" title="Eliminar"></i>
        `;
        
        if (item.estatus === 'Inactivo') {
            acciones += ` <i class="fas fa-redo-alt" onclick="reactivarAlmacen(${item.id}, '${item.codigo}')" title="Reactivar"></i>`;
        }
        
        row.insertCell(0).innerHTML = estatusBadge;
        row.insertCell(1).innerHTML = `<strong>${escapeHtml(item.codigo)}</strong>`;
        row.insertCell(2).innerHTML = escapeHtml(item.nombre);
        row.insertCell(3).innerHTML = escapeHtml(item.tipo);
        row.insertCell(4).innerHTML = escapeHtml(item.descripcion) || '---';
        row.insertCell(5).innerHTML = escapeHtml(item.ubicacion) || '---';
        row.insertCell(6).innerHTML = escapeHtml(item.responsable) || '---';
        row.insertCell(7).innerHTML = escapeHtml(item.cuenta_contable) || '---';
        row.insertCell(8).innerHTML = acciones;
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
        searchTimeout = setTimeout(() => { currentPage = 1; cargarAlmacenes(); }, 500);
    });
    
    document.getElementById('filtroTipo').addEventListener('change', () => { currentPage = 1; cargarAlmacenes(); });
    document.getElementById('filtroEstatus').addEventListener('change', () => { currentPage = 1; cargarAlmacenes(); });
    document.getElementById('registrosPorPagina').addEventListener('change', function() { 
        perPage = parseInt(this.value); 
        currentPage = 1; 
        cargarAlmacenes(); 
    });
    
    document.getElementById('btnPrimera').addEventListener('click', () => { currentPage = 1; cargarAlmacenes(); });
    document.getElementById('btnAnterior').addEventListener('click', () => { if (currentPage > 1) { currentPage--; cargarAlmacenes(); } });
    document.getElementById('btnSiguiente').addEventListener('click', () => { currentPage++; cargarAlmacenes(); });
    document.getElementById('btnUltima').addEventListener('click', () => { 
        const totalPages = parseInt(document.getElementById('totalPaginas').textContent);
        currentPage = totalPages;
        cargarAlmacenes();
    });
    
    document.getElementById('btnCrearFiltro').addEventListener('click', () => alert('Filtros avanzados en desarrollo'));
    document.getElementById('btnExcel').addEventListener('click', () => window.location.href = '{{ route("almacen.api.almacenes.exportar") }}');
}

window.abrirModalAlmacen = function() {
    editingId = null;
    document.getElementById('modalTituloAlmacen').textContent = 'Nuevo Almacén';
    document.getElementById('almacenId').value = '';
    document.getElementById('modalCodigoAlmacen').value = 'Autogenerado';
    document.getElementById('modalEstatusAlmacen').value = 'Activo';
    document.getElementById('modalNombreAlmacen').value = '';
    document.getElementById('modalTipoAlmacen').value = '';
    document.getElementById('modalDescripcionAlmacen').value = '';
    document.getElementById('modalUbicacionAlmacen').value = '';
    document.getElementById('modalResponsableAlmacen').value = '';
    document.getElementById('modalTelefonoAlmacen').value = '';
    document.getElementById('modalEmailAlmacen').value = '';
    document.getElementById('modalCuentaAlmacen').value = '';
    document.getElementById('modalAlmacen').style.display = 'flex';
    document.body.style.overflow = 'hidden';
};

window.editarAlmacen = function(id) {
    fetch(`{{ route('almacen.api.almacenes.show', '') }}/${id}`)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                const item = response.data;
                editingId = item.id;
                document.getElementById('modalTituloAlmacen').textContent = `Editar Almacén ${item.codigo}`;
                document.getElementById('almacenId').value = item.id;
                document.getElementById('modalCodigoAlmacen').value = item.codigo;
                document.getElementById('modalEstatusAlmacen').value = item.estatus;
                document.getElementById('modalNombreAlmacen').value = item.nombre;
                document.getElementById('modalTipoAlmacen').value = item.tipo;
                document.getElementById('modalDescripcionAlmacen').value = item.descripcion || '';
                document.getElementById('modalUbicacionAlmacen').value = item.ubicacion || '';
                document.getElementById('modalResponsableAlmacen').value = item.responsable || '';
                document.getElementById('modalTelefonoAlmacen').value = item.telefono || '';
                document.getElementById('modalEmailAlmacen').value = item.email || '';
                document.getElementById('modalCuentaAlmacen').value = item.cuenta_contable || '';
                document.getElementById('modalAlmacen').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        });
};

window.guardarAlmacen = function() {
    const nombre = document.getElementById('modalNombreAlmacen').value.trim();
    const tipo = document.getElementById('modalTipoAlmacen').value;
    
    if (!nombre) {
        alert('El nombre es obligatorio');
        return;
    }
    if (!tipo) {
        alert('El tipo de almacén es obligatorio');
        return;
    }
    
    const data = {
        nombre: nombre,
        tipo: tipo,
        descripcion: document.getElementById('modalDescripcionAlmacen').value,
        ubicacion: document.getElementById('modalUbicacionAlmacen').value,
        responsable: document.getElementById('modalResponsableAlmacen').value,
        telefono: document.getElementById('modalTelefonoAlmacen').value,
        email: document.getElementById('modalEmailAlmacen').value,
        cuenta_contable: document.getElementById('modalCuentaAlmacen').value,
        estatus: document.getElementById('modalEstatusAlmacen').value
    };
    
    const url = editingId ? `{{ route('almacen.api.almacenes.update', '') }}/${editingId}` : '{{ route("almacen.api.almacenes.store") }}';
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
            cerrarModalAlmacen();
            cargarAlmacenes();
        } else {
            alert('Error: ' + response.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar el almacén');
    });
};

window.eliminarAlmacen = function(id, codigo) {
    if (confirm(`¿Eliminar el almacén ${codigo}?`)) {
        fetch(`{{ route('almacen.api.almacenes.destroy', '') }}/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                alert(response.message);
                cargarAlmacenes();
            } else {
                alert('Error: ' + response.message);
            }
        });
    }
};

window.reactivarAlmacen = function(id, codigo) {
    if (confirm(`¿Reactivar el almacén ${codigo}?`)) {
        fetch(`{{ route('almacen.api.almacenes.reactivar', '') }}/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                alert(response.message);
                cargarAlmacenes();
            } else {
                alert('Error: ' + response.message);
            }
        });
    }
};

window.cerrarModalAlmacen = function() {
    document.getElementById('modalAlmacen').style.display = 'none';
    document.body.style.overflow = 'auto';
};

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModalAlmacen();
});

document.getElementById('modalAlmacen').addEventListener('click', function(e) {
    if (e.target === this) cerrarModalAlmacen();
});

// Funciones de UI
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
            { field: 'nombre', caption: 'Nombre' }, { field: 'tipo', caption: 'Tipo' },
            { field: 'descripcion', caption: 'Descripción' }, { field: 'ubicacion', caption: 'Ubicación' },
            { field: 'responsable', caption: 'Responsable' }, { field: 'cuenta_contable', caption: 'Cuenta Contable' }
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