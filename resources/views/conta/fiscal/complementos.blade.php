@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Complementos de Pago -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Complementos de Pago
                </h2>
            </div>

            <div class="card-body p-4">
                @php
                    $fechaInicioDefault = $fechaInicio ?? date('Y-m-01');
                    $fechaFinDefault = $fechaFin ?? date('Y-m-t');
                @endphp

                <!-- 4 CUADROS DE COMPLEMENTOS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Total Complementos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalComplementos">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Por Timbrar</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="porTimbrar">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Timbrados</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="timbrados">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Monto Total</div>
                            <div style="color: #000000; font-size: 28px; font-weight: bold;" id="montoTotal">$0</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <input type="date" id="fechaInicio" value="{{ $fechaInicioDefault }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>
                        <div>
                            <input type="date" id="fechaFin" value="{{ $fechaFinDefault }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>
                        <div>
                            <select id="filtroEstatus" style="padding: 6px 10px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 130px; background-color: white;">
                                <option value="">Todos</option>
                                <option value="Pendiente">Por Timbrar</option>
                                <option value="Timbrado">Timbrados</option>
                                <option value="Cancelado">Cancelados</option>
                            </select>
                        </div>
                        <div>
                            <button id="btnAplicarFiltros" style="background-color: #083CAE; border: none; border-radius: 4px; padding: 6px 16px; color: white; cursor: pointer;">
                                <i class="fas fa-search"></i> Aplicar
                            </button>
                        </div>
                        <div>
                            <a href="{{ route('conta.complementos') }}" style="background-color: #6c757d; border: none; border-radius: 4px; padding: 6px 16px; color: white; text-decoration: none; display: inline-block;">
                                <i class="fas fa-undo"></i> Limpiar
                            </a>
                        </div>
                        <div>
                            <button id="btnNuevo" style="background-color: #2CBF1F; border: none; border-radius: 4px; padding: 8px 16px; color: white; cursor: pointer;">
                                <i class="fas fa-plus"></i> Nuevo
                            </button>
                        </div>
                        <div>
                            <a href="{{ route('conta.complementos.exportar', request()->all()) }}" id="btnExcel" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; color: #083CAE; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fas fa-file-excel"></i> Excel
                            </a>
                        </div>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto;">
                    <table class="table table-bordered" style="width: 100%; font-size: 12px; margin-bottom: 0;">
                        <thead style="position: sticky; top: 0; background-color: #2378e1;">
                            <tr>
                                <th draggable="true" data-columna="folio" style="background:#2378e1;color:white;">Folio</th>
                                <th draggable="true" data-columna="cliente" style="background:#2378e1;color:white;">Cliente/Proveedor</th>
                                <th draggable="true" data-columna="rfc" style="background:#2378e1;color:white;">RFC</th>
                                <th draggable="true" data-columna="fecha_pago" style="background:#2378e1;color:white;">Fecha Pago</th>
                                <th draggable="true" data-columna="documento_relacionado" style="background:#2378e1;color:white;">Documento Relacionado</th>
                                <th draggable="true" data-columna="forma_pago" style="background:#2378e1;color:white;">Forma Pago</th>
                                <th draggable="true" data-columna="monto" style="background:#2378e1;color:white;text-align:right;">Monto</th>
                                <th draggable="true" data-columna="estatus" style="background:#2378e1;color:white;">Estado</th>
                                <th draggable="true" data-columna="uuid" style="background:#2378e1;color:white;">UUID</th>
                                <th style="background:#2378e1;color:white;position:sticky;right:0;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="10" style="text-align: center; padding: 40px;">Cargando datos...</td</tr>
                        </tbody>
                        <tfoot style="position: sticky; bottom: 0; background-color: #e9ecef;">
                            <tr>
                                <td colspan="6" style="text-align:right; font-weight:600;">Total filtrado:</td>
                                <td id="sumMonto" style="text-align:right; font-weight:600;">$0.00</td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <button id="btnCrearFiltro" style="background: transparent; border: none; color: #2378e1; cursor: pointer;">
                        <i class="fas fa-filter"></i> Crear filtro
                    </button>
                    <div style="display: flex; gap: 5px; align-items: center;">
                        <button id="btnPrimera" style="border: none; background: none; color: #2378e1; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
                        <button id="btnAnterior" style="border: none; background: none; color: #2378e1; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
                        <span id="paginaActual" style="padding: 5px 10px; background-color: #2378e1; color: white; border-radius: 4px;">1</span>
                        <button id="btnSiguiente" style="border: none; background: none; color: #2378e1; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
                        <button id="btnUltima" style="border: none; background: none; color: #2378e1; cursor: pointer;"><i class="fas fa-angle-double-right"></i></button>
                        <span id="paginacionInfo" style="color: #2378e1; margin-left: 10px;">Mostrando 0 registros</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para nuevo complemento -->
<div class="modal" id="nuevoModal" style="display: none;">
    <div class="modal-dialog" style="max-width: 500px;">
        <div class="modal-content">
            <div class="modal-header" style="background: #083CAE;">
                <h5 style="color: white; margin: 0;"><i class="fas fa-plus-circle"></i> Nuevo Complemento de Pago</h5>
                <button type="button" class="close" onclick="cerrarModal()" style="color: white;">&times;</button>
            </div>
            <div class="modal-body">
                <form id="nuevoForm">
                    <div class="form-group">
                        <label>Cliente/Proveedor <span style="color:red;">*</span></label>
                        <select id="fCliente" class="form-control" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                            <option value="">Seleccione un cliente...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha Pago <span style="color:red;">*</span></label>
                        <input type="date" id="fFecha" class="form-control" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label>Monto <span style="color:red;">*</span></label>
                        <input type="number" id="fMonto" class="form-control" step="0.01" placeholder="0.00" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                    </div>
                    <div class="form-group">
                        <label>Documento Relacionado (Factura)</label>
                        <input type="text" id="fDocumento" class="form-control" placeholder="FAC-001-2026" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                    </div>
                    <div class="form-group">
                        <label>Forma de Pago</label>
                        <select id="fFormaPago" class="form-control" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                            <option value="Transferencia">Transferencia</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="padding: 15px; text-align: right; border-top: 1px solid #dee2e6;">
                <button type="button" class="btn-cancelar" onclick="cerrarModal()" style="background:#6c757d; color:white; border:none; padding:8px 16px; border-radius:4px;">Cancelar</button>
                <button type="button" class="btn-guardar" onclick="guardarComplemento()" style="background:#083CAE; color:white; border:none; padding:8px 16px; border-radius:4px;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .semaforo .card-header { background-color: #f4f6f9; border-bottom: 2px solid #083CAE; }
    .semaforo .card-header h2 { color: #083CAE !important; }
    .custom-card { transition: transform 0.2s; }
    .custom-card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(8,60,174,0.15); }
    .badge { padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; }
    .badge-pendiente { background: #fd7e14; color: white; }
    .badge-timbrado { background: #28a745; color: white; }
    .badge-cancelado { background: #dc3545; color: white; }
    .table td { white-space: nowrap; padding: 8px 4px; }
    .table th { white-space: nowrap; padding: 10px 4px; }
    .modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; align-items: center; justify-content: center; }
    .modal-dialog { width: 100%; max-width: 500px; margin: 20px; }
    .modal-content { background: white; border-radius: 10px; overflow: hidden; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; }
    .form-control:focus { outline: none; border-color: #083CAE; box-shadow: 0 0 0 2px rgba(8,60,174,0.2); }
    [draggable="true"] { cursor: grab; }
    [draggable="true"]:active { cursor: grabbing; }
    .columna-agrupada { display: inline-flex; align-items: center; padding: 4px 10px; background: #f0f4ff; border-radius: 16px; color: #2378e1; font-size: 12px; margin: 2px; border: 1px solid #2378e1; }
    .columna-agrupada .remover { margin-left: 6px; cursor: pointer; font-weight: bold; }
    .fila-grupo { background: #f0f7ff; cursor: pointer; }
    .fila-grupo:hover { background: #e1f0ff; }
    .fila-detalle td:first-child { padding-left: 30px; }
    .drag-over #grupoColumnas { background: rgba(35,120,225,0.1); border-radius: 4px; }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
// API URLs
const API_URL = '/api/complementos-pago';
const API_CLIENTES = '/api/complementos-pago/clientes';

// Variables globales
let complementosData = [];
let currentPage = 1;
let perPage = 10;
let totalPages = 1;
let sortKey = 'fecha_pago';
let sortDir = 'desc';
let columnasAgrupadas = [];
let expandedGroups = new Set();
let searchTimeout;

// Elementos DOM
const tablaBody = document.getElementById('tablaBody');
const btnAnterior = document.getElementById('btnAnterior');
const btnSiguiente = document.getElementById('btnSiguiente');
const btnPrimera = document.getElementById('btnPrimera');
const btnUltima = document.getElementById('btnUltima');
const paginaActualSpan = document.getElementById('paginaActual');
const paginacionInfo = document.getElementById('paginacionInfo');
const sumMonto = document.getElementById('sumMonto');
const buscador = document.getElementById('buscador');
const btnAplicarFiltros = document.getElementById('btnAplicarFiltros');
const btnNuevo = document.getElementById('btnNuevo');
const fechaInicio = document.getElementById('fechaInicio');
const fechaFin = document.getElementById('fechaFin');
const filtroEstatus = document.getElementById('filtroEstatus');
const grupoAgrupacion = document.getElementById('grupoAgrupacion');

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    cargarDatos();
    setupDragAndDrop();
});

// Cargar datos
async function cargarDatos() {
    try {
        const params = new URLSearchParams({
            page: currentPage,
            per_page: perPage,
            sort_key: sortKey,
            sort_dir: sortDir,
            search: buscador?.value || '',
            fecha_inicio: fechaInicio?.value || '',
            fecha_fin: fechaFin?.value || '',
            estatus: filtroEstatus?.value || ''
        });
        
        const response = await fetch(`${API_URL}?${params}`);
        const result = await response.json();
        
        if (result.success) {
            complementosData = result.data.complementos;
            totalPages = result.data.pagination.last_page;
            actualizarKPIs(result.data.kpis);
            renderizarTabla(complementosData);
            actualizarPaginacion(result.data.pagination);
        } else {
            mostrarToast('Error al cargar datos: ' + result.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarToast('Error de conexión', 'error');
    }
}

// Renderizar tabla
function renderizarTabla(datos) {
    if (!tablaBody) return;
    
    if (datos.length === 0) {
        tablaBody.innerHTML = '<tr><td colspan="10" style="text-align: center; padding: 40px;"><i class="fas fa-folder-open" style="font-size: 48px; color: #ced4da;"></i><p>No hay complementos de pago para mostrar</p></td></tr>';
        if (sumMonto) sumMonto.textContent = '$0.00';
        return;
    }
    
    const { grupos } = agruparDatos(datos, columnasAgrupadas);
    const hayGrupos = grupos.length > 0 && columnasAgrupadas.length > 0;
    let totalMonto = 0;
    
    tablaBody.innerHTML = '';
    
    if (hayGrupos) {
        grupos.forEach(grupo => {
            const grupoRow = document.createElement('tr');
            grupoRow.className = 'fila-grupo';
            grupoRow.dataset.grupoId = grupo.id;
            if (expandedGroups.has(grupo.id)) grupoRow.classList.add('expandido');
            
            grupoRow.innerHTML = `
                <td colspan="10" style="border: 1px solid #dee2e6; padding: 10px;">
                    <div style="display: flex; justify-content: space-between;">
                        <div>
                            <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                            <strong style="color: #2378e1;">${escapeHtml(grupo.valor)}</strong>
                            <span style="color: #6c757d;">(${grupo.items.length} registros - Monto: ${formatMoney(grupo.totalMonto)})</span>
                        </div>
                    </div>
                </td>
            `;
            tablaBody.appendChild(grupoRow);
            
            totalMonto += grupo.totalMonto;
            
            if (expandedGroups.has(grupo.id)) {
                grupo.items.forEach(item => {
                    const row = document.createElement('tr');
                    row.className = 'fila-detalle';
                    row.innerHTML = `
                        <td style="padding-left: 30px;">${escapeHtml(item.folio || '-')}</td>
                        <td>${escapeHtml(item.cliente || '-')}</td>
                        <td>${escapeHtml(item.rfc || '-')}</td>
                        <td>${item.fecha_lista || '-'}</td>
                        <td>${escapeHtml(item.documento_relacionado || '-')}</td>
                        <td>${escapeHtml(item.forma_pago || '-')}</td>
                        <td style="text-align:right;">${formatMoney(item.monto)}</td>
                        <td><span class="badge ${item.badge_class}">${item.estatus}</span></td>
                        <td style="font-size:10px;">${escapeHtml(item.uuid || '-')}</td>
                        <td style="position:sticky;right:0;background:white;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-eye" data-id="${item.id}" style="cursor:pointer;color:#083CAE;" title="Ver"></i>
                                <i class="fas fa-edit" data-id="${item.id}" style="cursor:pointer;color:#083CAE;" title="Editar"></i>
                                ${item.estatus === 'Pendiente' ? '<i class="fas fa-cloud-upload-alt" data-id="${item.id}" style="cursor:pointer;color:#2CBF1F;" title="Timbrar"></i>' : ''}
                                ${item.estatus === 'Timbrado' ? '<i class="fas fa-ban" data-id="${item.id}" style="cursor:pointer;color:#dc3545;" title="Cancelar"></i>' : ''}
                                <i class="fas fa-file-pdf" data-id="${item.id}" style="cursor:pointer;color:#083CAE;" title="PDF"></i>
                                <i class="fas fa-file-code" data-id="${item.id}" style="cursor:pointer;color:#083CAE;" title="XML"></i>
                            </div>
                        </td>
                    `;
                    tablaBody.appendChild(row);
                });
            }
        });
        paginacionInfo.textContent = `Mostrando ${grupos.length} grupos`;
    } else {
        datos.forEach(item => {
            totalMonto += item.monto;
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${escapeHtml(item.folio || '-')}</td>
                <td>${escapeHtml(item.cliente || '-')}</td>
                <td>${escapeHtml(item.rfc || '-')}</td>
                <td>${item.fecha_lista || '-'}</td>
                <td>${escapeHtml(item.documento_relacionado || '-')}</td>
                <td>${escapeHtml(item.forma_pago || '-')}</td>
                <td style="text-align:right;">${formatMoney(item.monto)}</td>
                <td><span class="badge ${item.badge_class}">${item.estatus}</span></td>
                <td style="font-size:10px;">${escapeHtml(item.uuid || '-')}</td>
                <td style="position:sticky;right:0;background:white;">
                    <div style="display: flex; gap: 8px; justify-content: center;">
                        <i class="fas fa-eye" data-id="${item.id}" style="cursor:pointer;color:#083CAE;" title="Ver"></i>
                        <i class="fas fa-edit" data-id="${item.id}" style="cursor:pointer;color:#083CAE;" title="Editar"></i>
                        ${item.estatus === 'Pendiente' ? '<i class="fas fa-cloud-upload-alt" data-id="${item.id}" style="cursor:pointer;color:#2CBF1F;" title="Timbrar"></i>' : ''}
                        ${item.estatus === 'Timbrado' ? '<i class="fas fa-ban" data-id="${item.id}" style="cursor:pointer;color:#dc3545;" title="Cancelar"></i>' : ''}
                        <i class="fas fa-file-pdf" data-id="${item.id}" style="cursor:pointer;color:#083CAE;" title="PDF"></i>
                        <i class="fas fa-file-code" data-id="${item.id}" style="cursor:pointer;color:#083CAE;" title="XML"></i>
                    </div>
                </td>
            `;
            tablaBody.appendChild(row);
        });
    }
    
    if (sumMonto) sumMonto.textContent = formatMoney(totalMonto);
}

// Actualizar KPIs
function actualizarKPIs(kpis) {
    if (!kpis) return;
    document.getElementById('totalComplementos').textContent = kpis.total_formateado || '0';
    document.getElementById('porTimbrar').textContent = kpis.por_timbrar || '0';
    document.getElementById('timbrados').textContent = kpis.timbrados || '0';
    document.getElementById('montoTotal').textContent = kpis.monto_total_formateado || '$0';
}

// Actualizar paginación
function actualizarPaginacion(pagination) {
    if (!pagination) return;
    const current = pagination.current_page || 1;
    const total = pagination.total || 0;
    const from = pagination.from || 0;
    const to = pagination.to || 0;
    
    paginaActualSpan.textContent = current;
    paginacionInfo.textContent = `Mostrando ${from}-${to} de ${total} registros`;
    btnAnterior.disabled = current === 1;
    btnPrimera.disabled = current === 1;
    btnSiguiente.disabled = current === pagination.last_page;
    btnUltima.disabled = current === pagination.last_page;
    currentPage = current;
    totalPages = pagination.last_page;
}

// Formatear moneda
function formatMoney(amount) {
    return '$' + parseFloat(amount).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Escapar HTML
function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// Agrupar datos
function agruparDatos(datos, columnas) {
    if (columnas.length === 0) return { grupos: [], items: datos };
    const gruposMap = new Map();
    datos.forEach(item => {
        const grupoId = columnas.map(col => item[col] || 'Sin valor').join('||');
        if (!gruposMap.has(grupoId)) {
            gruposMap.set(grupoId, {
                id: grupoId,
                valor: columnas.map(col => item[col] || 'Sin valor').join(' - '),
                items: [item],
                totalMonto: item.monto || 0
            });
        } else {
            const grupo = gruposMap.get(grupoId);
            grupo.items.push(item);
            grupo.totalMonto += item.monto || 0;
        }
    });
    return { grupos: Array.from(gruposMap.values()), items: [] };
}

// Drag & Drop
function setupDragAndDrop() {
    const headers = document.querySelectorAll('th[draggable="true"]');
    headers.forEach(th => {
        th.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('text/plain', th.dataset.columna);
        });
    });
    grupoAgrupacion.addEventListener('dragover', (e) => { e.preventDefault(); grupoAgrupacion.classList.add('drag-over'); });
    grupoAgrupacion.addEventListener('dragleave', () => { grupoAgrupacion.classList.remove('drag-over'); });
    grupoAgrupacion.addEventListener('drop', (e) => {
        e.preventDefault();
        grupoAgrupacion.classList.remove('drag-over');
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadas.includes(columna)) {
            columnasAgrupadas.push(columna);
            actualizarGrupoColumnas();
        }
    });
}

function actualizarGrupoColumnas() {
    const container = document.getElementById('grupoColumnas');
    const texto = document.getElementById('textoAgrupar');
    if (!container) return;
    container.innerHTML = '';
    if (columnasAgrupadas.length === 0) {
        if (texto) texto.style.display = 'inline';
    } else {
        if (texto) texto.style.display = 'none';
        columnasAgrupadas.forEach(col => {
            const nombres = { folio:'Folio', cliente:'Cliente', rfc:'RFC', fecha_pago:'Fecha Pago', documento_relacionado:'Documento', forma_pago:'Forma Pago', monto:'Monto', estatus:'Estado', uuid:'UUID' };
            const chip = document.createElement('span');
            chip.className = 'columna-agrupada';
            chip.innerHTML = `${nombres[col] || col}<span class="remover" data-columna="${col}">&times;</span>`;
            container.appendChild(chip);
        });
    }
    expandedGroups.clear();
    renderizarTabla(complementosData);
}

// Eventos
btnAnterior?.addEventListener('click', () => { if (currentPage > 1) { currentPage--; cargarDatos(); } });
btnSiguiente?.addEventListener('click', () => { if (currentPage < totalPages) { currentPage++; cargarDatos(); } });
btnPrimera?.addEventListener('click', () => { currentPage = 1; cargarDatos(); });
btnUltima?.addEventListener('click', () => { currentPage = totalPages; cargarDatos(); });
btnAplicarFiltros?.addEventListener('click', () => { currentPage = 1; cargarDatos(); });
fechaInicio?.addEventListener('change', () => { currentPage = 1; cargarDatos(); });
fechaFin?.addEventListener('change', () => { currentPage = 1; cargarDatos(); });
filtroEstatus?.addEventListener('change', () => { currentPage = 1; cargarDatos(); });

if (buscador) {
    buscador.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => { currentPage = 1; cargarDatos(); }, 500);
    });
}

document.addEventListener('click', (e) => {
    if (e.target.classList.contains('remover')) {
        columnasAgrupadas = columnasAgrupadas.filter(c => c !== e.target.dataset.columna);
        actualizarGrupoColumnas();
    } else if (e.target.closest('.fila-grupo')) {
        const grupoRow = e.target.closest('.fila-grupo');
        const grupoId = grupoRow.dataset.grupoId;
        const icono = grupoRow.querySelector('i');
        if (expandedGroups.has(grupoId)) {
            expandedGroups.delete(grupoId);
            if (icono) icono.className = 'fas fa-caret-right';
        } else {
            expandedGroups.add(grupoId);
            if (icono) icono.className = 'fas fa-caret-down';
        }
        renderizarTabla(complementosData);
    } else if (e.target.classList.contains('fa-eye')) {
        alert('Ver complemento');
    } else if (e.target.classList.contains('fa-edit')) {
        alert('Editar complemento');
    } else if (e.target.classList.contains('fa-cloud-upload-alt')) {
        const id = e.target.dataset.id;
        if (confirm('¿Timbrar este complemento?')) {
            timbrarComplemento(id);
        }
    } else if (e.target.classList.contains('fa-ban')) {
        const id = e.target.dataset.id;
        if (confirm('¿Cancelar este complemento?')) {
            cancelarComplemento(id);
        }
    }
});

async function timbrarComplemento(id) {
    try {
        const response = await fetch(`${API_URL}/${id}/timbrar`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
        const result = await response.json();
        if (result.success) {
            mostrarToast('Complemento timbrado correctamente', 'success');
            cargarDatos();
        } else {
            mostrarToast(result.message, 'error');
        }
    } catch (error) {
        mostrarToast('Error al timbrar', 'error');
    }
}

async function cancelarComplemento(id) {
    try {
        const response = await fetch(`${API_URL}/${id}/cancelar`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
        const result = await response.json();
        if (result.success) {
            mostrarToast('Complemento cancelado correctamente', 'success');
            cargarDatos();
        } else {
            mostrarToast(result.message, 'error');
        }
    } catch (error) {
        mostrarToast('Error al cancelar', 'error');
    }
}

// Modal nuevo complemento
let modal = null;

btnNuevo?.addEventListener('click', async () => {
    await cargarClientes();
    if (!modal) {
        modal = document.getElementById('nuevoModal');
    }
    if (modal) {
        document.getElementById('fFecha').value = new Date().toISOString().split('T')[0];
        document.getElementById('fMonto').value = '';
        document.getElementById('fDocumento').value = '';
        modal.style.display = 'flex';
    }
});

function cerrarModal() {
    if (modal) modal.style.display = 'none';
}

async function cargarClientes() {
    try {
        const response = await fetch(API_CLIENTES);
        const result = await response.json();
        const select = document.getElementById('fCliente');
        if (select && result.success) {
            select.innerHTML = '<option value="">Seleccione un cliente...</option>';
            result.data.forEach(cliente => {
                select.innerHTML += `<option value="${cliente.contacto_id}">${cliente.razon_social} - ${cliente.rfc || 'Sin RFC'}</option>`;
            });
        }
    } catch (error) {
        console.error('Error cargando clientes:', error);
    }
}

async function guardarComplemento() {
    const clienteId = document.getElementById('fCliente').value;
    const fecha = document.getElementById('fFecha').value;
    const monto = parseFloat(document.getElementById('fMonto').value);
    const documento = document.getElementById('fDocumento').value;
    const formaPago = document.getElementById('fFormaPago').value;
    
    if (!clienteId) { mostrarToast('Seleccione un cliente', 'warning'); return; }
    if (!fecha) { mostrarToast('Seleccione una fecha', 'warning'); return; }
    if (!monto || monto <= 0) { mostrarToast('Ingrese un monto válido', 'warning'); return; }
    
    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({
                cliente_id: clienteId,
                fecha_pago: fecha,
                monto: monto,
                documento_relacionado: documento,
                forma_pago: formaPago
            })
        });
        const result = await response.json();
        if (result.success) {
            mostrarToast('Complemento registrado correctamente', 'success');
            cerrarModal();
            cargarDatos();
        } else {
            mostrarToast(result.message, 'error');
        }
    } catch (error) {
        mostrarToast('Error al guardar', 'error');
    }
}

function mostrarToast(msg, tipo = 'success') {
    const container = document.getElementById('toastContainer') || (() => {
        const div = document.createElement('div');
        div.id = 'toastContainer';
        div.style.cssText = 'position:fixed; bottom:20px; right:20px; z-index:9999; display:flex; flex-direction:column; gap:10px;';
        document.body.appendChild(div);
        return div;
    })();
    const toast = document.createElement('div');
    toast.className = `toast ${tipo}`;
    toast.style.cssText = `background:#1A1D23; color:white; padding:12px 20px; border-radius:8px; font-size:13px; display:flex; align-items:center; gap:12px; min-width:300px; box-shadow:0 8px 24px rgba(0,0,0,0.2); animation:slideInRight 0.3s ease; border-left:4px solid ${tipo === 'success' ? '#28a745' : '#dc3545'};`;
    const icon = tipo === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    toast.innerHTML = `<i class="fas ${icon}"></i> ${msg}`;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.animation = 'slideInRight 0.3s reverse';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>
@endsection