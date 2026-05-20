@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #2378e1; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-calendar-check me-2"></i> Programación de Pagos
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
                    <table class="table table-bordered" id="tablaProgramacionPagos" style="width: 100%; font-size: 12px;">
                        <thead style="position: sticky; top: 0; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="padding: 10px;">ID</th>
                                <th style="padding: 10px;">Folio</th>
                                <th style="padding: 10px;">Estatus</th>
                                <th style="padding: 10px;">Fecha</th>
                                <th style="padding: 10px;">Proveedor</th>
                                <th style="padding: 10px;">Descripción</th>
                                <th style="padding: 10px;">Proyecto</th>
                                <th style="padding: 10px; text-align: right;">Monto</th>
                                <th style="padding: 10px; text-align: right;">Saldo</th>
                                <th style="padding: 10px;">Fecha Est. Pago</th>
                                <th style="padding: 10px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="11" class="text-center py-5"><div class="spinner-border text-primary"></div><p>Cargando programaciones...</p></td></tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="7" style="padding: 10px;">TOTALES:</td>
                                <td id="sumMonto" style="padding: 10px; text-align: right;">$0.00</td>
                                <td id="sumSaldo" style="padding: 10px; text-align: right;">$0.00</td>
                                <td style="padding: 10px;" colspan="2"></td>
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

<!-- MODAL AGREGAR/EDITAR PROGRAMACIÓN -->
<div class="modal fade" id="modalProgramacionPago" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #2378e1, #1a5bbf); color: white;">
                <h5 class="modal-title"><i class="fas fa-calendar-check me-2"></i> Programación de Pago</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form id="formProgramacionPago">
                <div class="modal-body" style="max-height: 65vh; overflow-y: auto; padding: 20px;">
                    <input type="hidden" id="programacion_id" name="programacion_id">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Proveedor <span class="text-danger">*</span></label>
                            <select class="form-control" id="proveedor_id" required>
                                <option value="">-- Seleccione un proveedor --</option>
                                @if(isset($proveedores) && count($proveedores) > 0)
                                    @foreach($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }} - {{ $proveedor->rfc }}</option>
                                    @endforeach
                                @else
                                    <option value="" disabled>No hay proveedores disponibles</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Descripción <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="descripcion" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="fw-bold">Fecha Programación <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="fecha" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="fw-bold">Fecha Est. Pago <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="fecha_estimada" value="{{ date('Y-m-d', strtotime('+15 days')) }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="fw-bold">Monto <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" id="monto" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="fw-bold">Estatus</label>
                            <select class="form-control" id="estatus">
                                <option value="Programado">Programado</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="Pagado">Pagado</option>
                                <option value="Parcial">Parcial</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
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
                                @else
                                    <option value="" disabled>No hay proyectos disponibles</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Observaciones</label>
                            <textarea class="form-control" id="observaciones" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Programación</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL REGISTRAR PAGO -->
<div class="modal fade" id="modalRegistrarPago" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #28a745, #1e7e34); color: white;">
                <h5 class="modal-title"><i class="fas fa-credit-card me-2"></i> Registrar Pago</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form id="formRegistrarPago">
                <div class="modal-body">
                    <input type="hidden" id="pago_programacion_id" name="programacion_id">
                    <div class="mb-3">
                        <label class="fw-bold">Monto a Pagar <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" id="monto_pago" required placeholder="0.00">
                        <small class="text-muted" id="saldo_disponible_label">Saldo disponible: $0.00</small>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Referencia</label>
                        <input type="text" class="form-control" id="referencia_pago" placeholder="Referencia bancaria">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Registrar Pago</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DETALLE PROGRAMACIÓN -->
<div class="modal fade" id="modalDetalleProgramacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #17a2b8, #138496); color: white;">
                <h5 class="modal-title"><i class="fas fa-eye"></i> Detalle de Programación</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="detalleProgramacionContent">
                <div class="text-center"><div class="spinner-border"></div> Cargando...</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .badge-programado { background-color: #2378e1; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
    .badge-pendiente { background-color: #fd7e14; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
    .badge-pagado { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
    .badge-cancelado { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
    .badge-parcial { background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
    
    .table th { background-color: #2378e1 !important; color: white !important; }
    .table td { color: #000000 !important; }
    #tablaBody tr:nth-child(odd) { background-color: #ffffff; }
    #tablaBody tr:nth-child(even) { background-color: #f2f2f2; }
    #tablaBody tr:hover { background-color: #e0e0e0; }
    
    .fa-eye, .fa-trash-alt, .fa-edit, .fa-credit-card { cursor: pointer; color: #083CAE; margin: 0 4px; }
    .fa-eye:hover, .fa-trash-alt:hover, .fa-edit:hover, .fa-credit-card:hover { opacity: 0.7; }

    .modal { z-index: 9999999 !important; }
    .modal-backdrop { z-index: 9999998 !important; }
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
    console.log('Documento listo - Programación de Pagos');
    
    let datosProgramaciones = [];
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
        if (estatus === 'Programado') return 'badge-programado';
        if (estatus === 'Pendiente') return 'badge-pendiente';
        if (estatus === 'Pagado') return 'badge-pagado';
        if (estatus === 'Cancelado') return 'badge-cancelado';
        if (estatus === 'Parcial') return 'badge-parcial';
        return 'badge-pendiente';
    }
    
    async function cargarDatos() {
        const fi = fechaInicio.val() || '{{ date("Y-m-01") }}';
        const ff = fechaFin.val() || '{{ date("Y-m-d") }}';
        const busqueda = buscador.val() || '';
        
        tablaBody.html('<tr><td colspan="11" class="text-center py-5"><div class="spinner-border text-primary"></div><p>Cargando programaciones...</p></td></tr>');
        
        try {
            let url = `/admin/programacion/data?fecha_inicio=${fi}&fecha_fin=${ff}`;
            if (busqueda) url += `&buscar=${encodeURIComponent(busqueda)}`;
            
            const response = await fetch(url);
            const result = await response.json();
            
            if (result.success) {
                datosProgramaciones = result.data || [];
                $('#sumMonto').text(formatCurrency(result.totales?.monto || 0));
                $('#sumSaldo').text(formatCurrency(result.totales?.saldo || 0));
                paginaActual = 1;
                renderizarTabla();
            } else {
                tablaBody.html(`<td><td colspan="11" class="text-center text-danger py-5">Error: ${result.message}</td></table>`);
            }
        } catch (error) {
            console.error('Error:', error);
            tablaBody.html('<tr><td colspan="11" class="text-center text-danger py-5">Error de conexión: ' + error.message + '</td></tr>');
        }
    }
    
    function renderizarTabla() {
        if (!datosProgramaciones.length) {
            tablaBody.html('<tr><td colspan="11" class="text-center py-5">No hay programaciones para mostrar</td></td>');
            $('#paginacionInfo').text('Mostrando 0-0 de 0 registros');
            return;
        }
        
        const start = (paginaActual - 1) * registrosPorPagina;
        const pageData = datosProgramaciones.slice(start, start + registrosPorPagina);
        
        tablaBody.empty();
        pageData.forEach(item => {
            const row = $(`
                <tr>
                    <td class="text-center">${item.id || '-'}</td>
                    <td class="text-center fw-bold">${item.folio || '-'}</td>
                    <td class="text-center"><span class="badge ${getBadgeClass(item.estatus)}">${item.estatus || 'Pendiente'}</span></td>
                    <td class="text-center">${formatDate(item.fecha)}</td>
                    <td>${item.proveedor || '-'}</td>
                    <td>${item.descripcion || '-'}</td>
                    <td>${item.proyecto || '-'}</td>
                    <td class="text-end">${formatCurrency(item.monto)}</td>
                    <td class="text-end">${formatCurrency(item.saldo)}</td>
                    <td class="text-center">${formatDate(item.fecha_estimada)}</td>
                    <td class="text-center">
                        <i class="fas fa-eye" data-id="${item.id}" title="Ver detalle"></i>
                        <i class="fas fa-edit" data-id="${item.id}" title="Editar"></i>
                        <i class="fas fa-credit-card" data-id="${item.id}" data-saldo="${item.saldo}" title="Registrar pago"></i>
                        <i class="fas fa-trash-alt" data-id="${item.id}" title="Eliminar"></i>
                    </td>
                </tr>
            `);
            tablaBody.append(row);
        });
        
        const totalPaginas = Math.ceil(datosProgramaciones.length / registrosPorPagina);
        $('#paginaActual').text(paginaActual);
        const inicio = datosProgramaciones.length > 0 ? (paginaActual - 1) * registrosPorPagina + 1 : 0;
        const fin = Math.min(paginaActual * registrosPorPagina, datosProgramaciones.length);
        $('#paginacionInfo').text(`Mostrando ${inicio}-${fin} de ${datosProgramaciones.length} registros`);
        
        $('#btnPrimera').prop('disabled', paginaActual === 1);
        $('#btnAnterior').prop('disabled', paginaActual === 1);
        $('#btnSiguiente').prop('disabled', paginaActual === totalPaginas);
        $('#btnUltima').prop('disabled', paginaActual === totalPaginas);
    }
    
    function cambiarPagina(nuevaPagina) {
        const totalPaginas = Math.ceil(datosProgramaciones.length / registrosPorPagina);
        if (nuevaPagina >= 1 && nuevaPagina <= totalPaginas) {
            paginaActual = nuevaPagina;
            renderizarTabla();
        }
    }
    
    function limpiarFormulario() {
        $('#formProgramacionPago')[0].reset();
        $('#programacion_id').val('');
        $('#fecha').val(new Date().toISOString().split('T')[0]);
        const fechaEstimada = new Date();
        fechaEstimada.setDate(fechaEstimada.getDate() + 15);
        $('#fecha_estimada').val(fechaEstimada.toISOString().split('T')[0]);
        $('#estatus').val('Programado');
    }
    
    // Eventos
    $('#btnPrimera').on('click', () => cambiarPagina(1));
    $('#btnAnterior').on('click', () => cambiarPagina(paginaActual - 1));
    $('#btnSiguiente').on('click', () => cambiarPagina(paginaActual + 1));
    $('#btnUltima').on('click', () => cambiarPagina(Math.ceil(datosProgramaciones.length / registrosPorPagina)));
    $('#btnRecargar').on('click', cargarDatos);
    $('#fechaInicio, #fechaFin').on('change', cargarDatos);
    
    let timeoutBuscador;
    $('#buscador').on('input', function() {
        clearTimeout(timeoutBuscador);
        timeoutBuscador = setTimeout(cargarDatos, 500);
    });
    
    $('#btnAgregar').on('click', function() {
        limpiarFormulario();
        $('#modalProgramacionPago').modal('show');
    });
    
    $('#formProgramacionPago').on('submit', async function(e) {
        e.preventDefault();
        
        const formData = {
            proveedor_id: $('#proveedor_id').val(),
            descripcion: $('#descripcion').val(),
            fecha: $('#fecha').val(),
            fecha_estimada: $('#fecha_estimada').val(),
            monto: parseFloat($('#monto').val()) || 0,
            estatus: $('#estatus').val(),
            proyecto_id: $('#proyecto_id').val(),
            observaciones: $('#observaciones').val()
        };
        
        const programacionId = $('#programacion_id').val();
        const url = programacionId ? `/admin/programacion/${programacionId}` : '/admin/programacion';
        const method = programacionId ? 'PUT' : 'POST';
        
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
                $('#modalProgramacionPago').modal('hide');
                Swal.fire('Éxito', programacionId ? 'Programación actualizada' : 'Programación registrada', 'success');
                cargarDatos();
            } else {
                Swal.fire('Error', result.message, 'error');
            }
        } catch (error) {
            Swal.fire('Error', 'Error al guardar', 'error');
        }
    });
    
    $(document).on('click', '.fa-credit-card', function() {
        const id = $(this).data('id');
        const saldo = $(this).data('saldo');
        
        $('#pago_programacion_id').val(id);
        $('#monto_pago').val('');
        $('#referencia_pago').val('');
        $('#saldo_disponible_label').text(`Saldo disponible: ${formatCurrency(saldo)}`);
        $('#monto_pago').attr('max', saldo);
        $('#modalRegistrarPago').modal('show');
    });
    
    $('#formRegistrarPago').on('submit', async function(e) {
        e.preventDefault();
        
        const id = $('#pago_programacion_id').val();
        const formData = {
            monto_pago: parseFloat($('#monto_pago').val()) || 0,
            referencia: $('#referencia_pago').val()
        };
        
        try {
            const response = await fetch(`/admin/programacion/${id}/pagar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(formData)
            });
            
            const result = await response.json();
            
            if (result.success) {
                $('#modalRegistrarPago').modal('hide');
                Swal.fire('Éxito', 'Pago registrado correctamente', 'success');
                cargarDatos();
            } else {
                Swal.fire('Error', result.message, 'error');
            }
        } catch (error) {
            Swal.fire('Error', 'Error al registrar pago', 'error');
        }
    });
    
    $(document).on('click', '.fa-eye', async function() {
        const id = $(this).data('id');
        
        try {
            const response = await fetch(`/admin/programacion/${id}`);
            const result = await response.json();
            
            if (result.success) {
                const p = result.data;
                $('#detalleProgramacionContent').html(`
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Folio:</strong> ${p.folio || '-'}</p>
                            <p><strong>Proveedor:</strong> ${p.proveedor || '-'} (${p.proveedor_rfc || '-'})</p>
                            <p><strong>Descripción:</strong> ${p.descripcion || '-'}</p>
                            <p><strong>Proyecto:</strong> ${p.proyecto || 'Sin proyecto'}</p>
                            <p><strong>Fecha Programación:</strong> ${formatDate(p.fecha)}</p>
                            <p><strong>Fecha Estimada Pago:</strong> ${formatDate(p.fecha_estimada)}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Fecha Pago Real:</strong> ${formatDate(p.fecha_pago_real)}</p>
                            <p><strong>Monto:</strong> ${formatCurrency(p.monto)}</p>
                            <p><strong>Saldo:</strong> ${formatCurrency(p.saldo)}</p>
                            <p><strong>Estatus:</strong> <span class="badge ${getBadgeClass(p.estatus)}">${p.estatus}</span></p>
                            <p><strong>Referencia Pago:</strong> ${p.referencia_pago || '-'}</p>
                            <p><strong>Observaciones:</strong> ${p.observaciones || '-'}</p>
                            <p><strong>Creado por:</strong> ${p.creador || '-'}</p>
                        </div>
                    </div>
                `);
                $('#modalDetalleProgramacion').modal('show');
            }
        } catch (error) {
            Swal.fire('Error', 'Error al cargar detalle', 'error');
        }
    });
    
    $(document).on('click', '.fa-edit', async function() {
        const id = $(this).data('id');
        
        try {
            const response = await fetch(`/admin/programacion/${id}`);
            const result = await response.json();
            
            if (result.success) {
                const p = result.data;
                $('#programacion_id').val(p.id);
                $('#proveedor_id').val(p.proveedor_id);
                $('#descripcion').val(p.descripcion);
                $('#fecha').val(p.fecha);
                $('#fecha_estimada').val(p.fecha_estimada);
                $('#monto').val(p.monto);
                $('#estatus').val(p.estatus);
                $('#proyecto_id').val(p.proyecto_id);
                $('#observaciones').val(p.observaciones);
                $('#modalProgramacionPago').modal('show');
            }
        } catch (error) {
            Swal.fire('Error', 'Error al cargar datos', 'error');
        }
    });
    
    $(document).on('click', '.fa-trash-alt', async function() {
        const id = $(this).data('id');
        
        const confirm = await Swal.fire({
            title: '¿Eliminar programación?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar'
        });
        
        if (confirm.isConfirmed) {
            try {
                const response = await fetch(`/admin/programacion/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const result = await response.json();
                
                if (result.success) {
                    Swal.fire('Eliminado', 'Programación eliminada', 'success');
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