{{-- resources/views/proyectos/contratistas/partials/modal-contratista.blade.php --}}

<!-- Modal Nuevo Contratista -->
<div class="modal fade" id="modalNuevoContratista" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus text-primary"></i> Nuevo Contratista
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formNuevoContratista">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Código *</label>
                                <input type="text" name="codigo" class="form-control" 
                                       placeholder="Ej: CON-001" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre Comercial *</label>
                                <input type="text" name="nombre_comercial" class="form-control" 
                                       placeholder="Nombre del contratista" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Especialidad *</label>
                                <select name="especialidad" class="form-control" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="construccion">Construcción</option>
                                    <option value="electricidad">Electricidad</option>
                                    <option value="plomeria">Plomería</option>
                                    <option value="acabados">Acabados</option>
                                    <option value="estructuras">Estructuras</option>
                                    <option value="instalaciones">Instalaciones</option>
                                    <option value="pintura">Pintura</option>
                                    <option value="otros">Otros</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nivel de Riesgo *</label>
                                <select name="nivel_riesgo" class="form-control" required>
                                    <option value="bajo">Bajo</option>
                                    <option value="medio">Medio</option>
                                    <option value="alto">Alto</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Registro IMSS</label>
                                <input type="text" name="registro_imss" class="form-control" 
                                       placeholder="Número de registro IMSS">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Licencia de Obra</label>
                                <input type="text" name="licencia_obra" class="form-control" 
                                       placeholder="Número de licencia">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>RFC</label>
                                <input type="text" name="rfc" class="form-control" 
                                       placeholder="RFC del contratista">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" 
                                       placeholder="email@contratista.com">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text" name="telefono" class="form-control" 
                                       placeholder="Teléfono de contacto">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha Registro</label>
                                <input type="date" name="fecha_registro" class="form-control" 
                                       value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="activo" class="custom-control-input" id="activo" checked>
                            <label class="custom-control-label" for="activo">Activo</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Contratista
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Contratista -->
<div class="modal fade" id="modalEditarContratista" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit text-warning"></i> Editar Contratista
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formEditarContratista">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_contratista_id" name="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Código</label>
                                <input type="text" id="edit_codigo" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre Comercial *</label>
                                <input type="text" id="edit_nombre_comercial" name="nombre_comercial" 
                                       class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Especialidad *</label>
                                <select id="edit_especialidad" name="especialidad" class="form-control" required>
                                    <option value="construccion">Construcción</option>
                                    <option value="electricidad">Electricidad</option>
                                    <option value="plomeria">Plomería</option>
                                    <option value="acabados">Acabados</option>
                                    <option value="estructuras">Estructuras</option>
                                    <option value="instalaciones">Instalaciones</option>
                                    <option value="pintura">Pintura</option>
                                    <option value="otros">Otros</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nivel de Riesgo *</label>
                                <select id="edit_nivel_riesgo" name="nivel_riesgo" class="form-control" required>
                                    <option value="bajo">Bajo</option>
                                    <option value="medio">Medio</option>
                                    <option value="alto">Alto</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Registro IMSS</label>
                                <input type="text" id="edit_registro_imss" name="registro_imss" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Licencia de Obra</label>
                                <input type="text" id="edit_licencia_obra" name="licencia_obra" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="edit_activo" name="activo" class="custom-control-input">
                            <label class="custom-control-label" for="edit_activo">Activo</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Actualizar Contratista
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Formulario Nuevo Contratista
    $('#formNuevoContratista').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            url: '/api/contratistas',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#modalNuevoContratista').modal('hide');
                $('#formNuevoContratista')[0].reset();
                Swal.fire('¡Éxito!', response.message, 'success');
                $('#tablaContratistas').DataTable().ajax.reload();
            },
            error: function(xhr) {
                var errors = xhr.responseJSON?.errors;
                var msg = 'Error al guardar el contratista';
                if (errors) {
                    msg = Object.values(errors).flat().join('\n');
                }
                Swal.fire('Error', msg, 'error');
            }
        });
    });

    // Formulario Editar Contratista
    $('#formEditarContratista').on('submit', function(e) {
        e.preventDefault();
        var id = $('#edit_contratista_id').val();
        var formData = new FormData(this);
        formData.append('_method', 'PUT');
        
        $.ajax({
            url: '/api/contratistas/' + id,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#modalEditarContratista').modal('hide');
                Swal.fire('¡Éxito!', response.message, 'success');
                $('#tablaContratistas').DataTable().ajax.reload();
            },
            error: function(xhr) {
                var errors = xhr.responseJSON?.errors;
                var msg = 'Error al actualizar el contratista';
                if (errors) {
                    msg = Object.values(errors).flat().join('\n');
                }
                Swal.fire('Error', msg, 'error');
            }
        });
    });
});
</script>
@endpush