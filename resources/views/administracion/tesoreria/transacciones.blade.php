@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #2378e1; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Traspasos entre Cuentas
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar" id="iconoAgrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 30px;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div><input type="date" id="fechaInicio" class="form-control" style="width: 140px;" placeholder="Fecha inicio"></div>
                        <div><input type="date" id="fechaFin" class="form-control" style="width: 140px;" placeholder="Fecha fin"></div>
                        <div><button id="btnAgregar" class="btn" style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; width: 36px; height: 36px;"><i class="fas fa-plus" style="color: #2378e1;"></i></button></div>
                        <div><button id="btnExcel" class="btn" style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px;"><i class="fas fa-file-excel" style="color: #2378e1;"></i> Excel</button></div>
                        <div><button id="btnColumnas" class="btn" style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px;"><i class="fas fa-columns" style="color: #2378e1;"></i> Columnas</button></div>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #2378e1;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." class="form-control" style="padding: 8px 8px 8px 35px; border: 1px solid #2378e1; border-radius: 4px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Contadores -->
                <div style="display: flex; gap: 20px; margin-bottom: 15px; padding: 10px; background: #e9ecef; border-radius: 8px;">
                    <div><strong>Total Traspasos:</strong> <span id="totalRegistros">0</span></div>
                    <div><strong>Completados:</strong> <span id="totalCompletados">0</span></div>
                    <div><strong>Pendientes:</strong> <span id="totalPendientes">0</span></div>
                </div>

                <!-- Tabla de Traspasos -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;" id="tablaContainer">
                    <table class="table table-bordered table-hover" id="tablaTraspasos" style="width: 100%; font-size: 12px;">
                        <thead style="background-color: #2378e1; color: white;">
                            <tr>
                                <th draggable="true" data-columna="folio" style="cursor: grab;">Folio</th>
                                <th draggable="true" data-columna="fecha" style="cursor: grab;">Fecha</th>
                                <th draggable="true" data-columna="cuenta_origen" style="cursor: grab;">Cuenta Origen</th>
                                <th draggable="true" data-columna="cuenta_destino" style="cursor: grab;">Cuenta Destino</th>
                                <th draggable="true" data-columna="monto" style="cursor: grab;">Monto</th>
                                <th draggable="true" data-columna="moneda_origen" style="cursor: grab;">Moneda</th>
                                <th draggable="true" data-columna="tipo_cambio" style="cursor: grab;">Tipo Cambio</th>
                                <th draggable="true" data-columna="monto_destino" style="cursor: grab;">Monto Destino</th>
                                <th draggable="true" data-columna="estatus" style="cursor: grab;">Estatus</th>
                                <th style="position: sticky; right: 0; background-color: #2378e1; z-index: 1;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="10" style="text-align: center;">Cargando...</td></tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="4" style="text-align: center;"><strong>Totales:</strong></td>
                                <td style="text-align: right;" id="sumMonto">$0.00</td>
                                <td colspan="5"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <button id="btnCrearFiltro" class="btn btn-link" style="background: transparent; border: none; color: #2378e1;"><i class="fas fa-filter"></i> Crear filtro</button>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <button id="btnPrimera" class="btn btn-sm" style="background: none; border: none; color: #2378e1;"><i class="fas fa-angle-double-left"></i></button>
                        <button id="btnAnterior" class="btn btn-sm" style="background: none; border: none; color: #2378e1;"><i class="fas fa-angle-left"></i></button>
                        <span id="paginaActual" style="background-color: #2378e1; color: white; padding: 5px 10px; border-radius: 4px;">1</span>
                        <button id="btnSiguiente" class="btn btn-sm" style="background: none; border: none; color: #2378e1;"><i class="fas fa-angle-right"></i></button>
                        <button id="btnUltima" class="btn btn-sm" style="background: none; border: none; color: #2378e1;"><i class="fas fa-angle-double-right"></i></button>
                        <span id="paginacionInfo" style="color: #2378e1; margin-left: 10px;">Mostrando 0-0 de 0 registros</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Traspaso -->
<div class="modal fade" id="modalTraspaso" tabindex="-1" style="z-index: 99999 !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-exchange-alt"></i> Nuevo Traspaso</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTraspaso">
                    <input type="hidden" id="traspaso_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Fecha <span class="text-danger">*</span></label>
                            <input type="date" id="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Proyecto (opcional)</label>
                            <select id="proyecto_id" class="form-control">
                                <option value="">Ninguno</option>
                                @foreach($proyectos ?? [] as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->codigo ?? '' }} - {{ $proyecto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Cuenta Origen <span class="text-danger">*</span></label>
                            <select id="cuenta_origen_id" class="form-control" required>
                                <option value="">Seleccionar cuenta...</option>
                                @foreach($cuentasBancarias ?? [] as $cuenta)
                                    <option value="{{ $cuenta->id }}" 
                                        data-moneda-id="{{ $cuenta->moneda_id }}" 
                                        data-moneda-simbolo="{{ $cuenta->moneda->simbolo ?? '$' }}" 
                                        data-saldo="{{ $cuenta->saldo_actual }}">
                                        {{ $cuenta->banco->nombre ?? 'Sin banco' }} - {{ $cuenta->numero_cuenta }} 
                                        ({{ $cuenta->moneda->simbolo ?? '$' }}) - Saldo: ${{ number_format($cuenta->saldo_actual, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Cuenta Destino <span class="text-danger">*</span></label>
                            <select id="cuenta_destino_id" class="form-control" required>
                                <option value="">Seleccionar cuenta...</option>
                                @foreach($cuentasBancarias ?? [] as $cuenta)
                                    <option value="{{ $cuenta->id }}" 
                                        data-moneda-id="{{ $cuenta->moneda_id }}" 
                                        data-moneda-simbolo="{{ $cuenta->moneda->simbolo ?? '$' }}">
                                        {{ $cuenta->banco->nombre ?? 'Sin banco' }} - {{ $cuenta->numero_cuenta }} 
                                        ({{ $cuenta->moneda->simbolo ?? '$' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Monto <span class="text-danger">*</span></label>
                            <input type="number" id="monto" class="form-control" step="0.01" required>
                            <small id="saldoOrigenInfo" class="text-muted"></small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Tipo de Cambio</label>
                            <input type="number" id="tipo_cambio" class="form-control" step="0.0001" value="1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Monto Destino</label>
                            <input type="text" id="monto_destino" class="form-control" readonly style="background-color: #e9ecef;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Moneda Origen</label>
                            <input type="text" id="moneda_origen_text" class="form-control" readonly style="background-color: #e9ecef;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Moneda Destino</label>
                            <input type="text" id="moneda_destino_text" class="form-control" readonly style="background-color: #e9ecef;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Referencia</label>
                            <input type="text" id="referencia" class="form-control" placeholder="Referencia del traspaso">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Referencia Bancaria</label>
                            <input type="text" id="referencia_bancaria" class="form-control" placeholder="Referencia bancaria">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Concepto</label>
                        <textarea id="concepto" class="form-control" rows="2" placeholder="Motivo del traspaso"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Observaciones</label>
                        <textarea id="observaciones" class="form-control" rows="2" placeholder="Observaciones adicionales"></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" id="aplicar_ahora" class="form-check-input" checked>
                        <label class="form-check-label">Aplicar traspaso inmediatamente (actualizar saldos)</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarTraspaso()" style="background-color: #083CAE;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .table th { 
        background-color: #2378e1 !important; 
        color: white; 
        font-size: 12px; 
        padding: 10px 4px; 
        white-space: nowrap; 
    }
    .table td { 
        font-size: 12px; 
        padding: 10px 4px; 
        white-space: nowrap; 
        vertical-align: middle;
    }
    #tablaBody tr:nth-child(odd) { background-color: #ffffff; }
    #tablaBody tr:nth-child(even) { background-color: #f8f9fa; }
    #tablaBody tr:hover { background-color: #e8f0fe; }
    .badge { 
        padding: 4px 8px; 
        border-radius: 4px; 
        font-size: 11px; 
        font-weight: 600; 
        display: inline-block;
    }
    .badge-pendiente { background-color: #fd7e14; color: white; }
    .badge-procesado { background-color: #2378e1; color: white; }
    .badge-completado { background-color: #28a745; color: white; }
    .badge-cancelado { background-color: #dc3545; color: white; }
    .action-icons i { 
        font-size: 14px; 
        cursor: pointer; 
        margin: 0 3px;
        transition: transform 0.2s;
    }
    .action-icons i:hover { transform: scale(1.1); }
    .fa-edit { color: #ffc107; }
    .fa-trash-alt { color: #dc3545; }
    .fa-eye { color: #17a2b8; }
    .fa-check-circle { color: #28a745; }
    .fa-print { color: #6c757d; }
    [draggable="true"] { cursor: grab; user-select: none; }
    [draggable="true"]:active { cursor: grabbing; }
    .modal { z-index: 99999 !important; }
    .modal-backdrop { z-index: 99990 !important; }
    .btn:active { transform: scale(0.98); }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Token CSRF
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

// Variables globales
let datosOriginales = [];
let currentPage = 1;
let rowsPerPage = 8;
let columnasAgrupadas = [];
let expandedGroups = new Set();

// Funciones de utilidad
function formatCurrency(amount) {
    if (isNaN(amount) || amount === null) amount = 0;
    return '$' + Number(amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('es-MX');
}

function getBadgeClass(estatus) {
    const badges = {
        'pendiente': 'badge-pendiente',
        'procesado': 'badge-procesado',
        'completado': 'badge-completado',
        'cancelado': 'badge-cancelado'
    };
    return badges[estatus] || 'badge-pendiente';
}

function getEstatusTexto(estatus) {
    const textos = {
        'pendiente': 'Pendiente',
        'procesado': 'Procesado',
        'completado': 'Completado',
        'cancelado': 'Cancelado'
    };
    return textos[estatus] || estatus;
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function mostrarNotificacion(mensaje, tipo) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${tipo} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    alertDiv.style.zIndex = '99999';
    alertDiv.style.minWidth = '300px';
    alertDiv.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 3000);
}

// Funciones del formulario
function mostrarMonedas() {
    const origenSelect = document.getElementById('cuenta_origen_id');
    const destinoSelect = document.getElementById('cuenta_destino_id');
    
    if (origenSelect && origenSelect.selectedOptions[0]) {
        const monedaSimbolo = origenSelect.selectedOptions[0].dataset.monedaSimbolo || '$';
        document.getElementById('moneda_origen_text').value = monedaSimbolo;
    }
    
    if (destinoSelect && destinoSelect.selectedOptions[0]) {
        const monedaSimbolo = destinoSelect.selectedOptions[0].dataset.monedaSimbolo || '$';
        document.getElementById('moneda_destino_text').value = monedaSimbolo;
    }
}

function mostrarSaldoOrigen() {
    const origenSelect = document.getElementById('cuenta_origen_id');
    if (origenSelect && origenSelect.selectedOptions[0]) {
        const saldo = parseFloat(origenSelect.selectedOptions[0].dataset.saldo);
        if (!isNaN(saldo)) {
            const saldoInfo = document.getElementById('saldoOrigenInfo');
            saldoInfo.innerHTML = `Saldo disponible: ${formatCurrency(saldo)}`;
            saldoInfo.style.color = saldo >= 0 ? '#28a745' : '#dc3545';
        }
    } else {
        document.getElementById('saldoOrigenInfo').innerHTML = '';
    }
}

function obtenerTipoCambio() {
    const origenSelect = document.getElementById('cuenta_origen_id');
    const destinoSelect = document.getElementById('cuenta_destino_id');
    
    if (!origenSelect?.selectedOptions[0] || !destinoSelect?.selectedOptions[0]) return;
    
    const monedaOrigenId = origenSelect.selectedOptions[0].dataset.monedaId;
    const monedaDestinoId = destinoSelect.selectedOptions[0].dataset.monedaId;
    const fecha = document.getElementById('fecha').value;
    
    if (!monedaOrigenId || !monedaDestinoId) return;
    
    fetch(`/admin/api/tipo-cambio?moneda_origen_id=${monedaOrigenId}&moneda_destino_id=${monedaDestinoId}&fecha=${fecha}`, {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('tipo_cambio').value = data.tipo_cambio || 1;
        calcularMontoDestino();
    })
    .catch(error => console.error('Error al obtener tipo de cambio:', error));
}

function calcularMontoDestino() {
    const monto = parseFloat(document.getElementById('monto').value) || 0;
    const tipoCambio = parseFloat(document.getElementById('tipo_cambio').value) || 1;
    const montoDestino = monto * tipoCambio;
    document.getElementById('monto_destino').value = formatCurrency(montoDestino);
}

function abrirModalTraspaso() {
    document.getElementById('traspaso_id').value = '';
    document.getElementById('fecha').value = new Date().toISOString().split('T')[0];
    document.getElementById('cuenta_origen_id').value = '';
    document.getElementById('cuenta_destino_id').value = '';
    document.getElementById('proyecto_id').value = '';
    document.getElementById('monto').value = '';
    document.getElementById('tipo_cambio').value = '1';
    document.getElementById('monto_destino').value = '';
    document.getElementById('referencia').value = '';
    document.getElementById('referencia_bancaria').value = '';
    document.getElementById('concepto').value = '';
    document.getElementById('observaciones').value = '';
    document.getElementById('aplicar_ahora').checked = true;
    document.getElementById('moneda_origen_text').value = '';
    document.getElementById('moneda_destino_text').value = '';
    document.getElementById('saldoOrigenInfo').innerHTML = '';
    new bootstrap.Modal(document.getElementById('modalTraspaso')).show();
}

function guardarTraspaso() {
    const id = document.getElementById('traspaso_id').value;
    const data = {
        fecha: document.getElementById('fecha').value,
        cuenta_origen_id: document.getElementById('cuenta_origen_id').value,
        cuenta_destino_id: document.getElementById('cuenta_destino_id').value,
        proyecto_id: document.getElementById('proyecto_id').value || null,
        monto: document.getElementById('monto').value,
        tipo_cambio: document.getElementById('tipo_cambio').value,
        concepto: document.getElementById('concepto').value,
        referencia: document.getElementById('referencia').value,
        referencia_bancaria: document.getElementById('referencia_bancaria').value,
        observaciones: document.getElementById('observaciones').value,
        aplicar_ahora: document.getElementById('aplicar_ahora').checked
    };
    
    const url = id ? `/admin/api/traspasos/${id}` : '/admin/api/traspasos';
    const method = id ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        credentials: 'same-origin',
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            mostrarNotificacion(result.message, 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalTraspaso')).hide();
            cargarTraspasos();
        } else {
            mostrarNotificacion(result.message || 'Error al guardar', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('Error al guardar', 'danger');
    });
}

function editarTraspaso(id) {
    fetch(`/admin/api/traspasos/${id}`, {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(traspaso => {
        document.getElementById('traspaso_id').value = traspaso.id;
        document.getElementById('fecha').value = traspaso.fecha;
        document.getElementById('cuenta_origen_id').value = traspaso.cuenta_origen_id;
        document.getElementById('cuenta_destino_id').value = traspaso.cuenta_destino_id;
        document.getElementById('proyecto_id').value = traspaso.proyecto_id || '';
        document.getElementById('monto').value = traspaso.monto;
        document.getElementById('tipo_cambio').value = traspaso.tipo_cambio;
        document.getElementById('monto_destino').value = formatCurrency(traspaso.monto_destino);
        document.getElementById('referencia').value = traspaso.referencia || '';
        document.getElementById('referencia_bancaria').value = traspaso.referencia_bancaria || '';
        document.getElementById('concepto').value = traspaso.concepto || '';
        document.getElementById('observaciones').value = traspaso.observaciones || '';
        document.getElementById('aplicar_ahora').checked = false;
        mostrarMonedas();
        mostrarSaldoOrigen();
        new bootstrap.Modal(document.getElementById('modalTraspaso')).show();
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('Error al cargar el traspaso', 'danger');
    });
}

function eliminarTraspaso(id) {
    if (confirm('¿Estás seguro de eliminar este traspaso?')) {
        fetch(`/admin/api/traspasos/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarTraspasos();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al eliminar', 'danger');
        });
    }
}

function aplicarTraspaso(id) {
    if (confirm('¿Aplicar este traspaso? Se actualizarán los saldos de ambas cuentas.')) {
        fetch(`/admin/api/traspasos/${id}/aplicar`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarTraspasos();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al aplicar', 'danger');
        });
    }
}

function verDetalle(id) {
    fetch(`/admin/api/traspasos/${id}`, {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(traspaso => {
        let mensaje = `📋 DETALLES DEL TRASPASO\n`;
        mensaje += `━━━━━━━━━━━━━━━━━━━━━━━━━\n`;
        mensaje += `Folio: ${traspaso.folio}\n`;
        mensaje += `Fecha: ${formatDate(traspaso.fecha)}\n`;
        mensaje += `Cuenta Origen: ${traspaso.cuenta_origen?.banco?.nombre} - ${traspaso.cuenta_origen?.numero_cuenta}\n`;
        mensaje += `Cuenta Destino: ${traspaso.cuenta_destino?.banco?.nombre} - ${traspaso.cuenta_destino?.numero_cuenta}\n`;
        mensaje += `Monto: ${formatCurrency(traspaso.monto)}\n`;
        mensaje += `Tipo Cambio: ${traspaso.tipo_cambio}\n`;
        mensaje += `Monto Destino: ${formatCurrency(traspaso.monto_destino)}\n`;
        mensaje += `Estatus: ${getEstatusTexto(traspaso.estatus)}\n`;
        mensaje += `Concepto: ${traspaso.concepto || 'N/A'}\n`;
        mensaje += `Referencia: ${traspaso.referencia || 'N/A'}\n`;
        mensaje += `Referencia Bancaria: ${traspaso.referencia_bancaria || 'N/A'}`;
        alert(mensaje);
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('Error al cargar detalles', 'danger');
    });
}

function imprimirTraspaso(id) {
    mostrarNotificacion('Preparando impresión...', 'info');
    // Implementar impresión
    window.open(`/admin/traspasos/${id}/print`, '_blank');
}

function exportarExcel() {
    if (!datosOriginales || datosOriginales.length === 0) {
        mostrarNotificacion('No hay datos para exportar', 'warning');
        return;
    }
    
    let csv = "\uFEFFFolio,Fecha,Cuenta Origen,Cuenta Destino,Monto,Moneda,Tipo Cambio,Monto Destino,Estatus\n";
    datosOriginales.forEach(item => {
        csv += `"${item.folio}","${formatDate(item.fecha)}","${item.banco_origen} - ${item.cuenta_origen}","${item.banco_destino} - ${item.cuenta_destino}",${item.monto},"${item.moneda_origen}",${item.tipo_cambio},${item.monto_destino},"${getEstatusTexto(item.estatus)}"\n`;
    });
    
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.href = url;
    link.setAttribute('download', 'traspasos.csv');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
    mostrarNotificacion('Exportación completada', 'success');
}

function cargarTraspasos() {
    fetch('/admin/api/traspasos', {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        return response.json();
    })
    .then(data => {
        console.log('Datos recibidos:', data);
        
        if (!Array.isArray(data)) {
            console.error('Los datos no son un array:', data);
            document.getElementById('tablaBody').innerHTML = '<tr><td colspan="10" class="text-center text-danger">Error: Formato de datos incorrecto</td></tr>';
            return;
        }
        
        datosOriginales = data.map(d => ({
            id: d.id,
            folio: d.folio || '-',
            fecha: d.fecha,
            cuenta_origen: d.cuenta_origen?.numero_cuenta || '-',
            banco_origen: d.cuenta_origen?.banco?.nombre || '-',
            cuenta_destino: d.cuenta_destino?.numero_cuenta || '-',
            banco_destino: d.cuenta_destino?.banco?.nombre || '-',
            monto: parseFloat(d.monto) || 0,
            moneda_origen: d.moneda_origen?.simbolo || d.cuenta_origen?.moneda?.simbolo || '$',
            tipo_cambio: parseFloat(d.tipo_cambio) || 1,
            monto_destino: parseFloat(d.monto_destino) || 0,
            estatus: d.estatus || 'pendiente'
        }));
        
        cargarTabla(datosOriginales);
        
        // Actualizar contadores
        const total = datosOriginales.length;
        const completados = datosOriginales.filter(d => d.estatus === 'completado').length;
        const pendientes = datosOriginales.filter(d => d.estatus === 'pendiente').length;
        
        document.getElementById('totalRegistros').textContent = total;
        document.getElementById('totalCompletados').textContent = completados;
        document.getElementById('totalPendientes').textContent = pendientes;
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('tablaBody').innerHTML = `<tr><td colspan="10" class="text-center text-danger">Error al cargar datos: ${error.message}</td></tr>`;
    });
}

function cargarTabla(datos) {
    const tablaBody = document.getElementById('tablaBody');
    
    if (!datos || datos.length === 0) {
        tablaBody.innerHTML = '<tr><td colspan="10" class="text-center">No hay registros</td></tr>';
        document.getElementById('sumMonto').textContent = formatCurrency(0);
        return;
    }
    
    const start = (currentPage - 1) * rowsPerPage;
    const pageData = datos.slice(start, start + rowsPerPage);
    let totalMonto = 0;
    
    tablaBody.innerHTML = pageData.map(item => {
        totalMonto += item.monto;
        return `
            <tr>
                <td>${escapeHtml(item.folio)}</td>
                <td>${formatDate(item.fecha)}</td>
                <td>${escapeHtml(item.banco_origen)} - ${escapeHtml(item.cuenta_origen)}</td>
                <td>${escapeHtml(item.banco_destino)} - ${escapeHtml(item.cuenta_destino)}</td>
                <td class="text-end">${formatCurrency(item.monto)} ${escapeHtml(item.moneda_origen)}</td>
                <td>${item.tipo_cambio.toFixed(4)}</td>
                <td class="text-end">${formatCurrency(item.monto_destino)}</td>
                <td><span class="badge ${getBadgeClass(item.estatus)}">${getEstatusTexto(item.estatus)}</span></td>
                <td style="position: sticky; right: 0; background: white; z-index: 1;">
                    <div class="action-icons text-nowrap">
                        <i class="fas fa-eye" onclick="verDetalle(${item.id})" title="Ver" style="cursor:pointer;"></i>
                        ${item.estatus === 'pendiente' ? 
                            `<i class="fas fa-edit" onclick="editarTraspaso(${item.id})" title="Editar" style="cursor:pointer;"></i>
                             <i class="fas fa-trash-alt" onclick="eliminarTraspaso(${item.id})" title="Eliminar" style="cursor:pointer;"></i>
                             <i class="fas fa-check-circle" onclick="aplicarTraspaso(${item.id})" title="Aplicar" style="cursor:pointer;"></i>` : 
                            `<i class="fas fa-check-circle" style="color:#28a745" title="Completado"></i>`
                        }
                        <i class="fas fa-print" onclick="imprimirTraspaso(${item.id})" title="Imprimir" style="cursor:pointer;"></i>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
    
    document.getElementById('sumMonto').textContent = formatCurrency(totalMonto);
    actualizarPaginacion(datos.length);
}

function actualizarPaginacion(total) {
    const totalPages = Math.ceil(total / rowsPerPage);
    document.getElementById('paginaActual').textContent = currentPage;
    const start = (currentPage - 1) * rowsPerPage + 1;
    const end = Math.min(currentPage * rowsPerPage, total);
    document.getElementById('paginacionInfo').textContent = `Mostrando ${start}-${end} de ${total} registros`;
}

function filtrarPorFecha() {
    const fechaInicio = document.getElementById('fechaInicio').value;
    const fechaFin = document.getElementById('fechaFin').value;
    
    let filtrados = datosOriginales;
    
    if (fechaInicio) {
        filtrados = filtrados.filter(item => item.fecha >= fechaInicio);
    }
    if (fechaFin) {
        filtrados = filtrados.filter(item => item.fecha <= fechaFin);
    }
    
    currentPage = 1;
    cargarTabla(filtrados);
}

// Event listeners
document.addEventListener('DOMContentLoaded', () => {
    cargarTraspasos();
    
    document.getElementById('btnAgregar')?.addEventListener('click', abrirModalTraspaso);
    document.getElementById('btnExcel')?.addEventListener('click', exportarExcel);
    document.getElementById('btnPrimera')?.addEventListener('click', () => { currentPage = 1; cargarTabla(datosOriginales); });
    document.getElementById('btnAnterior')?.addEventListener('click', () => { if(currentPage > 1) { currentPage--; cargarTabla(datosOriginales); } });
    document.getElementById('btnSiguiente')?.addEventListener('click', () => { const total = Math.ceil(datosOriginales.length / rowsPerPage); if(currentPage < total) { currentPage++; cargarTabla(datosOriginales); } });
    document.getElementById('btnUltima')?.addEventListener('click', () => { currentPage = Math.ceil(datosOriginales.length / rowsPerPage); cargarTabla(datosOriginales); });
    document.getElementById('buscador')?.addEventListener('input', e => {
        const busqueda = e.target.value.toLowerCase();
        const filtrados = datosOriginales.filter(item => 
            item.folio?.toLowerCase().includes(busqueda) ||
            item.cuenta_origen?.toLowerCase().includes(busqueda) ||
            item.cuenta_destino?.toLowerCase().includes(busqueda) ||
            item.banco_origen?.toLowerCase().includes(busqueda) ||
            item.banco_destino?.toLowerCase().includes(busqueda)
        );
        currentPage = 1;
        cargarTabla(filtrados);
    });
    document.getElementById('fechaInicio')?.addEventListener('change', filtrarPorFecha);
    document.getElementById('fechaFin')?.addEventListener('change', filtrarPorFecha);
    
    // Event listeners del formulario
    document.getElementById('cuenta_origen_id')?.addEventListener('change', () => {
        mostrarMonedas();
        mostrarSaldoOrigen();
        obtenerTipoCambio();
    });
    document.getElementById('cuenta_destino_id')?.addEventListener('change', () => {
        mostrarMonedas();
        obtenerTipoCambio();
    });
    document.getElementById('monto')?.addEventListener('input', calcularMontoDestino);
    document.getElementById('fecha')?.addEventListener('change', obtenerTipoCambio);
    document.getElementById('tipo_cambio')?.addEventListener('input', calcularMontoDestino);
});
</script>
@endsection