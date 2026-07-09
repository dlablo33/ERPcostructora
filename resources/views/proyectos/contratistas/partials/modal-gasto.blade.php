{{-- resources/views/proyectos/contratistas/partials/modal-gasto.blade.php --}}

<!-- Modal Registrar Gasto -->
<div class="modal fade" id="modalGasto" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle text-success"></i> Registrar Gasto
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formGasto" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="gasto_asignacion_id" name="asignacion_id">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de Gasto *</label>
                                <select name="tipo_gasto" class="form-control" required>
                                    <option value="">Seleccionar tipo...</option>
                                    <option value="material">Materiales</option>
                                    <option value="mano_obra">Mano de Obra</option>
                                    <option value="maquinaria">Maquinaria</option>
                                    <option value="subcontrato">Subcontrato</option>
                                    <option value="otros">Otros</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha del Gasto *</label>
                                <input type="date" name="fecha_gasto" class="form-control" 
                                       value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Concepto *</label>
                                <input type="text" name="concepto" class="form-control" 
                                       placeholder="Descripción breve del gasto" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="2" 
                                          placeholder="Detalles adicionales del gasto"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Monto *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" name="monto" class="form-control" 
                                           step="0.01" min="0.01" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Factura</label>
                                <input type="text" name="factura" class="form-control" 
                                       placeholder="Número de factura">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Proveedor Externo</label>
                                <input type="text" name="proveedor_externo" class="form-control" 
                                       placeholder="Nombre del proveedor">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Comprobante</label>
                                <div class="custom-file">
                                    <input type="file" name="comprobante" class="custom-file-input" id="comprobanteGasto" accept=".pdf,.jpg,.jpeg,.png">
                                    <label class="custom-file-label" for="comprobanteGasto">Seleccionar archivo</label>
                                </div>
                                <small class="text-muted">Formatos permitidos: PDF, JPG, PNG (máx. 5MB)</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información de la asignación -->
                    <div class="alert alert-info mt-3" id="infoAsignacionGasto">
                        <i class="fas fa-info-circle"></i>
                        <span id="infoAsignacionTexto">Cargando información de la asignación...</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Registrar Gasto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Actualizar label del archivo
    $('#comprobanteGasto').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName || 'Seleccionar archivo');
    });

    // Cuando se abre el modal de gasto
    $('#modalGasto').on('shown.bs.modal', function() {
        var asignacionId = $('#gasto_asignacion_id').val();
        if (asignacionId) {
            cargarInfoAsignacion(asignacionId);
        }
    });

    function cargarInfoAsignacion(asignacionId) {
        $.get('/api/asignaciones/' + asignacionId, function(response) {
            var data = response.asignacion;
            var html = `
                <strong>Contratista:</strong> ${data.contratista.nombre_comercial} | 
                <strong>Proyecto:</strong> ${data.proyecto.nombre} |
                <strong>Presupuesto:</strong> $${Number(data.presupuesto_asignado).toLocaleString()} |
                <strong>Gasto Acumulado:</strong> $${Number(data.gasto_acumulado).toLocaleString()} |
                <strong>Saldo Disponible:</strong> $${Number(data.saldo_disponible).toLocaleString()}
            `;
            $('#infoAsignacionTexto').html(html);
        }).fail(function() {
            $('#infoAsignacionTexto').html('No se pudo cargar la información de la asignación');
        });
    }

    // Formulario de Gasto
    $('#formGasto').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            url: '/api/gastos',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#modalGasto').modal('hide');
                $('#formGasto')[0].reset();
                $('#comprobanteGasto').next('.custom-file-label').html('Seleccionar archivo');
                Swal.fire('¡Éxito!', response.message, 'success');
                // Recargar tabla si existe
                if (typeof table !== 'undefined') {
                    table.ajax.reload();
                }
            },
            error: function(xhr) {
                var msg = xhr.responseJSON?.message || 'Error al registrar el gasto';
                if (xhr.responseJSON?.errors) {
                    msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                }
                Swal.fire('Error', msg, 'error');
            }
        });
    });

    // Función global para abrir modal de gasto
    window.abrirModalGasto = function(asignacionId) {
        $('#gasto_asignacion_id').val(asignacionId);
        $('#modalGasto').modal('show');
    };
});
</script>
@endpush