@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- CFDI -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-file-invoice"></i> CFDI
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600;">Total CFDI</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalCfdi">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #28a745; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600;">Facturas</div>
                            <div style="color: #28a745; font-size: 36px; font-weight: bold;" id="totalFacturas">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #ffc107; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600;">Notas Crédito</div>
                            <div style="color: #ffc107; font-size: 36px; font-weight: bold;" id="totalNotasCredito">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #17a2b8; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600;">Cancelados</div>
                            <div style="color: #17a2b8; font-size: 36px; font-weight: bold;" id="totalCancelados">0</div>
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
                    <i class="fas fa-file-invoice" style="font-size: 64px; color: #dee2e6;"></i>
                    <h3 style="color: #6c757d;">No hay CFDI registrados</h3>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 500px; overflow-y: auto;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaCFDI" style="width: 100%; font-size: 12px;">
                        <thead style="position: sticky; top: 0; background-color: #083CAE; color: white; z-index: 10;">
                            <tr>
                                <th style="padding: 12px 6px; text-align: center;">Serie</th>
                                <th style="padding: 12px 6px; text-align: center;">Folio</th>
                                <th style="padding: 12px 6px; text-align: center;">Fecha</th>
                                <th style="padding: 12px 6px;">Receptor</th>
                                <th style="padding: 12px 6px;">RFC</th>
                                <th style="padding: 12px 6px; text-align: center;">Tipo</th>
                                <th style="padding: 12px 6px; text-align: center;">Estatus</th>
                                <th style="padding: 12px 6px; text-align: right;">Total</th>
                                <th style="padding: 12px 6px;">UUID</th>
                                <th style="padding: 12px 6px; text-align: center; position: sticky; right: 0; background-color: #083CAE; z-index: 20;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody"></tbody>
                        <tfoot style="position: sticky; bottom: 0; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="7" style="padding: 10px; text-align: right;"><strong>TOTAL:</strong></td>
                                <td style="padding: 10px; text-align: right;" id="sumTotal">$0.00</td>
                                <td colspan="2"></td>
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
    .badge-timbrada { background-color: #28a745; color: white; }
    .badge-cancelada { background-color: #dc3545; color: white; }
    .badge-factura { background-color: #083CAE; color: white; }
    .badge-nota { background-color: #ffc107; color: #333; }
    
    .table td { padding: 10px 6px; vertical-align: middle; }
    #tablaBody tr:nth-child(even) { background-color: #f8f9fa; }
    #tablaBody tr:hover { background-color: #e3f2fd; }
    
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
let datosCFDI = [];
let datosFiltrados = [];
let currentPage = 1;
const rowsPerPage = 10;

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

function getBadgeClass(tipo, estatus) {
    if (estatus === 'Cancelada') return 'badge-cancelada';
    if (tipo === 'Factura') return 'badge-factura';
    if (tipo === 'Nota de Crédito') return 'badge-nota';
    return 'badge-timbrada';
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
    
    fetch('/cfdi/data?' + params.toString())
        .then(response => response.json())
        .then(response => {
            if (response.success && response.data) {
                datosCFDI = response.data;
                datosFiltrados = [...datosCFDI];
                actualizarContadores(response.stats);
                cargarTabla();
            } else {
                datosCFDI = [];
                datosFiltrados = [];
                actualizarContadores({ total: 0, facturas: 0, notas_credito: 0, cancelados: 0 });
                cargarTabla();
            }
            showLoading(false);
        })
        .catch(error => {
            console.error('Error:', error);
            datosCFDI = [];
            datosFiltrados = [];
            actualizarContadores({ total: 0, facturas: 0, notas_credito: 0, cancelados: 0 });
            cargarTabla();
            showLoading(false);
        });
}

function actualizarContadores(stats) {
    document.getElementById('totalCfdi').textContent = stats.total || 0;
    document.getElementById('totalFacturas').textContent = stats.activas || 0;
    document.getElementById('totalNotasCredito').textContent = (stats.total || 0) - (stats.activas || 0);
    document.getElementById('totalCancelados').textContent = stats.canceladas || 0;
}

function calcularTotales(datos) {
    let total = 0;
    datos.forEach(item => {
        total += parseFloat(item.comprobanteTotal || 0);
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
        const tipo = item.comprobanteTipoDeComprobante === 'I' ? 'Factura' : 'Nota de Crédito';
        const badgeClass = getBadgeClass(tipo, item.estatus_texto);
        
        row.innerHTML = `
            <td style="padding: 10px 6px;">${item.comprobanteSerie || '-'}</td>
            <td style="padding: 10px 6px; text-align: center;"><strong>${item.comprobanteFolio || '-'}</strong></td>
            <td style="padding: 10px 6px; text-align: center;">${formatDate(item.comprobanteFecha)}</td>
            <td style="padding: 10px 6px;">${item.receptor_nombre || '-'}</td>
            <td style="padding: 10px 6px;">${item.receptor_rfc || '-'}</td>
            <td style="padding: 10px 6px; text-align: center;"><span class="badge ${badgeClass}">${tipo}</span></td>
            <td style="padding: 10px 6px; text-align: center;"><span class="badge badge-${item.estatus_texto === 'Cancelada' ? 'cancelada' : 'timbrada'}">${item.estatus_texto || '-'}</span></td>
            <td style="padding: 10px 6px; text-align: right;"><strong>${formatCurrency(item.comprobanteTotal)}</strong></td>
            <td style="padding: 10px 6px; font-size: 10px;">${item.uuid ? item.uuid.substring(0, 20) + '...' : '-'}</td>
            <td style="padding: 10px 6px; text-align: center; background: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                <div style="display: flex; gap: 8px; justify-content: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" title="Ver" data-id="${item.cfdi_id}"></i>
                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer;" title="PDF" data-id="${item.cfdi_id}"></i>
                    <i class="fas fa-file-code" style="color: #17a2b8; cursor: pointer;" title="XML" data-id="${item.cfdi_id}"></i>
                </div>
            </td>
        `;
    });
    
    calcularTotales(datosFiltrados);
    actualizarPaginacion(datosFiltrados.length);
    
    document.querySelectorAll('.fa-eye').forEach(el => el.addEventListener('click', () => verCFDI(el.dataset.id)));
    document.querySelectorAll('.fa-file-pdf').forEach(el => el.addEventListener('click', () => window.open(`/cfdi/${el.dataset.id}/pdf`, '_blank')));
    document.querySelectorAll('.fa-file-code').forEach(el => el.addEventListener('click', () => window.open(`/cfdi/${el.dataset.id}/xml`, '_blank')));
}

function actualizarPaginacion(total) {
    const totalPages = Math.ceil(total / rowsPerPage);
    const start = (currentPage - 1) * rowsPerPage + 1;
    const end = Math.min(currentPage * rowsPerPage, total);
    document.getElementById('paginaActual').textContent = currentPage;
    document.getElementById('paginacionInfo').textContent = `Mostrando ${total === 0 ? 0 : start}-${end} de ${total} registros`;
}

function verCFDI(id) {
    fetch(`/cfdi/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const cfdi = data.data;
                let conceptosHtml = '';
                if (data.conceptos && data.conceptos.length > 0) {
                    conceptosHtml = '<hr><strong>Conceptos:</strong><table style="width:100%; margin-top:10px;"><tr><th>Descripción</th><th>Cantidad</th><th>Valor Unitario</th><th>Importe</th></tr>';
                    data.conceptos.forEach(c => {
                        conceptosHtml += `<tr><td>${c.descripcion}</td><td>${c.cantidad}</td><td>${formatCurrency(c.valor_unitario)}</td><td>${formatCurrency(c.importe)}</td></tr>`;
                    });
                    conceptosHtml += '</table>';
                }
                
                Swal.fire({
                    title: `CFDI ${cfdi.comprobanteSerie}-${cfdi.comprobanteFolio}`,
                    html: `<div style="text-align:left;">
                        <p><strong>Receptor:</strong> ${cfdi.receptor_nombre}</p>
                        <p><strong>RFC:</strong> ${cfdi.receptor_rfc}</p>
                        <p><strong>Fecha:</strong> ${formatDate(cfdi.comprobanteFecha)}</p>
                        <p><strong>Tipo:</strong> ${cfdi.comprobanteTipoDeComprobante === 'I' ? 'Factura' : 'Nota de Crédito'}</p>
                        <p><strong>Total:</strong> ${formatCurrency(cfdi.comprobanteTotal)}</p>
                        <p><strong>UUID:</strong> <small>${cfdi.uuid}</small></p>
                        ${conceptosHtml}
                    </div>`,
                    width: '700px',
                    confirmButtonColor: '#083CAE'
                });
            }
        })
        .catch(error => console.error('Error:', error));
}

function exportToExcel() {
    if (datosFiltrados.length === 0) { 
        showError('No hay datos para exportar'); 
        return; 
    }
    
    let csv = 'Serie,Folio,Fecha,Receptor,RFC,Tipo,Estatus,Total,UUID\n';
    datosFiltrados.forEach(i => {
        const tipo = i.comprobanteTipoDeComprobante === 'I' ? 'Factura' : 'Nota de Crédito';
        csv += `${i.comprobanteSerie || '-'},`;
        csv += `${i.comprobanteFolio || '-'},`;
        csv += `${formatDate(i.comprobanteFecha)},`;
        csv += `"${i.receptor_nombre || '-'}",`;
        csv += `${i.receptor_rfc || '-'},`;
        csv += `${tipo},`;
        csv += `${i.estatus_texto || '-'},`;
        csv += `${i.comprobanteTotal || 0},`;
        csv += `${i.uuid || '-'}\n`;
    });
    
    const blob = new Blob(["\uFEFF" + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `cfdi_${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
    URL.revokeObjectURL(link.href);
    showSuccess('Exportación completada');
}

function aplicarFiltros() {
    const fi = document.getElementById('fechaInicio').value;
    const ff = document.getElementById('fechaFin').value;
    const busq = document.getElementById('buscador').value.toLowerCase();
    let filtrados = [...datosCFDI];
    if (fi) filtrados = filtrados.filter(f => f.comprobanteFecha >= fi);
    if (ff) filtrados = filtrados.filter(f => f.comprobanteFecha <= ff);
    if (busq) filtrados = filtrados.filter(f => (f.receptor_nombre || '').toLowerCase().includes(busq) || (f.receptor_rfc || '').toLowerCase().includes(busq) || (f.comprobanteFolio || '').toString().includes(busq));
    datosFiltrados = filtrados;
    currentPage = 1;
    cargarTabla();
}

// ============================================
// INICIALIZACIÓN
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando módulo CFDI');
    
    cargarDatos();
    
    const hoy = new Date();
    const hace30 = new Date(); 
    hace30.setDate(hoy.getDate() - 30);
    document.getElementById('fechaInicio').value = hace30.toISOString().split('T')[0];
    document.getElementById('fechaFin').value = hoy.toISOString().split('T')[0];
    
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
});
</script>

@endsection