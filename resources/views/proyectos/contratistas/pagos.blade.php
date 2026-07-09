{{-- resources/views/proyectos/contratistas/pagos.blade.php --}}
@extends('layouts.navigation')

@section('title', 'Pagos a Contratistas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-money-bill-wave text-primary"></i> Pagos a Contratistas
                        </h3>
                        <div>
                            <a href="{{ route('proyectos.contratistas.index') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPago">
                                <i class="fas fa-plus"></i> Nuevo Pago
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtros -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select id="filtroContratistaPago" class="form-control">
                                <option value="">Todos los contratistas</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filtroFormaPago" class="form-control">
                                <option value="">Todas las formas</option>
                                <option value="transferencia">Transferencia</option>
                                <option value="cheque">Cheque</option>
                                <option value="efectivo">Efectivo</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" id="filtroFechaPago" class="form-control" placeholder="Fecha de pago">
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" id="searchPago" class="form-control" placeholder="Buscar pago...">
                                <div class="input-group-append">
                                    <button class="btn btn-info" id="btnBuscarPago">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de pagos -->
                    <div class="row mb-3" id="resumenPagos">
                        <div class="col-md-3">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Pagos</span>
                                    <span class="info-box-number" id="totalPagos">$0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-success">
                                <span class="info-box-icon"><i class="fas fa-calendar"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Este Mes</span>
                                    <span class="info-box-number" id="pagosMes">$0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-warning">
                                <span class="info-box-icon"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Contratistas Pagados</span>
                                    <span class="info-box-number" id="contratistasPagados">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-danger">
                                <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Último Pago</span>
                                    <span class="info-box-number" id="ultimoPago">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Pagos -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="tablaPagos">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Fecha</th>
                                    <th>Contratista</th>
                                    <th>Proyecto</th>
                                    <th>Monto</th>
                                    <th>Forma</th>
                                    <th>Referencia</th>
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

@include('proyectos.contratistas.partials.modal-pago')
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Cargar contratistas para filtro
    $.get('/api/contratistas?activo=1&per_page=999', function(response) {
        var select = $('#filtroContratistaPago');
        select.empty().append('<option value="">Todos los contratistas</option>');
        response.data.forEach(function(c) {
            select.append(`<option value="${c.id}">${c.nombre_comercial}</option>`);
        });
    });

    // DataTable de pagos
    var table = $('#tablaPagos').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/api/pagos',
            data: function(d) {
                d.contratista_id = $('#filtroContratistaPago').val();
                d.forma_pago = $('#filtroFormaPago').val();
                d.fecha = $('#filtroFechaPago').val();
                d.search = $('#searchPago').val();
            }
        },
        columns: [
            { 
                data: 'folio',
                render: function(data) {
                    return '<span class="font-weight-bold">' + data + '</span>';
                }
            },
            { 
                data: 'fecha_pago',
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
            { 
                data: 'asignacion',
                render: function(data) {
                    return data && data.proyecto ? data.proyecto.nombre : 'N/A';
                }
            },
            { 
                data: 'monto',
                render: function(data) {
                    return '<span class="text-success">$' + Number(data).toLocaleString() + '</span>';
                }
            },
            { 
                data: 'forma_pago',
                render: function(data) {
                    var labels = {
                        'transferencia': 'Transferencia',
                        'cheque': 'Cheque',
                        'efectivo': 'Efectivo'
                    };
                    return '<span class="badge badge-info">' + (labels[data] || data) + '</span>';
                }
            },
            { data: 'referencia', defaultContent: 'N/A' },
            {
                data: 'id',
                render: function(data) {
                    return `
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-info ver-pago" data-id="${data}" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-danger eliminar-pago" data-id="${data}" title="Eliminar">
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
        order: [[1, 'desc']],
        pageLength: 15,
        drawCallback: function() {
            actualizarResumen();
        }
    });

    // Filtros
    $('#filtroContratistaPago, #filtroFormaPago, #filtroFechaPago').on('change', function() {
        table.ajax.reload();
    });

    $('#btnBuscarPago').on('click', function() {
        table.ajax.reload();
    });

    $('#searchPago').on('keypress', function(e) {
        if (e.which === 13) {
            table.ajax.reload();
        }
    });

    // Actualizar resumen
    function actualizarResumen() {
        $.get('/api/pagos?per_page=1', function(response) {
            var total = 0;
            var mes = 0;
            var contratistas = new Set();
            var ultimo = '-';
            
            // Obtener todos los pagos para el resumen
            $.get('/api/pagos?per_page=999', function(allData) {
                allData.data.forEach(function(pago) {
                    total += pago.monto;
                    contratistas.add(pago.contratista_id);
                    
                    var fecha = new Date(pago.fecha_pago);
                    if (fecha.getMonth() === new Date().getMonth() && 
                        fecha.getFullYear() === new Date().getFullYear()) {
                        mes += pago.monto;
                    }
                });
                
                if (allData.data.length > 0) {
                    var ultimoPago = allData.data[0];
                    ultimo = new Date(ultimoPago.fecha_pago).toLocaleDateString();
                }
                
                $('#totalPagos').text('$' + Number(total).toLocaleString());
                $('#pagosMes').text('$' + Number(mes).toLocaleString());
                $('#contratistasPagados').text(contratistas.size);
                $('#ultimoPago').text(ultimo);
            });
        });
    }

    // Ver pago
    $(document).on('click', '.ver-pago', function() {
        var id = $(this).data('id');
        $.get('/api/pagos/' + id, function(pago) {
            Swal.fire({
                title: 'Detalle del Pago',
                html: `
                    <table class="table table-sm">
                        <tr><th>Folio:</th><td>${pago.folio}</td></tr>
                        <tr><th>Fecha:</th><td>${new Date(pago.fecha_pago).toLocaleDateString()}</td></tr>
                        <tr><th>Contratista:</th><td>${pago.contratista.nombre_comercial}</td></tr>
                        <tr><th>Proyecto:</th><td>${pago.asignacion.proyecto.nombre}</td></tr>
                        <tr><th>Monto:</th><td>$${Number(pago.monto).toLocaleString()}</td></tr>
                        <tr><th>Forma de Pago:</th><td>${pago.forma_pago}</td></tr>
                        <tr><th>Referencia:</th><td>${pago.referencia || 'N/A'}</td></tr>
                        <tr><th>Observaciones:</th><td>${pago.observaciones || 'N/A'}</td></tr>
                        ${pago.comprobante_path ? `<tr><th>Comprobante:</th><td><a href="/api/pagos/${pago.id}/comprobante" target="_blank">Ver comprobante</a></td></tr>` : ''}
                    </table>
                `,
                icon: 'info',
                confirmButtonText: 'Cerrar'
            });
        });
    });

    // Eliminar pago
    $(document).on('click', '.eliminar-pago', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas eliminar este pago?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/pagos/' + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire('Eliminado', response.message, 'success');
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        var msg = xhr.responseJSON?.message || 'Error al eliminar el pago';
                        Swal.fire('Error', msg, 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush