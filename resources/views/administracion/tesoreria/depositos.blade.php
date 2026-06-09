@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Depósitos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Depósitos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE DEPÓSITOS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Total Depósitos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalDepositos">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Aplicados</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalAplicados">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Pendientes</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalPendientes">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">En Proceso</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalProceso">0</div>
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

                <!-- Tabla de Depósitos -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaDepositos" style="width: 100%; font-size: 12px;">
                        <thead style="background-color: #2378e1; color: white;">
                            <tr>
                                <th draggable="true" data-columna="folio">Folio</th>
                                <th draggable="true" data-columna="fecha">Fecha</th>
                                <th draggable="true" data-columna="banco">Banco</th>
                                <th draggable="true" data-columna="cuenta">Cuenta</th>
                                <th draggable="true" data-columna="monto">Monto</th>
                                <th draggable="true" data-columna="concepto">Concepto</th>
                                <th draggable="true" data-columna="tipo_ingreso">Tipo Ingreso</th>
                                <th draggable="true" data-columna="estatus">Estatus</th>
                                <th style="position: sticky; right: 0; background-color: #2378e1;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="9" style="text-align: center;">Cargando...<\/td></tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr><td colspan="4" style="text-align: center;">Totales:</td><td style="text-align: right;" id="sumMonto">$0.00<\/td><td colspan="3"><\/td>
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

<!-- Modal para Depósito -->
<div class="modal fade" id="modalDeposito" tabindex="-1" style="z-index: 99999 !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-money-bill-wave"></i> Nuevo Depósito</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formDeposito">
                    <input type="hidden" id="deposito_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Fecha <span class="text-danger">*</span></label>
                            <input type="date" id="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Cuenta Bancaria <span class="text-danger">*</span></label>
                            <select id="cuenta_bancaria_id" class="form-control" required>
                                <option value="">Seleccionar cuenta...</option>
                                @foreach($cuentasBancarias ?? [] as $cuenta)
                                    <option value="{{ $cuenta->id }}">{{ $cuenta->banco->nombre ?? 'Sin banco' }} - {{ $cuenta->numero_cuenta }} ({{ $cuenta->moneda->simbolo ?? '' }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Proyecto</label>
                            <select id="proyecto_id" class="form-control">
                                <option value="">Ninguno</option>
                                @foreach($proyectos ?? [] as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tipo de Ingreso <span class="text-danger">*</span></label>
                            <select id="tipo_ingreso_id" class="form-control" required>
                                <option value="">Seleccionar tipo...</option>
                                @foreach($tiposIngreso ?? [] as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
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
                    <!-- 🔴 NUEVO: Campo Código SAT -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Código SAT <span class="text-danger">*</span></label>
                            <select id="codigo_sat_id" class="form-control" required>
                                <option value="">Seleccionar código SAT...</option>
                                @foreach($codigosSatIngresos ?? [] as $codigo)
                                    <option value="{{ $codigo->id }}" 
                                        data-codigo="{{ $codigo->codigo_agrupador }}"
                                        data-nombre="{{ $codigo->nombre_cuenta }}"
                                        data-tipo="{{ $codigo->tipo }}">
                                        {{ $codigo->codigo_agrupador }} - {{ $codigo->nombre_cuenta }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted" id="codigo_sat_info">
                                <i class="fas fa-info-circle"></i> Selecciona el código SAT que corresponde a este ingreso
                            </small>
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
                    <div class="form-check">
                        <input type="checkbox" id="aplicar_ahora" class="form-check-input" checked>
                        <label class="form-check-label">Aplicar depósito inmediatamente</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarDeposito()" style="background-color: #083CAE;">Guardar</button>
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
    .badge-aplicado { background-color: #28a745; color: white; }
    .badge-pendiente { background-color: #fd7e14; color: white; }
    .badge-rechazado { background-color: #dc3545; color: white; }
    .badge-proceso { background-color: #17a2b8; color: white; }
    .action-icons i { font-size: 14px; cursor: pointer; margin: 0 3px; }
    .fa-edit { color: #ffc107; }
    .fa-trash-alt { color: #dc3545; }
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
let rowsPerPage = 5;

function formatCurrency(amount) {
    return '$' + Number(amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('es-MX');
}

function getBadgeClass(estatus) {
    if (estatus === 'aplicado') return 'badge-aplicado';
    if (estatus === 'pendiente') return 'badge-pendiente';
    if (estatus === 'rechazado') return 'badge-rechazado';
    if (estatus === 'proceso') return 'badge-proceso';
    return 'badge-pendiente';
}

function getEstatusTexto(estatus) {
    if (estatus === 'aplicado') return 'Aplicado';
    if (estatus === 'pendiente') return 'Pendiente';
    if (estatus === 'rechazado') return 'Rechazado';
    if (estatus === 'proceso') return 'Proceso';
    return estatus || 'Pendiente';
}

function actualizarContadores(datos) {
    document.getElementById('totalDepositos').textContent = datos.length;
    document.getElementById('totalAplicados').textContent = datos.filter(d => d.estatus === 'aplicado').length;
    document.getElementById('totalPendientes').textContent = datos.filter(d => d.estatus === 'pendiente').length;
    document.getElementById('totalProceso').textContent = datos.filter(d => d.estatus === 'proceso').length;
}

function generarGrupoId(item, columnas) {
    return columnas.map(col => item[col] || 'Sin dato').join('||');
}

function agruparDatos(datos, columnas) {
    if (columnas.length === 0) return { grupos: [], items: datos };
    const gruposMap = new Map();
    datos.forEach(item => {
        const grupoId = generarGrupoId(item, columnas);
        if (!gruposMap.has(grupoId)) {
            gruposMap.set(grupoId, { id: grupoId, valor: columnas.map(col => item[col] || 'Sin dato').join(' - '), items: [item], totalMonto: item.monto || 0 });
        } else {
            const grupo = gruposMap.get(grupoId);
            grupo.items.push(item);
            grupo.totalMonto += item.monto || 0;
        }
    });
    return { grupos: Array.from(gruposMap.values()), items: [] };
}

function getCurrentPageData(datos) {
    const start = (currentPage - 1) * rowsPerPage;
    return datos.slice(start, start + rowsPerPage);
}

function actualizarPaginacion(total) {
    const totalPages = Math.ceil(total / rowsPerPage);
    document.getElementById('paginaActual').textContent = currentPage;
    document.getElementById('paginacionInfo').textContent = `Mostrando ${Math.min((currentPage - 1) * rowsPerPage + 1, total)}-${Math.min(currentPage * rowsPerPage, total)} de ${total} registros`;
}

function calcularTotales(datos) {
    let totalMonto = 0;
    datos.forEach(item => totalMonto += item.monto || 0);
    document.getElementById('sumMonto').textContent = formatCurrency(totalMonto);
}

function cargarTabla(datos) {
    const tablaBody = document.getElementById('tablaBody');
    const textoAgrupar = document.getElementById('textoAgrupar');
    
    actualizarContadores(datos);
    if (textoAgrupar) textoAgrupar.style.display = columnasAgrupadas.length > 0 ? 'none' : 'inline';
    
    const { grupos } = agruparDatos(datos, columnasAgrupadas);
    const hayGrupos = grupos.length > 0 && columnasAgrupadas.length > 0;
    tablaBody.innerHTML = '';
    
    if (datos.length === 0) {
        tablaBody.innerHTML = '<tr><td colspan="9" style="text-align: center;">No hay depósitos registrados<\/td></tr>';
        calcularTotales(datos);
        actualizarPaginacion(0);
        return;
    }
    
    if (hayGrupos) {
        grupos.forEach(grupo => {
            const grupoRow = document.createElement('tr');
            grupoRow.className = 'fila-grupo';
            grupoRow.dataset.grupoId = grupo.id;
            if (expandedGroups.has(grupo.id)) grupoRow.classList.add('expandido');
            grupoRow.innerHTML = `<td colspan="9"><div style="display: flex; justify-content: space-between;"><div><i class="fas fa-caret-right"></i> <strong>${grupo.valor}</strong> <span style="color:#6c757d;">(${grupo.items.length} registros - Total: ${formatCurrency(grupo.totalMonto)})</span></div></div></td>`;
            tablaBody.appendChild(grupoRow);
            
            if (expandedGroups.has(grupo.id)) {
                grupo.items.forEach(item => {
                    const detalleRow = document.createElement('tr');
                    detalleRow.className = 'fila-detalle';
                    detalleRow.innerHTML = `
                        <td style="padding-left:30px;">${item.folio || '-'}</td>
                        <td>${formatDate(item.fecha)}</td>
                        <td>${item.banco || '-'}</td>
                        <td>${item.cuenta || '-'}</td>
                        <td style="text-align:right;">${formatCurrency(item.monto)}<\/td>
                        <td>${item.concepto || '-'}</td>
                        <td>${item.tipo_ingreso || '-'}</td>
                        <td><span class="badge ${getBadgeClass(item.estatus)}">${getEstatusTexto(item.estatus)}</span></td>
                        <td style="position:sticky;right:0;background:white;">
                            <div class="action-icons">
                                <i class="fas fa-edit" onclick="editarDeposito(${item.id})" title="Editar"></i>
                                <i class="fas fa-trash-alt" onclick="eliminarDeposito(${item.id})" title="Eliminar"></i>
                                ${item.estatus === 'pendiente' ? `<i class="fas fa-check-circle" onclick="aplicarDeposito(${item.id})" title="Aplicar"></i>` : ''}
                                <i class="fas fa-file-pdf" onclick="generarPDF(${item.id})" title="PDF"></i>
                            </div>
                        <\/td>
                    `;
                    tablaBody.appendChild(detalleRow);
                });
            }
        });
    } else {
        const pageData = getCurrentPageData(datos);
        pageData.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.folio || '-'}</td>
                <td>${formatDate(item.fecha)}<\/td>
                <td>${item.banco || '-'}<\/td>
                <td>${item.cuenta || '-'}<\/td>
                <td style="text-align:right;">${formatCurrency(item.monto)}<\/td>
                <td>${item.concepto || '-'}<\/td>
                <td>${item.tipo_ingreso || '-'}<\/td>
                <td><span class="badge ${getBadgeClass(item.estatus)}">${getEstatusTexto(item.estatus)}</span><\/td>
                <td style="position:sticky;right:0;background:white;">
                    <div class="action-icons">
                        <i class="fas fa-edit" onclick="editarDeposito(${item.id})" title="Editar"></i>
                        <i class="fas fa-trash-alt" onclick="eliminarDeposito(${item.id})" title="Eliminar"></i>
                        ${item.estatus === 'pendiente' ? `<i class="fas fa-check-circle" onclick="aplicarDeposito(${item.id})" title="Aplicar"></i>` : ''}
                        <i class="fas fa-file-pdf" onclick="generarPDF(${item.id})" title="PDF"></i>
                    </div>
                <\/td>
            `;
            tablaBody.appendChild(row);
        });
        calcularTotales(datos);
        actualizarPaginacion(datos.length);
    }
}

function cargarDepositos() {
    fetch('/admin/api/depositos', {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        datosOriginales = data.map(d => ({
            id: d.id,
            folio: d.folio,
            fecha: d.fecha,
            banco: d.cuenta_bancaria?.banco?.nombre || '-',
            cuenta: d.cuenta_bancaria?.numero_cuenta || '-',
            monto: d.monto,
            concepto: d.concepto,
            tipo_ingreso: d.tipo_ingreso?.nombre || '-',
            estatus: d.estatus
        }));
        cargarTabla(datosOriginales);
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('tablaBody').innerHTML = '<tr><td colspan="9" style="color:red;">Error al cargar datos<\/td></tr>';
    });
}

function abrirModalDeposito() {
    document.getElementById('deposito_id').value = '';
    document.getElementById('fecha').value = new Date().toISOString().split('T')[0];
    document.getElementById('cuenta_bancaria_id').value = '';
    document.getElementById('proyecto_id').value = '';
    document.getElementById('tipo_ingreso_id').value = '';
    document.getElementById('monto').value = '';
    document.getElementById('referencia').value = '';
    document.getElementById('concepto').value = '';
    document.getElementById('observaciones').value = '';
    document.getElementById('aplicar_ahora').checked = true;
    // 🔴 Limpiar código SAT
    document.getElementById('codigo_sat_id').value = '';
    const infoSpan = document.getElementById('codigo_sat_info');
    if (infoSpan) {
        infoSpan.innerHTML = '<i class="fas fa-info-circle"></i> Selecciona el código SAT que corresponde a este ingreso';
        infoSpan.classList.remove('text-success', 'text-warning', 'text-danger');
        infoSpan.classList.add('text-muted');
    }
    new bootstrap.Modal(document.getElementById('modalDeposito')).show();
}

function editarDeposito(id) {
    fetch(`/admin/api/depositos/${id}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(deposito => {
        document.getElementById('deposito_id').value = deposito.id;
        document.getElementById('fecha').value = deposito.fecha;
        document.getElementById('cuenta_bancaria_id').value = deposito.cuenta_bancaria_id;
        document.getElementById('proyecto_id').value = deposito.proyecto_id || '';
        document.getElementById('tipo_ingreso_id').value = deposito.tipo_ingreso_id;
        document.getElementById('monto').value = deposito.monto;
        document.getElementById('referencia').value = deposito.referencia || '';
        document.getElementById('concepto').value = deposito.concepto;
        document.getElementById('observaciones').value = deposito.observaciones || '';
        document.getElementById('aplicar_ahora').checked = false;
        // 🔴 Cargar código SAT
        document.getElementById('codigo_sat_id').value = deposito.codigo_sat_id || '';
        
        // Actualizar info del código SAT
        const codigoSatSelect = document.getElementById('codigo_sat_id');
        const selectedOption = codigoSatSelect.options[codigoSatSelect.selectedIndex];
        const infoSpan = document.getElementById('codigo_sat_info');
        if (selectedOption && selectedOption.value) {
            const codigo = selectedOption.getAttribute('data-codigo') || '';
            const nombre = selectedOption.getAttribute('data-nombre') || '';
            infoSpan.innerHTML = `<i class="fas fa-check-circle text-success"></i> Código SAT seleccionado: ${codigo} - ${nombre}`;
            infoSpan.classList.remove('text-muted');
            infoSpan.classList.add('text-success');
        } else {
            infoSpan.innerHTML = '<i class="fas fa-info-circle"></i> Selecciona un código SAT para este ingreso';
        }
        
        new bootstrap.Modal(document.getElementById('modalDeposito')).show();
    });
}

function guardarDeposito() {
    const id = document.getElementById('deposito_id').value;
    const codigoSatId = document.getElementById('codigo_sat_id').value;
    
    // Validar código SAT
    if (!codigoSatId) {
        mostrarNotificacion('Por favor seleccione un código SAT', 'warning');
        return;
    }
    
    const data = {
        fecha: document.getElementById('fecha').value,
        cuenta_bancaria_id: document.getElementById('cuenta_bancaria_id').value,
        proyecto_id: document.getElementById('proyecto_id').value || null,
        tipo_ingreso_id: document.getElementById('tipo_ingreso_id').value,
        monto: document.getElementById('monto').value,
        referencia: document.getElementById('referencia').value,
        concepto: document.getElementById('concepto').value,
        observaciones: document.getElementById('observaciones').value,
        aplicar_ahora: document.getElementById('aplicar_ahora').checked,
        codigo_sat_id: codigoSatId
    };
    
    const url = id ? `/admin/api/depositos/${id}` : '/admin/api/depositos';
    const method = id ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin',
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            mostrarNotificacion(result.message, 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalDeposito')).hide();
            cargarDepositos();
        } else {
            mostrarNotificacion(result.message, 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('Error al guardar: ' + error.message, 'danger');
    });
}

function eliminarDeposito(id) {
    if (confirm('¿Eliminar este depósito?')) {
        fetch(`/admin/api/depositos/${id}`, {
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
                cargarDepositos();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        });
    }
}

function aplicarDeposito(id) {
    if (confirm('¿Aplicar este depósito? Se creará un movimiento bancario.')) {
        fetch(`/admin/api/depositos/${id}/aplicar`, {
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
                cargarDepositos();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        });
    }
}

function generarPDF(id) { mostrarNotificacion('Generando PDF...', 'info'); }

function exportarExcel() {
    const tabla = document.getElementById('tablaDepositos').cloneNode(true);
    const html = tabla.outerHTML;
    const link = document.createElement('a');
    link.href = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
    link.download = 'depositos.xls';
    link.click();
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

function actualizarGrupoColumnas() {
    const container = document.getElementById('grupoColumnas');
    container.innerHTML = '';
    if (columnasAgrupadas.length === 0) {
        document.getElementById('textoAgrupar').style.display = 'inline';
    } else {
        document.getElementById('textoAgrupar').style.display = 'none';
        columnasAgrupadas.forEach(col => {
            const chip = document.createElement('span');
            chip.className = 'columna-agrupada';
            chip.innerHTML = `${col.charAt(0).toUpperCase() + col.slice(1)}<span class="remover" data-columna="${col}">&times;</span>`;
            container.appendChild(chip);
        });
    }
    expandedGroups.clear();
    cargarTabla(datosOriginales);
}

function setupDragAndDrop() {
    document.querySelectorAll('th[draggable="true"]').forEach(th => {
        th.addEventListener('dragstart', e => e.dataTransfer.setData('text/plain', th.dataset.columna));
        th.addEventListener('dragend', e => th.style.opacity = '1');
    });
    const grupoAgrupacion = document.getElementById('grupoAgrupacion');
    grupoAgrupacion.addEventListener('dragover', e => e.preventDefault());
    grupoAgrupacion.addEventListener('drop', e => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadas.includes(columna)) {
            columnasAgrupadas.push(columna);
            actualizarGrupoColumnas();
        }
    });
    document.addEventListener('click', e => {
        if (e.target.classList.contains('remover')) {
            columnasAgrupadas = columnasAgrupadas.filter(c => c !== e.target.dataset.columna);
            actualizarGrupoColumnas();
        }
    });
}

document.addEventListener('click', e => {
    const filaGrupo = e.target.closest('.fila-grupo');
    if (filaGrupo) {
        const grupoId = filaGrupo.dataset.grupoId;
        if (expandedGroups.has(grupoId)) expandedGroups.delete(grupoId);
        else expandedGroups.add(grupoId);
        cargarTabla(datosOriginales);
    }
});

document.getElementById('btnAgregar')?.addEventListener('click', abrirModalDeposito);
document.getElementById('btnExcel')?.addEventListener('click', exportarExcel);
document.getElementById('btnPrimera')?.addEventListener('click', () => { currentPage = 1; cargarTabla(datosOriginales); });
document.getElementById('btnAnterior')?.addEventListener('click', () => { if(currentPage > 1) { currentPage--; cargarTabla(datosOriginales); } });
document.getElementById('btnSiguiente')?.addEventListener('click', () => { const total = Math.ceil(datosOriginales.length / rowsPerPage); if(currentPage < total) { currentPage++; cargarTabla(datosOriginales); } });
document.getElementById('btnUltima')?.addEventListener('click', () => { currentPage = Math.ceil(datosOriginales.length / rowsPerPage); cargarTabla(datosOriginales); });
document.getElementById('buscador')?.addEventListener('input', e => {
    const busqueda = e.target.value.toLowerCase();
    const filtrados = datosOriginales.filter(item => 
        item.folio?.toLowerCase().includes(busqueda) ||
        item.banco?.toLowerCase().includes(busqueda) ||
        item.concepto?.toLowerCase().includes(busqueda) ||
        item.estatus?.toLowerCase().includes(busqueda)
    );
    currentPage = 1;
    cargarTabla(filtrados);
});

document.getElementById('fechaInicio')?.addEventListener('change', () => cargarDepositos());
document.getElementById('fechaFin')?.addEventListener('change', () => cargarDepositos());
document.getElementById('btnCrearFiltro')?.addEventListener('click', () => alert('Filtro - En desarrollo'));
document.getElementById('btnColumnas')?.addEventListener('click', () => alert('Selector columnas - En desarrollo'));

document.addEventListener('DOMContentLoaded', () => {
    setupDragAndDrop();
    cargarDepositos();
});
</script>
@endsection