{{-- resources/views/proyectos/contratistas/show.blade.php --}}
@extends('layouts.navigation')

@section('title', 'Detalle del Contratista')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-user-tie text-primary"></i> 
                            Detalle del Contratista: <span id="contratistaNombre"></span>
                        </h3>
                        <div>
                            <a href="{{ route('proyectos.contratistas.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="contenidoDetalle">
                    <div class="text-center py-5">
                        <i class="fas fa-spinner fa-spin fa-3x"></i>
                        <p class="mt-3">Cargando información del contratista...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Obtener ID de la URL
    var id = window.location.pathname.split('/').pop();
    cargarDetalleContratista(id);
});

function cargarDetalleContratista(id) {
    $.get('/api/contratistas/' + id, function(response) {
        var c = response.contratista;
        var e = response.estadisticas;
        
        $('#contratistaNombre').text(c.nombre_comercial);
        
        var html = `
            <!-- Información General -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-info-circle"></i> Información General</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tr><th>Código:</th><td>${c.codigo}</td></tr>
                                <tr><th>Nombre Comercial:</th><td>${c.nombre_comercial}</td></tr>
                                <tr><th>Especialidad:</th><td>${c.especialidad}</td></tr>
                                <tr><th>Nivel de Riesgo:</th><td><span class="badge badge-riesgo-${c.nivel_riesgo}">${c.nivel_riesgo.toUpperCase()}</span></td></tr>
                                <tr><th>Calificación:</th><td>${c.calificacion > 0 ? c.calificacion + '/10' : 'Sin calificar'}</td></tr>
                                <tr><th>Registro IMSS:</th><td>${c.registro_imss || 'N/A'}</td></tr>
                                <tr><th>Licencia Obra:</th><td>${c.licencia_obra || 'N/A'}</td></tr>
                                <tr><th>Fecha Registro:</th><td>${new Date(c.fecha_registro).toLocaleDateString()}</td></tr>
                                <tr><th>Status:</th><td>${c.activo ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>'}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-chart-bar"></i> Estadísticas</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="info-box bg-info">
                                        <span class="info-box-icon"><i class="fas fa-project-diagram"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Proyectos</span>
                                            <span class="info-box-number">${e.proyectos_activos}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box bg-success">
                                        <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Presupuesto</span>
                                            <span class="info-box-number">$${Number(e.presupuesto_total).toLocaleString()}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box bg-danger">
                                        <span class="info-box-icon"><i class="fas fa-coins"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Gasto</span>
                                            <span class="info-box-number">$${Number(e.gasto_total).toLocaleString()}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box bg-warning">
                                        <span class="info-box-icon"><i class="fas fa-piggy-bank"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Saldo</span>
                                            <span class="info-box-number">$${Number(e.saldo_disponible).toLocaleString()}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Asignaciones -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-tasks"></i> Asignaciones a Proyectos</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Proyecto</th>
                                            <th>Sección</th>
                                            <th>Presupuesto</th>
                                            <th>Gasto</th>
                                            <th>Saldo</th>
                                            <th>Avance</th>
                                            <th>Status</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${c.asignaciones.map(a => `
                                            <tr>
                                                <td>${a.proyecto.nombre}</td>
                                                <td>${a.seccion || 'N/A'}</td>
                                                <td>$${Number(a.presupuesto_asignado).toLocaleString()}</td>
                                                <td>$${Number(a.gasto_acumulado).toLocaleString()}</td>
                                                <td>$${Number(a.saldo_disponible).toLocaleString()}</td>
                                                <td>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar bg-${a.avance_porcentaje >= 90 ? 'success' : (a.avance_porcentaje >= 50 ? 'warning' : 'info')}" 
                                                             style="width: ${a.avance_porcentaje}%">
                                                            ${a.avance_porcentaje}%
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-${a.status === 'finalizado' ? 'success' : (a.status === 'en_progreso' ? 'primary' : 'secondary')}">
                                                        ${a.status.replace('_', ' ').toUpperCase()}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-info ver-asignacion" data-id="${a.id}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-success registrar-gasto" data-id="${a.id}">
                                                        <i class="fas fa-plus-circle"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        `).join('')}
                                        ${c.asignaciones.length === 0 ? '<tr><td colspan="8" class="text-center text-muted">No hay asignaciones registradas</td></tr>' : ''}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gastos -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-receipt"></i> Últimos Gastos</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Concepto</th>
                                            <th>Tipo</th>
                                            <th>Monto</th>
                                            <th>Factura</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${c.gastos.slice(0, 10).map(g => `
                                            <tr>
                                                <td>${new Date(g.fecha_gasto).toLocaleDateString()}</td>
                                                <td>${g.concepto}</td>
                                                <td>${g.tipo_gasto}</td>
                                                <td>$${Number(g.monto).toLocaleString()}</td>
                                                <td>${g.factura || 'N/A'}</td>
                                                <td>
                                                    <span class="badge badge-${g.status_pago === 'pagado' ? 'success' : 'warning'}">
                                                        ${g.status_pago.toUpperCase()}
                                                    </span>
                                                </td>
                                            </tr>
                                        `).join('')}
                                        ${c.gastos.length === 0 ? '<tr><td colspan="6" class="text-center text-muted">No hay gastos registrados</td></tr>' : ''}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('#contenidoDetalle').html(html);
        
        // Inicializar eventos de los botones
        inicializarEventos();
    }).fail(function() {
        $('#contenidoDetalle').html(`
            <div class="alert alert-danger text-center">
                <i class="fas fa-exclamation-triangle fa-2x"></i>
                <p class="mt-3">Error al cargar la información del contratista</p>
            </div>
        `);
    });
}

function inicializarEventos() {
    // Ver asignación
    $(document).on('click', '.ver-asignacion', function() {
        var id = $(this).data('id');
        $.get('/api/asignaciones/' + id, function(response) {
            var a = response.asignacion;
            Swal.fire({
                title: 'Detalle de Asignación',
                html: `
                    <table class="table table-sm">
                        <tr><th>Contratista:</th><td>${a.contratista.nombre_comercial}</td></tr>
                        <tr><th>Proyecto:</th><td>${a.proyecto.nombre}</td></tr>
                        <tr><th>Sección:</th><td>${a.seccion || 'N/A'}</td></tr>
                        <tr><th>Presupuesto:</th><td>$${Number(a.presupuesto_asignado).toLocaleString()}</td></tr>
                        <tr><th>Gasto:</th><td>$${Number(a.gasto_acumulado).toLocaleString()}</td></tr>
                        <tr><th>Saldo:</th><td>$${Number(a.saldo_disponible).toLocaleString()}</td></tr>
                        <tr><th>Avance:</th><td>${a.avance_porcentaje}%</td></tr>
                        <tr><th>Status:</th><td>${a.status.toUpperCase()}</td></tr>
                        <tr><th>Fecha Inicio:</th><td>${a.fecha_inicio ? new Date(a.fecha_inicio).toLocaleDateString() : 'N/A'}</td></tr>
                        <tr><th>Fecha Fin:</th><td>${a.fecha_fin ? new Date(a.fecha_fin).toLocaleDateString() : 'N/A'}</td></tr>
                    </table>
                `,
                icon: 'info',
                confirmButtonText: 'Cerrar'
            });
        });
    });

    // Registrar gasto
    $(document).on('click', '.registrar-gasto', function() {
        var id = $(this).data('id');
        if (typeof abrirModalGasto === 'function') {
            abrirModalGasto(id);
        }
    });
}
</script>
@endpush