{{-- resources/views/proyectos/contratistas/gastos.blade.php --}}
@extends('layouts.navigation')

@section('title', 'Gastos de Contratistas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-receipt text-danger"></i> Gastos de Contratistas
                        </h3>
                        <div>
                            <a href="{{ route('proyectos.contratistas.index') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalGasto">
                                <i class="fas fa-plus-circle"></i> Nuevo Gasto
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtros -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select id="filtroContratistaGasto" class="form-control">
                                <option value="">Todos los contratistas</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filtroTipoGasto" class="form-control">
                                <option value="">Todos los tipos</option>
                                <option value="material">Materiales</option>
                                <option value="mano_obra">Mano de Obra</option>
                                <option value="maquinaria">Maquinaria</option>
                                <option value="subcontrato">Subcontrato</option>
                                <option value="otros">Otros</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filtroStatusPago" class="form-control">
                                <option value="">Todos los status</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="pagado">Pagado</option>
                                <option value="parcial">Parcial</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" id="searchGasto" class="form-control" placeholder="Buscar gasto...">
                                <div class="input-group-append">
                                    <button class="btn btn-info" id="btnBuscarGasto">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Gastos -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="tablaGastos">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Contratista</th>
                                    <th>Concepto</th>
                                    <th>Tipo</th>
                                    <th>Monto</th>
                                    <th>Factura</th>
                                    <th>Status Pago</th>
                                    <th width="120">Acciones</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('proyectos.contratistas.partials.modal-gasto')
@include('proyectos.contratistas.partials.modal-pago')
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Cargar contratistas para filtro
    $.get('/api/contratistas?activo=1&per_page=999', function(response) {
        var select = $('#filtroContratistaGasto');
        select.empty().append('<option value="">Todos los contratistas</option>');
        response.data.forEach(function(c) {
            select.append(`<option value="${c.id}">${c.nombre_comercial}</option>`);
        });
    });

    // DataTable de gastos
    var table = $('#tablaGastos').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/api/gastos',
            data: function(d) {
                d.contratista_id = $('#filtroContratistaGasto').val();
                d.tipo_gasto = $('#filtroTipoGasto').val();
                d.status_pago = $('#filtroStatusPago').val();
                d.search = $('#searchGasto').val();
            }
        },
        columns: [
            { 
                data: 'fecha_gasto',
                render: function(data) {
                    return new Date(data).toLocaleDateString();
                }
            },
            { 
                data: 'contratista',
                render: function(data) {
                    return data ? data.nombre_comercial : 'N/A';
                }
            },
            { data: 'concepto' },
            { 
                data: 'tipo_gasto',
                render: function(data) {
                    var labels = {
                        'material': 'Materiales',
                        'mano_obra': 'Mano de Obra',
                        'maquinaria': 'Maquinaria',
                        'subcontrato': 'Subcontrato',
                        'otros': 'Otros'
                    };
                    return labels[data] || data;
                }
            },
            { 
                data: 'monto',
                render: function(data) {
                    return '<span class="text-danger">$' + Number(data).toLocaleString() + '</span>';
                }
            },
            { data: 'factura', defaultContent: 'N/A' },
            { 
                data: 'status_pago',
                render: function(data) {
                    var badge = data === 'pagado' ? 'success' : 
                               (data === 'parcial' ? 'info' : 'warning');
                    return `<span class="badge badge-${badge}">${data.toUpperCase()}</span>`;
                }
            },
            {
                data: 'id',
                render: function(data) {
                    return `
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-info ver-gasto" data-id="${data}" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-success pagar-gasto" data-id="${data}" title="Marcar como pagado">
                                <i class="fas fa-money-bill-wave"></i>
                            </button>
                            <button class="btn btn-danger eliminar-gasto" data-id="${data}" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        language: {
            processing: '<i class="fas fa-spinner fa-spin"></i> Cargando...',
            search: 'Buscar:',
            lengthMenu: 'Mostrar _MENU_ registros por página',
            info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
            infoEmpty: 'No hay registros disponibles',
            infoFiltered: '(filtrado de _MAX_ registros totales)',
            zeroRecords: 'No se encontraron registros',
            paginate: {
                first: 'Primero',
                last: 'Último',
                next: 'Siguiente',
                previous: 'Anterior'
            }
        },
        order: [[0, 'desc']],
        pageLength: 15
    });

    // Filtros
    $('#filtroContratistaGasto, #filtroTipoGasto, #filtroStatusPago').on('change', function() {
        table.ajax.reload();
    });

    $('#btnBuscarGasto').on('click', function() {
        table.ajax.reload();
    });

    $('#searchGasto').on('keypress', function(e) {
        if (e.which === 13) {
            table.ajax.reload();
        }
    });

    // Ver gasto
    $(document).on('click', '.ver-gasto', function() {
        var id = $(this).data('id');
        $.get('/api/gastos/' + id, function(gasto) {
            Swal.fire({
                title: 'Detalle del Gasto',
                html: `
                    <table class="table table-sm">
                        <tr><th>Concepto:</th><td>${gasto.concepto}</td></tr>
                        <tr><th>Descripción:</th><td>${gasto.descripcion || 'N/A'}</td></tr>
                        <tr><th>Tipo:</th><td>${gasto.tipo_gasto}</td></tr>
                        <tr><th>Monto:</th><td>$${Number(gasto.monto).toLocaleString()}</td></tr>
                        <tr><th>Fecha:</th><td>${new Date(gasto.fecha_gasto).toLocaleDateString()}</td></tr>
                        <tr><th>Factura:</th><td>${gasto.factura || 'N/A'}</td></tr>
                        <tr><th>Status Pago:</th><td>${gasto.status_pago.toUpperCase()}</td></tr>
                        ${gasto.comprobante_path ? `<tr><th>Comprobante:</th><td><a href="/api/gastos/${gasto.id}/comprobante" target="_blank">Ver comprobante</a></td></tr>` : ''}
                    </table>
                `,
                icon: 'info',
                confirmButtonText: 'Cerrar'
            });
        });
    });

    // Marcar gasto como pagado
    $(document).on('click', '.pagar-gasto', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Marcar como pagado',
            html: `
                <div class="form-group">
                    <label>Fecha de Pago</label>
                    <input type="date" id="fechaPagoGasto" class="form-control" value="${new Date().toISOString().split('T')[0]}">
                </div>
                <div class="form-group">
                    <label>Forma de Pago</label>
                    <select id="formaPagoGasto" class="form-control">
                        <option value="transferencia">Transferencia</option>
                        <option value="cheque">Cheque</option>
                        <option value="efectivo">Efectivo</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Referencia</label>
                    <input type="text" id="referenciaGasto" class="form-control" placeholder="Número de referencia">
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Marcar como pagado',
            cancelButtonText: 'Cancelar',
            preConfirm: function() {
                return {
                    fecha_pago: $('#fechaPagoGasto').val(),
                    forma_pago: $('#formaPagoGasto').val(),
                    referencia: $('#referenciaGasto').val()
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/gastos/' + id + '/pagar',
                    method: 'POST',
                    data: result.value,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire('¡Éxito!', response.message, 'success');
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        var msg = xhr.responseJSON?.message || 'Error al marcar como pagado';
                        Swal.fire('Error', msg, 'error');
                    }
                });
            }
        });
    });

    // Eliminar gasto
    $(document).on('click', '.eliminar-gasto', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas eliminar este gasto?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/gastos/' + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire('Eliminado', response.message, 'success');
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        var msg = xhr.responseJSON?.message || 'Error al eliminar el gasto';
                        Swal.fire('Error', msg, 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush