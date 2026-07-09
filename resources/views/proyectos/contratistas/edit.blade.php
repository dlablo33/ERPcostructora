{{-- resources/views/proyectos/contratistas/edit.blade.php --}}
@extends('layouts.navigation')

@section('title', 'Editar Contratista')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-user-edit text-warning"></i> Editar Contratista
                            <span class="badge badge-secondary ml-2" id="editCodigoDisplay"></span>
                        </h3>
                        <div>
                            <a href="{{ route('proyectos.contratistas.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="contenidoEdit">
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

@push('styles')
<style>
    .card-outline.card-warning {
        border-top: 3px solid #ffc107;
    }
    .custom-file-label::after {
        content: "Examinar";
    }
    .badge-estado-activo { background-color: #28a745; color: white; }
    .badge-estado-inactivo { background-color: #dc3545; color: white; }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Obtener ID de la URL
    var id = window.location.pathname.split('/').pop();
    cargarContratista(id);
});

function cargarContratista(id) {
    $.get('/api/contratistas/' + id, function(response) {
        var c = response.contratista;
        $('#editCodigoDisplay').text(c.codigo);
        
        var html = `
            <form id="formEditContratista" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id" name="id" value="${c.id}">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Código</label>
                            <input type="text" class="form-control" value="${c.codigo}" disabled>
                            <small class="text-muted">El código no se puede modificar</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edit_nombre_comercial">Nombre Comercial *</label>
                            <input type="text" id="edit_nombre_comercial" name="nombre_comercial" class="form-control" 
                                   value="${c.nombre_comercial}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edit_especialidad">Especialidad *</label>
                            <select id="edit_especialidad" name="especialidad" class="form-control" required>
                                <option value="construccion" ${c.especialidad === 'construccion' ? 'selected' : ''}>Construcción</option>
                                <option value="electricidad" ${c.especialidad === 'electricidad' ? 'selected' : ''}>Electricidad</option>
                                <option value="plomeria" ${c.especialidad === 'plomeria' ? 'selected' : ''}>Plomería</option>
                                <option value="acabados" ${c.especialidad === 'acabados' ? 'selected' : ''}>Acabados</option>
                                <option value="estructuras" ${c.especialidad === 'estructuras' ? 'selected' : ''}>Estructuras</option>
                                <option value="instalaciones" ${c.especialidad === 'instalaciones' ? 'selected' : ''}>Instalaciones</option>
                                <option value="pintura" ${c.especialidad === 'pintura' ? 'selected' : ''}>Pintura</option>
                                <option value="herreria" ${c.especialidad === 'herreria' ? 'selected' : ''}>Herrería</option>
                                <option value="albañileria" ${c.especialidad === 'albañileria' ? 'selected' : ''}>Albañilería</option>
                                <option value="carpinteria" ${c.especialidad === 'carpinteria' ? 'selected' : ''}>Carpintería</option>
                                <option value="vidrieria" ${c.especialidad === 'vidrieria' ? 'selected' : ''}>Vidriería</option>
                                <option value="jardineria" ${c.especialidad === 'jardineria' ? 'selected' : ''}>Jardinería</option>
                                <option value="otros" ${c.especialidad === 'otros' ? 'selected' : ''}>Otros</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edit_nivel_riesgo">Nivel de Riesgo *</label>
                            <select id="edit_nivel_riesgo" name="nivel_riesgo" class="form-control" required>
                                <option value="bajo" ${c.nivel_riesgo === 'bajo' ? 'selected' : ''}>Bajo</option>
                                <option value="medio" ${c.nivel_riesgo === 'medio' ? 'selected' : ''}>Medio</option>
                                <option value="alto" ${c.nivel_riesgo === 'alto' ? 'selected' : ''}>Alto</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edit_registro_imss">Registro IMSS</label>
                            <input type="text" id="edit_registro_imss" name="registro_imss" class="form-control" 
                                   value="${c.registro_imss || ''}" placeholder="Número de registro IMSS">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edit_licencia_obra">Licencia de Obra</label>
                            <input type="text" id="edit_licencia_obra" name="licencia_obra" class="form-control" 
                                   value="${c.licencia_obra || ''}" placeholder="Número de licencia de obra">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edit_rfc">RFC</label>
                            <input type="text" id="edit_rfc" name="rfc" class="form-control" 
                                   value="${c.proveedor?.rfc || ''}" placeholder="RFC del contratista" maxlength="13">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edit_email">Email</label>
                            <input type="email" id="edit_email" name="email" class="form-control" 
                                   value="${c.proveedor?.email || ''}" placeholder="email@contratista.com">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edit_telefono">Teléfono</label>
                            <input type="text" id="edit_telefono" name="telefono" class="form-control" 
                                   value="${c.proveedor?.telefono || ''}" placeholder="Teléfono de contacto">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha Registro</label>
                            <input type="text" class="form-control" value="${new Date(c.fecha_registro).toLocaleDateString()}" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Calificación Actual</label>
                            <div class="input-group">
                                <input type="number" id="edit_calificacion" name="calificacion" class="form-control" 
                                       value="${c.calificacion}" step="0.01" min="0" max="10">
                                <div class="input-group-append">
                                    <span class="input-group-text">/10</span>
                                </div>
                            </div>
                            <small class="text-muted">Calificación de 0 a 10</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-control-lg mt-3">
                                <input type="checkbox" id="edit_activo" name="activo" class="custom-control-input" 
                                       ${c.activo ? 'checked' : ''}>
                                <label class="custom-control-label" for="edit_activo">
                                    <span class="badge ${c.activo ? 'badge-estado-activo' : 'badge-estado-inactivo'}">
                                        ${c.activo ? 'ACTIVO' : 'INACTIVO'}
                                    </span>
                                </label>
                            </div>
                            <small class="text-muted">Active o desactive al contratista</small>
                        </div>
                    </div>
                </div>

                <!-- Documentos existentes -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fas fa-file-alt"></i> Documentos del Contratista
                                </h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="listaDocumentos">
                                    <!-- Se llena con JavaScript -->
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nuevo Contrato</label>
                                            <div class="custom-file">
                                                <input type="file" name="documento_contrato" class="custom-file-input" accept=".pdf,.doc,.docx">
                                                <label class="custom-file-label">Seleccionar contrato</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nueva Identificación</label>
                                            <div class="custom-file">
                                                <input type="file" name="documento_identificacion" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png">
                                                <label class="custom-file-label">Seleccionar identificación</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nuevo Comprobante de Domicilio</label>
                                            <div class="custom-file">
                                                <input type="file" name="documento_domicilio" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png">
                                                <label class="custom-file-label">Seleccionar comprobante</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nuevo Seguro</label>
                                            <div class="custom-file">
                                                <input type="file" name="documento_seguro" class="custom-file-input" accept=".pdf">
                                                <label class="custom-file-label">Seleccionar póliza</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas de la asignación -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fas fa-chart-bar"></i> Estadísticas del Contratista
                                </h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="info-box bg-info">
                                            <span class="info-box-icon"><i class="fas fa-project-diagram"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Proyectos</span>
                                                <span class="info-box-number">${response.estadisticas.proyectos_activos}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-box bg-success">
                                            <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Presupuesto</span>
                                                <span class="info-box-number">$${Number(response.estadisticas.presupuesto_total).toLocaleString()}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-box bg-danger">
                                            <span class="info-box-icon"><i class="fas fa-coins"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Gasto</span>
                                                <span class="info-box-number">$${Number(response.estadisticas.gasto_total).toLocaleString()}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-box bg-warning">
                                            <span class="info-box-icon"><i class="fas fa-piggy-bank"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Saldo</span>
                                                <span class="info-box-number">$${Number(response.estadisticas.saldo_disponible).toLocaleString()}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-warning btn-lg btn-block">
                            <i class="fas fa-save"></i> Actualizar Contratista
                        </button>
                    </div>
                </div>
            </form>
        `;
        
        $('#contenidoEdit').html(html);
        
        // Cargar documentos
        cargarDocumentos(id);
        
        // Inicializar eventos
        inicializarEventos(id);
        
    }).fail(function() {
        $('#contenidoEdit').html(`
            <div class="alert alert-danger text-center">
                <i class="fas fa-exclamation-triangle fa-2x"></i>
                <p class="mt-3">Error al cargar la información del contratista</p>
                <button class="btn btn-primary" onclick="location.reload()">
                    <i class="fas fa-redo"></i> Reintentar
                </button>
            </div>
        `);
    });
}

function cargarDocumentos(id) {
    $.get('/api/contratistas/' + id + '/documentos', function(data) {
        var html = '';
        if (data.length === 0) {
            html = '<p class="text-muted text-center">No hay documentos registrados</p>';
        } else {
            html = '<div class="table-responsive"><table class="table table-sm table-striped">';
            html += `
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
            `;
            data.forEach(function(doc) {
                html += `
                    <tr>
                        <td><span class="badge badge-info">${doc.tipo_documento}</span></td>
                        <td>${doc.nombre_original}</td>
                        <td>${new Date(doc.created_at).toLocaleDateString()}</td>
                        <td>
                            <button class="btn btn-sm btn-primary descargar-documento" data-id="${doc.id}">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn btn-sm btn-danger eliminar-documento" data-id="${doc.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            html += '</tbody></table></div>';
        }
        $('#listaDocumentos').html(html);
    });
}

function inicializarEventos(id) {
    // Actualizar labels de archivos
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName || 'Seleccionar archivo');
    });

    // Cambiar badge al activar/desactivar
    $('#edit_activo').on('change', function() {
        var label = $(this).next('.custom-control-label').find('.badge');
        if ($(this).is(':checked')) {
            label.removeClass('badge-estado-inactivo').addClass('badge-estado-activo').text('ACTIVO');
        } else {
            label.removeClass('badge-estado-activo').addClass('badge-estado-inactivo').text('INACTIVO');
        }
    });

    // Descargar documento
    $(document).on('click', '.descargar-documento', function() {
        var docId = $(this).data('id');
        window.open('/api/documentos-contratista/' + docId + '/descargar', '_blank');
    });

    // Eliminar documento
    $(document).on('click', '.eliminar-documento', function() {
        var docId = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas eliminar este documento?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/documentos-contratista/' + docId,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire('Eliminado', response.message, 'success');
                        cargarDocumentos(id);
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'No se pudo eliminar el documento', 'error');
                    }
                });
            }
        });
    });

    // Formulario de edición
    $('#formEditContratista').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        formData.append('_method', 'PUT');
        
        Swal.fire({
            title: 'Actualizando...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: function() {
                Swal.showLoading();
            }
        });
        
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
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.message,
                    showConfirmButton: true
                }).then(function() {
                    window.location.href = '/proyectos/contratistas';
                });
            },
            error: function(xhr) {
                var msg = 'Error al actualizar el contratista';
                if (xhr.responseJSON?.errors) {
                    var errors = Object.values(xhr.responseJSON.errors).flat();
                    msg = errors.join('\n');
                } else if (xhr.responseJSON?.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire('Error', msg, 'error');
            }
        });
    });
}
</script>
@endpush