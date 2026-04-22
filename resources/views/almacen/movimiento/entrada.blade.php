@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-exchange-alt"></i> Entradas y Salidas de Almacén
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Fecha Inicio</label>
                        <input type="date" id="fechaInicio" class="form-control" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-01') }}">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Fecha Fin</label>
                        <input type="date" id="fechaFin" class="form-control" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d') }}">
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
                    <div style="display: flex; align-items: flex-end;">
                        <button id="btnActualizar" style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; width: 100%;">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                    </div>
                </div>

                <!-- Pestañas -->
                <div style="display: flex; border-bottom: 2px solid #dee2e6; margin-bottom: 20px;">
                    <button class="tab-btn active" onclick="switchTab('entradas')" id="tabEntradas" style="background-color: var(--color-primary); color: white; border: none; padding: 10px 25px; border-radius: 8px 8px 0 0; margin-right: 5px; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-arrow-down" style="color: #28a745; margin-right: 5px;"></i> Entradas
                    </button>
                    <button class="tab-btn" onclick="switchTab('salidas')" id="tabSalidas" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; border-radius: 8px 8px 0 0; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-arrow-up" style="color: #dc3545; margin-right: 5px;"></i> Salidas
                    </button>
                </div>

                <!-- Panel Entradas -->
                <div id="panelEntradas" style="display: block;">
                    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 15px;">
                        <button id="btnAgregarEntrada" class="btn-agregar" onclick="abrirModalMovimiento('entrada')" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 15px; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-plus"></i> Nueva Entrada
                        </button>
                        <button id="btnExcelEntradas" class="btn-excel" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 15px; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-file-excel"></i> Exportar
                        </button>
                    </div>

                    <div class="table-container">
                        <table class="table" id="tablaEntradas">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Proyecto</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Almacén</th>
                                    <th>Referencia</th>
                                    <th>Observaciones</th>
                                    <th>Registrado por</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodyEntradas">
                                <tr><td colspan="10" style="text-align: center;">Cargando...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación Entradas -->
                    <div class="pagination-container" style="margin-top: 15px; display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                        <button class="page-btn" id="btnPrimeraEntrada" disabled><i class="fas fa-angle-double-left"></i></button>
                        <button class="page-btn" id="btnAnteriorEntrada" disabled><i class="fas fa-angle-left"></i></button>
                        <span>Página <span id="paginaActualEntrada">1</span> de <span id="totalPaginasEntrada">1</span></span>
                        <button class="page-btn" id="btnSiguienteEntrada" disabled><i class="fas fa-angle-right"></i></button>
                        <button class="page-btn" id="btnUltimaEntrada" disabled><i class="fas fa-angle-double-right"></i></button>
                        <select id="porPaginaEntrada" style="padding: 5px; border-radius: 4px;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>

                <!-- Panel Salidas -->
                <div id="panelSalidas" style="display: none;">
                    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 15px;">
                        <button id="btnAgregarSalida" class="btn-agregar" onclick="abrirModalMovimiento('salida')" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 15px; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-plus"></i> Nueva Salida
                        </button>
                        <button id="btnExcelSalidas" class="btn-excel" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 15px; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-file-excel"></i> Exportar
                        </button>
                    </div>

                    <div class="table-container">
                        <table class="table" id="tablaSalidas">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Proyecto</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Almacén</th>
                                    <th>Referencia</th>
                                    <th>Solicitante</th>
                                    <th>Observaciones</th>
                                    <th>Registrado por</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodySalidas">
                                <tr><td colspan="11" style="text-align: center;">Cargando...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación Salidas -->
                    <div class="pagination-container" style="margin-top: 15px; display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                        <button class="page-btn" id="btnPrimeraSalida" disabled><i class="fas fa-angle-double-left"></i></button>
                        <button class="page-btn" id="btnAnteriorSalida" disabled><i class="fas fa-angle-left"></i></button>
                        <span>Página <span id="paginaActualSalida">1</span> de <span id="totalPaginasSalida">1</span></span>
                        <button class="page-btn" id="btnSiguienteSalida" disabled><i class="fas fa-angle-right"></i></button>
                        <button class="page-btn" id="btnUltimaSalida" disabled><i class="fas fa-angle-double-right"></i></button>
                        <select id="porPaginaSalida" style="padding: 5px; border-radius: 4px;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA MOVIMIENTO (ENTRADA/SALIDA) -->
<div id="modalMovimiento" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 550px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;" id="modalTituloMovimiento">Nuevo Movimiento</h3>
            <button onclick="cerrarModalMovimiento()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;">
            <input type="hidden" id="movimientoTipo">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Proyecto <span style="color: red;">*</span></label>
                    <select id="modalProyecto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
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
                    <select id="modalArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar artículo</option>
                        @isset($articulos)
                            @foreach($articulos as $articulo)
                                <option value="{{ $articulo->id }}">{{ $articulo->codigo }} - {{ $articulo->descripcion }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Almacén <span style="color: red;">*</span></label>
                    <select id="modalAlmacen" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar almacén</option>
                        @isset($almacenes)
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}">{{ $almacen->codigo }} - {{ $almacen->nombre }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Cantidad <span style="color: red;">*</span></label>
                    <input type="number" step="0.001" id="modalCantidad" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Referencia</label>
                    <input type="text" id="modalReferencia" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Factura, orden, etc.">
                </div>
                <div id="divSolicitante" style="display: none; grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Solicitante</label>
                    <input type="text" id="modalSolicitante" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Nombre de quien solicita">
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Observaciones</label>
                    <textarea id="modalObservaciones" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones..."></textarea>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalMovimiento()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarMovimiento()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
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
    .btn-agregar:hover, .btn-excel:hover { background-color: var(--color-primary) !important; color: white !important; }
    @media (max-width: 768px) { div[style*="grid-template-columns: repeat(4, 1fr)"] { grid-template-columns: repeat(2, 1fr) !important; } }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
let movimientoTipo = 'entrada';
let currentPageEntrada = 1, currentPageSalida = 1;
let perPageEntrada = 10, perPageSalida = 10;

document.addEventListener('DOMContentLoaded', function() {
    cargarMovimientos('entrada');
    cargarMovimientos('salida');
    configurarEventos();
});

function cargarMovimientos(tipo) {
    const fechaInicio = document.getElementById('fechaInicio')?.value || '';
    const fechaFin = document.getElementById('fechaFin')?.value || '';
    const proyectoId = document.getElementById('filtroProyecto')?.value || '';
    const currentPage = tipo === 'entrada' ? currentPageEntrada : currentPageSalida;
    const perPage = tipo === 'entrada' ? perPageEntrada : perPageSalida;
    
    let url = `/inventario/api/movimientos?tipo=${tipo === 'entrada' ? 'Entrada' : 'Salida'}&page=${currentPage}&per_page=${perPage}`;
    if (fechaInicio) url += `&fecha_inicio=${fechaInicio}`;
    if (fechaFin) url += `&fecha_fin=${fechaFin}`;
    if (proyectoId) url += `&proyecto_id=${proyectoId}`;
    
    fetch(url)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                renderizarTabla(tipo, response.data);
                actualizarPaginacion(tipo, response.current_page, response.last_page, response.total);
            }
        })
        .catch(error => console.error('Error:', error));
}

function renderizarTabla(tipo, data) {
    const tbody = document.getElementById(`tablaBody${tipo === 'entrada' ? 'Entradas' : 'Salidas'}`);
    if (!data.length) {
        tbody.innerHTML = `<tr><td colspan="${tipo === 'entrada' ? '10' : '11'}" style="text-align: center;">No hay movimientos registrados</td></tr>`;
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
        row.insertCell(5).innerHTML = item.almacen_nombre || '---';
        row.insertCell(6).innerHTML = item.referencia_folio || '---';
        
        if (tipo === 'salida') {
            row.insertCell(7).innerHTML = item.solicitante || '---';
            row.insertCell(8).innerHTML = item.observaciones || '---';
            row.insertCell(9).innerHTML = item.creado_por || '---';
            row.insertCell(10).innerHTML = `<i class="fas fa-eye" onclick="verDetalle(${item.id})" style="color: var(--color-primary); cursor: pointer;"></i>`;
        } else {
            row.insertCell(7).innerHTML = item.observaciones || '---';
            row.insertCell(8).innerHTML = item.creado_por || '---';
            row.insertCell(9).innerHTML = `<i class="fas fa-eye" onclick="verDetalle(${item.id})" style="color: var(--color-primary); cursor: pointer;"></i>`;
        }
    });
}

function actualizarPaginacion(tipo, currentPage, lastPage, total) {
    const prefix = tipo === 'entrada' ? 'Entrada' : 'Salida';
    document.getElementById(`paginaActual${prefix}`).textContent = currentPage;
    document.getElementById(`totalPaginas${prefix}`).textContent = lastPage;
    document.getElementById(`btnPrimera${prefix}`).disabled = currentPage === 1;
    document.getElementById(`btnAnterior${prefix}`).disabled = currentPage === 1;
    document.getElementById(`btnSiguiente${prefix}`).disabled = currentPage === lastPage;
    document.getElementById(`btnUltima${prefix}`).disabled = currentPage === lastPage;
}

function configurarEventos() {
    document.getElementById('btnActualizar')?.addEventListener('click', () => {
        cargarMovimientos('entrada');
        cargarMovimientos('salida');
    });
    
    // Eventos de paginación Entradas
    document.getElementById('btnPrimeraEntrada')?.addEventListener('click', () => { currentPageEntrada = 1; cargarMovimientos('entrada'); });
    document.getElementById('btnAnteriorEntrada')?.addEventListener('click', () => { if (currentPageEntrada > 1) { currentPageEntrada--; cargarMovimientos('entrada'); } });
    document.getElementById('btnSiguienteEntrada')?.addEventListener('click', () => { currentPageEntrada++; cargarMovimientos('entrada'); });
    document.getElementById('btnUltimaEntrada')?.addEventListener('click', () => { currentPageEntrada = 999; cargarMovimientos('entrada'); });
    document.getElementById('porPaginaEntrada')?.addEventListener('change', (e) => { perPageEntrada = parseInt(e.target.value); currentPageEntrada = 1; cargarMovimientos('entrada'); });
    
    // Eventos de paginación Salidas
    document.getElementById('btnPrimeraSalida')?.addEventListener('click', () => { currentPageSalida = 1; cargarMovimientos('salida'); });
    document.getElementById('btnAnteriorSalida')?.addEventListener('click', () => { if (currentPageSalida > 1) { currentPageSalida--; cargarMovimientos('salida'); } });
    document.getElementById('btnSiguienteSalida')?.addEventListener('click', () => { currentPageSalida++; cargarMovimientos('salida'); });
    document.getElementById('btnUltimaSalida')?.addEventListener('click', () => { currentPageSalida = 999; cargarMovimientos('salida'); });
    document.getElementById('porPaginaSalida')?.addEventListener('change', (e) => { perPageSalida = parseInt(e.target.value); currentPageSalida = 1; cargarMovimientos('salida'); });
    
    document.getElementById('btnExcelEntradas')?.addEventListener('click', () => window.location.href = '/inventario/api/movimientos/exportar?tipo=Entrada');
    document.getElementById('btnExcelSalidas')?.addEventListener('click', () => window.location.href = '/inventario/api/movimientos/exportar?tipo=Salida');
}

window.switchTab = function(tab) {
    const panelEntradas = document.getElementById('panelEntradas');
    const panelSalidas = document.getElementById('panelSalidas');
    const tabEntradas = document.getElementById('tabEntradas');
    const tabSalidas = document.getElementById('tabSalidas');
    
    if (tab === 'entradas') {
        panelEntradas.style.display = 'block';
        panelSalidas.style.display = 'none';
        tabEntradas.style.backgroundColor = 'var(--color-primary)';
        tabEntradas.style.color = 'white';
        tabSalidas.style.backgroundColor = '#e9ecef';
        tabSalidas.style.color = '#495057';
    } else {
        panelEntradas.style.display = 'none';
        panelSalidas.style.display = 'block';
        tabSalidas.style.backgroundColor = 'var(--color-primary)';
        tabSalidas.style.color = 'white';
        tabEntradas.style.backgroundColor = '#e9ecef';
        tabEntradas.style.color = '#495057';
    }
};

window.abrirModalMovimiento = function(tipo) {
    movimientoTipo = tipo;
    document.getElementById('modalTituloMovimiento').textContent = tipo === 'entrada' ? '📥 Nueva Entrada de Material' : '📤 Nueva Salida de Material';
    document.getElementById('movimientoTipo').value = tipo;
    document.getElementById('divSolicitante').style.display = tipo === 'salida' ? 'block' : 'none';
    document.getElementById('modalProyecto').value = '';
    document.getElementById('modalFecha').value = new Date().toISOString().split('T')[0];
    document.getElementById('modalArticulo').value = '';
    document.getElementById('modalAlmacen').value = '';
    document.getElementById('modalCantidad').value = '';
    document.getElementById('modalReferencia').value = '';
    document.getElementById('modalSolicitante').value = '';
    document.getElementById('modalObservaciones').value = '';
    document.getElementById('modalMovimiento').style.display = 'flex';
    document.body.style.overflow = 'hidden';
};

window.guardarMovimiento = async function() {
    const proyectoId = document.getElementById('modalProyecto').value;
    const articuloId = document.getElementById('modalArticulo').value;
    const almacenId = document.getElementById('modalAlmacen').value;
    const cantidad = document.getElementById('modalCantidad').value;
    
    if (!proyectoId || !articuloId || !almacenId || !cantidad || cantidad <= 0) {
        alert('⚠️ Por favor complete todos los campos obligatorios');
        return;
    }
    
    // Verificar stock si es una salida
    if (movimientoTipo === 'salida') {
        try {
            const response = await fetch(`/inventario/api/movimientos/verificar-stock?proyecto_id=${proyectoId}&articulo_id=${articuloId}&almacen_id=${almacenId}&cantidad=${cantidad}`);
            const data = await response.json();
            
            if (!data.success) {
                alert(data.message);
                return;
            }
            
            if (!data.data.stock_suficiente) {
                alert(`⚠️ Stock insuficiente\n\nDisponible: ${data.data.disponible} ${data.data.unidad_medida}\nSolicitado: ${cantidad}`);
                return;
            }
        } catch (error) {
            console.error('Error al verificar stock:', error);
            alert('❌ Error al verificar stock. Intente de nuevo.');
            return;
        }
    }
    
    const data = {
        proyecto_id: proyectoId,
        articulo_id: articuloId,
        almacen_id: almacenId,
        cantidad: parseFloat(cantidad),
        fecha_movimiento: document.getElementById('modalFecha').value,
        referencia_folio: document.getElementById('modalReferencia').value,
        observaciones: document.getElementById('modalObservaciones').value
    };
    
    if (movimientoTipo === 'salida') {
        data.solicitante = document.getElementById('modalSolicitante').value || '';
    }
    
    const url = movimientoTipo === 'entrada' 
        ? '/inventario/api/movimientos/entrada' 
        : '/inventario/api/movimientos/salida';
    
    fetch(url, {
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
            cerrarModalMovimiento();
            cargarMovimientos('entrada');
            cargarMovimientos('salida');
        } else {
            alert('❌ Error: ' + response.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error al guardar el movimiento');
    });
};

window.cerrarModalMovimiento = function() {
    document.getElementById('modalMovimiento').style.display = 'none';
    document.body.style.overflow = 'auto';
};

window.verDetalle = async function(id) {
    if (!id) {
        alert('ID de movimiento no válido');
        return;
    }
    
    // Mostrar loading
    const loadingDiv = document.createElement('div');
    loadingDiv.id = 'loadingDetalle';
    loadingDiv.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999999; display: flex; align-items: center; justify-content: center;';
    loadingDiv.innerHTML = '<div style="background: white; padding: 20px; border-radius: 8px;"><i class="fas fa-spinner fa-spin"></i> Cargando detalles...</div>';
    document.body.appendChild(loadingDiv);
    
    try {
        const response = await fetch(`/inventario/api/movimientos/${id}`);
        const data = await response.json();
        
        loadingDiv.remove();
        
        if (data.success && data.data) {
            const m = data.data;
            let detalles = `╔════════════════════════════════════════════════════════════╗\n`;
            detalles += `║                    MOVIMIENTO #${m.id}                      ║\n`;
            detalles += `╠════════════════════════════════════════════════════════════╣\n`;
            detalles += `║ 📅 Fecha:        ${m.fecha_movimiento}\n`;
            detalles += `║ 📌 Tipo:         ${m.tipo_movimiento}\n`;
            detalles += `║ 🏗️ Proyecto:     ${m.proyecto_nombre || 'N/A'}\n`;
            detalles += `║ 📦 Artículo:     ${m.articulo_codigo} - ${m.articulo_descripcion}\n`;
            detalles += `║ 🔢 Cantidad:     ${m.cantidad}\n`;
            detalles += `║ 🏪 Almacén:      ${m.almacen_nombre || 'N/A'}\n`;
            detalles += `║ 📄 Referencia:   ${m.referencia_folio || 'N/A'}\n`;
            detalles += `║ 👤 Solicitante:  ${m.solicitante || 'N/A'}\n`;
            detalles += `║ 💬 Observaciones: ${m.observaciones || 'N/A'}\n`;
            detalles += `║ 👨‍💼 Registrado:   ${m.creado_por || 'N/A'}\n`;
            detalles += `╠════════════════════════════════════════════════════════════╣\n`;
            detalles += `║ 📊 Stock antes:  ${m.cantidad_antes}\n`;
            detalles += `║ 📊 Stock después: ${m.cantidad_despues}\n`;
            detalles += `╚════════════════════════════════════════════════════════════╝`;
            alert(detalles);
        } else {
            alert('❌ No se encontró el movimiento');
        }
    } catch (error) {
        loadingDiv.remove();
        console.error('Error:', error);
        alert('❌ Error al conectar con el servidor');
    }
};

document.addEventListener('keydown', (e) => { if (e.key === 'Escape') cerrarModalMovimiento(); });
document.getElementById('modalMovimiento')?.addEventListener('click', (e) => { if (e.target === this) cerrarModalMovimiento(); });
</script>
@endsection