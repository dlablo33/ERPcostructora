{{-- resources/views/proyectos/contratistas/partials/listado-content.blade.php --}}

<!-- Botones de acción -->
<div style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; align-items: center;">
    <button onclick="abrirModalCrearContratista()" 
            style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 20px; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
        <i class="fas fa-plus"></i> Nuevo Contratista
    </button>
    <button onclick="cambiarSeccion('dashboard')" 
            style="background-color: #17a2b8; color: white; border: none; border-radius: 4px; padding: 8px 20px; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
        <i class="fas fa-chart-pie"></i> Dashboard
    </button>
</div>

<!-- Filtros -->
<div style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap; align-items: flex-end;">
    <div style="flex: 1; min-width: 200px;">
        <div style="position: relative;">
            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
            <input type="text" id="searchContratista" placeholder="Buscar contratista..." 
                   style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
        </div>
    </div>
    <div>
        <select id="filtroEspecialidad" style="padding: 8px 10px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 13px;">
            <option value="">Todas las especialidades</option>
            <option value="construccion">Construcción</option>
            <option value="electricidad">Electricidad</option>
            <option value="plomeria">Plomería</option>
            <option value="acabados">Acabados</option>
            <option value="estructuras">Estructuras</option>
            <option value="instalaciones">Instalaciones</option>
            <option value="pintura">Pintura</option>
        </select>
    </div>
    <div>
        <select id="filtroRiesgo" style="padding: 8px 10px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 13px;">
            <option value="">Todos los riesgos</option>
            <option value="bajo">Bajo</option>
            <option value="medio">Medio</option>
            <option value="alto">Alto</option>
        </select>
    </div>
    <div>
        <select id="filtroStatus" style="padding: 8px 10px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 13px;">
            <option value="">Todos los status</option>
            <option value="1">Activos</option>
            <option value="0">Inactivos</option>
        </select>
    </div>
    <div>
        <button onclick="limpiarFiltros()" 
                style="background-color: #6c757d; color: white; border: none; border-radius: 4px; padding: 8px 20px; cursor: pointer; font-size: 13px;">
            <i class="fas fa-undo"></i> Limpiar
        </button>
    </div>
</div>

<!-- Tabla -->
<div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
    <table class="table" id="tablaContratistas" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1000px;">
        <thead style="background-color: var(--color-primary);">
            <tr>
                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;">Código</th>
                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;">Nombre</th>
                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;">Especialidad</th>
                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;">Riesgo</th>
                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;">Calificación</th>
                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;">Proyectos</th>
                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;">Presupuesto</th>
                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;">Gasto</th>
                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;">Status</th>
                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;">Acciones</th>
            </tr>
        </thead>
        <tbody id="tablaBody">
            <tr>
                <td colspan="10" style="text-align: center; padding: 40px;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 24px; color: var(--color-primary);"></i>
                    <p style="margin-top: 10px; color: #6c757d;">Cargando datos...</p>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Scripts específicos del listado -->
<script>
let tablaContratistas;

function inicializarDataTable() {
    if ($.fn.DataTable.isDataTable('#tablaContratistas')) {
        $('#tablaContratistas').DataTable().destroy();
    }
    
    tablaContratistas = $('#tablaContratistas').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/proyectos/api/contratistas',
            data: function(d) {
                d.search = $('#searchContratista').val();
                d.especialidad = $('#filtroEspecialidad').val();
                d.nivel_riesgo = $('#filtroRiesgo').val();
                d.activo = $('#filtroStatus').val();
            }
        },
        columns: [
            { data: 'codigo' },
            { 
                data: 'nombre_comercial',
                render: function(data, type, row) {
                    return '<span style="font-weight: 500;">' + data + '</span>';
                }
            },
            { data: 'especialidad' },
            { 
                data: 'nivel_riesgo',
                render: function(data) {
                    return '<span class="badge-riesgo-' + data + '">' + data.charAt(0).toUpperCase() + data.slice(1) + '</span>';
                }
            },
            { 
                data: 'calificacion',
                render: function(data) {
                    if (data > 0) {
                        var color = data >= 8 ? 'success' : (data >= 6 ? 'warning' : 'danger');
                        return '<div class="progress"><div class="progress-bar bg-' + color + '" style="width: ' + (data * 10) + '%">' + data + '/10</div></div>';
                    }
                    return '<span style="color: #6c757d; font-size: 11px;">Sin calificar</span>';
                }
            },
            { 
                data: 'proyectos_activos',
                render: function(data) {
                    return '<span style="background: #17a2b8; color: white; padding: 2px 10px; border-radius: 10px; font-size: 11px;">' + data + '</span>';
                }
            },
            { 
                data: 'presupuesto_total',
                render: function(data) {
                    return '<span style="color: var(--color-primary); font-weight: 600;">$' + Number(data).toLocaleString() + '</span>';
                }
            },
            { 
                data: 'gasto_total',
                render: function(data) {
                    return '<span style="color: #dc3545; font-weight: 600;">$' + Number(data).toLocaleString() + '</span>';
                }
            },
            {
                data: 'activo',
                render: function(data) {
                    return data ? 
                        '<span class="badge-activo"><i class="fas fa-check-circle"></i> Activo</span>' : 
                        '<span class="badge-inactivo"><i class="fas fa-times-circle"></i> Inactivo</span>';
                }
            },
            {
                data: 'id',
                render: function(data) {
                    return `
                        <div style="display: flex; gap: 5px; justify-content: center; flex-wrap: wrap;">
                            <button onclick="verContratista(${data})" class="btn btn-sm btn-info" title="Ver">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button onclick="abrirModalEditarContratista(${data})" class="btn btn-sm btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="abrirModalAsignacion(${data})" class="btn btn-sm btn-primary" title="Asignar">
                                <i class="fas fa-project-diagram"></i>
                            </button>
                            <button onclick="eliminarContratista(${data})" class="btn btn-sm btn-danger" title="Eliminar">
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
        order: [[0, 'asc']],
        pageLength: 15,
        drawCallback: function() {
            actualizarKPIs();
        }
    });
}

function recargarTabla() {
    if (tablaContratistas) {
        tablaContratistas.ajax.reload();
    }
}

function limpiarFiltros() {
    document.getElementById('searchContratista').value = '';
    document.getElementById('filtroEspecialidad').value = '';
    document.getElementById('filtroRiesgo').value = '';
    document.getElementById('filtroStatus').value = '';
    recargarTabla();
}

function verContratista(id) {
    // Cambiar a la sección de detalle o mostrar modal
    Swal.fire({
        title: 'Cargando...',
        text: 'Obteniendo información del contratista',
        allowOutsideClick: false,
        didOpen: function() {
            Swal.showLoading();
        }
    });
    
    fetch('/api/contratistas/' + id)
        .then(response => response.json())
        .then(data => {
            const c = data.contratista;
            Swal.fire({
                title: c.nombre_comercial,
                html: `
                    <div style="text-align: left;">
                        <p><strong>Código:</strong> ${c.codigo}</p>
                        <p><strong>Especialidad:</strong> ${c.especialidad}</p>
                        <p><strong>Riesgo:</strong> ${c.nivel_riesgo}</p>
                        <p><strong>Calificación:</strong> ${c.calificacion > 0 ? c.calificacion + '/10' : 'Sin calificar'}</p>
                        <p><strong>Proyectos Activos:</strong> ${data.estadisticas.proyectos_activos}</p>
                        <p><strong>Presupuesto Total:</strong> $${Number(data.estadisticas.presupuesto_total).toLocaleString()}</p>
                        <p><strong>Gasto Total:</strong> $${Number(data.estadisticas.gasto_total).toLocaleString()}</p>
                        <p><strong>Saldo Disponible:</strong> $${Number(data.estadisticas.saldo_disponible).toLocaleString()}</p>
                        <p><strong>Status:</strong> ${c.activo ? 'Activo' : 'Inactivo'}</p>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'Cerrar',
                width: 600
            });
        })
        .catch(error => {
            Swal.fire('Error', 'No se pudo cargar la información', 'error');
        });
}

function actualizarKPIs() {
    fetch('/api/contratistas/estadisticas')
        .then(response => response.json())
        .then(data => {
            // Actualizar KPIs si existen en el dashboard
            const totalEl = document.getElementById('totalContratistas');
            const activosEl = document.getElementById('contratistasActivos');
            const proyectosEl = document.getElementById('totalProyectos');
            const presupuestoEl = document.getElementById('presupuestoTotal');
            
            if (totalEl) totalEl.textContent = data.total || 0;
            if (activosEl) activosEl.textContent = data.activos || 0;
            if (proyectosEl) proyectosEl.textContent = data.total_proyectos || 0;
            if (presupuestoEl) presupuestoEl.textContent = '$' + Number(data.presupuesto_total || 0).toLocaleString();
        })
        .catch(error => console.error('Error:', error));
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar DataTable cuando el DOM esté listo
    setTimeout(inicializarDataTable, 500);
    
    // Filtros en tiempo real
    document.getElementById('searchContratista')?.addEventListener('keyup', recargarTabla);
    document.getElementById('filtroEspecialidad')?.addEventListener('change', recargarTabla);
    document.getElementById('filtroRiesgo')?.addEventListener('change', recargarTabla);
    document.getElementById('filtroStatus')?.addEventListener('change', recargarTabla);
});
</script>