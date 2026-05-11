@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-chart-line"></i> Ventas
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Resumen de Ventas -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px;">Total Ventas</div>
                            <div style="color: #083CAE; font-size: 36px; font-weight: bold;" id="totalVentas">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #28a745; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px;">Facturas</div>
                            <div style="color: #28a745; font-size: 36px; font-weight: bold;" id="totalFacturas">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #ffc107; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px;">Completadas</div>
                            <div style="color: #ffc107; font-size: 36px; font-weight: bold;" id="totalCompletadas">0</div>
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
                    <i class="fas fa-chart-line" style="font-size: 64px; color: #dee2e6;"></i>
                    <h3 style="color: #6c757d;">No hay ventas registradas</h3>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 500px; overflow-y: auto;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaVentas" style="width: 100%; font-size: 12px;">
                        <thead style="position: sticky; top: 0; background-color: #083CAE; color: white; z-index: 10;">
                            <tr>
                                <th style="padding: 12px 6px; text-align: center;">Folio</th>
                                <th style="padding: 12px 6px; text-align: center;">Fecha</th>
                                <th style="padding: 12px 6px;">Cliente</th>
                                <th style="padding: 12px 6px;">RFC</th>
                                <th style="padding: 12px 6px;">Producto/Servicio</th>
                                <th style="padding: 12px 6px; text-align: right;">Cantidad</th>
                                <th style="padding: 12px 6px; text-align: right;">Precio Unit.</th>
                                <th style="padding: 12px 6px; text-align: right;">Subtotal</th>
                                <th style="padding: 12px 6px; text-align: right;">IVA</th>
                                <th style="padding: 12px 6px; text-align: right;">Total</th>
                                <th style="padding: 12px 6px;">Método Pago</th>
                                <th style="padding: 12px 6px;">Vendedor</th>
                                <th style="padding: 12px 6px; text-align: center;">Estatus</th>
                                <th style="padding: 12px 6px; text-align: center; position: sticky; right: 0; background-color: #083CAE; z-index: 20;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody"></tbody>
                        <tfoot style="position: sticky; bottom: 0; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="5" style="padding: 10px; text-align: right;"><strong>TOTALES:</strong></td>
                                <td style="padding: 10px; text-align: right;" id="sumCantidad">0</td>
                                <td style="padding: 10px; text-align: right;" id="sumPrecio">$0.00</td>
                                <td style="padding: 10px; text-align: right;" id="sumSubtotal">$0.00</td>
                                <td style="padding: 10px; text-align: right;" id="sumIva">$0.00</td>
                                <td style="padding: 10px; text-align: right;" id="sumTotal">$0.00</td>
                                <td colspan="4"></td>
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
    .badge-completada { background-color: #28a745; color: white; }
    .badge-pendiente { background-color: #ffc107; color: #333; }
    .badge-cancelada { background-color: #dc3545; color: white; }
    .badge-proceso { background-color: #17a2b8; color: white; }
    
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
let datosVentas = [];
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

function getBadgeClass(estatus) {
    const map = {
        'Completada': 'badge-completada',
        'Pendiente': 'badge-pendiente',
        'Cancelada': 'badge-cancelada',
        'Proceso': 'badge-proceso'
    };
    return map[estatus] || 'badge-pendiente';
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
    
    fetch('/ventas/data?' + params.toString())
        .then(response => response.json())
        .then(response => {
            if (response.success && response.data) {
                datosVentas = response.data;
                datosFiltrados = [...datosVentas];
                actualizarContadores(response.stats);
                cargarTabla();
            } else {
                datosVentas = [];
                datosFiltrados = [];
                actualizarContadores({ total_ventas: 0, total_facturas: 0, total_ingresos: 0, ventas_completadas: 0 });
                cargarTabla();
            }
            showLoading(false);
        })
        .catch(error => {
            console.error('Error:', error);
            datosVentas = [];
            datosFiltrados = [];
            actualizarContadores({ total_ventas: 0, total_facturas: 0, total_ingresos: 0, ventas_completadas: 0 });
            cargarTabla();
            showLoading(false);
        });
}

function actualizarContadores(stats) {
    document.getElementById('totalVentas').textContent = stats.total_ventas || 0;
    document.getElementById('totalFacturas').textContent = stats.total_facturas || 0;
    document.getElementById('totalCompletadas').textContent = stats.ventas_completadas || 0;
    document.getElementById('montoTotal').textContent = formatCurrency(stats.total_ingresos || 0);
}

function calcularTotales(datos) {
    let cantidad = 0, precio = 0, subtotal = 0, iva = 0, total = 0;
    datos.forEach(item => {
        cantidad += parseFloat(item.cantidad || 0);
        precio += parseFloat(item.precio_unitario || 0);
        subtotal += parseFloat(item.subtotal || 0);
        iva += parseFloat(item.iva || 0);
        total += parseFloat(item.total || 0);
    });
    document.getElementById('sumCantidad').textContent = cantidad;
    document.getElementById('sumPrecio').textContent = formatCurrency(precio);
    document.getElementById('sumSubtotal').textContent = formatCurrency(subtotal);
    document.getElementById('sumIva').textContent = formatCurrency(iva);
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
        
        row.innerHTML = `
            <td style="padding: 10px 6px; text-align: center;"><strong>${item.folio || '-'}</strong></td>
            <td style="padding: 10px 6px; text-align: center;">${formatDate(item.fecha)}</td>
            <td style="padding: 10px 6px;">${item.cliente || '-'}</td>
            <td style="padding: 10px 6px;">${item.cliente_rfc || '-'}</td>
            <td style="padding: 10px 6px;">${item.producto || '-'}</td>
            <td style="padding: 10px 6px; text-align: right;">${item.cantidad || 0}</td>
            <td style="padding: 10px 6px; text-align: right;">${formatCurrency(item.precio_unitario)}</td>
            <td style="padding: 10px 6px; text-align: right;">${formatCurrency(item.subtotal)}</td>
            <td style="padding: 10px 6px; text-align: right;">${formatCurrency(item.iva)}</td>
            <td style="padding: 10px 6px; text-align: right;"><strong>${formatCurrency(item.total)}</strong></td>
            <td style="padding: 10px 6px;">${item.metodo_pago || '-'}</td>
            <td style="padding: 10px 6px;">${item.vendedor || '-'}</td>
            <td style="padding: 10px 6px; text-align: center;"><span class="badge ${badgeClass}">${item.estatus || '-'}</span></td>
            <td style="padding: 10px 6px; text-align: center; background: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                <div style="display: flex; gap: 8px; justify-content: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" title="Ver" data-id="${item.factura_id}"></i>
                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer;" title="PDF" data-id="${item.factura_id}"></i>
                    <i class="fas fa-print" style="color: #17a2b8; cursor: pointer;" title="Imprimir" data-id="${item.factura_id}"></i>
                </div>
            </td>
        `;
    });
    
    calcularTotales(datosFiltrados);
    actualizarPaginacion(datosFiltrados.length);
    
    document.querySelectorAll('.fa-eye').forEach(el => el.addEventListener('click', () => verVenta(el.dataset.id)));
    document.querySelectorAll('.fa-file-pdf').forEach(el => el.addEventListener('click', () => showSuccess('PDF en desarrollo')));
    document.querySelectorAll('.fa-print').forEach(el => el.addEventListener('click', () => showSuccess('Impresión en desarrollo')));
}

function actualizarPaginacion(total) {
    const totalPages = Math.ceil(total / rowsPerPage);
    const start = (currentPage - 1) * rowsPerPage + 1;
    const end = Math.min(currentPage * rowsPerPage, total);
    document.getElementById('paginaActual').textContent = currentPage;
    document.getElementById('paginacionInfo').textContent = `Mostrando ${total === 0 ? 0 : start}-${end} de ${total} registros`;
}

function verVenta(id) {
    fetch(`/ventas/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let conceptosHtml = '';
                if (data.conceptos && data.conceptos.length > 0) {
                    conceptosHtml = '<hr><strong>Conceptos:</strong><table style="width:100%; margin-top:10px; border-collapse:collapse;"><tr style="background:#f0f0f0;"><th style="padding:8px; text-align:left;">Descripción</th><th style="padding:8px; text-align:right;">Cantidad</th><th style="padding:8px; text-align:right;">Valor Unitario</th><th style="padding:8px; text-align:right;">Importe</th></tr>';
                    data.conceptos.forEach(c => {
                        conceptosHtml += `<tr>
                            <td style="padding:8px; border-bottom:1px solid #eee;">${c.descripcion}</td>
                            <td style="padding:8px; text-align:right; border-bottom:1px solid #eee;">${c.cantidad}</td>
                            <td style="padding:8px; text-align:right; border-bottom:1px solid #eee;">${formatCurrency(c.valor_unitario)}</td>
                            <td style="padding:8px; text-align:right; border-bottom:1px solid #eee;">${formatCurrency(c.importe)}</td>
                        </tr>`;
                    });
                    conceptosHtml += '</table>';
                }
                
                Swal.fire({
                    title: `Venta ${data.data.folio_completo || data.data.folio}`,
                    html: `<div style="text-align:left;">
                        <p><strong>Cliente:</strong> ${data.data.cliente_nombre || '-'}</p>
                        <p><strong>RFC:</strong> ${data.data.rfc || '-'}</p>
                        <p><strong>Fecha:</strong> ${formatDate(data.data.fecha)}</p>
                        <p><strong>Subtotal:</strong> ${formatCurrency(data.data.subtotal)}</p>
                        <p><strong>IVA:</strong> ${formatCurrency(data.data.iva)}</p>
                        <p><strong>Total:</strong> ${formatCurrency(data.data.total)}</p>
                        <p><strong>Método Pago:</strong> ${data.data.metodo_pago_texto || data.data.metodo_pago || '-'}</p>
                        <p><strong>Vendedor:</strong> ${data.data.vendedor || 'Sistema'}</p>
                        <p><strong>Estatus:</strong> <span class="badge ${getBadgeClass(data.data.estatus_texto)}">${data.data.estatus_texto || data.data.estatus}</span></p>
                        ${conceptosHtml}
                    </div>`,
                    width: '700px',
                    confirmButtonColor: '#083CAE'
                });
            } else {
                showError(data.message || 'Error al cargar los detalles');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Error al cargar los detalles de la venta');
        });
}

function exportToExcel() {
    if (datosFiltrados.length === 0) { 
        showError('No hay datos para exportar'); 
        return; 
    }
    
    let csv = 'Folio,Fecha,Cliente,RFC,Producto,Cantidad,Precio Unitario,Subtotal,IVA,Total,Método Pago,Vendedor,Estatus\n';
    datosFiltrados.forEach(i => {
        csv += `${i.folio || '-'},`;
        csv += `${formatDate(i.fecha)},`;
        csv += `"${i.cliente || '-'}",`;
        csv += `${i.cliente_rfc || '-'},`;
        csv += `"${i.producto || '-'}",`;
        csv += `${i.cantidad || 0},`;
        csv += `${i.precio_unitario || 0},`;
        csv += `${i.subtotal || 0},`;
        csv += `${i.iva || 0},`;
        csv += `${i.total || 0},`;
        csv += `${i.metodo_pago || '-'},`;
        csv += `${i.vendedor || '-'},`;
        csv += `${i.estatus || '-'}\n`;
    });
    
    const blob = new Blob(["\uFEFF" + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `ventas_${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
    URL.revokeObjectURL(link.href);
    showSuccess('Exportación completada');
}

function aplicarFiltros() {
    const fi = document.getElementById('fechaInicio').value;
    const ff = document.getElementById('fechaFin').value;
    const busq = document.getElementById('buscador').value.toLowerCase();
    let filtrados = [...datosVentas];
    if (fi) filtrados = filtrados.filter(f => f.fecha >= fi);
    if (ff) filtrados = filtrados.filter(f => f.fecha <= ff);
    if (busq) filtrados = filtrados.filter(f => (f.cliente || '').toLowerCase().includes(busq) || (f.producto || '').toLowerCase().includes(busq) || (f.folio || '').toString().includes(busq) || (f.vendedor || '').toLowerCase().includes(busq));
    datosFiltrados = filtrados;
    currentPage = 1;
    cargarTabla();
}

// ============================================
// INICIALIZACIÓN
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando módulo de ventas');
    
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