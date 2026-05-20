@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Conciliación Bancaria -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE !important; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-handshake me-2"></i> Conciliación Bancaria
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Tabs -->
                <ul class="nav nav-tabs mb-4" id="conciliacionTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="nueva-tab" data-toggle="tab" href="#nueva" role="tab">
                            <i class="fas fa-plus-circle"></i> Nueva Conciliación
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="historial-tab" data-toggle="tab" href="#historial" role="tab">
                            <i class="fas fa-history"></i> Historial de Conciliaciones
                        </a>
                    </li>
                </ul>

                <div class="tab-content" id="conciliacionTabsContent">
                    <!-- TAB NUEVA CONCILIACIÓN -->
                    <div class="tab-pane fade show active" id="nueva" role="tabpanel">
                        <!-- Panel de configuración -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label class="fw-bold">Cuenta Bancaria</label>
                                <select id="cuenta_id" class="form-control">
                                    <option value="">-- Seleccione una cuenta --</option>
                                    @foreach($cuentasBancarias as $cuenta)
                                        <option value="{{ $cuenta->id }}">{{ $cuenta->banco }} - {{ $cuenta->numero_cuenta }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="fw-bold">Fecha Inicio</label>
                                <input type="date" id="fecha_inicio" class="form-control" value="{{ date('Y-m-01') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="fw-bold">Fecha Fin</label>
                                <input type="date" id="fecha_fin" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="fw-bold">Saldo Inicial</label>
                                <input type="number" step="0.01" id="saldo_inicial" class="form-control" placeholder="0.00" value="0">
                            </div>
                            <div class="col-md-3">
                                <label class="fw-bold">&nbsp;</label>
                                <div>
                                    <button id="btnCargarSistema" class="btn btn-primary"><i class="fas fa-database"></i> Cargar Movimientos</button>
                                    <button id="btnDescargarPlantilla" class="btn btn-success"><i class="fas fa-file-excel"></i> Plantilla</button>
                                </div>
                            </div>
                        </div>

                        <!-- Panel de carga de Excel -->
                        <div class="row mb-4" id="panelExcel" style="display:none;">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <i class="fas fa-upload"></i> Cargar Extracto Bancario (Excel)
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Archivo Excel</label>
                                            <input type="file" id="archivo_excel" class="form-control" accept=".xlsx,.xls,.csv">
                                            <small class="text-muted">El archivo debe tener las columnas: Fecha, Descripcion, Referencia, Egresos, Ingresos, Numero Transaccion</small>
                                        </div>
                                        <button id="btnSubirExcel" class="btn btn-info"><i class="fas fa-upload"></i> Subir y Procesar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <i class="fas fa-info-circle"></i> Resumen del Extracto
                                    </div>
                                    <div class="card-body" id="resumenExtracto">
                                        <p>No se ha cargado ningún archivo</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Panel de resumen de conciliación -->
                        <div id="panelResumen" style="display:none;">
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">
                                            <i class="fas fa-chart-line"></i> Resumen de Conciliación
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3 text-center">
                                                    <h6>Saldo Inicial Sistema</h6>
                                                    <h4 id="res_saldo_inicial_sistema">$0.00</h4>
                                                </div>
                                                <div class="col-md-3 text-center">
                                                    <h6>Saldo Inicial Extracto</h6>
                                                    <h4 id="res_saldo_inicial_extracto">$0.00</h4>
                                                </div>
                                                <div class="col-md-3 text-center">
                                                    <h6>Diferencia</h6>
                                                    <h4 id="res_diferencia" class="text-warning">$0.00</h4>
                                                </div>
                                                <div class="col-md-3 text-center">
                                                    <h6>Estatus</h6>
                                                    <h4 id="res_estatus"><span class="badge badge-pendiente">Pendiente</span></h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3 text-center">
                                                    <small>Total Ingresos Sistema</small>
                                                    <strong id="res_total_ingresos_sistema">$0.00</strong>
                                                </div>
                                                <div class="col-md-3 text-center">
                                                    <small>Total Egresos Sistema</small>
                                                    <strong id="res_total_egresos_sistema">$0.00</strong>
                                                </div>
                                                <div class="col-md-3 text-center">
                                                    <small>Total Ingresos Extracto</small>
                                                    <strong id="res_total_ingresos_extracto">$0.00</strong>
                                                </div>
                                                <div class="col-md-3 text-center">
                                                    <small>Total Egresos Extracto</small>
                                                    <strong id="res_total_egresos_extracto">$0.00</strong>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <label>Observaciones</label>
                                                    <textarea id="observaciones" class="form-control" rows="2" placeholder="Notas adicionales..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tablas de conciliación lado a lado -->
                        <div id="tablasConciliacion" style="display:none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5><i class="fas fa-database text-primary"></i> Movimientos del Sistema</h5>
                                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 5px;">
                                        <table class="table table-bordered table-sm mb-0" id="tablaSistema">
                                            <thead class="bg-primary text-white sticky-top">
                                                <tr>
                                                    <th style="width: 30px;"><input type="checkbox" id="checkAllSistema"></th>
                                                    <th>Fecha</th>
                                                    <th>Descripción</th>
                                                    <th>Referencia</th>
                                                    <th class="text-right">Egreso</th>
                                                    <th class="text-right">Ingreso</th>
                                                    <th>N° Transacción</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbodySistema">
                                                <tr><td colspan="7" class="text-center">Seleccione cuenta y cargue movimientos...<\/td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5><i class="fas fa-file-excel text-success"></i> Movimientos del Extracto</h5>
                                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 5px;">
                                        <table class="table table-bordered table-sm mb-0" id="tablaExtracto">
                                            <thead class="bg-success text-white sticky-top">
                                                <tr>
                                                    <th style="width: 30px;"><input type="checkbox" id="checkAllExtracto"></th>
                                                    <th>Fecha</th>
                                                    <th>Descripción</th>
                                                    <th>Referencia</th>
                                                    <th class="text-right">Egreso</th>
                                                    <th class="text-right">Ingreso</th>
                                                    <th>N° Transacción</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbodyExtracto">
                                                <tr><td colspan="7" class="text-center">Primero cargue un archivo Excel<\/td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12 text-right">
                                    <button id="btnGuardarConciliacion" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Guardar Conciliación</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB HISTORIAL DE CONCILIACIONES -->
                    <div class="tab-pane fade" id="historial" role="tabpanel">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label>Fecha Inicio</label>
                                <input type="date" id="filtro_fecha_inicio" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label>Fecha Fin</label>
                                <input type="date" id="filtro_fecha_fin" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Buscar</label>
                                <input type="text" id="filtro_buscar" class="form-control" placeholder="Folio o Banco...">
                            </div>
                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <button id="btnFiltrar" class="btn btn-info btn-block"><i class="fas fa-search"></i> Filtrar</button>
                            </div>
                        </div>

                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 5px;">
                            <table class="table table-bordered table-hover mb-0" id="tablaHistorial">
                                <thead class="bg-dark text-white sticky-top">
                                    <tr>
                                        <th>Folio</th>
                                        <th>Banco / Cuenta</th>
                                        <th>Período</th>
                                        <th>Fecha Conciliación</th>
                                        <th>Diferencia</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyHistorial">
                                    <tr><td colspan="7" class="text-center">Cargando historial...<\/td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Detalle Conciliación -->
<div class="modal fade" id="modalDetalle" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-eye"></i> Detalle de Conciliación</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalDetalleBody">
                Cargando...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .badge-conciliado { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
    .badge-pendiente { background-color: #fd7e14; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
    .badge-diferencia { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
    .badge-descuadre { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
    
    .table th { background-color: #2378e1 !important; color: white !important; }
    .table td { color: #000000 !important; vertical-align: middle; }
    .sticky-top { position: sticky; top: 0; z-index: 10; }
    
    .text-right { text-align: right !important; }
    .text-success { color: #28a745 !important; font-weight: bold; }
    .text-danger { color: #dc3545 !important; font-weight: bold; }
    
    .nav-tabs .nav-link.active {
        background-color: #083CAE;
        color: white;
        border-color: #083CAE;
    }
    .nav-tabs .nav-link {
        color: #083CAE;
        font-weight: bold;
    }
    
    /* ============================================ */
    /* ESTILOS PARA EL MODAL - Por encima de todo */
    /* ============================================ */
    .modal {
        z-index: 9999999 !important;
        background-color: rgba(0,0,0,0.5);
    }
    
    .modal-backdrop {
        z-index: 9999998 !important;
    }
    
    .modal-backdrop.show {
        opacity: 0.5;
    }
    
    .modal-open {
        overflow: hidden;
        padding-right: 0 !important;
    }
    
    .modal-open .modal {
        overflow-y: auto;
        overflow-x: hidden;
    }
    
    .modal-content {
        z-index: 9999999 !important;
        border: none;
        border-radius: 8px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.3);
    }
    
    .modal-dialog {
        z-index: 9999999 !important;
        margin-top: 50px;
    }
    
    .modal.fade .modal-dialog {
        transform: translate(0, 0);
    }
    
    .modal.show .modal-dialog {
        transform: translate(0, 0);
    }
    
    #modalDetalle .modal-header {
        background-color: #083CAE !important;
        border-radius: 8px 8px 0 0;
    }
    
    #modalDetalle .modal-header .close {
        color: white;
        opacity: 1;
        text-shadow: none;
    }
    
    #modalDetalle .modal-header .close:hover {
        opacity: 0.8;
    }
    
    #modalDetalle .modal-body {
        max-height: 70vh;
        overflow-y: auto;
        padding: 20px;
    }
    
    /* Asegurar que el modal esté por encima de la barra de navegación */
    .navbar, .header, .main-header, .sidebar, .navigation, .nav-tabs {
        z-index: 1000 !important;
    }
    
    /* SweetAlert también debe estar por encima */
    .swal2-container {
        z-index: 99999999 !important;
    }
    
    .swal2-popup {
        z-index: 99999999 !important;
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    console.log('Documento listo - Conciliación Bancaria');
    
    let movimientosSistema = [];
    let movimientosExtracto = [];
    let totalesSistema = { ingresos: 0, egresos: 0 };
    let totalesExtracto = { ingresos: 0, egresos: 0 };
    
    function formatCurrency(amount) {
        let num = parseFloat(amount) || 0;
        return '$' + num.toLocaleString('es-MX', { minimumFractionDigits: 2 });
    }
    
    function formatDate(dateString) {
        if (!dateString) return '-';
        if (dateString.includes('/')) {
            let parts = dateString.split('/');
            if (parts.length === 3) {
                return `${parts[2]}-${parts[1]}-${parts[0]}`;
            }
        }
        let date = new Date(dateString);
        if (!isNaN(date.getTime())) {
            return date.toISOString().split('T')[0];
        }
        return dateString;
    }
    
    function formatDateDisplay(dateString) {
        if (!dateString) return '-';
        let date = new Date(dateString);
        if (!isNaN(date.getTime())) {
            return date.toLocaleDateString('es-MX');
        }
        return dateString;
    }
    
    function actualizarResumen() {
        const saldoInicial = parseFloat($('#saldo_inicial').val()) || 0;
        const saldoFinalSistema = saldoInicial + totalesSistema.ingresos - totalesSistema.egresos;
        const saldoFinalExtracto = saldoInicial + totalesExtracto.ingresos - totalesExtracto.egresos;
        const diferencia = saldoFinalSistema - saldoFinalExtracto;
        
        $('#res_saldo_inicial_sistema').text(formatCurrency(saldoInicial));
        $('#res_saldo_inicial_extracto').text(formatCurrency(saldoInicial));
        $('#res_diferencia').text(formatCurrency(diferencia));
        $('#res_total_ingresos_sistema').text(formatCurrency(totalesSistema.ingresos));
        $('#res_total_egresos_sistema').text(formatCurrency(totalesSistema.egresos));
        $('#res_total_ingresos_extracto').text(formatCurrency(totalesExtracto.ingresos));
        $('#res_total_egresos_extracto').text(formatCurrency(totalesExtracto.egresos));
        
        if (diferencia === 0) {
            $('#res_estatus').html('<span class="badge badge-conciliado">Conciliado</span>');
        } else {
            $('#res_estatus').html('<span class="badge badge-diferencia">Descuadre</span>');
        }
    }
    
    function renderizarTablaSistema() {
        const tbody = $('#tbodySistema');
        tbody.empty();
        
        if (movimientosSistema.length === 0) {
            tbody.html('<tr><td colspan="7" class="text-center">No hay movimientos en el período seleccionado<\/td></tr>');
            return;
        }
        
        movimientosSistema.forEach(mov => {
            const row = $(`
                <tr class="fila-pendiente">
                    <td class="text-center"><input type="checkbox" class="checkSistema" data-id="${mov.id}" data-egreso="${mov.egreso || 0}" data-ingreso="${mov.ingreso || 0}"><\/td>
                    <td>${formatDateDisplay(mov.fecha)}<\/td>
                    <td>${mov.descripcion || '-'}<\/td>
                    <td>${mov.referencia || '-'}<\/td>
                    <td class="text-right text-danger">${mov.egreso > 0 ? formatCurrency(mov.egreso) : '$0.00'}<\/td>
                    <td class="text-right text-success">${mov.ingreso > 0 ? formatCurrency(mov.ingreso) : '$0.00'}<\/td>
                    <td>${mov.numero_transaccion || '-'}<\/td>
                 `);
            tbody.append(row);
        });
        
        $('#checkAllSistema').off('change').on('change', function() {
            $('.checkSistema').prop('checked', $(this).prop('checked'));
        });
    }
    
    function renderizarTablaExtracto() {
        const tbody = $('#tbodyExtracto');
        tbody.empty();
        
        if (movimientosExtracto.length === 0) {
            tbody.html('<tr><td colspan="7" class="text-center">No hay movimientos en el extracto<\/td></tr>');
            return;
        }
        
        movimientosExtracto.forEach(mov => {
            const row = $(`
                <tr class="fila-pendiente">
                    <td class="text-center"><input type="checkbox" class="checkExtracto" data-id="${mov.id}" data-egreso="${mov.egreso || 0}" data-ingreso="${mov.ingreso || 0}"><\/td>
                    <td>${formatDateDisplay(mov.fecha)}<\/td>
                    <td>${mov.descripcion || '-'}<\/td>
                    <td>${mov.referencia || '-'}<\/td>
                    <td class="text-right text-danger">${mov.egreso > 0 ? formatCurrency(mov.egreso) : '$0.00'}<\/td>
                    <td class="text-right text-success">${mov.ingreso > 0 ? formatCurrency(mov.ingreso) : '$0.00'}<\/td>
                    <td>${mov.numero_transaccion || '-'}<\/td>
                 `);
            tbody.append(row);
        });
        
        $('#checkAllExtracto').off('change').on('change', function() {
            $('.checkExtracto').prop('checked', $(this).prop('checked'));
        });
    }
    
    // Cargar movimientos del sistema
    $('#btnCargarSistema').on('click', async function() {
        const cuentaId = $('#cuenta_id').val();
        const fechaInicio = $('#fecha_inicio').val();
        const fechaFin = $('#fecha_fin').val();
        
        if (!cuentaId) {
            Swal.fire('Error', 'Seleccione una cuenta bancaria', 'error');
            return;
        }
        
        Swal.fire({ title: 'Cargando...', text: 'Obteniendo movimientos', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
        
        try {
            const response = await fetch(`/admin/conciliacion/movimientos?cuenta_id=${cuentaId}&fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}`);
            const result = await response.json();
            
            if (result.success) {
                movimientosSistema = result.data || [];
                totalesSistema.ingresos = result.total_ingresos || 0;
                totalesSistema.egresos = result.total_egresos || 0;
                
                renderizarTablaSistema();
                $('#panelExcel').show();
                $('#tablasConciliacion').show();
                actualizarResumen();
                
                Swal.fire('Éxito', `${movimientosSistema.length} movimientos cargados`, 'success');
            } else {
                Swal.fire('Error', result.message, 'error');
            }
        } catch (error) {
            Swal.fire('Error', 'Error al cargar movimientos', 'error');
        }
    });
    
    // Descargar plantilla
    $('#btnDescargarPlantilla').on('click', function() {
        window.location.href = '/admin/conciliacion/plantilla';
    });
    
    // Subir Excel
    $('#btnSubirExcel').on('click', async function() {
        const fileInput = document.getElementById('archivo_excel');
        const file = fileInput.files[0];
        
        if (!file) {
            Swal.fire('Error', 'Seleccione un archivo Excel', 'error');
            return;
        }
        
        const formData = new FormData();
        formData.append('archivo_excel', file);
        formData.append('cuenta_id', $('#cuenta_id').val());
        formData.append('fecha_inicio', $('#fecha_inicio').val());
        formData.append('fecha_fin', $('#fecha_fin').val());
        
        Swal.fire({ title: 'Procesando...', text: 'Leyendo archivo', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
        
        try {
            const response = await fetch('/admin/conciliacion/upload', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            });
            const result = await response.json();
            
            if (result.success) {
                movimientosExtracto = result.data || [];
                totalesExtracto.ingresos = result.total_ingresos || 0;
                totalesExtracto.egresos = result.total_egresos || 0;
                
                renderizarTablaExtracto();
                actualizarResumen();
                
                $('#resumenExtracto').html(`
                    <p><strong>Total movimientos:</strong> ${result.total_movimientos}</p>
                    <p><strong>Total Ingresos:</strong> ${formatCurrency(result.total_ingresos)}</p>
                    <p><strong>Total Egresos:</strong> ${formatCurrency(result.total_egresos)}</p>
                `);
                
                Swal.fire('Éxito', `${result.total_movimientos} movimientos del extracto cargados`, 'success');
            } else {
                Swal.fire('Error', result.message, 'error');
            }
        } catch (error) {
            Swal.fire('Error', 'Error al procesar el archivo', 'error');
        }
    });
    
    // Guardar conciliación
    $('#btnGuardarConciliacion').on('click', async function() {
        const cuentaId = $('#cuenta_id').val();
        if (!cuentaId) {
            Swal.fire('Error', 'Seleccione una cuenta bancaria', 'error');
            return;
        }
        
        const saldoInicial = parseFloat($('#saldo_inicial').val()) || 0;
        const saldoFinalSistema = saldoInicial + totalesSistema.ingresos - totalesSistema.egresos;
        const saldoFinalExtracto = saldoInicial + totalesExtracto.ingresos - totalesExtracto.egresos;
        const diferencia = saldoFinalSistema - saldoFinalExtracto;
        
        const movimientosConciliados = [];
        
        $('.checkSistema:checked').each(function() {
            const row = $(this).closest('tr');
            const fechaRaw = row.find('td:eq(1)').text();
            movimientosConciliados.push({
                origen: 'Sistema',
                fecha: formatDate(fechaRaw),
                descripcion: row.find('td:eq(2)').text(),
                referencia: row.find('td:eq(3)').text(),
                egreso: parseFloat($(this).data('egreso')) || 0,
                ingreso: parseFloat($(this).data('ingreso')) || 0,
                numero_transaccion: row.find('td:eq(6)').text(),
                conciliado: true
            });
        });
        
        $('.checkExtracto:checked').each(function() {
            const row = $(this).closest('tr');
            const fechaRaw = row.find('td:eq(1)').text();
            movimientosConciliados.push({
                origen: 'Extracto',
                fecha: formatDate(fechaRaw),
                descripcion: row.find('td:eq(2)').text(),
                referencia: row.find('td:eq(3)').text(),
                egreso: parseFloat($(this).data('egreso')) || 0,
                ingreso: parseFloat($(this).data('ingreso')) || 0,
                numero_transaccion: row.find('td:eq(6)').text(),
                conciliado: true
            });
        });
        
        const data = {
            cuenta_id: cuentaId,
            fecha_inicio: $('#fecha_inicio').val(),
            fecha_fin: $('#fecha_fin').val(),
            saldo_inicial_sistema: saldoInicial,
            saldo_inicial_extracto: saldoInicial,
            total_ingresos_sistema: totalesSistema.ingresos,
            total_egresos_sistema: totalesSistema.egresos,
            total_ingresos_extracto: totalesExtracto.ingresos,
            total_egresos_extracto: totalesExtracto.egresos,
            saldo_final_sistema: saldoFinalSistema,
            saldo_final_extracto: saldoFinalExtracto,
            diferencia: diferencia,
            observaciones: $('#observaciones').val(),
            movimientos_conciliados: JSON.stringify(movimientosConciliados)
        };
        
        Swal.fire({ title: 'Guardando...', text: 'Procesando conciliación', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
        
        try {
            const response = await fetch('/admin/conciliacion/guardar', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            
            if (result.success) {
                Swal.fire('Éxito', `Conciliación ${result.folio} guardada exitosamente`, 'success');
                setTimeout(() => window.location.reload(), 2000);
            } else {
                Swal.fire('Error', result.message, 'error');
            }
        } catch (error) {
            Swal.fire('Error', 'Error al guardar la conciliación', 'error');
        }
    });
    
    // ============================================
    // FUNCIONES DEL HISTORIAL
    // ============================================
    
    function cargarHistorial() {
        const fechaInicio = $('#filtro_fecha_inicio').val();
        const fechaFin = $('#filtro_fecha_fin').val();
        const buscar = $('#filtro_buscar').val();
        
        let url = '/admin/conciliacion/lista';
        let params = [];
        if (fechaInicio) params.push(`fecha_inicio=${fechaInicio}`);
        if (fechaFin) params.push(`fecha_fin=${fechaFin}`);
        if (buscar) params.push(`buscar=${encodeURIComponent(buscar)}`);
        if (params.length) url += '?' + params.join('&');
        
        fetch(url)
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    renderizarHistorial(result.data);
                } else {
                    $('#tbodyHistorial').html('<td><td colspan="7" class="text-center text-danger">Error al cargar historial<\/td></tr>');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                $('#tbodyHistorial').html('<td><td colspan="7" class="text-center text-danger">Error de conexión<\/td></tr>');
            });
    }
    
    function renderizarHistorial(data) {
        const tbody = $('#tbodyHistorial');
        tbody.empty();
        
        if (!data || data.length === 0) {
            tbody.html('<tr><td colspan="7" class="text-center">No hay conciliaciones registradas<\/td></tr>');
            return;
        }
        
        data.forEach(item => {
            const estatusClass = item.estatus === 'Conciliado' ? 'badge-conciliado' : 'badge-descuadre';
            const diferencia = parseFloat(item.diferencia) || 0;
            
            const row = $(`
                <tr>
                    <td><strong>${item.folio}</strong><\/td>
                    <td>${item.banco}<br><small class="text-muted">${item.numero_cuenta}</small><\/td>
                    <td>${formatDateDisplay(item.periodo_inicio)} - ${formatDateDisplay(item.periodo_fin)}<\/td>
                    <td>${formatDateDisplay(item.fecha_conciliacion)}<\/td>
                    <td class="${diferencia !== 0 ? 'text-danger' : 'text-success'}">${formatCurrency(diferencia)}<\/td>
                    <td><span class="badge ${estatusClass}">${item.estatus}</span><\/td>
                    <td>
                        <button class="btn btn-sm btn-info btn-ver-detalle" data-id="${item.id}">
                            <i class="fas fa-eye"></i> Ver
                        </button>
                        <button class="btn btn-sm btn-danger btn-eliminar" data-id="${item.id}" data-folio="${item.folio}">
                            <i class="fas fa-trash"></i>
                        </button>
                    <\/td>
                 `);
            tbody.append(row);
        });
        
        $('.btn-ver-detalle').on('click', function() {
            const id = $(this).data('id');
            verDetalleConciliacion(id);
        });
        
        $('.btn-eliminar').on('click', function() {
            const id = $(this).data('id');
            const folio = $(this).data('folio');
            eliminarConciliacion(id, folio);
        });
    }
    
    function verDetalleConciliacion(id) {
        Swal.fire({ title: 'Cargando...', text: 'Obteniendo detalles', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
        
        fetch(`/admin/conciliacion/detalle/${id}`)
            .then(response => response.json())
            .then(result => {
                Swal.close();
                if (result.success) {
                    mostrarModalDetalle(result.conciliacion, result.detalle);
                } else {
                    Swal.fire('Error', 'No se pudo cargar el detalle', 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Error de conexión', 'error');
            });
    }
    
    function mostrarModalDetalle(conciliacion, detalle) {
        let html = `
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Folio:</strong> ${conciliacion.folio}</p>
                    <p><strong>Período:</strong> ${formatDateDisplay(conciliacion.periodo_inicio)} - ${formatDateDisplay(conciliacion.periodo_fin)}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Fecha Conciliación:</strong> ${formatDateDisplay(conciliacion.fecha_conciliacion)}</p>
                    <p><strong>Estatus:</strong> <span class="badge ${conciliacion.estatus === 'Conciliado' ? 'badge-conciliado' : 'badge-descuadre'}">${conciliacion.estatus}</span></p>
                    <p><strong>Diferencia:</strong> ${formatCurrency(conciliacion.diferencia)}</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h6>Sistema</h6>
                    <p>Saldo Inicial: ${formatCurrency(conciliacion.saldo_inicial_sistema)}</p>
                    <p>Total Ingresos: ${formatCurrency(conciliacion.total_ingresos_sistema)}</p>
                    <p>Total Egresos: ${formatCurrency(conciliacion.total_egresos_sistema)}</p>
                    <p>Saldo Final: ${formatCurrency(conciliacion.saldo_final_sistema)}</p>
                </div>
                <div class="col-md-6">
                    <h6>Extracto</h6>
                    <p>Saldo Inicial: ${formatCurrency(conciliacion.saldo_inicial_extracto)}</p>
                    <p>Total Ingresos: ${formatCurrency(conciliacion.total_ingresos_extracto)}</p>
                    <p>Total Egresos: ${formatCurrency(conciliacion.total_egresos_extracto)}</p>
                    <p>Saldo Final: ${formatCurrency(conciliacion.saldo_final_extracto)}</p>
                </div>
            </div>
            ${conciliacion.observaciones ? `<hr><p><strong>Observaciones:</strong> ${conciliacion.observaciones}</p>` : ''}
        `;
        
        if (detalle && detalle.length > 0) {
            html += `<hr><h6>Movimientos Conciliados</h6>
            <div class="table-responsive" style="max-height: 300px;">
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr><th>Origen</th><th>Fecha</th><th>Descripción</th><th>Egreso</th><th>Ingreso</th><th>Estatus</th></tr>
                    </thead>
                    <tbody>`;
            detalle.forEach(d => {
                html += `<tr>
                    <td>${d.origen}<\/td>
                    <td>${formatDateDisplay(d.fecha)}<\/td>
                    <td>${d.descripcion || '-'}<\/td>
                    <td class="text-danger">${formatCurrency(d.egreso)}<\/td>
                    <td class="text-success">${formatCurrency(d.ingreso)}<\/td>
                    <td>${d.estatus}<\/td>
                </tr>`;
            });
            html += `</tbody>赶</div>`;
        }
        
        $('#modalDetalleBody').html(html);
        
        // Forzar el modal a mostrarse correctamente por encima de todo
        $('#modalDetalle').modal({
            backdrop: 'static',
            keyboard: true,
            show: true
        });
        
        // Asegurar que el modal esté por encima de todo
        $('.modal').css('z-index', '9999999');
        $('.modal-backdrop').css('z-index', '9999998');
        $('body').addClass('modal-open');
    }
    
    function eliminarConciliacion(id, folio) {
        Swal.fire({
            title: '¿Eliminar conciliación?',
            text: `¿Está seguro de eliminar la conciliación ${folio}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Eliminando...', text: 'Procesando', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
                
                fetch(`/admin/conciliacion/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        Swal.fire('Eliminado', 'Conciliación eliminada correctamente', 'success');
                        cargarHistorial();
                    } else {
                        Swal.fire('Error', result.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'Error al eliminar', 'error');
                });
            }
        });
    }
    
    // Eventos del historial
    $('#btnFiltrar').on('click', function() {
        cargarHistorial();
    });
    
    // Cargar historial al abrir el tab
    $('a[href="#historial"]').on('shown.bs.tab', function() {
        cargarHistorial();
    });
    
    // Filtros automáticos
    $('#filtro_fecha_inicio, #filtro_fecha_fin, #filtro_buscar').on('change keyup', function() {
        cargarHistorial();
    });
});
</script>
@endsection