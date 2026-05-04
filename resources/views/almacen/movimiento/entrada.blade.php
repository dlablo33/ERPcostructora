@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-exchange-alt"></i> Entradas y Salidas de Almacén
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
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Proyecto</label>
                        <select id="filtroProyecto" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Todos los proyectos</option>
                            @isset($proyectos)
                                @foreach($proyectos as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div style="display: flex; align-items: flex-end;">
                        <button id="btnActualizar" style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; width: 100%;">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                    </div>
                </div>

                <!-- Pestañas -->
                <div style="display: flex; border-bottom: 2px solid #dee2e6; margin-bottom: 20px;">
                    <button class="tab-btn active" onclick="switchTab('entradas')" id="tabEntradas" style="background-color: var(--color-primary); color: white; border: none; padding: 10px 25px; border-radius: 8px 8px 0 0; margin-right: 5px; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-arrow-down" style="color: #28a745; margin-right: 5px;"></i> Entradas
                    </button>
                    <button class="tab-btn" onclick="switchTab('salidas')" id="tabSalidas" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; border-radius: 8px 8px 0 0; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-arrow-up" style="color: #dc3545; margin-right: 5px;"></i> Salidas
                    </button>
                </div>

                <!-- Panel Entradas -->
                <div id="panelEntradas" style="display: block;">
                    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 15px;">
                        <button id="btnAgregarEntrada" class="btn-agregar" onclick="abrirModalMovimiento('entrada')" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 15px; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-plus"></i> Nueva Entrada
                        </button>
                        <button id="btnExcelEntradas" class="btn-excel" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 15px; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-file-excel"></i> Exportar
                        </button>
                    </div>

                    <div class="table-container">
                        <table class="table" id="tablaEntradas">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Proyecto</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Costo Unit.</th>
                                    <th>Importe</th>
                                    <th>Almacén</th>
                                    <th>Referencia</th>
                                    <th>Observaciones</th>
                                    <th>Registrado por</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodyEntradas">
                                <tr><td colspan="12" style="text-align: center;">Cargando...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="pagination-container" style="margin-top: 15px; display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                        <button class="page-btn" id="btnPrimeraEntrada" disabled><i class="fas fa-angle-double-left"></i></button>
                        <button class="page-btn" id="btnAnteriorEntrada" disabled><i class="fas fa-angle-left"></i></button>
                        <span>Página <span id="paginaActualEntrada">1</span> de <span id="totalPaginasEntrada">1</span></span>
                        <button class="page-btn" id="btnSiguienteEntrada" disabled><i class="fas fa-angle-right"></i></button>
                        <button class="page-btn" id="btnUltimaEntrada" disabled><i class="fas fa-angle-double-right"></i></button>
                        <select id="porPaginaEntrada" style="padding: 5px; border-radius: 4px;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>

                <!-- Panel Salidas -->
                <div id="panelSalidas" style="display: none;">
                    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 15px;">
                        <button id="btnAgregarSalida" class="btn-agregar" onclick="abrirModalMovimiento('salida')" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 15px; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-plus"></i> Nueva Salida
                        </button>
                        <button id="btnExcelSalidas" class="btn-excel" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 15px; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-file-excel"></i> Exportar
                        </button>
                    </div>

                    <div class="table-container">
                        <table class="table" id="tablaSalidas">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Proyecto</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Costo Unit.</th>
                                    <th>Importe</th>
                                    <th>Almacén</th>
                                    <th>Referencia</th>
                                    <th>Solicitante</th>
                                    <th>Observaciones</th>
                                    <th>Registrado por</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodySalidas">
                                <tr><td colspan="13" style="text-align: center;">Cargando...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="pagination-container" style="margin-top: 15px; display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                        <button class="page-btn" id="btnPrimeraSalida" disabled><i class="fas fa-angle-double-left"></i></button>
                        <button class="page-btn" id="btnAnteriorSalida" disabled><i class="fas fa-angle-left"></i></button>
                        <span>Página <span id="paginaActualSalida">1</span> de <span id="totalPaginasSalida">1</span></span>
                        <button class="page-btn" id="btnSiguienteSalida" disabled><i class="fas fa-angle-right"></i></button>
                        <button class="page-btn" id="btnUltimaSalida" disabled><i class="fas fa-angle-double-right"></i></button>
                        <select id="porPaginaSalida" style="padding: 5px; border-radius: 4px;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA MOVIMIENTO (ENTRADA/SALIDA) -->
<div id="modalMovimiento" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 650px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;" id="modalTituloMovimiento">Nuevo Movimiento</h3>
            <button onclick="cerrarModalMovimiento()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;">
            <input type="hidden" id="movimientoTipo">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div id="divOrigenEntrada" style="grid-column: span 2; display: none;">
                    <label style="font-size: 13px; font-weight: 600;">Origen de la Entrada <span style="color: red;">*</span></label>
                    <select id="modalOrigenEntrada" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="manual">📝 Entrada Manual</option>
                        <option value="compra">🛒 De Compra Autorizada</option>
                        <option value="devolucion">🔄 Devolución de obra</option>
                    </select>
                </div>

                <div id="panelCompra" style="display: none; grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Seleccionar Orden de Compra <span style="color: red;">*</span></label>
                    <select id="modalCompra" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Cargando compras pendientes...</option>
                    </select>
                    <button type="button" id="btnVerArticulosCompra" style="margin-top: 8px; background-color: #28a745; color: white; border: none; border-radius: 4px; padding: 6px 12px; font-size: 12px; cursor: pointer;">
                        <i class="fas fa-boxes"></i> Ver artículos de esta compra
                    </button>
                </div>

                <div>
                    <label style="font-size: 13px; font-weight: 600;">Proyecto <span style="color: red;">*</span></label>
                    <select id="modalProyecto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar proyecto</option>
                        @isset($proyectos)
                            @foreach($proyectos as $proyecto)
                                <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Fecha <span style="color: red;">*</span></label>
                    <input type="date" id="modalFecha" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Artículo <span style="color: red;">*</span></label>
                    <select id="modalArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar artículo</option>
                        @isset($articulos)
                            @foreach($articulos as $articulo)
                                <option value="{{ $articulo->id }}">{{ $articulo->codigo }} - {{ $articulo->descripcion }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Almacén <span style="color: red;">*</span></label>
                    <select id="modalAlmacen" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar almacén</option>
                        @isset($almacenes)
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}">{{ $almacen->codigo }} - {{ $almacen->nombre }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Cantidad <span style="color: red;">*</span></label>
                    <input type="number" step="0.001" id="modalCantidad" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00">
                </div>
                <div id="divCosto" style="display: none;">
                    <label style="font-size: 13px; font-weight: 600;">Costo Unitario</label>
                    <input type="number" step="0.01" id="modalCosto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; background-color: #e9ecef;" readonly placeholder="Se carga automáticamente">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Referencia</label>
                    <input type="text" id="modalReferencia" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Factura, orden, etc.">
                </div>
                <div id="divSolicitante" style="display: none; grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Solicitante</label>
                    <input type="text" id="modalSolicitante" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Nombre de quien solicita">
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Observaciones</label>
                    <textarea id="modalObservaciones" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones..."></textarea>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalMovimiento()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarMovimiento()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA VER ARTÍCULOS DE LA COMPRA (MÚLTIPLES) -->
<div id="modalArticulosCompra" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100001; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 950px; max-height: 85vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;"><i class="fas fa-boxes"></i> Artículos de la Orden de Compra</h3>
            <button onclick="cerrarModalArticulos()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;">
            <div id="infoCompraResumen" style="background-color: #e8f0fe; border-radius: 8px; padding: 12px; margin-bottom: 20px;"></div>
            
            <div class="table-container">
                <table class="table" id="tablaArticulosCompra">
                    <thead>
                        <tr>
                            <th style="width: 40px;"><input type="checkbox" id="seleccionarTodosArticulos" style="transform: scale(1.2);"></th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Unidad</th>
                            <th style="text-align: center;">Pendiente</th>
                            <th style="text-align: center;">Costo Unit.</th>
                            <th style="text-align: center;">Importe</th>
                            <th style="text-align: center; min-width: 100px;">A Recibir</th>
                            <th>Observación</th>
                        </tr>
                    </thead>
                    <tbody id="tablaArticulosCompraBody">
                        <tr><td colspan="9" style="text-align: center;">Seleccione una compra primero</td></tr>
                    </tbody>
                    <tfoot style="background-color: #e9ecef; font-weight: bold;">
                        <tr>
                            <td colspan="4" style="text-align: right;">Totales:</td>
                            <td id="totalPendienteCompra" style="text-align: center;">0</td>
                            <td style="text-align: center;">---</td>
                            <td id="totalImporteCompra" style="text-align: center;">$0</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalArticulos()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button id="btnRegistrarRecepcionMultiple" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">
                    <i class="fas fa-save"></i> Registrar Recepción
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    :root { --color-primary: #083CAE; }
    .table-container { border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; max-height: 500px; overflow-y: auto; }
    .table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .table th { background-color: var(--color-primary) !important; color: white; padding: 12px 8px; border: 1px solid #dee2e6; position: sticky; top: 0; }
    .table td { padding: 10px 8px; border: 1px solid #dee2e6; }
    tbody tr:nth-child(even) { background-color: #f8f9fa; }
    tbody tr:hover { background-color: #e8f0fe; }
    .page-btn { padding: 5px 12px; border: 1px solid var(--color-primary); border-radius: 4px; background: white; cursor: pointer; color: var(--color-primary); }
    .page-btn:disabled { opacity: 0.5; cursor: not-allowed; }
    .btn-agregar:hover, .btn-excel:hover { background-color: var(--color-primary) !important; color: white !important; }
    .cantidad-recibir { width: 100px; text-align: center; }
    .cantidad-recibir input { width: 100%; padding: 5px; text-align: center; }
    .badge-pendiente { background-color: #ffc107; color: #212529; padding: 2px 8px; border-radius: 20px; font-size: 11px; }
    @media (max-width: 768px) { div[style*="grid-template-columns: repeat(4, 1fr)"] { grid-template-columns: repeat(2, 1fr) !important; } }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
let movimientoTipo = 'entrada';
let currentPageEntrada = 1, currentPageSalida = 1;
let perPageEntrada = 10, perPageSalida = 10;
let articulosCompraData = [];
let compraSeleccionadaId = null;

document.addEventListener('DOMContentLoaded', function() {
    cargarMovimientos('entrada');
    cargarMovimientos('salida');
    configurarEventos();
    
    const origenSelect = document.getElementById('modalOrigenEntrada');
    if (origenSelect) {
        origenSelect.addEventListener('change', function() {
            const panelCompra = document.getElementById('panelCompra');
            const divCosto = document.getElementById('divCosto');
            const campoReferencia = document.getElementById('modalReferencia');
            const selectArticulo = document.getElementById('modalArticulo');
            
            if (this.value === 'compra') {
                panelCompra.style.display = 'block';
                divCosto.style.display = 'block';
                campoReferencia.placeholder = 'Se asigna automáticamente';
                campoReferencia.readOnly = true;
                selectArticulo.disabled = true;
                selectArticulo.value = '';
                cargarComprasPendientes();
            } else {
                panelCompra.style.display = 'none';
                divCosto.style.display = 'none';
                campoReferencia.placeholder = 'Factura, orden, etc.';
                campoReferencia.readOnly = false;
                selectArticulo.disabled = false;
                document.getElementById('modalCosto').value = '';
            }
        });
    }
    
    document.getElementById('btnVerArticulosCompra')?.addEventListener('click', function() {
        const compraSelect = document.getElementById('modalCompra');
        const compraId = compraSelect.value;
        if (!compraId) {
            alert('⚠️ Seleccione una orden de compra primero');
            return;
        }
        abrirModalArticulosCompra(compraId);
    });
    
    document.getElementById('seleccionarTodosArticulos')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('#tablaArticulosCompraBody .chk-articulo-compra');
        checkboxes.forEach(chk => chk.checked = this.checked);
    });
    
    document.getElementById('btnRegistrarRecepcionMultiple')?.addEventListener('click', registrarRecepcionMultiple);
});

function cargarMovimientos(tipo) {
    const fechaInicio = document.getElementById('fechaInicio')?.value || '';
    const fechaFin = document.getElementById('fechaFin')?.value || '';
    const proyectoId = document.getElementById('filtroProyecto')?.value || '';
    const currentPage = tipo === 'entrada' ? currentPageEntrada : currentPageSalida;
    const perPage = tipo === 'entrada' ? perPageEntrada : perPageSalida;
    
    let url = `/inventario/api/movimientos?tipo=${tipo === 'entrada' ? 'Entrada' : 'Salida'}&page=${currentPage}&per_page=${perPage}`;
    if (fechaInicio) url += `&fecha_inicio=${fechaInicio}`;
    if (fechaFin) url += `&fecha_fin=${fechaFin}`;
    if (proyectoId) url += `&proyecto_id=${proyectoId}`;
    
    fetch(url)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                renderizarTabla(tipo, response.data);
                actualizarPaginacion(tipo, response.current_page, response.last_page, response.total);
            }
        })
        .catch(error => console.error('Error:', error));
}

function renderizarTabla(tipo, data) {
    const tbody = document.getElementById(`tablaBody${tipo === 'entrada' ? 'Entradas' : 'Salidas'}`);
    if (!data || !data.length) {
        tbody.innerHTML = `<tr><td colspan="${tipo === 'entrada' ? '12' : '13'}" style="text-align: center;">No hay movimientos registrados</td></tr>`;
        return;
    }
    
    tbody.innerHTML = '';
    data.forEach((item, index) => {
        const row = tbody.insertRow();
        row.style.backgroundColor = index % 2 === 1 ? '#f8f9fa' : 'white';
        row.insertCell(0).innerHTML = item.id;
        row.insertCell(1).innerHTML = item.fecha_movimiento;
        row.insertCell(2).innerHTML = item.proyecto_nombre || '---';
        row.insertCell(3).innerHTML = `${item.articulo_codigo}<br><small>${item.articulo_descripcion || ''}</small>`;
        row.insertCell(4).innerHTML = `${item.cantidad} ${item.unidad_medida || ''}`;
        row.insertCell(5).innerHTML = item.costo_unitario ? `$${parseFloat(item.costo_unitario).toFixed(2)}` : '---';
        row.insertCell(6).innerHTML = item.importe ? `$${parseFloat(item.importe).toFixed(2)}` : '---';
        row.insertCell(7).innerHTML = item.almacen_nombre || '---';
        row.insertCell(8).innerHTML = item.referencia_folio || '---';
        
        if (tipo === 'salida') {
            row.insertCell(9).innerHTML = item.solicitante || '---';
            row.insertCell(10).innerHTML = item.observaciones || '---';
            row.insertCell(11).innerHTML = item.creado_por || '---';
            row.insertCell(12).innerHTML = `<i class="fas fa-eye" onclick="verDetalle(${item.id})" style="color: var(--color-primary); cursor: pointer;"></i>`;
        } else {
            row.insertCell(9).innerHTML = item.observaciones || '---';
            row.insertCell(10).innerHTML = item.creado_por || '---';
            row.insertCell(11).innerHTML = `<i class="fas fa-eye" onclick="verDetalle(${item.id})" style="color: var(--color-primary); cursor: pointer;"></i>`;
        }
    });
}

function actualizarPaginacion(tipo, currentPage, lastPage, total) {
    const prefix = tipo === 'entrada' ? 'Entrada' : 'Salida';
    document.getElementById(`paginaActual${prefix}`).textContent = currentPage;
    document.getElementById(`totalPaginas${prefix}`).textContent = lastPage;
    document.getElementById(`btnPrimera${prefix}`).disabled = currentPage === 1;
    document.getElementById(`btnAnterior${prefix}`).disabled = currentPage === 1;
    document.getElementById(`btnSiguiente${prefix}`).disabled = currentPage === lastPage;
    document.getElementById(`btnUltima${prefix}`).disabled = currentPage === lastPage;
}

function configurarEventos() {
    document.getElementById('btnActualizar')?.addEventListener('click', () => {
        cargarMovimientos('entrada');
        cargarMovimientos('salida');
    });
    
    document.getElementById('btnPrimeraEntrada')?.addEventListener('click', () => { currentPageEntrada = 1; cargarMovimientos('entrada'); });
    document.getElementById('btnAnteriorEntrada')?.addEventListener('click', () => { if (currentPageEntrada > 1) { currentPageEntrada--; cargarMovimientos('entrada'); } });
    document.getElementById('btnSiguienteEntrada')?.addEventListener('click', () => { currentPageEntrada++; cargarMovimientos('entrada'); });
    document.getElementById('btnUltimaEntrada')?.addEventListener('click', () => { currentPageEntrada = 999; cargarMovimientos('entrada'); });
    document.getElementById('porPaginaEntrada')?.addEventListener('change', (e) => { perPageEntrada = parseInt(e.target.value); currentPageEntrada = 1; cargarMovimientos('entrada'); });
    
    document.getElementById('btnPrimeraSalida')?.addEventListener('click', () => { currentPageSalida = 1; cargarMovimientos('salida'); });
    document.getElementById('btnAnteriorSalida')?.addEventListener('click', () => { if (currentPageSalida > 1) { currentPageSalida--; cargarMovimientos('salida'); } });
    document.getElementById('btnSiguienteSalida')?.addEventListener('click', () => { currentPageSalida++; cargarMovimientos('salida'); });
    document.getElementById('btnUltimaSalida')?.addEventListener('click', () => { currentPageSalida = 999; cargarMovimientos('salida'); });
    document.getElementById('porPaginaSalida')?.addEventListener('change', (e) => { perPageSalida = parseInt(e.target.value); currentPageSalida = 1; cargarMovimientos('salida'); });
    
    document.getElementById('btnExcelEntradas')?.addEventListener('click', () => window.location.href = '/inventario/api/movimientos/exportar?tipo=Entrada');
    document.getElementById('btnExcelSalidas')?.addEventListener('click', () => window.location.href = '/inventario/api/movimientos/exportar?tipo=Salida');
}

async function cargarComprasPendientes() {
    const selectCompra = document.getElementById('modalCompra');
    selectCompra.innerHTML = '<option>Cargando...</option>';
    
    try {
        const response = await fetch('/compras/api/pendientes-recepcion');
        const data = await response.json();
        
        if (data.success && data.data.length > 0) {
            selectCompra.innerHTML = '<option value="">Seleccionar orden de compra</option>';
            data.data.forEach(compra => {
                selectCompra.innerHTML += `<option value="${compra.id}" 
                    data-proyecto-id="${compra.proyecto_id}"
                    data-folio="${compra.folio_requisicion}"
                    data-proveedor="${compra.proveedor_nombre}">
                    📄 ${compra.folio_requisicion} - ${compra.proveedor_nombre} (${compra.total_articulos} artículos, ${compra.total_pendiente} pendientes)
                </option>`;
            });
        } else {
            selectCompra.innerHTML = '<option value="">No hay compras pendientes</option>';
        }
    } catch (error) {
        console.error('Error:', error);
        selectCompra.innerHTML = '<option value="">Error al cargar compras</option>';
    }
}

async function abrirModalArticulosCompra(compraId) {
    const almacenId = document.getElementById('modalAlmacen').value;
    if (!almacenId) {
        alert('⚠️ Primero seleccione el Almacén de destino en el formulario principal');
        return;
    }
    
    const proyectoId = document.getElementById('modalProyecto').value;
    if (!proyectoId) {
        alert('⚠️ Primero seleccione el Proyecto en el formulario principal');
        return;
    }
    
    compraSeleccionadaId = compraId;
    const tbody = document.getElementById('tablaArticulosCompraBody');
    tbody.innerHTML = '<tr><td colspan="9" style="text-align: center;"><i class="fas fa-spinner fa-spin"></i> Cargando...</tr></td></tr>';
    
    try {
        const response = await fetch(`/compras/api/pendientes-recepcion/${compraId}/detalle`);
        const data = await response.json();
        
        if (data.success && data.data.articulos && data.data.articulos.length > 0) {
            articulosCompraData = data.data.articulos;
            const almacenText = document.getElementById('modalAlmacen').options[document.getElementById('modalAlmacen').selectedIndex]?.text || 'No seleccionado';
            document.getElementById('infoCompraResumen').innerHTML = `
                <strong>📄 Folio:</strong> ${data.data.folio_requisicion} | 
                <strong>🏢 Proveedor:</strong> ${data.data.proveedor} | 
                <strong>🏗️ Proyecto:</strong> ${data.data.proyecto_nombre}<br>
                <strong>🏪 Almacén:</strong> ${almacenText}
            `;
            renderizarTablaArticulosCompra(articulosCompraData);
            document.getElementById('modalArticulosCompra').style.display = 'flex';
        } else {
            alert('No se encontraron artículos pendientes para esta compra');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al cargar artículos');
    }
}

function renderizarTablaArticulosCompra(articulos) {
    const tbody = document.getElementById('tablaArticulosCompraBody');
    let totalPendiente = 0;
    let totalImporte = 0;
    
    if (!articulos || !articulos.length) {
        tbody.innerHTML = '<tr><td colspan="9" style="text-align: center;">No hay artículos pendientes</td></tr>';
        return;
    }
    
    tbody.innerHTML = '';
    articulos.forEach((art, idx) => {
        const pendiente = parseFloat(art.cantidad_pendiente) || 0;
        const costo = parseFloat(art.costo_unitario) || 0;
        const importe = pendiente * costo;
        totalPendiente += pendiente;
        totalImporte += importe;
        
        const row = tbody.insertRow();
        row.insertCell(0).innerHTML = `<input type="checkbox" class="chk-articulo-compra" data-index="${idx}" checked style="transform: scale(1.2);">`;
        row.insertCell(1).innerHTML = `<strong>${art.articulo_codigo || '---'}</strong>`;
        row.insertCell(2).innerHTML = art.articulo_descripcion || '---';
        row.insertCell(3).innerHTML = art.unidad_medida || 'pza';
        row.insertCell(4).innerHTML = `<span class="badge-pendiente">${pendiente}</span>`;
        row.insertCell(5).innerHTML = `$${costo.toFixed(2)}`;
        row.insertCell(6).innerHTML = `$${importe.toFixed(2)}`;
        row.insertCell(7).innerHTML = `<input type="number" class="cantidad-recibir-compra" data-index="${idx}" data-max="${pendiente}" value="${pendiente}" min="0" max="${pendiente}" step="0.001" style="width: 90px; padding: 5px; text-align: center; border:1px solid #ced4da; border-radius:4px;">`;
        row.insertCell(8).innerHTML = `<input type="text" class="obs-recibir-compra" data-index="${idx}" placeholder="Observación" style="width:100%; padding:5px; border:1px solid #ced4da; border-radius:4px;">`;
        
        const cantidadInput = row.cells[7].querySelector('.cantidad-recibir-compra');
        cantidadInput.addEventListener('change', function() {
            const newCantidad = parseFloat(this.value) || 0;
            const nuevoImporte = newCantidad * costo;
            row.cells[6].innerHTML = `$${nuevoImporte.toFixed(2)}`;
            recalcularTotalesCompra();
        });
    });
    
    document.getElementById('totalPendienteCompra').textContent = totalPendiente;
    document.getElementById('totalImporteCompra').textContent = `$${totalImporte.toFixed(2)}`;
}

function recalcularTotalesCompra() {
    const inputs = document.querySelectorAll('.cantidad-recibir-compra');
    let total = 0;
    let totalImporte = 0;
    inputs.forEach(input => {
        const idx = parseInt(input.dataset.index);
        const cantidad = parseFloat(input.value) || 0;
        const costo = parseFloat(articulosCompraData[idx]?.costo_unitario) || 0;
        total += cantidad;
        totalImporte += cantidad * costo;
    });
    document.getElementById('totalPendienteCompra').textContent = total;
    document.getElementById('totalImporteCompra').textContent = `$${totalImporte.toFixed(2)}`;
}

async function registrarRecepcionMultiple() {
    const checkboxes = document.querySelectorAll('.chk-articulo-compra:checked');
    if (checkboxes.length === 0) {
        alert('⚠️ Seleccione al menos un artículo');
        return;
    }
    
    const items = [];
    let errorArticulos = false;
    let articulosCreados = [];
    
    for (const chk of checkboxes) {
        const idx = parseInt(chk.dataset.index);
        const cantidadInput = document.querySelector(`.cantidad-recibir-compra[data-index="${idx}"]`);
        const obsInput = document.querySelector(`.obs-recibir-compra[data-index="${idx}"]`);
        const cantidad = parseFloat(cantidadInput?.value) || 0;
        
        if (cantidad > 0 && articulosCompraData[idx]) {
            let articuloId = articulosCompraData[idx].articulo_id;
            const articuloCodigo = articulosCompraData[idx].articulo_codigo;
            const articuloDescripcion = articulosCompraData[idx].articulo_descripcion;
            const unidadMedida = articulosCompraData[idx].unidad_medida || 'Pieza';
            
            if (!articuloId || articuloId === 0 || isNaN(articuloId)) {
                try {
                    const createResponse = await fetch('/inventario/api/articulos/crear-temporal', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            codigo: articuloCodigo,
                            descripcion: articuloDescripcion,
                            unidad_medida: unidadMedida
                        })
                    });
                    
                    const createData = await createResponse.json();
                    
                    if (createData.success && createData.data.id) {
                        articuloId = createData.data.id;
                        articulosCreados.push(articuloCodigo);
                    } else {
                        alert(`⚠️ No se pudo crear el artículo "${articuloCodigo}". Por favor, verifique.`);
                        errorArticulos = true;
                        break;
                    }
                } catch (error) {
                    alert(`⚠️ Error al crear el artículo "${articuloCodigo}". Por favor, verifique.`);
                    errorArticulos = true;
                    break;
                }
            }
            
            items.push({
                articulo_id: parseInt(articuloId),
                cantidad: cantidad,
                costo_unitario: parseFloat(articulosCompraData[idx].costo_unitario) || 0,
                observacion: obsInput?.value || ''
            });
        }
    }
    
    if (errorArticulos) return;
    
    if (items.length === 0) {
        alert('No hay cantidades válidas para recibir');
        return;
    }
    
    if (articulosCreados.length > 0) {
        alert(`📦 Se crearon automáticamente los siguientes artículos:\n${articulosCreados.join('\n')}\n\nContinúe con la recepción.`);
    }
    
    const almacenId = document.getElementById('modalAlmacen').value;
    if (!almacenId) {
        alert('⚠️ Seleccione el almacén de destino en el formulario principal');
        cerrarModalArticulos();
        return;
    }
    
    const proyectoId = document.getElementById('modalProyecto').value;
    if (!proyectoId) {
        alert('⚠️ Seleccione el proyecto en el formulario principal');
        cerrarModalArticulos();
        return;
    }
    
    const btn = document.getElementById('btnRegistrarRecepcionMultiple');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registrando...';
    btn.disabled = true;
    
    const dataToSend = {
        compra_id: parseInt(compraSeleccionadaId),
        proyecto_id: parseInt(proyectoId),
        almacen_id: parseInt(almacenId),
        fecha_movimiento: document.getElementById('modalFecha').value,
        items: items
    };
    
    try {
        const response = await fetch('/inventario/api/movimientos/recepcion-multiple', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: JSON.stringify(dataToSend)
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            let mensaje = `✅ ${data.message}`;
            if (articulosCreados.length > 0) {
                mensaje += `\n\n📦 Artículos creados automáticamente:\n${articulosCreados.join('\n')}`;
            }
            alert(mensaje);
            cerrarModalArticulos();
            cerrarModalMovimiento();
            cargarMovimientos('entrada');
            cargarMovimientos('salida');
            cargarComprasPendientes();
        } else {
            let errorMsg = 'Error: ';
            if (data.errors) {
                errorMsg += JSON.stringify(data.errors);
            } else if (data.message) {
                errorMsg += data.message;
            } else {
                errorMsg += 'Error desconocido';
            }
            alert(errorMsg);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Error al registrar: ' + error.message);
    } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }
}

window.switchTab = function(tab) {
    const panelEntradas = document.getElementById('panelEntradas');
    const panelSalidas = document.getElementById('panelSalidas');
    const tabEntradas = document.getElementById('tabEntradas');
    const tabSalidas = document.getElementById('tabSalidas');
    
    if (tab === 'entradas') {
        panelEntradas.style.display = 'block';
        panelSalidas.style.display = 'none';
        tabEntradas.style.backgroundColor = 'var(--color-primary)';
        tabEntradas.style.color = 'white';
        tabSalidas.style.backgroundColor = '#e9ecef';
        tabSalidas.style.color = '#495057';
    } else {
        panelEntradas.style.display = 'none';
        panelSalidas.style.display = 'block';
        tabSalidas.style.backgroundColor = 'var(--color-primary)';
        tabSalidas.style.color = 'white';
        tabEntradas.style.backgroundColor = '#e9ecef';
        tabEntradas.style.color = '#495057';
    }
};

window.abrirModalMovimiento = function(tipo) {
    movimientoTipo = tipo;
    const modal = document.getElementById('modalMovimiento');
    const titulo = document.getElementById('modalTituloMovimiento');
    const divOrigen = document.getElementById('divOrigenEntrada');
    const divSolicitante = document.getElementById('divSolicitante');
    const panelCompra = document.getElementById('panelCompra');
    const divCosto = document.getElementById('divCosto');
    const selectArticulo = document.getElementById('modalArticulo');
    const selectProyecto = document.getElementById('modalProyecto');
    
    if (tipo === 'entrada') {
        titulo.textContent = '📥 Nueva Entrada de Material';
        divOrigen.style.display = 'block';
        divSolicitante.style.display = 'none';
        panelCompra.style.display = 'none';
        divCosto.style.display = 'none';
        selectArticulo.disabled = false;
        selectProyecto.disabled = false;
    } else {
        titulo.textContent = '📤 Nueva Salida de Material';
        divOrigen.style.display = 'none';
        divSolicitante.style.display = 'block';
        panelCompra.style.display = 'none';
        divCosto.style.display = 'none';
        selectArticulo.disabled = false;
        selectProyecto.disabled = false;
    }
    
    document.getElementById('movimientoTipo').value = tipo;
    document.getElementById('modalProyecto').value = '';
    document.getElementById('modalFecha').value = new Date().toISOString().split('T')[0];
    document.getElementById('modalArticulo').value = '';
    document.getElementById('modalAlmacen').value = '';
    document.getElementById('modalCantidad').value = '';
    document.getElementById('modalCantidad').readOnly = false;
    document.getElementById('modalReferencia').value = '';
    document.getElementById('modalReferencia').readOnly = false;
    document.getElementById('modalSolicitante').value = '';
    document.getElementById('modalObservaciones').value = '';
    document.getElementById('modalCosto').value = '';
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
};

window.guardarMovimiento = async function() {
    const tipo = movimientoTipo;
    const proyectoId = document.getElementById('modalProyecto').value;
    const articuloId = document.getElementById('modalArticulo').value;
    const almacenId = document.getElementById('modalAlmacen').value;
    const cantidad = document.getElementById('modalCantidad').value;
    
    if (!proyectoId || !articuloId || !almacenId || !cantidad || cantidad <= 0) {
        alert('⚠️ Complete todos los campos obligatorios');
        return;
    }
    
    if (tipo === 'salida') {
        try {
            const response = await fetch(`/inventario/api/movimientos/verificar-stock?proyecto_id=${proyectoId}&articulo_id=${articuloId}&almacen_id=${almacenId}&cantidad=${cantidad}`);
            const data = await response.json();
            if (!data.success || !data.data.stock_suficiente) {
                alert(data.message || 'Stock insuficiente');
                return;
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al verificar stock');
            return;
        }
    }
    
    const data = {
        proyecto_id: proyectoId,
        articulo_id: articuloId,
        almacen_id: almacenId,
        cantidad: parseFloat(cantidad),
        fecha_movimiento: document.getElementById('modalFecha').value,
        observaciones: document.getElementById('modalObservaciones').value
    };
    
    if (tipo === 'entrada') {
        const origen = document.getElementById('modalOrigenEntrada').value;
        data.origen = origen;
        if (origen === 'compra') {
            const compraId = document.getElementById('modalCompra').value;
            if (!compraId) { 
                alert('Seleccione una orden de compra'); 
                return; 
            }
            data.compra_id = compraId;
            data.costo_unitario = document.getElementById('modalCosto').value;
        } else {
            data.referencia_folio = document.getElementById('modalReferencia').value;
        }
    } else {
        data.solicitante = document.getElementById('modalSolicitante').value || '';
        data.referencia_folio = document.getElementById('modalReferencia').value;
    }
    
    const url = tipo === 'entrada' ? '/inventario/api/movimientos/entrada' : '/inventario/api/movimientos/salida';
    
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
    btn.disabled = true;
    
    fetch(url, {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json', 
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' 
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(response => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        if (response.success) {
            alert('✅ ' + response.message);
            cerrarModalMovimiento();
            cargarMovimientos('entrada');
            cargarMovimientos('salida');
        } else {
            alert('❌ Error: ' + response.message);
        }
    })
    .catch(error => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        console.error('Error:', error);
        alert('❌ Error: ' + error.message);
    });
};

window.verDetalle = async function(id) {
    if (!id) {
        alert('ID no válido');
        return;
    }
    
    try {
        const response = await fetch(`/inventario/api/movimientos/${id}`);
        const data = await response.json();
        if (data.success && data.data) {
            const m = data.data;
            let detalles = `╔════════════════════════════════════════════════════════════╗\n`;
            detalles += `║                    MOVIMIENTO #${m.id}                      ║\n`;
            detalles += `╠════════════════════════════════════════════════════════════╣\n`;
            detalles += `║ 📅 Fecha:        ${m.fecha_movimiento}\n`;
            detalles += `║ 📌 Tipo:         ${m.tipo_movimiento}\n`;
            detalles += `║ 🏗️ Proyecto:     ${m.proyecto_nombre || 'N/A'}\n`;
            detalles += `║ 📦 Artículo:     ${m.articulo_codigo} - ${m.articulo_descripcion}\n`;
            detalles += `║ 🔢 Cantidad:     ${m.cantidad}\n`;
            detalles += `║ 💰 Costo Unit.:  ${m.costo_unitario ? '$' + parseFloat(m.costo_unitario).toFixed(2) : 'N/A'}\n`;
            detalles += `║ 💵 Importe:      ${m.importe ? '$' + parseFloat(m.importe).toFixed(2) : 'N/A'}\n`;
            detalles += `║ 🏪 Almacén:      ${m.almacen_nombre || 'N/A'}\n`;
            detalles += `║ 📄 Referencia:   ${m.referencia_folio || 'N/A'}\n`;
            detalles += `║ 👤 Solicitante:  ${m.solicitante || 'N/A'}\n`;
            detalles += `║ 💬 Observaciones: ${m.observaciones || 'N/A'}\n`;
            detalles += `║ 👨‍💼 Registrado:   ${m.creado_por || 'N/A'}\n`;
            detalles += `╠════════════════════════════════════════════════════════════╣\n`;
            detalles += `║ 📊 Stock antes:  ${m.cantidad_antes}\n`;
            detalles += `║ 📊 Stock después: ${m.cantidad_despues}\n`;
            detalles += `╚════════════════════════════════════════════════════════════╝`;
            alert(detalles);
        } else {
            alert('❌ No se encontró el movimiento');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Error al conectar con el servidor');
    }
};

window.cerrarModalMovimiento = function() {
    document.getElementById('modalMovimiento').style.display = 'none';
    document.body.style.overflow = 'auto';
    document.getElementById('modalProyecto').disabled = false;
    document.getElementById('modalArticulo').disabled = false;
};

window.cerrarModalArticulos = function() {
    document.getElementById('modalArticulosCompra').style.display = 'none';
};

document.addEventListener('keydown', (e) => { 
    if (e.key === 'Escape') { 
        cerrarModalMovimiento(); 
        cerrarModalArticulos(); 
    } 
});

document.getElementById('modalMovimiento')?.addEventListener('click', (e) => { 
    if (e.target === document.getElementById('modalMovimiento')) cerrarModalMovimiento(); 
});

document.getElementById('modalArticulosCompra')?.addEventListener('click', (e) => { 
    if (e.target === document.getElementById('modalArticulosCompra')) cerrarModalArticulos(); 
});
</script>
@endsection