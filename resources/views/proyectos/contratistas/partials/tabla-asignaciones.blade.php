{{-- resources/views/proyectos/contratistas/partials/tabla-asignaciones.blade.php --}}

<!-- Tabla de Asignaciones - Partial reutilizable -->
<div class="table-responsive">
    <table class="table table-hover table-striped" id="tablaAsignacionesPartial">
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
                <th width="180">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Se llena con JavaScript -->
        </tbody>
    </table>
</div>

@push('scripts')
<script>
// Función para renderizar la tabla de asignaciones
function renderizarTablaAsignaciones(data) {
    var tbody = $('#tablaAsignacionesPartial tbody');
    tbody.empty();
    
    if (data.length === 0) {
        tbody.html('<tr><td colspan="9" class="text-center text-muted">No hay asignaciones registradas</td></tr>');
        return;
    }
    
    data.forEach(function(a) {
        var statusBadge = a.status === 'finalizado' ? 'success' : 
                         (a.status === 'en_progreso' ? 'primary' : 
                         (a.status === 'pausado' ? 'warning' : 
                         (a.status === 'cancelado' ? 'danger' : 'secondary')));
        
        var avanceColor = a.avance_porcentaje >= 90 ? 'success' : 
                         (a.avance_porcentaje >= 50 ? 'warning' : 'info');
        
        var row = `
            <tr>
                <td>
                    <a href="#" class="ver-contratista" data-id="${a.contratista_id}">${a.contratista ? a.contratista.nombre_comercial : 'N/A'}</a>
                </td>
                <td>${a.proyecto ? a.proyecto.nombre : 'N/A'}</td>
                <td>${a.seccion || 'N/A'}</td>
                <td><span class="text-primary">$${Number(a.presupuesto_asignado).toLocaleString()}</span></td>
                <td><span class="text-danger">$${Number(a.gasto_acumulado).toLocaleString()}</span></td>
                <td><span class="text-success">$${Number(a.saldo_disponible).toLocaleString()}</span></td>
                <td>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-${avanceColor}" style="width: ${a.avance_porcentaje}%">
                            ${a.avance_porcentaje}%
                        </div>
                    </div>
                </td>
                <td><span class="badge badge-${statusBadge}">${a.status.replace('_', ' ').toUpperCase()}</span></td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-info ver-asignacion" data-id="${a.id}" title="Ver detalles">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-warning editar-asignacion" data-id="${a.id}" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-success registrar-gasto" data-id="${a.id}" title="Registrar Gasto">
                            <i class="fas fa-plus-circle"></i>
                        </button>
                        <button class="btn btn-primary pagar-asignacion" data-id="${a.id}" title="Registrar Pago">
                            <i class="fas fa-money-bill-wave"></i>
                        </button>
                        <button class="btn btn-danger eliminar-asignacion" data-id="${a.id}" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        tbody.append(row);
    });
}

// Función para cargar asignaciones con AJAX
function cargarTablaAsignaciones(filtros = {}) {
    var params = $.param(filtros);
    $.get('/api/asignaciones?' + params, function(response) {
        renderizarTablaAsignaciones(response.data);
    }).fail(function() {
        $('#tablaAsignacionesPartial tbody').html(
            '<tr><td colspan="9" class="text-center text-danger">Error al cargar los datos</td></tr>'
        );
    });
}

// Inicializar eventos
$(document).ready(function() {
    // Ver asignación
    $(document).on('click', '.ver-asignacion', function() {
        var id = $(this).data('id');
        if (typeof cargarDetalleAsignacion === 'function') {
            cargarDetalleAsignacion(id);
        }
    });

    // Editar asignación
    $(document).on('click', '.editar-asignacion', function() {
        var id = $(this).data('id');
        if (typeof cargarEditarAsignacion === 'function') {
            cargarEditarAsignacion(id);
        }
    });

    // Registrar gasto
    $(document).on('click', '.registrar-gasto', function() {
        var id = $(this).data('id');
        if (typeof abrirModalGasto === 'function') {
            abrirModalGasto(id);
        }
    });

    // Registrar pago
    $(document).on('click', '.pagar-asignacion', function() {
        var id = $(this).data('id');
        $.get('/api/asignaciones/' + id, function(response) {
            var a = response.asignacion;
            if (typeof abrirModalPago === 'function') {
                abrirModalPago(a.contratista_id, a.id);
            }
        });
    });

    // Eliminar asignación
    $(document).on('click', '.eliminar-asignacion', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas eliminar esta asignación?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                if (typeof eliminarAsignacion === 'function') {
                    eliminarAsignacion(id);
                }
            }
        });
    });
});
</script>
@endpush