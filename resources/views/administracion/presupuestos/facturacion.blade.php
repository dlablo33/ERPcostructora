@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE !important; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-file-invoice me-2"></i> Facturas Proveedores
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px;"></i>
                        <span style="color: #6c757d; font-size: 12px;">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <input type="date" id="fechaInicio" value="{{ date('Y-m-01') }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; width: 140px;">
                        <input type="date" id="fechaFin" value="{{ date('Y-m-d') }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; width: 140px;">
                        <button id="btnAgregar" style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; width: 36px; height: 36px; cursor: pointer;">
                            <i class="fas fa-plus" style="color: #2378e1;"></i>
                        </button>
                        <button id="btnExcel" style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px; cursor: pointer;">
                            <i class="fas fa-file-excel" style="color: #2378e1;"></i> Excel
                        </button>
                        <button id="btnRecargar" style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px; cursor: pointer;">
                            <i class="fas fa-sync-alt" style="color: #2378e1;"></i>
                        </button>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #2378e1;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #2378e1; border-radius: 4px; width: 250px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 500px; overflow-y: auto;">
                    <table class="table table-bordered" id="tablaFacturas" style="width: 100%; font-size: 12px;">
                        <thead style="position: sticky; top: 0; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="padding: 10px;">Estatus</th>
                                <th style="padding: 10px;">Folio</th>
                                <th style="padding: 10px;">Proveedor</th>
                                <th style="padding: 10px;">Fecha</th>
                                <th style="padding: 10px;">F. Vencimiento</th>
                                <th style="padding: 10px; text-align: right;">Subtotal</th>
                                <th style="padding: 10px; text-align: right;">IVA</th>
                                <th style="padding: 10px; text-align: right;">Total</th>
                                <th style="padding: 10px; text-align: right;">Saldo</th>
                                <th style="padding: 10px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="10" class="text-center py-5"><div class="spinner-border text-primary"></div><p>Cargando facturas...</p></td></tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="5" style="padding: 10px;">TOTALES:</td>
                                <td id="sumSubtotal" style="padding: 10px; text-align: right;">$0.00</td>
                                <td id="sumIva" style="padding: 10px; text-align: right;">$0.00</td>
                                <td id="sumTotal" style="padding: 10px; text-align: right;">$0.00</td>
                                <td id="sumSaldo" style="padding: 10px; text-align: right;">$0.00</td>
                                <td style="padding: 10px;"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 15px; gap: 5px;">
                    <button id="btnPrimera" style="padding: 5px 10px; border: none; background: none; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-double-left"></i></button>
                    <button id="btnAnterior" style="padding: 5px 10px; border: none; background: none; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-left"></i></button>
                    <span id="paginaActual" style="padding: 5px 10px; background-color: #2378e1; color: white; border-radius: 4px;">1</span>
                    <button id="btnSiguiente" style="padding: 5px 10px; border: none; background: none; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-right"></i></button>
                    <button id="btnUltima" style="padding: 5px 10px; border: none; background: none; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-double-right"></i></button>
                    <span id="paginacionInfo" style="margin-left: 10px; color: #2378e1;"></span>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL AGREGAR FACTURA -->
<div class="modal fade" id="modalFacturaProveedor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #2378e1, #1a5bbf); color: white;">
                <h5 class="modal-title"><i class="fas fa-file-invoice me-2"></i> Factura de Proveedor</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form id="formFacturaProveedor">
                <div class="modal-body" style="max-height: 65vh; overflow-y: auto; padding: 20px;">
                    <input type="hidden" id="factura_id" name="factura_id">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Proveedor <span class="text-danger">*</span></label>
                            <select class="form-control" id="proveedor_id" required>
                                <option value="">-- Seleccione un proveedor --</option>
                                @if(isset($proveedores) && count($proveedores) > 0)
                                    @foreach($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }} - {{ $proveedor->rfc }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <small><a href="#" id="btnNuevoProveedorModal"><i class="fas fa-plus-circle"></i> Nuevo proveedor</a></small>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="fw-bold">Serie</label>
                            <input type="text" class="form-control" id="serie" placeholder="F">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="fw-bold">Folio <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="folio" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="fw-bold">Fecha</label>
                            <input type="date" class="form-control" id="fecha" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="fw-bold">F. Vencimiento</label>
                            <input type="date" class="form-control" id="fecha_vencimiento" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="fw-bold">Método Pago</label>
                            <select class="form-control" id="metodo_pago">
                                <option value="PUE">PUE</option>
                                <option value="PPD">PPD</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="fw-bold">Forma Pago</label>
                            <select class="form-control" id="forma_pago">
                                <option value="01">Efectivo</option>
                                <option value="02">Cheque</option>
                                <option value="03">Transferencia</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="fw-bold">Moneda</label>
                            <select class="form-control" id="moneda">
                                <option value="MXN">MXN</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="fw-bold">Tipo Cambio</label>
                            <input type="number" step="0.000001" class="form-control" id="tipo_cambio" value="1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">UUID</label>
                            <input type="text" class="form-control" id="uuid" placeholder="XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="fw-bold">Observaciones</label>
                            <textarea class="form-control" id="observaciones" rows="2"></textarea>
                        </div>
                    </div>
                    
                    <hr>
                    <h6><i class="fas fa-list"></i> Conceptos</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:50%">Descripción</th>
                                    <th style="width:15%">Cantidad</th>
                                    <th style="width:20%">Precio</th>
                                    <th style="width:15%">Importe</th>
                                    <th style="width:5%"></th>
                                </tr>
                            </thead>
                            <tbody id="conceptosBody"></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end">Subtotal:</td>
                                    <td><input type="text" id="subtotal" class="form-control form-control-sm text-end" readonly style="background:#e9ecef;"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">IVA (16%):</td>
                                    <td><input type="text" id="iva" class="form-control form-control-sm text-end" readonly style="background:#e9ecef;"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">TOTAL:</td>
                                    <td><input type="text" id="total" class="form-control form-control-sm text-end fw-bold" readonly style="background:#e9ecef; color:#2378e1;"></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" id="btnAgregarConceptoModal"><i class="fas fa-plus"></i> Agregar concepto</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Factura</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL NUEVO PROVEEDOR -->
<div class="modal fade" id="modalNuevoProveedor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #28a745, #1e7e34); color: white;">
                <h5 class="modal-title"><i class="fas fa-truck"></i> Nuevo Proveedor</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form id="formNuevoProveedor">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nombre / Razón Social <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="proveedor_nombre" required>
                    </div>
                    <div class="mb-3">
                        <label>RFC <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="proveedor_rfc" required>
                    </div>
                    <div class="mb-3">
                        <label>Teléfono</label>
                        <input type="text" class="form-control" id="proveedor_telefono">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" id="proveedor_email">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DETALLE FACTURA -->
<div class="modal fade" id="modalDetalleFactura" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #17a2b8, #138496); color: white;">
                <h5 class="modal-title"><i class="fas fa-eye"></i> Detalle de Factura</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="detalleFacturaContent">
                <div class="text-center"><div class="spinner-border"></div> Cargando...</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos generales */
    .badge-pendiente { background-color: #fd7e14; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
    .badge-pagada { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
    .badge-cancelada { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
    
    .table th { background-color: #2378e1 !important; color: white !important; }
    .table td { color: #000000 !important; }
    #tablaBody tr:nth-child(odd) { background-color: #ffffff; }
    #tablaBody tr:nth-child(even) { background-color: #f2f2f2; }
    
    .fa-eye, .fa-trash-alt { cursor: pointer; color: #083CAE; margin: 0 5px; }
    .fa-eye:hover, .fa-trash-alt:hover { opacity: 0.7; }

    /* FORZAR MODALES Y ALERTAS POR ENCIMA DE TODO */
    .modal { z-index: 9999999 !important; }
    .modal-backdrop { z-index: 9999998 !important; }
    .modal-backdrop.show { z-index: 9999998 !important; opacity: 0.5 !important; }
    .modal-open .modal { z-index: 9999999 !important; }
    .modal-dialog { z-index: 10000000 !important; }
    .modal-content { z-index: 10000001 !important; }
    .modal.show { display: block !important; }

    /* Forzar SweetAlert2 por encima de todo */
    .swal2-container { z-index: 99999999 !important; }
    .swal2-popup { z-index: 99999999 !important; }

    /* Forzar cualquier alerta o mensaje flotante */
    .alert, .toast, .toast-container { z-index: 99999999 !important; }

    /* Forzar que elementos con posición fija no opaque los modales */
    .navbar-fixed-top, .fixed-top, .sticky-top,
    [style*="position: fixed"], [style*="position:fixed"] { z-index: auto !important; }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    console.log('Documento listo - Facturas Proveedores');
    
    let datosFacturas = [];
    let paginaActual = 1;
    const registrosPorPagina = 10;
    
    const fechaInicio = $('#fechaInicio');
    const fechaFin = $('#fechaFin');
    const buscador = $('#buscador');
    const tablaBody = $('#tablaBody');
    
    function formatCurrency(amount) {
        let num = parseFloat(amount) || 0;
        return '$' + num.toLocaleString('es-MX', { minimumFractionDigits: 2 });
    }
    
    function formatDate(dateString) {
        if (!dateString) return '-';
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX');
        } catch(e) {
            return dateString;
        }
    }
    
    function getBadgeClass(estatus, tipoComprobante) {
    if (tipoComprobante === 'E') return 'badge-info';
    const e = parseInt(estatus);
    if (e === 2) return 'badge-pagada';
    if (e === 3) return 'badge-cancelada';
    return 'badge-pendiente';
}

function getBadgeText(estatus, tipoComprobante) {
    if (tipoComprobante === 'E') return 'NOTA CRÉDITO';
    const e = parseInt(estatus);
    if (e === 2) return 'PAGADA';
    if (e === 3) return 'CANCELADA';
    return 'PENDIENTE';
}
    
    async function cargarDatos() {
        const fi = fechaInicio.val() || '{{ date("Y-m-01") }}';
        const ff = fechaFin.val() || '{{ date("Y-m-d") }}';
        const busqueda = buscador.val() || '';
        
        tablaBody.html('<tr><td colspan="10" class="text-center py-5"><div class="spinner-border text-primary"></div><p>Cargando facturas...</p></td></tr>');
        
        try {
            let url = `/admin/facturacionproveedores/data?fecha_inicio=${fi}&fecha_fin=${ff}`;
            if (busqueda) url += `&buscar=${encodeURIComponent(busqueda)}`;
            
            const response = await fetch(url);
            const result = await response.json();
            
            if (result.success) {
                datosFacturas = result.data || [];
                $('#sumSubtotal').text(formatCurrency(result.totales?.subtotal || 0));
                $('#sumIva').text(formatCurrency(result.totales?.iva || 0));
                $('#sumTotal').text(formatCurrency(result.totales?.total || 0));
                $('#sumSaldo').text(formatCurrency(result.totales?.saldo || 0));
                paginaActual = 1;
                renderizarTabla();
            } else {
                tablaBody.html(`<tr><td colspan="10" class="text-center text-danger py-5">Error: ${result.message}</td></tr>`);
            }
        } catch (error) {
            console.error('Error:', error);
            tablaBody.html('<tr><td colspan="10" class="text-center text-danger py-5">Error de conexión</td></tr>');
        }
    }
    
    function renderizarTabla() {
        if (!datosFacturas.length) {
            tablaBody.html('<tr><td colspan="10" class="text-center py-5">No hay facturas para mostrar</td></tr>');
            $('#paginacionInfo').text('Mostrando 0-0 de 0 registros');
            return;
        }
        
        const start = (paginaActual - 1) * registrosPorPagina;
        const pageData = datosFacturas.slice(start, start + registrosPorPagina);
        
        tablaBody.empty();
        pageData.forEach(item => {
            const row = $(`
                <tr>
                    <td class="text-center"><span class="badge ${getBadgeClass(item.estatus)}">${getBadgeText(item.estatus)}</span></td>
                    <td class="text-center fw-bold">${item.folio || '-'}</td>
                    <td>${item.proveedor || '-'}</td>
                    <td class="text-center">${formatDate(item.fecha)}</td>
                    <td class="text-center">${formatDate(item.fecha_vencimiento)}</td>
                    <td class="text-end">${formatCurrency(item.subtotal)}</td>
                    <td class="text-end">${formatCurrency(item.iva)}</td>
                    <td class="text-end fw-bold">${formatCurrency(item.total)}</td>
                    <td class="text-end">${formatCurrency(item.saldo)}</td>
                    <td class="text-center">
                        <i class="fas fa-eye" style="cursor:pointer; color:#083CAE;" data-id="${item.factura_id}" title="Ver detalle"></i>
                        <i class="fas fa-trash-alt" style="cursor:pointer; color:#083CAE;" data-id="${item.factura_id}" data-folio="${item.folio}" title="Cancelar"></i>
                    </td>
                </tr>
            `);
            tablaBody.append(row);
        });
        
        const totalPaginas = Math.ceil(datosFacturas.length / registrosPorPagina);
        $('#paginaActual').text(paginaActual);
        const inicio = datosFacturas.length > 0 ? (paginaActual - 1) * registrosPorPagina + 1 : 0;
        const fin = Math.min(paginaActual * registrosPorPagina, datosFacturas.length);
        $('#paginacionInfo').text(`Mostrando ${inicio}-${fin} de ${datosFacturas.length} registros`);
        
        $('#btnPrimera').prop('disabled', paginaActual === 1);
        $('#btnAnterior').prop('disabled', paginaActual === 1);
        $('#btnSiguiente').prop('disabled', paginaActual === totalPaginas);
        $('#btnUltima').prop('disabled', paginaActual === totalPaginas);
    }
    
    function cambiarPagina(nuevaPagina) {
        const totalPaginas = Math.ceil(datosFacturas.length / registrosPorPagina);
        if (nuevaPagina >= 1 && nuevaPagina <= totalPaginas) {
            paginaActual = nuevaPagina;
            renderizarTabla();
        }
    }
    
    function agregarFilaConcepto() {
        const fila = $(`
            <tr class="fila-concepto">
                <td><input type="text" class="form-control form-control-sm concepto-descripcion" placeholder="Descripción"></td>
                <td><input type="number" step="0.01" class="form-control form-control-sm concepto-cantidad text-end" value="1"></td>
                <td><input type="number" step="0.01" class="form-control form-control-sm concepto-precio text-end" value="0"></td>
                <td><input type="text" class="form-control form-control-sm concepto-importe text-end" readonly style="background:#e9ecef;"></td>
                <td class="text-center"><button type="button" class="btn btn-sm btn-danger btn-eliminar-concepto"><i class="fas fa-trash"></i></button></td>
            </tr>
        `);
        
        $('#conceptosBody').append(fila);
        
        const cantidad = fila.find('.concepto-cantidad');
        const precio = fila.find('.concepto-precio');
        const importe = fila.find('.concepto-importe');
        
        const calcular = () => {
            const cant = parseFloat(cantidad.val()) || 0;
            const prec = parseFloat(precio.val()) || 0;
            importe.val((cant * prec).toFixed(2));
            calcularTotales();
        };
        
        cantidad.on('input', calcular);
        precio.on('input', calcular);
        fila.find('.btn-eliminar-concepto').on('click', () => fila.remove());
        calcular();
    }
    
    function calcularTotales() {
        let subtotal = 0;
        $('.fila-concepto').each(function() {
            subtotal += parseFloat($(this).find('.concepto-importe').val()) || 0;
        });
        const iva = subtotal * 0.16;
        $('#subtotal').val(subtotal.toFixed(2));
        $('#iva').val(iva.toFixed(2));
        $('#total').val((subtotal + iva).toFixed(2));
    }
    
    function limpiarFormFactura() {
        $('#formFacturaProveedor')[0].reset();
        $('#factura_id').val('');
        $('#fecha').val(new Date().toISOString().split('T')[0]);
        const fechaVencimiento = new Date();
        fechaVencimiento.setDate(fechaVencimiento.getDate() + 30);
        $('#fecha_vencimiento').val(fechaVencimiento.toISOString().split('T')[0]);
        $('#conceptosBody').empty();
        agregarFilaConcepto();
    }
    
    // Eventos
    $('#btnPrimera').on('click', () => cambiarPagina(1));
    $('#btnAnterior').on('click', () => cambiarPagina(paginaActual - 1));
    $('#btnSiguiente').on('click', () => cambiarPagina(paginaActual + 1));
    $('#btnUltima').on('click', () => cambiarPagina(Math.ceil(datosFacturas.length / registrosPorPagina)));
    
    $('#btnRecargar').on('click', cargarDatos);
    $('#fechaInicio, #fechaFin').on('change', cargarDatos);
    
    let timeoutBuscador;
    $('#buscador').on('input', function() {
        clearTimeout(timeoutBuscador);
        timeoutBuscador = setTimeout(cargarDatos, 500);
    });
    
    $('#btnExcel').on('click', function() {
        const table = document.getElementById('tablaFacturas');
        if (!table) return;
        const html = table.cloneNode(true).outerHTML;
        const blob = new Blob([html], { type: 'application/vnd.ms-excel' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = `FacturasProveedores_${new Date().toISOString().slice(0,19)}.xls`;
        link.click();
        URL.revokeObjectURL(link.href);
    });
    
    $('#btnAgregar').on('click', function() {
        limpiarFormFactura();
        $('#modalFacturaProveedor').modal('show');
    });
    
    $('#btnAgregarConceptoModal').on('click', agregarFilaConcepto);
    
    $('#formFacturaProveedor').on('submit', async function(e) {
        e.preventDefault();
        
        const proveedorId = $('#proveedor_id').val();
        if (!proveedorId) {
            Swal.fire('Error', 'Seleccione un proveedor', 'error');
            return;
        }
        
        const conceptos = [];
        $('.fila-concepto').each(function() {
            const desc = $(this).find('.concepto-descripcion').val();
            if (desc) {
                conceptos.push({
                    descripcion: desc,
                    cantidad: $(this).find('.concepto-cantidad').val(),
                    precio_unitario: $(this).find('.concepto-precio').val()
                });
            }
        });
        
        if (conceptos.length === 0) {
            Swal.fire('Error', 'Agregue al menos un concepto', 'error');
            return;
        }
        
        const formData = {
            proveedor_id: parseInt(proveedorId),
            folio: $('#folio').val(),
            fecha: $('#fecha').val(),
            fecha_vencimiento: $('#fecha_vencimiento').val(),
            metodo_pago: $('#metodo_pago').val(),
            forma_pago: $('#forma_pago').val(),
            moneda: $('#moneda').val(),
            tipo_cambio: parseFloat($('#tipo_cambio').val()) || 1,
            subtotal: parseFloat($('#subtotal').val()) || 0,
            iva: parseFloat($('#iva').val()) || 0,
            total: parseFloat($('#total').val()) || 0,
            observaciones: $('#observaciones').val() || null,
            conceptos: conceptos
        };
        
        try {
            const response = await fetch('/admin/facturacionproveedores', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(formData)
            });
            
            const result = await response.json();
            
            if (result.success) {
                $('#modalFacturaProveedor').modal('hide');
                Swal.fire('Éxito', 'Factura guardada correctamente', 'success');
                cargarDatos();
            } else {
                Swal.fire('Error', result.message || 'Error al guardar', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire('Error', 'Error al guardar la factura', 'error');
        }
    });
    
    $(document).on('click', '.fa-eye', async function() {
        const id = $(this).data('id');
        
        try {
            const response = await fetch(`/admin/facturacionproveedores/${id}`);
            const result = await response.json();
            
            if (result.success) {
                const f = result.factura;
                const conceptos = result.conceptos || [];
                
                let badgeClass = 'badge-pendiente';
                let badgeText = 'PENDIENTE';
                if (f.estatus == 2) { badgeClass = 'badge-pagada'; badgeText = 'PAGADA'; }
                if (f.estatus == 3) { badgeClass = 'badge-cancelada'; badgeText = 'CANCELADA'; }
                
                let conceptosHtml = '';
                conceptos.forEach(c => {
                    conceptosHtml += `<tr>
                        <td>${c.descripcion || '-'}</td>
                        <td class="text-end">${c.cantidad || 0}</td>
                        <td class="text-end">${formatCurrency(c.valor_unitario || 0)}</td>
                        <td class="text-end">${formatCurrency(c.importe || 0)}</td>
                    </tr>`;
                });
                
                $('#detalleFacturaContent').html(`
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Factura:</strong> ${f.folio || '-'}</p>
                            <p><strong>Fecha:</strong> ${formatDate(f.fecha)}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Vencimiento:</strong> ${formatDate(f.fecha_vencimiento)}</p>
                            <p><strong>Estatus:</strong> <span class="badge ${badgeClass}">${badgeText}</span></p>
                        </div>
                    </div>
                    <p><strong>Proveedor:</strong> ${result.proveedor_nombre || 'N/A'} - ${result.proveedor_rfc || ''}</p>
                    <hr>
                    <h6>Conceptos</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light"><tr><th>Descripción</th><th>Cantidad</th><th>Precio</th><th>Importe</th></tr></thead>
                            <tbody>${conceptosHtml || '</td><td colspan="4">Sin conceptos</td></tr>'}</tbody>
                            <tfoot>
                                <tr><td colspan="3" class="text-end">Subtotal:</td><td class="text-end">${formatCurrency(f.subtotal)}</td></tr>
                                <tr><td colspan="3" class="text-end">IVA:</td><td class="text-end">${formatCurrency(f.iva)}</td></tr>
                                <tr><td colspan="3" class="text-end fw-bold">Total:</td><td class="text-end fw-bold">${formatCurrency(f.total)}</td></tr>
                                <tr><td colspan="3" class="text-end">Saldo:</td><td class="text-end">${formatCurrency(f.saldo_disponible)}</td></tr>
                            </tfoot>
                        </table>
                    </div>
                    <p><strong>Observaciones:</strong> ${f.observaciones || 'Ninguna'}</p>
                `);
                $('#modalDetalleFactura').modal('show');
            } else {
                Swal.fire('Error', 'No se pudo cargar el detalle', 'error');
            }
        } catch (error) {
            Swal.fire('Error', 'Error de conexión', 'error');
        }
    });
    
    $(document).on('click', '.fa-trash-alt', async function() {
        const id = $(this).data('id');
        const folio = $(this).data('folio');
        
        const confirm = await Swal.fire({
            title: '¿Cancelar factura?',
            html: `¿Cancelar factura <strong>${folio}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sí, cancelar'
        });
        
        if (confirm.isConfirmed) {
            try {
                const response = await fetch(`/admin/facturacionproveedores/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const result = await response.json();
                
                if (result.success) {
                    Swal.fire('Cancelada', 'Factura cancelada', 'success');
                    cargarDatos();
                } else {
                    Swal.fire('Error', result.message, 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Error al cancelar', 'error');
            }
        }
    });
    
    $('#btnNuevoProveedorModal').on('click', function(e) {
        e.preventDefault();
        $('#modalFacturaProveedor').modal('hide');
        setTimeout(() => $('#modalNuevoProveedor').modal('show'), 300);
    });
    
    $('#formNuevoProveedor').on('submit', async function(e) {
        e.preventDefault();
        
        const data = {
            nombre: $('#proveedor_nombre').val(),
            rfc: $('#proveedor_rfc').val(),
            telefono: $('#proveedor_telefono').val(),
            email: $('#proveedor_email').val()
        };
        
        try {
            const response = await fetch('/api/proveedores-lista', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (result.success) {
                $('#modalNuevoProveedor').modal('hide');
                Swal.fire('Éxito', 'Proveedor registrado', 'success');
                location.reload();
            } else {
                Swal.fire('Error', result.message || 'Error al guardar', 'error');
            }
        } catch (error) {
            Swal.fire('Error', 'Error al guardar proveedor', 'error');
        }
    });
    
    cargarDatos();
    agregarFilaConcepto();
});
</script>
@endsection