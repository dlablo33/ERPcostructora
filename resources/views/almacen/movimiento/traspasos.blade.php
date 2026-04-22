@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-exchange-alt"></i> Traspasos entre Almacenes
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Fecha Inicio</label>
                        <input type="date" id="fechaInicio" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-01') }}">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Fecha Fin</label>
                        <input type="date" id="fechaFin" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d') }}">
                    </div>
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
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap;">
                    <div>
                        <button id="btnActualizar" style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 20px; cursor: pointer;">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button id="btnNuevoTraspaso" onclick="abrirModalTraspaso()" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 20px; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-plus"></i> Nuevo Traspaso
                        </button>
                        <button id="btnExportar" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 20px; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-file-excel"></i> Exportar
                        </button>
                    </div>
                </div>

                <!-- Tabla de Traspasos -->
                <div class="table-container">
                    <table class="table" id="tablaTraspasos">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Proyecto</th>
                                <th>Artículo</th>
                                <th>Cantidad</th>
                                <th>Almacén Origen</th>
                                <th>Almacén Destino</th>
                                <th>Estatus</th>
                                <th>Observaciones</th>
                                <th>Registrado por</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="11" style="text-align: center;">Cargando...</td></tr>
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

<!-- MODAL TRASPASO -->
<div id="modalTraspaso" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 550px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;">Nuevo Traspaso entre Almacenes</h3>
            <button onclick="cerrarModalTraspaso()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Proyecto <span style="color: red;">*</span></label>
                    <select id="modalProyecto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" onchange="consultarStockDisponible()">
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
                    <input type="date" id="modalFecha" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Artículo <span style="color: red;">*</span></label>
                    <select id="modalArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" onchange="consultarStockDisponible()">
                        <option value="">Seleccionar artículo</option>
                        @isset($articulos)
                            @foreach($articulos as $articulo)
                                <option value="{{ $articulo->id }}">{{ $articulo->codigo }} - {{ $articulo->descripcion }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Almacén Origen <span style="color: red;">*</span></label>
                    <select id="modalOrigen" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" onchange="consultarStockDisponible()">
                        <option value="">Seleccionar almacén origen</option>
                        @isset($almacenes)
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}">{{ $almacen->codigo }} - {{ $almacen->nombre }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Almacén Destino <span style="color: red;">*</span></label>
                    <select id="modalDestino" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar almacén destino</option>
                        @isset($almacenes)
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}">{{ $almacen->codigo }} - {{ $almacen->nombre }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Cantidad <span style="color: red;">*</span></label>
                    <input type="number" step="0.001" id="modalCantidad" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00" onkeyup="validarCantidad()" onchange="validarCantidad()">
                    <div id="stockInfo" style="font-size: 11px; margin-top: 5px; color: #6c757d;"></div>
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Observaciones</label>
                    <textarea id="modalObservaciones" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones..."></textarea>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalTraspaso()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarTraspaso()" id="btnGuardarTraspaso" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
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
    .page-btn { padding: 5px 12px; border: 1px solid var(--color-primary); border-radius: 4px; background: white; cursor: pointer; color: var(--color-primary); }
    .page-btn:disabled { opacity: 0.5; cursor: not-allowed; }
    .badge-transferencia { background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 12px; font-size: 10px; display: inline-block; }
    .stock-suficiente { color: #28a745; }
    .stock-insuficiente { color: #dc3545; }
    @media (max-width: 768px) { div[style*="grid-template-columns: repeat(4, 1fr)"] { grid-template-columns: repeat(2, 1fr) !important; } }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
let currentPage = 1;
let perPage = 10;
let totalPages = 1;
let stockDisponibleActual = 0;
let unidadMedidaActual = '';

document.addEventListener('DOMContentLoaded', function() {
    cargarTraspasos();
    configurarEventos();
});

function cargarTraspasos() {
    const fechaInicio = document.getElementById('fechaInicio')?.value || '';
    const fechaFin = document.getElementById('fechaFin')?.value || '';
    const proyectoId = document.getElementById('filtroProyecto')?.value || '';
    const articuloId = document.getElementById('filtroArticulo')?.value || '';
    
    let url = `/inventario/api/movimientos?tipo=Transferencia&page=${currentPage}&per_page=${perPage}`;
    if (fechaInicio) url += `&fecha_inicio=${fechaInicio}`;
    if (fechaFin) url += `&fecha_fin=${fechaFin}`;
    if (proyectoId) url += `&proyecto_id=${proyectoId}`;
    if (articuloId) url += `&articulo_id=${articuloId}`;
    
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
        tbody.innerHTML = '<tr><td colspan="11" style="text-align: center;">No hay traspasos registrados</td></tr>';
        return;
    }
    
    tbody.innerHTML = '';
    data.forEach((item, index) => {
        const row = tbody.insertRow();
        row.style.backgroundColor = index % 2 === 1 ? '#f8f9fa' : 'white';
        
        row.insertCell(0).innerHTML = item.id;
        row.insertCell(1).innerHTML = item.fecha_movimiento;
        row.insertCell(2).innerHTML = item.proyecto_nombre || '---';
        row.insertCell(3).innerHTML = `${item.articulo_codigo}<br><small>${item.articulo_descripcion || ''}</small>`;
        row.insertCell(4).innerHTML = `${item.cantidad} ${item.unidad_medida || ''}`;
        row.insertCell(5).innerHTML = item.almacen_origen_nombre || '---';
        row.insertCell(6).innerHTML = item.almacen_destino_nombre || '---';
        row.insertCell(7).innerHTML = '<span class="badge-transferencia">Transferencia</span>';
        row.insertCell(8).innerHTML = item.observaciones || '---';
        row.insertCell(9).innerHTML = item.creado_por || '---';
        row.insertCell(10).innerHTML = `<i class="fas fa-eye" onclick="verDetalle(${item.id})" style="color: var(--color-primary); cursor: pointer;" title="Ver detalle"></i>`;
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
        cargarTraspasos();
    });
    
    document.getElementById('btnPrimera')?.addEventListener('click', () => { currentPage = 1; cargarTraspasos(); });
    document.getElementById('btnAnterior')?.addEventListener('click', () => { if (currentPage > 1) { currentPage--; cargarTraspasos(); } });
    document.getElementById('btnSiguiente')?.addEventListener('click', () => { currentPage++; cargarTraspasos(); });
    document.getElementById('btnUltima')?.addEventListener('click', () => { currentPage = totalPages; cargarTraspasos(); });
    document.getElementById('porPagina')?.addEventListener('change', (e) => { perPage = parseInt(e.target.value); currentPage = 1; cargarTraspasos(); });
    
    document.getElementById('btnExportar')?.addEventListener('click', () => {
        const fechaInicio = document.getElementById('fechaInicio').value;
        const fechaFin = document.getElementById('fechaFin').value;
        let url = '/inventario/api/movimientos/exportar?tipo=Transferencia';
        if (fechaInicio) url += `&fecha_inicio=${fechaInicio}`;
        if (fechaFin) url += `&fecha_fin=${fechaFin}`;
        window.location.href = url;
    });
}

async function consultarStockDisponible() {
    const proyectoId = document.getElementById('modalProyecto').value;
    const articuloId = document.getElementById('modalArticulo').value;
    const almacenOrigenId = document.getElementById('modalOrigen').value;
    
    const stockInfoDiv = document.getElementById('stockInfo');
    const cantidadInput = document.getElementById('modalCantidad');
    
    if (!proyectoId || !articuloId || !almacenOrigenId) {
        stockInfoDiv.innerHTML = '';
        stockInfoDiv.className = '';
        stockDisponibleActual = 0;
        return;
    }
    
    stockInfoDiv.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Consultando stock...';
    
    try {
        // Usar la ruta que SÍ existe: /inventario/api/movimientos/saldo
        const url = `/inventario/api/movimientos/saldo?proyecto_id=${proyectoId}&articulo_id=${articuloId}`;
        console.log('Consultando URL:', url);
        
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        console.log('Respuesta:', data);
        
        if (data.success && data.data) {
            // Buscar la cantidad en el almacén específico
            const ubicacion = data.data.ubicaciones ? data.data.ubicaciones.find(u => u.almacen_id == almacenOrigenId) : null;
            stockDisponibleActual = ubicacion ? parseFloat(ubicacion.cantidad) : 0;
            unidadMedidaActual = data.data.unidad_medida || 'Pieza';
            
            const cantidad = parseFloat(cantidadInput.value) || 0;
            
            if (stockDisponibleActual > 0) {
                stockInfoDiv.innerHTML = `
                    <i class="fas fa-boxes"></i> Stock disponible: <strong>${stockDisponibleActual.toFixed(3)} ${unidadMedidaActual}</strong>
                    ${cantidad > 0 ? `<br><i class="fas fa-arrow-right"></i> ${cantidad > stockDisponibleActual ? '⚠️ Excede el stock disponible' : '✓ Cantidad válida'}` : ''}
                `;
                cantidadInput.max = stockDisponibleActual;
                cantidadInput.title = `Máximo: ${stockDisponibleActual} ${unidadMedidaActual}`;
            } else {
                stockInfoDiv.innerHTML = '<span style="color: #ffc107;"><i class="fas fa-exclamation-triangle"></i> No hay stock disponible en este almacén</span>';
                cantidadInput.max = '';
                cantidadInput.title = 'No hay stock disponible';
            }
            
            if (cantidad > 0 && cantidad > stockDisponibleActual && stockDisponibleActual > 0) {
                stockInfoDiv.classList.add('stock-insuficiente');
                stockInfoDiv.classList.remove('stock-suficiente');
            } else if (cantidad > 0 && stockDisponibleActual > 0) {
                stockInfoDiv.classList.add('stock-suficiente');
                stockInfoDiv.classList.remove('stock-insuficiente');
            } else {
                stockInfoDiv.classList.remove('stock-suficiente', 'stock-insuficiente');
            }
        } else {
            stockDisponibleActual = 0;
            stockInfoDiv.innerHTML = '<span style="color: #dc3545;"><i class="fas fa-times-circle"></i> No se encontró stock para este artículo</span>';
        }
    } catch (error) {
        console.error('Error:', error);
        stockDisponibleActual = 0;
        stockInfoDiv.innerHTML = '<span style="color: #dc3545;"><i class="fas fa-times-circle"></i> Error de conexión al consultar stock</span>';
    }
}

function validarCantidad() {
    const cantidadInput = document.getElementById('modalCantidad');
    const cantidad = parseFloat(cantidadInput.value) || 0;
    const btnGuardar = document.getElementById('btnGuardarTraspaso');
    
    if (cantidad <= 0) {
        btnGuardar.disabled = false;
        btnGuardar.style.opacity = '1';
        return;
    }
    
    if (stockDisponibleActual === 0) {
        btnGuardar.disabled = true;
        btnGuardar.style.opacity = '0.5';
        btnGuardar.title = 'No hay stock disponible';
        return;
    }
    
    if (cantidad > stockDisponibleActual) {
        btnGuardar.disabled = true;
        btnGuardar.style.opacity = '0.5';
        btnGuardar.title = 'Stock insuficiente';
    } else {
        btnGuardar.disabled = false;
        btnGuardar.style.opacity = '1';
        btnGuardar.title = '';
    }
}

function abrirModalTraspaso() {
    document.getElementById('modalProyecto').value = '';
    document.getElementById('modalFecha').value = new Date().toISOString().split('T')[0];
    document.getElementById('modalArticulo').value = '';
    document.getElementById('modalCantidad').value = '';
    document.getElementById('modalOrigen').value = '';
    document.getElementById('modalDestino').value = '';
    document.getElementById('modalObservaciones').value = '';
    document.getElementById('stockInfo').innerHTML = '';
    document.getElementById('stockInfo').className = '';
    stockDisponibleActual = 0;
    unidadMedidaActual = '';
    
    const btnGuardar = document.getElementById('btnGuardarTraspaso');
    btnGuardar.disabled = false;
    btnGuardar.style.opacity = '1';
    
    document.getElementById('modalTraspaso').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalTraspaso() {
    document.getElementById('modalTraspaso').style.display = 'none';
    document.body.style.overflow = 'auto';
}

async function guardarTraspaso() {
    const proyectoId = document.getElementById('modalProyecto').value;
    const articuloId = document.getElementById('modalArticulo').value;
    const origenId = document.getElementById('modalOrigen').value;
    const destinoId = document.getElementById('modalDestino').value;
    const cantidad = parseFloat(document.getElementById('modalCantidad').value);
    const fecha = document.getElementById('modalFecha').value;
    const observaciones = document.getElementById('modalObservaciones').value;
    
    if (!proyectoId) {
        alert('❌ Seleccione un proyecto');
        return;
    }
    if (!articuloId) {
        alert('❌ Seleccione un artículo');
        return;
    }
    if (!origenId) {
        alert('❌ Seleccione el almacén de origen');
        return;
    }
    if (!destinoId) {
        alert('❌ Seleccione el almacén de destino');
        return;
    }
    if (origenId === destinoId) {
        alert('❌ Los almacenes deben ser diferentes');
        return;
    }
    if (!cantidad || cantidad <= 0) {
        alert('❌ Ingrese una cantidad válida');
        return;
    }
    if (stockDisponibleActual > 0 && cantidad > stockDisponibleActual) {
        alert(`❌ Stock insuficiente.\n\nDisponible: ${stockDisponibleActual.toFixed(3)} ${unidadMedidaActual}\nSolicitado: ${cantidad}`);
        return;
    }
    
    const data = {
        proyecto_id: parseInt(proyectoId),
        articulo_id: parseInt(articuloId),
        almacen_origen_id: parseInt(origenId),
        almacen_destino_id: parseInt(destinoId),
        cantidad: cantidad,
        fecha_movimiento: fecha,
        observaciones: observaciones
    };
    
    const btnGuardar = document.getElementById('btnGuardarTraspaso');
    const textoOriginal = btnGuardar.innerHTML;
    btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
    btnGuardar.disabled = true;
    
    try {
        const response = await fetch('/inventario/api/movimientos/transferencia', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('✅ ' + result.message);
            cerrarModalTraspaso();
            cargarTraspasos();
        } else {
            alert('❌ Error: ' + (result.message || 'No se pudo realizar el traspaso'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Error de conexión: ' + error.message);
    } finally {
        btnGuardar.innerHTML = textoOriginal;
        btnGuardar.disabled = false;
    }
}

function verDetalle(id) {
    fetch(`/inventario/api/movimientos/${id}`)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                const m = response.data;
                let detalles = `╔════════════════════════════════════════════════════════════╗\n`;
                detalles += `║                   TRASPASO #${m.id}                         ║\n`;
                detalles += `╠════════════════════════════════════════════════════════════╣\n`;
                detalles += `║ 📅 Fecha:        ${m.fecha_movimiento}\n`;
                detalles += `║ 🏗️ Proyecto:     ${m.proyecto_nombre || 'N/A'}\n`;
                detalles += `║ 📦 Artículo:     ${m.articulo_codigo} - ${m.articulo_descripcion}\n`;
                detalles += `║ 🔢 Cantidad:     ${m.cantidad} ${m.unidad_medida || ''}\n`;
                detalles += `║ 📍 Origen:       ${m.almacen_origen_nombre || 'N/A'}\n`;
                detalles += `║ 📍 Destino:      ${m.almacen_destino_nombre || 'N/A'}\n`;
                detalles += `║ 💬 Observaciones: ${m.observaciones || 'N/A'}\n`;
                detalles += `║ 👨‍💼 Registrado:   ${m.creado_por || 'N/A'}\n`;
                detalles += `╚════════════════════════════════════════════════════════════╝`;
                alert(detalles);
            } else {
                alert('❌ No se encontró el traspaso');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Error al cargar los detalles');
        });
}

document.addEventListener('keydown', (e) => { if (e.key === 'Escape') cerrarModalTraspaso(); });
document.getElementById('modalTraspaso')?.addEventListener('click', (e) => { if (e.target === document.getElementById('modalTraspaso')) cerrarModalTraspaso(); });
</script>
@endsection