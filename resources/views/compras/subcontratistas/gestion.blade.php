@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-truck"></i> Proveedores
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
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Estatus</label>
                        <select id="filtroEstatus" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Todos</option>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                    <div style="display: flex; align-items: flex-end;">
                        <button id="btnActualizar" style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; width: 100%;">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                    </div>
                </div>

                <!-- Botones -->
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 15px;">
                    <button id="btnNuevoProveedor" onclick="abrirModalProveedor()" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 20px; cursor: pointer; color: var(--color-primary);">
                        <i class="fas fa-plus"></i> Nuevo Proveedor
                    </button>
                    <button id="btnExportar" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 20px; cursor: pointer; color: var(--color-primary);">
                        <i class="fas fa-file-excel"></i> Exportar
                    </button>
                </div>

                <!-- Tabla -->
                <div class="table-container">
                    <table class="table" id="tablaProveedores">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Estatus</th>
                                <th>Fecha Alta</th>
                                <th>Alias</th>
                                <th>Razón Social</th>
                                <th>RFC</th>
                                <th>Régimen Fiscal</th>
                                <th>Calle</th>
                                <th>Núm. Ext</th>
                                <th>Núm. Int</th>
                                <th>C.P.</th>
                                <th>Límite Crédito</th>
                                <th>Crédito</th>
                                <th>Forma Pago</th>
                                <th>Método Pago</th>
                                <th>Uso CFDI</th>
                                <th>Banco</th>
                                <th>Cuenta Banco</th>
                                <th>Cuenta Contable</th>
                                <th>Cuenta Sec.</th>
                                <th>Cuenta Resultado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="22" style="text-align: center;">Cargando...<\/td></tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="22" style="padding: 10px; text-align: center;">Total Proveedores: 0<\/td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div class="pagination-container" style="margin-top: 15px; display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                    <button class="page-btn" id="btnPrimera" disabled><i class="fas fa-angle-double-left"></i></button>
                    <button class="page-btn" id="btnAnterior" disabled><i class="fas fa-angle-left"></i></button>
                    <span>Página <span id="paginaActual">1</span> de <span id="totalPaginas">1</span></span>
                    <button class="page-btn" id="btnSiguiente" disabled><i class="fas fa-angle-right"></i></button>
                    <button class="page-btn" id="btnUltima" disabled><i class="fas fa-angle-double-right"></i></button>
                    <select id="porPagina" style="padding: 5px; border-radius: 4px;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                
                <!-- Botón Crear filtro -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PROVEEDOR -->
<div id="modalProveedor" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 900px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;" id="modalTituloProveedor">Nuevo Proveedor</h3>
            <button onclick="cerrarModalProveedor()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;">
            <input type="hidden" id="proveedorId">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Folio</label>
                    <input type="text" id="modalFolio" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" readonly placeholder="Autogenerado">
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Estatus <span style="color: red;">*</span></label>
                    <select id="modalEstatus" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Fecha Alta</label>
                    <input type="date" id="modalFechaAlta" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Alias <span style="color: red;">*</span></label>
                    <input type="text" id="modalAlias" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Nombre corto">
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-size: 12px; font-weight: 600;">Razón Social</label>
                    <input type="text" id="modalRazonSocial" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Razón social completa">
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">RFC</label>
                    <input type="text" id="modalRFC" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="RFC">
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Régimen Fiscal</label>
                    <select id="modalRegimenFiscal" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>General de Ley</option>
                        <option>Persona Física</option>
                        <option>Régimen Simplificado</option>
                        <option>Régimen de Incorporación</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Calle</label>
                    <input type="text" id="modalCalle" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Calle">
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Núm. Exterior</label>
                    <input type="text" id="modalNumExt" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ext">
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Núm. Interior</label>
                    <input type="text" id="modalNumInt" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Int">
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Código Postal</label>
                    <input type="text" id="modalCP" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="C.P.">
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Límite de Crédito</label>
                    <input type="number" step="0.01" id="modalLimiteCredito" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00" value="0">
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Crédito Actual</label>
                    <input type="number" step="0.01" id="modalCredito" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00" value="0">
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Forma de Pago</label>
                    <select id="modalFormaPago" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Pago en una sola exhibición</option>
                        <option>Pago en parcialidades</option>
                        <option>Pago diferido</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Método de Pago</label>
                    <select id="modalMetodoPago" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Transferencia</option>
                        <option>Cheque</option>
                        <option>Efectivo</option>
                        <option>Tarjeta de crédito</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Uso CFDI</label>
                    <select id="modalUsoCFDI" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>G01 - Adquisición de mercancías</option>
                        <option>G02 - Devoluciones</option>
                        <option>G03 - Gastos en general</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Banco</label>
                    <select id="modalBanco" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>BBVA</option>
                        <option>Santander</option>
                        <option>Banamex</option>
                        <option>Banorte</option>
                        <option>HSBC</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Cuenta Banco</label>
                    <input type="text" id="modalCuentaBanco" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Número de cuenta">
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Cuenta Contable</label>
                    <input type="text" id="modalCuentaContable" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="2010-01">
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Cuenta Contable Sec.</label>
                    <input type="text" id="modalCuentaSecundaria" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="2010-02">
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600;">Cuenta Edo. Resultado</label>
                    <input type="text" id="modalCuentaResultado" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="5010-01">
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalProveedor()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarProveedor()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETALLE -->
<div id="modalDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 700px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;">Detalle de Proveedor</h3>
            <button onclick="cerrarModalDetalle()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div id="detalleContenido" style="padding: 20px;"></div>
        <div style="padding: 15px 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end;">
            <button onclick="cerrarModalDetalle()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cerrar</button>
        </div>
    </div>
</div>

<style>
    :root { --color-primary: #083CAE; }
    .table-container { border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; max-height: 500px; overflow-y: auto; }
    .table { width: 100%; border-collapse: collapse; font-size: 11px; }
    .table th { background-color: var(--color-primary) !important; color: white; padding: 12px 8px; border: 1px solid #dee2e6; position: sticky; top: 0; }
    .table td { padding: 10px 8px; border: 1px solid #dee2e6; }
    tbody tr:nth-child(even) { background-color: #f8f9fa; }
    .page-btn { padding: 5px 12px; border: 1px solid var(--color-primary); border-radius: 4px; background: white; cursor: pointer; color: var(--color-primary); }
    .page-btn:disabled { opacity: 0.5; cursor: not-allowed; }
    .badge-activo { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 12px; font-size: 10px; display: inline-block; }
    .badge-inactivo { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 12px; font-size: 10px; display: inline-block; }
    @media (max-width: 768px) { div[style*="grid-template-columns: repeat(4, 1fr)"] { grid-template-columns: repeat(2, 1fr) !important; } }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
let currentPage = 1;
let perPage = 10;
let totalPages = 1;
let editingId = null;
let searchTimeout = null;

document.addEventListener('DOMContentLoaded', function() {
    cargarProveedores();
    configurarEventos();
});

function cargarProveedores() {
    const fechaInicio = document.getElementById('fechaInicio')?.value || '';
    const fechaFin = document.getElementById('fechaFin')?.value || '';
    const estatus = document.getElementById('filtroEstatus')?.value || '';
    const busqueda = document.getElementById('buscador')?.value || '';
    
    let url = `/compras/api/proveedores?page=${currentPage}&per_page=${perPage}`;
    if (fechaInicio) url += `&fecha_inicio=${fechaInicio}`;
    if (fechaFin) url += `&fecha_fin=${fechaFin}`;
    if (estatus) url += `&estatus=${estatus}`;
    if (busqueda) url += `&search=${encodeURIComponent(busqueda)}`;
    
    fetch(url)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                renderizarTabla(response.data);
                totalPages = response.last_page;
                actualizarPaginacion(response.current_page, response.last_page);
                
                const tfoot = document.querySelector('#tablaProveedores tfoot');
                if (tfoot) {
                    tfoot.innerHTML = `<tr><td colspan="22" style="padding: 10px; text-align: center;">Total Proveedores: ${response.total}<\/td><\/tr>`;
                }
            } else {
                document.getElementById('tablaBody').innerHTML = `<tr><td colspan="22" style="text-align: center;">Error: ${response.message}<\/td><\/tr>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('tablaBody').innerHTML = `<tr><td colspan="22" style="text-align: center;">Error de conexión: ${error.message}<\/td><\/tr>`;
        });
}

function renderizarTabla(data) {
    const tbody = document.getElementById('tablaBody');
    if (!tbody) return;
    
    if (!data.length) {
        tbody.innerHTML = '<tr><td colspan="22" style="text-align: center;">No hay proveedores registrados<\/td><\/tr>';
        return;
    }
    
    tbody.innerHTML = '';
    data.forEach(item => {
        const estatusClass = item.estatus === 'Activo' ? 'badge-activo' : 'badge-inactivo';
        
        let acciones = `
            <i class="fas fa-eye" onclick="verDetalle(${item.id})" style="color: var(--color-primary); cursor: pointer; margin: 0 3px;" title="Ver detalle"></i>
            <i class="fas fa-edit" onclick="editarProveedor(${item.id})" style="color: var(--color-primary); cursor: pointer; margin: 0 3px;" title="Editar"></i>
            <i class="fas fa-trash" onclick="eliminarProveedor(${item.id}, '${item.folio}')" style="color: #dc3545; cursor: pointer; margin: 0 3px;" title="Eliminar"></i>
        `;
        
        if (item.estatus === 'Inactivo') {
            acciones += `<i class="fas fa-redo-alt" onclick="reactivarProveedor(${item.id}, '${item.folio}')" style="color: #ffc107; cursor: pointer; margin: 0 3px;" title="Reactivar"></i>`;
        }
        
        tbody.innerHTML += `
            <tr>
                <td style="padding: 10px 8px;"><strong>${escapeHtml(item.folio)}</strong></td>
                <td style="padding: 10px 8px;"><span class="${estatusClass}">${escapeHtml(item.estatus)}</span></td>
                <td style="padding: 10px 8px;">${item.fecha_alta || '---'}</td>
                <td style="padding: 10px 8px;">${escapeHtml(item.alias)}</td>
                <td style="padding: 10px 8px;">${escapeHtml(item.razon_social || '')}</td>
                <td style="padding: 10px 8px;">${escapeHtml(item.rfc) || '---'}</td>
                <td style="padding: 10px 8px;">${escapeHtml(item.regimen_fiscal) || '---'}</td>
                <td style="padding: 10px 8px;">${escapeHtml(item.calle) || '---'}</td>
                <td style="padding: 10px 8px;">${escapeHtml(item.num_ext) || '---'}</td>
                <td style="padding: 10px 8px;">${escapeHtml(item.num_int) || '---'}</td>
                <td style="padding: 10px 8px;">${escapeHtml(item.codigo_postal) || '---'}</td>
                <td style="padding: 10px 8px; text-align: right;">$${formatNumber(item.limite_credito)}</td>
                <td style="padding: 10px 8px; text-align: right;">$${formatNumber(item.credito)}</td>
                <td style="padding: 10px 8px;">${escapeHtml(item.forma_pago) || '---'}</td>
                <td style="padding: 10px 8px;">${escapeHtml(item.metodo_pago) || '---'}</td>
                <td style="padding: 10px 8px;">${escapeHtml(item.uso_cfdi) || '---'}</td>
                <td style="padding: 10px 8px;">${escapeHtml(item.banco) || '---'}</td>
                <td style="padding: 10px 8px;">${escapeHtml(item.cuenta_banco) || '---'}</td>
                <td style="padding: 10px 8px;">${escapeHtml(item.cuenta_contable) || '---'}</td>
                <td style="padding: 10px 8px;">${escapeHtml(item.cuenta_secundaria) || '---'}</td>
                <td style="padding: 10px 8px;">${escapeHtml(item.cuenta_resultado) || '---'}</td>
                <td style="padding: 10px 8px; position: sticky; right: 0; background-color: inherit; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">${acciones}</td>
            </tr>
        `;
    });
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatNumber(num) {
    if (!num && num !== 0) return '0.00';
    return parseFloat(num).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function actualizarPaginacion(currentPage, lastPage) {
    document.getElementById('paginaActual').textContent = currentPage;
    document.getElementById('totalPaginas').textContent = lastPage;
    document.getElementById('btnPrimera').disabled = currentPage === 1;
    document.getElementById('btnAnterior').disabled = currentPage === 1;
    document.getElementById('btnSiguiente').disabled = currentPage === lastPage;
    document.getElementById('btnUltima').disabled = currentPage === lastPage;
}

function configurarEventos() {
    document.getElementById('btnActualizar')?.addEventListener('click', () => { currentPage = 1; cargarProveedores(); });
    document.getElementById('btnPrimera')?.addEventListener('click', () => { currentPage = 1; cargarProveedores(); });
    document.getElementById('btnAnterior')?.addEventListener('click', () => { if (currentPage > 1) { currentPage--; cargarProveedores(); } });
    document.getElementById('btnSiguiente')?.addEventListener('click', () => { currentPage++; cargarProveedores(); });
    document.getElementById('btnUltima')?.addEventListener('click', () => { currentPage = totalPages; cargarProveedores(); });
    document.getElementById('porPagina')?.addEventListener('change', (e) => { perPage = parseInt(e.target.value); currentPage = 1; cargarProveedores(); });
    document.getElementById('btnExportar')?.addEventListener('click', () => window.location.href = '/compras/api/proveedores/exportar');
    document.getElementById('btnCrearFiltro')?.addEventListener('click', () => alert('Funcionalidad de filtro en desarrollo'));
    document.getElementById('btnExcel')?.addEventListener('click', () => window.location.href = '/compras/api/proveedores/exportar');
    
    const buscador = document.getElementById('buscador');
    if (buscador) {
        buscador.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentPage = 1;
                cargarProveedores();
            }, 500);
        });
    }
}

function abrirModalProveedor() {
    editingId = null;
    document.getElementById('modalTituloProveedor').textContent = 'Nuevo Proveedor';
    document.getElementById('proveedorId').value = '';
    document.getElementById('modalFolio').value = '';
    document.getElementById('modalEstatus').value = 'Activo';
    document.getElementById('modalFechaAlta').value = new Date().toISOString().split('T')[0];
    document.getElementById('modalAlias').value = '';
    document.getElementById('modalRazonSocial').value = '';
    document.getElementById('modalRFC').value = '';
    document.getElementById('modalRegimenFiscal').value = 'General de Ley';
    document.getElementById('modalCalle').value = '';
    document.getElementById('modalNumExt').value = '';
    document.getElementById('modalNumInt').value = '';
    document.getElementById('modalCP').value = '';
    document.getElementById('modalLimiteCredito').value = '0';
    document.getElementById('modalCredito').value = '0';
    document.getElementById('modalFormaPago').value = 'Pago en una sola exhibición';
    document.getElementById('modalMetodoPago').value = 'Transferencia';
    document.getElementById('modalUsoCFDI').value = 'G01 - Adquisición de mercancías';
    document.getElementById('modalBanco').value = 'BBVA';
    document.getElementById('modalCuentaBanco').value = '';
    document.getElementById('modalCuentaContable').value = '';
    document.getElementById('modalCuentaSecundaria').value = '';
    document.getElementById('modalCuentaResultado').value = '';
    document.getElementById('modalProveedor').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function editarProveedor(id) {
    fetch(`/compras/api/proveedores/${id}`)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                const p = response.data;
                editingId = p.id;
                document.getElementById('modalTituloProveedor').textContent = `Editar Proveedor ${p.folio}`;
                document.getElementById('proveedorId').value = p.id;
                document.getElementById('modalFolio').value = p.folio;
                document.getElementById('modalEstatus').value = p.estatus;
                document.getElementById('modalFechaAlta').value = p.fecha_alta;
                document.getElementById('modalAlias').value = p.alias;
                document.getElementById('modalRazonSocial').value = p.razon_social || '';
                document.getElementById('modalRFC').value = p.rfc || '';
                document.getElementById('modalRegimenFiscal').value = p.regimen_fiscal || 'General de Ley';
                document.getElementById('modalCalle').value = p.calle || '';
                document.getElementById('modalNumExt').value = p.num_ext || '';
                document.getElementById('modalNumInt').value = p.num_int || '';
                document.getElementById('modalCP').value = p.codigo_postal || '';
                document.getElementById('modalLimiteCredito').value = p.limite_credito || 0;
                document.getElementById('modalCredito').value = p.credito || 0;
                document.getElementById('modalFormaPago').value = p.forma_pago || 'Pago en una sola exhibición';
                document.getElementById('modalMetodoPago').value = p.metodo_pago || 'Transferencia';
                document.getElementById('modalUsoCFDI').value = p.uso_cfdi || 'G01 - Adquisición de mercancías';
                document.getElementById('modalBanco').value = p.banco || 'BBVA';
                document.getElementById('modalCuentaBanco').value = p.cuenta_banco || '';
                document.getElementById('modalCuentaContable').value = p.cuenta_contable || '';
                document.getElementById('modalCuentaSecundaria').value = p.cuenta_secundaria || '';
                document.getElementById('modalCuentaResultado').value = p.cuenta_resultado || '';
                document.getElementById('modalProveedor').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        });
}

function guardarProveedor() {
    const alias = document.getElementById('modalAlias').value.trim();
    if (!alias) {
        alert('El alias es obligatorio');
        return;
    }
    
    const data = {
        alias: alias,
        razon_social: document.getElementById('modalRazonSocial').value,
        rfc: document.getElementById('modalRFC').value,
        regimen_fiscal: document.getElementById('modalRegimenFiscal').value,
        calle: document.getElementById('modalCalle').value,
        num_ext: document.getElementById('modalNumExt').value,
        num_int: document.getElementById('modalNumInt').value,
        codigo_postal: document.getElementById('modalCP').value,
        limite_credito: document.getElementById('modalLimiteCredito').value,
        credito: document.getElementById('modalCredito').value,
        forma_pago: document.getElementById('modalFormaPago').value,
        metodo_pago: document.getElementById('modalMetodoPago').value,
        uso_cfdi: document.getElementById('modalUsoCFDI').value,
        banco: document.getElementById('modalBanco').value,
        cuenta_banco: document.getElementById('modalCuentaBanco').value,
        cuenta_contable: document.getElementById('modalCuentaContable').value,
        cuenta_secundaria: document.getElementById('modalCuentaSecundaria').value,
        cuenta_resultado: document.getElementById('modalCuentaResultado').value,
        estatus: document.getElementById('modalEstatus').value
    };
    
    const url = editingId ? `/compras/api/proveedores/${editingId}` : '/compras/api/proveedores';
    const method = editingId ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
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
            cerrarModalProveedor();
            cargarProveedores();
        } else {
            alert('❌ Error: ' + response.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error al guardar el proveedor');
    });
}

function verDetalle(id) {
    fetch(`/compras/api/proveedores/${id}`)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                const p = response.data;
                let html = `
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                        <div><strong>Folio:</strong> ${p.folio}</div>
                        <div><strong>Estatus:</strong> ${p.estatus}</div>
                        <div><strong>Fecha Alta:</strong> ${p.fecha_alta}</div>
                        <div><strong>Alias:</strong> ${escapeHtml(p.alias)}</div>
                        <div><strong>Razón Social:</strong> ${escapeHtml(p.razon_social || '')}</div>
                        <div><strong>RFC:</strong> ${p.rfc || '---'}</div>
                        <div><strong>Régimen Fiscal:</strong> ${escapeHtml(p.regimen_fiscal) || '---'}</div>
                        <div><strong>Dirección:</strong> ${escapeHtml(p.calle || '')} ${p.num_ext || ''} ${p.num_int ? 'Int ' + p.num_int : ''}, CP ${p.codigo_postal || ''}</div>
                        <div><strong>Límite Crédito:</strong> $${formatNumber(p.limite_credito)}</div>
                        <div><strong>Crédito Actual:</strong> $${formatNumber(p.credito)}</div>
                        <div><strong>Forma Pago:</strong> ${escapeHtml(p.forma_pago) || '---'}</div>
                        <div><strong>Método Pago:</strong> ${escapeHtml(p.metodo_pago) || '---'}</div>
                        <div><strong>Uso CFDI:</strong> ${escapeHtml(p.uso_cfdi) || '---'}</div>
                        <div><strong>Banco:</strong> ${escapeHtml(p.banco) || '---'}</div>
                        <div><strong>Cuenta Banco:</strong> ${p.cuenta_banco || '---'}</div>
                        <div><strong>Cuenta Contable:</strong> ${p.cuenta_contable || '---'}</div>
                        <div><strong>Cuenta Secundaria:</strong> ${p.cuenta_secundaria || '---'}</div>
                        <div><strong>Cuenta Resultado:</strong> ${p.cuenta_resultado || '---'}</div>
                    </div>
                `;
                document.getElementById('detalleContenido').innerHTML = html;
                document.getElementById('modalDetalle').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        });
}

function eliminarProveedor(id, folio) {
    if (confirm(`¿Eliminar el proveedor ${folio}?`)) {
        fetch(`/compras/api/proveedores/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                alert('✅ ' + response.message);
                cargarProveedores();
            } else {
                alert('❌ Error: ' + response.message);
            }
        });
    }
}

function reactivarProveedor(id, folio) {
    if (confirm(`¿Reactivar el proveedor ${folio}?`)) {
        fetch(`/compras/api/proveedores/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ estatus: 'Activo', activo: true })
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                alert('✅ ' + response.message);
                cargarProveedores();
            } else {
                alert('❌ Error: ' + response.message);
            }
        });
    }
}

function cerrarModalProveedor() {
    document.getElementById('modalProveedor').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function cerrarModalDetalle() {
    document.getElementById('modalDetalle').style.display = 'none';
    document.body.style.overflow = 'auto';
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        cerrarModalProveedor();
        cerrarModalDetalle();
    }
});

document.getElementById('modalProveedor')?.addEventListener('click', (e) => {
    if (e.target === this) cerrarModalProveedor();
});

document.getElementById('modalDetalle')?.addEventListener('click', (e) => {
    if (e.target === this) cerrarModalDetalle();
});
</script>
@endsection