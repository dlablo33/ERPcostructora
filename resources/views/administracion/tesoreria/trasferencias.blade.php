@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Cheques Transferencias -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Cheques y Transferencias
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE RESUMEN -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Total Registros</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalRegistrosCard">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Activos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalActivos">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Completados</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalCompletados">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Cancelados</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalCancelados">0</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar" id="iconoAgrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 30px;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div><input type="date" id="fechaInicio" class="form-control" style="width: 140px;"></div>
                        <div><input type="date" id="fechaFin" class="form-control" style="width: 140px;"></div>
                        <div><button id="btnAgregar" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px;"><i class="fas fa-plus" style="color: #083CAE;"></i></button></div>
                        <div><button id="btnExcel" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px;"><i class="fas fa-file-excel" style="color: #083CAE;"></i> Excel</button></div>
                        <div><button id="btnColumnas" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px;"><i class="fas fa-columns" style="color: #083CAE;"></i> Columnas</button></div>
                        <div style="position: relative;"><i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i><input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; width: 200px;"></div>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaChequesTransferencias" style="width: 100%; font-size: 12px;">
                        <thead style="background-color: #2378e1; color: white;">
                            <tr>
                                <th draggable="true" data-columna="estatus">Estatus</th>
                                <th draggable="true" data-columna="folio">Folio</th>
                                <th draggable="true" data-columna="proveedor">Proveedor/Contacto</th>
                                <th draggable="true" data-columna="forma_pago">Forma de Pago</th>
                                <th draggable="true" data-columna="cuenta">Cuenta Bancaria</th>
                                <th draggable="true" data-columna="fecha">Fecha</th>
                                <th draggable="true" data-columna="referencia">Referencia</th>
                                <th draggable="true" data-columna="ref_bancaria">Referencia Bancaria</th>
                                <th draggable="true" data-columna="monto">Monto</th>
                                <th draggable="true" data-columna="monto_restante">Monto Restante</th>
                                <th draggable="true" data-columna="moneda">Moneda</th>
                                <th draggable="true" data-columna="descripcion">Descripción</th>
                                <th style="position: sticky; right: 0; background-color: #2378e1;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="13" style="text-align: center;">Cargando...<\/td></tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr><td colspan="8" style="text-align: center;">Totales:</td><td style="text-align: right;" id="sumMonto">$0.00<\/td><td style="text-align: right;" id="sumMontoRestante">$0.00<\/td><td colspan="2"><\/td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <button id="btnCrearFiltro" style="background: transparent; border: none; color: #2378e1;"><i class="fas fa-filter"></i> Crear filtro</button>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <button id="btnPrimera" style="background: none; border: none; color: #2378e1;"><i class="fas fa-angle-double-left"></i></button>
                        <button id="btnAnterior" style="background: none; border: none; color: #2378e1;"><i class="fas fa-angle-left"></i></button>
                        <span id="paginaActual" style="background-color: #2378e1; color: white; padding: 5px 10px; border-radius: 4px;">1</span>
                        <button id="btnSiguiente" style="background: none; border: none; color: #2378e1;"><i class="fas fa-angle-right"></i></button>
                        <button id="btnUltima" style="background: none; border: none; color: #2378e1;"><i class="fas fa-angle-double-right"></i></button>
                        <span id="paginacionInfo" style="color: #2378e1; margin-left: 10px;">Mostrando 0-0 de 0 registros</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Cheque/Transferencia -->
<div class="modal fade" id="modalChequeTransferencia" tabindex="-1" style="z-index: 99999 !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-exchange-alt"></i> Nuevo Cheque/Transferencia</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formChequeTransferencia">
                    <input type="hidden" id="cheque_id">
                    <input type="hidden" id="proveedor_id">
                    <input type="hidden" id="contacto_id">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Fecha <span class="text-danger">*</span></label>
                            <input type="date" id="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Forma de Pago <span class="text-danger">*</span></label>
                            <select id="forma_pago" class="form-control" required>
                                <option value="transferencia">Transferencia</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Proveedor / Contacto <span class="text-danger">*</span></label>
                            <select id="entidad_select" class="form-control select2" required style="width: 100%;">
                                <option value="">Seleccionar proveedor o contacto...</option>
                                <optgroup label="📦 PROVEEDORES">
                                    @foreach($proveedores ?? [] as $proveedor)
                                        <option value="prov_{{ $proveedor->id }}" 
                                            data-nombre="{{ $proveedor->nombre }}"
                                            data-rfc="{{ $proveedor->rfc ?? '' }}"
                                            data-tipo="proveedor">
                                            {{ $proveedor->nombre }} - {{ $proveedor->rfc ?? 'Sin RFC' }}
                                        </option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="👥 CLIENTES / CONTACTOS">
                                    @foreach($contactos ?? [] as $contacto)
                                        <option value="cont_{{ $contacto->id }}" 
                                            data-nombre="{{ $contacto->nombre }}"
                                            data-rfc="{{ $contacto->rfc ?? '' }}"
                                            data-tipo="contacto">
                                            {{ $contacto->nombre }} - {{ $contacto->rfc ?? 'Sin RFC' }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nombre / Razón Social</label>
                            <input type="text" id="proveedor_nombre" class="form-control" readonly style="background-color: #e9ecef;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>RFC</label>
                            <input type="text" id="rfc" class="form-control" readonly style="background-color: #e9ecef;">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Cuenta Bancaria <span class="text-danger">*</span></label>
                            <select id="cuenta_bancaria_id" class="form-control" required>
                                <option value="">Seleccionar cuenta...</option>
                                @foreach($cuentasBancarias ?? [] as $cuenta)
                                    <option value="{{ $cuenta->id }}">{{ $cuenta->banco->nombre ?? 'Sin banco' }} - {{ $cuenta->numero_cuenta }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Moneda <span class="text-danger">*</span></label>
                            <select id="moneda_id" class="form-control" required>
                                <option value="">Seleccionar moneda...</option>
                                @foreach($monedas ?? [] as $moneda)
                                    <option value="{{ $moneda->id }}">{{ $moneda->nombre }} ({{ $moneda->simbolo }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Monto <span class="text-danger">*</span></label>
                            <input type="number" id="monto" class="form-control" step="0.01" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Referencia</label>
                            <input type="text" id="referencia" class="form-control">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Referencia Bancaria</label>
                            <input type="text" id="referencia_bancaria" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Proyecto</label>
                            <select id="proyecto_id" class="form-control">
                                <option value="">Ninguno</option>
                                @foreach($proyectos ?? [] as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- Campo Código SAT -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Código SAT <span class="text-danger">*</span></label>
                            <select id="codigo_sat_id" class="form-control" required>
                                <option value="">Seleccionar código SAT...</option>
                                @foreach($codigosSatGastos ?? [] as $codigo)
                                    <option value="{{ $codigo->id }}" 
                                        data-codigo="{{ $codigo->codigo_agrupador }}"
                                        data-nombre="{{ $codigo->nombre_cuenta }}">
                                        {{ $codigo->codigo_agrupador }} - {{ $codigo->nombre_cuenta }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted" id="codigo_sat_info">
                                <i class="fas fa-info-circle"></i> Selecciona el código SAT para este egreso
                            </small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label>Descripción</label>
                        <textarea id="descripcion" class="form-control" rows="2"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label>Observaciones</label>
                        <textarea id="observaciones" class="form-control" rows="2"></textarea>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input type="checkbox" id="aplicar_ahora" class="form-check-input" checked>
                        <label class="form-check-label">Aplicar inmediatamente (crear movimiento bancario)</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarChequeTransferencia()" style="background-color: #083CAE;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-card { transition: transform 0.2s; }
    .custom-card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(8,60,174,0.15); }
    .table th { background-color: #2378e1 !important; color: white; font-size: 12px; padding: 10px 4px; white-space: nowrap; }
    .table td { font-size: 12px; padding: 10px 4px; white-space: nowrap; }
    #tablaBody tr:nth-child(odd) { background-color: #ffffff; }
    #tablaBody tr:nth-child(even) { background-color: #f2f2f2; }
    #tablaBody tr:hover { background-color: #e0e0e0; }
    .badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
    .badge-activo { background-color: #28a745; color: white; }
    .badge-completado { background-color: #2378e1; color: white; }
    .badge-cancelado { background-color: #dc3545; color: white; }
    .badge-pendiente { background-color: #fd7e14; color: white; }
    .action-icons i { font-size: 14px; cursor: pointer; margin: 0 3px; }
    .fa-edit { color: #ffc107; }
    .fa-trash-alt { color: #dc3545; }
    .fa-eye { color: #17a2b8; }
    .fa-check-circle { color: #28a745; }
    .fa-file-pdf { color: #dc3545; }
    [draggable="true"] { cursor: grab; }
    .columna-agrupada { display: inline-flex; align-items: center; padding: 4px 10px; background-color: #f0f4ff; border-radius: 16px; color: #2378e1; font-size: 12px; margin: 2px; border: 1px solid #2378e1; }
    .columna-agrupada .remover { margin-left: 6px; cursor: pointer; font-weight: bold; }
    .fila-grupo { background-color: #f0f7ff !important; font-weight: 500; cursor: pointer; }
    .fila-detalle td:first-child { padding-left: 30px !important; }
    tfoot td { font-weight: bold; background-color: #e9ecef !important; border-top: 2px solid #083CAE; }
    .modal { z-index: 99999 !important; }
    .modal-backdrop { z-index: 99990 !important; }
    .select2-container { z-index: 100000 !important; }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

let columnasAgrupadas = [];
let expandedGroups = new Set();
let datosOriginales = [];
let currentPage = 1;
let rowsPerPage = 5;

// Inicializar Select2
$(document).ready(function() {
    $('#entidad_select').select2({
        dropdownParent: $('#modalChequeTransferencia'),
        placeholder: 'Buscar proveedor o contacto...',
        allowClear: true,
        width: '100%'
    });
});

function formatCurrency(amount) {
    return '$' + Number(amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('es-MX');
}

function getBadgeClass(estatus) {
    if (estatus === 'activo') return 'badge-activo';
    if (estatus === 'completado') return 'badge-completado';
    if (estatus === 'cancelado') return 'badge-cancelado';
    return 'badge-pendiente';
}

function getEstatusTexto(estatus) {
    if (estatus === 'activo') return 'Activo';
    if (estatus === 'completado') return 'Completado';
    if (estatus === 'cancelado') return 'Cancelado';
    return estatus || 'Pendiente';
}

function actualizarContadores(datos) {
    document.getElementById('totalRegistrosCard').textContent = datos.length;
    document.getElementById('totalActivos').textContent = datos.filter(d => d.estatus === 'activo').length;
    document.getElementById('totalCompletados').textContent = datos.filter(d => d.estatus === 'completado').length;
    document.getElementById('totalCancelados').textContent = datos.filter(d => d.estatus === 'cancelado').length;
}

function cargarChequesTransferencias() {
    fetch('/admin/api/cheques-transferencias', {
        headers: { 
            'Accept': 'application/json', 
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('HTTP error ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.error) {
            throw new Error(data.error);
        }
        datosOriginales = data.map(d => ({
            id: d.id,
            folio: d.folio,
            estatus: d.estatus,
            proveedor: d.proveedor,
            forma_pago: d.forma_pago === 'cheque' ? 'Cheque' : 'Transferencia',
            cuenta: d.cuenta_bancaria?.numero_cuenta || '-',
            fecha: d.fecha,
            referencia: d.referencia || '-',
            referencia_bancaria: d.referencia_bancaria || '-',
            monto: parseFloat(d.monto) || 0,
            monto_restante: parseFloat(d.monto_restante) || 0,
            moneda: d.moneda?.simbolo || '-',
            descripcion: d.descripcion || '-'
        }));
        cargarTabla(datosOriginales);
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('tablaBody').innerHTML = '<tr><td colspan="13" style="color:red; text-align:center;">Error al cargar datos: ' + error.message + '</td></tr>';
        mostrarNotificacion('Error al cargar datos: ' + error.message, 'danger');
    });
}

function actualizarEntidadSeleccionada() {
    const select = document.getElementById('entidad_select');
    const selectedOption = select.options[select.selectedIndex];
    
    if (!selectedOption || !selectedOption.value) {
        document.getElementById('proveedor_nombre').value = '';
        document.getElementById('rfc').value = '';
        document.getElementById('proveedor_id').value = '';
        document.getElementById('contacto_id').value = '';
        return;
    }
    
    const nombre = selectedOption.getAttribute('data-nombre') || '';
    const rfc = selectedOption.getAttribute('data-rfc') || '';
    const tipo = selectedOption.getAttribute('data-tipo') || '';
    const valor = selectedOption.value;
    const id = valor.split('_')[1];
    
    document.getElementById('proveedor_nombre').value = nombre;
    document.getElementById('rfc').value = rfc;
    
    if (tipo === 'proveedor') {
        document.getElementById('proveedor_id').value = id;
        document.getElementById('contacto_id').value = '';
    } else {
        document.getElementById('proveedor_id').value = '';
        document.getElementById('contacto_id').value = id;
    }
}

function abrirModalChequeTransferencia() {
    document.getElementById('cheque_id').value = '';
    document.getElementById('fecha').value = new Date().toISOString().split('T')[0];
    document.getElementById('forma_pago').value = 'transferencia';
    
    // Limpiar select de entidad
    const entidadSelect = document.getElementById('entidad_select');
    if (entidadSelect) {
        entidadSelect.value = '';
        if (entidadSelect.select2) {
            entidadSelect.select2('val', '');
        }
    }
    
    document.getElementById('proveedor_nombre').value = '';
    document.getElementById('rfc').value = '';
    document.getElementById('proveedor_id').value = '';
    document.getElementById('contacto_id').value = '';
    document.getElementById('cuenta_bancaria_id').value = '';
    document.getElementById('moneda_id').value = '';
    document.getElementById('monto').value = '';
    document.getElementById('referencia').value = '';
    document.getElementById('referencia_bancaria').value = '';
    document.getElementById('proyecto_id').value = '';
    document.getElementById('descripcion').value = '';
    document.getElementById('observaciones').value = '';
    
    // Limpiar código SAT
    document.getElementById('codigo_sat_id').value = '';
    const infoSpan = document.getElementById('codigo_sat_info');
    if (infoSpan) {
        infoSpan.innerHTML = '<i class="fas fa-info-circle"></i> Selecciona el código SAT para este egreso';
        infoSpan.classList.remove('text-success', 'text-warning', 'text-danger');
        infoSpan.classList.add('text-muted');
    }
    
    const aplicarCheckbox = document.getElementById('aplicar_ahora');
    if (aplicarCheckbox) {
        aplicarCheckbox.checked = true;
    }
    
    new bootstrap.Modal(document.getElementById('modalChequeTransferencia')).show();
}

function editarChequeTransferencia(id) {
    fetch(`/admin/api/cheques-transferencias/${id}`, {
        headers: { 
            'Accept': 'application/json', 
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(item => {
        document.getElementById('cheque_id').value = item.id;
        document.getElementById('fecha').value = item.fecha;
        document.getElementById('forma_pago').value = item.forma_pago;
        
        // Seleccionar la entidad en el select
        const entidadSelect = document.getElementById('entidad_select');
        let valorSelect = '';
        if (item.proveedor_id) {
            valorSelect = `prov_${item.proveedor_id}`;
        } else if (item.contacto_id) {
            valorSelect = `cont_${item.contacto_id}`;
        }
        entidadSelect.value = valorSelect;
        if (entidadSelect.select2) {
            entidadSelect.select2('val', valorSelect);
        }
        
        // Forzar actualización de los campos
        const selectedOption = entidadSelect.options[entidadSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            document.getElementById('proveedor_nombre').value = selectedOption.getAttribute('data-nombre') || '';
            document.getElementById('rfc').value = selectedOption.getAttribute('data-rfc') || '';
            const tipo = selectedOption.getAttribute('data-tipo') || '';
            const idVal = selectedOption.value.split('_')[1];
            if (tipo === 'proveedor') {
                document.getElementById('proveedor_id').value = idVal;
                document.getElementById('contacto_id').value = '';
            } else {
                document.getElementById('proveedor_id').value = '';
                document.getElementById('contacto_id').value = idVal;
            }
        }
        
        document.getElementById('cuenta_bancaria_id').value = item.cuenta_bancaria_id;
        document.getElementById('moneda_id').value = item.moneda_id;
        document.getElementById('monto').value = item.monto;
        document.getElementById('referencia').value = item.referencia || '';
        document.getElementById('referencia_bancaria').value = item.referencia_bancaria || '';
        document.getElementById('proyecto_id').value = item.proyecto_id || '';
        document.getElementById('descripcion').value = item.descripcion || '';
        document.getElementById('observaciones').value = item.observaciones || '';
        
        // Cargar código SAT
        document.getElementById('codigo_sat_id').value = item.codigo_sat_id || '';
        
        // Actualizar info del código SAT
        const codigoSatSelect = document.getElementById('codigo_sat_id');
        const selectedOptionSat = codigoSatSelect.options[codigoSatSelect.selectedIndex];
        const infoSpan = document.getElementById('codigo_sat_info');
        if (selectedOptionSat && selectedOptionSat.value) {
            const codigo = selectedOptionSat.getAttribute('data-codigo') || '';
            const nombre = selectedOptionSat.getAttribute('data-nombre') || '';
            infoSpan.innerHTML = `<i class="fas fa-check-circle text-success"></i> Código SAT seleccionado: ${codigo} - ${nombre}`;
            infoSpan.classList.remove('text-muted');
            infoSpan.classList.add('text-success');
        }
        
        const aplicarCheckbox = document.getElementById('aplicar_ahora');
        if (aplicarCheckbox) {
            aplicarCheckbox.checked = false;
        }
        
        new bootstrap.Modal(document.getElementById('modalChequeTransferencia')).show();
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('Error al cargar datos para editar', 'danger');
    });
}

function guardarChequeTransferencia() {
    const id = document.getElementById('cheque_id').value;
    const codigoSatId = document.getElementById('codigo_sat_id').value;
    const entidadSelect = document.getElementById('entidad_select');
    const selectedOption = entidadSelect.options[entidadSelect.selectedIndex];
    const entidadTipo = selectedOption ? selectedOption.getAttribute('data-tipo') : null;
    const entidadValor = entidadSelect.value;
    const entidadId = entidadValor ? entidadValor.split('_')[1] : null;
    const proveedorNombre = document.getElementById('proveedor_nombre').value;
    
    // Validar entidad seleccionada
    if (!entidadValor) {
        mostrarNotificacion('Por favor seleccione un proveedor o contacto', 'warning');
        return;
    }
    
    // Validar código SAT
    if (!codigoSatId) {
        mostrarNotificacion('Por favor seleccione un código SAT', 'warning');
        return;
    }
    
    const data = {
        fecha: document.getElementById('fecha').value,
        forma_pago: document.getElementById('forma_pago').value,
        proveedor: proveedorNombre,
        rfc: document.getElementById('rfc').value,
        cuenta_bancaria_id: document.getElementById('cuenta_bancaria_id').value,
        moneda_id: document.getElementById('moneda_id').value,
        monto: document.getElementById('monto').value,
        referencia: document.getElementById('referencia').value,
        referencia_bancaria: document.getElementById('referencia_bancaria').value,
        proyecto_id: document.getElementById('proyecto_id').value || null,
        descripcion: document.getElementById('descripcion').value,
        observaciones: document.getElementById('observaciones').value,
        aplicar_ahora: document.getElementById('aplicar_ahora') ? document.getElementById('aplicar_ahora').checked : false,
        codigo_sat_id: codigoSatId
    };
    
    // Agregar el ID correspondiente según el tipo
    if (entidadTipo === 'proveedor') {
        data.proveedor_id = entidadId;
    } else if (entidadTipo === 'contacto') {
        data.contacto_id = entidadId;
    }
    
    const url = id ? `/admin/api/cheques-transferencias/${id}` : '/admin/api/cheques-transferencias';
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
            bootstrap.Modal.getInstance(document.getElementById('modalChequeTransferencia')).hide();
            cargarChequesTransferencias();
        } else {
            mostrarNotificacion(result.message || 'Error al guardar', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('Error al guardar: ' + error.message, 'danger');
    });
}

function eliminarChequeTransferencia(id) {
    if (confirm('¿Eliminar este registro?')) {
        fetch(`/admin/api/cheques-transferencias/${id}`, {
            method: 'DELETE',
            headers: { 
                'X-CSRF-TOKEN': csrfToken, 
                'Accept': 'application/json' 
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarChequesTransferencias();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        })
        .catch(error => mostrarNotificacion('Error al eliminar', 'danger'));
    }
}

function aplicarChequeTransferencia(id) {
    if (confirm('¿Aplicar este registro? Se actualizará el saldo de la cuenta bancaria.')) {
        fetch(`/admin/api/cheques-transferencias/${id}/aplicar`, {
            method: 'POST',
            headers: { 
                'X-CSRF-TOKEN': csrfToken, 
                'Accept': 'application/json' 
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarChequesTransferencias();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        })
        .catch(error => mostrarNotificacion('Error al aplicar', 'danger'));
    }
}

function verDetalle(id) {
    fetch(`/admin/api/cheques-transferencias/${id}`, {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(item => {
        const codigoSatNombre = item.codigo_sat?.codigo_agrupador + ' - ' + item.codigo_sat?.nombre_cuenta || 'No asignado';
        mostrarNotificacion(`
📄 Folio: ${item.folio}
🏢 Proveedor: ${item.proveedor}
💳 Forma de Pago: ${item.forma_pago === 'cheque' ? 'Cheque' : 'Transferencia'}
💰 Monto: ${formatCurrency(item.monto)}
💵 Monto Restante: ${formatCurrency(item.monto_restante)}
📅 Fecha: ${formatDate(item.fecha)}
🏷️ Código SAT: ${codigoSatNombre}
📝 Descripción: ${item.descripcion || 'N/A'}`, 'info');
    })
    .catch(error => mostrarNotificacion('Error al cargar detalle', 'danger'));
}

function mostrarNotificacion(mensaje, tipo) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${tipo} position-fixed top-0 end-0 m-3`;
    alertDiv.style.zIndex = '99999';
    alertDiv.style.minWidth = '300px';
    alertDiv.innerHTML = `${mensaje}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
    document.body.appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 3000);
}

function exportarExcel() {
    const tabla = document.getElementById('tablaChequesTransferencias').cloneNode(true);
    const link = document.createElement('a');
    link.href = 'data:application/vnd.ms-excel,' + encodeURIComponent(tabla.outerHTML);
    link.download = 'cheques_transferencias.xls';
    link.click();
}

function cargarTabla(datos) {
    const tablaBody = document.getElementById('tablaBody');
    actualizarContadores(datos);
    
    if (datos.length === 0) {
        tablaBody.innerHTML = '<tr><td colspan="13" style="text-align: center;">No hay registros<\/td></tr>';
        document.getElementById('sumMonto').textContent = formatCurrency(0);
        document.getElementById('sumMontoRestante').textContent = formatCurrency(0);
        return;
    }
    
    const start = (currentPage - 1) * rowsPerPage;
    const pageData = datos.slice(start, start + rowsPerPage);
    let totalMonto = 0, totalMontoRestante = 0;
    
    tablaBody.innerHTML = pageData.map(item => {
        totalMonto += item.monto;
        totalMontoRestante += item.monto_restante;
        return `
            <tr>
                <td><span class="badge ${getBadgeClass(item.estatus)}">${getEstatusTexto(item.estatus)}</span></td>
                <td>${item.folio || '-'}</td>
                <td>${escapeHtml(item.proveedor) || '-'}</td>
                <td>${item.forma_pago || '-'}</td>
                <td>${item.cuenta || '-'}</td>
                <td>${formatDate(item.fecha)}<\/td>
                <td>${item.referencia || '-'}</td>
                <td>${item.referencia_bancaria || '-'}</td>
                <td style="text-align:right;">${formatCurrency(item.monto)}<\/td>
                <td style="text-align:right;">${formatCurrency(item.monto_restante)}<\/td>
                <td>${item.moneda || '-'}</td>
                <td>${item.descripcion || '-'}</td>
                <td style="position:sticky;right:0;background:white;">
                    <div class="action-icons">
                        <i class="fas fa-edit" onclick="editarChequeTransferencia(${item.id})" title="Editar"></i>
                        <i class="fas fa-trash-alt" onclick="eliminarChequeTransferencia(${item.id})" title="Eliminar"></i>
                        ${item.estatus === 'activo' ? `<i class="fas fa-check-circle" onclick="aplicarChequeTransferencia(${item.id})" title="Aplicar"></i>` : ''}
                        <i class="fas fa-eye" onclick="verDetalle(${item.id})" title="Ver"></i>
                        <i class="fas fa-file-pdf" onclick="generarPDF(${item.id})" title="PDF"></i>
                    </div>
                <\/td>
            </tr>
        `;
    }).join('');
    
    document.getElementById('sumMonto').textContent = formatCurrency(totalMonto);
    document.getElementById('sumMontoRestante').textContent = formatCurrency(totalMontoRestante);
    actualizarPaginacion(datos.length);
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function actualizarPaginacion(total) {
    const totalPages = Math.ceil(total / rowsPerPage);
    document.getElementById('paginaActual').textContent = currentPage;
    document.getElementById('paginacionInfo').textContent = `Mostrando ${Math.min((currentPage-1)*rowsPerPage+1, total)}-${Math.min(currentPage*rowsPerPage, total)} de ${total} registros`;
}

function generarPDF(id) {
    mostrarNotificacion('Generando PDF...', 'info');
}

// Event listeners
document.getElementById('entidad_select')?.addEventListener('change', actualizarEntidadSeleccionada);
document.getElementById('btnAgregar')?.addEventListener('click', abrirModalChequeTransferencia);
document.getElementById('btnExcel')?.addEventListener('click', exportarExcel);
document.getElementById('btnPrimera')?.addEventListener('click', () => { currentPage = 1; cargarTabla(datosOriginales); });
document.getElementById('btnAnterior')?.addEventListener('click', () => { if(currentPage > 1) { currentPage--; cargarTabla(datosOriginales); } });
document.getElementById('btnSiguiente')?.addEventListener('click', () => { const total = Math.ceil(datosOriginales.length / rowsPerPage); if(currentPage < total) { currentPage++; cargarTabla(datosOriginales); } });
document.getElementById('btnUltima')?.addEventListener('click', () => { currentPage = Math.ceil(datosOriginales.length / rowsPerPage); cargarTabla(datosOriginales); });
document.getElementById('buscador')?.addEventListener('input', e => {
    const busqueda = e.target.value.toLowerCase();
    const filtrados = datosOriginales.filter(item => 
        item.proveedor?.toLowerCase().includes(busqueda) ||
        item.folio?.toLowerCase().includes(busqueda) ||
        item.descripcion?.toLowerCase().includes(busqueda)
    );
    currentPage = 1;
    cargarTabla(filtrados);
});

document.getElementById('fechaInicio')?.addEventListener('change', () => cargarChequesTransferencias());
document.getElementById('fechaFin')?.addEventListener('change', () => cargarChequesTransferencias());

document.addEventListener('DOMContentLoaded', () => {
    cargarChequesTransferencias();
});
</script>
@endsection