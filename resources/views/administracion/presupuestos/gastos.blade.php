@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Gastos Fijos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE !important; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-file-invoice me-2"></i> Gastos Fijos
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
                    <table class="table table-bordered" id="tablaGastosFijos" style="width: 100%; font-size: 12px;">
                        <thead style="position: sticky; top: 0; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="padding: 10px;">ID</th>
                                <th style="padding: 10px;">Proveedor</th>
                                <th style="padding: 10px;">Proyecto</th>
                                <th style="padding: 10px;">Cuenta Contable</th>
                                <th style="padding: 10px;">Fecha Inicio</th>
                                <th style="padding: 10px;">Fecha Fin</th>
                                <th style="padding: 10px;">Descripción</th>
                                <th style="padding: 10px;">Periodicidad</th>
                                <th style="padding: 10px;">Día Cobro</th>
                                <th style="padding: 10px;">Estatus</th>
                                <th style="padding: 10px; text-align: right;">Importe</th>
                                <th style="padding: 10px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="12" class="text-center py-5"><div class="spinner-border text-primary"></div><p>Cargando gastos fijos...</p></td></tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="10" style="padding: 10px;">TOTALES:</td>
                                <td id="sumImporte" style="padding: 10px; text-align: right;">$0.00</td>
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

<!-- MODAL AGREGAR/EDITAR GASTO FIJO -->
<div class="modal fade" id="modalGastoFijo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #2378e1, #1a5bbf); color: white;">
                <h5 class="modal-title"><i class="fas fa-file-invoice me-2"></i> Gasto Fijo</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form id="formGastoFijo">
                <div class="modal-body" style="max-height: 65vh; overflow-y: auto; padding: 20px;">
                    <input type="hidden" id="gasto_fijo_id" name="gasto_fijo_id">
                    
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
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Descripción <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="descripcion" required placeholder="Descripción del gasto">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Proyecto</label>
                            <select class="form-control" id="proyecto_id">
                                <option value="">-- Sin proyecto --</option>
                                @if(isset($proyectos) && count($proyectos) > 0)
                                    @foreach($proyectos as $proyecto)
                                        <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Cuenta Contable</label>
                            <select class="form-control" id="cuenta_contable_id">
                                <option value="">-- Seleccione una cuenta --</option>
                                @if(isset($cuentasContables) && count($cuentasContables) > 0)
                                    @foreach($cuentasContables as $cuenta)
                                        <option value="{{ $cuenta->id }}">{{ $cuenta->codigo }} - {{ $cuenta->nombre }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="fw-bold">Fecha Inicio <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="fecha_inicio" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="fw-bold">Fecha Fin</label>
                            <input type="date" class="form-control" id="fecha_fin" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="fw-bold">Importe <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" id="importe" required placeholder="0.00">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="fw-bold">Periodicidad</label>
                            <select class="form-control" id="periodicidad">
                                <option value="Mensual">Mensual</option>
                                <option value="Trimestral">Trimestral</option>
                                <option value="Semestral">Semestral</option>
                                <option value="Anual">Anual</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="fw-bold">Día de Cobro</label>
                            <input type="number" class="form-control" id="dia_cobro" min="1" max="31" placeholder="1-31">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="fw-bold">Estatus</label>
                            <select class="form-control" id="estatus">
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                                <option value="Pendiente">Pendiente</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Cuenta Flujo Dinero</label>
                            <select class="form-control" id="cuenta_flujo_dinero">
                                <option value="">-- Seleccione --</option>
                                <option value="CFD-001">CFD-001 - Operación</option>
                                <option value="CFD-002">CFD-002 - Inversión</option>
                                <option value="CFD-003">CFD-003 - Financiamiento</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Uso CFDI</label>
                            <select class="form-control" id="uso_cfdi">
                                <option value="G01">G01 - Adquisición de mercancías</option>
                                <option value="G02">G02 - Devoluciones</option>
                                <option value="G03">G03 - Gastos en general</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Método Pago</label>
                            <select class="form-control" id="metodo_pago">
                                <option value="PUE">PUE - Pago en una sola exhibición</option>
                                <option value="PPD">PPD - Pago en parcialidades</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Forma Pago</label>
                            <select class="form-control" id="forma_pago">
                                <option value="01">01 - Efectivo</option>
                                <option value="02">02 - Cheque nominativo</option>
                                <option value="03">03 - Transferencia</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Gasto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DETALLE GASTO FIJO -->
<div class="modal fade" id="modalDetalleGasto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #17a2b8, #138496); color: white;">
                <h5 class="modal-title"><i class="fas fa-eye"></i> Detalle de Gasto Fijo</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="detalleGastoContent">
                <div class="text-center"><div class="spinner-border"></div> Cargando...</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .badge-activo { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
    .badge-inactivo { background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
    .badge-pendiente { background-color: #fd7e14; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
    .badge-cancelado { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
    
    .table th { background-color: #2378e1 !important; color: white !important; }
    .table td { color: #000000 !important; }
    #tablaBody tr:nth-child(odd) { background-color: #ffffff; }
    #tablaBody tr:nth-child(even) { background-color: #f2f2f2; }
    #tablaBody tr:hover { background-color: #e0e0e0; }
    
    .fa-eye, .fa-trash-alt, .fa-edit { cursor: pointer; color: #083CAE; margin: 0 4px; }
    .fa-eye:hover, .fa-trash-alt:hover, .fa-edit:hover { opacity: 0.7; }

    .modal { z-index: 9999999 !important; }
    .modal-backdrop { z-index: 9999998 !important; }
    .modal-backdrop.show { z-index: 9999998 !important; opacity: 0.5 !important; }
    .modal-dialog { z-index: 10000000 !important; }
    .modal-content { z-index: 10000001 !important; }
    .modal.show { display: block !important; }

    .swal2-container { z-index: 99999999 !important; }
    .swal2-popup { z-index: 99999999 !important; }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    console.log('Documento listo - Gastos Fijos');
    
    let datosGastos = [];
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
    
    function getBadgeClass(estatus) {
        if (estatus === 'Activo') return 'badge-activo';
        if (estatus === 'Inactivo') return 'badge-inactivo';
        if (estatus === 'Cancelado') return 'badge-cancelado';
        return 'badge-pendiente';
    }
    
    function getPeriodicidadTexto(periodicidad) {
        const periodicidades = {
            'Mensual': 'Mensual',
            'Trimestral': 'Trimestral',
            'Semestral': 'Semestral',
            'Anual': 'Anual'
        };
        return periodicidades[periodicidad] || periodicidad || '-';
    }
    
    async function cargarDatos() {
        const fi = fechaInicio.val() || '{{ date("Y-m-01") }}';
        const ff = fechaFin.val() || '{{ date("Y-m-d") }}';
        const busqueda = buscador.val() || '';
        
        tablaBody.html('<tr><td colspan="12" class="text-center py-5"><div class="spinner-border text-primary"></div><p>Cargando gastos fijos...</p></td></tr>');
        
        try {
            let url = `/admin/gastosfijos/data?fecha_inicio=${fi}&fecha_fin=${ff}`;
            if (busqueda) url += `&buscar=${encodeURIComponent(busqueda)}`;
            
            const response = await fetch(url);
            const result = await response.json();
            
            if (result.success) {
                datosGastos = result.data || [];
                $('#sumImporte').text(formatCurrency(result.totales?.importe || 0));
                paginaActual = 1;
                renderizarTabla();
            } else {
                tablaBody.html(`<tr><td colspan="12" class="text-center text-danger py-5">Error: ${result.message}</td></tr>`);
            }
        } catch (error) {
            console.error('Error:', error);
            tablaBody.html('<tr><td colspan="12" class="text-center text-danger py-5">Error de conexión</td></tr>');
        }
    }
    
    function renderizarTabla() {
        if (!datosGastos.length) {
            tablaBody.html('<tr><td colspan="12" class="text-center py-5">No hay gastos fijos para mostrar</td></tr>');
            $('#paginacionInfo').text('Mostrando 0-0 de 0 registros');
            return;
        }
        
        const start = (paginaActual - 1) * registrosPorPagina;
        const pageData = datosGastos.slice(start, start + registrosPorPagina);
        
        tablaBody.empty();
        pageData.forEach(item => {
            const row = $(`
                <tr>
                    <td>${item.gasto_fijo_id || '-'}</td>
                    <td>${item.proveedor || '-'}</td>
                    <td>${item.proyecto || '-'}</td>
                    <td>${item.cuenta_contable || '-'}</td>
                    <td class="text-center">${formatDate(item.fecha_inicio)}</td>
                    <td class="text-center">${formatDate(item.fecha_fin)}</td>
                    <td>${item.descripcion || '-'}</td>
                    <td>${getPeriodicidadTexto(item.periodicidad)}</td>
                    <td class="text-center">${item.dia_cobro ? item.dia_cobro + '° día' : '-'}</td>
                    <td><span class="badge ${getBadgeClass(item.estatus)}">${item.estatus || 'Pendiente'}</span></td>
                    <td class="text-end">${formatCurrency(item.importe)}</td>
                    <td class="text-center">
                        <i class="fas fa-eye" data-id="${item.gasto_fijo_id}" title="Ver detalle"></i>
                        <i class="fas fa-edit" data-id="${item.gasto_fijo_id}" title="Editar"></i>
                        <i class="fas fa-trash-alt" data-id="${item.gasto_fijo_id}" title="Eliminar"></i>
                    </td>
                </tr>
            `);
            tablaBody.append(row);
        });
        
        const totalPaginas = Math.ceil(datosGastos.length / registrosPorPagina);
        $('#paginaActual').text(paginaActual);
        const inicio = datosGastos.length > 0 ? (paginaActual - 1) * registrosPorPagina + 1 : 0;
        const fin = Math.min(paginaActual * registrosPorPagina, datosGastos.length);
        $('#paginacionInfo').text(`Mostrando ${inicio}-${fin} de ${datosGastos.length} registros`);
        
        $('#btnPrimera').prop('disabled', paginaActual === 1);
        $('#btnAnterior').prop('disabled', paginaActual === 1);
        $('#btnSiguiente').prop('disabled', paginaActual === totalPaginas);
        $('#btnUltima').prop('disabled', paginaActual === totalPaginas);
    }
    
    function cambiarPagina(nuevaPagina) {
        const totalPaginas = Math.ceil(datosGastos.length / registrosPorPagina);
        if (nuevaPagina >= 1 && nuevaPagina <= totalPaginas) {
            paginaActual = nuevaPagina;
            renderizarTabla();
        }
    }
    
    function limpiarFormulario() {
        $('#formGastoFijo')[0].reset();
        $('#gasto_fijo_id').val('');
        $('#fecha_inicio').val(new Date().toISOString().split('T')[0]);
        const fechaFin = new Date();
        fechaFin.setDate(fechaFin.getDate() + 30);
        $('#fecha_fin').val(fechaFin.toISOString().split('T')[0]);
        $('#periodicidad').val('Mensual');
        $('#estatus').val('Activo');
    }
    
    // Eventos de paginación
    $('#btnPrimera').on('click', () => cambiarPagina(1));
    $('#btnAnterior').on('click', () => cambiarPagina(paginaActual - 1));
    $('#btnSiguiente').on('click', () => cambiarPagina(paginaActual + 1));
    $('#btnUltima').on('click', () => cambiarPagina(Math.ceil(datosGastos.length / registrosPorPagina)));
    
    $('#btnRecargar').on('click', cargarDatos);
    $('#fechaInicio, #fechaFin').on('change', cargarDatos);
    
    let timeoutBuscador;
    $('#buscador').on('input', function() {
        clearTimeout(timeoutBuscador);
        timeoutBuscador = setTimeout(cargarDatos, 500);
    });
    
    $('#btnExcel').on('click', function() {
        const table = document.getElementById('tablaGastosFijos');
        if (!table) return;
        const html = table.cloneNode(true).outerHTML;
        const blob = new Blob([html], { type: 'application/vnd.ms-excel' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = `GastosFijos_${new Date().toISOString().slice(0,19)}.xls`;
        link.click();
        URL.revokeObjectURL(link.href);
    });
    
    $('#btnAgregar').on('click', function() {
        limpiarFormulario();
        $('#modalGastoFijo').modal('show');
    });
    
    $('#formGastoFijo').on('submit', async function(e) {
        e.preventDefault();
        
        const formData = {
            proveedor_id: $('#proveedor_id').val(),
            proyecto_id: $('#proyecto_id').val(),
            cuenta_contable_id: $('#cuenta_contable_id').val(),
            descripcion: $('#descripcion').val(),
            fecha_inicio: $('#fecha_inicio').val(),
            fecha_fin: $('#fecha_fin').val(),
            importe: parseFloat($('#importe').val()) || 0,
            periodicidad: $('#periodicidad').val(),
            dia_cobro: $('#dia_cobro').val(),
            estatus: $('#estatus').val(),
            cuenta_flujo_dinero: $('#cuenta_flujo_dinero').val(),
            uso_cfdi: $('#uso_cfdi').val(),
            metodo_pago: $('#metodo_pago').val(),
            forma_pago: $('#forma_pago').val()
        };
        
        const gastoId = $('#gasto_fijo_id').val();
        const url = gastoId ? `/admin/gastosfijos/${gastoId}` : '/admin/gastosfijos';
        const method = gastoId ? 'PUT' : 'POST';
        
        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(formData)
            });
            
            const result = await response.json();
            
            if (result.success) {
                $('#modalGastoFijo').modal('hide');
                Swal.fire('Éxito', gastoId ? 'Gasto actualizado' : 'Gasto registrado', 'success');
                cargarDatos();
            } else {
                Swal.fire('Error', result.message, 'error');
            }
        } catch (error) {
            Swal.fire('Error', 'Error al guardar', 'error');
        }
    });
    
    $(document).on('click', '.fa-eye', async function() {
        const id = $(this).data('id');
        
        try {
            const response = await fetch(`/admin/gastosfijos/${id}`);
            const result = await response.json();
            
            if (result.success) {
                const g = result.data;
                $('#detalleGastoContent').html(`
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> ${g.gasto_fijo_id || '-'}</p>
                            <p><strong>Proveedor:</strong> ${g.proveedor || '-'}</p>
                            <p><strong>Proyecto:</strong> ${g.proyecto || 'Sin proyecto'}</p>
                            <p><strong>Cuenta Contable:</strong> ${g.cuenta_contable || 'Sin cuenta'}</p>
                            <p><strong>Descripción:</strong> ${g.descripcion || '-'}</p>
                            <p><strong>Fecha Inicio:</strong> ${formatDate(g.fecha_inicio)}</p>
                            <p><strong>Fecha Fin:</strong> ${formatDate(g.fecha_fin)}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Importe:</strong> ${formatCurrency(g.importe)}</p>
                            <p><strong>Periodicidad:</strong> ${getPeriodicidadTexto(g.periodicidad)}</p>
                            <p><strong>Día de Cobro:</strong> ${g.dia_cobro ? g.dia_cobro + '° día del mes' : '-'}</p>
                            <p><strong>Estatus:</strong> <span class="badge ${getBadgeClass(g.estatus)}">${g.estatus || 'Pendiente'}</span></p>
                            <p><strong>Cuenta Flujo:</strong> ${g.cuenta_flujo_dinero || '-'}</p>
                            <p><strong>Uso CFDI:</strong> ${g.satcat_uso_cfdi_clave || '-'}</p>
                            <p><strong>Método Pago:</strong> ${g.satcat_metodos_pago_clave || '-'}</p>
                            <p><strong>Forma Pago:</strong> ${g.satcat_formas_pago_clave || '-'}</p>
                        </div>
                    </div>
                `);
                $('#modalDetalleGasto').modal('show');
            }
        } catch (error) {
            Swal.fire('Error', 'Error al cargar detalle', 'error');
        }
    });
    
    $(document).on('click', '.fa-edit', async function() {
        const id = $(this).data('id');
        
        try {
            const response = await fetch(`/admin/gastosfijos/${id}`);
            const result = await response.json();
            
            if (result.success) {
                const g = result.data;
                $('#gasto_fijo_id').val(g.gasto_fijo_id);
                $('#proveedor_id').val(g.proveedor_id);
                $('#proyecto_id').val(g.proyecto_id);
                $('#cuenta_contable_id').val(g.cuenta_contable_id);
                $('#descripcion').val(g.descripcion);
                $('#fecha_inicio').val(g.fecha_inicio);
                $('#fecha_fin').val(g.fecha_fin);
                $('#importe').val(g.importe);
                $('#periodicidad').val(g.periodicidad);
                $('#dia_cobro').val(g.dia_cobro);
                $('#estatus').val(g.estatus);
                $('#cuenta_flujo_dinero').val(g.cuenta_flujo_dinero);
                $('#uso_cfdi').val(g.satcat_uso_cfdi_clave);
                $('#metodo_pago').val(g.satcat_metodos_pago_clave);
                $('#forma_pago').val(g.satcat_formas_pago_clave);
                $('#modalGastoFijo').modal('show');
            }
        } catch (error) {
            Swal.fire('Error', 'Error al cargar datos', 'error');
        }
    });
    
    $(document).on('click', '.fa-trash-alt', async function() {
        const id = $(this).data('id');
        
        const confirm = await Swal.fire({
            title: '¿Eliminar gasto?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar'
        });
        
        if (confirm.isConfirmed) {
            try {
                const response = await fetch(`/admin/gastosfijos/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const result = await response.json();
                
                if (result.success) {
                    Swal.fire('Eliminado', 'Gasto eliminado', 'success');
                    cargarDatos();
                } else {
                    Swal.fire('Error', result.message, 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Error al eliminar', 'error');
            }
        }
    });
    
    cargarDatos();
});
</script>
@endsection