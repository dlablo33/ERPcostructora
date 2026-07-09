{{-- resources/views/proyectos/contratistas/asignaciones.blade.php --}}
@extends('layouts.navigation')

@section('title', 'Asignaciones de Contratistas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-project-diagram text-primary"></i> Asignaciones de Contratistas
                        </h3>
                        <div>
                            <a href="{{ route('proyectos.contratistas.index') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAsignacion">
                                <i class="fas fa-plus"></i> Nueva Asignación
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtros -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select id="filtroProyecto" class="form-control">
                                <option value="">Todos los proyectos</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filtroStatusAsignacion" class="form-control">
                                <option value="">Todos los status</option>
                                <option value="asignado">Asignado</option>
                                <option value="en_progreso">En Progreso</option>
                                <option value="pausado">Pausado</option>
                                <option value="finalizado">Finalizado</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" id="searchAsignacion" class="form-control" placeholder="Buscar por contratista o proyecto...">
                                <div class="input-group-append">
                                    <button class="btn btn-info" id="btnBuscarAsignacion">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Asignaciones -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="tablaAsignaciones">
                            <thead>
                                <tr>
                                    <th>Contratista</th>
                                    <th>Proyecto</th>
                                    <th>Sección</th>
                                    <th>Presupuesto</th>
                                    <th>Gasto</th>
                                    <th>Saldo</th>
                                    <th>Avance</th>
                                    <th>Status</th>
                                    <th width="150">Acciones</th>
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

@include('proyectos.contratistas.partials.modal-asignacion')
@include('proyectos.contratistas.partials.modal-gasto')
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Cargar proyectos para filtro
    $.get('/api/catalogos/proyectos', function(data) {
        var select = $('#filtroProyecto');
        select.empty().append('<option value="">Todos los proyectos</option>');
        data.forEach(function(proyecto) {
            select.append(`<option value="${proyecto.id}">${proyecto.nombre}</option>`);
        });
    });

    // DataTable de asignaciones
    var table = $('#tablaAsignaciones').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/api/asignaciones',
            data: function(d) {
                d.proyecto_id = $('#filtroProyecto').val();
                d.status = $('#filtroStatusAsignacion').val();
                d.search = $('#searchAsignacion').val();
            }
        },
        columns: [
            { 
                data: 'contratista',
                render: function(data) {
                    return data ? data.nombre_comercial : 'N/A';
                }
            },
            { 
                data: 'proyecto',
                render: function(data) {
                    return data ? data.nombre : 'N/A';
                }
            },
            { data: 'seccion', defaultContent: 'N/A' },
            { 
                data: 'presupuesto_asignado',
                render: function(data) {
                    return '<span class="text-primary">$' + Number(data).toLocaleString() + '</span>';
                }
            },
            { 
                data: 'gasto_acumulado',
                render: function(data) {
                    return '<span class="text-danger">$' + Number(data).toLocaleString() + '</span>';
                }
            },
            { 
                data: 'saldo_disponible',
                render: function(data) {
                    return '<span class="text-success">$' + Number(data).toLocaleString() + '</span>';
                }
            },
            { 
                data: 'avance_porcentaje',
                render: function(data) {
                    var color = data >= 90 ? 'success' : (data >= 50 ? 'warning' : 'info');
                    return `<div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-${color}" style="width: ${data}%">${data}%</div>
                    </div>`;
                }
            },
            { 
                data: 'status',
                render: function(data) {
                    var badge = data === 'finalizado' ? 'success' : 
                               (data === 'en_progreso' ? 'primary' : 
                               (data === 'pausado' ? 'warning' : 
                               (data === 'cancelado' ? 'danger' : 'secondary')));
                    return `<span class="badge badge-${badge}">${data.replace('_', ' ').toUpperCase()}</span>`;
                }
            },
            {
                data: 'id',
                render: function(data) {
                    return `
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-info ver-asignacion" data-id="${data}" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-warning editar-asignacion" data-id="${data}" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-success registrar-gasto" data-id="${data}" title="Registrar Gasto">
                                <i class="fas fa-plus-circle"></i>
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
        order: [[0, 'asc']],
        pageLength: 15
    });

    // Filtros
    $('#filtroProyecto, #filtroStatusAsignacion').on('change', function() {
        table.ajax.reload();
    });

    $('#btnBuscarAsignacion').on('click', function() {
        table.ajax.reload();
    });

    $('#searchAsignacion').on('keypress', function(e) {
        if (e.which === 13) {
            table.ajax.reload();
        }
    });
});
</script>
@endpush