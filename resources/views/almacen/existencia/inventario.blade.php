@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-clipboard-list"></i> Inventario Físico por Proyecto
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
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Artículo</label>
                        <select id="filtroArticulo" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Todos los artículos</option>
                            @isset($articulos)
                                @foreach($articulos as $articulo)
                                    <option value="{{ $articulo->id }}">{{ $articulo->codigo }} - {{ $articulo->descripcion }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Almacén</label>
                        <select id="filtroAlmacen" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Todos los almacenes</option>
                            @isset($almacenes)
                                @foreach($almacenes as $almacen)
                                    <option value="{{ $almacen->id }}">{{ $almacen->codigo }} - {{ $almacen->nombre }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div style="display: flex; align-items: flex-end;">
                        <button id="btnActualizar" style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; width: 100%;">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                    </div>
                </div>

                <!-- Botones -->
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 15px;">
                    <button id="btnExportar" class="btn-excel" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 15px; cursor: pointer; color: var(--color-primary);">
                        <i class="fas fa-file-excel"></i> Exportar a Excel
                    </button>
                </div>

                <!-- Tabla de Inventario -->
                <div class="table-container">
                    <table class="table" id="tablaInventario">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Proyecto</th>
                                <th>Código</th>
                                <th>Artículo</th>
                                <th>Stock Actual</th>
                                <th>Disponible</th>
                                <th>Mínimo</th>
                                <th>Máximo</th>
                                <th>Reorden</th>
                                <th>Ubicaciones</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="12" style="text-align: center;">Cargando...<\/td></tr>
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
    .badge-bajo-stock { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 12px; font-size: 10px; }
    .badge-normal { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 12px; font-size: 10px; }
    .btn-excel:hover { background-color: var(--color-primary) !important; color: white !important; }
    .ubicacion-tag { background-color: #e9ecef; padding: 2px 6px; border-radius: 4px; font-size: 10px; margin: 2px; display: inline-block; }
    @media (max-width: 768px) { div[style*="grid-template-columns: repeat(4, 1fr)"] { grid-template-columns: repeat(2, 1fr) !important; } }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
let currentPage = 1;
let perPage = 10;
let totalPages = 1;

document.addEventListener('DOMContentLoaded', function() {
    cargarInventario();
    configurarEventos();
});

function cargarInventario() {
    const proyectoId = document.getElementById('filtroProyecto')?.value || '';
    const articuloId = document.getElementById('filtroArticulo')?.value || '';
    const almacenId = document.getElementById('filtroAlmacen')?.value || '';
    
    let url = `/almacen/api/inventario-fisico?page=${currentPage}&per_page=${perPage}`;
    if (proyectoId) url += `&proyecto_id=${proyectoId}`;
    if (articuloId) url += `&articulo_id=${articuloId}`;
    if (almacenId) url += `&almacen_id=${almacenId}`;
    
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
        tbody.innerHTML = '<tr><td colspan="12" style="text-align: center;">No hay inventario registrado</td></tr>';
        return;
    }
    
    tbody.innerHTML = '';
    data.forEach((item, index) => {
        const row = tbody.insertRow();
        row.style.backgroundColor = index % 2 === 1 ? '#f8f9fa' : 'white';
        
        // Estado de stock
        const stockStatus = item.bajo_stock 
            ? '<span class="badge-bajo-stock">⚠️ Bajo Stock</span>' 
            : '<span class="badge-normal">✓ Normal</span>';
        
        // Ubicaciones
        let ubicacionesHtml = '';
        if (item.ubicaciones && item.ubicaciones.length > 0) {
            item.ubicaciones.forEach(ubi => {
                ubicacionesHtml += `<span class="ubicacion-tag">${ubi.almacen_nombre}: ${ubi.cantidad}</span>`;
            });
        } else {
            ubicacionesHtml = '---';
        }
        
        row.insertCell(0).innerHTML = item.id;
        row.insertCell(1).innerHTML = `<strong>${item.proyecto_codigo || ''}</strong><br><small>${item.proyecto_nombre || ''}</small>`;
        row.insertCell(2).innerHTML = item.articulo_codigo;
        row.insertCell(3).innerHTML = item.articulo_descripcion;
        row.insertCell(4).innerHTML = `${item.cantidad_actual} ${item.unidad_medida || ''}`;
        row.insertCell(5).innerHTML = `<strong>${item.disponible}</strong> ${item.unidad_medida || ''}`;
        row.insertCell(6).innerHTML = item.cantidad_minima || 0;
        row.insertCell(7).innerHTML = item.cantidad_maxima || 0;
        row.insertCell(8).innerHTML = item.punto_reorden || 0;
        row.insertCell(9).innerHTML = ubicacionesHtml;
        row.insertCell(10).innerHTML = stockStatus;
        row.insertCell(11).innerHTML = `<i class="fas fa-eye" onclick="verDetalle(${item.id})" style="color: var(--color-primary); cursor: pointer;"></i>`;
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
        cargarInventario();
    });
    
    document.getElementById('btnPrimera')?.addEventListener('click', () => { currentPage = 1; cargarInventario(); });
    document.getElementById('btnAnterior')?.addEventListener('click', () => { if (currentPage > 1) { currentPage--; cargarInventario(); } });
    document.getElementById('btnSiguiente')?.addEventListener('click', () => { currentPage++; cargarInventario(); });
    document.getElementById('btnUltima')?.addEventListener('click', () => { currentPage = totalPages; cargarInventario(); });
    document.getElementById('porPagina')?.addEventListener('change', (e) => { perPage = parseInt(e.target.value); currentPage = 1; cargarInventario(); });
    
    document.getElementById('btnExportar')?.addEventListener('click', () => {
        const proyectoId = document.getElementById('filtroProyecto')?.value || '';
        window.location.href = `/almacen/api/inventario-fisico/exportar?proyecto_id=${proyectoId}`;
    });
}

window.verDetalle = function(id) {
    fetch(`/almacen/api/inventario-fisico/${id}`)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                const item = response.data;
                let detalles = `╔════════════════════════════════════════════════════════════╗\n`;
                detalles += `║              DETALLE DE INVENTARIO #${id}                    ║\n`;
                detalles += `╠════════════════════════════════════════════════════════════╣\n`;
                detalles += `║ 📦 Artículo:    ${item.articulo_codigo}\n`;
                detalles += `║ 📝 Descripción: ${item.articulo_descripcion}\n`;
                detalles += `║ 🏗️ Proyecto:    ${item.proyecto_nombre}\n`;
                detalles += `║ 📊 Stock actual: ${item.cantidad_actual} ${item.unidad_medida}\n`;
                detalles += `║ ✅ Disponible:  ${item.disponible} ${item.unidad_medida}\n`;
                detalles += `║ 📉 Mínimo:      ${item.cantidad_minima} ${item.unidad_medida}\n`;
                detalles += `║ 📈 Máximo:      ${item.cantidad_maxima} ${item.unidad_medida}\n`;
                detalles += `║ 🔔 Punto reorden: ${item.punto_reorden} ${item.unidad_medida}\n`;
                detalles += `╠════════════════════════════════════════════════════════════╣\n`;
                detalles += `║ 📍 UBICACIONES POR ALMACÉN:\n`;
                item.ubicaciones.forEach(ubi => {
                    detalles += `║    🏪 ${ubi.almacen_nombre}: ${ubi.cantidad} ${item.unidad_medida}\n`;
                    if (ubi.ubicacion_especifica) detalles += `║       📍 Ubicación: ${ubi.ubicacion_especifica}\n`;
                    if (ubi.lote) detalles += `║       🏷️ Lote: ${ubi.lote}\n`;
                });
                if (item.observaciones) {
                    detalles += `╠════════════════════════════════════════════════════════════╣\n`;
                    detalles += `║ 💬 Observaciones: ${item.observaciones}\n`;
                }
                detalles += `╚════════════════════════════════════════════════════════════╝`;
                alert(detalles);
            }
        });
};
</script>
@endsection