@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #2378e1; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Pagos
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
                        <div><input type="date" id="fechaInicio" class="form-control" style="width: 140px;"></div>
                        <div><input type="date" id="fechaFin" class="form-control" style="width: 140px;"></div>
                        <div><button id="btnAgregar" style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; width: 36px; height: 36px;"><i class="fas fa-plus" style="color: #2378e1;"></i></button></div>
                        <div><button id="btnExcel" style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px;"><i class="fas fa-file-excel" style="color: #2378e1;"></i> Excel</button></div>
                        <div><button id="btnColumnas" style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px;"><i class="fas fa-columns" style="color: #2378e1;"></i> Columnas</button></div>
                        <div style="position: relative;"><i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #2378e1;"></i><input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #2378e1; border-radius: 4px; width: 200px;"></div>
                    </div>
                </div>

                <!-- Contadores -->
                <div style="display: flex; gap: 20px; margin-bottom: 15px; padding: 10px; background: #e9ecef; border-radius: 8px;">
                    <div><strong>Total Registros:</strong> <span id="totalRegistros">0</span></div>
                    <div><strong>Completados:</strong> <span id="totalCompletados">0</span></div>
                    <div><strong>Pendientes:</strong> <span id="totalPendientes">0</span></div>
                </div>

                <!-- Tabla de Pagos -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaPagos" style="width: 100%; font-size: 12px;">
                        <thead style="background-color: #2378e1; color: white;">
                            <tr>
                                <th draggable="true" data-columna="folio">Folio</th>
                                <th draggable="true" data-columna="fecha_pago">Fecha</th>
                                <th draggable="true" data-columna="proveedor">Proveedor</th>
                                <th draggable="true" data-columna="concepto">Concepto</th>
                                <th draggable="true" data-columna="monto">Monto</th>
                                <th draggable="true" data-columna="metodo_pago">Método Pago</th>
                                <th draggable="true" data-columna="estatus">Estatus</th>
                                <th draggable="true" data-columna="factura">Factura</th>
                                <th style="position: sticky; right: 0; background-color: #2378e1;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="9" style="text-align: center;">Cargando...<\/td></tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr><td colspan="4" style="text-align: center;">Totales:</td><td style="text-align: right;" id="sumMonto">$0.00<\/td><td colspan="3">
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

<!-- Modal para Pago -->
<div class="modal fade" id="modalPago" tabindex="-1" style="z-index: 99999 !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-money-bill-wave"></i> Nuevo Pago</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formPago">
                    <input type="hidden" id="pago_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Fecha Pago <span class="text-danger">*</span></label>
                            <input type="date" id="fecha_pago" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Cuenta Bancaria <span class="text-danger">*</span></label>
                            <select id="cuenta_bancaria_id" class="form-control" required>
                                <option value="">Seleccionar cuenta...</option>
                                @foreach($cuentasBancarias ?? [] as $cuenta)
                                    <option value="{{ $cuenta->id }}">{{ $cuenta->banco->nombre ?? 'Sin banco' }} - {{ $cuenta->numero_cuenta }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Proveedor</label>
                            <select id="proveedor_id" class="form-control">
                                <option value="">Seleccionar proveedor...</option>
                                @foreach($proveedores ?? [] as $proveedor)
                                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }} - {{ $proveedor->rfc }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-1" onclick="abrirModalProveedor()" style="font-size: 11px;">+ Nuevo Proveedor</button>
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
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Monto <span class="text-danger">*</span></label>
                            <input type="number" id="monto" class="form-control" step="0.01" required>
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
                            <label>Tipo de Egreso <span class="text-danger">*</span></label>
                            <select id="tipo_egreso_id" class="form-control" required>
                                <option value="">Seleccionar tipo...</option>
                                @foreach($tiposEgreso ?? [] as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Categoría de Gasto</label>
                            <select id="categoria_gasto_id" class="form-control">
                                <option value="">Primero seleccione un tipo de egreso</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Método de Pago <span class="text-danger">*</span></label>
                            <select id="metodo_pago_id" class="form-control" required>
                                <option value="">Seleccionar método...</option>
                                @foreach($metodosPago ?? [] as $metodo)
                                    <option value="{{ $metodo->id }}">{{ $metodo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Factura</label>
                            <input type="text" id="factura" class="form-control" placeholder="Número de factura">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Referencia</label>
                            <input type="text" id="referencia" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Referencia Bancaria</label>
                            <input type="text" id="referencia_bancaria" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Concepto <span class="text-danger">*</span></label>
                        <textarea id="concepto" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Observaciones</label>
                        <textarea id="observaciones" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" id="aplicar_ahora" class="form-check-input" checked>
                        <label class="form-check-label">Aplicar pago inmediatamente (actualizar saldo)</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarPago()" style="background-color: #083CAE;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Proveedor (rápido) -->
<div class="modal fade" id="modalProveedor" tabindex="-1" style="z-index: 99999 !important;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-truck"></i> Nuevo Proveedor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formProveedor">
                    <div class="mb-3">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" id="prov_nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>RFC</label>
                        <input type="text" id="prov_rfc" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" id="prov_email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Teléfono</label>
                        <input type="text" id="prov_telefono" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Contacto</label>
                        <input type="text" id="prov_contacto" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarProveedorRapido()" style="background-color: #083CAE;">Guardar</button>
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
    .badge-pendiente { background-color: #fd7e14; color: white; }
    .badge-procesado { background-color: #2378e1; color: white; }
    .badge-completado { background-color: #28a745; color: white; }
    .badge-cancelado { background-color: #dc3545; color: white; }
    .badge-rechazado { background-color: #dc3545; color: white; }
    .action-icons i { font-size: 14px; cursor: pointer; margin: 0 3px; }
    .fa-edit { color: #ffc107; }
    .fa-trash-alt { color: #dc3545; }
    .fa-eye { color: #17a2b8; }
    .fa-check-circle { color: #28a745; }
    .fa-file-pdf { color: #dc3545; }
    .fa-print { color: #6c757d; }
    [draggable="true"] { cursor: grab; }
    .columna-agrupada { display: inline-flex; align-items: center; padding: 4px 10px; background-color: #f0f4ff; border-radius: 16px; color: #2378e1; font-size: 12px; margin: 2px; border: 1px solid #2378e1; }
    .columna-agrupada .remover { margin-left: 6px; cursor: pointer; font-weight: bold; }
    .fila-grupo { background-color: #f0f7ff !important; font-weight: 500; cursor: pointer; }
    .fila-detalle td:first-child { padding-left: 30px !important; }
    tfoot td { font-weight: bold; background-color: #e9ecef !important; border-top: 2px solid #2378e1; }
    .modal { z-index: 99999 !important; }
    .modal-backdrop { z-index: 99990 !important; }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

let columnasAgrupadas = [];
let expandedGroups = new Set();
let datosOriginales = [];
let currentPage = 1;
let rowsPerPage = 8;

function formatCurrency(amount) {
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
        'cancelado': 'badge-cancelado',
        'rechazado': 'badge-rechazado'
    };
    return badges[estatus] || 'badge-pendiente';
}

function getEstatusTexto(estatus) {
    const textos = {
        'pendiente': 'Pendiente',
        'procesado': 'Procesado',
        'completado': 'Completado',
        'cancelado': 'Cancelado',
        'rechazado': 'Rechazado'
    };
    return textos[estatus] || estatus;
}

// Función para cargar categorías por tipo de egreso
function cargarCategoriasPorTipoEgreso() {
    const tipoEgresoId = document.getElementById('tipo_egreso_id').value;
    const categoriaSelect = document.getElementById('categoria_gasto_id');
    
    if (!categoriaSelect) return;
    
    if (tipoEgresoId) {
        categoriaSelect.innerHTML = '<option value="">Cargando categorías...</option>';
        
        fetch(`/admin/api/categorias-por-tipo-egreso/${tipoEgresoId}`, {
            method: 'GET',
            headers: { 
                'Accept': 'application/json',
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
            categoriaSelect.innerHTML = '<option value="">Seleccionar categoría...</option>';
            if (data.length === 0) {
                categoriaSelect.innerHTML += '<option value="" disabled>No hay categorías disponibles</option>';
            } else {
                data.forEach(cat => {
                    categoriaSelect.innerHTML += `<option value="${cat.id}">${escapeHtml(cat.nombre)}</option>`;
                });
            }
            console.log('Categorías cargadas:', data.length);
        })
        .catch(error => {
            console.error('Error al cargar categorías:', error);
            categoriaSelect.innerHTML = '<option value="">Error al cargar categorías</option>';
            mostrarNotificacion('Error al cargar categorías: ' + error.message, 'danger');
        });
    } else {
        categoriaSelect.innerHTML = '<option value="">Primero seleccione un tipo de egreso</option>';
    }
}

function cargarPagos() {
    console.log('Cargando pagos...');
    fetch('/admin/api/pagos', {
        headers: { 
            'Accept': 'application/json', 
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) throw new Error('HTTP error ' + response.status);
        return response.json();
    })
    .then(data => {
        datosOriginales = data.map(d => ({
            id: d.id,
            folio: d.folio || '-',
            fecha_pago: d.fecha_pago,
            proveedor: d.proveedor?.nombre || d.proveedor_nombre || '-',
            concepto: d.concepto || '-',
            monto: parseFloat(d.monto) || 0,
            metodo_pago: d.metodo_pago?.nombre || '-',
            estatus: d.estatus || 'pendiente',
            factura: d.factura || '-'
        }));
        
        cargarTabla(datosOriginales);
        
        const total = data.length;
        const completados = data.filter(d => d.estatus === 'completado').length;
        const pendientes = data.filter(d => d.estatus === 'pendiente').length;
        
        const totalReg = document.getElementById('totalRegistros');
        const totalComp = document.getElementById('totalCompletados');
        const totalPend = document.getElementById('totalPendientes');
        
        if (totalReg) totalReg.textContent = total;
        if (totalComp) totalComp.textContent = completados;
        if (totalPend) totalPend.textContent = pendientes;
    })
    .catch(error => {
        console.error('Error:', error);
        const tablaBody = document.getElementById('tablaBody');
        if (tablaBody) {
            tablaBody.innerHTML = '<tr><td colspan="9" style="color:red; text-align:center;">Error al cargar datos: ' + error.message + '<\/td></td>';
        }
        mostrarNotificacion('Error al cargar datos: ' + error.message, 'danger');
    });
}

function abrirModalPago() {
    document.getElementById('pago_id').value = '';
    document.getElementById('fecha_pago').value = new Date().toISOString().split('T')[0];
    document.getElementById('cuenta_bancaria_id').value = '';
    document.getElementById('proveedor_id').value = '';
    document.getElementById('proyecto_id').value = '';
    document.getElementById('tipo_egreso_id').value = '';
    document.getElementById('categoria_gasto_id').innerHTML = '<option value="">Primero seleccione un tipo de egreso</option>';
    document.getElementById('metodo_pago_id').value = '';
    document.getElementById('moneda_id').value = '';
    document.getElementById('monto').value = '';
    document.getElementById('concepto').value = '';
    document.getElementById('referencia').value = '';
    document.getElementById('referencia_bancaria').value = '';
    document.getElementById('factura').value = '';
    document.getElementById('observaciones').value = '';
    document.getElementById('aplicar_ahora').checked = true;
    new bootstrap.Modal(document.getElementById('modalPago')).show();
}

function abrirModalProveedor() {
    document.getElementById('prov_nombre').value = '';
    document.getElementById('prov_rfc').value = '';
    document.getElementById('prov_email').value = '';
    document.getElementById('prov_telefono').value = '';
    document.getElementById('prov_contacto').value = '';
    new bootstrap.Modal(document.getElementById('modalProveedor')).show();
}

function guardarProveedorRapido() {
    const data = {
        nombre: document.getElementById('prov_nombre').value,
        rfc: document.getElementById('prov_rfc').value,
        email: document.getElementById('prov_email').value,
        telefono: document.getElementById('prov_telefono').value,
        contacto: document.getElementById('prov_contacto').value,
        activo: true
    };
    
    fetch('/admin/api/proveedores', {
        method: 'POST',
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
            mostrarNotificacion('Proveedor creado exitosamente', 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalProveedor')).hide();
            // Recargar select de proveedores
            cargarProveedores();
            document.getElementById('proveedor_id').value = result.data.id;
        } else {
            mostrarNotificacion(result.message, 'danger');
        }
    })
    .catch(error => mostrarNotificacion('Error al guardar proveedor', 'danger'));
}

function cargarProveedores() {
    fetch('/admin/api/proveedores', {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        const select = document.getElementById('proveedor_id');
        select.innerHTML = '<option value="">Seleccionar proveedor...</option>';
        data.forEach(prov => {
            select.innerHTML += `<option value="${prov.id}">${prov.nombre} - ${prov.rfc || 'Sin RFC'}</option>`;
        });
    });
}

function editarPago(id) {
    fetch(`/admin/api/pagos/${id}`, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(pago => {
        document.getElementById('pago_id').value = pago.id;
        document.getElementById('fecha_pago').value = pago.fecha_pago;
        document.getElementById('cuenta_bancaria_id').value = pago.cuenta_bancaria_id;
        document.getElementById('proveedor_id').value = pago.proveedor_id || '';
        document.getElementById('proyecto_id').value = pago.proyecto_id || '';
        document.getElementById('tipo_egreso_id').value = pago.tipo_egreso_id;
        document.getElementById('metodo_pago_id').value = pago.metodo_pago_id;
        document.getElementById('moneda_id').value = pago.moneda_id;
        document.getElementById('monto').value = pago.monto;
        document.getElementById('concepto').value = pago.concepto;
        document.getElementById('referencia').value = pago.referencia || '';
        document.getElementById('referencia_bancaria').value = pago.referencia_bancaria || '';
        document.getElementById('factura').value = pago.factura || '';
        document.getElementById('observaciones').value = pago.observaciones || '';
        document.getElementById('aplicar_ahora').checked = false;
        
        // Cargar categorías
        if (pago.tipo_egreso_id) {
            fetch(`/admin/api/categorias-por-tipo-egreso/${pago.tipo_egreso_id}`, {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('categoria_gasto_id');
                select.innerHTML = '<option value="">Seleccionar categoría...</option>';
                data.forEach(cat => {
                    select.innerHTML += `<option value="${cat.id}" ${cat.id === pago.categoria_gasto_id ? 'selected' : ''}>${escapeHtml(cat.nombre)}</option>`;
                });
            });
        }
        
        new bootstrap.Modal(document.getElementById('modalPago')).show();
    });
}

function guardarPago() {
    const id = document.getElementById('pago_id').value;
    const data = {
        fecha_pago: document.getElementById('fecha_pago').value,
        cuenta_bancaria_id: document.getElementById('cuenta_bancaria_id').value,
        proveedor_id: document.getElementById('proveedor_id').value || null,
        proyecto_id: document.getElementById('proyecto_id').value || null,
        tipo_egreso_id: document.getElementById('tipo_egreso_id').value,
        categoria_gasto_id: document.getElementById('categoria_gasto_id').value || null,
        metodo_pago_id: document.getElementById('metodo_pago_id').value,
        moneda_id: document.getElementById('moneda_id').value,
        monto: document.getElementById('monto').value,
        concepto: document.getElementById('concepto').value,
        referencia: document.getElementById('referencia').value,
        referencia_bancaria: document.getElementById('referencia_bancaria').value,
        factura: document.getElementById('factura').value,
        observaciones: document.getElementById('observaciones').value,
        aplicar_ahora: document.getElementById('aplicar_ahora').checked
    };
    
    const url = id ? `/admin/api/pagos/${id}` : '/admin/api/pagos';
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
            bootstrap.Modal.getInstance(document.getElementById('modalPago')).hide();
            cargarPagos();
        } else {
            mostrarNotificacion(result.message, 'danger');
        }
    })
    .catch(error => mostrarNotificacion('Error al guardar: ' + error.message, 'danger'));
}

function eliminarPago(id) {
    if (confirm('¿Eliminar este pago?')) {
        fetch(`/admin/api/pagos/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarPagos();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        });
    }
}

function aplicarPago(id) {
    if (confirm('¿Aplicar este pago? Se actualizará el saldo de la cuenta bancaria.')) {
        fetch(`/admin/api/pagos/${id}/aplicar`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarPagos();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        });
    }
}

function verDetalle(id) {
    fetch(`/admin/api/pagos/${id}`, {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(pago => {
        mostrarNotificacion(`
Folio: ${pago.folio}
Fecha: ${formatDate(pago.fecha_pago)}
Proveedor: ${pago.proveedor?.nombre || pago.proveedor_nombre || '-'}
Concepto: ${pago.concepto}
Monto: ${formatCurrency(pago.monto)}
Método: ${pago.metodo_pago?.nombre || '-'}
Estatus: ${getEstatusTexto(pago.estatus)}
Factura: ${pago.factura || '-'}`, 'info');
    });
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
    const tabla = document.getElementById('tablaPagos');
    const html = tabla.outerHTML;
    const url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'pagos.xls';
    link.click();
}

function cargarTabla(datos) {
    const tablaBody = document.getElementById('tablaBody');
    
    if (datos.length === 0) {
        tablaBody.innerHTML = '<tr><td colspan="9" style="text-align: center;">No hay registros<\/td></tr>';
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
                <td>${escapeHtml(item.folio)}<\/td>
                <td>${formatDate(item.fecha_pago)}<\/td>
                <td>${escapeHtml(item.proveedor)}<\/td>
                <td>${escapeHtml(item.concepto)}<\/td>
                <td style="text-align:right;">${formatCurrency(item.monto)}<\/td>
                <td>${escapeHtml(item.metodo_pago)}<\/td>
                <td><span class="badge ${getBadgeClass(item.estatus)}">${getEstatusTexto(item.estatus)}</span><\/td>
                <td>${escapeHtml(item.factura)}<\/td>
                <td style="position:sticky;right:0;background:white;">
                    <div class="action-icons">
                        <i class="fas fa-eye" onclick="verDetalle(${item.id})" title="Ver"></i>
                        <i class="fas fa-edit" onclick="editarPago(${item.id})" title="Editar"></i>
                        <i class="fas fa-trash-alt" onclick="eliminarPago(${item.id})" title="Eliminar"></i>
                        ${item.estatus === 'pendiente' ? `<i class="fas fa-check-circle" onclick="aplicarPago(${item.id})" title="Aplicar"></i>` : ''}
                        <i class="fas fa-file-pdf" onclick="generarPDF(${item.id})" title="PDF"></i>
                        <i class="fas fa-print" onclick="imprimir(${item.id})" title="Imprimir"></i>
                    </div>
                <\/td>
            </tr>
        `;
    }).join('');
    
    document.getElementById('sumMonto').textContent = formatCurrency(totalMonto);
    actualizarPaginacion(datos.length);
}

function actualizarPaginacion(total) {
    const totalPages = Math.ceil(total / rowsPerPage);
    document.getElementById('paginaActual').textContent = currentPage;
    document.getElementById('paginacionInfo').textContent = `Mostrando ${Math.min((currentPage-1)*rowsPerPage+1, total)}-${Math.min(currentPage*rowsPerPage, total)} de ${total} registros`;
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Event listeners
document.getElementById('tipo_egreso_id')?.addEventListener('change', cargarCategoriasPorTipoEgreso);
document.getElementById('btnAgregar')?.addEventListener('click', abrirModalPago);
document.getElementById('btnExcel')?.addEventListener('click', exportarExcel);
document.getElementById('btnPrimera')?.addEventListener('click', () => { currentPage = 1; cargarTabla(datosOriginales); });
document.getElementById('btnAnterior')?.addEventListener('click', () => { if(currentPage > 1) { currentPage--; cargarTabla(datosOriginales); } });
document.getElementById('btnSiguiente')?.addEventListener('click', () => { const total = Math.ceil(datosOriginales.length / rowsPerPage); if(currentPage < total) { currentPage++; cargarTabla(datosOriginales); } });
document.getElementById('btnUltima')?.addEventListener('click', () => { currentPage = Math.ceil(datosOriginales.length / rowsPerPage); cargarTabla(datosOriginales); });
document.getElementById('buscador')?.addEventListener('input', e => {
    const busqueda = e.target.value.toLowerCase();
    const filtrados = datosOriginales.filter(item => 
        item.proveedor?.toLowerCase().includes(busqueda) ||
        item.concepto?.toLowerCase().includes(busqueda) ||
        item.folio?.toLowerCase().includes(busqueda)
    );
    currentPage = 1;
    cargarTabla(filtrados);
});

document.addEventListener('DOMContentLoaded', () => {
    cargarPagos();
});
</script>
@endsection