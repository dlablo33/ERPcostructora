{{-- resources/views/proyectos/contratistas/partials/modal-pago.blade.php --}}

<!-- Modal Registrar Pago -->
<div class="modal fade" id="modalPago" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-money-bill-wave text-primary"></i> Registrar Pago a Contratista
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formPago" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="pago_contratista_id" name="contratista_id">
                    <input type="hidden" id="pago_asignacion_id" name="asignacion_id">
                    <input type="hidden" id="pago_gasto_id" name="gasto_id">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha de Pago *</label>
                                <input type="date" name="fecha_pago" class="form-control" 
                                       value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
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
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Forma de Pago *</label>
                                <select name="forma_pago" class="form-control" required>
                                    <option value="">Seleccionar forma...</option>
                                    <option value="transferencia">Transferencia Bancaria</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="efectivo">Efectivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Referencia</label>
                                <input type="text" name="referencia" class="form-control" 
                                       placeholder="Número de referencia o cheque">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Observaciones</label>
                                <textarea name="observaciones" class="form-control" rows="2" 
                                          placeholder="Detalles adicionales del pago"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Comprobante</label>
                                <div class="custom-file">
                                    <input type="file" name="comprobante" class="custom-file-input" id="comprobantePago" accept=".pdf,.jpg,.jpeg,.png">
                                    <label class="custom-file-label" for="comprobantePago">Seleccionar archivo</label>
                                </div>
                                <small class="text-muted">Formatos permitidos: PDF, JPG, PNG (máx. 5MB)</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información del contratista -->
                    <div class="alert alert-info mt-3" id="infoContratistaPago">
                        <i class="fas fa-info-circle"></i>
                        <span id="infoContratistaTexto">Cargando información del contratista...</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Registrar Pago
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
    $('#comprobantePago').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName || 'Seleccionar archivo');
    });

    // Cuando se abre el modal de pago
    $('#modalPago').on('shown.bs.modal', function() {
        var contratistaId = $('#pago_contratista_id').val();
        var asignacionId = $('#pago_asignacion_id').val();
        var gastoId = $('#pago_gasto_id').val();
        
        if (contratistaId) {
            cargarInfoContratista(contratistaId, asignacionId, gastoId);
        }
    });

    function cargarInfoContratista(contratistaId, asignacionId, gastoId) {
        $.get('/api/contratistas/' + contratistaId, function(response) {
            var c = response.contratista;
            var html = `
                <strong>Contratista:</strong> ${c.nombre_comercial} |
                <strong>Especialidad:</strong> ${c.especialidad} |
                <strong>Calificación:</strong> ${c.calificacion > 0 ? c.calificacion + '/10' : 'Sin calificar'}
            `;
            
            if (asignacionId) {
                // Cargar información de la asignación
                $.get('/api/asignaciones/' + asignacionId, function(res) {
                    var a = res.asignacion;
                    html += `<br>
                        <strong>Proyecto:</strong> ${a.proyecto.nombre} |
                        <strong>Presupuesto:</strong> $${Number(a.presupuesto_asignado).toLocaleString()} |
                        <strong>Gasto:</strong> $${Number(a.gasto_acumulado).toLocaleString()}
                    `;
                    
                    if (gastoId) {
                        $.get('/api/gastos/' + gastoId, function(gastoRes) {
                            var g = gastoRes;
                            html += `<br>
                                <strong>Gasto a pagar:</strong> ${g.concepto} |
                                <strong>Monto:</strong> $${Number(g.monto).toLocaleString()}
                            `;
                            $('#infoContratistaTexto').html(html);
                        });
                    } else {
                        $('#infoContratistaTexto').html(html);
                    }
                });
            } else {
                $('#infoContratistaTexto').html(html);
            }
        }).fail(function() {
            $('#infoContratistaTexto').html('No se pudo cargar la información del contratista');
        });
    }

    // Formulario de Pago
    $('#formPago').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            url: '/api/pagos',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#modalPago').modal('hide');
                $('#formPago')[0].reset();
                $('#comprobantePago').next('.custom-file-label').html('Seleccionar archivo');
                Swal.fire('¡Éxito!', response.message, 'success');
                if (typeof table !== 'undefined') {
                    table.ajax.reload();
                }
            },
            error: function(xhr) {
                var msg = xhr.responseJSON?.message || 'Error al registrar el pago';
                if (xhr.responseJSON?.errors) {
                    msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                }
                Swal.fire('Error', msg, 'error');
            }
        });
    });

    // Función global para abrir modal de pago
    window.abrirModalPago = function(contratistaId, asignacionId, gastoId) {
        $('#pago_contratista_id').val(contratistaId);
        $('#pago_asignacion_id').val(asignacionId || '');
        $('#pago_gasto_id').val(gastoId || '');
        $('#modalPago').modal('show');
    };
});
</script>
@endpush