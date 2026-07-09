{{-- resources/views/proyectos/contratistas/partials/tabla-contratistas.blade.php --}}

<!-- Tabla de Contratistas - Partial reutilizable -->
<div class="table-responsive">
    <table class="table table-hover table-striped" id="tablaContratistasPartial">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre Comercial</th>
                <th>Especialidad</th>
                <th>Riesgo</th>
                <th>Calificación</th>
                <th>Proyectos</th>
                <th>Presupuesto</th>
                <th>Gasto</th>
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
// Función para renderizar la tabla con datos
function renderizarTablaContratistas(data) {
    var tbody = $('#tablaContratistasPartial tbody');
    tbody.empty();
    
    if (data.length === 0) {
        tbody.html('<tr><td colspan="10" class="text-center text-muted">No hay contratistas registrados</td></tr>');
        return;
    }
    
    data.forEach(function(c) {
        var riesgoBadge = 'badge-riesgo-' + c.nivel_riesgo;
        var statusBadge = c.activo ? 'badge-success' : 'badge-danger';
        var statusText = c.activo ? 'Activo' : 'Inactivo';
        
        var calificacionHtml = '';
        if (c.calificacion > 0) {
            var color = c.calificacion >= 8 ? 'success' : (c.calificacion >= 6 ? 'warning' : 'danger');
            calificacionHtml = `<div class="progress" style="height: 20px;">
                <div class="progress-bar bg-${color}" style="width: ${c.calificacion * 10}%">${c.calificacion}/10</div>
            </div>`;
        } else {
            calificacionHtml = '<span class="text-muted">Sin calificar</span>';
        }
        
        var row = `
            <tr>
                <td><span class="font-weight-bold">${c.codigo}</span></td>
                <td>
                    <a href="#" class="ver-contratista" data-id="${c.id}">${c.nombre_comercial}</a>
                </td>
                <td>${c.especialidad}</td>
                <td><span class="badge ${riesgoBadge}">${c.nivel_riesgo.charAt(0).toUpperCase() + c.nivel_riesgo.slice(1)}</span></td>
                <td>${calificacionHtml}</td>
                <td><span class="badge badge-info">${c.proyectos_activos || 0}</span></td>
                <td><span class="text-primary">$${Number(c.presupuesto_total || 0).toLocaleString()}</span></td>
                <td><span class="text-danger">$${Number(c.gasto_total || 0).toLocaleString()}</span></td>
                <td><span class="badge ${statusBadge}"><i class="fas ${c.activo ? 'fa-check-circle' : 'fa-times-circle'}"></i> ${statusText}</span></td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-info ver-contratista" data-id="${c.id}" title="Ver detalles">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-warning editar-contratista" data-id="${c.id}" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-primary asignar-contratista" data-id="${c.id}" title="Asignar a proyecto">
                            <i class="fas fa-project-diagram"></i>
                        </button>
                        <button class="btn btn-success pagar-contratista" data-id="${c.id}" title="Registrar pago">
                            <i class="fas fa-money-bill-wave"></i>
                        </button>
                        <button class="btn btn-danger eliminar-contratista" data-id="${c.id}" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        tbody.append(row);
    });
}

// Función para cargar datos con AJAX
function cargarTablaContratistas(filtros = {}) {
    var params = $.param(filtros);
    $.get('/api/contratistas?' + params, function(response) {
        renderizarTablaContratistas(response.data);
    }).fail(function() {
        $('#tablaContratistasPartial tbody').html(
            '<tr><td colspan="10" class="text-center text-danger">Error al cargar los datos</td></tr>'
        );
    });
}

// Inicializar eventos cuando el documento esté listo
$(document).ready(function() {
    // Eventos para los botones de la tabla
    $(document).on('click', '.ver-contratista', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (typeof cargarDetalleContratista === 'function') {
            cargarDetalleContratista(id);
        }
    });

    $(document).on('click', '.editar-contratista', function() {
        var id = $(this).data('id');
        if (typeof cargarEditarContratista === 'function') {
            cargarEditarContratista(id);
        }
    });

    $(document).on('click', '.asignar-contratista', function() {
        var id = $(this).data('id');
        $('#asignacion_contratista_id').val(id);
        $('#modalAsignacion').modal('show');
    });

    $(document).on('click', '.pagar-contratista', function() {
        var id = $(this).data('id');
        if (typeof abrirModalPago === 'function') {
            abrirModalPago(id);
        }
    });

    $(document).on('click', '.eliminar-contratista', function() {
        var id = $(this).data('id');
        var nombre = $(this).closest('tr').find('td:eq(1)').text();
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas eliminar al contratista "' + nombre + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                if (typeof eliminarContratista === 'function') {
                    eliminarContratista(id);
                }
            }
        });
    });
});
</script>
@endpush