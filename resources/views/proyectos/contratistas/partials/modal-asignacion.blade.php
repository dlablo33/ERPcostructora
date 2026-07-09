{{-- resources/views/proyectos/contratistas/partials/modal-asignacion.blade.php --}}

<div class="modal fade" id="modalAsignacion" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-project-diagram text-primary"></i> Asignar Contratista a Proyecto
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formAsignacion">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="asignacion_contratista_id" name="contratista_id">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Proyecto *</label>
                                <select id="asignacion_proyecto" name="proyecto_id" class="form-control" required>
                                    <option value="">Seleccionar proyecto...</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Partida</label>
                                <select id="asignacion_partida" name="partida_id" class="form-control">
                                    <option value="">Seleccionar partida...</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sección</label>
                                <input type="text" name="seccion" class="form-control" 
                                       placeholder="Ej: Cimentación, Estructura, etc.">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Presupuesto Asignado *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" name="presupuesto_asignado" class="form-control" 
                                           step="0.01" min="0" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha Asignación *</label>
                                <input type="date" name="fecha_asignacion" class="form-control" 
                                       value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha Inicio</label>
                                <input type="date" name="fecha_inicio" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha Fin</label>
                                <input type="date" name="fecha_fin" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Condiciones de Pago</label>
                        <textarea name="condiciones_pago" class="form-control" rows="2" 
                                  placeholder="Ej: 30% anticipo, 40% al 50% de avance, 30% al finalizar"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Asignar Contratista
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Cargar proyectos disponibles
    $('#modalAsignacion').on('shown.bs.modal', function() {
        cargarProyectosDisponibles();
    });

    function cargarProyectosDisponibles() {
        $.get('/api/catalogos/proyectos', function(data) {
            var select = $('#asignacion_proyecto');
            select.empty().append('<option value="">Seleccionar proyecto...</option>');
            data.forEach(function(proyecto) {
                select.append(`<option value="${proyecto.id}">${proyecto.codigo} - ${proyecto.nombre}</option>`);
            });
        });
    }

    // Cargar partidas al seleccionar proyecto
    $('#asignacion_proyecto').on('change', function() {
        var proyectoId = $(this).val();
        var select = $('#asignacion_partida');
        select.empty().append('<option value="">Seleccionar partida...</option>');
        
        if (proyectoId) {
            $.get('/api/catalogos/proyectos/' + proyectoId + '/partidas', function(data) {
                data.forEach(function(partida) {
                    select.append(`<option value="${partida.id}">${partida.codigo} - ${partida.nombre}</option>`);
                });
            });
        }
    });

    // Formulario Asignación
    $('#formAsignacion').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            url: '/api/asignaciones',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#modalAsignacion').modal('hide');
                $('#formAsignacion')[0].reset();
                Swal.fire('¡Éxito!', response.message, 'success');
                $('#tablaContratistas').DataTable().ajax.reload();
            },
            error: function(xhr) {
                var msg = xhr.responseJSON?.message || 'Error al crear la asignación';
                Swal.fire('Error', msg, 'error');
            }
        });
    });
});
</script>
@endpush