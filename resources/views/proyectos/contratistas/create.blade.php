{{-- resources/views/proyectos/contratistas/create.blade.php --}}
@extends('layouts.navigation')

@section('title', 'Nuevo Contratista')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-user-plus text-primary"></i> Nuevo Contratista
                        </h3>
                        <a href="{{ route('proyectos.contratistas.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="formCreateContratista" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="codigo">Código *</label>
                                    <input type="text" id="codigo" name="codigo" class="form-control" 
                                           placeholder="Ej: CON-001" required>
                                    <small class="text-muted">Código único del contratista</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre_comercial">Nombre Comercial *</label>
                                    <input type="text" id="nombre_comercial" name="nombre_comercial" class="form-control" 
                                           placeholder="Nombre del contratista" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="especialidad">Especialidad *</label>
                                    <select id="especialidad" name="especialidad" class="form-control" required>
                                        <option value="">Seleccionar especialidad...</option>
                                        <option value="construccion">Construcción</option>
                                        <option value="electricidad">Electricidad</option>
                                        <option value="plomeria">Plomería</option>
                                        <option value="acabados">Acabados</option>
                                        <option value="estructuras">Estructuras</option>
                                        <option value="instalaciones">Instalaciones</option>
                                        <option value="pintura">Pintura</option>
                                        <option value="herreria">Herrería</option>
                                        <option value="albañileria">Albañilería</option>
                                        <option value="carpinteria">Carpintería</option>
                                        <option value="vidrieria">Vidriería</option>
                                        <option value="jardineria">Jardinería</option>
                                        <option value="otros">Otros</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nivel_riesgo">Nivel de Riesgo *</label>
                                    <select id="nivel_riesgo" name="nivel_riesgo" class="form-control" required>
                                        <option value="bajo">Bajo</option>
                                        <option value="medio">Medio</option>
                                        <option value="alto">Alto</option>
                                    </select>
                                    <small class="text-muted">
                                        <span class="badge badge-success">Bajo</span> - Trabajos generales sin riesgo
                                        <br>
                                        <span class="badge badge-warning">Medio</span> - Trabajos con riesgo moderado
                                        <br>
                                        <span class="badge badge-danger">Alto</span> - Trabajos de alto riesgo (alturas, eléctricos, etc.)
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="registro_imss">Registro IMSS</label>
                                    <input type="text" id="registro_imss" name="registro_imss" class="form-control" 
                                           placeholder="Número de registro IMSS">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="licencia_obra">Licencia de Obra</label>
                                    <input type="text" id="licencia_obra" name="licencia_obra" class="form-control" 
                                           placeholder="Número de licencia de obra">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rfc">RFC</label>
                                    <input type="text" id="rfc" name="rfc" class="form-control" 
                                           placeholder="RFC del contratista" maxlength="13">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" 
                                           placeholder="email@contratista.com">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input type="text" id="telefono" name="telefono" class="form-control" 
                                           placeholder="Teléfono de contacto">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_registro">Fecha Registro</label>
                                    <input type="date" id="fecha_registro" name="fecha_registro" class="form-control" 
                                           value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" id="activo" name="activo" class="custom-control-input" checked>
                                        <label class="custom-control-label" for="activo">Activo</label>
                                    </div>
                                    <small class="text-muted">Desactive esta opción si el contratista no está disponible</small>
                                </div>
                            </div>
                        </div>

                        <!-- Documentos -->
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
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Contrato</label>
                                                    <div class="custom-file">
                                                        <input type="file" name="documento_contrato" class="custom-file-input" accept=".pdf,.doc,.docx">
                                                        <label class="custom-file-label">Seleccionar contrato</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Identificación Oficial</label>
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
                                                    <label>Comprobante de Domicilio</label>
                                                    <div class="custom-file">
                                                        <input type="file" name="documento_domicilio" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png">
                                                        <label class="custom-file-label">Seleccionar comprobante</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Seguro de Responsabilidad Civil</label>
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

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    <i class="fas fa-save"></i> Guardar Contratista
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-outline.card-info {
        border-top: 3px solid #17a2b8;
    }
    .custom-file-label::after {
        content: "Examinar";
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Actualizar labels de archivos
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName || 'Seleccionar archivo');
    });

    // Validaciones en tiempo real
    $('#codigo').on('blur', function() {
        var codigo = $(this).val();
        if (codigo) {
            $.get('/api/contratistas/validar-codigo?codigo=' + codigo, function(response) {
                if (response.existe) {
                    $(this).addClass('is-invalid');
                    $(this).after('<div class="invalid-feedback">Este código ya está registrado</div>');
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                }
            }.bind(this));
        }
    });

    // Formulario de creación
    $('#formCreateContratista').on('submit', function(e) {
        e.preventDefault();
        
        // Validar campos requeridos
        var required = ['codigo', 'nombre_comercial', 'especialidad', 'nivel_riesgo'];
        var isValid = true;
        
        required.forEach(function(field) {
            var input = $('#' + field);
            if (!input.val()) {
                input.addClass('is-invalid');
                isValid = false;
            } else {
                input.removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            Swal.fire('Error', 'Por favor complete todos los campos requeridos', 'error');
            return;
        }
        
        var formData = new FormData(this);
        
        // Mostrar loading
        Swal.fire({
            title: 'Guardando...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: function() {
                Swal.showLoading();
            }
        });
        
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
                var msg = 'Error al guardar el contratista';
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
});
</script>
@endpush