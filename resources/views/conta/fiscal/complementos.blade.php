@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
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

                <!-- KPIs -->
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
                        <div><input type="date" id="fechaInicio" value="{{ $fechaInicioDefault }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;"></div>
                        <div><input type="date" id="fechaFin" value="{{ $fechaFinDefault }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;"></div>
                        <div>
                            <select id="filtroEstatus" style="padding: 6px 10px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 130px; background-color: white;">
                                <option value="">Todos</option>
                                <option value="Pendiente">Por Timbrar</option>
                                <option value="Timbrado">Timbrados</option>
                                <option value="Cancelado">Cancelados</option>
                            </select>
                        </div>
                        <div><button id="btnAplicarFiltros" style="background-color: #083CAE; border: none; border-radius: 4px; padding: 6px 16px; color: white; cursor: pointer;"><i class="fas fa-search"></i> Aplicar</button></div>
                        <div><a href="{{ route('conta.complementos') }}" style="background-color: #6c757d; border: none; border-radius: 4px; padding: 6px 16px; color: white; text-decoration: none; display: inline-block;"><i class="fas fa-undo"></i> Limpiar</a></div>
                        <div><button id="btnNuevo" style="background-color: #2CBF1F; border: none; border-radius: 4px; padding: 8px 16px; color: white; cursor: pointer;"><i class="fas fa-plus"></i> Nuevo</button></div>
                        <div><a href="{{ route('conta.complementos.exportar', request()->all()) }}" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; color: #083CAE; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;"><i class="fas fa-file-excel"></i> Excel</a></div>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto;">
                    <table class="table table-bordered" style="width: 100%; font-size: 12px; margin-bottom: 0;">
                        <thead style="position: sticky; top: 0; background-color: #2378e1; z-index: 2;">
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
                            <tr><td colspan="10" style="text-align: center; padding: 40px;">Cargando datos...</td></tr>
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

<!-- MODAL CREAR / EDITAR -->
<div class="modal" id="formModal" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="formModalTitle"><i class="fas fa-plus-circle"></i> Nuevo Complemento de Pago</h5>
                <button type="button" class="close" onclick="cerrarFormModal()" aria-label="Cerrar">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formComplemento" autocomplete="off">
                    <input type="hidden" id="fId" value="">
                    <input type="hidden" id="fModo" value="crear">

                    <div class="form-group">
                        <label>Cliente/Proveedor <span style="color:red;">*</span></label>
                        <select id="fCliente" class="form-control">
                            <option value="">Cargando clientes...</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Facturas relacionadas <span class="hint">(opcional, Ctrl/Cmd para múltiples)</span></label>
                        <select id="fFactura" class="form-control" multiple size="4">
                            <option value="" disabled>Seleccione primero un cliente...</option>
                        </select>
                        <small id="fFacturaHelp" class="hint" style="display:block; margin-top:4px;"></small>
                    </div>

                    <div class="row-2">
                        <div class="form-group">
                            <label>Fecha Pago <span style="color:red;">*</span></label>
                            <input type="date" id="fFecha" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label>Monto <span style="color:red;">*</span></label>
                            <input type="number" id="fMonto" class="form-control" step="0.01" placeholder="0.00">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Documento Relacionado (Factura)</label>
                        <input type="text" id="fDocumento" class="form-control" placeholder="FAC-001-2026">
                    </div>

                    <div class="row-2">
                        <div class="form-group">
                            <label>Forma de Pago</label>
                            <select id="fFormaPago" class="form-control">
                                <option value="Transferencia">Transferencia</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Cuenta de banco</label>
                            <select id="fCuentaBanco" class="form-control">
                                <option value="">Cargando cuentas...</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="cerrarFormModal()">Cancelar</button>
                <button type="button" id="btnGuardarComplemento" onclick="guardarComplemento()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL VER -->
<div class="modal" id="verModal" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5><i class="fas fa-eye"></i> Detalle del Complemento</h5>
                <button type="button" class="close" onclick="cerrarVerModal()" aria-label="Cerrar">&times;</button>
            </div>
            <div class="modal-body">
                <div id="verContenido" style="font-size:13px;">
                    <p style="text-align:center; color:#6c757d;">Cargando...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="cerrarVerModal()">Cerrar</button>
                <button type="button" onclick="imprimirPdfActual()" style="background:#dc3545;color:white;border:none;padding:8px 16px;border-radius:4px;cursor:pointer;"><i class="fas fa-file-pdf"></i> PDF</button>
                <button type="button" onclick="descargarXmlActual()" style="background:#28a745;color:white;border:none;padding:8px 16px;border-radius:4px;cursor:pointer;"><i class="fas fa-file-code"></i> XML</button>
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

    .modal {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.55); z-index: 9999;
        display: flex; align-items: center; justify-content: center;
        padding: 20px; overflow-y: auto;
    }
    .modal-dialog {
        width: 100%; max-width: 600px; margin: auto;
        max-height: calc(100vh - 40px);
        display: flex; flex-direction: column;
    }
    .modal-content {
        background: #fff; border-radius: 10px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.35);
        display: flex; flex-direction: column;
        max-height: calc(100vh - 40px);
        overflow: hidden;
    }
    .modal-header {
        background: #083CAE; color: #fff;
        padding: 14px 18px;
        display: flex; align-items: center; justify-content: space-between;
        flex-shrink: 0;
    }
    .modal-header h5 { margin: 0; font-size: 16px; color: #fff; }
    .modal-header .close { background: transparent; border: none; color: #fff; font-size: 26px; line-height: 1; cursor: pointer; padding: 0; }
    .modal-body { padding: 18px; overflow-y: auto; flex: 1 1 auto; min-height: 0; }
    .modal-footer {
        padding: 14px 18px; border-top: 1px solid #dee2e6;
        display: flex; justify-content: flex-end; gap: 10px;
        flex-shrink: 0; background: #fff;
    }

    .form-group { margin-bottom: 14px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; }
    .form-control { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; box-sizing: border-box; }
    .form-control:focus { outline: none; border-color: #083CAE; box-shadow: 0 0 0 2px rgba(8,60,174,0.2); }
    .row-2 { display: flex; gap: 12px; flex-wrap: wrap; }
    .row-2 > .form-group { flex: 1 1 220px; }
    .hint { color: #6c757d; font-size: 11px; font-weight: normal; }
    .btn-secondary { background:#6c757d; color:#fff; border:none; padding:8px 16px; border-radius:4px; cursor:pointer; }
    #btnGuardarComplemento { background:#083CAE; color:#fff; border:none; padding:8px 16px; border-radius:4px; cursor:pointer; }
    #btnGuardarComplemento:disabled { opacity: 0.6; cursor: not-allowed; }

    .ver-grid { display: grid; grid-template-columns: 160px 1fr; gap: 8px 14px; }
    .ver-grid dt { color: #6c757d; font-weight: 600; }
    .ver-grid dd { margin: 0; word-break: break-word; }
    .ver-total { margin-top: 12px; padding-top: 12px; border-top: 1px dashed #dee2e6; display: flex; justify-content: space-between; align-items: center; font-size: 16px; }
    .ver-total strong { color: #083CAE; }

    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to   { transform: translateX(0); opacity: 1; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
// ============================================================
// URLs y constantes
// ============================================================
var API_URL      = '/api/complementos-pago';
var API_CLIENTES = '/api/complementos-pago/clientes';
var API_FACTURAS = '/api/complementos-pago/facturas-cliente';
var API_CUENTAS  = '/api/complementos-pago/cuentas-banco';
var CSRF_TOKEN   = '{{ csrf_token() }}';

// ============================================================
// Estado
// ============================================================
var complementosData = [];
var currentPage = 1, perPage = 10, totalPages = 1;
var sortKey = 'fecha_pago', sortDir = 'desc';
var columnasAgrupadas = [];
var expandedGroups = new Set();
var searchTimeout;
var formModalEl = null, verModalEl = null;
var verComplementoActual = null;

function $(id) { return document.getElementById(id); }

// ============================================================
// Init
// ============================================================
document.addEventListener('DOMContentLoaded', function() {
    formModalEl = $('formModal');
    verModalEl  = $('verModal');
    cargarDatos();
    setupDragAndDrop();

    if ($('fCliente')) $('fCliente').addEventListener('change', onClienteChange);
    if ($('fFactura')) $('fFactura').addEventListener('change', onFacturaChange);
});

// ============================================================
// Carga
// ============================================================
async function cargarDatos() {
    try {
        var params = new URLSearchParams({
            page: currentPage, per_page: perPage,
            sort_key: sortKey, sort_dir: sortDir,
            search: $('buscador') ? $('buscador').value : '',
            fecha_inicio: $('fechaInicio') ? $('fechaInicio').value : '',
            fecha_fin: $('fechaFin') ? $('fechaFin').value : '',
            estatus: $('filtroEstatus') ? $('filtroEstatus').value : ''
        });

        var r = await fetch(API_URL + '?' + params.toString(), { headers: { 'Accept': 'application/json' } });
        var result = await r.json();

        if (result.success) {
            complementosData = result.data.complementos;
            totalPages = result.data.pagination.last_page;
            actualizarKPIs(result.data.kpis);
            renderizarTabla(complementosData);
            actualizarPaginacion(result.data.pagination);
        } else {
            mostrarToast('Error al cargar datos: ' + result.message, 'error');
        }
    } catch (err) {
        mostrarToast('Error de conexión', 'error');
    }
}

// ============================================================
// Render
// ============================================================
function renderizarTabla(datos) {
    var tbody = $('tablaBody');
    if (!tbody) return;

    if (!datos || datos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" style="text-align: center; padding: 40px;"><i class="fas fa-folder-open" style="font-size: 48px; color: #ced4da;"></i><p>No hay complementos de pago para mostrar</p></td></tr>';
        $('sumMonto').textContent = '$0.00';
        return;
    }

    var agrupado = agruparDatos(datos, columnasAgrupadas);
    var grupos = agrupado.grupos;
    var hayGrupos = grupos.length > 0 && columnasAgrupadas.length > 0;
    var totalMonto = 0;
    tbody.innerHTML = '';

    if (hayGrupos) {
        grupos.forEach(function(grupo) {
            var grupoRow = document.createElement('tr');
            grupoRow.className = 'fila-grupo';
            grupoRow.dataset.grupoId = grupo.id;
            grupoRow.innerHTML = '<td colspan="10" style="border: 1px solid #dee2e6; padding: 10px;">' +
                '<div>' +
                '<i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>' +
                '<strong style="color: #2378e1;">' + escapeHtml(grupo.valor) + '</strong>' +
                '<span style="color: #6c757d;">(' + grupo.items.length + ' registros - Monto: ' + formatMoney(grupo.totalMonto) + ')</span>' +
                '</div></td>';
            tbody.appendChild(grupoRow);
            totalMonto += grupo.totalMonto;
            if (expandedGroups.has(grupo.id)) {
                grupo.items.forEach(function(item) { tbody.appendChild(filaDetalle(item)); });
            }
        });
        $('paginacionInfo').textContent = 'Mostrando ' + grupos.length + ' grupos';
    } else {
        datos.forEach(function(item) {
            totalMonto += item.monto;
            tbody.appendChild(filaDetalle(item));
        });
    }

    $('sumMonto').textContent = formatMoney(totalMonto);
}

function filaDetalle(item) {
    var tr = document.createElement('tr');
    var acciones = '<div style="display: flex; gap: 8px; justify-content: center;">' +
        '<i class="fas fa-eye" data-id="' + item.id + '" data-accion="ver" title="Ver" style="cursor:pointer;color:#083CAE;"></i>' +
        '<i class="fas fa-edit" data-id="' + item.id + '" data-accion="editar" title="Editar" style="cursor:pointer;color:#083CAE;"></i>' +
        (item.estatus === 'Pendiente' ? '<i class="fas fa-cloud-upload-alt" data-id="' + item.id + '" data-accion="timbrar" title="Timbrar" style="cursor:pointer;color:#2CBF1F;"></i>' : '') +
        (item.estatus === 'Timbrado'   ? '<i class="fas fa-ban" data-id="' + item.id + '" data-accion="cancelar" title="Cancelar" style="cursor:pointer;color:#dc3545;"></i>' : '') +
        '<i class="fas fa-file-pdf"  data-id="' + item.id + '" data-accion="pdf" title="PDF" style="cursor:pointer;color:#dc3545;"></i>' +
        '<i class="fas fa-file-code" data-id="' + item.id + '" data-accion="xml" title="XML" style="cursor:pointer;color:#28a745;"></i>' +
        '</div>';
    tr.innerHTML =
        '<td>' + escapeHtml(item.folio || '-') + '</td>' +
        '<td>' + escapeHtml(item.cliente || '-') + '</td>' +
        '<td>' + escapeHtml(item.rfc || '-') + '</td>' +
        '<td>' + (item.fecha_lista || '-') + '</td>' +
        '<td>' + escapeHtml(item.documento_relacionado || '-') + '</td>' +
        '<td>' + escapeHtml(item.forma_pago || '-') + '</td>' +
        '<td style="text-align:right;">' + formatMoney(item.monto) + '</td>' +
        '<td><span class="badge ' + item.badge_class + '">' + item.estatus + '</span></td>' +
        '<td style="font-size:10px;">' + escapeHtml(item.uuid || '-') + '</td>' +
        '<td style="position:sticky;right:0;background:white;">' + acciones + '</td>';
    return tr;
}

// ============================================================
// Utils
// ============================================================
function actualizarKPIs(k) {
    if (!k) return;
    $('totalComplementos').textContent = k.total_formateado || '0';
    $('porTimbrar').textContent = k.por_timbrar || '0';
    $('timbrados').textContent = k.timbrados || '0';
    $('montoTotal').textContent = k.monto_total_formateado || '$0';
}
function actualizarPaginacion(p) {
    if (!p) return;
    var cur = p.current_page || 1;
    $('paginaActual').textContent = cur;
    $('paginacionInfo').textContent = 'Mostrando ' + (p.from || 0) + '-' + (p.to || 0) + ' de ' + (p.total || 0) + ' registros';
    $('btnAnterior').disabled = cur === 1;
    $('btnPrimera').disabled = cur === 1;
    $('btnSiguiente').disabled = cur === p.last_page;
    $('btnUltima').disabled = cur === p.last_page;
    currentPage = cur;
    totalPages = p.last_page;
}
function formatMoney(a) {
    return '$' + parseFloat(a || 0).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}
function escapeHtml(s) {
    if (s === null || s === undefined) return '';
    return String(s).replace(/[&<>"']/g, function(m) {
        return ({ '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;' })[m];
    });
}
function agruparDatos(datos, cols) {
    if (cols.length === 0) return { grupos: [], items: datos };
    var map = new Map();
    datos.forEach(function(item) {
        var id = cols.map(function(c) { return item[c] || 'Sin valor'; }).join('||');
        if (!map.has(id)) {
            map.set(id, { id: id, valor: cols.map(function(c) { return item[c] || 'Sin valor'; }).join(' - '), items: [item], totalMonto: item.monto || 0 });
        } else {
            var g = map.get(id);
            g.items.push(item);
            g.totalMonto += item.monto || 0;
        }
    });
    return { grupos: Array.from(map.values()), items: [] };
}

// ============================================================
// Drag & Drop
// ============================================================
function setupDragAndDrop() {
    document.querySelectorAll('th[draggable="true"]').forEach(function(th) {
        th.addEventListener('dragstart', function(e) { e.dataTransfer.setData('text/plain', th.dataset.columna); });
    });
    var grp = $('grupoAgrupacion');
    if (!grp) return;
    grp.addEventListener('dragover', function(e) { e.preventDefault(); grp.classList.add('drag-over'); });
    grp.addEventListener('dragleave', function() { grp.classList.remove('drag-over'); });
    grp.addEventListener('drop', function(e) {
        e.preventDefault();
        grp.classList.remove('drag-over');
        var col = e.dataTransfer.getData('text/plain');
        if (col && columnasAgrupadas.indexOf(col) === -1) {
            columnasAgrupadas.push(col);
            actualizarGrupoColumnas();
        }
    });
}
function actualizarGrupoColumnas() {
    var c = $('grupoColumnas'), t = $('textoAgrupar');
    if (!c) return;
    c.innerHTML = '';
    if (columnasAgrupadas.length === 0) {
        if (t) t.style.display = 'inline';
    } else {
        if (t) t.style.display = 'none';
        var nombres = { folio:'Folio', cliente:'Cliente', rfc:'RFC', fecha_pago:'Fecha Pago', documento_relacionado:'Documento', forma_pago:'Forma Pago', monto:'Monto', estatus:'Estado', uuid:'UUID' };
        columnasAgrupadas.forEach(function(col) {
            var chip = document.createElement('span');
            chip.style.cssText = 'display:inline-flex;align-items:center;padding:4px 10px;background:#f0f4ff;border-radius:16px;color:#2378e1;font-size:12px;margin:2px;border:1px solid #2378e1;';
            chip.innerHTML = (nombres[col] || col) + '<span class="remover" data-columna="' + col + '" style="margin-left:6px;cursor:pointer;font-weight:bold;">&times;</span>';
            c.appendChild(chip);
        });
    }
    expandedGroups.clear();
    renderizarTabla(complementosData);
}

// ============================================================
// Eventos
// ============================================================
if ($('btnAnterior'))  $('btnAnterior').addEventListener('click',  function() { if (currentPage > 1) { currentPage--; cargarDatos(); } });
if ($('btnSiguiente')) $('btnSiguiente').addEventListener('click', function() { if (currentPage < totalPages) { currentPage++; cargarDatos(); } });
if ($('btnPrimera'))   $('btnPrimera').addEventListener('click',   function() { currentPage = 1; cargarDatos(); });
if ($('btnUltima'))    $('btnUltima').addEventListener('click',    function() { currentPage = totalPages; cargarDatos(); });
if ($('btnAplicarFiltros')) $('btnAplicarFiltros').addEventListener('click', function() { currentPage = 1; cargarDatos(); });
if ($('fechaInicio'))  $('fechaInicio').addEventListener('change',  function() { currentPage = 1; cargarDatos(); });
if ($('fechaFin'))     $('fechaFin').addEventListener('change',     function() { currentPage = 1; cargarDatos(); });
if ($('filtroEstatus'))$('filtroEstatus').addEventListener('change',function() { currentPage = 1; cargarDatos(); });
if ($('buscador')) {
    $('buscador').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() { currentPage = 1; cargarDatos(); }, 500);
    });
}

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remover')) {
        columnasAgrupadas = columnasAgrupadas.filter(function(c) { return c !== e.target.dataset.columna; });
        actualizarGrupoColumnas();
        return;
    }
    var grupoRow = e.target.closest('.fila-grupo');
    if (grupoRow && !e.target.closest('[data-accion]')) {
        var id = grupoRow.dataset.grupoId;
        var icono = grupoRow.querySelector('i');
        if (expandedGroups.has(id)) {
            expandedGroups.delete(id);
            if (icono) icono.className = 'fas fa-caret-right';
        } else {
            expandedGroups.add(id);
            if (icono) icono.className = 'fas fa-caret-down';
        }
        renderizarTabla(complementosData);
        return;
    }
    var accionEl = e.target.closest('[data-accion]');
    if (accionEl) {
        var idComp = accionEl.dataset.id;
        var accion = accionEl.dataset.accion;
        if (accion === 'ver')      verComplemento(idComp);
        if (accion === 'editar')   editarComplemento(idComp);
        if (accion === 'timbrar')  { if (confirm('¿Timbrar este complemento?')) timbrarComplemento(idComp); }
        if (accion === 'cancelar') { if (confirm('¿Cancelar este complemento?')) cancelarComplemento(idComp); }
        if (accion === 'pdf')      generarPdfPorId(idComp);
        if (accion === 'xml')      descargarXmlPorId(idComp);
    }
});

// ============================================================
// Timbrar / Cancelar
// ============================================================
async function timbrarComplemento(id) {
    try {
        var r = await fetch(API_URL + '/' + id + '/timbrar', { method:'POST', headers:{'X-CSRF-TOKEN':CSRF_TOKEN,'Accept':'application/json'} });
        var result = await r.json();
        if (result.success) { mostrarToast('Complemento timbrado', 'success'); cargarDatos(); }
        else mostrarToast(result.message, 'error');
    } catch (e) { mostrarToast('Error al timbrar', 'error'); }
}
async function cancelarComplemento(id) {
    try {
        var r = await fetch(API_URL + '/' + id + '/cancelar', { method:'POST', headers:{'X-CSRF-TOKEN':CSRF_TOKEN,'Accept':'application/json'} });
        var result = await r.json();
        if (result.success) { mostrarToast('Complemento cancelado', 'success'); cargarDatos(); }
        else mostrarToast(result.message, 'error');
    } catch (e) { mostrarToast('Error al cancelar', 'error'); }
}

// ============================================================
// Fetch un complemento
// ============================================================
async function fetchComplemento(id) {
    var r = await fetch(API_URL + '/' + id, { headers: { 'Accept': 'application/json' } });
    var result = await r.json();
    if (!result.success) throw new Error(result.message || 'No se pudo obtener el complemento');
    return result.data;
}

// ============================================================
// VER
// ============================================================
async function verComplemento(id) {
    try {
        var d = await fetchComplemento(id);
        verComplementoActual = d;

        $('verContenido').innerHTML =
            '<dl class="ver-grid">' +
            '<dt>Folio</dt><dd><strong>' + escapeHtml(d.folio || '-') + '</strong></dd>' +
            '<dt>Cliente</dt><dd>' + escapeHtml(d.cliente_nombre || '-') + '</dd>' +
            '<dt>RFC</dt><dd>' + escapeHtml(d.rfc || '-') + '</dd>' +
            '<dt>Fecha de pago</dt><dd>' + escapeHtml(d.fecha_formateada || d.fecha_pago || '-') + '</dd>' +
            '<dt>Documento</dt><dd>' + escapeHtml(d.documento_relacionado || '-') + '</dd>' +
            '<dt>Forma de pago</dt><dd>' + escapeHtml(d.forma_pago || '-') + '</dd>' +
            '<dt>Cuenta de banco</dt><dd>' + escapeHtml(d.cuenta_banco || '-') + '</dd>' +
            '<dt>Estatus</dt><dd><span class="badge badge-' + (d.estatus || '').toLowerCase() + '">' + escapeHtml(d.estatus || '-') + '</span></dd>' +
            '<dt>UUID</dt><dd style="font-size:11px;">' + escapeHtml(d.uuid || 'Sin timbrar') + '</dd>' +
            '<dt>Creado</dt><dd>' + escapeHtml(d.created_at || '-') + '</dd>' +
            '</dl>' +
            '<div class="ver-total">' +
            '<span>Monto total</span>' +
            '<strong>' + (d.monto_formateado || formatMoney(d.monto)) + '</strong>' +
            '</div>';
        verModalEl.style.display = 'flex';
    } catch (err) {
        mostrarToast(err.message, 'error');
    }
}
function cerrarVerModal() { verModalEl.style.display = 'none'; verComplementoActual = null; }

// ============================================================
// EDITAR
// ============================================================
async function editarComplemento(id) {
    try {
        var d = await fetchComplemento(id);
        if (d.estatus !== 'Pendiente') {
            mostrarToast('Solo se pueden editar complementos en estatus Pendiente', 'warning');
            return;
        }

        $('formModalTitle').innerHTML = '<i class="fas fa-edit"></i> Editar Complemento de Pago';
        $('fId').value = d.id;
        $('fModo').value = 'editar';

        await Promise.all([cargarClientes(), cargarCuentasBanco()]);

        $('fCliente').value = String(d.cliente_id || '');
        await onClienteChange({ target: { value: String(d.cliente_id || '') } });

        if (d.factura_id) {
            var opt = $('fFactura').querySelector('option[value="' + d.factura_id + '"]');
            if (opt) opt.selected = true;
        }

        $('fFecha').value = d.fecha_pago || new Date().toISOString().split('T')[0];
        $('fMonto').value = d.monto || '';
        $('fDocumento').value = d.documento_relacionado || '';
        $('fFormaPago').value = d.forma_pago || 'Transferencia';

        var selCuenta = $('fCuentaBanco');
        if (d.cuenta_banco) {
            var existe = Array.from(selCuenta.options).some(function(o) { return o.value === String(d.cuenta_banco); });
            if (!existe) {
                var opt2 = document.createElement('option');
                opt2.value = d.cuenta_banco;
                opt2.textContent = d.cuenta_banco;
                selCuenta.appendChild(opt2);
            }
            selCuenta.value = String(d.cuenta_banco);
        }

        formModalEl.style.display = 'flex';
    } catch (err) {
        mostrarToast(err.message, 'error');
    }
}

// ============================================================
// Nuevo
// ============================================================
if ($('btnNuevo')) {
    $('btnNuevo').addEventListener('click', async function() {
        $('formModalTitle').innerHTML = '<i class="fas fa-plus-circle"></i> Nuevo Complemento de Pago';
        $('fId').value = '';
        $('fModo').value = 'crear';
        $('fCliente').innerHTML = '<option value="">Cargando clientes...</option>';
        $('fFactura').innerHTML = '<option value="" disabled>Seleccione primero un cliente...</option>';
        $('fFacturaHelp').textContent = '';
        $('fFecha').value = new Date().toISOString().split('T')[0];
        $('fMonto').value = '';
        $('fDocumento').value = '';
        $('fFormaPago').value = 'Transferencia';
        $('fCuentaBanco').innerHTML = '<option value="">Cargando cuentas...</option>';

        formModalEl.style.display = 'flex';
        await Promise.all([cargarClientes(), cargarCuentasBanco()]);
    });
}
function cerrarFormModal() { formModalEl.style.display = 'none'; }

// ============================================================
// Catálogos
// ============================================================
async function cargarClientes() {
    try {
        var r = await fetch(API_CLIENTES, { headers: { 'Accept': 'application/json' } });
        var result = await r.json();
        var select = $('fCliente');
        select.innerHTML = '<option value="">Seleccione un cliente...</option>';
        if (result.success && Array.isArray(result.data)) {
            result.data.forEach(function(c) {
                var id = c.contacto_id || c.id;
                var opt = document.createElement('option');
                opt.value = String(id);
                opt.textContent = (c.razon_social || 'Sin nombre') + ' - ' + (c.rfc || 'Sin RFC');
                select.appendChild(opt);
            });
        }
    } catch (err) {
        mostrarToast('No se pudieron cargar los clientes', 'error');
    }
}
async function cargarCuentasBanco() {
    try {
        var r = await fetch(API_CUENTAS, { headers: { 'Accept': 'application/json' } });
        var result = await r.json();
        var select = $('fCuentaBanco');
        select.innerHTML = '<option value="">Seleccione una cuenta...</option>';
        if (result.success && Array.isArray(result.data) && result.data.length) {
            result.data.forEach(function(c) {
                var label = [c.banco, c.nombre, c.numero_cuenta || c.clabe].filter(Boolean).join(' · ') || ('Cuenta #' + (c.id || ''));
                var opt = document.createElement('option');
                opt.value = String(c.id || label);
                opt.textContent = label;
                select.appendChild(opt);
            });
        } else {
            select.innerHTML += '<option value="" disabled>(Sin cuentas configuradas)</option>';
        }
    } catch (err) {
        $('fCuentaBanco').innerHTML = '<option value="">Error al cargar cuentas</option>';
    }
}

// ============================================================
// Facturas del cliente
// ============================================================
async function onClienteChange(e) {
    var clienteIdRaw = e.target.value;
    var clienteId = parseInt(clienteIdRaw, 10);
    var selectFacturas = $('fFactura');
    var help = $('fFacturaHelp');

    if (!clienteIdRaw || clienteIdRaw === 'undefined' || !Number.isInteger(clienteId) || clienteId <= 0) {
        selectFacturas.innerHTML = '<option value="" disabled>Seleccione primero un cliente...</option>';
        if (help) help.textContent = '';
        return;
    }

    selectFacturas.innerHTML = '<option value="" disabled>Cargando facturas...</option>';
    if (help) help.textContent = 'Consultando facturas...';

    try {
        var r = await fetch(API_FACTURAS + '?cliente_id=' + encodeURIComponent(clienteId), { headers: { 'Accept': 'application/json' } });
        var result = await r.json();
        if (!result.success) {
            selectFacturas.innerHTML = '<option value="" disabled>' + escapeHtml(result.message || 'Error') + '</option>';
            if (help) help.textContent = result.message || '';
            return;
        }
        if (!Array.isArray(result.data) || result.data.length === 0) {
            selectFacturas.innerHTML = '<option value="" disabled>El cliente no tiene facturas pendientes</option>';
            if (help) help.textContent = 'Sin facturas con saldo pendiente.';
            return;
        }
        selectFacturas.innerHTML = '';
        result.data.forEach(function(f) {
            var folio = f.folio || ('#' + f.id);
            var total = f.total ? formatMoney(f.total) : '';
            var saldo = f.saldo ? (' · saldo ' + formatMoney(f.saldo)) : '';
            var fecha = f.fecha ? String(f.fecha).substring(0, 10) : '';
            var opt = document.createElement('option');
            opt.value = String(f.id);
            opt.textContent = (folio + ' · ' + fecha + ' · ' + total + saldo).replace(/\s+/g, ' ').trim();
            opt.dataset.folio = folio;
            opt.dataset.total = f.total || '';
            selectFacturas.appendChild(opt);
        });
        if (help) help.textContent = result.data.length + ' factura(s). Ctrl/Cmd para varias.';
    } catch (err) {
        selectFacturas.innerHTML = '<option value="" disabled>Error: ' + escapeHtml(err.message) + '</option>';
    }
}

function onFacturaChange(e) {
    var selected = Array.from(e.target.selectedOptions || []);
    if (selected.length === 1) {
        var opt = selected[0];
        var total = parseFloat(opt.dataset.total || '0');
        var montoInput = $('fMonto');
        var docInput = $('fDocumento');
        if (total > 0 && (!montoInput.value || parseFloat(montoInput.value) === 0)) montoInput.value = total.toFixed(2);
        if (!docInput.value && opt.dataset.folio) docInput.value = opt.dataset.folio;
    }
}

// ============================================================
// Guardar (crear / editar)
// ============================================================
async function guardarComplemento() {
    var modo      = $('fModo').value;
    var id        = $('fId').value;
    var clienteId = parseInt($('fCliente').value, 10);
    var fecha     = $('fFecha').value;
    var monto     = parseFloat($('fMonto').value);
    var documento = $('fDocumento').value;
    var formaPago = $('fFormaPago').value;
    var cuentaBanco = $('fCuentaBanco').value;
    var facturasSel = Array.from($('fFactura').selectedOptions || [])
        .map(function(o) { return parseInt(o.value, 10); })
        .filter(function(v) { return Number.isInteger(v) && v > 0; });

    if (!Number.isInteger(clienteId) || clienteId <= 0) { mostrarToast('Seleccione un cliente válido', 'warning'); return; }
    if (!fecha) { mostrarToast('Seleccione una fecha', 'warning'); return; }
    if (!monto || monto <= 0) { mostrarToast('Ingrese un monto válido', 'warning'); return; }

    var btn = $('btnGuardarComplemento');
    btn.disabled = true; btn.textContent = 'Guardando...';

    var payload = {
        fecha_pago: fecha,
        monto: monto,
        documento_relacionado: documento || null,
        forma_pago: formaPago || null,
        cuenta_banco: cuentaBanco || null,
        factura_id: facturasSel.length === 1 ? facturasSel[0] : null
    };

    try {
        var url = API_URL, method = 'POST';
        if (modo === 'editar') { url = API_URL + '/' + id; method = 'PUT'; }
        else { payload.cliente_id = clienteId; payload.facturas_ids = facturasSel.length ? facturasSel : null; }

        var r = await fetch(url, {
            method: method,
            headers: { 'Content-Type':'application/json', 'Accept':'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
            body: JSON.stringify(payload)
        });
        var result = await r.json();
        if (r.ok && result.success) {
            mostrarToast(modo === 'editar' ? 'Complemento actualizado' : 'Complemento registrado', 'success');
            cerrarFormModal();
            cargarDatos();
        } else {
            var errors = result.errors ? ' | ' + Object.values(result.errors).flat().join(' · ') : '';
            mostrarToast((result.message || 'Error') + errors, 'error');
        }
    } catch (err) {
        mostrarToast('Error de red al guardar', 'error');
    } finally {
        btn.disabled = false; btn.textContent = 'Guardar';
    }
}

// ============================================================
// PDF
// ============================================================
async function generarPdfPorId(id) {
    try {
        var d = await fetchComplemento(id);
        imprimirPdf(d);
    } catch (err) { mostrarToast(err.message, 'error'); }
}
function imprimirPdfActual() {
    if (verComplementoActual) imprimirPdf(verComplementoActual);
    else mostrarToast('No hay complemento cargado', 'warning');
}
function imprimirPdf(d) {
    var win = window.open('', '_blank', 'width=900,height=700');
    if (!win) { mostrarToast('Permite ventanas emergentes para ver el PDF', 'warning'); return; }

    var estilo = 'body{font-family:Arial,sans-serif;color:#222;margin:30px;}' +
        'h1{color:#083CAE;font-size:20px;margin:0 0 4px;}' +
        '.sub{color:#6c757d;font-size:12px;margin-bottom:20px;}' +
        'table{border-collapse:collapse;width:100%;font-size:12px;}' +
        'th,td{border:1px solid #dee2e6;padding:8px 10px;text-align:left;}' +
        'th{background:#083CAE;color:#fff;width:200px;}' +
        '.total{margin-top:18px;text-align:right;font-size:16px;}' +
        '.total strong{color:#083CAE;font-size:20px;}' +
        '.firma{margin-top:60px;display:flex;justify-content:space-between;font-size:12px;}' +
        '.firma div{width:45%;border-top:1px solid #333;padding-top:6px;text-align:center;}' +
        '@media print{body{margin:10mm;}}';

    var html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">' +
        '<title>Complemento de Pago ' + escapeHtml(d.folio || '') + '</title>' +
        '<style>' + estilo + '</style></head><body>' +
        '<h1>Complemento de Pago</h1>' +
        '<div class="sub">Folio ' + escapeHtml(d.folio || '-') + ' · Generado ' + new Date().toLocaleString('es-MX') + '</div>' +
        '<table>' +
        '<tr><th>Cliente</th><td>' + escapeHtml(d.cliente_nombre || '-') + '</td></tr>' +
        '<tr><th>RFC</th><td>' + escapeHtml(d.rfc || '-') + '</td></tr>' +
        '<tr><th>Fecha de pago</th><td>' + escapeHtml(d.fecha_formateada || d.fecha_pago || '-') + '</td></tr>' +
        '<tr><th>Documento relacionado</th><td>' + escapeHtml(d.documento_relacionado || '-') + '</td></tr>' +
        '<tr><th>Forma de pago</th><td>' + escapeHtml(d.forma_pago || '-') + '</td></tr>' +
        '<tr><th>Cuenta de banco</th><td>' + escapeHtml(d.cuenta_banco || '-') + '</td></tr>' +
        '<tr><th>Estatus</th><td>' + escapeHtml(d.estatus || '-') + '</td></tr>' +
        '<tr><th>UUID</th><td style="font-size:11px;">' + escapeHtml(d.uuid || 'Sin timbrar') + '</td></tr>' +
        '</table>' +
        '<div class="total">Monto total: <strong>' + (d.monto_formateado || formatMoney(d.monto)) + '</strong></div>' +
        '<div class="firma"><div>Recibí conforme</div><div>Autorizó</div></div>' +
        '<scr' + 'ipt>window.onload=function(){setTimeout(function(){window.print();},300);};</scr' + 'ipt>' +
        '</body></html>';

    win.document.open();
    win.document.write(html);
    win.document.close();
}

// ============================================================
// XML — construido con array.join para evitar problemas de escape
// ============================================================
async function descargarXmlPorId(id) {
    try {
        var d = await fetchComplemento(id);
        descargarXml(d);
    } catch (err) { mostrarToast(err.message, 'error'); }
}
function descargarXmlActual() {
    if (verComplementoActual) descargarXml(verComplementoActual);
    else mostrarToast('No hay complemento cargado', 'warning');
}
function descargarXml(d) {
    var uuid      = d.uuid || '00000000-0000-0000-0000-000000000000';
    var fechaPago = d.fecha_pago || new Date().toISOString().split('T')[0];
    var total     = parseFloat(d.monto || 0).toFixed(2);
    var iva       = (parseFloat(total) * 0.16).toFixed(2);
    var folio     = (d.folio || 'SIN-FOLIO').replace(/[^A-Za-z0-9\-_]/g, '');
    var rfc       = (d.rfc || 'XAXX010101000').toUpperCase();
    var formaPago = mapFormaPago(d.forma_pago);
    var numCta    = mapCuentaBanco(d.cuenta_banco);
    var nombre    = escapeXml(d.cliente_nombre || 'CLIENTE');

    var lines = [
        '<?xml version="1.0" encoding="UTF-8"?>',
        '<cfdi:Comprobante xmlns:cfdi="http://www.sat.gob.mx/cfd/4"',
        '    xmlns:pago20="http://www.sat.gob.mx/Pagos20"',
        '    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"',
        '    xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd http://www.sat.gob.mx/Pagos20 http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos20.xsd"',
        '    Version="4.0" Serie="CP" Folio="' + folio + '"',
        '    Fecha="' + new Date().toISOString().substring(0,19) + '"',
        '    SubTotal="0.00" Moneda="XXX" Total="0.00" TipoDeComprobante="P"',
        '    Exportacion="01" LugarExpedicion="45100" NoCertificado="00000000000000000000" Certificado="">',
        '    <cfdi:Emisor Rfc="EKU9003173C9" Nombre="EMPRESA EMISORA" RegimenFiscal="601"/>',
        '    <cfdi:Receptor Rfc="' + rfc + '" Nombre="' + nombre + '" DomicilioFiscalReceptor="64000" RegimenFiscalReceptor="601" UsoCFDI="CP01"/>',
        '    <cfdi:Conceptos>',
        '        <cfdi:Concepto ClaveProdServ="84111506" Cantidad="1" ClaveUnidad="ACT" Descripcion="Pago" ValorUnitario="0" Importe="0" ObjetoImp="01"/>',
        '    </cfdi:Conceptos>',
        '    <cfdi:Complemento>',
        '        <pago20:Pagos Version="2.0">',
        '            <pago20:Totales MontoTotalPagos="' + total + '"/>',
        '            <pago20:Pago FechaPago="' + fechaPago + 'T12:00:00" FormaDePagoP="' + formaPago + '" MonedaP="MXN" Monto="' + total + '" NumOperacion="' + folio + '"' + (numCta ? ' NumCtaPago="' + numCta + '"' : '') + '>',
        '                <pago20:DoctoRelacionado IdDocumento="' + uuid + '" MonedaDR="MXN" NumParcialidad="1" ImpSaldoAnt="' + total + '" ImpPagado="' + total + '" ImpSaldoInsoluto="0.00" ObjetoImpDR="02">',
        '                    <pago20:ImpuestosDR>',
        '                        <pago20:TrasladosDR>',
        '                            <pago20:TrasladoDR BaseDR="' + total + '" ImpuestoDR="002" TipoFactorDR="Tasa" TasaOCuotaDR="0.160000" ImporteDR="' + iva + '"/>',
        '                        </pago20:TrasladosDR>',
        '                    </pago20:ImpuestosDR>',
        '                </pago20:DoctoRelacionado>',
        '                <pago20:ImpuestosP>',
        '                    <pago20:TrasladosP>',
        '                        <pago20:TrasladoP BaseP="' + total + '" ImpuestoP="002" TipoFactorP="Tasa" TasaOCuotaP="0.160000" ImporteP="' + iva + '"/>',
        '                    </pago20:TrasladosP>',
        '                </pago20:ImpuestosP>',
        '            </pago20:Pago>',
        '        </pago20:Pagos>',
        '    </cfdi:Complemento>',
        '</cfdi:Comprobante>'
    ];

    var xml = lines.join('\n');

    var blob = new Blob([xml], { type: 'application/xml;charset=utf-8' });
    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'ComplementoPago_' + folio + '_' + fechaPago + '.xml';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    setTimeout(function() { URL.revokeObjectURL(url); }, 2000);

    mostrarToast('XML descargado', 'success');
}

function escapeXml(s) {
    return String(s === null || s === undefined ? '' : s).replace(/[<>&"']/g, function(c) {
        return ({ '<':'&lt;', '>':'&gt;', '&':'&amp;', '"':'&quot;', "'":'&apos;' })[c];
    });
}
function mapFormaPago(v) {
    var map = { 'Transferencia':'03', 'Cheque':'02', 'Efectivo':'01', 'Tarjeta':'04' };
    return map[v] || '03';
}
function mapCuentaBanco(v) {
    if (!v) return '';
    return /^[0-9]{4,}$/.test(String(v)) ? String(v).substring(0,4) : '';
}

// ============================================================
// Toast
// ============================================================
function mostrarToast(msg, tipo) {
    tipo = tipo || 'success';
    var container = document.getElementById('toastContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        container.style.cssText = 'position:fixed;bottom:20px;right:20px;z-index:10000;display:flex;flex-direction:column;gap:10px;';
        document.body.appendChild(container);
    }
    var color = tipo === 'success' ? '#28a745' : (tipo === 'warning' ? '#fd7e14' : '#dc3545');
    var icon  = tipo === 'success' ? 'fa-check-circle' : (tipo === 'warning' ? 'fa-exclamation-circle' : 'fa-exclamation-triangle');
    var t = document.createElement('div');
    t.style.cssText = 'background:#1A1D23;color:white;padding:12px 20px;border-radius:8px;font-size:13px;display:flex;align-items:center;gap:12px;min-width:300px;max-width:480px;box-shadow:0 8px 24px rgba(0,0,0,0.2);animation:slideInRight 0.3s ease;border-left:4px solid ' + color + ';';
    t.innerHTML = '<i class="fas ' + icon + '"></i> <span>' + escapeHtml(msg) + '</span>';
    container.appendChild(t);
    setTimeout(function() {
        t.style.animation = 'slideInRight 0.3s reverse';
        setTimeout(function() { t.remove(); }, 300);
    }, 4000);
}

// ============================================================
// Exponer funciones globales para onclick
// ============================================================
window.cerrarFormModal = cerrarFormModal;
window.cerrarVerModal  = cerrarVerModal;
window.guardarComplemento = guardarComplemento;
window.imprimirPdfActual  = imprimirPdfActual;
window.descargarXmlActual = descargarXmlActual;
</script>
@endsection