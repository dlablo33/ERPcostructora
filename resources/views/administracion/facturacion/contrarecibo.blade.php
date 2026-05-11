@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Contrarecibos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-receipt"></i> Contrarecibos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE ESTADÍSTICAS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px;">Total</div>
                            <div style="color: #083CAE; font-size: 36px; font-weight: bold;" id="totalContrarecibos">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #ffc107; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px;">Pendientes</div>
                            <div style="color: #ffc107; font-size: 36px; font-weight: bold;" id="totalPendientes">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #28a745; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px;">Aplicados</div>
                            <div style="color: #28a745; font-size: 36px; font-weight: bold;" id="totalAplicados">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #17a2b8; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px;">Monto Total</div>
                            <div style="color: #17a2b8; font-size: 36px; font-weight: bold;" id="montoTotal">$0.00</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-layer-group" style="color: #083CAE; font-size: 14px;"></i>
                        <span style="color: #6c757d; font-size: 12px;">Arrastra columna para agrupar</span>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <input type="date" id="fechaInicio" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                        </div>
                        <div>
                            <input type="date" id="fechaFin" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                        </div>
                        <div>
                            <button id="btnAgregar" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; width: 36px; height: 36px; cursor: pointer;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div>
                            <button id="btnExcel" style="background-color: #28a745; color: white; border: none; border-radius: 4px; padding: 8px 12px; cursor: pointer;">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                        </div>
                        <div>
                            <button id="btnColumnas" style="background-color: #6c757d; color: white; border: none; border-radius: 4px; padding: 8px 12px; cursor: pointer;">
                                <i class="fas fa-columns"></i> Columnas
                            </button>
                        </div>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #ddd; border-radius: 4px; width: 250px;">
                        </div>
                    </div>
                </div>

                <!-- Loading -->
                <div id="loadingIndicator" style="text-align: center; padding: 40px; display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
                    <p>Cargando datos...</p>
                </div>

                <!-- Sin datos -->
                <div id="sinDatosMensaje" style="text-align: center; padding: 60px; background: #f8f9fa; border-radius: 8px; display: none;">
                    <i class="fas fa-receipt" style="font-size: 64px; color: #dee2e6;"></i>
                    <h3 style="color: #6c757d;">No hay contrarecibos registrados</h3>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 500px; overflow-y: auto;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaContrarecibos" style="width: 100%; font-size: 12px;">
                        <thead style="position: sticky; top: 0; background-color: #083CAE; color: white; z-index: 10;">
                            <tr>
                                <th style="padding: 12px 6px; text-align: center;">Estatus</th>
                                <th style="padding: 12px 6px; text-align: center;">Fecha</th>
                                <th style="padding: 12px 6px; text-align: center;">Folio</th>
                                <th style="padding: 12px 6px;">Cliente</th>
                                <th style="padding: 12px 6px;">RFC</th>
                                <th style="padding: 12px 6px;">Forma de Pago</th>
                                <th style="padding: 12px 6px;">Referencia</th>
                                <th style="padding: 12px 6px; text-align: right;">Monto</th>
                                <th style="padding: 12px 6px; text-align: center; position: sticky; right: 0; background-color: #083CAE; z-index: 20;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody"></tbody>
                        <tfoot style="position: sticky; bottom: 0; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="7" style="padding: 10px; text-align: right;"><strong>TOTAL:</strong></td>
                                <td style="padding: 10px; text-align: right;" id="sumTotal">$0.00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <button id="btnCrearFiltro" style="background: transparent; border: none; color: #083CAE; cursor: pointer;">
                        <i class="fas fa-filter"></i> Crear filtro
                    </button>
                    
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <button id="btnPrimeraPagina" style="border: none; background: none; color: #083CAE; cursor: pointer;">
                            <i class="fas fa-angle-double-left"></i>
                        </button>
                        <button id="btnAnteriorPagina" style="border: none; background: none; color: #083CAE; cursor: pointer;">
                            <i class="fas fa-angle-left"></i>
                        </button>
                        <span style="padding: 5px 12px; background-color: #083CAE; color: white; border-radius: 4px;" id="paginaActual">1</span>
                        <span id="paginacionInfo" style="color: #666; font-size: 12px;">Mostrando 0-0 de 0 registros</span>
                        <button id="btnSiguientePagina" style="border: none; background: none; color: #083CAE; cursor: pointer;">
                            <i class="fas fa-angle-right"></i>
                        </button>
                        <button id="btnUltimaPagina" style="border: none; background: none; color: #083CAE; cursor: pointer;">
                            <i class="fas fa-angle-double-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL NUEVO CONTRARECIBO -->
<div id="modalNuevoContrarecibo" style="display: none; position: fixed; z-index: 10001; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); overflow-y: auto;">
    <div style="background-color: white; margin: 5% auto; width: 95%; max-width: 800px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        
        <div style="background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%); color: white; padding: 20px 25px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <i class="fas fa-plus-circle" style="font-size: 24px; margin-right: 10px;"></i>
                <span style="font-size: 20px; font-weight: bold;">Nuevo Contrarecibo</span>
            </div>
            <button id="cerrarModal" style="background: none; border: none; color: white; font-size: 32px; cursor: pointer;">&times;</button>
        </div>
        
        <div style="padding: 25px; max-height: 70vh; overflow-y: auto;">
            <form id="formNuevoContrarecibo">
                <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Cliente *</label>
                        <select id="contacto_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="">Seleccionar cliente...</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha de Pago *</label>
                        <input type="date" id="fecha_pago" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Forma de Pago</label>
                        <select id="forma_pago" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="">Seleccionar...</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Tarjeta">Tarjeta de crédito</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Referencia Bancaria</label>
                        <input type="text" id="referencia_bancaria" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;" placeholder="Folio de transferencia o número de cheque">
                    </div>
                    
                    <div style="grid-column: span 2;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Observaciones</label>
                        <textarea id="observaciones" rows="2" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;" placeholder="Notas adicionales..."></textarea>
                    </div>
                    
                    <div style="grid-column: span 2; margin-top: 10px;">
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                <h4 style="margin: 0; color: #083CAE;">Facturas a pagar</h4>
                                <button type="button" id="btnAgregarFactura" style="background-color: #28a745; color: white; border: none; padding: 5px 15px; border-radius: 4px; cursor: pointer;">
                                    <i class="fas fa-plus"></i> Agregar Factura
                                </button>
                            </div>
                            <div id="facturasContainer">
                                <div id="facturaRowTemplate" style="display: none;">
                                    <div class="factura-row" style="display: flex; gap: 10px; margin-bottom: 10px; align-items: center;">
                                        <select class="factura-select" style="flex: 2; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                                            <option value="">Seleccionar factura...</option>
                                        </select>
                                        <input type="number" class="factura-monto" placeholder="Monto a aplicar" step="0.01" style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                                        <button type="button" class="btn-remover-factura" style="background-color: #dc3545; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="facturasList"></div>
                                <div class="alert alert-info" id="noFacturasMsg" style="background: #e3f2fd; padding: 10px; border-radius: 4px; margin-top: 10px;">
                                    <small>Agregue al menos una factura para aplicar el pago</small>
                                </div>
                            </div>
                            
                            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                                <div style="display: flex; justify-content: flex-end; gap: 20px;">
                                    <div style="text-align: right;">
                                        <div style="color: #666; font-size: 14px;">Total a Pagar:</div>
                                        <div style="font-size: 24px; font-weight: bold; color: #28a745;" id="totalPagar">$0.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <div style="padding: 20px 25px; background-color: #f8f9fa; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 12px;">
            <button id="btnCancelar" style="background-color: #6c757d; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer;">Cancelar</button>
            <button id="btnGuardar" style="background-color: #28a745; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer;">
                <i class="fas fa-save"></i> Guardar Contrarecibo
            </button>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 20000; justify-content: center; align-items: center;">
    <div style="background: white; padding: 30px; border-radius: 12px; text-align: center;">
        <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
        <p style="margin-top: 15px;">Procesando...</p>
    </div>
</div>

<style>
    .custom-card { transition: transform 0.2s, box-shadow 0.2s; }
    .custom-card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(0,0,0,0.1); }
    
    .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block; }
    .badge-pendiente { background-color: #ffc107; color: #333; }
    .badge-aplicado { background-color: #28a745; color: white; }
    .badge-cancelado { background-color: #dc3545; color: white; }
    
    .table td { padding: 10px 6px; vertical-align: middle; }
    #tablaBody tr:nth-child(even) { background-color: #f8f9fa; }
    #tablaBody tr:hover { background-color: #e3f2fd; }
    .factura-row { background: white; padding: 10px; border-radius: 6px; margin-bottom: 10px; border: 1px solid #e0e0e0; }
    
    @media (max-width: 768px) {
        div[style*="grid-template-columns: repeat(2, 1fr)"] { grid-template-columns: 1fr !important; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// ============================================
// VARIABLES GLOBALES
// ============================================
let datosContrarecibos = [];
let datosFiltrados = [];
let currentPage = 1;
const rowsPerPage = 10;
let facturasSeleccionadas = [];

// ============================================
// UTILIDADES
// ============================================
function formatCurrency(amount) {
    if (amount === null || amount === undefined) amount = 0;
    return '$' + parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

function formatDate(dateString) {
    if (!dateString) return '-';
    try {
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return dateString;
        return date.toLocaleDateString('es-MX');
    } catch(e) { return dateString; }
}

function getBadgeClass(estatus) {
    const map = { 1: 'badge-pendiente', 19: 'badge-aplicado', 21: 'badge-cancelado' };
    return map[estatus] || 'badge-pendiente';
}

function getEstatusDisplay(estatus) {
    const map = { 1: 'Pendiente', 19: 'Aplicado', 21: 'Cancelado' };
    return map[estatus] || 'Pendiente';
}

function showLoading(show) {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) overlay.style.display = show ? 'flex' : 'none';
}

function showError(msg) { 
    Swal.fire({ icon: 'error', title: 'Error', text: msg, confirmButtonColor: '#083CAE' }); 
}

function showSuccess(msg) { 
    Swal.fire({ icon: 'success', title: 'Éxito', text: msg, confirmButtonColor: '#083CAE', timer: 3000, showConfirmButton: false }); 
}

// ============================================
// CARGA DE DATOS
// ============================================
function cargarDatos() {
    showLoading(true);
    
    const params = new URLSearchParams();
    const fi = document.getElementById('fechaInicio').value;
    const ff = document.getElementById('fechaFin').value;
    const busqueda = document.getElementById('buscador').value;
    
    if (fi) params.append('fecha_inicio', fi);
    if (ff) params.append('fecha_fin', ff);
    if (busqueda) params.append('search', busqueda);
    
    fetch('/contrarecibos/data?' + params.toString())
        .then(response => response.json())
        .then(response => {
            if (response.success && response.data) {
                datosContrarecibos = response.data;
                datosFiltrados = [...datosContrarecibos];
                actualizarContadores(response.stats);
                cargarTabla();
            } else {
                datosContrarecibos = [];
                datosFiltrados = [];
                actualizarContadores({ total: 0, pendientes: 0, aplicados: 0, cancelados: 0, monto_total: 0 });
                cargarTabla();
            }
            showLoading(false);
        })
        .catch(error => {
            console.error('Error:', error);
            datosContrarecibos = [];
            datosFiltrados = [];
            actualizarContadores({ total: 0, pendientes: 0, aplicados: 0, cancelados: 0, monto_total: 0 });
            cargarTabla();
            showLoading(false);
        });
}

function actualizarContadores(stats) {
    document.getElementById('totalContrarecibos').textContent = stats.total || 0;
    document.getElementById('totalPendientes').textContent = stats.pendientes || 0;
    document.getElementById('totalAplicados').textContent = stats.aplicados || 0;
    document.getElementById('montoTotal').textContent = formatCurrency(stats.monto_total || 0);
}

function calcularTotales(datos) {
    let total = 0;
    datos.forEach(item => {
        total += parseFloat(item.monto || 0);
    });
    document.getElementById('sumTotal').textContent = formatCurrency(total);
}

function cargarTabla() {
    const tbody = document.getElementById('tablaBody');
    const sinDatos = document.getElementById('sinDatosMensaje');
    const tablaContainer = document.getElementById('tablaContainer');
    
    if (!tbody) return;
    
    if (datosFiltrados.length === 0) {
        sinDatos.style.display = 'block';
        tablaContainer.style.display = 'none';
        calcularTotales([]);
        actualizarPaginacion(0);
        return;
    }
    
    sinDatos.style.display = 'none';
    tablaContainer.style.display = 'block';
    
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const pageData = datosFiltrados.slice(start, end);
    
    tbody.innerHTML = '';
    
    pageData.forEach(item => {
        const row = tbody.insertRow();
        const badgeClass = getBadgeClass(item.estatus);
        const estatusDisplay = getEstatusDisplay(item.estatus);
        
        row.innerHTML = `
            <td style="padding: 10px 6px; text-align: center;"><span class="badge ${badgeClass}">${estatusDisplay}</span></td>
            <td style="padding: 10px 6px; text-align: center;">${formatDate(item.fecha)}</td>
            <td style="padding: 10px 6px; text-align: center;"><strong>${item.folio || '-'}</strong></td>
            <td style="padding: 10px 6px;">${item.cliente || '-'}</td>
            <td style="padding: 10px 6px;">${item.rfc || '-'}</td>
            <td style="padding: 10px 6px;">${item.forma_pago || '-'}</td>
            <td style="padding: 10px 6px;">${item.referencia_bancaria || '-'}</td>
            <td style="padding: 10px 6px; text-align: right;"><strong>${formatCurrency(item.monto)}</strong></td>
            <td style="padding: 10px 6px; text-align: center; background: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                <div style="display: flex; gap: 8px; justify-content: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" title="Ver" data-id="${item.contrarecibo_id}"></i>
                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer;" title="PDF" data-id="${item.contrarecibo_id}"></i>
                    <i class="fas fa-print" style="color: #17a2b8; cursor: pointer;" title="Imprimir" data-id="${item.contrarecibo_id}"></i>
                </div>
            </td>
        `;
    });
    
    calcularTotales(datosFiltrados);
    actualizarPaginacion(datosFiltrados.length);
    
    document.querySelectorAll('.fa-eye').forEach(el => el.addEventListener('click', () => verContrarecibo(el.dataset.id)));
}

function actualizarPaginacion(total) {
    const totalPages = Math.ceil(total / rowsPerPage);
    const start = (currentPage - 1) * rowsPerPage + 1;
    const end = Math.min(currentPage * rowsPerPage, total);
    document.getElementById('paginaActual').textContent = currentPage;
    document.getElementById('paginacionInfo').textContent = `Mostrando ${total === 0 ? 0 : start}-${end} de ${total} registros`;
}

function verContrarecibo(id) {
    fetch(`/contrarecibos/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let facturasHtml = '';
                if (data.facturas && data.facturas.length > 0) {
                    facturasHtml = '<hr><strong>Facturas aplicadas:</strong><table style="width:100%; margin-top:10px;"><tr><th>Factura</th><th>Monto aplicado</th>\\th';
                    data.facturas.forEach(f => {
                        facturasHtml += `<tr><td>${f.serie}-${f.folio}</td><td>${formatCurrency(f.monto_aplicado)}</td></tr>`;
                    });
                    facturasHtml += '</table>';
                }
                
                Swal.fire({
                    title: `Contrarecibo ${data.data.folio}`,
                    html: `<div style="text-align:left;">
                        <p><strong>Cliente:</strong> ${data.data.cliente}</p>
                        <p><strong>Fecha:</strong> ${formatDate(data.data.fecha_pago)}</p>
                        <p><strong>Forma de Pago:</strong> ${data.data.forma_pago || '-'}</p>
                        <p><strong>Referencia:</strong> ${data.data.referencia_bancaria || '-'}</p>
                        <p><strong>Monto:</strong> ${formatCurrency(data.data.monto)}</p>
                        <p><strong>Observaciones:</strong> ${data.data.observaciones || '-'}</p>
                        <p><strong>Estatus:</strong> <span class="badge ${getBadgeClass(data.data.estatus)}">${getEstatusDisplay(data.data.estatus)}</span></p>
                        ${facturasHtml}
                    </div>`,
                    width: '600px',
                    confirmButtonColor: '#083CAE'
                });
            }
        })
        .catch(error => console.error('Error:', error));
}

// ============================================
// MODALES
// ============================================
function abrirModalNuevoContrarecibo() {
    const modal = document.getElementById('modalNuevoContrarecibo');
    if (!modal) return;
    
    document.getElementById('formNuevoContrarecibo').reset();
    facturasSeleccionadas = [];
    actualizarListaFacturas();
    
    const hoy = new Date().toISOString().split('T')[0];
    document.getElementById('fecha_pago').value = hoy;
    
    cargarCombos();
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function cerrarModalContrarecibo() {
    const modal = document.getElementById('modalNuevoContrarecibo');
    if (modal) { modal.style.display = 'none'; document.body.style.overflow = 'auto'; }
}

function cargarCombos() {
    // Clientes
    fetch('/api/contactos')
        .then(r => r.json()).then(data => {
            const select = document.getElementById('contacto_id');
            if (select && Array.isArray(data)) {
                select.innerHTML = '<option value="">Seleccionar cliente...</option>';
                data.forEach(c => {
                    select.innerHTML += `<option value="${c.contacto_id}">${c.razon_social} ${c.rfc ? '- ' + c.rfc : ''}</option>`;
                });
            }
        }).catch(e => console.error('Error clientes:', e));
    
    // Facturas disponibles para el select
    cargarFacturasDisponibles();
}

function cargarFacturasDisponibles() {
    const clienteId = document.getElementById('contacto_id').value;
    let url = '/api/facturas-para-pago';
    if (clienteId) {
        url += '?cliente_id=' + clienteId;
    }
    
    fetch(url)
        .then(r => r.json())
        .then(data => {
            window.facturasDisponibles = data;
            actualizarSelectsFactura();
        })
        .catch(e => console.error('Error facturas:', e));
}

function actualizarSelectsFactura() {
    document.querySelectorAll('.factura-select').forEach(select => {
        const valorActual = select.value;
        select.innerHTML = '<option value="">Seleccionar factura...</option>';
        if (window.facturasDisponibles && Array.isArray(window.facturasDisponibles) && window.facturasDisponibles.length > 0) {
            window.facturasDisponibles.forEach(f => {
                const yaSeleccionada = facturasSeleccionadas.some(fs => fs.factura_id === f.factura_id);
                if (!yaSeleccionada || valorActual == f.factura_id) {
                    const saldo = f.saldo_restante || f.saldo_disponible || f.total;
                    select.innerHTML += `<option value="${f.factura_id}" data-saldo="${saldo}" data-total="${f.total}" data-cliente="${f.cliente_nombre}">${f.serie}-${f.folio} | ${f.cliente_nombre} | Total: ${formatCurrency(f.total)} | Saldo: ${formatCurrency(saldo)}</option>`;
                }
            });
        } else {
            select.innerHTML = '<option value="">No hay facturas disponibles con saldo pendiente</option>';
        }
        if (valorActual) select.value = valorActual;
    });
}

// Actualizar la función que carga facturas al seleccionar cliente
function cargarCombos() {
    // Clientes
    fetch('/api/contactos')
        .then(r => r.json()).then(data => {
            const select = document.getElementById('contacto_id');
            if (select && Array.isArray(data)) {
                select.innerHTML = '<option value="">Seleccionar cliente...</option>';
                data.forEach(c => {
                    select.innerHTML += `<option value="${c.contacto_id}">${c.razon_social} ${c.rfc ? '- ' + c.rfc : ''}</option>`;
                });
                // Cuando cambia el cliente, recargar facturas disponibles
                select.onchange = function() {
                    cargarFacturasDisponibles();
                };
            }
        }).catch(e => console.error('Error clientes:', e));
    
    // Cargar facturas iniciales
    cargarFacturasDisponibles();
}

function actualizarSelectsFactura() {
    document.querySelectorAll('.factura-select').forEach(select => {
        const valorActual = select.value;
        select.innerHTML = '<option value="">Seleccionar factura...</option>';
        if (window.facturasDisponibles && Array.isArray(window.facturasDisponibles)) {
            window.facturasDisponibles.forEach(f => {
                const yaSeleccionada = facturasSeleccionadas.some(fs => fs.factura_id === f.factura_id);
                if (!yaSeleccionada || valorActual == f.factura_id) {
                    const saldo = f.saldo_restante || f.saldo_disponible || f.total;
                    select.innerHTML += `<option value="${f.factura_id}" data-saldo="${saldo}" data-total="${f.total}">${f.serie}-${f.folio} | ${f.cliente_nombre} | Saldo: ${formatCurrency(saldo)}</option>`;
                }
            });
        }
        if (valorActual) select.value = valorActual;
    });
}

function agregarFactura() {
    const nuevaFactura = {
        factura_id: '',
        monto: 0
    };
    facturasSeleccionadas.push(nuevaFactura);
    actualizarListaFacturas();
}

function removerFactura(index) {
    facturasSeleccionadas.splice(index, 1);
    actualizarListaFacturas();
}

function actualizarListaFacturas() {
    const container = document.getElementById('facturasList');
    const noFacturasMsg = document.getElementById('noFacturasMsg');
    
    if (!container) return;
    
    if (facturasSeleccionadas.length === 0) {
        container.innerHTML = '';
        if (noFacturasMsg) noFacturasMsg.style.display = 'block';
        actualizarTotalPagar();
        return;
    }
    
    if (noFacturasMsg) noFacturasMsg.style.display = 'none';
    
    let html = '';
    facturasSeleccionadas.forEach((factura, index) => {
        html += `
            <div class="factura-row" data-index="${index}">
                <div style="display: flex; gap: 10px; align-items: center;">
                    <select class="factura-select" data-index="${index}" style="flex: 2; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Seleccionar factura...</option>
                    </select>
                    <input type="number" class="factura-monto" data-index="${index}" placeholder="Monto a aplicar" step="0.01" value="${factura.monto || ''}" style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    <button type="button" class="btn-remover-factura" data-index="${index}" style="background-color: #dc3545; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <small id="saldo-disponible-${index}" style="display: block; margin-top: 5px; color: #666;"></small>
            </div>
        `;
    });
    
    container.innerHTML = html;
    
    // Cargar opciones de facturas en los selects
    document.querySelectorAll('.factura-select').forEach(select => {
        const idx = parseInt(select.dataset.index);
        select.innerHTML = '<option value="">Seleccionar factura...</option>';
        if (window.facturasDisponibles) {
            window.facturasDisponibles.forEach(f => {
                const yaSeleccionada = facturasSeleccionadas.some((fs, i) => i !== idx && fs.factura_id === f.factura_id);
                if (!yaSeleccionada || facturasSeleccionadas[idx]?.factura_id == f.factura_id) {
                    const saldo = f.saldo_restante || f.saldo_disponible || f.total;
                    select.innerHTML += `<option value="${f.factura_id}" data-saldo="${saldo}" data-total="${f.total}">${f.serie}-${f.folio} | ${f.cliente_nombre} | Saldo: ${formatCurrency(saldo)}</option>`;
                }
            });
        }
        if (facturasSeleccionadas[idx]?.factura_id) {
            select.value = facturasSeleccionadas[idx].factura_id;
        }
        
        select.addEventListener('change', (e) => {
            const option = e.target.options[e.target.selectedIndex];
            const idxSel = parseInt(e.target.dataset.index);
            facturasSeleccionadas[idxSel].factura_id = e.target.value;
            if (option && option.dataset.saldo) {
                const maxMonto = parseFloat(option.dataset.saldo);
                const montoInput = document.querySelector(`.factura-monto[data-index="${idxSel}"]`);
                if (montoInput && parseFloat(montoInput.value) > maxMonto) {
                    montoInput.value = maxMonto;
                    facturasSeleccionadas[idxSel].monto = maxMonto;
                }
                document.getElementById(`saldo-disponible-${idxSel}`).innerHTML = `Saldo disponible: ${formatCurrency(maxMonto)}`;
            }
            actualizarTotalPagar();
        });
    });
    
    // Event listeners para inputs de monto
    document.querySelectorAll('.factura-monto').forEach(input => {
        const idx = parseInt(input.dataset.index);
        input.addEventListener('input', (e) => {
            const monto = parseFloat(e.target.value) || 0;
            const select = document.querySelector(`.factura-select[data-index="${idx}"]`);
            const option = select?.options[select.selectedIndex];
            const maxMonto = option ? parseFloat(option.dataset.saldo) : Infinity;
            
            if (monto > maxMonto) {
                e.target.value = maxMonto;
                facturasSeleccionadas[idx].monto = maxMonto;
                showError(`El monto no puede exceder el saldo disponible (${formatCurrency(maxMonto)})`);
            } else {
                facturasSeleccionadas[idx].monto = monto;
            }
            actualizarTotalPagar();
        });
    });
    
    // Event listeners para botones de eliminar
    document.querySelectorAll('.btn-remover-factura').forEach(btn => {
        const idx = parseInt(btn.dataset.index);
        btn.addEventListener('click', () => removerFactura(idx));
    });
    
    actualizarTotalPagar();
}

function actualizarTotalPagar() {
    let total = 0;
    facturasSeleccionadas.forEach(f => {
        total += f.monto || 0;
    });
    document.getElementById('totalPagar').textContent = formatCurrency(total);
}

function guardarContrarecibo() {
    const contacto_id = document.getElementById('contacto_id').value;
    const fecha_pago = document.getElementById('fecha_pago').value;
    const forma_pago = document.getElementById('forma_pago').value;
    const referencia_bancaria = document.getElementById('referencia_bancaria').value;
    const observaciones = document.getElementById('observaciones').value;
    
    if (!contacto_id) { showError('Seleccione un cliente'); return; }
    if (!fecha_pago) { showError('Seleccione una fecha de pago'); return; }
    
    const facturasValidas = facturasSeleccionadas.filter(f => f.factura_id && f.monto > 0);
    if (facturasValidas.length === 0) { showError('Agregue al menos una factura con monto válido'); return; }
    
    const total = facturasValidas.reduce((sum, f) => sum + f.monto, 0);
    
    const data = {
        contacto_id: parseInt(contacto_id),
        fecha_pago: fecha_pago,
        forma_pago: forma_pago || null,
        referencia_bancaria: referencia_bancaria || null,
        observaciones: observaciones || null,
        monto: total,
        facturas: facturasValidas.map(f => ({ factura_id: parseInt(f.factura_id), monto: f.monto }))
    };
    
    showLoading(true);
    
    fetch('/contrarecibos', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.getElementById('csrf_token').value },
        body: JSON.stringify(data)
    })
    .then(r => r.json())
    .then(data => {
        showLoading(false);
        if (data.success) {
            showSuccess(data.message);
            cerrarModalContrarecibo();
            cargarDatos();
        } else { showError(data.message); }
    })
    .catch(err => { showLoading(false); showError('Error al guardar'); });
}

function exportToExcel() {
    if (datosFiltrados.length === 0) { showError('No hay datos'); return; }
    let csv = 'Estatus,Fecha,Folio,Cliente,RFC,Forma de Pago,Referencia,Monto\n';
    datosFiltrados.forEach(i => {
        csv += `${getEstatusDisplay(i.estatus)},${formatDate(i.fecha)},${i.folio || '-'},"${i.cliente || '-'}",${i.rfc || '-'},${i.forma_pago || '-'},${i.referencia_bancaria || '-'},${i.monto || 0}\n`;
    });
    const blob = new Blob(["\uFEFF" + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `contrarecibos_${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
    URL.revokeObjectURL(link.href);
    showSuccess('Exportación completada');
}

function aplicarFiltros() {
    const fi = document.getElementById('fechaInicio').value;
    const ff = document.getElementById('fechaFin').value;
    const busq = document.getElementById('buscador').value.toLowerCase();
    let filtrados = [...datosContrarecibos];
    if (fi) filtrados = filtrados.filter(f => f.fecha >= fi);
    if (ff) filtrados = filtrados.filter(f => f.fecha <= ff);
    if (busq) filtrados = filtrados.filter(f => (f.cliente || '').toLowerCase().includes(busq) || (f.folio || '').toLowerCase().includes(busq) || (f.referencia_bancaria || '').toLowerCase().includes(busq));
    datosFiltrados = filtrados;
    currentPage = 1;
    cargarTabla();
}

// ============================================
// INICIALIZACIÓN
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando módulo de contrarecibos');
    
    cargarDatos();
    
    const hoy = new Date();
    const hace30 = new Date(); hace30.setDate(hoy.getDate() - 30);
    document.getElementById('fechaInicio').value = hace30.toISOString().split('T')[0];
    document.getElementById('fechaFin').value = hoy.toISOString().split('T')[0];
    
    document.getElementById('btnAgregar').addEventListener('click', abrirModalNuevoContrarecibo);
    document.getElementById('btnExcel').addEventListener('click', exportToExcel);
    document.getElementById('btnCrearFiltro').addEventListener('click', () => showSuccess('Filtros avanzados en desarrollo'));
    document.getElementById('btnColumnas').addEventListener('click', () => showSuccess('Selector de columnas en desarrollo'));
    
    document.getElementById('fechaInicio').addEventListener('change', aplicarFiltros);
    document.getElementById('fechaFin').addEventListener('change', aplicarFiltros);
    document.getElementById('buscador').addEventListener('input', aplicarFiltros);
    
    document.getElementById('btnPrimeraPagina').addEventListener('click', () => { currentPage = 1; cargarTabla(); });
    document.getElementById('btnAnteriorPagina').addEventListener('click', () => { if (currentPage > 1) { currentPage--; cargarTabla(); } });
    document.getElementById('btnSiguientePagina').addEventListener('click', () => { const max = Math.ceil(datosFiltrados.length / rowsPerPage); if (currentPage < max) { currentPage++; cargarTabla(); } });
    document.getElementById('btnUltimaPagina').addEventListener('click', () => { currentPage = Math.ceil(datosFiltrados.length / rowsPerPage); cargarTabla(); });
    
    document.getElementById('cerrarModal').addEventListener('click', cerrarModalContrarecibo);
    document.getElementById('btnCancelar').addEventListener('click', cerrarModalContrarecibo);
    document.getElementById('btnGuardar').addEventListener('click', guardarContrarecibo);
    document.getElementById('btnAgregarFactura').addEventListener('click', agregarFactura);
    
    window.addEventListener('click', (e) => {
        if (e.target === document.getElementById('modalNuevoContrarecibo')) cerrarModalContrarecibo();
    });
});
</script>

@endsection